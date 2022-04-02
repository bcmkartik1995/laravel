<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(isset($page->meta_tag) && isset($page->meta_description))
        {{-- <meta name="keywords" content="{{ $page->meta_tag }}"> --}}
        {{-- <meta name="description" content="{{ $page->meta_description }}"> --}}
		<title>{{$gs->title}}</title>
    @elseif(isset($blog->meta_tag) && isset($blog->meta_description))
        {{-- <meta name="keywords" content="{{ $blog->meta_tag }}"> --}}
        {{-- <meta name="description" content="{{ $blog->meta_description }}"> --}}
		<title>{{$gs->title}}</title>
    @else
	    {{-- <meta name="keywords" content="{{ $seo->meta_keys }}"> --}}
	    <meta name="author" content="GeniusOcean">
		<title>{{$gs->title}}</title>
    @endif
	<!-- favicon -->
	{{-- <link rel="icon"  type="image/x-icon" href="{{asset('assets/images/'.$gs->favicon)}}"/> --}}

	<link rel="apple-touch-icon" sizes="72x72" href="{{asset('assets/favicon/apple-touch-icon.png')}}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets/favicon/favicon-32x32.png')}}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/favicon/favicon-16x16.png')}}">
	<link rel="manifest" href="{{asset('assets/favicon/site.webmanifest')}}">
	<link rel="mask-icon" href="{{asset('assets/favicon/safari-pinned-tab.svg')}}" color="#5bbad5">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="theme-color" content="#ffffff">

	{{-- <link rel="shortcut icon" href="images/favicon.png"> --}}
     <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />


  	<link href="{{asset('assets/front-assets/css/flaticon.css')}}" rel="stylesheet">
    <link href="{{asset('assets/front-assets/css/fontawesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/front-assets/css/bootstrap.min.css')}}">

    <link rel="stylesheet" src="{{ asset('assets/front-assets/css/plugin/sweetalert/sweetalert2.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/app-assets/vendors/css/forms/select/select2.min.css') }}">
    <!-- Site CSS -->
    <!-- <link rel="stylesheet" href="style.css"> -->
    <link rel="stylesheet" href="{{asset('assets/front-assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/front-assets/css/extra.css')}}">


	@yield('styles')

</head>

<body>

@if($gs->is_loader == 1)
	{{--  --}}
@endif

<div class="preloader" id="preloader" style="background: url({{asset('assets/images/'.$gs->loader)}}) no-repeat scroll center center #FFF;"></div>
<!-- top header section -->

<div class="velox-header">
	<div class="main-header">
		<div class="header-top">
			<div class="container pl-0">
				<div class="top-outer ">
					<div class="d-flex justify-content-between align-items-center">
						<ul class="top-left">
								<li class="icons pb-2 "><i class="fa fa-comment-dots"></i></span>&nbsp;24 Hour Service - 7 Days a Week</li>
								<li class="icons"><i class="fas fa-phone-alt"></i>&nbsp;<a href="tel:+919714 883 884">+91 9714 883 884</a> &nbsp;<i class="fas fa-phone-alt"></i>&nbsp;<a href="tel:+9190 818 818 89">+91 90 818 818 89</a></li>
						</ul>
						<ul class="social-icon d-flex">
							<li class=""><a href="https://twitter.com/SolutionVelox" target="_blank"><img class="icon" src="{{asset('assets/front-assets/images/social/twitter.png')}}"></a></li>
							<li><a class="" href="https://www.facebook.com/profile.php?id=100073738320376" target="_blank"><img class="icon" src="{{asset('assets/front-assets/images/social/fb1.png')}}"></a></li>
							<li><a class="" href="https://www.linkedin.com/in/velox-solution-bb5075223/" target="_blank"><img class="icon" src="{{asset('assets/front-assets/images/social/in.png')}}"></a></li>
							<li><a class="" href="https://www.instagram.com/veloxsolution/" target="_blank"><img class="icon" src="{{asset('assets/front-assets/images/social/instagram.png')}}"></a></li>
                            {{-- <li><a class="" href="#"><img class="icon" src="{{asset('assets/front-assets/images/social/youtube.png')}}"></a></li> --}}
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- top header end -->

	<!-- menubar section -->

	<div class="top-navbar top-navbar-head">
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<div class="container">
				<a class="navbar-brand" href="{{url('/')}}">
					<img src="{{asset('assets/front-assets/images/logo.png')}}" class="main-logo-dark" alt="" />
                    <img src="{{asset('assets/front-assets/images/logo_1.png')}}" class="main-logo-light" alt="" />
				</a>
				<div class="mobile-login">
					<div class="dropdown custom-header-link pay-sp">
                        <a onclick="go_to_cart();" href="javascript:void(0);"  type="button" data-toggle="dropdown" aria-haspopup="true=" aria-expanded="false">
						<i class="fa fa-shopping-cart fa-lg">
						<span class="badge badge-pill  crt-dang cart-item-count-badge">{{$session_cart['total_items']}}</span> </i>
                        </a>

						<div class="dropdown-menu dropdown-menu-right dropdown-cart dr-cart-ft cart-container" role="menu"  >

							@include('load.cart')

						</div>

					</div>
                    @include('load.payment-links')

					<div class="navbar-nav login-header">
						<a href="#" class="nav-item nav-link active" id="btn-login" data-toggle="modal" data-target="#login-confirm">Login</a>
						<!-- <img class="d-none d-sm-block" src="{{asset('assets/front-assets/images/s01.png')}}"> --><span class=" mn-sl align-self-center">/</span>
						<a href="#" class="nav-item nav-link mr-0 " id="btn-register" data-toggle="modal" data-target="#sign_in">Sign Up</a>
					</div>
				</div>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbars-host" aria-controls="navbars-rs-food" aria-expanded="false" aria-label="Toggle navigation">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbars-host">
					<ul class="navbar-nav ">
						<li class="nav-item {{Route::is('front.index')?'active':''}}"><a class="nav-link" href="{{ route('front.index') }}">Home</a></li>
						<li class="nav-item {{Route::is('front.about')?'active':''}}"><a class="nav-link" href="{{ route('front.about') }}">About</a></li>
						<li class="nav-item {{Route::is('front.registerprofessional')?'active':''}}"><a class="nav-link" href="{{ route('front.registerprofessional') }}">Register as a Professional </a></li>
						<li class="nav-item {{Route::is('front.blog')?'active':''}}"><a class="nav-link" href="{{ route('front.blog') }}">Blogs</a></li>
						<li class="nav-item {{Route::is('front.contact_us')?'active':''}}"><a class="nav-link" href="{{ route('front.contact_us') }}">Contact Us</a></li>
					</ul>
					@if(!Auth::guard('web')->check())
					<ul class=" navbar-nav navbar-right ml-auto "> </ul>

                        @include('load.location-search-form')
                        @include('load.sticky-search-form')

					<div class="dropdown custom-header-link pay-sp ">
                        <a onclick="go_to_cart();" href="javascript:void(0);"  type="button" data-toggle="dropdown" aria-haspopup="true=" aria-expanded="false">
                            <i class="fa fa-shopping-cart fa-lg">
                                <span class="badge badge-pill  crt-dang cart-item-count-badge">{{$session_cart['total_items']}}</span> </i>
                        </a>
						<div class="dropdown-menu dropdown-menu-right dropdown-menu-left dropdown-cart dr-cart-ft cart-container" role="menu"  >

							@include('load.cart')

						</div>
					</div>
					<div class="navbar-nav login-header">
						<a href="#" class="nav-item nav-link active" id="btn-login" data-toggle="modal" data-target="#login-confirm">Login</a>
						<!-- <img class="d-none d-sm-block" src="{{asset('assets/front-assets/images/s01.png')}}"> --><span class=" mn-sl align-self-center">/</span>
						<a href="#" class="nav-item nav-link mr-0 " id="btn-register" data-toggle="modal" data-target="#sign_in">Sign Up</a>
					</div>
					@else

						<ul class=" navbar-nav navbar-right ml-auto "> </ul>
                        @include('load.location-search-form')
                        @include('load.sticky-search-form')
						<div class="dropdown custom-header-link pay-sp">
                            <a onclick="go_to_cart();" href="javascript:void(0);"  type="button" data-toggle="dropdown" aria-haspopup="true=" aria-expanded="false">
							<i class="fa fa-shopping-cart fa-lg">
							<span class="badge badge-pill  crt-dang cart-item-count-badge">{{$session_cart['total_items']}}</span> </i>
                            </a>

							<div class="dropdown-menu dropdown-menu-right dropdown-cart dr-cart-ft cart-container" role="menu"  >

								@include('load.cart')

							</div>
						</div>

						@include('load.payment-links')
						<div class="profile-img1 dropdown pay-sp">
							<a class="dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<img  src="{{asset('assets/images/' . (Auth::user()->photo ? 'users/'.Auth::user()->photo : 'profile.png'))}}">
								<span class="d-inline pr-2">{{Auth::user()->name}}</span>
							</a>
							<div class="dropdown-menu ">
								<a class="dropdown-item mb-2 " href="{{ route('user-dashboard') }}">Dashboard</a>
								<a class="dropdown-item mb-2 " href="{{ route('mycart') }}">Mycart</a>
								{{-- <a class="dropdown-item mb-2 " href="#">Edit Profile</a> --}}
								<a class="dropdown-item mb-2" href="{{ route('user-logout') }}">Logout</a>
							</div>
						</div>
					@endif

				</div>
			</div>
		</nav>
	</div>
<!-- menubar section end -->
</div>

@yield('content')

	<!-- footer section  -->
	<footer id="tt-footer">
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-sm-12 col-12">
					<div class="footer-item">
					<div class="f-logo-image">
						<img src="{{asset('assets/front-assets/images/logo_1.png')}}">
					</div>
					<p>We provides better home service by professional you never seen before.</p>
					</div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-12">
                            <ul class="social-icons">
                                <li class="list-inline-item"><a class="icon1"  href="https://twitter.com/SolutionVelox" target="_blank"><img class="icon" src="{{asset('assets/front-assets/images/social/twitter.png')}}"></a></li>
                                <li class="list-inline-item"><a class="icon1" href="https://www.facebook.com/profile.php?id=100073738320376" target="_blank"><img class="icon" src="{{asset('assets/front-assets/images/social/fb1.png')}}"></a></li>
                                <li class="list-inline-item"><a class="icon1" href="https://www.linkedin.com/in/velox-solution-bb5075223/" target="_blank"><img class="icon" src="{{asset('assets/front-assets/images/social/in.png')}}"></a></li>
                                <li class="list-inline-item"><a class="icon1" href="https://www.instagram.com/veloxsolution/" target="_blank"><img class="icon" src="{{asset('assets/front-assets/images/social/instagram.png')}}"></a>
                                </li>
								<li class="list-inline-item"><a class="icon1" href="https://www.youtube.com/channel/UC8hIf0fZgq-_UYHFfLWQMOg/featured" target="_blank"><img class="icon" src="{{asset('assets/front-assets/images/social/youtube.png')}}"></a>
                                </li>
                                {{-- <li class="list-inline-item"><a class="icon1" href="#" target="_blank"><img class="icon" src="{{asset('assets/front-assets/images/social/youtube.png')}}"></a>
                                </li> --}}
                            </ul>
                        </div>
                    </div>
				</div>
				<div class="col-md-4 col-sm-12 col-12">
                    <div class="footer-item">
                        <h5 class="footer-title">Contact Us</h5>
					   	<ul>
							<li>
								<div>
									<img src="{{asset('assets/front-assets/images/1.png')}}" width="15px">
								</div>
								<p class="mb-0">S-06, 2<sup>nd</sup> Floor, Momai Complex, Near Blue Club, Khodiyar Colony, Aerodrome Road Jamnagar 361001</p>
							</li>
							<li>
								<div>
									<img src="{{asset('assets/front-assets/images/2.png')}}" width="15px">
								</div>
								<p class="mb-0"><a href="tel:+919714 883 884">+91 9714 883 884</a></p>
							</li>
							<li>
								<div>
									<img src="{{asset('assets/front-assets/images/2.png')}}" width="15px">
								</div>
								<p class="mb-0"><a href="tel:+91 90 818 818 89">+91 90 818 818 89</a></p>
							</li>
							<li>
								<div>
									<img src="{{asset('assets/front-assets/images/0.png')}}" width="15px">
								</div>
								<p class="mb-0"><a href="mailto:veloxsolutionpvtltd@gmail.com">veloxsolutionpvtltd@gmail.com</a></p>
							</li>
						</ul>
                    </div>
				</div>
				<div class="col-md-4 col-sm-12 col-12">
						<div class="footer-item">
						<h5 class="footer-title">Newsletters</h5>
							<p>Sign Up to Receive more tips and Coupons for our Services.</p>

							<form id="frm_subscribe_form" method="POST" data-action="{{route('subscribe_form')}}">
                                @include('includes.front.ajax-message')
                                @csrf
								<div class="d-flex">
									<div class="form-group mb-0 w-100">
										<input type="text"  class="form-controls" name="email"  id="subscribe-email" placeholder="Enter your Email">
									</div>

									<div class="subscribe-btn">
										<button class="subscribe-btn-text btn-subscribe" >Subscribe</button>
									</div>
								</div>
							</form>
						</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 ">
					<p class="serving-in">Serving in</p>
				</div>

			</div>
			@if($serving_countries->count())
				@php
				$i = 0;
				@endphp
				@foreach($serving_countries as $country => $cities)

					<div class="row justify-content-start pl-3">
						<div class="country-item">
							<p class="country-head">{{$country}}</p>
						</div>
                        @foreach ($cities as $city)
						    <p class="city-contain">{{$city->city}}</p>
                        @endforeach
					</div>

				@endforeach
			@endif

            <div class="row justify-content-start footer-links">
                <ul>
                    <li>
                        <a href="{{route('front.terms-and-conditions')}}" target="_blank">Terms & Conditions</a>
                    </li>
                    <li>
                        <a href="{{route('front.return-refund-policy')}}" target="_blank">Return & Refund Policy</a>
                    </li>
                    <li>
                        <a href="{{route('front.privacy-policy')}}" target="_blank">Privacy Policy</a>
                    </li>
                    <li>
                        <a href="{{route('front.eula')}}" target="_blank">End-User License Agreement</a>
                    </li>
                    <li>
                        <a href="{{route('front.disclaimer')}}" target="_blank">Disclaimer</a>
                    </li>
                    <li>
                        <a href="{{route('front.cookie-policy')}}" target="_blank">Cookie Policy</a>
                    </li>

                </ul>

            </div>

			<div class="row pt-2 f-bottam">
						<p class="mb-0">Copyright &#169; 2021 All Rights Reserved </p>
			</div>
		</div>
	</footer>
<!-- footer section  end -->


<!--    Login modal -->
<div class="modal fade" id="login" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header border-bottom-0">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-title text-center">
					<h4>Login to your account</h4>
				</div>
				<div class="d-flex flex-column text-center">
                    @include('includes.front.form-login')
					<form id="post-form-login" data-action="{{ route('userLogin') }}" method="POST">
                        @csrf
						<div class="form-group pb-2 pt-2">
						  <input type="text" class="form-control" name="phone" id="phone" placeholder="Your email or phone" onchange="verify_mobile()">
						</div>
						<div class="form-group pb-2 login_pwd" style="display: none;">
						  <input type="password" class="form-control" name="password" id="password1" placeholder="Your password">
						</div>
						<div class="f-pass" style="float: left;">
                            <a href="javascript:void(0);" id="login-with-pass" style="display: none;" onclick="login_with_pwd()"> Login with password</a>
                        </div>
                        <div class="f-pass">
                            <a href="javascript:void(0);" id="btn-forgot-pass"> Forgot Password?</a></div>
                        </div>
                        <input id="authdata" type="hidden"  value="{{ __('Authenticating...') }}">
						<div class="text-center">
							<button type="button" class="btn btn-sub-lg lg-btn" id="verify_mobile_btn" onclick="verify_mobile()">Continue</button>
							<button type="button" class="btn btn-sub-lg lg-btn" id="login_with_otp" style="display: none;" onclick="otp_login_modal()">Login with OTP</button>
							<button type="submit" class="btn btn-sub-lg lg-btn" id="loginfrm_btn" style="display: none;">Login</button>
						</div>
						 <!-- <button type="button" class="btn btn-secondary float-right mt-5 " data-dismiss="modal">Close</button> -->
					</form>

				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="otp_login" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="background-color: rgb(17 17 17 / 67%);">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header border-bottom-0">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-title text-center">
					<h4>Login to your account</h4>
				</div>
				<div class="d-flex flex-column text-center">
                    @include('includes.front.form-login')
					<form id="post-form-otp-login" action="{{ route('userOtpLogin') }}" method="POST">
                        @csrf
						<input type="hidden" class="form-control" name="otp_phone" id="otp_phone">
						<input type="hidden" class="form-control" name="send_otp" id="send_otp">
						<div class="form-group pb-2">
						  <input type="text" class="form-control" name="user_otp" id="user_otp" placeholder="Enter OTP" required>
						</div>
                        <input id="authdata1" type="hidden"  value="{{ __('Authenticating...') }}">
						<div class="text-center">
						<button type="button" class="btn btn-sub-lg lg-btn" id="otploginfrm_btn" onclick="submit_otp_form()">Login</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="forgot-pass-modal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header border-bottom-0">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-title text-center">
					<h4>Reset Password</h4>
				</div>
				<div class="d-flex flex-column text-center">
                    @include('includes.front.form-login')
					<form id="frm-forgot-pass" data-action="{{ route('password.email') }}" method="POST">
                        @csrf
						<div class="form-group pb-2 pt-2">
						  <input type="email" class="form-control" name="email" id="email1"placeholder="Your email ">
						</div>

						<button type="submit" class=" btn btn-sub-lg lg-btn submit-btn text-center">Send Password Reset Link</button>
						 <!-- <button type="button" class="btn btn-secondary float-right mt-5 " data-dismiss="modal">Close</button> -->
					</form>

				</div>
			</div>
		</div>
	</div>
</div>
<!--    Login modal end -->
<!-- sign in modal-->
<div class="modal fade" id="sign_in" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header border-bottom-0">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-title text-center">
					<h4>Sign up to your account</h4>
				</div>
				<div class="d-flex flex-column text-center">
					@include('includes.front.form-login')
					<form id="send_form" data-action="{{ route('userRegister') }}" method="POST">
                        @csrf
						<div class="form-group pb-2 pt-5">
						  <input type="text" class="form-control" name="name" id="name" placeholder=" Your Name">
						</div>
						<div class="form-group pb-2">
						  <input type="email" class="form-control" name="email" id="email1" placeholder="Your Email">
						</div>
						<div class="form-group pb-2">
						  <input type="text" class="form-control" name="phone" id="phone" placeholder=" Your Mobile No ">
						</div>
						<div class="form-group pb-2">
							<select name="city" class="form-control">
								<option value="" selected>Select City</option>
								@foreach($all_cities as $city)
									<option value="{{ $city->id }}">{{ $city->name }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group pb-2">
						  <input type="password" class="form-control" name="password" id="password" placeholder="Your password">
						</div>
						<div class="form-group pb-2">
						   <input type="password" class="form-control" name="confirm_password" id="reset" placeholder="Your Confirm">
						</div>

                        <button type="submit" class=" btn btn-sub-lg lg-btn ">Sign in</button>
						 <!-- <button type="button" class="btn btn-secondary float-right mt-5 " data-dismiss="modal">Close</button> -->
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- sign in modal end-->

<div class="modal fade" id="login-confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header border-bottom-0">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-title text-center">
					<h4>Login as a</h4>
				</div>
				<div class="d-flex flex-column">
                    <div class="form-group pb-2 pt-5">
                        <select name="" id="login_type" class="form-control">
                            <option value="">Select Login Type</option>
                            <option value="customer">Customer</option>
                            <option value="franchise">Franchise</option>
                        </select>
                    </div>
                    <button type="button" class=" btn btn-sub-lg lg-btn confirm-login-type">Confirm</button>
				</div>
			</div>
		</div>
	</div>
</div>

@php
    $is_scroll_to_category = false;
    if(session()->has('is_scroll_to_category')){
        session()->forget('is_scroll_to_category');
        $is_scroll_to_category = true;
    }
@endphp


<script src="{{asset('assets/front-assets/js/all.js')}}"></script>
<script src="{{asset('assets/front-assets/js/carousel.js')}}"></script>
<script src="{{asset('js/ajax_handling.js')}}"></script>
<script defer="defer" src="{{ asset('assets/front-assets/js/common.js') }}"></script>
<script src="{{ asset('assets/front-assets/js/plugin/sweetalert/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets/front-assets/js/plugin/typeahead/bootstrap3-typeahead.min.js') }}"></script>

<script src="{{ asset('assets/admin-assets/app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key={{env('GOOGLE_API_KEY')}}"></script>

@yield('scripts')
<script>

	function verify_mobile()
    {
        var phone = $('#phone').val();
        $.ajax({
            url:"{{route('verify_mobile')}}",
            method:"POST",
            data:{phone:phone, _token:"{{ csrf_token() }}"},
            success: function (data) 
            {
            	console.log(data);
                if ((data.error)) 
                {
                    $('.alert-success').hide();
                    $('.alert-info').hide();
                    $('.alert-danger').show();
                    $('.alert-danger ul').html('');
                    $('.alert-danger span.text-left').html('User not registered');
                } 
                else 
                {
                    $('.alert-info').hide();
                    $('.alert-danger').hide();
                    $('.alert-success').show();
                    $('.alert-success span.text-left').html('Success !');
                    $('#verify_mobile_btn').hide();
                    $('#login-with-pass').show();
                    $('#login_with_otp').show();
                }
            }
        });
    }

    function login_with_pwd()
    {
    	$('#verify_mobile_btn').hide();
    	$('#login_with_otp').hide();
    	$('#login-with-pass').hide();
    	$('#loginfrm_btn').show();
    	$('.login_pwd').show();
    }

    function otp_login_modal()
    {
    	$('.alert-success').hide();
    	$('.alert-info').hide();
    	$('.alert-danger').hide();
    	var phone = $('#phone').val();
    	var otp = Math.floor(1000 + Math.random() * 9000);
    	$.ajax({
            url:"{{route('send_otp')}}",
            method:"POST",
            data:{phone:phone,otp:otp, _token:"{{ csrf_token() }}"},
            success: function (data) 
            {
            	console.log(data);
                if((data.error)) 
                {
                    $('.alert-success').hide();
                    $('.alert-info').hide();
                    $('.alert-danger').show();
                    $('.alert-danger ul').html('');
                    $('.alert-danger span.text-left').html('Please Try Again...!');
                } 
                else 
                {
                    $('.alert-info').hide();
                    $('.alert-danger').hide();
                    $("#login").modal('hide');
    				$("#otp_login").modal('show');
    				$('#send_otp').val(otp);
					$('#otp_phone').val(phone);
                }
            },
            error: function (data) 
            {
                $('.alert-info').hide();
                $('.alert-danger').hide();
                $("#login").modal('hide');
				$("#otp_login").modal('show');
				$('#send_otp').val(otp);
				$('#otp_phone').val(phone);
			}
        });
    }

    function submit_otp_form()
    {
    	var send_otp = $('#send_otp').val();
    	var user_otp = $('#user_otp').val();
    	if(send_otp != user_otp)
    	{
    		$('.alert-success').hide();
            $('.alert-info').hide();
            $('.alert-danger').show();
            $('.alert-danger ul').html('');
            $('.alert-danger span.text-left').html('OTP not verified');
            return false;
    	}
    	$("#post-form-otp-login").submit();
    }
    
    var isIndexPage = "{{Route::is('front.index')}}";
    var isIndexPageUrl = "{{route('front.index')}}";
    var isIndex = isIndexPage ? true : false;

    // var isIndex = {{Route::is('front.index') == true}} ? true : false;
    $('.main-logo-light').hide();
	$(window).scroll(function() {
        var scroll = $(window).scrollTop();
        if (scroll > 100) {
            $("body").addClass("sticky-header");
            $('.main-logo-light').show();
            $('.main-logo-dark').hide();
        } else {
            $("body").removeClass("sticky-header");
            $('.main-logo-light').hide();
            $('.main-logo-dark').show();
        }

    });

    is_scroll_to_category = "{{$is_scroll_to_category}}";
    if(is_scroll_to_category){
        $("html, body").animate({ scrollTop: $(".category-block").offset().top-200 }, 1000);
    }
</script>
<script>
$('.confirm-login-type').click(function(){
    login_type = $('#login_type').val();
    $('#login-confirm').find('.error.login_type').remove();
    if(login_type){
        if(login_type == 'customer'){
            $('#login-confirm').modal('hide');
            $('#login_type').val('');
            $('#login').modal('show');
        }else{
            window.location.href = "{{route('admin.login')}}";
        }
    }else{
        $("#login_type").after('<label id="login_type-error" class="error login_type" for="login_type">Please select login type</label>');
    }
});

$('.counter-inner .counter').each(function() {
    var $this = $(this),
        countTo = $this.attr('data-count');
    $({ countNum: $this.text()}).animate({
        countNum: countTo
    },
    {
        duration: 8000,
        easing:'linear',
        step: function() {
        $this.text(Math.floor(this.countNum));
        },
        complete: function() {
        $this.text(this.countNum);
        //alert('finished');
        }
    });
});


var searchInputHeader = 'header_location_search';
var lat, lng = conuntry = state = city = zip = header_location_search = '';

function set_header_location(result, isRedirect){
    // console.log(result)
    header_location_search = result.formatted_address;

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
    $('#header_location_search').val(header_location_search).focus();
    $('#header_lat').val(lat);
    $('#header_lng').val(lng);
    $('#header_country').val(country);
    $('#header_state').val(state);
    $('#header_city').val(city);
    $('#header_zip').val(zip);
    if(isRedirect){
        $('#frm-set-header-location').submit();
    }
}
$(document).ready(function () {
    var autocomplete;
    autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInputHeader)), {
            types: ['geocode']
    });
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        var result = autocomplete.getPlace();
        set_header_location(result);
    });

    $('.btn-header-search-location').click(function(){
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
                            set_header_location(result, true);
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
</body>

</html>
