@extends('layouts.front')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="{{ asset('front/js/jquery.js') }}"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="{{ asset('front/css/payment-method.css') }}" media="screen">


<link rel="stylesheet" href="{{ asset('css/plugin/toaster/vendor/toastr.css') }}" media="screen">
<link rel="stylesheet" href="{{ asset('css/plugin/toaster/toastr.css') }}" media="screen">
<script src="{{ asset('js/plugin/toaster/toastr.min.js') }}"></script>

@section('content')
<form action="{{route('user.place_order')}}" method="post">
  @csrf
<section class="u-align-center u-clearfix u-white u-section-1" id="sec-fa17">

      <div class="u-clearfix u-sheet u-sheet-1">
        @include('layouts.flash-message')
        <div class="u-shape u-shape-circle u-white u-shape-1"></div>
        <div class="u-shape u-shape-circle u-white u-shape-2"></div>
        <div class="u-shape u-shape-circle u-white u-shape-3"></div>
        <div class="u-shape u-shape-circle u-white u-shape-4"></div>
        <h3 class="u-custom-font u-font-montserrat u-text u-text-1">Pay Using</h3>
        <div class="u-accordion u-spacing-15 u-accordion-1">
           {{-- <div class="u-accordion-item">
            <a class="active u-accordion-link u-active-custom-color-2 u-button-style u-custom-font u-font-montserrat u-grey-10 u-hover-grey-10 u-text-active-white u-text-custom-color-1 u-text-hover-custom-color-1 u-accordion-link-1" id="link-9c1d" aria-controls="9c1d" aria-selected="true">
              <span class="u-accordion-link-text">UPI</span><span class="u-accordion-link-icon u-icon u-text-active-white u-text-custom-color-1 u-icon-1"><svg class="u-svg-link" preserveAspectRatio="xMidYMin slice" viewBox="0 0 16 16" style=""><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-eddb"></use></svg><svg class="u-svg-content" viewBox="0 0 16 16" x="0px" y="0px" id="svg-eddb"><path d="M8,10.7L1.6,5.3c-0.4-0.4-1-0.4-1.3,0c-0.4,0.4-0.4,0.9,0,1.3l7.2,6.1c0.1,0.1,0.4,0.2,0.6,0.2s0.4-0.1,0.6-0.2l7.1-6
   c0.4-0.4,0.4-0.9,0-1.3c-0.4-0.4-1-0.4-1.3,0L8,10.7z"></path></svg></span>
            </a>
            <div class="u-accordion-active u-accordion-pane u-container-style u-white u-accordion-pane-1" id="9c1d" aria-labelledby="link-9c1d">
              <div class="u-container-layout u-container-layout-1">
                <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-2 u-text-default u-text-2">Add Existing UPI ID</p>
                <div class="u-custom-color-2 u-shape u-shape-circle u-shape-5"></div>
                <p class="u-custom-font u-font-montserrat u-text u-text-white u-text-3">+</p>
              </div>
            </div>
          </div>  --}}
           {{-- <div class="u-accordion-item">
            <a class="u-accordion-link u-active-custom-color-2 u-button-style u-custom-font u-font-montserrat u-grey-10 u-hover-grey-10 u-text-active-white u-text-custom-color-1 u-text-hover-custom-color-1 u-accordion-link-2" id="link-ee6a" aria-controls="ee6a" aria-selected="false">
              <span class="u-accordion-link-text">Credit/Debit Cards</span><span class="u-accordion-link-icon u-icon u-text-active-white u-text-custom-color-1 u-icon-2"><svg class="u-svg-link" preserveAspectRatio="xMidYMin slice" viewBox="0 0 16 16" style=""><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-a01d"></use></svg><svg class="u-svg-content" viewBox="0 0 16 16" x="0px" y="0px" id="svg-a01d"><path d="M8,10.7L1.6,5.3c-0.4-0.4-1-0.4-1.3,0c-0.4,0.4-0.4,0.9,0,1.3l7.2,6.1c0.1,0.1,0.4,0.2,0.6,0.2s0.4-0.1,0.6-0.2l7.1-6
   c0.4-0.4,0.4-0.9,0-1.3c-0.4-0.4-1-0.4-1.3,0L8,10.7z"></path></svg></span>
            </a>
            <div class="u-accordion-pane u-container-style u-white u-accordion-pane-2" id="ee6a" aria-labelledby="link-ee6a">
              <div class="u-container-layout u-container-layout-2">
                <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-2 u-text-default u-text-4">Add Existing UPI ID</p>
              </div>
            </div>
          </div>  --}}
           {{-- <div class="u-accordion-item">
            <a class="u-accordion-link u-active-custom-color-2 u-button-style u-custom-font u-font-montserrat u-grey-10 u-hover-grey-10 u-text-active-white u-text-custom-color-1 u-text-hover-custom-color-1 u-accordion-link-3" id="link-a10b" aria-controls="a10b" aria-selected="false">
              <span class="u-accordion-link-text">Wallet</span><span class="u-accordion-link-icon u-icon u-text-active-white u-text-custom-color-1 u-icon-3"><svg class="u-svg-link" preserveAspectRatio="xMidYMin slice" viewBox="0 0 16 16" style=""><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-67b6"></use></svg><svg class="u-svg-content" viewBox="0 0 16 16" x="0px" y="0px" id="svg-67b6"><path d="M8,10.7L1.6,5.3c-0.4-0.4-1-0.4-1.3,0c-0.4,0.4-0.4,0.9,0,1.3l7.2,6.1c0.1,0.1,0.4,0.2,0.6,0.2s0.4-0.1,0.6-0.2l7.1-6
   c0.4-0.4,0.4-0.9,0-1.3c-0.4-0.4-1-0.4-1.3,0L8,10.7z"></path></svg></span>
            </a>
            <div class="u-accordion-pane u-container-style u-white u-accordion-pane-3" id="a10b" aria-labelledby="link-a10b">
              <div class="u-container-layout u-container-layout-3">
                <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-2 u-text-5">AmazonPay</p>
                <img class="u-image u-image-default u-preserve-proportions u-image-1" src="{{'front/images/DSAO_LcXUAAP6jL.jpg'}}" alt="" data-image-width="543" data-image-height="543">
                <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-2 u-text-default u-text-6">Paytm</p>
                <img class="u-image u-image-default u-preserve-proportions u-image-2" src="{{'front/images/paytm-226448.png'}}" alt="" data-image-width="512" data-image-height="512">
              </div>
            </div>
          </div>  --}}
           {{-- <div class="u-accordion-item">
            <a class="u-accordion-link u-active-custom-color-2 u-button-style u-custom-font u-font-montserrat u-grey-10 u-hover-grey-10 u-text-active-white u-text-custom-color-1 u-text-hover-custom-color-1 u-accordion-link-4" id="link-a494" aria-controls="a494" aria-selected="false">
              <span class="u-accordion-link-text">Netbanking</span><span class="u-accordion-link-icon u-icon u-text-active-white u-text-custom-color-1 u-icon-4"><svg class="u-svg-link" preserveAspectRatio="xMidYMin slice" viewBox="0 0 16 16" style=""><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-a265"></use></svg><svg class="u-svg-content" viewBox="0 0 16 16" x="0px" y="0px" id="svg-a265"><path d="M8,10.7L1.6,5.3c-0.4-0.4-1-0.4-1.3,0c-0.4,0.4-0.4,0.9,0,1.3l7.2,6.1c0.1,0.1,0.4,0.2,0.6,0.2s0.4-0.1,0.6-0.2l7.1-6
   c0.4-0.4,0.4-0.9,0-1.3c-0.4-0.4-1-0.4-1.3,0L8,10.7z"></path></svg></span>
            </a>
            <div class="u-accordion-pane u-container-style u-white u-accordion-pane-4" id="a494" aria-labelledby="link-a494">
              <div class="u-container-layout u-container-layout-4">
                <form action="#" method="get" class="u-grey-10 u-search u-search-left u-search-1">
                  <button class="u-search-button" type="submit">
                    <span class="u-search-icon u-spacing-10">
                      <svg class="u-svg-link" preserveAspectRatio="xMidYMin slice" viewBox="0 0 56.966 56.966"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-fda6"></use></svg>
                      <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="svg-fda6" x="0px" y="0px" viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve" class="u-svg-content"><path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z"></path></svg>
                    </span>
                  </button>
                  <input class="u-custom-font u-font-montserrat u-search-input" type="search" name="search" value="" placeholder="Search">
                </form>
                <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-1 u-text-default u-text-7">Popular Banks</p>
                <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-2 u-text-default u-text-8">
                  <a class="u-active-none u-border-none u-btn u-button-link u-button-style u-hover-none u-none u-text-custom-color-2 u-text-hover-black u-btn-1" href="HDFC Bank">HDFC Bank</a>
                </p>
                <img class="u-image u-image-default u-preserve-proportions u-image-3" src="{{'front/images/HDFC-Bank-logo1.jpg'}}" alt="" data-image-width="206" data-image-height="262">
                <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-2 u-text-default u-text-9">
                  <a class="u-active-none u-border-none u-btn u-button-link u-button-style u-hover-none u-none u-text-custom-color-2 u-text-hover-custom-color-1 u-btn-2" href="ICICI Netbanking">ICICI Netbanking</a>
                </p>
                <img class="u-image u-image-default u-preserve-proportions u-image-4" src="{{'front/images/ICICI-Bank-PNG-Icon.png'}}" alt="" data-image-width="2048" data-image-height="2048">
                <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-2 u-text-default u-text-10">
                  <a class="u-active-none u-border-none u-btn u-button-link u-button-style u-hover-none u-none u-text-custom-color-2 u-text-hover-custom-color-1 u-btn-3" href="State Bank of India">State Bank of India</a>
                </p>
                <img class="u-image u-image-default u-preserve-proportions u-image-5" src="{{'front/images/SBI-Bank-PNG-Icon.png'}}" alt="" data-image-width="2048" data-image-height="2048">
              </div>
            </div>
          </div>  --}}
          <div class="u-accordion-item">
            <a class="u-accordion-link u-active-custom-color-2 u-button-style u-custom-font u-font-montserrat u-grey-10 u-hover-grey-10 u-text-active-white u-text-custom-color-1 u-text-hover-custom-color-1 u-accordion-link-2" id="link-ee6a" aria-controls="ee6a" aria-selected="false">
              <span class="u-accordion-link-text">Razorpay</span><span class="u-accordion-link-icon u-icon u-text-active-white u-text-custom-color-1 u-icon-2"><svg class="u-svg-link" preserveAspectRatio="xMidYMin slice" viewBox="0 0 16 16" style=""><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-a01d"></use></svg><svg class="u-svg-content" viewBox="0 0 16 16" x="0px" y="0px" id="svg-a01d"><path d="M8,10.7L1.6,5.3c-0.4-0.4-1-0.4-1.3,0c-0.4,0.4-0.4,0.9,0,1.3l7.2,6.1c0.1,0.1,0.4,0.2,0.6,0.2s0.4-0.1,0.6-0.2l7.1-6
   c0.4-0.4,0.4-0.9,0-1.3c-0.4-0.4-1-0.4-1.3,0L8,10.7z"></path></svg></span>
            </a>
            <div class="u-accordion-pane u-container-style u-white u-accordion-pane-2" id="ee6a" aria-labelledby="link-ee6a">
              <div class="u-container-layout u-container-layout-2">
                <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-2 u-text-default u-text-4"><input type="radio" class="payment_method_type" name="payment_method_type" value="Razorpay"> Pay with Razorpay</p>
              </div>
            </div>
          </div>
          <div class="u-accordion-item">
            <a class="u-accordion-link u-active-custom-color-2 u-button-style u-custom-font u-font-montserrat u-grey-10 u-hover-grey-10 u-text-active-white u-text-custom-color-1 u-text-hover-custom-color-1 u-accordion-link-5" id="link-e17d" aria-controls="e17d" aria-selected="false">
              <span class="u-accordion-link-text">Pay after service</span><span class="u-accordion-link-icon u-icon u-text-active-white u-text-custom-color-1 u-icon-5"><svg class="u-svg-link" preserveAspectRatio="xMidYMin slice" viewBox="0 0 16 16" style=""><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-9ec3"></use></svg><svg class="u-svg-content" viewBox="0 0 16 16" x="0px" y="0px" id="svg-9ec3"><path d="M8,10.7L1.6,5.3c-0.4-0.4-1-0.4-1.3,0c-0.4,0.4-0.4,0.9,0,1.3l7.2,6.1c0.1,0.1,0.4,0.2,0.6,0.2s0.4-0.1,0.6-0.2l7.1-6
   c0.4-0.4,0.4-0.9,0-1.3c-0.4-0.4-1-0.4-1.3,0L8,10.7z"></path></svg></span>
            </a>
            <div class="u-accordion-pane u-container-style u-white u-accordion-pane-5" id="e17d" aria-labelledby="link-e17d">
              <div class="u-container-layout u-valign-bottom u-container-layout-5">
                <p class="u-align-left u-custom-font u-font-montserrat u-text u-text-custom-color-2 u-text-11"><input type="radio"  class="payment_method_type" name="payment_method_type" value="Pay Online After Service"> Pay online after service</p>
                <p class="u-custom-font u-font-montserrat u-text u-text-custom-color-2 u-text-12"><input type="radio"  class="payment_method_type" name="payment_method_type" value="Cash On Delivery"> Pay with cash</p>
              </div>
            </div>
          </div>
          @error('payment_method_type')
                         <label id="payment_method_type-error" class="error" for="payment_method_type">{{ $message }}</label>
                     @enderror
        </div>
        <h3 class="u-align-left u-custom-font u-font-montserrat u-text u-text-default u-text-13">Payment Summary</h3>
        <div class="u-border-1 u-border-grey-75 u-container-style u-expanded-width-xs u-group u-radius-10 u-shape-round u-white u-group-1">
          <div class="u-container-layout u-container-layout-6">
            <h3 class="u-custom-font u-font-montserrat u-text u-text-default u-text-14">Service Quantity</h3>
            <h3 class="u-custom-font u-font-montserrat u-text u-text-15 text-right">{{$total_quantity}}</h3>
            <h3 class="u-custom-font u-font-montserrat u-text u-text-default-lg u-text-default-md u-text-default-sm u-text-default-xl u-text-16">Service Amount Payable</h3>
            <h3 class="u-custom-font u-font-montserrat u-text u-text-17 text-right">{{$cart_data['origional_price']}}</h3>
            <h3 class="u-custom-font u-font-montserrat u-text u-text-default-lg u-text-default-md u-text-default-sm u-text-default-xl u-text-18">Discount</h3>
            <h3 class="u-custom-font u-font-montserrat u-text u-text-19 text-right">{{$cart_data['discount']}}</h3>
            <h3 class="u-custom-font u-font-montserrat u-text u-text-default u-text-20">Total Service Amount</h3>
            <h3 class="u-custom-font u-font-montserrat u-text u-text-21 text-right">{{$cart_data['final_total']}}</h3>
            <h3 class="u-custom-font u-font-montserrat u-text u-text-default u-text-22">Amount Payable</h3>
            <h3 class="u-custom-font u-font-montserrat u-text u-text-23 text-right">{{$cart_data['final_total']}}</h3>
          </div>
        </div>
        <!-- <div class="u-border-1 u-border-custom-color-2 u-radius-10 u-shape u-shape-round u-white u-shape-6"></div>
        <h3 class="u-align-center-sm u-align-center-xs u-custom-font u-font-montserrat u-text u-text-custom-color-2 u-text-default u-text-24">Rs.10,000 insurance on online payment</h3>
        <p class="u-align-left u-custom-font u-font-montserrat u-text u-text-25"> By proceeding, you accept the latest versions of our T&amp;Cs Privacy policy and Cancellation Polic</p> -->
        <button type="submit" class="u-align-center u-border-none u-btn u-btn-round u-button-style u-custom-color-2 u-hover-custom-color-2 u-radius-6 u-btn-4 ">Place Order</button>
      </div>
    </section>
  </form>
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
