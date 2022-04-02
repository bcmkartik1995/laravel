<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\DB;
use App\Aboutus;
use App\Our_team;
use App\Service;
use App\City;
use App\Franchise;
use App\User;

class AboutusController extends Controller
{
    use ApiResponser;

    public function about_us()
    {
        $about_us = Aboutus::where(['status' => 1, 'deleted_at' => null])->first();

        $services_count = Service::where(['status' => 1,'deleted_at' => null])->count();
        $city_count = City::where(['status' => 1])->count();
        $franchise_count = Franchise::where(['status' => 1,'deleted_at' => null])->count();
        $services_count = User::where(['deleted_at' => null])->count();

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
            


        $our_team = Our_team::where(['status' => 1, 'deleted_at' => null])
        ->get()
        ->map(function($query){
            $query->image = asset('assets/images/ourteamimg/'.$query->image);
            return $query;
        });

        if(!empty($about_us->section3_image))
        {   
            $about_us->section3_image = asset('assets/images/whoweareimg/'.$about_us->section3_image);
        }
        return $this->success([
            "about" => $about_us,
            "counter" => $counter,
            "our_team" => $our_team,
        ]);
    }
}
