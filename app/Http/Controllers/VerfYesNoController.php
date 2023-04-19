<?php

namespace App\Http\Controllers;

use App\VerfYesNo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;
use Yajra\Datatables\Facades\Datatables;

class VerfYesNoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('ability:super-admin,list-verf-yes-nos', ['only' => ['index']]);
        $this->middleware('ability:super-admin,view-verf-yes-no', ['only' => ['show']]);
        $this->middleware('ability:super-admin,add-verf-yes-no', ['only' => ['add', 'store']]);
        $this->middleware('ability:super-admin,edit-verf-yes-no', ['only' => ['edit', 'update']]);
        $this->middleware('ability:super-admin,delete-verf-yes-no', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "Verification Status List";

        return view('verf-yes-nos.index', compact('pageTitle'));
    }

    /**
     * Get the data to populate the datatable in the view
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Yajra\Datatables\Datatables
     */
    public function getData(Request $request)
    {
        $verfYesNoData = VerfYesNo::all();

        return Datatables::of($verfYesNoData)
            ->addColumn('action', function ($model) {
                $content = \Form::open(['method' => 'DELETE', 'route' => ['verf-yes-nos.destroy', $model->id]]);

                if (Auth::user()->ability('super-admin', 'edit-verf-yes-no')) {
                    $content .= '<a title="Edit" href="' . action("VerfYesNoController@edit", [$model->id]) . '" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></a> ';
                }

                if (Auth::user()->ability('super-admin', 'view-verf-yes-no')) {
                    $content .= '<a title="Detail" href="' . action("VerfYesNoController@show", [$model->id]) . '" class="btn btn-info btn-xs"><i class="fa fa-list"></i></a> ';
                }

                if (Auth::user()->ability('super-admin', 'delete-verf-yes-no')) {
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
        $pageTitle = "Add Verification Status";

        return view('verf-yes-nos.add', compact('pageTitle'));
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
            'name' => 'required|unique:verf_yes_no,name',
            'value' => 'required|numeric|unique:verf_yes_no,value',
        ]);

        $verfYesNo = new VerfYesNo();
        $verfYesNo->name = $request->name ? $request->name : null;
        $verfYesNo->value = $request->value ? $request->value : null;
        $verfYesNo->save();

        Flash::success('Verification status added successfully');

        return redirect()->action('VerfYesNoController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $verfYesNo = VerfYesNo::find($id);

        if ($verfYesNo) {
            $pageTitle = "Verification Status Details";

            return view('verf-yes-nos.show', compact('pageTitle', 'verfYesNo'));
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
        $verfYesNo = VerfYesNo::find($id);

        if ($verfYesNo) {
            $pageTitle = "Edit Verification Status";

            return view('verf-yes-nos.edit', compact('pageTitle', 'verfYesNo'));
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
        $verfYesNo = VerfYesNo::find($id);

        if ($verfYesNo) {
            $this->validate($request, [
                'name' => 'required|unique:verf_yes_no,name,' . $id,
                'value' => 'required|numeric|unique:verf_yes_no,value,' . $id,
            ]);

            $verfYesNo->name = $request->name ? $request->name : null;
            $verfYesNo->value = $request->value ? $request->value : null;
            $verfYesNo->save();

            Flash::success('Verification status updated successfully');
            return redirect()->action('VerfYesNoController@index');
        } else {
            Flash::error('Failed to update verification status');
            return redirect()->action('VerfYesNoController@index');
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
        $verfYesNo = VerfYesNo::find($id);

        if ($verfYesNo) {
            $verfYesNo->delete();

            Flash::success('Verification status deleted successfully');
            return redirect()->action('VerfYesNoController@index');
        } else {
            Flash::error('Failed to delete verification status');
            return redirect()->action('VerfYesNoController@index');
        }
    }
}
