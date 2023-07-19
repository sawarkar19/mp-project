<?php

namespace App\Http\Controllers\Business;

use Auth, Image;
use App\Models\State;

use Illuminate\Http\Request;
use App\Models\BusinessDetail;

use App\Models\WhatsappSession;
use App\Http\Controllers\Controller;

class WizardController extends Controller
{
    public function __construct()
    {
       $this->middleware('business');
    }

    public function getStates(Request $request)
    {
        $states = State::where('status', 1)->get();
        $html = '';
        foreach($states as $key => $row){
            $html .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
        return response()->json($html);
    }

    public function updateBusinessDetails(Request $request)
    {
        $user_id = Auth::id();
        $businessDetail = BusinessDetail::where('user_id', $user_id)->first();
        $logo = $this->_uploadImage($request);
        if(!$logo){
            $logo = '';
        }
// dd($logo);
        $json=['status'=>false];

        $businessDetail->business_name=$request['business_name'];
        $businessDetail->tag_line=$request['tag_line'];
        $businessDetail->logo = $logo;
        if($businessDetail->update()){
            $json=[
                'status'=>true,
                'data' => $businessDetail,
            ];
        }
        else{
            $json=[
                'status'=>false,
                'message'=>"Unable to add bussiness detail"
            ];
        }
        return response()->json($json);
    }

    public function updateContactDetails(Request $request)
    {
        $user_id = Auth::id();
        $businessDetail = BusinessDetail::where('user_id', $user_id)->first();

        $json=['status'=>false];

        $businessDetail->call_number=$request['call_number'];
        $businessDetail->state=$request['state'];
        $businessDetail->city=$request['city'];
        $businessDetail->pincode=$request['pincode'];
        $businessDetail->address_line_1=$request['address_line_1'];
        $businessDetail->address_line_2=$request['address_line_2'];
        $businessDetail->is_same_address=1;
        $businessDetail->billing_state=$request['state'];
        $businessDetail->billing_city=$request['city'];
        $businessDetail->billing_pincode=$request['pincode'];
        $businessDetail->billing_address_line_1=$request['address_line_1'];
        $businessDetail->billing_address_line_2=$request['address_line_2'];
        // $businessDetail->is_wizard_setup=1;
        
        
        if($businessDetail->update()){

            $json=[
                'status'=>true
            ];
        }
        else{
            $json=[
                'status'=>false,
                'message'=>"Unable to add contact detail"
            ];
        }
        return response()->json($json);
    }

    public function getUserDetails(Request $request)
    {
        $user_id = Auth::id();
        $userNumber = Auth::user()->mobile;
        $businessDetail = BusinessDetail::where('user_id', $user_id)->first();Auth::id();
        
        $json=[
            'status'=>true,
            'businessDetail'=>$businessDetail,
            'userNumber' => $userNumber
        ];
        return response()->json($json);
    }

    // public function whatsappSettings(Request $request)
    // {
    //     $user_id = Auth::id();
    //     $wa_session = WhatsappSession::where('user_id', $user_id)
    //         ->orderBy('id', 'desc')
    //         ->first();

    //     $whatsapp_num = '';
    //     if ($wa_session) {
    //         $whatsapp_num = $wa_session->wa_number;
    //     }

    //     $userData = User::where('id', Auth::id())
    //         ->orderBy('id', 'desc')
    //         ->first();
    //     $wa_url = Option::where('key', 'oddek_url')->first();
    //     $wa_api_url = Option::where('key', 'wa_api_url')->first();

    //     $logo_url = asset('assets/business/logos');

    //     $json = [
    //         'status' => true,
    //         'wa_session' => $wa_session,
    //         'whatsapp_num' => $whatsapp_num,
    //         'userData' => $userData,
    //         'wa_url' => $wa_url,
    //         'wa_api_url' => $wa_api_url,
    //         'logo_url' => $logo_url,
    //     ];

    //     return response()->json($json);
    // }

    public function finishSetup(Request $request)
    {
        $user_id = Auth::id();
        $businessDetail = BusinessDetail::where('user_id', $user_id)->first();
        // dd($businessDetail);

        $json = ['status' => false];

        $businessDetail->is_wizard_setup = 1;

        if ($businessDetail->update()) {
            $json = [
                'status' => true,
            ];
        } else {
            $json = [
                'status' => false,
                'message' => 'Unable to whatsapp connect!',
            ];
        }

        return response()->json($json);
    }

    private function _uploadImage($request)
    {
        if($request->hasFile('logo'))
        {
            $image = $request->file('logo');
            $extension = $image->getClientOriginalExtension();
            $size = $image->getSize();

            if($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png'){
                if($size <= 2097152){

                    $image = $request->file('logo');
                    $extension = $image->getClientOriginalExtension();
                    $fileName = 'openlink-business-logo-'.date('dmYhis',time()) . '.' . $extension;
                    $destinationPath = base_path('../assets/business/logos/');
                    $image_resize = Image::make($image->getRealPath());
                    $image_resize->resize(350, 350, function($const){
                        $const->aspectRatio();
                    });
                    $image_resize->save($destinationPath. $fileName);

                    return $fileName;
                }else{
                    return false;
                }
            }else{
                return false;
            }

        }else{
            return false;
        }
    }
}
