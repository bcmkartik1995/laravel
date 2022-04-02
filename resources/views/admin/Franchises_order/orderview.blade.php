@extends('layouts.admin')

@section('styles')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />

<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/app-assets/vendors/css/pickers/daterange/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('assets/front-assets/css/bootstrap-datetimepicker.min.css') }}" media="screen">

<style>
    .swal-wide{
        width:500px !important;
        height:250px !important;
    }
</style>

@endsection

@section('content')

@php
    use Carbon\Carbon;
    $franchise_order['orders_id'] = "";
@endphp

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
                <div class="col-12">
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
                                            <?php
                                            $address = \App\User_address::where('id',$booking->customer_address_id)->first();
                                            ?>
                                            <tr>
                                                <td>Address :</td>
                                                <td class="users-view-username">{{ $address->flat_building_no.', '.$address->address}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @if(isset($franchise_orders))
                                @foreach($franchise_orders as $franchise_order)
                                <div class="col-lg-12 bg-white shadow">
                                    <div class="p-1 bg-dark text-white rounded">
                                        <p style="border:none; margin: 0;" class="align-middle">Service Ordered</p>
                                    </div>
                                    @if(isset($franchise_order->order_details['services']))
                                        <div class="col-md-12 mb-4">
                                            <table class="table table-white table-bordered">
                                                <h6 class="card-title mt-2 font-weight-bold">Service Details</h6>
                                                <thead>
                                                    <tr>
                                                        <th scope="col">service</th>
                                                        <th scope="col">price</th>
                                                        <th scope="col">Worker</th>
                                                        <th scope="col">Start Time</th>
                                                        <th scope="col">End Time</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Manage Status</th>
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
                                                                        $start_time =  Carbon::parse($service['start_time'])->format('d-m-Y h:i a');
                                                                    }

                                                                    $end_time = null;
                                                                    if(isset($service['end_time'])){
                                                                        $end_time = Carbon::parse($service['end_time'])->format('d-m-Y h:i a');
                                                                    }

                                                                    $worker_id = null;
                                                                    if(isset($worker_orders[$franchise_order->id]['services'][$service['id']]->id)){
                                                                        $worker_id = $worker_orders[$franchise_order->id]['services'][$service['id']]->id;
                                                                    }


                                                                @endphp
                                                                <tr>
                                                                    <td>{{$service['title']}}</td>
                                                                    <td>{{$service['price']}}</td>
                                                                    <td>{{$worker_name}}</td>
                                                                    <td>
                                                                        {{ $start_time  }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $end_time  }}
                                                                    </td>
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
                                                                        @if(in_array($worker_status, [0,1,3,4]))
                                                                            <button class="btn btn-secondary btn-sm show-example-btn franchises-order-status" data-id="{{ $worker_id }}" aria-label="Try me! Example: A custom positioned dialog">Manage Status</button>
                                                                        @elseif($worker_status == 5)
                                                                            <a href="javascript:void(0);" class="btn btn-success disabled">Completed</a>
                                                                        @elseif($worker_status == 2)
                                                                            <a href="javascript:void(0);" class="btn btn-danger disabled">Cancel</a>
                                                                            <a href="#" class="btn btn-success btn-sm show-example-btn btn-assign-service" data-type="service" data-package_id="0" data-service_id="{{ $service['id'] }}" data-worker_service_id="{{ $worker_id }}" data-toggle="modal" data-target="#order_rating_desc-{{$franchise_order['orders_id']}}" data-type="service" data-id="{{ $service['id'] }}">
                                                                                    Assign Worker
                                                                                </a>
                                                                        @endif
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
                                            <h6 class="card-title mt-2 font-weight-bold">Package Service</h6>
                                        @foreach($franchise_order->order_details['packages'] as $package)
                                            <table class="table table-white table-bordered">
                                                <h6 class="font-weight-bold mt-2">{{ $package['title'] }}</h6>
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>Services</th>
                                                        <th>Service Price</th>
                                                        <th>Start TIme</th>
                                                        <th>End TIme</th>
                                                        <th>worker</th>
                                                        <th>Status</th>
                                                        <th>Manage Status</th>
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
                                                            $start_time =  Carbon::parse($services['start_time'])->format('d-m-Y h:i a');
                                                        }

                                                        $end_time = null;
                                                        if(isset($services['end_time'])){
                                                            $end_time = Carbon::parse($services['end_time'])->format('d-m-Y h:i a');
                                                        }

                                                        $worker_id = null;
                                                        if(isset($worker_orders[$franchise_order->id]['packages'][$package['id']][$services['id']]->id)){
                                                            $worker_id = $worker_orders[$franchise_order->id]['packages'][$package['id']][$services['id']]->id;
                                                        }

                                                        $worker_user_id = null;
                                                        if(isset($worker_orders[$franchise_order->id]['packages'][$package['id']][$services['id']]->worker->id)){
                                                            $worker_user_id = $worker_orders[$franchise_order->id]['packages'][$package['id']][$services['id']]->worker->id;
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
                                                            <td>
                                                                @if(in_array($worker_status, [0,1,3,4]))
                                                                    <button class="btn btn-secondary btn-sm show-example-btn franchises-order-status" data-id="{{ $worker_id }}" aria-label="Try me! Example: A custom positioned dialog">Manage Status</button>
                                                                @elseif($worker_status == 5)
                                                                    <a href="javascript:void(0);" class="btn btn-success disabled">Completed</a>
                                                                @elseif($worker_status == 2)
                                                                    <a href="javascript:void(0);" class="btn btn-danger disabled">Cancel</a>
                                                                    <a href="#" class="btn btn-success btn-sm show-example-btn btn-assign-service" data-type="package" data-package_id="{{$package['id']}}" data-service_id="{{ $services['id'] }}" data-worker_service_id="{{ $worker_id }}" data-toggle="modal" data-target="#order_rating_desc" data-worker-id="{{ $worker_user_id }}">
                                                                        Assign Worker
                                                                    </a>
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
                                @endforeach
                            @endif
                        </div>
                    </div>
                    </div>
                </div>
            </div>
    </div>
</div>



<!-- franchise assign model Start -->

<div class="modal fade" id="order_rating_desc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Assign Frachise</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="form_assign_franchise" method="POST" action="{{ route('franchises-order-assign-worker',$franchise_order['orders_id']) }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="type" id="type" value="{{ old('type') }}">
                <input type="hidden" name="service_id" id="service_id" value="{{ old('service_id') }}">
                <input type="hidden" name="package_id" id="package_id" value="{{ old('package_id') }}">
                <input type="hidden" name="worker_service_id" id="worker_service_id" value="{{ old('worker_service_id') }}">
                <div class="form-group">
                    <div class="form-line">
                    <label class="form-label">Worker</label>
                        <select name="worker_id" id="worker_id" class="form-control select2">
                            <option value="">Select Worker</option>
                            @foreach($franchise_workers as $franchise_worker)
                                <option value="{{ $franchise_worker->id }}" {{ (old('worker_id') == $franchise_worker->id ? 'selected':'') }}>{{ $franchise_worker->name }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('worker_id'))
                            <label id="worker_id-error" class="error" for="worker_id">{{ $errors->first('worker_id') }}</label>
                        @endif
                    </div>
                </div>

                {{--<!-- <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <div class="form-line">
                                <label class="form-label">Date:</label>
                                <input type="text" class="form-control @if($errors->has('date')) is-invalid @endif datepicker" name="date" value="{{old('date')}}" autocomplete="off">
                                @if($errors->has('date'))
                                    <label id="date-error" class="error" for="date">{{ $errors->first('date') }}</label>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="id_end_time " class="fs-lb-tm">Time:</label>
                            <div class="input-group date" id="custom-slot-time">
                                <input type="text" name="time"  class="form-control" placeholder="Select Time" id="id_slot-time" readonly>
                                <div class="input-group-addon input-group-append">
                                    <div class="input-group-text">
                                        <i class="glyphicon glyphicon-time fa fa-clock-o"></i>
                                    </div>
                                </div>
                                @if($errors->has('time'))
                                    <label id="time-error" class="error" for="time">{{ $errors->first('time') }}</label>
                                @endif
                            </div>
                        </div>
                    </div>
                </div> -->--}}

                <button class="btn btn-primary waves-effect mt-1" type="submit">Submit</button>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>

<!-- franchise assign model End -->

@endsection

@section('scripts')


<script src="{{ asset('assets/front-assets/js/moment-with-locales.min.js') }}"></script>
<script src="{{ asset('assets/front-assets/js/bootstrap-datetimepicker.min.js') }}"></script>

<script src="{{ asset('assets/admin-assets/app-assets/vendors/js/pickers/daterange/moment.min.js') }}"></script>
<script src="{{ asset('assets/admin-assets/app-assets/vendors/js/pickers/daterange/daterangepicker.js') }}"></script>


<script>

    @if($errors->has('worker_id'))
        $('#order_rating_desc').modal();
    @endif

    $(".select2").select2({
        dropdownAutoWidth: true,
        width: '100%'
    });


    $('.btn-assign-service').click(function(){
        type = $(this).data('type');
        service_id = $(this).data('service_id');
        package_id = $(this).data('package_id');
        worker_service_id = $(this).data('worker_service_id');

        wid = $(this).data('worker-id');

        $('#form_assign_franchise #type').val(type);
        $('#form_assign_franchise #service_id').val(service_id);
        $('#form_assign_franchise #package_id').val(package_id);
        $('#form_assign_franchise #worker_service_id').val(worker_service_id);

        $("#worker_id option[value='"+wid+"']").remove();

    });

    $(function () {
        $('.datepicker').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            locale: {
            format: 'DD/MM/YYYY'
            },
            autoUpdateInput: true,
        });
    });

    $(document).ready(function(){
        $('#custom-slot-time').datetimepicker({
            "allowInputToggle": true,
            "showClose": true,
            "showClear": true,
            "showTodayButton": true,
            "format": "hh:mm A",
            "ignoreReadonly": true
            //"minDate": new Date()
        });

        $('#id_slot-time').val("");
    });

    $('.franchises-order-status').on( "click", function() {

        var id = $(this).data('id');

        Swal.fire({
            title: "What you want to do?",
            icon: "warning",
            showConfirmButton: false,
            customClass: 'swal-wide',
            showCloseButton: true,
            html: '<p><strong>Click Below Button To Manage Status</strong></p>'+
            '<div>'+
                '<button class="btn btn-success mr-25 franchises-status" data-id="'+id+'" data-status="1">Accept</button>'+
                '<button class="btn btn-danger mr-25 franchises-status"  data-id="'+id+'" data-status="2">Cancelled</button>'+
            '</div>'
        });

        $(document).on('click','.franchises-status',function(){
        id = $(this).data('id');
        status =  $(this).data('status');
        var _token = '{{ csrf_token() }}';
            $.ajax({
                url: "{{ route('franchises-worker-status') }}",
                type: 'POST',
                data: { id: id, status: status, _token: _token },
                success: function (franchises_orders) {
                    //console.log(leads.status);
                    if(franchises_orders.status == 0){
                        $('.span-'+id).empty();
                        $('.span-'+id).html('<span class="badge badge-pill badge-light-info">' + 'Pending' + '</span>');
                        Swal.close();
                    }
                    if(franchises_orders.status == 1){
                        $('.span-'+id).empty();
                        $('.span-'+id).html('<span class="badge badge-pill badge-light-success">' + 'Accept' + '</span>');
                        window.location.reload();
                        Swal.close();
                    }
                    if(franchises_orders.status == 2){
                        $('.span-'+id).empty();
                        $('.span-'+id).html('<span class="badge badge-pill badge-light-danger">' + 'Cancelled' + '</span>');
                        window.location.reload();
                        Swal.close();
                    }

                }
            });
        });

    });
</script>
@endsection
