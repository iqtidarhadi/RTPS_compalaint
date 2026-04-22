@php
    use Modules\Complaint\Enums\ComplaintStatus;

    $statusMap = collect(ComplaintStatus::cases())->mapWithKeys(fn ($status) => [$status->value => $status]);
@endphp

@extends('complaint::layouts.layout')

@section('content')
    <div class="d-flex flex-column gap-4">
        <form method="GET" action="{{ route('complaints.index') }}" class="row g-3">
            <input type="hidden" name="scope" value="{{ $filters['scope'] ?? request('scope') }}">

            <div class="col-md-2">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All statuses</option>
                    @foreach (ComplaintStatus::cases() as $status)
                        <option value="{{ $status->value }}" @selected(($filters['status'] ?? null) === $status->value)>{{ $status->label() }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label">Department</label>
                <select name="department_id" class="form-select">
                    <option value="">All departments</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}" @selected((string) ($filters['department_id'] ?? '') === (string) $department->id)>{{ $department->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label">Citizen ID</label>
                <input type="text" name="citizen_id" class="form-control" value="{{ $filters['citizen_id'] ?? '' }}" placeholder="Citizen user id">
            </div>

            <div class="col-md-2">
                <label class="form-label">From Date</label>
                <input type="date" name="from_date" class="form-control" value="{{ $filters['from_date'] ?? '' }}">
            </div>

            <div class="col-md-2">
                <label class="form-label">To Date</label>
                <input type="date" name="to_date" class="form-control" value="{{ $filters['to_date'] ?? '' }}">
            </div>

            <div class="col-md-2">
                <label class="form-label">Tracking No.</label>
                <input type="text" name="tracking_number" class="form-control" value="{{ $filters['tracking_number'] ?? '' }}" placeholder="CMP...">
            </div>

            <div class="col-12 d-flex gap-2">
                <button type="submit" class="btn btn-primary">Apply Filters</button>
                <a href="{{ route('complaints.index', request()->has('scope') ? ['scope' => request('scope')] : []) }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Tracking #</th>
                        <th>Citizen</th>
                        <th>Department</th>
                        <th>Status</th>
                        <th>Stage</th>
                        <th>Priority</th>
                        <th>Submitted</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($complaints as $complaint)
                        @php
                            $statusEnum = $statusMap[$complaint->status] ?? null;
                        @endphp
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $complaint->tracking_number }}</div>
                                <div class="text-muted small">{{ $complaint->complaint_number }}</div>
                            </td>
                            <td>
                                {{ $complaint->complainant->name ?? ($complaint->citizen->name ?? 'N/A') }}
                            </td>
                            <td>{{ $complaint->department->name ?? 'N/A' }}</td>
                            <td>
                                <span class="badge rounded-pill {{ $statusEnum?->badgeClass() ?? 'bg-secondary-subtle text-secondary' }}">
                                    {{ $statusEnum?->label() ?? \Illuminate\Support\Str::headline($complaint->status) }}
                                </span>
                            </td>
                            <td>{{ $complaint->stageLabel() }}</td>
                            <td>{{ \Illuminate\Support\Str::headline($complaint->priority) }}</td>
                            <td>{{ optional($complaint->submitted_at ?? $complaint->created_at)->format('d M Y') }}</td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-2">
                                    <a href="{{ route('complaints.show', $complaint) }}" class="btn btn-sm btn-outline-dark">View</a>

                                    @can('updateStatus', $complaint)
                                        @include('complaint::complaints.status-update', [
                                            'complaint' => $complaint,
                                            'allowedDecisions' => app(\Modules\Complaint\Services\ComplaintWorkflowService::class)->getAllowedDecisions($complaint),
                                        ])
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">No complaints found for the selected filters.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $complaints->links() }}
    </div>
@endsection
