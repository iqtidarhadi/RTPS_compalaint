<?php

namespace App\Services;

use App\Models\Backend\Department;
use App\Models\Complainant;
use App\Models\Complaint;
use App\Models\ComplaintDocument;
use App\Models\Service;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ComplaintService
{
   public function registerComplaint(array $data)
    {
        return DB::transaction(function () use ($data) {
            // Validate service and department relationship
            $service = Service::findOrFail($data['complaint']['service_id']);
            $department = Department::findOrFail($data['complaint']['department_id']);
            
            // Ensure service belongs to department
            if ($service->department_id != $department->id) {
                throw new \Exception('Selected service does not belong to the selected department');
            }
            
            // Create complainant
            $complainant = Complainant::create($data['complainant']);
            
            // Upload CNIC documents
            if (isset($data['cnic_front'])) {
                $this->uploadDocument($complainant, $data['cnic_front'], 'cnic_front');
            }
            
            if (isset($data['cnic_back'])) {
                $this->uploadDocument($complainant, $data['cnic_back'], 'cnic_back');
            }
            
            // Create complaint
            $complaintData = $data['complaint'];
            $complaintData['complainant_id'] = $complainant->id;
            $complaintData['submitted_at'] = now();
            $complaintData['status'] = 'pending';
            
            $complaint = Complaint::create($complaintData);
            
            // Upload screenshot
            if (isset($data['screenshot'])) {
                $this->uploadDocument($complaint, $data['screenshot'], 'screenshot');
            }
            
            return [
                'complainant' => $complainant,
                'complaint' => $complaint->load(['service', 'department']),
                'tracking_number' => $complaint->complaint_number
            ];
        });
    }
    
    public function fileAppeal(array $data)
    {
        return DB::transaction(function () use ($data) {
            $complaint = Complaint::findOrFail($data['complaint_id']);
            
            if (!$complaint->canAppeal()) {
                throw new \Exception('This complaint cannot be appealed');
            }
            
            $appeal = $complaint->appeals()->create([
                'complainant_id' => $complaint->complainant_id,
                'first_appeal_date' => $data['first_appeal_date'],
                'appeal_description' => $data['appeal_description'],
                'status' => 'pending'
            ]);
            
            if (isset($data['copy_of_appeal'])) {
                $this->uploadDocument($appeal, $data['copy_of_appeal'], 'copy_of_appeal');
            }
            
            if (isset($data['supporting_documents'])) {
                $this->uploadDocument($appeal, $data['supporting_documents'], 'supporting_documents');
            }
            
            // Update complaint status
            $complaint->updateStatus('appealed', 'Appeal filed against decision');
            
            return $appeal;
        });
    }
    
    private function uploadDocument($model, $file, $type)
    {
        $path = $file->store("complaints/{$type}", 'public');
        
        return $model->documents()->create([
            'document_type' => $type,
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
        ]);
    }
    
    public function getComplaintWithDetails($complaintId)
    {
        return Complaint::with([
            'complainant',
            'documents',
            'appeals.documents',
            'statusHistory'
        ])->findOrFail($complaintId);
    }
    
    public function getComplainantHistory($cnic)
    {
        return Complainant::with(['complaints' => function($q) {
                $q->orderBy('created_at', 'desc');
            }, 'complaints.appeals'])
            ->where('cnic_number', $cnic)
            ->firstOrFail();
    }
}