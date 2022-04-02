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
use App\Franchise_worker;
use App\Franchises_order;
use App\Franchise;
use App\Orders;
use App\Country;
use App\State;
use App\City;
use App\Franchise_work_cities;
use App\Notification;

class FranchiseController extends Controller
{
    use ApiResponser;
    public function dashboard(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'user_id' => 'required'
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
                $total_workers = Franchise_worker::where(['franchises_id' => $franchise_id])->count();
                $total_orders = Franchises_order::where(['franchises_id' => $franchise_id])->count();
                $completed_orders = Franchises_order::where(['franchises_orders.franchises_id' => $franchise_id,'franchises_orders.status' => 1])
                ->join('worker_assigned_services as ws','ws.f_order_id','=','franchises_orders.id')
                ->where('ws.status',3)
                ->count();

                $cancelled_orders = Franchises_order::where(['franchises_id' => $franchise_id,'status' => 2])->count();
                $rejected_orders = Franchises_order::where('franchises_orders.franchises_id','=',$franchise_id)
                                    ->join('orders as o','o.id','=','franchises_orders.orders_id')
                                    ->where('o.status','=','cancelled')
                                    ->count();

                $today_completed_orders = Franchises_order::where(['franchises_orders.franchises_id'=>$franchise_id])
                ->join('worker_assigned_services as ws','ws.f_order_id','=','franchises_orders.id')
                ->whereDate('ws.created_at',Carbon::today())
                ->count();     

                $total_working_orders = Franchises_order::where(['franchises_orders.franchises_id' => $franchise_id,'franchises_orders.status'=>1])
                ->join('worker_assigned_services as ws','ws.f_order_id','=','franchises_orders.id')
                ->where('ws.status',1)
                ->count();

                // $orders = Orders::where('user_id','=',$user->id)->whereIn('status', ['pending','processing','on delivery'])->orderBy('id','desc')->get();
                $ongoing_orders = Franchises_order::where(['franchises_orders.franchises_id' => $franchise_id,'franchises_orders.status'=>1])
                ->join('orders as o','o.id','=','franchises_orders.orders_id')
                ->whereIn('o.status', ['pending','processing','on delivery'])
                ->count();
                
                //----------------------franchise_account_start--------------------------//
                    $franchise_account = Franchise::with(['frenchise_orders' => function ($query) {
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
            
            
            
                    $franchise_account->credit_amount = 0;
                    $franchise_account->debit_amount = 0;
                    $franchise_account->offline_amount = 0;
                    $franchise_account->online_amount = 0;
                    $franchise_account->total_commission = 0;
                    $franchise_account->total_franchise_payment = 0;
            
                    if(!empty($franchise_account)){
            
                        if(!empty($franchise_account->frenchise_orders)){
                            foreach($franchise_account->frenchise_orders as $frenchise_order){
            
                                if(!empty($frenchise_order->f_order)){
            
            
                                    if($frenchise_order->f_order->payment_status == 'Paid' || $frenchise_order->f_order->payment_status == 'Refund'){
            
            
                                        if($frenchise_order->f_order->method == 'Cash On Delivery'){
            
                                            if(isset($frenchise_order->order_details['services']) && $frenchise_order->f_order->status == 'completed'){
            
                                                foreach($frenchise_order->order_details['services'] as $service){
                                                    $amount = $service['price'];
                                                    $franchise_account->offline_amount += $amount;
                                                }
                                            }
            
                                            if(isset($frenchise_order->order_details['packages']) && $frenchise_order->f_order->status == 'completed'){
            
                                                foreach($frenchise_order->order_details['packages'] as $package){
                                                    if(!empty($package['package_service'])){
                                                        foreach($package['package_service'] as $service){
                                                            $amount = $service['price'];
                                                            $franchise_account->offline_amount += $amount;
                                                        }
                                                    }
                                                }
                                            }
                                        }
            
            
                                        if(($frenchise_order->f_order->method == 'Razorpay' || $frenchise_order->f_order->method == 'Pay Online After Service') && $frenchise_order->f_order->payment_status == 'Paid'){
            
                                            if(isset($frenchise_order->order_details['services'])){
                                                foreach($frenchise_order->order_details['services'] as $service){
                                                    $amount = $service['price'];
                                                    $franchise_account->online_amount += $amount;
                                                }
                                            }
            
                                            if(isset($frenchise_order->order_details['packages'])){
            
                                                foreach($frenchise_order->order_details['packages'] as $package){
                                                    if(!empty($package['package_service'])){
                                                        foreach($package['package_service'] as $service){
                                                            $amount = $service['price'];
                                                            $franchise_account->online_amount += $amount;
                                                        }
                                                    }
                                                }
                                            }
                                        }
            
                                    }
                                }
                            }
            
                        }
            
                        $offline_commission = ($franchise_account->offline_amount * $franchise_account->commission) / 100;
                        $franchise_account->debit_amount = $offline_commission;
            
                        $online_commission = ($franchise_account->online_amount * $franchise_account->commission) / 100;
                        $franchise_account->credit_amount = $franchise_account->online_amount - $online_commission;
            
                        $franchise_account->total_commission = $online_commission + $offline_commission;
            
                        $franchise_account->cr_amount = $franchise_account->dr_amount = 0;
                        foreach($franchise_account->payments as $payments){
            
                            if($payments->type == 2){ //credit
                                $franchise_account->cr_amount += $payments->amount;
                            }
            
                            if($payments->type == 1){//debit
                                $franchise_account->dr_amount += $payments->amount;
                            }
                        }
            
            
                        $total_franchise_payment = $franchise_account->cr_amount - $franchise_account->dr_amount;
                        $total_franchise_order_amt = $franchise_account->credit_amount - $franchise_account->debit_amount;
            
                        $payment_flow = 'Credit';
                        if($total_franchise_payment < 0){
                            $payment_flow = 'Debit';
                            $total_franchise_payment = ($total_franchise_payment * (-1));
                        }
                        $franchise_account->payment_flow = $payment_flow;
            
                        $franchise_account->total_franchise_payment = $total_franchise_payment;
            
                        // echo $total_franchise_payment;
                        //             echo '<pre>';
                        // print_R($franchise->toArray());die;
            
                        $total_franchise_outstanding = $total_franchise_payment + $total_franchise_order_amt;
            
                        $flow = 'Credit';
                        $franchise_account->outstanding_amount = $total_franchise_outstanding;
                        if($total_franchise_outstanding < 0){
                            $flow = 'Debit';
                            $total_franchise_outstanding = ($total_franchise_outstanding * (-1));
                        }
                        $franchise_account->outstanding_amount = $total_franchise_outstanding;
                        $franchise_account->flow = $flow;
                    }
            
                    $franchise_account_data = [
                        'total_earnings' => $franchise_account->offline_amount + $franchise_account->online_amount,
                        'total_commission' => $franchise_account->total_commission,
                        'payments' => $franchise_account->total_franchise_payment,
                        'payment_flow' => $franchise_account->payment_flow,
                        'total_outstanding' =>$franchise_account->outstanding_amount,
                        'total_outstanding_flow' =>$franchise_account->flow,
                    ];
                //----------------------franchise_account_end--------------------------//

                //----------------------------latest order start--------------------//
                    $order_notification = Notification::where(['user_id'=>$user_id,'is_franchise'=>1,'is_read'=>0])->pluck('order_id');

                    $franchise_latest_order = Franchises_order::where(['franchises_id' => $franchise_id])
                    ->with(['f_order' => function ($query) {
                        $query->select('id','customer_name','customer_address','pay_amount');
                    }])
                    ->whereIn('orders_id',$order_notification)
                    ->select('id','franchises_id','orders_id','status')
                    ->orderBy('id', 'DESC')
                    ->get();

                //----------------------------latest order end--------------------//

                //----------------------------notification count start--------------------------------//
                    $notification_count = Notification::where(['user_id'=>$user_id,'is_franchise'=>1,'is_read'=>0])->count();
                //----------------------------notification count end--------------------------------//
                $data = [
                    'notification_count' => $notification_count,
                    'account' => $franchise_account_data,
                    'latest_order' => $franchise_latest_order,
                    'total_orders' => $total_orders,
                    'cancel_orders' => $cancelled_orders,
                    'total_workers' => $total_workers,
                    'ongoing_orders' => $ongoing_orders,
                ];
                return $this->success([
                    'dashboard_data' => $data
                ]);
            }else{
                return $this->error('Franchise not found', 401);
            }

        }
        return $this->error('Invalid Access', 401);
    }

    public function franchise_profile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }

        $user_id = $request->user_id;
        $user = Admin::find($user_id);

        if($user){

            $franchise = Franchise::where(['user_id' => $user_id])
            ->with(['country' => function ($query) {
                $query->select('id','name');
            }])
            ->with(['state' => function ($query) {
                $query->select('id','name');
            }])
            ->with(['city' => function ($query) {
                $query->select('id','name');
            }])
            ->with(['franchise_work_cities' => function ($query) {
                $query->select('id','city_id','franchise_id')->with(['city' => function ($query) {
                    $query->select('id','name');
                }]);
            }])
            ->with(['franchise_services' => function ($query) {
                $query->select('id','franchise_id','service_id')->with(['service' => function ($query) {
                    $query->select('id','title');
                }]);
            }])
            ->first();

            if($franchise){
                return $this->success([
                    'franchise' => $franchise
                ]);
            }else{
                return $this->error('Franchise not found', 401);
            }
        }
        return $this->error('Invalid Access', 401);
    }

    public function franchise_profile_edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'country_id'=>'required',
            'state_id'=>'required',
            'city_id'=>'required',
            'address_1'=>'required',
            'longitude'=>'required',
            'latitude'=>'required',
            'pincode'=>'required',
            'franchise_name'=>'required',
            'email'=>'required | email',
            'mobile'=>'required | numeric | digits:10',
            'commission'=>'required',
            'hour'=>'required|numeric',
            'minute'=>'required|numeric',
            'working_cities'=>'required',
        ]);
        
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }

        $user_id = $request->user_id;
        $user = Admin::find($user_id);

        if($user){

            $franchise = Franchise::where(['user_id' => $user_id])->first();

            if($franchise){

                $franchise->country_id = $request->input('country_id');
                $franchise->state_id = $request->input('state_id');
                $franchise->city_id = $request->input('city_id');
                $franchise->hour = $request->input('hour');
                $franchise->minute = $request->input('minute');
                $franchise->user_id = $request->input('user_id');
                $franchise->address_1 =$request->input('address_1');
                $franchise->address_2 = $request->input('address_2');
                $franchise->longitude = $request->input('longitude');
                $franchise->latitude = $request->input('latitude');
                $franchise->pincode = $request->input('pincode');
                $franchise->franchise_name = $request->input('franchise_name');
                $franchise->email = $request->input('email');
                $franchise->mobile = $request->input('mobile');
                $franchise->commission = $request->input('commission');

                $franchise->area_lat1 = $request->input('area_lat1');
                $franchise->area_lng1 = $request->input('area_lng1');
                $franchise->area_lat2 = $request->input('area_lat2');
                $franchise->area_lng2 = $request->input('area_lng2');

                $franchise->save();

                $franchises_id = $franchise->id;
        
                if(!empty($request->working_cities)){

                    $franchise_work_cities = [];
                    if(!empty($franchise->franchise_work_cities)){
                        foreach($franchise->franchise_work_cities as $city){
                            $franchise_work_cities[] = $city->city_id;
                        }
                    }

                    $data = [];
                    foreach($request->working_cities as $city_id){
                        if(!in_array($city_id, $franchise_work_cities)){
                            $data[] = [
                                'city_id' => $city_id,
                                'franchise_id' => $franchises_id
                            ];
                        }
                    }

                    if(!empty($data)){
                        Franchise_work_cities::insert($data);
                    }

                    $deletable = array_diff($franchise_work_cities, $request->working_cities);
                    if(!empty($deletable)){
                        $delete_cities = Franchise_work_cities::whereIn('city_id', $deletable)->where('franchise_id',$franchises_id);
                        $delete_cities->delete();
                    }
                }
                
                unset($franchise['franchise_work_cities']);
                return $this->success([
                    'franchise' => $franchise
                ]);
                
            }else{
                return $this->error('Franchise not found', 401);
            }
        }
        return $this->error('Invalid Access', 401);

    }

    public function franchise_working_cities(Request $request)
    {
        $cities = City::where(['status'=>1])->get();

        if($cities->count()) {
            return $this->success([
                'cities' => $cities
            ]);
        }else{
            return $this->error('No any cities found.', 401);
        }
    }

    public function countries(Request $request)
    {
        $countries = Country::all();

        if($countries->count()) {
            return $this->success([
                'countries' => $countries
            ]);
        }else{
            return $this->error('No any countries found.', 401);
        }
    }

    public function states(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_id' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }

        $country_id = $request->country_id;
        $states = State::where('country_id',$country_id)->get();

        if($states->count()) {
            return $this->success([
                'states' => $states
            ]);
        }else{
            return $this->error('No any states found.', 401);
        }
    }

    public function cities(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'state_id' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }

        $state_id = $request->state_id;
        $cities = City::where('state_id',$state_id)->get();

        if($cities->count()) {
            return $this->success([
                'cities' => $cities
            ]);
        }else{
            return $this->error('No any cities found.', 401);
        }
    }
    
    public function notification_read(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'order_id' => 'required',
            'franchise_order_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }
        
        $user_id = $request->user_id;
        $user = Admin::find($user_id);
        $franchise_order_id = $request->franchise_order_id;
        $order_id = $request->order_id;

        if($user){

            $franchise = Franchise::where(['user_id' => $user_id])->first();

            if($franchise){

                $franchise_id = $franchise->id;

                $order_notification = Notification::where(['user_id'=>$user_id,'is_franchise'=>1,'order_id'=>$order_id,'f_order_id'=>$franchise_order_id,'is_read'=>0])->first();
                
                $order_notification->is_read = 1;
                $order_notification->update();
                
                return $this->success([
                    'order_notification' => $order_notification
                ]);
              
            }else{
                return $this->error('Franchise not found', 401);
            }
        }
        return $this->error('Invalid Access', 401);
    }
}
