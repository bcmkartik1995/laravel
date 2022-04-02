@extends('layouts.worker')

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
                    <h5 class="content-header-title float-left pr-1 mb-0">Order</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('worker.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active"><a href="{{ route('worker.orders') }}">Orders</a>
                            </li>
                            <li class="breadcrumb-item">Order Details
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
                                @if(isset($order_data['services']))
                                <div class="col-md-12 mb-4">
                                    <table class="table table-borderless">
                                        <h6 class="card-title mt-2">Services</h6>
                                        <tr>
                                            <th>Service</th>
                                            <th>Take Time(Minutes)</th>
                                            <th>Scheduled Time</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach($order_data['services'] as $service)

                                            <tr>
                                                <td>{{$service['title']}}</td>
                                                <td>{{$service['take_time']}}</td>
                                                <td>{{Carbon::parse($service['start_time'])->format('d-m-Y h:i a')}} - {{Carbon::parse($service['end_time'])->format('d-m-Y h:i a')}}</td>
                                                <td>{{ucfirst($worker_order_status[$service['status']])}}</td>
                                                <td>
                                                    @if(in_array($service['status'], [0,1,3,4]))
                                                        <a href="javascript:void(0);" class="btn btn-primary worker-service-status" data-status="{{$service['status']}}" data-id="{{$service['id']}}">Manage Status</a>
                                                    @else
                                                        <a href="javascript:void(0);" class="btn btn-{{$service['status'] == 5 ? 'success':'danger'}} disabled">{{ucfirst($worker_order_status[$service['status']])}}</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                @endif
                                @if(isset($order_data['packages']))
                                <div class="col-md-12">

                                        <h6 class="card-title mt-2">Packages</h6>

                                        @foreach($order_data['packages'] as $package)
                                        <table class="table table-white table-bordered">
                                            <h6 class="font-weight-bold ml-1 mt-2">{{$package['title']}}</h6>
                                            <tr>
                                                <th>Service</th>
                                                <th>Take Time(Minutes)</th>
                                                <th>Scheduled Time</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            @foreach($package['services'] as $service)

                                            <tr>
                                                <td>{{$service['title']}}</td>
                                                <td>{{$service['take_time']}}</td>
                                                <td>{{Carbon::parse($service['start_time'])->format('d-m-Y h:i a')}} - {{Carbon::parse($service['end_time'])->format('d-m-Y h:i a')}}</td>
                                                <td>{{ucfirst($worker_order_status[$service['status']])}}</td>
                                                <td>
                                                    @if(in_array($service['status'], [0,1,3,4]))
                                                        <a href="javascript:void(0);" class="btn btn-primary worker-service-status" data-status="{{$service['status']}}" data-id="{{$service['id']}}">Manage Status</a>
                                                    @else
                                                        <a href="javascript:void(0);" class="btn btn-{{$service['status'] == 5 ? 'success':'danger'}} disabled">{{ucfirst($worker_order_status[$service['status']])}}</a>
                                                    @endif
                                                </td>
                                            </tr>
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
            </div>
    </div>
</div>



<!-- franchise assign model Start -->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Service Completed Confirmation</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <form id="form_extra_payment" method="POST" action="{{ route('worker.extra-payment') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="worker_assign_id" id="worker_assign_id" value="{{ old('worker_assign_id') }}">
                <input type="hidden" name="worker_id" id="worker_id" value="{{ old('worker_id') }}">
                <input type="hidden" name="order_id" id="order_id" value="{{ old('order_id') }}">
                <input type="hidden" name="f_order_id" id="f_order_id" value="{{ old('f_order_id') }}">
                <input type="hidden" name="payment_status" id="payment_status" value="{{ $booking->payment_status }}">
                
                <div class="form-group">
                    <div class="form-line">
                        <label class="form-label">Extra Payment</label>
                        <div class="checkbox">
                            <input type="hidden" name="extra_payment" value="">
                            <input type="checkbox" name="extra_payment" class="checkbox-input extra_payment" id="checkbox1" value="1" {{old('extra_payment') ? 'checked':''}}>
                            <label for="checkbox1">Please check if you collected extra payment.</label>
                        </div>
                        @if($errors->has('extra_payment'))
                            <label id="extra_payment-error" class="error" for="extra_payment">{{ $errors->first('extra_payment') }}</label>
                        @endif
                    </div>
                </div>
                <div class="form-group reason">
                    <div class="form-line">
                    <label class="form-label">Reason</label>
                        <input type="text" class="form-control" name="reason" id="reason">
                        @if($errors->has('reason'))
                            <label id="reason-error" class="error" for="reason">{{ $errors->first('reason') }}</label>
                        @endif
                    </div>
                </div>
                <div class="form-group amount">
                    <div class="form-line">
                    <label class="form-label">Amount</label>
                        <input type="text" class="form-control" name="amount" id="amount">
                        @if($errors->has('amount'))
                            <label id="amount-error" class="error" for="amount">{{ $errors->first('amount') }}</label>
                        @endif
                    </div>
                </div>
                @if($booking->payment_status == 'Pending')
                    <div class="form-group">
                        <div class="form-line">
                            <label class="form-label">Payment Recived</label>
                            <div class="checkbox">
                                <!-- <input type="hidden" name="payment_recived" value="0"> -->
                                <input type="checkbox" name="payment_recived" class="checkbox-input global_check" id="checkbox2" value="1" {{old('payment_recived') ? 'checked':''}}>
                                <label for="checkbox2">Please check if you collected order amount.</label>
                            </div>
                            @if($errors->has('payment_recived'))
                                <label id="payment_recived-error" class="error" for="payment_recived">{{ $errors->first('payment_recived') }}</label>
                            @endif
                        </div>
                    </div>
                @endif

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

<script>

    @if($errors->has('extra_payment') || $errors->has('reason') || $errors->has('amount') || $errors->has('payment_recived'))
        $('#myModal').modal();
    @endif

    $('.worker-service-status').on( "click", function() {
    var status = $(this).data('status');
    var id = $(this).data('id');
    //alert(id);
    html = '';
    if(status == 0){
        html = '<p><strong>Click Below Button To Manage Order Status</strong></p>'+

        '<div class="mt-2">'+
            '<button class="btn btn-primary order-status mr-25" data-status="1" data-id="'+id+'">Accept</button>'+
            '<button class="btn btn-danger order-status mr-25"  data-status="2" data-id="'+id+'">Decline</button>'+
        '</div>'
    }else if(status == 1){
        html = '<p><strong>Click Below Button To Manage Order Status</strong></p>'+

        '<div class="mt-2">'+
            '<button class="btn btn-primary order-status mr-25" data-status="3" data-id="'+id+'">Processing</button>'+
            '<button class="btn btn-danger order-status mr-25"  data-status="2" data-id="'+id+'">Decline</button>'+
        '</div>'
    }else if(status == 3){
        html = '<p><strong>Click Below Button To Manage Order Status</strong></p>'+

        '<div class="mt-2">'+
            '<button class="btn btn-primary order-status mr-25" data-status="4" data-id="'+id+'">On delivery</button>'+
            '<button class="btn btn-danger order-status mr-25"  data-status="2" data-id="'+id+'">Decline</button>'+
        '</div>'
    }else if(status == 4){
        html = '<p><strong>Click Below Button To Manage Order Status</strong></p>'+

        '<div class="mt-2">'+
            '<button class="btn btn-primary order-status mr-25" data-status="5" data-id="'+id+'">Completed</button>'+
            '<button class="btn btn-danger order-status mr-25"  data-status="2" data-id="'+id+'">Decline</button>'+
        '</div>'
    }

    Swal.fire({
        title: "What you want to do?",
        customClass: 'swal-wide',
        showConfirmButton: false,
        showCloseButton: true,
        html: html
    });
    $(document).on('click','.order-status',function(){
        status = $(this).data('status');
        id = $(this).data('id');

        var _token = "{{ csrf_token() }}";
        $.ajax({
            url: "{{ route('worker.orders-status') }}",
            type: 'POST',
            data: { status: status,id: id, _token: _token },
            success: function (data) {
                console.log(data.status);
                if(data.status == 1 || data.status == 2 || data.status == 3 || data.status == 4){
                    Swal.fire({
                    title: 'Success',
                    text: data.message,
                    type: "success",
                    showCancelButton: false,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonClass: "btn btn-primary",
                    closeOnConfirm: true,
                    }).then(function (result) {
                        window.location.reload();
                    });
                }else{
                    
                    Swal.close();
                    $('#myModal').modal('show');
                    $('#form_extra_payment #worker_assign_id').val(data.worker_assign_id);
                    $('#form_extra_payment #worker_id').val(data.worker_id);
                    $('#form_extra_payment #order_id').val(data.order_id);
                    $('#form_extra_payment #f_order_id').val(data.f_order_id);
                }
                
            }
        });
    });

});

$('.extra_payment').change(function() { 

    if($(this).is(':checked')){ 
        $('.reason').show(); 
        $('.amount').show(); 
    }else{
        $('.reason').hide(); 
        $('.amount').hide();
    }

});

$(document).ready(function(){
    $('.extra_payment').trigger('change');
});
</script>

@endsection
