<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class FranchiseuserController extends Controller
{
    use ApiResponser;
    
    public function franchise_user_profile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }
        
        $user_id = $request->user_id;
        $user = Admin::find($user_id);    

        if(!empty($user)){
            $user->photo = $user->photo == null ? asset('assets/images/admins/profile.png') : asset('assets/images/admins/'.$user->photo);
            return $this->success([
                'user' => $user
            ]);
        }else{
            return $this->error('User not found', 401);
        }
    }

    public function franchise_user_profile_edit(Request $request)
    {
        $user_id = $request->user_id;

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'name' => 'required|max:255',
            'email' => 'required|email|unique:admins,email,'.$user_id.',id,deleted_at,NULL',
            'phone' => 'required|numeric|digits:10|unique:admins,phone,'.$user_id.',id,deleted_at,NULL',
            'photo' => 'mimes:jpg,png,jpeg|max:2048',
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }

        $user = Admin::find($user_id);

        if($user){
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;

            if(!empty($request->photo)){
                $image = $request->file('photo');
                $imagename = rand().time().'.'.$image->extension();
                $image->move(public_path('assets/images/admins'),$imagename);
                $user->photo = $imagename;
            }
            $user->save();

            $user->photo = $user->photo == null ? asset('assets/images/admins/profile.png') : asset('assets/images/admins/'.$user->photo);

            return $this->success([
                'user' => $user
            ]);

        }else{
            return $this->error('User not found', 401);
        }
    }

    public function change_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'old_password'=>'required',
            'password'=>'required|min:6|max:15',
            'confirm_password'=>'required|same:password',
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }

        $user_id = $request->user_id;
        $user = Admin::find($user_id);
        
        if($user){
            
            if(Hash::check($request->old_password, $user->password)){
                if ($request->password == $request->confirm_password){
                    $input['password'] = bcrypt($request->password);
                }else{
                    return $this->error('Confirm password does not match.', 401);
                }
            }else{
                return $this->error('Old Password Does Not Match.', 401);
            }
    
            $user->update($input);

            $user->photo = $user->photo == null ? asset('assets/images/admins/profile.png') : asset('assets/images/admins/'.$user->photo);
            
            return $this->success([
                'user' => $user
            ]);

        }else{
            return $this->error('User not found', 401);
        }

    }
}
