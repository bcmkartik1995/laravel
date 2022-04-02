<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use App\Service;
use App\Service_cities;
use Illuminate\Http\Request;
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
use App\service_media;
use App\Traits\ApiResponser;
use App\Service_specifications;

class ServiceController extends Controller
{
    use ApiResponser;

    public function serviceList(Request $request) {

        $category_id = $request->category_id;
        $sub_cat_slug = $request->sub_category_id;
        //$city_id = $request->city_id;
        
        $lat = $request->latitude;
        $lng = $request->longitude;

        $category = Category::where(['id' => $category_id, 'status' => 1])->get()->map(function($query){
            if(!empty($query->logo)){
                $query->logo = asset('assets/images/categorylogo/'.$query->logo);
            }
            return $query;
            });

        $sub_cat = SubCategory::where('category_id', $category_id)->Where('status', 1)->get()->map(function($query){
            if(!empty($query->logo)){
                $query->logo = asset('assets/images/subcategorylogo/'.$query->logo);
            }
            $query->is_custom_package = false;
            return $query;
        });


        $all_packages = Package::with(['package_services' => function ($query) {
            $query->select('*')->with(['service' => function($query){
                $query->select('id','category_id','sub_category_id','title','price','image','banner','franchises_id','hour','minute','status','created_at','updated_at','deleted_at');
            }]);
        }])
        ->with(['package_media' => function($query){
            $query->select('id','package_id','media','created_at','updated_at','deleted_at');
        }])
        ->select('packages.id','packages.category_id','packages.sub_category_id','packages.title','packages.banner','packages.discount_value','packages.discount_type','packages.is_flexible','packages.franchises_id','packages.minimum_require','packages.status','packages.created_at','packages.updated_at','packages.deleted_at', DB::raw('count(pr.id) as review_count'), DB::raw('avg(pr.package_rating) as review_avg'))
        ->join('package_services AS ps', function($join){
            $join->on('ps.package_id', '=', 'packages.id')->where(['ps.deleted_at' => null]);
        })
        // ->join('package_media AS pm', function($join){
        //     $join->on('pm.package_id', '=', 'packages.id')->where(['pm.deleted_at' => null]);
        // })
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
        ->where(['s.status' => 1,'fc.deleted_at' => null])
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
        // $all_packages = $all_packages->groupBy('packages.id')->get();

        $all_packages = $all_packages->select(['packages.id','packages.category_id','packages.sub_category_id','packages.title','packages.banner','packages.discount_value','packages.discount_type','packages.is_flexible','packages.franchises_id','packages.minimum_require','packages.status','packages.created_at','packages.updated_at','packages.deleted_at'])->groupBy('packages.id')->get()->map(function($query){
            if(!empty($query->banner)){
                $query->banner = asset('assets/images/packagebanner/'.$query->banner);
            }
            if(!empty($query->package_media)){
                $query->package_media->map(function($p_media_query){
                    if(!empty($p_media_query->media)){
                        $p_media_query->media = asset('assets/images/packagemedia/'.$p_media_query->media);
                    }
                });
            }
            if(!empty($query->package_services)) {
                $query->package_services->map(function($sub_query){
                    
                    if(!empty($sub_query->service->image)) {
                        $sub_query->service->images = asset('assets/images/servicelogo/'.$sub_query->service->image);
                    }
                    if(!empty($sub_query->service->banner)) {
                        $sub_query->service->banner = asset('assets/images/servicebanner/'.$sub_query->service->banner);
                    }
                    return $sub_query;
                });

            }
            return $query;
        });
        
        $services = [];
        if($sub_cat_slug!='all-package'){
            $services = Service::with(['service_media'])
                ->select('services.id','services.category_id','services.sub_category_id','services.title','services.image','services.banner','services.price','services.franchises_id','services.hour','services.minute','services.status','services.created_at','services.updated_at','services.deleted_at', DB::raw('count(sr.id) as review_count'), DB::raw('avg(sr.service_rating) as review_avg'))->where(['services.status' => 1, 'services.category_id' => $category_id]);
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

            $services = $services->get()->map(function($query){
            
                if(!empty($query->banner)){
                    $query->banner = asset('assets/images/servicebanner/'.$query->banner);
                }
                if(!empty($query->image)){
                    $query->image = asset('assets/images/servicelogo/'.$query->image);
                }
                if(!empty($query->service_media)){
                    $query->service_media->map(function($sub_query){
                        $sub_query->media = asset('assets/images/servicemedia/'.$sub_query->media);
                        return $sub_query;
                    });
                }
                return $query;
            });
        }


        $where = [
            'services_ratings.status' => 1,
            'category_id' => $category_id
        ];

        if (!empty($sub_cat_slug)) {
            $where['sub_category_id'] = $sub_category_id;
        }

        // $sub_category = null;
        // if(!empty($sub_category_id)) {
        //     $sub_category = SubCategory::where('id', $sub_category_id)->first();
        //     if($sub_category){
        //         $sub_category_id = $sub_category->id;
        //         $all_packages->join('package_subcategories AS psc', function($join){
        //             $join->on('psc.package_id', '=', 'packages.id');
        //         })->where('psc.sub_category_id', $sub_category_id);
        //     }
        // }

        // $all_packages = $all_packages->select(['packages.id','packages.category_id','packages.sub_category_id','packages.title','packages.banner','packages.discount_value','packages.discount_type','packages.is_flexible','packages.franchises_id','packages.minimum_require','packages.status','packages.created_at','packages.updated_at','packages.deleted_at'])->groupBy('packages.id')->get()->map(function($query){
        //     if(!empty($query->banner)){
        //         $query->banner = asset('assets/images/packagebanner/'.$query->banner);
        //     }

        //     if(!empty($query->package_services)) {
        //         $query->package_services->map(function($sub_query){
        //             if(!empty($sub_query->service->image)) {
        //                 $sub_query->service->images = asset('assets/images/servicelogo/'.$sub_query->service->image);
        //             }
        //             if(!empty($sub_query->service->banner)) {
        //                 $sub_query->service->banner = asset('assets/images/servicebanner/'.$sub_query->service->banner);
        //             }
        //             return $sub_query;
        //         });

        //     }
        //     return $query;
        // });

        // echo '<pre>';
        // print_R($all_packages->toArray());die;

        // if(isset($request->test)){
        //     echo '<pre>';
        //     print_R($all_packages->toArray());die;
        // }
        if($all_packages->count() > 0){
            $sub_cat = $sub_cat->toArray();
            $sub_cat[] = [
                'id' => 0,
                'title'=> 'Packages',
                'slug'=> 'all-package',asset('assets/images/categorylogo/other-category.png'),
                'logo'=> asset('assets/images/categorylogo/other-category.png'),
                'service_count'=> 0,
                'package_count'=> 0,
                'is_custom_package'=> true
            ];
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

        $my_cart = [];
        if (Auth::check()) {
            $id = Auth::user()->id;
            $My_cart = My_cart::where('user_id', $id)->first();
            if($My_cart){
                $my_cart = $My_cart->cart_data;
            }
        }
        // $my_cart = Session::has('my_cart') ? Session::get('my_cart') : $my_cart;

        return $this->success([
            "category" => $category,
            "sub_category" => $sub_cat,
            "services" => $services,
            "all_packages" => $all_packages,
            "total_review" => $total_review,
            "review_ratings" => $review_ratings,
            "total_review_count" => $total_review_count,
            "my_cart" => $my_cart
        ]);

        // return view('front.services', compact('cat', 'sub_cat', 'all_packages', 'services', 'total_review', 'review_ratings', 'total_review_count', 'my_cart','sub_cat_slug','sub_category'));

    }

    public function serviceDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'type' => 'required',
        ]);
        
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }

        $image_formats = ['jpg','png','jpeg','gif'];

        $id = $request->id;
        $type = $request->type;

        if($type == 'service'){
            $services = Service::with([
                'service_media',
                'services_ratings' => function($query){
                    $query->with(['user' => function($q){
                        $q->select('id','name');
                    }]);
                }
            ])->select('services.*', DB::raw('count(sr.id) as review_count'), DB::raw('avg(sr.service_rating) as review_avg'))->where(['services.status' => 1, 'services.id' => $id])
            ->leftJoin('services_ratings As sr', function ($join) {
                $join->on('sr.service_id', '=', 'services.id');
            })
            ->groupBy('services.id');

            $serve = $services->get()->map(function($query){
                if(!empty($query->image)){
                    $query->image = asset('assets/images/servicelogo/'.$query->image);
                }
                if(!empty($query->banner)){
                    $query->banner = asset('assets/images/servicebanner/'.$query->banner);
                }
                if(!empty($query->service_media)){
                    $query->service_media->map(function($service_query){
                        if(!empty($service_query->media)){
                            $service_query->media = asset('assets/images/servicemedia/'.$service_query->media);
                        }
                    });
                }

                if(!empty($query->services_ratings)){
                    $query->services_ratings->map(function($service_rating_query){
                        if(!empty($service_rating_query->user->photo)){
                            $service_rating_query->user->profile_pic = asset('assets/images/users/'.$service_rating_query->user->photo);
                        }else{
                            $service_rating_query->user->profile_pic = asset('assets/images/profile.png');
                        }
                        $service_rating_query->review_date = $service_rating_query->created_at->format('d F, Y');
                    });
                }
                return $query;
            });

            $service_specifications = Service_specifications::where(['service_id' => $id, 'status' => 1])->get()->map(function($query){
                $query->filename = asset('assets/images/service_specifications/'.$query->filename);
                return $query;
            });

            

            return $this->success([
                "services" => $serve,
                "service_specifications" => $service_specifications
            ]);

        }elseif($type == 'package'){

            $all_packages = Package::with([
                'package_media' => function ($query) {
                    $query->select('*');
                },
                'package_services' => function ($query) {
                    $query->select('*')->with(['service']);
                },
                'packages_ratings' => function ($query) {
                    $query->with(['user']);
                },
            ])
            ->select('packages.*', DB::raw('count(pr.id) as review_count'), DB::raw('avg(pr.package_rating) as review_avg'))
            ->where('packages.id', $id)
            ->leftJoin('packages_ratings As pr', function ($join) {
                $join->on('pr.package_id', '=', 'packages.id');
            });

            $pack = $all_packages->groupBy('packages.id')->get()->map(function($query){
                if(!empty($query->banner)){
                    $query->banner = asset('assets/images/packagebanner/'.$query->banner);
                }
                if(!empty($query->package_media)){
                    $query->package_media->map(function($package_media){
                        if(!empty($package_media->media)){
                            $package_media->media = asset('assets/images/packagemedia/'.$package_media->media);
                        }
                    });
                }
                if(!empty($query->package_services)) {
                    $query->package_services->map(function($sub_query){
                        
                        if(!empty($sub_query->service->image)) {
                            $sub_query->service->image = asset('assets/images/servicelogo/'.$sub_query->service->image);
                        }
                        if(!empty($sub_query->service->banner)) {
                            $sub_query->service->banner = asset('assets/images/servicebanner/'.$sub_query->service->banner);
                        }
                        return $sub_query;
                    });
    
                }
                return $query;
            });

            return $this->success([
                "all_packages" => $pack,
            ]);

                
        }
    }


    public function service_search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }

        $service_search = null;
        $services = [];

        if(isset($request->service_search)){
            $service_search = $request->service_search;
        }
        

        // $city_id = $this->get_location_city($location_search);
        $lat = $request->latitude;
        $lng = $request->longitude;

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
        ->join('sub_categories As sc', function ($sub_join) {
            return $sub_join->on('services.sub_category_id', '=', 'sc.id');
        })
        ->select('services.id','services.title','services.category_id','services.image','c.slug as category_slug','c.title as category_title','c.id as category_id','sc.id as sub_category_id','sc.slug as sub_category_slug','sc.title as sub_category_title')
        ->where('services.title', 'LIKE', "%{$service_search}%")
        ->where(['services.status' => 1,'fc.deleted_at' => null])
        ->where('f.area_lat1', '>=', $lat)
        ->where('f.area_lng1', '<=', $lng)
        ->where('f.area_lat2', '<=', $lat)
        ->where('f.area_lng2', '>=', $lng)
        ->groupBy('services.id');
        
        $services = $services->get()->map(function($query){
            if(!empty($query->image)){
                $query->image = asset('assets/images/servicelogo/'.$query->image);
            }
            return $query;
        });

        return $this->success([
            "services" => $services,
        ]);

    }

    public function me(Request $request) {
        return $request->user();
    }
}
