<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Business Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::name('business.')->group(function () {

	// redirect if business not login
	Route::get('/', function () { return redirect()->route('login'); });

	Route::group(['middleware' => ['auth'],['business']], function() {

		// Wizard
		Route::get('getStates','WizardController@getStates')->name('getStates');
		Route::get('/whatsapp-settings','WizardController@whatsappSettings')->name('whatsappSettings');
		Route::get('/finish-setup','WizardController@finishSetup')->name('finishSetup');
		Route::get('getUserDetails','WizardController@getUserDetails')->name('getUserDetails');
		Route::post('business-detail-wizard','WizardController@updateBusinessDetails')->name('businessDetail.wizard');
		Route::post('contact-detail-wizard','WizardController@updateContactDetails')->name('contactDetail.wizard');

		// Header status
		Route::get('refresh-settings-status', 'CommonSettingController@refreshSettingsStatus')->name('refreshSettingsStatus');

		// get dashboard routes
		Route::get('/dashboard','DashboardController@dashboard')->name('dashboard');

		/* Partner Routes Start */
		Route::get('partner','Partner\PaymentController@index')->name('partner.index');
		Route::get('partner/subscriptions','Partner\PaymentController@subscriptions')->name('partner.subscriptions');
		Route::post('partner/update-user-detail','Partner\PaymentController@updateUserDetail')->name('partner.updateUserDetail');
		
		Route::post('partner/get-plan-data','Partner\PaymentController@getPlanData')->name('partner.getPlanData');
		Route::post('partner/set-renew-data','Partner\PaymentController@setRenewData')->name('partner.setRenewData');
		Route::post('partner/set-buy-data','Partner\PaymentController@setBuyData')->name('partner.setBuyData');
		Route::post('partner/get-coupon-code','Partner\PaymentController@getCouponCode')->name('partner.getCouponCode');
		
		Route::get('partner/create-payment-link/','Partner\PaymentController@create_payment_link')->name('partner.create_payment_link');

		Route::post('partner/proceed-to-pay', 'Partner\PaymentController@proceedToPay')->name('partner.proceedToPay');
		Route::get('partner/make-payment/{id}','Partner\PaymentController@make_payment')->name('partner.make_payment');
		Route::post('partner/make-charge/{id}','Partner\PaymentController@make_charge')->name('partner.make_charge');
	    Route::post('partner/razorpay/status', '\App\Helper\Subscription\Razorpay@status');
		Route::get('/partner/payment-with/razorpay', '\App\Helper\Subscription\Razorpay@razorpay_view');

		Route::get('partner/payment-success','Partner\PaymentController@success')->name('partner.payment.success');
		Route::get('partner/thank-you','Partner\PaymentController@thankYou')->name('partner.payment.thankYou');
		Route::post('partner/update-price-to-session','Partner\PaymentController@updatePriceToSession')->name('partner.updatePriceToSession');

		Route::get('partner/payment-link/{id}','Partner\LinkController@paymentLink')->name('partner.paymentLink');
		Route::post('partner/send-to-business','Partner\LinkController@sendToBusiness')->name('partner.sendToBusiness');
		Route::get('partner/payment-links','Partner\LinkController@paymentLinks')->name('partner.paymentLinks');

		Route::get('partner/users', 'Partner\UserController@index')->name('partner.userList');

		Route::get('partner/transactions', 'Partner\TransactionController@index')->name('partner.transactionHistory');
		Route::get('partner/transactions/{id}', 'Partner\TransactionController@viewHistory')->name('partner.viewHistory');
		Route::get('partner/transactions/download/{id}', 'Partner\TransactionController@downloadHistory')->name('partner.downloadHistory');
		Route::get('partner/transactions/view-invoice/{id}','Partner\TransactionController@viewInvoice')->name('partner.viewInvoice');

		/* Partner Routes End */

		// Connect with Social Media
		// Route::get('/connect-with-social-media','SocialConnectController@index')->name('connect-sm');
		Route::get('/connect-with-social-medias','SocialConnectController@index')->name('connect-with-social-medias');

		Route::post('/connect-social-media','SocialConnectController@connectSocialMedia')->name('connect-social-media');
		Route::get('create-old-user-authkey','SocialConnectController@createOldUserAuthKey')->name('createOldUserAuthKey');
		Route::post('postToSocialLink','SocialConnectController@postToSocialLink')->name('post-to-social-link');
		Route::post('addSocialPostTask','SocialConnectController@addSocialPostTask')->name('create-social-post');
		Route::post('getFacebookPages','SocialConnectController@getFacebookPages')->name('get-facebook-pages');
		Route::post('saveFacebookPage','SocialConnectController@saveFacebookPage')->name('save-facebook-page');
		Route::post('save-twitter-username','SocialConnectController@saveTwitterUsername')->name('saveTwitterUsername');
		Route::post('saveLinkedinPage','SocialConnectController@saveLinkedinPage')->name('save-linkedin-page');
		Route::post('save-instagram-username','SocialConnectController@saveInstagramUsername')->name('saveInstagramUsername');
		Route::post('post-to-social-media','SocialConnectController@onConnectPostToSocialMedia')->name('onConnectPostToSocialMedia');
		
		Route::get('get-last-7-days','GraphController@getLast7days')->name('getLast7days');
		Route::get('last-7-days','GraphController@last7days')->name('last7days');

		Route::get('last-7-day-current-offer-subscriberes','GraphController@last7daysCurrentOfferSubscriberes')->name('last7daysCurrentOfferSubscriberes');
		Route::get('last-30-day-current-offer-subscriberes','GraphController@last30daysCurrentOfferSubscriberes')->name('last30daysCurrentOfferSubscriberes');
		Route::get('last-365-day-current-offer-subscriberes','GraphController@last365daysCurrentOfferSubscriberes')->name('last365daysCurrentOfferSubscriberes');
		Route::get('offer-start-from-current-offer-subscriberes','GraphController@offerStartFromCurrentOfferSubscriberes')->name('offerStartFromCurrentOfferSubscriberes');

		Route::get('last-7-days-current-offer-chart','GraphController@last7daysCurrentOfferChart')->name('last7daysCurrentOfferChart');
		Route::get('last-30-days-current-offer-chart','GraphController@last30daysCurrentOfferChart')->name('last30daysCurrentOfferChart');
		Route::get('last-365-days-current-offer-chart','GraphController@last365daysCurrentOfferChart')->name('last365daysCurrentOfferChart');
		Route::get('offer-start-from-current-offer-chart','GraphController@offerStartFromCurrentOfferChart')->name('offerStartFromCurrentOfferChart');



		Route::get('get-last-7-days-challengers','GraphController@getlast7dayschallengers')->name('getlast7dayschallengers');
		Route::get('last-7-days-challengers','GraphController@last7DaysChallengers')->name('last7DaysChallengers');
		


		Route::get('last-365-days','GraphController@last365Days')->name('last365Days');
		Route::get('this-month','GraphController@thisMonth')->name('thisMonth');
		Route::get('last-30-days-challengers','GraphController@last30DaysChallengers')->name('last30DaysChallengers');
		Route::get('last-365-days-challengers','GraphController@last365DaysChallengers')->name('last365DaysChallengers');
		Route::get('offer-start-from-challengers','GraphController@offerStartFromChallengers')->name('offerStartFromChallengers');
		
		Route::get('offer-start-from-static-graph','GraphController@offerStartFromStaticGraph')->name('offerStartFromStaticGraph');
		Route::get('get-graph-data','GraphController@getGraphData')->name('getGraphData');
		
		
		// WhatsApp Posts routes 
		Route::get('/d2c-posts','WhatsAppPostController@index')->name('waPosts');
		Route::get('/d2c-posts/view/{id}','WhatsAppPostController@view')->name('waPostsView');
		Route::get('/d2c-posts/view/ajax/{id}','WhatsAppPostController@viewSingleAjax')->name('waPostsViewAjax');
		Route::post('/d2c-post/send','WhatsAppPostController@sendPost')->name('sendPost');
		Route::post('/d2c-post/cancelled','WhatsAppPostController@cancelledPost')->name('cancelledPost');

		//
		Route::get('/whatsapp-template','WhatsAppTemplateController@index')->name('customWpTemplate');
		Route::post('/saveWaTemplate','WhatsAppTemplateController@saveWaTemplate')->name('saveWaTemplate');
		Route::post('/change-wish-status','WhatsAppTemplateController@changeWishStatus')->name('changeWishStatus');

		// get plans, susbcriptions & payments routes
		Route::post('/proceed-to-pay', 'PlanController@proceedToPay')->name('proceedToPay');
		Route::get('/make-payment/{id}','PlanController@make_payment')->name('make_payment');
		Route::post('/checkSubscription', 'PlanController@checkSubscription')->name('checkSubscription');
		Route::get('/subscriptions/plans','PlanController@plans')->name('plan');
		Route::get('/subscriptions/history','PlanController@planHistory')->name('planHistory');
		Route::get('/subscriptions/get-statement','PlanController@getStatement')->name('getStatement');
		Route::get('/subscriptions/view-history/{id}','PlanController@viewHistory')->name('viewHistory');
		Route::get('/subscriptions/download-history/{id}','PlanController@downloadHistory')->name('downloadHistory');
		Route::get('/subscriptions/view-invoice/{id}','PlanController@viewInvoice')->name('viewInvoice');
		Route::get('/subscriptions/subscribe','PlanController@planSubscription')->name('planSubscription');
		Route::post('/make-charge/{id}','PlanController@make_charge')->name('make_charge');
	    Route::post('/razorpay/status', '\App\Helper\Subscription\Razorpay@status');
		Route::get('/payment-success','PlanController@success')->name('payment.success');
		Route::get('/thank-you','PlanController@thankYou')->name('payment.thankYou');
		
		
		Route::post('/set-plan-data','PlanController@setPlanData')->name('setPlanData');
		Route::post('/get-plan-data','PlanController@getPlanData')->name('getPlanData');
		Route::post('/set-renew-data','PlanController@setRenewData')->name('setRenewData');
		Route::post('/set-buy-data','PlanController@setBuyData')->name('setBuyData');
		Route::post('/get-coupon-code','PlanController@getCouponCode')->name('getCouponCode');

		//
		Route::get('/payment-with/razorpay', '\App\Helper\Subscription\Razorpay@razorpay_view');

		// get profile settings routes
		Route::get('/profile','ProfileController@profileSettings')->name('profileSettings');
		Route::post('/user-profile-update','ProfileController@profileUpdate')->name('profileUpdate');
		Route::post('/user-number-update','ProfileController@numberUpdate')->name('numberUpdate');
		Route::post('/user-verify-update','ProfileController@verifyUpdate')->name('verifyUpdate');
		Route::post('/user-email-update','ProfileController@emailUpdate')->name('emailUpdate');
		Route::post('/user-verify-update-email','ProfileController@verifyUpdateEmail')->name('verifyUpdateEmail');
		
		//
		Route::get('/settings','SettingController@settings')->name('settings');
		

		Route::post('/updateSocialLink','SettingController@updateSocialLink')->name('updateSocialLink');

		Route::post('/user-basic-details','SettingController@basicDetails')->name('basicDetails');
		Route::post('daily-report-time', 'SettingController@dailyReportTime')->name('dailyReportTime');
		Route::post('/user-basic-address','SettingController@businessAddress')->name('businessAddress');
		Route::post('/user-billing-address','SettingController@billingAddress')->name('billingAddress');
		Route::get('/check-billing-address','SettingController@checkSameBilling')->name('checkSameBilling');
		Route::post('/delete-billing-address','SettingController@deleteBilling')->name('deleteBilling');
		// Route::post('/toggle-msg-route','SettingController@msgToggle')->name('msgToggle');
		Route::post('/toggle-msg-route','RouteToggleContoller@msgToggle')->name('msgToggle');
		Route::post('/toggle-email-route','RouteToggleContoller@emailToggle')->name('emailToggle');
		Route::post('/user-basic-social','SettingController@socialLinks')->name('socialLinks');
		Route::post('/delete-logo','SettingController@deleteLogo')->name('deleteLogo');
		Route::post('update-list-style','SettingController@updateListStyle')->name('updateListStyle');
		Route::get('notifications','SettingController@notifications')->name('notifications');
		Route::get('notification/{id}','SettingController@viewNotification')->name('viewNotification');
		Route::post('notification/mark-read/','SettingController@markRead')->name('markRead');
		Route::post('notification/mark-unread/','SettingController@markUnRead')->name('markUnRead');
		Route::post('notification/mark-deleted/','SettingController@markDeleted')->name('markDeleted');
		Route::get('image-cropper','SettingController@cropper');
		Route::post('image-cropper/upload','SettingController@upload')->name('imageCropperUpload');

		Route::post('/store-vcard-details','SettingController@storeVcardDetail')->name('storeVcardDetail');
		Route::get('/vcard-info-preview/{id}','SettingController@vcardInfoPreview')->name('vcardInfoPreview');
		
		//convert Paid To Free
		Route::get('/convert-paid-to-free','SettingController@convertPaidToFree')->name('convertPaidToFree');
		/*add number*/
		Route::post('store-user-mobile', 'SettingController@storeUserMobile')->name('storeUserMobile');
		Route::post('destroy-number/{id}', 'SettingController@destroyNumber')->name('destroyNumber');
		/*mark all as read*/
		Route::post('mark-all-as-read', 'SettingController@markAllAsRead')->name('markAllAsRead');
		Route::get('notifications','SettingController@notifications')->name('notifications');

		//
		Route::post('/set-billing-type','CommonSettingController@setBillingType')->name('setBillingType');

		//offer routes
		Route::get('offer/customise/{id}', 'OfferController@customise')->name('offerCustomise');
		Route::get('offer/custom', 'OfferController@customOffer')->name('customOffer');
		Route::get('offer/edit/{id}', 'OfferController@edit')->name('offerEdit');
		Route::get('offer/preview/{id}', 'OfferController@preview')->name('offerPreview');
		Route::get('offer/custom/preview/{id}', 'OfferController@customPreview')->name('customOfferPreview');
		Route::get('template/preview/{id}', 'OfferController@templatePreview')->name('templatePreview');
		Route::get('offer/enter-details', 'OfferController@details')->name('enterOfferDetails');
		Route::post('offer/store', 'OfferController@store')->name('offerStore');
		Route::post('offer/standard/save', 'OfferController@saveStandardOffer')->name('offerSaveStandard');
		Route::post('offer/custom/save', 'OfferController@saveCustom')->name('offerSaveCustom');
		Route::post('offer/save-thumbnail','OfferController@saveThumbnail')->name('saveOfferThumbnail');
		Route::post('offer/update-thumbnail', 'OfferController@updateYoutubeThumbnail')->name('updateYoutubeThumbnail');
		Route::get('offer/script/{offer_id}','OfferController@scriptPage')->name('scriptPage');
		Route::get('offer-social-connect-popup', 'OfferController@showSpcialConnectPopup')->name("showSpcialConnectPopup");

	 	// get test routes
		Route::get('/test/upload', 'ImageController@selectImage')->name('selectImage');
		Route::post('/resize/image', 'ImageController@resizeImage')->name('resizeImage');

		//employee routes
		Route::resource('employee','EmployeeController');
		Route::post('employees/destroy','EmployeeController@destroy')->name('employees.destroys');
		Route::post('check-employee-login','EmployeeController@checkEmployeeLogin')->name('employees.checkEmployeeLogin');



		//testing whats app message
		Route::get('/test-whats', 'WhatsappController@test')->name('test');
		Route::post('/set-instance', 'WhatsappController@setInstance')->name('setInstance');
		Route::post('/remove-instance', 'WhatsappController@removeInstance')->name('removeInstance');

		//WA API routes
		Route::post('/set-wa-instance', 'WhatsappController@setInstanceKey')->name('setInstanceKey');
		Route::post('/reset-wa-instance', 'WhatsappController@resetInstanceKey')->name('resetInstanceKey');

		//
		Route::post('/set-webhook', 'WebhookCallController@setWebhook')->name('setWebhook');


		//Message Recharge
		Route::get('/message-recharges','MessageRechargeController@msgRecharge')->name('messageRecharge');
		Route::post('/checkRechargeSubscription', 'MessageRechargeController@checkRechargeSubscription')->name('checkRechargeSubscription');
		Route::get('/message-recharges/make-payment/{id}','MessageRechargeController@make_payment')->name('recharge_payment');
		Route::post('/make-recharge/{id}','MessageRechargeController@make_recharge_charge')->name('make_recharge');
		Route::get('/message-recharges/success','MessageRechargeController@success')->name('recharge.success');

		//Redeems
		Route::get('/offer-redeem/redeem','RedeemController@redeem')->name('offerRedeem');
		Route::get('/offer-redeem/reports','RedeemController@reports')->name('redeemReports');
		Route::post('redeem-offers', 'RedeemController@redeemOffer')->name('offersRedeem');
		Route::get('/offer-redeem/export-pdf', 'RedeemController@export_to_pdf')->name('redeemExportPdf');
		Route::get('/offer-redeem/export-excel', 'RedeemController@export_to_excel')->name('redeemExportExcel');
		Route::post('proceed-redeem', 'RedeemController@proceedRedeem')->name('redeemProceed');

		//Event Calendar
		Route::get('full-calendar', 'OfferCalendarController@index')->name('fullCalendar');
		Route::post('full-calendar/action', 'OfferCalendarController@action')->name('fullCalendarAction');
		Route::get('full-calendar/offer-list', 'OfferCalendarController@offerList')->name('fullCalendarOfferList');


		//design offer
		Route::get('design-offer', 'DesignOfferController@index')->name('designOffer');
		Route::get('design-offer/templates', 'DesignOfferController@templates')->name('designOffer.templates');
		Route::post('duplicate-offer', 'DesignOfferController@duplicate');
		Route::post('getOffers', 'DesignOfferController@getOffers');
		Route::post('delete-offer', 'DesignOfferController@deleteOffer');
		Route::post('set-unschedule-offer', 'DesignOfferController@setUnscheduleOffer')->name('setUnscheduleOffer');
		Route::post('expire-offer', 'DesignOfferController@expireOffer')->name('expireOffer');
		

		//channel
		Route::get('channels', 'ChannelController@index')->name('channels');

		// social posts routes 
		Route::get('channel/{channel_id}/social-posts','SocialpostController@index')->name('channel.socialPosts');
		Route::get('channel/changeStatus','ChannelController@disableEnableChannel')->name('channel.changeStatus');
		Route::post('addPostTask','SocialpostController@addPostTask')->name('channel.addPostTask');

		//instant rewards
		Route::get('channel/{channel_id}/instant-rewards', 'InstantRewardController@index')->name('channel.instantRewards');
		Route::get('channel/instant-reward/modify-tasks', 'InstantRewardController@modifyTasks')->name('channel.instantRewards.modifyTasks');
		Route::post('channel/instant-reward/update-tasks', 'InstantRewardController@updateTasks')->name('channel.instantRewards.updateTasks');
		Route::post('channel/{channel_id}/instant-reward/store', 'InstantRewardController@store')->name('channel.instantRewardSetting');
		Route::post('instant-reward/check-tasks', 'InstantRewardController@checkTasks')->name('checkTasks');
		Route::get('instant-reward/download-qrcode/{str}', 'InstantRewardController@downloadQrCode')->name('downloadQrCode');
		Route::post('channel/instant-reward/remove-tasks', 'InstantRewardController@removeDeletedTask')->name('removeDeletedTask');


		//share and rewards
		Route::get('channel/{channel_id}/share-and-rewards', 'ShareAndRewardController@index')->name('channel.shareAndReward');
		Route::post('channel/{channel_id}/share-and-reward/store', 'ShareAndRewardController@store')->name('channel.shareAndRewardSetting');
		Route::post('/channel/update-auto-share-settings', 'ShareAndRewardController@autoShareSettings')->name('channel.autoShareSettings');
		Route::post('/channel/send-share-challenge', 'ShareAndRewardController@sendShareChallenge')->name('sendShareChallenge');

		//Api integration whatsapp message
		Route::get('channel/{channel_id}/api', 'ApiIntegrationController@apiKeys')->name('channel.apiKeys');
		Route::get('channel/api/developer-docs', 'ApiIntegrationController@apiDocs')->name('channel.apiDocs');
		
		// new routes
		Route::get('channel/{channel_id}/personalised-messages','PersonalisedMessageController@index')->name('channel.personalisedMessage');
		Route::post('channel/personalised-messages/resend-falied-msg','PersonalisedMessageController@resendFailedMsg')->name('channel.personalisedMessage.resendFailedMsg');
		Route::post('channel/personalised-messages/resend-falied-wish-msg','PersonalisedMessageController@resendFailedWishMsg')->name('channel.personalisedMessage.resendFailedWishMsg');
		Route::post('channel/personalised-messages/resend-failed-offer-msg','PersonalisedMessageController@resendFailedOfferMsg')->name('channel.personalisedMessage.resendFailedOfferMsg');
		Route::post('channel/personalised-messages/get-templates','PersonalisedMessageController@getTemplates')->name('channel.personalisedMessage.getTemplates');
		Route::post('channel/personalised-messages/get-offer-details','PersonalisedMessageController@getOfferDetails')->name('channel.personalisedMessage.getOfferDetails');
		Route::post('channel/personalised-messages/shareOffer','PersonalisedMessageController@shareOffer')->name('channel.personalisedMessage.shareOffer');
		Route::post('channel/personalised-messages/shareOfferSendEnable','PersonalisedMessageController@shareOfferSendEnable')->name('channel.personalisedMessage.shareOfferSendEnable');
		Route::post('channel/personalised-messages/search-templates','PersonalisedMessageController@searchTemplates')->name('channel.personalisedMessage.searchTemplates');
		Route::post('channel/personalised-messages/search-templates-fest','PersonalisedMessageController@searchTemplatesFest')->name('channel.personalisedMessage.searchTemplatesFest');

		Route::post('channel/personalised-messages/setTemplate','PersonalisedMessageController@setTemplate')->name('channel.personalisedMessage.setTemplate');
		Route::post('channel/personalised-messages/setTemplateFestival','PersonalisedMessageController@setTemplateFestival')->name('channel.personalisedMessage.setTemplateFestival');

		Route::post('channel/personalised-messages/editTemplate','PersonalisedMessageController@editTemplate')->name('channel.personalisedMessage.editTemplate');
		Route::post('channel/personalised-messages/editFestivalTemplate','PersonalisedMessageController@editFestivalTemplate')->name('channel.personalisedMessage.editFestivalTemplate');

		Route::post('channel/personalised-messages/cancelTemplate','PersonalisedMessageController@cancelTemplate')->name('channel.personalisedMessage.cancelTemplate');

		Route::post('channel/personalised-messages/scheduleMsg','PersonalisedMessageController@scheduleMsg')->name('channel.personalisedMessage.scheduleMsg');
		Route::get('channel/personalised-messages/view-history','PersonalisedMessageController@viewHistory')->name('channel.personalisedMessage.viewHistory');
		Route::get('channel/personalised-messages/view-history/{id}','PersonalisedMessageController@showMessages')->name('channel.personalisedMessage.showMessages');
		Route::get('channel/personalised-messages/view-history-ofr/{id}','PersonalisedMessageController@showOfrMessages')->name('channel.personalisedMessage.showOfrMessages');
		Route::get('channel/personalised-messages/get-custom-message-list','PersonalisedMessageController@getCustomMessageList')->name('channel.personalisedMessage.getCustomMessageList');
		Route::get('channel/personalised-messages/get-anniversary-message-list','PersonalisedMessageController@getAnniversaryMessageList')->name('channel.personalisedMessage.getAnniversaryMessageList');
		Route::get('channel/personalised-messages/get-birthday-message-list','PersonalisedMessageController@getBirthdayMessageList')->name('channel.personalisedMessage.getBirthdayMessageList');
		Route::get('channel/personalised-messages/get-dob-message-list','PersonalisedMessageController@getDobMessagesList')->name('channel.personalisedMessage.getDobMessagesList');
		Route::get('channel/personalised-messages/get-anni-message-list','PersonalisedMessageController@getAnniMessagesList')->name('channel.personalisedMessage.getAnniMessagesList');
		Route::get('channel/personalised-messages/get-fest-message-list','PersonalisedMessageController@getFestMessagesList')->name('channel.personalisedMessage.getFestMessagesList');
		Route::get('channel/personalised-messages/get-cust-message-list','PersonalisedMessageController@getCustMessagesList')->name('channel.personalisedMessage.getCustMessagesList');
		Route::get('channel/personalised-messages/get-offer-message-list','PersonalisedMessageController@getOfferMessageList')->name('channel.personalisedMessage.getOfferMessageList');
		Route::get('channel/personalised-messages/get-ofr-message-list','PersonalisedMessageController@getOfrMessagesList')->name('channel.personalisedMessage.getOfrMessagesList');
		Route::get('channel/personalised-messages/view-history/dob/{id}','PersonalisedMessageController@dobMessages')->name('channel.personalisedMessage.dobMessages');
        Route::get('channel/personalised-messages/view-history/anni/{id}','PersonalisedMessageController@anniMessages')->name('channel.personalisedMessage.anniMessages');
        Route::post('personalised-messages/set-time-stamp','PersonalisedMessageController@setTimeStamp')->name('personalisedMessage.setTimeStamp');
        Route::post('get-edit-msg-info','PersonalisedMessageController@getPersonalisedMsgInfo')->name('getPersonalisedMsgInfo');
		Route::post('get-edit-msg-festival-info','PersonalisedMessageController@getFestivalMsgInfo')->name('getFestivalMsgInfo');
        Route::post('view-msg-info','PersonalisedMessageController@viewPersonalisedMsg')->name('viewPersonalisedMsg');


		//share links
		Route::get('share-links', 'ShareLinkController@index')->name('shareLinks');
		Route::post('share-links/share-offer', 'ShareLinkController@shareOffer')->name('shareOffer');
		Route::post('share-links/customer-info', 'ShareLinkController@customerInfo')->name('customerInfo');
		Route::post('share-links/apply-redeem-code', 'ShareLinkController@applyRedeemCode')->name('applyRedeemCode');
		Route::post('share-links/redeem-offer', 'ShareLinkController@redeemOffer')->name('redeemOffer');
		Route::post('share-links/get-redeem-code-by-mobile', 'ShareLinkController@getRedeemCodeByMobile')->name('getRedeemCodeByMobile');
		Route::post('share-links/resend-redeem', 'ShareLinkController@resendRedeemCode')->name('resendRedeemCode');
		
		//reports
		Route::get('reports', 'ReportController@index')->name('reports');
		Route::get('get-redeems', 'ReportController@getRedeems')->name('getRedeems');
		Route::get('get-subscriptions', 'ReportController@getSubscriptions')->name('getSubscriptions');
		Route::get('get-messages', 'ReportController@getMessages')->name('getMessages');
		Route::get('get-deductions', 'ReportController@getDeductions')->name('getDeductions');
		Route::get('get-social-impact', 'ReportController@getSocialImpact')->name('getSocialImpact');

		//customers (customer table is used)
		Route::get('/contact-groups', 'CustomerController@groups')->name('contactGroups');
		Route::get('/get-contact-groups', 'CustomerController@getContactGroups')->name('getContactGroups');
		Route::get('/edit-group/{id}', 'CustomerController@editGroup')->name('editGroup');
		Route::post('/update-group/{id}', 'CustomerController@updateGroup')->name('updateGroup');
		Route::get('/group/{id}', 'CustomerController@viewGroup')->name('viewGroup');
		Route::get('/get-groups-list', 'CustomerController@getGroupsList')->name('getGroupsList');
		Route::get('/contacts', 'CustomerController@index')->name('customer.index');
		Route::post('/contacts', 'CustomerController@store')->name('customer.store');
		Route::get('/contacts/{id}', 'CustomerController@show')->name('customer.show');
		Route::get('/contacts/{id}/edit', 'CustomerController@edit')->name('customer.edit');
		Route::put('/contacts/{id}', 'CustomerController@update')->name('customer.update');
		Route::delete('/contacts/{id}', 'CustomerController@destroy')->name('customer.destroy');

		Route::post('/delete-contacts','CustomerController@destroys')->name('customer.destroys');
		Route::post('/suspend-contact','CustomerController@suspend')->name('customer.suspend');
		Route::get('/contact-suspended','CustomerController@custSuspended')->name('customer.suspended');
		Route::get('/import', 'CustomerController@import')->name('customers.import');
		Route::get('/export', 'CustomerController@export')->name('customers.export');
		Route::get('/export-contacts', 'CustomerController@exportContacts')->name('customers.exportContacts');
		Route::post('/import-contact', 'CustomerController@importCustomer')->name('customers.importCustomer');
		Route::post('/group-check', 'CustomerController@groupCheck')->name('customers.groupCheck');
		Route::post('/contact-delete/{id}', 'CustomerController@customerDelete')->name('customerDelete');
		Route::post('/bulk-contact-delete', 'CustomerController@customerDeleteBulk')->name('customerDeleteBulk');
		Route::post('get-contact-details', 'CustomerController@getCustomerData')->name('getCustomerData');
		Route::post('get-subscription-data', 'CustomerController@getSubscriptionData')->name('getSubscriptionData');

	});

	Route::post('/receive-webhook-data', 'WebhookCallController@receiveWebhookData')->name('receiveWebhookData')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

	// Route::get('/resize-social-post-image', 'OfferController@reduceImage')->name('reduceImage');
});




