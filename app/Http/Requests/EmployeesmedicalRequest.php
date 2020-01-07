<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class EmployeesmedicalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Gate::allows('isAdmin') || Gate::allows('isDoctor') || Gate::allows('isNurse')) {
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
            'diagnosis'     =>  ['required'],
            'note'          =>  ['required'],
            'remarks'       =>  ['required'],
            'disease_id'    =>  ['required'],
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
            'diagnosis.required'    =>  'Diagnosis Field is required!',
            'note.required'         =>  'Note field is required!',
            'remarks.required'      =>  'Remarks is required!',
            'disease_id.required'   =>  'Disease field is required!'
        ];
    }
}
