<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SalesroboController extends Controller{

    public function __construct()
    {
        $this->middleware('guest');
    }

    // public function sr_submit_basepath(){
    //     /* set basepath of the salesrobo api (form submit URL) */
    //     return "https://c.com/form/submit";
    // }

    static function send_form_data($form_id, $array_data){
        // dd($form_id);
        $sr_submit_basepath = "https://mp.salesrobo.com/form/submit";

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $sr_submit_basepath.'?formId='.$form_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $array_data,
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        // Log::debug($response);
        return $response;
    }
}
