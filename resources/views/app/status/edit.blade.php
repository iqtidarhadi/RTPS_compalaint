@extends('layouts.layout')
@section('title', 'Edit Tax')
@push('plugin-styles')
     <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
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
                    <div class="col-xl-12 col-lg-12 col-sm-12 card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Edit Tax</h5>
                        </div>
                        <div class="card-body">
                            
                            {!! Form::model($status, ['method' => 'PATCH', 'route' => ['status.update', $status->id]]) !!}
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label>Status Name:</label>
                                        {!! Form::text('text', $status->text, ['placeholder' => 'Status Name', 'class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label>Status Color (Web):</label>
                                        <select name="badgeClass" id="badgeClass" class="form-control">
                                            <option value="" disabled>Select Badge Class</option>
                                            <option value="bg-primary" style="background-color: #007bff;" @if($status->badgeClass == 'badge-primary') selected @endif>Primary (Blue)</option>
                                            <option value="bg-secondary" style="background-color: #6c757d;" @if($status->badgeClass == 'badge-secondary') selected @endif>Secondary (Gray)</option>
                                            <option value="bg-success" style="background-color: #28a745;" @if($status->badgeClass == 'badge-success') selected @endif>Success (Green)</option>
                                            <option value="bg-danger" style="background-color: #dc3545;" @if($status->badgeClass == 'badge-danger') selected @endif>Danger (Red)</option>
                                            <option value="bg-warning" style="background-color: #ffc107;" @if($status->badgeClass == 'badge-warning') selected @endif>Warning (Yellow)</option>
                                            <!-- Add more options for other badge classes and colors as needed -->
                                        </select>
                                    </div>
                                </div>
        
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label>Status Color (For Mobile):</label>
                                        <input type="color" name="badgeColor" id="badgeColor" class="form-control" value="{{ $status->badgeColor }}">
                                    </div>
                                </div>
                                    <div class="col-md-12" style="text-align: end">
                                        <a class="btn btn-warning" href="{{ route('status.index') }}">
                                            <i class="bx bx-arrow-back"></i> Back
                                        </a>
                                        <button type="submit" class="btn btn-primary ">Update Executive Status</button>
                               </div>
                                {{-- <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div> --}}
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


