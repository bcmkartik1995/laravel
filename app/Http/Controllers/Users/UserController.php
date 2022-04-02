<?php

namespace App\Http\Controllers\Users;

use App\Classes\GeniusMailer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Input;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Orders;
use App\User;
// use Illuminate\Contracts\Session\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        // $ongoing_orders = Orders::where(['user_id' => $user->id])->whereIn('status', ['pending','processing','on delivery'])->get();
        // $order_history = Orders::where(['user_id' => $user->id])->whereIn('status', ['completed','declined'])->get();

        $user = Auth::user();

        $total_orders = Orders::where(['user_id' => $user->id])->count();
        $pending_orders = Orders::where(['user_id' => $user->id, 'status' => 'pending'])->count();
        return view('users.dashboard',compact('user', 'total_orders','pending_orders'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('user.profile',compact('user'));
    }

    public function profileupdate(Request $request)
    {
        //--- Validation Section

        $rules =
        [
            'photo' => 'mimes:jpeg,jpg,png,svg',
            'email' => 'unique:users,email,'.Auth::user()->id
        ];


        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends
        $input = $request->all();
        $data = Auth::user();
            if ($file = $request->file('photo'))
            {
                $name = time().$file->getClientOriginalName();
                $file->move('assets/images/users/',$name);
                if($data->photo != null)
                {
                    if (file_exists(public_path().'/assets/images/users/'.$data->photo)) {
                        unlink(public_path().'/assets/images/users/'.$data->photo);
                    }
                }
            $input['photo'] = $name;
            }
        $data->update($input);
        $msg = 'Successfully updated your profile';
        return response()->json($msg);
    }

    public function resetform()
    {
        return view('users.reset');
    }

    public function reset(Request $request)
    {
        $request->validate([
            'cpass' => ['required'],
            'newpass' => ['required','min:5'],
            'renewpass' => ['required','same:newpass']
        ], [
            'cpass.required' => 'Please enter your current password',
            'newpass.required' => 'Please enter your new password',
            'renewpass.required' => 'Please enter your confirm password',
            'newpass.min' => 'Password must be at least 5 characters.',
            'renewpass.same' => 'New password and confirm password must match.'
        ]);
        $user = Auth::user();
        if ($request->cpass){
            if (Hash::check($request->cpass, $user->password)){
                if ($request->newpass == $request->renewpass){
                    $user['password'] = Hash::make($request->newpass);
                }else{
                    return redirect()->route('resetform')->with('error', "Confirm password does not match.");
                }
            }else{
                return redirect()->route('resetform')->with('error', "Current password does not match.");
            }
        }
        $user->save();
        return redirect()->route('resetform')->with('success', "Your password has been changed successfully.");
    }

    public function logout()
    {
        Session::put('my_cart',[]);
        Session::forget('my_cart');
        Auth::guard('web')->logout();
        return redirect('/');
    }

    public function user_profile_edit(Request $request){
        $id = Auth::user()->id;
        $user = User::findOrFail($id);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required','string', 'email', 'max:255', Rule::unique('users')->ignore($id)],
            'phone' => ['required', 'numeric', 'digits:10', 'unique:users,phone,'.$id.',id,deleted_at,NULL'],
        ]);

        $ip = $request->ip();
        $loc_data = \Location::get($ip);

//         echo '<pre>';
// print_R($request->all());die;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->country = $request->input('country');
        $user->state = $request->input('state');
        $user->city = $request->input('city');
        $user->zip = $request->input('zip');
        $user->address = $request->input('address');

        if ($file = $request->file('photo')) {
            $name = time().rand().$file->getClientOriginalName();
            $file->move('assets/images/users/',$name);
            if($user->photo != null) {
                if (file_exists(public_path().'/assets/images/users/'.$user->photo)) {
                    unlink(public_path().'/assets/images/users/'.$user->photo);
                }
            }
            $user->photo = $name;
        }
        $user->save();
        return redirect()->route('user-profile')->with('success', "Profile has been updated successfully");
    }





}
