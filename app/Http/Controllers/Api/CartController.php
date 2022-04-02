<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;
use App\My_cart;
use App\Package;
use App\Service;
use Carbon\Carbon;
use App\GiftCard;
use App\Offer;
use App\User;

use Illuminate\Support\Collection;

class CartController extends Controller
{
    use ApiResponser;

    public function add_to_cart(Request $request) {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'cart_data' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }

        $user_id = $request->user_id;
        $cart_data = $request->cart_data;

        if(empty($cart_data['packages']) && empty($cart_data['services'])){
            $My_cart = My_cart::where('user_id', $user_id)->first();
            if($My_cart){
                $My_cart->delete();
            }
            return $this->success([
                'Success' => 'Cart data removed successfully.'
            ]);
        } else {

            if(!empty($cart_data['services'])){
                $services_collection = collect($cart_data['services']);
                $cart_data['services'] = $services_collection->mapWithKeys(function ($item) {
                    return [$item['id'] => $item];
                })->toArray();
            }
            if(!empty($cart_data['packages'])){
                $packages_collection = collect($cart_data['packages']);
                $cart_data['packages'] = $packages_collection->mapWithKeys(function ($item) {
                    return [$item['id'] => $item];
                })->toArray();
            }

            $My_cart = My_cart::where('user_id', $user_id)->first();
            if ($My_cart) {
                $My_cart->cart_data = $cart_data;
                $My_cart->save();
            } else {
                $My_cart = new My_cart;
                $My_cart->user_id = $user_id;
                $My_cart->cart_data = $cart_data;
                $My_cart->save();
            }

            return $this->success([
                'Success' => 'Cart data saved successfully.'
            ]);
        }

    }

    public function cart_details(Request $request) {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 401);
        }

        $user_id = $request->user_id;
        $My_cart = My_cart::where('user_id', $user_id)->first();

        if ($My_cart) {
            $cart_data = $My_cart['cart_data'];
            if(!empty($cart_data['packages'])){
                foreach($cart_data['packages'] as $p => $package){
                    $get_package = Package::where('id', $package['id'])->select('title','banner','discount_value','discount_type','description','is_flexible','minimum_require')
                    ->first()
                    ->toArray();
                    if(!empty($get_package['banner'])){
                        $get_package['banner'] = asset('assets/images/packagebanner/'.$get_package['banner']);
                    }
                    $cart_data['packages'][$p] = array_merge($package, $get_package);
                }
                $cart_data['packages'] = array_values($cart_data['packages']);
            }
            if(!empty($cart_data['services'])){
                foreach($cart_data['services'] as $p => $service){
                    $get_service = Service::where('id', $service['id'])->select('title','banner','description')->first()->toArray();
                    if(!empty($get_service['banner'])){
                        $get_service['banner'] = asset('assets/images/servicebanner/'.$get_service['banner']);
                    }
                    $cart_data['services'][$p] = array_merge($service, $get_service);
                }
                $cart_data['services'] = array_values($cart_data['services']);

            }

            if(!isset($cart_data['services'])){
                $cart_data['services'] = [];
            }
            if(!isset($cart_data['packages'])){
                $cart_data['packages'] = [];
            }

            $today = Carbon::now()->format('Y-m-d');
            $offers = Offer::with(['user_offer' => function ($query) use($user_id) {
                $query->select('id','offer_id','user_id')->where(['user_id' => $user_id, 'status' => 1]);
            }])
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->where(['status' => 1])
            ->select(['id','title','description','offer_code','is_global','category_id','sub_category_id','service_id','offer_type','offer_value','max_value','is_user_specific','banner','start_date','end_date'])
            ->get()->map(function($query){
                if(!empty($query->banner)){
                    $query->banner = asset('assets/images/offerbanner/'.$query->banner);
                }
                return $query;
            });
            foreach ($offers as $k => $offer) {
                if ($offer['is_user_specific'] == 1 && empty($offer['user_offer'])) {
                    unset($offers[$k]);
                }
            }

            $user = User::where('id', $user_id)->first();

            $gift_cards = GiftCard::join('gift_users as gu','gift_cards.id','=','gu.gift_card_id')
            ->select('gift_cards.id','title','description','gift_value','image','valid_from','valid_to')
            ->where(['gu.email'=>$user->email])->where('gift_cards.valid_from', '<=', $today)->where('gift_cards.valid_to', '>=', $today)
            ->where(['gift_cards.status' => 1])->get()->map(function($query){
                if(!empty($query->image)){
                    $query->image = asset('assets/images/giftsimage/'.$query->image);
                }
                return $query;
            });

            return $this->success([
                'cart_data' => $cart_data,
                'offers' => $offers,
                'gift_cards' => $gift_cards
            ]);
        } else {
            return $this->error('Cart is empty.', 401);
        }


    }

}
