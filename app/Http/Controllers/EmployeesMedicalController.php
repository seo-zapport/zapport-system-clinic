<?php

namespace App\Http\Controllers;

use File;
use App\Supgen;
use App\Supply;
use App\Disease;
use App\Generic;
use App\Mednote;
use App\Bodypart;
use App\Employee;
use App\Medicine;
use App\Diagnosis;
use App\Employeesmedical;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\EmployeesmedicalSupplyUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\EmployeesmedicalMedicineUser;
use App\Http\Requests\GetSupplyRequest;
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
        if (Gate::allows('isAdmin') || Gate::allows('isDoctor') || Gate::allows('isNurse')) {

            $this->validate($request, $request->rules(), $request->messages());
            $dtm = \carbon\carbon::now();

            if (Employeesmedical::whereNotNull('diagnosis_id')->orderBy('id', 'desc')->count() > 0) {
                $getID = Employeesmedical::whereNotNull('diagnosis_id')->orderBy('id', 'desc')->count();
                $lastID = str_pad($getID+1, 6, '0', STR_PAD_LEFT);
            }else{
                $lastID = str_pad(1, 6, '0', STR_PAD_LEFT);
            }

            // Find Diagnosis
            $findDiagnosis = Diagnosis::where('diagnosis', $request->input('diagnosis'))->first();
            if ($findDiagnosis != null) {
                $diagnosis = $findDiagnosis->id;
            }else{
                $newDiagnosis               =   new Diagnosis;
                $newDiagnosis->disease_id   =   $request->disease_id;
                $newDiagnosis->diagnosis    =   $request->diagnosis;
                $newDiagnosis->save();
                $diagnosis = $newDiagnosis->id;
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

            $newRecord                  = new Employeesmedical;
            $newRecord->user_id         = auth()->user()->id;
            $newRecord->employee_id     = $request->employee_id;
            $newRecord->diagnosis_id    = $diagnosis;
            $newRecord->note            = $request->note;
            $newRecord->status          = "walkin";
            $newRecord->remarks         = $request->remarks;
            $newRecord->attachment      = $filename;
            $newRecord->seen            = (Gate::check('isDoctor')) ? 1 : 0;
            $newRecord->med_num         = $lastID;
            $newRecord->save();
            $data = $newRecord->id;
            // medicines
            if ($request->generic_id != null && $request->brand_id != null && $request->quantity[0][0] != null) {
                $arr1 = array_map( 'array_values', $request->generic_id);
                $generic_id = array_values($arr1);
                $arr2 = array_map( 'array_values', $request->brand_id);
                $brand_id = array_values($arr2);
                $arr3 = array_map( 'array_values', $request->quantity);
                $quantity = array_values($arr3);

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
                        $medQty->availability           = 1;
                        $medQty->save();
                        $newData                        = new EmployeesmedicalMedicineUser;
                        $newData->employeesmedical_id   = $data;
                        $newData->medicine_id           = $medQty->id;
                        $newData->user_id               = auth()->user()->id;
                        $newData->quantity              = $quantity[$c][0];
                        $newData->created_at            = $dtm;
                        $newData->updated_at            = $dtm;
                        $newData->save();
                    }
                }

            }
            // Supplies
            if ($request->supgen_id != null && $request->supbrand_id != null && $request->supqty[0][0] != null) {
                $arr4 = array_map( 'array_values', $request->supgen_id);
                $supgen_id = array_values($arr4);
                $arr5 = array_map( 'array_values', $request->supbrand_id);
                $supbrand_id = array_values($arr5);
                $arr6 = array_map( 'array_values', $request->supqty);
                $supqty = array_values($arr6);

                $counter2 = count($request->supgen_id);
                $arrSup = array();
                for ($i = 0; $i < $counter2; $i++) {
                    $arrSup[] = Supply::where('supgen_id', $supgen_id[$i][0])
                                      ->where('supbrand_id', $supbrand_id[$i][0])
                                      ->where(function($exp_date){
                                        $exp_date->where('expiration_date', '>', NOW())
                                                 ->orWhere('expiration_date', NULL);
                                      })
                                      ->where('availability', 0)
                                      ->take($supqty[$i][0])->orderBy('id', 'asc')->get();
                }
                for ($c = 0; $c < count($arrSup); $c++) { 

                    foreach ($arrSup[$c] as $supQty) {
                        $supQty->availability           = 1;
                        $supQty->save();
                        $newData2                        = new EmployeesmedicalSupplyUser;
                        $newData2->employeesmedical_id   = $data;
                        $newData2->supply_id             = $supQty->id;
                        $newData2->user_id               = auth()->user()->id;
                        $newData2->supqty                = $supqty[$c][0];
                        $newData2->created_at            = $dtm;
                        $newData2->updated_at            = $dtm;
                        $newData2->save();
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

            $class = ( request()->is('medical/employees/*') ) ?'admin-medical-emp' : '';//**add Class in the body*/

            return view('medical.employeesMedical.show', compact('employee', 'employeesmedical', 'empMeds', 'gens', 'meds', 'class'));

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
            return view('medical.employeesMedical.listofemployee', compact('emps', 'search', 'countEmp'));
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
            $empMed = Employeesmedical::where('employee_id', $employee->id)->whereNotNull('diagnosis_id')->orderBy('id', 'desc');

            if (!empty($request->search)) {
                $diagnosis = Diagnosis::where('diagnosis', $request->search)->first();

                if ($diagnosis != null) {
                    $printsearch = $empMed->where('diagnosis_id', $diagnosis->id)->get();
                    $search = $empMed->where('diagnosis_id', $diagnosis->id)->paginate(10);
                }

                $printsearch = $empMed->get();    
                $search = $empMed->paginate(10);
                $search->appends(['search' => $request->search]);
                $result = $request->search;

            }else{
                $printsearch = $empMed->get();
                $search = $empMed->paginate(10);
            }

            $gens = Generic::orderBy('gname', 'asc')->get();
            $supplies = Supgen::orderBy('name')->get();
            $meds = Medicine::get();

            $bparts = Bodypart::get();
            $diseases = Disease::get();

            $this->printEmpMedinfo($employee, $printsearch);

             $class = ( request()->is('medical/employees/*') ) ?'admin-medical-emp' : '';//**add Class in the body*/

            return view('medical.employeesMedical.employeeInfo', compact('employee', 'gens', 'meds', 'search', 'result', 'bparts', 'diseases', 'class', 'supplies'));
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

            $dtm = \Carbon\carbon::now();

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
                        $newData->created_at = $dtm;
                        $newData->updated_at = $dtm;
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
        if (Gate::allows('isAdmin') || Gate::allows('isDoctor') || Gate::allows('isNurse') || Gate::allows('isHr')) {
            $emps = Employee::join('employeesmedicals', 'employees.id', 'employeesmedicals.employee_id')
                            ->select('emp_id', 'first_name', 'last_name', 'middle_name', 'department_id', 'position_id', 'employeesmedicals.med_num')
                            ->groupBy('emp_id', 'first_name', 'last_name', 'middle_name', 'department_id', 'position_id', 'employeesmedicals.med_num')
                            ->distinct('emp_id')
                            ->orWhere(\DB::raw("concat(emp_id, ' ', first_name, ' ', last_name, ' ', middle_name)"), 'like', '%'.$request->search.'%')
                            ->whereNotNull('med_num')
                            ->orWhere(\DB::raw("concat(emp_id, ' ', last_name, ' ', first_name, ' ', middle_name)"), 'like', '%'.$request->search.'%')
                            ->whereNotNull('med_num')
                            ->paginate(10);
            $emps->appends(['search' => $request->search]);
            $search = $request->search;
            $totalEmps = Employee::join('employeesmedicals', 'employees.id', 'employeesmedicals.employee_id')
                            ->select('emp_id', 'first_name', 'last_name', 'middle_name', 'department_id', 'position_id', 'employeesmedicals.med_num')
                            ->groupBy('emp_id', 'first_name', 'last_name', 'middle_name', 'department_id', 'position_id', 'employeesmedicals.med_num')
                            ->distinct('emp_id')
                            ->whereNotNull('med_num')
                            ->get();
            return view('medical.employeesMedical.employeesWithRecord', compact('emps', 'search', 'totalEmps'));
        }else{
            return back();
        }
    }

    public function fullReport()
    {
        if (Gate::allows('isAdmin') || Gate::allows('isDoctor') || Gate::allows('isNurse') || Gate::allows('isHr')) {
            $emps = Employeesmedical::join('diagnoses', 'diagnoses.id', 'employeesmedicals.diagnosis_id')
                                    ->join('diseases', 'diseases.id', 'diagnoses.disease_id')
                                    ->join('bodyparts', 'bodyparts.id', 'diseases.bodypart_id')
                                    ->join('employees', 'employees.id', 'employeesmedicals.employee_id')
                                    ->select('employeesmedicals.id', 'employees.gender', 'diagnosis', 'employeesmedicals.created_at', \DB::raw('TIMESTAMPDIFF(YEAR,birthday,NOW()) as age'), 'diseases.disease', 'bodyparts.bodypart')
                                    ->orderBy('age', 'desc')
                                    ->get()
                                    ->groupBy(function($date) {
                                        return Carbon::parse($date->created_at)->format('Y');
                                      });

            // $emps = Employeesmedical::get()
            //                         ->groupBy(function($date) {
            //                             return Carbon::parse($date->created_at)->format('Y');
            //                           });
            // dd($emps);
            return view('medical.employeesMedical.fullReport', compact('diagnoses', 'arr', 'arr_count', 'emps'));
        }elseif (Gate::allows('isBanned')) {
            Auth::logout();
            return back()->with('message', 'You\'re not employee!');
        }else{
            return back();
        }
    }

    public function printMedicalRecord($employee, $employeesmedical, $empMeds){

        $relPath = 'storage/uploaded/print/medrecord/';
        if (!file_exists($relPath)) {
            mkdir($relPath, 777, true);
        }
        $datamedrec = view('medical.employeesMedical.printmedrecord',compact('employee','employeesmedical','empMeds'))->render();
        File::put(public_path('/storage/uploaded/print/medrecord/emp-med-record.html'),$datamedrec); 

    }

    public function printEmpMedinfo($employee, $printsearch){

        $relPath = 'storage/uploaded/print/medrecord/';
        if (!file_exists($relPath)) {
            mkdir($relPath, 777, true);
        }
        $datamedrec = view('medical.employeesMedical.printemployeeInfo',compact('employee','printsearch','result'))->render();
        File::put(public_path('/storage/uploaded/print/medrecord/emp-med-info.html'),$datamedrec); 

    }

    public function medicalForm(Employee $employee)
    {
        $gens = Generic::orderBy('gname', 'asc')->get();
        $meds = Medicine::get();
        $bparts = Bodypart::get();
        return view('medical.employeesMedical.medicalform', compact('employee', 'gens', 'meds', 'bparts'));
    }

    public function getDisease(Bodypart $bodypart)
    {
        $data = array();
        $data['disease'] = $bodypart->diseases->pluck('disease', 'id');
        return json_encode($data);
    }

    public function getSupBrand(Request $request, $supgen)
    {
        if ($request->ajax()) {
            $result = Supgen::find($supgen);
            $data['brand'] = $result->supbrands->pluck('name', 'id');
            return json_encode($data);
        }
    }

    public function getSupBrandAndSupGen(Request $request, $supbrand_id, $supgen_id)
    {
        if ($request->ajax()) {
            $count = Supply::where('supbrand_id', $request->supbrand_id)
                           ->where('supgen_id', $request->supgen_id)
                           ->where('availability', 0)
                           ->where(function($date){
                                $date->where('expiration_date', '>', NOW())
                                     ->orWhere('expiration_date', NULL);
                           })
                           ->orderBy('created_at', 'desc')
                           ->count();
            return json_encode($count);
        }
    }

    public function getSupply(GetSupplyRequest $request)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isDoctor') || Gate::allows('isNurse')) {
            $atts = $this->validate($request, $request->rules(), $request->messages());
            $dtm = \carbon\carbon::now();
            $newRecord                  = new Employeesmedical;
            $newRecord->user_id         = auth()->user()->id;
            $newRecord->employee_id     = $request->employee_id;
            $newRecord->save();
            $data = $newRecord->id;
            // Supplies
            if ($request->supgen_id != null && $request->supbrand_id != null && $request->supqty[0][0] != null) {
                $arr4 = array_map( 'array_values', $request->supgen_id);
                $supgen_id = array_values($arr4);
                $arr5 = array_map( 'array_values', $request->supbrand_id);
                $supbrand_id = array_values($arr5);
                $arr6 = array_map( 'array_values', $request->supqty);
                $supqty = array_values($arr6);

                $counter2 = count($request->supgen_id);
                $arrSup = array();
                for ($i = 0; $i < $counter2; $i++) {
                    $arrSup[] = Supply::where('supgen_id', $supgen_id[$i][0])
                                      ->where('supbrand_id', $supbrand_id[$i][0])
                                      ->where(function($exp_date){
                                        $exp_date->where('expiration_date', '>', NOW())
                                                 ->orWhere('expiration_date', NULL);
                                      })
                                      ->where('availability', 0)
                                      ->take($supqty[$i][0])->orderBy('id', 'asc')->get();
                }
                for ($c = 0; $c < count($arrSup); $c++) { 

                    foreach ($arrSup[$c] as $supQty) {
                        $supQty->availability           = 1;
                        $supQty->save();
                        $newData2                        = new EmployeesmedicalSupplyUser;
                        $newData2->employeesmedical_id   = $data;
                        $newData2->supply_id             = $supQty->id;
                        $newData2->user_id               = auth()->user()->id;
                        $newData2->supqty                = $supqty[$c][0];
                        $newData2->created_at            = $dtm;
                        $newData2->updated_at            = $dtm;
                        $newData2->save();
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
