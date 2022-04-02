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
use App\Franchise_timing;
use App\Franchise_offday;

class FranchisetimingController extends Controller
{
    use ApiResponser;

    public function franchise_timing(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
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

                $franchise_time = Franchise_timing::where('franchises_id',$franchise_id)->get();

                if($franchise_time->count() > 0){
                    return $this->success([
                        'franchise_time' => $franchise_time
                    ]);
                }else{
                    return $this->error('No record found', 401);
                }
            }else{
                return $this->error('Franchise not found', 401);
            }
        }
        return $this->error('Invalid Access', 401);

    }

    public function franchise_timing_store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'monday' => 'sometimes',
            'mon_open_time'       => 'required_with:monday,on',
            'mon_close_time'       => 'required_with:monday,on',

            'tuesday' => 'sometimes',
            'tue_open_time'       => 'required_with:tuesday,on',
            'tue_close_time'       => 'required_with:tuesday,on',

            'wednesday' => 'sometimes',
            'wed_open_time'       => 'required_with:wednesday,on',
            'wed_close_time'       => 'required_with:wednesday,on',

            'thursday' => 'sometimes',
            'thu_open_time'       => 'required_with:thursday,on',
            'thu_close_time'       => 'required_with:thursday,on',

            'friday' => 'sometimes',
            'fri_open_time'       => 'required_with:friday,on',
            'fri_close_time'       => 'required_with:friday,on',

            'saturday' => 'sometimes',
            'sat_open_time'       => 'required_with:saturday,on',
            'sat_close_time'       => 'required_with:saturday,on',

            'sunday' => 'sometimes',
            'sun_open_time'       => 'required_with:sunday,on',
            'sun_close_time'       => 'required_with:sunday,on',

        ]);
        
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }

        $user_id = $request->user_id;
        $user = Admin::find($user_id);

        if($user){
            $franchises_id = Franchise::where(['user_id' => $user_id])->first();
            if($franchises_id){
                
                $franchise_timings = Franchise_timing::where('franchises_id',$franchises_id->id)->pluck('day')->toArray();
                
                $data = [];
                if(!empty($request->monday)){
                    if(!in_array($request->monday, $franchise_timings)){
                        $data[] = [
                            'day' => $request->input('monday'),
                            'open_time' => $request->input('mon_open_time'),
                            'close_time' => $request->input('mon_close_time'),
                            'franchises_id' => $franchises_id->id
                        ];
                    }
                    if(in_array($request->monday, $franchise_timings)){
                        Franchise_timing::where(['franchises_id'=> $franchises_id->id,'day' => $request->monday])->update(['open_time' => $request->input('mon_open_time') ,'close_time' => $request->input('mon_close_time')]);    
                    }
                    $franchise_timings = array_diff($franchise_timings, [$request->monday]);         
                }
                
        
                if(!empty($request->tuesday)){
                    if(!in_array($request->tuesday, $franchise_timings)){
                        $data[] = [
                            'day' => $request->input('tuesday'),
                            'open_time' => $request->input('tue_open_time'),
                            'close_time' => $request->input('tue_close_time'),
                            'franchises_id' => $franchises_id->id
                        ];
                    }
                    if(in_array($request->tuesday, $franchise_timings)){
                        Franchise_timing::where(['franchises_id'=> $franchises_id->id,'day' => $request->tuesday])->update(['open_time' => $request->input('tue_open_time') ,'close_time' => $request->input('tue_close_time')]);    
                    }
                    $franchise_timings = array_diff($franchise_timings, [$request->tuesday]);
                }
        
                if(!empty($request->wednesday) ){
                    if(!in_array($request->wednesday, $franchise_timings)){
                        $data[] = [
                            'day' => $request->input('wednesday'),
                            'open_time' => $request->input('wed_open_time'),
                            'close_time' => $request->input('wed_close_time'),
                            'franchises_id' => $franchises_id->id
                        ];
                    }
                    if(in_array($request->wednesday, $franchise_timings)){
                        Franchise_timing::where(['franchises_id'=> $franchises_id->id,'day' => $request->wednesday])->update(['open_time' => $request->input('wed_open_time') ,'close_time' => $request->input('wed_close_time')]);    
                    }
                    $franchise_timings = array_diff($franchise_timings, [$request->wednesday]);
                }
        
                if(!empty($request->thursday)){
                    if(!in_array($request->thursday, $franchise_timings)){
                        $data[] = [
                            'day' => $request->input('thursday'),
                            'open_time' => $request->input('thu_open_time'),
                            'close_time' => $request->input('thu_close_time'),
                            'franchises_id' => $franchises_id->id
                        ];
                    }
                    if(in_array($request->thursday, $franchise_timings)){
                        Franchise_timing::where(['franchises_id'=> $franchises_id->id,'day' => $request->thursday])->update(['open_time' => $request->input('thu_open_time') ,'close_time' => $request->input('thu_close_time')]);
                    }
                    $franchise_timings = array_diff($franchise_timings, [$request->thursday]);
                }
        
                if(!empty($request->friday)){
                    if(!in_array($request->friday, $franchise_timings)){
                        $data[] = [
                            'day' => $request->input('friday'),
                            'open_time' => $request->input('fri_open_time'),
                            'close_time' => $request->input('fri_close_time'),
                            'franchises_id' => $franchises_id->id
                        ];
                    }
                    if(in_array($request->friday, $franchise_timings)){
                        Franchise_timing::where(['franchises_id'=> $franchises_id->id,'day' => $request->friday])->update(['open_time' => $request->input('fri_open_time') ,'close_time' => $request->input('fri_close_time')]);
                    }
                    $franchise_timings = array_diff($franchise_timings, [$request->friday]);
                }
        
                if(!empty($request->saturday)){
                    if(!in_array($request->saturday, $franchise_timings)){
                        $data[] = [
                            'day' => $request->input('saturday'),
                            'open_time' => $request->input('sat_open_time'),
                            'close_time' => $request->input('sat_close_time'),
                            'franchises_id' => $franchises_id->id
                        ];
                    }
                    if(in_array($request->saturday, $franchise_timings)){
                        Franchise_timing::where(['franchises_id'=> $franchises_id->id,'day' => $request->saturday])->update(['open_time' => $request->input('sat_open_time') ,'close_time' => $request->input('sat_close_time')]);
                    }
                    $franchise_timings = array_diff($franchise_timings, [$request->saturday]);
                }
        
                if(!empty($request->sunday)){
                    if(!in_array($request->sunday, $franchise_timings)){
                        $data[] = [
                            'day' => $request->input('sunday'),
                            'open_time' => $request->input('sun_open_time'),
                            'close_time' => $request->input('sun_close_time'),
                            'franchises_id' => $franchises_id->id
                        ];
                    }
                    if(in_array($request->sunday, $franchise_timings)){
                        Franchise_timing::where(['franchises_id'=> $franchises_id->id,'day' => $request->sunday])->update(['open_time' => $request->input('sun_open_time') ,'close_time' => $request->input('sun_close_time')]);
                    }
                    $franchise_timings = array_diff($franchise_timings, [$request->sunday]);
                }
        
                if(!empty($franchise_timings)){
                    
                    $delete_service_city = Franchise_timing::whereIn('day', $franchise_timings)->where('franchises_id',$franchises_id->id);
                    $delete_service_city->delete();
                }
                
                
                if(!empty($data)){
                    Franchise_timing::insert($data);
                }

                $franchise_time = Franchise_timing::where('franchises_id',$franchises_id->id)->get();

                return $this->success([
                    'franchise_time' => $franchise_time
                ]);
                

            }else{
                return $this->error('Franchise not found', 401);
            }
        }
        return $this->error('Invalid Access', 401);
    }

    public function franchise_offday(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
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

                $franchise_offday = Franchise_offday::where('franchises_id',$franchise_id)->get();

                if($franchise_offday->count() > 0){
                    return $this->success([
                        'franchise_offday' => $franchise_offday
                    ]);
                }else{
                    return $this->error('No record found', 401);
                }

            }else{
                return $this->error('Franchise not found', 401);
            }
        }
        return $this->error('Invalid Access', 401);
    }


    public function franchise_offday_add(Request $request)
    {
        if($request->offday_id == null || $request->offday_id == 0){
            
            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'off_date' => 'required',
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

                    $franchise_offday = new Franchise_offday;

                    $franchise_offday->franchises_id = $franchise_id;
                    $date = Carbon::createFromFormat('d/m/Y', $request->off_date)->format('Y-m-d');
                    $franchise_offday->off_date = $date;
                    $franchise_offday->save();

                    return $this->success([
                        'franchise_offday' => $franchise_offday
                    ]);

                }else{
                    return $this->error('Franchise not found', 401);
                }
            }
            return $this->error('Invalid Access', 401);

        }else{
            $validator = Validator::make($request->all(), [
                'offday_id' => 'required',
                'off_date' => 'required',
            ]);
            
            if ($validator->fails()) {
                return $this->error($validator->errors()->first(), 401);
            }
    
            $offday_id = $request->offday_id;
            $off_date = $request->off_date;
            $franchise_offday = Franchise_offday::where('id',$offday_id)->first();
    
            if($franchise_offday){
                $date = Carbon::createFromFormat('d/m/Y', $off_date)->format('Y-m-d');
                $franchise_offday->off_date = $date;
                $franchise_offday->save();
    
                return $this->success([
                    'franchise_offday' => $franchise_offday
                ]);
            }
            return $this->error('Invalid Access', 401);
        }
    }

    public function franchise_offday_edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'offday_id' => 'required',
        ]);
        
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }

        $offday_id = $request->offday_id;
        $franchise_offday = Franchise_offday::where('id',$offday_id)->first();

        if(!empty($franchise_offday)){
            return $this->success([
                'franchise_offday' => $franchise_offday
            ]);
        }else{
            return $this->error('No record found', 401);
        }
        
    }

    public function franchise_offday_update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'offday_id' => 'required',
            'off_date' => 'required',
        ]);
        
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }

        $offday_id = $request->offday_id;
        $off_date = $request->off_date;
        $franchise_offday = Franchise_offday::where('id',$offday_id)->first();

        if($franchise_offday){
            $date = Carbon::createFromFormat('d/m/Y', $off_date)->format('Y-m-d');
            $franchise_offday->off_date = $date;
            $franchise_offday->save();

            return $this->success([
                'franchise_offday' => $franchise_offday
            ]);
        }
        return $this->error('Invalid Access', 401);
    }
}
