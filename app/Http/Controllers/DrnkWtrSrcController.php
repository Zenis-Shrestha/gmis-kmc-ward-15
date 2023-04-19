<?php

namespace App\Http\Controllers;

use App\DrnkWtrSrc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;
use Datatables;

class DrnkWtrSrcController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('ability:super-admin,list-water-srcs', ['only' => ['index']]);
        $this->middleware('ability:super-admin,view-water-src', ['only' => ['show']]);
        $this->middleware('ability:super-admin,add-water-src', ['only' => ['add', 'store']]);
        $this->middleware('ability:super-admin,edit-water-src', ['only' => ['edit', 'update']]);
        $this->middleware('ability:super-admin,delete-water-src', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "Drinking Water Source List";

        return view('water-srcs.index', compact('pageTitle'));
    }

    /**
     * Get the data to populate the datatable in the view
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Yajra\Datatables\Datatables
     */
    public function getData(Request $request)
    {
        $drnkWtrSrcData = DrnkWtrSrc::all();

        return Datatables::of($drnkWtrSrcData)
            ->addColumn('action', function ($model) {
                $content = \Form::open(['method' => 'DELETE', 'route' => ['water-srcs.destroy', $model->id]]);

                if (Auth::user()->ability('super-admin', 'edit-water-src')) {
                    $content .= '<a title="Edit" href="' . action("DrnkWtrSrcController@edit", [$model->id]) . '" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></a> ';
                }

                if (Auth::user()->ability('super-admin', 'view-water-src')) {
                    $content .= '<a title="Detail" href="' . action("DrnkWtrSrcController@show", [$model->id]) . '" class="btn btn-info btn-xs"><i class="fa fa-list"></i></a> ';
                }

                if (Auth::user()->ability('super-admin', 'delete-water-src')) {
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
        $pageTitle = "Add Drinking Water Source";

        return view('water-srcs.add', compact('pageTitle'));
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
            'name' => 'required|unique:drinking_water_source,name',
            'value' => 'required|numeric|unique:drinking_water_source,value',
        ]);

        $drnkWtrSrc = new DrnkWtrSrc();
        $drnkWtrSrc->name = $request->name ? $request->name : null;
        $drnkWtrSrc->value = $request->value ? $request->value : null;
        $drnkWtrSrc->save();

        Flash::success('Drinking water source added successfully');

        return redirect()->action('DrnkWtrSrcController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $drnkWtrSrc = DrnkWtrSrc::find($id);

        if ($drnkWtrSrc) {
            $pageTitle = "Drinking Water Source Details";

            return view('water-srcs.show', compact('pageTitle', 'drnkWtrSrc'));
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
        $drnkWtrSrc = DrnkWtrSrc::find($id);

        if ($drnkWtrSrc) {
            $pageTitle = "Edit Drinking Water Source";

            return view('water-srcs.edit', compact('pageTitle', 'drnkWtrSrc'));
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
        $drnkWtrSrc = DrnkWtrSrc::find($id);

        if ($drnkWtrSrc) {
            $this->validate($request, [
                'name' => 'required|unique:drinking_water_source,name,' . $id,
                'value' => 'required|numeric|unique:drinking_water_source,value,' . $id,
            ]);

            $drnkWtrSrc->name = $request->name ? $request->name : null;
            $drnkWtrSrc->value = $request->value ? $request->value : null;
            $drnkWtrSrc->save();

            Flash::success('Drinking water source updated successfully');
            return redirect()->action('DrnkWtrSrcController@index');
        } else {
            Flash::error('Failed to update drinking water source');
            return redirect()->action('DrnkWtrSrcController@index');
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
        $drnkWtrSrc = DrnkWtrSrc::find($id);

        if ($drnkWtrSrc) {
            $drnkWtrSrc->delete();

            Flash::success('Drinking water source deleted successfully');
            return redirect()->action('DrnkWtrSrcController@index');
        } else {
            Flash::error('Failed to delete drinking water source');
            return redirect()->action('DrnkWtrSrcController@index');
        }
    }
}
