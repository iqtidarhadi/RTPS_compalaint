@extends('layouts.layout')

@push('stylesheets')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endpush

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">{{ $title ?? ($isEdit ? 'Edit' : 'Create') . ' Division' }}</h5>
            <a href="{{ route('app.divisions.index') }}" class="btn btn-secondary">Back to List</a>
        </div>

        <div class="card-body">
            <form action="{{ $isEdit ? route('app.divisions.update', encryptId($model->id)) : route('app.divisions.store') }}" 
                  method="POST" id="divisionForm">
                @csrf
                @if($isEdit)
                    @method('PUT')
                @endif
                
                <div class="row g-3">
                    <!-- Title Field -->
                    <div class="col-md-6">
                        <label class="form-label"><strong>Division Title *</strong></label>
                        <input type="text" name="title" class="form-control" placeholder="Enter Division Title"
                            value="{{ old('title', $isEdit ? $model->title : '') }}" required>
                        @error('title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Province Selection -->
                    <div class="col-md-6">
                        <label class="form-label"><strong>Province *</strong></label>
                        <select name="province_id" id="province_id" class="form-control select2" required>
                            <option value="">Select Province</option>
                            @foreach($provinces as $id => $title)
                                <option value="{{ $id }}" {{ old('province_id', $selectedProvinceId ?? '') == $id ? 'selected' : '' }}>{{ $title }}</option>
                            @endforeach
                        </select>
                        @error('province_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- District Selection -->
                    <div class="col-md-6">
                        <label class="form-label"><strong>District *</strong></label>
                        <select name="district_id" id="district_id" class="form-control select2" required>
                            <option value="">Select District</option>
                            @if(isset($districts))
                                @foreach($districts as $id => $title)
                                    <option value="{{ $id }}" {{ old('district_id', $selectedDistrictId ?? '') == $id ? 'selected' : '' }}>{{ $title }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('district_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Urdu Title -->
                    <div class="col-md-6">
                        <label class="form-label"><strong>Urdu Title</strong></label>
                        <input type="text" name="ur_title" class="form-control" placeholder="Enter Urdu Title"
                            value="{{ old('ur_title', $isEdit ? $model->ur_title : '') }}">
                        @error('ur_title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Short Title -->
                    <div class="col-md-6">
                        <label class="form-label"><strong>Short Title</strong></label>
                        <input type="text" name="short_title" class="form-control" placeholder="Enter Short Title"
                            value="{{ old('short_title', $isEdit ? $model->short_title : '') }}">
                        @error('short_title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="col-md-6">
                        <label class="form-label"><strong>Status *</strong></label>
                        <select name="active" class="form-control" required>
                            <option value="">Select Status</option>
                            <option value="1" {{ old('active', $isEdit ? $model->active : '') == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('active', $isEdit ? $model->active : '') == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('active')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="col-md-12">
                        <label class="form-label"><strong>Description</strong></label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Enter Description">{{ old('description', $isEdit ? $model->description : '') }}</textarea>
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            {{ $isEdit ? 'Update' : 'Create' }} Division
                        </button>
                        <a href="{{ route('app.divisions.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            // Load districts based on province selection
            $('#province_id').on('change', function() {
                var provinceId = $(this).val();
                $('#district_id').empty().append('<option value="">Select District</option>');
                
                if(provinceId) {
                    $.ajax({
                        url: "{{ route('app.get-districts') }}",
                        type: "GET",
                        data: { province_id: provinceId },
                        success: function(data) {
                            $.each(data, function(key, value) {
                                $('#district_id').append('<option value="' + key + '">' + value + '</option>');
                            });
                        }
                    });
                }
            });

            // Trigger changes for edit mode
            @if($isEdit)
                $('#province_id').trigger('change');
                setTimeout(function() {
                    $('#district_id').val('{{ old("district_id", $selectedDistrictId ?? "") }}');
                }, 500);
            @endif
        });
    </script>
@endpush
