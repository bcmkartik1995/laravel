<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service;
use App\Category;
use App\SubCategory;
use App\City;
use App\Service_cities;
use App\Services_ratings;
use App\service_media;
use App\Best_service;
use App\Package;
use App\Package_category;
use App\Package_subcategory;
use App\Package_cities;
use App\package_media;
use App\Franchise_services;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Pagination\Paginator;
use Validator;

class ServicesController extends Controller
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

        $services = Service::with(['category' => function ($query) {
            $query->select('title','id');
        }])
        ->select('id','title','image','banner','hour','minute','description','long_description','status','category_id','sub_category_id')
        ->orderBy('id', 'DESC')
        ->with(['sub_category' => function ($query) {
            $query->select('title','id');
        }])
        ->get();  

        //$services = DB::table('services')->paginate(10);
        return view('admin.Services.index',compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('status','=',1)->get();
        //$cities = City::where('status',1)->get();
        return view('admin.Services.create',compact('categories'));
    }

    // public function fetchSubCategory(Request $request)
    // {
    //     $subcategory = SubCategory::where("category_id",$request->category_id)->get(["name", "id"]);
    //     return view('admin.Services.create',compact('subcategory'));
    // }
    // $('#category_id').change(function(){
    //     category_id = $(this).val();
    // })
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
            'title' => 'required',
            'price' => 'required|numeric',
            'hour' => 'required',
            'minute' => 'required',
            'description' => 'required',
            'image' => 'required|mimes:png|dimensions:max_width=64,max_height=64|dimensions:min_width=64,min_height=64|max:2048',
            'banner' => 'required|mimes:jpg,png,jpeg|dimensions:max_width=300,max_height=200|dimensions:min_width=300,min_height=200|max:2048',
            'multi_media' => 'required',
            // 'multi_media.*' => 'required|mimes:jpg,png,jpeg,mp4|dimensions:max_width=300,max_height=200|dimensions:min_width=300,min_height=200|max:5120',
            'multi_media.*' => 'required|mimes:jpg,png,jpeg,mp4|max:10240',
            'multi_media' => 'max:5',
        ];
    
        $customMessages = [
            'image.dimensions' => 'File resolution must be 64*64',
            'banner.dimensions' => 'File resolution must be 300*200',
            'multi_media.*.dimensions' => 'File resolution must be 300*200',
            'multi_media.max' => 'you can Upload Maximum 5 files',
            'multi_media.*.max' => 'Max file size allowed : 10MB (one file = 10mb)',
            'max' => 'Max file size allowed : 10MB'
        ];
    
        $this->validate($request, $rules, $customMessages);

        $service = new Service;
        $service->category_id = $request->input('category_id');
        $service->sub_category_id = $request->input('sub_category_id');
        $service->title = $request->input('title');

        $image = $request->file('image');
        $imagename = time().'.'.$image->extension();
        $image->move(public_path('assets/images/servicelogo'),$imagename);
        $service->image = $imagename;

        $banner = $request->file('banner');
        $bannername = time().'.'.$banner->extension();
        $banner->move(public_path('assets/images/servicebanner'),$bannername);
        $service->banner = $bannername;

        $service->price = $request->input('price');
        $service->hour = $request->input('hour');
        $service->minute = $request->input('minute');
        $service->description = $request->input('description');
        $service->long_description = $request->input('long_description');
        // echo '<pre>';
        // print_R($service);die;
        $service->save();




        if(!empty($request->multi_media)){
            $medias_id = $request->multi_media;
            $service_id = $service->id;
            
            $data = [];
            foreach($medias_id as $media_id){

                $multi_media = $media_id;
                $medianame = rand().time().'.'.$multi_media->extension();
                $multi_media->move(public_path('assets/images/servicemedia'),$medianame);

                $data[] = [
                    'media' => $medianame,
                    'service_id' => $service_id
                ];
            }
            service_media::insert($data);
        }

        return redirect('admin/services')->with('Insert_Message','Data Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $service_media = service_media::where('service_id',$id)->get();

       $image_formats = ['jpg','png','jpeg','gif'];

       return view('admin.Services.view',compact('service_media','id','image_formats'));
    }


    public function update_media(Request $request, $id)
    {
        // $rules = [
        //     'media'=>'required|mimes:jpg,png,jpeg,mp4|dimensions:max_width=300,max_height=200|dimensions:min_width=300,min_height=200|max:5120',
        // ];
        $rules = [
            // 'media'=>'required|mimes:jpg,png,jpeg,mp4|dimensions:max_width=300,max_height=200|dimensions:min_width=300,min_height=200|max:5120',
            'media'=>'required|mimes:jpg,png,jpeg,mp4|max:10240',
        ];
    
        $customMessages = [
            'media.dimensions' => 'File resolution must be 300*200',
            'media.max' => 'Max file size allowed : 10MB',
        ];

        $validator = Validator::make($request->all(), $rules, $customMessages);
        if($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors()->merge(['edit_id' => $id, 'action' => 'edit']));
        }
        //$this->validate($request, $rules, $customMessages);


        $service_media = service_media::find($id);

        if($request->media != ''){

            $multi_media = $request->file('media');
            $medianame = rand().time().'.'.$multi_media->extension();
            $multi_media->move(public_path('assets/images/servicemedia'),$medianame);
            $service_media->media = $medianame;
        }
        $service_media->save();

        return redirect()->back()->with('update_message','Data Updated Successfully');
    }

    public function add_media(Request $request)
    {
        // $request->validate([
        //     'media'=>'required|dimensions:max_width=350,max_height=250|dimensions:min_width=350,min_height=250',
        // ]);

        // $rules = [
        //     'media'=>'required|mimes:jpg,png,jpeg,mp4|dimensions:max_width=300,max_height=200|dimensions:min_width=300,min_height=200|max:5120',
        // ];
        $rules = [
            // 'media'=>'required|mimes:jpg,png,jpeg,mp4|dimensions:max_width=300,max_height=200|dimensions:min_width=300,min_height=200|max:5120',
            'media'=>'required|mimes:jpg,png,jpeg,mp4|max:10240',
        ];

        $customMessages = [
            'media.dimensions' => 'File resolution must be 300*200',
            'media.max' => 'Max file size allowed : 10MB',
        ];

        $validator = Validator::make($request->all(), $rules, $customMessages);
        if($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors()->merge(['action' => 'add']));
        }

        $service_media = new service_media;

        $service_media->service_id = $request->service_id;

        $multi_media = $request->file('media');
        $medianame = rand().time().'.'.$multi_media->extension();
        $multi_media->move(public_path('assets/images/servicemedia'),$medianame);
        $service_media->media = $medianame;

        $service_media->save();
        return redirect()->back()->with('Insert_Message','Data Created Successfully');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $service = Service::findOrFail($id);
        $categories = Category::where('status','=',1)->get();
        $subcategory = SubCategory::where('category_id', $service->category_id)->get();

        //$cities = City::where('status',1)->get();
        //$service_city = Service_cities::where('service_id',$id)->pluck('city_id')->toArray();

        return view('admin.Services.edit', compact('service','categories','subcategory'));
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
            'category_id'=>'required',
            'sub_category_id'=>'required',
            'title' => 'required',
            'price' => 'required|numeric',
            'hour' => 'required',
            'minute' => 'required',
            'description' => 'required',
            'image' => 'mimes:png|dimensions:max_width=64,max_height=64|dimensions:min_width=64,min_height=64|max:2048',
            'banner' => 'mimes:jpg,png,jpeg|dimensions:max_width=300,max_height=200|dimensions:min_width=300,min_height=200|max:2048',
        ];
    
        $customMessages = [
            'image.dimensions' => 'File resolution must be 64*64',
            'banner.dimensions' => 'File resolution must be 300*200',
            'max' => 'Max file size allowed : 2MB'
        ];
    
        $this->validate($request, $rules, $customMessages);

        $service = Service::find($id);
        $service->category_id = $request->input('category_id');
        $service->sub_category_id = $request->input('sub_category_id');
        $service->title = $request->input('title');

        if($request->image != ''){
            $image = $request->file('image');
            $imagename = time().'.'.$image->extension();
            $image->move(public_path('assets/images/servicelogo'),$imagename);
            $service->image = $imagename;
        }

        if($request->banner != ''){
            $banner = $request->file('banner');
            $bannername = time().'.'.$banner->extension();
            $banner->move(public_path('assets/images/servicebanner'),$bannername);
            $service->banner = $bannername;
        }

        $service->price = $request->input('price');
        $service->hour = $request->input('hour');
        $service->minute = $request->input('minute');
        $service->description = $request->input('description');
        $service->long_description = $request->input('long_description');
        $service->save();

   

        // if(!empty($request->multi_media)){
        //     $service_media = service_media::where('service_id',$id)->pluck('media')->toArray();
        //     $medias_id = $request->multi_media;
        //     $service_id = $service->id;

        //     $data = [];
        //     foreach($medias_id as $media_id){
        //         ()
        //     }
        // }
        
        return redirect('admin/services')->with('update_message','Data Updated Successfully');
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
        $service->package_service()->delete();

        $package_services = DB::table('packages as p')
        ->leftjoin('package_services as ps','ps.package_id','=','p.id')
        ->leftjoin('package_services as ps2', function ($sub_join)  {
            $sub_join->on('ps2.package_id', '=', 'p.id')->where('ps2.deleted_at', '=',NULL);
        })
        ->where('ps.service_id',$id)->select('p.*',DB::raw('count(ps2.package_id) as package_count'))->having('package_count','=',0)->groupBy('p.id')->get();

        foreach($package_services as $package_service){

            Package::where('id',$package_service->id)->delete();
            Package_category::where('package_id',$package_service->id)->delete();
            Package_subcategory::where('package_id',$package_service->id)->delete();
            Package_cities::where('package_id',$package_service->id)->delete();
            package_media::where('package_id',$package_service->id)->delete();
            
        }

        $service->services_ratings()->delete();
	$service->request_quotes()->delete();
        Service_cities::where('service_id',$id)->delete();
        service_media::where('service_id',$id)->delete();
        Services_ratings::where('service_id',$id)->delete();
        //Best_service::where('service_id',$id)->delete();
        $service->best_service()->delete();
        Franchise_services::where('service_id',$id)->delete();
        
        $service->delete();

        return response()->json(['success' => 1, 'message' => 'Data Deleted successfully']);
    }

    public function media_destroy($id)
    {
        $service_media = service_media::find($id);
        $service_media->delete();

        return response()->json(['success' => 1, 'message' => 'Data Deleted successfully']);
    }

}
