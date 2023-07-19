<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\WhatsappPost;

class CheckDelivered extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:delivered';

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
		$checkDelivered = $whatsappPost->checkDelivered(); //dd($checkDelivered);
		if($checkDelivered->status){
			if(isset($checkDelivered->data) && !empty($checkDelivered->data)){
				foreach($checkDelivered->data as $data){
					$whatsappPost::where('oddek_schedule_id',$data->id)->update(['delivered_to'=>$data->sent,'failed_to'=>$data->failed,'status'=>'delivered']);
				}
			}
		}
        return 0;
    }
}
