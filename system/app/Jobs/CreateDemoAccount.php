<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Offer;
use App\Models\Option;
use App\Models\Channel;
use App\Models\Userplan;
use App\Models\OfferReward;
use App\Models\Transaction;
use App\Models\UserChannel;
use App\Models\WhatsappApi;
use App\Models\ContactGroup;
use App\Models\MessageRoute;
use App\Models\UserEmployee;
use App\Models\BusinessVcard;
use App\Models\MessageWallet;
use Illuminate\Bus\Queueable;
use App\Models\BusinessDetail;
use App\Models\WhatsappSession;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\UserSocialConnection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Queue\SerializesModels;
use App\Models\MessageTemplateSchedule;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Controllers\UuidTokenController;
use App\Jobs\DuplicateOfferDataForSalesPerson;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class CreateDemoAccount implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {  
        // dd($this->data['name']); 

        DB::beginTransaction();
        try {

            $user = new User;
            $user->name = ucwords($this->data['name']);
            $user->email = $this->data['email'];       
            $user->mobile = $this->data['mobile'];
            $user->password = Hash::make($this->data['password']);
            $user->wa_access_token = $this->data['access_token'];
            $user->role_id = 2;
            $user->is_sales_person = 1;
            $user->status = 1;
            $user->save();

            // Get Default V-Card Page
            $vcard = BusinessVcard::where('default_card', 1)->where('status', 1)->first();
            $defaultVcard = 5;
            if($vcard!=NULL){
                $defaultVcard = $vcard->slug;
            }

            //save business details
            $details = new BusinessDetail;
            $details->user_id = $user->id;
            $details->uuid = $user->id.'BUSI'.date("Ymd");
            $details->call_number = $this->data['mobile'];
            $details->business_card_id = $defaultVcard;
            $details->save();

            // Save Personalised Messages
            // Birthday
            $dobTemp = new MessageTemplateSchedule;
            $dobTemp->user_id = $user->id;
            $dobTemp->channel_id = 5;
            $dobTemp->template_id = 1;
            $dobTemp->message_type_id = 1;
            $dobTemp->message_template_category_id = 7;
            $dobTemp->save();
            
            // Anniversary
            $anniTemp = new MessageTemplateSchedule;
            $anniTemp->user_id = $user->id;
            $anniTemp->channel_id = 5;
            $anniTemp->template_id = 6;
            $anniTemp->message_type_id = 1;
            $anniTemp->message_template_category_id = 8;
            $anniTemp->save();

            /* Add entry for default contact groups */
            $grpData = [
                ['user_id' => $user->id, 'name' => 'MESSAGING API Contacts', 'channel_id' => 4, 'is_default' => 1],
                ['user_id' => $user->id, 'name' => 'Instant Challenge Contacts', 'channel_id' => 2, 'is_default' => 1]
            ];
            ContactGroup::insert($grpData);

            //create message routes for user
            $channels = \App\Http\Controllers\Business\ChannelController::msg_channels();
            foreach ($channels as $channel) {
                $msgRoute = new MessageRoute;
                $msgRoute->user_id = $user->id;
                $msgRoute->channel_id = $channel->id;
                $msgRoute->save();
            }   

            /* Invoice number */
            $transaction = Transaction::where('invoice_no', '!=', '')->where('invoice_no', 'not like', '%DEMO%')->orderBy('id','desc')->select('invoice_no')->first();
            $sr_no = 1;
            if($transaction != null){
                $sr_no = (substr($transaction->invoice_no, strrpos($transaction->invoice_no, '/') + 1) + 1);
            }

            $currentYr = Carbon::now()->format('y');
            $month = date('m');
            if($month < 4){
                $currentYr = $currentYr - 1;
            }
            $nextYr = $currentYr + 1;
            $invoice_no = 'MP/DEMO/'.$currentYr.'-'.$nextYr.'/'.$sr_no;

            $transaction = new Transaction;
            $transaction->invoice_no = $invoice_no;
            $transaction->category_id = 12;
            $transaction->user_id = $user->id;
            $transaction->transaction_id = 'demo_abcdefghijklmnopqrstuvwxyz';
            $transaction->transaction_amount= 19180;
            $transaction->total_amount = 23976;
            $transaction->false_transaction = 1;
            $transaction->status = 1;
            $transaction->save();

 
            $invoice_date = Carbon::now()->addYear(1)->format('Y-m-d');
            $channels = Channel::where('status','1')->orderBy('ordering','asc')->get();

            $channelIds = $employeeIds = array();
            foreach($channels as $channel){

                $user_channel = new UserChannel;
                $user_channel->user_id = $user->id;
                $user_channel->channel_id = $channel->id;
                if($channel->price <= 0){
                    $user_channel->will_expire_on = Carbon::now()->addYears(100)->format('Y-m-d');
                }else{
                    $user_channel->will_expire_on = $invoice_date;
                }
                $user_channel->save();

                if($channel->free_employee > 0){
                    for($i = 0; $i < $channel->free_employee; $i++){
                        $user_employee = new UserEmployee;
                        $user_employee->user_id = $user->id;
                        $user_employee->is_free = 1;
                        $user_employee->free_with_channel = $channel->id;
                        $user_employee->will_expire_on = $invoice_date;
                        $user_employee->save();

                        $employeeIds[] = $user_employee->id;
                    }
                }

                /* API */

                $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
                $randomPassword = array(); //remember to declare $pass as an array
                $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
                for ($i = 0; $i < 8; $i++) {
                    $n = rand(0, $alphaLength);
                    $randomPassword[] = $alphabet[$n];
                }

                $randomSender = UuidTokenController::eightCharacterUniqueToken(8);
                if($channel->id == 4){
                    $wa_api = new WhatsappApi;
                    $wa_api->user_id = $user->id;
                    $wa_api->username = 'WAAPI'.$user->id;
                    $wa_api->password = implode($randomPassword);
                    $wa_api->sendername = $randomSender;
                    $wa_api->status = '1';
                    $wa_api->save();
                }

                $channelIds[] = $user_channel->id;
                
            }


            //Minimum Wallet Balance
            $key=array('free_whatsapp_limit','messaging_api_limit','minimum_balance');
            $options=Option::whereIn('key',$key)->pluck('value')->toArray();

            //create message wallet
            $wallet = new MessageWallet;
            $wallet->user_id = $user->id;
            $wallet->wallet_balance = 0;
            $wallet->minimum_balance = $options[0];
            $wallet->messaging_api_daily_limit = $options[1];
            $wallet->messaging_api_daily_free_limit = $options[2];
            $wallet->total_messages = 0;
            $wallet->will_expire_on = $invoice_date;
            $wallet->save();

            /* Register user with new WA API Start */
            $api_data = [
                'email' => $user->email,
                'mobile' => $user->mobile,
                'name' => $user->name,
                'partner_key' => 'PRT-0IDR245P',
                'partner_id' => 3,
            ];
            $wa_registration = app('App\Http\Controllers\WaApiController')->waRegistration($api_data);
            // dd($wa_registration);
            /* Register user with new WA API End */
            

            $wa_session = WhatsappSession::where('user_id', $user->id)->first();
            if($wa_session == null){
                $wa_session = new WhatsappSession;
            }
            $wa_session->user_id = $user->id;
            /* Store whatsapp session data for WA API Start */
            if($wa_registration["status"] == true && !empty($wa_registration["data"])){
                $wa_session->key_id = $wa_registration["data"]["key_id"];
                $wa_session->key_secret = $wa_registration["data"]["key_secret"];
            }
            /* Store whatsapp session data for WA API End */
            $wa_session->save(); 

            $channelArr = $emplooyeeArr = $paid_employeeArr = '';
            if(!empty($channelIds)){
                $channelArr = implode(',', $channelIds);
            }

            if(!empty($employeeIds)){
                $emplooyeeArr = implode(',', $employeeIds);
            }
            
            //save userplan
            $userplan = new Userplan;
            $userplan->user_id = $user->id;
            $userplan->plan_id = 5;
            $userplan->transaction_id = $transaction->id;
            $userplan->will_expire_on = $invoice_date;
            $userplan->channel_ids = $channelArr;
            $userplan->free_employee_ids = $emplooyeeArr;
            $userplan->save();

            if($user){
                $salesAdmin = User::where('is_sales_person', 1)->where('is_sales_admin', 1)->where('status', 1)->first();
                if($salesAdmin != ''){

                    /* User Social Connections same as Sales Admin */
                    $socialConnection = UserSocialConnection::where('user_id', $salesAdmin->id)->first();
                    if($socialConnection != null){
                        $newSocialConnection = $socialConnection->replicate();
                        $newSocialConnection->user_id = $user->id;
                        $newSocialConnection->save();
                    }
                    
                    $instantReward = OfferReward::where('user_id', $salesAdmin->id)->where('channel_id', 2)->first();
                    if($instantReward != null){
                        $instantOfferReward = $instantReward->replicate();
                        $instantOfferReward->user_id = $user->id;
                        $instantOfferReward->save();
                    }

                    $shareReward = OfferReward::where('user_id', $salesAdmin->id)->where('channel_id', 3)->first();
                    if($shareReward != null){
                        $shareOfferReward = $shareReward->replicate();
                        $shareOfferReward->user_id = $user->id;
                        $shareOfferReward->save();
                    }

                    $current_offer = Offer::where('user_id', $salesAdmin->id)->where('start_date', '=', date("Y-m-d"))->first();
                    if($current_offer != null){
                        dispatch(new DuplicateOfferDataForSalesPerson($user->id));
                    }
                }
            }
            
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
       }

       return $user ?? '';
    }
}
