<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Packages_ratings;
use App\User;
use App\Service;
use App\Package;

class PackageratingController extends Controller
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
        $package_ratings = Packages_ratings::with(['service' => function ($query) {
            $query->select('title','id');
        }])
        ->with(['user' => function ($query) {
            $query->select('name','id');
        }])
        ->select('id','user_id','package_id','package_rating','description','hygiene_rating','status')
        ->get();

        // echo '<pre>';
        // print_R($package_ratings);die;
        
        return view('admin.package_rating.index',compact('package_ratings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        $packages = Package::where(['status'=>1])->get();

        return view('admin.package_rating.create',compact('users','packages'));
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
            'package_id' => 'required',
            'rating' => 'required',
            'description' => 'required',
        ]);

        $package_rating = new Packages_ratings;
        $package_rating->user_id = $request->input('user_id');
        $package_rating->package_id = $request->input('package_id'); 
        $package_rating->package_rating = $request->input('rating'); 
        $package_rating->description = $request->input('description'); 

        $package_rating->save();

        return redirect('admin/package-rating')->with('Insert_Message','Data Created Successfully');
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
        $package_rating = Packages_ratings::findOrFail($id);
        $users = User::all();
        $packages = Package::where(['status'=>1])->get();

        return view('admin.package_rating.edit',compact('users','packages','package_rating'));
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
            'package_id' => 'required',
            'rating' => 'required',
            'description' => 'required',
        ]);

        $package_rating = new Packages_ratings;
        $package_rating->user_id = $request->input('user_id');
        $package_rating->package_id = $request->input('package_id');
        $package_rating->package_rating = $request->input('rating');
        $package_rating->description = $request->input('description');

        $package_rating->save();

        return redirect('admin/package-rating')->with('update_message','Data Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $package_rating = Packages_ratings::find($id);
        $package_rating->delete();

        return response()->json(['success' => 1, 'message' => 'Data Deleted successfully']);
    }
}
