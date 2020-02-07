<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Position;
use App\Department;
use App\DepartmentPosition;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\PositionRequest;

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

            $deps = Department::get();
            $arr = [];
            foreach ($deps as $dep) {
                foreach ($dep->positions as $pos) {
                    $arr[] = $pos;
                }
            }

            $positions = Position::orderBy('id', 'desc')->paginate(10);
            $positionsCount = Position::get();
            $departments = Department::orderBy('department', 'asc')->get();
            $employees = Employee::get();

            $class = ( request()->is('hr/position*') ) ?'admin-hr-position' : '';//**add Class in the body*/

            return view('hr.position.index', compact('class', 'positions', 'departments', 'employees', 'positionsCount', 'arr'));
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PositionRequest $request)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isHr')) {
            $atts = $this->validate($request, $request->rules(), $request->messages());
            $atts = $request->except('department_id');

            $check = Position::where('position', $request->position)->first();
            if (!empty($check)) {
                $data = $check;
            }else{
                $atts['position_slug'] = Str::slug($request->position, '-');
                $data = Position::create($atts);
            }

            $check2 = DepartmentPosition::where('department_id', $request->department_id)->where('position_id', $data->id)->first();
            if (!empty($check2)) {
                return back()->with('pivot_validation', 'Department and Position already exists!');
            }
            $lastID = $data->id;
            $posID['position_id'] = $lastID;
            $depID = request()->input(['department_id']);
            $dep = Department::find($depID);
            $dep->positions()->attach($posID);
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
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function show(Position $position, Department $department)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isHr')) {
            $employees = Employee::where('position_id', $position->id)->where('department_id', $department->id)->get();

            $class = ( request()->is('hr/position*') ) ?'admin-hr-position' : '';//**add Class in the body*/

            return view('hr.position.show', compact('class', 'position', 'department', 'employees'));
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
    public function update(Request $request, Position $position, Department $department)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isHr')) {
            $atts = $request->validate(
                [
                    'position'  =>  ['required', 'unique:positions,position,' . $position->id]
                ],
                [
                    'position.required' =>  'Position Name is required!',
                    'position.unique'   =>  'Position Name is already taken!',
                ]
            );
            $atts['position_slug'] = Str::slug($request->position, '-');
            $position->update($atts);

            return redirect()->route('hr.pos.show', ['position' =>  $position->position_slug, 'department'  =>  $department->department_slug]);
        }elseif (Gate::allows('isBanned')) {
            Auth::logout();
            return back()->with('message', 'You\'re not employee!');
        }else{
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function destroy(Position $position)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isHr')) {
            if (count($position->employee) > 0) {
                return back()->with('pos_message', 'You cannot delete a position with employee!');
            }
            $position->delete();
            return back();
        }elseif (Gate::allows('isBanned')) {
            Auth::logout();
            return back()->with('message', 'You\'re not employee!');
        }else{
            return back();
        }
    }
}