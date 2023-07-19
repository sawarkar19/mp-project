<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;
use Session;
use URL;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $status=$request->status ?? 'all';
        // dd($status);
        if (!empty($request->src) && !empty($request->term)) {
            if ($status === 'all') {

                $states = State::where($request->term, 'like','%'.$request->src.'%')
                ->latest()
                ->paginate(25);

            }else{
                $states = State::where('status', $status)
                ->where($request->term, 'like','%'.$request->src.'%')
                ->latest()
                ->paginate(25);
            }
        }else{  
            if ($status === 'all') { 

                $states = State::latest()
                ->paginate(25);

            }else{

                $states = State::where('status', $status)
                ->latest()
                ->paginate(25);
                // dd($states);

            }
        }
        $state_url = Session(['state_url'=>'#']);
        // $states = State::latest()->paginate(25);
        $all= State::count();
        $actives = State::where('status',1)->count();
        $inactives = State::where('status',0)->count();
        // dd($states);
        return view('admin.locations.states.index', compact('states', 'request', 'all', 'status', 'actives', 'inactives'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        $states = array();
        return view('admin.locations.states.create', compact('states'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // dd($request);

        // $check = State::where('id', '<>', $id)->where('name', $request->name)->first();
        $check = State::where('name', $request->name)->first();
        $checkLat = State::where('lat', $request->lat)->first();
        $checkLang = State::where('lng', $request->lng)->first();

        if(!$check){

            if(!$checkLat){
                if(!$checkLang){
                    $state = new State;
                    $state->name = $request->name;
                    $state->lat = $request->lat;
                    $state->lng = $request->lng;
                    $state->status = 1;
                    $state->save();

                    echo json_encode(array("type"=>"success", "message"=>"State Created Successfully!"));
                }else{
                    echo json_encode(array("type"=>"error", "message"=>"Longitude is already define!"));
                }
            }else{
                echo json_encode(array("type"=>"error", "message"=>"Latitude is already define!"));
            }                    
        }else{
            echo json_encode(array("type"=>"error", "message"=>"State name is already exists!"));
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $state_url = Session(['state_url' => URL::previous()]);
        $states = State::where('id', $id)->first();

        return view('admin.locations.states.edit', compact('states'));
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
        $state_url = Session::get('state_url');
        $check = State::where('name', $request->name)->where('id', '<>', $id)->first();
        $checkLat = State::where('lat', $request->lat)->where('id', '<>', $id)->first();
        $checkLang = State::where('lng', $request->lng)->where('id', '<>', $id)->first();

        if(!$check){
            if(!$checkLat){
                if(!$checkLang){
                    $state = State::where('id', $id)->first();
                    $state->name = $request->name;
                    $state->lat = $request->lat;
                    $state->lng = $request->lng;
                    $state->status = $request->status;
                    $state->save();

                    echo json_encode(array("type"=>"success", "message"=>"State Updated Successfully!", "url"=> $state_url));
                }else{
                    echo json_encode(array("type"=>"error", "message"=>"Longitude is already define!"));
                }
            }else{
                echo json_encode(array("type"=>"error", "message"=>"Latitude is already define!"));
            }                    
        }else{
            echo json_encode(array("type"=>"error", "message"=>"State name is already exists!"));
        }
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

    public function destroys(Request $request){
        // dd($request);
        if ($request->type=='delete') {
            foreach ($request->ids as $key => $id) {
                $states = State::findorFail($id);
                $states->delete();
            }
            return response()->json(['States Deleted']);
        }else if($request->type=='0'){
            foreach ($request->ids as $key => $id) {
                $states = State::findorFail($id);
                $states->status = 0;
                $states->save();
            }
            return response()->json(['States Deactivated']);
        }else if($request->type=='1'){
            foreach ($request->ids as $key => $id) {
                $states = State::findorFail($id);
                $states->status = 1;
                $states->save();
            }
            return response()->json(['States Activated']);
        }
    }
}
