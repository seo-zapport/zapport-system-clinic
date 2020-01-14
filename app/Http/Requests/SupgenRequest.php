<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupgenRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'  =>  ['required', 'unique:supgens']
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
            'name.required'  =>  'This field is required!',
            'name.unique'    =>  'Name is already taken!',
        ];
    }
}
