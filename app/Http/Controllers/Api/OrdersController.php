<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;
use App\Orders;
use App\Order_review;
use App\Services_ratings;
use App\Packages_ratings;
use App\My_cart;
use App\Package;
use App\Service;
use App\User_address;
use App\Franchise;
use App\User;
use App\Notification;
use App\Models\Admin;
use App\Worker_assigned_services;
use Carbon\CarbonPeriod;
use Illuminate\Support\Str;
use Mail;

use App\Order_tracks;
use App\Franchises_order;
use App\Franchise_plans;
use App\Ordered_services;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    use ApiResponser;

    public function order_history(Request $request) {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }

        $user_id = $request->user_id;

        $orders = Orders::where('user_id','=',$user_id)
            ->select('id','user_id','cart','method','totalQty','pay_amount','txnid','order_number','payment_status','status','created_at', DB::raw('DATE_FORMAT(created_at, "%d, %b %Y") as created_date'))
            ->orderBy('id','desc')
            ->get()
            ->map(function($query){
                $query->pay_amount = number_format($query->pay_amount,2,'.','');
                return $query;
            });

        if($orders->count()) {
            foreach($orders as $order){

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
                'orders' => $orders
            ]);
        }else{
            return $this->success([
                "orders" => $orders,
            ]);
            //return $this->error('No any orders found.', 401);
        }
    }

    public function ongoing_orders(Request $request) {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }

        $user_id = $request->user_id;
        $orders = Orders::where('user_id','=',$user_id)->whereIn('status', ['pending','processing','on delivery'])
            ->select('id','user_id','cart','method','totalQty','pay_amount','txnid','order_number','payment_status','status','created_at', DB::raw('DATE_FORMAT(created_at, "%d, %b %Y") as created_date'))
            ->orderBy('id','desc')
            ->get()
            ->map(function($query){
                $query->pay_amount = number_format($query->pay_amount,2,'.','');
                return $query;
            });
          
           
        if ($orders->count()) {
            
            foreach($orders as $order){

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
                'orders' => $orders
            ]);
        }else{
            return $this->success([
                "orders" => $orders,
            ]);
            //return $this->error('No any orders found.', 401);
        }
    }

    public function order_tracking(Request $request) {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'order_number' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }

        $order_number = $request->order_number;
        $order =  Orders::where('order_number', $order_number)->first();
        if(empty($order)){
            return $this->error('Please enter valid order number.', 401);
        }

        $Order_tracks = Order_tracks::where(['order_id' => $order->id])
        ->select('id','order_status','title','text','created_at')
        ->get()
        ->map(function($query){
            $query->created_time = $query->created_at->format('d M Y h:i A');
            return $query;
        });

        //$order_status_options = array('pending','processing','on delivery','completed');
        if ($Order_tracks->count()) {
            return $this->success([
                'order_tracks' => $Order_tracks
            ]);
        }else{
            return $this->error('No any order tracks found.', 401);
        }
    }

    public function order_detail(Request $request) {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'order_id' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }

        $order_id = $request->order_id;
        $user_id = $request->user_id;

        $my_order = Orders::with(['franchise_orders' => function($query){
            $query->select('id','franchises_id','orders_id','order_details','take_time','start_time','end_time','pay_status','status')->with(['franchise' => function($query){
                $query->select('id','franchise_name');
            }]);
        }])
        ->where(['user_id' => $user_id, 'id' => $order_id])
        ->select('id','user_id','method','totalQty','pay_amount','txnid','order_number','payment_status','status','created_at','cart','customer_email','customer_name','customer_phone','customer_address')
        ->first();
        
        if($my_order) {

            $cart_data = $my_order['cart'];
            
            $data = [];
            $data['packages'] = [];
            if(!empty($cart_data['packages'])){
                foreach($cart_data['packages'] as $p => $cart_package){
                    $package_data = [];
                    $package_data['quantity'] = (string)$cart_package['quantity'];
                    $package_data['price'] = $cart_package['price'];
                    $package_data['services'] = $cart_package['services'];
                    $package_data['title'] = $cart_package['title'];
                   // echo '<pre>';
                   // print_r($cart_package);
                    if(!empty($cart_package['package_service'])){
                        foreach($cart_package['package_service'] as $ps => $cart_package_service){
                            $package_service_data = [];
                            $package_service_data['id'] = $cart_package_service['id'];
                            $package_service_data['title'] = $cart_package_service['title'];
                            $package_data['package_service'][] = $package_service_data;
                            // $data['packages'] = $package_service_data;
                        }
                    }
                    $data['packages'][] = $package_data;

                }
            }

            $data['services'] = [];
            if(!empty($cart_data['services'])){
                foreach($cart_data['services'] as $s => $cart_service){
                    $service_data = [];
                    $service_data['title'] = $cart_service['title'];
                    $service_data['price'] = $cart_service['price'];
                    $service_data['quantity'] = (string)$cart_service['quantity'];
                    $data['services'][] = $service_data;
                }
            }

            $order_data = [];
            $order_data['id'] = $my_order['id'];
            $order_data['user_id'] = $my_order['user_id'];
            $order_data['method'] = $my_order['method'];
            $order_data['totalQty'] = $my_order['totalQty'];
            $order_data['pay_amount'] = $my_order['pay_amount'];
            $order_data['txnid'] = $my_order['txnid'];
            $order_data['order_number'] = $my_order['order_number'];
            $order_data['payment_status'] = $my_order['payment_status'];
            $order_data['status'] = $my_order['status'];
            $order_data['created_at'] = Carbon::parse($my_order['created_at'])->format('d M Y h:i A');
            $order_data['status'] = $my_order['status'];
            $order_data['customer_email'] = $my_order['customer_email'];
            $order_data['customer_name'] = $my_order['customer_name'];
            $order_data['customer_phone'] = $my_order['customer_phone'];
            $order_data['customer_address'] = $my_order['customer_address'];
            
            $order_data['cart'] = $data;

            $worker_orders = [];
            foreach($my_order->franchise_orders as $order){

                // echo '<pre>';
                // print_R($order->worker_orders);die;

                if(!empty($order->worker_orders)){
                    foreach($order->worker_orders as $w_order){
                    //  print_r($w_order->worker);
                    // echo '<pre>';
                    // print_R($w_order);die;
                        if($w_order->is_package){
                            $worker_orders[$w_order->f_order_id]['packages'][$w_order->package_id][$w_order->service_id] = $w_order;
                            $worker_orders['name'] = $worker_orders[$w_order->f_order_id]['packages'][$w_order->package_id][$w_order->service_id]->worker;
                            
                        }else{
                            $worker_orders[$w_order->f_order_id]['services'][$w_order->service_id] = $w_order;
                            $worker_orders['name'] = $worker_orders[$w_order->f_order_id]['services'][$w_order->service_id]->worker->name;
                        }
                    }
                }

            }
        // echo '<pre>';
        // print_R($my_order);die;

            $assign_detail = [];
            if(!empty($my_order->franchise_orders->count())){
                foreach($my_order->franchise_orders as $o => $franchise_order){
                    $franchise_data = [];
                    $franchise_data['franchise_id'] = $franchise_order['franchise']['id'];
                    $franchise_data['franchise_name'] = $franchise_order['franchise']['franchise_name'];
                    $franchise_data['packages'] = [];
                    $franchise_data['services'] = [];
                    if(!empty($franchise_order->order_details['packages'])){
                      

                            foreach($franchise_order->order_details['packages'] as $pid => $package){
                                
                                $package_data = [];
                                $package_data['id'] = $package['id'];
                                $package_data['title'] = $package['title'];

                                foreach($package['package_service'] as $service){

                                    $service_data = [];
                                    $service_data['id'] = $service['id'];
                                    $service_data['title'] = $service['title'];
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

                                    $service_data['worker'] = $worker_name;
                                    $service_data['status'] = $worker_status;
                                    $service_data['start_time'] = $start_time;
                                    $service_data['end_time'] = $end_time;

                                    $package_data['services'][] = $service_data;
                                }

                                $franchise_data['packages'][] = $package_data;
                            }
                      
                        
                    }
                    if(!empty($franchise_order->order_details['services'])){
                        foreach($franchise_order->order_details['services'] as $service){

                            $service_data = [];
                            $service_data['id'] = $service['id'];
                            $service_data['title'] = $service['title'];
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

                            $service_data['worker'] = $worker_name;
                            $service_data['status'] = $worker_status;
                            $service_data['start_time'] = $start_time;
                            $service_data['end_time'] = $end_time;

                            $franchise_data['services'][] = $service_data;
                        }
                        
                    }
                    $assign_detail[] = $franchise_data;
                }
                
            }

            $order_data['assign_detail'] = $assign_detail;
            //print_R($assign_detail);
            return $this->success([
                'order_data' => $order_data,
            //    'order_all' => $my_order,
            ]);
        }else{
            return $this->error('No any orders found.', 401);
        }

    }

    public function order_review(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'type' => 'required',
            'rating' => 'required',
            'description' => 'required',
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }
        
        $type = $request->type;
        
        if($type == 'order'){

            $order_review = new Order_review;
            $order_review->user_id = $request->user_id; 
            $order_review->order_id = $request->id; 
            $order_review->order_rating = $request->rating; 
            $order_review->description = $request->description; 
            $order_review->save();
            return $this->success([
                'review' => $order_review,
            ]);

        }elseif($type == 'service'){

            $service_review = new Services_ratings;
            $service_review->user_id = $request->user_id; 
            $service_review->service_id = $request->id; 
            $service_review->service_rating = $request->rating; 
            $service_review->description = $request->description; 
            $service_review->save();
            return $this->success([
                'review' => $service_review,
            ]);

        }elseif($type == 'package'){

            $package_review = new Packages_ratings;
            $package_review->user_id = $request->user_id; 
            $package_review->package_id = $request->id; 
            $package_review->package_rating = $request->rating; 
            $package_review->description = $request->description; 
            $package_review->save();
            return $this->success([
                'review' => $package_review,
            ]);

        }

    }

    public function place_order(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'payment_method_type' => 'required'
        ], ['payment_method_type.required' => 'Please select payment option']);

        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }

        $login_user_id = $request->user_id;
        $user_detail = User::where(['id' => $login_user_id])->first();

        $user_id = $request->user_id;
        $cart_data = $request->cart_data;
        
        if(empty($cart_data['packages']) && empty($cart_data['services'])){
            $My_cart = My_cart::where('user_id', $user_id)->first();
            if($My_cart){
                $My_cart->delete();
            }
            // return $this->success([
            //     'Success' => 'Cart data removed successfully.'
            // ]);
        } else {

            if(!empty($cart_data['services'])){
                $services_collection = collect($cart_data['services']);
                $cart_data['services'] = $services_collection->mapWithKeys(function ($item) {
                    return [$item['id'] => $item];
                })->toArray();
            }
            if(!empty($cart_data['packages'])){
                $packages_collection = collect($cart_data['packages']);
                $cart_data['packages'] = $packages_collection->mapWithKeys(function ($item) {
                    return [$item['id'] => $item];
                })->toArray();
            }

            $cart_data['ServiceQuantity']= !empty($request->ServiceQuantity) ? $request->ServiceQuantity : null;
            $cart_data['origional_price']= !empty($request->origional_price) ? $request->origional_price : null;
            $cart_data['final_total']= !empty($request->final_total) ? $request->final_total : null;
            $cart_data['discount']= !empty($request->discount) ? $request->discount : null;
            $cart_data['offer_code']= !empty($request->offer_code) ? $request->offer_code : null;
            $cart_data['gift_id']= !empty($request->gift_id) ? $request->gift_id : null;
            $cart_data['address_id']= !empty($request->address_id) ? $request->address_id : null;
            $cart_data['flat_building_no']= !empty($request->flat_building_no) ? $request->flat_building_no : null;
            $cart_data['address']= !empty($request->address) ? $request->address : null;
            $cart_data['customer_name']= !empty($request->customer_name) ? $request->customer_name : null;
            $cart_data['address_type']= !empty($request->address_type) ? $request->address_type : null;
            $cart_data['slot_date']= !empty($request->slot_date) ? $request->slot_date : null;
            $cart_data['slot_time']= !empty($request->slot_time) ? $request->slot_time : null;
            $cart_data['payment_method_type']= !empty($request->payment_method_type) ? $request->payment_method_type : null;

            $My_cart = My_cart::where('user_id', $user_id)->first();
            if ($My_cart) {
                $My_cart->cart_data = $cart_data;
                $My_cart->save();
            } else {
                $My_cart = new My_cart;
                $My_cart->user_id = $user_id;
                $My_cart->cart_data = $cart_data;
                $My_cart->save();
            }

        }
        
        $cart_data = $My_cart->cart_data;

    
        
        // $My_cart = My_cart::where('user_id', $user_detail->id)->first();
        // $cart_data = $My_cart->cart_data;

        // $My_cart->cart_data = array_merge($cart_data, ['payment_method_type' => $request->payment_method_type]);
        // $My_cart->save();
        
        if(!empty($cart_data['packages'])){
            foreach ($cart_data['packages'] as $p => $package) {
                $get_package = Package::where('id', $package['id'])->first()->toArray();
                $package_service = Service::whereIn('id', $package['services'])->get()->toArray();

                $collection = collect($package_service);
                $package_service = $collection->mapWithKeys(function ($item) {
                    return [$item['id'] => $item];
                })->toArray();

                $cart_data['packages'][$p] = array_merge($package, $get_package);
                $cart_data['packages'][$p]['package_service'] = $package_service;
            }
        }
        if(!empty($cart_data['services'])) {
            foreach ($cart_data['services'] as $s => $service) {
                $get_service = Service::where('id', $service['id'])->first()->toArray();
                unset($get_service['price']);

                $cart_data['services'][$s] = array_merge($service, $get_service);
            }
        }

        $payment_type = $request->payment_method_type;
        $total_quantity = 0;
        if (!empty($cart_data['packages'])) {
            foreach ($cart_data['packages'] as $package) {
                $total_quantity += $package['quantity'];
            }
        }
        if (!empty($cart_data['services'])) {
            foreach ($cart_data['services'] as $service) {
                $total_quantity += $service['quantity'];
            }
        }

        
        $address = User_address::where(['user_id' => $user_detail->id, 'id' => $cart_data['address_id']])->first();
        $latitude = $address->latitude;
        $longitude = $address->longitude;
        
        // Get frenchise with match city and cancellation retio desc
        $franchises = Franchise::where(['franchises.status' => 1])
            ->with(['franchise_workers' => function($query){
                $query->with(['worker_service' => function($query){
                    $query->where(['status'=>1]);
                }])->where(['status'=>1]);
            }])
            ->select(['franchises.*', DB::raw('count(fo.franchises_id) as cancel_count'),DB::raw("6371 * acos(cos(radians(" . $latitude . "))
            * cos(radians(latitude)) * cos(radians(longitude) - radians(" . $longitude . "))
            + sin(radians(" .$latitude. ")) * sin(radians(latitude))) AS distance"), 'fp.id as f_plan_id','fp.remain_credits as f_remain_credit'])
            ->leftjoin("franchises_orders AS fo", function ($join) {
                $join->on('franchises.id', '=', 'fo.franchises_id')->where('fo.status', 2)->where(['fo.deleted_at' => NULL]);
            })
            ->join("franchise_workers as fw", function ($join) {
                $join->on('franchises.id', '=', 'fw.franchises_id')->where(['fw.deleted_at' => NULL]);
            })
            ->leftjoin("franchise_plans as fp", function ($join) {
                $join->on('franchises.id', '=', 'fp.franchise_id')->where(['fp.deleted_at' => NULL]);
            })
            ->join('franchise_services As fc', function ($join) {
                $join->on('franchises.id', '=', 'fc.franchise_id')->where(['fc.deleted_at' => NULL]);
            })
           // ->where(['countries.name' => $address->country,'s.name' => $address->state,'c.name' => $address->city])
            ->where(function($query){
                $query->whereRaw('(end_date >= CURDATE() OR is_custom = 1)')->where('fp.remain_credits', '>',0);
            })
            ->where('franchises.area_lat1', '>=', $latitude)
            ->where('franchises.area_lng1', '<=', $longitude)
            ->where('franchises.area_lat2', '<=', $latitude)
            ->where('franchises.area_lng2', '>=', $longitude)
            ->orderBy('distance', 'ASC')
            ->orderBy('cancel_count', 'ASC')
            ->orderBy('franchises.id', 'DESC')
            ->groupBy('franchises.id')
            ->get()->map(function($query){
                $query->f_services = $query->franchise_services->pluck('service_id')->toArray();
                $query->franchise_workers->map(function($q){
                    $q->w_services = $q->worker_service->pluck('service_id')->toArray();
                });
                return $query;
            });
            
        // echo $franchises->count();
        // echo '<pre>';
        // print_R($franchises->toArray());
        // die;

        if($franchises->count()){

            // Group by franchise id
            $franchise_data = $cart_data;
            //echo '<pre>';print_R($franchise_data);die;
            $order_datetime = Carbon::parse($cart_data['slot_date'] . $cart_data['slot_time']);
            $order_datetime1 = $order_datetime->format('Y-m-d H:i:s');

            //// --------------------------NEED to check opening closing and offdays, also credit--------------------------------------


            $order_assign = [];

            // packages assign calculation
            if(!empty($franchise_data['packages'])){
                foreach($franchise_data['packages'] as $k => $f_package_data){
                    foreach($franchises as $franchise){
                        $worker_assigned_packages = [];
                        if(!empty($franchise->franchise_timings->count())){

                            $collection = collect($franchise->franchise_timings);
                            $franchise_timings = $collection->mapWithKeys(function ($item) {
                                return [$item['day'] => $item];
                            })->toArray();

                            $off_days = $franchise->franchise_offday->pluck('off_date')->toArray();

                            if($f_package_data['franchises_id'] == 0 || $f_package_data['franchises_id'] == $franchise->id){
                                $f_package = $f_package_data;
                                $assigned_package  = [];
                                // echo '<pre>';
                                // print_R($f_package);die;
                                $assignable_services = 0;

                                $starting_date = $order_datetime;
                                if($franchise->franchise_workers->count()){
                                    foreach($franchise->franchise_workers as $worker){
                                        foreach($f_package['package_service'] as $p_service){
                                            $time_required = 0; // in minute
                                            $travel_time_required = 0;
                                            if(!empty($p_service['hour'])){
                                                $time_required += $p_service['hour'] * 60;
                                            }
                                            if(!empty($p_service['minute'])){
                                                $time_required += $p_service['minute'];
                                            }

                                            if(!empty($franchise->hour)){
                                                $time_required += $franchise->hour * 60;
                                            }
                                            if(!empty($franchise->minute)){
                                                $time_required += $franchise->minute;
                                            }

                                            if(!empty($franchise->hour)){
                                                $travel_time_required += $franchise->hour * 60;
                                            }
                                            if(!empty($franchise->minute)){
                                                $travel_time_required += $franchise->minute;
                                            }

                                            $time_required = $time_required * $f_package_data['quantity'];

                                            if(in_array($p_service['id'], $franchise->f_services) && in_array($p_service['id'], $worker->w_services)){

                                                $order_datetime_new = Carbon::parse($order_datetime);
                                                $order_datetime1 = $order_datetime_new->format('Y-m-d H:i:s');
                                                $check_order_datetime1 = $order_datetime_new->subMinute($travel_time_required)->format('Y-m-d H:i:s');

                                                $order_datetime2 = $order_datetime_new->addMinute($time_required)->format('Y-m-d H:i:s');
                                                $check_order_datetime2 = $order_datetime_new->addMinute($time_required+$travel_time_required)->format('Y-m-d H:i:s');

                                                $worker_orders = Worker_assigned_services::where(['worker_id' => $worker->id])
                                                ->where(function($query) use($check_order_datetime1, $check_order_datetime2){
                                                    $query->whereBetween('start_time', [$check_order_datetime1, $check_order_datetime2])
                                                    ->OrwhereBetween('end_time', [$check_order_datetime1, $check_order_datetime2]);
                                                })
                                                ->select(['id'])
                                                ->get();

                                                if($worker_orders->count() == 0){
                                                    if(isset($worker_assigned_packages[$worker['id']])){
                                                        $start_time = Carbon::parse($worker_assigned_packages[$worker->id]['end_time']);
                                                        $end_time = $start_time->addMinute($time_required)->format('Y-m-d H:i:s');

                                                        $time_required += $worker_assigned_packages[$worker->id]['take_time'];

                                                        $order_dates = [];
                                                        $period = CarbonPeriod::create($check_order_datetime1, $check_order_datetime2);
                                                        // Iterate over the period
                                                        foreach ($period as $date) {
                                                            $order_dates[] = $date->format('Y-m-d');
                                                        }

                                                        $isOffday = false;
                                                        $isClosed = true;
                                                        $diff = array_intersect($off_days,$order_dates);
                                                        if(!empty($diff)){
                                                            $isOffday = true;
                                                        }

                                                        $starttime = Carbon::parse($order_datetime1);
                                                        $start_dayname = strtolower($starttime->format('D'));
                                                        $start_date = strtolower($starttime->format('Y-m-d'));
                                                        $endtime = Carbon::parse($order_datetime2);
                                                        $end_dayname = strtolower($endtime->format('D'));

                                                        if(isset($franchise_timings[$start_dayname]) && isset($franchise_timings[$end_dayname])){

                                                            $start_daytime = Carbon::parse($start_date.' '.$franchise_timings[$start_dayname]['open_time']);
                                                            $end_daytime = Carbon::parse($start_date.' '.$franchise_timings[$end_dayname]['close_time']);
                                                            if($start_daytime <= $starttime && $end_daytime >= $endtime){
                                                                $isClosed = false;
                                                            }

                                                        }

                                                        if($isOffday == false && $isClosed == false){
                                                            $service_data = [
                                                                'take_time' => $time_required,
                                                                'start_time' => $order_datetime1,
                                                                'end_time' => $order_datetime2
                                                            ];
                                                            $p_service = array_merge($p_service,$service_data);

                                                            $package_data = $worker_assigned_packages[$worker->id];
                                                            $package_data['package_service'][] = $p_service;

                                                            $package_data['take_time'] = $time_required;
                                                            $package_data['end_time'] = $order_datetime2;
                                                            $worker_assigned_packages[$worker->id] = $package_data;

                                                            $assigned_package = $package_data;
                                                            unset($f_package['package_service'][$p_service['id']]);

                                                            $order_datetime = $order_datetime_new;
                                                        }
                                                    }else{
                                                        $package_data = $f_package;
                                                        unset($package_data['package_service']);

                                                        $order_dates = [];
                                                        $period = CarbonPeriod::create($order_datetime1, $order_datetime2);
                                                        // Iterate over the period
                                                        foreach ($period as $date) {
                                                            $order_dates[] = $date->format('Y-m-d');
                                                        }

                                                        $isOffday = false;
                                                        $isClosed = true;
                                                        $diff = array_intersect($off_days,$order_dates);
                                                        if(!empty($diff)){
                                                            $isOffday = true;
                                                        }

                                                        $starttime = Carbon::parse($order_datetime1);
                                                        $start_dayname = strtolower($starttime->format('D'));
                                                        $start_date = strtolower($starttime->format('Y-m-d'));
                                                        $endtime = Carbon::parse($order_datetime2);
                                                        $end_dayname = strtolower($endtime->format('D'));

                                                        if(isset($franchise_timings[$start_dayname]) && isset($franchise_timings[$end_dayname])){
                                                            
                                                            $start_daytime = Carbon::parse($start_date.' '.$franchise_timings[$start_dayname]['open_time']);
                                                            $end_daytime = Carbon::parse($start_date.' '.$franchise_timings[$end_dayname]['close_time']);
                                                            if($start_daytime <= $starttime && $end_daytime >= $endtime){
                                                                $isClosed = false;
                                                            }

                                                        }

                                                        if($isOffday == false && $isClosed == false){
                                                            $service_data = [
                                                                'take_time' => $time_required,
                                                                'start_time' => $order_datetime1,
                                                                'end_time' => $order_datetime2
                                                            ];
                                                            $p_service = array_merge($p_service,$service_data);
                                                            $package_data['package_service'][] = $p_service;
                                                            $package_data['take_time'] = $time_required;
                                                            $package_data['start_time'] = $order_datetime1;
                                                            $package_data['end_time'] = $order_datetime2;
                                                            $worker_assigned_packages[$worker->id] = $package_data;

                                                            $assigned_package = $package_data;
                                                            unset($f_package['package_service'][$p_service['id']]);

                                                            $order_datetime = $order_datetime_new;
                                                        }

                                                    }
                                                }
                                            }
                                        }
                                    }
                                }

                                $is_assigned = false;
                                if(!empty($assigned_package)){

                                    $assigned_package['assiged_to_workers'] = $worker_assigned_packages;
                                    if($f_package_data['franchises_id'] == $franchise->id){
                                        if(empty($f_package['package_service'])){

                                            $data[$franchise->id]['packages'][] = $assigned_package;
                                            $assign_arr = [
                                                'franchises_id' => $franchise->id,
                                                'f_plan_id' => $franchise->f_plan_id,
                                                'data' => $data[$franchise->id],
                                                'take_time' => $assigned_package['take_time'],
                                                // 'start_time' => $assigned_package['start_time'],
                                                'end_time' => $assigned_package['end_time']
                                            ];
                                            $order_assign[$franchise->id] = $assign_arr;

                                            if(!isset($order_assign[$franchise->id]['start_time'])){
                                                $order_assign[$franchise->id]['start_time'] = $assigned_package['start_time'];
                                            }
                                            unset($f_package['packages'][$k]);
                                            unset($franchise_data['packages'][$k]);
                                            unset($franchise_data['packages'][$k]);
                                            $is_assigned = true;
                                        }
                                        $f_package_data = $franchise_data['packages'][$k] = $f_package;
                                    }else{
                                        $data[$franchise->id]['packages'][] = $assigned_package;
                                        $assign_arr = [
                                            'franchises_id' => $franchise->id,
                                            'f_plan_id' => $franchise->f_plan_id,
                                            'data' => $data[$franchise->id],
                                            'take_time' => $assigned_package['take_time'],
                                            // 'start_time' => $assigned_package['start_time'],
                                            'end_time' => $assigned_package['end_time']
                                        ];
                                        $order_assign[$franchise->id] = $assign_arr;
                                        if(!isset($order_assign[$franchise->id]['start_time'])){
                                            $order_assign[$franchise->id]['start_time'] = $assigned_package['start_time'];
                                        }

                                        if(empty($f_package['package_service'])){
                                            unset($f_package['packages'][$k]);
                                            $f_package_data = $franchise_data['packages'][$k] = [];
                                            unset($franchise_data['packages'][$k]);
                                        }else{
                                            $franchise_data['packages'][$k] = $f_package;
                                            $f_package_data = $franchise_data['packages'][$k] = $f_package;
                                        }
                                        $is_assigned = true;
                                    }
                                }
                                if($is_assigned == false){
                                    $order_datetime = $starting_date;
                                }
                            }
                        }
                    }
                }
            }

            // services assign calculation
            if(!empty($franchise_data['services'])){
                foreach($franchise_data['services'] as $s => $f_service_data){

                    $isAssiged = false;
                    foreach($franchises as $franchise){
                        $worker_assigned_services = [];
                        if($franchise->franchise_workers->count()){

                            $collection = collect($franchise->franchise_timings);
                            $franchise_timings = $collection->mapWithKeys(function ($item) {
                                return [$item['day'] => $item];
                            })->toArray();

                            $off_days = $franchise->franchise_offday->pluck('off_date')->toArray();
                            foreach($franchise->franchise_workers as $worker){
                                if(!empty($franchise_data['services'][$s])){
                                if(in_array($f_service_data['id'], $franchise->f_services) && in_array($f_service_data['id'], $worker->w_services)){
                                    $time_required = 0; // in minute
                                    $travel_time_required = 0;

                                    if(!empty($f_service_data['hour'])){
                                        $time_required += $f_service_data['hour'] * 60;
                                    }
                                    if(!empty($f_service_data['minute'])){
                                        $time_required += $f_service_data['minute'];
                                    }
                                    $time_required = $time_required * $f_service_data['quantity'];
                                    if(!empty($franchise->hour)){
                                        $travel_time_required += $franchise->hour * 60;
                                    }
                                    if(!empty($franchise->minute)){
                                        $travel_time_required += $franchise->minute;
                                    }

                                    $order_datetime_new = Carbon::parse($order_datetime);
                                    $order_datetime1 = $order_datetime_new->format('Y-m-d H:i:s');
                                    $check_order_datetime1 = $order_datetime_new->subMinute($travel_time_required)->format('Y-m-d H:i:s');

                                    $order_datetime2 = $order_datetime_new->addMinute($time_required)->format('Y-m-d H:i:s');
                                    $check_order_datetime2 = $order_datetime_new->addMinute($time_required+$travel_time_required)->format('Y-m-d H:i:s');

                                    $order_datetime_new = $order_datetime2;

                                    $worker_orders = Worker_assigned_services::where(['worker_id' => $worker->id])
                                        ->where(function($query) use($check_order_datetime1, $check_order_datetime2){
                                            $query->whereBetween('start_time', [$check_order_datetime1, $check_order_datetime2])
                                            ->OrwhereBetween('end_time', [$check_order_datetime1, $check_order_datetime2]);
                                        })
                                        ->select(['id'])
                                        ->get();


                                    if($worker_orders->count() == 0){

                                        if(isset($order_assign[$franchise->id])){

                                            $time_required += $order_assign[$franchise->id]['take_time'];
                                            $start_time = Carbon::parse($order_assign[$franchise->id]['end_time']);
                                            $end_time = $start_time->addMinute($time_required)->format('Y-m-d H:i:s');

                                            $order_dates = [];
                                            $period = CarbonPeriod::create($check_order_datetime1, $check_order_datetime2);
                                            // Iterate over the period
                                            foreach ($period as $date) {
                                                $order_dates[] = $date->format('Y-m-d');
                                            }

                                            $isOffday = false;
                                            $isClosed = true;
                                            $diff = array_intersect($off_days,$order_dates);
                                            if(!empty($diff)){
                                                $isOffday = true;
                                            }

                                            $starttime = Carbon::parse($order_datetime1);
                                            $start_dayname = strtolower($starttime->format('D'));
                                            $start_date = strtolower($starttime->format('Y-m-d'));
                                            $endtime = Carbon::parse($order_datetime2);
                                            $end_dayname = strtolower($endtime->format('D'));
                                            $end_date = strtolower($endtime->format('Y-m-d'));

                                            if(isset($franchise_timings[$start_dayname]) && isset($franchise_timings[$end_dayname])){

                                                $start_daytime = Carbon::parse($start_date.' '.$franchise_timings[$start_dayname]['open_time']);
                                                $end_daytime = Carbon::parse($start_date.' '.$franchise_timings[$end_dayname]['close_time']);
                                                if($start_daytime <= $starttime && $end_daytime >= $endtime){
                                                    $isClosed = false;
                                                }
                                            }


                                            if($isClosed == false && $isClosed == false){
                                            // $data = $order_assign[$franchise->id]['data'];
                                                $service_data = [
                                                    'take_time' => $time_required,
                                                    'start_time' => $order_datetime1,
                                                    'end_time' => $order_datetime2
                                                ];
                                                $f_service_data = array_merge($f_service_data,$service_data);

                                                $worker_assigned_services[$worker->id] = $f_service_data;


                                                $assiged_to_workers = $f_service_data;
                                                $assiged_to_workers['assiged_to_workers'] =  $worker_assigned_services;

                                                $data[$franchise->id]['services'][] = $assiged_to_workers;

                                                $order_assign[$franchise->id]['take_time'] = $time_required;
                                                $order_assign[$franchise->id]['end_time'] = $order_datetime2;
                                                $order_assign[$franchise->id]['data'] = $data[$franchise->id];

                                                if(!isset($order_assign[$franchise->id]['start_time'])){
                                                    $order_assign[$franchise->id]['start_time'] = $order_datetime1;
                                                }
                                                unset($franchise_data['services'][$s]);
                                                $isAssiged = true;
                                                break;
                                            }
                                        }else{


                                            $order_dates = [];
                                            $period = CarbonPeriod::create($order_datetime1, $order_datetime2);
                                            // Iterate over the period
                                            foreach ($period as $date) {
                                                $order_dates[] = $date->format('Y-m-d');
                                            }

                                            $isOffday = false;
                                            $isClosed = true;
                                            $diff = array_intersect($off_days,$order_dates);
                                            if(!empty($diff)){
                                                $isOffday = true;
                                            }


                                            $starttime = Carbon::parse($order_datetime1);
                                            $start_dayname = strtolower($starttime->format('D'));
                                            $start_date = strtolower($starttime->format('Y-m-d'));
                                            $endtime = Carbon::parse($order_datetime2);
                                            $end_dayname = strtolower($endtime->format('D'));
                                            $end_date = strtolower($endtime->format('Y-m-d'));


                                            if(isset($franchise_timings[$start_dayname]) && isset($franchise_timings[$end_dayname])){

                                                $start_daytime = Carbon::parse($start_date.' '.$franchise_timings[$start_dayname]['open_time']);
                                                $end_daytime = Carbon::parse($end_date.' '.$franchise_timings[$end_dayname]['close_time']);
                                                if($start_daytime <= $starttime && $end_daytime >= $endtime){
                                                    $isClosed = false;
                                                }
                                            }


                                            if($isOffday == false && $isClosed == false){

                                                $service_data = [
                                                    'take_time' => $time_required,
                                                    'start_time' => $order_datetime1,
                                                    'end_time' => $order_datetime2
                                                ];
                                                $f_service_data = array_merge($f_service_data,$service_data);

                                                $worker_assigned_services[$worker->id] = $f_service_data;
                                                $assiged_to_workers = $f_service_data;
                                                $assiged_to_workers['assiged_to_workers'] =  $worker_assigned_services;

                                                $data[$franchise->id]['services'][] = $assiged_to_workers;
                                                $order_assign[$franchise->id] = [
                                                    'franchises_id' => $franchise->id,
                                                    'f_plan_id' => $franchise->f_plan_id,
                                                    'data' => $data[$franchise->id],
                                                    'take_time' => $time_required,
                                                    // 'start_time' => $order_datetime1,
                                                    'end_time' => $order_datetime2
                                                ];
                                                if(!isset($order_assign[$franchise->id]['start_time'])){
                                                    $order_assign[$franchise->id]['start_time'] = $order_datetime1;
                                                }
                                                unset($franchise_data['services'][$s]);
                                                $isAssiged = true;
                                                break;
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
            // die;
            // echo '<pre>';
            // print_R($order_assign);
            // die;

            $is_order_place = true;
            $is_fully_allocated = 1;
            $unallocated = '';
            if(!empty($franchise_data)){
                if(!empty($franchise_data['packages'])){
                    $is_fully_allocated = 0;
                }
                if(!empty($franchise_data['services'])){
                    $is_fully_allocated = 0;
                }
            }
            if($is_fully_allocated == 0){
                $unallocated = $franchise_data;
            }

            $isPlaceOrderRequest = $request->is_check;
            $razorpay_payment_id = $request->razorpay_payment_id;
            
            if($isPlaceOrderRequest == true){
                
                if($is_order_place == true){
                    return $this->success([
                        'order_can_place' => true
                    ]);
                }else{
                    return $this->success([
                        'order_can_place' => false,
                        'message' => 'Currently your order can not process at provided time, please change and try again.'
                    ]);
                }
            }
           
            if($is_order_place == true){
                
                $cart_data['payment_type'] = $payment_type;
                $item_number = Str::random(4) . time();
                $order = new Orders;
                $order->user_id = $user_detail->id;
                $order->cart = $cart_data;
                $order->method = $payment_type;
                $order['user_id'] = $user_detail->id;
                $order['cart'] = $cart_data;
                $order['totalQty'] = $total_quantity;
                $order['pay_amount'] = $cart_data['final_total'];
                $order['original_price'] = $cart_data['origional_price'];
                $order['method'] = $payment_type;
                $order['customer_email'] = $user_detail->email;
                $order['customer_name'] = $cart_data['customer_name'];
                $order['customer_phone'] = $user_detail->phone;
                $order['order_number'] = $item_number;
                $order['customer_address'] = $cart_data['address'];
                $order['coupon_code'] = $cart_data['offer_code'];
                $order['gift_id'] = !empty($cart_data['gift_id']) ? $cart_data['gift_id'] : null;
                $order['coupon_discount'] = $cart_data['discount'];
                $order['payment_status'] = $cart_data['final_total'] ? "Pending" : 'Paid';
                $order['customer_address_id'] = $cart_data['address_id'];
                $order['unallocated'] = $unallocated;
                $order['is_fully_allocated'] = $is_fully_allocated;
                if($request->payment_method_type == 'Razorpay'){
                    $order['pay_id'] = !empty($razorpay_payment_id) ? $razorpay_payment_id : null;
                    if(!empty($razorpay_payment_id)){
                        $order['payment_status'] = 'Paid';
                    }
                    
                }
        
                $order->save();

                //--------------------------- For Notification Start------------------

                $user_ids = [];
                $users = Admin::all();

                foreach($users as $user){
                // echo '<pre>'; print_R($user->role);die;
                    if($user->id == 1){
                        $user_ids[] = $user->id;
                    }else{
                        $sections = explode(" , ",$user->role->section);
                        if (in_array('orders', $sections)){
                            $user_ids[] = $user->id;
                        }
                    }
                }

                if(!empty($user_ids)){
                    
                    $order_id = $order->id;
                    $type = 'new order';
                    $message = 'New order arrived';
        
                    $data = [];
                    foreach($user_ids as $user_id){
                        $data[] = [
                            'user_id' => $user_id,
                            'order_id' => $order_id,
                            'type' => $type,
                            'message' => $message
                        ];
                    }

                    Notification::insert($data);
                }

                //--------------------------- For Notification End ------------------//

                
                $data = [
                    'name' => $cart_data['customer_name'],
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'email' => $user_detail->email,
                ];

                // Please uncommet when mail server working on 
                Mail::send('front.email.place-order', $data, function($message)use($data) {
                    $message->to($data['email'])
                        ->subject('Order placed successfully');
                });


                $track = new Order_tracks;
                $track->title = 'Pending';
                $track->text = 'You have successfully placed your order.';
                $track->order_id = $order->id;
                $track->save();
                foreach($order_assign as $assign){

                    $assigned_data = $assign['data'];
                    $Franchises_order = new Franchises_order;
                    $Franchises_order->franchises_id = $assign['franchises_id'];
                    $Franchises_order->orders_id = $order->id;
                    $Franchises_order->take_time = $assign['take_time'];
                    $Franchises_order->order_details = $assigned_data;
                    $Franchises_order->start_time = $assign['start_time'];
                    $Franchises_order->end_time = $assign['end_time'];
                    $Franchises_order->save();


                    $Franchise_plan = Franchise_plans::where(['franchise_id' => $assign['franchises_id']])->first();
                    $Franchise_plan->remain_credits = $Franchise_plan->remain_credits - 1;
                    $Franchise_plan->save();

                    if(!empty($assigned_data['packages'])){
                        foreach($assigned_data['packages'] as $assigned_packages){
                            foreach($assigned_packages['assiged_to_workers'] as $worker_id => $assiged){

                                if(!empty($assiged['package_service'])){
                                    foreach($assiged['package_service'] as $package_service){
                                        $worker_assigned_services = new Worker_assigned_services;

                                        $worker_assigned_services->worker_id = $worker_id;
                                        $worker_assigned_services->order_id = $order->id;
                                        $worker_assigned_services->f_order_id = $Franchises_order->id;
                                        $worker_assigned_services->is_package = 1;
                                        $worker_assigned_services->package_id = $assiged['id'];
                                        $worker_assigned_services->service_id = $package_service['id'];
                                        $worker_assigned_services->take_time = $package_service['take_time'];
                                        $worker_assigned_services->start_time = $package_service['start_time'];
                                        $worker_assigned_services->end_time = $package_service['end_time'];
                                        $worker_assigned_services->save();


                                        $Ordered_service = new Ordered_services;
                                        $Ordered_service->order_id = $order->id;
                                        $Ordered_service->service_id = $package_service['id'];
                                        $Ordered_service->is_package = 1;
                                        $Ordered_service->package_id = $assiged['id'];
                                        $Ordered_service->is_allocated = 1;
                                        $Ordered_service->save();
                                    }
                                }
                            }
                        }
                    }

                    if(!empty($assigned_data['services'])){
                        foreach($assigned_data['services'] as $assiged_services){
                            if(!empty($assiged_services['assiged_to_workers'])){
                                foreach($assiged_services['assiged_to_workers'] as $worker_id => $assiged){

                                    $worker_assigned_services = new Worker_assigned_services;
                                    $worker_assigned_services->worker_id = $worker_id;
                                    $worker_assigned_services->order_id = $order->id;
                                    $worker_assigned_services->f_order_id = $Franchises_order->id;
                                    $worker_assigned_services->service_id = $assiged['id'];
                                    $worker_assigned_services->take_time = $assiged['take_time'];
                                    $worker_assigned_services->start_time = $assiged['start_time'];
                                    $worker_assigned_services->end_time = $assiged['end_time'];
                                    $worker_assigned_services->save();

                                    $Ordered_service = new Ordered_services;
                                    $Ordered_service->order_id = $order->id;
                                    $Ordered_service->service_id = $assiged['id'];
                                    $Ordered_service->is_allocated = 1;
                                    $Ordered_service->save();
                                }
                            }

                        }
                    }

                    //--------------------------- For Franchise Notification Start------------------

                    $users = $Franchises_order->franchises_id;

                    $franchise_info = Franchise::where('id',$users)->select('user_id')->get();

                    $franchise_users_ids = Admin::whereIn('id',$franchise_info)->select('id')->first(); 
                                    
                    $notification = new Notification;
                    $notification->order_id = $order->id;
                    $notification->user_id = $franchise_users_ids->id;
                    $notification->f_order_id = $Franchises_order->id;
                    $notification->is_package = isset($worker_assigned_services->is_package) ? $worker_assigned_services->is_package : 0;
                    $notification->package_id = isset($worker_assigned_services->package_id) ? $worker_assigned_services->package_id : 0;
                    $notification->service_id = isset($worker_assigned_services->service_id) ? $worker_assigned_services->service_id : 0;
                    $notification->is_franchise = 1;
                    $notification->type = 'new order';
                    $notification->message = 'New order arrived';

                    $notification->save();

                    

                //--------------------------- For Franchise Notification End------------------

                }


                if(isset($unallocated['packages']) && !empty($unallocated['packages'])){
                    foreach($unallocated['packages'] as $package){
                        if(!empty($package['package_service'])){
                            foreach($package['package_service'] as $service){
                                $Ordered_service = new Ordered_services;
                                $Ordered_service->order_id = $order->id;
                                $Ordered_service->service_id = $service['id'];
                                $Ordered_service->is_package = 1;
                                $Ordered_service->package_id = $package['id'];
                                $Ordered_service->save();
                            }
                        }

                    }
                }
                if(isset($unallocated['services']) && !empty($unallocated['services'])){
                    foreach($unallocated['services'] as $service){
                        $Ordered_service = new Ordered_services;
                        $Ordered_service->order_id = $order->id;
                        $Ordered_service->service_id = $service['id'];
                        $Ordered_service->save();
                    }
                }


                // Session::put('my_cart',[]);
                // Session::forget('my_cart');
                $My_cart = My_cart::where('user_id', $user_detail->id)->first();
                $My_cart->delete();

                return $this->success([
                    'user_id' => $order->user_id,
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'is_check' => $request->is_check,
                    'payment_method_type' => $request->payment_method_type,
                    'message' => 'Your order received successfullly.',
                ]);
                //return redirect()->route('user.order_details', $order->id)->with('success', 'Your order received successfullly.');
                //return response()->json(['success' => 1, 'message' => 'success', 'order_id' => $order->id]);

            }else{
                return $this->error('Currently your order can not process at provided time, please change and try again.', 401);
                //return redirect()->route('user.payment_method')->with('error', 'Currently your order can not process at provided time, please change and try again.');
            }
            
        }
        return $this->error('Currently your order can not process.', 401);
        //return redirect()->route('user.payment_method')->with('error', 'Currently your order can not process.');

    }

    public function order_pay(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'order_id' => 'required',
            'payment_type' => 'required',
            'razorpay_payment_id' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }

        $order_id = $request->order_id;
        $pay_id = $request->razorpay_payment_id;
        $order = Orders::where('id',$order_id)->first();
        
        if(!empty($order)){
            $order->payment_status = 'paid';
            $order->pay_id = $request->pay_id;
            $order->save();
        }

        if($order->count() > 0){
            return $this->success([
                'user_id' => $order->user_id,
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'payment_method_type' => $order->method,
                'message' => 'Your order payment received successfullly.',
            ]);
        }else{
            return $this->error('No any orders found.', 401);
        }   
    }

    public function cancel_order(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required',
            'user_id' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }

        $user_id = $request->user_id;
        $order_id = $request->order_id;
        $Order = Orders::where(['user_id' => $user_id, 'id' => $order_id])->first();
        if($Order){
            $Order->status = 'cancelled';
            $Order->save();

            $track = new Order_tracks;
            $track->title = 'Cancelled by you';
            $track->text = 'You have cancelled your order.';
            $track->order_id = $Order->id;
            $track->save();

            return $this->success([
                'message' => 'Order has been cancelled successfully.',
            ]);
        }
        return $this->error('Invalid access', 401);
    }
}
