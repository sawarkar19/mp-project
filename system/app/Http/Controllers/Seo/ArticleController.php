<?php

namespace App\Http\Controllers\Seo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\SeoController;

use App\Models\ArticlesSetting;
use App\Models\Article;
use App\Models\Tag;

use Auth;
use Illuminate\Support\Str;
use DB;
use Image;
use File;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {    
        $articles=Article::whereIn('role_id',[1,4])->latest()->paginate(20);
        SeoController::sitemapUpdate();

        return view('seo.article.index',compact('articles'));
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
        return view('seo.article.create', compact('all_tags', 'selectTags'));
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
            'article_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ];

        $messages = [
            'title.required' => 'Title can not be empty',
            'description.required' => 'Content can not be empty',
        ];

        $this->validate($request, $rules, $messages);

        $creat_slug = Str::slug($request->title);
        $check = Article::where('slug',$creat_slug)->count();
        if ($check != 0) {
            $slug = $creat_slug.'-'.$check.rand(20,80);
        }
        else{
            $slug = $creat_slug;
        }

        $article_banner = '';
        if($request->article_banner != null){
            $uploadedImage = $this->uploadImage($request);
            if($uploadedImage['status'] == false){
                return response()->json(['status'=>false, 'message'=> $uploadedImage['message']]);
            }else{
                $article_banner = $uploadedImage['file'];
            }
        }

        $article = new Article;
        $article->user_id = Auth::user()->id;
        $article->role_id = Auth::user()->role_id;
        $article->title = $request->title;
        $article->slug = $slug;
        $article->image = $article_banner;
        $article->content = $request->description;
        $article->tags = $request->tag;
        $article->meta_title = $request->meta_title;
        $article->meta_keyword = $request->meta_keyword;
        $article->meta_description = $request->meta_description;
        $article->status = $request->status;
        $article->featured = $request->featured;
        $article->save();

        SeoController::sitemapUpdate();
        
		return response()->json([
            'status' => true,
            'message' => 'Article Added Successfully',
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
        $articleInfo = Article::find($id); 
        $all_tags = Tag::get(['id','tag']);

        $selectTags=array();
        
        if($articleInfo->tags != null){
            $tags = $articleInfo->tags;
            $selectTags = explode(',', $tags);
        }       
        
        return view('seo.article.edit',compact('articleInfo', 'all_tags', 'selectTags'));
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
        // dd($request->file('article_banner'));
        $rules = [
            'title' => 'required|max:100', 
            'description' => 'required',
            'article_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ];

        $messages = [
            'title.required' => 'Title can not be empty',
            'description.required' => 'Content can not be empty',
        ];

        $this->validate($request, $rules, $messages);

        $article = Article::find($id);

        // dd($article->image);
        $article_banner = '';
        if($request->hasFile('article_banner'))
        {
            $uploadedImage = $this->uploadImage($request);
            if($uploadedImage['status'] == false){
                return response()->json(['status'=>false, 'message'=> $uploadedImage['message']]);
            }else{
                $article_banner = $uploadedImage['file'];
            }
        }else{
            $article_banner = $article->image;
        }

        $tags = '';
        if($request->tags){
            $tags = implode(',', $request->tags);
        }

        $article->title = $request->title;
        $article->image = $article_banner;
        $article->content = $request->description;
        $article->tags = $tags;
        $article->meta_title = $request->meta_title;
        $article->meta_keyword = $request->meta_keyword;
        $article->meta_description = $request->meta_description;
        $article->status = $request->status;
        $article->featured = $request->featured;
        $article->updated_at = $request->updated_at;
        $article->save();
        
        SeoController::sitemapUpdate();

        return response()->json([
            'status' => true,
            'message' => 'Article Updated Successfully',
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
               Article::destroy($id);
            }

            SeoController::sitemapUpdate();

            return response()->json('Successfully deleted');
        }else{
            return response()->json('Please select article');
        }
        
    }

    public function uploadImage($request){

        if($request->hasFile('article_banner'))
        {
            $image = $request->file('article_banner');
            $extension = $image->getClientOriginalExtension();
            $size = $image->getSize();
            $extension = $image->getClientOriginalExtension();
            $fileName = 'openlink-'.date('dmYhis',time()) . '.' . $extension;

            $destinationPath = base_path('../assets/articles/banners/');
            if(!File::isDirectory($destinationPath)){
                File::makeDirectory($destinationPath, 0777, true, true);
            }
            
            $image_resize = Image::make($image->getRealPath());
            //$image_resize->resize(318,159);
            $image_resize->save($destinationPath. $fileName);

            return ['status'=>true, 'file' => $fileName];

        }else{
            return ['status'=>false, 'message'=> 'Please select an Article Image.'];
        }
    }

    // Upload image from CK EDITOR
    public function upload(Request $request)
    {
        $target_dir = base_path('../assets/articles/banners/');
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

        $filename = 'article-'.date('dmYhis',time()) . '.' . $imageFileType;
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

                $url = url('assets/articles/banners/'.$filename);
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

        $settings = ArticlesSetting::first();
        // dd($settings);

        return view('seo.article.settings', compact('settings'));
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

        ArticlesSetting::where('id', 1)
        ->update([
            'title'=> $request->title,
            'description'=>$request->description
        ]);

        return json_encode(array("type"=>"success", "message"=>"Article Settings Successfully Updated."));
        // dd($request);
    }

    public function updateSettings2(Request $request){

        ArticlesSetting::where('id', 1)
        ->update([
            'show_subscription'=>$request->subscribe_form,
            'show_category'=>$request->categories,
            'show_top_post'=>$request->top_posts
        ]);

        return json_encode(array("type"=>"success", "message"=>"Article Settings Successfully Updated."));
        // dd($request);
    }

    public function updateSettings3(Request $request){

        $rules = [
            'meta_title' => 'required',
        ];

        $messages = [
            'meta_title.required' => 'Title can not be empty',
        ];

        $this->validate($request, $rules, $messages);

        ArticlesSetting::where('id', 1)
        ->update([
            'meta_title'=> $request->meta_title,
            'meta_description'=>$request->meta_description,
            'meta_keywords'=>$request->meta_keywords
        ]);

        return json_encode(array("type"=>"success", "message"=>"Article page SEO details are updated."));
        // dd($request);
    }


    public function destroyArticle(Request $request, $id)
    {
        Article::destroy($id);

        SeoController::sitemapUpdate();

        return response()->json([
            'status' => true,
            'message' => 'Article deleted successfully'
        ]);
    }

    public function changeArticleStatus(Request $request, $id)
    {
        $page = Article::findorFail($id);
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
            'message' => 'Article status changed successfully'
        ]);
    }
}
