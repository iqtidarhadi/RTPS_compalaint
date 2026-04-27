@php
    use Modules\Complaint\Enums\ComplaintStatus;

    $summary = $dashboardData['summary'] ?? [];
    $recentComplaints = $dashboardData['recentComplaints'] ?? collect();
    $departmentPerformance = $dashboardData['departmentPerformance'] ?? collect();
    $servicePerformance = $dashboardData['servicePerformance'] ?? collect();
    $timeline = $dashboardData['timeline'] ?? collect();
    $processFlow = $dashboardData['processFlow'] ?? [];
    $canCreateComplaint = $dashboardData['canCreateComplaint'] ?? false;
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
                        Dashboard counters, timeline, and performance blocks are automatically scoped to your complaint visibility.
                    </p>
                </div>
                <div class="align-self-lg-center d-flex flex-wrap gap-2">
                    @if($canCreateComplaint)
                        <a href="{{ route('citizen.complaints.create') }}" class="btn btn-warning fw-semibold">Submit Complaint</a>
                    @endif
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
                    <h5 class="mb-1">RTS Process Flow</h5>
                    <div class="text-muted small">Configured from the process you shared: citizen, SPO, appellate authority, and RTS commission.</div>
                </div>
            </div>

            <div class="row g-3">
                @foreach($processFlow as $index => $step)
                    <div class="col-lg-3 col-md-6">
                        <div class="border rounded-4 p-3 h-100 position-relative">
                            <div class="badge bg-{{ $step['accent'] }}-subtle text-{{ $step['accent'] }} mb-2">Step {{ $index + 1 }}</div>
                            <div class="fw-semibold mb-2">{{ $step['title'] }}</div>
                            <div class="small text-muted">{{ $step['detail'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="border rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
                <div>
                    <h5 class="mb-1">Department Performance Overview</h5>
                    <div class="text-muted small">Department-wise totals, escalations, and average resolution time.</div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Department</th>
                            <th>Total Cases</th>
                            <th>Pending</th>
                            <th>Escalated</th>
                            <th>Resolved</th>
                            <th>Avg. Time</th>
                            <th>Performance</th>
                            <th>Take Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($departmentPerformance as $row)
                            <tr>
                                <td class="fw-semibold">{{ $row['department'] }}</td>
                                <td>{{ $row['total_cases'] }}</td>
                                <td>{{ $row['pending_cases'] }}</td>
                                <td>{{ $row['escalated_cases'] }}</td>
                                <td>{{ $row['resolved_cases'] }}</td>
                                <td>{{ $row['avg_resolution_hours'] }} hrs</td>
                                <td>
                                    <span class="badge bg-{{ $row['performance_class'] }}-subtle text-{{ $row['performance_class'] }}">
                                        {{ $row['performance_label'] }}
                                    </span>
                                </td>
                                <td>
                                    @if($row['latest_complaint_id'])
                                        <a href="{{ route('complaints.show', $row['latest_complaint_id']) }}" class="btn btn-sm btn-outline-dark" title="View Complaint" aria-label="View Complaint">
                                            <i class="bx bx-eye"></i>
                                        </a>
                                    @else
                                        <span class="text-muted small">No case</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">No department performance data available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Service Delivery Details section removed as per requirements -->

        <div class="border rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
                <div>
                    <h5 class="mb-1">Case Timeline</h5>
                    <div class="text-muted small">Latest workflow movement across SPO, Appellate Authority, and RTS stages.</div>
                </div>
            </div>

            <div class="d-flex flex-column gap-3">
                @forelse($timeline as $item)
                    <div class="border rounded-4 p-3">
                        <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">
                            <div>
                                <div class="fw-semibold">{{ $item['tracking_number'] }}</div>
                                <div class="small text-muted">
                                    {{ \Illuminate\Support\Str::headline((string) $item['from_status']) }}
                                    to
                                    {{ \Illuminate\Support\Str::headline($item['to_status']) }}
                                    by {{ $item['changed_by'] }}
                                </div>
                                <div class="small mt-1">{{ $item['remarks'] ?: 'No remarks added.' }}</div>
                            </div>
                            <div class="text-end">
                                <div class="small text-muted">{{ optional($item['changed_at'])->format('d M Y, h:i A') }}</div>
                                <a href="{{ route('complaints.show', $item['complaint_id']) }}" class="btn btn-sm btn-outline-primary mt-2" title="View Complaint" aria-label="View Complaint">
                                    <i class="bx bx-eye"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-4">No recent workflow timeline available.</div>
                @endforelse
            </div>
        </div>

        <div class="border rounded-4 p-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-2">
                <div>
                    <h6 class="mb-1">Recent Complaints</h6>
                    <div class="text-muted small">Latest complaints visible to the current logged-in role.</div>
                </div>
                <a href="{{ route('complaints.index') }}" class="btn btn-outline-primary btn-sm">View All</a>
            </div>

            <div style="max-height: 300px; overflow-y: auto;">
                <table class="table table-sm align-middle mb-0">
                    <thead class="table-light sticky-top">
                        <tr class="small">
                            <th class="py-2">Tracking #</th>
                            <th class="py-2">Citizen</th>
                            <th class="py-2">Department</th>
                            <th class="py-2">Status</th>
                            <th class="py-2">Stage</th>
                            <th class="py-2">Submitted</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentComplaints->take(8) as $complaint)
                            @php $statusEnum = $statusMap[$complaint->status] ?? null; @endphp
                            <tr class="small">
                                <td class="py-1">
                                    <a href="{{ route('complaints.show', $complaint) }}" class="fw-semibold text-decoration-none small">
                                        {{ $complaint->tracking_number }}
                                    </a>
                                </td>
                                <td class="py-1 text-truncate" style="max-width: 120px;" title="{{ $complaint->complainant->name ?? ($complaint->citizen->name ?? 'N/A') }}">
                                    {{ $complaint->complainant->name ?? ($complaint->citizen->name ?? 'N/A') }}
                                </td>
                                <td class="py-1 text-truncate" style="max-width: 100px;" title="{{ $complaint->department->name ?? 'N/A' }}">
                                    {{ $complaint->department->name ?? 'N/A' }}
                                </td>
                                <td class="py-1">
                                    <span class="badge rounded-pill badge-sm {{ $statusEnum?->badgeClass() ?? 'bg-secondary-subtle text-secondary' }}">
                                        {{ $statusEnum?->label() ?? \Illuminate\Support\Str::headline($complaint->status) }}
                                    </span>
                                </td>
                                <td class="py-1 small">{{ $complaint->stageLabel() }}</td>
                                <td class="py-1 small">{{ optional($complaint->submitted_at ?? $complaint->created_at)->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-3 small">No complaints available for the current role scope.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
