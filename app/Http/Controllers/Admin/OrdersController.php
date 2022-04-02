<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Orders;
use App\User;
use App\Service;
use App\Package;
use App\Package_service;
use App\Franchises_order;
use App\Franchise;
use App\City;
use App\Notification;
use Illuminate\Http\Response;
use App\Order_Details;
use App\Ordered_services;
use Datatables;
use Carbon\Carbon;
use Auth;
use PDF;
use Mail;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function datatables(Request $request)
    {
        
        $datas = Orders::orderBy('id','desc')->where('orders.is_fully_allocated','=',1);
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
        ->select('orders.id','orders.customer_name','orders.order_number','orders.totalQty','orders.pay_amount','orders.status','mua.city','cart')->get();


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

                if(Auth::guard('admin')->user()->sectionCheck('orders_delete') || Auth::guard('admin')->user()->role_id == 0){
                    //$html .= '<a href="javascript:void(0);" data-href="'. route('orders-delete',$data->id). '" class="dropdown-item delete"><i class="bx bx-trash mr-1"></i>Detete</a>';
                }

                if(Auth::guard('admin')->user()->sectionCheck('orders_status') || Auth::guard('admin')->user()->role_id == 0){
                    $html .= '<a class="dropdown-item show-example-btn booking-status" data-status="'.$data->status.'" data-id="'.$data->id.'" om positioned dialog"><i class="bx bx-cog mr-1"></i>Manage Status</a>';
                }

                if(Auth::guard('admin')->user()->sectionCheck('orders_view') || Auth::guard('admin')->user()->role_id == 0){
                    $html .= '<a class="dropdown-item" href="'.route('orders-details',$data->id).'"><i class="bx bx-list-ul mr-1"></i> view</a>';
                }

                if(Auth::guard('admin')->user()->sectionCheck('franchise_orders_assigned') || Auth::guard('admin')->user()->role_id == 0){
                    $html .= '<a class="dropdown-item" href="'.route('franchise-orders-details',$data->id).'"><i class="bx bxs-buildings mr-1"></i> Franchise Details</a>';
                }

                if(Auth::guard('admin')->user()->sectionCheck('orders_invoice') || Auth::guard('admin')->user()->role_id == 0){
                    if($data->status == 'completed')
                    {
                        $html .= '<a class="dropdown-item" href="'.route('order-invoice',$data->id).'"><i class="bx bx-edit-alt mr-1"></i> Invoice Details</a>';
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
                if(!empty($data->cart['packages'])){
                    foreach($data->cart['packages'] as $package){
                        if(isset($package['title'])){
                            $ordered_services[] = $package['title'];
                        }
                    }
                }
                if(!empty($data->cart['services'])){
                    foreach($data->cart['services'] as $service){
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
        // $bookings = Orders::select('id','customer_name','order_number','totalQty','pay_amount','status','created_at','updated_at')
        // ->orderBy('id', 'DESC')
        // ->get();

        // ->leftjoin("franchises_orders AS fo",function($join){
        //     $join->on('orders.id', '=', 'fo.orders_id')->whereIN('fo.status',[0,1]);
        // })->groupBy('orders.id')

        $user_id = Auth::guard('admin')->user()->id;

       // Notification::where(['user_id'=>$user_id,'type'=>'new order'])->update(['is_read'=>1]);

        $franchises = Franchise::get();

        $cities = City::where(['status' => 1])->select(['id','name'])->get();

        $services = Service::where(['status' => 1])->select(['id','title'])->get();
        
        return view('admin.Orders.index',compact('franchises','cities','services'));
    }

    public function delete($id)
    {
        
        $bookings = Orders::findOrFail($id);
        $bookings->delete();
        return response()->json(['success' => 1, 'message' => 'Data Deleted successfully']);
    }

    public function show_orders($id)
    {
       
        $booking = Orders::with(['user' => function ($query) {
            $query->select('name','id');
        }])
        ->where('id',$id)
        ->first();

       
        // echo '<pre>';
        // print_R($booking);die;        
        // $booking_detail = Order_Details::where('booking_id',$id)->first()->toArray();

        // if(!empty($booking_detail['booking_details']['packages'])){
        //     foreach($booking_detail['booking_details']['packages'] as $pkey => $packages){
        //         if(!empty($packages['package_services'])){
        //             foreach($packages['package_services'] as $skey => $service){
        //                 $service_data = Service::where('id',$service['service_id'])->first();
        //                 $packages['package_services'][$skey]['title'] = $service_data->title;
        //                 $packages['package_services'][$skey]['price'] = $service_data->price;
        //             }
        //         }
        //         $booking_detail['booking_details']['packages'][$pkey] = $packages;
        //     }
        // }

        return view('admin.Orders.view',compact('booking'));
    }

    public function franchise_orders_details($id)
    {
    
        
        $franchise_orders = Franchises_order::with(['f_order' => function ($query) {
            $query->select('orders.*');
        }])
        ->with(['franchise' => function ($query) {
            $query->select('id','franchise_name');
        }])
        ->where('orders_id',$id)
        ->get();

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

        // echo '<pre>';
        // print_R($worker_orders);
        // echo '<pre>';
        // print_R($franchise_orders);die;
       
        return view('admin.Orders.franchise_order',compact('franchise_orders','worker_orders'));
    }

    public function assign_franchises(Request $request)
    {
        $order_detail = Orders::where('id',$request->id)->first();
        
        $category_id = isset($order_detail->cart['category_id'])? $order_detail->cart['category_id'] : '';
        
        if(empty($category_id)){
            if(isset($order_detail->cart['packages']))
            {
                foreach($order_detail->cart['packages'] as $package){
                    $category_id = $package['category_id'];
                }
            }
            if(isset($order_detail->cart['services']))
            {
                foreach($order_detail->cart['services'] as $service){
                    $category_id = $service['category_id'];
                }
            }
        }

        $franchises_order = Franchise::where('category_id',$category_id)->get();

        return response()->json($franchises_order);
    }


    public function order_invoice($id)
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


        return view('admin.Orders.invoice',compact('booking'));
    }

    public function order_invoice_print($id)
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
        $pdf = PDF::loadView('admin.Orders.orderPdf',$data);
        return $pdf->download($data["order_number"].'.pdf');

        //return $pdf->stream($booking->order_number.'.pdf');
    }

    public function order_invoice_send($id)
    {
        $booking = Orders::where('orders.id',$id)
        ->join('franchises_orders as fo','fo.orders_id','=','orders.id')
        ->join('users as u','orders.user_id','=','u.id')
        ->join('franchises as f','fo.franchises_id','=','f.id')
        ->select('fo.id','fo.franchises_id','fo.status','fo.orders_id','orders.id as order_id','orders.customer_email','orders.customer_name','orders.customer_phone','orders.customer_address','orders.user_id','orders.order_number','f.address_1','f.address_2','f.franchise_name','f.email','f.mobile','u.name','orders.pay_amount','u.latitude','u.longitude','u.ipaddress','orders.cart','orders.created_at')
        ->first()->toArray();

        $data["customer_email"]= $booking['customer_email'];

        $data['custom'] = json_encode($booking);
        $pdf = PDF::loadView('admin.Orders.orderPdf',$data);
        //echo 'dsdsdsdsd';die;
        Mail::send('admin.Orders.email.invoice', $data, function($message)use($data, $pdf) {
            
        $message->to($data['customer_email'])
            ->subject('Send Mail from Laravel')
            //->body('hi')
            ->attachData($pdf->output(),"order-invoice.pdf");
        });
        
        return redirect()->back()->with('Insert_Message', 'Mail sent successfully');
    }


}
