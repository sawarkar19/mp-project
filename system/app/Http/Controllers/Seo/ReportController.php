<?php

namespace App\Http\Controllers\Seo;

use Auth;
use DB;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use App\Models\User;
use App\Models\Redeem;
use Illuminate\Http\Request;
use App\Models\MessageHistory;
use App\Models\SocialOfferCount;
use App\Models\Offer;
use App\Models\DeductionHistory;
use App\Models\OfferSubscription;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Business\CommonSettingController;
use App\Helper\Deductions\DeductionHelper;


class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request ,$id )
    {
        $userId = decrypt($id);
        // dd($userId );
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();
        $userBalance = DeductionHelper::getUserWalletBalance($userId);
        // dd($userBalance);
        return view('seo.indexReport', compact('notification_list','planData','userBalance','id'));
    }

    public function getRedeems(Request $request)
    {
        if ($request->ajax()) {
            $redeem_search = $request->redeem_search ?? '';
            $id = decrypt($request->id);
            // $redeemPageNum = $request->page ?? 1;
            $redeems = Redeem::with('subscription', 'redeem_details')
            ->whereHas('subscription', function($query) use($redeem_search, $id) {
                $query->whereHas('customer', function($q) use($redeem_search, $id) {
                    $q->where('mobile', 'like', '%' . $redeem_search . '%');
                })->orWhereHas('offer_details', function($q) use($redeem_search, $id) {
                    $q->where('title', 'like', '%' . $redeem_search . '%')
                        ->where('user_id', '=', $id);
                });
            })->where('user_id', $id)->orderBy('id', 'DESC')->get();

            return Datatables::of($redeems)
                    ->addIndexColumn()
                    ->addColumn('customer number', function ($q) {
                        return $q->subscription->customer->mobile;
                    })
                    ->addColumn('offer title', function ($q) {
                        return $q->subscription->offer_details->title;
                    })
                    ->addColumn('challenge type', function ($q) {
                        $challenge_type = '';
                        if($q->subscription->channel_id == 3){
                            $challenge_type = '<span class="badge badge-warning">Share Challenge</span>';
                        }else if($q->subscription->channel_id == 2){
                            $challenge_type = '<span class="badge badge-warning">Instant Challenge</span>';
                        }else{
                            $challenge_type = '-';
                        }
                        return $challenge_type;
                    })
                    ->addColumn('redeem status', function ($q) {
                        $redeemed_status = '';
                        if($q->is_redeemed == 1){
                            $redeemed_status = '<span class="badge badge-success">Redeemed</span>';
                        }else{
                            $redeemed_status = '<span class="badge badge-warning">Pending</span>';
                        }
                        return $redeemed_status;
                    })
                    ->addColumn('redeem type', function ($q) {
                        $redeem_type = '-';
                        if($q->redeem_details != '' && $q->redeem_details->discount_type){
                            $redeem_type = $q->redeem_details->discount_type;
                        }
                        return $redeem_type;
                    })
                    ->addColumn('amount', function ($q) {
                        $amount = '-';
                        if($q->redeem_details != '' && $q->redeem_details->actual_amount){
                            $amount = $q->redeem_details->actual_amount;
                        }
                        return number_format((float)$amount,2);
                    })
                    ->addColumn('paid amount', function ($q) {
                        $paid_amount = '-';
                        if($q->redeem_details != '' && $q->redeem_details->redeem_amount){
                            $paid_amount = $q->redeem_details->redeem_amount;
                        }
                        return number_format((float)$paid_amount,2);
                    })
                    ->addColumn('discount received', function ($q) {
                        $discount_received = '-';
                        if($q->redeem_details != '' && $q->redeem_details->discount_received){
                            $discount_received = $q->redeem_details->discount_received;
                        }
                        return number_format((float)$discount_received,2);
                    })
                    ->addColumn('discount received', function ($q) {
                        $discount_received = '-';
                        if($q->redeem_details != '' && $q->redeem_details->discount_received){
                            $discount_received = $q->redeem_details->discount_received;
                        }
                        return $discount_received;
                    })
                    ->addColumn('redeemed date', function ($q) {
                        $redeemed_date = '-';
                        if($q->is_redeemed == 1){
                            $redeemed_date = \Carbon\Carbon::parse($q->redeem_details->created_at)->format('j M, Y h:i A');
                        }
                        return $redeemed_date;
                    })
                    ->escapeColumns([])
                    ->make(true);
        }
    }

    public function getSubscriptions(Request $request)
    {
        if ($request->ajax()) {
            $sub_search = $request->sub_search ?? '';
            $id = decrypt($request->id);
            

            $subscriptions = OfferSubscription::with('customer', 'offer_details', 'reward')->withCount('targets', 'completed_task')
            ->where('user_id', $id)
            ->whereHas('customer', function($query) use($sub_search, $id) {
                $query->where('mobile', 'like', '%' . $sub_search . '%');
            })->orWhereHas('offer_details', function($query) use($sub_search, $id) {
                $query->where('title', 'like', '%' . $sub_search . '%')
                        ->where('user_id', '=', $id);
            })->orderBy('id', 'DESC')->get();

            return Datatables::of($subscriptions)
                ->addIndexColumn()
                ->addColumn('offer title', function ($q) {
                    return $q->offer_details->title;
                })
                ->addColumn('subscriber number', function ($q) {
                    return $q->customer->mobile;
                })
                ->addColumn('status', function ($q) {
                    $status = '';
                    if($q->status == 1){
                        $status = '<span class="badge badge-primary">Active</span>';
                    }else if($q->status == 2){
                        $status = '<span class="badge badge-success">Completed</span>';
                    }else{
                        $status = '<span class="badge badge-danger">Expired</span>';
                    }
                    return $status;
                })
                ->addColumn('challenge type', function ($q) {
                    $challenge_type = '-';
                    if($q->channel_id == 3){
                        $challenge_type = '<span class="badge badge-warning">Share Challenge</span>';
                    }elseif($q->channel_id == 2){
                        $challenge_type = '<span class="badge badge-warning">Instant Challenge</span>';
                    }
                    return $challenge_type;
                })
                ->addColumn('challenge details', function ($q) {
                    if($q->offer_details->type == 'standard'){
                        $offer_link = url('/business/offer/preview/'.$q->offer_details->id);
                    }else{
                        $offer_link = url('/business/offer/custom/preview/'.$q->offer_details->id);
                    }

                    $reward_details = json_decode($q->reward->details);

                    $challenge_details = '<p style="margin-bottom: 0;"><b>Type: </b>'. $q->reward->type.'</p>';

                    if($q->channel_id == 2){
                        $challenge_details .= '<p style="margin-bottom: 0;">
                        <b>Minimum Tasks: </b>'.$reward_details->minimum_task.'</p>';
                    }elseif ($q->channel_id == 3) {
                        $challenge_details .= '<p style="margin-bottom: 0;">
                        <b>Minimum Clicks: </b>'.$reward_details->minimum_click.'</p>';
                    }

                    if($q->reward->type == 'Gift'){
                        $challenge_details .= '<p style="margin-bottom: 0;"><b>Gift: </b>'.$reward_details->gift.'</p>';
                    }

                    if($q->reward->type == 'Fixed Amount'){
                        $challenge_details .= '<p style="margin-bottom: 0;"><b>Discount: </b>&#8377;'.number_format((float)$reward_details->discount_amount,2).'</p>';
                    }

                    if($q->reward->type == 'Cash Per Click'){
                        $challenge_details .= '<p style="margin-bottom: 0;"><b>Discount: </b>&#8377;'.number_format((float)$reward_details->discount_perclick,2).'</p>';
                    }

                    if($q->reward->type == 'Percentage Discount'){
                        $challenge_details .= '<p style="margin-bottom: 0;"><b>Discount: </b>&#8377;'.number_format((float)$reward_details->discount_percent,2).'</p>';
                    }

                    return $challenge_details;
                })
                ->addColumn('unique clicks', function ($q) {
                    $unique_clicks = '-';
                    if($q->channel_id == 3){
                        $unique_clicks = '<span class="badge badge-success">'.$q->targets_count.'</span>';
                    }
                    return $unique_clicks;
                })
                ->addColumn('completed challenge', function ($q) {
                    $completed_challenge = '-';
                    if($q->channel_id == 2){
                        $completed_challenge = '<span class="badge badge-success">'.$q->completed_task_count.'</span>';
                    }
                    return $completed_challenge;
                })
                ->addColumn('subscription date', function ($q) {
                    $subscription_date = '-';
                    $subscription_date = \Carbon\Carbon::parse($q->created_at)->format('j M, Y h:i A');
                    return $subscription_date;
                })
                ->escapeColumns([])
                ->make(true);
        }
    }

    public function getMessages(Request $request)
    {
        if ($request->ajax()) {
            $msg_search = $request->msg_search ?? '';
            $id = decrypt($request->id);

            $messages = MessageHistory::with('channel','customerDetails')
                                      ->where('mobile', 'like', '%' . $msg_search . '%')
                                      ->where('user_id', $id)->orderBy('id', 'DESC')->get();

            return Datatables::of($messages)
            ->addIndexColumn()
            ->addColumn('customer number', function ($q) {
                $mobile = '';
                $name = '';
                $name_number = '';
                if($q->customerDetails != NULL && $q->customerDetails->info != NULL){
                    $name = $q->customerDetails->info->name;
                }

                if(strlen($q->customerDetails->mobile) == 12){
                    $mobile = substr($q->customerDetails->mobile, 2);
                }else{
                    $mobile = $q->customerDetails->mobile;
                }

                if($name != '' && $mobile != ''){
                    $name_number = $name.'<p>('.$mobile.')</p>';
                }elseif ($name == '' && $mobile != '') {
                    $name_number = $mobile;
                }elseif ($name != '' && $mobile == '') {
                    $name_number = $name;
                }
                return $name_number;
            })
            ->addColumn('sent by', function ($q) {
                return $q->channel->name ?? $q->sent_by;
            })
            ->addColumn('sent via', function ($q) {
                $sent_via = '<span class="badge badge-primary">SMS</span>';
                if($q->sent_via == 'wa'){
                    $sent_via = '<span class="badge badge-success">Whatsapp</span>';
                }
                return $sent_via;
            })
            ->addColumn('sent date', function ($q) {
                $sent_date = \Carbon\Carbon::parse($q->created_at)->format('j M, Y h:i A');
                return $sent_date;
            })
            ->addColumn('status', function ($q) {
                $status = '<span class="badge badge-warning">Pending</span>';
                if($q->status == 1){
                    $status = '<span class="badge badge-success">Success</span>';
                }
                return $status;
            })
            ->addColumn('view message', function ($q) {
                $view_messg = '<span class="badge badge-primary" data-toggle="tooltip" data-placement="top"  title="'.$q->content.'">View Message</span>';
                return $view_messg;
            })
            ->escapeColumns([])
            ->make(true);
        }
    }

    public function getDeductions(Request $request)
    {
        if ($request->ajax()) {
            $id = decrypt($request->id);
            $deductionHistory = DeductionHistory::with('getUserDeductionReport','user','deduction','businessCustomer','getEmployees')
                                            ->whereUserId($id)
                                            ->get();

            return Datatables::of($deductionHistory)
            ->addIndexColumn()
            ->addColumn('name', function ($q) {
                $name = '';
                if(@$q->businessCustomer->name != NULL){
                    $name = $q->businessCustomer->name;
                }elseif (@$q->businessCustomer->name == NULL && @$q->businessCustomer->buCustomerInfo->mobile != NULL) {
                    $name = $q->businessCustomer->buCustomerInfo->mobile;
                }elseif (@$q->getEmployees->name != NULL) {
                    $name = $q->getEmployees->name;
                }elseif (@$q->getEmployees->name == NULL && @$q->getEmployees->mobile != NULL) {
                    $name = $q->getEmployees->mobile;
                }
                elseif (@$q->customer_id == 0 && @$q->employee_id == 0) {
                    $name = $q->user->name.'<p>('.$q->user->mobile.')</p>';
                }
                return $name;
            })
            ->addColumn('deduction towards', function ($q) {
                return '<span class="badge badge-warning">'.$q->deduction->name.'</span>';
            })
            ->addColumn('deduction amount', function ($q) {
                return '<span class="badge badge-success">'.$q->deduction_amount.'</span>';
            })
            ->addColumn('date', function ($q) {
                return \Carbon\Carbon::parse($q->created_at)->format('j M, Y h:i A');
            })
            ->escapeColumns([])
            ->make(true);
        }
    }

    public function getSocialImpact(Request $request)
    {
        if ($request->ajax()) {
            $id = decrypt($request->id);

                $socialImpact = SocialOfferCount::whereUserId($id)->with('offer')->orderBy('id', 'DESC')->get();

                return Datatables::of($socialImpact)
                ->addIndexColumn()
                ->addColumn('offer title', function ($r) {
                    return $r->offer->title;
                })
                ->addColumn('facebook comment', function ($q) {
                return $q->fb_comment_post_url_count;
                })
                ->addColumn('facebook like', function ($q) {
                    return $q->fb_like_post_url_count;
                })
                ->addColumn('instagram comment', function ($q) {
                    return $q->insta_comment_post_url_count;
                })
                ->addColumn('instagram like', function ($q) {
                    return $q->insta_like_post_url_count;
                })
                ->addColumn('tweet like', function ($q) {
                    return $q->tw_tweet_url_count;
                })
                ->escapeColumns([])
                ->make(true);
            
        }

    }
}
