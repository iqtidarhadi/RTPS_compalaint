@extends('complaint::layouts.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">User /</span> Profile
        </h4>

        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Update Profile Information</h5>
                    </div>
                    <div class="card-body">
                        @include('complaint::profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Update Password</h5>
                    </div>
                    <div class="card-body">
                        @include('complaint::profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Delete Account</h5>
                    </div>
                    <div class="card-body">
                        @include('complaint::profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
