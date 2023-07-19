<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Option;
use App\Jobs\StoreSMSReportJob;

class BizSMSReportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'biz:smsreport';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To get reports from BIZ SMS ';

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
        $startdate=date('Y-m-d').' 00:00:01';
        $enddate=date('Y-m-d').' 23:59:59';
        $this->smsoptions=Option::where('key','sms_gateway')->first();
        $this->smsurl=json_decode($this->smsoptions->value)->url."/SMS_API/getreports.php";
        $this->smsusername = json_decode($this->smsoptions->value)->username;
        $this->smspassword = json_decode($this->smsoptions->value)->password;
        $postDaVal = [
                    'username' => $this->smsusername,
                    'password' => $this->smspassword,
                    'FromDate' => $startdate,
                    'toDate' => $enddate
                ];
        $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL => $this->smsurl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $postDaVal
                //,CURLOPT_FOLLOWLOCATION => true
            ));

            //Ignore SSL certificate verification
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            //Get response
            $output = curl_exec($ch);
            $outputs = explode("<br/>", $output);
            //dump($outputs);
            foreach($outputs as $output){
                $outputss = explode("~", $output);
                if($outputss[0]!=""){
                    dispatch(new StoreSMSReportJob($output));
                }
                //dispatch(new StoreSMSReportJob($output));
            }
    }
}
