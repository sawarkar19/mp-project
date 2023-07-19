<?php

namespace App\Http\Controllers\Business;

use Auth;
use App\Models\User;
use App\Models\Email;
use App\Models\Option;

use App\Models\EmailJob;
use App\Mail\WaLogoutEmail;
use App\Models\WhatsappApi;
use App\Models\MessageRoute;
use Illuminate\Http\Request;
use App\Models\BusinessDetail;
use App\Models\WhatsappSession;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\ShortLinkController;
use App\Http\Controllers\UuidTokenController;

class WhatsappController extends Controller
{
    //

    public function test(Request $request){


        $wa_session = WhatsappSession::where('user_id', Auth::id())->first();
        // dd($wa_session);
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        return view('business.test', compact('notification_list','planData', 'wa_session'));

    }

    public function setInstance(Request $request){

        $instance_id = $request->instance_id;
        $data = $request->data;

        $wa_ = WhatsappSession::where('user_id', Auth::id())
        ->orderBy('id', 'desc')
        ->first();

        if(!$wa_){
            if($instance_id){

                $wa_number = explode(':', $data['id']);
                $wa_session = WhatsappSession::where('user_id', Auth::id())->first();
                if($wa_session == null){
                    $wa_session = new WhatsappSession;
                }
                
                $wa_session->user_id = Auth::id();
                $wa_session->instance_id = $instance_id;
                $wa_session->data = json_encode($data);
                $wa_session->wa_id = $data['id'];
                $wa_session->wa_number = $wa_number[0];
                // $wa_session->wa_name = $name;
                $wa_session->wa_verifiedName = $data['verifiedName'];
                $wa_session->wa_avatar = $data['avatar'];
                $wa_session->status = 'active';
                $wa_session->save();

                $randomSender = UuidTokenController::eightCharacterUniqueToken(8);

                /*save api data*/
                $wa_api = WhatsappApi::where('user_id',Auth::id())->orderBy('id','desc')->first();
                if($wa_api == null){
                    $wa_api = new WhatsappApi;
                    $wa_api->user_id = Auth::id();
                    $wa_api->username = 'WAAPI'.Auth::id();
                    $wa_api->password = $this->randomPassword();
                    $wa_api->sendername = $randomSender;
                    $wa_api->status = '1';
                    $wa_api->save();
                }

                /* Update Business Whatsapp Number */
                $businessDetail = BusinessDetail::where('user_id',Auth::id())->first();
                $businessDetail->whatsapp_number = $wa_number[0];
                $businessDetail->save();

                return response()->json(['status'=>true, 'message'=>'Whatsapp connected!']);
            }else{

                return response()->json(['status'=>false, 'message'=>'Instance Id Is Empty!']);

            }
        }else{
            
            if($instance_id){
            
                $wa_number = explode(':', $data['id']);
                    
                $wa_session = WhatsappSession::find($wa_->id);
                $wa_session->user_id = Auth::id();
                $wa_session->instance_id = $instance_id;
                $wa_session->data = json_encode($data);
                $wa_session->wa_id = $data['id'];
                $wa_session->wa_number = $wa_number[0];
                // $wa_session->wa_name = $name;
                $wa_session->wa_verifiedName = $data['verifiedName'];
                $wa_session->wa_avatar = $data['avatar'];
                $wa_session->status = 'active';
                $wa_session->save();

                $randomSender = UuidTokenController::eightCharacterUniqueToken(8);

                /*save api data*/
                $wa_api = WhatsappApi::where('user_id',Auth::id())->orderBy('id','desc')->first();
                if($wa_api == null){
                    $wa_api = new WhatsappApi;
                    $wa_api->user_id = Auth::id();
                    $wa_api->username = 'WAAPI'.Auth::id();
                    $wa_api->password = $this->randomPassword();
                    $wa_api->sendername = $randomSender;
                    $wa_api->status = '1';
                    $wa_api->save();
                }

                /* Update Business Whatsapp Number */
                $businessDetail = BusinessDetail::where('user_id',Auth::id())->first();
                $businessDetail->whatsapp_number = $wa_number[0];
                $businessDetail->save();
                
                return response()->json(['status'=>true, 'message'=>'Whatsapp connected!']);
                //return response()->json(['status'=>false, 'message'=>'Record not foaund!']);
            }else{

                return response()->json(['status'=>false, 'message'=>'Instance Id Is Empty!']);

            }
        }
    }


    public function removeInstance(Request $request){
        $wa_session = WhatsappSession::where('user_id', $request->user_id)->first();
        if($wa_session != ''){
            $wa_session->instance_id = '';
            $wa_session->status = 'lost';
            $wa_session->save();
            
            /* Update Business Whatsapp Number */
            $businessDetail = BusinessDetail::where('user_id',Auth::id())->first();
            $businessDetail->whatsapp_number = '';
            $businessDetail->save();

            /* Disable whatsapp routes */
            MessageRoute::where('user_id', $request->user_id)->update(['wa' => 0]);

            /* Get user info */
            $user = User::find($request->user_id);

            /* Send Email */
            $email_info = Email::where('id', 16)->first();
        
            $subject = str_replace("[mobile_no]", substr($wa_session->wa_number, 2), $email_info->subject);

            $data = [
                'name' => $user->name,
                'email' => $user->email,
                'message' => $email_info->content,
                'subject' => $subject
            ];
            
            $email = new WaLogoutEmail($data);
            Mail::to($data['email'])->send($email);
            
            $job = new EmailJob;
            $job->user_id = $user->id;
            $job->email = $user->email;
            $job->email_id = $email_info->id;
            $job->subject = $subject;           
            $job->message = $email_info->content;
            $job->save();

            /* Send Whatsapp Message */
            $long_link = URL::to('/');
            $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $user->id ?? 0, "whatsapp_disconnected");

            /* Send Notification */
            $payload = \App\Http\Controllers\WACloudApiController::mp_wa_disconnected('91'.$user->mobile, $shortLinkData->original["code"]);
            $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);

            // dd($res);

            return response()->json(['status'=>true, 'message'=>'Whatsapp Disconnected!']);
        }
        
        // dd($request->all());
    }


    
    public function setInstanceKey(Request $request){

        $user = Auth::User();
        $wa_session = WhatsappSession::where('user_id', $user->id)->first();
        $instance_key = $request->instance_key;
        $wa_id = $request->jid;
        $number = $request->number;

        if(!$wa_session){
            $wa_session = WhatsappSession::where('user_id', $user->id)->first();
            if($wa_session == null){
                $wa_session = new WhatsappSession;
            }
            $wa_session->user_id = $user->id;
            $wa_session->instance_id = $instance_key;
            $wa_session->wa_id = $wa_id;
            $wa_session->wa_number = $number;
            $wa_session->status = 'active';
            $wa_session->save();

            /* Update Business Whatsapp Number */
            $businessDetail = BusinessDetail::where('user_id',$user->id)->first();
            $businessDetail->whatsapp_number = $number;
            $businessDetail->save();

        }else{
            $wa_session->user_id = $user->id;
            $wa_session->instance_id = $instance_key;
            $wa_session->wa_id = $wa_id;
            $wa_session->wa_number = $number;
            $wa_session->status = 'active';
            $wa_session->save();

            /* Update Business Whatsapp Number */
            $businessDetail = BusinessDetail::where('user_id',$user->id)->first();
            $businessDetail->whatsapp_number = $number;
            $businessDetail->save();
        }

        $avatar = $this->getVatar($instance_key, $number);
        $decode_avatar = json_decode($avatar);
        $wa_session->wa_avatar = $decode_avatar->data;
        $wa_session->save();

        return response()->json(['error' => false, 'connection' => $wa_session]);
    }

    public function resetInstanceKey(Request $request){
        $user = Auth::User();
        $wa_session = WhatsappSession::where('key_id', $request->key_id)->where('key_secret', $request->key_secret)->where('user_id', $user->id)->first();
        // dd($wa_session);
        if($wa_session != ''){
            $wa_session->instance_id = '';
            $wa_session->status = 'lost';
            $wa_session->save();


            /* Update Business Whatsapp Number */
            $user = User::find(Auth::id());

            $businessDetail = BusinessDetail::where('user_id', $user->id)->first();
            $businessDetail->whatsapp_number = '';
            $businessDetail->save();

            /* Disable whatsapp routes */
            MessageRoute::where('user_id', $user->id)->update(['wa' => 0]);

            /* Send Email of whatsapp disconnected */
            $email_info = Email::where('id', 16)->first();
        
            $subject = str_replace("[mobile_no]", substr($wa_session->wa_number, 2), $email_info->subject);

            $data = [
                'name' => $user->name,
                'email' => $user->email,
                'message' => $email_info->content,
                'subject' => $subject
            ];
            
            $email = new WaLogoutEmail($data);
            Mail::to($data['email'])->send($email);
            
            $job = new EmailJob;
            $job->user_id = $user->id;
            $job->email = $user->email;
            $job->email_id = $email_info->id;
            $job->subject = $subject;           
            $job->message = $email_info->content;
            $job->notification_day = "today";
            $job->save();

            /* Send Whatsapp Message */
            $long_link = URL::to('/');
            $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $user->id ?? 0, "whatsapp_instant_id_removed");

            /* Send Notification */
            $payload = \App\Http\Controllers\WACloudApiController::mp_wa_disconnected('91'.$user->mobile, $shortLinkData->original["code"]);
            $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);
        }

        return response()->json(['error' => false, 'message' => "Instance Id removed!"]);
    }

    public function getVatar($instance_key, $number){

        $wa_api_url = Option::where('key','wa_api_url')->first();

        $postDataArray = [
            'key' => $instance_key,
            'id' => $number
        ];
        $data = http_build_query($postDataArray);
        $ch = curl_init();
        $url=$wa_api_url->value.'/misc/downProfile';
        $getUrl = $url."?".$data;
      
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $getUrl);
        curl_setopt($ch, CURLOPT_TIMEOUT, 80);
           
        $response = curl_exec($ch);
        $err = curl_error($ch);

        if ($err) { 
            return $err; 
        } else { 
            return $response; 
        }
    }

    

    public function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public function getQrcode(Request $request){
        return view('test');
    }

    public function setRecevingWebhook(Request $request){
        return view('test');
    }

    public function rebootInstance(Request $request){
        return view('test');
    }

    public function resetInstance(Request $request){
        return view('test');
    }

    public function reconnect(Request $request){
        return view('test');
    }

    public function sendText(Request $request){
        return view('test');
    }

    public function sendMediaFile(Request $request){
        return view('test');
    }

    public function sendTextToGroup(Request $request){
        return view('test');
    }

    public function sendMediaFileToGroup(Request $request){
        return view('test');
    }
}
