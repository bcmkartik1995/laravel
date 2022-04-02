<?php

namespace App\Http\Controllers\Worker;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Franchise_worker;

class ResetPasswordController extends Controller
{
    public function getPassword($token) {
        return view('worker.passwordreset', ['token' => $token]);
    }

    public function updatePassword(Request $request) {

        $request->validate([
            'email' => 'required|email|exists:franchise_workers',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',

        ]);

        $updatePassword = DB::table('password_resets')
                            ->where(['email' => $request->email, 'token' => $request->token])
                            ->first();

        if(!$updatePassword){
            return back()->withInput()->with('error', 'Invalid token!');
        }

        $password = bcrypt($request->password);

        $user = Franchise_worker::where('email', $request->email)->update(['password' => $password]);

        DB::table('password_resets')->where(['email'=> $request->email])->delete();

        return redirect('worker/login')->with('Insert_Message', 'Your password has been changed!');

    }

}
