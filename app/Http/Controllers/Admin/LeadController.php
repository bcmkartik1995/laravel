<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Lead;
use App\Country;
use App\State;
use App\City;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Validator;
use App\Models\Admin;
use App\Models\Role;
use Mail;
use Auth;
use Datatables;
use Illuminate\Support\Str;

class LeadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    public function datatables(Request $request)
    {
        $datas = Lead::with(['country' => function ($query) {
            $query->select('name','id');
        }])
        ->with(['state' => function ($query) {
            $query->select('name','id');
        }])
        ->with(['city' => function ($query) {
            $query->select('name','id');
        }])
        ->select('id','country_id','state_id','city_id','name','email','skill','phone','status');
        
   
        // if(isset($request->searchBycity) && !empty($request->searchBycity)){
        //     $datas->where('city_id',$request->searchBycity);
        // }

        if(isset($request->searchByToskill) && !empty($request->searchByToskill)){
            $datas->where('id',$request->searchByToskill);
        }
        if(isset($request->searchBycity) && !empty($request->searchBycity)){
            $datas->where('city_id',$request->searchBycity);
        }

        $role_id = Role::where('name','franchises')->pluck('id');
        
        $user = Admin::where('role_id',$role_id)->pluck('email')->toArray();
        
        $datas = $datas->orderBy('id','DESC')->get();

        return Datatables::of($datas)
        
            ->addColumn('status', function(Lead $data) {
                if($data->status == 0){
                    return '<span class="span-'. $data->id .'"><span class="badge badge-pill badge-light-info">Pending</span></span>';
                }
                if($data->status == 1){
                    return '<span class="span-'. $data->id .'"><span class="badge badge-pill badge-light-success" id="span">Accept</span></span>';
                }
                if($data->status == 2){
                    return '<span class="span-'. $data->id .'"><span class="badge badge-pill badge-light-danger" id="span">Decline</span></span>';
                }
                
            }) 
            ->addColumn('action', function(Lead $data)use($user) {

                $html = '<div style="display:flex;">';
                if(Auth::guard('admin')->user()->sectionCheck('leads_delete') || Auth::guard('admin')->user()->role_id == 0){
                    //$html .= '<a href="javascript:void(0);" data-href="'.route('lead.destroy',$data->id).'" class="btn btn-danger btn-sm mr-25 delete">Detete</a>';
                    $html .= '';
                }
                if(Auth::guard('admin')->user()->sectionCheck('leads_edit') || Auth::guard('admin')->user()->role_id == 0){
                    $html .= '<a href="'.route('lead.edit',$data->id).'" class="btn btn-warning btn-sm mr-25">Edit</a>';
                }
                if(Auth::guard('admin')->user()->sectionCheck('leads_status') || Auth::guard('admin')->user()->role_id == 0){
                    $html .= '<button class="btn btn-secondary btn-sm show-example-btn status manage-status d-inline mr-25" data-id="'. $data->id .'" aria-label="Try me! Example: A custom positioned dialog">Manage Status</button>';
                }
                if(Auth::guard('admin')->user()->sectionCheck('leads_add_user') || Auth::guard('admin')->user()->role_id == 0){
                    if($data->status == '1' && !in_array($data->email, $user))
                    {
                        $html .= '<a href="javascript:void(0);" class="btn btn-success btn-sm mr-25 add-to-franchises" data-id="'.$data->id.'">Add To Franchises</a>';
                    }
                }
                $html .= '</div>';
                return $html;

            })
            ->rawColumns(['status','action'])
            ->toJson();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Lead::with(['country' => function ($query) {
            $query->select('name','id');
        }])
        ->with(['state' => function ($query) {
            $query->select('name','id');
        }])
        ->with(['city' => function ($query) {
            $query->select('name','id');
        }])
        ->select('id','country_id','state_id','city_id','name','email','skill','phone','status')
        ->get();

        $role_id = Role::where('name','franchises')->pluck('id');
        
        $user = Admin::where('role_id',$role_id)->pluck('email')->toArray();

        $cities = City::where(['status' => 1])->select('name','id')->get();

        $skills = Lead::select('skill','id')->groupBy('skill')->get();

     
        // $data = DB::table('leads as l')
        // ->join('countries as c', 'l.country_id', '=', 'c.id')
        // ->join('states as s', 'l.state_id', '=', 's.id')
        // ->join('cities as ct', 'l.city_id', '=', 'ct.id')
        // ->select('l.id','l.country_id','l.state_id','l.city_id','l.name','l.email','l.skill','l.phone','l.status','c.name as country_name','s.name as state_name','ct.name as city_name')
        // ->get();

        return view('admin.Lead.index',compact('data','cities','user','skills'));
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();
        return view('admin.Lead.create',compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'country_id'=>'required',
            'state_id'=>'required',
            'city_id'=>'required',
            'name' => 'required',
            'email' => 'required|email|unique:leads|unique:admins,email',
            'skill' => 'required',
            'mobile' => 'required|numeric|digits:10|unique:leads,phone|unique:admins,phone',
        ]);

        $lead = new Lead;
        $lead->country_id = $request->input('country_id');
        $lead->state_id = $request->input('state_id');
        $lead->city_id = $request->input('city_id');
        $lead->name = $request->input('name');
        $lead->email = $request->input('email');
        $lead->skill = $request->input('skill');
        $lead->phone = $request->input('mobile');

        $lead->save();
        return redirect('admin/lead')->with('Insert_Message','Data Created Successfully');


    }

    public function add_to_franchise(Request $request)
    {
        
        $lead = Lead::where('id',$request->id)->first();

        $data = [
            'phone' => $lead->phone,
            'email' => $lead->email
        ];

        $rules = [
            'phone' => ['required', 'numeric', 'digits:10', 'unique:admins,phone,NULL,id,deleted_at,NULL'],
            'email' => ['required', 'email', 'string', 'unique:admins,email,NULL,id,deleted_at,NULL'],

        ];
        $messages = [
            'phone.required' => 'Mobile Number Not Found',
            'email.required' => 'Email Address Not Found',
            'email.unique' => 'This Email Address Has Already Been Taken',
            'phone.unique' => 'This Mobile Number Has Already Been Taken',
        ];

        $validator = Validator::make($data, $rules, $messages);
        if($validator->fails()) {
            return response()->json(['success' => 0, 'errors' => $validator->errors()->first()]);
        }

        
        $user = new Admin;

        $user->name = $lead->name;
        $user->email = $lead->email;
        $user->phone = $lead->phone;
        $role_id = Role::where('name','=','franchises')->select('id')->first();

        $user->role_id = $role_id->id;
        $password = Str::random(8);
        $encripted_password = bcrypt($password);
        $user->password = $encripted_password;

        $user->save();

        // echo '<pre>';
        // print_R($user);die;
        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $password
        ];

        Mail::send('admin.user.mail.register', $data, function($message)use($data) {            
            $message->to($data['email'])
                ->subject('New Account Created');
        });

        return response()->json(['success' => 1, 'redirect' => route('user-franchise', $user->id), 'message' => 'Franchise User Account Created Successfully.']);

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $leads = Lead::findOrFail($id);
        $countries = Country::all();
        $states = State::where('country_id',$leads->country_id)->get();
        $cities = City::where('state_id',$leads->state_id)->get();
        // echo '<pre>';
        // print_R($cities);die;
        return view('admin.Lead.edit', compact('leads','countries','states','cities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'country_id'=>'required',
            'state_id'=>'required',
            'city_id'=>'required',
            'name' => 'required',
            'email' => 'sometimes|required|email|unique:leads,email,'.$id.',id,deleted_at,NULL',
            'skill' => 'required',
            'mobile' => 'sometimes|required|numeric|digits:10|unique:leads,phone,'.$id.',id,deleted_at,NULL',
        ]);

        $lead = Lead::find($id);
        $lead->country_id = $request->input('country_id');
        $lead->state_id = $request->input('state_id');
        $lead->city_id = $request->input('city_id');
        $lead->name = $request->input('name');
        $lead->email = $request->input('email');
        $lead->skill = $request->input('skill');
        $lead->phone = $request->input('mobile');

        $lead->save();
        return redirect('admin/lead')->with('update_message','Data Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $leads = Lead::find($id);
        $leads->delete();
        return response()->json(['success' => 1, 'message' => 'Data Deleted successfully']);
    }
}
