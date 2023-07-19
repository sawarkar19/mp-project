@extends('layouts.front')

@section('title', 'personalised wishing | OpenLink ')
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
   
   /* .text_img:after{
        content: '';
        background-image: url({{ asset('assets/front/images/features_landing_pages/gift_box.svg') }});
        position: absolute;
	    top: -25px;
	    right: 36px;
	    background-repeat: no-repeat;
	    width: 60px;
	    height: 60px;
        z-index: -1;
    }*/
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
    .logo{
        position: relative;
    }
    .logo img{
        position: absolute;
    }
    .section7_text{
        padding: 135px;
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
    .section6_text{
        animation: 1s 1 forwards cubic-bezier(.36,-0.01,.5,1.38) down;
        animation-delay: 0.6s;
        opacity:0;
    }
     @keyframes down {
      0% {transform: translateY(-160px);}
      100% {opacity:1;transform: translateY(0px);}
    }
    @-webkit-keyframes down {
      0% {transform: translateY(-160px);}
      100% {opacity:1;transform: translateY(0px);}
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
    .celebration{
        margin-top: 70px;
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
        h1{
            font-size: 22px;
        }
        span, p {
            font-size: 14px;
        }
        #section6 .h5{
            font-size: 14px;
            line-height: 1.4;
        }
        #section6 .h1{
            font-size: 22px;
            line-height: 1.3;
        }
        .icon_background i {
            padding: 8px 10px;
            font-size: 14px;
        }
        .section7_text{
            top: 165px;
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
                <div class="section_child1">
                    <div class="position-relative">
                        <div class="container">
                            <div class="pb-5">
                                <div class="celebration">
                                    <img src="{{ asset('assets/front/images/features_landing_pages/celebration.svg') }}" style="max-width: 50px;">
                                </div>
                                <div class="row justify-content-center align-items-center">
                                    <div class="col-lg-9 col-md-10 col-sm-12">
                                        <div class="align-middle">
                                            <div class="text-center position-relative">
                                                <div class="text_img">
                                                   <h1 class="font-700 color-text-gradient">Wish your customer effortlessly on their special day</h1>  
                                                </div>
                                                <p>Be there with your customer on their special day, wish them and make them feel valued as being your client.</p>
                                            </div>
                                        </div>
                                        <div class="text-center mt-5">
                                        	<svg style="max-width: 400px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 478.79 342.87">
                                                <defs>
                                                    <style>
                                                        .mobile{
                                                            animation: 0.7s 1 forwards cubic-bezier(.36,-0.01,.5,1.38) slideDown,3s Infinite linear rotate;
                                                            animation-delay: 0.6s, 1.6s;
                                                            opacity:0;
                                                            transform-origin: 154.729px 205.055px;
                                                        }
                                                        @keyframes slideDown {
                                                          0% {opacity: 0.5;transform: translateY(-60px);}
                                                          100% {opacity: 1;transform: translateY(0px);}
                                                        }
                                                        @-webkit-keyframes slideDown {
                                                          0% {opacity: 0.5;transform: translateY(-60px);}
                                                          100% {opacity: 1;transform: translateY(0px);}
                                                        }
                                                         @keyframes rotate{
                                                         0% {transform: rotate(0deg);}
                                                         50% {transform: rotate(5deg);}
                                                          100% {transform: rotate(0deg);}
                                                        }
                                                        @-webkit-keyframes slideDown {
                                                          0% {transform: rotate(0deg);}
                                                          50% {transform: rotate(5deg);}
                                                          100% {transform: rotate(0deg);}
                                                        } 
                                                        #Character{
                                                            animation: 0.7s 1 forwards cubic-bezier(.36,-0.01,.5,1.38) move, 3s Infinite linear shake;
                                                            animation-delay: 0.6s, 1.6s;
                                                            opacity:0;
                                                            transform-origin: 154.729px 205.055px;
                                                        }
                                                        @keyframes move {
                                                          0% {opacity: 0.5;transform: translateX(-50px);}
                                                          100% {opacity: 1;transform: translateX(0px);}
                                                        }
                                                        @-webkit-keyframes move {
                                                          0% {opacity: 0.5;transform: translateX(-50px);}
                                                          100% {opacity: 1;transform: translateX(0px);}
                                                        }
                                                        @keyframes shake {
                                                          0% {transform: translateX(0px);}
                                                          50% {transform: translateX(5px);}
                                                          100% {transform: translateX(0px);}
                                                        }
                                                        @-webkit-keyframes shake {
                                                          0% {transform: translateX(0px);}
                                                          50% {transform: translateX(5px);}
                                                          100% {transform: translateX(0px);}
                                                        }
                                                        #Character_m{
                                                            animation: 0.7s 1 forwards cubic-bezier(.36,-0.01,.5,1.38) move_m, 3s Infinite linear shake;
                                                            animation-delay: 0.6s, 1.6s;
                                                            opacity:0;
                                                            transform-origin: 154.729px 205.055px;
                                                        }
                                                        @keyframes move_m {
                                                          0% {opacity: 0.5;transform: translateX(50px);}
                                                          100% {opacity: 1;transform: translateX(0px);}
                                                        }
                                                        @-webkit-keyframes move_m {
                                                          0% {opacity: 0.5;transform: translateX(50px);}
                                                          100% {opacity: 1;transform: translateX(0px);}
                                                        }
                                                        .msg_box_left{
                                                            animation: 0.7s 1 forwards cubic-bezier(.36,-0.01,.5,1.38) Box;
                                                            animation-delay: 0.7s;
                                                            opacity:0;
                                                            transform-origin: 154.729px 205.055px;
                                                        }
                                                        @keyframes Box {
                                                          0% {opacity: 0.5;transform: translateX(-50px);}
                                                          100% {opacity: 1;transform: translateX(0px);}
                                                        }
                                                        @-webkit-keyframes Box {
                                                          0% {opacity: 0.5;transform: translateX(-50px);}
                                                          100% {opacity: 1;transform: translateX(0px);}
                                                        }
                                                        .msg_box_right{
                                                        animation: 0.7s 1 forwards cubic-bezier(.36,-0.01,.5,1.38) Box_R;
                                                            animation-delay: 0.7s;
                                                            opacity:0;
                                                            transform-origin: 154.729px 205.055px;
                                                        }
                                                        @keyframes Box_R {
                                                          0% {opacity: 0.5;transform: translateX(50px);}
                                                          100% {opacity: 1;transform: translateX(0px);}
                                                        }
                                                        @-webkit-keyframes Box_R {
                                                          0% {opacity: 0.5;transform: translateX(50px);}
                                                          100% {opacity: 1;transform: translateX(0px);}
                                                        }
                                                        #Sofa{
                                                            animation: 0.7s 1 forwards cubic-bezier(.36,-0.01,.5,1.38) sofa_m;
                                                            animation-delay: 0.6s, 1.6s;
                                                            opacity:0;
                                                            transform-origin: 154.729px 205.055px;
                                                        }
                                                        @keyframes sofa_m {
                                                          0% {opacity: 0.5;transform: translateX(50px);}
                                                          100% {opacity: 1;transform: translateX(0px);}
                                                        }
                                                        @-webkit-keyframes sofa_m {
                                                          0% {opacity: 0.5;transform: translateX(50px);}
                                                          100% {opacity: 1;transform: translateX(0px);}
                                                        }
                                                        .cls-1{fill:#c9d9e3;opacity:0.3;}.cls-2{fill:#333;}.cls-3{fill:#6b6b6b;}.cls-28,.cls-30,.cls-32,.cls-33,.cls-4,.cls-43,.cls-6{fill:#fff;}.cls-5{fill:url(#linear-gradient);}.cls-6{opacity:0.75;}.cls-7{fill:url(#linear-gradient-2);}.cls-8{fill:url(#linear-gradient-3);}.cls-9{fill:#ffb07d;}.cls-10{fill:url(#linear-gradient-4);}.cls-11{fill:#288cd4;}.cls-12{fill:#eaf0f5;}.cls-13{fill:gray;}.cls-14{fill:#f1f5f8;}.cls-15{fill:#d1d9db;}.cls-16{fill:#666;}.cls-17{fill:#263238;}.cls-18{fill:#976558;}.cls-19{fill:#455a64;}.cls-20{fill:url(#linear-gradient-5);}.cls-21{fill:url(#linear-gradient-6);}.cls-22,.cls-32,.cls-44{opacity:0.3;}.cls-23{fill:url(#linear-gradient-7);}.cls-24{fill:#e0e0e0;}.cls-25{fill:url(#linear-gradient-8);}.cls-26,.cls-38{opacity:0.2;}.cls-27{fill:url(#linear-gradient-9);}.cls-28,.cls-29,.cls-30,.cls-32,.cls-33,.cls-38,.cls-41,.cls-43,.cls-44{isolation:isolate;}.cls-28,.cls-29{opacity:0.5;}.cls-29{fill:#4f4f4f;}.cls-30{opacity:0.4;}.cls-31{fill:#6d6d6d;}.cls-33{opacity:0.6;}.cls-34{fill:#7a7a7a;}.cls-35{fill:#407bff;}.cls-36{fill:#757575;}.cls-37{fill:#fab27b;}.cls-39{fill:url(#linear-gradient-10);}.cls-40{fill:url(#linear-gradient-11);}.cls-41{opacity:0.1;}.cls-42{fill:url(#linear-gradient-12);}.cls-43{opacity:0.7;}.cls-45{fill:url(#linear-gradient-13);}.cls-46{fill:#ed893e;}.cls-47{fill:url(#linear-gradient-14);}
                                                    </style>
                                                    <linearGradient id="linear-gradient" x1="100.41" y1="64.88" x2="237.89" y2="64.88" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#00ffaf"/><stop offset="0.06" stop-color="#00edad"/><stop offset="0.32" stop-color="#00a6a7"/><stop offset="0.55" stop-color="#006ea2"/><stop offset="0.75" stop-color="#00469f"/><stop offset="0.91" stop-color="#002d9d"/><stop offset="1" stop-color="#00249c"/></linearGradient><linearGradient id="linear-gradient-2" x1="228.43" y1="116.87" x2="210.34" y2="89.5" xlink:href="#linear-gradient"/><linearGradient id="linear-gradient-3" x1="213.52" y1="161.88" x2="187.55" y2="215.69" xlink:href="#linear-gradient"/><linearGradient id="linear-gradient-4" x1="179.36" y1="143.95" x2="319.33" y2="143.95" xlink:href="#linear-gradient"/><linearGradient id="linear-gradient-5" x1="89.22" y1="157.93" x2="64.63" y2="119.43" xlink:href="#linear-gradient"/><linearGradient id="linear-gradient-6" x1="36.56" y1="140.26" x2="83.44" y2="140.26" xlink:href="#linear-gradient"/><linearGradient id="linear-gradient-7" x1="62.96" y1="312.41" x2="88.61" y2="312.41" xlink:href="#linear-gradient"/><linearGradient id="linear-gradient-8" x1="39.5" y1="312.67" x2="65.16" y2="312.67" xlink:href="#linear-gradient"/><linearGradient id="linear-gradient-9" x1="78.94" y1="161.56" x2="29.77" y2="118.89" xlink:href="#linear-gradient"/><linearGradient id="linear-gradient-10" x1="423.95" y1="327.85" x2="438.79" y2="344.55" xlink:href="#linear-gradient"/><linearGradient id="linear-gradient-11" x1="449.74" y1="304.92" x2="464.58" y2="321.62" xlink:href="#linear-gradient"/><linearGradient id="linear-gradient-12" x1="386.63" y1="217.3" x2="399.58" y2="217.3" xlink:href="#linear-gradient"/><linearGradient id="linear-gradient-13" x1="355.49" y1="227.61" x2="397.57" y2="227.61" xlink:href="#linear-gradient"/><linearGradient id="linear-gradient-14" x1="374.06" y1="204.07" x2="327.21" y2="212.65" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#00ffaf"/><stop offset="0.32" stop-color="#00a6a7"/><stop offset="0.55" stop-color="#006ea2"/><stop offset="0.75" stop-color="#00469f"/><stop offset="0.91" stop-color="#002d9d"/><stop offset="1" stop-color="#00249c"/></linearGradient>
                                                </defs>
                                                <g id="Layer_2" data-name="Layer 2">
                                                    <g id="Layer_1-2" data-name="Layer 1">
                                                        <path class="cls-1" style="opacity: 0.3;" d="M427.9,324.4a6,6,0,0,1-5.74,6.18H5.74A6,6,0,0,1,0,324.4H0a6,6,0,0,1,5.74-6.18H422.16a6,6,0,0,1,5.74,6.18Z"/>
                                                        <path class="cls-2 mobile" d="M307.41,301.88c0,10.73-8.09,19.43-18.06,19.43H133.92c-10,0-18.06-8.7-18.06-19.43V19.44C115.86,8.7,123.94,0,133.92,0H289.35c10,0,18.06,8.7,18.06,19.44Z"/>
                                                        <rect class="cls-3 mobile" x="199.28" y="12.36" width="23.17" height="4.63"/>
                                                        <path class="cls-4 mobile" d="M296.49,285.14V23.41c0-7-3.77-12-10.81-12h-37l-6.21,15.45H210.22V297.18h76.19c6.09,0,10.08-5.53,10.08-10.61A8.54,8.54,0,0,0,296.49,285.14Z"/>
                                                        <path class="cls-4 mobile" d="M126.58,285.14V23.41c0-7,3.77-12,10.81-12h37l6.21,15.45h32.29V297.18H136.66c-6.09,0-10.08-5.53-10.08-10.61A8.54,8.54,0,0,1,126.58,285.14Z"/>
                                                        <g class="msg_box_left">
                                                            <rect class="cls-5" x="100.41" y="35.53" width="137.48" height="58.7" rx="8.42"/>
                                                            <rect class="cls-6" x="156.02" y="55.61" width="30.9" height="4.63" rx="2.32"/>
                                                            <rect class="cls-6" x="156.02" y="67.97" width="58.7" height="4.63" rx="2.32"/>
                                                            <polygon class="cls-7" points="223.63 94.23 223.9 109.89 203.29 94.23 223.63 94.23"/>
                                                            <g class="user">
                                                                <path class="cls-9" d="M130.91,63.08a7.2,7.2,0,1,0-7.2-7.2A7.2,7.2,0,0,0,130.91,63.08Z"/>
                                                                <path class="cls-9" d="M131.41,65.38c-7,0-12.68,4.13-12.68,10.31H144.1C144.1,69.51,138.42,65.38,131.41,65.38Z"/>
                                                            </g>
                                                            <g class="gift_box">
                                                                <rect class="cls-4" x="218.79" y="61.56" width="14.37" height="11.4"/>
                                                                <polygon class="cls-16" points="226.75 61.56 220.12 72.91 218.79 72.91 218.79 72.7 225.26 61.56 226.75 61.56"/>
                                                                <polygon class="cls-16" points="232.39 61.56 225.72 72.91 224.28 72.91 230.9 61.56 232.39 61.56"/>
                                                                <polygon class="cls-16" points="233.11 67.41 233.11 69.93 231.37 72.91 229.88 72.91 233.11 67.41"/>
                                                                <polygon class="cls-16" points="218.79 66.8 218.79 64.23 220.53 61.25 222.02 61.25 218.79 66.8"/>
                                                                <path class="cls-16" d="M232.39,58.74c-1.64,2.1-4.72,1.95-4.72,1.95,2.77-.62,5.8-3.9,2.82-5.19S226,60.69,226,60.69s-2.2-7-4.62-4.62,2.93,4.77,2.93,4.77c-1.69.15-4.52-1.8-4.52-1.8L219,60.17c2.62,2,6.93,1.34,6.93,1.34,3.65.92,7.19-1.59,7.19-1.59Zm-10.21-1.8c.92-.62,2.41,2.82,2.41,2.82S221.25,57.56,222.18,56.94Zm5,2.82s1.18-3.69,2.67-3S227.21,59.76,227.21,59.76Z"/>
                                                            </g>
                                                        </g>
                                                        <g class="msg_box_right">
                                                            <polygon class="cls-8" points="198 171.4 198.46 189.76 219.59 171.94 198 171.4"/>
                                                            <rect class="cls-10" x="179.36" y="113.8" width="139.97" height="60.31" rx="8.42"/>
                                                            <rect class="cls-6" x="203.91" y="135.94" width="64.88" height="4.63" rx="2.32"/>
                                                            <rect class="cls-6" x="203.91" y="149.84" width="44.8" height="4.63" rx="2.32"/>
                                                            <path class="cls-11" d="M288.94,144.73a7.21,7.21,0,1,0-7.2-7.2A7.2,7.2,0,0,0,288.94,144.73Z"/>
                                                            <path class="cls-11" d="M288.82,148c-7,0-12.68,4.62-12.68,10.31h25.37C301.51,152.61,295.83,148,288.82,148Z"/>
                                                        </g>
                                                        
                                                        <rect class="cls-12 mobile" x="139.03" y="199.28" width="143.66" height="29.35" rx="14.2"/>
                                                        <rect class="cls-13 mobile" x="151.39" y="207" width="4.63" height="13.9" rx="2.32"/>
                                                        <rect class="cls-14 mobile" x="139.03" y="245.62" width="18.54" height="18.54" rx="2.37"/>
                                                        <rect class="cls-14 mobile" x="165.29" y="245.62" width="18.54" height="18.54" rx="2.37"/>
                                                        <rect class="cls-14 mobile" x="190.01" y="245.62" width="18.54" height="18.54" rx="2.37"/>
                                                        <rect class="cls-15 mobile" x="216.27" y="245.62" width="18.54" height="18.54" rx="2.37"/>
                                                        <rect class="cls-14 mobile" x="240.98" y="245.62" width="18.54" height="18.54" rx="2.37"/>
                                                        <rect class="cls-14 mobile" x="265.7" y="245.62" width="18.54" height="18.54" rx="2.37"/>
                                                        <rect class="cls-14 mobile" x="139.03" y="270.33" width="18.54" height="18.54" rx="2.37"/>
                                                        <rect class="cls-15 mobile" x="165.29" y="270.33" width="18.54" height="18.54" rx="2.37"/>
                                                        <rect class="cls-14 mobile" x="190.01" y="270.33" width="44.8" height="18.54" rx="2.37"/>
                                                        <rect class="cls-14 mobile" x="240.98" y="270.33" width="18.54" height="18.54" rx="2.37"/>
                                                        <rect class="cls-15 mobile" x="265.7" y="270.33" width="18.54" height="18.54" rx="2.37"/>
                                                        <ellipse class="cls-4" cx="225.92" cy="60.64" rx="0.98" ry="0.82"/>
                                                    <g id="Character">
                                                            <path class="cls-17" d="M69.24,80.64S72,92.56,72,100.93v2.79s-7.17,5.57-13,5.73L54.48,97.24Z"/>
                                                            <path class="cls-18" d="M89.63,129.76l-10.42,7.46.27,2.79,3,5.77s1.35,1.18,5-2.79,8.13-11.78,8.13-11.78Z"/>
                                                            <path class="cls-17" d="M109.6,112.26a1,1,0,0,0-.8-.55l-5.88-.59a1.87,1.87,0,0,0-1.41.49L85.33,127l.79.72L92.46,129l17.28-16.48Z"/>
                                                            <path class="cls-4" d="M105,113.66a.37.37,0,0,0,.5,0,.31.31,0,0,0-.5-.38A.3.3,0,0,0,105,113.66Z"/>
                                                            <path class="cls-19" d="M109.74,112.53a6.33,6.33,0,0,1-1.15,0l-3.13-.25-2.16-.2a1.23,1.23,0,0,0-1,.31l-.93.88-4.13,3.93c-3,2.78-5.6,5.29-7.61,7.08l-2.32,2.11a7,7,0,0,1-.89.74,7.85,7.85,0,0,1,.79-.84c.57-.56,1.34-1.3,2.25-2.2,1.9-1.85,4.55-4.37,7.49-7.16l4.16-3.91.94-.87a1.51,1.51,0,0,1,1.23-.37l2.16.24,3.12.37A6.75,6.75,0,0,1,109.74,112.53Z"/>
                                                            <path class="cls-18" d="M101.86,117.52s-.49-.21-1.1,1.11-2.46,5.09-2.46,5.09L96,121.66l-3.44-.36s-.88.5-.44,1a12.35,12.35,0,0,0,2.46,1.37l1,2.6-3.93-3.21s-1.58,0-1.34,1a30.88,30.88,0,0,0,2.54,4.57l-2.2-.67-2.26-2.25s-.82-.16-.67.6a27.19,27.19,0,0,0,2.3,3.93L93,132.7s1.86.3,2.16-.2a6.26,6.26,0,0,0,.53-1.25s1,0,1.34-.45a3.15,3.15,0,0,0,.36-1.2s1.46.63,1.85-.17a10.07,10.07,0,0,0,.64-3.2c0-.67,2.26-6.56,2.24-6.75S102.9,117.34,101.86,117.52Z"/>
                                                            <path class="cls-18" d="M95.2,132.5a1.84,1.84,0,0,1-.93.06,6.15,6.15,0,0,1-2.18-.63,6,6,0,0,1-1.8-1.39c-.38-.44-.54-.76-.5-.79a12.48,12.48,0,0,0,2.46,1.87A12.68,12.68,0,0,0,95.2,132.5Z"/>
                                                            <path class="cls-18" d="M94.7,131.11c-.07.06-.59-.39-1.1-1.06s-.8-1.29-.72-1.34.51.48,1,1.13S94.78,131.05,94.7,131.11Z"/>
                                                            <path class="cls-18" d="M97.15,128.64c-.07.07-.58-.37-1.05-1.06a2.67,2.67,0,0,1-.59-1.38c.08,0,.44.51.89,1.18S97.22,128.58,97.15,128.64Z"/>
                                                            <path class="cls-18" d="M99.56,126.77a8.47,8.47,0,0,1-.67-1.51,9,9,0,0,1-.67-1.48c.07-.06.62.48,1,1.34A2.65,2.65,0,0,1,99.56,126.77Z"/>
                                                            <path class="cls-20" d="M64.81,111.42s5.44-.87,8.59,1.65a13.07,13.07,0,0,1,5,9.14c.4,3.48,2.91,16.91,2.91,16.91l4.91-6.64,5.42,4.75S87,159.15,82.73,160.62s-9-3.35-10.06-4.21S64.81,111.42,64.81,111.42Z"/>
                                                            <path class="cls-21" d="M64.81,111.42s9,10.06,9.8,12.64,6.84,7.3,6.71,13.46a58.92,58.92,0,0,1-.76,8.38,13.07,13.07,0,0,0,.09,4.75l2.79,13.41a8.21,8.21,0,0,1-6.14,3.54c-4.36.48-15.5,3.1-22.9,0L49.08,165V144.22l-3.64-8.47-8.88-17.29A89.87,89.87,0,0,1,64.81,111.42Z"/>
                                                            <path class="cls-17" d="M82.92,161.39a2.67,2.67,0,0,0-.07-.47l-.24-1.34-1-4.89c-.18-1-.52-2.14-.67-3.35l-.15-.94c0-.31,0-.63-.08-1a17,17,0,0,1,0-2,18,18,0,0,1,.72-4.25,14.75,14.75,0,0,0,.8-4.65A13.18,13.18,0,0,0,81.05,134a29.3,29.3,0,0,0-2-3.88c-1.48-2.37-3-4.39-4.19-6.1s-2.22-3.06-2.92-4l-.84-1.09a2.06,2.06,0,0,0-.29-.37,2.65,2.65,0,0,0,.24.4l.74,1.14c.67,1,1.62,2.38,2.83,4.11s2.68,3.76,4.13,6.12a30.58,30.58,0,0,1,2,3.85,13,13,0,0,1,1.13,4.46,14.4,14.4,0,0,1-.78,4.55,18.06,18.06,0,0,0-.71,4.33,17.55,17.55,0,0,0,.06,2.05,9.63,9.63,0,0,0,.1,1c0,.3.1.63.15.94.18,1.23.54,2.34.72,3.35.45,2,.81,3.69,1.07,4.87.13.55.23,1,.3,1.34A1.94,1.94,0,0,0,82.92,161.39Z"/>
                                                            <g class="cls-22">
                                                                <path d="M79.57,145.72c-1.59,4.83-4.47,8.61-7.73,12.52a21.47,21.47,0,0,1-12.25,7.43c7.24-6.21,13.27-13.09,20-19.95"/>
                                                    </g>
                                                    <path class="cls-23" d="M76.27,302.12l-.86,13.21s13.12,5.31,13.2,7.77L63,322.34l.51-20.62Z"/>
                                                    <path class="cls-24" d="M67.5,314a1,1,0,0,0-.76,1.18,1,1,0,0,0,1.15.76,1.09,1.09,0,0,0,.81-1.27,1,1,0,0,0-1.28-.67"/>
                                                    <path class="cls-17" d="M62.92,323.24l0-2.37,24.64.89s1.14.53,1,1.34Z"/>
                                                    <path class="cls-17" d="M75.83,315.21c0,.12-.63.16-1.27.54s-1,.9-1.08.85.09-.77.86-1.23S75.86,315.09,75.83,315.21Z"/>
                                                    <path class="cls-17" d="M78.49,316.39c0,.13-.53.33-1,.84s-.58,1.07-.67,1.07a1.26,1.26,0,0,1,.38-1.34C77.79,316.34,78.49,316.28,78.49,316.39Z"/>
                                                    <path class="cls-17" d="M79.92,319.66c-.12,0-.27-.6.07-1.28s.94-.93,1-.83-.33.46-.6,1S80,319.65,79.92,319.66Z"/>
                                                    <path class="cls-17" d="M75.69,312.18c0,.11-.62-.08-1.34-.06s-1.27.24-1.34.13.48-.54,1.34-.56S75.76,312.07,75.69,312.18Z"/>
                                                    <path class="cls-25" d="M52.64,302.38l-.75,13.2s13.17,5.21,13.27,7.66l-25.66-.53.33-20.62Z"/>
                                                    <path class="cls-24" d="M44,314.31a1,1,0,0,0-.75,1.18,1,1,0,0,0,1.17.75,1.11,1.11,0,0,0,.78-1.25,1,1,0,0,0-1.29-.68"/>
                                                    <path class="cls-17" d="M39.47,323.24v-2l24.67.67s1.14.52,1,1.34Z"/>
                                                    <path class="cls-17" d="M52.31,315.46c0,.13-.64.17-1.26.56s-1,.91-1.08.86.09-.78.85-1.23S52.34,315.33,52.31,315.46Z"/>
                                                    <path class="cls-17" d="M55,316.63c0,.13-.53.33-1,.84s-.57,1.08-.67,1.08-.19-.72.37-1.35S55,316.51,55,316.63Z"/>
                                                    <path class="cls-17" d="M56.44,319.89c-.12,0-.28-.61.06-1.29s.93-.94,1-.83-.32.46-.59,1S56.56,319.87,56.44,319.89Z"/>
                                                    <path class="cls-17" d="M52.15,312.43c-.06.11-.63-.07-1.34,0s-1.27.24-1.34.13S50,312,50.81,312,52.21,312.34,52.15,312.43Z"/>
                                                    <path class="cls-17" d="M48.72,164.57a55.93,55.93,0,0,0-10,15.31C35.34,188.34,36.84,229,36.84,229l.72,21.32s-1,18.31-.24,31.37S39,309.15,39,309.15l14.25.67L68.36,199.1l-3.79,51.06c-2.4,13-2.12,36-1.65,59.65H78s5.2-35.35,6.38-43.74c1.34-9.49,5.29-35.59,5.29-35.59s3-25,2-38.42S82.62,159.79,82.35,159l-32.22,5.81"/>
                                                    <path class="cls-19" d="M47.09,161,43.3,171.05S15.19,210.24,16,213.5s16.12,15.92,20.62,13.88,16.13-10.4,20-18.77,14.87-31.85,14.87-31.85L75,170.23l-3.88-2.68Z"/>
                                                    <path class="cls-19" d="M82.58,159.59h0c-3.4,1.83-3,7.54-6.45,9.39,5.68,8,7.63,18,8.4,27.71s.54,19.6,2.49,29.18l7-.5a165.94,165.94,0,0,0-6-55.9A24.66,24.66,0,0,0,82.58,159.59Z"/>
                                                    <path class="cls-17" d="M55.11,176.09a8.22,8.22,0,0,1-1.78-.41,37.86,37.86,0,0,1-4.14-1.5,37.2,37.2,0,0,1-3.94-2,7.61,7.61,0,0,1-1.51-1,11.13,11.13,0,0,1,1.63.79c1,.52,2.39,1.19,4,1.86s3,1.2,4.08,1.58A10.42,10.42,0,0,1,55.11,176.09Z"/>
                                                    <g class="cls-26">
                                                        <path d="M36.89,205.92l-.67.05a16.59,16.59,0,0,0,18.46,3.36c2.06-1,4.11-2.75,4-5A41.44,41.44,0,0,1,36.89,205.92Z"/>
                                                    </g>
                                                    <path class="cls-19" d="M72,170.26c-2.62-.48-7.66.89-9.51,2.82A19.37,19.37,0,0,0,58.59,180c-2,5.44-3.35,11.46-7.65,15.36-4,3.66-9.74,4.65-15.11,5.47-.15,2-.13,4.36,1.51,5.5A4.92,4.92,0,0,0,39,207a26.94,26.94,0,0,0,4.89.87c7.65.63,15.77-2.46,20.27-8.69,5.68-7.88,6.13-17.35,9.34-26.52"/>
                                                    <path class="cls-17" d="M73.46,172.69a1.43,1.43,0,0,1-.07.28c-.07.21-.15.49-.26.84-.24.73-.56,1.83-.94,3.24s-.8,3.16-1.3,5.19-1,4.33-1.82,6.83A37.22,37.22,0,0,1,65.72,197a22.9,22.9,0,0,1-2.78,3.91,20.19,20.19,0,0,1-3.85,3.35A23.75,23.75,0,0,1,48.9,208a24.3,24.3,0,0,1-5.78.06,24,24,0,0,1-2.92-.48c-.48-.11-1-.23-1.45-.37a4.91,4.91,0,0,1-1.42-.59,3.39,3.39,0,0,1-1.1-1.22,4.66,4.66,0,0,1-.5-1.5,11.74,11.74,0,0,1-.08-3v-.13h.14A43.79,43.79,0,0,0,46,198.24a16.59,16.59,0,0,0,4.26-2.51,15.81,15.81,0,0,0,3.13-3.55,36.53,36.53,0,0,0,3.59-8A66.91,66.91,0,0,1,59.7,177a16.35,16.35,0,0,1,1.71-2.87,12.35,12.35,0,0,1,1-1.17,5.84,5.84,0,0,1,1.15-.88A14.53,14.53,0,0,1,68,170.45a12.3,12.3,0,0,1,3-.3,4.46,4.46,0,0,1,1,.12,6.8,6.8,0,0,0-1-.06,13,13,0,0,0-2.92.36,15,15,0,0,0-4.36,1.69,7,7,0,0,0-1.1.87,13.12,13.12,0,0,0-1,1.15,16.61,16.61,0,0,0-1.67,2.85,67.08,67.08,0,0,0-2.63,7.14,36.08,36.08,0,0,1-3.59,8.08A15.91,15.91,0,0,1,50.51,196a16.45,16.45,0,0,1-4.34,2.58,43.73,43.73,0,0,1-10.33,2.5l.15-.16a12,12,0,0,0,.07,2.93,3.54,3.54,0,0,0,1.45,2.46,9.63,9.63,0,0,0,2.76.91,23.38,23.38,0,0,0,2.88.48,25.27,25.27,0,0,0,5.7,0A23.6,23.6,0,0,0,58.91,204a20.46,20.46,0,0,0,3.8-3.27,23.72,23.72,0,0,0,2.76-3.85A37.93,37.93,0,0,0,68.82,189c.78-2.49,1.34-4.8,1.86-6.81s.95-3.76,1.34-5.17.74-2.5,1-3.22c.13-.36.22-.63.3-.84A2.44,2.44,0,0,1,73.46,172.69Z"/>
                                                    <path class="cls-17" d="M41.82,207.54a10.47,10.47,0,0,0,.48-3.89A10.18,10.18,0,0,0,41,200a2.57,2.57,0,0,1,.74.93,6.71,6.71,0,0,1,.61,5.59A2.63,2.63,0,0,1,41.82,207.54Z"/>
                                                    <path class="cls-17" d="M42,202.64a13.19,13.19,0,0,1-3,.38,14,14,0,0,1-3,0,12.65,12.65,0,0,1,3-.38A14,14,0,0,1,42,202.64Z"/>
                                                    <path class="cls-17" d="M42.58,204.83a13.68,13.68,0,0,1-3.13.24,13.57,13.57,0,0,1-3.12-.11,14.18,14.18,0,0,1,3.12-.23A13.67,13.67,0,0,1,42.58,204.83Z"/>
                                                    <path class="cls-19" d="M78.42,172c4.69,4.25,6.46,11,6.29,17.31s-2,12.49-3.43,18.66-2.4,12.66-.89,18.81l-6,.87a25.31,25.31,0,0,1-6.71-19.75c.62-5.91,3.3-11.36,5.22-17s3.06-12,.68-17.38"/>
                                                    <path class="cls-17" d="M73.53,173.5c0,.09.09.18.13.27l.33.79a16.84,16.84,0,0,1,.8,3.2,20.81,20.81,0,0,1,.06,5.23,35.09,35.09,0,0,1-1.47,6.8c-.77,2.46-1.83,5.09-2.88,7.93A44.78,44.78,0,0,0,67.93,207a25.62,25.62,0,0,0,6.56,20.46l-.15-.05,3-.43,3.07-.44-.15.22a31.94,31.94,0,0,1-.44-11.57,94.32,94.32,0,0,1,2.11-10.53c.82-3.35,1.59-6.46,2.08-9.45a40.93,40.93,0,0,0,.59-8.35A23.57,23.57,0,0,0,81.2,175.4a18,18,0,0,0-2-2.59l-.6-.61a2.09,2.09,0,0,1-.2-.22,1.37,1.37,0,0,1,.22.19l.63.58a18.44,18.44,0,0,1,2.06,2.59,23.41,23.41,0,0,1,3.47,11.54,40.05,40.05,0,0,1-.55,8.4c-.48,3-1.24,6.17-2,9.49a91.71,91.71,0,0,0-2.09,10.51,31.89,31.89,0,0,0,.45,11.44l.05.19h-.19l-3.07.44-3,.42h-.1l-.06-.06a25.57,25.57,0,0,1-5.75-10.06,25,25,0,0,1-.85-10.73,45,45,0,0,1,2.61-9.39c1.07-2.84,2.14-5.46,2.92-7.91a36,36,0,0,0,1.52-6.73,22.61,22.61,0,0,0,0-5.2,19.3,19.3,0,0,0-.74-3.2l-.3-.8A.73.73,0,0,1,73.53,173.5Z"/>
                                                    <path class="cls-17" d="M79.41,221.89a28.16,28.16,0,0,0-4.21.07,28.7,28.7,0,0,0-4.08,1,3.49,3.49,0,0,1,1.1-.61,11.84,11.84,0,0,1,6-.77A3.43,3.43,0,0,1,79.41,221.89Z"/><path class="cls-17" d="M75.9,227.44a11,11,0,0,1-1.42-2.38,11.42,11.42,0,0,1-1.1-2.54,11,11,0,0,1,1.42,2.38A11.22,11.22,0,0,1,75.9,227.44Z"/>
                                                    <path class="cls-17" d="M79.05,227a24.36,24.36,0,0,1-2.28-5.25,12.41,12.41,0,0,1,1.3,2.57A12.12,12.12,0,0,1,79.05,227Z"/>
                                                    <path class="cls-17" d="M70.39,170s-.13-.13-.18-.4A2,2,0,0,1,71,167.7c.23-.15.41-.18.43-.14a4.3,4.3,0,0,0-.78,1.11C70.39,169.35,70.49,170,70.39,170Z"/>
                                                    <path class="cls-19" d="M78.23,168.52c-.82-1.28-2.75-1.71-4.26-1.89a3.69,3.69,0,0,0-3.8,3.25,4.08,4.08,0,0,0,3,4.17,4.58,4.58,0,0,0,4.84-1.9A3.45,3.45,0,0,0,78.23,168.52Z"/>
                                                    <path class="cls-17" d="M74.87,167.34a2.19,2.19,0,0,1,.81.95,4,4,0,0,1-1.44,5.37,2.15,2.15,0,0,1-1.17.41s.44-.18,1-.62a4.08,4.08,0,0,0,1.34-5.06C75.13,167.72,74.81,167.38,74.87,167.34Z"/>
                                                    <path class="cls-17" d="M77.86,168a1.41,1.41,0,0,1,.48.63,3.63,3.63,0,0,1-.39,3.7c-.31.39-.58.54-.6.52a5.75,5.75,0,0,1,.4-.67,4.43,4.43,0,0,0,.56-1.7,4.25,4.25,0,0,0-.2-1.77C78,168.33,77.81,168.07,77.86,168Z"/>
                                                    <g class="cls-26">
                                                        <path d="M78.32,172A6.27,6.27,0,0,1,73.74,174a3.14,3.14,0,0,0,2.37,1.64A2.42,2.42,0,0,0,78.32,172Z"/>
                                                    </g>
                                                    <g class="cls-26">
                                                        <path d="M56.86,177.87a5.5,5.5,0,0,0-2.52-1.47c-3.49-1.26-7.26-3.42-10.73-4.69,3.19,2.83,6.64,6.16,10.29,8.35.89.52,2,1,2.88.43A1.81,1.81,0,0,0,56.86,177.87Z"/>
                                                    </g>
                                                    <g class="cls-26">
                                                        <path d="M85.8,184.15a16.09,16.09,0,0,0-5.87-10.88c1.82,3.31,3.66,6.71,4.47,10.38.89,4.06.24,6.65-.17,10.79l.4,2A30.66,30.66,0,0,0,85.8,184.15Z"/>
                                                    </g>
                                                    <path class="cls-17" d="M55,180.77a2.73,2.73,0,0,1-.54-.27c-.34-.19-.81-.48-1.4-.87a42,42,0,0,1-8.17-7.06c-.46-.51-.82-.94-1.06-1.25a2.1,2.1,0,0,1-.34-.5c.55.5,1.08,1,1.58,1.58,1,1,2.32,2.33,3.91,3.7s3.1,2.53,4.22,3.35A16.63,16.63,0,0,1,55,180.77Z"/>
                                                    <path class="cls-27" d="M39.7,117.17s-14.19,4.19-9.26,20.38c3.93,12.9,17.92,31.65,22.94,30.68,9.81-1.9,32-29.71,32-29.23l-5-6.94s-25,21.37-26,21-9.79-22.45-9.79-22.45S41.73,117.71,39.7,117.17Z"/>
                                                    <path class="cls-9" d="M80.51,132.27l4.33-6.91,7.55-6.71s.39,1.34,0,1.91-1.14,2-1.14,2,6.42-4.89,7.37-4.89.67,1,.58,1.43S93.84,124,93.84,124l5.47.19,3.44,1.72s-.2,1.25-1.34,1.16a10.55,10.55,0,0,1-2.69-.8l-4.69.57L99.25,129l2.2,3.28s-.77,1.34-1.72.45a13.32,13.32,0,0,1-1.64-1.8l-3.9-.85,3.62,2.37.77,2.87s-1.25,1.25-1.73,0-.76-1.82-.76-1.82L94,133a7.18,7.18,0,0,1-3.44,2.11,23.93,23.93,0,0,0-5.64,3.11Z"/>
                                                    <path class="cls-18" d="M87.13,124.61a9.79,9.79,0,0,0,2.37-1,8.14,8.14,0,0,0,2.12-1.45,20.4,20.4,0,0,0-2.26,1.2A16.48,16.48,0,0,0,87.13,124.61Z"/>
                                                    <path class="cls-18" d="M92.31,126.5a.65.65,0,0,0,.37-.16,1.29,1.29,0,0,0,.19-1.79c-.15-.2-.31-.26-.33-.23a2,2,0,0,1,.32,1.13C92.79,126.11,92.25,126.43,92.31,126.5Z"/>
                                                    <path class="cls-17" d="M38.27,85.49c1.16-4.94,2.35-10,6.45-13.09,3.65-2.68,7.72-3.35,12.23-3a15.91,15.91,0,0,1,6.6,2.43c2.61,1.58,3.63,4.69,4.83,7.49,2.38,5.63,1.81,13.12,0,15.16L44.8,106c-4-2.27-6.75-3.35-7.69-7.89C36.48,95,37.55,88.56,38.27,85.49Z"/>
                                                    <path class="cls-9" d="M45.07,77l14.75-3.82c4.69-.54,7.91,5.26,8.23,10,.37,5.26.61,11.72,0,15.65-1.22,7.91-7.26,9-7.26,9s0,.12,0,2.47l0,5.29c-1.94,6.41-8.45,5.64-16.56,2.31l-1.63-38A2.78,2.78,0,0,1,45.07,77Z"/>
                                                    <path class="cls-17" d="M66.12,90.13a1,1,0,0,1-1,1,1,1,0,0,1-1-.9h0a1,1,0,0,1,1-1,1,1,0,0,1,1,.87Z"/><path class="cls-17" d="M66.66,87.9c-.12.14-.89-.43-2-.42s-1.89.56-2,.43.06-.3.41-.55a2.79,2.79,0,0,1,1.6-.51,2.66,2.66,0,0,1,1.59.5C66.61,87.61,66.73,87.84,66.66,87.9Z"/>
                                                    <path class="cls-17" d="M56.5,89.89a1,1,0,0,1-1,1,1,1,0,0,1-1.05-.87v0a1,1,0,0,1,1-1,1,1,0,0,1,1,.87Z"/><path class="cls-17" d="M55.94,87.68c-.12.13-.9-.43-2-.42s-1.89.56-2,.43.07-.3.42-.55a2.8,2.8,0,0,1,1.61-.51,2.63,2.63,0,0,1,1.58.5C55.88,87.39,56,87.62,55.94,87.68Z"/>
                                                    <path class="cls-17" d="M60,94.88a7.67,7.67,0,0,1,1.77-.33c.28,0,.55-.08.59-.28a1.46,1.46,0,0,0-.19-.82l-.84-2.08a35.82,35.82,0,0,1-1.89-5.54,36.13,36.13,0,0,1,2.33,5.36c.28.75.54,1.46.81,2.14a1.58,1.58,0,0,1,.15,1.09.7.7,0,0,1-.46.41,2.42,2.42,0,0,1-.47.07A6.78,6.78,0,0,1,60,94.88Z"/>
                                                    <path class="cls-18" d="M60.79,107.79A20.12,20.12,0,0,1,50.19,105s2.68,5.51,10.56,4.69Z"/>
                                                    <path class="cls-18" d="M56.36,97a1.76,1.76,0,0,1,1.45-.81,2.29,2.29,0,0,1,2.09,1,1.39,1.39,0,0,1,.1,1c-.08.18,0,.09-.15.21a3.92,3.92,0,0,1-1.63,1,1.72,1.72,0,0,1-1.81-.67A1.77,1.77,0,0,1,56.36,97Z"/>
                                                    <path class="cls-17" d="M56.55,95.7c.18,0,.19,1.17,1.22,2s2.28.67,2.29.85-.27.23-.81.25a2.88,2.88,0,0,1-1.91-.67,2.57,2.57,0,0,1-1-1.68C56.34,96,56.47,95.69,56.55,95.7Z"/>
                                                    <path class="cls-17" d="M56.48,83.7c-.09.31-1.19.24-2.45.47s-2.28.67-2.47.41.08-.42.48-.74a4.1,4.1,0,0,1,1.8-.75,4,4,0,0,1,1.94.1C56.27,83.32,56.52,83.56,56.48,83.7Z"/>
                                                    <path class="cls-17" d="M66.67,85c-.26.21-1-.19-2-.38s-1.86-.16-2-.45c-.06-.14.12-.36.53-.53a3.24,3.24,0,0,1,1.72-.1,3.07,3.07,0,0,1,1.53.78C66.71,84.59,66.78,84.86,66.67,85Z"/>
                                                    <path class="cls-17" d="M59.62,72.32v.17h0Z"/>
                                                    <path class="cls-17" d="M48.16,110.57c-.15-2.08.75-4.13.57-6.21s-1.54-4.12-2-6.27c-.82-3.44.58-7,1.16-10.54a8.33,8.33,0,0,0,5.23-2.79,22.4,22.4,0,0,0,3.68-6.27,10.6,10.6,0,0,1-2.34,6,2.88,2.88,0,0,0,2.49-.72,6.45,6.45,0,0,0,1.51-2.2A17.23,17.23,0,0,0,60,75.34a22.49,22.49,0,0,1-1.34,9.19,3.85,3.85,0,0,1,1.72.12,1.91,1.91,0,0,0,1.65-.3,2,2,0,0,0,.47-1,23.4,23.4,0,0,0,.53-8,23.26,23.26,0,0,1,1.67,4.51,8.75,8.75,0,0,1-.12,4.76.66.66,0,0,0,.94,0l0,0a1.66,1.66,0,0,0,.46-1,12.12,12.12,0,0,0-.13-4,20.12,20.12,0,0,1,1.34,4.62,6.81,6.81,0,0,0,2.34,4.09,21,21,0,0,0,0-6A18,18,0,0,0,68,77.35a14.44,14.44,0,0,0-3.06-4.57c-2.26-2.11-3.27-1.27-4.78-.54l-.18.07a.2.2,0,0,0,0-.11l-.05-.32a22.25,22.25,0,0,0-11.76.17,15.77,15.77,0,0,0-7.88,6.12l-.08.15C36.65,84.23,34,92.65,36,106.4h0Z"/>
                                                </g>
                                                <g id="Sofa">
                                                    <path class="cls-2" d="M296.18,211.78h47.51a3.81,3.81,0,0,1,3.67,3.32l7.57,72a2.92,2.92,0,0,1-2.5,3.3,3.71,3.71,0,0,1-.47,0H304.45Z"/>
                                                    <path class="cls-28" d="M296.08,211.39H343.6a3.82,3.82,0,0,1,3.67,3.32l7.56,72a2.93,2.93,0,0,1-2.5,3.3,3.55,3.55,0,0,1-.46,0H304.35Z"/>
                                                    <path class="cls-2" d="M405.33,283.91c-.24-2.29-6.65-63.26-6.87-65.55a7.46,7.46,0,0,0-7.25-6.56H350.34a2.93,2.93,0,0,0-3,2.87,3.17,3.17,0,0,0,0,.44l7.57,72a3.81,3.81,0,0,0,3.68,3.32h40.85a5.79,5.79,0,0,0,5.92-5.66A6.79,6.79,0,0,0,405.33,283.91Z"/>
                                                    <path class="cls-28" d="M404.86,283.91c-.23-2.29-6.64-63.26-6.86-65.55a7.46,7.46,0,0,0-7.25-6.56H349.88a2.92,2.92,0,0,0-3,2.87,2.13,2.13,0,0,0,0,.44l7.57,72a3.81,3.81,0,0,0,3.68,3.32H399a5.79,5.79,0,0,0,5.91-5.66A5.43,5.43,0,0,0,404.86,283.91Z"/>
                                                    <path class="cls-29" d="M303.43,218.36a7.45,7.45,0,0,0-7.25-6.56,5.79,5.79,0,0,0-5.93,5.67,6.73,6.73,0,0,0,.05.89c.3,2.82,6.59,62.72,6.87,65.55a7.45,7.45,0,0,0,7.25,6.56,5.79,5.79,0,0,0,5.93-5.67,6.73,6.73,0,0,0-.05-.89C310.08,281.62,303.67,220.65,303.43,218.36Z"/>
                                                    <path class="cls-30" d="M303.43,218.34a7.47,7.47,0,0,0-7.25-6.56,5.8,5.8,0,0,0-5.93,5.67,6.55,6.55,0,0,0,.05.89c.3,2.83,6.59,62.73,6.87,65.56a7.47,7.47,0,0,0,7.25,6.56,5.8,5.8,0,0,0,5.93-5.67,6.55,6.55,0,0,0-.05-.89C310.08,281.6,303.67,220.63,303.43,218.34Z"/>
                                                    <path class="cls-31" d="M330.93,241.66H287.19a13.13,13.13,0,0,0,0,26.25v48.73a3.68,3.68,0,0,0,3.68,3.68h49.49a3.69,3.69,0,0,0,3.69-3.68V254.78A13.11,13.11,0,0,0,330.93,241.66Z"/>
                                                    <path class="cls-32" d="M330.93,241.66H287.19a13.13,13.13,0,0,0,0,26.25v48.73a3.68,3.68,0,0,0,3.68,3.68h49.49a3.69,3.69,0,0,0,3.69-3.68V254.78A13.11,13.11,0,0,0,330.93,241.66Z"/>
                                                    <path class="cls-2" d="M415.12,241.66h43.74a13.13,13.13,0,0,1,0,26.25v48.73a3.7,3.7,0,0,1-3.69,3.68H405.68a3.69,3.69,0,0,1-3.69-3.68V254.78A13.12,13.12,0,0,1,415.12,241.66Z"/>
                                                    <path class="cls-32" d="M415.37,241.66h43.75a13.13,13.13,0,0,1,0,26.25v48.73a3.7,3.7,0,0,1-3.7,3.68H405.94a3.7,3.7,0,0,1-3.7-3.68V254.78A13.14,13.14,0,0,1,415.37,241.66Z"/>
                                                    <path class="cls-2" d="M330.93,241.66a13.13,13.13,0,0,0,0,26.25v48.73a3.68,3.68,0,0,0,3.68,3.68h5.75a3.69,3.69,0,0,0,3.69-3.68V254.78A13.11,13.11,0,0,0,330.93,241.66Z"/>
                                                    <path class="cls-33" d="M330.93,241.66a13.13,13.13,0,0,0,0,26.25v48.73a3.68,3.68,0,0,0,3.68,3.68h5.75a3.69,3.69,0,0,0,3.69-3.68V254.78A13.11,13.11,0,0,0,330.93,241.66Z"/>
                                                    <path class="cls-34" d="M458.86,241.66a13.13,13.13,0,0,1,0,26.25v48.73a3.7,3.7,0,0,1-3.69,3.68h-5.75a3.69,3.69,0,0,1-3.69-3.68V254.78A13.12,13.12,0,0,1,458.86,241.66Z"/>
                                                    <path class="cls-33" d="M459.67,241.66a13.13,13.13,0,0,1,0,26.25v48.73a3.69,3.69,0,0,1-3.69,3.68h-5.75a3.7,3.7,0,0,1-3.69-3.68V254.78A13.13,13.13,0,0,1,459.67,241.66Z"/>
                                                    <rect class="cls-17" x="343" y="283.55" width="93.53" height="37.07" rx="5.32"/>
                                                    <rect class="cls-30" x="343" y="284.3" width="93.53" height="37.07" rx="5.32"/>
                                                    <rect class="cls-19" x="344.05" y="276.03" width="50.84" height="14.44" rx="4.67"/>
                                                    <rect class="cls-33" x="343.94" y="276.29" width="50.84" height="14.44" rx="4.67"/>
                                                    <rect class="cls-19" x="394.89" y="276.03" width="50.84" height="14.44" rx="4.67"/>
                                                    <rect class="cls-33" x="394.78" y="276.29" width="50.84" height="14.44" rx="4.67"/>
                                                    <path class="cls-35" d="M349.54,239.55c.1,1,.2,1.94.3,2.92,0,.21.37.21.35,0-.11-1-.21-2-.31-2.92C349.88,239.32,349.52,239.32,349.54,239.55Z"/>
                                                    <path class="cls-35" d="M347.84,223.48q.72,6.72,1.42,13.42c0,.21.36.22.34,0l-1.41-13.42C348.19,223.26,347.82,223.26,347.84,223.48Z"/>
                                                    <g class="cls-22">
                                                        <path class="cls-4" d="M349.54,239.55c.1,1,.2,1.94.3,2.92,0,.21.37.21.35,0-.11-1-.21-2-.31-2.92C349.88,239.32,349.52,239.32,349.54,239.55Z"/>
                                                    </g>
                                                    <g class="cls-22">
                                                        <path class="cls-4" d="M347.84,223.48q.72,6.72,1.42,13.42c0,.21.36.22.34,0l-1.41-13.42C348.19,223.26,347.82,223.26,347.84,223.48Z"/>
                                                    </g>
                                                    <path class="cls-35" d="M394.75,310.27v2.49a.15.15,0,0,0,.14.15.15.15,0,0,0,.15-.15v-2.49a.15.15,0,0,0-.15-.14A.14.14,0,0,0,394.75,310.27Z"/>
                                                    <path class="cls-35" d="M394.75,298.1v9.48a.15.15,0,0,0,.14.15.15.15,0,0,0,.15-.15V298.1a.15.15,0,0,0-.15-.15A.15.15,0,0,0,394.75,298.1Z"/>
                                                    <g class="cls-26">
                                                        <path class="cls-4" d="M394.75,310.27v2.49a.15.15,0,0,0,.14.15.15.15,0,0,0,.15-.15v-2.49a.15.15,0,0,0-.15-.14A.14.14,0,0,0,394.75,310.27Z"/>
                                                    </g>
                                                    <g class="cls-26">
                                                        <path class="cls-4" d="M394.75,298.1v9.48a.15.15,0,0,0,.14.15.15.15,0,0,0,.15-.15V298.1a.15.15,0,0,0-.15-.15A.15.15,0,0,0,394.75,298.1Z"/>
                                                    </g>
                                                    <path class="cls-17" d="M317.81,254.78H274.06a13.13,13.13,0,0,0,13.13,13.13h43.74A13.12,13.12,0,0,1,317.81,254.78Z"/>
                                                    <g class="cls-26">
                                                        <path class="cls-4" d="M318.18,254.78H274.44a13.12,13.12,0,0,0,13.12,13.13H331.3A13.12,13.12,0,0,1,318.18,254.78Z"/>
                                                    </g>
                                                </g>
                                                <g id="Character_m">
                                                    <path class="cls-35" d="M424.45,208.66l-5.06.17a.69.69,0,0,1-.76-.62.38.38,0,0,1,0-.15l.8-11.3a.9.9,0,0,1,.84-.82l5.07-.17a.69.69,0,0,1,.76.62.38.38,0,0,1,0,.15l-.81,11.3A.89.89,0,0,1,424.45,208.66Z"/>
                                                    <path class="cls-2" d="M425.38,208.63l-5.06.17a.69.69,0,0,1-.76-.62.38.38,0,0,1,0-.15l.81-11.3a.9.9,0,0,1,.84-.82l5.06-.17a.69.69,0,0,1,.76.62.38.38,0,0,1,0,.15l-.8,11.3A.89.89,0,0,1,425.38,208.63Z"/>
                                                    <path class="cls-36" d="M419.59,208l.81-11.3a.9.9,0,0,1,.84-.82h-.95a.92.92,0,0,0-.85.82l-.8,11.3a.7.7,0,0,0,.62.77h1.09a.69.69,0,0,1-.76-.62A.38.38,0,0,1,419.59,208Z"/>
                                                    <path class="cls-28" d="M418.23,208l.8-11.3a.91.91,0,0,1,.85-.82h-.95a.9.9,0,0,0-.85.82l-.8,11.3a.7.7,0,0,0,.62.77H419a.69.69,0,0,1-.76-.62A.38.38,0,0,1,418.23,208Z"/>
                                                    <path class="cls-17" d="M422.53,197.22a.76.76,0,0,1-.76.72.61.61,0,0,1-.64-.58.27.27,0,0,1,0-.09.77.77,0,0,1,.76-.72.62.62,0,0,1,.64.59A.11.11,0,0,1,422.53,197.22Z"/>
                                                    <polygon class="cls-37" points="421.78 326.54 424.06 333.9 430.82 332.65 428.93 324.46 421.78 326.54"/>
                                                    <polygon class="cls-38" points="423.13 330.9 430.02 329.23 429.49 326.91 422.59 329.19 423.13 330.9"/>
                                                    <path class="cls-17" d="M432.49,332.7a.17.17,0,0,1-.18-.11.17.17,0,0,1,0-.21c.1-.09,2.44-2.28,3.82-2.22a1,1,0,0,1,.68.29.71.71,0,0,1,.19.77c-.22.49-1.16.9-2.12,1.13A13.31,13.31,0,0,1,432.49,332.7Zm.53-.38c1.48-.16,3.43-.63,3.67-1.22,0-.07.06-.2-.13-.39a.52.52,0,0,0-.42-.17.89.89,0,0,0-.36,0,8.69,8.69,0,0,0-2.76,1.75Z"/>
                                                    <path class="cls-17" d="M432.39,332.72a.19.19,0,0,1-.12-.14c0-.1-.3-2.24.49-3.28a1.43,1.43,0,0,1,.95-.55c.52-.07.76.15.8.35.38.84-1.09,2.95-1.91,3.57h-.08A.17.17,0,0,1,432.39,332.72Zm1.28-3.59a1,1,0,0,0-.58.37,4.4,4.4,0,0,0-.46,2.62c.82-.77,1.73-2.4,1.52-2.91,0,0-.07-.17-.41-.12l-.1,0Z"/>
                                                    <path class="cls-39" d="M431.44,331.81l-8.43,2a.7.7,0,0,0-.53.69l.09,7.23a1.17,1.17,0,0,0,1.17,1.15H424c3-.77,5.69-1.58,9.48-2.47,4.47-1,3.46-.25,8.73-1.42,3.17-.7,2.9-4.44,1.52-4.29-6.31.68-7.39-1-10.28-2.66A2.75,2.75,0,0,0,431.44,331.81Z"/><polygon class="cls-37" points="454.54 315.81 458.04 322.66 464.49 320.28 461.23 312.53 454.54 315.81"/>
                                                    <polygon class="cls-38" points="456.62 319.87 463.13 317.05 462.21 314.85 455.8 318.27 456.62 319.87"/>
                                                    <path class="cls-17" d="M466.15,320.05a.18.18,0,0,1-.2-.09.2.2,0,0,1,0-.21c.09-.11,2-2.66,3.37-2.84a1,1,0,0,1,.72.17.7.7,0,0,1,.33.76c-.13.52-1,1.09-1.91,1.47A14.13,14.13,0,0,1,466.15,320.05Zm.46-.48c1.43-.41,3.27-1.21,3.4-1.83a.42.42,0,0,0-.2-.36.49.49,0,0,0-.44-.09,1,1,0,0,0-.34.09A8.89,8.89,0,0,0,466.61,319.57Z"/>
                                                    <path class="cls-17" d="M466.05,320.08a.21.21,0,0,1-.14-.12c0-.1-.67-2.16-.07-3.32a1.42,1.42,0,0,1,.83-.71c.5-.15.76,0,.86.22.5.76-.58,3.05-1.29,3.81a.06.06,0,0,1-.06,0A.22.22,0,0,1,466.05,320.08Zm.65-3.76a.92.92,0,0,0-.5.47,4.29,4.29,0,0,0,0,2.65c.67-.93,1.3-2.65,1-3.13,0,0-.11-.15-.43-.05l-.09.06Z"/>
                                                    <path class="cls-40" d="M465,319.36l-8,3.4a.71.71,0,0,0-.41.77l1.33,7.09a1.17,1.17,0,0,0,1.35.94l.23-.07c2.85-1.28,5.34-2.52,8.92-4.05,4.22-1.8,3.36-.84,8.35-2.89,3-1.24,2.11-4.87.77-4.5-6.11,1.75-7.47.26-10.59-.86A2.77,2.77,0,0,0,465,319.36Z"/>
                                                    <path class="cls-36" d="M392,253.18s38.79-3.5,47.95,5.34,23.74,55.21,23.74,55.21l-10.3,4.58S437.12,292.5,429.22,273c0,0-48.21,6.74-51.63-3.3l1.64-17.41Z"/><polygon class="cls-35" points="451.42 317.33 452.98 319.8 464.89 314.12 463.33 310.81 451.42 317.33"/>
                                                    <polygon class="cls-17" points="451.42 317.33 452.98 319.8 464.89 314.12 463.33 310.81 451.42 317.33"/>
                                                    <path class="cls-36" d="M362.49,252.36S360,273.09,368.9,276s35.55-.23,35.55-.23.05,21.5,16.15,53.25l9.52-3.33s-5.61-53.75-10.06-61C416.87,259.46,407.73,251.78,362.49,252.36Z"/>
                                                    <polygon class="cls-35" points="419.08 327.72 420.17 330.71 431.57 326.48 430.7 323.6 419.08 327.72"/>
                                                    <polygon class="cls-17" points="419.08 327.72 420.17 330.71 431.57 326.48 430.7 323.6 419.08 327.72"/>
                                                    <path class="cls-41" d="M421.63,263.08c-6.64-7.32-35.77-5.19-44.37-5.23v.07c19.12,2.2,39.21.24,42.8,6.75a40.37,40.37,0,0,1,2.76,9.16c1.17-.13,1.47-.25,2.36-.36C423.88,268,424.13,265.84,421.63,263.08Z"/>
                                                    <path class="cls-37" d="M387.92,203.14s4.82-.17,10.41,13.52L404.61,229s8.55-5.8,13.24-13.17c0,0,.71-13,5.3-12a5.76,5.76,0,0,1,4.59,6.73,5.83,5.83,0,0,1-.34,1.15,67,67,0,0,1-4.33,7s-11.14,19.19-18.35,19.42-14.32-13.77-14.32-13.77l-2.24-13.23Z"/>
                                                    <path class="cls-17" d="M388.83,202.89s5,1.07,9,11.74c0,0,1.47.32,1.37,2.43,0,0,2.44,8.58-4.42,14.94,0,0-1.44.08-2-2.29l-3.16-5.49-2.77-12.81-.15-4.69.23-4.11Z"/><path class="cls-42" d="M388.83,202.89s5,1.07,9,11.74c0,0,1.47.32,1.37,2.43,0,0,2.44,8.58-4.42,14.94,0,0-1.44.08-2-2.29l-3.16-5.49-2.77-12.81-.15-4.69.23-4.11Z"/><path class="cls-35" d="M416.42,217.49a13,13,0,0,1,4.19,3.2l1.37-1.44s-1.05-2.29-4.77-2.93Z"/>
                                                    <path class="cls-43" d="M416.42,217.49a13,13,0,0,1,4.19,3.2l1.37-1.44s-1.05-2.29-4.77-2.93Z"/>
                                                    <path class="cls-35" d="M422.92,221a1.59,1.59,0,1,1-.17-2.55A1.85,1.85,0,0,1,422.92,221Z"/>
                                                    <path class="cls-17" d="M422.62,220.79A1.23,1.23,0,1,1,421,218.9a1.22,1.22,0,0,1,1.46-.09A1.43,1.43,0,0,1,422.62,220.79Z"/>
                                                    <path class="cls-44" d="M388.79,220.73l.77,3.47,3.16,5.49c.58,2.39,2,2.29,2,2.29a15.34,15.34,0,0,0,3.1-4C395.45,224.05,391.08,221.7,388.79,220.73Z"/>
                                                    <path class="cls-45" d="M391.64,205c-1-1.41-3.17-2.92-6.39-4.05l-1.94,4.83L380.2,207l-2.48-.69-2.21-1.06-2.5-3.73-.34-2.22a58.71,58.71,0,0,0-9.26,1c-16.27,3.05-2.41,53.84-2.41,53.84,26.24,5.11,36.57-2,36.57-2C394.13,242.61,394.23,208.48,391.64,205Z"/>
                                                    <path class="cls-44" d="M364.94,207.55l-8.86,3.24a53.64,53.64,0,0,0-.46,10.89C367.61,219.7,364.94,207.55,364.94,207.55Z"/>
                                                    <path class="cls-17" d="M392.26,172.48s2.73,2.06,1.92,4.17c0,0,1.77,4.57-1.78,4.41C392.4,181.06,388.49,177.8,392.26,172.48Z"/>
                                                    <path class="cls-37" d="M381.29,206.14l2.22-2.23,1.68-3.06c-.53-.19-1.1-.36-1.7-.52l.51-7.2-8.43-4.93s.27,9.15-1.78,11c-.43.39-.41,0-1,0l1,3.82,3.15,3.92Z"/>
                                                    <path class="cls-35" d="M373.33,199s2.34,5.87,6,7.12c0,0-1.84,5.29-4.57,2.36s-3.06-9.43-3.06-9.43Z"/>
                                                    <path class="cls-24" d="M373.33,199s2.34,5.87,6,7.12c0,0-1.84,5.29-4.57,2.36s-3.06-9.43-3.06-9.43Z"/>
                                                    <path class="cls-35" d="M378.55,206.44s4.09-.83,5.73-6l1.82.76s-.72,8.1-3.59,8A4.69,4.69,0,0,1,378.55,206.44Z"/>
                                                    <path class="cls-24" d="M378.55,206.44s4.09-.83,5.73-6l1.82.76s-.72,8.1-3.59,8A4.69,4.69,0,0,1,378.55,206.44Z"/>
                                                    <path class="cls-38" d="M375.52,188.89s.18,6.57,8.16,8.84l.26-3.76-8.39-5.08Z"/>
                                                    <path class="cls-37" d="M393.33,181.56c.89,7.47-1.14,13.84-7.32,14.58s-11.06-4.06-11.95-11.53,1.05-14.59,7.23-15.33S392.45,174.1,393.33,181.56Z"/>
                                                    <path class="cls-17" d="M375.62,183.66a13.71,13.71,0,0,0,2.13-7.07s2.45-.29,3.05-1.61c0,0,7.63,3.21,11,.6,0,0,6.86-2.15,1.92-6,0,0,1-3-3.15-4.41s-6.56-.28-6.56-.28-3.46-2.36-7.36,1.07c0,0-6.87.72-5.76,5.46,0,0-3.82,1.12-2.29,4.67a3.85,3.85,0,0,0,.41,4.92s0,5.84,3.76,6.07C372.76,187.13,376.21,192.83,375.62,183.66Z"/>
                                                    <path class="cls-37" d="M376.56,183.48c.87,1.38.76,3.05-.21,3.64s-2.5,0-3.38-1.36-.76-3,.21-3.64S375.68,182.1,376.56,183.48Z"/>
                                                    <path class="cls-17" d="M371.8,167.68c.21-.17,0-.52-.21-.35a3.21,3.21,0,0,0-1.37,3.43,2.71,2.71,0,0,0-2.7.05c-.21.14,0,.49.22.35a2.22,2.22,0,0,1,2.19-.08,3.54,3.54,0,0,0-2.4,2.1c-.12.24.24.44.36.2.59-1.18,1.8-2.48,3-1.58l.29.26a.21.21,0,0,0,.29-.31l-.31-.27C370,170.27,370.51,168.73,371.8,167.68Z"/>
                                                    <path class="cls-17" d="M385.17,183.7c.08.48.4.83.72.77s.5-.47.42-.95-.4-.84-.76-.76S385.09,183.22,385.17,183.7Z"/>
                                                    <path class="cls-17" d="M390.64,183.73c.08.48.4.84.72.77s.5-.47.42-1-.4-.83-.72-.76S390.56,183.25,390.64,183.73Z"/>
                                                    <path class="cls-46" d="M388.94,184.21a18.47,18.47,0,0,0,3,3.81,2.78,2.78,0,0,1-2.23.76Z"/><path class="cls-17" d="M388,191.08a4.19,4.19,0,0,1-3.05-1.21.18.18,0,0,1,0-.2.17.17,0,0,1,.21,0h0a4,4,0,0,0,3.38,1.08.13.13,0,0,1,.18.09.13.13,0,0,1-.08.18h-.06A2.78,2.78,0,0,1,388,191.08Z"/>
                                                    <path class="cls-17" d="M384.06,181.44l-.13-.07A.29.29,0,0,1,384,181h0a2.78,2.78,0,0,1,2.59-.35.28.28,0,0,1,.15.36h0a.28.28,0,0,1-.37.16h0a2.18,2.18,0,0,0-2,.26A.26.26,0,0,1,384.06,181.44Z"/>
                                                    <path class="cls-17" d="M392.52,181.31a.26.26,0,0,0,.11-.07.29.29,0,0,0-.1-.39h0a2.75,2.75,0,0,0-2.6-.1.28.28,0,0,0-.13.37h0a.29.29,0,0,0,.38.12h0a2.21,2.21,0,0,1,2,.07A.29.29,0,0,0,392.52,181.31Z"/>
                                                    <path class="cls-37" d="M362.56,201.71s-21.68-1.93-35.55,5.1c0,0-2.24,4.45.27,8s11,17.92,11,17.92l1.17,6.87s-.54,4.09,1.52,5.45,7.22-1.19,7.52-3.41-4.42-11.3-4.42-11.3-5-14.64-7-18.06c0,0,19.12,1.93,25.83-.13C362.91,212.18,366.64,208.67,362.56,201.71Z"/>
                                                    <path class="cls-47" d="M362.8,200.88a53.89,53.89,0,0,0-10.68-.06s-.77-.87-2.6.49a24,24,0,0,1-.15,11.9,4,4,0,0,0,2.79.18s7.86,2.29,11.56-.22C366.26,211.45,369.06,207.12,362.8,200.88Z"/>
                                                </g>
                                            </g>
                                            </g>
                                            </svg>
                                        </div> 
                                    </div>
                                </div>
                                <div class="mt-5 text-end">
                                    <img src="{{ asset('assets/front/images/features_landing_pages/celebration.svg') }}" style="max-width: 50px;">
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
                            <div class="row justify-content-center align-items-center my-5">
                               <div class="col-lg-9 col-md-12 col-sm-12">
                                    <div class="text-center align-middle">
                                        <h1 class="font-700 color-text-gradient">Do you wish your customer personally on their birthday through your brand?</h1>
                                        <div class="text-center">
                                            <!-- <img src="{{ asset('assets/front/images/features_landing_pages/personalisedwish_do_you_wish.svg') }}" style="max-width: 300px;"> -->
                                                <svg version="1.1" id="Layer_1" style="max-width: 400px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                     viewBox="0 0 352.4 408.1" style="enable-background:new 0 0 352.4 408.1;" xml:space="preserve">
                                                <style type="text/css">
                                                    .mob_phone{
                                                        animation: 1s 1 forwards cubic-bezier(.36,-0.01,.5,1.38) slide_right, 3s Infinite linear up_down;
                                                        animation-delay: 0.6s, 1.6s;
                                                        opacity:0;
                                                        transform-origin: right;
                                                    }
                                                    @keyframes slide_right {
                                                      0% {opacity: 0.5;transform: translateX(100px);}
                                                      100% {opacity: 1;transform: translateX(0px);}
                                                    }
                                                    @-webkit-keyframes slide_right {
                                                      0% {opacity: 0.5;transform: translateX(100px);}
                                                      100% {opacity: 1;transform: translateX(0px);}
                                                    }
                                                    @keyframes up_down {
                                                      0% {transform: translateY(0px);}
                                                      50% {transform: translateY(8px);}
                                                      100% {transform: translateY(0px);}
                                                    }
                                                    @-webkit-keyframes up_down {
                                                      0% {transform: translateY(0px);}
                                                      50% {transform: translateY(8px);}
                                                      100% {transform: translateY(0px);}
                                                    }
                                                    .wish_msg1{
                                                        animation: 1s 1 forwards opacity_msg;
                                                        animation-delay:1.5s;
                                                        opacity: 0;
                                                        transform: translateX(10px);
                                                    }
                                                    @keyframes opacity_msg {
                                                      0% {opacity: 0;}
                                                      100% {opacity: 1;}
                                                    }
                                                    @-webkit-keyframes opacity_msg {
                                                      0% {opacity: 0;}
                                                      100% {opacity: 1;}
                                                    }
                                                    .opacity_line{
                                                            animation: 1s 1 forwards Line_op;
                                                            animation-delay:0.8s;
                                                            opacity:0;
                                                        }
                                                        @keyframes Line_op {
                                                          0% {opacity:0;}
                                                          50% {opacity:0.5;}
                                                          100% {opacity:1;}
                                                        }
                                                        @-webkit-keyframes Line_op {
                                                          0% {opacity:0;}
                                                          50% {opacity:0.5;}
                                                          100% {opacity:1;}
                                                        }
                                                    }


                                                    .st0{fill:#263238;stroke:#263238;stroke-miterlimit:10;}
                                                    .st1{opacity:0.36;fill:url(#SVGID_1_);enable-background:new    ;}
                                                    .st2{opacity:0.2;fill:#FFFFFF;enable-background:new    ;}
                                                    .st3{fill:none;stroke:#263238;stroke-width:0.5;stroke-linecap:round;stroke-linejoin:round;}
                                                    .st4{fill:none;stroke:#263238;stroke-width:0.25;stroke-linecap:round;stroke-linejoin:round;stroke-dasharray:1.98,1.98;}
                                                    .st5{fill:#263238;}
                                                    .st6{fill:#FFFFFF;}
                                                    .st7{fill:#868889;}
                                                    .st8{fill:none;stroke:#FFFFFF;stroke-width:0.5;stroke-linecap:round;stroke-linejoin:round;}
                                                    .st9{fill:url(#SVGID_00000016049177213822800700000006252141592353062324_);}
                                                    .st10{fill:#FFBE9D;}
                                                    .st11{fill:#263238;stroke:#263238;stroke-width:0.75;stroke-linecap:round;stroke-linejoin:round;}
                                                    .st12{fill:#FFFFFF;stroke:#263238;stroke-width:0.75;stroke-linecap:round;stroke-linejoin:round;}
                                                    .st13{fill:none;stroke:#263238;stroke-width:0.25;stroke-linecap:round;stroke-linejoin:round;}
                                                    .st14{fill:url(#SVGID_00000170262221804052257320000016124868850384789180_);}
                                                    .st15{fill:url(#SVGID_00000107573270046552998160000014035681264167343749_);}
                                                    .st16{fill:#FFFFFF;stroke:#263238;stroke-linecap:round;stroke-linejoin:round;}
                                                    .st17{fill:url(#SVGID_00000148626650463270700740000016038102563152725427_);}
                                                    .st18{clip-path:url(#SVGID_00000012443342748309844570000012192886375729620657_);}
                                                    .st19{fill:none;}
                                                    .st20{fill:url(#SVGID_00000003094799361919155690000009886586218240233125_);}
                                                    .st21{fill:none;stroke:url(#SVGID_00000029038980095140395620000011040194581710632323_);stroke-miterlimit:10;}
                                                    .st22{fill:none;stroke:url(#SVGID_00000165914423024356553500000016056714702146989952_);stroke-miterlimit:10;}
                                                    .st23{fill:none;stroke:url(#SVGID_00000078756128920431013520000002686453895508395959_);stroke-miterlimit:10;}
                                                    .st24{fill:none;stroke:url(#SVGID_00000042711052924946048810000012870180076309254792_);stroke-miterlimit:10;}
                                                    .st25{fill:url(#SVGID_00000160909653594542704710000017674720973307421083_);}
                                                    .st26{fill:url(#SVGID_00000003084072427775806740000006587671445012768130_);}
                                                    .st27{fill:url(#SVGID_00000118362052143317670960000004622646973973581752_);}
                                                    .st28{fill:url(#SVGID_00000011015422355600532620000016909905801891182260_);}
                                                    .st29{fill:url(#SVGID_00000056391168789101318430000012848495675670985356_);}
                                                    .st30{fill:url(#SVGID_00000048500859814922246030000009271776392259060110_);}
                                                    .st31{fill:none;stroke:#FFFFFF;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;}
                                                    .st32{fill:url(#SVGID_00000175292803343359458390000015488230916982274480_);}
                                                    .st33{fill:#FFFFFF;stroke:#263238;stroke-width:0.25;stroke-linecap:round;stroke-linejoin:round;}
                                                    .st34{fill:url(#SVGID_00000036945584430130709950000007904707207008452241_);}
                                                    .st35{clip-path:url(#SVGID_00000040541098605069411830000013955666439083640764_);}
                                                    .st36{fill:none;stroke:#263238;stroke-width:0.75;stroke-linecap:round;stroke-linejoin:round;}
                                                </style>
                                                <g>
                                                    <g class="mob_phone">
                                                        <path class="st0" d="M305.4,340.6h-52c-5.9-0.7-11.1-4-14.2-9l-35.3-61.3l-18.6-32.2l-14.2-25.1c-2.8-5-5.9-11.5,2.5-11.1H229
                                                        c0.6,0,1.2,0.3,2.2,0.3c3.8,0,7.4,1.9,9.6,5c1.8,2.2,3.4,4.6,4.6,7.1L311,328.8C313.8,333.5,310.7,340.6,305.4,340.6z"/>
                                                    
                                                        <linearGradient id="SVGID_1_" gradientUnits="userSpaceOnUse" x1="177.6026" y1="432.4568" x2="308.3253" y2="432.4568" gradientTransform="matrix(1 0 0 1 0 -164.47)">
                                                        <stop  offset="0" style="stop-color:#00FFAF"/>
                                                        <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                        <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                        <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                        <stop  offset="0.75" style="stop-color:#00469F"/>
                                                        <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                        <stop  offset="1" style="stop-color:#00249C"/>
                                                    </linearGradient>
                                                        <path class="st1" d="M303.3,332.2h-45.2c-5.8-0.5-11-3.9-13.9-9l-63.7-110.5c-5.6-8.3-1.2-9,3.7-9h45.2c7.7,0,10.2,2.8,13.9,9
                                                        L307,323.2C309.8,328.2,308.2,332.2,303.3,332.2z"/>
                                                        <polygon class="st2" points="234.1,203.3 230.1,221.6 230,221.8 225,213.3 225.1,213 227.6,203.3  "/>
                                                        <path class="st6" d="M229.5,203.3c0.2,0.2,0,0.5-0.2,0.5c-0.3,0-0.6-0.2-0.7-0.5c-0.2-0.2,0-0.5,0.2-0.5
                                                        C229,202.9,229.3,203,229.5,203.3z"/>
                                                        <path class="st6" d="M233.7,203.9h-2.6c-0.2,0-0.5-0.2-0.6-0.4v-0.1c0-0.2,0-0.4,0.2-0.4h2.6c0.3,0,0.5,0.2,0.7,0.4v0.1
                                                        C234,203.7,233.9,203.9,233.7,203.9z"/>
                                                        <path class="st5" d="M235.7,204.5h-5.8c-1.2-0.1-2.2-0.7-2.8-1.7l-0.2-0.2h9.4l0.2,0.2C237,203.6,236.7,204.5,235.7,204.5z"/>
                                                        <polygon class="st2" points="283.2,279.3 291.2,293.2 284.1,322.9 283.2,326.6 271.1,326.6 272,322.9  "/>
                                                    </g>
                                                    
                                                    
                                                    <line class="st3 opacity_line" x1="226.7" y1="194.7" x2="220.1" y2="177.5"/>
                                                    <line class="st3 opacity_line" x1="266.4" y1="198.1" x2="251.1" y2="203.9"/>
                                                    <line class="st3 opacity_line" x1="255.6" y1="183.1" x2="244.6" y2="196.6"/>
                                                    <line class="st3 opacity_line" x1="238.6" y1="175.5" x2="235.7" y2="193.4"/>
                                                    <line class="st4 opacity_line" x1="166.4" y1="193.7" x2="170" y2="199.5"/>
                                                    <line class="st4 opacity_line" x1="189.2" y1="154.5" x2="189.2" y2="194.5"/>
                                                    <line class="st4 opacity_line" x1="159.9" y1="239.1" x2="179.6" y2="238.6"/>

                                                    <g class="wish_msg1">
                                                        <path class="st7" d="M145.8,202.7h-105c-4.8,0-8.7,3.9-8.7,8.7c0,0,0,0.1,0,0.1l0,0v27.2c0,4.8,3.9,8.7,8.7,8.7h93.2
                                                        c5.8,0,11.5-1.8,16.3-5.2c1.7-1.2,3.4-2.4,5.2-3.5l8.2-5l-9-4.9v-17.3C154.6,206.6,150.7,202.6,145.8,202.7z"/>
                                                        <line class="st8" x1="68.7" y1="217.5" x2="89" y2="217.5"/>
                                                        <line class="st8" x1="68.7" y1="226.4" x2="111.5" y2="226.4"/>
                                                        <line class="st8" x1="68.7" y1="232.5" x2="111.5" y2="232.5"/>
                                                    
                                                        <linearGradient id="SVGID_00000014592016489222419190000016128602591584764049_" gradientUnits="userSpaceOnUse" x1="17.0721" y1="389.6523" x2="63.8247" y2="389.6523" gradientTransform="matrix(1 0 0 1 0 -164.47)">
                                                        <stop  offset="0" style="stop-color:#00FFAF"/>
                                                        <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                        <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                        <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                        <stop  offset="0.75" style="stop-color:#00469F"/>
                                                        <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                        <stop  offset="1" style="stop-color:#00249C"/>
                                                        </linearGradient>
                                                        <path style="fill:url(#SVGID_00000014592016489222419190000016128602591584764049_);" d="M63.8,225.2c0,10.4-6.9,19.5-16.8,22.4
                                                            c-0.6,0.2-1.1,0.3-1.7,0.4c-1.6,0.3-3.2,0.5-4.9,0.5c-3,0-5.9-0.6-8.7-1.7c-0.3,0-0.6-0.2-0.9-0.3c-11.8-5.3-16.9-19.2-11.6-31
                                                            s19.2-16.9,31-11.6C58.4,207.7,63.8,216,63.8,225.2L63.8,225.2z"/>
                                                        <path class="st10" d="M47,247.7c-0.6,0.2-1.1,0.3-1.7,0.4c-1.6,0.3-3.2,0.5-4.9,0.5c-3,0-5.9-0.6-8.7-1.7l-0.2-0.5
                                                            c1-1.5,1.6-3.2,1.9-5c0.5-3,0.6-6.2,0.3-9.2l11.2,1.9C45.3,238.7,46,243.2,47,247.7z"/>
                                                        <path class="st11" d="M46,241.5L46,241.5c-0.2,1.2-1.4,2-2.6,1.7c0,0,0,0,0,0c0,0-0.2,0-0.2,0c-1.7-0.6-3.3-1.4-4.7-2.5
                                                            c-4.4-3.5-4.4-10.1-4.4-10.1S43.3,238,46,241.5z"/>
                                                        <path class="st11" d="M36.7,237l-9.6-15.6c0,0-5-2.1-2.3-4.8c0,0-4.3-7.5,1.3-7.5c0,0,0.7-6.1,6.2-3.6c0,0,4.7-5.6,7.8-1.6
                                                            c0,0,6.5-3.1,8.2,0.8c0,0,4.7,0,4.5,3.6c0,0,3,4-0.9,4.5c0,0,1.1,3.1-3.6,3.1S38,221.7,38,221.7l-1.2,5.8L36.7,237z"/>
                                                        <path class="st12" d="M50.9,214.3l1.8,5.6c0.2,0.6,0.3,1.3,0.2,1.9l-0.2,1.7l0.9,3.7c0.1,0.2,0.1,0.4,0.1,0.6
                                                            c0.2,1.9,1,12.4-4.5,13.7c-4.9,1.2-10.8-4.1-13-6.3c-0.5-0.5-0.9-1.1-1.2-1.8l-1.2-2.8c-1.5,0.2-2.9-0.6-3.6-1.9
                                                            c-1.2-2.2-2.6-3.5-0.4-5.1c2.2-1.6,3.6,1.7,3.6,1.7c-0.1-1.7,0.1-3.5,0.4-5.2c0.5-1.1,2.3-2.6,2.8-3.6c0.2-0.8,0.4-1.6,0.5-2.5
                                                            c4.3,0.1,8.7-0.6,12.8-1.8L50.9,214.3z"/>
                                                        <path class="st10" d="M50.9,214.3l1.8,5.6c0.2,0.6,0.3,1.3,0.2,1.9l-0.2,1.7l0.9,3.7c0.1,0.2,0.1,0.4,0.1,0.6
                                                            c0.2,1.9,1,12.4-4.5,13.7c-4.9,1.2-10.8-4.1-13-6.3c-0.5-0.5-0.9-1.1-1.2-1.8l-1.2-2.8c-1.5,0.2-2.9-0.6-3.6-1.9
                                                            c-1.2-2.2-2.6-3.5-0.4-5.1c2.2-1.6,3.6,1.7,3.6,1.7c-0.1-1.7,0.1-3.5,0.4-5.2c0.5-1.1,2.3-2.6,2.8-3.6c0.2-0.8,0.4-1.6,0.5-2.5
                                                            c4.3,0.1,8.7-0.6,12.8-1.8L50.9,214.3z"/>
                                                        <path class="st13" d="M47.4,224.6l2.7,4.5c0.3,0.5,0.2,1.2-0.3,1.5c-0.1,0.1-0.2,0.1-0.3,0.2l-2.5,0.6"/>
                                                        <path class="st13" d="M48.1,236.4c-2.2,3-4.3-3.5-4.3-3.5c1.3,1.3,3.3,1.6,4.9,0.6C48.8,234.5,48.6,235.5,48.1,236.4z"/>
                                                        <path class="st5" d="M43.7,226.1c0.1,0.7,0.4,1.2,0.7,1.1c0.3-0.1,0.5-0.7,0.4-1.3c-0.1-0.7-0.4-1.2-0.7-1.1
                                                            C43.8,224.9,43.6,225.5,43.7,226.1z"/>
                                                        <path class="st5" d="M49.8,225.1c0,0.7,0.4,1.2,0.7,1.1c0.3-0.1,0.5-0.7,0.4-1.3s-0.4-1.2-0.7-1.1
                                                            C49.9,223.9,49.7,224.6,49.8,225.1z"/>
                                                        <path class="st13" d="M52.4,221.1c-0.3-1-1.4-1.6-2.4-1.3c-0.2,0-0.2,0-0.4,0.2"/>
                                                        <path class="st13" d="M45,220.4c-1.4,0-2.7,0.9-3.2,2.2"/>
                                                        <path class="st11" d="M34.8,213.8c0,0,6.2,4.5,6.9,1.2c0,0,5.1,1.2,5.4-0.5c0,0,5.1,2.1,5.8,0.5c0.6-1.6-4.1-5.8-4.1-5.8L38,210.7
                                                            L34.8,213.8z"/>
                                                        
                                                            <linearGradient id="SVGID_00000026160310411151832820000018011697010798554805_" gradientUnits="userSpaceOnUse" x1="122.5655" y1="394.71" x2="145.632" y2="394.71" gradientTransform="matrix(1 0 0 1 0 -164.47)">
                                                                <stop  offset="0" style="stop-color:#00FFAF"/>
                                                                <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                                <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                                <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                                <stop  offset="0.75" style="stop-color:#00469F"/>
                                                                <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                                <stop  offset="1" style="stop-color:#00249C"/>
                                                            </linearGradient>
                                                        
                                                            <rect x="122.6" y="221.1" style="fill:url(#SVGID_00000026160310411151832820000018011697010798554805_);" width="23.1" height="18.3"/>
                                                        <polygon class="st6" points="135.3,221.1 124.7,239.3 122.6,239.3 122.6,239 132.9,221.1  "/>
                                                        <polygon class="st6" points="144.4,221.1 133.7,239.3 131.4,239.3 142,221.1  "/>
                                                        <polygon class="st6" points="145.6,230.5 145.6,234.5 142.8,239.3 140.4,239.3    "/>
                                                        <polygon class="st6" points="122.6,229.5 122.6,225.4 125.4,220.6 127.8,220.6    "/>
                                                        
                                                            <linearGradient id="SVGID_00000181775629703359819590000012190190085455990178_" gradientUnits="userSpaceOnUse" x1="122.9301" y1="380.7582" x2="145.5744" y2="380.7582" gradientTransform="matrix(1 0 0 1 0 -164.47)">
                                                            <stop  offset="0" style="stop-color:#00FFAF"/>
                                                            <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                            <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                            <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                            <stop  offset="0.75" style="stop-color:#00469F"/>
                                                            <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                            <stop  offset="1" style="stop-color:#00249C"/>
                                                        </linearGradient>
                                                        <path style="fill:url(#SVGID_00000181775629703359819590000012190190085455990178_);" d="M144.4,216.6c-2,2.1-4.7,3.2-7.6,3.1
                                                            c4.5-1,9.3-6.3,4.5-8.3c-4.8-2.1-7.2,8.3-7.2,8.3s-3.6-11.3-7.4-7.4c-3.9,3.9,4.7,7.7,4.7,7.7c-2.7,0.2-7.3-2.9-7.3-2.9L123,219
                                                            c4.2,3.2,11.1,2.1,11.1,2.1c5.8,1.5,11.5-2.6,11.5-2.6L144.4,216.6z M128,213.7c1.5-1,3.8,4.5,3.8,4.5S126.5,214.7,128,213.7z
                                                             M136.1,218.2c0,0,1.9-5.9,4.3-4.9C142.7,214.4,136.1,218.2,136.1,218.2z"/>
                                                        <ellipse class="st16" cx="134" cy="219.6" rx="1.6" ry="1.3"/>

                                                    </g>
                                                    <g class="wish_msg1" style="animation-delay:1.8s;">
                                                        <path class="st7" d="M158.2,135.9H44c-4.8,0-8.7,3.9-8.7,8.7l0,0v27.1c0,4.8,3.8,8.7,8.7,8.8h112.6l10.3,10.9v-46.8
                                                        C166.8,139.7,162.9,135.9,158.2,135.9z"/>
                                                        <line class="st8" x1="78.2" y1="149.3" x2="103.5" y2="149.3"/>
                                                        <line class="st8" x1="78.2" y1="158.2" x2="119.4" y2="158.2"/>
                                                        <line class="st8" x1="78.2" y1="165.5" x2="118.7" y2="165.5"/>
                                                    
                                                        <linearGradient id="SVGID_00000126286341775787076050000006965410915860314545_" gradientUnits="userSpaceOnUse" x1="25.08" y1="322.6032" x2="71.8271" y2="322.6032" gradientTransform="matrix(1 0 0 1 0 -164.47)">
                                                            <stop  offset="0" style="stop-color:#00FFAF"/>
                                                            <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                            <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                            <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                            <stop  offset="0.75" style="stop-color:#00469F"/>
                                                            <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                            <stop  offset="1" style="stop-color:#00249C"/>
                                                        </linearGradient>
                                                        <path style="fill:url(#SVGID_00000126286341775787076050000006965410915860314545_);" d="M71.8,158.2c0,12.9-10.5,23.4-23.4,23.4
                                                        S25.1,171,25.1,158.1c0-12.9,10.4-23.3,23.3-23.4c12.9-0.1,23.4,10.3,23.4,23.2C71.8,158,71.8,158.1,71.8,158.2z"/>
                                                        <path class="st11" d="M61,159.3c-0.3,9-6.8,19-10.7,20.1c-3.9,1.1-12.1-5.2-13.1-5.9l0,0l0,0H37c-2.6,0.1-5.2-0.5-7.6-1.7
                                                        c-3.7-5.2-5.1-11.7-4-18c2.1-4.8,5.5-8.9,9.8-11.9c9.2-6.1,18.6,1,18.6,1C64.2,143.6,61.3,150.2,61,159.3z"/>
                                                        <path class="st10" d="M44.4,174.6c-1.4,1.8-2.2,3.9-2.3,6.1l0,0c-1-0.3-2.1-0.7-3.1-1.1c-2.9-1.2-5.6-3.1-7.7-5.4l0,0
                                                        c2.4-3.6,4-7.7,4.6-12C37.3,154.9,44.4,174.6,44.4,174.6z"/>
                                                        <g>
                                                            <defs>
                                                                <path id="SVGID_00000041254596265913424610000008629831646891963027_" d="M44.4,174.6c-1.4,1.8-2.2,3.9-2.3,6.1l0,0
                                                                c-1-0.3-2.1-0.7-3.1-1.1c-2.9-1.2-5.6-3.1-7.7-5.4l0,0c2.4-3.6,4-7.7,4.6-12C37.3,154.9,44.4,174.6,44.4,174.6z"/>
                                                            </defs>
                                                            <clipPath id="SVGID_00000044158814252015012140000015045793350496749459_">
                                                                <use xlink:href="#SVGID_00000041254596265913424610000008629831646891963027_"  style="overflow:visible;"/>
                                                            </clipPath>
                                                            <g style="clip-path:url(#SVGID_00000044158814252015012140000015045793350496749459_);">
                                                                <path class="st11" d="M35.8,165.5c0.2,3.7,1.2,5.3,4.3,8.4c3.6,3.6,5.9,6.5,11.1,0c2.2-2.4,3.8-5.3,4.9-8.4H35.8z"/>
                                                            </g>
                                                        </g>
                                                        <path class="st19" d="M44.4,174.6c-1.4,1.8-2.2,3.9-2.3,6.1l0,0c-1-0.3-2.1-0.7-3.1-1.1c-2.9-1.2-5.6-3.1-7.7-5.4l0,0
                                                            c2.4-3.6,4-7.7,4.6-12C37.3,154.9,44.4,174.6,44.4,174.6z"/>
                                                        <path class="st10" d="M57.9,155.6l-1.3,7.6c0,0,0.2,3-5,9.5s-7.6,3.6-11.1,0s-4.4-5.2-4.3-10.3c0,0-1.8-0.2-3-3.6s3-4.6,4-2.5
                                                            l6.2-3.1l3.8-4.6l2.2-3l4.5,1.7l4.8,2.9L57.9,155.6z"/>
                                                        <path class="st13" d="M52.3,163.3c-1,1-1.2,2.7-0.3,3.8c2.1,2.6-2.4,1.9-2.4,2.6"/>
                                                        <path class="st13" d="M44.3,168.3c1.3,0.8,2.5,1.7,3.7,2.7l0,0c-0.5,0.9-1.6,1.2-2.4,0.7c0,0,0,0,0,0c-0.3-0.2-0.5-0.4-0.7-0.7
                                                            C44.4,170.2,44.2,169.2,44.3,168.3z"/>
                                                        <path class="st5" d="M49.2,162.4c-0.2,0.7-0.7,1.1-1,1c-0.2-0.1-0.2-0.7,0-1.3c0.2-0.6,0.7-1.1,1-1
                                                            C49.6,161.1,49.5,161.7,49.2,162.4z"/>
                                                        <path class="st5" d="M54.9,164.6c-0.2,0.6-0.7,1-0.8,0.8c-0.2-0.4-0.2-0.8,0-1.2c0.2-0.6,0.7-1,0.8-0.8
                                                            C55.1,163.7,55.1,164.2,54.9,164.6z"/>
                                                        <path class="st13" d="M51.1,158.1c-1.2-0.9-2.9-0.9-4.1,0"/>
                                                        <path class="st13" d="M54.9,159.5c0.6,0.2,1.1,0.7,1.2,1.3"/>
                                                        <path class="st11" d="M37.5,153c0,0-2.7,6.8,1.1,9.8c0,0,3.1-8.8,9.5-9.8c3.2-0.3,6.3-1.3,9.1-3c0,0-0.7,8.7,1,10.9
                                                            s1.6-10.1,1.6-10.1l-1.7-4.2l-9.2-3.7l-7.9,3.7L37.5,153z"/>
                                                        <path class="st11" d="M35.8,163.4c0,0-2.2,9.1,0.7,9.9c2.9,0.8-3.2-0.6-6.9-2.2c-3.7-1.7,4.9-8.6,4.9-8.6L35.8,163.4z"/>
                                                        
                                                        <linearGradient id="SVGID_00000095334467409837773930000011039184247672502405_" gradientUnits="userSpaceOnUse" x1="125.9046" y1="330.1642" x2="143.2524" y2="330.1642" gradientTransform="matrix(1 0 0 1 0 -164.47)">
                                                            <stop  offset="0" style="stop-color:#00FFAF"/>
                                                            <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                            <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                            <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                            <stop  offset="0.75" style="stop-color:#00469F"/>
                                                            <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                            <stop  offset="1" style="stop-color:#00249C"/>
                                                        </linearGradient>
                                                        <polygon style="fill:url(#SVGID_00000095334467409837773930000011039184247672502405_);" points="128.4,174.4 125.9,171.8 
                                                            133.4,157 143.3,166.8   "/>
                                                        <path class="st11" d="M143.2,166.7c-0.7,0.7-3.3-1-5.9-3.7c-2.6-2.7-4.3-5.4-3.7-5.9c0.6-0.6,3.3,1,5.9,3.7
                                                            C142.1,163.5,143.8,166.1,143.2,166.7z"/>
                                                    
                                                        <linearGradient id="SVGID_00000106853592162041732930000006308710688977943975_" gradientUnits="userSpaceOnUse" x1="138.4506" y1="316.8017" x2="142.5809" y2="316.8017" gradientTransform="matrix(1 0 0 1 0 -164.47)">
                                                            <stop  offset="0" style="stop-color:#00FFAF"/>
                                                            <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                            <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                            <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                            <stop  offset="0.75" style="stop-color:#00469F"/>
                                                            <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                            <stop  offset="1" style="stop-color:#00249C"/>
                                                        </linearGradient>
                                                        <path style="fill:none;stroke:url(#SVGID_00000106853592162041732930000006308710688977943975_);stroke-miterlimit:10;" d="
                                                            M141.7,147.3c0.6,1.7,0.5,3.6-0.2,5.3c-0.7,1.7-1.6,3.2-2.6,4.7"/>
                                                    
                                                        <linearGradient id="SVGID_00000059286612188507548180000010756673790246312636_" gradientUnits="userSpaceOnUse" x1="142.9578" y1="325.4831" x2="153.87" y2="325.4831" gradientTransform="matrix(1 0 0 1 0 -164.47)">
                                                            <stop  offset="0" style="stop-color:#00FFAF"/>
                                                            <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                            <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                            <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                            <stop  offset="0.75" style="stop-color:#00469F"/>
                                                            <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                            <stop  offset="1" style="stop-color:#00249C"/>
                                                        </linearGradient>
                                                        <path style="fill:none;stroke:url(#SVGID_00000059286612188507548180000010756673790246312636_);stroke-miterlimit:10;" d="
                                                        M143.3,162.3c2.9-2.5,6.9-3.1,10.4-1.6"/>
                                                    
                                                        <linearGradient id="SVGID_00000083056414724832051780000006192663696088171680_" gradientUnits="userSpaceOnUse" x1="144.4369" y1="317.5802" x2="153.5521" y2="317.5802" gradientTransform="matrix(1 0 0 1 0 -164.47)">
                                                            <stop  offset="0" style="stop-color:#00FFAF"/>
                                                            <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                            <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                            <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                            <stop  offset="0.75" style="stop-color:#00469F"/>
                                                            <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                            <stop  offset="1" style="stop-color:#00249C"/>
                                                        </linearGradient>
                                                        <path style="fill:none;stroke:url(#SVGID_00000083056414724832051780000006192663696088171680_);stroke-miterlimit:10;" d="
                                                            M145.6,157.8c-0.3-0.9-0.6-1.9-0.7-2.9c-0.1-0.8,0.3-1.5,1-1.9c1.2-0.6,2.4,0.5,3.3,1.3c0.9,0.8,2.4,1.6,3.3,0.8
                                                            c0.9-0.8,0.4-2.2,0-3.3c-0.4-1.1-0.7-2.6,0.2-3.2"/>
                                                    
                                                        <linearGradient id="SVGID_00000173863788620523850990000003427014241161550737_" gradientUnits="userSpaceOnUse" x1="132.8488" y1="312.6783" x2="136.6887" y2="312.6783" gradientTransform="matrix(1 0 0 1 0 -164.47)">
                                                            <stop  offset="0" style="stop-color:#00FFAF"/>
                                                            <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                            <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                            <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                            <stop  offset="0.75" style="stop-color:#00469F"/>
                                                            <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                            <stop  offset="1" style="stop-color:#00249C"/>
                                                        </linearGradient>
                                                        <path style="fill:none;stroke:url(#SVGID_00000173863788620523850990000003427014241161550737_);stroke-miterlimit:10;" d="
                                                        M136.4,142.2l-0.3,0.2c-1.6,1-2.1,3-1.1,4.6c0,0,0,0,0,0c0.1,0.3,0.3,0.5,0.6,0.7l0,0c0.2,0.2,0.3,0.5,0.4,0.7
                                                        c0.3,1.2-0.5,1.9-1.2,2.6c-0.6,0.4-1.1,1-1.3,1.7c-0.2,0.7,0.6,1.7,1.3,1.3"/>
                                                    
                                                        <linearGradient id="SVGID_00000068642134474099586070000010706623363382390928_" gradientUnits="userSpaceOnUse" x1="147.6277" y1="309.5157" x2="150.4487" y2="309.5157" gradientTransform="matrix(1 0 0 1 0 -164.47)">
                                                            <stop  offset="0" style="stop-color:#00FFAF"/>
                                                            <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                            <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                            <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                            <stop  offset="0.75" style="stop-color:#00469F"/>
                                                            <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                            <stop  offset="1" style="stop-color:#00249C"/>
                                                        </linearGradient>
                                                    
                                                        <rect x="147.6" y="143.6" style="fill:url(#SVGID_00000068642134474099586070000010706623363382390928_);" width="2.8" height="2.8"/>
                                                    
                                                        <linearGradient id="SVGID_00000164494732449849354320000001426219133835241344_" gradientUnits="userSpaceOnUse" x1="149.9113" y1="331.8529" x2="152.7323" y2="331.8529" gradientTransform="matrix(1 0 0 1 0 -164.47)">
                                                            <stop  offset="0" style="stop-color:#00FFAF"/>
                                                            <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                            <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                            <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                            <stop  offset="0.75" style="stop-color:#00469F"/>
                                                            <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                            <stop  offset="1" style="stop-color:#00249C"/>
                                                        </linearGradient>
                                                    
                                                        <rect x="149.9" y="166" style="fill:url(#SVGID_00000164494732449849354320000001426219133835241344_);" width="2.8" height="2.8"/>
                                                    
                                                        <linearGradient id="SVGID_00000135668573688367200880000013006176048195698833_" gradientUnits="userSpaceOnUse" x1="156.7238" y1="319.4945" x2="159.5447" y2="319.4945" gradientTransform="matrix(1 0 0 1 0 -164.47)">
                                                            <stop  offset="0" style="stop-color:#00FFAF"/>
                                                            <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                            <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                            <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                            <stop  offset="0.75" style="stop-color:#00469F"/>
                                                            <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                            <stop  offset="1" style="stop-color:#00249C"/>
                                                        </linearGradient>
                                                    
                                                        <rect x="156.7" y="153.6" style="fill:url(#SVGID_00000135668573688367200880000013006176048195698833_);" width="2.8" height="2.8"/>
                                                    
                                                        <linearGradient id="SVGID_00000162321137521124534820000009012741565389447552_" gradientUnits="userSpaceOnUse" x1="129.9153" y1="312.5669" x2="132.717" y2="312.5669" gradientTransform="matrix(1 0 0 1 0 -164.47)">
                                                            <stop  offset="0" style="stop-color:#00FFAF"/>
                                                            <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                            <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                            <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                            <stop  offset="0.75" style="stop-color:#00469F"/>
                                                            <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                            <stop  offset="1" style="stop-color:#00249C"/>
                                                        </linearGradient>
                                                    
                                                        <rect x="129.9" y="146.7" style="fill:url(#SVGID_00000162321137521124534820000009012741565389447552_);" width="2.8" height="2.8"/>
                                                        <path class="st6" d="M138.5,169.2c-2.6-3.4-4.5-7.3-5.4-11.5v-0.1"/>
                                                        <path class="st6" d="M130.1,163.6c1,2.8,2.4,5.3,4.2,7.7"/>
                                                        <path class="st6" d="M130.2,173.5c-1.1-1.4-2-2.9-2.8-4.6"/>

                                                    </g>
                                                    <g class="wish_msg1" style="animation-delay:2s;">
                                                        <path class="st7" d="M189.2,104v46.8l10.3-10.9h112.5c4.8,0,8.7-3.9,8.7-8.7c0,0,0,0,0-0.1V104l0,0c0-4.8-3.9-8.7-8.7-8.7H197.9
                                                        C193.1,95.3,189.3,99.2,189.2,104z"/>
                                                    
                                                        <linearGradient id="SVGID_00000018952730263149122980000014936187577027489710_" gradientUnits="userSpaceOnUse" x1="208.441" y1="282.0835" x2="210.7822" y2="282.0835" gradientTransform="matrix(1 0 0 1 0 -164.47)">
                                                            <stop  offset="0" style="stop-color:#00FFAF"/>
                                                            <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                            <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                            <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                            <stop  offset="0.75" style="stop-color:#00469F"/>
                                                            <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                            <stop  offset="1" style="stop-color:#00249C"/>
                                                        </linearGradient>
                                                        <polygon style="fill:url(#SVGID_00000018952730263149122980000014936187577027489710_);" points="208.5,112.2 210.8,112.2 
                                                        210.7,123.1 208.4,123   "/>
                                                    
                                                        <linearGradient id="SVGID_00000010295702495364616690000017346417611097428902_" gradientUnits="userSpaceOnUse" x1="208.3472" y1="273.8414" x2="211.2641" y2="273.8414" gradientTransform="matrix(1 0 0 1 0 -164.47)">
                                                            <stop  offset="0" style="stop-color:#00FFAF"/>
                                                            <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                            <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                            <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                            <stop  offset="0.75" style="stop-color:#00469F"/>
                                                            <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                            <stop  offset="1" style="stop-color:#00249C"/>
                                                        </linearGradient>
                                                        <path style="fill:url(#SVGID_00000010295702495364616690000017346417611097428902_);" d="M209.7,106.5c0,0,3.5,4,0,5.8
                                                            C209.7,112.2,206.7,110.9,209.7,106.5z"/>
                                                        <path class="st31" d="M209.8,109.1c0,0,1.4,1.8-0.2,3.1C208.9,111.3,208.9,110,209.8,109.1C209.8,109.1,209.8,109.1,209.8,109.1z"
                                                            />
                                                    
                                                        <linearGradient id="SVGID_00000175323437926239324720000007541177718410966420_" gradientUnits="userSpaceOnUse" x1="198.8268" y1="290.0858" x2="220.6267" y2="290.0858" gradientTransform="matrix(1 0 0 1 0 -164.47)">
                                                            <stop  offset="0" style="stop-color:#00FFAF"/>
                                                            <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                            <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                            <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                            <stop  offset="0.75" style="stop-color:#00469F"/>
                                                            <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                            <stop  offset="1" style="stop-color:#00249C"/>
                                                        </linearGradient>
                                                        <polygon style="fill:url(#SVGID_00000175323437926239324720000007541177718410966420_);" points="198.9,117.6 220.6,117.8 
                                                        220.5,133.6 198.8,133.5     "/>
                                                        <path class="st12" d="M198.1,117.6v6.8c0.1,0.4,0.4,0.7,0.9,0.7c0,0,0,0,0,0h0.3l2.6-1.4c0.2-0.2,0.6-0.2,0.8,0l1.3,0.7
                                                        c1.3,0.7,2.9,0.7,4.2,0l1.6-0.8c0.2-0.2,0.6-0.2,0.8,0l0.9,0.6c1.4,0.9,3.1,0.9,4.5,0l0.6-0.4c0.3-0.2,0.6-0.2,0.9,0l2.6,1.4
                                                        c0.4,0.2,0.9,0.1,1.1-0.3c0,0,0,0,0,0c0-0.1,0-0.1,0-0.2v-6.9c0-0.4-0.4-0.7-0.7-0.7h-21.7C198.5,117,198.2,117.2,198.1,117.6z"/>
                                                        <path class="st33" d="M198.1,117.6v6.8c0.1,0.4,0.4,0.7,0.9,0.7c0,0,0,0,0,0h0.3l2.6-1.4c0.2-0.2,0.6-0.2,0.8,0l1.3,0.7
                                                        c1.3,0.7,2.9,0.7,4.2,0l1.6-0.8c0.2-0.2,0.6-0.2,0.8,0l0.9,0.6c1.4,0.9,3.1,0.9,4.5,0l0.6-0.4c0.3-0.2,0.6-0.2,0.9,0l2.6,1.4
                                                        c0.4,0.2,0.9,0.1,1.1-0.3c0,0,0,0,0,0c0-0.1,0-0.1,0-0.2v-6.9c0-0.4-0.4-0.7-0.7-0.7h-21.7C198.5,117,198.2,117.2,198.1,117.6z"/>
                                                        <line class="st8" x1="256.1" y1="109.8" x2="278.6" y2="109.8"/>
                                                        <line class="st8" x1="235.7" y1="117.7" x2="278.6" y2="117.7"/>
                                                        <line class="st8" x1="235.7" y1="124.1" x2="278.6" y2="124.1"/>
                                                    
                                                        <linearGradient id="SVGID_00000167387638119917231550000015528884554319350965_" gradientUnits="userSpaceOnUse" x1="288.8665" y1="282.4961" x2="334.2894" y2="282.4961" gradientTransform="matrix(1 0 0 1 0 -164.47)">
                                                            <stop  offset="0" style="stop-color:#00FFAF"/>
                                                            <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                            <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                            <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                            <stop  offset="0.75" style="stop-color:#00469F"/>
                                                            <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                            <stop  offset="1" style="stop-color:#00249C"/>
                                                        </linearGradient>
                                                        <circle style="fill:url(#SVGID_00000167387638119917231550000015528884554319350965_);" cx="311.6" cy="118" r="22.7"/>
                                                        <path class="st10" d="M312.6,140.4c2,0,3.9-0.4,5.8-1.1l-1.2-6.3l-9.8,0.6l-0.4,6.2C308.8,140.4,310.7,140.6,312.6,140.4z"/>
                                                        <g>
                                                            <defs>
                                                                <path id="SVGID_00000031189504948619879170000004196713958786720392_" d="M312.6,140.8c2.2,0,4.3-0.4,6.3-1.2l-1.4-6.9l-10.7,0.6
                                                                    l-0.4,6.8C308.5,140.7,310.6,141,312.6,140.8z"/>
                                                            </defs>
                                                            <clipPath id="SVGID_00000071541377102491407490000001795600438833635250_">
                                                                <use xlink:href="#SVGID_00000031189504948619879170000004196713958786720392_"  style="overflow:visible;"/>
                                                            </clipPath>
                                                            <g style="clip-path:url(#SVGID_00000071541377102491407490000001795600438833635250_);">
                                                                <path class="st11" d="M304.8,132.8c1.9,4.4,7,6.5,11.4,4.6c2.1-0.9,3.7-2.5,4.6-4.6H304.8z"/>
                                                            </g>
                                                            </g>
                                                        <path class="st13" d="M312.6,140.8c2,0,3.9-0.3,5.8-1.1l-1.2-6.3l-9.8,0.6l-0.3,6.2C308.8,140.7,310.7,140.9,312.6,140.8z"/>
                                                        <path class="st10" d="M324.3,120.8c-0.5-0.2-1-0.3-1.4-0.2c-0.3-8.2-5.4-14.7-11.6-14.7s-11.3,6.6-11.6,14.7
                                                            c-0.5-0.2,0.2-0.5-0.2-0.2c-1.2,0.8-1.7,2.3-1.2,3.6c0.3,1.4,1.4,2.9,2.5,2.8c1.7,5.8,5.5,9.9,10.5,9.9s9.2-4.2,10.8-10
                                                            c1.2-0.1,2.4-0.8,2.9-1.9c0.9-1.2,0.7-3-0.5-3.9C324.4,120.8,324.4,120.8,324.3,120.8z"/>
                                                        <path class="st13" d="M309.4,122.4v0.5c-0.3,1.4-0.9,2.7-1.6,3.8l0,0l2.3,1.3"/>
                                                        <path class="st5" d="M305.4,122.1c0,0.6-0.2,1.1-0.6,1.1s-0.6-0.5-0.6-1.1c0-0.6,0.2-1.1,0.6-1.1S305.4,121.5,305.4,122.1z"/>
                                                        <path class="st5" d="M314.2,122.1c0,0.6-0.2,1.1-0.6,1.1s-0.6-0.5-0.6-1.1c0-0.6,0.2-1.1,0.6-1.1S314.2,121.5,314.2,122.1z"/>
                                                        <path class="st13" d="M303.2,119.2c0.8-1.6,2.6-2.4,4.3-1.9"/>
                                                        <path class="st13" d="M317.5,119c-0.8-1.6-2.6-2.4-4.3-1.9"/>
                                                        <line class="st36" x1="302.1" y1="119.3" x2="299.8" y2="119.3"/>
                                                        <rect x="302.6" y="119.3" class="st13" width="6.6" height="4.2"/>
                                                        <rect x="312.1" y="119.3" class="st13" width="6.6" height="4.2"/>
                                                        <line class="st13" x1="309.2" y1="120.6" x2="312.1" y2="120.6"/>
                                                        <line class="st36" x1="322.5" y1="119.3" x2="318.6" y2="119.3"/>
                                                        <path class="st11" d="M300.6,120.6c0.8,0-0.5-3.3,1.9-8.5c1.6-3.4,6.3-2.6,11.9-2.4c5.6,0.2,6.8,9.3,7.3,13.1
                                                            c0,0.2,0.6-2.6,0.8-2.6c2.6,0,1.8-12.8-1.1-13.2c0,0-2.3-4.3-11.1-4c-8.8,0.3-10,5.9-10,5.9S295.8,120.1,300.6,120.6z"/>
                                                        <path class="st13" d="M313.7,128.4c0.1,1,0,2-0.2,3c-0.3,1.1-1.3,2-2.5,1.9c-1.6,0-3-2.5-2.5-4
                                                            C310.3,129.5,312.1,129.2,313.7,128.4z"/>
                                                        <path class="st12" d="M300.9,120.3c0.6,0.9,0,2.6-0.2,3.6c0.1,2.1,0.6,4.1,1.4,6"/>


                                                    </g>
                                                    
                                                        <g id="Clock">
                                                            <g id="Clock_inject-2">
                                                                <circle class="st3" cx="160.1" cy="105.7" r="20.6"/>
                                                                <circle class="st3" cx="160.1" cy="105.7" r="17.1"/>
                                                                <polyline class="st3 clock_line" points="165.3,92.3 160.1,105.7 160.1,96.3          "/>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </svg>

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
            <!-- section3 -->          
            <section id="section3" class="section">
                <div class="section_child1">
                    <div class="container">
                        <div class="position-relative">
                            <div class="row justify-content-center align-items-center my-5">
                               <div class="col-lg-9 col-md-12 col-sm-12">
                                    <div class="text-center que_background_img">
                                        <h1 class="font-700 color-text-gradient">Do you send anniversary greetings to your customers?</h1>      
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
                            <div class="row justify-content-center align-items-center my-5">
                               <div class="col-lg-9 col-md-12 col-sm-12">
                                    <div class="text-center que_background_img">
                                        <h1 class="font-700 color-text-gradient">Want to send it but don’t have time for all the process?</h1>      
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
             <!-- section5 -->
            <section id="section5" class="section">
                <div class="section_child1">
                    <div class="container">
                        <div class="position-relative">
                            <div class="row justify-content-center align-items-center my-5">
                                <div class="col-lg-9 col-md-12 col-sm-12">
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
                            <div class="row my-5 justify-content-center align-items-center">
                                <div class="col-lg-10 col-md-12 col-sm-12">
                                    <div class="text-center">
                                        <div class="section6_text" style="line-height: 1;">
                                            <span class="d-block h5" style="line-height: 1.2;"> Well, then we are here to help you stay connected with your customers on their special day</span>
                                            <span class="h1 font-900 color-text-gradient text-uppercase d-block">by sending a personalised greeting to them</span>
                                            <span class="d-block h5" style="line-height: 1;">Through OPENLINK,</span>
                                            <span class="h1 font-900 color-text-gradient text-uppercase d-block">personalised Wishing </span>
                                            <span class="d-block h5" style="line-height: 1;">you can effortlessly </span>
                                            <span class="h1 font-900 color-text-gradient text-uppercase d-block">wish your customer through customer base. </span>
                                            <div>
                                        </div>          
                                    </div>        
                                </div>
                                <!-- <div class="col-lg-4 col-md-4 col-sm-12 ">
                                	<img src="{{ asset('assets/front/images/features_landing_pages/whatsapp_msg.svg') }}" style="max-width: 300px;"> -->
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
                <div class="section_child1" style="justify-content:flex-start;">
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
                           <div class="col-lg-9 col-md-12 col-sm-12">
                                <div class="text-center pb-3">
                                   <h1 class="text-uppercase">OPENLINK'S Personalised wishing is all your answers!</h1>
                                   <p>OPENLINK'S Personalised wishing is designed to send birthday and anniversary wishes automatically. Just create your message with a customized template available and save it. That’s done! OPENLINK will automatically send your customer your message as per your saved customer database on their special day</p>
                                </div>  
                                <div class="text-center my-5">
                                   <h2>Why Personalized Wishing for your business?</h2> 
                                   <p>Happy customers are key to the business. Staying connected with them and updating them about business is always necessary. Then why skip their special day. Greeting a small message on their special day just does not make them connected with your brand but grows their trust for you.</p>
                                </div>     
                                <div class="bg_options mb-4">
                                    <div class="background_number d-inline ms-3"><i class="bi bi-caret-right-fill"></i></div>
                                    <h5 class="d-inline ms-2">Keeps customers connected saves on your costly paid ads to bring more customers.</h5>
                                </div>
                                <div class="bg_options mb-4">
                                    <div class="background_number d-inline ms-3"><i class="bi bi-caret-right-fill"></i></div>
                                    <h5 class="d-inline ms-2">Saves your time.</h5>
                                </div>
                                <div class="bg_options mb-4">
                                    <div class="background_number d-inline ms-3"><i class="bi bi-caret-right-fill"></i></div>
                                    <h5 class="d-inline ms-2">Effortless and automatic birthday/anniversary wishing.</h5>
                                </div>        
                                <div class="bg_options mb-4">
                                    <div class="background_number d-inline ms-3"><i class="bi bi-caret-right-fill"></i></div>
                                    <h5 class="d-inline ms-2">Your marketing budget is spent on your customers.</h5>
                                </div> 
                                <div class="bg_options mb-4">
                                    <div class="background_number d-inline ms-3"><i class="bi bi-caret-right-fill"></i></div>
                                    <h5 class="d-inline ms-2">Happy customer experience.</h5>
                                </div> 
                           </div>
                        </div>
                    </div>
                </div>   
                <div class="oplk-bg-color-gradient w-100">
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                           <div class="col-lg-9 col-md-12 px-0">
                                <div class="text-center text-white py-4">
                                    <h2 class="font-700">How to greet your customers effortlessly on their special day?</h2>
                                </div> 
                           </div> 
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row justify-content-center my-5">
                       <div class="col-lg-5 col-md-8 col-sm-10 text-center">
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
                                            <h5> Here you are landed to OPENLINK’S  dashboard click on Personalises wishes</h5>
                                        </div>
                                    </div>
                                </div> 
                                <!-- circle3 -->
                                <div class="circle_img_right mb-5">
                                    <img src="{{ asset('assets/front/images/features_landing_pages/arrow_left.svg') }}"> 
                                    <div class="steps_circle">
                                        <div class="text-center inside_circle">
                                            <h1 class="text-uppercase color-text-gradient font-900">Step 3</h1>
                                            <h5> That’s it!! Your messages will be automatically shooted to your customer base as per the data saved in it</h5> 
                                        </div>
                                    </div>
                                </div>
                           	<h6 style="margin-top: 120px;">So don’t miss the time anymore!! Start greeting your customer.</h6>    
                            <button class="btn-theme btn-sm-lg text-uppercase">Buy Personalized Wishing Now</button> 
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