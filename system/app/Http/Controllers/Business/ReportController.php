<?php

namespace App\Http\Controllers\Business;

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
    //

    public function __construct()
    {
        $this->middleware('business');
    }

    public function index(Request $request)
    {
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();
        $userBalance = DeductionHelper::getUserWalletBalance(Auth::id());
        return view('business.reports.index', compact('notification_list', 'planData', 'userBalance'));
    }

    public function getRedeems(Request $request)
    {
        if ($request->ajax()) {
            $redeem_search = $request->redeem_search ?? '';

            // $redeemPageNum = $request->page ?? 1;
            $redeems = Redeem::with('subscription', 'redeem_details')
                ->whereHas('subscription', function ($query) use ($redeem_search) {
                    $query
                        ->whereHas('customer', function ($q) use ($redeem_search) {
                            $q->where('mobile', 'like', '%' . $redeem_search . '%');
                        })
                        ->orWhereHas('offer_details', function ($q) use ($redeem_search) {
                            $q->where('title', 'like', '%' . $redeem_search . '%')->where('user_id', '=', Auth::id());
                        });
                })
                ->where('user_id', Auth::id())
                ->orderBy('id', 'DESC')
                ->get();

            return Datatables::of($redeems)
                ->addIndexColumn()
                ->addColumn('customer number', function ($q) {
                    $name_number = $q->subscription->customer->mobile;
                    if ($q->subscription->customer->getCustomerDetails != null) {
                        $name_number = $q->subscription->customer->getCustomerDetails->name . '<p>(' . $q->subscription->customer->mobile . ')</p>';
                    }
                    return $name_number;
                })
                ->addColumn('offer title', function ($q) {
                    return $q->subscription->offer_details->title;
                })
                ->addColumn('challenge type', function ($q) {
                    $challenge_type = '';
                    if ($q->subscription->channel_id == 3) {
                        $challenge_type = '<span class="badge badge-warning">Share Challenge</span>';
                    } elseif ($q->subscription->channel_id == 2) {
                        $challenge_type = '<span class="badge badge-warning">Instant Challenge</span>';
                    } else {
                        $challenge_type = '-';
                    }
                    return $challenge_type;
                })
                ->addColumn('redeem status', function ($q) {
                    $redeemed_status = '';
                    if ($q->is_redeemed == 1) {
                        $redeemed_status = '<span class="badge badge-success">Redeemed</span>';
                    } else {
                        $redeemed_status = '<span class="badge badge-warning">Pending</span>';
                    }
                    return $redeemed_status;
                })
                ->addColumn('redeem type', function ($q) {
                    $redeem_type = '-';
                    if ($q->redeem_details != '' && $q->redeem_details->discount_type) {
                        $redeem_type = $q->redeem_details->discount_type;
                    }
                    return $redeem_type;
                })
                ->addColumn('amount', function ($q) {
                    $amount = '-';
                    if ($q->redeem_details != '' && $q->redeem_details->actual_amount) {
                        $amount = $q->redeem_details->actual_amount;
                    }
                    return number_format((float) $amount, 2);
                })
                ->addColumn('paid amount', function ($q) {
                    $paid_amount = '-';
                    if ($q->redeem_details != '' && $q->redeem_details->redeem_amount) {
                        $paid_amount = $q->redeem_details->redeem_amount;
                    }
                    return number_format((float) $paid_amount, 2);
                })
                ->addColumn('discount received', function ($q) {
                    $discount_received = '-';
                    if ($q->redeem_details != '' && $q->redeem_details->discount_received) {
                        $discount_received = $q->redeem_details->discount_received;
                    }
                    return number_format((float) $discount_received, 2);
                })
                ->addColumn('redeemed date', function ($q) {
                    $redeemed_date = '-';
                    if ($q->is_redeemed == 1) {
                        $redeemed_date = $q->redeem_details != null ? \Carbon\Carbon::parse($q->redeem_details->created_at)->format('j M, Y h:i A') : '-';
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

            $subscriptions = OfferSubscription::with('customer', 'offer_details', 'reward')
                ->withCount('targets', 'completed_task')
                ->where('user_id', Auth::id())
                ->whereHas('customer', function ($query) use ($sub_search) {
                    $query->where('mobile', 'like', '%' . $sub_search . '%');
                })
                ->orWhereHas('offer_details', function ($query) use ($sub_search) {
                    $query->where('title', 'like', '%' . $sub_search . '%')->where('user_id', '=', Auth::id());
                })
                ->orderBy('id', 'DESC')
                ->get();

            return Datatables::of($subscriptions)
                ->addIndexColumn()
                ->addColumn('offer title', function ($q) {
                    return $q->offer_details->title;
                })
                ->addColumn('subscriber number', function ($q) {
                    $name_number = $q->customer->mobile;
                    if ($q->customer->getCustomerDetails != null) {
                        $name_number = $q->customer->getCustomerDetails->name . '<p>(' . $q->customer->mobile . ')</p>';
                    }
                    return $name_number;
                })
                ->addColumn('status', function ($q) {
                    $status = '';
                    if ($q->status == 1) {
                        $status = '<span class="badge badge-primary">Active</span>';
                    } elseif ($q->status == 2) {
                        $status = '<span class="badge badge-success">Completed</span>';
                    } else {
                        $status = '<span class="badge badge-danger">Expired</span>';
                    }
                    return $status;
                })
                ->addColumn('challenge type', function ($q) {
                    $challenge_type = '-';
                    if ($q->channel_id == 3) {
                        $challenge_type = '<span class="badge badge-warning">Share Challenge</span>';
                    } elseif ($q->channel_id == 2) {
                        $challenge_type = '<span class="badge badge-warning">Instant Challenge</span>';
                    }
                    return $challenge_type;
                })
                ->addColumn('challenge details', function ($q) {
                    if ($q->offer_details->type == 'standard') {
                        $offer_link = url('/business/offer/preview/' . $q->offer_details->id);
                    } else {
                        $offer_link = url('/business/offer/custom/preview/' . $q->offer_details->id);
                    }

                    $reward_details = json_decode($q->reward->details);

                    $challenge_details = '<p style="margin-bottom: 0;"><b>Type: </b>' . $q->reward->type . '</p>';

                    if ($q->channel_id == 2) {
                        $challenge_details .=
                            '<p style="margin-bottom: 0;">
                        <b>Minimum Tasks: </b>' .
                            $reward_details->minimum_task .
                            '</p>';
                    } elseif ($q->channel_id == 3) {
                        $challenge_details .=
                            '<p style="margin-bottom: 0;">
                        <b>Minimum Clicks: </b>' .
                            $reward_details->minimum_click .
                            '</p>';
                    }

                    if ($q->reward->type == 'Gift') {
                        $challenge_details .= '<p style="margin-bottom: 0;"><b>Gift: </b>' . $reward_details->gift . '</p>';
                    }

                    if ($q->reward->type == 'Fixed Amount') {
                        $challenge_details .= '<p style="margin-bottom: 0;"><b>Discount: </b>&#8377;' . number_format((float) $reward_details->discount_amount, 2) . '</p>';
                    }

                    if ($q->reward->type == 'Cash Per Click') {
                        $challenge_details .= '<p style="margin-bottom: 0;"><b>Discount: </b>&#8377;' . number_format((float) $reward_details->discount_perclick, 2) . '</p>';
                    }

                    if ($q->reward->type == 'Percentage Discount') {
                        $challenge_details .= '<p style="margin-bottom: 0;"><b>Discount: </b>&#8377;' . number_format((float) $reward_details->discount_percent, 2) . '</p>';
                    }

                    return $challenge_details;
                })
                ->addColumn('unique clicks', function ($q) {
                    $unique_clicks = '-';
                    if ($q->channel_id == 3) {
                        $unique_clicks = '<span class="badge badge-success">' . $q->targets_count . '</span>';
                    }
                    return $unique_clicks;
                })
                ->addColumn('completed challenge', function ($q) {
                    $completed_challenge = '-';
                    if ($q->channel_id == 2) {
                        $completed_challenge = '<span class="badge badge-success">' . $q->completed_task_count . '</span>';
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

            $messages = MessageHistory::with(['channel', 'customerDetails'])
                ->where('mobile', 'like', '%' . $msg_search . '%')
                ->where('user_id', Auth::id())
                ->orderBy('id', 'DESC')
                ->get();

            return Datatables::of($messages)
                ->addIndexColumn()
                ->addColumn('customer number', function ($q) {
                    $mobile = '';
                    $name = '';
                    $name_number = '';
                    if ($q->customerDetails != null && $q->customerDetails->info != null) {
                        $name = $q->customerDetails->info->name;
                    }

                    if (strlen($q->customerDetails->mobile) == 12) {
                        $mobile = substr($q->customerDetails->mobile, 2);
                    } else {
                        $mobile = $q->customerDetails->mobile;
                    }

                    if ($name != '' && $mobile != '') {
                        $name_number = $name . '<p class="mb-0">(' . $mobile . ')</p>';
                    } elseif ($name == '' && $mobile != '') {
                        $name_number = $mobile;
                    } elseif ($name != '' && $mobile == '') {
                        $name_number = $name;
                    }
                    return $name_number;
                })
                ->addColumn('sent by', function ($q) {
                    return $q->channel->name ?? $q->sent_by;
                })
                ->addColumn('sent via', function ($q) {
                    $sent_via = '<span class="badge badge-primary">SMS</span>';
                    if ($q->sent_via == 'wa') {
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
                    if ($q->status == 1) {
                        $status = '<span class="badge badge-success">Success</span>';
                    }
                    return $status;
                })
                ->addColumn('view message', function ($q) {
                    $name = '';
                    if ($q->customerDetails != null && $q->customerDetails->info != null) {
                        $name = $q->customerDetails->info->name;
                    }

                    $starReplace = str_replace(' *', ' <b>', $q->content);
                    $starReplace = str_replace('*', '</b>', $starReplace);

                $starReplace = str_replace(' *', " <b>", $q->content);
                $starReplace = str_replace('*', "</b>", $starReplace);
                
                    $findLink = ' opnl.in';
                    $position = strpos($starReplace, $findLink);

                    if ($position == true) {
                        $linkExplode = explode('opnl.in/', $starReplace);

                        $linkReplace = preg_replace('/^\w+/', '[LINK]', $linkExplode[1]);
                        
                        $array = [$linkExplode[0], $linkReplace];

                        $linkImplode = implode('', $array);

                        $starReplace = str_replace(' opnl.in[LINK]', '[LINK]', $linkImplode);
                    }

                    $data = [];

                    $nam = '';
                    if($name != ''){
                        $nam =  '<p><span class="font-weight-bold">Name:</span> '.$name.'</p>';
                    }
                    $mobnum = '';
                    if($q->mobile != ''){
                        $mobnum =  '<p><span class="font-weight-bold">Mobile Number:</span> '.$q->mobile.'</p>';
                    }

                    return '<a class="btn btn-primary pull-bs-canvas-right" data-content="#report-message' .
                        $q->id .
                        '" data-toggle="canvas" href="#pull-bs-canvas-right" aria-expanded="false" aria-controls="pull-bs-canvas-right" role="button">View Details</a>
                <div class="d-none" id="report-message' .
                        $q->id .
                        '">
                    <div class="customer-details">
                        <!-- Message Status table-->
                        <div class="msg-status-table mt-2">
                            <h6 class="mb-3 text-primary">Message Details</h6>
                            
                            '.$nam.'
                            '.$mobnum.'
                            <p class="mb-1"><span class="font-weight-bold">Message:</span> </p>
                            <p class="message-content">' .
                        $starReplace .
                        '</p>
                            
                        </div>
                    </div>
                </div>';
                })
                ->escapeColumns([])
                ->make(true);
        }
    }

    public function getDeductions(Request $request)
    {
        if ($request->ajax()) {
            $deductionHistory = DeductionHistory::with('getUserDeductionReport', 'user', 'deduction', 'businessCustomer', 'getEmployees')
                ->whereUserId(Auth::id())
                ->orderBy('id', 'DESC')
                ->get();
            // dd($deductionHistory);
            return Datatables::of($deductionHistory)
                ->addIndexColumn()
                ->addColumn('name', function ($q) {
                    $name_number = '';
                    if (@$q->businessCustomer->name != null && @$q->businessCustomer->buCustomerInfo->mobile != null) {
                        $name_number = $q->businessCustomer->name . '<p>(' . $q->businessCustomer->buCustomerInfo->mobile . ')</p>';
                    } elseif (@$q->businessCustomer->name != null && @$q->businessCustomer->buCustomerInfo->mobile == null) {
                        $name_number = $q->businessCustomer->name;
                    } elseif (@$q->businessCustomer->name == null && @$q->businessCustomer->buCustomerInfo->mobile != null) {
                        $name_number = $q->businessCustomer->buCustomerInfo->mobile;
                    } elseif (@$q->getEmployees->name != null && @$q->getEmployees->mobile != null) {
                        $name_number = $q->getEmployees->name . '<p>(' . $q->getEmployees->mobile . ')</p>';
                    } elseif (@$q->getEmployees->name != null && @$q->getEmployees->mobile == null) {
                        $name_number = $q->getEmployees->name;
                    } elseif (@$q->getEmployees->name == null && @$q->getEmployees->mobile != null) {
                        $name_number = $q->getEmployees->mobile;
                    } elseif (@$q->customer_id == 0 && @$q->employee_id == 0) {
                        $name_number = $q->user->name . '<p>(' . $q->user->mobile . ')</p>';
                    }
                    return $name_number;
                })
                ->addColumn('deduction towards', function ($q) {
                    return '<span class="badge badge-warning">' . $q->deduction->name . '</span>';
                })
                ->addColumn('deduction amount', function ($q) {
                    return '<span class="badge badge-success">' . $q->deduction_amount . '</span>';
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
            $socialImpact = SocialOfferCount::whereUserId(Auth::id())
                ->with('offer')
                ->orderBy('id', 'DESC')
                ->get();

            return Datatables::of($socialImpact)
                ->addIndexColumn()
                ->addColumn('offer title', function ($r) {
                    $offer_nm = $r->offer->title;
                    $offer_typ = $r->offer->type;
                    $offer_id = $r->offer->id;

                    if ($offer_typ != 'custom') {
                        $preview_url = route('business.offerPreview', $offer_id);
                    } else {
                        $preview_url = route('business.customOfferPreview', $offer_id);
                    }
                    // return $r->offer->title;
                    $offr_titl = '<a href="' . $preview_url . '" class="link-info " data-toggle="tooltip" title="Click to Preview Offer">' . $r->offer->title . '</a>';
                    return $offr_titl;
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
