<?php

namespace App\Http\Controllers;

use App\Models\EmailSubscriber;
use Illuminate\Http\Request;
use App\Models\DemoRequest;
use Session;
use App\Models\Plan;
use App\Models\WhatsappLog;
use App\Models\Blog;
use App\Models\User;
use App\Models\Offer;
use App\Models\Option;
use App\Models\Article;
use App\Models\Channel;
use App\Models\EmailJob;
use App\Models\PlanView;
use App\Models\Recharge;
use App\Models\PlanGroup;
use App\Models\InstantTask;
use App\Models\BlogsSetting;
use App\Models\Documentation;
use App\Models\BusinessDetail;
use App\Models\FrontEndSearch;
use App\Models\ArticlesSetting;
use App\Models\DocumentCategory;
use App\Models\PlanGroupChannel;

class FrontController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Set price in session.
     *
     * @param  array  $data
     * @return \App\Models\User
     */

    public function setPlanData(Request $request)
    {
        if($request->plan_slug != ''){

            // dd($request->all());
            $pricing_data = $this->getPricingData();
            // dd($pricing_data);
            Session([
                'plan_slug'   =>  $request->plan_slug,
                'billing_type'   =>  $request->billing_type,
                'total_price'   =>  $pricing_data[$request->billing_type][$request->plan_slug]['total_price'],
                'payble_price'   =>  $pricing_data[$request->billing_type][$request->plan_slug]['payble_price']
            ]);

            $planData = $request->except('_token');
        
            return response()->json(['status' => true, 'planInfo' => $planData]);

        }

        return response()->json(['status' => false, 'planInfo' => [], 'message' => 'Something went wrong']);
    }

    public function getPricingData(){
        $pricing_data = array();
        $plans = Plan::where('status','1')->orderBy('ordering','asc')->get();
        $groups = PlanGroup::where('status','1')->orderBy('ordering','asc')->get();

        foreach($plans as $plan){
            foreach($groups as $group){
                $channel_ids = PlanGroupChannel::where('plan_group_id',$group->id)->pluck('channel_id')->toArray();

                $amount = Channel::whereIn('id',$channel_ids)->sum('price');

                $pricing_data[$plan->slug][$group->slug]['total_price'] = round($amount * $plan->months);
                $pricing_data[$plan->slug][$group->slug]['payble_price'] = round(($amount * $plan->months) - ($amount * $plan->months) * ($plan->discount / 100));
                $pricing_data[$plan->slug][$group->slug]['mothly_total_price'] = $amount;
                $pricing_data[$plan->slug][$group->slug]['mothly_payble_price'] = round($amount - $amount * ($plan->discount / 100));
                $pricing_data[$plan->slug][$group->slug]['discount'] = $plan->discount;
            }
            
        }

        return $pricing_data;
    }

    public function getPlanData(Request $request)
    {
        //
    }

    public function setPlan(Request $request)
    {
        $planData = Session([
            'payble_price'   =>  $request->payble_price,
            'base_price'   =>  $request->base_price,
            'plan_name'   =>  $request->plan_name,
            'billing_type'   =>  $request->billing_type
        ]);
        return response()->json(['status' => true, 'planData' => $planData]);
    }

    public function setBillingType(Request $request)
    {
        $planData = Session([
            'payble_price'   =>  $request->payble_price,
            'base_price'   =>  $request->base_price,
            'billing_type'   =>  $request->billing_type
        ]);
        return response()->json(['status' => true, 'planData' => $planData]);
    }


    public function subscribe(Request $request){
        // dd($request);
        $phone = $request->input_data;
        if($phone != ''){

            $check = EmailSubscriber::where('phone', $phone)->first();
            if($check){
                echo json_encode(array("status" => false, "type"=>"success", "message"=>"Your WhatsApp number is already subscribed."));
            }else{

                $subsciber = new EmailSubscriber;
                $subsciber->phone = $phone;
                $subsciber->save();

                /*
                * Sending the data to the SalesRobo form.
                */
                // $form_id = 4;
                // $data = array(
                //     'mauticform[whatsapp_number]' => $phone,
                //     'mauticform[formId]' => $form_id,
                //     'mauticform[return]' => '',
                //     'mauticform[formName]' => 'mpwebsitefooterform'
                // );
                // $send_to_SalesRobo = \App\Http\Controllers\SalesroboController::send_form_data($form_id, $data);
                /* END SalesRobo code */

                /* Sending email */
                // $data = [
                //     'email' => $email
                // ];
                // \App\Http\Controllers\CommonMailController::EmailSubscriptionMail($data);

                echo json_encode(array("status" => true, "type"=>"success", "message"=>"Thank You! Your WhatsApp number has been subscibed."));
            }
                
        }else{
            echo json_encode(array("status" => false, "type"=>"error", "message"=>"Please Enter a WhatsApp number."));
        }

    }

    public function requestDemo(Request $request){
        
        $mobile = $request->mobile;
        if($mobile != ''){

            $check = EmailSubscriber::where('mobile', $mobile)->first();
            if($check){
                echo json_encode(array("type"=>"success", "message"=>"Email Id Is Already Subscribed."));
            }else{

                $demo = new DemoRequest;
                $demo->mobile = $mobile;
                $demo->save();

                echo json_encode(array("type"=>"success", "message"=>"Email Id Has Been Subscibe."));
            }
                
        }else{
            echo json_encode(array("type"=>"error", "message"=>"Please Enter Email Id."));
        }

    }

}