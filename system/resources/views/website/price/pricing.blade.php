@extends('layouts.website')
@section('title', 'Plans and Pricing - MouthPublicity.io')
@section('description', 'Upgrade to MouthPublicity.io and Convert your customers to mouth publicity marketing team. Get it at an incomparable price.')
{{-- @section('keywords', 'why MouthPublicity.io, what is MouthPublicity.io, mission of MouthPublicity.io, about us MouthPublicity.io') --}}
@section('image', asset('assets/website/images/pricing/pricing-banner.png'))

@section('end_head')
<link rel="stylesheet" href="{{asset('assets/website/vendor/rangeslider.js-2.3.0/rangeslider.css')}}">

<style>
    .pricing-banner img{
        width: 500px;
    }
    .btn-opn-green{
        background: rgba(27, 144, 18, 1);
        color: #fff;
    }
    .text-opn-green{
        color: rgba(27, 144, 18, 1);
    }
    .pricing-range{
        width: 100%;
        box-shadow: inset 3px 3px 5px rgba(0,0,0, .15);
        border-radius: 80px;
        background: #f6f6f6;
        padding: 20px 10px;
    }
    /* .pricing-range .range__input{
        width: 100%;
        display: block;
    } */
    #range_amount_input{
        width: 100%!important;
    }
    .pricing-input{
        width: 100%;
        box-shadow: inset 3px 3px 5px rgba(0,0,0, .15);
        background: #f6f6f6;
        border-radius: 80px;
        height: 48px;
        padding-left: 18px;
        font-weight: 600;
        font-size: 1.3rem;
    }
    .social-count-card {
        background: #f6f6f6;
        box-shadow: inset 3px 3px 5px rgba(0,0,0, .15);
        border-radius: 18px;
        opacity: 1;
        backdrop-filter: blur(30px);
        -webkit-backdrop-filter: blur(30px);
        padding-left: 2rem;
    }
    .pricing-card-social-icons li{
        text-decoration: none;
        display: inline-block;
        list-style: none;
    }

    .range__thumb{
        position: absolute;
        left: 0;
	    bottom: 40px;
        background-color: rgb(var(--color-primary));
        transform: translateX(-50%);
        border-radius: 8px;
        color:#fff ;
        font-weight: 600;
        font-size: 14px;
        padding: 8px 10px;
        line-height: 1;
        z-index: 2;
        min-width: 82px;
        text-align: center;
    }
    .range__thumb::before{
        content: '';
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        border-top: 8px solid rgb(var(--color-primary));
        border-left: 8px solid transparent;
        border-right: 8px solid transparent;
    }



    .rangeslider, .rangeslider__fill{
        -webkit-box-shadow: inset 0px 1px 3px rgb(0 0 0 / 15%); */
        box-shadow: inset 0px 1px 3px rgb(0 0 0 / 15%); */
    }
    .rangeslider--horizontal{
        height: 8px;
    }
    .rangeslider__fill{
        background: rgb(var(--color-primary));
    }
    .rangeslider--horizontal .rangeslider__handle{
        top: -8px;
        width: 25px;
        height: 25px;
        background-image:none;
    }
    .rangeslider--horizontal .rangeslider__handle:after{
        width: 15px;
        height: 15px;
        background: rgba(var(--color-primary), 1)
    }
    
    .pd-icon{
        position: relative;
        width: 70px;
    }
    .pd-text{
        width: calc(100% - 70px);
    }
    /* feature table */
    
   
    .pricing-features .card-footer{
        background-color: transparent;
        border-top: 0;
    }
    .price-detail-type{
        position: relative;
        height: 100%;
    }
    .price-detail-type .price-detail-type-inner{
        position: relative;
        height: 100%;
        
        /* padding: 24px 24px 48px; */
        box-shadow: rgb(0 0 0 / 8%) 0px 2px 4px 0px;
        -webkit-box-shadow: rgb(0 0 0 / 8%) 0px 2px 4px 0px;
        border-radius: 1rem;
        border: 1px solid rgb(218, 222, 224);
        background: rgb(255, 255, 255);
        transition: all 0.2s ease-out 0s;
        display: flex;
        flex-flow: column nowrap;
        width: 100%;
        box-sizing: border-box;
    }
    .price-detail-type:hover .price-detail-type-inner{
        transform: translateY(-0.1875rem);
        box-shadow: rgb(50 50 93 / 10%) 0px 1.125rem 2.1875rem, rgb(0 0 0 / 7%) 0px 0.5rem 0.9375rem;
        -webkit-box-shadow: rgb(50 50 93 / 10%) 0px 1.125rem 2.1875rem, rgb(0 0 0 / 7%) 0px 0.5rem 0.9375rem;
    }
    .price-detail-type .price-detail-type-inner.recommended::before{
        content: "recommended";
        padding: 6px 14px;
        border-radius: 15px;
        margin-left: 36px;
        /* background-color: rgb(122, 219, 255); */
        text-transform: uppercase;
        font-size: 14px;
        font-weight: bold;
        color: #FFF;
        display: inline;
        position: absolute;
        top: -1rem;

        background: linear-gradient(316deg,rgba(var(--color-one),1) 0,rgba(var(--color-two),1) 100%);
    }
    #how-we-are-free{
        background: rgba(var(--color-two),.025) linear-gradient(180deg,#fff 0,rgba(var(--color-two),.02) 100%) 0 0 no-repeat padding-box;
    }
    

    .price-card{
        position: relative;
        width: 100%;
        max-width: 1180px;
        /* background: #FFF; */
        border-radius: 8px;
        margin: auto;
    }
    .price-card-inner{
        position: relative;
        z-index: 2;
    }
    .br-left-to-top {
        border-radius: 1rem 0 0 1rem;
        border: 1px solid #dee2e6;
        border-right: 0px;
    }
    .br-right-to-bottom {
        border-radius: 0 1rem 1rem 0;
        border: 1px solid #dee2e6;
    }
    .info-btn {
        color: inherit;
        font-size: 18px;
    }
    .btn-white{
        border-radius: 100px;
        padding: 8px 25px;
        background: #32ffc1;
        color: #0f60a1;
    }
    .pd-icon img{
        width: 100%;
        max-width: 60px;
    }
    /* .price-detail-inner-section-two{
        background: rgba(var(--color-two),.025) linear-gradient(180deg,#fff 0,rgba(var(--color-two),.02) 100%) 0 0 no-repeat padding-box;
        border-radius: 0 0 1rem 1rem;
    }    */

    .accordion {
        --bs-accordion-bg: transparent;
    }
    
    @media (min-width: 768px) and (max-width: 991px){
        .beaktag{
            display: none;
        }
        
    }   
    @media(max-width: 767px){
        .br-left-to-top {
            border-radius: 1rem 1rem 0 0;
            border-bottom: 0px;
            border-right:1px solid #dee2e6; 
        }
        .br-right-to-bottom {
            border-radius: 0 0 1rem 1rem;
        }
    }
    @media(max-width: 574px){
        .recharge-button, .free-button{
            font-size: 12px;
        }
    }
</style>
@endsection

@section('content')
{{-- Banner Section --}}
<section id="banner">
    <div class="position-relative bg-dots">
        <div class="container">
            {{-- Breadcrumb Section --}}
            @php
                $bcrm = array(
                    array('name' => 'Pricing', 'link' => false),
                );
            @endphp
            @include('website.components.breadcrumb', $bcrm)
        </div>
        <div class="banner_bg pt-4">
            <div class="container">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-5 col-lg-5 order-md-2 order-lg-2">
                        <div class="pricing-banner">
                            <img src="{{ asset('assets/website/images/pricing/pricing-banner.png') }}" class="img-fluid" alt="MouthPublicity.io Pricing">
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 mt-5 mt-md-0 mb-0 mb-lg-5 order-md-1 order-lg-1">
                        <div class="banner-block pe-xl-5">
                            <h1 class="mb-3 text-uppercase h2 font-900 color-primary">you are not dreaming.<br clas> Yes, we are free for lifetime!</h1>
                            {{-- <h2 class="mb-3 h5 text-uppercase font-600">CURATED TO TACKLE YOUR BUSINESS MARKETING NEED</h2> --}}
                            <h5>Initiate, Boost, Manage and track publicity like never before and convert your customers to mouth publicity marketing team now.</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    </div>
</section>
{{-- how we are free --}}
{{-- <section id="how-we-are-free" class="mt-5 py-4">
    <div class="container">
        <div class="pt-5 text-center">
            <h4 class="text-capitalize h2 font-900 mb-3">How we are free
            </h4>
        </div>
        <div class="my-5">
            <div class="row justify-content-center align-content-center">
                <div class="col-md-6 col-lg-6 col-xl-5">
                    <div class="text-center">
                        <img src="{{asset('assets/website/images/pricing/free.svg')}}" alt="" class="w-25 shadow rounded-circle">
                        <h4 class="font-800 mt-3">Free Access to all product features</h4>
                        <p>Free access to all features that helps you to make more out of mouthpublicity.io efficiently for your brand.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-5">
                    <div class="text-center">
                        <img src="{{asset('assets/website/images/pricing/recharge.svg')}}" alt="" class="w-25 shadow rounded-circle">
                        <h4 class="font-800 mt-3">Recharge Anytime: simple as you go</h4>
                        <p>Recharge anytime to access pro features to full extent. No auto debit, no plan expiration limit, Recharge as you go based on usage.</p>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</section> --}}
{{--New Pricing--}}
<section id="pricing-new" class="pb-md-5">
    <div class="container">
        {{-- new table design --}}
        <div class="my-5 pt-3">
            <div class="pricing-features">
                {{-- card one --}}
                <div>
                    <h4 class="h2 text-center font-900 text-capitalize mb-3">How and Why we are free?
                    </h4>
                    <div class="row justify-content-center">
                        <div class="col-md-12 col-lg-8 col-xl-8">
                            <div class="h-100 price-detail-type">
                                <div class="price-detail-type-inner p-5">
                                    <div class="card-head">
                                        <h4 class="font-800 mb-4 color-primary">Free Mouth Publicity</h4>
                                        <p class="text-secondary">Best for micro business, Micro-Nano Influencers &
                                            individuals</p>
                                        <p>Free Lifetime access to all product features</p>
                                        {{-- <h6> <span class="font-800" style="font-size:26px;">&#8377;0.00</span>/lifetime free for one or more people</h6> --}}
                                        <h6 class="text-capitalize mt-4 mb-3 font-700">features you'll love</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="d-flex">
                                                    <i class="bi bi-check2-circle me-3 color-primary"></i>
                                                    <p class="text-capitalize">All offer Templates Access</p>
                                                </div>
                                                <div class="d-flex">
                                                    <i class="bi bi-check2-circle me-3 color-primary"></i>
                                                    <p class="text-capitalize">social media integration</p>
                                                </div>
                                                <div class="d-flex">
                                                    <i class="bi bi-check2-circle me-3 color-primary"></i>
                                                    <p class="text-capitalize">unlimited user accounts</p>
                                                </div>
                                                <div class="d-flex">
                                                    <i class="bi bi-check2-circle me-3 color-primary"></i>
                                                    <p class="text-capitalize">import customer's contacts</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex">
                                                    <i class="bi bi-check2-circle me-3 color-primary"></i>
                                                    <p class="text-capitalize">generate QR code</p>
                                                </div>
                                                <div class="d-flex">
                                                    <i class="bi bi-check2-circle me-3 color-primary"></i>
                                                    <p class="text-capitalize">Send instant & share Challenge on (WhatsApp
                                                        only)</p>
                                                </div>
                                                <div class="d-flex">
                                                    <i class="bi bi-check2-circle me-3 color-primary"></i>
                                                    <p class="text-capitalize">integrate messaging API (Whatsapp only)</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-center">
                                        <a href="{{url('signin?tab=register')}}" class="btn btn-outline-dark text-capitalize px-2 px-sm-4 py-2 mt-4 free-button">Get free lifetime access now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- card two --}}
                <div class="mt-5">
                    <h4 class="h2 text-center font-900 text-capitalize">what is our revenue model?
                    </h4>
                    <p class="text-center">Business owner who wants in depth statistics by paying minimal cost</p>
                    <div class="row justify-content-center mt-4">
                        <div class="col-md-12 col-lg-8 col-xl-8">
                            <div class="price-detail-type h-100">
                                <div class="price-detail-type-inner recommended">
                                    <div class="card-head p-5 pb-0">
                                        <h4 class="font-800 mb-3 color-primary">Pro Mouth Publicity</h4>
                                        <p class="text-secondary">Best for startups, Small & Medium Businesses,
                                            Enterprises and PR Marketing Agencies.</p>
                                        {{-- <h6> <span class="font-800" style="font-size:26px;">&#8377;1990.00</span>/ year  for one or more people</h6> --}}
                                        <h6 class="text-capitalize font-700 mt-4">features you'll love</h6>
                                    </div>
                                    <div class="card-body px-5 pb-3 pt-0">
                                        <h5 class="font-800 color-primary text-capitalize mb-3">Everything in Free
                                            Account Plus</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="d-flex">
                                                    <i class="bi bi-check2-circle me-3 color-primary"></i>
                                                    <p class="text-capitalize">personalised messaging</p>
                                                </div>
                                                <div class="d-flex">
                                                    <i class="bi bi-check2-circle me-3 color-primary"></i>
                                                    <p class="text-capitalize">Redeem Code Management</p>
                                                </div>
                                                <div class="d-flex">
                                                    <i class="bi bi-check2-circle me-3 color-primary"></i>
                                                    <p class="text-capitalize">customer activity reporting</p>
                                                    </p>
                                                </div>
                                                <div class="d-flex">
                                                    <i class="bi bi-check2-circle me-3 color-primary"></i>
                                                    <p class="text-capitalize">customer task completion of instant
                                                        challenge </p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex">
                                                    <i class="bi bi-check2-circle me-3 color-primary"></i>
                                                    <p class="text-capitalize">instant & share challenge pro Access
                                                    </p>
                                                </div>
                                                <div class="d-flex">
                                                    <i class="bi bi-check2-circle me-3 color-primary"></i>
                                                    <p class="text-capitalize">WhatsApp + SMS messaging
                                                        channels(WhatsApp + SMS)</p>
                                                </div>
                                                <div class="d-flex">
                                                    <i class="bi bi-check2-circle me-3 color-primary"></i>
                                                    <p class="text-capitalize">Integrate Messaging API (WhatsApp + SMS)
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>    
                                    <div class="price-detail-inner-section-two  pt-3">
                                        <div class="bg-light p-5 pb-2">
                                            <h5 class="font-800 color-primary text-capitalize mb-3">You Will Be Charged As Per The Below Actions</h5>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="pd-text- d-flex justify-content-between">
                                                        <p> <span class="font-600">&#8377;00.17</span> per SMS</p>
                            
                                                        <span class="info-btn ms-2" data-bs-toggle="tooltip"
                                                            title="You will be charged as per SMS usage across all apps/products."><i
                                                                class="bi bi-info-circle"></i></span>
                                                        {{-- <p class="small mb-1">You will be charged as per SMS usage across all apps/products.<br><a href="#" class="fw-bold text-decoration-none text-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#pr-collapce-01" aria-expanded="false">For Example</a></p>
                                                                    <div class="collapse" id="pr-collapce-01">
                                                                        <p class="small mb-0">when an offer is sent to your customer through Instant Challenge (or any apps) then &#8377;0.17 will be deducted from your MouthPublicity.io account balance.</p>
                                                                    </div> --}}
                                                    </div>
                                                    <div class="pd-text- d-flex justify-content-between">
                                                        <p><span class="font-600">&#8377;2.50</span>  per completed Instant Challenge</p>
                                                        <span class="info-btn ms-2" data-bs-toggle="tooltip"
                                                            title="You will be charged as per the number of Instant Challenge completed by the user."><i
                                                                class="bi bi-info-circle"></i></span>
                                                        {{-- <p class="small mb-1">You will be charged as per the number of Instant Challenge completed by the user.<br><a href="#" class="fw-bold text-decoration-none text-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#pr-collapce-02" aria-expanded="false">For Example</a></p>
                                                                    <div class="collapse" id="pr-collapce-02">
                                                                        <p class="small mb-0">When customers will complete your instant challenge then &#8377;2.50 will be deducted from your MouthPublicity.io account balance.</p>
                                                                    </div> --}}
                                                    </div>
                                                    <div class="pd-text- d-flex justify-content-between">
                                                        <p><span class="font-600"> &#8377;00.10 </span> Unique click of Share Challenge</p>
                                                        <span class="info-btn ms-2" data-bs-toggle="tooltip"
                                                            title="You will be charged as per the number of Unique Click while using Share Challenge."><i
                                                                class="bi bi-info-circle"></i></span>
                                                        {{-- <p class="small mb-1">You will be charged as per the number of Instant Challenge completed by the user.<br><a href="#" class="fw-bold text-decoration-none text-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#pr-collapce-02" aria-expanded="false">For Example</a></p>
                                                                    <div class="collapse" id="pr-collapce-02">
                                                                        <p class="small mb-0">When customers will complete your instant challenge then &#8377;2.50 will be deducted from your MouthPublicity.io account balance.</p>
                                                                    </div> --}}
                                                    </div>

                                                </div>
                                                <div class="col-md-6">
                                                    <div class="pd-text- d-flex justify-content-between">
                                                        <p><span class="font-600">&#8377;5.00</span> per day per active user</p>
                                                        <span class="info-btn ms-2" data-bs-toggle="tooltip"
                                                            title="You will be charged as per the number of users panel on a daily basis with unlimited login session."><i
                                                                class="bi bi-info-circle"></i></span>
                                                        {{-- <p class="small mb-1">You will be charged as per the number of users panel on a daily basis with unlimited login session.<br><a href="#" class="fw-bold text-decoration-none text-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#pr-collapce-04" aria-expanded="false">For Example</a></p>
                                                                    <div class="collapse" id="pr-collapce-04">
                                                                        <p class="small mb-1">When your employee is logged in through the employee panel (to share & redeem your current challenge) then &#8377;5 will be deducted from your MouthPublicity.io account balance.</p>
                                                                        <p class="small mb-0 fst-italic"><b>Note:</b> Charges are applicable irrespective of the number of logins in a day. No charges will be deducted if your employee doesn't login throughout the day. </p>
                                                                    </div> --}}
                                                    </div>
                                                    <div class="pd-text- d-flex justify-content-between">
                                                        <p><span class="font-600">&#8377;10</span> per day for Unlimited Messaging</p>
                                                        <span class="info-btn ms-2" data-bs-toggle="tooltip"
                                                            title="Enable your Messaging API toggle and send unlimited messages at &#8377;10 per day."><i
                                                                class="bi bi-info-circle"></i></span>
                                                        {{-- <p class="small mb-1">Enable your Messaging API toggle and send unlimited messages at &#8377;10 per day.<br><a href="#" class="fw-bold text-decoration-none text-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#pr-collapce-05" aria-expanded="false">For Example</a></p>
                                                                    <div class="collapse" id="pr-collapce-05">
                                                                        <p class="small mb-1">On enabling the Messaging API, you will be charged Rs. 10 per day irrespective of number of messages sent. If Messaging API is disabled then no amount will be deducted from your balance.</p>  
                                                                    </div> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- price select section --}}
                                        <div class="text-center p-5 pt-0">
                                            <div class="row justify-content-between my-4 my-md-5">
                                                <div class="col-lg-4 col-xl-3 text-start">
                                                    <label for="" class="mb-0 font-small font-600">Amount</label>
                                                    <input type="number" name="amount" id="payable_amount_input" value="2000"
                                                        class="form-control my-2 my-sm-0 pricing-input" min="100" max="100000"
                                                        placeholder="e.g 2000">
                                                </div>
                            
                                                <div class="col-lg-8 col-xl-9 text-start mt-4 mt-lg-0">
                                                    <label for="" class="mb-0 font-small font-600">Select the amount range</label>
                                                    <div class="pricing-range d-block px-4">
                                                        <div class="position-relative">
                                                            <span class="range__thumb" id="range__thumb">2000</span>
                                                            <input class="range__input my-2 my-sm-0" id="range_amount_input" type="range"
                                                                value="2000" min="100" max="100000" step="1">
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-between mt-2">
                                                        <h6 class="font-800 color-primary">&#8377; 100</h6>
                                                        <h6 class="font-800 color-primary">&#8377; 1,00,000</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <div class="pt-4 pb-0">
                                                                        <div class="row justify-content-center">
                                                                            <div class="col-sm-5">
                                                                                <div class="social-count-card text-start py-2 my-2 my-sm-0 px-4">
                                                                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                                                                        <h6 class="font-800 color-primary">Reach</h6>
                                                                                        <span class="info-btn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Lorem Ipsum is simply dummy text of the printing"><i class="bi bi-info-circle"></i></span>
                                                                                    </div>
                                                                                    
                                                                                    <div class="icons">
                                                                                        <ul class="pricing-card-social-icons ps-0 mb-0">
                                                                                            <li class="me-1"><i class="bi bi-facebook" style="color: #3b5998;"></i></li>
                                                                                            <li class="me-1"><i class="bi bi-instagram" style="color:#d62976;" ></i></li>
                                                                                            <li class="me-1"><i class="bi bi-twitter"  style="color: #1DA1F2;"></i></li>
                                                                                        </ul>
                                                                                    </div>
                                                                                    <h3 class="font-800 h2 color-primary" id="aprox_reach">000</h3>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-5">
                                                                                <div class="social-count-card text-start py-2 my-2 my-sm-0 px-4">
                                                                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                                                                        <h6 class="font-800 color-primary">Engagement</h6>
                                                                                        <span class="info-btn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip"  data-bs-title="Lorem Ipsum is simply dummy text of the printing"><i class="bi bi-info-circle"></i></span>
                                                                                    </div>
                                                                                    <div class="icons">
                                                                                        <ul class="pricing-card-social-icons ps-0 mb-0">
                                                                                            <li class="me-1"><i class="bi bi-facebook" style="color: #3b5998;"></i></li>
                                                                                            <li class="me-1"><i class="bi bi-instagram" style="color:#d62976;" ></i></li>
                                                                                            <li class="me-1"><i class="bi bi-twitter"  style="color: #1DA1F2;"></i></li>
                                                                                        </ul>
                                                                                    </div>
                                                                                    <h3 class="font-800 h2 color-primary" id="aprox_engagement">3,00,000</h3>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div> --}}
                            
                                            <div class="text-center my-4 mt-md-5">
                                                <button class="btn btn-primary-ol recharge-button btn-lg font-700 text-capitalize" id="recharge_now"
                                                    style="border-radius: 100px;">Recharge now & get pro access</button>
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
</section>


{{--commen questions--}}
<section id="common-questions">
    <div class="bg-light">
        <div class="container">
            <div class="py-5">
                <h4 class="text-center h2 font-600">Common Questions</h4>
                {{-- <div class="row mt-5 justify-content-center">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-5">
                        <h5 class="font-700 mb-3">What are Instant & Share Challenge?</h5>
                        <p><a href="">Instant Challenge</a>  is the quickest way to increase word of mouth through social media. Ask your customers to complete simple tasks like follow, like, comment & share posts and give them a discount or gifts for recent purchases.</p>
                        <p><a href="">Share Challenge</a> offers Cash Per Click, Fixed Amount, and Percentage Discounts to boost your brand’s word of mouth. Subscribed customers share an offer or landing page link via WhatsApp to reach a target. Completed challenges earn future benefits.</p>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-5 mt-5 mt-md-0">
                        <h5 class="font-700 mb-3">What is a redeem code?</h5>
                        <p>Your customers receive a redemption code after completing the challenge, which they can share with you (business owner) to claim a gift, discount or future benefits.</p>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-5 mt-5">
                        <h5 class="font-700 mb-3">Can I start for free?</h5>
                        <p>Absolutely. <a href="">MouthPublicity.io</a> is a lifetime free with all features. No credit card is required to start your first mouth publicity campaign. If you want a pro access then you have to recharge, see pricing page.</p>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-5 mt-5">
                        <h5 class="font-700 mb-3">What are the call or chat support hours?</h5>
                        <p>Monday to Friday during business hours of 9:00am-5:00pm IST.</p>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-5 mt-5">
                        <h5 class="font-700 mb-3">What is the minimum amount I can recharge with?</h5>
                        <p>You can recharge with minimum Rs.100 & start access all Pro features of mouthpublicity.io</p>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-5 mt-5">
                        <h5 class="font-700 mb-3">How do I became offer a partner or reseller program?</h5>
                        <p>You bet. Contact us <a href="mailto:enterprise@mouthpublicity.io">enterprise@mouthpublicity.io</a></p>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-5 mt-5">
                        <h5 class="font-700 mb-3">Do I need a developer or any technical expertise to use MouthPublicity.io?</h5>
                        <p>Nope. Creating and launching a challenge with mouthpublicity.io is as easy as 1-2-3. Anybody who uses a smartphone or browser on desktop/ laptop can easily use mouthpublicity.io for his/her brand’s mouth publicity. And if you need a hand, we're always here to help!</p>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-5 mt-5">
                        <h5 class="font-700 mb-3">Does it work best for an offline store or online business?</h5>
                        <p>MouthPublicity.io works best for both offline and online users.</p>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-5 mt-5">
                        <h5 class="font-700 mb-3">What happens at the end of my recharge balance?</h5>
                        <p>Your mouthpublcity.io account will be shifted from pro to a free plan, You can also recharge immediately or use it for free. It's up to you.</p>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-5 mt-5">
                        <h5 class="font-700 mb-3">I have more questions. Where can I find answers?</h5>
                        <p>No worries! Please get in touch with us at the <a href="">contact page</a>, we'll get back to you ASAP!</p>
                    </div>
                </div> --}}
                <div class="row justify-content-center">
                    <div class="col-xl-8 col-lg-8 col-12 px-0 px-sm-3">
                        <div class="accordion faq-accord" id="faq_accordian">
                            <div class="accordion-item">
                                <div class="accordion-header" data-bs-toggle="collapse" data-bs-target="#pricingfaqs1" aria-expanded="false" aria-controls="pricingfaqs1">
                                    <h4 class="faq-que">What are Instant & Share Challenge?</h4>
                                </div>
                                <div id="pricingfaqs1" class="accordion-collapse collapse show">
                                    <div class="accordion-body">
                                        <p class="faq-ans"><a href="{{route('channels', 'instant-challenge')}}">Instant Challenge</a>  is the quickest way to increase word of mouth through social media. Ask your customers to complete simple tasks like follow, like, comment & share posts and give them a discount or gifts for recent purchases.</p>
                                        <p class="faq-ans"><a href="{{route('channels', 'share-challenge')}}">Share Challenge</a> offers Cash Per Click, Fixed Amount, and Percentage Discounts to boost your brand’s word of mouth. Subscribed customers share an offer or landing page link via WhatsApp to reach a target. Completed challenges earn future benefits.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <div class="accordion-header collapsed" data-bs-toggle="collapse" data-bs-target="#pricingfaqs2" aria-expanded="false" aria-controls="pricingfaqs2">
                                    <h4 class="faq-que">What is a redeem code?</h4>
                                </div>
                                <div id="pricingfaqs2" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <p class="faq-ans">Your customers receive a redemption code after completing the challenge, which they can share with you (business owner) to claim a gift, discount or future benefits.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <div class="accordion-header collapsed" data-bs-toggle="collapse" data-bs-target="#pricingfaqs3" aria-expanded="false" aria-controls="pricingfaqs3">
                                    <h4 class="faq-que">Can I start for free?</h4>
                                </div>
                                <div id="pricingfaqs3" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <p class="faq-ans">Absolutely. MouthPublicity.io is a lifetime free with all features. No credit card is required to start your first mouth publicity campaign. If you want a pro access then you have to recharge, see pricing page.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <div class="accordion-header collapsed" data-bs-toggle="collapse" data-bs-target="#pricingfaqs4" aria-expanded="false" aria-controls="pricingfaqs4">
                                    <h4 class="faq-que">What are the call or chat support hours?</h4>
                                </div>
                                <div id="pricingfaqs4" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <p class="faq-ans">Monday to Friday during business hours of 9:00am-5:00pm IST.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <div class="accordion-header collapsed" data-bs-toggle="collapse" data-bs-target="#pricingfaqs5" aria-expanded="false" aria-controls="pricingfaqs5">
                                    <h4 class="faq-que">What is the minimum amount I can recharge with?</h4>
                                </div>
                                <div id="pricingfaqs5" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <p class="faq-ans">You can recharge with minimum Rs.100 & start access all Pro features of mouthpublicity.io</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <div class="accordion-header collapsed" data-bs-toggle="collapse" data-bs-target="#pricingfaqs6" aria-expanded="false" aria-controls="pricingfaqs6">
                                    <h4 class="faq-que">How do I became offer a partner or reseller program?</h4>
                                </div>
                                <div id="pricingfaqs6" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <p class="faq-ans">You bet. Contact us <a href="mailto:enterprise@mouthpublicity.io">enterprise@mouthpublicity.io</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <div class="accordion-header collapsed" data-bs-toggle="collapse" data-bs-target="#pricingfaqs7" aria-expanded="false" aria-controls="pricingfaqs7">
                                    <h4 class="faq-que">Do I need a developer or any technical expertise to use MouthPublicity.io?</h4>
                                </div>
                                <div id="pricingfaqs7" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <p class="faq-ans">Nope. Creating and launching a challenge with mouthpublicity.io is as easy as 1-2-3. Anybody who uses a smartphone or browser on desktop/ laptop can easily use mouthpublicity.io for his/her brand’s mouth publicity. And if you need a hand, we're always here to help!</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <div class="accordion-header collapsed" data-bs-toggle="collapse" data-bs-target="#pricingfaqs8" aria-expanded="false" aria-controls="pricingfaqs8">
                                    <h4 class="faq-que">Does it work best for an offline store or online business?</h4>
                                </div>
                                <div id="pricingfaqs8" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <p class="faq-ans">MouthPublicity.io works best for both offline and online users.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <div class="accordion-header collapsed" data-bs-toggle="collapse" data-bs-target="#pricingfaqs9" aria-expanded="false" aria-controls="pricingfaqs9">
                                    <h4 class="faq-que">What happens at the end of my recharge balance?</h4>
                                </div>
                                <div id="pricingfaqs9" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <p class="faq-ans">Your mouthpublcity.io account will be shifted from pro to a free plan, You can also recharge immediately or use it for free. It's up to you.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <div class="accordion-header collapsed" data-bs-toggle="collapse" data-bs-target="#pricingfaqs10" aria-expanded="false" aria-controls="pricingfaqs10">
                                    <h4 class="faq-que">I have more questions. Where can I find answers?</h4>
                                </div>
                                <div id="pricingfaqs10" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <p class="faq-ans">No worries! Please get in touch with us at the <a href="{{url('contact-us')}}">contact page</a>, we'll get back to you ASAP</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div> 
            </div>
        </div>
    </div>
</section>


{{-- FAQ new --}}
{{-- <div class="">
    <div class="row justify-content-center align-items-center mt-5">
        <div class="col-xl-12 col-lg-12 col-12 px-0 px-sm-3">
            <div class="accordion faq-accord" id="faq_accordian">
                <div class="accordion-item">
                    <div class="accordion-header" data-bs-toggle="collapse" data-bs-target="#pricingfaqs1" aria-expanded="false" aria-controls="pricingfaqs1">
                        <h4 class="faq-que">What is a redeem code?</h4>
                    </div>
                    <div id="pricingfaqs1" class="accordion-collapse collapse show">
                        <div class="accordion-body">
                            <p class="faq-ans">Your customers receive a redemption code after completing the challenge, which they can share with you (business owner) to claim a gift, discount or future benefits.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div> 
</div> --}}



<div class="loader-overlap" style="display: none;" id="loader">
    <div class="d-flex flex-column h-100 align-items-center justify-content-center">
        <div class="spinner-border text-white" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>

@endsection

@push('js')
<script src="{{asset('assets/website/vendor/rangeslider.js-2.3.0/rangeslider.min.js')}}"></script>
<script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
<script>
    function set_price(amount) {
        sessionStorage.setItem("payable_amount", amount);
    }
    function remove_price() {
        sessionStorage.removeItem("payable_amount");
    }

    function calc_aprox_roi(amount) {
        var amount = $("#payable_amount_input").val();
        
        const per_msg_price = 0.10;
        const per_user_cost = 0.50;
        const avg_reach_per_user = 400;
        
        /* Calculating reach */
        var reach =  (amount / per_user_cost) * avg_reach_per_user;
        var reach_value = Math.floor(reach);
        $("#aprox_reach").text(reach_value.toLocaleString());
    }

    function range_thumb(amount) {
        var range_input = document.getElementById("range_amount_input");
        var range_thumb = document.getElementById("range__thumb");
        const bulletPosition = (range_input.value / range_input.max),
        space = range_input.offsetWidth - range_thumb.offsetWidth;
        // range_thumb.style.left = (bulletPosition * space) + 'px';

        range_thumb.style.left = (bulletPosition * range_input.offsetWidth) + 'px';
        range_thumb.innerHTML = '&#8377; ' + amount;
    }
    
    $(function() {
        var amount = $("#payable_amount_input").val();
        $("#range_amount_input").val(amount).change();
        calc_aprox_roi(amount);
        range_thumb(amount);

        /* Check sessionStorage and add amount to inputs */
        var amount_stored = sessionStorage.getItem("payable_amount");
        if(amount_stored){
            var amount = amount_stored;
            $("#payable_amount_input").val(amount);
            $("#range_amount_input").val(amount);
            range_thumb(amount);
            calc_aprox_roi(amount);
        }


        $("#payable_amount_input").on("change", function() {
            let amount = $(this).val();
            $("#range_amount_input").val(amount).change();
            // range_thumb(amount);
            // calc_aprox_roi(amount);
        });

        $("#range_amount_input").rangeslider({
            polyfill: false,
            // update: true,
            onSlide: function(position, value) {
                if(value >= 100){
                    $("#payable_amount_input").val(value);
                    range_thumb(value);
                    calc_aprox_roi(amount);
                }
            },
        });

        $("#recharge_now").click(function(){
            var amount = $("#payable_amount_input").val();

            var url = "{{ route('checkout') }}";

            // console.log();

            if(amount >= 100){
                set_price(amount);
                window.location.href = url;

            }else{
                Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                    onOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                }).fire({
                    icon: 'error',
                    title: 'Please select a valid amount greater tha equals to 100.'
                })
            }

        });
    });
</script>

    
@endpush

@push('end_body')
    {{-- @include('website.scripts.pricing-js') --}}
@endpush