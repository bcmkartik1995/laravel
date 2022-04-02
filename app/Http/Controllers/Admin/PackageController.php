<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service;
use App\Category;
use App\SubCategory;
use App\Package;
use App\Package_service;
use App\Package_category;
use App\Package_subcategory;
use App\City;
use App\Package_cities;
use App\package_media;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Validator;

class PackageController extends Controller
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
        $data = Package::with(['owner' => function ($query) {
            $query->select('franchise_name','id');
        }])
        ->select('id','title','more_description','description','franchises_id','status','discount_value','discount_type')
        ->get();

        return view('admin.package.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $cities = City::where('status',1)->get();
        return view('admin.package.create',compact('categories','cities'));
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
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'city_id' => 'required',
            'title' => 'required',
            'discount_value' => 'required|numeric',
            'discount_type' => 'required',
            'more_description' => 'required',
            'minimum_require' => 'required|numeric',
            'banner' => 'required|mimes:jpg,png,jpeg|dimensions:max_width=300,max_height=200|dimensions:min_width=300,min_height=200|max:2048',
            'multi_media' => 'required',
            'multi_media.*' => 'required|mimes:jpg,png,jpeg,mp4|dimensions:max_width=300,max_height=200|dimensions:min_width=300,min_height=200|max:5120',
            'multi_media' => 'max:5',
        ];
    
        $customMessages = [
            'banner.dimensions' => 'File resolution must be 300*200',
            'multi_media.max' => 'you can Upload Maximum 5 files',
            'multi_media.*.dimensions' => 'File resolution must be 300*200',
            'multi_media.*.max' => 'Max file size allowed : 5MB (one file = 5mb)',
            'banner.max' => 'Max file size allowed : 2MB'
        ];
    
        $this->validate($request, $rules, $customMessages);

        $package = new Package;
        $package->title = $request->input('title');

        $banner = $request->file('banner');
        $bannername = time().'.'.$banner->extension();
        $banner->move(public_path('assets/images/packagebanner'),$bannername);
        $package->banner = $bannername;

        $package->discount_value = $request->input('discount_value');
        $package->discount_type = $request->input('discount_type');
        $package->more_description = $request->input('more_description');
        $package->minimum_require = $request->input('minimum_require');

        $package->save();

        if(!empty($request->category_id)){
            $categories_id = $request->category_id;
            $package_id = $package->id;

            $data = [];
            foreach($categories_id as $category_id){
                $data[] = [
                    'category_id' => $category_id,
                    'package_id' => $package_id
                ];
            }
            Package_category::insert($data);
        }

        if(!empty($request->sub_category_id)){
            $sub_categories_id = $request->sub_category_id;
            $package_id = $package->id;

            $data = [];
            foreach($sub_categories_id as $sub_category_id){
                $data[] = [
                    'sub_category_id' => $sub_category_id,
                    'package_id' => $package_id
                ];
            }
            Package_subcategory::insert($data);
        }
        
        if(!empty($request->service)){
            $services_id = $request->service;
            $package_id = $package->id;

            $data = [];
            foreach($services_id as $service_id) {
                $data[] = [
                    'service_id' => $service_id,
                    'package_id' => $package_id
                ];
            }
            Package_service::insert($data); 
        }

        if(!empty($request->city_id)){
            $cities_id = $request->city_id;
            $package_id = $package->id;

            $data = [];
            foreach($cities_id as $city_id) {
                $data[] = [
                    'city_id' => $city_id,
                    'package_id' => $package_id
                ];
            }
            Package_cities::insert($data); 
        }

        if(!empty($request->multi_media)){
            $medias_id = $request->multi_media;
            $package_id = $package->id;
            
            $data = [];
            foreach($medias_id as $media_id){

                $multi_media = $media_id;
                $medianame = rand().time().'.'.$multi_media->extension();
                $multi_media->move(public_path('assets/images/packagemedia'),$medianame);

                $data[] = [
                    'media' => $medianame,
                    'package_id' => $package_id
                ];
            }
            package_media::insert($data);
        }

        return redirect('admin/package')->with('Insert_Message','Data Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $package_media = package_media::where('package_id',$id)->get();

        // echo '<pre>';
        // print_R($package_media);die;
        $image_formats = ['jpg','png','jpeg','gif'];

        return view('admin.package.view',compact('package_media','id','image_formats'));
    }

    public function update_media(Request $request, $id)
    {
        $rules = [
            'media'=>'required|mimes:jpg,png,jpeg,mp4|dimensions:max_width=300,max_height=200|dimensions:min_width=300,min_height=200|max:5120',
        ];
    
        $customMessages = [
            'media.dimensions' => 'File resolution must be 300*200',
            'media.max' => 'Max file size allowed : 5MB',
        ];

        $validator = Validator::make($request->all(), $rules, $customMessages);
        if($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors()->merge(['edit_id' => $id, 'action' => 'edit']));
        }

        $package_media = package_media::find($id);

        if($request->media != ''){

            $multi_media = $request->file('media');
            $medianame = rand().time().'.'.$multi_media->extension();
            $multi_media->move(public_path('assets/images/packagemedia'),$medianame);
            $package_media->media = $medianame;
        }
        $package_media->save();

        return redirect()->back()->with('update_message','Data Updated Successfully');
    }

    public function add_media(Request $request)
    {
        $rules = [
            'media'=>'required|mimes:jpg,png,jpeg,mp4|dimensions:max_width=300,max_height=200|dimensions:min_width=300,min_height=200|max:5120',
        ];
    
        $customMessages = [
            'media.dimensions' => 'File resolution must be 300*200',
            'media.max' => 'Max file size allowed : 5MB',
        ];

        $validator = Validator::make($request->all(), $rules, $customMessages);
        if($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors()->merge(['action' => 'add']));
        }
        
        $package_media = new package_media;

        $package_media->package_id = $request->package_id;

        $multi_media = $request->file('media');
        $medianame = rand().time().'.'.$multi_media->extension();
        $multi_media->move(public_path('assets/images/packagemedia'),$medianame);
        $package_media->media = $medianame;

        $package_media->save();
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
        $package = Package::findOrFail($id);

        $categories = Category::all();
        $package_cat = Package_category::where('package_id',$id)->pluck('category_id')->toArray();
        $package_sub = Package_subcategory::where('package_id',$id)->pluck('sub_category_id')->toArray();
        $cities = City::where('status',1)->get();
        $package_city = Package_cities::where('package_id',$id)->pluck('city_id')->toArray();
        $subcategory = SubCategory::whereIn('category_id', $package_cat)->get();
        $services = DB::table('package_services as p')
        ->join('services as s', 'p.service_id', '=', 's.id')
        ->select('s.title', 'p.package_id', 'p.service_id','s.id')
        ->where('package_id',$id)
        ->get();

        return view('admin.package.edit', compact('package','categories','subcategory','services','package_cat','package_sub','package_city','cities'));
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
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'city_id' => 'required',
            'title' => 'required',
            'discount_value' => 'required|numeric',
            'discount_type' => 'required',
            'more_description' => 'required',
            'minimum_require' => 'required | numeric',
            'banner' => 'mimes:jpg,png,jpeg|dimensions:max_width=300,max_height=200|dimensions:min_width=300,min_height=200|max:2048',
        ];
    
        $customMessages = [
            'banner.dimensions' => 'File resolution must be 300*200',
            'max' => 'Max file size allowed : 2MB'
        ];
    
        $this->validate($request, $rules, $customMessages);
        

        $package = Package::find($id);
        $package->title = $request->input('title');
        $package->discount_value = $request->input('discount_value');
        $package->discount_type = $request->input('discount_type');
        $package->more_description = $request->input('more_description');
        $package->minimum_require = $request->input('minimum_require');

        
        if($request->banner != ''){
            $banner = $request->file('banner');
            $bannername = time().'.'.$banner->extension();
            $banner->move(public_path('assets/images/packagebanner'),$bannername);
            $package->banner = $bannername;
        }

        //$package->package_services =  $request->service;
        $package->save();

        if(!empty($request->category_id)){
            $package_category = Package_category::where('package_id',$id)->pluck('category_id')->toArray();
            $categories_id = $request->category_id;
            $package_id = $package->id;

            $data = [];
            foreach($categories_id as $category_id) {
                if(!in_array($category_id, $package_category)){
                    echo   $category_id;
                    $data[] = [
                        'category_id' => $category_id,
                        'package_id' => $package_id
                    ];
                }
            }
            $deletable = array_diff($package_category, $categories_id);
            if(!empty($data)){
                Package_category::insert($data);
            }
            if(!empty($deletable)){
                $delete_package_category = Package_category::whereIn('category_id', $deletable)->where('package_id',$id);
                $delete_package_category->delete();
            }
        }

        if(!empty($request->sub_category_id)){
            $package_subcategory = Package_subcategory::where('package_id',$id)->pluck('sub_category_id')->toArray();
            $sub_categories_id = $request->sub_category_id;
            $package_id = $package->id;

            $data = [];
            foreach($sub_categories_id as $sub_category_id) {
                if(!in_array($sub_category_id, $package_subcategory)){
                    echo   $sub_category_id;
                    $data[] = [
                        'sub_category_id' => $sub_category_id,
                        'package_id' => $package_id
                    ];
                }
            }
            $deletable = array_diff($package_subcategory, $sub_categories_id);
            if(!empty($data)){
                Package_subcategory::insert($data);
            }
            if(!empty($deletable)){
                $delete_package_subcategory = Package_subcategory::whereIn('sub_category_id', $deletable)->where('package_id',$id);
                $delete_package_subcategory->delete();
            }
        }

        if(!empty($request->service)){
            $package_service = Package_service::where('package_id',$id)->pluck('service_id')->toArray();
            $services_id = $request->service;
            $package_id = $package->id;

            $data = [];
            foreach($services_id as $service_id) {
                if(!in_array($service_id, $package_service)){
                    echo   $service_id;
                    $data[] = [
                        'service_id' => $service_id,
                        'package_id' => $package_id
                    ];
                }
            }
            $deletable = array_diff($package_service, $services_id);
            if(!empty($data)){
                Package_service::insert($data);
            }
            if(!empty($deletable)){
                $delete_package_services = Package_service::whereIn('service_id', $deletable)->where('package_id',$id);
                $delete_package_services->delete();
            }
        }

        if(!empty($request->city_id)){
            $package_city = Package_cities::where('package_id',$id)->pluck('city_id')->toArray();
            $cities_id = $request->city_id;
            $package_id = $package->id;

            $data = [];
            foreach($cities_id as $city_id) {
                if(!in_array($city_id, $package_city)){
                    echo   $city_id;
                    $data[] = [
                        'city_id' => $city_id,
                        'package_id' => $package_id
                    ];
                }
            }
            $deletable = array_diff($package_city, $cities_id);
            if(!empty($data)){
                Package_cities::insert($data);
            }
            if(!empty($deletable)){
                $delete_package_city = Package_cities::whereIn('city_id', $deletable)->where('package_id',$id);
                $delete_package_city->delete();
            }
        }

        return redirect('admin/package')->with('update_message','Data Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $package = Package::find($id);
        $package->packages_ratings()->delete();
        
        Package_category::where('package_id',$id)->delete();
        Package_subcategory::where('package_id',$id)->delete();
        Package_service::where('package_id',$id)->delete();
        Package_cities::where('package_id',$id)->delete();
        package_media::where('package_id',$id)->delete();

        $package->delete();
        
        return response()->json(['success' => 1, 'message' => 'Data Deleted successfully']);
    }

    public function media_destroy($id)
    {
        $package_media = package_media::find($id);
        $package_media->delete();

        return response()->json(['success' => 1, 'message' => 'Data Deleted successfully']);
    }
}
