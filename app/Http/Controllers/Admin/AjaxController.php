<?php

namespace App\Http\Controllers\Admin;

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
        $this->middleware('auth:admin');
    }
    public function ajax_subcat(Request $request){
        //print_R($request->cat_id);die;
        $subcategories = SubCategory::where('category_id', $request->cat_id)->select('title','id')->get();
        //print_R($subcategories);die;
        return response()->json($subcategories);
    }
    public function edit_ajax_subcat(Request $request){
        //$cat_id = Input::get('cat_id');
        $subcategories = SubCategory::where('category_id','=',$request->cat_id)->select('title','id')->get();
        //print_R($subcategories);die;
        return response()->json($subcategories);
    }
    
    public function best_subcat(Request $request){
        
        $subcategories = SubCategory::where('category_id', $request->cat_id)->select('title','id')->get();
        return response()->json($subcategories);
    }

    public function best_service(Request $request){
        
        $subcategories = Service::where('sub_category_id', $request->cat_id)->select('title','id')->get();
        return response()->json($subcategories);
    }

    public function package_subcat(Request $request){
      
        $package_id = isset($request->package_id) && !empty($request->package_id) ? $request->package_id : null;
        $sub_category_id = [];
        if($package_id){
            $sub_category_id = Package_subcategory::where('package_id', $package_id)->pluck('sub_category_id')->toArray();
        }
        
        $subcategories = SubCategory::whereIn('category_id', $request->cat_id)->select('title','id')
        ->get()
        ->map(function($query) use($sub_category_id){
            $query->selected = in_array($query->id, $sub_category_id) ? true : false;
            return $query;
        });
        //print_R($subcategories);die;
        return response()->json($subcategories);
    }
    
    public function package_service(Request $request){
        //print_R($request->all());die;
        $package_id = isset($request->package_id) && !empty($request->package_id) ? $request->package_id : null;
        $service_id = [];
        if($package_id){
            $service_id = Package_service::where('package_id', $package_id)->pluck('service_id')->toArray();
        }
       
        $service = Service::whereIn('sub_category_id',$request->cat_id)->select('title','id')
        ->get()
        ->map(function($query) use($service_id){
            $query->selected = in_array($query->id, $service_id) ? true : false;
            return $query;
        });
        
        return response()->json($service);
    }

    public function offer_subcat(Request $request){
        //$cat_id = Input::get('cat_id');
        $subcategories = SubCategory::where('category_id','=',$request->cat_id)->select('title','id')->get();
        //print_R($subcategories);die;
        return response()->json($subcategories);
    }

    public function offer_service(Request $request){
        //$cat_id = Input::get('cat_id');
        $subcategories = Service::where('sub_category_id','=',$request->cat_id)->select('title','id')->get();
        //print_R($subcategories);die;
        return response()->json($subcategories);
    }

    public function franchises_subcat(Request $request){
        //$cat_id = Input::get('cat_id');
        $subcategories = SubCategory::where('category_id','=',$request->cat_id)->select('title','id')->get();
        //print_R($subcategories);die;
        return response()->json($subcategories);
    }

    public function ajax_country(Request $request){
       
        $state = State::where('country_id','=',$request->country_id)->get();
        //print_R($state);die;
        return response()->json($state);
    }

    public function ajax_state(Request $request){
       
        $city = City::where('state_id','=',$request->state_id)->get();
        //print_R($city);die;
        return response()->json($city);
    }

    public function lead_status(Request $request){
        $leads = Lead::find($request->id);
        $leads->status = $request->action;
        // print_R($leads);die;
        $leads->update();
        return response()->json($leads);
    }

    public function orders_status(Request $request){
        
        $bookings = Orders::find($request->id);
        $bookings->status = $request->status;
        //print_R($bookings);die;
        $bookings->update();

        $track_title = $progress_text = null;
        if($request->status == 'processing'){
            $track_title = 'Processing';
            $progress_text = "Your order status has been change to processing.";
        }elseif($request->status == 'completed'){
            $track_title = 'Completed';
            $progress_text = "Your order status has been completed.";
        }elseif($request->status == 'declined'){
            $track_title = 'Declined';
            $progress_text = "Your order status has been declined.";
        }elseif($request->status == 'on delivery'){
            $track_title = 'On delivery';
            $progress_text = "Your order status has been on delivery.";
        }elseif($request->status == 'cancelled'){
            $track_title = 'Cancelled';
            $progress_text = "Your order status has been cancelled.";
        }

        
        $track = new Order_tracks;
        $track->title = $track_title;
        $track->order_status = $request->status;
        $track->text = $progress_text;
        $track->order_id = $request->id;
        $track->save();

        return response()->json($bookings);
    }
    public function franchises_orders(Request $request){

        $franchises_orders = Franchises_order::find($request->id);
        $franchises_orders->status = $request->action;
        //print_R($franchises_orders);die;
        $franchises_orders->update();
        return response()->json($franchises_orders);
    }

    public function franchise_subcat(Request $request){
        //print_R($request->cat_id);die;
        
        $subcategories = SubCategory::where('category_id', $request->cat_id)->select('title','id')->get();
        //print_R($subcategories);die;
        return response()->json($subcategories);
    }

    

    public function franchise_package_sub(Request $request){
      
        $package_id = isset($request->package_id) && !empty($request->package_id) ? $request->package_id : null;
        $sub_category_id = [];
        if($package_id){
            $sub_category_id = Package_subcategory::where('package_id', $package_id)->pluck('sub_category_id')->toArray();
        }
        
        $subcategories = SubCategory::whereIn('category_id', $request->cat_id)->select('title','id')
        ->get()
        ->map(function($query) use($sub_category_id){
            $query->selected = in_array($query->id, $sub_category_id) ? true : false;
            return $query;
        });
        //print_R($subcategories);die;
        return response()->json($subcategories);
    }


    public function franchise_package_service(Request $request){
        //print_R($request->all());die;
        $package_id = isset($request->package_id) && !empty($request->package_id) ? $request->package_id : null;
        $service_id = [];
        if($package_id){
            $service_id = Package_service::where('package_id', $package_id)->pluck('service_id')->toArray();
        }
       
        $service = Service::whereIn('sub_category_id',$request->cat_id)->select('title','id')
        ->get()
        ->map(function($query) use($service_id){
            $query->selected = in_array($query->id, $service_id) ? true : false;
            return $query;
        });
        
        return response()->json($service);
    }
    
    public function franchise_offer_subcat(Request $request){
        //$cat_id = Input::get('cat_id');
        $subcategories = SubCategory::where('category_id','=',$request->cat_id)->select('title','id')->get();
        //print_R($subcategories);die;
        return response()->json($subcategories);
    }

    public function franchise_offer_service(Request $request){
        //$cat_id = Input::get('cat_id');
        $subcategories = Service::where('sub_category_id','=',$request->cat_id)->select('title','id')->get();
        //print_R($subcategories);die;
        return response()->json($subcategories);
    }

    public function franchise_ajax_country(Request $request){
       
        $state = State::where('country_id','=',$request->country_id)->get();
        //print_R($state);die;
        return response()->json($state);
    }

    public function franchise_ajax_state(Request $request){
       
        $city = City::where('state_id','=',$request->state_id)->get();
        //print_R($city);die;
        return response()->json($city);
    }

    public function franchises_worker(Request $request){
       
        $id = $request->id;
        $worker_order_status = Worker_assigned_services::find($id);
        
        $worker_order_status->status = $request->status;
        $worker_order_status->save();
        
        $franchise_order_id = $worker_order_status->f_order_id;
        
        $franchises_order = Franchises_order::find($franchise_order_id);

        if($request->status == 1 && $franchises_order->status == 0){
            
            $franchises_order->status = 1;
            $franchises_order->save();
        }

        if($request->status == 2)
        {
            $order_detail = $franchises_order->order_details;
            $order = Orders::find($franchises_order->orders_id);
           
            // echo '<pre>';
            // print_R($order->user_id);die;
            //$roles = Role::all();

            $user_ids = [];
            $users = Admin::all();

            foreach($users as $user){
               // echo '<pre>'; print_R($user->role);die;
               if($user->id == 1){
                $user_ids[] = $user->id;
               }else{
                    $sections = explode(" , ",$user->role->section);
                    if (in_array('orders', $sections)){
                        $user_ids[] = $user->id;
                    }
               }
            }

           
            if(!empty($user_ids)){
                
                $order_id = $order->id;
                $type = 'unallocated service';
                $message = 'Unallocated service found';
                $f_order_id = $worker_order_status->f_order_id;
                $is_package = $worker_order_status->is_package;
                $package_id = $worker_order_status->package_id;
                $service_id = $worker_order_status->service_id;
    
                $data = [];
                foreach($user_ids as $user_id){
                    $data[] = [
                        'user_id' => $user_id,
                        'order_id' => $order_id,
                        'type' => $type,
                        'f_order_id' => $f_order_id,
                        'is_package' => $is_package,
                        'package_id' => $package_id,
                        'service_id' => $service_id,
                        'message' => $message
                    ];
                }

                Notification::insert($data);
            }

            $order_cart = $order->cart;
            
            $unallocated_service = null;
            $unallocated_package = null;
            if($worker_order_status->is_package == 0){ // service check
                $service_id = $worker_order_status->service_id;
                if(!empty($order_detail['services'])){
                    foreach($order_detail['services'] as $s => $service){
                        if($service['id'] == $service_id){
                            $unallocated_service = $service;
                            unset($unallocated_service['assiged_to_workers']);
                            unset($order_cart['services'][$service_id]);
                            unset($order_detail['services'][$s]);
                            
                        }
                    }
                }
            }else{// package check
                $package_id = $worker_order_status->package_id;
                $service_id = $worker_order_status->service_id;

                if(!empty($order_detail['packages'])){
                    foreach($order_detail['packages'] as $p => $package){
                        if($package['id'] == $package_id){
                            foreach($package['package_service'] as $k => $package_service){
                                if($package_service['id'] == $service_id){
                                    $unallocated_package = $package;
                                    // echo '<pre>';
                                    // print_R($unallocated_package);die;
                                    // echo '<pre>';
                                    // print_R($order_detail['packages'][$package_id]['package_service'][$package_service['id']]);die;
                                    unset($unallocated_package['assiged_to_workers']);
                                    unset($unallocated_package['package_service']);
                                    unset($order_cart['packages'][$package_id][$service_id]);
                                    // echo '<pre>';
                                    // print_R($order_cart);die;
                                    unset($order_cart['packages'][$package_id]['package_service'][$package_service['id']]);
                                    
                                    //unset($order_detail[$package]['package_service'][$package_service]);
                                    
                                    unset($order_detail['packages'][$p]['package_service'][$k]);
                                    $order_detail['packages'][$p]['package_service'] = array_values($order_detail['packages'][$p]['package_service']);

                                    foreach($package['assiged_to_workers'] as $aw => $assiged_to_workers){
                                        unset($order_detail['packages'][$p]['assiged_to_workers'][$aw]['package_service'][$k]);
                                        $order_detail['packages'][$p]['assiged_to_workers'][$aw]['package_service'] = array_values($order_detail['packages'][$p]['assiged_to_workers'][$aw]['package_service']);
                                    }

                                    $unallocated_package['package_service'][] = $package_service;
                                }
                            }
                        }
                    }
                }
            }

            
            $unallocated = $order->unallocated;
            
            if($unallocated == ''){
                $unallocated = [];
            }
            if(isset($unallocated_service)){
                $unallocated['services'][] = $unallocated_service;
                
            }else{
                $unallocated['packages'][] = $unallocated_package;
            }

            if(empty($order_detail['services'])){
                unset($order_detail['services']);
            }

            if(empty($order_detail['packages'])){
                unset($order_detail['packages']);
            }
            
            if(empty($order_detail['services']) && empty($order_detail['packages'])){
                Worker_assigned_services::where('f_order_id',$franchises_order->id)->delete();
                $franchises_order->delete();
            }

            if(isset($order_detail['services']) || isset($order_detail['packages'])){
                $franchises_order->order_details = $order_detail;
                $franchises_order->save();
            }
          
            $order->unallocated = $unallocated;

            $order->cart = $order_cart;
            $order->is_fully_allocated = 0;
            
            $order->save();

            $unallocated_order_service = $order->unallocated;
            

            if(!empty($unallocated_order_service['services'])){
                foreach($unallocated_order_service['services'] as $service){
                    if($service['id'] == $service_id){
                        Ordered_services::where(['order_id'=>$franchises_order->orders_id,'package_id'=>null,'service_id'=>$service['id']])->update(['is_allocated'=>0]);
                    }
                }
            }else{
                foreach($unallocated_order_service['packages'] as $package){
                    if($package['id'] == $package_id){
                        foreach($package['package_service'] as $package_service){
                            if($package_service['id'] == $service_id){
                                Ordered_services::where(['order_id'=>$franchises_order->orders_id,'package_id'=>$package['id'],'service_id'=>$package_service['id']])->update(['is_allocated'=>0]);
                            }
                        }
                    }
                }
            }
            

        }
        
        return response()->json($worker_order_status);
    }

    public function get_notification()
    {
        $user_id = Auth::guard('admin')->user()->id;
        
        $notification = Notification::where(['user_id'=>$user_id,'is_read'=>0,'is_worker'=>0])->get();
        
        // /$myDate = '12/08/2020';
        // echo '<pre>';
        // print_R($notification);die;
        //return response()->json($notification);
        return json_encode(array('data'=>$notification));
    }

    public function read_notification(Request $request) {

        $user_id = Auth::guard('admin')->user()->id;
        if($request->read_action == 'all'){
            Notification::where(['user_id' => $user_id, 'type' => 'new order', 'is_read' => 0])->update(['is_read' => 1]);
            return response()->json(['success' => 1, 'message' => 'Notifications readed.']);
        } else if($request->read_action == 'single'){
            $id = $request->id;
            Notification::where(['id' => $id])->update(['is_read' => 1]);
            return response()->json(['success' => 1, 'message' => 'Notification readed.']);
        }else{
            return response()->json(['success' => 0, 'message' => 'Invalid access']);
        }
    }

    public function ajax_franchise_assign(Request $request)
    {
        $franchise_worker = Franchise_worker::where('franchises_id', $request->franchise_id)->select('name','id')->get();
        
        // echo '<pre>';
        // print_R($franchise_worker);
        return response()->json($franchise_worker);
    }
    
}