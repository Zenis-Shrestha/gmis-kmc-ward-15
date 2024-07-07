<?php

namespace App\Http\Controllers;

use App\AddZone;
use App\Building;
use App\Street;
use App\Ward;
use Box\Spout\Common\Type;
use Box\Spout\Writer\Style\Color;
use Box\Spout\Writer\Style\StyleBuilder;
use Box\Spout\Writer\WriterFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;
use Datatables;

class StreetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('ability:super-admin,list-streets', ['only' => ['index']]);
        $this->middleware('ability:super-admin,view-street', ['only' => ['show']]);
        $this->middleware('ability:super-admin,add-street', ['only' => ['add', 'store']]);
        $this->middleware('ability:super-admin,edit-street', ['only' => ['edit', 'update']]);
        $this->middleware('ability:super-admin,delete-street', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "Street List";
        $addZones = AddZone::orderBy('name')->pluck('name', 'value');

        return view('streets.index', compact('pageTitle', 'addZones'));
    }


    /**
     * Get the data to populate the datatable in the view
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Yajra\Datatables\Datatables
     */
    public function getData(Request $request)
    {
        $streetData = Street::with('addZone');

        return Datatables::of($streetData)
            ->filter(function ($query) use ($request) {
                if ($request->addrzn) {
                    $query->where('addrzn', $request->addrzn);
                }
            })
            ->addColumn('action', function ($model) {
                $content = \Form::open(['method' => 'DELETE', 'route' => ['streets.destroy', $model->id]]);

                /*if (Auth::user()->ability('super-admin', 'edit-human-resource')) {
                    $content .= '<a title="Edit" href="' . action("HumanResourceController@edit", [$model->id]) . '" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></a> ';
                }*/

                if (Auth::user()->ability('super-admin', 'view-street')) {
                    $content .= '<a title="Detail" href="' . action("StreetController@show", [$model->id]) . '" class="btn btn-info btn-xs"><i class="fa fa-list"></i></a> ';
                }

                /*if (Auth::user()->ability('super-admin', 'delete-human-resource')) {
                    $content .= '<button title="Delete" type="submit" class="btn btn-info btn-xs" onclick="return confirm(\'Are you sure?\')">&nbsp;<i class="fa fa-trash"></i>&nbsp;</button> ';
                }*/

                if (Auth::user()->ability('super-admin', 'view-map')) {
                    $content .= '<a title="Map" href="'.action("MapsController@index", ['layer'=>'street','field'=>'gid','val'=>$model->gid]).'" class="btn btn-info btn-xs"><i class="fa fa-map-marker"></i></a> ';
                }

                $content .= \Form::close();
                return $content;
            })
            ->editColumn('vflag', function ($streetData) {
                return $streetData->vflag ? 'Yes' : 'No';
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
        $pageTitle = "Add Road";
        $addZones = AddZone::orderBy('name')->pluck('name', 'value');

        return view('streets.add', compact('pageTitle', 'addZones'));
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
            'id' => 'required|unique:street,id',
        ]);

        $building = new Building();
        $building->bldgasc = $request->bldgasc ? $request->bldgasc : null;
        $building->save();

        Flash::success('Building created successfully');
        return redirect('buildings');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $street = Street::find($id);

        if ($street) {
            $pageTitle = "Road Details";

            return view('streets.show', compact('pageTitle', 'street'));
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
        $street = Street::find($id);

        if ($street) {
            $pageTitle = "Edit Road";

            return view('streets.edit', compact('pageTitle', 'street'));
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
        $street = Street::find($id);
        if ($street) {
            $this->validate($request, [
                'code' => 'required|unique:street,bin,' . $id . ',bin',
            ]);

            $building->bin = $request->bin ? $request->bin : null;
            $building->holding = $request->holding ? $request->holding : null;
            $building->taxcd = $request->taxcd ? $request->taxcd : null;
            $building->roadcd = $request->roadcd ? $request->roadcd : null;
            $building->ward = $request->ward ? $request->ward : null;
            $building->structype = $request->structype ? $request->structype : null;
            $building->flrcount = $request->flrcount ? $request->flrcount : null;
            $building->bldgarea = $request->bldgarea ? $request->bldgarea : null;
            $building->bldguse = $request->bldguse ? $request->bldguse : null;
            $building->usecatag = $request->usecatag ? $request->usecatag : null;
            $building->offcnm = $request->offcnm ? $request->offcnm : null;
            $building->bldgasc = $request->bldgasc ? $request->bldgasc : null;
            $building->save();

            Flash::success('Building updated successfully');
            return redirect('buildings');
        } else {
            Flash::error('Failed to update building');
            return redirect('buildings');
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
        $building = Building::find($id);

        if ($building) {
            $building->containments()->detach();
            $building->delete();

            Flash::success('Building deleted successfully');
            return redirect('buildings');
        } else {
            Flash::error('Failed to delete building');
            return redirect('buildings');
        }
    }

    public function export()
    {
        $searchData = isset($_GET['searchData']) ? $_GET['searchData'] : null;
        $bin = isset($_GET['bin']) ? $_GET['bin'] : null;
        $structype = isset($_GET['structype']) ? $_GET['structype'] : null;
        $ward = isset($_GET['ward']) ? $_GET['ward'] : null;

        $columns = ['bin', 'holding', 'taxcd', 'roadcd', 'ward', 'structype', 'flrcount', 'bldgarea', 'bldguse', 'usecatag', 'offcnm', 'bldgasc'];

        $query = Building::select('bin', 'holding', 'taxcd', 'roadcd', 'ward', 'structype', 'flrcount', 'bldgarea', 'bldguse', 'usecatag', 'offcnm', 'bldgasc');

        if (!empty($searchData)) {
            foreach ($columns as $column) {
                $query->orWhereRaw("lower(cast(" . $column . " AS varchar)) LIKE lower('%" . $searchData . "%')");
                //casting to varchar LOWER doesn't work on int, double precision
            }
        }

        if (!empty($bin)) {
            $query->where('bin', $bin);
        }

        if (!empty($structype)) {
            $query->where('structype', $structype);
        }

        if (!empty($ward)) {
            $query->where('ward', $ward);
        }

        $style = (new StyleBuilder())
            ->setFontBold()
            ->setFontSize(13)
            ->setBackgroundColor(Color::rgb(228, 228, 228))
            ->build();

        $writer = WriterFactory::create(Type::XLSX);
        $writer->openToBrowser('streets.xlsx')
            ->addRowWithStyle($columns, $style); //Top row of excel

        $query->chunk(5000, function ($buildings) use ($writer) {
            $writer->addRows($buildings->toArray());
        });

        $writer->close();
    }
}
