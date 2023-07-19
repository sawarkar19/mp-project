@extends('layouts.website')
@section('title', 'Schdeule, Post & Track on multiple social media channels at one place for free.')
@section('description', 'Ease your content post management with MouthPublicity.io\'s social post tool. Keep track on your multiple posts of different socia media channels. Use it for Free Now. ')
{{-- @section('keywords', 'MouthPublicity.io blogs, MouthPublicity.io news, MouthPublicity.io updates') --}}
@section('image', asset('assets/website/images/products/social-posts/socialpost-banner.png'))

@section('end_head')
<style>
    .view_pricing_btn{
        width: 17.5rem;
        max-width: 100%;
    }
    #Cards .card-img-top{
        border-radius: 0.375rem;
    }
    .banner_bg{
        background: rgba(255, 255, 255, 1) linear-gradient(180deg,  rgba(255, 255, 255, 1) 59%, rgba(128, 128, 128, 0.8) 100%) 0% 0% no-repeat padding-box;
        padding-bottom: 160px;
    }
    .box_position{
        position: relative;
        top: -72px;
    }
    
    .hiw-steps{
        /* border: 1px solid #707070; */
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
        /* top: -74px; */
        background: rgba(var(--color-two), 1) linear-gradient(140deg, rgba(var(--color-two), 1) 0%, rgba(var(--color-one), 1) 100%) 0% 0% no-repeat padding-box;
    }
    .steps-number h4{
        line-height: 5.938rem; 
        /* font-family: Space Boards;  */
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
        left: 33%;
    }
    .hiw-steps-img_right{
        position: absolute;
        right: 33%;
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
        font-size: 10.25rem;
        color: rgba(206, 206, 206, 1);
    }
    .diagonal-arrow-left-HIW{
        position: relative;
        left: 9%;
    }
    .diagonal-arrow-right-HIW{
        position: relative;
        right: 58%;
    }
    .diagonal-arrow-left-HIW::before{
        position: absolute;
        top: 105px;
        transform: rotate(180deg);
    }
    .diagonal-arrow-right-HIW::before{
        position: absolute;
        top: 105px;
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
    .task_btn button{
        background: rgba(255, 255, 255, 1);
    }
    .task_btn button:hover{
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
    @media(max-width:991px){
        .hiw-steps{
            max-width: 400px;
        }
        .hiw-steps-img{
            max-width: 624px;
        }
        .diagonal-arrow, .diagonal-arrow-left-HIW, .diagonal-arrow-right-HIW{
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


</style>
@endsection

@section('content')
{{-- Banner Section --}}
<section id="banner">
    <div class="pt-5 position-relative">
        <div class="banner_bg pt-4">
            <div class="container">
                <div class="row justify-content-between align-items-center">
                    <div class="col-lg-5 order-lg-2">
                        <div class="">
                            <img src="assets/images/home-banner.svg" class="img-fluid" alt="">
                        </div>
                    </div>
                    <div class="col-lg-6 mb-5 mb-lg-0 order-lg-1">
                        <div class="banner-block pe-xl-5">
                            <h5 class="mb-5 text-uppercase h2 font-900 color-primary">SOCIAL MEDIA POSTING</h1>
                            <p class="mb-4">Post your content from a single dashboard across different social channels and keep track of the clicks, shares, comments, and more.</p>
                            <div>
                                <button class="btn px-4 btn-primary-ol view_pricing_btn py-2">View Pricing</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
        <div class="container">
            <div class="box_position">
                <div class="row justify-content-center">
                    <div class="col-sm-6 col-md-5 col-lg-4">
                        <div class="card h-100 bg-dark">
                            <div class="p-3">
                                <img src="{{ asset('assets/trash/dummy_box.png') }}" class="card-img-top" alt="img1"> 
                            </div>
                            <div class="card-body h-100 text-white">
                                <h5 class="card-text font-600 h3">The Social Media Posting Tool To Get The Exact Count Of The Total Number Of Clicks, Your Post Has Received On Social Media</h5>
                            </div>
                        </div>
                    </div> 
                    <div class="col-sm-6 col-md-5 col-lg-4 mt-4 mt-sm-0">
                        <div class="card h-100 bg-dark">
                            <div class="p-3">
                                <img src="{{ asset('assets/trash/dummy_box.png') }}" class="card-img-top" alt="img2">
                            </div>
                            <div class="card-body h-100 text-white">
                                <h5 class="card-text font-600 h3">Calculate The Reach Of Your Posts By Getting Accurate Insights And Monitor The Social Media Activity Done By Your Customers</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center mt-4">
                    <div class="col-sm-6 col-md-5 col-lg-4">
                        <div class="card h-100 bg-dark">
                            <div class="p-3">
                                <img src="{{ asset('assets/trash/dummy_box.png') }}" class="card-img-top" alt="img3"> 
                            </div>
                            <div class="card-body h-100 text-white">
                                <h5 class="card-text font-600 h3">Manage Your Social Media Account And Simplify Your Day-To-Day Social Media Activities For Free</h5>
                            </div>
                        </div>
                    </div> 
                    <div class="col-sm-6 col-md-5 col-lg-4 mt-4 mt-sm-0">
                        <div class="card h-100 bg-dark">
                            <div class="p-3">
                                <img src="{{ asset('assets/trash/dummy_box.png') }}" class="card-img-top" alt="img4">
                            </div>
                            <div class="card-body h-100 text-white">
                                <h5 class="card-text font-600 h3">Track Social Media And Schedule Your Social Media Posting As Per Your Convenience</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center mt-4">
                    <div class="col-sm-6 col-md-5 col-lg-4">
                        <div class="card h-100 bg-dark">
                            <div class="p-3">
                                <img src="{{ asset('assets/trash/dummy_box.png') }}" class="card-img-top" alt="img5"> 
                            </div>
                            <div class="card-body h-100 text-white">
                                <h5 class="card-text font-600 h3">Get Detailed Analytics About Your Business On Multiple Social Media Platforms</h5>
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
                <h4 class="text-white font-800 h1 mb-0">HOW IT WORKS</h4>
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
                            <h5 class="text-white text-center font-700">Create Offers From Templates</h5>
                        </div>
                        <div class="hiw-steps-dis">
                            <p class="text-center p-4 mb-0">Create the content you want to post on your social media page and save the content to use whenever you want to post</p>
                        </div>
                    </div>
                </div>
                <div class="diagonal-arrow diagonal-arrow-left-HIW"></div>
                <div class="hiw-steps-img hiw-steps-img_left mt-5 mt-md-0">
                    <img src="{{ asset('assets/trash/dummy_img2.png') }}" class="img-fluid" alt="">
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
                            <h5 class="text-white text-center font-700">Setup Custom Rewards</h5>
                        </div>
                        <div class="hiw-steps-dis">
                            <p class="text-center p-4 mb-0">Post the saved content on multiple social media channels (Twitter, Facebook, LinkedIn) in just one click.</p>
                        </div>
                    </div>
                </div>
                <div class="diagonal-arrow diagonal-arrow-right-HIW"></div>
                <div class="hiw-steps-img hiw-steps-img_right mt-5 mt-md-0">
                    <img src="{{ asset('assets/trash/dummy_img2.png') }}" class="img-fluid" alt="">
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
                            <h5 class="text-white text-center font-700">Share The Offer Link To Customers</h5>
                        </div>
                        <div class="hiw-steps-dis">
                            <p class="text-center p-4 mb-0">You will get the exact number of clicks your post has got on social media. Watch your social media likes followers and overall engagement increase and then decide what works best as per the target</p>
                        </div>
                    </div>
                </div>
                <div class="hiw-steps-img hiw-steps-img_left mt-5 mt-md-0">
                    <img src="{{ asset('assets/trash/dummy_img2.png') }}" class="img-fluid" alt="">
                </div>
            </div>
            
        </div>
    {{--HIW Section three end--}}
</section>


{{-- video Section --}}
<section id="video">
    <div class="container">
        <div class="video_section text-center my-5 py-5">
            <iframe class="video" src="https://www.youtube.com/embed/qX2P0DNFiiM" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    </div>
</section>


{{--  Give Your Customers A Simple Task  Section --}}
<section id="task">
    <div class="bg_dark">
        <div class="container-md">
            <div class="px-3 py-5 px-sm-5">
                <h4 class="text-white text-center font-700 h2 pb-3">Give Your Customers A Simple Task To Follow Or Like Your Page</h4>
                <div class="row justify-content-between align-items-center mt-5">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="task_content">
                            <h4 class="h1 text-white font-700 mb-4">Personalised Greeting</h4>
                            <p class="text-white mb-4">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim</p>
                            <div class="task_btn">
                                <button class="btn btn-link-ol px-5 py-2">Learn More</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-4">
                        <div class="mt-4 mt-md-0">
                            <img src="{{ asset('assets/trash/dummy_box.png') }}"  alt="" style="width:400px; max-width:100%; border-radius:12px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Social Media Engagement  Section --}}
<section id="social_media_eng">
    <div class="container">
        <div class="my-5 social_media_eng pt-5 mx-auto">
            <h4 class="social_media_head text-center font-700 mb-5">INCREASE Traffic, Social Media Engagement & Revenue WHEN your Customers like, share, subscribe, and follow on SOCIAL MEDIA</h4>
            <div style="max-width: 450px; margin:auto;">
                <form action="#" method="post">
                    <div class="form-group mb-3">
                        <input type="email" name="email" id="social_media_mail" class="form-control btn_border p-3" placeholder="Enter Your Email ID..." required>
                    </div>
                    <div class="text-center">
                        <button class="btn px-5 py-2 btn-primary-ol mt-4" style="font-size: 20px;">learn More</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>


{{--who is it for section--}}
<section id="who_is_it_for">
    <div class="py-5">
        <div class="container">
            <div class="gradient-box who-is-it-for">
                <div class="inner">
                    <div class="text-center mb-5">
                        <h2 class="text-uppercase font-900 text-white">who is it for</h2>
                        <h6 class="text-uppercase font-400 text-white sub-heading">anyone can use it like</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> 


@endsection