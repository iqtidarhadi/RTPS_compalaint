<?php

namespace Modules\Complaint\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Complaint\Enums\ComplaintDecision;
use Modules\Complaint\Enums\ComplaintStage;

class UpdateComplaintStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'stage' => ['required', Rule::in(array_column(ComplaintStage::cases(), 'value'))],
            'decision' => ['required', Rule::in(ComplaintDecision::values())],
            'remarks' => ['nullable', 'string', 'max:2000'],
            'penalty_amount' => ['nullable', 'numeric', 'min:0'],
            'penalty_reason' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if (in_array($this->input('decision'), [
                ComplaintDecision::INVALID_JUSTIFICATION->value,
            ], true) && !$this->filled('penalty_amount')) {
                $validator->errors()->add('penalty_amount', 'Penalty amount is required when invalid justification is selected.');
            }
        });
    }
}
