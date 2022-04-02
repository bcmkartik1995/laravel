<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\SubCategory;
use App\Blog;

class BlogController extends Controller
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
        $blogs = blog::with(['category' => function ($query) {
            $query->select('title','id');
        }])
        ->with(['sub_category' => function ($query) {
            $query->select('title','id');
        }])
        ->select('*')
        ->get();

        return view('admin.blog.index',compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('status','=',1)->get();

        return view('admin.blog.create',compact('categories'));
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
            'title' => 'required|unique:blogs,title,NULL,id,deleted_at,NULL',
            'photo' => 'required|mimes:jpg,png,jpeg|dimensions:max_width=300,max_height=200|dimensions:min_width=300,min_height=200|max:2048',
            
            'details' => 'required',
            'source' => 'url',
        ];
    
        $customMessages = [
            'dimensions' => 'Image resolution must be 300*200',
            'max' => 'Max file size allowed : 2MB'
        ];
    
        $this->validate($request, $rules, $customMessages);

        $blog = new Blog;
        $blog->category_id = $request->input('category_id');
        $blog->sub_category_id = $request->input('sub_category_id');
        $blog->title = $request->input('title');
        $blog->details = $request->input('details');
        $blog->source = $request->input('source');
        $blog->tags = $request->input('tag');
        $blog->author_name = $request->input('author_name');

        $image = $request->file('photo');
        $imagename = time().'.'.$image->extension();
        $image->move(public_path('assets/images/blogimage'),$imagename);
        $blog->photo = $imagename;

        $blog->save();
        return redirect('admin/blog')->with('Insert_Message','Data Created Successfully');
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
        $blog = Blog::findOrFail($id);
        $categories = Category::where('status','=',1)->get();
        $subcategory = SubCategory::where('category_id', $blog->category_id)->get();
        
        return view('admin.blog.edit', compact('blog','categories','subcategory'));
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
            'title' => 'required|unique:blogs,title,'.$id.',id,deleted_at,NULL',
            'photo' => 'mimes:jpg,png,jpeg|dimensions:max_width=300,max_height=200|dimensions:min_width=300,min_height=200|max:2048',
            
            'details' => 'required',
            'source' => 'url',
        ];
    
        $customMessages = [
            'dimensions' => 'Image resolution must be 300*200',
            'max' => 'Max file size allowed : 2MB'
        ];
    
        $this->validate($request, $rules, $customMessages);

        $blog = Blog::find($id);

        $blog->category_id = $request->input('category_id');
        $blog->sub_category_id = $request->input('sub_category_id');
        $blog->title = $request->input('title');
        $blog->details = $request->input('details');
        $blog->source = $request->input('source');
        $blog->tags = $request->input('tag');
        $blog->author_name = $request->input('author_name');

        if($request->photo != ''){

            $image = $request->file('photo');
            $imagename = time().'.'.$image->extension();
            $image->move(public_path('assets/images/blogimage'),$imagename);
            $blog->photo = $imagename;
        }

        $blog->save();

        return redirect('admin/blog')->with('update_message','Data Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blog = Blog::find($id);
        $blog->delete();
        
        return response()->json(['success' => 1, 'message' => 'Data Deleted successfully']);
    }
}
