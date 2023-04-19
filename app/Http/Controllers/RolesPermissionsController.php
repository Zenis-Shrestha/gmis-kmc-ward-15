<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use DB;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class RolesPermissionsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('ability:super-admin,assign-permissions', ['only' => ['index', 'store']]);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $pageTitle = 'Permissions';

        $roles = Role::where('name', '!=', 'super-admin')->get();
        $permissions = Permission::all();

        $query = 'SELECT * FROM permission_role';
        $results = DB::select($query);

        $role_perm = array();

        foreach ($results as $row) {
            $role_perm[$row->role_id][] = $row->permission_id;
        }

        return view('roles_permissions.index', compact('pageTitle', 'roles', 'permissions', 'role_perm'));
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $roles = Role::where('name', '!=', 'super-admin')->get();

        foreach ($roles as $role) {
            $permissions_sync = isset($input['roles'][$role->id]) ? $input['roles'][$role->id]['permissions'] : [];

            $role->perms()->sync($permissions_sync);
        }

        Flash::success('Permissions successfully updated');

        return redirect('role_permission');
    }
}
