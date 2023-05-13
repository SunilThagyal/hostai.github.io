<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AddArchitectRequest extends FormRequest
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
        $rules = [
            'name' => ['required', 'string'],
            'construction_site' => ['required', 'array'],
            'construction_site.*' => ['required', 'exists:sites,id'],
            'location' => ['required'],
            'email' => ['required', 'unique:users,email', 'email'],
            'password' => ['required', 'same:confirm_password'],
        ];
        if (!empty($parameter)) {
            $user = User::where('slug', $parameter)->first();
            $rules['profile_pic'] = ['nullable', 'mimes:jpeg,png'];
            $rules['email'][1] .= ','.$user->id;
            $rules['password'][0] = 'nullable';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => __('customvalidation.architect.name.required'),
            'name.string' => __('customvalidation.architect.name.string'),
            'name.max' => __('customvalidation.architect.name.max'),
            'construction_site.required' => __('customvalidation.architect.construction_site.required'),
            'construction_site.*.required' => __('customvalidation.architect.construction_site.required'),
            'construction_site.*.exists' => __('customvalidation.architect.construction_site.exists'),
            'location.required' => __('customvalidation.architect.location.required'),
            'location.max' => __('customvalidation.architect.location.max'),
            'profile_pic.required' => __('customvalidation.architect.profile_pic.required'),
            'profile_pic.mimes' => __('customvalidation.architect.profile_pic.mimes'),
            'email.required' => __('customvalidation.architect.email.required'),
            'email.email' => __('customvalidation.architect.email.email'),
            'email.unique' => __('customvalidation.architect.email.unique'),
            'password.required' => __('customvalidation.architect.password.required'),
            'confirm_password.required' => __('customvalidation.architect.confirm_password.required'),
            'password.max' => __('customvalidation.architect.password.max'),
            'profile_pic.required' => __('customvalidation.architect.profile_pic.required'),
            'profile_pic.mimes' => __('customvalidation.architect.profile_pic.mimes'),
        ];
    }
}
