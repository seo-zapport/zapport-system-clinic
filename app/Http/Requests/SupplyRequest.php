<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class SupplyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Gate::check('isAdmin') || Gate::check('isNurse') || Gate::check('isDoctor')) {
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
            'supgen_id'     =>  ['required'],
            'supbrand_id'   =>  ['required'],
            'quantity'      =>  ['required'],
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'supgen_id.required'        =>  'This field is required!',
            'supbrand_id.required'      =>  'This field is required!',
            'quantity'                  =>  'This field is required!',
        ];
    }
}
