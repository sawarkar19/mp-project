<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if($show_meta == 1)
        <!-- Primary Meta Tags -->
        <title>{{ $offer->title.' : '.$business->business_name }}</title>

        <meta name="title" content="{{ $offer->title }}">
        <meta name="description" content="{{ $offer->description }}">
        <meta name="keywords" content="">

        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:title" content="{{ $offer->title }}">
        <meta property="og:description" content="{{ $offer->description }}">

        
        @php
            $folderPath = base_path('../assets/templates/resize-file/');
            // dd(request()->segment(2));
        @endphp

        {{-- facebook --}}
        @if(file_exists($folderPath."fb-resize-".$template->thumbnail))
            <meta property="og:image" content="{{ asset('assets/templates/resize-file/fb-resize-'.$template->thumbnail) }}">
            <meta property="og:image:alt" content="{{ asset('assets/templates/resize-file/fb-resize-'.$template->thumbnail) }}">
        {{-- Twitter --}}
        {{-- twiiter stop for google review --}}
        {{-- @elseif(file_exists($folderPath."tw-resize-".$template->thumbnail))
            <meta property="og:image" content="{{ asset('assets/templates/resize-file/tw-resize-'.$template->thumbnail) }}">
            <meta property="og:image:alt" content="{{ asset('assets/templates/resize-file/tw-resize-'.$template->thumbnail) }}"> --}}
        {{-- Not Match --}}    
        @else
            <meta property="og:image" content="{{ asset('assets/offer-thumbnails/share-'.$template->thumbnail) }}">
            <meta property="og:image:alt" content="{{ asset('assets/offer-thumbnails/share-'.$template->thumbnail) }}">
        @endif

        <meta property="og:image:width" content="1200"/>
        <meta property="og:image:height" content="630"/>
        <meta property="og:locale" content="en_US"/>
        
        @if($offer->website_url != '')
            <meta property="og:url" content="{{ $offer->website_url }}">
        @else
            <meta property="og:url" content="{{ URL::full()}}">
        @endif
        <!-- Twitter -->
        <meta name="twitter:card" content="summary_large_image">
        @if($offer->website_url != '')
            <meta name="twitter:url" content="{{ $offer->website_url }}">
        @else
            <meta name="twitter:url" content="{{ URL::full() }}">
        @endif
        
    @else
        <title>MouthPublicity.io Templates</title>
    @endif

    <link rel="stylesheet" href="{{ asset('assets/frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{asset('assets/templates/'.$id.'/template-style.css')}}">

    <script src="{{asset('assets/js/jquery-3.5.1.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>

    @if($only_view != 1)
        <script type="text/javascript">var isShowPopup = '{{ $isShowPopup ?? 0 }}'; </script>
        <script src="{{ asset('assets/js/targets-template.js') }}"></script>
    @endif


    <style>
        :root{
            --color-background: {{ $template->bg_color ?? '#000000' }};
            --color-default-color:  {{ $template->default_color ?? '#000000' }};
            --color-business-name: {{ $template->business_name_color ?? '#000000' ?? '#000000' }};
            --color-tag-line: {{ $template->tag_line_color ?? '#000000' }};


            --color-temp-head: {{ $template->hero_title_color ?? '#000000' }};
            --color-text-color: {{ $template->hero_text_color ?? '#000000' }};
            --color-extra-head: {{ $template->extra_heading_1_color ?? '#000000' }};
            --color-extra-text: {{ $template->extra_text_1_color ?? '#000000' }};


            --color-cta-button: #FFFFFF;
            --bgcolor-cta-button: #000000;


            @php
                $g = 1;   
                foreach ($gallery_color_titles as $key => $title_col) {
            @endphp
                --color-image-title{{ $key }}: {{ $title_col ?? '#000000' }};
            @php
                    $g++;
                }
            @endphp


            @php
                $c = 1;   
                foreach ($text_colors as $key => $text_col) {
                    
            @endphp
                --color-text-content{{ $key }}: {{ $text_col ?? '#000000' }};
            @php
                    $c++;
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
                $t = 1;   
                foreach ($tag_1_bg_colors as $key => $tag_col) {
            @endphp
                --color-tag1-bg{{ $key }}: {{ $tag_col ?? '#000000' }};
            @php
                    $t++;
                }
            @endphp

            @php
                $t = 1;   
                foreach ($tag_2_bg_colors as $key => $tag_col) {
            @endphp
                --color-tag2-bg{{ $key }}: {{ $tag_col ?? '#000000' }};
            @php
                    $t++;
                }
            @endphp

            --color-icon-website: {{ $template->contact_icons->website_icon_color ?? '#000000' }};
            --color-icon-location: {{ $template->contact_icons->location_icon_color ?? '#000000' }};
            --color-icon-whatsapp: {{ $template->contact_icons->whatsapp_icon_color ?? '#000000' }};
            --color-icon-contact: {{ $template->contact_icons->contact_icon_color ?? '#000000' }};
            
        }

        /*  Apply CSS */
        @php
            $g = 1;   
            foreach ($gallery_color_titles as $g_key => $title_col) {
        @endphp
            .template-container #tem_image_title_{{ $g_key }}{color: var(--color-image-title{{ $g_key }});}
        @php
                $g++;
            }
        @endphp

        @php
                $c = 1;   
                foreach ($text_colors as $key => $text_col) {
        @endphp
                    .template-container #text_input_{{ $key }}{color: var(--color-text-content{{ $key }}) !important;}
        @php
                    $c++;
                }
        @endphp

        @php
            $t = 1;   
            foreach ($tag_1_bg_colors as $t_key => $tag_col) {
        @endphp
            .template-container #tem_img{{ $t_key }}::after{background: var(--color-tag1-bg{{ $t_key }}) !important;}
        @php
                $t++;
            }
        @endphp

        @php
            $t = 1;   
            foreach ($tag_2_bg_colors as $t_key => $tag_col) {
        @endphp
            
            .template-container #tem_tag_bg{{ $t_key }}{background: var(--color-tag2-bg{{ $t_key }}) !important;}
        @php
                $t++;
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


        .website_anchr{
            text-decoration: none!important;
            color: inherit!important;
        }
    </style>
</head>
<body>

    @if($offer != '' && $show_header == 1)
        @include('builder.header')
    @endif
    
    @include('builder.preview.'.$id)
    
</body>

    @if(request()->get('media'))
        <script src="{{asset('assets/js/sweetalert2.all.min.js')}}"></script>
    @endif
    <script >
        var is_posted = '{{ $is_posted }}';
        /* alert(is_posted); */
        var post_status = '{{ $offer ? $offer->social_post__db_id : NULL }}';
        if(post_status != ''){
            if(is_posted == 0){
                $('#offer_post_status span').remove();
                
                $('#offer_post_status').append('<span id="offer_post_status" style="color: #F2F2F2" class="badge badge-warning py-1">Scheduled</span>');
            }else{
                
                $('#offer_post_status span').remove();
                $('#offer_post_status').append('<span id="offer_post_status" style="color: #F2F2F2" class="badge badge-success py-1">Posted</span>');
            }
        }
    </script>
</html>