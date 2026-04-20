@extends('layouts.layout')

@push('stylesheets')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endpush

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">{{ $title ?? ($isEdit ? 'Edit' : 'Create') . ' ' . ucfirst($module) }}</h5>
            <a href="{{ route('app.' . $module . 's.index') }}" class="btn btn-secondary">Back to List</a>
        </div>

        <div class="card-body">
            <form action="{{ $isEdit ? route('app.' . $module . 's.update', encryptId($model->id)) : route('app.' . $module . 's.store') }}" 
                  method="POST" id="{{ $module }}Form">
                @csrf
                @if($isEdit)
                    @method('PUT')
                @endif
                
                <div class="row g-3">
                    <!-- Title Field -->
                    <div class="col-md-6">
                        <label class="form-label"><strong>{{ ucfirst($module) }} Title *</strong></label>
                        <input type="text" name="title" class="form-control" placeholder="Enter {{ ucfirst($module) }} Title"
                            value="{{ old('title', $isEdit ? $model->title : '') }}" required>
                        @error('title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    @if($module === 'province')
                        <!-- Abbreviation for Province -->
                        <div class="col-md-6">
                            <label class="form-label"><strong>Abbreviation</strong></label>
                            <input type="text" name="abbreviation" class="form-control" placeholder="Enter Abbreviation"
                                value="{{ old('abbreviation', $isEdit ? $model->abbreviation : '') }}">
                            @error('abbreviation')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif

                    @if($module !== 'province')
                        <!-- Province Selection for all except Province -->
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
                    @endif

                    @if(in_array($module, ['district', 'tehsil', 'union-council', 'village']))
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
                    @endif

                    @if(in_array($module, ['tehsil', 'union-council', 'village']))
                        <!-- Tehsil Selection -->
                        <div class="col-md-6">
                            <label class="form-label"><strong>Tehsil *</strong></label>
                            <select name="tehsil_id" id="tehsil_id" class="form-control select2" required>
                                <option value="">Select Tehsil</option>
                                @if(isset($tehsils))
                                    @foreach($tehsils as $id => $title)
                                        <option value="{{ $id }}" {{ old('tehsil_id', $selectedTehsilId ?? '') == $id ? 'selected' : '' }}>{{ $title }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('tehsil_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif

                    @if(in_array($module, ['union-council', 'village']))
                        <!-- Union Council Selection -->
                        <div class="col-md-6">
                            <label class="form-label"><strong>Union Council *</strong></label>
                            <select name="union_council_id" id="union_council_id" class="form-control select2" required>
                                <option value="">Select Union Council</option>
                                @if(isset($unionCouncils))
                                    @foreach($unionCouncils as $id => $title)
                                        <option value="{{ $id }}" {{ old('union_council_id', $selectedUnionCouncilId ?? '') == $id ? 'selected' : '' }}>{{ $title }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('union_council_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif

                    @if($module === 'district')
                        <!-- Additional fields for District -->
                        <div class="col-md-6">
                            <label class="form-label"><strong>Longitude</strong></label>
                            <input type="text" name="longitude" class="form-control" placeholder="Enter Longitude"
                                value="{{ old('longitude', $isEdit ? $model->longitude : '') }}">
                            @error('longitude')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label"><strong>Latitude</strong></label>
                            <input type="text" name="latitude" class="form-control" placeholder="Enter Latitude"
                                value="{{ old('latitude', $isEdit ? $model->latitude : '') }}">
                            @error('latitude')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif

                    @if($module !== 'province')
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
                    @endif

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

                    @if($module !== 'province')
                        <!-- Description -->
                        <div class="col-md-12">
                            <label class="form-label"><strong>Description</strong></label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Enter Description">{{ old('description', $isEdit ? $model->description : '') }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            {{ $isEdit ? 'Update' : 'Create' }} {{ ucfirst($module) }}
                        </button>
                        <a href="{{ route('app.' . $module . 's.index') }}" class="btn btn-secondary">Cancel</a>
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

            // Cascading dropdowns logic
            @if($module !== 'province')
                // Load districts based on province selection
                $('#province_id').on('change', function() {
                    var provinceId = $(this).val();
                    $('#district_id').empty().append('<option value="">Select District</option>');
                    $('#tehsil_id').empty().append('<option value="">Select Tehsil</option>');
                    $('#union_council_id').empty().append('<option value="">Select Union Council</option>');
                    
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
            @endif

            @if(in_array($module, ['tehsil', 'union-council', 'village']))
                // Load tehsils based on district selection
                $('#district_id').on('change', function() {
                    var districtId = $(this).val();
                    $('#tehsil_id').empty().append('<option value="">Select Tehsil</option>');
                    $('#union_council_id').empty().append('<option value="">Select Union Council</option>');
                    
                    if(districtId) {
                        $.ajax({
                            url: "{{ route('app.get-tehsils') }}",
                            type: "GET",
                            data: { district_id: districtId },
                            success: function(data) {
                                $.each(data, function(key, value) {
                                    $('#tehsil_id').append('<option value="' + key + '">' + value + '</option>');
                                });
                            }
                        });
                    }
                });
            @endif

            @if(in_array($module, ['union-council', 'village']))
                // Load union councils based on tehsil selection
                $('#tehsil_id').on('change', function() {
                    var tehsilId = $(this).val();
                    $('#union_council_id').empty().append('<option value="">Select Union Council</option>');
                    
                    if(tehsilId) {
                        $.ajax({
                            url: "{{ route('app.get-union-councils') }}",
                            type: "GET",
                            data: { tehsil_id: tehsilId },
                            success: function(data) {
                                $.each(data, function(key, value) {
                                    $('#union_council_id').append('<option value="' + key + '">' + value + '</option>');
                                });
                            }
                        });
                    }
                });
            @endif

            // Trigger changes for edit mode
            @if($isEdit)
                @if($module !== 'province')
                    $('#province_id').trigger('change');
                    setTimeout(function() {
                        $('#district_id').val('{{ old("district_id", $selectedDistrictId ?? "") }}').trigger('change');
                        @if(in_array($module, ['tehsil', 'union-council', 'village']))
                            setTimeout(function() {
                                $('#tehsil_id').val('{{ old("tehsil_id", $selectedTehsilId ?? "") }}').trigger('change');
                                @if(in_array($module, ['union-council', 'village']))
                                    setTimeout(function() {
                                        $('#union_council_id').val('{{ old("union_council_id", $selectedUnionCouncilId ?? "") }}');
                                    }, 500);
                                @endif
                            }, 500);
                        @endif
                    }, 500);
                @endif
            @endif
        });
    </script>
@endpush
