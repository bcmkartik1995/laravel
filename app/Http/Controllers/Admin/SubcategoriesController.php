<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SubCategory;
use Illuminate\Support\Facades\DB;
use App\Category;
use Illuminate\Support\Str;
use App\Package_category;
use App\Package;
use App\Package_service;
use App\Package_cities;
use App\package_media;

class SubcategoriesController extends Controller
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
        $subcategory = SubCategory::with(['category' => function ($query) {
            $query->select('title','id');
        }])
        ->select('id','title','logo','status','category_id')
        ->get();
       
        return view('admin.SubCategories.index',compact('subcategory'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('status','=',1)->get();

        return view('admin.SubCategories.create',compact('categories'));
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
            'title' => 'required|unique:sub_categories,title,NULL,id,deleted_at,NULL',
            'category_id' => 'required',
            'logo' => 'required|mimes:png|dimensions:max_width=64,max_height=64|dimensions:min_width=64,min_height=64|max:2048',
        ];
    
        $customMessages = [
            'dimensions' => 'Image resolution must be 64*64',
            'max' => 'Max file size allowed : 2MB'
        ];
    
        $this->validate($request, $rules, $customMessages);

        $subcategory = new SubCategory;
        $subcategory->title = $request->input('title');
        $slug = Str::slug($subcategory->title,'-');
        $subcategory->slug = $slug;
        $subcategory->category_id = $request->input('category_id');
        
        $image = $request->file('logo');
        $imagename = time().'.'.$image->extension();
        $image->move(public_path('assets/images/subcategorylogo'),$imagename);
        $subcategory->logo = $imagename;

        // $subcategory->note = $request->input('note');
        // $subcategory->sub_note = $request->input('subnote');

        $subcategory->save();
        return redirect('admin/sub-categories')->with('Insert_Message','Data Created Successfully');
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
        // $subcategory = SubCategory::findOrFail($id);
        $subcategory = SubCategory::with(['category'])
        ->findOrFail($id);
        $categories = Category::where('status','=',1)->get();

        return view('admin.SubCategories.edit', compact('subcategory','categories'));
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
            'title' => 'required|unique:sub_categories,title,'.$id.',id,deleted_at,NULL',
            'category_id' => 'required',
            'logo' => 'mimes:png|dimensions:max_width=64,max_height=64|dimensions:min_width=64,min_height=64|max:2048',
        ];
    
        $customMessages = [
            'dimensions' => 'Image resolution must be 64*64',
            'max' => 'Max file size allowed : 2MB'
        ];
    
        $this->validate($request, $rules, $customMessages);

        // $request->validate([
        //     'title' => 'required|unique:sub_categories,title,'.$id.',id,deleted_at,NULL',
        //     'category_id' => 'required',
        //     'note' => 'required',
        // ]);

        $subcategory = subcategory::find($id);
        $subcategory->title = $request->input('title');
        $slug = Str::slug($subcategory->title,'-');
        $subcategory->slug = $slug;
        $subcategory->category_id = $request->input('category_id');
        // $subcategory->note = $request->input('note');
        // $subcategory->sub_note = $request->input('subnote');

        if($request->logo != ''){
            $image = $request->file('logo');
            $imagename = time().'.'.$image->extension();
            $image->move(public_path('assets/images/subcategorylogo'),$imagename);
            $subcategory->logo = $imagename;
        }    

        

        $subcategory->save();
        return redirect('admin/sub-categories')->with('update_message','Data Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subcategory = subcategory::find($id);
        $subcategory->service()->delete();
        $subcategory->packages_subcategory()->delete();

        $package_subcategory = DB::table('packages as p')
        ->leftjoin('package_subcategories as ps','ps.package_id','=','p.id')
        ->leftjoin('package_subcategories as ps2', function ($sub_join)  {
            $sub_join->on('ps2.package_id', '=', 'p.id')->where('ps2.deleted_at', '=',NULL);
        })
        ->where('ps.sub_category_id',$id)->select('p.*',DB::raw('count(ps2.package_id) as package_count'))->having('package_count','=',0)->groupBy('p.id')->get();

        foreach($package_subcategory as $package_subcate){

            Package::where('id',$package_subcate->id)->delete();
            Package_category::where('package_id',$package_subcate->id)->delete();
            Package_service::where('package_id',$package_subcate->id)->delete();
            Package_cities::where('package_id',$package_subcate->id)->delete();
            package_media::where('package_id',$package_subcate->id)->delete();
            
       }
        $subcategory->blog()->delete();
        $subcategory->delete();
        return response()->json(['success' => 1, 'message' => 'Data Deleted successfully']);
        //return redirect('admin/sub-categories')->with('delete_message','Data Deleted successfully');
    }
}
