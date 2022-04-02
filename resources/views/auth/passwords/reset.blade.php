@extends('layouts.front')

@section('content')

<div class="container">
    <h4 class="text-center mt-5">Reset Password</h4>
    <div class="row mt-4 ps-cen mb-5">

        <div class="col-md-5 ">

            <div class="reset-bor">
                <div class="lc-ps-img">
                    <img src="{{asset('assets/front-assets/images/lock1.png')}}">
                </div>
                <div class="row ps-cen">

                    <div class="col-md-10 col-sm-10 col-10">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="form-group mt-3">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" placeholder="Email Address" autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" autocomplete="new-password">
                            </div>
                            <div class="form-row text-center">
                                <div class="col-12 pb-5 pt-5">
                                    <button class="btn-reg" type="submit">Reset Password </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

@endsection
