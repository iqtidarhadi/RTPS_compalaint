@extends('layouts.layout')

@push('stylesheets')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-select-bs5/select.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
@endpush

@section('content')
<div class="card">

    <div class="card-datatable table-responsive pt-0">

        <table id="myDataTable"
               class="table table-bordered myDataTable"
               data-route="{{ route('app.departments.dt.index') }}">

            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>NAME</th>
                    <th>STATUS</th>
                    <th>ACTION</th>
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
        $(document).ready(function () {

            initializeDataTable({
                selector: "#myDataTable",
                title: "{{ $title ?? '' }}",
                method: "POST",

                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'status', name: 'status', orderable: false, searchable: false },
                    { data: 'action', orderable: false, searchable: false }
                ],

                canCreate: @can('department-create') true @else false @endcan,

                createRoute: "{{ route('app.departments.create') }}",

                reloadButtonSelector: "#loadDataButton"
            });

        });
    </script>
@endpush