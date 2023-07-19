<?php

namespace App\Http\Controllers\Designer;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\GalleryImage;
use App\Models\Template;
use Session;
use URL;
use DB;
use Redirect;

class GalleryImageController extends Controller
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
    public function index()
    {
        $gallery_imgs = GalleryImage::orderBy('id', 'desc')
           ->take(10)
           ->paginate(10)
           ->get();
            // dd($gallery_imgs);

           

         $gallery_imgs_url = Session(['gallery_imgs_url'=>'#']);
         
         return view('designer.templates.show', compact('gallery_imgs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $template_id = $request->id;
        $gallery_imgs = array();
        
        
        
        return view('designer.galleryimages.create', compact('gallery_imgs','template_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        if ($request->has('image_path')) {

            $count = GalleryImage::where('template_id',$request->template_id)->count();

            $num = $count + 1;
             
            $gallery_img = new GalleryImage();
            $gallery_img->template_id = $request->template_id;
            $gallery_img->title = $request->title;
            $gallery_img->title_color = $request->title_color;
            $gallery_img->tag_1 = $request->tag_1;
            $gallery_img->show_tag_1 = $request->show_tag_1 ?? 0;
            $gallery_img->tag_1_bg_color = $request->tag_1_bg_color;
            $gallery_img->tag_2 = $request->tag_2;
            $gallery_img->show_tag_2 = $request->show_tag_2 ?? 0;
            $gallery_img->tag_2_bg_color = $request->tag_2_bg_color;
            $gallery_img->sale_price = $request->sale_price;
            $gallery_img->show_sale_price = $request->show_sale_price ?? 0;
            $gallery_img->price = $request->price;
            $gallery_img->show_price = $request->show_price ?? 0;
            
            $temp_dir = base_path('../assets/templates/').$request->template_id;

            $image_path = $request->file('image_path');
            if ($image_path != '') {
                
                if (!file_exists($temp_dir)) {
                    mkdir($temp_dir, 0777, true);
                }
                $image_path_name = 'img-'.$num.'.' .$image_path->getClientOriginalExtension();
                $image_path->move($temp_dir, $image_path_name);
                $gallery_img->image_path=$image_path_name;
            }

            $gallery_img->save();

            $url = route('designer.templates.show',$request->template_id);

            echo json_encode(array("type"=>"success", "message"=>"Gallery Created Successfully!", "url" => $url));
        } else {
            echo json_encode(array("type"=>"error", "message"=>"Gallery Image is Required!"));
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
    public function edit(Request $request, $id)
    {
        $gallery_imgs_url = Session(['gallery_imgs_url'=> URL::previous()]);
        
        $gallery_imgs = GalleryImage::find($id);
        $template_id = $request->id;

        return view('designer.galleryimages.edit', compact('gallery_imgs','template_id'));
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
        $gallery_imgs_url = Session::get('gallery_imgs_url');
        $gallery_img = GalleryImage::find($id);
        $gallery_img->title = $request->title;
        $gallery_img->title_color = $request->title_color;
        $gallery_img->tag_1 = $request->tag_1;
        $gallery_img->show_tag_1 = $request->show_tag_1;
        $gallery_img->tag_1_bg_color = $request->tag_1_bg_color;
        $gallery_img->tag_2 = $request->tag_2;
        $gallery_img->show_tag_2 = $request->show_tag_2;
        $gallery_img->tag_2_bg_color = $request->tag_2_bg_color;
        $gallery_img->sale_price = $request->sale_price;
        $gallery_img->show_sale_price = $request->show_sale_price;
        $gallery_img->price = $request->price;
        $gallery_img->show_price = $request->show_price;

        if ($request->has('image_path')) {
    
            $temp_dir = base_path('../assets/templates/').$request->template_id;
            //---gallery image start---//
            
            $image_path = $request->file('image_path');
            if ($image_path != '') {
                
                if (!file_exists($temp_dir)) {
                    mkdir($temp_dir, 0777, true);
                }
                $image_path_name = 'img-.' .$image_path->getClientOriginalExtension();
                $image_path->move($temp_dir, $image_path_name);
                $gallery_img->image_path=$image_path_name;
            }
        
            //---gallery image end---//
        } 

        $gallery_img->save();

        echo json_encode(array("type"=>"success", "message"=>"Gallery Update Successfully!", "url"=> $gallery_imgs_url));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroyPage(Request $request, $id)
    {
        GalleryImage::destroy($id);

        return response()->json([
            'status' => true,
            'message' => 'Gallery Image Deleted Successfully !',
        ]);
    }
}