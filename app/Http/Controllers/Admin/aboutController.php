<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Aboutus;
use App\Our_team;

class aboutController extends Controller
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
        $about = Aboutus::first();
        $our_team = Our_team::all();
        return view('admin.about.index',compact('about','our_team'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.about.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $about = Aboutus::first();
        if(!empty($about)){
            $about = Aboutus::first();
        }else{
            $about = new Aboutus;
        }
        if($request->type == 'section1'){
            
            $rules = [
                'section1_title'=>'required',
                'section1_description'=>'required',
            ];
            
            $this->validate($request, $rules);

            $about->section1_title = $request->input('section1_title');
            $about->section1_description = $request->input('section1_description');
        }

        if($request->type == 'mission_section'){

            $rules = [
                'mission_title'=>'required',
                'mission_description' => 'required',
            ];
        
            $this->validate($request, $rules);

            $about->mission_title = $request->input('mission_title');
            $about->mission_description = $request->input('mission_description');
        }

        if($request->type == 'vision_section'){

            $rules = [
                'vision_title'=>'required',
                'vision_description' => 'required',
            ];
        
            $this->validate($request, $rules);

            $about->vision_title = $request->input('vision_title');
            $about->vision_description = $request->input('vision_description');
        }

        if($request->type == 'section3'){

            $rules = [
                'section3_title'=>'required',
                'section3_description' => 'required',
            ];
        
            $this->validate($request, $rules);

            $about->section3_title = $request->input('section3_title');
            $about->section3_description = $request->input('section3_description');

            if($request->section3_image != ''){
                $image = $request->file('section3_image');
                $imagename = time().rand().'.'.$image->extension();
                $image->move(public_path('assets/images/whoweareimg'),$imagename);
                $about->section3_image = $imagename;
            }
        }
        
        $about->save();

        return redirect('admin/about')->with('Insert_Message','Data Created Successfully');
    }


    public function ourteam_create()
    {
        return view('admin.about.teamcreate');
    }

    public function ourteam_store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'designation' => 'required',
            'image' => 'required|mimes:jpg,png,jpeg|dimensions:max_width=500,max_height=600|dimensions:min_width=500,min_height=600|max:2048',
        ];
    
        $customMessages = [
            'image.dimensions' => 'File resolution must be 500*600',
            'image.max' => 'Max file size allowed : 2MB'
        ];
    
        $this->validate($request, $rules, $customMessages);

        $our_team = new Our_team;
        $our_team->name = $request->name;
        $our_team->designation = $request->designation;

        $image = $request->file('image');
        $imagename = time().rand().'.'.$image->extension();
        $image->move(public_path('assets/images/ourteamimg'),$imagename);
        $our_team->image = $imagename;

        $our_team->save();

        return redirect('admin/about')->with('Insert_Message','Data Created Successfully');
    }

    public function ourteam_edit($id)
    {
        $our_team = Our_team::findOrFail($id);
        return view('admin.about.teamedit',compact('our_team'));
    }

    public function ourteam_update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'designation' => 'required',
            'image' => 'mimes:jpg,png,jpeg|dimensions:max_width=500,max_height=600|dimensions:min_width=500,min_height=600|max:2048',
        ];
    
        $customMessages = [
            'image.dimensions' => 'File resolution must be 500*600',
            'image.max' => 'Max file size allowed : 2MB'
        ];
        $this->validate($request, $rules, $customMessages);

        $our_team = Our_team::find($id);
        $our_team->name = $request->name;
        $our_team->designation = $request->designation;

        if(!empty($request->file('image')))
        {
            $image = $request->file('image');
            $imagename = time().rand().'.'.$image->extension();
            $image->move(public_path('assets/images/ourteamimg'),$imagename);
            $our_team->image = $imagename;
        }

        $our_team->save();

        return redirect('admin/about')->with('update_message','Data Updated Successfully');
    }

    public function ourteam_delete($id)
    {
        $our_team = Our_team::find($id);
        $our_team->delete();
        
        return response()->json(['success' => 1, 'message' => 'Data Deleted successfully']);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $about = Aboutus::findOrFail($id);

        return view('admin.about.edit',compact('about'));
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
            'description'=>'required',
        ];
        
        $this->validate($request, $rules);

        $about = Aboutus::find($id);
        $about->title = $request->input('title');
        $about->heading = $request->input('heading');
        $about->description = $request->input('description');

        $about->save();

        return redirect('admin/about')->with('update_message','Data Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $about = Aboutus::find($id);
        $about->delete();

        return response()->json(['success' => 1, 'message' => 'Data Deleted successfully']);
    }
}
