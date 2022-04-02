<?php

namespace App\Http\Controllers\Admin;

use Datatables;
use App\Models\Admin;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;
use App\Lead;
use App\Franchise;
use Illuminate\Support\Facades\Hash;
use Mail;
use App\Models\Role;

class StaffController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    //*** JSON Request
    public function datatables()
    {
        $role_id = Role::where('name','franchises')->pluck('id');
      
        $datas = Admin::where('id','!=',1)->where('role_id','!=',$role_id)->where('id','!=',Auth::guard('admin')->user()->id)->orderBy('id')->get();
         //--- Integrating This Collection Into Datatables
        $collection = collect($datas);

        $user_ids = $collection->pluck('id')->toArray();
        
        $franchises = Franchise::pluck('user_id')->toArray();
        //print_R($franchises);die;
        return Datatables::of($datas)
                            ->addColumn('role', function(Admin $data) {
                                $role = $data->role_id == 0 ? 'No Role' : $data->role->name;
                                return $role;
                            }) 
                            ->addColumn('action', function(Admin $data)use($franchises) {
                                

                                //$delete ='<a href="javascript:;" data-href="' .route('admin-staff-delete',$data->id) . '" class="delete details-width txt-white cusor-pointer btn btn-icon btn-danger glow mr-1 mb-1" data-toggle="modal" data-target="#confirm-delete"> <i class="bx bxs-trash"></i></a>';
                                $delete = '';
                                if($data->role->name == 'franchises' && !in_array($data->id, $franchises)){

                                    return '<a data-href="' . route('admin-staff-show',$data->id) . '" class="view details-width txt-white cusor-pointer btn btn-icon btn-dark glow mr-1 mb-1" data-toggle="modal" data-target="#modal1"> <i class="bx 
                                    bx-show-alt"></i></a><a data-href="' . route('admin-staff-edit',$data->id) . '" class="edit details-width txt-white cusor-pointer btn btn-icon btn-success glow mr-1 mb-1" data-toggle="modal" data-target="#modal1"> <i class="bx bxs-edit-alt"></i></a>'.$delete.'<a href="' . route('user-franchise',$data->id) . '" class="txt-white cusor-pointer btn btn-icon btn-success glow mr-1 mb-1"> Franchises </a>';

                                }else{
                                    return '<a data-href="' . route('admin-staff-show',$data->id) . '" class="view details-width txt-white cusor-pointer btn btn-icon btn-dark glow mr-1 mb-1" data-toggle="modal" data-target="#modal1"> <i class="bx 
                                    bx-show-alt"></i></a><a data-href="' . route('admin-staff-edit',$data->id) . '" class="edit details-width txt-white cusor-pointer btn btn-icon btn-success glow mr-1 mb-1" data-toggle="modal" data-target="#modal1"> <i class="bx bxs-edit-alt"></i></a>'.$delete.'';
                                }
                            }) 
                            ->rawColumns(['action'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }

    //*** GET Request
  	public function index()
    {
        return view('admin.staff.index');
    }

    //*** GET Request
    public function create()
    {
        return view('admin.staff.create');
    }

    //*** POST Request
    public function store(Request $request)
    {
        
        //--- Validation Section
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins,email,NULL,id,deleted_at,NULL'],
            'phone' => ['required', 'numeric', 'digits:10', 'unique:admins,phone'],
            'password' => ['required','min:5'],
            'photo'      => 'mimes:jpeg,jpg,png,svg',
                ];

        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        // Mail::send('', $data, function($message)use($data, $pdf) {
            
        // $message->to($request->email)
        //     ->subject('Send Mail from Laravel')
        //     //->body('hi')
        // });
        
        //--- Logic Section
        $data = new Admin();
        $input = $request->all();
        if ($file = $request->file('photo')) 
         {      
            $name = time().$file->getClientOriginalName();
            $file->move('assets/images/admins',$name);           
            $input['photo'] = $name;
        } 
        $input['role'] = 'Staff';
        $input['password'] = bcrypt($request['password']);
        $data->fill($input)->save();

        $input['password'] = $request['password'];
        $data = $input;
        Mail::send('admin.user.mail.register', $data, function($message)use($data) {            
            $message->to($data['email'])
                ->subject('New Account Created');
        });
        //--- Logic Section Ends

        //--- Redirect Section        
        $msg = 'New Data Added Successfully.';
        return response()->json($msg);      
        //--- Redirect Section Ends 

    }


    public function edit($id)
    {
        $data = Admin::findOrFail($id);  
        return view('admin.staff.edit',compact('data'));
    }

    public function update(Request $request,$id)
    {
        //--- Validation Section
        if($id != Auth::guard('admin')->user()->id)
        {
            $rules =
            [
                'photo' => 'mimes:jpeg,jpg,png,svg',
                'email' => 'unique:admins,email,'.$id.',id,deleted_at,NULL'
            ];

            $validator = Validator::make($request->all(), $rules);
            
            if ($validator->fails()) {
                return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
            }
            //--- Validation Section Ends
            $input = $request->all();  
            $data = Admin::findOrFail($id);        
                if ($file = $request->file('photo')) 
                {              
                    $name = time().$file->getClientOriginalName();
                    $file->move('assets/images/admins/',$name);
                    if($data->photo != null)
                    {
                        if (file_exists(public_path().'/assets/images/admins/'.$data->photo)) {
                            unlink(public_path().'/assets/images/admins/'.$data->photo);
                        }
                    }            
                $input['photo'] = $name;
                } 
            if($request->password == ''){
                $input['password'] = $data->password;
            }
            else{
                $input['password'] = bcrypt($request->password);
            }
            $data->update($input);
            $msg = 'Data Updated Successfully.';
            return response()->json($msg);
        }
        else{
            $msg = 'You can not change your role.';
            return response()->json($msg);            
        }
        
 
    }

    //*** GET Request
    public function show($id)
    {
        $data = Admin::findOrFail($id);
        return view('admin.staff.show',compact('data'));
    }

    //*** GET Request Delete
    public function destroy($id)
    {
    	if($id == 1)
    	{
        return "You don't have access to remove this admin";
    	}
        $data = Admin::findOrFail($id);
        //If Photo Doesn't Exist
        if($data->photo == null){
            $data->delete();
            //--- Redirect Section     
            $msg = 'Data Deleted Successfully.';
            return response()->json($msg);      
            //--- Redirect Section Ends     
        }
        //If Photo Exist
        if (file_exists(public_path().'/assets/images/admins/'.$data->photo)) {
            unlink(public_path().'/assets/images/admins/'.$data->photo);
        }
        $data->delete();
        //--- Redirect Section     
        $msg = 'Data Deleted Successfully.';
        return response()->json($msg);      
        //--- Redirect Section Ends    
    }
}
