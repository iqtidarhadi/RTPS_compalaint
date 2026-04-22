<?php

namespace Modules\Complaint\Policies;

use App\Models\User;
use Modules\Complaint\Models\Complaint;
use Modules\Complaint\Services\ComplaintVisibilityService;

class ComplaintPolicy
{
    public function __construct(
        protected ComplaintVisibilityService $visibilityService
    ) {
    }

    public function viewAny(User $user): bool
    {
        return $user !== null;
    }

    public function view(User $user, Complaint $complaint): bool
    {
        return $this->visibilityService->canViewComplaint($user, $complaint);
    }

    public function create(User $user): bool
    {
        return $this->visibilityService->hasRole($user, ['citizen', 'super admin', 'admin']);
    }

    public function updateStatus(User $user, Complaint $complaint): bool
    {
        return $this->visibilityService->canUpdateStatus($user, $complaint);
    }
}
