<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Traits\ApiResponser;
use App\City;
use App\State;
use App\Country;
use App\User_referrals;
use App\Referral_programs;
use Carbon\Carbon;
use Mail;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    use ApiResponser;
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|numeric|digits:10|unique:users',
            'city' => 'required',
            'password' => 'required|min:5',
            'confirm_password' => 'required|min:5|same:password',
            'latitude' => 'required',
            'longitude' => 'required',
            'ipaddress' => 'required',
            'fcm_token' => 'required',
        ]);
        if ($validator->fails())
        {
            // return response([
            //     'success' => 0,
            //     'errors'=>$validator->errors()->first()
            // ], 422);
            return $this->error($validator->errors()->first(), 401);
        }
        $city = City::where('id',$request->city)->first();
        $state = State::where('id',$city->state_id)->first();
        $country = Country::where('id',$state->country_id)->first();

        $referral_code = $request->referral_code;

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password =  Hash::make($request->password);
        $user->latitude = $request->latitude;
        $user->longitude = $request->longitude;
        $user->ipaddress = $request->ipaddress;
        $user->fcm_token = $request->fcm_token;
        $user->city = $request->city;
        $user->state = $state->id;
        $user->country = $country->id;
        
        $Referral_programs = Referral_programs::where(['status' => 1])->first();
        if(!empty($referral_code) && !empty($Referral_programs)){
            $user_detail = user::where(['referral_id' => $referral_code])->first();
            if(!empty($user_detail)){
                
                $user_referral = User_referrals::where(['user_id'=>$user_detail->id,'phone'=>$request->phone])->first();
                if(!empty($user_referral)){
                    $user_referral->is_referred = 1;
                    $user_referral->save();
                }else{
                    $user_referral= new User_referrals;
                    $user_referral->user_id = $user_detail->id;
                    $user_referral->phone = $user->phone;
                    $user_referral->is_referred = 1;
                    $user_referral->save();
                }

                $max_value = $Referral_programs->max_value;
                $referral_value = $Referral_programs->referral_value;

                $amount = $user_detail->ref_bal_total + $referral_value;

                if($max_value < $amount){
                    $new_amount = $max_value - $user_detail->ref_bal_total;
                }else{
                    $new_amount = $referral_value;
                }

                $user_detail->ref_bal_total = $user_detail->ref_bal_total + $new_amount;
                $user_detail->ref_bal_remain = $user_detail->ref_bal_remain + $new_amount; 
               
                $user_detail->save();
                
            }else{
                return $this->error('Invalid referral code', 401);
            }
        }

        $user->save();
        
        //$user = User::create(array_merge($request->all(),['password' => Hash::make($request->password),'state' => $state->id,'country' => $country->id]));
       
        return $this->success([
            'token' => $user->createToken('API Token')->plainTextToken
        ]);
        // $token = null;
        // if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        //     $token = $user->createToken('auth_token')->plainTextToken;
        // }

        // return response(['user' => $user, 'access_token' =>$token,'token_type' => 'Bearer']);
    }
    public function login(Request $request)
    {

        $loginData = $request->validate([
            'phone' => 'required',
            'password' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
           'ipaddress' => 'required'
        ]);

        $username_field = 'phone';
        $identifier = request()->get('phone');
        if(filter_var($identifier, FILTER_VALIDATE_EMAIL)){
            $username_field = 'email';
        }

        if(Auth::guard('web')->attempt([$username_field => $request->phone, 'password' => $request->password], false, false)) {
            $token = $request->user()->createToken('auth_token')->plainTextToken;

            $user = User::find(auth()->user()->id);
            $user->fcm_token = $token;
            $user->latitude = $request->latitude;
            $user->longitude = $request->longitude;
            $user->ipaddress = $request->ipaddress;

            $get_user_referral_code = Auth::user()->get_user_referral_code();
            $user->referral_id = $get_user_referral_code;

            $user->save();

            $user->photo = $user->photo == null ? asset('assets/images/profile.png') : asset('assets/images/users/'.$user->photo);
            return $this->success([
                'user' => $user, 'access_token' =>$token,'token_type' => 'Bearer'
            ]);
        } else {
            return $this->error('Invalid Credentials', 401);
        }

    }

    public function forgot_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }  

        $check_email = User::where(['email' => $request->email])->first();

        $credentials = $request->all();

        if(!empty($check_email)){

            Password::sendResetLink($credentials);
            return $this->success([
                "message" => 'We have emailed your password reset link!',
            ]);
        }
        return $this->error("Sorry, We can't find a user with that email address.", 401);

    }

    public function login2(Request $request)
    {

        return response()->json(['error'=>Auth::user()]);
       // print_R(Auth:user());
    }

    public function signup_city()
    {
        $all_cities = City::where(['status' => 1])->select('id','name')->get();

        if($all_cities->count() > 0){
            return $this->success([
                "cities" => $all_cities
            ]);
        }else{
            return $this->error('No city found', 401);
        }
        
    }
}
