<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\Business\CommonSettingController;

use App\Models\Offer;

use Auth;

class OfferCalendarController extends Controller
{

    public function __construct()
    {
        $this->middleware('business');
    }

    public function index(Request $request)
    {
    	if($request->ajax())
    	{

            $data = Offer::where('user_id',Auth::id())->whereDate('start_date', '>=', $request->start)->whereDate('end_date',   '<=', $request->end)->get(['id', 'title', 'start_date AS start', 'end_date AS end']);
            //dd($data);
            return response()->json($data);
    	}

        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

    	return view('business.full-calender', compact('notification_list','planData'));
    }

    public function action(Request $request)
    {
    	if($request->ajax())
    	{
            //dd($request->all());

            if($request->type == 'add' || $request->type == 'update'){
                $start_date = date("Y-m-d", strtotime($request->start));  
                $end_date = date("Y-m-d", strtotime($request->end));  

                $offerExist = Offer::where(function ($query) use ($start_date, $end_date) {
                    $query->where('start_date', '>=', $start_date)
                        ->where('start_date', '<=', $end_date)
                        ->where('user_id',Auth::id());
                })
                ->orWhere(function ($query) use ($start_date, $end_date) {
                    $query->where('end_date', '>=', $start_date)
                        ->where('end_date', '<=', $end_date)
                        ->where('user_id',Auth::id());
                })
                ->first();

                if($offerExist != null){
                    return response()->json(['status' => false, 'data' => [], 'message' => 'Offer already running in this date range.']);
                }
            }

            $event = Offer::find($request->id);
            $event->start_date = $request->start;
            $event->end_date = $request->end;
            $event->save();

            return response()->json(['status' => true, 'data' => $event]);
    	}
    }

    public function offerList()
    {

        $offers = Offer::where('user_id',Auth::id())->where('start_date', NULL)->where('end_date', NULL)->get();

        return response()->json(["offers" => $offers, "count" => count($offers) ]);
    }
}
