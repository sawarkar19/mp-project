<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeductionController;

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
Route::name('admin.')->group(function () {
	Route::get('/', function () { return redirect()->route('login'); });

	Route::group(['middleware' => ['auth'],['admin']], function() {

		Route::get('sendemail','DashboardController@SendEmails');
		Route::get('dashboard','DashboardController@dashboard')->name('dashboard');
		Route::get('doughnut-chart','GraphController@doughnutChart')->name('doughnutChart');
		Route::get('get-last-7-days','GraphController@getLast7days')->name('getLast7days');
		Route::get('last-7-days','GraphController@last7days')->name('last7days');
		Route::get('this-month','GraphController@thisMonth')->name('thisMonth');
		Route::get('last-month','GraphController@lastMonth')->name('lastMonth');
		Route::get('last-12-month','GraphController@lastTwelveMonth')->name('lastTwelveMonth');
		Route::get('get-graph-data','GraphController@getGraphData')->name('getGraphData');

		Route::get('get-current-last-7-days','GraphController@getCurrentLast7days')->name('getCurrentLast7days');
		Route::get('current-last-7-days','GraphController@currentGraphLast7days')->name('currentGraphLast7days');
		Route::get('current-this-month','GraphController@currentGraphThisMonth')->name('currentGraphThisMonth');
		Route::get('current-last-month','GraphController@currentGraphLastMonth')->name('currentGraphLastMonth');
		Route::get('current-last-12-month','GraphController@currentGraphLastTwelveMonth')->name('currentGraphLastTwelveMonth');

		

        //--- plan details start  ---//
		Route::resource('plan','PlanController');
		Route::post('plans/destroy','PlanController@destroy')->name('plans.destroys');
		//--- plan details end  ---//

		/* Festival Start */
		Route::resource('festival','FestivalController');
		// Route::resource('deductions','class DeductionController');
		Route::get('deductions_list', 'DeductionController@index')->name('deductionsList');
		Route::post('store', 'DeductionController@store')->name('store');
		Route::post('update', 'DeductionController@update')->name('update');
		Route::post('get-deduction', 'DeductionController@getDeduction')->name('getDeduction');
		/* Festival End */

		Route::resource('customer','CustomerController');
		Route::get('transactions','CustomerController@transactions')->name('customer.transactions');
		Route::get('get-templates','FestivalController@getTemplates')->name('festival.getTemplates');
		
		Route::post('storeFestival','FestivalController@storeFestival')->name('storeFestival');
		// Route::get('festivals','FestivalController@index')->name('customer.festivals');
		Route::get('customer/plan/{id}','CustomerController@planview')->name('customer.planedit');
		Route::put('customer/planupdate/{id}','CustomerController@updateplaninfo')->name('customer.updateplaninfo');
		Route::get('customer/plan-info/{id}','CustomerController@planInfo')->name('customer.planInfo');
		Route::get('customer/user-info/{id}/{type?}','CustomerController@userInfo')->name('customer.userInfo');
		Route::post('customers/destroy','CustomerController@destroy')->name('customers.destroys');
		Route::post('customers/resend-pass-email','CustomerController@regeneratePassword')->name('customers.resendEmail');
		Route::get('customer/plan-history/{id}','CustomerController@history')->name('customer.history');
		Route::get('customer/plan-current/{id}','CustomerController@current')->name('customer.current');
		Route::get('customer/plan-invoice/{id}','CustomerController@invoice')->name('customer.invoice');
		Route::get('customer/view-invoice/{id}','CustomerController@current')->name('customer.webInvoice');
		Route::get('customer/invoice-d/{id}','CustomerController@downloadInvoice')->name('customer.downloadInvoice');
		Route::get('customer/invoice-v/{id}','CustomerController@viewInvoice')->name('customer.viewInvoice');
		Route::post('/get-coupon-code','CustomerController@getCouponCode')->name('getCouponCode');
		Route::post('/suspend-customer','CustomerController@suspendCustomer')->name('suspendCustomer');
		Route::post('/suspend-user','CustomerController@suspendUser')->name('suspendUser');

		Route::resource('order','OrderController');
		Route::post('orders/destroy','OrderController@destroy')->name('orders.destroys');
		Route::get('order/invoice/{id}','OrderController@invoice')->name('order.invoice');

		Route::resource('email','EmailController');

		Route::resource('payment-geteway','PaymentController');

		Route::resource('users', 'AdminController');
		Route::post('/users-status/destroy', 'AdminController@status')->name('users.changeStatus');
		Route::post('/users-status/sendmail', 'AdminController@resendEmail')->name('users.resendEmail');

		Route::get('/profile','ProfileController@settings')->name('profile.settings');
		Route::post('/user_profile_update','ProfileController@profile_update')->name('profile.update');

		Route::resource('marketing','MarketingController');
		
		/* site controller start */
		Route::get('site-settings','SiteController@site_settings')->name('site.settings');
		Route::post('site_settings_update','SiteController@site_settings_update')->name('site_settings.update');

		Route::get('business-settings','SiteController@business_settings')->name('business.settings');
		Route::post('business-settings-update','SiteController@business_settings_update')->name('business_settings.update');

		Route::get('system-environment','SiteController@system_environment_view')->name('site.environment');
		Route::post('env_update','SiteController@env_update')->name('env.update');
		/* site controller end */

		Route::resource('appearance','FrontendController');

		Route::resource('menu','MenuController');
		Route::post('menus/delete','MenuController@destroy')->name('menues.destroy');
		Route::post('menus/MenuNodeStore','MenuController@MenuNodeStore')->name('menus.MenuNodeStore');

		Route::resource('seo','SeoController');
		Route::post('seo/sitemap','SeoController@sitemap')->name('seo.sitemap');

		Route::resource('page','PageController');
		Route::post('/page-update/{id}', 'PageController@update')->name('page.PUpdate');
		Route::post('/pages/destroy','PageController@destroy')->name('pages.destroys');
		Route::post('/pages/destroy-page/{id}','PageController@destroyPage')->name('pages.destroyPage');
		Route::post('/pages/change-page-status/{id}','PageController@changePageStatus')->name('pages.changePageStatus');

		Route::post('categoryss/destroy','CategoryController@destroy')->name('categorie.destroys');

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

		// Route::get('blog/resizeImage', 'BlogController@resizeImage')->name('blog.resizeImage');
		// Route::post('resizeImage', [ImageController::class, 'resizeImage'])->name('resizeImage');

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

        //---location route state and city start---//
		Route::resource('locations/states','StateController');
		Route::post('/states/destroys', 'StateController@destroys')->name('states.destroys');
		Route::resource('locations/cities','CityController');
		Route::post('/cities/destroys', 'CityController@destroys')->name('cities.destroys');
        //---location route state and city end---//

		// coupon routes
		Route::resource('coupon','CouponController');
		Route::post('coupons/destroy','CouponController@destroy')->name('coupons.destroys');
		Route::get('coupons/archive/{id}','CouponController@archive')->name('coupons.archive');
		Route::get('coupons/get-subscribe-user', 'CouponController@getSubscriberUsers')->name('coupons.get-subscribe-user');

		//Manage Payments
		Route::get('/manage-payments/{id}', 'CustomerController@managePayments')->name('customer.managePayments');
		Route::get('/make-payment/{id}', 'CustomerController@make_payment')->name('customer.make_payment');
		Route::post('/proceed-to-pay','CustomerController@proceedToPay')->name('proceedToPay');
		Route::post('/make-charge/{id}','CustomerController@make_charge')->name('make_charge');
	    Route::post('/razorpay/status', '\App\Helper\Subscription\Razorpay@status');
		Route::get('/payment-success','CustomerController@success')->name('customer.success');
		Route::get('/thank-you','CustomerController@thankYou')->name('payment.thankYou');
		Route::get('/payment-with/razorpay', '\App\Helper\Subscription\Razorpay@razorpay_view');

		//---templates start ---//
		Route::resource('templates', 'TemplateController');
		Route::post('/templates/destroys','TemplateController@destroys')->name('templates.destroys');
		//---templates end ---//

		/* Business Vcard start */
		Route::resource('vcards', 'BusinessVcardController');
		Route::post('/vcards/destroys','BusinessVcardController@destroys')->name('vcards.destroys');
		/* Business Vcard end */

		//---Channels start ---//
		Route::resource('channels', 'ChannelController');
		Route::post('/channel','ChannelController@destroys')->name('channels.destroys');
		//---Channels end ---//

		/*--- Documents Category start ---*/
		Route::resource('docscategories', 'DocsCategoryController');
		Route::post('/docscategory','DocsCategoryController@destroys')->name('docscategories.destroys');
		/*--- Documents Category end ---*/

		//---Plans_groups start ---//
		Route::resource('plangroups', 'PlanGroupController');
		Route::post('/plangroup','PlanGroupController@destroys')->name('plangroups.destroys');
		//---Plans_groups end ---//

		//---gallery images start ---//
		Route::resource('galleryimages', 'GalleryImageController')->except('destroy');
		Route::post('/galleryimage/destroy-page/{id}','GalleryImageController@destroyPage')->name('galleryimage.destroyPage');
	    //---gallery image end ---//

		//---Content template start ---//
		Route::resource('contents', 'ContentController')->except('destroy');
		Route::post('/content/destroy-page/{id}','ContentController@destroyPage')->name('content.destroyPage');
	    //---Content template end ---//

		//--- template button start ---//
		Route::resource('templatebuttons', 'TemplateButtonController')->except('destroy');
		Route::post('/templatebutton/destroy-page/{id}','TemplateButtonController@destroyPage')->name('templatebutton.destroyPage');
	    //---template button end ---//

		/* email management start */
		Route::resource('emailmanages','EmailManageController');
		Route::post('/emailmanages/destroy','EmailManageController@destroy')->name('emailmanages.destroys');
		/* email management end */

		/* Demo account start */
		Route::resource('demo-accounts', 'DemoAccountController');
		Route::post('/demo-accounts-status/destroy', 'DemoAccountController@status')->name('demo-accounts.changeStatus');
		Route::post('/demo-accounts-status/sendmail', 'DemoAccountController@resendEmail')->name('demo-accounts.resendEmail');
		/* Demo account end */

		// front  end search route start
		Route::resource('frontendsearch','FrontEndSearchController');
		Route::post('/frontend-search-update/{id}', 'FrontEndSearchController@update')->name('frontendSearch.frontendSearchUpdate');
		Route::post('/frontend-search/destroy','FrontEndSearchController@destroy')->name('frontendSearch.destroys');
		Route::post('/frontend-search/destroy-page/{id}','FrontEndSearchController@destroyPage')->name('frontendSearch.destroyPage');
		Route::post('/frontend-search/change-page-status/{id}','FrontEndSearchController@changePageStatus')->name('frontendSearch.changePageStatus');
		//front end search route end

		/* sites-scripts start */
		Route::resource('sites-scripts','SitesScriptsController');

		Route::put('update-script', 'SitesScriptsController@updateScript')->name('updateScript');

		Route::post('/sites-scripts/destroy','SitesScriptsController@destroy')->name('sites-scripts.destroys');
		Route::post('option-details', 'SitesScriptsController@optionDetail')->name('sites-scripts.optionDetail');
		/* sites-scripts end */

		/* export contact start */
		Route::get('contact-request', 'ContactRequestController@contactList')->name('contacts-request.contactList');
		Route::get('/export-contacts', 'ContactRequestController@exportContacts')->name('exportContacts');
		/* export contact end */

		/* enterprises start */
		Route::resource('enterprises','EnterpriseController');
		Route::post('/enterprises/destroy','EnterpriseController@destroy')->name('enterprises.destroys');
		Route::post('/enterprises/import-users', 'EnterpriseController@importUsers')->name('enterprises.importUsers');
		/* enterprises end */

	});
});