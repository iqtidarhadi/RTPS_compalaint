<?php

namespace Modules\Complaint\Services;

use Modules\Complaint\Models\Complaint;
use Modules\Complaint\Models\ComplaintDocument;
use Modules\Complaint\Models\Complainant;
use Modules\Complaint\Models\Service;
use Modules\Complaint\Models\Department;
use Illuminate\Support\Facades\DB;

class ComplaintService
{
    public function __construct(
        protected ComplaintWorkflowService $workflowService
    ) {
    }

    public function registerComplaint(array $data)
    {
        return DB::transaction(function () use ($data) {
            $service = Service::findOrFail($data['complaint']['service_id']);
            $department = Department::findOrFail($data['complaint']['department_id']);

            $serviceDepartmentId = $service->dept_id ?? $service->department_id ?? null;
            if ((int) $serviceDepartmentId !== (int) $department->id) {
                throw new \Exception('Selected service does not belong to the selected department');
            }

            $complainant = Complainant::create($data['complainant']);

            if (isset($data['cnic_front'])) {
                $this->uploadDocument($complainant, $data['cnic_front'], 'cnic_front');
            }

            if (isset($data['cnic_back'])) {
                $this->uploadDocument($complainant, $data['cnic_back'], 'cnic_back');
            }

            $complaintData = $data['complaint'];
            unset($complaintData['agree_terms']);

            $complaintData['complainant_id'] = $complainant->id;
            $complaintData['citizen_id'] = auth()->id();
            $complaintData['submitted_at'] = now();
            $complaintData['status'] = 'draft';
            $complaintData['current_level'] = Complaint::LEVEL_CITIZEN;

            $complaint = Complaint::create($complaintData);
            $complaint = $this->workflowService->markAsSubmitted($complaint, auth()->user());

            if (isset($data['screenshot'])) {
                $this->uploadDocument($complaint, $data['screenshot'], 'screenshot');
            }

            return [
                'complainant' => $complainant,
                'complaint' => $complaint->load(['service', 'department', 'histories', 'statusHistory']),
                'tracking_number' => $complaint->tracking_number,
            ];
        });
    }

    public function fileAppeal(array $data)
    {
        return DB::transaction(function () use ($data) {
            $complaint = Complaint::findOrFail($data['complaint_id']);

            if (!$complaint->canAppeal()) {
                throw new \Exception('This complaint cannot be appealed at the current stage');
            }

            $appeal = $this->workflowService->createAppealRecord($complaint, $data, auth()->user());

            if (isset($data['copy_of_appeal'])) {
                $this->uploadDocument($appeal, $data['copy_of_appeal'], 'copy_of_appeal');
            }

            if (isset($data['supporting_documents'])) {
                $this->uploadDocument($appeal, $data['supporting_documents'], 'supporting_documents');
            }

            $this->workflowService->moveToRtsCommission(
                complaint: $complaint,
                actor: auth()->user(),
                remarks: $data['appeal_description'] ?? 'Citizen appealed again to RTS Commission.'
            );

            return $appeal->fresh();
        });
    }

    public function getComplaintWithDetails($complaintId)
    {
        return Complaint::with([
            'complainant',
            'service',
            'department',
            'complaintDocuments',
            'appeals.documents',
            'histories.actor',
            'penalties',
            'statusHistory',
        ])->findOrFail($complaintId);
    }

    public function getComplainantHistory($cnic)
    {
        return Complainant::with([
            'complaints' => function ($query) {
                $query->orderBy('created_at', 'desc');
            },
            'complaints.appeals',
            'complaints.histories',
            'complaints.penalties',
        ])->where('cnic_number', $cnic)->firstOrFail();
    }

    protected function uploadDocument($model, $file, string $type)
    {
        $path = $file->store("complaints/{$type}", 'public');

        $payload = [
            'document_type' => $type,
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'uploaded_by' => auth()->id(),
        ];

        if ($model instanceof Complaint) {
            $payload['complaint_id'] = $model->id;
        }

        return $model->documents()->create($payload);
    }
}
