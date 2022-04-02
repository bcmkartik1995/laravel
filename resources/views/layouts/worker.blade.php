<!doctype html>
<html lang="en" dir="ltr">

<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="author" content="GeniusOcean">
    	<meta name="csrf-token" content="{{ csrf_token() }}">
		<!-- Title -->
		<title>{{$gs->title}}</title>

		<link rel="apple-touch-icon" sizes="72x72" href="{{asset('assets/favicon/apple-touch-icon.png')}}">
		<link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets/favicon/favicon-32x32.png')}}">
		<link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/favicon/favicon-16x16.png')}}">
		<link rel="manifest" href="{{asset('assets/favicon/site.webmanifest')}}">
		<link rel="mask-icon" href="{{asset('assets/favicon/safari-pinned-tab.svg')}}" color="#5bbad5">
		<meta name="msapplication-TileColor" content="#da532c">
		<meta name="theme-color" content="#ffffff">

	    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet">

	    <!-- BEGIN: Vendor CSS-->
	    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/app-assets/vendors/css/vendors.min.css') }}">
	    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/app-assets/vendors/css/charts/apexcharts.css') }}">
	    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/app-assets/vendors/css/extensions/swiper.min.css') }}">
	    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
	    <!-- END: Vendor CSS-->

	    <!-- BEGIN: Theme CSS-->
	    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/app-assets/css/bootstrap.css') }}">
	    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/app-assets/css/bootstrap-extended.css') }}">
	    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/app-assets/css/colors.css') }}">
	    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/app-assets/css/components.css') }}">
	    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/app-assets/css/themes/dark-layout.css') }}">
	    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/app-assets/css/themes/semi-dark-layout.css') }}">
	    <!-- END: Theme CSS-->

	    <!-- BEGIN: Page CSS-->
	    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/app-assets/css/core/menu/menu-types/vertical-menu.css') }}">
	    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/app-assets/css/pages/authentication.css') }}">
	    <!-- END: Page CSS-->

	    <!-- BEGIN: Custom CSS-->
	    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/assets/css/style.css') }}">
	    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/css/common.css') }}">
	    <!-- END: Custom CSS-->

	    <!-- map css styles -->
	    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/css/map.css') }}" />

	    <!-- Sweet Alert -->
	    <link href="{{ asset('assets/admin-assets/css/plugin/sweetalert/sweetalert2.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/app-assets/vendors/css/forms/select/select2.min.css') }}">

		@yield('styles')

	</head>
	<body class="vertical-layout vertical-menu-modern semi-dark-layout 2-columns  navbar-sticky footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" data-layout="semi-dark-layout">
		<!-- BEGIN: Header-->
    <div class="header-navbar-shadow"></div>
    <nav class="header-navbar main-header-navbar navbar-expand-lg navbar navbar-with-menu fixed-top">
        <div class="navbar-wrapper">
            <div class="navbar-container content">
                <div class="navbar-collapse" id="navbar-mobile">
                    <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                        <ul class="nav navbar-nav">
                            <li class="nav-item mobile-menu d-xl-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ficon bx bx-menu"></i></a></li>
                        </ul>
                    </div>
                    <ul class="nav navbar-nav float-right">
						<li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon bx bx-bell bx-tada bx-flip-horizontal"></i><span class="badge badge-pill badge-danger badge-up notification-badge">0</span></a>
                            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                                <li class="dropdown-menu-header">
                                    <div class="dropdown-header px-1 py-75 d-flex justify-content-between">
										<span class="notification-title">0 new Notification</span>
										<span class="text-bold-400 cursor-pointer read-all-notification-link hidden">Mark all as read</span>
									</div>
                                </li>
                                <li class="scrollable-container media-list" id="show-notification">
                                    <!-- <div class="d-flex justify-content-between read-notification cursor-pointer">
                                        <div class="media d-flex align-items-center">
                                            <div class="media-left pr-0">
                                                <div class="avatar mr-1 m-0"><img src="" alt="avatar" height="39" width="39"></div>
                                            </div>
                                            <div class="media-body notification-txt">
                                                <small class="notification-text"></small>
                                            </div>
                                        </div>
                                    </div> -->
                                </li>
                                {{-- <li class="dropdown-menu-footer"><a class="dropdown-item p-50 text-primary justify-content-center" href="javascript:void(0)">Read all notifications</a></li> --}}
                            </ul>
                        </li>
                        <li class="dropdown dropdown-user nav-item">
							<a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                                <div class="user-nav d-sm-flex d-none">
									<span class="user-name">{{  Auth::guard('worker')->user()->name }}</span>
									<span class="user-status text-muted"></span>
								</div>
								<span><img class="round" src="{{ Auth::guard('worker')->user()->photo == '' ? asset('assets/admin-assets/app-assets/images/portrait/small/avatar.png') : asset('assets/images/admins') .'/'. Auth::guard('worker')->user()->photo }}" alt="avatar" height="40" width="40"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right pb-0">
                              <a class="dropdown-item" href="{{ route('worker.profile') }}"><i class="bx bx-user mr-50"></i> Edit Profile</a>
							  <div class="dropdown-divider mb-0 mt-0"></div>
							  <a class="dropdown-item mb-25" href="{{ route('worker.password') }}"><i class="bx bxs-lock mr-50"></i>Change Password</a>
                              <div class="dropdown-divider mb-0 mt-0"></div>
							  <a class="dropdown-item" href="{{ route('worker.logout') }}"><i class="bx bx-power-off mr-50"></i> Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- END: Header-->
    <!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto">
                	<a class="navbar-brand" href="{{ route('worker.dashboard') }}">
                        <div class="brand-logo"><img class="logo" src="{{ asset('assets/images/logo_text1.png') }}" />
                        </div>
                    </a>
                </li>
                <li class="nav-item nav-toggle">
                	<a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
	                	<i class="bx bx-x d-block d-xl-none font-medium-4 primary"></i>
	                	<i class="toggle-icon bx bx-disc font-medium-4 d-none d-xl-block primary" data-ticon="bx-disc"></i>
                    </a>
                </li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation"
                data-icon-style="lines">
                @include('includes.worker.normal')
            </ul>
        </div>
    </div>
    <!-- END: Main Menu-->
    @yield('content')


    <div class="sidenav-overlay"></div>
	<div class="drag-target"></div>

	<!-- BEGIN: Footer-->
	<footer class="footer footer-static footer-light">
	    <p class="clearfix mb-0">
	      <span class="float-left d-inline-block">2021 &copy; Veloxsolution</span>
	      <span class="float-right d-sm-inline-block d-none">Crafted with<i class="bx bxs-heart pink mx-50 font-small-3"></i>by<a class="text-uppercase" href="#">Veloxsolution</a></span>
	        <button class="btn btn-primary btn-icon scroll-top" type="button"><i class="bx bx-up-arrow-alt"></i></button>
	    </p>
	</footer>
	<!-- END: Footer-->
		<script type="text/javascript">
		  var mainurl = "{{url('/')}}";
		  var admin_loader = {{ $gs->is_admin_loader }};
		  var whole_sell = {{ $gs->wholesell }};
		  var getattrUrl = '{{ route('admin-prod-getattributes') }}';
			// console.log(curr);
		</script>

	<!-- Dashboard Core -->


		<!--   Core JS Files   -->

		  <script> window.baseUrl = "{{ asset('assets/admin-assets/app-assets/fonts/LivIconsEvo/svg/') }}";</script>
		  <!-- BEGIN: Vendor JS-->
		  <script src="{{ asset('assets/admin-assets/app-assets/vendors/js/vendors.min.js') }}"></script>
		  <script src="{{ asset('assets/admin-assets/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.js') }}"></script>
		  <script src="{{ asset('assets/admin-assets/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.js') }}"></script>
		  <script src="{{ asset('assets/admin-assets/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js') }}"></script>
		  <!-- BEGIN Vendor JS-->

		  <!-- BEGIN: Page Vendor JS-->
		  <script src="{{ asset('assets/admin-assets/app-assets/vendors/js/tables/datatable/datatables.min.js') }}"></script>
		  <script src="{{ asset('assets/admin-assets/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js') }}"></script>
		  <script src="{{ asset('assets/admin-assets/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js') }}"></script>
		  <script src="{{ asset('assets/admin-assets/app-assets/vendors/js/charts/apexcharts.min.js') }}"></script>
		  <script src="{{ asset('assets/admin-assets/app-assets/vendors/js/extensions/swiper.min.js') }}"></script>
		  <!-- END: Page Vendor JS-->

		  <!-- BEGIN: Theme JS-->
		  <script src="{{ asset('assets/admin-assets/app-assets/js/scripts/configs/vertical-menu-dark.js') }}"></script>
		  <script src="{{ asset('assets/admin-assets/app-assets/js/core/app-menu.js') }}"></script>
		  <script src="{{ asset('assets/admin-assets/app-assets/js/core/app.js') }}"></script>
		  <script src="{{ asset('assets/admin-assets/app-assets/js/scripts/components.js') }}"></script>
		  <script src="{{ asset('assets/admin-assets/app-assets/js/scripts/footer.js') }}"></script>
		  <!-- END: Theme JS-->

		  <!-- BEGIN: Page JS-->
		  <script src="{{ asset('assets/admin-assets/app-assets/js/scripts/datatables/datatable.js') }}"></script>
		  <!-- END: Page JS-->

		  <!-- Sweet Alert -->
		  <script src="{{ asset('assets/admin-assets/js/plugin/sweetalert/sweetalert2.all.min.js') }}"></script>

          <script src="{{ asset('assets/admin-assets/app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>

          <script src="{{asset('js/ajax_handling.js')}}"></script>

		  <!-- status active and inactive script -->
		  <script src="{{ asset('assets/admin-assets/js/admin/toggle-status.js') }}"></script>

		  <!-- ajax script -->
		  <script src="{{ asset('assets/admin-assets/js/admin/admin-common.js') }}"></script>
		  <script src="{{ asset('assets/admin-assets/js/admin/package.js') }}"></script>
		  <script src="{{ asset('assets/admin-assets/js/admin/lead.js') }}"></script>
		  <script src="{{ asset('assets/admin-assets/js/admin/offer.js') }}"></script>
		  <script src="{{ asset('assets/admin-assets/js/admin/booking.js') }}"></script>
		  <script src="{{ asset('assets/admin-assets/js/admin/franchise.js') }}"></script>
		  <!-- <script src="{{ asset('assets/admin-assets/js/admin/franchises-order.js') }}"></script> -->
		  <script src="{{ asset('assets/admin-assets/js/admin/assign-franchises.js') }}"></script>


		  <!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->


		  <!-- map js -->
		  <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
		  <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
		  <!-- <script
		      src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&callback=initMap&libraries=&v=weekly"
		      async
		    ></script>
		  <script src="{{ asset('assets/admin-assets/js/admin/map.js') }}"></script> -->


		  <script>
			  function get_notification(){
				var url = "{{URL('notificationData')}}";
				$.ajax({
					url: "{{ route('worker.get-notification') }}",
					type: "POST",
					data:{
						_token:'{{ csrf_token() }}'
					},
					cache: false,
					dataType: 'json',
					success: function(dataResult){
						console.log(dataResult);
						// $.each(dataResult, function (inedx, subcatObj) {
						// 	//console.log(subcatObj.title);
						// 	$('.show-notification .notification-txt').append('<small class="notification-text">' + subcatObj.message + '</small>');
						// 	//$('#o_sub_category_id').trigger('change');
						// });
						var resultData = dataResult.data;

						var bodyData = '';

						$.each(resultData,function(index,row){
							
							route_url =  row.type == 'unallocated service' ? "{{ route('worker.orders') }}" : "{{ route('worker.orders') }}";
							//console.log(route_url);
							bodyData+='<a href="'+route_url+'" data-id="'+row.id+'" class="read-single-notification-link"><div class="d-flex justify-content-between read-notification cursor-pointer"><div class="media d-flex align-items-center"><div class="media-left pr-0"><div class="avatar mr-1 m-0"><img src="{{ asset("assets/admin-assets/app-assets/images/notification/cart-3.png") }}" alt="avatar" height="39" width="39"></div></div><div class="media-body notification-txt">'
							bodyData+='<span class="text-bold-500">'+ row.message +'</span><h6><small class="notification-text">'+row.published+'</small>';
							bodyData+='</div></div></div></a>';

						});

						$('.notification-title').html(resultData.length+" new Notification");
						$('.notification-badge').html(resultData.length);

						if(resultData.length){
							$('.read-all-notification-link').removeClass('hidden');
						}else{
							$('.read-all-notification-link').addClass('hidden')
						}
						$("#show-notification").html(bodyData);
						
					}
				});
			}

			$("#show-notification").delegate('.read-single-notification-link', 'click', function(){
				id = $(this).data('id');
				var action = $(this).attr('href');
				//console.log(action);
				$.ajax({
					url: "{{ route('worker.read-notification') }}",
					type: "POST",
					data:{
						_token:'{{ csrf_token() }}',
						read_action:'single',
						id:id
					},
					cache: false,
					dataType: 'json',
					success: function(data){
						if(data.success){
							window.location.href = action;
							get_notification();
						}
					}
				});
				return false;
			});

			$(".read-all-notification-link").click(function(){
				$.ajax({
					url: "{{ route('worker.read-notification') }}",
					type: "POST",
					data:{
						_token:'{{ csrf_token() }}',
						read_action:'all'
					},
					cache: false,
					dataType: 'json',
					success: function(data){
						if(data.success){
							get_notification();
						}
					}
				});
			});

			
			$(document).ready(function() {
				get_notification();
				setInterval(function(){
				  get_notification();
				}, 10000);

			});
		  </script>
		@yield('scripts')


	</body>
</html>
