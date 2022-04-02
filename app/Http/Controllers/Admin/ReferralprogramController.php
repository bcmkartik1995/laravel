<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Referral_programs;

class ReferralprogramController extends Controller
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
        $referral_programs = Referral_programs::first();
        if(empty($referral_programs)){
            $referral_programs = new Referral_programs;
        }
        return view('admin.referral_program.index',compact('referral_programs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
            'referral_value' => 'required|numeric',
            'max_value' => 'required|numeric',
        ]);

        $referral_programs = Referral_programs::first();

        if(empty($referral_programs)){
            $referral_programs = new Referral_programs;
        }

        $referral_programs->referral_value = $request->referral_value;
        $referral_programs->max_value = $request->max_value;
        $referral_programs->status = $request->status;
        $referral_programs->save();

        return redirect('admin/referral-program')->with('Insert_Message','Data Saved Successfully');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
