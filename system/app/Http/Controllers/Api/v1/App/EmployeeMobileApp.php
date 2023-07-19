<?php

namespace App\Http\Controllers\Api\v1\App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Controllers\WhatsAppApiController;
use App\Http\Controllers\WhatsAppMsgController;
use App\Http\Controllers\Business\CommonSettingController;
use App\Http\Controllers\UuidTokenController;
use App\Http\Controllers\ShortLinkController;
use App\Http\Controllers\CommonMessageController;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\UserLogin;
use App\Models\Userplan;
use App\Models\Offer;
use Carbon\Carbon;
use App\Models\Redeem;
use App\Models\RedeemDetail;
use App\Models\OfferSubscription;
use App\Models\WhatsappSession;
use App\Models\Target;
use App\Models\OfferTemplate;
use App\Models\OfferFuture;
use App\Models\BusinessDetail;
use App\Models\Customer;
use App\Models\EmployeeDetail;
use App\Models\BusinessCustomer;
use App\Models\ShortLink;
use App\Models\Userotp;
use Validator;

use Hash;
use URL;
use Session;

class EmployeeMobileApp extends Controller
{
    //

    public function login(Request $request){

        if(is_numeric($request->mobile)){
            if(strlen($request->mobile)<10){
                return json_encode(array("status"=>"error", "message"=>"Mobile number length should be 10."));
            }else{
                $user = User::where('mobile', $request->mobile)->where('role_id',3)->first();
                $username = 'mobile number';
            }   
        }else{
            return json_encode(array("status"=>"error", "message"=>"Please Enter Valid Mobile number"));
        }

        $remember_me = $request->has('remember') ? true : false;

        if($user == null){
            return json_encode(array("status"=>"error", "message"=>"Opps the ".$username." not exists...!!"));
        }else{
            if(is_numeric($request->mobile)){
                
                
                if (Auth::attempt(['mobile' => $request->mobile, 'password' => $request->password], $remember_me)){
                    $existingUser = User::where('mobile', $request->mobile)->first();
                    
                    if($existingUser->status != 1){
                        Auth::logout();
                        return json_encode(array("status"=>"error", "message"=>"Your Account is Not Active!"));
                    }
                    
                    if($existingUser->role_id==3){
                        
                        $created_by = $existingUser->created_by;
                        
                        $employer = User::find($created_by);
                        
                        if($employer->status != 1){
                            Auth::logout();
                            return json_encode(array("status"=>"error", "message"=>"Your Employer Account is Not Active!"));                      
                        }
                        
                        $purchaseHistory = Userplan::join('plan_features', 'userplans.feature_id', '=', 'plan_features.id')->where('plan_features.slug','employee_account')->where('userplans.user_id',$created_by)->count();
                        
                        $checkExpiryCondition = Userplan::join('plan_features', 'userplans.feature_id', '=', 'plan_features.id')->where('plan_features.slug','employee_account')->where('userplans.user_id',$created_by)->where('userplans.status',1)->whereDate('will_expire_on', '>=', \Carbon\Carbon::now())->count();
                        
                        if($purchaseHistory==1 && $checkExpiryCondition==0){
                            Auth::logout();
                            return json_encode(array("status"=>"error", "message"=>"Your Employees Plan Has Expired!"));
                        }
                
                    }
                            
                    if(Auth::loginUsingId($existingUser->id)){ 
                        $user = Auth::User();
                        $this->getAndUpdateLoginStatus($user->id,$request->password);
                        if($user->role_id == 2){
                            $this->putSession($existingUser->id);                        
                        }            
                    }
                    
                    auth()->login($user, true);

                    $data = array();
                    $details = BusinessDetail::where('user_id', $employer->id)
                    ->first();
                    
                    $businessLogo = !empty($details->logo) ? asset('assets/business/logos').'/'.$details->logo : '';
                    $profilePic = !empty($user->profile_pic) ? asset('assets/employee').'/'.$user->profile_pic : '';
                    
                    $share_count = OfferSubscription::where('created_by', $existingUser->id)->count();
                    $redeem_count = RedeemDetail::where('redeem_by',$existingUser->id)->count();
                    
                    $data = (object)[
                        'business_id' => $employer->id,
                        'name' => $user->name,
                        'owner_name' => $employer->name,
                        'owner_email' => $employer->email,
                        'business_name' => $details->business_name,
                        'tag_line' => $details->tag_line,
                        'logo' => $businessLogo,
                        'profile_pic' => $profilePic,
                        // 'whatsapp' => $details->whatsapp_number,
                        'call_number' => $details->call_number,
                        'state' => $details->state,
                        'city' => $details->city,
                        'area' => $details->area,
                        'pincode' => $details->pincode,
                        'address_line_1' => $details->address_line_1,
                        'address_line_2' => $details->address_line_2,
                        'website' => $details->website,
                        'share_count' => $share_count,
                        'redeem_count' => $redeem_count
                    ];
                    
                    #Auth::logoutOtherDevices($request->password);
                    
                    // return json_encode(array("status"=>"success","user_id"=>$existingUser->id,"business_details"=>$data,"message"=>"User logged in successfully."));
                    return response()->json(["status"=>"success","user_id"=>$existingUser->id,"business_details"=>$data,"message"=>"User logged in successfully."]);
                }else{
                    return json_encode(array("status"=>"error", "message"=>"User credentials not match!"));
                }
            }
        }
    }
    
    public function sendOtp(Request $request){
        
        $user = User::where('mobile',$request->mobile)->first();

        if($user==null){
            
            echo json_encode(array("status"=>"error", "message"=>"Mobile number not exists!"));

        }else{

            $number = $request->mobile;
            $otp = rand(100000, 999999);
            $username = 'openlink';
            $password = 'KHdZFvJrMQDT';
            $sendername = 'OPNLNK';
            $message = $otp." is your OpenLink account verification code.";
            $routetype = "1";

            //$msg = \App\Http\Controllers\CommonMessageController::sendOtpMsg('91'.$request->mobile, $otp); dd($msg);
            
            $postData = array(
                'username' => $username,
                'password' => $password,
                'mobile' => $number,
                'sendername' => $sendername,
                'message' => $message,
                'routetype' => $routetype,
            );

            //API URL
            $url="http://logic.bizsms.in/SMS_API/sendsms.php";

            //init the resource
            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $postData
                //,CURLOPT_FOLLOWLOCATION => true
            ));


            //Ignore SSL certificate verification
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


            //Get response
            $output = curl_exec($ch);

            //Print error if any
            if(curl_errno($ch))
            {
                //echo 'error:' . curl_error($ch);
            }

            curl_close($ch);

            /*
            DB::table('ip_users')
            ->insert([
                'user_ip' => $clientIP,
                'mobile' => $number,
                'date' => Carbon::today(),
                'is_sent' => 1
            ]);*/
            
            $existingOtp = Userotp::where('number',$number)->where('user_id',$user->id)->first();
            
            if($existingOtp != null){
                $existingOtp->delete();
            }
            
            $otpObj = new Userotp;
            $otpObj->user_id = $user->id;
            $otpObj->number = $number;
            $otpObj->otp = $otp;
            $otpObj->save();

            echo json_encode(array("status"=>"success","message"=>"OTP sent on your number."));
        }
    }
    
    public function verifyOtp(Request $request){
        $newDateTime = Carbon::now()->addMinute(2);
        $checkOtp = Userotp::where('number',$request->mobile)->where('otp',$request->otp)->first();
        if($checkOtp != null){
            
            $newDateTime = Carbon::now()->addMinute(2);
            $startTime = carbon::parse($checkOtp->created_at);
            $totalDurationRemains = $newDateTime->diffInMinutes($startTime);
            if($totalDurationRemains <= 2){
                echo json_encode(array("status"=>"success","user_id"=>$checkOtp->user_id,"message"=>"OTP successfully verified!"));
            }else{
                echo json_encode(array("status"=>"error","message"=>"OTP has been expired!"));
            }
        }else{
            echo json_encode(array("status"=>"error","message"=>"OTP did not matched!"));
        }
    }
    
    public function resetPassword(Request $request){
        $validator = Validator::make($request->all(),[
            'password' => 'required|min:8',
            'confirm_password' => 'required|min:8|same:password'
        ]);
        
        if($validator->passes()){
            User::where('id', $request->user_id)->update(['password' => Hash::make($request->password)]);
            return response()->json(["status"=>"success", "message"=>"Password successfully changed!"]);
        }else{
            return response()->json(["status"=>"error", "message"=>$validator->errors()->all()]);
        }
    }
    
    public function changePassword(Request $request){
        $validator = Validator::make($request->all(),[
            'old_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|min:8|same:new_password'
        ]);
        
        if($validator->passes()){
            $user = User::where('id', $request->user_id)->first();
            if ((Hash::check($request->old_password, $user->password)) == false) {
                return response()->json(["status"=>"success", "message"=>"Old password not matched!"]);
            }else{
                User::where('id', $request->user_id)->update(['password' => Hash::make($request->new_password)]);
                return response()->json(["status"=>"success", "message"=>"Password successfully changed!"]);
            }
        }else{
            return response()->json(["status"=>"error", "message"=>$validator->errors()->all()]);
        }
    }

    public function getAndUpdateLoginStatus($userId, $password){
        $getLoginStatus = UserLogin::where('user_id',$userId)
                        ->where('is_login', '1')
                        ->orderBy('id','desc')
                        ->first();
        if($getLoginStatus != null)
        { 
            Auth::logoutOtherDevices($password);

            $getLoginStatus['is_login'] = '0';
            $getLoginStatus->save();

            $loginInfo = new UserLogin();
            $loginInfo->user_id = $userId;
            $loginInfo->is_login = '1';
            // dd($loginInfo);
            $loginInfo->save();

        } else {
            $loginInfo = new UserLogin();
            $loginInfo->user_id = $userId;
            $loginInfo->is_login = '1';
            // dd($loginInfo);
            $loginInfo->save();
        }
    }
    
    public function putSession($id){
        session(['key' => 'value']);
    }
    
    public function getProfileData($userid){
        
        $user = User::where('id',$userid)->first();
        
        if($user==null){
            return json_encode(array("status"=>"error", "message"=>"User not found!"));
        }
        
        $profile_pic = !empty($user->profile_pic) ? url('/').'/assets/employee/'.$user->profile_pic : '';
        
        $profileData['name'] = $user->name;
        $profileData['mobile'] = $user->mobile;
        $profileData['email'] = $user->email;
        $profileData['dob'] = $user->employee_details->dob;
        $profileData['blood_group'] = $user->employee_details->blood_group;
        $profileData['address'] = $user->employee_details->address;
        $profileData['pincode'] = $user->employee_details->pincode;
        $profileData['city'] = $user->employee_details->city;
        $profileData['state'] = $user->employee_details->state;
        $profileData['country'] = $user->employee_details->country;
        $profileData['profile_pic'] = $profile_pic;
        
        return json_encode(array("status"=>"success", "data"=>$profileData));
    }
    
    public function updateProfileData(Request $request){

        if(isset($request->user_id) && !empty($request->user_id)){
            
            $user = User::where('id',$request->user_id)->first();
        
            if($user==null){
                return json_encode(array("status"=>"error", "message"=>"User not found!"));
            }else{
                
                $attachment_url = '';
                $fileName = '';

                if(isset($_FILES['profile']) && !empty($_FILES['profile']['tmp_name'])){
                    
                    $validator = Validator::make($request->all(), [
                        'profile' => 'required|image|mimes:jpeg,jpg,png|max:2048',
                    ]);
                    
                    if($validator->passes()){
                        $fileName = time().'.'.$request->profile->extension();
                        $upload_path = base_path('../assets/');
                        $path = $request->file('profile')->move(
                             $upload_path.'/employee/', $fileName
                        );
                        $attachment_url = url('/').'/assets/employee/'.$fileName;
                    }else{
                        return response()->json(["status"=>"error", "message"=>$validator->errors()->all()]);
                    }
                }
                
                $user->name = $request->name;
                if(!empty($fileName))
                    $user->profile_pic = $fileName;
                $user->save();
                
                $employeeDetails = EmployeeDetail::where('user_id',$request->user_id)->first();
                $employeeDetails->dob = $request->dob;
                $employeeDetails->blood_group = $request->blood_group;
                $employeeDetails->address = $request->address;
                $employeeDetails->pincode = $request->pincode;
                $employeeDetails->city = $request->city;
                $employeeDetails->state = $request->state;
                $employeeDetails->country = $request->country;
                $employeeDetails->save();
                
                return json_encode(array("status"=>"success", "message"=>"Profile updated successfully!"));
            }
            
        }else{
            return json_encode(array("status"=>"error", "message"=>"Please enter User id!"));
        }
    }
    
    public function getOffersByType($type,$userid){
        
        $date_time = Carbon::now();
        
        if($type=='all'){
            $offers = Offer::where('user_id',$userid)->get();
        }else if($type=='active'){
            $offers = Offer::where('user_id',$userid)->whereDate('end_date','>=',$date_time)->get();
        }else if($type=='expired'){
            $offers = Offer::where('user_id',$userid)->whereDate('end_date','<',$date_time)->get();
        }

        if($offers == null || $offers->isEmpty()){
            return json_encode(array("status"=>"error", "message"=>"Offers not found!"));
        }
        
        $offerArray = [];
        foreach($offers as $offer){
            $subArr['offer_id'] = $offer->id;
            $subArr['title'] = $offer->title;
            $subArr['type'] = $offer->type;
            $subArr['sub_type'] = $offer->sub_type;
            $subArr['start_date'] = $offer->start_date;
            $subArr['end_date'] = $offer->end_date;
            $subArr['redeem_date'] = $offer->redeem_date;
            $subArr['status'] = $offer->status;
            $subArr['is_draft'] = $offer->is_draft;
            $subArr['is_default'] = $offer->is_default;
            $offerArray[] = $subArr;
        }
        
        return json_encode(array("status"=>"success", "data"=>$offerArray, "message"=>"Offers found."));
    }
    
    public function getOffers($userid){
        return $response = $this->getOffersByType('all',$userid);
    }
    
    public function getActiveOffers($userid){
        return $response = $this->getOffersByType('active',$userid);
    }
    
    public function getExpiredOffers($userid){
        return $response = $this->getOffersByType('expired',$userid);
    }
    
    public function getOffer($offerid){
        $offer = Offer::where('id',$offerid)->first();
        if($offer == null){
            return json_encode(array("status"=>"error", "message"=>"Offer not found!"));
        }
        
        $offerArray = [];
        
        $offerTemplate = OfferTemplate::where('offer_id',$offer->id)->first();
        $bg_image = '';
        if(!empty($offerTemplate->bg_image) || $offerTemplate->bg_image != null){
            $bg_image = asset('assets/templates/').'/'.$offerTemplate->slug.'/'.$offerTemplate->bg_image;
        }
        
        if($offer->future_offer->promotion_url != null){
            $previewOffer = url($offer->future_offer->promotion_url);
        }else{
            $previewOffer = url("business/offer-preview/".$offer->id."/".$offerTemplate->slug);
        }

        $offerArray['offer_id'] = $offer->id;
        $offerArray['title'] = $offer->title;
        $offerArray['description'] = $offer->future_offer->offer_description;
        $offerArray['bg_image'] = $bg_image;
        $offerArray['preview_url'] = $previewOffer;
        $offerArray['type'] = $offer->type;
        $offerArray['sub_type'] = $offer->sub_type;
        $offerArray['start_date'] = $offer->start_date;
        $offerArray['end_date'] = $offer->end_date;
        $offerArray['redeem_date'] = $offer->redeem_date;
        $offerArray['status'] = $offer->status;
        $offerArray['is_draft'] = $offer->is_draft;
        $offerArray['is_default'] = $offer->is_default;
        
        return json_encode(array("status"=>"success", "data"=>$offerArray, "message"=>"Offer found."));
        
    }
    
    public function getDefaultOffer(Request $request){
        $business_id = $request->business_id;
        if(empty($business_id)){
            return json_encode(array("status"=>"error", "message"=>"Please Enter Valid Business id!"));
        }

        $offer = Offer::where('user_id',$business_id)->where('is_default','1')->first();
        
        if($offer == null){
            return json_encode(array("status"=>"error", "message"=>"Offer not found!"));
        }
        
        $offerArray = [];
        
        $offerTemplate = OfferTemplate::where('offer_id',$offer->id)->first();
        $bg_image = '';
        if(!empty($offerTemplate->bg_image) || $offerTemplate->bg_image != null){
            $bg_image = asset('assets/templates/').'/'.$offerTemplate->slug.'/'.$offerTemplate->bg_image;
        }
        
        if($offer->future_offer->promotion_url != null){
            $previewOffer = url($offer->future_offer->promotion_url);
        }else{
            $previewOffer = url("business/offer-preview/".$offer->id."/".$offerTemplate->slug);
        }

        $offerArray['offer_id'] = $offer->id;
        $offerArray['title'] = $offer->title;
        $offerArray['description'] = $offer->future_offer->offer_description;
        $offerArray['bg_image'] = $bg_image;
        $offerArray['preview_url'] = $previewOffer;
        $offerArray['type'] = $offer->type;
        $offerArray['sub_type'] = $offer->sub_type;
        $offerArray['start_date'] = $offer->start_date;
        $offerArray['end_date'] = $offer->end_date;
        $offerArray['redeem_date'] = $offer->redeem_date;
        $offerArray['status'] = $offer->status;
        $offerArray['is_draft'] = $offer->is_draft;
        $offerArray['is_default'] = $offer->is_default;
        
        return json_encode(array("status"=>"success", "data"=>$offerArray, "message"=>"Offer found."));
        
    }
    
    public function redeemOffer(Request $request){
        $offer_id = $request->code;
        $business_id = $request->business_id;

        $whatsappSession = WhatsappSession::where('user_id', $business_id)->orderBy('id', 'desc')->first();
        
        if($whatsappSession == '' || (isset($whatsappSession->instance_id) && $whatsappSession->instance_id == '')){
            return response()->json(["success" => false, "message" => "Your business account is not linked to Whatsapp."]);
        }

        $offerIds = Offer::where('user_id',$business_id)->pluck('id')->toArray();
        
        //$redeem = Redeem::with('subscription')->where('code',$request->code)->orderBy('id', 'desc')->first();
        $redeem = Redeem::with('subscription')->where('code',$request->code)->orderBy('id', 'desc')->first();
        if($redeem == null){
            return response()->json(["success" => false, "message" => "Coupon is invalid."]);
        }else{
            return $this->verifyCoupon($redeem);
        }
    }
    
    public function verifyCoupon($redeem){
        if($redeem->is_redeemed != 0){
            return response()->json(["success" => false, "message" => "Offer is already redeemed."]);
        }else{
            $subscription = OfferSubscription::where('id',$redeem->offer_subscribe_id)->orderBy('id','desc')->first();
            if($subscription->parent_id != ''){
              $targets = Target::whereIn('offer_subscribe_id',[$subscription->id, $subscription->parent_id])->where('repeated',0)->count();
            }else{
              $targets = Target::where('offer_subscribe_id',$redeem->offer_subscribe_id)->where('repeated',0)->count();
            }

            $offer = Offer::with('future_offer')->where('id', $subscription->offer_id)->orderBy('id', 'desc')->first();
            $todays_date = date("Y-m-d");
            if($todays_date > $offer->redeem_date && $offer->type != 'instant'){
                return response()->json(["success" => false, 'data' => '', 'targets' => '', "message" => "Coupon has Expired."]);
            }
            
            $offerTemplate = OfferTemplate::where('offer_id',$offer->id)->first();
            $bg_image = '';
            if(!empty($offerTemplate->bg_image) || $offerTemplate->bg_image != null){ 
                $bg_image = asset('assets/templates/').'/'.$offerTemplate->slug.'/'.$offerTemplate->bg_image;
            }
            
            $data['redeem_id'] = $redeem->id;
            $data['offer_details'] = $offer;
            $data['offer_details']['offer_image'] = $bg_image;
            
            $data['for_clicks'] = $redeem->for_clicks;
            $data['type'] = $redeem->subscription->future_offer->sub_type;
            $data['value'] = $redeem->subscription->future_offer->future_offer->discount_value;

            return response()->json(["success" => true, 'data' => $data, 'targets' => $targets, "message" => "Coupon is valid. Please Proceed Payment."]);
        }
    }
    
    public function proceedRedeem(Request $request){

        if(!empty($request)){
            
            $redeem = Redeem::where('id', $request->redeem_id)->orderBy('id', 'desc')->first();

            if($redeem){

                //get achieved unique clicks count
                $clicks = Target::where('offer_subscribe_id',$redeem->offer_subscribe_id)->where('repeated',0)->orderBy('id','desc')->count();

                $invoice_no = $this->getInvoiceNo($request->offer_id);
                if($request->invoice == ''){
                    $redeem_invoice_no = $invoice_no;
                }else{
                    $redeem_invoice_no = $request->invoice;
                }

                $redeem_detail  =  RedeemDetail::Create([
                                    'offer_id' => $request->offer_id,
                                    'offer_subscribe_id' => $redeem->offer_subscribe_id,
                                    'redeem_id' => $request->redeem_id,  
                                    'redeem_invoice_no' => $redeem_invoice_no,
                                    'invoice_no' => $invoice_no,
                                    'no_of_clicks' => $clicks,
                                    'actual_amount' => $request->actual_amount,
                                    'discount_type' => $request->discount_type,
                                    'discount_value' => $request->discount_value,
                                    'redeem_amount' => $request->redeem_amount,
                                    'calculated_amount' => $request->calculated_amount,
                                    'redeem_by' => $request->user_id
                                ]);


                if(!$redeem_detail){
                    return response()->json(["success" => false, 'data' => [], "message" => "Saving redeem details failed."]);
                }

                /*whatsapp login check*/

                $offer = Offer::findorFail($request->offer_id);
                
                $whatsappSession = WhatsappSession::where('user_id', $request->business_id)->orderBy('id', 'desc')->first();
                if($whatsappSession == '' || (isset($whatsappSession->instance_id) && $whatsappSession->instance_id == '')){
                    return response()->json(["success" => false, "message" => "Your business account is not linked to Whatsapp."]);
                }

                /* Message Limit Check */
                if($offer->type == 'future'){
                    $type_id = 4;
                    $type_slug = 'share_rewards';
                }else{
                    $type_id = 5;
                    $type_slug = 'instant_rewards';
                }
                
                $message_data = CommonSettingController::checkSendFlag($request->business_id,$type_id);
                if(!$message_data['sendFlag']){
                    return response()->json(["success" => false, "message" => "Sorry your msg limit exceed!."]);
                }

                $msg = '';
                $businessDetail = BusinessDetail::where("user_id",$request->business_id)->orderBy('id','desc')->first();
                if($businessDetail != ''){
                    $msg = $businessDetail->business_msg;
                }

                /* Send Redeem Details on Whatsapp */
                $subscription = OfferSubscription::where('id',$redeem->offer_subscribe_id)->orderBy('id','desc')->first();
                $customer = Customer::where('id',$subscription->customer_id)->orderBy('id','desc')->first();
                $phoneNumber = '91'.$customer->mobile;
                
                $actual_amount = floatval($request->actual_amount);
                $discount_value = floatval($request->discount_value);
                $redeem_amount = floatval($request->redeem_amount);

                $payload = WhatsAppMsgController::afterRedeemedMsg($request->discount_type, ucfirst($businessDetail->business_name), $msg, $actual_amount, $discount_value, ($actual_amount - $redeem_amount), $redeem_amount);
                $wpa_res = WhatsAppMsgController::sendTextMessageWP($phoneNumber, $payload, $request->business_id);
                $res = json_decode($wpa_res); //dd($res);

                if($res != '' && $res->status == 'success'){
                    //
                }else{
                    return response()->json(["success" => false, "message" => "Redeem invoice failed to send on Whatsapp."]);
                }
                
                $redeem->is_redeemed = 1;
                if($redeem->save()){

                    //cashback offer
                    $offerFuture = OfferFuture::where('offer_id',$request->offer_id)->first();
                    if(($offerFuture != null) && ($offerFuture->max_promo_count != '')){

                        $subscription = OfferSubscription::where('id',$redeem->offer_subscribe_id)->first();
                        $subscription->code_sent = '0';
                        $subscription->save();

                        /*Update max clicks*/
                        $total_clicks = Target::where('offer_subscribe_id', '=', $redeem->offer_subscribe_id)->count();
                        $offerFuture->pending_clicks = $offerFuture->max_promo_count - $total_clicks;
                        $offerFuture->save();
                        
                        Target::where('offer_subscribe_id', '=', $redeem->offer_subscribe_id)
                        ->update(['repeated' => 1]);
                    }
                    
                    $redeem_detail['share_count'] = OfferSubscription::where('created_by', $request->user_id)->count();
                    $redeem_detail['redeem_count'] = RedeemDetail::where('redeem_by',$request->user_id)->count();
                    

                    return response()->json(["success" => true, 'data' => $redeem_detail, "message" => "Redeemed Successfully."]);
                }
            }else{
                return response()->json(["success" => false, 'data' => [], "message" => "Redeeem Failed."]);
            }
        }else{
            return response()->json(["success" => false, 'data' => [], "message" => "Something went wrong."]);
        }
    }
    
    public function getInvoiceNo($offer_id){
        $invoice_no = '';
        $last = RedeemDetail::where('offer_id',$offer_id)->select('invoice_no')->orderBy('id', 'desc')->latest()->first();

        $offer_id_no = sprintf('%03d', $offer_id);

        if($last != null){
            $invoice_details = explode('-', $last->invoice_no);
            $prev = (int)$invoice_details[1];
            $prev++;
            $redeem_no = sprintf('%06d', $prev);
            $invoice_no = $offer_id_no.'-'.$redeem_no;
        }else{
            $redeem_no = sprintf('%06d', 1);
            $invoice_no = $offer_id_no.'-'.$redeem_no;
        }
        
        return $invoice_no;
    }
    
    public function shareToCustomer(Request $request){

        $offer = Offer::where('id', $request->offer_id)->orderBy('id', 'desc')->first();
        $current_date = date('Y-m-d');
        $domain = URL::to('/');
        
        if($offer->is_draft == 1){
            return response()->json(["success" => false, "message" => "Offer is not published yet."]);
        }

        if($offer->start_date->format('Y-m-d') > $current_date){
            return response()->json(["success" => false, "message" => "Offer is not started yet."]);
        }

        if($offer == null){
            return response()->json(["success" => false, "message" => "Offer not found."]);
        }elseif ($offer->end_date < $current_date) {
            return response()->json(["success" => false, "message" => "Offer is expired."]);
        }else{
            $business_id = $request->business_id;
            $created_by = $request->user_id;

            /*whatsapp login check*/
            $whatsappSession = WhatsappSession::where('user_id', $business_id)->orderBy('id', 'desc')->first();
            if($whatsappSession == '' || (isset($whatsappSession->instance_id) && $whatsappSession->instance_id == '')){
                return response()->json(["success" => false, "message" => "Your business account is not linked to Whatsapp."]);
            }

            //get customer or create if not exist
            $customer = $this->getCustomer($request, $created_by, $business_id);
            if(isset($customer->customer_id)){
                $customer_id = $customer->customer_id;
            }else{
                $customer_id = $customer->id;
            }               

            $offerData = OfferFuture::where('offer_id',$offer->id)->orderBy('id', 'desc')->first();
            if($offerData->promotion_url == null){
                $type = 'template';
            }else{
                $type = 'website';
            }

            //get subscription or create if not exist
            $OfferSubscription = $this->getSubscription($request->offer_id, $customer_id, $created_by,$type,$offerData->promotion_url,$business_id);
            if($OfferSubscription['status'] == false){
                return response()->json(["success" => false, "message" => $OfferSubscription['message']]);
            }

            if($type == 'template'){
                //template
                $offerTemplate = OfferTemplate::where('offer_id',$request->offer_id)->orderBy('id','desc')->first();
                $img = $domain."/assets/offer-thumbnails/".$offerTemplate->thumbnail;
            }else{
                $img = asset('system/public/assets/business/Website-offer-thumb-'.$OfferSubscription['data']->user_id.'.jpg');
            }

            //share link code here
            $url = "https://waba.360dialog.io/v1/messages";
            $method = "POST";
            
            $code = $OfferSubscription['shortcode']->uuid;
            $phoneNumber = '91'.$request->number;
            
            /*  Check message limit */
            $data = CommonSettingController::checkSendFlag($business_id,4);
            if($offer->sub_type != 'MadeShare'){
                if(!$data['sendFlag']){
                    return response()->json(["success" => false, "message" => "Sorry your msg limit exceed!."]);
                }
            }

            if($offer->sub_type == 'PerClick'){
                $payload = WhatsAppMsgController::cashPerClickSubscription($code);
            }elseif($offer->sub_type == 'Percentage'){
                $payload = WhatsAppMsgController::percentageDiscountSubscription($code);
            }elseif($offer->sub_type == 'Fixed'){
                $payload = WhatsAppMsgController::fixedAmountSubscription($code);
            }elseif($offer->sub_type == 'MadeShare'){
                $payload = WhatsAppMsgController::MadeShareSubscription($code);
            }


            if($offer->sub_type == 'MadeShare'){
                $wpa_res = CommonMessageController::sendMessage($phoneNumber, $payload);
            }else{
                $wpa_res = WhatsAppMsgController::sendTextMessageWP($phoneNumber, $payload, $business_id);
            }
            
            $res = json_decode($wpa_res);
            // dd($wpa_res);
    
            if($res != '' && $res->status == 'success'){
                $subscrData = OfferSubscription::find($OfferSubscription['data']->id);
                $subscrData->link_shared = "1";
                $subscrData->save();
            }else{
                OfferSubscription::destroy($OfferSubscription['data']->id);
                return response()->json(["success" => false, "message" => "Something went wrong. Please try again."]);
            }

            if(isset($OfferSubscription['data']->share_link)){
                $share_link = $domain.$OfferSubscription['data']->share_link;
            }else{
                $share_link = $domain;
            }

            if($offer->sub_type != 'MadeShare'){
                //
            }
            
            $count['share_count'] = OfferSubscription::where('created_by', $request->user_id)->count();
            $count['redeem_count'] = RedeemDetail::where('redeem_by',$request->user_id)->count();

            return response()->json(["success" => true, "data" => $count, "message" => "Offer shared successfully.", "share_link" => $share_link]);
        }
    }
    
    public function getSubscription($offer_id, $customer_id, $created_by,$offer_type,$url,$business_id=''){

        $subscription = OfferSubscription::where('offer_id', $offer_id)->where('customer_id', $customer_id)->orderBy('id', 'desc')->first();
        $domain = URL::to('/');

        if($subscription != null){
            $redeem = Redeem::where('offer_subscribe_id',$subscription->id)->orderBy('id', 'desc')->first();
        }else{
            $redeem = null;
        }
        

        if(($subscription != null && $redeem == null) || ($redeem != null && $redeem->is_redeemed == 0)){

            return ['status' => false, 'message' => 'Already subscribed to the offer.', 'data' => $subscription, 'shortcode' => ''];
        }else{
            $type = 'future';
            $randomString = UuidTokenController::eightCharacterUniqueToken(8);
            $addedCharacter = UuidTokenController::addCharacter($type, $randomString);
            $tokenData = UuidTokenController::findUniqueToken($type,$addedCharacter);
           
            if($tokenData['status'] == true){
                $tokenData = UuidTokenController::findUniqueToken($type,$addedCharacter);
            }

            $offer = Offer::with('future_offer')->where('id',$offer_id)->orderBy('id', 'desc')->first();

            $url = rtrim($url,"/");

            if($redeem != null && $redeem->is_redeemed == 1){
                $share_link = $subscription->share_link;
                $uuid_code = $subscription->uuid;
            }else{
                if($offer_type == 'template'){
                    $share_link = '/f/'.$offer->uuid.'?share_cnf='.$tokenData['token'];
                }else{
                    $share_link = $url.'/?o='.$offer->uuid.'&share_cnf='.$tokenData['token'];
                }
                $uuid_code = $tokenData['token'];
            }

            $checkPendingClicks = $this->checkPendingClicks($created_by,$customer_id);
            if($checkPendingClicks['status'] == true){  
                $parent_id = $checkPendingClicks['data']->id;
            }else{
                $parent_id = '';
            }

            $subscription = new OfferSubscription;
            $subscription->user_id = $business_id;
            $subscription->offer_id = $offer_id;
            $subscription->customer_id = $customer_id;
            $subscription->parent_id = $parent_id;
            $subscription->created_by = $created_by;
            $subscription->uuid = $uuid_code;
            $subscription->share_link = $share_link;
            $subscription->target = $offer->future_offer->share_target;
            $subscription->save();
            
            //API call to get shortlink         
            if($offer_type == 'website'){
                $long_link = $share_link;
            }else{
                $long_link = $domain.$share_link;
            }
                  
            /*$postData = array(
                'opnlkey' => env('SHORTNER_API_KEY'),
                'secret' => env('SHORTNER_SECRET_KEY'),
                'long_link' => $long_link
            );*/

            $postData = array(
                'opnlkey' => 'ol-PFAb3O0wGo2hHnQY',
                'secret' => 'mEFgF1niz9L6PGuOgaeCet3CgjJ6X4DrpT4T6U3v',
                'long_link' => $domain.$share_link,
            );

            //API URL
            $url="https://opnl.in/api/v1/opnl-short-link";

            //init the resource
            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $postData
                //,CURLOPT_FOLLOWLOCATION => true
            ));

            //Ignore SSL certificate verification
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            //Get response
            $response = curl_exec($ch);
            $output = json_decode($response);
            curl_close($ch);

            if($output->status == true){
                $uriSegments = explode("/", parse_url($output->link, PHP_URL_PATH));
                $link_uuid = array_pop($uriSegments);

                $shortLink = new ShortLink;
                $shortLink->uuid = $link_uuid;
                $shortLink->link = $long_link;
                $shortLink->save();

                $subscription->short_link_id = $shortLink->id;
                $subscription->save();

                return ['status' => true, 'message' => 'Offer subscribed successfully.', 'data' => $subscription, 'shortcode' => $shortLink];
            }else{
                OfferSubscription::destroy($subscription->id);
                return ['status' => false, 'message' => 'Offer not subscribed.', 'data' => '', 'shortcode' => ''];
            }
        }
    }
    
    
    public function getCustomer($request, $created_by, $business_id){

        $checkWithBusiness = Customer::with('businesses')
                ->leftjoin('business_customers', 'customers.id', '=', 'business_customers.customer_id')
                ->where('customers.mobile',$request->number)
                ->where('business_customers.business_id',$request->business_id)
                ->orderBy('customers.id', 'desc')
                ->first();

        if($checkWithBusiness != null){
            //return $checkWithBusiness;
        }

        $customer = Customer::where('mobile',$request->number)->orderBy('id', 'desc')->first();
        if($customer == null){
            $customer= new Customer;
            $customer->mobile = $request->number;
            $customer->user_id = $created_by;
            $customer->created_by = $created_by;
            $customer->save();

            $customer->uuid = $customer->id.'CUST'.date("Ymd");
            $customer->save();

            $business_customer = new BusinessCustomer;
            $business_customer->customer_id = $customer->id;
            $business_customer->business_id = $business_id;
            $business_customer->name = $request->customer_name;
            $business_customer->dob = $request->customer_dob;
            $business_customer->anniversary_date = $request->customer_adate;
            $business_customer->save();
        }else{
            
            $businessCustomer = BusinessCustomer::where('business_id',$request->business_id)->where('customer_id',$customer->id)->orderBy('id', 'desc')->first();

            if($businessCustomer != null){
                $business_customer = BusinessCustomer::find($businessCustomer->id);
            }else{
                $business_customer = new BusinessCustomer;
            }  
            $business_customer->customer_id = $customer->id;
            $business_customer->business_id = $business_id;
            $business_customer->name = $request->customer_name;
            $business_customer->dob = $request->customer_dob;
            $business_customer->anniversary_date = $request->customer_adate;
            $business_customer->save();
        }

        return $customer;
    }
    
    public function checkPendingClicks($business_id,$customer_id){
        $incomplete = OfferSubscription::where('created_by',$business_id)->where('customer_id',$customer_id)->where('status','3')->orderBy('id','desc')->first();
        if($incomplete != null){
            return ['status' => true, 'data' => $incomplete];
        }else{
            return ['status' => false, 'data' => ''];
        }
    }


}
