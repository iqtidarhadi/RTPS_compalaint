<?php

namespace Modules\Complaint\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppealRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'complaint_id' => 'required|exists:complaints,id',
            'first_appeal_date' => 'required|date',
            'appeal_description' => 'required|string',
            'declaration' => 'required|boolean|accepted',
            'copy_of_appeal' => 'nullable|file|max:5120|mimes:pdf,jpeg,png,jpg',
            'supporting_documents' => 'nullable|file|max:5120|mimes:pdf,jpeg,png,jpg',
        ];
    }
}