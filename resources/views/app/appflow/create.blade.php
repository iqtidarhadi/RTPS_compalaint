@extends('layouts.layout')

@section('title', 'Create App Flow')

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
                            <h5 class="card-title mb-0">Create App Flow </h5>
                        </div>
                        <div class="card-body">
                            {!! Form::open(['route' => 'app_flow.store', 'method' => 'POST']) !!}
                            <div class="" id="addcode">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control actionstatus_code_select" name="status_id[]" placeholder="" id="actionstatus_code_select">
                                                <option>Select option</option>
                                                @foreach($statusCode as $status)
                                               `  <option value="{{ $status->id }}">{{ $status->text }}</option>
                                               @endforeach
                                            </select>
            
                                            {{--  @error('subhead_id')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                            @enderror  --}}
                                        </div>
                                    </div>
    
    
                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <label>Type</label>
                                            <select class="form-control subhead_code_select " name="type[]" placeholder="" id="readstatue_code_select">
                                                <option>Select option</option>
                                                <option value="Read">Read</option>
                                                <option value="Action">Action</option>
            
                                            </select>
            
                                            {{--  @error('subhead_id')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                            @enderror  --}}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label>Filter  Division </label>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" class="align-items-center" name="isFilterByDivision[]" id="">
                                        </div>
                                    </div>
    
                                    <div class="col-xs-12 col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label>Filter SubDivision</label>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" name="isFilterBySubDivision[]" id="">
                                        </div>
                                    </div>
    
                                    <div class="col-xs-12 col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label>Add more</label>
                                        </div>
                                        <div class="form-group">
                                            <button type="button" style="background-color: #4165a7; color:antiquewhite " class="btn bnt-primary" id="AddMore">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <div class="col-xs-12 col-sm-12 col-md-12"  style="text-align: end">
                                    <a class="btn btn-warning " href="{{ route('app_flow.index') }}">
                                        <i class="bx bx-arrow-back"></i> Back
                                    </a>
                                    <button type="submit" class="btn btn-primary " style="">Create App Flow</button>
                                </div>
                            {{-- <div class="row">
    
                                <div class="col-xs-12 col-sm-12 col-md-12 text-right">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div> --}}
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
@push('stylesheets')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
@endpush
{!! Html::script('assets/js/common/drop-down.js') !!}
@endpush


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
    
    $('#AddMore').on('click', function(){
        $('#addcode').append('<div class="row">'+
            '<div class="col-xs-12 col-sm-12 col-md-3">'+
                '<div class="form-group">'+
                    
                    '<select class="form-control actionstatus_code_select " name="status_id[]" placeholder="" id="actionstatus_code_select">'+
                    '</select>'+
                '</div>'+
            '</div>'+
            '<div class="col-xs-12 col-sm-12 col-md-3">'+
                '<div class="form-group">'+
                    '<select class="form-control  " name="type[]" placeholder="" id="readstatue_code_select">'+
                        '<option>Select option</option>'+
                        '<option value="Read">Read</option>'+
                        '<option value="Action">Action</option>'+

                    '</select>'+
                '</div>'+
            '</div>'+
            '<div class="col-xs-12 col-sm-12 col-md-2">'+
                '<div class="form-group">'+
                '</div>'+
                '<div class="form-group">'+
                    '<input type="checkbox" class="align-items-center" name="isFilterByDivision[]" id="">'+
                '</div>'+
            '</div>'+

            '<div class="col-xs-12 col-sm-12 col-md-2">'+
                '<div class="form-group">'+
                    '</div>'+
                '<div class="form-group">'+
                    '<input type="checkbox" name="isFilterBySubDivision[]" id="">'+
                '</div>'+
            '</div>'+

            '<div class="col-xs-12 col-sm-12 col-md-2">'+
                
                '<div class="form-group">'+
                    '<button type="button" style="background-color: #bd1121; color:antiquewhite" class="btn bg-red removeline" id="removecode">-</button>'+
                '</div>'+
            '</div>'+
        '</div>'
);
var newSelectElement = $("#addcode").find('.actionstatus_code_select').last();
initializeSelect2(newSelectElement);
        $("#addcode").on('click', '.removeline', function() {
        $(this).closest('.row').remove();
    });
    });

    $('#actionstatus_code_select').select2({
                ajax: {
                    url: "{{ route('getstatuscode') }}",
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: data.map(function(data) {
                                return {
                                    id: data.id,
                                    text: data.text
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


            
        });

    
</script>
    
@endpush
