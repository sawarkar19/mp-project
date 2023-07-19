<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappPost extends Model
{
    use HasFactory;

    public function callOddekApi($url,$data){
    	//init the resource
		$ch = curl_init();
		curl_setopt_array($ch, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => $data
		));

		//Ignore SSL certificate verification
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

		//Get response
		$response = curl_exec($ch);
		$output = json_decode($response);
		curl_close($ch);
		return $output;
    }
	
	public function createContactGroup($instance_id,$uuid){
		//API call to check whatsapp status                       
		$postData = array(
			'instance_id' => trim($instance_id),
			'name' => trim($uuid)
		);
		$data = json_encode($postData);
		//API URL
		$wa_url=Option::where('key','oddek_url')->first();
        $url=$wa_url->value."/api/createContactGroup.php";

		//running oddek api
		$output = $this->callOddekApi($url,$data);
		return $output;
	}
	
	public function updateContact($team_id,$group_id,$mobile_numbers){
		//API call to check whatsapp status                       
		$postData = array(
			'team_id' => trim($team_id),
			'group_id' => trim($group_id),
			'phone' => $mobile_numbers
		);
		$data = json_encode($postData);
		//API URL
		$wa_url=Option::where('key','oddek_url')->first();
        $url=$wa_url->value."/api/updateContacts.php";

		//running oddek api
		$output = $this->callOddekApi($url,$data);
		return $output;
	}
	
	public function scheduleCampaign($team_id,$group_id,$instance_id,$time_post,$message,$type,$attachmentUrl=''){
		//API call to check whatsapp status                       
		$postData = array(
			'team_id' => trim($team_id),
			'group_id' => trim($group_id),
			'instance_id' => trim($instance_id),
			'time_post' => $time_post,
			'message' => $message,
			'type' => $type,
			'attachment_url' => $attachmentUrl
		);
		$data = json_encode($postData);
		//API URL
		$wa_url=Option::where('key','oddek_url')->first();
        $url=$wa_url->value."/api/scheduleCampaign.php";

		//running oddek api
		$output = $this->callOddekApi($url,$data);
		return $output;
	}
	
	
	public function updateCampaign($schedule_id,$time_post,$message,$attachmentUrl=''){
		//API call to check whatsapp status                       
		$postData = array(
			'schedule_id' => trim($schedule_id),
			'time_post' => $time_post,
			'message' => $message,
			'attachment_url' => $attachmentUrl
		);
		$data = json_encode($postData);
		//API URL
		$wa_url=Option::where('key','oddek_url')->first();
        $url=$wa_url->value."/api/updateCampaign.php";

		//running oddek api
		$output = $this->callOddekApi($url,$data);
		return $output;
	}
	
	public function deleteCampaign($schedule_id){
		//API call to check whatsapp status                       
		$postData = array(
			'schedule_id' => trim($schedule_id)
		);
		$data = json_encode($postData);
		//API URL
		$wa_url=Option::where('key','oddek_url')->first();
        $url=$wa_url->value."/api/deleteCampaign.php";

		//running oddek api
		$output = $this->callOddekApi($url,$data);
		return $output;
	}
	
	public function checkDelivered(){
		//API URL
		$wa_url=Option::where('key','oddek_url')->first();
        $url=$wa_url->value."/api/checkDeliveredCampaign.php";

		//init the resource
		$ch = curl_init();
		curl_setopt_array($ch, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => false
		));

		//Ignore SSL certificate verification
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

		//Get response
		$response = curl_exec($ch);
		$output = json_decode($response);
		curl_close($ch);
		return $output;
	}
	
	public function checkProcessed(){
		//API URL
		$wa_url=Option::where('key','oddek_url')->first();
        $url=$wa_url->value."/api/checkProcessedCampaign.php";

		//init the resource
		$ch = curl_init();
		curl_setopt_array($ch, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => false
		));

		//Ignore SSL certificate verification
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

		//Get response
		$response = curl_exec($ch);
		$output = json_decode($response);
		curl_close($ch);
		return $output;
	}
	
	public function uploadAttachment($attachment){
		//API call to check whatsapp status     
		$tmpfile = $attachment['file']['tmp_name'];
		$filename = basename($attachment['file']['name']);                  
		$data = array(
		    'file' => curl_file_create($tmpfile, $attachment['file']['type'], $filename)
		); 
		//API URL
		$wa_url=Option::where('key','oddek_url')->first();
        $url=$wa_url->value."/api/uploadAttachment.php";

		//init the resource
		$ch = curl_init();
		curl_setopt_array($ch, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => $data
		));

		//Ignore SSL certificate verification
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

		//Get response
		$response = curl_exec($ch);
		$output = json_decode($response);
		curl_close($ch);
		return $output;

	}
	
	public function updateCampaignStatus($schedule_id){
		$postData = array(
			'schedule_id' => trim($schedule_id)
		);
		
		$data = json_encode($postData);
		$wa_url=Option::where('key','oddek_url')->first();
        $url=$wa_url->value."/api/updateCampaignStatus.php";

		$output = $this->callOddekApi($url,$data);
		return $output;
	}

	public function checkOutdatedMedia(){
		//API URL
		$wa_url=Option::where('key','oddek_url')->first();
        $url=$wa_url->value."/api/unlinkMedia.php";

		//init the resource
		$ch = curl_init();
		curl_setopt_array($ch, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => false
		));

		//Ignore SSL certificate verification
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

		//Get response
		$response = curl_exec($ch);
		$output = json_decode($response);
		curl_close($ch);
		return $output;
	}
	
}
