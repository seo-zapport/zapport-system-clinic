<?php

namespace App\Http\Controllers;

use App\User;
use App\Employee;
use App\Department;
use Illuminate\Http\Request;

class EmployeesProfileController extends Controller
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
        if (empty(auth()->user()->employee)) {
            return view('profile.index');
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
        return view('profile.create');
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
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee, User $user)
    {
        $this->authorize('view', $employee);
        return view('profile.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        if (empty(auth()->user()->employee)) {
            $userID = auth()->user()->id;
            $emp = $employee::find($request->input('id'));
            $emp->user_id = $userID;
            $emp->save();
            return redirect('employees/profile/employee/'.$emp->emp_id);
        }else{
            $emp = auth()->user()->employee->emp_id;
            return redirect('employees/profile/employee/'.$emp);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
    }

    public function searchResult(Request $request)
    {
        if (empty(auth()->user()->employee)) {
            $atts = $this->validateEmployeeID();
            $emp = Employee::where('emp_id', $atts)->where('user_id', null)->get();

            if (count($emp) >= 1) {
                return view('profile.edit', compact('emp'));
            }else{
                return back()->with('noResult', 'No Result Found! Or Employee Number Already Belongs To A User');
            }
        }else{
            $emp = auth()->user()->employee->emp_id;
            return redirect('employees/profile/employee/'.$emp);
        }
    }

    public function validateEmployeeID()
    {
        return request()->validate([
            'emp_id' => 'required'
        ],
        [
            'emp_id.required' => 'Employee ID is required!'
        ]);
    }
}