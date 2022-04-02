<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Service;
use App\Best_service;
use App\SubCategory;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Pagination\Paginator;

class BestserviceController extends Controller
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
        $best_services = Best_service::with(['service' => function ($query) {
            $query->select('title','id');
        }])
        ->select('id','service_id','status')
        ->get();

        return view('admin.best_service.index',compact('best_services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services = Service::where(['status' => 1])->get();
        return view('admin.best_service.create',compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_id'=>'required',
        ]);

        $best_service = new Best_service;
        $best_service->service_id = $request->input('service_id');

        $best_service->save();

        return redirect('admin/best-service')->with('Insert_Message','Data Created Successfully');
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
       
        $best_service = Best_service::find($id);
        $services = Service::where(['status'=>1])->get();
        return view('admin.best_service.edit',compact('best_service','services'));

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
    
        $request->validate([
            'service_id'=>'required',
        ]);

        $best_service = Best_service::find($id);
        $best_service->service_id = $request->input('service_id');

        $best_service->save();
        
        return redirect('admin/best-service')->with('update_message','Data Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $best_service = Best_service::find($id);
        $best_service->delete();

        return response()->json(['success' => 1, 'message' => 'Data Deleted successfully']);
    }
}
