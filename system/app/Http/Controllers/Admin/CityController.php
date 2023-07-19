<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;
use App\Models\City;
use Session;
use URL;

class CityController extends Controller
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
        if (!empty($request->src) && !empty($request->term)) {
            
            if($request->term === 'state'){
                if ($status === 'all') {
                    $cities = City::leftjoin('states', 'cities.state_id', '=', 'states.id')
                    ->select(
                        'cities.id',
                        'cities.state_id',
                        'cities.name as name',
                        'cities.lat',
                        'cities.lng',
                        'cities.created_at',
                        'cities.updated_at',
                        'cities.status',
                        'states.name as state_name'
                    )
                    ->where('states.name', 'like','%'.$request->src.'%')
                    ->latest()
                    ->paginate(25);

                }else{
                    $cities = City::leftjoin('states', 'cities.state_id', '=', 'states.id')
                    ->where('status',$status)
                    ->select(
                        'cities.id',
                        'cities.state_id',
                        'cities.name as name',
                        'cities.lat',
                        'cities.lng',
                        'cities.created_at',
                        'cities.updated_at',
                        'cities.status',
                        'states.name as state_name'
                    )
                    ->where('state_name', 'like','%'.$request->src.'%')
                    ->latest()
                    ->paginate(25);
                }
            }else{
                if ($status === 'all') {

                    $cities = City::where($request->term, 'like','%'.$request->src.'%')
                    ->latest()
                    ->paginate(25);

                }else{
                    $cities = City::where('status',$status)
                    ->where($request->term, 'like','%'.$request->src.'%')
                    ->latest()
                    ->paginate(25);
                }
            }
        }else{  
            if ($status === 'all') { 

                $cities = City::latest()
                ->paginate(25);

            }else{

                $cities = City::where('status',$status)
                ->latest()
                ->paginate(25);

            }
        }

        $city_url = Session(['city_url'=>'#']);
        $all=City::where('status',1)->count();
        $actives=City::where('status',1)->count();
        $inactives=City::where('status',0)->count();
        // dd($cities);
        return view('admin.locations.cities.index', compact('cities', 'request', 'all', 'status', 'actives', 'inactives'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        $states = State::orderBy('name', 'asc')
        ->pluck('name','id');
        $cities = array();
        return view('admin.locations.cities.create', compact('cities', 'states'));
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

        // $check = City::where('id', '<>', $id)->where('name', $request->name)->first();
        $check = City::where('name', $request->name)->first();
        $checkLat = City::where('lat', $request->lat)->first();
        $checkLang = City::where('lng', $request->lng)->first();

        if(!$check){

            if(!$checkLat){
                if(!$checkLang){
                    $city = new City;
                    $city->name = $request->name;
                    $city->state_id = $request->state_id;
                    $city->lat = $request->lat;
                    $city->lng = $request->lng;
                    $city->status = 1;
                    $city->save();

                    echo json_encode(array("type"=>"success", "message"=>"City Created Successfully!"));
                }else{
                    echo json_encode(array("type"=>"error", "message"=>"Longitude is already define!"));
                }
            }else{
                echo json_encode(array("type"=>"error", "message"=>"Latitude is already define!"));
            }                    
        }else{
            echo json_encode(array("type"=>"error", "message"=>"City name is already exists!"));
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
        $city_url = Session(['city_url' => URL::previous()]);        
        $states = State::orderBy('name', 'asc')
        ->pluck('name','id');
        $cities = City::where('id', $id)->first();

        return view('admin.locations.cities.edit', compact('cities', 'states'));
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
        $city_url = Session::get('city_url');
        $check = City::where('name', $request->name)->where('id', '<>', $id)->first();
        $checkLat = City::where('lat', $request->lat)->where('id', '<>', $id)->first();
        $checkLang = City::where('lng', $request->lng)->where('id', '<>', $id)->first();

        if(!$check){
            if(!$checkLat){
                if(!$checkLang){
                    $city = City::where('id', $id)->first();
                    $city->name = $request->name;
                    $city->state_id = $request->state_id;
                    $city->lat = $request->lat;
                    $city->lng = $request->lng;
                    $city->status = $request->status;
                    $city->save();

                    echo json_encode(array("type"=>"success", "message"=>"City Updated Successfully!", "url"=> $city_url));
                }else{
                    echo json_encode(array("type"=>"error", "message"=>"Longitude is already define!"));
                }
            }else{
                echo json_encode(array("type"=>"error", "message"=>"Latitude is already define!"));
            }                    
        }else{
            echo json_encode(array("type"=>"error", "message"=>"City name is already exists!"));
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
                $city = City::findorFail($id);
                $city->delete();
            }
            return response()->json(['Cities Deleted']);
        }else if($request->type=='0'){
            foreach ($request->ids as $key => $id) {
                $city = City::findorFail($id);
                $city->status = 0;
                $city->save();
            }
            return response()->json(['Cities Deactivated']);
        }else if($request->type=='1'){
            foreach ($request->ids as $key => $id) {
                $city = City::findorFail($id);
                $city->status = 1;
                $city->save();
            }
            return response()->json(['Cities Activated']);
        }
    }
}
