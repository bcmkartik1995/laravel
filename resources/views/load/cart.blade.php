<span class="cart-item-count" data-count="{{$session_cart['total_items']}}"></span>
@if(empty($session_cart['total_items']))
    <div class="row total-header-section">
        <div class="col-lg-6 col-sm-6 col-6 pl-4">
            Cart is empty
        </div>
    </div>
@else
    <div class="row total-header-section">
        <div class="col-lg-6 col-sm-6 col-6 pl-4">
        <span class="item-no">
            <span class="cart-quantity">{{$session_cart['total_items']}}</span> Item(s)</span>
        </div>
        <div class="col-lg-6 col-sm-6 col-6 total-section text-right">
            <a href="javascript:void(0);" class="btn-view-cart">View cart</a>
        </div>
    </div>
    <div class="row justify-content-center pb-2">
        <div class="col-lg-11 col-sm-6 col-6 ">
            <div class="bl-bd">
            </div>
        </div>
    </div>
    @if(!empty($session_cart['services']))
        @foreach($session_cart['services'] as $serv)
            <div class="row cart-detail">
                <div class="col-lg-6 col-sm-8 col-8 cart-detail-product">
                    <p class="text-capitalize">{{$serv['title']}}</p>
                    <span class="price "> ₹{{$serv['price']}}</span> <span class="count"> Quantity:{{$serv['quantity']}}</span>
                </div>
                    <div class="col-lg-6 col-sm-4 col-4 cart-detail-img">
                    <img src="{{asset('assets/images/servicebanner/'.$serv['banner'])}}">
                    <div class="cart-remove close btn-remove-cart" data-id="{{$serv['id']}}" data-type="service" data-url="{{ route('remove_item_from_cart') }}" aria-label="Close">
                        <span class="bt-crt-close" aria-hidden="true">&times;</span>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    @if(!empty($session_cart['packages']))
        @foreach($session_cart['packages'] as $pack)

            <div class="row cart-detail">
                <div class="col-lg-6 col-sm-8 col-8 cart-detail-product">
                    <p class="text-capitalize">{{$pack['title']}}</p>
                    <span class="price "> ₹{{$pack['price']}}</span> <span class="count"> Quantity:{{$pack['quantity']}}</span>
                </div>
                    <div class="col-lg-6 col-sm-4 col-4 cart-detail-img">
                    <img src="{{asset('assets/images/packagebanner/'.$pack['banner'])}}">
                    <div class="cart-remove close btn-remove-cart" data-id="{{$pack['id']}}" data-type="package" data-url="{{ route('remove_item_from_cart') }}" aria-label="Close">
                        <span class="bt-crt-close" aria-hidden="true">&times;</span>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
@endif
