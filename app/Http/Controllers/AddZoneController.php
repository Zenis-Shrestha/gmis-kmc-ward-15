<?php

namespace App\Http\Controllers;

use App\AddZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;
use Datatables;

class AddZoneController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('ability:super-admin,list-add-zones', ['only' => ['index']]);
        $this->middleware('ability:super-admin,view-add-zone', ['only' => ['show']]);
        $this->middleware('ability:super-admin,add-add-zone', ['only' => ['add', 'store']]);
        $this->middleware('ability:super-admin,edit-add-zone', ['only' => ['edit', 'update']]);
        $this->middleware('ability:super-admin,delete-add-zone', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "Address Zone List";

        return view('add-zones.index', compact('pageTitle'));
    }

    /**
     * Get the data to populate the datatable in the view
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Yajra\Datatables\Datatables
     */
    public function getData(Request $request)
    {
        $addZoneData = AddZone::all();

        return Datatables::of($addZoneData)
            ->addColumn('action', function ($model) {
                $content = \Form::open(['method' => 'DELETE', 'route' => ['add-zones.destroy', $model->gid]]);

                if (Auth::user()->ability('super-admin', 'edit-add-zone')) {
                    $content .= '<a title="Edit" href="' . action("AddZoneController@edit", [$model->gid]) . '" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></a> ';
                }

                if (Auth::user()->ability('super-admin', 'view-add-zone')) {
                    $content .= '<a title="Detail" href="' . action("AddZoneController@show", [$model->gid]) . '" class="btn btn-info btn-xs"><i class="fa fa-list"></i></a> ';
                }

                if (Auth::user()->ability('super-admin', 'delete-add-zone')) {
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
        $pageTitle = "Add Address Zone";

        return view('add-zones.add', compact('pageTitle'));
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
            'name' => 'required|unique:addzone,name',
            'addrzn' => 'required|unique:addzone,addrzn',
            'value' => 'required|numeric|unique:addzone,value',
        ]);

        $addZone = new AddZone();
        $addZone->name = $request->name ? $request->name : null;
        $addZone->addrzn = $request->addrzn ? $request->addrzn : null;
        $addZone->value = $request->value ? $request->value : null;
        $addZone->save();

        Flash::success('Adddress zone added successfully');

        return redirect()->action('AddZoneController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $addZone = AddZone::find($id);

        if ($addZone) {
            $pageTitle = "Address Zone Details";

            return view('add-zones.show', compact('pageTitle', 'addZone'));
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
        $addZone = AddZone::find($id);

        if ($addZone) {
            $pageTitle = "Edit Address Zone";

            return view('add-zones.edit', compact('pageTitle', 'addZone'));
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
        $addZone = AddZone::find($id);

        if ($addZone) {
            $this->validate($request, [
                'name' => 'required|unique:addzone,name,' . $id,
                'addrzn' => 'required|unique:addzone,addrzn,' . $id,
                'value' => 'required|numeric|unique:addzone,value,' . $id,
            ]);

            $addZone->name = $request->name ? $request->name : null;
            $addZone->addrzn = $request->addrzn ? $request->addrzn : null;
            $addZone->value = $request->value ? $request->value : null;
            $addZone->save();

            Flash::success('Address zone updated successfully');
            return redirect()->action('AddZoneController@index');
        } else {
            Flash::error('Failed to update address zone');
            return redirect()->action('AddZoneController@index');
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
        $addZone = AddZone::find($id);

        if ($addZone) {
            $addZone->delete();

            Flash::success('Address zone deleted successfully');
            return redirect()->action('AddZoneController@index');
        } else {
            Flash::error('Failed to delete address zone');
            return redirect()->action('AddZoneController@index');
        }
    }
}
