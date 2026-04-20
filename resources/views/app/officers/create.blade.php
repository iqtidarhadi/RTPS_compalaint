@extends('layouts.layout')

@push('stylesheets')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endpush

@section('content')
<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">{{ $title ?? '' }}</h5>
    </div>

    <div class="card-body">

        <form action="{{ route('app.officers.store') }}" method="POST" id="createOfficerForm">
            @csrf

            <div class="row g-3">

                {{-- Department --}}
                <div class="col-md-6">
                    <label class="form-label"><strong>Department</strong></label>
                    <select name="dept_id" class="form-control select2" required>
                        <option value="">Select Department</option>
                        @foreach ($departments as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>

                    @error('dept_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Name --}}
                <div class="col-md-6">
                    <label class="form-label"><strong>Name</strong></label>
                    <input type="text" name="name" class="form-control" placeholder="Enter Officer Name" required>

                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Designation --}}
                <div class="col-md-6">
                    <label class="form-label"><strong>Designation</strong></label>
                    <input type="text" name="designation" class="form-control" placeholder="Enter Designation">

                    @error('designation')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="col-md-6">
                    <label class="form-label"><strong>Email</strong></label>
                    <input type="email" name="email" class="form-control" placeholder="Enter Email">

                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Phone --}}
                <div class="col-md-6">
                    <label class="form-label"><strong>Phone</strong></label>
                    <input type="text" name="phone" class="form-control" placeholder="Enter Phone">

                    @error('phone')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Status --}}
                <div class="col-md-6">
                    <label class="form-label"><strong>Status</strong></label>
                    <select name="is_active" class="form-control" required>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>

                    @error('is_active')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

            </div>

        </form>

    </div>

    <div class="card-footer text-end">

        <a class="btn btn-warning" href="{{ route('app.officers.index') }}">
            <i class="bx bx-arrow-back"></i> Back
        </a>

        <button type="submit" form="createOfficerForm" class="btn btn-primary">
            Save Officer
        </button>

    </div>

</div>
@endsection

@push('plugin-scripts')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
@endpush

@push('scripts')
<script>
    $(document).ready(function () {
        $('.select2').select2({
            placeholder: "Select Department",
            allowClear: true
        });
    });
</script>
@endpush