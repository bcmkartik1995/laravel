<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stevebauman\Location\Facades\Location;
use App\Orders;
use App\Franchise;
use Auth;
use App\Worker_assigned_services;
use App\Franchise_worker;

class AccountsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function income(){

        $Orders = Orders::select(['orders.id','orders.pay_amount','orders.method','orders.payment_status','orders.status'])
            ->with([
                'franchise_orders' => function($q){
                    $q->with([
                        'worker_orders',
                        'extra_payments' => function($q){
                            $q->select('id','amount','f_order_id');
                        }
                    ]);
                }
            ])
            ->get();


        $total_online_payments = 0;
        $total_offline_payments = 0;
        $total_earnings = 0;
        $total_income = 0;
        $total_commission = 0;
        $total_refundable_amount = 0;
        $total_refunded_amount = 0;

        $franchise_offline_amount_to_get = $franchise_offline_amount_to_pay = 0;
        if($Orders->count()){
            foreach($Orders as $order){

                if($order->payment_status == 'Paid' || $order->payment_status == 'Refund'){

                    if(($order->method == 'Razorpay' || $order->method == 'Pay Online After Service')){
                        $total_online_payments += $order->pay_amount;

                        if($order->payment_status == 'Paid' && ($order->status == 'cancelled' || $order->status == 'declined')){
                            $total_refundable_amount += $order->pay_amount;
                        } else if($order->payment_status == 'Refund' && ($order->status == 'cancelled' || $order->status == 'declined')){
                            $total_refunded_amount += $order->pay_amount;
                        }
                    }else{
                        if($order->payment_status == 'Paid'){ // completed
                            $total_offline_payments += $order->pay_amount;
                        }
                    }

                    if(!empty($order->franchise_orders)){

                        foreach($order->franchise_orders as $franchise_orders){

                            $commission_perc = $franchise_orders->franchise->commission;
                            $franchise_online_amount = $franchise_offline_amount = 0;
                            $online_commission = $offline_commission = 0;

                            $offline_amount_taken = 0;
                            $total_extra_payment = 0;

                            if($franchise_orders->extra_payments->count()){

                                foreach($franchise_orders->extra_payments as $extra_payment){
                                   $total_extra_payment += $extra_payment->amount;
                                }
                            }

                            if(($order->method == 'Razorpay' || $order->method == 'Pay Online After Service') && $order->payment_status == 'Paid'){


                                $amount = 0;
                                if(isset($franchise_orders->order_details['services'])){

                                    foreach($franchise_orders->order_details['services'] as $service){
                                        $amount += $service['price'];
                                    }
                                }

                                if(isset($franchise_orders->order_details['packages'])){

                                    foreach($franchise_orders->order_details['packages'] as $package){
                                        if(!empty($package['package_service'])){
                                            foreach($package['package_service'] as $service){
                                                $amount += $service['price'];
                                            }
                                        }
                                    }
                                }
                                $franchise_online_amount += $amount;

                            }else{
                                if($order->payment_status == 'Paid'){ // completed

                                    $Franchise_worker = Franchise_worker::where('id', $order->payment_taken_by)->first();

                                    if($Franchise_worker && $Franchise_worker->franchises_id == $franchise_orders->franchise->id){
                                        $offline_amount_taken += $order->pay_amount;
                                    }


                                    $amount = 0;
                                    if(isset($franchise_orders->order_details['services'])){

                                        foreach($franchise_orders->order_details['services'] as $service){

                                            $assigned_service = Worker_assigned_services::where(['is_package' => 0, 'service_id' => $service['id'], 'order_id' => $franchise_orders->orders_id, 'status' => 5])->first();
                                            if($assigned_service){
                                                $amount += $service['price'];
                                            }
                                        }
                                    }

                                    if(isset($franchise_orders->order_details['packages'])){
                                        foreach($franchise_orders->order_details['packages'] as $package){
                                            if(!empty($package['package_service'])){
                                                foreach($package['package_service'] as $service){

                                                    $assigned_service = Worker_assigned_services::where(['is_package' => 0, 'service_id' => $service['id'], 'order_id' => $franchise_orders->orders_id, 'status' => 5])->first();
                                                    if($assigned_service){
                                                        $amount += $service['price'];
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    $franchise_offline_amount += $amount;
                                }
                            }



                            if($commission_perc){

                                $franchise_offline_amount += $total_extra_payment;
                                $offline_commission = ($franchise_offline_amount * $commission_perc) / 100;

                                // $offline_commission = ($franchise_offline_amount * $commission_perc) / 100;
                                $online_commission = ($franchise_online_amount * $commission_perc) / 100;
                            }


                            $franchise_offline_amount_to_get += ($offline_amount_taken + $offline_commission) - $franchise_offline_amount;
                            $franchise_offline_amount_to_pay += ($franchise_online_amount - $online_commission);
                            $total_commission += $offline_commission + $online_commission;

                        //     echo '<pre>franchise_offline_amount_to_get: ';print_R($franchise_offline_amount_to_get);echo '</pre>';
                        //    echo '<pre>franchise_offline_amount_to_pay: ';print_R($franchise_offline_amount_to_pay);echo '</pre>';
                        //    echo '<pre>total_commission: ';print_R($total_commission);echo '</pre>';
                        //    echo '<pre>******************';echo '</pre>';


                        }
                        // echo '<pre>************';
                    }




                   // print_R($order);
                }

            }
        }
// die;
        $total_earnings = $total_online_payments + $total_offline_payments;
        $total_pay_to_franchise = ($franchise_offline_amount_to_pay + $franchise_offline_amount_to_get);
        $total_income = $total_earnings - $total_refundable_amount - $total_refunded_amount - ($total_pay_to_franchise);

        // echo '<pre>total_online_payments: '.$total_online_payments.'</pre>';
        // echo '<pre>total_offline_payments: '.$total_offline_payments.'</pre>';
        // echo '<pre>total_earnings: '.$total_earnings.'</pre>';
        // echo '<pre>total_income : '.$total_income.'</pre>';
        // echo '<pre>total_commission : '.$total_commission.'</pre>';
        // echo '<pre>total_refundable_amount : '.$total_refundable_amount.'</pre>';
        // echo '<pre>total_refunded_amount : '.$total_refunded_amount.'</pre>';
        // echo '<pre>';
        // print_R($Orders);die;


        // $franchises = Franchise::with(['frenchise_orders' => function ($query) {
        //     $query->with(['f_order' => function($q){
        //         $q->select('id','method','pay_amount','status');//->where('status', 'completed');
        //     }])
        //     ->where(['status' => 1,'pay_status' => 'Paid']);
        // }])
        // ->with(['payments' => function ($query) {
        //     $query->select('payments.*');
        // }])
        // ->join('admins as a', 'franchises.user_id', '=', 'a.id')
        // ->select('franchises.id','franchises.franchise_name','franchises.created_at','franchises.updated_at','a.name as user_name','franchises.commission')
        // ->orderBy('franchises.id', 'DESC')
        // ->get();

        // echo '<pre>';
        // print_R($franchises);die;

        // $total_earnings = $total_commission = $total_income = 0;
        // foreach($franchises as $franchise){

        //     $franchise->credit_amount = 0;
        //     $franchise->debit_amount = 0;
        //     $franchise->offline_amount = 0;
        //     $franchise->online_amount = 0;

        //     if(!empty($franchise->frenchise_orders)){

        //         foreach($franchise->frenchise_orders as $frenchise_order){

        //             if($frenchise_order->f_order->method == 'Cash On Delivery'){

        //                 if(isset($frenchise_order->order_details['services']) && $frenchise_order->f_order->status == 'completed'){

        //                     foreach($frenchise_order->order_details['services'] as $service){

        //                         $amount = $service['price'];
        //                         $franchise->offline_amount += $amount;
        //                     }
        //                 }

        //                 if(isset($frenchise_order->order_details['packages']) && $frenchise_order->f_order->status == 'completed'){

        //                     foreach($frenchise_order->order_details['packages'] as $package){
        //                         $amount = $package['price'];
        //                         $franchise->offline_amount += $amount;
        //                     }
        //                 }
        //             }

        //             if($frenchise_order->f_order->method == 'Razorpay'){
        //                 $amount = 0;
        //                 if(isset($frenchise_order->order_details['services']) && $frenchise_order->f_order->status == 'completed'){

        //                     foreach($frenchise_order->order_details['services'] as $service){
        //                         $amount += $service['price'];
        //                     }
        //                 }

        //                 if(isset($frenchise_order->order_details['packages']) && $frenchise_order->f_order->status == 'completed'){

        //                     foreach($frenchise_order->order_details['packages'] as $package){
        //                         $amount += $package['price'];
        //                         $franchise->online_amount += $amount;
        //                     }
        //                 }
        //                 $franchise->online_amount += $amount;
        //             }

        //         }

        //         //print_R($franchise->offline_amount);
        //         $total_earnings += $franchise->offline_amount + $franchise->online_amount;

        //         $offline_commission = ($franchise->offline_amount * $franchise->commission) / 100;
        //         $franchise->debit_amount = $offline_commission;

        //         $online_commission = ($franchise->online_amount * $franchise->commission) / 100;
        //         $franchise->credit_amount = $franchise->online_amount - $online_commission;

        //         $total_commission += $offline_commission + $online_commission;

        //     }
        // }
        // $total_income = $total_earnings - $total_commission;


        // echo '<pre>total_online_payments: '.$total_online_payments.'</pre>';
        // echo '<pre>total_offline_payments: '.$total_offline_payments.'</pre>';
        // echo '<pre>total_earnings: '.$total_earnings.'</pre>';
        // echo '<pre>total_income : '.$total_income.'</pre>';
        // echo '<pre>total_commission : '.$total_commission.'</pre>';
        // echo '<pre>total_refundable_amount : '.$total_refundable_amount.'</pre>';
        // echo '<pre>total_refunded_amount : '.$total_refunded_amount.'</pre>';
        return view('admin.accounts.income', compact('total_online_payments', 'total_offline_payments', 'total_earnings','total_commission','total_income','total_refundable_amount','total_refunded_amount','total_pay_to_franchise'));
    }

    public function franchise_fees(){

        $franchises = DB::table('franchises as f')
        ->join('admins as a', 'f.user_id', '=', 'a.id')
        ->select('f.id','f.franchise_name','f.email','f.mobile','f.commission','f.status','f.created_at','f.updated_at','a.name as user_name')
        ->get();

        // echo '<pre>';
        // print_R($franchises);die;
        return view('admin.accounts.franchise_fees',compact('franchises'));
    }

    public function franchise_outstanding(){

        $franchises = Franchise::with([
            'frenchise_orders' => function ($query) {
                $query->with([
                    'f_order' => function($q){
                        $q->select('id','method','pay_amount','status', 'payment_status','payment_taken_by');
                    },
                    'worker_orders',
                    'extra_payments' => function($q){
                        $q->select('id','amount','f_order_id');
                    }
                ]);
            }])
            ->with(['payments' => function ($query) {
                $query->select('payments.*');
            }])
            ->join('admins as a', 'franchises.user_id', '=', 'a.id')
            ->select('franchises.id','franchises.franchise_name','franchises.created_at','franchises.updated_at','a.name as user_name','franchises.commission')
            ->orderBy('franchises.id', 'DESC')
            ->get();


        foreach($franchises as $franchise){
            // echo '<pre>';
            // print_R($franchise->id);

            $franchise->credit_amount = 0;
            $franchise->debit_amount = 0;
            $franchise->offline_amount = 0;
            $franchise->online_amount = 0;
            $franchise->offline_amount_taken = 0;
            $franchise->total_extra_payment = 0;

            if(!empty($franchise->frenchise_orders)){
                foreach($franchise->frenchise_orders as $frenchise_order){

                    if($frenchise_order->extra_payments->count()){

                        foreach($frenchise_order->extra_payments as $extra_payment){
                            $franchise->total_extra_payment += $extra_payment->amount;
                        }
                    }

                    if(!empty($frenchise_order->f_order)){

                        if($frenchise_order->f_order->payment_status == 'Paid' || $frenchise_order->f_order->payment_status == 'Refund'){

                            if($frenchise_order->f_order->method == 'Cash On Delivery'){

                                if($frenchise_order->f_order->payment_status == 'Paid'){

                                    $Franchise_worker = Franchise_worker::where('id', $frenchise_order->f_order->payment_taken_by)->first();

                                    if($Franchise_worker && $Franchise_worker->franchises_id == $franchise->id){
                                        $franchise->offline_amount_taken += $frenchise_order->f_order->pay_amount;
                                    }

                                    if(isset($frenchise_order->order_details['services'])){

                                        foreach($frenchise_order->order_details['services'] as $service){

                                            $assigned_service = Worker_assigned_services::where(['is_package' => 0, 'service_id' => $service['id'], 'order_id' => $frenchise_order->orders_id, 'status' => 5])->first();
                                            if($assigned_service){
                                                $amount = $service['price'];
                                                $franchise->offline_amount += $amount;
                                            }
                                        }
                                    }

                                    if(isset($frenchise_order->order_details['packages'])){

                                        foreach($frenchise_order->order_details['packages'] as $package){
                                            if(!empty($package['package_service'])){
                                                foreach($package['package_service'] as $service){
                                                    $assigned_service = Worker_assigned_services::where(['is_package' => 1, 'service_id' => $service['id'], 'order_id' => $frenchise_order->orders_id, 'status' => 5])->first();
                                                    if($assigned_service){
                                                        $amount = $service['price'];
                                                        $franchise->offline_amount += $amount;
                                                    }
                                                }
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
        }

        foreach($franchises as $franchise){

            $franchise->offline_amount += $franchise->total_extra_payment;
            $offline_commission = ($franchise->offline_amount * $franchise->commission) / 100;
            // $franchise->debit_amount = $offline_commission;
            $franchise->debit_amount = ($franchise->offline_amount_taken + $offline_commission) - $franchise->offline_amount;


            $online_commission = ($franchise->online_amount * $franchise->commission) / 100;
            $franchise->credit_amount = $franchise->online_amount - $online_commission;

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

            $total_franchise_outstanding = $total_franchise_payment + $total_franchise_order_amt;

            $flow = 'Credit';
            $franchise->outstanding_amount = $total_franchise_outstanding;
            if($total_franchise_outstanding < 0){
                $flow = 'Debit';
                $total_franchise_outstanding = ($total_franchise_outstanding * (-1));
            }
            $franchise->outstanding_amount = $total_franchise_outstanding;
            $franchise->flow = $flow;

            // echo '<pre>';
            // print_R($franchise);
        }
// die;
        return view('admin.accounts.franchise_outstanding',compact('franchises'));
    }

    public function franchises_account(){

        $user_id = Auth::guard('admin')->user()->id;
        //$franchises_id = Franchise::where('user_id',$user_id)->first();

        $franchise = Franchise::with(['frenchise_orders' => function ($query) {
            $query->with([
                'f_order' => function($q){
                    $q->select('id','method','pay_amount','status','payment_status','payment_taken_by');
                },
                'worker_orders',
                'extra_payments' => function($q){
                    $q->select('id','amount','f_order_id');
                }
        ]);
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
        $franchise->offline_amount_taken = 0;
        $franchise->total_extra_payment = 0;

        if(!empty($franchise)){

            if(!empty($franchise->frenchise_orders)){
                foreach($franchise->frenchise_orders as $frenchise_order){

                    if($frenchise_order->extra_payments->count()){

                        foreach($frenchise_order->extra_payments as $extra_payment){
                            $franchise->total_extra_payment += $extra_payment->amount;
                        }
                    }
                    if(!empty($frenchise_order->f_order)){


                        if($frenchise_order->f_order->payment_status == 'Paid' || $frenchise_order->f_order->payment_status == 'Refund'){


                            if($frenchise_order->f_order->method == 'Cash On Delivery'){

                                if($frenchise_order->f_order->payment_status == 'Paid'){

                                    $Franchise_worker = Franchise_worker::where('id', $frenchise_order->f_order->payment_taken_by)->first();

                                    if($Franchise_worker && $Franchise_worker->franchises_id == $franchise->id){
                                        $franchise->offline_amount_taken += $frenchise_order->f_order->pay_amount;
                                    }

                                    if(isset($frenchise_order->order_details['services'])){

                                        foreach($frenchise_order->order_details['services'] as $service){
                                            $assigned_service = Worker_assigned_services::where(['is_package' => 0, 'service_id' => $service['id'], 'order_id' => $frenchise_order->orders_id, 'status' => 5])->first();
                                            if($assigned_service){
                                                $amount = $service['price'];
                                                $franchise->offline_amount += $amount;
                                            }
                                        }
                                    }

                                    if(isset($frenchise_order->order_details['packages'])){

                                        foreach($frenchise_order->order_details['packages'] as $package){
                                            if(!empty($package['package_service'])){
                                                foreach($package['package_service'] as $service){
                                                    $assigned_service = Worker_assigned_services::where(['is_package' => 0, 'service_id' => $service['id'], 'order_id' => $frenchise_order->orders_id, 'status' => 5])->first();
                                                    if($assigned_service){
                                                        $amount = $service['price'];
                                                        $franchise->offline_amount += $amount;
                                                    }
                                                }
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


            $franchise->offline_amount += $franchise->total_extra_payment;
            $offline_commission = ($franchise->offline_amount * $franchise->commission) / 100;
            // $franchise->debit_amount = $offline_commission;
            $franchise->debit_amount = ($franchise->offline_amount_taken + $offline_commission) - $franchise->offline_amount;

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
        return view('admin.accounts.franchises_account', compact('franchise'));
    }

}
