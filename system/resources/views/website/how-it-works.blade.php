@extends('layouts.website')

@section('title', 'How MouthPublicity.io Works for your business marketing.')
@section('description', 'Simple to Setup, Easy to Use. See How MouthPublicity.io Mouth Publicity Management Tool works for your business branding.')
{{-- @section('keywords', 'why MouthPublicity.io, what is MouthPublicity.io, mission of MouthPublicity.io, about us MouthPublicity.io') --}}
@section('image', asset('assets/website/images/how-it-works/how-it-works-banner.png'))

@push('css')
    <link rel="stylesheet" href="{{asset('assets/css/fontello/css/fontello.css')}}">
    <style>
        /* banner-img */
        .htw-banner-image img{
            width: 500px;
            max-width: 100%;
        }
        .faq_btn{
            background-color: rgba(239, 237, 237, 1);
            color:rgba(22, 109, 162, 1);
        }
        .htg_faq_tab_section .btn:hover {
            color:rgba(22, 109, 162, 1);
            background-color:rgba(239, 237, 237, 1);
            border-color: transparent;
        }
        .htgc_btn, .faq_btn {
            font-size: 1.5rem;
            width: 500px;
            max-width: 100%;
        }
        .htgc-text h2, .htgc-text h3{
            color: rgba(25, 122, 164, 1);
        }
        .how-to-sub-heading{
            background-color: rgba(22, 111, 162, 1);
            color: rgba(255, 255, 255, 1);
            border-radius: 50px;
            max-width: 340px;
            margin: auto;

        }
        .hwtr-step{
            border: 1px solid rgba(0,0,0,1);
            border-radius: 30px;
        }
        .bg-color{
            background-color: rgba(22, 111, 162, 1);
        }
        .cricle_bg{
            background-color: rgba(255, 255, 255, 1);
            border: 6px solid rgba(25, 122, 163, 1);
            border-radius: 50%;
            width: 80px;
            height: 80px;
            line-height: 70px;
            position: absolute;
            top: -46px;
            left: 50%;
            transform: translateX(-50%);
        }
        .cricle_bg i{
            font-size: 30px;
        }
        .all-channels-width{
            max-width: 250px;
        }
        .query-sec {
            border-radius: 15px;
        }
        .query-sec p {
            color: #fff;
            text-align: center;
            font-size: 2rem;
            line-height: 1.2;
        }
        .query-sec p a:hover{
            color: #e5e8ee !important;
        }
        .fd-challenge-img img {
            max-width: 350px;
            width: 100%;
        }
        .dw-arrow{
            max-width: 602px;
            width: 100%;
        }
        .bg-feature{
            background-color: #F6FCFF;
        }
        #all-channels [class*=" icon-"]:before{
            width: auto;
        }
        .down-ar{
            display: none;
        }
        .card-feature-text{
            margin-top: 34px;
        }
        .all-channels-width a{
            text-decoration: none;
        }
        @media(max-width: 1400px){
            .all-channels-width{ 
                max-width: 192px;
            }
        }
        @media(max-width:991px){
            .htgc_btn, .faq_btn {
                font-size: 1.2rem;
            }
            .dw-arrow{
                max-width: 353px;
            }
            .all-channels-width{
                max-width: 184px;
            }
        }
        @media(max-width:767px){
            .htgc_btn, .faq_btn{
                font-size: 0.8rem;
            }
            .hwtr-step{
                height: auto!important;
            }
            .dw-arrow{
                display: none;
            }
            .down-ar{
                display: inline;
                width: 18px;
            }
            .all-channels-width{
                max-width: 180px;
            }
            
        }
        @media(max-width: 575px){
            .query-sec p {
                color: #fff;
                text-align: center;
                font-size: 1.3rem;
                line-height: 1.2;
            }
            
            
            .cricle_bg {    
                width: 74px;
                height: 74px;
                line-height: 64px;
                top: -42px;
                border: 5px solid rgba(25, 122, 163, 1);
                
            }    
        }
        @media(max-width: 440px){
            .line-position-new{
                top: 245px;
            }
        }
    </style>
@endpush

@section('content')
{{-- Banner Section --}}
<section id="banner">
    <div class="pt-5x bg-dots position-relative">
        <div class="container">
            {{-- Breadcrumb Section --}}
            @php
                $bcrm = array(
                    array('name' => 'How It Works', 'link' => false),
                );
            @endphp
            @include('website.components.breadcrumb', $bcrm)
        </div>
        <div class="py-5">
            <div class="container">
                <div class="row justify-content-between align-items-center">
                    <div class="col-lg-5 order-lg-2">
                        <div class="htw-banner-image mb-4 mb-lg-0">
                            <img src="{{ asset('assets/website/images/how-it-works/how-it-works-banner.png') }}"
                                class="img-fluid" alt="HOW IT WORKS">
                        </div>
                    </div>
                    <div class="col-lg-6 order-lg-1">
                        <div class="banner-block pe-xl-5">
                            <h1 class="mb-4 text-uppercase h2 font-900 color-primary">HOW IT WORKS</h1>
                            <p class="mb-4">MouthPublicity.io gives your business a 360 degree vision in branding with mouth publicity and public relationship management. We have 5 unique and easy-to-use automated tools to manage your marketing activities quickly with constant monitoring.</p>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
    </div>
</section>

{{--tab sections --}}
 <section class="htg_faq_tab_section">
    <div class="">
        {{-- <div class="container-fluid">
            <div class="text-center d-flex justify-content-center">
                    <a href="" class="btn px-sm-5 px-2 py-3 mx-sm-3 mx-1 btn-primary-ol text-uppercase font-800 htgc_btn">how to guide content </a>
                    <a href="" class="btn px-sm-5 px-2 py-3 mx-sm-3 mx-1 text-uppercase font-800 faq_btn">faqs</a> 
            </div>
        </div>   --}}
        <div class="container">
            <div class="text-center mt-0 my-md-5 pt-sm-4 mx-auto  htgc-text">
                <h2 class="text-capitalize_ font-800 mb-3">Features of MouthPublicity.io</h2>
                <h3 class="font-600 text-center mx-auto">Launching Your Mouth Publicity Campaign Made Easy</h3>
            </div>
        </div>  
    </div>
</section>

<section id="all-channels">
    <div class="container">
        <div class="py-5">
            <div class="row justify-content-center">
                <div class="all-channels-width mt-5 pt-3 pt-lg-0">
                    <a href="#instant-challenge" class="scrolly">
                        <div class="card bg-black h-100 justify-content-center">                    
                            <div class="cricle_bg text-center">
                                <i class="fntlo icon-instant-challenge-icon color-gradient"></i>
                            </div>
                            <div class="py-3 px-1 card-feature-text">
                                <h6 class="text-uppercase text-white mb-0 text-center font-800">Instant Challenge</h6>
                            </div>
                            {{-- <div class="text-center mb-3 pt-0">
                                <a href="{{route('channels', 'instant-challenge')}}" class="btn px-4 py-2 btn-primary-ol" style="border-radius: 30px!important;">View Details</a>
                            </div> --}}
                        </div>
                    </a>
                </div>
                
                <div class="mt-5 all-channels-width pt-3 pt-lg-0">
                    <a href="#share-challenge" class="scrolly">
                        <div class="card bg-black h-100 mx-2 justify-content-center">
                            <div class="cricle_bg text-center">
                                <i class="fntlo icon-share-challenge-icon color-gradient"></i>
                            </div>
                            <div class="py-3 px-1 card-feature-text">
                                <h6 class="text-uppercase text-white mb-0 text-center font-800">Share Challenge</h6>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="mt-5 all-channels-width pt-3 pt-lg-0">
                    <a href="#social-post" class="scrolly">
                        <div class="card bg-black h-100 mx-2 justify-content-center">
                            <div class="cricle_bg text-center">
                                <i class="fntlo icon-social-post-icon color-gradient"></i>
                            </div>
                            <div class="py-3 px-1 card-feature-text">
                                <h6 class="text-uppercase text-white mb-0 text-center font-800">social post</h6>
                            </div>
                        </div>
                    </a>
                </div>
            
            
                <div class="mt-5 all-channels-width pt-3 pt-lg-0">
                    <a href="#messaging-api" class="scrolly">
                        <div class="card bg-black h-100 mx-2 justify-content-center">
                            <div class="cricle_bg text-center">
                                <i class="fntlo icon-messaging-api-icon color-gradient"></i>
                            </div>
                            <div class="py-3 px-1 card-feature-text">
                                <h6 class="text-uppercase text-white mb-0 text-center font-800">messaging api</h6>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="mt-5 all-channels-width pt-3 pt-lg-0">
                    <a href="#personalised-message" class="scrolly">
                        <div class="card bg-black h-100 mx-2 justify-content-center">
                            <div class="cricle_bg text-center">
                                <i class="fntlo icon-personalised-messaging-icon color-gradient"></i>
                            </div>
                            <div class="py-3 px-1 card-feature-text">
                                <h6 class="text-uppercase text-white mb-0 text-center font-800">personalised messaging</h6>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section> 
<section id="multiple-channels">
    <div class="bg-color my-5">
        <div class="container">
            <div class="text-center py-3">
                <h3 class="text-white font-800 mx-auto" style="max-width: 950px;">Here is a simple description for you to understand our features</h3>
            </div>
        </div>
    </div>
</section>
<section id="features-description">
    <div class="py-5">
        <div class="container">
            {{-- instant challenge --}}
            <div id="instant-challenge" class="feature-des-instant-challenge mb-5">
                <h3 class="font-800 text-center mb-5 h2 text-capitalize">How instant challenge works</h3>
                <div class="row justify-content-between align-items-center">
                    <div class="col-12 col-md-6">
                        <div class="fd-instant-challenge-desc">
                            <h5 class="font-700">1) Ask your happy customers to take challenge</h5>
                            <p class="text-muted">When a customer is at your store online or offline, just before payment ask them to take an MouthPublicity.io in exchange for a gift or discount to like, follow or share your page or post on different social media platforms (Facebook, Instagram, Twitter, LinkedIn, YouTube, Google Review).</p>
                        </div>
                    </div>
                    <div class="col-12 col-md-5">
                        <div class="fd-challenge-img">
                            <img src="{{ asset('assets/website/images/how-it-works/feature-instantchallenge-img1.png') }}" alt="Ask your happy customers">
                        </div>
                    </div>
                </div>
                <div class="down-arrow text-center my-3">
                    <img src="{{ asset('assets/website/images/how-it-works/down-arrow.png') }}" alt="Arrow" class="dw-arrow">
                    <img src="{{ asset('assets/website/images/how-it-works/down-ar.png') }}" alt="Arrow" class="down-ar">
                </div>
                <div class="mt-3 mt-md-0">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-12 col-md-6 order-md-2">
                            <div class="fd-instant-challenge-desc">
                                <h5 class="font-700">2) Create & Customise the offers/discounts</h5>
                                <p class="text-muted">You can create challenges with MouthPublicity.io and decide the number of tasks to be completed by the customer so that they can avail the gift or discount.</p>
                                <p class="text-muted">For example, there are 7 activities in the options and if you offer to give 10% discount on completing 2 tasks, then if the customer likes your facebook page and shares your instagram post, then the 2 tasks are completed and the customer qualifies for the 10% discount through a redeem code.</p>
                            </div>
                        </div>
                        <div class="col-12 col-md-5 order-md-1">
                            <div class="fd-challenge-img text-md-end">
                                <img src="{{ asset('assets/website/images/how-it-works/feature-instantchallenge-img2.png') }}" alt="Create & Customise the offers">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="down-arrow text-center mt-0 mt-md-3 my-3">
                    <img src="{{ asset('assets/website/images/how-it-works/down-arrow-two.png') }}" alt="" class="dw-arrow">
                    <img src="{{ asset('assets/website/images/how-it-works/down-ar.png') }}" alt="" class="down-ar">
                </div>
                <div class="mt-3 mt-md-0">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-12 col-md-6">
                            <div class="fd-instant-challenge-desc">
                                <h5 class="font-700">3) Track & Confirmed the task completion by customers</h5>
                                <p class="text-muted">All actions are monitored by MouthPublicity.io to make sure the tasks in the challenges are completed correctly and successfully.</p>
                            </div>
                        </div>
                        <div class="col-12 col-md-5">
                            <div class="fd-challenge-img">
                                <img src="{{ asset('assets/website/images/how-it-works/feature-instantchallenge-img3.png') }}" alt="Track & Confirmed the task completion">
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
        {{-- share challenge --}}
        <div id="share-challenge" class="bg-feature py-5">
            <div class="container">
                <div class="feature-des-share-challenge">
                    <h3 class="font-800 text-center h2 mb-5 text-capitalize">How share challenge works</h3>
                    <div class="row justify-content-between align-items-center">
                        <div class="col-12 col-md-6">
                            <div class="fd-share-challenge-desc">
                                <h5 class="font-700">1) Send Share Challenge to the same customer on scheduled time</h5>
                                <p class="text-muted">When a customer avails an Instant Challenge or any message using MouthPublicity.io API integrated with your billing software , then just set the time at which you want the Share Challenge to be sent to the customers. The challenge can be shared individually or in groups.</p>
                            </div>
                        </div>
                        <div class="col-12 col-md-5">
                            <div class="fd-challenge-img">
                                <img src="{{ asset('assets/website/images/how-it-works/feature-sharechallenge-img1.png') }}" alt="Send Share Challenge to the same">
                            </div>
                        </div>
                    </div>
                    <div class="down-arrow text-center my-3">
                        <img src="{{ asset('assets/website/images/how-it-works/down-arrow.png') }}" alt="arrow" class="dw-arrow">
                        <img src="{{ asset('assets/website/images/how-it-works/down-ar.png') }}" alt="arrow" class="down-ar">
                    </div>
                    <div class="mt-3 mt-md-0">
                        <div class="row justify-content-between align-items-center mt-2 mt-sm-0">
                            <div class="col-12 col-md-6 order-md-2">
                                <div class="fd-share-challenge-desc">
                                    <h5 class="font-700">2) Let customers complete the challenge by sharing the link in their personal networks</h5>
                                    <p class="text-muted">A link will be sent through Share Challenge in which you will ask your customer to share the link in their personal network ( family,friends etc.) and based on the number of clicks and target set, the customer will get a discount, gift or a cashback.</p>
                                    <p class="text-muted">For example if the customer brings 10 clicks and the amount per click set by you is 10 rupees per click, then the customer will get 100 rupees off on their next purchase.</p>
                                    <p class="text-muted">It is important to note that the customer will only get the discount if the challenge is completed and they buy something from the store.</p>
                                    <p class="text-muted"> The total number of clicks are monitored in the dashboard.</p>
                                </div>
                            </div>
                            <div class="col-12 col-md-5 order-md-1">
                                <div class="fd-challenge-img text-md-end">
                                    <img src="{{ asset('assets/website/images/how-it-works/feature-sharechallenge-img2.png') }}" alt="Let customers complete the challenge">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Social post --}}
        <div class="container">
            <div id="social-post" class="feature-des-social-post py-5">
                <h3 class="font-800 text-center h2 mb-5 text-capitalize">How social post works</h3>
                <div class="row justify-content-between align-items-center">
                    <div class="col-12 col-md-6">
                        <div class="fd-social-post-desc">
                            <h5 class="font-700">1) Connect & Manage your social media accounts with MouthPublicity.io</h5>
                            <p class="text-muted">Connect social media accounts with MouthPublicity.io using the social post channel to easily manage social media campaigns and you can easily check if the content is scheduled, unscheduled or posted.</p>
                        </div>
                    </div>
                    <div class="col-12 col-md-5">
                        <div class="fd-challenge-img">
                            <img src="{{ asset('assets/website/images/how-it-works/feature-socialpost-img1.png') }}" alt="Connect & Manage your social media">
                        </div>
                    </div>
                </div>
                <div class="down-arrow text-center my-3">
                    <img src="{{ asset('assets/website/images/how-it-works/down-arrow.png') }}" alt="arrow" class="dw-arrow">
                    <img src="{{ asset('assets/website/images/how-it-works/down-ar.png') }}" alt="arrow" class="down-ar">
                </div>
                <div class="mt-3 mt-md-0">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-12 col-md-6 order-md-2">
                            <div class="fd-social-post-desc">
                                <h5 class="font-700">2) Publish & Schedule the created content on social media channels from Single Dashboard</h5>
                                <p class="text-muted">Design your content for social media using our templates and post it on Twitter, Facebook etc. simultaneously at the same time with a single click or schedule it for automatic post and start your campaign on a pre-decided date.</p>
                            </div>
                        </div>
                        <div class="col-12 col-md-5 order-md-1">
                            <div class="fd-challenge-img text-md-end">
                                <img src="{{ asset('assets/website/images/how-it-works/feature-socialpost-img2.png') }}" alt="Publish & Schedule the created content">
                            </div>
                        </div>
                    </div>
                </div>    
                <div class="down-arrow text-center mt-0 mt-md-3 my-3">
                    <img src="{{ asset('assets/website/images/how-it-works/down-arrow-two.png') }}" alt="arrow" class="dw-arrow">
                    <img src="{{ asset('assets/website/images/how-it-works/down-ar.png') }}" alt="arrow" class="down-ar">
                </div>
                <div class="mt-3 mt-md-0">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-12 col-md-6">
                            <div class="fd-social-post-desc">
                                <h5 class="font-700">3) Track the Insights & See how well you’re doing on Social Media</h5>
                                <p class="text-muted">Use our dashboard to track all insights and statistics to evaluate and compare the performance of your posts based on clicks, like, share etc. among all social media platforms.</p>
                            </div>
                        </div>
                        <div class="col-12 col-md-5">
                            <div class="fd-challenge-img">
                                <img src="{{ asset('assets/website/images/how-it-works/feature-socialpost-img3.png') }}" alt="Track the Insights">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Messaging API --}}
        <div id="messaging-api" class="bg-feature py-5">
            <div class="container">
                <div class="feature-des-messaging-api">
                    <h3 class="font-800 text-center h2 mb-5 text-capitalize">How to integrate messaging api & send automated messages</h3>
                    <div class="row justify-content-between align-items-center">
                        <div class="col-12 col-md-6">
                            <div class="fd-messaging-api-desc">
                                <h5 class="font-700">1) Simply Integrate Message API with your POS or Billing System</h5>
                                <p class="text-muted">Just integrate your current billing software with our Messaging API to send messages. You can use the API to send messages on both WhatsApp and SMS and you can also switch between them according to your requirement.</p>
                            </div>
                        </div>
                        <div class="col-12 col-md-5">
                            <div class="fd-challenge-img">
                                <img src="{{ asset('assets/website/images/how-it-works/feature-messagingapi-img1.png') }}" alt="Simply Integrate Message API">
                            </div>
                        </div>
                    </div>
                    <div class="down-arrow text-center my-3">
                        <img src="{{ asset('assets/website/images/how-it-works/down-arrow.png') }}" alt="arrow" class="dw-arrow">
                        <img src="{{ asset('assets/website/images/how-it-works/down-ar.png') }}" alt="arrow" class="down-ar">
                    </div>
                    <div class="mt-3 mt-md-0">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-12 col-md-6 order-md-2">
                                <div class="fd-messaging-api-desc">
                                    <h5 class="font-700">2) Send Automated WhatsApp/SMS to your customers</h5>
                                    <p class="text-muted">Use the simple copy and paste method to integrate the API or you can contact your billing software vendor for API integration.</p>
                                    <p class="text-muted">After a successful API Integration, the messages will be automatically sent to the customers after their billing. The message content will be decided by you and you can share billing details, invoice, offers or business updates to the customers.</p>
                                </div>
                            </div>
                            <div class="col-12 col-md-5 order-md-1">
                                <div class="fd-challenge-img text-md-end">
                                    <img src="{{ asset('assets/website/images/how-it-works/feature-messagingapi-img2.png') }}" alt="Send Automated WhatsApp/SMS">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- personalised messaging --}}
        <div class="container">
            <div id="personalised-message" class="feature-des-personalised-msg py-5">
                <h3 class="font-800 text-center h2 mb-5 text-capitalize">How personalised messaging works</h3>
                <div class="row justify-content-between align-items-center">
                    <div class="col-12 col-md-6">
                        <div class="fd-personalised-msg-desc">
                            <h5 class="font-700">1) Customise, Write & Save message templates</h5>
                            <p class="text-muted">Select a ready-made message template from the personalised messaging channel or create and add your own message. You can select the exact date and time at which you want your message to be shared with the customers.</p>
                        </div>
                    </div>
                    <div class="col-12 col-md-5">
                        <div class="fd-challenge-img">
                            <img src="{{ asset('assets/website/images/how-it-works/feature-personalisedmsg-img1.png') }}" alt="Customise, Write & Save message">
                        </div>
                    </div>
                </div>
                <div class="down-arrow text-center my-3">
                    <img src="{{ asset('assets/website/images/how-it-works/down-arrow.png') }}" alt="arrow" class="dw-arrow">
                    <img src="{{ asset('assets/website/images/how-it-works/down-ar.png') }}" alt="arrow" class="down-ar">
                </div>
                <div class="mt-3 mt-md-0">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-12 col-md-6 order-md-2">
                            <div class="fd-personalised-msg-desc">
                                <h5 class="font-700">2) Set Alerts, Offers, New Arrivals, BirthDay, Anniversary Messages on Autopilot</h5>
                                <p class="text-muted">The message will consist of an ongoing or an upcoming offer or business updates along with any of these greetings like birthday wish, anniversary wish or a festive greeting. You can send a personalised message individually or in groups.</p>
                            </div>
                        </div>
                        <div class="col-12  col-md-5 order-md-1">
                            <div class="fd-challenge-img text-md-end">
                                <img src="{{ asset('assets/website/images/how-it-works/feature-personalisedmsg-img2.png') }}" alt="Messages on Autopilot">
                            </div>
                        </div>
                    </div>
                </div>    
                <div class="down-arrow text-center my-3">
                    <img src="{{ asset('assets/website/images/how-it-works/down-arrow-two.png') }}" alt="arrow" class="dw-arrow">
                    <img src="{{ asset('assets/website/images/how-it-works/down-ar.png') }}" alt="arrow" class="down-ar">
                </div>
                <div class="mt-3 mt-md-0">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-12 col-md-6">
                            <div class="fd-personalised-msg-desc">
                                <h5 class="font-700">3) Keep track of message delivery rates & status</h5>
                                <p class="text-muted">You can get the status of your message to see if the message is active, failed or in process. You can also view the message history to keep a record of the shared messages.</p>
                            </div>
                        </div>
                        <div class="col-12 col-md-5">
                            <div class="fd-challenge-img">
                                <img src="{{ asset('assets/website/images/how-it-works/feature-personalisedmsg-img3.png') }}" alt="Keep track of message delivery">
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
    </div>
    <div class="container mb-5">
        <div class="bg-color-gradient query-sec">
            <p class="font-600 py-4 px-3">If you have any queries, just contact us on <a href="tel:7887882244" class="text-decoration-none text-white">7887882244</a> or <a href="mailto:care@mouthpublicity.io" class="text-decoration-none text-white">care@mouthpublicity.io</a></p>
        </div>
    </div>
</section>
@endsection

@push('js')
    {{-- typed js (for typing effect) --}}
    <script src="{{ asset('assets/website/vendor/typed/js/typed.min.js') }}"></script>
    {{-- Owl carousel --}}
    <script src="{{ asset('assets/website/vendor/owl.carousel/js/owl.carousel.min.js') }}"></script>
    <script>
        $('.scrolly').click(function() {
            $('html, body').animate({
                    scrollTop: $($(this).attr('href')).offset().top - 75
                }, 700);
                return false;
        });
    </script>
@endpush

@push('end_body')

@endpush