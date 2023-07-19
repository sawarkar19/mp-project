<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        {{-- Custom Links After Start-Head Tag --}}
        @yield('start_head')
        {{-- Page Title --}}
        <title>Template Builder: MouthPublicity.io</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        {{-- Page Meta --}}
        @include('layouts.business.meta')
        {{-- Page CSS, JS & Other Links --}}
        @include('layouts.business.link')
        {{-- Custom Links After End-Head Tag --}}
        <style>
            .logo-on-builder{
                position: absolute;
                top: 10px;
                left: 15px;
                width: 150px;
                z-index: 999;
            }
            .main-navbar{
                justify-content: end;
            }
            .main-navbar form.form-inline{
                display: none!important;
            }

            .btn.disabled,
            .btn:disabled {
                opacity: .05!important;
            }
        </style>
        <style>
            .no-social-links{
                font-family: 'Poppins', sans-serif;
                color: var(--cl-default);
                font-weight: 500;
                font-size: 18px;
            }
            /* @media (min-width: 768px){ */
            .main-content{
                padding-top: 160px!important;
            }
            /* } */
            #builder_canvas{
                padding-left: 350px;
            }

            #inputs_area{
                position: fixed;
                width: 100%;
                height:100%;
                background-color: transparent;
                z-index: 999;
                top: 0;
                right: 100%;
            }
            .input_area_child{
                position: fixed;
                width: 350px;
                max-width: 100%;
                height: calc(100% - 160px);
                bottom: 0;
                left: 0;
                background-color: #fff;
                box-shadow: 4px -2px 8px rgb(0 0 0 / 3%);
                border-radius:0 3px 0 0;
                padding: 30px;
                overflow-y: auto;
                z-index:999;
                transition: all 300ms cubic-bezier(0.76, 0.15, 0.38, 1.18);

            }
            #inputs_area .close-ea{
                display: none;
            }
            #inputs_area .loader{
                position: relative;
                text-align: center;
                height: 100%;
                justify-content: center;
                align-items: center;
                display: flex;
                flex-direction: column;
            }

            #inputs_area::-webkit-scrollbar-track{
                /* -webkit-box-shadow: inset 0 0 3px rgba(0,0,0,0.3); */
                background-color: #F5F5F5;
                border-radius: 3px
            }

            #inputs_area::-webkit-scrollbar
            {
                width: 5px;
                background-color: #F5F5F5;
            }

            #inputs_area::-webkit-scrollbar-thumb
            {
                background-color: #6777ef;
                border-radius: 3px;
                /* border: 1px solid #555555; */
            }

            .main_video{
                position: relative;
            }
            
            .main_video .overlay{
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0);
                z-index: 1;
                background-position: center;
                background-size: cover;
            }
            
            .navbar-bg{
                position: fixed;
                z-index: 9;
            }
            nav.navbar{
                position: relative!important;
            }
            .navbar-nav .dropdown-menu {
                position: absolute;
            }


            /* ===================CSS FOR EDITOR================== */
            .OL-EDITABLE{
                border: 1px dashed transparent;
                cursor: pointer;
            }
            .OL-EDITABLE:hover{
                border: 1px dashed blue;
            }
            .OL-EDITABLE.OL-ACTIVE{
                border: 1px solid blue;
            }
            .dd_btn{
                cursor: pointer;
            }
            .image_title, a{
                word-break: break-all;
            }
            .partition{
                border: 5px solid #6777ef;
                border-radius: 5px;
            }
            
            @media (min-width: 1025px){
                #builder_canvas{
                    padding-left: calc(350px + 15px);
                    padding-right: 15px;
                }
            }
            
            @media (max-width:1024px){
                .main-content {
                    padding-left: 15px;
                    padding-right: 15px;
                }   
                .input_area_child{
                    left: -270px;
                     width: 270px;
                     top: 0;
                     bottom: 0;
                     height: auto; 
                }
                #inputs_area.show{
                    overflow: hidden;
                    right: 0;
                    left: 0;
                }
                #inputs_area.show .input_area_child{
                    left: 0px;
                }
                #builder_canvas{
                    padding-left: 0px;
                }
                #inputs_area.show:before {
                    content: '';
                    position: fixed;
                    left: 0;
                    right: 0;
                    width: 100%;
                    height: 100%;
                    background-color: #000;
                    opacity: 0.8;
                    z-index: 891;
                }
                 #inputs_area:after{
                    content: "\f054";
                    font-family: "Font Awesome 5 Free";
                    -webkit-font-smoothing: antialiased;
                    font-style: normal;
                    font-variant: normal;
                    text-rendering: auto;
                    font-size: 15px;
                    font-weight: bold;
                    position: absolute;
                    padding-left: 6px;
                    padding-top: 2px;
                    top: 50%;
                    left: -25px;
                    width: 26px;
                    height: 99px;
                    color: #ff0000;
                    display: flex;
                    justify-content: center;
                    cursor: pointer;
                    z-index: 999;
                    align-items: center;
                    transform: translateY(-50%) rotate(180deg) ;
                    transition: all 300ms cubic-bezier(0.76, 0.15, 0.38, 1.18);
                    background-repeat: no-repeat;
                    background-size: 100% 100%;
                    background-image: url({{asset('assets/img/menu-curve-btn1.svg')}});
                }
                #inputs_area.show:after{
                    left: 267px;
                }
            }
            
        </style>

        <style>

            :root{
                --color-background: {{ $template->bg_color ?? '#000000' }};
                --color-default-color:  {{ $template->default_color ?? '#000000' }};
                --color-business-name: {{ $template->business_name_color ?? '#000000' ?? '#000000' }};
                --color-tag-line: {{ $template->tag_line_color ?? '#000000' }};
                --color-icon-website: {{ $template->contact_icons->website_icon_color ?? '#000000' }};
                --color-icon-location: {{ $template->contact_icons->location_icon_color ?? '#000000' }};
                --color-icon-whatsapp: {{ $template->contact_icons->whatsapp_icon_color ?? '#000000' }};
                --color-icon-contact: {{ $template->contact_icons->contact_icon_color ?? '#000000' }};
                
                
                --color-temp-head: {{ $template->hero_title_color ?? '#000000' }};
                --color-text-color: {{ $template->hero_text_color ?? '#000000' }};
                --color-extra-head: {{ $template->extra_heading_1_color ?? '#000000' }};
                --color-extra-text: {{ $template->extra_text_1_color ?? '#000000' }};
                

                @php
                    
                    foreach ($text_colors as $key => $text_col) {
                @endphp
                    --color-text-content{{ $key }}: {{ $text_col ?? '#000000' }};
                @php
                        
                    }
                @endphp

                @php
                       
                    foreach ($button_colors as $key => $btn_col) {
                @endphp
                    --color-btn-text{{ $key }}: {{ $btn_col ?? '#000000' }};
                @php
                        
                    }
                @endphp

                @php
                      
                    foreach ($button_bg_colors as $key => $btn_bg_col) {
                @endphp
                    --color-btn-bg{{ $key }}: {{ $btn_bg_col ?? '#000000' }};
                @php
                       
                    }
                @endphp

                @php
                       
                    foreach ($gallery_color_titles as $key => $title_col) {
                @endphp
                    --color-image-title{{ $key }}: {{ $title_col ?? '#000000' }};
                @php
                        
                    }
                @endphp

                @php
                       
                    foreach ($tag_1_bg_colors as $key => $tag_col) {
                @endphp
                    --color-tag1-bg{{ $key }}: {{ $tag_col ?? '#000000' }};
                @php
                        
                    }
                @endphp

                @php
                       
                    foreach ($tag_2_bg_colors as $key => $tag_col) {
                @endphp
                    --color-tag2-bg{{ $key }}: {{ $tag_col ?? '#000000' }};
                @php
                        
                    }
                @endphp
            }

            /*  Apply CSS */

            @php
                      
                    foreach ($text_colors as $key => $text_col) {
                @endphp
                .template-container #text_input_{{ $key }}{color: var(--color-text-content{{ $key }}) !important;}
                @php
                        
                    }
            @endphp

            @php
                
                foreach ($gallery_color_titles as $key => $title_col) {
            @endphp
                .template-container #tem_image_title_{{ $key }}{color: var(--color-image-title{{ $key }});}
            @php
                    
                }
            @endphp

            @php
                 
                foreach ($tag_1_bg_colors as $key => $tag_col) {
            @endphp
                .template-container #tem_img{{ $key }}::after{background: var(--color-tag1-bg{{ $key }}) !important;}
                
            @php
                   
                }
            @endphp

            @php
                 
                foreach ($tag_2_bg_colors as $key => $tag_col) {
            @endphp
                
                .template-container #tem_tag_bg{{ $key }}{background: var(--color-tag2-bg{{ $key }}) !important;}
            @php
                   
                }
            @endphp


            @php
                      
                foreach ($button_colors as $key => $text_col) {
            @endphp
                    .template-container #action_btn_{{ $key }}{color: var(--color-btn-text{{ $key }}) !important;}
            @php
                        
                }
            @endphp

            @php
                      
                foreach ($btn_style_types as $key => $type) {

                    if($type == 'Background'){
            @endphp
                    .template-container #action_btn_{{ $key }}{background-color: var(--color-btn-bg{{ $key }}) !important;}
            @php
                    }else{
            @endphp

                    .template-container #action_btn_{{ $key }}{border-color: var(--color-btn-bg{{ $key }}) !important;}
            @php
                    }        
                }
            @endphp
        </style>
        <style>
            #overlay{   
              position: fixed;
              top: 0;
              z-index: 9999;
              width: 100%;
              height:100%;
              display: none;
              background: rgba(0,0,0,0.6);
            }
            .cv-spinner {
              height: 100%;
              display: flex;
              justify-content: center;
              align-items: center;  
            }
            .spinner {
              width: 40px;
              height: 40px;
              border: 4px #ddd solid;
              border-top: 4px #2e93e6 solid;
              border-radius: 50%;
              animation: sp-anime 0.8s infinite linear;
            }
            @keyframes sp-anime {
              100% { 
                transform: rotate(360deg); 
              }
            }
            .is-hide{
              display:none;
            }
        </style>

        {{-- Image Crop CSS --}}
        <style type="text/css">
            .image-crop-modal .docs-tooltip{
                color: #ffffff;
            }
            .image-crop-modal .preview {
            overflow: hidden;
            width: 160px; 
            height: 160px;
            margin: 10px;
            border: 1px solid red;
            }
            .image-crop-modal .modal-lg{
            max-width: 1000px !important;
            }
            .image-crop-modal .ratio-btn{
            margin-bottom: 0px !important;
            }
            .image-crop-modal .container {
            margin: 20px auto;
            max-width: 640px;
            }
            .image-crop-modal img {
            width: 100%;
            }
           
        </style>

        @yield('end_head')

    </head>
    <body class="layout-3" class="sidebar-gone">

        @php
            $role_id = Auth::User()->role_id;
            $role = \DB::table('roles')->where('id', $role_id)->first()->role;
        @endphp

        @yield('start_body')

        <div id="app">
            <div class="main-wrapper">
                <div class="navbar-bg">
                    
                    <a href="{{ route($role.'.dashboard') }}" class="logo-on-builder">
                        <img src="{{ asset('assets/website/images/logos/logo-light.svg') }}">
                    </a>
                    @include('layouts.partials.header')

                    <section class="section">
                        {{-- <div class="container"> --}}
                            <div class="section-header justify-content-between align-items-center">
                                <h1 class="my-2">Template Builder</h1>

                                @if($offer_id != '')
                                <div>
                                    <a class="btn btn-outline-primary mr-1 mr-sm-2 mr-md-4" id="changeTemplate" href="">Change Template</a>    
                                </div>
                                @endif

                                <div class="template_button">
                                    <div>

                                        @if($offer_id != '')
                                            <a class="btn btn-outline-danger mr-1 mr-sm-2 mr-md-4" href="{{ route('business.offerPreview', $offer_id) }}">Cancel</a>

                                        @else
                                            <a class="btn btn-outline-danger mr-1 mr-sm-2 mr-md-4" href="{{ route('business.designOffer.templates') }}">Cancel</a>
                                        @endif
                                                
                                        
                                        <button class="btn btn-success" id="submitForm">Continue <i class="fa fa-long-arrow-alt-right"></i></button>
                                        
                                    </div>
                                </div>
                            </div>
                        {{-- </div> --}}
                    </section>          

                </div>
                
                {{-- Main Content --}}
                <div class="main-content">
                    
                    @yield('content')

                </div>
                
            </div>
        </div>


        <section id="inputs_area">
            <div class="input_area_child">
                <div class="data_edit h-100" id="inputs_data">
                {{-- <div class="loader">
                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                        <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                        <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                    </svg>
                </div> --}}

            <form id="builderForm" method="post" action="{{ $action }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="template_id" value="{{ $template->slug }}" />
                <input type="hidden" name="offer_id" value="{{ $offer_id }}" />

                <input type="hidden" name="offer_create_id" value="{{ request()->get('offer_create_id') }}" />

                <input type="hidden" name="blank_input" id="blank_input" value="" />


                <div id="_main_tab_" class="section-edit-tab">
                    <h5>Theme</h5>
                    <hr>
                    <div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="mb-1">Background Image</label>
                                    <div class="small mb-1">Select <span class="text-danger">PNG</span>, <span class="text-danger">JPG</span> or <span class="text-danger">JPEG</span> image, Max file size <span class="text-danger">2MB</span>, and Max image width <span class="text-danger">1024px</span>.</div>
                                    <div class="input-group mb-2">
                                        <input type="file" class="form-control cropperjs_input" name="background_image"  accept="image/png, image/jpeg"
                                            data-function-name="templats_images_preview" 
                                            data-cancel-function="click_default_gal($(this));"
                                            data-exts="jpeg|jpg|png"
                                        />
                                        <input type="hidden" name="string_background_image" id="string_background_image" value="" />

                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                            <i class="far fa-image"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h6>
                                        {{-- <span class="badge badge-danger dd_btn" id="delete_background_img">Detete</span> --}}
                                        <span class="badge badge-primary dd_btn" id="default_background_img">Default</span>
                                    </h6>
                                    <div>
                                        <img src="{{ asset('assets/templates/'.$id.'/'.$template->bg_image)}}" style="max-height: 200px" class="img-fluid border open-crop" crop-modal="" id="bi_preview" alt="">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Background Color</label>
                                    <div class="input-group colorpickerinput colorpicker-element" data-colorpicker-id="2">
                                        <input type="color" class="form-control" value="" name="background_color">
                                        <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i class="fas fa-fill-drip"></i>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="bg_type" value="" />

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Business Name Color</label>
                                    <div class="input-group colorpickerinput colorpicker-element" data-colorpicker-id="2">
                                        <input type="color" class="form-control" value="" name="business_name_color">
                                        <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i class="fas fa-fill-drip"></i>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Tag Line Color</label>
                                    <div class="input-group colorpickerinput colorpicker-element" data-colorpicker-id="2">
                                    <input type="color" class="form-control" value="" name="tag_line_color">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                        <i class="fas fa-fill-drip"></i>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Default Text Color</label>
                                    <div class="input-group colorpickerinput colorpicker-element" data-colorpicker-id="2">
                                    <input type="color" class="form-control" value="" name="default_color">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                        <i class="fas fa-fill-drip"></i>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="_main_image_" class="section-edit-tab" style="display: none;">
                    <h5>Main Banner Image</h5>
                    <hr>
                    <div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="mb-1">Select Image</label>
                                    <div class="small mb-1">Select <span class="text-danger">PNG</span>, <span class="text-danger">JPG</span> or <span class="text-danger">JPEG</span> image, Max file size <span class="text-danger">2MB</span>, and Max image width <span class="text-danger">1024px</span>.</div>
                                    <div class="input-group mb-2">
                                        <input type="file" class="form-control cropperjs_input" name="main_image" accept="image/png, image/jpeg"
                                            data-function-name="templats_images_preview" 
                                            data-cancel-function="click_default_gal($(this));"
                                            data-exts="jpeg|jpg|png"
                                        />
                                        
                                        <input type="hidden" name="string_main_image" id="string_main_image" value="" />

                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                            <i class="far fa-image"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h6>
                                        {{-- <span class="badge badge-danger dd_btn" id="delete_main_img">Detete</span> --}}
                                        <span class="badge badge-primary dd_btn" id="default_main_img">Default</span>
                                    </h6>
                                    <div>
                                        <img src="{{ asset('assets/templates/'.$id.'/'.$template->hero_image)}}" style="max-height: 200px" class="img-fluid border open-crop" crop-modal="" id="main_img_preview" alt="">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>


                {{-- <div id="_extra_heading_text_" class="section-edit-tab" style="display: none;">
                    <h5>Heading</h5>
                    <hr>
                    <div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Heading Content</label>
                                    <input type="text" class="form-control" id="extra_hero_title" name="extra_heading_1" value="{{ $template->extra_heading_1 }}">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Heading Color</label>
                                    <div class="input-group colorpickerinput colorpicker-element" data-colorpicker-id="2">
                                        <input type="color" class="form-control" id="extra_hero_text" value="" name="extra_heading_1_color">
                                        <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i class="fas fa-fill-drip"></i>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}


                {{-- <div id="_extra_text_" class="section-edit-tab" style="display: none;">
                    <h5>Text</h5>
                    <hr>
                    <div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Text Content</label>
                                    <textarea name="extra_text_1" rows="4" class="form-control">{{ $template->extra_text_1 }}</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Text Color</label>
                                    <div class="input-group colorpickerinput colorpicker-element" data-colorpicker-id="2">
                                        <input type="color" class="form-control" value="" name="extra_text_1_color">
                                        <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i class="fas fa-fill-drip"></i>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}

                {{-- <div id="_heading_text_" class="section-edit-tab" style="display: none;">
                    <h5>Heading & Text</h5>
                    <hr>
                    <div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Heading Content</label>
                                    <input type="text" class="form-control" id="hero_title" name="heading" value="{{ $template->hero_title }}">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Heading Color</label>
                                    <div class="input-group colorpickerinput colorpicker-element" data-colorpicker-id="2">
                                        <input type="color" class="form-control" id="hero_text" value="" name="heading_color">
                                        <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i class="fas fa-fill-drip"></i>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Text Content</label>
                                    <textarea name="text" rows="4" class="form-control">{{ $template->hero_text }}</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Text Color</label>
                                    <div class="input-group colorpickerinput colorpicker-element" data-colorpicker-id="2">
                                        <input type="color" class="form-control" value="" name="text_color">
                                        <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i class="fas fa-fill-drip"></i>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}

                <div id="_main_video_" class="section-edit-tab" style="display: none;">
                    <h5>Video</h5>
                    <hr>
                    <div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-2">
                                    <label>Youtube Video URL</label>
                                    <input type="text" class="form-control" id="video_url" name="video_url" value="{{ $template->video_url }}">
                                    <div class="small mt-2">Please type youtube video URL.</div>
                                </div>
                            </div>
                            <div class="col-12" style="display: none">
                                <div class="form-group">
                                  <div class="control-label">Autoplay Video</div>
                                  <label class="custom-switch mt-2 pl-0">
                                    <input type="checkbox" id="video_autoplay" name="video_autoplay" class="custom-switch-input" @if($template->video_autoplay != '') checked="checked" @endif>
                                    <span class="custom-switch-indicator"></span>
                                  </label>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>


                <div id="_contact_section_" class="section-edit-tab" style="display: none;">
                    <h5>Contact Section</h5>
                    <hr>
                    <div>
                        <div class="row">

                            <div class="col-12">
                                <div class="form-group mb-2">
                                    <label>Contact Icon Color</label>
                                    <div class="input-group colorpickerinput colorpicker-element" data-colorpicker-id="2">
                                        <input type="color" class="form-control" id="contact_icon_color" value="" name="contact_icon_color">
                                        <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i class="fas fa-fill-drip"></i>
                                        </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="custom-control custom-checkbox mb-4">
                                  <input type="checkbox" name="same_color" class="custom-control-input sameColor" id="customCheck1">
                                  <label class="custom-control-label" for="customCheck1">Same Color For All Icons</label>
                                </div>
                            </div>

                            

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Whatsapp Icon Color</label>
                                    <div class="input-group colorpickerinput colorpicker-element" data-colorpicker-id="2">
                                        <input type="color" class="form-control" id="whatsapp_icon_color" value="" name="whatsapp_icon_color">
                                        <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i class="fas fa-fill-drip"></i>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Location Icon Color</label>
                                    <div class="input-group colorpickerinput colorpicker-element" data-colorpicker-id="2">
                                        <input type="color" class="form-control" id="location_icon_color" value="" name="location_icon_color">
                                        <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i class="fas fa-fill-drip"></i>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Website Icon Color</label>
                                    <div class="input-group colorpickerinput colorpicker-element" data-colorpicker-id="2">
                                        <input type="color" class="form-control" id="website_icon_color" value="" name="website_icon_color">
                                        <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i class="fas fa-fill-drip"></i>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>


                @if(!empty($template->content))
                @foreach($template->content as $text)
                <div id="_text_{{$loop->iteration}}_" class="section-edit-tab" style="display: none;">
                    <h5>Update Content</h5>
                    <hr>
                    <div>
                        <div class="row">
                            <div class="col-12">

                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Content</label>
                                        <textarea class="form-control" id="text_content_{{ $loop->iteration }}" name="text_content_{{ $loop->iteration }}" rows="5" maxlength="{{ $text->content_length }}">{{ $text->content }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Content Color</label>
                                        <div class="input-group colorpickerinput colorpicker-element" data-colorpicker-id="2">
                                            <input type="color" class="form-control" id="text_content_color_{{ $loop->iteration }}" value="" name="text_content_color_{{ $loop->iteration }}">
                                            <div class="input-group-append">
                                            <div class="input-group-text">
                                                <i class="fas fa-fill-drip"></i>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif


                @if(!empty($template->gallery))
                @foreach($template->gallery as $gallery)
                <div id="_gal_sec_{{$loop->iteration}}" class="section-edit-tab" style="display: none;">
                    <h5>Gallery Images</h5>
                    <hr>
                    <div>
                        <div class="row">
                            
                            <div class="col-12">
                                
                                @if($gallery->title != '')
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" class="form-control" id="hero_title_{{ $loop->iteration }}" name="image_title_{{ $loop->iteration }}" value="{{ $gallery->title }}">

                                </div>

                                
                                <div class="form-group">
                                    <label>Image Title Color</label>
                                    <div class="input-group colorpickerinput colorpicker-element" data-colorpicker-id="2">
                                        <input type="color" class="form-control" id="hero_text" value="" name="image_{{ $loop->iteration }}_color">
                                        <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i class="fas fa-fill-drip"></i>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                
                                @endif
                            
                                @if($gallery->image_path != '')
                                <div class="form-group">
                                    <label class="mb-1">Select Image</label> 
                                    <div class="small mb-1">Select <span class="text-danger">PNG</span>, <span class="text-danger">JPG</span> or <span class="text-danger">JPEG</span> image, Max file size <span class="text-danger">2MB</span>, and Max image width <span class="text-danger">1024px</span>.</div>
                                    <div class="input-group mb-2">
                                        <input type="file" class="form-control gall_img_upld cropperjs_input" data-id="tem_img{{ $loop->iteration }}" name="image_{{ $loop->iteration }}" accept="image/png, image/jpeg"
                                            data-function-name="templats_images_preview" 
                                            data-cancel-function="click_default_gal($(this));"
                                            data-exts="jpeg|jpg|png"
                                        />

                                        <input type="hidden" name="string_image_{{ $loop->iteration }}" id="string_image_{{ $loop->iteration }}" value="" />
                                        
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                            <i class="far fa-image"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h6>
                                        {{-- <span class="badge badge-danger dd_btn delete_gall_imgs">Detete</span> --}}
                                        <span class="badge badge-primary dd_btn default_gall_imgs">Default</span>
                                    </h6>
                                    <div>
                                        <img src="{{ asset('assets/templates/'.$id.'/'.$gallery->image_path)}}" style="max-height: 200px" class="img-fluid border open-crop" crop-modal="" id="galleryImage{{ $loop->iteration }}" alt="">
                                    </div>
                                </div>
                                @endif

                                @if($gallery->show_price == 1)
                                <div class="form-group">
                                    <label>Price</label>
                                    <input type="text" class="form-control" id="gallery_price_{{ $loop->iteration }}" name="gallery_price_{{ $loop->iteration }}" value="{{ $gallery->price }}" maxlength="9">
                                </div>
                                @endif

                                @if($gallery->show_sale_price == 1)
                                <div class="form-group">
                                    <label>Sale Price</label>
                                    <input type="text" class="form-control" id="gallery_sale_price_{{ $loop->iteration }}" name="gallery_sale_price_{{ $loop->iteration }}" value="{{ $gallery->sale_price }}" maxlength="9">
                                </div>
                                @endif

                                @if($gallery->show_tag_1 == 1)
                                <div class="form-group">
                                    <label>Tag 1 of Image</label>
                                    <input type="text" class="form-control" id="gallery_tag_1_{{ $loop->iteration }}" name="gallery_tag_1_{{ $loop->iteration }}" value="{{ $gallery->tag_1 }}">
                                </div>
                                @endif


                                @if($gallery->show_tag_2 == 1)
                                <div class="form-group">
                                    <label>Tag 2 of Image</label>
                                    <input type="text" class="form-control" id="gallery_tag_2_{{ $loop->iteration }}" name="gallery_tag_2_{{ $loop->iteration }}" value="{{ $gallery->tag_2 }}">
                                </div>
                                @endif

                                @if($gallery->show_tag_1 == 1)
                                {{-- <div class="col-12"> --}}
                                    <div class="form-group">
                                        <label>Tag 1 Color</label>
                                        <div class="input-group colorpickerinput colorpicker-element" data-colorpicker-id="2">
                                            <input type="color" class="form-control" id="tag_1_bg" value="" name="tag_1_bg_{{ $loop->iteration }}_color">
                                            <div class="input-group-append">
                                            <div class="input-group-text">
                                                <i class="fas fa-fill-drip"></i>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                {{-- </div> --}}
                                @endif


                                @if($gallery->show_tag_2 == 1)
                                {{-- <div class="col-12"> --}}
                                    <div class="form-group">
                                        <label>Tag 2 Color</label>
                                        <div class="input-group colorpickerinput colorpicker-element" data-colorpicker-id="2">
                                            <input type="color" class="form-control" id="tag_2_bg" value="" name="tag_2_bg_{{ $loop->iteration }}_color">
                                            <div class="input-group-append">
                                            <div class="input-group-text">
                                                <i class="fas fa-fill-drip"></i>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                {{-- </div> --}}
                                @endif

                            </div>

                            {{-- @if(!$loop->last)
                                <div class="col-12">
                                    <hr class="partition">
                                </div>
                            @endif --}}

                            
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
                

                {{-- <div id="_social_links_" class="section-edit-tab" style="display: none;">
                    <h5>Social Links</h5>
                    <hr>
                    <div>
                        <div class="row">

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Facebook Link</label>
                                    <input type="url" class="form-control" id="facebook_link" name="facebook_link" value="{{ $business->facebook_link }}">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Instagram Link</label>
                                    <input type="url" class="form-control" id="instagram_link" name="instagram_link" value="{{ $business->instagram_link }}">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Twitter Link</label>
                                    <input type="url" class="form-control" id="twitter_link" name="twitter_link" value="{{ $business->twitter_link }}">
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="form-group">
                                    <label>Linkedin Link</label>
                                    <input type="url" class="form-control" id="linkedin_link" name="linkedin_link" value="{{ $business->linkedin_link }}">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Youtube Link</label>
                                    <input type="url" class="form-control" id="youtube_link" name="youtube_link" value="{{ $business->youtube_link }}">
                                </div>
                            </div>
                            <hr>
                            

                        </div>
                    </div>
                </div> --}}


                @if(!empty($template->button))
                    @foreach($template->button as $button)
                    <div id="_call_to_action_{{ $loop->iteration }}" class="section-edit-tab" style="display: none;">
                        <h5>Call To Action Button</h5>
                        <hr>
                        <div>
                            <div class="row">
                                <div class="col-12 mb-4">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input hide-cta-btn" name="cta_button_hide_{{ $loop->iteration }}" value="1" id="hide_cta_btn_{{ $loop->iteration }}" @if($button->is_hidden == 1) checked @endif>
                                        <label class="custom-control-label" for="hide_cta_btn_{{ $loop->iteration }}">Hide CTA Button</label>
                                    </div>
                                    <small><i>If check "Hide CTA Button" the button will not be shown on the offer template.</i></small>
                                </div>
                                <div class="col-12">

                                    <div class="cta_info_section_{{ $loop->iteration }}">
                                        <div class="form-group">
                                            <label>Button Name <small>(Max 32 characters)</small></label>
                                            <input type="text" class="form-control" id="cta_button_name_{{ $loop->iteration }}" name="cta_button_name_{{ $loop->iteration }}" maxlength="32" value="{{ $button->name }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Button URL</label>
                                            <input type="url" class="form-control" id="cta_button_url_{{ $loop->iteration }}" name="cta_button_url_{{ $loop->iteration }}" value="{{ $button->link }}">
                                            <ol>
                                                <li><span style="font-size: 11px;">Example Link : https://mouthpublicity.io</span></li>
                                                <li><span style="font-size: 11px;">By default it is set to #.</span></li>
                                            </ol>
                                            
                                        </div>
                                        <div class="form-group">
                                            <label>Button Text Color</label>
                                            <div class="input-group colorpickerinput colorpicker-element" data-colorpicker-id="3">
                                                <input type="color" class="form-control" id="cta_button_text_color_{{ $loop->iteration }}" value="{{ $button->btn_text_color }}" name="cta_button_text_color_{{ $loop->iteration }}">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-fill-drip"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" name="btn_style_type_{{ $loop->iteration }}" id="btn_style_type_{{ $loop->iteration }}" value="{{ $button->btn_style_type }}" />

                                            <label>Button {{ $button->btn_style_type }} Color</label>
                                            <div class="input-group colorpickerinput colorpicker-element" data-colorpicker-id="4">
                                                <input type="color" class="form-control" id="cta_button_bg_color_{{ $loop->iteration }}" value="{{ $button->btn_style_color }}" name="cta_button_bg_color_{{ $loop->iteration }}">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-fill-drip"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
        
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif

                {{-- Template Thumbnail --}}
                <input type="hidden" name="thumbnail" value="" />
                
                </form>
            </div>
            <div class="close-ea"> Done</div>
            </div>
        
        </section>

        {{-- image cropper --}}
        @include('components.cropperjs')

        @include('layouts.business.scripts')

        @yield('end_body')

        

        <script>
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            });

            $("#inputs_area").off('click onClick').on('click bindClickEvent', function(e) {
                if($(e.target).hasClass('show')) {
                    $("#inputs_area").removeClass("show");
                }
            });

        </script>

        @include('builder.builder-js')

        @include('builder.canvas')

        <div id="overlay">
          <div class="cv-spinner">
            <span class="spinner"></span>
          </div>
        </div>
    </body>
</html>