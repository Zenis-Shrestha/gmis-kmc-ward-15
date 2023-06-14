<?php

namespace App\Http\Controllers;

use App\BuildingPhoto;
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

class PhotoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllPhotos()
    {
        \DB::statement('TRUNCATE TABLE bldg_photos RESTART IDENTITY');
        \DB::statement('ALTER SEQUENCE IF exists bldg_photos_id_seq RESTART WITH 1');
        $directory = "buildings/reduced_photos";
      
        $files = Storage::disk('public')->allFiles($directory);
        
        foreach($files as $file)
        {
            $file_single = explode("buildings/reduced_photos/", $file);
            $file_name = $file_single[1];
            $binarr = explode(".", $file_name);
            $bin = $binarr[0];
            $building_photo = new BuildingPhoto();
            $building_photo->bin = $bin;
            $building_photo->new_photo = $file_name;
            $building_photo->save();
        }
    }

}   
    
