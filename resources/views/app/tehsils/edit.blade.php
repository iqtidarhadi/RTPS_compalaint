@extends('layouts.layout')

@push('stylesheets')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endpush

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">{{ $title ?? 'Edit Tehsil'}}</h5>
            <a href="{{ route('app.tehsils.index') }}" class="btn btn-secondary">Back to List</a>
        </div>

        <div class="card-body">
            <form action="{{ route('app.tehsils.update', encryptId($tehsil->id)) }}" method="POST" id="editTehsilForm">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label"><strong>Tehsil Title *</strong></label>
                        <input type="text" name="title" class="form-control" placeholder="Enter Tehsil Title"
                            value="{{ old('title', $tehsil->title) }}" required>
                        @error('title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><strong>Province *</strong></label>
                        <select name="province_id" id="province_id" class="form-control select2" required>
                            <option value="">Select Province</option>
                            @foreach($provinces as $id => $title)
                                <option value="{{ $id }}" {{ (old('province_id', $tehsil->district->province_id ?? '') == $id) ? 'selected' : '' }}>{{ $title }}</option>
                            @endforeach
                        </select>
                        @error('province_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><strong>District *</strong></label>
                        <select name="district_id" id="district_id" class="form-control select2" required>
                            <option value="">Select District</option>
                            @foreach($districts as $id => $title)
                                <option value="{{ $id }}" {{ (old('district_id', $tehsil->district_id) == $id) ? 'selected' : '' }}>{{ $title }}</option>
                            @endforeach
                        </select>
                        @error('district_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><strong>Urdu Title</strong></label>
                        <input type="text" name="ur_title" class="form-control" placeholder="Enter Urdu Title"
                            value="{{ old('ur_title', $tehsil->ur_title) }}">
                        @error('ur_title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><strong>Short Title</strong></label>
                        <input type="text" name="short_title" class="form-control" placeholder="Enter Short Title"
                            value="{{ old('short_title', $tehsil->short_title) }}">
                        @error('short_title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><strong>Status *</strong></label>
                        <select name="active" class="form-control" required>
                            <option value="">Select Status</option>
                            <option value="1" {{ (old('active', $tehsil->active) == '1') ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ (old('active', $tehsil->active) == '0') ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('active')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label class="form-label"><strong>Description</strong></label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Enter Description">{{ old('description', $tehsil->description) }}</textarea>
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Update Tehsil</button>
                        <a href="{{ route('app.tehsils.index') }}" class="btn btn-secondary">Cancel</a>
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
                var currentDistrictId = '{{ old("district_id", $tehsil->district_id) }}';
                $('#district_id').empty().append('<option value="">Select District</option>');
                
                if(provinceId) {
                    $.ajax({
                        url: "{{ route('app.get-districts') }}",
                        type: "GET",
                        data: { province_id: provinceId },
                        success: function(data) {
                            $.each(data, function(key, value) {
                                var selected = (key == currentDistrictId) ? 'selected' : '';
                                $('#district_id').append('<option value="' + key + '" ' + selected + '>' + value + '</option>');
                            });
                        }
                    });
                }
            });
        });
    </script>
@endpush
