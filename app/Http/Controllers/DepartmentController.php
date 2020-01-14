<?php

namespace App\Http\Controllers;

use App\Department;
use App\Http\Requests\DepartmentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class DepartmentController extends Controller
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
        if (Gate::allows('isAdmin') || Gate::allows('isHr')) {
            $deps = Department::orderBy('id', 'desc')->paginate(10);
            $depsCount = Department::get();

            $class = ( request()->is('hr/department*') ) ?'admin-hr-department' : '';//**add Class in the body*/

            return view('hr.department.index', compact('class', 'deps', 'depsCount'));
        }elseif (Gate::allows('isBanned')) {
            Auth::logout();
            return back()->with('message', 'You\'re not employee!');
        }else{
            return back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::allows('isAdmin') || Gate::allows('isHr')) {

            $class = ( request()->is('hr/department*') ) ?'admin-hr-department' : '';//**add Class in the body*/
            
            return view('hr.department.create', compact('class'));
        }elseif (Gate::allows('isBanned')) {
            Auth::logout();
            return back()->with('message', 'You\'re not employee!');
        }else{
            return back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartmentRequest $request)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isHr')) {
            $atts = $this->validate($request, $request->rules(), $request->messages());
            $replaced = Str::slug($request->department, '-');
            $atts['department_slug'] = strtolower($replaced);
            Department::create($atts);
            return back();
        }elseif (Gate::allows('isBanned')) {
            Auth::logout();
            return back()->with('message', 'You\'re not employee!');
        }else{
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isHr')) {

            $class = ( request()->is('hr/department*') ) ?'admin-hr-department' : '';//**add Class in the body*/
            
            return view('hr.department.show', compact('class','department'));
        }elseif (Gate::allows('isBanned')) {
            Auth::logout();
            return back()->with('message', 'You\'re not employee!');
        }else{
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isHr')) {
            if (count($department->positions) > 0) {
                return back()->with('dep_message', 'You cannot delete a department with positions');
            }
            $department->delete();
            return back();
        }elseif (Gate::allows('isBanned')) {
            Auth::logout();
            return back()->with('message', 'You\'re not employee!');
        }else{
            return back();
        }
    }
}
