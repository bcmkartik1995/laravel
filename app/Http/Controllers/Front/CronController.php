<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Orders;
use App\Worker_assigned_services;
use App\Franchises_order;
use App\Order_tracks;

use Carbon\Carbon;

class CronController extends Controller
{
    function order_status_cron() {

        $orders = Orders::whereIN('status', ['pending','processing'])->get();
        $total_affected_orders = 0;
        if($orders->count()){
            foreach($orders as $order){

                if($order->franchise_orders->count()){
                    $total_fra_order_inprogress = 0;
                    $total_fra_order_ondelivery = 0;
                    $total_fra_orders = 0;

                    foreach($order->franchise_orders as $franchise_order){

                        $total_worker_inprogress = 0;
                        $total_worker_ondelivery = 0;

                        $total_fra_orders++;

                        if($franchise_order->worker_orders->count()){
                            foreach($franchise_order->worker_orders as $worker_order){

                                $travel_time_required = 0; // in minute
                                if(!empty($franchise_order->franchise->hour)){
                                    $travel_time_required += $franchise_order->franchise->hour * 60;
                                }
                                if(!empty($franchise_order->franchise->minute)){
                                    $travel_time_required += $franchise_order->franchise->minute;
                                }

                                if($worker_order->status == 1){ //accepted
                                    if(Carbon::parse($worker_order->start_time)->subMinute($travel_time_required) < Carbon::now()){
                                        $total_worker_inprogress++;

                                        $Worker_assigned_services = Worker_assigned_services::find($worker_order->id);
                                        $Worker_assigned_services->status = 3;//inprogress
                                        $Worker_assigned_services->save();
                                    }
                                }elseif($worker_order->status == 3){ //inprogress
                                    if(Carbon::parse($worker_order->start_time) < Carbon::now()){
                                        $total_worker_ondelivery++;

                                        $Worker_assigned_services = Worker_assigned_services::find($worker_order->id);
                                        $Worker_assigned_services->status = 4;//on delivery
                                        $Worker_assigned_services->save();
                                    }
                                }elseif($worker_order->status == 3){ //inprogress
                                    $total_worker_inprogress++;
                                }elseif($worker_order->status == 4){ //on delivery
                                    $total_worker_ondelivery++;
                                }
                            }
                        }

                        if($total_worker_ondelivery > 0 || $total_worker_inprogress > 0){

                            if($total_worker_ondelivery > 0){
                                $total_fra_order_ondelivery++;
                                if(in_array($franchise_order->status, [0,1,3])){
                                    $Franchises_order = Franchises_order::find($franchise_order->id);
                                    $Franchises_order->status = 4;//on delivery
                                    $Franchises_order->save();
                                }
                            }else if($total_worker_inprogress > 0){ //0=pending,1=accept

                                $total_fra_order_inprogress++;
                                if(in_array($franchise_order->status, [0,1])){
                                    $Franchises_order = Franchises_order::find($franchise_order->id);
                                    $Franchises_order->status = 3;//inprogress
                                    $Franchises_order->save();
                                }
                            }
                        }

                        if($franchise_order->status == 3){
                            $total_fra_order_inprogress++;
                        }elseif($franchise_order->status == 3){
                            $total_fra_order_ondelivery++;
                        }
                    }

                    if($total_fra_order_ondelivery > 0){
                        if($order->status == 'processing'){
                            $update_order = Orders::find($order->id);
                            $update_order->status = 'on delivery';
                            $update_order->save();

                            $total_affected_orders++;

                            $track = new Order_tracks;
                            $track->title = 'On the way';
                            $track->order_status = $update_order->status;
                            $track->text = 'Worker is on the way.';
                            $track->order_id = $order->id;
                            $track->save();
                        }
                    }elseif($total_fra_order_inprogress > 0){
                        if($order->status == 'pending'){
                            $update_order = Orders::find($order->id);
                            $update_order->status = 'processing';
                            $update_order->save();

                            $total_affected_orders++;

                            $track = new Order_tracks;
                            $track->title = 'Processing';
                            $track->order_status = $update_order->status;
                            $track->text = 'Your order is in processing.';
                            $track->order_id = $order->id;
                            $track->save();
                        }
                    }
                }
            }
        }
        echo "Cron executed. Total Affected Orders : ".$total_affected_orders;
    }
}
