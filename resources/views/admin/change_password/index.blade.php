@extends('layouts.admin')

@section('content')

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h5 class="content-header-title float-left pr-1 mb-0">Change Password</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active"><a href="#">Change Password</a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.flash-message')
        <section id="basic-vertical-layouts">
            <div class="row match-height">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">User Profile</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form id="form_validationss" method="post" action="{{ route('admin.password.update') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label class="form-label">Old Password</label>
                                        <input type="password" class="form-control @error('old_password') is-invalid @enderror" name="old_password" placeholder="Enter Old Password" value="{{old('old_password')}}">
                                        @error('old_password')
                                        <label id="old_password-error" class="error" for="old_password">{{ $message }}</label>
                                        @enderror
                                    </div>

                                    <div class="form-group ">
                                        <label class="form-label">New Password</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Enter New Password" value="{{old('password')}}">
                                        @error('password')
                                        <label id="password-error" class="error" for="password">{{ $message }}</label>
                                        @enderror
                                    </div>

                                    <div class="form-group ">
                                        <label class="form-label">Confirm Password</label>
                                        <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" name="confirm_password" value="{{old('confirm_password')}}" placeholder="Confirm Password" value="{{old('confirm_password')}}">
                                        @error('confirm_password')
                                        <label id="confirm_password-error" class="error" for="confirm_password">{{ $message }}</label>
                                        @enderror
                                    </div>

                                    <button class="btn btn-primary btn-sm" type="submit">UPDATE</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

@endsection

@section('scripts')

@endsection
