<?php

namespace Modules\Complaint\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;
use Modules\Complaint\Enums\ComplaintStage;
use Modules\Complaint\Enums\ComplaintStatus;
use Modules\Complaint\Models\Complaint;
use Modules\Complaint\Models\Department;

class ComplaintVisibilityService
{
    public function applyVisibilityScope(Builder $query, ?User $user): Builder
    {
        $roleContext = $this->resolveRoleContext($user);

        return match ($roleContext) {
            'citizen' => $query->where(function (Builder $builder) use ($user) {
                $builder->where('citizen_id', $user?->id);

                if (!empty($user?->email)) {
                    $builder->orWhereHas('complainant', function (Builder $complainantQuery) use ($user) {
                        $complainantQuery->where('email', $user->email);
                    });
                }
            }),
            'department' => ($departmentId = $this->resolveDepartmentId($user))
                ? $query->where('department_id', $departmentId)
                : $query->whereRaw('1 = 0'),
            'rts' => $query->where(function (Builder $builder) {
                $builder
                    ->where('current_stage', ComplaintStage::RTS_COMMISSION->value)
                    ->orWhere('current_level', ComplaintStage::RTS_COMMISSION->value)
                    ->orWhere('status', ComplaintStatus::SENT_TO_RTS_COMMISSION->value);
            }),
            default => $query,
        };
    }

    public function canViewComplaint(User $user, Complaint $complaint): bool
    {
        return $this->applyVisibilityScope(Complaint::query()->whereKey($complaint->getKey()), $user)->exists();
    }

    public function canUpdateStatus(User $user, Complaint $complaint): bool
    {
        if ($this->isSuperAdmin($user)) {
            return true;
        }

        $stage = $complaint->current_stage ?: $complaint->current_level;

        if ($this->hasRole($user, ['citizen'])) {
            return $stage === ComplaintStage::CITIZEN->value
                && $complaint->status === ComplaintStatus::REJECTED->value
                && $this->canViewComplaint($user, $complaint);
        }

        if ($stage === ComplaintStage::SPO->value) {
            return $this->hasRole($user, ['service point officer']) && $this->belongsToComplaintDepartment($user, $complaint);
        }

        if ($stage === ComplaintStage::APPELLATE_AUTHORITY->value) {
            return $this->hasRole($user, ['appellate authority']) && $this->belongsToComplaintDepartment($user, $complaint);
        }

        if ($stage === ComplaintStage::RTS_COMMISSION->value) {
            return $this->hasRole($user, ['rts commission officer']);
        }

        return false;
    }

    public function resolveRoleContext(?User $user): string
    {
        if (!$user) {
            return 'guest';
        }

        if ($this->hasRole($user, ['super admin', 'admin'])) {
            return 'admin';
        }

        if ($this->hasRole($user, ['citizen'])) {
            return 'citizen';
        }

        if ($this->hasRole($user, ['rts commission officer'])) {
            return 'rts';
        }

        if ($this->hasRole($user, ['service point officer', 'appellate authority'])) {
            return 'department';
        }

        return 'admin';
    }

    public function resolveDepartmentId(?User $user): ?int
    {
        if (!$user) {
            return null;
        }

        if (Schema::hasColumn('users', 'department_id') && !empty($user->department_id)) {
            return (int) $user->department_id;
        }

        $nameCandidate = trim((string) ($user->lastname ?? ''));
        if ($nameCandidate === '') {
            return null;
        }

        return Department::query()
            ->where('name', $nameCandidate)
            ->value('id');
    }

    public function belongsToComplaintDepartment(User $user, Complaint $complaint): bool
    {
        $departmentId = $this->resolveDepartmentId($user);

        return $departmentId !== null && (int) $departmentId === (int) $complaint->department_id;
    }

    public function hasRole(User $user, array $roles): bool
    {
        $normalized = collect($roles)->map(fn (string $role) => strtolower($role))->all();

        return $user->roles->pluck('name')->map(fn ($role) => strtolower($role))->intersect($normalized)->isNotEmpty();
    }

    public function isSuperAdmin(User $user): bool
    {
        return $this->hasRole($user, ['super admin', 'admin']);
    }
}
