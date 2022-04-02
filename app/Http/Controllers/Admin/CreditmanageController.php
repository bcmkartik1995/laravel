<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Credit_price;
use App\Credit_plans;
use App\Franchise_plans;
use Auth;
use Illuminate\Support\Str;

use Razorpay\Api\Api;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class CreditmanageController extends Controller
{
    public function set_credit_price(Request $request){

        $request->validate([
            'price' => 'required|numeric',
        ]);

        $Credit_price = Credit_price::first();
        if(empty($Credit_price)){
            $Credit_price = new Credit_price;
        }

        $Credit_price->price = $request->price;
        $Credit_price->save();
        return redirect('admin/credit_plans')->with('update_message','Data Saved Successfully');
    }

    public function franchise_credits(){
        $user_id = Auth::guard('admin')->user()->id;

        $franchise = Auth::guard('admin')->user()->getFranchise();

        $franchise_credits = Franchise_plans::where(['franchise_id' => $franchise->id])->get();

        $validity_types = [1 => 'Day', 2 => 'Week', 3 => 'Month', 4 => 'Year'];
        // echo '<pre>';
        // print_R($franchise_credits);die;
        return view('admin.franchise_credits.index',compact('franchise_credits','validity_types'));
    }

    public function create(){

        $Credit_price = Credit_price::first();
        $validity_types = [1 => 'Day', 2 => 'Week', 3 => 'Month', 4 => 'Year'];
        $user_id = Auth::guard('admin')->user()->id;
        $Credit_plans = Credit_plans::where(['status' => 1])->get();
        
        return view('admin.franchise_credits.create',compact('Credit_plans','user_id','validity_types','Credit_price'));
    }

    public function get_plan_detail(Request $request){

        if(isset($request->is_custom_plan) && !empty($request->is_custom_plan)){
            $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));

            $order_id = Str::random(4) . time();

            $amount = $request->price * $request->qty;
            Session::put('ragorpay.credit.order_id', $order_id);
            $razorpayOrder  = $api->order->create([
            'receipt' => $order_id,
            'amount'  => $amount*100,
            'currency' => 'INR'
            ])->toArray();

            $custom_plan = [
                'price' => $request->price,
                'qty' => $request->qty,
                'amount' => $amount
            ];
            return response()->json(['success' => 1, 'plan' => $custom_plan, 'ragorpay' => $razorpayOrder]);
        }else{
            $id = $request->id;
            $Credit_plans = Credit_plans::where(['id' => $id, 'status' => 1])->first();
            if(empty($Credit_plans)){
                return response()->json(['success' => 0, 'message' => 'Something went wrong']);
            }

            $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));

            $order_id = Str::random(4) . time();

            Session::put('ragorpay.credit.order_id', $order_id);
            $razorpayOrder  = $api->order->create([
            'receipt' => $order_id,
            'amount'  => $Credit_plans->price*100,
            'currency' => 'INR'
            ])->toArray();

            return response()->json(['success' => 1, 'plan' => $Credit_plans, 'ragorpay' => $razorpayOrder]);
        }

    }

    public function credit_payment(Request $request){

        $input = $request->all();

        $credit_order_number = $input['credit_order_number'];
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

            $user_id = Auth::guard('admin')->user()->id;

            $franchise = Auth::guard('admin')->user()->getFranchise();

            $Franchise_plans = new Franchise_plans;
            $Franchise_plans->franchise_id = $franchise->id;
            $Franchise_plans->razorpay_id = $input['razorpay_payment_id'];

            if(isset($input['plan_id']) && !empty($input['plan_id'])){
                $plan_id = $input['plan_id'];
                $Credit_plan = Credit_plans::where(['id' => $plan_id, 'status' => 1])->first();
                //$validity_types = [1 => 'Day', 2 => 'Week', 3 => 'months', 4 => 'Year'];
                //$duration = $validity_types[$Credit_plan->validity_type];
                //$period = new CarbonPeriod('2021-06-06', $Credit_plan->validity_value.' '.$duration);

                $start_date = Carbon::now()->format("Y-m-d");
                $end_date = Carbon::now();
                if($Credit_plan->validity_type == 1){
                    $end_date->addDays($Credit_plan->validity_value);
                }elseif($Credit_plan->validity_type == 2){
                    $end_date->addWeek($Credit_plan->validity_value);
                }elseif($Credit_plan->validity_type == 3){
                    $end_date->addMonth($Credit_plan->validity_value);
                }elseif($Credit_plan->validity_type == 4){
                    $end_date->addYear($Credit_plan->validity_value);
                }
                $end_date->subDays(1);
                $end_date = $end_date->format("Y-m-d");

                $Franchise_plans->start_date = $start_date;
                $Franchise_plans->end_date = $end_date;

                $Franchise_plans->plan_id = $plan_id;
                $Franchise_plans->price = $Credit_plan->price;
                $Franchise_plans->amount = $Credit_plan->price;
                $Franchise_plans->total_credits = $Credit_plan->credit_value;
                $Franchise_plans->remain_credits = $Credit_plan->credit_value;
                $Franchise_plans->qty = 1;
            }else{
                $Franchise_plans->plan_id = 0;
                $Franchise_plans->price = $input['planprice'];
                $Franchise_plans->amount = $input['planamount'];
                $Franchise_plans->total_credits = $input['planqty'];
                $Franchise_plans->remain_credits = $input['planqty'];
                $Franchise_plans->qty = $input['planqty'];
                $Franchise_plans->is_custom = 1;
            }

            $Franchise_plans->save();
            return redirect()->route('franchise_credits.index')->with(['success' => 'Your payment has been done successfully.']);
        }
        return redirect()->back()->with(['error' => $error]);
    }

}
