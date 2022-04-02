<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="author" content="GeniusOcean">
    <!-- Title -->
    <title>{{$gs->title}}</title>
    <!-- favicon -->
    <!-- <link rel="icon"  type="image/x-icon" href="{{asset('assets/images/'.$gs->favicon)}}"/> -->
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
    @yield('styles')

  </head>
  <body class="vertical-layout vertical-menu-modern semi-dark-layout 1-column  navbar-sticky footer-static bg-full-screen-image  blank-page" data-open="click" data-menu="vertical-menu-modern" data-col="1-column" data-layout="semi-dark-layout">

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- login page start -->
                <section id="auth-login" class="row flexbox-container">
                    <div class="col-xl-8 col-11">
                        <div class="card bg-authentication mb-0">
                            <div class="row m-0">
                                <!-- left section-login -->
                                <div class="col-md-6 col-12 px-0">
                                    <div class="card disable-rounded-right mb-0 p-2 h-100 d-flex justify-content-center">
                                        <div class="card-header pb-1">
                                            <div class="card-title">
                                                <h4 class="text-center mb-2">{{ __('Login Now') }}</h4>
                                                <p class="text-center">{{ __('Welcome back, please sign in below') }}</p>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                        @include('layouts.flash-message')
                                             @include('includes.admin.form-login')

                                            <form id="loginform" action="{{ route('worker.login.submit') }}" method="POST">
                                                {{ csrf_field() }}
                                                <div class="form-group mb-50">
                                                    <label class="text-bold-600" for="exampleInputEmail1">Email address</label>
                                                    <input type="email" name="email" class="form-control User Name" placeholder="{{ __('Type Email Address') }}" value="" required="" autofocus>
</div>
                                                <div class="form-group">
                                                    <label class="text-bold-600" for="exampleInputPassword1">Password</label>
                                                    <input type="password" name="password" class="form-control Password" placeholder="{{ __('Type Password') }}" required="">
                                                </div>
                                                <div class="form-group d-flex flex-md-row flex-column justify-content-between align-items-center">
                                                    <div class="text-left">
                                                        <div class="checkbox checkbox-sm">
                                                            <input type="checkbox" class="form-check-input" name="remember"  id="rp" {{ old('remember') ? 'checked' : '' }}>
                                                            <label class="checkboxsmall" for="rp"><small>{{ __('Remember Me') }}
                                                                    in</small></label>
                                                        </div>
                                                    </div>
                                                    <div class="text-right"><a href="{{ route('worker.forgot') }}" class="card-link"><small>Forgot Password?</small></a></div>
                                                </div>
                                                <input id="authdata" type="hidden"  value="{{ __('Authenticating...') }}">
                                                <button type="submit" class="btn btn-primary glow w-100 position-relative">{{ __('Login') }}<i id="icon-arrow" class="bx bx-right-arrow-alt"></i></button>
                                            </form>
                                            <hr>
                                            <!-- <div class="text-center"><small class="mr-25">Don't have an account?</small><a href="auth-register.html"><small>Sign up</small></a></div> -->
                                        </div>
                                    </div>
                                </div>
                                <!-- right section image -->
                                <div class="col-md-6 d-md-block d-none text-center align-self-center p-3">
                                    <img class="img-fluid" src="{{ asset('assets/images/logo.png') }}" alt="branding logo">
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- login page ends -->

            </div>
        </div>
    </div>
    <!-- END: Content-->



    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('assets/admin-assets/app-assets/vendors/js/vendors.min.js') }}"></script>
   <!--  <script src="{{ asset('assets/admin-assets/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.js') }}"></script>
    <script src="{{ asset('assets/admin-assets/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.js') }}"></script>
    <script src="{{ asset('assets/admin-assets/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js') }}"></script> -->
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
