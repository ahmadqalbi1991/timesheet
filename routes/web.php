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
Route::get('/clear', function() {
    \Artisan::call('optimize');
    \Artisan::call('optimize:clear');
    \Artisan::call('cache:clear');
    \Artisan::call('config:clear');
    \Artisan::call('config:cache');
    \Artisan::call('view:clear');
    \Artisan::call('config:clear');
   dd('cleared');
});
Route::get('/', function () {
    return view('welcome');
});
Route::get('/access-restricted', 'Admin\AuthController@access_restricted')->name('admin.access_restricted');
Route::get('/admin', 'Admin\AuthController@login')->name('admin.login');
Route::post('admin/check_login', 'Admin\AuthController@check_login')->name('admin.check_login');
Route::get('/admin/logout', 'Admin\AuthController@logout')->name('admin.logout');


// socail login page
Route::get('/login', 'User\SocailLoginController@userLogin')->name('user.login');

//Customer Reset Password
Route::get('/resetPassword/{token}', 'User\AuthController@reset_password')->name('user.reset.password');

Route::post('/setPassword', 'User\AuthController@set_password')->name('user.password_set');




//Google
Route::get('/login/google', [App\Http\Controllers\User\SocailLoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/login/google/callback', [App\Http\Controllers\User\SocailLoginController::class, 'handleGoogleCallback']);
//Facebook
// Route::get('/login/facebook', [App\Http\Controllers\User\SocailLoginController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('/login/facebook/callback', [App\Http\Controllers\User\SocailLoginController::class, 'handleFacebookCallback']);
//apple
Route::get('/login/apple', [App\Http\Controllers\User\SocailLoginController::class, 'redirectToApple'])->name('login.apple');
Route::get('/login/apple/callback', [App\Http\Controllers\User\SocailLoginController::class, 'handleAppleCallback']);