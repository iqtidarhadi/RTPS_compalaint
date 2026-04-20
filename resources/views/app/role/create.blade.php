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
            <form action="{{ route('app.roles.store') }}" method="POST" id="createRoleForm">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label"><strong>Name</strong></label>
                        <input type="text" name="name" class="form-control" placeholder="Enter Role Name" required>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                  
                </div>

                <div class="table-responsive border rounded mt-4">
                    
                    <table class="table table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th>Module</th>
                                <th>View</th>
                                <th>Create</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($menus as $menu)
                                <tr>
                                    <td>{{ ucfirst($menu->title) }}</td>
                                    @foreach ($menu->permissionsList as $value)
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="permission[]"
                                                    value="{{ $value->id }}" id="per_{{ $value->id }}">
                                                <label class="form-check-label" for="per_{{ $value->id }}"></label>
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <hr>
                    <table class="table table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th>Other Permissions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $pr)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permission[]"
                                                value="{{ $pr->id }}" id="per_{{ $pr->id }}">
                                            <label class="form-check-label text-dark"
                                                for="per_{{ $pr->id }}">{{ $pr->name }}</label>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </form>
        </div>

        <div class="card-footer text-end">
            <a class="btn btn-warning" href="{{ route('app.roles.index') }}">
                <i class="bx bx-arrow-back"></i> Back
            </a>
            <button type="submit" form="createRoleForm" class="btn btn-primary">Create Role</button>
        </div>
    </div>
@endsection

@push('plugin-scripts')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Select Role",
                allowClear: true
            });
        });
    </script>
@endpush
