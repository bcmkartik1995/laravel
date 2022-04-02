<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Slider;
use App\Service;

class SliderController extends Controller
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
        $sliders = Slider::all();

        return view('admin.slider.index',compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services = Service::where(['status' => 1])->get();
        return view('admin.slider.create', compact('services'));
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
            'title'=>'required|max:50',
            'description'=>'required|max:255',
            'image' => 'required|mimes:jpg,png,jpeg|dimensions:max_width=1920,max_height=500|dimensions:min_width=1920,min_height=500|max:2048',
            'mobile_image' => 'required|mimes:jpg,png,jpeg|dimensions:max_width=400,max_height=200|dimensions:min_width=400,min_height=200|max:2048',
        ];

        $customMessages = [
            'image.dimensions' => 'You Can Only Upload Width(1920) Height(500) Image',
            'mobile_image.dimensions' => 'You Can Only Upload Width(400) Height(200) Image',
            'image.max' => 'Max file size allowed : 2MB',
            'mobile_image.max' => 'Max file size allowed : 2MB',
        ];

        $this->validate($request, $rules, $customMessages);

        $slider = new Slider;
        $slider->title = $request->input('title');
        $slider->description = $request->input('description');

        $image = $request->file('image');
        $imagename = rand().time().'.'.$image->extension();
        $image->move(public_path('assets/images/sliderimage'),$imagename);
        $slider->image = $imagename;

        $mobile_image = $request->file('mobile_image');
        $imagename = rand().time().'.'.$mobile_image->extension();
        $mobile_image->move(public_path('assets/images/sliderimage'),$imagename);
        $slider->mobile_image = $imagename;
        if(!empty($request->input('service_id'))){
            $slider->service_id = $request->input('service_id');
        }else{
            $slider->service_id = 0;
        }
        

        $slider->save();

        return redirect('admin/slider')->with('Insert_Message','Data Created Successfully');
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
        $slider = Slider::findOrFail($id);

        $services = Service::where(['status' => 1])->get();
        return view('admin.slider.edit',compact('slider','services'));
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
            'title'=>'required|max:50',
            'description'=>'required|max:255',
            'image' => 'mimes:jpg,png,jpeg|dimensions:max_width=1920,max_height=500|dimensions:min_width=1920,min_height=500|max:2048',
            'mobile_image' => 'mimes:jpg,png,jpeg|dimensions:max_width=400,max_height=200|dimensions:min_width=400,min_height=200|max:2048',
        ];

        $customMessages = [
            'image.dimensions' => 'You Can Only Upload Width(1920) Height(500) Image',
            'mobile_image.dimensions' => 'You Can Only Upload Width(400) Height(200) Image',
            'image.max' => 'Max file size allowed : 2MB',
            'mobile_image.max' => 'Max file size allowed : 2MB',
        ];

        $this->validate($request, $rules, $customMessages);

        $slider = Slider::find($id);
        $slider->title = $request->input('title');
        $slider->description = $request->input('description');

        if($request->image != ''){
            $image = $request->file('image');
            $imagename = rand().time().'.'.$image->extension();
            $image->move(public_path('assets/images/sliderimage'),$imagename);
            $slider->image = $imagename;
        }
        if($request->mobile_image != ''){
            $mobile_image = $request->file('mobile_image');
            $imagename = rand().time().'.'.$mobile_image->extension();
            $mobile_image->move(public_path('assets/images/sliderimage'),$imagename);
            $slider->mobile_image = $imagename;
        }
        
        if(!empty($request->input('service_id'))){
            $slider->service_id = $request->input('service_id');
        }else{
            $slider->service_id = 0;
        }

        $slider->save();

        return redirect('admin/slider')->with('update_message','Data Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slider = Slider::find($id);
        $slider->delete();

        return response()->json(['success' => 1, 'message' => 'Data Deleted successfully']);
    }
}
