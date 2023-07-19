<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use App\Models\Festival;
use App\Models\ContactGroup;
use App\Models\MessageTemplate;
use App\Models\MessageTemplateSchedule;
use App\Models\TimeSlot;
use App\Models\MessageTemplateCategory;
use App\Models\BusinessDetail;
use App\Models\AutoShareTiming;
use App\Models\UserChannel;
use App\Http\Controllers\Admin\RouteToggleContoller;

class FestivalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       
        // $festivalTemp = MessageTemplateSchedule::select('message_template_schedules.*')
        // ->leftjoin('time_slots', 'message_template_schedules.time_slot_id', '=', 'time_slots.id')
        // ->whereIn('message_template_schedules.related_to', ['Festival'])
        // ->where($whereConditions)
        // ->orWhere(function($query) use ($time_slot_ids, $orWhereConditions) {
        //     $query->where($orWhereConditions)
        //           ->whereIn('message_template_schedules.time_slot_id', $time_slot_ids);
        // })  
        // ->orderBy('message_template_schedules.scheduled', 'ASC')
        // ->orderBy('time_slots.value', 'ASC')
        // ->get();
        // return view('business.personalised-messages.index', compact('routes', 'notification_list', 'planData', 'groups', 'dobTemp', 'anniTemp', 'personalisedTemp', 'temp_categories', 'busnessDetails', 'usedDates', 'slots_array', 'groups_array','festiveGreetingTemp','festivalTemp','isChannelActive','timings'));
    }

    public function create()
    {
        $todays_date = date('Y-m-d');

        $groups = ContactGroup::where('user_id', Auth::id())
            ->orderBy('id', 'asc')
            ->get();

        $dobTemp = MessageTemplateSchedule::where('user_id', Auth::id())
            ->where('message_template_category_id', 7)
            ->orderBy('id', 'DESC')
            ->first();
        $anniTemp = MessageTemplateSchedule::where('user_id', Auth::id())
            ->where('message_template_category_id', 8)
            ->orderBy('id', 'DESC')
            ->first();

        $festiveGreetingTemp = Festival::where('status', 0)->orderBy('id', 'DESC')
        ->get();


        /* Time slots which are not passed */
        $time_slot_ids = TimeSlot::where('value', '>=', date("H:i:s"))->pluck('id')->toArray();

        $whereConditions = [
            ['message_template_schedules.user_id', '=', Auth::id()],
            ['message_template_schedules.channel_id', '=', 5],
            ['message_template_schedules.scheduled', '>', Carbon::now()->format('Y-m-d')],
        ];

        $orWhereConditions = [
            ['message_template_schedules.user_id', '=', Auth::id()],
            ['message_template_schedules.channel_id', '=', 5],
            ['message_template_schedules.scheduled', '=', Carbon::now()->format('Y-m-d')],
        ];
        
        $personalisedTemp = MessageTemplateSchedule::select('message_template_schedules.*')
            ->leftjoin('time_slots', 'message_template_schedules.time_slot_id', '=', 'time_slots.id')
            ->whereIn('message_template_schedules.related_to', ['Custom'])
            ->where($whereConditions)
            ->orWhere(function($query) use ($time_slot_ids, $orWhereConditions) {
                $query->where($orWhereConditions)
                      ->whereIn('message_template_schedules.time_slot_id', $time_slot_ids);
            })  
            ->orderBy('message_template_schedules.scheduled', 'ASC')
            ->orderBy('time_slots.value', 'ASC')
            ->get();



            $festivalTemp = MessageTemplateSchedule::select('message_template_schedules.*')
            ->leftjoin('time_slots', 'message_template_schedules.time_slot_id', '=', 'time_slots.id')
            ->whereIn('message_template_schedules.related_to', ['Festival'])
            ->where($whereConditions)
            ->orWhere(function($query) use ($time_slot_ids, $orWhereConditions) {
                $query->where($orWhereConditions)
                      ->whereIn('message_template_schedules.time_slot_id', $time_slot_ids);
            })  
            ->orderBy('message_template_schedules.scheduled', 'ASC')
            ->orderBy('time_slots.value', 'ASC')
            ->get();
           

        $temp_categories = MessageTemplateCategory::whereNotIn('id', [7, 8])->where('status', 1)->get();
        // dd($temp_categories);
      

        if (!$dobTemp) {
            $dobTemp = new MessageTemplateSchedule();
            $dobTemp->user_id = Auth::id();
            $dobTemp->channel_id = 5;
            $dobTemp->template_id = 1;
            $dobTemp->message_type_id = 1;
            $dobTemp->message_template_category_id = 7;
            $dobTemp->save();
        }
        if (!$anniTemp) {
            $anniTemp = new MessageTemplateSchedule();
            $anniTemp->user_id = Auth::id();
            $anniTemp->channel_id = 5;
            $anniTemp->template_id = 6;
            $anniTemp->message_type_id = 1;
            $anniTemp->message_template_category_id = 8;
            $anniTemp->save();
        }

        // $routes = RouteToggleContoller::routeDetail(Auth::id());

        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        $busnessDetails = BusinessDetail::where('user_id', Auth::id())->first();
        $busnessDetails->selected_groups = explode(',', $busnessDetails->selected_groups);
        
        $timeSlots = TimeSlot::where('status', 1)->get();
        $slots_array = array();
        foreach($timeSlots as $slot){
            // dd($slot);
            $opt = array(
                'value' => $slot->id,
                'label' => \Carbon\Carbon::parse($slot->value)->format('h:i A'),
                'disabled' => $slot->is_disabled ? true : false,
            );
            array_push($slots_array, $opt);
        }
        $groups_array = array();
        foreach($groups as $group){
            $opt = array(
                'value' => $group->id,
                'label' => $group->name,
                'disabled' => false,
            );
            array_push($groups_array, $opt);
        }

        /* Used Dates */
        $usedDates = [];
        foreach ($personalisedTemp as $message) {
            $usedDates[] = Carbon::parse($message->scheduled)->format('j-n-Y');
        }

        $timings = AutoShareTiming::where('status', 1)->get();
        $isChannelActive = UserChannel::whereChannelId(5)->whereUserId(Auth::id())->first('status');
        return view('admin.Festival.createFestival', compact('notification_list', 'planData', 'groups', 'dobTemp', 'anniTemp', 'personalisedTemp', 'temp_categories', 'busnessDetails', 'usedDates', 'slots_array', 'groups_array','festiveGreetingTemp','festivalTemp','isChannelActive','timings'));
    }

  
    public function getTemplates(Request $request)
    {
        
            $temp = MessageTemplate::with('category')
                ->where('message_template_category_id', '!=', '7')
                ->where('message_template_category_id', '!=', '8')
                ->orderBy('ordering', 'asc')
                ->get();
        // dd($temp);

        return response()->json(['status' => true, 'records' => $temp]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function storeFestival(Request $request)
    {
        // dd($request->festivalDate);
        // dd("u r in store");
        $festival = new Festival();
                $festival->template_id = 8;
                $festival->message_type_id = 1;
                $festival->message_template_category_id = $request->messageTemplateCategory_id;
                $festival->time_slot_id = $request->timeSlot_id;
                $festival->festival_name = $request->festivalName;
                // $festival->festival_date = $request->festivalDate;
                $festival->festival_date = Carbon::parse($request->festivalDate)->format('Y-m-d H:i:s');
                $festival->year = $request->yearpicker;
                $festival->status = 1;
                
                if ($festival->save()) {
                    return ['status' => true, 'res' => $festival];
                }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $festival = new Festival();
        // $festival->template_id = 8;
        // $festival->message_type_id = 1;
        // $festival->message_template_category_id = $request->messageTemplateCategory_id;
        // $festival->time_slot_id = $request->timeSlot_id;
        // $festival->festival_name = $request->festivalName;
        // // $festival->festival_date = $request->festivalDate;
        // $festival->festival_date = Carbon::parse($request->festivalDate)->format('Y-m-d H:i:s');
        // $festival->year = $request->yearpicker;
        // $festival->status = 1;
        
        // if ($festival->save()) {
        //     return ['status' => true, 'res' => $festival];
        // }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
