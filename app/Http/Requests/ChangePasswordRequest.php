<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class ChangePasswordRequest extends FormRequest
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
        if ("GET" == request()->method()) {
            return [];
        }

        $user = auth()->user();

        return [
            'old_password' => ['required', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    $fail('Old password is not correct.');
                }
            }],
            'password' => ['required', 'same:confirm_password'],
            'confirm_password' => ['required'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {

        return [
            'old_password.required' =>  __('customvalidation.change_password.old_password.required'),
            'password.required' => __('customvalidation.change_password.password.required'),
            'password.string' => __('customvalidation.change_password.password.string'),
            'password.regex' => __('customvalidation.change_password.password.regex'),
            'password.same' => __('customvalidation.change_password.password.same'),
            'confirm_password.required' => __('customvalidation.change_password.confirm_password.required'),
        ];
    }
}
