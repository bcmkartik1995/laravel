<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Country;
use App\State;
use App\City;

class UserprofileController extends Controller
{
    use ApiResponser;

    public function user_detail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }

        $user_id = $request->user_id;

        $user = User::where('id',$user_id)->first();

        if(!empty($user)) {
            $user->photo = $user->photo == null ? asset('assets/images/profile.png') : asset('assets/images/users/'.$user->photo);
            return $this->success([
                'user' => $user
            ]);
        }else{
            return $this->error('No any user found.', 401);
        }
    }

    public function user_edit_profile(Request $request)
    {
        $user_id = $request->user_id;

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,'.$user_id.',id,deleted_at,NULL',
            'phone' => 'required|numeric|digits:10|unique:users,phone,'.$user_id.',id,deleted_at,NULL',
            'photo' => 'mimes:jpg,png,jpeg|max:2048',
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }

        $user = User::find($user_id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        if(!empty($request->zip)){
            $user->zip = $request->zip;
        }
        if(!empty($request->country_id)){
            $user->country = $request->country_id;
        }
        if(!empty($request->state_id)){
            $user->state = $request->state_id;
        }
        if(!empty($request->city_id)){
            $user->city = $request->city_id;
        }
        if(!empty($request->address)){
            $user->address = $request->address;
        }
        if(!empty($request->photo)){
            $file = $request->file('photo');
            $name = time().rand().'.'.$file->extension();
            $file->move('assets/images/users/',$name);
            if($user->photo != null) {
                if (file_exists(public_path().'/assets/images/users/'.$user->photo)) {
                    unlink(public_path().'/assets/images/users/'.$user->photo);
                }
            }
            $user->photo = $name;
        }

        $user->save();
        $user->photo = $user->photo == null ? asset('assets/images/profile.png') : asset('assets/images/users/'.$user->photo);
        return $this->success([
            'user' => $user,
        ]);
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

    public function user_change_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'=>'required',
            'old_password'=>'required',
            'new_password'=>'required|min:5',
            'confirm_password'=>'required|same:new_password',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }

        $user_id = $request->user_id;
        $user = User::where('id',$user_id)->first();

        if($request->old_password){
            if (Hash::check($request->old_password, $user->password)){
                if ($request->new_password == $request->confirm_password){
                    $user['password'] = Hash::make($request->new_password);
                }else{
                    return $this->error('Confirm password does not match.', 401);
                }
            }else{
                return $this->error('Current password does not match.', 401);
            }
        }

        $user->save();
        $user->photo = $user->photo == null ? asset('assets/images/profile.png') : asset('assets/images/users/'.$user->photo);
        return $this->success([
            'user' => $user,
        ]);
    }
}
