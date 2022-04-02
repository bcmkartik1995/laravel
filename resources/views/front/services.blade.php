@extends('layouts.front')
@section('styles')
<link rel="stylesheet" href="{{asset('assets/front-assets/css/plugin/fancybox/jquery.fancybox.css')}}">
<link href="https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/assets/owl.carousel.min.css" type="text/css" rel="stylesheet" />
<link href="https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/assets/owl.theme.default.min.css" type="text/css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('assets/front-assets/css/plugin/toaster/vendor/toastr.css') }}" media="screen">
@endsection
@section('content')

<div class="mt-5 mb-5">
    <div class="container">

        <div class="row off-bg " style="display:none;">
            <div class="col-md-9 col-sm-12 col-12">
                <div class="offer-text1">
                    <div class="offer-detail">
                        <p class="service-nm1">{{ $cat['title'] }}</p>
                    </div>
                </div>
            </div>
             <div class="col-md-1 col-sm-2 col-2">
                <p class="rants">{{$review_ratings}}/5</p>
            </div>
            <div class="col-md-2 col-sm-10 col-10 text-center">
                <p class="based-rants">Based on {{$total_review_count}} rate</p>
            </div>
        </div>
        <div class="row mt-2 ">
            <div class="col-md-12">
                <div class="vertical-tab mr-0 row" role="tabpanel">
                    <!-- CATEGORY MENU -->
                    <div class="mobile-category w-100">
                        <select id="mobile-category-select">
                            <option value="">All Services</option>
                            @foreach($sub_cat as $sub_cate)
                                <option value="{{$sub_cate['slug']}}" {{$sub_category_id == $sub_cate->id ? 'selected' : ''}}>{{ $sub_cate->title }}</option>
                            @endforeach
                            @if($all_packages->count())
                                <option value="all-package" {{$sub_cat_slug == 'all-package' ? 'selected' : ''}}>Packages</option>
                            @endif
                        </select>
                    </div>
                    <!-- Nav tabs -->
                    <ul class="nav-tabs tables col-md-3 border-0 category-menu" role="tablist">
                        @foreach($sub_cat as $sub_cate)
                        <li role="presentation" class="{{$sub_category_id == $sub_cate->id ? 'active' : ''}}">
                            <a class="ls-display" href="{{ url('serviceList/'.$cat->slug.'/'.$sub_cate['slug']) }}" ><img class="mr-3" src="{{ asset('assets/images/subcategorylogo/'.$sub_cate->logo) }}">{{ $sub_cate->title }}</a>
                        </li>
                        @endforeach
                        @if($all_packages->count())
                            <li role="presentation" class="{{$sub_cat_slug == 'all-package' ? 'active' : ''}}">
                                <a class="ls-display" href="{{ url('serviceList/'.$cat->slug.'/all-package') }}" ><img class="mr-3" src="{{ asset('assets/images/all-packages.png') }}">Packages</a>
                            </li>
                        @endif

                    </ul>
                    <!-- Tab panes -->

                    <div class="tab-content tabs col-md-9 mt-0">
                        <div class=" ">
                        <div class=" ">
                        <div role="tabpanel" class="tab-pane fade in active show scrollbar" id="Service1">

                            <h5 class="p-3 text-center services-title">
                                @if($sub_cat_slug == 'all-package')
                                Packages
                                @elseif(!empty($sub_cat_slug))
                                {{$sub_category->title}}
                                @else
                                All Services
                                @endif
                            </h5>

                            <div class="main-panal row">
                                {{-- <div class="package-view border mt-3">
                                    <div class="  ">
                                        <div class=" ">
                                            <div class="festival-text text-center">
                                                <h5 class="mb-0">Festive Special  </h5>
                                                <p class="off-cl mb-0">Flat 50% off up to ₹250 | Use Code : SALON50</p>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                @php
                                    $hidden_cart = $my_cart;
                                    $total_cart_price = 0;
                                    $total_cart_quantity = 0;

                                @endphp
                                @if(!empty($services) && !empty($services->count()))
                                    @foreach($services as $serve)

                                        @php
                                            $quantity = 0;
                                            $inCart = false;
                                            if(isset($my_cart['services'][$serve->id])){
                                                $quantity = $my_cart['services'][$serve->id]['quantity'];
                                                $inCart = true;
                                                unset($hidden_cart['services'][$serve->id]);
                                            }
                                        @endphp

                                        <div class=" items-div col-md-6 mb-4" data-type="service" data-id="{{ $serve->id }}">
                                            <input type="hidden" name="service_price[{{ $serve->id }}]" class="service_price" value="{{ $serve->price }}">
                                            <input type="hidden" name="service_quantity[{{ $serve->id }}]" class="service_quantity">
                                            <div class=" border">
                                                @if($serve->service_media->count() > 1)
                                                    <div class="test-slider services-slider">
                                                        <div class="owl-carousel owl-theme">
                                                        @foreach($serve->service_media as $service_media)
                                                        @php
                                                            $ext = strtolower(pathinfo(asset('assets/images/servicemedia/'.$service_media->media), PATHINFO_EXTENSION));
                                                        @endphp

                                                        <div class="items">
                                                            <div class="ser-img-2">
                                                                @if(in_array($ext, $image_formats))
                                                                <a class="fancybox" href="{{asset('assets/images/servicemedia/'.$service_media->media)}}" data-fancybox="service-gallery-{{$serve->id}}">
                                                                    <img class="" src="{{asset('assets/images/servicemedia/'.$service_media->media)}}" alt="">
                                                                </a>
                                                                @else
                                                                    <a class="fancybox1" href="{{asset('assets/images/servicemedia/'.$service_media->media)}}" data-fancybox="service-gallery-{{$serve->id}}">
                                                                    <video controls width="100%" height="250px" class="">
                                                                        <source src="{{asset('assets/images/servicemedia/'.$service_media->media)}}" type="video/mp4">
                                                                      </video>
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="row px-3 pt-3 justify-content-between services-content">
                                                        <div class=" ">
                                                            <h5 class="mt-0 pt-2 service-contain">{{$serve->title}}</h5>
                                                            <div class="str-img">
                                                                <i class="fa fa-star text-warning"></i>
                                                            <p class="clr-text d-inline ">{{$serve->review_avg ? round($serve->review_avg,2) : 0}}</p>
                                                            <p class="mb-0 d-inline rs-rate">({{$serve->review_count}} ratings)</p>
                                                            </div>
                                                            <div>
                                                            <p class="mb-0 d-inline rs-text font-weight-bold">₹{{$serve->price}}</p>
                                                            {{-- <p class="d-inline rs-text font-weight-bold text-danger">₹{{$serve->price}}</p> --}}
                                                            </div>
                                                            <div class="">
                                                                <i class="fa fa-clock-o d-inline f-icons" aria-hidden="true"></i>
                                                                <p class=" d-inline">Estimated Time : {{($serve->hour*60) + $serve->minute}} min</p>
                                                            </div>
                                                        </div>

                                                        <div class="">
                                                            <div class="btn-add">
                                                                <input type="submit" name="cart_{{ $serve->id }}" style="{{$inCart==true?'display:none;':''}}" data-service_name = "{{ $serve->title }}" data-id="{{ $serve->id }}" value="Add" class="btn-add-text service_{{ $serve->id }} service_button ">
                                                                {{-- <a class="btn-add-text" href="#" data-toggle="modal" data-target="#cart1-modal">Add</a> --}}
                                                            </div>



                                                            <div class="service_cart_{{ $serve->id }} add-remove " data-id="service_cart_{{ $serve->id }}"  style="{{$inCart==true?'':'display:none;'}}">
                                                                <button id="minus" data-service_id="{{ $serve->id }}" height="10px;" width="20px;" data-value="1" class="button minus_service btn-min"> - </button>
                                                                <input type="submit" id="value_service_{{ $serve->id }}" height="10px;" width="20px;"  value="{{$quantity}}" class="button quantity btn-ad">
                                                                <button id="plus" data-service_id="{{ $serve->id }}" height="10px;" data-service_name = "{{ $serve->title }}" data-id="{{ $serve->id }}" width="20px;" data-value="1" class="button plus_service btn-plus"> + </button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="">
                                                        <div class="row px-2">
                                                            <div class="view-detail">
                                                                <a class="view-details view-details-ajax" data-id="{{$serve->id}}" data-type="service" data-title="{{$serve->title}}" href="#"    data-toggle="modal" data-target="#information_modal">View Detail</a>
                                                            </div>
                                                            <div  class="btn-edit ml-1">
                                                                <a href="javascript:void(0);" class="edit-text btn-view-cart-2" >Proceed to Pay</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="">
                                                    <div class="test-slider services-slider">
                                                        <div class="owl-carousel owl-theme">
                                                        @foreach($serve->service_media as $service_media)
                                                            <div class="item">
                                                            <div class=" ">
                                                                <div class="ser-img-2">
                                                                    @php
                                                                        $ext = strtolower(pathinfo(asset('assets/images/servicemedia/'.$service_media->media), PATHINFO_EXTENSION));
                                                                    @endphp
                                                                    @if(in_array($ext, $image_formats))
                                                                        <a class="fancybox" href="{{asset('assets/images/servicemedia/'.$service_media->media)}}" data-fancybox="service-gallery-{{$serve->id}}">
                                                                            <img class="" src="{{asset('assets/images/servicemedia/'.$service_media->media)}}" alt="">
                                                                        </a>
                                                                    @else
                                                                        <a class="fancybox1" href="{{asset('assets/images/servicemedia/'.$service_media->media)}}" data-fancybox="service-gallery-{{$serve->id}}">
                                                                        <video controls width="100%" height="auto" class="">
                                                                            <source src="{{asset('assets/images/servicemedia/'.$service_media->media)}}" type="video/mp4">
                                                                        </video>
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                    <div class="row px-3 pt-3 justify-content-between services-content">
                                                        <div class="">

                                                            <h5 class="mt-0 pt-2 service-contain">{{$serve->title}}</h5>
                                                            <div class="str-img">
                                                                <i class="fa fa-star text-warning"></i>
                                                                <p class="clr-text d-inline ">
                                                                    {{$serve->review_avg ? round($serve->review_avg,2) : 0}}
                                                                </p>
                                                                <p class="mb-0 d-inline rs-rate">({{$serve->review_count}} ratings)</p>
                                                            </div>
                                                            <div>
                                                            <p class="mb-0 d-inline rs-text font-weight-bold">₹{{$serve->price}}</p>
                                                            {{-- <p class="d-inline rs-text ">₹{{$serve->price}}</p> --}}
                                                            </div>
                                                            <div class="">
                                                                <i class="fa fa-clock-o d-inline f-icons" aria-hidden="true"></i>
                                                                <p class=" d-inline">Estimated Time : {{($serve->hour*60) + $serve->minute}} min</p>
                                                            </div>
                                                        </div>
                                                        <div class="">
                                                            <div class="btn-add">
                                                                <input type="submit" name="cart_{{ $serve->id }}" style="{{$inCart==true?'display:none;':''}}" data-service_name = "{{ $serve->title }}" data-id="{{ $serve->id }}" value="Add" class="btn-add-text service_{{ $serve->id }} service_button ">
                                                                {{-- <a class="btn-add-text" href="#" data-toggle="modal" data-target="#cart1-modal">Add</a> --}}
                                                            </div>



                                                            <div class="service_cart_{{ $serve->id }} add-remove " data-id="service_cart_{{ $serve->id }}"  style="{{$inCart==true?'':'display:none;'}}">
                                                                <button id="minus" data-service_id="{{ $serve->id }}" height="10px;" width="20px;" data-value="1" class="button minus_service btn-min"> - </button>
                                                                <input type="submit" id="value_service_{{ $serve->id }}" height="10px;" width="20px;"  value="{{$quantity}}" class="button quantity btn-ad">
                                                                <button id="plus" data-service_id="{{ $serve->id }}" height="10px;" data-service_name = "{{ $serve->title }}" data-id="{{ $serve->id }}" width="20px;" data-value="1" class="button plus_service btn-plus"> + </button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    </div>

                                                    <div class="row px-3 pt-3">
                                                        <div class="col-12">
                                                            {!! $serve->description !!}
                                                        </div>
                                                    </div>
                                                    <div class="">
                                                        <div class="row px-2">
                                                            <div class="view-detail">
                                                                <a class="view-details view-details-ajax" data-id="{{$serve->id}}" data-type="service" data-title="{{$serve->title}}" href="#"    data-toggle="modal" data-target="#information_modal">View Detail</a>
                                                            </div>
                                                            <div  class="btn-edit ml-1">
                                                                <a href="javascript:void(0);" class="edit-text btn-view-cart-2" >Proceed to Pay</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                                @if(!empty($all_packages->count()))
                                    @foreach($all_packages as $pack)

                                    @php
                                        $quantity = 0;
                                        $inCart = false;
                                        if(isset($my_cart['packages'][$pack->id])){
                                            $quantity = $my_cart['packages'][$pack->id]['quantity'];
                                            $inCart = true;
                                            unset($hidden_cart['packages'][$pack->id]);
                                        }
                                    @endphp

                                    <div class=" items-div col-md-6" data-type="package" data-id="{{ $pack->id }}">

                                        <input type="hidden" class="discount_type" value="{{ $pack->discount_type }}">
                                        <input type="hidden" class="discount_value" value="{{ $pack->discount_value }}">
                                        <input type="hidden" class="minimum_require" value="{{ $pack->minimum_require }}">
                                        <input type="hidden" name="package_price[{{ $pack->id }}]" class="package_price">
                                        <input type="hidden" name="package_quantity[{{ $pack->id }}]" class="package_quantity">


                                        <div class=" border">
                                            @if($pack->package_media->count() > 1)
                                                <div class="services-slider ">
                                                    <div class="owl-carousel owl-theme">
                                                        @foreach($pack->package_media as $package_media)
                                                        @php
                                                            $ext = strtolower(pathinfo(asset('assets/images/packagemedia/'.$package_media->media), PATHINFO_EXTENSION));
                                                        @endphp
                                                        <div class="items">
                                                            <div class="ser-img-2">
                                                                @if(in_array($ext, $image_formats))
                                                                <a class="fancybox" href="{{asset('assets/images/packagemedia/'.$package_media->media)}}" data-fancybox="package-gallery-{{$pack->id}}">
                                                                    <img class="" src="{{asset('assets/images/packagemedia/'.$package_media->media)}}" alt="">
                                                                </a>
                                                                @else
                                                                    <a class="fancybox1" href="{{asset('assets/images/packagemedia/'.$package_media->media)}}" data-fancybox="package-gallery-{{$pack->id}}">
                                                                    <video controls width="100%" height="auto" class="">
                                                                        <source src="{{asset('assets/images/packagemedia/'.$package_media->media)}}" type="video/mp4">
                                                                    </video>
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="row px-3 pt-3 justify-content-between services-content">
                                                    <div class="">

                                                        <h5 class="mt-0 pt-2 service-contain">{{$pack->title}}</h5>
                                                        <div class="str-img">
                                                            <i class="fa fa-star text-warning"></i>
                                                            <p class="clr-text d-inline ">
                                                                {{$pack->review_avg ? round($pack->review_avg,2) : 0}}
                                                            </p>
                                                            <p class="mb-0 d-inline rs-rate">({{$pack->review_count}} ratings)</p>
                                                        </div>
                                                        <div>
                                                            <p class="mb-0 d-inline rs-text font-weight-bold">₹<span class="discountvalue"></span></p>
                                                            <p class="d-inline rs-text font-weight-bold text-danger">₹<span class="fullvalue"></span></p>
                                                        </div>
                                                        <div class="">
                                                            <i class="fa fa-clock-o d-inline f-icons" aria-hidden="true"></i>
                                                            <p class=" d-inline">Estimated Time : {{($pack->hour*60) + $pack->minute}} min</p>
                                                        </div>
                                                    </div>

                                                    <div class="">
                                                        <div class="btn-add">
                                                            <input type="submit" name="cart_{{ $pack->id }}" style="{{$inCart==true?'display:none;':''}}" data-package_name = "{{ $pack->title }}" data-id="{{ $pack->id }}" value="Add" class="btn-add-text package_{{ $pack->id }} package_button ">
                                                        </div>



                                                        <div class="package_cart_{{ $pack->id }} add-remove" data-id="package_cart_{{ $pack->id }}"  style="{{$inCart==true?'':'display:none;'}}">
                                                            <button id="minus" data-package_id="{{ $pack->id }}" height="10px;" width="20px;" data-value="1" class="button minus_package btn-min"> - </button>
                                                            <input type="submit" id="value_package_{{ $pack->id }}" height="10px;" width="20px;"  value="{{$quantity}}" class="button quantity btn-ad">
                                                            <button id="plus" data-package_id="{{ $pack->id }}" height="10px;" data-package_name = "{{ $pack->title }}" data-id="{{ $pack->id }}" width="20px;" data-value="1" class="button plus_package btn-plus"> + </button>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row px-3 pt-3">
                                                    <div class="col-12">
                                                        {!! $pack->description !!}
                                                    </div>
                                                </div>
                                                <div class="row px-2">
                                                    <div class="btn-edit">
                                                        <a class="edit-text" href="#" data-toggle="modal" data-target="#edit-page-{{$pack->id}}">Edit package</a>
                                                    </div>
                                                    <div class="view-detail ml-1">
                                                        <a class="view-details view-details-ajax" data-id="{{$pack->id}}" data-type="package" data-title="{{$pack->title}}" href="#"    data-toggle="modal" data-target="#information_modal">View Detail</a>
                                                    </div>
                                                    <div  class="btn-edit ml-1">
                                                        <a href="javascript:void(0);" class="edit-text btn-view-cart-2" >Proceed to Pay</a>
                                                    </div>
                                                </div>


                                            @else
                                                <div class="">
                                                    <div class="test-slider services-slider">
                                                            <div class="owl-carousel owl-theme">
                                                        @foreach($pack->package_media as $package_media)
                                                            <div class="item">
                                                            <div class=" ">
                                                                <div class="ser-img-2">
                                                                    @php
                                                                        $ext = strtolower(pathinfo(asset('assets/images/packagemedia/'.$package_media->media), PATHINFO_EXTENSION));
                                                                    @endphp
                                                                    @if(in_array($ext, $image_formats))
                                                                        <a class="fancybox" href="{{asset('assets/images/packagemedia/'.$package_media->media)}}" data-fancybox="package-gallery-{{$pack->id}}">
                                                                            <img class="" src="{{asset('assets/images/packagemedia/'.$package_media->media)}}" alt="">
                                                                        </a>
                                                                    @else
                                                                        <a class="fancybox1" href="{{asset('assets/images/packagemedia/'.$package_media->media)}}" data-fancybox="package-gallery-{{$pack->id}}">
                                                                        <video controls width="100%" height="auto" class="">
                                                                            <source src="{{asset('assets/images/packagemedia/'.$package_media->media)}}" type="video/mp4">
                                                                            </video>
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                            </div></div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="row px-3 pt-3 justify-content-between services-content">
                                                    <div class="">

                                                        <h5 class="mt-0 pt-2 service-contain">{{$pack->title}}</h5>
                                                        <div class="str-img">
                                                            <i class="fa fa-star text-warning"></i>
                                                            <p class="clr-text d-inline ">{{$pack->review_avg ? round($pack->review_avg,2) : 0}} </p>
                                                            <p class="mb-0 d-inline rs-rate">({{$pack->review_count}} ratings)</p>
                                                        </div>
                                                        <div>
                                                            <p class="mb-0 d-inline rs-text font-weight-bold">₹<span class="discountvalue"></span></p>
                                                            <p class="d-inline rs-text font-weight-bold">₹<span class="fullvalue"></span></p>
                                                        </div>
                                                        <div class="">
                                                            <i class="fa fa-clock-o d-inline f-icons" aria-hidden="true"></i>
                                                            <p class=" d-inline">Estimated Time : {{($pack->hour*60) + $pack->minute}} min</p>
                                                        </div>
                                                    </div>
                                                    <div class="">
                                                        <div class="btn-add">
                                                            <input type="submit" name="cart_{{ $pack->id }}" style="{{$inCart==true?'display:none;':''}}" data-package_name = "{{ $pack->title }}" data-id="{{ $pack->id }}" value="Add" class="btn-add-text package_{{ $pack->id }} package_button ">
                                                            {{-- <a class="btn-add-text" href="#" data-toggle="modal" data-target="#cart1-modal">Add</a> --}}
                                                        </div>

                                                        <div class="package_cart_{{ $pack->id }} add-remove" data-id="package_cart_{{ $pack->id }}"  style="{{$inCart==true?'':'display:none;'}}">
                                                            <button id="minus" data-package_id="{{ $pack->id }}" height="10px;" width="20px;" data-value="1" class="button minus_package btn-min"> - </button>
                                                            <input type="submit" id="value_package_{{ $pack->id }}" height="10px;" width="20px;"  value="{{$quantity}}" class="button quantity btn-ad">
                                                            <button id="plus" data-package_id="{{ $pack->id }}" height="10px;" data-package_name = "{{ $pack->title }}" data-id="{{ $pack->id }}" width="20px;" data-value="1" class="button plus_package btn-plus"> + </button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row px-3 pt-3">
                                                    <div class="col-12">
                                                        {!! $pack->description !!}
                                                    </div>
                                                </div>
                                                <div class="row px-2">
                                                    <div class="btn-edit">
                                                        <a class="edit-text" href="#" data-toggle="modal" data-target="#edit-page-{{$pack->id}}">Edit package</a>
                                                    </div>
                                                    <div class="view-detail ml-1">
                                                        <a class="view-details view-details-ajax" data-id="{{$pack->id}}" data-type="package" data-title="{{$pack->title}}" href="#" data-toggle="modal" data-target="#information_modal">View Detail</a>
                                                    </div>
                                                    <div  class="btn-edit ml-1">
                                                        <a href="javascript:void(0);" class="edit-text btn-view-cart-2" >Proceed to Pay</a>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="modal fade edit-modal " id="edit-page-{{$pack->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content  edit-modal">
                                                    <div class="modal-header border-bottom-0">
                                                        <h3 class="modal-title">{{$pack->title}}</h3>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-title text-center">

                                                        </div>
                                                        <div class="d-flex flex-column ">
                                                            <div class="modal-body get_quote_view_modal_body">
                                                                <div class="container">
                                                                    @if($pack->package_media->count())
                                                                    <div class="pb-3">
                                                                    <div class="test-slider services-slider">
                                                                        <div class="owl-carousel owl-theme">
                                                                        @foreach ($pack->package_media as $media)
                                                                            <div class="item">
                                                                                <div class="pkg-img">
                                                                                    @php
                                                                                        $ext = strtolower(pathinfo(asset('assets/images/packagemedia/'.$media->media), PATHINFO_EXTENSION));
                                                                                    @endphp
                                                                                    @if(in_array($ext, $image_formats))
                                                                                        <a class="fancybox" href="{{asset('assets/images/packagemedia/'.$media->media)}}" data-fancybox="popup-package-gallery-{{$pack->id}}">
                                                                                            <img class="" src="{{asset('assets/images/packagemedia/'.$media->media)}}" alt="">
                                                                                        </a>
                                                                                    @else
                                                                                        <a class="fancybox1" href="{{asset('assets/images/packagemedia/'.$media->media)}}" data-fancybox="popup-package-gallery-{{$pack->id}}">
                                                                                            <video controls width="100%" height="auto" class="">
                                                                                                <source src="{{asset('assets/images/packagemedia/'.$media->media)}}" type="video/mp4">
                                                                                            </video>
                                                                                        </a>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                        </div>
                                                                        </div>
                                                                    </div>
                                                                    @endif
                                                                    <div class="justify-content-between">
                                                                            @foreach($pack->package_services as $pack_service)

                                                                            @php
                                                                                $isChecked = '';
                                                                                if(isset($my_cart['packages'][$pack->id]['services'])){
                                                                                    if(in_array($pack_service->service->id, $my_cart['packages'][$pack->id]['services'])){
                                                                                        $isChecked = 'checked';
                                                                                    }
                                                                                }else{
                                                                                    if($pack_service->is_defult){
                                                                                        $isChecked = 'checked';
                                                                                    }
                                                                                }
                                                                            @endphp
                                                                            <div class="form-check">
                                                                                <input class="form-check-input package_services" type="checkbox" id="service-{{$pack->id}}-{{$pack_service->service->id}}" data-price="{{$pack_service->service->price}}" value="{{$pack_service->service->price}}" data-id="{{$pack_service->service->id}}" data-is-default="{{$pack_service->is_defult}}" {{$isChecked}}>
                                                                                <label class="form-check-label chk-text" for="service-{{$pack->id}}-{{$pack_service->service->id}}">
                                                                                    {{$pack_service->service->title}}
                                                                                </label>
                                                                            </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                    <div class="boxes-ln mt-3">
                                                                        <div class="border">
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

                                    @endforeach
                                @endif

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
    </div>
</div>

<div class="modal modal_outer right_modal fade right-modal" id="information_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" >
    <div class="modal-dialog  right-sub-modals" role="document">
       <form method="post"  id="get_quote_frm">
        <div class="modal-content ">

            <div class="modal-header">
              <h2 class="modal-title pb-0"></h2>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body get_quote_view_modal_body">

            </div>

        </div>
      </form>
    </div>
</div>

<div class="see_cart">
    <div class="row">
        <div class="col-md-12">
            <div class="cart-detail mx-3">
            <p class="item" id="item">Total Item : <span id="item_cart">0</span></p>
            <p class="amount" id="amount">Total Amount : <span id="amount_cart">0</span></p>

            </div>
            <div class="cart-btn text-center">
                <a class="cart-btn-detail countinue-cart" href="javascript:void(0);">Add to cart</a>
            </div>
        </div>
    </div>
</div>
@php
    $total_cart_quantity = 0;
    $total_cart_price = 0;
    if(!empty($hidden_cart['packages'])){
        $hidden_cart['packages'] = array_values($hidden_cart['packages']);
        foreach($hidden_cart['packages'] as $p){
            $total_cart_price += $p['price'];
            $total_cart_quantity ++;
        }
    }else{
        unset($hidden_cart['packages']);
    }
    if(!empty($hidden_cart['services'])){
        $hidden_cart['services'] = array_values($hidden_cart['services']);
        foreach($hidden_cart['services'] as $p){
            $total_cart_price += $p['price'];
            $total_cart_quantity ++;
        }
    }else{
        unset($hidden_cart['services']);
    }
    //if(!empty($total_cart_quantity)){
        $hidden_cart['quantity'] = $total_cart_quantity;
        $hidden_cart['cart_total'] = $total_cart_price;
   // }


@endphp

@endsection

@section('scripts')
<script type="text/javascript" src="{{asset('assets/front-assets/js/plugin/fancybox/jquery.fancybox.min.js')}}"></script>
<!-- <script type="text/javascript" src="https://owlcarousel2.github.io/OwlCarousel2/assets/vendors/jquery.min.js"></script> -->
<script type="text/javascript" src="https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/owl.carousel.js"></script>
<script src="{{ asset('assets/front-assets/js/plugin/toaster/toastr.min.js') }}"></script>
<script>
    $(document).ready(function(){

        $('#mobile-category-select').change(function(){
            slug = $(this).val();
            url = "{{ url('serviceList/'.$cat->slug) }}/" + slug;
            window.location.href = url;
        });

        $('.services-slider .owl-carousel').owlCarousel({
            loop:true,
            margin:10,
            nav:false,
            dots:false,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:1
                },
                1000:{
                    items:1
                }
            }
        });
	});
    $(document).ready(function() {
        $(".fancybox").fancybox();


    });

    var my_cart = {};
    $(document).ready(function(){
        calculate_price();

        $(".package_button").on("click", function(){
            var package_id = $(this).attr("data-id");
            //$(".see_cart").show();
            $(".package_" + package_id).hide();
            $("#value_package_"+package_id).val(1);
            $(".package_cart_"+package_id).show();
            calculate_price(true, isNew = true);
        });

        $(".service_button").on("click", function(){
            var package_id = $(this).attr("data-id");
            $(".service_" + package_id).hide();
            $("#value_service_"+package_id).val(1);
            $(".service_cart_"+package_id).show();
            //$(".see_cart").show();
            calculate_price(true, isNew = true);
        });

        $(".plus_package").on("click", function(){
            package_id = $(this).data('package_id');
            var default_value = parseFloat($("#value_package_"+package_id).val());
            var after_add_value = parseFloat(default_value) + 1;
            $("#value_package_"+package_id).val(after_add_value);
            //$(".see_cart").show();
            calculate_price(true);
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
                calculate_price(true);
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
            //$(".see_cart").show();
            calculate_price(true);
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
                calculate_price(true);
                if(after_sub==0){
                    $(".service_"+service_id).show();
                    $(".service_cart_"+service_id).hide();
                }
            }
        });

        $('.package_services').click(function(){
            calculate_price(true);
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
                        window.location.href= "{{ route('mycart') }}";
                    }else{
                        $('#btn-login').trigger('click');
                    }
                }
            });
        });
    });

    function calculate_price(isUpdate, isNew){

        my_cart.packages = [];
        my_cart.services = [];

        total_price = 0;
        total_items = 0;

        @if(!empty($hidden_cart))
            my_cart_data = {!!json_encode($hidden_cart)!!};
            // console.log(my_cart_data)
            if(my_cart_data.services){
                my_cart.services = my_cart_data.services;
            }
            if(my_cart_data.packages){
                my_cart.packages = my_cart_data.packages;
            }

            if(my_cart_data.cart_total){
                total_price = my_cart_data.cart_total;
            }
            if(my_cart_data.quantity){
                total_items = my_cart_data.quantity;
            }
        @endif

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

                        package_total_price = package_total_price*quantity;

                        if(minimum_require <= total_package_services){
                            if(discount_type == '1'){
                                package_new_price = package_total_price - ((package_total_price*discount_value)/100);
                            }else{
                                package_new_price = package_total_price - discount_value;
                            }
                        }else{
                            package_new_price = package_total_price;
                        }
                        total_price = total_price + (package_new_price);
                    }else{
                        if(pkg_obj.find('.package_services:checked').length ==0){
                            package_total_price = package_new_price = (default_price);
                        }
                        if(quantity){
                            package_total_price = package_total_price*quantity;
                        }

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
                        // console.log(my_cart.services)
                        //my_cart.services = [];
                        my_cart.services.push(data);
                    }
                }
                total_items += quantity;
            }
        });

        total_price = total_price.toFixed(2);
        // if(total_price == 0){
        //     $(".see_cart").hide();
        // }else{
        //     $(".see_cart").show();
        // }
        // $('#item_cart').html(total_items)
        // $('#amount_cart').text(total_price);

        if(isUpdate){

            $.ajax({
                header:{
                    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                },
                url : '/create_cart_session',
                type : "post",
                data : {
                    "_token": "{{ csrf_token() }}",
                    "my_cart": my_cart
                },
                success : function(data) {
                    $('.cart-container').html(data);
                    cart_item_count = $('.cart-item-count').data('count');
                    $('.cart-item-count-badge').html(cart_item_count)
                    if(isNew){
                        toastr.success('Successfully Added to cart', '', { "progressBar": true });
                    }

                }
            });

        }
    }

    $(document).ready(function(){

        // $('#modal_view_left').modal({
        //     show: 'false'
        // });

        // $('#modal_view_right').modal({
        //     show: 'false'
        // });

        $('.view-details-ajax').click(function(){
            id = $(this).data('id');
            type = $(this).data('type');
            var title = $(this).data('title');
            var obj = $(this);
            $.ajax({
                header:{
                    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                },
                url : '{{route("get-service-detail")}}',
                type : "post",

                data : {
                    "_token": "{{ csrf_token() }}",
                    "id": id,
                    'type':type
                },
                success : function(data) {
                    $('#information_modal .modal-title').html(title);
                    $('#information_modal .modal-body').html(data);
                    if(type == 'package'){
                        $('.detail-discountvalue').html(obj.parents('.items-div').find('.discountvalue').html());
                        $('.detail-fullvalue').html(obj.parents('.items-div').find('.fullvalue').html())
                    }
                }
            });
        });

    });
</script>
@endsection
