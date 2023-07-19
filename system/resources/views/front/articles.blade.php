@extends('layouts.front')

@section('title', 'Articles - MouthPublicity.io')
@section('description', 'Discover amazing mouth publicity ideas, strategies, and hacks to reach new customers. Grow your Business Exponentially with MouthPublicity.io. ')
@section('keywords', 'MouthPublicity.io articles, MouthPublicity.io news, MouthPublicity.io updates')
{{-- @section('image', '') --}}

@section('content')

<section id="blogs">
    <div class="py-5">

    <div class="container">

        <div class="mb-5">
            <div class="">
                <div class="mb-4">
                    <a href="{{ url('/') }}" ><img src="{{ asset('assets/front/images/logo-dark.svg') }}" class="main_logo" alt="MouthPublicity.io"></a>
                </div>
            </div>
        </div>


        <div class="bumper mb-5">
            <div class="bm_inner pb-md-5">
                <div class="text-center">
                    <h1 class="font-600 main-title d-inline-block">{{ $setting->title ?? 'Articles' }}</h1>
                    <p>{{ $setting->description ?? 'MouthPublicity.io' }}</p>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-8">

                <div>
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
                                                <div class="p-3">
                                                    <h5 class="title">{{ $blog->title }}</h5>
                                                    <p class="excerpt">{!! substr(strip_tags($blog->content), 0, 90) !!}...</p>
                                                    <span class="btn btn-app btn-sm" onclick="window.location.href='{{url('articles'.'/'.$blog->slug)}}'">
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
                </div>

                <style>
                    .pagination .page-item > .page-link{
                        padding: .35rem 1rem;
                        color: inherit;
                        outline: none;
                        box-shadow: none;
                        font-family: var(--font-h1);
                    }
                    .pagination .page-item.active > .page-link{
                        background: var(--color-thm-shd);
                        color: #FFF;
                        border-color: #dee2e6;
                    }
                </style>
                {{-- pagination  --}}
                <div class="my-5 border-md-bottom">
                    {{-- <nav aria-label="Page navigation">
                        <ul class="pagination">
                          <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                          <li class="page-item active"><a class="page-link" href="#">1</a></li>
                          <li class="page-item"><a class="page-link" href="#">2</a></li>
                          <li class="page-item"><a class="page-link" href="#">3</a></li>
                          <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </nav> --}}
                    {!! $blogs->links() !!}
                </div>
                <!-- pagination end -->

            </div>



            {{-- ====================================Sidebar============================================ --}}
            <div class="col-lg-4">
                <div class="sticky-top sdbr-sk">
                    @include('layouts.front.sidebar')
                </div>
            </div>
            
        </div>


    </div>
        
        
    </div>
</section>

@endsection