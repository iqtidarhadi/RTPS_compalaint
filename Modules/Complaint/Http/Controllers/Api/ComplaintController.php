<?php

namespace Modules\Complaint\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Complaint\Http\Requests\StoreAppealRequest;
use Modules\Complaint\Http\Requests\StoreComplaintRequest;
use Modules\Complaint\Models\Complaint;
use Modules\Complaint\Models\ComplaintStatusHistory;
use Modules\Complaint\Services\ComplaintService;
use Modules\Complaint\Services\ComplaintWorkflowService;

class ComplaintController extends Controller
{
    protected $complaintService;
    protected $workflowService;

    public function __construct(
        ComplaintService $complaintService,
        ComplaintWorkflowService $workflowService
    ) {
        $this->complaintService = $complaintService;
        $this->workflowService = $workflowService;
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
        return $this->processWorkflowUpdate($request, $id);
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
            'stage' => 'required|in:spo,appellate_authority,citizen,rts_commission',
            'decision' => 'required|in:completed,rejected,invalid_justification,valid_justification,appeal_again',
            'remarks' => 'nullable|string|max:1000',
            'penalty_amount' => 'nullable|numeric|min:0',
            'penalty_reason' => 'nullable|string|max:1000',
        ]);

        return $this->processWorkflowUpdate($request, $id);
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
            'most_active_officers' => ComplaintStatusHistory::select('changed_by_name', DB::raw('COUNT(*) as changes'))
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

    private function processWorkflowUpdate(Request $request, $id)
    {
        $request->validate([
            'stage' => 'required|in:spo,appellate_authority,citizen,rts_commission',
            'decision' => 'required|in:completed,rejected,invalid_justification,valid_justification,appeal_again',
            'remarks' => 'nullable|string|max:1000',
            'penalty_amount' => 'nullable|numeric|min:0',
            'penalty_reason' => 'nullable|string|max:1000',
        ]);

        $complaint = Complaint::findOrFail($id);

        $updatedComplaint = $this->workflowService->processDecision(
            complaint: $complaint,
            stage: $request->string('stage')->toString(),
            decision: $request->string('decision')->toString(),
            actor: auth()->user(),
            remarks: $request->input('remarks'),
            penaltyAmount: $request->filled('penalty_amount') ? (float) $request->input('penalty_amount') : null,
            penaltyReason: $request->input('penalty_reason')
        );

        return response()->json([
            'success' => true,
            'message' => 'Workflow decision processed successfully',
            'data' => [
                'complaint' => $updatedComplaint,
                'history' => $updatedComplaint->histories()->latest()->first(),
                'status_history' => $updatedComplaint->statusHistory()->latest()->first(),
                'penalty' => $updatedComplaint->penalties()->latest()->first(),
            ],
        ]);
    }
}