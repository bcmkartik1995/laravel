<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Franchise_worker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Mail;

class AuthController extends Controller
{
    use ApiResponser;

    public function login(Request $request){

        $loginData = $request->validate([
            'email'   => 'required|email',
            'password' => 'required|min:6',
            'login_type' => 'required'
        ]);

        $login_type = $request->login_type;
        if(!in_array($login_type, ['franchise', 'worker'])){
            return $this->error('Invalid Access', 401);
        }

        $guard = $login_type;
        if($login_type == 'franchise'){
            $guard = 'admin';
        }
        if (Auth::guard($guard)->attempt(['email' => $request->email, 'password' => $request->password])) {

            if($guard == 'admin'){
                $user = Admin::find(Auth::guard($guard)->user()->id);
            }else{
                $user = Franchise_worker::find(Auth::guard($guard)->user()->id);

                $user->phone = $user->mobile;
            }

            $user->photo = $user->photo == null ? asset('assets/images/admins/profile.png') : asset('assets/images/admins/'.$user->photo);
            
            $user->login_type = $login_type;
            return $this->success([
                'user' => $user
            ]);
        }else{
            return $this->error('Invalid Credentials', 401);
        }
    }

    public function forgot_password(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'login_type' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }

        $login_type = $request->login_type;
        if(!in_array($login_type, ['franchise', 'worker'])){
            return $this->error('Invalid Access', 401);
        }

        $guard = $login_type;
        if($login_type == 'franchise'){
            $guard = 'admin';
        }

        if($guard == 'admin'){
            $check_email = Admin::where(['email' => $request->email])->first();
        }else{
            $check_email = Franchise_worker::where(['email' => $request->email])->first();
        }

        if(!empty($check_email)){

            $token = Str::random(64);
            DB::table('password_resets')->insert(
                ['email' => $request->email, 'token' => $token, 'created_at' => Carbon::now()]
            );

            if($guard == 'admin'){
                $mail = Mail::send('admin.resetlink', ['token' => $token], function($message) use($request){
                    $message->to($request->email);
                    $message->subject('Reset Password Notification');
                });
            }else{
                $mail = Mail::send('worker.resetlink', ['token' => $token], function($message) use($request){
                    $message->to($request->email);
                    $message->subject('Reset Password Notification');
                });
            }
            return $this->success([
                "message" => 'We have emailed your password reset link!',
            ]);
        }
        return $this->error("Sorry, We can't find a user with that email address.", 401);

    }
}
