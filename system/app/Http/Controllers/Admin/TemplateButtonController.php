<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\GalleryImage;
use App\Models\Template;
use App\Models\TemplateButton;
use Session;
use URL;
use DB;
use Redirect;


class TemplateButtonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $templateButtons = TemplateButton::orderBy('id', 'desc')
           ->take(10)
           ->paginate(10)
           ->get();

        $templateButton_url = Session(['templateButton_url'=>'#']);

        return view('admin.templates.show', compact('templateButtons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $template_id = $request->id;
        $templateButtons = array();

        return view('admin.templatebuttons.create', compact('templateButtons','template_id'));
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
            'name' => 'required|max:50',
            'link' => 'required|max:250',
            'btn_text_color' => 'required|max:50',
            'btn_style_type' => 'required',
        ];

        $messages = [
           'name.required' => 'name can not be empty!',
           'link.required' => 'link can not be empty!',
           'btn_text_color.required' => 'button text color can not be empty!',
           'btn_style_type.required' => 'button style type can not be empty!',
        ];

        $this->validate($request, $rules, $messages);

        $templateButton = new TemplateButton;
        $templateButton->template_id = $request->template_id;
        $templateButton->name = $request->name;
        $templateButton->link = $request->link;
        $templateButton->btn_text_color = $request->btn_text_color;
        $templateButton->btn_style_color = $request->btn_style_color;
        $templateButton->btn_style_type = $request->btn_style_type;
        $templateButton->is_hidden = $request->is_hidden;
        $templateButton->is_removed = $request->is_removed;
        $templateButton->save();

        $url = route('admin.templates.show', $request->template_id);

        echo json_encode(array("type"=>"success", "message"=>"Template Button Created Successfully!", "url" => $url));
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
        $templateButton_url = Session(['templateButton_url'=> URL::previous()]);
        $templateButtons = TemplateButton::find($id);
        $template_id = $request->id;

        return view('admin.templatebuttons.edit', compact('templateButtons','template_id'));
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
            'name' => 'required|max:50',
            'link' => 'required|max:250',
            'btn_text_color' => 'required|max:50',
            'btn_style_type' => 'required',
        ];

        $messages = [
           'name.required' => 'name can not be empty!',
           'link.required' => 'link can not be empty!',
           'btn_text_color.required' => 'button text color can not be empty!',
           'btn_style_type.required' => 'button style type can not be empty!',
        ];

        $this->validate($request, $rules, $messages);

        $templateButton_url = Session::get('templateButton_url');

        $templateButton = TemplateButton::find($id);
        $templateButton->name = $request->name;
        $templateButton->link = $request->link;
        $templateButton->btn_text_color = $request->btn_text_color;
        $templateButton->btn_style_color = $request->btn_style_color;
        $templateButton->btn_style_type = $request->btn_style_type;
        $templateButton->is_hidden = $request->is_hidden;
        $templateButton->is_removed = $request->is_removed;
        $templateButton->save();

        echo json_encode(array("type"=>"success", "message"=>"Template Button Update Successfully!", "url"=>$templateButton_url));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroyPage(Request $request, $id)
    {
        TemplateButton::destroy($id);

        return response()->json([
            'status' => true,
            'message' => 'Template Button Deleted Successfully !',
        ]);
    }
}
