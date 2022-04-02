@extends('layouts.admin')

@section('content')

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h5 class="content-header-title float-left pr-1 mb-0">Manage Customer</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active"><a href="{{ route('users.index') }}">Manage Customer</a>
                            </li>
                            <li class="breadcrumb-item">Add Customer
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Basic Vertical form layout section start -->
        <section id="basic-vertical-layouts">
            <div class="row match-height">
                <div class="col-md-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Add Customer</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                            <form id="form_validation" method="POST" action="{{ route('users.store') }}">
                                @csrf
                                <div class="form-group ">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{old('name')}}" placeholder="Username" autofocus>
                                    @error('name')
                                        <label id="name-error" class="error" for="name">{{ $message }}</label>
                                    @enderror
                                </div>

                                <div class="form-group ">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{old('email')}}" placeholder="Email Id" autofocus>
                                    @error('email')
                                        <label id="email-error" class="error" for="email">{{ $message }}</label>
                                    @enderror
                                </div>

                                <div class="form-group ">
                                    <label class="form-label">Mobile</label>
                                    <input type="tel" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{old('mobile')}}" placeholder="10 digit Mobile number" minlength=10 maxlength=10 pattern="\d*" title="10 digit Mobile number">
                                    @error('mobile')
                                        <label id="mobile-error" class="error" for="mobile">{{ $message }}</label>
                                    @enderror
                                </div>

                                <div class="form-group ">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" autocomplete="nope">
                                    @error('password')
                                        <label id="password-error" class="error" for="name">{{ $message }}</label>
                                    @enderror
                                </div>

                                <div class="form-group ">
                                    <label class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" name="confirm_password" placeholder="Confirm Password" autocomplete="nope">
                                    @error('confirm_password')
                                        <label id="password-error" class="error" for="confirm_password">{{ $message }}</label>
                                    @enderror
                                </div>

                                <button class="btn btn-primary btn-sm" type="submit">SUBMIT</button>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- // Basic Vertical form layout section end -->
    </div>
</div>

@endsection

@section('scripts')

@endsection
