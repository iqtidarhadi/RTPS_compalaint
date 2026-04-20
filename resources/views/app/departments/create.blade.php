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

        <form action="{{ route('app.departments.store') }}" method="POST" id="createDepartmentForm">
            @csrf

            <div class="row g-3">

                {{-- Department Name --}}
                <div class="col-md-6">
                    <label class="form-label"><strong>Department Name</strong></label>

                    <input type="text"
                           name="name"
                           class="form-control"
                           placeholder="Enter Department Name"
                           required>

                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Status --}}
                <div class="col-md-6">
                    <label class="form-label"><strong>Status</strong></label>

                    <select name="status" class="form-control" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>

                    @error('status')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

            </div>

        </form>

    </div>

    <div class="card-footer text-end">

        <a class="btn btn-warning" href="{{ route('app.departments.index') }}">
            <i class="bx bx-arrow-back"></i> Back
        </a>

        <button type="submit" form="createDepartmentForm" class="btn btn-primary">
            Save Department
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
            placeholder: "Select Status",
            allowClear: true
        });
    });
</script>
@endpush