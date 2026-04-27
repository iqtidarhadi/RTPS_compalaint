@extends('complaint::layouts.layout')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Service Delivery Details</h2>
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center p-3">
                <div class="fw-bold fs-4">40,689</div>
                <div class="text-muted">Critically Delayed</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-3">
                <div class="fw-bold fs-4">10,293</div>
                <div class="text-muted">Delivered Services</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-3">
                <div class="fw-bold fs-4">123</div>
                <div class="text-muted">Ontime Delivered</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-3">
                <div class="fw-bold fs-4">2040</div>
                <div class="text-muted">Total Pending</div>
            </div>
        </div>
    </div>
    <div class="card p-4">
        <h5 class="mb-3">Service Delivery Details</h5>
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
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
                    <tr>
                        <td>Arms License</td>
                        <td>Home</td>
                        <td>37 Days</td>
                        <td>42 Days</td>
                        <td>54</td>
                        <td>5</td>
                        <td>25</td>
                        <td>24</td>
                        <td><span class="badge bg-danger">Below Satisfactory</span></td>
                        <td><a href="{{ route('rts.services.department', 1) }}" class="btn btn-outline-secondary btn-sm">Details</a></td>
                    </tr>
                    <tr>
                        <td>Domicile</td>
                        <td>Home</td>
                        <td>14 Days</td>
                        <td>12 Days</td>
                        <td>65</td>
                        <td>65</td>
                        <td>25</td>
                        <td>24</td>
                        <td><span class="badge bg-warning text-dark">Average</span></td>
                        <td>...</td>
                    </tr>
                    <tr>
                        <td>Motor Vehicle Registration</td>
                        <td>Home</td>
                        <td>10 Days</td>
                        <td>8 Days</td>
                        <td>23</td>
                        <td>4</td>
                        <td>25</td>
                        <td>24</td>
                        <td><span class="badge bg-success">Satisfactory</span></td>
                        <td>...</td>
                    </tr>
                    <tr>
                        <td>Driving License</td>
                        <td>Home</td>
                        <td>3 Days</td>
                        <td>2 Days</td>
                        <td>02</td>
                        <td>6</td>
                        <td>25</td>
                        <td>24</td>
                        <td><span class="badge bg-warning text-dark">Below Average</span></td>
                        <td>...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
