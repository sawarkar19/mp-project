<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use samdark\sitemap\Sitemap;
use samdark\sitemap\Index;
use Auth;

use App\Models\Option;
use App\Models\User;
use App\Models\Page;
use App\Models\Blog;
use App\Models\Ebook;
use App\Models\Article;

class SeoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings=Option::where('key','seo')->first();
        $info=json_decode($settings->value ?? '');

        return view('admin.seo.index',compact('info'));
    }

 
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $seo['title']=$request->title;
        $seo['description']=$request->description;
        $seo['canonical']=$request->canonical;
        $seo['tags']=$request->tags;
        $seo['twitterTitle']=$request->twitterTitle;
        $seo['image_path']=$request->image_path;

        $json=json_encode($seo);

        $settings=Option::where('key','seo')->first();
        if (empty($settings)) {
            $settings=new Option;
            $settings->key="seo";
        }
        $settings->value=$json;
        $settings->save();
        return response()->json('Site Seo Updated');
        
    }

    public function sitemap(Request $request){
        $pages=Page::where('status',1)->get();
        $blogs=Blog::where('status',1)->get();
        $ebooks=Ebook::where('status',1)->get();
        $articles=Article::where('status',1)->get();


        /*Pages*/
        $page_index = new Index(base_path('pages-sitemap.xml'));
        $page_index->addSitemap(url('/'));
        foreach ($pages as $key => $row) {
            $page_index->addSitemap(url('/pages',$row->slug));
        }
           
        $check= $page_index->write();

        /*Blogs*/
        $blog_index = new Index(base_path('blogs-sitemap.xml'));
        $blog_index->addSitemap(url('/'));
        foreach ($blogs as $key => $row) {
            $blog_index->addSitemap(url('/blogs',$row->slug));
        }
           
        $check= $blog_index->write();


        /*Ebooks*/
        $ebook_index = new Index(base_path('ebooks-sitemap.xml'));
        $ebook_index->addSitemap(url('/'));
        foreach ($ebooks as $key => $row) {
            $ebook_index->addSitemap(url('/ebooks',$row->slug));
        }
           
        $check= $ebook_index->write();


        /*Articles*/
        $article_index = new Index(base_path('articles-sitemap.xml'));
        $article_index->addSitemap(url('/'));
        foreach ($articles as $key => $row) {
            $article_index->addSitemap(url('/articles',$row->slug));
        }
           
        $check= $article_index->write();


        /*Main Sitemap*/
        $index = new Index(base_path('sitemap_index.xml'));
        $index->addSitemap(url('/'));
        $index->addSitemap(url('/pages-sitemap.xml'), time(), Sitemap::DAILY, 0.3);
        $index->addSitemap(url('/blogs-sitemap.xml'), time(), Sitemap::DAILY, 0.3);
        $index->addSitemap(url('/ebooks-sitemap.xml'), time(), Sitemap::DAILY, 0.3);
        $index->addSitemap(url('/articles-sitemap.xml'), time(), Sitemap::DAILY, 0.3);

        #$index->setStylesheet('http://example.com/css/sitemap.xsl');
           
        $check= $index->write();
      
        return redirect()->back()->with('Sitemap Updated');
    }

    static function sitemapUpdate(){
        $pages=Page::where('status',1)->get();
        $blogs=Blog::where('status',1)->get();
        $ebooks=Ebook::where('status',1)->get();
        $articles=Article::where('status',1)->get();


        /*Pages*/
        $page_index = new Index(base_path('pages-sitemap.xml'));
        $page_index->addSitemap(url('/'));
        foreach ($pages as $key => $row) {
            $page_index->addSitemap($row->url);
        }
           
        $check= $page_index->write();

        /*Blogs*/
        $blog_index = new Index(base_path('blogs-sitemap.xml'));
        $blog_index->addSitemap(url('/'));
        foreach ($blogs as $key => $row) {
            $blog_index->addSitemap(url('/blogs',$row->slug));
        }
           
        $check= $blog_index->write();


        /*Ebooks*/
        $ebook_index = new Index(base_path('ebooks-sitemap.xml'));
        $ebook_index->addSitemap(url('/'));
        foreach ($ebooks as $key => $row) {
            $ebook_index->addSitemap(url('/ebooks',$row->slug));
        }
           
        $check= $ebook_index->write();


        /*Articles*/
        $article_index = new Index(base_path('articles-sitemap.xml'));
        $article_index->addSitemap(url('/'));
        foreach ($articles as $key => $row) {
            $article_index->addSitemap(url('/articles',$row->slug));
        }
           
        $check= $article_index->write();


        /*Main Sitemap*/
        $index = new Index(base_path('sitemap_index.xml'));
        $index->addSitemap(url('/'));
        $index->addSitemap(url('/pages-sitemap.xml'), time(), Sitemap::DAILY, 0.3);
        $index->addSitemap(url('/blogs-sitemap.xml'), time(), Sitemap::DAILY, 0.3);
        $index->addSitemap(url('/ebooks-sitemap.xml'), time(), Sitemap::DAILY, 0.3);
        $index->addSitemap(url('/articles-sitemap.xml'), time(), Sitemap::DAILY, 0.3);

        #$index->setStylesheet('http://example.com/css/sitemap.xsl');
           
        $check= $index->write();
      
        return redirect()->back()->with('Sitemap Updated');
    }
}
