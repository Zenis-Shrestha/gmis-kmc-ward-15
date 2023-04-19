<?php

namespace App\Http\Controllers;

use App\BuildingConstr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;
use Datatables;

class BuildingConstrController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('ability:super-admin,list-building-constructions', ['only' => ['index']]);
        $this->middleware('ability:super-admin,view-building-construction', ['only' => ['show']]);
        $this->middleware('ability:super-admin,add-building-construction', ['only' => ['add', 'store']]);
        $this->middleware('ability:super-admin,edit-building-construction', ['only' => ['edit', 'update']]);
        $this->middleware('ability:super-admin,delete-building-construction', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "Builidng Construction Type List";

        return view('building-constructions.index', compact('pageTitle'));
    }

    /**
     * Get the data to populate the datatable in the view
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Yajra\Datatables\Datatables
     */
    public function getData(Request $request)
    {
        $buildingConstrData = BuildingConstr::all();

        return Datatables::of($buildingConstrData)
            ->addColumn('action', function ($model) {
                $content = \Form::open(['method' => 'DELETE', 'route' => ['building-constructions.destroy', $model->id]]);

                if (Auth::user()->ability('super-admin', 'edit-building-construction')) {
                    $content .= '<a title="Edit" href="' . action("BuildingConstrController@edit", [$model->id]) . '" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></a> ';
                }

                if (Auth::user()->ability('super-admin', 'view-building-construction')) {
                    $content .= '<a title="Detail" href="' . action("BuildingConstrController@show", [$model->id]) . '" class="btn btn-info btn-xs"><i class="fa fa-list"></i></a> ';
                }

                if (Auth::user()->ability('super-admin', 'delete-building-construction')) {
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
        $pageTitle = "Add Building Construction Type";

        return view('building-constructions.add', compact('pageTitle'));
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
            'name' => 'required|unique:building_construction,name',
            'value' => 'required|numeric|unique:building_construction,value',
        ]);

        $buildingConstr = new BuildingConstr();
        $buildingConstr->name = $request->name ? $request->name : null;
        $buildingConstr->value = $request->value ? $request->value : null;
        $buildingConstr->save();

        Flash::success('Building construction type added successfully');

        return redirect()->action('BuildingConstrController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $buildingConstr = BuildingConstr::find($id);

        if ($buildingConstr) {
            $pageTitle = "Building Construction Type Details";

            return view('building-constructions.show', compact('pageTitle', 'buildingConstr'));
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
        $buildingConstr = BuildingConstr::find($id);

        if ($buildingConstr) {
            $pageTitle = "Edit Building Construction Type";

            return view('building-constructions.edit', compact('pageTitle', 'buildingConstr'));
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
        $buildingConstr = BuildingConstr::find($id);

        if ($buildingConstr) {
            $this->validate($request, [
                'name' => 'required|unique:building_construction,name,' . $id,
                'value' => 'required|numeric|unique:building_construction,value,' . $id,
            ]);

            $buildingConstr->name = $request->name ? $request->name : null;
            $buildingConstr->value = $request->value ? $request->value : null;
            $buildingConstr->save();

            Flash::success('Building construction type updated successfully');
            return redirect()->action('BuildingConstrController@index');
        } else {
            Flash::error('Failed to update building construction type');
            return redirect()->action('BuildingConstrController@index');
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
        $buildingConstr = BuildingConstr::find($id);

        if ($buildingConstr) {
            $buildingConstr->delete();

            Flash::success('Building construction type deleted successfully');
            return redirect()->action('BuildingConstrController@index');
        } else {
            Flash::error('Failed to delete building construction type');
            return redirect()->action('BuildingConstrController@index');
        }
    }
}
