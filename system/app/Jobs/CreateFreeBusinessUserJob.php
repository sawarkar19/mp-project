<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\Option;
use App\Models\Channel;
use App\Models\Enterprise;
use App\Models\OfferReward;
use App\Models\UserChannel;
use App\Models\WhatsappApi;
use App\Models\ContactGroup;
use App\Models\MessageRoute;
use App\Models\Notification;
use App\Models\BusinessVcard;
use App\Models\MessageWallet;
use Illuminate\Bus\Queueable;
use App\Models\BusinessDetail;
use App\Models\WhatsappSession;
use App\Models\UserNotification;
use App\Models\SocialAccountCount;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use App\Models\MessageTemplateSchedule;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Controllers\UuidTokenController;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Http\Controllers\Business\ChannelController;

class CreateFreeBusinessUserJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $userData;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($userData)
    {
        $this->userData = $userData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /* Add entry for default contact groups */
        $data = [['user_id' => $this->userData['id'], 'name' => 'MESSAGING API Contacts', 'channel_id' => 4, 'is_default' => 1], ['user_id' => $this->userData['id'], 'name' => 'Instant Challenge Contacts', 'channel_id' => 2, 'is_default' => 1]];
        ContactGroup::insert($data);

        $data = [['user_id' => $this->userData['id'], 'type' => 'Free', 'channel_id' => 2, 'details' => '{"minimum_task":"1"}'], ['user_id' => $this->userData['id'], 'type' => 'Free', 'channel_id' => 3, 'details' => '{"minimum_click":"10"}']];
        OfferReward::insert($data);

        
        /* Message Routes */
        $channelRoutes = ChannelController::msg_channels();
        foreach ($channelRoutes as $channel_r) {
            $route = new MessageRoute();
            $route->user_id = $this->userData['id'];
            $route->channel_id = $channel_r->id;
            $route->save();
        }

        /*notification for user start */
        $notifications = Notification::where('status', 1)->get();
        foreach ($notifications as $notification) {
            $user_notification = new UserNotification();
            $user_notification->notification_id = $notification->id;
            $user_notification->user_id = $this->userData['id'];
            $user_notification->save();
        }
        /*notification for user end*/

        //Minimum Wallet Balance
        $minimum_balance = Option::where('key', 'minimum_balance')->first();

        /*check enterprises id*/
        $enterprise = Enterprise::where('id', $this->userData['enterprise_id'])->first();

        //wallet
        $wallet = new MessageWallet();
        $wallet->user_id = $this->userData['id'];
        $wallet->wallet_balance = 0;
        $wallet->minimum_balance = $minimum_balance->value;
        $wallet->enterprise_api_wa_limit = $enterprise ? $enterprise->wa_per_month_limit : 0;
        $wallet->will_expire_on = Carbon::now()->addYears(100)->format('Y-m-d');
        $wallet->save();

        // Get Default V-Card Page
        $vcard = BusinessVcard::where('default_card', 1)
            ->where('status', 1)
            ->first();
        $defaultVcard = 5;
        if ($vcard != null) {
            $defaultVcard = $vcard->slug;
        }

        $contactGroup = ContactGroup::where('user_id', $this->userData['id'])
            ->pluck('id')
            ->toArray();

        $groups_id = implode(',', $contactGroup);

        $details = new BusinessDetail();
        $details->user_id = $this->userData['id'];
        $details->uuid = $this->userData['id'] . 'BUSI' . date('Ymd');
        $details->call_number = $this->userData['mobile'];
        $details->business_card_id = $defaultVcard;
        $details->save();

        /* Add Default Entry for Social Counts */
        $socialAccountCount = new SocialAccountCount();
        $socialAccountCount->user_id = $this->userData['id'];
        $socialAccountCount->fb_page_url_count = 0;
        $socialAccountCount->insta_profile_url_count = 0;
        $socialAccountCount->tw_username_count = 0;
        $socialAccountCount->li_company_url_count = 0;
        $socialAccountCount->yt_channel_url_count = 0;
        $socialAccountCount->google_review_link_count = 0;
        $socialAccountCount->save();

        $randomSender = UuidTokenController::eightCharacterUniqueToken(8);

        $wa_api = new WhatsappApi();
        $wa_api->user_id = $this->userData['id'];
        $wa_api->username = 'WAAPI' . $this->userData['id'];
        $wa_api->password = $this->randomPassword();
        $wa_api->sendername = $randomSender;
        $wa_api->status = '1';
        $wa_api->save();

        //add channels
        $channels = Channel::all();
        foreach ($channels as $channel) {
            $userChannel = new UserChannel();
            $userChannel->user_id = $this->userData['id'];
            $userChannel->channel_id = $channel->id;

            if ($channel->id == 4) {
                $userChannel->status = 0;
            }

            $userChannel->save();
        }

        // Save Personalised Messages
        // 1 Birthday
        $dobTemp = new MessageTemplateSchedule();
        $dobTemp->user_id = $this->userData['id'];
        $dobTemp->channel_id = 5;
        $dobTemp->template_id = 1;
        $dobTemp->related_to = 'Personal';
        $dobTemp->message_type_id = 1;
        $dobTemp->message_template_category_id = 7;
        $dobTemp->save();

        // 2 Anniversary
        $anniTemp = new MessageTemplateSchedule();
        $anniTemp->user_id = $this->userData['id'];
        $anniTemp->channel_id = 5;
        $anniTemp->template_id = 6;
        $anniTemp->related_to = 'Personal';
        $anniTemp->message_type_id = 1;
        $anniTemp->message_template_category_id = 8;
        $anniTemp->save();

        $all_festival = DB::table('festivals')
            ->where('status', 1)
            ->where('festival_date', '>=', Carbon::now()->format('Y-m-d'))
            ->get();

        // 3 Festivals
        foreach ($all_festival as $festival) {
            $festivalTemp = new MessageTemplateSchedule();
            $festivalTemp->user_id = $this->userData['id'];
            $festivalTemp->channel_id = 5;
            $festivalTemp->template_id = $festival->template_id;
            $festivalTemp->message_type_id = $festival->message_type_id;
            $festivalTemp->time_slot_id = $festival->time_slot_id;
            $festivalTemp->related_to = 'Festival';
            $festivalTemp->groups_id = $groups_id;
            $festivalTemp->scheduled = $festival->festival_date;
            $festivalTemp->message_template_category_id = $festival->message_template_category_id;
            $festivalTemp->save();
        }
    }

    public function randomPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = []; //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
}
