<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubcontractorDocumentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [];

        foreach ($this->input('document') as $documentId => $documentData) {
            $rules['document.' . $documentId . '.admin_document_name'] = 'required|string';
            $rules['document.' . $documentId . '.certificate'] = 'required|mimes:jpeg,png,pdf|max:2048';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'document.*.admin_document_name.required' => 'The document name field is required.',
            'document.*.certificate.required' => 'Please upload a valid document',
            'document.*.admin_document_name.string' => 'The document name field must be a string.',
            'document.*.certificate.mimes' => 'The document must be a file of type: jpeg, png, pdf.',
            'document.*.certificate.max' => 'The document may not be greater than 2 MB.',
        ];
    }
}
