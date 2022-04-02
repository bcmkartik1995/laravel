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
                                            <form id="loginform" action="{{ route('admin.login.submit') }}" method="POST">
                                                {{ csrf_field() }}
                                                <div class="form-group mb-50 admin_login_email">
                                                    <label class="text-bold-600" for="exampleInputEmail1">Email address</label>
                                                    <input type="email" name="email" class="form-control User Name" placeholder="{{ __('Type Email Address') }}" id="email" value="" required="" onchange="verify_admin_mobile()">
                                                </div>
                                                <div class="form-group admin_login_pwd" style="display: none;">
                                                    <label class="text-bold-600" for="exampleInputPassword1">Password</label>
                                                    <input type="password" name="password" class="form-control Password" placeholder="{{ __('Type Password') }}">
                                                </div>
                                                <div class="form-group mb-50 admin_login_otp" style="display: none;">
                                                    <label class="text-bold-600" for="exampleInputEmail1">Enter OTP</label>
                                                    <input type="text" name="user_otp" class="form-control" placeholder="{{ __('Type OTP') }}" id="user_otp">
                                                </div>
                                                <div class="form-group d-flex flex-md-row flex-column justify-content-between align-items-center">
                                                    <div class="text-left"><a href="javascript:void(0)" class="card-link" style="display: none;" id="admin-login-with-pass" onclick="admin_login_with_pwd()"><small>Login with password</small></a></div>
                                                    <div class="text-right"><a href="{{ route('admin.forgot') }}" class="card-link"><small>Forgot Password?</small></a></div>
                                                </div>
                                                <input type="hidden" name="send_otp" id="send_otp">
                                                <input type="hidden" name="phone" id="phone">
                                                <input id="authdata" type="hidden"  value="{{ __('Authenticating...') }}">
                                                <button type="button" class="btn btn-primary glow w-100 position-relative login_btn" id="verify_admin_mobile_btn" onclick="verify_admin_mobile()">{{ __('Login') }}<i id="icon-arrow" class="bx bx-right-arrow-alt"></i></button>
                                                <button type="button" class="btn btn-primary glow w-100 position-relative login_btn" id="admin_login_with_otp" style="display: none;" onclick="otp_admin_login()">Login with OTP</button>
                                                <button type="submit" class="btn btn-primary glow w-100 position-relative login_btn" id="admin_loginfrm_btn" style="display: none;">Login</button>
                                                <button type="button" class="btn btn-primary glow w-100 position-relative login_btn" id="submit_otp_form" style="display: none;" onclick="submit_otp_formbtn()">Login</button>
                                            </form>
                                            <hr>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 d-md-block d-none text-center align-self-center p-3">
                                    <img class="img-fluid" src="{{ asset('assets/images/logo.png') }}" alt="branding logo">
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    
    <script src="{{ asset('assets/admin-assets/app-assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('assets/admin-assets/app-assets/js/scripts/configs/vertical-menu-dark.js') }}"></script>
    <script src="{{ asset('assets/admin-assets/app-assets/js/core/app-menu.js') }}"></script>
    <script src="{{ asset('assets/admin-assets/app-assets/js/core/app.js') }}"></script>
    <script src="{{ asset('assets/admin-assets/app-assets/js/scripts/components.js') }}"></script>
    <script src="{{ asset('assets/admin-assets/app-assets/js/scripts/footer.js') }}"></script>
    <!-- END: Theme JS-->

    <script src="{{asset('js/ajax_handling.js')}}"></script>
    <!-- AJAX Js-->

    <script type="text/javascript">
    function verify_admin_mobile()
    {
        var email = $('#email').val();
        $.ajax({
            url:"{{route('verify_admin_mobile')}}",
            method:"POST",
            data:{email:email, _token:"{{ csrf_token() }}"},
            success: function (data) 
            {
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
                    $('#verify_admin_mobile_btn').hide();
                    $('#admin-login-with-pass').show();
                    $('#admin_login_with_otp').show();
                    $('#phone').val(data.success.data.phone);
                }
                return false;
            }
        });
    }

    function admin_login_with_pwd()
    {
        $('.alert-success').hide();
        $('.alert-info').hide();
        $('.alert-danger').hide();
        $('#verify_admin_mobile_btn').hide();
        $('#admin_login_with_otp').hide();
        $('#submit_otp_form').hide();
        $('#admin-login-with-pass').hide();
        $('#admin_loginfrm_btn').show();
        $('.admin_login_pwd').show();
    }

    function otp_admin_login()
    {
        $('.admin_login_email').hide();
        $('.admin_login_pwd').hide();
        $('.admin_login_otp').show();
        $('.alert-success').hide();
        $('.alert-info').hide();
        $('.alert-danger').hide();
        var phone = $('#phone').val();
        var otp = Math.floor(1000 + Math.random() * 9000);
        $.ajax({
            url:"{{route('send_admin_otp')}}",
            method:"POST",
            data:{phone:phone,otp:otp, _token:"{{ csrf_token() }}"},
            success: function (data) 
            {
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
                    $('#verify_admin_mobile_btn').hide();
                    $('#admin_login_with_otp').hide();
                    $('#admin_loginfrm_btn').hide();
                    $('#submit_otp_form').show();
                    $('#send_otp').val(otp);
                    $('#otp_phone').val(phone);
                }
            },
            error: function (data) 
            {
                $('.alert-info').hide();
                $('.alert-danger').hide();
                $('#verify_admin_mobile_btn').hide();
                $('#admin_login_with_otp').hide();
                $('#admin_loginfrm_btn').hide();
                $('#submit_otp_form').show();
                $('#send_otp').val(otp);
                $('#otp_phone').val(phone);
            }
        });
    }

    function submit_otp_formbtn()
    {
        var send_otp = $('#send_otp').val();
        var user_otp = $('#user_otp').val();
        var email = $('#email').val();
        if(send_otp != user_otp)
        {
            $('.alert-success').hide();
            $('.alert-info').hide();
            $('.alert-danger').show();
            $('.alert-danger ul').html('');
            $('.alert-danger span.text-left').html('OTP not verified');
            return false;
        }

        $.ajax({
            url:"{{route('adminOtpLogin')}}",
            method:"POST",
            data:{email:email, _token:"{{ csrf_token() }}"},
            success: function (data) 
            {
                if ((data.errors)) 
                {
                    $('.alert-success').hide();
                    $('.alert-info').hide();
                    $('.alert-danger').show();
                    $('.alert-danger ul').html('');
                    for(var error in data.errors)
                    {
                      $('.alert-danger span.text-left').html(data.errors[error]);
                    }
                }
                else
                {
                    $('.alert-info').hide();
                    $('.alert-danger').hide();
                    $('.alert-success').show();
                    $('.alert-success span.text-left').html('Success !');
                    window.location = data;
                }
            }
        });
    }
    </script>

    <script src="{{asset('assets/admin-assets/js/myscript.js')}}"></script>
  </body>

</html>
