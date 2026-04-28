@extends('complaint::layouts.layout')

@push('stylesheets')
<style>
    .service-delivery-table {
        table-layout: auto;
        width: 100%;
    }

    .service-delivery-table th,
    .service-delivery-table td {
        font-size: 0.76rem;
        padding: 0.4rem 0.45rem;
        white-space: normal;
        word-break: normal;
        overflow-wrap: anywhere;
        vertical-align: middle;
        line-height: 1.2;
    }

    .service-delivery-table th {
        font-weight: 700;
        letter-spacing: 0.02em;
    }

    .service-delivery-table th:nth-child(9),
    .service-delivery-table td:nth-child(9) {
        min-width: 130px;
    }

    .service-delivery-table th:nth-child(10),
    .service-delivery-table td:nth-child(10) {
        min-width: 90px;
    }

    .service-delivery-table .badge {
        font-size: 0.68rem;
        font-weight: 600;
        white-space: normal;
        display: inline-block;
        line-height: 1.1;
        max-width: 100%;
    }

    .service-delivery-table .btn-sm {
        font-size: 0.7rem;
        padding: 0.25rem 0.4rem;
    }

    @media (min-width: 1200px) {
        .service-delivery-table th,
        .service-delivery-table td {
            font-size: 0.8rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Service Delivery Details</h2>
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center p-3">
                <div class="fw-bold fs-4">{{ number_format($summary['critically_delayed']) }}</div>
                <div class="text-muted">Critically Delayed</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-3">
                <div class="fw-bold fs-4">{{ number_format($summary['delivered_services']) }}</div>
                <div class="text-muted">Delivered Services</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-3">
                <div class="fw-bold fs-4">{{ number_format($summary['on_time_delivered']) }}</div>
                <div class="text-muted">Ontime Delivered</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-3">
                <div class="fw-bold fs-4">{{ number_format($summary['total_pending']) }}</div>
                <div class="text-muted">Total Pending</div>
            </div>
        </div>
    </div>
    <div class="card p-4">
        <h5 class="mb-3">Service Delivery Details</h5>
        <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle service-delivery-table mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Service Title</th>
                        <th>Department</th>
                        <th>Notified Timelines As per RTPS</th>
                        <th>Average Process Time</th>
                        <th>Total Applications</th>
                        <th>Delivered on time</th>
                        <th>Delayed</th>
                        <th>Critically Delayed</th>
                        <th>Performance</th>
                        <th>Take Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                        <tr>
                            <td>{{ $service['title'] }}</td>
                            <td>{{ $service['department'] }}</td>
                            <td>{{ $service['timeline'] }}</td>
                            <td>{{ $service['avg_time'] }}</td>
                            <td>{{ $service['total_applications'] }}</td>
                            <td>{{ $service['on_time'] }}</td>
                            <td>{{ $service['delayed'] }}</td>
                            <td>{{ $service['critical'] }}</td>
                            <td>
                                <span class="badge bg-{{ $service['performance_class'] }}">
                                    {{ $service['performance_label'] }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1 flex-wrap">
                                    
                                    <a href="{{ route('rts.services.department', $service['id']) }}" class="btn btn-outline-secondary btn-sm">Details</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">No service data available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
