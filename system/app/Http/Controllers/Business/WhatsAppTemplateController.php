<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Business\CommonSettingController;
use App\Models\WhatsappTemplate;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\WhatsappSession;
use Auth;
use App\Models\Userplan;
use App\Models\BusinessCustomer;
use App\Models\WhatsappPost;
use App\Models\WhatsappFestivalPost;;
use App\Models\Customer;
use App\Models\BusinessDetail;

class WhatsAppTemplateController extends Controller
{

	public function __construct(WhatsappPost $whatsappPostModel){
		$this->middleware('business');
        $this->whatsappPostModel = $whatsappPostModel;
    }
	
    public function index(Request $request)
    {
		
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();
        $whatsappTemplates = WhatsappTemplate::where('user_id',Auth::id())->get();

        if(count($whatsappTemplates) == 0){

            /*Date of Birth*/
            $birthday = new WhatsappTemplate;
            $birthday->user_id = Auth::id();
            $birthday->title = 'Birthday';
            $birthday->template_type = 'birthday';
            $birthday->template_content = '<p>On the occasion of your <b>Birthday🎂</b>,</p><p>I wish you prosperity, good health and all the happiness that the room in your heart can hold.</p><p><br></p><p>😊Happy birthday!</p><p></p><p></p></p>';
            $birthday->whatsapp_content = 'On the occasion of your *Birthday🎂*,


I wish you prosperity, good health and all the happiness that the room in your heart can hold.


😊Happy birthday!';
			$birthday->send_wish = 0;
            $birthday->save();

            /*Anniversary*/
            $anniversary = new WhatsappTemplate;
            $anniversary->user_id = Auth::id();
            $anniversary->title = 'Anniversary';
            $anniversary->template_type = 'anniversary';
            $anniversary->template_content = 'Sending my warmest wishes to a wonderful couple on their special day 👫. Hope that you have a sparkling celebration on your anniversary.✨ <p><br></p><p>😊Happy Anniversary!</p>';
            $anniversary->whatsapp_content = 'Sending my warmest wishes to a wonderful couple on their special day 👫. Hope that you have a sparkling celebration on your anniversary.✨ 


😊Happy Anniversary!';
			$anniversary->send_wish = 0;
            $anniversary->save();

            /*Festival*/
            $festival = new WhatsappTemplate;
            $festival->user_id = Auth::id();
            $festival->title = 'Diwali';
            $festival->template_type = 'festival';
            $festival->festival_date = '2022-03-02';
            $festival->template_content = '<p><span style="color: var(--cl-default);">😊Happy Diwali!✨</span><br></p>';
            $festival->whatsapp_content = '😊Happy Diwali!✨';
			$festival->send_wish = 0;
            $festival->save();

            /*get all*/
            $whatsappTemplates = WhatsappTemplate::where('user_id',Auth::id())->get();
        }

        $current_plan_id = ['0' => 8];
        $purchaseHistory = Userplan::join('plan_features', 'userplans.feature_id', '=', 'plan_features.id')->where('plan_features.slug','customised_wishing')->where('userplans.user_id',Auth::id())->count();
		
        return view('business.wishes.index', compact('notification_list', 'planData','whatsappTemplates','current_plan_id','purchaseHistory'));
    }
	
	public function saveWaTemplate(Request $request){
        $user_id = Auth::id();
        $message = $request->whatsapp_content;
		//$request->schedule_date = "2022-04-18 18:58";

        $userData = User::where('id', $user_id)->orderBy('id', 'desc')->first();
        if($userData->wa_access_token == null){
            return response()->json(["success" => false, 'data' => [], 'message'=> 'WhatsApp Access Token not found.']);
        }

        $access_token = $userData->wa_access_token;
        $user = WhatsappSession::where('user_id', $user_id)->orderBy('id', 'desc')->first();
        if($user == '' || (isset($user->instance_id) && $user->instance_id == '')){
            return response()->json(["success" => false, "message" => "Your business account is not linked to Whatsapp."]);
        }
		
		if($request->type=='festival'){
		    
		    if($request->festival_switch == 'false')
               return response()->json(["success" => false, 'data' => [], 'message'=> 'Please enable Festival Wishes first!.']);
		    
			$customer_ids = BusinessCustomer::where('business_id',Auth::id())->pluck('customer_id')->toArray(); //dd($customer_ids);
        
			if(empty($customer_ids))
            return response()->json(["success" => false, 'data' => [], 'message'=> 'You don\'t have customers.']);
		
			$totalCustomers = count($customer_ids);
			
			$data = CommonSettingController::checkSendFlagD2c(Auth::id(),8,$request->festival_date,$totalCustomers,$request->type); //dd($data);
			
			if(!$data['sendFlag']){
				return response()->json(["success" => false, "message" => "Sorry your msg limit exceed!."]);
			}
			

			$countMain = $countCommon = $countMainBefore = $countCommonBefore = 0;
			if($data['countMainBalance']>0){
				$countMainBalance = $data['countMainBalance'];
				if($countMainBalance<=$totalCustomers){
					$countMain = $countMainBalance;
				}else if($countMainBalance > $totalCustomers){
					$countMain = $totalCustomers;
				}
			}
			if($data['countCommonBalance']>0){
				$countCommonBalance = $data['countCommonBalance'];
				if($countCommonBalance <= $totalCustomers){
					$countCommon = $totalCustomers - $countMain;
					if($countCommon > $countCommonBalance){
					    $countCommon = $countCommonBalance;
					}
				}else if($countCommonBalance > $totalCustomers){
					$countCommon = $totalCustomers - $countMain;
				}
			}
			
			$count_statistics = json_encode(['main'=>$countMain,'common'=>$countCommon]);

			$totalWillSend = $countMain+$countCommon;
			
			if($totalCustomers > $totalWillSend){ 
				$totalNotSend = $totalCustomers - $totalWillSend;
				
				$customer_ids = array_splice($customer_ids, 0, $totalWillSend);
				
				CommonSettingController::notifyClientD2c(Auth::id(),$totalWillSend,$totalNotSend);
			}
			
			//dd($customer_ids);

            $shared_to_num = implode(',',$customer_ids);
			
			$mobile_numbers = Customer::whereIn('id',$customer_ids)->pluck('mobile')->toArray();
			
			$businessDetail = BusinessDetail::where('user_id', $user_id)->orderBy('id', 'desc')->first();
			$whatsappSession = WhatsappSession::where('user_id', $user_id)->orderBy('id', 'desc')->first();
			
			$isTemplateExist = WhatsappFestivalPost::where('user_id',$user_id)->where('status','queued')->first();
			if($isTemplateExist != null){
				$last_scheduled_id = $isTemplateExist->id;
				$statistics = json_decode($isTemplateExist->count_statistics,true);
				//$countMain += $statistics['main'];
				//$countCommon += $statistics['common'];
				$countMainBefore = $statistics['main'];
				$countCommonBefore = $statistics['common'];
			}else{
				$last_scheduled_id = 0;
			}
			//dd($last_scheduled_id);
			//$count_statistics = json_encode(['main'=>$countMain,'common'=>$countCommon]);
			
			if($businessDetail != null){
				
				$attachmentUrl = '';
		 		if(isset($_FILES['file']) && !empty($_FILES['file'])){

					$errors     = array();
					$acceptable = array(
						'image/jpeg',
						'image/jpg',
						'video/mp4'
					);

					if((!in_array(strtolower($_FILES['file']['type']), $acceptable)) && (!empty($_FILES["file"]["type"]))) {
						
						return response()->json(["success" => false, "message" => "Invalid file type. Only JPG, JPEG and MP4 types are accepted."]);
						
					}
					
					if(($_FILES["file"]["size"] > 0)) {
						if(strtolower($_FILES['file']['type'])=='video/mp4'){
							$maxsize = 15728640;
							$type = 'Video';
						}else{
							$maxsize = 2097152;
							$type = 'Image';
						}
						
						if($_FILES['file']['size'] > $maxsize ) {
							return response()->json(["success" => false, "message" => $type ." is too large. File must be less than 15 MB."]);
						}
					}else{
					    return response()->json(["success" => false, "message" => "Having some errors in file."]);
					}
					
					if(($_FILES["file"]["error"] > 0)) {
					    return response()->json(["success" => false, "message" => "Having some errors in file."]);
					}

		 			$attachment = $_FILES;
		 			$attachmentResponse = $this->whatsappPostModel->uploadAttachment($attachment);
		 			if($attachmentResponse->status){
		 				$attachmentUrl = $attachmentResponse->filename;
		 			}
		 		}
		 		
		 		$manual = $request->festival_date;
		        $request->festival_date = date('Y-m-d H:i',strtotime($manual));
				
				$contactGroup = $this->whatsappPostModel->createContactGroup($whatsappSession->instance_id,$businessDetail->uuid);
				if($contactGroup->status){
					$team_id = $contactGroup->data->team_id;
					$group_id = $contactGroup->data->group_id;
					
					$whatsappSession = WhatsappSession::where('user_id', $user_id)->orderBy('id', 'desc')->first();
					
					$updateContact = $this->whatsappPostModel->updateContact($team_id,$group_id,$mobile_numbers);
					
					if($updateContact->status){
					
						$whatsappPostSchedule = WhatsappFestivalPost::find($last_scheduled_id);
							
						if($whatsappPostSchedule != null){
							
							$oddekschedule_id = $whatsappPostSchedule->oddek_schedule_id;
							$updateCampaign = $this->whatsappPostModel->updateCampaign($oddekschedule_id,$request->festival_date,$request->whatsapp_content,$attachmentUrl);
							
							if(!$updateCampaign->status && ($updateCampaign->running == 1 || $updateCampaign->campaign_status == 2) ){
								
								$scheduleCampaign = $this->whatsappPostModel->scheduleCampaign($team_id,$group_id,$whatsappSession->instance_id,$request->festival_date,$request->whatsapp_content,'festival',$attachmentUrl);
						
								if($scheduleCampaign->status){
									$oddekschedule_id = $scheduleCampaign->data->last_schedule_id;
									$attachment_url = $scheduleCampaign->data->attachment_url;
								}
							}else{
								$count_statistics = json_encode(['main'=>$countMainBefore,'common'=>$countCommonBefore]);
								$attachment_url = $updateCampaign->data->attachment_url;
							}
						}else{
							
							$scheduleCampaign = $this->whatsappPostModel->scheduleCampaign($team_id,$group_id,$whatsappSession->instance_id,$request->festival_date,$request->whatsapp_content,'festival',$attachmentUrl);

							if($scheduleCampaign->status){
								$oddekschedule_id = $scheduleCampaign->data->last_schedule_id;
								$attachment_url = $scheduleCampaign->data->attachment_url;	
							}else{
							    return response()->json(["success" => false, 'data' => [], 'message'=> $scheduleCampaign->message]);
							}
						}
					
					}
				}else{
					return response()->json(["success" => false, 'data' => [], 'message'=> 'Please relogin to whatsapp!']);
				}
			}
			
			if(!empty($shared_to_num)){
			    
			    if($oddekschedule_id==0){
			        return response()->json(["success" => false, 'data' => [], 'message'=> 'Something went wrong!, please try again later.']);
			    }
                
                if(!empty($last_scheduled_id) && $last_scheduled_id > 0){
                    $whatsappFestivalPost = WhatsappFestivalPost::find($last_scheduled_id);
                }else{
                    $whatsappFestivalPost = new WhatsappFestivalPost;
                }
                
                $whatsappFestivalPost->oddek_schedule_id = $oddekschedule_id;
                
                //if(!empty($attachment_url)){
    			    $whatsappFestivalPost->attachment_url = $attachment_url;
    			//}
				
                $whatsappFestivalPost->user_id = $user_id;
                $whatsappFestivalPost->content = $request->content;
                $whatsappFestivalPost->whatsapp_content = $request->whatsapp_content;
                $whatsappFestivalPost->shared_to = $shared_to_num;
                $whatsappFestivalPost->schedule_date = $request->festival_date;
                $whatsappFestivalPost->status = 'queued';
                $whatsappFestivalPost->count_statistics = $count_statistics;
                $whatsappFestivalPost->save();
				
				$isTemplateExist = WhatsappTemplate::where('user_id',$user_id)->where('template_type', $request->type)->first();
				if($isTemplateExist){
					$WhatsAppTemplate = WhatsappTemplate::find($isTemplateExist->id);
				}else{
					$WhatsAppTemplate = new WhatsappTemplate;
				}
				
				$WhatsAppTemplate->user_id = $user_id;
				$WhatsAppTemplate->title = ucfirst($request->title);
				$WhatsAppTemplate->template_type = $request->type;
				$WhatsAppTemplate->festival_date = $request->festival_date;
				$WhatsAppTemplate->template_content = $request->template_content;
				$WhatsAppTemplate->whatsapp_content = $request->whatsapp_content;
				
				//if(!empty($attachment_url)){
    			    $WhatsAppTemplate->attachment_url = $attachment_url;
    			//}
    			
				$WhatsAppTemplate->save();

				return response()->json(["success" => true, 'message'=> 'Template saved successfully.']); 
				

                return response()->json(["success" => true, 'data' => [], 'message'=> 'Schedule Successfully!']); 
            }else{
                return response()->json(["success" => false, 'data' => [], 'message'=> 'Something went wrong. Please try again.']);
            }			
		
		}else{
			
			$attachment_url = '';
			if(isset($_FILES['file']) && !empty($_FILES['file'])){

				$validatedData = $request->validate([
				 'file' => 'required|mimes:jpeg,jpg,mp4|max:2048',	 
				]);
		 
				$fileName = time().'.'.$request->file->extension();
				
				$upload_path = base_path('../assets/');
				
				$path = $request->file('file')->move(
					 $upload_path.'/schedules/', $fileName
				);
				
				$attachment_url = url('/').'/assets/schedules/'.$fileName;
				
			}
			
        
			$isTemplateExist = WhatsappTemplate::where('user_id',$user_id)->where('template_type', $request->type)->first();
			if($isTemplateExist){
				$WhatsAppTemplate = WhatsappTemplate::find($isTemplateExist->id);
			}else{
				$WhatsAppTemplate = new WhatsappTemplate;
			}
			$WhatsAppTemplate->user_id = $user_id;
			$WhatsAppTemplate->title = ucfirst($request->title);
			$WhatsAppTemplate->template_type = $request->type;
			$WhatsAppTemplate->festival_date = $request->festival_date;
			$WhatsAppTemplate->template_content = $request->template_content;
			$WhatsAppTemplate->whatsapp_content = $request->whatsapp_content;
			
			//if(!empty($attachment_url)){
			    $WhatsAppTemplate->attachment_url = $attachment_url;
			//}
			
			$WhatsAppTemplate->save();

			return response()->json(["success" => true, 'message'=> 'Template saved successfully.']); 
		}

    }

    public function changeWishStatus(Request $request){
        
        $whatsappTemplate = WhatsappTemplate::findorFail($request->wish_id);
        if($request->send_wish == 'true'){
            $send_wish = '1';
        }else{
            $send_wish = '0';
        }
        $whatsappTemplate->send_wish = $send_wish;
        $template_type = $whatsappTemplate->template_type;
        
        if($template_type == 'festival' && $send_wish == '0'){
            $whatsappTemplate->festival_date = '';
            $whatsappTemplate->template_content = '';
            $whatsappTemplate->whatsapp_content = '';
            $whatsappTemplate->attachment_url = '';
        }
        
        if($whatsappTemplate->save()){
            
            if($template_type == 'festival' && $send_wish == '0'){
                $user_id = Auth::id();
                $isTemplateExist = WhatsappFestivalPost::where('user_id',$user_id)->where('status','queued')->latest()->first();
                if($isTemplateExist){
                    
					$whatsappFestivalPost = WhatsappFestivalPost::find($isTemplateExist->id);
					
					$oddekschedule_id = $whatsappFestivalPost->oddek_schedule_id;
			        $deleteCampaign = $this->whatsappPostModel->deleteCampaign($oddekschedule_id);
					
					$whatsappFestivalPost->status = 'cancelled';
                    $whatsappFestivalPost->save();
				}
            }
            
            return response()->json(["success" => true, 'send_wish' => $send_wish, 'template_type' => $whatsappTemplate->template_type, 'message'=> 'Status updated successfully.']); 
        }else{
            return response()->json(["success" => false, 'message'=> 'Status update failed.']); 
        }
    }
}
