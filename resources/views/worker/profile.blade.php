@extends('layouts.worker')
@section('content')

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h5 class="content-header-title float-left pr-1 mb-0">User Profile</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('worker.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active"><a href="#">User Profile</a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section id="basic-vertical-layouts">
            <div class="row match-height">
                <div class="col-md-4">
                    <div class="card card-user">
                        <div class="image">
                            <!-- <img src="../assets/img/damir-bosnjak.jpg" alt="..."> -->
                        </div>
                        <div class="card-body">
                            <div class="author">
                                <a href="#" class="">
                                    <img src="{{ $data->photo == '' ? asset('assets/admin-assets/app-assets/images/portrait/small/avatar.png') : asset('assets/images/admins') .'/'. $data->photo }}" class="avatar border-gray mx-auto d-block" width="220px" height="220px"/>
                                    <!-- <img class="avatar border-gray" src="../assets/img/mike.jpg" alt="..."> -->
                                    <h5 class="title text-center mt-2">{{ $data->name }}</h5>

                                </a>
                                <p class="description">
                                </p>
                            </div>
                            <p class="description text-center">
                            </p>
                        </div>
                        <p class="description text-center">
                            {{ $data->name }}<br>{{ $data->email }}<br>{{ $data->mobile }}
                        </p>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">User Profile</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form id="form_validation" method="post" action="{{ route('worker.profile.update') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group ">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            name="name" value="{{$data->name}}" placeholder="Username"
                                            autofocus>
                                        @error('name')
                                        <label id="name-error" class="error" for="name">{{ $message }}</label>
                                        @enderror
                                    </div>

                                    <div class="form-group ">
                                        <label class="form-label">Mobile</label>
                                        <input type="tel" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ $data->mobile }}" placeholder="10 digit Mobile number" minlength=10 maxlength=10 pattern="\d*" title="10 digit Mobile number">
                                        @error('mobile')
                                        <label id="mobile-error" class="error" for="mobile">{{ $message }}</label>
                                        @enderror
                                    </div>

                                    <div class="form-group ">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            name="email" value="{{$data->email}}" placeholder="Email Id"
                                            autofocus>
                                        @error('email')
                                        <label id="email-error" class="error" for="email">{{ $message }}</label>
                                        @enderror
                                    </div>

                                    <div class="form-group ">
                                        <label class="form-label">Profile Pic</label>
                                        <input type="file" class="form-control @error('avatar') is-invalid @enderror" name="avatar">
                                        @error('avatar')
                                        <label id="avatar-error" class="error" for="avatar">{{ $message }}</label>
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
