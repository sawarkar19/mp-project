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

        {{-- <meta property="og:image" content="{{ asset('assets/templates/custom/share-'.$offer->image) }}"> --}}
        
        @php
            $folderPath = base_path('../assets/templates/resize-file/');
        @endphp
        {{-- facebook --}}
        @if(file_exists($folderPath."fb-resize-".$offer->image))
            <meta property="og:image" content="{{ asset('assets/templates/resize-file/fb-resize-'.$offer->image) }}">
        {{-- Twitter --}}
        {{-- twiiter stop for google review --}}
        {{-- @elseif(file_exists($folderPath."tw-resize-".$offer->image))
            <meta property="og:image" content="{{ asset('assets/templates/resize-file/tw-resize-'.$offer->image) }}">
            <meta property="og:image:alt" content="{{ asset('assets/templates/resize-file/tw-resize-'.$offer->image) }}"> --}}
        {{-- Not Match --}}    
        @else
            <meta property="og:image" content="{{ asset('assets/templates/custom/share-'.$offer->image) }}">
        @endif

        <meta property="og:image:width" content="1200"/>
        <meta property="og:image:height" content="630"/>
        <meta property="og:locale" content="en_US"/>
        
        @if($business->website != '')
        <meta property="og:url" content="{{ $business->website }}">
        @else
        <meta property="og:url" content="{{ URL::full()}}">
        @endif
        <!-- Twitter -->
        <meta name="twitter:card" content="summary_large_image">
        @if($business->website != '')
        <meta name="twitter:url" content="{{ $business->website }}">
        @else
        <meta name="twitter:url" content="{{ URL::full() }}">
        @endif
        
    @else
        <title>MouthPublicity.io Templates</title>
    @endif

    <link rel="stylesheet" href="{{ asset('assets/frontend/css/bootstrap.min.css') }}">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cookie&family=Source+Sans+3:wght@400&display=swap');
        @import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css");
    </style>

    <script src="{{asset('assets/js/jquery-3.5.1.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    

    @if($only_view != 1)
        <script type="text/javascript">var isShowPopup = '{{ $isShowPopup ?? 0 }}'; </script>
        <script src="{{ asset('assets/js/targets-template.js') }}"></script>
    @endif

</head>
<body>
    @if($offer != '' && $show_header == 1)
        @include('builder.header')
    @endif
    
    @include('builder.custom.index')
    
</body>
    {{-- PopUp code for count --}}
    @if(request()->get('media'))
        <script src="{{asset('assets/js/sweetalert2.all.min.js')}}"></script>
    @endif

    <script >
        var is_posted = '{{ $is_posted }}';
        // alert(is_posted);
        var post_status = '{{ $offer->social_post__db_id }}';
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