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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('Api\v1')->prefix("v1")->name("api.v1.")->group(function(){

    //basic
    Route::post('country_list','BasicController@country_list')->name('country_list');
    Route::post('city_list','BasicController@city_list')->name('city_list');
    Route::post('deligate_list','BasicController@deligate_list')->name('deligate_list');
    Route::post('truck_list','BasicController@truck_list')->name('truck_list');
    Route::post('truck_detail','BasicController@truck_detail')->name('truck_detail');
    Route::post('company_list','BasicController@company_list')->name('company_list');
    Route::post('account_types','BasicController@account_types')->name('account_types');
    Route::post('language_list','BasicController@language_list')->name('language_list');
    Route::post('activity_list','BasicController@activity_list')->name('activity_list');
    Route::post('container_list','BasicController@containerList')->name('container_list');
    Route::get('settings','BasicController@settings')->name('settings');
    
    Route::get('dial_codes','BasicController@dial_codes')->name('dial_codes');
    
    
    Route::post('customer/register','AuthController@customer_register')->name('customer.register');

    Route::post('driver/register','AuthController@driver_register')->name('driver.register');
    
    Route::post('verifyotp','AuthController@verifyOtp')->name('verifyotp');
    Route::post('resend_signup_otp','AuthController@resendSignupotp')->name('resend_signup_otp');
    

    Route::post('verify_otp','AuthController@verify_otp')->name('verify_otp');
    Route::post('resend_otp','AuthController@resend_otp')->name('resend_otp');

    Route::post('change_number','AuthController@change_number')->name('change_number');
    Route::post('user_image_submit','AuthController@user_image_submit')->name('user_image_submit');

    //Login
    Route::post('/login', 'AuthController@signIn')->name('signIn');
    Route::post('/social_login', 'AuthController@socialLogin')->name('social_login');
    
    Route::post('/social_media_login', 'AuthController@social_media_login')->name('social_media_login');
    Route::post('/forgot_password_api', 'AuthController@forgot_password_api')->name('forgot_password_api');
    Route::post('/reset_password_api', 'AuthController@reset_password_api')->name('reset_password_api');
    Route::post('/change_password','UserController@change_password')->name('change_password_api');

    // Driver Login
    Route::post('/driver_login', 'AuthController@driver_signIn')->name('driver.signIn');

    Route::post('logout', 'AuthController@logout')->name('logout');

    Route::post('login_with_phone','AuthController@login_with_phone')->name('login_with_phone');
    Route::post('verify_login_otp','AuthController@verify_login_otp')->name('verify_login_otp');

    Route::post('bookings/store','Customer\BookingController@store')->name('bookings.store');

    Route::get('bookings/qoutes/{id}','Customer\BookingController@qoutes')->name('bookings.qoutes');

    Route::post('bookings/approve_qoute/{id}','Customer\BookingController@approve_qoute')->name('bookings.approve.qoutes');
    

    //

    //Addresses

    Route::post('get_address_list','AddressController@get_address_list')->name('get_address_list');
    Route::post('get_single_address','AddressController@get_single_address')->name('get_single_address');
    Route::post('add_address','AddressController@add_address')->name('add_address');
    Route::post('update_address','AddressController@update_address')->name('update_address');
    Route::post('delete_address','AddressController@delete_address')->name('delete_address');
    
    
    // Truck Shipping

    Route::post('deligates_list','TruckShippingController@deligates_list')->name('deligate.list');
    
    //FTL
    Route::post('ftl_booking_create','TruckShippingController@ftl_booking_create')->name('ftl.booking.create');
    Route::post('ftl_add_truck','TruckShippingController@ftl_add_truck')->name('ftl.add.truck');
    Route::post('ftl_remove_truck','TruckShippingController@ftl_remove_truck')->name('ftl.remove.truck');
    Route::post('ftl_get_selected_trucks','TruckShippingController@ftl_get_selected_trucks')->name('ftl.get.selected.trucks');
    Route::post('ftl_booking_checkout','TruckShippingController@ftl_booking_checkout')->name('ftl.booking.checkout');
    Route::post('ftl_place_booking','TruckShippingController@ftl_place_booking')->name('ftl.place.booking');
    Route::post('ftl_booking_checkout','TruckShippingController@ftl_booking_checkout')->name('ftl.booking.checkout');
    Route::post('ftl_get_cart','TruckShippingController@ftl_get_cart')->name('ftl.get.cart');
    Route::post('booking_change_address','TruckShippingController@booking_change_address')->name('booking_change_address');
    
    //LTL
    Route::post('ltl_booking_create','TruckShippingController@ltl_booking_create')->name('ltl.booking.create');
    Route::post('ltl_get_cart','TruckShippingController@ltl_get_cart')->name('ltl.get.cart');
    Route::post('ltl_booking_checkout','TruckShippingController@ltl_booking_checkout')->name('ltl.booking.checkout');
    Route::post('ltl_place_booking','TruckShippingController@ltl_place_booking')->name('ltl.place.booking');
    //Route::post('create_ftl_booking','TruckShippingController@create_ftl_booking')->name('create.ftl.booking');
   
    
    //Air Freight 
    Route::post('shipmenttypes','AirFreightController@shipmenttypes')->name('shipmenttypes');
    Route::post('airfreight_booking_create','AirFreightController@airfreight_booking_create')->name('airfreight.booking.create');
    Route::post('airfreight_get_cart','AirFreightController@airfreight_get_cart')->name('airfreight.get.cart');
    Route::post('airfreight_booking_checkout','AirFreightController@airfreight_booking_checkout')->name('airfreight.booking.checkout');
    Route::post('airfreight_place_booking','AirFreightController@airfreight_place_booking')->name('airfreight.place.booking');

    //Sea Freight
    Route::post('ftl_seafreight_booking_create','SeaFreightController@ftl_seafreight_booking_create')->name('ftl.seafreight.booking.create');
    Route::post('ftl_seafright_add_truck','SeaFreightController@ftl_add_truck')->name('seafright.ftl.add.truck');
    Route::post('ftl_seafright_booking_checkout','SeaFreightController@ftl_booking_checkout')->name('seafright.ftl.booking.checkout');
    Route::post('ftl_seafright_place_booking','SeaFreightController@ftl_place_booking')->name('seafright.ftl.place.booking');
    Route::post('ftl_seafright_remove_truck','SeaFreightController@ftl_remove_truck')->name('seafright.ftl.remove.truck');

    Route::post('ltl_seafreight_booking_create','SeaFreightController@ltl_booking_create')->name('seafright.ltl.booking.create');
    Route::post('ltl_seafreight_get_cart','SeaFreightController@ltl_get_cart')->name('seafright.ltl.get.cart');
    Route::post('ltl_seafreight_booking_checkout','SeaFreightController@ltl_booking_checkout')->name('seafright.ltl.booking.checkout');
    Route::post('ltl_seafreight_place_booking','SeaFreightController@ltl_place_booking')->name('seafright.ltl.place.booking');


   

    //Storage Types
    Route::post('get_storage_types','StorageTypeController@get_storage_types')->name('get_storage_types');
    
    //Warehousing
    Route::post('warehousing_booking_create','WarehousingController@warehousing_booking_create')->name('warehousing.booking.create');
    Route::post('warehousing_get_cart','WarehousingController@warehousing_get_cart')->name('warehousing_get_cart');
    Route::post('warehousing_booking_checkout','WarehousingController@warehousing_booking_checkout')->name('warehousing.booking.checkout');
    Route::post('warehousing_place_booking','WarehousingController@warehousing_place_booking')->name('warehousing.place.booking');

    //Customer My Request 
    Route::post('customer_requests','CustomerBookingController@customer_requests')->name('customer.requests');
    Route::post('customer_request_detail','CustomerBookingController@customer_request_detail')->name('customer.request.detail');
    Route::post('customer_accept_quote','CustomerBookingController@customer_accept_quote')->name('customer.accept.quote');
    Route::post('customer_accept_all_quotes','CustomerBookingController@customer_accept_all_quotes')->name('customer.accept.all.quotes');
    Route::post('customer_track_shipment','CustomerBookingController@customer_track_shipment')->name('customer.track.shipment');

    Route::post('customer_submit_review','CustomerBookingController@customer_submit_review')->name('customer.submit.review');

    Route::post('grant_admin_to_accept_quote','CustomerBookingController@grantAdminAcceptQuote')->name('customer.grant_admin_to_accept_quote');
    
    //Profile
    Route::post('customer_edit_profile','CustomerProfileController@customer_edit_profile')->name('customer.edit.profile');
    Route::post('customer_update_profile','CustomerProfileController@customer_update_profile')->name('customer.update.profile');


    //Driver APIS
    Route::post('driver_pending_requests','DriverBookingController@driver_pending_requests')->name('driver.pending.requests');
    Route::post('driver_accepted_requests','DriverBookingController@driver_accepted_requests')->name('driver.accepted.requests');
    Route::post('driver_completed_requests','DriverBookingController@driver_completed_requests')->name('driver.completed.requests');
    Route::post('driver_request_detail','DriverBookingController@driver_request_detail')->name('driver.request.detail');
    Route::post('driver_submit_quote','DriverBookingController@driver_submit_quote')->name('driver.submit.quote');
    Route::post('change_request_status','DriverBookingController@change_request_status')->name('change.request.status');
    Route::post('deliver_now','DriverBookingController@deliver_now')->name('deliver_now');
    Route::post('driver_edit_profile','DriverBookingController@driver_edit_profile')->name('driver.edit.profile');
    Route::post('driver_update_profile','DriverBookingController@driver_update_profile')->name('driver.update_profile');
    
    Route::post('driver_phone_by_country','DriverController@phoneByCountry')->name('driver.driver_phone_by_country');
    Route::post('driver/add_additional_number','DriverController@addAdditionalNumber')->name('driver.add_additional_number');
    Route::post('driver/verify_additional_number','DriverController@verifyAdditionalPhoneOtp')->name('driver.verify_additional_number');
    Route::post('driver/delete_additional_number','DriverController@deleteAdditionalPhone')->name('driver.delete_additional_number');

    Route::post('driver/add_advance_amount','DriverBookingController@addAdvanceAmount')->name('driver.add_advance_amount');
    Route::post('driver/add_expenses','DriverBookingController@addExpenses')->name('driver.add_expenses');
    Route::post('driver/extra_category_list','DriverBookingController@extraCategoryList')->name('driver.extra_category_list');

    //CMS Apis
    Route::post('get_all_pages','CMSController@get_all_pages')->name('get.all.pages');
    Route::post('get_single_page','CMSController@get_single_page')->name('get.single.page');

    Route::post('faqs','CMSController@faqs')->name('faqs');

    Route::post('submit_help','CMSController@helpRequest')->name('submit_help');

});



//Facebook
Route::get('/login/facebook', [App\Http\Controllers\Api\v1\AuthController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('/login/facebook/callback', [App\Http\Controllers\Api\v1\AuthController::class, 'handleFacebookCallback']);
