<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\SeoController;

use App\Models\Page;
use App\Models\Seo;

use Str;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $pages = Page::with('seo')->orderBy('id', 'DESC')->paginate(20);
        SeoController::sitemapUpdate();

        return view('admin.page.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('admin.page.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $this->validate($request, [
            'title' => 'required',
            'url' => 'required',
        ]);

        $creat_slug = Str::slug($request->title);
        $check = Page::where('slug',$creat_slug)->count();
        if ($check != 0) {
            $slug = $creat_slug.'-'.$check.rand(20,80);
        }
        else{
            $slug = $creat_slug;
        }

        $url_check = Page::where('url',$request->url)->count();
        if ($url_check != 0) {
            return response()->json([
                'status' => false,
                'message' => 'Page with same URL already exists.',
            ]);
        }

        $page = Page::Create([ 
                    'title' => $request->title,
                    'slug' => $slug,
                    'url' => $request->url,
                    'status' => $request->status,
                ]);

        if($page){

                $seo = Seo::Create([ 
                        'page_id' => $page->id,
                        'meta_title' => $request->meta_title ?? '',
                        'meta_keyword' => $request->meta_keyword ?? '',
                        'meta_description' => $request->meta_description ?? '',
                    ]);

            SeoController::sitemapUpdate();

            return response()->json([
                'status' => true,
                'message' => 'Page Saved Successfully !',
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Page Saving Failed !',
            ]);
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
    public function edit($id)
    {
        $page = Page::with('seo')->where('id',$id)->first();
        // dd($page);
        return view('admin.page.edit', compact('page'));
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
        $creat_slug = Str::slug($request->title);
        $check = Page::where('slug',$creat_slug)->count();
        if ($check != 0) {
            $slug = $creat_slug;
            // $slug = $creat_slug.'-'.$check.rand(20,80);
        }
        else{
            $slug = $creat_slug;
        }

        $this->validate($request, [
            'title' => 'required',
            'url' => 'required',
        ]);

        $page = Page::find($id);
        $page->title = $request->title;
        $page->slug = $slug;
        $page->url = $request->url;
        $page->status = $request->status;
        $page->save();

        if($page){

            $seo = Seo::where('page_id',$page->id)->first();
            $seo->meta_title = $request->meta_title;
            $seo->meta_keyword = $request->meta_keyword;;
            $seo->meta_description = $request->meta_description;
            $seo->save();

            SeoController::sitemapUpdate();

            return response()->json([
                'status' => true,
                'message' => 'Page Updated Successfully !',
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Page Updated Failed !',
            ]);
        }
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
                $page_seo = Seo::where('page_id',$id)->first();
                Seo::destroy($page_seo->id);
                Page::destroy($id);
            }

            SeoController::sitemapUpdate();

            return response()->json('Successfully deleted !');
        }else{
            return response()->json('Please select page !');
        }
    }

    public function destroyPage(Request $request, $id)
    {
        $page_seo = Seo::where('page_id',$id)->first();
        Seo::destroy($page_seo->id);
        Page::destroy($id);

        SeoController::sitemapUpdate();

        return response()->json([
            'status' => true,
            'message' => 'Page deleted successfully !'
        ]);
    }

    public function changePageStatus(Request $request, $id)
    {
        $page = Page::findorFail($id);
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
            'message' => 'Page status changed successfully !'
        ]);
    }
}
