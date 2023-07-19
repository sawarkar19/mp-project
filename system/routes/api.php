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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/


Route::group(['prefix' => 'v1', 'namespace' => 'Api\v1'], function () {
    Route::get('WHATSAPP_MESSAGE_API/send', 'WhatsappApiController@sendApiMsg');
    Route::post('WHATSAPP_MESSAGE_API/send', 'WhatsappApiController@sendApiMsg');
    Route::post('message/send', 'WhatsappApiController@sendDocumentApiMsg');
    Route::post('user/create', 'WhatsappApiController@registerEnterpriseUser');
});

Route::group(['prefix' => 'employee/v1', 'namespace' => 'Api\v1\App'], function () {
    // for employee app
    Route::post('login', 'EmployeeMobileApp@login');
    Route::post('send-otp', 'EmployeeMobileApp@sendOtp');
    Route::post('verify-otp', 'EmployeeMobileApp@verifyOtp');
    Route::post('reset-password', 'EmployeeMobileApp@resetPassword');
    Route::post('change-password', 'EmployeeMobileApp@changePassword');
    Route::get('/get-profile/{userid}', 'EmployeeMobileApp@getProfileData');
    Route::post('update-profile', 'EmployeeMobileApp@updateProfileData');
    Route::get('/get-offers/{userid}', 'EmployeeMobileApp@getOffers');
    Route::get('/get-active-offers/{userid}', 'EmployeeMobileApp@getActiveOffers');
    Route::get('/get-expired-offers/{userid}', 'EmployeeMobileApp@getExpiredOffers');
    Route::get('/get-offer/{offerid}', 'EmployeeMobileApp@getOffer');
    Route::post('get-default-offer', 'EmployeeMobileApp@getDefaultOffer');
    Route::post('redeem-offers', 'EmployeeMobileApp@redeemOffer');
    Route::post('proceed-redeem', 'EmployeeMobileApp@proceedRedeem');
    Route::post('share-to-customer', 'EmployeeMobileApp@shareToCustomer');
});