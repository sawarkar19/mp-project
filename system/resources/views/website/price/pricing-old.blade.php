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
        color: #fff;
        font-weight: 600;
        font-size: 14px;
        padding: 8px 10px;
        line-height: 1;
        z-index: 2;
        min-width: 82px;
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
    .table-bg-color{
        background-color: #F8FAFF;
    }
    .pricing-feature-table{
        max-width: 1100px;
        margin: auto;
        background-color:#fafafa;
    }
    /* .title-prcing-feature{
        margin-bottom: 0;
        padding: 10px 24px;
        line-height: 3;
        border-radius: 0.4rem;
        border: 1px solid #166DA2;
    } */
    .table-icon i{
     font-size: 22px;
    }
    .check-icon{
       color: #24D086;
    }
     .cross-icon{
        color: #F2335C;;
    } 
    /* .strip{
        background-color: #f2f6fc;
        border-radius: 0.3rem;
    } */
       .pricing-feature-table td{
        padding: 1rem 0.8rem !important;
        margin: 10px 0;
    }
    .table-padding td:first-child{
        padding-left: 2rem !important;
    }
    .table-padding td:last-child{
        padding-right: 2rem !important;
    }
    .pricing-feature-table.table-bordered:last-child{
        border-width: 0 !important;
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
                            <h1 class="mb-4 text-uppercase h2 font-900 color-primary">The Pricing Plan That Doesn't Need Comparison To Rethink</h1>
                            <h2 class="mb-4 h5 text-uppercase font-600">CURATED TO TACKLE YOUR BUSINESS MARKETING NEED</h2>
                            <p>Reach a wide range of audiences, find qualified leads and start making sales with MouthPublicity.io. Choose the plan and grow your business relatively more than your traditionally marketing methods with MouthPublicity.io.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    </div>
</section>

{{--New Pricing--}}
<section id="pricing-new" class="pb-md-5">
    <div class="container">
        <div class="text-center py-5">
            <div class="pricing-details">
                <h4 class="text-uppercase h2 font-800 mb-3 color-primary">PAY AS YOU GO</h4>
                <p class="mx-auto mb-0" style="max-width:780px;">Start using MouthPublicity.io with full potential and make your business mouth publicity remarkable. Simply recharge with minimum price of Rs.100 to get full access. Pay as you go with product usage.</p>
            </div>


            <div class="mt-5 mx-auto" style="max-width: 800px;">
                <div class="card border-0 p-sm-5 px-3 py-4 bg-light_" style="box-shadow: 15px 20px 60px rgb(0 0 0 / 15%);border-radius:15px;">
                    <div class="row justify-content-between">
                        <div class="col-md-3 col-sm-4 text-start">
                            <label for="" class="mb-0 font-small font-600">Amount</label>
                            <input type="number" name="amount" id="payable_amount_input" value="2000" class="form-control my-2 my-sm-0 pricing-input" min="100" max="100000" placeholder="e.g 2000">
                        </div>
                        
                        <div class="col-md-9 col-sm-8 text-start">
                            <label for="" class="mb-0 font-small font-600">Select the amount range</label>
                            <div class="pricing-range d-block px-4">
                                <div class="position-relative">
                                    <span class="range__thumb" id="range__thumb">2000</span>
                                    <input class="range__input my-2 my-sm-0" id="range_amount_input" type="range" value="2000" min="100" max="100000" step="1">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <h6 class="color-primary font-800">&#8377; 100</h6>
                                <h6 class="color-primary font-800">&#8377; 1,00,000</h6>
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
                    
                    <div class="text-center mt-4 mt-md-5">
                        <button class="btn btn-primary-ol btn-lg" id="recharge_now">Recharge Now</button>
                    </div>
                </div>
            </div>    
        </div>
        <div class="pt-5">
            <div class="pricing-describtion">
                <h4 class="h2 font-800 mb-3 color-primary">You will be charged as per the below actions: </h4>
                <p>We understand that pricing is an important factor before you make a purchase, and that's why we have made all of our charges transparent. Cost will be charged as per below:</p>
            </div>
            <div class="mt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-lg-7 pb-5">
                        {{-- <div class="d-flex align-items-center_ mb-3">  
                            <div class="pd-icon">
                                <img src="{{ asset('assets/website/images/pricing/pricing-icon-whatsapp.png') }}" class="w-100" alt="WhatsApp">
                            </div>
                           <div class="pd-text ms-4">
                                <h5 class="font-800 color-primary">Rs 00.10/ WhatsApp</h5>
                                <p class="small mb-0">Reach a wide range of audiences, find qualified leads and start</p>
                           </div>
                        </div> --}}
                        <div class="d-flex align-items-center_ mb-3">  
                            <div class="pd-icon">
                                <img src="{{ asset('assets/website/images/pricing/pricing-icon-sms.png') }}" class="w-100" alt="MouthPublicity.io SMS Charges">
                            </div>
                           <div class="pd-text ms-4">
                                <h5 class="font-800 color-primary">&#8377;00.17 per SMS</h5>
                                <p class="small mb-1">You will be charged as per SMS usage across all apps/products.<br><a href="#" class="fw-bold text-decoration-none text-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#pr-collapce-01" aria-expanded="false">For Example</a></p>
                                <div class="collapse" id="pr-collapce-01">
                                    <p class="small mb-0">when an offer is sent to your customer through Instant Challenge (or any apps) then &#8377;0.17 will be deducted from your MouthPublicity.io account balance.</p>
                                </div>
                           </div>
                        </div>
                        <div class="d-flex align-items-center_ mb-3">  
                            <div class="pd-icon">
                                <img src="{{ asset('assets/website/images/pricing/pricing-icon-qrcode.png') }}" class="w-100" alt="MouthPublicity.io Instant Cahllenge Charges">
                            </div>
                           <div class="pd-text ms-4">
                                <h5 class="font-800 color-primary">&#8377;2.50 per completed Instant Challenge</h5>
                                <p class="small mb-1">You will be charged as per the number of Instant Challenge completed by the user.<br><a href="#" class="fw-bold text-decoration-none text-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#pr-collapce-02" aria-expanded="false">For Example</a></p>
                                <div class="collapse" id="pr-collapce-02">
                                    <p class="small mb-0">When customers will complete your instant challenge then &#8377;2.50 will be deducted from your MouthPublicity.io account balance.</p>
                                </div>
                           </div>
                        </div>
                        <div class="d-flex align-items-center_ mb-3">  
                            <div class="pd-icon">
                                <img src="{{ asset('assets/website/images/pricing/pricing-icon-share.png') }}" class="w-100" alt="MouthPublicity.io Share Challenge Charges">
                            </div>
                           <div class="pd-text ms-4">
                                <h5 class="font-800 color-primary">&#8377;00.10 per Unique click of Share Challenge </h5>
                                <p class="small mb-1">You will be charged as per the number of Unique Click while using Share Challenge.<br><a href="#" class="fw-bold text-decoration-none text-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#pr-collapce-03" aria-expanded="false">For Example</a></p>
                                <div class="collapse" id="pr-collapce-03">
                                    <p class="small mb-0">When you get a unique click on sharing the link by your customer to their network then &#8377;0.10 will be deducted from your MouthPublicity.io account balance.</p>
                                </div>
                           </div>
                        </div>
                        <div class="d-flex align-items-center_ mb-3">  
                            <div class="pd-icon">
                                <img src="{{ asset('assets/website/images/pricing/pricing-icon-user.png') }}" class="w-100" alt="MouthPublicity.io User Charges">
                            </div>
                           <div class="pd-text ms-4">
                                <h5 class="font-800 color-primary">&#8377;5.00 per day per User Login</h5>
                                <p class="small mb-1">You will be charged as per the number of users panel on a daily basis with unlimited login session.<br><a href="#" class="fw-bold text-decoration-none text-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#pr-collapce-04" aria-expanded="false">For Example</a></p>
                                <div class="collapse" id="pr-collapce-04">
                                    <p class="small mb-1">When your employee is logged in through the employee panel (to share & redeem your current challenge) then &#8377;5 will be deducted from your MouthPublicity.io account balance.</p>
                                    <p class="small mb-0 fst-italic"><b>Note:</b> Charges are applicable irrespective of the number of logins in a day. No charges will be deducted if your employee doesn't login throughout the day. </p>
                                </div>
                           </div>
                        </div>
                        {{-- messaging api --}}
                        <div class="d-flex align-items-center_ mb-3">  
                            <div class="pd-icon">
                                <img src="{{ asset('assets/website/images/pricing/pricing-messaging-api.png') }}" class="w-100" alt="MouthPublicity.io User Charges">
                            </div>
                           <div class="pd-text ms-4">
                                <h5 class="font-800 color-primary">Unlimited SMS Messaging at &#8377;10 per day</h5>
                                <p class="small mb-1">Enable your SMS toggle and send unlimited messages at &#8377;10 per day.<br><a href="#" class="fw-bold text-decoration-none text-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#pr-collapce-05" aria-expanded="false">For Example</a></p>
                                <div class="collapse" id="pr-collapce-05">
                                    <p class="small mb-1">On enabling the SMS, you will be charged Rs. 10 per day irrespective of number of SMS sent. If SMS is disabled then no amount will be deducted from your balance.</p>  
                                </div>
                           </div>
                        </div>
                        {{-- <div class="d-flex align-items-center_">  
                            <div class="pd-icon">
                                <img src="{{ asset('assets/website/images/pricing/pricing-icon-user.png') }}" class="w-100" alt="">
                            </div>
                           <div class="pd-text ms-4">
                                <h5 class="font-800 color-primary">Rs 00.25/ Google Review</h5>
                                <p class="small mb-0">Reach a wide range of audiences, find qualified leads and start</p>
                           </div>
                        </div> --}}
                        
                    </div>
                    <div class="col-lg-5">
                        <div class="text-center">
                            <img src="{{ asset('assets/website/images/pricing/pricing-charges.svg') }}" class="w-100" style="max-width: 320px" alt="OpenChalleng Pricing">
                        </div>
                        
                    </div>
               </div>
            </div>
            {{-- features page table  commented by tejaswi --}}
           <div class="my-5">
                <div class="table-bg-color shadow pricing-feature-table  rounded">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mb-0">
                            <thead>
                               <tr class="btn-primary-ol" style="vertical-align: middle;">
                                    <th class="text-center text-white" style="padding: 18px; border-top-left-radius: 0.3rem;"> <h5 class="font-700 mb-0">Features you'll love</h5></th>
                                    <th class="text-center" style="width: 250px; padding: 18px;"><h5 class="font-700 text-center text-white mb-0">Free Account</h5></th>
                                    <th class="text-center" style="width: 250px; padding: 18px; border-top-right-radius: 0.3rem;"><h5 class="font-700 text-center text-white mb-0">Pro Account</h5></th>
                               </tr>
                            </thead>
                            <tbody>
                                <tr class="table-padding align-middle">
                                    <td class="">Design Offer</td>
                                    <td class="text-center"> <span class="check-icon table-icon"><i class="bi bi-check-circle"></i></span></td>
                                    <td class="text-center"> <span class="check-icon table-icon"><i class="bi bi-check-circle"></i></span></td>
                                </tr>
                                <tr class="table-padding align-middle">
                                    <td class="">Access to all templates</td>
                                    <td class="text-center"> <span class="check-icon table-icon"><i class="bi bi-check-circle"></i></span></td>
                                    <td class="text-center"> <span class="check-icon table-icon"><i class="bi bi-check-circle"></i></span></td>
                                </tr>
                                <tr class="table-padding align-middle">
                                    <td class="">Social Media Integration</td>
                                    <td class="text-center"> <span class="check-icon table-icon"><i class="bi bi-check-circle"></i></span></td>
                                    <td class="text-center"> <span class="check-icon table-icon"><i class="bi bi-check-circle"></i></span></td>
                                </tr>
                                <tr class="table-padding align-middle">
                                    <td class=" ">Publish Offer/Content on Social Media</td>
                                    <td class="text-center "> <span class="check-icon table-icon"><i class="bi bi-check-circle"></i></span></td>
                                    <td class="text-center "> <span class="check-icon table-icon"><i class="bi bi-check-circle"></i></span></td>
                                </tr>
                                <tr class="table-padding align-middle">
                                    <td class=" ">Unlimited User Accounts</td>
                                    <td class="text-center "> <span class="check-icon table-icon"><i class="bi bi-check-circle"></i></span></td>
                                    <td class="text-center "> <span class="check-icon table-icon"><i class="bi bi-check-circle"></i></span></td>
                                </tr>
                                <tr class="table-padding align-middle">
                                    <td class="">Import Customer's Contacts</td>
                                    <td class="text-center"><span class="check-icon table-icon"><i class="bi bi-check-circle"></i></span></td>
                                    <td class="text-center"><span class="check-icon table-icon"><i class="bi bi-check-circle"></i></span></td>
                                </tr>
                                <tr class="table-padding align-middle">
                                    <td class="">Generate QR Code</td>
                                    <td class="text-center"><span class="check-icon table-icon"><i class="bi bi-check-circle"></i></span></td>
                                    <td class="text-center"><span class="check-icon table-icon"><i class="bi bi-check-circle"></i></span></td>
                                </tr>
                                <tr class="table-padding align-middle">
                                    <td class="">Export Customer's Contacts</td>
                                    <td class="text-center"><span class="cross-icon table-icon"><i class="bi bi-x-circle"></i></span></td>
                                    <td class="text-center"><span class="check-icon table-icon"><i class="bi bi-check-circle"></i></span></td>
                                </tr>
                                <tr class="table-padding align-middle">
                                    <td class="">Personalised Messaging</td>
                                    <td class="text-center"><span class="cross-icon table-icon"><i class="bi bi-x-circle"></i></span></td>
                                    <td class="text-center"><span class="check-icon table-icon"><i class="bi bi-check-circle"></i></span></td>
                                </tr>
                                <tr class="table-padding align-middle">
                                    <td class="">Reset Redeem Code Option</td>
                                    <td class="text-center"><span class="cross-icon table-icon"><i class="bi bi-x-circle"></i></span></td>
                                    <td class="text-center"><span class="check-icon table-icon"><i class="bi bi-check-circle"></i></span></td>
                                </tr>
                                <tr class="table-padding align-middle">
                                    <td class="">Detailed Customer activity reporting</td>
                                    <td class="text-center"><span class="cross-icon table-icon"><i class="bi bi-x-circle"></i></span></td>
                                    <td class="text-center"><span class="check-icon table-icon"><i class="bi bi-check-circle"></i></span></td>
                                </tr>
                                <tr class="table-padding align-middle">
                                    <td class="">View Customer's Contacts</td>
                                    <td class="text-center"><span class="cross-icon table-icon"><i class="bi bi-x-circle"></i></span></td>
                                    <td class="text-center"><span class="check-icon table-icon"><i class="bi bi-check-circle"></i></span></td>
                                </tr>
                                <tr class="table-padding align-middle">
                                    <td class="">Customer task complition of Instant Challenge</td>
                                    <td class="text-center"><span class="cross-icon table-icon"><i class="bi bi-x-circle"></i></span></td>
                                    <td class="text-center"><span class="check-icon table-icon"><i class="bi bi-check-circle"></i></span></td>
                                </tr>
                                <tr class="table-padding align-middle">
                                    <td class="">Unique click count of Share Challenge</td>
                                    <td class="text-center"><span class="cross-icon table-icon"><i class="bi bi-x-circle"></i></span></td>
                                    <td class="text-center"><span class="check-icon table-icon"><i class="bi bi-check-circle"></i></span></td>
                                </tr>
                                <tr class="table-padding align-middle">
                                    <td class="">Send messages though SMS</td>
                                    <td class="text-center"><span class="cross-icon table-icon"><i class="bi bi-x-circle"></i></span></td>
                                    <td class="text-center"><span class="check-icon table-icon"><i class="bi bi-check-circle"></i></span></td>
                                </tr>
                                <tr class="table-padding align-middle">
                                    <td class="">New "Share Challenge" offer can be automatically shared with selected contact groups</td>
                                    <td class="text-center"><span class="cross-icon table-icon"><i class="bi bi-x-circle"></i></span></td>
                                    <td class="text-center"><span class="check-icon table-icon"><i class="bi bi-check-circle"></i></span></td>
                                </tr>
                                <tr class="table-padding align-middle">
                                    <td class="">Access to Instant and Share Challenge Settings</td>
                                    <td class="text-center"><span class="cross-icon table-icon"><i class="bi bi-x-circle"></i></span></td>
                                    <td class="text-center"><span class="check-icon table-icon"><i class="bi bi-check-circle"></i></span></td>
                                </tr>

                                <tr class="table-padding align-middle">
                                    <td class="">Send Instant Challenge</td>
                                    <td class="text-center">WhatsApp Only</td>
                                    <td class="text-center">WhatsApp & SMS</td>
                                </tr>
                                <tr class="table-padding align-middle">
                                    <td class="">Schedule Share Challenge</td>
                                    <td class="text-center">WhatsApp Only</td>
                                    <td class="text-center">WhatsApp & SMS</td>
                                </tr>
                                <tr class="table-padding align-middle">
                                    <td class="">Integrate Messaging API</td>
                                    <td class="text-center">WhatsApp Only</td>
                                    <td class="text-center">WhatsApp & SMS</td>
                                </tr>
                                <tr class="table-padding align-middle">
                                    <td class=""></td>
                                    <td class="text-center"></td>
                                    <td class="text-center">
                                        <a href="#pricing-new" class="btn btn-primary-ol px-4">Recharge Now</a>
                                    </td>
                                </tr>
                            </tbody>    
                        </table>
                    </div>
                    
                </div>
           </div>
        
        
        </div>
    </div>
</section>


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