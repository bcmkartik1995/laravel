<?php

namespace App\Http\Controllers\Worker;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Package;
use App\Package_service;
use App\Service;
use App\Category;
use App\SubCategory;
use App\Country;
use App\State;
use App\City;
use App\Lead;
use App\Orders;
use App\Franchises_order;
use App\Package_subcategory;
use App\Order_tracks;
use App\Ordered_services;
use App\Worker_assigned_services;
use App\Franchise_worker;
use App\Notification;
use App\Models\Role;
use App\Models\Admin;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;

class AjaxController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:worker');
    }


    public function get_notification()
    {
        ////////////////pending create new table
        $user_id = Auth::guard('worker')->user()->id;

        $notification = Notification::where(['user_id'=>$user_id,'is_read'=>0,'is_worker'=>1])->get();
        
        // /$myDate = '12/08/2020';
        // echo '<pre>';
        // print_R($notification);die;
        //return response()->json($notification);
        return json_encode(array('data'=>$notification));
    }

    public function read_notification(Request $request)
    {
        $user_id = Auth::guard('worker')->user()->id;
        
        if($request->read_action == 'all'){
            Notification::where(['user_id' => $user_id, 'type' => 'new order', 'is_read' => 0, 'is_worker' => 1])->update(['is_read' => 1]);
            return response()->json(['success' => 1, 'message' => 'Notifications readed.']);
        } else if($request->read_action == 'single'){
            $id = $request->id;
            Notification::where(['id' => $id])->update(['is_read' => 1]);
            return response()->json(['success' => 1, 'message' => 'Notification readed.']);
        }else{
            return response()->json(['success' => 0, 'message' => 'Invalid access']);
        }
    }

}
