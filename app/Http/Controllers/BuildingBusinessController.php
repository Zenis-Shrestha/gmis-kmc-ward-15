<?php

namespace App\Http\Controllers;

use App\BuildingRent;
use App\Building;
use App\BuildingBusiness;
use App\Street;
use App\Ward;
use App\BuildingUse;
use App\BuildingConstr;
use App\TaxStsCode;
use App\YesNo;
use Box\Spout\Common\Type;
use Box\Spout\Writer\Style\Color;
use Box\Spout\Writer\Style\StyleBuilder;
use Box\Spout\Writer\WriterFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;
use Datatables;
use File;
use App\BusinessTaxRate;
use DB;
use PDF;

class BuildingBusinessController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('ability:super-admin,list-buildings-business', ['only' => ['index']]);
        $this->middleware('ability:super-admin,view-building-business', ['only' => ['show']]);
        $this->middleware('ability:super-admin,add-building-business', ['only' => ['add', 'store']]);
        $this->middleware('ability:super-admin,edit-building-business', ['only' => ['edit', 'update']]);
        $this->middleware('ability:super-admin,delete-building-business', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "Business List";
        $wards = Ward::select('ward')->distinct()->orderBy('ward', 'asc')->pluck('ward', 'ward')->all();
        $oldinternalnumber = BuildingBusiness::select('oldinternalnumber')->distinct()->pluck('oldinternalnumber', 'oldinternalnumber')->all();
        $businessMainTypes = BusinessTaxRate::pluck('businessmaintype','businessmaintype')->toArray();
        $taxStatuses = TaxStsCode::pluck('name', 'value');
        $yesNo = YesNo::pluck('name', 'value');
        $registration_status = BuildingBusiness::selectRaw("CASE WHEN registration_status THEN 'Yes' ELSE 'No' END AS registration_status_label, registration_status")
                ->whereNotNull('registration_status')
                ->groupBy('registration_status')
                ->orderBy('registration_status', 'asc')
                ->pluck('registration_status_label', 'registration_status');


        return view('buildings-business.index', compact('pageTitle', 'wards', 'oldinternalnumber', 'taxStatuses', 'yesNo', 'registration_status','businessMainTypes'));
    }

    public function getData(Request $request)
    {
        
        DB::enableQueryLog();
        

        $buildingData = BuildingBusiness::select(

                            "*"
                        );
        return Datatables::of($buildingData)
            ->filter(function ($query) use ($request) {
                if ($request->bin) {
                    $query->where('bin', $request->bin);
                }

                if ($request->ward) {
                    $query->where('ward', $request->ward);
                }

                if (trim($request->houseno)) {
                    $query->where('houseno', trim($request->houseno));
                }

                 if ($request->taxcode) {
                    $query->where('taxcode', trim($request->taxcode));
                } 
                if ($request->roadname) {
                    $query->where('roadname', trim($request->roadname));
                } 
                if ($request->businessname) {
                    $query->where('businessname', 'ilike', '%'.trim($request->businessname).'%');
                }
                if ($request->taxpayername) {
                    $query->where('taxpayername','ilike', '%'. trim($request->taxpayername).'%');
                } 
                
                if ($request->houseownername) {
                    $query->where('houseownername', 'ilike', '%'.trim($request->houseownername).'%');
                } 
                
                if ($request->oldinternalnumber) {
                    $query->where('oldinternalnumber', 'ilike', '%'.trim($request->oldinternalnumber).'%');
                } 

                if ($request->btxsts_select) {
                   $btxsts_select = $request->btxsts_select;
                   
                    $query->whereRaw(DB::raw("(2079 - (RIGHT(taxlastdate,4))::integer)=$btxsts_select"));
                }
                if ($request->registration) {
                   
                   
                    $query->where('registration', 'ilike', '%'.trim($request->registration).'%');
                }
               if ($request->registration_status) {
                
                    $query->where('registration_status', $request->registration_status);
                    dd($query);
                }

               
                if ($request->businesowner) {
                   
                   
                    $query->where('businesowner', 'ilike', '%'.trim($request->businesowner).'%');
                }
                if ($request->businessmaintype) {
                   
                   
                    $query->where('businessmaintype', 'ilike', '%'.trim($request->businessmaintype).'%');
                }
                if ($request->businesstype) {
                   
                   
                    $query->where('businesstype', 'ilike', '%'.trim($request->businesstype).'%');
                }
            })
            ->addColumn('action', function ($model) {
                $content = \Form::open(['method' => 'DELETE', 'route' => ['buildings-business.destroy', $model->id]]);

                if (Auth::user()->ability('super-admin', 'edit-building-business')) {
                    $content .= '<a title="Edit" href="' . action("BuildingBusinessController@edit", [$model->id]) . '" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></a> ';
                }

                if (Auth::user()->ability('super-admin', 'view-building-business')) {
                    $content .= '<a title="Detail" href="' . action("BuildingBusinessController@show", [$model->id]) . '" class="btn btn-info btn-xs"><i class="fa fa-list"></i></a> ';
                }

                if (Auth::user()->ability('super-admin', 'delete-building-business')) {
                    $content .= '<button title="Delete" type="submit" class="btn btn-info btn-xs" onclick="return confirm(\'Are you sure?\')">&nbsp;<i class="fa fa-trash"></i>&nbsp;</button> ';
                }

                if (Auth::user()->ability('super-admin', 'view-map')) {
                    $content .= '<a title="Map" href="'.action("MapsController@index", ['layer'=>'bldg_business_tax','field'=>'id','val'=>$model->id]).'" class="btn btn-info btn-xs"><i class="fa fa-map-marker"></i></a> ';
                }

                $content .= \Form::close();
                return $content;
            })
            ->make(true);
//            $query = DB::getQueryLog();
//dd($query);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        
        $pageTitle = "Add Building Business";
        $wards = Ward::orderBy('ward')->pluck('ward', 'ward');
        $streets = Street::orderBy('strtcd')->pluck('strtcd', 'strtcd');
        $buildingUses = BuildingUse::pluck('name', 'value');
        $constructionTypes = BuildingConstr::pluck('name', 'value');
        $taxStatuses = TaxStsCode::pluck('name', 'value');
        $yesNo = YesNo::pluck('name', 'value');
        //$bin = Building::distinct('bin')->pluck('bin','bin');
        $businessMainTypes = BusinessTaxRate::pluck('businessmaintype','businessmaintype')->toArray();

        return view('buildings-business.add', compact('pageTitle', 'wards', 'streets', 'buildingUses', 'constructionTypes', 'taxStatuses', 'yesNo', 'businessMainTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $this->validate($request, [
            'bin' => 'required',
        ]);
        $building = Building::where('bin', $request->bin)->first();
        $centroid = DB::select(DB::raw("SELECT (ST_AsText(st_centroid(st_union(geom)))) AS central_point FROM bldg WHERE bin = '$request->bin'"));
       
        $building_business = new BuildingBusiness();
       
        $building_business->bin = $request->bin ? $request->bin : null;
       
        $building_business->ward = $request->ward ? $request->ward : null;
        
        $building_business->roadname = $request->roadname ? $request->roadname : null;
        $building_business->houseno = $request->houseno ? $request->houseno : null;
        $building_business->houseownername = $request->houseownername ? $request->houseownername : null;
        $building_business->ownerphone = $request->ownerphone ? $request->ownerphone : null;
        $building_business->houseownermail = $request->houseownermail ? $request->houseownermail : null;
        $building_business->businesowner = $request->businesowner ? $request->businesowner : null;
        $building_business->businessname = $request->businessname ? $request->businessname : null;
        $building_business->businesstype = $request->businesstype ? $request->businesstype : null;
        $building_business->category = $request->category ? $request->category : null;
        $building_business->businessoprdate = $request->businessoprdate ? $request->businessoprdate : null;
        $building_business->registration = $request->registration ? $request->registration : null;
        $building_business->oldinternalnumber = $request->oldinternalnumber ? $request->oldinternalnumber : null;
        $building_business->taxlastdate = $request->taxlastdate ? $request->taxlastdate : null;
        $building_business->rent = $request->rent ? $request->rent : null;
        $building_business->rentresponsible = $request->rentresponsible ? $request->rentresponsible : null; 
        $building_business->businessownermobile = $request->businessownermobile ? $request->businessownermobile : null;
        $building_business->email = $request->email ? $request->email : null;
        $building_business->remarks = $request->remarks ? $request->remarks : null;
      
        $building_business->registration_status = ($request->registration_status === "Yes") ? 'yes' : 'no';

        if($request->businesstype){
        $business_tax_rate = BusinessTaxRate::where('businesssubtype', $request->businesstype)->first();
        $building_business->business_tax_rates_id = $business_tax_rate->id ? $business_tax_rate->id : null;
        }
        $building_business->geom = DB::raw("ST_GeomFromText('".$centroid[0]->central_point."', 4326)");      
        $building_business->businessmaintype = $request->businessmaintype ? $request->businessmaintype : null;
        
        $building_business->save();
        
        Flash::success('Business added successfully');
        return redirect()->action('BuildingBusinessController@add', ['bin' =>  $building_business->bin, 'ward' =>  $building_business->ward]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $building_business = BuildingBusiness::find($id);
        

        if ($building_business) {
            $pageTitle = "Business Details";

            return view('buildings-business.show', compact('pageTitle', 'building_business'));
        } else {
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
     
        $wards = Ward::orderBy('ward')->pluck('ward', 'ward');
        $streets = Street::orderBy('strtcd')->pluck('strtcd', 'strtcd');
        $buildingUses = BuildingUse::pluck('name', 'value');
        $constructionTypes = BuildingConstr::pluck('name', 'value');
        $taxStatuses = TaxStsCode::pluck('name', 'value');
        $yesNo = YesNo::pluck('name', 'value');
        //$bin = Building::distinct('bin')->pluck('bin','bin');
        $businessMainTypes = BusinessTaxRate::pluck('businessmaintype','businessmaintype')->toArray();
        $buildingBusiness = BuildingBusiness::find($id);
        $bldgMainBusiness = BusinessTaxRate::find($buildingBusiness->business_tax_rates_id);
        
        if ($buildingBusiness) {
            $pageTitle = "Edit Business";
            return view('buildings-business.edit', compact('pageTitle', 'buildingBusiness', 'wards', 'streets', 'buildingUses', 'constructionTypes', 'taxStatuses', 'yesNo', 'businessMainTypes', 'bldgMainBusiness'));
        } else {
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $building_business = BuildingBusiness::find($id);
        if ($building_business) {
            $this->validate($request, [
                'bin' => 'required',
            ]);

            $building = Building::where('bin', $request->bin);
            $centroid = DB::select(DB::raw("SELECT (ST_AsText(st_centroid(st_union(geom)))) AS central_point FROM bldg WHERE bin = '$request->bin'"));

            $building_business->bin = $request->bin ? $request->bin : null;
            $building_business->ward = $request->ward ? $request->ward : null;
            $building_business->roadname = $request->roadname ? $request->roadname : null;
            $building_business->houseno = $request->houseno ? $request->houseno : null;
            $building_business->houseownername = $request->houseownername ? $request->houseownername : null;
            $building_business->ownerphone = $request->ownerphone ? $request->ownerphone : null;
            $building_business->houseownermail = $request->houseownermail ? $request->houseownermail : null;
            $building_business->businesowner = $request->businesowner ? $request->businesowner : null;
            $building_business->businessname = $request->businessname ? $request->businessname : null;
            $building_business->businesstype = $request->businesstype ? $request->businesstype : null;
            $building_business->category = $request->category ? $request->category : null;
            $building_business->businessoprdate = $request->businessoprdate ? $request->businessoprdate : null;
            $building_business->registration = $request->registration ? $request->registration : null;
            $building_business->oldinternalnumber = $request->oldinternalnumber ? $request->oldinternalnumber : null;
            $building_business->taxlastdate = $request->taxlastdate ? $request->taxlastdate : null;
            $building_business->rent = $request->rent ? $request->rent : null;
            $building_business->rentresponsible = $request->rentresponsible ? $request->rentresponsible : null; 
            $building_business->businessownermobile = $request->businessownermobile ? $request->businessownermobile : null;
            $building_business->email = $request->email ? $request->email : null;
            $building_business->remarks = $request->remarks ? $request->remarks : null;
            $building_business->registration_status = $request->registration_status ? $request->registration_status : null;
         
            $building_business->business_tax_rates_id = $request->business_tax_rates_id ? $request->business_tax_rates_id : null;
            $building_business->geom = DB::raw("ST_GeomFromText('".$centroid[0]->central_point."', 4326)");         
            $building_business->businessmaintype = $request->businessmaintype ? $request->businessmaintype : null;
            $building_business->save();

            Flash::success('Business updated successfully');
            return redirect('buildings-business');
        } else {
            Flash::error('Failed to update business');
            return redirect('buildings-business');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $buildingBusiness = BuildingBusiness::find($id);

        if ($buildingBusiness) {
        $buildingBusiness->delete();
        
            Flash::success('Business deleted successfully');
            return redirect('buildings-business');
        } else {
            Flash::error('Failed to delete business');
            return redirect('buildings-business');
        }
    }

    public function export()
    {
        
        $searchData = isset($_GET['searchData']) ? $_GET['searchData'] : null;
        $bin = isset($_GET['bin']) ? $_GET['bin'] : null;
        $businessname = isset($_GET['businessname']) ? $_GET['businessname'] : null;
        $ward = isset($_GET['ward']) ? $_GET['ward'] : null;
        $roadname = isset($_GET['roadname']) ? $_GET['roadname'] : null;
        $houseownername = isset($_GET['houseownername']) ? $_GET['houseownername'] : null;
        $houseno = isset($_GET['houseno']) ? $_GET['houseno'] : null;
        $btxsts_select = isset($_GET['btxsts_select']) ? $_GET['btxsts_select'] : null;
        $registration = isset($_GET['registration']) ? $_GET['registration'] : null;
        $registration_status = isset($_GET['registration_status']) ? $_GET['registration_status'] : null;
        $businessmaintype = isset($_GET['businessmaintype']) ? $_GET['businessmaintype'] : null;
        $businesstype = isset($_GET['businesstype']) ? $_GET['businesstype'] : null;
        $oldinternalnumber = isset($_GET['oldinternalnumber']) ? $_GET['oldinternalnumber'] : null;
        $columns = ['ward','roadname','houseno','bin','houseownername','ownerphone','houseownermail','businesowner','businessname','businesstype','category','businessoprdate','registration','registration_status','taxlastdate','oldinternalnumber','rent','rentresponsible','businessownermobile','email','remarks', 'businessmaintype'];

        $query = BuildingBusiness::select('ward','roadname','houseno','bin','houseownername','ownerphone','houseownermail','businesowner','businessname','businesstype','category','businessoprdate','registration','registration_status','taxlastdate','oldinternalnumber','rent','rentresponsible','businessownermobile','email','remarks','businessmaintype');

        if (!empty($searchData)) {
            foreach ($columns as $column) {
                $query->orWhereRaw("lower(cast(" . $column . " AS varchar)) LIKE lower('%" . $searchData . "%')");
                //casting to varchar LOWER doesn't work on int, double precision
            }
        }

        if (!empty($bin)) {
            $query->where('bin', $bin);
        }

        if (!empty($businessname)) {
            $query->where('businessname','ilike', '%'.trim($businessname).'%');
        }
        if (!empty($ward)) {
            $query->where('ward', $ward);
        }
        
        if (!empty($roadname)) {
            $query->where('roadname','ilike', '%'.trim($roadname).'%');
        }
        
        if (!empty($houseownername)) {
            $query->where('houseownername', 'ilike','%'.trim($houseownername).'%');
        }
        
        if (!empty($houseno)) {
            $query->where('houseno', 'ilike','%'.trim($houseno).'%');
        } 
        if (!empty($btxsts_select)) {
            $query->whereRaw(DB::raw("(2079 - (RIGHT(taxlastdate,4))::integer)=$btxsts_select"));
        } 
        if (!empty($registration)) {

            $query->where('registration', 'ilike', '%'.trim($registration).'%');
        }
        if (!empty($registration_status)) {

            $query->where('registration_status', ($registration_status));
        }
  
        if (!empty($businessmaintype)) {

            $query->where('businessmaintype', 'ilike', '%'.trim($businessmaintype).'%');
        }
        if (!empty($businesstype)) {

            $query->where('businesstype', 'ilike', '%'.trim($businesstype).'%');
        }
        if (!empty($oldinternalnumber)) {

            $query->where('oldinternalnumber', 'ilike', '%'.trim($oldinternalnumber).'%');
        }
        $style = (new StyleBuilder())
            ->setFontBold()
            ->setFontSize(13)
            ->setBackgroundColor(Color::rgb(228, 228, 228))
            ->build();

        $writer = WriterFactory::create(Type::CSV);
        $writer->openToBrowser('Buildings Business.CSV')
            ->addRowWithStyle($columns, $style); //Top row of excel

        $query->chunk(100, function ($buildings) use ($writer) {
           foreach($buildings as $building) {
            $values = [];
                             
            $values[] = $building->ward;
            $values[] = $building->roadname;
            $values[] = $building->houseno;
            $values[] = $building->bin;
            $values[] = $building->houseownername;
            $values[] = $building->ownerphone;
            $values[] = $building->houseownermail;
            $values[] = $building->businesowner;
            $values[] = $building->businessname;
            $values[] = $building->businesstype;
            $values[] = $building->category;
            $values[] = $building->businessoprdate;
            $values[] = $building->registration;
            $values[] = $building->registration_status?'yes':'no';
            $values[] = $building->taxlastdate;
            $values[] = $building->oldinternalnumber;
            $values[] = $building->rent;
            $values[] = $building->rentresponsible;
            $values[] = $building->businessownermobile;
            $values[] = $building->email;
            $values[] = $building->remarks;
            $values[] = $building->businessmaintype;
            $writer->addRow($values);

           }
        });

        $writer->close();
    }

    public function downloadPhoto($building_id) {
        $building = Building::find($building_id);
        if($building) {
            $filepath = storage_path('app/photos/' . $building->bin . '.JPG');
            if(File::exists($filepath)) {
                return response()->file($filepath);
            }
            else {
                abort(404);
            }
        }
        else {
            abort(404);
        }
    } 
    
   
    public function getRoad(){

        $query = Building::select('*');
        if (request()->search){
            $query->where('bin', '=', request()->search);
        }
        if (request()->road_code){
            $query->where('road_code','=',request()->road_code);
        }
        $total = $query->count();

        $limit = 10;
        if (request()->page) {
            $page  = request()->page;
        }
        else{
            $page=1;
        };
        $start_from = ($page-1) * $limit;

        $total_pages = ceil($total / $limit);
        if($page < $total_pages){
            $more = true;
        }
        else
        {
            $more = false;
        }
        $house_numbers = $query->offset($start_from)
            ->limit($limit)
            ->get();
        $json = [];
        foreach($house_numbers as $house_number)
        {
            $json[] = ['id'=>$house_number['bin'], 'text'=>$house_number['bin']];
        }

        return response()->json(['results' =>$json, 'pagination' => ['more' => $more] ]);

    } 
    
    public function getBusinessSubTypes(Request $request) {
       
        $businessSubTypes = BusinessTaxRate::where('businessmaintype','ilike',urldecode(Request()->businesstype))->get();
        $type = [];
        foreach ($businessSubTypes as $row) {
            $type[$row->id] = $row->businesssubtype;
        }
        echo json_encode($type);
        
    }

    public function getBusinessDetails(Request $request) 

    {
        if(BuildingBusiness::where('bin', $request->bin)->exists()){
            $building_business = BuildingBusiness::where('bin', $request->bin)->first();

        } else {
            $building_business = Building::where('bin', $request->bin)->first();
           
        }
        if ($request->has('ward')) {
            $building_business['ward'] = $building_business->ward;
        }
        
    
        return response()->json( $building_business);
      
  }

  public function businessTaxReportPdf(){

    $query = "SELECT w.ward, count(b.registration),
    COUNT(DISTINCT b.registration) filter (where btps.due_year = '0' AND due_year is not Null)  AS no_due,
    COUNT(DISTINCT b.registration) filter (where btps.due_year > '0'AND due_year is not Null)  AS due,
    COUNT(DISTINCT b.registration) filter (where due_year is Null)  AS no_data
    FROM wardpl w LEFT JOIN bldg_business_tax b ON b.ward = w.ward
    LEFT JOIN business_tax_payment_status btps
    ON b.registration= btps.registration
    GROUP BY w.ward
    ORDER BY w.ward ASC";
    $results_one = DB::select($query);
   

    $detailed_query = "SELECT w.ward, count(b.id),
    COUNT(DISTINCT b.id) filter (where btps.due_year = '0' AND due_year is not Null)  AS no_due,
    COUNT(DISTINCT b.id) filter (where btps.due_year = '1' AND due_year is not Null)  AS due_one,
    COUNT(DISTINCT b.id) filter (where btps.due_year = '2' AND due_year is not Null)  AS due_two,
    COUNT(DISTINCT b.id) filter (where btps.due_year = '3' AND due_year is not Null)  AS due_three,
    COUNT(DISTINCT b.id) filter (where btps.due_year = '4' AND due_year is not Null)  AS due_four,
    COUNT(DISTINCT b.id) filter (where btps.due_year >= '5' AND due_year is not Null)  AS due_five,
    COUNT(DISTINCT b.id) filter (where due_year is Null)  AS no_data
    FROM wardpl w LEFT JOIN bldg_business_tax b ON b.ward = w.ward
    LEFT JOIN business_tax_payment_status btps
    ON b.registration= btps.registration
    GROUP BY w.ward
    ORDER BY w.ward ASC";
    $results_two = DB::select($detailed_query);
       
     return PDF::loadView('buildings-business.business-report', compact("results_one", "results_two"))->inline('Business Tax Report.pdf');

          
    }
  
} 
