<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Business\CommonSettingController;
use App\Http\Controllers\WhatsAppMsgController;
use Illuminate\Http\Request;

use App\Models\WhatsappPost;
use App\Models\User;
use App\Models\WhatsappSession;
use App\Models\BusinessCustomer;
use App\Models\BusinessDetail;
use App\Models\Customer;
use App\Models\Userplan;
use App\Jobs\SendPostMessageJob;
use App\Models\Option;

use Auth;
use Carbon\Carbon;

class WhatsAppPostController extends Controller
{
	
	public function __construct(WhatsappPost $whatsappPostModel){
		$this->middleware('business');
        $this->whatsappPostModel = $whatsappPostModel;
    }
	
    public function checkPlan(){

        $planData = CommonSettingController::getBusinessPlanDetails();
        $d2c_post = $planData['d2c_post'];

        return $d2c_post;
    }

    public function index(Request $request){

        $wq_posts = WhatsappPost::where('user_id',Auth::id())->whereIn('status',['delivered','processing','cancelled','failed'])->orderBy('id','desc')->paginate(20);
		$wq_posts_schedule_recent = WhatsappPost::where('user_id',Auth::id())->where('status','queued')->orderBy('schedule_date','asc')->first();	
		//dd($wq_posts_schedule_recent);  
		
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails(); //dd($planData);
        /*plan details*/
        $current_plan_id = ['0' => 7];
		
		$userPlanDetails = Userplan::join('plan_features', 'userplans.feature_id', '=', 'plan_features.id')->where('plan_features.slug','d2c_post')->where('userplans.status',1)->where('userplans.user_id',Auth::id())->select('userplans.id','userplans.allowed_qty','userplans.created_at','userplans.will_expire_on','userplans.plan_id')->first();
		
		$purchaseHistory = Userplan::join('plan_features', 'userplans.feature_id', '=', 'plan_features.id')->where('plan_features.slug','d2c_post')->where('userplans.user_id',Auth::id())->count();
		
		//dd($purchaseHistory);
		
		$currentMonthLimitExaust = $totalLimit = $totalLimitExaust = $todayLimitExaust = $allowed_qty = $addMoreDays = $waQueuedPostCountForCurrentMonth = 0;
		$waQueuedPostCount = '';
		$d2CpostPlanExpiryDate = '';
		$allScheduleDates = $getDatesArray = [];
		
		$monthStartDate = Carbon::now();
		$monthEndDate = Carbon::now()->addDays(30);
        
		if($userPlanDetails != null){
		
			$d2CpostPlanExpiryDate = $userPlanDetails->will_expire_on;
			$d2CpostPlanCreatedDate = $userPlanDetails->created_at;
			$firstMonthStartDate = $d2CpostPlanCreatedDate->format('Y-m-d');
			$plan_id = $userPlanDetails->plan_id;
			$allowed_qty = $userPlanDetails->allowed_qty; //dd($allowed_qty);
			
			$getDatesArray = CommonSettingController::getDatesArray($plan_id,$firstMonthStartDate); //dd($getDatesArray);
			
			$waQueuedPostCount = WhatsappPost::where('user_id',Auth::id())->where('status','queued')->count();
			
			$check = Carbon::now();
			
			if(!empty($getDatesArray)){
				foreach($getDatesArray as $getDates){
					$totalLimit += $allowed_qty;
					$startDate = Carbon::createFromFormat('Y-m-d',$getDates['startDate']);
					$endDate = Carbon::createFromFormat('Y-m-d',$getDates['endDate']);
					
					$waPostCountForCurrentMonth = WhatsappPost::where('user_id',Auth::id())->where('status','<>','cancelled')->where('status','<>','failed')->whereBetween('schedule_date', [$getDates['startDate'], $getDates['endDate']])->count();
					
					//echo $check->toDateString() .' '. $startDate->toDateString() .' '. $endDate->toDateString(); echo '<br/>';
					if(($check->toDateString() >= $startDate->toDateString()) && ($check->toDateString() <= $endDate->toDateString())){
						$monthStartDate = $startDate;
						$monthEndDate = $endDate;
						if($waPostCountForCurrentMonth >= $allowed_qty){
						    $check = $check->addDays(30);
							$addMoreDays += 30;
							$monthStartDate = $startDate;
						    $monthEndDate = $endDate;
							//$currentMonthLimitExaust = 1;
							$waQueuedPostCountForCurrentMonth = WhatsappPost::where('user_id',Auth::id())->where('status','queued')->whereBetween('schedule_date', [$getDates['startDate'], $getDates['endDate']])->count();
						}

					}
				}
			}
		
			$waPostCountForPackageDuration = WhatsappPost::where('user_id',Auth::id())->where('status','<>','cancelled')->where('status','<>','failed')->whereBetween('schedule_date', [$d2CpostPlanCreatedDate, $d2CpostPlanExpiryDate])->count();

			if($waPostCountForPackageDuration >= $totalLimit){
				$totalLimitExaust = 1;
			}
			
			$waPostScheduleCountForToday = WhatsappPost::where('user_id',Auth::id())->where('status','<>','cancelled')->where('status','<>','failed')->whereDate('schedule_date', '=', Carbon::tomorrow()->format('Y-m-d'))->count();
			
			if($waPostScheduleCountForToday > 0){
				$todayLimitExaust = 0;
			}
		}
		
		$wq_posts_all = WhatsappPost::select('schedule_date')->where('status','<>','cancelled')->where('status','<>','failed')->where('user_id',Auth::id())->get();
		
		if($wq_posts_all != null){
			foreach($wq_posts_all as $post){
				$allScheduleDates[] = date('Y-m-d',strtotime($post->schedule_date));
			}
		}
		//dd($allScheduleDates);
		$allScheduleDates = json_encode($allScheduleDates);
		$getDatesArray = json_encode($getDatesArray);
		
		$d2cPostValidations = ['monthStartDate'=>$monthStartDate,'monthEndDate'=>$monthEndDate,'allowedQty'=>$allowed_qty,'currentMonthLimitExaust'=>$currentMonthLimitExaust,'totalLimitExaust'=>$totalLimitExaust,'todayLimitExaust'=>$todayLimitExaust,'d2CpostPlanExpiryDate'=>$d2CpostPlanExpiryDate,'allScheduleDates'=>$allScheduleDates,'addMoreDays'=>$addMoreDays,'waQueuedPostCount'=>$waQueuedPostCount,'getDatesArray'=>$getDatesArray,'purchaseHistory'=>$purchaseHistory];
		//dd($currentMonthLimitExaust);

        return view('business.whatsapp.index', compact('notification_list', 'planData','wq_posts','current_plan_id','wq_posts_schedule_recent','d2cPostValidations'));

    }

    public function sendPost(Request $request){
        set_time_limit(0);
		
		//$request->schedule_date = "2022-05-06 16:30";
		//$manual = "2022-05-09 03:02 pm";
		
		$manual = $request->schedule_date;
		//$manual = "2022-06-10 11:55 am";
		$request->schedule_date = date('Y-m-d H:i',strtotime($manual));
        $shared_to = $delivered_to = $failed_to = array();
        $user_id = Auth::id();
        $message = $request->whatsapp_content;
        $last_scheduled_id = $request->last_scheduled_id;
        $is_media_exist = $request->is_media_exist;
        $rescheduled_id = $request->rescheduled_id;
        $media_exist_url = isset($request->media_exist_url) ? $request->media_exist_url : '';
        if($media_exist_url=='undefined'){
            $media_exist_url = '';
        }

        $userData = User::where('id', $user_id)->orderBy('id', 'desc')->first();
        if($userData->wa_access_token == null){
            return response()->json(["success" => false, 'data' => [], 'message'=> 'WhatsApp Access Token not found.']);
        }

        $access_token = $userData->wa_access_token;
        $user = WhatsappSession::where('user_id', $user_id)->orderBy('id', 'desc')->first();
		if($user == null || (isset($user->instance_id) && $user->instance_id == '')){
            return response()->json(["success" => false, "message" => "Your business account is not linked to Whatsapp."]);
        }

        $customer_ids = BusinessCustomer::where('business_id',Auth::id())->pluck('customer_id')->toArray();
        
        if(empty($customer_ids))
            return response()->json(["success" => false, 'data' => [], 'message'=> 'You don\'t have customers.']);

        if(!empty($customer_ids)){
			
			$totalCustomers = count($customer_ids);
			
			$data = CommonSettingController::checkSendFlagD2c(Auth::id(),7,$request->schedule_date,$totalCustomers); //dd($data);
			
			if(!$data['sendFlag']){
				return response()->json(["success" => false, "message" => "Sorry your msg limit exceed!."]);
			}
			
			
			$countMain = $countCommon = $countMainBefore = $countCommonBefore = 0;
			if($data['countMainBalance']>0){ //echo 111;
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
		 		
		 		if(empty($attachmentUrl)){
		 		    $attachmentUrl = $media_exist_url;
		 		}

				$contactGroup = $this->whatsappPostModel->createContactGroup($whatsappSession->instance_id,$businessDetail->uuid);
				if($contactGroup->status){
					$team_id = $contactGroup->data->team_id;
					$group_id = $contactGroup->data->group_id;
					
					$whatsappSession = WhatsappSession::where('user_id', $user_id)->orderBy('id', 'desc')->first();
					
					$updateContact = $this->whatsappPostModel->updateContact($team_id,$group_id,$mobile_numbers);
					
					if($updateContact->status){
					
						if(!empty($last_scheduled_id) || $last_scheduled_id > 0){
							$whatsappPostSchedule = WhatsappPost::find($last_scheduled_id);
							$statistics = json_decode($whatsappPostSchedule->count_statistics,true);
							$countMainBefore = $statistics['main'];
							$countCommonBefore = $statistics['common'];
						}else{
							$whatsappPostSchedule = null;
						}
							
						if($whatsappPostSchedule != null){
							
							$oddekschedule_id = $whatsappPostSchedule->oddek_schedule_id;
							$updateCampaign = $this->whatsappPostModel->updateCampaign($oddekschedule_id,$request->schedule_date,$request->whatsapp_content,$attachmentUrl);
							//dd($updateCampaign);
							if(!$updateCampaign->status && ($updateCampaign->running == 1 || $updateCampaign->campaign_status == 2) ){
								
								$scheduleCampaign = $this->whatsappPostModel->scheduleCampaign($team_id,$group_id,$whatsappSession->instance_id,$request->schedule_date,$request->whatsapp_content,'d2c',$attachmentUrl);
						
								if($scheduleCampaign->status){
									$oddekschedule_id = $scheduleCampaign->data->last_schedule_id;
									$attachment_url = $scheduleCampaign->data->attachment_url;
								}
							}else{
								$count_statistics = json_encode(['main'=>$countMainBefore,'common'=>$countCommonBefore]);
								$attachment_url = $updateCampaign->data->attachment_url;
							}
						}else{
							
							$scheduleCampaign = $this->whatsappPostModel->scheduleCampaign($team_id,$group_id,$whatsappSession->instance_id,$request->schedule_date,$request->whatsapp_content,'d2c',$attachmentUrl);
						
							if($scheduleCampaign->status){
								$oddekschedule_id = $scheduleCampaign->data->last_schedule_id;
								$attachment_url = $scheduleCampaign->data->attachment_url;	
							}
						}
					
					}
				}else{
					return response()->json(["success" => false, 'data' => [], 'message'=> 'Please relogin to whatsapp!']);
				}

			}

            if(!empty($shared_to_num)){
                
                if(!empty($last_scheduled_id) || $last_scheduled_id > 0){
                    $whatsappPost = WhatsappPost::find($last_scheduled_id);
                }else{
                    $whatsappPost = new WhatsappPost;
                }
                
                $whatsappPost->oddek_schedule_id = $oddekschedule_id;
                $whatsappPost->attachment_url = $attachment_url;
                $whatsappPost->user_id = $user_id;
                $whatsappPost->content = $request->content;
                $whatsappPost->whatsapp_content = $request->whatsapp_content;
                $whatsappPost->shared_to = $shared_to_num;
                $whatsappPost->schedule_date = $request->schedule_date;
                $whatsappPost->status = 'queued';
                $whatsappPost->count_statistics = $count_statistics;
                $whatsappPost->save();
                
                if(!empty($rescheduled_id) && $rescheduled_id > 0){

                    $whatsappPostReschedule = WhatsappPost::where('id',$rescheduled_id)->delete();
                
                }

                return response()->json(["success" => true, 'data' => [], 'message'=> 'Schedule Successfully!']); 
            }else{
                return response()->json(["success" => false, 'data' => [], 'message'=> 'Something went wrong. Please try again.']);
            }
        }else{
            return response()->json(["success" => false, 'data' => [], 'message'=> 'Customers not found.']);
        }

    }
    
    public function cancelledPost(Request $request){
        $last_scheduled_id = $request->last_scheduled_id;
        if(isset($last_scheduled_id) || !empty($last_scheduled_id)){
            $whatsappPost = WhatsappPost::find($last_scheduled_id);
			
			$oddekschedule_id = $whatsappPost->oddek_schedule_id;
			$deleteCampaign = $this->whatsappPostModel->deleteCampaign($oddekschedule_id);
			
            $whatsappPost->status = 'cancelled';
            $whatsappPost->save();
            return response()->json(["success" => true, 'data' => [], 'message'=> 'Cancelled Successfully!']); 
        }else{
            return response()->json(["success" => false, 'data' => [], 'message'=> 'Something went wrong. Please try again.']);
        }
    }

    public function sendPostMessage($cust,$message,$user,$access_token){
        $number = 91;
        $number .= $cust->mobile;

        $message = str_replace("[mobile]",$cust->mobile,$message);

        if(isset($cust->name) && $cust->name != ''){
            $message = str_replace("[name]",$cust->name,$message);
        }else{
            $message = str_replace("[name]",'Dear',$message);
        }

        $postDataArray = [
            'number' => $number,
            'type' => 'text',
            'message' => $message,
            'instance_id' => $user->instance_id,
            'access_token' => $access_token
        ];
     
        $data = http_build_query($postDataArray);
        $ch = curl_init();
  
        $wa_url=Option::where('key','oddek_url')->first();
        $url=$wa_url->value."/api/send.php";
      
        $getUrl = $url."?".$data;
      
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $getUrl);
        curl_setopt($ch, CURLOPT_TIMEOUT, 80);
           
        $response = curl_exec($ch);
        $output = json_decode($response);
        $err = curl_error($ch);

        if ($err) { 
            $this->sendPostMessageAgain($cust,$message,$user,$access_token);
        } else { 
            if($output == null || $output->status == 'error'){
                $this->sendPostMessageAgain($cust,$message,$user,$access_token);
            }else{
                /*Wait 1 min*/
                sleep(60);
                return true;
            } 
        }
    }

    public function sendPostMessageAgain($cust,$message,$user,$access_token){
        $number = 91;
        $number .= $cust->mobile;

        $message = str_replace("[mobile]",$cust->mobile,$message);

        if(isset($cust->name) && $cust->name != ''){
            $message = str_replace("[name]",$cust->name,$message);
        }else{
            $message = str_replace("[name]",'Dear',$message);
        }

        $postDataArray = [
            'number' => $number,
            'type' => 'text',
            'message' => $message,
            'instance_id' => $user->instance_id,
            'access_token' => $access_token
        ];
     
        $data = http_build_query($postDataArray);
        $ch = curl_init();
  
        $wa_url=Option::where('key','oddek_url')->first();
        $url=$wa_url->value."/api/send.php";
      
        $getUrl = $url."?".$data;
      
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $getUrl);
        curl_setopt($ch, CURLOPT_TIMEOUT, 80);
           
        $response = curl_exec($ch);
        $output = json_decode($response);
        $err = curl_error($ch);

        if ($err) { 
            $this->sendPostMessage($cust,$message,$user,$access_token);
        } else { 
            if($output == null || $output->status == 'error'){
                $this->sendPostMessage($cust,$message,$user,$access_token);
            }else{
                /*Wait 1 min*/
                sleep(60);
                return true;
            } 
        }
    }

    public function view(Request $request,$id){
        
        $wq_post = WhatsappPost::findorFail($id);
        if($wq_post->shared_to){
            $shared_to_cust = explode(',',$wq_post->shared_to);
        }else{
            $shared_to_cust = array();
        }
        
        if($request->search){
            $search = $request->search;

            $customers = Customer::with('details')
                                ->withCount('subscription')
                                ->whereIn('customers.id',$shared_to_cust)
                                ->leftjoin('business_customers', 'customers.id', '=', 'business_customers.customer_id')
                                ->where('business_customers.business_id',Auth::id())
                                ->where('customers.mobile', 'like', '%'.$search.'%')
                                ->latest()
                                ->paginate(20);
        }else{
            $search = '';

            $customers = Customer::with('details')
                                ->withCount('subscription')
                                ->whereIn('customers.id',$shared_to_cust)
                                ->leftjoin('business_customers', 'customers.id', '=', 'business_customers.customer_id')
                                ->where('business_customers.business_id',Auth::id())
                                ->latest()
                                ->paginate(20);
        }
        #dd($customers);
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        /*plan details*/
        $current_plan_id = ['0' => 7];

        return view('business.whatsapp.view', compact('notification_list', 'planData','wq_post','search','customers','current_plan_id'));
    }
    
    public function viewSingleAjax(Request $request,$id){
        
        $wq_post = WhatsappPost::findorFail($id);
        
        if($wq_post != null)
            return json_encode(array("status"=>"success", "data" => $wq_post, "message"=>"Success"));
        else
            return json_encode(array("status"=>"error", "message"=>"Scheduled id not matched!"));
    }
    
}
