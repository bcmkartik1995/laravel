<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Orders;
use App\User;
use App\Package;
use App\Package_service;
use App\Franchises_order;
use App\Franchise;
use App\Models\Admin;
use App\Worker_assigned_services;
use App\City;
use App\Notification;
use Illuminate\Http\Response;
use App\Order_Details;
use App\Ordered_services;
use App\Service;
use Datatables;
use Carbon\Carbon;
use Auth;
use App\Franchise_plans;
use App\Franchise_worker;

class UnallocatorderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function datatables(Request $request)
    {

        $datas = Orders::orderBy('id','desc')->where('orders.is_fully_allocated','=',0);

        if(isset($request->searchByFromdate) && !empty($request->searchByFromdate)){

            $datefrom =Carbon::createFromFormat('d/m/Y', $request->searchByFromdate)->format('Y-m-d');
            $datas->where(DB::raw('CAST(orders.created_at as date)'), '>=', $datefrom);
        }

        if(isset($request->searchByTodate) && !empty($request->searchByTodate)){
            $dateto = Carbon::createFromFormat('d/m/Y', $request->searchByTodate)->format('Y-m-d');
            $datas->where(DB::raw('CAST(orders.created_at as date)'), '<=', $dateto);
        }

        if(isset($request->searchBystatus) && !empty($request->searchBystatus)){

            $datas->where('orders.status',$request->searchBystatus);
        }

        if(isset($request->searchByfranchise) && !empty($request->searchByfranchise)){

            $datas->join('franchises_orders as fo', 'fo.orders_id', '=', 'orders.id')
            ->where('fo.franchises_id',$request->searchByfranchise)
            ->select('orders.id','orders.customer_name','orders.order_number','orders.totalQty','orders.pay_amount','orders.status');
        }

        if(isset($request->searchByCity) && !empty($request->searchByCity)){
            $datas->join('user_addresses as ua', 'ua.id', '=', 'orders.customer_address_id')
            ->where('ua.city',$request->searchByCity)
            ->select('orders.id','orders.customer_name','orders.order_number','orders.totalQty','orders.pay_amount','orders.status');
        }

        if(isset($request->searchByService) && !empty($request->searchByService)){
            $datas->join('ordered_services as os', 'os.order_id', '=', 'orders.id')
            ->where('os.service_id',$request->searchByService)
            ->select('orders.id','orders.customer_name','orders.order_number','orders.totalQty','orders.pay_amount','orders.status');
        }

        $datas = $datas->groupBy('orders.id')->leftJoin('user_addresses as mua', 'mua.id', '=', 'orders.customer_address_id')
        ->select('orders.id','orders.customer_name','orders.order_number','orders.totalQty','orders.pay_amount','orders.status','mua.city','unallocated')->get();

        return Datatables::of($datas)
            ->addColumn('cities', function($data){
                if($data->city == ''){
                    return '-';
                }else{
                    return $data->city;
                }
            })
            ->addColumn('action', function(Orders $data) {

                $html = '<div class="dropdown"><span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span><div class="dropdown-menu dropdown-menu-right">';

                if(Auth::guard('admin')->user()->sectionCheck('unallocated_orders_delete') || Auth::guard('admin')->user()->role_id == 0){
                    //$html .= '<a href="javascript:void(0);" data-href="'. route('unallocated-orders-delete',$data->id). '" class="dropdown-item delete"><i class="bx bx-trash mr-1"></i>Detete</a>';
                }

                if(Auth::guard('admin')->user()->sectionCheck('unallocated_orders_status') || Auth::guard('admin')->user()->role_id == 0){
                    $html .= '<a class="dropdown-item show-example-btn booking-status" data-status="'.$data->status.'" data-id="'.$data->id.'" om positioned dialog"><i class="bx bx-cog mr-1"></i>Manage Status</a>';
                }

                if(Auth::guard('admin')->user()->sectionCheck('unallocated_orders_view') || Auth::guard('admin')->user()->role_id == 0 ){
                    $html .= '<a class="dropdown-item" href="'.route('unallocated-orders-details',$data->id).'"><i class="bx bx-list-ul mr-1"></i> view</a>';
                }

                if(Auth::guard('admin')->user()->sectionCheck('unallocated_orders_assigned') || Auth::guard('admin')->user()->role_id == 0){
                    $html .= '<a class="dropdown-item" href="'.route('unallocated-franchise-assign-order',$data->id).'"><i class="bx bxs-buildings mr-1"></i> Assign To Franchise</a>';
                }

                if(Auth::guard('admin')->user()->sectionCheck('orders_invoice') || Auth::guard('admin')->user()->role_id == 0){
                    if($data->status == 'completed')
                    {
                        // $html .= '<a class="dropdown-item" href="'.route('franchises-invoice',$data->id).'"><i class="bx bx-edit-alt mr-1"></i> Invoice Details</a>';
                    }
                }
                $html .= '</div></div>';
                return $html;


                // if($data->status == 'completed'){
                //     $invoice_detail = '<a class="dropdown-item" href="'.route('franchises-invoice',$data->id).'"><i class="bx bx-edit-alt mr-1"></i> Invoice Details</a>';
                // }
                // else{
                //     $invoice_detail = '';
                // }
                // return '<div class="dropdown"><span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span><div class="dropdown-menu dropdown-menu-right"><a href="javascript:void(0);" data-href="'. route('orders-delete',$data->id). '" class="dropdown-item delete"><i class="bx bx-trash mr-1"></i>Detete</a><a class="dropdown-item show-example-btn booking-status" data-status="'.$data->status.'" data-id="'.$data->id.'" om positioned dialog"><i class="bx bx-cog mr-1"></i>Manage Status</a><a class="dropdown-item" href="'.route('orders-details',$data->id).'"><i class="bx bx-list-ul mr-1"></i> view</a>'.$invoice_detail.'</div></div>';
            })
            ->addColumn('ordered_services', function($data){
                $ordered_services = [];
                if(!empty($data->unallocated['packages'])){
                    foreach($data->unallocated['packages'] as $package){
                        $ordered_services[] = $package['title'];
                    }
                }
                if(!empty($data->unallocated['services'])){
                    foreach($data->unallocated['services'] as $service){
                        $ordered_services[] = $service['title'];
                    }
                }
                return implode(', ', $ordered_services);
            })
            ->rawColumns(['action','cities','ordered_services'])
            ->toJson();
    }


    public function index()
    {
        $user_id = Auth::guard('admin')->user()->id;

        //Notification::where(['user_id'=>$user_id,'type'=>'unallocated service'])->update(['is_read'=>1]);

        $franchises = Franchise::get();

        $cities = City::where(['status' => 1])->select(['id','name'])->get();

        $services = Service::where(['status' => 1])->select(['id','title'])->get();

        return view('admin.Orders.unallocated_order.index',compact('franchises','cities','services'));
    }

    public function delete($id)
    {
        $unallocated_order = Orders::findOrFail($id);
        $unallocated_order->delete();
        return response()->json(['success' => 1, 'message' => 'Data Deleted successfully']);
    }

    public function show_orders($id)
    {
        $booking = Orders::with(['user' => function ($query) {
            $query->select('name','id');
        }])
        ->where('id',$id)
        ->first();

        return view('admin.Orders.unallocated_order.view',compact('booking'));
    }

    public function franchise_assign_order($id)
    {
        $unallocated_orders = Orders::findOrFail($id);

        $franchises = Franchise::where(['franchises.status'=>1])
            ->select('franchises.id','franchises.franchise_name')
            ->leftjoin("franchise_plans as fp", function ($join) {
                $join->on('franchises.id', '=', 'fp.franchise_id')->where(['fp.deleted_at' => NULL]);
            })
            ->where(function($query){
                $query->whereRaw('(end_date >= CURDATE() OR is_custom = 1)')->where('fp.remain_credits', '>',0)->where('fp.status', '=',1);
            })
            ->groupBy('franchises.id')
        ->get();

        return view('admin.Orders.unallocated_order.assign_order',compact('unallocated_orders','franchises'));
    }

    public function unallocated_order_assign_worker(Request $request ,$id)
    {
        // echo '<pre>';
        // print_R($request->all());die;
        $request->validate([
            'franchise_id' => 'required',
            'worker_id' => 'required',
            'date' => 'required',
            'time' => 'required',
        ]);


        $franchise_id = $request->franchise_id;

        $unallocated_orders = Orders::findOrFail($id);

        $unallocated_order_detail = $unallocated_orders->unallocated;
        $unallocated = $unallocated_orders->cart;

        $franchise_order = Franchises_order::where(['orders_id' => $id, 'franchises_id' => $franchise_id])->first();
        $franchise_order_details = [];
        if($franchise_order){
            if(!empty($franchise_order->order_details['packages'])){
                foreach($franchise_order->order_details['packages'] as $order_detail){
                    $franchise_order_details['packages'][$order_detail['id']] = $order_detail;
                }
            }

        }

        if($request->type == "service"){
            $service_id = $request->service_id;
            if(!empty($unallocated_order_detail['services'])){
                foreach($unallocated_order_detail['services'] as $service){
                    if($service['id'] == $service_id){
                        $unallocated_service = $service;

                        unset($unallocated_order_detail['services'][$service_id]);

                        if(empty($unallocated_order_detail['services'])){
                            unset($unallocated_order_detail['services']);
                        }

                        $service_detail = $service;

                        $service_hour = $service['hour'];
                        $service_minite = $service['minute'];
                        $service_quantity = $service['quantity'];

                        $time_required = 0; // in minute

                        if(!empty($service_hour)){
                            $time_required += $service_hour * 60;
                        }
                        if(!empty($service_minite)){
                            $time_required += $service_minite;
                        }

                        $time_required = $time_required * $service['quantity'];

                        $date = $request->date;
                        $time = $request->time;

                        $start_time = Carbon::createFromFormat('d/m/Y H:i A',$date .' '. $time)->format('Y-m-d H:i:s');
                        $end_time = Carbon::createFromFormat('d/m/Y H:i A',$date .' '. $time)->addMinute($time_required)->format('Y-m-d H:i:s');

                        $worker_id = $request->worker_id;
                        $service_detail['take_time'] = $time_required;
                        $service_detail['start_time'] = $start_time;
                        $service_detail['end_time'] = $end_time;
                        $service_detail['assiged_to_workers'][$worker_id] = $service_detail;
                        $franchise_order_details['services'][] = $service_detail;

                        if(!empty($franchise_id)){

                            if(empty($franchise_order)){
                                $franchise_order = new Franchises_order;

                                $Franchise_plan = Franchise_plans::where(['franchise_id' => $franchise_id])->where('remain_credits', '>',0)->whereRaw('(end_date >= CURDATE() OR is_custom = 1)')->first();
                                $Franchise_plan->remain_credits = $Franchise_plan->remain_credits - 1;
                                $Franchise_plan->save();
                            }
                            $franchise_order->franchises_id = $franchise_id;
                            $franchise_order->orders_id = $unallocated_orders->id;
                            $franchise_order->order_details = $franchise_order_details;
                            $franchise_order->take_time = $time_required;
                            $franchise_order->start_time = $start_time;
                            $franchise_order->end_time = $end_time;

                            $franchise_order->save();

                            $worker_order_assign = new Worker_assigned_services;
                            $worker_order_assign->worker_id = $worker_id;
                            $worker_order_assign->order_id = $unallocated_orders->id;
                            $worker_order_assign->f_order_id = $franchise_order->id;
                            $worker_order_assign->service_id = $service_id;
                            $worker_order_assign->take_time = $time_required;
                            $worker_order_assign->start_time = $start_time;
                            $worker_order_assign->end_time = $end_time;

                            $worker_order_assign->save();

                            Ordered_services::where(['order_id'=>$franchise_order->orders_id,'package_id'=>null,'service_id'=>$service_id])->update(['is_allocated'=>1]);
                        }
                    }
                }
            }
        } else {

            $package_id = $request->package_id;
            $package_service_id = $request->service_id;
            if(!empty($unallocated_order_detail['packages'])){
                foreach($unallocated_order_detail['packages'] as $package){
                    if($package['id'] == $package_id){
                        foreach($package['package_service'] as $package_servcie){
                            if($package_servcie['id'] == $package_service_id){

                                $unallocated_package = $package_servcie;

                                unset($unallocated_order_detail['packages'][$package_id]['package_service'][$package_service_id]);

                                if(empty($unallocated_order_detail['packages'][$package_id]['package_service'])){
                                    unset($unallocated_order_detail['packages'][$package_id]);
                                }

                                $package_detail = $package;
                                unset($package_detail['package_service']);

                                $package_service_hour = $package_servcie['hour'];
                                $package_service_minite = $package_servcie['minute'];
                                $package_service_quantity = $package['quantity'];

                                $time_required = 0; // in minute

                                if(!empty($package_service_hour)){
                                    $time_required += $package_service_hour * 60;
                                }
                                if(!empty($package_service_minite)){
                                    $time_required += $package_service_minite;
                                }

                                $time_required = $time_required *  $package['quantity'];

                                $date = $request->date;
                                $time = $request->time;

                                $start_time = Carbon::createFromFormat('d/m/Y H:i A',$date .' '. $time)->format('Y-m-d H:i:s');

                                $end_time = Carbon::createFromFormat('d/m/Y H:i A',$date .' '. $time)->addMinute($time_required)->format('Y-m-d H:i:s');

                                $worker_id = $request->worker_id;

                                //time add in package
                                $package_detail['take_time'] = $time_required;
                                $package_detail['start_time'] = $start_time;
                                $package_detail['end_time'] = $end_time;

                                //time add in package service
                                $unallocated_package['take_time'] = $time_required;
                                $unallocated_package['start_time'] = $start_time;
                                $unallocated_package['end_time'] = $end_time;

                                $package_detail['package_service'][]= $unallocated_package;


                                if(!isset($franchise_order_details['packages'][$package_id])){
                                    $franchise_order_details['packages'][$package_id] = $package_detail;
                                }else{
                                    $franchise_order_details['packages'][$package_id]['package_service'][] = $unallocated_package;
                                }

                                if(isset($franchise_order_details['packages'][$package_id]['assiged_to_workers'][$worker_id])){
                                    $franchise_order_details['packages'][$package_id]['assiged_to_workers'][$worker_id]['package_service'][] = $unallocated_package;
                                }else{
                                    $franchise_order_details['packages'][$package_id]['assiged_to_workers'][$worker_id] = $package_detail;
                                }

                                $franchise_order_details['packages'] = array_values($franchise_order_details['packages']);
                                if(!empty($franchise_id) ){

                                    if(empty($franchise_order)){
                                        $franchise_order = new Franchises_order;

                                        $Franchise_plan = Franchise_plans::where(['franchise_id' => $franchise_id])->where('remain_credits', '>',0)->whereRaw('(end_date >= CURDATE() OR is_custom = 1)')->first();
                                        $Franchise_plan->remain_credits = $Franchise_plan->remain_credits - 1;
                                        $Franchise_plan->save();
                                    }

                                    $franchise_order->franchises_id = $franchise_id;
                                    $franchise_order->orders_id = $unallocated_orders->id;
                                    $franchise_order->order_details = $franchise_order_details;
                                    $franchise_order->take_time = $time_required;
                                    $franchise_order->start_time = $start_time;
                                    $franchise_order->end_time = $end_time;

                                    $franchise_order->save();

                                    $worker_order_assign = new Worker_assigned_services;
                                    $worker_order_assign->worker_id = $worker_id;
                                    $worker_order_assign->order_id = $unallocated_orders->id;
                                    $worker_order_assign->f_order_id = $franchise_order->id;
                                    $worker_order_assign->is_package = 1;
                                    $worker_order_assign->package_id = $package_id;
                                    $worker_order_assign->service_id = $package_service_id;
                                    $worker_order_assign->take_time = $time_required;
                                    $worker_order_assign->start_time = $start_time;
                                    $worker_order_assign->end_time = $end_time;

                                    $worker_order_assign->save();

                                    Ordered_services::where(['order_id'=>$franchise_order->orders_id,'package_id'=>$package_id,'service_id'=>$package_service_id])->update(['is_allocated'=>1]);
                                }
                            }
                        }
                    }
                }
                if(empty($unallocated_order_detail['packages'])){
                    unset($unallocated_order_detail['packages']);
                }

            }
        }

        // ---------------------------- For Franchise Notification Start-------------------------------------// 
        $users = $request->franchise_id;

        $franchise_info = Franchise::where('id',$users)->select('user_id')->get();

        $franchise_users_ids = Admin::whereIn('id',$franchise_info)->select('id')->first();

        $notification = new Notification;
        $notification->order_id = $unallocated_orders->id;
        $notification->user_id = $franchise_users_ids->id;
        $notification->f_order_id = $franchise_order->id;
        $notification->is_package = isset($worker_order_assign->is_package) ? $worker_order_assign->is_package : 0;
        $notification->package_id = isset($worker_order_assign->package_id) ? $worker_order_assign->package_id : 0;
        $notification->service_id = isset($worker_order_assign->service_id) ? $worker_order_assign->service_id : 0;
        $notification->is_franchise = 1;
        $notification->type = 'new order';
        $notification->message = 'New order arrived';
        $notification->save();

        // ---------------------------- For Franchise Notification End-------------------------------------//


        // ---------------------------- For Worker Notification Start-------------------------------------//
        $worker_users = $request->worker_id;

        $worker_user_id = Franchise_worker::where('id',$worker_users)->first();

        $notification = new Notification;
        $notification->order_id = $unallocated_orders->id;
        $notification->user_id = $worker_user_id->id;
        $notification->f_order_id = $franchise_order->id;
        $notification->is_package = isset($worker_order_assign->is_package) ? $worker_order_assign->is_package : 0;
        $notification->package_id = isset($worker_order_assign->package_id) ? $worker_order_assign->package_id : 0;
        $notification->service_id = isset($worker_order_assign->service_id) ? $worker_order_assign->service_id : 0;
        $notification->is_worker = 1;
        $notification->type = 'new order';
        $notification->message = 'New order arrived';
        $notification->save();
        // ---------------------------- For Worker Notification Start-------------------------------------//
        
        $unallocated_orders->cart = $unallocated;

        if(empty($unallocated_order_detail['packages']) && empty($unallocated_order_detail['services'])){
            $unallocated_orders->unallocated = null;
            $unallocated_orders->is_fully_allocated = 1;
        }else{
            $unallocated_orders->unallocated = $unallocated_order_detail;
        }

        $unallocated_orders->save();

        return redirect('admin/unallocated-orders')->with('Insert_Message','Order Assign Successfully');
    }

}
