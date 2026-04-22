<?php

namespace Modules\Complaint\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Complaint\Enums\ComplaintStatus;

class ComplaintFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'scope' => ['nullable', Rule::in([
                'all',
                'citizen',
                'department',
                'rts',
                'pending',
                'in_progress',
                'resolved',
                'rejected',
            ])],
            'status' => ['nullable', Rule::in(ComplaintStatus::values())],
            'department_id' => ['nullable', 'integer', 'exists:departments,id'],
            'citizen_id' => ['nullable', 'integer', 'exists:users,id'],
            'tracking_number' => ['nullable', 'string', 'max:100'],
            'from_date' => ['nullable', 'date'],
            'to_date' => ['nullable', 'date', 'after_or_equal:from_date'],
        ];
    }
}
