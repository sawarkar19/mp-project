<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\PlanGroup;
use App\Models\PlanGroupChannel;
use App\Models\PlanGroupType;
use Illuminate\Http\Request;
// use Illuminate\Support\Str;
use Session;
use URL;

class PlanGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = $request->status ?? 'all';
        $conditions = [];

        if (!empty($request->src) && !empty($request->term)) {
            if ($status === 'all') {
                $plangroups = PlanGroup::where($request->term, 'like', '%' . $request->src . '%')
                    ->latest()
                    ->paginate(10);

                $conditions[] = [$request->term, 'like', '%' . $request->src . '%'];
                // dd($conditions);
            } else {
                $plangroups = PlanGroup::where('status', $status)
                    ->where($request->term, 'like', '%' . $request->src . '%')
                    ->latest()

                    ->pagiante(10);
                // dd($channels);

                $conditions[] = [$request->term, 'like', '%' . $request->src . '%'];
            }
        } else {
            if ($status === 'all') {
                $plangroups = PlanGroup::latest()->paginate(10);
            } else {
                $plangroups = PlanGroup::where('status', $status)
                    ->latest()
                    ->paginate(10);
            }
        }
        $plangroups_url = Session(['plangroups_url' => '#']);
        $all = PlanGroup::where($conditions)->count();
        $actives = PlanGroup::where('status', 1)
            ->where($conditions)
            ->count();
        $inactives = PlanGroup::where('status', 0)
            ->where($conditions)
            ->count();
        // dd($all);

        return view('admin.plangroups.index', compact('plangroups', 'request', 'all', 'status', 'actives', 'inactives'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $plangroups = [];
        $types = PlanGroupType::orderBy('name', 'asc')->pluck('name', 'id');

        return view('admin.plangroups.create', compact('plangroups', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $maxValue = PlanGroup::max('id');
        $result_max = $maxValue + 1;

        $rules = [
            'name' => 'required|max:100',
        ];

        $messages = [
            'name.required' => 'Plan Group name is required ! ',
        ];

        $this->validate($request, $rules, $messages);

        $check = PlanGroup::where('name', $request->name)->first();

        if (!$check) {
            $plangroup = new PlanGroup();
            $plangroup->name = $request->name;
            $plangroup->slug = $request->slug;
            $plangroup->tag = $request->tag;
            $plangroup->status = 1;
            $plangroup->save();

            $plangroup->ordering = $result_max;
            $plangroup->save();

            if (!empty($request->channel_id)) {
                foreach ($request->channel_id as $channel) {
                    $plangroup_id = new PlanGroupChannel();
                    $plangroup_id->plan_group_id = $plangroup->id;
                    $plangroup_id->channel_id = $channel;
                    $plangroup_id->save();
                }
            } else {
                echo json_encode(['type' => 'error', 'message' => 'Please select channel!']);
            }

            echo json_encode(['type' => 'success', 'message' => 'Plan Group Created Successfully !']);
        } else {
            echo json_encode(['type' => 'error', 'message' => 'Plan Group name is Already exists !']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plan_group  $plan_group
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $plangroups = PlanGroup::findOrfail($id);

        return view('admin.plangroups.show', compact('plangroups'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Plan_group  $plan_group
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $plangroups_url = Session(['plangroups_url' => URL::previous()]);
        $plangroups = PlanGroup::find($id);
        $plangroup_id = PlanGroupChannel::where('plan_group_id',$id)->get();
        $types = PlanGroupType::orderBy('name', 'asc')->pluck('name', 'id');
        // dd($plangroup_id);
        return view('admin.plangroups.edit', compact('plangroups', 'types', 'plangroup_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Plan_group  $plan_group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $plangroup = PlanGroup::find($id);
        // dd($plangroup);

        $rules = [
            'name' => 'required|max:100',
            'channel_id' => 'required|array',
        ];

        $messages = [
            'name.required' => 'Channel name is required ! ',
            'channel_id.required' => 'Select Channel is Required',
        ];

        $this->validate($request, $rules, $messages);

        $plangroups_url = Session::get('plan_groups_url');

        $check = PlanGroup::where('name', $request->name)
            ->where('id', '<>', $id)
            ->first();

        if (!$check) {
            $plangroup->name = $request->name;
            $plangroup->slug = $request->slug;
            $plangroup->tag = $request->tag;
            $plangroup->status = $request->status;
            // dd($plangroup);
            $plangroup->save();

            PlanGroupChannel::where('plan_group_id', $plangroup->id)->delete();

            if (!empty($request->channel_id)) {
                foreach ($request->channel_id as $channel) {
                    $plangroup_id = new PlanGroupChannel();
                    $plangroup_id->plan_group_id = $plangroup->id;
                    $plangroup_id->channel_id = $channel;
                    // dd($plangroup_id);
                    $plangroup_id->save();
                }
            } else {
                echo json_encode(['type' => 'error', 'message' => 'Please select channel!']);
            }

            echo json_encode(['type' => 'success', 'message' => 'Plan Group Updated Successfully !']);
        } else {
            echo json_encode(['type' => 'error', 'message' => 'Plan Group name is Already exists !']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plan_group  $plan_group
     * @return \Illuminate\Http\Response
     */
    public function destroys(request $request)
    {
        if (!isset($request->type)) {
            return response()->json(['status' => false, 'message' => 'Please Select Action !']);
        }

        if (!isset($request->ids)) {
            return response()->json(['status' => false, 'message' => 'Please Select Plan Group !']);
        }

        if ($request->type == 0) {
            foreach ($request->ids as $key => $id) {
                $plangroups = PlanGroup::findOrfail($id);
                $plangroups->status = 0;
                $plangroups->save();
                // dd($request->type== 0);
            }
            return response()->json(['status' => true, 'message' => 'Plan Group Inactivated !']);
        } elseif ($request->type == 1) {
            foreach ($request->ids as $key => $id) {
                $plangroups = PlanGroup::findOrfail($id);
                $plangroups->status = 1;
                $plangroups->save();
            }
            return response()->json(['status' => true, 'message' => 'Plan Group Activated !']);
        } else {
            return response()->json(['status' => false, 'message' => 'Could Not Successfully Done !']);
        }
    }
}
