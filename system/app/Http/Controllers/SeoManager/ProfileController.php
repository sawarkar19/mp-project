<?php

namespace App\Http\Controllers\SeoManager;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Business\CommonSettingController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Option;

use App\Models\BusinessDetail;
use App\Models\EmailJob;
use App\Models\IpUser;

use Carbon\Carbon;
use Hash;
use Auth;
use DB;

class ProfileController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('seomanager');
    }

    public function profileSettings()
    {   

        $basic = BusinessDetail::where('user_id', Auth::id())->orderBy('id', 'desc')->first();
        if($basic == null){
            $basic = new BusinessDetail;
        }

        $userData = User::where('id', Auth::id())->orderBy('id', 'desc')->first();

        $logo_url = asset('assets/business/logos');

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        return view('seomanager.profile-setting', compact('basic','notification_list','planData', 'userData', 'logo_url'));
    }

    public function numberUpdate(){

        $check=User::where('mobile', $_POST['mobile_number'])->orderBy('id', 'desc')->first();

        if($check != null){
            if($check->id == Auth::id()){
                echo json_encode(array("type"=>"error", "message"=>"This number is already attached to your account."));
            }else{
                echo json_encode(array("type"=>"error", "message"=>"Opps the mobile number already exists...!!"));
            }
            
        }else{
            $checkOTP = IpUser::where('mobile', $_POST['mobile_number'])->where('date', Carbon::today())->count();

            if($checkOTP <= 2){
                $number = $_POST['mobile_number'];
                $otp = rand(100000, 999999);

                DB::table('user_otp')->insert(
                    array(
                        'user_id' => Auth::id(),
                        'number' => $number,
                        'otp' => $otp
                    )
                );

                // $username = 'openlink';
                // $password = 'KHdZFvJrMQDT';
                // $sendername = 'OPNLNK';
                // $message = $otp." is your OpenLink account verification code.";
                // $routetype = "1";

                // $postData = array(
                //     'username' => $username,
                //     'password' => $password,
                //     'mobile' => $number,
                //     'sendername' => $sendername,
                //     'message' => $message,
                //     'routetype' => $routetype,
                // );

                // //API URL
                // $url="http://logic.bizsms.in/SMS_API/sendsms.php";

                // // init the resource
                // $ch = curl_init();
                // curl_setopt_array($ch, array(
                //     CURLOPT_URL => $url,
                //     CURLOPT_RETURNTRANSFER => true,
                //     CURLOPT_POST => true,
                //     CURLOPT_POSTFIELDS => $postData
                //     //,CURLOPT_FOLLOWLOCATION => true
                // ));


                // //Ignore SSL certificate verification
                // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


                // //get response
                // $output = curl_exec($ch);

                // //Print error if any
                // if(curl_errno($ch))
                // {
                //     echo 'error:' . curl_error($ch);
                // }

                // curl_close($ch);

                $payload = \App\Http\Controllers\WACloudApiController::mp_sendotp('91'.$number, $otp);
                $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);
                
                $clientIP = request()->ip();

                $otp_save = new IpUser;
                $otp_save->user_ip = $clientIP;
                $otp_save->mobile = $number;
                $otp_save->date = Carbon::today();
                $otp_save->is_sent = 1;
                $otp_save->save();

                echo json_encode(array("type"=>"success","message"=>"OTP sent on your number."));
            }
            else{
                echo json_encode(array("type"=>"error","message"=>"OTP usage limit exceeded for this number. Try another number."));
            }
        }

    }   

    public function verifyUpdate(){      
        $otp = $_POST['otp']; 
        $isExist = DB::table('user_otp')->where("user_id", Auth::id())->where("otp", $otp)->exists();       
        $results = DB::table('user_otp')->where("user_id", Auth::id())->where("otp", $otp)->get();

        if ($isExist) {
            $user_id= Auth::id();

            User::where('id',$user_id)->update(['mobile'=>$results[0]->number]);

            echo json_encode(array("type"=>"success", "session_number"=>$results[0]->number, "message"=>"Mobile number successfully updated!"));        

            DB::table('user_otp')->where("user_id", Auth::id())->where("otp", $otp)->delete();
        } else {
            echo json_encode(array("type"=>"error", "message"=>"OTP is incorrect!"));
        } 
    }

    public function profileUpdate(Request $request){
        
        $user=User::find(Auth::id());
        if ($request->password_current) {
            if($request->password){
                $validatedData = $request->validate([
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
                ]);  


                $check = Hash::check($request->password_current, auth()->user()->password);

                if ($check == true) {
                    $user->password= Hash::make($request->password);
                }
                else{
                    return response()->json(['status' => false, 'message' => 'Enter Valid Old Password.']);
                }

                $checkWithNew = Hash::check($request->password, auth()->user()->password);
                if ($checkWithNew == true) {
                    return response()->json(['status' => false, 'message' => 'New Password is same as Old Password.']);
                }

                $redirect_url = route('login');
                if($user->save()){
                    return response()->json(['status' => true, 'message' => 'Password updated successfully.', 'redirect_url' => $redirect_url]);
                }else{
                    return response()->json(['status' => false, 'message' => 'Password Not Updated.']);
                }  
            }
                  
        }else{
            $validatedData = $request->validate([
                'name' => 'required|min:2|max:255',
                'email'  =>  'required|email|unique:users,email,'.Auth::id()
            ]);
            $user->name=$request->name;
            $user->email=$request->email;   

            if($user->save()){
                return response()->json(['status' => true, 'message' => 'Profile Updated Successfully']);
            }else{
                return response()->json(['status' => false, 'message' => 'Profile Not Updated.']);
            }
        }
    }
}
