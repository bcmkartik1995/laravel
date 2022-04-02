<?php

namespace App\Http\Controllers\Admin;

use App\Classes\GeniusMailer;
use App\Models\Generalsetting;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Input;
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Mail;

class LoginController extends Controller
{
    public function __construct()
    {
      $this->middleware('guest:admin', ['except' => ['logout']]);
    }

    public function showLoginForm()
    {
      return view('admin.login');
    }

    public function verify_admin_mobile(Request $request)
    {
        $rules = [
            'email'=>'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) 
        {
            return response()->json(['error' => $validator->errors()]);
        }
        else
        {
            $get_data = Admin::where('email',$request->email)->first();
            if($get_data)
            {
                return response()->json(array('success' => [ 1 => 'User Registered', 'data'=>$get_data ]));
            }
            else
            {
                return response()->json(array('error' => [ 0 => 'User not registered' ]));
            }
        }
    }

    public function send_admin_otp(Request $request)
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
        // Validation Section
        $rules = [
          'email'   => 'required|email'
        ];

        $validator = Validator::make($request->all(), $rules);
          
        if ($validator->fails()) 
        {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
          // Validation Section Ends

        // Attempt to log the user in
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password, 'deleted_at' => NULL], $request->remember)) {
          // if successful, then redirect to their intended location
          return response()->json(route('admin.dashboard'));
        }

        // if unsuccessful, then redirect back to the login with the form data
        return response()->json(array('errors' => [ 0 => 'Credentials Doesn\'t Match !' ]));     
    }

    public function adminOtpLogin(Request $request)
    {
        $get_data = Admin::where('email',$request->email)->first();
        Auth::guard('admin')->login($get_data);
        Auth::loginUsingId($get_data->id);
        return response()->json(route('admin.dashboard'));
    }
    
    public function showForgotForm()
    {
      return view('admin.forgot');
    }

    public function forgot(Request $request)
    {
      
      $request->validate([
        'email' => 'required|email|exists:admins',
      ]);

      $token = Str::random(64);

      DB::table('password_resets')->insert(
          ['email' => $request->email, 'token' => $token, 'created_at' => Carbon::now()]
      );

      $mail = Mail::send('admin.resetlink', ['token' => $token], function($message) use($request){
          $message->to($request->email);
          $message->subject('Reset Password Notification');
      });

      return response()->json('We have send mail your password reset link!');
      //return back()->with('Insert_Message', 'We have e-mailed your password reset link!');

      // $gs = Generalsetting::findOrFail(1);
      // $input =  $request->all();
      // if (Admin::where('email', '=', $request->email)->count() > 0) {
      // // user found
      // $admin = Admin::where('email', '=', $request->email)->firstOrFail();
      // $autopass = str_random(8);
      // $input['password'] = bcrypt($autopass);
      // $admin->update($input);
      // $subject = "Reset Password Request";
      // $msg = "Your New Password is : ".$autopass;
      // if($gs->is_smtp == 1)
      // {
      //     $data = [
      //             'to' => $request->email,
      //             'subject' => $subject,
      //             'body' => $msg,
      //     ];

      //     $mailer = new GeniusMailer();
      //     $mailer->sendCustomMail($data);                
      // }
      // else
      // {
      //     $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
      //     mail($request->email,$subject,$msg,$headers);            
      // }
      // return response()->json('Your Password Reseted Successfully. Please Check your email for new Password.');
      // }
      // else{
      // // user not found
      // return response()->json(array('errors' => [ 0 => 'No Account Found With This Email.' ]));    
      // }  
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }
}
