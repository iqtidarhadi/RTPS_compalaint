@extends('layouts.layout')

@push('stylesheets')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endpush

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">{{ $title ?? ($isEdit ? 'Edit' : 'Create') . ' District' }}</h5>
            <a href="{{ route('app.districts.index') }}" class="btn btn-secondary">Back to List</a>
        </div>

        <div class="card-body">
            <form action="{{ $isEdit ? route('app.districts.update', encryptId($model->id)) : route('app.districts.store') }}" 
                  method="POST" id="districtForm">
                @csrf
                @if($isEdit)
                    @method('PUT')
                @endif
                
                <div class="row g-3">
                    <!-- District Title -->
                    <div class="col-md-6">
                        <label class="form-label"><strong>District Title *</strong></label>
                        <input type="text" name="title" class="form-control" placeholder="Enter District Title"
                            value="{{ old('title', $isEdit ? $model->title : '') }}" required>
                        @error('title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Province -->
                    <div class="col-md-6">
                        <label class="form-label"><strong>Province</strong></label>
                        <select name="province_id" class="form-control select2">
                            <option value="">Select Province</option>
                            @foreach($provinces as $id => $title)
                                <option value="{{ $id }}" {{ old('province_id', $isEdit ? $model->province_id : '') == $id ? 'selected' : '' }}>{{ $title }}</option>
                            @endforeach
                        </select>
                        @error('province_id')
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

                    <!-- Longitude -->
                    <div class="col-md-6">
                        <label class="form-label"><strong>Longitude</strong></label>
                        <input type="text" name="longitude" class="form-control" placeholder="Enter Longitude"
                            value="{{ old('longitude', $isEdit ? $model->longitude : '') }}">
                        @error('longitude')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Latitude -->
                    <div class="col-md-6">
                        <label class="form-label"><strong>Latitude</strong></label>
                        <input type="text" name="latitude" class="form-control" placeholder="Enter Latitude"
                            value="{{ old('latitude', $isEdit ? $model->latitude : '') }}">
                        @error('latitude')
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
                            {{ $isEdit ? 'Update' : 'Create' }} District
                        </button>
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
