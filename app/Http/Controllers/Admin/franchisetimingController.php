<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Franchise;
use App\Franchise_timing;
use Auth;
use App\Franchise_offday;
use Carbon\Carbon;

class franchisetimingController extends Controller
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
        $franchise_time = Franchise_timing::where('franchises_id',$franchises_id->id)->get();

        $collection = collect($franchise_time);
        $franchise_time = $collection->mapWithKeys(function ($item) {
                return [$item['day'] => $item];
            })->toArray();

        $franchise_offdays = Franchise_offday::where('franchises_id',$franchises_id->id)->get();    
        return view('admin.franchises_timing.index',compact('franchise_offdays','franchise_time'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.franchises_timing.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function add_time(Request $request)
    {
        // echo '<pre>';
        // print_R($request->all());die;
        $request->validate([

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

        
        $user_id = Auth::guard('admin')->user()->id;
        $franchises_id = Franchise::where('user_id',$user_id)->first();

     
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
        

        return redirect('admin/franchises-timing')->with('Insert_Message','Data Created Successfully');
    }

    public function store(Request $request)
    {
        // echo '<pre>';
        // print_R($request->all());die;
        $request->validate([
            'offdaydate' => 'required',
        ]);

        $franchise_offday = new Franchise_offday;

        $user_id = Auth::guard('admin')->user()->id;
        $franchises_id = Franchise::where('user_id',$user_id)->first();
        $franchise_offday->franchises_id = $franchises_id->id;

        $date = Carbon::createFromFormat('d-m-Y', $request->offdaydate)->format('Y-m-d');
        $franchise_offday->off_date = $date;

        $franchise_offday->save();

        return redirect('admin/franchises-timing')->with('Insert_Message','Data Created Successfully');
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
        $franchise_offday = Franchise_offday::find($id);
        $date = Carbon::createFromFormat('Y-m-d', $franchise_offday->off_date)->format('d-m-Y');
    
        return view('admin.franchises_timing.edit',compact('franchise_offday','date'));
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
            'offdaydate' => 'required',
        ]);

        $franchise_offday = Franchise_offday::find($id);

        $franchise_offday->franchises_id = $request->input('franchises_id');

        $date = Carbon::createFromFormat('d-m-Y', $request->offdaydate)->format('Y-m-d');
        $franchise_offday->off_date = $date;

        $franchise_offday->save();

        return redirect('admin/franchises-timing')->with('update_message','Data Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $franchise_offday = Franchise_offday::find($id);
        $franchise_offday->delete();

        return response()->json(['success' => 1, 'message' => 'Data Deleted successfully']);
    }
}
