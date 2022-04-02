<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Admin;
use App\Franchise;
use App\Franchise_worker;
use App\Franchise_services;
use App\Service;
use App\Worker_service;
use Mail;
use Illuminate\Support\Str;

class FranchiseworkerController extends Controller
{
    use ApiResponser;

    public function worker_detail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'is_active' => 'required',
        ]);
        
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }

        $user_id = $request->user_id;
        $is_active = $request->is_active;

        $user = Admin::find($user_id);
        if($user){
            $franchise = Franchise::where(['user_id' => $user_id])->first();

            if($franchise){
                $franchise_id = $franchise->id;

                if($is_active == false){
                    $worker_detail = Franchise_worker::where(['franchises_id' => $franchise_id])
                    ->select('id','franchises_id','name','email','mobile','status')
                    ->orderBy('id','DESC')
                    ->get();
                }else{
                    $worker_detail = Franchise_worker::where(['franchises_id' => $franchise_id,'status'=>1])
                    ->select('id','franchises_id','name','email','mobile','status')
                    ->orderBy('id','DESC')
                    ->get();
                }
                

                if($worker_detail->count() > 0){
                    return $this->success([
                        'worker_detail' => $worker_detail
                    ]);
                }else{
                    return $this->error('Worker not found', 401);
                }
                
            }else{
                return $this->error('Franchise not found', 401);
            }
        }
        return $this->error('Invalid Access', 401);
    }

    public function worker_add(Request $request)
    {
        if($request->worker_id == null || $request->worker_id == 0){
            
            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'service' => 'required',
                'name'=>'required',
                'email'=>'required|string|email|max:255|unique:franchise_workers,email,NULL,id,deleted_at,NULL',
                'mobile'=>'required|numeric|digits:10|unique:franchise_workers,mobile,NULL,id,deleted_at,NULL',
            ]);
            if ($validator->fails()) {
                return $this->error($validator->errors()->first(), 401);
            }

            $user_id = $request->user_id;

            $user = Admin::find($user_id);

            if($user){

                $franchise = Franchise::where(['user_id' => $user_id])->first();

                if($franchise){

                    $franchise_worker = new Franchise_worker;
                    $franchise_worker->franchises_id = $franchise->id;
                    $franchise_worker->name = $request->name;
                    $franchise_worker->email = $request->email;
                    $franchise_worker->mobile = $request->mobile;
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

                    $franchise_worker['message'] = 'We have sent mail worker username and password';

                    // $worker_service = Worker_service::where('worker_id',$franchise_worker->id)->with(['services' => function($query){
                    //     $query->select('id','title');
                    // }])
                    // ->select('id','service_id','worker_id')
                    // ->get();
                    // $franchise_worker['worker_service'] = $worker_service;
                    
                    return $this->success([
                        'worker_detail' => $franchise_worker
                    ]);

                }else{
                    return $this->error('Franchise not found', 401);
                }
            }
            return $this->error('Invalid Access', 401);
        }else{
            
            $worker_id = $request->worker_id;
            $validator = Validator::make($request->all(), [
                'worker_id' => 'required',
                'service' => 'required',
                'name'=>'required',
                'email'=>'required|string|email|max:255|unique:franchise_workers,email,'.$worker_id.',id,deleted_at,NULL',
                'mobile'=>'required|numeric|digits:10|unique:franchise_workers,mobile,'.$worker_id.',id,deleted_at,NULL',
            ]);
            if ($validator->fails()) {
                return $this->error($validator->errors()->first(), 401);
            }
    
            $worker = Franchise_worker::where('id',$worker_id)->first();
    
            if($worker){
                $worker->name = $request->name;
                $worker->email = $request->email;
                $worker->mobile = $request->mobile;
    
                if(!empty($request->service)){
    
                    $worker_service = Worker_service::where('worker_id',$worker_id)->pluck('service_id')->toArray();
                    $services_id = $request->service;
        
                    $data = [];
                    foreach($services_id as $service_id) {
                        if(!in_array($service_id, $worker_service)){
                            //echo   $service_id;
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
                        $delete_Worker_services = Worker_service::whereIn('service_id', $deletable)->where('worker_id',$worker_id);
                        $delete_Worker_services->delete();
                    }
                }
    
                $worker->save();

                $worker['message'] = 'Worker data updated successfully';
    
                // $worker_service = Worker_service::where('worker_id',$worker_id)->with(['services' => function($query){
                //     $query->select('id','title');
                // }])
                // ->select('id','service_id','worker_id')
                // ->get();
                // $worker['worker_service'] = $worker_service;
                return $this->success([
                    'worker_detail' => $worker
                ]);
            }
            return $this->error('Invalid Access', 401);
        }
    }

    public function worker_edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'worker_id' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }

        $worker_id = $request->worker_id;
        $worker = Franchise_worker::where('id',$worker_id)
        ->with(['worker_service' => function ($query) {
            $query->select('id','service_id','worker_id')->with(['services' => function($query){
                $query->select('id','title');
            }]);
        }])
        ->first();

        if($worker){
            return $this->success([
                'worker' => $worker
            ]);
        }
        return $this->error('Invalid Access', 401);
    }

    public function franchise_service(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }

        $user_id = $request->user_id;
        $user = Admin::find($user_id);

        if($user){

            $franchise = Franchise::where(['user_id' => $user_id])->first();

            if($franchise){

                $franchise_id = $franchise->id;

                $franchise_service = Franchise_services::where('franchise_id',$franchise_id)
                ->with(['service' => function ($query) {
                    $query->select('id','title','image','hour','minute','status');
                        
                }])
                ->select('id','franchise_id','service_id')
                ->get();

                if($franchise_service->count() > 0){
                    foreach($franchise_service as $service){
                        $service['service']['image'] = asset('assets/images/servicelogo/'.$service['service']['image']);
                        //$service['service']['time'] = ($service['service']['hour']).' hour '.($service['service']['minute']).' minute';
                    }
                    return $this->success([
                        'service' => $franchise_service
                    ]);
                }else{
                    return $this->error('Service not found', 401);
                }
              
            }else{
                return $this->error('Franchise not found', 401);
            }
        }
        return $this->error('Invalid Access', 401);

    }

    public function worker_update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'worker_id' => 'required',
            'service' => 'required',
            'name'=>'required',
            'email'=>'required|string|email|max:255|unique:franchise_workers,email,'.$id.',id,deleted_at,NULL',
            'mobile'=>'required|numeric|digits:10|unique:franchise_workers,mobile,'.$id.',id,deleted_at,NULL',
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }

        $worker_id = $request->worker_id;
        $worker = Franchise_worker::where('id',$worker_id)->first();

        if($worker){
            $worker->name = $request->name;
            $worker->email = $request->email;
            $worker->mobile = $request->mobile;

            if(!empty($request->service)){

                $worker_service = Worker_service::where('worker_id',$worker_id)->pluck('service_id')->toArray();
                $services_id = $request->service;
    
                $data = [];
                foreach($services_id as $service_id) {
                    if(!in_array($service_id, $worker_service)){
                        //echo   $service_id;
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
                    $delete_Worker_services = Worker_service::whereIn('service_id', $deletable)->where('worker_id',$worker_id);
                    $delete_Worker_services->delete();
                }
            }

            $worker->save();

            // $worker_service = Worker_service::where('worker_id',$worker_id)->with(['services' => function($query){
            //     $query->select('id','title');
            // }])
            // ->select('id','service_id','worker_id')
            // ->get();
            // $worker['worker_service'] = $worker_service;
            return $this->success([
                'worker' => $worker
            ]);
        }
        return $this->error('Invalid Access', 401);
    }
    
    public function worker_status(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'worker_id' => 'required',
            'status' => 'required',
        ]);
        if($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }

        $worker_id = $request->worker_id;
        $worker = Franchise_worker::where('id',$worker_id)->first();
        $status = $request->status;

        if($worker){
            
            if($status == true){
                $worker->status = 1;
            }else{
                $worker->status = 0;
            }
            
            $worker->save();

            return $this->success([
                'worker' => $worker
            ]);
        }
        return $this->error('Invalid Access', 401);
    }


}
