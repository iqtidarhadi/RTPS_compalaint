@extends('complaint::layouts.layout')

@push('stylesheets')
<style>
    .department-service-table {
        table-layout: fixed;
        width: 100%;
        margin-bottom: 0;
    }

    .department-service-table th,
    .department-service-table td {
        font-size: 0.75rem;
        padding: 0.35rem 0.4rem;
        white-space: normal;
        word-break: break-word;
        overflow-wrap: anywhere;
        line-height: 1.2;
        vertical-align: middle;
    }

    .department-service-table th {
        font-weight: 700;
        letter-spacing: 0.01em;
    }

    .department-service-table .badge {
        font-size: 0.68rem;
        line-height: 1.1;
        white-space: normal;
    }

    .department-service-table .btn-sm {
        font-size: 0.68rem;
        padding: 0.22rem 0.38rem;
    }

    .department-table-wrap {
        overflow-x: hidden;
    }

    @media (max-width: 991.98px) {
        .department-service-table th,
        .department-service-table td {
            font-size: 0.72rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <h2 class="mb-4">{{ $service['title'] }} - Service Delivery Details</h2>
    <a href="{{ route('rts.services.index') }}" class="btn btn-link mb-3">&larr; Back to Services</a>
    <div class="card mb-4 p-4">
        <h5 class="mb-3">Send Reminder - Delayed Application</h5>
        <div class="table-responsive department-table-wrap">
            <table class="table table-bordered table-sm align-middle department-service-table">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th>CNIC</th>
                        <th>Apply For</th>
                        <th>Date</th>
                        <th>Delayed Days</th>
                        <th>Application Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($service['delayed_cases'] as $case)
                        <tr>
                            <td>{{ $case['name'] }}</td>
                            <td>{{ $case['address'] }}</td>
                            <td>{{ $case['cnic'] }}</td>
                            <td>{{ $service['title'] }}</td>
                            <td>{{ $case['date'] }}</td>
                            <td>{{ $case['delayed_days'] }}</td>
                            <td><span class="badge bg-{{ $case['status_class'] }} {{ $case['status_class'] === 'warning' ? 'text-dark' : '' }}">{{ $case['status'] }}</span></td>
                            <td>
                                <a href="{{ route('rts.services.department_user', $service['id']) }}"
                                   class="btn btn-{{ $case['status_class'] === 'danger' ? 'danger' : 'primary' }} btn-sm">
                                     Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">No delayed applications found for this service.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card p-4">
        <h5 class="mb-3">Service Delivery Applicant Details</h5>
        <div class="table-responsive department-table-wrap">
            <table class="table table-bordered table-sm align-middle department-service-table">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th>CNIC</th>
                        <th>Apply For</th>
                        <th>Date</th>
                        <th>Approved by</th>
                        <th>Application Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($service['applicants'] as $applicant)
                        <tr>
                            <td>{{ $applicant['name'] }}</td>
                            <td>{{ $applicant['address'] }}</td>
                            <td>{{ $applicant['cnic'] }}</td>
                            <td>{{ $service['title'] }}</td>
                            <td>{{ $applicant['date'] }}</td>
                            <td>{{ $applicant['approved_by'] }}</td>
                            <td><span class="badge bg-{{ $applicant['status_class'] }} {{ $applicant['status_class'] === 'warning' ? 'text-dark' : '' }}">{{ $applicant['status'] }}</span></td>
                            <td>
                                <a href="{{ route('rts.services.department_user', $service['id']) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">No applicant records found for this service.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
