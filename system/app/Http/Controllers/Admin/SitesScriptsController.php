<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Option;
use DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Session;
use URL;


class SitesScriptsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $options = Option::latest()->paginate(10);
        $option_url = Session(['option_url' => '#']);
        return view('admin.sites-scripts.index', compact('options'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //   $emails = array();
        //   return view('admin.emailmanage.create', compact('emails'));
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
            'title' => 'required|min:10|max:100',
            'value' => 'required',
        ];

        $messages = [
            'title.required' => 'Title can not be empty !',
            'value.required' => 'Description can not be empty !',
        ];

        $this->validate($request, $rules, $messages);

        $create_slug = Str::slug($request->title);
        $check = Option::where('key', $create_slug)->count();

        if ($check != 0) {
            $slug = $create_slug.'-'.$check.rand(20,80);
        }else {
            $slug = $create_slug;
        }

        $slug = str_replace('-', '_', $slug);

        $options = new Option;
        $options->title = $request->title;
        $options->key = $slug;
        $options->value = $request->value;
        $options->status = $request->status;
        $options->save();

        return response()->json([
            'status' => true,
            'message' => 'Site Script Added Successfully !',
        ]);
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
    public function optionDetail(Request $request)
    {
        $options = Option::find($request->id);

        $json=[
            'status'=>true,
            'options'=>$options
        ];
        return response()->json($json);
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
        $rules = [
            'title' => 'required|min:10|max:100',
            'value' => 'required',
        ];

        $messages = [
            'title.required' => 'Title can not be empty !',
            'value.required' => 'Description can not be empty !',
        ];

        $this->validate($request, $rules, $messages);

        $option = Option::find($request->id);
        // dd($option);
        $option_url = Session::get('option_url');
        $option->title = $request->title;
        $option->value = $request->value;
        $option->status = $request->status;
        $option->save();

        return response()->json([
            'status' => true,
            'message' => 'Site Script Update Successfully !'
        ]);
    }


    public function updateScript(Request $request)
    {
        $rules = [
            'title' => 'required|min:10|max:100',
            'value' => 'required',
        ];

        $messages = [
            'title.required' => 'Title can not be empty !',
            'value.required' => 'Description can not be empty !',
        ];

        $this->validate($request, $rules, $messages);

        $option = Option::find($request->id);
        // dd($option);
        $option_url = Session::get('option_url');
        $option->title = $request->title;
        $option->value = $request->value;
        $option->status = $request->status;
        $option->save();

        return response()->json([
            'status' => true,
            'message' => 'Site Script Update Successfully !'
        ]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if ($request->ids) {
            foreach ($request->ids as $id) {
                Option::destroy($id);
            }
            return response()->json(['status' => true, 'message' => 'Successfully deleted !']);
        }else{
            return response()->json(['status' => false, 'message' => 'Please select script !']);
        }
    }
}
