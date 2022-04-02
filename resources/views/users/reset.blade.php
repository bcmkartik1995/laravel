@extends('layouts.front')
@section('content')

<section class="user-dashbord">
    <div class="container">
        @include('layouts.flash-message')
        <div class="row">
            <div class="col-lg-4">
                <div class="user-profile-info-area">
                    @include('includes.front.dashboard-links')
                </div>
            </div>

            <div class="col-lg-8">
                <div class="user-profile-details">
                    <div class="account-info">
                        <div class="header-area">
                            <h4 class="title">
                                Reset Password
                            </h4>
                        </div>
                        <div class="edit-info-area">

                            <div class="body">
                                <div class="edit-info-area-form">
                                    <div class="gocover" style="background: url({{asset('assets/images/'.$gs->loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                                    <form id="userform" action="{{route('reset')}}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <div class="alert alert-success validation" style="display: none;">
                                            <button type="button" class="close alert-close"><span>×</span></button>
                                            <p class="text-left"></p>
                                        </div>
                                        <div class="alert alert-danger validation" style="display: none;">
                                            <button type="button" class="close alert-close"><span>×</span></button>
                                            <ul class="text-left">
                                            </ul>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <input type="password" name="cpass" class="input-field" placeholder="Current Password" value="" autocomplete="off">
                                                @error('cpass')
                                                <label id="cpass-error" class="error" for="cpass">{{ $message }}</label>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <input type="password" name="newpass" class="input-field" placeholder="New Password" value="" autocomplete="off">
                                                @error('newpass')
                                                <label id="newpass-error" class="error" for="newpass">{{ $message }}</label>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <input type="password" name="renewpass" class="input-field" placeholder="Re-Type New Password" value="" autocomplete="off">
                                                @error('renewpass')
                                                <label id="renewpass-error" class="error" for="renewpass">{{ $message }}</label>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-links">
                                            <button class="submit-btn" type="submit">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
