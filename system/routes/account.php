<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Account Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::name('account.')->group(function () {
	Route::get('/', function () { return redirect()->route('login'); });

	Route::group(['middleware' => ['auth'],['account']], function() {

		Route::get('dashboard','DashboardController@dashboard')->name('dashboard');

		/*Setting Page*/
		Route::get('/payment-geteway','SettingController@settings')->name('settings');

		/*User Profile Page start*/
		Route::get('/profile','ProfileController@profileSettings')->name('profileSettings');
		Route::post('/user-profile-update','ProfileController@profileUpdate')->name('profileUpdate');
		Route::post('/user-number-update','ProfileController@numberUpdate')->name('numberUpdate');
		Route::post('/user-verify-update','ProfileController@verifyUpdate')->name('verifyUpdate');
        /*User Profile Page end*/

		/*Coupons Page*/
		Route::get('/coupons','CouponsController@coupons')->name('coupons');

		/*User Page*/
		Route::get('/user','UserController@user')->name('user');
		Route::get('/user/{id}','UserController@userShow')->name('userShow');
		Route::get('/history/{user_id}','UserController@planHistory')->name('planHistory');
		Route::get('/view-history/{id}','UserController@viewHistory')->name('viewHistory');
		Route::get('/download-history/{id}','UserController@downloadHistory')->name('downloadHistory');
		Route::get('/view-invoice/{id}','UserController@viewInvoice')->name('viewInvoice');

		/*User credit payment Page*/
		Route::get('/user-credit-payment','UserCreditPaymentController@userCreditPayment')->name('userCreditPayment');
		Route::get('/user-credit-payment/{id}','UserCreditPaymentController@creditPayment')->name('creditPayment');
		Route::post('/set-plan-data-payment', 'UserCreditPaymentController@setPlanData')->name('setPlanData');
		Route::get('/checkout-payment', 'UserCreditPaymentController@checkoutSubscription')->name('checkout');
		Route::post('/sucess-payment', 'UserCreditPaymentController@SucessPayment')->name('SucessPayment');

		/*report Page*/
		Route::get('/report','ReportController@report')->name('report');
		Route::get('/export-report','ReportController@exportReportList')->name('exportReport');

		/*graph data start */
		Route::get('get-last-7-days','GraphController@getLast7days')->name('getLast7days');
		Route::get('last-7-days','GraphController@last7days')->name('last7days');
		Route::get('last-month','GraphController@lastMonth')->name('lastMonth');
		Route::get('this-month','GraphController@thisMonth')->name('thisMonth');
		Route::get('last-12-month','GraphController@lastTwelveMonth')->name('lastTwelveMonth');
		Route::get('get-graph-data','GraphController@getGraphData')->name('getGraphData');
        /*graph data end */
		
	});
});