<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/register', 'Api\AuthController@register');
Route::get('/sign-up-city', 'Api\AuthController@signup_city');
Route::post('/login', 'Api\AuthController@login');
Route::post('/forgot-password', 'Api\AuthController@forgot_password');
Route::post('/reset-password', 'Api\AuthController@reset_password');

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:sanctum')->group( function () {
    // Route::resource('profile', UserController::class);
    Route::post('/login2', 'Api\AuthController@login2');
});

Route::post('/latlong', 'Api\CategoryController@latlong');
Route::post('/categories', 'Api\CategoryController@categories');
Route::post('/subcategories', 'Api\CategoryController@subcategories');
Route::post('/other-category', 'Api\CategoryController@other_category');
Route::post('/services', 'Api\ServiceController@serviceList');
Route::post('/service-search', 'Api\ServiceController@service_search');
Route::post('/services-details', 'Api\ServiceController@serviceDetail');
Route::post('/add-to-cart', 'Api\CartController@add_to_cart');
Route::post('/cart-details', 'Api\CartController@cart_details');
Route::post('/user-addresses', 'Api\AddressController@user_addresses');
Route::post('/add-address', 'Api\AddressController@add_address');
Route::post('/edit-address', 'Api\AddressController@edit_address');
Route::post('/delete-address', 'Api\AddressController@delete_address');
Route::post('/get-timeslots', 'Api\AddressController@get_timeslots');

Route::post('/order-history', 'Api\OrdersController@order_history');
Route::post('/ongoing-orders', 'Api\OrdersController@ongoing_orders');
Route::post('/order-tracking', 'Api\OrdersController@order_tracking');
Route::post('/order-detail', 'Api\OrdersController@order_detail');
Route::post('/order-review', 'Api\OrdersController@order_review');
Route::post('/place-order', 'Api\OrdersController@place_order');
Route::post('/order-pay', 'Api\OrdersController@order_pay');
Route::post('/cancel-order', 'Api\OrdersController@cancel_order');

Route::post('/user-detail', 'Api\UserprofileController@user_detail');
Route::post('/user-edit-profile', 'Api\UserprofileController@user_edit_profile');
Route::post('/countries', 'Api\UserprofileController@countries');
Route::post('/states', 'Api\UserprofileController@states');
Route::post('/cities', 'Api\UserprofileController@cities');
Route::post('/user-change-password', 'Api\UserprofileController@user_change_password');

Route::post('/register-professional', 'Api\RegisterprofessionalController@register_professional');
Route::post('/contact-us', 'Api\RegisterprofessionalController@contact_us');

Route::get('/about', 'Api\AboutusController@about_us');

Route::get('/blogs', 'Api\BlogsController@blogs');
Route::get('/blog-detail/{blog_id}', 'Api\BlogsController@blog_detail');
Route::get('/blogs-by-category/{category_id}', 'Api\BlogsController@blogs_by_category');
Route::get('/blogs-by-tag/{tag_slug}', 'Api\BlogsController@blogs_by_tag');


// ----------------------- Franchise API - START --------------------------------------------

Route::post('/franchise/login', 'Api\Admin\AuthController@login');
Route::post('/franchise/forgot_password', 'Api\Admin\AuthController@forgot_password');
Route::post('/franchise/dashboard', 'Api\Admin\FranchiseController@dashboard');
Route::post('/franchise/franchise-notification-read', 'Api\Admin\FranchiseController@notification_read');

Route::post('/franchise/franchise-order', 'Api\Admin\FranchiseorderController@frachise_order');
Route::post('/franchise/order-detail', 'Api\Admin\FranchiseorderController@order_detail');
Route::post('/franchise/frachise-service-status', 'Api\Admin\FranchiseorderController@frachise_service_status');
Route::post('/franchise/frachise-order-status', 'Api\Admin\FranchiseorderController@frachise_order_status');

Route::post('/franchise/worker-detail', 'Api\Admin\FranchiseworkerController@worker_detail');
Route::post('/franchise/franchise-service', 'Api\Admin\FranchiseworkerController@franchise_service');
Route::post('/franchise/worker-add', 'Api\Admin\FranchiseworkerController@worker_add');
Route::post('/franchise/worker-edit', 'Api\Admin\FranchiseworkerController@worker_edit');
Route::post('/franchise/worker-update', 'Api\Admin\FranchiseworkerController@worker_update');
Route::post('/franchise/worker-status', 'Api\Admin\FranchiseworkerController@worker_status');

Route::post('/franchise/franchise-timing', 'Api\Admin\FranchisetimingController@franchise_timing');
Route::post('/franchise/franchise-timing-add', 'Api\Admin\FranchisetimingController@franchise_timing_store');
Route::post('/franchise/franchise-offday', 'Api\Admin\FranchisetimingController@franchise_offday');
Route::post('/franchise/franchise-offday-add', 'Api\Admin\FranchisetimingController@franchise_offday_add');
Route::post('/franchise/franchise-offday-edit', 'Api\Admin\FranchisetimingController@franchise_offday_edit');
Route::post('/franchise/franchise-offday-update', 'Api\Admin\FranchisetimingController@franchise_offday_update');

Route::post('/franchise/franchise-credit', 'Api\Admin\FranchiseCreditController@franchise_credit');
Route::post('/franchise/credit-plan', 'Api\Admin\FranchiseCreditController@credit_plan');
Route::post('/franchise/credit-plan-custome', 'Api\Admin\FranchiseCreditController@credit_plan_custome');
Route::post('/franchise/credit-plan-purchase', 'Api\Admin\FranchiseCreditController@credit_plan_purchase');

Route::post('/franchise/franchise-profile', 'Api\Admin\FranchiseController@franchise_profile');
Route::post('/franchise/franchise-profile-edit', 'Api\Admin\FranchiseController@franchise_profile_edit');
Route::post('/franchise/franchise-working-cities', 'Api\Admin\FranchiseController@franchise_working_cities');
Route::post('/franchise/countries', 'Api\Admin\FranchiseController@countries');
Route::post('/franchise/states', 'Api\Admin\FranchiseController@states');
Route::post('/franchise/cities', 'Api\Admin\FranchiseController@cities');

Route::post('/franchise/franchise-user-profile', 'Api\Admin\FranchiseuserController@franchise_user_profile');
Route::post('/franchise/franchise-user-profile-edit', 'Api\Admin\FranchiseuserController@franchise_user_profile_edit');

Route::post('/franchise/franchise-account', 'Api\Admin\AccountsController@franchise_account');

Route::post('/franchise/change-password', 'Api\Admin\FranchiseuserController@change_password');

// ----------------------- Franchise API - END --------------------------------------------





// ----------------------- Worker API - Start --------------------------------------------//
Route::post('/worker/dashboard', 'Api\Admin\WorkerController@dashboard');
Route::post('/worker/worker-order', 'Api\Admin\WorkerOrderController@worker_order');
Route::post('/worker/worker-service-list', 'Api\Admin\WorkerOrderController@order_service_filter_list');
Route::post('/worker/worker-order-detail', 'Api\Admin\WorkerOrderController@worker_order_detail');
Route::post('/worker/worker-order-status', 'Api\Admin\WorkerOrderController@worker_order_status');

Route::post('/worker/worker-user-profile', 'Api\Admin\WorkerController@worker_user_profile');
Route::post('/worker/worker-user-profile-update', 'Api\Admin\WorkerController@worker_user_profile_update');

Route::post('/worker/worker-change-password', 'Api\Admin\WorkerController@change_password');
// ----------------------- Worker API - end --------------------------------------------//
