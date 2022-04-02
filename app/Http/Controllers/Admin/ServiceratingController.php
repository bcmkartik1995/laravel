<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services_ratings;
use App\Service;
use App\User;

class ServiceratingController extends Controller
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
        $service_ratings = Services_ratings::with(['service' => function ($query) {
            $query->select('title','id');
        }])
        ->with(['user' => function ($query) {
            $query->select('name','id');
        }])
        ->join('services as sr', function ($sub_join)  {
            $sub_join->on('services_ratings.service_id','=','sr.id')->where('sr.deleted_at', '=',NULL);
        })
        ->select('services_ratings.id','services_ratings.user_id','services_ratings.service_id','services_ratings.service_rating','services_ratings.description','services_ratings.hygiene_rating','services_ratings.status')
        ->get();
        return view('admin.service_rating.index',compact('service_ratings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        $services = Service::where(['status'=>1])->get();

        return view('admin.service_rating.create',compact('users','services'));
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
            'user_id' => 'required',
            'service_id' => 'required',
            'rating' => 'required',
            'description' => 'required',
        ]);

        $service_rating = new Services_ratings;
        $service_rating->user_id = $request->input('user_id');
        $service_rating->service_id = $request->input('service_id');
        $service_rating->service_rating = $request->input('rating');
        $service_rating->description = $request->input('description');

        $service_rating->save();

        return redirect('admin/service-rating')->with('Insert_Message','Data Created Successfully');
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
        $service_rating = Services_ratings::findOrFail($id);
        $users = User::all();
        $services = Service::where(['status'=>1])->get();

        return view('admin.service_rating.edit',compact('users','services','service_rating'));
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
            'user_id' => 'required',
            'service_id' => 'required',
            'rating' => 'required',
            'description' => 'required',
        ]);

        $service_rating = Services_ratings::find($id);
        $service_rating->user_id = $request->input('user_id');
        $service_rating->service_id = $request->input('service_id');
        $service_rating->service_rating = $request->input('rating');
        $service_rating->description = $request->input('description');

        $service_rating->save();

        return redirect('admin/service-rating')->with('update_message','Data Created Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service_rating = Services_ratings::find($id);
        $service_rating->delete();

        return response()->json(['success' => 1, 'message' => 'Data Deleted successfully']);
    }
}
