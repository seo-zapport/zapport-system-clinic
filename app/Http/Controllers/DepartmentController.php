<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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
            $deps = Department::orderBy('id', 'desc')->get();
            return view('hr.department.index', compact('deps'));
        }else{
            abort(403, 'You are not Authorized on this page!');
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
            return view('hr.department.create');
        }else{
            abort(403, 'You are not Authorized on this page!');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isHr')) {
            $atts = $this->departmentValidation();
            Department::create($atts);
            return back();
        }else{
            abort(403, 'You are not Authorized on this page!');
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
        //
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
        //
    }

    public function departmentValidation()
    {
        return request()->validate([
            'department'    =>  ['required', 'unique:departments'],
        ]);
    }
}
