<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
use Session;
use Redirect;
use App\Orders;
use App\Franchises_order;
use App\Worker_assigned_services;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class RazorpayController extends Controller
{

    public function payment(Request $request) {

        $input = $request->all();

        $order_number = $input['order_number'];
        $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));


        $success = true;
        $error = "Payment Failed";

        if (empty($_POST['razorpay_payment_id']) === false) {

            try {
                $attributes = array(
                    'razorpay_order_id' => $input['razorpay_order_id'],
                    'razorpay_payment_id' => $input['razorpay_payment_id'],
                    'razorpay_signature' => $input['razorpay_signature']
                );
                $api->utility->verifyPaymentSignature($attributes);
            }  catch(SignatureVerificationError $e) {
                $success = false;
                $error = 'Razorpay Error : ' . $e->getMessage();
            }
        }
        if ($success === true){
            $razorpayOrder = $api->order->fetch($input['razorpay_order_id']);

            $transaction_id = $input['razorpay_payment_id'];
            $order =  Orders::where('order_number', $order_number)->first();

            $Franchises_order = Franchises_order::where('orders_id', $order->id)->update(['pay_status' => 'Paid']);
            $Worker_assigned_services = Worker_assigned_services::where('order_id', $order->id)->update(['pay_status' => 'Paid']);
            if (isset($order))  {
                $order->pay_id = $transaction_id;
                $order->payment_status = 'Paid';
                $order->save();

            }
            return redirect()->back()->with(['success' => 'Your payment has been done successfully.']);
        }
        return redirect()->back()->with(['error' => $error]);
    }


    public function payment_link(Request $request) {

        // $data_arr = [
        //     'order_id' => 6
        // ];
        // $data_string = json_encode($data_arr);
        // $error_message = null;
        // $encripted = Crypt::encryptString($data_string);
        // $decrypted = Crypt::decryptString($encripted);

        if(!empty($request->hash)){
            try {
                $decrypted = Crypt::decryptString($request->hash);
            } catch (DecryptException $e) {
                $error_message = "Invalid link";
            }

            if(!empty($decrypted)){
                $data = json_decode($decrypted, true);

                $order_id = $data['order_id'];
                $my_order =  Orders::where('id', $order_id)->first();

                if($my_order->payment_status != 'Paid'){
                    return view('front.link-payment', compact('my_order'));
                }else{
                    $error_message = "Payment has been already done for this order.";
                }
                // echo '<pre>';
                // print_R($my_order->payment_status);die;
            }
        }else{
            $error_message = "Invalid link";
        }

        if(!empty($error_message)){
            $back_url = route('front.index');
            return view('front.payment-error', compact('error_message','back_url'));
        }

    }

    public function payment_link_post(Request $request) {

        $input = $request->all();

        $order_number = $input['order_number'];
        $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));

        $success = true;
        $error = "Payment Failed";

        if (empty($_POST['razorpay_payment_id']) === false) {

            try {
                $attributes = array(
                    'razorpay_order_id' => $input['razorpay_order_id'],
                    'razorpay_payment_id' => $input['razorpay_payment_id'],
                    'razorpay_signature' => $input['razorpay_signature']
                );
                $api->utility->verifyPaymentSignature($attributes);
            }  catch(SignatureVerificationError $e) {
                $success = false;
                $error = 'Razorpay Error : ' . $e->getMessage();
            }
        }
        if ($success === true){
            $razorpayOrder = $api->order->fetch($input['razorpay_order_id']);

            $transaction_id = $input['razorpay_payment_id'];
            $order =  Orders::where('order_number', $order_number)->first();

            $Franchises_order = Franchises_order::where('orders_id', $order->id)->update(['pay_status' => 'Paid']);
            $Worker_assigned_services = Worker_assigned_services::where('order_id', $order->id)->update(['pay_status' => 'Paid']);
            if (isset($order))  {
                $order->pay_id = $transaction_id;
                $order->payment_status = 'Paid';
                $order->save();
            }
            $back_url = route('front.index');
            $response = ['success_message' => 'Your payment for order number '.$order_number.' has been done successfully.', 'back_url' => $back_url,'order_number' => $order_number];
            return redirect()->route('payment_success')->with(['data' => $response]);
        }

        $back_url = route('front.index');
        $error_message = $error;
        return view('front.payment-error', compact('error_message','back_url'));
    }

    public function payment_success(Request $request) {

        $data = Session::get('data');
        $back_url = route('front.index');
        if(isset($data['back_url'])){
            $back_url = $data['back_url'];
        }
        $success_message = null;
        if(isset($data['success_message'])){
            $success_message = $data['success_message'];
        }
        if(empty($success_message)){
            return redirect($back_url);
        }
        $order_number = null;
        $order = [];
        if(isset($data['order_number'])){
            $order_number = $data['order_number'];
            $order =  Orders::where('order_number', $order_number)->first();
        }

        return view('front.payment-success', compact('success_message','back_url','order_number','order'));
    }


}
