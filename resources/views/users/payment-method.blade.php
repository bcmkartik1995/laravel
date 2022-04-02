@extends('layouts.front')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/front-assets/css/plugin/sweetalert/sweetalert2.min.css') }}" media="screen">
@endsection

@section('content')
<div class="container">

    <div class="row mt-5 sel-add">
        <div class="col-md-8 text-center">
            @include('layouts.flash-message')
        </div>
    </div>

    <form action="{{route('user.place_order')}}" method="post">
        @csrf
        <h2 class=" my-tst text-center title-contain payment-title">Pay Using</h2>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="sel-add">
                    <div class="btn-home">
                        <a class="btn-sub-home d-block" data-toggle="collapse" href="#collapseExample4" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Razorpay
                        <!-- <img class="down-img" src="{{ asset('assets/front-assets/images/down3.png') }}"> -->
                        <i class="fas fa-chevron-down down-img"></i>
                        </a>
                    </div>
                </div>
                <div class="collapse {{in_array($payment_method_type,['Razorpay']) ? 'show':''}}" id="collapseExample4">
                    <div class="sel-add">
                        <div class="form-check rd-text">
                        <label class="form-check-label fr-ch-lb">
                            <input type="radio" class="form-check-input sel-text payment_method_type" name="payment_method_type" value="Razorpay" {{$payment_method_type=='Razorpay' ? 'checked':''}}> Pay with Razorpay
                        </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="sel-add">
                    <div class="btn-home ">
                        <a class="btn-sub-home d-block" data-toggle="collapse" href="#collapseExample5" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Pay after service
                        <!-- <img class="down-img" src="{{ asset('assets/front-assets/images/down3.png') }}"> -->
                        <i class="fas fa-chevron-down down-img"></i>
                        </a>
                    </div>
                </div>
                <div class="collapse {{in_array($payment_method_type,['Pay Online After Service','Cash On Delivery']) ? 'show':''}}" id="collapseExample5">
                    <div class="sel-add">
                            <div class="form-check rd-text">
                            <label class="form-check-label fr-ch-lb">
                                <input type="radio" class="form-check-input sel-text payment_method_type"  name="payment_method_type" value="Pay Online After Service" {{$payment_method_type=='Pay Online After Service' ? 'checked':''}}> Pay online after service
                            </label>
                            </div>
                            @if($cart_data['final_total'] <= 499)
                            <div class="form-check rd-text">
                            <label class="form-check-label fr-ch-lb">
                                <input type="radio" class="form-check-input sel-text payment_method_type"  name="payment_method_type" value="Cash On Delivery" {{$payment_method_type=='Cash On Delivery' ? 'checked':''}}> Pay with cash
                            </label>
                            </div>
                            @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row sel-add">
            <div class="col-md-12 mt-4">
                @error('payment_method_type')
                    <label id="payment_method_type-error" class="error" for="payment_method_type">{{ $message }}</label>
                @enderror

            </div>
        </div>


        <h2 class=" my-tst text-center  title-contain payment-title">Payment Summary</h2>

            <div class="row sel-add pt-0">
                <div class="col-lg-6 col-md-8 col-sm-12 text-center">
                    <div class="outer-box sel-add">
                        <div class="row">
                            <div class="col-md-8 col-sm-6 col-8">
                                <p class="sum-text">Service Quantity</p>
                            </div>
                            <div class="col-md-4 col-sm-6 col-4">
                                <p class="sum-text1">{{$total_quantity}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 col-sm-6 col-8">
                                <p class="sum-text">Service Amount Payable</p>
                            </div>
                            <div class="col-md-4 col-sm-6 col-4">
                                <p class="sum-text1">₹{{number_format($cart_data['origional_price'],2,'.','')}}</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-sm-6 col-8">
                                <p class="sum-text">Discount</p>
                            </div>
                            <div class="col-md-4 col-sm-6 col-4">
                                <p class="sum-text1">₹{{number_format($cart_data['discount'],2,'.','')}}</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-sm-6 col-8">
                                <p class="sum-text">Total Service Amount</p>
                            </div>
                            <div class="col-md-4 col-sm-6 col-4">
                                <p class="sum-text1">₹{{number_format($cart_data['final_total'],2,'.','')}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 col-sm-6 col-8">
                                <p class="sum-text">Amount Payable</p>
                            </div>
                            <div class="col-md-4 col-sm-6 col-4">
                                <p class="sum-text1">₹{{number_format($cart_data['final_total'],2,'.','')}}</p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <div class="row sel-add tm-pic mt-4">
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 text-center">
                    <button type="submit" class="btn-block btn-next btn-sub-next d-block">Place Order</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
<script>
   $(document).ready(function(){


      $('.place-order').click(function(){
         payment_type = $('.payment_method_type:checked').val();
         if(!payment_type){
            toastr.error('Please select payment method', 'Error', { "progressBar": true });
            return false;
         }

         $('.place-order').prop('disabled', true);
         data = {
            'payment_type' : payment_type
         }
         $.ajax({
              header:{
                  'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
              },
              url: "{{ route('user.place_order') }}",
              type : "post",
              dataType:'json',
              data : {
                  "_token": "{{ csrf_token() }}",
                  "data": data
              },
              success : function(data) {
                  $('.place-order').prop('disabled', false);
                  if(data.success){
                      /////////////////window.location.href = "{{ url('/order_details/') }}/" +data.order_id;
                  }else{
                     //error message
                  }
              }
          });
          return false;
      });

   })

</script>

@endsection
