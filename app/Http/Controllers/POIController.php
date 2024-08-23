<?php

namespace App\Http\Controllers;

use App\Enums\PointInterestTypeUse;
use Illuminate\Http\Request;
use App\POI;
use App\Ward;
use App\TypeOf;
use Yajra\DataTables\DataTables;
use DB;
class POIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "Point of Interest";
        $name = POI::pluck('name', 'name')->all();
        $ward = Ward::pluck('ward', 'ward')->all();
        $typeUse = TypeOf::pluck('name', 'id')->all();
        return view('point-interest.index', compact('pageTitle', 'name', 'ward', 'typeUse'));
    }
    public function getData(Request $request)
    {
        $data = $request->all();
        $pointinterest = POI::select('*');
        return Datatables::of($pointinterest)
            ->filter(function ($query) use ($data) {
                if ($data['name']) {
                    $query->where('name', 'ILIKE', '%' .  $data['name'] . '%');
                }
                if ($data['ward']) {
                    $query->where('ward', 'ILIKE', '%' .  $data['ward'] . '%');
                }
                if ($data['type_use']) {
                    $query->where('type_use', 'ILIKE', '%' .  $data['type_use'] . '%');
                }
            })
            ->addColumn('action', function ($model) {
                $content = \Form::open(['method' => 'DELETE', 'route' => ['point-interest.destroy', $model->id]]);
                $content .= '<a title="Edit" href="' . action("POIController@edit", [$model->id]) . '" class="btn btn-info btn-sm mb-1"><i class="fa fa-edit"></i></a> ';
                $content .= '<a title="Detail" href="' . action("POIController@show", [$model->id]) . '" class="btn btn-info btn-sm mb-1"><i class="fa fa-list"></i></a> ';
                // $content .= '<a title="History" href="' . action("POIController@history", [$model->id]) . '" class="btn btn-info btn-sm mb-1"><i class="fa fa-history"></i></a> ';
                $content .= '<a href="#" title="Delete"  class="delete btn btn-danger btn-sm mb-1"><i class="fa fa-trash"></i></a> ';
                 $content .= '<a title="Map" href="' . action("MapsController@index", ['layer' => 'places', 'field' => 'id', 'val' => $model->id]) . '" class="btn btn-info btn-sm mb-1"><i class="fa fa-map-marker"></i></a> ';
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
    public function create()
    {
        $pageTitle = "Add Point of Interest";
        $typeUse = TypeOf::pluck('name','id');
        $ward = Ward::pluck('ward', 'ward')->all();
        asort($ward);

        return view('point-interest.create', compact('pageTitle','typeUse','ward'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pointInterest = new POI();
        $data = $request->all();
        $maxid = POI::withTrashed()->max('id');
        $pointInterest->id =  $maxid +1;
        $pointInterest->name = $data['name'] ? $data['name'] : null;
        $pointInterest->ward = $data['ward'] ? $data['ward'] : null;
        $pointInterest->type_use = $data['type_use'] ? $data['type_use'] : null;
        if ($data['longitude'] && $data['latitude']) {
            $pointInterest->geom = DB::raw("ST_GeomFromText('POINT(" . $data['longitude'] . " " . $data['latitude'] .  ")', 4326)");
        }
        dd($pointInterest);
        $pointInterest->save();
        return redirect('point-interest')->with('success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pointInterest = POI::find($id);
        if ($pointInterest) {
            $pageTitle = "Point of Interest";
            $enumValue =  (int)$pointInterest->type_use;
            $typeuse = PointInterestTypeUse::getDescription($enumValue);
            return view('point-interest.show', compact('pageTitle', 'pointInterest','typeuse'));
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
        $pointInterest = POI::find($id);
        if ($pointInterest) {
            $page_title = "Edit Point Of Interest";
            $typeUse = TypeOf::pluck('name','id');
            return view('point-interest.edit', compact('page_title', 'pointInterest','typeUse'));
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
        $pointInterest = POI::find($id);
        if ($pointInterest) {
            $pointInterest->delete();
            return redirect('point-interest')->with('success','Point Of Interest deleted successfully');

        } else {
            return redirect('point-interest')->with('error','Failed to delete Point Of Interest');
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
        //
    }
}
