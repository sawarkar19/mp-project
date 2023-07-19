@extends('layouts.website')

@section('title', $setting->meta_title)
@section('description', $setting->meta_description)
@section('keywords', $setting->meta_keywords)
{{-- @section('image', '') --}}

@section('end_head')
<style>

</style>
@endsection

@section('content')
{{-- blogs --}}
<section id="blogs">
    
    {{-- page heading --}}
    <div class="bg-light">
        <div class="container">
            {{-- Breadcrumb Section --}}
            @php
                $bcrm = array(
                    array('name' => 'Articles', 'link' => false),
                );
            @endphp
            @include('website.components.breadcrumb', $bcrm)
        </div>
        <div class="container">
            <div class="bumper">
                <div class="bm_inner pb-5">
                    <div class="text-center_">
                        <h1 class="font-800 color-gradient d-inline-block">{{ $setting->title ?? 'Articles' }}</h1>
                        <div>
                            {!! $setting->description ?? 'MouthPublicity.io' !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-5">
        <div class="container">

            <div class="row">
                <div class="col-lg-8">
                    {{-- All Latest Articles --}}
                    <div class="row">
                        @foreach($blogs as $blog)
                        <div class="col-md-6 mb-4">
                            <div class="blog_card bl_grid" style="height: 100%;">
                                <a href="{{url('articles'.'/'.$blog->slug)}}">
                                    <div class="bl_inner border_ shadow-sm" style="height: 100%;">
                                        <div class="bl_flex">
                                            <div class="image_col">
                                                <div class="image_thumb" style="@if($blog->image != '')background-image:url({{asset('assets/articles/banners/'.$blog->image)}})@endif"></div>
                                            </div>
                                            <div class="content_col">
                                                <div class="inner">
                                                    <h5 class="title font-600">{{ $blog->title }}</h5>
                                                    <p class="excerpt">{!! substr(strip_tags($blog->content), 0, 256) !!}...</p>
                                                    <span class="btn btn-link-ol btn-sm" onclick="window.location.href='{{url('articles'.'/'.$blog->slug)}}'">
                                                        <span>Read More</span>
                                                        <i class="bi bi-arrow-right"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- pagination  --}}
                    <div class="my-5 border-md-bottom">
                        {!! $blogs->links() !!}
                    </div>
                    <!-- pagination end -->

                </div>



                {{-- ======= Sidebar ======= --}}
                <div class="col-lg-4">
                    @include('website.components.blogs-sidebar')
                </div>

            </div>


        </div>
    </div>
</section>

@endsection