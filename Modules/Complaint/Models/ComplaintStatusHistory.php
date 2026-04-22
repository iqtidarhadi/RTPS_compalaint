<?php

namespace Modules\Complaint\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComplaintStatusHistory extends Model
{
    use HasFactory;

    protected $table = 'complaint_status_history';

    protected $fillable = [
        'complaint_id',
        'complaint_number',
        'old_status',
        'new_status',
        'remarks',
        'internal_notes',
        'changed_by',
        'changed_by_name',
        'changed_by_role',
        'changed_at',
        'time_taken_hours',
    ];

    protected $casts = [
        'changed_at' => 'datetime',
        'time_taken_hours' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Status constants for easy reference
    const STATUS_DRAFT = 'draft';
    const STATUS_SUBMITTED = 'submitted';
    const STATUS_PENDING = 'pending';
    const STATUS_UNDER_REVIEW = 'under_review';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_RESOLVED = 'resolved';
    const STATUS_REJECTED = 'rejected';
    const STATUS_APPEALED = 'appealed';
    const STATUS_CLOSED = 'closed';

    const ALL_STATUSES = [
        self::STATUS_DRAFT,
        self::STATUS_SUBMITTED,
        self::STATUS_PENDING,
        self::STATUS_UNDER_REVIEW,
        self::STATUS_IN_PROGRESS,
        self::STATUS_RESOLVED,
        self::STATUS_REJECTED,
        self::STATUS_APPEALED,
        self::STATUS_CLOSED,
    ];

    // Status labels for display
    const STATUS_LABELS = [
        self::STATUS_DRAFT => 'Draft',
        self::STATUS_SUBMITTED => 'Submitted',
        self::STATUS_PENDING => 'Pending',
        self::STATUS_UNDER_REVIEW => 'Under Review',
        self::STATUS_IN_PROGRESS => 'In Progress',
        self::STATUS_RESOLVED => 'Resolved',
        self::STATUS_REJECTED => 'Rejected',
        self::STATUS_APPEALED => 'Appealed',
        self::STATUS_CLOSED => 'Closed',
    ];

    // Status colors for UI
    const STATUS_COLORS = [
        self::STATUS_DRAFT => 'gray',
        self::STATUS_SUBMITTED => 'indigo',
        self::STATUS_PENDING => 'yellow',
        self::STATUS_UNDER_REVIEW => 'blue',
        self::STATUS_IN_PROGRESS => 'orange',
        self::STATUS_RESOLVED => 'green',
        self::STATUS_REJECTED => 'red',
        self::STATUS_APPEALED => 'purple',
        self::STATUS_CLOSED => 'gray',
    ];

    // Relationships
    public function complaint(): BelongsTo
    {
        return $this->belongsTo(Complaint::class);
    }

    public function changedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }

    // Accessors
    public function getOldStatusLabelAttribute(): string
    {
        return self::STATUS_LABELS[$this->old_status] ?? ucfirst($this->old_status);
    }

    public function getNewStatusLabelAttribute(): string
    {
        return self::STATUS_LABELS[$this->new_status] ?? ucfirst($this->new_status);
    }

    public function getOldStatusColorAttribute(): string
    {
        return self::STATUS_COLORS[$this->old_status] ?? 'gray';
    }

    public function getNewStatusColorAttribute(): string
    {
        return self::STATUS_COLORS[$this->new_status] ?? 'gray';
    }

    public function getFormattedTimeTakenAttribute(): string
    {
        if (!$this->time_taken_hours) {
            return 'N/A';
        }
        
        $days = floor($this->time_taken_hours / 24);
        $hours = $this->time_taken_hours % 24;
        
        if ($days > 0) {
            return "{$days} days, {$hours} hours";
        }
        
        return "{$hours} hours";
    }

    public function getChangedAtFormattedAttribute(): string
    {
        return $this->changed_at->format('d-m-Y h:i A');
    }

    // Scopes
    public function scopeByComplaint($query, $complaintId)
    {
        return $query->where('complaint_id', $complaintId);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('new_status', $status);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('changed_at', [$startDate, $endDate]);
    }

    public function scopeByChangedBy($query, $userId)
    {
        return $query->where('changed_by', $userId);
    }

    public function scopeRecent($query, $limit = 10)
    {
        return $query->orderBy('changed_at', 'desc')->limit($limit);
    }

    // Helper Methods
    public static function getStatusTimeline($complaintId)
    {
        return self::where('complaint_id', $complaintId)
            ->orderBy('changed_at', 'asc')
            ->get();
    }

    public static function getAverageResolutionTime()
    {
        $resolvedComplaints = self::where('new_status', self::STATUS_RESOLVED)
            ->whereNotNull('time_taken_hours')
            ->get();
            
        if ($resolvedComplaints->isEmpty()) {
            return 0;
        }
        
        return round($resolvedComplaints->avg('time_taken_hours'));
    }

    public static function getStatusChangeCount($status = null)
    {
        $query = self::query();
        
        if ($status) {
            $query->where('new_status', $status);
        }
        
        return $query->count();
    }

    public static function getStatusFlow($complaintId)
    {
        $history = self::where('complaint_id', $complaintId)
            ->orderBy('changed_at', 'asc')
            ->get();
            
        $flow = [];
        foreach ($history as $index => $record) {
            $flow[] = [
                'from' => $record->old_status,
                'to' => $record->new_status,
                'at' => $record->changed_at,
                'by' => $record->changed_by_name,
                'remarks' => $record->remarks,
            ];
        }
        
        return $flow;
    }
}