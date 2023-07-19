<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="shortcut icon" href="{{asset('favicon.ico')}}" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/front/vendor/bootstrap/css/bootstrap.min.css') }}">

    {{-- <link rel="stylesheet" href="{{ asset('assets/js/line-awesome.min.css') }}" > --}}

    <link rel="stylesheet" href="{{ asset('assets/instant_card/css/style.css') }}">
    <title>{{ $offer->title }}</title>

    <style>
        .selected-date{
            color: #ffffff;
            background-color: rgba(var(--color-primary), 1);
            border-radius: 4px;
        }
        body{
            background: linear-gradient(90deg, rgba(0,36,156, 0.8) 0%, rgb(0,255,175, 0.8) 180%);
        }
        #offers .instant_offer_card{
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 0px;
        }
        .more_text{
            display: none;
        }
        .show_more,.show_less{
            text-decoration: none;
        }
        .hide_task{
            display: none;
        }
        .no-tasks svg{
            display: block;
            margin: 25px auto;
            width: 50px;
            height: 50px;
        }

        .instant_offer_card .img > .img_thumb{
            background-position: top left !important;
            transition: all 800ms ease !important;
        }
        .instant_offer_card .img > .img_thumb:hover{
            background-position: bottom right !important;
        }

        #date-month-modal .modal-dialog{
            pointer-events: all;
        }

        .custom_calendar .days {
            list-style: none;
            margin: 0;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: start;
            padding-left: 0px;
        }
        .custom_calendar .days li {
            text-align: center;
            cursor: pointer;
            flex: 0 1 14.20%;
            height: 38px;
            line-height: 38px;
        }
        .custom_calendar .days li:hover,
        .custom_calendar .days li:active,
        .custom_calendar .days li:focus {
            color: #ffffff;
            background-color: rgba(var(--color-primary), 1);
            border-radius: 4px;
        }

        .custom_calendar .days li .active {
            padding: 5px;
            background: #1abc9c;
            color: white !important
        }

        .close_calendar{
            font-size: 20px;
            line-height: 28px;
            width: 28px;
            height: 28px;
            color: #000000;
            background-color: #ffffff;
            border: 1px solid #000000;
            border-radius: 50%;
            text-decoration: none !important;
            text-align: center;
        }

        /* Loader */
        #loader{
            position: fixed;
            z-index: 9999;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0, 0.6);
            display: none;
        }
        #loader .content{
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            height: 100%;
            width: 100%;
        }
        #loader svg{
            animation-name: spin;
            animation-duration: 4000ms;
            animation-iteration-count: infinite;
            animation-timing-function: linear; 
        }
        @keyframes spin {
            from { transform:rotate(0deg); }
            to { transform:rotate(360deg); }
        }
        @-webkit-keyframes spin {
            from { transform:rotate(0deg); }
            to { transform:rotate(360deg); }
        }
    </style>
  </head>
  <body>

    

    <section id="offers">
      <div class="container">
        <div class="my-3">

          <div class="instant_offer_card shadow-sm">
            <div class="inner">

              <div class="img mb-1">
                  {{-- IMAGE THUMBNAIL --}}
                    @php
                        if($offer->type == 'custom'){
                            if($offer->website_url != ''){
                                $img_url = asset('assets/img/default_website_img.jpg');
                            }else{
                                $img_url = asset('assets/templates/custom').'/'.$offer->image;
                            } 
                        }else{
                            $img_url = asset('assets/offer-thumbnails').'/'.$offer->offer_template->thumbnail;
                        }
                    @endphp
                    <div class="img_thumb" style="background-image:url({{ $img_url }});"></div>
              </div>



              {{-- TITLE  --}}
              <div class="title pb-0">
                <h3>{{ $offer->title }}</h3>
              </div>
              
              {{-- INFORMATION DATA  --}}
              <div class="info">
                @if(strlen($offer->description) > 150)
                    <p class="less_text">{{ \Illuminate\Support\Str::limit($offer->description, 150, $end='...') }} <span><a href="#" class="show_more"> Show more</a></span></p>
                    <p class="more_text">{{ $offer->description }} <span><a href="#" class="show_less"> Show less</a></span></p>
                @else
                    <p class="less_text">{{ $offer->description }}</p>
                @endif

              </div>

              <div class="dashed-diveder"></div>

              
              <div class="">

                @if(count($instantTasks) == 0)
                
                <span class="no-tasks">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="rotate" viewBox="0 0 16 16">
                    <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                    <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                    </svg>
                </span>

                @else

                {{-- If Tasks (offer) not complete  --}}
                
                <div class="text-center py-3 px-2 border-bottom">
                    <h6 class="mb-0 small">Complete <span class="fw-bold text-primary">{{ $settings->details['minimum_task'] }} Task</span> to Unlock Offer</h6>
                </div>
                
                {{-- Instant Tasks List --}}
                    <div class="task_list">
                        @foreach($instantTasks as $instantKey => $instantTask)
                            @php
                                $isComingSoon = $instantTask->task->coming_soon ?? 0;
                            @endphp

                            @if($isComingSoon==0)

                                @php
                                    $isTaskShow = 1;
                                    $redirectBaseUrl = $iconColor = $icon = $reddemIcon = $openTaskModal = "";
                                    $isNoAppLinkClass = $task_value = "";
                                    
                                    // if(( !in_array($instantTask->id, $redeemedTasks) && in_array($instantTask->id, $completedTasks) ) || !in_array($instantTask->id, $completedTasks)){
                                    //     $is_hide_task = '';
                                    // }
                                    if($subscription->status == '1' && in_array($instantTask->id, $redeemedTasks)){
                                        $is_hide_task = 'hide_task';
                                    }else{
                                        $is_hide_task = '';
                                    }

                                    // redeem not completred
                                    if(!in_array($instantTask->id, $completedTasks)){
                                        $reddemIcon = '<span class="pending_task_'.$instantTask->id.'"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" style="fill: var(--bs-orange);" class="" viewBox="0 0 16 16">
                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                                        </svg></span>
                                        <span class="processing_task_'.$instantTask->id.'" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="rotate" viewBox="0 0 16 16">
                                            <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                                            <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                                        </svg></span>
                                        <span class="complete_task_'.$instantTask->id.'" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#189325" viewBox="0 0 16 16">
                                            <path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01-.622-.636zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708z"/>
                                        </svg><span>';
                                    }else{
                                    // {{-- If Task is Processing  --}}
                                        $reddemIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#189325" viewBox="0 0 16 16">
                                                        <path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01-.622-.636zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708z"/>
                                                    </svg>';
                                    }

                                    // FACEBOOK
                                    if($tasks[$instantTask->task_id]=="fb_page_url" || $tasks[$instantTask->task_id]=="fb_comment_post_url" || $tasks[$instantTask->task_id]=="fb_like_post_url" || $tasks[$instantTask->task_id]=="fb_share_post_url"){

                                        if($tasks[$instantTask->task_id]=="fb_page_url"){
                                            $redirectBaseUrl = "fb://page/".$instantTask['task_value'];
                                            $isNoAppLinkClass = "fb-page-link";
                                            $task_value = $instantTask['task_value'];
                                        }
                                        else{
                                            // $redirectBaseUrl = "fb://facewebmodal/f?href=/".$instantTask['task_value'];
                                            // $redirectBaseUrl = "fb://page?pfbid0uAnwWUeVAGoGVygqo7fwLB2LKA1wDi8stDwF2btyuVwKkK3yw4bWPjphJh7NZTuWl";

                                            $redirectBaseUrl = $instantTask['task_value']; // redirect after login in browser
                                            $isNoAppLinkClass = "fb-post-link";
                                            $task_value = $instantTask['task_value'];
                                        }

                                        $iconColor = "fb";
                                        $icon = '<div class="ins_icon">
                                            <div class="ico-thm_">
                                                <svg viewBox="0 0 36 36" fill="url(#jsc_s_2)" height="24" width="24">
                                                    <defs>
                                                        <linearGradient x1="50%" x2="50%" y1="97.0782153%" y2="0%" id="jsc_s_2">
                                                            <stop offset="0%" stop-color="#0062E0"></stop>
                                                            <stop offset="100%" stop-color="#19AFFF"></stop>
                                                        </linearGradient>
                                                    </defs>
                                                    <path d="M15 35.8C6.5 34.3 0 26.9 0 18 0 8.1 8.1 0 18 0s18 8.1 18 18c0 8.9-6.5 16.3-15 17.8l-1-.8h-4l-1 .8z"></path>
                                                    <path class="p361ku9c" fill="#ffffff" d="M25 23l.8-5H21v-3.5c0-1.4.5-2.5 2.7-2.5H26V7.4c-1.3-.2-2.7-.4-4-.4-4.1 0-7 2.5-7 7v4h-4.5v5H15v12.7c1 .2 2 .3 3 .3s2-.1 3-.3V23h4z"></path>
                                                </svg> 
                                            </div>
                                        </div>';

                                        $openTaskModal = "";
                                        if($tasks[$instantTask->task_id]=="fb_page_url"){
                                            // $openTaskModal = 'checkFacebookLikeOurPage("'.$instantTask['id'].'")';
                                        }
                                        else if($tasks[$instantTask->task_id]=="fb_comment_post_url"){
                                            // $openTaskModal = 'checkFacebookPostComment("'.$instantTask['id'].'")';
                                        }
                                        else if($tasks[$instantTask->task_id]=="fb_like_post_url"){
                                            // $openTaskModal = 'checkFacebookPostLike("'.$instantTask['id'].'")';
                                        }
                                        // else if($tasks[$instantTask->task_id]=="fb_share_post_url"){
                                        //     $openTaskModal = 'checkFacebookSharePost("'.$instantTask['id'].'")';
                                        // }
                                    }

                                    // INTAGRAM
                                    else if($tasks[$instantTask->task_id]=="insta_profile_url" || $tasks[$instantTask->task_id]=="insta_post_url" || $tasks[$instantTask->task_id]=="insta_comment_post_url"){
                                        if($tasks[$instantTask->task_id]=="insta_profile_url"){
                                            $isNoAppLinkClass = "instagram-follow-link";
                                        }
                                        else{
                                            $isNoAppLinkClass = "instagram-post-link";
                                        }
                                        $redirectBaseUrl = $instantTask['task_value'];
                                        $task_value = $instantTask['task_value'];

                                        $iconColor = "ig";
                                        $icon = '<div class="ins_icon">
                                            <div class="ico-thm_">
                                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" height="24" width="24" enable-background="new 0 0 200 200">
                                                    <linearGradient id="SVGID_1_" gradientUnits="userSpaceOnUse" x1="31.1326" y1="166.5063" x2="167.0317" y2="35.2666">
                                                        <stop  offset="0" style="stop-color:#FED01C"/>
                                                        <stop  offset="0.2503" style="stop-color:#FE8B44"/>
                                                        <stop  offset="0.4144" style="stop-color:#FE5265"/>
                                                        <stop  offset="0.4889" style="stop-color:#FA3B75"/>
                                                        <stop  offset="0.577" style="stop-color:#F72783"/>
                                                        <stop  offset="0.6354" style="stop-color:#F61F88"/>
                                                        <stop  offset="0.9086" style="stop-color:#B20AC0"/>
                                                        <stop  offset="0.9422" style="stop-color:#AF09C3"/>
                                                        <stop  offset="0.9703" style="stop-color:#A406CB"/>
                                                        <stop  offset="0.9964" style="stop-color:#9301D9"/>
                                                        <stop  offset="1" style="stop-color:#9000DC"/>
                                                    </linearGradient>
                                                    <circle fill="url(#SVGID_1_)" cx="100" cy="100" r="94.9"/>
                                                    <g>
                                                        <path fill="#FFFFFF" d="M72.5,37.1c18.5,0,37.1,0,55.6,0c0.6,0.1,1.3,0.3,1.9,0.4c14.9,2.7,25.1,11.1,30.8,25 c1.3,3.1,1.8,6.4,2.4,9.7c0,18.5,0,37.1,0,55.6c-0.1,0.6-0.3,1.1-0.3,1.7c-0.8,5.6-2.7,10.8-5.8,15.5c-7.6,11.3-18.3,17.7-32,18 c-16.6,0.3-33.1,0.1-49.7,0.1c-6.4,0-12.5-1.7-18-5c-13.2-7.8-20-19.5-20.1-34.9c-0.1-15.4,0-30.9,0-46.4c0-2.2,0.1-4.3,0.5-6.5 c2.7-14.9,11.1-25.2,25.2-30.9C66,38.2,69.3,37.7,72.5,37.1z M151.4,98.4c-0.2-6.7,0.4-15.2-0.2-23.7 c-0.7-10.3-5.9-17.7-14.9-22.6c-4.2-2.3-8.7-3-13.4-3c-13.6,0-27.3,0-40.9,0c-2.3,0-4.7,0-7,0.2c-10.3,0.9-17.7,6-22.6,15 c-2.3,4.2-3,8.7-3,13.4c0,13.6,0,27.3,0,40.9c0,2.3,0,4.7,0.2,7c0.9,10.3,6,17.7,15,22.6c4.2,2.3,8.7,3,13.4,3 c13.6,0,27.3,0,40.9,0c2.3,0,4.7,0,7-0.2c10.3-0.9,17.7-6,22.6-15c2.2-4.1,3-8.7,3-13.3C151.4,115.2,151.4,107.6,151.4,98.4z"/>
                                                        <path fill="#FFFFFF" d="M100.3,131.7c-17.5,0-31.5-14.1-31.5-31.6c0-17.5,14.1-31.5,31.6-31.5c17.5,0,31.5,14.1,31.5,31.6 C131.9,117.6,117.8,131.7,100.3,131.7z M119.9,100c-0.3-11.2-8.9-19.5-19.7-19.5c-11.2,0.1-19.5,8.9-19.4,19.5 c0.1,11.2,8.9,19.6,19.6,19.5C111.6,119.5,119.7,110.7,119.9,100z"/>
                                                        <path fill="#FFFFFF" d="M138.5,66.3c0,2.3-2.1,4.3-4.4,4.3c-2.3,0-4.3-2.1-4.3-4.4c0-2.4,2.1-4.4,4.4-4.3 C136.6,62,138.5,64,138.5,66.3z"/>
                                                    </g>
                                                </svg>
                                            </div>
                                        </div>';

                                        $openTaskModal = "";
                                    }

                                    // TWITTER
                                    else if($tasks[$instantTask->task_id]=="tw_username" || $tasks[$instantTask->task_id]=="tw_tweet_url"){
                                        if($tasks[$instantTask->task_id]=="tw_username"){
                                            $tweet_ID = $instantTask['task_value'];
                                            $prefix = '@';
                                            if (substr($instantTask['task_value'], 0, strlen($prefix)) == $prefix) {
                                                $tweet_ID = substr($instantTask['task_value'], strlen($prefix));
                                            }

                                            $redirectBaseUrl = 'https://twitter.com/'.$tweet_ID;
                                            $isNoAppLinkClass = "tw-profile-link";
                                            $task_value = $tweet_ID;
                                        }
                                        else{
                                            $redirectBaseUrl = $instantTask['task_value'];
                                            $isNoAppLinkClass = "tw-post-link";
                                            $task_value = $instantTask['task_value'];
                                        }
                                        
                                        $iconColor = "tw";
                                        $icon = '<div class="ins_icon">
                                            <div class="ico-thm_">
                                                <svg version="1.1" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg" height="24" width="24">
                                                    <circle cx="24" cy="24" fill="#1CB7EB" r="24" />
                                                    <path fill="#FFFFFF" d="M36.8,15.4c-0.9,0.5-2,0.8-3,0.9c1.1-0.7,1.9-1.8,2.3-3.1c-1,0.6-2.1,1.1-3.4,1.4c-1-1.1-2.3-1.8-3.8-1.8    c-2.9,0-5.3,2.5-5.3,5.7c0,0.4,0,0.9,0.1,1.3c-4.4-0.2-8.3-2.5-10.9-5.9c-0.5,0.8-0.7,1.8-0.7,2.9c0,2,0.9,3.7,2.3,4.7    c-0.9,0-1.7-0.3-2.4-0.7c0,0,0,0.1,0,0.1c0,2.7,1.8,5,4.2,5.6c-0.4,0.1-0.9,0.2-1.4,0.2c-0.3,0-0.7,0-1-0.1    c0.7,2.3,2.6,3.9,4.9,3.9c-1.8,1.5-4.1,2.4-6.5,2.4c-0.4,0-0.8,0-1.3-0.1c2.3,1.6,5.1,2.6,8.1,2.6c9.7,0,15-8.6,15-16.1    c0-0.2,0-0.5,0-0.7C35.2,17.6,36.1,16.6,36.8,15.4z"/>
                                                </svg>
                                            </div>
                                        </div>';

                                        if($tasks[$instantTask->task_id]=="tw_username"){
                                            // $openTaskModal = 'checkFollow("'.$instantTask['id'].'")';
                                        }
                                        else if($tasks[$instantTask->task_id]=="tw_tweet_url"){
                                            // $openTaskModal = 'checkTwLikedBy("'.$instantTask['id'].'")';
                                        }
                                    }

                                    // LINKEDIN
                                    else if($tasks[$instantTask->task_id]=="li_company_url" || $tasks[$instantTask->task_id]=="li_post_url"){
                                        $redirectBaseUrl = $instantTask['task_value'];

                                        $iconColor = "li";
                                        $icon = '<div class="ins_icon">
                                            <div class="ico-thm_">
                                                <svg version="1.1" viewBox="0 0 1000 1000" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill="#0078B5" d="M500,1000L500,1000C223.9,1000,0,776.1,0,500l0,0C0,223.9,223.9,0,500,0l0,0c276.1,0,500,223.9,500,500l0,0   C1000,776.1,776.1,1000,500,1000z" />
                                                    <g>
                                                    <path fill="#ffffff" d="M184.2,387.3h132.9v427.7H184.2V387.3z M250.7,174.7c42.5,0,77,34.5,77,77.1s-34.5,77.1-77,77.1     c-42.6,0-77.1-34.5-77.1-77.1C173.5,209.3,208,174.7,250.7,174.7" />
                                                    <path fill="#ffffff" d="M400.5,387.3H528v58.4h1.8c17.7-33.6,61-69.1,125.8-69.1c134.6,0,159.5,88.6,159.5,203.7v234.7H682.2V607.1     c0-49.7-0.9-113.4-69.1-113.4c-69.2,0-79.8,54-79.8,109.8v211.6H400.5V387.3z" />
                                                    </g>
                                                </svg>
                                            </div>
                                        </div>';
                                        
                                        $openTaskModal = "";
                                    }

                                    // YOUTUBE
                                    else if($tasks[$instantTask->task_id]=="yt_channel_url" || $tasks[$instantTask->task_id]=="yt_like_url" || $tasks[$instantTask->task_id]=="yt_comment_url"){
                                        $redirectBaseUrl = $instantTask['task_value'];

                                        $iconColor = "yt";
                                        $icon = '<div class="ins_icon">
                                            <div class="ico-thm_">
                                                <svg  version="1.1" viewBox="0 0 1000 1000" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill="#FF0000" d="M500,1000L500,1000C223.9,1000,0,776.1,0,500v0C0,223.9,223.9,0,500,0h0c276.1,0,500,223.9,500,500v0   C1000,776.1,776.1,1000,500,1000z" />
                                                    <path fill="#ffffff" d="M818.2,339.1c-7.6-28.8-30.1-51.4-58.7-59.1c-51.8-14-259.4-14-259.4-14s-207.7,0-259.4,14   c-28.6,7.7-51.1,30.3-58.7,59.1C168,391.2,168,500,168,500s0,108.8,13.9,160.9c7.6,28.8,30.1,51.4,58.7,59.1   c51.8,14,259.4,14,259.4,14s207.7,0,259.4-14c28.6-7.7,51.1-30.3,58.7-59.1C832,608.8,832,500,832,500S832,391.2,818.2,339.1z    M432.1,598.7V401.3L605.6,500L432.1,598.7z" />
                                                </svg>
                                            </div>
                                        </div>';

                                        if($tasks[$instantTask->task_id]=="yt_channel_url"){
                                            // $openTaskModal = 'checkSubscribe("'.$instantTask['id'].'")';
                                            $isNoAppLinkClass = "youtube-channel-link";
                                            $task_value = $instantTask['task_value'];
                                        }
                                        else if($tasks[$instantTask->task_id]=="yt_comment_url"){
                                            // $openTaskModal = 'checkComment("'.$instantTask['id'].'")';
                                            $isNoAppLinkClass = "youtube-post-link";
                                            $task_value = $instantTask['task_value'];
                                        }
                                        else if($tasks[$instantTask->task_id]=="yt_like_url"){
                                            // $openTaskModal = 'checkLike("'.$instantTask['id'].'")';
                                            $isNoAppLinkClass = "youtube-post-link";
                                            $task_value = $instantTask['task_value'];
                                        }
                                    }

                                    // GOOGLE REVIEW
                                    else if($tasks[$instantTask->task_id]=="google_review_link"){
                                        $redirectBaseUrl = "https://search.google.com/local/writereview?placeid=".$instantTask['task_value'];

                                        $iconColor = "ins_icon";
                                        $icon = '<div class="ins_icon">
                                            <div class="ico-thm_">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4" />
                                                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853" />
                                                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05" />
                                                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335" />
                                                    <path d="M1 1h22v22H1z" fill="none" />
                                                </svg>
                                            </div>
                                        </div>';
                                        
                                        // dd($is_hide_task, $messageWallet->total_messages);
                                        if($messageWallet->total_messages > 0){
                                            $openTaskModal = 'checkGoogleReview("'.$instantTask['id'].'")';
                                        }else{
                                            if(!in_array($instantTask->id, $completedTasks)){
                                                // dd($is_hide_task, $messageWallet->total_messages);
                                                $isTaskShow = 0; 
                                            }
                                        }
                                    }

                                    // WEBSITE
                                    else if($tasks[$instantTask->task_id]=="visit_page_url"){
                                        $redirectBaseUrl = $instantTask['task_value'];

                                        $iconColor = "ins_icon";
                                        $icon = '<div class="ins_icon">
                                            <div class="ico-thm">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-globe2" viewBox="0 0 16 16">
                                                    <path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm7.5-6.923c-.67.204-1.335.82-1.887 1.855-.143.268-.276.56-.395.872.705.157 1.472.257 2.282.287V1.077zM4.249 3.539c.142-.384.304-.744.481-1.078a6.7 6.7 0 0 1 .597-.933A7.01 7.01 0 0 0 3.051 3.05c.362.184.763.349 1.198.49zM3.509 7.5c.036-1.07.188-2.087.436-3.008a9.124 9.124 0 0 1-1.565-.667A6.964 6.964 0 0 0 1.018 7.5h2.49zm1.4-2.741a12.344 12.344 0 0 0-.4 2.741H7.5V5.091c-.91-.03-1.783-.145-2.591-.332zM8.5 5.09V7.5h2.99a12.342 12.342 0 0 0-.399-2.741c-.808.187-1.681.301-2.591.332zM4.51 8.5c.035.987.176 1.914.399 2.741A13.612 13.612 0 0 1 7.5 10.91V8.5H4.51zm3.99 0v2.409c.91.03 1.783.145 2.591.332.223-.827.364-1.754.4-2.741H8.5zm-3.282 3.696c.12.312.252.604.395.872.552 1.035 1.218 1.65 1.887 1.855V11.91c-.81.03-1.577.13-2.282.287zm.11 2.276a6.696 6.696 0 0 1-.598-.933 8.853 8.853 0 0 1-.481-1.079 8.38 8.38 0 0 0-1.198.49 7.01 7.01 0 0 0 2.276 1.522zm-1.383-2.964A13.36 13.36 0 0 1 3.508 8.5h-2.49a6.963 6.963 0 0 0 1.362 3.675c.47-.258.995-.482 1.565-.667zm6.728 2.964a7.009 7.009 0 0 0 2.275-1.521 8.376 8.376 0 0 0-1.197-.49 8.853 8.853 0 0 1-.481 1.078 6.688 6.688 0 0 1-.597.933zM8.5 11.909v3.014c.67-.204 1.335-.82 1.887-1.855.143-.268.276-.56.395-.872A12.63 12.63 0 0 0 8.5 11.91zm3.555-.401c.57.185 1.095.409 1.565.667A6.963 6.963 0 0 0 14.982 8.5h-2.49a13.36 13.36 0 0 1-.437 3.008zM14.982 7.5a6.963 6.963 0 0 0-1.362-3.675c-.47.258-.995.482-1.565.667.248.92.4 1.938.437 3.008h2.49zM11.27 2.461c.177.334.339.694.482 1.078a8.368 8.368 0 0 0 1.196-.49 7.01 7.01 0 0 0-2.275-1.52c.218.283.418.597.597.932zm-.488 1.343a7.765 7.765 0 0 0-.395-.872C9.835 1.897 9.17 1.282 8.5 1.077V4.09c.81-.03 1.577-.13 2.282-.287z"/>
                                                </svg>
                                            </div>
                                        </div>';

                                        $openTaskModal = "";
                                    }
                                @endphp

                                @if($isTaskShow)
                                    <div class="ins_task border-bottom {{ $iconColor }} {{ $is_hide_task }}">
                                        <a 
                                            @if(!in_array($instantTask->id, $completedTasks)) 
                                                target="_blank"
                                                @if($isNoAppLinkClass=="" && $task_value=="")
                                                    href="{{ $redirectBaseUrl }}" 
                                                @endif 

                                                @if($openTaskModal != "") 
                                                    onclick="{{ $openTaskModal }}" 
                                                @endif 

                                                data-instant_task_id="{{ $instantTask['id'] }}"
                                                data-task_value="{{ $task_value }}" data-task_key="{{ $tasks[$instantTask->task_id] }}"

                                                
                                                class="task_click @if($redirectBaseUrl!="") {{ $isNoAppLinkClass }} @endif" style="cursor: pointer;"
                                            @else
                                                class="disable"
                                            @endif
                                            id="instant_task_id_{{ $instantTask->id }}"
                                            {{-- id="{{ @$instantTask->id }}" --}}
                                            >

                                            <div class="inner d-flex justify-content-between align-items-center">
                                                {{-- ICON --}}
                                                {!! $icon !!}
                                                <div class="ins_title">
                                                    {{-- Title --}}
                                                    <h6 class="mb-0">{!! @$instantTask->task->name !!}</h6>
                                                </div>
                                                <div class="tic_ico verifing_conent_{{ $tasks[$instantTask->task_id] }}">
                                                    <span class="verifing_text" id="verifing_text_{{ $tasks[$instantTask->task_id] }}" style="display: none">Verifying...</span>
                                                    {!! $reddemIcon !!}
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                            
                            {{-- endif $isComingSoon --}}
                            @endif
                        @endforeach
                    </div>
                </div>


                <!-- Instant task list End -->
                
                <div class="border border-light p-3 mb-4">

                    <div class="text-center">
                        {{-- Copy to clipboard --}}
                        <input id="cpToClipbord" type="text" style="display: none">
                      <button type="button" id="sendRedeemCode" class="btn btn-success waves-effect waves-light">Done</button>
                    </div>

                </div>

                @endif

                
              <!-- VENDER INFO  -->
              <div class="business_option">
                <div class="d-flex align-items-center">
                  <div class="flex-column me-3">
                    @if($business->logo != '')
                      <img src="{{ asset('assets/business/logos/'.$business->logo) }}" alt="" class="business_logo" />
                    @else
                      <img src="{{ asset('assets/instant_card/imgs/no-preview.jpg') }}" alt="" class="business_logo" />
                    @endif
                  </div>
                  <div class="flex-column">
                    <div class="">
                      <p class="mb-0">{{ $business->business_name }}</p>
                      <p class="mb-0 text-muted smallest fw-light">{{ $business->tag_line }}</p>
                    </div>
                  </div>
                </div>
              </div>

            </div>

          </div>


        </div>
      </div>

    </section>

    <footer>
      <div class="container">
        <div class="pb-3 pt-5">
          <div class="text-center text-white">
            {{-- <p class="smallest mb-2">Powerd By <a href="#" target="_blank" class="logo_footer"><img src="{{ asset('assets/front/images/logo-light.svg') }}" alt="MouthPublicity.io" class="logo_powered"></a> </p> --}}
            <p class="smallest mb-2">Powerd By <span style="color: #fdb500" class="fw-bold">Logic Innovates</span> </p>
          </div>
          <div class="d-flex justify-content-center text-white">
            <a href="/terms-and-conditions" class="mx-2 small-links">Terms & Conditions</a>
            <a href="/privacy-policy" class="mx-2 small-links">Privacy Policy</a>
          </div>
        </div>
      </div>
    </footer>


    {{-- <div class="modal ol-modal popin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" id="user_mobile_modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary">Subscribe Here</h5>
                </div>
                <div class="modal-body">
                    
                    <div>
                        <p>To continue with the offer, Please share your mobile number.</p>
    
                        <form action="#">
                            <div class="form-group">
                                <label for="mobile">Mobile Number <span class="text-danger">*</span> <small class="text-secondary">(10 Digit)</small> </label>
                                <input type="tel" name="mobile" id="mobile" pattern="[6789][0-9]{9}" class="form-control" placeholder="Enter 10 digits mobile number..." required>
                            </div>
                            <div class="form-group">
                                <button id="continueBtn" class="btn btn-primary btn-sm px-3 mt-4" >Continue</button>
                            </div>
                        </form>
                    </div>
    
                </div>
            </div>
        </div>
    </div> --}}


    <div class="modal ol-modal popin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" id="user_data_modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title color-primary font-600">Details</h5>
                </div>
                <div class="modal-body">
                    
                    <div>
                        <p class="text-secondary">Please share your basic details to continue with the offer.</p>

                        <form action="#" class="form-type-one">
                            {{-- Mobile Number --}}
                            <div class="form-group mb-4" id="mobile_input">
                                <label for="mobile" class="mb-2"><span class="font-600">Whatsapp Number</span> <span class="text-danger">*</span> <small class="text-secondary">(10 Digit)</small> </label>
                                <input type="tel" name="mobile" value="" id="mobile" pattern="[6789][0-9]{9}" class="form-control indian-mobile-series no-space-validation" placeholder="Enter whatsapp number..." maxlength="10" minlength="10" required>
                                <span class="text-danger" id="mobile_error" style="display: none">Please enter a valid mobile number</span>
                            </div>
                            {{-- User Name --}}
                            <div class="form-group mb-4" id="name_input" style="display: none">
                                <label for="name" class="mb-2"><span class="font-600">Full Name</span> <span style="font-size: 10px;">(Optional)</span></label>
                                <input name="name" id="name" value="" type="text" class="form-control char-spcs-validation" placeholder="Enter your name...">
                            </div>
                            {{-- Date of Birth --}}
                            <div class="form-group mb-4" id="dob_input" style="display: none">
                                <label class="mb-2"><span class="font-600">Date of Birth</span> <span style="font-size: 10px;">(Optional)</span></label>
                                <input type="text" name="dob" value="" id="dob" placeholder="Select your date of birth..." class="form-control" onclick="openDobModal()" />
                            </div>
                            {{-- Anniversary date --}}
                            <div class="form-group mb-4" id="anniversary_input" style="display: none">
                                <label class="mb-2"><span class="font-600">Anniversary Date</span> <span style="font-size: 10px;">(Optional)</span></label>
                                <input type="text" name="anniversary" value="" id="anniversary" placeholder="Select your anniversary date..." class="form-control" onclick="openAnniversaryModal()" />
                            </div>
                            <div>
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-primary-ol px-4" id="continueBtn">Continue</button>

                                    {{-- <button class="btn btn-primary btn-sm px-3 mt-4" id="finishSetup">Finish</button> --}}
                                    {{-- <button class="btn btn-outline-secondary btn-sm px-3 mt-4" id="skipSetup">Skip Details</button> --}}
                                </div>
                            </div>
                        </form>
                    </div>
    
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal ol-modal popin" aria-hidden="true" id="date-month-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="font-600 color-primary mb-0">Select Month & Date</h6>
                    <a href="#" class="close_calendar" aria-hidden="true">&times;</a>
                </div>
                <div class="modal-body">
                    <div class="custom_calendar form-type-one">
                        <div class="form-group mb-3">
                            <select id="monthNo" class="form-control monthChange">
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>
                        <div>
                            <ul class="days"> 
                                @for($x = 1; $x <= 31; $x++)
                                    <li class="dateSelected" id="{{ $x }}">{{ $x }}</li>
                                @endfor
                            </ul>
                        </div>
                    </div>
                </div>
                {{-- <div class="modal-footer">
                    <button class="btn btn-primary" onclick="removeDate()">Remove Date</button>
                </div> --}}
            </div>
        </div>
    </div>
    <!-- /Modal -->

    {{-- SVG Icons for Ajax --}}
    {{-- 1. --}}
    @php
        $addIcon = '<span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" style="fill: var(--bs-orange);" class="" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/></svg></span>';

        $loaderIcon = '<span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="rotate" viewBox="0 0 16 16"><path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/><path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/></svg></span>';

        $completeTaskIcon = '<span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#189325" viewBox="0 0 16 16">
  <path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01-.622-.636zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708z"/>
</svg></span>';

        
    @endphp

    <div id="loader" style="display: none;">
        <div class="content">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                    <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                    <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                </svg>
            </div>
            <div>
                <h6>Please wait...<br>Redirecting to App or Web.</h6>
            </div>
        </div>
    </div>

  </body>

    <script src="{{ asset('assets/js/jQuery.3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/front/vendor/bootstrap/js/bootstrap.min.js') }}"></script>

    <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>

    <script src="{{ asset('assets/js/input-validation.js') }}"></script>
    
    @include('instant-rewards.instant-noapplink-js')
    @include('instant-rewards.instant-offer-js')
</html>
