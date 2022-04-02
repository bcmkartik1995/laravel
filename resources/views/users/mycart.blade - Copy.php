@extends('layouts.front')
<!-- <script class="u-script" type="text/javascript" src="{{ asset('front/js/nicepage.js')}}" defer=""></script>
  <script class="u-script" type="text/javascript" src="{{ asset('front/js/jquery.js')}}" defer=""></script>
<link rel="stylesheet" href="{{ asset('front/css/bootstrap.min.css')}}"> -->
<link rel="stylesheet" href="{{ asset('front/css/mycart.css')}}">
@section('content')
<!-- start code for cart data -->
<section class="u-clearfix u-valign-middle-lg u-valign-middle-sm u-valign-middle-xl u-valign-middle-xs u-section-1" id="sec-5130">
    <img src="{{ asset('front/images/Screenshot_16.png') }}" alt="" class="u-expanded-height-xl u-image u-image-default u-image-1" data-image-width="1009" data-image-height="294">
    <img src="{{ asset('front/images/mainslide-01__bg5.webp') }}" alt="" class="u-expanded-width u-image u-image-default u-image-2" data-image-width="1840" data-image-height="749">
    <p class="u-custom-font u-font-montserrat u-text u-text-white u-text-1">Cart</p>
    <p class="u-custom-font u-font-montserrat u-text u-text-white u-text-2"></p>
</section>
@if(empty($my_cart_data['packages']) && empty($my_cart_data['services']))
    <section class="u-clearfix u-section-2" id="sec-2a99">
        <div class="u-clearfix u-sheet u-sheet-1">
            <p class="u-align-left-lg u-align-left-md u-align-left-sm u-align-left-xl u-custom-font u-font-montserrat u-text u-text-1">Cart is empty</p>
        </div>
    </section>
@else

    <section class="u-clearfix u-section-2" id="sec-2a99">
        <div class="u-clearfix u-sheet u-sheet-1">
        <?php
        $sub_total = 0;
        ?>
        @if(!empty($my_cart_data['packages']))
            @foreach($my_cart_data['packages'] as $package)
            <?php
            $sub_total += $package['price'];
            ?>
            <p class="u-align-left-lg u-align-left-md u-align-left-sm u-align-left-xl u-custom-font u-font-montserrat u-text u-text-1">{{$package['title']}}</p>
            <p class="u-custom-font u-font-montserrat u-text u-text-2">{{$package['description']}}</p>
            <a href="#" class="u-btn u-button-style u-custom-color-2 u-custom-font u-font-montserrat u-hover-custom-color-2 u-btn-1 hidden">Add to cart</a>
            <p class="u-custom-font u-font-montserrat u-text u-text-3"><span>₹{{$package['price']}}</span> <del>₹{{$package['original_price']}}</del> <span>(Qty. {{$package['quantity']}})</span></p>
            @endforeach
        @endif

        @if(!empty($my_cart_data['services']))
            @foreach($my_cart_data['services'] as $service)
            <?php
            $sub_total += $service['price'];
            ?>
            <p class="u-align-left-lg u-align-left-md u-align-left-sm u-align-left-xl u-custom-font u-font-montserrat u-text u-text-1">{{$service['title']}}</p>
            <p class="u-custom-font u-font-montserrat u-text u-text-2">{{$service['description']}}</p>
            <a href="#" class="u-btn u-button-style u-custom-color-2 u-custom-font u-font-montserrat u-hover-custom-color-2 u-btn-1 hidden">Add to cart</a>
            <p class="u-custom-font u-font-montserrat u-text u-text-3"><span>₹{{$service['price']}}</span> <span>(Qty. {{$service['quantity']}})</span></p>
            @endforeach
        @endif

        <!-- <p class="u-align-left-xl u-custom-font u-font-montserrat u-text u-text-4">Offer is valid on same booking and same place</p>
        <p class="u-align-left-lg u-align-left-md u-align-left-xl u-text u-text-5"> Our Powerjet AC Servicing ensures 2X faster cooling. </p>
        <a href="#" class="u-btn u-button-style u-custom-color-2 u-custom-font u-font-montserrat u-hover-custom-color-2 u-btn-2">Add to cart</a>
        <p class="u-align-left-xl u-custom-font u-font-montserrat u-text u-text-6">₹599</p>
        <p class="u-custom-font u-font-montserrat u-text u-text-default-lg u-text-default-md u-text-default-sm u-text-default-xl u-text-7">Offer is valid on same booking and same place</p>
        <p class="u-custom-font u-font-montserrat u-text u-text-8"> Our Powerjet AC Servicing ensures 2X faster cooling.</p>
        <a href="#" class="u-btn u-button-style u-custom-color-2 u-custom-font u-font-montserrat u-hover-custom-color-2 u-btn-3">Add to cart</a>
        <p class="u-custom-font u-font-montserrat u-text u-text-9">₹599</p> -->
        </div>
    </section>
    <section class="u-clearfix u-valign-middle-xs u-section-3" id="sec-f78d">
        <div class="u-absolute-hcenter u-align-left u-expanded u-grey-5 u-left-0 u-shape u-shape-rectangle u-shape-1"></div>
        <div class="u-clearfix u-layout-wrap u-layout-wrap-1">
        <div class="u-layout">
            <div class="u-layout-row min-high-unset">
                <div class="u-align-left u-container-style u-layout-cell u-left-cell u-size-43 u-layout-cell-1">
                    <div class="u-container-layout u-container-layout-1">
                    <h3 class="u-custom-font u-font-montserrat u-text u-text-1">Offer, promo code and gift cards</h3>
                    <p class="u-text u-text-2">{{count($offers)}} Offers available</p>
                    <div class="u-border-2 u-border-grey-75 u-preserve-proportions u-shape u-shape-circle u-shape-2"></div>
                    <p class="u-custom-font u-font-montserrat u-text u-text-3">%</p>
                    </div>
                </div>
                <div class="u-align-left u-container-style u-layout-cell u-right-cell u-size-17 u-layout-cell-2">
                    <div class="u-container-layout u-valign-middle-lg u-valign-middle-md u-valign-middle-sm u-valign-middle-xl u-container-layout-2">
                    <a href="#" data-toggle="modal" data-target="#offer-modal" class="u-btn u-button-style u-custom-color-2 u-btn-1">View Offers</a>

                </div>
            </div>
        </div>
        </div>
    </section>
    <section class="u-clearfix u-section-4" id="sec-684f">
        <div class="u-expanded-width u-palette-3-light-3 u-shape u-shape-rectangle u-shape-1"></div>
        <p class="u-align-left-lg u-align-left-md u-align-left-sm u-align-left-xl u-custom-font u-font-montserrat u-text u-text-1 hidden offer-appliend-message"></p>
        <p class="u-align-left u-custom-font u-font-montserrat u-text u-text-2">Sub total</p>
        <p class="u-custom-font u-font-montserrat u-text u-text-3">₹{{number_format($sub_total,2)}}</p>
        <div class="discount-div">

        </div>
        <p class="u-custom-font u-font-montserrat u-text u-text-4">Total</p>
        <p class="u-custom-font u-font-montserrat u-text u-text-5" >₹<span class="order-total" data-value="{{$sub_total}}" data-original-value="{{$sub_total}}">{{number_format($sub_total,2)}}</span></p>

        <a href="javascript:void(0);" class="u-align-center u-btn u-button-style u-custom-color-2 u-custom-font u-font-montserrat u-text-body-alt-color u-text-hover-white u-btn-1" id="btn-pay">Pay ₹ <span class="order-total-pay">{{number_format($sub_total,2)}}</span></a>
    </section>
    <div class="modal fade" id="offer-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <div class="offers-div">
                        @if(!empty($offers))
                        <div class="u-expanded-width-xs u-form u-form-1">
                            @include('includes.admin.form-login')
                            <form action="{{ route('user.apply_offer') }}" method="POST" class="" id="offer-form" style="padding: 10px;">
                                <div class="u-form-group u-form-name">
                                <label for="offer_code" class="u-form-control-hidden u-label u-text-custom-color-10 u-label-1"></label>
                                <input type="text" placeholder="Enter coupon code" id="offer_code" name="offer_code" class="u-border-1 u-border-grey-30 u-custom-font u-font-montserrat u-input u-input-rectangle u-white" required="" autocomplete="off">
                                @error('offer_code')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                                <div class="u-align-left u-form-group u-form-submit">

                                <input type="submit" value="Apply" class="u-border-none u-btn u-btn-submit u-button-style u-custom-color-1 u-custom-font u-font-montserrat u-btn-1 btn-submit" >
                                </div>
                            </form>
                            </div>
                        <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-10 u-text-2">&nbsp; &nbsp;Offers</p>
                            @foreach($offers as $offer)

                            <div class="u-container-style u-expanded-width-xs u-group u-group-1">
                            <div class="u-container-layout u-container-layout-1">
                                <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-10 u-text-3">{{$offer->title}}</p>
                                <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-10 u-text-default u-text-4">
                                    {{$offer->offer_type == 0 ? 'Flat '.$offer->offer_value : $offer->offer_value.'%'}} off | Use code: {{$offer->offer_code}}
                                </p>
                                <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-10 u-text-default u-text-5">Get cashback up to&nbsp;₹{{$offer->max_value}} </p>
                                <!-- <a href="https://nicepage.com/k/flask-html-templates" class="u-border-none u-btn u-button-style u-custom-color-1 u-custom-font u-font-montserrat u-hover-custom-color-1 u-btn-2">view T&amp;C</a> -->
                                <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-10 u-text-default u-text-6">{{$offer->description}}</p>
                            </div>
                            </div>
                            @endforeach
                        @else
                        <h5>No any offer available.</h5>
                        @endif
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
        </div>
    </div>
@endif
<!-- end code for cart data -->
@endsection

@section('scripts')

<script>
var offer = null;
function apply_offer(offer_data){
    console.log(offer_data)
    if(offer_data){
        message = "Congratulations! you saved an additional ₹"+offer_data.discount+" on this booking";
        $('.offer-appliend-message').html(message).removeClass('hidden');

        discount_div = '<p class="u-custom-font u-font-montserrat u-text u-text-4">Discount</p>'+
                        '<p class="u-custom-font u-font-montserrat u-text u-text-5 order-discount">'+offer_data.discount+'</p>';
        $('.discount-div').html(discount_div);


        $('.order-total').attr('data-value', offer_data.new_price).html(offer_data.new_price);
        $('.order-total-pay').html(offer_data.new_price);
    }else{
        $('.offer-appliend-message').html('').addClass('hidden');
        $('.discount-div').html('');

        original_value = $('.order-total').attr('data-original-value');
        $('.order-total').attr('data-value', original_value).html(original_value);
        $('.order-total-pay').html(original_value);
    }

}

$('#btn-pay').click(function(){
    origional_price = $('.order-total').data('original-value');
    final_total = $('.order-total').data('value');
    hasOffer = false;
    discount = 0;
    offer_code = null;
    if(offer){
        hasOffer = true;
        discount = offer.discount;
        offer_code = offer.offer_code;
    }

    data = {
        'origional_price' : origional_price,
        'final_total' : final_total,
        'hasOffer' : hasOffer,
        'discount' : discount,
        'offer_code' : offer_code,
    }
    $.ajax({
        header:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        },
        url: "{{ route('user.add_final_price') }}",
        type : "post",
        dataType:'json',
        data : {
            "_token": "{{ csrf_token() }}",
            "data": data
        },
        success : function(data) {
            $('#offer-form .btn-submit').prop('disabled', false);
            if(data.success){
                window.location.href = "{{ url('/address') }}";
            }else{
               //error message
            }
        }
    });
    return false;

});

$('#offer-form').submit(function(e){
    var $this = $(this).parent();
    offer_code = $('#offer_code').val();
    $('#offer-form .btn-submit').prop('disabled', true);
    e.preventDefault();
    $.ajax({
        header:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        },
        url: $(this).prop('action'),
        type : "post",
        dataType:'json',
        data : {
            "_token": "{{ csrf_token() }}",
            "offer_code": offer_code
        },
        success : function(data) {
            $('#offer-form .btn-submit').prop('disabled', false);
            if(data.success){
                $this.find('.alert-info').hide();
                $this.find('.alert-danger').hide();
                $this.find('.alert-success').show();
                $this.find('.alert-success p').html(data.message);
                offer = data.offer_data;
                apply_offer(data.offer_data);
                $('#offer-modal .close').trigger('click');
            }else{
                $this.find('.alert-success').hide();
                $this.find('.alert-info').hide();
                $this.find('.alert-danger').show();
                $this.find('.alert-danger ul').html('');
                $(' .alert-danger p').html(data.message);
                offer = null;
                apply_offer();
            }
        }
    });
    return false;
});
</script>

@endsection
