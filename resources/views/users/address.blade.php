@extends('layouts.front')
@php
   use Carbon\Carbon;
@endphp


@section('styles')
<link rel="stylesheet" href="{{ asset('assets/front-assets/css/plugin/toaster/vendor/toastr.css') }}" media="screen">
<link rel="stylesheet" href="{{ asset('assets/front-assets/css/bootstrap-datetimepicker.min.css') }}" media="screen">
@endsection

@section('content')

<div class="container">


    @if(!empty($User_address->count()))

        @php
        $i = 0;
        $add = 0;
        @endphp

        <h2 class=" my-tst text-center mt-4 sel-add">Select Address</h2>
<div class="row">
        @foreach($User_address as $add_type => $addresses)

        @php

            $current_class = 'collapse';
            if(!empty($curent_address_type)){
                if($curent_address_type == $add_type){
                    $current_class = 'collapse show';
                }
            }else{
                if($i==0){
                    $current_class = 'collapse show';
                }
            }
        @endphp
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="sel-add">
                    <div class="btn-home d-flex justify-content-between">
                        <a class="btn-sub-home d-block" data-toggle="collapse" href="#collapseExample-{{$add_type}}" role="button" aria-expanded="false" aria-controls="collapseExample">
                            {{$add_type}}
                            <!-- <img class="down-img" src="{{ asset('assets/front-assets/images/down3.png') }}"> -->
                            <i class="fas fa-chevron-down down-img"></i>
                        </a>

                    </div>
            </div>

            <div class=" {{$current_class}}" id="collapseExample-{{$add_type}}">
                @foreach($addresses as $a => $address)
                    @php
                        $ischecked = '';
                        if(!empty($curent_address_id)){
                            if($curent_address_id == $address->id){
                                $ischecked = 'checked';
                            }
                        }else{
                            if($add==0){
                                $ischecked = 'checked';
                            }
                        }
                    @endphp
                    <div class="sel-add">
                        <div class="">
                            <div class="form-check rd-text">
                            <label class="form-check-label fr-ch-lb">
                                <input type="radio" class="form-check-input sel-text select-address" name="order_address" value="{{$address->id}}" {{$ischecked}} >{{$address->name}}
                            </label>
                            </div>
                            <p class="sel-text mb-0 pb-0">{{$address->flat_building_no}}, {{$address->address}}</p>
                        </div>
                    </div>
                    @php
                    $add++;
                    @endphp
                @endforeach
            </div>
        </div>
            @php
            $i++;
            @endphp
        @endforeach
</div>
    @endif
        <div class="sel-add 54">
                <div class="btn-new-add">
                    <a class="btn-sub-new btn-sub-home d-block" data-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample">

                        Add New Address
                        <img class="down-img " src="{{ asset('assets/front-assets/images/down3.png') }}">
                    </a>
                </div>
        </div>
    </div>
    <div class="container">
    <div class="row mt-md-3 mb-md-2 mt-2 mb-2 sel-add 34">
        <div class="col-md-8 text-center">
            @include('layouts.flash-message')
        </div>
    </div>
   @php
      // print_R($errors->all());die;
   @endphp
    <div class="collapse show" id="collapseExample2">

        <form id="frm-user-address" class="address-collapse" data-action="{{ route('user.save_user_address') }}" method="POST">

            @csrf
            <div class="sel-add row">
                <div class="col-md-12">
                    @include('includes.front.ajax-message')
                </div>
            </div>
            <div class="sel-add row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" placeholder="Your Location" name="address" id="address_search" class="form-control" value="{{old('address')}}">
                            <div class="input-group-append">
                                <button class="btn" type="button" id="btn-current-address"><i class="fas fa-map-marker-alt"></i></button>
                            </div>
                            <input type="hidden" name="lat" id="lat" value="{{old('lat')}}">
                            <input type="hidden" name="lng" id="lng" value="{{old('lng')}}">
                            <input type="hidden" name="country" id="country" value="{{old('country')}}">
                            <input type="hidden" name="city" id="city" value="{{old('city')}}">
                            <input type="hidden" name="state" id="state" value="{{old('state')}}">
                            <input type="hidden" name="zip" id="zip" value="{{old('zip')}}">
                            @error('address')
                                <label id="address-error" class="error" for="address">{{ $message }}</label>
                            @enderror
                            @error('lat')
                            <label id="lat-error" class="error" for="lat">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="text" id="email-85eb" name="flat_building_no" class="form-control" placeholder="Flat / Building / Street" value="{{old('flat_building_no')}}">
                        @error('flat_building_no')
                            <label id="flat_building_no-error" class="error" for="flat_building_no">{{ $message }}</label>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="text" placeholder="Your Name" id="address-d53d" name="name" class="form-control" value="{{old('name')}}">
                        @error('name')
                            <label id="name-error" class="error" for="name">{{ $message }}</label>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="text" placeholder="Mobile Number" id="phone" name="phone" class="form-control" value="{{old('phone')}}">
                        @error('phone')
                            <label id="phone-error" class="error" for="phone">{{ $message }}</label>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-6 mb-2 text-center">
                            <div class="">
                                <a class="btn-sub-other d-block {{old('type')=='Home'?'btn-others':'btn-other'}} add-type" href="javascript:void(0);" data-add-type="Home">Home</a>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-6 mb-2 text-center">
                            <div class="">
                                <a class="btn-sub-other d-block {{old('type')=='Office'?'btn-others':'btn-other'}} add-type" href="javascript:void(0);" data-add-type="Office">Office</a>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-6 text-center">
                            <div class="">
                                <a class="btn-sub-others d-block {{old('type')=='Others'?'btn-others':'btn-other'}} add-type" href="javascript:void(0);" data-add-type="Others">Other</a>
                            </div>
                        </div>
                        <input type="hidden" name="type" id="address-type" value="{{old('type')}}">
                        <div class="col-md-12">
                            <span class="address-type-message"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mt-2" id="address-map" style="width:100%;height:350px;"></div>
                </div>

            </div>
            <div class="row sel-add mb-md-4 mb-sm- 3 mb-2 d-none">
                <div class="col-md-6">
                    <div class="address-type-message"></div>
                    @error('type')
                        <label id="type-error" class="error" for="type">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="row sel-add mb-4 mt-4">
                <div class="col-md-4  col-sm-6 col-12  text-center">
                    <div class="">
                        <button class="btn-sub-save btn-save btn-address-submit" type="button">Save Address</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    </div>


    <!-- <div class="row mt-5 mb-5 sel-add">
        <div class="col-md-8 text-center">
            <div class="btn-new-add">
                <a class="btn-sub-new d-block" data-toggle="collapse" href="#" role="button" aria-expanded="false" aria-controls="collapseExample">
                     Continue with this address
                </a>
            </div>
        </div>
    </div> -->
<div class="container address-calender">
    <h3 class="text-center mt-0 ad-sub-texts"> When would you like Velox Solution to serve you?</h3>
    {{-- <div class="row mt-md-4 mt-sm-3 mt-2 ">
        <div class=col-md-6>
            <div class="form-group">
                <label for="id_end_time "class="fs-lb-tm">Date:</label>
                <div class="input-group date" id="custom-slot-date">
                    <input type="text" class="form-control"  placeholder="Select Date" id="id_slot-date" readonly>
                    <div class="input-group-addon input-group-append">
                        <div class="input-group-text">
                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class=col-md-6>
            <div class="form-group">
                <label for="id_end_time " class="fs-lb-tm">Time:</label>
                <div class="input-group date" id="custom-slot-time">
                    <input type="text" name="end_time"  class="form-control" placeholder="Select Time" id="id_slot-time" readonly>
                    <div class="input-group-addon input-group-append">
                        <div class="input-group-text">
                            <i class="glyphicon glyphicon-time fa fa-clock-o"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-md-4 mt-sm-3 mt-2">
        <div class="col-md-12 text-center">
            <p class="or-text">OR</p>
        </div>
    </div> --}}

    <div class="row mt-md-4 mt-sm-3 mt-2">
        <div class="col-md-12">
            <p class="sel-dt">Select Date of Service</p>

            <div class="page-content page-container" id="page-content">
                <div class="padding">
                    <div class="row  d-flex justify-content-center">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <ul class="nav nav-pills timeslot-ul" id="myTab" role="tablist ">
                                    @foreach($day_array as $d => $day)
                                        @php
                                            $date_active = '';
                                            if(!empty($slot_date)){
                                                if($slot_date == $day['date']){
                                                    $date_active = 'active';
                                                }
                                            }else{
                                                if($d==0){
                                                    $date_active = 'active';
                                                }
                                            }
                                        @endphp
                                        <li class="nav-item btn-tom ">
                                            <a class="nav-link btn-dd {{$date_active}} btn-t text-center date-select" data-toggle="tab" href="#time-tab-{{$day['date']}}" role="tab" aria-controls="home" aria-selected="true" data-date="{{$day['date']}}">{{$day['day_name']}} <div class="text-center">{{$day['day']}}</div>
                                            </a>
                                        </li>

                                    @endforeach
                                </ul>
                            </div>
                            <div class="tab-content mb-4">
                                @foreach($day_array as $d => $day)

                                    @php
                                        $time_active = '';
                                        if(!empty($slot_time)){
                                            if($slot_date == $day['date']){
                                                $time_active = 'active';
                                            }
                                        }else{
                                            if($d==0){
                                                $time_active = 'active';
                                            }
                                        }
                                    @endphp
                                    <div class="tab-pane fade show {{$time_active}}" id="time-tab-{{$day['date']}}" role="tabpanel" aria-labelledby="home-tab">
                                        <p class="sel-dt1 mt-md-4 mt-sm-3 mt-2">Select Time </p>
                                        <div class="row mt-3 px-2">
                                            @foreach($day['slots'] as $s => $slot)
                                                @php
                                                    $slot_active = 'time-box';
                                                    $slot_active_text = 'time-text';
                                                    if(!empty($slot_time)){
                                                        if($slot_date == $day['date'] && $slot_time == $slot){
                                                            $slot_active = 'time-box1';
                                                            $slot_active_text = 'time-text1 active';
                                                        }
                                                    }else{
                                                        if($d == 0 && $s == 0){
                                                            $slot_active = 'time-box1';
                                                            $slot_active_text = 'time-text1 active';
                                                        }
                                                    }
                                                @endphp
                                                <div class="">
                                                    <div class="{{$slot_active}}">
                                                        <a href="javascript:void(0);" data-slot="{{$slot}}" data-date="{{$day['human_date']}}" class="{{$slot_active_text}} d-block slots slot-{{$day['date']}}-{{$slot}} " > {{$slot}}</a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="row sel-add tm-pic mb-3">
        <div class="col-md-2 col-sm-3 col-6 text-center">
            <div class="btn-next">
                <a class="btn-sub-next d-block go-to-next" href="javascript:void(0);">Next</a>
            </div>
        </div>
    </div>
</div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('assets/front-assets/js/plugin/toaster/toastr.min.js') }}"></script>
{{-- <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key={{env('GOOGLE_API_KEY')}}"></script> --}}


<script src="{{ asset('assets/front-assets/js/moment-with-locales.min.js') }}"></script>
<script src="{{ asset('assets/front-assets/js/bootstrap-datetimepicker.min.js') }}"></script>


<script>
    var default_lat, default_long = null;
    let map;
    let marker = null;
    var address_lat = {{!empty(old('latitude')) ? old('latitude') : 21.16486108042384}};
    var address_long = {{!empty(old('longitude')) ? old('longitude') : 72.83420567685027}};

    function initMap(default_lat, default_long, address_lat,address_long) {
        const myLatLng = { lat: address_lat, lng: address_long };
        map = new google.maps.Map(document.getElementById("address-map"), {
            zoom: 12,
            center: myLatLng,
        });

        var geocoder = new google.maps.Geocoder();
        google.maps.event.addListener(map, 'click', function(event) {
            geocoder.geocode({
                'latLng': event.latLng
            }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    result = results[0]
                    set_address(result);
                }
            });
        });

        if(default_lat && default_long){
            const position = { lat: default_lat, lng: default_long };
            addMarker(position);
        }

    }

    function addMarker(myLatLng){
        if(marker){
            marker.setMap(null);
        }
        marker = new google.maps.Marker({
            position: myLatLng,
            map
        });
    }
    initMap(default_lat, default_long, address_lat,address_long);

    $('#btn-current-address').click(function(){
        var host = location.hostname;
        if (navigator.geolocation) {

            navigator.geolocation.getCurrentPosition(
            function(position) {
                location.latitude = position.coords.latitude;
                location.longitude = position.coords.longitude;

                var geocoder = new google.maps.Geocoder();
                var latLng = new google.maps.LatLng(location.latitude, location.longitude);
                if (geocoder) {
                    geocoder.geocode({ 'latLng': latLng}, function (results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            result = results[0];
                            set_address(result, true);
                        }
                    });
                }
            },
            function(error){
                console.log(error.message);
            }, {
                maximumAge: 0,
                enableHighAccuracy: true,
                timeout : 5000
            });

        }
    });

    $('.btn-address-submit').click(function(){
        $('#frm-user-address').submit();
    });

    $('#frm-user-address').submit(function(){
        //alert()
        $('#frm-user-address .error').remove();
        url = $(this).data('action');
        $.ajax({
            url : url,
            type : 'POST',
            datatype:'json',
            data : $('#frm-user-address').serialize(),
            success : function(data) {

                if(data.success){
                    $('#frm-user-address').find('.alert-success').show();
                    $('#frm-user-address').find('.alert-success .message-span').html(data.message);
                    $('#frm-user-address')[0].reset();
                    setTimeout(function(){
                        $('#frm-user-address').find('.alert-success').hide(1000);
                        $('#frm-user-address').find('.alert-success .message-span').html('');
                        window.location.reload();
                    }, 3000);
                    // Swal.fire("Success", data.message, "success");
                }else{

                    if(data.message){
                        $('#frm-user-address').find('.alert-danger').show();
                        $('#frm-user-address').find('.alert-danger .message-span').html(data.message);
                        $('#frm-user-address')[0].reset();
                        setTimeout(function(){
                            $('#frm-user-address').find('.alert-danger').hide(1000);
                            $('#frm-user-address').find('.alert-danger .message-span').html('');
                        }, 3000);
                    }
                    if(data.errors){
                        $.each(data.errors, function(key,value){
                            if(key == 'type'){
                                $('.address-type-message').append('<label id="'+key+'-error" class="error" for="'+key+'">'+value[0]+'</label>');
                            }else if(key == 'address'){
                                $('#address_search').after.append('<label id="'+key+'-error" class="error" for="'+key+'">'+value[0]+'</label>');
                            }else{
                                $("#frm-user-address [name='"+key+"']").parent().after('<label id="'+key+'-error" class="error" for="'+key+'">'+value[0]+'</label>');
                            }
                        });
                    }

                }
            }
        });
        return false;
    });

   function set_address(result, isRedirect){

        location_search = result.formatted_address;

        for(var i = 0; i < result.address_components.length; i += 1) {
            var addressObj = result.address_components[i];
            for(var j = 0; j < addressObj.types.length; j += 1) {

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

        initMap(lat, lng, lat,lng, result.geometry.location);

        $('#address_search').val(location_search);
        $('#lat').val(lat);
        $('#lng').val(lng);
        $('#country').val(country);
        $('#state').val(state);
        $('#city').val(city);
        $('#zip').val(zip);
        if(isRedirect){
            //$('#frm-user-address').submit();
        }
   }
   $(document).ready(function(){

    $('#custom-slot-date').datetimepicker({
            "allowInputToggle": true,
            "showClose": true,
            "showClear": true,
            "showTodayButton": true,
            "format": "DD/MM/YYYY",
            "minDate": new Date(),
            "ignoreReadonly": true
        });
        $('#custom-slot-time').datetimepicker({
            "allowInputToggle": true,
            "showClose": true,
            "showClear": true,
            "showTodayButton": true,
            "format": "hh:mm A",
            "ignoreReadonly": true
            //"minDate": new Date()
        });

        // $('#id_slot-date').val("{{$slot_date ? Carbon::parse($slot_date)->format('d/m/Y') : ''}}");
        // $('#id_slot-time').val("{{$slot_time ? Carbon::parse($slot_time)->format('h:i A') : ''}}");

      var searchInput = 'address_search';
      var lat, lng = conuntry = state = city = zip = location_search = '';

      var autocomplete;
      autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {
            types: ['geocode']
      });
      google.maps.event.addListener(autocomplete, 'place_changed', function () {
            var result = autocomplete.getPlace();
            set_address(result);
      });


      $('.go-to-next').click(function(){
         if(!$('.select-address:checked').val()){
            toastr.error('Please select address', 'Error', { "progressBar": true });
            return false;
         }

         if(!$('.slots.active').length && (!$('#id_slot-date').val() || !$('#id_slot-time').val())){
            toastr.error('Please select slot', 'Error', { "progressBar": true });
            return false;
         }

         $('.go-to-next').prop('disabled', true);
         if($('#id_slot-date').val() && $('#id_slot-time').val()){
            date = $('#id_slot-date').val();
            slot = $('#id_slot-time').val();
         }else{
            date = $('.slots.active').data('date');
            slot = $('.slots.active').data('slot');
         }
         data = {
            address_id : $('.select-address:checked').val(),
            slot_date : date,
            slot_time : slot
         }
         $.ajax({
              header:{
                  'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
              },
              url: "{{ route('user.save_address_time_slot') }}",
              type : "post",
              dataType:'json',
              data : {
                  "_token": "{{ csrf_token() }}",
                  "data": data
              },
              success : function(data) {
                  $('.go-to-next').prop('disabled', false);
                  if(data.success){
                      window.location.href = "{{ route('user.payment_method') }}";
                  }else{
                     //error message
                  }
              }
          });
          return false;
      });

      $('#btn-add-address').click(function(){
         $('.add-address-div').removeClass('hidden');
      });

      $('.add-type').click(function(){
         $('.add-type').addClass('btn-other').removeClass('btn-others');
         $(this).removeClass('btn-other').addClass('btn-others');
         type = $(this).data('add-type');
         $('#address-type').val(type);
      });

      $('.date-select').click(function(){
         $('.slots').removeClass('time-text1 active').addClass('time-text');
         $('.slots').parent().removeClass('time-box1').addClass('time-box');
      });
      $('.slots').click(function(){
         $('.slots').removeClass('time-text1 active').addClass('time-text');
         $('.slots').parent().removeClass('time-box1').addClass('time-box');
         $(this).addClass('time-text1 active').removeClass('time-text');
         $(this).parent().removeClass('time-box').addClass('time-box1');
      });

   });

</script>
@endsection
