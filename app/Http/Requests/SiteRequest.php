<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SiteRequest extends FormRequest
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
            'name' => ['required', 'unique:sites,name','string'],

        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('customvalidation.site.name.required'),
            'name.unique' => __('customvalidation.site.name.unique'),
            'name.string' => __('customvalidation.site.name.string'),
            'name.max' => __('customvalidation.site.name.max'),

        ];
    }
}
