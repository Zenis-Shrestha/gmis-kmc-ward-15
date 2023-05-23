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
use App\DueYear;
use App\BuildingOwner;
use App\Exports\BuildingsWithTaxStatusExport;
use Maatwebsite\Excel\Facades\Excel;

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
        $dueYears = DueYear::getInAscOrder();
        $yesNo = YesNo::pluck('name', 'value');
        $currentYear = "2080";
        $yearOfConstruction = DB::table('bldg')
                            ->select('yoc')
                            ->distinct()
                            ->whereBetween('yoc', [2060, $currentYear])
                            ->orderBy('yoc', 'desc')
                            ->pluck('yoc');
        

        return view('buildings.index', compact('pageTitle', 'wards', 'dueYears', 'yesNo','yearOfConstruction'));
    }

    public function getData(Request $request)
    {
       
        $buildingData = DB::table('bldg')
        ->leftJoin('bldg_tax_payment_status AS tax', 'bldg.bin', '=', 'tax.bin')
        ->leftjoin('due_years AS due', 'due.value', '=', 'tax.due_year')
        ->leftjoin('bldg_owners AS bo', 'bo.bin', '=', 'bldg.bin')
        ->select('bldg.*', 'due.name AS taxName', 'tax.due_year', 'bo.owner_name AS owner_name')
        
    ;


        return Datatables::of($buildingData)
            ->filter(function ($query) use ($request) {
               
                if ($request->bin) {
                    $query->where('bldg.bin', $request->bin);
                }

                if ($request->ward) {
                    $query->where('bldg.ward', $request->ward);
                }
                
                if ($request->yoc) {
                   
                    $query->where('bldg.yoc', $request->yoc);
                  
                }

                if ($request->hownr) {
                    $query->where('bo.owner_name', $request->hownr);
                }

                if ($request->due_year) {
                    
                    $query->where('due.name', $request->due_year);
              
                }

                if ($request->strtcd) {
                       $query->where('bldg.strtcd', $request->strtcd);
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
        $nextBin = Building::max('bin') + 1;

        return view('buildings.add', compact('pageTitle', 'wards', 'streets', 'buildingUses', 'constructionTypes', 'taxStatuses', 'yesNo', 'nextBin'));
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
            //'bin' => 'required|unique:bldg,bin',
            'yoc' => 'numeric',
            'flrcount' => 'numeric',
            'consttyp' => 'numeric',
            'toilyn' => 'numeric',
            'hhcount' => 'numeric',
            'hhpop' => 'numeric',
            'due_year' => 'numeric',
            'flrar' => 'numeric',
            'bprmtno' => 'numeric',
            'haddrplt' => 'numeric',
            'haddr' => 'numeric',
            'bldguse'  => 'numeric',
            'sngwoman'  => 'numeric',
            'gt60yr' => 'numeric',
            'dsblppl' => 'numeric',
            'house_new_photo' => 'image|mimes:png,jpg,jpeg',
            'footprint_option' => 'required',
            'kml_file' => 'required_if:footprint_option,==,upload_kml|file_extension:kml',
            'geom' => 'required_if:footprint_option,==,draw_plygon',
        ]);

        $building = new Building();
        $building->bin = Building::max('bin') + 1;
        $building->bldgcd = $request->bldgcd ? $request->bldgcd : null;
        $building->ward = $request->ward ? $request->ward : null;
        $building->tole = $request->tole ? $request->tole : null;
        $building->oldhno = $request->oldhno ? $request->oldhno : null;
        $building->haddr = $request->haddr ? $request->haddr : null;
        $building->haddrplt = $request->haddrplt ? $request->haddrplt : null;
        $building->strtcd = $request->strtcd ? $request->strtcd : null;
        $building->bldguse = $request->bldguse ? $request->bldguse : 0;
        //$building->hownr = $request->hownr ? $request->hownr : null;
        $building->yoc = $request->yoc ? $request->yoc : null;
        $building->flrcount = $request->flrcount ? $request->flrcount : null;
        $building->consttyp = $request->consttyp ? $request->consttyp : 0;
        $building->toilyn = $request->toilyn ? $request->toilyn : 0;
        $building->hhcount = $request->hhcount ? $request->hhcount : null;
        $building->hhpop = $request->hhpop ? $request->hhpop : null;
        $building->txpyrid = $request->txpyrid ? $request->txpyrid : null;
        $building->txpyrname = $request->txpyrname ? $request->txpyrname : null;
        //$building->due_year = $request->due_year ? $request->due_year : 99;
        $building->sngwoman = $request->sngwoman ? $request->sngwoman : 0;
        $building->gt60yr = $request->gt60yr ? $request->gt60yr : 0; 
        $building->flrar = $request->flrar ? $request->flrar : null;
        $building->bprmtno = $request->bprmtno ? $request->bprmtno : null;
        $building->offcnm = $request->offcnm ? $request->offcnm : null;
        $building->dsblppl = $request->dsblppl ? $request->dsblppl : 0;
        if($request->geom && $request->footprint_option == 'draw_plygon'){
        $building->geom = $request->geom ? DB::raw("ST_Multi(ST_GeomFromText('" . $request->geom . "', 4326))") : null;
        }
        $building->save();
        
        $owner = new BuildingOwner();
        $owner->bin = $building->bin;
        $owner->owner_name = $request->hownr ? $request->hownr : null;
        $owner->save();
        
        
        if($request->hasFile('kml_file') && $request->footprint_option == 'upload_kml') {
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
        $imageName = $request->bin.'.'.$request->house_new_photo->getClientOriginalExtension();

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
        if ($building->house_new_photo != null && Storage::disk('public')->exists('buildings/new-photos/'.$building->house_new_photo)) {
             $photo_path = asset('storage/buildings/new-photos/' . $building->house_new_photo);
         }
        else if ($building->house_photo != null && Storage::disk('public')->exists('buildings/photos/'.$building->house_photo)) {
             $photo_path = asset('storage/buildings/photos/' . $building->house_photo);
         }
         else{
             $photo_path = '';
         }
       
        $building['photo_path'] = $photo_path;
        if ($building) {
            $owner = BuildingOwner::select('*')->where('bin', $id)->first();
            if($owner)
            {
                $building->owner_name = $owner->owner_name;

            }
            $pageTitle = "Building Details";

            return view('buildings.show', compact('pageTitle', 'building', 'photo_path'));
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
        $geomArr = DB::select("SELECT ST_X(ST_AsText(ST_Centroid(ST_Centroid(geom)))) AS long, ST_Y(ST_AsText(ST_Centroid(ST_Centroid(geom)))) AS lat, ST_AsText(geom) AS geom FROM bldg WHERE bin = $id");
        $geom = ($geomArr[0]->geom);
        $lat = $geomArr[0]->lat;
        $long = $geomArr[0]->long;
        $wards = Ward::orderBy('ward')->pluck('ward', 'ward');
        $streets = Street::orderBy('strtcd')->pluck('strtcd', 'strtcd');
        $buildingUses = BuildingUse::pluck('name', 'value');
        $constructionTypes = BuildingConstr::pluck('name', 'value');
        $taxStatuses = TaxStsCode::pluck('name', 'value');
        $yesNo = YesNo::pluck('name', 'value');
        
        if ($building) {
             $owner = BuildingOwner::select('*')->where('bin', $id)->first();
                if($owner)
                {
                    $building->hownr = $owner->owner_name;
                   
                }
                else{
                    $building->hownr = $building->hownr;
                }
            $pageTitle = "Edit Building";
            return view('buildings.edit', compact('pageTitle', 'building',  'wards', 'streets', 'buildingUses', 'constructionTypes', 'taxStatuses', 'yesNo', 'geom', 'lat', 'long'));
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
                //'bin' => 'required|unique:bldg,bin,' . $id . ',bin',
                'yoc' => 'numeric',
                'flrcount' => 'numeric',
                'consttyp' => 'numeric',
                'toilyn' => 'numeric',
                'hhcount' => 'numeric',
                'hhpop' => 'numeric',
                'due_year' => 'numeric',
                'flrar' => 'numeric',
                'bprmtno' => 'numeric',
                'haddrplt' => 'numeric',
                'haddr' => 'numeric',
                'bldguse'  => 'numeric',
                'sngwoman'  => 'numeric',
                'gt60yr' => 'numeric',
                'dsblppl' => 'numeric',
                'house_new_photo' => 'image|mimes:png,jpg,jpeg',
                //'kml_file' => 'required_if:footprint_option,==,upload_kml|file_extension:kml',
                //'geom' => 'required_if:footprint_option,==,draw_plygon',
            ]);

        //$building->bin = $request->bin ? $request->bin : null;
        $building->bldgcd = $request->bldgcd ? $request->bldgcd : null;
        $building->ward = $request->ward ? $request->ward : null;
        $building->tole = $request->tole ? $request->tole : null;
        $building->oldhno = $request->oldhno ? $request->oldhno : null;
        $building->haddr = $request->haddr ? $request->haddr : null;
        $building->haddrplt = $request->haddrplt ? $request->haddrplt : null;
        $building->strtcd = $request->strtcd ? $request->strtcd : null;
        $building->bldguse = $request->bldguse ? $request->bldguse : 0;
        //$building->hownr = $request->hownr ? $request->hownr : null;
        $building->yoc = $request->yoc ? $request->yoc : null;
        $building->flrcount = $request->flrcount ? $request->flrcount : null;
        $building->consttyp = $request->consttyp ? $request->consttyp : 0;
        $building->toilyn = $request->toilyn ? $request->toilyn : 0;
        $building->hhcount = $request->hhcount ? $request->hhcount : null;
        $building->hhpop = $request->hhpop ? $request->hhpop : null;
        $building->txpyrid = $request->txpyrid ? $request->txpyrid : null;
        $building->txpyrname = $request->txpyrname ? $request->txpyrname : null;
        //$building->due_year = $request->due_year ? $request->due_year : 99;
        $building->sngwoman = $request->sngwoman ? $request->sngwoman : 0;
        $building->gt60yr = $request->gt60yr ? $request->gt60yr : 0; 
        $building->flrar = $request->flrar ? $request->flrar : null;
        $building->bprmtno = $request->bprmtno ? $request->bprmtno : null;
        $building->offcnm = $request->offcnm ? $request->offcnm : null;
        $building->dsblppl = $request->dsblppl ? $request->dsblppl : 0;
        if($request->geom && $request->footprint_option == 'draw_plygon'){
        $building->geom = $request->geom ? DB::raw("ST_Multi(ST_GeomFromText('" . $request->geom . "', 4326))") : $building->geom;
        }
        $building->save();
        
        if (BuildingOwner::where('bin', $id)->exists()) {
            $owner = BuildingOwner::where('bin',$id)->first();
            } else {
                $owner = new BuildingOwner();
                $owner->bin = $id;
            }
            $owner->owner_name = $request->hownr ? $request->hownr : null;
            $owner->save();
       
        if($request->hasFile('kml_file') && $request->footprint_option == 'upload_kml') {
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
        $imageName = $request->bin.'.'.$request->house_new_photo->getClientOriginalExtension();
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
        ini_set('memory_limit', '512MB');
        ob_end_clean();
        set_time_limit(500); // 

        $searchData = isset($_GET['searchData']) ? $_GET['searchData'] : null;
        $bin = isset($_GET['bin']) ? $_GET['bin'] : null;
        $due_year = isset($_GET['due_year']) ? $_GET['due_year'] : null;
        $hownr = isset($_GET['hownr']) ? $_GET['hownr'] : null;
        $tole = isset($_GET['tole']) ? $_GET['tole'] : null;
        $strtcd = isset($_GET['strtcd']) ? $_GET['strtcd'] : null;
        $ward = isset($_GET['ward']) ? $_GET['ward'] : null;
        
        return Excel::download(new BuildingsWithTaxStatusExport($bin, $due_year, $hownr, $tole, $strtcd, $ward), 'Building Info.xlsx');

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
    
    public function downloadNewPhoto($building_id) {
        $building = Building::find($building_id);
        if($building) {
            $filepath = storage_path('app/new-photos/' . $building->bin . '.jpg');
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
    public function getStreetNames(){
       
        $query = Street::select('strtcd', 'strtnm')->distinct()->orderBy('strtcd', 'ASC');
        
    
        if (request()->search) {
            $query->where('strtcd', 'ILIKE', '%' . request()->search . '%');
            $query->orWhere('strtnm', 'ILIKE', '%' . request()->search . '%');
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
            $json[] = ['id' => $house_number['strtcd'], 'text' => $house_number['strtcd'] . ' - ' .$house_number['strtnm']];
        }
        return response()->json(['results' => $json, 'pagination' => ['more' => $more]]);
    }

}   
    
