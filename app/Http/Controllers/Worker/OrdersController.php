<?php

namespace App\Http\Controllers\Worker;

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
use App\Worker_assigned_services;
use App\Extra_payment;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:worker');
    }

    public function datatables(Request $request)
    {

        $user_id = Auth::guard('worker')->user()->id;
        $datas = Orders::orderBy('id','desc')->with([
            'user' => function ($query) {
                $query->select('name','id');
            },
            'worker_orders' =>function($query)use($user_id){
                $query->where('worker_id', $user_id);
            }
        ])->where(['was.worker_id' => $user_id]);
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

        $datas = $datas->groupBy('orders.id')
        ->leftJoin('user_addresses as mua', 'mua.id', '=', 'orders.customer_address_id')
        ->join('worker_assigned_services as was', 'orders.id', '=', 'was.order_id')
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

                $html .= '<a class="dropdown-item" href="'.route('worker.orders-details',$data->id).'"><i class="bx bx-list-ul mr-1"></i> view</a>';
                $html .= '</div></div>';
                return $html;

            })
            ->addColumn('ordered_services', function($data){

                $ordered_services = [];
                if(!empty($data->worker_orders)){
                    foreach($data->worker_orders as $worker_order){
                        if(!empty($worker_order->service->title)){
                            $ordered_services[] = $worker_order->service->title;
                        }
                    }
                }
                return implode(', ', $ordered_services);
            })
            ->rawColumns(['action','cities','ordered_services'])
            ->toJson();
    }


    public function index() {

        $user_id = Auth::guard('worker')->user()->id;

        //Notification::where(['user_id'=>$user_id,'type'=>'new order'])->update(['is_read'=>1]);

        $cities = City::where(['status' => 1])->select(['id','name'])->get();

        $services = Service::where(['status' => 1])->select(['id','title'])->get();

        return view('worker.orders.index',compact('cities','services'));
    }

    public function show_orders($id)
    {

        $user_id = Auth::guard('worker')->user()->id;

        $booking = Orders::with([
            'user' => function ($query) {
                $query->select('name','id');
            },
            'worker_orders' =>function($query)use($user_id){
                $query->where('worker_id', $user_id);
            }
        ])
        //->join('worker_assigned_services as was', 'orders.id', '=', 'was.order_id')
        ->where('orders.id',$id)
        //->where(['was.worker_id' => $user_id])
        ->first();


        $order_data = [];

        if(!empty($booking->worker_orders)){
            foreach($booking->worker_orders as $worker_order){
                $data = [];
                $data['id'] = $worker_order->id;
                $data['title'] = $worker_order->service->title;
                $data['price'] = $worker_order->service->price;
                $data['take_time'] = $worker_order->take_time;
                $data['start_time'] = $worker_order->start_time;
                $data['end_time'] = $worker_order->end_time;
                $data['status'] = $worker_order->status;
                $data['pay_status'] = $worker_order->pay_status;

                if($worker_order->is_package == 1){

                    //print_R($worker_order);
                    if(!isset($order_data['packages'][$worker_order->package_id])){
                        $order_data['packages'][$worker_order->package_id]['title'] = $worker_order->package->title;
                    }
                    $order_data['packages'][$worker_order->package_id]['services'][] = $data;
                }else{
                    $order_data['services'][$worker_order->service_id] = $data;
                }
            }
        }

        $worker_order_status = [0 => 'Pending', 1 => 'Accepted', 2 => 'Declined', 3 => 'Inprogress' ,4 => 'On delivery', 5 => 'Completed'];

        return view('worker.orders.view',compact('booking','order_data','worker_order_status'));
    }

    public function orders_status(Request $request){

        $bookings = Worker_assigned_services::find($request->id);
        $bookings->status = $request->status;
        if($request->status == 2){
            $bookings->is_allocated = 0;
        }
        
        
        $worker_order = Worker_assigned_services::where(['id'=>$request->id])->first();
        $order_id = $worker_order->order_id;
        $order_worker = Worker_assigned_services::where(['order_id'=>$order_id])->count();
        $worker_status = Worker_assigned_services::where(['status'=> 5])->count();

        if($order_worker == $worker_status){
            $order = Orders::find($order_id);
            $order->status = 'completed';
            $order->save();
        }
            
        
        $bookings->update();

        $response = [
            'success' => 1,
            'message' => 'Status updated successfully.',
            'status' => $bookings->status,
            'worker_assign_id' => $bookings->id,
            'worker_id' => $bookings->worker_id,
            'order_id' => $bookings->order_id,
            'f_order_id' => $bookings->f_order_id,
        ];
        return response()->json($response);
    }

    public function extra_payment(Request $request)
    {
       

        if($request->payment_status == 'Pending'){
            $request->validate([
                'payment_recived' => 'required',
                'extra_payment' => 'sometimes',
                'reason'       => 'required_with:extra_payment,*',
                'amount'       => 'required_with:extra_payment,*',
            ]);
        }else{
            $request->validate([
                'extra_payment' => 'sometimes',
                'reason'       => 'required_with:extra_payment,*',
                'amount'       => 'required_with:extra_payment,*',
            ]);
        }


        if($request->extra_payment == 1){
            
            $extra_payment = new Extra_payment;

            $extra_payment->extra_payment = $request->extra_payment;

            if(!empty($request->reason)){
                $extra_payment->reason = $request->reason;
            }
            if(!empty($request->amount)){
                $extra_payment->amount = $request->amount;
            }
            
            $extra_payment->worker_assign_id = $request->worker_assign_id;
            $extra_payment->worker_id = $request->worker_id;
            $extra_payment->order_id = $request->order_id;
            $extra_payment->f_order_id = $request->f_order_id;

            $extra_payment->save();
            
        }
        
        $payment_recived = $request->payment_recived;
        if($payment_recived == 1){
            $order = Orders::where(['id'=>$request->order_id])->first();
            if($order->payment_taken_by == null && $order->payment_taken_date == null && $order->worker_assign_id == null){
                
                $order->payment_taken_by = $request->worker_id;
                $order->payment_taken_date = date('Y-m-d H:i:s');
                $order->worker_assign_id = $request->worker_assign_id;
                $order->payment_status = 'Paid';

                $order->save();
                
                Franchises_order::where(['orders_id'=>$order->id])->update(['pay_status'=>'Paid']);

                Worker_assigned_services::where(['order_id'=>$order->id])->update(['pay_status'=>'Paid']);
            }
        }

        return redirect('worker/orders-details/'.$request->order_id)->with('Insert_Message','Order Assign Successfully');
    }

}
