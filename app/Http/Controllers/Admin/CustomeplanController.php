<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Credit_plans;
use App\Credit_price;
use App\Franchise;
use App\Franchise_plans;
use Carbon\Carbon;

class CustomeplanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $credit_price = Credit_price::first();
        $credit_plans = Credit_plans::where(['status' => 1])->get();

        $franchises = Franchise::where(['status'=>1])->get();

        return view('admin.credit_plans.custome_plan',compact('credit_price','credit_plans','franchises'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // echo '<pre>';
        // print_R($request->all());die;
        if($request->is_custom == 1){

            $request->validate([
                'franchise_id' => 'required',
                'price' => 'required',
                'credit' => 'required|gt:0',
                'amount' => 'required|gt:0',
            ]);

        }else{
            $request->validate([
                'franchise_id' => 'required',
                'plan_id' => 'required',
            ]);
        }
        
        
        $franchise_plans = new Franchise_plans;
        
        if($request->is_custom == 1){
            $franchise_plans->price = $request->input('price');
            $franchise_plans->qty = $request->input('credit');
            $franchise_plans->amount = $request->input('amount');
            $franchise_plans->total_credits = $request->input('credit');
            $franchise_plans->remain_credits = $request->input('credit');
            $franchise_plans->franchise_id = $request->input('franchise_id');
        }else{
            $Credit_plan = Credit_plans::where('id',$request->plan_id)->first();
            $franchise_plans->plan_id = $request->input('plan_id');
            $franchise_plans->franchise_id = $request->input('franchise_id');
            $franchise_plans->price = $Credit_plan->price;
            
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

            $franchise_plans->start_date = $start_date;
            $franchise_plans->end_date = $end_date;

            $franchise_plans->price = $Credit_plan->price;
            $franchise_plans->amount = $Credit_plan->price;
            $franchise_plans->total_credits = $Credit_plan->credit_value;
            $franchise_plans->remain_credits = $Credit_plan->credit_value;
            $franchise_plans->qty = 1;
        }

        $franchise_plans->save();

        return redirect('admin/custome-plan')->with('Insert_Message','Data Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
