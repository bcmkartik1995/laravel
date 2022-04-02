<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Offer;
use App\Offer_user;
use App\Category;
use App\SubCategory;
use App\Service;
use App\Package;
use App\Franchise;
use App\GiftCard;
use App\Services_ratings;
use App\Packages_ratings;
use App\Best_service;
use Illuminate\Support\Facades\DB;
use App\Credit_plans;
use App\Slider;
use App\Best_offers;
use App\Blog;
use App\Franchise_worker;
use App\Faq;
use App\Our_team;
use App\Service_specifications;
use App\Testimonial;

class ToggleStatusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function toggle_status(Request $request)
    {
        $action = $request->action;
        $id = $request->id;

        if($action == 'offer'){

            $offers = Offer::findOrFail($id);
            if($offers->status == 1) {
                $offers->status = 0;
                $offers->save();
            }else{
                $offers->status = 1;
                $offers->save();
            }
            return response()->json($offers);

        }

        if($action == 'category'){
            $category = Category::findOrFail($id);
            if($category->status == 1) {
                $category->status = 0;
                $category->save();
            }else{
                $category->status = 1;
                $category->save();
            }
            return response()->json($category);
        }

        if($action == 'sub-category'){
            $subcategory = SubCategory::findOrFail($id);
            if($subcategory->status == 1) {
                $subcategory->status = 0;
                $subcategory->save();
            }else{
                $subcategory->status = 1;
                $subcategory->save();
            }
            return response()->json($subcategory);
        }

        if($action == 'package'){
            $package = Package::findOrFail($id);
            if($package->status == 1) {
                $package->status = 0;
                $package->save();
            }else{
                $package->status = 1;
                $package->save();
            }
            return response()->json($package);
        }

        if($action == 'service'){
            $service = Service::findOrFail($id);
            if($service->status == 1) {
                $service->status = 0;
                $service->save();
            }else{
                $service->status = 1;
                $service->save();
            }
            return response()->json($service);
        }

        if($action == 'franchise'){

            $franchise = Franchise::findOrFail($id);
            if($franchise->status == 1) {
                $franchise->status = 0;
                $franchise->save();
            }else{
                $franchise->status = 1;
                $franchise->save();
            }
            return response()->json($franchise);
        }

        if($action == 'gift'){

            $gifts = GiftCard::findOrFail($id);
            if($gifts->status == 1) {
                $gifts->status = 0;
                $gifts->save();
            }else{
                $gifts->status = 1;
                $gifts->save();
            }
            return response()->json($gifts);
        }

        if($action == 'best_service'){

            $best_service = Best_service::findOrFail($id);
            if($best_service->status == 1) {
                $best_service->status = 0;
                $best_service->save();
            }else{
                $best_service->status = 1;
                $best_service->save();
            }
            return response()->json($best_service);
        }

        if($action == 'service_rating'){

            $service_rating = Services_ratings::findOrFail($id);
            if($service_rating->status == 1) {
                $service_rating->status = 0;
                $service_rating->save();
            }else{
                $service_rating->status = 1;
                $service_rating->save();
            }
            return response()->json($service_rating);
        }

        if($action == 'package_rating'){

            $package_rating = Packages_ratings::findOrFail($id);
            if($package_rating->status == 1) {
                $package_rating->status = 0;
                $package_rating->save();
            }else{
                $package_rating->status = 1;
                $package_rating->save();
            }
            return response()->json($package_rating);
        }

        if($action == 'credit_plans'){

            $Credit_plans = Credit_plans::findOrFail($id);
            if($Credit_plans->status == 1) {
                $Credit_plans->status = 0;
            }else{
                $Credit_plans->status = 1;
            }
            $Credit_plans->save();
            return response()->json($Credit_plans);

        }

        if($action == 'slider'){

            $slider = Slider::findOrFail($id);
            if($slider->status == 1) {
                $slider->status = 0;
            }else{
                $slider->status = 1;
            }
            $slider->save();
            return response()->json($slider);

        }

        if($action == 'best-offer'){

            $best_offers = Best_offers::findOrFail($id);
            if($best_offers->status == 1) {
                $best_offers->status = 0;
                $best_offers->save();
            }else{
                $best_offers->status = 1;
                $best_offers->save();
            }
            return response()->json($best_offers);

        }

        if($action == 'blog'){

            $blog = Blog::findOrFail($id);
            if($blog->status == 1) {
                $blog->status = 0;
                $blog->save();
            }else{
                $blog->status = 1;
                $blog->save();
            }
            return response()->json($blog);

        }

        if($action == 'franchise_worker'){

            $franchise_worker = Franchise_worker::findOrFail($id);
            if($franchise_worker->status == 1) {
                $franchise_worker->status = 0;
                $franchise_worker->save();
            }else{
                $franchise_worker->status = 1;
                $franchise_worker->save();
            }
            return response()->json($franchise_worker);

        }
	
	    if($action == 'service_specification'){

            $offers = Service_specifications::findOrFail($id);
            if($offers->status == 1) {
                $offers->status = 0;
                $offers->save();
            }else{
                $offers->status = 1;
                $offers->save();
            }
            return response()->json($offers);

        }

        if($action == 'service_faq'){
           
            $faq = Faq::findOrFail($id);
            if($faq->status == 1) {
                $faq->status = 0;
                $faq->save();
            }else{
                $faq->status = 1;
                $faq->save();
            }
            return response()->json($faq);

        }

        if($action == 'ourteam'){
           
            $our_team = Our_team::findOrFail($id);
            if($our_team->status == 1) {
                $our_team->status = 0;
                $our_team->save();
            }else{
                $our_team->status = 1;
                $our_team->save();
            }
            return response()->json($our_team);

        }

        if($action == 'testimonial'){
           
            $testimonial = Testimonial::findOrFail($id);
            if($testimonial->status == 1) {
                $testimonial->status = 0;
                $testimonial->save();
            }else{
                $testimonial->status = 1;
                $testimonial->save();
            }
            return response()->json($testimonial);

        }
    }
}
