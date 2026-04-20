<?php

namespace App\Http\Controllers\Api;

use App\Models\Complaint;
use App\Models\ComplaintStatusHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreComplaintRequest;
use App\Http\Requests\StoreAppealRequest;
use App\Services\ComplaintService;
class ComplaintController extends Controller
{
    // ... existing methods ...
    protected $complaintService;
     public function __construct(ComplaintService $complaintService)
    {
        $this->complaintService = $complaintService;
    }
    public function store(StoreComplaintRequest $request)
    {
        try {
            $result = $this->complaintService->registerComplaint($request->validated());
            
            return response()->json([
                'success' => true,
                'message' => 'Complaint registered successfully',
                'data' => $result,
                'tracking_url' => route('complaints.track', $result['complaint']->complaint_number)
            ], 201);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to register complaint',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function fileAppeal(StoreAppealRequest $request)
    {
        try {
            $appeal = $this->complaintService->fileAppeal($request->validated());
            
            return response()->json([
                'success' => true,
                'message' => 'Appeal filed successfully',
                'data' => $appeal
            ], 201);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to file appeal',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function show($id)
    {

    
        $complaint = $this->complaintService->getComplaintWithDetails($id);
        
        return response()->json([
            'success' => true,
            'data' => $complaint
        ]);
    }
    
    public function track($complaintNumber)
    {
        $complaint = Complaint::with(['complainant', 'statusHistory'])
            ->where('complaint_number', $complaintNumber)
            ->firstOrFail();
            
        return response()->json([
            'success' => true,
            'data' => $complaint
        ]);
    }
    
    public function complainantHistory($cnic)
    {
        $history = $this->complaintService->getComplainantHistory($cnic);
        
        return response()->json([
            'success' => true,
            'data' => $history
        ]);
    }
    
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,under_review,in_progress,resolved,rejected',
            'remarks' => 'nullable|string'
        ]);
        
        $complaint = Complaint::findOrFail($id);
        $complaint->updateStatus($request->status, $request->remarks, auth()->id());
        
        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully',
            'data' => $complaint
        ]);
    }
    // Get status history for a complaint
    public function getStatusHistory($id)
    {
        $complaint = Complaint::with('statusHistory.changedBy')->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => [
                'complaint' => [
                    'id' => $complaint->id,
                    'number' => $complaint->complaint_number,
                    'current_status' => $complaint->status,
                    'current_status_label' => ComplaintStatusHistory::STATUS_LABELS[$complaint->status],
                ],
                'status_history' => $complaint->statusHistory->map(function ($history) {
                    return [
                        'id' => $history->id,
                        'old_status' => $history->old_status,
                        'old_status_label' => $history->old_status_label,
                        'new_status' => $history->new_status,
                        'new_status_label' => $history->new_status_label,
                        'new_status_color' => $history->new_status_color,
                        'remarks' => $history->remarks,
                        'changed_by' => $history->changed_by_name,
                        'changed_by_role' => $history->changed_by_role,
                        'changed_at' => $history->changed_at_formatted,
                        'time_taken' => $history->formatted_time_taken,
                    ];
                }),
                'statistics' => $complaint->getStatusStatistics(),
            ]
        ]);
    }

    // Get status timeline in chronological order
    public function getStatusTimeline($id)
    {
        $complaint = Complaint::findOrFail($id);
        $timeline = $complaint->getStatusTimeline();
        
        return response()->json([
            'success' => true,
            'data' => [
                'timeline' => $timeline,
                'flow' => ComplaintStatusHistory::getStatusFlow($id),
            ]
        ]);
    }

    // Get global status history statistics
    public function getGlobalStatusStats(Request $request)
    {
        $stats = [
            'total_status_changes' => ComplaintStatusHistory::count(),
            'average_resolution_time' => ComplaintStatusHistory::getAverageResolutionTime(),
            'status_breakdown' => [],
            'recent_activities' => ComplaintStatusHistory::recent(20)->with('complaint')->get(),
            'daily_changes' => ComplaintStatusHistory::selectRaw('DATE(changed_at) as date, COUNT(*) as count')
                ->where('changed_at', '>=', now()->subDays(30))
                ->groupBy('date')
                ->orderBy('date', 'desc')
                ->get(),
        ];
        
        // Get breakdown by status
        foreach (ComplaintStatusHistory::ALL_STATUSES as $status) {
            $stats['status_breakdown'][$status] = [
                'label' => ComplaintStatusHistory::STATUS_LABELS[$status],
                'count' => ComplaintStatusHistory::where('new_status', $status)->count(),
                'color' => ComplaintStatusHistory::STATUS_COLORS[$status],
            ];
        }
        
        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    // Update status with full history tracking
    public function updateStatusWithHistory(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:' . implode(',', ComplaintStatusHistory::ALL_STATUSES),
            'remarks' => 'nullable|string|max:500',
            'internal_notes' => 'nullable|string|max:1000',
        ]);
        
        $complaint = Complaint::findOrFail($id);
        
        // Check if status change is allowed
        if (!$complaint->isStatusChangeAllowed($request->status)) {
            return response()->json([
                'success' => false,
                'message' => "Status change from {$complaint->status} to {$request->status} is not allowed",
                'allowed_transitions' => $complaint->getAllowedTransitions()
            ], 422);
        }
        
        $history = $complaint->updateStatus(
            $request->status,
            $request->remarks,
            $request->internal_notes,
            auth()->id()
        );
        
        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully',
            'data' => [
                'complaint' => $complaint->fresh(),
                'history' => $history,
            ]
        ]);
    }

    // Get status change analytics for dashboard
    public function getStatusAnalytics(Request $request)
    {
        $period = $request->get('period', 'month'); // week, month, year
        
        $query = ComplaintStatusHistory::query();
        
        switch ($period) {
            case 'week':
                $query->where('changed_at', '>=', now()->subDays(7));
                break;
            case 'month':
                $query->where('changed_at', '>=', now()->subDays(30));
                break;
            case 'year':
                $query->where('changed_at', '>=', now()->subYear());
                break;
        }
        
        $analytics = [
            'period' => $period,
            'total_changes' => $query->count(),
            'avg_time_per_status' => [],
            'most_active_officers' => ComplaintStatusHistory::select('changed_by_name', \DB::raw('COUNT(*) as changes'))
                ->groupBy('changed_by_name', 'changed_by')
                ->orderBy('changes', 'desc')
                ->limit(10)
                ->get(),
            'status_transition_matrix' => $this->getStatusTransitionMatrix($query),
            'peak_hours' => ComplaintStatusHistory::selectRaw('HOUR(changed_at) as hour, COUNT(*) as count')
                ->whereIn('changed_at', $query->select('changed_at'))
                ->groupBy('hour')
                ->orderBy('hour')
                ->get(),
        ];
        
        return response()->json([
            'success' => true,
            'data' => $analytics
        ]);
    }

    private function getStatusTransitionMatrix($query)
    {
        $transitions = [];
        $statuses = ComplaintStatusHistory::ALL_STATUSES;
        
        foreach ($statuses as $from) {
            foreach ($statuses as $to) {
                $count = (clone $query)->where('old_status', $from)
                    ->where('new_status', $to)
                    ->count();
                    
                if ($count > 0) {
                    $transitions[] = [
                        'from' => $from,
                        'from_label' => ComplaintStatusHistory::STATUS_LABELS[$from],
                        'to' => $to,
                        'to_label' => ComplaintStatusHistory::STATUS_LABELS[$to],
                        'count' => $count,
                    ];
                }
            }
        }
        
        return $transitions;
    }
}