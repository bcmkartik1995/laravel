<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Admin;
use App\Franchise;

class AccountsController extends Controller
{
    use ApiResponser;

    public function franchise_account(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }

        $user_id = $request->user_id;
        //$franchises_id = Franchise::where('user_id',$user_id)->first();

        $franchise = Franchise::with(['frenchise_orders' => function ($query) {
            $query->with(['f_order' => function($q){
                $q->select('id','method','pay_amount','status','payment_status');
            }]);
            // ->where(['status' => 1,'pay_status' => 'Paid']);
        }])
        ->with(['payments' => function ($query) {
            $query->select('payments.*');
        }])
        ->join('admins as a', 'franchises.user_id', '=', 'a.id')
        ->select('franchises.id','franchises.franchise_name','franchises.created_at','franchises.updated_at','a.name as user_name','franchises.commission')
        ->orderBy('franchises.id', 'DESC')
        ->where('user_id',$user_id)
        ->first();



        $franchise->credit_amount = 0;
        $franchise->debit_amount = 0;
        $franchise->offline_amount = 0;
        $franchise->online_amount = 0;
        $franchise->total_commission = 0;
        $franchise->total_franchise_payment = 0;

        if(!empty($franchise)){

            if(!empty($franchise->frenchise_orders)){
                foreach($franchise->frenchise_orders as $frenchise_order){

                    if(!empty($frenchise_order->f_order)){


                        if($frenchise_order->f_order->payment_status == 'Paid' || $frenchise_order->f_order->payment_status == 'Refund'){


                            if($frenchise_order->f_order->method == 'Cash On Delivery'){

                                if(isset($frenchise_order->order_details['services']) && $frenchise_order->f_order->status == 'completed'){

                                    foreach($frenchise_order->order_details['services'] as $service){
                                        $amount = $service['price'];
                                        $franchise->offline_amount += $amount;
                                    }
                                }

                                if(isset($frenchise_order->order_details['packages']) && $frenchise_order->f_order->status == 'completed'){

                                    foreach($frenchise_order->order_details['packages'] as $package){
                                        if(!empty($package['package_service'])){
                                            foreach($package['package_service'] as $service){
                                                $amount = $service['price'];
                                                $franchise->offline_amount += $amount;
                                            }
                                        }
                                    }
                                }
                            }


                            if(($frenchise_order->f_order->method == 'Razorpay' || $frenchise_order->f_order->method == 'Pay Online After Service') && $frenchise_order->f_order->payment_status == 'Paid'){

                                if(isset($frenchise_order->order_details['services'])){
                                    foreach($frenchise_order->order_details['services'] as $service){
                                        $amount = $service['price'];
                                        $franchise->online_amount += $amount;
                                    }
                                }

                                if(isset($frenchise_order->order_details['packages'])){

                                    foreach($frenchise_order->order_details['packages'] as $package){
                                        if(!empty($package['package_service'])){
                                            foreach($package['package_service'] as $service){
                                                $amount = $service['price'];
                                                $franchise->online_amount += $amount;
                                            }
                                        }
                                    }
                                }
                            }

                        }
                    }
                }

            }

            $offline_commission = ($franchise->offline_amount * $franchise->commission) / 100;
            $franchise->debit_amount = $offline_commission;

            $online_commission = ($franchise->online_amount * $franchise->commission) / 100;
            $franchise->credit_amount = $franchise->online_amount - $online_commission;

            $franchise->total_commission = $online_commission + $offline_commission;

            $franchise->cr_amount = $franchise->dr_amount = 0;
            foreach($franchise->payments as $payments){

                if($payments->type == 2){ //credit
                    $franchise->cr_amount += $payments->amount;
                }

                if($payments->type == 1){//debit
                    $franchise->dr_amount += $payments->amount;
                }
            }


            $total_franchise_payment = $franchise->cr_amount - $franchise->dr_amount;
            $total_franchise_order_amt = $franchise->credit_amount - $franchise->debit_amount;

            $payment_flow = 'Credit';
            if($total_franchise_payment < 0){
                $payment_flow = 'Debit';
                $total_franchise_payment = ($total_franchise_payment * (-1));
            }
            $franchise->payment_flow = $payment_flow;

            $franchise->total_franchise_payment = $total_franchise_payment;

// echo $total_franchise_payment;
//             echo '<pre>';
// print_R($franchise->toArray());die;

            $total_franchise_outstanding = $total_franchise_payment + $total_franchise_order_amt;

            $flow = 'Credit';
            $franchise->outstanding_amount = $total_franchise_outstanding;
            if($total_franchise_outstanding < 0){
                $flow = 'Debit';
                $total_franchise_outstanding = ($total_franchise_outstanding * (-1));
            }
            $franchise->outstanding_amount = $total_franchise_outstanding;
            $franchise->flow = $flow;
        }

        // echo '<pre>';
        // print_R($franchise);
        // die;
        $data = [
            'total_earnings' => $franchise->offline_amount + $franchise->online_amount,
            'total_commission' => $franchise->total_commission,
            'payments' => $franchise->total_franchise_payment . $franchise->payment_flow,
            'total_outstanding' =>$franchise->outstanding_amount . $franchise->flow,
        ];
        return $this->success([
            'account' => $data
        ]);
    }
}
