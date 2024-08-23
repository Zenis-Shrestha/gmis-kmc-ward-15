<?php

namespace App\Http\Controllers;

use App\RoadSurface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;
use Datatables;

class RoadSurfaceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('ability:super-admin,list-road-surfaces', ['only' => ['index']]);
        // $this->middleware('ability:super-admin,view-road-surface', ['only' => ['show']]);
        // $this->middleware('ability:super-admin,add-road-surface', ['only' => ['add', 'store']]);
        // $this->middleware('ability:super-admin,edit-road-surface', ['only' => ['edit', 'update']]);
        // $this->middleware('ability:super-admin,delete-road-surface', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "Road Surface List";

        return view('road-surfaces.index', compact('pageTitle'));
    }

    /**
     * Get the data to populate the datatable in the view
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Yajra\Datatables\Datatables
     */
    public function getData(Request $request)
    {
        $roadSurfaceData = RoadSurface::all();

        return Datatables::of($roadSurfaceData)
            ->addColumn('action', function ($model) {
                $content = \Form::open(['method' => 'DELETE', 'route' => ['road-surfaces.destroy', $model->id]]);

                
                    $content .= '<a title="Edit" href="' . action("RoadSurfaceController@edit", [$model->id]) . '" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></a> ';
                

                
                    $content .= '<a title="Detail" href="' . action("RoadSurfaceController@show", [$model->id]) . '" class="btn btn-info btn-xs"><i class="fa fa-list"></i></a> ';
                

               
                    $content .= '<button title="Delete" type="submit" class="btn btn-info btn-xs" onclick="return confirm(\'Are you sure?\')">&nbsp;<i class="fa fa-trash"></i>&nbsp;</button> ';
                

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
        $pageTitle = "Add Road Surface";

        return view('road-surfaces.add', compact('pageTitle'));
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
            'name' => 'required|unique:road_surface,name',
            'value' => 'required|numeric|unique:road_surface,value',
        ]);

        $roadSurface = new RoadSurface();
        $roadSurface->name = $request->name ? $request->name : null;
        $roadSurface->value = $request->value ? $request->value : null;
        $roadSurface->save();

        Flash::success('Road surface added successfully');

        return redirect()->action('RoadSurfaceController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $roadSurface = RoadSurface::find($id);

        if ($roadSurface) {
            $pageTitle = "Road Surface Details";

            return view('road-surfaces.show', compact('pageTitle', 'roadSurface'));
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
        $roadSurface = RoadSurface::find($id);

        if ($roadSurface) {
            $pageTitle = "Edit Road Surface";

            return view('road-surfaces.edit', compact('pageTitle', 'roadSurface'));
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
        $roadSurface = RoadSurface::find($id);

        if ($roadSurface) {
            $this->validate($request, [
                'name' => 'required|unique:road_surface,name,' . $id,
                'value' => 'required|numeric|unique:road_surface,value,' . $id,
            ]);

            $roadSurface->name = $request->name ? $request->name : null;
            $roadSurface->value = $request->value ? $request->value : null;
            $roadSurface->save();

            Flash::success('Road surface updated successfully');
            return redirect()->action('RoadSurfaceController@index');
        } else {
            Flash::error('Failed to update road surface');
            return redirect()->action('RoadSurfaceController@index');
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
        $roadSurface = RoadSurface::find($id);

        if ($roadSurface) {
            $roadSurface->delete();

            Flash::success('Road surface deleted successfully');
            return redirect()->action('RoadSurfaceController@index');
        } else {
            Flash::error('Failed to delete road surface');
            return redirect()->action('RoadSurfaceController@index');
        }
    }
}
