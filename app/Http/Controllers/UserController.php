<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Role;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Creating new controller instance
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('ability:super-admin,list-users', ['only' => ['index']]);
        $this->middleware('ability:super-admin,view-user', ['only' => ['show']]);
        $this->middleware('ability:super-admin,add-user', ['only' => ['add', 'store']]);
        $this->middleware('ability:super-admin,edit-user', ['only' => ['edit', 'update']]);
        $this->middleware('ability:super-admin,delete-user', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $pageTitle = "Users Lists";
        $users = User::latest('created_at')->get();
        return view('user.index', compact('pageTitle', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function add()
    {
        $pageTitle = "Add User";
        $roles = Role::where('name', '!=', 'super-admin')->pluck('display_name', 'id')->all();
        return view('user.add', compact('pageTitle', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(UserRequest $request)
    {
        $input = $request->all();
        $user = new User();
        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->password = bcrypt($input['password']);
        $user->save();

        $superAdminId = Role::where('name', 'super-admin')->first()->id;

        $request->role = array_diff($request->role, [$superAdminId]);

        $user->roles()->sync($request->role);

        return redirect('user');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $userDetail = User::findorfail($id);
        if (!$userDetail->hasRole('super-admin')) {
            $pageTitle = "User Detail";
            return view('user.show', compact('pageTitle', 'userDetail'));
        } else {
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $user = User::findorfail($id);
        if (!$user->hasRole('super-admin')) {
            $pageTitle = "Edit User";
            $roles = Role::where('name', '!=', 'super-admin')->pluck('display_name', 'id', 1)->all();
            $role_arr = array();
            foreach ($user->roles as $role) {
                $role_arr[] = $role->id;
            }
            $user->role = $role_arr;
            return view('user.edit', compact('pageTitle', 'user', 'roles', 'operators', 'role'));
        } else {
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(UserRequest $request, $id)
    {
        $user = User::findorfail($id);
        if (!$user->hasRole('super-admin')) {
            $input = $request->only(['name', 'email', 'password']);
            if ($input['password'] != '') {
                $input['password'] = bcrypt($input['password']);
            } else {
                $input['password'] = $user->password;
            }

            $user->update($input);

            $superAdminId = Role::where('name', 'super-admin')->first()->id;

            $request->role = array_diff($request->role, [$superAdminId]);

            $user->roles()->sync($request->role);

            return redirect('user');
        } else {
            abort(404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $user = User::findorfail($id);
        if (!$user->hasRole('super-admin')) {
            User::destroy($id);
            flash('Successfully Deleted');
            return redirect('user');
        } else {
            abort(404);
        }
    }
}
