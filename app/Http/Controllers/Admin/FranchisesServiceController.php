<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service;
use App\Category;
use App\SubCategory;
use App\Franchise;
use App\City;
use App\Service_cities;
use App\Franchise_services;
use Illuminate\Support\Facades\DB;
use Auth;

class FranchisesServiceController extends Controller
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
        $user_id = Auth::guard('admin')->user()->id;
        $franchises_id = Franchise::where('user_id',$user_id)->first();

        $services = Franchise_services::with(['service' => function ($query) {
            $query->select('title','id','image');
        }])
        ->with(['franchise' => function ($query) {
            $query->select('id','hour','minute');
        }])
        ->select('id','service_id','hour','minute','status','franchise_id')
        ->where('franchise_id',$franchises_id->id)
        ->get();

        // echo '<pre>';
        // print_R($services);die;
        
        // $services = Service::with(['category' => function ($query) {
        //     $query->select('title','id');
        // }])
        // ->select('id','title','image','hour','minute','description','long_description','status','category_id','franchises_id','sub_category_id')
        // ->orderBy('id', 'DESC')
        // ->where('franchises_id',$franchises_id->id)
        // ->with(['sub_category' => function ($query) {
        //     $query->select('title','id');
        // }])
        // ->get();  

        return view('admin.franchises_service.index',compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $user_id = Auth::guard('admin')->user()->id;
        $franchises_id = Franchise::where('user_id',$user_id)->first();

        $cities = City::where('status',1)->get();

        return view('admin.franchises_service.create',compact('categories','franchises_id','cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = [
            'category_id'=>'required',
            'sub_category_id'=>'required',
            'city_id'=>'required',
            'title' => 'required',
            'price' => 'required',
            'hour' => 'required',
            'minute' => 'required',
            'description' => 'required',
            'franchises_id' => 'required',
            'image' => 'required|mimes:png|dimensions:max_width=64,max_height=64|dimensions:min_width=64,min_height=64|max:2048',
        ];
    
        $customMessages = [
            'image.dimensions' => 'Image resolution must be 64*64',
            'max' => 'Max file size allowed : 2MB'
        ];
    
        $this->validate($request, $rules, $customMessages);

        $service = new Service;
        $service->franchises_id = $request->input('franchises_id');
        $service->category_id = $request->input('category_id');
        $service->sub_category_id = $request->input('sub_category_id');
        $service->title = $request->input('title');

        $image = $request->file('image');
        $imagename = time().'.'.$image->extension();
        $image->move(public_path('assets/images/servicelogo'),$imagename);
        $service->image = $imagename;

        $service->price = $request->input('price');
        $service->hour = $request->input('hour');
        $service->minute = $request->input('minute');
        $service->description = $request->input('description');
        $service->long_description = $request->input('long_description');
        $service->status = 0;
        $service->save();

        if(!empty($request->city_id)){
            $cities_id = $request->city_id;
            $service_id = $service->id;

            $data = [];
            foreach($cities_id as $city_id){
                $data[] = [
                    'city_id' => $city_id,
                    'service_id' => $service_id
                ];
            }
            Service_cities::insert($data);
        }

        return redirect('admin/franchises-service')->with('Insert_Message','Data Created Successfully');
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
  
        
        $service = Franchise_services::with(['service' => function ($query) {
            $query->select('title','id');
        }])
        ->select('id','service_id','hour','minute','franchise_id')
        ->where('id', $id)
        ->first();

    //    echo '<pre>';
    //    print_R($service);die;

        // $categories = Category::all();
        // $subcategory = SubCategory::where('category_id', $service->category_id)->get();

        // $cities = City::where('status',1)->get();
        // $service_city = Service_cities::where('service_id',$id)->pluck('city_id')->toArray();

        return view('admin.franchises_service.edit', compact('service'));
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
        $rules = [
            'hour' => 'required',
            'minute' => 'required',
        ];
    
        $this->validate($request, $rules);
        
        $franchise_service = Franchise_services::find($id);
        $franchise_service->hour = $request->input('hour');
        $franchise_service->minute = $request->input('minute');

        $franchise_service->save();

        return redirect('admin/franchises-service')->with('update_message','Data Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = Service::find($id);
        $service->delete();
        Service_cities::where('service_id',$id)->delete();

        return response()->json(['success' => 1, 'message' => 'Data Deleted successfully']);
    }
}
