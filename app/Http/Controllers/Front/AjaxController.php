<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use App\Service;
use App\Package;
use App\City;
use App\State;
use App\Service_specifications;

class AjaxController extends Controller
{
    public function get_service_detail(Request $request){

        $image_formats = ['jpg','png','jpeg','gif'];
        $id = $request->id;
        $type = $request->type;
        if($type == 'service'){
            $services = Service::with([
                'service_media',
                'services_ratings' => function($query){
                    $query->with('user');
                }
            ])->select('services.*', DB::raw('count(sr.id) as review_count'), DB::raw('avg(sr.service_rating) as review_avg'))->where(['services.status' => 1, 'services.id' => $id])
            ->leftJoin('services_ratings As sr', function ($join) {
                $join->on('sr.service_id', '=', 'services.id');
            })
            ->groupBy('services.id');

            $serve = $services->first();

            $service_specifications = Service_specifications::where(['service_id' => $id, 'status' => 1])->get();

            return view('front.get_service_detail', compact('serve','image_formats','service_specifications'));
        }else if($type == 'package'){

            $all_packages = Package::with([
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

                $pack = $all_packages->groupBy('packages.id')->first();

                return view('front.get_service_detail', compact('pack','image_formats'));
        }
    }

    public function ajax_state_from_country(Request $request){

        $states = State::join('countries As c', function ($join) {
            $join->on('c.id', '=', 'states.country_id');
        })
        ->select('states.id', 'states.name')
        ->where('c.id','=',$request->country_id)->get();
        return response()->json($states);
    }

    public function ajax_city_from_state(Request $request){

        $city = City::join('states As s', function ($join) {
            $join->on('s.id', '=', 'cities.state_id');
        })
        ->select('cities.id', 'cities.name')
        ->where('s.id','=',$request->state_id)->get();
        return response()->json($city);
    }

}
