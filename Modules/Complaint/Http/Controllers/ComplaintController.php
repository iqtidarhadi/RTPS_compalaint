<?php

namespace Modules\Complaint\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Modules\Complaint\Http\Requests\ComplaintFilterRequest;
use Modules\Complaint\Http\Requests\UpdateComplaintStatusRequest;
use Modules\Complaint\Models\Complaint;
use Modules\Complaint\Models\Department;
use Modules\Complaint\Services\ComplaintDashboardService;
use Modules\Complaint\Services\ComplaintListingService;
use Modules\Complaint\Services\ComplaintWorkflowService;

class ComplaintController extends Controller
{
    public function __construct(
        protected ComplaintListingService $listingService,
        protected ComplaintWorkflowService $workflowService,
        protected ComplaintDashboardService $dashboardService
    ) {
    }

    public function dashboard(): View
    {
        return view('complaint::dashboard', [
            'title' => 'Complaint Dashboard',
            'dashboardData' => $this->dashboardService->getDashboardData(auth()->user()),
        ]);
    }

    public function index(ComplaintFilterRequest $request): View
    {
        $filters = $request->validated();

        return view('complaint::complaints.index', [
            'title' => 'Complaint Listing',
            'complaints' => $this->listingService->paginateForIndex($filters, $request->user()),
            'filters' => $filters,
            'departments' => Department::query()->orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function show(Complaint $complaint): View
    {
        $this->authorize('view', $complaint);

        return view('complaint::complaints.show', [
            'title' => 'Complaint Details',
            'complaint' => $complaint->load([
                'complainant',
                'citizen',
                'department',
                'service',
                'assignedTo',
                'appeals',
                'histories.actor',
                'penalties',
                'statusHistory.changedBy',
            ]),
            'allowedDecisions' => $this->workflowService->getAllowedDecisions($complaint),
        ]);
    }

    public function statusUpdate(UpdateComplaintStatusRequest $request, Complaint $complaint)
    {
        $this->authorize('updateStatus', $complaint);

        $this->workflowService->processDecision(
            complaint: $complaint,
            stage: $request->validated('stage'),
            decision: $request->validated('decision'),
            actor: $request->user(),
            remarks: $request->validated('remarks'),
            penaltyAmount: $request->filled('penalty_amount') ? (float) $request->validated('penalty_amount') : null,
            penaltyReason: $request->validated('penalty_reason')
        );

        return redirect()
            ->route('complaints.show', $complaint)
            ->with('success', 'Complaint status updated successfully.');
    }
}
