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

    <title>MouthPublicity.io - Mouth Publicity media</title>
    <meta name="title" content="MouthPublicity.io">
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
      
        .play_pause{
            color: #FFF;
            font-size: 1.3rem;
            display: block;
        }
        .play_pause i{
            line-height: 1;
        }


        .ol-modal.popin{
            -webkit-animation: popin 0.3s;
            animation: popin 0.3s;
        }
        @keyframes popin{
            0% {
                -webkit-transform: scale(0);
                -ms-transform: scale(0);
                transform: scale(0);
                opacity: 0;
            }
            100% {
                -webkit-transform: scale(1);
                -ms-transform: scale(1);
                transform: scale(1);
                opacity: 1;
            }
        }
        @-webkit-keyframes popin{
            0% {
                -webkit-transform: scale(0);
                -ms-transform: scale(0);
                transform: scale(0);
                opacity: 0;
            }
            100% {
                -webkit-transform: scale(1);
                -ms-transform: scale(1);
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>

    <script src="{{ asset('assets/front/vendor/jQuery/jQuery.min.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
</head>
<body>
    
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
    </section>
 
    <footer class="fixed-bottom bg-black p-3">
        <div class="row align-items-center justify-content-between">
            <div class="col-2 col-md-6 text-center">
                <a href="#" class="play_pause" id="_play_" data-bs-toggle="tooltip" title="Play Video" style="display: none;">
                    <i class="bi bi-play-circle-fill"></i>
                </a>
                <a href="#" class="play_pause" id="_pause_" data-bs-toggle="tooltip" title="Pause Video" style="display: none;">
                    <i class="bi bi-pause-circle-fill"></i>
                </a>
            </div>
            {{-- <div class="col-md-6 col-10 text-center">                  
                <a href="tel:+91 788 788 2244" class="btn btn-sm btn-theme py-1 me-3">Call Now</a>
                @auth
                    @php
                        $user_role = Auth::user()->role_id;
                        $url = '';
                        if($user_role == 2){
                            $url = url('/business/subscriptions/plans');
                        }
    
                        if($user_role == 1){
                            $url = url('/admin/dashboard');
                        }
    
                        if($user_role == 3){
                            $url = url('/employee/dashboard');
                        }
    
                        if($user_role == 4){
                            $url = url('/seo/dashboard');
                        }
    
                        if($user_role == 5){
                            $url = url('/account/dashboard');
                        }
    
                    @endphp
                    <a href="{{ $url }}" class="btn btn-theme btn-sm py-1">Buy Now</a>
                @else
                    <a href="{{url('pricing')}}" class="btn btn-theme btn-sm py-1">Buy Now</a>
                @endauth
            </div> --}}
        </div>  
          
    </footer>

    
  
    {{-- Modal Question 1 --}}
    <div class="modal ol-modal popin" id="ask_language" data-bs-backdrop="static" >
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-body">
                    
                    <div class="d-md-flex h-100 flex-coolumn align-items-center justify-content-center">
                        <div class="d-block">
                            <div class="container">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <div class="text-center text-md-start mb-5 mb-md-0">
                                            <h1 class="font-h1 h2 mb-5">Can you please select your preferred language?</h1>
                                            <div class="">
                                                <button type="button" class="btn btn-theme btn-lg me-3" onclick="language('English');">English</button>
                                                <button type="button" class="btn btn-theme btn-lg" onclick="language('Hindi');">Hindi</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-center">
                                            <div>
                                                <img src="{{ asset('assets/landing-page/pooja-04.png') }}" style="max-width: 150px;width:100%">
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
  
      
    {{-- Modal Question 2 --}}
    <div class="modal ol-modal popin" id="get_number" data-bs-backdrop="static">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-body">
                    
                    <div class="d-md-flex flex-column justify-content-center align-items-center h-100">
                        <div class="d-block w-100">
                            <div class="container">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <div class="mb-5 mb-md-0">
                                            <h1 class="mb-3 h2">Can you please share your Mobile/WhtasApp number?</h1>
                                            <div>
                                                <div class="form-floating mb-3">
                                                    <input type="tel" pattern="[6789][0-9]{9}" name="number" class="form-control" id="number" placeholder="Enter Number...">
                                                    <label for="software_name">Enter 10 Digit Number...</label>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <button type="button" class="btn btn-theme me-3 btn-lg" onclick="number_share();">Continue</button>
                                                    <button type="button" class="btn btn-link" onclick="number_skip();">Skip</button>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-center" id="illu-number">
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



    <div class="modal ol-modal popin" id="have_pos_eng" data-bs-backdrop="static">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-body">

                    <div class="d-md-flex flex-column justify-content-center align-items-center h-100">
                        <div class="d-block w-100">
                            <div class="container">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <div class="mb-5 mb-md-0 text-center text-md-start">
                                            <h1 class="mb-5 h2">Do you have POS system at your billing counter?</h1>
                                            <div class="">
                                                <button type="button" class="btn btn-theme btn-lg" onclick="have_pos_eng_ans('Yes');">Yes</button>
                                                <button type="button" class="btn btn-theme btn-lg ms-3" onclick="have_pos_eng_ans('No');">No</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-center" id="illu-pos">
                                            <img src="{{ asset('assets/landing-page/pooja-03.png') }}" style="width:100%;max-width:190px;" >
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


    <div class="modal ol-modal popin" id="topics_eng" data-bs-backdrop="static">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-body">

                    <div class="d-md-flex flex-column justify-content-center align-items-center h-100">
                        <div class="d-block w-100">
                            <div class="container">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <div class="mb-5 mb-md-0 text-center text-md-start">
                                            <h1 class=" h2">Which one of the following do you wish to listen to first?</h1>
                                            <h4 class="mb-5">Please select your preference.</h4>
                                            <div class="">
                                                <button type="button" class="btn btn-outline-dark me-3 mb-2" onclick="topics_eng_sct('2', 'Gaining customer trust naturally & fast');">Gaining customer trust naturally & fast</button>
                                                <button type="button" class="btn btn-outline-dark me-3 mb-2" onclick="topics_eng_sct('3', 'Get your customers to actively market your business');">Get your customers to actively market your business</button>
                                                <button type="button" class="btn btn-outline-dark me-3 mb-2" onclick="topics_eng_sct('1', 'Marketing challenge to target people in your own locality');">Marketing challenge to target people in your own locality</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-center">
                                            <img src="{{ asset('assets/landing-page/pooja-03.png') }}" style="width:100%;max-width:170px;" >
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

    <div class="modal ol-modal popin" id="more_topics_eng" data-bs-backdrop="static">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-body">

                    <div class="d-md-flex flex-column justify-content-center align-items-center h-100">
                        <div class="d-block w-100">
                            <div class="container">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <div class="mb-5 mb-md-0 text-center text-md-start">
                                            <h1 class="mb-5 h3">Know more about how you can solve marketing challenges for your business effectively with MouthPublicity.io?</h1>
                                            <div class="mb-3">
                                                <button type="button" class="btn btn-outline-dark me-3 mb-2" id="topic2" onclick="topics_eng_sct('2', 'Gaining customer trust naturally & fast');">Gaining customer trust naturally & fast</button>
                                                <button type="button" class="btn btn-outline-dark me-3 mb-2" id="topic3" onclick="topics_eng_sct('3', 'Get your customers to actively market your business');">Get your customers to actively market your business</button>
                                                <button type="button" class="btn btn-outline-dark me-3 mb-2" id="topic1" onclick="topics_eng_sct('1', 'Marketing challenge to target people in your own locality');">Marketing challenge to target people in your own locality</button>
                                            </div>
                                            <div>
                                                <button type="button" class="btn btn-primary px-3" id="" onclick="topics_eng_sct('continue');">No, Continue</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-center">
                                            <img src="{{ asset('assets/landing-page/pooja-03.png') }}" style="width:100%;max-width:170px;" >
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


    <div class="modal ol-modal popin" id="topics_hin" data-bs-backdrop="static">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-body">

                    <div class="d-md-flex flex-column justify-content-center align-items-center h-100">
                        <div class="d-block w-100">
                            <div class="container">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <div class="mb-5 mb-md-0 text-center text-md-start">
                                            <h1 class="h2">Which one of the following do you wish to listen to first?</h1>
                                            <h4 class="mb-5">Please select your preference.</h4>
                                            <div class="">
                                                <button type="button" class="btn btn-outline-dark me-3 mb-2" onclick="topics_hin_sct('2', 'Gaining customer trust naturally & fast');">Gaining customer trust naturally & fast</button>
                                                <button type="button" class="btn btn-outline-dark me-3 mb-2" onclick="topics_hin_sct('3', 'Get your customers to actively market your business');">Get your customers to actively market your business</button>
                                                <button type="button" class="btn btn-outline-dark me-3 mb-2" onclick="topics_hin_sct('1', 'Marketing challenge to target people in your own locality');">Marketing challenge to target people in your own locality</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-center">
                                            <img src="{{ asset('assets/landing-page/first.png') }}" style="width:100%;max-width:300px;" >
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

    <div class="modal ol-modal popin" id="more_topics_hin" data-bs-backdrop="static">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-body">

                    <div class="d-md-flex flex-column justify-content-center align-items-center h-100">
                        <div class="d-block w-100">
                            <div class="container">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <div class="mb-5 mb-md-0 text-center text-md-start">
                                            <h1 class="mb-5 h3">Know more about how you can solve marketing challenges for your business effectively with MouthPublicity.io?</h1>
                                            <div class="mb-3">
                                                <button type="button" class="btn btn-outline-dark me-3 mb-2" id="topic_hin2" onclick="topics_hin_sct('2', 'Gaining customer trust naturally & fast');">Gaining customer trust naturally & fast</button>
                                                <button type="button" class="btn btn-outline-dark me-3 mb-2" id="topic_hin3" onclick="topics_hin_sct('3', 'Get your customers to actively market your business');">Get your customers to actively market your business</button>
                                                <button type="button" class="btn btn-outline-dark me-3 mb-2" id="topic_hin1" onclick="topics_hin_sct('1', 'Marketing challenge to target people in your own locality');">Marketing challenge to target people in your own locality</button>
                                            </div>
                                            <div>
                                                <button type="button" class="btn btn-primary px-3" id="" onclick="topics_hin_sct('continue');">No, Continue</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-center">
                                            <img src="{{ asset('assets/landing-page/first.png') }}" style="width:100%;max-width:300px;" >
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
    <div class="modal ol-modal popin" id="enquiry" data-bs-backdrop="static">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-body">
                    
                    <div class="d-md-flex flex-column justify-content-center align-items-center h-100">
                        <div class="w-100 d-block ">
                            <div class="container">
                                <div class="row align-items-center justify-content-center">
                                    <div class="col-md-6 col-lg-5">
                                        <div class="mb-5 mb-md-0">
                                            <h1 class="h2">Acquire new customers,<br>Get more sales!!</h1>
                                            <h1 class="mb-3 h5">Create the first campaign for your business now.</h1>
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
                                                    <div id="error_msg"></div>
                                                    <div>
                                                        <input type="submit" id="submitform" class="btn btn-theme btn-lg me-3" value="Submit">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-center" id="illu-enquiry">
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
    <div class="modal ol-modal popin" id="thankyou">
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
                                            <p class="mb-5">Thanks for sharing your details with us, We'll get back to you soon.</p>
                                            <div class="mb-4">
                                            <div class="d-sm-flex">
                                                <div>

                                                    @auth
                                                        @php
                                                            $user_role = Auth::user()->role_id;
                                                            $url = '';
                                                            if($user_role == 2){
                                                                $url = url('/business/subscriptions/plans');
                                                            }

                                                            if($user_role == 1){
                                                                $url = url('/admin/dashboard');
                                                            }

                                                            if($user_role == 3){
                                                                $url = url('/employee/dashboard');
                                                            }

                                                            if($user_role == 4){
                                                                $url = url('/seo/dashboard');
                                                            }

                                                            if($user_role == 5){
                                                                $url = url('/account/dashboard');
                                                            }
                                                        @endphp

                                                        <a href="{{ $url }}" class="btn btn-theme btn-lg py-3 px-5 me-2 mb-2">Buy Now</a>
                                                        
                                                    @else
                                                        <a href="{{url('pricing')}}" class="btn btn-theme btn-lg py-3 px-5 me-2 mb-2">Buy Now</a>
                                                    @endauth
                                                     
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



    <input type="hidden" id="languageIN" value="">
    <input type="hidden" id="numberIN" value="">
    <input type="hidden" id="have_pos_engIN" value="">
    {{-- <input type="hidden" id="topicsIN" value="Gaining customer trust naturally & fast, Get your customers to actively market your business"> --}}
    <input type="hidden" id="topicsIN" value="">
    <input type="hidden" id="ifNumSaveID" value="">
    

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.6.0/umd/popper.min.js"></script>
    <script src="{{ asset('assets/front/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script>
        // Modals set to variables
        var ask_language = new bootstrap.Modal(document.getElementById("ask_language"), {});
        var get_number = new bootstrap.Modal(document.getElementById("get_number"), {});
        var have_pos_eng = new bootstrap.Modal(document.getElementById("have_pos_eng"), {});
        var topics_eng = new bootstrap.Modal(document.getElementById("topics_eng"), {});
        var more_topics_eng = new bootstrap.Modal(document.getElementById("more_topics_eng"), {});

        var topics_hin = new bootstrap.Modal(document.getElementById("topics_hin"), {});
        var more_topics_hin = new bootstrap.Modal(document.getElementById("more_topics_hin"), {});

        var enquiry = new bootstrap.Modal(document.getElementById("enquiry"), {});
        var modal_thank = new bootstrap.Modal(document.getElementById("thankyou"), {});

        // Audios 
        var audio_background = new Audio("{{asset('assets/landing-page/audio/background-tune.wav')}}");
        
        // enquiry.show();
    </script>
 
    <script>
        $(document).ready(function(){
            $("#_play_").on("click", function(){
                $(this).hide();
                playVideo();
                audio_background.play();
                $("#_pause_").show();
            });

            $("#_pause_").on("click", function(){
                $(this).hide();
                pauseVideo();
                audio_background.pause();
                $("#_play_").show();
            });
        });    
    </script>

    <script>
       
        // get height and width of window
        var winWidth = $('#plyer_win').width();
        var setVidHeight =  (winWidth / 100) * 56.3;
        //NVlN6xDJ920
        if ($(window).width() <= 575) {
            var id_video = 'uwrqe5t_C5k';
        }else{
            var id_video = 'uwrqe5t_C5k';
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
                    'enablejsapi': 1,
                    'playsinline': 1,
                    'showsearch': 0,
                    'rel':0,
                    'controls': 0,
                    'cc_load_policy': 1,
                    'modestbranding': 1,
                    'showinfo':0,
                    'autoplay':1,
                    'mute':1,
                    'fs':0,
                    'disablekb':1,
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

        // Play Button
        $(document).ready(function(){
            $("#playnow").on("click", function(event){
                event.preventDefault();
                YT_Player.seekTo(0);
                playVideo();
                YT_Player.unMute();
                audio_background.play();
                audio_background.volume = 0.3;
                audio_background.loop = true;
                $(this).hide();

                // more_topics_eng.show();

                $("#_play_").hide();
                $("#_pause_").show();
            });
        });

        // Replay Button
        function replay(){
            $("#playnow").hide();
            modal_thank.hide();
            YT_Player.seekTo(0);
            playVideo();
            YT_Player.unMute();
            audio_background.play();
            audio_background.volume = 0.3;
            audio_background.loop = true;

            $("#_play_").hide();
            $("#_pause_").show();
        }

        var done = false;
        function onPlayerStateChange(event) {
            // Do anything
            // console.log(event);
        }

        function onPlayerReady(event) {
            playVideo();

            var interval = setInterval(function() {
                var seconds = YT_Player.getCurrentTime();
                // console.log(seconds);
                if(YT_Player.isMuted()){
                    if(seconds > 7 && seconds < 11){
                        YT_Player.seekTo(1.50);
                    }
                }

                if(YT_Player.getPlayerState() == 1 && YT_Player.isMuted() == false){
                    
                    // Ask Language
                    if(seconds > 11.85 && seconds < 12.15 ){
                        pauseVideo();
                        ask_language.show();
                    }

                    // Start English
                    if(seconds > 19.90 && seconds < 21.20){
                        pauseVideo();
                        get_number.show();
                    }
                    if(seconds > 31.60 && seconds < 31.90){
                        pauseVideo();
                        have_pos_eng.show();
                    }
                    if(seconds > 62.10 && seconds < 62.40){
                        pauseVideo();
                        topics_eng.show();
                    }
                    if(seconds > 85.90 && seconds < 86.25){
                        pauseVideo();
                        more_topics_eng.show();
                    }
                    if(seconds > 122.40 && seconds < 122.80){
                        pauseVideo();
                        more_topics_eng.show();
                    }
                    if(seconds > 146.95 && seconds < 147.25){
                        pauseVideo();
                        more_topics_eng.show();
                    }
                    if(seconds > 188 && seconds < 188.30){
                        pauseVideo();
                        enquiry.show();
                    }
                    // End English


                    // Start Hindi
                    if(seconds > 196.90 && seconds < 197.20){
                        pauseVideo();
                        get_number.show();
                    }
                    if(seconds > 215.10 && seconds < 215.42){
                        pauseVideo();
                        topics_hin.show();
                    }
                    if(seconds > 259.90 && seconds < 260.20){
                        pauseVideo();
                        more_topics_hin.show();
                    }
                    if(seconds > 286.90 && seconds < 287.20){
                        pauseVideo();
                        more_topics_hin.show();
                    }
                    if(seconds > 315.85 && seconds < 316.15){
                        pauseVideo();
                        more_topics_hin.show();
                    }
                    if(seconds > 353 && seconds < 353.40){
                        pauseVideo();
                        enquiry.show();
                    }
                    // End Hindi


                }
            }, 200);
        }


        // clickable functions
        function language(ans){
            if(ans === 'English'){
                YT_Player.seekTo(12.50);

                $("#illu-number").html('<img src="{{ asset('assets/landing-page/pooja-02.png') }}" style="width: 100%;max-width:150px;">');
                $("#illu-pos").html('<img src="{{ asset('assets/landing-page/pooja-03.png') }}" style="width:100%;max-width:190px;" >');
                $("#illu-enquiry").html('<img src="{{ asset('assets/landing-page/pooja-02.png') }}" style="width:100%;max-width:170px;">');
                
            }
            else if(ans === 'Hindi'){
                YT_Player.seekTo(188.70);
                
                $("#illu-number").html('<img src="{{ asset('assets/landing-page/second.png') }}" style="width: 100%;max-width:150px;">');
                $("#illu-pos").html('<img src="{{ asset('assets/landing-page/first.png') }}" style="width:100%;max-width:300px;" >');
                $("#illu-enquiry").html('<img src="{{ asset('assets/landing-page/enquiry-form.png') }}" style="width:100%;max-width:300px;">');
            }
            $("#languageIN").val(ans);
            ask_language.hide();
            playVideo();
        }

        function number_share(){
            var input = $('#number');
            var in_parent = input.parent('.form-floating');

            input.siblings('span').remove();

            var ans = input.val();
            if(ans.match('[6789][0-9]{9}')){
                $("#numberIN").val(ans);
                $("#phone").val(ans);


                $.ajax({
                    url: '{{route("lp2-save-number")}}',
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "number": ans
                    },
                    dataType: "json",
                    success: function (responce) {
                        // console.log(responce);
                        if(responce.status){
                            $("#ifNumSaveID").val(responce.row_id);
                        }
                    }
                });

                get_number.hide();

                if($("#languageIN").val() === 'Hindi'){
                    have_pos_eng.show();
                }
                else{
                    YT_Player.seekTo(26.30);
                    playVideo();
                }
            }else{
                in_parent.append('<span style="font-size:12px;" class="text-danger">Number should be numeric and in 10 digit!</span>');
            }
        }

        function number_skip(){
            get_number.hide();
            if($("#languageIN").val() === 'Hindi'){
                have_pos_eng.show();
            }
            else{
                YT_Player.seekTo(26.30);
                playVideo();
            }
        }

        function have_pos_eng_ans(ans){

            $("#have_pos_engIN").val(ans);
            have_pos_eng.hide();
            if(ans === 'Yes'){
                if($("#languageIN").val() === 'Hindi'){
                    YT_Player.seekTo(200.80);
                }else{
                    YT_Player.seekTo(32.40);
                }
                playVideo();
            }else if (ans === 'No'){
                
                enquiry.show();
                // if($("#languageIN").val() === 'Hindi'){
                //     YT_Player.seekTo(0);
                // }else{
                //     YT_Player.seekTo(0);
                // }
            }
            
            
        }


        function topics_eng_sct(ans, tpname){

            if (ans === 'continue') {
                YT_Player.seekTo(147.75);
                more_topics_eng.hide();
                playVideo();

                return false;
            }

            if(ans === '1'){
                YT_Player.seekTo(62.70);
            }
            else if(ans === '2'){
                YT_Player.seekTo(86.75);
            }
            else if(ans === '3'){
                YT_Player.seekTo(122.85);
            }
            
            $("#topic" + ans).hide();

            if(ans != ''){
                var topic_name = tpname;
                var topic_val = $("#topicsIN").val();
                if(topic_val != ''){
                    topic_name = topic_val + ', ' + tpname;
                }
                $("#topicsIN").val(topic_name);

                topics_eng.hide();
                more_topics_eng.hide();
                playVideo();
            }
        }

        function topics_hin_sct(ans, tpname){

            if (ans === 'continue') {
                YT_Player.seekTo(317.70);
                more_topics_hin.hide();
                playVideo();
                return false;
            }

            if(ans === '1'){
                YT_Player.seekTo(215.90);
            }
            else if(ans === '2'){
                YT_Player.seekTo(260.70);
            }
            else if(ans === '3'){
                YT_Player.seekTo(287.70);
            }

            $("#topic_hin" + ans).hide();

            if(ans != ''){
                var topic_name = tpname;
                var topic_val = $("#topicsIN").val();
                if(topic_val != ''){
                    topic_name = topic_val + ', ' + tpname;
                }
                $("#topicsIN").val(topic_name);

                topics_hin.hide();
                more_topics_hin.hide();
                playVideo();
            }
        }

        $(document).ready(function(){
            $("#enquiry_form_one").on("submit", function(event){
                event.preventDefault();

                $("#error_msg").html('');

                var go = true;
                var msg = '';

                var name   = $('#name').val();
                var phone  = $('#phone').val();
                var email  = $('#email').val();

                if(name == ''){
                    go = false;
                    msg = '<span class="d-block mb-2 text-danger">Name shoulde not be empty!</span>' + msg;
                }
                if(email == ''){
                    go = false;
                    msg = '<span class="d-block mb-2 text-danger">Email ID shoulde not be empty!</span>' + msg;
                }

                if(!phone.match('[6789][0-9]{9}')){
                    go = false;
                    msg = '<span class="d-block mb-2 text-danger">WhatsApp/Mobile number sholde be 10 digit numeric!</span>' + msg;
                }

                if(go){
                    enquiry.hide();
                    YT_Player.seekTo(00);
                    modal_thank.show(); 
                    stopVideo();
                    
                    setTimeout(() => {
                        audio_background.pause();
                    }, 8000);

                    var _data_ = '{"language": "'+$("#languageIN").val()+'", "POS": "'+$("#have_pos_engIN").val()+'", "Topics": "'+$("#topicsIN").val()+'"}';
                    var row = $("#ifNumSaveID").val();
                    
                    var language = $('#languageIN').val();
                    var has_pos = $('#have_pos_engIN').val();

                    var topic_val = $("#topicsIN").val().split(", ");

                    var data = {
                        'mauticform[preferred_language1]': language,
                        'mauticform[whatsapp_no]': phone,
                        'mauticform[has_pos_or_billing_softwa]': has_pos,
                        'mauticform[topics_listened]' : topic_val,
                        'mauticform[f_name]': name,
                        'mauticform[email]': email,
                        'mauticform[formId]': 7,
                        'mauticform[return]': '',
                        'mauticform[formName]': 'wpmlandingform',
                        'mauticform[messenger]': 1,
                        'mauticform[submit]' : '',
                    };
                    var boboApi = 'https://ol.salesrobo.com/form/submit?formId=7';
                    $.ajax({
                        url: boboApi,
                        type: "post",
                        data: data,
                        success: function (data) {
                            console.log(data);
                        },
                    });
                    

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
                            if(has_pos == 'Yes'){
                                window.location.href="{{ url('pricing') }}";
                            }
                        }
                    });
                }else{
                    $("#error_msg").html(msg);
                }
            })
        })
        
    </script>

    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>

</body>
</html>