@extends('layouts.front')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/front-assets/css/plugin/sweetalert/sweetalert2.min.css') }}" media="screen">
@endsection

@section('content')

@php
    use Carbon\Carbon;
@endphp

<div class="cart-section mt-4 mb-4">
    <div class="container">
        <div class="row">
            <div class="d-flex justify-content-center w-100 mb-3">
                <h2 class="my-tst mb-0 title-contain mt-3">My cart</h2>
            </div>
        </div>

        @if(empty($my_cart_data['packages']) && empty($my_cart_data['services']))
            <div class="row ">
                <div class="col-md-12">
                    <div class="p-2">
                        <h5>Cart is empty</h5>
                    </div>
                </div>
            </div>
        @else


            @php
                $sub_total = 0;
            @endphp
            <div class="row ">
                <div class="col-md-9">
                    <table class="table table-bordered cart-table">
                        @if(!empty($my_cart_data['services']))
                            @foreach($my_cart_data['services'] as $service)
                                @php
                                    $sub_total += $service['price'];
                                @endphp

                                <tr>
                                    <td>
                                        <div class="cc-img">
                                            <img width="100px" class="rounded" src="{{asset('assets/images/servicebanner/'.$service['banner'])}}" >
                                        </div>
                                    </td>
                                    <td>
                                        <div class="product-details  "><span class="font-weight-bold  pr-dts">{{$service['title']}}</span>
                                            <div class="d-flex flex-row product-desc">
                                                <div class="size mr-1  ds-det">{!!Str::limit($service['description'] ,250,' ...') !!}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-row align-items-center qty">
                                        <p class="mb-0">(Qty. {{$service['quantity']}})</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <p class="mb-0">₹{{$service['price']}}</p>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                    <a href="javascript:void(0);" class="btn-remove-cart" data-id="{{$service['id']}}" data-type="service" data-url="{{ route('remove_item_from_cart') }}"><i class="fa fa-trash mb-1 text-danger"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                        @if(!empty($my_cart_data['packages']))
                            @foreach($my_cart_data['packages'] as $package)
                                @php
                                    $sub_total += $package['price'];
                                @endphp

                                <tr>
                                    <td>
                                        <div class="cc-img">
                                            <img width="100px" class="rounded" src="{{asset('assets/images/packagebanner/'.$package['banner'])}}" >
                                        </div>
                                    </td>
                                    <td>
                                        <div class="product-details  "><span class="font-weight-bold  pr-dts">{{$package['title']}}</span>
                                            <div class="d-flex flex-row product-desc">
                                                <div class="size mr-1  ds-det">{!!Str::limit($package['description'] ,250,' ...') !!}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-row align-items-center qty">
                                        <p class="mb-0">(Qty. {{$package['quantity']}})</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <p class="mb-0"><span>₹{{$package['price']}}</span> <del>₹{{$package['original_price']}}</del></p>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                    <a href="javascript:void(0);" class="btn-remove-cart" data-id="{{$package['id']}}" data-type="package" data-url="{{ route('remove_item_from_cart') }}"><i class="fa fa-trash mb-1 text-danger"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </table>
                </div>
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-bordered">
                                <tr>
                                    <td>
                                        <p class="sub-total mb-0 font-weight-normal">Sub Total</p>
                                    </td>
                                    <td>
                                        <p class="sub-total mb-0 font-weight-normal sub-total-value" data-price="{{$sub_total}}">₹{{number_format($sub_total,2,'.','')}}</p>
                                    </td>

                                </tr>
                                <tr>
                                    <td>
                                        <p class="discount-title sub-total mb-0 font-weight-normal">Discount</p>
                                    </td>
                                    <td>
                                        <p class="discount-value sub-total mb-0 font-weight-normal">₹0</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="sub-total mb-0">Total</p>
                                    </td>
                                    <td>
                                        <p class="sub-total mb-0">₹<span class="order-total" data-value="{{$sub_total}}" data-original-value="{{$sub_total}}">{{number_format($sub_total,2,'.','')}}</span></p>
                                    </td>
                                </tr>
                            </table>

                        </div>
                    </div>

                    <div class="row text-center pr-btn justify-content-center">
                        <div class="col-12">
                            <div class="btn-pay">
                                <a class="btn-sub-pay d-block" id="btn-pay" href="javascript:void(0);">Proceed to Pay</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@if(!empty($my_cart_data['packages']) || !empty($my_cart_data['services']))

<!-- Offer Section Start -->
<div class="container-fluid  bg-25 offer-popup">
    <div class="container">
        <div class="row offer-sec align-items-center">

            <div class="col-lg-1 col-md-1 col-sm-1 col-1 pl-0">
                <div class="per-img">
                    <img src="{{asset('assets/front-assets/images/per2.jpg')}}">
                </div>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-8 col-10 off-ts">
                <h3 class="ff-texts">Offer, promo code and gift cards</h3>
                <p class="offer-code">{{count($offers)}} Offers available</p>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-3 ts-views text-right pr-0">
                <div class="btn-view">
                    <a class="btn-sub-app" href="" data-toggle="modal" data-target="#view-offer">View Offers</a>
                </div>
            </div>

        </div>
    </div>
    <div class="row offer-two  bg-26 hidden offer-appliend-message-div">
        <div class="container">
            <span class=" offer-appliend-message"></span>
        </div>
    </div>
</div>
<!-- Offer Section End -->

<div class="container">


</div>
@endif

<div class="modal fade" id="view-offer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content apply-panal">
            <div class="modal-header border-bottom-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-0">

                <div class="d-flex flex-column text-center">

                    @if(!empty($offers->count()) || !empty($gift_card->count()))
                        <form action="{{ route('user.apply_offer') }}" method="POST" class="" id="offer-form">
                            @include('includes.front.form-login')

                                @if(!empty($offers->count()))
                                    <div class="ofr-text">
                                        <p class="ofr-sub-text text-center mb-3">Offers</p>
                                        <hr>
                                        <div class="d-flex justify-content-between">
                                            <div class="row">
                                                @foreach($offers as $offer)
                                                    <div class="col-lg-6">
                                                        <div class="offer-popup-text">
                                                            <h4>{{$offer->title}}</h4>
                                                            <p class="">
                                                                {{$offer->offer_type == 0 ? 'Flat '.$offer->offer_value : $offer->offer_value.'%'}} off | Use code: {{$offer->offer_code}}
                                                            </p>
                                                            <p class="">Get cashback up to&nbsp;₹{{$offer->max_value}} </p>
                                                            <p class="">{!!Str::limit($offer->description ,200,' ...') !!}</p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group pb-2 pt-2">
                                        <input type="text" class="form-control" placeholder="enter coupon code" id="offer_code" name="offer_code" >
                                    </div>
                                @endif

                                @if(!empty($gift_card))
                                    <div class="ofr-text mt-1">

                                        <p class="ofr-sub-text text-center mb-3">Gifts</p>
                                        <hr>
                                        <div class="justify-content-between">
                                            <div class="row">
                                                @foreach($gift_card as $gift)
                                                    <div class="col-lg-6 pt-3 mt-1">
                                                        <div class="offer-popup-text">
                                                            <h4><input type="radio" name="gift_id" class="checkbox-input gift_id" value="{{$gift->id}}" data-gift-value="{{$gift->gift_value}}"> {{$gift->title}}</h4>
                                                            <br>
                                                            <img src="{{ asset('assets/images/giftsimage') }}/{{ $gift->image }}" alt="" width="200">
                                                            <p class="mt-2">Gift Value &nbsp;₹{{$gift->gift_value}} </p>
                                                            <p class="">Valide From : <br> {{ Carbon::parse($gift->valid_from)->format('d-m-Y') }} To {{ Carbon::parse($gift->valid_to)->format('d-m-Y') }} </p>
                                                            <p class="">{!!Str::limit($gift->description ,200,' ...') !!}</p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            <button type="submit"  class="btn-block apl-btn apl-sub-btn d-block btn-submit" >Apply</button>


                        </form>
                    @else
                    <h5>No any offer available.</h5>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('assets/front-assets/js/plugin/sweetalert/sweetalert2.all.min.js') }}"></script>
<script>


var offer = gift_data = all_discount = null;
function apply_offer(offer_data, gift_data){

    if(offer_data || gift_data){


        price = parseFloat($('.sub-total-value').attr('data-price'));
        new_price = price;

        discount = 0;
        if(offer_data){
            discount += parseFloat(offer_data.discount);
            new_price = parseFloat(offer_data.new_price);
        }
        if(gift_data){
            gift_discount = gift_data.gift_value;
            discount += parseFloat(gift_data.gift_value);
            if(price < discount){
                discount = price;
                new_price = price - discount;
            }else{
                new_price -= parseFloat(gift_discount);
            }
        }

        all_discount = discount;

        message = "Congratulations! you saved an additional ₹"+discount+" on this booking";
        $('.offer-appliend-message').html(message);
        $('.offer-appliend-message-div').removeClass('hidden');

        discount_title = 'Discount';
        discount_value = '₹' + discount;
        $('.discount-title').html(discount_title);
        $('.discount-value').html(discount_value);


        $('.order-total').attr('data-value', new_price).html(new_price);
        $('.order-total-pay').html(new_price);
    }else{
        $('.offer-appliend-message').html('');
        $('.offer-appliend-message-div').addClass('hidden');
        $('.discount-title').html('Discount');
        $('.discount-value').html('₹0');

        original_value = $('.order-total').attr('data-original-value');
        $('.order-total').attr('data-value', original_value).html(original_value);
        $('.order-total-pay').html(original_value);
        all_discount = 0;
    }

}

$('#btn-pay').click(function(){
    origional_price = $('.order-total').data('original-value');
    final_total = $('.order-total').data('value');
    hasOffer = false;
    discount = all_discount;
    offer_code = gift_id = null;
    if(offer){
        hasOffer = true;
        // discount = offer.discount;
        offer_code = offer.offer_code;
    }
    if(gift_data){
        gift_id = gift_data.gift_id;
        // discount = offer.discount;
    }

    data = {
        'origional_price' : origional_price,
        'final_total' : final_total,
        'hasOffer' : hasOffer,
        'discount' : discount,
        'offer_code' : offer_code,
        'gift_id' : gift_id,
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
                window.location.href = "{{ route('user.address') }}";
            }else{
                Swal.fire("Error!", data.message, "error");
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

    gift_id = $('.gift_id:checked').val();
    if(offer_code){
        $.ajax({
            header:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            url: $(this).prop('action'),
            type : "post",
            dataType:'json',
            data : {
                "_token": "{{ csrf_token() }}",
                "offer_code": offer_code,
                "gift_data": gift_data
            },
            success : function(data) {
                $('#offer-form .btn-submit').prop('disabled', false);
                if(data.success){
                    $this.find('.alert-info').hide();
                    $this.find('.alert-danger').hide();
                    $this.find('.alert-success').show();
                    $this.find('.alert-success').html(data.message);
                    offer = data.offer_data;
                    apply_offer(offer,gift_data);
                    $('#view-offer .close').trigger('click');
                }else{
                    $this.find('.alert-success').hide();
                    $this.find('.alert-info').hide();
                    $this.find('.alert-danger').show();
                    $this.find('.alert-danger').html('');
                    $(' .alert-danger').html(data.message);
                    offer = null;
                    apply_offer(offer, gift_data);
                }
            }
        });
    }

    if(gift_id){
        $('#offer-form .btn-submit').prop('disabled', false);
        gift_data = {
            'gift_id' : gift_id,
            'gift_value' : $('.gift_id:checked').data('gift-value')
        };
        $('#offer-form').find('.alert-info').hide();
        $('#offer-form').find('.alert-danger').hide();
        $('#offer-form').find('.alert-success').show();
        $('#offer-form').find('.alert-success').html("Gift used successfully.");
        apply_offer(offer, gift_data);
        $('#view-offer .close').trigger('click');
    }
    return false;
});
</script>

@endsection
