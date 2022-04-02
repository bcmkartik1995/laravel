@extends('layouts.admin')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/app-assets/vendors/css/forms/select/select2.min.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-assets/css/pricing.css') }}">

<style>
    .shadow-custome{
        box-shadow: -8px 12px 18px 0 rgba(25, 42, 70, 0.13);
    }
    .description p {
        margin: 16px !important;
    }
</style>
@endsection

@php
   use Razorpay\Api\Api;
@endphp

@section('content')

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h5 class="content-header-title float-left pr-1 mb-0">Franchise</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active"><a href="{{ route('franchise_credits.index') }}">Credit Plans</a>
                            </li>
                            <li class="breadcrumb-item">Purchase Credit
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Basic Vertical form layout section start -->

        @if(!empty($Credit_price))
        <section id="basic-vertical-layouts">
            <div class="row match-height">
                <div class="col-md-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Custom Credit Plan</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="form-label">Price For One Credit</label>
                                                <input type="number" class="form-control" id="plan_price" readonly value="{{number_format($Credit_price->price,2,'.','')}}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="form-label">Credit</label>
                                                <input type="number" class="form-control" name="credit" id="credit">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="form-label">Amount</label>
                                                <input type="number" class="form-control" id="plan_amount" readonly value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary waves-effect mt-1 btn-custom-plan" type="button">Purchase</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @endif

        <section id="basic-vertical-layouts">
            <div class="row match-height">
                <div class="col-md-12 col-12">
                    <div class="card ">
                        <div class="card-header">
                            <h4 class="card-title">Purchase Credit Plan</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="row justify-content-between ml-3 mr-3">
                                            @if($Credit_plans->count())

                                                @foreach($Credit_plans as $Credit_plan)

                                                    <div class="col-xl-3 col-md-6 img-top-card">
                                                        <div class="shadow-custome">
                                                            <div class="card widget-img-top">
                                                                <div class="card-content">
                                                                    <img class="card-img-top img-fluid mb-1" src="{{ asset('assets/images/creditplanbanner') }}/{{ $Credit_plan->image }}" alt="Card image cap" width="100%"/>
                                                                    <div class="text-center">
                                                                        <h4>{{$Credit_plan->title}}</h4>
                                                                        <small>{{$Credit_plan->credit_value}} Credit</small>
                                                                        <p class="mt-1"><span class="h4">₹{{$Credit_plan->price}}</span>/{{$Credit_plan->validity_value}} {{$validity_types[$Credit_plan->validity_type]}}</p>
                                                                        <div class="description">
                                                                            <p>{!! $Credit_plan->description !!}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="card-footer text-center">
                                                                    <button type="button" class="btn btn-primary glow px-4 btn-plan-detail" data-id="{{$Credit_plan->id}}">Select</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{--<!-- <div class="col-6 col-lg-4 col-mb-6 col-sm-6 mb-4">
                                                        <div class="card pricing h-100 shadow-lg">
                                                            <div class="card-body">
                                                            <div class="text-center p-4">
                                                                <h5 class="card-title">{{$Credit_plan->title}}</h5>
                                                                <small>{{$Credit_plan->credit_value}} Credit</small>
                                                                <br><br>
                                                                <span class="h4">₹{{$Credit_plan->price}}</span>/{{$Credit_plan->validity_value}} {{$validity_types[$Credit_plan->validity_type]}}
                                                                <br><br>
                                                            </div>
                                                            <div class="card-text">{!! $Credit_plan->description !!}</div>
                                                            </div>
                                                            <div class="card-body text-center">
                                                            <button class="btn btn-outline-primary btn-lg btn-plan-detail" data-id="{{$Credit_plan->id}}" style="border-radius:30px">Select</button>
                                                            </div>
                                                        </div>
                                                    </div> -->--}}
                                                @endforeach
                                            @else
                                                <div class="col-md-12">
                                                    <h6>No any plans available.</h6>
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
        </section>
        <!-- // Basic Vertical form layout section end -->
    </div>
</div>

<button id="rzp-button1" class="btn-payment hidden">Pay</button>
<form name='razorpayform' action="{{route('franchise_credits.credit_payment')}}" method="POST">
    @csrf
    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
    <input type="hidden" name="razorpay_signature"  id="razorpay_signature" >
    <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
    <input type="hidden" name="credit_order_number" id="credit_order_number" value="">
    <input type="hidden" name="plan_id" id="plan_id" value="">
    <input type="hidden" name="planamount" id="planamount" value="">
    <input type="hidden" name="planprice" id="planprice" value="">
    <input type="hidden" name="planqty" id="planqty" value="">

</form>
@endsection

@section('scripts')


<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    function calculate_price(){
        credit = plan_price = 0;
        if($('#credit').val()){
            credit = parseFloat($('#credit').val());
        }
        if($('#plan_price').val()){
            plan_price = parseFloat($('#plan_price').val());
        }

        plan_amount = credit*plan_price;
        $('#plan_amount').val(plan_amount.toFixed(2));
    }
    $(document).ready(function(){

        $('.btn-custom-plan').click(function(){
            if(!$('#credit').val()){
                Swal.fire("Error", "Please enter how many credit you want to purchase ?", "error");
                return false;
            }

            data = {
                _token: "{{ csrf_token() }}",
                is_custom_plan:true,
                price:$('#plan_price').val(),
                qty:$('#credit').val()
            };
            $.ajax({
                url: "{{route('franchise_credits.get_plan_detail')}}",
                type: 'post',
                dataType:"json",
                data: data,
                success: function (data) {
                    if(data.success){
                        document.getElementById('credit_order_number').value = data.ragorpay.receipt;
                        document.getElementById('plan_id').value = '';
                        document.getElementById('planprice').value = data.plan.price;
                        document.getElementById('planqty').value = data.plan.qty;
                        document.getElementById('planamount').value = data.plan.amount;
console.log(data.plan)
                        var options = {
                            "key": "{{env('RAZOR_KEY')}}", // Enter the Key ID generated from the Dashboard
                            "amount": data.plan.amount, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                            "currency": "INR",
                            "name": "{{env('APP_NAME')}}",
                            "description": "Payment",
                            "image": "{{asset('assets/front-assets/images/logo1.png')}}",
                            "order_id": data.ragorpay.id, //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
                            "handler": function (response){
                                document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                                document.getElementById('razorpay_signature').value = response.razorpay_signature;
                                document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
                               // console.log(response);
                                //return false;
                                document.razorpayform.submit();
                            },
                            "prefill": {
                                "name": "{{Auth::guard('admin')->user()->name}}",
                                "email": "{{Auth::guard('admin')->user()->email}}",
                                "contact": "{{Auth::guard('admin')->user()->mobile}}"
                            },
                            "notes": {
                                "address": "",
                            },
                            "theme": {
                                "color": "#ff7400"
                            }
                        };
                        var rzp1 = new Razorpay(options);
                        rzp1.on('payment.failed', function (response){
                            //   alert(response.error.code);
                            //   alert(response.error.description);
                            //   alert(response.error.source);
                            //   alert(response.error.step);
                            //   alert(response.error.reason);
                            //   alert(response.error.metadata.order_id);
                            //   alert(response.error.metadata.payment_id);
                        });
                        //document.getElementById('rzp-button1').onclick = function(e){
                            rzp1.open();

                           // e.preventDefault();
                        //}
                    }else{
                        Swal.fire("Error", data.message, "error");
                    }
                }
            });
        });

        $('#credit').blur(function(){
            calculate_price();
        });

        $('.btn-plan-detail').click(function(){
            var id = $(this).data('id');
            $.ajax({
                url: "{{route('franchise_credits.get_plan_detail')}}",
                type: 'post',
                dataType:"json",
                data: { _token: "{{ csrf_token() }}", id:id },
                success: function (data) {
                    if(data.success){
                        document.getElementById('credit_order_number').value = data.ragorpay.receipt;
                        document.getElementById('plan_id').value = data.plan.id;

                        var options = {
                            "key": "{{env('RAZOR_KEY')}}", // Enter the Key ID generated from the Dashboard
                            "amount": data.plan.price * 100, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                            "currency": "INR",
                            "name": "{{env('APP_NAME')}}",
                            "description": "Payment",
                            "image": "{{asset('assets/front-assets/images/logo1.png')}}",
                            "order_id": data.ragorpay.id, //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
                            "handler": function (response){
                                document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                                document.getElementById('razorpay_signature').value = response.razorpay_signature;
                                document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
                               // console.log(response);
                                //return false;
                                document.razorpayform.submit();
                            },
                            "prefill": {
                                "name": "{{Auth::guard('admin')->user()->name}}",
                                "email": "{{Auth::guard('admin')->user()->email}}",
                                "contact": "{{Auth::guard('admin')->user()->mobile}}"
                            },
                            "notes": {
                                "address": "",
                            },
                            "theme": {
                                "color": "#ff7400"
                            }
                        };
                        var rzp1 = new Razorpay(options);
                        rzp1.on('payment.failed', function (response){
                            //   alert(response.error.code);
                            //   alert(response.error.description);
                            //   alert(response.error.source);
                            //   alert(response.error.step);
                            //   alert(response.error.reason);
                            //   alert(response.error.metadata.order_id);
                            //   alert(response.error.metadata.payment_id);
                        });
                        //document.getElementById('rzp-button1').onclick = function(e){
                            rzp1.open();

                           // e.preventDefault();
                        //}
                    }else{
                        Swal.fire("Error", data.message, "error");
                    }
                }
            });
        });
    })
</script>

@endsection
