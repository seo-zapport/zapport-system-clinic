<?php

namespace App\Http\Controllers;

use App\Generic;
use App\Mednote;
use App\Employee;
use App\Medicine;
use App\Employeesmedical;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\EmployeesmedicalMedicineUser;
use App\Http\Requests\EmployeesmedicalRequest;

class EmployeesmedicalController extends Controller
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
    public function index(Employeesmedical $employeesmedical)
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
    public function store(EmployeesmedicalRequest $request)
    {
        // dd($request->all());
        if (Gate::allows('isAdmin') || Gate::allows('isDoctor') || Gate::allows('isNurse')) {

            $this->validate($request, $request->rules(), $request->messages());

            // $arr = array_values($request->generic_id);
            if ($request->generic_id != null && $request->brand_id && $request->quantity) {
                $arr1 = array_map( 'array_values', $request->generic_id);
                $generic_id = array_values($arr1);

                $arr2 = array_map( 'array_values', $request->brand_id);
                $brand_id = array_values($arr2);

                $arr3 = array_map( 'array_values', $request->quantity);
                $quantity = array_values($arr3);
            }
            
            if (!empty($request->generic_id) && !empty($request->brand_id) && !empty($request->quantity)) {

            $counter = count($request->generic_id);

            $arr = array();
            for ($i = 0; $i < $counter; $i++) {
                $arr[] = Medicine::where('generic_id', $generic_id[$i][0])
                                 ->where('brand_id', $brand_id[$i][0])
                                 ->where('expiration_date', '>', NOW())
                                 ->where('availability', 0)
                                 ->take($quantity[$i][0])->orderBy('id', 'asc')->get();
            }

            }else{
                $newRecord              = new Employeesmedical;
                $newRecord->user_id     = auth()->user()->id;
                $newRecord->employee_id = $request->employee_id;
                $newRecord->diagnosis   = $request->diagnosis;
                $newRecord->note        = $request->note;
                $newRecord->status      = $request->status;
                $newRecord->remarks     = $request->remarks;
                $newRecord->seen        = (Gate::check('isDoctor')) ? 1 : 0;
                $newRecord->save();

                return back();
            }

            $newRecord              = new Employeesmedical;
            $newRecord->user_id     = auth()->user()->id;
            $newRecord->employee_id = $request->employee_id;
            $newRecord->diagnosis   = $request->diagnosis;
            $newRecord->note        = $request->note;
            $newRecord->status      = $request->status;
            $newRecord->remarks     = $request->remarks;
            $newRecord->seen        = (Gate::check('isDoctor')) ? 1 : 0;
            $newRecord->save();
            $data = $newRecord->id;

            for ($c = 0; $c < count($arr); $c++) { 

                foreach ($arr[$c] as $medQty) {
                    $medQty->availability = 1;
                    $medQty->save();
                    // $data2 = $medQty->employeesMedical()->attach($data, [ 'quantity' => $request->quantity[$c][$c]]);
                    $newData = new EmployeesmedicalMedicineUser;
                    $newData->employeesmedical_id = $data;
                    $newData->medicine_id = $medQty->id;
                    $newData->user_id = auth()->user()->id;
                    $newData->quantity = $quantity[$c][0];
                    $newData->save();
                }

            }

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
     * @param  \App\Employeesmedical  $employeesmedical
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee, Employeesmedical $employeesmedical)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isHr') || Gate::allows('isDoctor') || Gate::allows('isNurse')) {

            if (Gate::check('isDoctor') && $employeesmedical->seen === 0) {
                $employeesmedical->update(['seen' => 1]);
            }

            $unique = $employeesmedical->medicines->unique(function ($item) {
                return $item->pivot['created_at']->format('M d, Y H:i').$item['brand_id'].$item['generic_id'].$item->pivot['quantity'];
            });

            $empMeds =  $unique->values()->all();

            $gens = Generic::orderBy('gname', 'asc')->get();
            $meds = Medicine::get();

            return view('medical.employeesMedical.show', compact('employee', 'employeesmedical', 'empMeds', 'gens', 'meds'));

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
    public function update(Request $request, Employee $employee, Employeesmedical $employeesmedical)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isDoctor') || Gate::allows('isNurse')) {
            $atts = $request->validate([
                'remarks'   =>  'required'
            ],
            [
                'remarks.required'   =>  'Remarks is required!'
            ]);

            $employeesmedical->update($atts);

            return back();
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
        if (Gate::allows('isAdmin') || Gate::allows('isHr') || Gate::allows('isDoctor') || Gate::allows('isNurse')) {
            // $emps = Employee::where('emp_id', 'like', '%'.$request->search.'%')
            //                 ->orWhere('last_name', 'like', '%'.$request->search.'%')
            //                 ->orWhere('first_name', 'like', '%'.$request->search.'%')
            //                 ->orWhere('middle_name', 'like', '%'.$request->search.'%')->orderBy('last_name', 'asc')->paginate(10);
            $emps = Employee::orWhere(\DB::raw("concat(emp_id, ' ', first_name, ' ', last_name, ' ', middle_name)"), 'like', '%'.$request->search.'%')
                            ->orWhere(\DB::raw("concat(emp_id, ' ', last_name, ' ', first_name, ' ', middle_name)"), 'like', '%'.$request->search.'%')->paginate(10);
            $emps->appends(['search' => $request->search]);
            $search = $request->search;
            return view('medical.employeesMedical.listofemployee', compact('emps', 'search'));
        }elseif (Gate::allows('isBanned')) {
            Auth::logout();
            return back()->with('message', 'You\'re not employee!');
        }else{
            return back();
        }
    }

    // Show Employee details
    public function employeeinfo(Request $request, Employee $employee)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isHr') || Gate::allows('isDoctor') || Gate::allows('isNurse')) {
            $empMed = Employeesmedical::where('employee_id', $employee->id);

            // if (!empty($request->search)) {
                $search = $empMed->where('diagnosis', 'like', '%'.$request->search.'%')->orderBy('id', 'desc')->paginate(10);
                $search->appends(['search' => $request->search]);
                $result = $request->search;
            // }else{
            //     $search = $empMed->paginate(10);
            // }

            // return $search;
            $gens = Generic::orderBy('gname', 'asc')->get();
            $meds = Medicine::get();
            return view('medical.employeesMedical.employeeInfo', compact('employee', 'gens', 'meds', 'search', 'result'));
        }elseif (Gate::allows('isBanned')) {
            Auth::logout();
            return back()->with('message', 'You\'re not employee!');
        }else{
            return back();
        }
    }

    public function getMedBrand($id)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isDoctor') || Gate::allows('isNurse')) {

            $gen = Generic::find($id);
            $data = array();
            $data['brand_id'] = $gen->medbrand->pluck('bname', 'id');

            // $data['id'] = Medicine::where('generic_id', $id)->where('availability', 0)->where('expiration_date', '>', NOW())->count();
            return json_encode($data);
        }elseif (Gate::allows('isBanned')) {
            Auth::logout();
            return back()->with('message', 'You\'re not employee!');
        }else{
            return back();
        }
    }

    public function getMedGenBrd($generic_id, $brand_id)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isDoctor') || Gate::allows('isNurse')) {
            $dataCount = Medicine::where('generic_id', $generic_id)->where('brand_id', $brand_id)->where('availability', 0)->where('expiration_date', '>', NOW())->count();
            return json_encode($dataCount);
        }elseif (Gate::allows('isBanned')) {
            Auth::logout();
            return back()->with('message', 'You\'re not employee!');
        }else{
            return back();
        }
    }

    public function getMedGenBrdUpdate($employee, $employeesmedical, $generic_id, $brand_id)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isDoctor') || Gate::allows('isNurse')) {
            $dataCount = Medicine::where('generic_id', $generic_id)->where('brand_id', $brand_id)->where('availability', 0)->where('expiration_date', '>', NOW())->count();
            return json_encode($dataCount);
        }elseif (Gate::allows('isBanned')) {
            Auth::logout();
            return back()->with('message', 'You\'re not employee!');
        }else{
            return back();
        }
    }

    public function storeFollowup(Request $request, Employee $employee, Employeesmedical $employeesmedical)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isDoctor') || Gate::allows('isNurse')) {
            $atts = $request->validate([
                        'followup_note'  =>  ['required']
                    ],
                    [
                        'followup_note.required' => 'Note is required!'
                    ]
                );

            if ($request->generic_id != null && $request->brand_id && $request->quantity) {
                // $arr = array_values($request->generic_id);
                $arr1 = array_map( 'array_values', $request->generic_id);
                $generic_id = array_values($arr1);

                $arr2 = array_map( 'array_values', $request->brand_id);
                $brand_id = array_values($arr2);

                $arr3 = array_map( 'array_values', $request->quantity);
                $quantity = array_values($arr3);
            }

            $data = Mednote::create($atts);

            $data->employeesMedical()->attach($employeesmedical);

            if (!empty($request->generic_id) && !empty($request->brand_id) && !empty($request->quantity)) {
                $counter = count($request->generic_id);

                $arr = array();
                for ($i = 0; $i < $counter; $i++) {
                    $arr[] = Medicine::where('generic_id', $generic_id[$i][0])
                                     ->where('brand_id', $brand_id[$i][0])
                                     ->where('expiration_date', '>', NOW())
                                     ->where('availability', 0)
                                     ->take($quantity[$i][0])->orderBy('id', 'asc')->get();
                }

                for ($c = 0; $c < count($arr); $c++) { 

                    foreach ($arr[$c] as $medQty) {
                        $medQty->availability = 1;
                        $medQty->save();
                        // $data2 = $medQty->employeesMedical()->attach($employeesmedical, ['quantity' => $request->quantity[$c][$c]]);
                        $newData = new EmployeesmedicalMedicineUser;
                        $newData->employeesmedical_id = $employeesmedical->id;
                        $newData->medicine_id = $medQty->id;
                        $newData->user_id = auth()->user()->id;
                        $newData->quantity = $quantity[$c][0];
                        $newData->save();
                    }

                }
            }

            return back();
        }elseif (Gate::allows('isBanned')) {
            Auth::logout();
            return back()->with('message', 'You\'re not employee!');
        }else{
            return back();
        }
    }
}
