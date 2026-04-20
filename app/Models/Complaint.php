<?php

namespace App\Models;

use App\Events\ComplaintStatusChanged;
use App\Models\Backend\Department;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
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
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($complaint) {
            if (empty($complaint->complaint_number)) {
                $complaint->complaint_number = static::generateComplaintNumber();
            }
        });
    }

    public static function generateComplaintNumber()
    {
        $prefix = 'CMP';
        $year = date('Y');
        $month = date('m');
        
        $lastComplaint = static::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('id', 'desc')
            ->first();
            
        if ($lastComplaint) {
            $lastNumber = intval(substr($lastComplaint->complaint_number, -4));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }
        
        return "{$prefix}{$year}{$month}{$newNumber}";
    }

    // Relationships
    public function complainant()
    {
        return $this->belongsTo(Complainant::class);
    }
     public function departments()
    {
        return $this->belongsTo(Department::class);
    }

      public function services()
    {
        return $this->belongsTo(Service::class);
    }

    public function appeals()
    {
        return $this->hasMany(Appeal::class);
    }

    public function documents()
    {
        return $this->morphMany(ComplaintDocument::class, 'documentable');
    }

  

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByDepartment($query, $department)
    {
        return $query->where('department', $department);
    }


public function updateStatus($newStatus, $remarks = null, $internalNotes = null, $userId = null)
    {
        return DB::transaction(function () use ($newStatus, $remarks, $internalNotes, $userId) {
            $oldStatus = $this->status;
            
            // Calculate time taken in previous status
            $timeTakenHours = null;
            if ($oldStatus && $oldStatus !== $newStatus) {
                $lastHistory = ComplaintStatusHistory::where('complaint_id', $this->id)
                    ->where('new_status', $oldStatus)
                    ->latest('changed_at')
                    ->first();
                
                if ($lastHistory) {
                    $timeTakenHours = $lastHistory->changed_at->diffInHours(now());
                } else if ($this->created_at) {
                    $timeTakenHours = $this->created_at->diffInHours(now());
                }
            }
            
            // Update complaint
            $this->update([
                'status' => $newStatus,
                'last_updated_at' => now(),
                'resolved_at' => $newStatus === 'resolved' ? now() : $this->resolved_at,
            ]);
            
            // Create history record
            $history = ComplaintStatusHistory::create([
                'complaint_id' => $this->id,
                'complaint_number' => $this->complaint_number,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'remarks' => $remarks,
                'internal_notes' => $internalNotes,
                'changed_by' => $userId ?? auth()->id(),
                'changed_by_name' => auth()->user()->name ?? 'System',
                'changed_by_role' => auth()->user()->role ?? 'system',
                'changed_at' => now(),
                'time_taken_hours' => $timeTakenHours,
            ]);
            
            // Trigger any notifications or events
            event(new ComplaintStatusChanged($this, $history));
            
            return $history;
        });
    }
 public function getStatusTimeline()
    {
        return $this->statusHistory()
            ->orderBy('changed_at', 'desc')
            ->get();
    }

     // Get status history with pagination
    public function getStatusHistoryPaginated($perPage = 15)
    {
        return $this->statusHistory()
            ->orderBy('changed_at', 'desc')
            ->paginate($perPage);
    }

    public function getTimeSpentInEachStatus()
    {
        $history = $this->statusHistory()
            ->orderBy('changed_at', 'asc')
            ->get();
            
        $timeSpent = [];
        $previousTimestamp = $this->created_at;
        $previousStatus = ComplaintStatusHistory::STATUS_PENDING;
        
        foreach ($history as $record) {
            $duration = $previousTimestamp->diffInHours($record->changed_at);
            $timeSpent[$previousStatus] = ($timeSpent[$previousStatus] ?? 0) + $duration;
            $previousTimestamp = $record->changed_at;
            $previousStatus = $record->new_status;
        }
        
        // Add time spent in current status
        if ($this->status !== 'resolved' && $this->status !== 'closed') {
            $duration = $previousTimestamp->diffInHours(now());
            $timeSpent[$this->status] = ($timeSpent[$this->status] ?? 0) + $duration;
        }
        
        return $timeSpent;
    }

    // Check if status change is allowed
    public function isStatusChangeAllowed($newStatus)
    {
        $allowedTransitions = [
            'draft' => ['pending'],
            'pending' => ['under_review', 'rejected'],
            'under_review' => ['in_progress', 'rejected'],
            'in_progress' => ['resolved', 'rejected'],
            'resolved' => ['closed', 'appealed'],
            'rejected' => ['appealed', 'closed'],
            'appealed' => ['under_review', 'rejected'],
            'closed' => [],
        ];
        
        return in_array($newStatus, $allowedTransitions[$this->status] ?? []);
    }

    // Get status history statistics
    public function getStatusStatistics()
    {
        return [
            'total_changes' => $this->statusHistory()->count(),
            'first_submission' => $this->submitted_at,
            'last_update' => $this->last_updated_at,
            'resolution_time' => $this->resolved_at ? 
                $this->created_at->diffInHours($this->resolved_at) : null,
            'status_breakdown' => $this->statusHistory()
                ->select('new_status', DB::raw('count(*) as count'))
                ->groupBy('new_status')
                ->get(),
            'average_time_per_status' => $this->getTimeSpentInEachStatus(),
        ];
    }

    // Relationship with status history
    public function statusHistory()
    {
        return $this->hasMany(ComplaintStatusHistory::class)->orderBy('changed_at', 'desc');
    }

    public function canAppeal()
    {
        return in_array($this->status, ['rejected']) && !$this->appeals()->exists();
    }
}