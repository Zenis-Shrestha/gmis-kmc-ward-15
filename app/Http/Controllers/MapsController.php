<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Distpl;
use App\Vdcpl;
use App\Operator;
use App\Band;
use App\Ward;
use App\ByLaw;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BuildingsInfoExport;
use App\Exports\BuildingsMultisheet;
use App\Exports\BuildingsAreaMultisheet;


class MapsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');//, ['except' => ['index']]);
        $this->middleware('ability:super-admin,view-map', ['only' =>['index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        /*$districts = Distpl::orderBy('district', 'asc')->pluck('district','district')->all();
        $vdcs = Vdcpl::orderBy('vdc_name', 'asc')->pluck('vdc_name','vdc_name')->all();
        $operators = Operator::pluck('oprcode','oprcode')->all();
        $bands = Band::pluck('band_name', 'id')->all();*/
        $wards = Ward::orderBy('ward', 'asc')->pluck('ward', 'ward')->all();
        $bylaws = ByLaw::orderBy('name', 'asc')->pluck('name', 'name')->all();
        $pageTitle = "Map";
        // return view('maps.index', compact('page_title','districts','operators','vdcs','bands'));
        return view('maps.index', compact('wards', 'bylaws', 'pageTitle'));
    }

    public function map1()
    {
        $districts = Distpl::orderBy('district', 'asc')->pluck('district','district')->all();
        $vdcs = Vdcpl::orderBy('vdc_name', 'asc')->pluck('vdc_name','vdc_name')->all();
        $operators = Operator::pluck('oprcode','oprcode')->all();
        $bands = Band::pluck('band_name', 'id')->all();
        $page_title = "Map";
        return view('maps.map1', compact('page_title','districts','operators','vdcs','bands'));
    }

    
    public function getBuildingsReportCSV()
    {
        ob_end_clean();
        return Excel::download(new BuildingsMultisheet(request()->lat, request()->long, request()->bin), 'buildings.xlsx');
        
    }

    public function getBuildingsAreaReportCSV()
    {
        ob_end_clean();
        return Excel::download(new BuildingsAreaMultisheet(request()->geom), 'Building Infromation.xlsx');
        
    }
}
