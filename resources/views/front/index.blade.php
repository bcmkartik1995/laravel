@extends('layouts.front')
@section('styles')
<link rel="stylesheet" href="{{ asset('assets/front-assets/css/bootstrap-datetimepicker.min.css') }}" media="screen">

<!-- Add the slick-theme.css if you want default styling -->
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<!-- Add the slick-theme.css if you want default styling -->
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
@endsection
@section('content')
<div class="container-fluid pl-0 pr-0  banner-search-main">
    <div id="carouselExampleSlidesOnly" class="carousel slide main-slider" data-ride="carousel">

        <div class="carousel-inner ">
            @if($main_sliders->count())
                @foreach($main_sliders as $k => $main_slider)
                <div class="carousel-item {{$k==0?'active':''}} main-banner">
                    <img class="w-100" src="{{asset('assets/images/sliderimage/'.$main_slider->image)}}" alt="Second slide">
                    <div class="display-contain banner-sub-txt d-block">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <h1 class="banner-head-detail">{{$main_slider->title}}</h1>
                                <div class="b-contain mb-0">{!! $main_slider->description !!}</div>
                                <div class="banner-search">
                                    <form id="frm-set-location" action="{{ route('location.set_location_session') }}" method="post">
                                        {{csrf_field()}}
                                        @php
                                            $location_search = old('location_search');
                                            $lat = old('lat');
                                            $lng = old('lng');
                                            $country = old('country');
                                            $city = old('city');
                                            $zip = old('zip');
                                            $state = old('state');
                                            if(Session::has('location_search')){
                                                $location_search_arr = Session::get('location_search');
                                                $location_search = $location_search_arr['location_search'];
                                                $lat = $location_search_arr['lat'];
                                                $lng = $location_search_arr['lng'];
                                                $country = $location_search_arr['country'];
                                                $city = $location_search_arr['city'];
                                                $zip = $location_search_arr['zip'];
                                                $state = $location_search_arr['state'];
                                            }

                                        @endphp
                                                <div class="banner-form display-contain text-center">
                                                    <div class="input-group input-group-sm">
                                                        <div class="input-group-prepend in-gr-ft">
                                                            <span class="input-group-text ser-img-loc">
                                                                <img src="{{asset('assets/front-assets/images/search.png')}}">
                                                            </span>
                                                        </div>
                                                        <input type="text" class="form-control fr-inp location_search_slider" id="location_search" name="location_search" type="text" size="50" placeholder="Enter a location" value="{{$location_search}}">

                                                        <input type="hidden" name="lat" id="lat" value="{{$lat}}">
                                                        <input type="hidden" name="lng" id="lng" value="{{$lng}}">
                                                        <input type="hidden" name="country" id="country" value="{{$country}}">
                                                        <input type="hidden" name="city" id="city" value="{{$city}}">
                                                        <input type="hidden" name="state" id="state" value="{{$state}}">
                                                        <input type="hidden" name="zip" id="zip" value="{{$zip}}">
                                                        <input type="hidden" name="clear" id="clear-location-input" value="">

                                                        <div class="input-group-prepend border-none">
                                                            <span class="input-group-text ser-img-loc">
                                                                <button type="button" id="btn-current_location" class="fas fa-map-marker-alt fa-lg btn-cur btn-current_location"></button>
                                                            </span>
                                                        </div>

                                                        <div class="input-group-prepend border-none in-gr-th">
                                                            <span class="input-group-text ser-img-loc rounded-right">
                                                                <button type="button" name="clear" id="clear_location" value="clear"  class="clear_location far fa-times-circle fa-lg btn-cl"></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="p-0">
                                                        @if($errors->has('location_search'))
                                                            <label id="location_search-error" class="error" for="location_search">{{ $errors->first('location_search') }}</label>
                                                        @endif
                                                        @if($errors->has('lat'))
                                                            <label id="lat-error" class="error" for="lat">{{ $errors->first('lat') }}</label>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row justify-content-center">
                                                        <button type="submit" class="btn go-btn">Go</button>
                                                </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="carousel-item active main-banner">
                    <img class="w-100" src="{{asset('assets/front-assets/images/default-slider.jpg')}}" alt="Second slide">


                    <div class="display-contain banner-sub-txt d-block">
                        <div class="row">
                            <div class="col-md-12">
                                <h1 class="banner-head-detail">Are You Looking Appliance Repair Service ?</h1>

                                <div class="b-contain mb-0">Velox Solution expert will best experienced and high quality trained they will come at your door step and servicing your appliance repair fix and the problem and your Appliance work like as a new Appliance.</div>
                            </div>
                        </div>
                    </div>

                </div>
            @endif
        </div>
        <a class="carousel-control-prev" href="#carouselExampleSlidesOnly" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleSlidesOnly" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

</div>



  <!-- services section  -->
<div class="service-section category-block">
	<div class="container">

        @if($categories->count())
            @php
                $isLast = false;
                $isShown = false;
            @endphp
            @foreach($categories as $c => $cat)
                @php
                    if($c+1 == $categories->count()){
                        $isLast = true;
                    }
                   // var_dump($isLast);
                @endphp


                <div class="row text-center {{$cat->count() < 6 ? 'justify-content-center' : ''}}">
                    @foreach($cat as $category)

                        <div class="col-lg-2 col-md-2 col-sm-3 col-6 services-item">
                            <a href="{{ (Session::has('location_search') ? url('serviceList/'.$category->slug):'javascript:void(0);') }}" class="{{!Session::has('location_search')?'location-alert':''}}">
                            <div class="service-image">
                                <img src="{{asset('assets/images/categorylogo') }}/{{ $category->logo }}">
                            </div>
                            <h4 class="">
                                {{ $category->title}}
                            </h4></a>
                        </div>
                    @endforeach
                    @if($isLast && $cat->count() < 6)
                        @php
                            $isShown = true;
                        @endphp
                        @include('load.other-category')
                    @endif
                </div>
                @if($isLast && $isShown == false)
                    <div class="row text-center justify-content-center">
                        @include('load.other-category')
                    </div>
                @endif
            @endforeach
        @else
        <div class="row text-center justify-content-center">
            @include('load.other-category')
        </div>
        @endif

	</div>
</div>



<!-- service section end -->
<!-- best-serves section  -->

@if($Best_services->count())
	<div class="container text-center best-service-slider pb-5 pt-4">

        <h2 class="title-contain">Best Services</h2>
        <div class="best-service-slick-slider">
            @foreach($Best_services as $k => $Best_service)
                <a class="slide kl-icarousel__link {{!Session::has('location_search')?'location-alert':''}}" href="{{ (Session::has('location_search') ? url('serviceList/'.$Best_service->service->category->slug):'javascript:void(0);') }}" target="_self" title="title">
                    <div class="card shadow-sm">
                        <div class="">
                            <img src="{{asset('assets/images/servicebanner/'.$Best_service->service->banner)}}">
                        </div>
                        <div class="ca-bd-tx">
                            <div class="d-flex bg-white text-center flex-column w-1 align-items-center serve-con-det">{{$Best_service->service->title}}</div>
                            <div class="ser-det-ft">
                                {{$Best_service->service->category->title}}
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

	</div>
@endif

    <!-- best-offer section end -->

    <div class="count-section mb-4 bg-05">
        <div class="count-pds">
            <div class="container">
                <div class="row ">
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="counter">
                            <div class="counter-icon pb-2">
                                <img src="{{asset('assets/front-assets/images/statistics/icon-1.png') }}" width=46>
                           </div>
                            <span class="counter-value">{{ $all_services->count() }}</span>
                            <h3>Services</h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="counter">
                            <div class="counter-icon pb-2">
                                <img src="{{asset('assets/front-assets/images/statistics/icon-3.png') }}" width=46>
                           </div>
                            <span class="counter-value">15</span>
                            <h3>City</h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="counter">
                            <div class="counter-icon pb-2">
                                <img src="{{asset('assets/front-assets/images/statistics/icon-2.png') }}" width=46>
                           </div>
                            <span class="counter-value">22</span>
                            <h3>Franchises</h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 mx-auto">
                        <div class="counter">
                            <div class="counter-icon pb-2">
                                <img src="{{asset('assets/front-assets/images/statistics/icon-4.png') }}" width=46>
                           </div>
                            <span class="counter-value">{{count($users)}}</span> <!-- added kano for dynamik-->
                            <h3>Happy Customer</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- about section  -->
    <div class="best-offer">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 col-sm-12 col-12">
                    <div class="about-contain">
                        <h2 class="title-contain">About VELOX</h2>
                        <p class="about-detail mb-0">Velox Solution comes up with the AIM of Providing the Best Service at your Door Step. Velox provides Services like Cleaning & Disinfection, Salon For Women & Men, Paintwork, Car Washing, and AC Service Delivered by Professionals and Experts.</p>
                        <!-- <ul class="about-list">
                            <li ><p class="about-list-detail mb-0"> $49 waived with repair</p></li>
                            <li><p class="about-list-detail mb-0"> </p></li>
                            <li><p class="about-list-detail"> </p></li>
                        </ul> -->
						{{-- <table class="table table-bordered mb-0 my-3 ">
							<tr>
								<td><strong>Diagnosing the problem:</strong></td>
								<td>$49 waived with repair</td>
							</tr>
							<tr>
								<td><strong>Price:</strong></td>
								<td>Starting at $200</td>
							</tr>
							<tr>
								<td><strong>Average time to complete:</strong></td>
								<td>1 hour</td>
							</tr>
						</table> --}}
                        <div class="schedule-service mb-0 my-3">
                            <a class="btn-schedule" href="{{route('front.about')}}">Read More About Us</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-12">
                    <div class="about-images">
                        <img src="{{asset('assets/front-assets/images/about.png')}}">
                    </div>

                </div>
            </div>
        </div>

    </div>
    <!-- about section end  -->


    <!-- easy order process section  -->


    <div class="order-process bg-05">
            <h2 class="title-contain">Easy Ordering Process</h2>
        <div class="container">
            <div class="row order-space pt-3 pb-4">
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="media bg-arrow align-items-center">

                         <div class="round-box">
                            <img src="{{asset('assets/front-assets/images/search2.png')}}" alt="">
                         </div>
                        <div class="media-body pl-3">
                            <h5 class="mt-0 mb-3 fid-ser-sub-txt">Find Your Service</h5>
                           <p class="oreder-sub-detail mb-0">Whatever service you are looking for, select them. </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="media align-items-center">
                        <div class="round-box">
                            <img src="{{asset('assets/front-assets/images/service3.png')}}" alt="">
                        </div>
                        <div class="media-body pl-3">
                            <h5 class="mt-0 mb-3">Choose Your Services Options</h5>
                          <p class="oreder-sub-detail mb-0">Thousand of service providers available select one of them.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="media align-items-center">
                        <div class="round-box">
                            <img src="{{asset('assets/front-assets/images/enjoy3.png')}}"  alt="">
                        </div>
                        <div class="media-body pl-3">
                            <h5 class="mt-0 mb-3">Enjoy Your Service</h5>
                          <p class="oreder-sub-detail mb-0">Professional comes to your doorstep and deliver service.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row btn-center text-center">
                <div class="col-md-12">
                    <div class="btn-book">
                        <a class="sub-btn-book btn-book-now" href="#">Book Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


   <!-- easy order process section end  -->

   <!-- best offer  section  -->


@if($best_offers->count())
<div class="best-offers-slider pb-4 pt-5">
    <div class="container">
        <div class="best-offer-container">
            <h2 class="title-contain">Best Offer For Today</h2>
            <div class="best-offers-slick-slider">
                @foreach($best_offers as $k => $best_offer)
                    <div class="card shadow-sm">
                        <div class="">
                        <img src="{{asset('assets/images/offerbanner/'.$best_offer->offer->banner)}}">
                        </div>
                        <div class="ca-bd-tx">
                            <div class="d-flex bg-white text-center flex-column w-1 align-items-center serve-con-det"><?=$best_offer->offer->title?></div>
                            <div class="ser-det-ft">
                            up to {{$best_offer->offer->offer_type == 1 ? $best_offer->offer->offer_value.'%' : 'Rs.'.$best_offer->offer->offer_value}} off
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif
<!--   best offer  section  end  -->

<!-- refer and free section  -->

@if(!empty($Referral_programs))

@php
    $referral_value = $Referral_programs->referral_value;
    $referral_type = $Referral_programs->referral_type;
    $max_value = $Referral_programs->max_value;
@endphp
<div class="refer-section  bg3">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-md-6 col-sm-12 col-12">
				<div class="tt-contain">
					<h2 class="title-contain">Refer and Get Free Services</h2>
					<p class="refer-sub-contain">Invite your friends to Velox Solution. They get Rs. {{ $referral_value }} off. You win upto Rs. {{ $max_value }}</p>
				</div>
                <form id="frm-referral" data-action="{{route('refer_and_earn')}}" method="POST" enctype="multipart/form-data">
                    @include('includes.front.ajax-message')

                    @csrf
                    <div class="row col-md-12 justify-content-center mx-auto">
                        <div class="form-group w-75 mb-0">
                            <input type="text" class="form-control" name="referral_number" placeholder="Enter Mobile Number">
                        </div>
                        <div class="">
                            <button class="send-btn btn-contain" type="submit">Send</button>
                        </div>
                    </div>
                </form>

				<div class="row justify-content-center mt-4">
					<div class="refer-img">
						<img src="{{asset('assets/front-assets/images/Screenshot_8.png')}}">
					</div>
					<div class="refer-img">
						<img src="{{asset('assets/front-assets/images/Screenshot_9.png')}}">
					</div>
				</div>
			</div>
			<div class="col-md-6 col-sm-6 mx-auto col-12">
				<div class="refer-img1">
					<img src="{{asset('assets/front-assets/images/app.png')}}">
				</div>

			</div>
		</div>
	</div>

</div>
@endif

 <!-- refer and free section end -->

 <!-- Our Customers Review -->
 @if($customer_reviews->count())
    <div class="top-review testimonial">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="title-contain">Customers Review</h2>
            </div>
        </div>

        <div class="testimonial__inner">
        <div class="testimonial-slider">
            @foreach($customer_reviews as $k => $customer_review)
            <div class="testimonial-slide">
                <div class="testimonial_box">
                    <div class="testimonial_box-inner">
                        <div class="testimonial_box-top row">
                            <div class="col-lg-2 col-md-3 col-sm-12">
                                <div class="testimonial_box-img">
                                    <img src="{{asset('assets/images/' . ($customer_review->user->photo ? 'users/'.$customer_review->user->photo : 'profile.png'))}}" alt="profile">
                                </div>
                            </div>
                            <div class="col-lg-10 col-md-9 col-sm-12">
                                <div class="testimonial_box-icon">
                                    <i class="fas fa-quote-right"></i>
                                </div>
                                <div class="testimonial_box-text">
                                    {!!Str::limit(strip_tags($customer_review->description) ,200,' ...')!!}
                                </div>

                                <?php
                                $images = json_decode($customer_review->images);
                                ?>
                                @if(!empty($images))
                                <div class="testimonial_box-img" style="justify-content: unset;">
                                    @foreach($images as $image)
                                    <img src="{{asset('assets/images/review/' . ($image))}}" alt="profile" class="mr-2">
                                    @endforeach
                                </div>
                                @else
                                <div class="testimonial_box-img" style="justify-content: unset;height: 100px">
                                </div>
                                @endif
                                <div class="testimonial_box-name">
                                    <h6>{{$customer_review->user->name}}</h6>
                                </div>
                                <div class="testimonial_box-job">
                                    <div class="d-flex">
                                        @for($i=1;$i<=5;$i++)
                                            <div class="pr-1">
                                                <div class="sub-slider-img text-center">
                                                    <i class="fa fa-star {{$customer_review->service_rating >= $i ? 'text-warning':''}}"></i>
                                                </div>
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        </div>
    </div>
    </div>
@endif


<!-- Our Customers Review  end-->

 <!-- Enterprise Services section  -->

 <div class="map-section">
	<div class="map-img">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-12 col-sm-12">
				<h2 class="title-contain">Enterprise Services</h2>
                     <form id="request-a-quote" class="request-a-quote" data-action="{{route('front.request_a_quote')}}" method="POST" enctype="multipart/form-data">
                        @include('includes.front.ajax-message')
                        @csrf

                        <div class="form-row">
							<div class="col">
						        <input type="text" class="form-control" name="request_name" placeholder="Name" value="{{old('request_name')}}">
                                @error('request_name')
                                    <label id="request_name-error" class="error" for="request_name">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>

						<div class="form-row">
							<div class="col">
								<input type="text" class="form-control" name="request_email" placeholder="E-mail" value="{{old('request_email')}}">
                                @error('request_email')
                                    <label id="request_email-error" class="error" for="request_email">{{ $message }}</label>
                                @enderror
							</div>
							<div class="col">

								<input type="text" class="form-control" name="request_phone" placeholder="Phone" value="{{old('request_phone')}}">
                                @error('request_phone')
                                    <label id="request_phone-error" class="error" for="request_phone">{{ $message }}</label>
                                @enderror
							</div>
						</div>
                        <div class="form-row">
							<div class="col">
						        <input type="text" class="form-control" name="request_address" placeholder="Address" value="{{old('request_address')}}">
                                @error('request_address')
                                    <label id="request_address-error" class="error" for="request_address">{{ $message }}</label>
                                @enderror
                            </div>
                            {{-- <div class="col">
                                <select class="form-control" name="request_service" id="request_service">
                                    <option value="">Select Service</option>
                                    @foreach($all_services as $service)
                                    <option value="{{$service->id}}">{{$service->title}}</option>
                                    @endforeach
                                </select>
                                @error('request_service')
                                    <label id="request_service-error" class="error" for="request_service">{{ $message }}</label>
                                @enderror
                            </div> --}}
                        </div>
                        <div class="form-row">
							<div class="col">
                                <textarea type="text" class="form-control" name="request_message" placeholder="Message" rows="4">{{old('request_message')}}</textarea>
                                @error('request_message')
                                    <label id="request_message-error" class="error" for="message">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
							<div class="col">
                                <div class="input-group date" id="custom-visit_date">
						            <input type="text" name="request_visit_date" class="form-control"  placeholder="Select Date" readonly>
                                </div>
                                @error('request_visit_date')
                                    <label id="request_visit_date-error" class="error" for="request_visit_date">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="col">
                                <div class="input-group date" id="custom-visit_time">
                                    <input type="text" name="request_visit_time" class="form-control" placeholder="Select Time" readonly>
                                </div>
                                @error('request_visit_time')
                                    <label id="request_visit_time-error" class="error" for="request_visit_time">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>



						<div class="row btn-center text-center">
							<div class="col-md-12">
								<button class="sub-btn-book btn-book" href="#">Submit</button>
							</div>
						</div>
						 <!-- <button class="btn  my-4 btn-block btn-submit-req" type="submit"></button> -->
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Enterprise Services section end  -->

<!-- Enterprise Services Section - START  -->
@if($testimonials->count())
<div class="testimonials-slider pb-4 pt-5 bg-05">
    <div class="container">
        <div class="testimonials-container">
            <h2 class="title-contain">Testimonials</h2>
            <div class="testimonials-slick-slider">
                @foreach($testimonials as $k => $testimonials)
                    <div class="card shadow-sm">
                        <div class="">
                        <img src="{{asset('assets/images/testimonial/'.$testimonials->image)}}">
                        </div>
                        <div class="ca-bd-tx">
                            <div class="d-flex bg-white text-center flex-column w-1 align-items-center serve-con-det"><?=$testimonials->title?></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif
<!-- Enterprise Services Section - END  -->


	{{-- <section id="extraData">
		<div class="text-center">
			<img src="{{asset('assets/images/'.$gs->loader)}}">
		</div>
	</section> --}}
<div class="modal fade" id="other-category-modal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-title text-center">
                    <h4>Service Request</h4>
                </div>
                <div class="d-flex flex-column">
                    <form id="frm-other-category" class="frm-other-category" data-action="{{route('front.service_request')}}" method="POST" enctype="multipart/form-data">
                        @include('includes.front.ajax-message')
                        @csrf

                        <div class="form-row form-group">
							<div class="col">
						        <input type="text" class="form-control" name="request_name" placeholder="Name" value="{{old('request_name')}}">
                                @error('request_name')
                                    <label id="request_name-error" class="error" for="request_name">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>

						<div class="form-row form-group">
							<div class="col">
								<input type="text" class="form-control" name="request_email" placeholder="E-mail" value="{{old('request_email')}}">
                                @error('request_email')
                                    <label id="request_email-error" class="error" for="request_email">{{ $message }}</label>
                                @enderror
							</div>
						</div>
                        <div class="form-row form-group">
							<div class="col">

								<input type="text" class="form-control" name="request_phone" placeholder="Phone" value="{{old('request_phone')}}">
                                @error('request_phone')
                                    <label id="request_phone-error" class="error" for="request_phone">{{ $message }}</label>
                                @enderror
							</div>
						</div>
                        <div class="form-row form-group">
							<div class="col">
						        <input type="text" class="form-control" name="request_address" placeholder="Address" value="{{old('request_address')}}">
                                @error('request_address')
                                    <label id="request_address-error" class="error" for="request_address">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row form-group">
                            <div class="col">
                                <select class="form-control" name="request_service" id="request_service">
                                    <option value="">Select Service</option>
                                    @foreach($all_services as $service)
                                    <option value="{{$service->id}}">{{$service->title}}</option>
                                    @endforeach
                                </select>
                                @error('request_service')
                                    <label id="request_service-error" class="error" for="request_service">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row form-group">
							<div class="col">
                                <textarea type="text" class="form-control" name="request_message" placeholder="Message" rows="4">{{old('request_message')}}</textarea>
                                @error('request_message')
                                    <label id="request_message-error" class="error" for="message">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>

						<div class="row btn-center text-center">
							<div class="col-md-12">
								<button class="sub-btn-book btn-book" href="#">Submit</button>
							</div>
						</div>
						 <!-- <button class="btn  my-4 btn-block btn-submit-req" type="submit"></button> -->
					</form>

                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')

    <script src="{{ asset('assets/front-assets/js/moment-with-locales.min.js') }}"></script>
    <script src="{{ asset('assets/front-assets/js/bootstrap-datetimepicker.min.js') }}"></script>

    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>


	<script>

    $(document).ready(function(){


        $('.testimonial-slider').slick({
            // autoplay: true,
            // autoplaySpeed: 1000,
            speed: 600,
            draggable: true,
            infinite: true,
            slidesToShow: 2,
            slidesToScroll: 1,
            arrows: false,
            dots: false,
            responsive: [
                {
                breakpoint: 991,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                }
                },
                {
                    breakpoint: 575,
                    settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    }
                }
            ]
        });

        $('.best-offers-slick-slider,.best-service-slick-slider,.testimonials-slick-slider').slick({
            autoplay: true,
            autoplaySpeed: 2000,
            dots: true,
            infinite: true,
            speed: 300,
            slidesToShow: 3,
            slidesToScroll: 3,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 700,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]

        });



    });

    $(".btn-book-now").click(function() {
        // $('html, body').animate({
        //     scrollTop: $(".category-block").offset().top
        // }, 1000);
        $("html, body").animate({ scrollTop: $(".category-block").offset().top-200 }, 1000);
    });
    $('.counter-value').each(function(){
        $(this).prop('Counter',0).animate({
            Counter: $(this).text()
        },{
            duration: 3500,
            easing: 'swing',
            step: function (now){
                $(this).text(Math.ceil(now));
            }
        });
    });

    $('.clear_location').click(function(){
        $('#clear-location-input').val('clear');
        $('#frm-set-location').submit();
    });
        // $(window).on('load',function() {

        //     setTimeout(function(){

        //         $('#extraData').load('{{route('front.extraIndex')}}');

        //     }, 500);
        // });

        $('#custom-visit_date').datetimepicker({
            "allowInputToggle": true,
            "showClose": true,
            "showClear": true,
            "showTodayButton": true,
            "format": "DD/MM/YYYY",
            "minDate": new Date(),
            "ignoreReadonly": true
        });
        $('#custom-visit_time').datetimepicker({
            "allowInputToggle": true,
            "showClose": true,
            "showClear": true,
            "showTodayButton": true,
            "format": "hh:mm A",
            "ignoreReadonly": true
            //"minDate": new Date()
        });

        $('#frm-referral').submit(function(){

            $('#frm-referral .error').remove();
            url = $(this).data('action');
            $.ajax({
                url : url,
                type : 'POST',
                datatype:'json',
                data : $('#frm-referral').serialize(),
                success : function(data) {

                    if(data.success){
                        $('#frm-referral').find('.alert-success').show();
                        $('#frm-referral').find('.alert-success .message-span').html(data.message);
                        $('#frm-referral')[0].reset();
                        setTimeout(function(){
                            $('#frm-referral').find('.alert-success').hide(1000);
                            $('#frm-referral').find('.alert-success .message-span').html('');
                        }, 3000);
                        // Swal.fire("Success", data.message, "success");
                    }else{

                        if(data.message){
                            $('#frm-referral').find('.alert-danger').show();
                            $('#frm-referral').find('.alert-danger .message-span').html(data.message);
                            $('#frm-referral')[0].reset();
                            setTimeout(function(){
                                $('#frm-referral').find('.alert-danger').hide(1000);
                                $('#frm-referral').find('.alert-danger .message-span').html('');
                            }, 3000);
                        }
                        if(data.errors){
                            $.each(data.errors, function(key,value){
                                $("[name='"+key+"']").after('<label id="'+key+'-error" class="error" for="'+key+'">'+value[0]+'</label>');
                            });
                        }

                    }
                }
            });
            return false;
        });

        $('#request_service').select2({
           // dropdownAutoWidth: true,
            dropdownParent: $('#other-category-modal'),
            width: '100%'
        })


        $('#frm-other-category').submit(function(){

            $('#frm-other-category .error').remove();
            url = $(this).data('action');
            $.ajax({
                url : url,
                type : 'POST',
                datatype:'json',
                data : $('#frm-other-category').serialize(),
                success : function(data) {

                    if(data.success){
                        $('#frm-other-category').find('.alert-success').show();
                        $('#frm-other-category').find('.alert-success .message-span').html(data.message);
                        $('#frm-other-category')[0].reset();
                        setTimeout(function(){
                            $('#frm-other-category').find('.alert-success').hide(1000);
                            $('#frm-other-category').find('.alert-success .message-span').html('');
                            $('#other-category-modal').modal('hide');
                        }, 3000);
                        // Swal.fire("Success", data.message, "success");
                    }else{
                        if(data.message){
                            $('#frm-other-category').find('.alert-danger').show();
                            $('#frm-other-category').find('.alert-danger .message-span').html(data.message);
                            $('#frm-other-category')[0].reset();
                            setTimeout(function(){
                                $('#frm-other-category').find('.alert-danger').hide(1000);
                                $('#frm-other-category').find('.alert-danger .message-span').html('');
                            }, 3000);
                        }
                        $.each(data.errors, function(key,value){
                            if(key == 'request_visit_date' || key == 'request_visit_time'){
                                $("[name='"+key+"']").parent().after('<label id="'+key+'-error" class="error" for="'+key+'">'+value[0]+'</label>');
                            }else if(key == 'request_service'){
                                $("[name='"+key+"']").siblings('.select2').after('<label id="'+key+'-error" class="error" for="'+key+'">'+value[0]+'</label>');
                            }else{
                                $("[name='"+key+"']").after('<label id="'+key+'-error" class="error" for="'+key+'">'+value[0]+'</label>');
                            }

                        });
                    }
                }
            });
            return false;
        });

        $('#request-a-quote').submit(function(){

            $('#request-a-quote .error').remove();
            url = $(this).data('action');
            $.ajax({
                url : url,
                type : 'POST',
                datatype:'json',
                data : $('#request-a-quote').serialize(),
                success : function(data) {

                    if(data.success){
                        $('#request-a-quote').find('.alert-success').show();
                        $('#request-a-quote').find('.alert-success .message-span').html(data.message);
                        $('#request-a-quote')[0].reset();
                        setTimeout(function(){
                            $('#request-a-quote').find('.alert-success').hide(1000);
                            $('#request-a-quote').find('.alert-success .message-span').html('');
                        }, 3000);
                        // Swal.fire("Success", data.message, "success");
                    }else{
                        if(data.message){
                            $('#request-a-quote').find('.alert-danger').show();
                            $('#request-a-quote').find('.alert-danger .message-span').html(data.message);
                            $('#request-a-quote')[0].reset();
                            setTimeout(function(){
                                $('#request-a-quote').find('.alert-danger').hide(1000);
                                $('#request-a-quote').find('.alert-danger .message-span').html('');
                            }, 3000);
                        }
                        $.each(data.errors, function(key,value){
                            if(key == 'request_visit_date' || key == 'request_visit_time'){
                                $("[name='"+key+"']").parent().after('<label id="'+key+'-error" class="error" for="'+key+'">'+value[0]+'</label>');
                            }else{
                                $("[name='"+key+"']").after('<label id="'+key+'-error" class="error" for="'+key+'">'+value[0]+'</label>');
                            }

                        });
                    }
                }
            });
            return false;
        });


        @php if ($message = Session::get('success')){ @endphp
            Swal.fire("Success", "{{$message}}", "success");

        @php } @endphp

        // $('#myCarousel').on('mouseenter','.carousel-item-content', function(){

        //     $(this).find('.on-hover').show();
        //     $(this).find('.default-show').hide();
        // });
        // $('#myCarousel').on('mouseleave','.carousel-item-content', function(){
        //     $(this).find('.on-hover').hide();
        //     $(this).find('.default-show').show();
        // });

		var searchInput = 'location_search_slider';
		var lat, lng = conuntry = state = city = zip = location_search = '';

		function set_location(result, isRedirect){
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
			$('.location_search_slider').val(location_search).focus();
			$('#lat').val(lat);
			$('#lng').val(lng);
			$('#country').val(country);
			$('#state').val(state);
			$('#city').val(city);
			$('#zip').val(zip);
            if(isRedirect){
                $('#frm-set-location').submit();
            }
		}
		$(document).ready(function () {
			var autocomplete;
            input = document.getElementsByClassName(searchInput);
            for (i = 0; i < input.length; i++) {
                autocomplete = new google.maps.places.Autocomplete((input[i]), {
					types: ['geocode']
			    });
            }
			// autocomplete = new google.maps.places.Autocomplete((document.getElementsByClassName(searchInput)), {
			// 		types: ['geocode']
			// });
			google.maps.event.addListener(autocomplete, 'place_changed', function () {
                var result = autocomplete.getPlace();
                set_location(result);
			});

			$('.location-alert').click(function(){
                Swal.fire({
                    title: 'Info',
                    text: 'Please select location',
                    icon: "info",
                    showCancelButton: false,
                    confirmButtonColor: "#ff7400",
                    confirmButtonClass: "btn btn-go",
                    closeOnConfirm: true,
                }).then(function (result) {
                    $('html, body').animate({
                        scrollTop: $(".main-slider").offset().top
                    }, 1000);
                });
			});
			$('.btn-current_location').click(function(){
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
                                    set_location(result, true);
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
		});


	</script>

@endsection
