<?php

namespace App\Http\Controllers\Seo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use samdark\sitemap\Sitemap;
use samdark\sitemap\Index;
use Auth;

use App\Models\Option;
use App\Models\User;

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
}
