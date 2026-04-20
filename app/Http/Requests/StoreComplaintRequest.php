<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreComplaintRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Complainant Info
            'complainant' => 'required|array',
            'complainant.cnic_number' => 'required|string|size:15|unique:complainants,cnic_number',
            'complainant.name' => 'required|string|max:255',
            'complainant.gender' => 'required|in:male,female,other',
            'complainant.contact_number' => 'required|string|max:20',
            'complainant.id_type' => 'required|in:cnic,snic,passport',
            'complainant.email' => 'required|email|unique:complainants,email',
            'complainant.province' => 'required|string|max:100',
            'complainant.district' => 'required|string|max:100',
            'complainant.postal_address' => 'required|string',
            
            // Complaint Info
            'complaint' => 'required|array',
            'complaint.service_id' => 'required|exists:services,id',
            'complaint.department_id' => 'required|exists:departments,id',
            'complaint.category' => 'required|string|max:255',
            'complaint.address_location' => 'required|string',
            'complaint.title' => 'required|string|max:500',
            'complaint.description' => 'required|string',
            'complaint.agree_terms' => 'required|boolean|accepted',
            
            // Files
            'screenshot' => 'nullable|image|max:2048',
            'cnic_front' => 'nullable|image|max:2048',
            'cnic_back' => 'nullable|image|max:2048',
        ];
    }
    public function messages(): array
    {
        return [
            'complaint.service_id.required' => 'Please select a service',
            'complaint.service_id.exists' => 'Selected service is invalid',
            'complaint.department_id.required' => 'Please select a department',
            'complaint.department_id.exists' => 'Selected department is invalid',
        ];
    }
}