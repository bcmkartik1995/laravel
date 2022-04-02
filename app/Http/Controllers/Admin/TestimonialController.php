<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Testimonial;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $testimonials = Testimonial::all();
        return view('admin.testimonial.index',compact('testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.testimonial.create');
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
            'title'=>'required',
            'image' => 'required|mimes:jpg,png,jpeg|dimensions:max_width=300,max_height=200|dimensions:min_width=300,min_height=200|max:2048',
        ];
    
        $customMessages = [
            'dimensions' => 'You Can Only Upload Width(300) Height(200) Image',
            'max' => 'Max file size allowed : 2MB',
        ];
    
        $this->validate($request, $rules, $customMessages);

        $testimonial = new Testimonial;
        $testimonial->title = $request->title;

        $image = $request->file('image');
        $imagename = rand().time().'.'.$image->extension();
        $image->move(public_path('assets/images/testimonial'),$imagename);
        $testimonial->image = $imagename;

        $testimonial->save();

        return redirect('admin/testimonial')->with('Insert_Message','Data Created Successfully');
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
        $testimonial = Testimonial::findOrFail($id);

        return view('admin.testimonial.edit',compact('testimonial'));
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
            'title'=>'required',
            'image' => 'mimes:jpg,png,jpeg|dimensions:max_width=300,max_height=200|dimensions:min_width=300,min_height=200|max:2048',
        ];
    
        $customMessages = [
            'dimensions' => 'You Can Only Upload Width(300) Height(200) Image',
            'max' => 'Max file size allowed : 2MB',
        ];
        
        $this->validate($request, $rules, $customMessages);

        $testimonial = Testimonial::find($id);
        $testimonial->title = $request->input('title');

        if($request->image != ''){
            $image = $request->file('image');
            $imagename = rand().time().'.'.$image->extension();
            $image->move(public_path('assets/images/testimonial'),$imagename);
            $testimonial->image = $imagename;
        }

        $testimonial->save();

        return redirect('admin/testimonial')->with('update_message','Data Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $testimonial = Testimonial::find($id);
        $testimonial->delete();

        return response()->json(['success' => 1, 'message' => 'Data Deleted successfully']);
    }
}
