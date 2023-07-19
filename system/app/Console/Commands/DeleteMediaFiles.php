<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\WhatsappPost;
use App\Models\WhatsappFestivalPost;
use App\Models\WhatsappTemplate;

class DeleteMediaFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:media';

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
        $outDatedMedia = $whatsappPost->checkOutdatedMedia();
        if($outDatedMedia != null && $outDatedMedia->status && !empty($outDatedMedia->data)){
            
            foreach($outDatedMedia->data as $post){
                
                if($post->type=='festival'){
                    $whatsappPostGet = WhatsappFestivalPost::where('oddek_schedule_id',$post->id)->first();
                }else{
                    $whatsappPostGet = $whatsappPost::where('oddek_schedule_id',$post->id)->first();
                }
                
                if($whatsappPostGet == null){
                    continue;
                }else{
                    
                    if($post->type=='festival'){
                        $whatsappTemplate = WhatsappTemplate::where('user_id',$whatsappPostGet->user_id)->where('template_type','festival')->latest()->first();
                        $whatsappTemplate->attachment_url = '';
                        $whatsappTemplate->save();
                    }
                
                    $whatsappPostGet->attachment_url = '';
                    $whatsappPostGet->save();
                    
                }
                
                
                
            }
        }
        return 0;
    }
}
