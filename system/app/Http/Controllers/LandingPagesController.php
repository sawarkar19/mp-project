<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LandingPageEnquirie;

class LandingPagesController extends Controller
{
    public function pos_wa_api(){
        
        return view('landing_page.pos_wa_api_yt');
    }

    public function store(Request $request){
        
        $request->validate([
            'name' => 'required|min:2',
            'email' => 'required|email',
            'phone' => 'required|regex:/[0-9]/|not_regex:/[a-z]/|min:10|max:10'
        ]);
        
        $Jdata = json_encode(['Has POP' => $request->firstAns, 'Send WA or SMS via software' => $request->secondAns, 'Which Software' => $request->thirdAns]);

        $data = new LandingPageEnquirie();
        $data->pageID = 'LP1_WAPI';
        $data->status = 1;
        $data->name = $request->name;
        $data->phone = $request->phone;
        $data->email = $request->email;
        $data->data = $Jdata;

        $data->save();

        return response()->json(['status'=> true, 'message'=> 'Data successfully saved.'], 200);
    }

    public function mouth_publicity_media(){
        
        return view('landing_page.mouth_publicity_media');

    }

    public function store_lp2_number(Request $request){
        if ($request->number != '') {

            $data = new LandingPageEnquirie();
            $data->pageID = 'LP2_MPM';
            $data->status = 0;
            $data->phone = $request->number;
            $data->save();
            $id = $data->id;

            return response()->json(['status'=> true, 'message'=> 'Number successfully saved.', 'row_id' => $id], 200);
        }else{
            return response()->json(['status'=> false, 'message'=> 'Empty number!'], 200);
        }
    }

    public function store_lp2(Request $request){
        
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required'
        ]);


        if($request->row){
            $data = LandingPageEnquirie::find($request->row);
        }else{
            $data = new LandingPageEnquirie();
            $data->pageID = 'LP2_MPM';
        }
        $data->status = 1;
        $data->name = $request->name;
        $data->phone = $request->phone;
        $data->email = $request->email;
        $data->data = $request->Jdata;

        $data->save();

        return response()->json(['status'=> true, 'message'=> 'Data successfully saved.'], 200);
    }
}
