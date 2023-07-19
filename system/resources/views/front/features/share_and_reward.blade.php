@extends('layouts.front')

@section('title', 'share and reward| OpenLink ')
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
    .money_image{
	    background-repeat: no-repeat;
	    width: 75px;
	    height: 60px;
        z-index: -1;
    }
    .money_image_1{
        position: absolute;
        top: 0;
        left: 36px;
    }
    .money_image_2{
        position: absolute;
        top: 0;
        right: 36px;
    }
    .money_image_3{
        position: absolute;
        bottom: -18px;
        right: 21%;
    }
    .money_image_4{
        position: absolute;
        top: 60%;
        left: 30%;
        transform: rotate(240deg);
    }
    /*.money_image:before{
        content: '';
        background-image: url({{ asset('assets/front/images/features_landing_pages/money.svg') }});
        position: absolute;
        top: 200px;
        right: 36px;
        background-repeat: no-repeat;
        width: 75px;
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
    .section1_text{
        animation: 1s 1 forwards left;
        animation-delay: 0.2s;
        opacity:0;
    }
     @keyframes left {
      0% {transform: translateX(-160px);}
      100% {opacity:1;transform: translateX(0px);}
    }
    @-webkit-keyframes left {
      0% {transform: translateX(-160px);}
      100% {opacity:1;transform: translateX(0px);}
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
        .money_image_4 {
            left: 8%;
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
                <div class="section_child1" style="margin-top: 70px;">
                    <div class="position-relative">
                        <div class="container">
                            <div class="pb-5">
                                <div class="row justify-content-center align-items-center">
                                    <div class="col-lg-9 col-md-10 col-sm-12">
                                        <div class="align-middle">
                                            <div class="text-center position-relative section1_text">
                                                <div class="text_img">
                                                   <h1 class="font-700 color-text-gradient">Bring more customers through your own customers!!</h1>  
                                                </div>
                                                <p> Grow your brand’s reach to the next level through your own customers.  Create different offers for your customers, set different future rewards and share targets to avail the offer.</p>
                                            </div>
                                        </div>
                                        <div class="text-center mt-sm-0 mt-5">
                                        	<!-- <img src="{{ asset('assets/front/images/features_landing_pages/share_and_reward.svg') }}" style="max-width: 300px">  -->
                                            <svg style="max-width: 500px; margin-top: 30px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 274.5 255.29">
                                            <defs>
                                                <style>
                                                    .blink{
                                                        animation: opacity_blink 3s infinite;
                                                        animation-delay:1.8s;
                                                        -webkit-animation: opacity_blink 3s infinite;
                                                    }
                                                    @keyframes opacity_blink {
                                                      0% {opacity:0;}
                                                      20% {opacity:0.2;}
                                                      40% {opacity:0.5;}
                                                      60% {opacity:0.8;}
                                                      80% {opacity:0.2;}
                                                      100% {opacity:0;}
                                                    }
                                                    @-webkit-keyframes opacity_blink {
                                                      0% {opacity:0;}
                                                      20% {opacity:0.2;}
                                                      40% {opacity:0.5;}
                                                      60% {opacity:0.8;}
                                                      80% {opacity:0.2;}
                                                      100% {opacity:0;}
                                                    }
                                                    .rectangle{
                                                        animation: 1s 1 forwards cubic-bezier(.36,-0.01,.5,1.38) opacity_rect, 3s Infinite linear moving;
                                                        animation-delay:1.8s;
                                                        opacity: 0;
                                                        transform: translateX(10px);
                                                    }
                                                    @keyframes opacity_rect {
                                                      0% {opacity: 0;transform: translateX(10px);}
                                                      100% {opacity: 1;transform: translateX(0px);}
                                                    }
                                                    @-webkit-keyframes opacity_rect {
                                                      0% {opacity: 0;transform: translateX(10px);}
                                                      100% {opacity: 1;transform: translateX(0px);}
                                                    }
                                                    
                                                    @keyframes moving {
                                                      0% {transform: translateX(0px);}
                                                      50% {transform: translateX(8px);}
                                                      100% {transform: translateX(0px);}
                                                    }
                                                    @-webkit-keyframes moving {
                                                      0% {transform: translateX(0px);}
                                                      50% {transform: translateX(8px);}
                                                      100% {transform: translateX(0px);}
                                                    }
                                                     #hand{
                                                        animation: 1s 1 forwards cubic-bezier(0, 0.36, 0.18, 1.63) down;
                                                        animation-delay: 1s;
                                                        opacity:0;
                                                    } 
                                                    @keyframes down {
                                                      0% {transform: translateY(-100px);}
                                                      100% {opacity:1;transform: translateY(0px);}
                                                    }
                                                    @-webkit-keyframes down {
                                                      0% {transform: translateY(-100px);}
                                                      100% {opacity:10;transform: translateY(0px);}
                                                    }
                                                    .cls-1{fill:none;}.cls-2{fill:#c4c4c4;}.cls-3{fill:#783333;}.cls-4{fill:#ffeaec;}.cls-5{fill:#f9f9f9;}.cls-6{fill:#193c7d;}.cls-12,.cls-34,.cls-7{fill:#fff;}.cls-8{fill:#10193d;}.cls-9{clip-path:url(#clip-path);}.cls-10{fill:#bfdfff;}.cls-11{fill:url(#linear-gradient);}.cls-12{font-size:6.71px;font-family:Lato-Black, Lato;font-weight:800;}.cls-13{clip-path:url(#clip-path-2);}.cls-14{fill:#0e1a30;}.cls-15{clip-path:url(#clip-path-3);}.cls-16{fill:#2c2a2b;}.cls-17{fill:url(#linear-gradient-2);}.cls-18{fill:#ffb287;}.cls-19{fill:#a55930;}.cls-20{fill:#275f91;}.cls-21{fill:#ebf6ff;}.cls-22{fill:url(#linear-gradient-3);}.cls-23{fill:url(#linear-gradient-4);}.cls-24{fill:url(#linear-gradient-5);}.cls-25{fill:url(#linear-gradient-6);}.cls-26{fill:url(#linear-gradient-7);}.cls-27{fill:url(#linear-gradient-8);}.cls-28{fill:#73ade7;}.cls-29{fill:#3783cf;}.cls-30{fill:#a6d2ff;}.cls-31{fill:#c15638;}.cls-32{fill:#3973de;}.cls-33{fill:#406ec2;}.cls-34{opacity:0.82;}.cls-35,.cls-36,.cls-37,.cls-38,.cls-40,.cls-41{opacity:0.33;}.cls-35{fill:url(#linear-gradient-9);}.cls-36{fill:url(#linear-gradient-10);}.cls-37{fill:url(#linear-gradient-11);}.cls-38{fill:url(#linear-gradient-12);}.cls-39{fill:#e74a39;}.cls-40{fill:url(#linear-gradient-13);}.cls-41{fill:url(#linear-gradient-14);}
                                                </style>
                                                <clipPath id="clip-path">
                                                    <rect class="cls-1" x="125.2" y="56.07" width="53.52" height="107.74" rx="8.59" transform="translate(303.92 219.89) rotate(180)"/>
                                                </clipPath>
                                                <linearGradient id="linear-gradient" x1="134.16" y1="132.41" x2="169.78" y2="132.41" gradientUnits="userSpaceOnUse">
                                                    <stop offset="0" stop-color="#00ffaf"/>
                                                    <stop offset="0.06" stop-color="#00edad"/>
                                                    <stop offset="0.32" stop-color="#00a6a7"/>
                                                    <stop offset="0.55" stop-color="#006ea2"/>
                                                    <stop offset="0.75" stop-color="#00469f"/>
                                                    <stop offset="0.91" stop-color="#002d9d"/>
                                                    <stop offset="1" stop-color="#00249c"/>
                                                </linearGradient>
                                                <clipPath id="clip-path-2">
                                                    <path class="cls-2" d="M173.48,91.25a15.52,15.52,0,0,0-.1-14.64c-3.86-7.42-12.39-10.62-19-7.16a12.56,12.56,0,0,0-5.12,5,20.29,20.29,0,0,0-15.27,6.42c-8.06,8.8-6.49,23.36,3.51,32.52s24.65,9.43,32.71.63C175.71,107.94,176.69,99.14,173.48,91.25Z"/>
                                                </clipPath>
                                                <clipPath id="clip-path-3">
                                                    <circle class="cls-3" cx="168.01" cy="79.25" r="5.12" transform="translate(-17.21 93.42) rotate(-29.63)"/>
                                                </clipPath>
                                                <linearGradient id="linear-gradient-2" x1="134.51" y1="127.65" x2="169.06" y2="127.65" xlink:href="#linear-gradient"/>
                                                <linearGradient id="linear-gradient-3" x1="34.94" y1="60.19" x2="94.07" y2="60.19" xlink:href="#linear-gradient"/>
                                                <linearGradient id="linear-gradient-4" x1="175.29" y1="38.17" x2="230.2" y2="38.17" xlink:href="#linear-gradient"/>
                                                <linearGradient id="linear-gradient-5" x1="207.26" y1="87.78" x2="274.5" y2="87.78" xlink:href="#linear-gradient"/>
                                                <linearGradient id="linear-gradient-6" x1="193.44" y1="137.79" x2="240.16" y2="137.79" xlink:href="#linear-gradient"/>
                                                <linearGradient id="linear-gradient-7" x1="49.47" y1="152.79" x2="105.72" y2="152.79" xlink:href="#linear-gradient"/>
                                                <linearGradient id="linear-gradient-8" x1="12.46" y1="110.6" x2="77.46" y2="110.6" xlink:href="#linear-gradient"/>
                                                <linearGradient id="linear-gradient-9" x1="77.56" y1="9.2" x2="85.49" y2="9.2" xlink:href="#linear-gradient"/>
                                                <linearGradient id="linear-gradient-10" x1="248.03" y1="6.81" x2="259.12" y2="6.81" xlink:href="#linear-gradient"/>
                                                <linearGradient id="linear-gradient-11" x1="197.37" y1="173.76" x2="219.74" y2="173.76" xlink:href="#linear-gradient"/>
                                                <linearGradient id="linear-gradient-12" x1="109.76" y1="5.97" x2="121.78" y2="5.97" xlink:href="#linear-gradient"/>
                                                <linearGradient id="linear-gradient-13" x1="0" y1="140.65" x2="12.81" y2="140.65" xlink:href="#linear-gradient"/>
                                                <linearGradient id="linear-gradient-14" x1="9.76" y1="21.21" x2="15.86" y2="21.21" xlink:href="#linear-gradient"/>
                                            </defs>
                                            <g id="Layer_2" data-name="Layer 2">
                                                <g id="bg">
                                                    <path class="cls-4" d="M93,157.39c2.45,0,8.2-.4,7.32-4.2a6,6,0,0,0-2.21-3,16.93,16.93,0,0,0-11.75-4.22c-2.95.18-7.39,1.37-7.56,5a4.85,4.85,0,0,0,2.4,4.1C84.5,157.2,89.11,157.33,93,157.39Z"/>
                                                    <path class="cls-5" d="M262.07,57.69c-12.72-19.38-35.65-29-60.84-28.09h0c-1.76.06-3.53.17-5.31.34a112.83,112.83,0,0,1-20-.87c-8.83-1.27-17.54-4.91-22.2-7.09-1.1-.58-2.22-1.13-3.37-1.65l-.09,0h0a82.77,82.77,0,0,0-26.71-7c-29-2.71-54.92,9.48-65.13,28.69h0l0,.06-.23.45C49.53,59.16,34.8,76.22,34.78,76.25h0a51,51,0,0,0-13,29.07c-3.21,34.29,30.69,65.5,75.72,69.71,1.71.16,3.42.27,5.12.35h.24c.88,0,1.77.07,2.64.08,5.27.27,17.84,1.37,38.9,5.88a77,77,0,0,0,12.09,2.75h0c21.86,3.17,47-2.31,69.36-17C267.59,139.73,283.78,90.74,262.07,57.69Z"/>
                                                </g>
                                                <g id="hand">
                                                    <rect class="cls-6" x="122.42" y="53.29" width="59.08" height="113.3" rx="9.26" transform="translate(303.92 219.89) rotate(180)"/>
                                                    <rect class="cls-7" x="125.2" y="56.07" width="53.52" height="107.74" rx="8.59" transform="translate(303.92 219.89) rotate(180)"/>
                                                    <path class="cls-6" d="M181.42,84.62h0a.69.69,0,0,0,.69-.7V76.23a.69.69,0,0,0-.69-.69h0a.69.69,0,0,0-.7.69v7.69A.7.7,0,0,0,181.42,84.62Z"/>
                                                    <path class="cls-6" d="M181.42,94.3h0a.69.69,0,0,0,.69-.69V85.92a.69.69,0,0,0-.69-.7h0a.7.7,0,0,0-.7.7v7.69A.69.69,0,0,0,181.42,94.3Z"/>
                                                    <path class="cls-6" d="M122.33,85.27h0a.7.7,0,0,0,.7-.7V77.62a.69.69,0,0,0-.7-.69h0a.69.69,0,0,0-.69.69v6.95A.69.69,0,0,0,122.33,85.27Z"/>
                                                    <circle class="cls-8" cx="153.85" cy="54.68" r="0.7"/>
                                                    <path class="cls-8" d="M149.61,54.68a.69.69,0,0,0,.69.7.7.7,0,1,0,0-1.39A.69.69,0,0,0,149.61,54.68Z"/>
                                                    <g class="cls-9">
                                                        <path class="cls-10" d="M121.66,99.93c1.21,1.33-1.92,39.12,18.3,46.31,24.66,8.78,31.74-26.17,74.25-8.25s-31.43,59.1-31.43,59.1L131.6,183.73l-55.1-28L73.85,139Z"/>
                                                        <ellipse class="cls-10" cx="123.7" cy="80.33" rx="16.92" ry="12.87" transform="translate(-23.79 81.15) rotate(-33.32)"/>
                                                        <ellipse class="cls-10" cx="171.4" cy="56.07" rx="10.59" ry="13.92" transform="translate(31.37 169.71) rotate(-57.18)"/>
                                                        <path class="cls-11" d="M164.52,137.68h-25.1a5.26,5.26,0,0,1-5.26-5.27h0a5.26,5.26,0,0,1,5.26-5.26h25.1a5.26,5.26,0,0,1,5.26,5.26h0A5.26,5.26,0,0,1,164.52,137.68Z"/>
                                                        <text class="cls-12" transform="translate(141.42 135.22)">SHARE</text>
                                                    </g>
                                                    <path class="cls-2" d="M173.48,91.25a15.52,15.52,0,0,0-.1-14.64c-3.86-7.42-12.39-10.62-19-7.16a12.56,12.56,0,0,0-5.12,5,20.29,20.29,0,0,0-15.27,6.42c-8.06,8.8-6.49,23.36,3.51,32.52s24.65,9.43,32.71.63C175.71,107.94,176.69,99.14,173.48,91.25Z"/>
                                                    <g class="cls-13">
                                                        <path class="cls-14" d="M147.23,103.43a6,6,0,0,1-3,3.16c-2.36,1.22-4.84,1.11-5.54-.25-.82-1.58.76-3,1.81-4a4.48,4.48,0,0,0,1.4-2,12,12,0,0,0,.52-2.84c0-.4,0-.79.1-1.18a2.88,2.88,0,0,1,.14-.53l3.85,4.46.27,1.11a1.86,1.86,0,0,1,.43.53A2,2,0,0,1,147.23,103.43Z"/>
                                                        <circle class="cls-3" cx="168.01" cy="79.25" r="5.12" transform="translate(-17.21 93.42) rotate(-29.63)"/>
                                                        <g class="cls-15">
                                                            <path class="cls-16" d="M173.54,84a10,10,0,0,1-1.09-.06,8.58,8.58,0,0,1-5.5-2.86,7.12,7.12,0,0,1-1.76-5.54c.49-4.09,4.55-7,9-6.43s7.75,4.3,7.26,8.39a7.06,7.06,0,0,1-3,5A8.42,8.42,0,0,1,173.54,84Zm-.39-14.68c-3.91,0-7.25,2.64-7.68,6.25a6.81,6.81,0,0,0,1.69,5.32,8.52,8.52,0,0,0,11.14,1.35,6.83,6.83,0,0,0,2.91-4.77h0c.48-3.94-2.67-7.56-7-8.09A9.24,9.24,0,0,0,173.15,69.33Z"/>
                                                            <path class="cls-16" d="M171.33,80a4,4,0,0,1-.59,0,4.63,4.63,0,0,1-3-1.54,3.8,3.8,0,0,1,.68-5.68,4.75,4.75,0,0,1,6.21.75,3.8,3.8,0,0,1-.68,5.68A4.61,4.61,0,0,1,171.33,80Zm-.21-7.81a4.26,4.26,0,0,0-2.49.78,3.52,3.52,0,0,0-.64,5.27,4.46,4.46,0,0,0,5.84.7,3.55,3.55,0,0,0,1.52-2.49h0a3.55,3.55,0,0,0-.89-2.77,4.28,4.28,0,0,0-2.78-1.45A3.6,3.6,0,0,0,171.12,72.19Z"/>
                                                        </g>
                                                        <path class="cls-7" d="M143.3,115.34c-.05.08-1.88,6.55-3.77,13.21-.69,2.47-1.39,5-2,7.17-.13.5-.44.91-.57,1.39-1,3.7-3.23,5.92-6.48,4.66l-6.11-2.65,11.16-30.48s3.71-2.81,6-1.92C144.68,107.93,145.13,112.52,143.3,115.34Z"/>
                                                        <path class="cls-14" d="M139.53,128.55c-.69,2.47-1.39,5-2,7.17a5.49,5.49,0,0,1-.57,1.39c.18-3.94-2-8.31-1.84-8.46l2.67-1.42Z"/>
                                                        <path class="cls-3" d="M151.76,101.26l.53.24-1.55,5.72-4.6,1.67-5.23-.77c-.06-.26,4-1.63,2.53-6.6a0,0,0,0,1,0,0,4.14,4.14,0,0,0-.36-.93c-.12-.34-.22-.69-.31-1a18.44,18.44,0,0,1,1-11.78l.05-.11c.16-.35.55-1.24,1-2.09s1-1.76,1.38-1.85.57.36.85.73c.17.22.34.41.53.41a3.22,3.22,0,0,1,1.74.55l.21.14c2,1.49,3.38,5.19,3.38,9.51A16.79,16.79,0,0,1,151.76,101.26Z"/>
                                                        <path class="cls-17" d="M166.73,110c-3.15,2.86-4.88,8.48-4.48,12l.4,5.5v.11c0,.33.07.68.1,1s.08,1,.13,1.57c.32,0,1.19,12.53,2.88,18.75q-8.1.15-16.19-.25c-.64.26-1.31.51-2,.73-6.21,2-12.66-.29-12.66-.29a4.84,4.84,0,0,1,.84-3.56,11.3,11.3,0,0,0,2.16-4.85,56.66,56.66,0,0,0,.49-6.79c-.12-.74-.24-1.52-.37-2.32a.34.34,0,0,0,0-.1l-.08,0c-2.37-1-3.38-2.55-3.45-4.33h0a11.68,11.68,0,0,1,1.47-4.68.64.64,0,0,1,.08-.14c.13-.24.28-.46.43-.7h0c.38-.57.8-1.16,1.26-1.74h0c.13-3.79-2.42-10.13-2.28-11.13l0-.08a1.55,1.55,0,0,1,.78-.86c2.19-1,4.81-1.85,6.51-2.45l7.57,9.63,11.07-8.91a3.3,3.3,0,0,1,1.33-1s5.75,2.47,6.25,3.34C169.28,109,168.32,108.53,166.73,110Z"/>
                                                        <path class="cls-3" d="M157.89,79.37c2.2,2.42,1.35,6.77-1.89,9.72s-7.65,3.38-9.85,1-1.35-6.77,1.89-9.72S155.69,77,157.89,79.37Z"/>
                                                        <path class="cls-14" d="M165.22,126.53l0,.13c-.07.43-.14.84-.21,1.26-.28,1.74-2.24,13.73-2.24,13.73-1.19.95-3.71,4.73-8.21,4.76-2.22-5.12-1.56-13.35.74-13.54,8-.66,6.65-11.4,6.74-11.54l3.07,4.53Z"/>
                                                        <path class="cls-3" d="M161.35,81.28c2.08,1,2.56,4.34,1.07,7.52s-4.39,5-6.47,4-2.57-4.34-1.07-7.52S159.26,80.3,161.35,81.28Z"/><path class="cls-7" d="M154,107.43c-4.1,0-7.68-1-9.59-2.42l-.28-.21-1.48.6.06.06,7.7,10L162,106.54A69.22,69.22,0,0,1,154,107.43Z"/>
                                                        <path class="cls-14" d="M166.34,149.11c0,.26-.23.52-.65.77a6.25,6.25,0,0,1-.72.33c-2.46.94-7.95,1.6-14.34,1.6-1.11,0-2.2,0-3.25-.06-5-.19-9.06-.77-11.09-1.54-.88-.34-1.36-.71-1.36-1.1s.86-1,2.34-1.42a50.82,50.82,0,0,1,11.1-1.25c.74,0,1.49,0,2.26,0A56.41,56.41,0,0,1,164,147.69c.3.08.57.17.82.25C165.79,148.3,166.34,148.69,166.34,149.11Z"/>
                                                        <path class="cls-18" d="M160.08,105.4,158.59,107a23.79,23.79,0,0,1-4.63.44c-4.3,0-8-1.07-9.87-2.63l.83-.34a4.53,4.53,0,0,0,2.81-4.19v-8.6h8.91v9.1a4.52,4.52,0,0,0,2.18,3.86Z"/>
                                                        <path class="cls-14" d="M154.72,96.93s-1.77,3.25-7.16,4.57a4.51,4.51,0,0,0,.17-1.23V97.78Z"/>
                                                        <path class="cls-7" d="M168.67,141.29l-3.52-2.6a12.46,12.46,0,0,1-1.4-3.21,36.8,36.8,0,0,1-1-6.89c0-.35-.06-.69-.1-1v-.11l-.4-5.5c-.4-3.53.77-9.44,3.89-12.34,1.53-1.42,2.64-1.48,2.88-1.24s3.57,9.48,5.65,27.44C175.07,139.27,172.54,141.28,168.67,141.29Z"/>
                                                        <path class="cls-18" d="M145.39,81.61h11.69a0,0,0,0,1,0,0v10.9a6.3,6.3,0,0,1-6.3,6.3h0a5.4,5.4,0,0,1-5.4-5.4V81.61a0,0,0,0,1,0,0Z" transform="translate(11.89 -17.46) rotate(6.88)"/>
                                                        <path class="cls-16" d="M149,86.48c-.24-.07-.55-.18-.83-.25a6,6,0,0,0-.88-.17,4.43,4.43,0,0,0-.89,0,2.44,2.44,0,0,0-.94.23h0a.06.06,0,0,1-.08,0,.08.08,0,0,1,0,0,1.52,1.52,0,0,1,.78-.94,2.57,2.57,0,0,1,1.2-.3,3,3,0,0,1,1.19.19,2.34,2.34,0,0,1,1,.73.42.42,0,0,1-.06.58.44.44,0,0,1-.37.07Z"/>
                                                        <path class="cls-16" d="M152.32,86a2.22,2.22,0,0,1,1.25-.18,3,3,0,0,1,1.15.37,2.49,2.49,0,0,1,.92.82,1.54,1.54,0,0,1,.27,1.19.06.06,0,0,1-.08,0l0,0h0a2.55,2.55,0,0,0-.73-.64,4.88,4.88,0,0,0-.81-.36,7.51,7.51,0,0,0-.86-.25c-.28-.07-.61-.11-.86-.16l-.13,0a.41.41,0,0,1-.31-.49A.37.37,0,0,1,152.32,86Z"/>
                                                        <path class="cls-16" d="M154.42,90.11a.14.14,0,0,1-.13-.1,2.43,2.43,0,0,0-.73-1,1.16,1.16,0,0,0-1-.16,1.43,1.43,0,0,0-.53.32.28.28,0,0,1-.11.07.14.14,0,0,1-.18-.09.14.14,0,0,1,.09-.17s0,0,0,0a1.86,1.86,0,0,1,.63-.38,1.3,1.3,0,0,1,.91,0,1.59,1.59,0,0,1,.31.17,2.55,2.55,0,0,1,.83,1.18.12.12,0,0,1-.09.17Z"/>
                                                        <path class="cls-16" d="M149.14,89.47a.14.14,0,0,1-.14-.09,2.28,2.28,0,0,0-.72-1,1.2,1.2,0,0,0-.25-.13,1,1,0,0,0-.73,0,1.52,1.52,0,0,0-.53.32.31.31,0,0,1-.1.08.15.15,0,0,1-.18-.09.15.15,0,0,1,.09-.18s0,0,0,0a1.66,1.66,0,0,1,.62-.37,1.3,1.3,0,0,1,.91,0,1.24,1.24,0,0,1,.32.17,2.49,2.49,0,0,1,.83,1.17.15.15,0,0,1-.09.18Z"/>
                                                        <path class="cls-14" d="M148.53,88.79a.63.63,0,1,1-.55-.71A.64.64,0,0,1,148.53,88.79Z"/>
                                                        <path class="cls-14" d="M153.73,89.42a.63.63,0,0,1-.7.56.64.64,0,0,1,.15-1.27A.63.63,0,0,1,153.73,89.42Z"/>
                                                        <path class="cls-19" d="M150.54,92a3.5,3.5,0,0,1-1.41-.22c-.11-.06-.17-.1.79-4.1a.14.14,0,0,1,.17-.11.15.15,0,0,1,.1.17c-.31,1.31-.8,3.41-.85,3.84a4.37,4.37,0,0,0,1.26.15h0a.14.14,0,0,1,.14.13.14.14,0,0,1-.14.14Z"/>
                                                        <path class="cls-16" d="M156,133.05a14.26,14.26,0,0,1-4.18-.57c-3.38-1.47-4.37-4.11-2.87-7.64a.15.15,0,0,1,.19-.07.14.14,0,0,1,.07.18c-1.45,3.41-.54,5.86,2.71,7.27a14.17,14.17,0,0,0,4.29.55.17.17,0,0,1,.15.14.14.14,0,0,1-.14.14Z"/>
                                                        <path class="cls-16" d="M142.1,132.35a14.76,14.76,0,0,1-4.18-.57c-3.37-1.47-4.36-4.11-2.86-7.64a21.56,21.56,0,0,1,3.26-5.37.14.14,0,0,1,.19,0,.14.14,0,0,1,0,.2,21.47,21.47,0,0,0-3.2,5.28c-1.45,3.41-.54,5.85,2.7,7.27a14.28,14.28,0,0,0,4.3.55h0a.14.14,0,0,1,.14.14.14.14,0,0,1-.14.14Z"/>
                                                        <path class="cls-19" d="M150.67,94.22a3.37,3.37,0,0,1-1-.16l0,0-.06,0a.14.14,0,0,1-.11-.16.14.14,0,0,1,.16-.11l.09,0h.05a2.73,2.73,0,0,0,1.83,0,1.91,1.91,0,0,0,1-.93.15.15,0,0,1,.19-.07.12.12,0,0,1,.07.17v0A2.25,2.25,0,0,1,151.67,94,2.81,2.81,0,0,1,150.67,94.22Z"/>
                                                        <path class="cls-19" d="M153.17,93.55a.16.16,0,0,1-.09,0,.47.47,0,0,1-.1-.1,1.66,1.66,0,0,1-.34-.46,4.24,4.24,0,0,1-.24-.57l0-.08a.13.13,0,0,1,.07-.18.14.14,0,0,1,.19.07.62.62,0,0,1,0,.1,4.73,4.73,0,0,0,.23.53,1.27,1.27,0,0,0,.29.39.3.3,0,0,0,.08.08.13.13,0,0,1,0,.19A.14.14,0,0,1,153.17,93.55Z"/>
                                                        <path class="cls-14" d="M150.35,84.88l-.36.28-.5.36a10.18,10.18,0,0,1-5.71,2.11c.16-.35.55-1.24,1-2.09A17.12,17.12,0,0,1,147,84.42a1,1,0,0,1,.21-.09,3,3,0,0,1,1.47-.21A3.12,3.12,0,0,1,150.35,84.88Z"/>
                                                        <path class="cls-3" d="M158,80.66l-4.27-1.39-1.89,1-.09-.09.78-2.24-3.76.73a21.31,21.31,0,0,0-6,1.61c-1.34.7-2.74,2.43-2.13,3.88.8,1.93,2.93,2.9,6.4,2.15a10,10,0,0,0,3.59-1.5l0,0c.4-.28,3.66-2.47,5.65-.77s-.05,6.52-.05,6.52,1.86,1.43,1.94,1.23,3.57-7.33,3.57-7.33Z"/>
                                                        <path class="cls-3" d="M165.91,113.69c.06.23.34.85.53,1.38h-2.55a14.74,14.74,0,0,1-.61-3.17,13.84,13.84,0,0,0-.14,3.17h-4.65a14.81,14.81,0,0,1-1.94-6.18,23,23,0,0,0,.11,6.18H153.4a17.6,17.6,0,0,1,1.12-12.21,17,17,0,0,0,1.74-6.74l-.15-5.52,7.16-5.11a30.88,30.88,0,0,0,.25,5.66,33.09,33.09,0,0,0,2.2,6.7c.14.36.29.71.43,1.07,1.2,3.16-.18,5.66-.6,8.78A16.27,16.27,0,0,0,165.91,113.69Z"/>
                                                        <path class="cls-18" d="M158.35,93c-1.09.86-2.45,1-3,.22s-.17-2,.93-2.89,2.45-1,3-.22S159.44,92.15,158.35,93Z"/>
                                                        <path class="cls-3" d="M165.93,105.66a7.63,7.63,0,0,1-.32,1.09,7.76,7.76,0,0,1-.46,1c.12-.42.24-.82.39-1.2S165.79,105.94,165.93,105.66Z"/>
                                                        <path class="cls-16" d="M157.38,82.32a.16.16,0,0,1-.11,0,.14.14,0,0,1,0-.2c.1-.08,2.65-2,4.42-.74a.13.13,0,0,1,0,.19.12.12,0,0,1-.19,0c-1.6-1.18-4.07.72-4.09.74A.16.16,0,0,1,157.38,82.32Z"/>
                                                        <path class="cls-16" d="M156.75,90.14a.14.14,0,0,1-.07-.27l.09-.07a2.66,2.66,0,0,1,3-.54.15.15,0,0,1,.07.19.14.14,0,0,1-.19.06A2.39,2.39,0,0,0,157,90c-.07.07-.1.1-.14.11Z"/>
                                                        <path class="cls-16" d="M162.06,109a.14.14,0,0,1-.14-.12,8.9,8.9,0,0,1,.67-4.92,9.32,9.32,0,0,0,.77-4,13.84,13.84,0,0,0-2.52-6.35,3,3,0,0,1-.36-.62.14.14,0,0,1,.28-.05,4.18,4.18,0,0,0,.31.51,14,14,0,0,1,2.57,6.49,9.74,9.74,0,0,1-.78,4.12,8.47,8.47,0,0,0-.66,4.78.15.15,0,0,1-.12.17Z"/>
                                                        <path class="cls-20" d="M168,158H133.29l3-7.77,1-2.52a50.82,50.82,0,0,1,11.1-1.25c.74,0,1.49,0,2.26,0A56.41,56.41,0,0,1,164,147.69l1,2.52Z"/>
                                                        <path class="cls-20" d="M161.63,181.13c-5.59,1-11.76-7.59-13.75-19.13q-.36-2-.51-4a38,38,0,0,1,0-6.23,26.39,26.39,0,0,1,1-5.31c.74,0,1.49,0,2.26,0A56.41,56.41,0,0,1,164,147.69c.3.08.57.17.82.25.31.62.6,1.27.88,1.94a40.62,40.62,0,0,1,2.45,8.61C170.14,170,167.23,180.16,161.63,181.13Z"/>
                                                        <path class="cls-7" d="M172.44,143.29a7.66,7.66,0,0,0,2.23-5.62,6.71,6.71,0,0,0-10-5.37c-3.42,1.42-7.54,2.85-7.54,2.87-.2,0-.2.2-.39.25-3.49,1-3.7,7.4-1.95,13.06,1.61,5.19,4.89,10.22,8.11,10.26a3.28,3.28,0,0,0,.88-.12,3.32,3.32,0,0,0,2-1.68c1.31-1.93,2-5.38,2.5-7.72.47-2.15,2.31-4.16,3.4-5.19a6.85,6.85,0,0,0,.8-.72Z"/>
                                                        <path class="cls-16" d="M156.44,110.16a.13.13,0,0,1-.14-.13,9.79,9.79,0,0,1,1.55-5.53,11.37,11.37,0,0,0,1.71-6.84.14.14,0,0,1,.13-.15.14.14,0,0,1,.15.13,11.62,11.62,0,0,1-1.74,7,9.48,9.48,0,0,0-1.52,5.39.14.14,0,0,1-.14.14Z"/>
                                                        <path class="cls-16" d="M143.84,85.52a5.1,5.1,0,0,1-1.08-.12c-1-.2-2.38-1.08-2.34-2.31a.14.14,0,0,1,.14-.14.15.15,0,0,1,.14.15c0,1.07,1.25,1.84,2.12,2,2.37.51,4.11-.8,5.94-2.18,1.62-1.21,3.29-2.46,5.42-2.37a.14.14,0,0,1,.13.15.14.14,0,0,1-.14.13c-2-.09-3.67,1.14-5.24,2.32S145.81,85.52,143.84,85.52Z"/>
                                                        <path class="cls-16" d="M159.66,85.54a.15.15,0,0,1-.14-.13,2,2,0,0,0-.77-1.45c-.92-.69-2.59-.8-5-.35l-.2,0a.14.14,0,0,1-.16-.12.14.14,0,0,1,.12-.16l.18,0c.93-.18,3.73-.71,5.2.4a2.24,2.24,0,0,1,.89,1.64.14.14,0,0,1-.13.15Z"/>
                                                        <path class="cls-7" d="M133.55,131.25l-6.8-4.29-11.14-7c-.82-.52-4.5-3-4.5-3-2,.14-5.16,8.13-6,11.6-.73,3.06-1.86,7.36-.26,10.32.88,1.64,2.75,1.85,4.42,1.52a29.14,29.14,0,0,0,3.52-1.19,7.71,7.71,0,0,1,3.87-.28l12.76,3.5a5.77,5.77,0,0,0,6.29-2.26C137.12,138,136.18,132.87,133.55,131.25Z"/>
                                                        <path class="cls-14" d="M112.82,128.79c0,.23,0,.47-.08.71-.85,6.74-4.1,11.29-6.58,10.6s-2.67-5.51-1.07-11.59c.36-1.47.77-2.91,1.2-4.24A23.68,23.68,0,0,1,109,118.2c.59-.82,1.17-1.3,1.74-1.31.87,0,1.56,1.33,1.94,3.5A31,31,0,0,1,112.82,128.79Z"/>
                                                        <path class="cls-14" d="M162.54,158.7c-2.2.3-5.71-3.54-7.93-10a20,20,0,0,1-1.11-6.81c.07-2.59.76-4.68,1.86-5.8a3.09,3.09,0,0,1,1.28-.81,3,3,0,0,1,.78-.11h0c2,0,3.62,2.27,4.77,5.87a33,33,0,0,1,.94,3.91C164.36,151.22,167,158.11,162.54,158.7Z"/>
                                                        <path class="cls-16" d="M132.1,132.88a.13.13,0,0,1-.14-.11c-.39-2.07-2.22-4.07-5.15-5.62l-.14-.08a.14.14,0,0,1,0-.19.14.14,0,0,1,.19,0l.12.06c3,1.6,4.89,3.66,5.29,5.82a.13.13,0,0,1-.11.16Z"/>
                                                        <path class="cls-16" d="M163,131.89a.14.14,0,0,1-.14-.13l-1-10.42a.71.71,0,0,0,0-.15,3.88,3.88,0,0,1,1.93-3.74.14.14,0,1,1,.13.24,3.65,3.65,0,0,0-1.79,3.49.87.87,0,0,1,0,.17l1,10.39a.14.14,0,0,1-.13.15Z"/>
                                                        <path class="cls-16" d="M160.52,115.1a.12.12,0,0,1-.1,0,7.68,7.68,0,0,1-.46-8.41.13.13,0,0,1,.19,0,.15.15,0,0,1,0,.19,7.38,7.38,0,0,0,.43,8.09.14.14,0,0,1,0,.2A.14.14,0,0,1,160.52,115.1Z"/>
                                                        <path class="cls-16" d="M156.53,135.62a.14.14,0,0,1-.13-.09.14.14,0,0,1,.08-.18l6.26-2.45c3.32-1.09,6.76-1.56,9.54,2.34a.14.14,0,0,1,0,.2.14.14,0,0,1-.19,0c-2.68-3.76-6-3.3-9.23-2.24l-6.25,2.44Z"/>
                                                        <path class="cls-16" d="M165.91,156.77a.13.13,0,0,1-.08,0,.13.13,0,0,1,0-.19c2-2.73,2-6.44,2.1-9.15,0-1.64.06-2.92.49-3.51a.14.14,0,0,1,.19,0,.13.13,0,0,1,0,.2c-.37.51-.4,1.76-.43,3.34-.05,2.75-.13,6.51-2.15,9.31A.14.14,0,0,1,165.91,156.77Z"/>
                                                        <path class="cls-16" d="M112.44,139.48a.14.14,0,0,1-.13-.09.13.13,0,0,1,.08-.18l.24-.12c2.92-1.41,5.59-1.82,8-1.19a.15.15,0,0,1,.1.17.14.14,0,0,1-.17.1,11.16,11.16,0,0,0-7.75,1.18l-.27.12Z"/>
                                                        <path class="cls-16" d="M173.56,127.79a.13.13,0,0,1-.13-.09c-.75-2.13-3.18-5.17-4-6.17l-.09-.11a.15.15,0,0,1,0-.2.14.14,0,0,1,.2,0l.09.12c.81,1,3.27,4.07,4,6.25a.14.14,0,0,1-.09.18Z"/>
                                                        <path class="cls-16" d="M162.61,133.29h0a.13.13,0,0,1-.11-.16c.2-1.39,2.08-2.79,3.2-3.62a5.11,5.11,0,0,0,.67-.54.15.15,0,0,1,.2-.05.14.14,0,0,1,0,.19,3.26,3.26,0,0,1-.75.62c-1,.76-2.9,2.16-3.09,3.44A.14.14,0,0,1,162.61,133.29Z"/>
                                                        <path class="cls-16" d="M128.36,128.05h-.05a.14.14,0,0,1-.08-.18c.08-.24,1.47-2,4.54-2h0a.13.13,0,0,1,.14.13.14.14,0,0,1-.14.14c-2.86,0-4.19,1.6-4.28,1.82A.15.15,0,0,1,128.36,128.05Z"/>
                                                        <path class="cls-16" d="M137.77,119.77h0a.13.13,0,0,1-.13-.15c.15-2.24-.9-3.79-1.69-4a.15.15,0,0,1-.1-.18.13.13,0,0,1,.17-.09c1,.27,2.05,2.06,1.9,4.28A.14.14,0,0,1,137.77,119.77Z"/>
                                                        <path class="cls-20" d="M154.67,158l-.53,1-1.35,2.54-12.07,22.8-4.19,7.9.2,2.9,3.47,51.39-2.78,1.57-23.66-1.57,3.81-56.38a13.31,13.31,0,0,1,1.36-5L136.38,150Z"/>
                                                        <path class="cls-14" d="M140.72,184.38l-4.19,7.9.2,2.9h0c-.35-3.88-.65-4.94-1.2-5.95.86-.41,3.17-1,9.82-17.27a27.46,27.46,0,0,0,2.23-11.64l5.25,1.27Z"/>
                                                        <path class="cls-14" d="M140.2,246.57c-.27,1.21-2.29,2-5.92,2.34a59.12,59.12,0,0,1-6.4.17l-2.62-.07c-1.38-.06-2.64-.12-3.8-.21-1.45-.11-2.71-.25-3.76-.43-2.39-.4-3.75-1-3.94-1.8-.26-1.16,2.23-2.35,8.25-1.5,1.25.18,2.66.45,4.22.82,2.09.5,3.88.85,5.4,1.08.52.08,1,.14,1.47.19l1.13.12C139.21,247.69,140.2,246.57,140.2,246.57Z"/>
                                                        <path class="cls-14" d="M164.4,254.25l-2.33.8a4.56,4.56,0,0,1-3,0l-2.41-.89a2.72,2.72,0,0,1-1.76-2.59l.05-3.11a1.89,1.89,0,0,1,2.47-2.31s7.21,1,8.27,2l.59,2.9A2.79,2.79,0,0,1,164.4,254.25Z"/>
                                                        <path class="cls-18" d="M160.36,250.42a29.17,29.17,0,0,1-5.35-2.84l9.84.06Z"/>
                                                        <path class="cls-20" d="M174.44,246.76a.74.74,0,0,1,0,.14c0,1.21-5.9,2.2-13.18,2.2-6.93,0-12.6-.89-13.12-2h-.08l.69-58-1.54-32.67,21.53,9.4-.13,2.45v.37c0,.06,0,.11,0,.18l0,.84v0l-.88,17.58a27.23,27.23,0,0,0,.17,4.6l.45,3.8a0,0,0,0,1,0,0l6.14,51.09Z"/>
                                                        <path class="cls-16" d="M148.38,180.5a.15.15,0,0,1-.14-.14c-.15-5.18-.62-18.77-.91-19.48s-2.34-1.74-2.36-1.75a.15.15,0,0,1-.07-.19.15.15,0,0,1,.19-.07c.08,0,2.11,1,2.5,1.9s.91,18.82.93,19.58a.15.15,0,0,1-.13.15Z"/>
                                                        <path class="cls-16" d="M147.4,154.73a.13.13,0,0,1-.14-.13c0-.68,0-1.47-.06-2.36,0-2,0-4.37,0-5.77,0-.08.05-.12.14-.14a.15.15,0,0,1,.14.15c0,1.39-.06,3.72,0,5.76,0,.89,0,1.68.06,2.35a.14.14,0,0,1-.14.14Z"/>
                                                        <path class="cls-16" d="M135.49,151.92a.14.14,0,0,1,0-.28h.19l4.2-.06h.39l.66,0,.77-4.71a.14.14,0,0,1,.16-.12.15.15,0,0,1,.11.16l-.78,4.83a.14.14,0,0,1-.13.12l-.79,0h-.39l-4.19.06Z"/>
                                                        <path class="cls-16" d="M159.76,151.92c-1.38,0-4.77-.07-5.57-.08a.13.13,0,0,1-.13-.12l-.85-5.25a.13.13,0,0,1,.11-.16.14.14,0,0,1,.16.12l.83,5.13c2.34,0,5.78.1,6,.07a.14.14,0,0,1,.16.12.13.13,0,0,1-.11.15A5.22,5.22,0,0,1,159.76,151.92Z"/>
                                                        <path class="cls-16" d="M137,200a.14.14,0,0,1-.14-.13c-.13-1.89-.24-3.41-.35-4.66-.34-3.8-.64-4.89-1.18-5.89l-.22-.41a.13.13,0,0,1,0-.19.14.14,0,0,1,.19.05c.08.14.16.27.23.42.56,1,.87,2.15,1.21,6,.11,1.26.22,2.78.35,4.67a.14.14,0,0,1-.13.15Z"/>
                                                        <path class="cls-16" d="M122.45,188.21l-.06,0c-2.26-1-3.36-1-3.88-.78a.67.67,0,0,0-.39.32.15.15,0,0,1-.18.08.16.16,0,0,1-.09-.18,1,1,0,0,1,.53-.47c.57-.24,1.74-.3,4.12.78a.14.14,0,0,1,0,.27Z"/>
                                                        <path class="cls-16" d="M161.21,188.21l-.06,0c-3.83-1.73-6.23,0-6.25,0a.14.14,0,0,1-.2,0,.15.15,0,0,1,0-.2c.1-.07,2.55-1.82,6.53,0a.14.14,0,0,1,.07.19A.13.13,0,0,1,161.21,188.21Z"/>
                                                        <path class="cls-14" d="M167.71,187.24a27.23,27.23,0,0,0,.17,4.6l.45,3.8a23.29,23.29,0,0,1-1.67-10.57c.55-4.95,1.64-11.17,1.93-15.41Z"/>
                                                        <path class="cls-16" d="M115.69,218.17h0a.14.14,0,0,1-.13-.15c.43-6.37,4.48-15.82,5.18-16.29a.15.15,0,0,1,.2,0,.14.14,0,0,1,0,.19c-.56.38-4.62,9.51-5.06,16.08A.14.14,0,0,1,115.69,218.17Z"/>
                                                        <path class="cls-16" d="M139.7,239.34a.15.15,0,0,1-.14-.13c-.69-6.23-4.65-13.14-6.78-16.85-.94-1.65-1.33-2.32-1.29-2.57a.13.13,0,0,1,.16-.12.14.14,0,0,1,.12.15,14.49,14.49,0,0,0,1.25,2.4c2.14,3.73,6.12,10.67,6.82,17a.13.13,0,0,1-.12.15Z"/>
                                                        <path class="cls-16" d="M148.64,202h0a.15.15,0,0,1-.14-.15c.09-7.62,3.15-15.64,4.19-16.71a.13.13,0,0,1,.2,0,.12.12,0,0,1,0,.19c-1,1.05-4,9-4.11,16.53A.14.14,0,0,1,148.64,202Z"/>
                                                        <path class="cls-16" d="M171.48,222a.15.15,0,0,1-.14-.11c-1.19-5-7-14.64-7.47-15.22a.14.14,0,0,1,.22-.18c.46.59,6.32,10.27,7.53,15.34a.14.14,0,0,1-.11.16Z"/>
                                                        <path class="cls-16" d="M124.87,173.34h-.07a.16.16,0,0,1-.06-.19,15,15,0,0,1,8-6.45.14.14,0,0,1,.18.08.13.13,0,0,1-.08.18,14.75,14.75,0,0,0-7.83,6.31A.13.13,0,0,1,124.87,173.34Z"/>
                                                        <path class="cls-16" d="M168.58,167.41a.14.14,0,0,1-.13-.12,8.18,8.18,0,0,0-3.55-5c-.55-.42-.9-.69-1-1a.14.14,0,0,1,.08-.18.14.14,0,0,1,.18.09,3.32,3.32,0,0,0,.91.83c1.19.93,3.2,2.48,3.65,5.21a.15.15,0,0,1-.11.17Z"/><path class="cls-16" d="M134.1,154.73a.14.14,0,0,1-.08-.26c.09-.05,2.15-1.4,7.62-1.51a.14.14,0,0,1,.14.14.13.13,0,0,1-.13.14c-5.37.11-7.45,1.45-7.47,1.47Z"/>
                                                        <path class="cls-18" d="M133.1,247.16c-1.44.38-4.48,1.17-7.84,1.85a44.88,44.88,0,0,1-9.86,1.11l2.3-1.75,4.31-3.3c1.25.18,2.66.45,4.22.82A58.64,58.64,0,0,0,133.1,247.16Z"/>
                                                        <path class="cls-16" d="M135.35,146.53h0a.14.14,0,0,1-.09-.17c.76-2.47,3.52-3.7,4.56-4.17l.35-.16a.13.13,0,0,1,.19,0,.14.14,0,0,1,0,.2,1.48,1.48,0,0,1-.43.23c-1,.45-3.69,1.64-4.41,4A.15.15,0,0,1,135.35,146.53Z"/>
                                                        <path class="cls-14" d="M126,253.45v-2.16l-6.61,2.16H108.78a6.2,6.2,0,0,1-2.94-.74.61.61,0,0,1,.2-1.13l15.42-2.78L131.63,247c.52.08,1,.14,1.47.19l1.13.12.05,1.63.11,4.54Z"/>
                                                        <path class="cls-18" d="M159,136c.61.32-2.45,3-3.19,2.24-3.08-3-5.79-6.34-5.62-7.31h0a.24.24,0,0,1,.37-.2A64.2,64.2,0,0,0,159,136Z"/>
                                                        <path class="cls-14" d="M153.62,141.13a1.78,1.78,0,0,1-.33,1.39l-.12.15-3.35-17.15c0-1.26-.35-1.58-.79-1.57l-15.37,0,.45-.41a1.32,1.32,0,0,1,1-.54l14.43-.08a.88.88,0,0,1,.86.72Z"/>
                                                        <path class="cls-21" d="M150.14,124.42l3.24,17.68a.64.64,0,0,1-.62.75H138a.87.87,0,0,1-.85-.7l-3.67-17.63a.65.65,0,0,1,.62-.77l15.14,0A.88.88,0,0,1,150.14,124.42Z"/>
                                                        <path class="cls-14" d="M143.9,130.37a1.53,1.53,0,1,1-1.42-1.33A1.39,1.39,0,0,1,143.9,130.37Z"/>
                                                        <path class="cls-18" d="M112.82,128.79l-6.53-4.52-1.46-1,3.51-5.46.68.41,3.68,2.19A31,31,0,0,1,112.82,128.79Z"/>
                                                        <path class="cls-18" d="M108.34,118.1l-2,6.13s-6.61-1.09-8-2.33c-1-.92,2.17-5.05,2.17-5.05Z"/><path class="cls-18" d="M110.73,119.33c.5.47-3.17,2.19-3.68,1.28-2.13-3.77-3.84-7.68-3.4-8.57h0a.22.22,0,0,1,.4-.09A65.17,65.17,0,0,0,110.73,119.33Z"/>
                                                        <path class="cls-18" d="M100.58,118.66l-.29-.11-.14-.08-.23-.15-.38-.29c-.25-.19-.48-.39-.7-.59-.45-.41-.87-.83-1.28-1.27a31.78,31.78,0,0,1-2.29-2.86.32.32,0,0,1,.32-.49h0a2.19,2.19,0,0,1,1.3.73,21.43,21.43,0,0,0,1.66,1.63,16.12,16.12,0,0,0,1.28,1.07q.33.25.66.48a3,3,0,0,0,.33.21l.14.07.05,0a.24.24,0,0,0-.09,0Z"/>
                                                        <path class="cls-18" d="M100.52,119.81l-.29-.1-.14-.08-.26-.14a5.55,5.55,0,0,1-.48-.29c-.32-.19-.62-.39-.92-.6-.59-.41-1.17-.85-1.73-1.31A20.23,20.23,0,0,1,93.62,114a.24.24,0,0,1,.19-.37h0a2.24,2.24,0,0,1,1.67.72,12.9,12.9,0,0,0,2.08,1.83c.55.4,1.13.78,1.71,1.13l.88.5.44.22.21.1.1,0s0,0-.05,0Z"/>
                                                        <path class="cls-18" d="M100.2,121.49l-.24-.1-.15-.08-.27-.15-.51-.31c-.33-.21-.65-.42-1-.64-.63-.45-1.24-.92-1.83-1.42a26.07,26.07,0,0,1-3.3-3.4.3.3,0,0,1,.27-.47h.1a2.32,2.32,0,0,1,1.52.78,15,15,0,0,0,2.29,2c.58.44,1.18.84,1.8,1.22.3.19.62.37.93.54l.47.25.23.11.1,0h0Z"/>
                                                        <path class="cls-18" d="M100.11,122.72l-.2-.06-.14,0-.26-.1-.32-.14c-.21-.1-.42-.19-.63-.3a18,18,0,0,1-2.24-1.32,15.73,15.73,0,0,1-3.13-3,.32.32,0,0,1,.23-.51h0a1.62,1.62,0,0,1,1.28.5,10.8,10.8,0,0,0,2.38,1.84,16.68,16.68,0,0,0,2.16,1.07l.57.21.28.11.22.06.1,0h0Z"/>
                                                        <path class="cls-18" d="M151.53,137.87a2.21,2.21,0,0,1-.34.06H151l-.3,0-.53-.08c-.34,0-.67-.12-1-.2-.65-.16-1.29-.34-1.92-.55a33.5,33.5,0,0,1-3.75-1.56.34.34,0,0,1,0-.64h0a2.46,2.46,0,0,1,1.65,0,21.44,21.44,0,0,0,2.49.7c.6.15,1.21.27,1.82.36.3.05,1.89.26,1.85.28Z"/>
                                                        <path class="cls-18" d="M150.83,139a1.8,1.8,0,0,1-.31,0h-.17l-.3,0-.57-.05-1.1-.17c-.73-.12-1.45-.28-2.17-.47a20.29,20.29,0,0,1-4.26-1.71.24.24,0,0,1,0-.42h0a2.25,2.25,0,0,1,1.85-.06,12.8,12.8,0,0,0,2.71.8c.68.13,1.37.23,2.07.31l1,.08.5,0h.3Z"/>
                                                        <path class="cls-18" d="M151.89,140.57h-.44l-.31,0c-.21,0-.4,0-.6-.06q-.6-.08-1.17-.18a22.54,22.54,0,0,1-2.3-.53,25.16,25.16,0,0,1-4.51-1.72.3.3,0,0,1,0-.55l.1,0a2.38,2.38,0,0,1,1.74.07,15.88,15.88,0,0,0,3,.86c.72.15,1.46.27,2.19.35.36.05.73.08,1.09.1l.54,0h.39Z"/>
                                                        <path class="cls-18" d="M152.5,141.41l-.22,0h-.78c-.24,0-.48,0-.72,0a19.45,19.45,0,0,1-2.63-.31,15.86,15.86,0,0,1-4.15-1.52.32.32,0,0,1,0-.57h0a1.63,1.63,0,0,1,1.4-.06,10.9,10.9,0,0,0,3,.74,16.88,16.88,0,0,0,2.46.11l.62,0,.31,0,.23,0,.1,0h0Z"/>
                                                        <path class="cls-18" d="M162.19,141l-3,.7a12.73,12.73,0,0,1-3.53.31c-.63,0-1.37-.09-2.13-.16a15.91,15.91,0,0,1-4.64-.86c-1.15-.67,1.32-4.86,1.32-4.86l5.18-.08.61,0-.07-.37,1.52-.53h0C159.37,135.17,161,137.43,162.19,141Z"/>
                                                        <path class="cls-19" d="M150.23,139.22h0a20.43,20.43,0,0,1-8.3-2.52.14.14,0,0,1-.07-.19.14.14,0,0,1,.18-.07l0,0a20.29,20.29,0,0,0,8.19,2.48.15.15,0,0,1,.13.16A.14.14,0,0,1,150.23,139.22Z"/>
                                                        <path class="cls-19" d="M150.1,140.72h0a22.93,22.93,0,0,1-7.6-2.54.14.14,0,1,1,.14-.24,22.57,22.57,0,0,0,7.49,2.5.14.14,0,0,1,.12.16A.13.13,0,0,1,150.1,140.72Z"/>
                                                        <path class="cls-19" d="M150.23,137.83h0a14.32,14.32,0,0,1-3.57-.81.14.14,0,0,1-.08-.18.14.14,0,0,1,.18-.08,14.19,14.19,0,0,0,3.49.79.15.15,0,0,1,.13.15A.15.15,0,0,1,150.23,137.83Z"/>
                                                        <path class="cls-19" d="M106.91,120.26a.12.12,0,0,1-.09,0,10.81,10.81,0,0,1-1.94-3.5l0-.07a.14.14,0,0,1,.07-.18.13.13,0,0,1,.18.06.85.85,0,0,1,0,.09A9.49,9.49,0,0,0,107,120a.15.15,0,0,1,0,.2A.12.12,0,0,1,106.91,120.26Z"/>
                                                        <path class="cls-19" d="M98.48,121.32h0a.14.14,0,0,1-.07-.18l.07-.2c.52-1.26,1.47-3.62,2.43-4.05a.14.14,0,0,1,.18.07.13.13,0,0,1-.07.18c-.85.39-1.85,2.86-2.28,3.91l-.08.19A.13.13,0,0,1,98.48,121.32Z"/>
                                                        <path class="cls-19" d="M104.58,121.32a.16.16,0,0,1-.11,0,.14.14,0,0,1,0-.2,3.24,3.24,0,0,1,3.56-.06.14.14,0,1,1-.19.21,3,3,0,0,0-3.2.07A.16.16,0,0,1,104.58,121.32Z"/>
                                                        <path class="cls-19" d="M98.6,120.51l-.07,0-2.12-1.16a.15.15,0,0,1,0-.2.14.14,0,0,1,.19,0l2.11,1.15a.15.15,0,0,1,0,.19A.13.13,0,0,1,98.6,120.51Z"/>
                                                        <path class="cls-19" d="M99.35,119.34a.08.08,0,0,1-.07,0,30.11,30.11,0,0,1-3.9-2.85.14.14,0,0,1,0-.2.13.13,0,0,1,.19,0,29.74,29.74,0,0,0,3.84,2.82.15.15,0,0,1,.06.19A.14.14,0,0,1,99.35,119.34Z"/>
                                                        <path class="cls-19" d="M100,118H100a18.13,18.13,0,0,1-3.35-2.32.13.13,0,0,1,0-.19.14.14,0,0,1,.2,0,17.89,17.89,0,0,0,3.28,2.27.14.14,0,0,1,.07.18A.13.13,0,0,1,100,118Z"/>
                                                        <path class="cls-19" d="M156.62,91.53a.11.11,0,0,1-.07,0,.13.13,0,0,1-.05-.19,2,2,0,0,1,2.39-.77.14.14,0,0,1-.12.26,1.64,1.64,0,0,0-2,.66A.15.15,0,0,1,156.62,91.53Z"/>
                                                        <path class="cls-16" d="M148.55,118.34h-.06a.15.15,0,0,1-.06-.19,13.17,13.17,0,0,1,4.36-4.69.15.15,0,0,1,.2,0,.14.14,0,0,1,0,.19,12.91,12.91,0,0,0-4.27,4.57A.13.13,0,0,1,148.55,118.34Z"/>
                                                    </g>
                                                </g>
                                                <g id="push">
                                                    <g class="rectangle">
                                                        <path class="cls-23" d="M177.34,26.62h50.8c1.14,0,2.06,1.24,2.06,2.78V42.1c0,1.54-.92,2.78-2.06,2.78H180l-4.69,4.84V29.4C175.29,27.86,176.21,26.62,177.34,26.62Z"/> 
                                                        <rect class="cls-30" x="214.91" y="29.41" width="12.11" height="12.11" rx="1.27" transform="translate(441.94 70.94) rotate(180)"/>
                                                        <path class="cls-7" d="M185.27,36.18a2.87,2.87,0,1,1-2.87-2.86A2.87,2.87,0,0,1,185.27,36.18Z"/>
                                                        <path class="cls-29" d="M182.4,37.72a.1.1,0,0,1-.07,0,.15.15,0,0,1-.07-.21l1.37-2.65a.15.15,0,0,1,.21-.07.16.16,0,0,1,.07.22l-1.37,2.65A.16.16,0,0,1,182.4,37.72Z"/>
                                                        <path class="cls-29" d="M182.4,37.72a.13.13,0,0,1-.1,0l-1.55-1.38a.16.16,0,1,1,.22-.24l1.54,1.38a.17.17,0,0,1,0,.23A.17.17,0,0,1,182.4,37.72Z"/>
                                                        <rect class="cls-34" x="188.96" y="32.92" width="22.69" height="1.69" rx="0.85"/>
                                                        <rect class="cls-34" x="199.02" y="37.33" width="12.63" height="1.27" rx="0.63"/>
                                                        <circle class="cls-7" cx="220.97" cy="33.68" r="1.83"/>
                                                        <path class="cls-7" d="M221,35.64a3.45,3.45,0,0,0-3.45,3.45h6.9A3.46,3.46,0,0,0,221,35.64Z"/>
                                                    </g>

                                                    <g class="rectangle">
                                                        <path class="cls-24" d="M209.77,73.64H272c1.38,0,2.51,1.52,2.51,3.41V92.6c0,1.88-1.13,3.4-2.51,3.4H213l-5.74,5.93V77.05C207.26,75.16,208.39,73.64,209.77,73.64Z"/>
                                                        <rect class="cls-32" x="258.18" y="77.79" width="13.64" height="13.64" rx="1.44" transform="translate(530.01 169.23) rotate(180)"/>
                                                        <circle class="cls-7" cx="215.97" cy="85.87" r="3.48"/>
                                                        <path class="cls-29" d="M216,87.71l-.07,0a.16.16,0,0,1-.07-.21l1.66-3.22a.15.15,0,0,1,.21-.07.16.16,0,0,1,.07.21l-1.66,3.22A.15.15,0,0,1,216,87.71Z"/>
                                                        <path class="cls-29" d="M216,87.71a.21.21,0,0,1-.11,0L214,86a.16.16,0,0,1,0-.23.16.16,0,0,1,.22,0l1.87,1.68a.16.16,0,0,1,0,.22A.16.16,0,0,1,216,87.71Z"/>
                                                        <rect class="cls-34" x="226.03" y="80.69" width="29.71" height="2.21" rx="1.11"/>
                                                        <rect class="cls-34" x="239.2" y="86.47" width="16.54" height="1.66" rx="0.83"/>
                                                        <circle class="cls-7" cx="265.01" cy="82.4" r="2.27"/>
                                                        <path class="cls-7" d="M265,84.83a4.28,4.28,0,0,0-4.28,4.28h8.56A4.28,4.28,0,0,0,265,84.83Z"/>
                                                    </g>
                                                    <g class="rectangle">
                                                        <path class="cls-25" d="M195.33,148.4h42.94c1,0,1.89-1.14,1.89-2.55V134.18c0-1.41-.85-2.55-1.89-2.55H197.75l-4.31-4.45v18.67C193.44,147.26,194.29,148.4,195.33,148.4Z"/>
                                                        <rect class="cls-33" x="227.82" y="134.42" width="10.16" height="10.16" rx="1.3" transform="translate(465.81 279) rotate(180)"/>
                                                        <path class="cls-7" d="M202,141a2.3,2.3,0,1,1-2.3-2.3A2.3,2.3,0,0,1,202,141Z"/>
                                                        <path class="cls-29" d="M199.69,142.23a.08.08,0,0,1-.07,0,.15.15,0,0,1-.07-.21l1.1-2.13a.15.15,0,0,1,.21-.07.16.16,0,0,1,.07.22l-1.1,2.13A.16.16,0,0,1,199.69,142.23Z"/>
                                                        <path class="cls-29" d="M199.69,142.23a.15.15,0,0,1-.11,0l-1.24-1.11a.16.16,0,0,1,0-.22.16.16,0,0,1,.23,0l1.23,1.11a.16.16,0,0,1,0,.23A.18.18,0,0,1,199.69,142.23Z"/>
                                                        <rect class="cls-34" x="203.02" y="136.59" width="22.69" height="1.69" rx="0.85"/>
                                                        <rect class="cls-34" x="213.08" y="141.01" width="12.63" height="1.27" rx="0.63"/>
                                                        <circle class="cls-7" cx="232.9" cy="138.19" r="1.35"/>
                                                        <path class="cls-7" d="M232.9,139.63a2.53,2.53,0,0,0-2.53,2.53h5.07A2.54,2.54,0,0,0,232.9,139.63Z"/>
                                                    </g>

                                                    <g class="rectangle">
                                                        <path class="cls-26" d="M103.45,165.57H51.74c-1.26,0-2.27-1.38-2.27-3.08V148.44c0-1.7,1-3.08,2.27-3.08h48.8l5.18-5.35v22.48C105.72,164.19,104.71,165.57,103.45,165.57Z"/>
                                                        <rect class="cls-28" x="54.05" y="149.13" width="10.82" height="10.82" rx="0.93"/>
                                                        <circle class="cls-7" cx="97.53" cy="155.96" r="2.84"/>
                                                        <path class="cls-29" d="M97.53,157.5a.12.12,0,0,1-.08,0,.16.16,0,0,1-.07-.23l1.35-2.62a.17.17,0,0,1,.23-.07.16.16,0,0,1,.07.23l-1.35,2.62A.16.16,0,0,1,97.53,157.5Z"/>
                                                        <path class="cls-29" d="M97.53,157.5a.19.19,0,0,1-.12,0l-1.52-1.37a.17.17,0,0,1,0-.24.19.19,0,0,1,.25,0l1.52,1.38a.17.17,0,0,1,0,.24A.21.21,0,0,1,97.53,157.5Z"/>
                                                        <rect class="cls-34" x="67.35" y="151.48" width="24.44" height="1.82" rx="0.91"/>
                                                        <rect class="cls-34" x="67.35" y="156.23" width="13.6" height="1.37" rx="0.68"/>
                                                        <circle class="cls-7" cx="59.46" cy="152.98" r="1.6"/>
                                                        <path class="cls-7" d="M59.46,154.69a3,3,0,0,0-3,3h6A3,3,0,0,0,59.46,154.69Z"/>
                                                    </g>
                                                    <g class="rectangle">
                                                        <path class="cls-27" d="M75,96.93H14.89c-1.34,0-2.43,1.47-2.43,3.29v15c0,1.82,1.09,3.3,2.43,3.3h57l5.55,5.72v-24C77.46,98.4,76.37,96.93,75,96.93Z"/>
                                                        <rect class="cls-28" x="16.51" y="100.97" width="13.78" height="13.78" rx="1.33"/>
                                                        <circle class="cls-7" cx="66.8" cy="107.85" r="3.36"/>
                                                        <path class="cls-29" d="M66.8,109.65l-.07,0a.17.17,0,0,1-.08-.23l1.6-3.11a.19.19,0,0,1,.24-.07.18.18,0,0,1,.07.23l-1.6,3.1A.18.18,0,0,1,66.8,109.65Z"/>
                                                        <path class="cls-29" d="M66.8,109.65a.16.16,0,0,1-.11-.05L64.88,108a.17.17,0,0,1,0-.24.16.16,0,0,1,.24,0l1.81,1.62a.17.17,0,0,1,0,.24A.16.16,0,0,1,66.8,109.65Z"/>
                                                        <rect class="cls-34" x="33.97" y="103.82" width="24.44" height="1.82" rx="0.91"/>
                                                        <rect class="cls-34" x="33.97" y="108.58" width="13.6" height="1.37" rx="0.68"/>
                                                        <circle class="cls-7" cx="23.4" cy="105.98" r="1.91"/>
                                                        <path class="cls-7" d="M23.4,108a3.61,3.61,0,0,0-3.6,3.61H27A3.61,3.61,0,0,0,23.4,108Z"/>
                                                    </g>
                                                    <g class="rectangle">
                                                        <path class="cls-22" d="M91.86,47.75H37.15c-1.22,0-2.21,1.34-2.21,3V64.42c0,1.66,1,3,2.21,3H89l5,5.21V50.75C94.07,49.09,93.08,47.75,91.86,47.75Z"/>
                                                        <rect class="cls-30" x="38.32" y="51.36" width="12.09" height="12.09" rx="1.28"/>
                                                        <path class="cls-7" d="M87.44,57.34a3.09,3.09,0,1,1-3.08-3.08A3.08,3.08,0,0,1,87.44,57.34Z"/>
                                                        <path class="cls-29" d="M84.36,59a.11.11,0,0,1-.08,0,.16.16,0,0,1-.07-.23l1.47-2.85a.17.17,0,0,1,.23-.07.18.18,0,0,1,.07.23l-1.47,2.85A.16.16,0,0,1,84.36,59Z"/>
                                                        <path class="cls-29" d="M84.36,59a.19.19,0,0,1-.12,0l-1.66-1.49a.17.17,0,0,1,.23-.26l1.66,1.49a.18.18,0,0,1,0,.25A.18.18,0,0,1,84.36,59Z"/>
                                                        <rect class="cls-34" x="54.42" y="54.39" width="24.44" height="1.82" rx="0.91"/>
                                                        <rect class="cls-34" x="54.42" y="59.14" width="13.6" height="1.37" rx="0.68"/>
                                                        <circle class="cls-7" cx="44.36" cy="55.62" r="1.83"/>
                                                        <path class="cls-7" d="M44.36,57.58A3.44,3.44,0,0,0,40.92,61h6.89A3.44,3.44,0,0,0,44.36,57.58Z"/>

                                                    </g>
                                                    
                                                    
                                                </g>
                                                <g id="_0" data-name="0">
                                                    <path class="cls-7" d="M131.52,34.44a.7.7,0,1,1-.7-.7A.7.7,0,0,1,131.52,34.44Z"/>
                                                    <circle class="cls-7" cx="215.09" cy="51.42" r="2.66"/>
                                                    <path class="cls-7" d="M99,175a1,1,0,1,1-1-1A1,1,0,0,1,99,175Z"/>
                                                    <circle class="cls-7" cx="104.2" cy="84.26" r="0.7"/>
                                                    <circle class="cls-7" cx="60.96" cy="131.54" r="1.5"/>
                                                    <path class="cls-7" d="M208.78,158.29a1,1,0,1,1-1-1A1,1,0,0,1,208.78,158.29Z"/>
                                                    <circle class="cls-7" cx="253.64" cy="119.81" r="0.7"/>
                                                    <circle class="cls-7" cx="122.81" cy="177.93" r="0.97"/>
                                                    <path class="cls-7" d="M111.72,26.66a.7.7,0,1,1-.7-.7A.7.7,0,0,1,111.72,26.66Z"/>
                                                    <circle class="cls-7" cx="26.23" cy="149.77" r="0.97"/>
                                                    <circle class="cls-7" cx="145.98" cy="27.34" r="2.16"/>
                                                    <path class="cls-7" d="M88.69,79.34a1.91,1.91,0,1,1,1.91-1.91A1.91,1.91,0,0,1,88.69,79.34Z"/>
                                                    <path class="cls-35 blink" d="M83,11.68c-2,1.21-4.34,1.08-5.15-.29S78,7.94,80.05,6.73,84.39,5.65,85.2,7,85,10.47,83,11.68Z"/>
                                                    <polygon class="cls-36 blink" points="251.91 1.14 253.83 4.7 259.12 2.33 254.86 6.29 257.33 9.5 253.67 7.75 250.43 12.47 251.91 7.08 248.03 5.93 252.01 5.19 251.91 1.14"/>
                                                    <polygon class="cls-37 blink" points="199.51 185.12 205.78 175.89 197.37 172.09 207.43 173.09 211.94 162.39 210.26 173.14 219.74 170.97 210.35 175.96 211.04 181.84 207.58 177.66 199.51 185.12"/>
                                                    <polygon class="cls-38 blink" points="118.62 0 116.61 4.86 121.78 6.77 116.14 6.33 115.32 11.95 114.59 6.34 109.75 7.55 114.11 4.87 112.84 1.81 115.36 3.96 118.62 0"/>
                                                    <circle class="cls-39 blink" cx="42.4" cy="74.56" r="3.37"/>
                                                    <path class="cls-7" d="M44.19,74.68a1,1,0,0,0,.17-.58,1.09,1.09,0,0,0-2-.65,1.12,1.12,0,0,0-.88-.44,1.09,1.09,0,0,0-1.09,1.09,1,1,0,0,0,.17.58l.11.14.07.08,1.63,1.7L44,74.89l.06-.06Z"/>
                                                    <polygon class="cls-40 blink" points="12.81 137.38 9.12 141.01 12.36 145.24 7.53 142.84 4.45 147 5.31 141.89 0 140.12 5.52 139.48 5.56 134.3 7.87 138.94 12.81 137.38"/>
                                                    <polygon class="cls-41 blink" points="15.86 19.65 14.1 21.38 15.64 23.39 13.35 22.25 11.88 24.23 12.29 21.8 9.76 20.95 12.39 20.65 12.41 18.19 13.51 20.39 15.86 19.65"/>
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

            <!--   section2 -->
            <section id="section2" class="section">
                <div class="section_child1">
                    <div class="container">
                        <div class="position-relative">
                            <div class="row justify-content-center align-items-center my-5">
                               <div class="col-lg-9 col-md-10 col-sm-12">
                                    <div class="text-center align-middle que_background_img">
                                        <h1 class="font-700 color-text-gradient">Where do most of your marketing money go?</h1>
                                    </div> 
                                    <span class="money_image money_image_1"> <img src="{{ asset('assets/front/images/features_landing_pages/money2.svg') }}"></span>       
                                    <span class="money_image money_image_2"><img src="{{ asset('assets/front/images/features_landing_pages/money.svg') }}"></span>       
                                    <span class="money_image money_image_3"><img src="{{ asset('assets/front/images/features_landing_pages/money.svg') }}"></span>       
                                    <span class="money_image money_image_4"><img src="{{ asset('assets/front/images/features_landing_pages/money.svg') }}"></span>        
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
                               <div class="col-lg-9 col-md-10 col-sm-12">
                                    <div class="text-center que_background_img">
                                        <h1 class="font-700 color-text-gradient">Does it bring you the expected result?</h1>      
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
                               <div class="col-lg-9 col-md-10 col-sm-12">
                                    <div class="text-center que_background_img">
                                        <h1 class="font-700 color-text-gradient">Do you have an analysis of each penny invested?</h1>      
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
                               <div class="col-lg-9 col-md-10 col-sm-12">
                                    <div class="text-center que_background_img">
                                        <h1 class="font-700 color-text-gradient">Want to save big on your marketing budget even with desired fruitful results?</h1>      
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
                            <div class="row justify-content-center align-items-center my-5">
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
            <!-- section7 -->
           <section id="section7" class="section">
                <div class="section_child1">
                    <div class="container">
                        <div class="position-relative">
                            <div class="row my-5 justify-content-center align-items-center">
                                <div class="col-lg-10 col-md-8 col-sm-12">
                                    <div class="text-center">
                                        <div class="" style="line-height: 1;">
                                            <span class="d-block h5" style="line-height: 1.2;">Well, then we are here to help you save and take great marketing moves with Share & Reward.Today sharing and availing the benefit in the future is one of the trendy features</span>
                                            <span class="h1 font-900 color-text-gradient text-uppercase d-block"> Through OPENLINK, a mouth publicity media, you can create, share and reward your customer very smoothl</span>
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
            <!-- section8 -->
          <section id="section8" class="section">
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
        <!-- section 9 -->
            <section id="section9" class="section">
                <div class="container">
                    <div class="position-relative">
                        <div class="row justify-content-center my-5">
                           <div class="col-lg-9 col-md-10 col-sm-12">
                                <div class="text-center pb-3">
                                   <h1 class="text-uppercase">OPENLINK'S Share & Reward is all your answers!</h1>
                                   <p>One can easily create offers based on future giveaways. It can be cash-per-click, a percentage discount or a fixed amount then set a target and share it with customers with an open link. Share & Reward offers are the ones that are beneficial for the customers at the same time for your business too!</p>
                                </div>  
                                <div class="text-center my-5">
                                   <h1 class="text-uppercase">how?</h1> 
                                   <p>Once you set a Share target for content, the customer tends to share in their network, which directly creates trust and brings your next customer. OPENLINK'S Share & Reward helps you market your business through your customers.</p>
                                   <p>Easily create the link with the content you want to promote and expand your business. Now, share it with your customers and ask your customers to promote it. Once the basic promotion criteria are fulfilled, give them some benefit in the future through your business.</p>
                                </div> 
                                <div class="text-center pb-3">
                                   <h1 class="text-uppercase">Why Share & Reward for your business?</h1>
                                   <p>Mouth Publicity is one of the most traditional marketing practices used to draw in organic traffic. OPENLINK with Share & Reward feature supports Digital Mouth Publicity media, where your own customer shares about your business in their network through WhatsApp and grows your brand’s awareness & visibility.</p>
                                </div>      
                                <div class="bg_options mb-4">
                                    <div class="background_number d-inline ms-3"><i class="bi bi-caret-right-fill"></i></div>
                                    <h5 class="d-inline ms-2">Saves on your costly paid ads to bring more customerss.</h5>
                                </div>
                                <div class="bg_options mb-4">
                                    <div class="background_number d-inline ms-3"><i class="bi bi-caret-right-fill"></i></div>
                                    <h5 class="d-inline ms-2">Saves your time.</h5>
                                </div>
                                <div class="bg_options mb-4">
                                    <div class="background_number d-inline ms-3"><i class="bi bi-caret-right-fill"></i></div>
                                    <h5 class="d-inline ms-2">Your marketing budget is spent on your own customers.</h5>
                                </div>        
                                <div class="bg_options mb-4">
                                    <div class="background_number d-inline ms-3"><i class="bi bi-caret-right-fill"></i></div>
                                    <h5 class="d-inline ms-2">Your customers bring you your next customer.</h5>
                                </div> 
                                <div class="bg_options mb-4">
                                    <div class="background_number d-inline ms-3"><i class="bi bi-caret-right-fill"></i></div>
                                    <h5 class="d-inline ms-2">Help you build trust in potential customer networks.</h5>
                                </div> 
                           </div>
                        </div>
                    </div>
                </div>   
                <div class="oplk-bg-color-gradient w-100">
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                           <div class="col-lg-9 px-0">
                                <div class="text-center text-white py-4">
                                    <h2 class="font-700">How to create a Share & Reward offer?</h2>
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
                                            <h5>  Here you are landed to OPENLINK dashboard click to Share & Reward</h5>
                                        </div>
                                    </div>
                                </div> 
                                <!-- circle3 -->
                                <div class="circle_img_right mb-5">
                                    <img src="{{ asset('assets/front/images/features_landing_pages/arrow_left.svg') }}"> 
                                    <div class="steps_circle">
                                        <div class="text-center inside_circle">
                                            <h1 class="text-uppercase color-text-gradient font-900">Step 3</h1>
                                            <h5>Select offer category as per your business strategy</h5> 
                                        </div>
                                    </div>
                                </div>
                                <!-- circle4 -->
                                <div class="circle_img_right mb-5">
                                    <img src="{{ asset('assets/front/images/features_landing_pages/arrow_left.svg') }}"> 
                                    <div class="steps_circle">
                                        <div class="text-center inside_circle">
                                            <h1 class="text-uppercase color-text-gradient font-900">Step 3</h1>
                                            <h5>Fill in the offer and business-related details as per your business offer strategy & click on the save & publish button</h5> 
                                        </div>
                                    </div>
                                </div>
                                <!-- circle5 -->
                                <div class="circle_img_right mb-5">
                                    <img src="{{ asset('assets/front/images/features_landing_pages/arrow_left.svg') }}"> 
                                    <div class="steps_circle">
                                        <div class="text-center inside_circle">
                                            <h1 class="text-uppercase color-text-gradient font-900">Step 3</h1>
                                            <h5>You are all ready to share, click on subscribe and share it with your customers</h5> 
                                        </div>
                                    </div>
                                </div>
                                <!-- circle6 -->
                                <div class="circle_img_right mb-5">
                                    <img src="{{ asset('assets/front/images/features_landing_pages/arrow_left.svg') }}"> 
                                    <div class="steps_circle">
                                        <div class="text-center inside_circle">
                                            <h1 class="text-uppercase color-text-gradient font-900">Step 3</h1>
                                            <h5>That’s it!!</h5> 
                                        </div>
                                    </div>
                                </div>
                           	<h6 style="margin-top: 120px;">Wish to bring your next customer through your own customers.</h6>    
                            <button class="btn-theme btn-sm-lg text-uppercase">Buy share & reward Now</button> 
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