@extends('layouts.website')
@section('title', 'Messaging API for Free- Integrate & Send Automated SMS and WhatsApp')
@section('description', 'Keep your customers connected with you by sending them automated messages using our Messaging API for Free.')
{{-- @section('keywords', 'MouthPublicity.io blogs, MouthPublicity.io news, MouthPublicity.io updates') --}}
@section('image', asset('assets/website/images/products/messaging-api/messagingApi-banner.png'))

@section('end_head')
<style>
    .view_pricing_btn{
        width: 17.5rem;
        max-width: 100%;
    }
    
    .hiw-steps{
        border-radius: 50px;
        max-width: 400px;
        position: relative;
        background: transparent;
    }
    .hiw-steps::before{
        content: '';
        background: rgba(var(--color-two), 1) linear-gradient(135deg, rgba(var(--color-two), 1) 0%, rgba(var(--color-one), 1) 100%) 0% 0% no-repeat padding-box;
        position: absolute;
        top: 65px;
        bottom: 40px;
        width: 100%;
        border-radius: 1rem;
        z-index: 1;
    }
    .hiw-steps .inner{
        padding: 0 1.5rem;
        position: relative;
        z-index: 2;
    }
    .steps-number{
        width: 130px;
        height: 130px;
        border-radius: 50%;
        padding: 12px 12px 0 12px;
        margin: auto;
        position: relative;
        background: rgba(var(--color-two), 1) linear-gradient(140deg, rgba(var(--color-two), 1) 0%, rgba(var(--color-one), 1) 100%) 0% 0% no-repeat padding-box;
    }
    .steps-number h4{
        line-height: 5.938rem; 
        font-size:3.75rem;
        border: 6px solid rgba(255, 255, 255, 1);
        border-radius: 50%;
    }
    .hiw-steps-dis{
        background: rgba(255, 255, 255, 1);
        box-shadow: 0px 0px 10px #0000008F;
        border-radius: 2.25rem;
        padding: 0.5rem;
        position: relative;
    }
    .hiw-steps-dis p{
        background: rgba(255, 255, 255, 1);
        box-shadow: 0px 0px 56px #0000008F;
        border-radius: 1.813rem;
        min-height: 210px;
    }
    .hiw-steps-img{
        max-width:624px;
    }
    .hiw-steps-img_left{
        position: absolute;
        left: 36%;
    }
    .hiw-steps-img_right{
        position: absolute;
        right: 36%;
    }
    .diagonal-arrow{
        position: relative;
        font-family: 'bootstrap-icons';
        z-index: 3;
    }
    .diagonal-arrow::before,
    .diagonal-arrow-right::before{
        content: '\F13F';
        position: absolute;
        margin: 0.625rem;
        font-size: 6.25rem;
        color: rgba(206, 206, 206, 1);
    }
    .diagonal-arrow-left{
        position: relative;
        left: 9%;
    }
    .diagonal-arrow-right{
        position: relative;
        right: 58%;
    }
    .diagonal-arrow-left::before{
        position: absolute;
        top: 185px;
        transform: rotate(180deg);
    }
    .diagonal-arrow-right::before{
        position: absolute;
        top: 168px;
        transform: rotate(270deg);
    }
    .video_section .video{
        width: 1024px;
        max-width: 100%;
        height: 600px;
        margin: auto;
        border-radius: 0.8rem;
    }
    .bg_dark{
        background:rgba(0, 0, 0, 1) linear-gradient(122deg, rgba(0, 0, 0, 1) 28%, rgba(84, 84, 84, 1) 100%) 0% 0% no-repeat padding-box;
    }
    .task_btn a{
        background: rgba(255, 255, 255, 1);
    }
    .task_btn a:hover{
        background: rgba(255, 255, 255, 1);
    }
    .social_media_head{
        color: rgba(25, 122, 164, 1);
    }
    .btn_border{
        border: 2px solid rgba(11, 70, 158, 1);
        border-radius: 10px;
    }
    .hiw-container{
        width: 1040px;
        max-width: 100%;
        margin: auto;
        position: relative;
    }
    .hiw-flex{
        display: flex;
        align-items: center;
    }
    .hiw-container:nth-child(odd) .hiw-flex{
        justify-content: flex-start;
    }
    .hiw-container:nth-child(even) .hiw-flex{
        justify-content: flex-end;
    }
    .social_media_eng{
        width: 1024px;
        max-width: 100%;
    }
    .messagingApi-banner img, .hiw-steps-img img{
        width: 500px;
    }
    .messaging-api .card-section .card-section-inner{
        background: transparent;
        border-radius: 8px;
        width: calc(100% - 30px);
        margin: 15px auto 30px auto;
        padding-top: 42%;
    }
    .messaging-api .card-section .card-section-inner img{
        position: absolute;
        width: 100%;
        left: 0;
        right: 0;
        bottom: 0;
    }
    .task-image img{
        width: 330px;
    }
    .ma-card-lineHeight{
        line-height: 27px;
    }
    @media(max-width:991px){
        .hiw-steps{
            max-width: 400px;
        }
        .hiw-steps-img{
            max-width: 624px;
        }
        .diagonal-arrow, .diagonal-arrow-left, .diagonal-arrow-right{
            display: none;
        }
        .hiw-steps-img_left{
            left: 44%;
        }
        .hiw-steps-img_right{
            right: 44%;
        }
        .banner_bg{
            padding-bottom: 70px;
        }
    }
    @media(max-width:767px){
        .hiw-steps{
            max-width: 100%;
        }
        .hiw-steps-img{
            position: relative;
            max-width: 100%;
            left: 0;
            text-align: center
        }
        .hiw-flex{
            display: block !important;  
        }

    }
    @media(max-width: 574px){
        .messaging-api .card-section{
            height: auto !important;
        }
        /* .messaging-api .card-section .card-section-inner{
            padding-top:50%;
        }
        .messaging-api .card-section .card-section-inner:first-child{
            padding-top: 42%;
        } */
        .banner_bg{
            padding-bottom: 25%;
        }
        .box_position {
            top: -100px;
        }
        
    }


</style>
@endsection

@section('content')
{{-- Banner Section --}}
<section id="banner">
    <div class="pt-5x bg-dots position-relative">
        <div class="container">
            {{-- Breadcrumb Section --}}
            @php
                $bcrm = array(
                    array('name' => 'Products', 'link' => false),
                    array('name' => 'Messaging API', 'link' => false),
                );
            @endphp
            @include('website.components.breadcrumb', $bcrm)
        </div>
        <div class="py-5 mb-lg-5">
            <div class="container">
                <div class="row justify-content-between align-items-center">
                    <div class="col-lg-5 order-lg-2">
                        <div class="messagingApi-banner mb-4 mb-lg-0">
                            <img src="{{ asset ('assets/website/images/products/messaging-api/messagingApi-banner.png') }}"
                                class="img-fluid" alt="Messaging API">
                        </div>
                    </div>
                    <div class="col-lg-6 order-lg-1">
                        <div class="banner-block pe-xl-5">
                            <h1 class="mb-4 text-uppercase h2 font-900 color-primary">MESSAGING API</h1>
                                <p class="mb-4">Keep your customers connected with you by sending them automated
                                    messages using our Messaging API.</p>
                                <div>
                                    <a href="{{url('pricing')}}"
                                        class="btn px-4 btn-primary-ol view_pricing_btn py-2">View Pricing</a>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="messaging-api pt-5">
                <div class="row justify-content-center">
                    <div class="col-sm-6 col-md-5 col-lg-4 me-md-5 mb-5 mb-sm-0">
                        <div class="card card-section h-100 bg-dark position-relative">
                            <div class="px-3 position-relative card-section-inner">
                                <img src="{{ asset('assets/website/images/products/messaging-api/m-api-1.png') }}"
                                    class="card-img-top" alt="Send Exciting Offers">
                            </div>
                            <div class="card-body h-100 text-white pt-0 mb-sm-5">
                                <h5 class="card- text-capitalize ma-card-lineHeight">Send Exciting Offers To Your Customers
                                    Using Messaging Api/Sms Api To Make Them Come To Your Business Again And Again</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-5 col-lg-4 my-5 my-sm-0">
                        <div class="card card-section h-100 bg-dark position-relative">
                            <div class="px-3 position-relative card-section-inner">
                                <img src="{{ asset('assets/website/images/products/messaging-api/m-api-2.png') }}"
                                    class="card-img-top" alt="Give Your Brand A Strong Recall Value">
                            </div>
                            <div class="card-body h-100 text-white pt-0 mb-sm-5">
                                <h5 class="card-text text-capitalize ma-card-lineHeight">Give Your Brand A Strong Recall Value Through Messages Sent By Sms Api And Messaging Api.</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-5 col-lg-4 me-md-5 my-5 mt-sm-5 pt-md-5 my-sm-0">
                        <div class="card card-section h-100 bg-dark position-relative">
                            <div class="px-3 position-relative card-section-inner">
                                <img src="{{ asset('assets/website/images/products/messaging-api/m-api-3.png') }}"
                                    class="card-img-top" alt="Send Bulk Messages">
                            </div>
                            <div class="card-body h-100 text-white pt-0 mb-sm-5">
                                <h5 class="card-text text-capitalize ma-card-lineHeight">Send Bulk Messages Through Whatsapp
                                    Api/Sms Api To Your Customers For Free.</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-5 col-lg-4 my-5 my-sm-0 mt-sm-5 pt-md-5">
                        <div class="card card-section h-100 bg-dark position-relative">
                            <div class="px-3 position-relative card-section-inner">
                                <img src="{{ asset('assets/website/images/products/messaging-api/m-api-4.png') }}"
                                    class="card-img-top" alt="Integrate Messaging Api">
                            </div>
                            <div class="card-body h-100 text-white pt-0 mb-sm-5">
                                <h5 class="card-text text-capitalize ma-card-lineHeight">Integrate Messaging Api/Sms Api With
                                    Your Current Billing Software To Send Messages For Free</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-5 col-lg-4 me-md-5 my-5 my-sm-0 mt-sm-5 pt-md-5">
                        <div class="card card-section h-100 bg-dark position-relative">
                            <div class="px-3 position-relative card-section-inner">
                                <img src="{{ asset('assets/website/images/products/messaging-api/m-api-5.png') }}"
                                    class="card-img-top" alt="Send Billing Details">
                            </div>
                            <div class="card-body h-100 text-white pt-0 mb-sm-5">
                                <h5 class="card-text text-capitalize ma-card-lineHeight">Send Billing Details And Updates
                                    Through Messaging Api And Sms Api For Free.</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-5 col-lg-4"></div>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- how it works Section --}}
<section id="How_It_Works">
    <div class="bg-color-primary p-5 my-5">
        <div class="container-fluid">
            <div class="text-center">
                <h2 class="text-white font-800 h1 mb-0">HOW IT WORKS</h2>
            </div>
        </div>
    </div>
    {{--HIW Section one start--}}
    <div class="container">
        <div class="hiw-container mb-5">
            <div class="hiw-flex">
                <div class="hiw-steps">
                    <div class="inner">
                        <div class="steps-number">
                            <h4 class="text-white font-800 text-center">1</h4>
                        </div>
                        <div class="hiw-steps-head my-4">
                            <h5 class="text-white text-capitalize text-center font-700">Choose the integration method
                            </h5>
                        </div>
                        <div class="hiw-steps-dis">
                            <p class="text-center p-4 mb-0">Once you click on the Messaging API channel you just have to
                                select the method in which you want to integrate our API with the billing software you
                                already have. Two methods of integration are available in our Messaging API GET Method
                                and POST Method</p>
                        </div>
                    </div>
                </div>
                <div class="diagonal-arrow diagonal-arrow-left"></div>
                <div class="hiw-steps-img hiw-steps-img_left mt-5 mt-md-0">
                    <img src="{{ asset('assets/website/images/products/messaging-api/messagingAPi-HTW1.png') }}"
                        class="img-fluid" alt="Choose the integration method">
                </div>
            </div>

        </div>

        {{--HIW Section one end--}}
        {{--HIW Section Two start--}}
        <div class="hiw-container mb-5">
            <div class="hiw-flex">
                <div class="hiw-steps">
                    <div class="inner">
                        <div class="steps-number">
                            <h4 class="text-white font-800 text-center">2</h4>
                        </div>
                        <div class="hiw-steps-head my-4">
                            <h5 class="text-white text-capitalize text-center font-700">Simply copy and paste the API
                            </h5>
                        </div>
                        <div class="hiw-steps-dis">
                            <p class="text-center p-4 mb-0">Copy and paste our API URL at the place of your earlier API
                                URL. The messages will be sent exactly from the same medium through which they were
                                being sent. You can do the integration yourself by the simple copy and paste method or
                                you can contact your software vendor for API integration.</p>
                        </div>
                    </div>
                </div>
                <div class="hiw-steps-img hiw-steps-img_right mt-5 mt-md-0">
                    <img src="{{ asset('assets/website/images/products/messaging-api/messagingAPi-HTW2.png') }}"
                        class="img-fluid" alt="Simply copy and paste">
                </div>
            </div>
        </div>
        {{--HIW Section Two end--}}
</section>


{{-- video Section --}}
{{-- <section id="video">
    <div class="container">
        <div class="video_section text-center my-5 py-5">
            <iframe class="video" src="https://www.youtube.com/embed/qX2P0DNFiiM" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    </div>
</section> --}}


{{--  Give Your Customers A Simple Task  Section --}}
<section id="task">
    <div class="bg_dark">
        <div class="container-md">
            <div class="px-3 py-5 px-sm-5">
                <h4 class="text-white text-md-center text-capitalize font-700 h2 pb-3">Post on multiple social media platforms in a single click</h4>
                <div class="row justify-content-between align-items-center mt-3 mt-md-5">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="task_content">
                            <h4 class="h1 text-white font-700 mb-4">Social Post</h4>
                            <p class="text-white mb-4">Post your content from a single dashboard across different social channels and keep track of the clicks, shares, comments, and more.</p>
                            <div class="task_btn">
                                <a href="{{route('channels', 'social-post')}}" class="btn btn-link-ol px-5 py-2">Learn More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-4">
                        <div class="mt-4 mt-md-0 task-image">
                            <img src="{{ asset('assets/website/images/products/messaging-api/messagingAPI-task-section.png') }}"
                                alt="Social Post" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Social Media Engagement Section --}}
@include('website.components.product-cta-section', ['form_id' => 16, 'form_name' => 'messagingapilpform'])



{{-- Who is it for  --}}
@include('website.components.who-is-it-for')


@endsection