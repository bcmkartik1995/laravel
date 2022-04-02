@extends('layouts.front')
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
  <link rel="stylesheet" href="{{ asset('front/css/blogg.css') }}" media="screen">
  <link rel="stylesheet" href="{{ asset('front/css/blog1.css') }}" media="screen">
  <style>
     .see_cart {
      position: fixed;
      top: 345px;
      right: 16px;
      font-size: 18px;
      background-color: #ff7400;
      border-radius: 9px;
      padding: 10px;
      z-index: 99;
   }
   .badge {
         cursor: pointer;
      }
      #sec-c9e6 {
         position : relative;
      }
  </style>
@section('content')
<section class="u-clearfix u-section-1" id="sec-c9e6">
<div class="see_cart">
   <h6 class="item" id="item">Total Item :<span id="item_cart">0</span></h6>
   <h6 class="amount" id="amount">Totla Amount : <span id="amount_cart">0</span></h6>
   <div>
      <span id="list_item"> </span>
   </div>
   <div>
      <span id="list_amount"></span>
   </div>
   <div class="cart_package_detail">
      <a href="javascript:void(0);" class="button countinue-cart">Countinue</a>
   </div>
</div>
<form id="view_cart" class="tt-modal__body modal__size-lg">

</form>

         <div class="u-clearfix u-sheet u-sheet-1">
            <div class="u-custom-color-2 u-expanded-width u-shape u-shape-rectangle u-shape-1"></div>
            <p class="u-text u-text-white u-text-1"> {{ $cat['title'] }}  </p>
            <p class="u-text u-text-2">&nbsp;<span class="u-text-body-alt-color">{{$review_ratings}}/​5</span>
               <br>
            </p>
            <p class="u-text u-text-white u-text-3"> Based on {{$total_review_count}} ​rate</p>
            <div class="u-clearfix u-expanded-width u-gutter-0 u-layout-wrap u-white u-layout-wrap-1">
               <div class="u-layout" style="">
                  <div class="u-layout-row" style="">
                     <div class="u-container-style u-layout-cell u-shape-rectangle u-size-16-xl u-size-18-lg u-size-21-md u-size-21-sm u-size-21-xs u-layout-cell-1">
                        <div class="u-container-layout u-container-layout-1">
                           @foreach($sub_cat as $sub_category)
                           <img class="u-image u-image-default u-preserve-proportions u-image-1" src="{{ asset('front/images/arrow21.jpg') }}" alt="" data-image-width="900" data-image-height="520">
                           <a href="{{ url('serviceList/'.$cat->slug.'/'.$sub_category['slug']) }}" class="u-border-1 u-border-active-palette-2-base u-border-hover-palette-1-base u-btn u-button-style u-custom-font u-font-montserrat u-none u-text-custom-color-4 u-btn-1"> {{ $sub_category->title }} </a>
                           @endforeach
                        </div>
                     </div>
                     <div class="u-container-style u-layout-cell u-size-39-md u-size-39-sm u-size-39-xs u-size-42-lg u-size-44-xl u-layout-cell-2">
                        <div class="u-container-layout u-container-layout-2"></div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="u-clearfix u-expanded-width-sm u-expanded-width-xs u-layout-wrap u-layout-wrap-2">
               <div class="u-layout">
                  <div class="u-layout-row">
                     <div class="u-align-left u-container-style u-layout-cell u-size-60 u-layout-cell-3">
                        <div class="u-container-layout u-valign-top-xs u-container-layout-3">

                           @if(count($all_packages)==0 && count($services)==0)
                           <div class="u-border-1 u-border-grey-dark-1 u-container-style u-expanded-width-sm u-expanded-width-xs u-group u-radius-4 u-shape-round u-group-2 items-div" data-type="service" data-id="">
                                 <div class="u-container-layout u-container-layout-5">
                                    <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-3 u-text-8">Sorry Currently Data Not Available</p>
                                    <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-4 u-text-9">&nbsp;<span style="font-size: 16px;"class="u-text-custom-color-1"></span>
                                       </span>
                                       <br>
                                    </p>

                                    <input type="hidden" name="service_price[]" class="service_price" value="">
                                    <input type="hidden" name="service_quantity[]" class="service_quantity">
                                    <p class="u-custom-font u-font-montserrat u-text u-text-10"> </p>
                                    <p class="u-custom-font u-font-montserrat u-text u-text-11">  </p>

                                 </div>
                              </div>
                              <script type="text/javascript">
                                 $(document).ready(function(){
                                    $(".see_cart").hide();
                                 });
                              </script>
                           @else
                           @if(!empty($all_packages))
                           @foreach($all_packages as $pack)
                           <div class="u-border-1 u-border-grey-dark-1 u-container-style u-expanded-width-xs u-group u-radius-4 u-shape-round u-group-1 items-div" data-type="package" data-id="{{ $pack->id }}">
                              <div class="u-container-layout u-container-layout-4">
                                 <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-4 u-text-4"> &nbsp; {{ $pack->title }}</p>
                                 <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-4 u-text-5">&nbsp;<span class="discountvalue" style="font-size: 16px;"></span>&nbsp;<span class="fullvalue" style="font-size: 16px;"></span>
                                    <br>
                                 </p>
                                 <input type="hidden" class="discount_type" value="{{ $pack->discount_type }}">
                                 <input type="hidden" class="discount_value" value="{{ $pack->discount_value }}">
                                 <input type="hidden" class="minimum_require" value="{{ $pack->minimum_require }}">
                                 <input type="hidden" name="package_price[{{ $pack->id }}]" class="package_price">
                                 <input type="hidden" name="package_quantity[{{ $pack->id }}]" class="package_quantity">
                                 @foreach($pack->package_services as $pack_service)
                                 <img class="u-image u-image-default u-preserve-proportions u-image-9" src="{{ asset('front/images/arrow21.jpg') }}" alt="" data-image-width="900" data-image-height="520">
                                 <p class="u-custom-font u-font-montserrat u-text u-text-6">
                                    <span style="font-size: 0.75rem;"> {{$pack_service->service->title }}</span>
                                 </p>
                                 @endforeach

                                 @php
                                 $quantity = 0;
                                 $inCart = false;
                                 if(isset($my_cart['packages'][$pack->id])){
                                    $quantity = $my_cart['packages'][$pack->id]['quantity'];
                                    $inCart = true;
                                 }
                                 @endphp
                                 <input type="submit" name="cart_{{ $pack->id }}" style="{{$inCart==true?'display:none;':''}}" data-package_name = "{{ $pack->title }}" data-id="{{ $pack->id }}" value="Add to cart" class="button package_{{ $pack->id }} package_button u-border-none u-btn u-button-style u-custom-color-1 u-hover-custom-color-1 u-btn-9">
                                 <div class="package_cart_{{ $pack->id }} add-remove u-border-none u-btn u-button-style u-custom-color-1 u-hover-custom-color-1 u-btn-9" data-id="package_cart_{{ $pack->id }}"  style="{{$inCart==true?'':'display:none;'}}">
                                    <button id="minus" data-package_id="{{ $pack->id }}" height="10px;" width="20px;" data-value="1" class="button minus_package"> - </button>
                                    <input type="submit" id="value_package_{{ $pack->id }}" height="10px;" width="20px;"  value="{{$quantity}}" class="button quantity">
                                    <button id="plus" data-package_id="{{ $pack->id }}" height="10px;" data-package_name = "{{ $pack->title }}" data-id="{{ $pack->id }}" width="20px;" data-value="1" class="button plus_package"> + </button>
                                 </div>

                                 <span data-toggle="modal" data-target="#myModal_package_edit-{{ $pack->id }}" class="badge badge-success u-border-none u-btn u-button-style u-custom-color-4 u-hover-custom-color-4 u-btn-10" data-id="{{ $pack->id }}"  id="pac_{{ $pack->id }}"  data-title="{{ $pack->title }}" style="margin-top: 20px;">Edit Package</span>
                                 <div class="modal fade" id="myModal_package_edit-{{ $pack->id }}" role="dialog">
                                    <div class="modal-dialog">
                                       <div class="modal-content">
                                          <div class="modal-header">
                                             <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          </div>
                                          <div class="modal-body">
                                             <form class="package" action="javascript:void(0)">
                                                      @csrf
                                                      <p style="text-align:center;font-size:30px;margin-bottom: 20px;color:#3896ff;">Edit your package
                                                      </p>
                                                      <div class="alert alert-success print-success-msg-login" style="display:none">
                                                         <ul></ul>
                                                      </div>
                                                      <div class="alert alert-danger print-danger-msg-login" style="display:none">
                                                         <ul></ul>
                                                      </div>
                                                      <div class="myModal_package_edit">
                                                      @foreach($pack->package_services as $pack_service)
                                                      <div class="row">
                                                         <div class="col-md-12">
                                                            <label>{{$pack_service->service->title}}</label> : <input type="checkbox" data-price="{{$pack_service->service->price}}" class="package_services" value="{{$pack_service->service->price}}" data-id="{{$pack_service->service->id}}" data-is-default="{{$pack_service->is_defult}}" {{$pack_service->is_defult ? 'checked':''}}></div></div>

                                                      @endforeach

                                                      </div>
                                                      <div class="tt-form__btn" style="display:flex;justify-content:center;">

                                                      </div>
                                             </form>
                                          </div>
                                          <div class="modal-footer">
                                             <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                          </div>
                                       </div>

                                    </div>
                                 </div>
                              </div>
                           </div>
                           @endforeach
                           @endif
                           @if(!empty($services))
                           @foreach($services as $serve)
                           <div class="u-border-1 u-border-grey-dark-1 u-container-style u-expanded-width-sm u-expanded-width-xs u-group u-radius-4 u-shape-round u-group-2 items-div" data-type="service" data-id="{{ $serve->id }}">
                              <div class="u-container-layout u-container-layout-5">
                                 <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-3 u-text-8"> &nbsp; {{ $serve->title }}</p>
                                 <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-4 u-text-9">&nbsp;<span style="font-size: 16px;"class="u-text-custom-color-1">{{ number_format($serve->price,2) }}</span>
                                    </span>
                                    <br>
                                 </p>

                                 <input type="hidden" name="service_price[{{ $serve->id }}]" class="service_price" value="{{ $serve->price }}">
                                 <input type="hidden" name="service_quantity[{{ $serve->id }}]" class="service_quantity">
                                 @php
                                 $quantity = 0;
                                 $inCart = false;
                                 if(isset($my_cart['services'][$serve->id])){
                                    $quantity = $my_cart['services'][$serve->id]['quantity'];
                                    $inCart = true;
                                 }
                                 @endphp
                                 <img class="u-image u-image-default u-preserve-proportions u-image-11" src="{{ asset('front/images/arrow21.jpg') }}" alt="" data-image-width="900" data-image-height="520">
                                 <p class="u-custom-font u-font-montserrat u-text u-text-10"> {{ $serve->description }} </p>
                                 <p class="u-custom-font u-font-montserrat u-text u-text-11"> {{ $serve->long_description }} </p>
                                 <input type="submit" style="font-size:0.875rem;{{$inCart==true?'display:none;':''}}" name="cart_{{ $serve->id }}" data-service="{{ $serve->title }}" data-id="{{ $serve->id }}" data-price="{{ $serve->price }}" value="Add to cart" class="button service_{{ $serve->id }} service_button u-border-none u-btn u-button-style u-custom-color-1 u-hover-custom-color-1 u-btn-11">
                                 <div class="service_cart_{{ $serve->id }} add-remove u-border-none u-btn u-button-style u-custom-color-1 u-hover-custom-color-1 u-btn-11" id="service_cart_{{ $serve->id }}" style="{{$inCart==true?'':'display:none;'}}">
                                    <button id="minus" data-service_id="{{ $serve->id }}" height="10px;" width="20px;" class="button minus_service"> - </button>
                                    <input type="submit" id="value_service_{{ $serve->id }}" height="10px;" width="20px;" value="{{$quantity}}" class="button quantity">
                                    <button id="plus" data-service_id="{{ $serve->id }}" height="10px;" width="20px;" class="button plus_service"> + </button>
                                 </div>
                              </div>
                           </div>
                          @endforeach
                          @endif
                          @endif
                          <script text="text/javascript">
                              var my_cart = {};
                              $(document).ready(function(){
                                 <?php
                                 if(!empty($my_cart)){
                                    //print_R($my_cart);
                                 }
                                 ?>
                                 // $("#view_cart").hide();
                                 // $('#myModal').hide();
                                 calculate_price();
                                 // $(".see_cart").hide();
                                 // $(".add-remove").hide();
                                 $(".package_button").on("click", function(){
                                    var package_id = $(this).attr("data-id");
                                    $(".see_cart").show();
                                    $(".package_" + package_id).hide();
                                    $("#value_package_"+package_id).val(1);
                                    $(".package_cart_"+package_id).show();
                                    calculate_price();
                                 });

                                 $(".service_button").on("click", function(){
                                    var package_id = $(this).attr("data-id");
                                    $(".service_" + package_id).hide();
                                    $("#value_service_"+package_id).val(1);
                                    $(".service_cart_"+package_id).show();
                                    $(".see_cart").show();
                                    calculate_price();
                                 });

                                 $(".plus_package").on("click", function(){
                                    package_id = $(this).data('package_id');
                                    var default_value = parseFloat($("#value_package_"+package_id).val());
                                    var after_add_value = parseFloat(default_value) + 1;
                                    $("#value_package_"+package_id).val(after_add_value);
                                    $(".see_cart").show();
                                    calculate_price();
                                 });
                                 $(".minus_package").on("click", function(e){
                                    package_id = $(this).data('package_id');
                                    var default_value = parseFloat($("#value_package_"+package_id).val());
                                    if(default_value > 1){
                                       $(".package_"+package_id).hide();
                                       $(".package_cart_"+package_id).show();
                                    }
                                    if(default_value > 0){
                                       var after_sub = parseFloat(default_value) - 1;
                                       $("#value_package_"+package_id).val(after_sub);
                                       calculate_price();
                                       if(after_sub==0){
                                          $(".package_"+package_id).show();
                                          $(".package_cart_"+package_id).hide();
                                       }
                                    }
                                 });

                                 $(".plus_service").on("click", function(){
                                    service_id = $(this).data('service_id');
                                    var default_value = parseFloat($("#value_service_"+service_id).val());
                                    var after_add_value = parseFloat(default_value) + 1;
                                    $("#value_service_"+service_id).val(after_add_value);
                                    $(".see_cart").show();
                                    calculate_price();
                                 });
                                 $(".minus_service").on("click", function(e){
                                    service_id = $(this).data('service_id');
                                    var default_value = parseFloat($("#value_service_"+service_id).val());
                                    if(default_value > 1){
                                       $(".service_"+service_id).hide();
                                       $(".service_cart_"+service_id).show();
                                    }
                                    if(default_value > 0){
                                       var after_sub = parseFloat(default_value) - 1;
                                       $("#value_service_"+service_id).val(after_sub);
                                       calculate_price();
                                       if(after_sub==0){
                                          $(".service_"+service_id).show();
                                          $(".service_cart_"+service_id).hide();
                                       }
                                    }
                                 });

                                 $('.package_services').click(function(){
                                    calculate_price();
                                 });

                                 $('.countinue-cart').click(function(){
                                    $.ajax({
                                       header:{
                                          'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                                       },
                                       url : '/create_cart_session',
                                       type : "post",
                                       dataType:'json',
                                       data : {
                                          "_token": "{{ csrf_token() }}",
                                          "my_cart": my_cart
                                       },
                                       success : function(data) {
                                          if(data.isUserLogin){
                                             window.location.href= "{{ URL::to('/mycart') }}";
                                          }else{
                                             $('#btn-login').trigger('click');
                                          }
                                          console.log(data)
                                       }
                                    });
                                 });
                              });

                           </script>
                          <script text="text/javascript">

                          function calculate_price(){

                              my_cart.packages = [];
                              my_cart.services = [];

                              total_price = 0;
                              total_items = 0;
                              $(".items-div").each(function(){

                                 pkg_obj = $(this);
                                 type = pkg_obj.data('type');
                                 quantity = pkg_obj.find('.quantity').val();

                                 if(quantity){
                                    quantity = parseInt(quantity);
                                    if(type == 'package'){
                                       services = [];
                                       default_services = [];
                                       package_total_price = 0;
                                       total_package_services = 0;
                                       package_new_price = 0;
                                       default_price = 0;
                                       default_total = 0;
                                       pkg_obj.find('.package_services').each(function(){

                                          if (this.checked) {
                                             package_total_price += parseFloat($(this).val());
                                             total_package_services++;
                                             services.push($(this).data('id'));
                                          }

                                          if($(this).data('is-default')){
                                             default_total++;
                                             default_price  += parseFloat($(this).val());
                                             default_services.push($(this).data('id'))
                                          }
                                       });
                                       discount_type = pkg_obj.find('.discount_type').val();
                                       discount_value = pkg_obj.find('.discount_value').val();
                                       minimum_require = pkg_obj.find('.minimum_require').val();

                                       if(quantity && total_package_services){
                                          package_new_price = package_total_price*quantity;

                                          if(minimum_require <= total_package_services){
                                             if(discount_type == '1'){
                                                package_new_price = package_total_price - ((package_total_price*discount_value)/100);
                                             }else{
                                                package_new_price = package_total_price - discount_value;
                                             }
                                          }
                                          total_price = total_price + (package_new_price*quantity);
                                       }else{
                                          package_total_price = package_new_price = default_price;
                                          if(minimum_require <= default_total){
                                             if(discount_type == '1'){
                                                package_new_price = package_total_price - ((package_total_price*discount_value)/100);
                                             }else{
                                                package_new_price = package_total_price - discount_value;
                                             }
                                          }
                                          if(quantity){
                                             total_price = total_price + (package_new_price);
                                          }
                                       }

                                       package_new_price = package_new_price.toFixed(2);
                                       package_total_price = package_total_price.toFixed(2);
                                       pkg_obj.find('.discountvalue').html(package_new_price);
                                       pkg_obj.find('.fullvalue').html('<del>'+package_total_price+'</del>');

                                       pkg_obj.find('.package_price').val(package_new_price);
                                       pkg_obj.find('.package_quantity').val(quantity);

                                       if(quantity){

                                          data = {
                                             'id' : pkg_obj.data('id'),
                                             'quantity' : quantity,
                                             'price' : package_new_price,
                                             'original_price' : package_total_price
                                          }
                                          if(total_package_services){
                                             data.services = services;
                                          }else{
                                             data.services = default_services;
                                          }
                                          my_cart.packages.push(data);
                                       }

                                    }else{
                                       service_price = pkg_obj.find('.service_price').val() * quantity;
                                       total_price = total_price + (service_price);
                                       if(quantity){
                                          data = {
                                             'id' : pkg_obj.data('id'),
                                             'quantity' : quantity,
                                             'price' : service_price.toFixed(2),
                                             'original_price' : service_price.toFixed(2)
                                          }
                                          my_cart.services.push(data);
                                       }
                                    }
                                    total_items += quantity;
                                 }
                              });
                              total_price = total_price.toFixed(2);
                              my_cart.category_id = " {{ $cat['id'] }}";
                              console.log(my_cart);
                              if(total_price == 0){
                                 $(".see_cart").hide();
                              }
                              $('#item_cart').html(total_items)
                              $('#amount_cart').text(total_price);
                          }

                           $(document).ready(function(){
                              // $(".see_cart").hide();
                              // $(".add-remove").hide();
                           });

                           </script>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <p class="u-text u-text-custom-color-5 u-text-12"> How it Works </p>
            <div class="u-border-1 u-border-custom-color-6 u-line u-line-horizontal u-line-1"></div>
            <img class="u-image u-image-default u-preserve-proportions u-image-13" src="{{ asset('front/images/01.png') }}" alt="" data-image-width="48" data-image-height="48">
            <img class="u-image u-image-default u-preserve-proportions u-image-14" src="{{ asset('front/images/02.png') }}" alt="" data-image-width="150" data-image-height="150">
            <img class="u-image u-image-default u-preserve-proportions u-image-15" src="{{ asset('front/images/03.png') }}" alt="" data-image-width="150" data-image-height="150">
            <img class="u-image u-image-default u-preserve-proportions u-image-16" src="{{ asset('front/images/04.png') }}" alt="" data-image-width="150" data-image-height="150">
            <p class="u-align-center u-custom-font u-font-montserrat u-text u-text-custom-color-3 u-text-13"> Choose the ty​pe<br>&nbsp;of AC
            </p>
            <p class="u-align-center u-custom-font u-font-montserrat u-text u-text-custom-color-3 u-text-14"> Choose the service<br>&nbsp;you need
            </p>
            <p class="u-align-center u-custom-font u-font-montserrat u-text u-text-custom-color-3 u-text-15"> Choose your<br>&nbsp;time-slot
            </p>
            <p class="u-align-center u-custom-font u-font-montserrat u-text u-text-custom-color-3 u-text-16"> Hassle-free<br>&nbsp;service
            </p>
            <p class="u-align-left u-custom-font u-font-montserrat u-text u-text-custom-color-3 u-text-17"> We Service all types of ACs: Split, Window, Central</p>
            <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-3 u-text-18"> We Service all types of ACs: Split, Window, Central</p>
            <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-3 u-text-19"> We service from 9 AM - 9&nbsp;<br>PM
            </p>
            <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-3 u-text-20"> Our professional will get in touch with you&nbsp;</p>
            <div class="u-border-1 u-border-custom-color-6 u-line u-line-horizontal u-line-2"></div>
            <!-- <div class="u-border-2 u-border-custom-color-6 u-shape u-shape-rectangle u-white u-shape-2"></div> -->
            <!-- <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-3 u-text-21"> AC Service in Delhi</p>
            <p class="u-custom-font u-font-montserrat u-text u-text-22"> Get 10% OFF all​Get your window or split AC service in Delhi done by<br>&nbsp;Velox Solution .......<br>
            </p> -->
         </div>
      </section>
      <section class="u-clearfix u-section-2" id="sec-2a94">
         <div class="u-clearfix u-sheet u-sheet-1">
            <div class="u-border-2 u-border-custom-color-6 u-expanded-width u-shape u-shape-rectangle u-white u-shape-1"></div>
            <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-3 u-text-1"> Technicians</p>
            <p class="u-custom-font u-font-montserrat u-text u-text-2"> 1,447 AC Service and Repair Professionals in New Delhi<br>
            </p>
            <!--div class="u-clearfix u-expanded-width u-gutter-0 u-layout-wrap u-layout-wrap-1">
               <div class="u-layout">
                  <div class="u-layout-row">
                     <div class="u-align-left u-container-style u-layout-cell u-right-cell u-size-60 u-layout-cell-1">
                        <div class="u-border-2 u-border-custom-color-6 u-container-layout u-valign-top-xs u-container-layout-1">
                           <div class="u-image u-image-circle u-preserve-proportions u-image-1" alt="" data-image-width="160" data-image-height="160"></div>
                           <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-3 u-text-3"> Muddasser Kh​an</p>
                           <p class="u-custom-font u-font-montserrat u-text u-text-4">Delhi, Delhi, India<br>
                           </p>
                           <p class="u-custom-font u-font-montserrat u-text u-text-5"> 4.7&nbsp;(306 ratings)<br>
                           </p>
                           <div class="u-palette-2-light-2 u-shape u-shape-circle u-shape-2"></div>
                           <p class="u-custom-font u-font-montserrat u-text u-text-body-alt-color u-text-6">S<br>
                           </p>
                           <p class="u-custom-font u-font-montserrat u-text u-text-7"> Siddharth<br>
                           </p>
                           <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-7 u-text-8"> 5.0<br>
                           </p>
                           <p class="u-custom-font u-font-montserrat u-text u-text-9">
                              <span style="font-size: 0.75rem;"> Excellent behaviour and work is done in very gentle way</span>
                              <br>
                           </p>
                           <a href="" class="u-border-1 u-border-custom-color-6 u-btn u-btn-round u-button-style u-custom-font u-font-montserrat u-radius-22 u-white u-btn-1"> Click to read more reviews</a>
                           <p class="u-custom-font u-font-montserrat u-text u-text-body-alt-color u-text-10">S<br>
                           </p>
                        </div>
                     </div>
                  </div>
               </div>
            </div-->
            <div class="u-clearfix u-expanded-width u-gutter-0 u-layout-wrap u-layout-wrap-2 sec_div">
               <div class="u-layout">
                  <div class="u-layout-row">
                     <div class="u-align-left u-container-style u-layout-cell u-right-cell u-size-60 u-layout-cell-2">
                        <div class="u-border-2 u-border-custom-color-6 u-container-layout u-valign-top-xs u-container-layout-2">
                           <div class="u-image u-image-circle u-preserve-proportions u-image-2" alt="" data-image-width="160" data-image-height="160"></div>
                           <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-3 u-text-11"> Muddasser Kh​an</p>
                           <p class="u-custom-font u-font-montserrat u-text u-text-12">Delhi, Delhi, India<br>
                           </p>
                           <p class="u-custom-font u-font-montserrat u-text u-text-13"> 4.7&nbsp;(306 ratings)<br>
                           </p>
                           <div class="u-palette-2-light-2 u-shape u-shape-circle u-shape-3"></div>
                           <p class="u-custom-font u-font-montserrat u-text u-text-body-alt-color u-text-14">S<br>
                           </p>
                           <p class="u-custom-font u-font-montserrat u-text u-text-15"> Siddharth<br>
                           </p>
                           <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-7 u-text-16"> 5.0<br>
                           </p>
                           <p class="u-custom-font u-font-montserrat u-text u-text-17">
                              <span style="font-size: 0.75rem;"> Excellent behaviour and work is done in very gentle way</span>
                              <br>
                           </p>
                           <a href="" class="u-border-1 u-border-custom-color-6 u-btn u-btn-round u-button-style u-custom-font u-font-montserrat u-radius-22 u-white u-btn-2"> Click to read more reviews</a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="u-clearfix u-expanded-width u-gutter-0 u-layout-wrap u-layout-wrap-3">
               <div class="u-layout">
                  <div class="u-layout-row">
                     <div class="u-align-left u-container-style u-layout-cell u-right-cell u-size-60 u-layout-cell-3">
                        <div class="u-border-2 u-border-custom-color-6 u-container-layout u-valign-top-xs u-container-layout-3">
                           <div class="u-image u-image-circle u-preserve-proportions u-image-3" alt="" data-image-width="160" data-image-height="160"></div>
                           <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-3 u-text-18"> Muddasser Kh​an</p>
                           <p class="u-custom-font u-font-montserrat u-text u-text-19">Delhi, Delhi, India<br>
                           </p>
                           <p class="u-custom-font u-font-montserrat u-text u-text-20"> 4.7&nbsp;(306 ratings)<br>
                           </p>
                           <div class="u-palette-2-light-2 u-shape u-shape-circle u-shape-4"></div>
                           <p class="u-custom-font u-font-montserrat u-text u-text-body-alt-color u-text-21">S<br>
                           </p>
                           <p class="u-custom-font u-font-montserrat u-text u-text-22"> Siddharth<br>
                           </p>
                           <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-7 u-text-23"> 5.0<br>
                           </p>
                           <p class="u-custom-font u-font-montserrat u-text u-text-24">
                              <span style="font-size: 0.75rem;"> Excellent behaviour and work is done in very gentle way</span>
                              <br>
                           </p>
                           <a href="" class="u-border-1 u-border-custom-color-6 u-btn u-btn-round u-button-style u-custom-font u-font-montserrat u-radius-22 u-white u-btn-3"> Click to read more reviews</a>
                           <p class="u-custom-font u-font-montserrat u-text u-text-body-alt-color u-text-25">S<br>
                           </p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="u-clearfix u-expanded-width u-gutter-0 u-layout-wrap u-layout-wrap-4">
               <div class="u-layout">
                  <div class="u-layout-row">
                     <div class="u-align-left u-container-style u-layout-cell u-right-cell u-size-60 u-layout-cell-4">
                        <div class="u-border-2 u-border-custom-color-6 u-container-layout u-valign-top-xs u-container-layout-4">
                           <div class="u-image u-image-circle u-preserve-proportions u-image-4" alt="" data-image-width="160" data-image-height="160"></div>
                           <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-3 u-text-26"> Muddasser Kh​an</p>
                           <p class="u-custom-font u-font-montserrat u-text u-text-27">Delhi, Delhi, India<br>
                           </p>
                           <p class="u-custom-font u-font-montserrat u-text u-text-28"> 4.7&nbsp;(306 ratings)<br>
                           </p>
                           <div class="u-palette-2-light-2 u-shape u-shape-circle u-shape-5"></div>
                           <p class="u-custom-font u-font-montserrat u-text u-text-body-alt-color u-text-29">S<br>
                           </p>
                           <p class="u-custom-font u-font-montserrat u-text u-text-30"> Siddharth<br>
                           </p>
                           <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-7 u-text-31"> 5.0<br>
                           </p>
                           <p class="u-custom-font u-font-montserrat u-text u-text-32">
                              <span style="font-size: 0.75rem;"> Excellent behaviour and work is done in very gentle way</span>
                              <br>
                           </p>
                           <a href="" class="u-border-1 u-border-custom-color-6 u-btn u-btn-round u-button-style u-custom-font u-font-montserrat u-radius-22 u-white u-btn-4"> Click to read more reviews</a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <section class="u-align-center u-clearfix u-section-3" id="sec-d0ac">
         <div class="u-clearfix u-sheet u-sheet-1">
            <div id="carousel-1c88" data-interval="5000" data-u-ride="carousel" class="u-carousel u-expanded-width u-slider u-slider-1">
               <ol class="u-absolute-hcenter u-carousel-indicators u-hidden u-carousel-indicators-1">
                  <li data-u-target="#carousel-1c88" class="u-active u-grey-30" data-u-slide-to="0"></li>
                  <li data-u-target="#carousel-1c88" class="u-grey-30" data-u-slide-to="1"></li>
               </ol>
               <div class="u-carousel-inner" role="listbox">
                  <div class="u-active u-align-left u-carousel-item u-container-style u-slide">
                     <div class="u-container-layout u-container-layout-1">
                        <img alt="" class="u-expanded-width-sm u-expanded-width-xs u-image u-image-default u-image-1" data-image-width="370" data-image-height="300" src="{{ asset('front/images/news-img01.webp') }}">
                        <img alt="" class="u-expanded-width-sm u-expanded-width-xs u-image u-image-default u-image-2" data-image-width="370" data-image-height="300" src="{{ asset('front/images/news-img02.webp') }}">
                        <img alt="" class="u-expanded-width-sm u-expanded-width-xs u-image u-image-default u-image-3" data-image-width="370" data-image-height="300" src="{{ asset('front/images/news-img03.webp') }}">
                        <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-10 u-text-1"> The Most Common Types of Sewer Line Pipe</p>
                        <div class="u-container-style u-group u-shape-rectangle u-white u-group-1">
                           <div class="u-container-layout u-container-layout-2">
                              <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-3 u-text-2"> by&nbsp;<a href="#" class="u-active-none u-border-none u-btn u-button-style u-hover-none u-none u-text-palette-1-base u-btn-1">Admin</a>&nbsp;/<br>2&nbsp;Co​mments
                              </p>
                           </div>
                        </div>
                        <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-3 u-text-3"> How Does Pipe Leak Tape</p>
                        <div class="u-container-style u-group u-shape-rectangle u-white u-group-2">
                           <div class="u-container-layout u-container-layout-3">
                              <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-3 u-text-4"> by&nbsp;<a href="#" class="u-active-none u-border-none u-btn u-button-style u-hover-none u-none u-text-palette-1-base u-btn-2">Admin</a>&nbsp;/<br>2&nbsp;Co​mments
                              </p>
                           </div>
                        </div>
                        <div class="u-container-style u-group u-shape-rectangle u-white u-group-3">
                           <div class="u-container-layout u-container-layout-4">
                              <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-3 u-text-5"> by&nbsp;<a href="#" class="u-active-none u-border-none u-btn u-button-link u-button-style u-custom-font u-font-montserrat u-hover-none u-none u-text-palette-1-base u-btn-3">Admin</a>&nbsp;/<br>2&nbsp;Co​mments
                              </p>
                           </div>
                        </div>
                        <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-9 u-text-6">
                           <span class="u-text-custom-color-3">Why Copper is the Best Plumbing Material?</span>
                        </p>
                        <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-3 u-text-7"> Repairing or replacing a sewer line on your p<span style="font-weight: 400;"></span>roperty is one of the...
                        </p>
                        <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-3 u-text-8"> Driven by competition and the desire to cut costs, they put people...</p>
                        <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-3 u-text-9"> A clogged sewer line is one of the most common, frustrating, an they put people.... </p>
                     </div>
                  </div>
                  <div class="u-align-left u-carousel-item u-container-style u-slide">
                     <div class="u-container-layout u-container-layout-5">
                        <img alt="" class="u-expanded-width-sm u-expanded-width-xs u-image u-image-default u-image-4" data-image-width="370" data-image-height="300" src="{{ asset('front/images/news-img01.webp') }}">
                        <img alt="" class="u-expanded-width-sm u-expanded-width-xs u-image u-image-default u-image-5" data-image-width="370" data-image-height="300" src="{{ asset('front/images/news-img02.webp') }}">
                        <img alt="" class="u-expanded-width-sm u-expanded-width-xs u-image u-image-default u-image-6" data-image-width="370" data-image-height="300" src="{{ asset('front/images/news-img03.webp') }}">
                        <div class="u-container-style u-group u-shape-rectangle u-white u-group-4">
                           <div class="u-container-layout u-container-layout-6">
                              <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-3 u-text-10"> by&nbsp;<a href="#" class="u-active-none u-border-none u-btn u-button-style u-hover-none u-none u-text-palette-1-base u-btn-4">Admin</a>&nbsp;/<br>2&nbsp;Co​mments
                              </p>
                           </div>
                        </div>
                        <div class="u-container-style u-group u-shape-rectangle u-white u-group-5">
                           <div class="u-container-layout u-valign-middle u-container-layout-7">
                              <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-8 u-text-11"> by&nbsp;<a href="#" class="u-active-none u-border-none u-btn u-button-style u-hover-none u-none u-text-palette-1-base u-btn-5">Admin</a>&nbsp;/<br>2&nbsp;Co​mments
                              </p>
                           </div>
                        </div>
                        <div class="u-container-style u-group u-shape-rectangle u-white u-group-6">
                           <div class="u-container-layout u-container-layout-8">
                              <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-8 u-text-12"> by&nbsp;<a href="#" class="u-active-none u-border-none u-btn u-button-style u-hover-none u-none u-text-palette-1-base u-btn-6">Admin</a>&nbsp;/<br>2&nbsp;Co​mments
                              </p>
                           </div>
                        </div>
                        <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-3 u-text-13"> The Most Common Types of Sewer Line Pipe</p>
                        <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-3 u-text-14"> Why Copper is the Best Plumbing Material?</p>
                        <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-3 u-text-15"> How Does Pipe Leak Tape</p>
                        <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-3 u-text-16"> Repairing or replacing a sewer line on your p<span style="font-weight: 400;"></span>roperty is one of the...
                        </p>
                        <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-3 u-text-17"> Driven by competition and the desire to cut costs, they put people...</p>
                        <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-3 u-text-18"> A clogged sewer line is one of the most common, frustrating, an they put people.... </p>
                     </div>
                  </div>
               </div>
               <a class="u-absolute-vcenter u-carousel-control u-carousel-control-prev u-icon-circle u-radius-10 u-text-custom-color-3 u-carousel-control-1" href="#carousel-1c88" role="button" data-u-slide="prev">
                  <span aria-hidden="true">
                     <svg viewBox="0 0 256 256">
                        <g>
                           <polygon points="207.093,30.187 176.907,0 48.907,128 176.907,256 207.093,225.813 109.28,128"></polygon>
                        </g>
                     </svg>
                  </span>
                  <span class="sr-only">
                     <svg viewBox="0 0 256 256">
                        <g>
                           <polygon points="207.093,30.187 176.907,0 48.907,128 176.907,256 207.093,225.813 109.28,128"></polygon>
                        </g>
                     </svg>
                  </span>
               </a>
               <a class="u-absolute-vcenter u-carousel-control u-carousel-control-next u-icon-circle u-radius-10 u-text-custom-color-3 u-carousel-control-2" href="#carousel-1c88" role="button" data-u-slide="next">
                  <span aria-hidden="true">
                     <svg viewBox="0 0 306 306">
                        <g id="chevron-right">
                           <polygon points="94.35,0 58.65,35.7 175.95,153 58.65,270.3 94.35,306 247.35,153"></polygon>
                        </g>
                     </svg>
                  </span>
                  <span class="sr-only">
                     <svg viewBox="0 0 306 306">
                        <g id="chevron-right">
                           <polygon points="94.35,0 58.65,35.7 175.95,153 58.65,270.3 94.35,306 247.35,153"></polygon>
                        </g>
                     </svg>
                  </span>
               </a>
            </div>
         </div>
      </section>
      <section class="u-clearfix u-white u-section-4" id="sec-6a63">
         <div class="u-clearfix u-sheet u-sheet-1">
            <h3 class="u-custom-font u-font-montserrat u-text u-text-1"> All About AC Repair</h3>
            <div class="u-border-2 u-border-custom-color-6 u-expanded-width u-shape u-shape-rectangle u-white u-shape-1"></div>
            <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-3 u-text-2"> Services offered in AC Service and Repair</p>
            <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-3 u-text-3">
               <span style="font-size: 1.125rem;">Installing an AC: Choose this service for AC installation at your place. The professional will ensure that the AC is running properly as gas pressure and performance of the appliance will be checked post AC installation.<span style="font-weight: 400;">
               <span style="font-weight: 700;"></span>
               </span>
               </span>
            </p>
         </div>
      </section>
<!--  start code for edit package popup   -->
<div class="modal fade" id="myModal_package_editvvvv" role="dialog">
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
        <form class="package" action="javascript:void(0)">
                @csrf
                <p style="text-align:center;font-size:30px;margin-bottom: 20px;color:#3896ff;">Edit your package
                </p>
                <div class="alert alert-success print-success-msg-login" style="display:none">
                    <ul></ul>
                </div>
                <div class="alert alert-danger print-danger-msg-login" style="display:none">
                    <ul></ul>
                </div>
                <div class="myModal_package_edit">

               </div>
                <div class="tt-form__btn" style="display:flex;justify-content:center;">

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
<!--  end code for edit package popup -->
      <section class="u-clearfix u-grey-5 u-section-5" id="sec-fbb9">
         <div class="u-clearfix u-sheet u-sheet-1"></div>
      </section>
@endsection

@section('scripts')



@endsection
