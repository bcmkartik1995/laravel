<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\News_letter;
use Mail;

class NewsletterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news_letter = News_letter::get();
        
        return view('admin.news_letter.index',compact('news_letter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $news_letters = News_letter::where('status','=',1)->get();

        // echo '<pre>';
        // print_R($news_letters);die;
        return view('admin.news_letter.sendnews',compact('news_letters'));
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
            'description'=>'required',
        ]);
        

        if($request->all_user == 1){
            $mails = News_letter::where('status','=',1)->pluck('email')->toArray();
        }else{
            $request->validate([
                'mails'=>'required',
            ]);
            $mails = $request->mails;
        }

        $data = [
            'description' => $request->description,
            'email' => $mails,
        ];

        foreach($data['email'] as $d){
            Mail::send('admin.news_letter.mail.sendmail', $data, function($message)use($d) {            
                $message->to($d)
                    ->subject('News Letter From '.env('APP_NAME'));
            });
        }
        return redirect()->back()->with('Insert_Message', 'Mail Sent Successfully');
        
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
        $news_letter = News_letter::findOrFail($id);
        $news_letter->delete();

        return response()->json(['success' => 1, 'message' => 'Data Deleted successfully']);
    }
}
