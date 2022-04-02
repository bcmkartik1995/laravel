<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;
use Illuminate\Support\Collection;
use App\Franchise_worker;
use App\Worker_assigned_services;
use App\Orders;
use App\Notification;
use App\Service;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

class WorkerOrderController extends Controller
{
    use ApiResponser;

    public function worker_order(Request $request)
    {
        $limit = 10;

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }
        
        $user_id = $request->user_id;
        $user = Franchise_worker::find($user_id);
        $type = $request->type;
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        $status = $request->status;
        $service = $request->service;
        $page = isset($request->page) && !empty($request->page) ? ($request->page * $limit) : 0 ;
        $limit = isset($request->limit) && !empty($request->limit) ?$request->limit : $limit ;

        if($user){

            if($type == "worker_orders"){

                $order = Orders::orderBy('id','desc')->with([
                    'user' => function ($query) {
                        $query->select('name','id');
                    },
                    'worker_orders' =>function($query)use($user_id){
                        $query->where('worker_id', $user_id);
                    }
                ])->where(['was.worker_id' => $user_id])
                ->groupBy('orders.id')
                ->leftJoin('user_addresses as mua', 'mua.id', '=', 'orders.customer_address_id')
                ->join('worker_assigned_services as was', 'orders.id', '=', 'was.order_id')
                ->select('orders.id','orders.customer_name','orders.customer_address','orders.order_number','orders.totalQty','orders.pay_amount','orders.status','mua.city','cart');
            }

            if($type == "ongoing_orders"){

                $order = Orders::orderBy('id','desc')->with([
                    'user' => function ($query) {
                        $query->select('name','id');
                    },
                    'worker_orders' =>function($query)use($user_id){
                        $query->where('worker_id', $user_id);
                    }
                ])->where(['was.worker_id' => $user_id])
                ->whereIn('was.status', ['1','3','4'])
                ->groupBy('orders.id')
                ->leftJoin('user_addresses as mua', 'mua.id', '=', 'orders.customer_address_id')
                ->join('worker_assigned_services as was', 'orders.id', '=', 'was.order_id')
                ->select('orders.id','orders.customer_name','orders.customer_address','orders.order_number','orders.totalQty','orders.pay_amount','orders.status','mua.city','cart');
            }

            if($type == "completed_orders"){

                $order = Orders::orderBy('id','desc')->with([
                    'user' => function ($query) {
                        $query->select('name','id');
                    },
                    'worker_orders' =>function($query)use($user_id){
                        $query->where('worker_id', $user_id);
                    }
                ])->where(['was.worker_id' => $user_id,'was.status'=>5])
                ->groupBy('orders.id')
                ->leftJoin('user_addresses as mua', 'mua.id', '=', 'orders.customer_address_id')
                ->join('worker_assigned_services as was', 'orders.id', '=', 'was.order_id')
                ->select('orders.id','orders.customer_name','orders.customer_address','orders.order_number','orders.totalQty','orders.pay_amount','orders.status','mua.city','cart');
            }

            if($type == "today_orders"){

                $order = Orders::orderBy('id','desc')->with([
                    'user' => function ($query) {
                        $query->select('name','id');
                    },
                    'worker_orders' =>function($query)use($user_id){
                        $query->where('worker_id', $user_id);
                    }
                ])->where(['was.worker_id' => $user_id])
                ->whereDate('was.created_at',Carbon::today())
                ->groupBy('orders.id')
                ->leftJoin('user_addresses as mua', 'mua.id', '=', 'orders.customer_address_id')
                ->join('worker_assigned_services as was', 'orders.id', '=', 'was.order_id')
                ->select('orders.id','orders.customer_name','orders.customer_address','orders.order_number','orders.totalQty','orders.pay_amount','orders.status','mua.city','cart');
            }
            
            if(!empty($date_from) && !empty($date_to)){

                $datefrom = Carbon::createFromFormat('d/m/Y', $date_from)->format('Y-m-d');
                $dateto = Carbon::createFromFormat('d/m/Y', $date_to)->format('Y-m-d');

                $worker_order = $order->where(DB::raw('CAST(was.created_at as date)'), '>=', $datefrom)->where(DB::raw('CAST(was.created_at as date)'), '<=', $dateto);
            }

            if(!empty($status)){
                $worker_order = $order->where('orders.status',$status);
            }

            if(!empty($service)){
                $worker_order = $order->join('ordered_services as os', 'os.order_id', '=', 'orders.id')
                ->where('os.service_id',$service);
            }

            $worker_order = $order->take($limit)->skip($page)->get();

            if($worker_order->count()){
                
                foreach($worker_order as $order){
                    $service_titles = [];
                    if(!empty($order->cart['services'])){
                        foreach($order->cart['services'] as $service){
                            $service_title = $service['title'];
                            $service_titles[] = $service_title;
                        }
                    }
    
                    if(!empty($order->cart['packages'])){
                        foreach($order->cart['packages'] as $package){
                            $service_titles[] = $package['title'];
                        }
                    }
                    unset($order->cart);
                    $order->service_titles = implode(',',$service_titles);
                }

                return $this->success([
                    'worker_orders' => $worker_order,
                ]);
            }else{
                return $this->error('No any orders found.', 401);
            }
                
        }
        return $this->error('Invalid Access', 401);
    }

    public function order_service_filter_list(Request $request)
    {
        $services = Service::where(['status' => 1])->select(['id','title'])->get();

        if($services->count()) {
            return $this->success([
                'services' => $services
            ]);
        }else{
            return $this->error('No any services found.', 401);
        }
    }

    public function worker_order_detail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'order_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }
        
        $user_id = $request->user_id;
        $user = Franchise_worker::find($user_id);
        $order_id = $request->order_id;
        if($user){

            $booking = Orders::with([
                'user' => function ($query) {
                    $query->select('name','id');
                },
                'worker_orders' =>function($query)use($user_id){
                    $query->where('worker_id', $user_id);
                }
            ])
            //->join('worker_assigned_services as was', 'orders.id', '=', 'was.order_id')
            ->where('orders.id',$order_id)
            //->where(['was.worker_id' => $user_id])
            ->first();


            if($booking){
                $order_data = [];

                $order_data['id'] = $booking->id;
                $order_data['user_id'] = $booking->user_id;
                $order_data['method'] = $booking->method;
                $order_data['totalQty'] = $booking->totalQty;
                $order_data['pay_amount'] = $booking->pay_amount;
                $order_data['order_number'] = $booking->order_number;
                $order_data['payment_status'] = $booking->payment_status;
                $order_data['customer_email'] = $booking->customer_email;
                $order_data['customer_name'] = $booking->customer_name;
                $order_data['customer_phone'] = $booking->customer_phone;
                $order_data['customer_address'] = $booking->customer_address;
                $order_data['created_at'] = $booking->created_at;
                $order_data['order_date'] = Carbon::parse($booking->created_at)->format('d-m-Y h:i a');

                if(!empty($booking->worker_orders)){
                    foreach($booking->worker_orders as $worker_order){
                        $data = [];
                        $data['id'] = $worker_order->id;
                        $data['worker_id'] = $worker_order->worker_id;
                        $data['order_id'] = $worker_order->order_id;
                        $data['f_order_id'] = $worker_order->f_order_id;
                        $data['is_package'] = $worker_order->is_package;
                        $data['package_id'] = $worker_order->package_id;
                        $data['service_id'] = $worker_order->service_id;
                        $data['title'] = $worker_order->service->title;
                        $data['price'] = $worker_order->service->price;
                        $data['take_time'] = $worker_order->take_time;
                        $data['start_time'] = $worker_order->start_time;
                        $data['end_time'] = $worker_order->end_time;
                        $data['status'] = $worker_order->status;
                        $data['pay_status'] = $worker_order->pay_status;
        
                        if($worker_order->is_package == 1){
        
                            //print_R($worker_order);
                            if(!isset($order_data['packages'][$worker_order->package_id])){
                                $order_data['packages'][$worker_order->package_id]['title'] = $worker_order->package->title;
                            }
                            $order_data['packages'][$worker_order->package_id]['services'][] = $data;
                        }else{
                            $order_data['services'][$worker_order->service_id] = $data;
                        }
                    }
                }
                
                return $this->success([
                    'worker_order' => $order_data,
                ]);

            }else{
                return $this->error('No any orders found.', 401);
            }
              
        }
        return $this->error('Invalid Access', 401);
    }

    public function worker_order_status(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'assign_service_id' => 'required',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }
        
        $user_id = $request->user_id;
        $assign_service_id = $request->assign_service_id;
        $status = $request->status;

        $user = Franchise_worker::find($user_id);
       
        if($user){

            $bookings = Worker_assigned_services::find($assign_service_id);
            $bookings->status = $request->status;
            if($request->status == 2){
                $bookings->is_allocated = 0;
            }
            
            $worker_order = Worker_assigned_services::where(['id'=>$assign_service_id])->first();
            $order_id = $worker_order->order_id;
            $order_worker = Worker_assigned_services::where(['order_id'=>$order_id])->count();
            $worker_status = Worker_assigned_services::where(['status'=> 5])->count();

            if($order_worker == $worker_status){
                $order = Orders::find($order_id);
                $order->status = 'completed';
                $order->save();
            }
                
            $bookings->update();

            return $this->success([
                'worker_order' => $bookings,
            ]);

        }
        return $this->error('Invalid Access', 401);
    }

}
