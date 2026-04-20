@extends('layouts.layout')

@push('stylesheets')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endpush

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">{{ $title ?? ($isEdit ? 'Edit' : 'Create') . ' Village' }}</h5>
            <a href="{{ route('app.villages.index') }}" class="btn btn-secondary">Back to List</a>
        </div>

        <div class="card-body">
            <form action="{{ $isEdit ? route('app.villages.update', encryptId($model->id)) : route('app.villages.store') }}" 
                  method="POST" id="villageForm">
                @csrf
                @if($isEdit)
                    @method('PUT')
                @endif
                
                <div class="row g-3">
                    <!-- Village Title -->
                    <div class="col-md-6">
                        <label class="form-label"><strong>Village Title *</strong></label>
                        <input type="text" name="title" class="form-control" placeholder="Enter Village Title"
                            value="{{ old('title', $isEdit ? $model->title : '') }}" required>
                        @error('title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Province -->
                    <div class="col-md-6">
                        <label class="form-label"><strong>Province *</strong></label>
                        <select name="province_id" id="province_id" class="form-control select2" required>
                            <option value="">Select Province</option>
                            @foreach($provinces as $id => $title)
                                <option value="{{ $id }}" {{ old('province_id', $isEdit && $model->unionCouncil && $model->unionCouncil->tehsil && $model->unionCouncil->tehsil->district ? $model->unionCouncil->tehsil->district->province_id : '') == $id ? 'selected' : '' }}>{{ $title }}</option>
                            @endforeach
                        </select>
                        @error('province_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- District -->
                    <div class="col-md-6">
                        <label class="form-label"><strong>District *</strong></label>
                        <select name="district_id" id="district_id" class="form-control select2" required>
                            <option value="">Select District</option>
                            @if(isset($districts))
                                @foreach($districts as $id => $title)
                                    <option value="{{ $id }}" {{ old('district_id', $isEdit && $model->unionCouncil && $model->unionCouncil->tehsil ? $model->unionCouncil->tehsil->district_id : '') == $id ? 'selected' : '' }}>{{ $title }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('district_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tehsil -->
                    <div class="col-md-6">
                        <label class="form-label"><strong>Tehsil *</strong></label>
                        <select name="tehsil_id" id="tehsil_id" class="form-control select2" required>
                            <option value="">Select Tehsil</option>
                            @if(isset($tehsils))
                                @foreach($tehsils as $id => $title)
                                    <option value="{{ $id }}" {{ old('tehsil_id', $isEdit && $model->unionCouncil ? $model->unionCouncil->tehsil_id : '') == $id ? 'selected' : '' }}>{{ $title }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('tehsil_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Union Council -->
                    <div class="col-md-6">
                        <label class="form-label"><strong>Union Council *</strong></label>
                        <select name="union_council_id" id="union_council_id" class="form-control select2" required>
                            <option value="">Select Union Council</option>
                            @if(isset($unionCouncils))
                                @foreach($unionCouncils as $id => $title)
                                    <option value="{{ $id }}" {{ old('union_council_id', $isEdit ? $model->union_council_id : '') == $id ? 'selected' : '' }}>{{ $title }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('union_council_id')
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
                            {{ $isEdit ? 'Update' : 'Create' }} Village
                        </button>
                        <a href="{{ route('app.villages.index') }}" class="btn btn-secondary">Cancel</a>
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

            // For edit mode
            @if($isEdit && $model->unionCouncil && $model->unionCouncil->tehsil && $model->unionCouncil->tehsil->district)
                $('#province_id').trigger('change');
                setTimeout(function() {
                    $('#district_id').val('{{ $model->unionCouncil->tehsil->district_id }}').trigger('change');
                    setTimeout(function() {
                        $('#tehsil_id').val('{{ $model->unionCouncil->tehsil_id }}').trigger('change');
                        setTimeout(function() {
                            $('#union_council_id').val('{{ $model->union_council_id }}');
                        }, 500);
                    }, 500);
                }, 500);
            @endif

            // For validation errors
            @if(old('province_id'))
                $('#province_id').trigger('change');
                setTimeout(function() {
                    $('#district_id').val('{{ old("district_id") }}').trigger('change');
                    setTimeout(function() {
                        $('#tehsil_id').val('{{ old("tehsil_id") }}').trigger('change');
                        setTimeout(function() {
                            $('#union_council_id').val('{{ old("union_council_id") }}');
                        }, 500);
                    }, 500);
                }, 500);
            @endif
        });
    </script>
@endpush
