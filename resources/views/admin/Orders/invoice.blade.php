<?php use Illuminate\Support\Str; ?>
@extends('layouts.admin')

@section('styles')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/app-assets/css/pages/app-invoice.css') }}">


@endsection

@section('content')



    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
            @include('layouts.flash-message')
                <!-- app invoice View Page -->
                <section class="invoice-view-wrapper">
                    <div class="row">
                        <!-- invoice view page -->
                        <div class="col-xl-9 col-md-8 col-12">
                            <div class="card invoice-print-area">
                                <div class="card-content">
                                    <div class="card-body pb-0 mx-25">
                                        <!-- header section -->
                                        <div class="row">
                                            <div class="col-xl-4 col-md-12">
                                                <span class="invoice-number mr-50">Invoice#</span>
                                                <span>{{ $booking->order_number }}</span>
                                            </div>
                                            @php
                                                $datetime = new DateTime($booking->created_at);
                                                $date = $datetime->format('d-m-Y');
                                                $time = $datetime->format('h:i A');
                                            @endphp
                                            <div class="col-xl-8 col-md-12">
                                                <div class="d-flex align-items-center justify-content-xl-end flex-wrap">
                                                    <div class="mr-3">
                                                        <small class="text-muted">Order Date:</small>
                                                        <span>{{ $date }}</span>
                                                    </div>
                                                    <div>
                                                        <small class="text-muted">Order Time:</small>
                                                        <span>{{ $time }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- logo and title -->
                                        <div class="row my-3">
                                            <div class="col-6">
                                                <h4 class="text-primary">Invoice</h4>
                                            </div>
                                            <div class="col-6 d-flex justify-content-end">
                                                <img src="{{ asset('assets\admin-assets\images\logo.png')}}" alt="logo" height="46" width="180">
                                            </div>
                                        </div>
                                        <hr>
                                        <!-- invoice address and contact -->
                                        
                                            <div class="row invoice-info">
                                           
                                                <div class="col-6 mt-1">
                                                    <h6 class="invoice-from">Bill From</h6>
                                                    <div class="mb-1">
                                                        <span>{{ env('APP_NAME') }}</span>
                                                    </div>
                                                    {{--<!-- <div class="mb-1">
                                                        <span>{{ $booking->address_1 }}</span>
                                                    </div>
                                                    <div class="mb-1">
                                                        <span>{{ $booking->email }}</span>
                                                    </div>
                                                    <div class="mb-1">
                                                        <span>{{ $booking->mobile }}</span>
                                                    </div> -->--}}
                                                </div>  
                                                <div class="col-6 mt-1">
                                                    <h6 class="invoice-to">Bill To</h6>
                                                    <div class="mb-1">
                                                        <span>{{ $booking->customer_name }}</span>
                                                    </div>
                                                    <div class="mb-1">
                                                        <span>{{ $booking->customer_address }}</span>
                                                    </div>
                                                    <div class="mb-1">
                                                        <span>{{ $booking->customer_email }}</span>
                                                    </div>
                                                    <div class="mb-1">
                                                        <span>{{ $booking->customer_phone }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                        <hr>
                                    </div>
                                    <!-- product details table-->
                                    <div class="invoice-product-details table-responsive mx-md-25">
                                        @if(!empty($booking->cart['services']))
                                          <table class="table table-white table-bordered mb-0">
                                              <h4 class="text-primary ml-2">Services</h4>
                                              <thead>
                                                  <tr class="border-0">
                                                      <th scope="col" class="text-center font-weight-bold">Item</th>
                                                      <th scope="col" class="text-center font-weight-bold">Cost</th>
                                                      <th scope="col" class="text-center font-weight-bold">Qty</th>
                                                      <th scope="col" class="text-center font-weight-bold">Price</th>
                                                  </tr>
                                              </thead>
                                              <tbody>
                                                  @foreach($booking->cart['services'] as $service)
                                                      <tr class="text-center">
                                                          <td>{{$service['title']}}</td>
                                                          <td>{{$service['price']}}</td>
                                                          <td>{{$service['quantity']}}</td>
                                                          <td class="text-primary font-weight-bold">{{$service['original_price']}}</td>
                                                      </tr>
                                                  @endforeach
                                              </tbody>
                                          </table>
                                        @endif
                                        @if(!empty($booking->cart['packages']))
                                        <table class="table table-white table-bordered mb-2">
                                            <h4 class="text-primary mt-3 ml-2">Packages</h4>
                                            <thead>
                                                <tr class="">
                                                    <th scope="col" class="text-center font-weight-bold" >Item</th>
                                                    <th scope="col" class="text-center font-weight-bold">Discount</th>
                                                    <th scope="col" class="text-center font-weight-bold">Cost</th>
                                                    <th scope="col" class="text-center font-weight-bold">Qty</th>
                                                    <th scope="col" class="text-center font-weight-bold">Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                              @foreach($booking->cart['packages'] as $package)
                                              
                                                  <tr class="text-center">
                                                      <td>{{$package['title']}}</td>
                                                      <td>{{$package['discount_value']}}{{ $package['discount_type'] == 1 ? '%' : ''}}</td>
                                                      <td>{{$package['original_price']}}</td>
                                                      <td>{{$package['quantity']}}</td>
                                                      <td class="text-primary font-weight-bold">{{$package['price']}}</td>
                                                  </tr>
                                              @endforeach
                                            </tbody>
                                        </table>
                                        <table class="table mb-0">
                                            <h4 class="text-primary ml-2">Package Services</h4>
                                            <thead>
                                                <tr class="border-0">
                                                    <th scope="col" class="text-center font-weight-bold">Service</th>
                                                    <!-- <th scope="col" class="text-center font-weight-bold">Description</th> -->
                                                    <th scope="col" class="text-center font-weight-bold">Service Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($booking->cart['packages'] as $package)
                                                    @foreach($package['package_service'] as $service)
                                                    <tr class="text-center">
                                                        <td>{{ $service['title'] }}</td>
                                                        <td>{{ $service['price'] }}</td>
                                                    </tr>
                                                    @endforeach
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @endif
                                    </div>

                                    <!-- invoice subtotal -->
                                    <div class="card-body pt-0 mx-25">
                                        <hr>
                                        <div class="row">
                                            <div class="col-4 col-sm-6 mt-75">
                                                <p>Thanks for your business.</p>
                                            </div>
                                            <div class="col-8 col-sm-6 d-flex justify-content-end mt-75">
                                                <div class="invoice-subtotal">
                                                    <div class="invoice-calc d-flex justify-content-between">
                                                        <span class="invoice-title">Subtotal</span>
                                                        <span class="invoice-value">{{ $booking->cart['origional_price'] }}</span>
                                                    </div>
                                                    <div class="invoice-calc d-flex justify-content-between">
                                                        <span class="invoice-title">Discount</span>
                                                        <span class="invoice-value">{{ $booking->cart['discount'] }}</span>
                                                    </div>
                                                    <hr>
                                                    <div class="invoice-calc d-flex justify-content-between">
                                                        <span class="invoice-title font-weight-bold text-dark">Invoice Total</span>
                                                        <span class="invoice-value text-primary font-weight-bold"> {{ $booking->cart['final_total'] }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- invoice action  -->
                        <div class="col-xl-3 col-md-4 col-12">
                            <div class="card invoice-action-wrapper shadow-none border">
                                <div class="card-body">

                                    <div class="invoice-action-btn mb-2">
                                        <a href="{{ route('order-invoice-send',$booking->order_id) }}" class="btn btn-primary btn-block invoice-send-btn">
                                              <i class="bx bx-send"></i>
                                              <span>Send Invoice</span>
                                        </a>
                                    </div>
                                    <div class="invoice-action-btn mb-2">
                                        <a href="javascript:void(0);" class="btn btn-light-primary btn-block invoice-print-a">
                                            <span>print</span>
                                        </a>
                                    </div>
                                    <div class="invoice-action-btn">
                                        <a href="{{ route('order-invoice-print',$booking->order_id) }}" class="btn btn-success btn-block">
                                            <span>Download</span>
                                        </a>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection

@section('scripts')


<script src="{{ asset('assets/admin-assets/app-assets/js/scripts/pages/app-invoice.js') }}"></script>

<script>
    $(document).ready(function () {
        
        $(".invoice-print-a").on("click", function () {
            window.print();
        });
    });
</script>
@endsection
