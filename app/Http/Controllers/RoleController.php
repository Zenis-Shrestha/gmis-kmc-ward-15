<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Laracasts\Flash\Flash;
use Session;

class RoleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('ability:super-admin,list-roles', ['only' => ['index']]);
        $this->middleware('ability:super-admin,view-role', ['only' => ['show']]);
        $this->middleware('ability:super-admin,add-role', ['only' => ['create', 'store']]);
        $this->middleware('ability:super-admin,edit-role', ['only' => ['edit', 'update']]);
        $this->middleware('ability:super-admin,delete-role', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = __("Roles");
        $roles = Role::where('name', '!=', 'super-admin')->get();

        return view('roles.index', compact('pageTitle', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageTitle = __("Add Role");
        $url = 'roles';
        $role = null;

        if (count(Session::get('errors')) > 0) {
            $role = new Role();
            $role->name = Input::old('name');
            $role->display_name = Input::old('display_name');
        }

        return view('roles.create', [
            'pageTitle' => $pageTitle,
            'url' => $url,
            'role' => $role,
        ]);
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
            'name' => 'required|unique:roles,name',
            'display_name' => 'required',
        ]);

        $role = new Role();
        $role->name = $request->name;
        $role->display_name = $request->display_name;
        $role->save();

        Flash::success('Role added successfully');
        return redirect('roles');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        if ($role && $role->name != 'super-admin') {
            $pageTitle = __("Edit Role");
            $url = 'roles/' . $id;
            $method = 'put';

            if (count(Session::get('errors')) > 0) {
                $role = new Role();
                $role->name = Input::old('name');
                $role->display_name = Input::old('display_name');
            }

            return view('roles.create', [
                'pageTitle' => $pageTitle,
                'url' => $url,
                'role' => $role,
                'method' => $method,
            ]);
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
        $role = Role::find($id);
        if ($role && $role->name != 'super-admin') {
            $this->validate($request, [
                'name' => 'required|unique:roles,name,' . $id,
                'display_name' => 'required',
            ]);

            $role->name = $request->name ? $request->name : null;
            $role->display_name = $request->display_name ? $request->display_name : null;
            $role->save();

            Flash::success('Role updated successfully');
            return redirect('roles');
        } else {
            Flash::error('Failed to update role');
            return redirect('roles');
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
        $role = Role::find($id);

        if ($role && $role->name != 'super-admin') {
            $role->delete();

            Flash::success('Role deleted successfully');
            return redirect('roles');
        } else {
            Flash::error('Failed to delete role');
            return redirect('roles');
        }
    }
}
