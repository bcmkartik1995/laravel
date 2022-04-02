<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Faq;

class FaqController extends Controller
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
    public function index(Request $request,$service_id)
    {
        $faqs = Faq::where('service_id',$service_id)->get();

        return view('admin.service_faq.index',compact('faqs','service_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request,$service_id)
    {
        return view('admin.service_faq.create',compact('service_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // echo '<pre>';
        // print_R($request->all());die;

        $rules = [
            'question' => 'required',
            'answer' => 'required',
        ];
        $this->validate($request, $rules);

        $service_faq = new Faq;
        $service_faq->service_id = $request->input('service_id');
        $service_faq->question = $request->input('question');
        $service_faq->answer = $request->input('answer');

        $service_faq->save();

        return redirect()->route('service_faq.index', $service_faq->service_id)->with('Insert_Message', 'Data Created Successfully.');
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
        $faq = Faq::findOrFail($id);

        return view('admin.service_faq.edit',compact('faq','id'));
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
            'question' => 'required',
            'answer' => 'required',
        ];
        $this->validate($request, $rules);

        $service_faq = Faq::find($id);
        $service_faq->question = $request->input('question');
        $service_faq->answer = $request->input('answer');

        $service_faq->save();

        return redirect()->route('service_faq.index', $service_faq->service_id)->with('update_message', 'Data Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service_faq = Faq::find($id);
        $service_faq->delete();
        return response()->json(['success' => 1, 'message' => 'Data Deleted successfully']);
    }
}
