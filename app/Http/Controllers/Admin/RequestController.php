<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Request_quotes;
use App\Franchise_services;
use App\Franchise;
use App\Followup;
use App\Models\Role;
use Datatables;
use DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatables(Request $request)
    {
        
        if(Auth::guard('admin')->user()->role_id == 0 || Auth::guard('admin')->user()->sectionCheck('request_quotes')){

                $datas = Request_quotes::where('request_quotes.status', '!=', 1)->orderBy('id','desc');

                if(isset($request->searchBystatus) && !empty($request->searchBystatus || $request->searchBystatus == 0)){
                    $datas->where('request_quotes.status',$request->searchBystatus);
                }

                if(isset($request->searchByrequest_type) && !empty($request->searchByrequest_type))
                {
                    $datas->where('request_quotes.request_type',$request->searchByrequest_type);
                }
                $datas = $datas->get();

                return Datatables::of($datas)
                    ->addColumn('visit_date_time', function($row){
                        return Carbon::parse($row->visit_date.' '.$row->visit_time)->format('d-m-Y H:i a');
                    })
                    ->addColumn('status', function(Request_quotes $data) {
                        if($data->status == 0){
                            return '<span class="badge badge-pill badge-light-info"> New</span>';
                        }
                        if($data->status == 1){
                            return '<span class="badge badge-pill badge-light-primary"> Folloups</span>';
                        }
                        if($data->status == 3){
                            return '<span class="badge badge-pill badge-light-danger"> Canceled</span>';
                        }
                        if($data->status == 4){
                            return '<span class="badge badge-pill badge-light-warning"> Refer</span>';
                        }
                        if($data->status == 5){
                            return '<span class="badge badge-pill badge-light-success"> Accepted</span>';
                        }
                        if($data->status == 6){
                            return '<span class="badge badge-pill badge-light-danger"> Declined</span>';
                        }
                        
                    }) 
                    ->addColumn('view_message', function(Request_quotes $row){
                        return '<button class="btn btn-primary btn-sm message" data-comment="'. $row->message .'" data-toggle="modal" data-target="#franchise-'.$row->id.'">View Message</button>
                        <div class="modal fade" id="franchise-'.$row->id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content logs">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Message</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>'.$row->message .'</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                                </div>
                            </div>
                            </div>';
                    })
                    ->addColumn('view_logs', function(Request_quotes $row){
                        if(!empty($row->ref_message || $row->followup_mes)) {
                        return '<button class="btn btn-primary btn-sm ref_message" data-id="'. $row->id .'" data-comment="'. $row->ref_message .'" data-followup="'. $row->followup_mes .'" data-date="'. $row->followup_date.'" data-franchise="'. $row->refer_to.'" data-toggle="modal" data-target="#exampleModal1">View Logs</button>';
                        }
                    })
                    ->addColumn('action', function(Request_quotes $data) {

                        if(Auth::guard('admin')->user()->sectionCheck('request_quotes_status') || Auth::guard('admin')->user()->role_id == 0){
                            $html = '<a href="javascript:void(0);" data-href="'. route("request.destroy",$data->id) .'" class="btn btn-danger btn-sm mr-25 delete mb-1">Delete</a>';
                            $html .='<div class="dropdown">
                            <button class="btn btn-primary btn-sm dropdown-toggle mr-1" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action </button>';

                            if($data->status == 1) {
                                $html .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#">Refer</a>
                                    <a class="dropdown-item cancel" data-id="'. $data->id . '" data-status="3" data-toggle="modal"  href="#">Cancel</a>
                                </div>
                            </div>';
                            }
                            elseif($data->status == 4) {
                                $html .='<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                               
                                <a class="dropdown-item cancel" data-id="'. $data->id . '" data-status="3" data-toggle="modal" href="#">Cancel</a>
                            </div>';
                            } elseif($data->status == 5) {
                                $html .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item cancel" data-id="'. $data->id .'" data-status="3" data-toggle="modal" href="#">Cancel</a>
                            </div>';
                            } elseif($data->status == 0) {
                                $html .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item follow" data-id="'. $data->id .'" data-status="1" data-toggle="modal" data-target="#followupmodal">Folloups</a>
                                <a class="dropdown-item refer" data-id="'. $data->id .'" data-status="4" data-toggle="modal" data-target="#refmodal" href="#">Refer</a>
                                <a class="dropdown-item cancel" data-id="'. $data->id .'" data-status="3" data-toggle="modal" href="#">Cancel</a>
                            </div>';
                            } elseif($data->status == 6) {
                                $html .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item follow" data-id="'. $data->id .'" data-status="1" data-toggle="modal" data-target="#followupmodal">Folloups</a>
                                <a class="dropdown-item refer" data-id="'. $data->id .'" data-status="4" data-toggle="modal" data-target="#refmodal" href="#">Refer</a>
                                <a class="dropdown-item cancel" data-id="'. $data->id .'" data-status="3" data-toggle="modal" href="#">Cancel</a>
                            </div>';
                            }
                        }

                            $html .= '</div>';


                        
                        return $html;

                    }) 
                    ->rawColumns(['action','visit_date_time','status','view_message', 'view_logs'])
                    ->toJson();
        } 

        $role_id = Role::where('name','=','franchises')->first();

        
        if(Auth::guard('admin')->user()->role_id == $role_id->id){
            
            $datas = Request_quotes::select('request_quotes.*')
                                     ->whereIn('request_quotes.status', [4,5,6])
                                     ->where('admins.role_id', Auth::guard('admin')->user()->role_id)
                                     ->join('franchises','franchises.id', 'request_quotes.refer_to')
                                     ->join('admins', 'admins.id', 'franchises.user_id');


                if(isset($request->searchBystatus) && !empty($request->searchBystatus || $request->searchBystatus == 0)){
                    $datas->where('request_quotes.status',$request->searchBystatus);
                }

                if(isset($request->searchByrequest_type) && !empty($request->searchByrequest_type))
                {
                    $datas->where('request_quotes.request_type',$request->searchByrequest_type);
                }

                $datas = $datas->get();

                return Datatables::of($datas)
                    ->addColumn('visit_date_time', function($row){
                          return Carbon::parse($row->visit_date.' '.$row->visit_time)->format('d-m-Y H:i a');
                      })
                    ->addColumn('status', function($data) {
                        if($data->status == 3){
                            return '<span class="badge badge-pill badge-light-danger"> Canceled</span>';
                        }
                        elseif($data->status == 4){
                            return '<span class="badge badge-pill badge-light-warning"> Refer</span>';
                        }
                        elseif($data->status == 5){
                            return '<span class="badge badge-pill badge-light-success"> Accepted</span>';
                        }
                        elseif($data->status == 6){
                            return '<span class="badge badge-pill badge-light-danger"> Declined</span>';
                        }
                    })

                     ->addColumn('action', function(Request_quotes $data) {

                            if($data->status != 5 && $data->status != 6) {
                                return  '<a class="btn btn-success btn-sm mr-25 accept mb-1" data-id="'. $data->id .'" data-status="5" data-toggle="modal"  href="#">Accept</a>
                                <a class="btn btn-danger btn-sm mr-25 accept mb-1  decline" data-id="'. $data->id .'" data-status="6" data-toggle="modal" data-target="#refmodal" href="#">Decline</a>';
                            }
                            // if($data->status != 6) {
                            //     return  
                            // }
                    })

                    ->addColumn('view_message', function(Request_quotes $row){
                        return '<button class="btn btn-primary btn-sm message" data-comment="'. $row->message .'" data-toggle="modal" data-target="#franchise-'.$row->id.'">View Message</button>
                        <div class="modal fade" id="franchise-'.$row->id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content logs">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Message</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>'.$row->message .'</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                                </div>
                            </div>
                            </div>';
                    })
                    ->addColumn('view_logs', function(Request_quotes $row){
                        if(!empty($row->ref_message)) {
                        return '<button class="btn btn-primary btn-sm ref_message" data-id="'. $row->id .'" data-comment="'. $row->ref_message .'" data-followup="'. $row->followup_mes .'" data-date="'. $row->followup_date.'" data-franchise="'. $row->refer_to.'" data-toggle="modal" data-target="#exampleModal1">View Logs</button>';
                        }
                    })

                    ->rawColumns(['action','visit_date_time','status','view_message', 'view_logs'])
                    ->toJson();
                }
      
        
    }

    public function index()
    {        
        return view('admin.request.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
    
        if($request->req_f_id) {
            $id = $request->req_f_id;
            $message = $request->fol_message;
            $date = $request->fol_date;
            $status = $request->status;

            $req_quotes = Request_quotes::find($id);
            // $req_quotes->followup_mes = $message;
            // $req_quotes->followup_date = $date;
            $req_quotes->status = $status;
            $req_quotes->save();
            $followup  = new Followup;
            $followup->request_id = $id;
            $followup->followup_mes = $message;
            $followup->followup_date = $date;
            $followup->status = $status;
            $followup->save();

            return redirect()->back()->with('update_message','Status Updated Successfully');
        }


        if($request->req_r_id) {
            
            $id = $request->req_r_id;
            $f_id = $request->followup_id;

            $status = $request->status;
            $refer_to = $request->franchise;

            $quotes = Request_quotes::find($id);
            $quotes->ref_message = $request->ref_message;
            $quotes->status = $status;
            $quotes->refer_to = $refer_to;

                $fol = new Followup;
                $fol->request_id = $id;
                $fol->status = $status;
                $fol->refer_to = $refer_to;
                $fol->ref_message = $request->ref_message;
                $fol->save();
            
            
            //start code for logs for refer without followup
            // if(!empty($id)) {
            //     $fol = new Followup;
            //     $fol->request_id = $id;
            //     $fol->status = $status;
            //     $fol->save();
            // }
            //end code for logs for refer without followup
            $quotes->save();
            return redirect()->back()->with('update_message','Status Updated Successfully');
        }

        if($request->req_c_id) {
            $user_id = Auth::guard('admin')->user()->name;
            // if(!empty($user)) {
                $id = $request->req_c_id;
                $status = $request->status;

                $req_quotes = Request_quotes::find($id);
                $req_quotes->status = $status;
                $req_quotes->canceled_by = $user_id;
                $fol = new Followup;
                $fol->canceled_by = $user_id;
                $fol->status = $status;
                $fol->save();
                $req_quotes->save();
                return redirect()->back()->with('update_message','Status Updated Successfully');
            // }
        }

        if($request->req_a_id) {
            $user_id = Auth::guard('admin')->user()->name;
            // if(!empty($user)) {
                $id = $request->req_a_id;
                $status = $request->status;

                $req_quotes = Request_quotes::find($id);
                $req_quotes->status = $status;
                $req_quotes->accepted_by = $user_id;
                $fol = new Followup;
                $fol->accepted_by = $user_id;
                $fol->status = $status;
                $fol->save();
                $req_quotes->save();
                return redirect()->back()->with('update_message','Status Updated Successfully');
            // }
        }

        if($request->req_d_id) {
            // if(!empty($user)) {
                $user_id = Auth::guard('admin')->user()->name;
                $id = $request->req_d_id;
                $status = $request->status;

                $req_quotes = Request_quotes::find($id);
                $req_quotes->status = $status;
                $req_quotes->dec_message = $request->dec_message;
                $req_quotes->decline_by = $user_id;
               

                $fol = New Followup;
                $fol->status = $status;
                $fol->request_id = $id;
                if(!empty($request->dec_message)){
                    $fol->dec_message = $request->dec_message;
                    $fol->decline_by = $user_id;
                }
                $fol->save();
                $req_quotes->save();
                return redirect()->back()->with('update_message','Declined Successfully');
            // }
        }

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $quotes = Request_quotes::find($id);
        $quotes->delete();

        return response()->json(['success' => 1, 'message' => 'Data Deleted successfully']);
    }

    public function request_followups(Request $request) {
        $date = date('Y-m-d');
        $datas = Request_quotes::where('request_quotes.status', '=' ,1)->where('followups.status', '=', 1)->where('followups.followup_date', '<=' ,$date)->join('followups', 'followups.request_id', '=', 'request_quotes.id')->orderBy('request_quotes.id','desc');
        $datas = $datas->get();

        return Datatables::of($datas)
                    ->addColumn('visit_date_time', function($row){
                        return Carbon::parse($row->visit_date.' '.$row->visit_time)->format('d-m-Y H:i a');
                    })

                    ->addColumn('view_message', function($row){
                        return '<button class="btn btn-primary btn-sm message" data-comment="'. $row->message .'" data-toggle="modal" data-target="#franchise-'.$row->id.'">View Message</button>
                        <div class="modal fade" id="franchise-'.$row->id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content logs">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Message</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>'.$row->followup_mes .'</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                                </div>
                            </div>
                            </div>';
                    })
                    ->addColumn('action', function(Request_quotes $data) {

                        if(Auth::guard('admin')->user()->sectionCheck('followups_status') || Auth::guard('admin')->user()->role_id == 0){
                            $html = '<a href="javascript:void(0);" data-href="'. route("request.destroy",$data->id) .'" class="btn btn-danger btn-sm mr-25 delete mb-1">Delete</a>';
                            $html .='<div class="dropdown">
                            <button class="btn btn-primary btn-sm dropdown-toggle mr-1" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action </button>';

                            if($data->status == 1) {
                                $html .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item follow" data-id="'. $data->request_id .'" data-follo_id = "'. $data->id .'" data-service_id = "'.  $data->service_id .'" data-status="4" data-toggle="modal" data-target="#followupmodal" href="#">Refer</a>
                                <a class="dropdown-item" href="#">Cancel</a>
                            </div>';
                            }
                            
                        }

                            $html .= '</div>';


                        
                        return $html;

                    })
                    ->rawColumns(['action','visit_date_time', 'view_message'])
                    ->toJson();

    }

    public function followups(Request $request)
    {
        $date = date('Y-m-d');
        //  $req_quotes = Request_quotes::Where('status',1)->with('followup')->where('followup_date',$date)->get();  
        
        $req_quotes = Request_quotes::where('request_quotes.status', '=' ,1)->where('followups.status', '=', 1)->where('followups.followup_date', '<=' ,$date)->join('followups', 'followups.request_id', '=', 'request_quotes.id')->get();
        return view('admin.request.followups',compact('req_quotes'));
    }

    public function franchise(Request $request)
    {
        $service_id = $request->service_id;
        $franchise['data'] = Franchise::select('id', 'franchise_name')->groupBy('id')->get();
        return response()->json($franchise);      
        
    }

    public function getfranchise(Request $request) 
    {
        $id = $request->id;
        $reffer_to = Request_quotes::select('request_quotes.*', 'followups.followup_date', 'followups.followup_mes', 'franchises.franchise_name')
                                     ->leftjoin('followups', 'followups.request_id', '=', 'request_quotes.id')
                                     ->leftjoin('franchises', 'franchises.id', '=', 'request_quotes.refer_to')
                                     ->where('request_quotes.id', '=', $id)
                                     ->groupBy('followups.request_id')
                                     ->get();
                                     return response()->json($reffer_to);
    } 

    
}
