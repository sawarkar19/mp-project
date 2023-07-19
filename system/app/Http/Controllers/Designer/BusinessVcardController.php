<?php

namespace App\Http\Controllers\Designer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BusinessVcard;
use Session;
use URL;

class BusinessVcardController extends Controller
{
    public function __construct()
    {
        $this->middleware('designer');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = $request->status ?? 'all';
        if (!empty($request->src) && !empty($request->term)) {
            if ($status === 'all') {
                $vcards = BusinessVcard::where($request->term, 'like', '%' . $request->src . '%')
                    ->orderBy('id', 'asc')
                    ->paginate(10);
            } else {
                $vcards = BusinessVcard::where('status', $status)
                    ->where($request->term, 'like', '%' . $request->src . '%')
                    ->orderBy('id', 'asc')
                    ->paginate(10);
            }
        } else {
            if ($status === 'all') {
                $vcards = BusinessVcard::orderBy('id', 'asc')->paginate(10);
            } else {
                $vcards = BusinessVcard::where('status', $status)
                    ->orderBy('id', 'asc')
                    ->paginate(10);
            }
        }

        $vcards_url = Session(['vcards_url' => '#']);
        // $states = State::latest()->paginate(25);
        $all = BusinessVcard::count();
        $actives = BusinessVcard::where('status', 1)->count();
        $inactives = BusinessVcard::where('status', 0)->count();

        return view('designer.vcards.index', compact('vcards', 'request', 'all', 'status', 'actives', 'inactives'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vcards = [];
        return view('designer.vcards.create', compact('vcards'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'thumbnail' => 'required',
        ];

        $messages = [
            'thumbnail.required' => 'Thumbnail Image is required!',
        ];

        $this->validate($request, $rules, $messages);

        if ($request->default_card == 1) {
            BusinessVcard::where('default_card', 1)->update(['default_card' => 0]);
        }

        $vcard = new BusinessVcard();
        $vcard->default_card = $request->default_card;
        $vcard->status = $request->status;
        $vcard->save();

        $vcard->slug = $vcard->id;
        $thumb_dir = base_path('../assets\business\vcards');
        $thumbnail = $request->file('thumbnail');

        if ($thumbnail != '') {
            if (!file_exists($thumb_dir)) {
                mkdir($thumb_dir, 0777, true);
            }
            $thumbnail_image_name = 'vcard_thumb_' .$vcard->slug . '.' . $thumbnail->getClientOriginalExtension();

            $thumbnail->move($thumb_dir, $thumbnail_image_name);
            $vcard->thumbnail = $thumbnail_image_name;
        }
        $vcard->save();
        // dd($vcard);

        echo json_encode(array("type"=>"success", "message"=>"Vcard Created Successfully!"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vcards_url = Session(['vcards_url'=> URL::previous()]);
        $vcards = BusinessVcard::find($id);
        return view('designer.vcards.edit', compact('vcards'));
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
        if ($request->default_card == 1) {
            BusinessVcard::where('default_card', 1)->update(['default_card' => 0]);
        }
        $vcard = BusinessVcard::find($id);
        $vcards_url = Session::get('vcards_url');

        $thumb_dir = base_path('../assets\business\vcards');

        //---thumbnail image start---//
        if ($request->has('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            //dd($request->file('thumbnail'));
            if($thumbnail != '')
            {
                if (!file_exists($thumb_dir)) {
                    mkdir($thumb_dir, 0777, true);
                }
                $thumbnail_image_name = 'vcard_thumb_'.$vcard->id.'.' . $thumbnail->getClientOriginalExtension();

                $thumbnail->move($thumb_dir, $thumbnail_image_name);
                $vcard->thumbnail=$thumbnail_image_name;
            }
        } else {
            ($vcard['thumbnail']);
        }
        //---thumbnail image end---//

        $vcard->default_card = $request->default_card;
        $vcard->status = $request->status;
        $vcard->save();

        echo json_encode(array("type"=>"success", "message"=>"Vcard Update Successfully!", "url"=> $vcards_url));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroys(request $request)
    {
        if(!isset($request->type)){
            return response()->json(["status" => false, "message" => 'Please Select Action!']);
        }

        if(!isset($request->ids)){
            return response()->json(["status" => false, "message" => 'Please Select Vcard!']);
        }

        if (($request->type=='delete')) {
            foreach ($request->ids as $key => $id) {
                $vcards = BusinessVcard::findorfail($id);
                $vcards->delete();
            }
            return response()->json(["status" =>true, "message" =>'Vcard Deleted!']);
        } else if ($request->type== 0) {
            foreach ($request->ids as $key => $id) {
                $vcards = BusinessVcard::findorfail($id);
                $vcards->status = 0;
                $vcards->save();
            }
            return response()->json(["status" =>true, "message" =>'Successfully Done !']);
        } else if ($request->type== 1) {
            foreach ($request->ids as $key => $id) {
                $vcards = BusinessVcard::findorfail($id);
                $vcards->status = 1;
                $vcards->save();
            }
            return response()->json(["status" =>true, "message" =>'Vcard Deactivated!']);
        } else {
            return response()->json(["status" =>false, "message" =>'Could Not Successfully Done !']);
        }
    }
}
