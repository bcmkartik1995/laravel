<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Franchise;
use App\Service;
use App\Country;
use App\State;
use App\City;
use App\Franchise_work_cities;
use Auth;

class FranchiseprofileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::guard('admin')->user()->id;
        $franchises_id = Franchise::where('user_id',$user_id)->pluck('id');

        $franchise = Franchise::where('id',$franchises_id)->first();

        $countries = Country::all();
        $states = State::where('country_id',$franchise->country_id)->get();
        $cities = City::where('status',1)->select('id','name')->get();
        // echo '<pre>';
        // print_R($franchise);die;
        $services = Service::where(['status' => 1])->select('id','title')->get();
        $franchise_work_cities = [];
        if(!empty($franchise->franchise_work_cities)){
            foreach($franchise->franchise_work_cities as $city){
                $franchise_work_cities[] = $city->city_id;
            }
        }

        $franchise_services = [];
        if(!empty($franchise->franchise_services)){
            foreach($franchise->franchise_services as $service){
                $franchise_services[] = $service->service_id;
            }
        }
        return view('admin.franchise_profile.edit',compact('franchise','countries','cities','states','services','franchise_services','franchise_work_cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        // echo '<pre>';
        // print_R($request->all());die;
        // echo '<pre>';
        // print_R($id);die;
        $request->validate([
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
            'hour'=>'required|string|numeric',
            'minute'=>'required|numeric',
            'working_cities'=>'required',
        ]);

        $franchise = Franchise::find($id);

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
                $delete_cities = Franchise_work_cities::whereIn('city_id', $deletable)->where('franchise_id',$id);
                $delete_cities->delete();
            }
        }

        return redirect()->back()->with('update_message','Data Updated Successfully');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }
}
