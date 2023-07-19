@extends('layouts.business')

@section('title', 'Dashboard: Business Panel')

@section('end_head')
<style>
    .lh-1{
        line-height: 1.5;
    }

    .offer-icon-data .icon-box{
        position: relative;
        width: 38px;
        height: 38px;
        border-radius: 6px;
        color: #fff;
        text-align: center;
    }
    .offer-icon-data .icon-box i.far,
    .offer-icon-data .icon-box i.fas{
        font-size: 1.2rem;
        line-height: 38px;
    }

    /* Hero card CSS Overwrite */
    .card.card-hero .card-header{
        background: var(--primary);
    }
    .card.card-hero .card-header h4{
        font-size: 2rem;
    }
    .card.card-hero .card-header .card-icon{
        color: rgba(255, 255, 255, 0.4);
    }


    /* Social Posts Data CSS */
    .social-canvas-container{
        position: relative;
        width: 100%;
        max-width: 300px;
        margin: auto;
    }
    .budget-price .budget-price-label{
        line-height: 1;
    }
    .msg-expired{
        background-color: #767676 !important;
    }
    .expired-msg-text{
        color: #a6a6a6 !important;
    }
    /* dashbaord design offer banner */
    .bg-design-offer-banner{
        background: #F2EAE1;
        overflow: hidden;
        position: relative;
    }
    .bg-design-offer-banner-inner{
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
    }
    .design-offer-banner-img{
        text-align: right;
    }
    .design-offer-banner-img img{
        width: 575px;
    }
    .design-offer-button{
        background: #EF5744;
        border: 0px !important;
        border-radius: 30px;
        color: #fff;
    }
    .do-banner-text-para{
        color:#7C5037;
    }
    .design-img-top img{
        position: absolute;
        top: -20px;
        left: -24px;
        width: 100px;
        transform: rotate(180deg);
    }
    .design-img-bottom img{
        position: absolute;
        bottom: -20px;
        right: -24px;
        width: 100px;
    }
    .bg-design-offer-banner-inner.banner-responsive{
        flex-direction: column !important;
    }
    .bg-design-offer-banner-inner.banner-responsive .design-offer-banner-text,
    .bg-design-offer-banner-inner.banner-responsive .design-offer-banner-img{
        text-align: center;
    }
    /* create offer */
    .bg-design-offer{
        background: linear-gradient(245deg, #BFC3E2 0%, #F1F5FD 91%, #F8F5FD 100%);
        overflow: hidden;
        position: relative;
    }
    .design-offer-banner-text ,.design-offer-banner-img{
        position: relative;
        z-index: 2;
    }
    
    @media(max-width: 575px){
        .bg-design-offer-banner-inner{
            flex-direction: column;
        }
        .design-offer-banner-text,
        .design-offer-banner-img{
            text-align: center;
        }

    }

    .hide-section{
        display: none;
    }
</style>
@endsection

@section('head')
    @include('layouts.partials.headersection',['title'=>'Dashboard'])
@endsection

@section('content')
<section>
    <div class="section">
        {{-- <div class="row">
            <div class="col-12">
                <div class="card bg-design-offer">
                    <div class="card-body px-5">
                        <span class="design-circle"></span>
                        <span class="design-circle-small"></span>
                        <div class="row align-items-center">
                            <div class="col-sm-6">
                                <div class="design-offer-banner-text-one position-relative text-center text-sm-left">
                                    <h3 class="do-banner-text-head-one">You don't have any <span class="font-weight-bold">offer to challenge!</span></h3>
                                    <p class="do-banner-text-para-one">Please click below button to create or design new offer.</p>
                                    <a href=""><button class="btn design-offer-button-one px-4 font-weight-bold">Design Now</button></a>
                                </div>
                            </div> 
                            <div class="col-sm-6">
                                <div class="design-offer-banner-img-one text-center text-sm-right mt-4 mt-sm-0">
                                    <img src="{{asset('assets/business/design-offer-banner-dashboard/design-offer-banner-img.png')}}" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>   
        </div>   --}}

        {{-- 2nd --}}
        <div class="card bg-design-offer-banner @if($planData['no_created_a_single_offer'] != 0) hide-section @endif">
            <div class="card-body px-sm-5">
                <span class="design-img-top"><img src="{{asset('assets/business/design-offer-banner-dashboard/bg-design-img.png')}}" alt=""></span>
                <div class="bg-design-offer-banner-inner">
                    <div class="design-offer-banner-text position-relative">
                        <h3 class="do-banner-text-head">You don't have any <span class="font-weight-bold" style="color:#EF5744;">offer to challenge!</span></h3>
                        <p class="do-banner-text-para">Please click below button to create or design new offer.</p>
                        <a  @if($isConnectAnySocialMedia!=0) href="{{ route('business.designOffer.templates') }}" @else href="javascript:void()" id="showConnectPopup" @endif><button class="btn design-offer-button px-4 font-weight-bold">Design Now</button></a>
                    </div>
                    <div class="design-offer-banner-img mt-4 mt-sm-0">
                        <img src="{{asset('assets/business/design-offer-banner-dashboard/design-banner-new.png')}}" alt="" class="img-fluid">
                    </div>
                </div>
                <span class="design-img-bottom"><img src="{{asset('assets/business/design-offer-banner-dashboard/bg-design-img.png')}}" alt=""></span>
            </div>
        </div>

        {{-- Current (on going) offer  --}}
        <div class="row @if($planData['no_created_a_single_offer'] == 0) hide-section @endif">

            <div class="col-xl-8 col-md-7 col-sm-6">
                <div class="card">
                    <div class="card-header justify-content-between">
                        <h4>Current offer statistics</h4>
                        <span class="info-btn" data-toggle="tooltip"  title="Showing the clicks count of current running offer"><i class="fa fa-info-circle"></i></span>
                    </div>
                    {{-- Current Offer Statistics --}}
                    <div class="card-body p-3">
                        <div class="row  align-items-center">
                            <div class="col-md-6 mb-0">
                                <div class="d-flex align-items-center offer-icon-data">
                                    <div class="mr-2">
                                        <div class="bg-warning icon-box">
                                            <i class="far fa-hand-pointer"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">{{ $current_total_clicks  }}</h5>
                                        <p class="mb-0 lh-1 small">Total Clicks</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-1 mb-md-0">
                                <div class="d-flex align-items-center offer-icon-data">
                                    <div class="mr-2">
                                        <div class="bg-success icon-box">
                                            <i class="far fa-hand-pointer"></i>
                                        </div>
                                    </div>
                                    <div>
                                        @if($planData['userData']->current_account_status == 'free')
                                            <h5 class="mb-0 __pro__"></h5>
                                        @else
                                            <h5 class="mb-0">{{ $current_unique_clicks }}</h5>
                                        @endif
                                        
                                        <p class="mb-0 lh-1 small">Unique Clicks</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-around" id="current_offer_chart_btns">
                        <a href="#" class="day7 py-1 badge badge-secondary">7D</a>
                        <a href="#" class="month1 py-1 badge badge-secondary">1M</a>
                        <a href="#" class="year1 py-1 badge badge-secondary">1Y</a>
                        <a href="#" class="maxall py-1 badge badge-secondary">Max</a>
                    </div>
    
                    <div class="card-chart p-2">
                        {{-- Graph --}}
                        <canvas id="current_offer_chart" height="211"></canvas>
                    </div>
                    <hr class="mb-0">
                </div>
            </div>

            <div class="col-xl-4 col-md-5 col-sm-6">
                {{-- Current Offer Card --}}
                @include('business.current-offer')
                
            </div>

            <div class="col-md-6">
                <div class="card">
                    {{-- Subscribers of Current Offer --}}
                    <div class="card-header justify-content-between">
                        <h4>Instant & Share Challenges For Current Offer</h4>
                        <span class="info-btn" data-toggle="tooltip"  title="Showing the counts of Instant & Share Challengers of current running offer"><i class="fa fa-info-circle"></i></span>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-6 mb-1">
                                <div class="d-flex align-items-center offer-icon-data">
                                    <div class="mr-2">
                                        <div class="bg-primary icon-box">
                                            <i class="far fa-user"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">{{ $current_instant_subscribers }}</h5>
                                        <p class="mb-0 lh-1 small">Instant Challengers</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-1">
                                <div class="d-flex align-items-center offer-icon-data">
                                    <div class="mr-2">
                                        <div class="bg-info icon-box">
                                            <i class="far fa-user"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">{{ $current_share_subscribers }}</h5>
                                        <p class="mb-0 lh-1 small">Share Challengers</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex justify-content-around" id="current_offer_subscriberes_btns">
                            <a href="#" class="day7 py-1 badge badge-secondary">7D</a>
                            <a href="#" class="month1 py-1 badge badge-secondary">1M</a>
                            <a href="#" class="year1 py-1 badge badge-secondary">1Y</a>
                            <a href="#" class="maxall py-1 badge badge-secondary">Max</a>
                        </div>
                    </div>
                    <div class="card-chart p-2">
                        {{-- Graph --}}
                        <canvas id="current_offer_subscriberes" height="160"></canvas>
                    </div>
                    {{-- Subscribers of Current Offer - END --}}
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    {{-- Subscribers of Current Offer --}}
                    <div class="card-header justify-content-between">
                        <div>
                            <h4 class="mb-0">Social Media Impact Of Instant Challenge</h4>
                            <p style="font-size:10px;line-height:1;" class="mb-0">( Updates in every 4 hours )</p>
                        </div>
                        <span class="info-btn" data-toggle="tooltip"  title="Showing the count of all social media actions made through running Instant Challenge."><i class="fa fa-info-circle"></i></span>
                    </div>
                    <div class="card-chart p-3">
                        {{-- Graph --}}
                        <canvas id="current_offer_social_reach" height="230"></canvas>
                    </div>
                    {{-- Subscribers of Current Offer - END --}}
                </div>
            </div>
            
        </div>
        {{-- Current offer - END  --}}
        

        <div class="row">
        
            <div class="col-lg-5 mb-4">
                {{-- Message API DATA --}}
                <div class="card card-hero mb-0 h-100">

                    {{-- Expired message plan --}}
                    {{-- <div class="card-header msg-expired py-4 px-lg-4 px-md-3 px-4" data-toggle="tooltip" data-placement="top" title="Expired Message">
                        <div class="card-icon">
                             <i class="fas fa-rupee-sign"></i>
                        </div>
                        <h4 class="expired-msg-text">{{ $remaing_message_count }}</h4>
                        <div class="card-description expired-msg-text">Available Messages</div>
                    </div> --}}

                    <div class="card-header py-4 px-lg-4 px-md-3 px-4">
                        <div class="card-icon">
                            <i class="fas fa-rupee-sign"></i>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5>₹{{ $remaing_message_count }}</h5>
                                <div class="card-description">Available Balance</div>
                            </div>
                            <div>
                                <a href="{{ route('pricing') }}#pricing-cart" class="btn btn-success py-2 rounded-pill shadow">
                                    Recharge now
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="px-2 py-2">
                            {{-- Graph --}}
                            <canvas id="balance_chart" height="275"></canvas>
                        </div>
                        {{-- <div class="tickets-list m-0">
                            <a href="{{ route('pricing') }}" class="ticket-item ticket-more py-2 bg-light border-0">
                                Recharge now <i class="fas fa-chevron-right"></i>
                            </a>
                        </div> --}}
                    </div>
                </div>
                {{-- =======END======= Message API DATA --}}
            </div>

            {{-- Social Posts DATA --}}
            <div class="col-lg-7 mb-4">
                <div class="card h-100 mb-0">
                    <div class="card-header justify-content-between">
                        <h4>Social Post Statistics</h4>
                        <span class="info-btn" data-toggle="tooltip"  title="These are the total number of clicks of your posts made through MouthPublicity"><i class="fa fa-info-circle"></i></span>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center h-100">
                            <div class="col-md-6">
                                <div class="social-canvas-container">
                                    <canvas id="social_cart" width="100%"></canvas>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="social_posts_data">

                                    <ul class="list-unstyled list-unstyled-border mb-0">
                                        {{-- *** Facebook *** --}}
                                        <li class="media">
                                            <div width="50px" class="mr-2">
                                                <svg version="1.1" id="facebook_svg" width="48" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
                                                    <g>
                                                        <path fill="#485A94" d="M99.3,62.8c0-16.2,0-32.3,0-48.5c0-6.6-4.2-11.8-10.5-13.3c-1-0.2-2-0.3-3.1-0.3c-23.8,0-47.6,0-71.4,0
                                                            C7.7,0.7,2.5,4.9,1,11.4c-0.1,0.2,0.1,0.5-0.2,0.7c0,25.3,0,50.5,0,75.8C1,88,0.9,88.3,1,88.5c1.3,5.7,4.9,9.2,10.5,10.5
                                                            c0.2,0,0.5,0,0.6,0.2c12.4,0,24.9,0,37.3,0c5.1,0,10.3,0,15.4,0c7.6,0,15.3,0,22.9,0c0.3-0.3,0.7-0.2,1.1-0.3
                                                            c6.3-1.5,10.5-6.7,10.5-13.1C99.3,78.2,99.3,70.5,99.3,62.8z"/>
                                                        <path fill="#FEFEFE" d="M46.7,99.3c0-0.3,0.1-0.7,0.1-1c0-11,0-22.1,0.1-33.1c0-0.9-0.2-1.1-1.1-1.1c-2.5,0.1-5.1,0-7.6,0
                                                            c-1.8,0-2.6-0.8-2.6-2.7c0-3.5,0-6.9,0-10.4c0-1.8,0.8-2.6,2.6-2.6c2.6,0,5.2,0,7.8,0c0.7,0,0.9-0.2,0.9-0.9c0-4-0.2-8,0.1-12
                                                            c0.3-5.3,2-10,6.2-13.5c3.2-2.7,6.9-3.9,11-4.1c3.6-0.2,7.2-0.1,10.8-0.1c1.8,0,2.6,0.8,2.6,2.6c0,2.9,0,5.8,0,8.7
                                                            c0,1.8-0.8,2.6-2.7,2.6c-2.2,0-4.4,0-6.6,0.1c-2,0.1-3.9,0.7-5,2.7c-0.4,0.7-0.7,1.5-0.7,2.4c-0.4,3.7-0.1,7.4-0.2,11.1
                                                            c0,0.7,0.4,0.6,0.8,0.6c4,0,8,0,12,0c2.3,0,3,0.9,2.8,3.2c-0.4,3.4-0.8,6.7-1.2,10.1c-0.2,1.7-0.9,2.4-2.7,2.4c-3.5,0-7,0-10.5,0
                                                            c-0.9,0-1.2,0.2-1.2,1.2c0,11,0,21.9-0.1,32.9c0,0.4,0,0.8,0,1.2C57,99.3,51.9,99.3,46.7,99.3z"/>
                                                    </g>
                                                </svg>
                                            </div>
                                            <div class="media-body">
                                                <div class="media-title mb-0">Facebook</div>
                                                <div class="">
                                                    <div class="budget-price" data-toggle="tooltip" title="Unique Clicks">
                                                        {{-- [FACEBOOK_UNIQUE_CLICKS_WITH_PROGRESS] --}}
                                                        <div class="budget-price-square bg-primary rounded-pill" data-width="{{ $social_percent_data['fb_unique_percent'] }}" style="width: {{ $social_percent_data['fb_unique_percent'] }};"></div>
                                                        <div class="budget-price-label lh-1">{{ $fb_post_unique_click }}</div>
                                                    </div>
                                                    <div class="budget-price" data-toggle="tooltip" title="Total Clicks">
                                                        {{-- [FACEBOOK_EXTRA_CLICKS_WITH_PROGRESS] --}}
                                                        <div class="budget-price-square bg-warning rounded-pill" data-width="{{ $social_percent_data['fb_extra_percent'] }}" style="width: {{ $social_percent_data['fb_extra_percent'] }};"></div>
                                                        <div class="budget-price-label lh-1">{{ $fb_post_unique_click + $fb_post_extra_click }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        {{-- *** END FB *** --}}

                                        {{-- *** Twitter *** --}}
                                        <li class="media">
                                            <div width="50px" class="mr-2">
                                                <svg version="1.1" id="twitter_svg" width="48" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
                                                    <g>
                                                        <path fill="#3AA5DD" d="M99.1,11C97.6,5,92.3,0.6,86.1,0.6c-24.1,0-48.2,0-72.3,0c-7.2,0-13.2,6-13.2,13.2c0,24.1,0,48.2,0,72.3
                                                            C0.6,92.3,5,97.6,10.9,99c0.4,0.1,0.8,0,1,0.4c25.3,0,50.6,0,75.9,0c0.2-0.3,0.6-0.2,0.9-0.3c5.5-1.4,9-4.8,10.4-10.3
                                                            c0.1-0.3,0-0.7,0.3-0.9c0-25.3,0-50.6,0-75.8C99.1,11.9,99.2,11.4,99.1,11z"/>
                                                        <path fill="#FFFFFF" d="M81.4,30.7c-1.4,2.2-3.1,4-5.1,5.6c-0.8,0.6-1.1,1.1-1.1,2.2c0.1,5.4-1.1,10.5-3.3,15.5
                                                            c-2,4.5-4.8,8.6-8.4,12c-4.9,4.7-10.8,7.7-17.4,9c-2.9,0.6-5.9,0.8-8.9,0.7c-6.6-0.2-12.6-2-18.2-5.5c-0.1-0.1-0.2-0.1-0.4-0.3
                                                            c7.1,0.7,13.3-1.1,19-5.3c-0.6-0.2-1.2-0.1-1.7-0.2c-4.9-0.9-8.2-3.7-10.1-8.2c-0.3-0.6-0.2-0.7,0.5-0.6c1.6,0.2,3.2,0.1,4.8-0.3
                                                            c-2.9-0.8-5.4-2.3-7.3-4.7c-1.9-2.4-2.8-5-2.8-8.2c1.8,0.9,3.6,1.5,5.7,1.5c-1.2-0.9-2.2-1.8-3.1-2.9c-1.5-2-2.4-4.2-2.6-6.8
                                                            c-0.2-2.5,0.3-4.8,1.4-7.1c0.2-0.4,0.3-0.5,0.6-0.1c4,4.7,8.8,8.3,14.5,10.6c2.9,1.2,6,2,9.2,2.3c0.7,0.1,1.4,0.1,2.1,0.2
                                                            c0.5,0.1,0.5-0.1,0.5-0.5c-0.7-4.8,0.6-8.9,4.2-12.2c3-2.6,6.5-3.6,10.5-3c2.8,0.4,5.1,1.6,7.1,3.6c0.2,0.2,0.4,0.3,0.8,0.2
                                                            c2.5-0.6,4.8-1.4,7.1-2.6c0.2-0.1,0.3-0.2,0.6-0.2c-1,2.9-2.8,5.1-5.3,6.9c1.3-0.1,2.6-0.4,3.8-0.7C79.3,31.3,80.3,30.9,81.4,30.7
                                                            C81.3,30.6,81.4,30.6,81.4,30.7z"/>
                                                    </g>
                                                </svg>
                                            </div>
                                            <div class="media-body">
                                                <div class="media-title mb-0">Twitter</div>
                                                <div class="">
                                                    <div class="budget-price" data-toggle="tooltip" title="Unique Clicks">
                                                        {{-- [TWITTER_UNIQUE_CLICKS_WITH_PROGRESS] --}}
                                                        <div class="budget-price-square bg-primary rounded-pill" data-width="{{ $social_percent_data['tw_unique_percent'] }}" style="width: {{ $social_percent_data['tw_unique_percent'] }};"></div>
                                                        <div class="budget-price-label">{{ $tw_post_unique_click }}</div>
                                                    </div>
                                                    <div class="budget-price" data-toggle="tooltip" title="Total Clicks">
                                                        {{-- [TWITTER_EXTRA_CLICKS_WITH_PROGRESS] --}}
                                                        <div class="budget-price-square bg-warning rounded-pill" data-width="{{ $social_percent_data['tw_extra_percent'] }}" style="width: {{ $social_percent_data['tw_extra_percent'] }};"></div>
                                                        <div class="budget-price-label">{{ $tw_post_unique_click + $tw_post_extra_click }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        {{-- *** END TW *** --}}

                                        {{-- *** LinkedIn *** --}}
                                        {{-- <li class="media">
                                            <div width="50px" class="mr-2">
                                                <svg version="1.1" id="linkedin" width="48" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
                                                    <g>
                                                        <path fill="#0278B5" d="M99.1,14c0-6.3-4.6-11.6-10.9-12.9c-0.2,0-0.5,0.1-0.6-0.2c-25,0-50,0-75.1,0C12,1,11.3,1.1,10.7,1.3
                                                            c-5,1.5-8.2,4.8-9.5,9.9c-0.1,0.3,0,0.7-0.3,0.9c0,25.2,0,50.4,0,75.6c0.3,0.2,0.3,0.6,0.3,0.9c1.4,6,6.7,10.4,12.9,10.4
                                                            c24,0,47.9,0,71.9,0c7.2,0,13.2-6,13.2-13.2C99.2,62,99.2,38,99.1,14z"/>
                                                        <path fill="#FDFEFE" d="M53.2,44.6c1.2-1.5,2.3-2.8,3.7-3.6c3.1-1.8,6.4-2.2,9.9-2c3.7,0.2,7,1.3,9.5,4.2c2.1,2.4,3.1,5.3,3.6,8.3
                                                            c0.4,2.4,0.6,4.8,0.6,7.2c0,6.5,0,13.1,0,19.6c0,1.8-0.7,2.5-2.5,2.5c-2.8,0-5.6,0-8.4,0c-1.8,0-2.5-0.6-2.5-2.4
                                                            c0-5.9,0-11.8,0-17.8c0-2.1,0-4.2-0.7-6.2c-0.8-2.3-2.3-3.9-4.8-4.2c-2.8-0.4-5.1,0.4-6.7,2.8c-1.3,2-1.8,4.2-1.8,6.5
                                                            c0,6.2,0,12.3,0,18.5c0,2.2-0.6,2.7-2.7,2.7c-2.7,0-5.3,0-8,0c-1.6,0-2.3-0.7-2.3-2.3c0-12.2,0-24.4,0-36.6c0-1.6,0.7-2.3,2.3-2.3
                                                            c2.8,0,5.6,0,8.4,0c1.6,0,2.3,0.7,2.3,2.3C53.2,42.7,53.2,43.5,53.2,44.6z"/>
                                                        <path fill="#FCFDFE" d="M21.4,60.1c0-6,0-12,0-18c0-1.8,0.7-2.5,2.5-2.5c2.7,0,5.4,0,8.1,0c1.7,0,2.4,0.8,2.4,2.4
                                                            c0,12.1,0,24.2,0,36.4c0,1.6-0.8,2.4-2.4,2.4c-2.7,0-5.4,0-8.2,0c-1.6,0-2.4-0.8-2.4-2.4C21.4,72.3,21.4,66.2,21.4,60.1z"/>
                                                        <path fill="#FCFDFE" d="M36.2,27.6c0.1,4.6-3.6,8.4-8.2,8.4c-4.7,0.1-8.5-3.6-8.6-8.2c-0.1-4.6,3.6-8.4,8.1-8.5
                                                                C32.4,19.2,36.2,22.8,36.2,27.6z"/>
                                                    </g>
                                                </svg>
                                            </div>
                                            <div class="media-body">
                                                <div class="media-title mb-0">LinkedIn</div>
                                                <div class="">
                                                    <div class="budget-price" data-toggle="tooltip" title="Unique Clicks">
                                                        
                                                        <div class="budget-price-square bg-primary rounded-pill" data-width="{{ $social_percent_data['li_unique_percent'] }}" style="width: {{ $social_percent_data['li_unique_percent'] }};"></div>
                                                        <div class="budget-price-label">{{ $li_post_unique_click }}</div>
                                                    </div>
                                                    <div class="budget-price" data-toggle="tooltip" title="Extra Clicks">
                                                        
                                                        <div class="budget-price-square bg-warning rounded-pill" data-width="{{ $social_percent_data['li_extra_percent'] }}" style="width: {{ $social_percent_data['li_extra_percent'] }};"></div>
                                                        <div class="budget-price-label">{{ $li_post_extra_click }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li> --}}
                                        {{-- *** END LI *** --}}
                                    </ul>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- =========END======== Social Posts DATA --}}
                
        </div>

         {{-- Social Media Reach Start --}}
 
        <div class="">
            <div class="card">
                {{-- Subscribers of Current Offer --}}
                <div class="card-header justify-content-between">
                    <h4>Social Media Reach <span style="font-size:10px">( Updates in every 4 hours )</span></h4>
                    <span class="info-btn" data-toggle="tooltip"  title="Showing your reach on social media through MouthPublicity.io."><i class="fa fa-info-circle"></i></span>
                </div>
                <div class="card-chart p-3">
                    {{-- Graph --}}
                    <canvas id="overall__social_reach" height="150"></canvas>
                </div>
                {{-- Subscribers of Current Offer - END --}}
            </div>
        </div>
        {{-- Social Media Reach End --}}

        {{-- Overall Clicks Graph --}}
        <div>
            <div class="card">
                <div class="card-header justify-content-between">
                    <h4 class="d-inline">Statistics</h4>
                    <span class="info-btn" data-toggle="tooltip" title="This graph shows the number of total clicks on your overall challenges till today."><i class="fa fa-info-circle"></i></span>
                </div>
                <div class="d-flex justify-content-around pt-3 pb-2" id="clicks_data_chart_btns">
                    <a href="#" class="day7 py-1 badge badge-secondary">7D</a>
                    <a href="#" class="month1 py-1 badge badge-secondary">1M</a>
                    <a href="#" class="year1 py-1 badge badge-secondary">1Y</a>
                    <a href="#" class="maxall py-1 badge badge-secondary">Max</a>
                </div>
                <div class="card-chart">
                    {{-- Graph --}}
                    <canvas id="clicks_data_chart" width="100%" height="300"></canvas>
                </div>
            </div>
        </div>
        {{-- Overall Clicks Graph--END --}}


        {{--total offer challengers --}}
        <div>
            <div class="card">
                <div class="card-header justify-content-between">
                    <h4 class="d-inline">Instant & share Challengers</h4>
                    <span class="info-btn" data-toggle="tooltip"  title="This graph shows the number of total clicks on your overall challenges till today."><i class="fa fa-info-circle"></i></span>
                </div>
                <div class="d-flex justify-content-around pt-3" id="total_offer_challengers_btns">
                    <a href="#" class="day7 py-1 badge badge-secondary">7D</a>
                    <a href="#" class="month1 py-1 badge badge-secondary">1M</a>
                    <a href="#" class="year1 py-1 badge badge-secondary">1Y</a>
                    <a href="#" class="maxall py-1 badge badge-secondary">Max</a>
                </div>
                <div class="card-body p-0 p-sm-3 pt-1">
                    {{-- Graph --}}
                    <canvas id="total_offer_challengers" height="150"></canvas>
                </div>
            </div>
        </div>
        {{-- total offer challengers end --}}
        
        
        {{-- SVG Circles  --}}
        {{-- <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Social Post</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <svg class="prog-container" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg">
                                    <g data-toggle="tooltip" title="Unique Clicks">
                                        <circle class="prog-container__background" r="20" cx="50%" cy="50%"></circle>
                                        <circle class="prog-container__progress" r="20" cx="50%" cy="50%" style="stroke-dashoffset: 40.625;" ></circle>
                                    </g>
                                    <g data-toggle="tooltip" title="Extra Clicks">
                                        <circle class="prog-container__background inner" r="17" cx="50%" cy="50%"></circle>
                                        <circle class="prog-container__progress inner" r="17" cx="50%" cy="50%" style="stroke-dashoffset: 50;" ></circle>
                                    </g>

                                    <svg viewBox="-45 -45 100 100" fill="url(#jsc_s_c)" height="40" width="40">
                                        <defs>
                                            <linearGradient x1="50%" x2="50%" y1="97.0782153%" y2="0%" id="jsc_s_c">
                                                <stop offset="0%" stop-color="#0062E0"></stop>
                                                <stop offset="100%" stop-color="#19AFFF"></stop>
                                            </linearGradient>
                                        </defs>
                                        <path d="M15 35.8C6.5 34.3 0 26.9 0 18 0 8.1 8.1 0 18 0s18 8.1 18 18c0 8.9-6.5 16.3-15 17.8l-1-.8h-4l-1 .8z"></path>
                                        <path class="kbtg6tx2" fill="#fff"
                                            d="M25 23l.8-5H21v-3.5c0-1.4.5-2.5 2.7-2.5H26V7.4c-1.3-.2-2.7-.4-4-.4-4.1 0-7 2.5-7 7v4h-4.5v5H15v12.7c1 .2 2 .3 3 .3s2-.1 3-.3V23h4z">
                                        </path>
                                    </svg>
                                </svg>
                            </div>
                            <div class="col-md-4">
                                <svg class="prog-container" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg" height="145" width="145">
                                    <g data-toggle="tooltip" title="Unique Clicks">
                                        <circle class="prog-container__background" r="19" cx="50%" cy="50%"></circle>
                                        <circle class="prog-container__progress" r="19" cx="50%" cy="50%" style="stroke-dashoffset: 40.625;" ></circle>
                                    </g>
                                    <g data-toggle="tooltip" title="Extra Clicks">
                                        <circle class="prog-container__background inner" r="16" cx="50%" cy="50%"></circle>
                                        <circle class="prog-container__progress inner" r="16" cx="50%" cy="50%" style="stroke-dashoffset: 50;" ></circle>
                                    </g>

                                    <svg viewBox="-44 -44 100 100" fill="url(#jsc_s_c)" height="40" width="40">
                                        <defs>
                                            <linearGradient x1="50%" x2="50%" y1="97.0782153%" y2="0%" id="jsc_s_c">
                                                <stop offset="0%" stop-color="#0062E0"></stop>
                                                <stop offset="100%" stop-color="#19AFFF"></stop>
                                            </linearGradient>
                                        </defs>
                                        <path d="M15 35.8C6.5 34.3 0 26.9 0 18 0 8.1 8.1 0 18 0s18 8.1 18 18c0 8.9-6.5 16.3-15 17.8l-1-.8h-4l-1 .8z"></path>
                                        <path class="kbtg6tx2" fill="#fff"
                                            d="M25 23l.8-5H21v-3.5c0-1.4.5-2.5 2.7-2.5H26V7.4c-1.3-.2-2.7-.4-4-.4-4.1 0-7 2.5-7 7v4h-4.5v5H15v12.7c1 .2 2 .3 3 .3s2-.1 3-.3V23h4z">
                                        </path>
                                    </svg>
                                </svg>
                            </div>
                            <div class="col-md-4">
                                <svg class="prog-container" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg">
                                    <g data-toggle="tooltip" title="Unique Clicks">
                                        <circle class="prog-container__background" r="19" cx="50%" cy="50%"></circle>
                                        <circle class="prog-container__progress" r="19" cx="50%" cy="50%" style="stroke-dashoffset: 15;" ></circle>
                                    </g>
                                    <g data-toggle="tooltip" title="Extra Clicks">
                                        <circle class="prog-container__background inner" r="16" cx="50%" cy="50%"></circle>
                                        <circle class="prog-container__progress inner" r="16" cx="50%" cy="50%" style="stroke-dashoffset: 30;" ></circle>
                                    </g>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        
    </div>
</section>

@endsection

@push('js')
<script src="{{ asset('assets/js/chart.min.js')}}"></script>

<script >
$(document).ready(function(){
    $(document).on('click', "#showConnectPopup", function(){
        const swalSocialConnectPopup = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success m-1',
                cancelButton: 'btn btn-primary m-1'
            },
            buttonsStyling: false
        })

        swalSocialConnectPopup.fire({
            title: "You are not connected to social media",
            text: "If you are not connected to any social media then need to post manually!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Go to connect page!',
            cancelButtonText: 'Design new offer!',
            reverseButtons: true,
            allowOutsideClick: false,
            showCloseButton: true,
        }).
        then((result) => {
            if (result.value == true) {
                sessionStorage.setItem("setting_section", "social_connection");
                window.location.href = "{{ route('business.settings') }}";
            } 
            else if (result.dismiss === "cancel") {
                window.location.href = "{{ route('business.designOffer.templates') }}";
            }
        });
    });
});
</script>

<script>
/* === All Graph's Requied variables === */
const win_screen = window.innerWidth;

$(function() {
    /* CHART DEFAULT SETTINS SET */
    Chart.defaults.font.family = 'Poppins';
});

/* Chart update */
function addChartData(chart, labels, data) {
    chart.data.labels = labels
    chart.data.datasets.forEach((dataset, index) => {
        dataset.data = data[index];
    });
    chart.update();
}

const every_nth = (arr, nth) => arr.filter((e, i) => i % nth === nth - 1);

function get_lables_name (value, index, ticks, options){
    let nth = 1;
    let lb_names = [];
    if(ticks.length > 360){
        nth = 60;
    }else if(ticks.length > 175){
        nth = 28;
    }else if(ticks.length > 84){
        nth = 12;
    }else if(ticks.length > 27){
        nth = 4;
    }else if(ticks.length > 14){
        nth = 2;
    }
    lb_names = every_nth(options.data.labels, nth);
    if(lb_names.includes(options.data.labels[index])){
        return options.data.labels[index];
    }
}



/* ==============================Remove after api connecteds============================ */
function random_numbers(length, max) {
    return Array.apply(null, Array(length)).map(function() {
        return Math.round(Math.random() * max);
    });
}
function getDates(startDate, endDate) {
    const dates = [];
    let currentDate = new Date(startDate);
    while (currentDate <= endDate) {
        
        let day = new Date(currentDate);

        let options = { day: '2-digit', month: 'short'};
        let formattedDate = day.toLocaleDateString('en-US', options);
        
        dates.push(formattedDate);
        currentDate.setDate(currentDate.getDate() + 1);
    }
    return dates;
}
/* ==============================Remove after api connecteds============================ */

</script>

@include('business.graph-scripts.current_offer_chart')
@include('business.graph-scripts.current_offer_subscriberes')
@include('business.graph-scripts.overall__social_reach')
@include('business.graph-scripts.clicks_data_chart')
@include('business.graph-scripts.social_chart')
@include('business.graph-scripts.balance_chart')
@include('business.graph-scripts.total_offer_challengers')
@include('business.graph-scripts.current_offer_social_reach')

{{-- @include('business.graph-script') --}}

@endpush


