@extends('layouts.layout')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">{{ $title ?? ($isEdit ? 'Edit' : 'Create') . ' Province' }}</h5>
            <a href="{{ route('app.provinces.index') }}" class="btn btn-secondary">Back to List</a>
        </div>

        <div class="card-body">
            <form action="{{ $isEdit ? route('app.provinces.update', encryptId($model->id)) : route('app.provinces.store') }}" 
                  method="POST" id="provinceForm">
                @csrf
                @if($isEdit)
                    @method('PUT')
                @endif
                
                <div class="row g-3">
                    <!-- Province Title -->
                    <div class="col-md-6">
                        <label class="form-label"><strong>Province Title *</strong></label>
                        <input type="text" name="title" class="form-control" placeholder="Enter Province Title"
                            value="{{ old('title', $isEdit ? $model->title : '') }}" required>
                        @error('title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Abbreviation -->
                    <div class="col-md-6">
                        <label class="form-label"><strong>Abbreviation</strong></label>
                        <input type="text" name="abbreviation" class="form-control" placeholder="Enter Abbreviation"
                            value="{{ old('abbreviation', $isEdit ? $model->abbreviation : '') }}">
                        @error('abbreviation')
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
                            {{ $isEdit ? 'Update' : 'Create' }} Province
                        </button>
                        <a href="{{ route('app.provinces.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
