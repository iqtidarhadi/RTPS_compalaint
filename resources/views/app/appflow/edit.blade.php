@extends('layouts.layout')

@section('title', 'Edit App Flow')

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
                    <div class="col-xl-12 col-lg-12 col-sm-12 card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Edit App Flow</h5>
                        </div>
                        <div class="card-body">
                            
                            {!! Form::model($appFlow, ['route' => ['app_flow.update', $appFlow->id ?? ''], 'method' => 'PATCH']) !!}
                            <div class="" id="addcode">
                                @if(is_iterable($appFlow))
                                @foreach ($appFlow->details as $detail)
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control actionstatus_code_select" name="status_id[]" placeholder="" id="actionstatus_code_select">
                                                <option>Select option</option>
                                                @foreach($statusCode as $status)
                                                    <option value="{{ $status->id }}" {{ $detail->status_id == $status->id ? 'selected' : '' }}>
                                                        {{ $status->text }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <label>Type</label>
                                            <select class="form-control subhead_code_select" name="type[]" placeholder="" id="readstatue_code_select">
                                                <option>Select option</option>
                                                <option value="Read" {{ $detail->type == 'Read' ? 'selected' : '' }}>Read</option>
                                                <option value="Action" {{ $detail->type == 'Action' ? 'selected' : '' }}>Action</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label>Filter Division</label>
                                            <input type="checkbox" class="align-items-center" name="isFilterByDivision[]" id="" {{ $detail->isFilterByDivision ? 'checked' : '' }}>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label>Filter SubDivision</label>
                                            <input type="checkbox" name="isFilterBySubDivision[]" id="" {{ $detail->isFilterBySubDivision ? 'checked' : '' }}>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label>Remove</label>
                                            <button type="button" style="background-color: #bd1121; color:antiquewhite" class="btn bg-red removeline" id="removecode">-</button>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12" style="text-align: end">
                                <a class="btn btn-warning" href="{{ route('app_flow.index') }}">
                                    <i class="bx bx-arrow-back"></i> Back
                                </a>
                                <button type="submit" class="btn btn-primary">Update App Flow</button>
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

@push('plugin-scripts')
<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    function initializeSelect2(element) {
        element.select2({
            ajax: {
                url: "{{ route('getstatuscode') }}",
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: data.map(function(item) {
                            return {
                                id: item.id,
                                text: item.text
                            };
                        })
                    };
                }
            },
            templateResult: function(data) {
                if (!data.id) {
                    return data.text;
                }
                var $result = $('<span>');
                $result.text(data.text);
                return $result;
            }
        });
    }

    $(document).ready(function() {
        $('#AddMore').on('click', function() {
            $('#addcode').append('<div class="row">'+
                '<div class="col-xs-12 col-sm-12 col-md-3">'+
                    '<div class="form-group">'+
                        '<select class="form-control actionstatus_code_select" name="status_id[]"></select>'+
                    '</div>'+
                '</div>'+
                '<div class="col-xs-12 col-sm-12 col-md-3">'+
                    '<div class="form-group">'+
                        '<select class="form-control" name="type[]">'+
                            '<option>Select option</option>'+
                            '<option value="Read">Read</option>'+
                            '<option value="Action">Action</option>'+
                        '</select>'+
                    '</div>'+
                '</div>'+
                '<div class="col-xs-12 col-sm-12 col-md-2">'+
                    '<input type="checkbox" class="align-items-center" name="isFilterByDivision[]">'+
                '</div>'+
                '<div class="col-xs-12 col-sm-12 col-md-2">'+
                    '<input type="checkbox" name="isFilterBySubDivision[]">'+
                '</div>'+
                '<div class="col-xs-12 col-sm-12 col-md-2">'+
                    '<button type="button" style="background-color: #bd1121; color:antiquewhite" class="btn bg-red removeline">-</button>'+
                '</div>'+
            '</div>');

            var newSelectElement = $("#addcode").find('.actionstatus_code_select').last();
            initializeSelect2(newSelectElement);

            $("#addcode").on('click', '.removeline', function() {
                $(this).closest('.row').remove();
            });
        });

        initializeSelect2($('#actionstatus_code_select'));
    });
</script>
@endpush
