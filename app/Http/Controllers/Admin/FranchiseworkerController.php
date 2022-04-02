<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Franchise_worker;
use Auth;
use App\Franchise;
use App\Worker_service;
use App\Franchise_services;
use Mail;
use Illuminate\Support\Str;

class FranchiseworkerController extends Controller
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
        $user_id = Auth::guard('admin')->user()->id;
        $franchises_id = Franchise::where('user_id',$user_id)->first();

        
        $franchise_workers = Franchise_worker::where('franchises_id',$franchises_id->id)->get();

        return view('admin.franchise_worker.index',compact('franchise_workers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        $user_id = Auth::guard('admin')->user()->id;
        $franchises_id = Franchise::where('user_id',$user_id)->first();

        $services = Franchise_services::with(['service' => function ($query) {
            $query->select('title','id','image');
        }])
        ->select('id','franchise_id','service_id','hour','minute')
        ->where('franchise_id',$franchises_id->id)
        ->get();

        return view('admin.franchise_worker.create',compact('franchises_id','services'));
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
            'service' => 'required',
            'name'=>'required',
            'email'=>'required|string|email|max:255|unique:franchise_workers,email,NULL,id,deleted_at,NULL',
            'mobile'=>'required|numeric|digits:10|unique:franchise_workers,mobile,NULL,id,deleted_at,NULL',
        ]);

        $franchise_worker = new Franchise_worker;
        
        $franchise_worker->franchises_id = $request->input('franchises_id');
        $franchise_worker->name = $request->input('name');
        $franchise_worker->email = $request->input('email');
        $franchise_worker->mobile = $request->input('mobile');
        $password = Str::random(8);
        $encripted_password = bcrypt($password);
        $franchise_worker->password = $encripted_password;
        
        $franchise_worker->save();

        if(!empty($request->service)){
            $services_id = $request->service;
            $worker_id = $franchise_worker->id;

            $data = [];
            foreach($services_id as $service_id){
                $data[] = [
                    'service_id' => $service_id,
                    'worker_id' => $worker_id
                ];
            }
            Worker_service::insert($data);
        }

        $data = [
            'name' => $franchise_worker->name,
            'email' => $franchise_worker->email,
            'mobile' => $franchise_worker->mobile,
            'password' => $password
        ];

        Mail::send('admin.franchise_worker.mail.sendmail', $data, function($message)use($data) {            
            $message->to($data['email'])
                ->subject('New Account Created');
        });

        return redirect('admin/franchises-worker')->with('Insert_Message','Data Created Successfully. We Have Sent Mail Worker Username And Password');
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
        $franchise_worker = Franchise_worker::findOrFail($id);

        $worker_service = Worker_service::where('worker_id',$id)->pluck('service_id')->toArray();       
        
        $services = Franchise_services::with(['service' => function ($query) {
            $query->select('title','id');
        }])
        ->select('id','franchise_id','service_id')
        ->where('franchise_id',$franchise_worker->franchises_id)
        ->get();

        return view('admin.franchise_worker.edit',compact('franchise_worker','worker_service','services'));
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
            'service' => 'required',
            'name'=>'required',
            'email'=>'required|string|email|max:255|unique:franchise_workers,email,'.$id.',id,deleted_at,NULL',
            'mobile'=>'required|numeric|digits:10|unique:franchise_workers,mobile,'.$id.',id,deleted_at,NULL',
        ]);

        $franchise_worker = Franchise_worker::find($id);

        $franchise_worker->name = $request->input('name');
        $franchise_worker->email = $request->input('email');
        $franchise_worker->mobile = $request->input('mobile');
        
        $franchise_worker->save();


        if(!empty($request->service)){

            $worker_service = Worker_service::where('worker_id',$id)->pluck('service_id')->toArray();
            $services_id = $request->service;
            $worker_id = $franchise_worker->id;

            $data = [];
            foreach($services_id as $service_id) {
                if(!in_array($service_id, $worker_service)){
                    echo   $service_id;
                    $data[] = [
                        'service_id' => $service_id,
                        'worker_id' => $worker_id
                    ];
                }
            }
            $deletable = array_diff($worker_service, $services_id);
            if(!empty($data)){
                Worker_service::insert($data);
            }
            if(!empty($deletable)){
                $delete_Worker_services = Worker_service::whereIn('service_id', $deletable)->where('worker_id',$id);
                $delete_Worker_services->delete();
            }
        }

        return redirect('admin/franchises-worker')->with('update_message','Data Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $franchise_worker = Franchise_worker::find($id);
        $franchise_worker->delete();

        return response()->json(['success' => 1, 'message' => 'Data Deleted successfully']);
    }
}
