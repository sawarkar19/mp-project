<?php

namespace App\Http\Controllers\Support;
use App\Models\User;
use App\Models\Transaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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

        return view('support.userList', compact('activeUser', 'inactiveUser', 'paidUser', 'unPaidUser', 'allUsers', 'conditions', 'request'));

    }

    public function user_transaction(Request $request, $id){
        $id = decrypt($id);
        // $allUsers = User::with('getRedeemedCustomers','getShareSubscriptions','getInstantSubscriptions','getUniqueClicks','getExtraClicks','getOffersList','getRedeemedCodeSent','getCompletedTasks','employees')->whereId($id)->first();

        // return view('support.usershow', compact('allUsers','offers','instantTasks','socilPosts','deductionHistory','request','employees'));
    }
    public function user_report(Request $request, $id){
        $id = decrypt($id);
        
    }
   
}
