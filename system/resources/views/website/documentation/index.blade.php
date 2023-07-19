@extends('layouts.website')

@section('title', $getCategory->meta_title)
@section('description', $getCategory->meta_description)
@section('keywords', $getCategory->meta_keywords)
{{-- @section('image', '') --}}

@section('end_head')
    <style>
    .documentation-page {
        min-height: calc(100vh - 72px);
        position: relative;
    }
    .documentation-page .main-head{
        position: absolute;
        top: 0px;
        z-index: 893;
    }
    .documentation-page p.doc-para {
        color: rgba(var(--color-text-dark), 1);
        font-weight: 600;
        letter-spacing: .15px;
        margin-top: 20px;
        font-size: 15px;
        line-height: 32px;
    }
    .documentation-page .main-sidebar {
        background-color: rgba(247,247,255, 1);
        position: absolute;
        box-shadow: none;
        border-right: 1px solid #f4f4f4;
        top: 0;
        height: 100%;
        width: 230px;
        transition: all .5s;
        z-index: 880;
        left: 0;
    } 
    .documentation-page.sidebar-gone .main-sidebar {
        left: -250px;
    }
    .documentation-page .main-sidebar, .documentation-page .main-content {
        transition: all .5s;
    }
    .documentation-page .main-sidebar aside {
        padding-top: 65px;
        transition: all .2s;
    } 
    .documentation-page .main-sidebar .sidebar-brand.sidebar-brand-sm {
        display: none;
    }  
    .documentation-page .main-sidebar .sidebar-brand {
        display: inline-block;
        width: 100%;
        text-align: center;
        height: 60px;
        line-height: 60px;
    }
    .documentation-page .main-sidebar .sidebar-brand a {
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-weight: 700;
        color: #000;    
    }
    .documentation-page .main-sidebar aside > ul {
        padding-left: 20px;
        padding-right: 20px;
        padding-bottom: 40px;
        margin: 0;
        list-style: none;
    }
    .documentation-page .main-sidebar aside > ul > li {
        font-size: 10px;
        letter-spacing: 1px;
        font-weight: 800;
        color: rgba(0,0,0,.2);
        text-transform: uppercase;
        /* padding-left: 20px;
        padding-right: 20px; */
        margin-top: 20px;
    }
    /* .documentation-page .main-sidebar aside > ul li ul {
        list-style: none;
        padding: 0;
        margin: 0;
    } */
    .documentation-page .main-sidebar aside > ul li a {
        display: block;
        /* height: 35px; */
        font-size: 14px;
        text-transform: none;
        letter-spacing: normal;
        font-weight: 600;
        color: rgba(var(--color-text-dark), 1);
        text-decoration: none;
    }
    .documentation-page .main-sidebar aside > ul li a.active, .documentation-page .main-sidebar aside > ul li a:hover {
        color: rgba(var(--color-primary), 1);
    }
    .documentation-page .main-content {
        padding-left: 275px;
        padding-right: 30px;
        padding-top: 15px;
        width: 100%;
        position: relative;
    }
    .documentation-page .main-content .section .section-body {
        padding: 40px 0;
        padding-right: 250px;
        position: relative;
    }
    .documentation-page .main-content .section .section-header {
        box-shadow: none;
        margin-bottom: 0;
        background-color: #fff;
        border-radius: 3px;
        border: none;
        position: relative;
        padding: 20px 0px 20px 0px;
        display: flex;
        align-items: center;
    }
    .documentation-page .main-content .section .section-body h2.doc-main-page-head {
        font-size: 28px;
        margin-bottom: 0;
        font-weight: 700;
        display: inline-block;
        margin-top: 3px;
        color: #34395e;
    }
    .documentation-page .main-content .section .section-header .btn {
        font-size: 12px;
    }
    .documentation-page .main-content .section .section-body hr:first-of-type {
        margin-top: 10px;
        margin-bottom: 60px;
    }
    .documentation-page .main-content .section .section-body hr {
        border-top-style: dashed;
        border-top-width: 2px;
    }
    .documentation-page .main-content .section .section-body .doc-side-list-sec{
        position: absolute;
        top: 65px;
        right: 10px;
        width: 200px;
        height: calc(100% - 65px);
    }
    .documentation-page .main-content .section .section-body .doc-side-list-sec ul.doc-list-right {
        position: sticky;
        top: 100px;
        padding: 0;
        margin: 0;
        list-style: none;
        border-left: 1px solid #f4f4f4;
        padding-left: 20px;
        /* padding-right: 20px; */
    } 
    .documentation-page .main-content .section .section-body .doc-side-list-sec ul.doc-list-right li a {
        display: block;
        color: rgba(0,0,0, .7);
        text-decoration: none;
        font-size: .9rem;
        margin-bottom: 12px;
        line-height: 1.2;
    }
    ul.doc-list-right li a:hover,
    ul.doc-list-right li a:focus{
        color: rgba(var(--color-primary), 1)!important;
    }
    .documentation-page .main-content .section .section-body h2.doc-head {
        font-size: 18px;
        position: relative;
    }
    .documentation-page .main-content .section .section-body h2.doc-head:before {
        content: " ";
        border-radius: 5px;
        height: 6px;
        width: 15px;
        background-color: rgba(var(--color-primary), 1);
        display: inline-block;
        float: left;
        margin-top: 6px;
        margin-right: 10px;
    }
    .main-content img{
        max-width: 100%!important;
        height: auto!important;
    }
    body.sidebar-gone .documentation-page .main-sidebar {
        left: -250px;
    }
    .documentation-page .main-head .navbar-toggler {
        display: none;
    }
    .section-body .doc-padd{
        padding-top: 3rem;
    }
    .section-body .doc-padd:first-child{
        padding-top: 0rem !important;
    }
    
    @media (max-width: 1024px){
        .documentation-page .main-sidebar {
            top: 0;
            height: 100%;
            background-color: #fff;
            position: fixed !important;
            margin-top: 0 !important;
            z-index: 891;
            left: -250px;
        }
        .documentation-page .main-content {
            padding-left: 15px;
            padding-right: 15px;
            width: 100% !important;
            padding-top: 28px;
        }
        .documentation-page .sidebar-gone-show {
            display: block !important;
        }
        .documentation-page .main-head .navbar-toggler {
            font-size: 1.6rem;
            color: #000;
            font-weight: bolder;
            display: block;
        }
        .documentation-page .main-sidebar aside {
            padding-top: 125px;
        }
        .sb-active::after{
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background-color: #000;
            opacity: 0.3;
            z-index: 890;
            -webkit-animation-name: fadeinbackdrop;
            animation-name: fadeinbackdrop;
            -webkit-animation-duration: 1s;
            animation-duration: 1s;
            -webkit-animation-fill-mode: forwards;
            animation-fill-mode: forwards;
        }

        /* .documentation-page .main-head{
            position: fixed;
            top: 72px;
            z-index: 893;
        } */
    }
    @media(max-width: 768px) {
        .documentation-page .main-content .section .section-body {
            padding-right: 0px;
        }
        .documentation-page .main-content .section .section-body .doc-side-list-sec {
            display: inline-block;
            position: static;
        }
        .documentation-page .main-content .section .section-body .doc-side-list-sec ul.doc-list-right {
            margin-bottom: 30px;
        }

        .documentation-page .main-content .section .section-body h1{
            font-size: 22px;
        }
        
    }

    .sb-active.documentation-page .main-sidebar{
        left: 0;
    }
    
    </style>
@endsection

@section('content')
<div class="documentation-page">
    <div class="main-head bg-white border-bottom d-flex py-3 w-100">
        <button class="navbar-toggler mx-3" type="button" id="doc-sidebar-toggle">
            <span class="bi bi-list"></span>
        </button>
        <h1 class="fw-bold mb-0 ms-md-3 h4">{{__('Documentation')}}</h1>
    </div>

    {{-- Sidebar --}}
    <div class="main-sidebar sidebar-style-2 doc-sidebar" tabindex="1" style="overflow: hidden; outline: none;">
        <aside id="sidebar-wrapper">
            <ul class="">
                @php
                    $page_title = '';
                    $segment_category =  Request::segment(2);
                @endphp
                @foreach ($category as $cate)
                <li>
                    <a href="{{ route('documentation', $cate->slug) }}" class="@if($cate->slug == $segment_category) active @endif">
                        <span>{{ $cate->name }}</span>
                    </a>
                </li>
                @php
                    if ($cate->slug == $segment_category){
                        $page_title = $cate->name;
                    }
                @endphp
                @endforeach
            </ul>              
            <!-- Menu -->
        </aside>
    </div>
    {{-- END -- Sidebar --}}



    <div class="main-content">
        <section class="section">
            <div class="section-body">
                @if ($page_title != '')
                <div class="section-header">
                    <h2 id="overview" class="doc-main-page-head">{{$page_title}}</h2>
                </div>
                <hr class="mt-0 mb-3">
                @endif
                
                {{-- right side menu --}}
                <div class="doc-side-list-sec">
                    <ul class="doc-list-right">
                    @foreach ($documentation as $docs)
                        <li>
                            <a href="#section_{{$docs->id}}" class="page_content_sidebar">{{ $docs->title }}</a>
                        </li>
                    @endforeach
                    </ul>
                </div>

                @if (count($documentation) >= 1)
                    @foreach ($documentation as $docs)
                    <div id="section_{{$docs->id}}" class="mb-0 pt-5">
                        @if ($loop->iteration > 1)
                        <hr class="mb-5 mt-0">
                        @endif
                        {{-- <p class="doc-para"><a name="section-{{$loop->iteration}}"></a></p> --}}
                        <h2 class="h2 doc-head fw-bold">{{ $docs->title }}</h2>
                        <div>
                            {!! $docs->content !!}
                        </div>
                    </div>

                    @endforeach
                @else
                    <div>
                        <h5>Content will be updated soon.</h5>
                    </div>
                @endif
                
            </div>
        </section>
    </div>
</div>
@endsection
@push('end_body')
<script>
    $(document).on('click', '#doc-sidebar-toggle', function(){
        $('.documentation-page').toggleClass('sb-active');
    });

    /* when click outside the documents page sidebar */
    $(document).mouseup(function(e){
        /* check if main container has a class "sb-active" */
        if($('.documentation-page').hasClass('sb-active')){
            var sidebar = $(".main-sidebar");
            var toggle_btn = $("#doc-sidebar-toggle");
            // if the target of the click isn't the sidebar nor a descendant of the sidebar
            if (!sidebar.is(e.target) && sidebar.has(e.target).length === 0 && !toggle_btn.is(e.target) && toggle_btn.has(e.target).length === 0) {
                /* remove the class active for collapced the sidebar */
                $('.documentation-page').removeClass('sb-active');
            }
        }
    });
</script>

<script>
    $(document).on('click', '.page_content_sidebar', function(e) {
        e.preventDefault();
        // target element id
        var id = $(this).attr('href');
        // target element
        var $id = $(id);
        if ($id.length === 0) {
            return;
        }
        var pos = $id.offset().top;
        $('body, html').animate({
            scrollTop: pos
        });
    });
</script>
@endpush