<?php

namespace App\Http\Controllers;

use App\Building;
use App\BuildingRent;
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
use DB;

class BuildingRentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('ability:super-admin,list-buildings-rent', ['only' => ['index']]);
        $this->middleware('ability:super-admin,view-building-rent', ['only' => ['show']]);
        $this->middleware('ability:super-admin,add-building-rent', ['only' => ['add', 'store']]);
        $this->middleware('ability:super-admin,edit-building-rent', ['only' => ['edit', 'update']]);
        $this->middleware('ability:super-admin,delete-building-rent', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "Rent List";
        $wards = Ward::orderBy('ward', 'asc')->pluck('ward', 'ward')->all();
        $taxStatuses = TaxStsCode::pluck('name', 'value');
        $yesNo = YesNo::pluck('name', 'value');

        return view('buildings-rent.index', compact('pageTitle', 'wards', 'taxStatuses', 'yesNo'));
    }

    public function getData(Request $request)
    {
        $buildingData = BuildingRent::select('*');

        return Datatables::of($buildingData)
            ->filter(function ($query) use ($request) {
                if ($request->bin) {
                    $query->where('bin', $request->bin);
                }

                if ($request->ward) {
                    $query->where('ward', $request->ward);
                }

                if ($request->houseno) {
                    $query->where('houseno','ilike', '%'.trim($request->houseno).'%');
                }

                if ($request->hownername) {
                    $query->where('hownername', 'ilike', '%'.trim($request->hownername).'%');
                }
                if ($request->roadname) {
                    $query->where('roadname', 'ilike', '%'.trim($request->roadname).'%');
                }
                if ($request->rentername) {
                    $query->where('rentername', 'ilike', '%'.trim($request->rentername).'%');
                }
            })
            ->addColumn('action', function ($model) {
                $content = \Form::open(['method' => 'DELETE', 'route' => ['buildings-rent.destroy', $model->id]]);

                if (Auth::user()->ability('super-admin', 'edit-building-rent')) {
                    $content .= '<a title="Edit" href="' . action("BuildingRentController@edit", [$model->id]) . '" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></a> ';
                }

                if (Auth::user()->ability('super-admin', 'view-building-rent')) {
                    $content .= '<a title="Detail" href="' . action("BuildingRentController@show", [$model->id]) . '" class="btn btn-info btn-xs"><i class="fa fa-list"></i></a> ';
                }

                if (Auth::user()->ability('super-admin', 'delete-building-rent')) {
                    $content .= '<button title="Delete" type="submit" class="btn btn-info btn-xs" onclick="return confirm(\'Are you sure?\')">&nbsp;<i class="fa fa-trash"></i>&nbsp;</button> ';
                }

                if (Auth::user()->ability('super-admin', 'view-map')) {
                    $content .= '<a title="Map" href="'.action("MapsController@index", ['layer'=>'bldg_rent_tax','field'=>'id','val'=>$model->id]).'" class="btn btn-info btn-xs"><i class="fa fa-map-marker"></i></a> ';
                }

                $content .= \Form::close();
                return $content;
            })
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $pageTitle = "Add Rent";
        $wards = Ward::orderBy('ward')->pluck('ward', 'ward');
        $streets = Street::orderBy('strtcd')->pluck('strtcd', 'strtcd');
        $buildingUses = BuildingUse::pluck('name', 'value');
        $constructionTypes = BuildingConstr::pluck('name', 'value');
        $taxStatuses = TaxStsCode::pluck('name', 'value');
        $yesNo = YesNo::pluck('name', 'value');

        return view('buildings-rent.add', compact('pageTitle', 'wards', 'streets', 'buildingUses', 'constructionTypes', 'taxStatuses', 'yesNo'));
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
            'length' => 'numeric',
            'width' => 'numeric',
            'area' => 'numeric',
        ]);
        $building = Building::where('bin', $request->bin)->first();
        $centroid = DB::select(DB::raw("SELECT (ST_AsText(st_centroid(st_union(geom)))) AS central_point FROM bldg WHERE bin = '$request->bin'"));
        $buildingRent = new BuildingRent();
        $buildingRent->ward = $request->ward ? $request->ward : null;
        $buildingRent->roadname = $request->roadname ? $request->roadname : null;
        $buildingRent->houseno = $request->houseno ? $request->roadname : null;
        $buildingRent->bin = $request->bin ? $request->bin : null;
        $buildingRent->taxpayercode = $request->taxpayercode ? $request->taxpayercode : null;
        $buildingRent->hownername = $request->hownername ? $request->hownername : null;
        $buildingRent->hownernumber = $request->hownernumber ? $request->hownernumber : null;
        $buildingRent->howneremail = $request->howneremail ? $request->howneremail : null;
        $buildingRent->housetype = $request->housetype ? $request->housetype : null;
        $buildingRent->locatedat = $request->locatedat ? $request->locatedat : null;
        $buildingRent->length = $request->length ? $request->length : null;
        $buildingRent->width = $request->width ? $request->width : null;
        $buildingRent->area = $request->area ? $request->area : null;
        $buildingRent->rentername = $request->rentername ? $request->rentername : null;
        $buildingRent->rentpurpose = $request->rentpurpose ? $request->rentpurpose : null;
        $buildingRent->rentstart = $request->rentstart ? $request->rentstart : null;
        $buildingRent->rentend = $request->rentend ? $request->rentend : null;
        $buildingRent->monthlyrent = $request->monthlyrent ? $request->monthlyrent : null;
        $buildingRent->rentaxresponsible = $request->rentaxresponsible ? $request->rentaxresponsible : null;
        $buildingRent->rentincreseperyear = $request->rentincreseperyear ? $request->rentincreseperyear : null;
        $buildingRent->rentmobilenumber = $request->rentmobilenumber ? $request->rentmobilenumber : null;
        $buildingRent->remarks = $request->remarks ? $request->remarks : null;
        $buildingRent->geom = DB::raw("ST_GeomFromText('".$centroid[0]->central_point."', 4326)");    
        $buildingRent->save();

        Flash::success('Rent added successfully');
        return redirect()->action('BuildingRentController@add', ['bin' =>  $buildingRent->bin, 'ward' =>  $buildingRent->ward]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $building_business = BuildingRent::find($id);

        if ($building_business) {
            $pageTitle = "Rent Details";

            return view('buildings-rent.show', compact('pageTitle', 'building_business'));
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
        $buildingRent = BuildingRent::find($id);
        $wards = Ward::orderBy('ward', 'asc')->pluck('ward', 'ward')->all();
        if ($buildingRent) {
            $pageTitle = "Edit Rent";
            return view('buildings-rent.edit', compact('pageTitle', 'buildingRent', 'wards'));
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
        $buildingRent = BuildingRent::find($id);
        if ($buildingRent) {
            $this->validate($request, [
            'bin' => 'required',
            'length' => 'numeric',
            'width' => 'numeric',
            'area' => 'numeric',
        ]);
        $building = Building::where('bin', $request->bin)->first();
        $centroid = DB::select(DB::raw("SELECT (ST_AsText(st_centroid(st_union(geom)))) AS central_point FROM bldg WHERE bin = '$request->bin'"));
        
        $buildingRent->ward = $request->ward ? $request->ward : null;
        $buildingRent->roadname = $request->roadname ? $request->roadname : null;
        $buildingRent->houseno = $request->houseno ? $request->roadname : null;
        $buildingRent->bin = $request->bin ? $request->bin : null;
        $buildingRent->taxpayercode = $request->taxpayercode ? $request->taxpayercode : null;
        $buildingRent->hownername = $request->hownername ? $request->hownername : null;
        $buildingRent->hownernumber = $request->hownernumber ? $request->hownernumber : null;
        $buildingRent->howneremail = $request->howneremail ? $request->howneremail : null;
        $buildingRent->housetype = $request->housetype ? $request->housetype : null;
        $buildingRent->locatedat = $request->locatedat ? $request->locatedat : null;
        $buildingRent->length = $request->length ? $request->length : null;
        $buildingRent->width = $request->width ? $request->width : null;
        $buildingRent->area = $request->area ? $request->area : null;
        $buildingRent->rentername = $request->rentername ? $request->rentername : null;
        $buildingRent->rentpurpose = $request->rentpurpose ? $request->rentpurpose : null;
        $buildingRent->rentstart = $request->rentstart ? $request->rentstart : null;
        $buildingRent->rentend = $request->rentend ? $request->rentend : null;
        $buildingRent->monthlyrent = $request->monthlyrent ? $request->monthlyrent : null;
        $buildingRent->rentaxresponsible = $request->rentaxresponsible ? $request->rentaxresponsible : null;
        $buildingRent->rentincreseperyear = $request->rentincreseperyear ? $request->rentincreseperyear : null;
        $buildingRent->rentmobilenumber = $request->rentmobilenumber ? $request->rentmobilenumber : null;
        $buildingRent->remarks = $request->remarks ? $request->remarks : null;
        $buildingRent->geom = DB::raw("ST_GeomFromText('".$centroid[0]->central_point."', 4326)");    
        $buildingRent->save();


        Flash::success('Rent updated successfully');
        return redirect('buildings-rent');
        } else {
            Flash::error('Failed to update rent');
            return redirect('buildings-rent');
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
        $buildingRent = BuildingRent::find($id);

        if ($buildingRent) {
           
            $buildingRent->delete();

            Flash::success('Rent deleted successfully');
            return redirect('buildings-rent');
        } else {
            Flash::error('Failed to delete rent');
            return redirect('buildings-rent');
        }
    }

    public function export()
    {
        $searchData = isset($_GET['searchData']) ? $_GET['searchData'] : null;
        $bin = isset($_GET['bin']) ? $_GET['bin'] : null;
        $rentername = isset($_GET['rentername']) ? $_GET['rentername'] : null;
        $ward = isset($_GET['ward']) ? $_GET['ward'] : null;
        $roadname = isset($_GET['roadname']) ? $_GET['roadname'] : null;
        $houseno = isset($_GET['houseno']) ? $_GET['houseno'] : null;
        $hownername = isset($_GET['hownername']) ? $_GET['hownername'] : null;
        $columns = ['bin','ward','roadname','houseno','taxpayercode','hownername','hownernumber','howneremail','housetype','locatedat','length','width','area','rentername','rentpurpose','rentstart','rentend','monthlyrent','rentaxresponsible','rentincreseperyear','rentmobilenumber','remarks'];

        $query = BuildingRent::select('bin','ward','roadname','houseno','taxpayercode','hownername','hownernumber','howneremail','housetype','locatedat','length','width','area','rentername','rentpurpose','rentstart','rentend','monthlyrent','rentaxresponsible','rentincreseperyear','rentmobilenumber','remarks');

        if (!empty($searchData)) {
            foreach ($columns as $column) {
                $query->orWhereRaw("lower(cast(" . $column . " AS varchar)) LIKE lower('%" . $searchData . "%')");
                //casting to varchar LOWER doesn't work on int, double precision
            }
        }

        if (!empty($bin)) {
            $query->where('bin', $bin);
        }

        if (!empty($rentername)) {
           $query->where('rentername', 'ilike', '%'.trim($rentername).'%');
        }

        if (!empty($ward)) {
            $query->where('ward', $ward);
        }
        
        if (!empty($roadname)) {
            $query->where('roadname','ilike', '%'.trim($roadname).'%');
        }
        
        if (!empty($hownername)) {
            $query->where('hownername', 'ilike', '%'.trim($hownername).'%');
        }
        
        if (!empty($houseno)) {
            $query->where('houseno', 'ilike', '%'.trim($houseno).'%');
        }

        $style = (new StyleBuilder())
            ->setFontBold()
            ->setFontSize(13)
            ->setBackgroundColor(Color::rgb(228, 228, 228))
            ->build();

        $writer = WriterFactory::create(Type::CSV);
        $writer->openToBrowser('Buildings Rent.CSV')
            ->addRowWithStyle($columns, $style); //Top row of excel

        $query->chunk(5000, function ($buildings) use ($writer) {
            
             
            foreach($buildings as $building) {
                $values = [];
                $values[] = $building->bin;
                $values[] = $building->ward;
                $values[] = $building->roadname;
                $values[] = $building->houseno;
                $values[] = $building->taxpayercode;
                $values[] = $building->hownername;
                $values[] = $building->hownernumber;
                $values[] = $building->howneremail;
                $values[] = $building->housetype;
                $values[] = $building->locatedat;
                $values[] = $building->length;
                $values[] = $building->width;
                $values[] = $building->area;
                $values[] = $building->rentername;
                $values[] = $building->rentpurpose;
                $values[] = $building->rentstart;
                $values[] = $building->rentend;
                $values[] = $building->monthlyrent;
                $values[] = $building->rentaxresponsible;
                $values[] = $building->rentincreseperyear;
                $values[] = $building->rentmobilenumber;
                $values[] = $building->remarks;
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

    public function getRentDetails(Request $request) 

    {
        if(BuildingRent::where('bin', $request->bin)->exists()){
            $building_rent = BuildingRent::where('bin', $request->bin)->first();
            return response()->json($building_rent);
        } else {
            $building_rent = Building::where('bin', $request->bin)->first();
            return response()->json($building_rent);
        }
    }


  
}
