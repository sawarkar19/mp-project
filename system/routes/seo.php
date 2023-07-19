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
Route::name('seo.')->group(function () {
	Route::get('/', function () { return redirect()->route('login'); });

	Route::group(['middleware' => ['auth'],['seo']], function() {
		Route::get('dashboard','DashboardController@dashboard')->name('dashboard');

		// marketing route start
		Route::resource('marketing','MarketingController');
        // marketing route start

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
		Route::post('blogs/update-settings3','BlogController@updateSettings3')->name('blogs.updateSettings3');
		Route::post('/blogs/destroy-blog/{id}','BlogController@destroyBlog')->name('blogs.destroyBlog');
		Route::post('/blogs/change-blog-status/{id}','BlogController@changeBlogStatus')->name('blogs.changeBlogStatus');
		Route::post('ckeditorblog/upload', 'BlogController@upload')->name('ckeditorblog.upload');
		// blog routes end

		Route::resource('seo','SeoController');
		Route::post('seo/sitemap','SeoController@sitemap')->name('seo.sitemap');

		Route::resource('page','PageController');
		Route::post('/page-update/{id}', 'PageController@update')->name('page.PUpdate');
		Route::post('/pages/destroy','PageController@destroy')->name('pages.destroys');
		Route::post('/pages/destroy-page/{id}','PageController@destroyPage')->name('pages.destroyPage');
		Route::post('/pages/change-page-status/{id}','PageController@changePageStatus')->name('pages.changePageStatus');

		Route::post('categoryss/destroy','CategoryController@destroy')->name('categorie.destroys');

		/* documentation start */
		Route::resource('documentation','DocumentationController');
		Route::post('/documentation-update/{id}', 'DocumentationController@update')->name('documentation.BUpdate');
		Route::post('/documentations/destroy','DocumentationController@destroy')->name('documentations.destroys');
		Route::post('documentations/add_tags','DocumentationController@add_tags')->name('documentations.add_tags');
		Route::post('/documentations/destroy-documentation/{id}','DocumentationController@destroydocumentation')->name('documentations.destroydocumentation');
		Route::post('/documentations/change-documentation-status/{id}','DocumentationController@changedocumentationStatus')->name('documentations.changedocumentationStatus');
		/* documentation end */
		
		
		// Editor Route
		Route::post('ckeditordocumentation/upload', 'DocumentationController@upload')->name('ckeditordocumentation.upload');

		//article
		Route::resource('article','ArticleController');
		Route::post('/article-update/{id}', 'ArticleController@update')->name('article.BUpdate');
		Route::post('/articles/destroy','ArticleController@destroy')->name('articles.destroys');
		Route::post('articles/add_tags','ArticleController@add_tags')->name('articles.add_tags');
		Route::get('articles/settings','ArticleController@settings')->name('articles.settings');
		Route::post('articles/update-settings1','ArticleController@updateSettings1')->name('articles.updateSettings1');
		Route::post('articles/update-settings2','ArticleController@updateSettings2')->name('articles.updateSettings2');
		Route::post('articles/update-settings3','ArticleController@updateSettings3')->name('articles.updateSettings3');
		Route::post('/articles/destroy-article/{id}','ArticleController@destroyArticle')->name('articles.destroyArticle');
		Route::post('/articles/change-article-status/{id}','ArticleController@changeArticleStatus')->name('articles.changeArticleStatus');
		
		
		// Editor Route
		Route::post('ckeditorarticle/upload', 'ArticleController@upload')->name('ckeditorarticle.upload');

		//ebook
		Route::resource('ebook','EbookController');
		Route::post('/ebook-update/{id}', 'EbookController@update')->name('ebook.BUpdate');
		Route::post('/ebooks/destroy','EbookController@destroy')->name('ebooks.destroys');
		Route::post('ebooks/add_tags','EbookController@add_tags')->name('ebooks.add_tags');
		Route::get('ebooks/settings','EbookController@settings')->name('ebooks.settings');
		Route::post('ebooks/update-settings1','EbookController@updateSettings1')->name('ebooks.updateSettings1');
		Route::post('ebooks/update-settings2','EbookController@updateSettings2')->name('ebooks.updateSettings2');
		Route::post('/ebooks/destroy-ebook/{id}','EbookController@destroyEbook')->name('ebooks.destroyEbook');
		Route::post('/ebooks/change-ebook-status/{id}','EbookController@changeEbookStatus')->name('ebooks.changeEbookStatus');
		
		
		// Editor Route
		Route::post('ckeditorebook/upload', 'EbookController@upload')->name('ckeditorebook.upload');


		/*--- Documents Category start ---*/
		Route::resource('docscategories', 'DocsCategoryController');
		Route::post('/docscategory','DocsCategoryController@destroys')->name('docscategories.destroys');
		/*--- Documents Category end ---*/

		// front  end search route start
		Route::resource('frontendsearch','FrontEndSearchController');
		Route::post('/frontend-search-update/{id}', 'FrontEndSearchController@update')->name('frontendSearch.frontendSearchUpdate');
		Route::post('/frontend-search/destroy','FrontEndSearchController@destroy')->name('frontendSearch.destroys');
		Route::post('/frontend-search/destroy-page/{id}','FrontEndSearchController@destroyPage')->name('frontendSearch.destroyPage');
		Route::post('/frontend-search/change-page-status/{id}','FrontEndSearchController@changePageStatus')->name('frontendSearch.changePageStatus');
		//front end search route end
		
		
		// Editor Route
		Route::post('ckeditorblog/upload', 'BlogController@upload')->name('ckeditorblog.upload');

		/*User Profile Page start*/
		Route::get('/profile','ProfileController@profileSettings')->name('profileSettings');
		Route::post('/user-profile-update','ProfileController@profileUpdate')->name('profileUpdate');
		Route::post('/user-number-update','ProfileController@numberUpdate')->name('numberUpdate');
		Route::post('/user-verify-update','ProfileController@verifyUpdate')->name('verifyUpdate');
        /*User Profile Page end*/

		/*Users start*/
		Route::get('/userList','UserController@user')->name('userList');
		Route::get('/user-activity/{id}','UserController@userActivity')->name('userActivity');

		Route::get('/userTransaction/{id}','PlanController@planHistory')->name('userTransaction');
		Route::get('/viewTransactionHistory/{id}','PlanController@viewTransactionHistory')->name('viewTransactionHistory');
		Route::get('/viewTransactionInvoice/{id}','PlanController@viewTransactionInvoice')->name('viewTransactionInvoice');
		Route::get('/downloadTransactionHistory/{id}','PlanController@downloadTransactionHistory')->name('downloadTransactionHistory');
		Route::get('/export-users', 'PlanController@exportUsers')->name('exportUsers');

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