@php
    use Modules\Complaint\Enums\ComplaintDecision;
    use Modules\Complaint\Enums\ComplaintStatus;

    $decisionLabels = collect(ComplaintDecision::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()]);
    $statusLabels = collect(ComplaintStatus::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()]);
@endphp

<button
    type="button"
    class="btn btn-sm btn-outline-primary"
    data-bs-toggle="modal"
    data-bs-target="#statusUpdateModal-{{ $complaint->id }}"
>
    Change Status
</button>

<div class="modal fade" id="statusUpdateModal-{{ $complaint->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{ route('complaints.status-update', $complaint) }}">
                @csrf

                <div class="modal-header">
                    <div>
                        <h5 class="modal-title mb-1">Update Complaint Status</h5>
                        <div class="text-muted small">{{ $complaint->tracking_number }} | Current: {{ $statusLabels[$complaint->status] ?? \Illuminate\Support\Str::headline($complaint->status) }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="stage" value="{{ $complaint->current_stage ?: $complaint->current_level }}">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Decision</label>
                            <select name="decision" class="form-select" required>
                                <option value="">Select a decision</option>
                                @foreach ($allowedDecisions as $decision)
                                    <option value="{{ $decision }}">{{ $decisionLabels[$decision] ?? \Illuminate\Support\Str::headline($decision) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Penalty Amount</label>
                            <input type="number" step="0.01" min="0" name="penalty_amount" class="form-control" placeholder="Optional unless invalid justification">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Remarks</label>
                            <textarea name="remarks" rows="4" class="form-control" placeholder="Add internal or decision remarks"></textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Penalty Reason</label>
                            <textarea name="penalty_reason" rows="3" class="form-control" placeholder="Required if penalty is applied"></textarea>
                        </div>
                    </div>

                    <div class="alert alert-light border mt-3 mb-0">
                        <div class="fw-semibold mb-1">Workflow automation</div>
                        <div class="small text-muted">
                            Delayed complaints move to Appellate Authority. Rejected citizen-stage complaints can be appealed again to RTS Commission.
                            Invalid justification decisions apply service with penalty automatically.
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Workflow</button>
                </div>
            </form>
        </div>
    </div>
</div>
