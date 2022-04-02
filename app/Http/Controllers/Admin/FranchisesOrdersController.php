<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Stevebauman\Location\Facades\Location;
use App\Franchises_order;
use App\Orders;
use App\Order_Details;
use App\User;
use App\Franchise;
use App\Franchise_worker;
use App\Worker_assigned_services;
use App\Notification;
use PDF;
use Mail;
use Auth;
use Datatables;
use Carbon\Carbon;

class FranchisesOrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function datatables(Request $request)
    {
        $user = Auth::guard('admin')->user();
        
        $franchise_user = DB::table('franchises')
        ->where('user_id',$user->id)
        ->first();

        $franchises_orders = Franchises_order::from('franchises_orders as fo')
        ->join('orders as o','fo.orders_id','=','o.id')
        ->join('users as u','o.user_id','=','u.id')
        ->join('franchises as f','fo.franchises_id','=','f.id')    
        ->select('fo.id','fo.franchises_id','f.franchise_name','fo.orders_id','o.id as order_id','o.customer_address','o.user_id','u.name','o.pay_amount','u.latitude','u.longitude','u.ipaddress','fo.status','fo.status as status')
        ->where('fo.franchises_id',$franchise_user->id)
        ->orderBy('id', 'DESC');
        

        if(isset($request->searchByFromdate) && !empty($request->searchByFromdate)){

            $datefrom =Carbon::createFromFormat('d/m/Y', $request->searchByFromdate)->format('Y-m-d');
            $franchises_orders->where(DB::raw('CAST(fo.created_at as date)'), '>=', $datefrom);
            
        }
        if(isset($request->searchByTodate) && !empty($request->searchByTodate)){
            $dateto = Carbon::createFromFormat('d/m/Y', $request->searchByTodate)->format('Y-m-d');
            $franchises_orders->where(DB::raw('CAST(fo.created_at as date)'), '<=', $dateto);
        }
        if(isset($request->searchBystatus) && !empty($request->searchBystatus)){
            $franchises_orders->where('fo.status',$request->searchBystatus);
        }
        $datas = $franchises_orders->get();
        
        return Datatables::of($datas)
            ->addColumn('status', function(Franchises_order $data) {
                    
                if($data->status == 0){
                    return '<span class="mr-25 span-'.$data->id.'"><span class="badge badge-pill badge-light-info">Pending</span></span><button class="btn btn-secondary btn-sm show-example-btn franchises-order-status" data-id="'.$data->id.'" aria-label="Try me! Example: A custom positioned dialog">Manage Status</button>';
                }elseif($data->status == 1){
                    return '<span class="span-'.$data->id.'"><span class="badge badge-pill badge-light-success">Accept</span></span>';
                }elseif($data->status == 2){
                    return '<span class="span-'.$data->id.'"><span class="badge badge-pill badge-light-danger">Cancelled</span></span>';
                }
            })
            ->addColumn('action', function(Franchises_order $data) {

                return '<a href="'.route('franchises-order-view',$data->orders_id).'" class="btn btn-warning btn-sm mr-25">View</a>';
            }) 
            ->rawColumns(['status','action'])
            ->toJson();
    }

    public function index()
    { 

        // $user = Auth::guard('admin')->user();
        
        // $franchise_user = DB::table('franchises')
        // ->where('user_id',$user->id)
        // ->first();

        // $franchises_orders = DB::table('franchises_orders as fo')
        // ->join('orders as o','fo.orders_id','=','o.id')
        // ->join('users as u','o.user_id','=','u.id')
        // ->join('franchises as f','fo.franchises_id','=','f.id')    
        // ->select('fo.id','fo.franchises_id','f.franchise_name','fo.orders_id','o.id as order_id','o.customer_address','o.user_id','u.name','o.pay_amount','u.latitude','u.longitude','u.ipaddress','fo.status','o.status as order_status')
        // ->where('fo.franchises_id',$franchise_user->id)
        // ->orderBy('id', 'DESC')
        // ->get();
        
        // echo '<pre>';
        // print_R($franchises_orders);die;
        $user_id = Auth::guard('admin')->user()->id;

        Notification::where(['user_id'=>$user_id,'type'=>'new order'])->update(['is_read'=>1]);

        return view('admin.Franchises_order.index');
    }

    public function store(Request $request)
    {
        
        $franchises_data = Franchises_order::where(['orders_id'=> $request->orders_id, 'status' => 1])->first();
        if(!empty($franchises_data)){
            return redirect('/admin/orders')->with('delete_message','Order Aleready Completed');
        }
        $franchises_data = Franchises_order::where(['orders_id'=> $request->orders_id, 'status' => 0])->first();
       
        if(!empty($franchises_data))
        {
            $franchises_data->franchises_id = $request->input('franchises_id');
            $franchises_data->save();
        }else{
            $franchises_order = new Franchises_order;
            $franchises_order->franchises_id = $request->input('franchises_id');
            $franchises_order->orders_id = $request->input('orders_id');
            $franchises_order->save();
        }

        return redirect('/admin/orders')->with('Insert_Message','Franchises Assign Successfully');
    }

    public function franchises_assign()
    {
        $franchises_orders = DB::table('franchises_orders as fo')
        ->join('orders as o','fo.orders_id','=','o.id')
        ->join('users as u','o.user_id','=','u.id')
        ->join('franchises as f','fo.franchises_id','=','f.id')
        ->select('fo.id','fo.franchises_id','f.franchise_name','fo.orders_id','o.id as order_id','o.customer_address','o.user_id','u.name','o.pay_amount','u.latitude','u.longitude','u.ipaddress','fo.status')
        ->orderBy('id', 'DESC')
        ->paginate(10);

        return view('admin.Franchises_assigned.index',compact('franchises_orders'));
    }

    public function franchises_invoice($id)
    {
        
        
        $booking = Orders::where('orders.id',$id)
        ->join('franchises_orders as fo','fo.orders_id','=','orders.id')
        ->join('users as u','orders.user_id','=','u.id')
        ->join('franchises as f','fo.franchises_id','=','f.id')
        ->select('fo.id','fo.franchises_id','fo.status','fo.orders_id','orders.id as order_id','orders.customer_email','orders.customer_name','orders.customer_phone','orders.customer_address','orders.user_id','orders.order_number','f.address_1','f.address_2','f.franchise_name','f.email','f.mobile','u.name','orders.pay_amount','u.latitude','u.longitude','u.ipaddress','orders.cart','orders.created_at')
        ->first();

        // $bookings = Orders::where('orders.id',$id)
        // ->join('franchises_orders as fo','fo.orders_id','=','orders.id')
        // ->join('users as u','orders.user_id','=','u.id')
        // ->join('franchises as f','fo.franchises_id','=','f.id')
        // ->select('fo.id','fo.franchises_id','fo.status','fo.orders_id','orders.id as order_id','orders.customer_email','orders.customer_name','orders.customer_phone','orders.customer_address','orders.user_id','orders.order_number','f.address_1','f.address_2','f.franchise_name','f.email','f.mobile','u.name','orders.pay_amount','u.latitude','u.longitude','u.ipaddress','orders.cart','orders.created_at')
        // ->get();

        // $franchise_orders = Franchises_order::with(['f_order' => function ($query) {
        //     $query->select('orders.*');
        // }])
        // ->with(['franchise' => function ($query) {
        //     $query->select('id','franchise_name');
        // }])
        // ->where('orders_id',$id)
        // ->get();


        return view('admin.Franchises_order.invoice',compact('booking'));
    }

    public function franchises_invoice_print($id)
    {
        $booking = Orders::where('orders.id',$id)
        ->join('franchises_orders as fo','fo.orders_id','=','orders.id')
        ->join('users as u','orders.user_id','=','u.id')
        ->join('franchises as f','fo.franchises_id','=','f.id')
        ->select('fo.id','fo.franchises_id','fo.status','fo.orders_id','orders.id as order_id','orders.customer_email','orders.customer_name','orders.customer_phone','orders.customer_address','orders.user_id','orders.order_number','f.address_1','f.address_2','f.franchise_name','f.email','f.mobile','u.name','orders.pay_amount','u.latitude','u.longitude','u.ipaddress','orders.cart','orders.created_at')
        ->first();
        
        //$data = ['title' => 'Welcome to ItSolutionStuff.com'];
        //$dompdf->set_base_path("/www/public/css/");
       // return view('admin.Franchises_order.orderPdf',compact('booking'));
    //    echo '<pre>';
    //    print_R($booking);die;
        $data["order_number"]= $booking['order_number'];

        $data['custom'] = json_encode($booking);
        $pdf = PDF::loadView('admin.Franchises_order.orderPdf',$data);
        return $pdf->download($data["order_number"].'.pdf');

        //return $pdf->stream($booking->order_number.'.pdf');
    }

    public function franchises_invoice_send($id)
    {
        $booking = Orders::where('orders.id',$id)
        ->join('franchises_orders as fo','fo.orders_id','=','orders.id')
        ->join('users as u','orders.user_id','=','u.id')
        ->join('franchises as f','fo.franchises_id','=','f.id')
        ->select('fo.id','fo.franchises_id','fo.status','fo.orders_id','orders.id as order_id','orders.customer_email','orders.customer_name','orders.customer_phone','orders.customer_address','orders.user_id','orders.order_number','f.address_1','f.address_2','f.franchise_name','f.email','f.mobile','u.name','orders.pay_amount','u.latitude','u.longitude','u.ipaddress','orders.cart','orders.created_at')
        ->first()->toArray();

        $data["customer_email"]= $booking['customer_email'];

        $data['custom'] = json_encode($booking);
        $pdf = PDF::loadView('admin.Franchises_order.orderPdf',$data);
        //echo 'dsdsdsdsd';die;
        Mail::send('admin.Franchises_order.email.invoice', $data, function($message)use($data, $pdf) {
            
        $message->to($data['customer_email'])
            ->subject('Send Mail from Laravel')
            //->body('hi')
            ->attachData($pdf->output(),"test.pdf");
        });
        
        return redirect()->back()->with('Insert_Message', 'Mail sent successfully');
    }

    public function franchises_order_view($id)
    {
        $user = Auth::guard('admin')->user();
        
        $franchise_user = Franchise::where('user_id',$user->id)->pluck('id')->first();

        $booking = Orders::with(['user' => function ($query) {
            $query->select('name','id');
        }])
        ->where('id',$id)
        ->first();

        $franchise_orders = Franchises_order::with(['f_order' => function ($query) {
            $query->select('orders.*');
        }])
        ->with(['franchise' => function ($query) {
            $query->select('id','franchise_name');
        }])
        ->where([
            ['orders_id','=',$id],
            ['franchises_id', '=', $franchise_user]
        ])
        ->get();

        $franchise_workers = Franchise_worker::where(['franchises_id'=>$franchise_user])->get();

        $worker_orders = [];
        foreach($franchise_orders as $order){
            if(!empty($order->worker_orders)){
                foreach($order->worker_orders as $w_order){
                  //  print_r($w_order->worker);
                    if($w_order->is_package){
                        $worker_orders[$w_order->f_order_id]['packages'][$w_order->package_id][$w_order->service_id] = $w_order;
                    }else{
                        $worker_orders[$w_order->f_order_id]['services'][$w_order->service_id] = $w_order;
                    }
                }
            }
            
        }

        return view('admin.Franchises_order.orderview',compact('booking','franchise_orders','worker_orders','franchise_workers'));
    }

    public function franchises_order_assign_worker(Request $request, $id)
    {
        $request->validate([
            'worker_id' => 'required',
        ]);

        $worker_service_id = $request->worker_service_id;
        $old_worker_data = Worker_assigned_services::where(['id'=>$worker_service_id])->first();

        $worker_id = $request->worker_id;

        $new_worker_assign = new Worker_assigned_services;
        $new_worker_assign->worker_id = $worker_id;
        $new_worker_assign->order_id = $old_worker_data->order_id;
        $new_worker_assign->f_order_id = $old_worker_data->f_order_id;
        $new_worker_assign->is_package = $old_worker_data->is_package;
        $new_worker_assign->package_id = $old_worker_data->package_id;
        $new_worker_assign->service_id = $old_worker_data->service_id;
        $new_worker_assign->take_time = $old_worker_data->take_time;
        $new_worker_assign->start_time = $old_worker_data->start_time;
        $new_worker_assign->end_time = $old_worker_data->end_time;
        $new_worker_assign->pay_status = $old_worker_data->pay_status;

        $new_worker_assign->save();

        $old_worker_data->is_allocated = 2;
        $old_worker_data->save();

        $franchise_order = Franchises_order::where(['id'=>$old_worker_data->f_order_id])->first();
        $order_detail = $franchise_order->order_details;
        $service_id = $new_worker_assign->service_id;
        if($old_worker_data->is_package == 0 && !empty($order_detail['services'])){
            foreach($order_detail['services'] as $s => $service){
                if($service['id'] == $service_id){
                    if(!empty($service['assiged_to_workers'])){
                        $order_detail['services'][$s]['assiged_to_workers'][$worker_id] = $service['assiged_to_workers'][$old_worker_data->worker_id];
                        unset($order_detail['services'][$s]['assiged_to_workers'][$old_worker_data->worker_id]);
                    }
                }
            }
        }

        $package_id = $new_worker_assign->package_id;
        if(!empty($franchise_order->order_details['packages'])){
            foreach($franchise_order->order_details['packages'] as $p => $package){
                if($package['id'] == $package_id){
                    if(!empty($package['assiged_to_workers'])){

                        $new_package_data = $package['assiged_to_workers'][$old_worker_data->worker_id];

                        foreach($new_package_data['package_service'] as $ps => $package_service){
                            if($package_service['id'] == $service_id){
                                $new_package_service = $package_service;
                                unset($order_detail['packages'][$p]['assiged_to_workers'][$old_worker_data->worker_id]['package_service'][$ps]);
                                if(!empty($order_detail['packages'][$p]['assiged_to_workers'][$old_worker_data->worker_id]['package_service'])){
                                    $order_detail['packages'][$p]['assiged_to_workers'][$old_worker_data->worker_id]['package_service'] = array_values($order_detail['packages'][$p]['assiged_to_workers'][$old_worker_data->worker_id]['package_service']);
                                }else{
                                    unset($order_detail['packages'][$p]['assiged_to_workers'][$old_worker_data->worker_id]);
                                }
                            }
                        }

                        if(isset($package['assiged_to_workers'][$worker_id])){
                            $package_data = $package['assiged_to_workers'][$worker_id];
                        }else{
                            $package_data = $new_package_data;
                            unset($package_data['package_service']);
                        }

                        $package_data['package_service'][] = $new_package_service;
                        $order_detail['packages'][$p]['assiged_to_workers'][$worker_id] = $package_data;

                    }
                }
            }
        }

        if(isset($order_detail['services']) || isset($order_detail['packages'])){
            $franchise_order->order_details = $order_detail;
            $franchise_order->save();
        }

        // ---------------------------- For Worker Notification Start-------------------------------------//
            $worker_users = $request->worker_id;

            $worker_user_id = Franchise_worker::where('id',$worker_users)->first();

            $notification = new Notification;
            $notification->order_id = $new_worker_assign->order_id;
            $notification->user_id = $worker_user_id->id;
            $notification->f_order_id = $new_worker_assign->f_order_id;
            $notification->is_package = isset($new_worker_assign->is_package) ? $new_worker_assign->is_package : 0;
            $notification->package_id = isset($new_worker_assign->package_id) ? $new_worker_assign->package_id : 0;
            $notification->service_id = isset($new_worker_assign->service_id) ? $new_worker_assign->service_id : 0;
            $notification->is_worker = 1;
            $notification->type = 'new order';
            $notification->message = 'New order arrived';
            $notification->save();
        // ---------------------------- For Worker Notification end-------------------------------------//

        return redirect('admin/franchise-order')->with('Insert_Message','Order Assign Successfully');
    }
}
