<?php

namespace App\Http\Controllers;

use App\Mednote;
use App\Generic;
use App\Employee;
use App\Medicine;
use App\Diagnosis;
use App\Employeesmedical;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\EmployeesmedicalMedicineUser;
use App\Http\Requests\EmployeesmedicalRequest;

use File;

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
        if (Gate::allows('isAdmin') || Gate::allows('isDoctor') || Gate::allows('isNurse')) {

            $this->validate($request, $request->rules(), $request->messages());

            $findDiagnosis = Diagnosis::where('diagnosis', $request->input('diagnosis'))->first();
            if ($findDiagnosis != null) {
                $diagnosis = $findDiagnosis->id;
            }else{
                $insrtDiagnosis = Diagnosis::create(['diagnosis' => $request->diagnosis]);
                $diagnosis = $insrtDiagnosis->id;
            }

            if ($request->generic_id != null && $request->brand_id != null && $request->quantity != null) {
                $arr1 = array_map( 'array_values', $request->generic_id);
                $generic_id = array_values($arr1);

                $arr2 = array_map( 'array_values', $request->brand_id);
                $brand_id = array_values($arr2);

                $arr3 = array_map( 'array_values', $request->quantity);
                $quantity = array_values($arr3);
            }

            if ($request->hasFile('attachment')) {
                $filepath = 'public/uploaded/attachments';
                $orig_filename = pathinfo($request->attachment->getClientOriginalName(), PATHINFO_FILENAME).'-'.date("Y-m-d");
                $fileExtension = $request->file('attachment')->getClientOriginalExtension();
                $filename = 'emp_id-'.$request->employee_id.'-'.$orig_filename.'.'.$fileExtension;
                $request->file('attachment')->storeAs($filepath, $filename);
            }else{
                $filename = NULL;
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
                $newRecord                  = new Employeesmedical;
                $newRecord->user_id         = auth()->user()->id;
                $newRecord->employee_id     = $request->employee_id;
                $newRecord->diagnosis_id    = $diagnosis;
                $newRecord->note            = $request->note;
                $newRecord->status          = $request->status;
                $newRecord->remarks         = $request->remarks;
                $newRecord->attachment      = $filename;
                $newRecord->seen            = (Gate::check('isDoctor')) ? 1 : 0;
                $newRecord->save();

                return back();
            }

            $newRecord                  = new Employeesmedical;
            $newRecord->user_id         = auth()->user()->id;
            $newRecord->employee_id     = $request->employee_id;
            $newRecord->diagnosis_id    = $diagnosis;
            $newRecord->note            = $request->note;
            $newRecord->status          = $request->status;
            $newRecord->remarks         = $request->remarks;
            $newRecord->attachment      = $filename;
            $newRecord->seen            = (Gate::check('isDoctor')) ? 1 : 0;
            $newRecord->save();
            $data = $newRecord->id;

            for ($c = 0; $c < count($arr); $c++) { 

                foreach ($arr[$c] as $medQty) {
                    $medQty->availability           = 1;
                    $medQty->save();
                    $newData                        = new EmployeesmedicalMedicineUser;
                    $newData->employeesmedical_id   = $data;
                    $newData->medicine_id           = $medQty->id;
                    $newData->user_id               = auth()->user()->id;
                    $newData->quantity              = $quantity[$c][0];
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

            $this->printMedicalRecord($employee, $employeesmedical, $empMeds);

            $class = ( request()->is('medical/employees*') ) ?'admin-medical admin-med-employees employee-medical-diagnosis' : '';//**add Class in the body*/

            return view('medical.employeesMedical.show', compact('class', 'employee', 'employeesmedical', 'empMeds', 'gens', 'meds'));

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
            $emps = Employee::orWhere(\DB::raw("concat(emp_id, ' ', first_name, ' ', last_name, ' ', middle_name)"), 'like', '%'.$request->search.'%')
                            ->orWhere(\DB::raw("concat(emp_id, ' ', last_name, ' ', first_name, ' ', middle_name)"), 'like', '%'.$request->search.'%')->paginate(10);
            $emps->appends(['search' => $request->search]);
            $search = $request->search;
            $countEmp = Employee::get();

            $class = ( request()->is('medical/employees*') ) ?'admin-medical admin-med-employees' : '';//**add Class in the body*/

            return view('medical.employeesMedical.listofemployee', compact('class', 'emps', 'search', 'countEmp'));
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
            $empMed = Employeesmedical::where('employee_id', $employee->id)->orderBy('id', 'desc');

            if (!empty($request->search)) {
                $diagnosis = Diagnosis::where('diagnosis', $request->search)->first();

                if ($diagnosis != null) {
                    $search = $empMed->where('diagnosis_id', $diagnosis->id)->paginate(10);
                }

                $search = $empMed->paginate(10);
                $search->appends(['search' => $request->search]);
                $result = $request->search;

            }else{
                $search = $empMed->paginate(10);
            }

            $gens = Generic::orderBy('gname', 'asc')->get();
            $meds = Medicine::get();

            $class = ( request()->is('medical/employees*') ) ?'admin-medical admin-med-employees employee-info' : '';//**add Class in the body*/

            return view('medical.employeesMedical.employeeInfo', compact('class', 'employee', 'gens', 'meds', 'search', 'result'));
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

            if ($request->generic_id != null && $request->brand_id != null && $request->quantity != null) {
                $arr1 = array_map( 'array_values', $request->generic_id);
                $generic_id = array_values($arr1);

                $arr2 = array_map( 'array_values', $request->brand_id);
                $brand_id = array_values($arr2);

                $arr3 = array_map( 'array_values', $request->quantity);
                $quantity = array_values($arr3);
            }

            if ($request->hasFile('attachment')) {
                $filepath = 'public/uploaded/attachments';
                $orig_filename = pathinfo($request->attachment->getClientOriginalName(), PATHINFO_FILENAME).'-'.date("Y-m-d");
                $fileExtension = $request->file('attachment')->getClientOriginalExtension();
                $filename = $orig_filename.'.'.$fileExtension;
                $request->file('attachment')->storeAs($filepath, $filename);
            }else{
                $filename = NULL;
            }

            $atts['attachment'] = $filename;

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

    public function download($file_name)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isDoctor') || Gate::allows('isNurse') || Gate::allows('isHr')) {
            return response()->download(storage_path("app/public/uploaded/attachments/".$file_name));
        }elseif (Gate::allows('isBanned')) {
            Auth::logout();
            return back()->with('message', 'You\'re not employee!');
        }else{
            return back();
        }
    }

    public function EmployeesWithRecord(Request $request)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isDoctor') || Gate::allows('isNurse')) {
            $emps = Employee::join('employeesmedicals', 'employees.id', 'employeesmedicals.employee_id')
                            ->select('emp_id', 'first_name', 'last_name', 'middle_name', 'department_id', 'position_id')
                            ->groupBy('emp_id', 'first_name', 'last_name', 'middle_name', 'department_id', 'position_id')
                            ->distinct('emp_id')
                            ->orWhere(\DB::raw("concat(emp_id, ' ', first_name, ' ', last_name, ' ', middle_name)"), 'like', '%'.$request->search.'%')
                            ->orWhere(\DB::raw("concat(emp_id, ' ', last_name, ' ', first_name, ' ', middle_name)"), 'like', '%'.$request->search.'%')
                            ->paginate(10);
            $emps->appends(['search' => $request->search]);
            $search = $request->search;
            $totalEmps = Employee::join('employeesmedicals', 'employees.id', 'employeesmedicals.employee_id')
                            ->select('emp_id', 'first_name', 'last_name', 'middle_name', 'department_id', 'position_id')
                            ->groupBy('emp_id', 'first_name', 'last_name', 'middle_name', 'department_id', 'position_id')
                            ->distinct('emp_id')
                            ->get();

            $class = ( request()->is('medical/employees*') ) ?'admin-medical admin-med-employees medical-record' : '';//**add Class in the body*/

            return view('medical.employeesMedical.employeesWithRecord', compact('class', 'emps', 'search', 'totalEmps'));
        }else{
            return back();
        }
    }

    public function fullReport()
    {
        $emps = Employeesmedical::join('diagnoses', 'diagnoses.id', 'employeesmedicals.diagnosis_id')
                                ->join('employees', 'employees.id', 'employeesmedicals.employee_id')
                                // ->select('employeesmedicals.id', 'employees.gender', 'diagnosis', 'employeesmedicals.created_at', \DB::raw('floor(DATEDIFF(CURDATE(),employees.birthday) /365) as old_age'))
                                ->select('employeesmedicals.id', 'employees.gender', 'diagnosis', 'employeesmedicals.created_at', \DB::raw('TIMESTAMPDIFF(YEAR,birthday,NOW()) as age'))
                                ->orderBy('employeesmedicals.created_at', 'desc')
                                ->get()
                                ->groupBy(function($date) {
                                    return Carbon::parse($date->created_at)->format('Y');
                                  });
                                // dd($emps);

            $class = ( request()->is('medical/employees*') ) ?'admin-medical admin-med-employees' : '';//**add Class in the body*/

        return view('medical.employeesMedical.fullReport', compact('class', 'diagnoses', 'arr', 'arr_count', 'emps'));
    }

    public function printMedicalRecord($employee, $employeesmedical, $empMeds){

        $relPath = 'storage/uploaded/print/medrecord/';
        if (!file_exists($relPath)) {
            mkdir($relPath, 777, true);
        }
        $datamedrec = view('medical.employeesMedical.printmedrecord',compact('employee','employeesmedical','empMeds'))->render();
        File::put(public_path('/storage/uploaded/print/medrecord/emp-med-record.html'),$datamedrec); 

    }
}