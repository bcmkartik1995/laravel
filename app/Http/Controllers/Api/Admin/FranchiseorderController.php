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
use App\Franchises_order;
use App\Worker_assigned_services;
use App\Notification;
use App\Orders;
use App\Ordered_services;
use Illuminate\Support\Facades\DB;

class FranchiseorderController extends Controller
{
    use ApiResponser;
    
    public function frachise_order(Request $request)
    {
        $limit = 10;
        
        $validator = Validator::make($request->all(), [
            'user_id' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }
        
        $user_id = $request->user_id;
        $type = $request->type;
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        $worker_id = $request->worker_id;
        $user = Admin::find($user_id);
        $page = isset($request->page) && !empty($request->page) ? ($request->page * $limit) : 0 ;
        $limit = isset($request->limit) && !empty($request->limit) ?$request->limit : $limit ;
        if($user){

            $franchise = Franchise::where(['user_id' => $user_id])->first();
            
            if($franchise){

                $franchise_id = $franchise->id;

                if($type == "franchise_order"){

                    $franchise_orders = Franchises_order::where(['franchises_orders.franchises_id' => $franchise_id])
                    ->with(['f_order' => function ($query) {
                        $query->select('id','customer_name','customer_address');
                    }])
                    ->select('franchises_orders.id','franchises_orders.franchises_id','franchises_orders.orders_id','franchises_orders.order_details','franchises_orders.status')
                    ->orderBy('franchises_orders.id', 'DESC');

                    if($worker_id != 0){
                        $data = $franchise_orders->join('worker_assigned_services as ws','ws.f_order_id','=','franchises_orders.id')->where('ws.worker_id',$worker_id);
                    }

                }

                if($type == "complet_order"){

                    $franchise_orders = Franchises_order::where(['franchises_orders.franchises_id' => $franchise_id,'franchises_orders.status' => 1])
                    ->with(['f_order' => function ($query) {
                        $query->select('id','customer_name','customer_address');
                    }])
                    ->join('worker_assigned_services as ws','ws.f_order_id','=','franchises_orders.id')
                    ->where('ws.status',3)
                    ->select('franchises_orders.id','franchises_orders.franchises_id','franchises_orders.orders_id','franchises_orders.order_details','franchises_orders.status')
                    ->orderBy('franchises_orders.id', 'DESC');

                    if($worker_id != 0){
                        $data = $franchise_orders->where('ws.worker_id',$worker_id);
                    }
                }

                if($type == "reject_order"){

                    $franchise_orders = Franchises_order::where(['franchises_orders.franchises_id' => $franchise_id,'franchises_orders.status' => 2])
                    ->with(['f_order' => function ($query) {
                        $query->select('id','customer_name','customer_address');
                    }])
                    ->join('worker_assigned_services as ws','ws.f_order_id','=','franchises_orders.id')
                    ->select('franchises_orders.id','franchises_orders.franchises_id','franchises_orders.orders_id','franchises_orders.order_details','franchises_orders.status')
                    ->orderBy('franchises_orders.id', 'DESC');

                    if($worker_id != 0){
                        $data = $franchise_orders->where('ws.worker_id',$worker_id);
                    }
                }

                if($type == "today_complete_order"){

                    $franchise_orders = Franchises_order::where(['franchises_orders.franchises_id'=>$franchise_id])
                    ->with(['f_order' => function ($query) {
                        $query->select('id','customer_name','customer_address');
                    }])
                    ->join('worker_assigned_services as ws','ws.f_order_id','=','franchises_orders.id')
                    ->select('franchises_orders.id','franchises_orders.franchises_id','franchises_orders.orders_id','franchises_orders.order_details','franchises_orders.status')
                    ->whereDate('ws.created_at',Carbon::today())
                    ->orderBy('franchises_orders.id', 'DESC');

                    if($worker_id != 0){
                        $data = $franchise_orders->where('ws.worker_id',$worker_id);
                    }
                }

                if($type == "total_working_order"){

                    $franchise_orders = Franchises_order::where(['franchises_orders.franchises_id' => $franchise_id,'franchises_orders.status'=>1])
                    ->with(['f_order' => function ($query) {
                        $query->select('id','customer_name','customer_address');
                    }])
                    ->join('worker_assigned_services as ws','ws.f_order_id','=','franchises_orders.id')
                    ->select('franchises_orders.id','franchises_orders.franchises_id','franchises_orders.orders_id','franchises_orders.order_details','franchises_orders.status')
                    ->where('ws.status',1)
                    ->orderBy('franchises_orders.id', 'DESC');    
                    
                    if($worker_id != 0){
                        $data = $franchise_orders->where('ws.worker_id',$worker_id);
                    }
                }

                if($type == "cancel_order"){

                    $franchise_orders = Franchises_order::where('franchises_orders.franchises_id','=',$franchise_id)
                    ->with(['f_order' => function ($query) {
                        $query->select('id','customer_name','customer_address');
                    }])
                    ->join('orders as o','o.id','=','franchises_orders.orders_id')
                    ->select('franchises_orders.id','franchises_orders.franchises_id','franchises_orders.orders_id','franchises_orders.order_details','franchises_orders.status')
                    ->where('o.status','=','cancelled')
                    ->orderBy('franchises_orders.id', 'DESC');

                    if($worker_id != 0){
                        $data = $franchise_orders->join('worker_assigned_services as ws','ws.f_order_id','=','franchises_orders.id')->where('ws.worker_id',$worker_id);
                    }
                }

                if(!empty($date_from) && !empty($date_to)){

                    $datefrom = Carbon::createFromFormat('d/m/Y', $date_from)->format('Y-m-d');
                    $dateto = Carbon::createFromFormat('d/m/Y', $date_to)->format('Y-m-d');

                    $data = $franchise_orders->where(DB::raw('CAST(franchises_orders.created_at as date)'), '>=', $datefrom)->where(DB::raw('CAST(franchises_orders.created_at as date)'), '<=', $dateto);

                }

                

                $data = $franchise_orders->take($limit)->skip($page)->get();
                    
                if($data->count() != 0){
                   
                    foreach($data as $franchise_order){
                        $service_amount = 0;
                        $package_amount = 0;
                        if(!empty($franchise_order['order_details']['services'])){
                            foreach($franchise_order['order_details']['services'] as $service){
                                $service_amount += $service['price'];
                            
                            }
                        }
                        if(!empty($franchise_order['order_details']['packages'])){
                            foreach($franchise_order['order_details']['packages'] as $package){
                                $package_amount += $package['price'];
                            }
                        }
                        $franchise_order->amount = $service_amount + $package_amount;
                        unset($franchise_order['order_details']);
                    }
                }else{
                    return $this->error('Not any order found', 401);
                }

                return $this->success([
                    'franchise_orders' => $data
                ]);

            }else{
                return $this->error('Franchise not found', 401);
            }

        }
        return $this->error('Invalid Access', 401);
    }

    public function frachise_order_status(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'franchise_order_id' => 'required',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }
        
        $user_id = $request->user_id;
        $user = Admin::find($user_id);
        $franchise_order_id = $request->franchise_order_id;
        $status = $request->status;
        if($user){

            $franchise = Franchise::where(['user_id' => $user_id])->first();

            if($franchise){

                $franchise_id = $franchise->id;

                $franchises_orders = Franchises_order::find($franchise_order_id);
                $franchises_orders->status = $status;

                $franchises_orders->update();
                
                return $this->success([
                    'franchises_orders' => $franchises_orders
                ]);
              
            }else{
                return $this->error('Franchise not found', 401);
            }
        }
        return $this->error('Invalid Access', 401);
    }
    public function order_detail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'order_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }

        $user_id = $request->user_id;
        $order_id = $request->order_id;

        $user = Admin::find($user_id);
        if($user){

            $franchise = Franchise::where(['user_id' => $user_id])->first();

            if($franchise){

                $franchise_id = $franchise->id;

                $franchise_orders = Franchises_order::with(['f_order' => function ($query) {
                    $query->select('orders.*');
                }])
                ->with(['franchise' => function ($query) {
                    $query->select('id','franchise_name');
                }])
                ->where([
                    ['orders_id','=',$order_id],
                    ['franchises_id', '=', $franchise_id]
                ])
                ->get();
 

                if($franchise_orders){
                    $order_detail = [];
                    $assign_detail = [];
                    foreach($franchise_orders as $franchise_order)
                    {
                        
                        $order_detail['id'] = $franchise_order['id'];
                        $order_detail['franchises_id'] = $franchise_order['franchises_id'];

                        $cart_data = $franchise_order['order_details'];

                        $data = [];
                        $data['packages'] = [];
                        if(!empty($cart_data['packages'])){
                            foreach($cart_data['packages'] as $p => $cart_package){
                                $package_data = [];
                                $package_data['id'] = $cart_package['id'];
                                $package_data['quantity'] = $cart_package['quantity'];
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
                                $service_data['id'] = $cart_service['id'];
                                $service_data['title'] = $cart_service['title'];
                                $service_data['price'] = $cart_service['price'];
                                $service_data['quantity'] = $cart_service['quantity'];
                                $data['services'][] = $service_data;
                            }
                        }
                        
                        $order_detail['order_details'] = $data;

                        $order_detail['f_order']['id'] = $franchise_order['f_order']['id'];
                        $order_detail['f_order']['user_id'] = $franchise_order['f_order']['user_id'];
                        $order_detail['f_order']['method'] = $franchise_order['f_order']['method'];
                        $order_detail['f_order']['totalQty'] = $franchise_order['f_order']['totalQty'];
                        $order_detail['f_order']['pay_amount'] = $franchise_order['f_order']['pay_amount'];
                        $order_detail['f_order']['txnid'] = $franchise_order['f_order']['txnid'];
                        $order_detail['f_order']['order_number'] = $franchise_order['f_order']['order_number'];
                        $order_detail['f_order']['payment_status'] = $franchise_order['f_order']['payment_status'];
                        $order_detail['f_order']['status'] = $franchise_order['f_order']['status'];
                        $order_detail['f_order']['created_at'] = Carbon::parse($franchise_order['f_order']['created_at'])->format('d M Y h:i A');
                        $order_detail['f_order']['customer_email'] = $franchise_order['f_order']['customer_email'];
                        $order_detail['f_order']['customer_name'] = $franchise_order['f_order']['customer_name'];
                        $order_detail['f_order']['customer_phone'] = $franchise_order['f_order']['customer_phone'];
                        $order_detail['f_order']['customer_address'] = $franchise_order['f_order']['customer_address'];
                        
                        $worker_orders = [];
                        if(!empty($franchise_order->worker_orders)){
                            foreach($franchise_order->worker_orders as $w_order){
                                if($w_order->is_package){
                                    $worker_orders[$w_order->f_order_id]['packages'][$w_order->package_id][$w_order->service_id] = $w_order;
                                    $worker_orders['name'] = $worker_orders[$w_order->f_order_id]['packages'][$w_order->package_id][$w_order->service_id]->worker;
                                }else{
                                    $worker_orders[$w_order->f_order_id]['services'][$w_order->service_id] = $w_order;
                                    $worker_orders['name'] = $worker_orders[$w_order->f_order_id]['services'][$w_order->service_id]->worker->name;
                                }
                            }
                        }


                        

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
                                $package_data['price'] = $package['price'];

                                foreach($package['package_service'] as $service){

                                    $service_data = [];
                                    $service_data['id'] = $service['id'];
                                    $service_data['title'] = $service['title'];
                                    $service_data['price'] = $service['price'];
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

                                    $worker_id = null;
                                    if(isset($worker_orders[$franchise_order->id]['packages'][$package['id']][$service['id']]->id)){
                                        $worker_id = $worker_orders[$franchise_order->id]['packages'][$package['id']][$service['id']]->id;
                                    }

                                    $service_data['worker'] = $worker_name;
                                    $service_data['status'] = $worker_status;
                                    $service_data['start_time'] = $start_time;
                                    $service_data['end_time'] = $end_time;
                                    $service_data['worker_id'] = $worker_id;

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
                                $service_data['price'] = $service['price'];
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

                                $worker_id = null;
                                if(isset($worker_orders[$franchise_order->id]['services'][$service['id']]->id)){
                                    $worker_id = $worker_orders[$franchise_order->id]['services'][$service['id']]->id;
                                }

                                $service_data['worker'] = $worker_name;
                                $service_data['status'] = $worker_status;
                                $service_data['start_time'] = $start_time;
                                $service_data['end_time'] = $end_time;
                                $service_data['worker_id'] = $worker_id;

                                $franchise_data['services'][] = $service_data;
                            }
                            
                        }
                        $assign_detail[] = $franchise_data;

                    }
                    $order_detail['assign_detail'] = $assign_detail;

                    return $this->success([
                        'order_detail' => $order_detail
                    ]);
                }else{
                    return $this->error('Order not found', 401);
                }
                
            }else{
                return $this->error('Franchise not found', 401);
            }
        }
        return $this->error('Invalid Access', 401);
    }

    public function frachise_service_status(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'worker_id' => 'required',
            'status' => 'required'
        ]);
        
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }

        $user_id = $request->user_id;
        $user = Admin::find($user_id);

        if($user){
            $franchise = Franchise::where(['user_id' => $user_id])->first();

            if($franchise){
                $franchise_id = $franchise->id;

                $id = $request->worker_id;
                $worker_order_status = Worker_assigned_services::find($id);
                
                $worker_order_status->status = $request->status;
                $worker_order_status->save();
                
                $franchise_order_id = $worker_order_status->f_order_id;
                
                $franchises_order = Franchises_order::find($franchise_order_id);

                if($request->status == 1 && $franchises_order->status == 0){
                    
                    $franchises_order->status = 1;
                    $franchises_order->save();
                }

                if($request->status == 2)
                {
                    $order_detail = $franchises_order->order_details;
                    $order = Orders::find($franchises_order->orders_id);
                
                    // echo '<pre>';
                    // print_R($order->user_id);die;
                    //$roles = Role::all();

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
                        $type = 'unallocated service';
                        $message = 'Unallocated service found';
                        $f_order_id = $worker_order_status->f_order_id;
                        $is_package = $worker_order_status->is_package;
                        $package_id = $worker_order_status->package_id;
                        $service_id = $worker_order_status->service_id;
            
                        $data = [];
                        foreach($user_ids as $user_id){
                            $data[] = [
                                'user_id' => $user_id,
                                'order_id' => $order_id,
                                'type' => $type,
                                'f_order_id' => $f_order_id,
                                'is_package' => $is_package,
                                'package_id' => $package_id,
                                'service_id' => $service_id,
                                'message' => $message
                            ];
                        }

                        Notification::insert($data);
                    }

                    $order_cart = $order->cart;
                    
                    $unallocated_service = null;
                    $unallocated_package = null;
                    if($worker_order_status->is_package == 0){ // service check
                        $service_id = $worker_order_status->service_id;
                        if(!empty($order_detail['services'])){
                            foreach($order_detail['services'] as $s => $service){
                                if($service['id'] == $service_id){
                                    $unallocated_service = $service;
                                    unset($unallocated_service['assiged_to_workers']);
                                    unset($order_cart['services'][$service_id]);
                                    unset($order_detail['services'][$s]);
                                    
                                }
                            }
                        }
                    }else{// package check
                        $package_id = $worker_order_status->package_id;
                        $service_id = $worker_order_status->service_id;

                        if(!empty($order_detail['packages'])){
                            foreach($order_detail['packages'] as $p => $package){
                                if($package['id'] == $package_id){
                                    foreach($package['package_service'] as $k => $package_service){
                                        if($package_service['id'] == $service_id){
                                            $unallocated_package = $package;
                                            // echo '<pre>';
                                            // print_R($unallocated_package);die;
                                            // echo '<pre>';
                                            // print_R($order_detail['packages'][$package_id]['package_service'][$package_service['id']]);die;
                                            unset($unallocated_package['assiged_to_workers']);
                                            unset($unallocated_package['package_service']);
                                            unset($order_cart['packages'][$package_id][$service_id]);
                                            // echo '<pre>';
                                            // print_R($order_cart);die;
                                            unset($order_cart['packages'][$package_id]['package_service'][$package_service['id']]);
                                            
                                            //unset($order_detail[$package]['package_service'][$package_service]);
                                            
                                            unset($order_detail['packages'][$p]['package_service'][$k]);
                                            $order_detail['packages'][$p]['package_service'] = array_values($order_detail['packages'][$p]['package_service']);

                                            foreach($package['assiged_to_workers'] as $aw => $assiged_to_workers){
                                                unset($order_detail['packages'][$p]['assiged_to_workers'][$aw]['package_service'][$k]);
                                                $order_detail['packages'][$p]['assiged_to_workers'][$aw]['package_service'] = array_values($order_detail['packages'][$p]['assiged_to_workers'][$aw]['package_service']);
                                            }

                                            $unallocated_package['package_service'][] = $package_service;
                                        }
                                    }
                                }
                            }
                        }
                    }

                    
                    $unallocated = $order->unallocated;
                    
                    if($unallocated == ''){
                        $unallocated = [];
                    }
                    if(isset($unallocated_service)){
                        $unallocated['services'][] = $unallocated_service;
                        
                    }else{
                        $unallocated['packages'][] = $unallocated_package;
                    }

                    if(empty($order_detail['services'])){
                        unset($order_detail['services']);
                    }

                    if(empty($order_detail['packages'])){
                        unset($order_detail['packages']);
                    }
                    
                    if(empty($order_detail['services']) && empty($order_detail['packages'])){
                        Worker_assigned_services::where('f_order_id',$franchises_order->id)->delete();
                        $franchises_order->delete();
                    }

                    if(isset($order_detail['services']) || isset($order_detail['packages'])){
                        $franchises_order->order_details = $order_detail;
                        $franchises_order->save();
                    }
                
                    $order->unallocated = $unallocated;

                    $order->cart = $order_cart;
                    $order->is_fully_allocated = 0;
                    
                    $order->save();

                    $unallocated_order_service = $order->unallocated;
                    

                    if(!empty($unallocated_order_service['services'])){
                        foreach($unallocated_order_service['services'] as $service){
                            if($service['id'] == $service_id){
                                Ordered_services::where(['order_id'=>$franchises_order->orders_id,'package_id'=>null,'service_id'=>$service['id']])->update(['is_allocated'=>0]);
                            }
                        }
                    }else{
                        foreach($unallocated_order_service['packages'] as $package){
                            if($package['id'] == $package_id){
                                foreach($package['package_service'] as $package_service){
                                    if($package_service['id'] == $service_id){
                                        Ordered_services::where(['order_id'=>$franchises_order->orders_id,'package_id'=>$package['id'],'service_id'=>$package_service['id']])->update(['is_allocated'=>0]);
                                    }
                                }
                            }
                        }
                    }
                }

                $data = [];

                $data['status'] = $worker_order_status['status'];
                
                return $this->success([
                    'worker_order_status' => $data
                ]);
            }else{
                return $this->error('Franchise not found', 401);
            }
        }
        return $this->error('Invalid Access', 401);
    }
    
}
