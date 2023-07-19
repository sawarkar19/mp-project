<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Customer;
use App\Jobs\SendPostMessageJob;
use App\Models\WhatsappPost;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class SendD2CPost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:d2cPost';

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
    public function handle()
    {
		
		$getQueuedPosts = WhatsappPost::where('status','queued')
		->whereDate('schedule_date', date('Y-m-d'))
		->get();
		
		if(!empty($getQueuedPosts)){
			
			foreach($getQueuedPosts as $post){
				
				$user = User::where('users.id', $post->user_id)->where('status', 1)->join('whatsapp_sessions', 'users.id', '=', 'whatsapp_sessions.user_id')->orderBy('whatsapp_sessions.id', 'desc')->first();
				
				WhatsappPost::where('id',$post->id)->update(['status'=>'processing']);
				
				$customer_ids = explode(',',$post->shared_to);
				
				$total_customers =  Customer::whereIn('customers.id',$customer_ids)
				->join('business_customers', 'customers.id', '=', 'business_customers.customer_id')
				->where('business_customers.business_id',$post->user_id)
				->get();		
				
				$deliveredCustomers = '';
				if(!empty($total_customers)){
					foreach($total_customers as $customer){
						
						$number = 91;
						$number .= $customer->mobile;
						$message = $post->whatsapp_content;

						$message = str_replace("[mobile]",$customer->mobile,$message);

						if(isset($customer->name) && $customer->name != ''){
							$message = str_replace("[name]",$customer->name,$message);
						}else{
							$message = str_replace("[name]",'Dear',$message);
						}
							
						$data = [
							'mobile' => $number,
							'message' => $message,
							'instance_id' => $user->instance_id,
							'access_token' => $user->wa_access_token,
							'post_id' => $post->id,
							'customer_id' => $customer->customer_id,
						];
						
						//SendPostMessageJob::dispatch($data)->delay(now()->addMinutes(2));
						SendPostMessageJob::dispatch($data);
						//$deliveredCustomers .= $customer->customer_id.',';
						
						sleep(60);
						
					}
				}
				
				WhatsappPost::where('id',$post->id)->update(['status'=>'delivered']);
			}
		}
    }
}
