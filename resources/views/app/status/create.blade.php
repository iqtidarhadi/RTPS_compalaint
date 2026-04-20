@extends('layouts.layout')


@section('title', 'Create Status')

@push('plugin-styles')
{!! Html::style('plugins/table/datatable/datatables.css') !!}

@endpush

@push('stylesheets')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
@endpush
@section('content')
<div class="layout-top-spacing mb-2 m-2">
    <div class="col-md-12">
        <div class="row">
            <div class="container p-0">
                <div class="row date-table-container">
                    <!-- Datatable go to last page -->
                    <div class="col-xl-12 col-lg-12 col-sm-12  card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Create Status </h5>
                        </div>
                        <div class="card-body">

                        {!! Form::open(['route' => 'status.store', 'method' => 'POST']) !!}
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Status Name:</label>
                                {!! Form::text('text', null, ['placeholder' => 'Status Name', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Status Color (Web):</label>
                                <select name="badgeClass" id="badgeClass" class="form-control">
                                    <option value="" disabled selected>Select Badge Class</option>
                                    <option value="bg-primary" style="background-color: #007bff;">
                                        <label>Primary (Blue)</label>
                                    </option>
                                    <option value="bg-secondary" style="background-color: #6c757d;">
                                        <label>Secondary (Gray)</label>
                                    </option>
                                    <option value="bg-success" style="background-color: #28a745;">
                                        <label>Success (Green)</label>
                                    </option>
                                    <option value="bg-danger" style="background-color: #dc3545;">
                                        <label>Danger (Red)</label>
                                    </option>
                                    <option value="bg-warning" style="background-color: #ffc107;">
                                        <label>Warning (Yellow)</label>
                                    </option>
                                    <!-- Add more options for other badge classes and colors as needed -->
                                </select>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Status Color (For Mobile):</label>
                                <input type="color" name="badgeColor" id="badgeColor" class="form-control" placeholder="badgeColor">
                            </div>
                        </div>
                            <div class="row" style=" margin-left:50px">
                                <div class="col-md-12" style="text-align: right">
                                    <a class="btn btn-warning" href="{{ route('status.index') }}">
                                        <i class="bx bx-arrow-back"></i> Back
                                    </a>
                                    <button type="submit" class="btn btn-primary ">Create Executive Status</button>
                                </div>
                            </div>
                    </div>
                    {!! Form::close() !!}      
                         
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</div>



<!-- action Model To Be Performed by  -->
@endsection



@push('plugin-scripts')
 <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
@push('stylesheets')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
@endpush
{!! Html::script('assets/js/common/drop-down.js') !!}
@endpush
