<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RejectDocumentRequest extends FormRequest
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
            'comment' => ['required','string','max:50','min:5'],
        ];
    }

    public function messages()
    {
        return [
            'comment.required' => __('customvalidation.contractor.comment.required'),
            'comment.string' => __('customvalidation.contractor.comment.string'),
            'comment.max' => __('customvalidation.contractor.comment.max'),
            'comment.max' => 'Rejection reason should be at least 5 characters long.',
        ];
    }
}
