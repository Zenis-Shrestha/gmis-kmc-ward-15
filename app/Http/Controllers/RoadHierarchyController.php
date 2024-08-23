<?php

namespace App\Http\Controllers;

use App\RoadHierarchy;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;
use Datatables;
use Illuminate\Http\Request;

class RoadHierarchyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "Road Hierarchy List";
        return view('road-hierarchies.index', compact('pageTitle'));
    }
    public function add()
    {
        $pageTitle = "Add Road Hierarchy";

        return view('road-hierarchies.add', compact('pageTitle'));
    }

    public function getData(Request $request)
    {
        $roadHierarchyData = RoadHierarchy::all();
        return Datatables::of($roadHierarchyData)
            ->addColumn('action', function ($model) {
                $content = \Form::open(['method' => 'DELETE', 'route' => ['road-hierarchies.destroy', $model->id]]);
                if (Auth::user()->ability('super-admin', 'edit-road-hierarchy')) {
                    $content .= '<a title="Edit" href="' . action("RoadHierarchyController@edit", [$model->id]) . '" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></a> ';
                }
                if (Auth::user()->ability('super-admin', 'view-road-hierarchy')) {
                    $content .= '<a title="Detail" href="' . action("RoadHierarchyController@show", [$model->id]) . '" class="btn btn-info btn-xs"><i class="fa fa-list"></i></a> ';
                }
                if (Auth::user()->ability('super-admin', 'delete-road-hierarchy')) {
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
    public function create()
    {
        //
    }
   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $roadHierarchy = RoadHierarchy::find($id);
        if ($roadHierarchy) {
            $pageTitle = "Road Hierarchy Details";
            return view('road-hierarchies.show', compact('pageTitle', 'roadHierarchy'));
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
        $roadHierarchy = RoadHierarchy::find($id);
        if ($roadHierarchy) {
            $pageTitle = "Edit Road Hierarchy";
            return view('road-hierarchies.edit', compact('pageTitle', 'roadHierarchy'));
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
        $roadHierarchy = RoadHierarchy::find($id);

        if ($roadHierarchy) {
            $this->validate($request, [
                'name' => 'required|unique:road_hierarchy,name,' . $id,
                'value' => 'required|numeric|unique:road_hierarchy,value,' . $id,
            ]);

            $roadHierarchy->name = $request->name ? $request->name : null;
            $roadHierarchy->value = $request->value ? $request->value : null;
            $roadHierarchy->save();

            Flash::success('Road hierarchy updated successfully');
            return redirect()->action('RoadHierarchyController@index');
        } else {
            Flash::error('Failed to update road hierarchy');
            return redirect()->action('RoadHierarchyController@index');
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
        $roadHierarchy = RoadHierarchy::find($id);

        if ($roadHierarchy) {
            $roadHierarchy->delete();

            Flash::success('Road hierarchy deleted successfully');
            return redirect()->action('RoadHierarchyController@index');
        } else {
            Flash::error('Failed to delete road hierarchy');
            return redirect()->action('RoadHierarchyController@index');
        }
    }
}







// namespace App\Http\Controllers;

// use App\RoadHierarchy;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Laracasts\Flash\Flash;
// use Datatables;

// class RoadHierarchyController extends Controller
// {
//     public function __construct()
//     {
//         $this->middleware('auth');
//         $this->middleware('ability:super-admin,list-road-hierarchies', ['only' => ['index']]);
//         $this->middleware('ability:super-admin,view-road-hierarchy', ['only' => ['show']]);
//         $this->middleware('ability:super-admin,add-road-hierarchy', ['only' => ['add', 'store']]);
//         $this->middleware('ability:super-admin,edit-road-hierarchy', ['only' => ['edit', 'update']]);
//         $this->middleware('ability:super-admin,delete-road-hierarchy', ['only' => ['destroy']]);
//     }

//     /**
//      * Display a listing of the resource.
//      *
//      * @return \Illuminate\Http\Response
//      */
   

//     /**
//      * Get the data to populate the datatable in the view
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @return \Yajra\Datatables\Datatables
//      */
//     public function getData(Request $request)
//     {
//         $roadHierarchyData = RoadHierarchy::all();

//         return Datatables::of($roadHierarchyData)
//             ->addColumn('action', function ($model) {
//                 $content = \Form::open(['method' => 'DELETE', 'route' => ['road-hierarchies.destroy', $model->id]]);

//                 if (Auth::user()->ability('super-admin', 'edit-road-hierarchy')) {
//                     $content .= '<a title="Edit" href="' . action("RoadHierarchyController@edit", [$model->id]) . '" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></a> ';
//                 }

//                 if (Auth::user()->ability('super-admin', 'view-road-hierarchy')) {
//                     $content .= '<a title="Detail" href="' . action("RoadHierarchyController@show", [$model->id]) . '" class="btn btn-info btn-xs"><i class="fa fa-list"></i></a> ';
//                 }

//                 if (Auth::user()->ability('super-admin', 'delete-road-hierarchy')) {
//                     $content .= '<button title="Delete" type="submit" class="btn btn-info btn-xs" onclick="return confirm(\'Are you sure?\')">&nbsp;<i class="fa fa-trash"></i>&nbsp;</button> ';
//                 }

//                 $content .= \Form::close();
//                 return $content;
//             })
//             ->make(true);
//     }

//     /**
//      * Show the form for creating a new resource.
//      *
//      * @return \Illuminate\Http\Response
//      */
//     public function add()
//     {
//         $pageTitle = "Add Road Hierarchy";

//         return view('road-hierarchies.add', compact('pageTitle'));
//     }

//     /**
//      * Store a newly created resource in storage.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @return \Illuminate\Http\Response
//      */
//     public function store(Request $request)
//     {
//         $this->validate($request, [
//             'name' => 'required|unique:road_hierarchy,name',
//             'value' => 'required|numeric|unique:road_hierarchy,value',
//         ]);

//         $roadHierarchy = new RoadHierarchy();
//         $roadHierarchy->name = $request->name ? $request->name : null;
//         $roadHierarchy->value = $request->value ? $request->value : null;
//         $roadHierarchy->save();

//         Flash::success('Road hierarchy added successfully');

//         return redirect()->action('RoadHierarchyController@index');
//     }

//     /**
//      * Display the specified resource.
//      *
//      * @param  int  $id
//      * @return \Illuminate\Http\Response
//      */
//     public function show($id)
//     {
//         $roadHierarchy = RoadHierarchy::find($id);

//         if ($roadHierarchy) {
//             $pageTitle = "Road Hierarchy Details";

//             return view('road-hierarchies.show', compact('pageTitle', 'roadHierarchy'));
//         } else {
//             abort(404);
//         }
//     }

//     /**
//      * Show the form for editing the specified resource.
//      *
//      * @param  int  $id
//      * @return \Illuminate\Http\Response
//      */
//     public function edit($id)
//     {
//         $roadHierarchy = RoadHierarchy::find($id);

//         if ($roadHierarchy) {
//             $pageTitle = "Edit Road Hierarchy";

//             return view('road-hierarchies.edit', compact('pageTitle', 'roadHierarchy'));
//         } else {
//             abort(404);
//         }
//     }

//     /**
//      * Update the specified resource in storage.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @param  int  $id
//      * @return \Illuminate\Http\Response
//      */
//     public function update(Request $request, $id)
//     {
//         $roadHierarchy = RoadHierarchy::find($id);

//         if ($roadHierarchy) {
//             $this->validate($request, [
//                 'name' => 'required|unique:road_hierarchy,name,' . $id,
//                 'value' => 'required|numeric|unique:road_hierarchy,value,' . $id,
//             ]);

//             $roadHierarchy->name = $request->name ? $request->name : null;
//             $roadHierarchy->value = $request->value ? $request->value : null;
//             $roadHierarchy->save();

//             Flash::success('Road hierarchy updated successfully');
//             return redirect()->action('RoadHierarchyController@index');
//         } else {
//             Flash::error('Failed to update road hierarchy');
//             return redirect()->action('RoadHierarchyController@index');
//         }
//     }

//     /**
//      * Remove the specified resource from storage.
//      *
//      * @param  int  $id
//      * @return \Illuminate\Http\Response
//      */
//     public function destroy($id)
//     {
//         $roadHierarchy = RoadHierarchy::find($id);

//         if ($roadHierarchy) {
//             $roadHierarchy->delete();

//             Flash::success('Road hierarchy deleted successfully');
//             return redirect()->action('RoadHierarchyController@index');
//         } else {
//             Flash::error('Failed to delete road hierarchy');
//             return redirect()->action('RoadHierarchyController@index');
//         }
//     }
// }
