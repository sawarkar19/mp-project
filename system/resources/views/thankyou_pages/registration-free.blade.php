<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">


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


    <title>ThankYou</title>
    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Bootstrap 5.2.0 -->
    <link rel="stylesheet" href="{{ asset('assets/website/vendor/bootstrap/css/bootstrap.min.css') }}">

    <!-- ICONS (Bootstrap) V1.5.0 -->
    <link rel="stylesheet" href="{{ asset('assets/website/vendor/bootstrap-icons/font/bootstrap-icons.css') }}">
        <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="{{ asset('assets/website/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/website/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/website/css/customs.css') }}">
    <style>
        .thankYou-main{
            background: #F1F8F8;
            min-height: 100vh;
        }
        .thankYou-inner{
            display: flex;
            flex-direction: column;
        }
        .thankYou-content{
           padding: 100px 0;
           min-height: 80vh;
           max-width: 850px;
        }
        .thankYou-content--icon {
            font-size: 60px;
        }
        .main-logo{
            width: 240px;
        }
        .thankYou-content--button .btn{
            font-size: 24px;
        }
        @media(max-width: 991px){
            
            .thankYou-content--button .btn{
                font-size: 14px ;
            }
        }    
    </style>
</head>
    <body>
        <section>
            <div class="py-2 thankYou-main">
                <div class="container">
                    <div class="thankYou-inner">
                        <div class="text-center">
                            <a href="{{url('/')}}"><img src="{{asset('assets/website/images/logos/logo-dark.svg')}}" alt="MouthPublicity" class="main-logo" id="mainLogo"> </a>
                        </div>
                        <div class="thankYou-content text-center flex-fill mx-auto"> 
                            <div class="">
                                <div class="thankYou-content--icon mb-2">
                                    <i class="bi bi-patch-check text-success"></i>
                                </div>
                                <h3 class="mb-2"><b>Congratulations</b>on signing up with MouthPublicity.io tool!</h3>
                                <h6> We are thrilled to have you onboard and can't wait to see you get started.</h6>
                            </div>
                            <div class="thankYou-content--button my-3 my-md-5 mx-auto">
                                <a href="{{ route('business.dashboard') }}" class="btn px-sm-5 px-4 py-2 btn-primary-ol">Launch Your Mouth Publicity Campaign Now</a>
                            </div>
                            <p>You should be automatically redirected in <span id="redirect-timmer"> 6</span> seconds.
                            </p>
                        </div>
                        <div></div>
                    </div>
                    
                    
                </div>
            </div>
            
        
        </section>
        <script>
            var seconds = 120; // seconds for HTML
            var foo; // variable for clearInterval() function
        
            function redirect() {
                document.location.href = '{{ route('business.dashboard') }}';
            }
        
            function updateSecs() {
                document.getElementById("redirect-timmer").innerHTML = seconds;
                seconds--;
                if (seconds == -1) {
                    clearInterval(foo);
                    redirect();
                }
            }
        
            function countdownTimer() {
                foo = setInterval(function () {
                    updateSecs()
                }, 1000);
            }
        
            countdownTimer();
        </script>
    </body>
</html>
