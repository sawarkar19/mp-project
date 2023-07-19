<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Email;
use App\Models\EmailJob;
use App\Models\AdminMessage;
use App\Models\CompleteTask;
use Illuminate\Bus\Queueable;
use App\Models\BusinessDetail;
use App\Models\UserNotification;
use App\Models\OfferSubscription;
use App\Models\NotificationContact;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\DailyReportsToBussinessEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Controllers\ShortLinkController;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendDailyReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $userId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = User::withCount('getBusCustomers', 'getInstantSubscriptions', 'getShareSubscriptions', 'getRedeemedCustomers', 'getUniqueClicks', 'getExtraClicks', 'getCompletedTasks')
            ->where('id', $this->userId)
            ->where('status', 1)
            ->first();

        if ($user != null) {
            $added_customers = $user->get_bus_customers_count;
            $received_instant_challenge = $user->get_instant_subscriptions_count;
            $received_share_challenge = $user->get_share_subscriptions_count;
            $redeemed_customers = $user->get_redeemed_customers_count;
            $unique_clicks = $user->get_unique_clicks_count;
            $total_clicks = $user->get_extra_clicks_count + $user->get_unique_clicks_count;
            $completed_tasks = $user->get_completed_tasks_count;

            $data = [
                'name' => $user->name,
                'mobile' => $user->mobile,
                'email' => $user->email,
                'added_customers' => $added_customers,
                'received_instant_challenge' => $received_instant_challenge,
                'received_share_challenge' => $received_share_challenge,
                'redeemed_customers' => $redeemed_customers,
                'unique_clicks' => $unique_clicks,
                'total_clicks' => $total_clicks,
                'completed_tasks' => $completed_tasks,
            ];

            /* notification contact start */
            $notification_contact = NotificationContact::where('user_id', $user->id)->get();
            $businessDetail = BusinessDetail::where('user_id', $user->id)->first();
            /* notification contact end */
            $user_notification_info = UserNotification::where('notification_id', 9)
                ->where('user_id', $user->id)
                ->first();
            if ($user_notification_info->email == 1) {
                $email_info = Email::where('id', 7)->first();

                $new_content = str_replace('Dear {customer_name}', '<b>' . 'Dear &nbsp;' . $user->name . '</b>', $email_info['content']);

                $data['content'] = $new_content;
                $data['added_customers'] = $added_customers;
                $data['received_instant_challenge'] = $received_instant_challenge;
                $data['received_share_challenge'] = $received_share_challenge;
                $data['redeemed_customers'] = $redeemed_customers;
                $data['completed_tasks'] = $completed_tasks;
                $data['unique_clicks'] = $unique_clicks;
                $data['total_clicks'] = $total_clicks;

                $data['message'] = $new_content . "\n\n<br> 1) Total Contacts added to your business = <b> $added_customers </b> \n <br> 2) Total Contacts who received Instant Challenge = <b> $received_instant_challenge </b>\n <br> 3) Total Contacts who received Share Challenge = <b> $received_share_challenge </b>\n <br> 4) Total Contacts who come to redeem the Challenge = <b> $redeemed_customers </b>\n <br> 5) Total Completed Instant Challenge tasks by your contacts = <b> $completed_tasks </b>\n <br> 6) Total Unique Clicks on your Offer Pages = <b> $unique_clicks </b>\n <br> 7) Total Clicks on your Offer Pages = <b> $total_clicks </b>";

                $data['subject'] = $email_info['subject'];

                $email = new DailyReportsToBussinessEmail($data);
                Mail::to($user->email)->send($email);

                /* Add entry to email_jobs table */
                $save_emailjob = new EmailJob();
                $save_emailjob->user_id = $user->id;
                $save_emailjob->email_id = $email_info['id'];
                $save_emailjob->email = $user->email;
                $save_emailjob->subject = $data['subject'];
                $save_emailjob->message = $data['message'];
                $save_emailjob->save();
            }
            if ($user_notification_info->wa == 1) {
                $long_link = URL::to('/') . '/pricing';
                $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $user->id ?? 0, 'daily_report');

                if ($shortLinkData->original['success'] !== false) {
                    //Send through whatsapp on His own whatsapp number

                    $link = '/business/reports';
                    $long_link = URL::to('/') . $link;

                    $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $user->id ?? 0, 'daily_report');
                    if ($shortLinkData->original['success'] == false) {
                        $btn_url = URL::to('/') . '/signin';
                    } else {
                        $btn_url = 'https://opnl.in/' . $shortLinkData->original['code'];
                    }

                    $wa_msg =
                        "*Daily Report of your MouthPublicity: Progress and Insights.*\n*Dear " .
                        $user->name .
                        "*,\n\nWe firmly believe that if you analyze the daily MouthPublicity reports, you can grow your business by focusing on your mouth publicity campaign. 🙂\n\n 1) Total Contacts added to your business = *" .
                        $added_customers .
                        "*\n  2) Total Contacts who received Instant Challenge = *" .
                        $received_instant_challenge .
                        "*\n  3) Total Contacts who received Share Challenge = *" .
                        $received_share_challenge .
                        "*\n  4) Total Contacts who come to redeem the Challenge = *" .
                        $redeemed_customers .
                        "*\n  5) Total Completed Instant Challenge tasks by your contacts = *" .
                        $completed_tasks .
                        "*\n  6) Total Unique Clicks on your Offer Pages = *" .
                        $unique_clicks .
                        "*\n  7) Total Clicks on your Offer Pages = *" .
                        $total_clicks .
                        "*\n\nClick below link to view full report\n" .
                        $btn_url .
                        "\n\n If you have any queries! Feel free to connect with us. We are available from Monday to Friday between 10 AM to 7 PM._\n\n📞 _Call us on 07887882244_\n✉️ _Or you can mail us at care@mouthpublicity.io_\n_MouthPublicity By Logic Innovates_";

                    $params = [
                        'mobile' => '91' . $user->mobile,
                        'message' => $wa_msg,
                        'channel_id' => 0,
                        'user_id' => $user->id,
                    ];

                    $sendLink = app('App\Http\Controllers\MessageController')->sendOnlyWhatsappMsg($params);

                    /* this notification contact send daily report start */
                    if (!empty($notification_contact)) {

                        foreach ($notification_contact as $key => $contact) {
                            $mobile = substr($businessDetail->whatsapp_number, 2);

                            $checkWaNumber = NotificationContact::where('mobile', $mobile)
                            ->where('mobile', $contact->mobile)
                           ->where('user_id', $user->id)
                           ->first();

                            if ($checkWaNumber == null) {
                                $params = [
                                    'mobile' => '91' . $contact->mobile,
                                    'message' => $wa_msg,
                                    'channel_id' => 0,
                                    'user_id' => $user->id,
                                ];

                                $sendLink = app('App\Http\Controllers\MessageController')->sendOnlyWhatsappMsg($params);
                            }
                        }
                    }
                    /*this notification contact send daily report end */

                    $link_by_wa = false;

                    if (isset($sendLink->original['wa']['status']) && $sendLink->original['wa']['status'] == 'success') {
                        $link_by_wa = true;
                    }

                    if ($link_by_wa == true) {
                        /* Admin Message History start */
                        $addmin_history = new AdminMessage();
                        $addmin_history->template_name = 'daily_reports_alert';
                        $addmin_history->message_sent_to = $user->mobile;
                        $addmin_history->save();
                        /* Admin Message History end */
                    }
                }
            }
        }
    }
}
