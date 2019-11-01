<?php

namespace App\Http\Controllers;

use App\Generic;
use App\Employee;
use App\Medicine;
use App\Diagnosis;
use App\Employeesmedical;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Repositories\NotificationRepository;

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

            $emps2 = Employee::where('employee_type', 0)->get();

        }
        if(Gate::allows('isBanned')) {
            Auth::logout();

            return back()->with('message', 'You\'re not employee!');
        }

        if (auth()->user()->employee) {
            $findEmployee = auth()->user();
            $employee = $findEmployee->employee->id;
            $empMed = Employeesmedical::where('employee_id', $employee);


            if (!empty($request->search)) {
                $diagnosis = Diagnosis::where('diagnosis', $request->search)->first();

                if ($diagnosis != null) {
                    $search = $empMed->where('diagnosis_id', $diagnosis->id)->orderBy('id', 'desc')->paginate(10);
                }

                $search = $empMed->paginate(10);

                $search->appends(['search' => $request->search]);
                $result = $request->search;

            }else{
                $search = $empMed->paginate(10);
            }

            $gens = Generic::orderBy('gname', 'asc')->get();
            $meds = Medicine::get();
        }

        return view('admin.dashboard', compact('empMeds', 'emps', 'notSeen', 'employee', 'gens', 'meds', 'search', 'result', 'emps2'));
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
    public function show(Employee $employee, Employeesmedical $employeesmedical)
    {
        $this->authorize('view', $employee);
        $unique = $employeesmedical->medicines->unique(function ($item) {
            return $item->pivot['created_at']->format('M d, Y H:i').$item['brand_id'].$item['generic_id'].$item->pivot['quantity'];
        });

        $empMeds =  $unique->values()->all();

        $gens = Generic::orderBy('gname', 'asc')->get();
        $meds = Medicine::get();

        return view('admin.show', compact('employee', 'employeesmedical', 'empMeds', 'gens', 'meds'));
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

    public function notification(Request $request, NotificationRepository $notification)
    {
        if ($request->ajax()) {
            $notifications = $notification->getNotificationList();
            return response()->json($notifications);
        }
    }

}
