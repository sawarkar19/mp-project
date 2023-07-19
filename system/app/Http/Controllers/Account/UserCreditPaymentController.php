<?php

namespace App\Http\Controllers\Account;

use Session;
use Carbon\Carbon;
use App\Models\Plan;
use App\Models\User;
use App\Models\State;
use App\Models\Option;
use App\Models\Channel;
use App\Models\Category;
use App\Models\PlanView;
use App\Models\Recharge;
use App\Models\Userplan;
use App\Models\PlanGroup;
use App\Models\PaymentLink;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\PlanGroupChannel;
use App\Http\Controllers\Controller;

use App\Models\Employee;
use App\Models\UserLogin;
use App\Models\DirectPost;
use App\Models\UserChannel;
use App\Models\WhatsappApi;
use App\Models\AdminMessage;
use App\Models\ContactGroup;
use App\Models\MessageRoute;
use App\Models\UserEmployee;
use App\Models\BeforePayment;
use App\Models\BusinessVcard;
use App\Models\MessageWallet;
use App\Models\BusinessDetail;
use App\Helper\Subscription\PayU;
use App\Helper\Subscription\Paytm;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use App\Helper\Subscription\Cashfree;
use App\Helper\Subscription\Instamojo;
use App\Models\MessageTemplateSchedule;
use App\Http\Controllers\ShortLinkController;
use App\Http\Controllers\UuidTokenController;

class UserCreditPaymentController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('account');
    }

    public function userCreditPayment(Request $request)
    {
        /* all user show data, search and pagination start */
        $conditions = [];
        $numberOfPage = $request->no_of_users ?? 10;
        if (!empty($request->src) && !empty($request->term)) {
            $freeUsers = User::where('is_paid', 0)
                ->where($request->term, 'like', '%' . $request->src . '%')
                ->orderBy('id', 'DESC')
                ->paginate($numberOfPage);
        } else {
            $freeUsers = User::where('is_paid', 0)
                ->orderBy('id', 'DESC')
                ->paginate($request->no_of_users);
        }
        /* all user show data, search and pagination end */

        return view('account.user-credits.user-credit-payment', compact('freeUsers', 'conditions', 'request'));
    }

    public function creditPayment($id)
    {
        $allUsers = User::find($id);

        //get data
        $plan_view = PlanView::where('status', '1')->first();
        $plans = Plan::where('status', '1')
            ->orderBy('ordering', 'asc')
            ->get();
        $groups = PlanGroup::with('channels')
            ->where('status', '1')
            ->orderBy('ordering', 'asc')
            ->get();

        $pricing_data = $this->getPricingData();

        $message_plans = Recharge::where('status', 1)
            ->orderBy('ordering', 'asc')
            ->get();
        Session([
            'user_id' => $id,
        ]);

        if ($plan_view->name == 'Group') {
            return view('account.user-credits.pricing-credit-payment', compact('plans', 'groups', 'pricing_data', 'message_plans', 'allUsers'));
        } else {
            //
        }
    }

    public function getPricingData()
    {
        $pricing_data = [];
        $plans = Plan::where('status', '1')
            ->orderBy('ordering', 'asc')
            ->get();
        $groups = PlanGroup::where('status', '1')
            ->orderBy('ordering', 'asc')
            ->get();

        foreach ($plans as $plan) {
            foreach ($groups as $group) {
                $channel_ids = PlanGroupChannel::where('plan_group_id', $group->id)
                    ->pluck('channel_id')
                    ->toArray();

                $amount = Channel::whereIn('id', $channel_ids)->sum('price');

                $pricing_data[$plan->slug][$group->slug]['total_price'] = round($amount * $plan->months);
                $pricing_data[$plan->slug][$group->slug]['payble_price'] = round($amount * $plan->months - $amount * $plan->months * ($plan->discount / 100));
                $pricing_data[$plan->slug][$group->slug]['mothly_total_price'] = $amount;
                $pricing_data[$plan->slug][$group->slug]['mothly_payble_price'] = round($amount - $amount * ($plan->discount / 100));
                $pricing_data[$plan->slug][$group->slug]['discount'] = $plan->discount;
            }
        }

        return $pricing_data;
    }

    public function setPlanData(Request $request)
    {
        if ($request->plan_slug != '') {
            Session([
                'plan_slug' => $request->plan_slug,
                'billing_type' => $request->billing_type,
                'total_price' => $request->total_price,
                'payble_price' => $request->payble_price,
            ]);

            $planData = $request->except('_token');

            return response()->json(['status' => true, 'planInfo' => $planData]);
        }

        return response()->json(['status' => false, 'planInfo' => [], 'message' => 'Something went wrong']);
    }

    public function checkoutSubscription(Request $request)
    {
        $data = Session::all();

        $userDetails = User::where('id', $data['user_id'])->first();

        $businessDetails = BusinessDetail::where('user_id', $data['user_id'])->first();

        $plan = Plan::where('is_default', 1)->first();

        $planData = [
            'plan_id' => $plan->id,
            'plan_name' => $plan->name,
            'payble_price' => 100,
        ];

        // GST calculation
        $gst_price = $planData['payble_price'] - $planData['payble_price'] * (100 / (100 + 18));
        $cgst_price = $gst_price / 2;
        $sgst_price = $gst_price / 2;
        $withoutGst_price = $planData['payble_price'] - $gst_price;

        // Other Information
        // $info = PageController::socialAndSupport();
        $states = State::where('status', 1)->get();

        // Payment Gateway
        $getway = Category::where('type', 'payment_gateway')
            ->where('status', 1)
            ->where('slug', '!=', 'cod')
            ->with('preview')
            ->first();

        return view('account.user-credits.checkout-payment', compact('userDetails', 'businessDetails', 'getway', 'states', 'planData', 'gst_price', 'cgst_price', 'sgst_price', 'withoutGst_price'));
    }

    public function SucessPayment(Request $request)
    {
        $data = Session::all();

        $selectedPlan = [];
        $paymentLink = '';
        $new_registration = 0;

        if (Session::get('selectedPlan')) {
            $selectedPlan = Session::get('selectedPlan');

            Session::forget('selectedPlan');
        }

        /* SalesRobo */
        $salesRobo = true;
        $salesRobo_msgs = 'no';
        $salesRobo_prod = 'no';
        $salesRobo_expi = 'no';
        $isExpire = false;

        $user_subscription = UserChannel::where('user_id', $data['user_id'])
            ->where('channel_id', 2)
            ->first();
        if (!empty($user_subscription)) {
            $isExpire = Carbon::now()->format('Ymd') > Carbon::parse($user_subscription->will_expire_on)->format('Ymd');
            if ($isExpire) {
                $salesRobo_expi = 'yes';
            } else {
                $salesRobo = false;
            }
        }

        $plan_id = $request->plan_id;

        // save transaction data start //

        $transactions = new Transaction();
        $transactions->invoice_no = $this->getInvoiceNo();
        $transactions->user_id = $data['user_id'];
        $transactions->gst_claim = $request->gst_claim;
        $transactions->category_id = 17;
        $transactions->gst_address = $request->gst_address ?? 0;
        $transactions->gst_state = $request->gst_state ?? 0;
        $transactions->gst_city = $request->gst_city ?? 0;
        $transactions->gst_pincode = $request->gst_pincode ?? 0;
        $transactions->gst_business_name = $request->gst_business_name ?? 0;
        $transactions->gst_number = $request->gst_number ?? 0;

        if ($request->account_number) {
            $transactions->account_number = $request->account_number;
        } elseif ($request->account_number_input_nft) {
            $transactions->account_number = $request->account_number_input_nft;
        } elseif ($request->account_number_input_upi) {
            $transactions->upi_id = $request->account_number_input_upi;
        }
        if ($request->cheque_number !== null) {
            $transactions->cheque_number = $request->cheque_number;
        }

        if ($request->transaction_id) {
            $transactions->transaction_id = $request->transaction_id;
        } elseif ($request->upi_transaction_id) {
            $transactions->transaction_id = $request->upi_transaction_id;
        }
        if ($request->cheque_date !== null) {
            $transactions->cheque_date = date('Y-m-d', strtotime($request->cheque_date));
        }

        if ($request->nft_date) {
            $transactions->date = date('Y-m-d', strtotime($request->nft_date));
        } elseif ($request->upi_date) {
            $transactions->date = date('Y-m-d', strtotime($request->upi_date));
        }
        $transactions->total_amount = $request->payble_price;
        $transactions->transaction_amount = $request->payble_price;
        $transactions->status = 1;
        $transactions->save();
        // save transaction data end //

        //create message wallet start //
        $wallet = MessageWallet::where('user_id', $data['user_id'])->first();
        $wallet->wallet_balance = $wallet->wallet_balance + $request->payble_price;
        $wallet->save();
        //create message wallet end //

        //user is paid successfully start //
        $user = User::where('id', $data['user_id'])->first();
        $user->is_paid = 1;
        $user->save();
        //user is paid successfully end //

        Session::flash('success', 'Thank You For Subscribe,You Will Get A Notification Mail From Admin');

        // $data['info'] = $userplan;
        $data['to_admin'] = env('MAIL_TO');
        $data['from_email'] = $user->email;

        /* Mark as used */
        if ($paymentLink != '') {
            $paymentLink->is_used = 1;
            $paymentLink->save();
        }

        $gst = $request->payble_price - $request->payble_price * (100 / (100 + 18));
        $priceWithoutGst = $request->payble_price - $gst;

        $gst_state = $request->gst_state;
        $plan_name = $data['plan_name'];
        $amount = $request->payble_price;

        $emailData = [
            'id' => $data['user_id'],
            'name' => $user->name,
            'mobile' => $user->mobile,
            'email' => $user->email,
            'token' => $user->pass_token,
            'plan_name' => $plan_name,
            'plan_price' => $amount,
            'plan_gst' => $gst,
            'gst_state' => $request->gst_state,
            'plan_without_gst' => $priceWithoutGst,
            'plan_date' => $transactions->created_at,
        ];

        /* Welcome Notification */
        if ($new_registration == 1) {
            /* Message */
            $long_link = URL::to('/') . '/signin';
            $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $data['user_id'] ?? 0, "paid_registration");

            $payload = \App\Http\Controllers\WACloudApiController::mp_paidwelcome_alert('91' . $user->mobile, $user->name, $shortLinkData->original['code']);
            $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);

            /* Admin Message History start */
            $addmin_history = new AdminMessage();
            $addmin_history->template_name = 'mp_paidwelcome_alert';
            $addmin_history->message_sent_to = $user->mobile;
            $addmin_history->save();
            /* Admin Message History end */

            /* Email */
            \App\Http\Controllers\CommonMailController::BusinessWelcomeMail($emailData);
        }

        $date = Carbon::parse($emailData['plan_date'])->format('d M, Y g:i A');
        $price = round($emailData['plan_without_gst'], 2);
        $gst = round($emailData['plan_gst'], 2);
        $total = round($emailData['plan_price'], 2);

        $long_link = URL::to('/') . '/business/subscriptions/view-invoice/'.$transactions->id;
        $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $data['user_id'] ?? 0, "paid_registration_subscription");

        $state_name = State::with('state')
            ->where('id', $gst_state)
            ->pluck('name')
            ->first();
        if ($state_name != 'Maharashtra') {
            $gst_name = 'IGST(18%)';
        } else {
            $gst_name = 'CGST + SGST(18%)';
        }
        $gst_data = $gst . '( ' . $gst_name . ' )';

        $payload = \App\Http\Controllers\WACloudApiController::mp_new_registration('91' . $user->mobile, $user->name, $total, $date, $total, $price, $gst_data, $total, $shortLinkData->original['code']);
        $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);

        /* Admin Message History start */
        $addmin_history = new AdminMessage();
        $addmin_history->template_name = 'mp_new_registration';
        $addmin_history->message_sent_to = $user->mobile;
        $addmin_history->save();
        /* Admin Message History end */

        \App\Http\Controllers\CommonMailController::BusinessPlanUpdateMail($emailData);

        /* Sending the data to the SalesRobo form. */

        if ($salesRobo) {
            $sb_form_id = 1;
            $sb_form_data = [
                'mauticform[f_name]' => $user->name,
                'mauticform[email_id]' => $user->email,
                'mauticform[whatsapp_number]' => $user->mobile,
                'mauticform[address]' => $request->gst_address,
                'mauticform[state]' => $request->gst_state,
                'mauticform[city]' => $request->gst_city,
                'mauticform[pincode]' => $request->gst_pincode,
                'mauticform[gst_number]' => $request->gst_number,
                'mauticform[business_name]' => $request->gst_business_name,
                'mauticform[purchased_messages]' => $salesRobo_msgs,
                'mauticform[purchased_product]' => $salesRobo_prod,
                'mauticform[expired_subscription]' => $salesRobo_expi,
                'mauticform[formId]' => $sb_form_id,
                'mauticform[return]' => '',
                'mauticform[formName]' => 'checkoutform',
            ];
            $send_to_SalesRobo = \App\Http\Controllers\SalesroboController::send_form_data($sb_form_id, $sb_form_data);
        }
        /* END SalesRobo code */

        /* Remove Session */
        Session()->forget(['plan_slug', 'total_price', 'payble_price', 'name', 'email', 'mobile']);

        return response()->json(['status' => true, 'message' => 'Payment Successfully !']);
    }

    public function getInvoiceNo()
    {
        $currentYr = Carbon::now()->format('y');
        $month = date('m');

        if ($month < 4) {
            $currentYr = $currentYr - 1;
        }

        $nextYr = $currentYr + 1;
        $slug = 'MP/' . $currentYr . '-' . $nextYr;

        $transaction = Transaction::where('invoice_no', '!=', '')
                                    ->where('invoice_no', 'like', '%'.$slug.'%')
                                    ->orderBy('id', 'desc')
                                    ->select('invoice_no')
                                    ->first();
        
        $sr_no = 1;
        if ($transaction != null) {
            $sr_no = substr($transaction->invoice_no, strrpos($transaction->invoice_no, '/') + 1) + 1;
        }

        if(strlen($sr_no) == 1){
            $sr_no = '0'.$sr_no;
        }
        $invoice_no = $slug . '/' . $sr_no;

        return $invoice_no;
    }
}
