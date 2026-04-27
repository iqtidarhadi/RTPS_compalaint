@extends('complaint::layouts.layout')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Arms License - Service Delivery Details</h2>
    <a href="{{ route('rts.services.index') }}" class="btn btn-link mb-3">&larr; Back to Services</a>
    <div class="card mb-4 p-4">
        <h5 class="mb-3">Send Reminder - Delayed Application</h5>
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
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
                    <tr>
                        <td>Fazal Manan</td>
                        <td>Malakand</td>
                        <td>12548-547245-6</td>
                        <td>Arms License</td>
                        <td>12 Jan 2026</td>
                        <td>42</td>
                        <td><span class="badge bg-danger">Critically Delayed</span></td>
                        <td><button class="btn btn-danger btn-sm">Show cause</button></td>
                    </tr>
                    <tr>
                        <td>Fazal Manan</td>
                        <td>Malakand</td>
                        <td>12548-547245-6</td>
                        <td>Arms License</td>
                        <td>12 Jan 2026</td>
                        <td>35</td>
                        <td><span class="badge bg-warning text-dark">Delayed</span></td>
                        <td><button class="btn btn-primary btn-sm">Send Reminder</button></td>
                    </tr>
                    <tr>
                        <td>Fazal Manan</td>
                        <td>Malakand</td>
                        <td>12548-547245-6</td>
                        <td>Arms License</td>
                        <td>12 Jan 2026</td>
                        <td>32</td>
                        <td><span class="badge bg-warning text-dark">Delayed</span></td>
                        <td><button class="btn btn-primary btn-sm">Send Reminder</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card p-4">
        <h5 class="mb-3">Service Delivery Applicant Details</h5>
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
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
                    <tr>
                        <td>Fazal Manan</td>
                        <td>Malakand</td>
                        <td>12548-547245-6</td>
                        <td>Arms License</td>
                        <td>12 Jan 2026</td>
                        <td>Shaukat Khan DC-Office</td>
                        <td><span class="badge bg-danger">Dependency</span></td>
                        <td>...</td>
                    </tr>
                    <tr>
                        <td>Jawad Khan</td>
                        <td>Peshawar</td>
                        <td>12548-547245-6</td>
                        <td>Arms License</td>
                        <td>12 Jan 2026</td>
                        <td>Shaukat Khan DC-Office</td>
                        <td><span class="badge bg-warning text-dark">Pending</span></td>
                        <td>...</td>
                    </tr>
                    <tr>
                        <td>Mustafa Jan</td>
                        <td>Peshawar</td>
                        <td>12548-547245-6</td>
                        <td>Arms License</td>
                        <td>12 Jan 2026</td>
                        <td>Shaukat Khan DC-Office</td>
                        <td><span class="badge bg-success">Delivered</span></td>
                        <td>...</td>
                    </tr>
                    <tr>
                        <td>Rafiullah</td>
                        <td>Peshawar</td>
                        <td>12548-547245-6</td>
                        <td>Arms License</td>
                        <td>12 Jan 2026</td>
                        <td>Shaukat Khan DC-Office</td>
                        <td><span class="badge bg-warning text-dark">Payment</span></td>
                        <td>...</td>
                    </tr>
                    <tr>
                        <td>Kashif Khan</td>
                        <td>Peshawar</td>
                        <td>12548-547245-6</td>
                        <td>Arms License</td>
                        <td>12 Jan 2026</td>
                        <td>Shaukat Khan DC-Office</td>
                        <td><span class="badge bg-danger">Dependency</span></td>
                        <td>...</td>
                    </tr>
                    <tr>
                        <td>Jawad Khan</td>
                        <td>Peshawar</td>
                        <td>12548-547245-6</td>
                        <td>Arms License</td>
                        <td>12 Jan 2026</td>
                        <td>Shaukat Khan DC-Office</td>
                        <td><span class="badge bg-success">Delivered</span></td>
                        <td>...</td>
                    </tr>
                    <tr>
                        <td>Mustafa Jan</td>
                        <td>Peshawar</td>
                        <td>12548-547245-6</td>
                        <td>Arms License</td>
                        <td>12 Jan 2026</td>
                        <td>Shaukat Khan DC-Office</td>
                        <td><span class="badge bg-warning text-dark">Payment</span></td>
                        <td>...</td>
                    </tr>
                    <tr>
                        <td>Rafiullah</td>
                        <td>Peshawar</td>
                        <td>12548-547245-6</td>
                        <td>Arms License</td>
                        <td>12 Jan 2026</td>
                        <td>Shaukat Khan DC-Office</td>
                        <td><span class="badge bg-warning text-dark">Payment</span></td>
                        <td>...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
