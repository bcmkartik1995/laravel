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
                    <h5 class="content-header-title float-left pr-1 mb-0">Franchise Order Details</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active"><a href="{{ route('orders-view') }}">Order</a>
                            </li>
                            <li class="breadcrumb-item">Franchise Order Details
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        @foreach($franchise_orders as $franchise_order)
            <div class="col-md-12">
                <div class="card card-user">
                    <div class="card-header">
                        <h5 class="card-title">Franchise Name : {{ $franchise_order['franchise']['franchise_name'] }}</h5>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="p-1 bg-dark text-white rounded-top">
                                    <p style="margin: 0;"> Order Details</p>
                                </div>
                                <div class="bg-white shadow">
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr>
                                                <td>Order Number :</td>
                                                <td class="users-view-username">{{ $franchise_order->f_order->order_number }}</td>
                                            </tr>
                                            <tr>
                                                <td>Amount :</td>
                                                <td class="users-view-username">{{ $franchise_order->f_order->pay_amount }}</td>
                                            </tr>
                                            <tr>
                                                <td>Order Date:</td>
                                                <td class="users-view-username">{{ Carbon::parse($franchise_order->f_order->created_at)->format('d-m-Y')  }}</td>
                                            </tr>
                                            <tr>
                                                <td>Payment Method:</td>
                                                <td class="users-view-username">{{ $franchise_order->f_order->method }}</td>
                                            </tr>
                                            <tr>
                                                <td>Payment Status:</td>
                                                <td class="users-view-username">{{ $franchise_order->f_order->payment_status }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-12 bg-white shadow">
                                <div class="p-1 bg-dark text-white rounded">
                                    <p style="border:none; margin: 0;" class="align-middle">Services Ordered</p>
                                </div>
                                @if(isset($franchise_order->order_details['services']))
                                <div class="col-md-12 mb-4">
                                    <table class="table table-white table-bordered">
                                        <h6 class="card-title mt-2 font-weight-bold">Service Details</h6>
                                            <thead>
                                                <tr class="text-center">
                                                    <th scope="col">service</th>
                                                    <th scope="col">price</th>
                                                    <th scope="col">Worker</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Start Time</th>
                                                    <th scope="col">End Time</th>
                                                </tr>
                                            </thead>
                                        @foreach($franchise_order->order_details['services'] as $service)
                                            <tbody>
                                                @if(isset($service['assiged_to_workers']))
                                                    @foreach($service['assiged_to_workers'] as $id => $assiged_workers)
                                                        @php 
                                                            $worker_name = null;
                                                            if(isset($worker_orders[$franchise_order->id]['services'][$service['id']]->worker->name)){
                                                                $worker_name = $worker_orders[$franchise_order->id]['services'][$service['id']]->worker->name;
                                                            }

                                                            $worker_status = null;
                                                            if(isset($worker_orders[$franchise_order->id]['services'][$service['id']]['status'])){
                                                                $worker_status = $worker_orders[$franchise_order->id]['services'][$service['id']]['status'];
                                                            }

                                                            $start_time = null;
                                                            if(isset($service['start_time'])){
                                                                $start_time =  Carbon::parse($service['start_time'])->format('d-m-Y H:i a');
                                                            }

                                                            $end_time = null;
                                                            if(isset($service['end_time'])){
                                                                $end_time = Carbon::parse($service['end_time'])->format('d-m-Y H:i a');
                                                            }
                                                        @endphp
                                                        <tr class="text-center">
                                                            <td>{{$service['title']}}</td>
                                                            <td>{{$service['price']}}</td>
                                                            <td>{{$worker_name}}</td>
                                                            <td>
                                                                @if($worker_status == 0)
                                                                    <span class="badge badge-pill badge-light-info"> Pending</span>
                                                                @elseif($worker_status == 1)
                                                                    <span class="badge badge-pill badge-light-primary"> Accept</span>
                                                                @elseif($worker_status == 2)
                                                                    <span class="badge badge-pill badge-light-danger"> Cancel</span>
                                                                @elseif($worker_status == 3)
                                                                    <span class="badge badge-pill badge-light-primary"> processing</span>
                                                                @elseif($worker_status == 4)
                                                                    <span class="badge badge-pill badge-light-warning"> On delivery</span>
                                                                @elseif($worker_status == 5)
                                                                    <span class="badge badge-pill badge-light-success"> Complete</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                {{ $start_time }}
                                                            </td>
                                                            <td>
                                                                {{ $end_time }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        @endforeach
                                    </table>    
                                </div>
                                @endif
                                @if(isset($franchise_order->order_details['packages']))
                                <div class="col-md-12">
                                    @foreach($franchise_order->order_details['packages'] as $package)
                                        <h6 class="card-title mt-2 font-weight-bold">Package Details</h6>
                                        <table class="table table-white table-bordered">
                                            <thead>
                                                <tr class="text-center">
                                                    <th scope="col">Package Name</th>
                                                    <th scope="col">Price</th>
                                                    <th scope="col">Original Price</th>
                                                    <th scope="col">Discount Value</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="text-center">
                                                    <td>{{ $package['title'] }}</td>
                                                    <td>{{ $package['price'] }}</td>
                                                    <td>{{ $package['original_price'] }}</td>
                                                    <td>{{ $package['discount_value'] }}{{ $package['discount_type'] == 1 ? '%' : '' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <h6 class="card-title mt-3 font-weight-bold">Package Service Details</h6>
                                        <table class="table table-white table-bordered">
                                            <thead>
                                                <tr class="text-center">
                                                    <th>Services</th>
                                                    <th>Service Price</th>
                                                    <th>Start TIme</th>
                                                    <th>End TIme</th>
                                                    <th>worker</th>
                                                    <th>Status</th>
                                                </tr>    
                                            </thead>
                                            @foreach($package['package_service'] as $services)
                                                @php 
                                                    $worker_name = null;
                                                    if(isset($worker_orders[$franchise_order->id]['packages'][$package['id']][$services['id']]->worker->name)){
                                                        $worker_name = $worker_orders[$franchise_order->id]['packages'][$package['id']][$services['id']]->worker->name;
                                                    }
                                                   
                                                    $worker_status = null;
                                                    if(isset($worker_orders[$franchise_order->id]['packages'][$package['id']][$services['id']]['status'])){
                                                        $worker_status = $worker_orders[$franchise_order->id]['packages'][$package['id']][$services['id']]['status'];
                                                    }
                                                    
                                                    $start_time = null;
                                                    if(isset($services['start_time'])){
                                                        $start_time =  Carbon::parse($services['start_time'])->format('d-m-Y H:i a');
                                                    }
                                                    $end_time = null;
                                                    if(isset($services['end_time'])){
                                                        $end_time = Carbon::parse($services['end_time'])->format('d-m-Y H:i a');
                                                    }
                                                @endphp
                                                <tbody>
                                                    <tr class="text-center">
                                                        <td>{{$services['title']}}</td>
                                                        <td>{{$services['price']}}</td>
                                                        <td>{{ $start_time }}</td>
                                                        <td>{{ $end_time }}</td>
                                                        <td>{{ $worker_name }}</td>
                                                        <td>
                                                            @if($worker_status == 0)
                                                                <span class="badge badge-pill badge-light-info"> Pending</span>
                                                            @elseif($worker_status == 1)
                                                                <span class="badge badge-pill badge-light-primary"> Accept</span>
                                                            @elseif($worker_status == 2)
                                                                <span class="badge badge-pill badge-light-danger"> Cancel</span>
                                                            @elseif($worker_status == 3)
                                                                <span class="badge badge-pill badge-light-primary"> processing</span>
                                                            @elseif($worker_status == 4)
                                                                <span class="badge badge-pill badge-light-warning"> On delivery</span>
                                                            @elseif($worker_status == 5)
                                                                <span class="badge badge-pill badge-light-success"> Complete</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            @endforeach
                                        </table>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        @endforeach    
    </div>
</div>        

@endsection

@section('scripts')


@endsection