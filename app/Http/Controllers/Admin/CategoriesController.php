<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Pagination\Paginator;
use Auth;
use App\Package_category;
use App\Package;
use App\Package_subcategory;
use App\Package_service;
use App\Package_cities;
use App\package_media;

class CategoriesController extends Controller
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
        // echo '<pre>';
        // print_R(auth::user());die;
        // echo"ssss";die;
        $categories = Category::get();
        //print_r($categories);die;
        return view('admin.Categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.Categories.create');
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
            'title' => 'required|unique:categories,title,NULL,id,deleted_at,NULL',
            'logo' => 'required|mimes:png|dimensions:max_width=64,max_height=64|dimensions:min_width=64,min_height=64|max:2048',
            'description' => 'required',
        ];
    
        $customMessages = [
            'dimensions' => 'Image resolution must be 64*64',
            'max' => 'Max file size allowed : 2MB'
        ];
    
        $this->validate($request, $rules, $customMessages);

        $category = new Category;
        $category->title = $request->input('title');
        $slug = Str::slug($category->title,'-');
        $category->slug = $slug;
        $category->description = $request->input('description');
        
        $image = $request->file('logo');
        $imagename = time().'.'.$image->extension();
        $image->move(public_path('assets/images/categorylogo'),$imagename);
        $category->logo = $imagename;

        $category->save();

        return redirect('admin/categories')->with('Insert_Message','Data Created Successfully');
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
        $categories = Category::findOrFail($id);
        
        return view('admin.Categories.edit', compact('categories'));
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
            'title' => 'required|unique:categories,title,'.$id.',id,deleted_at,NULL',
            'description' => 'required',
            'logo' => 'mimes:png|dimensions:max_width=64,max_height=64|dimensions:min_width=64,min_height=64|max:2048',
        ];
    
        $customMessages = [
            'dimensions' => 'Image resolution must be 64*64',
            'max' => 'Max file size allowed : 2MB'
        ];
    
        $this->validate($request, $rules, $customMessages);

        $category = Category::find($id);
        
        $category->title = $request->input('title');
        $slug = Str::slug($category->title,'-');
        $category->slug = $slug;
        $category->description = $request->input('description');
        
        if($request->logo != ''){

            $image = $request->file('logo');
            $imagename = time().'.'.$image->extension();
            $image->move(public_path('assets/images/categorylogo'),$imagename);
            $category->logo = $imagename;
        }
      
        $category->save();
        
        return redirect('admin/categories')->with('update_message','Data Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->subCategory()->delete();
        $category->service()->delete();
        $category->packages_category()->delete();

        $package_category = DB::table('packages as p')
        ->leftjoin('package_categories as pc','pc.package_id','=','p.id')
        ->leftjoin('package_categories as pc2', function ($sub_join)  {
            $sub_join->on('pc2.package_id', '=', 'p.id')->where('pc2.deleted_at', '=',NULL);
        })
        ->where('pc.category_id',$id)->select('p.*',DB::raw('count(pc2.package_id) as package_count'))->having('package_count','=',0)->groupBy('p.id')->get();


       foreach($package_category as $package_cate){

            Package::where('id',$package_cate->id)->delete();
            Package_subcategory::where('package_id',$package_cate->id)->delete();
            Package_service::where('package_id',$package_cate->id)->delete();
            Package_cities::where('package_id',$package_cate->id)->delete();
            package_media::where('package_id',$package_cate->id)->delete();

       }

        $category->offer()->delete();
        $category->blog()->delete();
        $category->delete();
        
        return response()->json(['success' => 1, 'message' => 'Data Deleted successfully']);
        //return redirect('admin/categories')->with('delete_message','Data Deleted successfully');
    }
}
