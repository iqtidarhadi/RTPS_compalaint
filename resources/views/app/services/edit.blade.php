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

        <form action="{{ route('app.services.update', Crypt::encrypt($model->id)) }}" method="POST" id="editServiceForm">
            @csrf
            @method('PUT')

            <div class="row g-3">

                {{-- Department --}}
                <div class="col-md-6">
                    <label class="form-label"><strong>Department</strong></label>

                    <select name="dept_id" class="form-control select2" required>
                        <option value="">Select Department</option>

                        @foreach ($departments as $id => $name)
                            <option value="{{ $id }}"
                                {{ old('dept_id', $model->dept_id) == $id ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
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
                           value="{{ old('service_name', $model->service_name) }}"
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
                           value="{{ old('sla_days', $model->sla_days) }}"
                           placeholder="Enter SLA Days">

                    @error('sla_days')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Status --}}
                <div class="col-md-6">
                    <label class="form-label"><strong>Status</strong></label>

                    <select name="is_active" class="form-control" required>
                        <option value="1" {{ old('is_active', $model->is_active) == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('is_active', $model->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
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
                              placeholder="Enter Service Description">{{ old('description', $model->description) }}</textarea>

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

        <button type="submit" form="editServiceForm" class="btn btn-primary">
            Update Service
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