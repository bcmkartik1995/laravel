<?php

namespace App\Http\Controllers\Front;

use App\Classes\GeniusMailer;
use App\Http\Controllers\Controller;
use App\Models\Counter;
use App\Models\Generalsetting;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use InvalidArgumentException;
use Markury\MarkuryPost;
use App\Referral_programs;
use App\User_referrals;
use App\Best_offers;


use App\Category;
use App\SubCategory;
use App\Service;
use App\Country;
use App\State;
use App\City;
use App\Lead;
use App\Package;
use App\Package_service;
use App\My_cart;
use App\Offer;
use Carbon\CarbonPeriod;
use App\User_address;
use App\Orders;
use Illuminate\Support\Str;
use App\Services_ratings;
use App\Packages_ratings;
use App\Franchise;
use App\Franchises_order;
use App\Franchise_plans;
use App\Best_service;
use App\contact_us;
use App\News_letter;
use Auth;
use Validator;
use App\Aboutus;
use Illuminate\Support\Collection;
use App\Slider;
use App\Worker_assigned_services;
use App\Request_quotes;
use App\Blog;
use App\Order_tracks;
use App\Order_review;
use App\Ordered_services;
use App\GiftCard;
use App\Gift_user;
use App\Our_team;
use App\Models\Admin;
use App\Notification;
use App\Testimonial;
use App\Franchise_worker;
use Mail;

use Spatie\Geocoder\Geocoder;

class FrontendController extends Controller
{

    public function __construct()
    {

    }

    function getOS() {

        $user_agent     =   !empty($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "Unknown";

        $os_platform    =   "Unknown OS Platform";

        $os_array       =   array(
            '/windows nt 10/i'     =>  'Windows 10',
            '/windows nt 6.3/i'     =>  'Windows 8.1',
            '/windows nt 6.2/i'     =>  'Windows 8',
            '/windows nt 6.1/i'     =>  'Windows 7',
            '/windows nt 6.0/i'     =>  'Windows Vista',
            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     =>  'Windows XP',
            '/windows xp/i'         =>  'Windows XP',
            '/windows nt 5.0/i'     =>  'Windows 2000',
            '/windows me/i'         =>  'Windows ME',
            '/win98/i'              =>  'Windows 98',
            '/win95/i'              =>  'Windows 95',
            '/win16/i'              =>  'Windows 3.11',
            '/macintosh|mac os x/i' =>  'Mac OS X',
            '/mac_powerpc/i'        =>  'Mac OS 9',
            '/linux/i'              =>  'Linux',
            '/ubuntu/i'             =>  'Ubuntu',
            '/iphone/i'             =>  'iPhone',
            '/ipod/i'               =>  'iPod',
            '/ipad/i'               =>  'iPad',
            '/android/i'            =>  'Android',
            '/blackberry/i'         =>  'BlackBerry',
            '/webos/i'              =>  'Mobile'
        );

        foreach ($os_array as $regex => $value) {

            if (preg_match($regex, $user_agent)) {
                $os_platform    =   $value;
            }

        }
        return $os_platform;
    }


// -------------------------------- HOME PAGE SECTION ----------------------------------------

    public function get_location_city($location_search)
    {
        $country_name = $location_search['country'];
        $state_name = $location_search['state'];
        $city_name = $location_search['city'];

        $get_city = Country::where(['countries.name' => $country_name, 'countries.status' => 1])
            ->join("states AS s", function ($join) use ($state_name) {
                $join->on('countries.id', '=', 's.country_id')->where(['s.status' => 1, 's.name' => $state_name]);
            })
            ->join("cities AS c", function ($join) use ($city_name) {
                $join->on('s.id', '=', 'c.state_id')->where(['c.status' => 1, 'c.name' => $city_name]);
            })
            ->first();

        $city_id = null;
        if ($get_city) {
            $city_id = $get_city->id;
        }
        return $city_id;
    }
    public function index()
    {
        $cat = Category::where(['categories.status' => 1]);
        //Session::forget('location_search');
        if (Session::has('location_search')) {

            $location_search = Session::get('location_search');
            $lat = $location_search['lat'];
            $lng = $location_search['lng'];
            //$city_id = $this->get_location_city($location_search);

            $cat->leftjoin("services AS s", function ($join) use($lat, $lng) {
                $join->on('categories.id', '=', 's.category_id')

                    ->join('franchise_services As fc', function ($join) {
                        $join->on('fc.service_id', '=', 's.id');
                    })
                    ->join('franchises As f', function ($join) {
                        $join->on('fc.franchise_id', '=', 'f.id');
                    })
                    ->where('f.area_lat1', '>=', $lat)
                    ->where('f.area_lng1', '<=', $lng)
                    ->where('f.area_lat2', '<=', $lat)
                    ->where('f.area_lng2', '>=', $lng)
                    ->where(['s.deleted_at' => null, 's.status' => 1,'fc.deleted_at' => null,'f.status' => 1]);
            })
            ->leftjoin("services AS ss", function ($join) use($lat, $lng) {
                $join->on('categories.id', '=', 'ss.category_id')
                    ->join('package_services AS pss', function ($join) {
                        $join->on('pss.service_id', '=', 'ss.id');
                    })
                    ->join('packages AS p', function ($join) {
                        $join->on('p.id', '=', 'pss.package_id');
                    })
                    ->join('franchise_services As fcc', function ($join) {
                        $join->on('fcc.service_id', '=', 'ss.id');
                    })
                    ->join('franchises As ff', function ($join) {
                        $join->on('fcc.franchise_id', '=', 'ff.id');
                    })
                    ->where('ff.area_lat1', '>=', $lat)
                    ->where('ff.area_lng1', '<=', $lng)
                    ->where('ff.area_lat2', '<=', $lat)
                    ->where('ff.area_lng2', '>=', $lng)
                    ->where(['ss.deleted_at' => null, 'ss.status' => 1,'fcc.deleted_at' => null,'f.status' => 1]);
            })
            ->select('categories.*',  DB::raw('count(s.category_id) as service_count'),  DB::raw('count(ss.category_id) as package_count'))
            ->havingRaw('service_count > 0 OR package_count > 0');
        }
        $cat = $cat->groupBy('categories.id')->get();

        // echo '<pre>';
        // print_R($cat);die;
        //$subcategories = SubCategory::select('id','category_id','title','slug','note','logo','sub_note','status')->get();

        $categories = $cat->chunk(6);

        $Best_services = Best_service::with(['service'])->where(['status' => 1])->get();

        $customer_reviews = Services_ratings::with(['user' => function($query){
            $query->select('name','id','photo');
        }])
        ->select(['id','service_id','user_id','service_rating','description','images'])->where(['status' => 1])->limit(12)->orderBy('id','desc')->get();

        $Referral_programs = Referral_programs::where(['status' => 1])->first();

        $today = Carbon::now()->format('Y-m-d');
        $best_offers = Best_offers::with(['offer'])
        ->join('offers As f', function ($sub_join) {
            return $sub_join->on('best_offers.offer_id', '=', 'f.id');
        })
        ->where(['f.status' => 1,'best_offers.status' => 1, 'f.deleted_at' => null])
        ->where('f.start_date', '<=', $today)
        ->where('f.end_date', '>=', $today)
        ->select('best_offers.*')
        ->get();

        $main_sliders = Slider::where(['status' => 1])->get();

        $all_services = Service::where(['status' => 1])->select('id','title')->get();

        //Added for dynamik user on home page kano
        $users = DB::table('users')->get();

        $testimonials = Testimonial::where(['status' => 1])->get();

        return view('front.index', compact('categories','users','Best_services','customer_reviews','Referral_programs','best_offers','main_sliders','all_services','testimonials'));
    }

    public function service_search(Request $request){

        $query = null;
        $services = [];
        if (Session::has('location_search')) {
            if(isset($request['query'])){
                $query = $request['query'];
            }
            $location_search = Session::get('location_search');

            // $city_id = $this->get_location_city($location_search);
            $lat = $location_search['lat'];
            $lng = $location_search['lng'];

            $services = Service::join('franchise_services As fc', function ($join) use($lat, $lng) {
                $join->on('fc.service_id', '=', 'services.id');
            })
            ->join('franchises As f', function ($join) {
                $join->on('fc.franchise_id', '=', 'f.id');
            })
            ->leftJoin('services_ratings As sr', function ($join) {
                $join->on('sr.service_id', '=', 'services.id');
            })
            ->join('categories As c', function ($sub_join) {
                return $sub_join->on('services.category_id', '=', 'c.id');
            })
            ->select('services.id','services.title','services.category_id','c.slug as category_slug')
            ->where('services.title', 'LIKE', "%{$query}%")
            ->where(['services.status' => 1,'fc.deleted_at' => null])
            ->where('f.area_lat1', '>=', $lat)
            ->where('f.area_lng1', '<=', $lng)
            ->where('f.area_lat2', '<=', $lat)
            ->where('f.area_lng2', '>=', $lng)
            ->groupBy('services.id');

            $services = $services->get();
        }
        return response()->json($services);
    }


    public function about()
    {
        $Aboutus = Aboutus::where(['status' => 1])->first();
        $our_team = Our_team::where(['status' => 1])->get();
        $services_count = Service::where(['status' => 1,'deleted_at' => null])->count();

        return view('front.about', compact('Aboutus','services_count','our_team'));
    }

    public function registerProfessional()
    {
        $id = Auth::id();
        $country = Country::where('status', 1)->get();
        return view('front.registerProfessional', compact('country'));
    }
    public function getState(Request $request) {
        $country_id = $request->country_id;
        $state['states'] = State::where('country_id', $country_id)->where('status', 1)->get();
        return response()->json($state);
    }

    public function getCity(Request $request)
    {
        $state_id = $request->state_id;
        $city['city'] = City::where('state_id', $state_id)->where('status', 1)->get();
        return response()->json($city);
    }
    public function areaCategory()
    {
        return view('front.areaCategory');
    }

    public function gifts()
    {
        return view('front.gifts');
    }

    public function serviceList(Request $request, $cat_slug, $sub_cat_slug = null)
    {
        if (!Session::has('location_search')) {
            return redirect('/');
        }

        $location_search = Session::get('location_search');
        $lat = $location_search['lat'];
        $lng = $location_search['lng'];
         $city_id = $this->get_location_city($location_search);

        $cat = Category::where('slug', $cat_slug)->first();
        $category_id = $cat->id;
        $sub_cat = SubCategory::where(['category_id' => $cat->id, 'status' => 1])->get();

        $all_packages = Package::with(['package_services' => function ($query) {
            $query->select('*')->with(['service']);
        }])
        ->select('packages.*', DB::raw('count(pr.id) as review_count'), DB::raw('avg(pr.package_rating) as review_avg'))
        ->join('package_services AS ps', function($join){
            $join->on('ps.package_id', '=', 'packages.id')->where(['ps.deleted_at' => null]);
        })
        ->join('services AS s', function($join){
            $join->on('ps.service_id', '=', 's.id')->where(['s.deleted_at' => null]);
        })
        ->join('franchise_services As fc', function ($join) use($lat, $lng) {
            $join->on('fc.service_id', '=', 's.id')->where(['fc.deleted_at' => null]);
        })
        ->join('franchises As f', function ($join) {
            $join->on('fc.franchise_id', '=', 'f.id')->where(['f.deleted_at' => null]);
        })
        ->where('s.category_id', $category_id)
        ->where('f.area_lat1', '>=', $lat)
        ->where('f.area_lng1', '<=', $lng)
        ->where('f.area_lat2', '<=', $lat)
        ->where('f.area_lng2', '>=', $lng)
        ->where(['s.status' => 1,'packages.status' => 1,'fc.deleted_at' => null])
        ->leftJoin('packages_ratings As pr', function ($join) {
            $join->on('pr.package_id', '=', 'packages.id');
        });


        $sub_category = null;
        $sub_category_id = null;
        if (!empty($sub_cat_slug)) {
            $sub_category = SubCategory::where('slug', $sub_cat_slug)->first();
            if($sub_category){
                $sub_category_id = $sub_category->id;
                $all_packages->join('package_subcategories AS psc', function($join){
                    $join->on('psc.package_id', '=', 'packages.id');
                })->where('psc.sub_category_id', $sub_category_id);
            }

        }
        $all_packages = $all_packages->groupBy('packages.id')->get();


        // echo '<pre>';
        // print_R($all_packages);die;
        $services = [];
        if($sub_cat_slug!='all-package'){
            $services = Service::with(['service_media'])
                ->select('services.*', DB::raw('count(sr.id) as review_count'), DB::raw('avg(sr.service_rating) as review_avg'))->where(['services.status' => 1, 'services.category_id' => $category_id]);
            if (!empty($sub_cat_slug)) {
                $services->where('services.sub_category_id', $sub_category_id);
            }


            $services->join('franchise_services As fc', function ($join) use($lat, $lng) {
                $join->on('fc.service_id', '=', 'services.id');
            })
            ->join('franchises As f', function ($join) {
                $join->on('fc.franchise_id', '=', 'f.id');
            })
            ->leftJoin('services_ratings As sr', function ($join) {
                $join->on('sr.service_id', '=', 'services.id');
            })
            ->where('f.area_lat1', '>=', $lat)
            ->where('f.area_lng1', '<=', $lng)
            ->where('f.area_lat2', '<=', $lat)
            ->where('f.area_lng2', '>=', $lng)
            ->where(['services.status' => 1,'fc.deleted_at' => null])
            ->groupBy('services.id');

            $services = $services->get();
        }


        $where = [
            'services_ratings.status' => 1,
            'category_id' => $category_id
        ];

        if (!empty($sub_cat_slug)) {
            $where['sub_category_id'] = $sub_category_id;
        }

        $Services_ratings = Services_ratings::where($where)->join('services', 'services.id', '=', 'services_ratings.service_id')->get();
        /*start code for package ratings */
        $Packages_ratings = Packages_ratings::where(['packages_ratings.status' => 1])->join('packages', 'packages.id', '=', 'packages_ratings.package_id')->get();
        $total_review_count_package = count($Packages_ratings);

        $collection_package = collect($Packages_ratings);

        $total_review_package = $collection_package->sum('package_rating');
        $review_ratingss_package = !empty($total_review_count_package) ? ($total_review_package / $total_review_count_package) : 0;
        $review_ratings_package = round($review_ratingss_package, 1);

        /*end code for package ratings */

        /*Start Code for Service Ratings */
        $total_review_count_service = count($Services_ratings);

        $collection_service = collect($Services_ratings);

        $total_review_service = $collection_service->sum('service_rating');
        $review_ratingss_service = !empty($total_review_count_service) ? ($total_review_service / $total_review_count_service) : 0;
        $review_ratings_service = round($review_ratingss_service, 1);
        /*End Code For Service Ratings */

        /*Start Code For Sum of Rating of Packages and Services*/
        $total_review = $total_review_package + $total_review_service;
        $total_review_ratings = $review_ratingss_package + $review_ratingss_service;
        $total_review_count = $total_review_count_service + $total_review_count_package;
        $review_ratingss = !empty($total_review_ratings) ? ($total_review / $total_review_count) : 0;
        $review_ratings = round($review_ratingss, 1);
        /*End Code For Sum of Rating of Packages and Services */

        /* $total_review_count = count($Services_ratings);

        $collection = collect($Services_ratings);

        $total_review = $collection->sum('service_rating');
        $review_ratingss = !empty($total_review_count) ? ($total_review/$total_review_count) : 0;
        $review_ratings = round($review_ratingss,1);   */

        // return view('front.services',compact('cat', 'sub_cat','all_packages','services', 'total_review', 'review_ratings', 'total_review_count'));

        $my_cart = [];
        if (Auth::check()) {
            $id = Auth::user()->id;
            $My_cart = My_cart::where('user_id', $id)->first();
            if($My_cart){
                $my_cart = $My_cart->cart_data;
            }
        }
        $my_cart = Session::has('my_cart') ? Session::get('my_cart') : $my_cart;

        // echo '<pre>';
        // print_R($sub_category->title);die;

        $image_formats = ['jpg','png','jpeg','gif'];
        return view('front.services', compact('cat', 'sub_cat', 'all_packages', 'services', 'total_review', 'review_ratings', 'total_review_count', 'my_cart','sub_cat_slug','sub_category','sub_category_id','image_formats'));
    }

    public function register(Request $request, $countries, $states, $cities)
    {
        $user_id = Auth::id();
        $country = $countries;
        $state = $states;
        $city = $cities;
        return view('front.register', compact('user_id', 'country', 'state', 'city'));
    }

    public function addProfessionalUser(Request $request)
    {

        $request->validate([
            'country_id' => 'required',
            'state_id' => 'required',
            'name' => 'required|string|max:50',
            'city_id' => 'required',
            'email' => 'required|string|email|max:255|unique:admins,email,NULL,id,deleted_at,NULL|unique:leads,email,NULL,id,deleted_at,NULL',
            'phone' => 'required|numeric|unique:admins,phone,NULL,id,deleted_at,NULL|unique:leads,phone,NULL,id,deleted_at,NULL',
            'skill' => 'required',
        ], [
            'country_id.required' => 'Please select your country',
            'state_id.required' => 'Please select your state',
            'name.required' => 'Please enter your name',
            'city_id.required' => 'Please select your city',
            'email.required' => 'Please enter your email',
            'phone.required' => 'Please enter your phone number',
            'skill.required' => 'Please enter what do you do ?'
        ]);

        $country_id = $request->country_id;
        $state_id = $request->state_id;
        $city_id = $request->city_id;

        $data = [
            'name' => $request->name,
            'country_id' => $country_id,
            'state_id' => $state_id,
            'city_id' => $city_id,
            'email' => $request->email,
            'phone' => $request->phone,
            'skill' => $request->skill
        ];
        $user = Lead::create($data);
        return redirect('/Register-as-Professional')->with('success', 'Registration done successfully');
    }

    public function viewpackage(Request $request)
    {
        $package_id = $request->package_id;
        $package = Package_service::where('package_id', $package_id)->get();
        $package_array = array();
        foreach ($package as $mypackage) {
            $package_array[] = $mypackage['service_id'];
        }
        $service = Service::whereIn('id', $package_array)->get();
        return $service;
    }

    public function add_cart_detail(Request $request) {

        $service_data = array();
        $package_array = array();
        if ($request->package_name) {
            $package_array = $request->package_name;
            $all_package_id = array();
            foreach ($package_array as $package => $value) {
                $all_package_id[] = $value;
            }
            $package = Package::whereIn('id', $all_package_id)->get();
            $package_array = array();
            $package_service_array = array();
            $service_array = array();
            $a = 0;
            foreach ($package as $pack) {
                $package_array[$a]['package']['package_id'] = $pack->id;
                $package_array[$a]['package']['package_name'] = $pack->title;
                $package_array[$a]['package']['discount_type'] = $pack->discount_type;
                $package_array[$a]['package']['discount_value'] = $pack->discount_value;
                $package_service = Package_service::where('package_id', $pack->id)->get();
                foreach ($package_service as $pack_service => $val) {
                    $package_service_array[] = $val->service_id;
                }
                $service = Service::whereIn('id', $package_service_array)->get();
                $b = 0;
                foreach ($service as $serve) {
                    $package_array[$a]['package'][$b]['service']['service_id'] = $serve->id;
                    $package_array[$a]['package'][$b]['service']['service_name'] = $serve->title;
                    $package_array[$a]['package'][$b]['service']['service_price'] = $serve->price;
                    $b++;
                }
                $a++;
            }
            if ($request->service_name) {
                $service_name = $request->service_name;
                foreach ($service_name as $served => $value) {
                    $service_data[] = $value;
                }
                $services = Service::whereIn('id', $service_data)->get();
                $b = 0;
                foreach ($services as $serve) {
                    $package_array[$b]['services']['service_id'] = $serve->id;
                    $package_array[$b]['services']['service_name'] = $serve->title;
                    $package_array[$b]['services']['service_price'] = $serve->price;
                    $b++;
                }
            }
        } else {
            $service_name = $request->service_name;
            foreach ($service_name as $served => $value) {
                $service_data[] = $value;
            }
            $services = Service::whereIn('id', $service_data)->get();
            $b = 0;
            foreach ($services as $serve) {
                $package_array[$b]['services']['service_id'] = $serve->id;
                $package_array[$b]['services']['service_name'] = $serve->title;
                $package_array[$b]['services']['service_price'] = $serve->price;
                $b++;
            }
        }
        $data =  $package_array;
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $cart_detail = new Cart_detail;
            $cart_detail->user_id = $user_id;
            $cart_detail->detail = json_encode($data);
        } else {
            $_SESSION['cart_detali'] = json_encode($data);
        }
    }

    public function create_cart_session(Request $request)
    {
        if(isset($request->action) && $request->action == 'view-cart'){
            //if (!session()->has('user.url.intended')) {
                session(['user.url.intended' =>  route('mycart')]);
                return response()->json(['success' => 1, 'isUserLogin' => Auth::check(), 'url' => route('mycart')]);
            //}
        }
        //print_R($request->action);die;
        $my_cart_data = $request->my_cart;
        // print_R($my_cart_data);die;
        if (!empty($my_cart_data['packages'])) {
            $collection = collect($my_cart_data['packages']);
            $my_cart_data['packages'] = $collection->mapWithKeys(function ($item) {
                return [$item['id'] => $item];
            })->toArray();
        }
        if (!empty($my_cart_data['services'])) {
            $collection = collect($my_cart_data['services']);
            $my_cart_data['services'] = $collection->mapWithKeys(function ($item) {
                return [$item['id'] => $item];
            })->toArray();
        }

        Session::put('my_cart', $my_cart_data);
        if (Auth::check()) {
            $id = Auth::user()->id;

            $My_cart = My_cart::where('user_id', $id)->first();
            if ($My_cart) {
                $My_cart->cart_data = $my_cart_data;
                $My_cart->save();
            } else {

                $My_cart = new My_cart;
                $My_cart->user_id = $id;
                $My_cart->cart_data = $my_cart_data;
                $My_cart->save();
            }
        }


        $session_cart = Session::get('my_cart');
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


        return view('load.cart', compact('session_cart'));
        //return response()->json(['success' => 1, 'isUserLogin' => Auth::check()]);
    }

    public function mycart() {
        $my_cart_data = Session::get('my_cart');
        // if (Auth::check()) {
        //     $id = Auth::user()->id;
        //     $My_cart = My_cart::where('user_id', $id)->first();
        //     if (!empty($my_cart_data)) {
        //         if ($My_cart) {
        //             $My_cart->cart_data = $my_cart_data;
        //             $My_cart->save();
        //         } else {

        //             $My_cart = new My_cart;
        //             $My_cart->user_id = $id;
        //             $My_cart->cart_data = $my_cart_data;
        //             $My_cart->save();
        //         }
        //     } else {
        //         if(!empty($My_cart)){
        //             $my_cart_data = $My_cart->cart_data;
        //             Session::put('my_cart', $my_cart_data);
        //         }
        //     }
        // }

        // if($id == 33){
        //   // echo '<pre>';
        //   // print_r($my_cart_data);die;
        // }

        if (!empty($my_cart_data['packages'])) {
            foreach ($my_cart_data['packages'] as $key => $value) {
                $package = Package::with(['package_services' => function ($query) use ($value) {
                    $query->with(['service'])->whereIn('service_id', $value['services']);
                }])->where('id', $value['id'])->first()->toArray();
                if (!empty($package)) {
                    $package['quantity'] = $value['quantity'];
                    $package['price'] = $value['price'];
                    $package['original_price'] = $value['original_price'];
                    $package['services'] = $value['services'];
                    $my_cart_data['packages'][$key] = $package;
                } else {
                    unset($my_cart_data['packages'][$key]);
                }
            }
        }
        if (!empty($my_cart_data['services'])) {
            foreach ($my_cart_data['services'] as $key => $value) {
                $service = Service::where('id', $value['id'])->first()->toArray();
                if (!empty($service)) {
                    $service['quantity'] = $value['quantity'];
                    $service['price'] = $value['price'];
                    $service['original_price'] = $value['original_price'];
                    $my_cart_data['services'][$key] = $service;
                } else {
                    unset($my_cart_data['services'][$key]);
                }
            }
        }

        $today = Carbon::now()->format('Y-m-d');
        $offers = Offer::with(['user_offer' => function ($query) {
            $query->where(['user_id' => Auth::user()->id, 'status' => 1]);
        }])->where('start_date', '<=', $today)->where('end_date', '>=', $today)->where(['status' => 1])->get();



        $gift_card = GiftCard::join('gift_users as gu','gift_cards.id','=','gu.gift_card_id')
        ->where(['gu.email'=>Auth::user()->email])->where('gift_cards.valid_from', '<=', $today)->where('gift_cards.valid_to', '>=', $today)
        ->where(['gift_cards.status' => 1])->get();



        foreach ($offers as $k => $offer) {
            if ($offer['is_user_specific'] == 1 && empty($offer['user_offer'])) {
                unset($offers[$k]);
            }
        }
        // echo '<pre>';
        // print_R($my_cart_data);die;
        return view('users.mycart', compact('my_cart_data', 'offers','gift_card'));
    }

    public function apply_offer(Request $request)
    {
        $user_id = Auth::user()->id;


        $today = Carbon::now()->format('Y-m-d');
        $offer = Offer::with(['user_offer' => function ($query) {
            $query->where(['user_id' => Auth::user()->id, 'status' => 1]);
        }])->where('start_date', '<=', $today)->where('end_date', '>=', $today)->where(['status' => 1, 'offer_code' => $request->offer_code])->first();


        if (!empty($offer)) {

            if ($offer->is_user_specific == 1 && empty($offer['user_offer'])) {
                return response()->json(['success' => 0, 'message' => 'Invalid offer code']);
            } else {
                $my_cart_data = Session::get('my_cart');

                $isOfferApplied = false;
                $total_price = 0;
                $total_applicable_price = 0;
                if (!empty($my_cart_data['packages'])) {
                    foreach ($my_cart_data['packages'] as $package) {
                        $total_price += $package['price'];
                        if ($offer->is_global == 1) {
                            $total_applicable_price += $package['price'];
                            $isOfferApplied = true;
                        }
                    }
                }

                if (!empty($my_cart_data['services'])) {
                    foreach ($my_cart_data['services'] as $service) {
                        $total_price += $service['price'];
                        if ($offer->is_global == 1) {
                            $isOfferApplied = true;
                            $total_applicable_price += $service['price'];
                        } else {
                            $service_data = Service::where('id', $service['id'])->first();
                            $isApplicable = false;
                            if ($offer->category_id == 0 || $offer->category_id == $service_data->category_id) {
                                $isApplicable = true;
                            }
                            if ($isApplicable == true && ($offer->sub_category_id == 0 || $offer->sub_category_id == $service_data->sub_category_id)) {
                                $isApplicable = true;
                            } else {
                                $isApplicable = false;
                            }
                            if ($isApplicable == true && ($offer->service_id == 0 || $offer->service_id == $service_data->id)) {
                                $isApplicable = true;
                            } else {
                                $isApplicable = false;
                            }
                            if ($isApplicable == true) {
                                $isOfferApplied = true;
                                $total_applicable_price += $service['price'];
                            }
                        }
                    }
                }

                if ($isOfferApplied == true) {
                    $discount = 0;
                    if ($offer->offer_type == 0) {
                        $discount = $offer->offer_value;
                    } else {
                        $discount = (($total_applicable_price * $offer->offer_value) / 100);
                        if ($discount > $offer->max_value) {
                            $discount = $offer->max_value;
                        }
                    }

                    $new_price = $total_price - $discount;

                    $offer->total_price = number_format($total_price,2,'.','');
                    $offer->new_price = number_format($new_price,2,'.','');
                    $offer->discount = number_format($discount,2,'.','');
                    return response()->json(['success' => 1, 'message' => 'Offer code applied successfully.', 'offer_data' => $offer]);
                } else {
                    return response()->json(['success' => 0, 'message' => 'Offer code not applicable to your order.']);
                }
            }
        }
        return response()->json(['success' => 0, 'message' => 'Invalid offer code']);
    }

    public function add_final_price(Request $request) {

        $My_cart = My_cart::where('user_id', Auth::user()->id)->first();
        if ($My_cart) {
            $My_cart->cart_data = array_merge($My_cart->cart_data, $request->data);
            $My_cart->save();
            return response()->json(['success' => 1, 'message' => 'success']);
        }
        return response()->json(['success' => 0, 'message' => 'Something went wrong']);
    }

    public function address()  {

        $curent_address_id = null;
        $curent_address_type = null;
        $slot_date = $slot_time = null;
        $My_cart = My_cart::where('user_id', Auth::user()->id)->first();
        if(isset($My_cart->cart_data['address_id']) && !empty($My_cart->cart_data['address_id'])){
            $curent_address_id = $My_cart->cart_data['address_id'];
            $curent_address_type = $My_cart->cart_data['address_type'];
            $slot_date = isset($My_cart->cart_data['slot_date']) ? $My_cart->cart_data['slot_date'] : null;
            $slot_time = isset($My_cart->cart_data['slot_time']) ? $My_cart->cart_data['slot_time'] : null;
        }

        // echo '<pre>';
        // print_R($My_cart->cart_data);die;

        $User_address = User_address::where('user_id', Auth::user()->id)->get();
        $User_address = new Collection($User_address);
        $User_address = $User_address->groupBy('type');

        $day_array = [];

        for ($i = 0; $i < 3; $i++) 
        {
            $start = Carbon::now();
            //$start = Carbon::parse('2021-10-07 11:29:00');
            $date = $start->addDay($i);

            if($date->format('i') > 30)
            {
                $date = $date->addMinute(120-$date->format('i'));
            }
            else
            {
                $date = $date->addMinute(90-$date->format('i'));
            }
            // echo '<pre>';
            // print_R($date);
            if ($i == 0) 
            {
                //$start_hour = $date->addHour(1)->format('H:i');
                $start_hour = $date->format('H:i');
            	if($start_hour < '08:00')
            	{
            		$start_hour = '08:00';
            	}
            	else
            	{
            		//$start_hour = $date->addHour(1)->format('H:i');
                    $start_hour = $date->format('H:i');
            	}
            } else {
                $start_hour = '08:00';
            }
            
            // echo '<pre>';
            // print_R($start_hour);die;
            $period = new CarbonPeriod($start_hour, '30 minutes', '20:00'); // for create use 24 hours format later change format
            $slots = [];
            foreach ($period as $item) {
                array_push($slots, $item->format("h:i A"));
            }

            if ($i == 0) {
                $day_name = 'Today';
            } elseif ($i == 1) {
                $day_name = 'Tomorrow';
            } else {
                $day_name = $date->format('D');
            }
            $day_array[] = [
                'date' => $date->format('Y-m-d'),
                'human_date' => $date->format('d/m/Y'),
                'slots' => $slots,
                'day_name' => $day_name,
                'day' => $date->format('d'),
            ];
        }

        return view('users.address', compact('User_address', 'day_array','curent_address_id','curent_address_type','slot_date','slot_time'));
    }

    public function save_user_address(Request $request) {

        $rules = [
            'flat_building_no' => 'required',
            'name' => 'required',
            'type' => 'required',
            'lat' => 'required',
            'phone' => ['required', 'numeric', 'digits:10']
        ];
        $messages = [
            'lat.required' => 'Please enter valid address',
            'phone.required' => 'Please enter mobile number',
            'phone.numeric' => 'Mobile number must be a number.',
            'phone.digits' => 'Mobile number must be 10 digits.',
            'type.required' => 'Please select address type.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()) {
            return response()->json(['success' => 0, 'errors' => $validator->errors()]);
        }


        // $address = User_address::where(['user_id' => Auth::user()->id, 'type' => $request->type])->first();
        // if ($address) {
            // $address->user_id = Auth::user()->id;
            // $address->flat_building_no = $request->flat_building_no;
            // $address->name = $request->name;
            // $address->address = $request->address;
            // $address->type = $request->type;
            // $address->country = $request->country;
            // $address->state = $request->state;
            // $address->city = $request->city;
            // $address->zip = $request->zip;
            // $address->latitude = $request->lat;
            // $address->longitude = $request->lng;
            // $address->save();
            // return response()->json(['success' => 1, 'message' => "Address saved successfully."]);
            //return redirect()->route('user.address')->with('success', 'Address saved successfully');
        // } else {
            $address = new User_address;
            $address->user_id = Auth::user()->id;
            $address->flat_building_no = $request->flat_building_no;
            $address->name = $request->name;
            $address->phone = $request->phone;
            $address->address = $request->address;
            $address->type = $request->type;
            $address->country = $request->country;
            $address->state = $request->state;
            $address->city = $request->city;
            $address->zip = $request->zip;
            $address->latitude = $request->lat;
            $address->longitude = $request->lng;

            $address->save();

            $My_cart = My_cart::where('user_id', Auth::user()->id)->first();
            $data = [];
            $data['address_id'] = $address->id;
            $data['address_type'] = $address->type;

            $My_cart->cart_data = array_merge($My_cart->cart_data, $data);
            $My_cart->save();
            // address_id
            return response()->json(['success' => 1, 'message' => "Address saved successfully."]);
            //return redirect()->route('user.address')->with('success', 'Address saved successfully');
        // }
    }

    public function save_address_time_slot(Request $request) {

        $My_cart = My_cart::where('user_id', Auth::user()->id)->first();
        if ($My_cart) {
            $data['slot_date'] = Carbon::createFromFormat('d/m/Y', $request->data['slot_date'])->format('Y-m-d');;
            $data['slot_time'] = $request->data['slot_time'];

            $address = User_address::where(['user_id' => Auth::user()->id, 'id' => $request->data['address_id']])->first();
            $data['flat_building_no'] = $address->flat_building_no;
            $data['address'] = $address->address;
            $data['address_id'] = $address->id;
            $data['customer_name'] = $address->name;
            $data['address_id'] = $address->id;
            $data['address_type'] = $address->type;

            $My_cart->cart_data = array_merge($My_cart->cart_data, $data);
            $My_cart->save();
            return response()->json(['success' => 1, 'message' => 'success']);
        }
        return response()->json(['success' => 0, 'message' => 'Something went wrong']);
    }

    public function payment_method() {

        $My_cart = My_cart::where('user_id', Auth::user()->id)->first();
        if (!$My_cart) {
            return redirect('/')->with('Insert_Message', 'Cart Is empty');
        }
        $cart_data = $My_cart->cart_data;
        $payment_method_type = null;
        if(isset($cart_data['payment_method_type'])){
            $payment_method_type = $cart_data['payment_method_type'];
        }

        $total_quantity = 0;
        if (!empty($cart_data['packages'])) {
            foreach ($cart_data['packages'] as $package) {
                $total_quantity++;
            }
        }
        if (!empty($cart_data['services'])) {
            foreach ($cart_data['services'] as $service) {
                $total_quantity++;
            }
        }
        return view('users.payment-method', compact('cart_data', 'total_quantity','payment_method_type'));
    }

    public function place_order(Request $request) {
        $validator = $request->validate([
            'payment_method_type' => 'required',
        ], ['payment_method_type.required' => 'Please select payment option']);

        $My_cart = My_cart::where('user_id', Auth::user()->id)->first();
        $cart_data = $My_cart->cart_data;
        $My_cart->cart_data = array_merge($cart_data, ['payment_method_type' => $request->payment_method_type]);
        $My_cart->save();



        if (!empty($cart_data['packages'])) {
            foreach ($cart_data['packages'] as $p => $package) {
                $get_package = Package::where('id', $package['id'])->first()->toArray();
                $package_service = Service::whereIn('id', $package['services'])->get()->toArray();

                $collection = collect($package_service);
                $package_service = $collection->mapWithKeys(function ($item) {
                    return [$item['id'] => $item];
                })->toArray();

                $cart_data['packages'][$p] = array_merge($package, $get_package);
                $cart_data['packages'][$p]['package_service'] = $package_service;
            }
        }
        if (!empty($cart_data['services'])) {
            foreach ($cart_data['services'] as $s => $service) {
                $get_service = Service::where('id', $service['id'])->first()->toArray();
                unset($get_service['price']);

                $cart_data['services'][$s] = array_merge($service, $get_service);
            }
        }

        $payment_type = $request->payment_method_type;
        $total_quantity = 0;
        if (!empty($cart_data['packages'])) {
            foreach ($cart_data['packages'] as $package) {
                $total_quantity += $package['quantity'];
            }
        }
        if (!empty($cart_data['services'])) {
            foreach ($cart_data['services'] as $service) {
                $total_quantity += $service['quantity'];
            }
        }

        $address = User_address::where(['user_id' => Auth::user()->id, 'id' => $cart_data['address_id']])->first();
        $latitude = $address->latitude;
        $longitude = $address->longitude;


        // Get frenchise with match city and cancellation retio desc
        $franchises = Franchise::where(['franchises.status' => 1])
            ->with(['franchise_workers' => function($query){
                $query->with(['worker_service' => function($query){
                    $query->where(['status'=>1]);
                }])->where(['status'=>1]);
            }])
            ->select(['franchises.*', DB::raw('count(fo.franchises_id) as cancel_count'),DB::raw("6371 * acos(cos(radians(" . $latitude . "))
            * cos(radians(latitude)) * cos(radians(longitude) - radians(" . $longitude . "))
            + sin(radians(" .$latitude. ")) * sin(radians(latitude))) AS distance"), 'fp.id as f_plan_id','fp.remain_credits as f_remain_credit'])
            ->leftjoin("franchises_orders AS fo", function ($join) {
                $join->on('franchises.id', '=', 'fo.franchises_id')->where('fo.status', 2)->where(['fo.deleted_at' => NULL]);
            })
            ->join("franchise_workers as fw", function ($join) {
                $join->on('franchises.id', '=', 'fw.franchises_id')->where(['fw.deleted_at' => NULL]);
            })
            ->leftjoin("franchise_plans as fp", function ($join) {
                $join->on('franchises.id', '=', 'fp.franchise_id')->where(['fp.deleted_at' => NULL]);
            })
            ->join('franchise_services As fc', function ($join) {
                $join->on('franchises.id', '=', 'fc.franchise_id')->where(['fc.deleted_at' => NULL]);
            })
           // ->where(['countries.name' => $address->country,'s.name' => $address->state,'c.name' => $address->city])
            ->where(function($query){
                $query->whereRaw('(end_date >= CURDATE() OR is_custom = 1)')->where('fp.remain_credits', '>',0)->where('fp.status', '=',1);
            })
            ->where('franchises.area_lat1', '>=', $latitude)
            ->where('franchises.area_lng1', '<=', $longitude)
            ->where('franchises.area_lat2', '<=', $latitude)
            ->where('franchises.area_lng2', '>=', $longitude)
            ->orderBy('distance', 'ASC')
            ->orderBy('cancel_count', 'ASC')
            ->orderBy('franchises.id', 'DESC')
            ->groupBy('franchises.id')
            ->get()->map(function($query){
                $query->f_services = $query->franchise_services->pluck('service_id')->toArray();
                $query->franchise_workers->map(function($q){
                    $q->w_services = $q->worker_service->pluck('service_id')->toArray();
                });
                return $query;
            });

        // echo $franchises->count();
        // echo '<pre>';
        // print_R($franchises->toArray());
        // die;
        //return 'ok'; 
        if($franchises->count())
        {
            // Group by franchise id
            $franchise_data = $cart_data;
            //echo '<pre>';print_R($franchise_data);die;
            $order_datetime = Carbon::parse($cart_data['slot_date'] . $cart_data['slot_time']);
            $order_datetime1 = $order_datetime->format('Y-m-d H:i:s');

            //// --------------------------NEED to check opening closing and offdays, also credit--------------------------------------
            $order_assign = [];

            // packages assign calculation
            if(!empty($franchise_data['packages']))
            {
                foreach($franchise_data['packages'] as $k => $f_package_data){
                    if(!empty($franchise_data['packages'][$k])){
                        foreach($franchises as $franchise){
                            if(!empty($franchise_data['packages'][$k])){
                                $worker_assigned_packages = [];
                                if(!empty($franchise->franchise_timings->count())){

                                    $collection = collect($franchise->franchise_timings);
                                    $franchise_timings = $collection->mapWithKeys(function ($item) {
                                        return [$item['day'] => $item];
                                    })->toArray();

                                    $off_days = $franchise->franchise_offday->pluck('off_date')->toArray();
                                    // if(!isset($f_package_data['franchises_id'])){

                                    // }
                                    if($f_package_data['franchises_id'] == 0 || $f_package_data['franchises_id'] == $franchise->id){
                                        $f_package = $f_package_data;
                                        $assigned_package  = [];
                                        // echo '<pre>';
                                        // print_R($f_package);die;
                                        $assignable_services = 0;

                                        $starting_date = $order_datetime;
                                        if($franchise->franchise_workers->count()){
                                            foreach($franchise->franchise_workers as $worker){
                                                foreach($f_package['package_service'] as $p_service){
                                                    $time_required = 0; // in minute
                                                    $travel_time_required = 0;
                                                    if(!empty($p_service['hour'])){
                                                        $time_required += $p_service['hour'] * 60;
                                                    }
                                                    if(!empty($p_service['minute'])){
                                                        $time_required += $p_service['minute'];
                                                    }

                                                    if(!empty($franchise->hour)){
                                                        $time_required += $franchise->hour * 60;
                                                    }
                                                    if(!empty($franchise->minute)){
                                                        $time_required += $franchise->minute;
                                                    }

                                                    if(!empty($franchise->hour)){
                                                        $travel_time_required += $franchise->hour * 60;
                                                    }
                                                    if(!empty($franchise->minute)){
                                                        $travel_time_required += $franchise->minute;
                                                    }

                                                    $time_required = $time_required * $f_package_data['quantity'];

                                                    if(in_array($p_service['id'], $franchise->f_services) && in_array($p_service['id'], $worker->w_services)){

                                                        $order_datetime_new = Carbon::parse($order_datetime);
                                                        $order_datetime1 = $order_datetime_new->format('Y-m-d H:i:s');
                                                        $check_order_datetime1 = $order_datetime_new->subMinute($travel_time_required)->format('Y-m-d H:i:s');

                                                        $order_datetime2 = $order_datetime_new->addMinute($time_required)->format('Y-m-d H:i:s');
                                                        $check_order_datetime2 = $order_datetime_new->addMinute($time_required+$travel_time_required)->format('Y-m-d H:i:s');

                                                        $worker_orders = Worker_assigned_services::where(['worker_id' => $worker->id])
                                                        ->where(function($query) use($check_order_datetime1, $check_order_datetime2){
                                                            $query->whereBetween('start_time', [$check_order_datetime1, $check_order_datetime2])
                                                            ->OrwhereBetween('end_time', [$check_order_datetime1, $check_order_datetime2]);
                                                        })
                                                        ->select(['id'])
                                                        ->get();

                                                        if($worker_orders->count() == 0){
                                                            if(isset($worker_assigned_packages[$worker['id']])){
                                                                $start_time = Carbon::parse($worker_assigned_packages[$worker->id]['end_time']);
                                                                $end_time = $start_time->addMinute($time_required)->format('Y-m-d H:i:s');

                                                                $time_required += $worker_assigned_packages[$worker->id]['take_time'];

                                                                $order_dates = [];
                                                                $period = CarbonPeriod::create($check_order_datetime1, $check_order_datetime2);
                                                                // Iterate over the period
                                                                foreach ($period as $date) {
                                                                    $order_dates[] = $date->format('Y-m-d');
                                                                }

                                                                $isOffday = false;
                                                                $isClosed = true;
                                                                $diff = array_intersect($off_days,$order_dates);
                                                                if(!empty($diff)){
                                                                    $isOffday = true;
                                                                }

                                                                $starttime = Carbon::parse($order_datetime1);
                                                                $start_dayname = strtolower($starttime->format('D'));
                                                                $start_date = strtolower($starttime->format('Y-m-d'));
                                                                $endtime = Carbon::parse($order_datetime2);
                                                                $end_dayname = strtolower($endtime->format('D'));

                                                                if(isset($franchise_timings[$start_dayname]) && isset($franchise_timings[$end_dayname])){

                                                                    $start_daytime = Carbon::parse($start_date.' '.$franchise_timings[$start_dayname]['open_time']);
                                                                    $end_daytime = Carbon::parse($start_date.' '.$franchise_timings[$end_dayname]['close_time']);
                                                                    if($start_daytime <= $starttime && $end_daytime >= $endtime){
                                                                        $isClosed = false;
                                                                    }

                                                                }

                                                                if($isOffday == false && $isClosed == false){
                                                                    $service_data = [
                                                                        'take_time' => $time_required,
                                                                        'start_time' => $order_datetime1,
                                                                        'end_time' => $order_datetime2
                                                                    ];
                                                                    $p_service = array_merge($p_service,$service_data);

                                                                    $package_data = $worker_assigned_packages[$worker->id];
                                                                    $package_data['package_service'][] = $p_service;

                                                                    $package_data['take_time'] = $time_required;
                                                                    $package_data['end_time'] = $order_datetime2;
                                                                    $worker_assigned_packages[$worker->id] = $package_data;

                                                                    $assigned_package = $package_data;
                                                                    unset($f_package['package_service'][$p_service['id']]);

                                                                    $order_datetime = $order_datetime_new;
                                                                }
                                                            }else{
                                                                $package_data = $f_package;
                                                                unset($package_data['package_service']);

                                                                $order_dates = [];
                                                                $period = CarbonPeriod::create($order_datetime1, $order_datetime2);
                                                                // Iterate over the period
                                                                foreach ($period as $date) {
                                                                    $order_dates[] = $date->format('Y-m-d');
                                                                }

                                                                $isOffday = false;
                                                                $isClosed = true;
                                                                $diff = array_intersect($off_days,$order_dates);
                                                                if(!empty($diff)){
                                                                    $isOffday = true;
                                                                }

                                                                $starttime = Carbon::parse($order_datetime1);
                                                                $start_dayname = strtolower($starttime->format('D'));
                                                                $start_date = strtolower($starttime->format('Y-m-d'));
                                                                $endtime = Carbon::parse($order_datetime2);
                                                                $end_dayname = strtolower($endtime->format('D'));

                                                                if(isset($franchise_timings[$start_dayname]) && isset($franchise_timings[$end_dayname])){
                                                                    
                                                                    $start_daytime = Carbon::parse($start_date.' '.$franchise_timings[$start_dayname]['open_time']);
                                                                    $end_daytime = Carbon::parse($start_date.' '.$franchise_timings[$end_dayname]['close_time']);
                                                                    if($start_daytime <= $starttime && $end_daytime >= $endtime){
                                                                        $isClosed = false;
                                                                    }

                                                                }

                                                                if($isOffday == false && $isClosed == false){
                                                                    $service_data = [
                                                                        'take_time' => $time_required,
                                                                        'start_time' => $order_datetime1,
                                                                        'end_time' => $order_datetime2
                                                                    ];
                                                                    $p_service = array_merge($p_service,$service_data);
                                                                    $package_data['package_service'][] = $p_service;
                                                                    $package_data['take_time'] = $time_required;
                                                                    $package_data['start_time'] = $order_datetime1;
                                                                    $package_data['end_time'] = $order_datetime2;
                                                                    $worker_assigned_packages[$worker->id] = $package_data;

                                                                    $assigned_package = $package_data;
                                                                    unset($f_package['package_service'][$p_service['id']]);

                                                                    $order_datetime = $order_datetime_new;
                                                                }

                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }

                                        $is_assigned = false;
                                        if(!empty($assigned_package)){

                                            $assigned_package['assiged_to_workers'] = $worker_assigned_packages;
                                            if($f_package_data['franchises_id'] == $franchise->id){
                                                if(empty($f_package['package_service'])){

                                                    $data[$franchise->id]['packages'][] = $assigned_package;
                                                    $assign_arr = [
                                                        'franchises_id' => $franchise->id,
                                                        'f_plan_id' => $franchise->f_plan_id,
                                                        'data' => $data[$franchise->id],
                                                        'take_time' => $assigned_package['take_time'],
                                                        // 'start_time' => $assigned_package['start_time'],
                                                        'end_time' => $assigned_package['end_time']
                                                    ];
                                                    $order_assign[$franchise->id] = $assign_arr;

                                                    if(!isset($order_assign[$franchise->id]['start_time'])){
                                                        $order_assign[$franchise->id]['start_time'] = $assigned_package['start_time'];
                                                    }
                                                    unset($f_package['packages'][$k]);
                                                    unset($franchise_data['packages'][$k]);
                                                    unset($franchise_data['packages'][$k]);
                                                    $is_assigned = true;
                                                }
                                                $f_package_data = $franchise_data['packages'][$k] = $f_package;
                                            }else{
                                                $data[$franchise->id]['packages'][] = $assigned_package;
                                                $assign_arr = [
                                                    'franchises_id' => $franchise->id,
                                                    'f_plan_id' => $franchise->f_plan_id,
                                                    'data' => $data[$franchise->id],
                                                    'take_time' => $assigned_package['take_time'],
                                                    // 'start_time' => $assigned_package['start_time'],
                                                    'end_time' => $assigned_package['end_time']
                                                ];
                                                $order_assign[$franchise->id] = $assign_arr;
                                                if(!isset($order_assign[$franchise->id]['start_time'])){
                                                    $order_assign[$franchise->id]['start_time'] = $assigned_package['start_time'];
                                                }

                                                if(empty($f_package['package_service'])){
                                                    unset($f_package['packages'][$k]);
                                                    $f_package_data = $franchise_data['packages'][$k] = [];
                                                    unset($franchise_data['packages'][$k]);
                                                }else{
                                                    $franchise_data['packages'][$k] = $f_package;
                                                    $f_package_data = $franchise_data['packages'][$k] = $f_package;
                                                }
                                                $is_assigned = true;
                                            }
                                        }
                                        if($is_assigned == false){
                                            $order_datetime = $starting_date;
                                        }
                                        
                                    }
                                }
                            }
                        }
                    }
                }
            }

            // services assign calculation
            if(!empty($franchise_data['services']))
            {
                foreach($franchise_data['services'] as $s => $f_service_data){

                    $isAssiged = false;
                    foreach($franchises as $franchise){
                        $worker_assigned_services = [];
                        if($franchise->franchise_workers->count()){

                            $collection = collect($franchise->franchise_timings);
                            $franchise_timings = $collection->mapWithKeys(function ($item) {
                                return [$item['day'] => $item];
                            })->toArray();

                            $off_days = $franchise->franchise_offday->pluck('off_date')->toArray();
                            foreach($franchise->franchise_workers as $worker){
                                if(!empty($franchise_data['services'][$s])){
                                if(in_array($f_service_data['id'], $franchise->f_services) && in_array($f_service_data['id'], $worker->w_services)){
                                    $time_required = 0; // in minute
                                    $travel_time_required = 0;

                                    if(!empty($f_service_data['hour'])){
                                        $time_required += $f_service_data['hour'] * 60;
                                    }
                                    if(!empty($f_service_data['minute'])){
                                        $time_required += $f_service_data['minute'];
                                    }
                                    $time_required = $time_required * $f_service_data['quantity'];
                                    if(!empty($franchise->hour)){
                                        $travel_time_required += $franchise->hour * 60;
                                    }
                                    if(!empty($franchise->minute)){
                                        $travel_time_required += $franchise->minute;
                                    }

                                    $order_datetime_new = Carbon::parse($order_datetime);
                                    $order_datetime1 = $order_datetime_new->format('Y-m-d H:i:s');
                                    $check_order_datetime1 = $order_datetime_new->subMinute($travel_time_required)->format('Y-m-d H:i:s');

                                    $order_datetime2 = $order_datetime_new->addMinute($time_required)->format('Y-m-d H:i:s');
                                    $check_order_datetime2 = $order_datetime_new->addMinute($time_required+$travel_time_required)->format('Y-m-d H:i:s');

                                    $order_datetime_new = $order_datetime2;

                                    $worker_orders = Worker_assigned_services::where(['worker_id' => $worker->id])
                                        ->where(function($query) use($check_order_datetime1, $check_order_datetime2){
                                            $query->whereBetween('start_time', [$check_order_datetime1, $check_order_datetime2])
                                            ->OrwhereBetween('end_time', [$check_order_datetime1, $check_order_datetime2]);
                                        })
                                        ->select(['id'])
                                        ->get();


                                    if($worker_orders->count() == 0){

                                        if(isset($order_assign[$franchise->id])){

                                            $time_required += $order_assign[$franchise->id]['take_time'];
                                            $start_time = Carbon::parse($order_assign[$franchise->id]['end_time']);
                                            $end_time = $start_time->addMinute($time_required)->format('Y-m-d H:i:s');

                                            $order_dates = [];
                                            $period = CarbonPeriod::create($check_order_datetime1, $check_order_datetime2);
                                            // Iterate over the period
                                            foreach ($period as $date) {
                                                $order_dates[] = $date->format('Y-m-d');
                                            }

                                            $isOffday = false;
                                            $isClosed = true;
                                            $diff = array_intersect($off_days,$order_dates);
                                            if(!empty($diff)){
                                                $isOffday = true;
                                            }

                                            $starttime = Carbon::parse($order_datetime1);
                                            $start_dayname = strtolower($starttime->format('D'));
                                            $start_date = strtolower($starttime->format('Y-m-d'));
                                            $endtime = Carbon::parse($order_datetime2);
                                            $end_dayname = strtolower($endtime->format('D'));
                                            $end_date = strtolower($endtime->format('Y-m-d'));

                                            if(isset($franchise_timings[$start_dayname]) && isset($franchise_timings[$end_dayname])){

                                                $start_daytime = Carbon::parse($start_date.' '.$franchise_timings[$start_dayname]['open_time']);
                                                $end_daytime = Carbon::parse($start_date.' '.$franchise_timings[$end_dayname]['close_time']);
                                                if($start_daytime <= $starttime && $end_daytime >= $endtime){
                                                    $isClosed = false;
                                                }
                                            }


                                            if($isClosed == false && $isClosed == false){
                                            // $data = $order_assign[$franchise->id]['data'];
                                                $service_data = [
                                                    'take_time' => $time_required,
                                                    'start_time' => $order_datetime1,
                                                    'end_time' => $order_datetime2
                                                ];
                                                $f_service_data = array_merge($f_service_data,$service_data);

                                                $worker_assigned_services[$worker->id] = $f_service_data;


                                                $assiged_to_workers = $f_service_data;
                                                $assiged_to_workers['assiged_to_workers'] =  $worker_assigned_services;

                                                $data[$franchise->id]['services'][] = $assiged_to_workers;

                                                $order_assign[$franchise->id]['take_time'] = $time_required;
                                                $order_assign[$franchise->id]['end_time'] = $order_datetime2;
                                                $order_assign[$franchise->id]['data'] = $data[$franchise->id];

                                                if(!isset($order_assign[$franchise->id]['start_time'])){
                                                    $order_assign[$franchise->id]['start_time'] = $order_datetime1;
                                                }
                                                unset($franchise_data['services'][$s]);
                                                $isAssiged = true;
                                                break;
                                            }
                                        }else{


                                            $order_dates = [];
                                            $period = CarbonPeriod::create($order_datetime1, $order_datetime2);
                                            // Iterate over the period
                                            foreach ($period as $date) {
                                                $order_dates[] = $date->format('Y-m-d');
                                            }

                                            $isOffday = false;
                                            $isClosed = true;
                                            $diff = array_intersect($off_days,$order_dates);
                                            if(!empty($diff)){
                                                $isOffday = true;
                                            }


                                            $starttime = Carbon::parse($order_datetime1);
                                            $start_dayname = strtolower($starttime->format('D'));
                                            $start_date = strtolower($starttime->format('Y-m-d'));
                                            $endtime = Carbon::parse($order_datetime2);
                                            $end_dayname = strtolower($endtime->format('D'));
                                            $end_date = strtolower($endtime->format('Y-m-d'));


                                            if(isset($franchise_timings[$start_dayname]) && isset($franchise_timings[$end_dayname])){

                                                $start_daytime = Carbon::parse($start_date.' '.$franchise_timings[$start_dayname]['open_time']);
                                                $end_daytime = Carbon::parse($end_date.' '.$franchise_timings[$end_dayname]['close_time']);
                                                if($start_daytime <= $starttime && $end_daytime >= $endtime){
                                                    $isClosed = false;
                                                }
                                            }


                                            if($isOffday == false && $isClosed == false){

                                                $service_data = [
                                                    'take_time' => $time_required,
                                                    'start_time' => $order_datetime1,
                                                    'end_time' => $order_datetime2
                                                ];
                                                $f_service_data = array_merge($f_service_data,$service_data);

                                                $worker_assigned_services[$worker->id] = $f_service_data;
                                                $assiged_to_workers = $f_service_data;
                                                $assiged_to_workers['assiged_to_workers'] =  $worker_assigned_services;

                                                $data[$franchise->id]['services'][] = $assiged_to_workers;
                                                $order_assign[$franchise->id] = [
                                                    'franchises_id' => $franchise->id,
                                                    'f_plan_id' => $franchise->f_plan_id,
                                                    'data' => $data[$franchise->id],
                                                    'take_time' => $time_required,
                                                    // 'start_time' => $order_datetime1,
                                                    'end_time' => $order_datetime2
                                                ];
                                                if(!isset($order_assign[$franchise->id]['start_time'])){
                                                    $order_assign[$franchise->id]['start_time'] = $order_datetime1;
                                                }
                                                unset($franchise_data['services'][$s]);
                                                $isAssiged = true;
                                                break;
                                            }
                                        }
                                    }
                                }
                            }
                            }
                        }
                    }
                }
            }
            //die;
            // echo '<pre>';
            // print_R($order_assign);
            // die;

            $is_order_place = true;
            $is_fully_allocated = 1;
            $unallocated = '';
            if(!empty($franchise_data)){
                if(!empty($franchise_data['packages'])){
                    $is_fully_allocated = 0;
                }
                if(!empty($franchise_data['services'])){
                    $is_fully_allocated = 0;
                }
            }
            if($is_fully_allocated == 0)
            {
                $unallocated = $franchise_data;
            }

            if($is_order_place == true)
            {

                $cart_data['payment_type'] = $payment_type;
                $item_number = Str::random(4) . time();
                $order = new Orders;
                $order->user_id = Auth::user()->id;
                $order->cart = $cart_data;
                $order->method = $payment_type;
                $order['user_id'] = Auth::user()->id;
                $order['cart'] = $cart_data;
                $order['totalQty'] = $total_quantity;
                $order['pay_amount'] = $cart_data['final_total'];
                $order['original_price'] = $cart_data['origional_price'];
                $order['method'] = $payment_type;
                $order['customer_email'] = Auth::user()->email;
                $order['customer_name'] = $cart_data['customer_name'];
                $order['customer_phone'] = Auth::user()->phone;
                $order['order_number'] = $item_number;
                $order['customer_address'] = $cart_data['flat_building_no'].', '.$cart_data['address'];
                $order['coupon_code'] = $cart_data['offer_code'];
                $order['gift_id'] = !empty($cart_data['gift_id']) ? $cart_data['gift_id'] : null;
                $order['coupon_discount'] = $cart_data['discount'];
                $order['payment_status'] = $cart_data['final_total'] ? "Pending" : 'Paid';
                $order['customer_address_id'] = $cart_data['address_id'];
                $order['unallocated'] = $unallocated;
                $order['is_fully_allocated'] = $is_fully_allocated;

                $order->save();

                //--------------------------- For Notification Start------------------

                $user_ids = [];
                $users = Admin::all();

                foreach($users as $user){
                // echo '<pre>'; print_R($user->role);die;
                    if($user->id == 1){
                        $user_ids[] = $user->id;
                    }else{
                        $sections = explode(" , ",$user->role->section);
                        if (in_array('orders', $sections)){
                            $user_ids[] = $user->id;
                        }
                    }
                }

                if(!empty($user_ids))
                {
                    $order_id = $order->id;
                    $type = 'new order';
                    $message = 'New order arrived';

                    $data = [];
                    foreach($user_ids as $user_id){
                        $data[] = [
                            'user_id' => $user_id,
                            'order_id' => $order_id,
                            'type' => $type,
                            'created_at' => date('Y-m-d H:i:s'),
                            'message' => $message
                        ];
                    }
                    Notification::insert($data);
                }

                //--------------------------- For Notification End------------------


                $data = [
                    'name' => $cart_data['customer_name'],
                    'order_id' => $order->id,
                    'order_number' => $order->order_number
                ];
                Mail::send('front.email.place-order', $data, function($message) {
                    $message->to(Auth::user()->email)
                        ->subject('Order placed successfully');
                });


                $track = new Order_tracks;
                $track->title = 'Pending';
                $track->text = 'You have successfully placed your order.';
                $track->order_id = $order->id;
                $track->save();
                foreach($order_assign as $assign){

                    $assigned_data = $assign['data'];
                    $Franchises_order = new Franchises_order;
                    $Franchises_order->franchises_id = $assign['franchises_id'];
                    $Franchises_order->orders_id = $order->id;
                    $Franchises_order->take_time = $assign['take_time'];
                    $Franchises_order->order_details = $assigned_data;
                    $Franchises_order->start_time = $assign['start_time'];
                    $Franchises_order->end_time = $assign['end_time'];
                    $Franchises_order->save();

                    $Franchise_plan = Franchise_plans::where(['franchise_id' => $assign['franchises_id']])->first();
                    $Franchise_plan->remain_credits = $Franchise_plan->remain_credits - 1;
                    $Franchise_plan->save();

                    if(!empty($assigned_data['packages'])){
                        foreach($assigned_data['packages'] as $assigned_packages){
                            foreach($assigned_packages['assiged_to_workers'] as $worker_id => $assiged){

                                if(!empty($assiged['package_service'])){
                                    foreach($assiged['package_service'] as $package_service){
                                        $worker_assigned_services = new Worker_assigned_services;

                                        $worker_assigned_services->worker_id = $worker_id;
                                        $worker_assigned_services->order_id = $order->id;
                                        $worker_assigned_services->f_order_id = $Franchises_order->id;
                                        $worker_assigned_services->is_package = 1;
                                        $worker_assigned_services->package_id = $assiged['id'];
                                        $worker_assigned_services->service_id = $package_service['id'];
                                        $worker_assigned_services->take_time = $package_service['take_time'];
                                        $worker_assigned_services->start_time = $package_service['start_time'];
                                        $worker_assigned_services->end_time = $package_service['end_time'];
                                        $worker_assigned_services->save();

                                         //--------------------------- For Worker Notification Start------------------
                                            $worker_users = $worker_assigned_services->worker_id;

                                            $worker_user_id = Franchise_worker::where('id',$worker_users)->first();

                                            $notification = new Notification;
                                            $notification->order_id = $order->id;
                                            $notification->user_id = $worker_user_id->id;
                                            $notification->f_order_id = $worker_assigned_services->f_order_id;
                                            $notification->is_package = 1;
                                            $notification->package_id = $assiged['id'];
                                            $notification->service_id = $package_service['id'];
                                            $notification->is_worker = 1;
                                            $notification->created_at = date('Y-m-d H:i:s');
                                            $notification->type = 'new order';
                                            $notification->message = 'New order arrived';

                                            $notification->save();
                                        //--------------------------- For Worker Notification End------------------
                                        
                                        $Ordered_service = new Ordered_services;
                                        $Ordered_service->order_id = $order->id;
                                        $Ordered_service->service_id = $package_service['id'];
                                        $Ordered_service->is_package = 1;
                                        $Ordered_service->package_id = $assiged['id'];
                                        $Ordered_service->is_allocated = 1;
                                        $Ordered_service->save();
                                    }
                                }
                            }
                        }
                    }

                    if(!empty($assigned_data['services'])){
                        foreach($assigned_data['services'] as $assiged_services){
                            if(!empty($assiged_services['assiged_to_workers'])){
                                foreach($assiged_services['assiged_to_workers'] as $worker_id => $assiged){

                                    $worker_assigned_services = new Worker_assigned_services;
                                    $worker_assigned_services->worker_id = $worker_id;
                                    $worker_assigned_services->order_id = $order->id;
                                    $worker_assigned_services->f_order_id = $Franchises_order->id;
                                    $worker_assigned_services->service_id = $assiged['id'];
                                    $worker_assigned_services->take_time = $assiged['take_time'];
                                    $worker_assigned_services->start_time = $assiged['start_time'];
                                    $worker_assigned_services->end_time = $assiged['end_time'];
                                    $worker_assigned_services->save();

                                    //--------------------------- For Worker Notification Start------------------
                                    $worker_users = $worker_assigned_services->worker_id;

                                    $worker_user_id = Franchise_worker::where('id',$worker_users)->first();

                                    $notification = new Notification;
                                    $notification->order_id = $order->id;
                                    $notification->user_id = $worker_user_id->id;
                                    $notification->f_order_id = $worker_assigned_services->f_order_id;
                                    $notification->service_id = $assiged['id'];
                                    $notification->is_worker = 1;
                                    $notification->created_at = date('Y-m-d H:i:s');
                                    $notification->type = 'new order';
                                    $notification->message = 'New order arrived';

                                    $notification->save();
                                    //--------------------------- For Worker Notification End------------------

                                    $Ordered_service = new Ordered_services;
                                    $Ordered_service->order_id = $order->id;
                                    $Ordered_service->service_id = $assiged['id'];
                                    $Ordered_service->is_allocated = 1;
                                    $Ordered_service->save();
                                }
                            }

                        }
                    }

                    //--------------------------- For Franchise Notification Start------------------

                    $users = $Franchises_order->franchises_id;

                    $franchise_info = Franchise::where('id',$users)->select('user_id')->get();

                    $franchise_users_ids = Admin::whereIn('id',$franchise_info)->select('id')->first();

                    $notification = new Notification;
                    $notification->order_id = $order->id;
                    $notification->user_id = $franchise_users_ids->id;
                    $notification->f_order_id = $Franchises_order->id;
                    $notification->is_package = isset($worker_assigned_services->is_package) ? $worker_assigned_services->is_package : 0;
                    $notification->package_id = isset($worker_assigned_services->package_id) ? $worker_assigned_services->package_id : 0;
                    $notification->service_id = isset($worker_assigned_services->service_id) ? $worker_assigned_services->service_id : 0;
                    $notification->is_franchise = 1;
                    $notification->created_at = date('Y-m-d H:i:s');
                    $notification->type = 'new order';
                    $notification->message = 'New order arrived';
                    $notification->save();
                    //--------------------------- For Franchise Notification End------------------
                }

                if(isset($unallocated['packages']) && !empty($unallocated['packages'])){
                    foreach($unallocated['packages'] as $package){
                        if(!empty($package['package_service'])){
                            foreach($package['package_service'] as $service){
                                $Ordered_service = new Ordered_services;
                                $Ordered_service->order_id = $order->id;
                                $Ordered_service->service_id = $service['id'];
                                $Ordered_service->is_package = 1;
                                $Ordered_service->package_id = $package['id'];
                                $Ordered_service->save();
                            }
                        }

                    }
                }
                if(isset($unallocated['services']) && !empty($unallocated['services'])){
                    foreach($unallocated['services'] as $service){
                        $Ordered_service = new Ordered_services;
                        $Ordered_service->order_id = $order->id;
                        $Ordered_service->service_id = $service['id'];
                        $Ordered_service->save();
                    }
                }
                Session::put('my_cart',[]);
                Session::forget('my_cart');
                $My_cart = My_cart::where('user_id', Auth::user()->id)->first();
                $My_cart->delete();
                return redirect()->route('user.order_details', $order->id)->with('success', 'Your order received successfully.');
                //return response()->json(['success' => 1, 'message' => 'success', 'order_id' => $order->id]);

            }else{
                return redirect()->route('user.payment_method')->with('error', 'Currently your order can not process at provided time, please change and try again.');
            }
        }
        return redirect()->route('user.payment_method')->with('error', 'Currently your order can not process.');
    }
    public function order_details($order_id = null)
    {
        if (!$order_id) {
            return redirect('/')->with('Insert_Message', 'Invalid order');
        }
        $my_order = Orders::with(['franchise_orders' => function($query){
            $query->with('franchise');
        }])
        ->where('id', $order_id)->first();

        $worker_orders = [];
        foreach($my_order->franchise_orders as $order){
            if(!empty($order->worker_orders)){
                foreach($order->worker_orders as $w_order){
                  //  print_r($w_order->worker);
                    if($w_order->is_package){
                        $worker_orders[$w_order->f_order_id]['packages'][$w_order->package_id][$w_order->service_id] = $w_order;
                    }else{
                        $worker_orders[$w_order->f_order_id]['services'][$w_order->service_id] = $w_order;
                    }
                }
            }

        }

        // echo '<pre>';
        // print_r($worker_orders);die;
        // $category_id = $my_order->cart['category_id'];
        // $catogory = Category::where('id', $category_id)->first();
        return view('users.order_detail', compact('my_order','worker_orders'));
    }

    public function send_review(Request $request) 
    {
        if ($request->type == 'package') 
        {
            $package = new Packages_ratings;
            $user_id = Auth::user()->id;
            
            $package->user_id = $user_id;
            $package->package_id = $request->id;
            if ($request->rate == '') {
                $package->package_rating = 0;
            } else {
                $package->package_rating = $request->rate;
            }
            $package->description = $request->w3review;

            $images = array();
            if($files=$request->file('review_img'))
            {
                foreach($files as $file)
                {
                    $image = $file;
                    $imagename = rand().time().'.'.$image->extension();
                    $image->move(public_path('assets/images/review'),$imagename);
                    array_push($images, $imagename);
                }
            }
            $package->images = json_encode($images);
            $package->save();
        } 
        if ($request->type == 'service') 
        {
            $package = new Services_ratings;
            $user_id = Auth::user()->id;
            $package->user_id = $user_id;
            $package->service_id = $request->id;
            if ($request->rate == '') 
            {
                $package->service_rating = 0;
            } else {
                $package->service_rating = $request->rate;
            }
            $package->description = $request->w3review;
            $images = array();
            if($files=$request->file('review_img'))
            {
                foreach($files as $file)
                {
                    $image = $file;
                    $imagename = rand().time().'.'.$image->extension();
                    $image->move(public_path('assets/images/review'),$imagename);
                    array_push($images, $imagename);
                }
            }
            $package->images = json_encode($images);
            $package->save();
        }
        else
        {

            $user_id = Auth::user()->id;
            $Order_review = new Order_review;
            $Order_review->user_id = $user_id;
            $Order_review->order_id = $request->id;
            if ($request->rate == '') {
                $Order_review->order_rating = 0;
            } else {
                $Order_review->order_rating = $request->rate;
            }
            $Order_review->description = $request->description;
            $images = array();
            if($files=$request->file('review_img'))
            {
                foreach($files as $file)
                {
                    $image = $file;
                    $imagename = rand().time().'.'.$image->extension();
                    $image->move(public_path('assets/images/review'),$imagename);
                    array_push($images, $imagename);
                }
            }
            $Order_review->images = json_encode($images);
            $Order_review->save();
        }
        return redirect()->back()->with('Review Uploaded Successfully');
    }

    public function set_location_session(Request $request) {

        if (isset($request->clear) && $request->clear == 'clear') {
            Session::forget('location_search');
            return redirect('/');
        }

        $location_search = [
            'location_search' => $request->location_search
        ];

        $rules = [
            'location_search' => 'required'
        ];

        $customMessages = [
            'location_search.required' => 'Please enter valid location'
        ];

        // print_R($request->all());die;
        $validator = Validator::make($location_search, $rules, $customMessages);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator->errors());
        }

        $client = new \GuzzleHttp\Client();
        $geocoder = new Geocoder($client);
        $geocoder->setApiKey(config('geocoder.key'));
        $get_address = $geocoder->getCoordinatesForAddress($request->location_search);

        if($get_address['formatted_address'] == 'result_not_found'){
            $request->lat = null;
            $request->long = null;
        }else{
            $request->location_search = $get_address['formatted_address'];
            $request->lat = $get_address['lat'];
            $request->lng = $get_address['lng'];
            if(!empty($get_address['address_components'])){
                foreach($get_address['address_components'] as $key=>$value) {
                    foreach($value->types as $types) {
                        if($types == 'locality') {
                            $request->city = $value->long_name;
                        }elseif($types == 'administrative_area_level_1') {
                            $request->state = $value->long_name;
                        }elseif($types == 'country') {
                            $request->country = $value->long_name;
                        }elseif($types == 'postal_code') {
                            $request->zip = $value->long_name;
                        }
                    }
                }
            }

        }

        $location_search = [
            'location_search' => $request->location_search,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'country' => $request->country,
            'city' => $request->city,
            'state' => $request->state,
            'zip' => $request->zip
        ];

        $rules = [
            'lat' => 'required'
        ];

        $customMessages = [
            'lat.required' => 'Please enter valid location'
        ];

        $validator = Validator::make($location_search, $rules, $customMessages);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator->errors());
        }

        Session::put('location_search', $location_search);
        Session::put('is_scroll_to_category', true);
        return redirect(url()->previous());
    }

    public function cancel_order(Request $request, $order_id){
        $user_id = Auth::user()->id;
        $Order = Orders::where(['user_id' => $user_id, 'id' => $order_id])->first();
        if($Order){
            $Order->status = 'cancelled';
            $Order->save();

            $track = new Order_tracks;
            $track->title = 'Cancelled by you';
            $track->text = 'You have cancelled your order.';
            $track->order_id = $Order->id;
            $track->save();
            return response()->json(['success' => 1, 'message' => 'Order has been cancelled successfully.']);
        }
        return response()->json(['success' => 0, 'message' => 'Invalid access']);

    }

    public function remove_item_from_cart(Request $request){

        $id = $request->id;

        $cart_data = Session::get('my_cart');
        if ($cart_data) {
            if($request->type == 'service'){
                if(isset($cart_data['services'][$id])){
                    unset($cart_data['services'][$id]);
                }
                if(empty($cart_data['services'])){
                    unset($cart_data['services']);
                }
            }else{
                if(isset($cart_data['packages'][$id])){
                    unset($cart_data['packages'][$id]);
                }
                if(empty($cart_data['packages'])){
                    unset($cart_data['packages']);
                }
            }

            if(empty($cart_data)){
                Session::put('my_cart',[]);
                Session::forget('my_cart');
                if (Auth::check()) {
                    $id = Auth::user()->id;
                    $My_cart = My_cart::where('user_id', Auth::user()->id)->first();
                    $My_cart->delete();
                }
            }else{
                Session::put('my_cart', $cart_data);
                if (Auth::check()) {
                    $id = Auth::user()->id;
                    $My_cart = My_cart::where('user_id', Auth::user()->id)->first();
                    $My_cart->cart_data = $cart_data;
                    $My_cart->save();
                }

            }

            return response()->json(['success' => 1, 'message' => 'Item removed successfully.']);
        }
        return response()->json(['success' => 0, 'message' => 'Something went wrong']);
    }

    public function orders()
    {
        $user = Auth::guard('web')->user();
        $orders = Orders::where('user_id','=',$user->id)->orderBy('id','desc')->get();
        return view('users.orders', compact('orders'));
    }

    public function ongoingorders()
    {
        $user = Auth::guard('web')->user();
        $orders = Orders::where('user_id','=',$user->id)->whereIn('status', ['pending','processing','on delivery'])->orderBy('id','desc')->get();
        return view('users.ongoingorders', compact('orders'));
    }

    public function user_profile()
    {
        $user = Auth::guard('web')->user();

        $countries = Country::all();
        return view('users.user_profile', compact('countries', 'user'));
    }

    public function contact_us()
    {
        return view('front.contact_us');
    }

    public function contact_us_save(Request $request){

        $validator = Validator::make($request->all(), [
            'contact_name' => ['required'],
            'contact_email' => ['required', 'string', 'email', 'max:255'],
            'contact_phone' => ['required', 'numeric', 'digits:10'],
            'contact_message' => ['required'],
        ], [
            'contact_name.required' => 'Please enter your name',
            'contact_email.required' => 'Please enter your email',
            'contact_phone.required' => 'Please enter your mobile number',
            'contact_message.required' => 'Please enter your message.',
        ]);
        if($validator->fails()) {
            return response()->json(['success' => 0, 'errors' => $validator->errors()]);
        }

        $contact_us = new contact_us;
        $contact_us->name = $request->contact_name;
        $contact_us->email = $request->contact_email;
        $contact_us->phone = $request->contact_phone;
        $contact_us->comment = $request->contact_message;

        $contact_us->save();
        return response()->json(['success' => 1, 'message' => 'Message submitted successfully']);
    }

    public function subscribe_form(Request $request){

        $rules = [
            'email' => ['required','email'],
        ];
        $messages = [
            'email.required' => 'Please enter your email',
            'email.email' => 'Please enter valid email',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()) {
            return response()->json(['success' => 0, 'errors' => $validator->errors()]);
        }

        $News_letter = News_letter::where(['email' => $request->email])->first();
        if(empty($News_letter)){
            $News_letter = new News_letter;
        }
        $News_letter->email = $request->email;
        $News_letter->save();
        return response()->json(array('success' => 1, 'message' => 'News letter subscribed successfully.'));


    }

    public function refer_and_earn(Request $request){
        if(empty(Auth::user())){
            return response()->json(['success' => 0, 'message' => 'Please login first to refer.']);
        }

        $user_id = Auth::user()->id;
        $rules = [
            'referral_number' => ['required', 'numeric', 'digits:10', 'unique:user_referrals,phone,NULL,id,user_id,' . $user_id],

        ];
        $messages = [
            'referral_number.required' => 'Please enter mobile number',
            'referral_number.numeric' => 'Mobile number must be a number.',
            'referral_number.digits' => 'Mobile number must be 10 digits.',
            'referral_number.unique' => 'You are already referred this number.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()) {
            return response()->json(['success' => 0, 'errors' => $validator->errors()]);
        }

        $get_user_referral_code = Auth::user()->get_user_referral_code();

      //  print_R($get_user_referral_code);die;
        $User_referrals = new User_referrals;
        $User_referrals->user_id = $user_id;
        $User_referrals->phone = $request->referral_number;
        $User_referrals->save();

        // Send SMS here

        $user = User::findOrFail($user_id);
        $user->referral_id = $get_user_referral_code;
        $user->save();

        return response()->json(['success' => 1, 'message' => "Referral sent successfully."]);

    }


    public function request_a_quote(Request $request){

        if(empty(Auth::user())){
           // return response()->json(['success' => 0, 'message' => 'Please login first request a quote.']);
        }
        $validator = Validator::make($request->all(), [
            'request_name' => ['required'],
            'request_email' => ['required', 'string', 'email', 'max:255'],
            'request_phone' => ['required', 'numeric', 'digits:10'],
            'request_message' => ['required'],
            // 'request_service' => ['required'],
            'request_visit_date' => ['required'],
            'request_visit_time' => ['required'],
        ], [
            'request_name.required' => 'Please enter your name',
            'request_email.required' => 'Please enter your email',
            'request_phone.required' => 'Please enter your mobile number',
            'request_message.required' => 'Please enter your message.',
            // 'request_service.required' => 'Please select service.',
            'request_visit_date.required' => 'Please select date.',
            'request_visit_time.required' => 'Please select time.',
        ]);
        if($validator->fails()) {
            return response()->json(['success' => 0, 'errors' => $validator->errors()]);
        }

        $Request_quotes = new Request_quotes;
        $Request_quotes->name = $request->request_name;
        $Request_quotes->email = $request->request_email;
        $Request_quotes->phone = $request->request_phone;
        $Request_quotes->address = $request->request_address;
        $Request_quotes->message = $request->request_message;
        $Request_quotes->service_id = 0;
        $Request_quotes->visit_date = Carbon::createFromFormat('d/m/Y', $request->request_visit_date)->format('Y-m-d');
        $Request_quotes->visit_time = Carbon::createFromFormat('d/m/Y H:i A', $request->request_visit_date . ' ' . $request->request_visit_time)->format('H:i:a');

        $Request_quotes->save();
        return response()->json(['success' => 1, 'message' => 'Request submitted successfully.']);
    }

    public function service_request(Request $request){
        
        if(empty(Auth::user())){
           // return response()->json(['success' => 0, 'message' => 'Please login first request a quote.']);
        }
        $validator = Validator::make($request->all(), [
            'request_name' => ['required'],
            'request_email' => ['required', 'string', 'email', 'max:255'],
            'request_phone' => ['required', 'numeric', 'digits:10'],
            'request_message' => ['required'],
            'request_service' => ['required'],
            'request_address' => ['required'],
            // 'request_visit_date' => ['required'],
            // 'request_visit_time' => ['required'],
        ], [
            'request_name.required' => 'Please enter your name',
            'request_email.required' => 'Please enter your email',
            'request_phone.required' => 'Please enter your mobile number',
            'request_message.required' => 'Please enter your message.',
            'request_service.required' => 'Please select service.',
            'request_address.required' => 'Please enter address.',
            // 'request_visit_date.required' => 'Please select date.',
            // 'request_visit_time.required' => 'Please select time.',
        ]);
        if($validator->fails()) {
            return response()->json(['success' => 0, 'errors' => $validator->errors()]);
        }

        $Request_quotes = new Request_quotes;
        $Request_quotes->name = $request->request_name;
        $Request_quotes->email = $request->request_email;
        $Request_quotes->phone = $request->request_phone;
        $Request_quotes->address = $request->request_address;
        $Request_quotes->message = $request->request_message;
        $Request_quotes->service_id = $request->request_service;
        $Request_quotes->request_type = 'Service Request';

        $Request_quotes->save();
        return response()->json(['success' => 1, 'message' => 'Request submitted successfully.']);
    }



    public function blog()
    {
        $blogs = Blog::where(['status' => 1])->orderBy('id','desc')->paginate(9);


        return view('front.blog', compact('blogs'));
    }

    public function blog_view($id)
    {
        $blog = Blog::find($id);
        $categories = Category::where('categories.status','=',1)
            ->leftjoin("blogs AS b", function ($join) {
                $join->on('categories.id', '=', 'b.category_id')->where(['b.status' => 1, 'b.deleted_at' => NULL]);
            })
            ->select('categories.*',DB::raw('count(b.category_id) as blog_count'))
            ->groupBy('categories.id')
        ->get();

        $tagz = '';
        $blogs_tag = Blog::pluck('tags')->toArray();
        foreach($blogs_tag as $tag)
        {
            $tagz .= $tag.',';
        }
        $tags = array_unique(explode(',',$tagz));

        return view('front.blogview',compact('blog','categories','tags'));
    }
    public function blog_tag($id)
    {
        $blogs = Blog::where('tags', 'like', '%' . $id . '%')->paginate(9);

        return view('front.blog',compact('blogs','id'));
    }
    public function blog_category($id)
    {
        $blogs = Blog::where('category_id', '=',$id)->paginate(9);

        return view('front.blog',compact('blogs','id'));
    }

    public function order_track()
    {
        return view('users.order-track');
    }

    public function get_order_track(Request $request){
        $validator = Validator::make($request->all(), [
            'track_code' => ['required']
        ], [
            'track_code.required' => 'Please enter order number'
        ]);
        if($validator->fails()) {
            return response()->json(['success' => 0, 'errors' => $validator->errors()]);
        }

        $order_number = $request->track_code;
        $order =  Orders::where('order_number', $order_number)->first();
        if(empty($order)){
            return response()->json(['success' => 0, 'errors' => ['order_number' => ['Please enter valid order number.']]]);
        }

        $Order_tracks = Order_tracks::where(['order_id' => $order->id])->get()->map(function($query){
            $query->created_time = $query->created_at->format('d M Y h:i A');
            return $query;
        });

        $datas = array('Pending','Processing','On Delivery','Completed');
        return response()->json(['success' => 1, 'order_tracks' => $Order_tracks, 'datas' => $datas]);
    }

    public function terms_and_conditions() {
        return view('front.terms-and-conditions');
    }

    public function return_refund_policy() {
        return view('front.return-refund-policy');
    }

    public function privacy_policy() {
        return view('front.privacy-policy');
    }

    public function eula() {
        return view('front.eula');
    }

    public function disclaimer() {
        return view('front.disclaimer');
    }

    public function cookie_policy() {
        return view('front.cookie-policy');
    }

}
