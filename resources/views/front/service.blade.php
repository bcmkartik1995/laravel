@extends('layouts.front')

@section('content')
<style>
   .see_cart {
      position: absolute;
      bottom: 8px;
      right: 16px;
      font-size: 18px;
      background-color: #ff7400;
      border-radius: 9px;
      padding: 10px;
   }
      /* .see_cart {
            position: fixed;
            background: #2184cd;
            color: #fff;
            padding: 20px;
            width: 200px;
      } */
      .badge {
         cursor: pointer;
      }
      .wrapper {
         position : relative;
      }
      /* @media screen and (min-width: 768px){
   .CartFooter__container--1AX23 .CartFooter__cartBtn--2iw9Z {
    background-color: #304ffe;
    max-width: 355px;
    height: 48px;
    float: right;
   }
   .CartFooter__container--1AX23 .CartFooter__cartBtn--2iw9Z .CartFooter__cartInfo--1y1-6 .CartFooter__numItemsContainer--1cPsy
      {
         border: 1px solid #fff;
      }
}
*, :after, :before {
      -webkit-box-sizing: border-box;
      -moz-box-sizing: border-box;
      box-sizing: border-box;
   }


   .CartFooter__container--1AX23 .CartFooter__cartBtn--2iw9Z {
      width: 100%;
      height: 48px;
      border-radius: 4px;
      background-color: #212121;
      color: #fff;
      font-size: 16px;
      font-weight: 500;
      display: flex;
      justify-content: space-between;
      align-items: center;
      align-content: center;
   }

   .CartFooter__container--1AX23 .CartFooter__cartBtn--2iw9Z .CartFooter__cartInfo--1y1-6 .CartFooter__numItemsContainer--1cPsy {
      display: inline-block;
      border: 1px solid #fff;
      width: 24px;
      height: 24px;
      text-align: center;
      line-height: 22px;
      border-radius: 2px;
      font-size: 14px;
   }

   *, :after, :before {
      -webkit-box-sizing: border-box;
      -moz-box-sizing: border-box;
      box-sizing: border-box;
   }

   .CartFooter__container--1AX23 .CartFooter__cartBtn--2iw9Z .CartFooter__cartInfo--1y1-6 .CartFooter__priceValContainer--1ABxI {
      display: inline-block;
      line-height: 16px;
      font-size: 16px;
      font-weight: 500;
      padding-left: 16px;
   }

   .CartFooter__container--1AX23 .CartFooter__cartBtn--2iw9Z {
      width: 100%;
      height: 48px;
      border-radius: 4px;
      background-color: #212121;
      color: #fff;
      font-size: 16px;
      font-weight: 500;
      display: flex;
      justify-content: space-between;
      align-items: center;
      align-content: center;
   } */
</style>

<!-- <div class="CartFooter__cartBtn--2iw9Z see_cart">
   <div class="CartFooter__cartInfo--1y1-6">
      <div class="CartFooter__numItemsContainer--1cPsy" id="item_cart">
      </div>
      <div class="CartFooter__priceValContainer--1ABxI">
         <p id="amount_cart"></p>
      </div>
   </div>
   <div class="CartFooter__nextBtn--29SZV">
   </div>
</div> -->
<div class="wrapper">
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
      <a href="#" class="button countinue">Countinue</a>
   </div>
</div>

   <form id="view_cart" class="tt-modal__body modal__size-lg">

   </form>

<div class="container">
      <div class="row">
         <div class="col-12">
            <div class="text">
               <h1><h1><a>{{ $cat['title'] }}</a></h1></h1>
               <h4> </h4>
            </div>
         </div>
         <div class="col-12">
            <div class="btn-group jj" role="group" aria-label="Basic example">
            @foreach($sub_cat as $subcat)
            <a class="btn btn-secondary hh logo-item" href="{{ url('listService/'.$cat['slug'].'/'.$subcat['slug']) }}">{{ $subcat['title'] }}  </a>
            @endforeach
            </div>
         </div>
      </div>
   </div>











<div id="tt-pageContent">
<div class="section-indent"class="popup">
   <div class="container container__fluid-xl" style="padding-bottom: 50px;">
      <div class="blocktitle text-center blocktitle__min-width03">
         <div class="blocktitle__subtitle">money saving</div>
         <div class="blocktitle__title">Plumbing Service Plans</div>
      </div>
      <div class="col-sm-2 col-mg-6 col-lg-12">
      <div class="swiper-grid-layout">
         <div class="swiper-grid-layout02">
            <div class="swiper-container js-align-layout swiper-container-initialized swiper-container-horizontal swiper-container-autoheight" data-carousel="swiper" data-slides-sm="1" data-slides-md="2" data-slides-lg="3" data-slides-xl="3" data-slides-xxl="3" data-autoplay-delay="3500" data-space-between="0">

               <div class="swiper-wrapper" id="swiper-wrapper-89fbd80a3899c28d" aria-live="off" >
                  <div class="swiper-slide swiper-slide-active" role="group" aria-label="1 / 6">
                     @if(!empty($package))
                     @foreach($package as $pack)
                     <div class="promo-price js-align-layout__item">
                        <div class="promo-price__icon icon-701142"><i class="icon-694055"></i></div>
                        <div class="promo-price__title" id="package_id_{{ $pack->id }}">{{ $pack->title }}</div>
                        <ul class="promo-price__list">
                           @foreach($service as $serve)
                           @foreach($packages as $packs)
                           @if($serve->id == $packs->service_id)
                           <li><i class="fas fa-arrow-right"></i>&nbsp;  &nbsp; {{ $serve->title }}</li>
                           @php
                              $service_id[] = $serve->id;
                              $service_title[] = $serve->title;
                              $pricearray[] = $serve->price;
                              $discount_type = $pack->discount_type;
                              $discount_value = $pack->discount_value;
                           @endphp
                           @endif
                           @endforeach
                           @endforeach
                        </ul>
                        <span class="discountvalue{{ $pack->id }}"></span> &nbsp; &nbsp;  <span class="fullvalue{{ $pack->id }}"></span></br>
                        <a href="#popup5" class="badge badge-success" data-id="{{ $pack->id }}"  id="pac_{{ $pack->id }}"  data-title="{{ $pack->title }}">Edit Package</a>
                        <script text="text/javascript">
                              $(document).ready(function(){
                                 var app = @json($pricearray);
                                 var total = 0;
                                 var discount_value = @json($discount_value);
                                 for (var i = 0; i < app.length; i++) {
                                    total += app[i] << 0;
                                 }
                                 $(".fullvalue{{ $pack->id }}").append('<del>' + total + '</del>');
                                 var discount_type = @json($discount_type);
                                 if(discount_type == 1) {
                                    var disc_value = total*discount_value/100;
                                    var new_total = total - disc_value;
                                 } else {
                                    var disc_value = discount_value;
                                    new_total = total - discount_value;
                                 }

                                 $(".discountvalue{{ $pack->id }}").append(new_total.toFixed(2));
                              });
                        </script>
                        <div class="promo-price__price">
                           <input type="submit" name="cart_{{ $pack->id }}" data-package_name = "{{ $pack->title }}" data-id="{{ $pack->id }}" value="Add to cart" class="button package_{{ $pack->id }} package_button">
                           <div class="change_cart_{{ $pack->id }} add-remove" data-id="change_cart_{{ $pack->id }}">
                              <button id="minus_{{ $pack->id }}" height="10px;" width="20px;" data-value="1" class="button"> - </button>
                              <input type="submit" id="value_{{ $pack->id }}" height="10px;" width="20px;"  value="0" class="button">
                              <button id="plus_{{ $pack->id }}" height="10px;" data-package_name = "{{ $pack->title }}" data-id="{{ $pack->id }}" width="20px;" data-value="1" class="button"> + </button>
                           </div>
                        </div>
                        <div class="modal_overlay">
                        </div>
                     </div>
                     @endforeach
                     <script text="text/javascript">
                        $(document).ready(function(){
                           $("#view_cart").hide();
                        $('#myModal').hide();
                           $(".badge").on("click", function(){
                              var package_id = $(this).attr("data-id");
                              var title = $(this).attr("data-title");
                              $(".title").append(title);
                              $.ajax({
                                 header:{
                                       'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                                 },
                                 url : '{{ url("/view_package") }}',
                                 type : "post",
                                 data : {
                                    "_token": "{{ csrf_token() }}",
                                    "package_id": package_id
                                 },
                              success : function(data) {
                                 var html = '';
                                 var arr = '';
                                 $(".mypackagedata").text('');
                                    jQuery.each(data, function(index, itemData) {
                                       arr[itemData.id];
                                       html += `<div class="service_title">`+ itemData.title +`</div></hr>
                                       <div class="oreal">
                                          <input type="checkbox" class="check_class`+package_id+`" id=`+ itemData.id + ` data-price=`+itemData.price+` name="edit_package_name[]" value=`+itemData.price  + ` checked>
                                          ₹` + itemData.price + `
                                       </div>`;
                                    });
                                    $(".mypackagedata").append(html);
                                    //$(".mypackagedata").append('<button class="button" type="submit" name="edit_pack" id="edit_pack"'+package_id+'>Appy Now</button>');
                                    html = '';
                                   var full_value = $(".fullvalue"+package_id).children('del').text();
                                   var discount_value = parseFloat($(".discountvalue"+package_id).text());
                                   $(".check_class"+package_id).on("click", function(){
                                    if($(this).prop("checked") == true){
                                          var this_class_value = parseFloat($(this).attr("data-price"));
                                          var after_add_this_value = parseFloat(full_value) + parseFloat(this_class_value);
                                          if($('.check_class'+package_id+' :checkbox:not(:checked)').length == 0) {
                                             $(".discountvalue"+package_id).text(parseFloat(discount_value));
                                             $(".fullvalue"+package_id).show();
                                          } else {
                                             $(".discountvalue"+package_id).text(parseFloat(after_add_this_value));
                                             $(".fullvalue"+package_id).hide();
                                          }
                                       }
                                       else if($(this).prop("checked") == false){
                                          var this_class_value = parseFloat($(this).attr("data-price"));
                                          var after_remove_this_value = parseFloat(full_value) - parseFloat(this_class_value);
                                          $(".discountvalue"+package_id).text(parseFloat(after_remove_this_value));
                                          $(".fullvalue"+package_id).hide();
                                       }
                                   });
                              }
                           });
                              //return false;
                           });
                           $(".see_cart").hide();
                           $(".add-remove").hide();
                           $(".package_button").on("click", function(){
                              var package_id = $(this).attr("data-id");
                              var package_name = $(this).attr("data-package_name");
                              var package_value = parseFloat($(".discountvalue"+package_id).text());
                              var total_this_item = 1;
                             // $(".view_cart").append('<span>' + list_item +'</span>');
                              $(".package_" + package_id).hide();
                              $("#value_"+package_id).val(1);
                              $(".change_cart_"+package_id).show();
                              $(".see_cart").show();
                              var check_item = parseFloat($("#item_cart").text());
                              var package_cart_id = 1;
                              $("#view_cart").append("<div class='form-group form_package"+ package_id +"'>"+ "<label>"+ package_name +"</label>"  + "<input type='number' name='package_name[]' data-price="+package_value+" data-total="+ total_this_item +" class='form-cotrol' id = 'form_package_value"+package_cart_id+"' value='"+package_id+"' readonly >" + "</div>");
                              if(parseFloat($("#item_cart").text()) == 0){
                                 $("#item_cart").text(1);
                                 $("#amount_cart").text($(".discountvalue"+package_id).text());
                              } else {
                                 var sum_for_item_cart = $("#item_cart").text();
                                 var sum_for_item_cart_final = parseInt(sum_for_item_cart) + 1;
                                 $("#item_cart").text(sum_for_item_cart_final);
                                 var amount = $(".discountvalue"+package_id).text();
                                 var sum_for_amount_cart = parseFloat($("#amount_cart").text());
                                 var sum_for_amount_cart_final = parseFloat(sum_for_amount_cart) + parseFloat(amount);
                                 $("#amount_cart").text(sum_for_amount_cart_final);
                              }

                                 $("#plus_"+package_id).on("click", function(){
                                      package_cart_id++;
                                    $("#view_cart").append("<div class='form-group form_package"+ package_id +"'>"+ "<label>"+ package_name +"</label>"  + "<input type='number' name='package_name[]' data-price="+package_value+" data-total="+ total_this_item +" class='form-cotrol' id = 'form_package_value"+package_cart_id+"' value='"+package_id+"' readonly >" + "</div>");
                                    var form_package_value = parseFloat($("#form_package_value"+package_id).val());
                                    var after_add_package_value = form_package_value + package_value;
                                    var list_this_item = parseFloat($("#form_package_value"+package_id).attr('data-total'));
                                    $("#form_package_value"+package_id).attr('data-total', list_this_item+1);
                                    var form_defalut_value = parseFloat($(package_name).val());
                                    var default_value = parseFloat($("#value_"+package_id).val());
                                    $(package_name).val(form_defalut_value + default_value);
                                    var amount = parseFloat($(".discountvalue"+package_id).text());
                                    var default_amount = parseFloat($("#amount_cart").text());
                                    var after_add_amount = default_amount + amount;
                                    var after_add_value = parseFloat(default_value) + 1;
                                    $("#value_"+package_id).val(after_add_value);
                                    $(".see_cart").show();
                                    var default_cart_item = parseFloat($("#item_cart").text());
                                    var after_add_cart = default_cart_item + 1;
                                    $("#item_cart").text(after_add_cart);
                                    $("#amount_cart").text(after_add_amount.toFixed(2));
                                    var data = sum_of + 1;
                                 });
                                 $("#minus_"+package_id).on("click", function(e){
                                    $("#form_package_value"+package_cart_id).parent().remove();
                                    package_cart_id--;
                                    var form_package_value = parseFloat($("#form_package_value"+package_id).val());
                                    var after_remove_package_value = parseFloat(form_package_value) - parseFloat(package_value);
                                   // $("#form_package_value"+package_id).attr('value', after_remove_package_value.toFixed(2));
                                    var list_this_item = parseFloat($("#form_package_value"+package_id).attr('data-total'));
                                    $("#form_package_value"+package_id).attr('data-total', list_this_item-1);
                                    var default_value = parseFloat($("#value_"+package_id).val());
                                    var default_amout = parseFloat($("#amount_cart").text());
                                    var amount = parseFloat($(".discountvalue"+package_id).text());
                                    var after_sub_amount = parseFloat(default_amout) - parseFloat(amount);
                                    if(default_value == 1) {
                                       $(".form_package"+package_id).remove();
                                       $("#value_"+package_id).val('0');
                                       $(".change_cart_"+package_id).hide();
                                       $(".package_"+package_id).show();
                                       var after_sub = parseFloat(default_value) - 1;
                                       $("#value_"+package_id).val(after_sub);
                                       var default_cart_value = parseFloat($("#item_cart").text());
                                       var after_sub_cart_value = parseFloat(default_cart_value) - 1;
                                       $("#item_cart").text(after_sub_cart_value);
                                       $("#amount_cart").text(after_sub_amount.toFixed(2));
                                       if($("#item_cart").text() == 0) {
                                          $(".see_cart").hide();
                                       }
                                       var default_cart_value = parseFloat($("#item_cart").text());
                                       if(default_cart_value == 1) {
                                          $("#item_cart").text(0);
                                          $("#amount_cart").text(0)
                                          $(".see_cart").hide();
                                       }
                                    } else {
                                       var after_sub = parseFloat(default_value) - 1;
                                       $("#value_"+package_id).val(after_sub);
                                       var default_cart_value = parseFloat($("#item_cart").text());
                                       var after_sub_cart_value = parseFloat(default_cart_value) - 1;
                                       $("#item_cart").text(after_sub_cart_value);
                                       $("#amount_cart").text(after_sub_amount.toFixed(2));
                                    }
                                    var data = sum_of + 1;
                                 });
                           });
                        });

                     </script>
                     @endif
                  </div>
                  @foreach($serve_no_package as $serve)
                  <div class="swiper-slide swiper-slide-next" role="group" aria-label="2 / 6" >
                     <div class="promo-price js-align-layout__item" >
                        <div class="promo-price__icon icon-857333"><i class="icon-694055"></i></div>
                        <div class="promo-price__title">{{ $serve->title }}</div>
                        <ul class="promo-price__list">
                           <li><i class="fas fa-arrow-right"></i> &nbsp; &nbsp; {{ $serve->description }}</li>
                           <li><i class="fas fa-arrow-right"></i>&nbsp; &nbsp; {{ $serve->long_description }}</li>
                           <li><i class="fas fa-arrow-right"></i>&nbsp; &nbsp; {{ $serve->price }}</li>
                        </ul>
                        <div class="promo-price__price">
                           <input type="submit" name="cart_{{ $serve->id }}" data-service="{{ $serve->title }}" data-id="{{ $serve->id }}" data-price="{{ $serve->price }}" value="Add to cart" class="button service_{{ $serve->id }} service_button">
                           <div class="change_cart_{{ $serve->id }} add-remove" id="change_cart_{{ $serve->id }}">
                              <button id="minus_service{{ $serve->id }}" height="10px;" width="20px;" class="button"> - </button>
                              <input type="submit" id="value_service{{ $serve->id }}" height="10px;" width="20px;" value="0" class="button">
                              <button id="plus_service{{ $serve->id }}" height="10px;" width="20px;" class="button"> + </button>
                           </div>
                        </div>
                           <div class="modal_overlay">
                        </div>
                     </div>
                  </div>
                  @endforeach
               </div>

               <script text="text/javascript">
               $(document).ready(function(){
                  $(".see_cart").hide();
                  $(".add-remove").hide();
                  $(".service_button").on("click", function(){
                     var package_id = $(this).attr("data-id");
                     var package_value = parseFloat($(this).attr("data-price"));
                     var package_name = $(this).attr("data-service");
                     var total_this_item = 1;
                     $(".service_" + package_id).hide();
                     $("#value_service"+package_id).val(1);
                     $(".change_cart_"+package_id).show();
                     $(".see_cart").show();
                     var amount = $(this).attr("data-price");
                     var check_item = parseFloat($("#item_cart").text());
                     var package_cart_id = 1;
                     $("#view_cart").append("<div class='form-group form_service"+ package_id +"'>"+ "<label>"+ package_name +"</label>"  + "<input type='number' name='service_name[]' data-price="+package_value+" data-total="+ total_this_item +" id = 'form_service_value"+package_cart_id+"' class='form-cotrol'  value='"+package_id+"' readonly >" + "</div>");
                     if(parseFloat($("#item_cart").text()) == 0){
                        $("#item_cart").text(1);
                        $("#amount_cart").text(amount);
                     } else {
                        var sum_for_item_cart = $("#item_cart").text();
                        var sum_for_item_cart_final = parseInt(sum_for_item_cart) + 1;
                        $("#item_cart").text(sum_for_item_cart_final);
                        var sum_for_amount_cart = parseFloat($("#amount_cart").text());
                        var sum_for_amount_cart_final = parseFloat(sum_for_amount_cart) + parseFloat(amount);
                        $("#amount_cart").text(sum_for_amount_cart_final);
                     }


                        $("#plus_service"+package_id).on("click", function(){
                           package_cart_id++;
                           var form_package_value = parseFloat($("#form_service_value"+package_id).val());
                           var after_add_package_value = form_package_value + package_value;
                           $("#view_cart").append("<div class='form-group form_service"+ package_id +"'>"+ "<label>"+ package_name +"</label>"  + "<input type='number' name='service_name[]' data-price="+package_value+" data-total="+ total_this_item +" id = 'form_service_value"+package_cart_id+"' class='form-cotrol'  value='"+package_id+"' readonly >" + "</div>");
                           //$("#form_service_value"+package_id).attr('value',after_add_package_value.toFixed(2));
                           //var list_this_item = parseFloat($("#form_service_value"+package_id).attr('data-total'));
                           //$("#form_service_value"+package_id).attr('data-total', list_this_item+1);
                           var default_value = parseFloat($("#value_service"+package_id).val());
                           $("#plus_service"+package_id).attr("data-amount",amount);
                           var new_amount = $(this).attr("data-amount");
                           var default_amount =  parseFloat($("#amount_cart").text());
                           var after_add_amount = parseFloat(default_amount) + parseFloat(new_amount);
                           var after_add_value = default_value + 1;
                           $("#value_service"+package_id).val(after_add_value);
                           $(".see_cart").show();
                           var default_cart_item = parseFloat($("#item_cart").text());
                           var after_add_cart = default_cart_item + 1;
                           $("#item_cart").text(after_add_cart);
                           $("#amount_cart").text(after_add_amount);
                           var data = sum_of + 1;
                        });
                        $("#minus_service"+package_id).on("click", function(e){
                           e.preventDefault();
                           $("#form_service_value"+package_cart_id).parent().remove();
                           package_cart_id--;
                           var form_package_value = parseFloat($("#form_service_value"+package_id).val());
                           var after_remove_package_value = parseFloat(form_package_value) - parseFloat(package_value);
                           //$("#form_service_value"+package_id).attr('value', after_remove_package_value.toFixed(2));
                           var list_this_item = parseFloat($("#form_service_value"+package_id).attr('data-total'));
                           $("#form_service_value"+package_id).attr('data-total', list_this_item-1);

                           var default_value = parseFloat($("#value_service"+package_id).val());
                           var default_amout = parseFloat($("#amount_cart").text());
                           var after_sub_amount = default_amout - parseFloat(amount);
                           if(default_value == 1) {
                              $(".form_service"+package_id).remove();
                              $("#value_service"+package_id).val(0);
                              $(".change_cart_"+package_id).hide();
                              $(".service_"+package_id).show();
                              var default_cart_value = parseFloat($("#item_cart").text());
                              var after_sub = parseFloat(default_value) - 1;
                              $("#value_service"+package_id).val(after_sub);
                              var default_cart_value = parseFloat($("#item_cart").text());
                              var after_sub_cart_value = parseFloat(default_cart_value) - 1;
                              $("#item_cart").text(after_sub_cart_value);
                              $("#amount_cart").text(after_sub_amount.toFixed(2));
                              if($("#item_cart").text() == 0) {
                                 $(".see_cart").hide();
                                 $("#view_cart").text('');
                                 $("#view_cart").hide();
                              }
                              if(default_cart_value == 1) {
                                 $("#item_cart").text(0);
                                 $("#amount_cart").text(0)
                                 $(".see_cart").hide();
                              }
                           } else {
                              var after_sub = parseFloat(default_value) - 1;
                              $("#value_service"+package_id).val(after_sub);
                              var default_cart_value = parseFloat($("#item_cart").text());
                              var after_sub_cart_value = parseFloat(default_cart_value) - 1;
                              $("#item_cart").text(after_sub_cart_value);
                              $("#amount_cart").text(after_sub_amount.toFixed(2));
                           }
                           var data = sub_of + 1;
                        });
                  });
               });

               </script>
               <div class="swiper-pagination swiper-pagination__center swiper-pagination__align02 swiper-pagination-clickable swiper-pagination-bullets"><span class="swiper-pagination-bullet swiper-pagination-bullet-active" tabindex="0" role="button" aria-label="Go to slide 1"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 2"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 3"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 4"></span></div>
               <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
            </div>
         </div>
      </div>
   </div>
   </div>
</div>
</div>
</div>

<!-- ------dailog-1---------- -->

<div class="defin">
   <div id="popup1" class="overlay">
      <div class="box-1">
         <a class="close" href="#" style="float: right;font-size: 48px; ">&times;</a>
         <div class="slide_container" style="animation-duration: 0.25s;transition-duration: 0.25s">
            <h2 style="margin-bottom :60px;">AC Service and Repair</h2>
            <div class="statictext">
               <div>
                  <div class="content">Safety Guidelines
                     <img src="{{ asset('front/images/16.png') }}" style="width: 78%;">
                  </div>
               </div>
               <div style="margin-top: 15px;">
                  <a class="button" href="ac_service_and_repair.html" style="padding: 10px 120px 10px 120px;">Next</a>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- -----------dailog-2-------!-->

<div class="defin">
<div id="popup2" class="overlay">
   <div class="box-1">
   <a class="fas fa-chevron-left" href="#" style="float: left;font-size: 48px; ">&times;</a>
   <a class="close" href="#" style="float: right;font-size: 48px; ">&times;</a>
    <div class="slide_container" style="animation-duration: 0.25s;transition-duration: 0.25s">
   <h2 style="margin-bottom :60px;">AC Service and Repair</h2>
   <div class="statictext">
   <div>
   <div class="content" style="text-align: left;">
      <h6>Split AC service</h6>
      <p style="font-size:12px; margin: 0px;">Offer is valid on same booking and same place</p>
      <p style="font-size:12px; margin:0px;">Our Powerjet AC Servicing ensures 2X faster cooling.</p>
      <span style="font-size:15px;">₹599</span>
      <span style="font-size:15px;">₹699</span>
   </div>

   <h5 style="float:left;margin-top:32px;">Frequently added together</h5>

   <div style="float:left";>
   <img src="{{ asset('front/images/imgbox-inner__img01.webp') }}" style="width: 32%;margin-bottom: 40px;">
   <img src="{{ asset('front/images/imgbox-inner__img01.webp') }}" style="width: 32%;margin-bottom: 40px;">
   <img src="{{ asset('front/images/imgbox-inner__img01.webp') }}" style="width: 32%;margin-bottom: 40px;">
   </div>
   </div>

   <div style="height: 5px; background-color: rgb(245, 245, 245) ; padding: 9px;"></div>


   <div class="content" style="text-align: left;">
   <p style="font-size:20px;">Offers, promo code and gift cards
     <a href="promo_code.html"><img src="{{ asset('front/images/back.png') }}" style="width: 1.5%;float:right; margin-right: 10px;"></a>
   </p>
   <p style="margin-top: 0;font-size:15px;">3 offers available</p>
   <div style="height: 5px; background-color: rgb(245, 245, 245) ; padding: 9px;"></div>
   </div>

   <p style="margin-top: 0;font-size:15px;text-align: left;background-color:rgb(30 136 255);padding:15px;color:#ffffff;">Congratulations! you saved an additional ₹250 on this booking</p>
   <div style="height: 5px; background-color: rgb(245, 245, 245) ; padding: 9px;"></div>

   <div style="text-align: left;">Item total</div>
   <div style="text-align: right;">₹3,146</div>
   <div style="text-align: left;">Safety & Partner Welfare Fees</div>
   <div style="text-align: right;">₹3,146</div>
   <img src="{{ asset('front/images/1619510980301-e7891f.png') }}">


   <h3>Become a UC Plus member and get</h3>
   <p style="font-size:12px;margin:0;">10% off on Salon & Men's Haircut
   ₹100 off on Appliance Repair & Cleaning services
   ₹50 off on Home Repair services</p>



   </div>
   </div>

     <div style="margin-top: 23px;">
     <a class="button" href="#" style="padding: 10px 80px 10px 80px; color:#1e60aa;border-color:#1e60aa;background-color: #ffffff;margin-top: ">No, I will pay ₹648</a>
     <a class="button" href="#" style="padding: 10px 120px 10px 120px;">Next</a>
     </div>


   </div>
   </div>
   </div>
   </div>
   <div class="defin">
            <div id="popup5" class="overlay">
               <div class="box-0">
                  <a class="close" href="#" style="float: right;font-size: 48px;margin-top: -35px; ">&times;</a>
                  <div class="slide_container" style="animation-duration: 0.25s;transition-duration: 0.25s">
                     <h2 style="margin-bottom :60px;" class="title"></h2>
                     <div class="statictext">
                        <div class="mypackagedata">
                           <!--div class="service_title"></div></hr>
                              <div class="oreal">
                                 <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                 I don’t want any
                                 <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                 L'Oreal Matrix
                              </div>
                              <div class="cart0">
                                 <a class="button0" href="ac_service_and_repair.html">$199 Add To Cart</a>
                              </div-->
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
      </div>
   </div>
   </div>
   </div>
   <script>
      $(document).ready(function(){
         $(".countinue").on("click", function(){
           var form = $("#view_cart");
           form.serialize();
           var mydata = form.serialize();
           //alert(mydata);
           $.ajax({
              url : '/add_cart_detail',
              type: 'post',
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              data : form.serialize(),
              success : function(data) {
               console.log(data)
              }
           });
         });
      });
   </script>
<!---------dailog-4---------->


<div>

@endsection

@section('scripts')



@endsection
