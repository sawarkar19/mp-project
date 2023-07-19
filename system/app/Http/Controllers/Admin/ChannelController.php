<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Channel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Session;
use URL;

class ChannelController extends Controller
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
                $channels = Channel::where($request->term, 'like', '%' . $request->src . '%')
                    ->latest()
                    ->paginate(10);

                $conditions[] = [$request->term, 'like', '%' . $request->src . '%'];
                // dd($conditions);
            } else {
                $channels = Channel::where('status', $status)
                    ->where($request->term, 'like', '%' . $request->src . '%')
                    ->latest()

                    ->pagiante(10);
                // dd($channels);

                $conditions[] = [$request->term, 'like', '%' . $request->src . '%'];
            }
        } else {
            if ($status === 'all') {
                $channels = Channel::latest()->paginate(10);
            } else {
                $channels = Channel::where('status', $status)
                    ->latest()
                    ->paginate(10);
            }
        }
        $channels_url = Session(['channels_url' => '#']);
        $all = Channel::where($conditions)->count();
        $actives = Channel::where('status', 1)
            ->where($conditions)
            ->count();
        $inactives = Channel::where('status', 0)
            ->where($conditions)
            ->count();
        // dd($all);

        return view('admin.channels.index', compact('channels', 'request', 'all', 'status', 'actives', 'inactives'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $channels = [];

        return view('admin.channels.create', compact('channels'));
        // dd($channels);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $maxValue = Channel::max('id');
        $result_max = $maxValue + 1;

        $rules = [
            'name' => 'required|max:100',
            'price' => 'required|max:8',
        ];

        $messages = [
            'name.required' => 'Channel name is required ! ',
            'price.required' => 'Price is required !',
        ];

        $this->validate($request, $rules, $messages);

        $check = Channel::where('name', $request->name)->first();
        if (!$check) {
            $channel = new Channel();
            $channel->name = $request->name;
            $channel->slug = $request->slug;
            $channel->short_description = $request->short_description;
            $channel->description = $request->description;
            $channel->price = $request->price;
            $channel->icon = $request->icon;
            $channel->font_icon = $request->font_icon;
            $channel->route = $request->route;
            $channel->free_employee = $request->free_employee;
            $channel->disabled = $request->disabled ?? 0;
            $channel->is_use_msg = $request->is_use_msg ?? 1;
            $channel->status = 1;
            $channel->save();
            $channel->ordering = $result_max;
            $channel->save();

            echo json_encode(['type' => 'success', 'message' => 'Channel Created Successfully !']);
        } else {
            echo json_encode(['type' => 'error', 'message' => 'Channel name is Already exists !']);
        }

        // dd($channel);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $channels = Channel::findOrfail($id);
        return view('admin.channels.show', compact('channels'));
        // dd($channels);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $channels_url = Session(['channels_url' => URL::previous()]);
        $channels = Channel::find($id);
        // dd($channels);
        return view('admin.channels.edit', compact('channels'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $channel = Channel::find($id);

        $rules = [
            'name' => 'required|max:100',
            'price' => 'required|max:8',
        ];

        $messages = [
            'name.required' => 'Channel name is required ! ',
            'price.required' => 'Price is required !',
        ];

        $this->validate($request, $rules, $messages);
        $channels_url = Session::get('channels_url');
        $check = Channel::where('name', $request->name)
            ->where('id', '<>', $id)
            ->first();
        if (!$check) {
            $channel->name = $request->name;
            $channel->slug = $request->slug;
            $channel->short_description = $request->short_description;
            $channel->description = $request->description;
            $channel->price = $request->price;
            $channel->icon = $request->icon;
            $channel->font_icon = $request->font_icon;
            $channel->route = $request->route;
            $channel->free_employee = $request->free_employee;
            $channel->disabled = $request->disabled ?? 0;
            $channel->is_use_msg = $request->is_use_msg ?? 1;
            $channel->status = $request->status;
            $channel->save();

            echo json_encode(['type' => 'success', 'message' => 'Channel Updated Successfully !']);
        } else {
            echo json_encode(['type' => 'error', 'message' => 'Channel name is Already exists !']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function destroys(request $request)
    {
        if (!isset($request->type)) {
            return response()->json(['status' => false, 'message' => 'Please Select Action !']);
        }

        if (!isset($request->ids)) {
            return response()->json(['status' => false, 'message' => 'Please Select Channel !']);
        }

        // if (($request->type=='delete')) {
        //     foreach ($request->ids as $key => $id) {
        //         $channels = Channel::findOrfail($id);
        //         $channels->delete();
        //         // dd($request->type=='delete');
        //     }
        //     return response()->json(["status" =>true, "message" => "Channel Deleted !"]);
        // } else {
        //     return response()->json(["status" =>false, "message" => "Channel Not Deleted !"]);
        // }

        if ($request->type == 0) {
            foreach ($request->ids as $key => $id) {
                $channels = Channel::findOrfail($id);
                $channels->status = 0;
                $channels->save();
                // dd($request->type== 0);
            }
            return response()->json(['status' => true, 'message' => 'Channel Inactivated !']);
        } elseif ($request->type == 1) {
            foreach ($request->ids as $key => $id) {
                $channels = Channel::findOrfail($id);
                $channels->status = 1;
                $channels->save();
            }
            return response()->json(['status' => true, 'message' => 'Channel Activated !']);
        } else {
            return response()->json(['status' => false, 'message' => 'Could Not Successfully Done !']);
        }

        // dd(!isset($request->ids));
    }
}
