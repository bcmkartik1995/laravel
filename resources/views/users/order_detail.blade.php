@php
   use Razorpay\Api\Api;
   use Carbon\Carbon;
@endphp
@extends('layouts.front')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/front-assets/css/plugin/sweetalert/sweetalert2.min.css') }}" media="screen">
<link rel="stylesheet" href="{{ asset('assets/front-assets/css/plugin/toaster/vendor/toastr.css') }}" media="screen">
@endsection

@section('content')

<div class="container">

    @include('layouts.flash-message')
    <div class="row  mt-5 or-spac">
        <div class="col-md-6 col-sm-6 col-12">
            <h4 class="or-hd">Order Number : {{$my_order->order_number}}</h4>
        </div>

        @if (in_array($my_order->status, ['pending','processing','on delivery']))
            <div class="col-md-1 col-sm-3 col-6 pb-2  ">
                <div class=" order-status-badge   btn-comp">
                    <i class="fa fa-refresh d-inline" aria-hidden="true"></i>
                    <span class="d-inline bt-cos">{{ucwords($my_order->status)}}</span>
                </div>
            </div>
        @elseif (in_array($my_order->status, ['completed']))
            <div class="col-md-1 col-sm-3 col-6 pb-2 text-right">
                <div class=" order-status-badge  btn-cancle">
                    <i class="fa fa-check d-inline" aria-hidden="true"></i>
                    <span class="d-inline bt-can">Completed</span>
                </div>
            </div>
        @elseif (in_array($my_order->status, ['cancelled']))
            <div class="col-md-1 col-sm-3 col-6 text-right">
                <div class=" order-status-badge  btn-cancle">
                    <i class="fa fa-times d-inline" aria-hidden="true"></i>
                    <span class="d-inline bt-can">Cancelled</span>
                </div>
            </div>
        @endif
        <!-- @if(in_array($my_order->status, ['pending','processing','on delivery']))
            <div class="col-md-1 col-sm-3 col-6 text-right">
                <a href="javascript:void(0);" class="order-status-badge  btn-cancle cancel_order">
                    <i class="fa fa-times d-inline" aria-hidden="true"></i>
                    <span class="d-inline bt-can">Cancel</span>
                </a>
            </div>
        @endif -->
    </div>

    <div class="row mt-md-4 mt-sm-3 mt-2  mb-5">
        <div class="col-md-6">
            <div class="box-book">
                <h4 class="sum-pad">Payment Summary</h4>
                @if(!empty($my_order->cart['packages']))
                    @foreach($my_order->cart['packages'] as $package)

                        <div class="row">
                            <div class="col-md-8 col-sm-8 col-8 ">
                                <p class="sum-sub-pad">{{$package['title']}} x{{$package['quantity']}}</p>
                            </div>
                            <div class="col-md-4 col-sm-4 col-4 text-right">
                                <p class="sum-sub-pads">₹{{$package['price']}}</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                @foreach($package['package_service'] as $service)
                                <p class="ps-nms-up  "> {{$service['title']}}</p>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @endif

                @if(!empty($my_order->cart['services']))
                    @foreach($my_order->cart['services'] as $service)
                        <div class="row">
                            <div class="col-md-8 col-sm-8 col-8 ">
                                <p class="sum-sub-pad">{{$service['title']}} x{{$service['quantity']}}</p>
                            </div>
                            <div class="col-md-4 col-sm-4 col-4 text-right">
                                <p class="sum-sub-pads">₹{{$service['price']}}</p>
                            </div>
                        </div>
                    @endforeach
                @endif


                <div class="row ">
                    <div class="col-md-8 col-sm-8 col-8 ">
                        <p class="sum-sub-pad">Offer discount</p>
                    </div>
                     <div class="col-md-4 col-sm-4 col-4 text-right">
                        <p class="sum-sub-pads">₹{{number_format(($my_order->coupon_discount ? $my_order->coupon_discount : 0), 2,'.','')}}</p>
                    </div>
                </div>

                <div class="row  sel-add">
                    <div class="col-md-11">
                        <div class="box-bor">
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-8 col-sm-8 col-8 ">
                        <p class="sum-sub-pad">Amount to Pay</p>
                    </div>
                     <div class="col-md-4 col-sm-4 col-4 text-right">
                        <p class="tot-pys">₹{{$my_order->pay_amount}}</p>
                    </div>
                </div>

                <div class="row sel-add pb-md-4 pb-sm-3 pb-2">
                    <div class="col-lg-3 col-md-4 col-sm-3 col-4 text-center">
                        @if($my_order->payment_status == 'Pending')
                              @php
                                 $pay_amount = $my_order->pay_amount;
                                 $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));
                                 $razorpayOrder  = $api->order->create([
                                    'receipt' => $my_order->order_number,
                                    'amount'  => $pay_amount*100,
                                    'currency' => 'INR'
                                 ]);

                                // print_r(Auth::user())
                              @endphp
                             <button id="rzp-button1" class="btn btn-primary btn-payment btn-block">Pay</button>
                             <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
                             <script>
                              var options = {
                                  "key": "{{env('RAZOR_KEY')}}", // Enter the Key ID generated from the Dashboard
                                  "amount": "{{$pay_amount*100}}", // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                                  "currency": "INR",
                                  "name": "{{env('APP_NAME')}}",
                                  "description": "Payment",
                                  "image": "{{asset('assets/front-assets/images/logo1.png')}}",
                                  "order_id": "{{$razorpayOrder->id}}", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
                                  "handler": function (response){
                                    document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                                    document.getElementById('razorpay_signature').value = response.razorpay_signature;
                                    document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
                                    document.razorpayform.submit();
                                  },
                                  "prefill": {
                                      "name": "{{Auth::user()->name}}",
                                      "email": "{{Auth::user()->email}}",
                                      "contact": "{{Auth::user()->mobile}}"
                                  },
                                  "notes": {
                                      "address": "",
                                      "merchant_order_id": "{{$my_order->order_number}}"
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
                              document.getElementById('rzp-button1').onclick = function(e){
                                  rzp1.open();
                                  e.preventDefault();
                              }
                              </script>
                              <form name='razorpayform' action="{{route('payment')}}" method="POST">
                                 @csrf
                                 <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                                 <input type="hidden" name="razorpay_signature"  id="razorpay_signature" >
                                 <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
                                 <input type="hidden" name="order_number" value="{{$my_order->order_number}}">
                             </form>
                           @else
                            <a href="javascript:void(0);" class="btn btn-block btn-pd btn-success">Paid</a>
                           @endif
                    </div>
                </div>


            </div>
        </div>
        <div class="col-md-6">
            <div class="box-book">

                 <div class="row ">
                    <div class="col-md-12">
                        <h4 class="sum-pad">Booking Details</h4>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-12 ">
                       <i class="fa fa-map-marker fa-lg d-inline sr-icon" aria-hidden="true"></i>
                       <p class="d-inline sr-loc">Service Location</p>
                       <p class="sr-add mb-0"> {{$my_order->cart['flat_building_no']}}, {{$my_order->cart['address']}}</p>
                    </div>

                </div>
                <div class="row ">
                    <div class="col-md-12 ">
                       <i class="fa fa-clock-o d-inline  sr-icon" aria-hidden="true"></i>
                       <p class="d-inline sr-loc">Timings</p>
                        <p class="sr-add mb-0"> {{date('D, d M, Y h:i a', strtotime($my_order->cart['slot_date'] .' '. $my_order->cart['slot_time']))}}</p>
                    </div>

                </div>
                <div class="row ">
                    <div class="col-md-12 ">
                     <i class="fa fa-credit-card  d-inline sr-icon" aria-hidden="true"></i>
                       <p class="d-inline sr-loc">Payment History</p>
                        <p class="sr-add">{{$my_order->payment_status}}</p>
                    </div>

                </div>

            </div>
        </div>

    </div>

    <div class="row pb-4">
        <div class="col-md-12">
            <div class="box-book">
                <div class="row">
                    <div class="col-md-12">
                         <h4 class="sum-pad">Booking {{$my_order->status}}</h4>
                         <p class="sr-bk">Booked for {{date('D, d M, Y h:i a', strtotime($my_order->cart['slot_date'] .' '. $my_order->cart['slot_time']))}}</p>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-12">

                        <p class="sr-bks"> A service provider will be assigned 15 minutes before booking time.</p>
                    </div>
                </div>

                <div class="row mt-2 sel-add">
                    <div class="col-md-12">
                        <div class="box-bor">
                        </div>
                    </div>
                </div>


                @if($my_order->franchise_orders->count())
                <div class="assignment-details">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="sum-pad">Service Providers Details</h4>
                        </div>
                    </div>


                    @foreach ($my_order->franchise_orders as $franchise_order)
                        <h5 class="sum-pas">{{ $franchise_order->franchise->franchise_name }}</h5>



                        <div class="row  frs-nms">
                            @php
                                $order_details = $franchise_order->order_details;
                            @endphp

                            @if(!empty($order_details['packages']))
                                @foreach ($order_details['packages'] as $package)


                                    <div class="col-md-12 ">
                                    <p class="sum-sub-pad"> {{$package['title']}} (Package)</p>
                                        <div class="bd-kn pl-0 pr-0">

                                            <div class="row">
                                                <div class="col-md-4  col-sm-4 col-4">
                                                    <div class="bd-title">Service Title</div>
                                                </div>
                                                <div class="col-md-2 col-sm-2 col-2">
                                                    <div class="bd-title ">Worker</div>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-3">
                                                    <div class="bd-title ">Time Slot</div>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-3">
                                                    <div class="bd-title ">Order Status</div>
                                                </div>
                                            </div>
                                            @foreach($package['package_service'] as $service)
                                                @php

                                                $worker_name = null;
                                                if(isset($worker_orders[$franchise_order->id]['packages'][$package['id']][$service['id']]->worker->name)){
                                                    $worker_name = $worker_orders[$franchise_order->id]['packages'][$package['id']][$service['id']]->worker->name;
                                                }

                                                $worker_status = null;
                                                if(isset($worker_orders[$franchise_order->id]['packages'][$package['id']][$service['id']]['status'])){
                                                    $worker_status = $worker_orders[$franchise_order->id]['packages'][$package['id']][$service['id']]['status'];
                                                }

                                                $start_time = null;
                                                if(isset($service['start_time'])){
                                                    $start_time =  Carbon::parse($service['start_time'])->format('d M, Y h:i a');
                                                }

                                                $end_time = null;
                                                if(isset($service['end_time'])){
                                                    $end_time = Carbon::parse($service['end_time'])->format('d M, Y h:i a');
                                                }
                                                @endphp
                                                <div class="row">
                                                    <div class="col-md-4  col-sm-4 col-4">
                                                            <div class="ps-nms">{{$service['title']}}</div>
                                                    </div>
                                                    <div class="col-md-2 col-sm-2 col-2">
                                                            <div class="ps-nms">{{$worker_name}}</div>
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 col-3">
                                                            <div class="ps-nms">{{$start_time}} To {{$end_time}}</div>
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 col-3">
                                                            <div class="ps-nms">
                                                                @if($worker_status == 0)
                                                                <span class="badge badge-pill badge-light-info"> Pending</span>
                                                                @elseif($worker_status == 1)
                                                                    <span class="badge badge-pill badge-light-primary"> Accept</span>
                                                                @elseif($worker_status == 2)
                                                                    <span class="badge badge-pill badge-light-danger"> Cancel</span>
                                                                @elseif($worker_status == 3)
                                                                    <span class="badge badge-pill badge-light-success"> Complete</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>

                                @endforeach
                            @endif

                            @if(!empty($order_details['services']))
                                @foreach ($order_details['services'] as $service)
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
                                        $start_time =  Carbon::parse($service['start_time'])->format('d M, Y h:i a');
                                    }

                                    $end_time = null;
                                    if(isset($service['end_time'])){
                                        $end_time = Carbon::parse($service['end_time'])->format('d M, Y h:i a');
                                    }
                                    @endphp
                                    <div class="col-md-12 ">
                                        <p class="sum-sub-pad"> {{$service['title']}}  (Service)</p>
                                        <div class="bd-kn pl-0 pr-0">

                                            <div class="row">
                                                <div class="col-md-4  col-sm-4 col-4">
                                                    <div class="bd-title">Service Title</div>
                                                </div>
                                                <div class="col-md-2 col-sm-2 col-2">
                                                    <div class="bd-title ">Worker</div>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-3">
                                                    <div class="bd-title ">Time Slot</div>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-3">
                                                    <div class="bd-title ">Order Status</div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4  col-sm-4 col-4">
                                                        <div class="ps-nms">{{$service['title']}}</div>
                                                </div>
                                                <div class="col-md-2 col-sm-2 col-2">
                                                    <div class="ps-nms">{{$worker_name}}</div>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-3">
                                                    <div class="ps-nms">{{$start_time}} To {{$end_time}}</div>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-3">
                                                    <div class="ps-nms">
                                                        @if($worker_status == 0)
                                                        <span class="badge badge-pill badge-light-info"> Pending</span>
                                                        @elseif($worker_status == 1)
                                                            <span class="badge badge-pill badge-light-primary"> Accept</span>
                                                        @elseif($worker_status == 2)
                                                            <span class="badge badge-pill badge-light-danger"> Cancel</span>
                                                        @elseif($worker_status == 3)
                                                            <span class="badge badge-pill badge-light-success"> Complete</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    @endforeach

                </div>
                @endif

            </div>

            @if($my_order->status == 'completed')
                <div class="box-book mt-4">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="sum-pad">Review & Rating <button type="button" class="btn btn-outline-dark review" data-type="order" data-id="{{$my_order->id}}" data-toggle="modal" data-target="#review">Order Review</button></h4>
                        </div>
                    </div>
                    @if(!empty($my_order->cart['packages']))
                        @foreach($my_order->cart['packages'] as $package)
                            <div class="row mt-md-3 mt-sm-2 mt-2 mb-mt-4 mb-sm-3 mb-2">
                                <div class="col-md-8 col-sm-6 col-6">
                                    <p class="sr-bs"> {{$package['title']}} </p>
                                </div>
                                <div class="col-lg-3 col-md-2 col-sm-3 col-3">
                                    <div class="row sel-add">
                                        <div class="col-md-3 col-sm-3 col-3 text-center">
                                            <button type="button" class="btn  btn-rev review" data-type="package" data-id="{{ $package['id'] }}" data-toggle="modal" data-target="#review">Review</button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    @if(!empty($my_order->cart['services']))
                        @foreach($my_order->cart['services'] as $service)
                            <div class="row mt-4 mb-5">
                                <div class="col-md-8 col-sm-6 col-6">
                                    <p class="sr-bs"> {{$service['title']}} </p>
                                </div>
                                <div class="col-md-2 col-sm-3 col-3">
                                    <div class="row sel-add">
                                        <div class="col-md-3 col-sm-3 col-3 text-center">
                                            <button type="button" class="btn  btn-rev  review" data-type="service" data-id="{{ $service['id'] }}" data-toggle="modal" data-target="#review">Review</button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>
            @endif
        </div>
    </div>

</div>


<div class="modal fade edit-modal " id="review" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content  edit-modal">
            <div class="modal-header border-bottom-0 pb-0">
                 <h2 class="modal-title text-center ad-rev-header">Add Your Review Here</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <form id="post-form-review" action="{{ url('send_review') }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="row rev-cen">
                        <div class="col-md-10">
                           <div class="form-group">
                             <input type="hidden" name="type" id="type">
                             <input type="hidden" name="id" id="id">
                              <div class="rate pl-0">

                                 <input type="radio" id="star5" name="rate" value="5" />
                                 <label for="star5" title="text">5 stars</label>
                                 <input type="radio" id="star4" name="rate" value="4" />
                                 <label for="star4" title="text">4 stars</label>
                                 <input type="radio" id="star3" name="rate" value="3" />
                                 <label for="star3" title="text">3 stars</label>
                                 <input type="radio" id="star2" name="rate" value="2" />
                                 <label for="star2" title="text">2 stars</label>
                                 <input type="radio" id="star1" name="rate" value="1" />
                                 <label for="star1" title="text">1 star</label>
                              </div>
                           </div>
                        </div>
                     </div>

                    <div class="row mt-2 rev-cen ">
                        <div class="col-md-10">
                            <div class="form-outline">
                                <textarea class="form-control " id="w3review" name="w3review" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4 rev-cen">
                        <div class="col-md-10">
                            <label style="text-align: left !important;">Upload Photos</label>
                            <input type="file" name="review_img[]" class="form-control" multiple="">
                        </div>
                    </div>
                    <div class="row sel-add mt-4">
                        <div class="col-md-4 col-sm-3 col-4 text-center">
                            <button type="submit" class="btn btn-revs submit_revivew">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script src="{{ asset('assets/front-assets/js/plugin/sweetalert/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets/front-assets/js/plugin/toaster/toastr.min.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('.review').on("click", function(){
            var type = $(this).attr("data-type");
            var id = $(this).attr("data-id");
            $('#type').val(type);
            $('#id').val(id);
        });

        $('.cancel_order').click(function(){
            $.ajax({
                url : '{{ url("/cancel_order/".$my_order->id) }}',
                type : 'post',
                async : false,
                data : {
                    '_token' : "{{ csrf_token() }}",
                },
                success : function(data)  {
                    if(data.success){

                    Swal.fire({
                            title: 'Success',
                            text: data.message,
                            type: "success",
                            showCancelButton: false,
                            confirmButtonColor: "#3085d6",
                            confirmButtonClass: "btn btn-primary",
                            closeOnConfirm: true,
                        }).then(function (result) {
                            window.location.reload();
                        });
                    }else{
                    Swal.fire("Error!", data.message, "error");
                    }
                }
            });
            return false;
        });

        $(".submit_revivew222").on("click",function(){
            var star_rate = $("input[name=rate]:checked").val();
            var comment = $("#w3review").val();
            var type = $('#type').val();
            var id = $('#id').val();
            
            var review_img = [];
            /*Initializing array with Checkbox checked values*/
            $("input[name='review_img[]']").each(function(){
                review_img.push(this.value);
            });
            console.log(review_img);
            return false;
            $.ajax({
                url : '{{ url("/send_review") }}',
                type : 'post',
                datatype:'json',
                data : {
                    '_token' : "{{ csrf_token() }}",
                    'type' : type,
                    'id' : id,
                    'comment' : comment,
                    'review_img' : review_img,
                    'star_rate' : star_rate
                },
                success : function(data)
                {
                    $('.input_review').html('');
                    $("#reviewModel").modal("hide");
                    $('.close').click();
                }

            });
            return false;
        });
    });
</script>
@endsection
