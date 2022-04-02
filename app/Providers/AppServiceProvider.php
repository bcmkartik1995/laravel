<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Country;
use App\Franchise_work_cities;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Collection;
use App;
use Auth;
use App\Service;
use App\Package;
use App\Orders;
use App\My_cart;
use App\City;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $admin_lang = DB::table('admin_languages')->where('is_default','=',1)->first();
        App::setlocale($admin_lang->name);

        view()->composer('*',function($settings){
            $settings->with('gs', DB::table('generalsettings')->find(1));
            $settings->with('seo', DB::table('seotools')->find(1));
            //$settings->with('categories', Category::where('status','=',1)->get());

            $serving_countries = Country::with(['state' => function($query){
                $query->where(['status' => 1])->with(['city' => function($query){
                    $query->where(['status' => 1]);
                }]);
            }])
            ->where(['status' => 1])->get();

            $serving_countries = Franchise_work_cities::where(['franchise_work_cities.status' => 1])
                ->join('cities As c', function ($sub_join) {
                    $sub_join->on('c.id', '=', 'franchise_work_cities.city_id');
                })
                ->join('states AS s', function ($sub_join) {
                    $sub_join->on('c.state_id', '=', 's.id');
                })
                ->join('countries', function ($sub_join) {
                    $sub_join->on('s.country_id', '=', 'countries.id');
                })
                ->select('c.id as city_id', DB::raw('count(c.id) as city_count'),'c.name as city','countries.name as country_name','countries.id As country_id')
                ->groupBy('c.id')
                ->orderBy('city_count','desc')
                ->limit(20)
                ->get();

            $serving_countries = new Collection($serving_countries);
            $serving_countries = $serving_countries->groupBy('country_name');
            $settings->with('serving_countries', $serving_countries);
            
            //For cart

            $my_cart_session = [];
            if (Auth::check()) {
                $id = Auth::user()->id;
                $My_cart = My_cart::where('user_id', $id)->first();
                if($My_cart){
                    $my_cart_session = $My_cart->cart_data;
                }
            }
            else{
                if(empty($my_cart_session)){
                    $my_cart_session = Session::has('my_cart') ? Session::get('my_cart') : [];
                }
            }
            
            $session_cart = $my_cart_session;
            
           // if(!empty($session_cart)){
                Session::put('my_cart', $session_cart);
          //  }
            

           // $session_cart = Session::get('my_cart');
            $session_cart['total_items'] = 0;
            if(!empty($session_cart['services'])){
                foreach($session_cart['services'] as $k => $serv){
                    $get_serv = Service::findOrFail($serv['id']);
                    $session_cart['services'][$k]['title'] = $get_serv->title;
                    $session_cart['services'][$k]['banner'] = $get_serv->banner;
                    $session_cart['total_items']++;
                }
            }
            if(!empty($session_cart['packages'])){
                foreach($session_cart['packages'] as $k => $pack){
                    $get_pack = Package::findOrFail($pack['id']);
                    $session_cart['packages'][$k]['title'] = $get_pack->title;
                    $session_cart['packages'][$k]['banner'] = $get_pack->banner;
                    $session_cart['total_items']++;
                }
            }
            $settings->with('session_cart', $session_cart);

            // For Order payment links
            $orders_pay_links = [];
            if(Auth::guard('web')->user()){
                $orders_pay_links = Orders::select(['id','user_id','method','pay_amount','order_number','payment_status','status','cart','unallocated'])
                    ->where(['user_id' => Auth::guard('web')->user()->id, 'payment_status' => 'Pending'])
                    ->whereIN('status', ['pending','processing','completed','on delivery'])
                    ->orderBy('orders.id', 'DESC')
                    ->get()
                    ->toArray();
            }
            // echo '<pre>';
            // print_R($orders_pay_links);die;
            $settings->with('orders_pay_links', $orders_pay_links);

            $all_cities = City::where(['status' => 1])->select('id','name','state_id')->get();
            $settings->with('all_cities', $all_cities);


            if (Session::has('language'))
            {
                $data = DB::table('languages')->find(Session::get('language'));
                $data_results = file_get_contents(public_path().'/assets/languages/'.$data->file);
                $lang = json_decode($data_results);
                $settings->with('langg', $lang);
            }
            else
            {
                $data = DB::table('languages')->where('is_default','=',1)->first();
                $data_results = file_get_contents(public_path().'/assets/languages/'.$data->file);
                $lang = json_decode($data_results);
                $settings->with('langg', $lang);
            }

            if (!Session::has('popup'))
            {
                $settings->with('visited', 1);
            }
            Session::put('popup' , 1);
        });
    }
}
