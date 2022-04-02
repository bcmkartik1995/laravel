<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;
use App\My_cart;
use App\User;
use App\User_address;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class AddressController extends Controller
{
    use ApiResponser;

    public function user_addresses(Request $request) {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }

        $user_id = $request->user_id;
        $User_address = User_address::where('user_id', $user_id)->orderBy('id','desc')->get();
        if ($User_address->count()) {
            return $this->success([
                'user_addresses' => $User_address
            ]);
        }else{
            return $this->success([
                'user_addresses' => $User_address,
                'message' => 'No any saved address found.'
            ]);
        }
    }

    public function add_address(Request $request) {
        $rules = [
            'user_id' => 'required',
            'flat_building_no' => 'required',
            'address' => 'required',
            'name' => 'required',
            'type' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'zip' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'phone' => ['required', 'numeric', 'digits:10']
        ];
        $messages = [
            'user_id.required' => 'Please enter user id',
            'flat_building_no.required' => "Please enter flat/building number",
            'address.required' => "Please enter address",
            'name.required' => "Please enter name",
            'type.required' => 'Please enter address type.',
            'country.required' => 'Please enter country.',
            'state.required' => 'Please enter state.',
            'city.required' => 'Please enter city.',
            'zip.required' => 'Please enter zip.',
            'latitude.required' => 'Please enter latitude.',
            'longitude.required' => 'Please enter longitude.',
            'phone.required' => 'Please enter mobile number',
            'phone.numeric' => 'Mobile number must be a number.',
            'phone.digits' => 'Mobile number must be 10 digits.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }

        $user_id = $request->user_id;
        $address = new User_address;
        $address->user_id = $user_id;
        $address->flat_building_no = $request->flat_building_no;
        $address->name = $request->name;
        $address->phone = $request->phone;
        $address->address = $request->address;
        $address->type = $request->type;
        $address->country = $request->country;
        $address->state = $request->state;
        $address->city = $request->city;
        $address->zip = $request->zip;
        $address->latitude = $request->latitude;
        $address->longitude = $request->longitude;

        $address->save();

        return $this->success([
            'Success' => 'Address saved successfully.'
        ]);
    }

    public function edit_address(Request $request) {

        $rules = [
            'user_id' => 'required',
            'address_id' => "required",
            'flat_building_no' => 'required',
            'address' => 'required',
            'name' => 'required',
            'type' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'zip' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'phone' => ['required', 'numeric', 'digits:10']
        ];
        $messages = [
            'user_id.required' => 'Please enter user id',
            'address_id.required' => 'Please enter address id',
            'flat_building_no.required' => "Please enter flat/building number",
            'address.required' => "Please enter address",
            'name.required' => "Please enter name",
            'type.required' => 'Please enter address type.',
            'country.required' => 'Please enter country.',
            'state.required' => 'Please enter state.',
            'city.required' => 'Please enter city.',
            'zip.required' => 'Please enter zip.',
            'latitude.required' => 'Please enter latitude.',
            'longitude.required' => 'Please enter longitude.',
            'phone.required' => 'Please enter mobile number',
            'phone.numeric' => 'Mobile number must be a number.',
            'phone.digits' => 'Mobile number must be 10 digits.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }

        $address_id = $request->address_id;
        $user_id = $request->user_id;
        $address = User_address::where(['id' => $address_id, 'user_id' => $user_id])->first();
        if($address){

            $address->flat_building_no = $request->flat_building_no;
            $address->name = $request->name;
            $address->phone = $request->phone;
            $address->address = $request->address;
            $address->type = $request->type;
            $address->country = $request->country;
            $address->state = $request->state;
            $address->city = $request->city;
            $address->zip = $request->zip;
            $address->latitude = $request->latitude;
            $address->longitude = $request->longitude;

            $address->save();

            return $this->success([
                'Success' => 'Address saved successfully.'
            ]);
        }else{
            return $this->error('Please enter valid address id.', 401);
        }
    }

    public function delete_address(Request $request) {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'address_id' => "required",
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }

        $user_id = $request->user_id;
        $address_id = $request->address_id;
        $address = User_address::where(['id' => $address_id, 'user_id' => $user_id])->first();
        if($address){
            $address->delete();
            return $this->success([
                'Success' => "Address deleted successfully."
            ]);
        }else{
            return $this->error('Please enter valid address id.', 401);
        }
    }

    public function get_timeslots(Request $request) {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }
        $day_array = [];
        for ($i = 0; $i < 3; $i++) {
            $start = Carbon::now();
            // $start = Carbon::parse('2021-10-07 11:29:00');
            $date = $start->addDay($i);

            if($date->format('i') > 30){
                $date = $date->addMinute(60-$date->format('i'));
            }else{
                $date = $date->addMinute(30-$date->format('i'));
            }
            // echo '<pre>';
            // print_R($date);
            if ($i == 0) {
                $start_hour = $date->addHour(1)->format('H:i');
            } else {
                $start_hour = '08:00';
            }
            // echo '<pre>';
            // print_R($start_hour);die;
            $period = new CarbonPeriod($start_hour, '30 minutes', '20:00'); // for create use 24 hours format later change format
            $slots = [];
            foreach ($period as $item) {
                array_push($slots, $item->format("h:i A"));
            }

            if ($i == 0) {
                $day_name = 'Today';
            } elseif ($i == 1) {
                $day_name = 'Tomorrow';
            } else {
                $day_name = $date->format('D');
            }
            $day_array[] = [
                'id'=>$i+1,
                'date' => $date->format('Y-m-d'),
                'slots' => $slots,
                'day_name' => $day_name,
                'day' => $date->format('d'),
            ];
        }

        $user_id = $request->user_id;
        $My_cart = My_cart::where('user_id', $user_id)->first();
        $isCODAvailable = true;
        if(!empty($My_cart->cart_data)){
            $final_total = isset($My_cart->cart_data['final_total']) ? $My_cart->cart_data['final_total'] : 0;
            if($final_total >= 500){
                $isCODAvailable = false;
            }
        }

        $payment_methods = [
            ['title' => 'Pay with Razorpay', 'value' => 'Razorpay'],
            ['title' => 'Pay online after service', 'value' => 'Pay Online After Service']
        ];
        if($isCODAvailable === true){
            $payment_methods[] = ['title' => 'Cash On Delivery', 'value' => 'Cash On Delivery'];
        }

        return $this->success([
            'day_array' => $day_array,
            'payment_methods' => $payment_methods
        ]);
    }

}
