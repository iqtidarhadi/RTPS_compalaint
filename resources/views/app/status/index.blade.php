@extends('layouts.layout')

@push('stylesheets')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-select-bs5/select.bootstrap5.css') }}" />
@endpush

@section('content')
    <div class="layout-top-spacing mb-2 m-2">
        <div class="col-md-12">
            <div class="row">
                <div class="container p-0">
                    <div class="row date-table-container">
                        <!-- Datatable Container -->
                        <div class="col-xl-12 col-lg-12 col-sm-12 card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Status Listings</h5>
                                @can('boq-create')
                                    <a href="{{ route('status.create') }}" class="btn btn-primary">Create</a>
                                @endcan
                            </div>
                            <div class="card-body">
                                <div class="table-responsive mb-4">
                                    <table id="myDataTable" class="table table-bordered myDataTable"
                                        data-route="{{ route('status.index') }}">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Text</th>
                                                <th>Badge</th>
                                                <th>Color</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/vendor/libs/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-responsive/datatables.responsive.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-select-bs5/select.bootstrap5.js') }}"></script>

    <script src="{{ asset('assets/js/Agriculture/actions/action.js') }}"></script>
    <!-- <script src="{{ asset('assets/js/app-custom.js') }}"></script> -->
    <script>
        $(document).ready(function() {
            var selectedDataIds = [];
            var dataTable = $("#myDataTable");
            var route = dataTable.data("route");
            var relations = (dataTable.attr("raw-relations") || "").split(",");
            var table = dataTable.DataTable({
                pagingType: "full_numbers",
                lengthMenu: [25, 75, 100, 150],
                pageLength: 25,
                processing: true,
                serverSide: true,
                ajax: {
                    url: route,
                    data: {
                        relations: relations || "",
                    },
                },
                columns: [
                    { data: 'id' },
                    { data: 'text' },
                    {
                        data: 'badgeClass',
                        render: function(data, type, row) {
                            return '<span class="badge ' + data + '">' + data + '</span>';
                        }
                    },
                    {
                        data: 'badgeColor',
                        render: function(data, type, row) {
                            return '<span class="badge" style="background-color: ' + data + ';">&nbsp;</span>';
                        }
                    },
                    {
                        data: "action",
                        orderable: false,
                        searchable: false,
                    }
                ]
            });
        });
    </script>
@endpush
