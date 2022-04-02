<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;
use Illuminate\Support\Collection;
use App\Franchise_worker;
use App\Worker_assigned_services;
use App\Notification;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class WorkerController extends Controller
{
    use ApiResponser;

    public function dashboard(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }
        
        $user_id = $request->user_id;
        $user = Franchise_worker::find($user_id);

        if($user){

            //----------------------------------- worker latest order start----------------------------------//
            $order_notification = Notification::where(['user_id'=>$user_id,'is_worker'=>1,'is_read'=>0])->pluck('order_id');
            
            $worker_latest_order =  Worker_assigned_services::where(['worker_id'=>$user_id])
            ->with(['orders' => function ($query) {
                $query->select('id','customer_name','customer_address','pay_amount');
            }])
            ->select('id','worker_id','order_id','f_order_id','is_package','package_id','service_id')
            ->whereIn('order_id',$order_notification)
            ->get();

            //----------------------------------- worker latest order end----------------------------------//


            //----------------------------------- worker notification count start----------------------------------//
            $notification_count = Notification::where(['user_id'=>$user_id,'is_worker'=>1,'is_read'=>0])->count();
            //----------------------------------- worker notification count end----------------------------------//


            //----------------------------------- worker order count start----------------------------------//
            $total_orders = Worker_assigned_services::where(['worker_id'=>$user_id])->count();

            $ongoing_orders = Worker_assigned_services::where(['worker_id'=>$user_id])
            ->whereIn('status', ['1','3','4'])
            ->count();

            $completed_orders = Worker_assigned_services::where(['worker_id'=>$user_id])
            ->where(['status'=>5])
            ->count();


            $today_orders = Worker_assigned_services::where(['worker_id'=>$user_id])
            ->whereDate('created_at',Carbon::today())
            ->count();

            //----------------------------------- worker order count end----------------------------------//
            
            return $this->success([
                'notification_count' => $notification_count,
                'worker_latest_order' => $worker_latest_order,
                'total_orders' => $total_orders,
                'ongoing_orders' => $ongoing_orders,
                'completed_orders' => $completed_orders,
                'today_orders' => $today_orders,
            ]);
              
        }
        return $this->error('Invalid Access', 401);
    }
    

    public function worker_user_profile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }
        
        $user_id = $request->user_id;
        $user = Franchise_worker::find($user_id);
      
            
        if($user){

            $user->phone = $user->mobile;
            $user->photo = $user->photo == null ? asset('assets/images/admins/profile.png') : asset('assets/images/admins/'.$user->photo);
            return $this->success([
                'worker' => $user,
            ]);

        }
        return $this->error('Invalid Access', 401);
    }

    public function worker_user_profile_update(Request $request)
    {
        $user_id = $request->user_id;

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'name' => 'required|max:255',
            'email' => 'required|email|unique:franchise_workers,email,'.$user_id.',id,deleted_at,NULL',
            'mobile' => 'required|numeric|digits:10|unique:franchise_workers,mobile,'.$user_id.',id,deleted_at,NULL',
            'photo' => 'mimes:jpg,png,jpeg|max:2048',
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }
        
        $user = Franchise_worker::find($user_id);
      
        if($user){

            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile = $request->mobile;

            if(!empty($request->photo)){
                $image = $request->file('photo');
                $imagename = rand().time().'.'.$image->extension();
                $image->move(public_path('assets/images/admins'),$imagename);
                $user->photo = $imagename;
            }

            $user->save();

            $user->photo = $user->photo == null ? asset('assets/images/admins/profile.png') : asset('assets/images/admins/'.$user->photo);

            return $this->success([
                'worker' => $user,
            ]);

        }
        return $this->error('Invalid Access', 401);
    }

    public function change_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'old_password'=>'required',
            'password'=>'required|min:6|max:15',
            'confirm_password'=>'required|same:password',
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }
        
        $user_id = $request->user_id;
        $user = Franchise_worker::find($user_id);
        
        if($user){

            if(Hash::check($request->old_password, $user->password)){
                if ($request->password == $request->confirm_password){
                    $input['password'] = bcrypt($request->password);
                }else{
                    return $this->error('Confirm password does not match.', 401);
                }
            }else{
                return $this->error('Old Password Does Not Match.', 401);
            }
    
            $user->update($input);

            $user->photo = $user->photo == null ? asset('assets/images/admins/profile.png') : asset('assets/images/admins/'.$user->photo);
            
            return $this->success([
                'worker' => $user,
            ]);

        }
        return $this->error('Invalid Access', 401);
    }
}
