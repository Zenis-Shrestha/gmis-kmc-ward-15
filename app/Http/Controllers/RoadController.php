<?php

namespace App\Http\Controllers;

use App\Road;
use App\Street;
use App\VerfYesNo;
use App\AddZone;
use App\RoadHierarchy;
use App\RoadSurface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;
use Datatables;

class RoadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('ability:super-admin,list-roads', ['only' => ['index']]);
        $this->middleware('ability:super-admin,view-road', ['only' => ['show']]);
        $this->middleware('ability:super-admin,add-road', ['only' => ['add', 'store']]);
        $this->middleware('ability:super-admin,edit-road', ['only' => ['edit', 'update']]);
        $this->middleware('ability:super-admin,delete-road', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "Road List";
        $streets = Street::orderBy('strtcd')->pluck('strtcd', 'strtcd');
        $roadSurfaces = RoadSurface::pluck('name', 'value');

        return view('roads.index', compact('pageTitle', 'streets', 'roadSurfaces'));
    }

    public function getData(Request $request)
    {
        $roadData = Road::select('gid', 'strtnm', 'strtcd', 'rdlen', 'rdwidth', 'rdhier', 'rdsurf')
                        ->with('street')
                        ->with('roadHierarchy')
                        ->with('roadSurface');

        return Datatables::of($roadData)
            ->filter(function ($query) use ($request) {
                if ($request->strtnm) {
                    $query->whereRaw("LOWER(strtnm) LIKE '%" . strtolower($request->strtnm) . "%'");
                }

                if ($request->strtcd) {
                    $query->where('strtcd', $request->strtcd);
                }

                if ($request->rdwidth) {
                    $query->where('rdwidth', $request->rdwidth);
                }

                if ($request->rdsurf || $request->rdsurf == '0') {
                    $query->where('rdsurf', $request->rdsurf);
                }
            })
            ->addColumn('action', function ($model) {
                $content = \Form::open(['method' => 'DELETE', 'route' => ['roads.destroy', $model->gid]]);

                /*if (Auth::user()->ability('super-admin', 'edit-road')) {
                    $content .= '<a title="Edit" href="' . action("RoadController@edit", [$model->gid]) . '" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></a> ';
                }*/

                if (Auth::user()->ability('super-admin', 'view-road')) {
                    $content .= '<a title="Detail" href="' . action("RoadController@show", [$model->gid]) . '" class="btn btn-info btn-xs"><i class="fa fa-list"></i></a> ';
                }

                /*if (Auth::user()->ability('super-admin', 'delete-road')) {
                    $content .= '<button title="Delete" type="submit" class="btn btn-info btn-xs" onclick="return confirm(\'Are you sure?\')">&nbsp;<i class="fa fa-trash"></i>&nbsp;</button> ';
                }*/

                if (Auth::user()->ability('super-admin', 'view-map')) {
                    $content .= '<a title="Map" href="'.action("MapsController@index", ['layer'=>'road','field'=>'gid','val'=>$model->gid]).'" class="btn btn-info btn-xs"><i class="fa fa-map-marker"></i></a> ';
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
        $pageTitle = "Add Road";
        $streets = Street::orderBy('strtcd')->pluck('strtcd', 'strtcd');
        $addZones = AddZone::orderBy('name')->pluck('name', 'value');
        $roadHierarchies = RoadHierarchy::pluck('name', 'value');
        $roadSurfaces = RoadSurface::pluck('name', 'value');
        $verfYesNo = VerfYesNo::pluck('name', 'value');

        return view('roads.add', compact('pageTitle', 'streets', 'addZones', 'roadHierarchies', 'roadSurfaces', 'verfYesNo'));
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
            'rdsgcd' => 'required|unique:road,rdsgcd',
        ]);

        $road = new Road();
        $road->rdsgcd = $request->rdsgcd ? $request->rdsgcd : null;
        $road->strtcd = $request->strtcd ? $request->strtcd : null;
        $road->strtnm = $request->strtnm ? $request->strtnm : null;
        $road->rdlen = $request->rdlen ? $request->rdlen : null;
        $road->rdwidth = $request->rdwidth ? $request->rdwidth : null;
        $road->row = $request->row ? $request->row : null;
        $road->vflag = $request->vflag ? $request->vflag : null;
        $road->addrzn = $request->addrzn ? $request->addrzn : null;
        $road->rdhier = $request->rdhier ? $request->rdhier : null;
        $road->rdsurf = $request->rdsurf ? $request->rdsurf : null;
        $road->save();

        Flash::success('Road added successfully');
        return redirect()->action('RoadController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $road = Road::find($id);

        if ($road) {
            $pageTitle = "Road Details";

            return view('roads.show', compact('pageTitle', 'road'));
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
        $road = Road::find($id);
        if ($road) {
            $pageTitle = "Edit Road";
            $streets = Street::orderBy('strtcd')->pluck('strtcd', 'strtcd');
            $addZones = AddZone::orderBy('name')->pluck('name', 'value');
            $roadHierarchies = RoadHierarchy::pluck('name', 'value');
            $roadSurfaces = RoadSurface::pluck('name', 'value');
            $verfYesNo = VerfYesNo::pluck('name', 'value');
            
            return view('roads.edit', compact('pageTitle', 'road', 'streets', 'addZones', 'roadHierarchies', 'roadSurfaces', 'verfYesNo'));
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
        $road = Road::find($id);
        if ($road) {
            $this->validate($request, [
                'rdsgcd' => 'required|unique:road,rdsgcd,' . $id . ',gid',
            ]);

            $road->rdsgcd = $request->rdsgcd ? $request->rdsgcd : null;
            $road->strtcd = $request->strtcd ? $request->strtcd : null;
            $road->strtnm = $request->strtnm ? $request->strtnm : null;
            $road->rdlen = $request->rdlen ? $request->rdlen : null;
            $road->rdwidth = $request->rdwidth ? $request->rdwidth : null;
            $road->row = $request->row ? $request->row : null;
            $road->vflag = $request->vflag ? $request->vflag : null;
            $road->addrzn = $request->addrzn ? $request->addrzn : null;
            $road->rdhier = $request->rdhier ? $request->rdhier : null;
            $road->rdsurf = $request->rdsurf ? $request->rdsurf : null;
            $road->save();

            Flash::success('Road updated successfully');
            return redirect('roads');
        } else {
            Flash::error('Failed to update road');
            return redirect('roads');
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
        $road = Road::find($id);

        if ($road) {
            $road->delete();

            Flash::success('Road deleted successfully');
            return redirect('roads');
        } else {
            Flash::error('Failed to delete road');
            return redirect('roads');
        }
    }
}
