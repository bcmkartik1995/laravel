<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('admin')->group(function() {
  
    Route::get('/login', 'Admin\LoginController@showLoginForm')->name('admin.login');
    Route::post('/verify_admin_mobile', 'Admin\LoginController@verify_admin_mobile')->name('verify_admin_mobile');
    Route::post('/send_admin_otp', 'Admin\LoginController@send_admin_otp')->name('send_admin_otp');
    Route::post('/adminOtpLogin', 'Admin\LoginController@adminOtpLogin')->name('adminOtpLogin');
    Route::post('/login', 'Admin\LoginController@login')->name('admin.login.submit');
    Route::get('/logout', 'Admin\LoginController@logout')->name('admin.logout');
    //Route::get('/', 'Admin\AdminController@index')->name('admin.dashboard');
    Route::get('/forgot', 'Admin\LoginController@showForgotForm')->name('admin.forgot');
    Route::post('/forgot', 'Admin\LoginController@forgot')->name('admin.forgot.submit');

    Route::get('/reset-password/{token}', 'Admin\ResetPasswordController@getPassword');
    Route::post('/reset-password', 'Admin\ResetPasswordController@updatePassword')->name('admin.reset.submit');


    //------------ ADMIN DASHBOARD & PROFILE SECTION ------------
    Route::get('/', 'Admin\DashboardController@index')->name('admin.dashboard');
    Route::get('/profile', 'Admin\DashboardController@profile')->name('admin.profile');
    Route::post('/profile/update', 'Admin\DashboardController@profileupdate')->name('admin.profile.update');
    Route::get('/password', 'Admin\DashboardController@passwordreset')->name('admin.password');
    Route::post('/password/update', 'Admin\DashboardController@changepass')->name('admin.password.update');
    //------------ ADMIN DASHBOARD & PROFILE SECTION ENDS ------------


    //--------- New Add Controller ------------//
  Route::group(['middleware'=>'permissions:franchises'],function(){

    Route::get('/franchise/datatables', 'Admin\FranchiseController@datatables')->name('admin-franchises');

    Route::get('/franchise/{id}','Admin\FranchiseController@create')->name('user-franchise');
    Route::post('/franchise/store','Admin\FranchiseController@store')->name('franchise-store');
    Route::get('/franchises','Admin\FranchiseController@index')->name('franchise-view');
    Route::get('/franchises-edit/{id}','Admin\FranchiseController@edit')->name('franchise-edit');
    Route::post('/franchises-update/{id}','Admin\FranchiseController@update')->name('franchise-update');
    Route::delete('/franchises-delete/{id}','Admin\FranchiseController@delete')->name('franchise-delete');
    Route::post('/franchises-subcat','Admin\AjaxController@franchises_subcat')->name('franchises-subcat');


  });
  Route::group(['middleware'=>'permissions:franchise_user'],function(){
    Route::get('/franchise-user','Admin\FranchiseController@franchise_user')->name('franchise-user-view');
    Route::get('/franchise-user-edit/{id}','Admin\FranchiseController@franchise_user_edit')->name('franchise-user-edit');
    Route::post('/franchise-user-update/{id}','Admin\FranchiseController@franchise_user_update')->name('franchise-user-update');
    Route::delete('/franchises-user-delete/{id}','Admin\FranchiseController@franchise_user_delete')->name('franchise-user-delete');
  });

  Route::group(['middleware'=>'permissions:categories'],function(){
      Route::resource('categories', 'Admin\CategoriesController');
  });

  Route::group(['middleware'=>'permissions:sub_categories'],function(){
    Route::resource('sub-categories', 'Admin\SubcategoriesController');
  });

  Route::group(['middleware'=>'permissions:services'],function(){
    //service route
    Route::post('service/media/{id}','Admin\ServicesController@update_media')->name('update.media');
    Route::post('service/add-media','Admin\ServicesController@add_media')->name('add.media');
    Route::delete('service/media-destroy/{id}','Admin\ServicesController@media_destroy')->name('media.destroy');
    Route::resource('services','Admin\ServicesController');
    Route::post('/ajax-subcat','Admin\AjaxController@ajax_subcat')->name('ajax-subcat');
    Route::post('/edit-ajax-subcat','Admin\AjaxController@edit_ajax_subcat');
  });

  Route::group(['middleware'=>'permissions:best_services'],function(){
    //best service route
    Route::resource('best-service','Admin\BestserviceController');
    Route::post('best-subcat','Admin\AjaxController@best_subcat');
    Route::post('best-subservice','Admin\AjaxController@best_service');
  });

  Route::group(['middleware'=>'permissions:service_specification'],function(){
        Route::get('service_specification/{service_id}','Admin\ServicespecificationsController@index')->name('service_specification.index');
        Route::get('service_specification/create/{service_id}','Admin\ServicespecificationsController@create')->name('service_specification.create');
        Route::post('service_specification/store','Admin\ServicespecificationsController@store')->name('service_specification.store');
        Route::get('service_specification/edit/{id}','Admin\ServicespecificationsController@edit')->name('service_specification.edit');
        Route::post('service_specification/update/{id}','Admin\ServicespecificationsController@update')->name('service_specification.update');
        Route::delete('service_specification/destroy/{id}','Admin\ServicespecificationsController@destroy')->name('service_specification.destroy');
        // Route::get('service_specification/{service_id}','Admin\ServicespecificationsController@index')->name('service_specification.index');
        // Route::post('service_specification/add-media','Admin\ServicesController@add_media')->name('add.media');
        // Route::delete('service_specification/media-destroy/{id}','Admin\ServicesController@media_destroy')->name('media.destroy');
  });


  Route::group(['middleware'=>'permissions:service_faq'],function(){
      //Route::resource('service_faq','Admin\FaqController');

      Route::get('service_faq/{service_id}','Admin\FaqController@index')->name('service_faq.index');
      Route::get('service_faq/create/{service_id}','Admin\FaqController@create')->name('service_faq.create');
      Route::post('service_faq/store','Admin\FaqController@store')->name('service_faq.store');
      Route::get('service_faq/edit/{id}','Admin\FaqController@edit')->name('service_faq.edit');
      Route::post('service_faq/update/{id}','Admin\FaqController@update')->name('service_faq.update');
      Route::delete('service_faq/destroy/{id}','Admin\FaqController@destroy')->name('service_faq.destroy');
  });



  Route::group(['middleware'=>'permissions:packages'],function(){
    //Package route
    Route::post('package/media/{id}','Admin\PackageController@update_media')->name('package.update.media');
    Route::post('package/add-media','Admin\PackageController@add_media')->name('package.add.media');
    Route::delete('package/media-destroy/{id}','Admin\PackageController@media_destroy')->name('package.media.destroy');
    Route::resource('package','Admin\PackageController');
    Route::post('/package-subcat','Admin\AjaxController@package_subcat')->name('package-subcat');
    Route::post('/package-service','Admin\AjaxController@package_service')->name('package-service');
  });

  Route::group(['middleware'=>'permissions:leads'],function(){
    //lead route
    Route::get('/lead/datatables', 'Admin\LeadController@datatables')->name('lead-datatables');
    Route::post('/add-to-franchise','Admin\LeadController@add_to_franchise')->name('add-to-franchise');
    Route::resource('lead','Admin\LeadController');
    Route::post('/ajax-country','Admin\AjaxController@ajax_country')->name('ajax-country');
    Route::post('/ajax-state','Admin\AjaxController@ajax_state')->name('ajax-state');
    Route::post('/lead-status','Admin\AjaxController@lead_status')->name('lead-status');
  });


  Route::group(['middleware'=>'permissions:offers'],function(){
    //Offer route
    Route::resource('offer', 'Admin\OfferController');
    Route::post('/offer-subcat','Admin\AjaxController@offer_subcat')->name('offer-subcat');
    Route::post('/offer-service','Admin\AjaxController@offer_service')->name('offer-service');
  });

  Route::group(['middleware'=>'permissions:best_offers'],function(){
    //best offer Route
    Route::resource('best-offer', 'Admin\BestofferController');
  });

  Route::group(['middleware'=>'permissions:gifts'],function(){
    //Gift-card route
    Route::get('/gift-card/send-gift', 'Admin\GiftController@send_gift_form')->name('send-gift');
    Route::post('/gift-card/send-gift-mail', 'Admin\GiftController@send_gift_mail')->name('send-gift-mail');
    Route::resource('gift-card','Admin\GiftController');
  });

  //Super Admin Order Route Start
  Route::group(['middleware'=>'permissions:orders'],function(){
    //orders route
    Route::get('/orders/datatables', 'Admin\OrdersController@datatables')->name('admin-order-datatables');
    Route::get('/orders','Admin\OrdersController@index')->name('orders-view');
    Route::get('/orders-edit/{id}','Admin\OrdersController@edit')->name('orders-edit');
    Route::post('/orders-update/{id}','Admin\OrdersController@update')->name('orders-update');
    Route::delete('/orders-delete/{id}','Admin\OrdersController@delete')->name('orders-delete');
    Route::post('/orders-status','Admin\AjaxController@orders_status')->name('orders-status');
    Route::get('/orders-details/{id}','Admin\OrdersController@show_orders')->name('orders-details');
    Route::get('/assign-franchises','Admin\OrdersController@assign_franchises');//assign-franchises
    Route::get('/franchise-orders-details/{id}','Admin\OrdersController@franchise_orders_details')->name('franchise-orders-details');

    //invoice
    Route::get('/order-invoice/{id}','Admin\OrdersController@order_invoice')->name('order-invoice');
    Route::get('/order-invoice-print/{id}','Admin\OrdersController@order_invoice_print')->name('order-invoice-print');
    Route::get('/order-invoice-send/{id}','Admin\OrdersController@order_invoice_send')->name('order-invoice-send');

  });
  Route::group(['middleware'=>'permissions:unallocated_orders'],function(){
    //orders route
    Route::get('/unallocated-orders/datatables', 'Admin\UnallocatorderController@datatables')->name('admin-unallocated-order-datatables');
    Route::get('/unallocated-orders','Admin\UnallocatorderController@index')->name('unallocated-orders-view');
    Route::delete('/unallocated-orders-delete/{id}','Admin\UnallocatorderController@delete')->name('unallocated-orders-delete');
    Route::post('/unallocated-orders-status','Admin\AjaxController@orders_status')->name('unallocated-orders-status');
    Route::get('/unallocated-orders-details/{id}','Admin\UnallocatorderController@show_orders')->name('unallocated-orders-details');
    //Route::get('/assign-franchises','Admin\UnallocatorderController@assign_franchises');//assign-franchises
    Route::get('/franchise-assign-order/{id}','Admin\UnallocatorderController@franchise_assign_order')->name('unallocated-franchise-assign-order');
    Route::post('/unallocated-order-assign_worker/{id}','Admin\UnallocatorderController@unallocated_order_assign_worker')->name('unallocated-order-assign_worker');
    Route::post('/ajax-franchise-assign','Admin\AjaxController@ajax_franchise_assign')->name('ajax-franchise-assign');

  });


  Route::group(['middleware'=>'permissions:orders,franchise_orders'],function(){
    Route::get('/orders-details/{id}','Admin\OrdersController@show_orders')->name('orders-details');

  });
  Route::group(['middleware'=>'permissions:franchise_orders'],function(){
    //franchise Order Route
    Route::get('/franchise-orders/datatables', 'Admin\FranchisesOrdersController@datatables')->name('admin-franchise-order');
    Route::get('/franchise-order','Admin\FranchisesOrdersController@index')->name('franchise-order');
    Route::post('/franchises-orders-status','Admin\AjaxController@franchises_orders')->name('franchises-orders-status');
    Route::post('/franchises-worker-status','Admin\AjaxController@franchises_worker')->name('franchises-worker-status');
    Route::get('/franchises-order-view/{id}','Admin\FranchisesOrdersController@franchises_order_view')->name('franchises-order-view');
    Route::get('/franchise-order-store','Admin\FranchisesOrdersController@store')->name('franchise-order-store');
    Route::get('/franchises-invoice/{id}','Admin\FranchisesOrdersController@franchises_invoice')->name('franchises-invoice');
    Route::get('/franchises-invoice-print/{id}','Admin\FranchisesOrdersController@franchises_invoice_print')->name('franchises-invoice-print');
    Route::get('/franchises-invoice-send/{id}','Admin\FranchisesOrdersController@franchises_invoice_send')->name('franchises-invoice-send');

    Route::post('/franchises-order-assign-worker/{id}','Admin\FranchisesOrdersController@franchises_order_assign_worker')->name('franchises-order-assign-worker');
  });

  Route::group(['middleware'=>'permissions:franchise_assigned'],function(){
    //franchises Assign Route
    Route::get('/franchises-assigned','Admin\FranchisesOrdersController@franchises_assign')->name('franchises-assigned');
  });

  Route::group(['middleware'=>'permissions:news_letter'],function(){
    //News Letter Route
    Route::resource('news-letter', 'Admin\NewsletterController');
  });

  Route::group(['middleware'=>'permissions:accounts'],function(){
    //Account Menu
    Route::get('/income','Admin\AccountsController@income')->name('income');
    Route::get('/franchise_fees','Admin\AccountsController@franchise_fees')->name('franchise_fees');
    Route::get('/franchise_outstanding','Admin\AccountsController@franchise_outstanding')->name('franchise_outstanding');
  });

  Route::group(['middleware'=>'permissions:Payments'],function(){
    //Payments Menu
    Route::resource('payments', 'Admin\PaymentsController');
  });

  Route::group(['middleware'=>'permissions:service_ratings,package_ratings'],function(){
    //rating Routes
    //service rating route
    Route::resource('service-rating','Admin\ServiceratingController');
    //package rating route
    Route::resource('package-rating','Admin\PackageratingController');
  });

  Route::group(['middleware'=>'permissions:testimonial'],function(){
    Route::resource('testimonial','Admin\TestimonialController');
  });

  Route::group(['middleware'=>'permissions:order_review'],function(){
    //order rating Routes
    Route::resource('order-review','Admin\OrdereviewController');

  });



  Route::group(['middleware'=>'permissions:franchise_services'],function(){
    //Franchises Add Service Route
    Route::post('/franchise-subcat','Admin\AjaxController@franchise_subcat')->name('franchise-subcat');
    Route::resource('franchises-service','Admin\FranchisesServiceController');
  });

  Route::group(['middleware'=>'permissions:franchise_packages'],function(){
    //Franchises Add Package Route
    Route::post('/franchise-package-sub','Admin\AjaxController@franchise_package_sub')->name('franchise-package-sub');
    Route::post('/franchise-package-service','Admin\AjaxController@franchise_package_service')->name('franchise-package-service');

    Route::post('franchises-package/media/{id}','Admin\FranchisesPackageController@update_media')->name('franchise.package.edit.media');
    Route::post('franchises-package/add-media','Admin\FranchisesPackageController@add_media')->name('franchise.package.add.media');
    Route::delete('franchises-package/media-destroy/{id}','Admin\FranchisesPackageController@media_destroy')->name('franchise.package.media.destroy');
    Route::resource('franchises-package','Admin\FranchisesPackageController');
  });

  Route::group(['middleware'=>'permissions:franchise_offers'],function(){
    //Franchises Add Offer Route
    Route::post('/franchise-offer-subcat','Admin\AjaxController@franchise_offer_subcat')->name('franchise-offer-subcat');
    Route::post('/franchise-offer-service','Admin\AjaxController@franchise_offer_service')->name('franchise-offer-service');
    Route::resource('/franchises-offer','Admin\FranchisesOfferController');
  });

  Route::group(['middleware'=>'permissions:franchise_timing'],function(){
    //Franchises Add Timing Route
    Route::post('franchises-timing/time','Admin\franchisetimingController@add_time')->name('add.time');
    Route::resource('franchises-timing','Admin\franchisetimingController');
  });

  Route::group(['middleware'=>'permissions:franchise_worker'],function(){
    //Franchises Add worker Route
    Route::resource('franchises-worker','Admin\FranchiseworkerController');
  });

  Route::group(['middleware'=>'permissions:franchise_profile'],function(){
    //Franchises Profile Route
    Route::resource('franchises-profile','Admin\FranchiseprofileController');
    Route::post('/franchise-ajax-country','Admin\AjaxController@franchise_ajax_country')->name('ajax-country-franchise');
    Route::post('/franchise-ajax-state','Admin\AjaxController@franchise_ajax_state')->name('ajax-state-franchise');
  });

  Route::group(['middleware'=>'permissions:franchise_account'],function(){
    //franchises account
    Route::get('/franchises-account','Admin\AccountsController@franchises_account')->name('franchises-account');
  });

    //chnage status(active,inactive)
    Route::post('/toggle-status','Admin\ToggleStatusController@toggle_status')->name('common.toggle-status');

    Route::post('/get-notification','Admin\AjaxController@get_notification')->name('get-notification');
    Route::post('/read-notification','Admin\AjaxController@read_notification')->name('read-notification');


  Route::group(['middleware'=>'permissions:general_settings'],function(){
    // ------------ GLOBAL ----------------------
    Route::post('/general-settings/update/all', 'Admin\GeneralSettingController@generalupdate')->name('admin-gs-update');
    Route::post('/general-settings/update/payment', 'Admin\GeneralSettingController@generalupdatepayment')->name('admin-gs-update-payment');

  });

  Route::group(['middleware'=>'permissions:slider_list'],function(){
    //slider Letter Route
    Route::resource('slider', 'Admin\SliderController');
  });

  Route::group(['middleware'=>'permissions:referral_program'],function(){
    //referral-programs  Route
    Route::resource('referral-program', 'Admin\ReferralprogramController');
  });

  Route::group(['middleware'=>'permissions:about_us'],function(){
    //about us Letter Route
    Route::get('about-ourteam/create','Admin\aboutController@ourteam_create')->name('about.ourteam.create');
    Route::post('about-ourteam/store','Admin\aboutController@ourteam_store')->name('about.ourteam.store');
    Route::get('about-ourteam/edit/{id}','Admin\aboutController@ourteam_edit')->name('about.ourteam.edit');
    Route::post('about-ourteam/update/{id}','Admin\aboutController@ourteam_update')->name('about.ourteam.update');
    Route::delete('about-ourteam/delete/{id}','Admin\aboutController@ourteam_delete')->name('about.ourteam.delete');
    Route::resource('about', 'Admin\aboutController');
  });

  Route::group(['middleware'=>'permissions:blog'],function(){
    //Blog Route
    Route::resource('blog', 'Admin\BlogController');
  });

  Route::group(['middleware'=>'permissions:contact_list'],function(){
    //Contact us Route
    Route::resource('contact', 'Admin\ContactController');
  });

  Route::group(['middleware'=>'permissions:request_list,request_quotes,followups'],function(){
    //Request Quotes Route
    Route::get('/requests/datatables','Admin\RequestController@datatables')->name('admin-request-datatables');
    Route::get('/requests/request_followups','Admin\RequestController@request_followups')->name('admin-request-request_followups');
    Route::resource('request', 'Admin\RequestController');
    ////////////////////////////////
    Route::get('followups',  'Admin\RequestController@followups')->name('request.followups');
    Route::post('followups', 'Admin\RequestController@franchise')->name('request.franchise');
    Route::post('franchise', 'Admin\RequestController@getfranchise')->name('request.franchises');

  });
  //Credit plans
  Route::group(['middleware'=>'permissions:custome_plans'],function(){

    Route::resource('custome-plan', 'Admin\CustomeplanController');

  });

  Route::group(['middleware'=>'permissions:credit_plans'],function(){

    Route::resource('credit_plans', 'Admin\CreditplansController');
    Route::post('manage_credit_plans/set_credit_price', 'Admin\CreditmanageController@set_credit_price')->name('credit_plans.set_credit_price');
  });

  Route::group(['middleware'=>'permissions:franchise_credits'],function(){
    Route::get('franchise_credits', 'Admin\CreditmanageController@franchise_credits')->name('franchise_credits.index');
    Route::get('franchise_credits/create', 'Admin\CreditmanageController@create')->name('franchise_credits.create');
    Route::post('franchise_credits/get_plan_detail', 'Admin\CreditmanageController@get_plan_detail')->name('franchise_credits.get_plan_detail');
    Route::post('franchise_credits/credit_payment', 'Admin\CreditmanageController@credit_payment')->name('franchise_credits.credit_payment');


  });

  Route::group(['middleware'=>'permissions:user'],function(){
    Route::get('/customer/datatables', 'Admin\UsersController@datatables')->name('admin-user-datatables');
    Route::resource('users', 'Admin\UsersController');
  });

    //------------ ADMIN DASHBOARD & PROFILE SECTION ------------
  Route::get('/', 'Admin\DashboardController@index')->name('admin.dashboard');
  Route::get('/profile', 'Admin\DashboardController@profile')->name('admin.profile');
  Route::post('/profile/update', 'Admin\DashboardController@profileupdate')->name('admin.profile.update');
  Route::get('/password', 'Admin\DashboardController@passwordreset')->name('admin.password');
  Route::post('/password/update', 'Admin\DashboardController@changepass')->name('admin.password.update');
  //------------ ADMIN DASHBOARD & PROFILE SECTION ENDS ------------

  //------------ ADMIN GENERAL SETTINGS SECTION ------------

  Route::group(['middleware'=>'permissions:general_settings'],function(){

    Route::get('/general-settings/logo', 'Admin\GeneralSettingController@logo')->name('admin-gs-logo');
    Route::get('/general-settings/favicon', 'Admin\GeneralSettingController@fav')->name('admin-gs-fav');
    Route::get('/general-settings/loader', 'Admin\GeneralSettingController@load')->name('admin-gs-load');
    Route::get('/general-settings/contents', 'Admin\GeneralSettingController@contents')->name('admin-gs-contents');
    Route::get('/general-settings/footer', 'Admin\GeneralSettingController@footer')->name('admin-gs-footer');
    Route::get('/general-settings/affilate', 'Admin\GeneralSettingController@affilate')->name('admin-gs-affilate');
    Route::get('/general-settings/error-banner', 'Admin\GeneralSettingController@errorbanner')->name('admin-gs-error-banner');
    Route::get('/general-settings/popup', 'Admin\GeneralSettingController@popup')->name('admin-gs-popup');
    Route::get('/general-settings/maintenance', 'Admin\GeneralSettingController@maintain')->name('admin-gs-maintenance');
    //------------ ADMIN PICKUP LOACTION ------------

    //------------ ADMIN GENERAL SETTINGS JSON SECTION ------------

    // General Setting Section
    Route::get('/general-settings/home/{status}', 'Admin\GeneralSettingController@ishome')->name('admin-gs-ishome');
    Route::get('/general-settings/disqus/{status}', 'Admin\GeneralSettingController@isdisqus')->name('admin-gs-isdisqus');
    Route::get('/general-settings/loader/{status}', 'Admin\GeneralSettingController@isloader')->name('admin-gs-isloader');
    Route::get('/general-settings/email-verify/{status}', 'Admin\GeneralSettingController@isemailverify')->name('admin-gs-is-email-verify');
    Route::get('/general-settings/popup/{status}', 'Admin\GeneralSettingController@ispopup')->name('admin-gs-ispopup');

    Route::get('/general-settings/admin/loader/{status}', 'Admin\GeneralSettingController@isadminloader')->name('admin-gs-is-admin-loader');
    Route::get('/general-settings/talkto/{status}', 'Admin\GeneralSettingController@talkto')->name('admin-gs-talkto');

    Route::get('/general-settings/multiple/shipping/{status}', 'Admin\GeneralSettingController@mship')->name('admin-gs-mship');
    Route::get('/general-settings/multiple/packaging/{status}', 'Admin\GeneralSettingController@mpackage')->name('admin-gs-mpackage');
    Route::get('/general-settings/security/{status}', 'Admin\GeneralSettingController@issecure')->name('admin-gs-secure');
    Route::get('/general-settings/stock/{status}', 'Admin\GeneralSettingController@stock')->name('admin-gs-stock');
    Route::get('/general-settings/maintain/{status}', 'Admin\GeneralSettingController@ismaintain')->name('admin-gs-maintain');
    //  Affilte Section

    Route::get('/general-settings/affilate/{status}', 'Admin\GeneralSettingController@isaffilate')->name('admin-gs-isaffilate');

    //  Capcha Section

    Route::get('/general-settings/capcha/{status}', 'Admin\GeneralSettingController@iscapcha')->name('admin-gs-iscapcha');


    //------------ ADMIN GENERAL SETTINGS JSON SECTION ENDS------------




  });

  //------------ ADMIN GENERAL SETTINGS SECTION ENDS ------------


    Route::group(['middleware'=>'permissions:super','middleware'=>'permissions:clear_cache'],function(){



    Route::get('/cache/clear', function() {
      Artisan::call('cache:clear');
      Artisan::call('config:clear');
      Artisan::call('route:clear');
      Artisan::call('view:clear');
      return redirect()->route('admin.dashboard')->with('cache','System Cache Has Been Removed.');
    })->name('admin-cache-clear');


    Route::group(['middleware'=>'permissions:roles'],function(){
    // ------------ ROLE SECTION ----------------------
      Route::get('/role/datatables', 'Admin\RoleController@datatables')->name('admin-role-datatables');
      Route::get('/role', 'Admin\RoleController@index')->name('admin-role-index');
      Route::get('/role/create', 'Admin\RoleController@create')->name('admin-role-create');
      Route::post('/role/create', 'Admin\RoleController@store')->name('admin-role-store');
      Route::get('/role/edit/{id}', 'Admin\RoleController@edit')->name('admin-role-edit');
      Route::post('/role/edit/{id}', 'Admin\RoleController@update')->name('admin-role-update');
      Route::get('/role/delete/{id}', 'Admin\RoleController@destroy')->name('admin-role-delete');

    });

    // ------------ ROLE SECTION ENDS ----------------------


  });

  //------------ ADMIN STAFF SECTION ------------

  Route::group(['middleware'=>'permissions:manage_staffs'],function(){

    Route::get('/staff/datatables', 'Admin\StaffController@datatables')->name('admin-staff-datatables');
    Route::get('/staff', 'Admin\StaffController@index')->name('admin-staff-index');
    Route::get('/staff/create', 'Admin\StaffController@create')->name('admin-staff-create');
    Route::post('/staff/create', 'Admin\StaffController@store')->name('admin-staff-store');
    Route::get('/staff/edit/{id}', 'Admin\StaffController@edit')->name('admin-staff-edit');
    Route::post('/staff/update/{id}', 'Admin\StaffController@update')->name('admin-staff-update');
    Route::get('/staff/show/{id}', 'Admin\StaffController@show')->name('admin-staff-show');
    Route::get('/staff/delete/{id}', 'Admin\StaffController@destroy')->name('admin-staff-delete');

  });

  //------------ ADMIN STAFF SECTION ENDS------------


  Route::group(['middleware'=>'permissions:products'],function(){

    Route::get('/products/datatables', 'Admin\ProductController@datatables')->name('admin-prod-datatables'); //JSON REQUEST
    Route::get('/products', 'Admin\ProductController@index')->name('admin-prod-index');

    Route::post('/products/upload/update/{id}', 'Admin\ProductController@uploadUpdate')->name('admin-prod-upload-update');

    Route::get('/products/deactive/datatables', 'Admin\ProductController@deactivedatatables')->name('admin-prod-deactive-datatables'); //JSON REQUEST
    Route::get('/products/deactive', 'Admin\ProductController@deactive')->name('admin-prod-deactive');


    Route::get('/products/catalogs/datatables', 'Admin\ProductController@catalogdatatables')->name('admin-prod-catalog-datatables'); //JSON REQUEST
    Route::get('/products/catalogs/', 'Admin\ProductController@catalogs')->name('admin-prod-catalog-index');

    // CREATE SECTION
    Route::get('/products/types', 'Admin\ProductController@types')->name('admin-prod-types');
    Route::get('/products/physical/create', 'Admin\ProductController@createPhysical')->name('admin-prod-physical-create');
    Route::get('/products/digital/create', 'Admin\ProductController@createDigital')->name('admin-prod-digital-create');
    Route::get('/products/license/create', 'Admin\ProductController@createLicense')->name('admin-prod-license-create');
    Route::post('/products/store', 'Admin\ProductController@store')->name('admin-prod-store');
    Route::get('/getattributes', 'Admin\ProductController@getAttributes')->name('admin-prod-getattributes');
    // CREATE SECTION

      // EDIT SECTION
    Route::get('/products/edit/{id}', 'Admin\ProductController@edit')->name('admin-prod-edit');
    Route::post('/products/edit/{id}', 'Admin\ProductController@update')->name('admin-prod-update');
    // EDIT SECTION ENDS



    // DELETE SECTION
    Route::get('/products/delete/{id}', 'Admin\ProductController@destroy')->name('admin-prod-delete');
    // DELETE SECTION ENDS


    Route::get('/products/catalog/{id1}/{id2}', 'Admin\ProductController@catalog')->name('admin-prod-catalog');
    //------------ ADMIN PRODUCT SECTION ENDS------------

  });

}) ;


// ************************************ WORKER SECTION **********************************************
Route::prefix('worker')->group(function() {

    Route::get('/login', 'Worker\LoginController@showLoginForm')->name('worker.login');
    Route::post('/login', 'Worker\LoginController@login')->name('worker.login.submit');
    Route::get('/logout', 'Worker\LoginController@logout')->name('worker.logout');

    Route::get('/forgot', 'Worker\LoginController@showForgotForm')->name('worker.forgot');
    Route::post('/forgot', 'Worker\LoginController@forgot')->name('worker.forgot.submit');

    Route::get('/reset-password/{token}', 'Worker\ResetPasswordController@getPassword');
    Route::post('/reset-password', 'Worker\ResetPasswordController@updatePassword')->name('worker.reset.submit');


    //------------ WORKER DASHBOARD & PROFILE SECTION ------------
    Route::get('/', 'Worker\DashboardController@index')->name('worker.dashboard');
    Route::get('/profile', 'Worker\DashboardController@profile')->name('worker.profile');
    Route::post('/profile/update', 'Worker\DashboardController@profileupdate')->name('worker.profile.update');
    Route::get('/password', 'Worker\DashboardController@passwordreset')->name('worker.password');
    Route::post('/password/update', 'Worker\DashboardController@changepass')->name('worker.password.update');
    //------------ WORKER DASHBOARD & PROFILE SECTION ENDS ------------


    Route::post('/get-notification','Worker\AjaxController@get_notification')->name('worker.get-notification');
    Route::post('/read-notification','Worker\AjaxController@read_notification')->name('worker.read-notification');

    Route::get('/my-order','Worker\OrdersController@index')->name('worker.orders');
    Route::get('/orders/datatables', 'Worker\OrdersController@datatables')->name('worker-order-datatables');
    Route::get('/orders-details/{id}','Worker\OrdersController@show_orders')->name('worker.orders-details');
    Route::post('/worker-extra_payment','Worker\OrdersController@extra_payment')->name('worker.extra-payment');

    Route::post('/orders-status','Worker\OrdersController@orders_status')->name('worker.orders-status');

});
// ************************************ WORKER SECTION **********************************************




   // ************************************ FRONT SECTION **********************************************


   Route::prefix('user')->middleware('auth:web')->group(function() {
        // User Dashboard
        Route::get('/dashboard', 'Users\UserController@index')->name('user-dashboard');

        Route::get('/logout', 'Users\UserController@logout')->name('user-logout');

        Route::get('/mycart', 'Front\FrontendController@mycart')->name('mycart');


        // To apply promo code
        Route::post('/apply_offer', 'Front\FrontendController@apply_offer')->name('user.apply_offer');

        // To add final price and offer in session
        Route::post('/add_final_price', 'Front\FrontendController@add_final_price')->name('user.add_final_price');

        Route::get('/address', 'Front\FrontendController@address')->name('user.address');

        // Payment page of order
        Route::get('/payment_method', 'Front\FrontendController@payment_method')->name('user.payment_method');

        // Order detail page
        Route::get('/order_details/{order_id}', 'Front\FrontendController@order_details')->name('user.order_details');


        Route::get('/orders', 'Front\FrontendController@orders')->name('user-orders');
        Route::get('/ongoingorders', 'Front\FrontendController@ongoingorders')->name('user-ongoingorders');
        Route::get('/user_profile', 'Front\FrontendController@user_profile')->name('user-profile');
        Route::post('/user_profile_edit', 'Users\UserController@user_profile_edit')->name('user_profile_edit');

        Route::get('/resetform', 'Users\UserController@resetform')->name('resetform');
        Route::post('/reset', 'Users\UserController@reset')->name('reset');

        Route::get('/order_track', 'Front\FrontendController@order_track')->name('user-order-track');
        Route::post('/get_order_track', 'Front\FrontendController@get_order_track')->name('user-get-order-track');


   });
   Route::get('/', 'Front\FrontendController@index')->name('front.index');



   // ************************************ Dharmesh START**********************************************
   // To set user location in session
   Route::post('/set_location_session', 'Front\FrontendController@set_location_session')->name('location.set_location_session');

   Route::get('/about','Front\FrontendController@about')->name('front.about');
   Route::get('/Register-as-Professional','Front\FrontendController@registerProfessional')->name('front.registerprofessional');
   Route::get('/Registerform/{country}/{state}/{city}', 'Front\FrontendController@register')->name('Register');
   Route::get('/area-category','Front\FrontendController@areaCategory')->name('front.areaCategory');
   Route::get('/gifts','Front\FrontendController@gifts')->name('front.gifts');
   Route::post('/add_cart_detail', 'Front\FrontendController@add_cart_detail')->name('add_cart_detail');

   // front Blog Routes
   Route::get('/blog', 'Front\FrontendController@blog')->name('front.blog');
   Route::get('/blog-view/{id}', 'Front\FrontendController@blog_view')->name('front.blog.view');
   Route::get('/blog-tag/{id}', 'Front\FrontendController@blog_tag')->name('front.blog.tag');
   Route::get('/blog-category/{id}', 'Front\FrontendController@blog_category')->name('front.blog.category');



   // Route::resource('userLogin', 'Front\UsersController');
   Route::post('/getState', 'Front\FrontendController@getState')->name('getState');
   Route::post('/getCity', 'Front\FrontendController@getCity')->name('getCity');
   Route::post('/registerprofessional','Front\FrontendController@addProfessionalUser')->name('registerprofessional');
   Route::post('/package', 'Front\FrontendController@showPackage')->name('package');
   Route::post('/view_package', 'Front\FrontendController@viewpackage')->name('view_package');
   Route::post('/userRegister','Front\UsersController@store')->name('userRegister');
   Route::post('/userLogin','Front\UsersController@login')->name('userLogin');
   Route::post('/userOtpLogin','Front\UsersController@userOtpLogin')->name('userOtpLogin');
   Route::post('/verify_mobile','Front\UsersController@verify_mobile')->name('verify_mobile');
   Route::post('/send_otp','Front\UsersController@send_otp')->name('send_otp');
   // Route::get('/serviceList/{cat_slug}/{sub_cat_slug}', 'Front\FrontendController@serviceList')->name('serviceList');
   Route::get('/serviceList/{cat_slug}', 'Front\FrontendController@serviceList')->name('serviceList');
   Route::post('/get_service_detail', 'Front\AjaxController@get_service_detail')->name('get-service-detail');

   Route::get('/serviceList/{cat_slug}/{sub_cat_slug}', 'Front\FrontendController@serviceList')->name('serviceList');


   // To create session for cart items
   Route::post('/create_cart_session', 'Front\FrontendController@create_cart_session');

   // To save user addressess
   Route::post('/save_user_address', 'Front\FrontendController@save_user_address')->name('user.save_user_address');

   // To save user address and time slot of service
   Route::post('/save_address_time_slot', 'Front\FrontendController@save_address_time_slot')->name('user.save_address_time_slot');



   // To place order
   Route::post('/place_order', 'Front\FrontendController@place_order')->name('user.place_order');


   Route::post('/send_review','Front\FrontendController@send_review')->name('send_review');

   Route::post('/cancel_order/{order_id}', 'Front\FrontendController@cancel_order')->name('cancel_order');

   // To set user location in session
   Route::post('/set_location_session', 'Front\FrontendController@set_location_session')->name('location.set_location_session');

   // Razorpay
   Route::post('/razorpaypayment', 'Front\RazorpayController@payment')->name('payment');

   //Request a Quote
   Route::post('/request_a_quote', 'Front\FrontendController@request_a_quote')->name('front.request_a_quote');
   Route::post('/service_request', 'Front\FrontendController@service_request')->name('front.service_request');

   Route::post('/ajax_state_from_country', 'Front\AjaxController@ajax_state_from_country')->name('ajax_state_from_country');
   Route::post('/ajax_city_from_state', 'Front\AjaxController@ajax_city_from_state')->name('ajax_city_from_state');

   Route::post('/subscribe_form', 'Front\FrontendController@subscribe_form')->name('subscribe_form');

   Route::post('/refer_and_earn', 'Front\FrontendController@refer_and_earn')->name('refer_and_earn');

   Route::get('/contact_us','Front\FrontendController@contact_us')->name('front.contact_us');
   Route::post('/contact_us_save', 'Front\FrontendController@contact_us_save')->name('contact_us_save');

   Route::get('/payment_link', 'Front\RazorpayController@payment_link')->name('payment_link');
   Route::post('/payment_link_post', 'Front\RazorpayController@payment_link_post')->name('payment_link_post');
   Route::get('/payment_success', 'Front\RazorpayController@payment_success')->name('payment_success');

   Route::post('/remove_item_from_cart', 'Front\FrontendController@remove_item_from_cart')->name('remove_item_from_cart');


   Route::get('/service_search', 'Front\FrontendController@service_search')->name('front.service_search');


   Route::get('/terms-and-conditions','Front\FrontendController@terms_and_conditions')->name('front.terms-and-conditions');
   Route::get('/return-refund-policy','Front\FrontendController@return_refund_policy')->name('front.return-refund-policy');
   Route::get('/privacy-policy','Front\FrontendController@privacy_policy')->name('front.privacy-policy');
   Route::get('/eula','Front\FrontendController@eula')->name('front.eula');
   Route::get('/disclaimer','Front\FrontendController@disclaimer')->name('front.disclaimer');
   Route::get('/cookie-policy','Front\FrontendController@cookie_policy')->name('front.cookie-policy');

   // ************************************ Dharmesh ENDS**********************************************

   Route::get('/extras', 'Front\FrontendController@extraIndex')->name('front.extraIndex');

   Route::get('/order_status_cron', 'Front\CronController@order_status_cron')->name('front.order_status_cron');




