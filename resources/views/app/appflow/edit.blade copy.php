@extends('layouts.layout')

@section('title', 'Create AppFlow')
@push('plugin-styles')

 <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endpush

@section('content')
<!--  Navbar Starts / Breadcrumb Area  -->

<!--  Navbar Ends / Breadcrumb Area  -->
<!-- Main Body Starts -->
<div class="layout-px-spacing ">
    <div class="layout-top-spacing mb-2">
        <div class="row layout-top-spacing date-table-container ">

            <!-- Datatable go to last page -->
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="table-header">Set Flow For {{$model->name ?? ''}}</h4>

                        </div>

                    </div>

                    {!! Form::open(['route' => 'app_flow.store', 'method' => 'POST']) !!}
                    <div id="addcode">
                        <h5>MB Listings (List With Status)</h5>
                        <div class="row">
                            <input class="form-control" value="{{ $model->id }}" type="hidden" name="role_id">
                            <div class="col-xs-12 col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control actionstatus_code_select" multiple name="read_status_id[]" placeholder="" id="actionstatus_code_select">
                                        <option value="">NIL</option>
                                        @foreach($statuses as $key=> $status)
                                        <option value="{{$status->id}}" {{$appFlow && $appFlow->isReadStatusAvailable($status->id) ? 'selected':''}}>{{$status->text}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>



                            <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label>Filter Division </label>
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" class="align-items-center" value="1" name="isFilterByDivision" {{$appFlow->isFilterByDivision ?? 0==1 ? 'checked' : ''}}>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label>Filter SubDivision</label>
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" value="1" name="isFilterBySubDivision" {{$appFlow->isFilterBySubDivision?? 0 ==1 ? 'checked' : ''}}>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label>Filter By Status</label>
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" value="1" name="isFilterByStatus" {{$appFlow->isFilterByStatus?? 0 ==1 ? 'checked' : ''}}>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="addcode">
                        <h5>Action (User Will Perfume Following Action ) </h5>
                        <div class="row">
                            <input class="form-control" value="{{ $model->id }}" type="hidden" name="role_id">
                            <div class="col-xs-12 col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control actionstatus_code_select" multiple name="action_status_id[]" placeholder="" id="actionstatus_code_select">
                                        <option value="">NIL</option>
                                        @foreach($statuses as $key=> $status)
                                        <option value="{{$status->id}}" {{$appFlow && $appFlow->isActionStatusAvailable($status->id)==true ? 'Selected':''}}>{{$status->text}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-12 text-right">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('plugin-scripts')
 <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
@endpush

@push('custom-scripts')

@endpush