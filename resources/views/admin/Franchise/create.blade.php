@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/app-assets/vendors/css/forms/select/select2.min.css') }}">
@endsection

@section('content')

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h5 class="content-header-title float-left pr-1 mb-0">Franchise</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active"><a href="{{ route('admin-staff-index') }}">Manage Staff</a>
                            </li>
                            <li class="breadcrumb-item">Add Franchise
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Basic Vertical form layout section start -->
        <section id="basic-vertical-layouts">
            <div class="row match-height">
                <div class="col-md-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Add Franchise</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                            <form autocomplete="off" id="form_franchise" method="POST" action="{{ route('franchise-store') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="user_id" value="{{ $user_id }}">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                        <label class="form-label">Services</label>
                                            <select name="service_id[]" id="f_service_ids" class="select2 form-control" multiple="multiple">
                                                @foreach($services as $service)
                                                    <option value="{{ $service->id }}" {{!empty(old('service_id')) && in_array($service->id, old('service_id')) ? 'selected' : ''}}>{{ $service->title }}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('service_id'))
                                                <label id="name-error" class="error" for="service_id">{{ $errors->first('service_id') }}</label>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label class="form-label">Country</label>
                                            <select name="country_id" id="f_country_id" class="form-control select-box">
                                                    <option value="">Select Country</option>
                                                @foreach($countries as $country)
                                                    <option value="{{ $country->id }}" {{ $country->id == old('country_id',$lead->country_id) ? 'selected':''}}>{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('country_id'))
                                                <label id="name-error" class="error" for="country">{{ $errors->first('country') }}</label>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                        <label class="form-label">State</label>
                                            <select name="state_id" id="f_state_id" class="form-control select-box">
                                                <option value=""> Select State</option>
                                            </select>
                                            @if($errors->has('state_id'))
                                                <label id="name-error" class="error" for="state_id">{{ $errors->first('state_id') }}</label>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label class="form-label">City</label>
                                            <select name="city_id" id="f_city_id" class="form-control select-box">
                                                <option value=""> Select City</option>
                                            </select>
                                            @if($errors->has('city_id'))
                                                <label id="name-error" class="error" for="city_id">{{ $errors->first('city_id') }}</label>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label class="form-label">Franchise Name</label>
                                            <input type="text" class="form-control @if($errors->has('franchise_name')) is-invalid @endif" name="franchise_name" autocomplete="off" value="{{old('franchise_name')}}">
                                            @if($errors->has('franchise_name'))
                                                <label id="name-error" class="error" for="franchise_name">{{ $errors->first('franchise_name') }}</label>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label class="form-label">Address</label>
                                            <input type="text" class="form-control @if($errors->has('address_1')) is-invalid @endif" name="address_1" autocomplete="off" value="{{old('address_1')}}">
                                            @if($errors->has('address_1'))
                                                <label id="name-error" class="error" for="address_1">{{ $errors->first('address_1') }}</label>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label class="form-label">Address 2</label>
                                            <input type="text" class="form-control @if($errors->has('address_2')) is-invalid @endif" name="address_2" autocomplete="off" value="{{old('address_2')}}">
                                            @if($errors->has('address_2'))
                                                <label id="name-error" class="error" for="address_2">{{ $errors->first('address_2') }}</label>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label class="form-label">Pincode</label>
                                            <input type="text" class="form-control @if($errors->has('pincode')) is-invalid @endif" name="pincode" autocomplete="off" value="{{old('pincode')}}">
                                            @if($errors->has('pincode'))
                                                <label id="name-error" class="error" for="pincode">{{ $errors->first('pincode') }}</label>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label class="form-label">Mobile Number</label>
                                            <input type="text" class="form-control @if($errors->has('mobile')) is-invalid @endif" name="mobile" autocomplete="off" value="{{ old('mobile',$lead->phone) }}">
                                            @if($errors->has('mobile'))
                                                <label id="name-error" class="error" for="mobile">{{ $errors->first('mobile') }}</label>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label class="form-label">Email</label>
                                            <input type="text" class="form-control @if($errors->has('email')) is-invalid @endif" name="email" autocomplete="off" value="{{ old('email',$lead->email) }}">
                                            @if($errors->has('email'))
                                                <label id="name-error" class="error" for="email">{{ $errors->first('email') }}</label>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label class="form-label">Commission(%)</label>
                                            <input type="text" class="form-control @if($errors->has('commission')) is-invalid @endif" name="commission" autocomplete="off" value="{{old('commission')}}">
                                            @if($errors->has('commission'))
                                                <label id="name-error" class="error" for="commission">{{ $errors->first('commission') }}</label>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    @php
                                        $hours_arr = range(0,24);
                                        $minute_arr = range(0,59);
                                    @endphp
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <label class="form-label">Delivery Time (Hours)</label>
                                                    <select name="hour" id="hour" class="form-control select-hour">
                                                        <option value="">Select Hours</option>
                                                        @foreach($hours_arr as $hour)
                                                        <option value="{{$hour}}" {{ (old('hour') == "$hour" ? 'selected':'') }}>{{$hour}}</option>
                                                        @endforeach
                                                    </select>
                                                    @if($errors->has('hour'))
                                                        <label id="name-error" class="error" for="hour">{{ $errors->first('hour') }}</label>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <label class="form-label">Delivery Time (Minute)</label>
                                                    <select name="minute" id="minute" class="form-control select-hour">
                                                        <option value="" selected>Select Minute</option>
                                                        @foreach($minute_arr as $minute)
                                                        <option value="{{$minute}}"  {{ (old('minute') == "$minute" ? 'selected':'') }}>{{$minute}}</option>
                                                        @endforeach
                                                    </select>
                                                    @if($errors->has('minute'))
                                                        <label id="name-error" class="error" for="minute">{{ $errors->first('minute') }}</label>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label class="form-label">Working City</label>
                                            <select name="working_cities[]" id="working_cities" class="form-control select-box" multiple>
                                                @foreach($cities as $city)
                                                    <option value="{{$city->id}}" {{!empty(old('working_cities')) && in_array($city->id,old('working_cities')) ? 'selected':''}}> {{$city->name}}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('working_cities'))
                                                <label id="name-error" class="error" for="working_cities">{{ $errors->first('working_cities') }}</label>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <label class="form-label">Latitude</label>
                                                    <div id="latitude">
                                                        <input type="text" class="form-control @if($errors->has('latitude')) is-invalid @endif" id="latitude" autocomplete="off" name="latitude" value="{{old('latitude')}}">
                                                    </div>
                                                    @if($errors->has('latitude'))
                                                        <label id="name-error" class="error" for="latitude">{{ $errors->first('latitude') }}</label>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <label class="form-label">Longitude</label>
                                                    <div id="longitude">
                                                        <input type="text" class="form-control @if($errors->has('longitude')) is-invalid @endif" id="longitude" name="longitude" autocomplete="off" value="{{old('longitude')}}">
                                                    </div>
                                                    @if($errors->has('longitude'))
                                                        <label id="name-error" class="error" for="longitude">{{ $errors->first('longitude') }}</label>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <input type="text" class="form-control" id="location_search" name="location_search" type="text" size="50" value="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div id="floating-panel" class="pt-2">
                                        <input id="hide-markers" type="button" value="Hide Markers" class="hidden"/>
                                        <input id="show-markers" type="button" value="Show Markers" class="hidden" />
                                        <input id="delete-markers" type="button" value="Reset Area" class="btn btn-danger" />
                                      </div>
                                </div>
                            </div>
                                <input type="hidden" class="form-control" id="lat1" name="area_lat1" value="{{old('area_lat1')}}">
                                <input type="hidden" class="form-control" id="lng1" name="area_lng1" value="{{old('area_lng1')}}">
                                <input type="hidden" class="form-control" id="lat2" name="area_lat2" value="{{old('area_lat2')}}">
                                <input type="hidden" class="form-control" id="lng2" name="area_lng2" value="{{old('area_lng2')}}">
                                <div class="mt-2" id="map" style="width:100%;height:500px;"></div>
                                <button class="btn btn-primary waves-effect mt-1" type="submit">SUBMIT</button>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- // Basic Vertical form layout section end -->
    </div>
</div>

@endsection

@section('scripts')


<!-- BEGIN: Page Vendor JS-->
<script src="{{ asset('assets/admin-assets/app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key={{env('GOOGLE_API_KEY')}}"></script>
<!-- END: Page Vendor JS-->

<script>

var lat = {{!empty(old('latitude')) ? old('latitude') : 21.16486108042384}};
var lng = {{!empty(old('longitude')) ? old('longitude') : 72.83420567685027}};

var area_lat1 = "{{old('area_lat1')}}";
var area_lng1 = "{{old('area_lng1')}}";
var area_lat2 = "{{old('area_lat2')}}";
var area_lng2 = "{{old('area_lng2')}}";
if(area_lat1){
    area_lat1 = parseFloat(area_lat1);
}
if(area_lng1){
    area_lng1 = parseFloat(area_lng1)
}
if(area_lat2){
    area_lat2 = parseFloat(area_lat2)
}
if(area_lng2){
    area_lng2 = parseFloat(area_lng2)
}

var searchInput = 'location_search';

let map;
let markers = [];

var total_marker = 0;
function initMap2(lat,lng) {
    const default_loc = { lat: lat, lng: lng };

    map = new google.maps.Map(document.getElementById("map"), {
            zoom: 12,
            center: default_loc,
            mapTypeId: "terrain",
    });
    // This event listener will call addMarker() when the map is clicked.
    map.addListener("click", (event) => {
        addMarker(event.latLng);
    });
    // add event listeners for the buttons
    document.getElementById("show-markers").addEventListener("click", showMarkers);
    document.getElementById("hide-markers").addEventListener("click", hideMarkers);
    document.getElementById("delete-markers").addEventListener("click", deleteMarkers);
    // Adds a marker at the center of the map.

    var default_marker = new google.maps.Marker({
        position: default_loc
    });
    defaultPlaceMarker(default_loc, map, default_marker);

    if(area_lat1 && area_lng1 && area_lat2 && area_lng2){
        existing_position1 = { lat: area_lat1, lng: area_lng1 };
        existing_marker1 = new google.maps.Marker({
            existing_position1,
            map,
        });
        markers.push(existing_marker1);
        existingPlaceMarker(existing_position1, map, existing_marker1);

        existing_position2 = { lat: area_lat2, lng: area_lng2 };
        existing_marker2 = new google.maps.Marker({
            existing_position2,
            map,
        });
        markers.push(existing_marker2);
        existingPlaceMarker(existing_position2, map, existing_marker2);
        generate_area(area_lat1,area_lat2,area_lng1,area_lng2)
    }
}

function existingPlaceMarker(latlng, map, marker) {
    marker.setPosition(latlng);
    marker.setMap(map);
   // map.panTo(latlng);
}
function defaultPlaceMarker(latlng, map, marker) {
    marker.setPosition(latlng);
    marker.setMap(map);
    map.panTo(latlng);
}
var rectangle = null;

function generate_area(lat1,lat2,lng1,lng2){
    north = Math.max(lat1,lat2);
    south = Math.min(lat1,lat2);

    east = Math.max(lng1,lng2);
    west = Math.min(lng1,lng2);

        rectangle = new google.maps.Rectangle({
        strokeColor: "#FF0000",
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: "#FF0000",
        fillOpacity: 0.35,
        map,
        bounds: {
            north: north,
            south: south,
            east: east,
            west: west,
        },
    });
}
// Adds a marker to the map and push to the array.
function addMarker(position) {
    if(markers.length < 2){
            const marker = new google.maps.Marker({
            position,
            map,
        });
        markers.push(marker);
        if(markers.length == 2){
            var lat1 = markers[0].getPosition().lat();
            var lng1 = markers[0].getPosition().lng();

            var lat2 = markers[1].getPosition().lat();
            var lng2 = markers[1].getPosition().lng();

            $('#lat1').val(lat1);
            $('#lng1').val(lng1);
            $('#lat2').val(lat2);
            $('#lng2').val(lng2);
            generate_area(lat1,lat2,lng1,lng2)

        }
    }

}

// Sets the map on all markers in the array.
function setMapOnAll(map) {
  for (let i = 0; i < markers.length; i++) {
    markers[i].setMap(map);
  }
}

// Removes the markers from the map, but keeps them in the array.
function hideMarkers() {
  setMapOnAll(null);
}

// Shows any markers currently in the array.
function showMarkers() {
  setMapOnAll(map);
}

// Deletes all markers in the array by removing references to them.
function deleteMarkers() {
  hideMarkers();
  markers = [];
  rectangle.setMap(null);
    //   drawingManager.setOptions({
    //     drawingControl: true
    //   });
}
initMap2(lat,lng);

$(document).ready(function () {
  var autocomplete;

    autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {
        types: ['geocode']
    });
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        var results = autocomplete.getPlace();

        lat = results.geometry.location.lat();
        lng = results.geometry.location.lng();

        $('#longitude').html('<input type="text" class="form-control" name="longitude" value="' + lng+ '">');
        $('#latitude').html('<input type="text" class="form-control" name="latitude" value="' + lat+ '">');
        initMap2(lat,lng);

    });
});


$(".select2").select2({
    // the following code is used to disable x-scrollbar when click in select input and
    // take 100% width in responsive also
    placeholder: "Select Service",
    dropdownAutoWidth: true,
    width: '100%'
});


$('#f_country_id').on('change', function () {

    var country_id = $(this).val();
    var _token = $("#form_franchise input[name='_token']").val();


    $.ajax({
        url: "{{route('ajax-country')}}",
        type: 'POST',
        data: { country_id: country_id, _token: _token },
        success: function (data) {

            selected = "{{old('state_id')}}";
            states_id = "{{ $lead->state_id }}";
            $('#f_state_id').empty();
            $('#f_state_id').append('<option value ="">Select State</option>');
            $.each(data, function (inedx, subcatObj) {
                select = states_id == (selected,subcatObj.id) ? 'selected':'';
                $('#f_state_id').append('<option value ="' + subcatObj.id + '" '+select+'>' + subcatObj.name + '</option>');
            });
            $('#f_state_id').trigger('change');
        }
    });

});


$('#f_state_id').on('change', function () {
    var state_id = $(this).val();
    var _token = $("#form_franchise input[name='_token']").val();

    $.ajax({
        url: "{{route('ajax-state')}}",
        type: 'POST',
        data: { state_id: state_id, _token: _token },
        success: function (data) {
            selected = "{{old('city_id')}}";
            citys_id = "{{ $lead->city_id }}";
            $('#f_city_id').empty();
            $('#f_city_id').append('<option value ="">Select City</option>');
            $.each(data, function (inedx, subcatObj) {
                select = citys_id == (selected,subcatObj.id) ? 'selected':'';
                $('#f_city_id').append('<option value ="' + subcatObj.id + '"'+select+'>' + subcatObj.name + '</option>');
            });
        }
    });

});

$(".select-box").select2({
    // the following code is used to disable x-scrollbar when click in select input and
    // take 100% width in responsive also
    dropdownAutoWidth: true,
    width: '100%'
});

$(".select-hour").select2({
    // the following code is used to disable x-scrollbar when click in select input and
    // take 100% width in responsive also
    dropdownAutoWidth: true,
    width: '100%'
});

$('#working_cities').select2({
    placeholder: "Select Working City",
    dropdownAutoWidth: true,
    width: '100%'
});

$(document).ready(function(){
    $('#f_country_id').trigger('change');
});


</script>

@endsection
