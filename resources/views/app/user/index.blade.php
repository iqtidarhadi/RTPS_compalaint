@extends('layouts.layout')

@push('stylesheets')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-select-bs5/select.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
@endpush

@section('content')
    <div class="card">
        {{-- <div class="card-header">
                <h3 class="card-title">Users</h3>
                <input type="text" id="employee_id" data-filter="employee_id" placeholder="Employee ID">
                <button id="loadDataButton">Reload Data</button>
            </div> --}}
        <div class="card-datatable table-responsive pt-0">
            <table id="myDataTable" class="table table-bordered myDataTable" data-route="{{ route('app.users.dt.index') }}">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>NAME</th>
                        <th>EMAIL</th>
                        <th>ROLE</th>
                        <th></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    <script>
        $(document).ready(function() {
            initializeDataTable({
                selector: "#myDataTable",
                title: "{{ $title ?? '' }}",
                method: "POST",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: null,
                        render: function(data) {
                            return '<span class="badge bg-primary">' + data.role + '</span>';
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "action",
                        orderable: false,
                        searchable: false
                    }
                ],
                canCreate: @can('user-create')
                    true
                @else
                    false
                @endcan ,
                createRoute: "{{ route('app.users.create') }}",
                reloadButtonSelector: "#loadDataButton" // Reload on button click
            });
        });
    </script>
@endpush
