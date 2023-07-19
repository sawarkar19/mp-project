<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Option;
use Illuminate\Http\Request;
use App\Models\WhatsappSession;
use App\Http\Controllers\Controller;
use App\Jobs\NotifyWhatsappDisconnectedJob;

class WaApiController extends Controller
{
    private $wa_info_api;
    private $wa_text_message_api;
    private $wa_instance_info_api_url;
    private $wa_register_api;

    public function __construct()
    {
        $wa_api_data = Option::where('key','wa_api_url')->first();
        
        $this->wa_register_api = $wa_api_data->value."/user/register";
        $this->wa_info_api = $wa_api_data->value."/user/info";
        $this->wa_text_message_api = $wa_api_data->value."/message/text";
        $this->wa_instance_info_api_url = $wa_api_data->value."/instance/info";
        $this->wa_text_doc_message_api = $wa_api_data->value."/message/doc";
    }

    
    // Register old users in WA Post API
    public function oldUserRegister(Request $request){
        $getUserIds = User::where('role_id', 2)->where('status', 1)->pluck('id')->toArray();
        
        $userIds = [];
        foreach ($getUserIds as $key => $user_id) {
            $user = User::find($user_id);
            $wa_session = WhatsappSession::where('user_id', $user_id)->first();

            if($wa_session == null || ($wa_session->key_id == '' && $wa_session->key_secret == '')){
                $api_data = [
                    'email' => $user->email,
                    'mobile' => $user->mobile,
                    'name' => $user->name,
                    'partner_key' => 'PRT-0IDR245P',
                    'partner_id' => 3,
                ];
    
                $info_output = $this->waUserInfo($api_data);
                
                if($info_output['status']==true && isset($info_output['data']['key_id']) && $info_output['data']['key_id']!="" && isset($info_output['data']['key_secret']) && $info_output['data']['key_secret']!="")
                {
    
                    $key_id = $info_output['data']['key_id'] ?? NULL;
                    $key_secret = $info_output['data']['key_secret'] ?? NULL;
    
                    $wa_session = WhatsappSession::where('user_id', $user->id)->first();
                    if ($wa_session == null) {
                        $wa_session = new WhatsappSession();
                        $wa_session->user_id = $user->id;
                    }
                    $wa_session->key_id = $key_id;
                    $wa_session->key_secret = $key_secret;
                    $wa_session->save();
                }
                else{
                    $data = http_build_query($api_data);
                    $wa_register_api_url = $this->wa_register_api."?".$data;
    
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                    curl_setopt($ch, CURLOPT_URL, $wa_register_api_url);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 80);
                    
                    $response = curl_exec($ch);
                    $err = curl_error($ch);
                    $output = json_decode($response, true);
    
                    if(isset($output['error']) && $output['error']==true){
                        // $this->suspendCustomer($user->id);
                    }
                    else{
                        if (isset($output['error']) && $output['error'] == true) {
                            $info_output = $this->waUserInfo($api_data);
    
                            if($info_output['status'] == true){
    
                                $key_id = $info_output['data']['key_id'] ?? NULL;
                                $key_secret = $info_output['data']['key_secret'] ?? NULL;
    
                                $wa_session = WhatsappSession::where('user_id', $user->id)->first();
                                if ($wa_session == null) {
                                    $wa_session = new WhatsappSession();
                                    $wa_session->user_id = $user->id;
                                }
                                $wa_session->key_id = $key_id;
                                $wa_session->key_secret = $key_secret;
                                $wa_session->save();
    
                                return ["status" => true, "data" => $info_output['data']];
                            }else{
                                return ["status" => false];
                            }
                        } else {
    
                            $key_id = $output['data']['key_id'] ?? NULL;
                            $key_secret = $output['data']['key_secret'] ?? NULL;
    
                            $wa_session = WhatsappSession::where('user_id', $user->id)->first();
                            if ($wa_session == null) {
                                $wa_session = new WhatsappSession();
                                $wa_session->user_id = $user->id;
                            }
                            $wa_session->key_id = $key_id;
                            $wa_session->key_secret = $key_secret;
                            $wa_session->save();
    
                            return ["status" => true, "data" => $output['user']];
                        }
                    }
                }

                    $data = [
                        'day' => 'today',
                        'user' => $user,
                    ];

                    if(!empty($data)){
                        dispatch(new NotifyWhatsappDisconnectedJob($data));
                    }
                    $userIds[] = $user->id; 
            } 
        }
        
        WhatsappSession::whereIn('user_id', $userIds)->update(['instance_id'=> NULL, 'status'=>'lost']);
        
        dd('Registration Completed.');
    } 

    /* API For Registration */
    public function waRegistration($api_data = []){
        // dd($api_data);

        if(!empty($api_data)){
            //API call to get whatsapp key_id and key_secret                       
            $data = http_build_query($api_data);
            $ch = curl_init();
            
            $wa_register_api_url = $this->wa_register_api."?".$data;
            
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_URL, $wa_register_api_url);
            curl_setopt($ch, CURLOPT_TIMEOUT, 80);
                
            $response = curl_exec($ch);
            $err = curl_error($ch);

            $output = json_decode($response, true);
            
            if (isset($output['error']) && $output['error'] == true) {
                
                $info_output = $this->waUserInfo($api_data);

                if($info_output['status'] == true){
                    return ["status" => true, "data" => $info_output['data']];
                }else{
                    return ["status" => false];
                }
            } else {
                return ["status" => true, "data" => $output['user']];
            }
        }else{
            return ["status" => false];
        }
    } 

    public function waUserInfo($api_data = []){
        $data = http_build_query($api_data);
        $ch = curl_init();

        $wa_info_api_url = $this->wa_info_api."?".$data;
        
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $wa_info_api_url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 80);
            
        $info_response = curl_exec($ch);
        $err = curl_error($ch);

        $info_output = json_decode($info_response, true);

        if(isset($info_output['error']) && $info_output['error'] == false){
            return ["status" => true, "data" => $info_output['user']];
        }else{
            return ["status" => false];
        }
    }


    public function generateBulkKeys(){
        $users = User::where('role_id', 2)->get();
        foreach($users as $user){
            $api_data = [
                'email' => $user->email,
                'mobile' => $user->mobile,
                'name' => $user->name,
                'partner_key' => 'PRT-0IDR245P',
                'partner_id' => 3,
            ];
            $wa_registration = $this->waRegistration($api_data);

            if($wa_registration["status"] == true && !empty($wa_registration["data"])){
                $wa_session = WhatsappSession::where('user_id', $user->id)->first();
                if(!$wa_session){
                    $wa_session = new WhatsappSession;
                    $wa_session->user_id = $user->id;
                }
                $wa_session->key_id = $wa_registration["data"]["key_id"];
                $wa_session->key_secret = $wa_registration["data"]["key_secret"];
                $wa_session->save(); 

                // Log::debug($user->id);
            }
            
        }

        // dd($users);
    }

    public function waInstanceInfo($instance_id = ''){
        $ch = curl_init();

        $wa_instance_info_api_url = $this->wa_instance_info_api_url."?key=".$instance_id;
        
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $wa_instance_info_api_url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 80);
            
        $info_response = curl_exec($ch);
        $err = curl_error($ch);

        $info_output = json_decode($info_response, true);

        if(isset($info_output['error']) && $info_output['error'] == false){
            return ["status" => true, "data" => $info_output];
        }else{
            return ["status" => false];
        }
    }


    public function sendWaTextMsg($api_data = []){
        
        if($api_data['wa_session'] != '' && $api_data['wa_session']['instance_id'] != ''){
            $url = $this->wa_text_message_api."?key=".$api_data['wa_session']['instance_id'];

            $params = [
                'id' => $api_data['mobile'],
                'message' => $api_data['whatsapp_msg'] ?? $api_data['message']
            ]; 
            $params = http_build_query($params);

            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $params,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
            ),
            ));

            $response = curl_exec($curl);
            $output = json_decode($response, true);
            $err = curl_error($curl);
            curl_close($curl);

            if(isset($output['error']) && $output['error'] == false){
                return ["status" => true, "message" => "Message sent successfully!", "data" => $output];
            }else{
                return ["status" => false, "message" => "Failed to send message!", "data" => $err];
            }

        }else{
            return ["status" => false, "message" => "Failed to send message!", "data" => []];
        }
        
    }

    public function sendWaTextDocMsg($api_data=[]){
        if($api_data['wa_session'] != '' && $api_data['wa_session']['instance_id'] != ''){
            $url = $this->wa_text_doc_message_api."?key=".$api_data['wa_session']['instance_id'];

            $file_server_path = realpath($api_data['pdf']);

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'id' => $api_data['mobile'],
                    'filename' => $api_data['filename'],
                    'message' => $api_data['message'],
                    'file'=> new \CURLFILE($file_server_path)
                ),
            ));

            $response = curl_exec($curl);
            // dd($response, $url, $api_data, $curl);

            $output = json_decode($response, true);
            $err = curl_error($curl);
            curl_close($curl);

            if(isset($output['error']) && $output['error'] == false){
                return ["status" => true, "message" => "Message sent successfully!", "data" => $output];
            }else{

                $connection = $this->waUserInfo($api_data);
                if($connection['status'] == false){
                    $this->updateToken($api_data);
                }

                $user = User::find($api_data['user_id']);
                $redirectURL = route('enterpriseUserDetail', $user->enterprise_info_token);
                $data['redirect_url'] = $redirectURL;
                
                return ["status" => false, "message" => "Failed to send message!", "data" => $data];
            }
        }else{
            $connection = $this->waUserInfo($api_data);
            if($connection['status'] == false){
                $this->updateToken($api_data);
            }

            $user = User::find($api_data['user_id']);

            $redirectURL = route('enterpriseUserDetail', $user->enterprise_info_token);
            $data['redirect_url'] = $redirectURL;

            return ["status" => false, "message" => "Failed to send message!", "data" => $data];
        }
    }


    public function updateToken($api_data = []){ 
        $wa_session = WhatsappSession::where('user_id', $api_data['user_id'])->first();
        $wa_session->instance_id = '';
        $wa_session->save();

        $userDetail = User::find($api_data['user_id']);

        $data = [
            'day' => 'today',
            'user' => $userDetail,
        ];
    
        dispatch(new NotifyWhatsappDisconnectedJob($data));
    }

    public function getRandomCode($char = 8)
    {
        $string = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomCode = '';
        for ($i = 0; $i < $char; $i++) {
            $index = rand(0, strlen($string) - 1);
            $randomCode .= $string[$index];
        }

        return $randomCode;
    }


    // suspendCustomer if User not register from olduser-register-wapost
    public function suspendCustomer($user_id=0){
        $user = User::find($user_id);
        $user->mobile = '0123456789';
        $user->email = 'user.suspended.'.$user->id.'@mouthpublicity.io';
        $user->social_post_api_token = $user->social_post_api_token.$user->id;
        $user->status = 2;
        $user->logout_user = 1;
        
        if($user->save()){

            $employeeIds = User::where('created_by', $user->id)->pluck('id')->toArray();

            if(!empty($employeeIds)){
                foreach($employeeIds as $employeeId){
                    $employee = User::find($employeeId);
                    $employee->mobile = '0123456789';
                    $employee->status = 2;
                    $employee->logout_user = 1;
                    $employee->save();
                }
            }

            return response()->json(['status' => true]);
        }else{
            return response()->json(['status' => false]);
        }
    }

}