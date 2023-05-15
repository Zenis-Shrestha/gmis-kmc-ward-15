<?php

namespace App\Http\Controllers;

use App\Building;
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
use DataTables;
use File;
use Illuminate\Support\Facades\Validator;
use DOMDocument;
use DomXpath;
use DB;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class BuildingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('ability:super-admin,list-buildings', ['only' => ['index']]);
        $this->middleware('ability:super-admin,view-building', ['only' => ['show']]);
        $this->middleware('ability:super-admin,add-building', ['only' => ['add', 'store']]);
        $this->middleware('ability:super-admin,edit-building', ['only' => ['edit', 'update']]);
        $this->middleware('ability:super-admin,delete-building', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "Building List";
        $wards = Ward::orderBy('ward', 'asc')->pluck('ward', 'ward')->all();
        $taxStatuses = TaxStsCode::pluck('name', 'value');
        $yesNo = YesNo::pluck('name', 'value');
        $currentYear = "2080";
        $yearOfConstruction = DB::table('bldg')
                            ->select('yoc')
                            ->distinct()
                            ->whereBetween('yoc', [2060, $currentYear])
                            ->orderBy('yoc', 'desc')
                            ->pluck('yoc');
        

        return view('buildings.index', compact('pageTitle', 'wards', 'taxStatuses', 'yesNo','yearOfConstruction'));
    }

    public function getData(Request $request)
    {
        //$buildingData = Building::select('gid', 'bin', 'bldgcd', 'ward', 'tole', 'toilyn', 'btxsts', 'sngwoman', 'gt60yr', 'dsblppl')
        //                                ->with('toilynYesNo')
        //                                ->with('taxStsCode');

        
        $buildingData = DB::table('bldg')
        ->leftJoin('yes_no', 'bldg.toilyn', '=', 'yes_no.value')
        ->leftJoin('tax_status_code', 'bldg.btxsts', '=', 'tax_status_code.value')
        ->select('bldg.*', 'tax_status_code.name AS taxName', 'tax_status_code.value AS taxVal', 'yes_no.name AS ynName', 'yes_no.value AS ynVal');



        return Datatables::of($buildingData)
            ->filter(function ($query) use ($request) {
               
                if ($request->bin) {
                    $query->where('bin', $request->bin);
                }

                if ($request->ward) {
                    $query->where('ward', $request->ward);
                }
                
                if ($request->yoc) {
                   
                    $query->where('bldg.yoc', $request->yoc);
                  
                }

                if ($request->toilyn) {
                    $query->where('toilyn', $request->toilyn);
                }

                if ($request->btxsts || $request->btxsts == '0') {
                    $query->where('btxsts', $request->btxsts);
                    
                }

                if ($request->sngwoman) {
                    $query->where('sngwoman', '>', '0');
                }

                if ($request->gt60yr) {
                    $query->where('gt60yr', '>', '0');
                }

                if ($request->dsblppl) {
                    $query->where('dsblppl', '>', '0');
                }
                
            })
            ->addColumn('action', function ($model) {
                $content = \Form::open(['method' => 'DELETE', 'route' => ['buildings.destroy', $model->bin]]);

                if (Auth::user()->ability('super-admin', 'edit-building')) {
                    $content .= '<a title="Edit" href="' . action("BuildingController@edit", [$model->bin]) . '" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></a> ';
                }

                if (Auth::user()->ability('super-admin', 'view-building')) {
                    $content .= '<a title="Detail" href="' . action("BuildingController@show", [$model->bin]) . '" class="btn btn-info btn-xs"><i class="fa fa-list"></i></a> ';
                }

                if (Auth::user()->ability('super-admin', 'delete-building')) {
                    $content .= '<button title="Delete" type="submit" class="btn btn-info btn-xs" onclick="return confirm(\'Are you sure?\')">&nbsp;<i class="fa fa-trash"></i>&nbsp;</button> ';
                }

                if (Auth::user()->ability('super-admin', 'view-map')) {
                    $content .= '<a title="Map" href="'.action("MapsController@index", ['layer'=>'bldg','field'=>'bin','val'=>$model->bin]).'" class="btn btn-info btn-xs"><i class="fa fa-map-marker"></i></a> ';
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
        $pageTitle = "Add Building";
        $wards = Ward::orderBy('ward')->pluck('ward', 'ward');
        $streets = Street::orderBy('strtcd')->pluck('strtcd', 'strtcd');
        $buildingUses = BuildingUse::pluck('name', 'value');
        $constructionTypes = BuildingConstr::pluck('name', 'value');
        $taxStatuses = TaxStsCode::pluck('name', 'value');
        $yesNo = YesNo::pluck('name', 'value');

        return view('buildings.add', compact('pageTitle', 'wards', 'streets', 'buildingUses', 'constructionTypes', 'taxStatuses', 'yesNo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::extend('file_extension', function ($attribute, $value, $parameters, $validator) {
                if( !in_array( $value->getClientOriginalExtension(), $parameters ) ){
                return false;
            }
            else {
                return true;
            }
        }, 'File must be kml format');
        
        $this->validate($request, [
            'bin' => 'required|unique:bldg,bin',
            'yoc' => 'numeric',
            'flrcount' => 'numeric',
            'consttyp' => 'numeric',
            'toilyn' => 'numeric',
            'hhcount' => 'numeric',
            'hhpop' => 'numeric',
            'btxsts' => 'numeric',
            'flrar' => 'numeric',
            'bprmtno' => 'numeric',
            'haddrplt' => 'numeric',
            'haddr' => 'numeric',
            'bldguse'  => 'numeric',
            'sngwoman'  => 'numeric',
            'gt60yr' => 'numeric',
            'dsblppl' => 'numeric',
            'kml_file' => 'required|file_extension:kml',
            'house_new_photo' => 'required|image|mimes:png,jpg,jpeg'
        ]);

        $building = new Building();
        $building->bin = $request->bin ? $request->bin : null;
        $building->bldgcd = $request->bldgcd ? $request->bldgcd : null;
        $building->ward = $request->ward ? $request->ward : null;
        $building->tole = $request->tole ? $request->tole : null;
        $building->oldhno = $request->oldhno ? $request->oldhno : null;
        $building->haddr = $request->haddr ? $request->haddr : null;
        $building->haddrplt = $request->haddrplt ? $request->haddrplt : null;
        $building->strtcd = $request->strtcd ? $request->strtcd : null;
        $building->bldguse = $request->bldguse ? $request->bldguse : 0;
        $building->hownr = $request->hownr ? $request->hownr : null;
        $building->yoc = $request->yoc ? $request->yoc : null;
        $building->flrcount = $request->flrcount ? $request->flrcount : null;
        $building->consttyp = $request->consttyp ? $request->consttyp : 0;
        $building->toilyn = $request->toilyn ? $request->toilyn : 0;
        $building->hhcount = $request->hhcount ? $request->hhcount : null;
        $building->hhpop = $request->hhpop ? $request->hhpop : null;
        $building->txpyrid = $request->txpyrid ? $request->txpyrid : null;
        $building->txpyrname = $request->txpyrname ? $request->txpyrname : null;
        $building->btxsts = $request->btxsts ? $request->btxsts : 99;
        $building->sngwoman = $request->sngwoman ? $request->sngwoman : 0;
        $building->gt60yr = $request->gt60yr ? $request->gt60yr : 0; 
        $building->flrar = $request->flrar ? $request->flrar : null;
        $building->bprmtno = $request->bprmtno ? $request->bprmtno : null;
        $building->offcnm = $request->offcnm ? $request->offcnm : null;
        $building->dsblppl = $request->dsblppl ? $request->dsblppl : 0;
        $building->save();
        if($request->hasFile('kml_file')) {
            $xml = new DOMDocument();
            $xml->load($request->kml_file);
            
            $polygons = $xml->getElementsByTagName('Polygon');
            if($polygons->length > 0) {
                $coordinates = $polygons[0]->getElementsByTagName('coordinates');
                if($coordinates->length > 0) {
                    $value = $coordinates[0]->nodeValue;
                    $points = preg_split('/\s/', $value);
                    $points = array_map(function($value){
                        $arr = explode(',', $value);
                        if(count($arr) > 1) {
                            return $arr[0] . ' ' . $arr[1];
                        }
                        else {
                            return null;
                        }
                    }, $points);
                    // remove empty elements from array
                    $points = array_filter($points);


                    $building->geom = DB::raw("ST_GeomFromText('MULTIPOLYGON(((" . implode(',', $points) .  ")))', 4326)");
                    $building->save();
                }
            }
        }
        if($request->hasFile('house_new_photo')) {
        $imageName = $request->bin.'.'.$request->house_new_photo->extension();

        $storeHouseImg = Image::make($request->house_new_photo)->save(Storage::disk('public')->path('/buildings/new-photos/' . $imageName),50);
        $building->house_new_photo = $imageName ? $imageName : null;
        $building->save();
        }
        Flash::success('Building added successfully');
        return redirect()->action('BuildingController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $building = Building::find($id);

        if ($building) {
            $pageTitle = "Building Details";

            return view('buildings.show', compact('pageTitle', 'building'));
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
        $building = Building::find($id);
        $wards = Ward::orderBy('ward')->pluck('ward', 'ward');
        $streets = Street::orderBy('strtcd')->pluck('strtcd', 'strtcd');
        $buildingUses = BuildingUse::pluck('name', 'value');
        $constructionTypes = BuildingConstr::pluck('name', 'value');
        $taxStatuses = TaxStsCode::pluck('name', 'value');
        $yesNo = YesNo::pluck('name', 'value');

        if ($building) {
            $pageTitle = "Edit Building";
            return view('buildings.edit', compact('pageTitle', 'building',  'wards', 'streets', 'buildingUses', 'constructionTypes', 'taxStatuses', 'yesNo'));
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
        Validator::extend('file_extension', function ($attribute, $value, $parameters, $validator) {
                if( !in_array( $value->getClientOriginalExtension(), $parameters ) ){
                return false;
            }
            else {
                return true;
            }
        }, 'File must be kml format');
        $building = Building::find($id);
        if ($building) {
            $this->validate($request, [
                'bin' => 'required|unique:bldg,bin,' . $id . ',bin',
                'yoc' => 'numeric',
                'flrcount' => 'numeric',
                'consttyp' => 'numeric',
                'toilyn' => 'numeric',
                'hhcount' => 'numeric',
                'hhpop' => 'numeric',
                'btxsts' => 'numeric',
                'flrar' => 'numeric',
                'bprmtno' => 'numeric',
                'haddrplt' => 'numeric',
                'haddr' => 'numeric',
                'bldguse'  => 'numeric',
                'sngwoman'  => 'numeric',
                'gt60yr' => 'numeric',
                'dsblppl' => 'numeric',
                'kml_file' => 'file_extension:kml'
            ]);

        $building->bin = $request->bin ? $request->bin : null;
        $building->bldgcd = $request->bldgcd ? $request->bldgcd : null;
        $building->ward = $request->ward ? $request->ward : null;
        $building->tole = $request->tole ? $request->tole : null;
        $building->oldhno = $request->oldhno ? $request->oldhno : null;
        $building->haddr = $request->haddr ? $request->haddr : null;
        $building->haddrplt = $request->haddrplt ? $request->haddrplt : null;
        $building->strtcd = $request->strtcd ? $request->strtcd : null;
        $building->bldguse = $request->bldguse ? $request->bldguse : 0;
        $building->hownr = $request->hownr ? $request->hownr : null;
        $building->yoc = $request->yoc ? $request->yoc : null;
        $building->flrcount = $request->flrcount ? $request->flrcount : null;
        $building->consttyp = $request->consttyp ? $request->consttyp : 0;
        $building->toilyn = $request->toilyn ? $request->toilyn : 0;
        $building->hhcount = $request->hhcount ? $request->hhcount : null;
        $building->hhpop = $request->hhpop ? $request->hhpop : null;
        $building->txpyrid = $request->txpyrid ? $request->txpyrid : null;
        $building->txpyrname = $request->txpyrname ? $request->txpyrname : null;
        $building->btxsts = $request->btxsts ? $request->btxsts : 99;
        $building->sngwoman = $request->sngwoman ? $request->sngwoman : 0;
        $building->gt60yr = $request->gt60yr ? $request->gt60yr : 0; 
        $building->flrar = $request->flrar ? $request->flrar : null;
        $building->bprmtno = $request->bprmtno ? $request->bprmtno : null;
        $building->offcnm = $request->offcnm ? $request->offcnm : null;
        $building->dsblppl = $request->dsblppl ? $request->dsblppl : 0;
        $building->save();
        
        $building->save();
        if($request->hasFile('kml_file')) {
            $xml = new DOMDocument();
            $xml->load($request->kml_file);
            
            $polygons = $xml->getElementsByTagName('Polygon');
            if($polygons->length > 0) {
                $coordinates = $polygons[0]->getElementsByTagName('coordinates');
                if($coordinates->length > 0) {
                    $value = $coordinates[0]->nodeValue;
                    $points = preg_split('/\s/', $value);
                    $points = array_map(function($value){
                        $arr = explode(',', $value);
                        if(count($arr) > 1) {
                            return $arr[0] . ' ' . $arr[1];
                        }
                        else {
                            return null;
                        }
                    }, $points);
                    // remove empty elements from array
                    $points = array_filter($points);


                    $building->geom = DB::raw("ST_GeomFromText('MULTIPOLYGON(((" . implode(',', $points) .  ")))', 4326)");
                    $building->save();
                }
            }
            }
        if($request->hasFile('house_new_photo')) {
        $imageName = $request->bin.'.'.$request->house_new_photo->extension();
        $storeHouseImg = Image::make($request->house_new_photo)->save(Storage::disk('public')->path('/buildings/new-photos/' . $imageName),50);
        $building->house_new_photo = $imageName ? $imageName : null;
        $building->save();
        }

            Flash::success('Building updated successfully');
            return redirect('buildings');
        } else {
            Flash::error('Failed to update building');
            return redirect('buildings');
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
        $building = Building::find($id);

        if ($building) {
            $building->delete();

            Flash::success('Building deleted successfully');
            return redirect('buildings');
        } else {
            Flash::error('Failed to delete building');
            return redirect('buildings');
        }
    }

    public function export()
    {
        //ini_set('memory_limit', '512MB');
        set_time_limit(500); // 

        $searchData = isset($_GET['searchData']) ? $_GET['searchData'] : null;
        $bin = isset($_GET['bin']) ? $_GET['bin'] : null;
        $btxsts = isset($_GET['btxsts']) ? $_GET['btxsts'] : null;
        $toilyn = isset($_GET['toilyn']) ? $_GET['toilyn'] : null;
        $sngwoman = isset($_GET['sngwoman']) ? $_GET['sngwoman'] : null;
        $gt60yr = isset($_GET['gt60yr']) ? $_GET['gt60yr'] : null;
        $dsblppl = isset($_GET['dsblppl']) ? $_GET['dsblppl'] : null;
        $ward = isset($_GET['ward']) ? $_GET['ward'] : null;
        
        
        $columns = ['bin','bldgcd','ward','tole','oldhno','haddr','haddrplt','strtcd','imgfl','addrzn','zonecode','bldgasc','bldguse','offcnm','hownr','prclkey','yoc','flrcount','flrar','consttyp','elecyn','bprmtyn','bprmtno','buildvflag','drnkwtr','wtrcons','toilyn','wwdischg','swsegyn','sngwoman','hhcount','hhpop','gt60yr','dsblppl','datsrc','txpyrname','txpyrid','btxyr','btxsts'];

        $query = Building::select('bin','bldgcd','ward','tole','oldhno','haddr','haddrplt','strtcd','imgfl','addrzn','zonecode','bldgasc','bldguse','offcnm','hownr','prclkey','yoc','flrcount','flrar','consttyp','elecyn','bprmtyn','bprmtno','buildvflag','drnkwtr','wtrcons','toilyn','wwdischg','swsegyn','sngwoman','hhcount','hhpop','gt60yr','dsblppl','datsrc','txpyrname','txpyrid','btxyr','btxsts');
        //var_dump($query);die;
        if (!empty($searchData)) {
            foreach ($columns as $column) {
                $query->orWhereRaw("lower(cast(" . $column . " AS varchar)) LIKE lower('%" . $searchData . "%')");
                //casting to varchar LOWER doesn't work on int, double precision
            }
        }

        if (!empty($bin)) {
            $query->where('bin', $bin);
        }

        if (!empty($ward)) {
            $query->where('ward', $ward);
        }

        if (!empty($toilyn)) {
            $query->where('toilyn', $toilyn);
        }

        if (!empty($btxsts) || $btxsts == '0') {
            $query->where('btxsts', $btxsts);
        }

        if (!empty($sngwoman)) {
            $query->where('sngwoman', '>', '0');
        }

        if (!empty($gt60yr)) {
            $query->where('gt60yr', '>', '0');
        }

        if (!empty($dsblppl)) {
            $query->where('dsblppl', '>', '0');
        }

        $style = (new StyleBuilder())
            ->setFontBold()
            ->setFontSize(13)
            ->setBackgroundColor(Color::rgb(228, 228, 228))
            ->build();

        $writer = WriterFactory::create(Type::CSV);
        $writer->openToBrowser('Buildings.csv')
            ->addRowWithStyle($columns, $style); //Top row of excel

        $query->chunk(100, function ($buildings) use ($writer) {
            foreach($buildings as $building) {
                
                $values = [];
                $values[] = $building->bin;
                $values[] = $building->bldgcd;
                $values[] = $building->ward;
                $values[] = $building->tole;
                $values[] = $building->oldhno;
                $values[] = $building->haddr;
                $values[] = $building->haddrplt;
                $values[] = $building->strtcd;
                $values[] = $building->imgfl;
                $values[] = $building->addrzn;
                $values[] = $building->zonecode;
                $values[] = $building->bldgasc;
                $values[] = $building->bldguse;
                $values[] = $building->offcnm;
                $values[] = $building->hownr;
                $values[] = $building->prclkey;
                $values[] = $building->yoc;
                $values[] = $building->flrcount;
                $values[] = $building->flrar;
                $values[] = $building->consttyp;
                $values[] = $building->elecyn;
                $values[] = $building->bprmtyn;
                $values[] = $building->bprmtno;
                $values[] = $building->buildvflag;
                $values[] = $building->drnkwtr;
                $values[] = $building->wtrcons;
                $values[] = $building->toilyn;
                $values[] = $building->wwdischg;
                $values[] = $building->swsegyn;
                $values[] = $building->sngwoman;
                $values[] = $building->hhcount;
                $values[] = $building->hhpop;
                $values[] = $building->gt60yr;
                $values[] = $building->dsblppl;
                $values[] = $building->datsrc;
                $values[] = $building->txpyrname;
                $values[] = $building->txpyrid;
                $values[] = $building->btxyr;
                $values[] = $building->btxsts;
                $writer->addRow($values);
            }
            
        });

        $writer->close();
    }

    public function downloadPhoto($building_id) {
        $building = Building::find($building_id);
        if($building) {
            $filepath = storage_path('app/photos/' . $building->house_photo);
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
    
    public function downloadNewPhoto($building_id) {
        $building = Building::find($building_id);
        if($building) {
            $filepath = storage_path('app/new-photos/' . $building->house_new_photo);
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
    public function getBinNumbers(){
       
        $query = Building::select('bin')->distinct()->orderBy('bin', 'ASC');
        
    
        if (request()->search) {
            $query->where('bin', 'ILIKE', '%' . request()->search . '%');
        }
    
        $total = $query->count();
        $limit = 10;
        if (request()->page) {
            $page = request()->page;
        } else {
            $page = 1;
        };
        $start_from = ($page - 1) * $limit;
    
        $total_pages = ceil($total / $limit);
        if ($page < $total_pages) {
            $more = true;
        } else {
            $more = false;
        }
        $house_numbers = $query->offset($start_from)
            ->limit($limit)
            ->get();
    
        $json = [];
        foreach ($house_numbers as $house_number) {
            $json[] = ['id' => $house_number['bin'], 'text' => $house_number['bin']];
        }
    
        return response()->json(['results' => $json, 'pagination' => ['more' => $more]]);
    }
    
    
    
    public function getWards()
    {
        
        $query = Building::select('ward')->distinct()->orderBy('ward', 'ASC');
        
        if (request()->search){
          
            $query->where('ward', 'ILIKE', '%'.request()->search.'%');
         
        }
        if (request()->bin){
            $query->where('bin','=',request()->bin);
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
    
        $ward_numbers = $query->offset($start_from)
            ->limit($limit)
            ->get();
               
        $json = [];
        foreach($ward_numbers as $ward_number)
        {
            $json[] = ['id'=>$ward_number['ward'], 'text'=>$ward_number['ward']];
        }
    
        return response()->json(['results' =>$json, 'pagination' => ['more' => $more] ]);
          
        
    }
}   
    
