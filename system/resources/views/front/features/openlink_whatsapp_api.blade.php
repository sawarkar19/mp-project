@extends('layouts.front')

@section('title', 'Openlink Whatsapp API | OpenLink ')
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
   #section1 p{
     margin-top: 30px;
   }
    #section1 .card{
        padding: 30px 20px;
        box-shadow: 5px 5px 8px #bebebe;
        border-style: none;
        background: rgba(240, 240, 240, 0.6);
    }   
   .text_img{
        width: 101px;
        height: 176px;
        position: absolute;
        right: -57px;
        top: -14px;
   }
    /*.text_img:after{
        content: '';
        background-image: url({{ asset('assets/front/images/features_landing_pages/only_one_rupes.svg') }});
        position: absolute;
	    top: -25px;
	    right: 36px;
	    background-repeat: no-repeat;
	    width: 60px;
	    height: 60px;
        z-index: -1;
    }*/*/
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
        margin-right: 10px
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
    .card_part .card{
        min-height: 320px;
        padding: 10px 0;
        border-style: none;
    }
    .step{
        color:#707070;
    }
    .whatsapp_icon{
        margin-top: 70px;
        animation: wp_icon 5s infinite;
        -webkit-animation: wp_icon 5s infinite;
    }
    .logo{
        position: relative;
    }
    .logo img{
        position: absolute;
    }
    
    @keyframes wp_icon {
      0% {transform: translateX(0px);}
      50% {transform: translateX(30px);}
      100% {transform: translateX(0px);}
    }
    @-webkit-keyframes wp_icon {
        0% {transform: translateX(0px);}
      50% {transform: translateX(30px);}
      100% {transform: translateX(0px);}
    }
    .text_animation{
        animation: textR 3s;
        -webkit-animation: textR 3s;
    }
     @keyframes textR {
      0% {transform: translateX(-140px);}
      100% {transform: translateX(0px);}
    }
    @-webkit-keyframes textR {
        0% {transform: translateX(-140px);}
      100% {transform: translateX(0px);}
    }
    .oneRupees{
        animation: oneR 3s;
        -webkit-animation: oneR 3s;
    }
     @keyframes oneR {
      0% {transform: translateX(140px);}
      100% {transform: translateX(0px);}
    }
    @-webkit-keyframes oneR {
        0% {transform: translateX(140px);}
      100% {transform: translateX(0px);}
    }
    .card1{
         animation: card_left 3s;
        -webkit-animation: card_left 3s;
    }
     @keyframes card_left {
      0% {transform: translateX(-400px);}
      100% {transform: translateX(0px);}
    }
    @-webkit-keyframes card_left {
        0% {transform: translateX(-400px);}
      100% {transform: translateX(0px);}
    }
    .card2{
         animation: card_right 3s;
        -webkit-animation: card_right 3s;
    }
     @keyframes card_right {
      0% {transform: translateX(400px);}
      100% {transform: translateX(0px);}
    }
    @-webkit-keyframes card_right {
        0% {transform: translateX(400px);}
      100% {transform: translateX(0px);}
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
    @media(min-width: 769px) and (max-width: 991px){
        .text_img img{
            width: 220px;
            height: 205px;
            position: absolute;
            right: 0;
            top: 64px;
            z-index: -1;
        }
    }    
    @media(max-width: 768px){
       /* .text_img img{
            width: 160px;
            height: 150px;
            right: -26px;
            top: 51px;
        }
        #section1 p {
            margin-top: 65px;
        } */   
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
        /* .text_img img{
            width: 160px;
            height: 150px;
            right: -26px;
            top: 51px;
        }*/
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
                                <div class="whatsapp_icon">
                                    <img src="{{ asset('assets/front/images/features_landing_pages/whtasapp.svg') }}" style="max-width: 50px;opacity: 0.5">
                                </div>
                                <div class="row justify-content-center align-items-center">
                                    <div class="col-lg-9 col-md-10 col-sm-12">
                                        <div class="align-middle text-center position-relative">
                                            <div class="card">
                                                <div class="card-body">
                                                   <h1 class="font-700 color-text-gradient">Send Messages to your customer’s WhatsApp - Only at ₹1 /day</h1>
                                                    <p class="card-text">Send alerts, greetings, new arrivals, updates, and order receipts directly to your customer’s WhatsApp. Integrate OPENLINK'S WhatsApp API Solution with your billing software or POS, get unlimited WhatsApp messages at only 1 Rupee per day.</p>
                                                </div>  
                                                    <img src="{{ asset('assets/front/images/features_landing_pages/only_one_rupes.svg') }}" class="text_img rupees_tag"> 
                                            </div>
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
                                    <div class="text-center align-middle">
                                        <h1 class="font-700 color-text-gradient">Do you use a Billing Software or POS system in your business billing?</h1>
                                        <div class="text-center billing_img">
                                          <!-- <img src="{{ asset('assets/front/images/features_landing_pages/billing_software.svg') }}" style="max-width: 320px;"> --> 
                                          <svg xmlns="http://www.w3.org/2000/svg" width="320px" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 341.65 302.2">
                                            <defs>
                                                <style>
                                                    .man{
                                                        animation: ani_left 2s;
                                                        -webkit-animation: ani_left 2s;
                                                    }
                                                    @keyframes ani_left {
                                                      0% {transform: translateX(50px);}
                                                      100% {transform: translateX(0px);}
                                                    }
                                                    @-webkit-keyframes ani_left {
                                                        0% {transform: translateX(50px);}
                                                      100% {transform: translateX(0px);} 
                                                    }
                                                    .woman_hand, .man_hand{
                                                      animation: moving_man 3s infinite;
                                                       -webkit-animation: moving_man 3s infinite;
                                                    }
                                                    @keyframes moving_man {
                                                      0% {transform: translateX(0px);}
                                                      50% {transform: translateX(5px);}
                                                      100% {transform: translateX(0px);}
                                                    }
                                                    @-webkit-keyframes moving_man {
                                                        0% {transform: translateX(0px);}
                                                        50% {transform: translateX(5px);}
                                                        100% {transform: translateX(0px);} 
                                                    }
                                                    .cls-1{fill:#cecece;}.cls-1,.cls-2{isolation:isolate;}.cls-1,.cls-2,.cls-6{opacity:0.5;}.cls-2,.cls-5{fill:#e0e0e0;}.cls-3{opacity:0.7;}.cls-20,.cls-29,.cls-4{fill:#fff;}.cls-7{fill:#e2d893;}.cls-11,.cls-15,.cls-16,.cls-17,.cls-20,.cls-23,.cls-24,.cls-27,.cls-29,.cls-7{stroke:#263238;}.cls-11,.cls-13,.cls-15,.cls-16,.cls-17,.cls-20,.cls-7{stroke-linecap:round;stroke-linejoin:round;}.cls-11,.cls-17,.cls-23,.cls-8{fill:#263238;}.cls-9{fill:#ffbe9d;}.cls-10{fill:url(#linear-gradient);}.cls-12{fill:url(#linear-gradient-2);}.cls-13,.cls-15,.cls-16,.cls-27{fill:none;}.cls-13{stroke:#fff;}.cls-14{fill:#f4ad8e;}.cls-16{stroke-width:0.75px;}.cls-17{stroke-width:1px;}.cls-18,.cls-23,.cls-24,.cls-27,.cls-29{stroke-miterlimit:10;}.cls-18{fill:url(#linear-gradient-3);stroke:url(#linear-gradient-4);}.cls-19{fill:url(#linear-gradient-5);}.cls-21{fill:url(#linear-gradient-6);}.cls-22{fill:url(#linear-gradient-7);}.cls-24{fill:#6e6e6e;}.cls-25{fill:url(#linear-gradient-8);}.cls-26{fill:url(#linear-gradient-9);}.cls-28{fill:url(#linear-gradient-10);}.cls-30{fill:url(#linear-gradient-11);}
                                                </style>
                                                <linearGradient id="linear-gradient" x1="29.17" y1="114.1" x2="65.42" y2="114.1" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#00ffaf"/><stop offset="0.06" stop-color="#00edad"/><stop offset="0.32" stop-color="#00a6a7"/><stop offset="0.55" stop-color="#006ea2"/><stop offset="0.75" stop-color="#00469f"/><stop offset="0.91" stop-color="#002d9d"/><stop offset="1" stop-color="#00249c"/></linearGradient><linearGradient id="linear-gradient-2" x1="27.71" y1="115.98" x2="58.2" y2="115.98" xlink:href="#linear-gradient"/><linearGradient id="linear-gradient-3" x1="59.36" y1="212.67" x2="175.76" y2="212.67" xlink:href="#linear-gradient"/><linearGradient id="linear-gradient-4" x1="58.86" y1="212.67" x2="176.26" y2="212.67" xlink:href="#linear-gradient"/><linearGradient id="linear-gradient-5" x1="30.26" y1="113.28" x2="59.12" y2="113.28" xlink:href="#linear-gradient"/><linearGradient id="linear-gradient-6" x1="214.11" y1="140.52" x2="236.05" y2="140.52" xlink:href="#linear-gradient"/><linearGradient id="linear-gradient-7" x1="249.35" y1="281.98" x2="275.84" y2="281.98" xlink:href="#linear-gradient"/><linearGradient id="linear-gradient-8" x1="234.43" y1="280.88" x2="265.26" y2="280.88" xlink:href="#linear-gradient"/><linearGradient id="linear-gradient-9" x1="234.1" y1="147.2" x2="276.19" y2="147.2" xlink:href="#linear-gradient"/><linearGradient id="linear-gradient-10" x1="236.36" y1="115.34" x2="269.29" y2="115.34" xlink:href="#linear-gradient"/><linearGradient id="linear-gradient-11" x1="222.61" y1="142.08" x2="266.31" y2="142.08" xlink:href="#linear-gradient"/>
                                            </defs>
                                            <g id="Layer_2" data-name="Layer 2">
                                                <g id="Layer_1-2" data-name="Layer 1">
                                                    <g id="background">
                                                        <rect class="cls-1" x="145.13" y="166.79" width="41.82" height="35.92"/>
                                                        <rect class="cls-1" x="145.13" y="124.08" width="41.82" height="35.92"/>
                                                            <rect class="cls-1" x="145.13" y="37.94" width="41.82" height="36.66"/>
                                                            <rect class="cls-1" x="145.13" y="81.38" width="41.82" height="35.92"/>
                                                            <path class="cls-1" d="M306.74,83.68H271.28V34.83q-2.34-2.13-4.74-4.14V89.37h42.65Q308.07,86.52,306.74,83.68Z"/>
                                                            <path class="cls-1" d="M282.82,46.61c-3.11-3.54-6.39-6.93-9.77-10.15h-.12V82.05H306A151.57,151.57,0,0,0,282.82,46.61Z"/>
                                                            <rect class="cls-1" x="194.46" y="209.5" width="41.82" height="37.4"/>
                                                            <path class="cls-1" d="M105.32,39.28c-1.58,1.27-3.15,2.53-4.74,3.77V83.68H58V69.78c-1.63.92-3.19,1.83-4.74,2.74V89.38h52.11Z"/>
                                                            <path class="cls-1" d="M99,44.33C90.74,50.75,82.34,56.77,73.3,61.49,68.53,64,64,66.44,59.58,68.88V82.07H99Z"/>
                                                            <path class="cls-1" d="M145.13,224.26c14.19,5.06,26.94,14.66,40.6,22.63H187V209.5H145.13Z"/>
                                                            <rect class="cls-1" x="194.46" y="81.38" width="41.82" height="35.92"/>
                                                            <rect class="cls-1" x="194.46" y="124.08" width="41.82" height="35.92"/>
                                                            <path class="cls-1" d="M242.92,30.61H138.51V222.28q2.52.6,5,1.43V207.87h45.07v40.65h0a118.81,118.81,0,0,0,11.54,5.7h42.81ZM188.57,204.34H143.5V165.16h45.07Zm0-42.7H143.5V122.46h45.07Zm0-42.71H143.5V79.75h45.07Zm0-42.71H143.5V36.31h45.07Zm49.34,172.3H192.83V207.87h45.08Zm0-44.18H192.83V165.16h45.08Zm0-42.7H192.83V122.46h45.08Zm0-42.71H192.83V79.75h45.08Zm0-42.71H192.83V36.31h45.08Z"/>
                                                            <rect class="cls-1" x="194.46" y="166.79" width="41.82" height="35.92"/>
                                                            <path class="cls-2" d="M264.91,91V29.37C243.43,11.94,217.26,1,189.45.09,154.17-1,130.56,18.9,107,37.94V91H51.58V73.48c-26.33,15.85-44,33.23-47.66,64.32-4.68,39-.82,75.49,31.18,93.75s51.44-12.45,92.76-10.79a54.81,54.81,0,0,1,9,1.14V29H244.55v226.9H204.24a64.5,64.5,0,0,0,41.71,1.4c34.11-9.82,59.4-45.85,68.91-80.51,8.06-29.4,5.33-59.21-5-85.76Z"/>
                                                            <rect class="cls-1" x="194.46" y="37.94" width="41.82" height="36.66"/>
                                                            <g class="cls-3">
                                                                <rect class="cls-4" x="145.13" y="166.74" width="41.82" height="35.92"/>
                                                                <rect class="cls-4" x="145.13" y="124.04" width="41.82" height="35.92"/>
                                                                <rect class="cls-4" x="145.13" y="37.89" width="41.82" height="36.66"/>
                                                                <rect class="cls-4" x="145.13" y="81.33" width="41.82" height="35.92"/>
                                                                <path class="cls-4" d="M306.74,83.64H271.28V34.78c-1.56-1.42-3.14-2.79-4.74-4.13V89.33h42.65Q308.07,86.47,306.74,83.64Z"/>
                                                                <path class="cls-4" d="M282.82,46.56c-3.11-3.54-6.39-6.93-9.77-10.15h-.12V82H306A151.43,151.43,0,0,0,282.82,46.56Z"/>
                                                                <rect class="cls-4" x="194.46" y="209.45" width="41.82" height="37.4"/>
                                                                <path class="cls-4" d="M105.32,39.24c-1.58,1.26-3.15,2.52-4.74,3.77V83.64H58V69.74c-1.63.91-3.19,1.82-4.74,2.73V89.33h52.11Z"/>
                                                                <path class="cls-4" d="M99,44.28C90.74,50.7,82.34,56.72,73.3,61.44c-4.77,2.51-9.35,5-13.72,7.39V82H99Z"/>
                                                                <path class="cls-4" d="M145.13,224.21c14.19,5.07,26.94,14.66,40.6,22.64H187v-37.4H145.13Z"/>
                                                                <rect class="cls-4" x="194.46" y="81.33" width="41.82" height="35.92"/>
                                                                <rect class="cls-4" x="194.46" y="124.04" width="41.82" height="35.92"/>
                                                                <path class="cls-4" d="M242.92,30.56H138.51V222.23q2.52.6,5,1.43V207.82h45.07v40.66h0a118.72,118.72,0,0,0,11.54,5.69h42.81ZM188.57,204.3H143.5V165.11h45.07Zm0-42.71H143.5V122.41h45.07Zm0-42.71H143.5V79.7h45.07Zm0-42.7H143.5V36.26h45.07Zm49.34,172.3H192.83V207.82h45.08Zm0-44.18H192.83V165.11h45.08Zm0-42.71H192.83V122.41h45.08Zm0-42.71H192.83V79.7h45.08Zm0-42.7H192.83V36.26h45.08Z"/>
                                                                <rect class="cls-4" x="194.46" y="166.74" width="41.82" height="35.92"/>
                                                                <path class="cls-4" d="M264.91,91V29.32C243.43,11.89,217.26.94,189.45.05,154.17-1.09,130.56,18.86,107,37.89V90.94H51.58V73.43c-26.33,15.86-44,33.23-47.66,64.33-4.68,39-.82,75.48,31.18,93.74s51.44-12.44,92.76-10.79a54.81,54.81,0,0,1,9,1.14V28.94H244.55v226.9H204.24a64.63,64.63,0,0,0,41.71,1.4c34.11-9.83,59.4-45.86,68.91-80.52,8.06-29.4,5.33-59.2-5-85.76Z"/>
                                                                <rect class="cls-4" x="194.46" y="37.89" width="41.82" height="36.66"/>
                                                            </g>
                                                        </g>
                                                        <g id="Ground">
                                                            <ellipse class="cls-5" cx="170.82" cy="282.32" rx="170.82" ry="19.88"/>
                                                            <ellipse class="cls-2" cx="170.82" cy="282.32" rx="170.82" ry="19.88"/>
                                                        </g>
                                                        <g id="Plants">
                                                            <path class="cls-5" d="M283.94,160c1.63.71,5.62.62,5.62.62s-.86-2.61-.93-2.77c-.87-1.84-3.64-4.89-5.9-4.56a2.69,2.69,0,0,0-2.22,3.09l.06.29C281,158.21,282.54,159.37,283.94,160Z"/>
                                                            <path class="cls-5" d="M336.22,146.39c-2.27-.24-5,2.85-5.77,4.71-.08.16-.91,2.79-.87,2.79h.05c-.42.49-.88,1-1.36,1.63-.89,1.09-1.87,2.33-2.86,3.75a48,48,0,0,0-3,4.72,35,35,0,0,0-2.53,5.7v-2.6c-.26-2-2-5.75-4.19-6.17a2.7,2.7,0,0,0-3.07,2.27l0,.26c-.13,1.63,1,3.2,2.16,4.22,1.28,1.13,4.82,2.24,5.11,2.33a45.11,45.11,0,0,0-1.5,6.17c-.22,1.22-.4,2.44-.56,3.69v-1.17c-.27-2-1.95-5.74-4.19-6.16a2.68,2.68,0,0,0-3.07,2.24,1.43,1.43,0,0,0,0,.29c-.13,1.63,1,3.2,2.16,4.21s4.15,2,4.95,2.28c-.07.48-.13,1-.18,1.43-.28,2.28-.54,4.56-.87,6.79-.11.81-.26,1.55-.4,2.32v-1c-.26-2-1.94-5.75-4.18-6.16a2.68,2.68,0,0,0-3.07,2.25,1.27,1.27,0,0,0,0,.28c-.13,1.63,1,3.2,2.16,4.21a16.79,16.79,0,0,0,4.8,2.24c-.17.81-.33,1.56-.53,2.32-.15.5-.25,1-.42,1.51s-.33,1-.48,1.5c-.35.94-.7,1.9-1.05,2.82-.24.62-.48,1.23-.73,1.83.12-.82.33-2.31.33-2.44a10.29,10.29,0,0,0-1.4-5.08,3,3,0,0,0,0-.6,2.69,2.69,0,0,0-3-2.33l-.24,0c-2.2.59-3.59,4.45-3.7,6.48,0,.12.07,1.42.14,2.24-.11-.48-.21-.94-.33-1.43-.23-1-.49-1.94-.76-3-.16-.5-.31-1-.46-1.51s-.36-1-.54-1.54c-.43-1.18-.92-2.37-1.45-3.55.81-.2,3.86-1,5.07-1.89a5.65,5.65,0,0,0,2.44-4.08,2.7,2.7,0,0,0-2.61-2.76h-.29c-2.27.25-4.23,3.85-4.64,5.83,0,.13-.16,1.59-.22,2.4-.32-.71-.64-1.42-1-2.13-1-2-2.09-4.07-3.17-6.09-.33-.62-.65-1.24-1-1.86.3-.07,3.9-.91,5.25-1.94,1.2-.93,2.48-2.44,2.44-4.07a2.69,2.69,0,0,0-2.62-2.77h-.29c-2.26.24-4.22,3.85-4.63,5.84,0,.14-.22,2.24-.24,2.78-.72-1.37-1.41-2.74-2-4.12a46.32,46.32,0,0,1-2.21-5.7c.14,0,3.9-.89,5.28-2a5.63,5.63,0,0,0,2.44-4.07,2.69,2.69,0,0,0-2.61-2.77h-.29c-2.27.25-4.22,3.85-4.64,5.84,0,.16-.23,2.44-.24,2.83a1.57,1.57,0,0,0-.11-.35,33.48,33.48,0,0,1-1.15-6.05c-.13-1.13-.19-2.21-.22-3.25.72-.09,4-.52,5.34-1.35s2.73-2.15,2.89-3.74a2.68,2.68,0,0,0-2.28-3,1.85,1.85,0,0,0-.41,0c-2.27,0-4.62,3.35-5.24,5.29,0,.1-.27,1.2-.42,2v-1.44c0-1.71.1-3.25.22-4.69.06-.81.13-1.5.22-2.17a18,18,0,0,0,4.07-3.63c.81-1.33,1.43-3.17.81-4.66a2.69,2.69,0,0,0-3.44-1.63l-.26.11c-2,1-2.51,5.1-2.14,7.13,0,.17.81,2.83.81,2.8h0c-.09.64-.17,1.33-.25,2.09-.14,1.39-.29,3-.33,4.69a49.27,49.27,0,0,0,.13,5.57,35.71,35.71,0,0,0,1,6.16v.07c-.36-.56-1.41-2.1-1.51-2.21-1.33-1.53-4.8-3.72-6.89-2.84A2.7,2.7,0,0,0,281,169l.13.25c.78,1.41,2.63,2.1,4.13,2.32,1.7.25,5.25-.81,5.54-.87a48.44,48.44,0,0,0,2.16,6c.49,1.14,1,2.26,1.56,3.38l-.66-1c-1.33-1.54-4.8-3.72-6.9-2.83a2.69,2.69,0,0,0-1.32,3.56c0,.09.09.17.14.26.77,1.41,2.62,2.11,4.12,2.32s4.58-.6,5.38-.82c.22.44.42.87.64,1.29,1,2.05,2.07,4.07,3,6.14.34.72.64,1.43.95,2.15-.28-.42-.53-.77-.57-.82-1.33-1.53-4.8-3.72-6.89-2.83a2.69,2.69,0,0,0-1.33,3.57,2.1,2.1,0,0,0,.13.26c.77,1.4,2.63,2.1,4.13,2.32a15.64,15.64,0,0,0,5.23-.82c.3.75.6,1.49.82,2.24.15.5.35,1,.48,1.49s.28,1,.42,1.52c.23,1,.48,2,.69,2.92.14.66.26,1.3.4,1.93-.33-.72-1-2.11-1.07-2.21-1.08-1.72-4.18-4.41-6.38-3.85a2.7,2.7,0,0,0-1.86,3.32c0,.09.06.18.1.27.55,1.52,2.28,2.45,3.73,2.93,1.62.49,5.13,0,5.56,0,.22,1.06.41,2.08.58,3.06.6,3.37,1,6.21,1.2,8.19a6.83,6.83,0,0,0,.11,1h-6.85l2.5,48.75h11.66l2.5-48.75h-6.31l.14-.29c.87-1.83,2.09-4.45,3.4-7.65.41-1,.81-2.1,1.27-3.26.42.09,3.92.82,5.55.43s3.26-1.17,3.93-2.63a2.68,2.68,0,0,0-1.2-3.6l-.28-.12c-2.15-.72-5.44,1.72-6.65,3.36-.07.1-.72,1.23-1.12,1.94.17-.45.34-.9.51-1.37.34-.94.66-1.88,1-2.9l.45-1.51c.15-.5.27-1.05.41-1.57.29-1.24.53-2.49.74-3.77.81.3,3.75,1.32,5.27,1.21s3.42-.66,4.29-2a2.69,2.69,0,0,0-.67-3.75l-.24-.15c-2-1-5.64.88-7.08,2.32-.09.09-1,1.23-1.5,1.87.12-.77.24-1.54.34-2.31.28-2.26.5-4.56.72-6.84.06-.7.15-1.4.22-2.09.28.11,3.74,1.39,5.45,1.28,1.51-.11,3.41-.67,4.29-2a2.68,2.68,0,0,0-.66-3.74l-.25-.16c-2-1-5.64.88-7.08,2.31-.11.11-1.43,1.76-1.74,2.19.16-1.54.34-3.06.58-4.57a45.86,45.86,0,0,1,1.31-6c.13,0,3.73,1.41,5.48,1.29,1.51-.11,3.41-.66,4.29-2a2.71,2.71,0,0,0-.67-3.76l-.24-.14c-2-1-5.65.88-7.08,2.31-.11.1-1.53,1.88-1.77,2.22a1.64,1.64,0,0,1,.09-.35,35.93,35.93,0,0,1,2.38-5.7c.52-1,1.07-1.94,1.63-2.85.64.33,3.61,1.76,5.19,1.83s3.46-.29,4.48-1.53a2.68,2.68,0,0,0-.23-3.78l-.24-.19c-1.89-1.26-5.7.25-7.29,1.51-.09.08-.89.88-1.46,1.46.26-.41.51-.81.77-1.2.94-1.44,1.9-2.69,2.77-3.79.49-.63.95-1.18,1.38-1.69.82,0,4-.12,5.42-.78s2.94-1.84,3.26-3.41a2.69,2.69,0,0,0-2-3.25Zm-25,60.74c-1.37,3.14-2.63,5.7-3.53,7.5l-.5,1H307c-.05-.35-.1-.74-.15-1.16-.28-2-.71-4.89-1.39-8.26-.21-1.06-.45-2.21-.72-3.38a32.59,32.59,0,0,0,3.11-1.46,19.59,19.59,0,0,0,4.53,2.92c-.4,1-.81,2-1.2,2.87Z"/>
                                                            <path class="cls-5" d="M324.35,160.89s.72-2.66.75-2.83c.27-2-.37-6.06-2.45-7.05a2.69,2.69,0,0,0-3.56,1.36c0,.09-.07.18-.1.27-.55,1.51.15,3.36,1,4.63C320.92,158.73,324.3,160.89,324.35,160.89Z"/>
                                                            <g class="cls-6">
                                                                <path class="cls-5" d="M283.94,160c1.63.71,5.62.62,5.62.62s-.86-2.61-.93-2.77c-.87-1.84-3.64-4.89-5.9-4.56a2.69,2.69,0,0,0-2.22,3.09l.06.29C281,158.21,282.54,159.37,283.94,160Z"/>
                                                                <path class="cls-5" d="M336.22,146.39c-2.27-.24-5,2.85-5.77,4.71-.08.16-.91,2.79-.87,2.79h.05c-.42.49-.88,1-1.36,1.63-.89,1.09-1.87,2.33-2.86,3.75a48,48,0,0,0-3,4.72,35,35,0,0,0-2.53,5.7v-2.6c-.26-2-2-5.75-4.19-6.17a2.7,2.7,0,0,0-3.07,2.27l0,.26c-.13,1.63,1,3.2,2.16,4.22,1.28,1.13,4.82,2.24,5.11,2.33a45.11,45.11,0,0,0-1.5,6.17c-.22,1.22-.4,2.44-.56,3.69v-1.17c-.27-2-1.95-5.74-4.19-6.16a2.68,2.68,0,0,0-3.07,2.24,1.43,1.43,0,0,0,0,.29c-.13,1.63,1,3.2,2.16,4.21s4.15,2,4.95,2.28c-.07.48-.13,1-.18,1.43-.28,2.28-.54,4.56-.87,6.79-.11.81-.26,1.55-.4,2.32v-1c-.26-2-1.94-5.75-4.18-6.16a2.68,2.68,0,0,0-3.07,2.25,1.27,1.27,0,0,0,0,.28c-.13,1.63,1,3.2,2.16,4.21a16.79,16.79,0,0,0,4.8,2.24c-.17.81-.33,1.56-.53,2.32-.15.5-.25,1-.42,1.51s-.33,1-.48,1.5c-.35.94-.7,1.9-1.05,2.82-.24.62-.48,1.23-.73,1.83.12-.82.33-2.31.33-2.44a10.29,10.29,0,0,0-1.4-5.08,3,3,0,0,0,0-.6,2.69,2.69,0,0,0-3-2.33l-.24,0c-2.2.59-3.59,4.45-3.7,6.48,0,.12.07,1.42.14,2.24-.11-.48-.21-.94-.33-1.43-.23-1-.49-1.94-.76-3-.16-.5-.31-1-.46-1.51s-.36-1-.54-1.54c-.43-1.18-.92-2.37-1.45-3.55.81-.2,3.86-1,5.07-1.89a5.65,5.65,0,0,0,2.44-4.08,2.7,2.7,0,0,0-2.61-2.76h-.29c-2.27.25-4.23,3.85-4.64,5.83,0,.13-.16,1.59-.22,2.4-.32-.71-.64-1.42-1-2.13-1-2-2.09-4.07-3.17-6.09-.33-.62-.65-1.24-1-1.86.3-.07,3.9-.91,5.25-1.94,1.2-.93,2.48-2.44,2.44-4.07a2.69,2.69,0,0,0-2.62-2.77h-.29c-2.26.24-4.22,3.85-4.63,5.84,0,.14-.22,2.24-.24,2.78-.72-1.37-1.41-2.74-2-4.12a46.32,46.32,0,0,1-2.21-5.7c.14,0,3.9-.89,5.28-2a5.63,5.63,0,0,0,2.44-4.07,2.69,2.69,0,0,0-2.61-2.77h-.29c-2.27.25-4.22,3.85-4.64,5.84,0,.16-.23,2.44-.24,2.83a1.57,1.57,0,0,0-.11-.35,33.48,33.48,0,0,1-1.15-6.05c-.13-1.13-.19-2.21-.22-3.25.72-.09,4-.52,5.34-1.35s2.73-2.15,2.89-3.74a2.68,2.68,0,0,0-2.28-3,1.85,1.85,0,0,0-.41,0c-2.27,0-4.62,3.35-5.24,5.29,0,.1-.27,1.2-.42,2v-1.44c0-1.71.1-3.25.22-4.69.06-.81.13-1.5.22-2.17a18,18,0,0,0,4.07-3.63c.81-1.33,1.43-3.17.81-4.66a2.69,2.69,0,0,0-3.44-1.63l-.26.11c-2,1-2.51,5.1-2.14,7.13,0,.17.81,2.83.81,2.8h0c-.09.64-.17,1.33-.25,2.09-.14,1.39-.29,3-.33,4.69a49.27,49.27,0,0,0,.13,5.57,35.71,35.71,0,0,0,1,6.16v.07c-.36-.56-1.41-2.1-1.51-2.21-1.33-1.53-4.8-3.72-6.89-2.84A2.7,2.7,0,0,0,281,169l.13.25c.78,1.41,2.63,2.1,4.13,2.32,1.7.25,5.25-.81,5.54-.87a48.44,48.44,0,0,0,2.16,6c.49,1.14,1,2.26,1.56,3.38l-.66-1c-1.33-1.54-4.8-3.72-6.9-2.83a2.69,2.69,0,0,0-1.32,3.56c0,.09.09.17.14.26.77,1.41,2.62,2.11,4.12,2.32s4.58-.6,5.38-.82c.22.44.42.87.64,1.29,1,2.05,2.07,4.07,3,6.14.34.72.64,1.43.95,2.15-.28-.42-.53-.77-.57-.82-1.33-1.53-4.8-3.72-6.89-2.83a2.69,2.69,0,0,0-1.33,3.57,2.1,2.1,0,0,0,.13.26c.77,1.4,2.63,2.1,4.13,2.32a15.64,15.64,0,0,0,5.23-.82c.3.75.6,1.49.82,2.24.15.5.35,1,.48,1.49s.28,1,.42,1.52c.23,1,.48,2,.69,2.92.14.66.26,1.3.4,1.93-.33-.72-1-2.11-1.07-2.21-1.08-1.72-4.18-4.41-6.38-3.85a2.7,2.7,0,0,0-1.86,3.32c0,.09.06.18.1.27.55,1.52,2.28,2.45,3.73,2.93,1.62.49,5.13,0,5.56,0,.22,1.06.41,2.08.58,3.06.6,3.37,1,6.21,1.2,8.19a6.83,6.83,0,0,0,.11,1h-6.85l2.5,48.75h11.66l2.5-48.75h-6.31l.14-.29c.87-1.83,2.09-4.45,3.4-7.65.41-1,.81-2.1,1.27-3.26.42.09,3.92.82,5.55.43s3.26-1.17,3.93-2.63a2.68,2.68,0,0,0-1.2-3.6l-.28-.12c-2.15-.72-5.44,1.72-6.65,3.36-.07.1-.72,1.23-1.12,1.94.17-.45.34-.9.51-1.37.34-.94.66-1.88,1-2.9l.45-1.51c.15-.5.27-1.05.41-1.57.29-1.24.53-2.49.74-3.77.81.3,3.75,1.32,5.27,1.21s3.42-.66,4.29-2a2.69,2.69,0,0,0-.67-3.75l-.24-.15c-2-1-5.64.88-7.08,2.32-.09.09-1,1.23-1.5,1.87.12-.77.24-1.54.34-2.31.28-2.26.5-4.56.72-6.84.06-.7.15-1.4.22-2.09.28.11,3.74,1.39,5.45,1.28,1.51-.11,3.41-.67,4.29-2a2.68,2.68,0,0,0-.66-3.74l-.25-.16c-2-1-5.64.88-7.08,2.31-.11.11-1.43,1.76-1.74,2.19.16-1.54.34-3.06.58-4.57a45.86,45.86,0,0,1,1.31-6c.13,0,3.73,1.41,5.48,1.29,1.51-.11,3.41-.66,4.29-2a2.71,2.71,0,0,0-.67-3.76l-.24-.14c-2-1-5.65.88-7.08,2.31-.11.1-1.53,1.88-1.77,2.22a1.64,1.64,0,0,1,.09-.35,35.93,35.93,0,0,1,2.38-5.7c.52-1,1.07-1.94,1.63-2.85.64.33,3.61,1.76,5.19,1.83s3.46-.29,4.48-1.53a2.68,2.68,0,0,0-.23-3.78l-.24-.19c-1.89-1.26-5.7.25-7.29,1.51-.09.08-.89.88-1.46,1.46.26-.41.51-.81.77-1.2.94-1.44,1.9-2.69,2.77-3.79.49-.63.95-1.18,1.38-1.69.82,0,4-.12,5.42-.78s2.94-1.84,3.26-3.41a2.69,2.69,0,0,0-2-3.25Zm-25,60.74c-1.37,3.14-2.63,5.7-3.53,7.5l-.5,1H307c-.05-.35-.1-.74-.15-1.16-.28-2-.71-4.89-1.39-8.26-.21-1.06-.45-2.21-.72-3.38a32.59,32.59,0,0,0,3.11-1.46,19.59,19.59,0,0,0,4.53,2.92c-.4,1-.81,2-1.2,2.87Z"/>
                                                                <path class="cls-5" d="M324.35,160.89s.72-2.66.75-2.83c.27-2-.37-6.06-2.45-7.05a2.69,2.69,0,0,0-3.56,1.36c0,.09-.07.18-.1.27-.55,1.51.15,3.36,1,4.63C320.92,158.73,324.3,160.89,324.35,160.89Z"/>
                                                            </g>
                                                        </g>
                                                        <path class="cls-9 woman_hand" d="M93.52,103.59s5.24-5.24,5.75-5.92,9.64-1.19,11.16-1.35,2,0,1.36,1S104,99,104,99l-2.53,1.35L100,102.26h2c1.7,0,4.89-.17,4.89-.17s.51,1.53-.82,1.86a20.92,20.92,0,0,1-4.73.67c-1.53,0-2.71,1.19-4.23,1.36s-2.71.34-2.71.34S66.8,124.05,65.42,124.39s-18.09-3.55-18.09-3.55l3.21-8.63,13.7,2Z"/>
                                                        <path class="cls-10" d="M29.17,106.73s1.88-4.78,6.25-4.08,30,9.31,30,9.31l-1.86,13.66s-19.14-2.81-24.37-4.52a16.53,16.53,0,0,1-7.67-4.95"/>
                                                        <path class="cls-8" d="M176.09,282c0,2.12-37.89,3.83-84.68,3.83S6.73,284.13,6.73,282s37.9-3.82,84.68-3.82S176.09,279.9,176.09,282Z"/>
                                                        <path class="cls-9" d="M57.28,203.3a246.47,246.47,0,0,1-1.51,25.62q-1.38,11.42-2.13,22.91c-.28,4.07-.81,8.09-.81,12.16,0,1.7-.3,6.89,1.05,8.24a40.23,40.23,0,0,0,4.88,4.15c2.27,1.5,9,2.64,7.92,4.52s-17-.76-17-.76-3.38,1.13-5.27-1.12,2.26-7.16,2.64-11.31,0-13.94-1.14-27.87a85.14,85.14,0,0,1,1.14-23.73l-1.51-13.18Z"/>
                                                        <path class="cls-11" d="M51.58,273.25a25.83,25.83,0,0,1-1.76,2s-2.82-1.21-4.63-1.85c-.94,2.28-1.75,4.34-.74,5.61,1.89,2.25,5.27,1.12,5.27,1.12s15.83,2.64,17,.76-5.65-3-7.92-4.52a40.23,40.23,0,0,1-4.88-4.15A2.44,2.44,0,0,0,51.58,273.25Z"/>
                                                        <path class="cls-9" d="M50.1,204.81S49.72,217.24,49,221s-.88,8.75-12.8,37.67C32,268.8,31,271.7,31,271.7s.26,4.68,6.52,7.14c5.7,2.26,5.27,3.3,2.64,3.3s-5.9,1-10-.14-5.88-3.25-7.76-4c-3.1-1.24.89-5.56,1.84-6.84a28.22,28.22,0,0,0,4.29-10c3.77-14.94,3.14-23.61,4.65-30.39a30.23,30.23,0,0,1,5.64-11.67l-2.63-13.56Z"/>
                                                        <path class="cls-11" d="M40.18,282.21c2.64,0,3.07-1-2.64-3.3-6.26-2.44-6.51-7.14-6.51-7.14l.19-.51a1.77,1.77,0,0,0-1.7.51,10.12,10.12,0,0,1-2.25,1.76l-3.14-2.14c-1.1,1.41-4.74,5.49-1.74,6.7,1.88.75,3.62,2.85,7.76,4S37.54,282.21,40.18,282.21Z"/>
                                                        <path class="cls-12" d="M42.27,91S47,97.75,52.4,105s6.62,10.28,5.32,14.66-5.08,10.75-4.88,13.12,2.93,7-.75,8.31c-8.26,2.9-17.42-2.26-17.42-2.26s-2.81-8.78-5.7-19.54-.31-19.15,2.72-21.93S39.2,87.31,42.27,91Z"/>
                                                        <circle class="cls-11" cx="30.33" cy="59.09" r="8.08"/>
                                                        <path class="cls-11" d="M62.49,65.79s5.47-.52,6.26-4.69-5.7-8.33-8.33-8.33a9,9,0,0,1-3.65-.52s-7-3.65-14.59-.53-9.9,10.42-8.33,16.67,6,12.51,12.21,13S62.49,65.79,62.49,65.79Z"/>
                                                        <path class="cls-13" d="M58.48,56.16A19.45,19.45,0,0,1,49,65C42.25,68,35.19,68.55,34.58,65"/>
                                                        <path class="cls-13" d="M52.57,54.4S47.85,64.72,40.78,64.72"/>
                                                        <path class="cls-13" d="M59.16,58s8.14-4.78,7.28,3.19"/>
                                                        <path class="cls-13" d="M36.64,55S33,60.45,33.38,64.42"/>
                                                        <path class="cls-14" d="M52.34,85.59a22.61,22.61,0,0,0-2.22,7.51A16.58,16.58,0,0,0,51,99.54l-8.78-9.2s.6-2.6,1.63-6.84,1.3-6.17,1.3-6.17Z"/>
                                                        <polygon class="cls-4" points="41.2 86.51 51.73 96.39 50.72 105.75 37.42 91.16 41.2 86.51"/>
                                                        <path class="cls-9" d="M59.16,58s4.68,3.25,5.61,7.32-.14,6.57.82,8.88,3,2.84,1.47,3.61-3.64,1.71-3.64,1.71-2,7.53-2.88,8.91-3.26.55-6.23-.81-9-5.58-9.57-6.87c-.4-1-.75-2-1.05-3.07C43.69,77.67,59.45,68.74,59.16,58Z"/>
                                                        <path class="cls-14" d="M47.91,75.39S45.56,68.88,42.7,71s-2,5.17.95,6.62,4,.16,4,.16"/>
                                                        <path class="cls-8" d="M60.8,72.8c-.1.73.06,1.35.36,1.38s.63-.51.72-1.23-.06-1.34-.37-1.38S60.89,72.08,60.8,72.8Z"/>
                                                        <path class="cls-15" d="M61.63,81.57s-3-.82-3.85-2.73"/>
                                                        <path class="cls-16" d="M63.74,69s-1.45-2.44-3.18-1.09"/>
                                                        <path class="cls-11" d="M34.66,138.9a233.57,233.57,0,0,0-9,21.85c-3.77,10.93,8.66,47.84,8.66,47.84H59.89V164.51c0-18.08-5.77-26.37-5.77-26.37S47.84,141.15,34.66,138.9Z"/>
                                                        <polygon class="cls-11" points="114.37 128.51 110.21 128.51 110.21 104.59 114.37 100.81 114.37 128.51"/>
                                                        <rect class="cls-17" x="89.22" y="97.17" width="47.38" height="4.69" transform="translate(-32.74 137.46) rotate(-55.99)"/>
                                                        <path class="cls-11" d="M138.37,109.16,110,114.22v10.92h38v-8a8.14,8.14,0,0,0-8.17-8.12A8,8,0,0,0,138.37,109.16Z"/>
                                                        <rect class="cls-11" x="82.39" y="123.58" width="65.53" height="13.52"/>
                                                        <rect class="cls-18" x="59.36" y="142.54" width="116.4" height="140.25"/>
                                                        <rect class="cls-11" x="59.36" y="142.54" width="116.4" height="5.48"/>
                                                        <path class="cls-9" d="M56.32,120l4.94,5.23,40.43,8.72,10.18-2.61,7.85,5.52c-2,.59-7.57-1.74-7.57-1.74a12,12,0,0,1-5.81,2H97.62s-36.06-3.2-37.81-3.2-11.34-7.55-11.34-7.55Z"/>
                                                        <path class="cls-19" d="M32.92,98s4-3.2,7.43-.37,18.77,21.48,18.77,21.48l-7.6,10.9S38.08,119.6,34.43,115.49a16.43,16.43,0,0,1-4.17-8.14"/>
                                                        <rect class="cls-20" x="55.81" y="136.43" width="125.85" height="7.65"/>
                                                        
                                                        <g class="man">
                                                            
                                                            <path class="cls-9 man_hand" d="M219.48,126.71s-5.28-4.07-6.87-4.89-6.15-.19-8-.41-4.78,3.62-4.78,3.62.64,1,1.45,1.07,5.37.32,6.52.31a32.43,32.43,0,0,0,3.48-.36l6.58,5.13Z"/>
                                                            <path class="cls-21 man_hand" d="M236.05,137.43l-16.55-11-5.39,6.14s18.78,21.44,19.87,22S236.05,137.43,236.05,137.43Z"/>
                                                            <path class="cls-9 man_hand" d="M208.25,122.77l-3.94.59c-1.1.16-4-.81-4,.28s2,1.15,2.59,1.06,2.23,1,3.88,1.18a7.46,7.46,0,0,0,3.73-.88"/>
                                                            <path class="cls-9" d="M273.34,270.23l.67,6.85s1.34-.34,1.34,1.84,1.34,7.33-.5,8.51-10.69.18-12.7.18-5.85-.34-10-.34-2.68-2-1.84-2.68,7.52-2.33,9.36-3.67a13.67,13.67,0,0,0,3.67-5.18c.16-.67,0-6.18,0-6.18Z"/>
                                                            <path class="cls-22" d="M275.37,278.92c0-1.39-.54-1.76-.93-1.83-2.07,1.2-7.25,1.62-7.25,1.62a7.59,7.59,0,0,0-2.18-2.5,1.31,1.31,0,0,0-1.81.46l0,0h-.28a12.91,12.91,0,0,1-3.22,4.15c-1.84,1.33-8.52,3-9.36,3.67s-2.34,2.68,1.84,2.68,8,.33,10,.33,10.86,1,12.7-.17S275.37,281.09,275.37,278.92Z"/>
                                                            <path class="cls-23" d="M267.33,193.23s0,24.9.5,27.74.67,5.7.82,6.18,1.62,2.34,1.62,3.67a2.93,2.93,0,0,1-1.41,2.18,2.65,2.65,0,0,1,1.17,2.17,3.58,3.58,0,0,1-.33,2.34s3.17,10.86,3.51,15.7.33,14.2.33,14.2-2.84.17-6.19.51a41.58,41.58,0,0,1-6,.16s3.51-23.55,2.17-28.73-4-10-3.67-15.71,2.17-22.89,2.84-24.73S266,189.89,267.33,193.23Z"/>
                                                            <path class="cls-24" d="M263.48,263.24s5.35.17,6.86.17,2.51-1.51,3.67-.34.67,6.18.34,7-3.34,1.35-6,1.35h-6.19Z"/>
                                                            <path class="cls-9" d="M252,268.92l-.33,4.84s-1.84.67-2.18,1.51a9.27,9.27,0,0,1-3.5,4.18,57.79,57.79,0,0,1-9.2,3.83c-1.5.34-3,1.84-2,3.18s10,1.68,14.7,1.5,12.36-.16,14.54-.66,1-4.69.5-6.52a23.77,23.77,0,0,1-.66-3.34l-.51-7.33Z"/>
                                                            <path class="cls-25" d="M249.45,275.27a9.27,9.27,0,0,1-3.5,4.18,57.79,57.79,0,0,1-9.2,3.83c-1.5.34-3,1.84-2,3.18s10,1.68,14.7,1.5,12.36-.16,14.54-.66,1-4.69.5-6.52a23.72,23.72,0,0,1-.57-2.66,21.21,21.21,0,0,1-6.78-.51,7.39,7.39,0,0,1-2.34-2.18c-.82-1.33-3.17-1.67-3.17-1.67S249.79,274.43,249.45,275.27Z"/>
                                                            <path class="cls-23" d="M240.43,179.7l1.5,8.86a134.37,134.37,0,0,0,0,23.22c1.17,11.36,3.68,23.89,3.68,23.89s3.67,14.7,4.18,17.54,1.5,13.71,1.5,13.71a14.24,14.24,0,0,0,7.68,1.62c4.35-.33,5-1.84,5-1.84s2.51-19,2-22.39-2.16-10.5-2.16-10.5.33-2.35.33-3.51a14.32,14.32,0,0,0-.17-2.17,5.33,5.33,0,0,0,.33-1.67c0-.82-.49-3.68-.49-3.68L266,200.06l1.67-5.35a9.17,9.17,0,0,0,3.51-6c.83-4.34.17-11.35.17-11.35s-13,2.5-20.35.66-10.86-1.84-10.86-1.84Z"/>
                                                            <path class="cls-26" d="M238.59,122.55s-2.17.51-3.17,8.86-1,13.36-.82,14.2,0,23.06,0,25.06-.5,8.19-.5,8.19,5.51,3.51,16.71,4S276.19,179,276.19,179s-1.18-20.72-1.67-24.73-2.51-25.73-5-32.41-3.67-8.19-4.18-8.52-7-3.35-12.21-1-10.53,6.86-11.69,7.52A15.58,15.58,0,0,0,238.59,122.55Z"/>
                                                            <path class="cls-27" d="M268.29,167.29c.89-.24,1.77-.49,2.68-.78"/>
                                                            <path class="cls-27" d="M239.64,167.56s11.14,3.55,26,.35"/>
                                                            <path class="cls-27" d="M271.6,149.07a42.62,42.62,0,0,1-5.7,1.26"/>
                                                            <path class="cls-27" d="M237.33,139.18s4.63,1,8.41-.21"/>
                                                            <path class="cls-9" d="M238.61,83.06l-2,4.19c0,1.69.81,4.4.33,5.08s-4.42,3.53-3.73,4.89A3.67,3.67,0,0,0,235.39,99a57.41,57.41,0,0,1,1.19,6.77c0,1.52.34,2.37,3.39,3s4.22.17,4.22.17l1.87,5.75,13.71-6.6s-1.35-6.59-1.5-9.45,2.32-3.8,2.54-12c0-1.56-3-5.08-8.14-6.95S241,80.74,238.61,83.06Z"/>
                                                            <path class="cls-8" d="M239.88,92.66c0,.52-.24.93-.52.93s-.52-.41-.52-.93.23-.94.52-.94S239.88,92.13,239.88,92.66Z"/>
                                                            <path class="cls-27" d="M237.79,89s2.5-1.63,3.64.81"/>
                                                            <path class="cls-27" d="M236.76,100.46a5.5,5.5,0,0,0,4.78-1.25"/>
                                                            <path class="cls-23" d="M263.66,79.33c-2.7-4.39-13.37-4.56-15.06-4.39a13.3,13.3,0,0,1-4.07-.51s-7.11-2.2-7.79.17,1.86,4.57,1.86,4.57-7.28-1.52-5.24,1.7,6.09,3.25,6.09,3.25,8.14-3.25,8-.81-3.38,2.54-1.69,3.89,2.71,2.37,2.71,3-.92,2.85-.28,4c0,1.32-.1,3.13-.16,4.72-.11,2.91-.41,4.26-2.7,5.3a25.26,25.26,0,0,1-5.1,1.56,4.6,4.6,0,0,0-2.08-2.08c-1.24-.41-1.87,0-1.87.73s-.21,3.64,1.77,4.88,3.95.82,7.69-1.45,4.27-5.82,4.16-8.42c-.07-1.84-.09-4.07,0-5.58.26-.86.59-2,2.29-2,3.05,0,3.05,3.39,2.7,5.08a3.91,3.91,0,0,1-2.35,2.44s3.89,1.53,5.42,1.53,5.59-2.37,6.77-6.61S266.41,83.74,263.66,79.33Z"/>
                                                            <path class="cls-24" d="M250.62,262.06a63.17,63.17,0,0,0,9.19,1,44.24,44.24,0,0,0,5-.17,49.35,49.35,0,0,1-.67,7c-.5,1.84-4.68,2.67-8.35,1.84s-5-1-5.19-2S250.62,262.06,250.62,262.06Z"/>
                                                            <path class="cls-20" d="M243.62,121.39l-.16,14a.76.76,0,0,0,.73.77.67.67,0,0,0,.24,0h0a.75.75,0,0,0,.51-.71l.16-14.33Z"/>
                                                            <path class="cls-28" d="M261.15,105.68s-12.87,6.68-16.71,8.69-8.69,10.52-8,10.69,7.52-3,8-3,6.85-6.19,12.86-7.33,9,2.84,11.2,1.5-.67-6.52-2.34-8.85S261.15,105.68,261.15,105.68Z"/>
                                                            <path class="cls-29" d="M237.26,122.82c-.7,1.28-1,2.18-.82,2.24.67.17,7.53-3,8-3,.28,0,2.33-1.88,5.12-3.76Z"/>
                                                            <path class="cls-9 man_hand_right" d="M223.93,155.55l-4.68.1s-3.13-1.36-3.52-1.46a17.24,17.24,0,0,0-3.51.39,15.07,15.07,0,0,1-4.29.29c-1.08-.19-.1,1.95.49,2.15s2,.81,2.82.49a6.09,6.09,0,0,1,2.25-.1L210.56,159s-6.51-.49-7.33-.81-1.46.29-1.07.81a32.13,32.13,0,0,0,6.34,3.31c.81.1,11.61-1.76,11.61-1.76l5.56.4Z"/>
                                                            <path class="cls-30 man_hand_right" d="M255.13,118.88s-5,2.18-5.85,6.18-3.84,22.56-3.84,22.56-3,.5-3,1.33a16.86,16.86,0,0,1-.18,2s-3.67,1-6.84,1.5-12.22,2.17-12.22,2.17,0-.33-.49,2.34,1.16,8,1.16,8,8.19.51,14,.17S258.26,163,260,160.81s5-13.53,5.34-17.7,1-13.2,1-13.2"/>
                                                            <path class="cls-27" d="M244.06,151.17s1.68,2.31,6.31,2.52"/>
                                                            <path class="cls-27" d="M246.58,148.43h3.15"/>
                                                            <rect class="cls-7 man_hand" x="192.43" y="123.11" width="19.22" height="11.94" rx="1.56"/>
                                                            <rect class="cls-8  man_hand" x="192.43" y="124.67" width="19.22" height="2.77"/>

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
                               <div class="col-lg-9 col-md-10 col-sm-12">
                                    <div class="text-center que_background_img">
                                        <h1 class="font-700 color-text-gradient">Is SMS API your billing communication mode to connect with your customer?</h1>      
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
            <!-- section5 -->
           <section id="section5" class="section">
                <div class="section_child1">
                    <div class="container">
                        <div class="position-relative">
                            <div class="row my-5 justify-content-between align-items-center">
                                <div class="col-lg-7 col-md-8 col-sm-12">
                                    <div class="">
                                        <div class="text_animation" style="line-height: 1;">
                                            <span class="d-block h5 mb-0"> Well, then we are here to help you save much on your billing communication.</span>
                                            <span class="h1 font-900 color-text-gradient text-uppercase d-block mb-0" style="line-height: 1.4;">Replace your SMS pathway with Whatsapp API</span> 
                                            <span class="h1 font-900 color-text-gradient text-uppercase d-block mb-0" style="line-height: 1.4;">Just pay ₹1/per day</span>
                                            <span class="d-block h5"> and start your billing communication with your customer on WhatsApp today.</span>
                                             
                                        </div>          
                                    </div>        
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class=" my-4 text-center oneRupees">
                                        <img src="{{ asset('assets/front/images/features_landing_pages/one_rupes.svg') }}" style="max-width: 200px;">
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
        <!-- section 7 -->
            <section id="section7" class="section">
                <div class="section_child1">
                    <div class="container">
                        <div class="position-relative">
                            <div class="row justify-content-center my-5">
                               <div class="col-lg-9 col-md-10 col-sm-12">
                                    <div class="text-center pb-3">
                                       <h1 class="text-uppercase">OPENLINK'S WhatsApp API Is all your answers!</h1>
                                       <p>The OPENLINK WhatsApp API allows you to integrate your billing software and send messages to your customer’s WhatsApp. You can send billing messages, notifications, alerts, offers, and any custom message to individual customers directly on their WhatsApp.  That too just at ₹1/Per Day</p>
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
            <!--section 8 -->
            <section id="section8" class="section">
                <div class="section_child1">
                    <div class="oplk-background-color-gradient">
                        <div class="container-fluid px-0">
                            <div class="position-relative">
                                <div class="row justify-content-center my-5">
                                   <div class="col-lg-10 col-md-10 col-sm-12">
                                        <div class="text-center pb-3 card_part">
                                            <div class="row justify-content-center">
                                                <div class="col-lg-4">
                                                   <div class="card m-4 card1">
                                                        <div class="card-body">
                                                            <h5 class="card-title mb-3">Send custom messages to all customers at a time</h5>
                                                            <p class="card-text">OPENLINK facilitates users to select the template, create a customized message and share it with many customers all at one time. Just Make your customized message and Share it with your audience with one click.</p>
                                                        </div>
                                                    </div> 
                                                </div> 
                                                <div class="col-lg-4">
                                                   <div class="card m-4 card2">
                                                        <div class="card-body">
                                                            <h5 class="card-title mb-3">Send birthday & anniversary greetings to your customers</h5>
                                                            <p class="card-text">A happy Customer relationship is a key to any successful business. Greet and make your customer feel special on their D days with OPENLINK. Save your customer data and OPENLINK automate the birthday & anniversary greeting to your customers.</p>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="row justify-content-center pt-sm-4 pt-0">
                                                <div class="col-lg-4">
                                                   <div class="card m-4 card1">
                                                        <div class="card-body">
                                                            <h5 class="card-title mb-3">Post & track social media content directly from your OPENLINK</h5>
                                                            <p class="card-text">Post your content on social media and keep eye on the analytics on a single platform. OPENLINK facilities direct posting of your content on Facebook, LinkedIn, and Twitter and also makes the tracking of clicks easy of each particular post on a single dashboard.</p>
                                                        </div>
                                                    </div> 
                                                </div> 
                                                <div class="col-lg-4">
                                                   <div class="card m-4 card2">
                                                        <div class="card-body">
                                                            <h5 class="card-title mb-3">Send Bulk WhatsApp at a time to all your customers at once</h5>
                                                            <p class="card-text">OPENLINK facilities users to send bulk messages to a group of customers with just one click. Select the template, create your bulk message and send it to the number of customers now.</p>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>    
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
            <section id="section9" class="section">
                <div class="container">
                    <div class="position-relative">
                        <div class="row justify-content-center my-5">
                           <div class="col-lg-10 col-md-10 col-sm-12">
                                <div class="text-center my-5">
                                   <h2>Why WhatsApp API for your business</h2>
                                   <p class="mt-5">
                                       With more than 2 billion users across 180 countries, WhatsApp is the most popular messaging app in the world and with more than 95% of open rate, it’s the best and most reliable platform to connect to your customer.
                                   </p> 
                                </div>     
                                <div class="bg_options mb-4">
                                    <div class="background_number d-inline ms-3"><i class="bi bi-caret-right-fill"></i></div>
                                    <h5 class="d-inline ms-2">Saves on your Billing communication pathway.</h5>
                                </div>
                                <div class="bg_options mb-4">
                                    <div class="background_number d-inline ms-3"><i class="bi bi-caret-right-fill"></i></div>
                                    <h5 class="d-inline ms-2">Saves your time.</h5>
                                </div>
                                <div class="bg_options mb-4">
                                    <div class="background_number d-inline ms-3"><i class="bi bi-caret-right-fill"></i></div>
                                    <h5 class="d-inline ms-2">Send Billing receipt on WhatsApp, to keep data safe and for future reference.</h5>
                                </div>        
                                <div class="bg_options mb-4">
                                    <div class="background_number d-inline ms-3"><i class="bi bi-caret-right-fill"></i></div>
                                    <h5 class="d-inline ms-2">Lessens human interaction by sharing offers in billing communication.</h5>
                                </div> 
                                <div class="bg_options mb-4">
                                    <div class="background_number d-inline ms-3"><i class="bi bi-caret-right-fill"></i></div>
                                    <h5 class="d-inline ms-2">Send promotional offers and discounts to customers Whatsapp from POS to bring them to your store.</h5>
                                </div> 
                                <div class="bg_options mb-4">
                                    <div class="background_number d-inline ms-3"><i class="bi bi-caret-right-fill"></i></div>
                                    <h5 class="d-inline ms-2">Easily notify your customers about updates with a custom message directly from WhatsApp API.</h5>
                                </div> 
                                <div class="bg_options mb-4">
                                    <div class="background_number d-inline ms-3"><i class="bi bi-caret-right-fill"></i></div>
                                    <h5 class="d-inline ms-2">Flexibility to send a message from the Billing system on Whatsapp.</h5>
                                </div> 
                           </div>
                        </div>
                    </div>
                </div> 
                <div class="oplk-bg-color-gradient w-100">
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                           <div class="col-lg-9">
                                <div class="text-center text-white py-4 px-0">
                                    <h2 class="font-700">How to get it and integrate it with your billing system?</h2>
                                </div> 
                           </div> 
                        </div>
                    </div>
                </div>           
            </section>    
               
                <div class="container">
                    <div class="row justify-content-center my-5">
                       <div class="col-lg-9 col-md-10 col-sm-10 text-center">
                           <div class="position-relative">
                                <!-- step1 -->
                                <div class="mt-5">
                                    <h4 class=""><span class="step font-700">STEP1 : </span>Replace your SMS pathway with Whatsapp API now just at ₹1/day Choose the plan as per your business strategy</h4>
                                    <div class="text-center mt-2">
                                        <img src="{{ asset('assets/front/images/features_landing_pages/pricing_page_sc.png') }}" style="width: 800px; max-width:100%;">
                                    </div>
                                </div> 
                                <!-- step2 -->
                                <div class="mt-5">
                                    <h4 class=""><span class="step font-700">STEP2 : </span>Fill your credentials, check out and you are all set</h4>
                                    <div class="text-center mt-2">
                                        <img src="{{ asset('assets/front/images/features_landing_pages/checkout_page_scs.png') }}" style="width: 800px; max-width:100%;">
                                    </div>
                                </div>
                                <!-- step3 -->
                                <div class="mt-5">
                                    <h4 class=""><span class="step font-700">STEP3 : </span>Successful! Now let’s generate your password</h4>
                                    <div class="text-center mt-2">
                                        <img src="{{ asset('assets/front/images/features_landing_pages/payment_sucessfull.jpg') }}" style="width: 800px; max-width:100%;">
                                    </div>
                                </div>
                                <!-- step4 -->
                                <div class="mt-5">
                                    <h4 class=""><span class="step font-700">STEP4 : </span>Hey Welcome to OpenLinks Dashboard</h4>
                                    <div class="text-center mt-2">
                                        <img src="{{ asset('assets/front/images/features_landing_pages/dashboard_scs.jpg') }}" style="width: 800px; max-width:100%;">
                                    </div>
                                </div>
                                <!-- step5 -->
                                <div class="mt-5">
                                    <h4 class=""><span class="step font-700">STEP5 : </span>Go to settings. Scan your Whtsapp with QR following all the instructions given over there!</h4>
                                    <div class="text-center mt-2">
                                        <img src="{{ asset('assets/front/images/features_landing_pages/whatsapp_scan_page_scs.jpg') }}" style="width: 800px; max-width:100%;">
                                    </div>
                                </div>
                                <!-- step6 -->
                                <div class="mt-5">
                                    <h4 class=""><span class="step font-700">STEP6 : </span>Now you successfully connected your WhatsApp with OpenLink</h4>
                                    <div class="text-center mt-2">
                                        <img src="{{ asset('assets/front/images/features_landing_pages/whatsapp_connected_scs.jpg') }}" style="width: 800px; max-width:100%;">
                                    </div>
                                </div>
                                <!-- step7 -->
                                <div class="mt-5">
                                    <h4 class=""><span class="step font-700">STEP7 : </span>Go to API keys, Check your credentials & API example.</h4>
                                    <div class="text-center mt-2">
                                        <img src="{{ asset('assets/front/images/features_landing_pages/api_key_scs.jpg') }}" style="width: 800px; max-width:100%;">
                                    </div>
                                </div>
                                <!-- step8 -->
                                <div class="mt-5">
                                    <h4 class=""><span class="step font-700">STEP8 : </span>Copy it and paste it into your POS system. Connect with your POS system support team.Once done you are all set and your Whatsapp API is integrated with your POS system.</h4>
                                    <div class="text-center mt-2">
                                        <img src="{{ asset('assets/front/images/features_landing_pages/credentail_scs.jpg') }}" style="width: 800px; max-width:100%;">
                                    </div>
                                </div>
                           	<h6 style="margin-top: 120px;">So don’t miss the time anymore!! Start greeting your customer.</h6>    
                            <button class="btn-theme btn-sm-lg text-uppercase">Buy openlink whatsapp api Now</button> 
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