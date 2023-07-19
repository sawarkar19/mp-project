<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\WhatsappSession;
use App\Models\WebhookCall;
use App\Models\WebhookWaStatus;
use App\Models\Option;
use App\Models\User;
use App\Models\EmailJob;

class WebhookCallController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('business');
    }
	
	public function setWebhook(Request $request){

		return true;
		
		// if(isset($request->instance_id) && isset($request->access_token)){
			
		// 	$instance_id = $request->instance_id;
		// 	$access_token = $request->access_token;
			
		// 	$receiveWebhookDataUrl = route('business.receiveWebhookData').'&enable=true&instance_id='.$instance_id.'&access_token='.$access_token;
		
		// 	$wa_url=Option::where('key','oddek_url')->first();
        // 	$url=$wa_url->value."/api/setwebhook.php?webhook_url=".$receiveWebhookDataUrl;

		// 	//init the resource
		// 	$ch = curl_init();
		// 	curl_setopt_array($ch, array(
		// 		CURLOPT_URL => $url,
		// 		CURLOPT_RETURNTRANSFER => true,
		// 		CURLOPT_CUSTOMREQUEST => 'GET'
		// 	));

		// 	//Ignore SSL certificate verification
		// 	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		// 	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

		// 	//Get response
		// 	$response = curl_exec($ch);
		// 	$output = json_decode($response);
		// 	curl_close($ch);
		// 	return $output;
		// 	//dd($output);
		// }
	}
	
	public function receiveWebhookData(){

		return true;

		// $result = file_get_contents('php://input');
        // $result = json_decode($result,true);
		
		// if(!empty($result)){
		//     $instanceId = $result['instance_id'];
		//     $waSession = WhatsappSession::where('status', 'active')->where('instance_id', $instanceId)->orderBy('id', 'desc')->first();
        //     //Log::info(print_r($waSession,true));
        //     if(!empty($waSession) || $waSession != null){
        //         $userId = $waSession->user_id;
        //     }
            
        //     //$userId = 105;
			
		// 	if(isset($result['event']) && $result['event']=='state'){
		//         if($result['data']=='logout'){
		            
		//             //Log::info('=======================Logout entry=======================');
        //     		//Log::info(print_r($instanceId,true));
        //     		//Log::info('=======================Logout entry Ends Here=======================');
		            
		// 			WhatsappSession::where('instance_id',$instanceId)->update(['status' => 'lost']);
					
		// 			$lastInstance = WhatsappSession::where('instance_id',$instanceId)->first();
					
		// 			if($lastInstance != null || !empty($lastInstance)){
					    
		// 			    $user = User::where('id', $lastInstance->user_id)->first();
					    
		// 			    if($user != null || !empty($user)){
		// 					//
		// 			    }
                        
		// 			}
					
		// 			//API call to check whatsapp status                       
		// 			$postData = array(
		// 				'instance_id' => trim($instanceId)
		// 			);
		// 			$data = json_encode($postData);
					
		// 			//API URL
		// 			$wa_url=Option::where('key','oddek_url')->first();
        // 			$url=$wa_url->value."/api/removeWebhook.php";

		// 			//init the resource
		// 			$ch = curl_init();
		// 			curl_setopt_array($ch, array(
		// 				CURLOPT_URL => $url,
		// 				CURLOPT_RETURNTRANSFER => true,
		// 				CURLOPT_POST => true,
		// 				CURLOPT_POSTFIELDS => $data
		// 			));

		// 			//Ignore SSL certificate verification
		// 			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		// 			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

		// 			//Get response
		// 			$response = curl_exec($ch);
		// 			$output = json_decode($response);
		// 			curl_close($ch);
					
		//         }
		//     }
		    
		//     if(isset($result['event']) && $result['event']=='message'){
		//         if(isset($result['data']['type']) && $result['data']['type']=='append'){
		// 			if(isset($result['data']['messages'][0]['message']) && isset($result['data']['messages'][0]['message']['extendedTextMessage']['text']) && isset($result['data']['messages'][0]['status']) && isset($result['data']['messages'][0]['key']['id'])){
		// 				$conversation = $result['data']['messages'][0]['message']['extendedTextMessage']['text'];
		// 				$status = $result['data']['messages'][0]['status'];
		// 				$messageId = $result['data']['messages'][0]['key']['id'];
						
		// 				$saveWebhookData = new WebhookCall;
		// 				$saveWebhookData->user_id = $userId;
		// 				$saveWebhookData->instance_id = $instanceId;
		// 				$saveWebhookData->message_id = $messageId;
		// 				$saveWebhookData->conversation = $conversation;
		// 				$saveWebhookData->save();
					
		// 			}
		//         }
		//     }
		    
		//     if(isset($result['event']) && $result['event']=='messages.update'){
		//         if(isset($result['data'][0]['key']['id']) && isset($result['data'][0]['update']['status'])){ 
		//             $status = $result['data'][0]['update']['status'];
		//             $messageId = $result['data'][0]['key']['id'];
					
		// 			$webhookCall = WebhookCall::where('message_id', $messageId)->orderBy('id', 'desc')->first();
		            
		//             if(!empty($webhookCall) || $webhookCall != null){
		                
		// 				$WebhookWaStatus = new WebhookWaStatus;
		// 				$WebhookWaStatus->message_id = $webhookCall->id;
		// 				$WebhookWaStatus->status = $status;
		// 				$WebhookWaStatus->save();
		// 			}
                    
		//         }
		//     }
		// }
		
	}
	
	
}
