<?php

namespace Modules\Complaint\Services;

use App\Models\User;
use Modules\Complaint\Enums\ComplaintStatus;
use Modules\Complaint\Models\Complaint;

class ComplaintDashboardService
{
    public function __construct(
        protected ComplaintVisibilityService $visibilityService
    ) {
    }

    public function getDashboardData(?User $user): array
    {
        $query = Complaint::query()->with(['department:id,name', 'service:id,service_name', 'complainant:id,name', 'citizen:id,firstname,lastname,email']);
        $complaints = $this->visibilityService->applyVisibilityScope($query, $user)
            ->latest()
            ->get();

        $summary = [
            'total' => $complaints->count(),
            'pending' => $complaints->whereIn('status', [
                ComplaintStatus::SUBMITTED->value,
                ComplaintStatus::PENDING->value,
            ])->count(),
            'in_progress' => $complaints->whereIn('status', [
                ComplaintStatus::IN_PROGRESS->value,
                ComplaintStatus::UNDER_REVIEW->value,
            ])->count(),
            'resolved' => $complaints->filter(fn (Complaint $complaint) => in_array($complaint->status, [
                ComplaintStatus::RESOLVED->value,
                ComplaintStatus::PENALTY_APPLIED->value,
                ComplaintStatus::CLOSED->value,
            ], true))->count(),
            'rejected' => $complaints->where('status', ComplaintStatus::REJECTED->value)->count(),
            'escalated' => $complaints->filter(fn (Complaint $complaint) => in_array($complaint->status, [
                ComplaintStatus::SENT_TO_APPELLATE_AUTHORITY->value,
                ComplaintStatus::SENT_TO_RTS_COMMISSION->value,
                ComplaintStatus::APPEALED->value,
            ], true))->count(),
        ];

        return [
            'roleContext' => $this->visibilityService->resolveRoleContext($user),
            'viewerName' => trim((string) (($user->firstname ?? '') . ' ' . ($user->lastname ?? ''))) ?: ($user->name ?? $user->email ?? 'Complaint User'),
            'summary' => $summary,
            'recentComplaints' => $complaints->take(8)->values(),
        ];
    }
}
