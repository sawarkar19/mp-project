@extends('layouts.front')

@section('title', 'Instant Rewards | OpenLink ')
@section('description', ' ')
@section('keywords', '')
{{-- @section('image', '') --}}

@section('end_head')

    <style>

      
    #feature_instant_reward {
       
        overflow: hidden;
    }
    .mouse_scroll {
        width: 100%;
        margin: 0 auto;
        min-height: 100vh;
    }
    .section{
        overflow: hidden;
        min-height: 100vh;
        position: relative;
    }
    .section_child1{
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }
   
    .text_img:after{
        content: '';
        background-image: url({{ asset('assets/front/images/features_landing_pages/star_page1_2.svg') }});
        position: absolute;
        top: -53px;
        right: -67px;
        background-repeat: no-repeat;
        width: 100px;
        height: 100px;
        z-index: -1;
        animation-name: opacitystar;
        animation-duration: 3s;
    }
    @keyframes opacitystar {
      from {opacity: 0;}
      to {opacity: 1;}
    }
    .icon_background i{
        background-color:  var(--color-thm-lth);
        padding: 10px 15px;
        font-size: 30px;
        border-radius: 50%;
        color: #ffffff;
        opacity: 0.1;
        
    }
   
    .fb_icon_position{
        position: absolute;
        top: -19px;
        left: 0;
    }
    .linkedin_icon_position{
        position: absolute;
        top: 60px;
        right: 0;
    }
    .wp_icon_position{
        position: absolute;
        bottom: 130px;
        right: 140px;
    }
    .twitter_icon_position{
        position: absolute;
        bottom: 60px;
        left: 100px;
    }
    .que_background_img{
        background-image: url({{ asset('assets/front/images/features_landing_pages/question_mark.svg') }});
        padding: 132px 0;
        background-size: 100% 100%;
        background-repeat: no-repeat;
    }

    /*.social_media_presence_img{
        margin-top: 110px;
    }*/

    .bg_options{
        padding: 20px 10px;
        background: linear-gradient(64deg,#e9e9e9 0%, #d0d1d32b 80%);
        display: flex;
        align-items: center;
    }
    .background_number i{
        background: #00ffaf;
        background: linear-gradient(64deg,#00ffaf 0%, #00249c 80%);
        background: -webkit-linear-gradient(64deg,#00ffaf 0%, #00249c 80%);
        background: -moz-linear-gradient(64deg,#00ffaf 0%, #00249c 80%);
        padding: 6px 8px;
        font-size: 12px;
        border-radius: 50%;
        color: #ffffff;
        margin-right: 10px;
    }
    .steps_circle{
        border-radius: 50%;
        padding: 7px;
        width: 380px;
        height: 380px;
        position: relative;
        left: 0px;
        top: 0;
        background-image: linear-gradient(64deg,#00ffaf 0%, #00249c 80%);

    }
    .inside_circle{
        width: 366px;
        height: 366px;
        background: #fff;
        border-radius: 50%;
        padding: 15px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .circle_img_right{
        position: relative;
        padding: 19px 0;
        width: 410px;
        height: 410px;
        margin: 64px auto;
    }
    .circle_img_right img{
        position: absolute;
        right: 0;
        top: 0px;
        width: 254px;
        transform: rotate(2deg);
    }
    
    .circle_img_left{
        position: relative;
        padding: 26px 0;
        width: 410px;
        height: 410px;
        margin: 64px auto;
    }
    .circle_img_left img{
        position: absolute;
        left: 0;
        top: 0px;
        width: 254px;
        transform: rotate(2deg);
    }
    .yes_section{
      text-align: center;
      letter-spacing: 5px;
      -webkit-background-clip: text;
      background-clip: text;
      -webkit-text-fill-color: transparent;
      background-repeat: no-repeat;
      background-size: 80%;
      animation: type 5s linear;
      position: relative;
    }

    @keyframes type {
      0% {
        background-position-x: -500%;
      }
      100% {
        background-position-x: 500%;
      }
    }
    .que_background_img{
        animation: 1s 1 forwards cubic-bezier(.36,-0.01,.5,1.38) up;
        animation-delay: 0.6s;
        opacity:0;
    }
     @keyframes up {
      0% {opacity: 0.5;transform: translateY(100px);}
      100% {opacity: 1;transform: translateY(0px);}
    }
    @-webkit-keyframes up {
      0% {opacity: 0.5;transform: translateY(100px);}
      100% {opacity: 1;transform: translateY(0px);}
    }
    .fb_icon_position {
        animation-name: ICON;
        animation-duration: 3s;
        animation-iteration-count: infinite;
    }
    @keyframes ICON {
      0% {transform: translateX(0px);}
      50% {transform: translateX(50px);}
      100% {transform: translateX(0px);}
    }
    @-webkit-keyframes ICON{
       0% {transform: translateX(0px);}
       50% {transform: translateX(50px);}
       100% {transform: translateX(0px);}
    }
    .linkedin_icon_position {
        animation-name: ICONIN;
        animation-duration: 3s;
        animation-iteration-count: infinite;
    }
    @keyframes ICONIN {
      0% {transform: translateY(50px);}
      50% {transform: translateY(0px);}
      100% {transform: translateY(50px);}
    }
    @-webkit-keyframes ICONIN{
       0% {transform: translateY(50px);}
       50% {transform: translateY(0px);}
       100% {transform: translateY(50px);}
    }
    .wp_icon_position {
        animation-name: ICONWP;
        animation-duration: 6s;
        animation-iteration-count: infinite;
    }
    @keyframes ICONWP {
      0% {transform: scale(0.5, 0.5);}
      50% {transform: scale(0.8, 0.8);}
      100% {transform: scale(0.5, 0.5);}
    }
    @-webkit-keyframes ICONWP{
       0% {transform: scale(0.5, 0.5);}
       50% {transform: scale(0.8, 0.8);}
       100% {transform: scale(0.5, 0.5);}
    }
    .twitter_icon_position {
        animation-name: ICONTW;
        animation-duration: 3s;
        animation-iteration-count: infinite;
    }
    @keyframes ICONTW {
      0% {transform: translateY(0px);}
      50% {transform: translateY(50px);}
      100% {transform: translateY(0px);}
    }
    @-webkit-keyframes ICONTW{
       0% {transform: translateY(0px);}
       50% {transform: translateY(50px);}
       100% {transform: translateY(0px);}
    }
    .image_animation{
        animation-name: leftimg;
        animation-duration: 2s;
    }
    @keyframes leftimg {
      0% {transform: translateX(60px);}
      100% {transform: translateX(0px);}
    }
    @-webkit-keyframes leftimg {
        0% {transform: translateX(60px);}
      100% {transform: translateX(0px);}
    }
    .section6_text{
        animation-name: text_right;
        animation-duration: 2s;
    }
    @keyframes text_right {
      0% {transform: translateX(-100px);}
      100% {transform: translateX(0px);}
    }
    @-webkit-keyframes text_right {
        0% {transform: translateX(-100px);}
      100% {transform: translateX(0px);}
    }
    .logo{
       position: relative;
    }
    .logo img{
       position: absolute;
      
    }
    .arrow i{
        font-size: 45px;
        position: absolute;
        left: 50%;
        margin-left: -30px;
        bottom: 0px;
    }

    .arrow i {
         animation: 1s linear arrow;
          animation-iteration-count:infinite;
    }
    .arrow i::before{
        background: #00FFAF;
        background: -webkit-linear-gradient(115deg, #00FFAF 0%, #00249C 80%);
        background: -moz-linear-gradient(115deg, #00FFAF 0%, #00249C 80%);
        background: linear-gradient(115deg, #00FFAF 0%, #00249C 80%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    @keyframes arrow
    {
    0% {transform: translateY(0px);}
    50% {transform: translateY(10px);}
    100% {transform: translateY(0px);}
    }

    @-webkit-keyframes arrow 
    {
    0% {transform: translateY(0px);}
    50% {transform: translateY(10px);}
    100% {transform: translateY(0px);}
    }

    .arrow i.arrow1 {
        animation-delay:1s;
        -webkit-animation-delay:1s; /* Safari 和 Chrome */
    }
    .section7_img img{
        max-width: 300px;
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translate(-50%);
    }
    .section7_text{
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        top: 54px;
    }
    @media(min-width: 576px) and (max-width: 768px){
        .section7_text{
            top: 225px;
        }    
    }
    @media(max-width: 575px){
        .circle_img_right{
            margin: auto;
            width: 280px;
            height: 280px;
            padding: 13px 0;
        }
        .circle_img_right img{
            width: 174px;
        }
        .inside_circle{
            width: 246px;
            height: 246px;
        }
        .inside_circle h5{
            font-size: 18px; 
        }
        .steps_circle{
            padding: 7px;
            width: 260px;
            height: 260px;
        }
        .circle_img_left{
            margin: auto;
            width: 280px;
            height: 280px;
            padding: 19px 0;
        }
        .circle_img_left img{
            width: 174px;
        }
        .wp_icon_position{
            bottom: 90px;
            right: 51px;
        }
        .twitter_icon_position{
            bottom: 10px;
            left: 14px;
        }
        .icon_background i {
            padding: 8px 10px;
            font-size: 14px;
        }
         .section7_text{
            top: 165px;
        }
        .arrow i{
            bottom: -20px;
        }
    }    
    </style>
@endsection

@section('content')


<section id="feature_instant_reward">
    <div class="pt-5">
    <!--   Logo section -->
        <div class="container">
            <div class="mb-4 logo">
                <a href="{{ url('') }}" ><img src="{{ asset('assets/front/images/logo-dark.svg') }}" class="main_logo" alt="OpenLink"></a>
            </div>
        </div>
           
            <!--  section1 -->
        <div class="mouse_scroll">    
            <section id="section1" class="section">
                <div class="section_child1" style="margin-top: 70px;">
                    <div class="position-relative">
                        <div class="container">
                            <div class="pb-5">
                                <div class="mt-5">
                                    <img src="{{ asset('assets/front/images/features_landing_pages/instant_reward_page1_1.svg') }}" style="max-width: 200px;">
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-lg-9 col-md-10 col-sm-12">
                                        <div class="">
                                            <div class="text-center position-relative">
                                                <div class="text_img">
                                                   <h1 class="font-700 color-text-gradient">Make your own customers, as your social media followers now!</h1>  
                                                </div>
                                                <p>Grow your social media presence with your own customers just with a few clicks. Create Instant offers, set instant social media tasks, and let your customer complete the task while their billing to avail of the instant discount.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-between align-items-center">
                                    <div class="col-lg-2">
                                       <img src="{{ asset('assets/front/images/features_landing_pages/magnet_page1_3.svg') }}" style="max-width: 100px;"> 
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="text-end image_animation">
                                            <img src="{{ asset('assets/front/images/features_landing_pages/girl_page1_4.svg') }}" style="max-width: 230px"> 
                                        </div>
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
                <div class="section_child2">
                    <div class="arrow">
                        <i class="bi bi-chevron-down arrow1"></i> 
                    </div>
                </div>
                 
            </section>

            <!--   section2 -->
            <section id="section2" class="section">
                <div class="section_child1">
                   <div class="container">
                    <div class="position-relative">
                        <div class="row justify-content-center my-5">
                           <div class="col-lg-9 col-md-10 col-sm-12">
                                <div class="text-center">
                                    <h1 class="font-700 color-text-gradient">Who are your social media followers?</h1>
                                   <!--  <img src="{{ asset('assets/front/images/features_landing_pages/who_are_social_followers.svg') }}" style="max-width: 400px;  position: relative; z-index: 10;"> -->
                                   <svg xmlns="http://www.w3.org/2000/svg" width="400" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 388.3 306.56">
                                    <defs>
                                    <style>
                                        .heart{
                                            animation: heartD 4s infinite;
                                            -webkit-animation: heartD 4s infinite;
                                        }
                                        @keyframes heartD {
                                          0% {transform: translateY(0px);}
                                          50% {transform: translateY(10px);}
                                          100% {transform: translateY(0px);}
                                        }
                                        @-webkit-keyframes heartD {
                                          0% {transform: translateY(0px);}
                                          50% {transform: translateY(10px);}
                                          100% {transform: translateY(0px);}
                                        }
                                        .woman{
                                            animation-name: womanBody;
                                            animation-duration: 3s;
                                        }
                                         @keyframes womanBody {
                                          0% {transform: translateY(0px);}
                                          50% {transform: translateY(10px);}
                                          100% {transform: translateY(0px);}
                                        }
                                        @-webkit-keyframes womanBody {
                                          0% {transform: translateX(50px);}
                                          100% {transform: translateX(0px);}
                                        }
                                    .cls-1{fill:#f5f5f5;}
                                    .cls-2{fill:#407bff;}.
                                    cls-3{fill:#263238;}.cls-4{fill:url(#linear-gradient);}.cls-5{fill:url(#linear-gradient-2);}.cls-10,.cls-20,.cls-22,.cls-30,.cls-6,.cls-7{fill:#fff;}.cls-10,.cls-20,.cls-22,.cls-23,.cls-25,.cls-28,.cls-30,.cls-6,.cls-7,.cls-9{isolation:isolate;}.cls-6{opacity:0.6;}.cls-28,.cls-7{opacity:0.4;}.cls-8{fill:#eec1bb;}.cls-30,.cls-9{opacity:0.2;}.cls-10{opacity:0.3;}.cls-11{fill:#b97964;}.cls-12{fill:url(#linear-gradient-3);}.cls-13{fill:url(#linear-gradient-4);}.cls-14{fill:url(#linear-gradient-5);}.cls-15,.cls-23{fill:#8290d1;}.cls-16{fill:url(#linear-gradient-6);}.cls-17{fill:#3a3a3a;}.cls-18{fill:#a24e3f;}.cls-19{fill:url(#linear-gradient-7);}.cls-20{opacity:0.5;}.cls-21{fill:url(#linear-gradient-8);}.cls-22{opacity:0;}.cls-23{opacity:0.8;}.cls-24{fill:#011da2;}.cls-25{opacity:0.1;}.cls-26{fill:url(#linear-gradient-9);}.cls-27{fill:#e4897b;}.cls-29{fill:#de5753;}.cls-31{fill:url(#linear-gradient-10);}.cls-32{fill:url(#linear-gradient-11);}</style><linearGradient id="linear-gradient" x1="32.3" y1="277.88" x2="113.49" y2="270.99" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#00ffaf"/><stop offset="0.06" stop-color="#00edad"/><stop offset="0.32" stop-color="#00a6a7"/><stop offset="0.55" stop-color="#006ea2"/><stop offset="0.75" stop-color="#00469f"/><stop offset="0.91" stop-color="#002d9d"/><stop offset="1" stop-color="#00249c"/></linearGradient><linearGradient id="linear-gradient-2" x1="118.86" y1="276.47" x2="75.96" y2="273.4" xlink:href="#linear-gradient"/><linearGradient id="linear-gradient-3" x1="319" y1="70.7" x2="350.48" y2="70.7" xlink:href="#linear-gradient"/><linearGradient id="linear-gradient-4" x1="297.85" y1="37.29" x2="302.45" y2="101.63" xlink:href="#linear-gradient"/><linearGradient id="linear-gradient-5" x1="271.12" y1="273.84" x2="287.22" y2="273.84" xlink:href="#linear-gradient"/><linearGradient id="linear-gradient-6" x1="297.35" y1="282.33" x2="321.01" y2="282.33" xlink:href="#linear-gradient"/><linearGradient id="linear-gradient-7" x1="289.98" y1="17.54" x2="313.98" y2="17.54" xlink:href="#linear-gradient"/><linearGradient id="linear-gradient-8" x1="271.39" y1="76.99" x2="306.44" y2="76.99" xlink:href="#linear-gradient"/><linearGradient id="linear-gradient-9" x1="232.32" y1="143.2" x2="226.96" y2="241.24" xlink:href="#linear-gradient"/><linearGradient id="linear-gradient-10" x1="137.2" y1="183.12" x2="155.14" y2="183.12" xlink:href="#linear-gradient"/><linearGradient id="linear-gradient-11" x1="158.4" y1="159.14" x2="170.38" y2="159.14" xlink:href="#linear-gradient"/></defs><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><g id="Shadow"><ellipse id="path" class="cls-1" cx="194.15" cy="285.82" rx="194.15" ry="11.34"/></g><path class="cls-2" d="M66.92,238l-7.89-2c-2-.49-4.14.35-4.64,2.33l-1.29,5.21c-.51,2,1,3.64,3,4.13l3.11.77v3.55l1.68-3.13,3.1.77c2,.49,4.13-.24,4.62-2.22l1.3-5.22C70.43,240.19,68.91,238.45,66.92,238Z"/><path class="cls-2" d="M75.77,219c-4.08-1.73-6.45,3.3-6.45,3.3s-4.94-2.56-7.12,1.3c-3.11,5.5,5.8,10.44,11,10.27C77.51,230.82,81.57,221.48,75.77,219Z"/><polygon class="cls-2" points="89.36 248.48 85.37 242.97 78.89 245.08 83.68 230.38 94.15 233.78 89.36 248.48"/><rect class="cls-3" x="40.7" y="256.7" width="63.06" height="35.58"/><rect class="cls-4" x="40.7" y="256.7" width="63.06" height="35.58"/><rect class="cls-5" x="78.65" y="256.7" width="25.11" height="35.58"/><path class="cls-6" d="M66.92,238l-7.89-2c-2-.49-4.14.35-4.64,2.33l-1.29,5.21c-.51,2,1,3.64,3,4.13l3.11.77v3.55l1.68-3.13,3.1.77c2,.49,4.13-.24,4.62-2.22l1.3-5.22C70.43,240.19,68.91,238.45,66.92,238Z"/><polygon class="cls-7" points="89.36 248.48 85.37 242.97 78.89 245.08 83.68 230.38 94.15 233.78 89.36 248.48"/><polygon class="cls-8" points="226.47 270.18 217.35 271.13 216.89 265.84 215.63 251.46 224.76 250.49 226.14 266.38 226.47 270.18"/><polygon class="cls-9" points="224.76 250.49 226.14 266.38 216.89 265.84 215.63 251.46 224.76 250.49"/><path class="cls-2" d="M216.38,268.2h10.74a.77.77,0,0,1,.75.6l1.74,7.89arrow1.3,1.3,0,0,1-1,1.54h-.29c-3.47-.06-6-.27-10.36-.27-2.7,0-10.81.28-14.51.28s-4.2-3.67-2.68-4c6.81-1.48,11.94-3.54,14.12-5.5A2.23,2.23,0,0,1,216.38,268.2Z"/><polygon class="cls-2" points="213.35 260.86 213.98 264.52 229.3 264.52 229.3 261.14 213.35 260.86"/><path class="cls-10" d="M216.38,268.2h10.74a.77.77,0,0,1,.75.6l1.74,7.89a1.3,1.3,0,0,1-1,1.54h-.29c-3.47-.06-6-.27-10.36-.27-2.7,0-10.81.28-14.51.28s-4.2-3.67-2.68-4c6.81-1.48,11.94-3.54,14.12-5.5A2.23,2.23,0,0,1,216.38,268.2Z"/>
                                    <g class="woman">
                                        <path class="cls-11" d="M339.11,193.57c-4.9,12.11-18,30-30.09,45.24l-3.08,3.9c-3.48,4.31-6.79,8.33-9.86,11.84-1.53,1.77-3,3.41-4.4,4.89h0a92.48,92.48,0,0,0-7.35,8.71l-4.84-2.84s4.64-7.24,10.85-17.22l4.11-6.63c3.65-5.86,7.58-12.24,11.37-18.45l2.12-3.52c7-11.63,13.26-22.15,15.5-26.8.17-.35.32-.68.44-1,1.24-2.85-2.11-13.82-5.83-24.15l-.84-2.33c-3.52-9.61-7.08-18.08-7.08-18.08L320,130.4l3.62-6.15s1.95,5.4,4.56,13.17c1.77,5.26,3.85,11.62,5.82,18.13.2.66.4,1.33.61,2,3,9.89,5.48,19.87,6.41,26.64C341.37,186.61,340.63,189.81,339.11,193.57Z"/><path class="cls-9" d="M309.3,238.81c-6.39,8-12.53,15.32-17.09,20.63-.65-3.26-1.31-7.13-1.83-11.34,5.27-8.48,11.73-18.93,17.6-28.61A110.56,110.56,0,0,0,309.3,238.81Z"/><path class="cls-11" d="M306.13,279.85l-5.76.75s-2.21-10.89-4.32-26c-.57-4.09-1.12-8.5-1.63-13.08a308.79,308.79,0,0,1-2.06-35s-.63-2.18-1.56-5.88c-1.56-6.16-3.94-16.49-5.61-27.9v-.2c-2-13.68-3-28.88-.31-40.25l20,9,.34,24.18.08,5.86.28,20.37.06,4.67.16,26.78.12,19.69Z"/><path class="cls-9" d="M304.87,141.16l.34,24.18c-6.11,4.1-14.53,6.12-20,7.06-2-13.68-3-28.88-.31-40.25Z"/><path class="cls-9" d="M334.63,157.58c-5.15,5.74-13.61,7.27-17.42,7.67-3.52-9.61-7.08-18.08-7.08-18.08L320,130.44c2.7,2.12,5.56,4.51,8.18,7,1.77,5.26,3.85,11.62,5.82,18.13C334.22,156.25,334.42,156.92,334.63,157.58Z"/><path class="cls-12" d="M319,49.78c3.8.17,19.71,21.54,19.71,21.54l5.91-7.68s9.11,17.69,4.6,26.12S321,75.15,321,75.15Z"/><path class="cls-9" d="M338.71,71.32l-.85,1.62,2.48,9.64s-6.84-6.21-2.48-12.3Z"/><path class="cls-13" d="M319.68,103.2l-32,2.49s-.43-19.15-3-29.11c-.83-3.23-1.87-6.85-3.2-11-.56-1.78-1.17-3.66-1.84-5.68s-1.28-3.86-2-6A96.16,96.16,0,0,1,291,50.69a103.63,103.63,0,0,1,14.5-1.53c6.27,0,13.49.66,13.49.66s1,.25,1.68,6.9C321.27,62.94,321,80.46,319.68,103.2Z"/><path class="cls-14" d="M279.9,262.14c.58-.42,5.57,7,5.57,7s-1.1,7.78,1.14,12.81-2.12,4.59-5.76-.17l-9-11.76C269.3,266.69,273.79,266.61,279.9,262.14Z"/><path class="cls-15" d="M287.17,274.84c-1.13-.27-1.86-3.49-2-4.14a.14.14,0,0,1,0-.09h0v-.07h0a.06.06,0,0,1,0-.06h.08c.1,0,2.21-.71,3.34,0a1.32,1.32,0,0,1,.68.94.82.82,0,0,1-.24.92,3.12,3.12,0,0,1-1.9-.3,3.57,3.57,0,0,1,1,1.73,1,1,0,0,1-.81,1.16h-.11Zm.11-.46c.05,0,.19,0,.41-.24a.48.48,0,0,0,.09-.4c-.09-.74-1.21-1.82-2-2.48C286.14,272.65,286.75,274.25,287.28,274.38Zm-1.3-3.63c1.2.74,2.53,1.34,2.87,1.11.1-.07.07-.3,0-.43a.86.86,0,0,0-.45-.63,2.11,2.11,0,0,0-1.08-.23A6.09,6.09,0,0,0,286,270.75Z"/><path class="cls-16" d="M298.34,276.92c0-.73,9-.16,9-.16s5.52,5.61,10.87,6.87,2.37,4.48-3.62,4.48H299.75C295.49,288.11,298.16,284.48,298.34,276.92Z"/><path class="cls-15" d="M308.31,277.93l-.07-.06h0v-.06h0a.11.11,0,0,1,0-.08h0a.14.14,0,0,1,0-.09c0-.11.79-2.19,2-2.7a1.46,1.46,0,0,1,1.16,0c.41.2.6.45.59.76,0,.47-.67.94-1.4,1.33a3.83,3.83,0,0,1,2,.22,1.05,1.05,0,0,1,.48.61.88.88,0,0,1-.22,1,1.34,1.34,0,0,1-.8.21A11.56,11.56,0,0,1,308.31,277.93Zm.82-.15c1.32.56,3,1.05,3.39.7,0,0,.15-.12.06-.47a.48.48,0,0,0-.26-.31,2,2,0,0,0-1.06-.2,9.57,9.57,0,0,0-2.13.28Zm1.24-2.4a4,4,0,0,0-1.53,1.92c1.32-.5,2.6-1.2,2.63-1.6,0-.12-.2-.24-.32-.3a1.18,1.18,0,0,0-.42-.1A.94.94,0,0,0,310.37,275.38Z"/><path class="cls-11" d="M302.84,56.26c-8-1-10.35-4.43-10.35-4.43,3.25-3.06,2.66-7.59,1.83-10.41a15.7,15.7,0,0,0-1-2.6l9.58,1.79a28.19,28.19,0,0,0-.37,4,12.69,12.69,0,0,0,.27,3c.65,2.86,2.29,2.9,2.29,2.9C306.79,53.66,302.84,56.26,302.84,56.26Z"/><path class="cls-9" d="M302.55,44.64a12.69,12.69,0,0,0,.27,3c-3.8-.5-6.69-3.55-8.5-6.19a15.7,15.7,0,0,0-1-2.6l9.58,1.79A28.16,28.16,0,0,0,302.55,44.64Z"/><path class="cls-17" d="M314.26,22.46s4-1.1,3.1-3.87-2.28-2.88-2.28-2.88a7.89,7.89,0,0,0,.79-7.12c-1.58-3.77-5.94-2.68-5.94-2.68s.35-4.06-3.48-5.15a5.2,5.2,0,0,0-5.82,2.41S298.28-.53,294.3.06,289,6,289,6a4.38,4.38,0,0,0-5.64,2.11,6.67,6.67,0,0,0,0,6.92s-2.38-1.4-3.57,2.51,2.67,7.83,2.67,7.83-2.27.07-1.38,3.12S285.67,32,285.67,32s-1.49.59,1,3.26,11.47,0,11.47,0Z"/><path class="cls-11" d="M304.22,15.15c8.25,1.2,10.27,6,9.65,14.58-.78,10.75-4.23,18-14.22,14.19C286.08,38.85,290.52,13.17,304.22,15.15Z"/><path class="cls-18" d="M308.6,28.5a17.85,17.85,0,0,0,1.9,3.78,2.29,2.29,0,0,1-2.3.62Z"/><path class="cls-3" d="M303.64,27.1c-.08.68-.51,1.19-1,1.13s-.75-.65-.67-1.33.52-1.18,1-1.13S303.72,26.42,303.64,27.1Z"/><path class="cls-3" d="M302.78,25.83l1.54-.4S303.44,26.53,302.78,25.83Z"/><path class="cls-3" d="M312.11,28c-.08.68-.51,1.18-1,1.13s-.76-.65-.68-1.33.52-1.19,1-1.13S312.2,27.3,312.11,28Z"/><path class="cls-3" d="M311.25,26.66l1.56-.4S311.94,27.41,311.25,26.66Z"/><path class="cls-3" d="M300.63,22.47a.36.36,0,0,1-.26-.11.34.34,0,0,1,0-.48l0,0a4.66,4.66,0,0,1,4.09-.81.36.36,0,0,1,.25.44.35.35,0,0,1-.44.24,4,4,0,0,0-3.42.65A.31.31,0,0,1,300.63,22.47Z"/><path class="cls-3" d="M313.63,23.42a.46.46,0,0,1-.24-.09,3.55,3.55,0,0,0-2.89-1.08.36.36,0,0,1-.41-.28.33.33,0,0,1,.26-.4h0a4.24,4.24,0,0,1,3.51,1.23.38.38,0,0,1,0,.51A.37.37,0,0,1,313.63,23.42Z"/><path class="cls-3" d="M293.19,27.76s4.84-6.23,5-11.54c0,0,17.31-4.33,15.72,12.39,0,0,3.73-14.51-10.42-16.89s-17.07,18.39-10.64,25.63C292.92,37.35,290.2,31.66,293.19,27.76Z"/><path class="cls-11" d="M294.29,29.69a3.65,3.65,0,0,0-3.37-3.86c-2.6-.09-4.58,5,1.6,7.17C293.36,33.3,294,32.49,294.29,29.69Z"/>
                                    <path class="cls-3" d="M306.26,37.56a4.72,4.72,0,0,1-4.72-3.26.35.35,0,0,1,.23-.44h0a.36.36,0,0,1,.44.24c.9,3,4.16,2.75,4.2,2.75a.37.37,0,0,1,.34.38.36.36,0,0,1-.28.33Z"/><path class="cls-19" d="M290.43,24.45c2.91-10.12,18.92-17.36,23.55-4.87a15.58,15.58,0,0,0-4.63-8s-15-5.83-19.37,11.51Z"/><path class="cls-3" d="M324.8,63.88a.81.81,0,0,0,.69.91h9.28a1.06,1.06,0,0,0,1-.92l2-18a.9.9,0,0,0-.81-1H327.8a1.21,1.21,0,0,0-1,1Z"/><path class="cls-20" d="M327.86,45.71,325.78,64a.69.69,0,0,0,.5.84.55.55,0,0,0,.22,0h7.76c.52,0,1.48-.29,1.54-.8l2.07-18.3c.06-.52-.83-.93-1.35-.93h-7.76A.94.94,0,0,0,327.86,45.71Z"/><path class="cls-6" d="M307.05,107.31a1.62,1.62,0,1,0,1.62-1.62h0A1.61,1.61,0,0,0,307.05,107.31Z"/><path class="cls-11" d="M344,65.39l-4.77-8.09s0-4.26-.4-5.26-5.1-3.26-6-2.92-1.25,8.68-.42,9.81,3.76,2.38,3.76,2.38L336,62.88l2.78,8.43Z"/><polygon class="cls-2" points="345.89 64.48 344.3 62.89 336.79 71.32 337.86 74.65 345.89 64.48"/><path class="cls-11" d="M299.29,73.31l10.84-8.5a39,39,0,0,1,2.3-5.36c.67-.79,10.17-4.3,11-4.39s0,7.79-1.19,9.13-8.85,4-8.85,4L302,78.9Z"/><path class="cls-21" d="M277,53.87c-6.36,3.18-9.2,39.15,1.86,45.36s27.58-21.85,27.58-21.85L300,70.57s-13.47,11.33-15.1,10.25.23-12,.23-12,1.89-3.34-2.09-8.58S277,53.87,277,53.87Z"/><polygon class="cls-2" points="307.17 79.9 309.09 78.74 301.88 68.17 299.24 69.65 307.17 79.9"/><path class="cls-3" d="M336.52,153.2v.16c-1.75.28-3.22,3.44-4.87,4.54a16.8,16.8,0,0,1-6.78,2.46c-4.51.69-9.16.19-13.66,1-5.58,1-10.61,3.89-16,5.67-3.82,1.25-10.1,2.57-13.75.06-2.62-1.81-2.21-5-2.28-7.88a161.85,161.85,0,0,1,1.32-27,106.44,106.44,0,0,1,6.33-24.63c.25-.62.51-1.23.77-1.84l32-2.48.27,1.54,2,11.51,3.82,9.67,9.45,23.88A26.16,26.16,0,0,1,336.52,153.2Z"/><path class="cls-22" d="M336.52,153.2v.16c-1.75.28-3.22,3.44-4.87,4.54a16.8,16.8,0,0,1-6.78,2.46c-4.51.69-9.16.19-13.66,1-5.58,1-10.61,3.89-16,5.67-3.82,1.25-10.1,2.57-13.75.06-2.62-1.81-2.21-5-2.28-7.88a161.85,161.85,0,0,1,1.32-27,106.44,106.44,0,0,1,6.33-24.63c.25-.62.51-1.23.77-1.84l32-2.48.27,1.54,2,11.51,3.82,9.67,9.45,23.88A26.16,26.16,0,0,1,336.52,153.2Z"/><polygon class="cls-2" points="297.29 104.89 296.88 109.3 295.65 109.3 295.85 104.89 297.29 104.89"/><polygon class="cls-6" points="297.29 104.89 296.88 109.3 295.65 109.3 295.85 104.89 297.29 104.89"/><polygon class="cls-2" points="315.26 103.55 315.75 108.16 316.89 108.16 316.5 103.36 315.26 103.55"/><polygon class="cls-6" points="315.26 103.55 315.75 108.16 316.89 108.16 316.5 103.36 315.26 103.55"/><path class="cls-23" d="M305.66,104.44l.39,3.75a.77.77,0,0,0,.82.68l5-.4a.77.77,0,0,0,.71-.82h0l-.37-3.7a.75.75,0,0,0-.81-.69l-5,.35a.75.75,0,0,0-.75.76A.19.19,0,0,0,305.66,104.44Z"/><path class="cls-11" d="M316.63,49.58a6,6,0,0,1-1.32,3.59,8.86,8.86,0,0,1-2.13,1.92c-2.06,1.36-5.28,2.55-10.26,3.21a31.06,31.06,0,0,1-8.23.07,22.2,22.2,0,0,1-3.53-.77,17.33,17.33,0,0,1-8.25-5.24q2.64-.66,5.33-1.19l1.38-.27,1.41-.25a103.63,103.63,0,0,1,14.5-1.53c1.75,0,3.56,0,5.28.1.75,0,1.49.07,2.2.12C314.38,49.41,315.63,49.5,316.63,49.58Z"/><path class="cls-3" d="M294.69,58.37a22.2,22.2,0,0,1-3.53-.77,11.76,11.76,0,0,0-2.94-6.43l1.38-.27C292.35,52.86,293.92,56.36,294.69,58.37Z"/><path class="cls-3" d="M315.31,53.17a8.86,8.86,0,0,1-2.13,1.92,9.14,9.14,0,0,0-2.39-5.87c.75,0,1.49.07,2.2.12A12.21,12.21,0,0,1,315.31,53.17Z"/>
                                    <g class="heart">
                                       <path class="cls-2" d="M327.7,30h-5.81a1.58,1.58,0,0,0-1.58,1.59V36.1a1.57,1.57,0,0,0,1.58,1.58H324l.77,1.88.77-1.88h2.14a1.58,1.58,0,0,0,1.58-1.58V31.57A1.59,1.59,0,0,0,327.7,30Z"/>
                                        <path class="cls-6" d="M322.61,32.27c.57-.91,1.64-.54,2.19.17.56-.7,1.64-1,2.2-.12.94,1.56-1.05,3-2,3.51l-.26.16-.27-.17C323.58,35.25,321.64,33.84,322.61,32.27Z"/> 
                                    </g> 
                                    </g>
                                    <path class="cls-24" d="M205.33,215.62c-6.65,14.27-15.41,15.79-15.41,15.79l-10.47-12.26s7.51-4.53,9.26-10-1.5-41.31,7.83-48.81c0,0,1.07,2.84,2.52,7.29h0c2.85,8.69,7.15,23.49,7.83,35.23C207.2,207.92,206.86,212.46,205.33,215.62Z"/><path class="cls-25" d="M206.86,202.84c-9.15-16.33-10.1-28.12-7.83-35.23C201.91,176.3,206.21,191.1,206.86,202.84Z"/><path class="cls-3" d="M206.45,238.92S139.36,220.2,131,243.73s52.46,42.3,86.12,43.45,47.44-22.48,37.51-44.94Z"/><path class="cls-9" d="M206.45,238.92S139.36,220.2,131,243.73s52.46,42.3,86.12,43.45,47.44-22.48,37.51-44.94Z"/><path class="cls-26" d="M260.93,255.83l-62.32-10.67c10.92-21,7.45-53-2-84.85,6.6-5.52,33-9.24,53.07-3.39,0,0,1.19,4.42,2.8,12,1.94,9.11,4.47,22.79,6.27,38.93A341.7,341.7,0,0,1,260.93,255.83Z"/><path class="cls-25" d="M258.72,207.89a33.14,33.14,0,0,1-11-15.53c-5.07-16.07,2.82-22.19,4.73-23.4C254.39,178.07,256.93,191.75,258.72,207.89Z"/><path class="cls-15" d="M138.66,275.63a3,3,0,0,1-1.06-1.52A1.16,1.16,0,0,1,138,273a.69.69,0,0,1,.67-.19c1.13.34,2.25,3.58,2.36,4a.16.16,0,0,1-.06.2.23.23,0,0,1-.25,0A12.88,12.88,0,0,1,138.66,275.63Zm.18-2.23a.61.61,0,0,0-.26-.15.24.24,0,0,0-.26.08.74.74,0,0,0-.29.74,4.88,4.88,0,0,0,2.4,2.32,9.17,9.17,0,0,0-1.59-3Z"/><path class="cls-15" d="M140.67,277v-.1c-.4-1-.49-3.63.32-4.2a.75.75,0,0,1,.91.08,1.28,1.28,0,0,1,.53.81c.26,1.33-1.31,3.3-1.41,3.39a.2.2,0,0,1-.21.06A.23.23,0,0,1,140.67,277Zm1-3.81-.07-.07c-.26-.16-.35-.09-.4-.06-.48.33-.56,2.17-.31,3.3.42-.61,1.21-1.87,1-2.7a.86.86,0,0,0-.27-.47Z"/><path class="cls-15" d="M209.55,291.36a3,3,0,0,1-.35,1.81,1.17,1.17,0,0,1-1.06.48.71.71,0,0,1-.61-.35c-.55-1,1-4.11,1.17-4.45a.2.2,0,0,1,.2-.1.21.21,0,0,1,.18.17A11.83,11.83,0,0,1,209.55,291.36Zm-1.69,1.42a1.09,1.09,0,0,0,.07.3.24.24,0,0,0,.24.13.78.78,0,0,0,.74-.31,4.8,4.8,0,0,0,0-3.34A9.38,9.38,0,0,0,207.86,292.78Z"/><polygon class="cls-27" points="192.83 266.26 204.7 274.96 210.4 279.14 206.67 285.64 200.89 282.47 186.77 274.74 192.83 266.26"/><path class="cls-3" d="M204.86,285.45l3.57-7.9a.88.88,0,0,1,1.16-.43h0l3.86,1.89s5.37,2.17,6,3.91c2,5.11-5.5,22.79-7.83,22.79-.85,0-1.36-1.32-1.48-2.16-.38-2.68-.44-9.41-.78-11.64-.4-2.61-3-4.61-4.26-5.41A.86.86,0,0,1,204.86,285.45Z"/><path class="cls-15" d="M209.12,289l-.05.09c-.44,1-2.25,2.9-3.23,2.72a.73.73,0,0,1-.56-.71,1.24,1.24,0,0,1,.2-.95c.77-1.11,3.25-1.38,3.4-1.36a.2.2,0,0,1,.19.1A.37.37,0,0,1,209.12,289Zm-3.42,1.95v.1c0,.3.17.32.23.33.57.11,1.94-1.13,2.56-2.09-.73.12-2.17.44-2.65,1.14a.83.83,0,0,0-.15.52Z"/><polygon class="cls-9" points="192.83 266.26 204.7 274.96 200.89 282.47 186.77 274.74 192.83 266.26"/><polygon class="cls-2" points="198.18 282.96 194.29 282.09 200.76 269.72 204.38 273.41 198.18 282.96"/><polygon class="cls-15" points="198.18 282.96 194.29 282.09 200.76 269.72 204.38 273.41 198.18 282.96"/><polygon class="cls-27" points="168.28 281.25 153.76 283.63 146.78 284.79 144.75 277.59 151.06 275.66 166.46 270.98 168.28 281.25"/>
                                    <path class="cls-3" d="M146.17,276.41l3.15,8.08a.87.87,0,0,1-.5,1.11h0l-4,1.43s-5.32,2.32-7,1.58c-5-2.16-12.43-19.87-10.79-21.54.59-.61,1.89-.05,2.58.46,2.17,1.61,7,6.27,8.86,7.58,2.14,1.55,5.42,1.06,6.84.75A.84.84,0,0,1,146.17,276.41Z"/>
                                    <polygon class="cls-9" points="168.28 281.25 153.76 283.63 151.06 275.66 166.46 270.98 168.28 281.25"/>
                                    <path class="cls-3" d="M153.56,274.16s60.36-35.61,80.78-34.65,22.22,21.27,13.79,32.55-24,14-24,14,10.59-15,9.07-19.19-7.38,10-7.38,10-37.39,4.9-70,7.66Z"/>
                                    <polygon class="cls-2" points="152.6 273.24 155.95 271 160.26 284.22 155.08 284.22 152.6 273.24"/>
                                    <polygon class="cls-15" points="152.6 273.24 155.95 271 160.26 284.22 155.08 284.22 152.6 273.24"/>
                                    <path class="cls-27" d="M221.77,165.48c8.78,0,14.5-9.22,14.5-9.22-11.51-4-11.55-16.19-11.55-16.19l-4.44,4.3L214,150.56c5.26,3.72,2.78,6.95,1.1,8.38a8.06,8.06,0,0,1-1.1.82S213,165.48,221.77,165.48Z"/>
                                    <path class="cls-9" d="M215.06,159c10.78,1.21,10-14.92,10-14.92a27,27,0,0,0-4.83.35l-6.32,6.19C219.22,154.32,216.74,157.55,215.06,159Z"/>
                                    <path class="cls-2" d="M237.38,136.41c1.3,1.27-4.08,4.74-12.67,1.79s-10.07-11.65-10.07-11.65S228.89,128.12,237.38,136.41Z"/>
                                    <path class="cls-28" d="M237.38,136.41c1.3,1.27-4.08,4.74-12.67,1.79s-10.07-11.65-10.07-11.65S228.89,128.12,237.38,136.41Z"/>
                                    <path class="cls-3" d="M206.64,128c4.09,1.69,3.31,6.13-3.46,14.26-4.17-3.6-6.43-11.77-4.25-14.38S203.09,126.51,206.64,128Z"/>
                                    <path class="cls-27" d="M200.62,146h0a27.59,27.59,0,0,0,1.31,3.18c4,8.21,15.6,9.8,20.72,1.69l.06-.08c3.39-5.46,2.12-10.56.7-19.39a12.21,12.21,0,0,0-19-8.19C197.64,127.94,198,138.49,200.62,146Z"/>
                                    <path class="cls-3" d="M211,136.77c.16.71-.09,1.37-.55,1.47s-1-.38-1.12-1.09.08-1.36.54-1.47S210.75,136.09,211,136.77Z"/><path class="cls-3" d="M202.86,138.59c.15.71-.1,1.37-.56,1.47s-1-.38-1.14-1.1.09-1.36.57-1.47S202.74,137.88,202.86,138.59Z"/>
                                    <path class="cls-29" d="M205.6,138.36a25.78,25.78,0,0,1-2,6.83c1.54.88,3.53-.13,3.53-.13Z"/>
                                    <path class="cls-3" d="M212.58,133.73a.39.39,0,0,0,.37-.42.43.43,0,0,0-.16-.3,4.23,4.23,0,0,0-3.77-1,.43.43,0,0,0-.31.5h0a.45.45,0,0,0,.54.29h0a3.38,3.38,0,0,1,3,.79A.39.39,0,0,0,212.58,133.73Z"/>
                                    <path class="cls-3" d="M198.61,136.7a.45.45,0,0,0,.33-.32,3.4,3.4,0,0,1,1.92-2.42.42.42,0,0,0,.26-.55.43.43,0,0,0-.55-.26,4.28,4.28,0,0,0-2.46,3,.44.44,0,0,0,.31.51h0A.42.42,0,0,0,198.61,136.7Z"/>
                                    <path class="cls-3" d="M218.22,124.52c-3.76,2.32-2.28,6.59,5.7,13.52,3.54-4.21,4.47-12.65,1.89-14.87S221.5,122.52,218.22,124.52Z"/>
                                    <path class="cls-27" d="M229.13,137.5a8.5,8.5,0,0,1-2.83,5.85c-2.24,2-4.65.26-5.1-2.53-.4-2.51.29-6.55,3.06-7.44S229.28,134.75,229.13,137.5Z"/>
                                    <path class="cls-3" d="M208.77,149.38a.32.32,0,0,1-.28-.24.3.3,0,0,1,.23-.33,6.14,6.14,0,0,0,5-3.71.28.28,0,0,1,.35-.19h0a.27.27,0,0,1,.2.33h0c0,.14-1,3.36-5.4,4.12Z"/>
                                    <path class="cls-3" d="M214.87,126.34a8.24,8.24,0,0,0-3.51,2.45,2.06,2.06,0,0,1,0-1.78,12.71,12.71,0,0,0-3.76,3,6.39,6.39,0,0,1-.61-2.85,16.82,16.82,0,0,0-1.67,3.66s-3-1.09-3.28-3.47a12.13,12.13,0,0,0,0,3.07,3.7,3.7,0,0,1-2.43-2.67,10,10,0,0,0-.53,3.73s-2.23-1.06-1.58-4.13,9.33-7.81,14.37-6.33S214.87,126.34,214.87,126.34Z"/>
                                    <path class="cls-15" d="M197.24,128.66s.09-8.89,3.69-12.23,16.48-4.41,22.85-1.09,4.11,15.33,4.11,15.33S214.79,124,197.24,128.66Z"/>
                                    <path class="cls-3" d="M201.71,125.8a20.24,20.24,0,0,1,8-.66s2.25-4-3.38-4.19C202.29,120.78,201.48,122.94,201.71,125.8Z"/>
                                    <path class="cls-2" d="M221,128.35l7.1.05a35.44,35.44,0,0,1,9.25,8S231.9,131.65,221,128.35Z"/><path class="cls-9" d="M221,128.35l7.1.05a35.44,35.44,0,0,1,9.25,8S231.9,131.65,221,128.35Z"/>
                                    <path class="cls-9" d="M245.64,226.64l-20.76,23s-22.95-.51-50.83,13.11c0,0-29.91-12.36-32.67-22.62s62.8-3,62.8-3Z"/>
                                    <path class="cls-27" d="M239.78,219.88l-33.3,10.89s-11.89-2.63-14-2.63-10.34,6.68-5.69,9,17.33,2.64,18.71,1.89,38.3-9.4,38.3-9.4Z"/>
                                    <path class="cls-24" d="M249.65,156.92c-7.54-1.47,5.54,44.43,2.33,51.19s-15.71,11-15.71,11L242,231.84s17-3.22,26.28-15S261.94,159.31,249.65,156.92Z"/>
                                    <polygon class="cls-2" points="236.27 218.13 243.28 231.86 237.27 233.15 231.77 220.51 236.27 218.13"/>
                                    <polygon class="cls-30" points="236.27 218.13 243.28 231.86 237.27 233.15 231.77 220.51 236.27 218.13"/>
                                    <path class="cls-3" d="M222.5,237.15v2.19a2.84,2.84,0,0,1-2.71,2.82h-80.5a3,3,0,0,1-2.9-2.82v-2.19Z"/>
                                    
                                    <g class="heart" >
                                        <path class="cls-31" d="M152,173.55H140.36a3.16,3.16,0,0,0-3.16,3.17v9.06a3.18,3.18,0,0,0,3.16,3.18h4.27l1.54,3.73L147.7,189H152a3.17,3.17,0,0,0,3.17-3.18h0v-9.06A3.17,3.17,0,0,0,152,173.55Z"/>
                                        <path class="cls-6" d="M141.78,178.11c1.15-1.81,3.29-1.08,4.39.35,1.13-1.41,3.3-2.08,4.4-.24,1.86,3.12-2.1,5.93-4,7l-.53.31-.52-.32C143.78,184.09,139.85,181.18,141.78,178.11Z"/>
                                    </g>
                                    <path class="cls-30" d="M222.5,237.15v2.19a2.84,2.84,0,0,1-2.71,2.82h-80.5a3,3,0,0,1-2.9-2.82v-2.19Z"/>
                                    <path class="cls-30" d="M192.46,237.15v2.19a2.85,2.85,0,0,1-2.72,2.82H139.29a3,3,0,0,1-2.9-2.82v-2.19Z"/>
                                    <path class="cls-3" d="M189.74,240.16H136.56a4.35,4.35,0,0,1-3.87-2.86L120.5,199.05a2.11,2.11,0,0,1,1.12-2.78,2.06,2.06,0,0,1,.88-.17h53.22a4.46,4.46,0,0,1,3.87,3l12.19,38.2A2.08,2.08,0,0,1,190.7,240,2.12,2.12,0,0,1,189.74,240.16Z"/>
                                    <path class="cls-30" d="M189.74,240.16H136.56a4.35,4.35,0,0,1-3.87-2.86L120.5,199.05a2.11,2.11,0,0,1,1.12-2.78,2.06,2.06,0,0,1,.88-.17h53.22a4.46,4.46,0,0,1,3.87,3l12.19,38.2A2.08,2.08,0,0,1,190.7,240,2.12,2.12,0,0,1,189.74,240.16Z"/>
                                    <path class="cls-30" d="M187.74,240.16H136.56a4.35,4.35,0,0,1-3.87-2.86L120.5,199.05a2.11,2.11,0,0,1,1.12-2.78,2.06,2.06,0,0,1,.88-.17h51.22a4.43,4.43,0,0,1,3.86,3l12.2,38.2a2.09,2.09,0,0,1-2,2.91Z"/>
                                    <path class="cls-30" d="M156.63,219.88c.65,2.55-.62,4.62-2.84,4.62s-4.55-2.07-5.21-4.62.62-4.62,2.84-4.62S156,217.34,156.63,219.88Z"/>
                                    <g class="heart">
                                        <path class="cls-2" d="M182.35,182h-5.81a1.59,1.59,0,0,0-1.58,1.59v4.53a1.6,1.6,0,0,0,1.58,1.59h2.13l.78,1.86.76-1.86h2.14a1.59,1.59,0,0,0,1.58-1.59v-4.53A1.59,1.59,0,0,0,182.35,182Z"/>
                                        <path class="cls-6" d="M177.25,184.24c.58-.9,1.66-.54,2.21.18.56-.71,1.64-1,2.19-.12.93,1.55-1,3-2,3.51l-.27.16-.26-.16C178.22,187.24,176.28,185.77,177.25,184.24Z"/>
                                    </g>
                                    <g class="heart">
                                        <path class="cls-32" d="M168.32,152.72h-7.79a2.11,2.11,0,0,0-2.13,2.11h0v6.09a2.12,2.12,0,0,0,2.12,2.12h2.87l1,2.52,1-2.52h2.86a2.12,2.12,0,0,0,2.12-2.12v-6.09A2.12,2.12,0,0,0,168.32,152.72Z"/>
                                        <path class="cls-6" d="M161.48,155.78c.78-1.22,2.21-.73,3,.23.76-.94,2.21-1.4,3-.16,1.25,2.1-1.4,4-2.65,4.72l-.36.21-.35-.22C162.8,159.79,160.18,157.84,161.48,155.78Z"/>
                                    </g>
                                <path class="cls-30" d="M204.86,286.28l3.57-7.9a.87.87,0,0,1,1.16-.42h0l3.86,1.89s5.37,2.17,6,3.92c2,5.1-5.5,22.79-7.83,22.79-.85,0-1.36-1.32-1.48-2.17-.38-2.68-.44-9.41-.78-11.64-.4-2.6-3-4.61-4.26-5.41A.85.85,0,0,1,204.86,286.28Z"/><path class="cls-30" d="M146.17,276.41l3.15,8.08a.87.87,0,0,1-.5,1.11h0l-4,1.43s-5.32,2.32-7,1.58c-5-2.16-12.43-19.87-10.79-21.54.59-.61,1.89-.05,2.58.46,2.17,1.61,7,6.27,8.86,7.58,2.14,1.55,5.42,1.06,6.84.75A.84.84,0,0,1,146.17,276.41Z"/></g></g></svg>
                                </div>        
                           </div>
                          
                           <div class="bg_icons">
                              <span class="icon_background fb_icon_position"><i class="bi bi-facebook"></i></span>
                               <span class="icon_background linkedin_icon_position"><i class="bi bi-linkedin"></i></span>
                               <span class="icon_background wp_icon_position"><i class="bi bi-whatsapp"></i></span>
                               <span class="icon_background twitter_icon_position"><i class="bi bi-twitter"></i></span> 
                           </div>
                        </div>
                    </div>
                </div> 
                </div>
                <div class="section_child2">
                    <div class="arrow">
                        <i class="bi bi-chevron-down arrow1"></i> 
                    </div>
                </div>
            </section> 
            <!-- section3 -->          
            <section id="section3" class="section">
                <div class="section_child1">
                    <div class="container">
                        <div class="position-relative">
                            <div class="row justify-content-center my-5">
                               <div class="col-lg-9 col-md-10 col-sm-12">
                                    <div class="text-center que_background_img">
                                        <h1 class="font-700 color-text-gradient">Does your business have a great social media presence?</h1>      
                                    </div>        
                               </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="section_child2">
                    <div class="arrow">
                        <i class="bi bi-chevron-down arrow1"></i> 
                    </div>
                </div>    
            </section>
            <!-- section4 -->
           <section id="section4" class="section">
                <div class="section_child1">
                    <div class="container">
                        <div class="position-relative">
                            <div class="row justify-content-center my-5">
                                <div class="col-lg-9 col-md-10 col-sm-12">
                                    <div class="text-center que_background_img">
                                        <h1 class="font-700 color-text-gradient">Do you want your own customers to be your followers?</h1>      
                                    </div>        
                                </div>
                                <div class="bg_icons">
                                    <span class="icon_background fb_icon_position"><i class="bi bi-facebook"></i></span>
                                    <span class="icon_background linkedin_icon_position"><i class="bi bi-linkedin"></i></span>
                                    <span class="icon_background wp_icon_position"><i class="bi bi-whatsapp"></i></span>
                                    <span class="icon_background twitter_icon_position"><i class="bi bi-twitter"></i></span> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="section_child2">
                    <div class="arrow">
                        <i class="bi bi-chevron-down arrow1"></i> 
                    </div>
                 </div>   
            </section> 
             <!-- section5 -->
            <section id="section5" class="section">
                <div class="section_child1">
                    <div class="container">
                        <div class="position-relative">
                            <div class="row justify-content-center my-5">
                                <div class="col-lg-9 col-md-10 col-sm-12">
                                    <div class="text-center">
                                        <h1 class="display-1 font-900 color-text-gradient text-uppercase yes_section">If yes!! </h1>
                                    </div>        
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="section_child2">
                    <div class="arrow">
                        <i class="bi bi-chevron-down arrow1"></i> 
                    </div>
                </div>   
            </section>
            <!-- section6 -->
           <section id="section6" class="section">
                <div class="section_child1">
                    <div class="container">
                    <div class="position-relative">
                        <div class="row my-5  justify-content-between">
                            <div class="col-lg-7 col-md-10 col-sm-12">
                                <div class="">
                                    <div class="section6_text" style="line-height: 1;">
                                        <span class="d-block h5" style="line-height: 1;">Well, then we are here to help you to</span>
                                        <span class="h1 font-900 color-text-gradient text-uppercase d-block">grow your social media presence</span>
                                         <span class="d-block h5" style="line-height: 1;">with the right set of audiences.Replace your Paid campaigns with</span>
                                        <span class="h1 font-900 color-text-gradient text-uppercase d-block"> INSTANT REWARD From OPENLINK.</span>
                                    </div>      
                                </div>        
                            </div>
                            <div class="col-lg-4">
                                <div class="social_media_presence_img">
                                  <img src="{{ asset('assets/front/images/features_landing_pages/grow_your_social_presence.svg') }}">  
                                </div>  
                            </div>

                        </div>
                    </div>
                    </div>
                </div>
                <div class="section_child2">
                    <div class="arrow">
                        <i class="bi bi-chevron-down arrow1"></i> 
                    </div>
                </div>     
           </section>  
            <!-- section7 -->
           <section id="section7" class="section">
                <div class="section_child1" style="justify-content:flex-start">
                    <div class="container">
                        <div class="position-relative">
                            <div class="row justify-content-center my-5">
                               <div class="col-lg-9 col-md-10 col-sm-12">
                                    <div class="text-center">
                                        <h1 class="display-1 font-700 color-text-gradient text-uppercase section7_text">how?</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                    
                <div class="section_child2">
                    <div class="text-center section7_img">
                        <img src="{{ asset('assets/front/images/features_landing_pages/how.svg') }}" style="max-width: 300px;">
                    </div>
                    <div class="arrow">
                        <i class="bi bi-chevron-down arrow1"></i> 
                    </div>
                </div>     
            </section>  
        <!-- section 8 -->
            <section id="section8" class="section">
                <div class="container">
                    <div class="position-relative">
                        <div class="row justify-content-center my-5">
                           <div class="col-lg-9 col-md-10 col-sm-12">
                                <div class="text-center pb-3">
                                   <h1 class="text-uppercase">OpenLinks Instant Reward Is all your answers!</h1>
                                   <p>One can easily integrate social media pages & create an instant giveaway or run offers to engage the audience with an open link. Instant offers are the ones that are beneficial for the customers right at the same time there today itself. OPENLINK'S Instant Reward helps you grow your social media presence with your own customers.</p>
                                   <p>Create an Instant reward task for your customer, ask them to follow, like, subscribe on your business social media platform as per your business strategy and avail them back with a small offer or benefit after doing the task at the time of purchase.</p>
                                </div>  
                                <div class="text-center my-5">
                                   <h1>Why Instant Reward for your business?</h1> 
                                   <p>Social Media is one of the Important factors today when it comes to growing brand reach and Brand Visibility. But more than growing brand reach more important factor is reaching the right set of audiences and growing it within them and through them. This is where OPENLINK Instant Reward helps. OpenLink makes your customer at your billing counter your follower.</p>
                                </div>     
                                <div class="bg_options mb-4">
                                    <div class="background_number d-inline ms-3"><i class="bi bi-caret-right-fill"></i></div>
                                    <h5 class="d-inline ms-2">Saves on your costly paid ads to achieve more followers.</h5>
                                </div>
                                <div class="bg_options mb-4">
                                    <div class="background_number d-inline ms-3"><i class="bi bi-caret-right-fill"></i></div>
                                    <h5 class="d-inline ms-2">Saves your time.</h5>
                                </div>
                                <div class="bg_options mb-4">
                                    <div class="background_number d-inline ms-3"><i class="bi bi-caret-right-fill"></i></div>
                                    <h5 class="d-inline ms-2">Your real customers are your followers.</h5>
                                </div>        
                                <div class="bg_options mb-4">
                                    <div class="background_number d-inline ms-3"><i class="bi bi-caret-right-fill"></i></div>
                                    <h5 class="d-inline ms-2">Once connected on social media; your customers are always updated with your business activities.</h5>
                                </div> 
                                <div class="bg_options mb-4">
                                    <div class="background_number d-inline ms-3"><i class="bi bi-caret-right-fill"></i></div>
                                    <h5 class="d-inline ms-2">Grows social media presence with organic targeted audience base.</h5>
                                </div> 
                           </div>
                        </div>
                    </div>
                </div>
                <div class="oplk-bg-color-gradient  w-100">
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                           <div class="col-lg-9 px-0">
                                <div class="text-center text-white py-4 px-0">
                                    <h2 class="font-700">How to create instant rewards and grow social media presence?</h2>
                                </div> 
                           </div> 
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row justify-content-center my-5">
                       <div class="col-lg-6 col-md-8 col-sm-10 text-center">
                           <div class="position-relative">
                                <!-- circle1 -->
                                <div class="circle_img_right mb-5">
                                    <img src="{{ asset('assets/front/images/features_landing_pages/arrow_left.svg') }}"> 
                                    <div class="steps_circle">
                                        <div class="text-center inside_circle">
                                            <h1 class="text-uppercase color-text-gradient font-900">Step 1</h1>
                                            <h5>Log in to OPENLINK</h5>
                                        </div>
                                    </div>
                                </div> 
                                <!-- circle2 -->
                                 <div class="circle_img_left mb-5">
                                    <img src="{{ asset('assets/front/images/features_landing_pages/arrow_right.svg') }}"> 
                                    <div class="steps_circle float-end">
                                        <div class="text-center inside_circle">
                                            <h1 class="text-uppercase color-text-gradient font-900">Step 2</h1>
                                            <h5>Here you are landed to OPENLINK'S dashboard click to Instant Reward</h5>
                                        </div>
                                    </div>
                                </div> 
                                <!-- circle3 -->
                                <div class="circle_img_right mb-5">
                                    <img src="{{ asset('assets/front/images/features_landing_pages/arrow_left.svg') }}"> 
                                    <div class="steps_circle">
                                        <div class="text-center inside_circle">
                                            <h1 class="text-uppercase color-text-gradient font-900">Step 3</h1>
                                            <h5>Click on create offer</h5> 
                                        </div>
                                    </div>
                                </div> 
                                <!-- circle4 -->
                                 <div class="circle_img_left mb-5">
                                    <img src="{{ asset('assets/front/images/features_landing_pages/arrow_right.svg') }}"> 
                                    <div class="steps_circle float-end">
                                        <div class="text-center inside_circle">
                                            <h1 class="text-uppercase color-text-gradient font-900">Step 4</h1>
                                            <h5> Fill in the offer and social media-related details as per your business offer strategy & click on the save & publish button</h5>
                                        </div>
                                    </div>
                                </div>
                                <!-- circle5 -->
                                <div class="circle_img_right mb-5">
                                    <img src="{{ asset('assets/front/images/features_landing_pages/arrow_left.svg') }}"> 
                                    <div class="steps_circle">
                                        <div class="text-center inside_circle">
                                            <h1 class="text-uppercase color-text-gradient font-900">Step 5</h1>
                                            <h5>You are all ready to share, click on subscribe and share it with your customers</h5>
                                        </div>
                                    </div>
                                </div>
                                <!-- circle6 -->
                                <div class="circle_img_left mb-5">
                                    <img src="{{ asset('assets/front/images/features_landing_pages/arrow_right.svg') }}"> 
                                    <div class="steps_circle float-end">
                                        <div class="text-center inside_circle">
                                            <h1 class="text-uppercase color-text-gradient font-900">Step 6</h1>
                                            <h5>That’s it!!</h5>
                                        </div>
                                    </div>
                                </div>
                             </div>
                            <button class="btn-theme btn-sm-lg mt-5">BUY INSTANT REWARD NOW</button> 
                            <h6 class="my-2">LIMITED PERIOD OFFER!</h6>
                        </div>
                    </div>    
            </section>
        </div>
    </div>
</section>
@endsection

@section('end_body')
    <script>
        (function() {
              var delay = false;

              $(document).on('mousewheel DOMMouseScroll', function(event) {
                event.preventDefault();
                if(delay) return;

                delay = true;
                setTimeout(function(){delay = false},200)

                var wd = event.originalEvent.wheelDelta || -event.originalEvent.detail;

                var a= document.getElementsByClassName('section');
                if(wd < 0) {
                  for(var i = 0 ; i < a.length ; i++) {
                    var t = a[i].getClientRects()[0].top;
                    if(t >= 40) break;
                  }
                }
                else {
                  for(var i = a.length-1 ; i >= 0 ; i--) {
                    var t = a[i].getClientRects()[0].top;
                    if(t < -20) break;
                  }
                }
                
                if(i >= 0 && i < a.length) {
                  $('html,body').animate({
                    scrollTop: a[i].offsetTop
                  });
                }
              });
            })();
            console.clear();
    </script>
@endsection