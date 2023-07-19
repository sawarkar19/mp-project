<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\BizSmsReport;
use Carbon\Carbon;


class StoreSMSReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $output;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($output)
    {
        //
        $this->output = $output;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $datas=explode("~", $this->output);
        if($datas[0]!=""){
            $BizSmsReport=BizSmsReport::where('number','=',$datas[1])->where('shoot_date','=',$datas[3])->where('send_date','=',$datas[4])->first();
            if($BizSmsReport==null){
                $record = array(
                    'message' =>$datas[0],
                    'number' =>$datas[1],
                    'stage' =>$datas[2],
                    'shoot_date' =>$datas[3],
                    'send_date' =>$datas[4],
                    'status' =>$datas[5],
                    'created_at' =>Carbon::now(),
                    'updated_at' =>Carbon::now()
                );
                BizSmsReport::insert($record); 
            }   
        } 
       
    }
}
