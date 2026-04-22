<?php

namespace Modules\Complaint\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Complaint\Enums\ComplaintStage;
use Modules\Complaint\Enums\ComplaintStatus;
use Modules\Complaint\Services\ComplaintVisibilityService;

class Complaint extends Model
{
    use HasFactory;

    public const LEVEL_CITIZEN = ComplaintStage::CITIZEN->value;
    public const LEVEL_SPO = ComplaintStage::SPO->value;
    public const LEVEL_APPELLATE_AUTHORITY = ComplaintStage::APPELLATE_AUTHORITY->value;
    public const LEVEL_RTS_COMMISSION = ComplaintStage::RTS_COMMISSION->value;
    public const LEVEL_CLOSED = ComplaintStage::CLOSED->value;

    protected $fillable = [
        'tracking_number',
        'citizen_id',
        'current_level',
        'current_stage',
        'complainant_id',
        'complaint_number',
        'service_id',
        'department_id',
        'category',
        'address_location',
        'title',
        'description',
        'status',
        'priority',
        'decision_notes',
        'penalty_amount',
        'submitted_at',
        'resolved_at',
        'admin_remarks',
        'resolution_details',
        'assigned_to',
        'last_updated_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'resolved_at' => 'datetime',
        'last_updated_at' => 'datetime',
        'penalty_amount' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::creating(function (Complaint $complaint) {
            if (empty($complaint->complaint_number)) {
                $complaint->complaint_number = static::generateComplaintNumber();
            }

            if (empty($complaint->tracking_number)) {
                $complaint->tracking_number = $complaint->complaint_number;
            }

            $complaint->current_stage = $complaint->current_stage ?: ($complaint->current_level ?: self::LEVEL_SPO);
        });
    }

    public static function generateComplaintNumber(): string
    {
        $prefix = 'CMP';
        $year = date('Y');
        $month = date('m');

        $lastComplaint = static::query()
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->latest('id')
            ->first();

        $nextNumber = $lastComplaint
            ? str_pad(((int) substr((string) $lastComplaint->complaint_number, -4)) + 1, 4, '0', STR_PAD_LEFT)
            : '0001';

        return "{$prefix}{$year}{$month}{$nextNumber}";
    }

    public function getTrackingNumberAttribute($value): string
    {
        return $value ?: (string) $this->complaint_number;
    }

    public function citizen()
    {
        return $this->belongsTo(User::class, 'citizen_id');
    }

    public function complainant()
    {
        return $this->belongsTo(Complainant::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function appeals()
    {
        return $this->hasMany(Appeal::class);
    }

    public function complaintDocuments()
    {
        return $this->hasMany(ComplaintDocument::class);
    }

    public function documents()
    {
        return $this->morphMany(ComplaintDocument::class, 'documentable');
    }

    public function histories()
    {
        return $this->hasMany(ComplaintHistory::class);
    }

    public function penalties()
    {
        return $this->hasMany(Penalty::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function statusHistory()
    {
        return $this->hasMany(ComplaintStatusHistory::class)->latest('changed_at');
    }

    public function scopeVisibleTo(Builder $query, ?User $user): Builder
    {
        return app(ComplaintVisibilityService::class)->applyVisibilityScope($query, $user);
    }

    public function scopeStatus(Builder $query, ?string $status): Builder
    {
        return $status ? $query->where('status', $status) : $query;
    }

    public function scopeDepartment(Builder $query, $departmentId): Builder
    {
        return filled($departmentId) ? $query->where('department_id', $departmentId) : $query;
    }

    public function scopeCitizen(Builder $query, $citizenId): Builder
    {
        return filled($citizenId) ? $query->where('citizen_id', $citizenId) : $query;
    }

    public function scopeDateRange(Builder $query, ?string $fromDate, ?string $toDate): Builder
    {
        return $query
            ->when($fromDate, fn (Builder $builder) => $builder->whereDate('created_at', '>=', $fromDate))
            ->when($toDate, fn (Builder $builder) => $builder->whereDate('created_at', '<=', $toDate));
    }

    public function scopeTrackingNumber(Builder $query, ?string $trackingNumber): Builder
    {
        return $trackingNumber
            ? $query->where(function (Builder $builder) use ($trackingNumber) {
                $builder
                    ->where('tracking_number', 'like', '%' . $trackingNumber . '%')
                    ->orWhere('complaint_number', 'like', '%' . $trackingNumber . '%');
            })
            : $query;
    }

    public function scopeEscalated(Builder $query): Builder
    {
        return $query->whereIn('status', [
            ComplaintStatus::SENT_TO_APPELLATE_AUTHORITY->value,
            ComplaintStatus::SENT_TO_RTS_COMMISSION->value,
            ComplaintStatus::APPEALED->value,
        ]);
    }

    public function scopeResolved(Builder $query): Builder
    {
        return $query->whereIn('status', [
            ComplaintStatus::COMPLETED->value,
            ComplaintStatus::RESOLVED->value,
            ComplaintStatus::PENALTY_APPLIED->value,
            ComplaintStatus::CLOSED->value,
        ]);
    }

    public function canAppeal(): bool
    {
        return $this->status === ComplaintStatus::REJECTED->value
            && ($this->current_stage ?: $this->current_level) === self::LEVEL_CITIZEN;
    }

    public function stageLabel(): string
    {
        return match ($this->current_stage ?: $this->current_level) {
            self::LEVEL_CITIZEN => ComplaintStage::CITIZEN->label(),
            self::LEVEL_SPO => ComplaintStage::SPO->label(),
            self::LEVEL_APPELLATE_AUTHORITY => ComplaintStage::APPELLATE_AUTHORITY->label(),
            self::LEVEL_RTS_COMMISSION => ComplaintStage::RTS_COMMISSION->label(),
            default => ComplaintStage::CLOSED->label(),
        };
    }
}