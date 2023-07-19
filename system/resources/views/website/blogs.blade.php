@extends('layouts.website')

@section('title', $setting->meta_title)
@section('description', $setting->meta_description)
@section('keywords', $setting->meta_keywords)
{{-- @section('image', '') --}}

@section('end_head')

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
                    array('name' => 'Blogs', 'link' => false),
                );
            @endphp
            @include('website.components.breadcrumb', $bcrm)
        </div>
        <div class="container">
            <div class="bumper">
                <div class="bm_inner pb-5">
                    <div class="text-center_">
                        <h1 class="font-800 color-gradient d-inline-block">{{ $setting->title ?? 'Blogs' }}</h1>
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
            
            @if (isset($_GET['page']) && $_GET['page'] > 1)
            
            @else
            <div class="mb-5">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        {{-- First Latest Post (only One) --}}
                        <div class="blog_card bl_grid">
                            <a href="{{url('blogs'.'/'.$letestBlog->slug)}}">
                                <div class="bl_inner border_ shadow-sm">
                                    <div class="bl_flex">
                                        <div class="image_col">
                                            <div class="image_thumb" style="@if($letestBlog->image != '')background-image:url({{asset('assets/blogs/banners/'.$letestBlog->image)}})@endif"></div>
                                        </div>
                                        <div class="content_col">
                                            <div class="p-3">
                                                <h5 class="title font-600">{{ $letestBlog->title }}</h5>
                                                <p class="excerpt">{!! substr(strip_tags($letestBlog->content), 0, 256) !!}...</p>
                                                <span class="btn btn-link-ol">
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

                    {{-- Featured Blogs  --}}
                    <div class="col-lg-6">
                        <div class="heading mb-3">
                            <h4 class="font-700 color-primary">Featured Blogs</h4>
                        </div>
                        @foreach($featuredBlog as $blog)
                        <div class="blog_card bl_list mb-4">
                            <a href="{{url('blogs'.'/'.$blog->slug)}}">
                                <div class="bl_inner border_ shadow-sm">
                                    <div class="bl_flex">
                                        <div class="image_col">
                                            <div class="image_thumb" style="@if($blog->image != '')background-image:url({{asset('assets/blogs/banners/thumbnails/'.$blog->image)}})@endif"></div>
                                        </div>
                                        <div class="content_col">
                                            <div class="p-3">
                                                <h5 class="title font-600">{{ $blog->title }}</h5>
                                                <p class="excerpt">{!! substr(strip_tags($blog->content), 0, 256) !!}...</p>
                                                <span class="btn btn-link-ol btn-sm">
                                                    <span>Read More</span>
                                                    <i class="bi bi-arrow-right"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif


            <div class="row">
                <div class="col-lg-8">
                    {{-- All Latest Blogs --}}
                    <div class="row">
                        @foreach($blogs as $blog)
                        <div class="col-md-6 mb-4">
                            <div class="blog_card bl_grid" style="height: 100%;">
                                <a href="{{url('blogs'.'/'.$blog->slug)}}">
                                    <div class="bl_inner border_ shadow-sm" style="height: 100%;">
                                        <div class="bl_flex">
                                            <div class="image_col">
                                                <div class="image_thumb" style="@if($blog->image != '')background-image:url({{asset('assets/blogs/banners/'.$blog->image)}})@endif"></div>
                                            </div>
                                            <div class="content_col">
                                                <div class="inner">
                                                    <h5 class="title font-600">{{ $blog->title }}</h5>
                                                    <p class="excerpt">{!! substr(strip_tags($blog->content), 0, 256) !!}...</p>
                                                    <span class="btn btn-link-ol btn-sm" onclick="window.location.href='{{url('blogs'.'/'.$blog->slug)}}'">
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