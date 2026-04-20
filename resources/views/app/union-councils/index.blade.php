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
            <table id="myDataTable" class="table table-bordered myDataTable" data-route="{{ route('app.union-councils.dt.index') }}">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Tehsil</th>
                        <th>District</th>
                        <th>Province</th>
                        <th>Status</th>
                        <th>Action</th>
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
                title: "Union Council Listings",
                method: "POST",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'title', name: 'title' },
                    { data: 'tehsil_title', name: 'tehsil.title' },
                    { data: 'district_title', name: 'tehsil.district.title' },
                    { data: 'province_title', name: 'tehsil.district.province.title' },
                    { data: 'status', name: 'active', orderable: false, searchable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                canCreate: @can('union-council-create') true @else false @endcan,
                createRoute: "{{ route('app.union-councils.create') }}"
            });
        });
    </script>
@endpush
