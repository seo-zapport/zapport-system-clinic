<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use App\User_role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserRoleController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('isAdmin')) {
            $users = User::orderBy('id', 'asc')->get();

            $roles = Role::get();

            $userRoles = User_role::get();

            // Exclude User with Role

            $arr = array();

            foreach ($userRoles as $userRole) {
                $arr[] = $userRole->user_id;
            }

            $noRoles = User::whereNotIn('id', $arr)->get();

            return view('admin.userRoles.index', compact('users', 'roles', 'noRoles', 'noUsers'));
        }else{
            abort(403, "Hindi ka admin bitch!");
        }
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
        if (Gate::allows('isAdmin')) {
            $this->validateUserRoles();
            $user_id = request()->input('user_id');
            $user = User::find($user_id);
            $roles_id = request()->input('role_id');
            $user->roles()->attach($roles_id);

            return back();
        }else{
            abort(403, "Hindi ka admin bitch!");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User_role  $user_role
     * @return \Illuminate\Http\Response
     */
    public function show(User_role $user_role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User_role  $user_role
     * @return \Illuminate\Http\Response
     */
    public function edit(User_role $user_role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User_role  $user_role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User_role $user_role, $user_id, $role_id)
    {
        if (Gate::allows('isAdmin')) {
            $atts = $this->validateUserRoles();
            $user = User::find($user_id);
            $user->roles()->updateExistingPivot($role_id, $atts);
            return back();
        }else{
            abort(403, "Hindi ka admin bitch!");
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User_role  $user_role
     * @return \Illuminate\Http\Response
     */
    public function destroy(User_role $user_role)
    {
        // 
    }

    public function validateUserRoles()
    {
        return request()->validate([
            'user_id'   =>  'required',
            'role_id'   =>  'required',
        ]);
    }
}
