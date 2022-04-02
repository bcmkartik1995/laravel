<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;
use Stevebauman\Location\Facades\Location;
use Illuminate\Validation\Rule;
use Datatables;
use App\City;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function datatables(Request $request)
    {
        $datas = User::leftjoin("cities AS c", function ($join){
            $join->on('users.city', '=', 'c.id');
        });

      //  $datas = User::where(['status' => 1]);

        if(isset($request->searchByCity) && !empty($request->searchByCity)){
            $datas->where('users.city',$request->searchByCity);
        }
        

        $datas = $datas->select('users.*', 'c.name as user_city')->orderBy('users.id', 'desc')->get();
        
        return Datatables::of($datas)
                            ->addColumn('user_city', function($data){
                                if($data->user_city == ''){
                                    return '-';
                                }else{
                                    return $data->user_city;
                                }
                            })
                            ->addColumn('action', function(User $data) {
                                return '<a href="javascript:void(0);" data-href="'. route('users.destroy',$data->id) .'" class="btn btn-danger btn-sm mr-25 delete">Detete</a>';
                            }) 
                            ->rawColumns(['action','user_city'])
                            ->toJson();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::where(['status' => 1])->select(['id','name'])->get();

        return view('admin.users.index',compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'mobile' => ['required', 'numeric', 'digits:10', 'unique:users,phone'],
            'password' => ['required','min:5'],
            'confirm_password' => ['required','min:5','same:password']
        ]);

        $ip = $request->ip();
        $data = \Location::get($ip);
        
        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('mobile');
        $user->password = Hash::make($request->input('password'));
        $user->latitude = $data->latitude;
        $user->longitude = $data->longitude;
        $user->ipaddress = $ip;

        $user->save();

        return redirect()->route('users.index')->with('Insert_Message', "The $user->name was saved successfully");
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
        $user = User::findOrFail($id);
        return view('admin.users.edit',compact('user'));
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required','string', 'email', 'max:255', Rule::unique('users')->ignore($id)],
            'mobile' => ['required', 'numeric', 'digits:10', 'unique:users,phone,'.$id.',id,deleted_at,NULL'],
            'password' => ['sometimes','nullable','min:5']
        ]);

        $user = User::findOrFail($id);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('mobile');
        $user->password = Hash::make($request->input('password'));

        $user->save();

        //$user->update(array_merge($request->all(),['password' => Hash::make($request->password)]));

        return redirect()->route('users.index')->with('update_message', "The $user->name was updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return response()->json(['success' => 1, 'message' => 'Data Deleted successfully']);
    }
}
