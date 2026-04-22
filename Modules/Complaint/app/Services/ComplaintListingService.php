<?php

namespace Modules\Complaint\Services;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Complaint\Models\Complaint;

class ComplaintListingService
{
    public function __construct(
        protected ComplaintVisibilityService $visibilityService
    ) {
    }

    public function paginateForIndex(array $filters, ?User $user, int $perPage = 15): LengthAwarePaginator
    {
        return $this->visibilityService->applyVisibilityScope(
            Complaint::query()
                ->with([
                    'complainant:id,name,email',
                    'citizen:id,firstname,lastname,email',
                    'department:id,name',
                    'service:id,service_name',
                    'assignedTo:id,firstname,lastname,email',
                ]),
            $user
        )
            ->status($filters['status'] ?? null)
            ->department($filters['department_id'] ?? null)
            ->citizen($filters['citizen_id'] ?? null)
            ->trackingNumber($filters['tracking_number'] ?? null)
            ->dateRange($filters['from_date'] ?? null, $filters['to_date'] ?? null)
            ->when(($filters['scope'] ?? null) === 'citizen', fn ($query) => $query->where('citizen_id', $user?->id))
            ->when(($filters['scope'] ?? null) === 'department', function ($query) use ($user) {
                $departmentId = $this->visibilityService->resolveDepartmentId($user);

                if ($departmentId) {
                    $query->where('department_id', $departmentId);
                }
            })
            ->when(($filters['scope'] ?? null) === 'rts', function ($query) {
                $query->where(function ($builder) {
                    $builder
                        ->where('current_stage', 'rts_commission')
                        ->orWhere('current_level', 'rts_commission')
                        ->orWhere('status', 'sent_to_rts_commission');
                });
            })
            ->when(($filters['scope'] ?? null) === 'pending', fn ($query) => $query->whereIn('status', ['submitted', 'pending']))
            ->when(($filters['scope'] ?? null) === 'in_progress', fn ($query) => $query->whereIn('status', ['in_progress', 'under_review']))
            ->when(($filters['scope'] ?? null) === 'resolved', fn ($query) => $query->whereIn('status', ['resolved', 'penalty_applied', 'closed']))
            ->when(($filters['scope'] ?? null) === 'rejected', fn ($query) => $query->where('status', 'rejected'))
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }
}
