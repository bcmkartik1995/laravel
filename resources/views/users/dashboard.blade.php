@extends('layouts.front')
@section('content')

<section class="user-dashbord">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="user-profile-info-area">
                    @include('includes.front.dashboard-links')
                </div>
            </div>

            <div class="col-lg-8">
                <div class="row mb-3">
                    <div class="col-lg-12">
                        <div class="user-profile-details">
                            <div class="account-info">
                                <div class="header-area">
                                    <h4 class="title">
                                        Account Information
                                    </h4>
                                </div>
                                <div class="edit-info-area">
                                </div>
                                <div class="main-info">
                                    <h5 class="title">{{$user->name}}</h5>
                                    <ul class="list">
                                        <li>
                                            <p><span class="user-title">Email:</span> {{$user->email}}</p>
                                        </li>
                                        <li>
                                            <p><span class="user-title">Phone:</span> {{$user->phone}}</p>
                                        </li>
                                        <li>
                                            <p><span class="user-title">Address:</span> {{$user->address}}</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row row-cards-one mb-3">
                    <div class="col-md-6 col-xl-6">
                        <div class="card c-info-box-area">
                            <div class="c-info-box box2">
                                <p>{{$total_orders}}</p>
                            </div>
                            <div class="c-info-box-content">
                                <h6 class="title">Total Orders</h6>
                                <p class="text">All Time</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-6">
                        <div class="card c-info-box-area">
                            <div class="c-info-box box1">
                                <p>{{$pending_orders}}</p>
                            </div>
                            <div class="c-info-box-content">
                                <h6 class="title">Pending Orders</h6>
                                <p class="text">All Time</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
