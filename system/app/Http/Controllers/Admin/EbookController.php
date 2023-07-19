<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\SeoController;

use App\Models\EbooksSetting;
use App\Models\Ebook;
use App\Models\Tag;

use Auth;
use Illuminate\Support\Str;
use DB;
use Image;
use File;

class EbookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {    

        $ebooks=Ebook::whereIn('role_id',[1,4])->latest()->paginate(20);
        SeoController::sitemapUpdate();

        return view('admin.ebook.index',compact('ebooks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $all_tags = Tag::get(['id','tag']);
        $selectTags = array();
        return view('admin.ebook.create', compact('all_tags', 'selectTags'));
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
            'title' => 'required|max:100', 
            'description' => 'required',
            'ebook_name' => 'required|mimes:pdf|max:10000',
            'ebook_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ];

        $messages = [
            'title.required' => 'Title can not be empty',
            'description.required' => 'Content can not be empty',
            'ebook_name.required' => 'Please upload ebook attachment',
            'ebook_name.mimes' => 'Ebook attachment type should be PDF',
        ];

        $this->validate($request, $rules, $messages);

        $creat_slug = Str::slug($request->title);
        $check = Ebook::where('slug',$creat_slug)->count();
        if ($check != 0) {
            $slug = $creat_slug.'-'.$check.rand(20,80);
        }
        else{
            $slug = $creat_slug;
        }

        $ebook_banner = '';
        if($request->ebook_banner != null){
            $uploadedImage = $this->uploadImage($request);
            if($uploadedImage['status'] == false){
                return response()->json(['status'=>false, 'message'=> $uploadedImage['message']]);
            }else{
                $ebook_banner = $uploadedImage['file'];
            }
        }

        //pdf upload
        $ebook_name = 'Ebook-'.time().'.'.$request->file('ebook_name')->extension();
        $destinationPath = base_path('../assets/ebooks/attachments/');  
        $request->file('ebook_name')->move($destinationPath, $ebook_name);
        if(!file_exists($destinationPath.'/'.$ebook_name)){
            return response()->json(['status'=>false, 'message'=> 'Ebook not uploaded.']);
        }

        $ebook = new Ebook;
        $ebook->user_id = Auth::user()->id;
        $ebook->role_id = Auth::user()->role_id;
        $ebook->title = $request->title;
        $ebook->slug = $slug;
        $ebook->ebook_name = $ebook_name;
        $ebook->image = $ebook_banner;
        $ebook->content = $request->description;
        $ebook->tags = $request->tag;
        $ebook->meta_title = $request->meta_title;
        $ebook->meta_keyword = $request->meta_keyword;
        $ebook->meta_description = $request->meta_description;
        $ebook->status = $request->status;
        $ebook->featured = $request->featured;
        $ebook->save();

        SeoController::sitemapUpdate();
        
		return response()->json([
            'status' => true,
            'message' => 'Ebook Added Successfully',
        ]);
    } 

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ebookInfo = Ebook::find($id); 
        $all_tags = Tag::get(['id','tag']);

        $selectTags=array();
        
        if($ebookInfo->tags != null){
            $tags = $ebookInfo->tags;
            $selectTags = explode(',', $tags);
        }       
        
        return view('admin.ebook.edit',compact('ebookInfo', 'all_tags', 'selectTags'));
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
        // dd($request->file('ebook_banner'));
        $rules = [
            'title' => 'required|max:100', 
            'description' => 'required',
            'ebook_name' => 'nullable|mimes:pdf|max:10000',
            'ebook_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ];

        $messages = [
            'title.required' => 'Title can not be empty',
            'description.required' => 'Content can not be empty',
            'ebook_name.mimes' => 'Ebook attachment type should be PDF',
        ];

        $this->validate($request, $rules, $messages);

        $ebook = Ebook::find($id);

        // dd($ebook->image);
        $ebook_banner = '';
        if($request->hasFile('ebook_banner'))
        {
            $uploadedImage = $this->uploadImage($request);
            if($uploadedImage['status'] == false){
                return response()->json(['status'=>false, 'message'=> $uploadedImage['message']]);
            }else{
                $ebook_banner = $uploadedImage['file'];
            }
        }else{
            $ebook_banner = $ebook->image;
        }

        $tags = '';
        if($request->tags){
            $tags = implode(',', $request->tags);
        }

        //pdf upload
        $ebook_name = '';
        if($request->hasFile('ebook_name'))
        {
            $ebook_name = 'Ebook-'.time().'.'.$request->file('ebook_name')->extension();
            $destinationPath = base_path('../assets/ebooks/attachments/');  
            $request->file('ebook_name')->move($destinationPath, $ebook_name);
            if(!file_exists($destinationPath.'/'.$ebook_name)){
                return response()->json(['status'=>false, 'message'=> 'Ebook not uploaded.']);
            }
        }else{
            $ebook_name = $ebook->ebook_name;
        }

        

        $ebook->title = $request->title;
        $ebook->image = $ebook_banner;
        $ebook->ebook_name = $ebook_name;
        $ebook->content = $request->description;
        $ebook->tags = $tags;
        $ebook->meta_title = $request->meta_title;
        $ebook->meta_keyword = $request->meta_keyword;
        $ebook->meta_description = $request->meta_description;
        $ebook->status = $request->status;
        $ebook->featured = $request->featured;
        $ebook->save();
        SeoController::sitemapUpdate();

        return response()->json([
            'status' => true,
            'message' => 'Ebook Updated Successfully',
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
               Ebook::destroy($id);
            }
            SeoController::sitemapUpdate();

            return response()->json('Successfully deleted');
        }else{
            return response()->json('Please select ebook');
        }
        
    }

    public function uploadImage($request){

        if($request->hasFile('ebook_banner'))
        {
            $image = $request->file('ebook_banner');
            $extension = $image->getClientOriginalExtension();
            $size = $image->getSize();
            $extension = $image->getClientOriginalExtension();
            $fileName = 'openlink-'.date('dmYhis',time()) . '.' . $extension;

            $destinationPath = base_path('../assets/ebooks/banners/');
            if(!File::isDirectory($destinationPath)){
                File::makeDirectory($destinationPath, 0777, true, true);
            }
            
            $image_resize = Image::make($image->getRealPath());
            //$image_resize->resize(318,159);
            $image_resize->save($destinationPath. $fileName);

            return ['status'=>true, 'file' => $fileName];

        }else{
            return ['status'=>false, 'message'=> 'Please select an Ebook Image.'];
        }
    }

    // Upload image from CK EDITOR
    public function upload(Request $request)
    {
        $target_dir = base_path('../assets/ebooks/banners/');
        if(!File::isDirectory($target_dir)){
            File::makeDirectory($target_dir, 0777, true, true);
        }

        $target_file = $target_dir . basename($_FILES["upload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["upload"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
        }

        $filename = 'ebook-'.date('dmYhis',time()) . '.' . $imageFileType;
        $saveFile = $target_dir .$filename;
        // Check if file already exists
        if (file_exists($saveFile)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["upload"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {

            if (move_uploaded_file($_FILES["upload"]["tmp_name"], $saveFile)) {

                $CKEditorFuncNum = $request->input('CKEditorFuncNum');

                $url = url('assets/ebooks/banners/'.$filename);
                $msg = 'Image uploaded successfully';
                $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
                @header('Content-type: text/html; charset=utf-8');
                echo $response;
                
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }

    }

    public function add_tags(Request $request){

        if($request->tag){
            $tag = Tag::updateOrCreate([
                'tag' => $request->tag,
            ]);

           return json_encode(array("type"=>"success", "data" => $tag, "message"=>"Successfully Added."));
        }
    }

    public function settings(Request $request){

        $settings = EbooksSetting::first();
        // dd($settings);

        return view('admin.ebook.settings', compact('settings'));
    }

    public function updateSettings1(Request $request){

        $rules = [
            'title' => 'required', 
            'description' => 'required'
        ];

        $messages = [
            'title.required' => 'Title can not be empty',
            'description.required' => 'Content can not be empty',
        ];

        $this->validate($request, $rules, $messages);

        EbooksSetting::where('id', 1)
        ->update([
            'title'=> $request->title,
            'description'=>$request->description
        ]);

        return json_encode(array("type"=>"success", "message"=>"Ebook Settings Successfully Updated."));
        // dd($request);
    }

    public function updateSettings2(Request $request){

        EbooksSetting::where('id', 1)
        ->update([
            'show_subscription'=>$request->subscribe_form,
            'show_category'=>$request->categories,
            'show_top_post'=>$request->top_posts
        ]);

        return json_encode(array("type"=>"success", "message"=>"Ebook Settings Successfully Updated."));
        // dd($request);
    }

    public function destroyEbook(Request $request, $id)
    {
        Ebook::destroy($id);
        SeoController::sitemapUpdate();

        return response()->json([
            'status' => true,
            'message' => 'Ebook deleted successfully'
        ]);
    }

    public function changeEbookStatus(Request $request, $id)
    {
        $page = Ebook::findorFail($id);
        if($page->status == 1){
            $status = 0;
            $hide = 'active-badge';
            $show = 'deactive-badge';
        }else{
            $status = 1;
            $hide = 'deactive-badge';
            $show = 'active-badge';
        }
        $page->status = $status;
        $page->save();

        SeoController::sitemapUpdate();
        
        return response()->json([
            'status' => true,
            'hide' => $hide,
            'show' => $show,
            'message' => 'Ebook status changed successfully'
        ]);
    }
}
