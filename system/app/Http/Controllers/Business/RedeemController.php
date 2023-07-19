<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\WhatsAppApiController;
use App\Http\Controllers\WhatsAppMsgController;
use App\Http\Controllers\Business\CommonSettingController;

use App\Models\RedeemDetail;
use App\Models\Offer;
use App\Models\Redeem;
use App\Models\Target;
use App\Models\OfferFuture;
use App\Models\OfferSubscription;
use App\Models\WhatsappSession;
use App\Models\BusinessDetail;
use App\Models\Customer;

use Rap2hpoutre\FastExcel\FastExcel;

use DB;
use Carbon\Carbon;
use Auth;

class RedeemController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('business');
    }

    public function redeem(){
        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();
        $businessSettings = CommonSettingController::businessSettings();

        return view('business.redeem.redeem', compact('notification_list','planData','businessSettings'));
    }

    public function redeemOffer(Request $request){
        $business_id = Auth::id();

        $whatsappSession = WhatsappSession::where('user_id', $business_id)->orderBy('id', 'desc')->first();
        
        if($whatsappSession == '' || (isset($whatsappSession->instance_id) && $whatsappSession->instance_id == '')){
            return response()->json(["success" => false, "message" => "Your business account is not linked to Whatsapp."]);
        }



        $offerIds = Offer::where('user_id',$business_id)->pluck('id')->toArray();
        
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

            return response()->json(["success" => true, 'data' => $redeem, 'targets' => $targets, "message" => "Coupon is valid. Please Proceed Payment."]);
        }
    }

    public function proceedRedeem(Request $request){
        $data = $request->data;
        if(!empty($data)){
            
            $redeem = Redeem::where('id', $data['redeem_id'])->orderBy('id', 'desc')->first();

            if($redeem){

                //get achieved unique clicks count
                $clicks = Target::where('offer_subscribe_id',$redeem->offer_subscribe_id)->where('repeated',0)->orderBy('id','desc')->count();

                $invoice_no = $this->getInvoiceNo($data['offer_id']);
                if($data['invoice'] == ''){
                    $redeem_invoice_no = $invoice_no;
                }else{
                    $redeem_invoice_no = $data['invoice'];
                }

                $redeem_detail  =  RedeemDetail::Create([
                                    'offer_id' => $data['offer_id'],
                                    'offer_subscribe_id' => $redeem->offer_subscribe_id,
                                    'redeem_id' => $data['redeem_id'],  
                                    'redeem_invoice_no' => $redeem_invoice_no,
                                    'invoice_no' => $invoice_no,
                                    'no_of_clicks' => $clicks,
                                    'actual_amount' => $data['actualAmount'],
                                    'discount_type' => $data['discount_type'],
                                    'discount_value' => $data['discount_value'],
                                    'redeem_amount' => $data['redeem_amount'],
                                    'calculated_amount' => $data['calculated_amount'],
                                ]);


                if(!$redeem_detail){
                    return response()->json(["success" => false, 'data' => [], "message" => "Saving redeem details failed."]);
                }



                /*whatsapp login check*/

                $offer = Offer::findorFail($data['offer_id']);
                
                $whatsappSession = WhatsappSession::where('user_id', Auth::id())->orderBy('id', 'desc')->first();
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
                
                $message_data = CommonSettingController::checkSendFlag(Auth::id(),$type_id);
                if(!$message_data['sendFlag']){
                    return response()->json(["success" => false, "message" => "Sorry your msg limit exceed!."]);
                }

                $msg = '';
                $businessDetail = BusinessDetail::where("user_id",Auth::id())->orderBy('id','desc')->first();
                if($businessDetail != ''){
                    $msg = $businessDetail->business_msg;
                }

                /* Send Redeem Details on Whatsapp */
                $subscription = OfferSubscription::where('id',$redeem->offer_subscribe_id)->orderBy('id','desc')->first();
                $customer = Customer::where('id',$subscription->customer_id)->orderBy('id','desc')->first();
                $phoneNumber = '91'.$customer->mobile;

                $payload = WhatsAppMsgController::afterRedeemedMsg($data['discount_type'], ucfirst($businessDetail->business_name), $msg, $data['actualAmount'], $data['discount_value'], ($data['actualAmount'] - $data['redeem_amount']), $data['redeem_amount']);
                $wpa_res = WhatsAppMsgController::sendTextMessageWP($phoneNumber, $payload);
                $res = json_decode($wpa_res);

                if($res != '' && $res->status == 'success'){
                    //
                }else{
                    return response()->json(["success" => false, "message" => "Redeem invoice failed to send on Whatsapp."]);
                }
                
                $redeem->is_redeemed = 1;
                if($redeem->save()){

                    //cashback offer
                    $offerFuture = OfferFuture::where('offer_id',$data['offer_id'])->first();
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

    public function reports(Request $request){

        $dates = array();
        $type = $date_range = '';

        if(isset($request->date_range) && $request->date_range != null){
            $dates = explode(' - ',$request->date_range);
            $date_range = $request->date_range;
        }else{
            $startDate = Carbon::now();
            $firstDay = $startDate->firstOfMonth()->format('d-m-Y'); 
            $lastDay = Carbon::now()->format('d-m-Y');
            $dates = array(0 => $firstDay, 1 => $lastDay);
            $date_range = $firstDay.' - '.$lastDay;
        }

        if(isset($request->offer_type) && $request->offer_type != null){
            $type = $request->offer_type;
        }

        $start_date = date('Y-m-d 00:00:00', strtotime($dates[0]));
        $end_date = date('Y-m-d 23:59:59', strtotime($dates[1]));

        if(!empty($dates) && $type != ''){
            $offer_ids = Offer::where('user_id',Auth::id())->where('type', $type)->pluck('id')->toArray();
            $data = RedeemDetail::with('subscription_details')->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->whereIn('offer_id',$offer_ids)->get();
        }else if(!empty($dates) && $type == ''){
            $offer_ids = Offer::where('user_id',Auth::id())->pluck('id')->toArray();
            $data = RedeemDetail::with('subscription_details')->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->whereIn('offer_id',$offer_ids)->get();
        }else{

            $offer_ids = Offer::where('user_id',Auth::id())->pluck('id')->toArray();
            $data = RedeemDetail::with('subscription_details')->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->whereIn('offer_id',$offer_ids)->get();
        }

        $records = array();
        // If customer deleted
        foreach($data as $record){
            if(isset($record->subscription_details->customer->mobile)){
                $records[] = $record;
            }
        }

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        return view('business.redeem.reports', compact('records','notification_list','planData', 'date_range', 'type'));
    }

    public function export_to_pdf(Request $request){
        
        $dates = array();
        $type = $date_range = '';

        if(isset($request->date_range) && $request->date_range != null){
            $dates = explode(' - ',$request->date_range);
            $date_range = $request->date_range;
        }else{
            $startDate = Carbon::now();
            $firstDay = $startDate->firstOfMonth()->format('d-m-Y'); 
            $lastDay = Carbon::now()->format('d-m-Y');
            $dates = array(0 => $firstDay, 1 => $lastDay);
            $date_range = $firstDay.' - '.$lastDay;
        }

        if(isset($request->offer_type) && $request->offer_type != null){
            $type = $request->offer_type;
        }

        $start_date = date('Y-m-d 00:00:00', strtotime($dates[0]));
        $end_date = date('Y-m-d 23:59:59', strtotime($dates[1]));

        if(!empty($dates) && $type != ''){
            $offer_ids = Offer::where('user_id',Auth::id())->where('type', $type)->pluck('id')->toArray();
            $data = RedeemDetail::with('subscription_details')->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->whereIn('offer_id',$offer_ids)->get();
        }else if(!empty($dates) && $type == ''){
            $offer_ids = Offer::where('user_id',Auth::id())->pluck('id')->toArray();
            $data = RedeemDetail::with('subscription_details')->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->whereIn('offer_id',$offer_ids)->get();
        }else{

            $offer_ids = Offer::where('user_id',Auth::id())->pluck('id')->toArray();
            $data = RedeemDetail::with('subscription_details')->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->whereIn('offer_id',$offer_ids)->get();
        }

        $records = array();
        // If customer deleted
        foreach($data as $record){
            if(isset($record->subscription_details->customer->mobile)){
                $records[] = $record; 
            }
        }


        // calculate data from records
        $total_amo = $recieved_amo = $discount_amo = $total_discounted = 0;
        if (!empty($records)) {
            foreach ($records as $row) {
                $total_amo = $total_amo + $row->actual_amount;
                $recieved_amo = $recieved_amo + $row->redeem_amount;
                $discount_amo = $discount_amo + ($row->actual_amount - $row->redeem_amount);
            }
            $total_discounted = number_format(($discount_amo / $total_amo) * 100, 2);
        }

        $customPaper = array(0,20,794.00,1123.00);
        $pdf = \PDF::loadView('business.redeem.download-report', compact('records', 'date_range','total_amo','recieved_amo','discount_amo', 'total_discounted'))->setOptions(['defaultFont' => 'sans-serif', 'enable_remote' => true])->setPaper($customPaper, 'portrait');

        return $pdf->download('redeem-report.pdf');
        // return $pdf->stream('redeem-report.pdf');
    }

    public function export_to_excel(Request $request){

        $dates = array();
        $type = $date_range = '';

        if(isset($request->date_range) && $request->date_range != null){
            $dates = explode(' - ',$request->date_range);
            $date_range = $request->date_range;
        }else{
            $startDate = Carbon::now();
            $firstDay = $startDate->firstOfMonth()->format('d-m-Y'); 
            $lastDay = Carbon::now()->format('d-m-Y');
            $dates = array(0 => $firstDay, 1 => $lastDay);
            $date_range = $firstDay.' - '.$lastDay;
        }

        if(isset($request->offer_type) && $request->offer_type != null){
            $type = $request->offer_type;
        }

        $start_date = date('Y-m-d 00:00:00', strtotime($dates[0]));
        $end_date = date('Y-m-d 23:59:59', strtotime($dates[1]));

        if(!empty($dates) && $type != ''){
            $offer_ids = Offer::where('user_id',Auth::id())->where('type', $type)->pluck('id')->toArray();
            $records = RedeemDetail::with('subscription_details')->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->whereIn('offer_id',$offer_ids)->get();
        }else if(!empty($dates) && $type == ''){
            $offer_ids = Offer::where('user_id',Auth::id())->pluck('id')->toArray();
            $records = RedeemDetail::with('subscription_details')->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->whereIn('offer_id',$offer_ids)->get();
        }else{
            $offer_ids = Offer::where('user_id',Auth::id())->pluck('id')->toArray();
            $records = RedeemDetail::with('subscription_details')->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->whereIn('offer_id',$offer_ids)->get();
        }

        $data_collect = array();

        foreach ($records as $row) {
            if(isset($row->subscription_details->customer->mobile)){

                $disc_type_icon = ($row->discount_type == "Percentage") ? '%' : 'INR';
                $discount = $row->discount_value;
                $discount_type = '';

                if ($row->discount_type == "Percentage") {
                    $discount .= '%';
                }else{
                    $discount = 'INR '.$discount;
                }

                if ($row->discount_type == "Percentage"){
                    $discount_type = 'Percentage Discount';
                }
                elseif ($row->discount_type == "Perclick"){
                    $discount_type = 'Cash Per Click Discount';
                }
                elseif ($row->discount_type == "Fixed"){
                    $discount_type = 'Fixed Amount Discount';
                }

                $data_row = array(
                    'CUSTOMER' => $row->subscription_details->customer->mobile,
                    'OFFER ID' => $row->subscription_details->offer->uuid,
                    'OFFER TYPE' => ($row->subscription_details->offer->type == 'future') ? 'Share & Reward' : 'Instant Reward',
                    'BILL AMOUNT' => $row->actual_amount,
                    'PAID AMOUNT' => $row->redeem_amount,
                    'DISCOUNT AMOUNT' => number_format($row->actual_amount - $row->redeem_amount, 2),
                    'DISCOUNT' => $discount,
                    'DISCOUNT TYPE' => $discount_type,
                    'DATE' => Carbon::parse($row->created_at)->format('d/m/Y'),
                    'TIME' => Carbon::parse($row->created_at)->format('H:i')
                );
                array_push($data_collect, $data_row);
            }
        }

        $record = collect($data_collect);

        return (new FastExcel($record))->download('redeem-report-excel.xlsx');
        
    }
}
