<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Designer Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::name('designer.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    });

    Route::group(['middleware' => ['auth'], ['designer']], function () {
        Route::get('dashboard', 'DashboardController@dashboard')->name('dashboard');

        /*User Profile Page start*/
        Route::get('/profile', 'ProfileController@profileSettings')->name('profileSettings');
        Route::post('/user-profile-update', 'ProfileController@profileUpdate')->name('profileUpdate');
        Route::post('/user-number-update', 'ProfileController@numberUpdate')->name('numberUpdate');
        Route::post('/user-verify-update', 'ProfileController@verifyUpdate')->name('verifyUpdate');
        /*User Profile Page end*/

        /*templates start*/
        Route::resource('templates', 'TemplateController');
        Route::post('/templates/destroys', 'TemplateController@destroys')->name('templates.destroys');
        /*templates end*/

        /*gallery images start*/
        Route::resource('galleryimages', 'GalleryImageController')->except('destroy');
        Route::post('/galleryimage/destroy-page/{id}', 'GalleryImageController@destroyPage')->name('galleryimage.destroyPage');
        /*gallery image end*/

        /*Content template start*/
        Route::resource('contents', 'ContentController')->except('destroy');
        Route::post('/content/destroy-page/{id}', 'ContentController@destroyPage')->name('content.destroyPage');
        /*Content template end*/

        /*template button start*/
        Route::resource('templatebuttons', 'TemplateButtonController')->except('destroy');
        Route::post('/templatebutton/destroy-page/{id}', 'TemplateButtonController@destroyPage')->name('templatebutton.destroyPage');
        /*template button end*/

        /* Business Vcard start */
        Route::resource('vcards', 'BusinessVcardController');
        Route::post('/vcards/destroys', 'BusinessVcardController@destroys')->name('vcards.destroys');
        /* Business Vcard end */
    });
});
