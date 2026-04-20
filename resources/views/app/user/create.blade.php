@extends('layouts.layout')

@push('stylesheets')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endpush

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">{{ $title ?? ''}}</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('app.users.store') }}" method="POST" id="createUserForm">
                @csrf
                <div class="row g-3"> <!-- Added Bootstrap 5 spacing -->
                    <div class="col-md-6">
                        <label class="form-label"><strong>Name</strong></label>
                        <input type="text" name="name" class="form-control" placeholder="Enter Name"
                            value="{{ old('name') }}">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><strong>Email</strong></label>
                        <input type="email" name="email" class="form-control" placeholder="Enter Email"
                            value="{{ old('email') }}">
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><strong>Password</strong></label>
                        <input type="password" name="password" class="form-control" placeholder="Enter Password">
                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><strong>Confirm Password</strong></label>
                        <input type="password" name="password_confirmation" class="form-control"
                            placeholder="Confirm Password">
                        @error('password_confirmation')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>



                    <div class="col-md-6">
                        <label class="form-label"><strong>Role</strong></label>
                        <select name="roles[]" multiple class="form-control select2">
                            @foreach ($roles as $key => $role)
                                <option value="{{ $key }}">{{ $role }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="col-md-6">
                        <label class="form-label"><strong>District</strong></label>
                        <select name="district_id" id="district_id" class="form-control select2">
                            <option value="">Select a District</option>
                            @foreach ($districts as $key => $district)
                                <option value="{{ $key }}">{{ $district }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><strong>Tehsil</strong></label>
                        <select name="tehsil_id" id="tehsil_id" class="form-control dynamic-select" required
                            data-route="{{ route('dynamic.dropDown') }}"
                            data-statment="{{ \Illuminate\Support\Facades\Crypt::encrypt([
                                'model' => 'tehsils',
                                'label' => 'name',
                                'value' => 'id',
                            ]) }}"
                            data-conditions='@json(['column' => 'district_id', 'operator' => '=', 'value' => 'district_id'])'>

                            <option value="" disabled selected>Select a Tehsil</option>

                        </select>

                    </div>

                </div>
            </form>
        </div>

        <div class="card-footer text-end">
            <a class="btn btn-warning" href="{{ route('app.users.index') }}">
                <i class="bx bx-arrow-back"></i> Back
            </a>
            <button type="submit" form="createUserForm" class="btn btn-primary">Create User</button>
        </div>
    </div>


    <!-- action Model To Be Performed by  -->
@endsection

@push('plugin-scripts')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
@endpush
@push('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').each(function() {
                var placeholderText = $(this).data('placeholder') || 'Select an option';
                $(this).select2({
                    placeholder: placeholderText,
                    allowClear: true
                });
            });
        });
    </script>

    <script src="{{ asset('assets/js/common/drop-down.js') }}"></script>
@endpush
