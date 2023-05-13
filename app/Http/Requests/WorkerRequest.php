<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkerRequest extends FormRequest
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
        $rules =  [
            'first_name' => 'required|string',
            'last_name' => 'nullable|string',
            'construction_site' => 'required',
            // 'location' => 'required',
            'employment_type' => 'required|in:Fixed Employee (CDI & CDD),Short Term (Interim)',
            'profile_pic' => 'mimes:jpeg,png',
            'document_name' => 'required|array',
            'document_name.*' => 'required|string',
            'admin_document_name' => 'required|array',
            'admin_document_name.*' => 'required|string'
        ];

        foreach (request()->document_name as $index => $documentName) {
            $rules['certificate.'.$index] = 'required|max:2048|mimes:pdf,jpeg,jpg,png';
            $rules['dates.'.$index] = 'nullable|date_format:Y-m-d';
        }

        foreach (request()->admin_document_name as $index => $adminDocumentName) {
            $rules['admin_certificate.'.$index] = 'required|max:2048|mimes:pdf,jpeg,jpg,png';
            $rules['admin_dates.'.$index] = 'nullable|date_format:Y-m-d';
        }

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'first_name.required' => __('customvalidation.worker.firstName.required'),
            'first_name.string' => __('customvalidation.worker.firstName.string'),
            'first_name.max' => __('customvalidation.worker.firstName.max'),
            'last_name.string' => __('customvalidation.worker.lastName.string'),
            'last_name.max' => __('customvalidation.worker.lastName.max'),
            'construction_site.required' => __('customvalidation.worker.construction_site.required'),
            // 'location.required' => __('customvalidation.worker.location.required'),
            'employment_type.required' => __('customvalidation.worker.employment_type.required'),
            'profile_pic.mimes' => __('customvalidation.worker.profile_pic.mimes'),
            'document_name.*.required' => __('customvalidation.worker.document_name.required'),
            'admin_document_name.*.required' => __('customvalidation.worker.document_name.required')

        ];

        foreach (request()->document_name as $index => $documentName) {
            $messages['certificate.'.$index . '.required'] =  __('customvalidation.worker.certificate.required');
            $messages['certificate.'.$index . '.mimes'] =  __('customvalidation.worker.certificate.mimes');
            $messages['certificate.'.$index . '.max'] =  __('customvalidation.worker.certificate.size');
            // $messages['dates.'.$index . '.required'] =  __('customvalidation.worker.dates.required');
            $messages['dates.'.$index . '.date_format'] =  __('customvalidation.worker.dates.format');
        }

        foreach (request()->admin_document_name as $index => $adminDocumentName) {
            $messages['admin_certificate.'.$index . '.required'] =  __('customvalidation.worker.certificate.required');
            $messages['admin_certificate.'.$index . '.mimes'] =  __('customvalidation.worker.certificate.mimes');
            $messages['admin_certificate.'.$index . '.max'] =  __('customvalidation.worker.certificate.size');
            // $messages['dates.'.$index . '.required'] =  __('customvalidation.worker.dates.required');
            $messages['admin_dates.'.$index . '.date_format'] =  __('customvalidation.worker.dates.format');
        }

        return $messages;
    }
}
