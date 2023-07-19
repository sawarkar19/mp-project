@extends('layouts.website')

@section('title', $seo->title)
@section('description', $seo->description)
@section('image', $seo->image_path)
{{-- @section('keywords', $seo->keywords) --}}

@section('end_head')

@endsection

@push('css')
    <!-- Owl Carousel CSS (2) -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/website/vendor/owl.carousel/css/owl.carousel.min.css') }}" media="all">
    <link rel="stylesheet" href="{{ asset('assets/website/vendor/owl.carousel/css/owl.theme.default.css') }}" media="all"> --}}

    <style>
        @media(max-width:575px){
            .hb-head-font{
                font-size: 27px !important;
            }
        }
        /*---reward and instant tabs--*/
        .main_product_new .nav {
            flex-wrap: nowrap;
        }
        .main_product_new .nav-tabs .nav-link {
            color: rgba(var(--color-primary), 1);
            border: none!important;
            background-color: #EFEDED;
        }
        .main_product_new .nav-tabs .nav-link.active {
            color: rgb(var(--color-one));
        }
        
        .main_product_new .bg-light-grey,
        .main_product_new .nav-tabs .nav-link.active{
            /* background: #F5F5F5; */
            background: rgba(var(--color-one), .05);
        }
        .productBtn svg{
            width: 30px;
            height: 30px;
        }
        .main_product_new .tab-content {
            border-radius: 0px 8px 8px 8px;
        }
        .youtube_video{
            width: 100%;
            max-width: 970px;
            margin-left: auto;
            margin-right: auto;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
        }
        .youtube_video iframe{
            display: block;
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
            background-color: rgb(0,0,0, 0.7);
        }
        .video-btn .play-video {
            color: rgb(var(--color-primary));
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
            background: #FFFFFF;
        }
        .video-btn .play-video:hover {
            color: rgb(var(--color-one));
            transform:translate(-50%, -50%) scale(1.2);
        }
        .video-btn .play-video i {
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


        @media (min-width:576px) and (max-width:767px){
            .main_product_new .tab-content {
                border-radius: 0px 0px 8px 8px;
            }
        }
        @media(max-width:410px){
            .main_product_new .tab-content {
                border-radius: 0px 0px 8px 8px;
            }
        }
        @media(max-width:320px){
            .productBtn{
                font-size: 14px !important;
            }
        }
    </style>
@endpush

@section('content')
{{-- Banner Section --}}
<section id="banner">
    <div class="pb-5 bg-dots">
        <div class="container-fluid">
            <div class="row justify-content-end align-items-center">

                <div class="col-lg-5 order-lg-2 pe-lg-0">
                    <div class="">
                        {{-- <img src="assets/images/home-banner.svg" class="img-fluid" alt=""> --}}
                        {{-- <video width="100%" autoplay muted loop>
                            <source src="{{asset('assets/website/videos/MouthPublicity.io-story.mp4')}}" type="video/mp4">
                        </video> --}}
                        <video autoplay loop muted playsinline width="100%" poster="{{asset('assets/website/images/oc-video-screen-1.jpg')}}" src="{{asset('assets/website/videos/mp-story.mp4')}}">
                            <source src="{{asset('assets/website/videos/mp-story.mp4')}}" type="video/mp4"></source>
                        </video>
                    </div>
                </div>

                <div class="col-lg-6 mb-lg-0 order-lg-1">
                    <div class="banner-block pe-xl-5">

                        <h1 class="mb-3 text-capitalize font-900 hb-head-font color-primary" style="font-size: 3.1rem">Convert your customer to mouth publicity marketing team</h1>
                        {{-- <h1 class="mb-3 text-capitalize font-900 text-dark hb-head-font typed-heading-height color-primary" style="font-size: 3.1rem">Convert your customer into <span class="d-sm-block"><span class="typed"></span></span></h1> --}}
                        <p class="mb-4">Transform your customers into a marketing team with MouthPublicity.io - the only platform that lets you initiate, increase, track and manage word of mouth. Start your business free mouth publicity now instead waiting for it to happen.</p>

                        <div style="max-width: 350px;">
                            {{-- <form action="#" class="form-type-one" method="post">
                                <div class="form-group mb-3">
                                    <input type="email" name="email" id="started_email" class="form-control shadow" placeholder="Enter Your Email ID..." required>
                                </div>
                                <div>
                                    <button class="btn px-4 btn-primary-ol">Get Started for Free</button>
                                </div>
                            </form> --}}
                            <div>
                                <a href="{{url('signin?tab=register')}}" class="btn px-sm-5 px-4 py-2 btn-primary-ol" style="font-size: 24px !important;">Register For Free</a>
                            </div>
                            
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</section>
<section class="yt-video">
    <div class="pb-sm-3 pb-4">
        <div class="container">
            <div class="youtube_video mb-4">
                <div id="player"></div>
                {{-- <iframe src="https://www.youtube.com/embed/ACF6_JFgZm8?controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> --}}
                <div class="video-btn" id="playnow">
                    <a class="play-video" href="#">
                        <i class="bi bi-play-fill"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="main_product_new">
    <div class="py-sm-5 py-4">
        <div class="container">
            <div class="text-center mb-md-5 mb-4 mx-auto" style="max-width: 850px;">
                <h2 class="text-capitalize font-900">Give your customers a reason to share your brand with their personal & professional network</h2>
            </div>
            <div class="col-md-12">
                <div class="card border-0 p-0">
                <nav>
                    <div class="nav nav-tabs border-0 mb-0" id="nav-tab" role="tablist">
                        <button class="nav-link active font-900 px-sm-5 py-sm-3 productBtn" id="nav-instant-tab" data-bs-toggle="tab" data-bs-target="#nav-instant" type="button" role="tab" aria-controls="nav-instant" aria-selected="true">
                            <svg id="Group_3081" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 365.115 342.611">
                                <g id="Group_3068" fill="currentColor">
                                  <path id="Path_1058" data-name="Path 1058" d="M365.114,152.164c-2.954,6.067-7.862,8.126-14.5,8.106-46.522-.145-93.046-.076-139.569-.078-5.736,0-5.739-.007-5.74-5.9,0-11.868-.087-23.737.058-35.6.036-3.015-.711-4.192-3.956-4.149-12.459.167-24.923.142-37.383.013-2.947-.03-3.893.918-3.862,3.871.133,12.46-.051,24.924.123,37.383.048,3.444-1.081,4.453-4.475,4.446q-71.208-.135-142.417-.073c-8.637,0-13.205-4.6-13.225-13.174C.149,136.918.648,126.8.047,116.749-.756,103.326,8.54,90.7,26.018,90.815c20.887.13,41.776.029,62.664.029h4.8c-3.074-2.513-5.429-4.376-7.718-6.316-16.1-13.66-21.587-35.1-13.969-54.51C79.252,11.022,97.67-.809,118.813.392c13.341.758,24.938,5.865,33.469,16.5,13.443,16.756,23.508,35.3,28.784,56.264.722,2.867,1.229,5.779,1.848,8.81.341-2.095.573-4.213,1.039-6.28,5.287-23.43,15.911-44.389,32.23-61.752,13.156-14,30.482-16.933,48.633-11.1,17.405,5.594,28.009,18.105,31.289,35.978,3.756,20.462-3.94,36.687-20.346,49.059-.989.747-2.318,1.162-2.857,2.533,1.249.8,2.577.421,3.824.423q31.332.043,62.664.028c8.459.008,15.895,2.365,21.317,9.369,2,2.578,3.027,5.618,4.408,8.494ZM150.848,90.682c7.9.265,8.578-.437,8.174-6.4a18.717,18.717,0,0,0-.469-3.156c-4.521-18.466-12.388-35.281-24.869-49.752A22.675,22.675,0,0,0,116.759,23.5a23.944,23.944,0,0,0-22.9,15.034,24.56,24.56,0,0,0,6.369,27.323c9.713,8.571,21,14.582,32.836,19.59,6.331,2.679,12.829,4.96,17.783,5.239m61.468.226a56.746,56.746,0,0,0,5.614-.836A113.563,113.563,0,0,0,265.565,65.53c10.42-9.042,10.421-25.945.576-35.254a24.349,24.349,0,0,0-35.2,2.1c-9.142,10.575-15.189,22.871-20.15,35.778-2.045,5.319-3.876,10.73-4.288,16.466-.4,5.624.3,6.285,5.81,6.282" transform="translate(0 0)" />
                                  <path id="Path_1059" data-name="Path 1059" d="M163,284.485q0,37.573,0,75.145c0,4.9-.017,4.918-4.937,4.919q-53.777.009-107.554-.009c-15.108-.016-24.752-9.651-24.76-24.689q-.033-65.53-.005-131.06c0-4.684.057-4.755,4.8-4.756q63.749-.015,127.5,0c4.947,0,4.961.029,4.962,4.948q.008,37.751,0,75.5" transform="translate(-2.776 -22.012)" />
                                  <path id="Path_1060" data-name="Path 1060" d="M230.129,284.11q0-37.573,0-75.145c0-4.9.016-4.928,4.982-4.929q63.748-.012,127.5,0c4.715,0,4.776.079,4.777,4.775q.007,65.708-.01,131.416c-.011,14.539-9.777,24.287-24.419,24.307-36.089.051-72.177-.027-108.266.088-3.592.012-4.658-1.06-4.638-4.656.14-25.285.074-50.571.074-75.857" transform="translate(-24.82 -22.012)" />
                                </g>
                            </svg> 
                            <span class="d-block d-md-inline text-uppercase mt-1">&nbsp;Instant Challenge</span>
                        </button>
                        <button class="nav-link font-900 px-sm-5 py-sm-3 productBtn" id="nav-share-reward-tab" data-bs-toggle="tab" data-bs-target="#nav-share-reward" type="button" role="tab" aria-controls="nav-share-reward" aria-selected="false">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 265.479 254.198">
                                <g id="Group_3080" data-name="Group 3080" transform="translate(0)" fill="currentColor">
                                  <path id="Path_81" data-name="Path 81" d="M-320.573,26.912c-1.012,5.149-1.546,10.45-3.113,15.425-10.152,32.233-32.074,51.471-65.076,58.241a5.64,5.64,0,0,1-1.524.279c-6.207-.534-9.807,2.974-13.428,7.53A66.293,66.293,0,0,1-427.977,127.4c-1.534.711-1.878,1.522-1.747,3.146a113.85,113.85,0,0,0,25.372,63.433c.261.326.479.688.884,1.276H-503a18.767,18.767,0,0,1,1.029-1.612c14.667-18.6,23.237-39.609,25.084-63.3.107-1.363-.047-2.179-1.447-2.826-11.641-5.38-20.849-13.716-28.494-23.87a4.94,4.94,0,0,0-4.027-2.175c-38.972-2.8-71.337-34.422-74.675-73.3-.781-9.1-.458-18.3-.443-27.451.007-4.436,3.527-7.5,8.228-7.508,11.922-.03,23.843-.01,35.765-.01h3.137c0-2.42,0-4.707,0-6.994.011-5.348,3.167-8.556,8.529-8.556q76.972-.017,153.944,0c5.5,0,8.615,3.2,8.609,8.736,0,2.153,0,4.3,0,6.815h2.8c11.316,0,22.636.156,33.948-.073,4.821-.1,8.38,1.277,10.44,5.778ZM-438.15,77.41c5.63.082,9.281-4.2,8.506-9.151-.627-4-1.395-7.991-1.9-12.009a3.991,3.991,0,0,1,.941-2.868c2.781-2.952,5.774-5.7,8.606-8.607a7.346,7.346,0,0,0,1.965-7.846,7.486,7.486,0,0,0-6.346-5.372c-3.832-.621-7.661-1.27-11.51-1.747a3.614,3.614,0,0,1-3.252-2.37c-1.332-2.99-3.01-5.826-4.33-8.821-1.544-3.5-3.976-5.637-7.889-5.616s-6.285,2.236-7.812,5.73a94.659,94.659,0,0,1-4.552,9,4.388,4.388,0,0,1-2.606,1.935c-3.8.758-7.653,1.279-11.495,1.822a7.629,7.629,0,0,0-6.695,5.308c-1.145,3.33-.049,6.081,2.357,8.445,2.771,2.723,5.595,5.4,8.266,8.216a3.682,3.682,0,0,1,.873,2.651q-.724,5.774-1.818,11.5c-.645,3.388.18,6.228,2.929,8.275s5.775,1.959,8.784.395c3.213-1.67,6.492-3.224,9.625-5.032a4.043,4.043,0,0,1,4.524.052c3.151,1.779,6.386,3.419,9.638,5.01A21.743,21.743,0,0,0-438.15,77.41Zm-80.42,7.4a156.893,156.893,0,0,1-13.258-37.392c-2.657-12.715-4.564-25.585-6.81-38.444h-31.557c-1.813,20.492,2.252,39.085,16.108,54.714A67.056,67.056,0,0,0-518.569,84.813ZM-367.921,8.889c-2.319,13.148-4.282,26.025-6.925,38.761a159.263,159.263,0,0,1-13.159,37.183C-372.487,81-360.2,73.239-350.526,61.318c12.443-15.336,15.781-33.15,14.128-52.429Z" transform="translate(586.052 22.354)" />
                                  <path id="Path_82" data-name="Path 82" d="M-489.744,323.824c-.342-.221-.668-.472-1.027-.659-3.512-1.826-5.308-5.291-4.507-8.723a7.876,7.876,0,0,1,7.9-6.167c2.4-.039,4.8-.007,7.377-.007V296.6a4.718,4.718,0,0,1,4.718-4.718h99.465A4.718,4.718,0,0,1-371.1,296.6v11.665c2.293,0,4.409,0,6.524,0,4.929.009,7.984,2.122,8.935,6.175.862,3.669-.987,6.846-5.224,9-.132.067-.2.252-.3.382Z" transform="translate(558.189 -69.626)" />
                                  <path id="Path_83" data-name="Path 83" d="M-404.5,82.416c1.389-4.763.217-8.232-3.608-11.285,4.779-.23,7.756-2.218,9.521-7.069,1.646,4.812,4.647,6.882,9.531,7.059-3.874,3.061-5.014,6.533-3.7,11.14C-396.774,79.681-400.436,79.5-404.5,82.416Z" transform="translate(531.353 -4.21)" />
                                </g>
                            </svg>
                            <span class="d-block d-md-inline text-uppercase mt-1">&nbsp;SHARE Challenge</span>
                        </button>
                    </div>
                </nav>
                <div class="tab-content px-2 py-4 px-md-5 border-0 bg-light-grey" id="nav-tabContent">
                    <div class="tab-pane fade active show" id="nav-instant" role="tabpanel" aria-labelledby="nav-instant-tab">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-7">
                                <ul>
                                    <li class="mb-3">Encourage your customers to subscribe, follow, or like your brand across multiple platforms.</li>
                                    <li class="mb-3">Decide the challenge and offer incentives like gifts and discounts upon completion.</li>
                                    <li class="mb-3">Make your social media page stand out by promoting it through your customers to get your challenge program sorted.</li>
                                    <li class="mb-3">Watch as your customers promote your brand by sharing, following, and liking on their social media networks, ultimately generating word of mouth.</li>
                                </ul>
                                <div class="ms-3">
                                    <a href="{{route('channels', 'instant-challenge')}}" class="btn btn-sm btn-primary-ol px-4">Learn More</a>
                                </div>
                            </div>
                            <div class="col-12 col-md-5">
                                <img src="{{ asset('assets/website/images/products/instant-reward/instant-reward-banner.png') }}" class="img-fluid mt-3 mt-md-0" alt="Instant Challenge">
                            </div>
                        </div>
                        
                        
                    </div>
                    <div class="tab-pane fade" id="nav-share-reward" role="tabpanel" aria-labelledby="nav-share-reward-tab">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-7">
                               <ul>
                                    <li class="mb-3">Motivate customers to share links to your website, landing page, or content via personal networks like SMS, WhatsApp, or social media.</li>
                                    <li class="mb-3">Offer discounts or gifts based on total click count to benefit them for their word-of-mouth efforts.</li>
                                    <li class="mb-3">Reach new potential customers and retain existing ones with exciting new challenges & corresponding future benefits.</li>
                                </ul>
                                <div class="ms-3">
                                    <a href="{{route('channels', 'share-challenge')}}" class="btn btn-sm btn-primary-ol px-4">Learn More</a>
                                </div>
                            </div>
                            <div class="col-12 col-md-5">
                                <img src="{{ asset('assets/website/images/products/share-and-reward/share-reward-banner.png') }}"
                                class="img-fluid mt-3 mt-md-0 w-100" alt="Share Challenge">
                            </div>
                        </div>
                       
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>

<!-- <section class="main_product">
    <div class="py-5">
        <div class="container">

            <div class="main-products">
                <div class="main-products-column">
                    <div class="m-product-card">
                        <div class="inner">
                            <div class="icon">
                                <div class="icon-box">
                                    <svg id="Group_3081" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 365.115 342.611">
                                        <g id="Group_3068" >
                                          <path id="Path_1058" data-name="Path 1058" d="M365.114,152.164c-2.954,6.067-7.862,8.126-14.5,8.106-46.522-.145-93.046-.076-139.569-.078-5.736,0-5.739-.007-5.74-5.9,0-11.868-.087-23.737.058-35.6.036-3.015-.711-4.192-3.956-4.149-12.459.167-24.923.142-37.383.013-2.947-.03-3.893.918-3.862,3.871.133,12.46-.051,24.924.123,37.383.048,3.444-1.081,4.453-4.475,4.446q-71.208-.135-142.417-.073c-8.637,0-13.205-4.6-13.225-13.174C.149,136.918.648,126.8.047,116.749-.756,103.326,8.54,90.7,26.018,90.815c20.887.13,41.776.029,62.664.029h4.8c-3.074-2.513-5.429-4.376-7.718-6.316-16.1-13.66-21.587-35.1-13.969-54.51C79.252,11.022,97.67-.809,118.813.392c13.341.758,24.938,5.865,33.469,16.5,13.443,16.756,23.508,35.3,28.784,56.264.722,2.867,1.229,5.779,1.848,8.81.341-2.095.573-4.213,1.039-6.28,5.287-23.43,15.911-44.389,32.23-61.752,13.156-14,30.482-16.933,48.633-11.1,17.405,5.594,28.009,18.105,31.289,35.978,3.756,20.462-3.94,36.687-20.346,49.059-.989.747-2.318,1.162-2.857,2.533,1.249.8,2.577.421,3.824.423q31.332.043,62.664.028c8.459.008,15.895,2.365,21.317,9.369,2,2.578,3.027,5.618,4.408,8.494ZM150.848,90.682c7.9.265,8.578-.437,8.174-6.4a18.717,18.717,0,0,0-.469-3.156c-4.521-18.466-12.388-35.281-24.869-49.752A22.675,22.675,0,0,0,116.759,23.5a23.944,23.944,0,0,0-22.9,15.034,24.56,24.56,0,0,0,6.369,27.323c9.713,8.571,21,14.582,32.836,19.59,6.331,2.679,12.829,4.96,17.783,5.239m61.468.226a56.746,56.746,0,0,0,5.614-.836A113.563,113.563,0,0,0,265.565,65.53c10.42-9.042,10.421-25.945.576-35.254a24.349,24.349,0,0,0-35.2,2.1c-9.142,10.575-15.189,22.871-20.15,35.778-2.045,5.319-3.876,10.73-4.288,16.466-.4,5.624.3,6.285,5.81,6.282" transform="translate(0 0)" fill="#fff"/>
                                          <path id="Path_1059" data-name="Path 1059" d="M163,284.485q0,37.573,0,75.145c0,4.9-.017,4.918-4.937,4.919q-53.777.009-107.554-.009c-15.108-.016-24.752-9.651-24.76-24.689q-.033-65.53-.005-131.06c0-4.684.057-4.755,4.8-4.756q63.749-.015,127.5,0c4.947,0,4.961.029,4.962,4.948q.008,37.751,0,75.5" transform="translate(-2.776 -22.012)" fill="#fff"/>
                                          <path id="Path_1060" data-name="Path 1060" d="M230.129,284.11q0-37.573,0-75.145c0-4.9.016-4.928,4.982-4.929q63.748-.012,127.5,0c4.715,0,4.776.079,4.777,4.775q.007,65.708-.01,131.416c-.011,14.539-9.777,24.287-24.419,24.307-36.089.051-72.177-.027-108.266.088-3.592.012-4.658-1.06-4.638-4.656.14-25.285.074-50.571.074-75.857" transform="translate(-24.82 -22.012)" fill="#fff"/>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-uppercase font-900">   Instant Challenge</h4>
                            </div>
                            <div>
                                <p class="text">Give your customers a simple task to follow or like your page on multiple social media platforms. Decide the task you want to provide and reward the customers with offers and discounts as soon as they finish the task. Watch the happy customers increase the social media reach, and the total number of likes and followers like never seen before.</p>
                            </div>
                            <div>
                                <a href="{{route('channels', 'instant-challenge')}}" class="btn btn-sm btn-primary-ol px-4">Know More</a>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="main-products-column">

                    <div class="m-product-card">
                        <div class="inner">
                            <div class="icon">
                                <div class="icon-box">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 265.479 254.198">
                                        <g id="Group_3080" data-name="Group 3080" transform="translate(0)">
                                          <path id="Path_81" data-name="Path 81" d="M-320.573,26.912c-1.012,5.149-1.546,10.45-3.113,15.425-10.152,32.233-32.074,51.471-65.076,58.241a5.64,5.64,0,0,1-1.524.279c-6.207-.534-9.807,2.974-13.428,7.53A66.293,66.293,0,0,1-427.977,127.4c-1.534.711-1.878,1.522-1.747,3.146a113.85,113.85,0,0,0,25.372,63.433c.261.326.479.688.884,1.276H-503a18.767,18.767,0,0,1,1.029-1.612c14.667-18.6,23.237-39.609,25.084-63.3.107-1.363-.047-2.179-1.447-2.826-11.641-5.38-20.849-13.716-28.494-23.87a4.94,4.94,0,0,0-4.027-2.175c-38.972-2.8-71.337-34.422-74.675-73.3-.781-9.1-.458-18.3-.443-27.451.007-4.436,3.527-7.5,8.228-7.508,11.922-.03,23.843-.01,35.765-.01h3.137c0-2.42,0-4.707,0-6.994.011-5.348,3.167-8.556,8.529-8.556q76.972-.017,153.944,0c5.5,0,8.615,3.2,8.609,8.736,0,2.153,0,4.3,0,6.815h2.8c11.316,0,22.636.156,33.948-.073,4.821-.1,8.38,1.277,10.44,5.778ZM-438.15,77.41c5.63.082,9.281-4.2,8.506-9.151-.627-4-1.395-7.991-1.9-12.009a3.991,3.991,0,0,1,.941-2.868c2.781-2.952,5.774-5.7,8.606-8.607a7.346,7.346,0,0,0,1.965-7.846,7.486,7.486,0,0,0-6.346-5.372c-3.832-.621-7.661-1.27-11.51-1.747a3.614,3.614,0,0,1-3.252-2.37c-1.332-2.99-3.01-5.826-4.33-8.821-1.544-3.5-3.976-5.637-7.889-5.616s-6.285,2.236-7.812,5.73a94.659,94.659,0,0,1-4.552,9,4.388,4.388,0,0,1-2.606,1.935c-3.8.758-7.653,1.279-11.495,1.822a7.629,7.629,0,0,0-6.695,5.308c-1.145,3.33-.049,6.081,2.357,8.445,2.771,2.723,5.595,5.4,8.266,8.216a3.682,3.682,0,0,1,.873,2.651q-.724,5.774-1.818,11.5c-.645,3.388.18,6.228,2.929,8.275s5.775,1.959,8.784.395c3.213-1.67,6.492-3.224,9.625-5.032a4.043,4.043,0,0,1,4.524.052c3.151,1.779,6.386,3.419,9.638,5.01A21.743,21.743,0,0,0-438.15,77.41Zm-80.42,7.4a156.893,156.893,0,0,1-13.258-37.392c-2.657-12.715-4.564-25.585-6.81-38.444h-31.557c-1.813,20.492,2.252,39.085,16.108,54.714A67.056,67.056,0,0,0-518.569,84.813ZM-367.921,8.889c-2.319,13.148-4.282,26.025-6.925,38.761a159.263,159.263,0,0,1-13.159,37.183C-372.487,81-360.2,73.239-350.526,61.318c12.443-15.336,15.781-33.15,14.128-52.429Z" transform="translate(586.052 22.354)" fill="#fff"/>
                                          <path id="Path_82" data-name="Path 82" d="M-489.744,323.824c-.342-.221-.668-.472-1.027-.659-3.512-1.826-5.308-5.291-4.507-8.723a7.876,7.876,0,0,1,7.9-6.167c2.4-.039,4.8-.007,7.377-.007V296.6a4.718,4.718,0,0,1,4.718-4.718h99.465A4.718,4.718,0,0,1-371.1,296.6v11.665c2.293,0,4.409,0,6.524,0,4.929.009,7.984,2.122,8.935,6.175.862,3.669-.987,6.846-5.224,9-.132.067-.2.252-.3.382Z" transform="translate(558.189 -69.626)" fill="#fff"/>
                                          <path id="Path_83" data-name="Path 83" d="M-404.5,82.416c1.389-4.763.217-8.232-3.608-11.285,4.779-.23,7.756-2.218,9.521-7.069,1.646,4.812,4.647,6.882,9.531,7.059-3.874,3.061-5.014,6.533-3.7,11.14C-396.774,79.681-400.436,79.5-404.5,82.416Z" transform="translate(531.353 -4.21)" fill="#fff"/>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-uppercase font-900">Share Challenge</h4>
                            </div>
                            <div>
                                <p class="text">Give your customers a task to share your offer in their personal network. Reward your existing customers with an offer or discount. Watch your rewarded customers bring new customers to your business!</p>
                            </div>
                            <div>
                                <a href="{{route('channels', 'share-challenge')}}" class="btn btn-sm btn-primary-ol px-4">Know More</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section> -->


{{-- features section --}}
<section id="features">
    <div class="py-sm-5 py-4">
        <div class="container">
            <div class="text-center mb-md-5 mb-4 mx-auto" style="max-width: 850px;">
                <h2 class="text-capitalize font-900">best features that help you to launch your mouth publicity campaign</h2>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <div class="main-features">
                        <div class="inner">
                            <div>
                                <div class="img-thumb">
                                    <img src="{{asset('assets/website/images/features/best-feature-1.gif')}}" class="img-fluid" alt="Get exact count of clicks">
                                </div>
                            </div>
                            <div>
                                <h4 class="font-900 text-capitalize">Not just views, get exact count of clicks</h4>
                            </div>
                            <div>
                                <p class="mb-0 small">Not just views but you can see the total number of people who clicked the link which you can compare against different types of social media platforms.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="main-features">
                        <div class="inner">
                            <div>
                                <div class="img-thumb">
                                    <img src="{{asset('assets/website/images/features/best-feature-2.gif')}}" class="img-fluid" alt="Give your customers discounts and gifts">
                                </div>
                            </div>
                            <div>
                                <h4 class="font-900">Give your customers discounts and gifts after they complete the challenge</h4>
                            </div>
                            <div>
                                <p class="mb-0 small">As the customers are putting a lot of effort to complete the challenge, you can give them with various discounts and gifts.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="main-features">
                        <div class="inner">
                            <div>
                                <div class="img-thumb">
                                    <img src="{{asset('assets/website/images/features/best-feature-3.gif')}}" class="img-fluid" alt="Never miss an event to celebrate">
                                </div>
                            </div>
                            <div>
                                <h4 class="font-900">Never miss an event to celebrate with your customers</h4>
                            </div>
                            <div>
                                <p class="mb-0 small">Don’t miss any opportunity you get to celebrate with your customers by sending them fresh updates about your business or special festive/birthday offers.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>



{{-- Free Products section --}}
<section id="free_products" class="bg-white py-md-4">
    <div class="pb-sm-5 pb-4 pt-5">
        <div class="container">
            <div class="text-center mb-sm-5 mb-4">
                <h3 class="text-capitalize h2 font-900 mb-0">start sending message to your customers for free</h3>
            </div>

            <!-- <div class="row">
                {{-- Social Post Card --}}
                <div class="col-md-4">
                    <div class="free-products">
                        <div class="inner">
                            <div class="icon mb-4">
                                <div class="icon-box">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="40" height="40" viewBox="0 0 174 174">
                                        <defs>
                                          <clipPath id="clip-path">
                                            <rect id="Rectangle_233" data-name="Rectangle 233" width="174" height="174" transform="translate(0 -0.055)" fill="none"/>
                                          </clipPath>
                                        </defs>
                                        <g id="Group_3070" data-name="Group 3070" transform="translate(0 0.055)" clip-path="url(#clip-path)">
                                          <path id="Path_1061" data-name="Path 1061" d="M174.486,71.111V199.9a2.42,2.42,0,0,0-.224.457c-2.226,8.69-7.557,12.831-16.535,12.831q-70.691,0-141.381,0c-9.83,0-16.307-6.488-16.308-16.33q0-61.918,0-123.837V71.111ZM87.435,85.422q-25.544,0-51.088,0c-4.005,0-5.985,1.959-5.986,5.927q0,37.295,0,74.589c0,4.086,1.952,6.026,6.06,6.026q50.833,0,101.666,0c4.113,0,6.072-1.938,6.073-6.014q0-37.21,0-74.419c0-4.2-1.921-6.108-6.147-6.109q-25.289,0-50.578,0M41,187.216c-.852-.967-1.325-1.61-1.9-2.141a5.095,5.095,0,0,0-7.264,7.146q2.674,2.856,5.536,5.535a4.96,4.96,0,0,0,7.065.031c1.955-1.81,3.849-3.7,5.652-5.658a5.022,5.022,0,0,0-.1-7.071,5.08,5.08,0,0,0-7.2-.014A22.772,22.772,0,0,0,41,187.216M73.642,196.5c1.756,0,3.511.027,5.266-.006a5.1,5.1,0,1,0,.063-10.2q-5.35-.067-10.7,0a5.1,5.1,0,1,0-.062,10.2c1.811.048,3.624.009,5.436.01m32.692-10.219c-1.755,0-3.511-.025-5.266.005a5.1,5.1,0,1,0-.073,10.2q5.35.071,10.7,0a5.1,5.1,0,1,0-.1-10.2c-1.755-.03-3.511-.005-5.266-.005" transform="translate(-0.019 -40.187)" fill="#fff"/>
                                          <path id="Path_1062" data-name="Path 1062" d="M174.467,13.288v8.859H.024c0-2.483-.062-4.8.013-7.108C.2,10.091,2.149,5.922,6.245,3.139,8.342,1.715,10.936,1.023,13.3,0H161.178a9.556,9.556,0,0,0,.955.313A15.058,15.058,0,0,1,173.243,9.42a35.9,35.9,0,0,1,1.224,3.868" transform="translate(0 -1.445)" fill="#fff"/>
                                          <path id="Path_1063" data-name="Path 1063" d="M182.595,125.249v27.616c-.622-.7-1.009-1.139-1.4-1.575q-5.486-6.171-10.975-12.34c-2.612-2.926-5.6-3.017-8.382-.237q-12.353,12.329-24.676,24.686a15.037,15.037,0,0,0-1.182,1.534c-.657-.529-1.058-.831-1.435-1.16q-8.077-7.058-16.146-14.123c-3.129-2.739-5.456-2.72-8.5.055-6.753,6.147-13.511,12.288-20.464,18.611V125.249Z" transform="translate(-48.725 -69.682)" fill="#fff"/>
                                          <path id="Path_1064" data-name="Path 1064" d="M165.332,177.5c5.764,6.481,11.2,12.584,16.611,18.707a2,2,0,0,1,.5,1.19c.03,7.369.021,14.739.021,22.208H89.113c0-2.823-.025-5.589.029-8.354a1.817,1.817,0,0,1,.629-1.106q11.892-10.845,23.818-21.652a4.472,4.472,0,0,1,.559-.35q5.463,4.774,10.965,9.584,3.333,2.915,6.661,5.835c2.9,2.533,5.486,2.477,8.224-.253q12.123-12.086,24.2-24.214a11.869,11.869,0,0,0,1.131-1.6" transform="translate(-48.547 -98.149)" fill="#fff"/>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h6 class="font-800">Social Post</h6>
                            </div>
                            <div>
                                <p class="small text">Post your content from a single dashboard across different social channels and keep track of the clicks, shares, comments, and more.</p>
                            </div>
                            <div>
                                <a href="#" class="btn btn-sm btn-link-ol">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Personalized Message card  --}}
                <div class="col-md-4">
                    <div class="free-products">
                        <div class="inner">
                            <div class="icon mb-4">
                                <div class="icon-box">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="40" height="40" viewBox="0 0 168.847 148.336">
                                        <defs>
                                            <clipPath id="clip-path">
                                            <rect id="Rectangle_230" data-name="Rectangle 230" width="40" height="40" fill="#fff"/>
                                            </clipPath>
                                        </defs>
                                        <g id="Group_3071" data-name="Group 3071" transform="translate(4.036)">
                                            <g id="Group_3064" data-name="Group 3064" transform="translate(-4.036)" clip-path="url(#clip-path)">
                                            <path id="Path_1053" data-name="Path 1053" d="M0,16.2A20.7,20.7,0,0,1,4.5,6.8,19.231,19.231,0,0,1,19.475.028Q67.653-.036,115.831.014c3.884,0,5.882,2.039,5.883,5.907q.009,30.965-.008,61.931a19.066,19.066,0,0,1-19.353,19.293q-29.318.034-58.637-.008a15.461,15.461,0,0,0-9.37,3.014q-12.76,9.194-25.608,18.267c-3.622,2.569-6.482,1.908-8.738-1.93ZM64.1,27.436v.007c-9.5,0-18.994-.018-28.492.012a4.656,4.656,0,0,0-4.816,4.257,4.843,4.843,0,0,0,3.521,4.962,8.032,8.032,0,0,0,2.116.191q27.668.014,55.337.007c.439,0,.881.014,1.317-.028A4.937,4.937,0,0,0,97.387,32.7a4.867,4.867,0,0,0-3.019-4.983,7,7,0,0,0-2.6-.277q-13.834-.009-27.668,0M64.267,50.5v.007c-9.552,0-19.1-.018-28.656.011a4.657,4.657,0,0,0-4.82,4.253,4.841,4.841,0,0,0,3.516,4.965,8.015,8.015,0,0,0,2.116.191q27.668.015,55.337.007c.439,0,.881.015,1.317-.027a4.935,4.935,0,0,0,4.31-4.139,4.865,4.865,0,0,0-3.014-4.986,6.971,6.971,0,0,0-2.6-.279q-13.752-.009-27.5,0" transform="translate(0 0)" fill="#fff"/>
                                            <path id="Path_1054" data-name="Path 1054" d="M228.573,148.613q0,21.418.015,42.835a5.442,5.442,0,0,1-1.682,4.455c-1.973,1.724-4.256,1.816-6.646.129-6.282-4.431-12.531-8.908-18.792-13.369-2.371-1.689-4.773-3.335-7.1-5.086a15.093,15.093,0,0,0-9.5-3.093q-28.831.1-57.663.025c-7.85-.007-14.052-3.088-18.078-10a17.084,17.084,0,0,1-2.377-8.634c-.012-2.911.026-5.822-.029-8.731-.022-1.124.394-1.64,1.516-1.6.548.019,1.1-.006,1.647-.007l51.9,0c11.242,0,19.687-4.968,25.48-14.5a27.775,27.775,0,0,0,3.823-14.478c.068-8.951.018-17.9.021-26.854,0-2.3.007-2.313,2.228-2.312,5.6,0,11.2-.038,16.8.03a19,19,0,0,1,18.415,18.523c.052,14.223.013,28.447.015,42.671" transform="translate(-59.742 -48.912)" fill="#fff"/>
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h6 class="font-800">Personalized Messaging</h6>
                            </div>
                            <div>
                                <p class="small text">Engage your customers by wishing them and notifying them about new offers on special occasions and build a strong rapport with your customers!</p>
                            </div>
                            <div>
                                <a href="#" class="btn btn-sm btn-link-ol">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Message API Card --}}
                <div class="col-md-4">
                    <div class="free-products">
                        <div class="inner">
                            <div class="icon mb-4">
                                <div class="icon-box">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="40" height="40" viewBox="0 0 176.89 176.781">
                                        <defs>
                                            <clipPath id="clip-path">
                                                <rect id="Rectangle_231" data-name="Rectangle 231" width="40" height="40" fill="#fff"/>
                                            </clipPath>
                                        </defs>
                                        <g id="Group_3072" data-name="Group 3072" transform="translate(5 24.627)">
                                            <g id="Group_3066" data-name="Group 3066" transform="translate(-5 -24.627)" clip-path="url(#clip-path)">
                                            <path id="Path_1055" data-name="Path 1055" d="M91.51,121.061c0,9.925.032,19.851-.032,29.777a3.028,3.028,0,0,0,2.029,3.333,11.925,11.925,0,1,1-9.995-.083,2.8,2.8,0,0,0,1.89-3.045q-.077-30.052-.034-60.1c0-2.395-.006-2.4-2.442-2.4-2.267,0-4.54.1-6.8-.033-1.746-.1-2.315.439-2.3,2.246.077,10.967.052,21.934.028,32.9a8.8,8.8,0,0,1-6.741,8.765,10.335,10.335,0,0,1-2.735.233q-10.11.008-20.219,0c-2.643,0-2.646,0-2.647,2.563q0,11.488,0,22.976c-.006,6.2-3.583,9.742-9.835,9.752-1.961,0-3.928.1-5.88-.031a2.687,2.687,0,0,0-3.042,1.9c-2.136,4.762-6.433,7.18-11.877,6.938A11.93,11.93,0,0,1,7.2,153.906a11.745,11.745,0,0,1,15.4,5.746c.823,1.765,1.784,2.329,3.6,2.187,1.888-.148,3.8.007,5.695-.051,2.279-.07,3.432-1.154,3.445-3.417.046-8.088.007-16.175.036-24.262,0-1.151-.5-1.539-1.562-1.456a4.744,4.744,0,0,1-1.1-.006c-2.192-.346-3.437.4-4.476,2.567a11.594,11.594,0,0,1-13.531,5.911c-5.549-1.542-8.918-6.264-8.755-12.272a11.854,11.854,0,0,1,22.56-4.44c.768,1.671,1.663,2.395,3.449,2.118a9.9,9.9,0,0,1,2.019-.013c1.04.055,1.394-.439,1.393-1.438q-.024-17.553,0-35.107c0-1.17-.541-1.458-1.582-1.444-2.573.036-5.147.021-7.72,0a26.412,26.412,0,0,1-26-26.083C.014,48.865,8.993,38.052,22.366,35.7a2.874,2.874,0,0,0,2.657-2.453A43.844,43.844,0,0,1,63.47.216C78.292-1.136,90.931,3.843,101,14.956c.83.915,1.353,1.8,2.951.816a26.47,26.47,0,0,1,40.021,17.56c.318,1.651.991,2.07,2.549,2.041a39.739,39.739,0,0,1,10.046.661,26.857,26.857,0,0,1,20.251,27.932c-.617,11.587-10.014,22.122-22.062,24.227-3.716.649-7.457.292-11.186.305-1.6.006-2.107.448-2.1,2.081q.088,19.943,0,39.886c-.006,1.564.539,2.122,2.023,1.938a3.808,3.808,0,0,1,1.1,0c1.973.339,3-.444,3.876-2.32a11.852,11.852,0,0,1,22.451,5.808,11.847,11.847,0,0,1-9.35,11.274,12.047,12.047,0,0,1-13.391-6.734c-.349-.721-.375-1.833-1.511-1.855a16.166,16.166,0,0,0-4.743.162c-.526.148-.419.827-.419,1.308,0,6.127-.033,12.254.022,18.381.02,2.179,1.149,3.284,3.315,3.351,2.387.075,4.781-.043,7.167.05,1.339.052,1.576-.872,1.992-1.757,3.542-7.535,12.989-9.564,18.921-4.019a11.337,11.337,0,0,1,3.2,12.748,11.853,11.853,0,0,1-21.815,1.344,3.343,3.343,0,0,0-3.771-2.232c-2.135.141-4.287.059-6.431.022a8.744,8.744,0,0,1-8.735-8.8c-.045-6.188-.066-12.377.02-18.564.023-1.649-.527-2.079-2.112-2.063-6.984.074-13.969.045-20.953.026-5.6-.015-9.309-3.727-9.315-9.343-.015-12.8-.038-25.61.031-38.415.009-1.776-.5-2.383-2.28-2.268-2.135.139-4.287.032-6.431.033-2.83,0-2.831,0-2.831,2.746q0,14.888,0,29.777m43.857-10.54c0-6.677-.04-13.354.029-20.029.016-1.535-.486-2-2-1.982-7.411.063-14.823.076-22.234-.007-1.678-.019-2.043.582-2.036,2.135.053,12.557.023,25.114.035,37.671,0,3.057,1.029,4.074,4.1,4.081,6.677.015,13.353-.039,20.029.037,1.583.018,2.134-.411,2.113-2.061-.084-6.614-.035-13.23-.035-19.845m-93.855-2.994c0,5.7.036,11.393-.026,17.089-.015,1.41.375,1.941,1.866,1.927,6.86-.068,13.72-.013,20.58-.041,2.691-.011,3.774-1.111,3.779-3.838.02-10.78-.009-21.56.032-32.34,0-1.353-.423-1.817-1.793-1.808q-11.3.075-22.6-.006c-1.5-.013-1.879.523-1.864,1.929.061,5.7.026,11.392.026,17.089M73.277,74.58c-.016-.34-.015-.525-.035-.707-.865-7.838-1.718-15.676-2.609-23.511-.228-2.011-1.331-2.95-3.5-2.981-3.243-.048-6.488-.027-9.733-.013-3.006.013-3.862.9-4.172,3.868Q52.1,62,50.823,72.739c-.4,3.3-.186,3.654,3.187,3.8.122.005.246,0,.367.016,1.039.125,1.57-.234,1.658-1.377.15-1.948.512-3.88.659-5.829.094-1.254.639-1.7,1.858-1.667q3.4.084,6.794,0c1.188-.027,1.8.341,1.9,1.626.124,1.766.558,3.518.583,5.28.026,1.825.9,2.2,2.432,1.936a12.282,12.282,0,0,1,1.45-.212c1.23-.06,1.814-.617,1.57-1.729m6.468-11.871c0,3.305-.038,6.611.009,9.916.063,4.407-.838,3.822,4.06,3.906,1.232.021,1.589-.5,1.569-1.647-.049-2.754.05-5.511-.038-8.263-.047-1.465.508-1.914,1.923-1.891,3.978.066,7.957.044,11.936.011,2.7-.022,3.774-1.1,3.8-3.815.031-3.183.024-6.366,0-9.549-.019-2.952-1.048-3.994-3.982-4.006q-7.621-.031-15.242,0c-3.023.011-4.023,1.045-4.036,4.137-.015,3.734,0,7.468,0,11.2m38.289-15.343c-2.449,0-4.9.029-7.347-.014-1.077-.019-1.5.355-1.553,1.481-.184,4.094-.221,4.092,3.831,4.155a1.347,1.347,0,0,0,.184,0c1.43-.177,1.934.433,1.912,1.879-.068,4.652-.083,9.307.007,13.959.032,1.616-.495,2.117-2.1,2.1-4.052-.042-4.052.028-3.808,4.117a1.53,1.53,0,0,1,0,.184c-.056.953.431,1.3,1.34,1.292q7.347-.023,14.695,0c.907,0,1.28-.346,1.361-1.288.369-4.264.385-4.274-3.823-4.339a1.271,1.271,0,0,0-.184,0c-1.429.177-1.934-.433-1.912-1.879.068-4.653.083-9.308-.007-13.959-.031-1.616.495-2.116,2.1-2.1,4.052.043,4.016-.026,3.832-4.118-.05-1.124-.472-1.5-1.551-1.483-2.326.044-4.653.013-6.98.013" transform="translate(0 0)" fill="#fff"/>
                                            <path id="Path_1056" data-name="Path 1056" d="M121.661,116.79c-5.091-.109-4.358.944-3.893-4.507a1.328,1.328,0,0,1,.036-.179c.324-1.393-.327-3.376.973-4.082,1.556-.845,3.577-.245,5.4-.259.808-.006,1.01.592,1.087,1.218.278,2.235.529,4.473.782,6.711.091.805-.366,1.1-1.091,1.1-1.1,0-2.195,0-3.292,0" transform="translate(-59.76 -54.738)" fill="#fff"/>
                                            <path id="Path_1057" data-name="Path 1057" d="M179.823,113.995c-1.528,0-3.057-.023-4.584.008-1,.021-1.432-.411-1.424-1.419.046-5.815-.635-4.588,4.36-4.711,2.016-.05,4.036.033,6.051-.017,1.176-.029,1.634.433,1.617,1.613-.081,5.492.621,4.408-4.37,4.534-.55.014-1.1,0-1.65,0Z" transform="translate(-88.444 -54.877)" fill="#fff"/>
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h6 class="font-800">Messaging API</h6>
                            </div>
                            <div>
                                <p class="small text">Keep your customers connected with you by sending them automated messages using our Messaging API</p>
                            </div>
                            <div>
                                <a href="#" class="btn btn-sm btn-link-ol">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->

            <div class="">
                <div class="owl-carousel owl-theme" id="product">
                    {{-- Social Post Card --}}
                    <div class="product-item item">
                        <div class="free-products">
                            <div class="inner">
                                <div class="icon mb-4">
                                    <div class="icon-box">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 174 174">
                                            <g id="Group_3070" transform="translate(0 0.055)" >
                                              <path id="Path_1061" data-name="Path 1061" d="M174.486,71.111V199.9a2.42,2.42,0,0,0-.224.457c-2.226,8.69-7.557,12.831-16.535,12.831q-70.691,0-141.381,0c-9.83,0-16.307-6.488-16.308-16.33q0-61.918,0-123.837V71.111ZM87.435,85.422q-25.544,0-51.088,0c-4.005,0-5.985,1.959-5.986,5.927q0,37.295,0,74.589c0,4.086,1.952,6.026,6.06,6.026q50.833,0,101.666,0c4.113,0,6.072-1.938,6.073-6.014q0-37.21,0-74.419c0-4.2-1.921-6.108-6.147-6.109q-25.289,0-50.578,0M41,187.216c-.852-.967-1.325-1.61-1.9-2.141a5.095,5.095,0,0,0-7.264,7.146q2.674,2.856,5.536,5.535a4.96,4.96,0,0,0,7.065.031c1.955-1.81,3.849-3.7,5.652-5.658a5.022,5.022,0,0,0-.1-7.071,5.08,5.08,0,0,0-7.2-.014A22.772,22.772,0,0,0,41,187.216M73.642,196.5c1.756,0,3.511.027,5.266-.006a5.1,5.1,0,1,0,.063-10.2q-5.35-.067-10.7,0a5.1,5.1,0,1,0-.062,10.2c1.811.048,3.624.009,5.436.01m32.692-10.219c-1.755,0-3.511-.025-5.266.005a5.1,5.1,0,1,0-.073,10.2q5.35.071,10.7,0a5.1,5.1,0,1,0-.1-10.2c-1.755-.03-3.511-.005-5.266-.005" transform="translate(-0.019 -40.187)" fill="#fff"/>
                                              <path id="Path_1062" data-name="Path 1062" d="M174.467,13.288v8.859H.024c0-2.483-.062-4.8.013-7.108C.2,10.091,2.149,5.922,6.245,3.139,8.342,1.715,10.936,1.023,13.3,0H161.178a9.556,9.556,0,0,0,.955.313A15.058,15.058,0,0,1,173.243,9.42a35.9,35.9,0,0,1,1.224,3.868" transform="translate(0 -1.445)" fill="#fff"/>
                                              <path id="Path_1063" data-name="Path 1063" d="M182.595,125.249v27.616c-.622-.7-1.009-1.139-1.4-1.575q-5.486-6.171-10.975-12.34c-2.612-2.926-5.6-3.017-8.382-.237q-12.353,12.329-24.676,24.686a15.037,15.037,0,0,0-1.182,1.534c-.657-.529-1.058-.831-1.435-1.16q-8.077-7.058-16.146-14.123c-3.129-2.739-5.456-2.72-8.5.055-6.753,6.147-13.511,12.288-20.464,18.611V125.249Z" transform="translate(-48.725 -69.682)" fill="#fff"/>
                                              <path id="Path_1064" data-name="Path 1064" d="M165.332,177.5c5.764,6.481,11.2,12.584,16.611,18.707a2,2,0,0,1,.5,1.19c.03,7.369.021,14.739.021,22.208H89.113c0-2.823-.025-5.589.029-8.354a1.817,1.817,0,0,1,.629-1.106q11.892-10.845,23.818-21.652a4.472,4.472,0,0,1,.559-.35q5.463,4.774,10.965,9.584,3.333,2.915,6.661,5.835c2.9,2.533,5.486,2.477,8.224-.253q12.123-12.086,24.2-24.214a11.869,11.869,0,0,0,1.131-1.6" transform="translate(-48.547 -98.149)" fill="#fff"/>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="font-800">Social Post</h6>
                                </div>
                                <div>
                                    <p class="small text">Post your content from a single dashboard across different social channels and keep track of the clicks, shares, comments, and more.</p>
                                </div>
                                <div>
                                    <a href="{{route('channels', 'social-post')}}" class="btn btn-sm btn-link-ol">Know More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Personalized Message card  --}}
                    <div class="product-item item">
                        <div class="free-products">
                            <div class="inner">
                                <div class="icon mb-4">
                                    <div class="icon-box">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 168.847 148.336">
                                            <g id="Group_3071" transform="translate(4.036)">
                                                <g id="Group_3064" data-name="Group 3064" transform="translate(-4.036)" clip-path="url(#clip-path)">
                                                <path id="Path_1053" data-name="Path 1053" d="M0,16.2A20.7,20.7,0,0,1,4.5,6.8,19.231,19.231,0,0,1,19.475.028Q67.653-.036,115.831.014c3.884,0,5.882,2.039,5.883,5.907q.009,30.965-.008,61.931a19.066,19.066,0,0,1-19.353,19.293q-29.318.034-58.637-.008a15.461,15.461,0,0,0-9.37,3.014q-12.76,9.194-25.608,18.267c-3.622,2.569-6.482,1.908-8.738-1.93ZM64.1,27.436v.007c-9.5,0-18.994-.018-28.492.012a4.656,4.656,0,0,0-4.816,4.257,4.843,4.843,0,0,0,3.521,4.962,8.032,8.032,0,0,0,2.116.191q27.668.014,55.337.007c.439,0,.881.014,1.317-.028A4.937,4.937,0,0,0,97.387,32.7a4.867,4.867,0,0,0-3.019-4.983,7,7,0,0,0-2.6-.277q-13.834-.009-27.668,0M64.267,50.5v.007c-9.552,0-19.1-.018-28.656.011a4.657,4.657,0,0,0-4.82,4.253,4.841,4.841,0,0,0,3.516,4.965,8.015,8.015,0,0,0,2.116.191q27.668.015,55.337.007c.439,0,.881.015,1.317-.027a4.935,4.935,0,0,0,4.31-4.139,4.865,4.865,0,0,0-3.014-4.986,6.971,6.971,0,0,0-2.6-.279q-13.752-.009-27.5,0" transform="translate(0 0)" fill="#fff"/>
                                                <path id="Path_1054" data-name="Path 1054" d="M228.573,148.613q0,21.418.015,42.835a5.442,5.442,0,0,1-1.682,4.455c-1.973,1.724-4.256,1.816-6.646.129-6.282-4.431-12.531-8.908-18.792-13.369-2.371-1.689-4.773-3.335-7.1-5.086a15.093,15.093,0,0,0-9.5-3.093q-28.831.1-57.663.025c-7.85-.007-14.052-3.088-18.078-10a17.084,17.084,0,0,1-2.377-8.634c-.012-2.911.026-5.822-.029-8.731-.022-1.124.394-1.64,1.516-1.6.548.019,1.1-.006,1.647-.007l51.9,0c11.242,0,19.687-4.968,25.48-14.5a27.775,27.775,0,0,0,3.823-14.478c.068-8.951.018-17.9.021-26.854,0-2.3.007-2.313,2.228-2.312,5.6,0,11.2-.038,16.8.03a19,19,0,0,1,18.415,18.523c.052,14.223.013,28.447.015,42.671" transform="translate(-59.742 -48.912)" fill="#fff"/>
                                                </g>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="font-800">Personalised Messaging</h6>
                                </div>
                                <div>
                                    <p class="small text">Engage your customers by wishing them and notifying them about new offers on special occasions and build a strong connection with your customers!</p>
                                </div>
                                <div>
                                    <a href="{{route('channels', 'personalised-message')}}" class="btn btn-sm btn-link-ol">Know More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Message API Card --}}
                    <div class="product-item item">
                        <div class="free-products">
                            <div class="inner">
                                <div class="icon mb-4">
                                    <div class="icon-box">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 176.89 176.781">
                                            <g id="Group_3072" transform="translate(5 24.627)">
                                                <g id="Group_3066" data-name="Group 3066" transform="translate(-5 -24.627)" clip-path="url(#clip-path)">
                                                <path id="Path_1055" data-name="Path 1055" d="M91.51,121.061c0,9.925.032,19.851-.032,29.777a3.028,3.028,0,0,0,2.029,3.333,11.925,11.925,0,1,1-9.995-.083,2.8,2.8,0,0,0,1.89-3.045q-.077-30.052-.034-60.1c0-2.395-.006-2.4-2.442-2.4-2.267,0-4.54.1-6.8-.033-1.746-.1-2.315.439-2.3,2.246.077,10.967.052,21.934.028,32.9a8.8,8.8,0,0,1-6.741,8.765,10.335,10.335,0,0,1-2.735.233q-10.11.008-20.219,0c-2.643,0-2.646,0-2.647,2.563q0,11.488,0,22.976c-.006,6.2-3.583,9.742-9.835,9.752-1.961,0-3.928.1-5.88-.031a2.687,2.687,0,0,0-3.042,1.9c-2.136,4.762-6.433,7.18-11.877,6.938A11.93,11.93,0,0,1,7.2,153.906a11.745,11.745,0,0,1,15.4,5.746c.823,1.765,1.784,2.329,3.6,2.187,1.888-.148,3.8.007,5.695-.051,2.279-.07,3.432-1.154,3.445-3.417.046-8.088.007-16.175.036-24.262,0-1.151-.5-1.539-1.562-1.456a4.744,4.744,0,0,1-1.1-.006c-2.192-.346-3.437.4-4.476,2.567a11.594,11.594,0,0,1-13.531,5.911c-5.549-1.542-8.918-6.264-8.755-12.272a11.854,11.854,0,0,1,22.56-4.44c.768,1.671,1.663,2.395,3.449,2.118a9.9,9.9,0,0,1,2.019-.013c1.04.055,1.394-.439,1.393-1.438q-.024-17.553,0-35.107c0-1.17-.541-1.458-1.582-1.444-2.573.036-5.147.021-7.72,0a26.412,26.412,0,0,1-26-26.083C.014,48.865,8.993,38.052,22.366,35.7a2.874,2.874,0,0,0,2.657-2.453A43.844,43.844,0,0,1,63.47.216C78.292-1.136,90.931,3.843,101,14.956c.83.915,1.353,1.8,2.951.816a26.47,26.47,0,0,1,40.021,17.56c.318,1.651.991,2.07,2.549,2.041a39.739,39.739,0,0,1,10.046.661,26.857,26.857,0,0,1,20.251,27.932c-.617,11.587-10.014,22.122-22.062,24.227-3.716.649-7.457.292-11.186.305-1.6.006-2.107.448-2.1,2.081q.088,19.943,0,39.886c-.006,1.564.539,2.122,2.023,1.938a3.808,3.808,0,0,1,1.1,0c1.973.339,3-.444,3.876-2.32a11.852,11.852,0,0,1,22.451,5.808,11.847,11.847,0,0,1-9.35,11.274,12.047,12.047,0,0,1-13.391-6.734c-.349-.721-.375-1.833-1.511-1.855a16.166,16.166,0,0,0-4.743.162c-.526.148-.419.827-.419,1.308,0,6.127-.033,12.254.022,18.381.02,2.179,1.149,3.284,3.315,3.351,2.387.075,4.781-.043,7.167.05,1.339.052,1.576-.872,1.992-1.757,3.542-7.535,12.989-9.564,18.921-4.019a11.337,11.337,0,0,1,3.2,12.748,11.853,11.853,0,0,1-21.815,1.344,3.343,3.343,0,0,0-3.771-2.232c-2.135.141-4.287.059-6.431.022a8.744,8.744,0,0,1-8.735-8.8c-.045-6.188-.066-12.377.02-18.564.023-1.649-.527-2.079-2.112-2.063-6.984.074-13.969.045-20.953.026-5.6-.015-9.309-3.727-9.315-9.343-.015-12.8-.038-25.61.031-38.415.009-1.776-.5-2.383-2.28-2.268-2.135.139-4.287.032-6.431.033-2.83,0-2.831,0-2.831,2.746q0,14.888,0,29.777m43.857-10.54c0-6.677-.04-13.354.029-20.029.016-1.535-.486-2-2-1.982-7.411.063-14.823.076-22.234-.007-1.678-.019-2.043.582-2.036,2.135.053,12.557.023,25.114.035,37.671,0,3.057,1.029,4.074,4.1,4.081,6.677.015,13.353-.039,20.029.037,1.583.018,2.134-.411,2.113-2.061-.084-6.614-.035-13.23-.035-19.845m-93.855-2.994c0,5.7.036,11.393-.026,17.089-.015,1.41.375,1.941,1.866,1.927,6.86-.068,13.72-.013,20.58-.041,2.691-.011,3.774-1.111,3.779-3.838.02-10.78-.009-21.56.032-32.34,0-1.353-.423-1.817-1.793-1.808q-11.3.075-22.6-.006c-1.5-.013-1.879.523-1.864,1.929.061,5.7.026,11.392.026,17.089M73.277,74.58c-.016-.34-.015-.525-.035-.707-.865-7.838-1.718-15.676-2.609-23.511-.228-2.011-1.331-2.95-3.5-2.981-3.243-.048-6.488-.027-9.733-.013-3.006.013-3.862.9-4.172,3.868Q52.1,62,50.823,72.739c-.4,3.3-.186,3.654,3.187,3.8.122.005.246,0,.367.016,1.039.125,1.57-.234,1.658-1.377.15-1.948.512-3.88.659-5.829.094-1.254.639-1.7,1.858-1.667q3.4.084,6.794,0c1.188-.027,1.8.341,1.9,1.626.124,1.766.558,3.518.583,5.28.026,1.825.9,2.2,2.432,1.936a12.282,12.282,0,0,1,1.45-.212c1.23-.06,1.814-.617,1.57-1.729m6.468-11.871c0,3.305-.038,6.611.009,9.916.063,4.407-.838,3.822,4.06,3.906,1.232.021,1.589-.5,1.569-1.647-.049-2.754.05-5.511-.038-8.263-.047-1.465.508-1.914,1.923-1.891,3.978.066,7.957.044,11.936.011,2.7-.022,3.774-1.1,3.8-3.815.031-3.183.024-6.366,0-9.549-.019-2.952-1.048-3.994-3.982-4.006q-7.621-.031-15.242,0c-3.023.011-4.023,1.045-4.036,4.137-.015,3.734,0,7.468,0,11.2m38.289-15.343c-2.449,0-4.9.029-7.347-.014-1.077-.019-1.5.355-1.553,1.481-.184,4.094-.221,4.092,3.831,4.155a1.347,1.347,0,0,0,.184,0c1.43-.177,1.934.433,1.912,1.879-.068,4.652-.083,9.307.007,13.959.032,1.616-.495,2.117-2.1,2.1-4.052-.042-4.052.028-3.808,4.117a1.53,1.53,0,0,1,0,.184c-.056.953.431,1.3,1.34,1.292q7.347-.023,14.695,0c.907,0,1.28-.346,1.361-1.288.369-4.264.385-4.274-3.823-4.339a1.271,1.271,0,0,0-.184,0c-1.429.177-1.934-.433-1.912-1.879.068-4.653.083-9.308-.007-13.959-.031-1.616.495-2.116,2.1-2.1,4.052.043,4.016-.026,3.832-4.118-.05-1.124-.472-1.5-1.551-1.483-2.326.044-4.653.013-6.98.013" transform="translate(0 0)" fill="#fff"/>
                                                <path id="Path_1056" data-name="Path 1056" d="M121.661,116.79c-5.091-.109-4.358.944-3.893-4.507a1.328,1.328,0,0,1,.036-.179c.324-1.393-.327-3.376.973-4.082,1.556-.845,3.577-.245,5.4-.259.808-.006,1.01.592,1.087,1.218.278,2.235.529,4.473.782,6.711.091.805-.366,1.1-1.091,1.1-1.1,0-2.195,0-3.292,0" transform="translate(-59.76 -54.738)" fill="#fff"/>
                                                <path id="Path_1057" data-name="Path 1057" d="M179.823,113.995c-1.528,0-3.057-.023-4.584.008-1,.021-1.432-.411-1.424-1.419.046-5.815-.635-4.588,4.36-4.711,2.016-.05,4.036.033,6.051-.017,1.176-.029,1.634.433,1.617,1.613-.081,5.492.621,4.408-4.37,4.534-.55.014-1.1,0-1.65,0Z" transform="translate(-88.444 -54.877)" fill="#fff"/>
                                                </g>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="font-800">Messaging API</h6>
                                </div>
                                <div>
                                    <p class="small text">Keep your customers connected with you by sending them automated messages using our Messaging API</p>
                                </div>
                                <div>
                                    <a href="{{route('channels', 'messaging-api')}}" class="btn btn-sm btn-link-ol">Know More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="text-center">
        <a href="{{url('signin?tab=register')}}" class="btn btn-lg btn-primary-ol px-4">Get Started for Free</a>
    </div>

</section>

{{-- Who is it for  --}}
@include('website.components.who-is-it-for')



{{-- features section --}}
<section id="o_features">
    <div class="mb-md-5">

        {{-- One --}}
        <div class="feature-container py-sm-5 py-3">
            <div class="container py-md-4">
                <div class="text-center mb-md-5 mb-4 mx-auto" style="max-width: 850px;">
                    <h2 class="text-capitalize font-900">simple steps to  make your customers as marketing team</h2>
                </div>
                <div class="row justify-content-center align-items-center">
                    <div class="col-md-6 col-lg-5">
                        <div class="d-flex justify-content-md-start py-3">
                            <div class="feature-text" style="--width: 22rem;">
                                <h4 class="font-800 h1 mb-3">Design your offers in no time</h4>
                                <p class="font-600 mb-0">Design mind-blowing offers with our eye-catching, easy-to-make templates within just a few minutes to save your valuable time</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-5">
                        <div class="feature-image">
                            <img src="{{asset('assets/website/images/features/feature-one.png')}}" class="img-fluid" alt="Design your offers in no time">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- One - END --}}

        {{-- two --}}
        <div class="feature-container py-sm-5 py-3">
            <div class="container py-md-4">
                <div class="row justify-content-center align-items-center">
                    <div class="col-md-6 col-lg-5 order-md-2">
                        <div class="d-flex justify-content-md-end py-3">
                            <div class="feature-text" style="--width: 24rem;">
                                <h4 class="font-800 h1 mb-3">Define the simple tasks for your customers</h4>
                                <p class="font-600 mb-0">Create simple tasks (like, sharing your social media post, follow your facebook page and drop a google review of your business etc) for your customers with a simple  drag and drop widget.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-5 order-md-1">
                        <div class="feature-image">
                            <img src="{{asset('assets/website/images/features/feature-two.png')}}" class="img-fluid" alt="Define the challenge">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- two - END --}}

        {{-- three --}}
        <div class="feature-container py-sm-5 py-3">
            <div class="container py-md-4">
                <div class="row justify-content-center align-items-center">
                    <div class="col-md-6 col-lg-5">
                        <div class="d-flex justify-content-md-start py-3">
                            <div class="feature-text" style="--width: 27rem;">
                                <h4 class="font-800 h1 mb-3">Setup a challenge program that works within few minutes</h4>
                                <p class="font-600 mb-0">Give your customers discounts for boosting your mouth publicity. They just need to complete the given challenge. The pre-decided discounts can be immediately availed by the customers</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-5">
                        <div class="feature-image">
                            <img src="{{asset('assets/website/images/features/feature-three.png')}}" class="img-fluid" alt="Setup a challenge program">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- three - END --}}

        {{-- four --}}
        <div class="feature-container py-sm-5 py-3">
            <div class="container py-md-4">
                <div class="row justify-content-center align-items-center">
                    <div class="col-md-6 col-lg-5 order-md-2">
                        <div class="d-flex justify-content-md-end py-3">
                            <div class="feature-text" style="--width: 25rem;">
                                <h4 class="font-800 h1 mb-3">Not just views, track the clicks</h4>
                                <p class="font-600 mb-0">Get the exact number of clicks that your post and campaign messages have got and measure the reach of different social media pages to enhance social media activity.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-5 order-md-1">
                        <div class="feature-image">
                            <img src="{{asset('assets/website/images/features/feature-four.png')}}" class="img-fluid" alt="Track the clicks">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- four - END --}}

        {{-- five --}}
        <div class="feature-container py-sm-5 py-3">
            <div class="container py-md-4">
                <div class="row justify-content-center align-items-center">
                    <div class="col-md-6 col-lg-5">
                        <div class="d-flex justify-content-md-start py-3">
                            <div class="feature-text" style="--width: 25rem;">
                                <h4 class="font-800 h1 mb-3">Full control over your business word of mouth campaigns</h4>
                                <p class="font-600 mb-0">Regulate your business word-of-mouth campaign and keep it under your supervision without any trouble</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-5">
                        <div class="feature-image">
                            <img src="{{asset('assets/website/images/features/feature-five.png')}}" class="img-fluid" alt="Word of mouth campaigns">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- five - END --}}
        

    </div>
</section>

{{-- Latest Blogs --}}
@if ($blogs != null)
<section id="blogs">
    <div class="pt-5">
        <div class="container">
            <div class="row">
                <div class="owl-carousel owl-theme px-0" id="blog-slider">
                    @foreach($blogs as $blog)
                    <div class="item" >
                        <div class="blog-item p-3">
                            <div class="blog_card bl_grid" style="height: 100%;">
                                <a href="{{url('blogs'.'/'.$blog->slug)}}">
                                    <div class="bl_inner border_ shadow-sm" style="height: 100%;">
                                        <div class="bl_flex">
                                            <div class="image_col">
                                                <div class="image_thumb" style="@if($blog->image != '')background-image:url({{asset('assets/blogs/banners/'.$blog->image)}})@endif"></div>
                                            </div>
                                            <div class="content_col">
                                                <div class="inner">
                                                    <h5 class="title font-600">{{ $blog->title }}</h5>
                                                    <p class="excerpt">{!! substr(strip_tags($blog->content), 0, 256) !!}</p>
                                                    <span class="btn btn-link-ol btn-sm" onclick="window.location.href='{{url('blogs'.'/'.$blog->slug)}}'">
                                                        <span>Read More</span>
                                                        <i class="bi bi-arrow-right"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif


{{-- Call to Action  --}}
<section id="call_to_action">
    <div class="py-5">
        <div class="container">

            <div class="action-box bg-color-gradient">
                <div class="inner" style="--width:991px;">
                    <div class="mb-4">
                        <h4 class="font-800 text-capitalize_ h2">Get your happy customers to share about your business anytime, anywhere with MouthPublicity.io</h4>
                    </div>
                    <div>
                        <a href="{{url('signin?tab=register')}}" class="btn btn-outline-light px-4 text-uppercase font-700">get started for free</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


@endsection

@push('js')
    {{-- typed js (for typing effect) --}}
    {{-- <script src="{{ asset('assets/website/vendor/typed/js/typed.min.js') }}"></script> --}}

    {{-- Owl carousel --}}
    {{-- <script src="{{ asset('assets/website/vendor/owl.carousel/js/owl.carousel.min.js') }}"></script> --}}
@endpush

@push('end_body')
{{-- <script>
    $(document).ready(function() {
        $(".typed").typed({
            strings: ["Brand Ambassador", "Promoter", "Guide"],
            typeSpeed: 30,
            loop:1
        });
    });
</script> --}}
<script>
$(document).ready(function(){
    //for product
    $('#product').owlCarousel({
        items:3,
        loop: true,
        margin:15,
        stagePadding: 1,
        responsive:{
            991:{
                items:3
            },
            768:{
                items:2
            },
            0:{
                items:1
            }
        }
       
    });
    //for blog
    $('#blog-slider').owlCarousel({
        items: 3,
        loop: true,
        margin: 0,
        responsive:{
            991:{
                items:3
            },
            768:{
                items:2.1
            },
            0:{
                items:1.2
            }
        }
       
    });
});

</script>
<script>
    // var video_id = 'xIN7W55-j3s';
    var video_id = 'V0fs0nNLbcs';
    // 1. get height and width of window
    var winWidth = $('.youtube_video').width();
    var setVidHeight =  (winWidth / 100) * 57;
    // 2. This code loads the IFrame Player API code asynchronously.
    var tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    // 3. This function creates an <iframe> (and YouTube player)
    var player;
    function onYouTubeIframeAPIReady() {
        player = new YT.Player('player', {
            height:parseInt(setVidHeight),
            width: parseInt(winWidth),
            videoId: video_id,
            playerVars: {
                'rel':0,
                'showinfo':0,
                'playsinline': 1,
                'fs':0,
                'mute':0,
                'autoplay':0,
            },
            events: {
                // 'onReady': onPlayerReady,
            }
        });
    }
    // 4. The API will call this function when the video player is ready.
    function onPlayerReady(event) {
        // event.target.playVideo();
    }
    function playVideo() {
        player.playVideo();
    }

    $("#playnow").on("click", function(event){
        event.preventDefault();
        player.seekTo(0);
        playVideo();
        player.unMute();
        
        $(this).hide();
    });
</script>
<script>
    // var main_nav = $("#mainNavCollapse");
    // $("body").click(function( event ) {
    //     console.log('ID: '+event.target.id);
    //     if(main_nav.hasClass('show')){
    //         if(event.target.id !== 'mainNavCollapse'){
    //             console.log("Clicked");
    //             main_nav.toggle("hide");
    //             // $("#close_main_navigation").click();
    //             // $(".navbar-toggler").click();
    //         }
    //     }
    // });
</script>
@endpush