<?php

namespace App\Http\Controllers\Worker;

use App\Classes\GeniusMailer;
use App\Models\Generalsetting;
use App\Franchise_worker;
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
    public function __construct() {

      $this->middleware('guest:worker', ['except' => ['logout']]);
    }

    public function showLoginForm() {
      return view('worker.login');
    }

    public function login(Request $request) {
        //--- Validation Section
        $rules = [
            'email'   => 'required|email',
            'password' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        // Attempt to log the user in
        if (Auth::guard('worker')->attempt(['email' => $request->email, 'password' => $request->password, 'deleted_at' => NULL], $request->remember)) {
            // if successful, then redirect to their intended location
            return response()->json(route('worker.dashboard'));
        }

        // if unsuccessful, then redirect back to the login with the form data
        return response()->json(array('errors' => [ 0 => 'Credentials Doesn\'t Match !' ]));
    }

    public function showForgotForm() {
      return view('worker.forgot');
    }

    public function forgot(Request $request) {

      $request->validate([
        'email' => 'required|email|exists:franchise_workers',
      ]);

      $token = Str::random(64);

      DB::table('password_resets')->insert(
          ['email' => $request->email, 'token' => $token, 'created_at' => Carbon::now()]
      );

      $mail = Mail::send('worker.resetlink', ['token' => $token], function($message) use($request){
          $message->to($request->email);
          $message->subject('Reset Password Notification');
      });

      return response()->json('We have send mail your password reset link!');

    }

    public function logout() {
        Auth::guard('worker')->logout();
        return redirect('/worker/login');
    }
}
