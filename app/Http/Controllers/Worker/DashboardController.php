<?php

namespace App\Http\Controllers\Worker;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use InvalidArgumentException;
use Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Blog;
use App\Models\Product;
use App\Models\Counter;
use App\Models\Role;
use App\Models\Admin;
use App\Service;
use App\Franchise;
use App\Franchises_order;
use App\Franchise_worker;
use App\Franchise_plans;
use App\Franchise_services;
use App\User;
use App\Orders;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function __construct() {
        $this->middleware('auth:worker');
    }

    public function index() {
        return view('worker.dashboard');
    }

    public function profile() {
        $data = Auth::guard('worker')->user();
        return view('worker.profile',compact('data'));
    }

    public function profileupdate(Request $request) {
        //--- Validation Section
        $request->validate([
            'photo' => 'mimes:jpeg,jpg,png,svg',
            'email' => 'unique:franchise_workers,email,'.Auth::guard('worker')->user()->id,
            'mobile' => 'unique:franchise_workers,mobile,'.Auth::guard('worker')->user()->id
        ]);

        //check if file attached
        if($file = $request->file('avatar')){

            $image = $request->file('avatar');
            $newImageName = time().'.'.$image->extension();
            $image->move(public_path('/assets/images/admins'),$newImageName);
        }
        $user = Auth::guard('worker')->user();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->mobile = $request->input('mobile');
        if(isset($newImageName) && !empty($newImageName)){
            $user->photo = $newImageName;
        }


        $user->save();

        return redirect()->route('worker.profile')->with('update_message', "The $user->name was updated successfully");

    }

    public function passwordreset()
    {
        $data = Auth::guard('worker')->user();

        return view('worker.change_password.index',compact('data'));
    }

    public function changepass(Request $request)
    {
        $request->validate([
            'old_password'=>'required',
            'password'=>'required|min:6|max:15',
            'confirm_password'=>'required|same:password',
        ]);

        $worker = Auth::guard('worker')->user();

        if($request->old_password){
            if (Hash::check($request->old_password, $worker->password)){
                if ($request->password == $request->confirm_password){
                    $input['password'] = bcrypt($request->password);
                }else{
                    return redirect()->route('worker.password')->with('delete_message','Confirm password does not match.');
                }
            }else{
                return redirect()->back()->with('delete_message','Old Password Does Not Match.');
            }
        }

        $worker->update($input);

        return redirect()->route('worker.password')->with('Insert_Message','Password Change Successfully');
    }







}
