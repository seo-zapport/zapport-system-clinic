<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Gate::allows('isAdmin') || Gate::allows('isHr')) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "profile_img"               => ['mimes:jpg,jpeg,png', 'max:2000'],
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
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
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
        ];
    }
}