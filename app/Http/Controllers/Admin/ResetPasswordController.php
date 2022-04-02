<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;

class ResetPasswordController extends Controller
{
    public function getPassword($token) 
    { 
        return view('admin.passwordreset', ['token' => $token]);
    }

    public function updatePassword(Request $request)
    {
        
        $request->validate([
            'email' => 'required|email|exists:admins',
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
        
        $user = Admin::where('email', $request->email)->update(['password' => $password]);

        DB::table('password_resets')->where(['email'=> $request->email])->delete();
        
        return redirect('admin/login')->with('Insert_Message', 'Your password has been changed!');

    }
    
}
