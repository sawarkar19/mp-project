@extends('layouts.website')
@section('title', 'Share Challenge - Get targeted clicks through your customers & grow.')
@section('description', 'Reward your existing customers with an offer or discount. Watch your rewarded customers bring new customers to you through the Share Challenge. Get Started Now.')
{{-- @section('keywords', 'MouthPublicity.io blogs, MouthPublicity.io news, MouthPublicity.io updates') --}}
@section('image', asset('assets/website/images/products/share-and-reward/ShareReward-banner.png'))

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
        min-height: 290px;
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
        top: 190px;
        transform: rotate(180deg);
    }
    .diagonal-arrow-right::before{
        position: absolute;
        top: 190px;
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
    .share-reward .card-section-inner{
        background: transparent;
        border-radius: 8px;
        width: calc(100% - 30px);
        margin: 15px auto 30px auto;
        padding-top: 42%;
    }
    .share-reward .card-section .card-section-inner img{
        position: absolute;
        width: 100%;
        left: 0;
        right: 0;
        bottom: 0;
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
    .share-reward-banner img, .hiw-steps-img img{
        width: 500px;
    }
    .task-image img{
        width: 330px;
    } 
    .sr-card-lineHeight{
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
    @media(min-width:768px) and (max-width:991px){
        .banner_bg{
            padding-bottom: 100px;
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
        .share-reward .card-section{
            height: auto !important;
        }
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
                    array('name' => 'Share Challenge', 'link' => false),
                );
            @endphp
            @include('website.components.breadcrumb', $bcrm)
        </div>
        <div class="py-5 mb-lg-5">
            <div class="container">
                <div class="row justify-content-between align-items-center">
                    <div class="col-lg-5 order-lg-2">
                        <div class="share-reward-banner mb-4 mb-lg-0">
                            <img src="{{ asset('assets/website/images/products/share-and-reward/share-reward-banner.png') }}"
                                class="img-fluid" alt="Share Challenge">
                        </div>
                    </div>
                    <div class="col-lg-6 order-lg-1">
                        <div class="banner-block pe-xl-5">
                            <h1 class="mb-4 text-uppercase h2 font-900 color-primary">Share Challenge</h1>
                                <p class="mb-4">Give your customers a challenge to share your offer in their personal network. Give your existing customers gifts and discounts. Watch your existing customers bring new customers to your business!</p>
                                <div>
                                    <a href="{{url('pricing')}}" class="btn px-4 btn-primary-ol view_pricing_btn py-2">View Pricing</a>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="pt-5 share-reward">
                <div class="row justify-content-center">
                    <div class="col-sm-6 col-md-5 col-lg-4 me-md-5 mb-5 mb-sm-0">
                        <div class="card card-section h-100 bg-dark position-relative">
                            <div class="px-3 position-relative card-section-inner">
                                <img src="{{ asset('assets/website/images/products/share-and-reward/share-reward-card-1.png') }}"
                                    class="card-img-top rounded" alt="Utilize the personal network">
                            </div>
                            <div class="card-body pt-0 h-100 text-white mb-sm-5">
                                <h5 class="card-text text-capitalize sr-card-lineHeight">Utilize the personal network of your
                                    customers to increase customer retention</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-5 col-lg-4 my-5 my-sm-0">
                        <div class="card card-section h-100 bg-dark position-relative">
                            <div class="px-3 position-relative card-section-inner">
                                <img src="{{ asset('assets/website/images/products/share-and-reward/share-reward-card-2.png') }}"
                                    class="card-img-top rounded" alt="A customer loyalty program">
                            </div>
                            <div class="card-body pt-0 h-100 text-white mb-sm-5">
                                <h5 class="card-text text-capitalize sr-card-lineHeight">A customer loyalty program to spread the word about your business to bring new customers</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-5 col-lg-4 me-md-5 my-5 my-sm-0 mt-sm-5 pt-md-5">
                        <div class="card card-section h-100 bg-dark position-relative">
                            <div class="px-3 position-relative card-section-inner">
                                <img src="{{ asset('assets/website/images/products/share-and-reward/share-reward-card-3.png') }}"
                                    class="card-img-top rounded" alt="Increase the popularity">
                            </div>
                            <div class="card-body pt-0 h-100 text-white mb-sm-5">
                                <h5 class="card-text text-capitalize sr-card-lineHeight">Increase the popularity of your business within and beyond your customer network with customised discount</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-5 col-lg-4 my-5 my-sm-0 mt-sm-5 pt-md-5">
                        <div class="card card-section h-100 bg-dark position-relative">
                            <div class="px-3 position-relative card-section-inner">
                                <img src="{{ asset('assets/website/images/products/share-and-reward/share-reward-card-4.png') }}"
                                    class="card-img-top rounded" alt="Send Challenge to your customers">
                            </div>
                            <div class="card-body pt-0 h-100 text-white mb-sm-5">
                                <h5 class="card-text text-capitalize sr-card-lineHeight">Send Challenge to your customers and provide them the advantage of attractive discounts</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-5 col-lg-4 my-5 me-md-5 my-sm-0 mt-sm-5 pt-md-5">
                        <div class="card card-section h-100 bg-dark position-relative">
                            <div class="px-3 position-relative card-section-inner">
                                <img src="{{ asset('assets/website/images/products/share-and-reward/share-reward-card-5.png') }}"
                                    class="card-img-top rounded" alt="Achieve loyalty marketing goals">
                            </div>
                            <div class="card-body pt-0 h-100 text-white mb-sm-5">
                                <h5 class="card-text text-capitalize sr-card-lineHeight">Achieve loyalty marketing goals with your own customers</h5>
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
                            <h5 class="text-white text-capitalize text-center font-700">Design Offers From Templates
                            </h5>
                        </div>
                        <div class="hiw-steps-dis">
                            <p class="text-center p-4 mb-0">Design multiple offers according to your needs using our
                                stunning readymade templates and choose the template suitable for the business. You can
                                also use social media links, business logos, and images to design an offer and set the
                                validity of the offer. Once the offer is created, save the offer to use it whenever you
                                want to launch a campaign.</p>
                        </div>
                    </div>
                </div>
                <div class="diagonal-arrow diagonal-arrow-left"></div>
                <div class="hiw-steps-img hiw-steps-img_left mt-5 mt-md-0">
                    <img src="{{ asset('assets/website/images/products/share-and-reward/shareReward-HTW1.png') }}"
                        class="img-fluid" alt="Design Offers">
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
                            <h5 class="text-white text-center text-capitalize font-700">Set up custom Discounts</h5>
                        </div>
                        <div class="hiw-steps-dis">
                            <p class="text-center p-4 mb-0">Create and set up the discount you want to give to the customers from various options available like the fixed offer, discounts, gifts, or cash per click. Select the offer and you can keep the offers updated as per the requirement to get your challenge program aligned and sorted.</p>
                        </div>
                    </div>
                </div>
                <div class="diagonal-arrow diagonal-arrow-right"></div>
                <div class="hiw-steps-img hiw-steps-img_right mt-5 mt-md-0">
                    <img src="{{ asset('assets/website/images/products/share-and-reward/shareReward-HTW2.png') }}"
                        class="img-fluid" alt="Set up custom Discounts">
                </div>
            </div>
        </div>
        {{--HIW Section Two end--}}
        {{--HIW Section three start--}}
        <div class="hiw-container mb-5">
            <div class="hiw-flex">
                <div class="hiw-steps">
                    <div class="inner">
                        <div class="steps-number">
                            <h4 class="text-white font-800 text-center">3</h4>
                        </div>
                        <div class="hiw-steps-head my-4">
                            <h5 class="text-white text-center text-capitalize font-700">Share The Offer Link To
                                Customers</h5>
                        </div>
                        <div class="hiw-steps-dis">
                            <p class="text-center p-4 mb-0">Use the redeem button on the active offer to enter basic
                                customer details and send redeem code to the customers. You only need to enter the name
                                and mobile numbers of your customers. After the details are entered the offer will be
                                shared directly with the customers in just one minute.</p>
                        </div>
                    </div>
                </div>
                <div class="diagonal-arrow diagonal-arrow-left"></div>
                <div class="hiw-steps-img hiw-steps-img_left mt-5 mt-md-0">
                    <img src="{{ asset('assets/website/images/products/share-and-reward/shareReward-HTW3.png') }}"
                        class="img-fluid" alt="Share The Offer Link">
                </div>
            </div>

        </div>
        {{--HIW Section three end--}}
        {{--HIW Section four start--}}
        <div class="hiw-container mb-5">
            <div class="hiw-flex">
                <div class="hiw-steps">
                    <div class="inner">
                        <div class="steps-number">
                            <h4 class="text-white font-800 text-center">4</h4>
                        </div>
                        <div class="hiw-steps-head my-4">
                            <h5 class="text-white text-center text-capitalize font-700">Let the customers do the sharing
                                happily</h5>
                        </div>
                        <div class="hiw-steps-dis">
                            <p class="text-center p-4 mb-0">The customers will share the offer link in their personal
                                network to achieve the target you have asked them to complete for the purpose of getting
                                an offer. This in turn will increase the mouth publicity of your business and will
                                attract potential customers to your business.</p>
                        </div>
                    </div>
                </div>
                <div class="diagonal-arrow diagonal-arrow-right"></div>
                <div class="hiw-steps-img hiw-steps-img_right mt-5 mt-md-0">
                    <img src="{{ asset('assets/website/images/products/share-and-reward/shareReward-HTW4.png') }}"
                        class="img-fluid" alt="sharing happily">
                </div>
            </div>
        </div>
        {{--HIW Section four end--}}
        {{--HIW Section five start--}}
        <div class="hiw-container mb-5">
            <div class="hiw-flex">
                <div class="hiw-steps">
                    <div class="inner">
                        <div class="steps-number">
                            <h4 class="text-white font-800 text-center">5</h4>
                        </div>
                        <div class="hiw-steps-head my-4">
                            <h5 class="text-white text-center text-capitalize font-700">Give discounts to the customers after they finish the challenge</h5>
                        </div>
                        <div class="hiw-steps-dis">
                            <p class="text-center p-4 mb-0">Once the given target is completed by the customers, they
                                will visit your business to get an offer from you. You just have to confirm their
                                details using a redeem code button on the created offer. The customer will share the
                                redeem code with you and can get the offer. This activity will attract potential
                                customers which in turn will bring new customers through existing customers to your
                                business.</p>
                        </div>
                    </div>
                </div>
                <div class="hiw-steps-img hiw-steps-img_left mt-5 mt-md-0">
                    <img src="{{ asset('assets/website/images/products/share-and-reward/shareReward-HTW5.png') }}"
                        class="img-fluid" alt="Give discounts">
                </div>
            </div>

        </div>
        {{--HIW Section five end--}}
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
                <h4 class="text-white text-md-center font-700 h2 text-capitalize pb-3">Give your customers a simple challenge to follow or like your page</h4>
                <div class="row justify-content-between align-items-center mt-3 mt-md-5">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="task_content">
                            <h4 class="h1 text-white font-700 mb-4">Instant Challenge</h4>
                            <p class="text-white mb-4">Give your customers a simple challenge to follow or like your page on multiple social media platforms and give them discounts as soon as they finish the challenge. Watch your social media engagement and followers grow like never before</p>
                            <div class="task_btn">
                                <a href="{{route('channels', 'instant-reward')}}" class="btn btn-link-ol px-5 py-2">Learn More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-4">
                        <div class="mt-4 mt-md-0 task-image">
                            <img src="{{ asset('assets/website/images/products/share-and-reward/share-reward-task-section.png') }}"
                                alt="Instant Challenge" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Social Media Engagement Section --}}
@include('website.components.product-cta-section', ['form_id' => 15, 'form_name' => 'sharerewardlpform'])



{{-- Who is it for  --}}
@include('website.components.who-is-it-for')

@endsection