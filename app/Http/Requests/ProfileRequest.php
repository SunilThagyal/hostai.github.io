<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required',
            'profile_pic' => 'required|mimes:jpeg,png',

        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('customvalidation.admin.name.required'),
            'name.string' => __('customvalidation.admin.name.string'),
            'name.max' => __('customvalidation.admin.name.max'),
            'email.required' => __('customvalidation.admin.email.required'),
            'profile_pic.required' => __('customvalidation.worker.profile_pic.required'),
            'profile_pic.mimes' => __('customvalidation.admin.profile_pic.mimes'),

            
        ];
    }
}
