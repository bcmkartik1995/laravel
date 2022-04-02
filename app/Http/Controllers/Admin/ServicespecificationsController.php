<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service_specifications;

class ServicespecificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$service_id)
    {
        $Service_specifications = Service_specifications::where(['service_id' => $service_id])->get();
        return view('admin.service_specification.index',compact('Service_specifications','service_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request,$service_id)
    {
        return view('admin.service_specification.create', compact('service_id'));
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
            'title' => 'required',
            'description' => 'required',
            'filename' => 'required|mimes:jpg,png,jpeg|dimensions:max_width=300,max_height=300|dimensions:min_width=300,min_height=300|max:2048',
        ];

        $customMessages = [
            'filename.dimensions' => 'Image resolution must be 300*300',
            'filename.required' => 'Please select image',
            'max' => 'Max file size allowed : 2MB',
            'filename.mimes' => 'Image must be a file of type: JPG, PNG, JPEG.'
        ];

        $this->validate($request, $rules, $customMessages);

        $service_specification = new Service_specifications;
        $service_specification->title = $request->input('title');
        $service_specification->service_id = $request->input('service_id');

        $filename = $request->file('filename');
        $filename_name = time().'.'.$filename->extension();
        $filename->move(public_path('assets/images/service_specifications'),$filename_name);
        $service_specification->filename = $filename_name;

        $service_specification->description = $request->input('description');
        $service_specification->save();

        return redirect()->route('service_specification.index', $service_specification->service_id)->with('Insert_Message', 'Data Created Successfully.');
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
        $service_specification = Service_specifications::findOrFail($id);
        return view('admin.service_specification.edit', compact('service_specification'));
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
            'title' => 'required',
            'description' => 'required',
            'filename' => 'mimes:jpg,png,jpeg|dimensions:max_width=300,max_height=300|dimensions:min_width=300,min_height=300|max:2048',
        ];

        $customMessages = [
            'filename.dimensions' => 'Image resolution must be 300*300',
            'max' => 'Max file size allowed : 2MB',
            'filename.mimes' => 'Image must be a file of type: JPG, PNG, JPEG.'
        ];

        $this->validate($request, $rules, $customMessages);


        $service_specification = Service_specifications::find($id);

        $service_specification->title = $request->input('title');

        if($request->filename != ''){
            $filename = $request->file('filename');
            $filename_name = time().'.'.$filename->extension();
            $filename->move(public_path('assets/images/service_specifications'),$filename_name);
            $service_specification->filename = $filename_name;
        }

        $service_specification->description = $request->input('description');
        $service_specification->save();

        return redirect()->route('service_specification.index', $service_specification->service_id)->with('update_message', 'Data Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service_specifications = Service_specifications::find($id);
        $service_specifications->delete();
        return response()->json(['success' => 1, 'message' => 'Data Deleted successfully']);
    }
}
