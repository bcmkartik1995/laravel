<?php

namespace App\Http\Controllers\Admin;

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

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $service_count = Service::where('status','=','1')->count();
        $franchise_count = Franchise::where('status','=','1')->count();
        $user_count = User::count();
        $order_count = Orders::where('status','=','completed')->count();

        $user = Auth::guard('admin')->user();

        if($user->role_id != 0){
            $role = Role::where('id',$user->role_id)->select('name')->first();
            

            if($role->name == 'franchises'){
                $franchise = Franchise::where('user_id',$user->id)->first();

                $franchise_order = Franchises_order::where('franchises_id',$franchise->id)->count();
                $franchise_worker = Franchise_worker::where('franchises_id',$franchise->id)->count();
                
                $franchise_plan = Franchise_plans::where('franchise_id',$franchise->id)->whereRaw('(end_date >= CURDATE() OR is_custom = 1)')->select(DB::raw('sum(remain_credits) as remain_credits_count'))->first();

                $franchise_service = Franchise_services::where('franchise_id',$franchise->id)->count();

                return view('admin.dashboard',compact('franchise_order','franchise_worker','franchise_plan','franchise_service'));
            }
        }
        

        return view('admin.dashboard',compact('service_count','franchise_count','user_count','order_count'));
    }

    public function profile()
    {
        $data = Auth::guard('admin')->user();
        return view('admin.profile',compact('data'));
    }

    public function profileupdate(Request $request)
    {
        //--- Validation Section
        $request->validate([
            'photo' => 'mimes:jpeg,jpg,png,svg',
            'email' => 'unique:admins,email,'.Auth::guard('admin')->user()->id
        ]);

        //check if file attached
        if($file = $request->file('avatar')){

            $image = $request->file('avatar');
            $newImageName = time().'.'.$image->extension();
            $image->move(public_path('/assets/images/admins'),$newImageName);
        }
        $user = Auth::guard('admin')->user();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('mobile');
        $user->photo = $newImageName;
        
        $user->save();

        return redirect()->route('admin.profile')->with('update_message', "The $user->name was updated successfully");

        // $rules =
        // [
        //     'photo' => 'mimes:jpeg,jpg,png,svg',
        //     'email' => 'unique:admins,email,'.Auth::guard('admin')->user()->id
        // ];


        // $validator = Validator::make(Input::all(), $rules);

        // if ($validator->fails()) {
        //   return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        // }
        // //--- Validation Section Ends
        // $input = $request->all();
        // $data = Auth::guard('admin')->user();
        //     if ($file = $request->file('photo'))
        //     {
        //         $name = time().$file->getClientOriginalName();
        //         $file->move('assets/images/admins/',$name);
        //         if($data->photo != null)
        //         {
        //             if (file_exists(public_path().'/assets/images/admins/'.$data->photo)) {
        //                 unlink(public_path().'/assets/images/admins/'.$data->photo);
        //             }
        //         }
        //     $input['photo'] = $name;
        //     }
        // $data->update($input);
        // $msg = 'Successfully updated your profile';
        // return response()->json($msg);
    }

    public function passwordreset()
    {
        $data = Auth::guard('admin')->user();
    
        return view('admin.change_password.index',compact('data'));
    }

    public function changepass(Request $request)
    {
        $request->validate([
            'old_password'=>'required',
            'password'=>'required|min:6|max:15',
            'confirm_password'=>'required|same:password',
        ]);

        $admin = Auth::guard('admin')->user();

        if($request->old_password){
            if (Hash::check($request->old_password, $admin->password)){
                if ($request->password == $request->confirm_password){
                    $input['password'] = bcrypt($request->password);
                }else{
                    return redirect()->route('admin.password')->with('delete_message','Confirm password does not match.');
                }
            }else{
                return redirect()->back()->with('delete_message','Old Password Does Not Match.');
            }
        }

        $admin->update($input);

        return redirect()->route('admin.password')->with('Insert_Message','Password Change Successfully');
    }



    public function generate_bkup()
    {
        $bkuplink = "";
        $chk = file_get_contents('backup.txt');
        if ($chk != ""){
            $bkuplink = url($chk);
        }
        return view('admin.movetoserver',compact('bkuplink','chk'));
    }


    public function clear_bkup()
    {
        $destination  = public_path().'/install';
        $bkuplink = "";
        $chk = file_get_contents('backup.txt');
        if ($chk != ""){
            unlink(public_path($chk));
        }

        if (is_dir($destination)) {
            $this->deleteDir($destination);
        }
        $handle = fopen('backup.txt','w+');
        fwrite($handle,"");
        fclose($handle);
        //return "No Backup File Generated.";
        return redirect()->back()->with('success','Backup file Deleted Successfully!');
    }


    public function activation()
    {

        $activation_data = "";
        if (file_exists(public_path().'/project/license.txt')){
            $license = file_get_contents(public_path().'/project/license.txt');
            if ($license != ""){
                $activation_data = "<i style='color:darkgreen;' class='icofont-check-circled icofont-4x'></i><br><h3 style='color:darkgreen;'>Your System is Activated!</h3><br> Your License Key:  <b>".$license."</b>";
            }
        }
        return view('admin.activation',compact('activation_data'));
    }


    public function activation_submit(Request $request)
    {
        //return config('services.genius.ocean');
        $purchase_code =  $request->pcode;
        $my_script =  'GeniusCart';
        $my_domain = url('/');

        $varUrl = str_replace (' ', '%20', config('services.genius.ocean').'purchase112662activate.php?code='.$purchase_code.'&domain='.$my_domain.'&script='.$my_script);

        if( ini_get('allow_url_fopen') ) {
            $contents = file_get_contents($varUrl);
        }else{
            $ch = curl_init();
            curl_setopt ($ch, CURLOPT_URL, $varUrl);
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
            $contents = curl_exec($ch);
            curl_close($ch);
        }

        $chk = json_decode($contents,true);

        if($chk['status'] != "success")
        {

            $msg = $chk['message'];
            return response()->json($msg);
            //return redirect()->back()->with('unsuccess',$chk['message']);

        }else{
            $this->setUp($chk['p2'],$chk['lData']);

            if (file_exists(public_path().'/rooted.txt')){
                unlink(public_path().'/rooted.txt');
            }

            $fpbt = fopen(public_path().'/project/license.txt', 'w');
            fwrite($fpbt, $purchase_code);
            fclose($fpbt);

            $msg = 'Congratulation!! Your System is successfully Activated.';
            return response()->json($msg);
            //return redirect('admin/dashboard')->with('success','Congratulation!! Your System is successfully Activated.');
        }
        //return config('services.genius.ocean');
    }

    function setUp($mtFile,$goFileData){
        $fpa = fopen(public_path().$mtFile, 'w');
        fwrite($fpa, $goFileData);
        fclose($fpa);
    }

    public function movescript(){
        ini_set('max_execution_time', 3000);

        $destination  = public_path().'/install';
        $chk = file_get_contents('backup.txt');
        if ($chk != ""){
            unlink(public_path($chk));
        }

        if (is_dir($destination)) {
            $this->deleteDir($destination);
        }

        $src = base_path().'/vendor/update';
        $this->recurse_copy($src,$destination);
        $files = public_path();
        $bkupname = 'GeniusCart-By-GeniusOcean-'.date('Y-m-d').'.zip';

        $zipper = new \Chumper\Zipper\Zipper;

        $zipper->make($bkupname)->add($files);

        $zipper->remove($bkupname);

        $zipper->close();

        $handle = fopen('backup.txt','w+');
        fwrite($handle,$bkupname);
        fclose($handle);

        if (is_dir($destination)) {
            $this->deleteDir($destination);
        }
        return response()->json(['status' => 'success','backupfile' => url($bkupname),'filename' => $bkupname],200);
    }

    public function recurse_copy($src,$dst) {
        $dir = opendir($src);
        @mkdir($dst);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    $this->recurse_copy($src . '/' . $file,$dst . '/' . $file);
                }
                else {
                    copy($src . '/' . $file,$dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

    public function deleteDir($dirPath) {
        if (! is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }



}
