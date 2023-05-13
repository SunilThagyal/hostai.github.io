<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AddContractorRequest extends FormRequest
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
        $parameter = $this->route()->parameter('slug');
        $user = User::where('slug', $parameter)->first();
        $authUserRole = Auth::user()->role;
        $rules =  [
            'name' => 'required|string',
            'company_name' => 'required|string',
            'architect_id' => 'required',
            'construction_site' => 'required|array',
            'construction_site.*' => 'required|exists:sites,id',
            'location' => 'required',
            'profile_pic' => 'nullable|mimes:jpeg,png',
            'email' => ['required', 'unique:users,email','email'],
            'password' => ['required', 'same:confirm_password'],
            'confirm_password' => ['required'],

        ];

        if (!empty($parameter)) {
            $rules['email'][1] .= ','.$user->id;
            $rules['password'][0] = 'nullable';
            $rules['confirm_password'][0] = 'nullable';
        }

        if ( in_array( $authUserRole , [config('constants.project-manager'),config('constants.main-manager')] )) {
            unset($rules['architect_id']);
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => __('customvalidation.contractor.contact_name.required'),
            'name.string' => __('customvalidation.contractor.contact_name.string'),
            'name.max' => __('customvalidation.contractor.contact_name.max'),
            'company_name.required' => __('customvalidation.contractor.company_name.required'),
            'company_name.string' => __('customvalidation.contractor.company_name.string'),
            'company_name.max' => __('customvalidation.contractor.company_name.max'),
            'architect_id.required' => __('customvalidation.contractor.architect_id.required'),
            'construction_site.required' => __('customvalidation.contractor.construction_site.required'),
            'construction_site.max' => __('customvalidation.contractor.construction_site.max'),
            'construction_site.*.exists' => __('customvalidation.contractor.construction_site.exists'),
            'location.required' => __('customvalidation.contractor.location.required'),
            'location.max' => __('customvalidation.contractor.location.max'),
            'profile_pic.required' => __('customvalidation.contractor.profile_pic.required'),
            'profile_pic.mimes' => __('customvalidation.contractor.profile_pic.mimes'),
            'email.required' => __('customvalidation.contractor.email.required'),
            'email.email' => __('customvalidation.contractor.email.email'),
            'email.unique' => __('customvalidation.contractor.email.unique'),
            'password.required' => __('customvalidation.contractor.password.required'),
            'confirm_password.required' => __('customvalidation.contractor.confirm_password.required'),
            'password.max' => __('customvalidation.contractor.password.max'),
            'profile_pic.required' => __('customvalidation.contractor.profile_pic.required'),
            'profile_pic.mimes' => __('customvalidation.contractor.profile_pic.mimes'),

        ];
    }
}
