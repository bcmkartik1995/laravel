<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\GiftCard;
use Carbon\Carbon;
use Validator;
use Mail;
use Auth;
use App\Gift_user; 

class GiftController extends Controller
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
        $gifts = GiftCard::get();
        return view('admin.Gift.index',compact('gifts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.Gift.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
   
        $rules = [
            'title' => 'required',
            'gift_value' => 'required|numeric',
            'valid_from' => 'required|date',
            'valid_to' => 'required|date|after_or_equal:valid_from',
            'description' => 'required',
            'image' => 'required|mimes:jpg,png,jpeg|dimensions:max_width=300,max_height=200|dimensions:min_width=300,min_height=200|max:2048',
        ];
    
        $customMessages = [
            'image.dimensions' => 'Image resolution must be 300*200',
            'max' => 'Max file size allowed : 2MB'
        ];
    
        $this->validate($request, $rules, $customMessages);

        $gifts = new GiftCard;
        $gifts->title = $request->input('title');
        $gifts->description = $request->input('description');
        $gifts->gift_value = $request->input('gift_value');

        $image = $request->file('image');
        $imagename = time().'.'.$image->extension();
        $image->move(public_path('assets/images/giftsimage'),$imagename);
        $gifts->image = $imagename;

        $gifts->valid_from = $request->input('valid_from');
        $gifts->valid_to = $request->input('valid_to');

        $gifts->save();
        return redirect('admin/gift-card')->with('Insert_Message','Data Created Successfully');
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
        $gifts = GiftCard::findOrFail($id);
        return view('admin.Gift.edit',compact('gifts'));
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
        $rules = [
            'title' => 'required',
            'gift_value' => 'required|numeric',
            'valid_from' => 'required|date',
            'valid_to' => 'required|date|after_or_equal:valid_from',
            'description' => 'required',
            'image' => 'mimes:jpg,png,jpeg|dimensions:max_width=300,max_height=200|dimensions:min_width=300,min_height=200|max:2048',
        ];
    
        $customMessages = [
            'image.dimensions' => 'Image resolution must be 300*200',
            'image.max' => 'Max file size allowed : 2MB'
        ];
    
        $this->validate($request, $rules, $customMessages);

        $gifts = GiftCard::find($id);   
        $gifts->title = $request->input('title');
        $gifts->description = $request->input('description');
        $gifts->gift_value = $request->input('gift_value');

        if($request->image != ''){

            $image = $request->file('image');
            $imagename = time().'.'.$image->extension();
            $image->move(public_path('assets/images/giftsimage'),$imagename);
            $gifts->image = $imagename;
        }

        $gifts->valid_from = $request->input('valid_from');
        $gifts->valid_to = $request->input('valid_to');

        
        $gifts->save();
        return redirect('admin/gift-card')->with('update_message','Data Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gifts = GiftCard::findOrFail($id);
        $gifts->delete();
        
        return response()->json(['success' => 1, 'message' => 'Data Deleted successfully']);
    }

    public function send_gift_form()
    {
        
        $gifts = GiftCard::where(['status'=>1])->get();
        return view('admin.Gift.sendgift',compact('gifts'));
    }

    

    public function send_gift_mail(Request $request)
    {        
        // echo '<pre>';
        // print_R($request->all());die;
        $rules = [
            'gift_card'=>'required',
            'description'=>'required',
            'file' => 'required|mimes:csv,txt|max:2048',
        ];
    
        $customMessages = [
            'max' => 'Max file size allowed : 2MB',
        ];

        $validator = Validator::make($request->all(), $rules, $customMessages);
        if($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
        

        // $image = $request->file('file');
        // $imagename = time().'.'.$image->getClientOriginalExtension();
        // $image->move(public_path('assets/admin-assets/csvfile'),$imagename);
        // $location = public_path('assets/admin-assets/csvfile/'.$imagename);
        // //print_R($location);die;
        
        $user_id = Auth::guard('admin')->user();

        if($request->file('file')->getSize() > 0){

            $handle = fopen($request->file,"r");

            $columns = fgetcsv($handle, 1000, ",");

            if(!empty($columns)){
                
                $all_data = [];
                while (($data = fgetcsv($handle, 200, ",")) !== FALSE) {
                    $all_data[] = $data[1];
                }

                $sender_id = $user_id->id;

                $all_data = [
                    'description' => $request->description,
                    'email' => $all_data,
                ];

                $data = [];
                foreach($all_data['email'] as $d){
                    
                    Mail::send('admin.Gift.mail.sendmail', $all_data, function($message)use($d) {            
                        $message->to($d)
                            ->subject('Gift Card From '.env('APP_NAME'));
                    });

                    $data[] = [
                        'email' => $d,
                        'sender_id' => $sender_id,
                        'gift_card_id' => $request->gift_card,
                    ];
                    
                }
                Gift_user::insert($data);

                return redirect()->back()->with('Insert_Message', 'Mail Sent Successfully');

            }else{
                return redirect()->back()->withInput()->withErrors($validator->errors()->merge(['file' => ['Blank File']]));
            }
            
            fclose($handle);
            
        }else{
            return redirect()->back()->withInput()->withErrors($validator->errors()->merge(['file' => ['Invalid File']]));
        }
        
        
       

    }

    
}
