<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Support Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::name('support.')->group(function () {
	Route::get('/', function () { return redirect()->route('login'); });

	Route::group(['middleware' => ['auth'],['support']], function() {

		Route::get('dashboard','DashboardController@dashboard')->name('dashboard');

		/*User Profile Page start*/
		Route::get('/profile','ProfileController@profileSettings')->name('profileSettings');
		Route::post('/user-profile-update','ProfileController@profileUpdate')->name('profileUpdate');
		Route::post('/user-number-update','ProfileController@numberUpdate')->name('numberUpdate');
		Route::post('/user-verify-update','ProfileController@verifyUpdate')->name('verifyUpdate');
        /*User Profile Page end*/

		/*Users start*/
		Route::get('/userList','UserController@user')->name('userList');
		Route::get('/userTransaction/{id}','PlanController@planHistory')->name('userTransaction');
		Route::get('/viewTransactionHistory/{id}','PlanController@viewTransactionHistory')->name('viewTransactionHistory');
		Route::get('/viewTransactionInvoice/{id}','PlanController@viewTransactionInvoice')->name('viewTransactionInvoice');
		Route::get('/downloadTransactionHistory/{id}','PlanController@downloadTransactionHistory')->name('downloadTransactionHistory');
		Route::get('/export-users', 'PlanController@exportUsers')->name('exportUsers');

		/*Users end*/
		
		/* Reports Start */
		Route::get('/userReport/{id}','ReportController@index')->name('userReport');
		Route::get('get-redeems', 'ReportController@getRedeems')->name('getRedeems');
		Route::get('get-subscriptions', 'ReportController@getSubscriptions')->name('getSubscriptions');
		Route::get('get-messages', 'ReportController@getMessages')->name('getMessages');
		Route::get('get-deductions', 'ReportController@getDeductions')->name('getDeductions');
		Route::get('get-social-impact', 'ReportController@getSocialImpact')->name('getSocialImpact');
		/* Reports End */


		
	});
});