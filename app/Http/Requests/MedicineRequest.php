<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class MedicineRequest extends FormRequest
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
            'brand_id'          =>  ['required'],
            'generic_id'        =>  ['required'],
            'expiration_date'   =>  ['required'],
            'qty_input'         =>  ['required']
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
            'brand_id.required'          =>  'Brand is required!',
            'generic_id.required'        =>  'Generic is required!',
            'expiration_date.required'   =>  'Expiration date is required!',
            'qty_input.required'         =>  'Quantity is required!'
        ];
    }
}
