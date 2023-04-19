<?php

namespace App\Http\Controllers;

use App\TaxStsCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;
use Datatables;

class TaxStsCodeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('ability:super-admin,list-tax-sts-codes', ['only' => ['index']]);
        $this->middleware('ability:super-admin,view-tax-sts-code', ['only' => ['show']]);
        $this->middleware('ability:super-admin,add-tax-sts-code', ['only' => ['add', 'store']]);
        $this->middleware('ability:super-admin,edit-tax-sts-code', ['only' => ['edit', 'update']]);
        $this->middleware('ability:super-admin,delete-tax-sts-code', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "Tax Status Code List";

        return view('tax-sts-codes.index', compact('pageTitle'));
    }

    /**
     * Get the data to populate the datatable in the view
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Yajra\Datatables\Datatables
     */
    public function getData(Request $request)
    {
        $taxStsCodeData = TaxStsCode::all();

        return Datatables::of($taxStsCodeData)
            ->addColumn('action', function ($model) {
                $content = \Form::open(['method' => 'DELETE', 'route' => ['tax-sts-codes.destroy', $model->id]]);

                if (Auth::user()->ability('super-admin', 'edit-tax-sts-code')) {
                    $content .= '<a title="Edit" href="' . action("TaxStsCodeController@edit", [$model->id]) . '" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></a> ';
                }

                if (Auth::user()->ability('super-admin', 'view-tax-sts-code')) {
                    $content .= '<a title="Detail" href="' . action("TaxStsCodeController@show", [$model->id]) . '" class="btn btn-info btn-xs"><i class="fa fa-list"></i></a> ';
                }

                if (Auth::user()->ability('super-admin', 'delete-tax-sts-code')) {
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
        $pageTitle = "Add Tax Status Code";

        return view('tax-sts-codes.add', compact('pageTitle'));
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
            'name' => 'required|unique:tax_status_code,name',
            'value' => 'required|numeric|unique:tax_status_code,value',
        ]);

        $taxStsCode = new TaxStsCode();
        $taxStsCode->name = $request->name ? $request->name : null;
        $taxStsCode->value = $request->value ? $request->value : null;
        $taxStsCode->save();

        Flash::success('Tax status code added successfully');

        return redirect()->action('TaxStsCodeController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $taxStsCode = TaxStsCode::find($id);

        if ($taxStsCode) {
            $pageTitle = "Tax Status Code Details";

            return view('tax-sts-codes.show', compact('pageTitle', 'taxStsCode'));
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
        $taxStsCode = TaxStsCode::find($id);

        if ($taxStsCode) {
            $pageTitle = "Edit Tax Status Code";

            return view('tax-sts-codes.edit', compact('pageTitle', 'taxStsCode'));
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
        $taxStsCode = TaxStsCode::find($id);

        if ($taxStsCode) {
            $this->validate($request, [
                'name' => 'required|unique:tax_status_code,name,' . $id,
                'value' => 'required|numeric|unique:tax_status_code,value,' . $id,
            ]);

            $taxStsCode->name = $request->name ? $request->name : null;
            $taxStsCode->value = $request->value ? $request->value : null;
            $taxStsCode->save();

            Flash::success('Tax status code updated successfully');
            return redirect()->action('TaxStsCodeController@index');
        } else {
            Flash::error('Failed to update tax status code');
            return redirect()->action('TaxStsCodeController@index');
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
        $taxStsCode = TaxStsCode::find($id);

        if ($taxStsCode) {
            $taxStsCode->delete();

            Flash::success('Tax status code deleted successfully');
            return redirect()->action('TaxStsCodeController@index');
        } else {
            Flash::error('Failed to delete tax status code');
            return redirect()->action('TaxStsCodeController@index');
        }
    }
}
