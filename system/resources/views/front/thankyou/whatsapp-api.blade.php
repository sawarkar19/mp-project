@extends('layouts.front')
@php
    use Illuminate\Support\Facades\Request;
    if(Request::has('tab')){if(Request::get('tab') == 'register'){$tab = 'register';}else{$tab = '';} }else{$tab = '';}
@endphp
@section('start_head')
    <link rel="stylesheet" href="{{ asset('assets/uploads/tmp/assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">


    <style>
    #thankYou {
        position: relative; 
        background-color: #fff; 
        min-height: 100vh;
        overflow: hidden; 
    }
    .splashes.dots-color-bottom-ty {
        content: url(assets/front/images/dots-colorbt-ty.png);
        bottom: 421px;
        left: -8px;
        width: 200px;
    }
    .splashes.dots-top-ty {
        content: url(assets/front/images/dots-ty.png);
        top: 122px;
        right: 22%;
        width: 100px;
    }
    .ty-txt1 {
        max-width: 50%;
        margin: 0 auto;
        font-size: 28px;
    }
    .btnW {
        width: 184px;
        padding: 13px 0px !important;
        margin: 0px 15px;
    }
    .oplk-text-gradient-rev {
        background: #00FFAF;
        background: -webkit-linear-gradient(120deg, #00249C, #00FFAF);
        background: -moz-linear-gradient(120deg, #00249C, #00FFAF);
        background: linear-gradient(120deg, #00249C, #00FFAF);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .blog_card.bl_grid .content_col .bl_title {
        color: var(--color-thm-lth);
        font-size: 14px;
    }
    .blog_card .content_col .bl_title {
        transition: all 300ms ease;
    }
    .shadow-api{
        box-shadow: 0 .125rem .25rem rgba(0,0,0,20%) !important;
    }
    .btn.btn-default {
        background: #ddd;
    }
    .btn.btn-default:hover{
        color: #1a3aa6;
    }
    @media (max-width: 767px){
        .btnW {
            width: 150px;
            padding: 13px 0px !important;
            margin: 0px 2px;
        }
        .ty-txt1 {
            max-width: 100%;
        }
    }

    </style>


@endsection
@section('title', 'Thank You | OpenChallenge')
@section('content')

<section id="thankYou">
    <span class="splashes dots-top-ty"></span>
    <span class="splashes dots-color-bottom-ty"></span>
    <div class="py-5">
        <div class="container">
            <div class="mb-5">
                <a href="{{ url('') }}"><img src="{{ asset('assets/front/images/logo-dark.svg') }}" class="main_logo" alt="OpenChallenge"></a>
            </div>

            <div class="row justify-content-between text-center">
                <img src="{{ asset('assets/front/images/thankyou.png') }}" class="img-fluid" style="width: 600px; margin: 0 auto;">
                <div class="mt-5">
                    <div class="oplk-text-gradient-rev d-inline-block mx-auto">
                        <h4 class="font-600 text-uppercase ">WE HAVE A SPECIAL GIFT FOR YOU!</h4>
                    </div>
                    
                    <h6 class="mt-1 font-600 ty-txt1">Check your inbox to get your offer immediately</h6>
                    <a href="#" class="btn btn-theme btnW mt-4">GRAB IT NOW</a>
                    <div class="mt-5">
                        <a href="#" class="btn btn-default btnW"><i class="bi bi-arrow-left"></i> Back to Home</a>
                        <a href="#" class="btn btn-default btnW"><i class="bi bi-geo-alt"></i> Contact us</a>
                    </div>
                    <div class="my-5 font-600">
                        <h3>Meanwhile you can Check Our Blogs Here</h3>
                    </div>
                </div>
                
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <div class="blog_card bl_grid" style="text-align: left;">
                        <a href="#">
                            <div class="bl_inner border_ shadow-api">
                                <div class="bl_flex">
                                    <div class="image_col">
                                        <div class="image_thumb" style="background-image: url('https://openlink.co.in/assets/blogs/banners/openlink-28032022012435.jpg');"></div>
                                    </div>
                                    <div class="content_col">
                                        <div class="p-3">
                                            <h6 class="bl_title">Lorem Ipsum is simply dummy text of the printing and typesetting industry. </h6>
                                            <span class="btn btn-app btn-sm" onclick="">
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
                <div class="col-lg-4 col-md-4">
                    <div class="blog_card bl_grid" style="text-align: left;">
                        <a href="#">
                            <div class="bl_inner border_ shadow-api">
                                <div class="bl_flex">
                                    <div class="image_col">
                                        <div class="image_thumb" style="background-image: url('https://openlink.co.in/assets/blogs/banners/openlink-28032022012435.jpg');"></div>
                                    </div>
                                    <div class="content_col">
                                        <div class="p-3">
                                            <h6 class="bl_title">Lorem Ipsum is simply dummy text of the printing and typesetting industry. </h6>
                                            <span class="btn btn-app btn-sm" onclick="">
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
                <div class="col-lg-4 col-md-4">
                    <div class="blog_card bl_grid" style="text-align: left;">
                        <a href="#">
                            <div class="bl_inner border_ shadow-api">
                                <div class="bl_flex">
                                    <div class="image_col">
                                        <div class="image_thumb" style="background-image: url('https://openlink.co.in/assets/blogs/banners/openlink-28032022012435.jpg');"></div>
                                    </div>
                                    <div class="content_col">
                                        <div class="p-3">
                                            <h6 class="bl_title">Lorem Ipsum is simply dummy text of the printing and typesetting industry. </h6>
                                            <span class="btn btn-app btn-sm" onclick="">
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
            </div>
            
        </div>
        <div class="container">

        </div>
    </div>
</section>
 

@endsection
@section('end_body')
    <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/js/form.js') }}"></script>
    <script src="{{ asset('assets/js/admin/register.js') }}"></script>
    <script src="{{ asset('assets/js/input-validation.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>

    @include('auth.scripts.validation')
    @include('auth.scripts.otp')
@endsection