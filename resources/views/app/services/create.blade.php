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

        <form action="{{ route('app.services.store') }}" method="POST" id="createServiceForm">
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

                {{-- Service Name --}}
                <div class="col-md-6">
                    <label class="form-label"><strong>Service Name</strong></label>

                    <input type="text"
                           name="service_name"
                           class="form-control"
                           placeholder="Enter Service Name"
                           required>

                    @error('service_name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                {{-- SLA Days --}}
                <div class="col-md-6">
                    <label class="form-label"><strong>SLA Days</strong></label>

                    <input type="number"
                           name="sla_days"
                           class="form-control"
                           placeholder="Enter SLA in Days">

                    @error('sla_days')
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

                {{-- Description --}}
                <div class="col-md-12">
                    <label class="form-label"><strong>Description</strong></label>

                    <textarea name="description"
                              class="form-control"
                              rows="3"
                              placeholder="Enter Service Description"></textarea>

                    @error('description')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

            </div>

        </form>

    </div>

    <div class="card-footer text-end">

        <a class="btn btn-warning" href="{{ route('app.services.index') }}">
            <i class="bx bx-arrow-back"></i> Back
        </a>

        <button type="submit" form="createServiceForm" class="btn btn-primary">
            Save Service
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