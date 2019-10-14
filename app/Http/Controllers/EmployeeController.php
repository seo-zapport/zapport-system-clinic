<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Position;
use App\Department;
use App\DepartmentPosition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\EmployeeRequest;
use Illuminate\Support\Facades\Storage;


class EmployeeController extends Controller
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
        if (Gate::allows('isAdmin') || Gate::allows('isHr')) {
            $employees = Employee::orWhere(\DB::raw("concat(emp_id, ' ', first_name, ' ', last_name, ' ', middle_name)"), 'like', '%'.$request->search.'%')
                                 ->orWhere(\DB::raw("concat(emp_id, ' ', last_name, ' ', first_name, ' ', middle_name)"), 'like', '%'.$request->search.'%')->orderBy('last_name', 'desc')->paginate(10);
            $employees->appends(['search' => $request->search]);
            $search = $request->search;
            return view('hr.employee.index', compact('employees', 'search'));
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
        if (Gate::allows('isAdmin') || Gate::allows('isHr')) {
            $departments = Department::get();
            return view('hr.employee.create', compact('departments'));
        }elseif (Gate::allows('isBanned')) {
            Auth::logout();
            return back()->with('message', 'You\'re not employee!');
        }else{
            return back();
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isHr')) {
            $atts = $this->validate($request, $request->rules(), $request->messages());

            // dd($atts);
            $arr = array(request('experience'));
            $works  = serialize($arr[0]);

            $arr1 = array(request('children'));
            $childrens  = serialize($arr1[0]);


            if ($request->hasFile('profile_img')) {
                $filePath = 'public/uploaded';
                $fileExtension = $request->file('profile_img')->getClientOriginalExtension();
                $newFileName = rand(11111, 99999).'.'.$fileExtension;
                $request->file('profile_img')->storeAs($filePath, $newFileName);
            }else{
                $newFileName = 'default.png';
            }

            $newEmp                             = new Employee;
            $newEmp->profile_img                = $newFileName;
            $newEmp->first_name                 = $request->first_name;
            $newEmp->last_name                  = $request->last_name;
            $newEmp->middle_name                = $request->middle_name;
            $newEmp->birthday                   = $request->birthday;
            $newEmp->birth_place                = $request->birth_place;
            $newEmp->citizenship                = $request->citizenship;
            $newEmp->religion                   = $request->religion;
            $newEmp->present_address            = $request->present_address;
            $newEmp->permanent_address          = $request->permanent_address;
            $newEmp->civil_status               = $request->civil_status;
            $newEmp->contact                    = $request->contact;
            $newEmp->gender                     = $request->gender;
            $newEmp->emp_id                     = $request->emp_id;
            $newEmp->department_id              = $request->department_id;
            $newEmp->position_id                = $request->position_id;
            $newEmp->height                     = $request->height;
            $newEmp->weight                     = $request->weight;
            $newEmp->religion                   = $request->religion;
            $newEmp->father_name                = $request->father_name;
            $newEmp->father_birthday            = $request->father_birthday;
            $newEmp->mother_name                = $request->mother_name;
            $newEmp->mother_birthday            = $request->mother_birthday;
            $newEmp->spouse_name                = $request->spouse_name;
            $newEmp->date_of_marriage           = $request->date_of_marriage;
            $newEmp->children                   = $childrens;
            $newEmp->elementary                 = $request->elementary;
            $newEmp->elementary_grad_date       = $request->elementary_grad_date;
            $newEmp->highschool                 = $request->highschool;
            $newEmp->highschool_grad_date       = $request->highschool_grad_date;
            $newEmp->college                    = $request->college;
            $newEmp->college_grad_date          = $request->college_grad_date;
            $newEmp->person_to_contact          = $request->person_to_contact;
            $newEmp->person_to_contact_address  = $request->person_to_contact_address;
            $newEmp->person_to_contact_number   = $request->person_to_contact_number;
            $newEmp->tin_no                     = $request->tin_no;
            $newEmp->sss_no                     = $request->sss_no;
            $newEmp->philhealth_no              = $request->philhealth_no;
            $newEmp->hdmf_no                    = $request->hdmf_no;
            $newEmp->experience                 = $works;
            $newEmp->hired_date                 = $request->hired_date;
            // dd($newEmp);
            $newEmp->save();

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
     * @param  \App\employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isHr')) {
            return view('hr.employee.show', compact('employee'));
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
     * @param  \App\employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isHr')) {
            $departments = Department::get();
            // Filter Department IDs that are not included
            $depID = $employee->departments->id;
            $uniqDep = Department::where('id', '!=', $depID)->get();
            // Filter Civil Status IDs that are not included

            return view('hr.employee.edit', compact('employee', 'departments', 'uniqDep'));
        }elseif (Gate::allows('isBanned')) {
            Auth::logout();
            return back()->with('message', 'You\'re not employee!');
        }else{
            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isHr')) {
            $request->validate([
                    "profile_img"               => ['mimes:jpg,jpeg,png'],
                    "first_name"                => ['required'],
                    "last_name"                 => ['required'],
                    "middle_name"               => ['required'],
                    "birthday"                  => ['required'],
                    "birth_place"               => ['required'],
                    "citizenship"               => ['required'],
                    "religion"                  => ['required'],
                    "present_address"           => ['required'],
                    "permanent_address"         => ['required'],
                    "civil_status"              => ['required'],
                    "contact"                   => ['required', 'numeric'],
                    "gender"                    => ['required'],
                    "emp_id"                    => ['required', 'unique:employees,emp_id,'.$employee->id],
                    "department_id"             => ['required'],
                    "position_id"               => ['required'],
                    "height"                    => ['required'],
                    "weight"                    => ['required'],
                    "religion"                  => ['required'],
                    "father_name"               => ['required'],
                    "father_birthday"           => ['required'],
                    "mother_name"               => ['required'],
                    "elementary"                => ['required'],
                    "elementary_grad_date"      => ['required'],
                    "highschool"                => ['required'],
                    "highschool_grad_date"      => ['required'],
                    // "college"                   => ['required'],
                    // "college_grad_date"         => ['required'],
                    "person_to_contact"         => ['required'],
                    "person_to_contact_address" => ['required'],
                    "person_to_contact_number"  => ['required', 'numeric'],
                    "hired_date"                => ['required'],
            ],
            [
                    "first_name.required"                => 'First name is required!',
                    "last_name.required"                 => 'Last name is required!',
                    "middle_name.required"               => 'Middle name is required!',
                    "birthday.required"                  => 'Birthdate is required!',
                    "birth_place.required"               => 'Birthplace is required!',
                    "citizenship.required"               => 'Citizenship is required!',
                    "religion.required"                  => 'Religion is required!',
                    "present_address.required"           => 'Present address is required!',
                    "permanent_address.required"         => 'Permanent address is required!',
                    "civil_status.required"              => 'Civil status is required!',
                    "contact.required"                   => 'Contact number is required!',
                    "gender.required"                    => 'Gender is required!',
                    "emp_id.required"                    => 'Employee ID is required!',
                    "department_id.required"             => 'Department is required!',
                    "position_id.required"               => 'Position is required!',
                    "height.required"                    => 'Height is required!',
                    "weight.required"                    => 'Weight is required!',
                    "religion.required"                  => 'Religion is required!',
                    "father_name.required"               => 'Father\'s name is required!',
                    "father_birthday.required"           => 'Father\'s birthday is required!',
                    "mother_name.required"               => 'Mother\'s name is required!',
                    "mother_birthday.required"           => 'Mother\'s birthday is required!',
                    "elementary.required"                => 'Primary education is required!',
                    "elementary_grad_date.required"      => 'Primary graduated date education is required!',
                    "highschool.required"                => 'Secondary education is required!',
                    "highschool_grad_date.required"      => 'Secondary graduated date is required!',
                    // "college.required"                   => 'Tertiary education is required!',
                    // "college_grad_date.required"         => 'Tertiary graduated date is required!',
                    "person_to_contact.required"         => 'Person to contact name is required!',
                    "person_to_contact_address.required" => 'Person to contact address is required!',
                    "person_to_contact_number.required"  => 'Person to contact phone number is required!',
                    "hired_date.required"                => 'Hired Date is required!',
            ]);

            $arr = array(request('experience'));
            $works  = serialize($arr[0]);

            $arr1 = array(request('children'));
            $childrens  = serialize($arr1[0]);

            if ($employee->profile_img != null && $request->hasFile('profile_img')) {

                Storage::delete('public/uploaded/'.$employee->profile_img);
                $filePath = 'public/uploaded';
                $fileExtension = $request->file('profile_img')->getClientOriginalExtension();
                $newFileName = rand(11111, 99999).'.'.$fileExtension;
                $request->file('profile_img')->storeAs($filePath, $newFileName);

            }elseif($employee->profile_img == null && $request->hasFile('profile_img')){

                $filePath = 'public/uploaded';
                $fileExtension = $request->file('profile_img')->getClientOriginalExtension();
                $newFileName = rand(11111, 99999).'.'.$fileExtension;
                $request->file('profile_img')->storeAs($filePath, $newFileName);

            }else{
                $newFileName = $employee->profile_img;
            }

            $employee->profile_img                  = $newFileName;
            $employee->first_name                   = $request->first_name;
            $employee->last_name                    = $request->last_name;
            $employee->middle_name                  = $request->middle_name;
            $employee->birthday                     = $request->birthday;
            $employee->birth_place                  = $request->birth_place;
            $employee->citizenship                  = $request->citizenship;
            $employee->religion                     = $request->religion;
            $employee->present_address              = $request->present_address;
            $employee->permanent_address            = $request->permanent_address;
            $employee->civil_status                 = $request->civil_status;
            $employee->contact                      = $request->contact;
            $employee->gender                       = $request->gender;
            $employee->emp_id                       = $request->emp_id;
            $employee->department_id                = $request->department_id;
            $employee->position_id                  = $request->position_id;
            $employee->height                       = $request->height;
            $employee->weight                       = $request->weight;
            $employee->religion                     = $request->religion;
            $employee->father_name                  = $request->father_name;
            $employee->father_birthday              = $request->father_birthday;
            $employee->mother_name                  = $request->mother_name;
            $employee->mother_birthday              = $request->mother_birthday;
            $employee->spouse_name                  = $request->spouse_name;
            $employee->date_of_marriage             = $request->date_of_marriage;
            $employee->children                     = $childrens;
            $employee->elementary                   = $request->elementary;
            $employee->elementary_grad_date         = $request->elementary_grad_date;
            $employee->highschool                   = $request->highschool;
            $employee->highschool_grad_date         = $request->highschool_grad_date;
            $employee->college                      = $request->college;
            $employee->college_grad_date            = $request->college_grad_date;
            $employee->person_to_contact            = $request->person_to_contact;
            $employee->person_to_contact_address    = $request->person_to_contact_address;
            $employee->person_to_contact_number     = $request->person_to_contact_number;
            $employee->tin_no                       = $request->tin_no;
            $employee->sss_no                       = $request->sss_no;
            $employee->philhealth_no                = $request->philhealth_no;
            $employee->hdmf_no                      = $request->hdmf_no;
            $employee->experience                   = $works;
            $employee->hired_date                   = $request->hired_date;
            $employee->save();

            return redirect(route('hr.emp.show', ['employee' => $employee->emp_id]));

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
     * @param  \App\employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
    }

    public function getPosition($id) 
    {
        // $position_id = Position::where("id",$id)->pluck("position","id");

        $dept = Department::find($id);
        $position_id = $dept->positions->pluck('position', 'id');

        return json_encode($position_id);
    }

    public function getEditPosition($id) 
    {
        // $position_id = Position::where("id",$id)->pluck("position","id");

        $d = Department::find($id);
        $position_id = $d->positions->pluck('position', 'id');

        return json_encode($position_id);
    }

    public function getEmpID($emp_id)
    {
        $employeesID = Employee::where('emp_id', $emp_id)->count();
        return json_encode($employeesID);
    }

    public function printcsv(Request $request)
    {
        
        


    }


  

}