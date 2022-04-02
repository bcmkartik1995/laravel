<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Credit_plans;
use App\Credit_price;
use App\Franchise;

class CreditplansController extends Controller
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
        $validity_types = [1 => 'Day', 2 => 'Week', 3 => 'Month', 4 => 'Year'];
        $credit_plans = Credit_plans::get();

        $Credit_price = Credit_price::first();
        return view('admin.credit_plans.index',compact('credit_plans','validity_types','Credit_price'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $validity_types = [1 => 'Day', 2 => 'Week', 3 => 'Month', 4 => 'Year'];
        return view('admin.credit_plans.create', compact('validity_types'));
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
            'title' => 'required|unique:credit_plans,title,NULL,id,deleted_at,NULL',
            'credit_value' => 'required|numeric',
            'validity_value' => 'required|numeric',
            'price' => 'numeric',
            'validity_type' => 'required',
            'description' => 'required',
            'image' => 'required|mimes:jpg,png,jpeg|dimensions:max_width=300,max_height=200|dimensions:min_width=300,min_height=200|max:2048',
            'real_price' => 'required|numeric',
        ];
    
        $customMessages = [
            'image.dimensions' => 'File resolution must be 300*200',
            'image.max' => 'Max file size allowed : 2MB'
        ];
    
        $this->validate($request, $rules, $customMessages);

        $Credit_plans = new Credit_plans;
        $Credit_plans->title = $request->input('title');
        $Credit_plans->credit_value = $request->input('credit_value');
        $Credit_plans->price = $request->input('price');
        $Credit_plans->real_price = $request->input('real_price');
        $Credit_plans->validity_value = $request->input('validity_value');
        $Credit_plans->validity_type = $request->input('validity_type');
        $Credit_plans->description = $request->input('description');

        $image = $request->file('image');
        $imagename = time().'.'.$image->extension();
        $image->move(public_path('assets/images/creditplanbanner'),$imagename);
        $Credit_plans->image = $imagename;
    
        $Credit_plans->save();

        return redirect('admin/credit_plans')->with('Insert_Message','Data Created Successfully');
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
        $credit_plans = Credit_plans::findOrFail($id);

        $validity_types = [1 => 'Day', 2 => 'Week', 3 => 'Month', 4 => 'Year'];
        return view('admin.credit_plans.edit', compact('credit_plans','validity_types'));
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
            'title' => 'required|unique:credit_plans,title,'.$id.',id,deleted_at,NULL',
            'credit_value' => 'required|numeric',
            'validity_value' => 'required|numeric',
            'price' => 'numeric',
            'validity_type' => 'required',
            'description' => 'required',
            'image' => 'mimes:jpg,png,jpeg|dimensions:max_width=300,max_height=200|dimensions:min_width=300,min_height=200|max:2048',
            'real_price' => 'required|numeric',
        ];
    
        $customMessages = [
            'image.dimensions' => 'File resolution must be 300*200',
            'image.max' => 'Max file size allowed : 2MB'
        ];
    
        $this->validate($request, $rules, $customMessages);

        $Credit_plans = Credit_plans::find($id);
        $Credit_plans->title = $request->input('title');
        $Credit_plans->credit_value = $request->input('credit_value');
        $Credit_plans->price = $request->input('price');
        $Credit_plans->real_price = $request->input('real_price');
        $Credit_plans->validity_value = $request->input('validity_value');
        $Credit_plans->validity_type = $request->input('validity_type');
        $Credit_plans->description = $request->input('description');

        if($request->image != ''){
            $image = $request->file('image');
            $imagename = time().'.'.$image->extension();
            $image->move(public_path('assets/images/creditplanbanner'),$imagename);
            $Credit_plans->image = $imagename;
        }

        $Credit_plans->save();

        return redirect('admin/credit_plans')->with('update_message','Data Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Credit_plans = Credit_plans::find($id);
        $Credit_plans->delete();
        return response()->json(['success' => 1, 'message' => 'Data Deleted successfully']);
    }

   
}
