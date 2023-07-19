<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\WhatsappPost;
use Illuminate\Support\Facades\Log;

use App\Models\Option;

class SendPostMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	private $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
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
        $postDataArray = [
            'number' => $this->data['mobile'],
            'type' => 'text',
            'message' => $this->data['message'],
            'instance_id' => $this->data['instance_id'],
            'access_token' => $this->data['access_token']
        ];
		//Log::info(print_r($postDataArray, true));
     
	 
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
		
		//Log::info(print_r($output, true));
		
		$whatsappPost = WhatsappPost::find($this->data['post_id']);
		if(isset($output->status) && $output->status == 'success'){
			if(empty($whatsappPost->delivered_to)){
				$whatsappPost->delivered_to = $whatsappPost->delivered_to.''.$this->data['customer_id'];
			}else{
				$whatsappPost->delivered_to = $whatsappPost->delivered_to.','.$this->data['customer_id'];
			}
		}else{
			if(empty($whatsappPost->failed_to)){
				$whatsappPost->failed_to = $whatsappPost->failed_to.''.$this->data['customer_id'];
			}else{
				$whatsappPost->failed_to = $whatsappPost->failed_to.','.$this->data['customer_id'];
			}
		}
		$whatsappPost->save();
		
        /*if ($err) { 
            $this->handle();
        } else { 
            if($output == null || $output->status == 'error'){
                $this->handle();
            }
        }*/
    }
}
