<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Userplan;
use App\Models\Target;
use App\Models\Offer;
use App\Models\OfferSubscription;
use App\Models\User;
use Carbon\Carbon;
use Auth;
use DB;

class GraphController extends Controller
{
    //
    public function __construct()
    {
       $this->middleware('business');
    }

    public function user(){

        $user = Auth::user();
        return $user;

    }


  

    /* Stastics Graph on click of 1M button(last 30 daya) start*/
    public function thisMonth()
    {
        $user = Auth::user(); 
        $labels = $this->getThisMonthLb();
        $data = $this->getThisMonthRecords();
        if($user->current_account_status == 'free'){
            $data[0] = 0;
        }
        return response()->json(
            [
                'labels'=>$labels,
                'data'=>$data
            ]
        );
    }


    public function getThisMonthLb()
    {
        $currentMonth = Carbon::now();
        $count = $currentMonth->day;
        $month = Carbon::parse($currentMonth)->format("M");
       
        for($i = 30; $i >= 0; $i--)
        { 
            $date =  Carbon::now()->subDays($i)->format("d M");

            $labels[] = $date;
        }

        return $labels;
    }


    public function getThisMonthRecords()
    {
        $user = $this->user();
        $now = Carbon::today();

        $currentMonth = Carbon::now();
        $count = $currentMonth->day;
        $month = Carbon::parse($currentMonth)->format("M");
        for($i = 30; $i >= 0; $i--)
        { 
            $date =  Carbon::now()->subDays($i)->format("d M");

            $labels[] = $date;
        }
        
        $datas = array();

        /* Unique clicks */
        $uniqueClicks = array();
        $updatedClicks = 0; 
        foreach ($labels as $day) {
            $dailyClicks = Target::leftjoin('offer_subscriptions', 'targets.offer_subscription_id', '=', 'offer_subscriptions.id')
            ->leftjoin('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
            ->leftjoin('users', 'offers.user_id', '=', 'users.id')
            ->where('offers.user_id', $user->id)
            ->where('targets.repeated', 0)
            ->where('targets.created_at', 'LIKE', Carbon::parse($day)->format("Y-m-d").'%')
            ->count(); 

            if(!empty($uniqueClicks)){
                $lastCountInstant = end($uniqueClicks);
            }else{
                $lastCountInstant = 0;
            }
            $uniqueClicks[] = $lastCountInstant + $dailyClicks;
        }
        $datas[] = $uniqueClicks;

        /* Extra Clicks */
        $extraClicks = array();
        $updatedClicks = 0; 
        foreach ($labels as $day) {
            $DailyExtraClicks = Target::leftjoin('offer_subscriptions', 'targets.offer_subscription_id', '=', 'offer_subscriptions.id')
            ->leftjoin('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
            ->leftjoin('users', 'offers.user_id', '=', 'users.id')
            ->where('offers.user_id', $user->id)
            // ->where('targets.repeated', 1)
            ->where('targets.created_at', 'LIKE', Carbon::parse($day)->format("Y-m-d").'%')
            ->count();

            if(!empty($extraClicks)){
                $lastCountInstant = end($extraClicks);
            }else{
                $lastCountInstant = 0;
            }
            $extraClicks[] = $lastCountInstant + $DailyExtraClicks;
        }
        $datas[] = $extraClicks;
        return $datas;
    }
/* Stastics Graph on click of 1M button(last 30 daya) end*/

    
    public function getLast7days()
    {

        $labels = $this->getSevenDaysLb();
        $data = $this->get7DayRecords();
        $label= 'Visits';
        $borderWidth= 5;
        $borderColor= '#6777ef';
        $backgroundColor= 'transparent';
        $pointBackgroundColor= '#fff';
        $pointBorderColor= '#6777ef';
        $pointRadius= 4;

        $datasets = [
            'label'=> $label,
            'data'=> $data,
            'borderWidth'=> $borderWidth,
            'borderColor'=> $borderColor,
            'backgroundColor'=> $backgroundColor,
            'pointBackgroundColor'=> $pointBackgroundColor,
            'pointBorderColor'=> $pointBorderColor,
            'pointRadius'=> $pointRadius,
        ];
        
        return response()->json(
            [
                'labels'=>$labels,
                'datasets'=>$datasets,
                'max'=> max($data),
                'min'=> min($data)
            ]
        );
    }


    public function getCurrentLast7days()
    {
        $labels = $this->getSevenDaysLb();
        $data = $this->get7DayRecords();
        $label= 'Visits';
        $borderWidth= 5;
        $borderColor= '#6777ef';
        $backgroundColor= 'transparent';
        $pointBackgroundColor= '#fff';
        $pointBorderColor= '#6777ef';
        $pointRadius= 4;

        $datasets = [
            'label'=> $label,
            'data'=> $data,
            'borderWidth'=> $borderWidth,
            'borderColor'=> $borderColor,
            'backgroundColor'=> $backgroundColor,
            'pointBackgroundColor'=> $pointBackgroundColor,
            'pointBorderColor'=> $pointBorderColor,
            'pointRadius'=> $pointRadius,
        ];
        
        return response()->json(
            [
                'labels'=>$labels,
                'datasets'=>$datasets,
                'max'=> max($data),
                'min'=> min($data)
            ]
        );
    }
/* Stastics Graph on click of 7D button start*/
    public function last7days()
    {
        $labels = $this->getSevenDaysLb();
        $data = $this->get7DayRecords();
        
        return response()->json(
            [
                'labels'=>$labels,
                'data'=>$data
            ]
        );
    }


    public function getSevenDaysLb()
    {
        $w7 = Carbon::now()->subDays(6)->format('d M');
        $w6 = Carbon::now()->subDays(5)->format('d M');
        $w5 = Carbon::now()->subDays(4)->format('d M');
        $w4 = Carbon::now()->subDays(3)->format('d M');
        $w3 = Carbon::now()->subDays(2)->format('d M');
        $w2 = Carbon::now()->subDays(1)->format('d M');
        $w1 = Carbon::now()->format('d M');

        $labels = [$w7,$w6,$w5,$w4,$w3,$w2,$w1];

        return $labels;
    }


    public function get7DayRecords()
    {
        $user = $this->user();
        $now = Carbon::today();

        $w7 = Carbon::now()->subDays(6);
        $w6 = Carbon::now()->subDays(5);
        $w5 = Carbon::now()->subDays(4);
        $w4 = Carbon::now()->subDays(3);
        $w3 = Carbon::now()->subDays(2);
        $w2 = Carbon::now()->subDays(1);
        $w1 = Carbon::now();

        $labels = [$w7,$w6,$w5,$w4,$w3,$w2,$w1];
        $datas = array();

        /* Unique clicks */
        $uniqueClicks = array();
        $updatedClicks = 0; 
        foreach ($labels as $day) {
            $dailyClicks = Target::leftjoin('offer_subscriptions', 'targets.offer_subscription_id', '=', 'offer_subscriptions.id')
            ->leftjoin('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
            ->leftjoin('users', 'offers.user_id', '=', 'users.id')
            ->where('offers.user_id', $user->id)
            ->where('targets.repeated', 0)
            ->where('targets.created_at', 'LIKE', Carbon::parse($day)->format("Y-m-d").'%')
            ->count();

            if(!empty($uniqueClicks)){
                $lastCountInstant = end($uniqueClicks);
            }else{
                $lastCountInstant = 0;
            }
            $uniqueClicks[] = $lastCountInstant + $dailyClicks;
        }

        $datas[] = $uniqueClicks;
        
        /* Extra Clicks */
        $extraClicks = array();
        $updatedClicks = 0; 
        foreach ($labels as $day) {
            $DailyExtraClicks = Target::leftjoin('offer_subscriptions', 'targets.offer_subscription_id', '=', 'offer_subscriptions.id')
            ->leftjoin('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
            ->leftjoin('users', 'offers.user_id', '=', 'users.id')
            ->where('offers.user_id', $user->id)
            // ->where('targets.repeated', 1)
            ->where('targets.created_at', 'LIKE', Carbon::parse($day)->format("Y-m-d").'%')
            ->count();

            if(!empty($extraClicks)){
                $lastCountInstant = end($extraClicks);
            }else{
                $lastCountInstant = 0;
            }
            $extraClicks[] = $lastCountInstant + $DailyExtraClicks;
        }
        $datas[] = $extraClicks;

        return $datas;
    }
 /* Stastics Graph on click of 7D button end*/
 


    public function last365Days()
    { 
        $user = Auth::user();
        $labels = $this->getLast365DaysStaticGraph();
        $data = $this->getLast365DaysRecordStaticGraph();
        if($user->current_account_status == 'free'){
                 $data[0] = 0;
             }

        return response()->json(
            [
                'labels'=>$labels,
                'data'=>$data
            ]
        );
    }
    public function getLast365DaysStaticGraph()
    {
        $previousMonth = Carbon::now()->subMonths(1);
        $count = $previousMonth->daysInMonth;
        $month = Carbon::parse($previousMonth)->format("M");
        for($i = 365; $i >= 0; $i--)
        { 
            $date =  Carbon::now()->subDays($i)->format("d M Y");

            $labels[] = $date;
        }

        return $labels;
    }
    public function getLast365DaysRecordStaticGraph()
    {
        $user = $this->user();
        $now = Carbon::today();

        $previousMonth = Carbon::now()->subMonths(1);
        $count = $previousMonth->daysInMonth;
        $month = Carbon::parse($previousMonth)->format("M");
        for($i = 365; $i >= 0; $i--)
        { 
            $date =  Carbon::now()->subDays($i)->format("d M Y");

            $labels[] = $date;
        }
        $datas = array();

        /* Unique clicks */
        $uniqueClicks = array(); 
        $updatedClicks = 0;
        foreach ($labels as $day) {
            $dailyClicks = Target::leftjoin('offer_subscriptions', 'targets.offer_subscription_id', '=', 'offer_subscriptions.id')
            ->leftjoin('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
            ->leftjoin('users', 'offers.user_id', '=', 'users.id')
            ->where('offers.user_id', $user->id)
            ->where('targets.repeated', 0)
            ->where('targets.created_at', 'LIKE', Carbon::parse($day)->format("Y-m-d").'%')
            ->count(); 

            if(!empty($uniqueClicks)){
                $lastCountInstant = end($uniqueClicks);
            }else{
                $lastCountInstant = 0;
            }
            $uniqueClicks[] = $lastCountInstant + $dailyClicks;
        }
        $datas[] = $uniqueClicks;

        /* Extra Clicks */
        $extraClicks = array(); 
        $updatedClicks = 0;
        foreach ($labels as $day) {
            $DailyExtraClicks = Target::leftjoin('offer_subscriptions', 'targets.offer_subscription_id', '=', 'offer_subscriptions.id')
            ->leftjoin('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
            ->leftjoin('users', 'offers.user_id', '=', 'users.id')
            ->where('offers.user_id', $user->id)
            // ->where('targets.repeated', 1)
            ->where('targets.created_at', 'LIKE', Carbon::parse($day)->format("Y-m-d").'%')
            ->count();
            
            if(!empty($extraClicks)){
                $lastCountInstant = end($extraClicks);
            }else{
                $lastCountInstant = 0;
            }
            $extraClicks[] = $lastCountInstant + $DailyExtraClicks;
        }
        $datas[] = $extraClicks;
        return $datas;
    }



/* Stastics Graph on click of 1Y button start*/
    public function offerStartFromStaticGraph()
    {
        $user = Auth::user();
        $labels = $this->offerStartFromStaticGraphLB();
        $data = $this->offerStartFromStaticGraphRecord();
        if($user->current_account_status == 'free'){
                 $data[0] = 0;
             }
        return response()->json(['labels'=>$labels, 'data'=>$data, 'max'=> max($data), 'min'=> min($data)]);
    }


    public function offerStartFromStaticGraphLB()
    {
        $user = $this->user();
        $date =  Carbon::create($user->created_at)->Format("d M Y");
        $date_now =  Carbon::now()->Format("d M Y");
        $diff = now()->diffInDays(Carbon::parse($date));
        $labels = [];
        for($i = $diff; $i >= 0; $i--)
        { 
            $date =  Carbon::now()->subDays($i)->format("d M Y");
            $labels[] = $date;
        }

        return $labels;
    }


    public function offerStartFromStaticGraphRecord()
    {
        $user = $this->user();
        $date =  Carbon::create($user->created_at)->Format("d M Y");
        $date_now =  Carbon::now()->Format("d M Y");
        $diff = now()->diffInDays(Carbon::parse($date));
        $labels = [];
        for($i = $diff; $i >= 0; $i--)
        { 
            $date =  Carbon::now()->subDays($i)->format("d M Y");
            $labels[] = $date;
        }
        $datas = array();

        /* Unique clicks */
        $uniqueClicks = array(); 
        foreach ($labels as $day) {
            $start_date = Carbon::parse($day)->format("Y-m-d");
            $end_date = Carbon::parse($day)->format("Y-m-d");
            
            $dailyClicks = Target::leftjoin('offer_subscriptions', 'targets.offer_subscription_id', '=', 'offer_subscriptions.id')
            ->leftjoin('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
            ->leftjoin('users', 'offers.user_id', '=', 'users.id')
            ->where('offers.user_id', $user->id)
            ->where('targets.repeated', 0)
            // ->where('targets.created_at', 'LIKE', Carbon::parse($day)->format("Y-m-d").'%')
            ->whereBetween('targets.created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
            ->count(); 
         
            if(!empty($uniqueClicks)){
                $lastCountInstant = end($uniqueClicks);
            }else{
                $lastCountInstant = 0;
            }
            $uniqueClicks[] = $lastCountInstant + $dailyClicks;
        }
        $datas[] = $uniqueClicks;

        /* Total Clicks */
        $totalClicks = array(); 
        foreach ($labels as $day) {
            $start_date = Carbon::parse($day)->format("Y-m-d");
            $end_date = Carbon::parse($day)->format("Y-m-d");

            $DailyTotalClicks = Target::leftjoin('offer_subscriptions', 'targets.offer_subscription_id', '=', 'offer_subscriptions.id')
            ->leftjoin('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
            ->leftjoin('users', 'offers.user_id', '=', 'users.id')
            ->where('offers.user_id', $user->id)
            // ->where('targets.repeated', 1)
            // ->where('targets.created_at', 'LIKE', Carbon::parse($day)->format("Y-m-d").'%')
            ->whereBetween('targets.created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
            ->count();

            if(!empty($totalClicks)){
                $lastCountInstant = end($totalClicks);
            }else{
                $lastCountInstant = 0;
            }
            $totalClicks[] = $lastCountInstant + $DailyTotalClicks;
        }
        $datas[] = $totalClicks;
        return $datas;
    }
    /* Stastics Graph on click of 1Y button end*/

    public function getGraphData()
    {    
        $w6 = Carbon::now()->subDays(6)->format('d M');
        $w5 = Carbon::now()->subDays(5)->format('d M');
        $w4 = Carbon::now()->subDays(4)->format('d M');
        $w3 = Carbon::now()->subDays(3)->format('d M');
        $w2 = Carbon::now()->subDays(2)->format('d M');
        $w1 = Carbon::now()->subDays(1)->format('d M');
        $w0 = Carbon::now()->subDays(0)->format('d M');

        $labels = [$w6,$w5,$w4,$w3,$w2,$w1,$w0];

        $unique = $extra = array();
        for ($i=0; $i < 7; $i++) { 
            $key = 6 - $i;
            $u = Target::where('user_id',Auth::id())->whereRaw('date(created_at) = ?', [Carbon::now()->subDays($key)->format('Y-m-d')])->where('repeated',0)->count();
            $e = Target::where('user_id',Auth::id())->whereRaw('date(created_at) = ?', [Carbon::now()->subDays($key)->format('Y-m-d')])->where('repeated',1)->count();

            $unique[] = $u;
            $extra[] = $e;
        }

        return response()->json(['labels'=>$labels, 'unique'=>$unique, 'extra'=>$extra]);
    }


    /* Current Offer Chart Changes */

    public function currentGraphlast7days()
    {
    
        $labels = $this->getCurrentSevenDaysLb();
        $data = $this->getCurrent7DayRecords();
        
        return response()->json(
            [
                'labels'=>$labels,
                'data'=>$data
            ]
        );
    }


    public function getCurrentSevenDaysLb()
    {
        $w7 = Carbon::now()->subDays(6)->format('d M');
        $w6 = Carbon::now()->subDays(5)->format('d M');
        $w5 = Carbon::now()->subDays(4)->format('d M');
        $w4 = Carbon::now()->subDays(3)->format('d M');
        $w3 = Carbon::now()->subDays(2)->format('d M');
        $w2 = Carbon::now()->subDays(1)->format('d M');
        $w1 = Carbon::now()->format('d M');

        $labels = [$w7,$w6,$w5,$w4,$w3,$w2,$w1];

        return $labels;
    }


    public function getCurrent7DayRecords()
    {
        $user = $this->user();
        $now = Carbon::today();

        $w7 = Carbon::now()->subDays(6);
        $w6 = Carbon::now()->subDays(5);
        $w5 = Carbon::now()->subDays(4);
        $w4 = Carbon::now()->subDays(3);
        $w3 = Carbon::now()->subDays(2);
        $w2 = Carbon::now()->subDays(1);
        $w1 = Carbon::now();

        $labels = [$w7,$w6,$w5,$w4,$w3,$w2,$w1];
        $datas = array();

        /* Instant Challanges */
        $instantC = array();
        $updatedInChallanges = 0; 
        foreach ($labels as $day) {
            $dailyClicks = Target::leftjoin('offer_subscriptions', 'targets.offer_subscription_id', '=', 'offer_subscriptions.id')
            ->leftjoin('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
            ->leftjoin('users', 'offers.user_id', '=', 'users.id')
            ->where('offers.user_id', $user->id)
            ->where('targets.repeated', 0)
            ->where('targets.created_at', 'LIKE', Carbon::parse($day)->format("Y-m-d").'%')
            ->count();

            $instantC[] = $dailyClicks;
        }
        $datas[] = $instantC;
        
        /* Share Challanges */
        $shareC = array();
        $updatedShChallanges = 0; 
        foreach ($labels as $day) {
            $shareChallanges = Target::leftjoin('offer_subscriptions', 'targets.offer_subscription_id', '=', 'offer_subscriptions.id')
            ->leftjoin('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
            ->leftjoin('users', 'offers.user_id', '=', 'users.id')
            ->where('offers.user_id', $user->id)
            // ->where('targets.repeated', 1)
            ->where('targets.created_at', 'LIKE', Carbon::parse($day)->format("Y-m-d").'%')
            ->count();

            $shareC[] = $shareChallanges;
        }
        $datas[] = $shareC;

        return $datas;
    }
/* Instant & share Challengers on 7D button click */

    public function last7DaysChallengers()
    {
    
        $labels = $this->getSevenDaysChallengersLb();
        $data = $this->get7DayChallengersRecords();
        return response()->json(
            [
                'labels'=>$labels,
                'data'=>$data
            ]
        );
    }


    public function getSevenDaysChallengersLb()
    {
        $w7 = Carbon::now()->subDays(6)->format('d M');
        $w6 = Carbon::now()->subDays(5)->format('d M');
        $w5 = Carbon::now()->subDays(4)->format('d M');
        $w4 = Carbon::now()->subDays(3)->format('d M');
        $w3 = Carbon::now()->subDays(2)->format('d M');
        $w2 = Carbon::now()->subDays(1)->format('d M');
        $w1 = Carbon::now()->format('d M');

        $labels = [$w7,$w6,$w5,$w4,$w3,$w2,$w1];

        return $labels;
    }


    public function get7DayChallengersRecords()
    {
        $user = $this->user();
        $now = Carbon::today();

        $w7 = Carbon::now()->subDays(6);
        $w6 = Carbon::now()->subDays(5);
        $w5 = Carbon::now()->subDays(4);
        $w4 = Carbon::now()->subDays(3);
        $w3 = Carbon::now()->subDays(2);
        $w2 = Carbon::now()->subDays(1);
        $w1 = Carbon::now();

        $labels = [$w7,$w6,$w5,$w4,$w3,$w2,$w1];
        $datas = array();

        /* Instant Challanges *//*Instant & share Challengers 7 days tab*/
        $instantC = array();
        foreach ($labels as $day) {
            $instantChallanges = OfferSubscription::leftjoin('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
            ->where('offer_subscriptions.user_id', Auth::id())
            ->where('offer_subscriptions.channel_id', 2)
            ->where('offer_subscriptions.created_at', 'LIKE', Carbon::parse($day)->format("Y-m-d").'%')
            ->distinct()->count('offer_subscriptions.customer_id');

            if(!empty($instantC)){
                $lastCountInstant = end($instantC);
            }else{
                $lastCountInstant = 0;
            }
            $instantC[] = $lastCountInstant + $instantChallanges;
        }
        $datas[] = $instantC;
        /* Share Challanges */
        $shareC = array();
        foreach ($labels as $day) {
            $shareChallanges = OfferSubscription::leftjoin('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
            ->where('offer_subscriptions.user_id', Auth::id())
            ->where('offer_subscriptions.channel_id', 3)
            ->where('offer_subscriptions.created_at', 'LIKE', Carbon::parse($day)->format("Y-m-d").'%')
            ->distinct()->count('offer_subscriptions.customer_id'); 

            if(!empty($shareC)){
                $lastCountInstant = end($shareC);
            }else{
                $lastCountInstant = 0;
            }
            $shareC[] = $lastCountInstant + $shareChallanges;
        }
        $datas[] = $shareC;

        return $datas;
    }
/* Instant & share Challengers on 7D button click  end*/

/* Instant & share Challengers on 1M button click start*/
    public function last30DaysChallengers()
    {
        
        $labels = $this->last30DaysChallengersLb();
        $data = $this->last30DaysChallengersRecords();
        // dd($data);
        return response()->json(
            [
                'labels'=>$labels,
                'data'=>$data
            ]
        );
    }


    public function last30DaysChallengersLb()
    {
        for($i = 30; $i >= 0; $i--)
        { 
            $date =  Carbon::now()->subDays($i)->format("d M");

            $labels[] = $date;
        }
        return $labels;
    }


    public function last30DaysChallengersRecords()
    {
        $user = $this->user();
        for($i = 30; $i >= 0; $i--)
        { 
            $date =  Carbon::now()->subDays($i)->format("d M");

            $labels[] = $date;
        }
        $datas = array();
        /* Unique clicks */
        $instantC = array(); 
        foreach ($labels as $day) {

            $instantChallanges = OfferSubscription::leftjoin('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
            ->where('offer_subscriptions.user_id', Auth::id())
            ->where('offer_subscriptions.channel_id', 2)
            ->where('offer_subscriptions.created_at', 'LIKE', Carbon::parse($day)->format("Y-m-d").'%')
            ->distinct()->count('offer_subscriptions.customer_id');
            if(!empty($instantC)){
                $lastCountInstant = end($instantC);
            }else{
                $lastCountInstant = 0;
            }

            $instantC[] = $lastCountInstant + $instantChallanges;
        }
        $datas[] = $instantC;
        /* Extra Clicks */
        $shareC = array();
        foreach ($labels as $day) {
            $shareChallanges = OfferSubscription::leftjoin('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
            ->where('offer_subscriptions.user_id', Auth::id())
            ->where('offer_subscriptions.channel_id', 3)
            ->where('offer_subscriptions.created_at', 'LIKE', Carbon::parse($day)->format("Y-m-d").'%')
            ->distinct()->count('offer_subscriptions.customer_id');
            if(!empty($shareC)){
                $lastCountInstant = end($shareC);
            }else{
                $lastCountInstant = 0;
            }
            $shareC[] = $lastCountInstant + $shareChallanges;
        }
        $datas[] = $shareC;
        return $datas;
    }
    /* Instant & share Challengers on 1M button click end*/


    /* Instant & share Challengers on 1Y button click start*/
    public function last365DaysChallengers()
    { 
        $labels = $this->getLast365DaysChallengersLb();
        $data = $this->getLast365DaysChallengersRecords();
        return response()->json(
            [
                'labels'=>$labels,
                'data'=>$data
            ]
        );
    }


    public function getLast365DaysChallengersLb()
    {
        $previousMonth = Carbon::now()->subMonths(1);
        $count = $previousMonth->daysInMonth;
        $month = Carbon::parse($previousMonth)->format("M");
      
        for($i = 365; $i >= 0; $i--)
        { 
            $date =  Carbon::now()->subDays($i)->format("d M Y");

            $labels[] = $date;
        }

        return $labels;
    }


    public function getLast365DaysChallengersRecords()
    {
        $user = $this->user();
        for($i = 365; $i >= 0; $i--)
        { 
            $date =  Carbon::now()->subDays($i)->format("d M Y");

            $labels[] = $date;
        }
        $datas = array();
        /* Instant Challanges */
        $instantC = array(); 
        foreach ($labels as $day) {
            $instantChallanges = OfferSubscription::leftjoin('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
            ->where('offer_subscriptions.user_id', Auth::id())
            ->where('offer_subscriptions.channel_id', 2)
            ->where('offer_subscriptions.created_at', 'LIKE', Carbon::parse($day)->format("Y-m-d").'%')
            ->distinct()->count('offer_subscriptions.customer_id');
            if(!empty($instantC)){
                $lastCountInstant = end($instantC);
            }else{
                $lastCountInstant = 0;
            }
            $instantC[] = $lastCountInstant + $instantChallanges;
        }
        $datas[] = $instantC;

        /* Share Challanges */
        $shareC = array();
        foreach ($labels as $day) {
            $shareChallanges = OfferSubscription::leftjoin('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
            ->where('offer_subscriptions.user_id', Auth::id())
            ->where('offer_subscriptions.channel_id', 3)
            ->where('offer_subscriptions.created_at', 'LIKE', Carbon::parse($day)->format("Y-m-d").'%')
            ->distinct()->count('offer_subscriptions.customer_id');
            if(!empty($shareC)){
                $lastCountInstant = end($shareC);
            }else{
                $lastCountInstant = 0;
            }
            $shareC[] = $lastCountInstant + $shareChallanges;
        }
        $datas[] = $shareC;
        return $datas;
    }
    /* Instant & share Challengers  on 1Y button click end*/




    /* Instant & share Challengers offer starts from start*/
    public function offerStartFromChallengers()
    {
        $labels = $this->offerStartFromChallengersLb();
        $data = $this->offerStartFromChallengersRecords();
        return response()->json(['labels'=>$labels, 'data'=>$data, 'max'=> max($data), 'min'=> min($data)]);
    }


    public function offerStartFromChallengersLb()
    {
        $user = $this->user();
        $date =  Carbon::create($user->created_at)->Format("d M Y");
        $date_now =  Carbon::now()->Format("d M Y");
        $diff = now()->diffInDays(Carbon::parse($date));
        $labels = [];
        for($i = $diff; $i >= 0; $i--)
        { 
            $date =  Carbon::now()->subDays($i)->format("d M Y");
            $labels[] = $date;
        }

        return $labels;
    }


    public function offerStartFromChallengersRecords()
    {

        $user = $this->user();
        $date =  Carbon::create($user->created_at)->Format("d M Y");
        $date_now =  Carbon::now()->Format("d M Y");
        $diff = now()->diffInDays(Carbon::parse($date));
        $labels = [];
        for($i = $diff; $i >= 0; $i--)
        { 
            $date =  Carbon::now()->subDays($i)->format("d M Y");
            $labels[] = $date;
        }
        $datas = array();
        /* Instant Challenges */
        $instantC = array(); 
        foreach ($labels as $day) {
            
            $start_date = Carbon::parse($day)->format("Y-m-d");
            $end_date = Carbon::parse($day)->format("Y-m-d");
            
            $dailyInstantChallanges = OfferSubscription::leftjoin('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
            ->where('offer_subscriptions.user_id', Auth::id())
            ->where('offer_subscriptions.channel_id', 2)
            ->whereBetween('offer_subscriptions.created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
            ->distinct()->count('offer_subscriptions.customer_id');

            if(!empty($instantC)){
                $lastCountInstant = end($instantC);
            }else{
                $lastCountInstant = 0;
            }

            $instantC[] = $lastCountInstant + $dailyInstantChallanges;

        }
        $datas[] = $instantC;

        /* Share Challenges */
        $shareC = array(); 
        foreach ($labels as $day) {
            $start_date = Carbon::parse($day)->format("Y-m-d");
            $end_date = Carbon::parse($day)->format("Y-m-d");

            $dailyShareChallanges = OfferSubscription::leftjoin('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
            ->where('offer_subscriptions.user_id', Auth::id())
            ->where('offer_subscriptions.channel_id', 3)
            ->whereBetween('offer_subscriptions.created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
            ->distinct()->count('offer_subscriptions.customer_id');

            if(!empty($shareC)){
                $lastCountShare = end($shareC);
            }else{
                $lastCountShare = 0;
            }

            $shareC[] = $lastCountShare + $dailyShareChallanges;

        }
        $datas[] = $shareC;
        return $datas;
    }
    /* Instant & share Challengers offer starts from end*/


    /*Graph: Instant & Share Challenges For Current Offer */
    /* last 7 days  Instant & Share Challenges For Current Offer start */
    public function last7daysCurrentOfferSubscriberes(Request $request)
    { 
        $offer_id = $request->current_offer_id;
        $labels = $this->getlast7daysCurrentOfferSubscriberes($offer_id);
        $data = $this->getlast7daysCurrentOfferSubscriberesRecord($offer_id);
        return response()->json(
            [
                'labels'=>$labels,
                'data'=>$data
            ]
        );
    }


    public function getlast7daysCurrentOfferSubscriberes($offer_id)
    {
        $w7 = Carbon::now()->subDays(6)->format('d M');
        $w6 = Carbon::now()->subDays(5)->format('d M');
        $w5 = Carbon::now()->subDays(4)->format('d M');
        $w4 = Carbon::now()->subDays(3)->format('d M');
        $w3 = Carbon::now()->subDays(2)->format('d M');
        $w2 = Carbon::now()->subDays(1)->format('d M');
        $w1 = Carbon::now()->format('d M');

        $labels = [$w7,$w6,$w5,$w4,$w3,$w2,$w1];

        return $labels;
    }

    public function getlast7daysCurrentOfferSubscriberesRecord($offer_id)
    {
        $user = $this->user();
        $now = Carbon::today();

        $w7 = Carbon::now()->subDays(6);
        $w6 = Carbon::now()->subDays(5);
        $w5 = Carbon::now()->subDays(4);
        $w4 = Carbon::now()->subDays(3);
        $w3 = Carbon::now()->subDays(2);
        $w2 = Carbon::now()->subDays(1);
        $w1 = Carbon::now();

        $labels = [$w7,$w6,$w5,$w4,$w3,$w2,$w1];
        $datas = array();
        $instantC = array();
        foreach ($labels as $day) {
            // DB::enableQueryLog();

            $dailyDatas = OfferSubscription::leftjoin('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
            ->where('offer_subscriptions.offer_id', $offer_id)
            ->where('offer_subscriptions.channel_id', 2)
            ->where('offer_subscriptions.created_at', 'LIKE', Carbon::parse($day)->format("Y-m-d").'%')
            ->distinct()->count('offer_subscriptions.customer_id');

            if(!empty($instantC)){
                $lastCountInstant = end($instantC);
            }else{
                $lastCountInstant = 0;
            }
            $instantC[] = $lastCountInstant + $dailyDatas;
        }
        $datas[] = $instantC;
        /* Share Challanges */
        $shareC = array();
        foreach ($labels as $day) {
            $dailyDatas1 = OfferSubscription::leftjoin('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
            ->where('offer_subscriptions.offer_id', $offer_id)
            ->where('offer_subscriptions.channel_id', 3)
            ->where('offer_subscriptions.created_at', 'LIKE', Carbon::parse($day)->format("Y-m-d").'%')
            ->distinct()->count('offer_subscriptions.customer_id'); 
        
            if(!empty($shareC)){
                $lastCountInstant = end($shareC);
            }else{
                $lastCountInstant = 0;
            }
            $shareC[] = $lastCountInstant + $dailyDatas1;
        }
        $datas[] = $shareC;

        return $datas;
    }
    /* last 7 days  Instant & Share Challenges For Current Offer end */

    
   /* last 30 days  Instant & Share Challenges For Current Offer start */
    public function last30daysCurrentOfferSubscriberes(Request $request)
    {
        $offer_id = $request->current_offer_id;
        $labels = $this->getlast30daysCurrentOfferSubscriberesLb($offer_id);
        $data = $this->getlast30daysCurrentOfferSubscriberesRecords($offer_id);
       
        return response()->json(
            [
                'labels'=>$labels,
                'data'=>$data
            ]
        );
    }


    public function getlast30daysCurrentOfferSubscriberesLb($offer_id)
    {
        for($i = 30; $i >= 0; $i--)
        { 
            $date =  Carbon::now()->subDays($i)->format("d M");

            $labels[] = $date;
        }
        return $labels;
    }


    public function getlast30daysCurrentOfferSubscriberesRecords($offer_id)
    {
        $user = $this->user();
        for($i = 30; $i >= 0; $i--)
        { 
            $date =  Carbon::now()->subDays($i)->format("d M");

            $labels[] = $date;
        }
        $datas = array();
          /* Instant Challanges */
        $instantC = array(); 
        foreach ($labels as $day) {
            $instantChallanges = OfferSubscription::leftjoin('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
            ->where('offer_subscriptions.offer_id', $offer_id)
            ->where('offer_subscriptions.channel_id', 2)
            ->where('offer_subscriptions.created_at', 'LIKE', Carbon::parse($day)->format("Y-m-d").'%')
            ->distinct()->count('offer_subscriptions.customer_id');
            if(!empty($instantC)){
                $lastCountInstant = end($instantC);
            }else{
                $lastCountInstant = 0;
            }
            $instantC[] = $lastCountInstant + $instantChallanges;
        }
        $datas[] = $instantC;
         /* Share Challanges */
        $shareC = array();
        foreach ($labels as $day) {
            $shareChallanges = OfferSubscription::leftjoin('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
            ->where('offer_subscriptions.offer_id', $offer_id)
            // ->where('offer_subscriptions.user_id', Auth::id())
            ->where('offer_subscriptions.channel_id', 3)
            ->where('offer_subscriptions.created_at', 'LIKE', Carbon::parse($day)->format("Y-m-d").'%')
            ->distinct()->count('offer_subscriptions.customer_id');
            if(!empty($shareC)){
                $lastCountInstant = end($shareC);
            }else{
                $lastCountInstant = 0;
            }
            $shareC[] = $lastCountInstant + $shareChallanges;
        }
        $datas[] = $shareC;
        return $datas;
    }

    /*/ last 30 days Instant & Share Challenges For Current Offers end */




    /* last 365 days Instant & Share Challenges For Current Offer start*/

    public function last365daysCurrentOfferSubscriberes( Request $request)
    {
        $offer_id = $request->current_offer_id;
        $labels = $this->getlast365daysCurrentOfferSubscriberesLb($offer_id);
        $data = $this->getlast365daysCurrentOfferSubscriberesRecords($offer_id);
        return response()->json(
            [
                'labels'=>$labels,
                'data'=>$data
            ]
        );
    }


    public function getlast365daysCurrentOfferSubscriberesLb($offer_id)
    {
        $previousMonth = Carbon::now()->subMonths(1);
        $count = $previousMonth->daysInMonth;
        $month = Carbon::parse($previousMonth)->format("M");
      
        for($i = 365; $i >= 0; $i--)
        { 
            $date =  Carbon::now()->subDays($i)->format("d M Y");

            $labels[] = $date;
        }

        return $labels;
    }


    public function getlast365daysCurrentOfferSubscriberesRecords($offer_id)
    {
        $user = $this->user();
        for($i = 365; $i >= 0; $i--)
        { 
            $date =  Carbon::now()->subDays($i)->format("d M Y");

            $labels[] = $date;
        }
        $datas = array();
        /* Instant Challanges */
        $instantC = array(); 
        foreach ($labels as $day) {
            $instantChallanges = OfferSubscription::leftjoin('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
            ->where('offer_subscriptions.offer_id', $offer_id)
            // ->where('offer_subscriptions.user_id', Auth::id())
            ->where('offer_subscriptions.channel_id', 2)
            ->where('offer_subscriptions.created_at', 'LIKE', Carbon::parse($day)->format("Y-m-d").'%')
            ->distinct()->count('offer_subscriptions.customer_id');
            if(!empty($instantC)){
                $lastCountInstant = end($instantC);
            }else{
                $lastCountInstant = 0;
            }
            $instantC[] = $lastCountInstant + $instantChallanges;
        }
        $datas[] = $instantC;

        /* Share Challanges */
        $shareC = array();
        foreach ($labels as $day) {
            $shareChallanges = OfferSubscription::leftjoin('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
            ->where('offer_subscriptions.offer_id', $offer_id)
            // ->where('offer_subscriptions.user_id', Auth::id())
            ->where('offer_subscriptions.channel_id', 3)
            ->where('offer_subscriptions.created_at', 'LIKE', Carbon::parse($day)->format("Y-m-d").'%')
            ->distinct()->count('offer_subscriptions.customer_id');
            if(!empty($shareC)){
                $lastCountInstant = end($shareC);
            }else{
                $lastCountInstant = 0;
            }
            $shareC[] = $lastCountInstant + $shareChallanges;
        }
        $datas[] = $shareC;
        return $datas;
    }
    /* last 365 days Instant & Share Challenges For Current Offer end */



    /* Offer Strt from date Instant & Share Challenges For Current Offer start*/
    public function offerStartFromCurrentOfferSubscriberes(Request $request)
    {
        $offer_id = $request->current_offer_id;
        $labels = $this->getofferStartFromCurrentOfferSubscriberes($offer_id);
        $data = $this->getofferStartFromCurrentOfferSubscriberesRecords($offer_id);
        return response()->json(['labels'=>$labels, 'data'=>$data, 'max'=> max($data), 'min'=> min($data)]);
    }


    public function getofferStartFromCurrentOfferSubscriberes($offer_id)
    {
        $user = $this->user();
        $date =  Carbon::create($user->created_at)->Format("d M Y");
        $date_now =  Carbon::now()->Format("d M Y");
        $diff = now()->diffInDays(Carbon::parse($date));
        $labels = [];
        for($i = $diff; $i >= 0; $i--)
        { 
            $date =  Carbon::now()->subDays($i)->format("d M Y");
            $labels[] = $date;
        }

        return $labels;
    }


    public function getofferStartFromCurrentOfferSubscriberesRecords($offer_id)
    {

        $user = $this->user();
        $date =  Carbon::create($user->created_at)->Format("d M Y");
        $date_now =  Carbon::now()->Format("d M Y");
        $diff = now()->diffInDays(Carbon::parse($date));
        $labels = [];
        for($i = $diff; $i >= 0; $i--)
        { 
            $date =  Carbon::now()->subDays($i)->format("d M Y");
            $labels[] = $date;
        }
        $datas = array();
        /* Instant Challenges */
        $instantC = array(); 
        foreach ($labels as $day) {
            
            $start_date = Carbon::parse($day)->format("Y-m-d");
            $end_date = Carbon::parse($day)->format("Y-m-d");
            
            $dailyInstantChallanges = OfferSubscription::leftjoin('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
            ->where('offer_subscriptions.offer_id', $offer_id)
            // ->where('offer_subscriptions.user_id', Auth::id())
            ->where('offer_subscriptions.channel_id', 2)
            ->whereBetween('offer_subscriptions.created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
            ->distinct()->count('offer_subscriptions.customer_id');

            if(!empty($instantC)){
                $lastCountInstant = end($instantC);
            }else{
                $lastCountInstant = 0;
            }

            $instantC[] = $lastCountInstant + $dailyInstantChallanges;

        }
        $datas[] = $instantC;

        /* Share Challenges */
        $shareC = array(); 
        foreach ($labels as $day) {
            $start_date = Carbon::parse($day)->format("Y-m-d");
            $end_date = Carbon::parse($day)->format("Y-m-d");

            $dailyShareChallanges = OfferSubscription::leftjoin('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
            ->where('offer_subscriptions.offer_id', $offer_id)
            // ->where('offer_subscriptions.user_id', Auth::id())
            ->where('offer_subscriptions.channel_id', 3)
            ->whereBetween('offer_subscriptions.created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
            ->distinct()->count('offer_subscriptions.customer_id');

            if(!empty($shareC)){
                $lastCountShare = end($shareC);
            }else{
                $lastCountShare = 0;
            }

            $shareC[] = $lastCountShare + $dailyShareChallanges;

        }
        $datas[] = $shareC;
        return $datas;
    }
    /* Offer Stsrt from date Instant & Share Challenges For Current Offer end*/


    /* Graph Current Offer Chart */
    /* Last 7 days of Graph Current Offer Chart (7D Button Click) start*/
    public function last7daysCurrentOfferChart(Request $request)
    {  
        $offer_id = $request->current_offer_id;
        $users = User::where('id', Auth::id())->first();
        $labels = $this->getlast7daysCurrentOfferChart($offer_id);
        if($users->current_account_status== 'free'){
            $uniquedata = 0;
        }else{
            $uniquedata = $this->getlast7daysUniqueRecords($offer_id);
        }
        $totaldata = $this->getlast7daysTotalRecords($offer_id);

        // $data[] = $uniquedata;
        // $data[] = $totaldata;

        // return [
        //         'labels'=>$labels,
        //         'data'=>$data
        //     ];
        return [
            'labels'=>$labels,
            'uniquedata'=>$uniquedata,
            'totaldata'=>$totaldata
        ];
    }
    public function getlast7daysCurrentOfferChart($offer_id)
    {
        $w7 = Carbon::now()->subDays(6)->format('d M');
        $w6 = Carbon::now()->subDays(5)->format('d M');
        $w5 = Carbon::now()->subDays(4)->format('d M');
        $w4 = Carbon::now()->subDays(3)->format('d M');
        $w3 = Carbon::now()->subDays(2)->format('d M');
        $w2 = Carbon::now()->subDays(1)->format('d M');
        $w1 = Carbon::now()->format('d M');

        $labels = [$w7,$w6,$w5,$w4,$w3,$w2,$w1];

        return $labels;
    }

    public function getlast7daysUniqueRecords($offer_id)
    {
        $user = Auth::user();
        $now = Carbon::today();

        $w7 = Carbon::now()->subDays(6);
        $w6 = Carbon::now()->subDays(5);
        $w5 = Carbon::now()->subDays(4);
        $w4 = Carbon::now()->subDays(3);
        $w3 = Carbon::now()->subDays(2);
        $w2 = Carbon::now()->subDays(1);
        $w1 = Carbon::now();

        $labels = [$w7,$w6,$w5,$w4,$w3,$w2,$w1];
        $datas = array();

        /* Unique clicks */ 
        $updatedClicks = 0;
        foreach ($labels as $day) {
            $dailyDatas = Target::leftjoin('offer_subscriptions', 'targets.offer_subscription_id', '=', 'offer_subscriptions.id')
            ->leftjoin('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
            ->where('offer_subscriptions.offer_id', $offer_id)
            ->where('targets.repeated', 0)
            ->where('targets.created_at', 'LIKE', Carbon::parse($day)->format("Y-m-d").'%')
            ->count(); 

            $uniqueClicks[] = $dailyDatas;
        }

        return $datas = $uniqueClicks;
    }


    public function getlast7daysTotalRecords($offer_id)
    {
        $user = Auth::user();
        $now = Carbon::today();

        $w7 = Carbon::now()->subDays(6);
        $w6 = Carbon::now()->subDays(5);
        $w5 = Carbon::now()->subDays(4);
        $w4 = Carbon::now()->subDays(3);
        $w3 = Carbon::now()->subDays(2);
        $w2 = Carbon::now()->subDays(1);
        $w1 = Carbon::now();

        $labels = [$w7,$w6,$w5,$w4,$w3,$w2,$w1];
        $datas = array();

        /* Unique clicks */ 
        $updatedClicks = 0;
        foreach ($labels as $day) {
            $dailyDatas = Target::leftjoin('offer_subscriptions', 'targets.offer_subscription_id', '=', 'offer_subscriptions.id')
            ->leftjoin('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
            ->where('offer_subscriptions.offer_id', $offer_id)
            // ->where('targets.repeated', 1)
            ->where('targets.created_at', 'LIKE', Carbon::parse($day)->format("Y-m-d").'%')
            ->count(); 
            
            $uniqueClicks[] = $dailyDatas;
        }

        return $datas = $uniqueClicks;
    }

/* Last 7 days of Graph Current Offer Chart (7D Button Click) end*/


/* Last 30 days of Graph Current Offer Chart (7D Button Click) start*/
    public function last30daysCurrentOfferChart(Request $request)
    {  
        // dd($request->current_offer_id);
        if(!isset($request->current_offer_id) || $request->current_offer_id == null) {
            return false;
        }
         $offer_id = $request->current_offer_id;
        $users = User::where('id', Auth::id())->first();
        $labels = $this->getlast30daysCurrentOfferChart($offer_id);
        if($users->current_account_status== 'free'){
            $uniquedata = 0;
        }else{
            $uniquedata = $this->getlast30daysUniqueRecords($offer_id);
        }
        $totaldata = $this->getlast30daysTotalRecords($offer_id);

        $data[] = $uniquedata;
        $data[] = $totaldata;

        return [
                'labels'=>$labels,
                'data'=>$data
            ];
    }
    public function getlast30daysCurrentOfferChart($offer_id)
    {
        for($i = 30; $i >= 0; $i--)
        { 
            $date =  Carbon::now()->subDays($i)->format("d M");

            $labels[] = $date;
        }
        return $labels;
    }

    public function getlast30daysUniqueRecords($offer_id)
    {
        $user = Auth::user();
        for($i = 30; $i >= 0; $i--)
        { 
            $date =  Carbon::now()->subDays($i)->format("d M");
            
            $labels[] = $date;
        }
        $datas = array();
        

        /* Unique clicks */ 
        $updatedClicks = 0;
        foreach ($labels as $day) {
            $dailyDatas = Target::leftjoin('offer_subscriptions', 'targets.offer_subscription_id', '=', 'offer_subscriptions.id')
            ->leftjoin('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
            ->where('offer_subscriptions.offer_id', $offer_id)
            ->where('targets.repeated', 0)
            ->where('targets.created_at', 'LIKE', Carbon::parse($day)->format("Y-m-d").'%')
            ->count();
            $uniqueClicks[] = $dailyDatas;
        }
        
        return $datas = $uniqueClicks;
    }


    public function getlast30daysTotalRecords($offer_id)
    {
        $user = Auth::user();
        for($i = 30; $i >= 0; $i--)
        { 
            $date =  Carbon::now()->subDays($i)->format("d M");

            $labels[] = $date;
        }
        $datas = array();

        /* Unique clicks */ 
        $updatedClicks = 0;
        foreach ($labels as $day) {
            $dailyDatas = Target::leftjoin('offer_subscriptions', 'targets.offer_subscription_id', '=', 'offer_subscriptions.id')
            ->leftjoin('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
            ->where('offer_subscriptions.offer_id', $offer_id)
            // ->where('targets.repeated', 1)
            ->where('targets.created_at', 'LIKE', Carbon::parse($day)->format("Y-m-d").'%')
            ->count();
            $uniqueClicks[] = $dailyDatas;
        }
        // dd($uniqueClicks);
        return $datas = $uniqueClicks;
    }

/* Last 30 days of Graph Current Offer Chart (7D Button Click) end*/


/* Last 365 days of Graph Current Offer Chart (7D Button Click) start*/
    public function last365daysCurrentOfferChart(Request $request)
    {
        if(!isset($request->current_offer_id) || $request->current_offer_id == null) {
            return false;
        }
        $offer_id = $request->current_offer_id;
        $users = User::where('id', Auth::id())->first();
        $labels = $this->getlast365daysCurrentOfferChart($offer_id);
        if($users->current_account_status== 'free'){
            $uniquedata = 0;
        }else{
            $uniquedata = $this->getlast365daysUniqueRecords($offer_id);
        }
        $totaldata = $this->getlast365daysTotalRecords($offer_id);

        $data[] = $uniquedata;
        $data[] = $totaldata;

        return [
                'labels'=>$labels,
                'data'=>$data
            ];
    }
    public function getlast365daysCurrentOfferChart($offer_id)
    {
        for($i = 365; $i >= 0; $i--)
        { 
            $date =  Carbon::now()->subDays($i)->format("d M Y");

            $labels[] = $date;
        }
        return $labels;
    }

    public function getlast365daysUniqueRecords($offer_id)
    {
        $user = Auth::user();
        for($i = 365; $i >= 0; $i--)
        { 
            $date =  Carbon::now()->subDays($i)->format("d M Y");

            $labels[] = $date;
        }
        $datas = array();

        /* Unique clicks */ 
        $updatedClicks = 0;
        foreach ($labels as $day) {
            $dailyDatas = Target::leftjoin('offer_subscriptions', 'targets.offer_subscription_id', '=', 'offer_subscriptions.id')
            ->leftjoin('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
            ->where('offer_subscriptions.offer_id', $offer_id)
            ->where('targets.repeated', 0)
            ->where('targets.created_at', 'LIKE', Carbon::parse($day)->format("Y-m-d").'%')
            ->count(); 
            $uniqueClicks[] = $dailyDatas;
        }

        return $datas = $uniqueClicks;
    }


    public function getlast365daysTotalRecords($offer_id)
    {
        $user = Auth::user();
        for($i = 365; $i >= 0; $i--)
			{ 
				$date =  Carbon::now()->subDays($i)->format("d M Y");

				$labels[] = $date;
			}
        $datas = array();

        /* Unique clicks */ 
        $updatedClicks = 0;
        foreach ($labels as $day) {
            $dailyDatas = Target::leftjoin('offer_subscriptions', 'targets.offer_subscription_id', '=', 'offer_subscriptions.id')
            ->leftjoin('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
            ->where('offer_subscriptions.offer_id', $offer_id)
            // ->where('targets.repeated', 1)
            ->where('targets.created_at', 'LIKE', Carbon::parse($day)->format("Y-m-d").'%')
            ->count();
            $uniqueClicks[] = $dailyDatas;
        }

        return $datas = $uniqueClicks;
    }
/* Last 365 days of Graph Current Offer Chart (7D Button Click) end*/





/*  Offer start from date Graph Current Offer Chart (7D Button Click) start*/
    public function offerStartFromCurrentOfferChart( Request $request)
    {
        if(!isset($request->current_offer_id) || $request->current_offer_id == null) {
            return false;
        }
        $offer_id = $request->current_offer_id;
        $users = User::where('id', Auth::id())->first();
        $labels = $this->getofferStartFromCurrentOfferChart($offer_id);
        if($users->current_account_status== 'free'){
            $uniquedata = 0;
        }else{
            $uniquedata = $this->getofferStartFromUniqueRecords($offer_id);
        }
        $totaldata = $this->getofferStartFromTotalRecords($offer_id);

        $data[] = $uniquedata;
        $data[] = $totaldata;

        return [
                'labels'=>$labels,
                'data'=>$data
            ];
    }
    public function getofferStartFromCurrentOfferChart($offer_id)
    {
        $user = $this->user();
        $date =  Carbon::create($user->created_at)->Format("d M Y");
        $date_now =  Carbon::now()->Format("d M Y");
        $diff = now()->diffInDays(Carbon::parse($date));
        $labels = [];
        for($i = $diff; $i >= 0; $i--)
        { 
            $date =  Carbon::now()->subDays($i)->format("d M Y");
            $labels[] = $date;
        }

        return $labels;
    
    }

    public function getofferStartFromUniqueRecords($offer_id)
    {
        $user = $this->user();
        $date =  Carbon::create($user->created_at)->Format("d M Y");
        $date_now =  Carbon::now()->Format("d M Y");
        $diff = now()->diffInDays(Carbon::parse($date));
        $labels = [];
        for($i = $diff; $i >= 0; $i--)
        { 
            $date =  Carbon::now()->subDays($i)->format("d M Y");
            $labels[] = $date;
        }
        $datas = array();

        /* Unique clicks */ 
        $updatedClicks = 0;
        foreach ($labels as $day) {
            $dailyDatas = Target::leftjoin('offer_subscriptions', 'targets.offer_subscription_id', '=', 'offer_subscriptions.id')
            ->leftjoin('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
            ->where('offer_subscriptions.offer_id', $offer_id)
            ->where('targets.repeated', 0)
            ->where('targets.created_at', 'LIKE', Carbon::parse($day)->format("Y-m-d").'%')
            ->count(); 
            $uniqueClicks[] = $dailyDatas;
        }
        return $datas = $uniqueClicks;
    }


    public function getofferStartFromTotalRecords($offer_id)
    {
        $user = $this->user();
        $date =  Carbon::create($user->created_at)->Format("d M Y");
        $date_now =  Carbon::now()->Format("d M Y");
        $diff = now()->diffInDays(Carbon::parse($date));
        $labels = [];
        for($i = $diff; $i >= 0; $i--)
        { 
            $date =  Carbon::now()->subDays($i)->format("d M Y");
            $labels[] = $date;
        }
        $datas = array();

        /* Unique clicks */ 
        $updatedClicks = 0;
        foreach ($labels as $day) {
            $dailyDatas = Target::leftjoin('offer_subscriptions', 'targets.offer_subscription_id', '=', 'offer_subscriptions.id')
            ->leftjoin('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
            ->where('offer_subscriptions.offer_id', $offer_id)
            // ->where('targets.repeated', 1)
            ->where('targets.created_at', 'LIKE', Carbon::parse($day)->format("Y-m-d").'%')
            ->count(); 
            $uniqueClicks[] = $dailyDatas;
        }
        return $datas = $uniqueClicks;
    }
/*  Offer start from date Graph Current Offer Chart (7D Button Click) end*/

}