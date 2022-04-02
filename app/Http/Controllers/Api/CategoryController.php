<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Service;
use App\Service_cities;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Geocoder\Geocoder;

use App\Classes\GeniusMailer;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Counter;
use App\Models\Generalsetting;
use App\Models\Order;
use App\Models\Product;
use App\Models\Subscriber;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use InvalidArgumentException;
use Markury\MarkuryPost;


use App\Category;
use App\SubCategory;
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
use App\Best_service;
use App\contact_us;
use App\Referral_programs;
use App\Best_offers;
use App\Slider;
use App\Request_quotes;
use App\Traits\ApiResponser;
use App\Testimonial;

class CategoryController extends Controller
{
    use ApiResponser;
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

    public function latlong(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'latitude' => 'required',
            'longitude' => 'required',
            'ipaddress' => 'required',
        ]);
        if ($validator->fails())
        {
            // return response([
            //     'success' => 0,
            //     'errors'=>$validator->errors()->first()
            // ], 422);
            return $this->error($validator->errors()->first(), 401);
        }
        $lat = session()->put('latitude', $request->latitude);
        $long = session()->put('longitude', $request->longitude);
        $ip = session()->put('ipaddress', $request->ipaddress);
        if(session()->has('latitude') && session()->has('latitude') && session()->has('ipaddress')) {
            return $this->success([
                'Success' => 'Your location area Found successfully'
            ]);
        } else {
            return $this->error('Your Location Can not get', 401);
        }
    }

    public function categories(Request $request) {


        $validator = Validator::make($request->all(), [
            'latitude' => 'required',
            'longitude' => 'required',
            'ipaddress' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }

        $lat = $request->latitude;
        $lng = $request->longitude;
        $ip = $request->ipaddress;

        $cat = Category::where(['categories.status' => 1]);

        if($lat != 0.0 && $lng != 0.0){
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
            ->select('categories.id','categories.title','categories.slug','categories.logo',  DB::raw('count(s.category_id) as service_count'),  DB::raw('count(ss.category_id) as package_count'))
            ->havingRaw('service_count > 0 OR package_count > 0');

            $cat = $cat->groupBy('categories.id')->get()->map(function($query){
                if(!empty($query->logo)){
                    $query->logo = asset('assets/images/categorylogo/'.$query->logo);
                }

                $query->is_custom_category = false;
                return $query;
            });

            $cat = $cat->toArray();

            $cat[] = [
                'id' => 0,
                'title'=> 'Other',
                'slug'=> 'other',
                'logo'=> asset('assets/images/categorylogo/other-category.png'),
                'service_count'=> 0,
                'package_count'=> 0,
                'is_custom_category'=> true
            ];

        }else{
            $cat = $cat->select('id','title','slug','logo')->groupBy('categories.id')->get()->map(function($query){
                if(!empty($query->logo)){
                    $query->logo = asset('assets/images/categorylogo/'.$query->logo);
                }

                $query->is_custom_category = false;
                return $query;
            });

            $cat = $cat->toArray();

            $cat[] = [
                'id' => 0,
                'title'=> 'Other',
                'slug'=> 'other',
                'logo'=> asset('assets/images/categorylogo/other-category.png'),
                'service_count'=> 0,
                'package_count'=> 0,
                'is_custom_category'=> true
            ];
        }

        $Best_services = Best_service::with(['service' => function($query){
            $query->join('sub_categories As sc', function ($join) {
                $join->on('services.sub_category_id', '=', 'sc.id');
            })
            ->select(['services.id','services.category_id','services.sub_category_id','services.title','sc.slug as sub_category_slug','services.banner','services.image']);
        }])
        ->where(['best_services.status' => 1])
        ->select(['best_services.id', 'best_services.service_id'])
        ->get()->map(function($query){
            if(!empty($query->service->banner)){
                $query->service->banner = asset('assets/images/servicebanner/'.$query->service->banner);
            }
            if(!empty($query->service->image)){
                $query->service->image = asset('assets/images/servicelogo/'.$query->service->image);
            }
            return $query;
        });

        $customer_reviews = Services_ratings::with(['user' => function($query){
            $query->select('name','id','photo');
        }])
        ->select(['id','service_id','user_id','service_rating','description'])
        ->where(['status' => 1])
        ->limit(10)
        ->orderBy('id', 'DESC')
        ->get()
        ->map(function($query){
            if(!empty($query->user->photo)){
                $query->user->profile_pic = asset('assets/images/users/'.$query->user->photo);
            }else{
                $query->user->profile_pic = asset('assets/images/profile.png');
            }
            return $query;
        });

        $Referral_programs = Referral_programs::where(['status' => 1])->select(['id','referral_value','max_value'])->first();

        $today = Carbon::now()->format('Y-m-d');
        $best_offers = Best_offers::with(['offer'])
            ->join('offers As f', function ($sub_join) {
                return $sub_join->on('best_offers.offer_id', '=', 'f.id');
            })
            ->join('sub_categories As sc', function ($join) {
                $join->on('f.sub_category_id', '=', 'sc.id');
            })
            ->select('best_offers.id','best_offers.offer_id','best_offers.status','best_offers.created_at','best_offers.updated_at','best_offers.deleted_at','f.title','f.description','f.offer_code','f.is_global','f.category_id','f.sub_category_id','f.service_id','f.franchises_id','f.offer_type','f.offer_value','f.max_value','f.is_user_specific','f.banner','f.start_date','f.end_date','sc.slug as sub_category_slug')
            ->where(['f.status' => 1,'best_offers.status' => 1, 'f.deleted_at' => null])
            ->where('f.start_date', '<=', $today)
            ->where('f.end_date', '>=', $today)
            ->get()->map(function($query){
            $query->banner = asset('assets/images/offerbanner/'.$query->banner);
            return $query;
        });;

       
        $cat_ids = [];
        foreach($cat as $c){
            $cat_ids[] = $c['id'];
        }
        $cat_ids = array_filter($cat_ids);
        $slider = Slider::where(['sliders.status'=>1])
        ->where('sliders.mobile_image', '!=', null)
        ->leftjoin("services AS s", function ($join) {
            $join->on('sliders.service_id', '=', 's.id')->where(['s.status' => 1, 's.deleted_at' => null]);
        })
        ->leftjoin("sub_categories AS sc", function ($join) {
            $join->on('s.sub_category_id', '=', 'sc.id')->where(['sc.status' => 1, 'sc.deleted_at' => null]);
        })
        ->select(['sliders.id','sliders.title','sliders.description','sliders.service_id','sliders.mobile_image', 'sc.slug as sub_category_slug'])->get()->map(function($query)use($cat_ids){
            $is_redirectable = false;
            if(!empty($query->service->id) && in_array($query->service->category_id,$cat_ids)){
                $is_redirectable = true;
            }
            $query->is_redirectable = $is_redirectable;
            if(!empty($query->mobile_image)){
                $query->image = asset('assets/images/sliderimage/'.$query->mobile_image);
            }
            return $query;
        });

        $other_service = Service::where(['status' => 1])->select('id','title')->get();


        $services_count = Service::where(['status' => 1,'deleted_at' => null])->count();
        $city_count = City::where(['status' => 1])->count();
        $franchise_count = Franchise::where(['status' => 1,'deleted_at' => null])->count();
        $user_count = User::where(['deleted_at' => null])->count();

        $counter = [
            [
                'image' => asset('assets/front-assets/images/statistics/icon-1.png'),
                'count' => $services_count,
                'name' => 'Services',
            ],
            [
                'image' => asset('assets/front-assets/images/statistics/icon-3.png'),
                'count' => 15,
                'name' => 'City',
            ],
            [
                'image' => asset('assets/front-assets/images/statistics/icon-2.png'),
                'count' => 22,
                'name' => 'Franchises',
            ],
            [
                'image' => asset('assets/front-assets/images/statistics/icon-4.png'),
                'count' => 150,
                'name' => 'Happy Customer',
            ],
        ];

        $testimonials = Testimonial::where(['status' => 1])->select('id','title','image')->get()->map(function($query){
            if(!empty($query->image)){
                $query->image = asset('assets/images/testimonial/'.$query->image);
            }
            return $query;
        });
        
        return $this->success([
            'testimonials' => $testimonials,
            "categories" => $cat,
            "Best_services" => $Best_services,
            "customer_reviews" => $customer_reviews,
            "Referral_programs" => $Referral_programs,
            "best_offers" => $best_offers,
            "slider" => $slider,
            "other_service" => $other_service,
            "counter" => $counter,
        ]);
    }

  // public function categories(Request $request) {
  //       $lat = $request->latitude;
  //       $long = $request->longitude;
  //       $ip = $request->ipaddress;

  //       $validator = Validator::make($request->all(), [
  //           'latitude' => 'required',
  //           'longitude' => 'required',
  //           'ipaddress' => 'required',
  //       ]);
  //       if ($validator->fails()) {
  //           return $this->error($validator->errors()->first(), 401);
  //       }
  //               $client = new \GuzzleHttp\Client();
  //               $geocoder = new Geocoder($client);
  //               $geocoder->setApiKey(config('geocoder.key'));
  //               $a = $geocoder->getAddressForCoordinates($lat, $long);
  //               $address = array();
  //               foreach($a['address_components'] as $key=>$value) {
  //                   foreach($value->types as $types) {
  //                   if($types == 'locality') {
  //                           $address['city'] = $value->long_name;
  //                   }
  //                   if($types == 'administrative_area_level_1') {
  //                           $address['state'] = $value->long_name;
  //                       }
  //                       if($types == 'country') {
  //                           $address['country'] =  $value->long_name;
  //                       }
  //                   }
  //               }
  //               if(!empty($address['city']) && !empty($address['state']) && !empty($address['country'])) {
  //                   $location = $this->get_location_city($address);
  //                   if(!empty($location)) {
  //                       $category_in_city = Category::select('id', 'title', 'slug', 'logo', 'description', 'city_id')->Where('city_id', $location)->Where('status',1)

  //                           ->get()->map(function($query){
  //                               if(!empty($query->logo)){
  //                                   $query->logo = asset('assets/images/categorylogo/'.$query->logo);
  //                               }
  //                               return $query;
  //                           });
  //                       if(!empty($category_in_city)) {
  //                           return $this->success([
  //                           "categories" => $category_in_city
  //                           ]);
  //                       } else {
  //                           return $this->error('Sorry, This Service is not active currently in your area', 401);
  //                       }
  //                   } else {
  //                       return $this->error('Sorry, This Service not available in your are', 401);
  //                   }
  //               } else {
  //                       return $this->error('Sorry, your location not found', 404);
  //               }
  //   }


    public function subcategories(Request $request) {

        $lat = $request->latitude;
        $lng = $request->longitude;
        
        $category_id = $request->category_id;
        $cat = Category::where('id', $category_id)->first();

        $sub_cat = array();
        $sub_cat = SubCategory::select('id', 'category_id', 'title', 'slug', 'note', 'logo', 'sub_note')->Where('category_id', $category_id)->Where('status', 1)->get()->map(function($query){
                            if(!empty($query->logo)){
                                $query->logo = asset('assets/images/subcategorylogo/'.$query->logo);
                            }
                            return $query;
                        });

        if($sub_cat->count() != 0) {
            return $this->success([
                "subcategory" => $sub_cat,
            ]);
        } else {
            return $this->error('Sorry, Sub Category not found in this category', 401);
        }
    }

    public function other_category(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'message' => 'required',
            'service_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }  
        
        $Request_quotes = new Request_quotes;
        $Request_quotes->name = $request->name;
        $Request_quotes->email = $request->email;
        $Request_quotes->phone = $request->phone;
        $Request_quotes->address = $request->address;
        $Request_quotes->message = $request->message;
        $Request_quotes->service_id = $request->service_id;
        $Request_quotes->request_type = 'Service Request';

        $Request_quotes->save();

        if($Request_quotes->count() != 0) {
            return $this->success([
                "service_request" => $Request_quotes,
            ]);
        }
    }
}
