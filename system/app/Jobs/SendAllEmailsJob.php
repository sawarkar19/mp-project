<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use DB;
use Mail;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Email;
use App\Models\Target;
use App\Mail\TestEmail;
use App\Models\Userplan;
use App\Mail\WaLogoutEmail;
use App\Models\Transaction;
use App\Mail\LowWalletEmail;
use Illuminate\Http\Request;
use App\Mail\AdminByAdminMail;
use App\Mail\ContactToUserMail;
use App\Mail\LowWalletDOBEmail;
use App\Mail\OfferNotPostEmail;
use App\Mail\ContactToAdminMail;
use App\Mail\ForgotPasswordMail;
use App\Mail\LowWalletAnniEmail;
use App\Mail\LowWalletZeroEmail;
use App\Mail\OfferNotShareEmail;
use App\Mail\OfferToCreateEmail;
use App\Mail\BusinessByAdminMail;
use App\Mail\BusinessWelcomeMail;
use App\Mail\EventCancelledEmail;
use App\Mail\OfferToExpiredEmail;
use App\Mail\PlanExpireTodayEmail;

//add code start//
use App\Mail\EmailSubscriptionMail;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Mail\BusinessPlanUpdateMail;
use App\Mail\BusinessPlanExpiredMail;
use App\Mail\AutoSettingLowWalletEmail;
use App\Mail\BusinessWalletExpiredMail;
use App\Mail\BusinessPlanExpireInOneDay;
use App\Mail\BusinessPlanExpireInFiveDay;
use App\Mail\BusinessPlanExpireInSevenDay;
use App\Mail\BusinessPlanExpireInThreeDay;
use App\Mail\DailyReportsToBussinessEmail;
use App\Mail\PlanExpireTodayYesterdayEmail;
use App\Http\Controllers\ShortLinkController;


class SendAllEmailsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user_id;
    private $name;
    private $mobile;
    private $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->user_id = 121;
        $this->name = 'Dinesh Mohurle';
        $this->mobile = '8806168387';
        $this->email = 'dinesh.mohurle@selftech.in';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // set_time_limit(0);

        /* Welcome Email */
        // ######################################################################## 
        // ## WELCOME => check sub, sub & msg, btn, character                    ##
        // ######################################################################## 
        $data = [
            'id' => $this->user_id,
            'name' => $this->name,
            'mobile' => $this->mobile,
            'email' => $this->email,
        ];
        $email = new BusinessWelcomeMail($data);
        Mail::to($data['email'])->send($email);
        $long_link = URL::to('/') . '/signin';
        $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $this->user_id ?? 0, "send_mail");
        $payload = \App\Http\Controllers\WACloudApiController::mp_fr_welcome_alert($this->mobile, $this->name, $shortLinkData->original['code']);
        $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);

        /* Subscription / Subscription Upgrade Email */
        // ######################################################################## 
        // ## THANKS FOR PAYMENT => check sub, sub & msg, btn, character         ##
        // ######################################################################## 
        $data = [
            'name' => $this->name,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'user_id' => $this->user_id,
            'invoice_no' => 'MP/22-23/82',
            'transaction_id' => 'cashfree_6368944110837071122',
            'userplan_id' => 108,
            'plan_id' => 5,
            'plan_name' => 'Test',
            'plan_date' => '25-11-2022',
            'plan_without_gst' => 0,
            'plan_gst' => 1,
            'gst_state' => 'maharashtra',
            'plan_price' => 19180,
        ];
        $email = new BusinessPlanUpdateMail($data);
        Mail::to($data['email'])->send($email);
        $payload = \App\Http\Controllers\WACloudApiController::mp_sub_payment_alert2($this->mobile, $this->name, 'Yearly', '13 Oct, 2022', 'Yearly', '2000', '200', '2000', 'Yearly');
        $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);

        /* 7 days to Plan Expiry */
        // #################################################################################### 
        // ## YOUR PLAN WILL GET EXPIRED IN 7 DAY's => check sub, sub & msg, btn, character  ##
        // ####################################################################################
        $data = [
            'name' => $this->name,
            'mobile' => $this->mobile,
            'email' => $this->email,
        ];
        $email_info = Email::where('id', 3)->first();
        $data['message'] = $email_info['content'];
        $data['subject'] = $email_info['subject'];
        $email = new BusinessPlanExpireInSevenDay($data);
        Mail::to($data['email'])->send($email);
        /* Share link */
        $long_link = URL::to('/') . '/pricing';
        $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $this->user_id ?? 0, "send_mail");
        $day = 7;
        $payload = \App\Http\Controllers\WACloudApiController::mp_will_753_expire_alert($this->mobile, $this->name, $day, $shortLinkData->original['code']);
        $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);

        /* 5 Days to Plan Expiry */
        // ################################################################################### 
        // ## Your plan will get expired in 5 days! => check sub, sub & msg, btn, character  ##                                                                  ##
        // ###################################################################################
        $data = [
            'name' => $this->name,
            'mobile' => $this->mobile,
            'email' => $this->email,
        ];
        $email_info = Email::where('id', 4)->first();
        $data['message'] = $email_info['content'];
        $data['subject'] = $email_info['subject'];

        $email = new BusinessPlanExpireInFiveDay($data);
        Mail::to($data['email'])->send($email);
        /* Share link */
        $long_link = URL::to('/') . '/pricing';
        $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $this->user_id ?? 0, "send_mail");
        $day = 5;

        $payload = \App\Http\Controllers\WACloudApiController::mp_will_753_expire_alert($this->mobile, $this->name, $day, $shortLinkData->original['code']);
        $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);

        /* 3 Days to Plan Expiry */
        // ####################################################################################
        // ## Your plan will get expired in 3 days! => check sub, sub & msg, btn, character  ##                                                                 ##
        // ####################################################################################
        $data = [
            'name' => $this->name,
            'mobile' => $this->mobile,
            'email' => $this->email,
        ];
        $email_info = Email::where('id', 5)->first();
        $data['message'] = $email_info['content'];
        $data['subject'] = $email_info['subject'];
        $email = new BusinessPlanExpireInThreeDay($data);
        Mail::to($data['email'])->send($email);
        /* Share link */
        $long_link = URL::to('/') . '/pricing';
        $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $this->user_id ?? 0, "send_mail");
        $day = 3;
        $payload = \App\Http\Controllers\WACloudApiController::mp_will_753_expire_alert($this->mobile, $this->name, $day, $shortLinkData->original['code']);
        $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);

        /* 1 Days to Plan Expiry */
        // ################################################################################## 
        // ## Your plan will get expired in 1 day! => check sub, sub & msg, btn, character ##
        // ##################################################################################
        $data = [
            'name' => $this->name,
            'mobile' => $this->mobile,
            'email' => $this->email,
        ];
        $email_info = Email::where('id', 6)->first();
        $data['message'] = $email_info['content'];
        $data['subject'] = $email_info['subject'];
        $email = new BusinessPlanExpireInOneDay($data);
        Mail::to($data['email'])->send($email);
        /* Share link */
        $long_link = URL::to('/') . '/pricing';
        $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $this->user_id ?? 0, "send_mail");
        $payload = \App\Http\Controllers\WACloudApiController::mp_will_1_expire_alert($this->mobile, $this->name, $shortLinkData->original['code']);
        $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);

        /* When Plan Expired */
        // ######################################################################## 
        // ## Your plan has expired! => check sub, sub & msg, btn, character     ##
        // ######################################################################## 
        $data = [
            'name' => $this->name,
            'mobile' => $this->mobile,
            'email' => $this->email,
        ];
        $email_info = Email::where('id', 24)->first();
        $data['message'] = $email_info['content'];
        $data['subject'] = $email_info['subject'];

        $email = new PlanExpireTodayEmail($data);
        Mail::to($data['email'])->send($email);
        /* Share link */ 
        $long_link = URL::to('/') . '/pricing';
        $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $this->user_id ?? 0, "send_mail");
        $payload = \App\Http\Controllers\WACloudApiController::mp_today_expire_alert($this->mobile, $this->name, $shortLinkData->original['code']);
        $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);

        /* Daily Reports Email */
        // ########################################################################################## 
        // ## Here are your daily OpenChallenge reports! => check sub, sub & msg, btn, character   ##
        // ##########################################################################################
        $data = [
            'name' => $this->name,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'added_customers' => 100,
            'received_customers' => 50,
            'redeemed_customers' => 10,
            'unique_clicks' => 200,
            'extra_clicks' => 600,
        ];
        $email_info = Email::where('id', 7)->first();
        $email_info['content'] = str_replace('Dear {customer_name}', "<b>". "Dear &nbsp;"  . $this->name."</b>", $email_info['content']);
        $data['message'] = $email_info['content'] . "\n\n<br> 1) Total Contacts added to your business = " . 100 . " \n <br> 2) Total Contacts who received Your Challenge = " . 50 . "\n <br> 3) Total Contacts who come to redeem the Challenge = " . 10 . "\n <br> 4) Total Unique Clicks on your Offer Pages = " . 200 . "\n <br> 5) Total Extra Clicks on your Offer Pages = " . 600;
        $data['subject'] = $email_info['subject'];
        $email = new DailyReportsToBussinessEmail($data);
        Mail::to($data['email'])->send($email);
        /* Share link */
        $long_link = URL::to('/') . '/pricing';
        $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $this->user_id ?? 0, "send_mail");
        $payload = \App\Http\Controllers\WACloudApiController::mp_daily_reports_alert($this->mobile, $this->name, '100', '50', '10', '200', '600', $shortLinkData->original['code']);
        $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);

        /* Offer not posted on social media */
        // #################################################################################
        // ## You haven’t posted your offer yet! => check sub, sub & msg, btn, character  ##
        // #################################################################################
        $data = [
            'name' => $this->name,
            'mobile' => $this->mobile,
            'email' => $this->email,
        ];
        $email_info = Email::where('id', 8)->first();
        $email_info['content'] = str_replace('Dear {customer_name}', "<b>". "Dear &nbsp;"  . $this->name."</b>", $email_info['content']);
        $data['message'] = $email_info['content'];
        $data['subject'] = $email_info['subject'];
        $email = new OfferNotPostEmail($data);
        Mail::to($data['email'])->send($email);
        /* Share link */
        $long_link = URL::to('/') . '/signin';
        $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $this->user_id ?? 0, "send_mail");
        $payload = \App\Http\Controllers\WACloudApiController::mp_dont_posted_offer($this->mobile, $this->name, $shortLinkData->original['code']);
        $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);

        /* Dont have any created offer */
        // ############################################################################# 
        // ## You haven’t created any offer => check sub, sub & msg, btn, character   ##
        // #############################################################################
        $data = [
            'name' => $this->name,
            'mobile' => $this->mobile,
            'email' => $this->email,
        ];
        $email_info = Email::where('id', 9)->first();
        $email_info['content'] = str_replace('Dear {customer_name}', "<b>". "Dear &nbsp;"  . $this->name."</b>", $email_info['content']);
        $data['message'] = $email_info['content'];
        $data['subject'] = $email_info['subject'];
        $email = new OfferToCreateEmail($data);
        Mail::to($data['email'])->send($email);
        /* Share link */
        $long_link = URL::to('/') . '/pricing';
        $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $this->user_id ?? 0, "send_mail");
        $payload = \App\Http\Controllers\WACloudApiController::mp_dont_created_offer($this->mobile, $this->name, $shortLinkData->original['code']);
        $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);

        /* if current offer going to expiry and don't have any scheduled offer */
        // ###################################################################################
        // ## Your current offer will expire soon! => check sub, sub & msg, btn, character  ##
        // ###################################################################################
        $data = [
            'name' => $this->name,
            'mobile' => $this->mobile,
            'email' => $this->email,
        ];
        $email_info = Email::where('id', 10)->first();
        $email_info['content'] = str_replace('Dear {customer_name}', "<b>". "Dear &nbsp;"  . $this->name."</b>", $email_info['content']);
        $data['message'] = $email_info['content'];
        $data['subject'] = $email_info['subject'];
        $email = new OfferToExpiredEmail($data);
        Mail::to($data['email'])->send($email);
        /* Share link */
        $long_link = URL::to('/') . '/pricing';
        $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $this->user_id ?? 0, "send_mail");
        $payload = \App\Http\Controllers\WACloudApiController::mp_offer_expire_soon($this->mobile, $this->name, $shortLinkData->original['code']);
        $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);

        /* Wallet balance is 0 */
        // #########################################################################################
        // ## You have consumed all the message credits! => check sub, sub & msg, btn, character  ##
        // #########################################################################################
        $data = [
            'name' => $this->name,
            'mobile' => $this->mobile,
            'email' => $this->email,
        ];
        $email_info = Email::where('id', 11)->first();
        $email_info['content'] = str_replace('Dear [Name]', "<b>". "Dear &nbsp;"  . $this->name."</b>", $email_info['content']);
        $data['message'] = $email_info['content'];
        $data['subject'] = $email_info['subject'];
        $email = new LowWalletZeroEmail($data);
        Mail::to($data['email'])->send($email);
        /* Share link */
        $long_link = URL::to('/') . '/pricing';
        $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $this->user_id ?? 0, "send_mail");
        $payload = \App\Http\Controllers\WACloudApiController::mp_message_credits_0($this->mobile, $this->name, $shortLinkData->original['code']);
        $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);

        /* If the auto share offer setting is enabled for share and reward and there is not enough wallet balance */
        // #############################################################################
        // ## Your offer may not get shared! => check sub, sub & msg, btn, character  ##
        // #############################################################################
        $data = [
            'name' => $this->name,
            'mobile' => $this->mobile,
            'email' => $this->email,
        ];
        $email_info = Email::where('id', 12)->first();
        $data['message'] = $email_info['content'];
        $data['subject'] = $email_info['subject'];
        $email = new AutoSettingLowWalletEmail($data);
        Mail::to($data['email'])->send($email);
        /* Share link */
        $long_link = URL::to('/') . '/pricing';
        $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $this->user_id ?? 0, "send_mail");
        $payload = \App\Http\Controllers\WACloudApiController::mp_auto_sr_offer_notsent($this->mobile, $this->name, $shortLinkData->original['code']);
        $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);

        /* if Any Event is scheduled but have low wallet */
        // ############################################################################ 
        // ## Your message credits are low! => check sub, sub & msg, btn, character  ##
        // ############################################################################
        $data = [
            'name' => $this->name,
            'mobile' => $this->mobile,
            'email' => $this->email,
        ];
        $email_info = Email::where('id', 13)->first();
        $email_info['content'] = str_replace('Dear {customer_name}', "<b>". "Dear &nbsp;"  . $this->name."</b>", $email_info['content']);
        $data['message'] = $email_info['content'];
        $data['subject'] = $email_info['subject'];
        $email = new LowWalletEmail($data);
        Mail::to($data['email'])->send($email);
        /* Share link */
        $long_link = URL::to('/') . '/pricing';
        $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $this->user_id ?? 0, "send_mail");
        $payload = \App\Http\Controllers\WACloudApiController::mp_low_message($this->mobile, $this->name, $shortLinkData->original['code']);
        $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);

        /* if Any Event cancelled due to low wallet */
        // ######################################################################## 
        // ## Insufficient balance => check sub, sub & msg, btn, character       ##
        // ######################################################################## 
        $data = [
            'name' => $this->name,
            'mobile' => $this->mobile,
            'email' => $this->email,
        ];
        $email_info = Email::where('id', 22)->first();
        $email_info['content'] = str_replace('Dear {name}', "<b>". "Dear &nbsp;"  . $this->name."</b>", $email_info['content']);
        $data['message'] = $email_info['content'];
        $data['subject'] = $email_info['subject'];
        $email = new EventCancelledEmail($data);
        Mail::to($data['email'])->send($email);
        // /* Share link */
        $long_link = URL::to('/') . '/pricing';
        $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $this->user_id ?? 0, "send_mail");
        $payload = \App\Http\Controllers\WACloudApiController::mp_scheduled_canceled($this->mobile, $this->name, $shortLinkData->original['code']);
        $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);

        /* Birthday and Anniversary cron stopped due low message balance */
        // ####################################################################################################################
        // ## Your birthday messages from personalised messaging have been stopped! => check sub, sub & msg, btn, character  ##
        // ####################################################################################################################
        $data = [
            'name' => $this->name,
            'mobile' => $this->mobile,
            'email' => $this->email,
        ];
        $email_info = Email::where('id', 14)->first();
        $data['message'] = $email_info['content'];
        $data['subject'] = $email_info['subject'];
        $email = new LowWalletDOBEmail($data);
        Mail::to($data['email'])->send($email);
        /* Share link */ 
        $long_link = URL::to('/') . '/pricing';
        $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $this->user_id ?? 0, "send_mail");
        $payload = \App\Http\Controllers\WACloudApiController::mp_dob_will_canceled_alert($this->mobile, $this->name, $shortLinkData->original['code']);
        $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);

        /* Anniversary */
        // ######################################################################################################################
        // ## Your anniversary messages from personalised messaging have been stopped! => check sub, sub & msg, btn, character ##
        // ######################################################################################################################
        $data = [
            'name' => $this->name,
            'mobile' => $this->mobile,
            'email' => $this->email,
        ];
        $email_info = Email::where('id', 15)->first();
        $data['message'] = $email_info['content'];
        $data['subject'] = $email_info['subject'];
        $email = new LowWalletAnniEmail($data);
        Mail::to($data['email'])->send($email);
        /* Share link */ 
        $long_link = URL::to('/') . '/pricing';
        $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $this->user_id ?? 0, "send_mail");
        $payload = \App\Http\Controllers\WACloudApiController::mp_anny_will_canceled_alert($this->mobile, $this->name, $shortLinkData->original['code']);
        $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);

        /* if whatsapp disconnected */
        // ######################################################################################################
        // ## Your WhatsApp has been disconnected from OpenChallenge! => check sub, sub & msg, btn, character  ##
        // ######################################################################################################
        $data = [
            'name' => $this->name,
            'mobile' => $this->mobile,
            'email' => $this->email,
        ];
        $email_info = Email::where('id', 16)->first();
        $data['message'] = $email_info['content'];
        $data['subject'] = $email_info['subject'];
        $email = new WaLogoutEmail($data);
        Mail::to($data['email'])->send($email);
        /* Share link */ 
        $long_link = URL::to('/') . '/signin';
        $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $this->user_id ?? 0, "send_mail");
        $payload = \App\Http\Controllers\WACloudApiController::mp_wa_disconnected($this->mobile, $shortLinkData->original['code']);
        $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);

        /* When Plan Expired */
        // ######################################################################## 
        // ## Your plan has expired! => check sub, sub & msg, btn, character     ##
        // ######################################################################## 
        $data = [
            'name' => $this->name,
            'mobile' => $this->mobile,
            'email' => $this->email,
        ];
        $email_info = Email::where('id', 17)->first();
        $email_info['content'] = str_replace('Dear {customer_name}', "<b>". "Dear &nbsp;"  . $this->name."</b>", $email_info['content']);
        $data['message'] = $email_info['content'];
        $data['subject'] = $email_info['subject'];
        $email = new PlanExpireTodayYesterdayEmail($data);
        Mail::to($data['email'])->send($email);
        /* Share link */
        $long_link = URL::to('/') . '/pricing';
        $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $this->user_id ?? 0, "send_mail");
        $payload = \App\Http\Controllers\WACloudApiController::mp_sub_expired_alert($this->mobile, $this->name, $shortLinkData->original['code']);
        $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);

        // echo "e-mails send successfully";
    }
}
