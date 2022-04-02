@extends('layouts.admin')

@section('content')
@php
    use Carbon\Carbon;
@endphp
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">     
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    @if(Auth::guard('admin')->user()->sectionCheck('franchise_orders_view'))
                    <h5 class="content-header-title float-left pr-1 mb-0">Franchises Order</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active"><a href="{{ route('franchise-order') }}">Franchises Order</a>
                            </li>
                            <li class="breadcrumb-item">Franchises Order Details
                            </li>
                        </ol>
                    </div>
                    @elseif(Auth::guard('admin')->user()->role_id == 0)
                    <h5 class="content-header-title float-left pr-1 mb-0">Order</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active"><a href="{{ route('orders-view') }}">Order</a>
                            </li>
                            <li class="breadcrumb-item">Order Details
                            </li>
                        </ol>
                    </div>
                    @endif
                </div>
            </div>
        </div>
            <div class="col-md-12">
                <div class="card card-user">
                    <div class="card-header">
                        <h5 class="card-title">Orders View</h5>
                    </div>
                    <div class="card-body">
                
                        <div class="row">
                            <div class="col-md-6">
                                <div class="p-1 bg-dark text-white rounded-top">
                                    <p style="margin: 0;"> Order Details</p>
                                </div>
                                <div class="bg-white shadow">
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr>
                                                <td>Order Number :</td>
                                                <td class="users-view-username">{{ $booking->order_number }}</td>
                                            </tr>
                                            <tr>
                                                <td>Total Quantity :</td>
                                                <td class="users-view-username">{{ $booking->totalQty }}</td>
                                            </tr>
                                            <tr>
                                                <td>Amount :</td>
                                                <td class="users-view-username">{{ $booking->pay_amount }}</td>
                                            </tr>
                                            <tr>
                                                <td>Order Date:</td>
                                                <td class="users-view-username">{{Carbon::parse($booking->created_at)->format('d-m-Y h:i a')}}</td>
                                            </tr>
                                            <tr>
                                                <td>Payment Method:</td>
                                                <td class="users-view-username">{{ $booking->method }}</td>
                                            </tr>
                                            <tr>
                                                <td>Payment Status:</td>
                                                <td class="users-view-username">{{ $booking->payment_status }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-1 bg-dark text-white rounded-top">
                                    <p style="border:none; margin: 0;" class="align-middle">Billing Details</p>
                                </div>
                                <div class="bg-white shadow">
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr>
                                                <td>Name :</td>
                                                <td class="users-view-username">{{ $booking->user->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Email :</td>
                                                <td class="users-view-username">{{ $booking->customer_email }}</td>
                                            </tr>
                                            <tr>
                                                <td>Phone :</td>
                                                <td class="users-view-username">{{ $booking->customer_phone }}</td>
                                            </tr>
                                            <tr>
                                                <td>Address :</td>
                                                <td class="users-view-username">{{ $booking->customer_address }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-12 bg-white shadow">
                                <div class="p-1 bg-dark text-white rounded">
                                    <p style="border:none; margin: 0;" class="align-middle">Service Ordered</p>
                                </div>
                                @if(isset($booking->cart['services']))
                                <div class="col-md-6 mb-4">
                                    <table class="table table-borderless">
                                        <h6 class="card-title mt-2">Services</h6>
                                        <tr>
                                            <th>service</th>
                                            <th>price</th>
                                        </tr>
                                        @foreach($booking->cart['services'] as $service)
                                            <tr>
                                                <td>{{$service['title']}}</td>
                                                <td>{{$service['price']}}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                @endif
                                @if(isset($booking->cart['packages']))
                                <div class="col-md-12">
                                    <table class="table table-borderless">
                                        <h6 class="card-title mt-2">Packages</h6>
                                        <tr>
                                            <th>package</th>
                                            <th>Discount Value</th>
                                            <th>Package Price</th>
                                            <th class="text-center">Services</th>
                                        </tr>    
                                        @foreach($booking->cart['packages'] as $package)
                                        
                                            <tr>
                                                <td>{{$package['title']}}</td>
                                                <td>{{$package['discount_value'] }}{{ $package['discount_type'] == 1 ? '%' : '' }}</td>
                                                <td>{{$package['price']}}</td>
                                                <td>
                                                    <table class="table table-borderless">
                                                        @foreach($package['package_service'] as $service)
                                                            <td>{{$service['title']}}</td>
                                                        @endforeach
                                                    </table>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
    </div>
</div>        

@endsection

@section('scripts')


@endsection