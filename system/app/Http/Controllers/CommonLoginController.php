<?php

namespace App\Http\Controllers;

use URL;
use Hash;
use Session;

use Carbon\Carbon;
use App\Models\User;
use DeductionHelper;
use App\Models\Offer;
use App\Models\Option;
use App\Models\Userplan;
use App\Models\ShortLink;
use App\Models\UserLogin;

// use Auth;
use App\Models\OfferReward;
use Illuminate\Support\Str;
use App\Models\AdminMessage;
use App\Models\MessageRoute;

use App\Models\UserEmployee;
use Illuminate\Http\Request;
use App\Models\BusinessDetail;
use App\Models\OfferSubscription;
use Illuminate\Support\Facades\Auth;
use App\Jobs\DeleteExpiredOfferInstantTaskJob;

class CommonLoginController extends Controller
{
    //

    public function getLogin(Request $request)
    {
        // dd(bcrypt('12345678'));
        $option = Option::where('key', 'company_info')->first();
        $info = json_decode($option->value);
        if (Auth::User()) {
            if (Auth::User()->role_id == 1) {
                return redirect()->route('admin.dashboard');
            } elseif (Auth::User()->role_id == 2) {
                /* if (session()->has('url.intended')) {
                    $redirectTo = session()->get('url.intended');
                    return redirect($redirectTo);
                } */
                return redirect()->route('business.dashboard');
            } elseif (Auth::User()->role_id == 3) {
                return redirect()->route('employee.dashboard');
            } elseif (Auth::User()->role_id == 4) {
                return redirect()->route('seo.dashboard');
            } elseif (Auth::User()->role_id == 5) {
                return redirect()->route('account.dashboard');
            } elseif (Auth::User()->role_id == 6) {
                return redirect()->route('seomanager.dashboard');
            }elseif(Auth::User()->role_id == 7){
                return redirect()->route('support.dashboard');
            }elseif(Auth::User()->role_id == 8){
                return redirect()->route('designer.dashboard');
            }elseif(Auth::User()->role_id == 9){
                return redirect()->route('wacloud.dashboard');
            }
        } else {
            /* $prev_ul = url()->previous();
            if(Str::contains($prev_ul, ['/checkout', '/business/'])){
                session(['url.intended' => url()->previous()]);
            } */

            // return view('auth.login');
            // return view('front.signin', compact('info'));

            $user_mobile = $user_pass = '';
            // if($request->req){
            //     $user_mobile = '7887882244';
            //     $user_pass = 'demo@123';
            // }

            return view('website.auth.signin', compact('info', 'user_mobile', 'user_pass'));
        }
    }

    public function getAdminLogin(Request $request)
    {
        $option = Option::where('key', 'company_info')->first();
        $info = json_decode($option->value);
        if (Auth::User()) {
            if (Auth::User()->role_id == 1) {
                return redirect()->route('admin.dashboard');
            } elseif (Auth::User()->role_id == 2) {
                /* if (session()->has('url.intended')) {
                    $redirectTo = session()->get('url.intended');
                    return redirect($redirectTo);
                } */
                return redirect()->route('business.dashboard');
            } elseif (Auth::User()->role_id == 3) {
                return redirect()->route('employee.dashboard');
            } elseif (Auth::User()->role_id == 4) {
                return redirect()->route('seo.dashboard');
            } elseif (Auth::User()->role_id == 5) {
                return redirect()->route('account.dashboard');
            }elseif(Auth::User()->role_id == 6){
                return redirect()->route('seomanager.dashboard');
            }elseif(Auth::User()->role_id == 7){
                return redirect()->route('support.dashboard');
            }elseif(Auth::User()->role_id == 8){
                return redirect()->route('designer.dashboard');
            }elseif(Auth::User()->role_id == 9){
                return redirect()->route('wacloud.dashboard');
            }
        } else {
            return view('website.auth.admin-login', compact('info'));
        }
    }

    public function username()
    {
        if (is_numeric($request->username)) {
            return ['mobile' => $request->username, 'password' => $request->password];
        } elseif (filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
            return ['email' => $request->username, 'password' => $request->password];
        }
        return ['username' => $request->username, 'password' => $request->password];
    }

    public function putSession($id)
    {
        /* session(['key' => 'value']);

        $existingUser = User::with(['user_plan','user_plan_metas'])->where('id', $id)->first();

        if($existingUser->user_plan_metas != null && $existingUser->user_plan != null){
            Session::put('plan_price',$existingUser->user_plan->amount);
            Session::put('plan_id',$existingUser->user_plan->plan_id);
        }else{
            Session::put('plan_price',0);
            Session::put('plan_id',0);
        } */
    }





    public function postLogin(Request $request)
    {
        // echo json_encode(array("type"=>"error", "message"=>filter_var($request->username, FILTER_VALIDATE_EMAIL)));
        if (is_numeric($request->username)) {
            if (strlen($request->username) < 10) {
                return json_encode(['type' => 'error', 'message' => 'Mobile number length should be 10.']);
            } else {
                $user = User::where('mobile', $request->username)->first();
                $username = 'mobile number';
            }
        } else {
            if (filter_var($request->username, FILTER_VALIDATE_EMAIL)) {
                $user = User::where('email', $request->username)->first();
                $username = 'email address';
            } else {
                return json_encode(['type' => 'error', 'message' => 'Email address is not valid!']);
            }
        }

        $remember_me = $request->has('remember') ? true : false;

        if ($user == null) {
            return json_encode(['type' => 'error', 'message' => 'Oops the ' . $username . ' not exists...!!']);
        } else {
            if (is_numeric($request->username)) {
        // dd($request->username);
                if (Auth::attempt(['mobile' => $request->username, 'password' => $request->password], $remember_me)) 
                {
                    $existingUser = User::where('mobile', $request->username)->first();

                    if ($existingUser->status != 1) {
                        Auth::logout();
                        return json_encode(['type' => 'error', 'message' => 'Your Account is Not Active!']);
                    }


                    /* Check is user already login */
                    if($user != null){
                        if($request->force_login_check == 0 && $user->enable_multi_login == 0){
                            $user_login = UserLogin::where('user_id', $user->id)->where('is_login', '1')->first();
                            if($user_login != null){

                                return json_encode(['type' => 'error', 'message' => 'Someone is already logged in!', 'force_login_check' => 1]);
                                
                            }
                        }
                    }

                    /* user employee start */
                    $todays_date = Carbon::now()->format('Y-m-d');

                    /* $userEmployeeInfo = UserEmployee::where('employee_id', $existingUser->id)->first();
                    if ($userEmployeeInfo !== null) {
                        if ($userEmployeeInfo->will_expire_on < $todays_date) {
                            return json_encode(['type' => 'error', 'message' => 'The user is expired, please contact business!']);
                        }
                    } */

                    // Remove because we create CRON for daily basic deductions
                    // if ($user->role_id == 3) {
                    //     $dedution = $this->deductEmployeeSignUpCost($user);
                    //     if (isset($dedution['type']) && $dedution['type'] == 'error') {
                    //         return $dedution;
                    //     }
                    // }

                    /* user employee end */

                    /* Add here condition to restrict employee from logging in if expired */
                    if (Auth::loginUsingId($existingUser->id)) {
                        $user = Auth::User();
                        $this->getAndUpdateLoginStatus($user->id, $request->password);
                        if ($user->role_id == 2) {
                            $this->putSession($existingUser->id);
                        }
                    }

                    auth()->login($user, true);

                    #Auth::logoutOtherDevices($request->password);

                    $payment_link = '';
                    if (Session::get('payment_url_from_partner')) {
                        $payment_link = Session::get('payment_url_from_partner');
                    }
                    Session::forget('payment_url_from_partner');

                    return json_encode(['type' => 'success', 'message' => 'User logged in successfully.', 'payment' => 'done', 'link' => $payment_link]);
                } else {
                    return json_encode(['type' => 'error', 'message' => 'User credentials not match!']);
                }
            } else {
                if (Auth::attempt(['email' => $request->username, 'password' => $request->password], $remember_me))
                {
                    $existingUser = User::where('email', $request->username)->first();

                    if ($existingUser->status != 1) {
                        Auth::logout();
                        return json_encode(['type' => 'error', 'message' => 'Your Account is Not Active!']);
                    }


                    /* Check is user already login */
                    if($user != null){
                        if($request->force_login_check == 0 && $user->enable_multi_login == 0){
                            $user_login = UserLogin::where('user_id', $user->id)->where('is_login', '1')->first();
                            if($user_login != null){

                                return json_encode(['type' => 'error', 'message' => 'Someone is already logged in!', 'force_login_check' => 1]);
                                
                            }
                        }
                    }


                    /* user employee start */
                    $todays_date = \Carbon\Carbon::now()->format('Y-m-d');
                    
                    /* $userEmployeeInfo = UserEmployee::where('employee_id', $existingUser->id)->first();
                    if ($userEmployeeInfo !== null) {
                        if ($userEmployeeInfo->will_expire_on < $todays_date) {
                            return json_encode(['type' => 'error', 'message' => 'The user is expired, please contact business!']);
                        }
                    } */

                    // Remove because we create CRON for daily basic deductions
                    // if ($user->role_id == 3) {
                    //     $dedution = $this->deductEmployeeSignUpCost($user);
                    //     if (isset($dedution['type']) && $dedution['type'] == 'error') {
                    //         return $dedution;
                    //     }
                    // }

                    /* user employee end */

                    if (Auth::loginUsingId($existingUser->id)) {
                        $user = Auth::User();
                        /*if($user->role_id == 2){
                            $this->putSession($existingUser->id);
                        }*/
                        $this->getAndUpdateLoginStatus($user->id, $request->password);
                    }
                    auth()->login($user, true);

                    #Auth::logoutOtherDevices($request->password);

                    $payment_link = '';
                    if (Session::get('payment_url_from_partner')) {
                        $payment_link = Session::get('payment_url_from_partner');
                    }
                    Session::forget('payment_url_from_partner');

                    return json_encode(['type' => 'success', 'message' => 'User logged in successfully.', 'payment' => 'done', 'link' => $payment_link]);
                } else {
                    return json_encode(['type' => 'error', 'message' => 'User credentials not match!']);
                }
            }
        }
    }

    public function getAndUpdateLoginStatus($userId, $password)
    {
        // dd("getAndUpdateLoginStatus");
        $getLoginStatus = UserLogin::where('user_id', $userId)
            ->where('is_login', '1')
            ->orderBy('id', 'desc')
            ->first();

        $user = User::find($userId);
// dd($getLoginStatus); null
// dd($user->enable_multi_login); 0
        if ($getLoginStatus != null && $user->enable_multi_login != 1) {
            // dd("in if");
            Auth::logoutOtherDevices($password);

            $getLoginStatus['is_login'] = '0';
            $getLoginStatus->save();

            $loginInfo = UserLogin::where('user_id', $user->id)->first();
            if ($loginInfo == null) {
                $loginInfo = new UserLogin();
            }
            $loginInfo->user_id = $userId;
            $loginInfo->is_login = '1';
            // dd($loginInfo);
            $loginInfo->save();
        } else {
            // dd("in else");
            $loginInfo = UserLogin::where('user_id', $user->id)->first();
            if ($loginInfo == null) {
                $loginInfo = new UserLogin();
            }
            $loginInfo->user_id = $userId;
            $loginInfo->is_login = '1';
            // dd($loginInfo);
            $loginInfo->save();
        }
    }

    public function generatePassword(Request $request)
    {
        $token = $request->token;
        $user = User::where('pass_token', $token)
            ->where('pass_token', '<>', null)
            ->first();
        // dd($user);
        $domain = URL::to('/');
        if ($user == null) {
            return redirect('/login');
        }
        $data = [];
        if (Session::has('payment_info')) {
            $data = Session::get('payment_info');
        }
        // dd($data);
        return view('auth.password', compact('token', 'user', 'data'));
    }

    public function updateUserPassword(Request $request)
    {
        $userData = User::where('pass_token', $request->user_token)->first();
        if ($userData != null) {
            $userData->pass_token = '';
            $userData->password = Hash::make($request->password);
            $userData->status = 1;
            $userData->save();

            Auth()->login($userData, true);
            if ($userData->role_id == 1) {
                return redirect()->route('admin.dashboard');
            } elseif ($userData->role_id == 2) {
                if (Session::has('payment_info')) {
                    return redirect('/checkout-paid-register/thankyou');
                } else {
                    return redirect()->route('business.dashboard');
                }
            }
        } else {
            if (Auth::user()) {
                return redirect()->route('business.dashboard');
            } else {
                return redirect()->url('/');
            }
        }
    }

    public function generateAdminPassword(Request $request)
    {
        // dd($request->token);
        $token = $request->token;
        $user = User::where('pass_token', $request->token)
            ->where('pass_token', '<>', null)
            ->first();
        $domain = URL::to('/');
        if ($user == null) {
            return redirect('/');
        }
        return view('auth.admin-password', compact('token', 'user'));
    }

    public function updateAdminPassword(Request $request)
    {
        $userData = User::where('pass_token', $request->user_token)->first();
        $userData->pass_token = '';
        $userData->password = Hash::make($request->password);
        $userData->status = 1;
        $userData->save();

        Auth()->login($userData, true);
        return redirect()->route('admin.dashboard');
    }

    public function forgotPasswordEmail(Request $request)
    {
        
        if (is_numeric($request->username)) {
            if (strlen($request->username) < 10) {
                return json_encode(['type' => 'error', 'message' => 'Mobile number length should be 10.']);
            } else {
                $user = User::where('mobile', $request->username)->first();
                // dd($user);
                $username = 'mobile number';
            }
        } else {
            if (filter_var($request->username, FILTER_VALIDATE_EMAIL)) {
                $user = User::where('email', $request->username)->first();
                $username = 'email address';
            } else {
                return json_encode(['type' => 'error', 'message' => 'Email address is not valid!']);
            }
        }

        // dd($user);

        if ($user == null) {
            return json_encode(['type' => 'error', 'message' => 'Oops the ' . $username . ' not exists...!!']);
        } else {
            $date = \Carbon\Carbon::now()->format('Ymd');
            $m = 180;
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randomCode = '';
            for ($i = 0; $i < $m; $i++) {
                $index = rand(0, strlen($characters) - 1);
                $randomCode .= $characters[$index];
            }

            if ($user->role_id == 3) {
                return json_encode(['type' => 'success', 'message' => 'Please contact to your Business.']);
            } elseif ($user->role_id == 2 || $user->role_id == 1) {
                // Create User Token
                $user->pass_token = $randomCode . $date;
                $user->save();

                $data = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'token' => $user->pass_token,
                ];

                $long_url = url('forgot-password?token=' . $user->pass_token);
                $token = \App\Http\Controllers\ShortLinkController::callShortLinkApi($long_url, $user->id ?? 0, "forget_password");

                if ($token->original['success'] == true) {

                    $success_message = 'Link has been sent successfully.';
                    if (is_numeric($request->username)) {

                        $payload = \App\Http\Controllers\WACloudApiController::mp_forgot_password('91' . $user->mobile, $user->name, $token->original['code']);
                        $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);
    
                        /* Admin Message History start */
                        $addmin_history = new AdminMessage();
                        $addmin_history->template_name = 'mp_forgot_password';
                        $addmin_history->message_sent_to = $user->mobile;
                        $addmin_history->save();
                        /* Admin Message History end */

                        $success_message = 'Message has been sent successfully.';
                    } else {
                        \App\Http\Controllers\CommonMailController::ForgotPasswordMail($data);

                        $success_message = 'Email has been sent successfully.';
                    }

                    return json_encode(['type' => 'success', 'message' => $success_message]);
                } else {
                    return json_encode(['type' => 'error', 'message' => 'Please try again.']);
                }
            }
        }
    }

    public function forgotPassword(Request $request)
    {
        $token = $request->token;
        $user = User::where('pass_token', $token)
            ->where('pass_token', '<>', null)
            ->first();

        if($user == null){
            abort(419);
        }
        
        $domain = URL::to('/');
        if ($user == null) {
            return redirect('/');
        }
        return view('auth.forgot-password', compact('token', 'user'));
        // return view('auth.forgot-password');
    }

    public function updateForgotPassword(Request $request)
    {
        $userData = User::where('pass_token', $request->user_token)->first();
        $userData->pass_token = '';
        $userData->password = Hash::make($request->password);
        $userData->status = 1;
        $userData->save();

        Auth()->login($userData, true);
        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        $getLoginStatus = UserLogin::where('user_id', $user->id)
            ->where('is_login', '1')
            ->orderBy('id', 'desc')
            ->first();
        if ($getLoginStatus != null) {
            $getLoginStatus['is_login'] = '0';
            $getLoginStatus->save();
        }
        Auth::logout();
        return redirect('/login');
    }

    public function freeRegistration(Request $request)
    {
        $user = User::find($request->userId);

        Auth()->login($user, true);

        return redirect('business/dashboard');
    }

    public function deductEmployeeSignUpCost($user = [])
    {
        if (!empty($user)) {
            // Check User is Employee and deduct employee_login_cost from wallet
            if ($user->role_id == 3) {
                // Update Employee expire_login = 0
                $userToLogout = User::find($user->id);
                $userToLogout->expire_login = '0';
                $userToLogout->save();

                $loginInfo = UserLogin::where('user_id', $user->id)->first();

                if ($loginInfo != null && $loginInfo->wallet_deduct_date != null) {
                    $loginDate = Carbon::parse($loginInfo->wallet_deduct_date)->format('d-m-Y');
                } else {
                    $loginInfo = new UserLogin();
                    $loginDate = Carbon::now()
                        ->subDays(1)
                        ->format('d-m-Y');
                }
                $todayDate = Carbon::now()->format('d-m-Y');

                $todayTimeStamp = strtotime($todayDate);
                $loginTimeStamp = strtotime($loginDate);

                if ($loginTimeStamp < $todayTimeStamp) {
                    $deductionDetail = DeductionHelper::getActiveDeductionDetail('slug', 'employee_login_cost');
                    $checkWalletBalance = DeductionHelper::checkWalletBalance($user->created_by ?? 0, $deductionDetail->id ?? 0);

                    if ($checkWalletBalance['status'] != true) {
                        return [
                            'type' => 'error',
                            'message' => 'Can\'t login, please contact to business owner',
                        ];
                    }

                    // Insert in Deduction History Table
                    $customer_id = 0;
                    $employee_id = $user->id;
                    DeductionHelper::deductWalletBalance($user->created_by ?? 0, $deductionDetail->id ?? 0, 0, 0, $customer_id, $employee_id);

                    $loginInfo->user_id = $user->id;
                    $loginInfo->wallet_deduct_date = Carbon::now();
                    $loginInfo->save();

                    return [
                        'type' => 'success',
                    ];
                }
            }
        }
    }

    //convert free to paid
    public function convertFreeToPaid($user_id)
    {
        $yesterday = Carbon::now()
            ->subDays(1)
            ->format('Y-m-d');
        $today = Carbon::now()->format('Y-m-d');

        $activeOffersIds = Offer::where('user_id', $user_id)
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->pluck('id')
            ->toArray();

        if (!empty($activeOffersIds)) {
            $subscriptionsIds = OfferSubscription::whereIn('offer_id', $activeOffersIds)
                ->where('status', '1')
                ->pluck('id')
                ->toArray();

            if (!empty($subscriptionsIds)) {
                OfferSubscription::whereIn('id', $subscriptionsIds)->update(['status' => '3']);
            }

            foreach ($activeOffersIds as $offersId) {
                $offer = Offer::find($offersId);
                
                if (\Carbon\Carbon::parse($offer->start_date)->format("Y-m-d") == $today) {
                    $offer->start_date = $yesterday;
                }
                $offer->end_date = $yesterday;
                $offer->save();
            }
        }

        $shareReward = OfferReward::where('user_id', $user_id)
            ->where('channel_id', 3)
            ->first();
        if ($shareReward != null) {
            OfferReward::destroy($shareReward->id);
          
            $data = [
                ['user_id' => $shareReward->user_id, 'type' => 'No Reward', 'channel_id' => 3, 'details' => '{"minimum_click":"10"}'],
            ];
            OfferReward::insert($data);

        }

        $instantReward = OfferReward::where('user_id', $user_id)
            ->where('channel_id', 2)
            ->first();
        if ($instantReward != null) {
            OfferReward::destroy($instantReward->id);
            // dd($instantReward);
            $data = [
                ['user_id' => $instantReward->user_id, 'type' => 'No Reward', 'channel_id' => 2, 'details' => '{"minimum_task":"1"}'],
            ];
            OfferReward::insert($data);
        }

        $isPaid = User::where('id', $user_id)
            ->where('is_paid', 1)
            ->first();
        
        if ($isPaid != null) {
            $smsRouteData = MessageRoute::where('user_id', $user_id)
                ->pluck('id')
                ->toArray();
            if ($smsRouteData != null) {
                foreach ($smsRouteData as $smsId) {
                    $smsRoute = MessageRoute::find($smsId);
                    $smsRoute->sms = $smsRoute->old_sms;
                    $smsRoute->save();
                }
            }
        }

        //mark expired
        dispatch(new DeleteExpiredOfferInstantTaskJob());
    }
}
