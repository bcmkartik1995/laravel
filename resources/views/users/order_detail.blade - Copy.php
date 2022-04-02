@php
   use Razorpay\Api\Api;
@endphp
@extends('layouts.front')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="{{ asset('front/js/jquery.js') }}"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="{{ asset('front/css/booking_accepted.css') }}" media="screen">
<link rel="stylesheet" href="{{ asset('css/plugin/toaster/vendor/toastr.css') }}" media="screen">
<link rel="stylesheet" href="{{ asset('css/plugin/toaster/toastr.css') }}" media="screen">
<script src="{{ asset('js/plugin/toaster/toastr.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/plugin/sweetalert/sweetalert2.min.css')}}" media="screen">
<style>
   {
   margin: 0;
   padding: 0;
   }
   .rate {
   float: left;
   height: 46px;
   padding: 0 10px;
   }
   .rate:not(:checked) > input {
   position:absolute;
   top:-9999px;
   }
   .rate:not(:checked) > label {
   float:right;
   width:1em;
   overflow:hidden;
   white-space:nowrap;
   cursor:pointer;
   font-size:30px;
   color:#ccc;
   }
   .rate:not(:checked) > label:before {
   content: '★ ';
   }
   .rate > input:checked ~ label {
   color: #ffc700;
   }
   .rate:not(:checked) > label:hover,
   .rate:not(:checked) > label:hover ~ label {
   color: #deb217;
   }
   .rate > input:checked + label:hover,
   .rate > input:checked + label:hover ~ label,
   .rate > input:checked ~ label:hover,
   .rate > input:checked ~ label:hover ~ label,
   .rate > label:hover ~ input:checked ~ label {
   color: #c59b08;
   }
</style>
@section('content')
<section class="u-clearfix u-section-1" id="sec-8222">
   <div class="u-clearfix u-sheet u-sheet-1">
      @include('layouts.flash-message')
      <!-- <span class="u-icon u-icon-circle u-text-custom-color-10 u-icon-1"><svg class="u-svg-link" preserveAspectRatio="xMidYMin slice" viewBox="0 0 551.122 551.122" style=""><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-dc3f"></use></svg><svg class="u-svg-content" viewBox="0 0 551.122 551.122" id="svg-dc3f"><path d="m275.561 551.122c-2.573 0-5.163-.572-7.535-1.749-108.955-53.048-199.139-110.3-199.139-273.816v-189.451c0-7.249 4.524-13.708 11.336-16.18l189.451-68.892c3.801-1.379 7.972-1.379 11.773 0l189.451 68.891c6.812 2.472 11.336 8.931 11.336 16.18v189.451c0 163.516-90.184 220.768-199.139 273.816-2.371 1.178-4.961 1.75-7.534 1.75zm-172.228-452.957v177.392c0 128.482 57.992 182.454 172.228 239.135 114.236-56.681 172.228-110.653 172.228-239.135v-177.392l-172.228-62.618s-172.228 62.618-172.228 62.618z"></path><path d="m263.384 344.447-81.068-81.068 24.354-24.354 56.714 56.714 108.382-108.383 24.354 24.354z"></path></svg>
         </span> -->
      <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-10 u-text-1" style="padding-top:40px;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<br>
      </p>
      {{-- <span class="u-icon u-icon-circle u-text-custom-color-10 u-icon-2">
         <svg class="u-svg-link" preserveAspectRatio="xMidYMin slice" viewBox="0 0 492 492" style="">
            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-e0ac"></use>
         </svg>
         <svg class="u-svg-content" viewBox="0 0 492 492" x="0px" y="0px" id="svg-e0ac" style="enable-background:new 0 0 492 492;">
            <g>
               <g>
                  <path d="M464.344,207.418l0.768,0.168H135.888l103.496-103.724c5.068-5.064,7.848-11.924,7.848-19.124    c0-7.2-2.78-14.012-7.848-19.088L223.28,49.538c-5.064-5.064-11.812-7.864-19.008-7.864c-7.2,0-13.952,2.78-19.016,7.844    L7.844,226.914C2.76,231.998-0.02,238.77,0,245.974c-0.02,7.244,2.76,14.02,7.844,19.096l177.412,177.412    c5.064,5.06,11.812,7.844,19.016,7.844c7.196,0,13.944-2.788,19.008-7.844l16.104-16.112c5.068-5.056,7.848-11.808,7.848-19.008    c0-7.196-2.78-13.592-7.848-18.652L134.72,284.406h329.992c14.828,0,27.288-12.78,27.288-27.6v-22.788    C492,219.198,479.172,207.418,464.344,207.418z"></path>
               </g>
            </g>
         </svg>
      </span> --}}
      <!--  -->
      <!--   -->
      <!--   -->

      @if (in_array($my_order->status, ['pending','processing','on delivery']))
         <a class="u-border-none u-btn u-button-style u-custom-font u-font-montserrat u-none u-btn-2">&nbsp; <span style="font-size: 1.125rem;"></span>&nbsp; {{ucwords($my_order->status)}}
         </a>
         <span class="u-icon u-icon-circle u-icon-3"><svg class="u-svg-link" preserveAspectRatio="xMidYMin slice" viewBox="0 0 512 512" style=""><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-c8e7"></use></svg><svg class="u-svg-content" viewBox="0 0 512 512" id="svg-c8e7"><path d="m61.496094 279.609375c-.988282-8.234375-1.496094-16.414063-1.496094-23.609375 0-107.402344 88.597656-196 196-196 50.097656 0 97 20.199219 131.5 51.699219l-17.300781 17.601562c-3.898438 3.898438-5.398438 9.597657-3.898438 15 1.800781 5.097657 6 9 11.398438 10.199219 3.019531.605469 102.214843 32.570312 95.898437 31.300781 8.035156 2.675781 19.917969-5.894531 17.703125-17.699219-.609375-3.023437-22.570312-113.214843-21.300781-106.902343-1.199219-5.398438-5.101562-9.898438-10.5-11.398438-5.097656-1.5-10.800781 0-14.699219 3.898438l-14.699219 14.398437c-45.300781-42.296875-107.503906-68.097656-174.101562-68.097656-140.699219 0-256 115.300781-256 256v.597656c0 8.457032.386719 14.992188.835938 19.992188.597656 6.625 5.480468 12.050781 12.003906 13.359375l30.816406 6.160156c10.03125 2.007813 19.050781-6.402344 17.839844-16.5zm0 0"></path><path d="m499.25 222.027344-30.90625-6.296875c-10.042969-2.046875-19.125 6.371093-17.890625 16.515625 1.070313 8.753906 1.546875 17.265625 1.546875 23.753906 0 107.398438-88.597656 196-196 196-50.097656 0-97-20.199219-131.5-52l17.300781-17.300781c3.898438-3.898438 5.398438-9.597657 3.898438-15-1.800781-5.101563-6-9-11.398438-10.199219-3.019531-.609375-102.214843-32.570312-95.898437-31.300781-5.101563-.898438-10.203125.601562-13.5 4.199219-3.601563 3.300781-5.101563 8.699218-4.203125 13.5.609375 3.019531 22.574219 112.210937 21.304687 105.898437 1.195313 5.402344 5.097656 9.902344 10.496094 11.398437 6.261719 1.570313 11.488281-.328124 14.699219-3.898437l14.402343-14.398437c45.296876 42.300781 107.5 69.101562 174.398438 69.101562 140.699219 0 256-115.300781 256-256v-.902344c0-6.648437-.242188-13.175781-.796875-19.664062-.570313-6.628906-5.433594-12.074219-11.953125-13.40625zm0 0"></path></svg></span>

      @elseif (in_array($my_order->status, ['completed']))
         <span  class="u-border-none u-btn u-button-style u-custom-color-1 u-hover-custom-color-1 u-btn-1">Completed</span>
      @elseif (in_array($my_order->status, ['cancelled']))
         <span  class="u-border-none u-btn u-button-style u-custom-color-2 u-hover-custom-color-1 u-btn-1">Cencelled</span>
      @endif

      @if(in_array($my_order->status, ['pending','processing','on delivery']))
         <a href="javascript:void(0);" class="u-border-none u-btn u-button-style u-custom-font u-font-montserrat u-none u-btn-3 cancel_order">&nbsp; &nbsp; &nbsp;Cancel</a>

         <span class="u-icon u-icon-circle u-text-custom-color-10 u-icon-4">
            <svg class="u-svg-link" preserveAspectRatio="xMidYMin slice" viewBox="0 0 329.26933 329" style="">
               <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-0135"></use>
            </svg>
            <svg class="u-svg-content" viewBox="0 0 329.26933 329" id="svg-0135">
               <path d="m194.800781 164.769531 128.210938-128.214843c8.34375-8.339844 8.34375-21.824219 0-30.164063-8.339844-8.339844-21.824219-8.339844-30.164063 0l-128.214844 128.214844-128.210937-128.214844c-8.34375-8.339844-21.824219-8.339844-30.164063 0-8.34375 8.339844-8.34375 21.824219 0 30.164063l128.210938 128.214843-128.210938 128.214844c-8.34375 8.339844-8.34375 21.824219 0 30.164063 4.15625 4.160156 9.621094 6.25 15.082032 6.25 5.460937 0 10.921875-2.089844 15.082031-6.25l128.210937-128.214844 128.214844 128.214844c4.160156 4.160156 9.621094 6.25 15.082032 6.25 5.460937 0 10.921874-2.089844 15.082031-6.25 8.34375-8.339844 8.34375-21.824219 0-30.164063zm0 0"></path>
            </svg>
         </span>
      @endif



      <!-- -->
      <?php
         // echo '<pre>';
         //   print_r($my_order->cart);
         ?>
         <div class="row">
            <div class="col-md-6">
      <div class="u-clearfix u-expanded-width-md u-expanded-width-sm u-expanded-width-xs u-gutter-10 u-layout-wrap u-layout-wrap-1">
         <div class="u-layout">
            <div class="u-layout-col min-high-unset">
               <div class="u-size-60">
                  <div class="u-layout-row">
                     <div class="u-align-left u-container-style u-layout-cell u-right-cell u-size-60 u-layout-cell-1">
                        <div class="u-border-1 u-border-grey-30 u-container-layout u-container-layout-1">
                           <h2 class="u-custom-font u-font-montserrat u-text u-text-custom-color-1 u-text-2">Booking {{$my_order->status}}</h2>
                           <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-10 u-text-3">Booked for {{date('D, d F, Y h:i a', strtotime($my_order->cart['slot_date'] .' '. $my_order->cart['slot_time']))}}</p>
                           <div class="u-border-2 u-border-custom-color-6 u-line u-line-horizontal u-line-1"></div>
                           <p class="u-custom-font u-font-montserrat u-text u-text-4"> A service provider will be assigned 15 minutes before booking time.<br>
                           </p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      @if($my_order->status == 'completed')
      <div class="u-clearfix u-expanded-width-md u-expanded-width-sm u-expanded-width-xs u-gutter-10 u-layout-wrap u-layout-wrap-1">
         <div class="u-layout">
            <div class="u-layout-col min-high-unset">
               <div class="u-size-60">
                  <div class="u-layout-row">
                     <div class="u-align-left u-container-style u-layout-cell u-right-cell u-size-60 u-layout-cell-1">
                        <div class="u-border-1 u-border-grey-30 u-container-layout u-container-layout-1">
                           <h2 class="u-custom-font u-font-montserrat u-text u-text-custom-color-1 u-text-2">Rating and Review</h2>
                           @if(!empty($my_order->cart['packages']))
                           @foreach($my_order->cart['packages'] as $package)
                           <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-10 u-text-6"> {{$package['title']}}<br>
                           </p>
                           <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-10 u-text-7"> &nbsp; <button class="button review" data-toggle="modal" data-target="#reviewModel" data-type="package" data-id="{{ $package['id'] }}">Review</button></p>
                           @endforeach
                           @endif
                           @if(!empty($my_order->cart['services']))
                           @foreach($my_order->cart['services'] as $service)

                           <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-10 u-text-6"> {{$service['title']}}<br>
                           <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-10 u-text-7"> &nbsp; <button class="button review" data-toggle="modal" data-target="#reviewModel" data-type="service" data-id="{{ $service['id'] }}">Review</button></p>
                           </p>
                           @endforeach
                           @endif
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      @endif
</div>
<div class="col-md-6">
      <div class="u-clearfix u-expanded-width-md u-expanded-width-sm u-expanded-width-xs u-gutter-0 u-layout-wrap u-layout-wrap-2">
         <div class="u-layout">
            <div class="u-layout-col min-high-unset">
               <div class="u-size-30">
                  <div class="u-layout-row">
                     <div class="u-align-left u-container-style u-layout-cell u-right-cell u-size-60 u-layout-cell-2">
                        <div class="u-border-1 u-border-grey-30 u-container-layout u-container-layout-2">
                           <h2 class="u-custom-font u-font-montserrat u-text u-text-custom-color-10 u-text-5"> Payment Summary</h2>
                           @if(!empty($my_order->cart['packages']))
                           @foreach($my_order->cart['packages'] as $package)
                           <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-10 u-text-6"> {{$package['title']}} x{{$package['quantity']}}<br>
                           </p>
                           <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-10 u-text-7"> &nbsp; ₹{{$package['price']}}</p>
                           @foreach($package['package_service'] as $service)
                           <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-10 u-text-8"> {{$service['title']}}
                           </p>
                           @endforeach
                           @endforeach
                           @endif
                           @if(!empty($my_order->cart['services']))
                           @foreach($my_order->cart['services'] as $service)
                           <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-10 u-text-6"> {{$service['title']}} x{{$service['quantity']}}<br>
                           <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-10 u-text-7"> &nbsp; ₹{{$service['price']}}</p>
                           </p>
                           @endforeach
                           @endif
                           <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-10 u-text-9">&nbsp;​Offer discount&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;<span class="u-text-custom-color-1"></span>
                           </p>
                           <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-1 u-text-10"> &nbsp; ₹{{$my_order->coupon_discount}}</p>
                           <div class="u-border-2 u-border-custom-color-6 u-line u-line-horizontal u-line-2"></div>
                           <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-10 u-text-14">&nbsp;​Amount to Pay&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p>
                           <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-10 u-text-15"> &nbsp; ₹{{$my_order->pay_amount}}</p>

                           @if($my_order->payment_status == 'Pending')
                              @php
                                 $pay_amount = $my_order->pay_amount;
                                 $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));
                                 $razorpayOrder  = $api->order->create([
                                    'receipt' => $my_order->order_number,
                                    'amount'  => $pay_amount*100,
                                    'currency' => 'INR'
                                 ]);

                                // print_r(Auth::user())
                              @endphp
                             <button id="rzp-button1" class="btn btn-primary">Pay</button>
                             <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
                             <script>
                              var options = {
                                  "key": "{{env('RAZOR_KEY')}}", // Enter the Key ID generated from the Dashboard
                                  "amount": "{{$pay_amount*100}}", // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                                  "currency": "INR",
                                  "name": "{{env('APP_NAME')}}",
                                  "description": "Payment",
                                  "image": "{{asset('front/images/logo1.png')}}",
                                  "order_id": "{{$razorpayOrder->id}}", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
                                  "handler": function (response){
                                    document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                                    document.getElementById('razorpay_signature').value = response.razorpay_signature;
                                    document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
                                    document.razorpayform.submit();
                                  },
                                  "prefill": {
                                      "name": "{{Auth::user()->name}}",
                                      "email": "{{Auth::user()->email}}",
                                      "contact": "{{Auth::user()->mobile}}"
                                  },
                                  "notes": {
                                      "address": "",
                                      "merchant_order_id": "{{$my_order->order_number}}"
                                  },
                                  "theme": {
                                      "color": "#ff7400"
                                  }
                              };
                              var rzp1 = new Razorpay(options);
                              rzp1.on('payment.failed', function (response){
                                    //   alert(response.error.code);
                                    //   alert(response.error.description);
                                    //   alert(response.error.source);
                                    //   alert(response.error.step);
                                    //   alert(response.error.reason);
                                    //   alert(response.error.metadata.order_id);
                                    //   alert(response.error.metadata.payment_id);
                              });
                              document.getElementById('rzp-button1').onclick = function(e){
                                  rzp1.open();
                                  e.preventDefault();
                              }
                              </script>
                              <form name='razorpayform' action="{{route('payment')}}" method="POST">
                                 @csrf
                                 <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                                 <input type="hidden" name="razorpay_signature"  id="razorpay_signature" >
                                 <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
                                 <input type="hidden" name="order_number" value="{{$my_order->order_number}}">
                             </form>
                              {{-- <form action="{{route('payment')}}" method="POST" >
                                 <script src="https://checkout.razorpay.com/v1/checkout.js"
                                         data-key="{{ env('RAZOR_KEY') }}"
                                         data-amount="{{$pay_amount*100}}"
                                         data-buttontext="Pay {{$pay_amount}} INR"
                                         data-name="{{env('APP_NAME')}}"
                                         data-description="Payment"
                                         data-image="{{asset('front/images/logo1.png')}}"
                                         data-prefill.name="{{Auth::user()->name}}"
                                         data-prefill.email="{{Auth::user()->email}}"
                                         data-prefill.contact="{{Auth::user()->mobile}}"
                                         data-theme.color="#ff7400">
                                         data-class="btn btn-primary"
                                 </script>
                                 <input type="hidden" name="_token" value="{!!csrf_token()!!}">
                             </form> --}}
                           @else
                              <p class="text-right"><span class="badge ">Paid</span></p>
                           @endif

                        </div>
                     </div>
                  </div>
               </div>
               <div class="u-size-30">
                  <div class="u-layout-row">
                     <div class="u-container-style u-layout-cell u-right-cell u-shape-rectangle u-size-60 u-layout-cell-3" src="">
                        <div class="u-border-1 u-border-grey-30 u-container-layout u-container-layout-3">
                           <h2 class="u-custom-font u-font-montserrat u-text u-text-custom-color-10 u-text-16"> Booking Details</h2>
                           <span class="u-icon u-icon-circle u-text-custom-color-1 u-icon-5">
                              <svg class="u-svg-link" preserveAspectRatio="xMidYMin slice" viewBox="0 0 54.757 54.757" style="">
                                 <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-ac21"></use>
                              </svg>
                              <svg class="u-svg-content" viewBox="0 0 54.757 54.757" x="0px" y="0px" id="svg-ac21" style="enable-background:new 0 0 54.757 54.757;">
                                 <path d="M40.94,5.617C37.318,1.995,32.502,0,27.38,0c-5.123,0-9.938,1.995-13.56,5.617c-6.703,6.702-7.536,19.312-1.804,26.952
                                    L27.38,54.757L42.721,32.6C48.476,24.929,47.643,12.319,40.94,5.617z M27.557,26c-3.859,0-7-3.141-7-7s3.141-7,7-7s7,3.141,7,7
                                    S31.416,26,27.557,26z"></path>
                              </svg>
                           </span>
                           <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-10 u-text-17">Service Location</p>
                           <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-10 u-text-18"> {{$my_order->cart['flat_building_no']}}, {{$my_order->cart['address']}}<br>
                           </p>
                           <span class="u-custom-color-1 u-icon u-icon-circle u-spacing-3 u-icon-6">
                              <svg class="u-svg-link" preserveAspectRatio="xMidYMin slice" viewBox="0 0 60 60" style="">
                                 <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-f24a"></use>
                              </svg>
                              <svg class="u-svg-content" viewBox="0 0 60 60" x="0px" y="0px" id="svg-f24a" style="enable-background:new 0 0 60 60;">
                                 <path d="M30,0.061c-16.542,0-30,13.458-30,30s13.458,29.879,30,29.879s30-13.337,30-29.879S46.542,0.061,30,0.061z M32,30.939
                                    c0,1.104-0.896,2-2,2H14c-1.104,0-2-0.896-2-2s0.896-2,2-2h14v-22c0-1.104,0.896-2,2-2s2,0.896,2,2V30.939z"></path>
                              </svg>
                           </span>
                           <p class="u-custom-font u-font-montserrat u-text u-text-19">
                              <span class="u-text-custom-color-10">Timings</span>
                           </p>
                           <p class="u-custom-font u-font-montserrat u-text u-text-20">
                              <span class="u-text-custom-color-10">{{date('D, d F, Y h:i a', strtotime($my_order->cart['slot_date'] .' '. $my_order->cart['slot_time']))}}</span>
                              <br>
                           </p>
                           <span class="u-icon u-icon-circle u-text-custom-color-1 u-icon-7">
                              <svg class="u-svg-link" preserveAspectRatio="xMidYMin slice" viewBox="0 0 512 512" style="">
                                 <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-68e9"></use>
                              </svg>
                              <svg class="u-svg-content" viewBox="0 0 512 512" id="svg-68e9">
                                 <g>
                                    <path d="m512 163v-27c0-30.928-25.072-56-56-56h-400c-30.928 0-56 25.072-56 56v27c0 2.761 2.239 5 5 5h502c2.761 0 5-2.239 5-5z"></path>
                                    <path d="m0 205v171c0 30.928 25.072 56 56 56h400c30.928 0 56-25.072 56-56v-171c0-2.761-2.239-5-5-5h-502c-2.761 0-5 2.239-5 5zm128 131c0 8.836-7.164 16-16 16h-16c-8.836 0-16-7.164-16-16v-16c0-8.836 7.164-16 16-16h16c8.836 0 16 7.164 16 16z"></path>
                                 </g>
                              </svg>
                           </span>
                           <p class="u-text u-text-custom-color-10 u-text-21">&nbsp;<span style="font-size: 1rem;">Payment History</span>
                           </p>
                           <p class="u-text u-text-custom-color-10 u-text-22"> {{$my_order->payment_status}}<br>
                           </p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div></div>
</div>
   </div>
</section>
<div class="modal fade" id="reviewModel" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <div class="modal-body">
            <!--
               start code for login form
               -->
            <form id="post-form-review" action="{{ url('send_review') }}">
               @csrf
               <p style="text-align:center;font-size:30px;margin-bottom: 20px;color:#3896ff;">Add Your Review Here
               </p>
               <div class="input_review"></div>
               <div class="rate">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="form-group">
                          <input type="hidden" name="type" id="type">
                          <input type="hidden" name="id" id="id">
                           <div class="rate">
                              <input type="radio" id="star5" name="rate" value="5" />
                              <label for="star5" title="text">5 stars</label>
                              <input type="radio" id="star4" name="rate" value="4" />
                              <label for="star4" title="text">4 stars</label>
                              <input type="radio" id="star3" name="rate" value="3" />
                              <label for="star3" title="text">3 stars</label>
                              <input type="radio" id="star2" name="rate" value="2" />
                              <label for="star2" title="text">2 stars</label>
                              <input type="radio" id="star1" name="rate" value="1" />
                              <label for="star1" title="text">1 star</label>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12">
                     <label>Comment<span class="text-danger">*</span></label>
                     <textarea id="w3review" name="w3review" rows="4" cols="50"> </textarea>
                  </div>
               </div>
               <div class="tt-form__btn" style="display:flex;justify-content:center;">
                  <button type="submit" class="btn btn-success submit_revivew"><span> Submit </span></button>
               </div>
            </form>
            <!--
               end code for login form
               -->
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         </div>
      </div>
   </div>
</div>

@endsection
@section('scripts')

<script src="{{ asset('js/plugin/sweetalert/sweetalert2.all.min.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('.review').on("click", function(){
      var type = $(this).attr("data-type");
      var id = $(this).attr("data-id");
      $('#type').val(type);
      $('#id').val(id);
    });

    $('.cancel_order').click(function(){
      $.ajax({
         url : '{{ url("/cancel_order/".$my_order->id) }}',
         type : 'post',
         async : false,
         data : {
            '_token' : "{{ csrf_token() }}",
         },
         success : function(data)  {
            if(data.success){

               Swal.fire({
                     title: 'Success',
                     text: data.message,
                     type: "success",
                     showCancelButton: false,
                     confirmButtonColor: "#3085d6",
                     confirmButtonClass: "btn btn-primary",
                     closeOnConfirm: true,
                  }).then(function (result) {
                     window.location.reload();
                  });
            }else{
               Swal.fire("Error!", data.message, "error");
            }
         }
      });
      return false;
    });
    $(".submit_revivew").on("click",function(){
      var star_rate = $("input[name=rate]:checked").val();
      var comment = $("#w3review").val();
      var type = $('#type').val();
      var id = $('#id').val();
      //var token = $('meta[name="csrf-token"]').attr('content');
      //var form_data = $("#post-form-review").serialize();
      $.ajax({
        url : '{{ url("/send_review") }}',
        type : 'post',
        datatype:'json',
        data : {
          '_token' : "{{ csrf_token() }}",
          'type' : type,
          'id' : id,
          'comment' : comment,
          'star_rate' : star_rate
         },
        success : function(data)
        {
          $('.input_review').html('');
          $("#reviewModel").modal("hide");
          $('.close').click();
        }

      });
      return false;
    });
  });
</script>
@endsection
