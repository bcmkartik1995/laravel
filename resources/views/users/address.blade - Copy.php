@extends('layouts.front')
<!-- <script src="{{ asset('front/js/jquery.js') }}"></script> -->

<link rel="stylesheet" href="{{ asset('front/css/address.css') }}" media="screen">


<link rel="stylesheet" href="{{ asset('css/plugin/toaster/vendor/toastr.css') }}" media="screen">
<link rel="stylesheet" href="{{ asset('css/plugin/toaster/toastr.css') }}" media="screen">
<link rel="stylesheet" href="{{ asset('css/plugin/datetimepicker/bootstrap-datetimepicker.min.css') }}" media="screen">


@section('content')

<section class="u-align-center u-clearfix u-white u-section-1" id="sec-fcea">

         <div class="u-clearfix u-sheet u-sheet-1">
            @include('layouts.flash-message')
            @if(!empty($User_address))
            <h2 class="u-text u-text-default u-text-1"> Select Address</h2>
            <div class="u-accordion u-spacing-10 u-accordion-1">
               @php
               $i = 0;
               @endphp
               @foreach($User_address as $address)
               <div class="u-accordion-item">
                  <a class="{{$i==0?'active':''}} u-accordion-link u-active-custom-color-2 u-button-style u-custom-color-2 u-hover-custom-color-2 u-radius-14 u-accordion-link-1" id="link-accordion-0781" aria-controls="accordion-0781" aria-selected="true">
                     <span class="u-accordion-link-text"> {{$address->type}}</span>
                     <span class="u-accordion-link-icon u-icon u-icon-rectangle u-text-white u-icon-1">
                        <svg class="u-svg-link" preserveAspectRatio="xMidYMin slice" viewBox="0 0 42 42" style="">
                           <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-f4c1"></use>
                        </svg>
                        <svg class="u-svg-content" viewBox="0 0 42 42" x="0px" y="0px" id="svg-f4c1" style="enable-background:new 0 0 42 42;">
                           <polygon points="42,20 22,20 22,0 20,0 20,20 0,20 0,22 20,22 20,42 22,42 22,22 42,22 "></polygon>
                        </svg>
                     </span>
                  </a>
                  <div class="{{$i==0?'u-accordion-active':''}} u-accordion-pane u-container-style u-shape-rectangle u-accordion-pane-1" id="accordion-0781" aria-labelledby="link-accordion-0781">
                     <div class="u-container-layout u-container-layout-1">
                        <p class="u-text u-text-2"><input type="radio"  class="select-address" name="order_address" value="{{$address->id}}"> {{$address->name}}<br>{{$address->flat_building_no}}, {{$address->address}}<br>
                        </p>
                     </div>
                  </div>
               </div>
                @php
               $i++;
               @endphp
               @endforeach

            </div>
            @endif

         </div>
      </section>
      <!-- <section class="u-clearfix u-grey-light-2 u-typography-custom-page-typography-12--Map u-section-2" id="sec-db47">
         <div class="u-expanded u-grey-light-2 u-map">
            <div class="embed-responsive">
               <iframe class="embed-responsive-item" src="//maps.google.com/maps?output=embed&amp;q=Manhattan&amp;t=m" data-map="JTdCJTIycG9zaXRpb25UeXBlJTIyJTNBJTIybWFwLWFkZHJlc3MlMjIlMkMlMjJhZGRyZXNzJTIyJTNBJTIyTWFuaGF0dGFuJTIyJTJDJTIyem9vbSUyMiUzQW51bGwlMkMlMjJ0eXBlSWQlMjIlM0ElMjJyb2FkJTIyJTJDJTIybGFuZyUyMiUzQW51bGwlMkMlMjJhcGlLZXklMjIlM0FudWxsJTJDJTIybWFya2VycyUyMiUzQSU1QiU1RCU3RA=="></iframe>
            </div>
         </div>
      </section> -->
      <section class="u-clearfix u-section-3 add-address-div {{$errors->all()  ? '':'hidden'}}" id="sec-7b77">

         <div class="u-clearfix u-sheet u-valign-middle-xs u-sheet-1">
            <div class="u-form u-form-1">

               <form action="{{ route('user.save_user_address') }}" method="POST" class="u-clearfix u-form-spacing-10 u-form-vertical u-inner-form" source="custom" name="form-1" style="padding: 10px;">
                  @csrf
                  <div class="u-form-group u-form-name">
                     <label for="name-85eb" class="u-form-control-hidden u-label"></label>
                     <input type="text" placeholder="Your Location" name="address" id="address_search" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" value="{{old('address')}}">
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
                  <div class="u-form-email u-form-group">
                     <label for="email-85eb" class="u-form-control-hidden u-label"></label>
                     <input type="text" id="email-85eb" name="flat_building_no" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" placeholder="Flat / Building / Street" value="{{old('flat_building_no')}}">
                    @error('flat_building_no')
                         <label id="flat_building_no-error" class="error" for="flat_building_no">{{ $message }}</label>
                     @enderror
                  </div>
                  <div class="u-form-address u-form-group u-form-group-3">
                     <label for="address-d53d" class="u-form-control-hidden u-label"></label>
                     <input type="text" placeholder="Your Name" id="address-d53d" name="name" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" value="{{old('name')}}">
                     @error('name')
                         <label id="name-error" class="error" for="name">{{ $message }}</label>
                     @enderror
                  </div>
                  <div class="u-align-center u-form-group u-form-submit">
                     <a href="javascript:void(0);" data-add-type="Office" class="add-type u-border-none u-btn u-btn-submit u-button-style {{old('type')=='Office'?'':'u-custom-color-2'}} u-btn-1">Office<br>

                     </a>
                     <a href="javascript:void(0);" data-add-type="Home" class="add-type u-border-none u-btn u-button-style {{old('type')=='Home'?'':'u-custom-color-2'}} u-btn-2">Home</a>
                     <a href="javascript:void(0);" data-add-type="Others" class="add-type u-border-none u-btn u-button-style {{old('type')=='Others'?'':'u-custom-color-2'}} u-btn-3">Others<br>
                     </a>
                     <input type="hidden" name="type" id="address-type" value="{{old('type')}}">

                  </div>
                  @error('type')
                         <label id="type-error" class="error" for="type">{{ $message }}</label>
                     @enderror

                  <button type="submit" class="u-border-none u-btn u-button-style u-custom-color-1 u-custom-font u-font-montserrat u-hover-custom-color-1 u-btn-4">Save Address</button>
               </form>
            </div>

         </div>
      </section>
      <section class="u-align-center u-clearfix u-white u-section-1" id="sec-fcea">
         <div class="u-clearfix u-sheet u-sheet-1">

            <a href="javascript:void(0);" class="u-border-1 u-border-active-palette-2-base u-border-custom-color-2 u-border-hover-custom-color-2 u-btn u-button-style u-custom-font u-font-montserrat u-none u-text-custom-color-1 u-btn-1" id="btn-add-address"> + Add a new address</a>
            <a href="javascript:void(0);" class="u-align-center u-border-none u-btn u-button-style u-custom-color-1 u-custom-font u-font-montserrat u-hover-custom-color-1 u-btn-2" id="continue-with-address"> Continue with this address</a>
         </div>
      </section>
      <section class="u-align-left u-clearfix u-section-4" id="sec-71f5">
         <div class="u-clearfix u-sheet u-valign-middle-lg u-valign-middle-md u-valign-middle-xl u-sheet-1">
            <p class="u-align-center u-custom-font u-font-montserrat u-text u-text-1"> When would you like Velox Solution to serve you?</p>
            <p class="u-align-center u-custom-font u-font-montserrat u-text u-text-default u-text-grey-40 u-text-2">Select Date of Service</p>
            <div class="u-expanded-width u-tab-links-align-justify u-tabs u-tabs-1">

               <ul class="u-spacing-30 u-tab-list u-unstyled" role="tablist">
                  @foreach($day_array as $d => $day)
                  <li class="u-tab-item" role="presentation">
                     <a class="{{$d==0?'active':''}} u-active-custom-color-2 u-button-style u-custom-font u-font-montserrat u-tab-link u-tab-link-1 date-select" id="link-tab-081f" href="#date-{{$day['date']}}" role="tab" aria-controls="tab-081f" aria-selected="true" data-date="{{$day['date']}}">{{$day['day_name']}}<br>
                     <span style="font-size: 2.25rem;">{{$day['day']}}</span>
                     </a>
                  </li>
                  @endforeach

                 <!--  <li class="u-tab-item" role="presentation">
                     <a class="u-active-custom-color-2 u-button-style u-custom-font u-font-montserrat u-tab-link u-tab-link-2" id="link-tab-4d57" href="#tab-4d57" role="tab" aria-controls="tab-4d57" aria-selected="false"> Tomorrow<br>
                     <span style="font-size: 2.25rem;">28</span>
                     <span style="font-size: 2.25rem;"></span>
                     </a>
                  </li>
                  <li class="u-tab-item" role="presentation">
                     <a class="u-active-custom-color-2 u-button-style u-custom-font u-font-montserrat u-tab-link u-tab-link-3" id="link-tab-3a42" href="#tab-3a42" role="tab" aria-controls="tab-3a42" aria-selected="false">Fri<br>
                     <span style="font-size: 2.25rem;">30</span>
                     </a>
                  </li> -->
               </ul>
               <div class="u-tab-content">
                  @foreach($day_array as $d => $day)
                  <div class="u-align-center-sm u-align-center-xs u-container-style {{$d==0?'u-tab-active':''}} u-tab-pane u-tab-pane-1" id="date-{{$day['date']}}" role="tabpanel" aria-labelledby="link-tab-081f">
                     <div class="u-container-layout u-container-layout-1">
                        <h4 class="u-custom-font u-font-montserrat u-text u-text-default u-text-grey-40 u-text-3">Select time</h4>
                        @foreach($day['slots'] as $s => $slot)
                           <a href="javascript:void(0);" data-slot="{{$slot}}" data-date="{{$day['human_date']}}" class="active u-border-2 u-btn u-btn-round u-button-style u-custom-font u-font-montserrat u-radius-6 u-btn-1 {{$d == 0 && $s == 0 ? 'u-border-custom-color-1 u-custom-color-1 u-text-body-alt-color' : 'u-border-grey-50 u-none u-text-body-color'}} slot-{{$day['date']}}-{{$slot}} slots">{{$slot}}</a>

                        @endforeach
                     </div>
                  </div>
                  @endforeach
                  <!-- <div class="u-container-style u-tab-pane" id="tab-4d57" role="tabpanel" aria-labelledby="link-tab-4d57">
                     <div class="u-container-layout u-valign-top u-container-layout-2">
                        <h4 class="u-custom-font u-font-montserrat u-text u-text-default u-text-grey-40 u-text-4">Select time</h4>
                        <a href="https://nicepage.com/k/business-card-html-templates" class="u-border-2 u-border-grey-50 u-btn u-btn-round u-button-style u-custom-font u-font-montserrat u-none u-radius-6 u-text-body-color u-btn-6">5 pm</a>
                        <a href="https://nicepage.com/k/business-card-html-templates" class="u-border-2 u-border-grey-50 u-btn u-btn-round u-button-style u-custom-font u-font-montserrat u-none u-radius-6 u-text-body-color u-btn-7">5:30pm</a>
                        <a href="https://nicepage.com/k/business-card-html-templates" class="u-border-2 u-border-grey-50 u-btn u-btn-round u-button-style u-custom-font u-font-montserrat u-none u-radius-6 u-text-body-color u-btn-8">6 pm</a>
                        <a href="https://nicepage.com/k/business-card-html-templates" class="u-border-2 u-border-grey-50 u-btn u-btn-round u-button-style u-custom-font u-font-montserrat u-none u-radius-6 u-text-body-color u-btn-9">6:30 pm</a>
                     </div>
                  </div>
                  <div class="u-align-center u-container-style u-tab-pane" id="tab-3a42" role="tabpanel" aria-labelledby="link-tab-3a42">
                     <div class="u-container-layout u-valign-top u-container-layout-3">
                        <h4 class="u-custom-font u-font-montserrat u-text u-text-default u-text-grey-40 u-text-5">Select time</h4>
                        <a href="https://nicepage.com/k/business-card-html-templates" class="u-border-2 u-border-grey-50 u-btn u-btn-round u-button-style u-custom-font u-font-montserrat u-none u-radius-6 u-text-body-color u-btn-10">6 pm</a>
                        <a href="https://nicepage.com/k/business-card-html-templates" class="u-align-center u-border-2 u-border-grey-50 u-btn u-btn-round u-button-style u-custom-font u-font-montserrat u-none u-radius-6 u-text-body-color u-btn-11">6:30pm</a>
                        <a href="https://nicepage.com/k/business-card-html-templates" class="u-align-center u-border-2 u-border-grey-50 u-btn u-btn-round u-button-style u-custom-font u-font-montserrat u-none u-radius-6 u-text-body-color u-btn-12">7 pm</a>
                        <a href="https://nicepage.com/k/business-card-html-templates" class="u-border-2 u-border-grey-50 u-btn u-btn-round u-button-style u-custom-font u-font-montserrat u-none u-radius-6 u-text-body-color u-btn-13">7:30 pm</a>
                     </div>
                  </div> -->
               </div>
            </div>
            <p class="text-center">OR</p>
            <div class="form-group row">
               <div class="col-md-6">
                  <input type="text" class="form-control" id="custom-slot-date" readonly="readonly">
               </div>
               <div class="col-md-6">
                  <input type="text" class="form-control" id="custom-slot-time" readonly="readonly">
               </div>
            </div>
            <button type="button" class="u-align-center u-border-none u-btn u-button-style u-custom-color-2 u-hover-custom-color-2 u-btn-14 go-to-next">Next</button>
         </div>
      </section>
      @endsection

@section('scripts')
<script src="{{ asset('js/plugin/toaster/toastr.min.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key={{env('GOOGLE_API_KEY')}}"></script>
<script src="{{ asset('js/plugin/datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
<script>
   function set_location(result){
     // console.log(result)
      location_search = result.formatted_address;

      for(var i = 0; i < result.address_components.length; i += 1) {
         var addressObj = result.address_components[i];
         for(var j = 0; j < addressObj.types.length; j += 1) {
            //console.log(addressObj)
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
      $('#address_search').val(location_search);
      $('#lat').val(lat);
      $('#lng').val(lng);
      $('#country').val(country);
      $('#state').val(state);
      $('#city').val(city);
      $('#zip').val(zip);
   }
   $(document).ready(function(){

      $('#custom-slot-date').datetimepicker({
         defaultDate: new Date(),
         minView: 2,
         format: 'dd/mm/yyyy',
         autoclose: true,
         startDate: new Date()
      });
      $('#custom-slot-time').datetimepicker({
         pickDate: false,
         minuteStep: 30,
         pickerPosition: 'bottom-right',
         format: 'HH:ii P',
         autoclose: true,
         showMeridian: true,
         startView: 1,
         maxView: 1,
      });

      var searchInput = 'address_search';
      var lat, lng = conuntry = state = city = zip = location_search = '';

      var autocomplete;
      autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {
            types: ['geocode']
      });
      google.maps.event.addListener(autocomplete, 'place_changed', function () {
            var result = autocomplete.getPlace();
            set_location(result);
      });


      $('.go-to-next').click(function(){
         if(!$('.select-address:checked').val()){
            toastr.error('Please select address', 'Error', { "progressBar": true });
            return false;
         }

         if(!$('.slots.active').length && (!$('#custom-slot-date').val() || !$('#custom-slot-time').val())){
            toastr.error('Please select slot', 'Error', { "progressBar": true });
            return false;
         }

         $('.go-to-next').prop('disabled', true);
         if($('#custom-slot-date').val() && $('#custom-slot-time').val()){
            date = $('#custom-slot-date').val();
            slot = $('#custom-slot-time').val();
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
                      window.location.href = "{{ url('/payment_method') }}";
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
         $('.add-type').addClass('u-custom-color-2');
         $(this).removeClass('u-custom-color-2');
         type = $(this).data('add-type');
         $('#address-type').val(type);
      });

      $('.date-select').click(function(){
         $('.slots').removeClass('active u-border-custom-color-1 u-custom-color-1 u-text-body-alt-color').addClass('u-border-grey-50 u-none u-text-body-color');
      });
      $('.slots').click(function(){
         $('.slots').removeClass('active u-border-custom-color-1 u-custom-color-1 u-text-body-alt-color').addClass('u-border-grey-50 u-none u-text-body-color');
         $(this).addClass('active u-border-custom-color-1 u-custom-color-1 u-text-body-alt-color').removeClass('u-border-grey-50 u-none u-text-body-color');
      });

   })

</script>
@endsection
