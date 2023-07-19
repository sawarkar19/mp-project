<?php

namespace App\Http\Controllers\Seo;
use App\Models\User;
use App\Models\Offer;
use App\Models\OfferReward;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\MessageWallet;
use App\Http\Controllers\Controller;
use App\Models\UserSocialConnection;

class UserController extends Controller
{
    public function user(Request $request)
    {
        /*  active user count and inactive user count start*/
        $activeUser = User::where('status', 1)->count();
        $inactiveUser = User::where('status', 0)->count();
        /*  active user count and inactive user count end*/

        // $today = Carbon::now();
        $paidUser = Transaction::where('transaction_amount', '>', 0)
            ->groupBy('user_id')
            // ->whereDate('created_by', '>=', $today)
            ->get();

            foreach ($paidUser as $key => $User) {
                   $data[] = $User->id;
            }
            $unPaidUser = Transaction::whereNotIn('user_id', $data)->where('transaction_amount', 0)->groupBy('user_id')->get();

            /* all user show data, search and pagination start */
            $conditions = [];
            $numberOfPage = $request->no_of_users ?? 10;
            if (!empty($request->src) && !empty($request->term)) {
                $allUsers = User::where('role_id', 2)->where($request->term, 'like', '%'. $request->src . '%' )->paginate($numberOfPage);
            $conditions[] = [$request->term, 'like', '%' . $request->src . '%'];
            } else{
                $allUsers = User::where('role_id', 2)->orderBy('id', 'DESC')->paginate($request->no_of_users);
            }
            /* all user show data, search and pagination end */

        return view('seo.userList', compact('activeUser', 'inactiveUser', 'paidUser', 'unPaidUser', 'allUsers', 'conditions', 'request'));

    }

    public function user_transaction(Request $request, $id){
        $id = decrypt($id);
        // $allUsers = User::with('getRedeemedCustomers','getShareSubscriptions','getInstantSubscriptions','getUniqueClicks','getExtraClicks','getOffersList','getRedeemedCodeSent','getCompletedTasks','employees')->whereId($id)->first();

        // return view('seo.usershow', compact('allUsers','offers','instantTasks','socilPosts','deductionHistory','request','employees'));
    }
    public function user_report(Request $request, $id){
        $id = decrypt($id);
        
    }

    public function userActivity($id){
        $id = decrypt($id);

        /* Current Offer */
        $currentOffer = Offer::where('user_id', $id)
                             ->where('start_date', '<=', date("Y-m-d"))
                             ->where('end_date', '>=', date("Y-m-d"))
                             ->first();

        /* Upcoming Offers */
        $comingOffers = Offer::where('user_id', $id)
                             ->where('start_date', '>', date("Y-m-d"))
                             ->get();

        /* Reward Settings */
        $instantChallengeSetting = OfferReward::where('channel_id', 2)
                                     ->where('user_id', $id)
                                     ->first();

        $shareChallengeSetting = OfferReward::where('channel_id', 3)
                                     ->where('user_id', $id)
                                     ->first();

        /* Social Connections */
        $socialConnections = UserSocialConnection::where('user_id', $id)
                                                 ->select('is_facebook_auth','is_twitter_auth','is_linkedin_auth','is_youtube_auth','is_instagram_auth','is_google_auth')
                                                 ->first();

        /* Account Balance */
        $balance = MessageWallet::where('user_id', $id)
                                ->select('wallet_balance')
                                ->first();

        /* User Details */
        $user = User::where('id', $id)
                    ->select('name','email','mobile','is_paid')
                    ->first();

        return view('seo.activity', compact(['user','balance','socialConnections','shareChallengeSetting','instantChallengeSetting','comingOffers','currentOffer']));            
        
    }
   
}
