<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\SubCategory;
use App\Service;
use App\Offer;
use App\Offer_user;
use App\User;
use Illuminate\Support\Facades\DB;

class OfferController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$offers = DB::table('offers')->get();
        $offers = Offer::with(['owner' => function ($query) {
            $query->select('franchise_name','id');
        }])
        ->select('id','title','offer_type','offer_value','franchises_id','offer_code','start_date','end_date','status')
        ->get();

        return view('admin.Offer.index',compact('offers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where(['status'=>1])->get();
        $users = User::select('id','name')->get();
        return view('admin.Offer.create',compact('categories','users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validations = [
            'title' => 'required',
            'description' => 'required',
            'offer_code' => 'required | unique:offers',
            'offer_type' => 'required',
            'offer_value' => 'required|numeric',
            'max_value' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'banner' => 'required|mimes:jpg,png,jpeg|dimensions:max_width=300,max_height=200|dimensions:min_width=300,min_height=200|max:2048',
        ];

        $messages = [
            'banner.dimensions' => 'Image resolution must be 300*200',
            'max' => 'Max file size allowed : 2MB'
        ];

        if($request->is_global != 1)
        {
            $validations['category_id'] = 'required';
        }
        
        $request->validate($validations, $messages);

        $offers = new Offer;
        if($request->category_id || $request->sub_category_id || $request->service_id)
        {
            $offers->category_id = $request->input('category_id');
            $offers->sub_category_id = $request->input('sub_category_id');
            $offers->service_id = $request->input('service_id');
        }
        
        $offers->title = $request->input('title');
        $offers->description = $request->input('description');
        $offers->offer_code = strtoupper($request->input('offer_code'));
        $offers->is_global = $request->input('is_global');
        $offers->is_user_specific = $request->input('is_user_specific');
        $offers->offer_type = $request->input('offer_type');
        $offers->offer_value = $request->input('offer_value');
        $offers->max_value = $request->input('max_value');
        $offers->start_date = $request->input('start_date');
        $offers->end_date = $request->input('end_date');

        $banner = $request->file('banner');
        $bannername = time().'.'.$banner->extension();
        $banner->move(public_path('assets/images/offerbanner'),$bannername);
        $offers->banner = $bannername;

        $offers->save();

        if($request->user_specific)
        {
            $user_specific = $request->user_specific;
            $offer_id = $offers->id;

            $data = [];
            foreach($user_specific as $user_id) {
                $data[] = [
                    'user_id' => $user_id,
                    'offer_id' => $offer_id
                ];
                
            }
            Offer_user::insert($data);
        }
        
        return redirect('admin/offer')->with('Insert_Message','Data Created Successfully');

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
        $offers = Offer::findOrFail($id);
        $categories = Category::all();
        $subcategory = SubCategory::where('category_id', $offers->category_id)->get();
        $services = Service::where('sub_category_id', $offers->sub_category_id)->get();

        $users = User::select('id','name')->get();
        $users_existing = DB::table('offer_users as o')
        ->join('users as u', 'o.user_id', '=', 'u.id')
        ->where('offer_id',$id)
        ->pluck('o.user_id','o.id')->toArray();


        // echo '<pre>';
        // print_R($users_existing);die;
        //$users = User::select('id','name')->get();
       
        return view('admin.Offer.edit',compact('offers','categories','subcategory','users','services','users_existing'));
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

        $validations = [
            'title' => 'required',
            'description' => 'required',
            'offer_code' => 'required | unique:offers,offer_code,'.$id,
            'offer_type' => 'required',
            'offer_value' => 'required|numeric',
            'max_value' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'banner' => 'mimes:jpg,png,jpeg|dimensions:max_width=300,max_height=200|dimensions:min_width=300,min_height=200|max:2048',
        ];

        $messages = [
            'banner.dimensions' => 'Image resolution must be 300*200',
            'max' => 'Max file size allowed : 2MB'
        ];

        if($request->is_global != 1)
        {
            $validations['category_id'] = 'required';
        }
        
        $request->validate($validations, $messages);
        
        $validations = [
            
        ];
        if($request->is_global != 1)
        {
            $validations['category_id'] = 'required';
        }
       
        $request->validate($validations);

        $offers = Offer::find($id);
        if($request->category_id || $request->sub_category_id || $request->service_id)
        {
            $offers->category_id = $request->input('category_id');
            $offers->sub_category_id = $request->input('sub_category_id');
            $offers->service_id = $request->input('service_id');
        }
        
        $offers->title = $request->input('title');
        $offers->description = $request->input('description');
        $offers->offer_code = strtoupper($request->input('offer_code'));
        $offers->is_global = $request->input('is_global');
        $offers->is_user_specific = $request->input('is_user_specific');
        $offers->offer_type = $request->input('offer_type');
        $offers->offer_value = $request->input('offer_value');
        $offers->max_value = $request->input('max_value');
        $offers->start_date = $request->input('start_date');
        $offers->end_date = $request->input('end_date');

        if($request->banner != ''){
            
            $banner = $request->file('banner');
            $bannername = time().'.'.$banner->extension();
            $banner->move(public_path('assets/images/offerbanner'),$bannername);
            $offers->banner = $bannername;
        }

        $offers->save();

        if(!empty($request->user_specific)){
            $offer_user = Offer_user::where('offer_id',$id)->pluck('user_id')->toArray();
            $users_id = $request->user_specific;
            $offer_id = $offers->id;
            
            $data = [];
            foreach($users_id as $user_id) {
                if(!in_array($user_id, $offer_user)){    
                    echo   $user_id;         
                    $data[] = [
                        'user_id' => $user_id,
                        'offer_id' => $offer_id
                    ];
                }
            }
            $deletable = array_diff($offer_user, $users_id);
            if(!empty($data)){
                Offer_user::insert($data);
            }
            if(!empty($deletable)){
                $delete_offer_user = Offer_user::whereIn('user_id', $deletable)->where('offer_id',$id);
                $delete_offer_user->delete();
            }
        }

        // $offer_id = $offers->id;
        // $existing_ids = [];
        // $offer_user = Offer_user::where('offer_id',$offer_id)->pluck('user_id')->toArray();

        // $user_specific = $request->user_specific;

        // $insertable  = array_diff($user_specific,$offer_user);
        // // echo '<pre>';
        // // print_R($insertable);
        // if($request->user_specific)
        // {
        //     if(!empty($insertable)){
        //         $data = [];
        //         foreach($user_specific as $user_id) {
        //             $data[] = [
        //                 'user_id' => $user_id,
        //                 'offer_id' => $offer_id
        //             ];
                    
        //         }               
        //         Offer_user::insert($data);
        //     }
        // }

        // $deletable  = array_diff($offer_user,$user_specific);
        
        // if(!empty($deletable))
        // {
        //     $offer_users = DB::table('offer_users')->where('offer_id',$offer_id)
        //     ->whereIn('user_id',$deletable)->delete();
        // }
        // /print_R($deletable);die;
        return redirect('admin/offer')->with('update_message','Data Updated Successfully');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $offers = Offer::findOrFail($id);
        $offers->best_offer()->delete();
        Offer_user::where('offer_id',$id)->delete();
        $offers->delete();

        return response()->json(['success' => 1, 'message' => 'Data Deleted successfully']);
    }
}
