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
                    <h5 class="content-header-title float-left pr-1 mb-0">Franchise Profile</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item">Edit Franchise Profile
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.flash-message')
        <!-- Basic Vertical form layout section start -->
        <section id="basic-vertical-layouts">
            <div class="row match-height">
                <div class="col-md-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Edit Franchise Profile</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form id="form_franchise" method="POST" action="{{ route('franchises-profile.update',$franchise->id) }}" enctype="multipart/form-data">
                                {{ method_field('PUT') }}
                                {{ csrf_field() }}
                                    <input type="hidden" name="user_id" value="{{ $franchise->user_id }}">
                                    <div class="row">
                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <div class="form-line">
                                                <label class="form-label">Services</label>
                                                    <select name="service_id[]" id="f_service_ids" class="select2 form-control" multiple="multiple" disabled="true">
                                                        @foreach($services as $service)
                                                            <option value="{{ $service->id }}" {{ in_array($service->id ,old('service_id',$franchise_services)) ? 'selected':'' }}>{{ $service->title }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if($errors->has('service_id'))
                                                        <label id="name-error" class="error" for="service_id">{{ $errors->first('service_id') }}</label>
                                                    @endif
                                                </div>
                                            </div> 

                                            <div class="form-group">
                                                <div class="form-line">
                                                    <label class="form-label">State</label>
                                                    <select name="state_id" id="f_state_id" class="form-control select-box">
                                                        <option value=""></option>
                                                        @foreach($states as $state)
                                                            <option value="{{ $state->id }}" {{ $franchise->state_id == old('state_id',$state->id) ? 'selected':''}}>{{ $state->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if($errors->has('state_id'))
                                                        <label id="name-error" class="error" for="state_id">{{ $errors->first('state_id') }}</label>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <label class="form-label">Franchise Name</label>
                                                    <input type="text" class="form-control @if($errors->has('franchise_name')) is-invalid @endif" name="franchise_name" value="{{ old('franchise_name',$franchise->franchise_name) }}">
                                                    @if($errors->has('franchise_name'))
                                                        <label id="name-error" class="error" for="franchise_name">{{ $errors->first('franchise_name') }}</label>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <label class="form-label">Second Address</label>
                                                    <input type="text" class="form-control @if($errors->has('address_2')) is-invalid @endif" name="address_2" value="{{ old('address_2',$franchise->address_2) }}">
                                                    @if($errors->has('address_2'))
                                                        <label id="name-error" class="error" for="address_2">{{ $errors->first('address_2') }}</label>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <label class="form-label">Mobile Number</label>
                                                    <input type="text" class="form-control @if($errors->has('mobile')) is-invalid @endif" name="mobile" value="{{ old('mobile',$franchise->mobile) }}">
                                                    @if($errors->has('mobile'))
                                                        <label id="name-error" class="error" for="mobile">{{ $errors->first('mobile') }}</label>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="form-line">
                                                    <label class="form-label">Commission(%)</label>
                                                    <input type="text" class="form-control @if($errors->has('commission')) is-invalid @endif" name="commission" value="{{ old('commission',$franchise->commission) }}">
                                                    @if($errors->has('commission'))
                                                        <label id="name-error" class="error" for="commission">{{ $errors->first('commission') }}</label>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="form-line">
                                                    <label class="form-label">Working City</label>
                                                    <select name="working_cities[]" id="working_cities" class="form-control select-box" multiple>
                                                        @foreach($cities as $city)
                                                            <option value="{{$city->id}}" {{in_array($city->id,old('working_cities',$franchise_work_cities))?'selected':''}}> {{$city->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @if($errors->has('working_cities'))
                                                        <label id="name-error" class="error" for="working_cities">{{ $errors->first('working_cities') }}</label>
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
                                                        <option value="{{ $country->id }}" {{ old('country_id',$franchise->country_id) == $country->id ? 'selected':''}}>{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('country_id'))
                                                    <label id="name-error" class="error" for="country">{{ $errors->first('country') }}</label>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="form-label">City</label>
                                                <select name="city_id" id="f_city_id" class="form-control select-box">
                                                    <option value=""></option>
                                                    @foreach($cities as $city)
                                                        <option value="{{ $city->id }}" {{ old('city_id',$franchise->city_id) == $city->id ? 'selected':''}}>{{ $city->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('city_id'))
                                                    <label id="name-error" class="error" for="city_id">{{ $errors->first('city_id') }}</label>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="form-label">First Address</label>
                                                <input type="text" class="form-control @if($errors->has('address_1')) is-invalid @endif" name="address_1" value="{{ old('address_1',$franchise->address_1) }}">
                                                @if($errors->has('address_1'))
                                                    <label id="name-error" class="error" for="address_1">{{ $errors->first('address_1') }}</label>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="form-label">Pincode</label>
                                                <input type="text" class="form-control @if($errors->has('pincode')) is-invalid @endif" name="pincode" value="{{ old('pincode',$franchise->pincode) }}">
                                                @if($errors->has('pincode'))
                                                    <label id="name-error" class="error" for="pincode">{{ $errors->first('pincode') }}</label>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="form-label">Email</label>
                                                <input type="text" class="form-control @if($errors->has('email')) is-invalid @endif" name="email" value="{{ old('email',$franchise->email) }}">
                                                @if($errors->has('email'))
                                                    <label id="name-error" class="error" for="email">{{ $errors->first('email') }}</label>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label class="form-label">Longitude</label>
                                                        <div id="longitude">
                                                            <input type="text" class="form-control @if($errors->has('longitude')) is-invalid @endif" id="longitude" name="longitude" value="{{ old('longitude',$franchise->longitude) }}">
                                                        </div>
                                                        @if($errors->has('longitude'))
                                                            <label id="name-error" class="error" for="longitude">{{ $errors->first('longitude') }}</label>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label class="form-label">Latitude</label>
                                                        <div id="latitude">
                                                            <input type="text" class="form-control @if($errors->has('latitude')) is-invalid @endif" id="latitude" name="latitude" value="{{ old('latitude',$franchise->latitude) }}">
                                                        </div>
                                                        @if($errors->has('latitude'))
                                                            <label id="name-error" class="error" for="latitude">{{ $errors->first('latitude') }}</label>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                                                            <option value="" selected>Select Hours</option>
                                                            @foreach($hours_arr as $hour)
                                                            <option value="{{$hour}}" {{$hour === old('hour',$franchise->hour)?'selected':''}}>{{$hour}}</option>
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
                                                            <option value="{{$minute}}"  {{$minute === old('minute',$franchise->minute)?'selected':''}}>{{$minute}}</option>
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
                                <input type="text" class="form-control" id="location_search" name="location_search" type="text" size="50" value="">
                                <div class="mt-2" id="map" style="width:100%;height:500px;"></div>
                                <button class="btn btn-primary mt-1" type="submit">UPDATE</button>
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
var lat = {{!empty(old('latitude')) ? old('latitude',$franchise->latitude) : 21.16486108042384}};
var lng = {{!empty(old('longitude')) ? old('longitude',$franchise->longitude) : 72.83420567685027}};
var searchInput = 'location_search';

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

        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: lat, lng: lng},
            zoom: 10
        });
        myLatlng = { lat: lat, lng: lng };
        let infoWindow = new google.maps.InfoWindow({
            content: "Click the map to get Lat/Lng!",
            position: myLatlng,
        });
        infoWindow.open(map);
        map.addListener("click", (mapsMouseEvent) => {
        // Close the current InfoWindow.
        infoWindow.close();
        // Create a new InfoWindow.
        infoWindow = new google.maps.InfoWindow({
        position: mapsMouseEvent.latLng,
        });
        infoWindow.setContent(
        JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2)
        );
        infoWindow.open(map);
        current_latLng = mapsMouseEvent.latLng.toJSON();

        lat = current_latLng.lat;
        lng = current_latLng.lng;
        $('#longitude').html('<input type="text" class="form-control" name="longitude" value="' + lng+ '">');
        $('#latitude').html('<input type="text" class="form-control" name="latitude" value="' + lat+ '">');
    });

    });
});

function initMap(lat,lng) {

const myLatlng = { lat: lat, lng: lng };

const map = new google.maps.Map(document.getElementById("map"), {
  zoom: 8,
  center: myLatlng,
});
// Create the initial InfoWindow.
let infoWindow = new google.maps.InfoWindow({
  content: "Click the map to get Lat/Lng!",
  position: myLatlng,
});
infoWindow.open(map);
// Configure the click listener.
map.addListener("click", (mapsMouseEvent) => {
  // Close the current InfoWindow.
  infoWindow.close();
  // Create a new InfoWindow.
  infoWindow = new google.maps.InfoWindow({
    position: mapsMouseEvent.latLng,
  });
  infoWindow.setContent(
    JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2)
  );
  infoWindow.open(map);
  current_latLng = mapsMouseEvent.latLng.toJSON();
  lat = current_latLng.lat;
  lng = current_latLng.lng;

  $('#longitude').html('<input type="text" class="form-control" name="longitude" value="' + lng+ '">');
  $('#latitude').html('<input type="text" class="form-control" name="latitude" value="' + lat+ '">');
});

}
initMap(lat,lng);

function set_location(result){

			location_search = result.formatted_address;

			for(var i = 0; i < result.address_components.length; i += 1) {
				var addressObj = result.address_components[i];
				for(var j = 0; j < addressObj.types.length; j += 1) {
					console.log(addressObj)
					if (addressObj.types[j] === 'country') {
					country = addressObj.long_name;
					}else if(addressObj.types[j] === 'postal_code'){
					zip = addressObj.long_name;
					}else if(addressObj.types[j] === 'administrative_area_level_1'){
					state = addressObj.long_name;
					}else if(addressObj.types[j] === 'locality'){
					city = addressObj.long_name;
					}

				}
			}

			lat = result.geometry.location.lat();
			lng = result.geometry.location.lng();
			$('#location_search').val(location_search);
			$('#lat').val(lat);
			$('#lng').val(lng);
			$('#country').val(country);
			$('#state').val(state);
			$('#city').val(city);
			$('#zip').val(zip);
		}


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
            url: "{{route('ajax-country-franchise')}}",
            type: 'POST',
            data: { country_id: country_id, _token: _token },
            success: function (data) {
                
                $('#f_state_id').empty();
                $('#f_state_id').append('<option value ="">Select State</option>');
                $.each(data, function (inedx, subcatObj) {
                    $('#f_state_id').append('<option value ="' + subcatObj.id + '">' + subcatObj.name + '</option>');
                });
            }
        });

    });


    $('#f_state_id').on('change', function () {
        var state_id = $(this).val();
        var _token = $("#form_franchise input[name='_token']").val();

        $.ajax({
            url: "{{route('ajax-state-franchise')}}",
            type: 'POST',
            data: { state_id: state_id, _token: _token },
            success: function (data) {
                $('#f_city_id').empty();
                $('#f_city_id').append('<option value ="">Select City</option>');
                $.each(data, function (inedx, subcatObj) {

                    $('#f_city_id').append('<option value ="' + subcatObj.id + '">' + subcatObj.name + '</option>');
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

</script>

@endsection
