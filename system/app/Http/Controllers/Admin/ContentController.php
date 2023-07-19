<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\GalleryImage;
use App\Models\Template;
use App\Models\Content;
use Session;
use URL;
use DB;
use Redirect;


class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contents = Content::orderBy('id', 'desc')
           ->take(10)
           ->paginate(10)
           ->get();
        //    dd($contents);

        $content_url = Session(['content_url'=>'#']);

        return view('admin.templates.show', compact('contents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $template_id = $request->id;
        $contents = array();

        return view('admin.contents.create', compact('contents','template_id'));
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
            'content' => 'required|min:2',
            'content_color' => 'required',
            'content_length' => 'required',
        ];

        $messages = [
            'content.required' => 'Content is required !',
            'content_length.required' => 'Content length is required !',
            'content_color.required' => 'Content color is required !',
        ];

        $this->validate($request, $rules, $messages);
        
        $content = new Content;
        // dd($content);
        $content->template_id = $request->template_id;
        $content->content = $request->content;
        $content->content_length = $request->content_length;
        $content->content_color = $request->content_color;
        $content->save();

        $url = route('admin.templates.show', $request->template_id);

        echo json_encode(array("type"=>"success", "message"=>"Content Created Successfully!", "url" => $url));
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
    public function edit(Request $request, $id)
    {
        $content_url = Session(['content_url'=> URL::previous()]);
        $contents = Content::find($id);
        $template_id = $request->id;

        return view('admin.contents.edit', compact('contents','template_id'));
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
        $content_url = Session::get('content_url');
        $content = Content::find($id);
        $rules = [
            'content' => 'required|min:2',
            'content_color' => 'required',
            'content_length' => 'required',
        ];

        $messages = [
            'content.required' => 'Content is required !',
            'content_length.required' => 'Content length is required !',
            'content_color.required' => 'Content color is required !',
        ];

        $this->validate($request, $rules, $messages);
        
        $content->content = $request->content;
        $content->content_length = $request->content_length;
        $content->content_color = $request->content_color;
        $content->save();

        echo json_encode(array("type"=>"success", "message"=>"Content Update Successfully!", "url"=>$content_url));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroyPage(Request $request, $id)
    {
        Content::destroy($id);

        return response()->json([
            'status' => true,
            'message' => 'Content Deleted Successfully !',
        ]);
    }
}
