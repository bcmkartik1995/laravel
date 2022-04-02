<?php

namespace App\Http\Controllers\Front;

use App\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\UserLoginLog;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Session;
use App\My_cart;
use App\City;
use App\State;
use App\Country;


use Illuminate\Foundation\Auth\AuthenticatesUsers;


class UsersController extends Controller
{

    public function __construct() {
        //$this->middleware(['role:admin|creator']);
        //$this->middleware(['role:user']);
    }


    public function index()
    {
        $user = Auth::user();
        return view('users.dashboard',compact('user'));
    }
    public function indexLoginLogs()
    {
        $userLoginActivities = UserLoginLog::paginate(10);

        return view('admin.activity.logs', compact('userLoginActivities'));
    }


    public function store(Request $request)
    {
        // $validator = \Validator::make($request->all(), [
        //     'name' => 'required|string',
        //     'email' => 'required|string|email|max:255|unique:users',
        //     'mobile' => 'required|numeric|digits:10|unique:users',
        //     'password' => 'required|min:5',
        //     'confirm_password' => 'required|min:5|same:password',
        // ]);

        $rules = [
            'name' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|numeric|digits:10|unique:users',
            'city' => 'required',
            'password' => 'required|min:5',
            'confirm_password' => 'required|min:5|same:password',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->first()));
        }
        
        // echo '<pre>';
        // print_R($request->city);die;
        $city = City::where('id',$request->city)->first();
        $state = State::where('id',$city->state_id)->first();
        $country = Country::where('id',$state->country_id)->first();

        $user = User::create(array_merge($request->all(),['password' => Hash::make($request->password),'state' => $state->id,'country' => $country->id]));

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {
            // if successful, then redirect to their intended location
            // Login as User
            return response()->json(route('user-dashboard'));
        }

    }

    public function verify_mobile(Request $request)
    {
        $rules = [
            'phone'=>'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) 
        {
            return response()->json(['error' => $validator->errors()]);
        }
        else
        {
            $get_data = User::where('phone',$request->phone)->first();
            if($get_data)
            {
                return response()->json(array('success' => [ 1 => 'User Registered' ]));
            }
            else
            {
                return response()->json(array('error' => [ 0 => 'User not registered' ]));
            }
        }
    }

    public function send_otp(Request $request)
    {
        $rules = [
            'phone'=>'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) 
        {
            return response()->json(['error' => $validator->errors()]);
        }
        else
        {
            $uname = "8401805775";
            $smspwd = "1234@4321";
            $strSenderId = "VELOXD";
            $mobile = "+91".$request->phone;
            $phone = $request->phone;
            $otp = mt_rand(1000,9999); 
            $otp = $request->otp; 
            $msg = "Dear User, ".$otp." is the One Time Password (OTP) for login in with The Velox Doorstep Services Pvt Ltd. DO NOT SHARE OTP WITH ANYONE. Regards VELOX";
            try
            {
                //http Url to send sms.
                $url="http://tsms.vishawebsolutions.com/smsstatuswithid.aspx";
                $fields = array(
                'mobile' => $uname,
                'pass' => $smspwd,
                'senderid' => $strSenderId,
                'to' => $mobile,
                'msg' => urlencode($msg)
                );
                //url-ify the data for the POST
                $fields_string = "";
                foreach($fields as $key=>$value) 
                { 
                    $fields_string .= $key.'='.$value.'&'; 
                }
                rtrim($fields_string, '&');
                //open connection
                $ch = curl_init();
                //set the url, number of POST vars, POST data
                curl_setopt($ch,CURLOPT_URL, $url);
                curl_setopt($ch,CURLOPT_POST, count($fields));
                curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
                //execute post
                $result = curl_exec($ch);
                //close connection
                curl_close($ch);
                return response()->json(array('success' => [ 1 => 'OTP Sent Successfully', 'otp' => $otp, 'phone' => $phone]));
            }
            catch(Exception $e)
            {
                return response()->json(array('error' => [ 0 => 'Please Try Again...!' ]));
            }
        }
    }

    public function login(Request $request)
    {
        $rules = [
            'phone'   => 'required',
            'password' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $username_field = 'phone';
        $identifier = request()->get('phone');
        if(filter_var($identifier, FILTER_VALIDATE_EMAIL)){
            $username_field = 'email';
        }

        if (Auth::guard('web')->attempt([$username_field => $request->phone, 'password' => $request->password, 'deleted_at' => NULL])) {
            
            if(Session::has('my_cart') && !empty(Session::get('my_cart'))){
                $id = Auth::user()->id;
                $My_cart = My_cart::where('user_id', $id)->first();
                if ($My_cart) {
                    $my_cart_data = Session::get('my_cart');
                    $My_cart->cart_data = $my_cart_data;
                    $My_cart->save();
                } else {

                    $my_cart_data = Session::get('my_cart');
                    $My_cart = new My_cart;
                    $My_cart->user_id = $id;
                    $My_cart->cart_data = $my_cart_data;
                    $My_cart->save();
                }
            }

            // if successful, then redirect to their intended location
            if(session()->has('user.url.intended')){
                    $url = session()->get('user.url.intended');
                    session()->put('user.url.intended','');
                }else{
                    if(url()->previous() == route('front.index')){
                        $url = route('user-dashboard');
                    }else{
                        $url = url()->previous();
                    }

                }
                return response()->json($url);
        }
        return response()->json(array('error' => [ 0 => 'Credentials Doesn\'t Match !' ]));
    }

    public function userOtpLogin(Request $request)
    {
        $userId = User::where('phone',$request->otp_phone)->first();
        Auth::loginUsingId($userId->id);
        
        $id = Auth::user()->id;
        $My_cart = My_cart::where('user_id', $id)->first();
        if ($My_cart) 
        {
            $my_cart_data = Session::get('my_cart');
            $My_cart->cart_data = $my_cart_data;
            $My_cart->save();
        } 
        else 
        {
            $my_cart_data = Session::get('my_cart');
            $My_cart = new My_cart;
            $My_cart->user_id = $id;
            $My_cart->cart_data = $my_cart_data;
            $My_cart->save();
        }

        // if successful, then redirect to their intended location
        if(session()->has('user.url.intended'))
        {
            $url = session()->get('user.url.intended');
            session()->put('user.url.intended','');
        }
        else
        {
            if(url()->previous() == route('front.index'))
            {
                $url = route('user-dashboard');
            }
            else
            {
                $url = url()->previous();
            }
        }
        return redirect($url);
    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {

    }


    public function destroy($id)
    {

    }


    public function massDestroy(Request $request)
    {

    }

}
