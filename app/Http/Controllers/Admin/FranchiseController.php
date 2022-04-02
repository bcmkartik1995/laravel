<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use Spatie\Permission\Models\Role;
use App\Franchise;
use App\Category;
use App\SubCategory;
use App\Country;
use App\State;
use App\Lead;
use App\User;
use App\City;
use App\Models\Role;
use App\Models\Admin;
use App\Franchise_category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Datatables;
use Carbon\Carbon;
use Auth;
use Validator;
use App\Franchise_work_cities;
use App\Franchise_services;
use App\Service;

class FranchiseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function datatables(Request $request)
    {

        // $datas = Orders::orderBy('id','desc');
        // if(isset($request->searchByFromdate) && !empty($request->searchByFromdate)){
        //     $datefrom =Carbon::createFromFormat('d/m/Y', $request->searchByFromdate)->format('Y-m-d');
        //     $datas->where(DB::raw('CAST(created_at as date)'), '>=', $datefrom);

        // }
        // if(isset($request->searchByTodate) && !empty($request->searchByTodate)){
        //     $dateto = Carbon::createFromFormat('d/m/Y', $request->searchByTodate)->format('Y-m-d');
        //     $datas->where(DB::raw('CAST(created_at as date)'), '<=', $dateto);
        // }
        // if(isset($request->searchBystatus) && !empty($request->searchBystatus)){

        //     $datas->where('status',$request->searchBystatus);
        // }
        // $datas = $datas->get();

        // return Datatables::of($datas)
        //     ->addColumn('action', function(Orders $data) {


        //         return '<div class="dropdown"><span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span><div class="dropdown-menu dropdown-menu-right"><a href="javascript:void(0);" data-href="'. route('orders-delete',$data->id). '" class="dropdown-item delete"><i class="bx bx-trash mr-1"></i>Detete</a><a class="dropdown-item" href="'.route('franchises-invoice',$data->id).'"><i class="bx bx-edit-alt mr-1"></i> Invoice Details</a><a class="dropdown-item show-example-btn booking-status" data-status="'.$data->status.'" data-id="'.$data->id.'" om positioned dialog"><i class="bx bx-cog mr-1"></i>Manage Status</a><a class="dropdown-item" href="'.route('orders-details',$data->id).'"><i class="bx bx-list-ul mr-1"></i> view</a></div></div>';
        //     })
        //     ->rawColumns(['action'])
        //     ->toJson();

        $datas = Franchise::with(['country' => function ($query) {
                $query->select('name','id');
            }])
            ->with(['state' => function ($query) {
                $query->select('name','id');
            }])
            ->with(['city' => function ($query) {
                $query->select('name','id');
            }])
            ->with(['user' => function ($query) {
                $query->select('name','id','email','phone');
            }])


            ->select('franchises.id','country_id','state_id','city_id','address_1','user_id','address_2','longitude','latitude','pincode','franchise_name','email','mobile','commission','status','created_at','updated_at','hour','minute');

            if(isset($request->searchByTocategory) && !empty($request->searchByTocategory)){

                $datas->leftjoin("franchise_categories AS fc",function($join){
                    $join->on('franchises.id', '=', 'fc.franchises_id');
                });
                $datas->where('fc.category_id',$request->searchByTocategory);
            }
            if(isset($request->searchBycity) && !empty($request->searchBycity)){
                $datas->where('city_id',$request->searchBycity);
            }

        $datas = $datas->orderBy('franchises.id','DESC')->groupBy('franchises.id')->get();

        return Datatables::of($datas)
            ->addColumn('action', function(Franchise $data) {

                $html = '<div style="display:flex;">';
                if(Auth::guard('admin')->user()->sectionCheck('franchises_edit') || Auth::guard('admin')->user()->role_id == 0){
                    $html .= '<a href="'.route('franchise-edit',$data->id).'" class="btn btn-warning btn-sm mr-25">Edit</a>';
                }
                if(Auth::guard('admin')->user()->sectionCheck('franchises_delete') || Auth::guard('admin')->user()->role_id == 0){
                    //$html .= '<a href="javascript:void(0);" data-href="'.route('franchise-delete',$data->id).'" class="btn btn-danger btn-sm mr-25 delete">Detete</a>';
                }
                if(Auth::guard('admin')->user()->sectionCheck('franchises_status') || Auth::guard('admin')->user()->role_id == 0){
                    $html .= '<a href="javascript:void(0);" data-id="'.$data->id.'" data-action="franchise" class="toggle-button btn btn-'.($data->status==1?'danger':'success').' btn-sm"> '.($data->status==1?'In Active':'Active').'</a>';
                }
                $html .= '</div>';
                return $html;
            })
            ->addColumn('commission', function(Franchise $data) {
                return $data->commission .'%';
            })
            ->addColumn('status', function(Franchise $data) {
                return '<span class="badge badge-pill badge-light-info status-span-'.$data->id.'">'.($data->status==1 ? 'Active': 'In Active').'</span>';
            })
            ->addColumn('more_info', function(Franchise $data) {
                return '<a href="#" class="" data-toggle="modal" data-target="#franchise-'.$data->id.'">
                More Information...
            </a>
            <div class="modal fade" id="franchise-'.$data->id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">More Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h4 class="card-title">Owner Info</h4>
                        <table>
                            <tr>
                                <th style="border: none;">User Name</th>
                                <td>:</td>
                                <td>'.$data->user->name.'</td>
                            </tr>
                            <tr>
                                <th>Email :</th>
                                <td>:</td>
                                <td>'.$data->user->email.'</td>
                            </tr>
                            <tr>
                                <th>Mobile</th>
                                <td>:</td>
                                <td>'.$data->user->phone.'</td>
                            </tr>
                        </table>

                        <h4 class="card-title pt-2">Franchise Info</h4>
                        <table>
                            <tr>
                                <th style="border: none;">Name</th>
                                <td>:</td>
                                <td>'.$data->franchise_name.'</td>
                            </tr>
                            <tr>
                                <th>Email :</th>
                                <td>:</td>
                                <td>'.$data->email.'</td>
                            </tr>
                            <tr>
                                <th>Mobile</th>
                                <td>:</td>
                                <td>'.$data->mobile.'</td>
                            </tr>
                            <tr>
                                <th>Time</th>
                                <td>:</td>
                                <td>'.$data->hour.' hour '.$data->minute.' minute</td>
                            </tr>
                        </table>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                    </div>
                </div>
            </div>';
            })
            ->rawColumns(['action','commission', 'more_info','status'])
            ->toJson();

    }
    public function create(Request $request)
    {
        $services = Service::where(['status' => 1])->select('id','title')->get();
        $user_id = $request->id;
        $countries = Country::all();
        $franchise = Franchise::where('user_id',$user_id)->first();

        $cities = City::where(['status' => 1])->select(['id','name'])->get();

        $user_email = Admin::where('id',$request->id)->pluck('email')->first();

        $lead = Lead::where('email','=',$user_email)->select('country_id','state_id','city_id','email','phone')->first();
        // echo '<pre>';
        // print_R($lead);die;
        return view('admin.Franchise.create',compact('countries','user_id','franchise','services','cities','lead'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'country_id'=>'required',
            'state_id'=>'required',
            'city_id'=>'required',
            'service_id'=>'required',
            'user_id'=>'required',
            'address_1'=>'required',
            'longitude'=>'required',
            'latitude'=>'required',
            'pincode'=>'required',
            'franchise_name'=>'required',
            'email'=>'required | email',
            'mobile'=>'required | numeric | digits:10',
            'commission'=>'required',
            'hour'=>'required|numeric',
            'minute'=>'required|numeric',
            'working_cities'=>'required',
        ]);

        $franchise = new Franchise;
        $franchise->country_id = $request->input('country_id');
        $franchise->state_id = $request->input('state_id');
        $franchise->city_id = $request->input('city_id');
        $franchise->hour = $request->input('hour');
        $franchise->minute = $request->input('minute');
        $franchise->user_id = $request->input('user_id');
        $franchise->address_1 =$request->input('address_1');
        $franchise->address_2 = $request->input('address_2');
        $franchise->longitude = $request->input('longitude');
        $franchise->latitude = $request->input('latitude');
        $franchise->pincode = $request->input('pincode');
        $franchise->franchise_name = $request->input('franchise_name');
        $franchise->email = $request->input('email');
        $franchise->mobile = $request->input('mobile');
        $franchise->commission = $request->input('commission');
        $franchise->area_lat1 = $request->input('area_lat1');
        $franchise->area_lng1 = $request->input('area_lng1');
        $franchise->area_lat2 = $request->input('area_lat2');
        $franchise->area_lng2 = $request->input('area_lng2');


        $franchise->save();

        $franchises_id = $franchise->id;

        if(!empty($request->service_id)){
            $data = [];
            foreach($request->service_id as $service_id){
                $data[] = [
                    'service_id'=>$service_id,
                    'franchise_id'=>$franchises_id
                ];
            }
            Franchise_services::insert($data);
        }

        if(!empty($request->working_cities)){
            $data = [];
            foreach($request->working_cities as $city_id){
                $data[] = [
                    'city_id'=>$city_id,
                    'franchise_id'=>$franchises_id
                ];
            }
            Franchise_work_cities::insert($data);
        }

        return redirect()->route('franchise-view')->with('Insert_Message','Data Created Successfully');
    }

    public function index()
    {
        $franchises = Franchise::with(['country' => function ($query) {
            $query->select('name','id');
        }])
        ->with(['state' => function ($query) {
            $query->select('name','id');
        }])
        ->with(['city' => function ($query) {
            $query->select('name','id');
        }])
        ->with(['user' => function ($query) {
            $query->select('name','id');
        }])
        ->select('id','country_id','state_id','city_id','address_1','user_id','address_2','longitude','latitude','pincode','franchise_name','email','mobile','commission','status','created_at','updated_at','hour','minute')
        ->get();

        $cities = City::where(['status' => 1])->select('name','id')->get();

        $categories = Category::where(['status' => 1])->select('title','id')->get();

        return view('admin.Franchise.index',compact('franchises','cities','categories'));
    }

    public function edit($id)
    {
        $franchise = Franchise::findOrFail($id);
        $countries = Country::all();
        $services = Service::where(['status' => 1])->select('id','title')->get();
       // $franchise_cat = Franchise_category::where('franchises_id',$id)->pluck('category_id')->toArray();
        $subcategory = SubCategory::where('category_id', $franchise->category_id)->get();
        $states = State::where('country_id',$franchise->country_id)->get();
        $cities = City::where('status',1)->select('id','name')->get();

        $franchise_work_cities = [];
        if(!empty($franchise->franchise_work_cities)){
            foreach($franchise->franchise_work_cities as $city){
                $franchise_work_cities[] = $city->city_id;
            }
        }

        $franchise_services = [];
        if(!empty($franchise->franchise_services)){
            foreach($franchise->franchise_services as $service){
                $franchise_services[] = $service->service_id;
            }
        }
        //print_R($franchise_work_cities);die;
        return view('admin.Franchise.edit', compact('franchise','countries','states','cities','services','subcategory','franchise_services','franchise_work_cities'));
    }


    public function update(Request $request, $id)
    {

        $request->validate([
            'country_id'=>'required',
            'state_id'=>'required',
            'city_id'=>'required',
            'service_id'=>'required',
            'user_id'=>'required',
            'address_1'=>'required',
            'longitude'=>'required',
            'latitude'=>'required',
            'pincode'=>'required',
            'franchise_name'=>'required',
            'email'=>'required | email',
            'mobile'=>'required | numeric | digits:10',
            'commission'=>'required',
            'hour'=>'required|string|numeric',
            'minute'=>'required|numeric',
            'working_cities'=>'required',
        ]);

        $franchise = Franchise::find($id);
        $franchise->country_id = $request->input('country_id');
        $franchise->state_id = $request->input('state_id');
        $franchise->city_id = $request->input('city_id');
        $franchise->hour = $request->input('hour');
        $franchise->minute = $request->input('minute');
        $franchise->user_id = $request->input('user_id');
        $franchise->address_1 =$request->input('address_1');
        $franchise->address_2 = $request->input('address_2');
        $franchise->longitude = $request->input('longitude');
        $franchise->latitude = $request->input('latitude');
        $franchise->pincode = $request->input('pincode');
        $franchise->franchise_name = $request->input('franchise_name');
        $franchise->email = $request->input('email');
        $franchise->mobile = $request->input('mobile');
        $franchise->commission = $request->input('commission');
        $franchise->area_lat1 = $request->input('area_lat1');
        $franchise->area_lng1 = $request->input('area_lng1');
        $franchise->area_lat2 = $request->input('area_lat2');
        $franchise->area_lng2 = $request->input('area_lng2');

        $franchise->save();

        $franchises_id = $franchise->id;

        if(!empty($request->service_id)){

            $franchise_services = [];
            if(!empty($franchise->franchise_services)){
                foreach($franchise->franchise_services as $service){
                    $franchise_services[] = $service->service_id;
                }
            }

            $data = [];
            foreach($request->service_id as $service_id){
                if(!in_array($service_id, $franchise_services)){
                    $data[] = [
                        'service_id' => $service_id,
                        'franchise_id' => $franchises_id
                    ];
                }
            }

            if(!empty($data)){
                Franchise_services::insert($data);
            }

            $deletable = array_diff($franchise_services, $request->service_id);
            if(!empty($deletable)){
                $delete_franchise_cat = Franchise_services::whereIn('service_id', $deletable)->where('franchise_id',$id);
                $delete_franchise_cat->delete();
            }
        }

        if(!empty($request->working_cities)){

            $franchise_work_cities = [];
            if(!empty($franchise->franchise_work_cities)){
                foreach($franchise->franchise_work_cities as $city){
                    $franchise_work_cities[] = $city->city_id;
                }
            }

            $data = [];
            foreach($request->working_cities as $city_id){
                if(!in_array($city_id, $franchise_work_cities)){
                    $data[] = [
                        'city_id' => $city_id,
                        'franchise_id' => $franchises_id
                    ];
                }
            }

            if(!empty($data)){
                Franchise_work_cities::insert($data);
            }

            $deletable = array_diff($franchise_work_cities, $request->working_cities);
            if(!empty($deletable)){
                $delete_cities = Franchise_work_cities::whereIn('city_id', $deletable)->where('franchise_id',$id);
                $delete_cities->delete();
            }
        }

        return redirect()->route('franchise-view')->with('update_message','Data Updated Successfully');
    }

    public function delete($id)
    {
        $franchise = Franchise::find($id);
        $franchise->payments()->delete();
        $franchise->user()->delete();
        $franchise->franchise_worker()->delete();
        $franchise->delete();
        //Franchise_category::where('franchises_id',$id)->delete();

        return response()->json(['success' => 1, 'message' => 'Data Deleted successfully']);
    }

    public function franchise_user()
    {
        $role_id = Role::where('name','franchises')->pluck('id');

        $franchise_users = Admin::where('role_id',$role_id)
        ->leftjoin("franchises",function($join){
            $join->on('franchises.user_id', '=', 'admins.id');
        })
        ->select('admins.*', 'franchises.id as franchiseID')
        ->get();

        return view('admin.franchise_user.index',compact('franchise_users'));
    }

    public function franchise_user_edit($id)
    {
        $franchise_user = Admin::findOrFail($id);

        return view('admin.franchise_user.edit', compact('franchise_user'));
    }

    public function franchise_user_update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'photo' => 'mimes:jpeg,jpg,png,svg',
            'email' => 'unique:admins,email,'.$id.',id,deleted_at,NULL'
        ]);

        // $rules =
        // [
        //     'name' => 'required',
        //     'photo' => 'mimes:jpeg,jpg,png,svg',
        //     'email' => 'unique:admins,email,'.$id.',id,deleted_at,NULL'
        // ];

        // $validator = Validator::make($request->all(), $rules);

        // if ($validator->fails()) {
        //     return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        // }
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
        return redirect()->route('franchise-user-view')->with('update_message','Data Updated Successfully');

    }


    public function franchise_user_delete($id)
    {
        $franchise_user = Admin::find($id);
        Franchise::where('user_id',$id)->delete();
        $franchise_user->delete();
        return response()->json(['success' => 1, 'message' => 'Data Deleted successfully']);
    }
}
