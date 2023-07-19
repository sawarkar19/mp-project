<?php

namespace App\Http\Controllers\Admin;

use DB;
use Auth;
use File;
use Image;

use App\Models\Category;


use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Documentation;
use App\Models\DocumentCategory;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\SeoController;

class DocumentationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {    
        $documentations=Documentation::whereIn('role_id',[1,4])->latest()->paginate(20);
        SeoController::sitemapUpdate();

        return view('admin.documentation.index',compact('documentations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $all_tags = DocumentCategory::get(['id','name']);
        $selectTags = array();
        // dd($selectTags);
        return view('admin.documentation.create', compact('all_tags', 'selectTags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $maxValue = Documentation::max('ordering');
        $result_max = $maxValue + 1;

        $rules = [
            'title' => 'required|max:300', 
            'description' => 'required',
            'documentation_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ];

        $messages = [
            'title.required' => 'Title can not be empty',
            'description.required' => 'Content can not be empty',
        ];

        $this->validate($request, $rules, $messages);

        $creat_slug = Str::slug($request->title);
        $check = Documentation::where('slug',$creat_slug)->count();
        if ($check != 0) {
            $slug = $creat_slug.'-'.$check.rand(20,80);
        }
        else{
            $slug = $creat_slug;
        }

        $documentation_banner = '';
        if($request->documentation_banner != null){
            $uploadedImage = $this->uploadImage($request);
            if($uploadedImage['status'] == false){
                return response()->json(['status'=>false, 'message'=> $uploadedImage['message']]);
            }else{
                $documentation_banner = $uploadedImage['file'];
            }
        }


        // $tags = '';
        // if($request->tags){
        //     $tags = implode(',', $request->tags);
        // }

        $documentation = new Documentation;
        $documentation->user_id = Auth::user()->id;
        $documentation->role_id = Auth::user()->role_id;
        $documentation->title = $request->title;
        $documentation->slug = $slug;
        $documentation->image = $documentation_banner;
        $documentation->content = $request->description;
        $documentation->document_category_id = $request->tags;
        $documentation->meta_title = $request->meta_title;
        $documentation->meta_keyword = $request->meta_keyword;
        $documentation->meta_description = $request->meta_description;
        $documentation->status = $request->status;
        $documentation->ordering = $result_max;
        // dd($documentation);
        $documentation->save();

        SeoController::sitemapUpdate();
        
		return response()->json([
            'status' => true,
            'message' => 'Documentation Added Successfully !',
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
        $documentationInfo = Documentation::find($id); 
        
        // dd($documentationInfo);
        $all_tags = DocumentCategory::get(['id','name']);
        
        // $selectTags=array();
        
        if($documentationInfo->document_category_id != null){

            $selectTags = $documentationInfo->document_category_id;
            // dd($selectTags);
            
            // $selectTags = explode(',', $tags);
        }      

        return view('admin.documentation.edit',compact('documentationInfo', 'all_tags', 'selectTags'));
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
        $maxordering = Documentation::where('ordering', $request->ordering)->first();

        $rules = [
            'title' => 'required|max:300', 
            'description' => 'required',
            'documentation_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ];

        $messages = [
            'title.required' => 'Title can not be empty',
            'description.required' => 'Content can not be empty',
        ];

        $this->validate($request, $rules, $messages);

        $documentation = Documentation::find($id);
        $oldDocId = $documentation->ordering;

        // dd($documentation->image);
        $documentation_banner = '';
        if($request->hasFile('documentation_banner'))
        {
            $uploadedImage = $this->uploadImage($request);
            if($uploadedImage['status'] == false){
                return response()->json(['status'=>false, 'message'=> $uploadedImage['message']]);
            }else{
                $documentation_banner = $uploadedImage['file'];
            }
        }else{
            $documentation_banner = $documentation->image;
        }

        // $tags = '';
        // if($request->tags){
        //     $tags = implode(',', $request->tags);
        // }

        $documentation->title = $request->title;
        $documentation->image = $documentation_banner;
        $documentation->content = $request->description;
        $documentation->document_category_id = $request->tags;
        $documentation->meta_title = $request->meta_title;
        $documentation->meta_keyword = $request->meta_keyword;
        $documentation->meta_description = $request->meta_description;
        $documentation->status = $request->status;
        $documentation->ordering = $request->ordering;
        if ($maxordering != null) {
            $maxordering->ordering = $oldDocId;
            $maxordering->save();
        }
        $documentation->updated_at = $request->updated_at;
        $documentation->save();

        SeoController::sitemapUpdate();

        return response()->json([
            'status' => true,
            'message' => 'Documentation Updated Successfully',
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
                Documentation::destroy($id);
            }

            SeoController::sitemapUpdate();

            return response()->json('Successfully deleted');
        }else{
            return response()->json('Please select Documentation');
        }
        
    }

    public function uploadImage($request){

        if($request->hasFile('documentation_banner'))
        {
            $image = $request->file('documentation_banner');
            $extension = $image->getClientOriginalExtension();
            $size = $image->getSize();
            $extension = $image->getClientOriginalExtension();
            $fileName = 'openlink-'.date('dmYhis',time()) . '.' . $extension;

            $destinationPath = base_path('../assets/documentations/banners/');
            if(!File::isDirectory($destinationPath)){
                File::makeDirectory($destinationPath, 0777, true, true);
            }
            
            $image_resize = Image::make($image->getRealPath());
            //$image_resize->resize(318,159);
            $image_resize->save($destinationPath. $fileName);

            return ['status'=>true, 'file' => $fileName];

        }else{
            return ['status'=>false, 'message'=> 'Please select an Documentation Image.'];
        }
    }

    // Upload image from CK EDITOR
    public function upload(Request $request)
    {
        $target_dir = base_path('../assets/documentations/banners/');
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

        $filename = 'documentation-'.date('dmYhis',time()) . '.' . $imageFileType;
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

                $url = url('assets/documentations/banners/'.$filename);
                $msg = 'Image uploaded successfully';
                $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
                @header('Content-type: text/html; charset=utf-8');
                echo $response;
                
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }

    }

    // public function add_tags(Request $request){

    //     if($request->tags){
    //         $tag = DocumentCategory::updateOrCreate([
    //             'name' => $request->tags,
    //         ]);

    //        return json_encode(array("type"=>"success", "data" => $tag, "message"=>"Successfully Added."));
    //     }
    // }

    // public function settings(Request $request){

    //     $settings = documentationsSetting::first();
    //     // dd($settings);

    //     return view('admin.documentation.settings', compact('settings'));
    // }

    // public function updateSettings1(Request $request){

    //     $rules = [
    //         'title' => 'required', 
    //         'description' => 'required'
    //     ];

    //     $messages = [
    //         'title.required' => 'Title can not be empty',
    //         'description.required' => 'Content can not be empty',
    //     ];

    //     $this->validate($request, $rules, $messages);

    //     documentationsSetting::where('id', 1)
    //     ->update([
    //         'title'=> $request->title,
    //         'description'=>$request->description
    //     ]);

    //     return json_encode(array("type"=>"success", "message"=>"documentation Settings Successfully Updated."));
    //     // dd($request);
    // }

    // public function updateSettings2(Request $request){

    //     documentationsSetting::where('id', 1)
    //     ->update([
    //         'show_subscription'=>$request->subscribe_form,
    //         'show_category'=>$request->categories,
    //         'show_top_post'=>$request->top_posts
    //     ]);

    //     return json_encode(array("type"=>"success", "message"=>"documentation Settings Successfully Updated."));
    //     // dd($request);
    // }

    public function destroyDocumentation(Request $request, $id)
    {
        documentation::destroy($id);

        SeoController::sitemapUpdate();

        return response()->json([
            'status' => true,
            'message' => 'Documentation deleted successfully !'
        ]);
    }

    public function changeDocumentationStatus(Request $request, $id)
    {
        $page = Documentation::findorFail($id);
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
            'message' => 'Documentation status changed successfully !'
        ]);
    }
}
