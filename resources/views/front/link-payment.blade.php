@php
use Razorpay\Api\Api;
    $pay_amount = $my_order->pay_amount;
    $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));
    $razorpayOrder  = $api->order->create([
    'receipt' => $my_order->order_number,
    'amount'  => $pay_amount*100,
    'currency' => 'INR'
    ]);

// print_r(Auth::user())
@endphp
<button id="rzp-button1" class="btn btn-primary btn-payment btn-block" style="display: none;">Pay</button>
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
        "name": "{{$my_order->user->name}}",
        "email": "{{$my_order->user->email}}",
        "contact": "{{$my_order->user->mobile}}"
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
document.getElementById('rzp-button1').click();
</script>
<form name='razorpayform' id='razorpayform' action="{{route('payment_link_post')}}" method="POST">
    @csrf
    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
    <input type="hidden" name="razorpay_signature"  id="razorpay_signature" >
    <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
    <input type="hidden" name="order_number" value="{{$my_order->order_number}}">
</form>

