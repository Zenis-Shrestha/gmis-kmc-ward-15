<?php

namespace App\Http\Controllers;

use App\YesNo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;
use Datatables;

class YesNoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('ability:super-admin,list-yes-nos', ['only' => ['index']]);
        $this->middleware('ability:super-admin,view-yes-no', ['only' => ['show']]);
        $this->middleware('ability:super-admin,add-yes-no', ['only' => ['add', 'store']]);
        $this->middleware('ability:super-admin,edit-yes-no', ['only' => ['edit', 'update']]);
        $this->middleware('ability:super-admin,delete-yes-no', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "Yes No Status List";

        return view('yes-nos.index', compact('pageTitle'));
    }

    /**
     * Get the data to populate the datatable in the view
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Yajra\Datatables\Datatables
     */
    public function getData(Request $request)
    {
        $yesNoData = YesNo::all();

        return Datatables::of($yesNoData)
            ->addColumn('action', function ($model) {
                $content = \Form::open(['method' => 'DELETE', 'route' => ['yes-nos.destroy', $model->id]]);

                if (Auth::user()->ability('super-admin', 'edit-yes-no')) {
                    $content .= '<a title="Edit" href="' . action("YesNoController@edit", [$model->id]) . '" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></a> ';
                }

                if (Auth::user()->ability('super-admin', 'view-yes-no')) {
                    $content .= '<a title="Detail" href="' . action("YesNoController@show", [$model->id]) . '" class="btn btn-info btn-xs"><i class="fa fa-list"></i></a> ';
                }

                if (Auth::user()->ability('super-admin', 'delete-yes-no')) {
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
        $pageTitle = "Add Yes No Status";

        return view('yes-nos.add', compact('pageTitle'));
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
            'name' => 'required|unique:yes_no,name',
            'value' => 'required|numeric|unique:yes_no,value',
        ]);

        $yesNo = new YesNo();
        $yesNo->name = $request->name ? $request->name : null;
        $yesNo->value = $request->value ? $request->value : null;
        $yesNo->save();

        Flash::success('Yes no status added successfully');

        return redirect()->action('YesNoController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $yesNo = YesNo::find($id);

        if ($yesNo) {
            $pageTitle = "Yes No Status Details";

            return view('yes-nos.show', compact('pageTitle', 'yesNo'));
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
        $yesNo = YesNo::find($id);

        if ($yesNo) {
            $pageTitle = "Edit Yes No Status";

            return view('yes-nos.edit', compact('pageTitle', 'yesNo'));
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
        $yesNo = YesNo::find($id);

        if ($yesNo) {
            $this->validate($request, [
                'name' => 'required|unique:yes_no,name,' . $id,
                'value' => 'required|numeric|unique:yes_no,value,' . $id,
            ]);

            $yesNo->name = $request->name ? $request->name : null;
            $yesNo->value = $request->value ? $request->value : null;
            $yesNo->save();

            Flash::success('Yes no status updated successfully');
            return redirect()->action('YesNoController@index');
        } else {
            Flash::error('Failed to update yes no status');
            return redirect()->action('YesNoController@index');
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
        $yesNo = YesNo::find($id);

        if ($yesNo) {
            $yesNo->delete();

            Flash::success('Yes no status deleted successfully');
            return redirect()->action('YesNoController@index');
        } else {
            Flash::error('Failed to delete yes no status');
            return redirect()->action('YesNoController@index');
        }
    }
}
