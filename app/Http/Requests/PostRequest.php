<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Gate::check('isAdmin') || Gate::check('isHr') || Gate::check('isDoctor') || Gate::check('isNurse')) {
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
            'title'        =>  'required',
            'description'  =>  'required',
            'tag_id'       =>  'required',
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
            'title.required'        =>  'Title field is required!',
            'description.required'  =>  'Description field is required!',
            'tag_id.required'       =>  'Select at least 1 category!',
        ];
    }
}
