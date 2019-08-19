<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Employeesmedical;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
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
    public function index(Request $request)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isDoctor') || Gate::allows('isNurse')){

            $empMeds = Employeesmedical::where('remarks', 'followUp')->paginate(10);

        }
        if (Gate::allows('isAdmin') || Gate::allows('isDoctor')){

            $notSeen = Employeesmedical::where('seen', 0)->get();

        }
        if (Gate::allows('isAdmin') || Gate::allows('isHr') ) { 

            $emps = Employee::where('tin_no', '=', NULL)->orWhere('sss_no', '=', NULL)
                                                      ->orWhere('philhealth_no', '=', NULL)
                                                      ->orWhere('hdmf_no', '=', NULL)
                                                      ->get();

        }
        if(Gate::allows('isBanned')) {
            Auth::logout();

            return back()->with('message', 'You\'re not employee!');
        }

        return view('admin.dashboard', compact('empMeds', 'emps', 'notSeen'));
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
