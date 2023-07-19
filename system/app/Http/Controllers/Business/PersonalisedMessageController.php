<?php

namespace App\Http\Controllers\Business;

use Auth, DB;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Wish;
use App\Jobs\SendSms;
use App\Models\Offer;
use App\Models\Option;
use App\Models\Customer;
use App\Models\Festival;
use App\Models\TimeSlot;
use App\Jobs\SendWishSms;
use App\Models\ShortLink;
use App\Jobs\SendCustomSms;
use App\Models\OfferReward;
use App\Models\UserChannel;
use App\Models\ContactGroup;
use App\Models\MessageRoute;
use Illuminate\Http\Request;
use App\Models\GroupCustomer;
use App\Models\MessageWallet;
use App\Models\BusinessDetail;
use App\Models\MessageHistory;
use App\Models\AutoShareTiming;
use App\Models\MessageTemplate;
use App\Models\BusinessCustomer;
use App\Models\OfferSubscription;
use App\Jobs\ShareNewOfferLinkJob;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\ShareChallengeContact;
use App\Models\MessageScheduleContact;
use App\Models\MessageTemplateCategory;
use App\Models\MessageTemplateSchedule;
use App\Models\OfferSubscriptionReward;
use Yajra\DataTables\Facades\DataTables;
use App\Helper\Deductions\DeductionHelper;
use App\Http\Controllers\ShortLinkController;
use App\Http\Controllers\UuidTokenController;

class PersonalisedMessageController extends Controller
{
    private $smsusername;
    private $smspassword;
    private $sendername;
    private $smsurl;

    // private $smsoptions;
    // private $waoptions;
    // private $waurl;

    public function __construct()
    {
        $this->middleware('business');

        //
        $this->smsoptions = Option::where('key', 'sms_gateway')->first();
        $this->smsurl = json_decode($this->smsoptions->value)->url . '/SMS_API/sendsms.php';

        $this->smsusername = json_decode($this->smsoptions->value)->username;
        $this->smspassword = json_decode($this->smsoptions->value)->password;
        $this->sendername = json_decode($this->smsoptions->value)->sendername;
    }

    public function index($channel_id, Request $request)
    {
        // dd(Carbon::tomorrow()->format('Y-m-d') );
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

        // $festiveGreetingTemp = MessageTemplateSchedule::select('message_template_schedules.*')
        //     ->leftjoin('time_slots', 'message_template_schedules.time_slot_id', '=', 'time_slots.id')
        //     ->orderBy('time_slots.value', 'ASC')
        //     ->get();
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
                      ->whereIn('message_template_schedules.related_to', ['Festival'])
                      ->whereIn('message_template_schedules.time_slot_id', $time_slot_ids);
            })  
            ->orderBy('message_template_schedules.scheduled', 'ASC')
            ->orderBy('time_slots.value', 'ASC')
            ->get();


            // dd($festivalTemp);

            // DB::enableQueryLog();

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
           
            // dd(DB::getQueryLog());
           

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

        $routes = RouteToggleContoller::routeDetail($channel_id, Auth::id());

        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        $busnessDetails = BusinessDetail::where('user_id', Auth::id())->first();
        if($busnessDetails->selected_groups!=NULL){
            $busnessDetails->selected_groups = explode(',', $busnessDetails->selected_groups);
        }else{
            $contact_groups = ContactGroup::where('user_id',Auth::id())->pluck('id')->toArray();
            $busnessDetails->selected_groups=$contact_groups;
        }
        
        $timeSlots = TimeSlot::where('status', 1)->get();
        $slots_array = array();
        foreach($timeSlots as $slot){
            $opt = array(
                'value' => $slot->id,
                'label' => Carbon::parse($slot->value)->format('h:i A'),
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
        
        return view('business.personalised-messages.index', compact('routes', 'notification_list', 'planData', 'groups', 'dobTemp', 'anniTemp', 'personalisedTemp', 'temp_categories', 'busnessDetails', 'usedDates', 'slots_array', 'groups_array','festiveGreetingTemp','festivalTemp','isChannelActive','timings'));
    }

    public function getTemplates(Request $request)
    {
        $message_template_category_id = $request->message_template_category_id;

        if ($message_template_category_id == '') {
            return response()->json(['status' => false, 'message' => 'Template category required! ']);
        }
        $temp = $schedule = [];
        if ($message_template_category_id == '7') {
            $temp = MessageTemplate::with('category')
                ->wishingTemplates('7')
                ->orderBy('ordering', 'asc')
                ->get();
            $schedule = MessageTemplateSchedule::where('user_id', Auth::id())
                ->where('message_template_category_id', '7')
                ->first();
        } elseif ($message_template_category_id == '8') {
            $temp = MessageTemplate::with('category')
                ->wishingTemplates('8')
                ->orderBy('ordering', 'asc')
                ->get();
            $schedule = MessageTemplateSchedule::where('user_id', Auth::id())
                ->where('message_template_category_id', '8')
                ->first();
        } else {
            $temp = MessageTemplate::with('category')
                ->where('message_template_category_id', '!=', '7')
                ->where('message_template_category_id', '!=', '8')
                ->orderBy('ordering', 'asc')
                ->get();
        }

        return response()->json(['status' => true, 'records' => $temp, 'schedule' => $schedule]);
    }
    public function searchTemplates(Request $request)
    {
        $text = $request->text;
        $category = $request->category;

        $where[] = ['status', '=', 1];

        if ($text != '') {
            $where[] = ['message', 'LIKE', '%' . $text . '%'];
        }

        if ($category !== 'all' && $category != '') {
            $where[] = ['message_template_category_id', '=', $category];
        }

        // DB::enableQueryLog();
        $temp = MessageTemplate::with('category')
            ->whereNotIn('message_template_category_id', [7, 8])
            ->where($where)
            ->orderBy('ordering', 'asc')
            ->get();
        // dd(DB::getQueryLog());
        // dd($temp);
        return response()->json(['status' => true, 'records' => $temp]);
    }
    public function searchTemplatesFest(Request $request)
    {
        $r_all = $request->all();
        $text = $r_all['text_fest'];
        $category = $request->category_fest;
        // dd($text);

        $where[] = ['status', '=', 1];


        if ($text != '') {
            $where[] = ['message', 'LIKE', '%' . $text . '%'];
        }
        if ($category !== 'all' && $category != '') {
            $where[] = ['message_template_category_id', '=', $category];
        }

        // DB::enableQueryLog();
        $temp = MessageTemplate::with('category')
            ->whereNotIn('message_template_category_id', [7, 8])
            ->where($where)
            ->orderBy('ordering', 'asc')
            ->get();
        // dd(DB::getQueryLog());
        // dd($temp);
        return response()->json(['status' => true, 'records' => $temp]);
    }
    public function template_search_fest(Request $request)
    {
        // dd( $request->all());
        $text = $request->text_fest;
        $category = $request->category_fest;

        $where[] = ['status', '=', 1];

        if ($text != '') {
            $where[] = ['message', 'LIKE', '%' . $text . '%'];
        }

        if ($category !== 'all' && $category != '') {
            $where[] = ['message_template_category_id', '=', $category];
        }

        // DB::enableQueryLog();
        $temp = MessageTemplate::with('category')
            ->whereNotIn('message_template_category_id', [7, 8])
            ->where($where)
            ->orderBy('ordering', 'asc')
            ->get();
        // dd(DB::getQueryLog());
        // dd($temp);
        return response()->json(['status' => true, 'records' => $temp]);
    }

    public function scheduleTemplate($id, $message_template_category_id, $channel_id, $temp_id, $datetime, $groups, $time_slot_id=NULL)
    {
        $schedule = MessageTemplateSchedule::where('user_id', Auth::id())
            // ->where('message_template_category_id', $message_template_category_id)
            ->where('id', $id)
            ->where('channel_id', $channel_id)
            ->orderBy('id', 'desc')
            ->first();

        $created = false;

        if ($message_template_category_id == 7 || $message_template_category_id == 8) {
            if ($schedule) {
                $schedule->channel_id = (int) $channel_id;
                $schedule->template_id = (int) $temp_id;
                // $schedule->is_scheduled = 1;
                $schedule->message_type_id = 1;
                $schedule->message_template_category_id = (int) $message_template_category_id;

                $created = true;
            } else {
                $schedule = new MessageTemplateSchedule();
                $schedule->user_id = Auth::id();
                $schedule->channel_id = (int) $channel_id;
                $schedule->template_id = (int) $temp_id;
                // $schedule->is_scheduled = 1;
                $schedule->message_type_id = 1;
                $schedule->message_template_category_id = (int) $message_template_category_id;

                $created = true;
            }
        } else {
            if ($schedule) {
                $schedule->delete();

                $schedule->channel_id = (int) $channel_id;
                $schedule->template_id = (int) $temp_id;
                $schedule->message_type_id = 1;
                $schedule->message_template_category_id = (int) $message_template_category_id;
                $schedule->scheduled = Carbon::parse($datetime)->format('Y-m-d H:i:s');
                $schedule->time_slot_id = $time_slot_id;
                $schedule->groups_id = implode(',', $groups);

                $created = false;
            } else {
                $schedule = new MessageTemplateSchedule();
                $schedule->user_id = Auth::id();
                $schedule->channel_id = (int) $channel_id;
                $schedule->template_id = (int) $temp_id;
                $schedule->message_type_id = 1;
                $schedule->message_template_category_id = (int) $message_template_category_id;
                $schedule->scheduled = Carbon::parse($datetime)->format('Y-m-d H:i:s');
                $schedule->time_slot_id = $time_slot_id;
                $schedule->groups_id = implode(',', $groups);

                $created = true;
            }
        }
        // dd($schedule);
        if ($schedule->save()) {
            return ['status' => true, 'res' => $schedule, 'created' => $created];
        } else {
            return ['status' => false, 'res' => $schedule, 'created' => $created];
        }
    }

    public function setTemplate(Request $request)
    {

        /* Restriction */
        $userData=User::where('id',Auth::id())->first();
        $wallet = MessageWallet::where('user_id', Auth::id())->first();
        if($userData->current_account_status=='paid'){
            if($wallet->wallet_balance <= 0){
                return response()->json(['status' => false, 'message' => config('constants.payment_alert')]);
            }
        }else{
                return response()->json(['status' => false, 'message' => config('constants.payment_alert')]);  
        }
        


        $datetime = $time = '';
        $temp = '';
        $row = false;
        $message_template_category_id = $request->message_template_category_id;
        $temp_id = $request->temp_id;
        $channel_id = $request->channel_id;
        $date = $request->date;
        $time_slot_id = $request->time;
        $groups = $request->groups;
        
        $timeSlot = TimeSlot::find($request->time);
        if($timeSlot!=NULL){
            $time = $timeSlot->value;
        }

        if ($date != null || $time != null) {
            $datetime = date($date . ' ' . $time);
        }
        if ($request->id == null || $request->id == '') {
            $id = '0';
        } else {
            $id = $request->id;
        }

        // return response()->json($request);

        if ($message_template_category_id == '') {
            return response()->json(['status' => false, 'message' => 'Message Template required!']);
        }
        if ($temp_id == '') {
            return response()->json(['status' => false, 'message' => 'Message template ID is required!']);
        }

        if ($message_template_category_id != '7' && $message_template_category_id != '8') {
            if ($datetime == '') {
                return response()->json(['status' => false, 'message' => 'Date & Time is required! ']);
            }
            if ($groups == '') {
                return response()->json(['status' => false, 'message' => 'Groups is required! ']);
            }
            $row = true;

            // Check No. of Persone set msg on same datetime
            // DB::enableQueryLog();
            $checkNoOfPersonSendSameDatetimeMsg = 2;
            $checkDate = Carbon::parse($date.' '.$time)->format('Y-m-d H:i');
            $isScheduleAvailable = MessageTemplateSchedule::whereNotIn('message_template_category_id', [7, 8])->where('scheduled', $checkDate)->count();

            if($isScheduleAvailable >= $checkNoOfPersonSendSameDatetimeMsg){
                return response()->json([
                    'status' => false, 
                    'message' => 'This time already occupied by another user, please select another time!'
                ]);
            }

            // check datewise message schedule or not
            // dd($request);

            // $todayDate = Carbon::now();
            // $todayDate = Carbon::parse($todayDate)->format('Y-m-d');
            if ($request->id != null) {
                $isScheduleAvailable = MessageTemplateSchedule::where('user_id', Auth::id())
                    ->where('id', '!=', $request->id)
                    ->whereDate('scheduled', $date)
                    ->first();
            } else {
                $isScheduleAvailable = MessageTemplateSchedule::where('user_id', Auth::id())
                    ->whereDate('scheduled', $date)
                    ->first();
            }
            // dd($isScheduleAvailable);
            if ($isScheduleAvailable != null) {
                return response()->json(['status' => false, 'message' => 'Already message schedule on this date!']);
            }
        }

        $schedule = $this->scheduleTemplate($id, $message_template_category_id, $channel_id, $temp_id, $datetime, $groups, $time_slot_id);
        // return response()->json($schedule);
        // echo "schedule";
        // dd($schedule['res']->template->category);
        
        $businessDetail = BusinessDetail::where('user_id', Auth::id())->first();
        if($businessDetail!=NULL){
            $temp = str_replace("[business_name]", $businessDetail->business_name, $schedule['res']->template->message);
            $temp = str_replace("{#var#}", $businessDetail->business_name, $temp);
        }

        
        $title = $schedule['res']->template->category->name;
        $date = Carbon::parse($schedule['res']->scheduled)->format('d M, Y');
        $time = Carbon::parse($schedule['res']->scheduled)->format('h:i A');

        return response()->json([
            'id' => $schedule['res']->id,
            'message' => 'Message template has been set successfully.',
            'temp' => $temp,
            'date' => $date,
            'time' => $time,
            'row' => $row,
            'title' => $title,
            'created' => $schedule['created'],
            'status' => $schedule['status'],
        ]);
    }

    public function setTemplateFestival(Request $request)
    {

        /* Restriction */
        $wallet = MessageWallet::where('user_id', Auth::id())->first();
        if($wallet->wallet_balance <= 0){
            return response()->json(['status' => false, 'message' => config('constants.payment_alert')]);
        }


        $datetime = $time = '';
        $temp = '';
        $row = false;
        $message_template_category_id = $request->message_template_category_id;
        $temp_id = $request->temp_id;
        $channel_id = $request->channel_id;
        $date = $request->date;
        $time_slot_id = $request->time;
        $groups = $request->groups;
        
        $timeSlot = TimeSlot::find($request->time);
        if($timeSlot!=NULL){
            $time = $timeSlot->value;
        }

        if ($date != null || $time != null) {
            $datetime = date($date . ' ' . $time);
        }
        if ($request->id == null || $request->id == '') {
            $id = '0';
        } else {
            $id = $request->id;
        }

        // return response()->json($request);

        if ($message_template_category_id == '') {
            return response()->json(['status' => false, 'message' => 'Message Template required!']);
        }
        if ($temp_id == '') {
            return response()->json(['status' => false, 'message' => 'Message template ID is required!']);
        }

        if ($message_template_category_id != '7' && $message_template_category_id != '8') {
            if ($datetime == '') {
                return response()->json(['status' => false, 'message' => 'Date & Time is required! ']);
            }
            if ($groups == '') {
                return response()->json(['status' => false, 'message' => 'Groups is required! ']);
            }
            $row = true;

            // Check No. of Persone set msg on same datetime
            // DB::enableQueryLog();
            $checkNoOfPersonSendSameDatetimeMsg = 2;
            $checkDate = Carbon::parse($date.' '.$time)->format('Y-m-d H:i');
            $isScheduleAvailable = MessageTemplateSchedule::whereNotIn('message_template_category_id', [7, 8])->where('scheduled', $checkDate)->count();

            if($isScheduleAvailable >= $checkNoOfPersonSendSameDatetimeMsg){
                return response()->json([
                    'status' => false, 
                    'message' => 'This time already occupied by another user, please select another time!'
                ]);
            }

            // check datewise message schedule or not
            // dd($request);

            // $todayDate = Carbon::now();
            // $todayDate = Carbon::parse($todayDate)->format('Y-m-d');
            if ($request->id != null) {
                $isScheduleAvailable = MessageTemplateSchedule::where('user_id', Auth::id())
                    ->where('id', '!=', $request->id)
                    ->whereDate('scheduled', $date)
                    ->first();
            } else {
                $isScheduleAvailable = MessageTemplateSchedule::where('user_id', Auth::id())
                    ->whereDate('scheduled', $date)
                    ->first();
            }
            // dd($isScheduleAvailable);
            if ($isScheduleAvailable != null) {
                return response()->json(['status' => false, 'message' => 'Already message schedule on this date!']);
            }
        }

        $schedule = $this->scheduleTemplate($id, $message_template_category_id, $channel_id, $temp_id, $datetime, $groups, $time_slot_id);
        // return response()->json($schedule);
        // echo "schedule";
        // dd($schedule['res']->template->category);
        
        $businessDetail = BusinessDetail::where('user_id', Auth::id())->first();
        if($businessDetail!=NULL){
            $temp = str_replace("[business_name]", $businessDetail->business_name, $schedule['res']->template->message);
            $temp = str_replace("{#var#}", $businessDetail->business_name, $temp);
        }

        
        $title = $schedule['res']->template->category->name;
        $date = Carbon::parse($schedule['res']->scheduled)->format('d M, Y');
        $time = Carbon::parse($schedule['res']->scheduled)->format('h:i A');

        return response()->json([
            'id' => $schedule['res']->id,
            'message' => 'Message template has been set successfully.',
            'temp' => $temp,
            'date' => $date,
            'time' => $time,
            'row' => $row,
            'title' => $title,
            'created' => $schedule['created'],
            'status' => $schedule['status'],
        ]);
    }

    public function editTemplate(Request $request)
    {
// dd($request->all());
        $schedule = MessageTemplateSchedule::where('user_id', Auth::id())
            ->where('id', $request->id)
            ->with('template')
            ->first();
            
           if(isset($request->cat_id)){
                $temps = MessageTemplate::with('category')
                ->where('message_template_category_id', $request->cat_id)
                ->orderBy('ordering', 'asc')
                ->get();
           }else{
                $temps = MessageTemplate::with('category')
                ->where('message_template_category_id', '!=', '7')
                ->where('message_template_category_id', '!=', '8')
                ->orderBy('ordering', 'asc')
                ->get();
           }
        $timeSlots = TimeSlot::where('status', 1)->get();
        $slots_array = array();
        foreach($timeSlots as $slot){
            $opt = array(
                'value' => $slot->id,
                'label' => Carbon::parse($slot->value)->format('h:i A'),
                'disabled' => $slot->is_disabled ? true : false,
                'selected' => ($slot->id == $schedule->time_slot_id) ? true : false,
            );
            array_push($slots_array, $opt);
        }
        
        // Working Code
        // $selectedGroupsInfo=array();
        // if($schedule->groups_id!=NULL){
        //     $groupsIds = explode(',', $schedule->groups_id);
        //     $selectedGroupsInfo = ContactGroup::where('user_id', Auth::id())
        //                 ->whereIn('id', $groupsIds)
        //                 ->orderBy('id', 'asc')
        //                 ->get();
        // }

        $selectedGroupsInfo=array();
        if($schedule->groups_id!=NULL){
            $groupsIds = explode(',', $schedule->groups_id);
            $selectedGroups = ContactGroup::where('user_id', Auth::id())
                        ->orderBy('id', 'asc')
                        ->get();

            foreach($selectedGroups as $group){
                $opt = array(
                    'value' => $group->id,
                    'label' => $group->name,
                    'selected' => in_array($group->id, $groupsIds) ? true : false,
                );
                array_push($selectedGroupsInfo, $opt);
            }
        }

        $checkPersonalisedTempDates = MessageTemplateSchedule::where('user_id', Auth::id())
                    ->whereNotIN('message_template_category_id', [7, 8])
                    ->where('id', $schedule->id)
                    ->first();

        /* Used Dates */
        $usedDates = "";
        if($checkPersonalisedTempDates!=NULL){
            $usedDates = Carbon::parse($checkPersonalisedTempDates->scheduled)->format('j-n-Y');
        }

        if ($schedule) {
            $record = [];
            $record = [
                'id' => $schedule->id,
                'cat_id' => $request->cat_id,
                'template_id' => $schedule->template_id,
                'type_id' => $schedule->message_type_id,
                'message_template_category_id' => $schedule->message_template_category_id,
                'temp_message' => $schedule->template->message,
                'temp_name' => $schedule->template->category->name,
                'date' => Carbon::parse($schedule->scheduled)->format('d-m-Y'),
                'time_slot_id' => $schedule->time_slot_id,
                'route_type' => $schedule->template->route_type,
                'groups' => explode(',', $schedule->groups_id),
                'selectedGroupsInfo' => $selectedGroupsInfo,
                'status' => $schedule->status,
                'templates' => $temps,
                'slots_array' => $slots_array,
                'temp_category_id' => $request->cat_id,
                'usedDates' => $usedDates
            ];
            // dd($record['temp_category']);
            return response()->json(['status' => true, 'message' => 'Schedule found', 'record' => $record]);
        } else {
            return response()->json(['status' => false, 'message' => 'Schedule not found']);
        }
    }

    public function editFestivalTemplate(Request $request)
    {
// dd($request->all());
        $schedule = MessageTemplateSchedule::where('user_id', Auth::id())
            ->where('id', $request->id)
            ->with('template')
            ->first();
            
           if(isset($request->cat_id)){
                $temps = MessageTemplate::with('category')
                ->where('message_template_category_id', $request->cat_id)
                ->orderBy('ordering', 'asc')
                ->get();
           }else{
                $temps = MessageTemplate::with('category')
                ->where('message_template_category_id', '!=', '7')
                ->where('message_template_category_id', '!=', '8')
                ->orderBy('ordering', 'asc')
                ->get();
           }
        //    dd($temps,$request->all());
        $timeSlots = TimeSlot::where('status', 1)->get();
        $slots_array = array();
        foreach($timeSlots as $slot){
            $opt = array(
                'value' => $slot->id,
                'label' => Carbon::parse($slot->value)->format('h:i A'),
                'disabled' => $slot->is_disabled ? true : false,
                'selected' => ($slot->id == $schedule->time_slot_id) ? true : false,
            );
            array_push($slots_array, $opt);
        }
        
        // Working Code
        // $selectedGroupsInfo=array();
        // if($schedule->groups_id!=NULL){
        //     $groupsIds = explode(',', $schedule->groups_id);
        //     $selectedGroupsInfo = ContactGroup::where('user_id', Auth::id())
        //                 ->whereIn('id', $groupsIds)
        //                 ->orderBy('id', 'asc')
        //                 ->get();
        // }

        $selectedGroupsInfo=array();
        if($schedule->groups_id!=NULL){
            $groupsIds = explode(',', $schedule->groups_id);
            $selectedGroups = ContactGroup::where('user_id', Auth::id())
                        ->orderBy('id', 'asc')
                        ->get();

            foreach($selectedGroups as $group){
                $opt = array(
                    'value' => $group->id,
                    'label' => $group->name,
                    'selected' => in_array($group->id, $groupsIds) ? true : false,
                );
                array_push($selectedGroupsInfo, $opt);
            }
        }

        $checkPersonalisedTempDates = MessageTemplateSchedule::where('user_id', Auth::id())
                    ->whereNotIN('message_template_category_id', [7, 8])
                    ->where('id', $schedule->id)
                    ->first();

        /* Used Dates */
        $usedDates = "";
        if($checkPersonalisedTempDates!=NULL){
            $usedDates = Carbon::parse($checkPersonalisedTempDates->scheduled)->format('j-n-Y');
        }
// dd($schedule);
        if ($schedule) {
            $record = [];
            $record = [
                'id' => $schedule->id,
                'cat_id' => $request->cat_id,
                'template_id' => $schedule->template_id,
                'type_id' => $schedule->message_type_id,
                'message_template_category_id' => $schedule->message_template_category_id,
                'temp_message' => $schedule->template->message,
                'temp_name' => $schedule->template->category->name,
                'date' => Carbon::parse($schedule->scheduled)->format('d-m-Y'),
                'time_slot_id' => $schedule->time_slot_id,
                'route_type' => $schedule->template->route_type,
                'groups' => explode(',', $schedule->groups_id),
                'selectedGroupsInfo' => $selectedGroupsInfo,
                'status' => $schedule->status,
                'templates' => $temps,
                'slots_array' => $slots_array,
                'temp_category_id' => $request->cat_id,
                'usedDates' => $usedDates
            ];
            // dd($record);
            return response()->json(['status' => true, 'message' => 'Schedule found', 'record' => $record]);
        } else {
            return response()->json(['status' => false, 'message' => 'Schedule not found']);
        }
    }

    public function cancelTemplate(Request $request)
    {
        // return response()->json($request);
        $schedule = MessageTemplateSchedule::where('user_id', Auth::id())
            ->where('id', $request->id)
            ->first();

        if ($schedule) {
            $schedule->delete();
            return response()->json(['status' => true, 'message' => 'Schedule deleted successfully']);
        } else {
            return response()->json(['status' => false, 'message' => 'Schedule not found']);
        }
    }

    public function scheduleMsg(Request $request)
    {
        // dd( decrypt($request->all()));
        $scheduleMsg = MessageTemplateSchedule::where('user_id', Auth::id())
            ->where('message_template_category_id', decrypt($request->category_type_id))
            ->first();
        if ($scheduleMsg->is_scheduled == 0) {
            $route = MessageRoute::where('user_id', Auth::id())->where('channel_id', 5)->first();
            if($route->sms == 1){
                  $checkWalletBalance = DeductionHelper::checkWalletBalanceWithChannel(Auth::id(), 5, ['send_sms']);
                    if($checkWalletBalance['status'] != true){
                        return response()->json(["status" => $checkWalletBalance['status'], "message" => 'Low']);
                    }   
            } 
        }
        if ($scheduleMsg->is_scheduled == 0) {
            $scheduleMsg->is_scheduled = 1;
            /*if(isset($request->groups_id)){
                $groups = implode(',', $request->groups_id);
                $scheduleMsg->groups_id = $groups;
            }*/
        } else {
            $scheduleMsg->is_scheduled = 0;
        }
        if ($scheduleMsg->save()) {
            return response()->json(['status' => true, 'message' => 'Status updated successfully!']);
        } else {
            return response()->json(['status' => false, 'message' => 'Unable to Failed to update status!']);
        }
    }

    // Send Message => call from Job
    public function sendMessage($request, $type = '')
    {
        // echo "request"; dd($type, $request);
        if ($request != null) {
            $userSmsParams = $userWaParams = [];

            $deductionDetail = DeductionHelper::getActiveDeductionDetail('slug', 'send_sms');
            foreach ($request as $key => $scheduleMsg) {
                $busniess_name = @$scheduleMsg->getUserDetails->bussiness_detail->business_name;

                $busniess_name = $busniess_name ?? 'business owner';
                if (strlen($busniess_name) > 28) {
                    $busniess_name = substr($busniess_name, 0, 28) . '..';
                }

                $message = @$scheduleMsg->template->message;
                $message = str_replace('[business_name]', $busniess_name, $message);
                $message = str_replace('{#var#}', $busniess_name, $message);

                // DOB
                if ($type == 'dob') {
                    if ($scheduleMsg->getMessageRoute['sms'] == 1) {
                        $todays_date = date('j F');
                        // DB::enableQueryLog();
                        $businessCustomer = BusinessCustomer::where('user_id', $scheduleMsg->user_id)
                            ->where('dob', $todays_date)
                            ->get();

                        $businessCustomerIds = BusinessCustomer::where('user_id', $scheduleMsg->user_id)
                            ->where('dob', $todays_date)
                            ->pluck('customer_id')
                            ->toArray();

                        $checkWalletBalance = DeductionHelper::checkWalletBalance($scheduleMsg->user_id, $deductionDetail->id ?? 0);
                        if ($checkWalletBalance['status']==true) {
                            foreach (@$businessCustomer as $cusKey => $busCustomer) {
                                if ($busCustomer != null) {
                                    $userSmsParams[] = $this->_setCustomerDetailsForSms($busCustomer, $message, $scheduleMsg, $type);
                                }
                            }
                        }
                    }
                }

                if ($type == 'anniversary') {
                    if ($scheduleMsg->getMessageRoute['sms'] == 1) {
                        $todays_date = date('j F');
                        
                        $businessCustomer = BusinessCustomer::where('user_id', $scheduleMsg->user_id)
                            ->where('anniversary_date', $todays_date)
                            ->get();

                        $businessCustomerIds = BusinessCustomer::where('user_id', $scheduleMsg->user_id)
                            ->where('anniversary_date', $todays_date)
                            ->pluck('customer_id')
                            ->toArray();

                        $checkWalletBalance = DeductionHelper::checkWalletBalance($scheduleMsg->user_id, $deductionDetail->id ?? 0);
                        if ($checkWalletBalance['status']==true) {
                            if ($businessCustomer) {
                                foreach (@$businessCustomer as $cusKey => $busCustomer) {
                                    if ($busCustomer != null) {
                                        $userSmsParams[] = $this->_setCustomerDetailsForSms($busCustomer, $message, $scheduleMsg, $type);
                                    }
                                }
                            }
                        }
                    }
                }

                if ($type == 'otherMsg') {
                    $groups = explode(',', $scheduleMsg->groups_id);
                    $grpCustomers = GroupCustomer::whereIn('contact_group_id', $groups)
                        ->groupBy('customer_id')
                        ->pluck('customer_id')
                        ->toArray();

                    $businessCustomerIds = BusinessCustomer::with('getCustomerInfo')
                        ->whereIN('customer_id', $grpCustomers)
                        ->groupBy('customer_id')
                        ->pluck('customer_id')
                        ->toArray();

                    if ($scheduleMsg->getMessageRoute['sms'] == 1) {
                        $businessCustomer = BusinessCustomer::with('getCustomerInfo')
                            ->whereIN('customer_id', $grpCustomers)
                            ->groupBy('customer_id')
                            ->get();

                        $checkWalletBalance = DeductionHelper::checkWalletBalance($scheduleMsg->user_id, $deductionDetail->id ?? 0);
                        if ($checkWalletBalance['status']==true && count($businessCustomer) > 0 ) {
                            foreach (@$businessCustomer as $cusKey => $busCustomer) {
                                if ($busCustomer != null) {
                                    $userSmsParams[] = $this->_setCustomerDetailsForSms($busCustomer, $message, $scheduleMsg, $type);
                                }
                            }
                        } else {
                            $currentScheduleMsg = MessageTemplateSchedule::where('id', $scheduleMsg->id)->first();
                            $currentScheduleMsg->sms_status = 'cancelled';
                            $currentScheduleMsg->customer_ids = implode(', ', @$businessCustomerIds);
                            $currentScheduleMsg->save();
                        }
                    } else {
                        $currentScheduleMsg = MessageTemplateSchedule::where('id', $scheduleMsg->id)->first();
                        $currentScheduleMsg->sms_status = 'route_inactive';
                        $currentScheduleMsg->customer_ids = implode(', ', @$businessCustomerIds);
                        $currentScheduleMsg->save();
                    }
                }
            }

            if ($userSmsParams != null) {
                $dataArr = [];
                foreach ($userSmsParams as $key => $params) {
                    $data = $this->validateParams($params);
                    if ($data['status'] == true) {
                        $dataArr[] = $data;
                    }
                    // $this->sendSmsMsg($dataArr);
                }

                // echo "\n suc type:- ";
                // print_r($dataArr);
                dispatch(new SendSms($dataArr));
            }
            echo 'successfully send sms';
        }
    }

    private function _setCustomerDetailsForSms($busCustomer, $message, $scheduleMsg, $type = '', $wish_id = 0)
    {
        $message = str_replace('[customer_name]', @$busCustomer->name, $message);
        $user['customer_id'] = @$busCustomer->getCustomerInfo->id;
        $user['mobile'] = '91' . @$busCustomer->getCustomerInfo->mobile;
        $user['message'] = $message;
        $user['channel_id'] = @$scheduleMsg->channel_id;
        $user['schedule_id'] = @$scheduleMsg->id;
        $user['user_id'] = $scheduleMsg->user_id;
        $user['type'] = @$type;
        $user['wish_id'] = @$wish_id;
        return $user;
    }

    private function _setCustomerContactDetailsForSms($busCustomer, $message, $scheduleMsg, $type = '', $contact_id = 0)
    {
        $message = str_replace('[customer_name]', @$busCustomer->name, $message);
        $user['customer_id'] = @$busCustomer->getCustomerInfo->id;
        $user['mobile'] = '91' . @$busCustomer->getCustomerInfo->mobile;
        $user['message'] = $message;
        $user['channel_id'] = @$scheduleMsg->channel_id;
        $user['schedule_id'] = @$scheduleMsg->id;
        $user['user_id'] = $scheduleMsg->user_id;
        $user['type'] = @$type;
        $user['contact_id'] = @$contact_id;
        return $user;
    }

    public function validateWishParams($params)
    {
        $dataArr = [];

        $userData = User::where('id', $params['user_id'])
                    ->where('status', 1)
                    ->orderBy('id', 'desc')
                    ->first();

        $dataArr = [
            'user_id' => $userData != null ? $userData->id : $params['user_id'],
            'customer_id' => $params['customer_id'],
            'mobile' => $params['mobile'],
            'message' => $params['message'],
            'channel_id' => $params['channel_id'],
            'schedule_id' => $params['schedule_id'],
            'wish_id' => $params['wish_id'],
            'type' => $params['type'],
            'status' => true,
        ];

        return $dataArr;
    }

    public function validateContactParams($params)
    {
        $dataArr = [];

        $userData = User::where('id', $params['user_id'])
                    ->where('status', 1)
                    ->orderBy('id', 'desc')
                    ->first();

        $dataArr = [
            'user_id' => $userData != null ? $userData->id : $params['user_id'],
            'customer_id' => $params['customer_id'],
            'mobile' => $params['mobile'],
            'message' => $params['message'],
            'channel_id' => $params['channel_id'],
            'schedule_id' => $params['schedule_id'],
            'contact_id' => $params['contact_id'],
            'type' => $params['type'],
            'status' => true,
        ];

        return $dataArr;
    }

    public function validateParams($params)
    {
        $dataArr = [];
        if (!is_numeric($params['mobile']) || strlen($params['mobile']) != 12 || $params['mobile'] == '') {
            // return ['status'=> false, 'data' => [], 'message'=> 'Number is invalid.'];
            $dataArr = [
                'user_id' => '',
                'mobile' => '',
                'message' => 'Number is invalid!',
                'channel_id' => '',
                'status' => false,
            ];
        } elseif (!isset($params['message']) || $params['message'] == '') {
            // return ['status'=> false, 'data' => [], 'message'=> 'Didn\'t get message.'];
            $dataArr = [
                'user_id' => '',
                'mobile' => '',
                'message' => 'Didn\'t get message!',
                'channel_id' => '',
                'status' => false,
            ];
        } else {
           
            $userData = User::where('id', $params['user_id'])
                ->orderBy('id', 'desc')
                ->first();

            // if($userData->wa_access_token == null){ return ['status'=> false, 'data' => [], 'message'=> 'WhatsApp Access Token not found.']; }
            // $access_token = $userData->wa_access_token;
            // $wa_session = WhatsappSession::where('user_id', $params['user_id'])->orderBy('id', 'desc')
            // ->select('id', 'instance_id', 'user_id', 'status')->first();

            $dataArr = [
                'user_id' => $userData != null ? $userData->id : $params['user_id'],
                // 'wa_session' => $wa_session,
                // 'access_token' => $access_token,
                'customer_id' => $params['customer_id'],
                'mobile' => $params['mobile'],
                'message' => $params['message'],
                'channel_id' => $params['channel_id'],
                'schedule_id' => $params['schedule_id'],
                'type' => $params['type'],
                'status' => true,
            ];
        }

        return $dataArr;
    }

    public function sendSmsMsg($dataArr)
    {
        $postData = [
            'username' => $this->smsusername,
            'password' => $this->smspassword,
            'mobile' => $dataArr['mobile'],
            'sendername' => $this->sendername,
            'message' => $dataArr['message'],
            'routetype' => 1,
        ];

        //init the resource
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $this->smsurl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData,
            //,CURLOPT_FOLLOWLOCATION => true
        ]);

        //Ignore SSL certificate verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        //Get response
        $output = curl_exec($ch);

        //Print error if any
        if (curl_errno($ch)) {
            return curl_error($ch);
        } else {

            /* Customer ID */
            $customer_id = 0;
            $mobile_number = substr($dataArr['mobile'], 2);
            $customer = Customer::where('mobile', $mobile_number)->first();
            if($customer != null){
                $customer_id = $customer->id;
            }

            $offer_id = 'NULL';
            if(isset($dataArr['offer_id'])){
                $offer_id = $dataArr['offer_id'];
            }

            $sms_message = new MessageHistory();
            $sms_message->user_id = $dataArr['user_id'];
            $sms_message->channel_id = $dataArr['channel_id'];
            $sms_message->customer_id = $customer_id;
            $sms_message->mobile = $dataArr['mobile'];
            $sms_message->content = $dataArr['message'];
            $sms_message->sent_via = 'sms';
            $sms_message->status = 0;
            $sms_message->save();

            $messageWallet = MessageWallet::where('user_id', $dataArr['user_id'])
                ->orderBy('id', 'desc')
                ->first();
            $messageWallet->total_messages = $messageWallet->total_messages - 1;
            $messageWallet->save();
        }
        curl_close($ch);
        return $output;
    }

    public function sendWaMessage($scheduleMsg = [], $busCustomer = [])
    {
        // echo "scheduleMsg"; dd($scheduleMsg);
        // echo 'busCustomer';
        // dd($busCustomer);
    }

        /**
     * Resend Failed Wish Messages
     */
    public function resendFailedWishMsg(Request $request)
    {
        if ($request != null) {

            $deductionDetail = DeductionHelper::getActiveDeductionDetail('slug', 'send_sms');

            /* Users with balance */
            $activeUserWithBalance = MessageWallet::with('user')->has('user')->where('wallet_balance', '>', $deductionDetail->amount)->pluck('user_id')->toArray();

            if($activeUserWithBalance == null){
                return response()->json(['status' => false, 'message' => config('constants.payment_alert')]);
            }

            /* Master Switch Check */
            $activeSwitchUser = UserChannel::where('user_id', Auth::id())->where('channel_id', 5)->where('status', 1)->first();

            if($activeSwitchUser == null){
                return response()->json(['status' => false, 'message' => 'Personalised Message Master Switch is disabled.']);
            }

            /* Check SMS routes on for Personalised Message */
            $userWithActiveRoutes = MessageRoute::where('user_id', Auth::id())->where('channel_id', 5)->where('sms', 1)->first();
            
            if($userWithActiveRoutes == null){
                return response()->json(['status' => false, 'message' => 'SMS Route is disabled.']);
            }
            
            /* Get Birthday and Anniversary Message Records */
            $messageSchedules = MessageTemplateSchedule::where('id', $request->scheduleMsgs_id)->where('related_to', 'Personal')->whereNull('scheduled')->where('is_scheduled', 1)->get();
            
            if(!empty($messageSchedules)){
                
                foreach($messageSchedules as $scheduleMsg){
                    
                    /* Business Name */
                    $busniess_name = 'business owner';
                    if(isset($scheduleMsg->getUserDetails->bussiness_detail->business_name)){
                        $busniess_name = $scheduleMsg->getUserDetails->bussiness_detail->business_name;
                        $busniess_name = $busniess_name ?? 'business owner';
                        if (strlen($busniess_name) > 28) {
                            $busniess_name = substr($busniess_name, 0, 28) . '..';
                        }
                    }

                    /* Message */
                    $message = '';
                    if(isset($scheduleMsg->template->message)){
                        $message = $scheduleMsg->template->message;
                        $message = str_replace('[business_name]', $busniess_name, $message);
                        $message = str_replace('{#var#}', $busniess_name, $message);
                    }
                    
                    // DOB
                    if ($scheduleMsg->message_template_category_id == 7) {
                        $userSmsParams = [];
    
                        $type = 'dob';
                        $wishCustomersIds = Wish::where('message_template_schedule_id', $scheduleMsg->id)
                                                ->where('sms_send', 0)
                                                ->select('id','business_customer_id')->get();                 

                        $deductionDetail = DeductionHelper::getActiveDeductionDetail('slug', 'send_sms');
                        $checkWalletBalance = DeductionHelper::checkWalletBalanceWithNoOfPer($scheduleMsg->user_id, $deductionDetail->id ?? 0, count($wishCustomersIds));

                        if ($checkWalletBalance['status']==true) {
                            foreach (@$wishCustomersIds as $cusKey => $wishCustomersId) {

                                $busCustomer = BusinessCustomer::where('id', $wishCustomersId->business_customer_id)->first();

                                if ($busCustomer != null) {
                                    $userSmsParams[] = $this->_setCustomerDetailsForSms($busCustomer, $message, $scheduleMsg, $type, $wishCustomersId->id);
                                }
                            }
                        }
                        
                        if ($userSmsParams != null) {
                            $dataArr = [];
                            foreach ($userSmsParams as $key => $params) {
                                $data = $this->validateWishParams($params);
                                if ($data['status'] == true) {
                                    $dataArr[] = $data;
                                }
                            }
                            // dd($dataArr);
                            dispatch(new SendWishSms($dataArr));

                            return response()->json(['status' => true, 'message' => 'Sent Successfully.']);
                        }
                    }
                    
                    if ($scheduleMsg->message_template_category_id == 8) {
                        $userSmsParams = [];
                        
                        $type = 'aniversary';
                        $wishCustomersIds = Wish::where('message_template_schedule_id', $scheduleMsg->id)
                                                ->where('sms_send', 0)
                                                ->select('id','business_customer_id')->get();                 

                        $deductionDetail = DeductionHelper::getActiveDeductionDetail('slug', 'send_sms');
                        $checkWalletBalance = DeductionHelper::checkWalletBalanceWithNoOfPer($scheduleMsg->user_id, $deductionDetail->id ?? 0, count($wishCustomersIds));

                        if ($checkWalletBalance['status']==true) {
                            foreach (@$wishCustomersIds as $cusKey => $wishCustomersId) {

                                $busCustomer = BusinessCustomer::where('id', $wishCustomersId->business_customer_id)->first();

                                if ($busCustomer != null) {
                                    $userSmsParams[] = $this->_setCustomerDetailsForSms($busCustomer, $message, $scheduleMsg, $type, $wishCustomersId->id);
                                }
                            }
                        }
                        
                        
                        if ($userSmsParams != null) {
                            $dataArr = [];
                            foreach ($userSmsParams as $key => $params) {
                                $data = $this->validateWishParams($params);
                                if ($data['status'] == true) {
                                    $dataArr[] = $data;
                                }
                            }
                            
                            dispatch(new SendWishSms($dataArr));

                            return response()->json(['status' => true, 'message' => 'Sent Successfully.']);
                        }
                    }
                }
                
            }

            return response()->json(['status' => false, 'message' => 'Failed To Resend.']);
            
        }

    }

    /**
     * Resend Failed Messages
     */

    public function resendFailedMsg(Request $request)
    {
        if ($request != null) {
 
            $deductionDetail = DeductionHelper::getActiveDeductionDetail('slug', 'send_sms');

            /* Users with balance */
            $activeUserWithBalance = MessageWallet::with('user')->has('user')->where('wallet_balance', '>', $deductionDetail->amount)->pluck('user_id')->toArray();

            if($activeUserWithBalance == null){
                return response()->json(['status' => false, 'message' => config('constants.payment_alert')]);
            }

            /* Master Switch Check */
            $activeSwitchUser = UserChannel::where('user_id', Auth::id())->where('channel_id', 5)->where('status', 1)->first();

            if($activeSwitchUser == null){
                return response()->json(['status' => false, 'message' => 'Personalised Message Master Switch is disabled.']);
            }

            /* Check SMS routes on for Personalised Message */
            $userWithActiveRoutes = MessageRoute::where('user_id', Auth::id())->where('channel_id', 5)->where('sms', 1)->first();
            
            if($userWithActiveRoutes == null){
                return response()->json(['status' => false, 'message' => 'SMS Route is disabled.']);
            }
             
            /* Get Message Records */
            $messageSchedules = MessageTemplateSchedule::where('id', $request->scheduleMsgs_id)->where('is_scheduled', 1)->get();
             
            
            if(!empty($messageSchedules)){
                 
                foreach($messageSchedules as $scheduleMsg){
                     
                    /* Business Name */
                    $busniess_name = 'business owner';
                    if(isset($scheduleMsg->getUserDetails->bussiness_detail->business_name)){
                        $busniess_name = $scheduleMsg->getUserDetails->bussiness_detail->business_name;
                        $busniess_name = $busniess_name ?? 'business owner';
                        if (strlen($busniess_name) > 28) {
                            $busniess_name = substr($busniess_name, 0, 28) . '..';
                        }
                    }

                    /* Message */
                    $message = '';
                    if(isset($scheduleMsg->template->message)){
                        $message = $scheduleMsg->template->message;
                        $message = str_replace('[business_name]', $busniess_name, $message);
                        $message = str_replace('{#var#}', $busniess_name, $message);
                    }

                    $userSmsParams = [];

                    //Message
                    $type = 'custom';

                    $contactCustomersIds = MessageScheduleContact::where('message_template_schedule_id', $scheduleMsg->id)->where('status', '0')->select('id','customer_id')->get();                 
                    
                    $deductionDetail = DeductionHelper::getActiveDeductionDetail('slug', 'send_sms');
                    $checkWalletBalance = DeductionHelper::checkWalletBalanceWithNoOfPer($scheduleMsg->user_id, $deductionDetail->id ?? 0, count($contactCustomersIds));

                    if ($checkWalletBalance['status']==true) {
                        foreach (@$contactCustomersIds as $cusKey => $contactCustomerId) {

                            $busCustomer = BusinessCustomer::where('user_id', Auth::id())->where('customer_id', $contactCustomerId->customer_id)->first();

                            if ($busCustomer != null) {
                                $userSmsParams[] = $this->_setCustomerContactDetailsForSms($busCustomer, $message, $scheduleMsg, $type, $contactCustomerId->id);
                            }
                        }
                    }
                    
                    if ($userSmsParams != null) {
                        $dataArr = [];
                        foreach ($userSmsParams as $key => $params) {
                            $data = $this->validateContactParams($params);
                            
                            if ($data['status'] == true) {
                                $dataArr[] = $data;
                            }
                        }
                         
                        dispatch(new SendCustomSms($dataArr));

                        return response()->json(['status' => true, 'message' => 'Sent Successfully.']);
                    }
                }
                 
            }
 
            return response()->json(['status' => false, 'message' => 'Failed To Resend.']);
             
        }
 
    }

    /* public function resendFailedMsg(Request $request)
    {
        if ($request != null) {
            $userSmsParams = $userWaParams = [];
            $type = $request->type;
            $date = $request->date;
            $scheduleMsgs_id = $request->scheduleMsgs_id;
            $deductionDetail = DeductionHelper::getActiveDeductionDetail('slug', 'send_sms');
            $scheduleMsg = MessageTemplateSchedule::find($scheduleMsgs_id);
            
            if ($scheduleMsg->getMessageRoute->sms != 1) {
                return response()->json(['status' => false, 'message' => 'Please Activate Personalised Messaging']);
            }
            $busniess_name = 'business owner';
            if(isset($scheduleMsg->getUserDetails->bussiness_detail->business_name)){
                $busniess_name = $scheduleMsg->getUserDetails->bussiness_detail->business_name;
                $busniess_name = $busniess_name ?? 'business owner';
                if (strlen($busniess_name) > 28) {
                    $busniess_name = substr($busniess_name, 0, 28) . '..';
                }
            }
            $message = '';
            if(isset($scheduleMsg->template->message)){
                $message = $scheduleMsg->template->message;
                $message = str_replace('[business_name]', $busniess_name, $message);
                $message = str_replace('{#var#}', $busniess_name, $message);
            }
            if ($type == 'otherMsg' || $type == 'dob' || $type == 'anniversary') {
                
                $checkWalletBalance = DeductionHelper::checkWalletBalance($scheduleMsg->user_id, $deductionDetail->id ?? 0);
                if ($checkWalletBalance['status']==true) {
                    if($type == 'otherMsg')
                        $messageScheduleContact = MessageScheduleContact::where('status','0')->where('message_template_schedule_id',$scheduleMsgs_id)->get();
                    else
                        $messageScheduleContact = Wish::where('sms_send','0')->where('created_at','like',"%".$date."%")->where('message_template_schedule_id',$scheduleMsgs_id)->get();
                    foreach (@$messageScheduleContact as $mKey => $mVal) {
                        if ($mVal != null) {
                            $wishId = ($type == 'otherMsg')?0:$mVal->id;
                            if($type == 'otherMsg')
                                $businessCustomer = BusinessCustomer::where('customer_id', $mVal->customer_id)->where('user_id', $mVal->user_id)->first();
                            else
                                $businessCustomer = BusinessCustomer::find($mVal->business_customer_id);
                            $userSmsParams[] = $this->_setCustomerDetailsForSms($businessCustomer, $message, $scheduleMsg, $type, $wishId);
                        }
                    }
                } else {
                    return response()->json(['status' => false, 'message' => $checkWalletBalance['message']]);
                } 
            }
            if ($userSmsParams != null) {
                $dataArr = [];
                foreach ($userSmsParams as $key => $params) {
                    $data = $this->validateParams($params);
                    $data['cond'] = 'resend';
                    $data['wish_id'] = $params['wish_id'];
                    if ($data['status'] == true) {
                        $dataArr[] = $data;
                    }
                }
                dispatch(new SendSms($dataArr));
            }
            return response()->json(['status' => true, 'message' => 'Successfully Send SMS']);
        }

    } */

    public function viewHistory(Request $request)
    {
        $routes = RouteToggleContoller::routeDetail(5, Auth::id());

        $success = $isProcessing = $failed = 0;

        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        return view('business.personalised-messages.history', compact('notification_list', 'planData', 'routes', 'success', 'isProcessing', 'failed'));
    }

    public function getDobMessagesList(Request $request)
    {
        if ($request->ajax()) {
            $dobMessageHistory = Wish::with('template_message')
                ->where('user_id', Auth::id())
                ->where('message_template_category_id', 7)
                ->orderBy('id', 'DESC')
                ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'), DB::raw('DAY(created_at)'))
                ->get();
            
            $dobMessageHistoryCount = [];
            foreach ($dobMessageHistory as $key => $row) {
                $countDobSms1 = Wish::select(DB::raw('count(*) as count'))
                    ->where('user_id', Auth::id())
                    ->where('sms_send', 1)
                    ->where('message_template_category_id', 7)
                    ->where('sent_via', 'sms')
                    ->whereDate('created_at', $row->created_at)
                    ->first();

                $countDobSms0 = Wish::select(DB::raw('count(*) as count'))
                    ->where('user_id', Auth::id())
                    ->where('sms_send', 0)
                    ->where('message_template_category_id', 7)
                    ->where('sent_via', 'sms')
                    ->whereDate('created_at', $row->created_at)
                    ->first();

                $dobMessageHistoryCount[$row->id]['countDobSms1'] = $countDobSms1;
                $dobMessageHistoryCount[$row->id]['countDobSms0'] = $countDobSms0;
            }

            $busnessDetails = BusinessDetail::where('user_id', Auth::id())->first();

            return Datatables::of($dobMessageHistory)
            ->addIndexColumn()
            ->addColumn('date', function ($q) {
                return Carbon::parse($q->created_at)->format('j M, Y');
            })
            ->addColumn('status', function ($q) use ($dobMessageHistoryCount){
                return (empty($dobMessageHistoryCount[$q->id]['countDobSms1']->count))?'<div class="badge badge-danger">Failed</div>':'<div class="badge badge-success">Success</div>';
            })
            ->addColumn('message', function ($q) use($busnessDetails) {
                $busniess_name = $busnessDetails->business_name;
                $message = $q->template_message->message;
                $message = str_replace('[business_name]', $busniess_name, $message);
                $message = str_replace('{#var#}', $busniess_name, $message);
                return '<div class="p-2 comment more">'.$message.'</div>';
            })
            ->addColumn('action', function ($q) {
                return '<a class="btn btn-warning"
                href="'.route('business.channel.personalisedMessage.dobMessages', $q->id).'">'.__('View Contact').'</a>';
            })
            ->addColumn('details', function ($q) use($dobMessageHistoryCount) {
                $date = $q->created_at->format('Y-m-d');
                return '<a class="btn btn-primary" data-content="#birthday_content_'.$q->id.'" data-toggle="canvas" href="#bs-canvas-right" aria-expanded="false" aria-controls="bs-canvas-right" role="button">View Details</a>
                <div  class="d-none" id="birthday_content_'.$q->id.'">
                    <div class="customer-details">
                        <!-- Message Status table-->
                        <div class="msg-status-table mt-5">
                            <h6 class="mb-3 text-primary">Sent Message Status</h6>
                            <table class="table table-borderless">
                                <thead>
                                <tr>
                                    <th>Routes</th>
                                    <th>Success</th>
                                    <th>Failed</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>SMS</td>
                                        <td class="text-success">'. ($dobMessageHistoryCount[$q->id]['countDobSms1']->count ?? "0").'</td>
                                        <td class="text-danger">'. ($dobMessageHistoryCount[$q->id]['countDobSms0']->count ?? "0").'</td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                            '.
                            ((!empty($dobMessageHistoryCount[$q->id]['countDobSms0']->count))?"<div class=\"text-danger\" onclick = \"resendMsg('$q->message_template_schedule_id','dob','$date')\">
                            <button class = 'btn border border-primary'>Resend SMS</button></div>":"")
                            .'
                        </div>
                    </div>
                </div>';
            })
            ->escapeColumns([])
            ->make(true);
        }
    }

    public function getAnniMessagesList(Request $request)
    {
        if ($request->ajax()) {
            $anniversaryMessageHistory = Wish::with('template_message')
                ->where('user_id', Auth::id())
                ->where('message_template_category_id', 8)
                ->orderBy('id', 'DESC')
                ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'), DB::raw('DAY(created_at)'))
                ->get();
            
            $anniversaryMessageHistoryCount = [];
            foreach ($anniversaryMessageHistory as $key => $row) {
                $countAnniversarySms1 = Wish::select(DB::raw('count(*) as count'))
                    ->where('user_id', Auth::id())
                    ->where('sms_send', 1)
                    ->where('message_template_category_id', 8)
                    ->where('sent_via', 'sms')
                    ->whereDate('created_at', $row->created_at)
                    ->first();

                $countAnniversarySms0 = Wish::select(DB::raw('count(*) as count'))
                    ->where('user_id', Auth::id())
                    ->where('sms_send', 0)
                    ->where('message_template_category_id', 8)
                    ->where('sent_via', 'sms')
                    ->whereDate('created_at', $row->created_at)
                    ->first();

                $anniversaryMessageHistoryCount[$row->id]['countAnniversarySms1'] = $countAnniversarySms1;
                $anniversaryMessageHistoryCount[$row->id]['countAnniversarySms0'] = $countAnniversarySms0;
            }

            $busnessDetails = BusinessDetail::where('user_id', Auth::id())->first();

            return Datatables::of($anniversaryMessageHistory)
            ->addIndexColumn()
            ->addColumn('date', function ($q) {
                return Carbon::parse($q->created_at)->format('j M, Y');
            })
            ->addColumn('status', function ($q) use($anniversaryMessageHistoryCount){
                return (empty($anniversaryMessageHistoryCount[$q->id]['countAnniversarySms1']->count))?'<div class="badge badge-danger">Failed</div>':'<div class="badge badge-success">Success</div>';
            })
            ->addColumn('message', function ($q) use($busnessDetails) {
                $busniess_name = $busnessDetails->business_name;
                $message = $q->template_message->message;
                $message = str_replace('[business_name]', $busniess_name, $message);
                $message = str_replace('{#var#}', $busniess_name, $message);
                return '<div class="p-2 comment more">'.$message.'</div>';
            })
            ->addColumn('action', function ($q) {
                return '<a class="btn btn-warning"
                href="'.route('business.channel.personalisedMessage.anniMessages', $q->id).'">'.__('View Contact').'</a>';
            })
            ->addColumn('details', function ($q) use($anniversaryMessageHistoryCount) {
                $date = $q->created_at->format('Y-m-d');
                return '<a class="btn btn-primary" data-content="#anniversary_content_'.$q->id.'" data-toggle="canvas" href="#bs-canvas-right" aria-expanded="false" aria-controls="bs-canvas-right" role="button">View Details</a>
                <div  class="d-none" id="anniversary_content_'.$q->id.'">
                    <div class="customer-details">
                        <div class="msg-status-table mt-5">
                            <h6 class="mb-3 text-primary">Sent Message Status</h6>
                            <table class="table table-borderless">
                                <thead>
                                <tr>
                                    <th>Routes</th>
                                    <th>Success</th>
                                    <th>Failed</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>SMS</td>
                                        <td class="text-success">'. ($anniversaryMessageHistoryCount[$q->id]['countAnniversarySms1']->count ?? "0").'</td>
                                        <td class="text-danger">'. ($anniversaryMessageHistoryCount[$q->id]['countAnniversarySms0']->count ?? "0").'</td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                            '.
                            ((!empty($anniversaryMessageHistoryCount[$q->id]['countAnniversarySms0']->count))?"<div class=\"text-danger\" onclick = \"resendMsg('$q->message_template_schedule_id','anniversary','$date')\">
                            <button class = 'btn border border-primary'>Resend SMS</button></div>":"")
                            .'
                        </div>
                    </div>
                </div>';
            })
            ->escapeColumns([])
            ->make(true);
        }
    }

    public function getFestMessagesList(Request $request)
    {
        if ($request->ajax()) {
            $time_slot_ids = TimeSlot::where('value', '<', date("H:i:s"))->pluck('id')->toArray();

        // Customized Msg History

            $whereConditions = [
                ['message_template_schedules.user_id', '=', Auth::id()],
                ['message_template_schedules.related_to', '=', 'Festival'],
                ['message_template_schedules.channel_id', '=', 5],
                ['message_template_schedules.scheduled', '<', Carbon::now()->format('Y-m-d')],
            ];

            $orWhereConditions = [
                ['message_template_schedules.related_to', '=', 'Festival'],
                ['message_template_schedules.user_id', '=', Auth::id()],
                ['message_template_schedules.channel_id', '=', 5],
                ['message_template_schedules.scheduled', '=', Carbon::now()->format('Y-m-d')],
            ];
            
            $msgHistorylist = MessageTemplateSchedule::with('template')->withCount('contacts')
                ->leftjoin('time_slots', 'message_template_schedules.time_slot_id', '=', 'time_slots.id')
                ->whereNotIn('message_template_schedules.message_template_category_id', [7, 8])
                ->whereIn('message_template_schedules.related_to', ['Festival'])
                ->where($whereConditions)
                ->orWhere(function($query) use ($time_slot_ids, $orWhereConditions) {
                    $query->where($orWhereConditions)
                        ->whereIn('message_template_schedules.time_slot_id', $time_slot_ids);
                })  
                ->orderBy('message_template_schedules.scheduled', 'DESC')
                ->orderBy('time_slots.id', 'DESC')
                ->get();
                
            $contact_grps = [];
            foreach ($msgHistorylist as $msg) {
                $grpIds = explode(',', $msg->groups_id);
                $contact_groups = ContactGroup::withCount('customers')
                ->whereIn('id', $grpIds)
                ->get();
                $contact_grps[$msg->id] = $contact_groups;
                
            }

            $msgHistorylistCount = [];
            foreach ($msgHistorylist as $key => $row) {
                $countMesgSms1 = MessageScheduleContact::select(DB::raw('count(*) as count'))
                                                                ->where('user_id', Auth::id())
                                                                ->where('message_template_schedule_id', $row->id)
                                                                ->where('status', '1')
                                                                ->first();

                $countMesgSms0 = MessageScheduleContact::select(DB::raw('count(*) as count'))
                                                                    ->where('user_id', Auth::id())
                                                                    ->where('message_template_schedule_id', $row->id)
                                                                    ->where('status', '0')
                                                                    ->first();

                $msgHistorylistCount[$row->id]['countMesgSms1'] = $countMesgSms1;
                $msgHistorylistCount[$row->id]['countMesgSms0'] = $countMesgSms0;
            }

            $busnessDetails = BusinessDetail::where('user_id', Auth::id())->first();

            return Datatables::of($msgHistorylist)
            ->addIndexColumn()
            ->addColumn('date', function ($q) {
                $date = Carbon::parse($q->scheduled)->format('j M, Y');
                if($q->getTimeSlot != NULL){
                    $date .= '|'. Carbon::parse($q->getTimeSlot->value)->format('h:i A');
                }
                return $date;
            })
            ->addColumn('status', function ($q) use ($msgHistorylistCount) {
                if ($msgHistorylistCount[$q->id]['countMesgSms1']->count > 0){
                    return '<div class="badge badge-success">
                        Success
                    </div>';
                }else{
                    return '<div class="badge badge-danger">
                        Failed
                    </div>';
                }
            })
            ->addColumn('message', function ($q) use($busnessDetails) {
                $busniess_name = $busnessDetails->business_name;
                $message = $q->template->message;
                $message = str_replace('[business_name]', $busniess_name, $message);
                $message = str_replace('{#var#}', $busniess_name, $message);
                return '<div class="p-2 comment more">'.$message.'</div>';
            })
            ->addColumn('action', function ($q) {
                return '<a class="btn btn-warning"
                href="'.route('business.channel.personalisedMessage.showMessages', $q->id).'">'.__('View Contact').'</a>';
            })
            ->addColumn('details', function ($q) use($contact_grps, $msgHistorylistCount) {
                $append = "";

                foreach ($contact_grps[$q->id] as $grp){
                    $append .= '<tr>
                        <td>'.$grp->name.'</td>
                        <td><span class="badge badge-primary">'. $grp->customers_count.'</span></td>
                    </tr>';
                }


                return '<a class="btn btn-primary" data-content="#content_'.$q->id.'" data-toggle="canvas" href="#bs-canvas-right" aria-expanded="false" aria-controls="bs-canvas-right" role="button">View Details</a>
                <div  class="d-none" id="content_'.$q->id.'">
                    <div class="customer-details">
                        <div class="contact-grp-table">
                            <h6 class="mb-3 text-primary">Contact Groups</h6>
                            <table class="table table-borderless border_ tab-rounded_">
                                <tbody>'.$append.'
                                    
                                </tbody>
                            
                            </table>
                        </div>
        
                        <div class="msg-status-table mt-5">
                            <h6 class="mb-3 text-primary">Sent Message Status</h6>
                            <table class="table table-borderless">
                                <thead>
                                <tr>
                                    <th>Routes</th>
                                    <th>Success</th>
                                    <th>Failed</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>SMS</td>
                                        <td class="text-success">'. ($msgHistorylistCount[$q->id]['countMesgSms1']->count ?? "0").'</td>
                                        <td class="text-danger">'. ($msgHistorylistCount[$q->id]['countMesgSms0']->count ?? "0").'</td>
                                    </tr>
                                </tbody>
                            </table>
                            '.
                            (($msgHistorylistCount[$q->id]['countMesgSms0']->count > 0)?"<div class=\"text-danger\" onclick = \"resendMsg('$q->id','otherMsg','')\">
                            <button class = 'btn border border-primary'>Resend SMS</button></div>":"")
                            .'
                        </div>
                    </div>
                </div>';
            })
            ->escapeColumns([])
            ->make(true);
        }
    }

    public function getCustMessagesList(Request $request)
    {
        if ($request->ajax()) {
            $time_slot_ids = TimeSlot::where('value', '<', date("H:i:s"))->pluck('id')->toArray();

        // Customized Msg History

            $whereConditions = [
                ['message_template_schedules.user_id', '=', Auth::id()],
                ['message_template_schedules.related_to', '=', 'Custom'],
                ['message_template_schedules.channel_id', '=', 5],
                ['message_template_schedules.scheduled', '<', Carbon::now()->format('Y-m-d')],
            ];

            $orWhereConditions = [
                ['message_template_schedules.user_id', '=', Auth::id()],
                ['message_template_schedules.related_to', '=', 'Custom'],
                ['message_template_schedules.channel_id', '=', 5],
                ['message_template_schedules.scheduled', '=', Carbon::now()->format('Y-m-d')],
            ];
            
            $msgHistorylist = MessageTemplateSchedule::with('template')->withCount('contacts')
                ->leftjoin('time_slots', 'message_template_schedules.time_slot_id', '=', 'time_slots.id')
                ->whereNotIn('message_template_schedules.message_template_category_id', [7, 8])
                ->whereIn('message_template_schedules.related_to', ['Custom'])
                ->where($whereConditions)
                ->orWhere(function($query) use ($time_slot_ids, $orWhereConditions) {
                    $query->where($orWhereConditions)
                        ->whereIn('message_template_schedules.time_slot_id', $time_slot_ids);
                })  
                ->orderBy('message_template_schedules.scheduled', 'DESC')
                ->orderBy('time_slots.id', 'DESC')
                ->get();
                
            $contact_grps = [];
            foreach ($msgHistorylist as $msg) {
                $grpIds = explode(',', $msg->groups_id);
                $contact_groups = ContactGroup::withCount('customers')
                ->whereIn('id', $grpIds)
                ->get();
                $contact_grps[$msg->id] = $contact_groups;
                
            }
            
            $msgHistorylistCount = [];
            foreach ($msgHistorylist as $key => $row) {
                $countMesgSms1 = MessageScheduleContact::select(DB::raw('count(*) as count'))
                                                                ->where('user_id', Auth::id())
                                                                ->where('message_template_schedule_id', $row->id)
                                                                ->where('status', '1')
                                                                ->first();

                $countMesgSms0 = MessageScheduleContact::select(DB::raw('count(*) as count'))
                                                                    ->where('user_id', Auth::id())
                                                                    ->where('message_template_schedule_id', $row->id)
                                                                    ->where('status', '0')
                                                                    ->first();

                $msgHistorylistCount[$row->id]['countMesgSms1'] = $countMesgSms1;
                $msgHistorylistCount[$row->id]['countMesgSms0'] = $countMesgSms0;
            }

            $busnessDetails = BusinessDetail::where('user_id', Auth::id())->first();

            return Datatables::of($msgHistorylist)
            ->addIndexColumn()
            ->addColumn('date', function ($q) {
                $date = Carbon::parse($q->scheduled)->format('j M, Y');
                if($q->getTimeSlot != NULL){
                    $date .= '|'. Carbon::parse($q->getTimeSlot->value)->format('h:i A');
                }
                return $date;
            })
            ->addColumn('status', function ($q) use ($msgHistorylistCount) {
            
                if ($msgHistorylistCount[$q->id]['countMesgSms1']->count > 0){
                    return '<div class="badge badge-success">
                        Success
                    </div>';
                }else{
                    return '<div class="badge badge-danger">
                        Failed
                    </div>';
                }
            })
            ->addColumn('message', function ($q) use($busnessDetails) {
                $busniess_name = $busnessDetails->business_name;
                $message = $q->template->message;
                $message = str_replace('[business_name]', $busniess_name, $message);
                $message = str_replace('{#var#}', $busniess_name, $message);
                return '<div class="p-2 comment more">'.$message.'</div>';
            })
            ->addColumn('action', function ($q) {
                return '<a class="btn btn-warning"
                href="'.route('business.channel.personalisedMessage.showMessages', $q->id).'">'.__('View Contact').'</a>';
            })
            ->addColumn('details', function ($q) use($contact_grps, $msgHistorylistCount) {
                $append = "";

                foreach ($contact_grps[$q->id] as $grp){
                    $append .= '<tr>
                        <td>'.$grp->name.'</td>
                        <td><span class="badge badge-primary">'. $grp->customers_count.'</span></td>
                    </tr>';
                }


                return '<a class="btn btn-primary" data-content="#content_'.$q->id.'" data-toggle="canvas" href="#bs-canvas-right" aria-expanded="false" aria-controls="bs-canvas-right" role="button">View Details</a>
                <div  class="d-none" id="content_'.$q->id.'">
                    <div class="customer-details">
                        <div class="contact-grp-table">
                            <h6 class="mb-3 text-primary">Contact Groups</h6>
                            <table class="table table-borderless border_ tab-rounded_">
                                <tbody>'.$append.'
                                    
                                </tbody>
                            
                            </table>
                        </div>
        
                        <div class="msg-status-table mt-5">
                            <h6 class="mb-3 text-primary">Sent Message Status</h6>
                            <table class="table table-borderless">
                                <thead>
                                <tr>
                                    <th>Routes</th>
                                    <th>Success</th>
                                    <th>Failed</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>SMS</td>
                                        <td class="text-success">'. ($msgHistorylistCount[$q->id]['countMesgSms1']->count ?? "0").'</td>
                                        <td class="text-danger">'. ($msgHistorylistCount[$q->id]['countMesgSms0']->count ?? "0").'</td>
                                    </tr>
                                </tbody>
                            </table>
                            '.
                            (($msgHistorylistCount[$q->id]['countMesgSms0']->count > 0)?"<div class=\"text-danger\" onclick = \"resendMsg('$q->id','otherMsg','')\">
                            <button class = 'btn border border-primary'>Resend SMS</button></div>":"")
                            .'
                        </div>
                    </div>
                </div>';
            })
            ->escapeColumns([])
            ->make(true);
        }
    }

    public function showMessages(Request $request, $id)
    {

        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        return view('business.personalised-messages.show-custom-messages', compact('notification_list', 'planData','id'));
    }

    public function getCustomMessageList(Request $request)
    {
        if ($request->ajax()) {
            $customer_sms = [];
            $msgHistorylist = MessageTemplateSchedule::find($request->id);
            $customer_sms = MessageScheduleContact::where('message_template_schedule_id',$request->id)
                ->where('user_id',auth()->user()->id)
                ->pluck('customer_id')
                ->toArray();
                
            $smsCustomer = BusinessCustomer::with('buCustomerInfo')
                ->whereIn('customer_id', $customer_sms)
                ->where('user_id', Auth::id())
                ->groupBy('customer_id')
                ->select('customer_id', 'name')
                ->orderBy('name', 'ASC')
                ->get();
            
            return Datatables::of($smsCustomer)
            ->addIndexColumn()
            ->addColumn('number', function ($q) {
                return $q->buCustomerInfo->mobile;
            })
            ->addColumn('name', function ($q) {
                return $q->name;
            })
            ->addColumn('date', function ($q) use($msgHistorylist) {
                return Carbon::parse($msgHistorylist->scheduled)->format("j M, Y");
            })
            ->addColumn('status', function ($q) use($msgHistorylist) {
                $scheduleContact = $q->buCustomerInfo->getCustScheduleContact->where("message_template_schedule_id",$msgHistorylist->id);
                foreach($scheduleContact as $key => $val)
                { 
                    return (empty($val->status))?"<div class='text-danger'>Failed</div>":"<div class='text-success'>Sent</div>";
                }
            })
            ->escapeColumns([])
            ->make(true);
        }
    }

    public function getAnniversaryMessageList(Request $request)
    {
        if ($request->ajax()) {
            $wish = Wish::find($request->id);
            
            /* SMS */
            $business_customer_id_sms_anni = Wish::where('user_id', Auth::id())
                                                    ->where('message_template_schedule_id', $wish->message_template_schedule_id)
                                                    ->where('template_id', $wish->template_id)
                                                    ->where('sent_via', 'sms')
                                                    ->whereDate('created_at', date("Y-m-d", strtotime($wish->created_at)))
                                                    ->pluck('business_customer_id')
                                                    ->toArray();

            /* Whatsapp */
            $customer_id_sms_anni = BusinessCustomer::with('wishBuCustomerInfo')
                                                    ->whereIn('id', $business_customer_id_sms_anni)
                                                    ->where('user_id', Auth::id())
                                                    ->select('id', 'customer_id', 'name', 'anniversary_date')
                                                    ->orderBy('name', 'ASC')
                                                    ->get();
                                                    
            return Datatables::of($customer_id_sms_anni)
            ->addIndexColumn()
            ->addColumn('number', function ($q) {
                return $q->buCustomerInfo->mobile;
            })
            ->addColumn('name', function ($q) {
                return $q->name;
            })
            ->addColumn('date', function ($q) {
                return $q->anniversary_date;
            })
            ->addColumn('status', function ($q) {
                return (empty($q->wishBuCustomerInfo[0]->sms_send))?"<div class='text-danger'>Failed</div>":"<div class='text-success'>Sent</div>";
            })
            ->escapeColumns([])
            ->make(true);
        }
    }

    public function getBirthdayMessageList(Request $request)
    {
        if ($request->ajax()) {
            $wish = Wish::find($request->id);
            
            /* SMS */
            $business_customer_id_sms = Wish::where('user_id', Auth::id())
                                        ->where('message_template_schedule_id', $wish->message_template_schedule_id)
                                        ->where('sent_via', 'sms')
                                        ->where('template_id', $wish->template_id)
                                        ->whereDate('created_at', date("Y-m-d", strtotime($wish->created_at)))
                                        ->pluck('business_customer_id')
                                        ->toArray();
            
            $customer_id_sms = BusinessCustomer::with('wishBuCustomerInfo')
                                            ->whereIn('id', $business_customer_id_sms)
                                            ->where('user_id', Auth::id())
                                            ->select('id', 'customer_id', 'name', 'dob')
                                            ->orderBy('name', 'ASC')
                                            ->get();
            
            return Datatables::of($customer_id_sms)
            ->addIndexColumn()
            ->addColumn('number', function ($q) {
                return $q->buCustomerInfo->mobile;
            })
            ->addColumn('name', function ($q) {
                return $q->name ?? '-';
            })
            ->addColumn('date', function ($q) {
                return $q->dob;
            })
            ->addColumn('status', function ($q) {
                return (empty($q->wishBuCustomerInfo[0]->sms_send))?"<div class='text-danger'>Failed</div>":"<div class='text-success'>Sent</div>";
            })
            ->escapeColumns([])
            ->make(true);
        }
    }

    public function dobMessages(Request $request, $id)
    {

        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        return view('business.personalised-messages.show-dob-messages', compact('notification_list', 'planData','id'));
    }

    public function anniMessages(Request $request, $id)
    {

        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        return view('business.personalised-messages.show-anni-messages', compact( 'notification_list', 'planData','id'));
    }

    public function setTimeStamp(Request $request)
    {
        // No of person set same datetime
        $noOfPerson = 100;
        $slots_array = array();
        if($request->selectDate){
            $timeSlots = TimeSlot::where('status', 1)->get();
            
            foreach($timeSlots as $slot){
                $messageTemplateSchedule = MessageTemplateSchedule::whereDate('scheduled', Carbon::parse($request->selectDate)->format('Y-m-d'))->where('time_slot_id', $slot->id)->count();
                
                $isDisabled = $messageTemplateSchedule >= $noOfPerson ? true : false;
                $opt = array(
                    'value' => $slot->id,
                    'label' => Carbon::parse($slot->value)->format('h:i A'),
                    'disabled' => $isDisabled
                );
                array_push($slots_array, $opt);
            }
        }

        return response()->json(['status' => true, 'data' => $slots_array]);
    }

    public function getPersonalisedMsgInfo(Request $request)
    {
        
        $checkPersonalisedTempDates = MessageTemplateSchedule::where('user_id', Auth::id())
                    ->whereNotIN('message_template_category_id', [7, 8])
                    ->where('scheduled', '>=', Carbon::now()->format('Y-m-d H:i:s'))
                    ->where('id', "!=", $request->editTempId)
                    ->get();
        $usedDates = [];
        if($checkPersonalisedTempDates){
            foreach ($checkPersonalisedTempDates as $message) {
                $usedDates[] = Carbon::parse($message->scheduled)->format('j-n-Y');
            }
        }
        return response()->json(['status' => true, 'dates' => $usedDates]);
    }
    public function getFestivalMsgInfo(Request $request)
    {
        $checkPersonalisedTempDates = MessageTemplateSchedule::where('user_id', Auth::id())
                    ->whereNotIN('message_template_category_id', [7, 8])
                    ->where('scheduled', '>=', Carbon::now()->format('Y-m-d H:i:s'))
                    ->where('id', "!=", $request->editTempIdFestival)
                    ->get();
        $usedDates = [];
        if($checkPersonalisedTempDates){
            foreach ($checkPersonalisedTempDates as $message) {
                $usedDates[] = Carbon::parse($message->scheduled)->format('j-n-Y');
            }
        }
        return response()->json(['status' => true, 'dates' => $usedDates]);
    }

    public function viewPersonalisedMsg(Request $request)
    {
        $json=[];
        if($request->temp_id){
            $data=[];
            $checkPersonalisedTempDates = MessageTemplateSchedule::find($request->temp_id);
            if($checkPersonalisedTempDates!=NULL){
                
                $date = Carbon::parse($checkPersonalisedTempDates->scheduled)->format('d M, Y');
                $time="";
                if($checkPersonalisedTempDates->getTimeSlot!=NULL){
                    $time = Carbon::parse($checkPersonalisedTempDates->getTimeSlot->value)->format('h:i A');
                }

                $busniess_name = $checkPersonalisedTempDates->getUserDetails->bussiness_detail->business_name;
                $busniess_name = $busniess_name ?? 'business owner';
                if (strlen($busniess_name) > 28) {
                    $busniess_name = substr($busniess_name, 0, 28) . '..';
                }

                $message = $checkPersonalisedTempDates->template->message;
                $message = str_replace('[business_name]', $busniess_name, $message);
                $message = str_replace('{#var#}', $busniess_name, $message);
                
                $contacts = explode(',', $checkPersonalisedTempDates->groups_id);
                $contact_grps_data=[];
                if(count($contacts) > 0){
                    $contact_grps = ContactGroup::with('customers')->whereIn('id', $contacts)->get();
                    if($contact_grps){
                        foreach ($contact_grps as $key => $grp) {
                            $contact['name'] = $grp->name;
                            $contact['cust_count'] = count($grp->customers);
                            $contact_grps_data[] = $contact;
                        }
                    }
                }
                
                $data=[
                    'date' => $date.' | '.$time,
                    'title' => $checkPersonalisedTempDates->template->category->name ?? "",
                    'message' => $message ? nl2br($message) : "",
                    'contact_grps_data' => $contact_grps_data
                ];
    
                $json=['status' => true, 'message' => 'Message found', 'data' => $data];
            }
            else{
                $json=['status'=>false, 'message'=>'Message not found!' ];
            }
        }
        else{
            $json=['status'=>false, 'message'=>'Message not found!' ];
        }
        return response()->json($json);
    }

    public function getOfferDetails(Request $request)
    {
        $offerDeatils = Offer::where('id', $request->offer_id)->first();
        return response()->json(['status' => true,'offerDeatils'=>$offerDeatils]);
    }

    public function shareOffer(Request $request){

        $userBalance = DeductionHelper::getUserWalletBalance(Auth::id());
        $userData=User::where('id',Auth::id())->first();

        if($userData->current_account_status=='free'){
            return response()->json(['status' => false, 'message' => config('constants.payment_alert')]);
        }

        if($userData->current_account_status=='paid' && $userBalance['wallet_balance'] <= 0){
            
              return response()->json(['status' => false, 'message' => config('constants.payment_alert')]);
            
        }

        $businessDetail = BusinessDetail::where('user_id', Auth::id())->first();

        $businessDetail->share_offer_scheduled_date = date('Y-m-d',strtotime($request->start_date));
        $businessDetail->selected_groups = isset($request->groups_id) ? implode(',', $request->groups_id) : '';
        $businessDetail->save();

        return response()->json(['status' => true,'message'=>'Share Offer Schedule Set successfully.']);
    }

    public function shareOfferSendEnable(Request $request){
        $businessDetail = BusinessDetail::where('user_id', Auth::id())->first();
        if($request->is_checked=='true'){
            $send_when_start='1';
            $message='Share Offer Message Enabled successfully.';
        }else{
            $send_when_start='0';
            $message='Share Offer Message Disabled successfully.';
        }
        $businessDetail->send_when_start = $send_when_start;
        $businessDetail->save();

        return response()->json(['status' => true,'message' => $message]);
    }

    public function getOfrMessagesList(Request $request)
    {
        if ($request->ajax()) {

        // Customized Msg History
            $whereConditions = [
                ['share_challenge_contacts.user_id', '=', Auth::id()],
            ];
            
            $msgHistorylist = ShareChallengeContact::where($whereConditions)
                                                    ->orderBy('share_challenge_contacts.id', 'DESC')
                                                    ->groupBy('share_challenge_contacts.offer_id')
                                                    ->get();

            //dd($msgHistorylist);
            $msgHistorylistCount = [];
            foreach ($msgHistorylist as $key => $row) {
                $countShareSms1 = ShareChallengeContact::select(DB::raw('count(*) as count'))
                                                        ->where('offer_id', $row->offer_id)
                                                        ->where('user_id', Auth::id())
                                                        ->where('status','=',1)
                                                        ->first();

                $countShareSms0 = ShareChallengeContact::select(DB::raw('count(*) as count'))
                                                        ->where('offer_id', $row->offer_id)
                                                        ->where('user_id', Auth::id())
                                                        ->where('status',0)
                                                        ->first();

                $msgHistorylistCount[$row->id]['countShareSms1'] = $countShareSms1;
                $msgHistorylistCount[$row->id]['countShareSms0'] = $countShareSms0;
            }

            $busnessDetails = BusinessDetail::where('user_id', Auth::id())->first();

            return Datatables::of($msgHistorylist)
                                ->addIndexColumn()
                                ->addColumn('date', function ($q) {
                                    $date = Carbon::parse($q->created_at)->format('j M, Y');
                                    return $date;
                                })
                                ->addColumn('status', function ($q) {

                                    if($q->status == 1){
                                        return '<div class="badge badge-success">
                                            Success
                                        </div>';
                                    }else{
                                            return '<div class="badge badge-danger">
                                                Failed
                                            </div>';
                                    }
                                })
                                ->addColumn('offer_title', function ($q) {
                                    $offerDeatils = Offer::where('id', $q->offer_id)->first();
                                    $message = $offerDeatils->title;
                                    return '<div class="p-2 comment more">'.$message.'</div>';
                                })
                                ->addColumn('action', function ($q) {
                                    return '<a class="btn btn-warning"
                                    href="'.route('business.channel.personalisedMessage.showOfrMessages', $q->offer_id).'">'.__('View Contact').'</a>';
                                })
                                ->addColumn('details', function ($q) use($msgHistorylistCount) {
                                    $date = $q->created_at->format('Y-m-d');
                                    if($msgHistorylistCount[$q->id]['countShareSms0']->count==0){
                                        $failedcount="0";
                                    }else{
                                    $failedcount=$msgHistorylistCount[$q->id]['countShareSms0']->count; 
                                    }

                                    if($msgHistorylistCount[$q->id]['countShareSms1']->count==0){
                                        $succeescount="0";
                                    }else{
                                    $succeescount=$msgHistorylistCount[$q->id]['countShareSms1']->count; 
                                    }

                                    return '<a class="btn btn-primary" data-content="#offer_content_'.$q->id.'" data-toggle="canvas" href="#bs-canvas-right" aria-expanded="false" aria-controls="bs-canvas-right" role="button">View Details</a>
                                    <div  class="d-none" id="offer_content_'.$q->id.'">
                                        <div class="customer-details">
                                            <div class="msg-status-table mt-5">
                                                <h6 class="mb-3 text-primary">Sent Message Status</h6>
                                                <table class="table table-borderless">
                                                    <thead>
                                                    <tr>
                                                        <th>Routes</th>
                                                        <th>Success</th>
                                                        <th>Failed</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>SMS</td>
                                                            <td class="text-success">'.$succeescount.'</td>
                                                            <td class="text-danger">'.$failedcount.'</td>
                                                        </tr>  
                                                    </tbody>
                                                </table>
                                                '.
                                                ((!empty($msgHistorylistCount[$q->id]['countShareSms0']->count))?"<div class=\"text-danger\" onclick = \"resendFailedOfferMsg('$q->offer_id','$date')\">
                                                <button class = 'btn border border-primary'>Resend SMS</button></div>":"")
                                                .'
                                            </div>
                                        </div>
                                    </div>';
                                })
                                ->escapeColumns([])
                                ->make(true);
        }
    }

    public function showOfrMessages(Request $request, $id)
    {

        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        return view('business.personalised-messages.show-offer-messages', compact('notification_list', 'planData','id'));
    }


    public function getOfferMessageList(Request $request){
            
            $msgHistorylist = ShareChallengeContact::where('share_challenge_contacts.user_id', Auth::id())
                ->where('offer_id',$request->id)
                ->orderBy('share_challenge_contacts.id', 'DESC')
                ->get();

            return Datatables::of($msgHistorylist)
            ->addIndexColumn()
            ->addColumn('number', function ($q) {
                $custdet=Customer::where('id',$q->customer_id)->first();
                $number = $custdet->mobile;
                return $number;
            })
            ->addColumn('name', function ($q) {
                $bucustdet=BusinessCustomer::where('customer_id',$q->customer_id)
                ->where('user_id',Auth::id())
                ->first();
                $name = $bucustdet->name;
                return $name;
            })
            ->addColumn('date', function ($q) {
                $date = Carbon::parse($q->created_at)->format('j M, Y');
                return $date;
            })
            ->addColumn('status', function ($q) {
                if($q->status==1){
                        return "<div class='text-success'>Sent</div>";
                    }else{
                        return "<div class='text-danger'>Failed</div>";
                    }
            })
            ->escapeColumns([])
            ->make(true);

    }

    public static function setOfferContactHistory($user_id, $customer_id, $offer_id, $ShareChallengeContactstatus)
    {
        $contactmsg = new ShareChallengeContact;
        $contactmsg->user_id = $user_id;
        $contactmsg->customer_id = $customer_id;
        $contactmsg->offer_id = $offer_id;
        $contactmsg->status = $ShareChallengeContactstatus;
        $contactmsg->save();
        return $contactmsg->id;
    }

    /**
     * Resend Failed Offer Messages
     */
    // public function resendFailedOfferMsg(Request $request)
    // {
    //     if ($request != null) {

    //         $date = $request->date;
    //         $offer_id = $request->offer_id;
    //         $userChannel = UserChannel::where('user_id', Auth::id())->where('channel_id', 5)->first();
    //         $route = UserChannel::where('user_id', Auth::id())->where('channel_id', 5)->first();
            
    //         if ($userChannel->status == 0) {
    //             return response()->json(['status' => false, 'message' => 'Please Activate Personalised Messaging']);
    //         }

    //         if ($route->sms == 0) {
    //             return response()->json(['status' => false, 'message' => 'Route not active']);
    //         }else{
    //             $checkWalletBalance = DeductionHelper::checkWalletBalanceWithChannel(Auth::id(), 5, ['send_sms']);
    //                 if($checkWalletBalance['status'] != true){
    //                     return response()->json(["status" => $checkWalletBalance['status'], "message" => 'Low']);
    //                 }
    //         }
    //         $offer=Offer::where('id',$offer_id)
    //                 ->where('user_id', Auth::id())
    //                 ->where('start_date', '<=', date('Y-m-d'))
    //                 ->where('end_date', '>=', date('Y-m-d'))->first();
    //         if($offer!=null){
    //             $ShareChallengeContacts=ShareChallengeContact::where('offer_id',$offer_id)->where('status','=',0)->whereDate('created_at',$date)->get();

    //             foreach ($ShareChallengeContacts as $ShareChallengeContact) {
    //                 $subscription = OfferSubscription::where('user_id', $offer->user_id)->where('offer_id', $offer->id)->where('channel_id', 3)->where('customer_id', $ShareChallengeContact->customer_id)->where('status','1')->first();
    //                 $checkWalletBalance = DeductionHelper::checkWalletBalanceWithChannel($offer->user_id, 3, ['send_sms', 'send_whatsapp', 'share_challenge_subscription']);
    //                 if($subscription == '' && $checkWalletBalance['status'] == true){
    //                     $type = 'future';
    //                     $randomString = UuidTokenController::eightCharacterUniqueToken(8);
    //                     $addedCharacter = UuidTokenController::addCharacter($type, $randomString);
    //                     $tokenData = UuidTokenController::findUniqueToken($type,$addedCharacter);
                    
    //                     if($tokenData['status'] == true){
    //                         $tokenData = UuidTokenController::findUniqueToken($type, $addedCharacter);
    //                     }

    //                     /* Domain */
    //                     $option = Option::where('key', 'site_url')->first();
    //                     if($offer->website_url == ''){
    //                         $share_link = '/f/'.$offer->uuid.'?share_cnf='.$tokenData['token'];
    //                     }else{
    //                         $url = rtrim($offer->website_url,"/");
    //                         $share_link = $url.'/?o='.$offer->uuid.'&share_cnf='.$tokenData['token'];
    //                     }
    //                     $uuid_code = $tokenData['token'];

    //                     /* Get Short Link */
    //                     if($this->offer->website_url != ''){
    //                         $long_link = $share_link;
    //                     }else{
    //                         $long_link = $option->value.$share_link;
    //                     }
    //                     $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $offer->user_id ?? 0, "share_new_offer");

    //                     if($shortLinkData->original["success"] !== false){
    //                         $settings = OfferReward::where('user_id', $offer->user_id)->where('channel_id',3)->first();
    //                         if($settings != null){
    //                             $short_link = "https://opnl.in/".$shortLinkData->original["code"];
    //                             $groupSettings = BusinessDetail::where('user_id', $offer->user_id)->first();
    //                             $biz_name = $groupSettings->business_name ?? 'business owner';
    //                             if(strlen($biz_name) > 28){
    //                                 $biz_name = substr($biz_name,0,28).'..';
    //                             }

    //                             $message = "You are eligible for Challenge\nClick: opnl.in/".$shortLinkData->original["code"]."\nShare to your contacts to get benefits on your next purchase with ".$biz_name."\nOPNLNK";
                                
    //                             $followThisLink = "Follow this link:";

    //                             $whatsapp_msg = "Hello again!\n\nWe have another exciting and simple to do challenge for you. All you need to do is share the provided link with your friends and family, and get targeted clicks.\n\nOnce you've completed this task, you'll receive a prize as a benefit for your effort on your next purchase!\n\nDon't miss out on this opportunity to earn some extra prizes while supporting *".$biz_name."*. \n\n *".$followThisLink."* Click: opnl.in/".$shortLinkData->original["code"]."  to the offer page for more details on this task and the reward.\n\nThank you for your continued support!";
                            
    //                             $customerData = Customer::find($ShareChallengeContact->customer_id);

    //                             $params = [
    //                                 "mobile" => "91".$customerData->mobile,
    //                                 "message" => $message,
    //                                 "channel_id" => 3,
    //                                 'whatsapp_msg' => $whatsapp_msg,
    //                                 'sms_msg' => $message,
    //                                 "user_id" => $offer->user_id
    //                             ];
    //                             $sendLink = app('App\Http\Controllers\MessageController')->sendMsg($params);
    //                             $link_by_sms = false;
    //                             $err_by_sms = '';

    //                             if(isset($sendLink->original["sms"]["Status"]) && $sendLink->original["sms"]["Status"] == "1"){
    //                                 $link_by_sms = true;
    //                             }else{  
    //                                 if(isset($sendLink->original["sms"]["message"])){
    //                                     $err_by_sms = $sendLink->original["sms"]["message"];
    //                                 }else{
    //                                     $err_by_sms = $sendLink->original["sms"];
    //                                 }
    //                             }
    //                             if($link_by_sms == true){
    //                                 $channel_id = 3;
    //                                 $related_to = "Share and reward";
    //                                 if($link_by_sms == true){
    //                                     $messageHistory_id = DeductionHelper::setMessageHistory($offer->user_id, $channel_id, "91".$customerData->mobile, $message, $related_to, 'sms', 1);

    //                                     // Insert in Deduction History Table
    //                                     $checkWallet = DeductionHelper::getUserWalletBalance($this->offer->user_id);

    //                                     if($checkWallet['status']==true && $checkWallet['wallet_balance'] <= 0){
    //                                         $sms_res = ['status'=> false, 'message' => "Unable to send sms due to low balance"];
    //                                         DeductionHelper::deductWalletBalance($offer->user_id, $deductionSmsDetail->id ?? 0, $channel_id, $messageHistory_id, $customer_id, 0);
    //                                          $ShareChallengeContactstatus=0;
    //                                         $his=DeductionHelper::setOfferContactHistory($offer->user_id,$customer_id,$offer->id,$ShareChallengeContactstatus);
    //                                     }
    //                                     else{
    //                                         $deductionSmsDetail = DeductionHelper::getActiveDeductionDetail('slug', 'send_sms');
    //                                         DeductionHelper::deductWalletBalance($offer->user_id, $deductionSmsDetail->id ?? 0, $channel_id, $messageHistory_id, $customer_id, 0); 
    //                                          $ShareChallengeContactstatus=1;
    //                                         $his=DeductionHelper::setOfferContactHistory($offer->user_id,$customer_id,$this->offer->id,$ShareChallengeContactstatus);
    //                                     }
    //                                 }

    //                                 $incomplete = OfferSubscription::where('user_id', $offer->user_id)->where('channel_id', 3)->where('customer_id', $customer_id)->where('status','3')->first();
    //                                 if($incomplete != null){  
    //                                     $parent_id = $incomplete->id;
    //                                 }else{
    //                                     $parent_id = '';
    //                                 }

    //                                 $shortLink = new ShortLink;
    //                                 $shortLink->uuid = $shortLinkData->original["code"];
    //                                 $shortLink->link = $long_link;
    //                                 $shortLink->save();

    //                                 $subscription = new OfferSubscription;
    //                                 $subscription->parent_id = $parent_id;
    //                                 $subscription->channel_id = 3;
    //                                 $subscription->user_id = $offer->user_id;
    //                                 $subscription->created_by = $offer->user_id;
    //                                 $subscription->offer_id = $offer->id;
    //                                 $subscription->short_link_id = $shortLink->id;
    //                                 $subscription->customer_id = $customer_id;
    //                                 $subscription->uuid = $uuid_code;
    //                                 $subscription->share_link = $share_link;
    //                                 $subscription->save();
                            
    //                                 $offerSubscriptionReward = new OfferSubscriptionReward;
    //                                 $offerSubscriptionReward->user_id = $offer->user_id;
    //                                 $offerSubscriptionReward->offer_id = $offer->id;
    //                                 $offerSubscriptionReward->offer_subscription_id = $subscription->id;
    //                                 $offerSubscriptionReward->type = $settings->type;
    //                                 $offerSubscriptionReward->details = $settings->details;
    //                                 $offerSubscriptionReward->save();
    //                                 return response()->json(['status' => true, 'message' => 'Successfully Send SMS']);
    //                             }
    //                         }
    //                     }
    //                 }
    //             }   
    //         }else{
    //            return response()->json(['status' => false, 'message' => 'Offer Expired']); 
    //         }
            
    //     }

    // }

    public function resendFailedOfferMsg(Request $request)
    {
        if ($request != null) {
            $date = $request->date;
            $offer_id = $request->offer_id;

            /* Check Master Switch */
            $activeSwitchUserCheck = UserChannel::whereIn('channel_id', [3,5])->where('status', 1)->where('user_id', Auth::id())->get();

            if(empty($activeSwitchUserCheck) || count($activeSwitchUserCheck) != 2){
                return response()->json(['status' => false, 'message' => 'Please enable Share Challenge and Personalised Message master switch.']);
            }

            /* Check SMS routes on for Personalised Message */
            $userWithActiveRouteCheck = MessageRoute::where('user_id', Auth::id())->where('channel_id', 5)->where('sms', 1)->first();
            
            if($userWithActiveRouteCheck == null){
                return response()->json(['status' => false, 'message' => 'Please enable Personalised Message SMS route.']);
            }

            /* Check Balance */
            $deductionDetail = DeductionHelper::getActiveDeductionDetail('slug', 'send_sms');

            /* Users with balance */
            $activeUserWithBalanceCheck = MessageWallet::with('user')->has('user')->where('wallet_balance', '>', $deductionDetail->amount)->where('user_id', Auth::id())->first();

            if($activeUserWithBalanceCheck == null){
                return response()->json(['status' => false, 'message' => config('constants.payment_alert')]);
            }

            $offer = Offer::where('id', $offer_id)->where('start_date', '<=', date("Y-m-d"))->where('end_date', '>=', date("Y-m-d"))->first();

            if($offer == null){
                return response()->json(['status' => false, 'message' => 'Offer expired.']);
            }

            $businessDetail = BusinessDetail::where('user_id', Auth::id())->where('send_when_start',1)->where('selected_groups','!=','')->select('id','user_id','share_offer_scheduled_date')->first();

            if($businessDetail != null){
                dispatch(new ShareNewOfferLinkJob($offer));

                return response()->json(['status' => true, 'message' => 'Offer shared successfully.']);

            }else{
                return response()->json(['status' => false, 'message' => 'Please complete share challenge setting.']);
            }
        }
    }

}
