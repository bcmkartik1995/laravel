<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
// use Validator;
// use Auth;
// use Session;

class LoginController extends Controller
{
    public function __construct()
    {
       // $this->middleware('guest', ['except' => ['logout', 'userLogout']]);
    }


    public function login(Request $request)
    {

        //--- Validation Section
        $rules = [
                  'email'   => 'required|email',
                  'password' => 'required'
                ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
        {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

      // Attempt to log the user in
      if (Auth::attempt(['email' => $request->email, 'password' => $request->password]))
      {
        // if successful, then redirect to their intended location


          // Login as User
          if(session()->has('url.intended')){
            $url = session()->get('url.intended');
            session()->forget('url.intended');
          }else{
            $url = route('user-dashboard');
          }
          return response()->json($url);
      }

      // if unsuccessful, then redirect back to the login with the form data
          return response()->json(array('errors' => [ 0 => 'Credentials Doesn\'t Match !' ]));
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect('/');
    }

}
