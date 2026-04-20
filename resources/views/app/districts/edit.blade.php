@extends('layouts.layout')

@push('stylesheets')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endpush

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">{{ $title ?? 'Edit District'}}</h5>
            <a href="{{ route('app.districts.index') }}" class="btn btn-secondary">Back to List</a>
        </div>

        <div class="card-body">
            <form action="{{ route('app.districts.update', encryptId($district->id)) }}" method="POST" id="editDistrictForm">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label"><strong>District Title *</strong></label>
                        <input type="text" name="title" class="form-control" placeholder="Enter District Title"
                            value="{{ old('title', $district->title) }}" required>
                        @error('title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><strong>Province</strong></label>
                        <select name="province_id" class="form-control select2">
                            <option value="">Select Province</option>
                            @foreach($provinces as $id => $title)
                                <option value="{{ $id }}" {{ (old('province_id', $district->province_id) == $id) ? 'selected' : '' }}>{{ $title }}</option>
                            @endforeach
                        </select>
                        @error('province_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><strong>Urdu Title</strong></label>
                        <input type="text" name="ur_title" class="form-control" placeholder="Enter Urdu Title"
                            value="{{ old('ur_title', $district->ur_title) }}">
                        @error('ur_title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><strong>Short Title</strong></label>
                        <input type="text" name="short_title" class="form-control" placeholder="Enter Short Title"
                            value="{{ old('short_title', $district->short_title) }}">
                        @error('short_title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><strong>Longitude</strong></label>
                        <input type="text" name="longitude" class="form-control" placeholder="Enter Longitude"
                            value="{{ old('longitude', $district->longitude) }}">
                        @error('longitude')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><strong>Latitude</strong></label>
                        <input type="text" name="latitude" class="form-control" placeholder="Enter Latitude"
                            value="{{ old('latitude', $district->latitude) }}">
                        @error('latitude')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><strong>Status *</strong></label>
                        <select name="active" class="form-control" required>
                            <option value="">Select Status</option>
                            <option value="1" {{ (old('active', $district->active) == '1') ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ (old('active', $district->active) == '0') ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('active')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label class="form-label"><strong>Description</strong></label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Enter Description">{{ old('description', $district->description) }}</textarea>
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Update District</button>
                        <a href="{{ route('app.districts.index') }}" class="btn btn-secondary">Cancel</a>
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
        });
    </script>
@endpush
