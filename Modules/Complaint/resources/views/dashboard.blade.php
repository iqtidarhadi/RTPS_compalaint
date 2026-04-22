@php
    use Modules\Complaint\Enums\ComplaintStatus;

    $summary = $dashboardData['summary'] ?? [];
    $recentComplaints = $dashboardData['recentComplaints'] ?? collect();
    $roleContext = $dashboardData['roleContext'] ?? 'admin';
    $viewerName = $dashboardData['viewerName'] ?? 'Complaint User';
    $statusMap = collect(ComplaintStatus::cases())->mapWithKeys(fn ($status) => [$status->value => $status]);
@endphp

@extends('complaint::layouts.layout')

@section('content')
    <div class="d-flex flex-column gap-4">
        <div class="p-4 rounded-4 text-white" style="background: linear-gradient(135deg, #0c447c, #1d6ecf);">
            <div class="d-flex flex-column flex-lg-row justify-content-between gap-3">
                <div>
                    <div class="text-uppercase small fw-semibold opacity-75 mb-2">RTS Complaint Workflow</div>
                    <h2 class="fw-bold mb-2">Welcome {{ $viewerName }}</h2>
                    <p class="mb-0 opacity-75">
                        Role context: {{ \Illuminate\Support\Str::headline($roleContext) }}.
                        Dashboard counters are automatically scoped to your complaint visibility.
                    </p>
                </div>
                <div class="align-self-lg-center">
                    <a href="{{ route('complaints.index') }}" class="btn btn-light text-primary fw-semibold">Open Complaints</a>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-6 col-xl">
                <div class="border rounded-4 p-3 h-100">
                    <div class="text-muted small text-uppercase fw-semibold">Total Complaints</div>
                    <div class="display-6 fw-bold">{{ number_format($summary['total'] ?? 0) }}</div>
                </div>
            </div>
            <div class="col-md-6 col-xl">
                <div class="border rounded-4 p-3 h-100">
                    <div class="text-muted small text-uppercase fw-semibold">Pending Complaints</div>
                    <div class="display-6 fw-bold text-warning">{{ number_format($summary['pending'] ?? 0) }}</div>
                </div>
            </div>
            <div class="col-md-6 col-xl">
                <div class="border rounded-4 p-3 h-100">
                    <div class="text-muted small text-uppercase fw-semibold">In Progress</div>
                    <div class="display-6 fw-bold text-info">{{ number_format($summary['in_progress'] ?? 0) }}</div>
                </div>
            </div>
            <div class="col-md-6 col-xl">
                <div class="border rounded-4 p-3 h-100">
                    <div class="text-muted small text-uppercase fw-semibold">Resolved</div>
                    <div class="display-6 fw-bold text-success">{{ number_format($summary['resolved'] ?? 0) }}</div>
                </div>
            </div>
            <div class="col-md-6 col-xl">
                <div class="border rounded-4 p-3 h-100">
                    <div class="text-muted small text-uppercase fw-semibold">Rejected</div>
                    <div class="display-6 fw-bold text-danger">{{ number_format($summary['rejected'] ?? 0) }}</div>
                </div>
            </div>
            <div class="col-md-6 col-xl">
                <div class="border rounded-4 p-3 h-100">
                    <div class="text-muted small text-uppercase fw-semibold">Escalated</div>
                    <div class="display-6 fw-bold text-primary">{{ number_format($summary['escalated'] ?? 0) }}</div>
                </div>
            </div>
        </div>

        <div class="border rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
                <div>
                    <h5 class="mb-1">Recent Complaints</h5>
                    <div class="text-muted small">Latest complaints visible to the current logged-in role.</div>
                </div>
                <a href="{{ route('complaints.index') }}" class="btn btn-outline-primary btn-sm">View All</a>
            </div>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Tracking #</th>
                            <th>Citizen</th>
                            <th>Department</th>
                            <th>Status</th>
                            <th>Stage</th>
                            <th>Submitted</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentComplaints as $complaint)
                            @php $statusEnum = $statusMap[$complaint->status] ?? null; @endphp
                            <tr>
                                <td>
                                    <a href="{{ route('complaints.show', $complaint) }}" class="fw-semibold text-decoration-none">
                                        {{ $complaint->tracking_number }}
                                    </a>
                                </td>
                                <td>{{ $complaint->complainant->name ?? ($complaint->citizen->name ?? 'N/A') }}</td>
                                <td>{{ $complaint->department->name ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge rounded-pill {{ $statusEnum?->badgeClass() ?? 'bg-secondary-subtle text-secondary' }}">
                                        {{ $statusEnum?->label() ?? \Illuminate\Support\Str::headline($complaint->status) }}
                                    </span>
                                </td>
                                <td>{{ $complaint->stageLabel() }}</td>
                                <td>{{ optional($complaint->submitted_at ?? $complaint->created_at)->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No complaints available for the current role scope.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
