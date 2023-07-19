<?php

namespace App\Http\Controllers\Designer;
use URL;

use Session;
use App\Models\Content;
use App\Models\Template;
use App\Models\Bussiness;
use App\Models\GalleryImage;
use App\Models\TemplateType;
use Illuminate\Http\Request;
use App\Models\TemplateButton;
use App\Models\BussinessTemplate;
use App\Http\Controllers\Controller;

class TemplateController extends Controller
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

        $status=$request->status ?? 'all';
        if (!empty($request->src) && !empty($request->term)) {
            if ($status === 'all') {

                $templates = Template::where($request->term, 'like','%'.$request->src.'%')
                ->orderBy('id', 'asc')
                ->paginate(10);
            }else {
                $templates = Template::where('status', $status)
                ->where($request->term, 'like','%'.$request->src.'%')
                ->orderBy('id', 'asc')
                ->paginate(10);
            }
        }else {
            if ($status === 'all') {

                $templates = Template::orderBy('id', 'asc')
                ->paginate(10);

            }else {

                $templates = Template::where('status',$status)
                ->orderBy('id', 'asc')
                ->paginate(10);
            }
        }
        // dd($templates);

        $templates_url = Session(['templates_url'=>'#']);
        // $states = State::latest()->paginate(25);
        $all= Template::count();
        $actives = Template::where('status',1)->count();
        $inactives = Template::where('status',0)->count();

        // dd($templates);
        return view('designer.templates.index', compact('templates', 'request', 'all', 'status', 'actives', 'inactives'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $templates = array();
        $types = TemplateType::orderBy('name', 'asc')
        ->pluck('name','id');

        return view('designer.templates.create',compact('templates','types'));
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
               'name' => 'required|max:100',
               'contact_icon_color' => 'required',
               'thumbnail' => 'required',
               'hero_image' => 'required',

            ];

         $messages = [
                   'name.required' => 'Template Name is required!',
                   'contact_icon_color.required' => 'Contact Icons is required!',
                   'thumbnail.required' => 'Thumbnail Image is required!',
                   'hero_image.required' => 'Banner Image is required!',

                ];

                $this->validate($request, $rules, $messages);

        $check = Template::where('name', $request->name)->first();

        if (!$check) {

            $template = new Template();
            $template->name = $request->name;
            $template->bg_color = $request->bg_color;
            $template->default_color = $request->default_color;
            $template->business_name_color = $request->business_name_color;
            $template->tag_line_color = $request->tag_line_color;
            // $template->hero_title = $request->hero_title;
            // $template->hero_title_color = $request->hero_title_color;
            // $template->hero_text = $request->hero_text;
            // $template->hero_text_color = $request->hero_text_color;
            $template->video_url = $request->video_url;
            $template->video_autoplay = $request->video_autoplay;
            // $template->extra_heading_1 = $request->extra_heading_1;
            // $template->extra_heading_1_color = $request->extra_heading_1_color;
            // $template->extra_text_1 = $request->extra_text_1;
            // $template->extra_text_1_color = $request->extra_text_1_color;

            $contact_icons = [
                'contact_icon_color' => $request->contact_icon_color,
                'whatsapp_icon_color' => $request->whatsapp_icon_color,
                'location_icon_color' => $request->location_icon_color,
                'website_icon_color' => $request->website_icon_color
            ];
            $template->contact_icons = json_encode($contact_icons);
            $template->business_type = $request->business_type;
            $template->template_type = $request->template_type;
            $template->is_free = $request->is_free;
            $template->status = 1;
            $template->save();

            $dir = base_path('../assets/templates/').$template->id;
            $thumb_dir = base_path('../assets/thumbnails');

               //---background image start---//
            $bg_image = $request->file('bg_image');
            // dd($request->file('photo'));
            if($bg_image != '')
            {

                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
                $image_name = 'background.' . $bg_image->getClientOriginalExtension();
                // $folderPath1 = base_path('../assets/templates/');

                $bg_image->move($dir, $image_name);
                $template->bg_image=$image_name;

            }
            //---background image start---//

             //---banner image start---//
            $hero_image = $request->file('hero_image');
            // dd($request->file('photo'));
            if($hero_image != '')
            {
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
                $hero_image_name = 'banner.' . $hero_image->getClientOriginalExtension();

                $hero_image->move($dir, $hero_image_name);
                $template->hero_image=$hero_image_name;
            }
            //---banner image end---//

            //---thumbnail image start---//
            $thumbnail = $request->file('thumbnail');
             //dd($request->file('thumbnail'));
            if($thumbnail != '')
            {
                if (!file_exists($thumb_dir)) {
                    mkdir($thumb_dir, 0777, true);
                }
                $thumbnail_image_name = 'thumbnails/'.$template->id.'.' . $thumbnail->getClientOriginalExtension();

                $thumbnail->move($thumb_dir, $thumbnail_image_name);
                $template->thumbnail=$thumbnail_image_name;
            }
            //---thumbnail image end---//

            //---Template style start---//
            $template_style = $request->file('template_style');
            // dd($request->file('photo'));
            if($template_style != '')
            {
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
                $template_style_name = 'template-style.' . $template_style->getClientOriginalExtension();

                $template_style->move($dir, $template_style_name);
                // $template->hero_image=$hero_image_name;
            }
            //---Template style end---//

            //---Logo image start---//
            $logo = $request->file('logo');
            // dd($request->file('photo'));
            if($logo != '')
            {
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
                $logo_name = 'logo.' . $logo->getClientOriginalExtension();

                $logo->move($dir, $logo_name);
                // $template->hero_image=$hero_image_name;
            }
            //---Logo image end---//

            $template->slug = $template->id;
            $template->save();



           echo json_encode(array("type"=>"success", "message"=>"Templates Created Successfully!"));

        } else {
            echo json_encode(array("type"=>"error", "message"=>"Tempmate name is Already exists!"));
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {

        $templates = Template::findOrfail($id);

        $page = $request->page ?? 1;
        $gallery_imgs = GalleryImage::where('template_id',$id)->orderBy('id', 'asc')
        ->paginate(10, ['*'], 'page', $page);

        $no_of_content = $request->no_of_content ?? 1;
        $contents = Content::where('template_id',$id)->orderBy('id', 'asc')
        ->paginate(10, ['*'], 'no_of_content', $no_of_content);

        $perPage = $request->per_page ?? 1;
        $templateButtons = TemplateButton::where('template_id', $id)->orderBy('id', 'asc')
        ->paginate(10, ['*'], 'per_page', $perPage);
        return view('designer.templates.show',compact('templates','gallery_imgs','contents', 'templateButtons'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $templates_url = Session(['templates_url'=> URL::previous()]);
        $types = TemplateType::orderBy('name', 'asc')
        ->pluck('name','id');
        $templates = Template::find($id);
        $contact_icons = json_decode($templates->contact_icons, true);
        $templates->contact_icon_color = $contact_icons['contact_icon_color'];
        $templates->whatsapp_icon_color = $contact_icons['whatsapp_icon_color'];
        $templates->location_icon_color = $contact_icons['location_icon_color'];
        $templates->website_icon_color = $contact_icons['website_icon_color'];
        // dd($contact_icons);
        return view('designer.templates.edit',compact('templates','types','contact_icons'));
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
        $template = Template::find($id);

        $rules = [
            'name' => 'required|max:100',
            'contact_icon_color' => 'required',
         ];

        $messages = [
            'name.required' => 'Template Name is required!',
            'contact_icon_color.required' => 'Contact Icons is required!',
             ];

             $this->validate($request, $rules, $messages);

        $templates_url = Session::get('templates_url');
        $check = Template::where('name', $request->name)->where('id', '<>', $id)->first();

        if (!$check) {
            $dir = base_path('../assets/templates/').$template->id;
            $thumb_dir = base_path('../assets/thumbnails');

            //---background image start---//
            if($request->has('bg_image')){
                $bg_image = $request->file('bg_image');
                // dd($request->file('photo'));
                if($bg_image != '')
                {

                    if (!file_exists($dir)) {
                        mkdir($dir, 0777, true);
                    }
                    $image_name = 'background.' . $bg_image->getClientOriginalExtension();
                    // $folderPath1 = base_path('../assets/templates/');

                    $bg_image->move($dir, $image_name);
                    $template->bg_image=$image_name;

                }
            }
            //---background image end---//

            //---banner image start---//
            if ($request->has('hero_image')) {
                $hero_image = $request->file('hero_image');
               // dd($request->file('photo'));
                if($hero_image != '')
               {
                    if (!file_exists($dir)) {
                        mkdir($dir, 0777, true);
                    }
                    $hero_image_name = 'banner.' . $hero_image->getClientOriginalExtension();

                    $hero_image->move($dir, $hero_image_name);
                    $template->hero_image=$hero_image_name;
                }
            }  else{
                ($template['hero_image']);
                // unset($template['hero_image']);

            }
            //---banner image end---//

            //---thumbnail image start---//
            if ($request->has('thumbnail')) {
                $thumbnail = $request->file('thumbnail');
                //dd($request->file('thumbnail'));
                if($thumbnail != '')
                {
                    if (!file_exists($thumb_dir)) {
                        mkdir($thumb_dir, 0777, true);
                    }
                    $thumbnail_image_name = 'thumbnails/'.$template->id.'.' . $thumbnail->getClientOriginalExtension();

                    $thumbnail->move($thumb_dir, $thumbnail_image_name);
                    $template->thumbnail=$thumbnail_image_name;
                }
            } else {
                ($template['thumbnail']);
            }
            //---thumbnail image end---//

            //---Template style start---//
            if ($request->file('template_style')) {
                $template_style = $request->file('template_style');
                // dd($request->file('photo'));
                if($template_style != '')
                {
                    if (!file_exists($dir)) {
                        mkdir($dir, 0777, true);
                    }
                    $template_style_name = 'template-style.' . $template_style->getClientOriginalExtension();

                    $template_style->move($dir, $template_style_name);
                }
            }
            //---Template style end---//

            //---Logo image start---//
            if ($request->file('logo')) {
                $logo = $request->file('logo');
                // dd($request->file('photo'));
                if($logo != '')
                {
                    if (!file_exists($dir)) {
                        mkdir($dir, 0777, true);
                    }
                    $logo_name = 'logo.' . $logo->getClientOriginalExtension();

                    $logo->move($dir, $logo_name);
                }
            }
            //---Logo image end---//


            $template->name = $request->name;
            $template->bg_color = $request->bg_color;
            $template->default_color = $request->default_color;
            $template->business_name_color = $request->business_name_color;
            $template->tag_line_color = $request->tag_line_color;
            // $template->hero_title = $request->hero_title;
            // $template->hero_title_color = $request->hero_title_color;
            // $template->hero_text = $request->hero_text;
            // $template->hero_text_color = $request->hero_text_color;
            $template->video_url = $request->video_url;
            $template->video_autoplay = $request->video_autoplay;
            // $template->extra_heading_1 = $request->extra_heading_1;
            // $template->extra_heading_1_color = $request->extra_heading_1_color;
            // $template->extra_text_1 = $request->extra_text_1;
            // $template->extra_text_1_color = $request->extra_text_1_color;

            $contact_icons = [
                'contact_icon_color' => $request->contact_icon_color,
                'whatsapp_icon_color' => $request->whatsapp_icon_color,
                'location_icon_color' => $request->location_icon_color,
                'website_icon_color' => $request->website_icon_color
            ];
            $template->contact_icons = json_encode($contact_icons);
            $template->business_type = $request->business_type;
            $template->template_type = $request->template_type;
            $template->is_free = $request->is_free;
            $template->status = $request->status;
            $template->save();

            $template->slug = $template->id;
            $template->save();

            echo json_encode(array("type"=>"success", "message"=>"Templates Update Successfully!", "url"=> $templates_url));

        }   else {
                echo json_encode(array("type"=>"error", "message"=>"Tempmate name is Already exists!"));
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

    public function destroys(request $request){
        //dd($request->all());
        if(!isset($request->type)){
            return response()->json(["status" => false, "message" => 'Please Select Action!']);
        }

        if(!isset($request->ids)){
            return response()->json(["status" => false, "message" => 'Please Select Template!']);
        }

        if (($request->type=='delete')) {
            foreach ($request->ids as $key => $id) {
                $templates = Template::findorfail($id);
                $templates->delete();
            }
            return response()->json(["status" =>true, "message" =>'Templates Deleted!']);
        } else if ($request->type== 0) {
            foreach ($request->ids as $key => $id) {
                $templates = Template::findorfail($id);
                $templates->status = 0;
                $templates->save();
            }
            return response()->json(["status" =>true, "message" =>'Successfully Done !']);
        } else if ($request->type== 1) {
            foreach ($request->ids as $key => $id) {
                $templates = Template::findorfail($id);
                $templates->status = 1;
                $templates->save();
            }
            return response()->json(["status" =>true, "message" =>'Templates Deactivated!']);
        } else {
            return response()->json(["status" =>false, "message" =>'Could Not Successfully Done !']);
        }
    }
}









