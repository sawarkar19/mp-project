<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Wacloud Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::name('wacloud.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    });

    Route::group(['middleware' => ['auth'], ['wacloud']], function () {
        Route::get('dashboard', 'DashboardController@dashboard')->name('dashboard');

        /*User Profile Page start*/
        Route::get('/profile', 'ProfileController@profileSettings')->name('profileSettings');
        Route::post('/user-profile-update', 'ProfileController@profileUpdate')->name('profileUpdate');
        Route::post('/user-number-update', 'ProfileController@numberUpdate')->name('numberUpdate');
        Route::post('/user-verify-update', 'ProfileController@verifyUpdate')->name('verifyUpdate');
        /*User Profile Page end*/
    });
});
