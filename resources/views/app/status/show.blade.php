@extends('layouts.layout')

@section('title', 'MB Details')
@push('plugin-styles')

<link rel="stylesheet" href="{{ asset('plugins/maps/leaflet-map/leaflet.css') }}" />
<style>
    .fancybox__container {
        z-index: 999999999 !important;
    }
</style>
@endpush

@section('content')
<!--  Navbar Starts / Breadcrumb Area  -->

<!--  Navbar Ends / Breadcrumb Area  -->
<!-- Main Body Starts -->
<div class="row m-4">
    <div class="col-md-12 widget-content widget-content-area br-6">
        <h4>Mb Details</h4>
        <!-- Details Start  -->
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="show-field">
                    BOQ#:
                    <p class="show-value">{{ $mb->boq_master_id }}</p>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="show-field">
                    Description:
                    <p class="show-value">{{ $mb->boq->head->head }}</p>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="show-field">
                    MB Date:
                    <p class="show-value">{{ date('Y_m_d', strtotime($mb->measurementDate)) }}</p>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="show-field">
                    Visit Count:
                    <p class="show-value">{{ $mb->visit_count }}</p>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="show-field">
                    Latitude:
                    <p class="show-value">{{ $mb->latitude }}</p>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="show-field">
                    Longitude:
                    <p class="show-value">{{ $mb->longitude }}</p>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="show-field">
                    Created By:
                    <p class="show-value">{{ $mb->User->name }}</p>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="show-field">
                    Status:
                    <p class="show-value">{{ $mb->status == 1 ? 'Active' : 'Inactive' }}</p>
                </div>
            </div>
        </div>

        <!-- Details End here  -->

    </div>
</div>


<!-- Mb Item Details Start Here  -->

<div class="row m-4">
    <div class="col-md-12 widget-content widget-content-area br-6">
        <h4>Mb Items Details</h4>
        <table class="table table-bordered table-light">
            <thead class="">
                <tr class="text-center">
                    <th>#</th>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Number</th>
                    <th>Lenght</th>
                    <th>Width</th>
                    <th>Height</th>
                    <th>Total</th>
                    <th>Show Detaile</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalSum = 0; // Variable to store the sum of the "total" values
                $n = 1;
                ?>
                @foreach ($mb->mbchild as $child )
                <tr class="text-center">
                    <td class="text-right">{{ $n }}</td>
                    <td style="width:140px;"><a href="{{ route('mrs.show', $child->mrs->item_id) }}">{{ $child->mrs->item_code ??  '' }}</a></td>
                    <td>{{ $child->mrs->item_name ??  '' }}</td>
                    <td class="text-right">{{ $child->no }}</td>
                    <td class="text-right">{{ $child->lenght }}</td>
                    <td class="text-right">{{ $child->width }}</td>
                    <td class="text-right">{{ $child->height }}</td>
                    <td class="text-right">{{ $child->total }}</td>
                    <td class="text-right"><button type="button" class="btn btn-primary showmodal mb-2 mr-2" data-toggle="modal" data-item-id="{{ $child->id }}"><i class='las la-eye'></i></button></td>
                    <?php
                    $totalSum += $child->total; // Add the "total" value to the sum
                    $n++;
                    ?>
                </tr>

                @endforeach

                <tr>
                    <td colspan="7" class="text-right">SUM:</td>
                    <td class="text-right">{{ $totalSum }}</td>
                </tr>

            </tbody>
        </table>
    </div>
</div>

    {{-- Modal --}}

    <div class="modal fade bd-example-modal-lg show-modal-lg mt-5" id="show-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showitem_code" ></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <h5 class="" id="myLargeModalLabel">></h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Number</th>
                                <th>Length</th>
                                <th>Width</th>
                                <th>Height</th>
                                <th>Total</th>
                                <!-- Add other table headers as needed -->
                            </tr>
                        </thead>
                        <tbody id="search_data">
                            <!-- Table rows with data will be added here dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    
    {{-- End Modal --}}


<!-- End of Mb Items Details  -->
<!-- Add Map Here  -->
<div class="row m-4">
    <div class="col-md-12 widget-content widget-content-area br-6">
        <h4>Location on map</h4>
        <div class="widht-custom">
            <div class="leaflet-map" id="userLocation" style="height: 400px;"></div>
        </div>
    </div>
</div>

<!-- End of Map -->

<livewire:complaints.comment :complaint_id="$mb->id" :model="$mb" />
</div>
<!-- Main Body Ends -->
@endsection



@push('custom-scripts')
<script src="{{ asset('plugins/maps/leaflet-map/leaflet.js') }}"></script>
<script>
{{-- Ajax for Modal To show data of MB Itens --}}

$(document).on('click', '.showmodal', function(){
    var searchdata = $('#search_data');
    var MB_child_Id = $(this).data("item-id");

    $.ajax({
        url:'{{ route("get_mb_items") }}',
        dataType:'json',
        method:'GET',
        data:{
            "_token":"{{ csrf_token() }}",
            MB_child_Id: MB_child_Id,
        },

        success : function(response){
            searchdata.empty();
            var totalSum = 0;
            if (response.length > 0) {
                var mrsData = response[0].mrs;
                $('#myLargeModalLabel').text(mrsData.item_name);
                $('#showitem_code').text(mrsData.item_code);
                $.each(response, function(key , value){
                    searchdata.append(
                        '<tr>'+
                        ' <td>'+value.no+'</td>'+
                        ' <td>'+value.lenght+'</td>'+
                        ' <td>'+value.width+'</td>'+
                        ' <td>'+value.height+'</td>'+
                        ' <td>'+value.total+'</td>'+
                        '</tr>'

                    );
                    totalSum += value.total;
                });
                searchdata.append(
                    '<tr>' +
                    ' <td colspan="4" class="text-right">Total Sum:</td>' +
                    ' <td>' + totalSum + '</td>' +
                    '</tr>'
                );
                
            } else {
                searchdata.append(
                    '<tr>' +
                    ' <td colspan="7" class="text-center">No data found</td>' +
                    '</tr>'
                );
            }
            $("#show-modal-lg").modal("show");

        }
    });
});
{{-- End Aajx --}}

$(document).on('click','.close', function() {
    
        // Manually hide the modal
        $("#show-modal-lg").modal("hide");
    });









    const userLocationVar = document.getElementById('userLocation');
    if (userLocationVar) {
        const myLat = "{{ $mb->latitude }}"; // Replace with your latitude value from Laravel
        const myLong = "{{ $mb->longitude }}"; // Replace with your longitude value from Laravel

        const userLocation = L.map('userLocation').setView([myLat, myLong], 10);

        function onLocationFound(e) {
            const radius = e.accuracy;
            L.marker(e.latlng)
                .addTo(userLocation)
                .bindPopup('You are somewhere around ' + radius + ' meters from this point')
                .openPopup();
            L.circle(e.latlng, radius).addTo(userLocation);
        }
        userLocation.on('locationfound', onLocationFound);
        L.tileLayer('https://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a>',
            maxZoom: 18
        }).addTo(userLocation);


        // Add a marker for the specific point
        L.marker([myLat, myLong])
            .addTo(userLocation)
            // .bindPopup('Dengue Identified')
            .openPopup();
    }
</script>
@endpush