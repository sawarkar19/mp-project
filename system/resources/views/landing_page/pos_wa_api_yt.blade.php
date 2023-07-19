<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
    /* Get the Marketing tool data like Google Analytics, Google Tag Manager, Facebook Pixel */
    $marketing_tools = DB::table('options')->where('key', 'marketing_tool')->first();
    $mt_data = json_decode($marketing_tools->value);
    @endphp
    {{-- /* Check for Google tag maneger & print the script */ --}}
    @if (isset($mt_data->google_tag_manager_status) && $mt_data->google_tag_manager_status === "on")
    @if (isset($mt_data->gtm_container_id) && !empty($mt_data->gtm_container_id))
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer', '{{$mt_data->gtm_container_id}}');</script>
    <!-- End Google Tag Manager -->
    @endif
    @endif
    {{-- /* Check for Google Analytics & print the script */ --}}
    @if (isset($mt_data->google_status) && $mt_data->google_status === "on")
    @if (isset($mt_data->ga_measurement_id) && !empty($mt_data->ga_measurement_id))
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{$mt_data->ga_measurement_id}}"></script>
    <script>window.dataLayer = window.dataLayer || [];function gtag(){window.dataLayer.push(arguments);}gtag('js', new Date());gtag('config', '{{$mt_data->ga_measurement_id}}');</script>
    @endif
    @endif
    {{-- /* Check for Facebook Pixel & print the script */ --}}
    @if (isset($mt_data->fb_pixel_status) && $mt_data->fb_pixel_status === "on")
    @if (isset($mt_data->fb_pixel) && !empty($mt_data->fb_pixel))
    <!-- Facebook Pixel Code -->
    <script>!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window, document,'script','https://connect.facebook.net/en_US/fbevents.js');fbq('init', {{$mt_data->fb_pixel}});fbq('track', 'PageView');</script>
    <!-- End Facebook Pixel Code -->
    @endif
    @endif
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <title>MouthPublicity.io - Messaging API for POS Systems</title>
    <meta name="title" content="MouthPublicity.io - Messaging API for POS Systems">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="{{ asset('assets/front/vendor/bootstrap/css/bootstrap.min.css') }}" media="all">
    <!-- ICONS (Bootstrap) V1.5.0 -->
    <link rel="stylesheet" href="{{ asset('assets/front/vendor/bootstrap-icons/font/bootstrap-icons.css') }}" media="all">

    <link rel="stylesheet" href="{{ asset('assets/front/css/customs.css') }}" media="all">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&family=Poppins:ital,wght@0,300;0,500;0,600;0,700;1,300&display=swap');
        :root{
            /* Font Family */
            --font-h1: 'Poppins', sans-serif;
            --font-t1: 'Open Sans', sans-serif;
            --font-gs: 16px; /* Font global size */
            --color-thm-lth:rgb(0,36,156);
            --color-thm-drk:rgb(0,255,175);
            
            /* --color-thm-shd: linear-gradient(90deg, var(--color-thm-lth), var(--color-thm-drk)); */
            --color-thm-shd: linear-gradient(90deg, rgba(0,36,156, 0.9) 0%, rgb(0,255,175, 0.9) 180%);

            --text-light-color: rgb(255,255,255);

            --menu-width: 230px;
        }
        body{
            font-family: var(--font-t1);
            font-size: var(--font-gs);
            
            /* min-height: 100vh; */
            width: 100%;
            overflow-x: hidden;
            line-height: 1.8;
        }



        .pop_logo {
            width: 100%;
            max-width: 130px;
        }
         .play-btn{
            width:70px; 
            height:70px; 
            border-radius:50%; 
            position: absolute; 
            top: 40%; 
            left: 47%; 
            background: transparent;
            border: 1px solid transparent
         }

        .vd-rply-btn{
            width: 60px;
            height: 60px; 
            display: inline-block;
            border-radius: 50%; 
            border: 1px solid #fff;
         }

        .vd-rply-btn-icon{
            font-size: 50px;
            color: #fff;
            position: relative;
            bottom: 17px;
        }
        .vd-player-screen{
            position:fixed; 
            top: 0; 
            left: 0; 
            right: 0; 
            bottom: 0;
        }
        .vd-nav{
            position:relative; 
            width: 100%;
            max-width: 150px;
        }
        .vd-main-pt{
            padding-top: 13rem;
        }
        .vd-main-pt1{
            padding-top: 11rem;
        }
        .btn-font{
            font-size: 30px;
        }
        #btnSubmit{
            font-size: 70px;
            position: relative;
            bottom: 60%;
            right: 5px;
        }
        .enquiry-img{
            width: 50%;
            margin-top:40px;
        }
       @media only screen and (max-width:575px) {
            .vd-main-pt{
                padding-top: 0.5rem !important;
            }
            .vd-main-pt1{
                padding-top: 3.5rem;
            }
            .btn-font{
                font-size: 10px;
            }
            .play-btn{
                top: 47%;
                left: 40%;
            }
            #btnSubmit{
                bottom: 47%;
                right: 5px;
            }
            .enquiry-img{
                width: 45%;
                margin-top:0px;
            }
        }


        .video-btn{
            z-index: 999;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgb(0,0,0, 0.2);
            transition: all 300ms ease;
        }
        .video-btn:hover{
            background-color: rgb(0,0,0, 0.75);
        }
        .play-video {
            color: #fff;
            border-radius: 50%;
            display: inline-block;
            height: 80px;
            width: 80px;
            text-align: center;
            animation: animate-pulse 2s linear infinite;
            -webkit-animation: animate-pulse 2s linear infinite;
            -webkit-transition: all 0.4s ease 0s;
            transition: all 0.4s ease 0s;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(1);
        }
        .play-video:hover {
            color: #FFF;
            transform:translate(-50%, -50%) scale(1.2);
        }
        .play-video i {
            font-size: 4rem;
            line-height: 80px;
            margin-left: 7px;
        }
        @keyframes animate-pulse{
            0%{box-shadow: 0 0 0 0 rgba(0,239,173,0.7),  0 0 0 0 rgba(0,239,173,0.7);}
            40%{box-shadow: 0 0 0 20px rgba(0,239,173,0.0),  0 0 0 0 rgba(0,239,173,0.7);}
            80%{box-shadow: 0 0 0 20px rgba(0,239,173,0.0),  0 0 0 15px rgba(0,239,173,0);}
            100%{box-shadow: 0 0 0 0 rgba(0,239,173,0.0),  0 0 0 15px rgba(0,239,173,0);}
        }
        @-webkit-keyframes animate-pulse{
            0%{box-shadow: 0 0 0 0 rgba(0,239,173,0.7),  0 0 0 0 rgba(0,239,173,0.7);}
            40%{box-shadow: 0 0 0 20px rgba(0,239,173,0.0),  0 0 0 0 rgba(0,239,173,0.7);}
            80%{box-shadow: 0 0 0 20px rgba(0,239,173,0.0),  0 0 0 15px rgba(0,239,173,0);}
            100%{box-shadow: 0 0 0 0 rgba(0,239,173,0.0),  0 0 0 15px rgba(0,239,173,0);}
        }


        .bg-black{
            background-color: #000;
        }

        #loader{
            position: absolute;
            z-index: 999;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: inline-block;
        }

        iframe { pointer-events: none; 
            width: 100%;
            height: 100vh;
        }

        /* .vid
          {
            position:fixed;
            top:0;
            left:0;
            min-width:100%;
            min-height:100%;
            margin:0 auto;
          } */
      

    </style>

    <script src="{{ asset('assets/front/vendor/jQuery/jQuery.min.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
</head>
<body>
    {{-- <header>
        <nav class="navbar navbar-dark bg-dark">
            <div class="container-fluid">
              <a class="navbar-brand" href="{{url('')}}">
                <img src="{{asset('assets/front/images/logo-light.svg')}}" alt="MouthPublicity.io" width="130" class="d-inline-block align-text-top">
              </a>
            </div>
        </nav>
    </header> --}}
    
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-black">
        <div class="container-fluid">
          <a class="navbar-brand vd-nav py-0" href="{{url('')}}" style="">
              <img src="{{ asset('assets/front/images/logo-light.svg') }}" class="img-fluid" />
          </a>
        </div>
    </nav>
      
    <section>
        <div class="vd-player-screen">
            <div id="plyer_win" class="w-100">
                <div id="player"></div>
            </div>
        </div>

        <div class="video-btn" id="playnow">
            <a class="play-video oplk-bg-color-gradient" href="#">
                <i class="bi bi-play-fill"></i>
            </a>
        </div>

        {{-- <video muted="true" autoplay="true" class="vid" id="loader"  style="display: none;">
            <source src="assets/front/images/videotest.mp4" type="video/mp4">
        </video> --}}
    </section>
  
    <footer class="fixed-bottom bg-black p-3" style="height: 50px;">
        <div class="float-end">                  
            <!-- <a href="tel:+91 788 788 2244" class="btn btn-sm btn-theme py-1 me-3">Call Now</a>
            <a href="pricing" class="btn btn-theme btn-sm py-1">Buy Now</a> -->
        </div>    
    </footer>

    
  
    {{-- Modal Question 1 --}}
    <div class="modal" id="que_1st" data-bs-backdrop="static" >
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-body">
                    
                    <div class="d-md-flex h-100 flex-coolumn align-items-center justify-content-center">
                        <div class="d-block">
                            <div class="container">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <div class="text-center text-md-start mb-5 mb-md-0">
                                            <h1 class="font-h1 h2 mb-5"> Do you have a POS or Billing Software for your business?</h1>
                                            <div class="">
                                                <button type="button" class="btn btn-theme btn-lg me-3" onclick="queOne('no');">No</button>
                                                <button type="button" class="btn btn-theme btn-lg" onclick="queOne('yes');">Yes</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-center">
                                            <img src="{{ asset('assets/landing-page/first.png') }}" style="max-width: 300px;width:100%">
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
  
      
    {{-- Modal Question 2 --}}
    <div class="modal" id="que_2nd" data-bs-backdrop="static">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-body">

                    <div class="d-md-flex flex-column justify-content-center align-items-center h-100">
                        <div class="d-block w-100">
                            <div class="container">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <div class="mb-5 mb-md-0 text-center text-md-start">
                                            <h1 class="mb-5 h2">Do you send SMS or WhatsApp to your customers via POS Software?</h1>
                                            <div class="">
                                                <button type="button" class="btn btn-theme btn-lg me-3" onclick="queTwo('no');">No</button>
                                                <button type="button" class="btn btn-theme btn-lg" onclick="queTwo('yes');">Yes</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-center">
                                            <img src="{{ asset('assets/landing-page/second.png') }}" style="width:100%;max-width:120px;" >
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
  
    {{-- Modal Question 3 --}}
    <div class="modal" id="que_3rd" data-bs-backdrop="static">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-body">
                    
                    <div class="d-md-flex flex-column justify-content-center align-items-center h-100">
                        <div class="d-block w-100">
                            <div class="container">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <div class="mb-5 mb-md-0">
                                            <h1 class="mb-3 h2">Which software do you use?</h1>
                                            <div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" name="software" class="form-control" id="software_name" placeholder="Enter software name...">
                                                    <label for="software_name">Enter software name...</label>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <button type="button" class="btn btn-theme me-3 btn-lg" onclick="queThree();">Submit</button>
                                                    <button type="button" class="btn btn-outline-dark btn-lg" onclick="queThreeSkip();">Skip</button>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-center">
                                            <img src="{{ asset('assets/landing-page/first.png') }}" style="width: 100%;max-width:300px;">
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
  
    {{-- Modal Inquiry --}}
    <div class="modal" id="enquiry" data-bs-backdrop="static">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-body">
                    
                    <div class="d-md-flex flex-column justify-content-center align-items-center h-100">
                        <div class="w-100 d-block ">
                            <div class="container">
                                <div class="row align-items-center justify-content-center">
                                    <div class="col-md-6 col-lg-4">
                                        <div class="mb-5 mb-md-0">
                                            <h1 class="mb-3 h2" id="changable">Please share your details</h1>
                                            <div>
                                                <form method="post" action="#" id="enquiry_form_one">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" name="name" class="form-control" id="name" placeholder="" required>
                                                        <label for="name">Your Name <span class="text-danger">*</span></label>
                                                    </div>
        
                                                    <div class="form-floating mb-3">
                                                        <input type="tel" pattern="[6789][0-9]{9}" name="phone" class="form-control" id="phone" placeholder="" required>
                                                        <label for="phone">WhatsApp Number <small>(10 Digit)</small> <span class="text-danger">*</span></label>
                                                    </div>
        
                                                    <div class="form-floating mb-3">
                                                        <input type="email" name="email"  class="form-control" id="email" placeholder="" required>
                                                        <label for="email">Email ID <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div>
                                                        <input type="submit" id="submitform" class="btn btn-theme btn-lg me-3" value="Submit">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-center">
                                            <img src="{{ asset('assets/landing-page/enquiry-form.png') }}" style="width:100%;max-width:300px;">
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
  
    {{-- Modal Question 3 --}}
    <div class="modal" id="thankyou">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-body">

                    <div class="d-md-flex flex-column justify-content-center align-items-center h-100">
                        <div class="w-100 d-block ">
                            <div class="container">
                                <div class="row align-items-center justify-content-center">
                                    <div class="col-md-6 col-lg-6">
                                        <div class="my-5 my-md-0 text-center text-md-start">
                                            <h1 class="mb-1">Thank You!</h1>
                                            <p class="mb-5">Our executive will contact you as soon as possible.</p>
                                            <div class="mb-4">
                                            <div class="d-sm-flex">
                                                <div>
                                                    <a href="{{url('pricing')}}" class="btn btn-theme btn-lg py-3 px-5 me-2 mb-2">Buy Now</a> 
                                                </div>
                                                <div>
                                                    <p class="text-danger mb-0 fw-bold h4">50% OFF</p>
                                                    <p class="font-h1 small"><i>Limited period offer</i></p>

                                                </div>
                                            </div>
                                            </div>
                                            <div>
                                                <div class="mb-4"> 
                                                    <a href="tel:+917887882244" class="btn btn-dark me-2 mb-2">Call Now</a>
                                                    {{-- <a href="{{url('pricing')}}" class="btn btn-theme me-2 mb-2">Buy Now</a> --}}
                                                    <a href="{{url('')}}" class="btn btn-dark me-2 mb-2">Visit Website</a>

                                                    <button class="btn btn-outline-dark mb-2" onclick="replay();return false;"><i class="bi bi-play"></i> Replay</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-center">
                                            <img src="{{ asset('assets/landing-page/thankyou.png') }}" style="width:100%;max-width:175px;">
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
    <input type="hidden" id="firstAns" value="">
    <input type="hidden" id="secondAns" value="">
    <input type="hidden" id="thirdAns" value="">

    <input type="hidden" id="bobo_form_id" value="6">
    <input type="hidden" id="bobo_form_name" value="apilandingformhaspossendssms">
    <input type="hidden" id="bobo_form_message" value="1">

    <script src="{{ asset('assets/front/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script>
        // Modals set to variables
        var modal_one = new bootstrap.Modal(document.getElementById("que_1st"), {});
        var modal_two = new bootstrap.Modal(document.getElementById("que_2nd"), {});
        var modal_three = new bootstrap.Modal(document.getElementById("que_3rd"), {});
        var modal_enquiry = new bootstrap.Modal(document.getElementById("enquiry"), {});
        var modal_thank = new bootstrap.Modal(document.getElementById("thankyou"), {});

        var audio_background = new Audio("{{asset('assets/landing-page/audio/background-tune.wav')}}");
        var audio1 = new Audio("{{asset('assets/landing-page/audio/audio1.wav')}}");
        var audio2 = new Audio("{{asset('assets/landing-page/audio/audio2.wav')}}");
        var audio3 = new Audio("{{asset('assets/landing-page/audio/soft.wav')}}");
        // var audioE = new Audio("{{asset('assets/landing-page/audio/enquiry.wav')}}");
        var audioE = new Audio("{{asset('assets/landing-page/audio/enquiry-new.wav')}}");
        
        var dhanyawad = new Audio("{{asset('assets/landing-page/audio/dhnyawad.wav')}}");
        var offer = new Audio("{{asset('assets/landing-page/audio/thank-new.wav')}}");

        var audioT = dhanyawad;
    </script>
    <script>
       
        // get height and width of window
        var winWidth = $('#plyer_win').width();
        var setVidHeight =  (winWidth / 100) * 56.3;

        if ($(window).width() <= 575) {
            var id_video = 'aQBsAXw4iYA';
        }else{
            var id_video = 'cKVIXCNOUGI';
        }

        var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
  
        var YT_Player;
        function onYouTubeIframeAPIReady() {
            YT_Player = new YT.Player('player', {
                // width: winWidth,
                // height: setVidHeight,
                videoId: id_video,
                playerVars: {
                    // 'playsinline': 1,
                    rel:0,
                    controls: 0,
                    color: 'white',
                    cc_load_policy: 1,
                    modestbranding: 1,
                    showinfo:0,
                    autoplay:1,
                    mute:1,
                    fs:0,
                    disablekb:1,
                },
                events: {
                    'onReady': onPlayerReady,
                    'onStateChange': onPlayerStateChange
                }
            });
        }

        function pauseVideo() {
            YT_Player.pauseVideo();
        }
        function playVideo() {
            YT_Player.playVideo();
        }
        function stopVideo() {
            YT_Player.stopVideo();
        }

        $(document).ready(function(){
            $("#playnow").on("click", function(event){
                event.preventDefault();

                YT_Player.seekTo(0);
                playVideo();

                YT_Player.unMute();
                
                audio_background.play();
                // audio_background.volume = 0.5;
                
                $(this).hide();
            });
        });

        var done = false;
        function onPlayerStateChange(event) {
            // Do anything
        }

        function onPlayerReady(event) {
            playVideo();
            var interval = setInterval(function() {
                var seconds = YT_Player.getCurrentTime();
                // console.log(seconds);
                if(YT_Player.isMuted()){
                    if(seconds > 8.10 && seconds < 9.50){
                        YT_Player.seekTo(1.50);
                    }
                }

                if(YT_Player.getPlayerState() == 1 && YT_Player.isMuted() == false){
                    // 1st POPUP
                    if(seconds > 11.85 && seconds < 12.15){
                        pauseVideo();
                        modal_one.show();

                        setTimeout(() => {
                            if($('#que_1st').hasClass('show')){
                                audio1.play();
                            }
                        }, 3000);
                    }

                    // 2nd POPUP
                    if(seconds > 19.30 && seconds < 19.70){
                        pauseVideo();
                        modal_two.show();
                        setTimeout(() => {
                            if($('#que_2nd').hasClass('show')){
                                audio2.play();
                            }
                        }, 3000);
                    }

                    //Enquiry form
                    if(seconds > 42.02 && seconds < 42.32){
                        pauseVideo();
                        modal_enquiry.show();

                        setTimeout(() => {
                            if($('#enquiry').hasClass('show')){
                                audioE.play();
                            }
                        }, 3000);
                    }
                    if(seconds > 49.94 && seconds < 50.24){
                        stopVideo();
                        modal_thank.show();

                        setTimeout(() => {
                            if($('#thankyou').hasClass('show')){
                                audioT.play();
                            }
                        }, 3000);
                    }

                    if(seconds > 54.05 && seconds < 54.35){
                        pauseVideo();
                        modal_three.show();

                        setTimeout(() => {
                            if($('#que_3rd').hasClass('show')){
                                audio3.play();
                            }
                        }, 2000);
                    }

                    if(seconds > 62.70 && seconds < 63.10){
                        stopVideo();
                        modal_enquiry.show();

                        setTimeout(() => {
                            if($('#enquiry').hasClass('show')){
                                audioE.play();
                            }
                        }, 3000);
                    }

                }
            }, 200);
        }

        function replay(){
            $("#playnow").hide();
            modal_thank.hide();
            YT_Player.seekTo(0);
            playVideo();
            YT_Player.unMute();
            
            audio_background.play();
            // audio_background.volume = 0.5; 
        }

        // clickable functions
        function queOne(ans){
            if(ans === 'yes'){
                YT_Player.seekTo(12.65); 
            }else if(ans === 'no'){
                YT_Player.seekTo(60);
                $("#changable").html("No worry! We still have something special for you.");

                $("#bobo_form_id").val("4");
                $("#bobo_form_name").val("apilandingformnopos");

            }
            audio1.pause();
            $("#firstAns").val(ans);
            modal_one.hide();
            playVideo();
        }

        function queTwo(ans){
            if(ans === 'yes'){
                YT_Player.seekTo(20.50);
                $("#changable").html("Send WhatsApp messages from your Billing Software at @ just ₹1 per day.!");
                $("#submitform").val("Yes I'm Interested");

                audioT = offer;

            }else if (ans === 'no'){
                YT_Player.seekTo(50.80);
                $("#changable").html("Integrate & Start sending WhatsApp messages Now!");

                $("#bobo_form_id").val("5");
                $("#bobo_form_name").val("apilandingformhasposnosms");

            }

            $("#secondAns").val(ans);
            modal_two.hide();
            playVideo();
        }

        function queThree(){
            var input = $('#software_name');
            var in_parent = input.parent('.form-floating');
            input.next('span').remove();
            var ans = input.val();
            if(ans != ''){
                $("#thirdAns").val(ans);
                modal_three.hide();
                YT_Player.seekTo(60);
                playVideo();
                
            }else{
                in_parent.append('<span style="font-size:12px;" class="text-danger">Software name should not be empty!</span>');
            }
            audio3.pause();
        }

        function queThreeSkip(){
            audio3.pause();
            modal_three.hide();
            YT_Player.seekTo(60);
            playVideo();
        }

        $(document).ready(function(){
            $("#enquiry_form_one").on("submit", function(event){
                event.preventDefault();

                audioE.pause();

                modal_enquiry.hide();
                // YT_Player.seekTo(59.13);
                modal_thank.show();
                stopVideo();
                
                setTimeout(() => {
                    audioT.play();
                }, 1000);
                setTimeout(() => {
                    audio_background.pause();
                }, 8000);

                var firstAns    =   $('#firstAns').val();
                var secondAns   =   $('#secondAns').val();
                var thirdAns    =   $('#thirdAns').val();
                var name        =   $('#name').val();
                var phone       =   $('#phone').val();
                var email       =   $('#email').val();

                var boboFormId  =   $('#bobo_form_id').val();
                var boboFormName=   $('#bobo_form_name').val();
                var boboFormMsg =   $('#bobo_form_message').val();

                var boboApi = 'https://ol.salesrobo.com/form/submit?formId=' + boboFormId;

                $.ajax({
                    url: boboApi,
                    type: "post",
                    data: {
                        'mauticform[mail]': email,
                        'mauticform[mobile]': phone,
                        'mauticform[f_name]': name,
                        'mauticform[billing_software]': thirdAns,
                        'mauticform[formId]': boboFormId,
                        'mauticform[return]': '',
                        'mauticform[formName]': boboFormName,
                        'mauticform[messenger]': boboFormMsg,
                    },
                    success: function (data) {
                        console.log(data);
                    }
                });

                var _data_ = '{"Has POS": "'+firstAns+'", "Send SMS via POS": "'+secondAns+'", "Which POS": "'+thirdAns+'"}';
                $.ajax({
                    url: '{{route("lp2-save")}}',
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        name : name,
                        phone : phone,
                        email : email,
                        Jdata: _data_,
                        row: row
                    },
                    dataType: "json",
                    success: function (responce) {
                        // console.log(responce); 
                        if(responce.status){
                            $("form").trigger('reset');
                            $("input").val('');
                        }
                        window.location.href="{{ url('pricing') }}";
                    }
                });
                      
            })
        })
        
    </script>

</body>
</html>