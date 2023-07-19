@extends('layouts.front')

@section('title', 'D2C Post | OpenLink ')
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
    .section_heading{
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }
   
    /*.text_img:after{
        content: '';
        background-image: url({{ asset('assets/front/images/features_landing_pages/whtasapp.svg') }});
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
        position: absolute;
        top: 3rem;
        z-index: 2;
    }
    .section_bottom_arrow{
         position: absolute;
         left: 50%;
        transform: translateX(-50%);
        bottom: 10px;
    }
  /*  .arrow{
       position: absolute;
        left: 50%;
        transform: translateX(-50%);
        bottom: 10px;
    }*/
     .arrow i{
        font-size: 22px;
        
    }

    .arrow {
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
    50% {transform: translateY(8px);}
    100% {transform: translateY(0px);}
    }

    @-webkit-keyframes arrow 
    {
    0% {transform: translateY(0px);}
    50% {transform: translateY(8px);}
    100% {transform: translateY(0px);}
    }

    .arrow .arrow1 {
        animation-delay:1s;
        -webkit-animation-delay:1s; /* Safari 和 Chrome */
    }
    .section7_img img{
        max-width: 180px;
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translate(-50%);
    }
   /* .section7_text{
        position: absolute;
        left: 50%;
        transform: translateX(-50%);/*
        top: 50%;
    }*/
   /* @media(min-width: 576px) and (max-width: 768px){
        .section7_text{
            top: 225px;
        }    
    }*/
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
    .cloud_img{
        animation-name: cloud;
        animation-duration: 28s;
        animation-iteration-count: infinite;
    /*    transition: 3s linear;*/
    }
    @keyframes cloud {
      0% {transform: translateX(0px);}
      100% {transform: translateX(900px);}
    }
    @-webkit-keyframes cloud {
        0% {transform: translateX(0px);}
      100% {transform: translateX(900px);}
    }
    .section_2_img img{
        max-width: 180px;
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translate(-50%);
    }
    .section_2_img{
        animation-name: img;
        animation-duration: 2s;
    }
    @keyframes img {
      0% {transform: translateY(100px);}
      100% {transform: translateY(0px);}
    }
    @-webkit-keyframes img {
        0% {transform: translateY(100px);}
      100% {transform: translateY(0px);}
    }
    .D2C_whatsapp{
        animation-name: whatsapp_mb;
        animation-duration: 2s;
    }
    @keyframes whatsapp_mb {
      0% {transform: translateY(80px);}
      100% {transform: translateY(0px);}
    }
    @-webkit-keyframes whatsapp_mb {
        0% {transform: translateY(80px);}
      100% {transform: translateY(0px);}
    }
    .text_animation{
         animation-name: text_up;
        animation-duration: 2s;
    }
    @keyframes text_up {
      0% {transform: translateY(-80px);}
      100% {transform: translateY(0px);}
    }
    @-webkit-keyframes text_up {
        0% {transform: translateY(-80px);}
      100% {transform: translateY(0px);}
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
       /*.section7_text{
            top: 165px;
        }*/
        /*.arrow i{
          bottom: -20px;  
        }*/
        
        
    }
    </style>
@endsection

@section('content')


<section id="feature_instant_reward">
    <div class="pb-5">
    <!--   Logo section -->
        <div class="container">
            <div class="logo">
                <a href="{{ url('') }}" ><img src="{{ asset('assets/front/images/logo-dark.svg') }}" class="main_logo" alt="OpenLink"></a>
            </div>
        </div>
           
            <!--  section1 -->
        <div class="mouse_scroll">    
            <section id="section1" class="section">
                <div class="section_heading">
                    <div class="position-relative">
                        <div class="container">
                            <div class="pb-5">
                                <div class="mt-5 cloud_img">
                                    <img src="{{ asset('assets/front/images/features_landing_pages/cloud.svg') }}" style="max-width: 200px;">
                                </div>
                                <div class="row justify-content-center align-items-center">
                                    <div class="col-lg-12 col-md-10 col-sm-12">
                                        <div class="align-middle">
                                            <div class="text-center position-relative">
                                                <div class="text_img">
                                                   <h1 class="font-700 color-text-gradient">Easily send powerful bulk WhatsApp campaign</h1>  
                                                </div>
                                                <p>  Effortlessly send your message in bulk on your customers WhatsApp now with one click.</p>
                                            </div>
                                        </div>
                                    </div>    
                                        <div class="text-center mt-5">
                                        	<!-- <img src="{{ asset('assets/front/images/features_landing_pages/D2C_whattsapp_bulk_msg.svg') }}">  -->
                                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                 viewBox="0 0 845.2 320.4" style="enable-background:new 0 0 845.2 320.4;" xml:space="preserve">
                                            <style type="text/css">
                                                .line_1{
                                                        stroke-dasharray: 1000;
                                                        stroke-dashoffset: 1000;
                                                        animation: dash 5s linear forwards;
                                                    }

                                                    @keyframes dash {
                                                      from {
                                                        stroke-dashoffset: 1000;
                                                      }
                                                      to {
                                                        stroke-dashoffset: 0;
                                                      }
                                                    }
                                                .location{
                                                    animation: location_PIN 4s;
                                                    -webkit-animation: location_PIN 4s;
                                                }
                                                @keyframes location_PIN {
                                                  0% {transform: scaleY(1.5);}
                                                  100% {transform: scaleY(1);}
                                                }
                                                @-webkit-keyframes location_PIN {
                                                    0% {transform: scaleY(1.5);}
                                                    100% {transform: scaleY(1);}
                                                }
                                                .location_1 {
                                                    animation: location1_PIN 4s;
                                                    -webkit-animation: location1_PIN 4s;
                                                }
                                                    @keyframes location1_PIN {
                                                      0% {transform: scaleY(1.2);}
                                                      100% {transform: scaleY(1);}
                                                    }
                                                    @-webkit-keyframes location1_PIN {
                                                        0% {transform: scaleY(1.2);}
                                                        100% {transform: scaleY(1);}
                                                    }

                                                 .st2, .cloud_sm{
                                                        animation: cloud_si 40s infinite;
                                                        -webkit-animation: cloud_si 40s infinite ;
                                                        transition-timing-function: linear;
                                                    }
                                                    @keyframes cloud_si {
                                                      0% {transform: translateX(0px);}
                                                      100% {transform: translateX(800px);}
                                                    }
                                                    @-webkit-keyframes cloud_si {
                                                        0% {transform: translateX(0px);}
                                                        100% {transform: translateX(800px);}
                                                    }   
                                                 .whatsapp{
                                                         animation: whatsapp_W 6s infinite;
                                                        -webkit-animation: whatsapp_W 6s infinite;
                                                    }
                                                    @keyframes whatsapp_W {
                                                      0% {opacity: 0;}
                                                      50% {opacity: 1;}
                                                      100% {opacity: 0;}
                                                    }
                                                    @-webkit-keyframes whatsapp_W {
                                                        0% {opacity: 0;}
                                                        50% {opacity: 1;}
                                                      100% {opacity: 0;}
                                                    }
                                                .left_man{
                                                    animation: left_man_1 5s infinite;
                                                    animation-delay: 0.1s;
                                                    -webkit-animation: left_man_1 5s infinite;
                                                }
                                                    @keyframes left_man_1 {
                                                      0% {transform: translate(0px);}
                                                      50% {transform: translate(-10px);}
                                                      100% {transform: translate(0px);}
                                                    }
                                                    @-webkit-keyframes left_man_1 {
                                                       0% {transform: translate(0px);}
                                                     50% {transform: translate(-10px);}
                                                      100% {transform: translate(0px);}
                                                    }  
                                                    .left_woman{
                                                        animation: left_woman_1 5s infinite;
                                                        animation-delay: 10s;
                                                        -webkit-animation: left_woman_1 5s infinite;
                                                    }
                                                    @keyframes left_woman_1 {
                                                      0% {transform: translate(0px);}
                                                      50% {transform: translate(20px);}
                                                      100% {transform: translate(0px);}
                                                    }
                                                    @-webkit-keyframes left_woman_1 {
                                                       0% {transform: translate(0px);}
                                                     50% {transform: translate(20px);}
                                                      100% {transform: translate(0px);}
                                                    } 
                                                    .right_man{
                                                         animation: right_man 8s infinite;
                                                        animation-delay: 3s;
                                                        -webkit-animation: right_man_R 5s infinite;
                                                    }
                                                    @keyframes right_man_R {
                                                      0% {transform: translateX(0px);}
                                                      50% {transform: translateX(30px);}
                                                      100% {transform: translateX(0px);}
                                                    }
                                                    @-webkit-keyframes right_man_R {
                                                       0% {transform: translateX(0px);}
                                                     50% {transform: translateX(30px);}
                                                      100% {transform: translateX(0px);}
                                                    } 
                                                    .right_woman{
                                                         animation: right_woman_R 8s infinite;
                                                        animation-delay: 1s;
                                                        -webkit-animation: right_woman_R 5s infinite;
                                                    }
                                                    @keyframes right_woman_R {
                                                      0% {transform: translateX(0px);}
                                                      50% {transform: translateX(-20px);}
                                                      100% {transform: translateX(0px);}
                                                    }
                                                    @-webkit-keyframes right_woman_R {
                                                       0% {transform: translateX(0px);}
                                                     50% {transform: translateX(-20px);}
                                                      100% {transform: translateX(0px);}
                                                    }        
                                                .st0{fill:#EBEBEB;}
                                                .st1{fill:#E0E0E0;}
                                                .st2{fill:#F5F5F5;}
                                                .st3{fill:url(#SVGID_1_);}
                                                .st4{fill:url(#SVGID_00000084527970868191303850000003908338611716178337_);}
                                                .st5{fill:url(#SVGID_00000108280220552353169140000003225828237685710486_);}
                                                .st6{fill:url(#SVGID_00000168838858650581227880000018260220602258007443_);}
                                                .st7{fill:url(#SVGID_00000096757862991056333890000012227776394059136432_);}
                                                .st8{fill:url(#SVGID_00000018215285961453213980000014159643006653658558_);}
                                                .st9{fill:url(#SVGID_00000176744128289261078660000017584225878530878346_);}
                                                .st10{fill:url(#SVGID_00000109711705077062518430000000122258092201963438_);}
                                                .st11{fill:url(#SVGID_00000168113715175260549900000008036012190703369879_);}
                                                .st12{fill:#FAFAFA;}
                                                .st13{fill:#263238;}
                                                .st14{fill:url(#SVGID_00000127746279054724773670000005990456430196150152_);}
                                                .st15{fill:url(#SVGID_00000037672546247652986710000006374145027745071258_);}
                                                .st16{opacity:0.2;}
                                                .st17{fill:#455A64;}
                                                .st18{fill:#EB996E;}
                                                .st19{fill:#AA6550;}
                                                .st20{fill:#FFBE9D;}
                                                .st21{fill:url(#SVGID_00000103956090830616719520000000888495828080179383_);}
                                                .st22{fill:url(#SVGID_00000145020735130283355490000008815705540030184865_);}
                                                .st23{opacity:0.3;}
                                                .st24{fill:#D8AFA3;}
                                                .st25{fill:#995037;}
                                                .st26{fill:#FF725E;}
                                                .st27{fill:url(#SVGID_00000026160519870044592420000016971798615616044950_);}
                                                .st28{fill:url(#SVGID_00000083778410845911129120000005097535906904729751_);}
                                                .st29{fill:url(#SVGID_00000096763326435676198380000004262246438069623724_);}
                                                .st30{fill:#E07646;}
                                                .st31{fill:url(#SVGID_00000101823545861296862630000003304846291700006281_);}
                                                .st32{fill:#B77153;}
                                                .st33{fill:url(#SVGID_00000007429576849518457050000011464871822505552773_);}
                                                .st34{fill:url(#SVGID_00000009573381085261226550000002388288703704262278_);}
                                                .st35{fill:url(#SVGID_00000047027598672145404730000007326525681044987814_);}
                                                .st36{fill:url(#SVGID_00000163075337208882053470000010023351998363924614_);}
                                                .st37{fill:url(#SVGID_00000047757713299758461280000005283144426299421092_);}
                                                .st38{fill:url(#SVGID_00000150824341086275365600000012465938516283891385_);}
                                                
                                                    .st39{fill:none;stroke:url(#SVGID_00000068653663598307257260000008342579102880140449_);stroke-width:0.5;stroke-linecap:round;stroke-miterlimit:10;}
                                                
                                                    .st40{fill:none;stroke:url(#SVGID_00000031177988854795096630000013767019845978258822_);stroke-width:0.5;stroke-linecap:round;stroke-miterlimit:10;stroke-dasharray:3.9604,3.9604;}
                                                
                                                    .st41{fill:none;stroke:url(#SVGID_00000090296547071491250230000017966046829330291126_);stroke-width:0.5;stroke-linecap:round;stroke-miterlimit:10;}
                                                
                                                    .st42{fill:none;stroke:url(#SVGID_00000014633908891048957990000002649636494698197386_);stroke-width:0.5;stroke-linecap:round;stroke-miterlimit:10;}
                                                
                                                    .st43{fill:none;stroke:url(#SVGID_00000065769236084614045720000003684103821826775194_);stroke-width:0.5;stroke-linecap:round;stroke-miterlimit:10;stroke-dasharray:4.048,4.048;}
                                                
                                                    .st44{fill:none;stroke:url(#SVGID_00000057112525639631458460000015709076289621139357_);stroke-width:0.5;stroke-linecap:round;stroke-miterlimit:10;}
                                                .st45{fill:url(#SVGID_00000163779943225216448860000006330561913896649604_);}
                                                .st46{fill:url(#SVGID_00000104686662932904602330000015574108568450675621_);}
                                                
                                                    .st47{fill:none;stroke:url(#SVGID_00000026845836080647078640000013255157417965831328_);stroke-width:0.5;stroke-linecap:round;stroke-miterlimit:10;stroke-dasharray:4;}
                                                
                                                    .st48{fill:none;stroke:url(#SVGID_00000042730223263946530170000004129518992171406231_);stroke-width:0.5;stroke-linecap:round;stroke-miterlimit:10;stroke-dasharray:4;}
                                                
                                                    .st49{fill:none;stroke:url(#SVGID_00000036231019942484072250000013579766266377585066_);stroke-width:0.5;stroke-linecap:round;stroke-miterlimit:10;stroke-dasharray:4;}
                                                .st50{fill:url(#SVGID_00000036941880026556429870000004204002368714965660_);}
                                                .st51{fill:url(#SVGID_00000054967755928636129770000014125788004387183526_);}
                                                .st52{fill:#4C4C4C;}
                                            </style>
                                            <g id="main">
                                                <path class="st0 earth" d="M526.7,189.2c-0.8-2.9-0.7-6-1-9c-0.2-1.6-0.7-3.4-2.1-4.3c-1-0.5-2-0.8-3-1.2c-3.5-1.6-3.8-6.9-7-9
                                                    c-1.1-0.6-2.2-1-3.4-1.2c-4.6-1.2-9.2-3.5-11.6-7.6c-0.7-1.4-1.4-2.7-2.4-4c-1-1.1-2.9-1.8-4.2-1c0.7,2.1,1.4,4.2,2.1,6.3
                                                    c0.5,1.9,1.4,3.8,2.6,5.4c1.2,1.6,3.3,2.4,5.3,2c0.6-0.3,1.3-0.4,2-0.4c0.5,0.2,0.9,0.5,1.1,0.9c2.1,3.2,0.6,7.8-2.3,10.3
                                                    s-6.8,3.5-10.5,4.4c-1.3,0.4-2.7,0.5-4,0.2c-2.4-0.8-3.3-3.6-3.7-6.1c-0.8-5.5-0.8-11.4-3.4-16.3c-0.9-1.6-2-3-2.4-4.8
                                                    s0-3.9-0.8-5.6s-3.1-3.1-3-5.1c0.1-1.4,1.4-2.4,2.8-2.9s2.8-0.4,4.2-0.8c0.5-0.1,1.2-0.4,1.3-1c0.1-0.8-1-1.3-1.2-2.1
                                                    s0.8-1.6,1.3-2.4c1.1-1.8-0.6-4-2.5-5.1c-1.9-1.1-4.1-2-4.7-4c-0.2-1-0.3-1.9-0.2-2.9c-0.1-2.4-1.5-5-3.9-5.8s-5.4,1-5.3,3.5
                                                    c0,1.4,0.9,2.5,1.2,3.8c0.4,1.3,0,3.1-1.4,3.3c-2.2,0.3-3.6-3.7-5.5-2.7c0.4,2.5,0.7,5,1,7.6c-2.9,1-5.8-2-6.6-5s-0.3-6.2-1.3-9.1
                                                    s-4.4-5.5-7.1-3.9c-0.6,3.5,3.8,5.6,5.5,8.7c1.2,2.3,0.5,5.6-1.9,6.6c-2.4,1-5.5-1.8-4.3-4c0.4-0.8,1.2-1.4,1.4-2.2
                                                    c0.2-1.1-0.6-2.1-1.3-3c-1.2-1.3-2.3-2.6-3.5-3.9c-0.7-0.9-1.6-1.6-2.6-2.2c-2.6-1.2-5.6,0.6-7.4,2.9s-3,5-5.3,6.7
                                                    c-3.3,2.5-8.8,1.9-11-1.6s0-9.1,4.1-9.7c1.6-0.2,3.5,0.1,4.4-1.1c1.7-2.1-1.8-5.7-0.1-7.9c1.3-1.7,4-0.4,6.1-0.8
                                                    c2.1-0.3,3.5-2.2,4.9-3.7s3.5-3,5.5-2.2c-0.1-1.2,0.2-2.5,0.7-3.6c0.7-1,2.3-1.5,3.2-0.7c-1.2,1.5-0.4,4,1.3,5.1
                                                    c1.8,0.9,3.7,1.3,5.7,1.2c2,0.1,4.5-0.3,4.9-2.2c0.1-0.6,0-1.3,0.3-1.9c1.2-2.2,5,1.6,6.9,0c1.1-0.8,0.3-2.7-1-3.2s-2.7-0.2-4-0.4
                                                    c-1.3-0.2-2.9-1.1-2.8-2.4s1.8-2.1,2.1-3.3c0.6-2.2-3.1-3.3-4.7-1.7s-1.5,4.1-1.4,6.4s-0.1,4.8-1.9,6.2c-0.8,0.9-2.6,0.1-3-1.1
                                                    c-0.3-1.2-0.3-2.5,0-3.8c0.1-1.3-0.3-2.8-1.4-3.3c-0.9-0.2-1.8-0.2-2.7-0.1c-3.5-0.1-5.2-4.8-3.7-8s5-4.8,8.2-6
                                                    c2.4-0.9,5.3-1.7,7.3-0.1c0.9,0.7,1.5,1.8,2.4,2.6c1.6,1.3,3.8,1.2,5.8,1.5c3.1,0.5,6,2.2,8.1,4.6c0.8,0.9,1.4,2.4,0.6,3.2
                                                    s-3.1,0.7-2.9,2c2.2,1,4.7,0,5.7-2.2l0,0c0.1-0.2,0.1-0.3,0.2-0.4c1.1,0.7,1.7,1.9,1.6,3.2c2.9-2,6.9-1.3,9,1.6l0,0
                                                    c0.1,0.2,0.2,0.3,0.3,0.5c0.3,0.9,0.8,1.7,1.4,2.5c0.7,0.6,2.1,0.6,2.4-0.3c0.1-0.3,0.1-0.6,0-0.9c-0.3-1.4-0.6-2.8-0.9-4.2
                                                    c2-0.7,3.9,1.1,4.9,3c3.7,6.8,7.6,3.6,13.9,5.6c4.3,1.3,5.8,4.4,7.8,8.2c6.1,11.6,14.9,21.7,20.3,33.6c0.5,1.3,1,2.5,1.5,3.8
                                                    c-0.1-0.3-0.1-0.6-0.2-0.9c-1.7-7.5-4-14.9-7.1-21.9c-0.6-1.5-1.3-3-2-4.5c-0.4-0.9-0.9-1.8-1.3-2.7c-0.6-1.2-1.2-2.3-1.8-3.4
                                                    c-0.5-0.9-1-1.8-1.5-2.7c-0.4-0.6-0.7-1.2-1.1-1.9s-0.8-1.4-1.3-2.1l-1.4-2.2c-0.1-0.2-0.3-0.4-0.5-0.7c-0.5-0.7-1-1.5-1.5-2.2
                                                    c0-0.1-0.1-0.2-0.2-0.2l-0.4-0.6c-0.4-0.6-0.9-1.2-1.3-1.8c-0.7-1-1.5-2-2.2-2.9c-0.6-0.8-1.3-1.6-1.9-2.4
                                                    c-0.7-0.8-1.2-1.4-1.8-2.1s-1.2-1.4-1.8-2s-1.5-1.7-2.2-2.5l0,0c-2.1-2.3-4.3-4.4-6.6-6.5c-0.6-0.5-1.1-1-1.7-1.5s-1.2-1-1.7-1.5
                                                    s-1.2-1-1.8-1.5s-1.2-1-1.8-1.4s-1-0.8-1.5-1.1c-0.2-0.2-0.5-0.4-0.7-0.6c-1-0.8-2.1-1.6-3.1-2.3c-0.5-0.4-1.1-0.8-1.6-1.1
                                                    c-0.5-0.4-1.4-0.9-2.1-1.4c-0.1-0.1-0.2-0.1-0.3-0.2l-1.9-1.2c-0.9-0.5-1.8-1.1-2.7-1.6s-2.1-1.2-3.1-1.8s-2.4-1.3-3.5-1.9
                                                    s-2.4-1.2-3.6-1.8s-2.5-1.1-3.7-1.7c-2.5-1.1-5-2.1-7.5-3h-0.1c-1-0.3-2-0.7-2.9-1c-0.1,0-0.1-0.1-0.2-0.1
                                                    c-0.4-0.1-0.9-0.3-1.3-0.4c-1.8-0.6-3.7-1.1-5.6-1.6c-0.2-0.1-0.5-0.1-0.7-0.2c-0.5-0.2-1.1-0.3-1.6-0.4c-1.2-0.3-2.5-0.6-3.8-0.8
                                                    l-4-0.8c-1.3-0.3-2.8-0.5-4.2-0.7c-3.7-0.6-7.5-1-11.2-1.2c-0.9-0.1-1.7-0.1-2.6-0.1s-1.8-0.1-2.7-0.1h-2.7c-0.9,0-1.8,0-2.7,0
                                                    c-0.8,0-1.5,0-2.3,0.1c-1.9,0.1-3.8,0.2-5.7,0.4c-0.9,0.1-1.8,0.2-2.6,0.3s-1.8,0.2-2.6,0.3c-1.5,0.2-2.9,0.4-4.3,0.7l0,0l-3.5,0.7
                                                    h-0.1c-1.2,0.2-2.3,0.5-3.5,0.8h-0.2c-1.1,0.2-2.1,0.5-3.2,0.8c-1.3,0.3-2.6,0.7-3.9,1.1c-1.1,0.3-2.2,0.7-3.2,1
                                                    c-1.1,0.3-2.3,0.8-3.4,1.2h-0.1c-1.1,0.4-2.2,0.8-3.2,1.2c-1.1,0.4-2.2,0.9-3.3,1.4l0,0c-1,0.4-2,0.9-3,1.3
                                                    c-0.4,0.2-0.8,0.4-1.1,0.5c-1.1,0.5-2.1,1-3.2,1.5c-1.3,0.6-2.6,1.3-3.8,2c-1.1,0.6-2.2,1.2-3.3,1.8c-6.2,3.7-12.1,7.9-17.6,12.5
                                                    c-2,1.6-3.8,3.3-5.6,5c-1.5,1.5-3,3-4.5,4.5c-1.3,1.3-2.6,2.8-3.8,4.2c1.2-1.4,2.5-2.8,3.8-4.2c0.3,0,0.7,0,1,0
                                                    c1.8,0.1,3.7,0.4,5.4-0.1s2.8-1.7,4.3-2.4c3.8-2,9.5-1.6,11-5.6c0.5-1.3,0.4-2.9,1.1-4.1c1.3-2.3,4.7-2.2,7.3-1.8
                                                    c1.1,0.2,2.4,0.5,2.8,1.6c0.2,0.8,0,1.6-0.4,2.3c-2.3,4.4-6.1,7.9-10.8,9.9c-3.7,1.6-8.4,2.6-10,6.3c0.3,1.4,2.7,1.6,2.7,3
                                                    c0,1.1-1.5,1.5-2.2,2.4c-1,1.3,0.5,3.3,2.2,3.5c1.6,0.2,3.2-0.8,4.5-1.8c4.1-2.8,8.4-5.9,10.4-10.4c0.8-1.9,1.4-4.1,3.1-5.2
                                                    c1.9-1,4.3-0.2,5.2,1.7c0.2,0.3,0.3,0.7,0.4,1c1.7-0.7,4.2-0.9,4.8,0.8c0.1,0.6,0.1,1.3,0.1,1.9c0.1,2.6,3.4,4.2,3.4,6.8
                                                    c0,3-4,4-7,4c-2.7,0-5.4,0-8.2,0.1c-1.2-0.1-2.4,0.1-3.5,0.6s-1.7,1.8-1.4,3c0.3,0.6,0.7,1.1,1.2,1.6c1.9,2.5-0.6,6.8-3.7,6.4
                                                    c-1.1-0.1-2.1-0.7-3.1-0.9c-3.1-0.6-6,1.8-8,4.4c-1.9,2.6-3.5,5.6-6.3,7.1c-4.5,2.5-11.4,0.8-14.1,5.2c-1.1,1.8-1,4-0.9,6
                                                    c0.1,2-0.2,4.3-1.6,5.8c-1.5,1.5-4.5,1.4-5.1-0.6c-0.2-0.9-0.1-1.8,0.3-2.6c0.9-2.9,1.8-5.7,2.6-8.6c0.6-2.1,1.3-4.5,0.3-6.4
                                                    c-1.4-2.8-5.5-3.1-8.1-1.4s-4,4.6-5.1,7.5c-0.8,2.6-2,5.2-3.4,7.5l0,0c-0.8,2.4-1.5,4.8-2.1,7.3s-1.2,5.1-1.6,7.6
                                                    c0.4-0.2,0.8-0.5,1.1-0.8c1.4-1.1,4.7-6.2,6.6-3.2c0.5,0.8,0.3,1.8-0.3,2.5c-0.8,0.8-2.2,0.8-2.9,1.7c-0.8,1.1-0.1,2.6,0.8,3.5
                                                    s2.2,1.6,2.8,2.8c1.1,2.3-0.7,5.2,0.4,7.5c0.9,2,3.5,2.5,5.6,3l0.7,0.2c1.2-4.3,3.8-7.5,9.9-8c8.4-0.7,18.2,7.6,21.9,14.5
                                                    c4.1,7.6,5.1,17.7,12.5,22.3c5.3,3.3,13.4,3.6,15.3,9.4c1.7,5.3-3.3,10.2-4.8,15.6c-0.9,3.6-0.3,7.3-0.5,11s-1.9,7.7-5.5,8.8
                                                    c-2,0.6-4.2,0.1-5.9,1.3c-3,2.1-1.6,7.6-4.6,9.7c-1.1,0.6-2.3,1.1-3.5,1.4c-6.3,2.1-7.4,10.8-5.6,17.2l0.2,0.7
                                                    c34.2,27.8,80.5,35.7,122,20.8l0,0c10.4-3.8,20.2-8.8,29.3-15.1c3.8-2.6,7.4-5.5,10.9-8.5c2.4-2.1,4.8-4.3,7-6.6
                                                    c1.2-1.2,2.3-2.4,3.4-3.6c8.1-8.9,14.9-18.8,20.1-29.7c3.2-6.6,5.8-13.5,7.8-20.6c0.8-2.8,1.5-5.6,2.1-8.4
                                                    c-1.5,1.2-3.4,1.7-5.3,1.5C529.6,195,527.5,192.1,526.7,189.2z"/>
                                                <path class="st1" d="M488.1,204.3c5.5-3.6,8.9-12.9,3.1-16c-2.2-1.2-5-0.9-7.1-2.1c-2.8-1.6-3.7-5.2-4.4-8.3
                                                    c-1.7-8.3-3.4-16.7-5.1-25.1c-1-5-2.8-10.9-7.8-12.4c-2.8-0.8-5.8,0.1-8.6,0.3c-10,0.4-23-25.6-32.7-10.8
                                                    c-0.4-4.5-7.7-3.9-10.5-0.3c-2.8,3.6-4,8.5-7.9,10.7c-3,1.6-7,1.2-9.6,3.4c-1.8,1.6-2.4,4.1-3,6.4c-1,4.5-2.1,9-3.1,13.4
                                                    c-0.8,3.6-1.6,7.5-0.3,10.9c1.4,3.5,5.8,5.9,8.9,3.8c1.4-1,2.2-2.6,3.4-3.8c2-1.9,5-2.5,7.6-1.5c2.1,0.9,3.6,2.8,5,4.7
                                                    c10.7,15.5,12.4,35.6,10.3,54.3c-0.4,3.4-0.9,6.9-0.1,10.3c0.9,3.9,3.6,7.4,3.9,11.4c0.3,3.1-0.9,6.3,0,9.3
                                                    c1.6,5.5,9.5,6.8,14.3,3.8s7.2-8.8,8.9-14.2s3.1-11.3,6.9-15.5c2.4-2.6,5.5-4.6,7.4-7.6c2.5-4.2,1.9-9.8,4.3-14.1
                                                    C475.3,209.6,482.6,207.9,488.1,204.3z"/>
                                                <path class="st1" d="M365.5,200c-1.9-5.9-10.1-6.2-15.3-9.4c-7.4-4.6-8.4-14.7-12.5-22.3c-3.7-6.8-13.5-15.1-21.9-14.5
                                                    c-6.1,0.5-8.6,3.7-9.9,8l-0.7-0.2c-2.2-0.6-4.7-1-5.6-3c-1.1-2.3,0.7-5.3-0.4-7.5c-0.6-1.2-1.8-1.9-2.8-2.8s-1.6-2.4-0.8-3.5
                                                    c0.7-0.9,2.1-0.9,2.9-1.7c0.7-0.6,0.8-1.7,0.3-2.5c-1.9-3-5.1,2.1-6.6,3.2c-0.4,0.3-0.7,0.6-1.1,0.8l0,0c-0.1,0.2-0.1,0.5-0.1,0.7
                                                    c-0.1,0.7-0.2,1.5-0.4,2.2c-0.1,0.8-0.2,1.5-0.4,2.2c-0.1,0.8-0.1,1.2-0.2,1.8s-0.2,1.2-0.2,1.8c0,0.3-0.1,0.6-0.1,0.9
                                                    c-1.5,13.6-0.7,27.3,2.3,40.7c1.3,5.9,3.1,11.8,5.2,17.4c0.9,2.4,1.9,4.8,3,7.2c1.3,3,2.8,5.9,4.4,8.7s3,5.4,4.8,8
                                                    c2.3,3.6,4.8,7.1,7.5,10.4c2.4,3,4.9,5.8,7.5,8.5c-3.9-18-7.4-36.4-15.6-52.8c8.2,16.4,11.7,34.8,15.6,52.8l0,0
                                                    c1.1,1.2,2.3,2.3,3.4,3.4c0.9,0.9,1.9,1.8,2.8,2.6c0.9,0.9,1.9,1.7,2.9,2.5c0.7,0.6,1.4,1.1,2.1,1.7l-0.2-0.7
                                                    c-1.9-6.4-0.8-15.1,5.6-17.2c1.3-0.3,2.5-0.7,3.6-1.3c3-2.1,1.6-7.6,4.6-9.7c1.7-1.2,4-0.7,5.9-1.3c3.5-1.1,5.2-5.1,5.5-8.8
                                                    s-0.4-7.4,0.5-11C362.1,210.2,367.2,205.3,365.5,200z M302.9,166.1c0.7,0.2,1.3,0.3,2,0.4L302.9,166.1z M304.7,168.5
                                                    c-0.2,1.9-0.4,3.9-0.7,5.7c-0.1,0.4-0.1,0.7-0.2,1.1c0.1-0.4,0.1-0.7,0.2-1.1C304.3,172.3,304.5,170.4,304.7,168.5L304.7,168.5z
                                                     M294.3,156.7c1.7,1.5,3.2,3.2,3.3,5.4C297.5,160,296,158.2,294.3,156.7L294.3,156.7z M297.6,164c-0.2-0.4-0.2-0.9-0.1-1.4
                                                    C297.5,163.1,297.5,163.5,297.6,164c0.2,0.3,0.4,0.5,0.8,0.6C298.1,164.5,297.8,164.3,297.6,164z M302.3,180.5
                                                    c-0.4,1.4-0.7,2.8-0.8,4.3c0,2.5,0.5,4.9,1.5,7.1c-1-2.2-1.5-4.7-1.5-7.1C301.7,183.4,301.9,181.9,302.3,180.5L302.3,180.5z
                                                     M303.3,192.5c0.2,0.5,0.5,1,0.7,1.5C303.8,193.5,303.6,193,303.3,192.5L303.3,192.5z"/>
                                                <path class="st1" d="M303.1,114.5c2.6-1.7,6.7-1.3,8.1,1.4c1,2,0.4,4.3-0.3,6.4c-0.9,2.8-1.8,5.7-2.6,8.6c-0.3,0.8-0.4,1.8-0.3,2.6
                                                    c0.6,2,3.7,2.1,5.1,0.6s1.6-3.8,1.6-5.8c0-2.1-0.1-4.3,0.9-6c2.6-4.4,9.5-2.7,14-5.2c2.8-1.5,4.4-4.5,6.3-7.1s4.8-5,8-4.4
                                                    c1.1,0.2,2,0.7,3.1,0.9c3.1,0.3,5.6-4,3.7-6.4c-0.5-0.5-0.9-1-1.2-1.6c-0.3-1.2,0.3-2.5,1.4-3s2.3-0.7,3.5-0.6
                                                    c2.7,0,5.4-0.1,8.2-0.1c3,0,7-1,7-4c0-2.6-3.3-4.2-3.4-6.8c0.1-0.6,0-1.3-0.1-1.9c-0.6-1.7-3.1-1.4-4.8-0.8
                                                    c-0.4-2.1-2.5-3.5-4.6-3.1c-0.3,0.1-0.7,0.2-1,0.3c-1.8,1.1-2.3,3.3-3.1,5.2c-2,4.6-6.3,7.6-10.4,10.4c-1.4,0.9-2.9,1.9-4.5,1.8
                                                    s-3-2.2-2-3.5c0.7-0.9,2.2-1.3,2.2-2.4c0-1.4-2.4-1.7-2.7-3c1.5-3.8,6.2-4.7,10-6.3c4.6-2,8.3-5.4,10.7-9.8
                                                    c0.5-0.7,0.6-1.5,0.5-2.3c-0.4-1.1-1.7-1.4-2.8-1.6c-2.6-0.4-6-0.6-7.3,1.8c-0.7,1.2-0.5,2.8-1.1,4.1c-1.5,4-7.2,3.6-11,5.6
                                                    c-1.5,0.8-2.7,1.9-4.3,2.4c-1.6,0.5-3.6,0.2-5.4,0.1c-0.3,0-0.7,0-1,0c-1.3,1.3-2.6,2.7-3.8,4.2c-1.2,1.4-2.4,2.9-3.6,4.3
                                                    c-5.6,6.9-10.4,14.5-14.4,22.4c-1.4,2.8-2.7,5.7-3.9,8.6c-1.2,2.9-2.2,5.9-3.2,9c1.4-2.4,2.6-4.9,3.4-7.5
                                                    C299.1,119.2,300.5,116.2,303.1,114.5z"/>
                                                <path class="st1" d="M539.6,184c0.2-1.8,0.5-3.6,0.6-5.4s0.3-3.6,0.4-5.3c0.1-1.4,0.1-2.9,0.1-4.3v-4.5c-0.1-4.5-0.4-8.9-1-13.4
                                                    c-0.2-1.7-0.5-3.4-0.8-5s-0.6-3.4-1-5l0,0c-0.5-1.3-1-2.5-1.5-3.8c-5.3-12-14.2-22-20.2-33.6c-2-3.8-3.5-6.9-7.8-8.2
                                                    c-6.4-1.9-10.2,1.3-13.9-5.6c-1-1.8-3-3.7-4.9-3c0.3,1.4,0.6,2.8,0.9,4.2c0.1,0.3,0.1,0.6,0,0.9c-0.2,0.9-1.6,1-2.4,0.4
                                                    c-0.6-0.7-1.1-1.6-1.4-2.5c-1.8-3.1-5.7-4.2-8.8-2.4l0,0c-0.2,0.1-0.3,0.2-0.5,0.3c0.1-1.3-0.6-2.5-1.6-3.2
                                                    c-0.7,2.3-3.1,3.6-5.4,2.8c-0.2,0-0.3-0.1-0.4-0.2c-0.2-1.2,2-1.2,2.9-2.1s0.2-2.3-0.6-3.2c-2.1-2.4-4.9-4-8.1-4.6
                                                    c-2-0.3-4.2-0.3-5.8-1.5c-0.9-0.7-1.5-1.8-2.4-2.6c-2-1.6-4.9-0.8-7.3,0.1c-3.3,1.2-6.7,2.9-8.2,6s0.2,7.9,3.7,8
                                                    c0.9-0.2,1.8-0.1,2.7,0.1c1.2,0.5,1.5,2,1.4,3.3s-0.4,2.6,0,3.8s2.1,2,3,1c1.8-1.3,2-3.9,1.9-6.2s-0.2-4.8,1.4-6.4s5.2-0.5,4.7,1.7
                                                    c-0.4,1.3-2,2-2.1,3.3s1.4,2.3,2.7,2.4s2.8-0.1,4,0.4s2.1,2.4,1,3.2c-1.9,1.6-5.7-2.2-6.9,0c-0.3,0.6-0.2,1.3-0.3,1.9
                                                    c-0.5,1.9-3,2.3-4.9,2.2c-2,0.2-3.9-0.3-5.7-1.2c-1.7-1.1-2.5-3.6-1.3-5.1c-0.9-0.8-2.5-0.4-3.2,0.7c-0.6,1.1-0.8,2.3-0.7,3.6
                                                    c-2-0.8-4.1,0.7-5.5,2.3s-2.9,3.4-4.9,3.7c-2.1,0.3-4.8-0.9-6.1,0.8c-1.7,2.2,1.8,5.7,0.1,7.9c-1,1.2-2.9,0.9-4.4,1.1
                                                    c-4.1,0.6-6.4,6.1-4.1,9.7c2.3,3.5,7.7,4.1,11,1.6c2.3-1.7,3.5-4.5,5.3-6.7s4.8-4,7.4-2.9c1,0.5,1.9,1.3,2.6,2.2
                                                    c1.2,1.3,2.3,2.6,3.5,3.9c0.8,0.8,1.5,1.8,1.3,3c-0.2,0.9-1,1.5-1.4,2.2c-1.2,2.3,2,5,4.3,4s3.1-4.3,1.9-6.6
                                                    c-1.6-3.1-6.1-5.2-5.5-8.7c2.6-1.6,6.1,1,7.1,3.9s0.6,6.2,1.3,9.2s3.6,6,6.6,5c-0.4-2.6-0.7-5.1-1-7.6c1.9-1,3.4,3,5.5,2.7
                                                    c1.3-0.2,1.7-2,1.4-3.3s-1.2-2.5-1.2-3.8c0-2.5,3-4.2,5.3-3.5s3.8,3.3,3.9,5.8c-0.1,1,0,2,0.2,2.9c0.6,2,2.9,2.9,4.7,4
                                                    c1.8,1.1,3.6,3.3,2.5,5.1c-0.5,0.8-1.5,1.5-1.3,2.4s1.3,1.3,1.2,2.1c-0.1,0.6-0.7,0.8-1.3,1c-1.4,0.3-2.8,0.3-4.2,0.7
                                                    s-2.7,1.5-2.8,2.9c-0.1,2,2.1,3.3,3,5.1s0.4,3.8,0.8,5.6c0.6,1.7,1.4,3.3,2.4,4.8c2.6,4.9,2.6,10.8,3.4,16.3
                                                    c0.4,2.5,1.3,5.4,3.7,6.1c1.3,0.3,2.7,0.2,4-0.2c3.7-0.9,7.6-1.9,10.5-4.4s4.4-7.1,2.3-10.3c-0.2-0.4-0.6-0.8-1.1-0.9
                                                    c-0.7-0.1-1.3,0.1-2,0.4c-2,0.4-4.1-0.4-5.3-2c-1.2-1.6-2.1-3.4-2.6-5.4c-0.7-2.1-1.4-4.2-2.1-6.3c1.3-0.8,3.1-0.1,4.2,1
                                                    c0.9,1.2,1.7,2.6,2.4,4c2.4,4.1,7,6.4,11.6,7.6c1.2,0.2,2.3,0.7,3.4,1.2c3.2,2.1,3.5,7.4,7,9c1,0.3,2,0.7,3,1.2
                                                    c1.4,0.9,1.8,2.7,2.1,4.3c0.4,3,0.2,6.1,1,9.1c0.8,2.9,2.9,5.8,5.9,6.3c1.9,0.2,3.8-0.3,5.3-1.5l0,0c0.5-2.7,1-5.4,1.4-8.2
                                                    C539.5,185.3,539.6,184.7,539.6,184z"/>
                                                <path class="st1" d="M481.9,228.6c-1.9,0.1-2.4,1.1-3.6,2.4c-1.6,1.6-3.7,3.1-5.2,4.7c-2.5,2.7-1.3,7.6-4.4,9.8
                                                    c-0.7,0.4-1.3,0.7-1.9,1.2c-1.2,1.2-1.2,3.2,0,4.4c1.3,1.1,3.1,1.4,4.6,0.8c1.5-0.7,2.7-1.9,3.4-3.5c0.5-1.1,0.9-2.3,1.9-3
                                                    c1.7-1.1,4,0.2,6,0.2C491.5,245.6,490.3,228.2,481.9,228.6z"/>
                                            </g>
                                            <g>
                                                <path class="st0" d="M143.8,213.7h35.5c0,0-3.1-5.7-12.3-4.9c-8.7,0.8-9.2-2.8-13.6-3.3C149,205.1,145.2,208.5,143.8,213.7z"/>
                                                <path class="st0" d="M765.9,124.1c-6.6-9.4-4.5-21.5-0.4-31.7c0.7-1.7,1.1-3.6,2.5-4.8s3.6-1.6,4.9-0.3c1.1,1,1.1,2.7,1.4,4.2
                                                    c0.4,2,1.3,3.8,2.6,5.3c0.8,1.1,2.1,1.7,3.4,1.6c1.8-0.3,2.7-2.3,3.3-4l3.4-9.6c0.5-1.7,1.3-3.4,2.3-4.9c1.1-1.5,2.8-2.4,4.6-2.4
                                                    c1.9,0.1,3.3,1.7,3.2,3.6c-0.2,0.7-0.4,1.4-0.7,2.1s-0.1,1.5,0.5,2.1c0.7,0.3,1.5,0.3,2.2-0.1c2.3-1.2,4.5-2.8,6.3-4.7
                                                    c1.8-1.9,3.9-3.6,6.1-5c2.2-1.4,4.9-1.9,7.5-1.2c2.5,0.8,4.6,3.2,4.3,5.8s-2.5,4.6-4.8,6c-3.3,2.1-6.9,3.7-10.7,4.8
                                                    c-0.7,0.1-1.4,0.5-1.8,1c-0.8,1-0.1,2.5,0.9,3.3c1.2,0.8,2.5,1.4,3.8,1.9c1.4,0.5,2.3,1.8,2.6,3.2c0.1,2-2,3.3-3.9,4
                                                    c-3.7,1.4-7.7,2.1-11.7,2.1c-1.4-0.1-2.9,0-4.2,0.4c-1.4,0.5-2.3,1.8-2.3,3.2c0.3,1.4,1.5,2.5,3,2.6c1.4,0.1,2.9,0.1,4.3-0.1
                                                    c2.7,0,5.6,1.2,6.4,3.8c0.4,1.8,0,3.6-1.2,5c-1.1,1.4-2.5,2.5-4.1,3.3c-5.3,3.1-11.4,4.8-17.6,4.8
                                                    C775.9,129.3,770.6,128,765.9,124.1"/>
                                                <path class="st1" d="M767.3,125.3c1.8-3.9,0.2-2,3.6-6.7c3.7-5,7.7-9.8,12-14.3l3.3-3.6c1.1-1.2,2.2-2.3,3.3-3.4
                                                    c2.2-2.1,4.5-4,6.9-5.8c2.3-1.7,4.5-3.3,6.6-4.8s4.1-2.8,5.9-3.9c2.9-1.8,6-3.3,9.2-4.6c1.1-0.5,2-0.8,2.6-1l0.7-0.2
                                                    c0.1,0,0.2-0.1,0.2-0.1c-0.1,0-0.1,0.1-0.2,0.1l-0.7,0.3c-0.6,0.2-1.5,0.6-2.6,1.1c-3.1,1.3-6.1,2.9-9,4.7
                                                    c-1.8,1.1-3.8,2.4-5.9,3.9s-4.3,3-6.6,4.8c-2.4,1.8-4.7,3.7-6.8,5.8c-1.1,1.1-2.2,2.2-3.3,3.4l-3.4,3.7c-4.3,4.5-8.3,9.3-12,14.3
                                                    c-3.4,4.6-1.7,2.7-3.6,6.6"/>
                                                <path class="st1" d="M771.3,118.3c0-0.1-0.1-0.2-0.1-0.3c0-0.2,0-0.6-0.1-0.9c-0.1-0.8-0.1-2-0.2-3.4c-0.2-2.9-0.2-6.9-0.3-11.3
                                                    s-0.1-8.4-0.2-11.3c0-1.4-0.1-2.6-0.1-3.4v-0.9c0-0.1,0-0.2,0-0.3c0,0.1,0,0.2,0.1,0.3c0,0.2,0,0.6,0.1,0.9c0.1,0.8,0.1,2,0.2,3.4
                                                    c0.2,2.9,0.2,6.9,0.3,11.3c0,4.4,0.1,8.4,0.2,11.3c0,1.4,0.1,2.6,0.1,3.4v0.9C771.3,118.1,771.3,118.2,771.3,118.3z"/>
                                                <path class="st1" d="M803.9,119.4c-0.1,0-0.2,0-0.3,0h-1l-3.5-0.1c-3-0.1-7-0.2-11.5-0.3s-8.6-0.2-11.5-0.4
                                                    c-1.5-0.1-2.7-0.2-3.5-0.2l-1-0.1c-0.1,0-0.2,0-0.3-0.1h1.3l3.5,0.1c3,0.1,7,0.2,11.5,0.3s8.6,0.2,11.5,0.4
                                                    c1.5,0.1,2.7,0.2,3.5,0.2l1,0.1C803.7,119.4,803.8,119.4,803.9,119.4z"/>
                                                <path class="st0" d="M680.4,191.1c0.4,0.7,1.3,1,2,0.6c0.3-0.2,0.5-0.4,0.6-0.7l3.7-7.6c0.7-1.5,1.2-3,1.3-4.7
                                                    c0-4.6-4.8-7.6-9.7-5.4c-1,0.4-1.8,1.1-2.4,2c-1.7,2.5-1.1,5.6,0.1,8L680.4,191.1z M683.4,182.7c-3.6,2.1-7.2-1.8-5.2-5.6
                                                    c0.3-0.5,0.7-0.9,1.2-1.2c3.6-2.1,7.2,1.8,5.2,5.6C684.3,182,683.9,182.4,683.4,182.7L683.4,182.7z"/>
                                                <path class="st2" d="M83.8,51.5h70c0,0-6.2-11.3-24.2-9.7c-17.2,1.5-18.1-5.5-26.9-6.5S86.7,41.3,83.8,51.5z"/>
                                                <path class="st0 cloud_sm" d="M167,65.9h45.2c0,0-4-7.2-15.6-6.2c-11.1,1-11.7-3.6-17.3-4.1S168.9,59.3,167,65.9z"/>
                                                <path class="st0" d="M300.5,319.8h45.2c0,0-4-7.2-15.6-6.2c-11.1,1-11.7-3.6-17.3-4.1S302.4,313.2,300.5,319.8z"/>
                                                <path class="st1" d="M701.8,227.3h42.7c0,0-3.8-6.9-14.8-5.9c-10.5,1-11-3.4-16.4-3.9S703.5,221.1,701.8,227.3z"/>
                                                <path class="st0" d="M316.8,28.8c-0.1-0.3-0.1-0.7-0.1-1c0-0.4-0.1-0.8-0.1-1.1c-0.1-0.5-0.2-1.1-0.3-1.6c-0.4-1.4-1-2.8-1.7-4
                                                    c-3.7-6.2-11.3-8.9-18.1-6.4c-1.4,0.5-2.7,1.1-3.8,2c-0.6,0.4-1.2,0.9-1.7,1.4s-1,1.1-1.5,1.7c-4.4,6-3.8,14.2,1.4,19.5
                                                    c0.5,0.5,1.1,1,1.7,1.5c1.2,0.9,2.4,1.6,3.8,2.1c6.8,2.5,14.4-0.1,18.2-6.3c0.8-1.2,1.4-2.6,1.7-4c0.2-0.5,0.3-1,0.4-1.6
                                                    c0.1-0.4,0.1-0.8,0.2-1.2C316.6,29.5,316.7,29.2,316.8,28.8c0,0.4,0,0.7,0,1c0,0.4,0,0.8-0.1,1.2c-0.1,0.5-0.2,1.1-0.3,1.6
                                                    c-0.3,1.5-0.9,2.9-1.7,4.2c-3.8,6.5-11.8,9.4-18.9,6.8c-1.4-0.5-2.8-1.2-4-2.2c-0.6-0.5-1.2-1-1.8-1.5c-0.6-0.6-1.1-1.2-1.5-1.8
                                                    c-4.1-5.6-4.1-13.2,0.1-18.7c0.5-0.6,1-1.3,1.6-1.8c0.6-0.6,1.2-1.1,1.8-1.5c1.2-0.9,2.6-1.6,4-2.1c2.7-0.9,5.5-1.1,8.3-0.6
                                                    c4.4,0.9,8.3,3.6,10.5,7.6c0.8,1.3,1.3,2.7,1.6,4.2c0.1,0.5,0.2,1.1,0.3,1.6c0.1,0.4,0.1,0.8,0.1,1.2
                                                    C316.8,28.2,316.8,28.5,316.8,28.8z"/>
                                                <path class="st0" d="M313.5,19.2c0,0-0.2,0.3-0.8,0.7l-1,0.7c-0.2,0.1-0.4,0.3-0.6,0.5l-0.8,0.4c-2.7,1.6-5.8,2.5-9,2.5h-1.4
                                                    l-1.3-0.2l-0.6-0.1l-0.6-0.2c-0.4-0.1-0.8-0.2-1.2-0.3c-1.4-0.4-2.7-1-3.9-1.7c-2.1-1.2-3.1-2.3-3-2.4s1.2,0.8,3.3,1.9
                                                    c1.2,0.6,2.5,1.1,3.8,1.5c0.4,0.1,0.8,0.2,1.1,0.3l0.6,0.1l0.6,0.1l1.3,0.2h1.3c3,0,6-0.7,8.7-2.1l0.8-0.3l0.6-0.4l1-0.6
                                                    C313.1,19.3,313.4,19.2,313.5,19.2z"/>
                                                <path class="st0" d="M289.1,38.5c0,0,0.2-0.3,0.8-0.7l1-0.7l0.6-0.4l0.8-0.4c2.7-1.6,5.8-2.5,9-2.5h1.4L304,34l0.6,0.1l0.6,0.1
                                                    c0.4,0.1,0.8,0.2,1.2,0.3c1.4,0.4,2.7,1,3.9,1.7c2.1,1.2,3.1,2.3,3,2.4s-1.2-0.8-3.3-1.9c-1.2-0.6-2.5-1.1-3.8-1.5
                                                    c-0.4-0.1-0.8-0.2-1.1-0.3l-0.6-0.1l-0.6-0.1l-1.3-0.2h-1.3c-3,0-6.1,0.7-8.8,2.2l-0.8,0.3c-0.2,0.1-0.5,0.3-0.6,0.4l-1,0.6
                                                    C289.8,38.2,289.5,38.4,289.1,38.5z"/>
                                                <path class="st0" d="M316.8,29.2c0,0.2-6.9,0.4-15.4,0.4S286,29.3,286,29.1s6.9-0.4,15.4-0.4S316.8,29,316.8,29.2z"/>
                                                <path class="st0" d="M300.9,44.2c-0.2,0-0.4-6.9-0.4-15.4s0.3-15.4,0.5-15.4s0.4,6.9,0.4,15.4C301.3,37.2,301.1,44.2,300.9,44.2z"
                                                    />
                                                <path class="st0" d="M300.9,44.2c-0.1,0.1-1.8-1-3.8-3.6c-1.2-1.5-2.1-3.2-2.9-5c-0.9-2.2-1.3-4.5-1.3-6.9s0.5-4.7,1.4-6.9
                                                    c0.8-1.8,1.7-3.4,2.9-4.9c2-2.6,3.7-3.7,3.8-3.6s-1.4,1.4-3.3,4c-1.1,1.5-2,3.1-2.7,4.8c-0.8,2.1-1.3,4.3-1.3,6.6s0.4,4.5,1.2,6.6
                                                    c0.7,1.7,1.5,3.4,2.6,4.9C299.4,42.8,301,44.1,300.9,44.2z"/>
                                                <path class="st0" d="M301.4,13.3c0.1-0.1,1.8,1,3.8,3.6c1.2,1.5,2.1,3.2,2.9,5c0.9,2.2,1.3,4.5,1.3,6.9s-0.5,4.7-1.4,6.9
                                                    c-0.7,1.8-1.7,3.4-2.9,4.9c-2,2.5-3.7,3.7-3.8,3.6c0-0.1,1.4-1.4,3.3-4c1.1-1.5,2-3.1,2.7-4.9c0.8-2.1,1.3-4.3,1.3-6.6
                                                    s-0.4-4.5-1.2-6.6c-0.7-1.7-1.5-3.4-2.6-4.9C302.8,14.7,301.3,13.4,301.4,13.3z"/>
                                                <path class="st1" d="M415.4,19c0,0.7,0.5,1.2,1.2,1.2s1.2-0.5,1.2-1.2s-0.5-1.2-1.2-1.2l0,0C416,17.8,415.5,18.3,415.4,19L415.4,19
                                                    z"/>
                                                <path class="st1" d="M410.6,19c0,0.7,0.5,1.2,1.2,1.2s1.2-0.5,1.2-1.2s-0.5-1.2-1.2-1.2l0,0l0,0C411.2,17.8,410.6,18.3,410.6,19
                                                    L410.6,19z"/>
                                                <path class="st1" d="M405.8,18.4c-0.3,0.6-0.2,1.3,0.4,1.6l0,0c0.6,0.3,1.3,0.1,1.7-0.4c0.3-0.6,0.1-1.3-0.4-1.7l0,0
                                                    C406.9,17.7,406.2,17.9,405.8,18.4L405.8,18.4z"/>
                                                <path class="st1" d="M411.8,5h-0.2h-0.8h-0.5l-0.6,0.1L409,5.2l-0.8,0.2c-1.4,0.4-2.7,1-3.9,1.8c-3.6,2.3-5.9,6.2-6.3,10.5
                                                    c0,0.6,0,1.3,0,1.9c0,0.3,0,0.7,0.1,1s0.1,0.6,0.1,1c0.2,1.4,0.7,2.7,1.3,3.9c0.7,1.3,1.5,2.4,2.5,3.4c1.1,1,2.3,1.9,3.6,2.6
                                                    c1.4,0.7,2.9,1.2,4.4,1.3c0.4,0.1,0.8,0.1,1.2,0.1c0.4,0,0.8,0,1.2,0c2.5-0.1,5-0.9,7.1-2.3h0.1h0.1l4.9,2l-0.2,0.2l-1.4-5.3v-0.1
                                                    v-0.1c1.3-1.7,2.2-3.8,2.6-5.9c0.2-1,0.3-2,0.2-3c0-0.5-0.1-1-0.1-1.5c0-0.2,0-0.5-0.1-0.7c0-0.2-0.1-0.5-0.2-0.7
                                                    c-1.3-5.4-5.7-9.5-11.2-10.5c-0.4,0-0.7-0.1-1-0.1h-0.7L411.8,5c0,0.1,0.1,0.1,0.1,0.1h1.2c0.3,0,0.7,0.1,1,0.1
                                                    c0.2,0,0.4,0,0.6,0.1l0.6,0.2l0.7,0.2l0.7,0.3c1.2,0.4,2.3,1,3.3,1.7c2.7,1.9,4.7,4.8,5.5,8.1c0.1,0.2,0.1,0.5,0.2,0.7
                                                    c0,0.2,0.1,0.5,0.1,0.7c0.1,0.5,0.1,1,0.1,1.5c0.1,1,0,2.1-0.2,3.1c-0.4,2.2-1.3,4.2-2.6,6v-0.2l1.5,5.2l0.1,0.3l-0.3-0.1l-4.9-2
                                                    h0.1c-1.5,1-3.1,1.7-4.9,2.1c-0.8,0.2-1.6,0.3-2.4,0.3c-0.4,0-0.8,0-1.2,0c-0.4,0-0.8,0-1.2-0.1c-1.6-0.2-3.1-0.7-4.5-1.4
                                                    c-1.4-0.7-2.6-1.6-3.7-2.7c-1-1-1.9-2.2-2.6-3.5c-0.6-1.2-1.1-2.6-1.3-3.9l-0.2-1c0-0.3,0-0.7-0.1-1c0-0.6,0-1.3,0-1.9
                                                    c0.2-2.3,1-4.6,2.3-6.6c1.1-1.6,2.5-3,4.1-4c1.2-0.8,2.6-1.4,4-1.7l0.8-0.2l0.7-0.1l0.7-0.1h1.2h0.5V5z"/>
                                                <path class="st1" d="M146.3,166.2c0,0.7,0.5,1.2,1.2,1.2s1.2-0.5,1.2-1.2s-0.5-1.2-1.2-1.2l0,0C146.9,165,146.3,165.6,146.3,166.2z
                                                    "/>
                                                <path class="st1" d="M141.5,166.2c0,0.7,0.5,1.2,1.2,1.2s1.2-0.5,1.2-1.2s-0.5-1.2-1.2-1.2l0,0l0,0
                                                    C142,165,141.5,165.6,141.5,166.2L141.5,166.2z"/>
                                                <path class="st1" d="M136.7,165.7c-0.3,0.6-0.1,1.3,0.4,1.6c0.6,0.3,1.3,0.1,1.6-0.4c0.3-0.6,0.1-1.3-0.4-1.6l0,0
                                                    C137.8,164.9,137,165.1,136.7,165.7C136.7,165.6,136.7,165.7,136.7,165.7z"/>
                                                <path class="st1" d="M142.6,152.2h-0.2h-0.7h-0.5l-0.6,0.1l-0.7,0.1l-0.8,0.2c-1.4,0.4-2.7,1-3.9,1.8c-3.6,2.3-5.9,6.2-6.3,10.5
                                                    c0,0.6,0,1.3,0,1.9c0,0.3,0,0.7,0.1,1s0.1,0.6,0.2,1c0.2,1.4,0.7,2.7,1.3,3.9c0.7,1.3,1.5,2.4,2.5,3.4c1.1,1,2.3,1.9,3.6,2.6
                                                    c1.4,0.7,2.9,1.2,4.4,1.3c0.4,0.1,0.8,0.1,1.2,0.1s0.8,0,1.2,0c2.5-0.1,5-0.9,7.1-2.3l0.1-0.1h0.1l4.9,2l-0.2,0.2
                                                    c-0.5-1.8-1-3.6-1.4-5.3v-0.1v-0.1c1.3-1.7,2.2-3.8,2.6-5.9c0.2-1,0.3-2,0.2-3c0-0.5-0.1-1-0.1-1.5c0-0.2-0.1-0.5-0.1-0.7
                                                    s-0.1-0.5-0.2-0.7c-1.3-5.4-5.7-9.5-11.2-10.4c-0.4,0-0.7-0.1-1-0.1h-0.7h0.7c0.3,0,0.7,0.1,1,0.1c0.2,0,0.4,0,0.6,0.1l0.6,0.2
                                                    l0.7,0.2l0.7,0.3c1.2,0.4,2.3,1,3.3,1.7c2.7,1.9,4.7,4.8,5.5,8.1c0.1,0.2,0.1,0.5,0.2,0.7s0.1,0.5,0.1,0.7c0.1,0.5,0.1,1,0.1,1.5
                                                    c0.1,1,0,2.1-0.2,3.1c-0.4,2.2-1.3,4.2-2.6,6v-0.1l1.5,5.2l0.1,0.3l-0.3-0.1l-4.9-2h0.1c-2.2,1.4-4.7,2.2-7.2,2.3
                                                    c-0.4,0-0.8,0-1.2,0s-0.8,0-1.2-0.1c-1.6-0.2-3.1-0.7-4.5-1.4c-1.3-0.7-2.6-1.6-3.6-2.6s-1.9-2.2-2.6-3.5c-0.6-1.2-1.1-2.6-1.4-3.9
                                                    l-0.2-1c-0.1-0.3,0-0.7-0.1-1c-0.1-0.6-0.1-1.3,0-1.9c0.4-4.4,2.8-8.3,6.4-10.6c1.2-0.8,2.6-1.4,4-1.7l0.8-0.2l0.7-0.1l0.6-0.1h1.2
                                                    L142.6,152.2z"/>
                                                
                                                    <linearGradient id="SVGID_1_" gradientUnits="userSpaceOnUse" x1="649.0701" y1="383.6017" x2="668.41" y2="383.6017" gradientTransform="matrix(1 0 0 1 0 -178)">
                                                    <stop  offset="0" style="stop-color:#00FFAF"/>
                                                    <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                    <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                    <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                    <stop  offset="0.75" style="stop-color:#00469F"/>
                                                    <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                    <stop  offset="1" style="stop-color:#00249C"/>
                                                </linearGradient>
                                                <path class="st3 location" d="M657.3,218.7c0.6,1,1.9,1.4,3,0.8c0.4-0.2,0.7-0.6,0.9-1l5.4-11.2c2-4.4,1.9-6.9,1.9-6.9
                                                    c0-6.8-7-11.1-14.3-7.9c-1.4,0.6-2.7,1.6-3.5,2.9c-2.4,3.7-1.7,8.1,0.1,11.8L657.3,218.7z M661.7,206.4c-5.3,3-10.6-2.7-7.7-8.2
                                                    c0.4-0.7,1-1.3,1.7-1.8c5.3-3,10.6,2.6,7.7,8.2C663,205.4,662.4,206,661.7,206.4L661.7,206.4z"/>
                                                
                                                    <linearGradient id="SVGID_00000177467504799790208690000008391690203500670364_" gradientUnits="userSpaceOnUse" x1="112.2247" y1="292.1" x2="114.6348" y2="292.1" gradientTransform="matrix(1 0 0 1 0 -178)">
                                                    <stop  offset="0" style="stop-color:#00FFAF"/>
                                                    <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                    <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                    <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                    <stop  offset="0.75" style="stop-color:#00469F"/>
                                                    <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                    <stop  offset="1" style="stop-color:#00249C"/>
                                                </linearGradient>
                                                <path style="fill:url(#SVGID_00000177467504799790208690000008391690203500670364_);" d="M112.2,114c0-0.1,0.6-0.2,1.2-0.1
                                                    s1.2,0.2,1.2,0.3s-0.6,0.2-1.2,0.1S112.2,114.1,112.2,114z"/>
                                                
                                                    <linearGradient id="SVGID_00000173852335886095599000000011360093229075252925_" gradientUnits="userSpaceOnUse" x1="439.7547" y1="338.1445" x2="440.4751" y2="338.1445" gradientTransform="matrix(1 0 0 1 0 -178)">
                                                    <stop  offset="0" style="stop-color:#00FFAF"/>
                                                    <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                    <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                    <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                    <stop  offset="0.75" style="stop-color:#00469F"/>
                                                    <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                    <stop  offset="1" style="stop-color:#00249C"/>
                                                </linearGradient>
                                                <path style="fill:url(#SVGID_00000173852335886095599000000011360093229075252925_);" d="M440.4,159c0.1,0,0.1,0.6-0.1,1.2
                                                    s-0.4,1.1-0.5,1.1s-0.1-0.6,0.1-1.2S440.3,158.9,440.4,159z"/>
                                                
                                                    <linearGradient id="SVGID_00000103944561212579342840000017349281099917272205_" gradientUnits="userSpaceOnUse" x1="658.1101" y1="251.7" x2="660.3601" y2="251.7" gradientTransform="matrix(1 0 0 1 0 -178)">
                                                    <stop  offset="0" style="stop-color:#00FFAF"/>
                                                    <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                    <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                    <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                    <stop  offset="0.75" style="stop-color:#00469F"/>
                                                    <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                    <stop  offset="1" style="stop-color:#00249C"/>
                                                </linearGradient>
                                                <path style="fill:url(#SVGID_00000103944561212579342840000017349281099917272205_);" d="M660.4,74.1c0,0.1-0.6,0-1.2-0.2
                                                    c-0.6-0.2-1.1-0.5-1-0.6c0-0.1,0.6,0,1.2,0.2C659.9,73.7,660.4,74,660.4,74.1z"/>
                                                
                                                    <linearGradient id="SVGID_00000111885194276880277250000014434126865280670606_" gradientUnits="userSpaceOnUse" x1="440.1647" y1="348.4" x2="442.4447" y2="348.4" gradientTransform="matrix(1 0 0 1 0 -178)">
                                                    <stop  offset="0" style="stop-color:#00FFAF"/>
                                                    <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                    <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                    <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                    <stop  offset="0.75" style="stop-color:#00469F"/>
                                                    <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                    <stop  offset="1" style="stop-color:#00249C"/>
                                                </linearGradient>
                                                <path  style="fill:url(#SVGID_00000111885194276880277250000014434126865280670606_);" d="M442.4,170c0,0.1-0.4,0.4-1.1,0.6
                                                    s-1.2,0.3-1.2,0.2s0.4-0.4,1.1-0.6S442.4,169.9,442.4,170z"/>
                                                
                                                    <linearGradient id="SVGID_00000041979470363125589230000011343815340314243771_" gradientUnits="userSpaceOnUse" x1="384.7947" y1="347.6621" x2="389.5347" y2="347.6621" gradientTransform="matrix(1 0 0 1 0 -178)">
                                                    <stop  offset="0" style="stop-color:#00FFAF"/>
                                                    <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                    <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                    <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                    <stop  offset="0.75" style="stop-color:#00469F"/>
                                                    <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                    <stop  offset="1" style="stop-color:#00249C"/>
                                                </linearGradient>
                                                <path style="fill:url(#SVGID_00000041979470363125589230000011343815340314243771_);" d="M389.5,169.3c-0.7,0.3-1.5,0.5-2.3,0.6
                                                    c-0.8,0.2-1.6,0.2-2.4,0.1c0.7-0.3,1.5-0.5,2.3-0.6S388.7,169.2,389.5,169.3z"/>
                                                
                                                    <linearGradient id="SVGID_00000083076016499524635500000018149322125261320582_" gradientUnits="userSpaceOnUse" x1="394.2247" y1="346.7121" x2="399.0047" y2="346.7121" gradientTransform="matrix(1 0 0 1 0 -178)">
                                                    <stop  offset="0" style="stop-color:#00FFAF"/>
                                                    <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                    <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                    <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                    <stop  offset="0.75" style="stop-color:#00469F"/>
                                                    <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                    <stop  offset="1" style="stop-color:#00249C"/>
                                                </linearGradient>
                                                <path style="fill:url(#SVGID_00000083076016499524635500000018149322125261320582_);" d="M399,168.6c-0.8,0.2-1.6,0.3-2.4,0.3
                                                    c-0.8,0.1-1.6,0.1-2.4-0.1c0.8-0.2,1.6-0.3,2.4-0.3C397.4,168.4,398.2,168.5,399,168.6z"/>
                                                
                                                    <linearGradient id="SVGID_00000008130859518383122300000000532002677081325733_" gradientUnits="userSpaceOnUse" x1="403.7247" y1="346.8828" x2="408.4947" y2="346.8828" gradientTransform="matrix(1 0 0 1 0 -178)">
                                                    <stop  offset="0" style="stop-color:#00FFAF"/>
                                                    <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                    <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                    <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                    <stop  offset="0.75" style="stop-color:#00469F"/>
                                                    <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                    <stop  offset="1" style="stop-color:#00249C"/>
                                                </linearGradient>
                                                <path style="fill:url(#SVGID_00000008130859518383122300000000532002677081325733_);" d="M408.5,169c-0.8,0.2-1.6,0.2-2.4,0.1
                                                    c-0.8,0-1.6-0.1-2.4-0.4C405.3,168.5,406.9,168.6,408.5,169L408.5,169z"/>
                                                
                                                    <linearGradient id="SVGID_00000015339218098959725970000014571710655413582472_" gradientUnits="userSpaceOnUse" x1="431.5247" y1="352.9" x2="433.7547" y2="352.9" gradientTransform="matrix(1 0 0 1 0 -178)">
                                                    <stop  offset="0" style="stop-color:#00FFAF"/>
                                                    <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                    <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                    <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                    <stop  offset="0.75" style="stop-color:#00469F"/>
                                                    <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                    <stop  offset="1" style="stop-color:#00249C"/>
                                                </linearGradient>
                                                <path style="fill:url(#SVGID_00000015339218098959725970000014571710655413582472_);" d="M433.8,175.4c0,0.1-0.6,0-1.2-0.3
                                                    s-1.1-0.6-1-0.7s0.6,0,1.2,0.3S433.8,175.3,433.8,175.4z"/>
                                            <g class="left_man">
                                                    <path class="st12" d="M701.7,74.4l2.9,8.1c-14.6,17.4-12.4,43.3,5,57.9c17.4,14.6,43.3,12.4,57.9-5c14.6-17.4,12.4-43.3-5-57.9
                                                    c-15.1-12.8-37.2-12.9-52.5-0.3L701.7,74.4z"/>
                                                    <path class="st13" d="M701.7,74.4l8.3,2.7h-0.1c3.5-2.9,7.4-5.2,11.7-6.8c0.8-0.3,1.8-0.6,2.7-0.8c0.9-0.3,1.9-0.6,2.8-0.8l3.1-0.6
                                                    l3.2-0.3l0.8-0.1h2.6c0.6,0,1.2,0,1.8,0l1.8,0.2c5.2,0.5,10.2,2.1,14.8,4.5c5.1,2.7,9.7,6.4,13.3,10.9l0.7,0.9l0.6,1l1.3,1.9
                                                    l0.3,0.5l0.3,0.5l0.6,1c0.4,0.7,0.7,1.4,1.1,2.1c0.4,0.7,0.6,1.5,0.9,2.2l0.5,1.1c0.2,0.4,0.3,0.7,0.4,1.1l0.7,2.3l0.3,1.2
                                                    c0.1,0.4,0.2,0.8,0.2,1.2c0.2,0.8,0.3,1.6,0.5,2.4c0.1,0.4,0.1,0.8,0.2,1.2l0.1,1.2c0.1,0.8,0.2,1.7,0.2,2.5s0,1.7,0,2.5v1.3
                                                    l-0.1,1.3l-0.3,2.6c-0.2,0.8-0.3,1.7-0.5,2.5l-0.3,1.3c-0.1,0.4-0.2,0.8-0.4,1.2l-0.8,2.5c-0.3,0.8-0.7,1.6-1,2.4
                                                    c-0.7,1.6-1.5,3.2-2.4,4.7c-0.4,0.8-1,1.5-1.5,2.2l-0.7,1.1c-0.2,0.4-0.5,0.7-0.8,1.1c-0.6,0.7-1.1,1.4-1.7,2.1
                                                    c-0.6,0.7-1.3,1.3-1.9,2l-1,1c-0.3,0.3-0.7,0.6-1,0.9l-2.1,1.7c-0.7,0.5-1.5,1-2.2,1.5l-1.1,0.8c-0.4,0.2-0.8,0.4-1.2,0.6l-2.4,1.3
                                                    c-0.8,0.4-1.6,0.7-2.4,1.1c-1.6,0.7-3.3,1.2-5,1.7c-0.8,0.3-1.7,0.4-2.5,0.6c-0.9,0.2-1.7,0.3-2.5,0.5l-2.6,0.2l-1.3,0.1h-3.8
                                                    c-0.8,0-1.7-0.2-2.5-0.2l-1.2-0.1l-0.6-0.1l-0.6-0.1l-2.4-0.5c-0.8-0.2-1.6-0.4-2.4-0.6l-2.3-0.7l-2.2-0.9c-0.7-0.3-1.5-0.6-2.2-1
                                                    c-1.4-0.7-2.8-1.5-4.1-2.3l-1.9-1.3c-0.6-0.5-1.2-1-1.8-1.4c-4.5-3.7-8.2-8.3-10.8-13.5c-1.2-2.4-2.1-4.9-2.9-7.4
                                                    c-0.3-1.2-0.6-2.5-0.8-3.7c-0.1-0.6-0.2-1.2-0.3-1.8l-0.2-1.8c-0.4-4.4-0.1-8.9,1-13.3c0.9-3.6,2.2-7,4-10.2
                                                    c1.4-2.4,2.9-4.7,4.7-6.8v0.1L701.7,74.4l3,8.1l0,0l0,0c-1.8,2.2-3.3,4.5-4.6,6.9c-3.9,7.1-5.5,15.2-4.8,23.3
                                                    c0.1,0.6,0.1,1.2,0.2,1.8s0.2,1.2,0.3,1.8c0.2,1.2,0.5,2.4,0.8,3.7c0.7,2.5,1.7,5,2.9,7.4c2.5,5.2,6.2,9.7,10.6,13.4
                                                    c0.6,0.5,1.2,1,1.8,1.4l1.9,1.3c1.3,0.9,2.6,1.6,4,2.3c0.7,0.4,1.4,0.7,2.2,1l2.2,0.9l2.3,0.7c0.8,0.3,1.6,0.5,2.4,0.6l2.4,0.5
                                                    l0.6,0.1l0.6,0.1l1.2,0.1c0.8,0.1,1.6,0.2,2.5,0.2h3.8l1.3-0.1l2.5-0.2c0.8-0.1,1.7-0.3,2.5-0.5c0.8-0.1,1.7-0.3,2.5-0.6
                                                    c1.7-0.4,3.3-1,4.9-1.7c0.8-0.4,1.6-0.6,2.4-1l2.3-1.2c0.4-0.2,0.8-0.4,1.2-0.7l1.1-0.7c0.7-0.5,1.5-1,2.2-1.5l2.1-1.7
                                                    c0.3-0.3,0.7-0.6,1-0.9l1-1c0.6-0.6,1.3-1.3,1.9-1.9l1.7-2.1c0.3-0.3,0.6-0.7,0.8-1l0.7-1.1c0.5-0.7,1-1.5,1.4-2.2
                                                    c0.9-1.5,1.7-3.1,2.3-4.7c0.3-0.8,0.7-1.6,1-2.4s0.5-1.6,0.8-2.5c0.1-0.4,0.3-0.8,0.4-1.2l0.2-1.3c0.2-0.8,0.3-1.7,0.5-2.5
                                                    c0.1-0.8,0.2-1.7,0.3-2.5l0.1-1.2v-3.7c0-0.8-0.1-1.6-0.2-2.5l-0.1-1.2c0-0.4-0.1-0.8-0.2-1.2c-0.2-0.8-0.3-1.6-0.5-2.4
                                                    c-0.1-0.4-0.1-0.8-0.2-1.2l-0.3-1.2c-0.2-0.8-0.5-1.5-0.7-2.3c-0.1-0.4-0.3-0.8-0.4-1.1l-0.5-1.1c-0.3-0.7-0.6-1.4-0.9-2.2l-1.1-2
                                                    l-0.5-1l-0.2-0.6l-0.3-0.5l-1.3-1.9l-0.6-1l-0.7-0.9c-6.8-8.6-16.8-14.1-27.8-15.3l-1.8-0.2c-0.6,0-1.2,0-1.7,0h-2.5l-0.8,0.1
                                                    l-3.2,0.3l-3.1,0.6c-1,0.2-1.9,0.5-2.8,0.8c-0.9,0.3-1.8,0.5-2.7,0.8c-1.6,0.6-3.2,1.4-4.7,2.2c-2.4,1.3-4.8,2.8-6.9,4.5l0,0
                                                    L701.7,74.4z"/>
                                                
                                                    <linearGradient id="SVGID_00000155840362870420803570000006854341116728224654_" gradientUnits="userSpaceOnUse" x1="673.5" y1="294.8698" x2="751.9" y2="294.8698" gradientTransform="matrix(1 0 0 1 0 -178)">
                                                    <stop  offset="0" style="stop-color:#00FFAF"/>
                                                    <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                    <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                    <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                    <stop  offset="0.75" style="stop-color:#00469F"/>
                                                    <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                    <stop  offset="1" style="stop-color:#00249C"/>
                                                </linearGradient>
                                                <path style="fill:url(#SVGID_00000155840362870420803570000006854341116728224654_);" d="M740.7,87.3l-16.5,1.6l-6.7,1.9
                                                    c-2.9,0.8-5.5,2.3-7.7,4.4L688.2,116l-3.9-32.3l-10.8,1l1.8,41.5c1.6,5.1,6.4,8.6,11.8,8.6c3.3,0,6.4-1.3,8.7-3.6l15.4-14.5
                                                    l-1.5,19.1l-1.4,3.2c10.1,9.5,24.4,13.2,37.9,9.8c0,0,0.5-1.7,2.9-17c1.9-12.3,2.9-39.1,2.9-39.1L740.7,87.3z"/>
                                                
                                                    <linearGradient id="SVGID_00000175286789598056069620000015615863929930897826_" gradientUnits="userSpaceOnUse" x1="748.2501" y1="296.7507" x2="767.9801" y2="296.7507" gradientTransform="matrix(1 0 0 1 0 -178)">
                                                    <stop  offset="0" style="stop-color:#00FFAF"/>
                                                    <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                    <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                    <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                    <stop  offset="0.75" style="stop-color:#00469F"/>
                                                    <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                    <stop  offset="1" style="stop-color:#00249C"/>
                                                </linearGradient>
                                                <path style="fill:url(#SVGID_00000175286789598056069620000015615863929930897826_);" d="M768,134.8c0,0-4.9-27-6.7-32.8
                                                    c-2-6.6-10.4-9.7-10.4-9.7l-2.6,24.3l7.5,28.6C755.7,145.3,764.4,140.1,768,134.8z"/>
                                                <path class="st13" d="M709.7,136.1c-0.1,0,0.3-6.9,0.8-15.3c0.5-8.5,1.1-15.3,1.2-15.3c0.1,0-0.3,6.9-0.8,15.4
                                                    C710.4,129.2,709.8,136.1,709.7,136.1z"/>
                                                <path class="st13" d="M736.8,118.7c0,0.1-0.1,0.2-0.1,0.3l-0.4,0.9c-0.2,0.5-0.4,0.9-0.7,1.4s-0.6,1.2-1,1.8l-0.6,1
                                                    c-0.2,0.3-0.5,0.7-0.7,1c-0.5,0.8-1.1,1.5-1.8,2.2c-2.8,3.3-6.3,6.1-10.2,8.1c-0.9,0.4-1.8,0.9-2.6,1.2c-0.4,0.2-0.8,0.3-1.2,0.5
                                                    l-1.1,0.4c-0.7,0.3-1.4,0.4-2,0.6s-1,0.2-1.5,0.3l-1,0.2c-0.1,0-0.2,0-0.3,0c0.1,0,0.2-0.1,0.3-0.1l0.9-0.2c0.5-0.1,1-0.2,1.5-0.4
                                                    s1.2-0.3,1.9-0.6l1.1-0.4c0.4-0.1,0.8-0.3,1.2-0.5c0.8-0.3,1.7-0.8,2.5-1.2c3.8-2,7.3-4.7,10.1-8c0.6-0.8,1.3-1.5,1.8-2.2
                                                    c0.3-0.4,0.5-0.7,0.8-1l0.6-1c0.4-0.6,0.7-1.2,1-1.8c0.3-0.5,0.5-1,0.7-1.4l0.4-0.9C736.6,118.9,736.7,118.8,736.8,118.7z"/>
                                                <g class="st16">
                                                    <path d="M713.7,138.3c-1.2-0.5-1.8-1.8-1.5-3c0.4-1.2,1.3-2.2,2.5-2.7s2.4-0.8,3.6-1.1c5.3-1.3,10.2-4.1,14.1-7.9
                                                        c0.4-0.3,0.9-0.8,1.3-0.5s0.2,1.2-0.2,1.8c-5,6.6-12,11.3-20,13.5"/>
                                                </g>
                                                <path class="st13" d="M751.9,130.5c-0.1-0.2-0.2-0.5-0.3-0.7c-0.1-0.5-0.3-1.1-0.5-2c-0.5-1.7-1-4-1.6-6.5s-1-4.9-1.3-6.6
                                                    c-0.1-0.8-0.3-1.5-0.3-2c-0.1-0.2-0.1-0.5-0.1-0.8c0.1,0.2,0.2,0.5,0.2,0.7l0.4,2c0.4,1.8,0.9,4,1.5,6.5l1.5,6.5
                                                    c0.2,0.8,0.3,1.4,0.4,2C751.8,130,751.9,130.2,751.9,130.5z"/>
                                                <path class="st13" d="M675.4,87.7c-0.2-0.5-0.3-1.1-0.3-1.6c-0.1-0.6-0.1-1.1,0-1.7c0.2,0.5,0.3,1.1,0.3,1.6
                                                    C675.5,86.6,675.5,87.2,675.4,87.7z"/>
                                                <path class="st13" d="M678.5,87.8c-0.2-0.6-0.3-1.1-0.3-1.7c-0.1-0.6-0.1-1.2,0.1-1.8C678.6,85.5,678.7,86.7,678.5,87.8z"/>
                                                <path class="st13" d="M681.7,87.6c-0.2-0.6-0.3-1.3-0.3-1.9c-0.1-0.7-0.1-1.3,0.1-2C681.7,85,681.8,86.3,681.7,87.6L681.7,87.6z"/>
                                                <path class="st13" d="M687.7,121.6c-0.1-1,0-1.9,0.1-2.9c0-1,0.2-1.9,0.5-2.8C688.4,117.8,688.2,119.7,687.7,121.6z"/>
                                                <path class="st13" d="M757.6,96.4c0,0.1-0.9,0-2.2,0.3c-3.6,0.7-6.5,3.3-7.7,6.7c-0.5,1.3-0.5,2.2-0.6,2.2c0-0.2,0-0.4,0-0.6
                                                    c0.1-0.5,0.2-1.1,0.3-1.6c1.1-3.6,4.2-6.3,7.9-6.9c0.5-0.1,1.1-0.1,1.7-0.1C757.2,96.3,757.4,96.3,757.6,96.4z"/>
                                                <path class="st12" d="M762.7,110.4c-0.7,0.3-1.4,0.6-2.1,0.9c-1.3,0.5-3.1,1.1-5.1,1.7s-3.9,1.1-5.2,1.5c-0.7,0.2-1.4,0.4-2.2,0.4
                                                    c0.7-0.3,1.4-0.5,2.1-0.7l5.2-1.6l5.1-1.7C761.3,110.8,762,110.6,762.7,110.4z"/>
                                                <path class="st12" d="M748.8,121.3c-0.1,0-0.3,0-0.4,0l-1.1-0.2l-4-0.7c-3.4-0.6-8-1.3-13.2-2.1s-9.9-1.4-13.3-1.8l-4-0.5l-1.1-0.2
                                                    c-0.1,0-0.3,0-0.4-0.1c0.1,0,0.3,0,0.4,0l1.1,0.1c1,0.1,2.3,0.2,4,0.4c3.4,0.4,8.1,1,13.3,1.7s9.9,1.6,13.2,2.2
                                                    c1.7,0.3,3.1,0.6,4,0.8l1.1,0.2L748.8,121.3z"/>
                                                <path class="st12" d="M747.2,100.7c0,0.1-7.4-0.9-16.5-2.3s-16.5-2.6-16.5-2.6s7.4,0.9,16.5,2.3S747.3,100.6,747.2,100.7z"/>
                                                <path class="st12" d="M708.4,118.7c-0.4-0.7-0.8-1.5-1-2.2l-2.4-5.4c-0.9-2.1-1.8-3.9-2.4-5.4c-0.4-0.7-0.7-1.5-1-2.3
                                                    c0.1,0.2,0.3,0.4,0.4,0.6c0.2,0.4,0.5,0.9,0.8,1.6c0.7,1.3,1.6,3.2,2.5,5.4s1.8,4,2.3,5.5c0.3,0.7,0.5,1.3,0.6,1.7
                                                    C708.3,118.3,708.4,118.5,708.4,118.7z"/>
                                                <path class="st12" d="M693.7,133.1c-0.1,0-1-4.1-2.1-9.2c-1.1-5.1-1.8-9.3-1.8-9.3c0.1,0,1,4.1,2.1,9.2
                                                    C693,128.9,693.8,133.1,693.7,133.1z"/>
                                                <path class="st12" d="M687.6,110.6c-2.1,0.6-4.3,1.1-6.4,1.6c-2.1,0.5-4.3,0.9-6.4,1.2c2.1-0.6,4.3-1.1,6.4-1.6
                                                    C683.3,111.3,685.4,110.9,687.6,110.6z"/>
                                                <path class="st12" d="M685.5,91.9c-0.5,0.2-1.1,0.3-1.7,0.4c-1,0.2-2.5,0.4-4.1,0.6s-3.1,0.3-4.1,0.4c-0.6,0.1-1.1,0.1-1.7,0
                                                    c0.6-0.1,1.1-0.2,1.7-0.3l4.1-0.5l4.1-0.5C684.3,92,684.9,91.9,685.5,91.9z"/>
                                                <path class="st17" d="M691,59.4c0.2,0.4,5.3,26.8,5.3,26.8l-12.1,0.6l-4.7-22.7L691,59.4z"/>
                                                <polygon class="st13" points="696.4,86.2 697.7,85.6 692.5,59.6 690.9,59.5   "/>
                                                <path class="st13" d="M686.1,65.2c0,0.3-0.2,0.7-0.5,0.7s-0.7-0.2-0.7-0.5s0.2-0.7,0.5-0.7l0,0C685.7,64.6,686.1,64.8,686.1,65.2
                                                    L686.1,65.2L686.1,65.2z"/>
                                                <path class="st18" d="M683.6,83.7l-0.2-3.5l5.2-2.1l-2-4.8c-0.9-2.1-3.4-3.1-5.5-2.2l0,0l-0.3,0.2c-0.7,0.4-1.4,0.8-2.1,1.1
                                                    c-1.5,0.8-2.6,2.2-3,3.8c-0.6,2.8-1,5.6-1.2,8.4"/>
                                                <path class="st13" d="M743.6,53c2,1.2,2.4,3.8,2.6,6.1s0.5,4.9,2.3,6.3c1.5,1.1,4,1.3,4.6,3.2c0.4,1.1-0.2,2.4-1.3,2.8
                                                    c-0.6,0.2-1.3,0.1-1.9-0.2c0.8,1.4,0.7,3.2-0.4,4.4c-1.1,1-2.7,0.9-3.7-0.1c-0.1-0.1-0.2-0.2-0.3-0.4c0.4,1-0.1,2.1-1.1,2.5
                                                    c-0.9,0.4-2-0.1-2.4-1c0-0.1,0-0.1-0.1-0.2"/>
                                                <path class="st13" d="M719.4,72.8c-0.3,1.2-1.5,2-2.7,1.8c-1.2-0.3-2-1.5-1.8-2.7v-0.1c0.2-0.9,1.1-1.7,1-2.7
                                                    c-0.1-1.2-1.4-1.8-2.5-2.1s-2.4-0.8-2.7-1.9s0.5-2.1,1.2-3s1.3-2.2,0.7-3.1c-0.4-0.5-0.9-0.7-1.4-1c-0.9-1-0.9-2.5,0-3.5
                                                    c0.9-0.9,2.2-1.3,3.5-1.3c1.3,0.1,2.5,0.2,3.8,0.5c4.2,0.5,8.5-0.8,11.7-3.6"/>
                                                <path class="st18" d="M733.5,97c4.7,0.3,8.7-3.2,9-7.9c0-0.1,0-0.2,0-0.2l1-26.8c0.4-6.7-4.6-12.5-11.3-12.9l0,0h-0.4h-0.6
                                                    c-6.4,0.1-11.6,5.1-12,11.5c-0.4,5.9-0.7,12.5-0.5,15.7c0.2,6.6,6.8,7.4,6.8,7.4v4.9C725.4,93.1,729,96.7,733.5,97z"/>
                                                <path class="st19" d="M725.4,83.6c3,0,6-0.9,8.5-2.6c0,0-1.9,4.8-8.5,4.3V83.6z"/>
                                                <path class="st13" d="M721.6,64.8c0,0.5,0.4,0.9,0.9,0.9s0.9-0.3,0.9-0.8l0,0l0,0c0-0.5-0.4-0.9-0.9-0.9
                                                    C722,63.9,721.6,64.3,721.6,64.8L721.6,64.8z"/>
                                                <path class="st13" d="M720.7,63.8c0.1,0.1,0.8-0.4,1.8-0.4s1.8,0.5,1.9,0.3s-0.1-0.3-0.4-0.5c-0.4-0.3-1-0.4-1.5-0.4
                                                    s-1,0.2-1.5,0.5C720.7,63.6,720.6,63.7,720.7,63.8z"/>
                                                <path class="st13" d="M731.6,64.8c0,0.5,0.4,0.9,0.9,0.9s0.9-0.3,0.9-0.8l0,0c0-0.5-0.4-0.9-0.9-0.9
                                                    C732.1,63.9,731.7,64.3,731.6,64.8L731.6,64.8L731.6,64.8z"/>
                                                <path class="st13" d="M730.6,63.8c0.1,0.1,0.8-0.4,1.8-0.5c1,0,1.8,0.5,1.9,0.3s-0.1-0.3-0.4-0.5c-0.9-0.6-2.1-0.6-2.9,0.1
                                                    C730.6,63.5,730.6,63.7,730.6,63.8z"/>
                                                <path class="st13" d="M727.1,71.3c-0.5-0.2-1.1-0.2-1.7-0.3c-0.3,0-0.5-0.1-0.5-0.2c0-0.3,0-0.5,0.2-0.8c0.2-0.6,0.5-1.3,0.7-2
                                                    c0.7-1.7,1.2-3.4,1.6-5.2c-0.8,1.6-1.5,3.3-2,5l-0.7,2c-0.1,0.3-0.2,0.7-0.1,1c0.1,0.2,0.2,0.3,0.4,0.4c0.1,0,0.3,0,0.4,0
                                                    C726,71.3,726.6,71.4,727.1,71.3z"/>
                                                <path class="st13" d="M730.1,72c-0.2,0-0.2,1.1-1.1,1.9c-0.9,0.8-2.1,0.7-2.1,0.9s0.3,0.2,0.8,0.2c0.6,0,1.3-0.2,1.8-0.7
                                                    c0.5-0.4,0.8-1,0.8-1.6C730.3,72.2,730.2,72,730.1,72z"/>
                                                <path class="st13" d="M730.2,59.8c0.1,0.3,1.1,0.1,2.3,0.2s2.1,0.4,2.3,0.2c0.1-0.2-0.1-0.4-0.5-0.6c-0.5-0.3-1.1-0.5-1.7-0.6
                                                    c-0.6-0.1-1.2,0-1.8,0.2C730.4,59.5,730.2,59.7,730.2,59.8z"/>
                                                <path class="st13" d="M721,60.9c0.2,0.2,0.9,0,1.7-0.1s1.5,0.1,1.7-0.1s0-0.3-0.4-0.5c-0.9-0.5-1.9-0.5-2.8,0.1
                                                    C721,60.5,720.9,60.7,721,60.9z"/>
                                                <path class="st13" d="M736.2,55L736.2,55c1.1,0.8,1.8,2,2,3.3v0.1c0.3,1.9,0.3,3.8,0.6,5.6c0.2,1.9,1.1,3.6,2.4,5
                                                    c0.6,0.5,1.6,0.9,2.1,0.2c0.1-0.3,0.2-0.6,0.2-0.9c0.2-4.5,1.4-8.6,1.3-13.3c0-1.3-0.6-2.5-1.6-3.2s-2.2-1.4-3.3-0.8
                                                    c-1.1,0.6-2.5,2.6-3.3,3.5"/>
                                                <path class="st18" d="M741.3,65c0.1-0.1,4.5-1.4,4.4,3.1s-4.5,3.5-4.6,3.4S741.3,65,741.3,65z"/>
                                                <path class="st19" d="M742.6,69.8c0.1,0,0.1,0.1,0.2,0.1c0.2,0.1,0.4,0.1,0.6,0c0.6-0.4,0.9-1,0.9-1.7c0-0.4-0.1-0.8-0.2-1.1
                                                    c-0.1-0.3-0.3-0.5-0.6-0.6c-0.2-0.1-0.4,0-0.5,0.2c-0.1,0.1,0,0.2-0.1,0.2s-0.1-0.1-0.1-0.3c0-0.1,0.1-0.2,0.2-0.3
                                                    c0.1-0.1,0.3-0.1,0.4-0.1c0.4,0.1,0.7,0.3,0.8,0.7c0.2,0.4,0.3,0.8,0.3,1.2c0,0.8-0.4,1.6-1.2,1.9C743.1,70.1,742.8,70,742.6,69.8
                                                    C742.6,69.9,742.6,69.8,742.6,69.8z"/>
                                                <path class="st13" d="M739.9,51.8c1.1-1.8-2-4.3-4.2-5s-5.1,0.5-7.3,1.3c-1.3,0.6-2.8,1-4.2,1.2c-1-0.1-2-0.3-2.9-0.7
                                                    s-1.9-0.5-2.9-0.5c-1,0.1-1.8,0.7-2.2,1.5c-0.3,0.9,0.1,1.9,1,2.2l0,0l0.2,0.1c-1.1-0.5-2.4,0.1-2.9,1.2c-0.4,1,0,2.1,0.9,2.7
                                                    c0.5,0.2,1,0.3,1.5,0.2c-0.7-0.5-1.6,0.3-1.5,1.1c0.2,0.8,0.8,1.4,1.6,1.7c2,0.7,4.1,0.6,6-0.2c1.9-0.7,3.7-1.8,5.6-2.5
                                                    s5.1-2.1,7-1.4c1.4,0.5,2.4,2.2,3.2,1.8c0.7-0.4,1.2-1.2,1.3-2C740.2,53.5,740.1,52.6,739.9,51.8"/>
                                                <path class="st17" d="M719.6,51.1c-0.4-0.1-0.8-0.1-1.1,0.2c-0.9,0.6-1.3,1.8-0.9,2.8c0.8,1.4,2.4,2.2,4,1.9c1.9-0.3,3.7-1,5.2-2.1
                                                    s3-2.1,4.7-2.9c0.7-0.3,1.5-0.5,2.3-0.6c0.7,0,1.4,0.1,2,0.3c1,0.3,1.8,0.9,2.3,1.8c0.2,0.3,0.3,0.7,0.4,1c0-0.1,0-0.2,0-0.3
                                                    c0-0.3-0.1-0.5-0.3-0.8c-0.5-0.9-1.3-1.7-2.4-2c-0.7-0.3-1.4-0.4-2.1-0.3c-0.8,0-1.6,0.2-2.4,0.5c-1.7,0.8-3.3,1.8-4.8,3
                                                    c-1.5,1.1-3.2,1.8-5,2.1c-1.5,0.2-2.9-0.4-3.7-1.7c-0.2-0.5-0.2-1.1,0-1.6c0.1-0.4,0.4-0.7,0.7-1C718.9,51.2,719.2,51.1,719.6,51.1
                                                    z"/>
                                                <path class="st17" d="M731.8,48.6c0,0.1,0.6-0.1,1.6-0.2c2.5-0.2,4.9,1.2,6.1,3.4c0.5,0.8,0.6,1.4,0.6,1.4c0-0.5-0.1-1.1-0.4-1.5
                                                    c-1.1-2.5-3.7-3.9-6.4-3.6C732.8,48.2,732.3,48.3,731.8,48.6z"/>
                                                <path class="st17" d="M744,59.9c0.2-0.4,0.4-0.8,0.4-1.2c0.2-2.2-1.2-4.2-3.3-4.8c-0.4-0.2-0.8-0.2-1.3-0.1c0,0.1,0.5,0.1,1.2,0.4
                                                    c1.9,0.7,3.1,2.5,3.1,4.5C744,59.1,744,59.5,744,59.9z"/>
                                            </g>
                                            <g class="left_woman">
                                                <path class="st12" d="M620,259.8l7.5,1.3c13-15.4,36-17.4,51.4-4.4s17.4,36,4.4,51.4s-36,17.4-51.4,4.4
                                                    c-13.4-11.3-16.9-30.6-8.2-45.9L620,259.8z"/>
                                                <path class="st13" d="M619.6,259.8c0.2,0.4,1.3,2.4,3.6,6.9v-0.1c-1.2,2.2-2.2,4.4-3,6.8c-0.5,1.5-0.9,3-1.2,4.5
                                                    c-0.2,0.8-0.2,1.6-0.3,2.5s-0.2,1.8-0.2,2.6c0,0.9,0,1.8-0.1,2.8c0,1,0.1,1.9,0.2,2.9l0.1,0.8l0.1,0.7l0.3,1.5
                                                    c0.1,0.5,0.2,1,0.3,1.5s0.3,1,0.4,1.5c2.7,9.5,9.1,17.5,17.7,22.3l0.9,0.5l0.9,0.4l1.9,0.8l0.5,0.2l0.5,0.2l1,0.3l2,0.7
                                                    c1.4,0.3,2.7,0.7,4.2,0.9l2.1,0.3l1.1,0.1h1.1h2.2c0.4,0,0.7,0,1.1,0l1.1-0.1c0.7-0.1,1.5-0.1,2.2-0.2l2.2-0.4l1.1-0.2l1.1-0.3
                                                    l2.2-0.6c0.7-0.3,1.4-0.5,2.1-0.8l1.1-0.4c0.3-0.1,0.7-0.3,1-0.5l2.1-1c0.7-0.4,1.3-0.8,2-1.2c1.3-0.8,2.6-1.8,3.8-2.8
                                                    c0.6-0.5,1.2-1.1,1.8-1.6s1.2-1.1,1.7-1.7l1.6-1.8c0.5-0.6,1-1.3,1.4-2l0.7-1c0.2-0.3,0.4-0.7,0.6-1l1.2-2.1c0.3-0.7,0.7-1.5,1-2.2
                                                    l0.5-1.1c0.2-0.4,0.3-0.8,0.4-1.1l0.8-2.2c0.2-0.8,0.4-1.5,0.5-2.3c0.4-1.5,0.6-3.1,0.7-4.6c0.1-0.8,0.1-1.5,0.1-2.3v-2.3
                                                    c0-0.8-0.1-1.5-0.2-2.3l-0.1-1.1c0-0.4-0.1-0.8-0.2-1.1c-0.1-0.8-0.3-1.5-0.4-2.2s-0.4-1.4-0.6-2.2l-0.3-1.1l-0.2-0.5l-0.2-0.5
                                                    c-0.3-0.7-0.5-1.4-0.8-2c-0.3-0.7-0.6-1.4-0.9-2l-1-1.9l-1.1-1.8c-0.4-0.6-0.8-1.2-1.2-1.8c-0.8-1.1-1.7-2.2-2.7-3.2l-1.4-1.5
                                                    c-0.5-0.5-1-0.9-1.5-1.4c-3.9-3.4-8.5-5.9-13.5-7.4c-2.3-0.7-4.6-1.1-7-1.4c-2.2-0.2-4.5-0.2-6.7-0.1c-7.2,0.6-14.1,3.4-19.8,7.9
                                                    c-1.9,1.6-3.7,3.3-5.3,5.2h0.1L619.6,259.8l7.4,1.4h0.1c1.6-1.9,3.4-3.6,5.3-5.1c5.7-4.5,12.5-7.2,19.7-7.8
                                                    c2.2-0.2,4.4-0.1,6.6,0.1c2.3,0.3,4.7,0.7,6.9,1.4c4.9,1.5,9.4,4,13.3,7.3c0.5,0.5,1,0.9,1.5,1.3l1.4,1.4c0.9,1,1.8,2.1,2.6,3.2
                                                    c0.4,0.6,0.8,1.1,1.2,1.7l1.1,1.8l1,1.9c0.3,0.6,0.7,1.3,0.9,2l0.8,2l0.2,0.5l0.2,0.5l0.3,1.1c0.2,0.7,0.4,1.4,0.6,2.1
                                                    c0.2,0.7,0.3,1.5,0.4,2.2c0.1,0.4,0.1,0.7,0.2,1.1l0.1,1.1c0,0.8,0.1,1.5,0.2,2.3c0.1,0.8,0,1.5,0,2.3s0,1.5-0.1,2.3
                                                    c-0.1,1.5-0.4,3.1-0.7,4.6c-0.2,0.8-0.3,1.5-0.5,2.3l-0.7,2.2c-0.1,0.4-0.2,0.8-0.4,1.1l-0.5,1.1c-0.3,0.7-0.7,1.5-1,2.1l-1.2,2.1
                                                    c-0.2,0.4-0.4,0.7-0.6,1l-0.7,1c-0.5,0.6-0.9,1.3-1.4,1.9s-1,1.2-1.6,1.8c-0.5,0.6-1.1,1.2-1.6,1.7c-0.6,0.5-1.1,1.1-1.7,1.6
                                                    c-1.2,1-2.5,1.9-3.8,2.8c-0.7,0.4-1.3,0.9-2,1.2l-2.1,1c-0.3,0.2-0.7,0.4-1,0.5l-1.1,0.4c-0.7,0.3-1.4,0.6-2.1,0.8l-2.2,0.6
                                                    l-1.1,0.3c-0.4,0.1-0.7,0.1-1.1,0.2l-2.2,0.4c-0.7,0.1-1.5,0.1-2.2,0.2l-1.1,0.1c-0.4,0-0.7,0-1.1,0h-2.2h-1l-1.1-0.1l-2.1-0.2
                                                    c-1.4-0.2-2.8-0.6-4.1-0.9l-2-0.7l-1-0.3l-0.5-0.2l-0.5-0.2l-1.8-0.8l-0.9-0.4l-0.9-0.5c-8.6-4.7-14.9-12.6-17.6-22
                                                    c-0.1-0.5-0.3-1-0.4-1.5c-0.1-0.5-0.2-1-0.3-1.5s-0.2-1-0.3-1.5l-0.1-0.7v-0.7c-0.1-1-0.2-1.9-0.2-2.9c0-1.8,0.1-3.6,0.3-5.4
                                                    c0.1-0.8,0.2-1.7,0.3-2.5c0.7-3.9,2.1-7.7,4-11.2l0,0l0,0C620.9,262.2,619.9,260.2,619.6,259.8z"/>
                                                <path class="st20" d="M630.3,289.2l-4.1,11l-3.1-24.8c-0.1-1.6,0.2-3.2,0.9-4.6c0.3-0.6,0.7-1.2,1.1-1.8c0.5-0.7,1.2-1.3,1.9-1.8
                                                    c0.7-0.4,0.6-1.4-0.1-1.5s-2.7,1-4.2,3.1s-1.7-1.9-1.8-3.4s-0.6-6-1-6.3c-0.7-0.5-1.3,0.2-1.2,1.7s0.2,5.9-0.6,5.9
                                                    s-1.1-7.4-1.1-7.4s0.2-1.6-0.7-1.6c-1.6,0-0.7,7.9-0.6,8.6c0.1,0.5-0.8,0.6-0.8,0s-0.2-7.5-1.8-7.5c-1.2,0,0.7,6.5,0,8
                                                    c-0.8,1.5-1-5.1-2.2-5.1c-0.5,0-0.8,0.1-0.1,3.8c0.4,2,1.7,4.9,2.1,8.9l0.1,1c0.1,4.9,0.7,23.3,5.1,34.5c1.9,4.7,7.1,6.9,11.8,5
                                                    c1.7-0.7,3.2-1.9,4.2-3.4c3.5-5.3,6.4-11,8.7-16.9L630.3,289.2z"/>
                                                <path class="st18" d="M615.2,272.3c0.2,0,0.4,0.1,0.7,0.2c0.5,0.2,1,0.5,1.2,1l0.2,0.3l0.1-0.3c0.1-0.4,0.3-0.8,0.6-1.2
                                                    c0.5-0.7,1.2-1.2,2.1-1.5c0.6-0.2,1.1-0.2,1.1-0.3c-0.4-0.1-0.8-0.1-1.1,0.1c-0.9,0.3-1.7,0.8-2.2,1.5c-0.3,0.4-0.5,0.8-0.6,1.3
                                                    h0.2c-0.3-0.5-0.8-0.9-1.4-1C615.7,272.3,615.4,272.3,615.2,272.3z"/>
                                                <path class="st13" d="M645,255.6c-3.7-1-7.5,1.2-8.5,4.9c0,0.1-0.1,0.3-0.1,0.5c-0.2,1.4,0,2.9-0.9,4s-2.6,1.3-4,1.8
                                                    c-3.1,1.3-4.8,4.8-3.8,8.1c0.3,0.8,0.8,1.7,0.4,2.5c-0.3,0.8-1,1-1.5,1.4c-1.2,1.2-1.7,2.9-1.1,4.5c0.6,1.6,1.7,2.9,3.1,3.8
                                                    c4.2,2.7,9.6,2.5,13.6-0.4c1.9-1.4,3.4-3.5,5.7-4c2.8-0.6,5.4,1.2,8.1,1.9c3.5,0.8,7.1,0.1,9.9-2.1c2.8-2.2,4.6-5.4,5.1-8.9
                                                    c0.7-4.2-0.5-8.5-0.2-12.8c0.2-2.6,0.9-5.2,0.6-7.8c-0.3-2.6-2.3-5.3-4.9-5.2"/>
                                                
                                                    <linearGradient id="SVGID_00000094582554216385024260000018296928757403790739_" gradientUnits="userSpaceOnUse" x1="611.9446" y1="474.3688" x2="642.9647" y2="474.3688" gradientTransform="matrix(1 0 0 1 0 -178)">
                                                    <stop  offset="0" style="stop-color:#00FFAF"/>
                                                    <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                    <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                    <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                    <stop  offset="0.75" style="stop-color:#00469F"/>
                                                    <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                    <stop  offset="1" style="stop-color:#00249C"/>
                                                </linearGradient>
                                                <path style="fill:url(#SVGID_00000094582554216385024260000018296928757403790739_);" d="M624.3,276.5l1.9,22l10.5-22.9l6.2,20
                                                    c-2.3,5.9-5.2,11.6-8.7,16.9c-4,6.1-13.9,6.4-16.6-0.4c-4.4-11.2-5.7-30.5-5.8-35.4L624.3,276.5z"/>
                                                
                                                    <linearGradient id="SVGID_00000013906777419311596010000002853586741946033840_" gradientUnits="userSpaceOnUse" x1="634.007" y1="473.2276" x2="687.8" y2="473.2276" gradientTransform="matrix(1 0 0 1 0 -178)">
                                                    <stop  offset="0" style="stop-color:#00FFAF"/>
                                                    <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                    <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                    <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                    <stop  offset="0.75" style="stop-color:#00469F"/>
                                                    <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                    <stop  offset="1" style="stop-color:#00249C"/>
                                                </linearGradient>
                                                <path style="fill:url(#SVGID_00000013906777419311596010000002853586741946033840_);" d="M636.3,315.8c-2.4-1.5-3-19.4-1.4-29
                                                    l0.6-3.7c-1.1-6.5,3.4-12.7,9.9-13.8c0.4-0.1,0.7-0.1,1.1-0.1c0.7-0.1,1.4,0,2.1,0.1L664,270c0,0,17.1,4.1,20.1,15
                                                    c0.6,2.4,3.7,16.3,3.7,16.3c-5.5,9.8-12,13.7-12,13.7l-5-13.6c0,0,1.5,7.9,1.7,10.9c0.1,1.9-0.3,3.7-1.2,5.4
                                                    C671.3,317.6,653.7,327,636.3,315.8z"/>
                                                <path class="st13" d="M672.2,304.8c-0.3-0.5-0.6-1.1-0.8-1.7c-0.4-1-0.9-2.5-1.4-4.2c-0.5-1.6-1-3.1-1.3-4.2
                                                    c-0.2-0.6-0.3-1.2-0.4-1.8c0.3,0.5,0.5,1.1,0.6,1.7c0.4,1.2,0.9,2.6,1.4,4.2s1,3,1.3,4.2C671.9,303.6,672.1,304.2,672.2,304.8z"/>
                                                <path class="st13" d="M624.9,305.8c-0.2-0.3-0.4-0.7-0.4-1.1c-0.2-1-0.2-1.9,0-2.9s0.6-1.9,1.1-2.7c0.2-0.3,0.5-0.7,0.8-0.9
                                                    C624.8,300.5,624.3,303.2,624.9,305.8L624.9,305.8z"/>
                                                <path class="st12" d="M669.2,299.7c0,0.1-7.8,0.1-17.5,0.1s-17.5-0.2-17.5-0.3s7.8-0.1,17.5-0.1S669.2,299.6,669.2,299.7z"/>
                                                <path class="st12" d="M670.5,301c0,0.1-8,0.3-18,0.5s-18,0.2-18,0.1s8-0.3,18-0.5S670.5,300.9,670.5,301z"/>
                                                <path class="st13" d="M635.2,313.6c-0.1-0.4-0.2-0.7-0.3-1.1c-0.2-0.7-0.4-1.8-0.5-3.1c-0.4-3.4-0.5-6.9-0.1-10.4
                                                    c0.2-1.9,0.5-3.8,1-5.6c0.2-0.8,0.5-1.6,0.8-2.4c0.2-0.7,0.5-1.3,0.8-2c0.2-0.6,0.6-1.1,0.8-1.6c0.2-0.4,0.4-0.8,0.7-1.2
                                                    c0.2-0.3,0.4-0.6,0.7-0.9c0.1,0.1-0.9,1.4-1.9,3.8c-1.3,3.2-2.1,6.6-2.5,10c-0.3,3.4-0.3,6.9,0,10.3c0.1,1.3,0.3,2.4,0.4,3.1
                                                    C635.1,312.8,635.2,313.2,635.2,313.6z"/>
                                                <path class="st13" d="M651.5,277.3c0,0.1-0.2,0.3-0.5,0.6s-0.5,0.5-0.6,0.5s-0.1-0.5,0.3-0.8C651.1,277.3,651.5,277.2,651.5,277.3z
                                                    "/>
                                                <path class="st13" d="M649.8,274.6c0,0.1-0.3,0.2-0.7,0.4s-0.6,0.5-0.7,0.4c-0.1-0.1,0-0.5,0.5-0.8
                                                    C649.4,274.4,649.8,274.5,649.8,274.6z"/>
                                                <path class="st13" d="M649.4,272.1c-0.1,0.1-0.3-0.1-0.7-0.2c-0.3-0.1-0.6,0-0.7-0.1s0.3-0.4,0.8-0.3
                                                    C649.4,271.6,649.5,272.1,649.4,272.1z"/>
                                                <path class="st13" d="M653.7,280.4c-0.1,0-0.2-0.4,0-0.8s0.4-0.7,0.5-0.6s0,0.4-0.1,0.7C653.9,280.1,653.8,280.4,653.7,280.4z"/>
                                                <path class="st13" d="M657.5,280.9c-0.1,0-0.3-0.3-0.4-0.7s-0.1-0.8,0-0.8s0.3,0.3,0.4,0.7S657.6,280.9,657.5,280.9z"/>
                                                <path class="st13" d="M660.9,279.7c-0.1,0-0.3-0.3-0.6-0.6c-0.3-0.3-0.6-0.6-0.5-0.7c0-0.1,0.5,0,0.8,0.4S661,279.7,660.9,279.7z"
                                                    />
                                                <path class="st13" d="M663.8,277.3c-0.1,0-0.3-0.4-0.7-0.7c-0.4-0.3-0.8-0.4-0.9-0.5c0-0.1,0.6-0.3,1.1,0.1
                                                    S663.9,277.4,663.8,277.3z"/>
                                                <path class="st13" d="M665.1,274.3c-0.1,0-0.3-0.3-0.8-0.6c-0.5-0.3-0.9-0.3-0.9-0.4s0.5-0.3,1.1,0.1S665.2,274.3,665.1,274.3z"/>
                                                <g class="st23">
                                                    <path d="M634.9,311.9c-1.2-7.1-0.7-14.4,1.4-21.2c-3,2.9-5,6.8-5.6,10.9c-0.7,4.1,0.7,8.7,2.6,12.4L634.9,311.9z"/>
                                                </g>
                                                <path class="st13" d="M643.3,247.1c-3.8-9.3,1.7-15,5.3-17c2.2-1.1,4.6-1.6,7-1.5c2.4-0.1,4.8,0.2,7.1,0.7c2.3,0.6,4.5,1.8,6.1,3.6
                                                    c2.8,3.2,3.4,7.8,3.1,12.1c-0.4,5.1-1.9,10-4.5,14.4c-0.3,0.6-0.7,1.1-1.3,1.5s-1.3,0.2-1.7-0.3"/>
                                                <path class="st20" d="M656,279.4c4.1,0.3,7.7-3.2,8.3-9.7l2.8-32.6l-0.2,2.2c0.1-1.3-0.9-2.5-2.3-2.7l-12.7-1.5
                                                    c-4.3-0.5-8.2,2.7-8.6,7l0,0v0.3c-0.4,5-0.7,11.1-0.2,14.8c1,7.5,6.6,8.5,6.6,8.5l-0.5,5.4c-0.5,4.1,2.5,7.8,6.6,8.2L656,279.4
                                                    L656,279.4z"/>
                                                <path class="st13" d="M650.8,253.3c-0.5-0.2-1.1-0.3-1.6-0.3c-0.2,0-0.5-0.1-0.5-0.3c0-0.3,0-0.6,0.2-0.8c0.2-0.6,0.5-1.3,0.8-2
                                                    c0.7-1.7,1.3-3.4,1.8-5.2c-0.9,1.6-1.6,3.3-2.2,5.1c-0.3,0.7-0.5,1.4-0.8,2c-0.2,0.3-0.2,0.7-0.1,1c0.1,0.2,0.2,0.3,0.4,0.4
                                                    c0.1,0,0.3,0.1,0.5,0.1C649.7,253.3,650.2,253.4,650.8,253.3z"/>
                                                <path class="st18" d="M649.8,265.5c3.5,0.1,6.9-0.8,9.8-2.6c0,0-2.7,5.1-10,4.4L649.8,265.5z"/>
                                                <path class="st18" d="M651.2,255.8c0.4-0.5,1-0.7,1.6-0.7c0.5,0,0.9,0.3,1.1,0.6c0.3,0.4,0.3,0.8,0.1,1.2c-0.3,0.4-0.9,0.5-1.3,0.3
                                                    c-0.5-0.2-0.9-0.5-1.3-0.8c-0.1-0.1-0.2-0.2-0.3-0.3C651,256.1,651,256,651.2,255.8"/>
                                                <path class="st13" d="M653.7,254.1c-0.2,0-0.2,1.1-1.1,1.9s-2.1,0.7-2.1,0.8s0.2,0.2,0.8,0.2s1.3-0.2,1.8-0.6s0.8-1,0.9-1.6
                                                    C653.9,254.3,653.8,254.1,653.7,254.1z"/>
                                                <path class="st13" d="M654.1,243.9c0.1,0.3,1.1,0.2,2.3,0.3s2.1,0.5,2.3,0.2s-0.1-0.4-0.5-0.7c-0.5-0.3-1.1-0.6-1.7-0.6
                                                    c-0.6-0.1-1.2,0-1.8,0.2C654.3,243.6,654.1,243.8,654.1,243.9z"/>
                                                <path class="st13" d="M645.1,242.5c0.2,0.2,0.9,0,1.7,0s1.5,0.2,1.7-0.1c0.2-0.2,0-0.4-0.3-0.6c-0.4-0.3-0.9-0.4-1.4-0.4
                                                    s-1,0.2-1.4,0.4C645.1,242.1,645,242.3,645.1,242.5z"/>
                                                <path class="st13" d="M668.1,260.2c1.9-0.2,3.6-1.4,4.5-3.1c2.7-4.9,3.3-12.7,3.2-15.8c0-2.1-1.3-4-3.2-4.9c-1.6-0.7-1.8-0.6-3-1.9
                                                    c-5.6-5.9-13.2-8.9-20.3-4.9l0,0c-1.8,1-2.5,3.2-1.8,5.1c1.5,3.8,4.6,6.1,8,7.7c1.1,0.5,3.2,0.8,4.8,1.5c1.6,0.9,2.7,2.5,2.9,4.3
                                                    c0.3,2.6-2.5,5.2-1.6,7.6c0.5,1.4,2.1,2.1,2.7,3.5c0.5,1.2-0.5,4.2,0.3,5.7C664.6,265.1,667.4,260.7,668.1,260.2L668.1,260.2z"/>
                                                <path class="st13" d="M645.1,247.1c-0.1,0.5,0.3,0.9,0.8,1l0,0c0.5,0.1,0.9-0.2,1-0.7l0,0c0,0,0,0,0-0.1c0.1-0.5-0.3-0.9-0.8-1
                                                    S645.1,246.6,645.1,247.1C645.1,247,645.1,247,645.1,247.1L645.1,247.1z"/>
                                                <path class="st13" d="M644.9,246.2c0.1,0.1,0.8-0.4,1.8-0.3c1,0.1,1.6,0.6,1.8,0.5c0.1-0.1,0-0.3-0.3-0.5c-0.4-0.3-0.9-0.5-1.4-0.5
                                                    s-1,0.1-1.4,0.4C645,245.9,644.9,246.1,644.9,246.2z"/>
                                                <path class="st13" d="M654.5,247.7c-0.1,0.5,0.3,0.9,0.8,1l0,0c0.5,0.1,0.9-0.2,1-0.7l0,0c0,0,0,0,0-0.1c0.1-0.5-0.3-0.9-0.8-1l0,0
                                                    C655,246.8,654.5,247.1,654.5,247.7C654.5,247.6,654.5,247.6,654.5,247.7L654.5,247.7z"/>
                                                <path class="st13" d="M654.5,246.7c0.1,0.1,0.8-0.3,1.8-0.3c1,0.1,1.7,0.6,1.8,0.5s0-0.3-0.3-0.5c-0.4-0.3-0.9-0.5-1.4-0.5
                                                    s-1,0.1-1.4,0.4C654.6,246.5,654.4,246.7,654.5,246.7z"/>
                                                <path class="st17" d="M663.6,254.3c0,0,0.5-0.1,1.5-0.4c1.3-0.4,2.6-1.1,3.6-2c0.7-0.7,1.2-1.5,1.5-2.4c0.3-1,0.4-2.2,0.1-3.2
                                                    c-0.3-1.2-1-2.2-2-2.8c-1.2-0.6-2.4-0.9-3.7-0.9c-2.6-0.2-5.1-1-7.2-2.4c-1.8-1.1-3.4-2.6-4.6-4.3c-0.8-1.1-1.5-2.4-2-3.7
                                                    c-0.1-0.4-0.3-0.7-0.4-1.1c0-0.1-0.1-0.3-0.1-0.4c0,0,0.2,0.5,0.6,1.4c0.6,1.3,1.3,2.5,2.1,3.6c1.3,1.6,2.8,3,4.6,4.1
                                                    c2.2,1.3,4.6,2.1,7.1,2.4c1.4,0,2.7,0.3,3.9,0.9c1.1,0.7,1.9,1.8,2.2,3.1c0.3,1.1,0.2,2.3-0.2,3.4c-0.3,0.9-0.9,1.8-1.6,2.5
                                                    c-1.1,1-2.3,1.7-3.7,2c-0.4,0.1-0.7,0.2-1.1,0.2C664,254.3,663.8,254.3,663.6,254.3z"/>
                                                <path class="st17" d="M673.3,242.7c0.1-0.4,0.1-0.7,0.2-1.1c0-1-0.5-1.9-1.2-2.6c-1.1-1-2.5-1.6-4-1.6c-1.7-0.2-3.6,0.1-5.6-0.1
                                                    c-1.9-0.2-3.7-0.8-5.3-1.7c-1.3-0.8-2.5-1.8-3.5-3c-0.7-0.8-1.2-1.7-1.6-2.6c-0.1-0.3-0.2-0.5-0.3-0.8c0-0.1-0.1-0.2-0.1-0.3
                                                    c0.6,1.3,1.3,2.4,2.2,3.5c1,1.1,2.1,2.1,3.4,2.9c1.6,0.9,3.3,1.5,5.2,1.7c1.9,0.1,3.8-0.1,5.6,0.1c1.6,0.1,3.1,0.7,4.2,1.8
                                                    c0.7,0.8,1.1,1.8,1.1,2.9c0,0.3-0.1,0.5-0.2,0.8C673.4,242.6,673.4,242.7,673.3,242.7z"/>
                                                <path class="st17" d="M670.5,235.6c0.1,0,0.2,0,0.2,0.1c0.2,0.1,0.5,0.2,0.7,0.4c0.8,0.6,1.4,1.3,1.7,2.2c0.5,1.3,0.9,2.6,1,4
                                                    c0.2,1.7,0.2,3.4,0,5.1c-0.5,3-1.2,6-2.2,8.9l-0.8,2.6c-0.1,0.3-0.2,0.7-0.4,1c0-0.3,0.1-0.7,0.2-1c0.2-0.6,0.4-1.5,0.7-2.7
                                                    c0.9-2.9,1.6-5.9,2-8.9c0.2-1.7,0.2-3.3,0.1-5c-0.1-1.4-0.4-2.7-0.9-3.9c-0.3-0.8-0.9-1.6-1.6-2.2
                                                    C670.8,235.7,670.5,235.6,670.5,235.6z"/>
                                                <path class="st17" d="M675.8,244.6c-0.1,0-0.4-0.5-0.8-1s-0.9-0.8-0.8-0.9s0.7,0,1.2,0.6S675.9,244.5,675.8,244.6z"/>
                                                <path class="st17" d="M675.9,241.8c-0.1,0-0.3-0.6-0.7-1.1s-1-0.7-1-0.8s0.7-0.1,1.3,0.6C676.1,241.1,676,241.8,675.9,241.8z"/>

                                            </g>    
                                                
                                                <path class="st12" d="M426.9,188.7l-7,4.4c-19.4-10.2-43.3-2.8-53.5,16.5s-2.8,43.3,16.5,53.5s43.3,2.8,53.5-16.5
                                                    c8.9-16.9,4.5-37.7-10.4-49.5L426.9,188.7z"/>
                                                <path class="st13" d="M426.9,188.7c-0.1,0.5-0.3,2.9-0.8,8.4l0,0c3.4,2.7,6.4,5.9,8.8,9.6c0.5,0.7,0.9,1.6,1.4,2.4
                                                    c0.5,0.8,0.9,1.7,1.3,2.6c0.4,0.9,0.8,1.8,1.2,2.8l1,3l0.2,0.8c0,0.3,0.1,0.5,0.2,0.8c0.1,0.5,0.2,1.1,0.4,1.6
                                                    c0.1,0.5,0.2,1.1,0.3,1.7l0.2,1.7c1.2,10.6-1.9,21.3-8.7,29.6l-0.7,0.9l-0.8,0.8l-1.5,1.6l-0.4,0.4l-0.4,0.4l-0.9,0.7L426,260
                                                    l-1.9,1.3c-0.6,0.5-1.3,0.9-1.9,1.3l-2,1.1l-1,0.6c-0.4,0.2-0.7,0.3-1.1,0.5l-2.2,1c-0.4,0.2-0.7,0.3-1.1,0.4l-1.1,0.4
                                                    c-0.8,0.2-1.5,0.5-2.3,0.7l-2.4,0.5c-0.4,0.1-0.8,0.2-1.2,0.2l-1.2,0.1l-2.5,0.3c-0.8,0-1.6,0-2.5,0h-1.3c-0.4,0-0.8,0-1.2-0.1
                                                    l-2.5-0.2c-0.8-0.1-1.7-0.3-2.5-0.4c-1.7-0.3-3.4-0.7-5-1.2c-0.8-0.3-1.6-0.6-2.4-0.9l-1.2-0.5c-0.4-0.2-0.8-0.4-1.2-0.6l-2.3-1.2
                                                    c-0.8-0.4-1.5-0.9-2.2-1.4l-1.1-0.7c-0.4-0.2-0.7-0.5-1-0.8l-2.1-1.6c-0.6-0.6-1.3-1.2-1.9-1.8l-0.9-0.9c-0.3-0.3-0.6-0.6-0.9-1
                                                    l-1.7-2c-0.5-0.7-1-1.4-1.5-2.1c-1-1.4-1.9-2.8-2.6-4.3c-0.4-0.7-0.8-1.5-1.1-2.3c-0.3-0.8-0.7-1.5-1-2.3l-0.8-2.4l-0.4-1.2
                                                    c-0.1-0.4-0.2-0.8-0.3-1.2l-0.5-2.4c-0.1-0.8-0.2-1.6-0.3-2.4l-0.1-1.2l-0.1-0.6v-3c0-0.8,0-1.6,0.1-2.4l0.2-2.3
                                                    c0.1-0.8,0.3-1.5,0.4-2.3s0.3-1.5,0.5-2.2c0.4-1.5,0.8-2.9,1.4-4.3l0.8-2.1c0.3-0.7,0.7-1.3,1-2c2.5-5,6.1-9.4,10.5-12.9
                                                    c2-1.6,4.2-3,6.4-4.3c1.1-0.5,2.2-1.1,3.3-1.6c0.6-0.2,1.1-0.5,1.7-0.7l1.7-0.6c7.5-2.3,15.6-2.4,23.2-0.2c2.6,0.8,5,1.8,7.4,3H420
                                                    l7.1-4.3l-7,4.5l0,0c-2.4-1.2-4.9-2.2-7.4-2.9c-7.5-2.2-15.5-2.1-23,0.3l-1.7,0.7c-0.6,0.2-1.1,0.4-1.7,0.7c-1.1,0.4-2.2,1-3.3,1.6
                                                    c-2.2,1.2-4.4,2.6-6.4,4.2c-4.3,3.5-7.9,7.9-10.4,12.9c-0.3,0.7-0.7,1.3-1,2s-0.5,1.4-0.8,2.1c-0.5,1.4-1,2.8-1.3,4.3
                                                    c-0.2,0.7-0.4,1.5-0.5,2.2c-0.1,0.8-0.3,1.5-0.4,2.3s-0.1,1.5-0.2,2.3s-0.1,1.6-0.1,2.3v3l0.1,0.6l0.1,1.2c0.1,0.8,0.1,1.6,0.3,2.4
                                                    s0.3,1.6,0.5,2.4c0.1,0.4,0.2,0.8,0.3,1.2l0.4,1.2c0.2,0.8,0.5,1.6,0.7,2.4c0.3,0.8,0.6,1.5,1,2.3c0.3,0.8,0.7,1.5,1.1,2.2
                                                    c0.8,1.5,1.6,2.9,2.6,4.3c0.5,0.7,0.9,1.4,1.5,2.1l1.7,1.9c0.3,0.3,0.5,0.7,0.8,1l0.9,0.9c0.6,0.6,1.2,1.2,1.9,1.8l2,1.6
                                                    c0.3,0.2,0.7,0.5,1,0.8l1.1,0.7c0.7,0.5,1.4,1,2.2,1.4l2.3,1.2c0.4,0.2,0.8,0.4,1.2,0.6l1.2,0.5c0.8,0.3,1.6,0.6,2.4,0.9
                                                    c1.6,0.5,3.3,0.9,4.9,1.2c0.8,0.1,1.7,0.3,2.5,0.4l2.5,0.2c0.4,0,0.8,0.1,1.2,0.1h1.2c0.8,0,1.6,0,2.5,0l2.4-0.3l1.2-0.1l1.2-0.2
                                                    l2.4-0.5c0.8-0.2,1.5-0.5,2.3-0.7l1.1-0.4c0.4-0.1,0.8-0.2,1.1-0.4l2.2-0.9c0.4-0.2,0.7-0.3,1.1-0.5l1-0.6l2-1.1
                                                    c0.7-0.4,1.3-0.9,1.9-1.3l1.9-1.4l1.7-1.5l0.9-0.7l0.4-0.4l0.4-0.4l1.5-1.6l0.8-0.8l0.7-0.9c6.7-8.2,9.8-18.8,8.7-29.4
                                                    c-0.1-0.6-0.1-1.1-0.2-1.7c-0.1-0.6-0.2-1.1-0.3-1.6l-0.3-1.6l-0.2-0.8l-0.2-0.8c-0.3-1-0.6-2-1-3l-1.2-2.7
                                                    c-0.4-0.9-0.8-1.7-1.3-2.5s-0.9-1.6-1.4-2.4c-0.9-1.4-1.9-2.7-3-4c-1.7-2.1-3.6-4-5.7-5.6l0,0l0,0
                                                    C426.5,191.6,426.8,189.2,426.9,188.7z"/>
                                                <path class="st24" d="M423.7,236.6l1,7.7l11.7-10l6.4,1.5c0,0-6.6,13.8-11.8,19.3c-5.2,5.5-8,6.3-10,6.4c-2.7,0.1-3.9-3.2-3.9-3.2
                                                    l-1.2-19L423.7,236.6z"/>
                                                <path class="st25" d="M424.6,244c-0.4,0.6-0.7,1.2-0.8,1.9c-0.2,0.7-0.3,1.4-0.3,2.1c0.2-0.7,0.4-1.3,0.5-2
                                                    C424.3,245.3,424.5,244.7,424.6,244z"/>
                                                <path class="st17" d="M437.5,214.8h8.8c1.2,0.1,2.2,1.1,2.1,2.4c0,0.2,0,0.3-0.1,0.4l-8.9,17.2c-0.3,0.7-1,1.1-1.8,1.1h-10.7
                                                    c-0.8-0.1-1.4-0.9-1.4-1.7c0-0.2,0.1-0.4,0.2-0.6l8.5-16.9C434.9,215.6,436.1,214.8,437.5,214.8z"/>
                                                <path class="st13" d="M438.1,215.9h8.8c0.8,0,1.5,0.7,1.5,1.5l0,0c0,0.2-0.1,0.5-0.2,0.7l-8.6,16.9c-0.3,0.7-1,1.1-1.8,1.1h-10.6
                                                    c-0.5,0-0.9-0.4-0.9-0.8l0,0c0-0.1,0-0.3,0.1-0.4l8.5-16.9C435.5,216.6,436.7,215.9,438.1,215.9z"/>
                                                <path class="st24" d="M438.8,222.9l5.4,2.1l1.1,4.3l-2.5,6.4l-9.5,1.4l2.8-2.8l-0.4-2.5c0,0-2.6-0.8-2.7-1.2s0.3-1.8,0.7-1.8
                                                    c1.1,0.2,2.1,0.6,3.2,1c0,0-3.3-2.6-3.2-3s0.5-1.5,1.1-1.6s5.9,2.4,5.9,2.4l0.9,2l0.8-3.1C442.3,226.4,437.6,225.1,438.8,222.9z"/>
                                                <path class="st25" d="M438.1,233c0.1-0.2,0.2-0.3,0.2-0.5c0.1-0.9-0.2-1.8-0.9-2.5c-0.3-0.2-0.5-0.3-0.5-0.3
                                                    C437.8,230.6,438.2,231.8,438.1,233L438.1,233z"/>
                                                <path class="st25" d="M440.7,232.1c-0.1-0.5-0.2-0.9-0.2-1.4s-0.1-1-0.3-1.6c-0.1-0.3-0.3-0.6-0.5-0.8c-0.3-0.2-0.6-0.4-0.9-0.6
                                                    c-1.3-0.5-2.4-0.8-3.3-1.1c-0.5-0.2-0.9-0.3-1.4-0.4c0.4,0.2,0.9,0.4,1.3,0.6c0.8,0.3,2,0.7,3.2,1.2c0.3,0.1,0.6,0.3,0.8,0.5
                                                    c0.2,0.2,0.3,0.5,0.4,0.7c0.2,0.5,0.3,1,0.3,1.5C440.3,231.3,440.4,231.7,440.7,232.1z"/>
                                                <path class="st25" d="M441.9,231.1c0.1,0,0.1-0.5,0-1.1c0-0.4-0.1-0.7-0.3-1C441.5,229.8,441.6,230.5,441.9,231.1L441.9,231.1z"/>
                                                <circle class="st12" cx="440.9" cy="219.1" r="1.1"/>
                                                <path class="st13" d="M409.2,173.8c3,8,6.2,16.6,13.1,21.7c-0.9,0.2-1.9,0.1-2.7-0.4c1.6,2.4,2.9,4.9,3.8,7.6
                                                    c0.9,2.7,0.6,5.8-0.9,8.3c-0.2-0.3-0.4-0.6-0.5-0.9c1.6,6.1-0.9,12.5-6.2,15.9c-2.3,1.4-5.3,2-7.5,0.6c-1.7-1.1-2.5-3.1-3.2-5
                                                    l-13.6-36.7c-1.3-3.4-2.5-7-1.9-10.6c1-5.7,6.5-9.5,12.2-8.5c2.7,0.5,5.1,2,6.7,4.3"/>
                                                <path class="st17" d="M417.1,218.8c0.1-0.1,0.2-0.1,0.2-0.2c0.2-0.2,0.4-0.5,0.6-0.7c0.6-0.9,1.1-2,1.4-3.1c0.4-1.6,0.5-3.3,0.3-5
                                                    c-0.3-2-0.9-4-1.7-5.9c-0.9-2-1.8-3.8-2.6-5.5c-0.8-1.5-1.4-3-2-4.5c-0.4-1-0.7-2.1-0.9-3.2c0-0.4-0.1-0.8-0.2-1.2
                                                    c0,0.1,0,0.2,0,0.3c0,0.3,0.1,0.6,0.1,0.9c0.2,1.1,0.4,2.2,0.8,3.2c0.6,1.6,1.2,3.1,2,4.6c0.8,1.7,1.8,3.5,2.6,5.5
                                                    c0.8,1.8,1.4,3.8,1.7,5.8c0.2,1.6,0.2,3.3-0.2,4.9c-0.3,1.1-0.7,2.1-1.3,3C417.6,218.1,417.3,218.5,417.1,218.8z"/>
                                                <path class="st24" d="M400.1,169.2c6.1,0.3,10.9,5.3,10.9,11.4c0,4.7-0.1,9.9-0.4,12.9c-0.7,7.1-6,8.3-6,8.3s0.2,4.4,0.4,8.6
                                                    c0.1,4.2-3.2,7.6-7.3,7.9l0,0c-4,0.5-7.6-2.4-8.1-6.4v-0.1l-1.5-30.6c-0.3-6.3,4.6-11.7,10.9-12l0,0L400.1,169.2L400.1,169.2z"/>
                                                <path class="st13" d="M408.5,183.4c0,0.5-0.3,0.9-0.8,1s-0.9-0.3-1-0.7l0,0c-0.1-0.5,0.3-0.9,0.8-1l0,0
                                                    C408,182.6,408.5,182.9,408.5,183.4L408.5,183.4L408.5,183.4z"/>
                                                <path class="st13" d="M409.4,182.3c-0.1,0.1-0.8-0.3-1.8-0.3s-1.6,0.6-1.8,0.5s0-0.3,0.3-0.5c0.4-0.3,0.9-0.5,1.4-0.5
                                                    s1,0.1,1.4,0.4C409.4,182.1,409.5,182.3,409.4,182.3z"/>
                                                <path class="st13" d="M398.4,184.3c0.1,0.5-0.3,0.9-0.8,1l0,0c-0.5,0.1-0.9-0.2-1-0.7l0,0l0,0c-0.1-0.5,0.3-0.9,0.8-1
                                                    S398.4,183.8,398.4,184.3L398.4,184.3L398.4,184.3z"/>
                                                <path class="st13" d="M399.3,183.3c-0.1,0.1-0.8-0.4-1.8-0.3c-1,0.1-1.6,0.6-1.8,0.5c-0.1-0.1,0-0.3,0.3-0.5
                                                    c0.4-0.3,0.9-0.5,1.4-0.5s1,0.1,1.4,0.4C399.2,183,399.4,183.2,399.3,183.3z"/>
                                                <path class="st13" d="M403.3,190.3c0.5-0.2,1-0.3,1.6-0.4c0.2,0,0.5-0.1,0.5-0.3c0-0.3-0.1-0.5-0.2-0.7l-0.9-1.8
                                                    c-0.8-1.6-1.4-3.2-1.9-4.8c0.9,1.5,1.7,3.1,2.3,4.7l0.8,1.9c0.2,0.3,0.3,0.7,0.2,1c-0.1,0.2-0.2,0.3-0.4,0.4
                                                    c-0.1,0-0.3,0.1-0.4,0.1C404.3,190.3,403.8,190.3,403.3,190.3z"/>
                                                <path class="st25" d="M404.7,201.9c-3.3,0.1-6.7-0.6-9.7-2.1c0,0,2.6,5.1,9.7,4.1V201.9z"/>
                                                <path class="st13" d="M396.1,180.6c0.1,0.2,0.8-0.1,1.7-0.3c0.9-0.2,1.6-0.2,1.7-0.4s-0.8-0.5-1.8-0.3
                                                    C396.6,179.8,396,180.4,396.1,180.6z"/>
                                                <path class="st13" d="M405.8,178.8c0,0.2,0.9,0.2,1.8,0.2s1.8,0.1,1.8-0.1s-0.7-0.6-1.8-0.6S405.7,178.7,405.8,178.8z"/>
                                                <path class="st13" d="M378.2,212.4c0,0,2.5-5,0.9-9.4s-1-7.8,1.3-9.6c1.6-1.2,1.8-3.3,1.6-4.9c-0.3-2.7-0.2-5.4,0.2-8.1
                                                    c0.6-3.9,1.8-7.9,4.1-11c3-3.9,8.5-7.5,13-5.5c2.1,0.9,3.2,0.9,5.4,2.9c0,0,2,0.1,3.1,0.3c3.7,0.6,6.1,4.5,6.5,7.4
                                                    c1,6.7-2.7,8.6-3,13.1c0,0-0.7-9.4-1.5-11.8c-0.7-1.8-2-3.2-3.6-4.1c-2.7,0.3-3.8,1.9-4.6,4.4s-1.4,4.6-3.5,6.3
                                                    c-2.2,1.7-3.5,4.2-7.2,2.9c-0.7,1.4-0.9,2.9-0.8,4.5c0.4,2.3,2.9,2.9,2.3,6.8s-3,7.1-2.9,8.5"/>
                                                <path class="st25" d="M402.1,192.6c-0.3-0.4-0.8-0.5-1.3-0.4c-0.4,0.1-0.7,0.3-0.9,0.6c-0.2,0.3-0.2,0.7,0,1
                                                    c0.3,0.3,0.7,0.3,1.1,0.2c0.4-0.2,0.7-0.4,1-0.7c0.1-0.1,0.2-0.2,0.2-0.2C402.2,192.9,402.2,192.8,402.1,192.6"/>
                                                <path class="st13" d="M400,191.4c0.1,0,0.2,0.9,1,1.4s1.7,0.4,1.7,0.5s-0.2,0.2-0.6,0.2c-0.5,0-1-0.1-1.4-0.4
                                                    c-0.4-0.3-0.7-0.7-0.8-1.2C399.8,191.6,399.9,191.4,400,191.4z"/>
                                                <path class="st13" d="M385.8,170.2c-1.3,2.2-2.8,4.2-4.5,6.2c-1.8,2-3.6,4.2-3.7,6.9c-0.1,1.9,0.7,4,0,5.7
                                                    c-0.7,1.5-2.3,2.4-3.4,3.5c-2.1,2.1-2.9,5.1-2.2,8c0.5,1.8,1.7,3.5,1.3,5.3c-0.4,1.6-1.8,2.7-2.3,4.3c-0.3,1.5,0,3.1,0.8,4.4
                                                    c1,2.1,2.5,4.3,4.8,4.8c1.6,0.3,3.2-0.1,4.5-1.1s2.3-2.3,3-3.7c1.5-2.7,2.4-5.7,2.7-8.8c0.4-3.7-0.2-7.4-0.6-11
                                                    c-0.7-6.7-0.7-13.5,0-20.2C386.3,172.9,387,171.3,385.8,170.2"/>
                                                <path class="st24" d="M392.2,186.2c0-0.5-1.2-1.3-1.7-1.3c-1.1,0-2.8,0.5-2.9,3.5c0,4.3,4,3,4,2.9
                                                    C391.9,189.7,392.1,188,392.2,186.2z"/>
                                                <path class="st25" d="M390.6,189.7c-0.1,0-0.1,0.1-0.2,0.1c-0.2,0.1-0.4,0.1-0.6,0c-0.5-0.4-0.9-1-0.8-1.6c0-0.4,0.1-0.7,0.2-1.1
                                                    c0.1-0.3,0.3-0.5,0.6-0.6c0.2,0,0.4,0,0.5,0.2c0,0.1,0,0.2,0,0.2s0.1-0.1,0.1-0.2c0-0.1-0.1-0.2-0.2-0.3s-0.3-0.1-0.4-0.1
                                                    c-0.4,0.1-0.7,0.3-0.8,0.6c-0.2,0.4-0.3,0.8-0.3,1.2c0,0.8,0.4,1.5,1.1,1.9c0.2,0.1,0.5,0,0.7-0.1
                                                    C390.6,189.8,390.7,189.7,390.6,189.7z"/>
                                                <path class="st17" d="M412.5,184.6c-0.1-0.2-0.1-0.5-0.2-0.7c-0.2-0.7-0.3-1.3-0.3-2c0-1,0.1-2,0.3-3c0.2-1.2,0.3-2.5,0.3-3.7
                                                    c0-0.7-0.2-1.3-0.4-1.9c-0.2-0.6-0.5-1.1-0.9-1.6c-0.7-0.8-1.5-1.4-2.5-1.8c-0.6-0.3-1.3-0.4-2-0.4c-0.2,0-0.4,0-0.6,0
                                                    c-0.1,0-0.1,0-0.2,0h0.7c1.7,0.1,3.3,0.9,4.3,2.2c0.4,0.5,0.6,1,0.8,1.5c0.2,0.6,0.3,1.2,0.3,1.9c0,1.2-0.1,2.5-0.3,3.7
                                                    c-0.2,1-0.2,2-0.2,3c0,0.7,0.1,1.4,0.3,2c0.1,0.2,0.1,0.4,0.2,0.5C412.4,184.5,412.5,184.6,412.5,184.6z"/>
                                                <path class="st26" d="M388.2,191.1c-0.1,0.1-0.2,0.2-0.3,0.4c-0.2,0.4-0.3,0.8-0.3,1.2c0,0.7,0.4,1.3,0.9,1.6
                                                    c0.6,0.5,1.5,0.6,2.2,0.2c0.7-0.3,1.2-1,1.3-1.8c0-0.3,0-0.7-0.2-1c-0.1-0.3-0.3-0.5-0.6-0.7c-0.3-0.3-0.7-0.4-1.2-0.4
                                                    c-0.2,0-0.3,0-0.5,0.1h0.5c0.4,0.1,0.8,0.2,1.1,0.5c0.4,0.4,0.7,0.9,0.6,1.5c-0.1,0.7-0.5,1.3-1.2,1.6s-1.4,0.2-2-0.2
                                                    c-0.5-0.3-0.8-0.8-0.9-1.4c0-0.4,0.1-0.8,0.2-1.1C388,191.3,388.1,191.2,388.2,191.1z"/>
                                                <path class="st17" d="M377.6,188.7c0-0.1,0-0.3,0.1-0.4c0.1-0.3,0.2-0.7,0.4-1c0.7-1.1,1.6-2.1,2.7-2.9c0.8-0.5,1.6-0.9,2.5-1
                                                    c1-0.2,2.1-0.2,3.1-0.1c1.1,0.1,2.3,0.1,3.4,0c1.2-0.2,2.3-0.6,3.3-1.3s1.9-1.5,2.8-2.3c0.9-0.7,1.7-1.5,2.4-2.4
                                                    c1.3-1.7,2.6-3.2,3.6-4.5c0.8-1,1.5-2.1,2.1-3.2c0.4-0.8,0.6-1.3,0.6-1.3c0,0.1,0,0.2-0.1,0.4s-0.2,0.6-0.4,1
                                                    c-0.6,1.2-1.2,2.3-2,3.3c-1,1.4-2.2,2.9-3.5,4.6c-0.7,0.9-1.5,1.7-2.4,2.5s-1.9,1.6-2.9,2.4c-1.1,0.7-2.3,1.1-3.5,1.3
                                                    c-1.1,0.1-2.3,0.1-3.5,0c-1-0.1-2,0-3,0.1c-0.9,0.1-1.7,0.4-2.4,0.9c-1.1,0.7-2,1.6-2.7,2.7C378.1,187.8,377.8,188.2,377.6,188.7z"
                                                    />
                                                
                                                    <linearGradient id="SVGID_00000016034523639725527920000002597698889784592317_" gradientUnits="userSpaceOnUse" x1="397.5747" y1="409.5003" x2="426.8936" y2="409.5003" gradientTransform="matrix(1 0 0 1 0 -178)">
                                                    <stop  offset="0" style="stop-color:#00FFAF"/>
                                                    <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                    <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                    <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                    <stop  offset="0.75" style="stop-color:#00469F"/>
                                                    <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                    <stop  offset="1" style="stop-color:#00249C"/>
                                                </linearGradient>
                                                <path style="fill:url(#SVGID_00000016034523639725527920000002597698889784592317_);" d="M400.6,218c1.5-4.7,5.3-9.5,9.4-7.8
                                                    c4.6,1.9,5.9,4.4,8.4,8.1s4,8.1,5.6,12.4c0.6,1.7,3.7,9.4,2.8,10.9c-0.8,1.3-8.6,11.1-10.1,11.5c-3.8,1-4-13.2-7.9-12.4
                                                    c-1.6,0.3-3.3,0.5-4.6-0.2c-1.8-1-2.3-3.2-2.6-5.2c-1.3-6.9-2.6-13.9-3.9-20.9"/>
                                                
                                                    <linearGradient id="SVGID_00000011751182419536632710000018035708157140372638_" gradientUnits="userSpaceOnUse" x1="376.2969" y1="416.0826" x2="417.1" y2="416.0826" gradientTransform="matrix(1 0 0 1 0 -178)">
                                                    <stop  offset="0" style="stop-color:#00FFAF"/>
                                                    <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                    <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                    <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                    <stop  offset="0.75" style="stop-color:#00469F"/>
                                                    <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                    <stop  offset="1" style="stop-color:#00249C"/>
                                                </linearGradient>
                                                <path style="fill:url(#SVGID_00000011751182419536632710000018035708157140372638_);" d="M404.8,208.3l6,2.6
                                                    c3.1,2.4,3.9,6.5,3.8,10.4l2.3,32.2l0.2,11.1c0,0-17.8,9.7-37.7-2.9l3.3-8.8l-6-20.9c-0.4-3-0.7-9.4,0.1-12.4
                                                    c2-7.7,7.5-10,13.1-11.6c0,0,5.6,4.7,11.1,3.7C401.1,211.9,404.4,211.6,404.8,208.3z"/>
                                                <g class="st16">
                                                    <path d="M413.1,243.4l-10.5,15.2c-1.2,2.1-2.9,3.9-4.8,5.3c-3,1.9-6.9,1.8-9.9-0.1c-2.9-1.9-5.5-7.1-4.8-10.6
                                                        c0.1-0.4,1.4,0.3,1.4,0.3c0.5-0.4,1.2-0.6,1.8-0.3c0.6,0.2,1.2,0.5,1.7,0.9c3.3,1.7,7.4,0.8,10.5-1.3s5.3-5.1,7.7-8
                                                        c0.8-1.1,1.9-2,3.1-2.6c1.3-0.6,2.8-0.1,3.5,1.2"/>
                                                </g>
                                                <path class="st24" d="M395.1,240.2l0.9,3.6l18.4-13.4l5.6-8c0.8-1.1,1.9-1.8,3.2-2l0,0c1.4-0.3,2.8,0,3.9,0.8l5.2,3.7
                                                    c0,0-0.1,2.8-1.4,2.2s-3.8-2-3.8-2l-0.7,6.8l-3.1,2.3l-3.1,2.4l-20.7,20.6c-3.6,3.6-9.5,3.6-13.1,0l0,0c-0.7-0.7-1.3-1.5-1.7-2.4
                                                    l-3.1-8.7L395.1,240.2z"/>
                                                <path class="st25" d="M396.4,243.2c-0.3,0.1-0.5,0.3-0.8,0.5c-0.5,0.5-0.9,1.2-1.1,1.9s-0.2,1.4-0.2,2.2c0,0.3,0,0.6,0.1,0.9
                                                    c0.1-0.3,0.1-0.6,0.1-0.9c0-0.7,0.1-1.4,0.3-2.1c0.2-0.7,0.5-1.3,0.9-1.8C396.2,243.4,396.5,243.3,396.4,243.2z"/>
                                                <path class="st25" d="M427.1,225.5c-0.1-0.2-0.2-0.4-0.3-0.5c-0.3-0.4-0.7-0.8-1.2-0.9c-0.5-0.2-1.1-0.1-1.5,0.3
                                                    c-0.3,0.3-0.3,0.6-0.3,0.6c0.1-0.2,0.2-0.3,0.4-0.4c0.4-0.2,0.8-0.3,1.3-0.2c0.4,0.2,0.8,0.4,1.1,0.8
                                                    C426.9,225.4,427,225.5,427.1,225.5z"/>
                                                <path class="st25" d="M423.8,227.3l0.4-0.2c0.3-0.2,0.7-0.3,1-0.3c0.4,0,0.7,0.1,1,0.3c0.2,0.1,0.4,0.3,0.4,0.2s-0.1-0.2-0.3-0.4
                                                    c-0.7-0.5-1.6-0.5-2.3,0C423.8,227.1,423.8,227.3,423.8,227.3z"/>
                                                
                                                    <linearGradient id="SVGID_00000098214261765340954160000000453971300976595074_" gradientUnits="userSpaceOnUse" x1="372.9289" y1="409.0516" x2="399.3142" y2="409.0516" gradientTransform="matrix(1 0 0 1 0 -178)">
                                                    <stop  offset="0" style="stop-color:#00FFAF"/>
                                                    <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                    <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                    <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                    <stop  offset="0.75" style="stop-color:#00469F"/>
                                                    <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                    <stop  offset="1" style="stop-color:#00249C"/>
                                                </linearGradient>
                                                <path style="fill:url(#SVGID_00000098214261765340954160000000453971300976595074_);" d="M387.9,208.6c-4.1,1.7-8.4,3.6-11.3,7
                                                    s-3.9,8.2-3.7,12.8c0.2,4.5,0.2,8.8,1.5,13.1c0.7,2.6,1.5,5.2,2.5,7.7c1.1,2.1,6.1,4.4,8.5,4.3c4-0.1,5.8-7.6,9.4-9.3
                                                    c1.4-0.7,3.7-3.7,4.3-5.1c0.8-1.8-1.6-5.3-2.5-7.1l-9.2-19.1"/>
                                                <path class="st13" d="M395.6,243.8c0-0.1,0.1-0.2,0.1-0.4c0.1-0.3,0.2-0.7,0.2-1c0-0.5-0.2-1-0.6-1.4c-0.5-0.4-1.2-0.6-1.9-0.5
                                                    h-0.2v-0.2c-0.2-1.5-0.7-2.9-1.5-4.2c-0.9-1.6-2.1-2.9-3.6-3.9c-1.6-1.1-3.5-1.8-5.4-2.2c-1.6-0.4-3.2-0.6-4.8-0.7
                                                    c-1.4-0.1-2.5-0.1-3.2-0.1c-0.4,0-0.8,0-1.2,0c0.4-0.1,0.8-0.2,1.2-0.2c1.1-0.1,2.2-0.1,3.3-0.1c1.6,0.1,3.2,0.3,4.8,0.6
                                                    c2,0.4,3.8,1.1,5.5,2.2c1.5,1,2.8,2.4,3.7,4c0.8,1.3,1.3,2.8,1.4,4.4l-0.2-0.1c0.8-0.1,1.6,0.1,2.1,0.6c0.4,0.4,0.6,1,0.6,1.6
                                                    c-0.1,0.4-0.2,0.7-0.4,1C395.6,243.7,395.6,243.8,395.6,243.8z"/>
                                                <path class="st13" d="M386.8,247c1.8-2.6,4.1-4.8,6.9-6.4c0.1,0.1-1.6,1.4-3.5,3.1S386.8,247.1,386.8,247z"/>
                                                <g class="st23">
                                                    <path d="M393.4,240.4c-1.7,0.6-3.2,1.4-4.7,2.5c-1.4,1-2.4,2.6-2.8,4.4l1.5-1.4c2-1.9,4.1-3.6,6.3-5.2"/>
                                                </g>
                                                <path class="st13" d="M414.8,229.7c0-0.5,0.1-1.1,0.3-1.6c0.4-1.2,0.9-2.4,1.5-3.5c0.7-1.6,1.8-3.1,3-4.4c-0.2,0.5-0.5,0.9-0.8,1.4
                                                    c-0.5,0.8-1.2,2-1.9,3.3c-0.6,1.1-1.1,2.2-1.6,3.4C415.2,228.8,415,229.2,414.8,229.7z"/>
                                                <path class="st13" d="M417.1,262.1c-0.1-0.3-0.1-0.6-0.1-0.9c-0.1-0.6-0.1-1.4-0.2-2.4c-0.1-2-0.2-4.8-0.2-7.8s0-5.8,0.1-7.8
                                                    c0-1,0.1-1.8,0.1-2.4c0-0.3,0-0.6,0.1-0.9c0.1,0.3,0.1,0.6,0.1,0.9V251c0,3,0,5.7,0.1,7.8v2.4C417.1,261.5,417.2,261.8,417.1,262.1
                                                    z"/>
                                                <path class="st0" d="M409.8,227.5c-0.2-0.7-0.4-1.4-0.5-2.1c-0.1-0.7-0.3-1.4-0.3-2.1c0.2,0.7,0.4,1.4,0.5,2.1
                                                    S409.7,226.8,409.8,227.5z"/>
                                                <path class="st0" d="M411.1,224.7c-0.5,0.3-1.1,0.5-1.6,0.7s-1.1,0.4-1.7,0.4c0.5-0.2,1.1-0.4,1.6-0.6
                                                    C410,225,410.5,224.8,411.1,224.7z"/>
                                                <path class="st0" d="M408.7,227c0.4-1.1,0.8-2.2,1.4-3.3c-0.2,0.6-0.4,1.1-0.6,1.7C409.2,225.9,409,226.5,408.7,227z"/>
                                                <path class="st0" d="M411.1,226.6c-1.1-0.7-2.1-1.4-3.1-2.2c0.6,0.3,1.1,0.7,1.6,1.1C410.1,225.8,410.6,226.2,411.1,226.6z"/>
                                                <path class="st0" d="M414.6,252.2c-0.2-0.7-0.4-1.4-0.5-2.1c-0.2-0.7-0.3-1.4-0.3-2.2c0.2,0.7,0.4,1.4,0.5,2.1
                                                    C414.4,250.8,414.5,251.5,414.6,252.2z"/>
                                                <path class="st0" d="M415.9,249.4c-1,0.5-2.1,0.9-3.2,1.1c0.5-0.2,1.1-0.4,1.6-0.6C414.8,249.7,415.3,249.6,415.9,249.4z"/>
                                                <path class="st0" d="M413.5,251.8c0.2-0.6,0.4-1.1,0.6-1.7c0.2-0.6,0.5-1.1,0.7-1.6c-0.1,0.6-0.3,1.1-0.6,1.7
                                                    C414,250.7,413.7,251.3,413.5,251.8z"/>
                                                <path class="st0" d="M415.8,251.4c-0.5-0.3-1.1-0.7-1.6-1.1c-0.5-0.3-1-0.7-1.5-1.2c0.6,0.3,1.1,0.7,1.6,1.1
                                                    C414.9,250.6,415.4,250.9,415.8,251.4z"/>
                                                <path class="st0" d="M421.4,242.5c-0.2-0.7-0.4-1.4-0.5-2.1c-0.2-0.7-0.3-1.4-0.3-2.1c0.2,0.7,0.4,1.4,0.5,2.1
                                                    S421.3,241.8,421.4,242.5z"/>
                                                <path class="st0" d="M422.8,239.6c-0.5,0.3-1.1,0.5-1.6,0.7s-1.1,0.4-1.7,0.4c0.5-0.2,1.1-0.4,1.6-0.6
                                                    C421.6,239.9,422.2,239.8,422.8,239.6z"/>
                                                <path class="st0" d="M420.3,242c0.4-1.1,0.8-2.2,1.4-3.3c-0.1,0.6-0.3,1.1-0.6,1.7C420.8,240.9,420.6,241.5,420.3,242z"/>
                                                <path class="st0" d="M422.7,241.6c-0.6-0.3-1.1-0.7-1.6-1.1c-0.5-0.4-1-0.7-1.5-1.1c0.6,0.3,1.1,0.7,1.6,1.1
                                                    C421.8,240.8,422.2,241.2,422.7,241.6z"/>
                                                <path class="st0" d="M411.9,218.2c-0.3-1.4-0.6-2.8-0.8-4.2c0.2,0.7,0.4,1.4,0.5,2.1C411.8,216.8,411.9,217.5,411.9,218.2z"/>
                                                <path class="st0" d="M413.3,215.4c-0.5,0.3-1.1,0.5-1.6,0.7s-1.1,0.4-1.7,0.4C411,216.1,412.1,215.7,413.3,215.4L413.3,215.4z"/>
                                                <path class="st0" d="M410.8,217.7c0.2-0.6,0.4-1.1,0.6-1.7c0.2-0.6,0.4-1.1,0.7-1.6c-0.2,0.6-0.4,1.1-0.6,1.7
                                                    C411.4,216.6,411.2,217.2,410.8,217.7z"/>
                                                <path class="st0" d="M413.2,217.3c-0.6-0.3-1.1-0.7-1.6-1.1c-0.5-0.4-1-0.8-1.5-1.2c0.6,0.3,1.1,0.7,1.6,1.1
                                                    C412.3,216.5,412.8,216.9,413.2,217.3z"/>
                                                <path class="st0" d="M402.8,235.6c-0.4-1.4-0.6-2.8-0.8-4.2c0.2,0.7,0.4,1.4,0.5,2.1C402.6,234.2,402.7,234.9,402.8,235.6z"/>
                                                <path class="st0" d="M404.1,232.7c-0.5,0.3-1.1,0.5-1.6,0.7s-1.1,0.4-1.7,0.4c0.5-0.2,1.1-0.4,1.6-0.6
                                                    C403,233.1,403.5,232.9,404.1,232.7z"/>
                                                <path class="st0" d="M401.7,235.1c0.4-1.1,0.8-2.2,1.4-3.2c-0.2,0.6-0.4,1.1-0.6,1.7C402.2,234.1,402,234.6,401.7,235.1z"/>
                                                <path class="st0" d="M404.1,234.7c-0.6-0.3-1.1-0.7-1.6-1.1c-0.5-0.4-1-0.8-1.5-1.2c0.6,0.3,1.1,0.7,1.6,1.1
                                                    C403.1,233.9,403.6,234.3,404.1,234.7z"/>
                                                <path class="st0" d="M404.3,258.5c-0.2-0.7-0.4-1.4-0.5-2.1c-0.2-0.7-0.3-1.4-0.3-2.1c0.2,0.7,0.4,1.4,0.5,2.1
                                                    S404.2,257.8,404.3,258.5z"/>
                                                <path class="st0" d="M405.6,255.7c-0.5,0.3-1.1,0.5-1.6,0.7c-0.5,0.2-1.1,0.4-1.7,0.5c0.5-0.2,1.1-0.4,1.6-0.6
                                                    C404.4,256,405,255.8,405.6,255.7z"/>
                                                <path class="st0" d="M403.2,258c0.4-1.1,0.8-2.2,1.4-3.3c-0.2,0.6-0.4,1.1-0.6,1.7C403.7,256.9,403.5,257.5,403.2,258z"/>
                                                <path class="st0" d="M405.6,257.6c-0.6-0.3-1.1-0.7-1.6-1.1s-1-0.8-1.5-1.2c0.6,0.3,1.1,0.7,1.6,1.1S405.1,257.2,405.6,257.6z"/>
                                                <path class="st0" d="M412.2,264.2c-0.2-0.7-0.4-1.4-0.5-2.1c-0.2-0.7-0.3-1.4-0.3-2.1c0.2,0.7,0.4,1.4,0.5,2.1
                                                    C412,262.8,412.1,263.5,412.2,264.2z"/>
                                                <path class="st0" d="M413.5,261.4c-0.5,0.3-1.1,0.5-1.6,0.7s-1.1,0.4-1.7,0.5c0.5-0.2,1.1-0.4,1.6-0.6
                                                    C412.3,261.7,412.9,261.5,413.5,261.4z"/>
                                                <path class="st0" d="M411.1,263.7c0.4-1.1,0.8-2.2,1.4-3.3c-0.1,0.6-0.3,1.1-0.6,1.7C411.6,262.6,411.4,263.2,411.1,263.7z"/>
                                                <path class="st0" d="M413.4,263.3c-0.6-0.3-1.1-0.7-1.6-1.1s-1-0.8-1.5-1.2c0.6,0.3,1.1,0.7,1.6,1.1
                                                    C412.5,262.5,413,262.9,413.4,263.3z"/>
                                                <path class="st0" d="M397,267.2c-0.2-0.7-0.4-1.4-0.5-2.1c-0.2-0.7-0.3-1.4-0.3-2.1c0.2,0.7,0.3,1.4,0.5,2.1
                                                    C396.8,265.8,396.9,266.5,397,267.2z"/>
                                                <path class="st0" d="M398.3,264.3c-0.5,0.3-1,0.5-1.6,0.7c-0.5,0.2-1.1,0.4-1.7,0.4C396.1,265,397.2,264.6,398.3,264.3L398.3,264.3
                                                    z"/>
                                                <path class="st0" d="M395.9,266.7c0.4-1.1,0.8-2.2,1.4-3.3c-0.2,0.6-0.4,1.1-0.6,1.6C396.5,265.6,396.2,266.1,395.9,266.7z"/>
                                                <path class="st0" d="M398.3,266.3c-0.6-0.3-1.1-0.7-1.6-1.1s-1-0.7-1.5-1.2c0.6,0.3,1.1,0.7,1.6,1.1
                                                    C397.4,265.4,397.9,265.8,398.3,266.3z"/>
                                                <path class="st0" d="M384.1,262.5c-0.2-0.7-0.4-1.4-0.5-2.1c-0.2-0.7-0.3-1.4-0.3-2.1c0.2,0.7,0.4,1.4,0.5,2.1
                                                    C384,261.1,384.1,261.8,384.1,262.5z"/>
                                                <path class="st0" d="M385.4,259.7c-1,0.5-2.1,0.9-3.3,1.1c0.5-0.2,1.1-0.4,1.6-0.6C384.3,260,384.8,259.8,385.4,259.7z"/>
                                                <path class="st0" d="M383,262c0.2-0.6,0.4-1.1,0.6-1.7s0.4-1.1,0.7-1.6c-0.2,0.6-0.4,1.1-0.6,1.6C383.5,260.9,383.3,261.5,383,262z
                                                    "/>
                                                <path class="st0" d="M385.4,261.6c-1.1-0.7-2.1-1.4-3.1-2.2C383.4,260,384.4,260.8,385.4,261.6z"/>
                                                <path class="st0" d="M401.9,219.9c-0.4-1.4-0.6-2.8-0.8-4.2c0.2,0.7,0.4,1.4,0.5,2.1C401.7,218.5,401.8,219.2,401.9,219.9z"/>
                                                <path class="st0" d="M403.2,217.1c-0.5,0.3-1.1,0.5-1.6,0.6c-0.5,0.2-1.1,0.4-1.7,0.4c0.5-0.2,1.1-0.4,1.6-0.6
                                                    C402,217.4,402.6,217.2,403.2,217.1z"/>
                                                <path class="st0" d="M400.8,219.4c0.2-0.6,0.4-1.1,0.6-1.7c0.2-0.6,0.4-1.1,0.7-1.6c-0.2,0.6-0.4,1.1-0.6,1.7
                                                    C401.3,218.3,401.1,218.9,400.8,219.4z"/>
                                                <path class="st0" d="M403.2,219c-0.6-0.3-1.1-0.7-1.6-1.1c-0.5-0.4-1-0.8-1.5-1.2C401.2,217.4,402.2,218.2,403.2,219L403.2,219z"/>
                                                <path class="st0" d="M379.1,226.4c-0.2-0.7-0.4-1.4-0.5-2.1c-0.2-0.7-0.3-1.4-0.3-2.1c0.2,0.7,0.4,1.4,0.5,2.1
                                                    C378.9,225,379,225.7,379.1,226.4z"/>
                                                <path class="st0" d="M380.4,223.6c-0.5,0.3-1.1,0.5-1.6,0.7s-1.1,0.4-1.7,0.4c0.5-0.2,1.1-0.4,1.6-0.6
                                                    C379.3,223.9,379.8,223.7,380.4,223.6z"/>
                                                <path class="st0" d="M378,225.9c0.2-0.6,0.4-1.1,0.6-1.7c0.2-0.6,0.4-1.1,0.7-1.6c-0.2,0.6-0.4,1.1-0.6,1.7
                                                    C378.5,224.9,378.3,225.4,378,225.9z"/>
                                                <path class="st0" d="M380.4,225.5c-0.6-0.3-1.1-0.7-1.6-1.1c-0.5-0.4-1-0.7-1.5-1.2c0.6,0.3,1.1,0.7,1.6,1.1
                                                    C379.4,224.7,379.9,225.1,380.4,225.5z"/>
                                                <path class="st0" d="M393.1,232c-0.2-0.7-0.4-1.4-0.5-2.1c-0.2-0.7-0.3-1.4-0.3-2.1c0.2,0.7,0.4,1.4,0.5,2.1
                                                    C392.9,230.6,393,231.3,393.1,232z"/>
                                                <path class="st0" d="M394.4,229.2c-0.5,0.3-1.1,0.5-1.6,0.6c-0.5,0.2-1.1,0.4-1.7,0.4c0.5-0.2,1.1-0.4,1.6-0.6
                                                    C393.3,229.5,393.8,229.3,394.4,229.2z"/>
                                                <path class="st0" d="M392,231.5c0.2-0.6,0.4-1.1,0.6-1.6c0.2-0.6,0.4-1.1,0.7-1.6c-0.2,0.6-0.4,1.1-0.6,1.6S392.3,231,392,231.5z"
                                                    />
                                                <path class="st0" d="M394.4,231.1c-0.6-0.3-1.1-0.7-1.6-1.1c-0.5-0.4-1-0.8-1.5-1.2c0.6,0.3,1.1,0.7,1.6,1.1
                                                    C393.4,230.3,393.9,230.7,394.4,231.1z"/>
                                                <path class="st0" d="M379.6,238.6c-0.2-0.7-0.4-1.4-0.5-2.1c-0.2-0.7-0.3-1.4-0.3-2.1c0.2,0.7,0.4,1.4,0.5,2.1
                                                    C379.4,237.1,379.5,237.9,379.6,238.6z"/>
                                                <path class="st0" d="M380.9,235.7c-0.5,0.3-1.1,0.5-1.6,0.7s-1.1,0.4-1.7,0.4c0.5-0.2,1.1-0.4,1.6-0.6
                                                    C379.7,236,380.3,235.8,380.9,235.7z"/>
                                                <path class="st0" d="M378.4,238c0.4-1.1,0.8-2.2,1.4-3.3c-0.1,0.6-0.3,1.1-0.6,1.7C379,236.9,378.7,237.5,378.4,238z"/>
                                                <path class="st0" d="M380.8,237.6c-0.6-0.3-1.1-0.7-1.6-1.1c-0.5-0.4-1-0.8-1.5-1.2C378.9,236,379.9,236.8,380.8,237.6L380.8,237.6
                                                    z"/>
                                                <path class="st0" d="M388,241.3c-0.4-1.4-0.6-2.8-0.8-4.2c0.2,0.7,0.4,1.4,0.5,2.1C387.8,239.9,387.9,240.6,388,241.3z"/>
                                                <path class="st0" d="M389.3,238.5c-0.5,0.3-1.1,0.5-1.6,0.7s-1.1,0.3-1.7,0.4c0.5-0.2,1.1-0.4,1.6-0.6
                                                    C388.2,238.8,388.7,238.6,389.3,238.5z"/>
                                                <path class="st0" d="M386.9,240.8c0.2-0.6,0.4-1.1,0.6-1.7c0.2-0.6,0.5-1.1,0.8-1.6c-0.2,0.6-0.4,1.1-0.6,1.6
                                                    C387.4,239.7,387.2,240.3,386.9,240.8z"/>
                                                <path class="st0" d="M389.3,240.4c-0.6-0.3-1.1-0.7-1.6-1.1c-0.5-0.4-1-0.7-1.5-1.2c0.6,0.3,1.1,0.7,1.6,1.1S388.8,240,389.3,240.4
                                                    z"/>
                                                <path class="st0" d="M382.6,249.3c-0.2-0.7-0.4-1.4-0.5-2.1c-0.2-0.7-0.3-1.4-0.3-2.1c0.2,0.7,0.4,1.4,0.5,2.1
                                                    C382.4,247.8,382.5,248.6,382.6,249.3z"/>
                                                <path class="st0" d="M383.9,246.4c-1,0.5-2.1,0.9-3.3,1.1c0,0,0.7-0.3,1.6-0.6C382.8,246.7,383.3,246.6,383.9,246.4z"/>
                                                <path class="st0" d="M381.5,248.8c0.4-1.1,0.8-2.2,1.4-3.3C382.5,246.6,382,247.7,381.5,248.8z"/>
                                                <path class="st0" d="M383.9,248.4c-0.6-0.3-1.1-0.7-1.6-1.1c-0.5-0.4-1-0.7-1.5-1.2c0.6,0.3,1.1,0.7,1.6,1.1
                                                    C382.9,247.5,383.4,247.9,383.9,248.4z"/>
                                                <path class="st13" d="M392.2,196.3c-1.3,2.3-1.2,5.1,0.1,7.4c0.9,1.4,2.3,2.6,3,4.1c0.8,1.9,0.5,4.1,0.2,6.1s-0.3,4.4,1,6
                                                    c0.5,0.7,1.3,1.2,1.9,1.8s0.8,1.6,0.5,2.4c-0.4,0.5-0.9,0.8-1.5,1c-4.3,1.5-9.2,0.3-12.2-3.2l-0.3,2.2c-5.7-5-7.2-13.2-3.6-19.9"/>
                                            <g class="right_man">
                                                        <path class="st12" d="M174.9,249.3h-8.6c-11.5-19.6-36.7-26.1-56.3-14.6S83.9,271.5,95.4,291c11.5,19.6,36.7,26.1,56.3,14.6
                                                    c17.1-10.1,24.6-30.8,17.8-49.5L174.9,249.3z"/>
                                                <path class="st13" d="M174.9,249.3l-5.3,6.9v-0.1c1.5,4.3,2.3,8.7,2.4,13.2c0,0.9-0.1,1.9-0.1,2.8c0,1-0.1,2-0.2,3
                                                    c-0.1,1-0.3,2-0.5,3.1s-0.5,2.1-0.8,3.2c-0.1,0.3-0.1,0.5-0.2,0.8l-0.3,0.8c-0.2,0.5-0.4,1.1-0.6,1.6s-0.4,1.1-0.6,1.6
                                                    s-0.5,1.1-0.8,1.6c-4.8,10-13.4,17.6-23.9,21.2l-1.1,0.4l-1.1,0.3l-2.2,0.6l-0.6,0.1l-0.6,0.1l-1.2,0.2l-2.3,0.4l-2.4,0.1l-1.2,0.1
                                                    c-0.4,0-0.8,0-1.2,0l-2.4-0.1h-1.2c-0.4,0-0.8-0.1-1.2-0.2l-2.4-0.4c-0.4,0-0.8-0.1-1.2-0.2l-1.2-0.3c-0.8-0.2-1.6-0.4-2.4-0.7
                                                    l-2.4-0.9c-0.4-0.1-0.8-0.3-1.2-0.4l-1.2-0.5l-2.3-1.1c-0.7-0.4-1.5-0.9-2.2-1.3l-1.1-0.7c-0.4-0.2-0.7-0.5-1.1-0.8l-2.1-1.6
                                                    c-0.7-0.5-1.3-1.1-2-1.7c-1.3-1.2-2.5-2.5-3.6-3.8c-0.6-0.7-1.1-1.4-1.6-2.1l-0.8-1.1c-0.3-0.4-0.5-0.8-0.7-1.1l-1.4-2.3
                                                    c-0.4-0.8-0.8-1.6-1.2-2.4l-0.6-1.2c-0.2-0.4-0.3-0.9-0.5-1.3l-0.9-2.6c-0.3-0.8-0.4-1.8-0.7-2.6l-0.3-1.3
                                                    c-0.1-0.4-0.1-0.9-0.2-1.3c-0.1-0.9-0.3-1.8-0.4-2.6c-0.1-0.9-0.1-1.8-0.2-2.6c-0.1-1.8-0.1-3.5,0.1-5.3c0-0.9,0.1-1.7,0.3-2.6
                                                    c0.1-0.9,0.2-1.7,0.4-2.6c0.2-0.9,0.4-1.7,0.6-2.5l0.3-1.2c0.1-0.4,0.3-0.8,0.4-1.2c0.3-0.8,0.6-1.6,0.9-2.4s0.7-1.5,1-2.3l0.5-1.1
                                                    l0.3-0.6l0.3-0.5l1.4-2.1c0.4-0.7,0.9-1.4,1.4-2l1.4-2l1.6-1.8c0.5-0.6,1.1-1.2,1.7-1.7c1.1-1.1,2.3-2.1,3.6-3l1.8-1.4l2-1.2
                                                    c5-3,10.5-4.9,16.3-5.6c2.7-0.3,5.3-0.4,8-0.2c1.3,0.1,2.6,0.2,3.8,0.5c0.6,0.1,1.2,0.2,1.8,0.3l1.8,0.4c7.9,2.1,15,6.4,20.4,12.6
                                                    c1.8,2.1,3.4,4.3,4.8,6.7h-0.1H174.9l-8.5,0.1l0,0c-1.4-2.4-3.1-4.6-4.9-6.7c-5.4-6.1-12.5-10.4-20.4-12.4l-1.8-0.4
                                                    c-0.6-0.1-1.2-0.2-1.8-0.3c-1.2-0.2-2.5-0.3-3.8-0.5c-2.6-0.2-5.3-0.1-7.9,0.2c-5.7,0.7-11.2,2.6-16.2,5.6
                                                    c-0.7,0.4-1.3,0.8-1.9,1.2l-1.9,1.3c-1.2,0.9-2.4,1.9-3.5,3c-0.6,0.5-1.1,1.1-1.6,1.7l-1.6,1.8l-1.4,1.9c-0.5,0.6-1,1.3-1.4,2
                                                    l-1.3,2.1l-0.3,0.5l-0.3,0.6l-0.5,1.1c-0.3,0.8-0.7,1.5-1,2.2c-0.3,0.8-0.6,1.6-0.9,2.4c-0.1,0.4-0.3,0.8-0.4,1.2l-0.3,1.2
                                                    c-0.2,0.8-0.4,1.6-0.6,2.5s-0.3,1.7-0.4,2.5c-0.2,0.8-0.3,1.7-0.3,2.6c-0.1,1.7-0.2,3.5-0.1,5.2c0.1,0.9,0.1,1.8,0.2,2.6
                                                    s0.3,1.7,0.4,2.6c0.1,0.4,0.1,0.9,0.2,1.3l0.3,1.3c0.2,0.9,0.4,1.7,0.7,2.6l0.9,2.5c0.2,0.4,0.3,0.9,0.5,1.3l0.6,1.2
                                                    c0.4,0.8,0.8,1.6,1.2,2.4l1.4,2.3c0.2,0.4,0.4,0.8,0.7,1.1l0.8,1.1c0.5,0.7,1,1.4,1.6,2.1c1.1,1.4,2.3,2.6,3.6,3.9
                                                    c0.7,0.6,1.3,1.2,1.9,1.7l2.1,1.6c0.4,0.2,0.7,0.5,1,0.8l1.1,0.7c0.7,0.4,1.5,0.9,2.2,1.3l2.3,1.1l1.1,0.5c0.4,0.2,0.8,0.3,1.2,0.4
                                                    l2.3,0.9c0.8,0.3,1.6,0.4,2.4,0.6l1.2,0.3c0.4,0.1,0.8,0.2,1.2,0.2l2.4,0.4c0.4,0.1,0.8,0.1,1.2,0.2l1.2,0.1l2.4,0.1
                                                    c0.4,0,0.8,0,1.2,0h1.2l2.4-0.1l2.3-0.4l1.1-0.2l0.6-0.1l0.6-0.1l2.2-0.6l1.1-0.3l1.1-0.4c10.4-3.6,18.9-11.1,23.7-21
                                                    c0.3-0.5,0.5-1.1,0.8-1.6c0.2-0.5,0.4-1.1,0.6-1.6c0.2-0.5,0.4-1.1,0.6-1.6c0.1-0.3,0.2-0.5,0.3-0.8s0.2-0.5,0.2-0.8
                                                    c0.3-1.1,0.6-2.1,0.8-3.1s0.4-2,0.5-3.1c0.1-1,0.2-2,0.2-3s0.1-1.9,0.1-2.8c0-4.5-0.8-8.9-2.3-13.2l0,0l0,0L174.9,249.3z"/>
                                                <path class="st18" d="M93.9,270.1l-4.8,12.8l-3.6-29c-0.1-1.9,0.2-3.7,1.1-5.4c0.4-0.7,0.8-1.4,1.3-2c0.6-0.8,1.4-1.5,2.2-2.1
                                                    c0.5-0.2,0.7-0.8,0.4-1.2c-0.1-0.3-0.3-0.4-0.6-0.5c-0.8-0.1-3.1,1.1-4.9,3.6s-2-2.3-2.1-4s-0.7-7-1.2-7.4
                                                    c-0.8-0.6-1.6,0.2-1.4,1.9c0.1,1.7,0.2,6.9-0.7,6.9c-0.9,0-1.3-8.7-1.3-8.7s0.2-1.9-0.8-1.9c-1.9,0-0.8,9.2-0.7,10.1
                                                    c0.1,0.6-0.9,0.7-0.9,0c-0.1-0.7-0.2-8.7-2.1-8.7c-1.5,0,0.8,7.6-0.1,9.3s-1.2-5.9-2.6-5.9c-0.5,0-0.9,0.1-0.1,4.5
                                                    c0.4,2.3,2,5.7,2.4,10.3l0.1,1.2c0.1,5.7,0.8,27.2,5.9,40.3c2.2,5.4,8.4,8,13.8,5.8c2-0.8,3.6-2.2,4.8-3.9
                                                    c4.1-6.2,7.5-12.8,10.1-19.7L93.9,270.1z"/>
                                                <path class="st30" d="M76.2,250.4c0.3,0,0.5,0.1,0.8,0.2c0.6,0.2,1.1,0.6,1.4,1.2l0.2,0.3l0.1-0.4c0.1-0.5,0.4-1,0.7-1.4
                                                    c0.6-0.8,1.5-1.5,2.4-1.8c0.7-0.3,1.2-0.2,1.2-0.3c-0.4-0.1-0.9-0.1-1.3,0.1c-1.1,0.3-2,0.9-2.6,1.8c-0.3,0.4-0.6,0.9-0.7,1.5h0.3
                                                    c-0.4-0.6-1-1-1.7-1.2C76.5,250.2,76.2,250.3,76.2,250.4z"/>
                                                
                                                    <linearGradient id="SVGID_00000079458134005366271480000002522305057462907304_" gradientUnits="userSpaceOnUse" x1="88.9" y1="454.3379" x2="170.9" y2="454.3379" gradientTransform="matrix(1 0 0 1 0 -178)">
                                                    <stop  offset="0" style="stop-color:#00FFAF"/>
                                                    <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                    <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                    <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                    <stop  offset="0.75" style="stop-color:#00469F"/>
                                                    <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                    <stop  offset="1" style="stop-color:#00249C"/>
                                                </linearGradient>
                                                <path style="fill:url(#SVGID_00000079458134005366271480000002522305057462907304_);" d="M122.1,241.7h16.6c0,0,15,5.3,19.9,9.1
                                                    s12.3,30.1,12.3,30.1l-15-0.5l-1.1,22.6c-15.3,10.9-33.7,10.3-48,0.2l-1.1-17.3h0.2l-17-5.4c0,0,9.6-25.2,12.5-30.1
                                                    C103.9,246.3,118.7,242.5,122.1,241.7"/>
                                                <path class="st13" d="M139.7,243.1c0,0.1,0,0.2,0,0.3c0,0.3-0.1,0.5-0.1,0.8c-0.2,1-0.6,2-1.2,2.9c-2.8,4.6-8.8,6.1-13.4,3.3
                                                    c-1.5-0.9-2.8-2.2-3.6-3.8c-0.5-0.9-0.8-1.9-1-2.9c0-0.3-0.1-0.5-0.1-0.8c0-0.1,0-0.2,0-0.3c0,0,0,0.4,0.2,1.1
                                                    c0.5,2.5,2,4.7,4.1,6.1c3.1,2.1,7.2,2.2,10.4,0.3c1.3-0.8,2.4-1.9,3.2-3.1c0.5-0.9,1-1.8,1.2-2.8
                                                    C139.6,243.5,139.6,243.1,139.7,243.1z"/>
                                                <path class="st13" d="M105.9,268.7c0.1,0,0.2,3.9,0.2,8.6s-0.1,8.6-0.1,8.6s-0.2-3.9-0.2-8.6S105.8,268.7,105.9,268.7z"/>
                                                <path class="st13" d="M155.8,264.5c0.1,0,0.1,3.9,0.1,8.6c0,4.8-0.1,8.6-0.1,8.6s-0.1-3.9-0.2-8.6
                                                    C155.6,268.4,155.7,264.5,155.8,264.5z"/>
                                                <path class="st13" d="M105.9,268.7c-0.3-0.4-0.5-0.9-0.7-1.4c-0.4-0.9-0.9-2.1-1.4-3.5s-1-2.6-1.3-3.5c-0.2-0.5-0.4-1-0.5-1.5
                                                    c0.3,0.4,0.5,0.9,0.7,1.4c0.4,0.9,0.9,2.1,1.4,3.5s1,2.6,1.3,3.5C105.5,267.7,105.7,268.2,105.9,268.7z"/>
                                                <path class="st13" d="M105.9,270c-1-0.7-1.9-1.6-2.8-2.4s-1.8-1.7-2.7-2.6c1,0.7,1.9,1.5,2.8,2.4
                                                    C104.2,268.2,105.1,269.1,105.9,270z"/>
                                                <path class="st13" d="M156.7,258.2c0,1.1-0.2,2.3-0.4,3.4c-0.1,1.1-0.3,2.3-0.6,3.4C155.9,262.6,156.2,260.4,156.7,258.2
                                                    L156.7,258.2z"/>
                                                <g class="st23">
                                                    <path d="M105.6,285.8c-1.9-3.4-3.1-7.1-3.6-11s0.2-7.8,2-11.3l1.9,6.1L105.6,285.8z"/>
                                                </g>
                                                <path class="st12" d="M153.2,247.7l-0.5,0.4l-1.4,1.2l-5,4.3l-16.7,14l-0.1,0.1l-0.1-0.1l-0.3-0.2l-16.8-14.2l-5.1-4.3l-1.4-1.2
                                                    c-0.3-0.3-0.5-0.4-0.5-0.4c0.2,0.1,0.3,0.3,0.5,0.4c0.3,0.3,0.8,0.7,1.4,1.1l5.1,4.3l16.8,14.2l0.3,0.2h-0.2l16.7-14l5.1-4.2
                                                    l1.4-1.1L153.2,247.7z"/>
                                                <path class="st12" d="M156.7,249.7l-0.5,0.5l-1.5,1.3l-5.7,4.9l-19,16h-0.1l-0.1-0.1l-0.3-0.2l-19.1-16.2l-5.8-4.9
                                                    c-0.7-0.6-1.2-1-1.6-1.4l-0.5-0.5l0.6,0.4l1.6,1.3l5.8,4.9l19.2,16.1l0.3,0.2h-0.2l19-15.9l5.8-4.8l1.6-1.3
                                                    C156.4,250,156.5,249.8,156.7,249.7z"/>
                                                <path class="st12" d="M156.7,283.9l-0.5,0.5l-1.5,1.2l-5.4,4.6l-17.8,15l-0.1,0.1l-0.1-0.1L131,305l-18-15.3l-5.4-4.6l-1.5-1.2
                                                    c-0.3-0.3-0.5-0.5-0.5-0.5s0.2,0.1,0.5,0.4l1.5,1.2l5.5,4.6l18,15.2l0.2,0.2h-0.2l17.9-15l5.4-4.5l1.5-1.2
                                                    C156.5,284,156.7,283.9,156.7,283.9z"/>
                                                <path class="st12" d="M157.2,288.2c0,0-0.2,0.2-0.5,0.5l-1.5,1.2l-5.4,4.6l-17.9,15l-0.1,0.1l-0.1-0.1l-0.3-0.2l-18-15.3l-5.4-4.6
                                                    l-1.5-1.3l-0.5-0.5c0,0,0.2,0.1,0.5,0.4l1.5,1.2l5.5,4.6l18,15.2l0.3,0.2h-0.1l17.9-15l5.4-4.5l1.5-1.2
                                                    C157,288.3,157.2,288.2,157.2,288.2z"/>
                                                <path class="st17" d="M123.1,255.8h11c1.5,0,2.7,1.2,2.7,2.7v21.3c0,1.5-1.2,2.7-2.7,2.7h-11c-1.5,0-2.7-1.2-2.7-2.7v-21.3
                                                    C120.4,257,121.6,255.8,123.1,255.8z"/>
                                                <path class="st18" d="M169.7,280.8c0.1,0.9,2.5,14.7,2.1,17.4s-1.2,6.4-4.3,7.7s-7.9-0.4-10.5-4.9s-13.9-20.3-13.9-20.3l-8.4-1
                                                    v-14.1l16.1,10.3l6.6,5.9l-0.1-1.3L169.7,280.8z"/>
                                                <path class="st30" d="M150.1,275.5c0.1-0.1,3.6,3,7.8,6.8s7.7,6.9,7.6,7s-3.6-3-7.8-6.8C153.4,278.7,150,275.5,150.1,275.5z"/>
                                                <path class="st18" d="M123.6,270.6l11-5l1.7,4.4l-1.7,9.7l-2.5-2.6c-0.5-0.6-0.7-1.3-0.6-2.1l0.3-1.2c0,0-5.6,1.4-6.6,1.6
                                                    c-1.2,0.3-1.3-1.2-0.4-1.8c1.3-0.8,8.1-3.5,8.1-3.5l-8.6,2.4c-0.5,0.2-1.1-0.2-1.2-0.7l0,0l0,0
                                                    C122.9,271.3,123.1,270.8,123.6,270.6z"/>
                                                <polygon class="st18" points="136.9,264.7 139.3,266.8 140.7,271 136.9,269.2     "/>
                                                <path class="st12" d="M129.9,260.6c0,0.6-0.4,1.1-1,1.1s-1.1-0.4-1.1-1s0.4-1.1,1-1.1h0.1l0,0C129.4,259.6,129.9,260.1,129.9,260.6
                                                    z"/>
                                                <path class="st13" d="M128.8,261.7c-0.6,0-1.1-0.5-1.1-1.1s0.5-1.1,1.1-1.1c0.6,0,1.1,0.5,1.1,1.1l0,0
                                                    C129.9,261.2,129.4,261.7,128.8,261.7z M128.8,259.6c-0.6,0-1,0.4-1,1s0.4,1,1,1s1-0.4,1-1C129.8,260.1,129.3,259.6,128.8,259.6z"
                                                    />
                                                <path class="st18" d="M130.9,249.9L130.9,249.9c4.4-0.3,7.8-3.9,7.8-8.4c0-2.6-0.1-4.9-0.1-4.9s6.7-1,6.8-7.8s-1.1-22.2-1.1-22.2
                                                    l0,0c-7.8-3.3-16.8-2.2-23.5,3l-1,0.8l2.3,31.8C122.5,246.8,126.3,250.2,130.9,249.9z"/>
                                                <path class="st30" d="M138.6,236.6c-3.1,0.1-6.1-0.8-8.8-2.5c0,0,2.1,4.8,8.8,4.2V236.6z"/>
                                                <path class="st18" d="M120.7,217.4c-0.1-0.1-4.6-1.4-4.5,3.2s4.7,3.5,4.7,3.4S120.7,217.4,120.7,217.4z"/>
                                                <path class="st30" d="M119.5,222.3l-0.2,0.1c-0.2,0.1-0.4,0.1-0.6,0c-0.6-0.4-1-1-1-1.8c0-0.4,0-0.8,0.2-1.2
                                                    c0.1-0.3,0.3-0.5,0.6-0.6c0.2-0.1,0.4,0,0.5,0.2c0.1,0.1,0,0.2,0.1,0.2s0.1-0.1,0-0.3c0-0.1-0.1-0.2-0.2-0.3s-0.3-0.1-0.4-0.1
                                                    c-0.4,0.1-0.7,0.4-0.8,0.7c-0.2,0.4-0.3,0.8-0.2,1.3c0,0.8,0.5,1.6,1.2,1.9c0.3,0.1,0.5,0,0.7-0.1
                                                    C119.5,222.4,119.5,222.4,119.5,222.3z"/>
                                                <path class="st13" d="M142.1,216.7c0,0.5-0.4,1-0.9,1s-1-0.4-1-0.9s0.4-1,0.9-1S142.1,216.2,142.1,216.7L142.1,216.7L142.1,216.7z"
                                                    />
                                                <path class="st13" d="M143.1,216.2c-0.1,0.1-0.8-0.4-1.9-0.4c-1,0-1.8,0.5-1.9,0.4s0.1-0.3,0.4-0.5c0.4-0.3,1-0.5,1.5-0.5
                                                    s1.1,0.2,1.5,0.5C143,215.9,143.1,216.1,143.1,216.2z"/>
                                                <path class="st13" d="M132,217.1c0,0.5-0.4,1-0.9,1s-1-0.3-1-0.9l0,0c0-0.5,0.4-1,0.9-1C131.5,216.1,131.9,216.5,132,217.1
                                                    C132,217,132,217,132,217.1L132,217.1z"/>
                                                <path class="st13" d="M132.9,216.4c-0.1,0.1-0.8-0.4-1.9-0.4c-1,0-1.8,0.5-1.9,0.4s0.1-0.3,0.4-0.5c0.4-0.3,1-0.5,1.5-0.5
                                                    s1.1,0.2,1.5,0.5C132.9,216.1,133,216.3,132.9,216.4z"/>
                                                <path class="st13" d="M136.6,224c0.5-0.2,1.1-0.3,1.7-0.3c0.3,0,0.5-0.1,0.6-0.3c0-0.3,0-0.6-0.2-0.8l-0.8-2
                                                    c-0.7-1.7-1.3-3.5-1.8-5.3c0.9,1.6,1.6,3.4,2.2,5.1l0.8,2c0.2,0.3,0.2,0.7,0.1,1c-0.1,0.2-0.2,0.3-0.4,0.4c-0.1,0-0.3,0.1-0.4,0.1
                                                    C137.8,224,137.2,224.1,136.6,224z"/>
                                                <path class="st13" d="M133.6,224.8c0.2,0,0.2,1.1,1.1,1.9c0.7,0.4,1.4,0.7,2.2,0.8c0,0.1-0.3,0.2-0.8,0.2c-0.7,0-1.3-0.2-1.8-0.6
                                                    c-0.5-0.4-0.8-1-0.9-1.6C133.4,225,133.5,224.7,133.6,224.8z"/>
                                                <path class="st13" d="M133.2,212.4c-0.1,0.3-1.1,0.1-2.3,0.3c-1.2,0.1-2.2,0.5-2.4,0.2s0.1-0.4,0.5-0.6c1.1-0.7,2.4-0.8,3.6-0.4
                                                    C133,212,133.2,212.2,133.2,212.4z"/>
                                                <path class="st13" d="M142.7,213.2c-0.2,0.2-0.9,0-1.7,0c-0.9,0-1.6,0.2-1.8-0.1s0-0.4,0.3-0.6c0.4-0.3,0.9-0.4,1.4-0.4
                                                    s1,0.2,1.4,0.5C142.7,212.8,142.8,213.1,142.7,213.2z"/>
                                                <path class="st13" d="M147.6,202.5c0.1-0.8-0.3-1.7-0.9-2.2c-0.7-0.5-1.7-0.4-2.3,0.2c0.2-1.1-0.5-2.2-1.6-2.5h-0.2
                                                    c-1.1-0.1-2,0.8-3.1,1.1c-1.1,0.2-2.2,0.1-3.2-0.4c-1-0.4-1.9-0.9-2.9-1.3c-4.4-1.6-9.3,0.6-11,5.1c-1.5-0.4-3.1,0.3-4,1.5
                                                    c-0.9,1.3-1.2,2.9-1,4.4c0.2,1,0.4,2,0.8,3v0.3c0.1,3.7,0.5,8,2.1,8c2.8,0.1,2.1-5.1,2.1-5.1c3.4-1.3,2.1-6.4,3-7.1
                                                    s2.6-2.6,9.7,1.1c2.6,1.2,5.6,1.5,8.4,0.9h0.2c0.6-0.2,1.3-0.4,1.8-0.8c0.7-0.4,1.2-1,1.5-1.7s0.1-1.5-0.4-2.1
                                                    C147.2,204.1,147.5,203.3,147.6,202.5z"/>
                                                <path class="st12" d="M118.3,210.8c0.3,0.2,0.6,0.5,0.9,0.6c1.5,1,3.5,0.9,4.9-0.2c0.3-0.2,0.6-0.5,0.8-0.7
                                                    c-0.2,0.3-0.4,0.6-0.7,0.9c-1.4,1.2-3.5,1.3-5.1,0.2C118.7,211.4,118.5,211.1,118.3,210.8z"/>
                                                 <path class="st12" d="M124.5,208.6c-0.2,0.3-0.5,0.5-0.9,0.7c-1.6,0.9-3.6,0.9-5.3,0.1c-0.3-0.1-0.7-0.4-0.9-0.6c0,0,0.4,0.2,1,0.5
                                                    c1.6,0.7,3.5,0.7,5.1-0.1C124.1,208.9,124.4,208.6,124.5,208.6z"/> 
                                            </g>
                                            <g class="right_woman">
                                                <path class="st12" d="M99.3,118.1l-6.2,3.9c-17-8.9-38-2.4-46.9,14.6s-2.4,38,14.6,46.9s38,2.4,46.9-14.6
                                                    c7.8-14.8,3.9-33.1-9.2-43.5L99.3,118.1z"/>
                                                <path class="st13" d="M99.3,118.1l-0.7,7.4v-0.1c1.9,1.5,3.6,3.1,5.1,4.9c0.9,1.1,1.8,2.3,2.6,3.5c0.4,0.6,0.8,1.4,1.2,2.1
                                                    c0.4,0.7,0.8,1.5,1.2,2.2l1.1,2.4c0.3,0.9,0.6,1.8,0.9,2.6l0.2,0.7l0.2,0.7c0.1,0.5,0.2,1,0.3,1.4s0.2,1,0.3,1.5s0.1,1,0.2,1.5
                                                    c1,9.4-1.7,18.8-7.6,26.1l-0.6,0.8l-0.7,0.7l-1.3,1.4c-0.5,0.5-1,0.9-1.5,1.3l-1.5,1.4c-1.1,0.8-2.2,1.6-3.4,2.3l-1.8,1l-0.9,0.5
                                                    c-0.3,0.2-0.6,0.3-0.9,0.4l-1.9,0.8c-0.7,0.3-1.3,0.5-2,0.7s-1.3,0.4-2,0.6l-2.1,0.4l-1.1,0.2l-1.1,0.1l-2.2,0.2
                                                    c-0.7,0-1.5,0-2.2,0H76c-0.4,0-0.7-0.1-1.1-0.1l-2.2-0.2c-0.7-0.1-1.5-0.2-2.2-0.4c-1.5-0.3-2.9-0.6-4.4-1.1
                                                    c-0.7-0.2-1.4-0.5-2.1-0.8c-0.7-0.2-1.4-0.5-2.1-0.9l-2-1c-0.7-0.4-1.3-0.8-2-1.2l-1-0.6c-0.3-0.2-0.6-0.5-0.9-0.7l-1.8-1.4
                                                    c-0.6-0.5-1.1-1-1.7-1.6l-0.8-0.8c-0.3-0.3-0.5-0.6-0.8-0.9l-1.5-1.7c-0.5-0.6-0.9-1.2-1.3-1.8c-0.9-1.2-1.6-2.5-2.3-3.8
                                                    c-0.4-0.6-0.7-1.3-1-2s-0.6-1.4-0.9-2c-0.3-0.6-0.4-1.4-0.7-2.1l-0.3-1c-0.1-0.4-0.2-0.7-0.2-1.1l-0.5-2.1
                                                    c-0.1-0.7-0.2-1.4-0.3-2.1c-0.2-1.4-0.2-2.8-0.2-4.2c0-0.7,0-1.4,0.1-2.1c0.1-0.7,0.1-1.4,0.2-2.1l0.4-2c0.1-0.7,0.3-1.3,0.4-2
                                                    c0.3-1.3,0.7-2.6,1.2-3.9l0.7-1.8l0.9-1.8c2.2-4.4,5.4-8.3,9.2-11.4c1.8-1.4,3.7-2.7,5.6-3.8c1.9-1,3.9-1.8,5.9-2.4
                                                    c3.6-1.1,7.4-1.7,11.2-1.6c3.1,0.1,6.2,0.5,9.2,1.4c2.3,0.7,4.4,1.6,6.5,2.7h-0.1C97.1,119.4,98.9,118.3,99.3,118.1l-6.1,3.9l0,0
                                                    c-2.1-1.1-4.3-1.9-6.5-2.6c-6.6-1.9-13.7-1.8-20.3,0.2c-2,0.6-4,1.4-5.8,2.4c-2,1.1-3.9,2.3-5.6,3.7c-3.8,3.1-6.9,6.9-9.1,11.3
                                                    c-0.3,0.6-0.6,1.1-0.9,1.7l-0.7,1.8c-0.5,1.2-0.9,2.5-1.2,3.8c-0.2,0.7-0.3,1.3-0.4,2l-0.4,2l-0.2,2c-0.1,0.7-0.1,1.4-0.1,2.1
                                                    c0,1.4,0.1,2.8,0.2,4.2c0.1,0.7,0.1,1.4,0.3,2.1l0.4,2.1c0.1,0.3,0.1,0.7,0.2,1l0.3,1l0.6,2.1c0.3,0.7,0.6,1.3,0.9,2
                                                    c0.3,0.7,0.6,1.4,0.9,2c0.7,1.3,1.4,2.6,2.3,3.8c0.4,0.6,0.8,1.2,1.3,1.8l1.5,1.7c0.2,0.3,0.5,0.6,0.7,0.9l0.8,0.8l1.6,1.6
                                                    c0.5,0.5,1.2,0.9,1.8,1.4c0.3,0.2,0.6,0.5,0.9,0.7l1,0.6c0.7,0.4,1.3,0.8,1.9,1.2l2,1c0.7,0.4,1.4,0.7,2.1,0.9
                                                    c0.7,0.3,1.4,0.6,2.1,0.8c1.4,0.4,2.9,0.8,4.3,1.1c0.7,0.1,1.5,0.3,2.2,0.4l2.2,0.2c0.4,0,0.7,0.1,1.1,0.1h1.1c0.7,0,1.4,0,2.2,0
                                                    l2.1-0.2l1.1-0.1l1-0.2l2.1-0.4c0.7-0.2,1.3-0.4,2-0.6c0.7-0.2,1.3-0.4,2-0.7l1.9-0.8c0.3-0.1,0.6-0.3,0.9-0.4l0.9-0.5l1.8-1
                                                    c1.2-0.7,2.2-1.5,3.3-2.3l1.5-1.3c0.5-0.4,1-0.9,1.4-1.3l1.3-1.4l0.7-0.7l0.6-0.8c5.9-7.2,8.6-16.6,7.6-25.8c0-0.5-0.1-1-0.2-1.5
                                                    s-0.2-1-0.3-1.5c-0.1-0.5-0.2-1-0.3-1.4l-0.1-0.7l-0.1-0.7c-0.3-0.9-0.6-1.8-0.8-2.6l-1-2.4c-0.3-0.8-0.7-1.5-1.2-2.2
                                                    c-0.4-0.7-0.8-1.4-1.2-2.1c-2.1-3.2-4.6-6.1-7.6-8.5l0,0C99,120.7,99.3,118.6,99.3,118.1z"/>
                                                <path class="st32" d="M97.4,149.2l4.6,9.7l0.9-22.7c0-1.4-0.4-2.9-1.2-4.1c-0.7-1.3-1.7-2.3-3-3c-0.4-0.1-0.6-0.5-0.5-0.9
                                                    c0.1-0.2,0.2-0.4,0.5-0.5c0.6-0.1,2.5,0.7,4,2.4s1.4-1.9,1.3-3.2c0-1.3,0-5.5,0.4-5.8c0.6-0.5,1.2,0.1,1.2,1.4s0.3,5.3,1,5.3
                                                    s0.4-6.8,0.4-6.8s-0.3-1.4,0.5-1.5c1.5-0.1,1.2,7.1,1.2,7.8c0,0.2,0.2,0.4,0.4,0.4c0.2,0,0.4-0.2,0.4-0.4l0,0c0-0.5-0.4-6.8,1-6.9
                                                    c1.2-0.1-0.1,6,0.7,7.2c0.8,1.3,0.5-4.7,1.6-4.8c0.4,0,0.7,0,0.4,3.4c-0.2,1.9-1.2,4.6-1.2,8.2v0.9c0.3,4.4,1.2,21.2-1.9,31.7
                                                    c-1.4,4.4-6,6.8-10.3,5.4c-1.6-0.5-3-1.4-4-2.7c-3.6-4.5-6.7-9.4-9.2-14.7L97.4,149.2z"/>
                                                <path class="st25" d="M109.7,132.7c-0.2,0-0.4,0.1-0.6,0.2c-0.4,0.2-0.8,0.6-1,1l-0.1,0.3l-0.1-0.3c-0.2-0.4-0.4-0.7-0.6-1
                                                    c-0.5-0.6-1.2-1-2-1.2c-0.6-0.1-1-0.1-1-0.2c0.3-0.1,0.7-0.1,1,0c0.8,0.2,1.6,0.6,2.1,1.2c0.3,0.3,0.5,0.7,0.7,1.1h-0.2
                                                    c0.2-0.5,0.7-0.9,1.2-1.1C109.5,132.6,109.8,132.6,109.7,132.7z"/>
                                                
                                                    <rect x="64.3" y="120.7" transform="matrix(0.9963 -8.559341e-02 8.559341e-02 0.9963 -10.3852 5.9848)" class="st26" width="0.6" height="6.8"/>
                                                
                                                    <linearGradient id="SVGID_00000175310170732635685780000010780572594022319242_" gradientUnits="userSpaceOnUse" x1="45.5" y1="337.8763" x2="94.09" y2="337.8763" gradientTransform="matrix(1 0 0 1 0 -178)">
                                                    <stop  offset="0" style="stop-color:#00FFAF"/>
                                                    <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                    <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                    <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                    <stop  offset="0.75" style="stop-color:#00469F"/>
                                                    <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                    <stop  offset="1" style="stop-color:#00249C"/>
                                                </linearGradient>
                                                <path style="fill:url(#SVGID_00000175310170732635685780000010780572594022319242_);" d="M58.8,182.7l3-19.9c0,0,3,5.5,3.1,8.3
                                                    s-2.7,13.4-2.7,13.4c10.5,4.7,22,4.6,32-1.2L92.5,168L92,157.4l0.5-13.8c0.4-6-4-11.2-10-11.7c-0.3,0-0.7,0-1.1,0
                                                    c-0.6,0-1.3,0.1-1.9,0.3l-14,1.8c0,0-14.5,7.6-17.6,18.4c-1.1,3.9-1.9,9.9-2.4,15.8C48.5,174.2,53.1,179.3,58.8,182.7z"/>
                                                
                                                    <linearGradient id="SVGID_00000018924118663398527240000001958014340519980479_" gradientUnits="userSpaceOnUse" x1="91.6147" y1="333.45" x2="101.9647" y2="333.45" gradientTransform="matrix(1 0 0 1 0 -178)">
                                                    <stop  offset="0" style="stop-color:#00FFAF"/>
                                                    <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                    <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                    <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                    <stop  offset="0.75" style="stop-color:#00469F"/>
                                                    <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                    <stop  offset="1" style="stop-color:#00249C"/>
                                                </linearGradient>
                                                <polygon style="fill:url(#SVGID_00000018924118663398527240000001958014340519980479_);" points="94.6,143.2 102,158.5 92.3,167.7 
                                                    91.6,152.7 92.4,143.4   "/>
                                                <path class="st32" d="M47.5,154.8c0,0,12.5-1.2,15.9-7.1c3.7-6.3,2.2-13.8,2.2-13.8s-8,2.6-11.5,6.4S47.8,150.3,47.5,154.8"/>
                                                <path class="st32" d="M80.7,131.9c-0.3,0.1,2.9,16,14.9,13.4C95.6,145.3,90.4,130,80.7,131.9z"/>
                                                <path class="st12" d="M98,150.2l-0.5-0.1c-0.5-0.1-1-0.1-1.5-0.1c-1.9,0.1-3.8,0.5-5.6,1.2c-2.3,0.8-4.8,2.2-7.7,3.5
                                                    c-1.5,0.7-3.1,1.2-4.8,1.5c-1.8,0.2-3.6,0.3-5.4,0.1c-3.7-0.3-7.2-1-10.3-0.5c-1.5,0.2-2.9,0.6-4.3,1.2c-1.3,0.5-2.5,1-3.7,1.4
                                                    c-1.7,0.8-3.6,1.3-5.5,1.5c-0.7,0.1-1.4,0-2.1-0.1l0.5,0.1c0.5,0,1,0,1.5,0c1.9-0.2,3.7-0.7,5.5-1.5c1.1-0.4,2.3-1,3.7-1.5
                                                    c1.4-0.6,2.9-1,4.4-1.2c3.2-0.5,6.7,0.1,10.4,0.5c1.8,0.2,3.6,0.2,5.3-0.1c1.6-0.3,3.2-0.8,4.8-1.4c2.9-1.2,5.5-2.6,7.8-3.4
                                                    c1.8-0.7,3.7-1.1,5.6-1.1C96.7,150,97.3,150,98,150.2z"/>
                                                <path class="st12" d="M60.7,169.3h-0.2H60c-0.4,0-1,0.1-1.7,0.1c-1.9,0.1-3.8,0-5.6-0.3c-1-0.2-2-0.4-3-0.7
                                                    c-0.8-0.3-1.6-0.6-2.3-1.1c-0.5-0.3-0.9-0.7-1.3-1.1c-0.1-0.2-0.3-0.3-0.4-0.5c0.5,0.6,1.1,1.1,1.7,1.5c0.7,0.5,1.5,0.8,2.3,1.1
                                                    c1,0.3,2,0.5,3,0.7c1.8,0.3,3.7,0.4,5.6,0.3H60.7L60.7,169.3z"/>
                                                <path class="st12" d="M97.1,162.5l-0.3,0.1c-0.3,0.1-0.6,0.2-0.9,0.3c-1.1,0.5-2.1,1.1-3.1,1.8c-1.5,0.9-3.2,1.5-5,1.8
                                                    c-2.2,0.3-4.3,0.5-6.5,0.3c-2.3-0.1-4.5-0.2-6.5-0.2c-1.8,0-3.5,0.3-5.3,0.7c-1.2,0.3-2.3,0.8-3.3,1.4c-0.3,0.2-0.6,0.3-0.8,0.5
                                                    l-0.3,0.2c0.3-0.3,0.7-0.6,1.1-0.8c1-0.6,2.1-1.1,3.3-1.4c1.7-0.5,3.5-0.7,5.3-0.8c2-0.1,4.2,0.1,6.5,0.1c2.2,0.1,4.3,0,6.5-0.3
                                                    c1.8-0.3,3.5-0.9,5-1.8c1-0.7,2.1-1.2,3.2-1.7C96.2,162.6,96.6,162.6,97.1,162.5z"/>
                                                <path class="st12" d="M93.2,176.1h-0.3c-0.3,0-0.6-0.1-0.9-0.1c-1.1,0-2.1,0.3-3.2,0.7c-1.3,0.5-2.7,1.3-4.3,2.2
                                                    c-0.9,0.4-1.7,0.8-2.7,1.1c-0.5,0.1-1,0.2-1.5,0.3c-0.5,0-1,0-1.6,0c-2-0.1-3.9-0.5-5.8-1.1c-1.5-0.5-3.1-0.9-4.7-1.2
                                                    c-1.1-0.2-2.1-0.2-3.2-0.2c-0.3,0-0.6,0.1-0.9,0.1H64c0,0,0.4-0.1,1.2-0.2c1.1-0.1,2.2-0.1,3.2,0.1c1.6,0.3,3.2,0.7,4.7,1.1
                                                    c1.9,0.6,3.8,1,5.8,1.2c0.5,0,1,0,1.5,0c1.4-0.2,2.8-0.6,4.1-1.3c1.4-0.8,2.9-1.5,4.4-2.2c1-0.4,2.1-0.6,3.2-0.6
                                                    C92.5,175.9,92.8,175.9,93.2,176.1z"/>
                                                <path class="st12" d="M83.9,140.6c-0.3,0-0.5-0.1-0.8-0.1c-0.7,0-1.5,0.2-2.2,0.5c-1,0.5-1.9,1.2-2.6,2c-0.9,1-2,1.9-3.1,2.7
                                                    c-1.2,0.7-2.6,1-4,1c-1.1,0-2.2-0.2-3.3-0.5c-0.9-0.2-1.7-0.5-2.2-0.7l-0.6-0.2l-0.2-0.1c0.1,0,0.1,0,0.2,0.1l0.6,0.2
                                                    c0.5,0.2,1.3,0.4,2.2,0.6c1.1,0.3,2.2,0.4,3.3,0.4c1.4,0,2.7-0.3,3.9-1c1.1-0.8,2.2-1.7,3.1-2.7c0.8-0.8,1.7-1.5,2.7-2
                                                    c0.7-0.3,1.5-0.5,2.2-0.5C83.3,140.5,83.6,140.6,83.9,140.6z"/>
                                                <path class="st13" d="M88.4,139.7c0.2,0.3,0.4,0.7,0.5,1.1l0.3,0.6c0.1,0.2,0.2,0.4,0.3,0.7c0.2,0.5,0.4,1.1,0.6,1.7l0.3,1
                                                    c0.1,0.4,0.2,0.7,0.3,1.1c0.2,0.8,0.3,1.6,0.5,2.5c0.3,1.8,0.5,3.8,0.7,5.8c0.3,4.1,0.4,7.9,0.5,10.6c0.1,1.4,0.2,2.4,0.2,3.2
                                                    c0,0.4,0.1,0.8,0.1,1.2c-0.1-0.4-0.2-0.8-0.2-1.2c-0.1-0.8-0.2-1.9-0.3-3.2c-0.2-2.7-0.3-6.4-0.6-10.6c-0.2-2.1-0.4-4-0.7-5.8
                                                    c-0.2-0.9-0.3-1.7-0.5-2.5c-0.1-0.4-0.2-0.8-0.2-1.1s-0.2-0.7-0.3-1c-0.2-0.7-0.4-1.2-0.6-1.7c-0.1-0.2-0.2-0.5-0.2-0.7l-0.2-0.6
                                                    C88.7,140.4,88.6,140,88.4,139.7z"/>
                                                <g class="st23">
                                                    <polygon points="91.5,150.3 95.8,164.4 92.6,167.3       "/>
                                                </g>
                                                <g class="st23">
                                                    <path d="M76.9,161.3c-3.8,2.8-9.1,2-11.9-1.8l0,0c-0.2-0.2-0.3-0.5-0.5-0.7c0.5,2.7,2.5,4.8,5.1,5.5
                                                        C73.5,165.2,76.9,161.3,76.9,161.3z"/>
                                                </g>
                                                <path class="st13" d="M62.9,154.6c0,1.9-0.2,3.8-0.5,5.6c-0.2,1.9-0.5,3.7-0.9,5.6c0-1.9,0.2-3.8,0.5-5.6
                                                    C62,158.3,62.4,156.4,62.9,154.6z"/>
                                                <path class="st13" d="M64.4,106.7c-2.1,1.1-13.4,2-14.7,0.1c-1.3-2.1-0.8-4.8,1-6.4c-1.1-1.2-1.8-2.7-1.8-4.4
                                                    c0-1.6,0.7-3.2,2.1-4.1c1.4-0.9,3.2-0.9,4.5,0.1c-0.9-0.7-0.6-2.1,0.1-3c2-2.7,5.8-3.3,8.5-1.3l0,0c0.4,0.3,0.8,0.7,1.2,1.2
                                                    c1-2.9,4.1-4.5,7-3.5c2.1,0.7,3.6,2.7,3.8,4.9c1.9-0.8,4.1,0.6,4.8,2.5c0.6,1.9,0.5,4-0.2,5.9"/>
                                                <path class="st26" d="M58.6,113.9c-0.9-1.1-1.4-2.6-1.3-4.1c0.1-1.5,0.5-2.9,1.2-4.2c3-5.9,9.1-9.6,15.7-9.6
                                                    c2.6-0.1,5.2,0.7,7.2,2.3c2.1,1.6,3.1,4.3,2.5,6.9"/>
                                                <path class="st32" d="M79.9,133.4c-0.1-2.5-0.2-4.7-0.2-4.7s5.5-1.2,5.2-6.8S83,103.3,83,103.3l-10.6-4l-8.2,8.8l3.2,26.3
                                                    c0.6,3.7,2.8,6.7,6.6,6.2l0,0C77.4,140.1,80,137,79.9,133.4z"/>
                                                <path class="st13" d="M68.6,101.9c-1.6,2.7-0.5,4.2,1.6,6.5c0.9,1.1,2.2,1.7,3.6,1.6c1.3-0.1,2.3-1.3,2.2-2.7c0-0.1,0-0.1,0-0.2
                                                    c-0.3,1.5,0.6,3,2.1,3.4c1.5,0.3,3-0.6,3.4-2.1l0,0c0.1-0.5,0.1-1.1-0.1-1.6c0.2,0.6,0.4,1.2,0.8,1.7s1,0.8,1.6,0.7
                                                    c0.8-0.2,1.9-0.2,2-1.6c0.4-2.7-0.7-5.4-2.7-7.1c-2.3-1.7-5.1-2.4-7.9-2c-2.6,0.4-4.9,1.7-6.7,3.6"/>
                                                <path class="st13" d="M70.2,101.8c0.8,1.5,1.4,3.2,1.6,4.9c0.2,1.8-0.3,3.5-1.4,4.9s-3,2-4.7,1.6c0.6,1.5,0.5,3.2-0.3,4.6
                                                    s-2.5,2-4.1,1.4c-1.3-0.7-2.1-2-2.3-3.4c-1.3-6.2,2.7-12.4,8.9-13.7c0.8-0.2,1.7-0.3,2.5-0.2"/>
                                                <path class="st32" d="M65.3,116.1c-0.9-0.3-1.8,0-2.3,0.7c-1.2,1.3-1.1,3.3,0.2,4.5c0.9,0.8,2.2,1.1,3.4,0.6"/>
                                                <path class="st25" d="M65.4,120.4c-0.2,0.1-0.4,0.1-0.6,0c-0.5-0.1-1-0.5-1.2-1c-0.1-0.3-0.1-0.6,0-0.9c0.1-0.2,0.2-0.4,0.4-0.6
                                                    c0.3-0.2,0.6-0.3,0.6-0.2s-0.2,0.1-0.5,0.4c-0.3,0.3-0.4,0.8-0.3,1.2c0.2,0.4,0.6,0.7,1,0.9C65.1,120.3,65.4,120.3,65.4,120.4z"/>
                                                <path class="st13" d="M76.3,119.4c0,0.1,0,0.2,0,0.3c-0.1,0.5-0.5,0.8-0.9,0.9h-0.3c0.3-0.1,0.5-0.3,0.7-0.5
                                                    C76.1,119.7,76.3,119.4,76.3,119.4z"/>
                                                <path class="st13" d="M83.4,113.4c0.1,0.4-0.2,0.8-0.7,0.9l0,0l0,0c-0.4,0.1-0.8-0.2-0.9-0.6s0.2-0.8,0.6-0.9h0.1l0,0
                                                    C82.9,112.6,83.3,112.9,83.4,113.4z"/>
                                                <path class="st13" d="M83.9,112.2c-0.1,0.1-0.8-0.3-1.6-0.2s-1.5,0.6-1.6,0.5s0-0.2,0.3-0.5c0.4-0.3,0.8-0.5,1.3-0.5
                                                    s0.9,0.1,1.3,0.3C83.9,111.9,84,112.1,83.9,112.2z"/>
                                                <path class="st13" d="M75.1,114.1c0.1,0.4-0.3,0.8-0.7,0.9l0,0l0,0c-0.4,0.1-0.8-0.2-0.9-0.6s0.2-0.8,0.6-0.9h0.1l0,0
                                                    C74.7,113.4,75.1,113.7,75.1,114.1z"/>
                                                <path class="st13" d="M75.3,112.9c-0.1,0.1-0.8-0.3-1.6-0.2c-0.9,0.1-1.5,0.6-1.6,0.5s0-0.2,0.3-0.5c0.4-0.3,0.8-0.5,1.3-0.5
                                                    s0.9,0.1,1.3,0.3C75.2,112.7,75.3,112.9,75.3,112.9z"/>
                                                <path class="st13" d="M78.9,119.3c0.4-0.2,0.9-0.3,1.4-0.4c0.2,0,0.4-0.1,0.5-0.2c0-0.2-0.1-0.5-0.2-0.7l-0.8-1.7
                                                    c-0.7-1.4-1.4-2.9-1.9-4.4c0.8,1.3,1.6,2.8,2.2,4.2l0.8,1.7c0.2,0.3,0.2,0.6,0.2,0.9c-0.1,0.2-0.2,0.3-0.3,0.4
                                                    c-0.1,0-0.2,0.1-0.4,0.1C79.8,119.3,79.4,119.3,78.9,119.3z"/>
                                                <path class="st25" d="M78.7,122.4c0.2-0.4,0-0.9-0.4-1.1c-0.2-0.1-0.4-0.1-0.5,0c0-0.3-0.2-0.6-0.5-0.7s-0.6,0-0.9,0.2
                                                    c-0.4,0.4-0.6,1.1-0.3,1.6c0.3,0.5,0.9,0.8,1.5,0.8c0.6-0.1,1.1-0.5,1.3-1.1"/>
                                                <path class="st13" d="M76.3,120.1c0.2,0,0.2,0.9,1.1,1.6s1.9,0.4,1.9,0.6s-0.2,0.2-0.6,0.3c-0.6,0.1-1.1-0.1-1.6-0.4
                                                    c-0.4-0.3-0.8-0.8-0.9-1.3C76.1,120.4,76.2,120.1,76.3,120.1z"/>
                                                <path class="st13" d="M75.9,111.3c-0.1,0.2-1,0.2-2,0.4s-1.8,0.6-2,0.4s0-0.3,0.4-0.6c0.9-0.6,2-0.9,3-0.6
                                                    C75.7,111,75.9,111.2,75.9,111.3z"/>
                                                <path class="st13" d="M83.7,110.5c-0.1,0.2-0.8,0-1.5,0.1s-1.3,0.2-1.5,0s0-0.3,0.3-0.5c0.7-0.5,1.7-0.6,2.4-0.1
                                                    C83.6,110.2,83.7,110.4,83.7,110.5z"/>
                                                <path class="st25" d="M79.7,128.7c-2.6,0.2-5.2-0.5-7.5-1.8c0,0,2.1,4,7.5,3.2V128.7z"/>
                                                <path class="st12" d="M60.9,106.9c-0.1-0.1-0.3-0.2-0.4-0.3c-0.3-0.3-0.5-0.7-0.7-1.1c-0.1-0.4-0.2-0.8-0.2-1.3
                                                    c0-0.2,0-0.4,0.1-0.5c0,0.6,0,1.2,0.2,1.7C60.2,105.9,60.5,106.4,60.9,106.9z"/>
                                                <path class="st12" d="M62.8,104.7c-0.1-0.1-0.3-0.2-0.4-0.3c-0.3-0.3-0.5-0.6-0.7-1s-0.3-0.7-0.4-1.1c-0.1-0.2-0.1-0.3-0.1-0.5
                                                    c0.1,0,0.2,0.7,0.7,1.6C62.3,104.1,62.9,104.6,62.8,104.7z"/>
                                                <path class="st12" d="M65.9,102.8c-0.1-0.1-0.3-0.3-0.4-0.4c-0.3-0.4-0.6-0.7-0.8-1.2c-0.2-0.4-0.4-0.8-0.6-1.2
                                                    c-0.1-0.2-0.1-0.4-0.2-0.6c0.1,0,0.4,0.8,0.9,1.7S65.9,102.8,65.9,102.8z"/>
                                                <path class="st12" d="M69.6,101c-0.1,0-0.4-0.9-1-1.8c-0.4-0.6-0.8-1.1-1.3-1.6c0.2,0.1,0.3,0.2,0.5,0.4c0.4,0.3,0.7,0.7,1,1.2
                                                    c0.3,0.4,0.5,0.9,0.6,1.3C69.5,100.6,69.6,100.8,69.6,101z"/>
                                                <path class="st12" d="M72.9,99.1c-0.1-0.5-0.3-1.1-0.4-1.6c-0.3-0.5-0.6-0.9-1-1.3c0.1,0.1,0.3,0.2,0.4,0.3
                                                    c0.3,0.3,0.6,0.6,0.8,0.9c0.2,0.4,0.3,0.8,0.3,1.2C72.9,98.8,72.9,98.9,72.9,99.1z"/>
                                                <path class="st12" d="M76.6,98.4c0,0-0.2-0.6-0.6-1.2s-0.8-1-0.8-1.1C76,96.6,76.5,97.5,76.6,98.4z"/>
                                                <path class="st12" d="M79.9,98.9c0,0-0.1-0.5-0.4-1.1c-0.2-0.4-0.4-0.7-0.7-1c0.4,0.2,0.7,0.5,0.8,0.9
                                                    C79.8,98.1,79.9,98.5,79.9,98.9z"/>
                                                <path class="st12" d="M81.9,98.8c0.1,0.1,0.2,0.3,0.2,0.5c0,0.3-0.1,0.6-0.2,0.5s0-0.2,0-0.5S81.9,98.8,81.9,98.8z"/>
                                                <path class="st12" d="M59.6,109.5c-1-0.3-1.7-1.3-1.7-2.4c0.1,0.5,0.3,1,0.6,1.4C58.8,108.9,59.2,109.2,59.6,109.5z"/>
                                                <path class="st12" d="M58.7,111.9c-0.3,0-0.6-0.1-0.9-0.3c-0.3-0.2-0.5-0.4-0.6-0.7c0.2,0.2,0.4,0.4,0.7,0.6
                                                    C58.3,111.8,58.7,111.9,58.7,111.9z"/>
                                                <path class="st17" d="M79.2,106.4c0.2,0,0.4-0.1,0.7-0.2c0.6-0.3,1-0.7,1.2-1.3c0.4-0.8,0.3-1.8-0.2-2.6c-0.6-1-1.5-1.7-2.6-1.9
                                                    c-1.1-0.3-2.2-0.3-3.3-0.2c-0.9,0.1-1.8,0.4-2.6,0.8c-0.8,0.4-1.4,0.9-2,1.6c0.1-0.2,0.3-0.4,0.4-0.6c0.4-0.5,1-0.8,1.5-1.1
                                                    c0.8-0.4,1.7-0.7,2.7-0.8c1.1-0.2,2.3-0.1,3.4,0.2c1.1,0.3,2.1,1,2.7,2c0.5,0.8,0.6,1.9,0.2,2.7c-0.3,0.6-0.7,1-1.3,1.3
                                                    C79.7,106.3,79.5,106.4,79.2,106.4z"/>
                                                <path class="st17" d="M73.2,107c0.3-0.3,0.5-0.6,0.6-0.9c0.1-0.4,0.1-0.8,0-1.2c-0.1-0.5-0.5-0.9-0.9-1.1c-0.8-0.4-1.6-0.8-2.5-1
                                                    c-0.4-0.1-0.7-0.3-1.1-0.4c0,0,0.1,0,0.3,0l0.8,0.2c0.9,0.2,1.8,0.6,2.6,1c0.5,0.3,0.8,0.7,0.9,1.2c0.1,0.4,0.1,0.9-0.1,1.3
                                                    c-0.1,0.3-0.3,0.5-0.5,0.7C73.3,106.9,73.3,107,73.2,107z"/>
                                                <path class="st17" d="M57,91.8c0-0.3,0-0.5,0.1-0.8c0.2-0.7,0.7-1.3,1.4-1.6c1-0.5,2.1-0.5,3.1-0.1c1.2,0.6,2.1,1.7,2.4,3h-0.2
                                                    c0.2-0.2,0.4-0.4,0.7-0.6c1.2-0.8,2.8-0.8,4,0.1c0.9,0.8,1.3,2,1,3.2c-0.2,0.8-0.7,1.4-1.4,1.8c-0.2,0.2-0.5,0.3-0.8,0.3
                                                    c0.3-0.1,0.5-0.2,0.8-0.4c1.4-0.9,1.8-2.8,0.9-4.2c-0.2-0.3-0.4-0.5-0.6-0.7c-1.1-0.8-2.7-0.8-3.8-0.1c-0.2,0.2-0.5,0.3-0.6,0.6
                                                    l-0.1,0.1v-0.1c-0.3-1.3-1.2-2.3-2.3-2.9c-0.9-0.5-2.1-0.5-3,0c-0.6,0.3-1.1,0.9-1.4,1.5C57,91.2,57,91.5,57,91.8z"/>
                                                <path class="st17" d="M73.6,89.7c0.1,0,0.2,0.1,0.2,0.1c0.2,0.2,0.4,0.3,0.6,0.5c1.1,1.4,1.2,3.3,0.1,4.7c-0.2,0.2-0.3,0.4-0.5,0.6
                                                    c-0.1,0.1-0.2,0.1-0.2,0.2c0.2-0.3,0.5-0.5,0.7-0.8c0.5-0.7,0.7-1.5,0.7-2.3s-0.3-1.6-0.8-2.3C74.1,90.2,73.9,90,73.6,89.7z"/>
                                                <path class="st17" d="M53.1,94.1c-0.3,0.7-0.4,1.4-0.2,2.2c0.2,0.8,0.7,1.4,1.3,1.8c0.8,0.5,1.8,0.6,2.8,0.3l0.3-0.1L57,98.6
                                                    l-0.1,0.1c-0.6,0.8-0.5,1.9,0.2,2.6c0.6,0.6,1.4,0.9,2.2,0.8c0.5,0,1.1-0.2,1.6-0.4c0.2-0.1,0.4-0.2,0.5-0.2
                                                    c-0.2,0.1-0.3,0.2-0.5,0.3c-0.5,0.2-1,0.4-1.6,0.4c-0.8,0.1-1.7-0.2-2.3-0.8c-0.8-0.7-0.9-2-0.2-2.8l0.1-0.1l0.1,0.2
                                                    c-1,0.3-2,0.2-2.9-0.4c-0.7-0.5-1.2-1.2-1.3-2c-0.1-0.5-0.1-1.1,0-1.6C52.8,94.4,52.9,94.2,53.1,94.1z"/>
                                                <path class="st13" d="M77.9,160.7c-0.1,0.2-0.3,0.3-0.4,0.5c-0.4,0.4-0.9,0.7-1.4,1c-3.5,1.9-7.8,1.2-10.5-1.8
                                                    c-0.4-0.4-0.7-0.9-1-1.4c-0.1-0.2-0.2-0.4-0.2-0.6c0.4,0.7,0.9,1.3,1.4,1.8c2.7,2.7,6.8,3.4,10.2,1.7
                                                    C77.2,161.2,77.9,160.6,77.9,160.7z"/> 

                                            </g>
                                                
                                               
                                                
                                                    <linearGradient id="SVGID_00000057114676564663451850000010133467582970796427_" gradientUnits="userSpaceOnUse" x1="688.3501" y1="203.55" x2="712.4201" y2="203.55" gradientTransform="matrix(1 0 0 1 0 -178)">
                                                    <stop  offset="0" style="stop-color:#00FFAF"/>
                                                    <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                    <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                    <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                    <stop  offset="0.75" style="stop-color:#00469F"/>
                                                    <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                    <stop  offset="1" style="stop-color:#00249C"/>
                                                </linearGradient>
                                                <path class="whatsapp" style="fill:url(#SVGID_00000057114676564663451850000010133467582970796427_);" d="M708.8,17c-2.2-2.2-5.3-3.5-8.4-3.5
                                                    c-6.6,0-11.9,5.4-11.9,12c0,2.1,0.5,4.1,1.6,5.9l-1.7,6.2l6.3-1.7c1.7,1,3.7,1.5,5.7,1.5l0,0c6.6,0,12-5.3,12-11.9
                                                    C712.3,22.2,711.1,19.2,708.8,17z M700.4,35.3c-1.8,0-3.5-0.5-5-1.4l-0.4-0.2l-3.8,1l1-3.7l-0.2-0.4c-2.8-4.7-1.3-10.8,3.3-13.6
                                                    c4.7-2.8,10.8-1.3,13.6,3.3c0.9,1.5,1.4,3.3,1.4,5C710.4,30.9,705.9,35.4,700.4,35.3L700.4,35.3z M705.8,27.9c-0.3-0.1-1.8-0.9-2-1
                                                    s-0.5-0.1-0.7,0.1s-0.8,1-1,1.2s-0.3,0.2-0.6,0.1c-1.7-0.7-3.1-1.9-4.1-3.5c-0.3-0.5,0.3-0.5,0.9-1.6c0.1-0.2,0.1-0.4,0-0.5
                                                    s-0.7-1.6-0.9-2.2s-0.5-0.5-0.7-0.5H696c-0.3,0-0.6,0.1-0.8,0.4c-0.7,0.6-1.1,1.5-1,2.5c0.1,1.1,0.5,2.2,1.2,3.1
                                                    c1.3,1.9,3,3.5,5.1,4.5c1.9,0.8,2.6,0.9,3.6,0.7c0.8-0.2,1.6-0.7,2-1.4c0.2-0.4,0.2-0.9,0.2-1.4C706.3,28.1,706.1,28.1,705.8,27.9
                                                    L705.8,27.9z"/>
                                                
                                                    <linearGradient id="SVGID_00000048481519541198447150000000323423817227145115_" gradientUnits="userSpaceOnUse" x1="444.5447" y1="374.5375" x2="468.6047" y2="374.5375" gradientTransform="matrix(1 0 0 1 0 -178)">
                                                    <stop  offset="0" style="stop-color:#00FFAF"/>
                                                    <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                    <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                    <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                    <stop  offset="0.75" style="stop-color:#00469F"/>
                                                    <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                    <stop  offset="1" style="stop-color:#00249C"/>
                                                </linearGradient>
                                                <path style="fill:url(#SVGID_00000048481519541198447150000000323423817227145115_);" d="M465,188c-4.7-4.7-12.2-4.7-16.9,0
                                                    c-2.2,2.2-3.5,5.3-3.5,8.4c0,2.1,0.5,4.2,1.6,6l-1.7,6.2l6.3-1.7c1.7,1,3.7,1.5,5.7,1.4l0,0c6.5,0.1,11.9-5.1,12.1-11.6
                                                    C468.7,193.5,467.4,190.3,465,188z M456.6,206.3c-1.8,0-3.5-0.5-5-1.4l-0.4-0.2l-3.8,1l1-3.7l-0.2-0.4c-2.8-4.7-1.3-10.8,3.3-13.6
                                                    s10.8-1.3,13.6,3.3c0.9,1.5,1.4,3.3,1.4,5C466.5,201.9,462.1,206.3,456.6,206.3z M462,198.9c-0.3-0.1-1.8-0.9-2-1s-0.5-0.1-0.7,0.1
                                                    s-0.8,1-1,1.2s-0.4,0.2-0.6,0.1c-1.7-0.7-3.2-1.9-4.1-3.6c-0.3-0.5,0.3-0.5,0.9-1.6c0.1-0.2,0.1-0.4,0-0.5s-0.7-1.6-0.9-2.2
                                                    s-0.5-0.5-0.7-0.5h-0.6c-0.3,0-0.6,0.1-0.8,0.4c-0.7,0.7-1,1.6-1,2.5c0.1,1.1,0.5,2.2,1.2,3.1c1.3,1.9,3,3.5,5.1,4.5
                                                    c1.9,0.8,2.6,0.9,3.6,0.8c0.8-0.2,1.6-0.7,2-1.4c0.2-0.4,0.3-0.9,0.2-1.4C462.5,199.1,462.3,199.1,462,198.9L462,198.9z"/>
                                                
                                                    <linearGradient id="SVGID_00000168117904139024340710000008624384873354575257_" gradientUnits="userSpaceOnUse" x1="81.6" y1="392.7375" x2="105.6551" y2="392.7375" gradientTransform="matrix(1 0 0 1 0 -178)">
                                                    <stop  offset="0" style="stop-color:#00FFAF"/>
                                                    <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                    <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                    <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                    <stop  offset="0.75" style="stop-color:#00469F"/>
                                                    <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                    <stop  offset="1" style="stop-color:#00249C"/>
                                                </linearGradient>
                                                <path class="whatsapp" style="fill:url(#SVGID_00000168117904139024340710000008624384873354575257_);" d="M102.1,206.2c-4.7-4.7-12.2-4.7-16.9,0
                                                    c-2.2,2.2-3.5,5.3-3.5,8.4c0,2.1,0.5,4.2,1.6,6l-1.7,6.2l6.3-1.7c1.7,1,3.7,1.5,5.7,1.4l0,0c6.5,0.1,11.9-5.1,12-11.7
                                                    C105.7,211.7,104.4,208.5,102.1,206.2L102.1,206.2z M93.6,224.6c-1.8,0-3.5-0.5-5-1.4l-0.4-0.2l-3.8,1l1-3.7l-0.2-0.4
                                                    c-2.8-4.7-1.3-10.8,3.3-13.6c4.7-2.8,10.8-1.3,13.6,3.3c0.9,1.5,1.4,3.3,1.4,5C103.6,220.2,99.1,224.6,93.6,224.6z M99.1,217.2
                                                    c-0.3-0.1-1.8-0.9-2-1s-0.5-0.1-0.7,0.1s-0.8,1-0.9,1.2s-0.3,0.2-0.6,0.1c-1.7-0.7-3.1-1.9-4.1-3.5c-0.3-0.5,0.3-0.5,0.9-1.6
                                                    c0.1-0.2,0.1-0.4,0-0.5s-0.7-1.6-0.9-2.2s-0.5-0.5-0.7-0.5h-0.6c-0.3,0-0.6,0.1-0.8,0.4c-0.7,0.7-1,1.6-1,2.5
                                                    c0.1,1.1,0.5,2.2,1.2,3.1c1.2,1.9,2.9,3.5,5,4.5c1.9,0.8,2.6,0.9,3.6,0.7c0.8-0.2,1.6-0.7,2-1.4c0.2-0.4,0.2-0.9,0.2-1.4
                                                    C99.6,217.4,99.4,217.3,99.1,217.2z"/>
                                                
                                                    <linearGradient id="SVGID_00000109745818142077250260000003696038622928830357_" gradientUnits="userSpaceOnUse" x1="86" y1="247.5375" x2="110.0551" y2="247.5375" gradientTransform="matrix(1 0 0 1 0 -178)">
                                                    <stop  offset="0" style="stop-color:#00FFAF"/>
                                                    <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                    <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                    <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                    <stop  offset="0.75" style="stop-color:#00469F"/>
                                                    <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                    <stop  offset="1" style="stop-color:#00249C"/>
                                                </linearGradient>
                                                <path class="whatsapp" style="fill:url(#SVGID_00000109745818142077250260000003696038622928830357_);" d="M106.4,61c-4.7-4.7-12.2-4.7-16.9,0
                                                    c-2.2,2.2-3.5,5.3-3.5,8.4c0,2.1,0.5,4.2,1.6,6L86,81.6l6.3-1.7c1.7,1,3.7,1.5,5.7,1.4l0,0c6.5,0.1,11.9-5.1,12-11.7
                                                    C110.1,66.5,108.8,63.3,106.4,61L106.4,61z M98,79.4c-1.8,0-3.5-0.5-5.1-1.4l-0.4-0.2l-3.8,1l1-3.7l-0.2-0.4
                                                    C86.8,70.1,88.3,64,93,61.1c4.7-2.8,10.8-1.3,13.6,3.3c0.9,1.5,1.4,3.3,1.4,5C108,75,103.5,79.4,98,79.4z M103.4,72
                                                    c-0.3-0.1-1.8-0.9-2-1s-0.5-0.1-0.7,0.1s-0.8,1-1,1.2s-0.3,0.2-0.6,0.1c-1.7-0.7-3.1-1.9-4.1-3.5c-0.3-0.5,0.3-0.5,0.9-1.6
                                                    c0.1-0.2,0.1-0.4,0-0.5s-0.7-1.6-0.9-2.2c-0.2-0.6-0.5-0.5-0.7-0.5h-0.6c-0.3,0-0.6,0.1-0.8,0.4c-0.7,0.7-1,1.6-1,2.5
                                                    c0.1,1.1,0.5,2.2,1.2,3.1c1.2,1.9,2.9,3.5,5,4.5c1.9,0.8,2.6,0.9,3.6,0.7c0.8-0.2,1.6-0.7,2-1.4c0.2-0.4,0.2-0.9,0.2-1.4
                                                    C103.9,72.2,103.7,72.1,103.4,72z"/>
                                                <g>
                                                    <g>
                                                        
                                                            <linearGradient id="SVGID_00000100360679543183668000000015076156031928961962_" gradientUnits="userSpaceOnUse" x1="439.5647" y1="161.6" x2="653.6755" y2="161.6" gradientTransform="matrix(1 0 0 -1 0 322)">
                                                            <stop  offset="0" style="stop-color:#00FFAF"/>
                                                            <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                            <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                            <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                            <stop  offset="0.75" style="stop-color:#00469F"/>
                                                            <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                            <stop  offset="1" style="stop-color:#00249C"/>
                                                        </linearGradient>
                                                        
                                                            <path style="fill:none;stroke:url(#SVGID_00000100360679543183668000000015076156031928961962_);stroke-width:0.5;stroke-linecap:round;stroke-miterlimit:10;" d="
                                                            M439.8,161.3c0.3-0.6,0.6-1.2,0.9-1.8"/>
                                                        
                                                            <linearGradient id="SVGID_00000179619246040905164300000005110291011985845635_" gradientUnits="userSpaceOnUse" x1="439.5647" y1="212.7356" x2="653.6755" y2="212.7356" gradientTransform="matrix(1 0 0 -1 0 322)">
                                                            <stop  offset="0" style="stop-color:#00FFAF"/>
                                                            <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                            <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                            <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                            <stop  offset="0.75" style="stop-color:#00469F"/>
                                                            <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                            <stop  offset="1" style="stop-color:#00249C"/>
                                                        </linearGradient>
                                                        
                                                            <path class="line_1" style="fill:none;stroke:url(#SVGID_00000179619246040905164300000005110291011985845635_);stroke-width:0.5;stroke-linecap:round;stroke-miterlimit:10;" d="
                                                            M442.4,156c8.5-16.9,23.4-39.9,48.6-59.1c62.5-47.6,138-33.5,158.5-28.5"/>
                                                        
                                                            <linearGradient id="SVGID_00000002350912569919244270000012317719989670645166_" gradientUnits="userSpaceOnUse" x1="439.5647" y1="252.95" x2="653.6755" y2="252.95" gradientTransform="matrix(1 0 0 -1 0 322)">
                                                            <stop  offset="0" style="stop-color:#00FFAF"/>
                                                            <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                            <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                            <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                            <stop  offset="0.75" style="stop-color:#00469F"/>
                                                            <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                            <stop  offset="1" style="stop-color:#00249C"/>
                                                        </linearGradient>
                                                        
                                                            <path style="fill:none;stroke:url(#SVGID_00000002350912569919244270000012317719989670645166_);stroke-width:0.5;stroke-linecap:round;stroke-miterlimit:10;" d="
                                                            M651.5,68.8c0.8,0.2,1.4,0.4,1.9,0.5"/>
                                                    </g>
                                                </g>
                                                <g>
                                                    <g>
                                                        
                                                            <linearGradient id="SVGID_00000178190506048627810770000016279080415759903388_" gradientUnits="userSpaceOnUse" x1="439.5281" y1="150.236" x2="564.1378" y2="35.108" gradientTransform="matrix(1 0 0 -1 0 322)">
                                                            <stop  offset="0" style="stop-color:#00FFAF"/>
                                                            <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                            <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                            <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                            <stop  offset="0.75" style="stop-color:#00469F"/>
                                                            <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                            <stop  offset="1" style="stop-color:#00249C"/>
                                                        </linearGradient>
                                                        
                                                            <path style="fill:none;stroke:url(#SVGID_00000178190506048627810770000016279080415759903388_);stroke-width:0.5;stroke-linecap:round;stroke-miterlimit:10;" d="
                                                            M439.1,172.6c0.6-0.3,1.2-0.5,1.8-0.8"/>
                                                        
                                                            <linearGradient id="SVGID_00000019639159076346785040000009984954915473873547_" gradientUnits="userSpaceOnUse" x1="468.1653" y1="181.2317" x2="592.775" y2="66.1038" gradientTransform="matrix(1 0 0 -1 0 322)">
                                                            <stop  offset="0" style="stop-color:#00FFAF"/>
                                                            <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                            <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                            <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                            <stop  offset="0.75" style="stop-color:#00469F"/>
                                                            <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                            <stop  offset="1" style="stop-color:#00249C"/>
                                                        </linearGradient>
                                                        
                                                            <path class="line_1" style="fill:none;stroke:url(#SVGID_00000019639159076346785040000009984954915473873547_);stroke-width:0.5;stroke-linecap:round;stroke-miterlimit:10;" d="
                                                            M444.7,170.3c14.3-5.4,35.2-10.9,59.9-8.9c61.7,5,97.6,52.5,107.5,67.3"/>
                                                        
                                                            <linearGradient id="SVGID_00000146471632414292931310000014322801309830618770_" gradientUnits="userSpaceOnUse" x1="490.1053" y1="204.9787" x2="614.715" y2="89.8508" gradientTransform="matrix(1 0 0 -1 0 322)">
                                                            <stop  offset="0" style="stop-color:#00FFAF"/>
                                                            <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                            <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                            <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                            <stop  offset="0.75" style="stop-color:#00469F"/>
                                                            <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                            <stop  offset="1" style="stop-color:#00249C"/>
                                                        </linearGradient>
                                                        
                                                            <path  style="fill:none;stroke:url(#SVGID_00000146471632414292931310000014322801309830618770_);stroke-width:0.5;stroke-linecap:round;stroke-miterlimit:10;" d="
                                                            M613.3,230.5c0.4,0.7,0.8,1.2,1.1,1.7"/>
                                                    </g>
                                                </g>
                                                
                                                    <linearGradient id="SVGID_00000016766136557215900450000008008118748277392306_" gradientUnits="userSpaceOnUse" x1="650.7079" y1="247.5851" x2="670.0143" y2="247.5851" gradientTransform="matrix(1 0 0 1 0 -178)">
                                                    <stop  offset="0" style="stop-color:#00FFAF"/>
                                                    <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                    <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                    <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                    <stop  offset="0.75" style="stop-color:#00469F"/>
                                                    <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                    <stop  offset="1" style="stop-color:#00249C"/>
                                                </linearGradient>
                                                <path class="location_1" style="fill:url(#SVGID_00000016766136557215900450000008008118748277392306_);" d="M658.9,82.6c0.6,1.1,1.9,1.4,3,0.8
                                                    c0.4-0.2,0.7-0.6,0.9-1l5.4-11.2c2-4.4,1.9-6.8,1.9-6.8c0-6.8-7-11.1-14.3-7.8c-1.4,0.6-2.7,1.6-3.5,2.9c-2.4,3.7-1.6,8.1,0.1,11.8
                                                    L658.9,82.6z M663.3,70.3c-5.3,3-10.6-2.7-7.7-8.2c0.4-0.7,1-1.3,1.7-1.8c5.3-3,10.6,2.7,7.7,8.2C664.6,69.3,664.1,69.9,663.3,70.3
                                                    z"/>
                                                
                                                    <linearGradient id="SVGID_00000132779020647129067120000016303687999614702759_" gradientUnits="userSpaceOnUse" x1="608.3947" y1="418.4562" x2="632.46" y2="418.4562" gradientTransform="matrix(1 0 0 1 0 -178)">
                                                    <stop  offset="0" style="stop-color:#00FFAF"/>
                                                    <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                    <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                    <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                    <stop  offset="0.75" style="stop-color:#00469F"/>
                                                    <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                    <stop  offset="1" style="stop-color:#00249C"/>
                                                </linearGradient>
                                                <path class="whatsapp" style="fill:url(#SVGID_00000132779020647129067120000016303687999614702759_);" d="M628.8,231.9c-4.7-4.7-12.2-4.6-16.9,0
                                                    c-3.8,3.8-4.6,9.7-1.9,14.4l-1.7,6.2l6.3-1.7c1.7,1,3.7,1.5,5.7,1.4l0,0c6.5,0.1,11.9-5.1,12-11.7
                                                    C632.5,237.3,631.2,234.2,628.8,231.9z M620.4,250.2c-1.8,0-3.5-0.5-5-1.4l-0.4-0.2l-3.8,1l1-3.7l-0.2-0.4
                                                    c-2.8-4.7-1.3-10.8,3.3-13.6c4.7-2.8,10.8-1.3,13.6,3.3c0.9,1.5,1.4,3.3,1.4,5C630.4,245.8,625.9,250.2,620.4,250.2L620.4,250.2z
                                                     M625.8,242.8c-0.3-0.1-1.8-0.9-2-1s-0.5-0.1-0.7,0.1s-0.8,1-1,1.2s-0.4,0.2-0.6,0.1c-1.7-0.7-3.1-1.9-4.1-3.6
                                                    c-0.3-0.5,0.3-0.5,0.9-1.6c0.1-0.2,0.1-0.4,0-0.5s-0.7-1.6-0.9-2.2s-0.5-0.5-0.7-0.5h-0.6c-0.3,0-0.6,0.1-0.8,0.4
                                                    c-0.7,0.6-1.1,1.5-1,2.5c0.1,1.1,0.5,2.2,1.2,3.1c1.3,1.9,3,3.5,5.1,4.5c1.9,0.8,2.6,0.9,3.6,0.8c0.8-0.2,1.6-0.7,2-1.4
                                                    c0.2-0.4,0.2-0.9,0.2-1.4C626.4,243.1,626.2,243,625.8,242.8z"/>
                                                
                                                    <linearGradient id="SVGID_00000119819485716413135440000004512263575729141182_" gradientUnits="userSpaceOnUse" x1="110.25" y1="204.1157" x2="430.35" y2="204.1157" gradientTransform="matrix(1 0 0 -1 0 322)">
                                                    <stop  offset="0" style="stop-color:#00FFAF"/>
                                                    <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                    <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                    <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                    <stop  offset="0.75" style="stop-color:#00469F"/>
                                                    <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                    <stop  offset="1" style="stop-color:#00249C"/>
                                                </linearGradient>
                                                
                                                    <path class="line_1" style="fill:none;stroke:url(#SVGID_00000119819485716413135440000004512263575729141182_);stroke-width:0.5;stroke-linecap:round;stroke-miterlimit:10;" d="
                                                    M430.1,159.3c-18.9-20.5-54.4-53.1-107.4-70.8c-104-34.7-193.3,15.3-212.2,26.5"/>
                                                
                                                    <linearGradient id="SVGID_00000170965595748945624250000015597192944863243180_" gradientUnits="userSpaceOnUse" x1="115.25" y1="147.975" x2="187.5053" y2="147.975" gradientTransform="matrix(1 0 0 -1 0 322)">
                                                    <stop  offset="0" style="stop-color:#00FFAF"/>
                                                    <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                    <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                    <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                    <stop  offset="0.75" style="stop-color:#00469F"/>
                                                    <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                    <stop  offset="1" style="stop-color:#00249C"/>
                                                </linearGradient>
                                                
                                                    <path class="line_1" style="fill:none;stroke:url(#SVGID_00000170965595748945624250000015597192944863243180_);stroke-width:0.5;stroke-linecap:round;stroke-miterlimit:10;" d="
                                                    M115.5,118c5.6,1.4,45.8,12.6,63.7,51.5c12.6,27.2,7.1,52.3,5,60.5"/>
                                                
                                                    <linearGradient id="SVGID_00000163061146729393046740000008964014288357227154_" gradientUnits="userSpaceOnUse" x1="195.3" y1="122.2" x2="431.7" y2="122.2" gradientTransform="matrix(0.9683 5.167814e-02 5.151328e-02 -0.9652 -8.270922e-05 302.8089)">
                                                    <stop  offset="0" style="stop-color:#00FFAF"/>
                                                    <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                    <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                    <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                    <stop  offset="0.75" style="stop-color:#00469F"/>
                                                    <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                    <stop  offset="1" style="stop-color:#00249C"/>
                                                </linearGradient>
                                                
                                                    <path class="line_1" style="fill:none;stroke:url(#SVGID_00000163061146729393046740000008964014288357227154_);stroke-width:0.5;stroke-linecap:round;stroke-miterlimit:10;" d="
                                                    M426.3,165.7c-25.1-3-63.8-4.5-108.9,6.8c-61.1,15.3-102.8,46.3-123.9,64.5"/>
                                                
                                                    <linearGradient id="SVGID_00000078724754048884573970000011738114152986586297_" gradientUnits="userSpaceOnUse" x1="179.9773" y1="414.4517" x2="199.283" y2="414.4517" gradientTransform="matrix(1 0 0 1 0 -178)">
                                                    <stop  offset="0" style="stop-color:#00FFAF"/>
                                                    <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                    <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                    <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                    <stop  offset="0.75" style="stop-color:#00469F"/>
                                                    <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                    <stop  offset="1" style="stop-color:#00249C"/>
                                                </linearGradient>
                                                <path class="location" style="fill:url(#SVGID_00000078724754048884573970000011738114152986586297_);" d="M188.2,249.5c0.6,1,1.9,1.4,3,0.8
                                                    c0.4-0.2,0.7-0.5,0.9-0.9l5.4-11.2c1.9-4.4,1.9-6.9,1.9-6.9c0-6.8-7-11.1-14.3-7.9c-1.4,0.6-2.7,1.6-3.5,2.9
                                                    c-2.4,3.7-1.6,8.1,0.1,11.8L188.2,249.5z M192.6,237.2c-5.3,3-10.6-2.6-7.7-8.2c0.4-0.7,1-1.3,1.7-1.8c5.3-3,10.6,2.6,7.7,8.2
                                                    C193.9,236.1,193.3,236.7,192.6,237.2z"/>
                                                
                                                    <linearGradient id="SVGID_00000064336082049578609900000006503185991858139058_" gradientUnits="userSpaceOnUse" x1="100.8894" y1="287.5742" x2="120.1959" y2="287.5742" gradientTransform="matrix(1 0 0 1 0 -178)">
                                                    <stop  offset="0" style="stop-color:#00FFAF"/>
                                                    <stop  offset="6.000000e-02" style="stop-color:#00EDAD"/>
                                                    <stop  offset="0.32" style="stop-color:#00A6A7"/>
                                                    <stop  offset="0.55" style="stop-color:#006EA2"/>
                                                    <stop  offset="0.75" style="stop-color:#00469F"/>
                                                    <stop  offset="0.91" style="stop-color:#002D9D"/>
                                                    <stop  offset="1" style="stop-color:#00249C"/>
                                                </linearGradient>
                                                <path class="location_1" style="fill:url(#SVGID_00000064336082049578609900000006503185991858139058_);" d="M109.1,122.6c0.6,1,1.9,1.4,3,0.8l0,0
                                                    c0.4-0.2,0.7-0.6,0.9-1l5.4-11.2c2-4.4,1.9-6.8,1.9-6.8c0-6.8-7-11.1-14.3-7.8c-1.4,0.6-2.7,1.6-3.5,2.9c-2.4,3.7-1.6,8.2,0.1,11.8
                                                    L109.1,122.6z M113.6,110.2c-5.3,3-10.6-2.7-7.7-8.2c0.4-0.7,1-1.4,1.7-1.8c5.3-3,10.6,2.7,7.7,8.2
                                                    C114.8,109.2,114.3,109.8,113.6,110.2L113.6,110.2z"/>
                                                <path class="st52" d="M433.2,185.4c0.6,1,1.9,1.4,3,0.8c0.4-0.2,0.7-0.6,0.9-1l5.4-11.2c2-4.4,1.9-6.9,1.9-6.9
                                                    c0-6.8-7-11.1-14.3-7.8c-1.4,0.6-2.7,1.6-3.5,2.9c-2.4,3.7-1.7,8.1,0.1,11.8L433.2,185.4z M437.6,173.1c-5.3,3-10.6-2.7-7.7-8.2
                                                    c0.4-0.7,1-1.4,1.7-1.8c5.3-3,10.6,2.7,7.7,8.2C438.9,172.1,438.3,172.7,437.6,173.1L437.6,173.1z"/>
                                            </g>
                                            </svg>

                                        </div>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
                <div class="section_bottom_arrow">
                    <div class="arrow">
                        <i class="bi bi-chevron-down arrow1"></i> 
                    </div>
                </div>    
            </section>

            <!--   section2 -->
            <section id="section2" class="section">
                <div class="section_heading">
                    <div class="container">
                        <div class="position-relative">
                            <div class="row justify-content-center align-items-center my-5">
                               <div class="col-lg-10 col-md-10 col-sm-12">
                                    <div class="text-center align-middle">
                                        <h1 class="font-700 color-text-gradient">Do you wish to send your customer bulk messages on their WhatsApp?</h1>
                                    </div>        
                               </div>
                            </div>
                        </div>
                    </div>
                </div>
                 <div class="text-center section_2_img">
                    <img src="{{ asset('assets/front/images/features_landing_pages/do_you_wish.svg') }}">
                </div>
                <div class="section_bottom_arrow">
                    <div class="arrow">
                        <i class="bi bi-chevron-down arrow1"></i> 
                    </div>
                </div> 
            </section> 
            <!-- section3 -->          
            <section id="section3" class="section">
                <div class="section_heading">
                    <div class="container">
                        <div class="position-relative">
                            <div class="row justify-content-center align-items-center my-5">
                               <div class="col-lg-9 col-md-10 col-sm-12">
                                    <div class="text-center que_background_img">
                                        <h1 class="font-700 color-text-gradient">Want an automated system for bulk whatsapp messaging?</h1>      
                                    </div>        
                               </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="section_bottom_arrow">
                    <div class="arrow">
                        <i class="bi bi-chevron-down arrow1"></i> 
                    </div>
                </div>    
            </section>
             <!-- section4 -->
            <section id="section4" class="section">
                <div class="section_heading">
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
                <div class="section_bottom_arrow">
                    <div class="arrow">
                        <i class="bi bi-chevron-down arrow1"></i> 
                    </div>
                </div>
            </section>
            <!-- section5 -->
           <section id="section5" class="section">
                <div class="section_heading">
                    <div class="container">
                        <div class="position-relative">
                            <div class="row my-5 justify-content-between align-items-center">
                                <div class="col-lg-7 col-md-8 col-sm-12">
                                    <div class="">
                                        <div class="text_animation" style="line-height: 1;">
                                            <span class="d-block h5" style="line-height: 1;">Well, then we are here to help you to do it in few clicks</span>
                                            <span class="h1 font-900 color-text-gradient text-uppercase d-block">Through OPENLINK, D2C you can effortlessly send your customers messages in bulk on their whatsapp</span>
                                            <!--  <span class="d-block h5" style="line-height: 1;">with the right set of audiences.Replace your Paid campaigns with</span>
                                            <span class="h1 font-900 color-text-gradient text-uppercase d-block"> INSTANT REWARD From OPENLINK.</span></div> -->
                                        </div>          
                                    </div>        
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="D2C_whatsapp mt-4 mt-sm-0 text-center">
                                        <img src="{{ asset('assets/front/images/features_landing_pages/whatsapp_msg.svg') }}" style="max-width: 300px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>    
                <div class="section_bottom_arrow">
                    <div class="arrow">
                        <i class="bi bi-chevron-down arrow1"></i> 
                    </div>
                </div>
           </section>  
            <!-- section6 -->
           <section id="section6" class="section">
                <div class="section_heading" style="justify-content:center;">
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
                <div class="">
                    <div class="text-center section7_img">
                        <img src="{{ asset('assets/front/images/features_landing_pages/how.svg') }}">
                    </div>
                    <div class="section_bottom_arrow arrow">
                        <i class="bi bi-chevron-down arrow1"></i> 
                    </div>
                </div>     
            </section>  
        <!-- section 7 -->
            <section id="section7" class="section">
                <div class="container">
                    <div class="position-relative">
                        <div class="row justify-content-center my-5">
                           <div class="col-lg-9 col-md-10 col-sm-12">
                                <div class="text-center pb-3">
                                   <h1 class="text-uppercase">OPENLINK'S D2C Is all your answers!</h1>
                                   <p>OPENLINK D2C Post gives you an easily accessible and effective platform to share your content i.e your business update, alerts, or any other message on your customer's WhatsApp that too in one click to your Customer Base. OPENLINK D2C posting is a WhatsApp bulk messaging service</p>
                                   <p>You can send customised messages to your customer base 24/7 on their WhatsApp in one click. D2C post gives you 100% assurance for instant delivery within no time.</p>
                                </div>  
                                <div class="text-center my-5">
                                   <h2>Why D2C for your business?</h2> 
                                </div>     
                                <div class="bg_options mb-4">
                                    <div class="background_number d-inline ms-3"><i class="bi bi-caret-right-fill"></i></div>
                                    <h5 class="d-inline ms-2">Effortless bulk messaging.</h5>
                                </div>
                                <div class="bg_options mb-4">
                                    <div class="background_number d-inline ms-3"><i class="bi bi-caret-right-fill"></i></div>
                                    <h5 class="d-inline ms-2">Saves your time.</h5>
                                </div>
                                <div class="bg_options mb-4">
                                    <div class="background_number d-inline ms-3"><i class="bi bi-caret-right-fill"></i></div>
                                    <h5 class="d-inline ms-2">Quick updates to customer on their WhatsApp.</h5>
                                </div>        
                                <div class="bg_options mb-4">
                                    <div class="background_number d-inline ms-3"><i class="bi bi-caret-right-fill"></i></div>
                                    <h5 class="d-inline ms-2">Customizable messaging template.</h5>
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
                           <div class="col-lg-9 px-0">
                                <div class="text-center text-white py-4">
                                    <h2 class="font-700">How to create Broadcast WhatsApp message with D2C?</h2>
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
                                            <h5>Here you are landed to OPENLINK’S dashboard click on D2C Posts</h5>
                                        </div>
                                    </div>
                                </div> 
                                <!-- circle3 -->
                                <div class="circle_img_right mb-5">
                                    <img src="{{ asset('assets/front/images/features_landing_pages/arrow_left.svg') }}"> 
                                    <div class="steps_circle">
                                        <div class="text-center inside_circle">
                                            <h1 class="text-uppercase color-text-gradient font-900">Step 3</h1>
                                            <h5>Select schedule date and set the message, and schedule your D2C post</h5> 
                                        </div>
                                    </div>
                                </div> 
                                <!-- circle4 -->
                                 <div class="circle_img_left mb-5">
                                    <img src="{{ asset('assets/front/images/features_landing_pages/arrow_right.svg') }}"> 
                                    <div class="steps_circle float-end">
                                        <div class="text-center inside_circle">
                                            <h1 class="text-uppercase color-text-gradient font-900">Step 4</h1>
                                            <h5> That’s it!! Your messages will be automatically shooted to your customer base as per data saved in it</h5>
                                        </div>
                                    </div>
                                </div>
                           	<h6 style="margin-top: 120px;">So don’t miss the time anymore!! Start greeting your customer.</h6>    
                            <button class="btn-theme btn-sm-lg text-uppercase">Buy D2C Post Now</button> 
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