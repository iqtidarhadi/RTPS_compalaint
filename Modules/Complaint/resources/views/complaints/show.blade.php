@php
    use Modules\Complaint\Enums\ComplaintStatus;

    $statusMap = collect(ComplaintStatus::cases())->mapWithKeys(fn ($status) => [$status->value => $status]);
    $statusEnum = $statusMap[$complaint->status] ?? null;
@endphp

@extends('complaint::layouts.layout')

@section('content')
    <div class="d-flex flex-column gap-4">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="border rounded-4 p-4 h-100">
                    <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                        <div>
                            <div class="text-muted small">Tracking Number</div>
                            <h4 class="mb-1">{{ $complaint->tracking_number }}</h4>
                            <div class="text-muted">{{ $complaint->complaint_number }}</div>
                        </div>
                        <span class="badge rounded-pill {{ $statusEnum?->badgeClass() ?? 'bg-secondary-subtle text-secondary' }}">
                            {{ $statusEnum?->label() ?? \Illuminate\Support\Str::headline($complaint->status) }}
                        </span>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="text-muted small">Citizen</div>
                            <div class="fw-semibold">{{ $complaint->complainant->name ?? ($complaint->citizen->name ?? 'N/A') }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted small">Department</div>
                            <div class="fw-semibold">{{ $complaint->department->name ?? 'N/A' }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted small">Service</div>
                            <div class="fw-semibold">{{ $complaint->service->service_name ?? 'N/A' }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted small">Current Stage</div>
                            <div class="fw-semibold">{{ $complaint->stageLabel() }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted small">Priority</div>
                            <div class="fw-semibold">{{ \Illuminate\Support\Str::headline($complaint->priority) }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted small">Penalty Amount</div>
                            <div class="fw-semibold">Rs. {{ number_format((float) ($complaint->penalty_amount ?? 0), 2) }}</div>
                        </div>
                        <div class="col-12">
                            <div class="text-muted small">Description</div>
                            <div class="fw-semibold">{{ $complaint->description }}</div>
                        </div>
                        <div class="col-12">
                            <div class="text-muted small">Decision Notes</div>
                            <div>{{ $complaint->decision_notes ?: 'No decision notes recorded yet.' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="border rounded-4 p-4 h-100">
                    <div class="fw-semibold mb-3">Workflow Action</div>

                    @can('updateStatus', $complaint)
                        @include('complaint::complaints.status-update', [
                            'complaint' => $complaint,
                            'allowedDecisions' => $allowedDecisions,
                        ])
                    @else
                        <div class="text-muted small">You do not have permission to change the status of this complaint at the current stage.</div>
                    @endcan

                    <hr>

                    <div class="text-muted small">Submitted</div>
                    <div class="fw-semibold mb-3">{{ optional($complaint->submitted_at ?? $complaint->created_at)->format('d M Y, h:i A') }}</div>

                    <div class="text-muted small">Assigned To</div>
                    <div class="fw-semibold">{{ trim(($complaint->assignedTo->firstname ?? '') . ' ' . ($complaint->assignedTo->lastname ?? '')) ?: ($complaint->assignedTo->name ?? 'Unassigned') }}</div>
                </div>
            </div>
        </div>

        <div class="border rounded-4 p-4">
            <h5 class="mb-3">Status Timeline</h5>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Changed At</th>
                            <th>From</th>
                            <th>To</th>
                            <th>By</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($complaint->statusHistory as $history)
                            <tr>
                                <td>{{ optional($history->changed_at)->format('d M Y, h:i A') }}</td>
                                <td>{{ \Illuminate\Support\Str::headline((string) $history->old_status) ?: 'N/A' }}</td>
                                <td>{{ \Illuminate\Support\Str::headline($history->new_status) }}</td>
                                <td>{{ $history->changed_by_name ?? 'System' }}</td>
                                <td>{{ $history->remarks ?: 'No remarks' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No status history recorded yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
