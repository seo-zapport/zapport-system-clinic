<?php

namespace App\Http\Controllers;

use App\Department;
use App\DepartmentPosition;
use App\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PositionController extends Controller
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
            $positions = Position::orderBy('id', 'desc')->get();
            $departments = Department::orderBy('department', 'asc')->get();
            return view('hr.position.index', compact('positions', 'departments'));
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
        if (Gate::allows('isAdmin') || Gate::allows('isHr')) {
            $atts = $this->positionValidation();
            $atts = $request->except('department_id');
            $data = Position::create($atts);

            $lastID = $data->id;
            $posID['position_id'] = $lastID;
            $depID = request()->input(['department_id']);
            $dep = Department::find($depID);
            // dd($dep);
            $dep->positions()->attach($posID);
            return back();
        }else{
            abort(403, 'You are not Authorized on this page!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function show(Position $position)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function edit(Position $position)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Position $position)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function destroy(Position $position)
    {
        //
    }

    public function positionValidation()
    {
        return request()->validate([
            'position'  =>  ['required', 'unique:positions'],
            'department_id'  =>  'required',
        ]);
    }
}