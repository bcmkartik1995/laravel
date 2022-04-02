<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Offer;
use App\Best_offers;

class BestofferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offers = Best_offers::with(['offer' => function ($query) {
            $query->select('title','id');
        }])
        ->select('id','offer_id','status')
        ->get();

        return view('admin.best_offer.index',compact('offers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $offers = Offer::select('id','title')->get();

        return view('admin.best_offer.create',compact('offers'));
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
            'offer_id' => 'required',
        ]);

        $best_offer = new Best_offers;
        $best_offer->offer_id = $request->input('offer_id');

        
        $best_offer->save();

        return redirect('admin/best-offer')->with('Insert_Message','Data Created Successfully');
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
        $best_offer = Best_offers::findOrFail($id);

        $offers = Offer::select('id','title')->get();

        return view('admin.best_offer.edit',compact('best_offer','offers'));
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
            'offer_id' => 'required',
        ]);

        $best_offer = Best_offers::find($id);
        $best_offer->offer_id = $request->input('offer_id');

        
        $best_offer->save();

        return redirect('admin/best-offer')->with('update_message','Data Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $best_offer = Best_offers::find($id);
        $best_offer->delete();
        
        return response()->json(['success' => 1, 'message' => 'Data Deleted successfully']);
    }
}
