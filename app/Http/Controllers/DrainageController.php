<?php

namespace App\Http\Controllers;

use App\Drainage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;
use Datatables;

class DrainageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('ability:super-admin,list-drainages', ['only' => ['index']]);
        $this->middleware('ability:super-admin,view-drainage', ['only' => ['show']]);
        $this->middleware('ability:super-admin,add-drainage', ['only' => ['add', 'store']]);
        $this->middleware('ability:super-admin,edit-drainage', ['only' => ['edit', 'update']]);
        $this->middleware('ability:super-admin,delete-drainage', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "Drainage List";

        return view('drainages.index', compact('pageTitle'));
    }

    /**
     * Get the data to populate the datatable in the view
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Yajra\Datatables\Datatables
     */
    public function getData(Request $request)
    {
        $drainageData = Drainage::all();

        return Datatables::of($drainageData)
            ->addColumn('action', function ($model) {
                $content = \Form::open(['method' => 'DELETE', 'route' => ['drainages.destroy', $model->id]]);

                if (Auth::user()->ability('super-admin', 'edit-drainage')) {
                    $content .= '<a title="Edit" href="' . action("DrainageController@edit", [$model->id]) . '" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></a> ';
                }

                if (Auth::user()->ability('super-admin', 'view-drainage')) {
                    $content .= '<a title="Detail" href="' . action("DrainageController@show", [$model->id]) . '" class="btn btn-info btn-xs"><i class="fa fa-list"></i></a> ';
                }

                if (Auth::user()->ability('super-admin', 'delete-drainage')) {
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
        $pageTitle = "Add Drainage";

        return view('drainages.add', compact('pageTitle'));
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
            'name' => 'required|unique:toilet_waste_drainage,name',
            'value' => 'required|numeric|unique:toilet_waste_drainage,value',
        ]);

        $drainage = new Drainage();
        $drainage->name = $request->name ? $request->name : null;
        $drainage->value = $request->value ? $request->value : null;
        $drainage->save();

        Flash::success('Drainage added successfully');

        return redirect()->action('DrainageController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $drainage = Drainage::find($id);

        if ($drainage) {
            $pageTitle = "Drainage Details";

            return view('drainages.show', compact('pageTitle', 'drainage'));
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
        $drainage = Drainage::find($id);

        if ($drainage) {
            $pageTitle = "Edit Drainage";

            return view('drainages.edit', compact('pageTitle', 'drainage'));
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
        $drainage = Drainage::find($id);

        if ($drainage) {
            $this->validate($request, [
                'name' => 'required|unique:toilet_waste_drainage,name,' . $id,
                'value' => 'required|numeric|unique:toilet_waste_drainage,value,' . $id,
            ]);

            $drainage->name = $request->name ? $request->name : null;
            $drainage->value = $request->value ? $request->value : null;
            $drainage->save();

            Flash::success('Drainage updated successfully');
            return redirect()->action('DrainageController@index');
        } else {
            Flash::error('Failed to update drainage');
            return redirect()->action('DrainageController@index');
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
        $drainage = Drainage::find($id);

        if ($drainage) {
            $drainage->delete();

            Flash::success('Drainage deleted successfully');
            return redirect()->action('DrainageController@index');
        } else {
            Flash::error('Failed to delete drainage');
            return redirect()->action('DrainageController@index');
        }
    }
}
