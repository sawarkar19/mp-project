@extends('layouts.front')

@section('title', $seo->title)
@section('description', $seo->description)
{{-- @section('keywords', $seo->keywords) --}}
@section('image', $seo->image_path)

@section('end_head')
<style>

    #new-banner{
        position: relative;
        background-color: #000000;
    }
    .content-ban{
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        z-index: 9;
    }
    .mockup{
        position: relative;
        overflow: hidden;
        min-height: 720px;
    }
    .mockup::after{
        content: "";
        position: absolute;
        top: 0;
        left: 50%;
        width: 50%;
        height: calc(100% + 2px);
        overflow: hidden;
        z-index: 1;
        background-position: left center;
        background-size: auto 110%;
        background-repeat: no-repeat;
        background-image: url({{asset('assets/front/images/mockups/land.png')}});
    }
    
    .rocket{
        position: absolute;
        width: 70px;
        z-index: -1;
        animation: rocket 15s Linear infinite;
        -webkit-animation: rocket 15s Linear infinite;
    }
    @keyframes rocket{
        0%{
            top: 300px;
            left:-60px;
            opacity: 1;
        }
        95%{
            /* top: 0px;
            left:400px; */
            opacity: 1;
        }
        100%{
            top: 0px;
            left:400px;
            opacity: 0;
        }
    }
    @-webkit-keyframes rocket{
        0%{
            top: 300px;
            left:-60px;
            opacity: 1;
        }
        95%{
            /* top: 0px;
            left:400px; */
            opacity: 1;
        }
        100%{
            top: 0px;
            left:400px;
            opacity: 0;
        }
    }

    

    .splashes.dots-between-left-right{
        content: url('assets/front/images/dots.svg');
        /*transform: rotate(136deg); */
        left: 300px;
        bottom:90%;
        width: 80px;
        height: 80px;
        opacity: 1.5;
        /*background-color: red;*/
    }

    .boost-card{
        background-color: #f0f0f0;
        border-radius: 15px;
        padding: 25px 20px;
    }
    
    .card-2-img{
        max-width: 300px;
    }
    .diagonal-line-1{
        position: relative;
    }
    .diagonal-line-1::before{
        content: '';
        border-bottom: 1px solid #e8e8e8;
        width: 360px;
        position: absolute;
        left: 72%;
        transform: rotate(207deg);
        margin: 10px;
        top: 42px;
    }
        
    .diagonal-line-2{
        position: relative;
    }
    .diagonal-line-2::after{
        content: '';
        border-bottom: 1px solid #e8e8e8;
        width: 360px;
        position: relative;
        right: 23%;
        transform: rotate(144deg);
        margin: 10px;
        bottom: -108px;
        display: inline-block;
    }

    .card-base > .card-icon {
        position: relative;
    }

    .imagecard { 
        z-index: 2;
        display: block;
        position: relative;
        top: 20px;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        border: 5px solid white;
        box-shadow: 1px 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
        margin: 0 auto;
        text-align: center;
        color: black;

    }
    .card-base > .card-icon > .card-data {
        min-height: 250px !important;
        margin-top: -24px;
        color: #fff;
        padding: 15px 0 10px 0;
        box-shadow: 1px 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
        min-height: 215px;
        text-align: center !important;
        border-radius: 10px;
    }
    #widgetCardIcon {
        background: #fff;
        font-size: 28px;
        line-height: 78px;
    }

    #analytics_spoiler .spoiler_data{
        font-size: 60px;
        margin-bottom: 0px;
    }
    #analytics_spoiler .spoiler_text{
        margin-bottom: 0px;
    }
    
    @media(min-width:992px){
        .boost-card.fx-size{
            max-width: 22rem;
            margin: auto;
        }
		.home-logo{
            position: relative;
            width: 100%;
        }
        .logo-flt img.main_logo{
            position: absolute;
            top: 0;
            left: 0;
        }
    }

    @media (max-width: 991px){
        #analytics_spoiler .spoiler_data{
            font-size:40px;
        }
        #analytics_spoiler .spoiler_text{
            line-height: 1.2;
            font-size: 1rem;
        }

        .content-ban{
            position: relative;
            display: block;
            flex-direction: none;
            justify-content: none;
        }
        .mockup{
            min-height: 1px;
            padding-bottom: 65%;
            background-color: #FFF;
        }
        .mockup::after{
            left: 0;
            width: 100%;
            overflow: visible;
            background-position: center top;
            background-size: contain;
            background-image: url({{asset('assets/front/images/mockups/port.png')}});
        }
        .mockup::before{
            content: "";
            position: absolute;
            top: -2px;
            left: 0;
            width: 100%;
            height: 60%;
            background-color: #000000;
            z-index: 1;
        }
    }
    @media (max-width:767px){
        #analytics_spoiler .spoiler_data{
            font-size:30px;
            width: 45%;
        }
        #analytics_spoiler .spoiler_text{
            width: 55%;
            padding: 10px;
        }
        #analytics_spoiler .spoiler_text br{
            display: none;
        }

        @keyframes rocket{
            0%{
                top: 200px;
                left:-60px;
                opacity: 1;
            }
            95%{
                /* top: 0px;
                left:300px; */
                opacity: 1;
            }
            100%{
                top: 0px;
                left:300px;
                opacity: 0;
            }
        }
        @-webkit-keyframes rocket{
            0%{
                top: 200px;
                left:-60px;
                opacity: 1;
            }
            95%{
                /* top: 0px;
                left:300px; */
                opacity: 1;
            }
            100%{
                top: 0px;
                left:300px;
                opacity: 0;
            }
        }
    }
</style>
@endsection

@section('content')
<style>
    .home-logo_{
        position: absolute;
        width: 100%;
        top: 0;
        z-index:1;
    }
    .logo-flt_{
        position: relative;
        top: 0;
        left: 0;
        z-index: 999;
    }
    .main-video{
        display: block;
        position: relative;
        width: 100%;
    }
    @media(min-width:1200px){
        .main-video{
            top: -80px;
        }
    }
</style>
<section class="mb-5">
    <div class="container">
        <div class="position-relative">
            <div class="home-logo_">
                <div class="logo-flt_">
                    <img src="{{ asset('assets/front/images/logo-light.svg') }}" class="main_logo pt-5" alt="OPENLINK">
                </div>
            </div>    
        </div>
	</div>

    <div class="position-relative">
        <video  playsinline autoplay muted loop class="main-video">
            <source src="{{asset('assets/videos/main-page.mp4')}}" type="video/mp4">
            {{-- <source src="uploads/promo-dukandary.ogg" type="video/ogg"> --}}
        </video>
    </div>
</section>
{{-- <section id="banner-main">
    <div class="py-5">
        <div class="container">
            <div class="mb-5 mb-xl-0">
                <img src="{{ asset('assets/front/images/logo-light.svg') }}" class="main_logo" alt="OPENLINK">
            </div>

            <div class="flex-banner">
                <div class="d-block">
                    <div class="row align-items-center">
                        <style>
                            .max-width-500{
                                max-width: 500px;
                            }
                            @media(min-width:992px){
                                .main-line{
                                    font-size: 2rem!important;
                                }
                            }
                            @media(max-width:340px){
                                .main-line{
                                    font-size: 1.6rem!important;
                                }
                            }
                        </style>

                        <div class="order-lg-2 col-xl-7 col-lg-7 text-center  mb-5 mb-lg-0">
                            <img src="{{ asset('assets/front/images/home-ban.svg') }}" class="banner-image" alt="OPENLINK">
                        </div>
                        <div class="order-lg-1 col-lg-5">
                            <div class="text-white mb-4">
                                <h1 class="main-line font-h1 color-drk text-uppercase font-700 mb-3"><span>OPENLINK gives you a</span><br> <span class="display-4 font-800"> pathway</span> </h1>
                                <p class="h5 font-h1 font-300 text-uppercase_ lh-2 max-width-500">To share links with your customers and lets your customers re-share it to avail themselves of some benefit.</p>
                            </div>
                            <div>
                                <button onclick="window.location.href='{{ url('signin?tab=register') }}';return false;" class="btn btn-theme btn-lg">Sign up for Free</button>
                            </div>
                        </div>
                        

                    </div>
                </div>
            </div>

        </div>
    </div>
</section> --}}


<section id="new-banner" class="d-none">
	<div class="container">
        <div class="home-logo">
            <div class="logo-flt">
                <img src="{{ asset('assets/front/images/logo-light.svg') }}" class="main_logo pt-5" alt="OPENLINK">
            </div>
        </div>
	</div>
    <div class="content-ban">
        <div class="container">
            <div class="py-5">
                <div class="row">
                    <div class="col-xl-6 col-lg-8">
                        {{-- <div class="text-white mb-4">
                            <h1 class="main-line font-h1 color-drk text-uppercase font-700 mb-3"><span>Get in & Grow with</span><br> <span class="display-4 font-800"> #Mouthpublicity</span> </h1>
                            <p class="h5 font-h1 font-300 text-uppercase_ lh-2 max-width-500">Share your link with your customer and let them re-share it in their network to grow your business through a digital way of mouth publicity.</p>
                        </div> --}}
                        <div class="text-white mb-4">
                            <h1 class="main-line font-h1 color-drk_ font-800 mb-3" style="line-height:1.2">
                                <span class="display-4 font-800 ">YAY!</span>
                                <br>
                                <span style="font-size:18px;">Send Notifications, Order Receipts, Special Offers</span><br>
                                <span>ON CUSTOMER'S WHATSAPP</span>
                                <br>
                                <span class="font-300" style="font-size:26px">and Enhance your customer experience</span><br>

                                <span>Just <font face="Arial, Verdana, Geneva, sans-serif">&#8377;</font> 1/Day </span></h1>
                            <p class="h5 font-h1 font-300 text-uppercase_ lh-2 max-width-500">OPENLINK'S WhatsApp API helps you send alerts, greetings, new arrivals, updates, and order receipts directly to your customers.</p>
                        </div>

                        <div>
                            {{-- <button onclick="window.location.href='{{ url('signin?tab=register') }}';return false;" class="btn btn-theme btn-lg">Sign up for Free</button> --}}
                            <button onclick="window.location.href='{{ url('pricing') }}';return false;" class="btn btn-theme btn-lg">Get Now</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mockup"></div>

</section>

<!-- Boost your bussiness -->
<section class="pb-5 position-relative">

    <img src="{{asset('assets/front/images/home/rocket.svg')}}" class="rocket">

    <div class="container">

        <div class="row justify-content-center"> 
            <div class="col-lg-6">
                <div class="pb-5">
                    <h3 class="fw-bold text-center text-capitalize h1">Boost Your Business With
                    <span class="oplk-text-gradient"><strong>OPENLINK</strong></span></h3>
                </div>       
            </div>
        </div>
        <!--01 card  -->
       <div class="mb-5 pb-lg-5">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="text-center">
                        <img src="{{ asset('assets/front/images/home/whatsapp_billing.svg') }}" class="card-2-img" alt="whatsapp billing details">
                    </div>
                    <div class="diagonal-line-1 d-none d-lg-block"></div>
                </div>
                <div class="col-lg-6">
                    <div class="boost-card">
                        <div class="container-fluid">
                            <div class="row align-items-center">
                                <div class="col-md-4 col-lg-12">
                                    <h4 class="m-0 text-md-center text-lg-start" style="font-size: 80px;">01</h4>
                                </div>
                                <div class="col-md-8 col-lg-12">
                                    <div class="">
                                        <h5 class="color-lht fw-bold text-capitalize">WhatsApp Billing Details</h5>
                                        <p class="text-muted">Replace your SMS with a WhatsApp message now. Send your customer billing updates on their WhatsApp through your running billing software.</p>
                                    </div>
                                </div>
                                {{-- <div class="col-12">
                                    <a href class="btn btn-app text-decoration-none text-dark">See more <i class="bi bi-arrow-right"></i></a>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- 02 Card -->
        <div class="mb-5 pb-lg-5">
            <div class="row align-items-center">
                <div class="col-lg-6 order-lg-2">
                    <div class="text-center">
                        <img src="{{ asset('assets/front/images/home/customize_& _share_whatsapp.svg') }}" class="card-2-img"  alt="customise & share your content on whatsapp">
                    </div>
                    <div class="diagonal-line-2 d-none d-lg-block"></div>
                </div>
                <div class="col-lg-6 order-lg-1">
                    <div class="boost-card fx-size" >
                        <div class="row align-items-center">
                            <div class="col-md-4 col-lg-12">
                                <h4 class="m-0 text-md-center text-lg-start" style="font-size: 80px;">02</h4>
                            </div>
                            <div class="col-md-8 col-lg-12">
                                <h5 class="color-lht fw-bold text-capitalize">Customize & Share Your Content on WhatsApp</h5>
                                <p class="text-muted">Select template, build your WhatsApp message, and share it with everyone on WhatsApp with OPENLINK. </p>
                            </div>    
                        </div>
                        
                        {{-- <div class="">
                            <a href class="btn btn-app text-decoration-none text-dark">See more <i class="bi bi-arrow-right"></i></a>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
        <!-- 03 Card -->
        <div class="mb-5 pb-lg-5">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="text-center">
                        <img src="{{ asset('assets/front/images/home/social_media_analytics.svg') }}" class="card-2-img" alt="Social media analytics">
                    </div>
                    <div class="diagonal-line-1 d-none d-lg-block"></div>
                </div>
                <div class="col-lg-6">
                    <div class="boost-card">
                        <div class="container-fluid">
                            <div class="row align-items-center">
                                <div class="col-md-4 col-lg-12">
                                    <h4 class="m-0 text-md-center text-lg-start" style="font-size: 80px;">03</h4>
                                </div>
                                <div class="col-md-8 col-lg-12">
                                    <div class="">
                                        <h5 class="color-lht fw-bold text-capitalize">Social Media Sharing & Analytics</h5>
                                        <p class="text-muted">Post your content on social media through OPENLINK & keep each click on your post on a single Dashboard of OPENLINK.</p>
                                    </div>
                                </div>
                                {{-- <div class="col-12">
                                    <a href class="btn btn-app text-decoration-none text-dark">See more <i class="bi bi-arrow-right"></i></a>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- 04 card -->
        <div class="mb-5 pb-lg-5">
            <div class="row align-items-center">
                <div class="col-lg-6 order-lg-2">
                    <div class="text-center">
                        <img src="{{ asset('assets/front/images/home/create_run_campaign.svg') }}" class="card-2-img" alt="Create and Run Campaigns">
                    </div>
                    <div class="diagonal-line-2 d-none d-lg-block"></div>
                </div>
                <div class="col-lg-6 order-lg-1">
                    <div class="boost-card fx-size" >
                        <div class="row align-items-center">
                            <div class="col-md-4 col-lg-12">
                                <h4 class="m-0 text-md-center text-lg-start" style="font-size: 80px;">04</h4>
                            </div>
                            <div class="col-md-8 col-lg-12">
                                <h5 class="color-lht fw-bold text-capitalize">Create and Run Campaigns</h5>
                                <p class="text-muted">Run different business campaigns through OPENLINK, create the link, share them with your customer. Customize links with rewards, offers, giveaways, or any other business campaigns..</p>
                            </div>
                            {{-- <div class="">
                                <a href class="btn btn-app text-decoration-none text-dark">See more <i class="bi bi-arrow-right"></i></a>
                            </div> --}}
                        </div>    
                    </div>
                </div>
            </div>
        </div>
        <!-- 05 card -->
        <div class="mb-5 pb-lg-5">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="text-center">
                        <img src="{{ asset('assets/front/images/home/instant_reward_coupons.svg') }}" class="card-2-img"  alt="Instant Rewards & Coupons">
                    </div>
                    <div class="diagonal-line-1 d-none d-lg-block"></div>
                </div>
                <div class="col-lg-6">
                    <div class="boost-card">
                        <div class="container-fluid">
                            <div class="row align-items-center">
                                <div class="col-md-4 col-lg-12">
                                    <h4 class="m-0 text-md-center text-lg-start" style="font-size: 80px;">05</h4>
                                </div>
                                <div class="col-md-8 col-lg-12">
                                    <div class="">
                                        <h5 class="color-lht fw-bold text-capitalize">Instant Reward & Coupon</h5>
                                        <p class="text-muted">Get more followers by running instant reward, coupons, or any other promotional activity. When users get any offer instantly, they tend to perform tasks more quickly to avail themselves of the benefit.</p>
                                    </div>
                                </div>
                                {{-- <div class="col-12">
                                    <a href class="btn btn-app text-decoration-none text-dark">See more <i class="bi bi-arrow-right"></i></a>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 06 Card -->
        <div class="mb-5 pb-lg-5">
            <div class="row align-items-center">
                <div class="col-lg-6 order-lg-2">
                    <div class="text-center">
                        <img src="{{ asset('assets/front/images/home/track_&_manage.svg') }}" class="card-2-img" alt="Track and manage entries on a single dashboard">
                    </div>
                    <div class="diagonal-line-2 d-none d-lg-block"></div>
                </div>
                <div class="col-lg-6 order-lg-1">
                    <div class="boost-card fx-size">
                        <div class="row align-items-center">
                            <div class="col-md-4 col-lg-12">
                                <h4 class="m-0 text-md-center text-lg-start" style="font-size: 80px;">06</h4>
                            </div>
                            <div class="col-md-8 col-lg-12">
                                <h5 class="color-lht fw-bold text-capitalize">Track and Manage Entries on a Single Dashboard</h5>
                                <p class="text-muted">Track your customer's activity and analytics in real-time of shared links on a single dashboard.</p>
                            </div>
                            {{-- <div class="">
                                <a href class="btn btn-app text-decoration-none text-dark">See more <i class="bi bi-arrow-right"></i></a>
                            </div> --}}  
                        </div>
                    </div>
                </div>
            </div>
        </div>

<!-- 07 Card -->
        <div class="mb-5 pb-lg-5">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="text-center">
                        <img src="{{ asset('assets/front/images/home/embeded_anywhere.svg') }}" class="card-2-img" alt="boost_engagement">
                    </div>
                    <div class="diagonal-line-1 d-none d-lg-block"></div>
                </div>
                <div class="col-lg-6">
                    <div class="boost-card fx-size">
                        <div class="row align-items-center">
                            <div class="col-md-4 col-lg-12">
                                <h4 class="m-0 text-md-center text-lg-start" style="font-size: 80px;">07</h4>
                            </div>
                            <div class="col-md-8 col-lg-12">
                                <h5 class="color-lht fw-bold text-capitalize">Boost Engagement</h5>
                                <p class="text-muted">Increase engagement directly on your business social media platform, grow the market by creating and sharing successful strategies, contests, giveaways, polls, coupons, forms and offers links.</p>
                            </div>
                        {{-- <div class="">
                                <a href class="btn btn-app text-decoration-none text-dark">See more <i class="bi bi-arrow-right"></i></a>
                        </div> --}}   
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- 07 Card -->

        <!-- 08 Card -->
        <div class="mb-5 pb-lg-5">
            <div class="row align-items-center3">
                <div class="col-lg-6 order-lg-2">
                    <div class="text-center">
                        <img src="{{ asset('assets/front/images/home/loyal_customer_base.svg') }}" class="card-2-img" alt="Build a Loyal Customer Base">
                    </div>
                    <div class="d-none d-lg-block"></div>
                </div>
                <div class="col-lg-6 order-lg-1">
                    <div class="boost-card">
                        <div class="row align-items-center">
                            <div class="col-md-4 col-lg-12">
                                <h4 class="m-0 text-md-center text-lg-start" style="font-size: 80px;">08</h4>
                            </div>
                            <div class="col-md-8 col-lg-12">
                                <div class="">
                                    <h5 class="color-lht fw-bold text-capitalize">Build a Loyal Customer Base</h5>
                                    <p class="text-muted">Businesses need to create a loyal customer base to stay afloat and propel the growth of their brand. By giving instant or future benefits to your existing customer, you can build a trustworthy customer base and keep your relationship with them in a continuous loop.</p>
                                </div>
                            </div>
                            {{-- <div class="col-12">
                                <a href class="btn btn-app text-decoration-none text-dark">See more <i class="bi bi-arrow-right"></i></a>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- 08 Card -->

        <!-- 09 Card -->
        
        <!-- 09 Card -->

    </div>
</section>
<!-- Boost your bussiness -->

<!-- Three Awesome Apps in One Dashboard -->
<section style="">
    <div class="pt-5" id="apps" style="position: relative; padding-bottom: 150px;">
        <div class="container">
            <div class="text-center text-white">
                <h2 class="h4">Every click brings you one step close to your potential customer</h2>
                <div class="pt-3">
                    {{-- <p>
                        Every click brings you one step close to your potential customer
                    </p> --}}
                </div>
            </div>
        </div>
    </div>
<style type="text/css">
    #carousel {
      margin: auto;
      width: 100%;
      text-align: center;
    }
    .owl-carousel .owl-item img {
        display: inline-block;
    }
    .item{
        height: 100% !important;
    }
    .card-icon{
        height: 100% !important;
        border-radius: 10px;
        overflow: hidden;
    }
    .card-base{
        height: 100% !important;
    }
    .card-data{
        height: 100% !important;
    }
    .owl-nav {
      position: absolute;
      height: 0;
      top: 50%;
      left: 10px;
      right: 10px;
    }
    .owl-nav [class^=owl] {
      width: 24px;
      height: 24px;
      background: #4DB6AC;
      border-radius: 50%;
      position: absolute;
      top: -12px;
      transition: transform 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .owl-nav [class^=owl]:after {
      content: "";
      display: block;
      position: absolute;
      top: calc(50% - 6px);
      transition: opacity 0.2s ease 0.2s;
    }
    .owl-nav [class^=owl].disabled {
      transform: scale(0);
      transition-timing-function: cubic-bezier(0.19, 1, 0.22, 1);
    }
    .owl-nav [class^=owl].disabled:after {
      opacity: 0;
    }
    .owl-dots {
      text-align: center;
      line-height: 0;
      position: absolute;
      bottom: -20px;
      left: 0;
      right: 0;
    }
    .owl-dot {
      display: inline-block;
      width: 12px;
      height: 12px;
      position: relative;
    }
    .owl-dot + .owl-dot {
      margin-left: 12px;
    }
    .owl-dot:after {
      content: "";
      display: block;
      background: #4DB6AC;
      width: 100%;
      height: 100%;
      border-radius: 50%;
      transform: scale(0.25);
      transition: transform 0.3s ease;
    }
    .owl-dot.active:after {
      transition-delay: 0.2s;
      transform: scale(1);
    }

    .dot-indicator {
      width: 24px;
      height: 2px;
      background: #4DB6AC;
      position: absolute;
      top: calc(50% - 1px);
      transform: scaleX(0);
      -webkit-animation-duration: 0.2s;
              animation-duration: 0.2s;
      -webkit-animation-timing-function: linear;
              animation-timing-function: linear;
      -webkit-animation-fill-mode: forwards;
              animation-fill-mode: forwards;
    }
    .dot-indicator.next {
      left: 50%;
      -webkit-animation-name: dot-indicator-next;
              animation-name: dot-indicator-next;
    }
    .dot-indicator.prev {
      right: 50%;
      -webkit-animation-name: dot-indicator-prev;
              animation-name: dot-indicator-prev;
    }

    @-webkit-keyframes dot-indicator-next {
      0%, 100% {
        transform: scaleX(0);
      }
      0%, 60% {
        transform-origin: left;
      }
      60% {
        transform: scaleX(1);
      }
      60.1%, 100% {
        transform-origin: right;
      }
    }

    @keyframes dot-indicator-next {
      0%, 100% {
        transform: scaleX(0);
      }
      0%, 60% {
        transform-origin: left;
      }
      60% {
        transform: scaleX(1);
      }
      60.1%, 100% {
        transform-origin: right;
      }
    }
    @-webkit-keyframes dot-indicator-prev {
      0%, 100% {
        transform: scaleX(0);
      }
      0%, 60% {
        transform-origin: right;
      }
      60% {
        transform: scaleX(1);
      }
      60.1%, 100% {
        transform-origin: left;
      }
    }
    @keyframes dot-indicator-prev {
      0%, 100% {
        transform: scaleX(0);
      }
      0%, 60% {
        transform-origin: right;
      }
      60% {
        transform: scaleX(1);
      }
      60.1%, 100% {
        transform-origin: left;
      }
    }
@media(max-width: 575px){
    .item{
        height: auto !important;
    }
    .card-icon{
        height: auto !important;
    }
    .card-base{
        height: auto !important;
    }
    .card-data{
        height: auto !important;
    }
}    
 
</style>
    <div style="position: relative;top: -150px;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="owl-carousel" id="carousel">
                        <div class="item">
                            <div class="card-base mx-auto pb-3" style="max-width: 30rem; ">
                                <div class="card-icon">
                                    <a href="#" title="Widgets" id="widgetCardIcon" class="imagecard">
                                       <img src="{{asset('assets/front/images/home/whatsapp_api_icon.svg')}}" class="w-50">
                                    </a>
                                    <div class="card-data widgetCardData p-4 oplk-bg-color-gradient content">
                                        <h5 class="box-title pt-5 text-center text-uppercase">WHATSAPP API</h5>
                                        <p class="card-block small">Connect and keep your business communication going with customers on WhatsApp. Now create & Send your message to your customers WhatsApp from running a billing system with WhatsApp API. You can also send alerts, updates, notifications and order receipts to individual customers or Group.</p>
                                        {{-- <a href="#" title="Style Builder" class="anchor btn btn-app text-decoration-none"> <i class="fa fa-paper-plane" aria-hidden="true"></i> See more <i class="bi bi-arrow-right"></i></a> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">    
                            <div class="card-base mx-auto pb-3" style="max-width: 30rem; ">
                                <div class="card-icon">
                                    <a href="#" title="Widgets" id="widgetCardIcon" class="imagecard">
                                        <img src="{{asset('assets/front/images/home/share_and_reward_icon.svg')}}" class="w-50">
                                    </a>
                                    <div class="card-data widgetCardData p-4 oplk-bg-color-gradient content">
                                        <h5 class="box-title pt-5 text-center text-uppercase">SHARE & REWARD</h5>
                                        <p class="card-block small">Turn your potential customers into your personal business marketer. Create a link with some amazing offers, set the offer availing target, share it with your existing customer, and let them re-share it on their network. When the target is completed, you can redeem your customer by giving a percentage discount, fixed amount discount, or cashback offer with OPENLINK.</p>
                                        {{-- <a href="#" title="Style Builder" class="anchor btn btn-app text-decoration-none"> <i class="fa fa-paper-plane" aria-hidden="true"></i> See more <i class="bi bi-arrow-right"></i></a> --}}
                                    </div>
                                </div>
                            </div>
                        </div>    
                        <div class="item">    
                            <div class="card-base mx-auto pb-3" style="max-width: 30rem; ">
                                <div class="card-icon">
                                    <a href="#" title="Widgets" id="widgetCardIcon" class="imagecard">
                                        <img src="{{ asset('assets/front/images/home/instant_reward.svg')}}" class="w-50">
                                    </a>
                                    <div class="card-data widgetCardData p-4 oplk-bg-color-gradient content">
                                        <h5 class="box-title pt-5 text-center text-uppercase">INSTANT REWARD</h5>
                                        <p class="card-block small">Grow your social media presence instantly. Easily create an instant offer for customers in exchange for actions from them. Share the offer instantly with customers at times of purchase, ask them to follow and grow your social media presence, and avail them of some benefit to boost your business reach.</p>
                                        {{-- <a href="#" class="anchor btn btn-app text-decoration-none"> <i class="fa fa-paper-plane" aria-hidden="true"></i> See more <i class="bi bi-arrow-right"></i></a> --}}
                                    </div>
                                </div>
                            </div>
                        </div>   
                        <div class="item"> 
                            <div class="card-base mx-auto pb-3" style="max-width: 30rem; ">
                                <div class="card-icon">
                                    <a href="#" title="Widgets" id="widgetCardIcon" class="imagecard">
                                        <img src="{{ asset('assets/front/images/home/D2C_post_icon.svg')}}" style="width: 30px;">
                                    </a>
                                    <div class="card-data widgetCardData p-4 oplk-bg-color-gradient content">
                                        <h5 class="box-title pt-5 text-center text-uppercase">D2C Post</h5>
                                        <p class="card-block small">Save your time and message all your customers at one time. Whatsapp is a very prominent tool when it comes to communication. OPENLINK D2C i.e Direct to Customer app helps you broadcast the messages to a list of customers on their WhatsApp.
                                        Just create your message, share it with your audience and analyze each click on your content on Dashboard. OPENLINK D2C takes this a step further with chat blasts. This means you can reach your audience with your latest content instantly via Whatsapp. 
                                        </p>
                                        {{-- <a href="#" class="anchor btn btn-app text-decoration-none"> <i class="fa fa-paper-plane" aria-hidden="true"></i> See more <i class="bi bi-arrow-right"></i></a> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item"> 
                            <div class="card-base mx-auto pb-3" style="max-width: 30rem; ">
                            <div class="card-icon">
                                <a href="#" title="Widgets" id="widgetCardIcon" class="imagecard">
                                    <img src="{{ asset('assets/front/images/home/personalised_greetings_icon.svg')}}" style="width: 30px;">
                                </a>
                                <div class="card-data widgetCardData p-4 oplk-bg-color-gradient content">
                                    <h5 class="box-title pt-5 text-center text-uppercase">Personalised Greeting</h5>
                                    <p class="card-block small">Personalised Greeting is a great asset for maintaining a happy client relationship. OPENLINK’s Personalized Wishing app lets you greet your customer effortlessly and automatically on their special day.Just once draft your customized message which would make your customer feel special. Save your customer's data and let OPENLINK work on it.</p>
                                    {{-- <a href="#" class="anchor btn btn-app text-decoration-none"> <i class="fa fa-paper-plane" aria-hidden="true"></i> See more <i class="bi bi-arrow-right"></i></a> --}}
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="item"> 
                            <div class="card-base mx-auto pb-3" style="max-width: 30rem; ">
                                <div class="card-icon">
                                    <a href="#" title="Widgets" id="widgetCardIcon" class="imagecard">
                                        <img src="{{ asset('assets/front/images/home/social_media_post_icon.svg')}}" style="width: 56px;">
                                    </a>
                                    <div class="card-data widgetCardData p-4 oplk-bg-color-gradient content">
                                        <h5 class="box-title pt-5 text-center text-uppercase">Social Media Post</h5>
                                        <p class="card-block small">OPENLINK Social Media Post is an all-in-one dashboard for social media posting management with social media metrics. Use OPENLINK Social Media Post to create and share a post on Facebook, Twitter, and LinkedIn and even gain audience insights at-a-glance. OPENLINK Social Media Post has lots of templates to build unique and attractive templates. Additionally, you can store unlimited posts tied to particular themes, and queue them up for posting.</p>
                                        {{-- <a href="#" class="anchor btn btn-app text-decoration-none"> <i class="fa fa-paper-plane" aria-hidden="true"></i> See more <i class="bi bi-arrow-right"></i></a> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item"> 
                            <div class="card-base mx-auto pb-3" style="max-width: 30rem; ">
                                <div class="card-icon">
                                    <a href="#" title="Widgets" id="widgetCardIcon" class="imagecard">
                                        <img src="{{ asset('assets/front/images/home/make_share_icon.svg')}}" class="w-50">
                                    </a>
                                    <div class="card-data widgetCardData p-4 oplk-bg-color-gradient content">
                                        <h5 class="box-title pt-5 text-center text-uppercase">Make & Share</h5>
                                        <p class="card-block small">Create amazing, appealing, and engaging content using a customized template and share it with your friends, family, and colleagues on WhatsApp. Analyze each click on your content on OPENLINK’s Dashboard. OPENLINK Make & Share app lets you create engaging and sharing content that too in a few clicks.</p>
                                        {{-- <a href="#" class="anchor btn btn-app text-decoration-none"> <i class="fa fa-paper-plane" aria-hidden="true"></i> See more <i class="bi bi-arrow-right"></i></a> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item"> 
                            <div class="card-base mx-auto pb-3" style="max-width: 30rem; ">
                                <div class="card-icon">
                                    <a href="#" title="Widgets" id="widgetCardIcon" class="imagecard">
                                        <img src="{{ asset('assets/front/images/home/empolyee_manegment_icon.svg')}}" class="w-50">
                                    </a>
                                    <div class="card-data widgetCardData p-4 oplk-bg-color-gradient content">
                                        <h5 class="box-title pt-5 text-center text-uppercase">Employee Management</h5>
                                        <p class="card-block small">Let your employees manage all your offer sharing and redeem processes at your counter. Easily create your employee's id, give them access to your OPENLINK account and let them manage your work. Employees can not access other processes rather than offer sharing and offer redemption.</p>
                                        {{-- <a href="#" class="anchor btn btn-app text-decoration-none"> <i class="fa fa-paper-plane" aria-hidden="true"></i> See more <i class="bi bi-arrow-right"></i></a> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>  
        </div>
    </div>  
<script type="text/javascript">
    $(function() {
    var current_pos;
    
    $('#carousel').owlCarousel({
        items: 3,
        mouseDrag: false,
        touchDrag: true,
        autoplay: true,
        autoplayTimeout: 4000,
        nav: false,
        navText: ['', ''],
        dots: true,
        loop: true,
        margin: 15,
        responsive: {
            0: {
                items: 1,
            },
            768: {
                items: 2,
            },
            991: {
                items: 3,
            },
        }
    });
});
</script>
</section>
<!-- Three Awesome Apps in One Dashboard -->

<?php
$partner = array(
    array('icon' => 'bi-people', 'title' => 'Increase your Customer Base', 'content' => 'Use our 50+ beautiful pre-optimized templates, create links and share them with your customer to improve your conversion rates to over 40%!', 'image' => asset('assets/front/images/home-tab-1.svg'), 'icon_svg' => '<svg id="Layer_1" width="100%" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 50 50"><defs><style>.tab-svg1, .tab-svg2, .tab-svg3{fill:#ffffff;}.active .tab-svg1 {fill: url(#linear-gradient);}.active .tab-svg2 {fill: url(#linear-gradient);}.active .tab-svg3 {fill: url(#linear-gradient);}</style><linearGradient id="linear-gradient" x1="4.3" y1="6.41" x2="50.11" y2="60.28" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="var(--color-thm-drk)" /><stop offset="1" stop-color="var(--color-thm-lth)" /></linearGradient></defs><path id="Path_1240-2" data-name="Path 1240-2" class="tab-svg1" d="M49.71,31.2a5.57,5.57,0,0,1-1.88,2.89c-4.26,4.08-8.5,8.19-12.76,12.28a1.17,1.17,0,0,1-.71.28q-8.55,0-17.09,0a2.1,2.1,0,0,1-.7-.12L11,44.66a.46.46,0,0,1-.37-.51q0-7.56,0-15.11a.61.61,0,0,1,.37-.59,10.05,10.05,0,0,1,11.89,1.33,1.07,1.07,0,0,0,.81.32h6.81a3,3,0,0,1,3.08,2.27A3.25,3.25,0,0,1,32.12,36a3.66,3.66,0,0,1-2,.53H21.24v2.86l.28,0c3,0,6,0,9,0a6.12,6.12,0,0,0,5.94-5.1,1.15,1.15,0,0,1,.33-.6q3.18-2.91,6.39-5.81a3.82,3.82,0,0,1,5.41.07,3.74,3.74,0,0,1,1,1.91.56.56,0,0,0,.09.17Z" /><path id="Path_1241-2" data-name="Path 1241-2" class="tab-svg2" d="M.28,25.4c1.27,0,2.55,0,3.82,0a4,4,0,0,1,3.39,1.8,1.13,1.13,0,0,1,.19.62q0,8.25,0,16.5a1.11,1.11,0,0,1-.19.62,3.94,3.94,0,0,1-3.2,1.79c-1.34,0-2.67,0-4,0Z" /><path class="tab-svg3" d="M32.6,3.24c.35.08.69.15,1,.25a5.79,5.79,0,0,1-.57,11.25.21.21,0,0,0-.17.1h2.28A6,6,0,0,1,41.28,21v5.13H22.75c0-.16,0-.31,0-.45,0-1.59,0-3.18,0-4.77a6,6,0,0,1,6-6c.77,0,1.53,0,2.3,0a6.74,6.74,0,0,1-2.56-1.15,5.78,5.78,0,0,1,2.6-10.33,3,3,0,0,0,.32-.09Z" /></svg>'),
    array('icon' => 'bi-wifi', 'title' => 'Potential Customers Add Value', 'content' => 'Reach your targeted audience, convert them into your potential leads by offering them the best offers/ rewards and ask them to re-share links in their audience to add more value to your business.', 'image' => asset('assets/front/images/home-tab-2.svg'), 'icon_svg' => '<svg id="Layer_2" width="100%" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 50 50"> <defs> <style> .tab-2-icon {fill: #ffffff;} .active .tab-2-icon {fill: url(#linear-gradient);} </style> <linearGradient id="linear-gradient" x1="4.3" y1="7.17" x2="50.11" y2="61.04" gradientUnits="userSpaceOnUse"> <stop offset="0" stop-color="var(--color-thm-drk)" /> <stop offset="1" stop-color="var(--color-thm-lth)" /> </linearGradient> </defs> <path id="Path_1240-2" data-name="Path 1240-2" class="tab-2-icon" d="M49.71,32a5.57,5.57,0,0,1-1.88,2.89c-4.26,4.08-8.5,8.2-12.76,12.28a1.17,1.17,0,0,1-.71.28q-8.55,0-17.09,0a2.38,2.38,0,0,1-.7-.11C14.7,46.68,12.83,46,11,45.42a.46.46,0,0,1-.37-.51q0-7.54,0-15.11a.61.61,0,0,1,.37-.59,10,10,0,0,1,11.89,1.34,1.06,1.06,0,0,0,.81.31h6.81a3,3,0,0,1,3.08,2.26,3.25,3.25,0,0,1-1.42,3.64,3.58,3.58,0,0,1-2,.53H21.24v2.87l.28,0c3,0,6,0,9,0a6.14,6.14,0,0,0,5.94-5.11,1.15,1.15,0,0,1,.33-.6q3.18-2.91,6.39-5.81a3.83,3.83,0,0,1,5.41.07,3.73,3.73,0,0,1,1,1.92.51.51,0,0,0,.09.16Z" /> <path id="Path_1241-2" data-name="Path 1241-2" class="tab-2-icon" d="M.28,26.17c1.27,0,2.55,0,3.82,0A4,4,0,0,1,7.49,28a1.16,1.16,0,0,1,.19.62q0,8.25,0,16.51a1.16,1.16,0,0,1-.19.62,3.93,3.93,0,0,1-3.2,1.78c-1.34,0-2.67,0-4,0Z" /> <path class="tab-2-icon" d="M41.19,20.48v6c0,.65-.22.88-.87.89s-1.11,0-1.66,0-.74-.17-.75-.74c0-1,0-2,0-3q0-4.25,0-8.48c0-.32,0-.63.06-1a.5.5,0,0,1,.57-.5c.63,0,1.26,0,1.89,0s.8.22.8.85Z" /> <path class="tab-2-icon" d="M38.62,10.58c-.27-.26-.53-.48-.77-.74s-.26-.61.16-.76c1-.37,2-.71,2.94-1,.44-.15.69.06.61.52-.17,1-.37,2-.57,3.07-.09.42-.43.52-.8.25s-.53-.43-.83-.69l-.65.71a37.11,37.11,0,0,1-11.14,8.82,20.67,20.67,0,0,1-5.52,1.92c-.33.06-.59,0-.67-.34s.18-.51.48-.57c4.24-.82,7.79-3,11.12-5.63A43.55,43.55,0,0,0,38.29,11Z" /> <path class="tab-2-icon" d="M32.51,22.86c0-1.24,0-2.49,0-3.73,0-.64.19-.82.82-.82h1.75c.49,0,.69.2.7.68q0,3.8,0,7.57c0,.52-.22.76-.74.77s-1.26,0-1.89,0a.6.6,0,0,1-.66-.69c0-1.26,0-2.52,0-3.78Z" /> <path class="tab-2-icon" d="M27.15,24.45c0-.71,0-1.42,0-2.13,0-.48.21-.69.68-.7.66,0,1.33,0,2,0a.54.54,0,0,1,.59.59c0,1.48.05,3,.05,4.44a.62.62,0,0,1-.64.68c-.69,0-1.39,0-2.08,0a.56.56,0,0,1-.59-.65V24.45Z" /> <path class="tab-2-icon" d="M25.08,25.42c0,.41,0,.82,0,1.23a.65.65,0,0,1-.68.69c-.63,0-1.26,0-1.89,0a.66.66,0,0,1-.73-.7q0-1.28,0-2.55a.63.63,0,0,1,.7-.66c.63,0,1.26,0,1.89,0s.69.21.71.7S25.08,25,25.08,25.42Z" / </svg>'),
    array('icon' => 'bi-geo-fill', 'title' => 'Reach Within Minutes Anywhere', 'content' => 'Create, share & re-share the link and outgrow your customer network within a few minutes.', 'image' => asset('assets/front/images/home-tab-3.svg'), 'icon_svg' => '<svg id="Layer_3" width="100%" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 50 50"><defs><style>.tab-3-icon {fill: #ffffff;}.active .tab-3-icon {fill: url(#linear-gradient);}</style><linearGradient id="linear-gradient" x1="15.76" y1="-6.47" x2="60.48" y2="36.56" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="var(--color-thm-drk)" /><stop offset="1" stop-color="var(--color-thm-lth)" /></linearGradient></defs><path class="tab-3-icon" d="M33.05,1V3.81H26.4V6.25H23.6V3.82H16.93V1Z" /><path class="tab-3-icon" d="M45,29.05A20,20,0,1,1,25,9.06,20,20,0,0,1,45,29.05ZM24.87,37V20.5l-6,2.05.92,2.65,2.27-.77V37Zm5.81-11.26V19.11H27.93v6.62Z" /><path class="tab-3-icon" d="M9.79,12,8,13.82,4.79,10.63,6.62,8.8Z" /><path class="tab-3-icon" d="M43.33,8.77l1.88,1.9L42.1,13.78,40.21,11.9Z" /></svg>'),
    array('icon' => 'bi-bar-chart-line', 'title' => 'Analytics and Data', 'content' => 'Get all the customer\'s insights and their task performance on a customised dashboard. Check all the campaign performance.', 'image' => asset('assets/front/images/home-tab-4.svg'), 'icon_svg' => '<svg id="Layer_4" width="100%" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 50 50"><defs><style>.tab-4-icon { fill: #ffffff; } .active .tab-4-icon { fill: url(#linear-gradient); }</style><linearGradient id="linear-gradient" x1="-3.96" y1="-10.63" x2="52.1" y2="50.48" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="var(--color-thm-drk)" /><stop offset="1" stop-color="var(--color-thm-lth)" /></linearGradient></defs><path class="tab-4-icon" d="M2.05,39.78V2.1H48V39.78ZM15.58,26.35A9.4,9.4,0,1,0,6.17,17,9.43,9.43,0,0,0,15.58,26.35Zm20.15,8V18.33H33.09V34.38Zm-8-24.17H41.1V7.58H27.71Zm0,2.72v2.65H41.1V12.93ZM8.89,29.06v2.63H22.27V29.06Zm29.59-5.38V34.37h2.64V23.68ZM27.72,29.05v5.32h2.64V29.05Z" /><path class="tab-4-icon" d="M35.73,47.9H14.26V45.26h5.35V42.49H30.37v2.73h5.36Z" /><path class="tab-4-icon" d="M14.24,10.42v7.86h7.88a6.62,6.62,0,0,1-6.73,5.38,6.75,6.75,0,0,1-6.52-6.37A6.63,6.63,0,0,1,14.24,10.42Z" /><path class="tab-4-icon" d="M22.12,15.59H17V10.46A6.41,6.41,0,0,1,22.12,15.59Z" /></svg>'),
    // array('icon' => 'bi-bar-chart', 'title' => 'Increase Social Media presence', 'content' => 'Having a good social media presence will help you to build your brand and grow your business. Ask your customers to help you in growing your social media presence by following you there, in respect to that offer them some amazing discounts. The offers you will provide to your customers, they will like, share, subscribe and follow your social media pages and accounts, ultimately your social reach will get increased', 'image' => ''),
);
?>
<section id="">
    <div class="py-5 my-5 pt-0 mt-0">
        <div class="container">
            <style>
                .feture_img{
                    /* width: 100%; */
                    max-width: 400px;
                    max-height: 380px;
                }
                @media(max-width: 575px){
                    .section_featurs2 svg{
                        width: 27px;
                    }
                }
            </style>
            <h3 class="text-center fw-bolder h1 mb-4">Become Modern Marketer With OPENLINK</h3>
            @if(!empty($partner))
            <div class="section_featurs2">
                <div class="tab_list pb-md-5">
                    <ul class="nav nav-tabs" id="TabsS3" role="tablist">
                        @for ($i = 0; $i < count($partner); $i++)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link tab-icon {{ (!$i) ? 'active' : '' }}" id="s3t{{$i}}-tab" data-bs-toggle="tab" data-bs-target="#s3t{{$i}}" type="button" role="tab" aria-controls="s3t{{$i}}" aria-selected=" {{ (!$i) ? 'true' : 'false' }}">
                                {{-- <i class="bi {{$partner[$i]['icon']}}"></i> --}}
                                {!!$partner[$i]['icon_svg']!!}
                            </button>
                        </li>
                        @endfor
                    </ul>
                </div>
                <div class="tab-content" id="TabsS3Content">
                    @for ($i = 0; $i < count($partner); $i++)
                    <div class="tab-pane fade {{ (!$i) ? 'show active' : '' }}" id="s3t{{$i}}" role="tabpanel" aria-labelledby="s3t{{$i}}-tab">
                        <div class="partners">
                            <div class="row justify-content-center align-items-center">
                                <div class="order-md-2 col-md-5 mb-5 mb-md-0">
                                    <div class="heading font-h1 color-lht mb-4">
                                        <h3>{{$partner[$i]['title']}}</h3>
                                    </div>
                                    <div class="content">
                                        <p>{{$partner[$i]['content']}}</p>
                                    </div>
                                    <div class="content">
                                        {{-- <a href="#" class="btn btn-app">
                                            <span>Read More</span>
                                            <i class="bi bi-arrow-right"></i>
                                        </a> --}}
                                    </div>
                                </div>
                                <div class="order-md-1 col-md-4 text-center">
                                    <img src="{{ $partner[$i]['image'] }}" class="feture_img" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
            @endif
        </div>
    </div>
</section>

<section id="analytics_spoiler">
    <div class="oplk-bg-color-gradient p-5 px-3 px-md-3">
        <div class="container">
            <div style="border: 4px solid #fff;" class="p-3">  
                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <div class="text-white fw-bold d-flex justify-content-center align-items-center">
                            <h5 class="text-end spoiler_text">OPENLINK <br>User</h5>
                            <h3 class="px-2 spoiler_data">5K<i class="bi bi-arrow-up"></i></h3>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-white fw-bold d-flex justify-content-center align-items-center">
                            <h5 class="text-end spoiler_text">Offers <br>Created</h5>
                            <h3 class="px-2 spoiler_data">10K<i class="bi bi-arrow-up"></i></h3>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-white fw-bold d-flex justify-content-center align-items-center">
                            <h5 class="text-end spoiler_text">Link <br>Shares</h5>
                            <h3 class="px-2 spoiler_data">18M<i class="bi bi-arrow-up"></i></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Video Slider -->
{{--

<style type="text/css">
#carousel {
  margin: auto;
  width: 100%;
  max-width: 600px;
  text-align: center;
  font-size: 32px;
  color: #4DB6AC;
  box-shadow: 20px 20px 0 0 #B2DFDB, 40px 40px 0 0 #80CBC4;
}

.item {
  height: 300px;
  display: flex;
  justify-content: center;
  align-items: center;
}

.owl-item:nth-child(1) {
  /*background: #FFFDE7;*/
}
.owl-item:nth-child(2) {
  /*background: #FFF9C4;*/
}
.owl-item:nth-child(3) {
  background: red;
}
.owl-item:nth-child(4) {
  background: green;
}
.owl-item:nth-child(5) {
  background: #FFF9C4;
}
.owl-item:nth-child(6) {
  background: blue;
}
.owl-nav {
  position: absolute;
  height: 0;
  top: 50%;
  left: 10px;
  right: 10px;
}
.owl-nav [class^=owl] {
  width: 24px;
  height: 24px;
  border-radius: 50%;
  background: #4DB6AC;
  position: absolute;
  top: -12px;
  transition: transform 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}
.owl-nav [class^=owl]:after {
  content: "";
  display: block;
  border: 6px solid transparent;
  position: absolute;
  top: calc(50% - 6px);
  transition: opacity 0.2s ease 0.2s;
}
.owl-nav [class^=owl].disabled {
  transform: scale(0);
  transition-timing-function: cubic-bezier(0.19, 1, 0.22, 1);
}
.owl-nav [class^=owl].disabled:after {
  opacity: 0;
}
.owl-nav > :first-child {
  left: 0;
}
.owl-nav > :first-child:after {
  left: calc(50% - 9px);
  border-right-color: white;
}
.owl-nav > :last-child {
  right: 0;
}
.owl-nav > :last-child:after {
  right: calc(50% - 9px);
  border-left-color: white;
}
.owl-dots {
  text-align: center;
  line-height: 0;
  position: absolute;
  bottom: 10px;
  left: 0;
  right: 0;
}
.owl-dot {
  display: inline-block;
  width: 12px;
  height: 12px;
  position: relative;
}
.owl-dot + .owl-dot {
  margin-left: 12px;
}
.owl-dot:after {
  content: "";
  display: block;
  width: 100%;
  height: 100%;
  border-radius: 50%;
  background: #4DB6AC;
  transform: scale(0.25);
  transition: transform 0.3s ease;
}
.owl-dot.active:after {
  transition-delay: 0.2s;
  transform: scale(1);
}

.dot-indicator {
  width: 24px;
  height: 2px;
  background: #4DB6AC;
  position: absolute;
  top: calc(50% - 1px);
  transform: scaleX(0);
  -webkit-animation-duration: 0.2s;
          animation-duration: 0.2s;
  -webkit-animation-timing-function: linear;
          animation-timing-function: linear;
  -webkit-animation-fill-mode: forwards;
          animation-fill-mode: forwards;
}
.dot-indicator.next {
  left: 50%;
  -webkit-animation-name: dot-indicator-next;
          animation-name: dot-indicator-next;
}
.dot-indicator.prev {
  right: 50%;
  -webkit-animation-name: dot-indicator-prev;
          animation-name: dot-indicator-prev;
}

@-webkit-keyframes dot-indicator-next {
  0%, 100% {
    transform: scaleX(0);
  }
  0%, 60% {
    transform-origin: left;
  }
  60% {
    transform: scaleX(1);
  }
  60.1%, 100% {
    transform-origin: right;
  }
}

@keyframes dot-indicator-next {
  0%, 100% {
    transform: scaleX(0);
  }
  0%, 60% {
    transform-origin: left;
  }
  60% {
    transform: scaleX(1);
  }
  60.1%, 100% {
    transform-origin: right;
  }
}
@-webkit-keyframes dot-indicator-prev {
  0%, 100% {
    transform: scaleX(0);
  }
  0%, 60% {
    transform-origin: right;
  }
  60% {
    transform: scaleX(1);
  }
  60.1%, 100% {
    transform-origin: left;
  }
}
@keyframes dot-indicator-prev {
  0%, 100% {
    transform: scaleX(0);
  }
  0%, 60% {
    transform-origin: right;
  }
  60% {
    transform: scaleX(1);
  }
  60.1%, 100% {
    transform-origin: left;
  }
}
</style>

<section class="py-5 mb-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h4>TITLE</h4>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.    </p>
            </div>
            <div class="col-md-8"> 
                <div class="owl-carousel" id="carousel">
                    <div class="item"> 
                        <img src="{{asset('assets/front/images/openLink_share_icon.gif')}}">
                    </div>
                    <div class="item"> 
                        <img src="{{asset('assets/front/images/home-ban.svg')}}">
                    </div>
                    <div class="item"> </div>
                    <div class="item"> </div>
                    <div class="item"> </div>
                    <div class="item"> </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    $(function() {
    var current_pos;
    
    $('#carousel').owlCarousel({
        items: 1,
        mouseDrag: false,
        touchDrag: false,
        autoplay: true,
        autoplayTimeout: 2000,
        nav: true,
        navText: ['', ''],
        dots: true,
        onInitialized: function(e) {
            current_pos = e.item.index;
            
        },
        onTranslate: function(e) {
            var direction = e.item.index > current_pos? 1 : 0,
                    indicator_c = direction? 'next' : 'prev',
                    $dots = $(e.currentTarget).find('.owl-dots'),
                    $current_dot = $dots.children().eq(current_pos);
                        
            $current_dot.html('<div class="dot-indicator '+ indicator_c +'">');
            
            current_pos = e.item.index;
            
            setTimeout(function() {
                $current_dot.html('');
            }, 200);    
        }
    });
});
</script> --}}
<!-- Video Slider -->



<!-- Track Campaign performance -->
<section>
    <div class="bg-light py-5">
        <div class="container my-lg-5">
            
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h3 class="fw-bolder h1 mb-4">Track campaign performance</h3>
                    <div>
                        <p class="mb-4">See how people interact with your shared links in real-time. Track your current campaign, make adjustments to active campaigns, and plan your future marketing based on what you're seeing. </p>
                    </div>
                    <div class="mb-4">
                        {{-- <a href="{{ url('signin') }}" class="btn btn-theme btn-lg">Get Started</a> --}}
                        <button onclick="window.location.href='{{ url('signin?tab=register') }}';return false;" class="btn btn-theme btn-lg">Get Started</button>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="text-center">
                        <img src="{{asset('assets/front/images/dashboard.png')}}" class="img-fluid" alt="Dashboard">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Track Campaign performance -->

<section>
    <div class="oplk-bg-color-gradient py-5">

        <div class="container">
            <div class="row align-items-center text-white">
                <div class="col-lg-9 col-md-8">
                    <h2 class="text-capitalize">create your first OPENLINK campaign now!</h2>
                    <p>OPENLINK lets you create your offer, discount link and grow your business.</p>
                </div>
                <div class="col-lg-3 col-md-4 text-md-end">
                    {{-- <a href="{{ url('signin') }}" class="btn btn-light btn-lg fw-bold"> Get Started</a> --}}
                    <button onclick="window.location.href='{{ url('signin?tab=register') }}';return false;" class="btn btn-light btn-lg font-600">Create Now</button>
                </div>
            </div>
        </div>

    </div>
</section>

<section id="why_openlink">
    <div class="py-5 my-md-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="why_img">
                        <img src="{{ asset('assets/front/images/home/y_should_go_for_opnlnk.svg') }}" alt="openlink">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="why_tab">
                        <div class="wt_inner">
                            <div class="heading">
                                <h5 class="h3">Why should you go for OPENLINK?</h5>
                            </div>
                            <div class="text">
                                <ul class="why_list">
                                    <li>Instant Billing update on WhatsApp</li>
                                    <li>Customised Birthday/Anniversary wishes to each customer</li>
                                    <li>Easy social media posting from a single dashboard</li>
                                    <li>Bulk WhatsApp messaging</li>
                                    <li>Quick social media growth</li>
                                    <li>More customers walking</li>
                                    <li>Reach customers through your clients</li>
                                    <li>Brand Promotion</li>
                                    <li>Boost your social media presence</li>
                                    <li>Increase website traffic</li>
                                    <li>Increase in sale</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- <section id="testimonials">
    <span class="splashes dots-left"></span>
    <div class="py-5">
        <div class="container">
            <div class="heading text-center mb-5 ">
                <h3 class="font-h1 h1">What <span class="color-lht">People Say</span></h3>
            </div>
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-10 py-md-5">
                    <div class="owl-carousel owl-theme" id="SaysCarousel">
                        <div class="item">
                            <div class="says_tab">
                                <div class="say_inner">
                                    <div class="say_row">
                                        <div class="image_blk">
                                            <div class="img_thumb" style="/*background-image:url();*/"></div>
                                        </div>
                                        <div>
                                        <div class="say_text">
                                            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Dolorum, veniam sed. Saepe laborum et hic minima veritatis quo ipsum velit distinctio ratione repellendus, consequuntur sit ipsam optio aliquam reprehenderit natus.</p>
                                        </div>
                                        <div class="say_name">
                                            <h4 class="s_name mb-1">Pankaj Sakore</h4>
                                            <p class="s_bname">Business Name</p>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="says_tab">
                                <div class="say_inner">
                                    <div class="say_row">
                                        <div class="image_blk">
                                            <div class="img_thumb" style="/*background-image:url();*/"></div>
                                        </div>
                                        <div>
                                            <div class="say_text">
                                                <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text.</p>
                                            </div>
                                            <div class="say_name">
                                                <h4 class="s_name mb-1">Pratik Bhanarkar</h4>
                                                <p class="s_bname">Business Name</p>
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
</section> --}}
@endsection

@section('end_body')

@endsection