<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
   <!--  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css"> -->
    
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
            background-color: rgb(0,0,0, 0.5);
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
    </style>
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

        <div id="loader" style="display: none;">
            <div class="spinner-border text-dark" style="width: 3rem; height: 3rem;" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </section>

    <footer class="fixed-bottom bg-black p-3">
        <div class="float-end">                  
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
                        $url = url('/seo/seo');
                    }

                    if($user_role == 5){
                        $url = url('/account/dashboard');
                    }

                @endphp

                <a href="{{ $url }}" class="btn btn-theme btn-sm py-1">Buy Now</a>
                
            @else
                <a href="{{url('pricing')}}" class="btn btn-theme btn-sm py-1">Buy Now</a>
            @endauth
        </div>    
    </footer>

    {{-- Modal Question 1 --}}
    <div class="modal" id="que_1st" data-bs-backdrop="static" >
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-body">
                   
                    <div class="d-flex h-100 flex-coolumn align-items-center justify-content-center">
                        <div class="d-block">
                            <div class="container">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <div class="text-center text-md-start mb-5 mb-md-0">
                                            <h1 class="font-h1 h2 mb-5">Do you have a POS / Billing software for you business?</h1>
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

                    <div class="d-flex flex-column justify-content-center align-items-center h-100">
                        <div class="d-block w-100">
                            <div class="container">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <div class="mb-5 mb-md-0 text-center text-md-start">
                                            <h1 class="mb-5 h2">Do you send SMS / WhatsApp via POS Software?</h1>
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
                     
                    <div class="d-flex flex-column justify-content-center align-items-center h-100">
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
                    
                    <div class="d-flex flex-column justify-content-center align-items-center h-100">
                        <div class="w-100 d-block ">
                            <div class="container">
                                <div class="row align-items-center justify-content-center">
                                    <div class="col-md-6 col-lg-4">
                                        <div class="mb-5 mb-md-0">
                                            <h1 class="mb-3 h2">Please share your details</h1>
                                            <div>
                                                <form method="post" action="#" id="enquiry_form_one">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" name="name" class="form-control" id="name" placeholder="" required>
                                                        <label for="name">Your Name <span class="text-danger">*</span></label>
                                                    </div>
        
                                                    <div class="form-floating mb-3">
                                                        <input type="tel" pattern="[6789][0-9]{9}" name="phone" class="form-control" id="phone" placeholder="John Doe" required>
                                                        <label for="phone">Your Mobile Number <small>(10 Digit)</small> <span class="text-danger">*</span></label>
                                                    </div>
        
                                                    <div class="form-floating mb-3">
                                                        <input type="email" name="email"  class="form-control" id="email" placeholder="John Doe" required>
                                                        <label for="email">Your Email ID <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div>
                                                        <input type="submit" class="btn btn-theme btn-lg me-3" value="Submit">
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
                                    <div class="col-md-6 col-lg-5">
                                        <div class="my-5 my-md-0 text-center text-md-start">
                                            <h1 class="mb-1">Thank You!</h1>
                                            <p class="mb-5">Our executive will contact you as soon as possible.</p>
                                            <div>
                                                <div class="mb-4"> 
                                                    <a href="tel:+917887882244" class="btn btn-theme me-2 mb-2">Call Now</a>

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
                                                                $url = url('/seo/seo');
                                                            }

                                                            if($user_role == 5){
                                                                $url = url('/account/dashboard');
                                                            }

                                                        @endphp

                                                        <a href="{{ $url }}" class="btn btn-theme me-2 mb-2">Buy Now</a>

                                                    @else
                                                        <a href="{{url('pricing')}}" class="btn btn-theme me-2 mb-2">Buy Now</a>
                                                    @endauth

                                                    
                                                    <a href="{{url('/')}}" class="btn btn-theme me-2 mb-2">Visit Website</a>
                                                </div>
                                                <div>
                                                    <button class="btn btn-outline-dark" onclick="replay();return false;"><i class="bi bi-play"></i> Replay</button>
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


    <script src="{{ asset('assets/front/vendor/jQuery/jQuery.min.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
    <script src="https://player.vimeo.com/api/player.js"></script>

    <script src="{{ asset('assets/front/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script> -->

    <script>
        // Modals set to variables
        var modal_one = new bootstrap.Modal(document.getElementById("que_1st"), {});
        var modal_two = new bootstrap.Modal(document.getElementById("que_2nd"), {});
        var modal_three = new bootstrap.Modal(document.getElementById("que_3rd"), {});
        var modal_enquiry = new bootstrap.Modal(document.getElementById("enquiry"), {});
        var modal_thank = new bootstrap.Modal(document.getElementById("thankyou"), {});
    </script>
    <script>

        // get height and width of window
        var winWidth = $('#plyer_win').width();
        var setVidHeight =  (winWidth / 100) * 56.3;

        if ($(window).width() <= 575) {
            var id_video = '684531063';
        }else{
            var id_video = '684159573';
        }

        var video = {
            id: id_video, 
            width:winWidth,
            controls:false, 
            keyboard: 0  
        };

        var player = new Vimeo.Player(document.querySelector('#plyer_win'));
        
        $(document).ready(function(){
            $("#playnow").on("click", function(event){
                event.preventDefault();
                VimeoPlayer.play();
                $(this).hide();
            });
        });

        var buffStart = function(data){
            $("#loader").show();
        }
        var buffEnd = function(data){
            $("#loader").hide();
        }

        // alert(player); return false;
        var VimeoPlayer = new Vimeo.Player('player', video);

        VimeoPlayer.setVolume(1);

        VimeoPlayer.on('play', function() {

            var interval = setInterval(() => {
                VimeoPlayer.getCurrentTime().then(function(seconds) {
                    console.log('CT:'+seconds);

                    // 1st POP (POS System)
                    // 0:12:17 
                    if(seconds > 12.10 && seconds < 12.40){
                        VimeoPlayer.pause().then(function() {
                            modal_one.show();
                        })
                    }
                    // 0:12:17
                    // 1st POP (POS System)

                    // 2st POP (POS System)
                    if(seconds > 20.05 && seconds < 20.35){
                        VimeoPlayer.pause().then(function() {
                            modal_two.show();
                        })
                    }
                    // 2st POP (POS System)

                    // 3rd POP (Enquiry Form)
                    if(seconds > 43.10 && seconds < 43.40){
                        VimeoPlayer.pause().then(function() {
                            modal_enquiry.show();
                        })
                    }
                    // 3rd POP (Enquiry Form)

                    // story end
                    if(seconds > 55.80 && seconds < 56.10){
                        VimeoPlayer.pause().then(function() {
                            VimeoPlayer.setCurrentTime(0);
                            modal_thank.show();
                        })
                    }

                    // 3rd POP (POS System)
                    if(seconds > 60.05 && seconds < 60.35){
                        VimeoPlayer.pause().then(function() {
                            modal_three.show();
                        })
                    }
                    // 3rd POP (POS System)
                    

                    if(seconds > 69.85 && seconds < 70.05){
                        VimeoPlayer.pause().then(function() {
                            VimeoPlayer.setCurrentTime(0);
                        })
                    }

                    // (Enquiry Form)
                    if(seconds > 73.10 && seconds < 73.30){
                        VimeoPlayer.pause().then(function() {
                            modal_enquiry.show();
                        })
                    }
                    // (Enquiry Form)
                    
                });
            }, 250);

        });

        VimeoPlayer.on('bufferstart', buffStart);
        VimeoPlayer.on('bufferend', buffEnd);

        function pauseVideo() {
            VimeoPlayer.pause();
        }
        function playVideo() {
            VimeoPlayer.play();
        }
        function stopVideo() {
            VimeoPlayer.stop();
        }

        function replay(){
            $("#playnow").hide();
            modal_thank.hide();
            VimeoPlayer.setCurrentTime(0);
            playVideo();
        }


        // clickable functions
        function queOne(ans){
            if(ans === 'yes'){
                VimeoPlayer.setCurrentTime(13);
            }else if(ans === 'no'){
                VimeoPlayer.setCurrentTime(70.05)
            }
            $("#firstAns").val(ans);
            modal_one.hide();
            playVideo();
        }

        function queTwo(ans){
            if(ans === 'yes'){
                VimeoPlayer.setCurrentTime(20.40);
            }else if (ans === 'no'){
                VimeoPlayer.setCurrentTime(56.11);
            }
            $("#secondAns").val(ans);
            modal_two.hide();
            playVideo();
        }

        function queThree(){
            var input = $('#software_name');
            var in_parent = input.parent('.form-group');
            input.next('span').remove();
            var ans = input.val();
            if(ans != ''){
                $("#thirdAns").val(ans);
                modal_three.hide();
                VimeoPlayer.setCurrentTime(70.05);
                playVideo();
            }else{
                in_parent.append('<span style="font-size:12px;" class="text-danger">Software name should not be empty!</span>');
            }
        }

        function queThreeSkip(){
            modal_three.hide();
            VimeoPlayer.setCurrentTime(70.05);
            playVideo();
        }

        $(document).ready(function(){
            $("#enquiry_form_one").on("submit", function(event){
                event.preventDefault();

                modal_enquiry.hide();
                VimeoPlayer.setCurrentTime(43.41);
                playVideo();

                var firstAns    =   $('#firstAns').val();
                var secondAns   =   $('#secondAns').val();
                var thirdAns    =   $('#thirdAns').val();
                var name        =   $('#name').val();
                var phone       =   $('#phone').val();
                var email       =   $('#email').val();
                    
                $.ajax({
                    url: '{{route("lp-save")}}',
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        firstAns : firstAns,
                        secondAns : secondAns,
                        thirdAns : thirdAns,
                        name : name,
                        phone : phone,
                        email : email,
                    },
                    dataType: "json",
                    success: function (data) {
                        console.log(data);
                    },
                    error: function (error) {
                        console.log(`Error ${error}`);
                    }
                });                
            })
        })
        
    </script>

</body>
</html>