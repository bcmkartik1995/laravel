<!doctype html>
<html lang="en" dir="ltr">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description"
        content="Frest admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Frest admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>Velox Solution</title>

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon/favicon-32x32.png') }}">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/app-assets/vendors/css/vendors.min.css') }}">
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
    <!-- END: Custom CSS-->


</head>

<body class="vertical-layout vertical-menu-modern semi-dark-layout 1-column  navbar-sticky footer-static bg-full-screen-image  blank-page blank-page" data-open="click" data-menu="vertical-menu-modern" data-col="1-column" data-layout="semi-dark-layout">

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- forgot password start -->

                <section class="row flexbox-container">
                    <div class="col-xl-7 col-md-9 col-10  px-0">
                        <div class="card bg-authentication mb-0">
                            <div class="row m-0">
                                <!-- left section-forgot password -->
                                <div class="col-md-6 col-12 px-0">
                                    <div class="card disable-rounded-right mb-0 p-2">
                                        <div class="card-header pb-1">
                                            <div class="card-title">
                                                <h4 class="text-center mb-2">Forgot Password?</h4>
                                            </div>
                                        </div>
                                        <div class="card-content">
                                            <div class="card-body">

                                                @include('includes.admin.form-login')
                                                <form class="mb-2" id="forgotform" action="{{ route('worker.forgot.submit') }}" method="POST">
                                                    {{ csrf_field() }}
                                                    <div class="form-group mb-2">

                                                        <label class="text-bold-600" for="exampleInputEmail1">Email address</label>
                                                        <input type="email" name="email" class="User Name form-control" placeholder="{{ __('Type Email Address') }}" value="" required="">
                                                        <i class="icofont-user-alt-5"></i>
                                                    </div>
                                                    <input id="authdata" type="hidden" value="{{ __('Checking...') }}">
                                                    <button type="submit" class="btn btn-primary glow position-relative w-100">SEND PASSWORD<i id="icon-arrow" class="bx bx-right-arrow-alt"></i></button>
                                                </form>

                                                <div class="text-center mb-2">
                                                  <a href="{{ route('worker.login') }}">
                                                  <small>I Remembered My Password</small>
                                                  </a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- right section image -->
                                <div class="col-md-6 d-md-block d-none text-center align-self-center">
                                    <img class="img-fluid" src="{{ asset('assets/images/logo.png') }}"
                                        alt="branding logo" width="300">
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- forgot password ends -->
            </div>
        </div>
    </div>
    <!-- END: Content-->


     <!-- BEGIN: Vendor JS-->
     <script src="{{ asset('assets/admin-assets/app-assets/vendors/js/vendors.min.js') }}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('assets/admin-assets/app-assets/js/scripts/configs/vertical-menu-dark.js') }}"></script>
    <script src="{{ asset('assets/admin-assets/app-assets/js/core/app-menu.js') }}"></script>
    <script src="{{ asset('assets/admin-assets/app-assets/js/core/app.js') }}"></script>
    <script src="{{ asset('assets/admin-assets/app-assets/js/scripts/components.js') }}"></script>
    <script src="{{ asset('assets/admin-assets/app-assets/js/scripts/footer.js') }}"></script>
    <!-- END: Theme JS-->

    <script src="{{asset('js/ajax_handling.js')}}"></script>

    <!-- AJAX Js-->
    <script src="{{asset('assets/admin-assets/js/myscript.js')}}"></script>

</body>

</html>
