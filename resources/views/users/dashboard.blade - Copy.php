@extends('layouts.front')

<link rel="stylesheet" href="{{ asset('front/css/booking.css') }}" media="screen">
@section('content')
<section class="u-align-center u-clearfix u-white u-section-1" id="sec-1e4f">
      <div class="u-clearfix u-sheet u-sheet-1">
        <h1 class="u-align-center u-custom-font u-font-montserrat u-text u-text-custom-color-10 u-text-1">My Bookings
        </h1>

        <div class="container">

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">

                <a href="#ongoing" class="u-border-none u-btn u-btn-rectangle u-button-style u-color-scheme-summer-time u-color-style-multicolor-1 u-custom-color-1 u-custom-font u-font-montserrat u-radius-0 u-btn-1" role="tab" data-toggle="tab">Ongoing&nbsp;</a>

                <a href="#history" class="u-border-none u-btn u-btn-rectangle u-button-style u-color-scheme-summer-time u-color-style-multicolor-1 u-custom-color-10 u-custom-font u-font-montserrat u-radius-0 u-btn-2" role="tab" data-toggle="tab">History&nbsp;</a>


            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane fade active in" id="ongoing">
                    @if(count($ongoing_orders))


                    <div class="ongoing-order">
                        <div class="header-area">
                            <h4 class="title text-left">
                                Ongoing Orders
                            </h4>
                        </div>
                        <div class="mr-table allproduct mt-4">
                                <div class="table-responsive">
                                        <table id="example" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>#Order</th>
                                                    <th>Date</th>
                                                    <th>Order Total</th>
                                                    <th>Order Status</th>
                                                    <th>View</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($ongoing_orders as $order)
                                            <tr>
                                                <td>{{$order->order_number}}</td>
                                                <td>{{date('d F, Y', strtotime($order->created_at))}}</td>
                                                <td>{{$order->pay_amount}}</td>
                                                <td>
                                                    <div class="order-status pending">
                                                        {{ucfirst($order->status)}}
                                                    </div>
                                                </td>
                                                <td>
                                                    <a class="mybtn2 sm" href="{{url('/order_details/'.$order->id)}}">
                                                            VIEW ORDER
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach

                                            </tbody>
                                        </table>
                                </div>
                            </div>
                    </div>


                    @else
                    <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-10 u-text-2">You don't have any ongoing orders <br></p>
                    @endif

                </div>
                <div class="tab-pane fade" id="history">
                @if(count($order_history))
                <div class="order-history">
                        <div class="header-area">
                            <h4 class="title text-left">
                                Ongoing Orders
                            </h4>
                        </div>
                        <div class="mr-table allproduct mt-4">
                                <div class="table-responsive">
                                        <table id="example" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>#Order</th>
                                                    <th>Date</th>
                                                    <th>Order Total</th>
                                                    <th>Order Status</th>
                                                    <th>View</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($order_history as $order)
                                            <tr>
                                                <td>{{$order->order_number}}</td>
                                                <td>{{date('d F, Y', strtotime($order->created_at))}}</td>
                                                <td>{{$order->pay_amount}}</td>
                                                <td>
                                                    <div class="order-status pending">
                                                        {{ucfirst($order->status)}}
                                                    </div>
                                                </td>
                                                <td>
                                                    <a class="mybtn2 sm" href="{{url('/order_details/'.$order->id)}}">
                                                            VIEW ORDER
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach

                                            </tbody>
                                        </table>
                                </div>
                            </div>
                    </div>
                @else
                <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-10 u-text-2">You don't have any order history <br></p>
                @endif
                </div>
            </div>

        </div>



        <a href="{{ url('/') }}" class="u-border-none u-btn u-btn-rectangle u-button-style u-color-scheme-summer-time u-color-style-multicolor-1 u-custom-color-1 u-custom-font u-font-montserrat u-radius-0 u-btn-3">Book a service<span style="font-size: 1rem;"></span>
        </a>
      </div>
    </section>


@endsection
