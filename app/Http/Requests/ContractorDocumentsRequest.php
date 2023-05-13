<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContractorDocumentsRequest extends FormRequest
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
        $rules = [
            'document_name.*' => ['required', 'string', 'max:30'],
        ];

        for ($i = 0; $i < count(request()->document_name); $i++) {
            $rules['certificate.' . $i] = ['required', 'file', 'mimes:pdf,img,jpg,jpeg,png', 'max:3000'];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'document_name.*.required' => __('customvalidation.contractor.document_name.required'),
            'document_name.*.string' => __('customvalidation.contractor.document_name.string'),
            'document_name.*.max' => __('customvalidation.contractor.document_name.max'),
            'certificate.*.required' => __('customvalidation.contractor.certificate.required'),
            'certificate.*.mimes' => __('customvalidation.contractor.certificate.mimes'),
            'certificate.*.max' => __('customvalidation.contractor.certificate.max'),
            'certificate.required' => __('customvalidation.contractor.certificate.required'),
            'certificate.mimes' => __('customvalidation.contractor.certificate.mimes'),
            'certificate.max' => __('customvalidation.contractor.certificate.max'),
        ];
    }
}
