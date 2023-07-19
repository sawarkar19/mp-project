<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::name('seomanager.')->group(function () {
	Route::get('/', function () { return redirect()->route('login'); });

	Route::group(['middleware' => ['auth'],['seomanager']], function() {
		Route::get('dashboard','DashboardController@dashboard')->name('dashboard');

		

		//seo route start
		Route::resource('seo','SeoController');
		//seo route start

        // blog routes start
		Route::resource('blog','BlogController');
		Route::post('/blog-update/{id}', 'BlogController@update')->name('blog.BUpdate');
		Route::post('/blogs/destroy','BlogController@destroy')->name('blogs.destroys');
		Route::post('blogs/add_tags','BlogController@add_tags')->name('blogs.add_tags');
		Route::get('blogs/settings','BlogController@settings')->name('blogs.settings');
		Route::post('blogs/update-settings1','BlogController@updateSettings1')->name('blogs.updateSettings1');
		Route::post('blogs/update-settings2','BlogController@updateSettings2')->name('blogs.updateSettings2');
		Route::post('/blogs/destroy-blog/{id}','BlogController@destroyBlog')->name('blogs.destroyBlog');
		Route::post('/blogs/change-blog-status/{id}','BlogController@changeBlogStatus')->name('blogs.changeBlogStatus');
		// blog routes end
		
		
		// Editor Route
		Route::post('ckeditorblog/upload', 'BlogController@upload')->name('ckeditorblog.upload');

		/*User Profile Page start*/
		Route::get('/profile','ProfileController@profileSettings')->name('profileSettings');
		Route::post('/user-profile-update','ProfileController@profileUpdate')->name('profileUpdate');
		Route::post('/user-number-update','ProfileController@numberUpdate')->name('numberUpdate');
		Route::post('/user-verify-update','ProfileController@verifyUpdate')->name('verifyUpdate');
        /*User Profile Page end*/

	});
});