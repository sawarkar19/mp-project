<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\WhatsappPost;
use App\Models\WhatsappFestivalPost;
use App\Models\User;
use App\Models\WhatsappSession;
use App\Models\EmailJob;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

use App\Models\Option;

class CheckProcessed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:processed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(WhatsappPost $whatsappPost)
    {
		$checkProcessed = $whatsappPost->checkProcessed();
		if($checkProcessed->status){
		    $totalSent = 0;
		    $statistics = [];
			if(isset($checkProcessed->data) && !empty($checkProcessed->data)){
				foreach($checkProcessed->data as $data){
				    
				    if($data->type=='festival'){
				        $whatsappPostGet = WhatsappFestivalPost::where('oddek_schedule_id',$data->id)->first();
				    }else{
				        $whatsappPostGet = $whatsappPost::where('oddek_schedule_id',$data->id)->first();
				    }
				    
				    if($whatsappPostGet == null){
				        continue;
				    }
				    
				    $time_post = $data->time_post;
				    $startTime = Carbon::now();
                    $endTime = Carbon::parse(date('Y-m-d h:i a',$time_post));
                
                    $totalDurationRemains = $endTime->diffInMinutes($startTime);
                    
				    if($data->status==2){
				        $status = 'delivered';
				    }else if($data->running==1){
				        $status = 'processing';
				    }else if($data->sent>0){
				        $status = 'processing';
				    }else if($data->failed>0){
				        $status = 'processing';
				    }else{
				        $status = 'queued';
				    }
				    
				    
				    
				    if($whatsappPostGet != null && $totalDurationRemains <= 2){
				        
				        $user = User::where('id', $whatsappPostGet->user_id)->where('status', 1)->first(); 
                        $instance = WhatsappSession::where('user_id', $whatsappPostGet->user_id)->select('instance_id')->orderBy('id', 'desc')->first(); 

                		if($user != null && $instance != null){
                		    
                			$access_token = $user->wa_access_token;
                			$instance_id = $instance->instance_id;
                			
                			$postDataArray = [
                                'instance_id' => $instance_id,
                                'access_token' => $access_token
                            ];
                         
                            $dataQuery = http_build_query($postDataArray);
                            $ch = curl_init();
                      
                      		$wa_url=Option::where('key','oddek_url')->first();
            				$url=$wa_url->value."/api/reconnect.php";
                          
                            $getUrl = $url."?".$dataQuery;
                          
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                            curl_setopt($ch, CURLOPT_URL, $getUrl);
                            curl_setopt($ch, CURLOPT_TIMEOUT, 80);
                               
                            $response = curl_exec($ch);
                            $output = json_decode($response);
                            $err = curl_error($ch);

                			if(isset($output->status) && $output->status != 'success'){
                			    
                			    $updateCampaignStatus = $whatsappPost->updateCampaignStatus($data->id);
                			    
                			    $notificationMsg = 'You have been logout! Your scheduled '.$data->type.' messages has been cancelled.';
                			    $subject = 'Your scheduled messages cancelled!';
                			    
                			    $sendWaMsg = \App\Http\Controllers\CommonMessageController::sendMessage('91'.$user->mobile, $notificationMsg);

                			    if($data->type=='festival'){
            				        WhatsappFestivalPost::where('oddek_schedule_id',$data->id)->update(['delivered_to'=>$data->sent,'failed_to'=>$data->failed,'status'=>'failed']);
            				    }else{
            				        $whatsappPost::where('oddek_schedule_id',$data->id)->update(['delivered_to'=>$data->sent,'failed_to'=>$data->failed,'status'=>'failed']);
            				    }
            				    
            				    $data = [
                                    'name' => $user->name,
                                    'email' => $user->email,
                                    'message' => $notificationMsg,
                                    'subject' => $subject
                                ];
                                
                                dispatch(new \App\Jobs\WaLogoutEmailJob($data));
                                
                                $job = new EmailJob;
                                $job->user_id = $user->id;
                                $job->email = $user->email;
                                $job->subject = $subject;           
                                $job->message = $notificationMsg;
                                $job->save();
                			    
                			    continue;
                			}
                		}
				        
    				    if($whatsappPostGet->count_statistics != null || !empty($whatsappPostGet->count_statistics)){
    				        $statistics = json_decode($whatsappPostGet->count_statistics,true);
    				        if($data->result != null || !empty($data->result)){
    				            $totalSent = count(json_decode($data->result,true));
    				        }
    				    }
				    }
				    
				    $countMain = $countCommon = 0;
				    $count_statistics = '';
				    
				    if($totalSent > 0){
				        
				        if(isset($statistics['main']) && $statistics['main']>0){
            				if($statistics['main'] <= $totalSent){
            					$countMain = $statistics['main'];
            				}else if($statistics['main'] > $totalSent){
            					$countMain = $totalSent;
            				}
            			}
            			
            			if(isset($statistics['common']) &&  $statistics['common']>0){
            				if($statistics['common'] <= $totalSent){
            					$countCommon = $totalSent - $countMain;
            					if($countCommon > $statistics['common']){
            					    $countCommon = $statistics['common'];
            					}
            				}else if($statistics['common'] > $totalSent){
            					$countCommon = $totalSent - $countMain;
            				}
            			}
				        
				        $count_statistics = json_encode(['main'=>$countMain,'common'=>$countCommon]);
				    }
				    
				    if($status !='queued'){
    				    if($data->type=='festival'){
    				        WhatsappFestivalPost::where('oddek_schedule_id',$data->id)->update(['delivered_to'=>$data->sent,'failed_to'=>$data->failed,'status'=>$status,'delivered_numbers'=>$data->result,'count_statistics_realtime'=>$count_statistics]);
    				    }else{
    				        $whatsappPost::where('oddek_schedule_id',$data->id)->update(['delivered_to'=>$data->sent,'failed_to'=>$data->failed,'status'=>$status,'delivered_numbers'=>$data->result,'count_statistics_realtime'=>$count_statistics]);
    				    }
				    }
				    
				    if($data->status==2){
				        $updateCampaignStatus = $whatsappPost->updateCampaignStatus($data->id);
				    }
				    
				}
			}
		}
        return 0;
    }
}
