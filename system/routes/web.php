<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

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

// Auth::routes();
Auth::routes(['login' => false, 'register' => false]);

Route::get('/system-admin/login', 'CommonLoginController@getAdminLogin')->name('admin-auth');

Route::get('/', 'PageController@index');
Route::get('/home', 'PageController@index')->name('home');
Route::get('/pricing', 'PageController@pricing')->name('pricing');
Route::get('/why-openlink', 'PageController@why_openlink')->name('why-openlink');
Route::get('/signin', 'CommonLoginController@getLogin')->name('login');
Route::get('/user-logout', 'CommonLoginController@logout')->name('userLogout');
// contact us page
Route::get('/contact-us', 'PageController@contact_us')->name('contact_us');
Route::post('/post-contact', 'ContactUsController@postContact')->name('postContact');
Route::post('/ebook-dowload', 'ContactUsController@ebook_download')->name('ebookDownload');
Route::post('/cta-form', 'ContactUsController@cta_form')->name('ctaForm');

Route::get('/about-us', 'PageController@about_us')->name('about-us');
Route::get('/faqs', 'PageController@faqs')->name('faqs');

Route::get('/features', 'PageController@features')->name('features');
// Route::get('/features/d2c-post', 'PageController@ftr_d2c_post');
// Route::get('/features/instant-rewards', 'PageController@ftr_instant_rewards');
// Route::get('/features/openlink-whatsapp-api', 'PageController@ftr_whatsapp_api');
// Route::get('/features/personalised-greetings', 'PageController@ftr_personalised_greetings');
// Route::get('/features/share-and-reward', 'PageController@ftr_share_and_reward');
Route::get('/products/instant-reward', function (){return redirect()->route('channels', 'instant-challenge');});
Route::get('/products/share-and-reward', function (){return redirect()->route('channels', 'share-challenge');});

Route::get('/products/{slug}', 'PageController@channels')->name('channels');

Route::get('/blogs', 'PageController@blogs')->name('blogs');
Route::get('/blogs/{details}', 'PageController@blog_detail')->name('blog_detail');

// Articles routes 
Route::get('/articles', 'PageController@articles')->name('articles');
Route::get('/articles/{slug}', 'PageController@article_detail')->name('article_detail');

Route::get('/privacy-policy', 'PageController@privacy_policy')->name('privacy_policy');
Route::get('/terms-and-conditions', 'PageController@terms_and_conditions')->name('terms_and_conditions');
Route::get('/how-to-redeem', 'PageController@how_to_redeem')->name('how_to_redeem');
Route::get('/track', 'PageController@track')->name('track');

Route::get('/how-it-works', 'PageController@how_it_works')->name('how-it-works');
Route::get('/lp/{str}', 'PageController@landingPages')->name('landingPages');
// set plan in session
Route::post('/set-plan', 'FrontController@setPlan')->name('setPlan');
Route::post('/set-billing-type', 'FrontController@setBillingType')->name('setBillingType');
// email subscription
Route::post('/subscribe-email', 'FrontController@subscribe')->name('subscribe');
Route::post('/subscribe-wa', 'ContactUsController@subscribe_wa')->name('subscribe_wa');
// storing mobile for
Route::post('/request-demo', 'FrontController@requestDemo')->name('requestDemo');

// landing page routes
Route::get('/pos-whatsapp-api', 'LandingPagesController@pos_wa_api');
Route::post('/landing-page-store-data', 'LandingPagesController@store')->name('lp-save');
Route::get('/lp2-mouth-publicity-media', 'LandingPagesController@mouth_publicity_media');
Route::post('/lp2-mouth-publicity-media/save-number', 'LandingPagesController@store_lp2_number')->name('lp2-save-number');
Route::post('/lp2-mouth-publicity-media/save', 'LandingPagesController@store_lp2')->name('lp2-save');

Route::post('/set-plan-data', 'FrontController@setPlanData')->name('setPlanData');
Route::post('/get-plan-data', 'FrontController@getPlanData')->name('getPlanData');

// subscription checkout routes
Route::get('/checkout', 'CheckoutController@checkoutSubscription')->name('checkout');
Route::post('/check-user-payment', 'CheckoutController@checkUserPayment')->name('checkUserPayment');
Route::post('/make-charge/{id}','CheckoutController@checkoutMakePayment')->name('make_charge');

//payment with razorpay
Route::get('/payment-with/razorpay', '\App\Helper\Subscription\Razorpay@razorpay_view');
Route::post('/razorpay/status', '\App\Helper\Subscription\Razorpay@status');
Route::get('/payment-success','CheckoutController@success')->name('payment.success');
Route::any('/payment-failed','CheckoutController@failed')->name('payment.fail');

Route::get('/instamojo','\App\Helper\Subscription\Instamojo@status')->name('instamojo.fallback');
Route::any('/cashfree','\App\Helper\Subscription\Cashfree@status')->name('cashfree.fallback');

Route::any('/payu','\App\Helper\Subscription\PayU@status')->name('payu.fallback');
Route::any('/paytm' ,'\App\Helper\Subscription\Paytm@paymentCallback')->name('paytm.fallback');

// Route::get('/paypal','\App\Helper\Subscription\Paypal@status')->name('paypal.fallback');
// Route::get('/toyyibpay','\App\Helper\Subscription\Toyyibpay@status')->name('toyyibpay.fallback');
// Route::get('/payment-with/razorpay', '\App\Helper\Subscription\Razorpay@razorpay_view');
// Route::get('/payment/mollie', '\App\Helper\Subscription\Mollie@status');
// Route::get('/payment/mercado', '\App\Helper\Subscription\Mercado@status');
// Route::post('/paystack/status', '\App\Helper\Subscription\Paystack@status');

/**
 * Redirect /login & /register to /signin (both forms in one page)
 */
Route::get('/login', function () { return redirect('/signin'); });
Route::get('/register', function () { return redirect('/signin'); });


// Route::get('/login', 'CommonLoginController@getLogin')->name('login');
Route::post('/post-login', 'CommonLoginController@postLogin')->name('postLogin');
Route::post('/send-otp', 'Auth\RegisterController@send_otp')->name('send_otp');
Route::post('/verify-otp', 'Auth\RegisterController@verify_otp')->name('verify_otp');
Route::post('/resend-otp', 'Auth\RegisterController@resend_otp')->name('resend_otp');


//generate password 
Route::post('post-Login-Show-Disclamer/','CommonLoginController@postLoginShowDisclamer')->name('postLoginShowDisclamer');
Route::get('forgot-password/','CommonLoginController@forgotPassword')->name('forgotPassword');
Route::post('email-forgot-password/','CommonLoginController@forgotPasswordEmail')->name('forgotPasswordEmail');
Route::post('update-forgot-password/','CommonLoginController@updateForgotPassword')->name('updateForgotPassword');
Route::get('generate-password/','CommonLoginController@generatePassword');
Route::post('update-user-password/','CommonLoginController@updateUserPassword')->name('updateUserPassword');
Route::get('generate-admin-password/','CommonLoginController@generateAdminPassword');
Route::post('update-admin-password/','CommonLoginController@updateAdminPassword')->name('updateAdminPassword');

//share future link
Route::get('/f/{str}', 'FutureTaskController@offerPage')->name('offerPage');
Route::post('update-social-count', 'FutureTaskController@updateSocialCount')->name('updateSocialCount');

//share instant link
Route::get('/i/{str}', 'InstantTaskController@sharedInstantTemplate')->name('sharedInstantTemplate');

//business info page
Route::get('/business/info/{uuid}', 'PageController@businessPage');
Route::get('/business/task-page/{uuid}', 'PageController@taskPage');

//guide details page
Route::get('/guide/{uuid}', 'FutureTaskController@guidePage');
Route::post('/subscribe-and-share', 'FutureTaskController@subscribeAndShare')->name('subscribeAndShare');

//send redeem code to cashback offer customer
Route::post('/cashback/redeem/{uuid}', 'FutureTaskController@sendCashbackRedeem')->name('cashbackRedeem');

//send redeem code to instant offer customer
Route::post('/instant/redeem/', 'InstantTaskController@sendInstantCode')->name('sendInstantCode');

//verify twitter user who liked the tweet
Route::post('/instant/verify-twliked/', 'InstantTaskController@verifyTwTweetLikedBy')->name('verifyTwTweetLikedBy');

// customer Task for Facebook
// # Like Our Page
Route::post('/instant/fb-page-like/', 'InstantTaskController@facebookPageLike')->name('facebookPageLike');
// # Comment on Post
Route::post('/instant/fb-post-comment/', 'InstantTaskController@facebookPostComment')->name('facebookPostComment');
// # Comment on Post
Route::post('/instant/fb-post-like/', 'InstantTaskController@facebookPostLike')->name('facebookPostLike');

// customer Task for Instagram
// # Like Our Post
Route::post('/instant/check-instagram-profile-followers/', 'InstantTaskController@instagramProfileFollowers')->name('instagramProfileFollowers');
Route::post('/instant/check-instagram-like/', 'InstantTaskController@instagramPostLike')->name('instagramPostLike');
Route::post('/instant/check-instagram-comment/', 'InstantTaskController@instagramPostComment')->name('instagramPostComment');


//verify twitter follow
Route::post('/instant/verify-twfollow/', 'InstantTaskController@verifyTwFollow')->name('verifyTwFollow');

//verify youtube subscribbe
Route::post('/instant/verify-youtube-subscribe/', 'InstantTaskController@verifyYoutubeSubscribe')->name('verifyYoutubeSubscribe');

//verify youtube comment
Route::post('/instant/verify-youtube-comment/', 'InstantTaskController@verifyYoutubeComment')->name('verifyYoutubeComment');

//verify youtube like
Route::post('/instant/verify-youtube-like/', 'InstantTaskController@verifyYoutubeLike')->name('verifyYoutubeLike');

//verify Instagram followers
Route::post('/instant/verify-instagram-follow/', 'InstantTaskController@verifyInstagramFollow')->name('verifyInstagramFollow');

Route::post('verify-google-review', 'InstantTaskController@verifyGoogleReview')->name('verifyGoogleReview');
Route::get('google-review-auth', 'InstantTaskController@googleReviewAuth')->name('googleReviewAuth');
Route::post('set-task-statistics', 'InstantTaskController@setTaskStatistics')->name('setTaskStatistics');
Route::post('get-task-statistics', 'InstantTaskController@getTaskStatistics')->name('getTaskStatistics');

//testing whats app message
Route::get('/test-whats-app', 'FrontController@testWhatsApp')->name('testWhatsApp');

//social posts links
Route::get('/sp/{str}', 'SocialPagesController@post')->name('socialPostPage');

/* Site Generate */
Route::get('/sitemap_index.xml', function(){
    return response(file_get_contents(base_path('sitemap_index.xml')), 200, [
        'Content-Type' => 'application/xml'
    ]);
});
Route::get('/pages-sitemap.xml', function(){
    return response(file_get_contents(base_path('pages-sitemap.xml')), 200, [
        'Content-Type' => 'application/xml'
    ]);
});
Route::get('/blogs-sitemap.xml', function(){
    return response(file_get_contents(base_path('blogs-sitemap.xml')), 200, [
        'Content-Type' => 'application/xml'
    ]);
});
Route::get('/ebooks-sitemap.xml', function(){
    return response(file_get_contents(base_path('ebooks-sitemap.xml')), 200, [
        'Content-Type' => 'application/xml'
    ]);
});
Route::get('/articles-sitemap.xml', function(){
    return response(file_get_contents(base_path('articles-sitemap.xml')), 200, [
        'Content-Type' => 'application/xml'
    ]);
});

// Route::post('business/msg-recharge', 'Business/MessageRechargeController@msgRecharge')->name('msg-recharge');


Route::get('/free-registration', 'CommonLoginController@freeRegistration')->name('freeRegistration');


Route::post('/add-customer-details', 'InstantTaskController@addCustomerDetails')->name('addCustomerDetails');
Route::post('/continue-with-subscription', 'InstantTaskController@continueWithSubscription')->name('continueWithSubscription');


Route::post('/get-socialpost-info', 'PageController@getSocialPostInfo')->name('getSocialPostInfo');

Route::get('/search-results', 'PageController@results')->name('searchResults');
Route::get('/documentation/{slug}', 'PageController@documentation')->name('documentation');

// Get request => Test Expire media type
// Route::get('expire-social-media-get','SocialPagesController@expireSocialMediaGet')->name('expireSocialMediaGet');
Route::post('expire-social-media','SocialPagesController@expireSocialMedia')->name('expireSocialMedia');

Route::get('update-fb-page','SocialPagesController@updateFbPageId')->name('updateFbPageId');

// Set Instant Task Count
Route::post('/check-instant-tasks-count', 'InstantTaskController@checkInstantTasksCount')->name('checkInstantTasksCount');

// thank you pages
Route::get('/{str}/thankyou', 'PageController@thankyou_pages');


Route::get('/olduser-register-wapost', 'WaApiController@oldUserRegister');

// pos pages
Route::get('/pos-info/{str}', 'PageController@posInfoPage')->name('posInfoPage');
Route::get('/pos-qr/{str}', 'PageController@posQrPage')->name('posQrPage');

Route::get('/enterprise/user/{str}', 'PageController@enterpriseUserDetail')->name('enterpriseUserDetail');


//WA API routes
Route::post('/web/set-wa-instance', 'PageController@setWebInstanceKey')->name('setWebInstanceKey');
Route::post('/web/reset-wa-instance', 'PageController@resetWebInstanceKey')->name('resetWebInstanceKey');
Route::post('/web/send-otp', 'PageController@sendPosOTP')->name('sendPosOTP');
Route::post('/web/resend-otp', 'PageController@resendPosOTP')->name('resendPosOTP');
Route::post('/web/verify-otp', 'PageController@verifyPosOTP')->name('verifyPosOTP');
Route::post('get-user-wa-status', 'WaApiController@waStatus')->name('waStatus');


//image
Route::get('/enterprise/banner/{id}', 'PageController@enterpriseOfferImage')->name('enterpriseOfferImage');