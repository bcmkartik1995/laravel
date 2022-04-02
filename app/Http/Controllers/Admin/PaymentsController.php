<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Payments;
use App\Franchise;
use Carbon\Carbon;


class PaymentsController extends Controller
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
        $payments = Payments::with(['franchise' => function ($query) {
            $query->select('franchise_name','id');
        }])
        ->select('type','payment_date','amount','status','id','franchise_id')
        ->get();
 
        return view('admin.payments.index',compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $franchises = Franchise::where(['status' => 1])->pluck('franchise_name','id');
        return view('admin.payments.create', compact('franchises'));
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
            'type' => 'required',
            'franchise_id' => 'required',
            'amount' => 'required|numeric',
            'payment_date' => 'required',
        ]);
        $data = $request->all();
        $data['payment_date'] = Carbon::createFromFormat('d/m/Y',  $data['payment_date'])->format('Y-m-d');
        $data['created_by'] = Auth::guard('admin')->user()->id;
        $payment = Payments::create($data);

       // $payment->save();
        return redirect('admin/payments')->with('Insert_Message','Data Created Successfully');
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
        $payments = Payments::findOrFail($id);
        $franchises = Franchise::where(['status' => 1])->pluck('franchise_name','id');

        return view('admin.payments.edit',compact('payments','franchises'));
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
            'type' => 'required',
            'franchise_id' => 'required',
            'amount' => 'required|numeric',
            'payment_date' => 'required',
        ]);
        $payment = Payments::find($id);
        $payment->franchise_id = $request->input('franchise_id');
        $payment->type = $request->input('type');
        $payment->amount = $request->input('amount');
        $payment->payment_date = Carbon::createFromFormat('d/m/Y', $request->input('payment_date'))->format('Y-m-d');;
        $payment->updated_by = Auth::guard('admin')->user()->id;

        $payment->remarks = $request->input('remarks');

        $payment->save();
        
        return redirect('admin/payments')->with('update_message','Data Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payment = Payments::findOrFail($id);
        $payment->delete();
        
        return response()->json(['success' => 1, 'message' => 'Data Deleted successfully']);
    }
}
