<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Employee Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::name('employee.')->group(function () {

	Route::get('/', function () { return redirect()->route('login'); });

	Route::group(['middleware' => ['auth'],['employee']], function() {

		Route::get('dashboard','DashboardController@index')->name('dashboard');
		Route::get('/thank-you','DashboardController@thankYou')->name('payment.thankYou');

		Route::get('/profile','ProfileController@settings')->name('profile.settings');
		Route::post('/user_profile_update','ProfileController@profile_update')->name('profile.update');
		Route::post('/user_address_update','ProfileController@profile_address')->name('address.update');

		Route::get('share-links', 'ShareLinkController@index')->name('shareLinks');
		Route::post('share-links/share-offer', 'ShareLinkController@shareOffer')->name('shareOffer');
		Route::post('share-links/customer-info', 'ShareLinkController@customerInfo')->name('customerInfo');
		Route::post('share-links/apply-redeem-code', 'ShareLinkController@applyRedeemCode')->name('applyRedeemCode');
		Route::post('share-links/redeem-offer', 'ShareLinkController@redeemOffer')->name('redeemOffer');
		
	});
});