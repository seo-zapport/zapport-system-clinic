<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Employeesmedical;
use App\Generic;
use App\Medicine;
use Illuminate\Http\Request;

class EmployeesmedicalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 
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

        $this->employeesMedicalValidation();

        if (!empty($request->generic_id) && !empty($request->brand_id)) {

        $counter = count($request->generic_id);

        $arr = array();
        for ($i = 0; $i < $counter; $i++) {
            $arr[] = Medicine::where('generic_id', $request->generic_id[$i][$i])
                             ->where('brand_id', $request->brand_id[$i][$i])
                             ->where('expiration_date', '>', NOW())
                             ->where('availability', 0)
                             ->take($request->quantity[$i][$i])->orderBy('id', 'asc')->get();
        }

        }else{
            $newRecord              = new Employeesmedical;
            $newRecord->user_id     = auth()->user()->id;
            $newRecord->employee_id = $request->employee_id;
            $newRecord->diagnosis   = $request->diagnosis;
            $newRecord->note        = $request->note;
            $newRecord->status      = $request->status;
            $newRecord->remarks     = $request->remarks;
            $newRecord->save();

            return back();
        }

        for ($c = 0; $c < count($arr); $c++) { 

                $newRecord              = new Employeesmedical;
                $newRecord->user_id     = auth()->user()->id;
                $newRecord->employee_id = $request->employee_id;
                $newRecord->quantity    = $request->quantity[$c][$c];
                $newRecord->diagnosis   = $request->diagnosis;
                $newRecord->note        = $request->note;
                $newRecord->status      = $request->status;
                $newRecord->remarks     = $request->remarks;
                $newRecord->save();
                $data = $newRecord->id;

            foreach ($arr[$c] as $medQty) {
                $medQty->availability = 1;
                $medQty->save();
                $data2 = $medQty->employeesMedical()->attach($data);
            }

        }

        return back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employeesmedical  $employeesmedical
     * @return \Illuminate\Http\Response
     */
    public function show(Employeesmedical $employeesmedical)
    {
        // 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employeesmedical  $employeesmedical
     * @return \Illuminate\Http\Response
     */
    public function edit(Employeesmedical $employeesmedical)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employeesmedical  $employeesmedical
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employeesmedical $employeesmedical)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employeesmedical  $employeesmedical
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employeesmedical $employeesmedical)
    {
        //
    }

    // Lists of Employee
    public function listofEmployee(Request $request)
    {
        $emps = Employee::where('emp_id', 'like', '%'.$request->search.'%')
                        ->orWhere('last_name', 'like', '%'.$request->search.'%')
                        ->orWhere('first_name', 'like', '%'.$request->search.'%')
                        ->orWhere('middle_name', 'like', '%'.$request->search.'%')->orderBy('last_name', 'asc')->paginate(10);
        return view('medical.employeesMedical.listofemployee', compact('emps'));
    }

    // Show Employee details
    public function employeeinfo(Employee $employee)
    {
        $gens = Generic::orderBy('gname', 'asc')->get();
        $meds = Medicine::get();
        return view('medical.employeesMedical.employeeInfo', compact('employee', 'gens', 'meds'));
    }

    public function getMedBrand($id)
    {
        // $gen = Generic::find($id);
        // $brand_id = $gen->medbrand->pluck('bname', 'id');

        $gen = Generic::find($id);
        $data = array();
        $data['brand_id'] = $gen->medbrand->pluck('bname', 'id');

        // $data['id'] = Medicine::where('generic_id', $id)->where('availability', 0)->where('expiration_date', '>', NOW())->count();
        return json_encode($data);
    }

    public function getMedGenBrd($generic_id, $brand_id)
    {
        $dataCount = Medicine::where('generic_id', $generic_id)->where('brand_id', $brand_id)->where('availability', 0)->where('expiration_date', '>', NOW())->count();
        return json_encode($dataCount);
    }

    public function employeesMedicalValidation()
    {
        return request()->validate([
            // 'user_id'       =>  ['required'],
            'employee_id'   =>  ['required'],
            'diagnosis'     =>  ['required'],
            'note'          =>  ['required'],
            'status'        =>  ['required'],
            'remarks'       =>  ['required'],
        ]);
    }

}
