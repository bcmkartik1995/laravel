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
use App\Franchise_plans;
use App\Credit_price;
use App\Credit_plans;

class FranchiseCreditController extends Controller
{
    use ApiResponser;

    public function franchise_credit(Request $request)
    {
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

                $franchise_credits = Franchise_plans::where(['franchise_id' => $franchise_id])
                ->with(['plan' => function ($query) {
                    $query->select('id','title');
                        
                }])->get();
                
                if($franchise_credits->count() > 0){
                    return $this->success([
                        'franchise_credits' => $franchise_credits
                    ]);
                }else{
                    return $this->error('Franchise credits not found', 401);
                }
                
            }else{
                return $this->error('Franchise not found', 401);
            }
        }
        return $this->error('Invalid Access', 401);
    }

   
    public function credit_plan(Request $request)
    {
        $Credit_price = Credit_price::first();

        $Credit_plans = Credit_plans::where(['status' => 1])->get()->map(function($query){
                    
            if(!empty($query->image)) {
                $query->image = asset('assets/images/creditplanbanner/'.$query->image);
            }
            return $query;
        });
        
        return $this->success([
            'credit_price' => $Credit_price,
            'credit_plans' => $Credit_plans
        ]);
    }

    public function credit_plan_custome(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'price' => 'required',
            'quantity' => 'required',
            'amount' => 'required',
            'razorpay_id' => 'required',
            'is_custome' => 'required'
        ]);
        
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }

        $user_id = $request->user_id;
        $price = $request->price;
        $quantity = $request->quantity;
        $amount = $request->amount;
        $razorpay_id = $request->razorpay_id;
        $is_custome = $request->is_custome;

        $user = Admin::find($user_id);
        if($user){
            $franchise = Franchise::where(['user_id' => $user_id])->first();

            if($franchise){
                $franchise_id = $franchise->id;

                if($is_custome == true){
                    $franchise_plan = new Franchise_plans;                
                    $franchise_plan->franchise_id = $franchise_id;
                    $franchise_plan->plan_id = 0;
                    $franchise_plan->price = $price;
                    $franchise_plan->qty = $quantity;
                    $franchise_plan->amount = $amount;
                    $franchise_plan->total_credits = $quantity;
                    $franchise_plan->remain_credits = $quantity;
                    $franchise_plan->is_custom = 1;
                    $franchise_plan->razorpay_id = $razorpay_id;

                    $franchise_plan->save();
                    
                    return $this->success([
                        'franchise_plan' => $franchise_plan
                    ]);
                }else{
                    return $this->error('Invalid Access', 401);
                }
                
            }else{
                return $this->error('Franchise not found', 401);
            }
        }
        return $this->error('Invalid Access', 401);
    }

    public function credit_plan_purchase(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'plan_id' => 'required',
            'razorpay_id' => 'required',
        ]);
        
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }

        $user_id = $request->user_id;
        $plan_id = $request->plan_id;
        $razorpay_id = $request->razorpay_id;

        $user = Admin::find($user_id);
        if($user){
            $franchise = Franchise::where(['user_id' => $user_id])->first();

            if($franchise){
                $franchise_id = $franchise->id;

                $Franchise_plans = new Franchise_plans;
                $Franchise_plans->franchise_id = $franchise->id;
                $Franchise_plans->razorpay_id = $razorpay_id;

                $Credit_plan = Credit_plans::where(['id' => $plan_id, 'status' => 1])->first();
                $validity_types = [1 => 'Day', 2 => 'Week', 3 => 'months', 4 => 'Year'];
                $duration = $validity_types[$Credit_plan->validity_type];
                $period = new CarbonPeriod('2021-06-06', $Credit_plan->validity_value.' '.$duration);

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

               
                $Franchise_plans->save();
                
                return $this->success([
                    'franchise_plan' => $Franchise_plans
                ]);
                
            }else{
                return $this->error('Franchise not found', 401);
            }
        }
        return $this->error('Invalid Access', 401);
    }
}
