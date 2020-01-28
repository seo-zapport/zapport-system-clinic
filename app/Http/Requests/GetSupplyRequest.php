<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class GetSupplyRequest extends FormRequest
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
            'supqty'        =>  ['required'],
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
            'supgen_id.required'    =>  'Please select a supply name!',
            'supbrand_id.required'  =>  'Please select a supply brand',
            'supqty.required'       =>  'Quantity is required!',
        ];
    }
}
