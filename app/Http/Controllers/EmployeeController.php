<?php

namespace App\Http\Controllers;

use App\Department;
use App\DepartmentPosition;
use App\Employee;
use App\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
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
    public function index()
    {
        if (Gate::allows('isAdmin') || Gate::allows('isHr')) {
            $employees = Employee::orderBy('first_name', 'asc')->paginate(10);
            return view('hr.employee.index', compact('employees'));
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
        if (Gate::allows('isAdmin') || Gate::allows('isHr')) {
            $departments = Department::get();
            return view('hr.employee.create', compact('departments'));
        }else{
            abort(403, 'You are not Authorized on this page!');
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        if (Gate::allows('isAdmin') || Gate::allows('isHr')) {
            $atts = $this->employeeValidation();

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
                $newFileName = null;
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
            // dd($newEmp);
            $newEmp->save();

            return back();

        }else{
            abort(403, 'You are not Authorized on this page!');
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
        }else{
            abort(403, 'You are not Authorized on this page!');
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
        }else{
            abort(403, 'You are not Authorized on this page!');
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
                    // "mother_birthday"           => ['required'],
                    // "spouse_name"               => ['required'],
                    // "date_of_marriage"          => ['required'],
                    // "children"                  => ['required'],
                    "elementary"                => ['required'],
                    "elementary_grad_date"      => ['required'],
                    "highschool"                => ['required'],
                    "highschool_grad_date"      => ['required'],
                    "college"                   => ['required'],
                    "college_grad_date"         => ['required'],
                    "person_to_contact"         => ['required'],
                    "person_to_contact_address" => ['required'],
                    "person_to_contact_number"  => ['required', 'numeric'],
                    // "tin_no"                    => ['numeric'],
                    // "sss_no"                    => ['numneric'],
                    // "philhealth_no"             => ['numneric'],
                    // "hdmf_no"                   => ['numneric'],
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
            $employee->save();

            return redirect(route('hr.emp.show', ['employee' => $employee->id]));

        }else{
            abort(403, 'You are not Authorized on this page!');
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


    public function employeeValidation()
    {
        return request()->validate([
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
            "emp_id"                    => ['required', 'unique:employees'],
            "department_id"             => ['required'],
            "position_id"               => ['required'],
            "height"                    => ['required'],
            "weight"                    => ['required'],
            "religion"                  => ['required'],
            "father_name"               => ['required'],
            "father_birthday"           => ['required'],
            "mother_name"               => ['required'],
            "mother_birthday"           => ['required'],
            // "spouse_name"               => ['required'],
            // "date_of_marriage"          => ['required'],
            // "children"                  => ['required'],
            "elementary"                => ['required'],
            "elementary_grad_date"      => ['required'],
            "highschool"                => ['required'],
            "highschool_grad_date"      => ['required'],
            "college"                   => ['required'],
            "college_grad_date"         => ['required'],
            "person_to_contact"         => ['required'],
            "person_to_contact_address" => ['required'],
            "person_to_contact_number"  => ['required', 'numeric'],
            // "tin_no"                    => ['numeric'],
            // "sss_no"                    => ['numeric'],
            // "philhealth_no"             => ['numeric'],
            // "hdmf_no"                   => ['numeric'],
        ]);
    }
}