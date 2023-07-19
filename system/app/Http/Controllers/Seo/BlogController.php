<?php

namespace App\Http\Controllers\Seo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\BlogsSetting;
use App\Models\Blog;
use App\Models\Tag;

use Auth;
use Illuminate\Support\Str;
use DB;
use Image;
use File;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {    
        $blogs=Blog::whereIn('role_id',[1,4])->latest()->paginate(20);
        return view('seo.blog.index',compact('blogs'));
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
        return view('seo.blog.create', compact('all_tags', 'selectTags'));
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
            'blog_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ];

        $messages = [
            'description.required' => 'Content can not be empty',
        ];

        $this->validate($request, $rules, $messages);

        $creat_slug = Str::slug($request->title);
        $check = Blog::where('slug',$creat_slug)->count();
        if ($check != 0) {
            $slug = $creat_slug.'-'.$check.rand(20,80);
        }
        else{
            $slug = $creat_slug;
        }

        $blog_banner = '';
        if($request->blog_banner != null){
            $uploadedImage = $this->uploadImage($request);
            if($uploadedImage['status'] == false){
                return response()->json(['status'=>false, 'message'=> $uploadedImage['message']]);
            }else{
                $blog_banner = $uploadedImage['file'];
            }
        }

        $blog = new Blog;
        $blog->user_id = Auth::user()->id;
        $blog->role_id = Auth::user()->role_id;
        $blog->title = $request->title;
        $blog->slug = $slug;
        $blog->image = $blog_banner;
        $blog->content = $request->description;
        $blog->tags = $request->tag;
        $blog->meta_title = $request->meta_title;
        $blog->meta_keyword = $request->meta_keyword;
        $blog->meta_description = $request->meta_description;
        #$blog->status = $request->status;
        $blog->status = 0;
        $blog->featured = $request->featured;
        $blog->save();

        
		return response()->json([
            'status' => true,
            'message' => 'Blog Added Successfully',
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
        $blogInfo = Blog::find($id); 
        $all_tags = Tag::get(['id','tag']);

        $selectTags=array();
        
        if($blogInfo->tags != null){
            $tags = $blogInfo->tags;
            $selectTags = explode(',', $tags);
        }       
        
        return view('seo.blog.edit',compact('blogInfo', 'all_tags', 'selectTags'));
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
        // dd($request->file('blog_banner'));
        $rules = [
            'title' => 'required|max:100', 
            'slug' => 'required|max:200', 
            'description' => 'required',
            'blog_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ];

        $messages = [
            'description.required' => 'Content can not be empty',
        ];

        $this->validate($request, $rules, $messages);

        $blog = Blog::find($id);

        // dd($blog->image);
        $blog_banner = '';
        if($request->hasFile('blog_banner'))
        {

            /* Delete from banner folder start */
            $file_path = base_path('../assets/blogs/banners/'.$blog['image']);
            $file_path_thumbnails = base_path('../assets/blogs/banners/thumbnails/'.$blog['image']);
            //You can also check existance of the file in storage.
            if(file_exists($file_path)) {
               @unlink($file_path); 
               @unlink($file_path_thumbnails); 
            }
            /*  Delete from banner folder end */  

            $uploadedImage = $this->uploadImage($request);
            if($uploadedImage['status'] == false){
                return response()->json(['status'=>false, 'message'=> $uploadedImage['message']]);
            }else{
                $blog_banner = $uploadedImage['file'];
            }
        }else{
            $blog_banner = $blog->image;
        }

        $tags = '';
        if($request->tags){
            $tags = implode(',', $request->tags);
        }

        $blog->title = $request->title;
        $blog->slug = $request->slug;
        $blog->image = $blog_banner;
        $blog->content = $request->description;
        $blog->tags = $tags;
        $blog->meta_title = $request->meta_title;
        $blog->meta_keyword = $request->meta_keyword;
        $blog->meta_description = $request->meta_description;
        #$blog->status = $request->status;
        $blog->status = 0;
        $blog->featured = $request->featured;
        $blog->save();

        return response()->json([
            'status' => true,
            'message' => 'Blog Updated Successfully',
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
               Blog::destroy($id);
            }
            return response()->json('Successfully deleted');
        }else{
            return response()->json('Please select blog');
        }
        
    }

    public function uploadImage($request){

        if($request->hasFile('blog_banner'))
        {
            $image = $request->file('blog_banner');
            $extension = $image->getClientOriginalExtension();
            $size = $image->getSize();
            $extension = $image->getClientOriginalExtension();
            $fileName = 'openlink-'.date('dmYhis',time()) . '.' . $extension;

            /* thumbnails start */
            $destinationPath = base_path('../assets/blogs/banners/thumbnails/');
            $img = Image::make($image->path());
            $img->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath. $fileName);
            /* thumbnails end */
            $destinationPath = base_path('../assets/blogs/banners/');
            $img = Image::make($image->path());
            // $img->resize(1024, 1024, function ($constraint) {
            //     $constraint->aspectRatio();
            // });
            if(!File::isDirectory($destinationPath)){
                File::makeDirectory($destinationPath, 0777, true, true);
            }
            
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(1024 ,1024,function ($constraint) {
            $constraint->aspectRatio();
            })->save($destinationPath. $fileName);

            return ['status'=>true, 'file' => $fileName];

        }else{
            return ['status'=>false, 'message'=> 'Please select an Blog Image.'];
        }
    }

    // Upload image from CK EDITOR
    public function upload(Request $request)
    {
        $target_dir = base_path('../assets/blogs/banners/');
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

        $filename = 'blog-'.date('dmYhis',time()) . '.' . $imageFileType;
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

                $url = url('assets/blogs/banners/'.$filename);
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

        $settings = BlogsSetting::first();
        // dd($settings);

        return view('seo.blog.settings', compact('settings'));
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

        BlogsSetting::where('id', 1)
        ->update([
            'title'=> $request->title,
            'description'=>$request->description
        ]);

        return json_encode(array("type"=>"success", "message"=>"Blog Settings Successfully Updated."));
        // dd($request);
    }

    public function updateSettings2(Request $request){

        BlogsSetting::where('id', 1)
        ->update([
            'show_subscription'=>$request->subscribe_form,
            'show_category'=>$request->categories,
            'show_top_post'=>$request->top_posts
        ]);

        return json_encode(array("type"=>"success", "message"=>"Blog Settings Successfully Updated."));
        // dd($request);
    }
}
