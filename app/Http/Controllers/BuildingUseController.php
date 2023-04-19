<?php

namespace App\Http\Controllers;

use App\BuildingUse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;
use Datatables;

class BuildingUseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('ability:super-admin,list-building-uses', ['only' => ['index']]);
        $this->middleware('ability:super-admin,view-building-use', ['only' => ['show']]);
        $this->middleware('ability:super-admin,add-building-use', ['only' => ['add', 'store']]);
        $this->middleware('ability:super-admin,edit-building-use', ['only' => ['edit', 'update']]);
        $this->middleware('ability:super-admin,delete-building-use', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "Builidng Use List";

        return view('building-uses.index', compact('pageTitle'));
    }

    /**
     * Get the data to populate the datatable in the view
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Yajra\Datatables\Datatables
     */
    public function getData(Request $request)
    {
        $buildingUseData = BuildingUse::all();

        return Datatables::of($buildingUseData)
            ->addColumn('action', function ($model) {
                $content = \Form::open(['method' => 'DELETE', 'route' => ['building-uses.destroy', $model->id]]);

                if (Auth::user()->ability('super-admin', 'edit-building-use')) {
                    $content .= '<a title="Edit" href="' . action("BuildingUseController@edit", [$model->id]) . '" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></a> ';
                }

                if (Auth::user()->ability('super-admin', 'view-building-use')) {
                    $content .= '<a title="Detail" href="' . action("BuildingUseController@show", [$model->id]) . '" class="btn btn-info btn-xs"><i class="fa fa-list"></i></a> ';
                }

                if (Auth::user()->ability('super-admin', 'delete-building-use')) {
                    $content .= '<button title="Delete" type="submit" class="btn btn-info btn-xs" onclick="return confirm(\'Are you sure?\')">&nbsp;<i class="fa fa-trash"></i>&nbsp;</button> ';
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
        $pageTitle = "Add Building Use";

        return view('building-uses.add', compact('pageTitle'));
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
            'name' => 'required|unique:building_use,name',
            'value' => 'required|numeric|unique:building_use,value',
        ]);

        $buildingUse = new BuildingUse();
        $buildingUse->name = $request->name ? $request->name : null;
        $buildingUse->value = $request->value ? $request->value : null;
        $buildingUse->save();

        Flash::success('Building use added successfully');

        return redirect()->action('BuildingUseController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $buildingUse = BuildingUse::find($id);

        if ($buildingUse) {
            $pageTitle = "Building Use Details";

            return view('building-uses.show', compact('pageTitle', 'buildingUse'));
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
        $buildingUse = BuildingUse::find($id);

        if ($buildingUse) {
            $pageTitle = "Edit Building Use";

            return view('building-uses.edit', compact('pageTitle', 'buildingUse'));
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
        $buildingUse = BuildingUse::find($id);

        if ($buildingUse) {
            $this->validate($request, [
                'name' => 'required|unique:building_use,name,' . $id,
                'value' => 'required|numeric|unique:building_use,value,' . $id,
            ]);

            $buildingUse->name = $request->name ? $request->name : null;
            $buildingUse->value = $request->value ? $request->value : null;
            $buildingUse->save();

            Flash::success('Building use updated successfully');
            return redirect()->action('BuildingUseController@index');
        } else {
            Flash::error('Failed to update building use');
            return redirect()->action('BuildingUseController@index');
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
        $buildingUse = BuildingUse::find($id);

        if ($buildingUse) {
            $buildingUse->delete();

            Flash::success('Building use deleted successfully');
            return redirect()->action('BuildingUseController@index');
        } else {
            Flash::error('Failed to delete building use');
            return redirect()->action('BuildingUseController@index');
        }
    }
}
