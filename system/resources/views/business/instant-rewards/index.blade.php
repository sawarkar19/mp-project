@extends('layouts.business')
@section('title', 'Instant Challenge: Business Panel')

@section('end_head')
<style>
    .form_select label{
        font-size: 14px;
    }
    .form_select button{
        max-width: 100%;
    }   
    .current_offer_share .card{
        flex-direction: row;
    }
    .offer_img img{
        max-width: 100%;
        border-radius: 3px;
    }
   .current_offer_share .card-body p{
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        line-height: 20px;
        overflow: hidden;
        text-overflow: ellipsis;
        cursor: pointer;
   }
   .status .badge{
        padding: 4px 12px;
        font-size: 9px;
        color: #fff;
   }
   .form_select small{
        line-height: 19px;
        font-size: 11px;
    }
    .selectgroup-button{
        line-height: 22px;
    }
    .current_offer_share .date p{
        font-weight: 500 !important;
    } 
    .select_offer .card{
        background: #f9f9f9; 
        margin-bottom: 0;
        border: 1px solid #ebebeb;
    }
    
    .options{
        height: 100%;
        position: relative;
    }
    .options .radio_label{
        height: 100%;
        width: 100%;
        position: relative;
    }
    .options .card{
        height: 100%;
    }
    .form_select .div_form label span{
        color: red;
    }
    .select_offer .radio_label:before{
        content: '';
        border-radius: 50%;
        width: 20px;
        height: 20px;
        background-color: #fff;
        border: 1px solid #c7c7c7;
        position: absolute;
        top: 12px;
        left: 10px;
        z-index: 1;
    }
    .select_offer .radio_label:after{
        content: '';
        top: 12px;
        left: 10px;
        background-color: #ffffff;
        position: absolute;/*
        transform: rotate(45deg);*/
        height: 20px;
        width: 20px;
        border-radius: 50%;
        border: 4px solid #006ba2;
        /*border-bottom: 2px solid #237cd8;
        border-right: 2px solid #237cd8;*/
        visibility: hidden;
        z-index: 2;
    }
    .reward_type{
        visibility: hidden;
        position: absolute;
        top: 0;
        left: 0;
    }
    .options input:checked + .radio_label:before{
        visibility: hidden;
    }
    .options input:checked + .radio_label:after{
        visibility: visible;
    } 
    .options input:checked + .radio_label .card{
        border: 1px solid #006ba2;
        background: #effaff;
    } 
    .card_style{
        padding: 12px;
        padding-left: 40px;
    }
    .card_style h6{
        font-size: 14px;
        margin-bottom: 6px;
    }
    .card_style p{
        font-size: 12px;
        line-height: 16px;
    }
    .cash_per_click label span {
        color: red;
    }
    .add-gift{
        border-radius: 0px 3px 3px 0px;
    }
    .input_gift{
        border-radius: 0.25rem 0px 0px 0.25rem !important;
    }
    .gift_item .badge{
        line-height: 0;
    }
    .outer_badge{
        padding: 4px 4px 4px 10px;
    } 
    .delete_badge{
        padding: 10px 8px;
        font-size: 10px;
        margin-left: 6px;
         cursor: pointer;
    }    
    @media(max-width: 575px){
        .toggle_buttons_share .custom-switch {
            padding-left: 0rem;
        }
        .current_offer_share .card{
            flex-direction: column;
        }
    }
    @media(max-width: 991px){
        .options{
            height: 100%;
            min-height: 100%;
        }

    }
    

    .qr_main{
        position: relative;
        margin-left: auto;
        margin-right: auto;
        margin-bottom: 20px;
        width: 100%;
        max-width: 280px;
        /* border: 1px solid rgb(201, 201, 201); */
        border-radius: 4px;
        overflow: hidden;
    }
    .qr_main .qr_inner{
        width: 100%;
        padding: 3px;
        /* padding-bottom: 100%; */
    }


    /* popup design */
    .qr-pre-modal .modal-dialog{
        width: auto!important;
        max-width: 800px;
    }
    .qr-pre-modal .nav .nav-item{
        /* width: 100%; */
        margin-bottom: 10px;
    }
    .qr-pre-modal .nav a.nav-link{
        color: var(--cl-default);
        border:1px solid rgba(0, 0, 0, 0.1);
        border-radius:4px;
        background: #fff;
    }
    .qr-pre-modal .nav a.nav-link.active{
        background: rgba(0, 0, 0, 0.05);
    }
    .qr-pre-modal .nav a.nav-link p{
        line-height: 2;
    }
    .qr-pre-modal .nav a.nav-link i.fa{
        vertical-align: sub;
        line-height: 1;
    }
    @media(min-width:768px){
        .qr-pre-modal .nav .nav-item{
            width: 100%;
        }
    }
    @media(max-width:830px){
        .qr-pre-modal .modal-dialog{
            margin: .5rem;
        }
    }
</style>
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

@section('head') @include('layouts.partials.headersection',['title'=>'Instant Challenge']) @endsection

@section('content')
<section class="section">
    <div class="">

        @php
            $user_id = Auth::User()->id;
            $group = \DB::table('contact_groups')->where('user_id', $user_id)->where('channel_id', 2)->first();
        @endphp
        
        <div class="row align-items-center">
            <div class="col-sm-6 col-12 mb-4 order-sm-2">
                @if(isset($routes) && !empty($routes))
                    @include('business.channels.routes-toggle')
                @endif
            </div>
            <div class="col-sm-6 col-12 mb-4 order-sm-1">
                <button class="btn btn-primary " data-toggle="modal" data-target="" id="qr_code_modal_check">QR Code <i class="fas fa-qrcode"></i></button>
                {{-- <button class="btn btn-success ml-2">Share <i class="fas fa-share"></i></button> --}}
                <a href="{{ route('business.viewGroup', $group->id) }}"><button class="btn btn-warning @if($planData['userData']->current_account_status == 'free') __pro__ @endif">Challenge Subscribers</button></a>
            </div>
        </div>

        
        <div class="row">

            <div class="col-md-7 col-lg-8">
                <form method="POST" action="{{ route('business.channel.instantRewardSetting', $channel_id) }}" id="instantRewardForm">
                <div class="card">
                    <div class="card-header justify-content-between">
                        <h4>Challenge Rewards</h4>
                         <span class="info-btn" data-toggle="tooltip"  title="Here you can set and update your reward details and amount which will be given to the customer who has shared and completed the challenge."><i class="fa fa-info-circle"></i></span>
                    </div>

                    <div class="card-body">

                        {{-- Discount types (radio Buttons) --}}
                        <div class="form-group mb-5">
                            <label class="form-label mb-3">Select Discount type for your running offer</label>
                            <div class="row select_offer">

                                <div class="col-sm-6 mb-1 mb-3 " > 
                                    @if($planData['userData']->current_account_status == 'free')
                                    <div class="options"  data-toggle="tooltip">
                                    @else
                                    <div class="options"  data-toggle="tooltip" title="Set the fixed amount in rupees, you want to give to your customer as an offer.">
                                    @endif
                                    
                                        <input type="radio" name="type" value="Fixed Amount" id="fixedAmount" class="reward_type  radio_button_fixed" @if($settings->type == 'Fixed Amount') checked @endif> 
                                        <label class="radio_label fixed_label mb-0" for="fixedAmount">
                                            <div class="card">
                                                <div class="card_style">
                                                    <h6 class="mb-0 @if($planData['userData']->current_account_status == 'free') __pro__ @endif">Fixed Amount</h6> 
                                                </div>
                                            </div>  
                                        </label>    
                                    </div>
                                </div>

                                <div class="col-sm-6  mb-1 mb-3">
                                @if($planData['userData']->current_account_status == 'free')
                                <div class="options" data-toggle="tooltip">
                                @else
                                <div class="options" data-toggle="tooltip" title="Set the percentage of discount you want to give to your customer.">
                                @endif
                                        <input type="radio" name="type" value="Percentage Discount" id="percentageDiscount" class="reward_type radio_button_percentage" @if($settings->type == 'Percentage Discount') checked @endif> 
                                        <label class="radio_label percentage_label mb-0" for="percentageDiscount">
                                            <div class="card">
                                                <div class="card_style">
                                                    <h6 class="mb-0 @if($planData['userData']->current_account_status == 'free') __pro__ @endif">Percentage Discount</h6>  
                                                </div>
                                            </div>  
                                        </label>    
                                    </div> 
                                </div>

                                <div class="col-sm-6 mb-1 mb-3">
                                @if($planData['userData']->current_account_status == 'free')
                                <div class="options" data-toggle="tooltip">
                                @else
                                <div class="options" data-toggle="tooltip" title="Set the Gifts names which you want to give to your customer as reward.">
                                @endif
                                        <input type="radio" name="type" value="Gift" id="giftItem" class="reward_type radio_button_gift" @if($settings->type == 'Gift') checked @endif> 
                                        <label class="radio_label gift_label mb-0" for="giftItem">
                                            <div class="card">
                                                <div class="card_style">
                                                    <h6 class="mb-0 @if($planData['userData']->current_account_status == 'free') __pro__ @endif">Gifts</h6>  
                                                </div>
                                            </div>  
                                        </label>    
                                    </div> 
                                </div>

                                @if($planData['userData']->current_account_status == 'free')
                                    <div class="col-sm-6  mb-3">
                                        <div class="options" data-toggle="tooltip" title="Here customer will not get any reward.">
                                            <input type="radio" name="type" value="Free" id="noreward" class="reward_type radio_button_noreward" @if($settings->type == 'Free' || $planData['userData']->current_account_status == 'free') checked @endif > 
                                            <label class="radio_label gift_label mb-0" for="noreward">
                                                <div class="card">
                                                    <div class="card_style">
                                                        <h6 class="mb-0">Free</h6>  
                                                    </div>
                                                </div>  
                                            </label>    
                                        </div> 
                                    </div>
                                @else
                                    <div class="col-sm-6  mb-3">
                                        @if($userBalance['wallet_balance'] > 0)
                                        <div class="options" data-toggle="tooltip" title="Here customer will not get any reward.">
                                            <input type="radio" name="type" value="No Reward" id="noreward" class="reward_type radio_button_noreward" @if($settings->type == 'No Reward' || $userBalance['wallet_balance'] <= 0) checked @endif> 
                                            <label class="radio_label gift_label mb-0" for="noreward">
                                                <div class="card">
                                                    <div class="card_style">
                                                        <h6 class="mb-0">No Reward</h6>  
                                                    </div>
                                                </div>  
                                            </label>    
                                        </div>
                                        @else
                                        <div class="options" data-toggle="tooltip" title="Here customer will not get any reward.">
                                            <input type="radio" name="type" value="Free" id="noreward" class="reward_type radio_button_noreward" @if($settings->type == 'Free'|| $userBalance['wallet_balance'] <= 0) checked @endif > 
                                            <label class="radio_label gift_label mb-0" for="noreward">
                                                <div class="card">
                                                    <div class="card_style">
                                                        <h6 class="mb-0">Free</h6>  
                                                    </div>
                                                </div>  
                                            </label>    
                                        </div>
                                        @endif

                                    </div>
                                @endif
                                

                            </div>
                        </div>
                        {{-- Discount Types END --}}

                        {{-- Fixed Amount --}}
                        <div class="types-to-input @if($settings->type != 'Fixed Amount') blank-inputs @endif form-group row" id="discount_amount" style="margin-bottom: 15px;@if(!isset($settings->details['discount_amount']))display:none;@endif">
                            <div class="col-sm-5 col-form-label">
                                <label class="mb-1">Enter Discount Amount <span class="text-danger">*</span> </label>
                                <p class="small text-secondary mb-1" style="line-height:1.6;">Set the fixed amount in rupees, you want to give to your customer as an offer.</p>    
                            </div>
                            <div class="col-sm-7">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                                    </div>
                                    <input type="text" name="discount_amount"  class="form-control offer_data_in price-validation" min="1" placeholder="Enter Amount above 0" value="{{ $settings->details['discount_amount'] ?? '' }}">
                                </div>
                                <span class="error" style="display: none" id="error_discount_amount">Error</span>
                            </div>
                        </div>

                        {{-- Percentage Discount --}}
                        <div class="types-to-input @if($settings->type != 'Percentage Discount') blank-inputs @endif form-group row" id="discount_percent" style="margin-bottom: 15px;@if(!isset($settings->details['discount_percent']))display:none;@endif">
                            <div class="col-sm-5 col-form-label">
                                <label class="mb-1">Enter Discount Percentage <span class="text-danger">*</span> </label>
                                <p class="small text-secondary mb-1" style="line-height:1.6;">Set the percentage of discount you want to give to your customer.</p>
                            </div>
                            <div class="col-sm-7">
                                <div class="input-group">
                                    <input type="text" name="discount_percent"  class="form-control offer_data_in price-validation" min="0" max="100" placeholder="Enter Percentage between 1 to 100%" value="{{ $settings->details['discount_percent'] ?? '' }}">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="border-radius: 0 3px 3px 0;"><i class="fas fa-percent"></i></span>
                                    </div>
                                </div>
                                <span class="error" style="display: none" id="error_discount_percent">Error</span>
                            </div>    
                        </div>

                        {{-- Gifts --}}
                        <div class="types-to-input @if($settings->type != 'Gift') blank-inputs @endif form-group row" style="@if(!isset($settings->details['gift']))display:none;@endif" id="gift_name" >
                            <div class="col-sm-5 col-form-label">
                                <label for="gift_name" class="d-block">Add Gift Item <span class="text-danger">*</span> </label>
                                <p class="small text-secondary mb-1" style="line-height:1.6;">Enter the name of product and click Add to add the name(Max 5 names).</p>
                            </div> 
                            <div class="col-sm-7">
                                <div class="input-group">
                                    <input type="hidden" name="gift" class="input_gift" value="{{ $settings->details['gift'] ?? '' }}">
                                    <input type="text" name="gift_name" maxlength="32" class="form-control input_gift mb-2" placeholder="Enter Name...">
                                    <div class="input-group-append">
                                        <button class="input-group-text btn btn-primary add-gift text-white px-3" type="button"><i class="fa fa-plus mr-2"></i>Add</button>
                                    </div>
                                </div>
                                <p class="small text-secondary mb-1" style="line-height:1.6;">Maximum character limit is 32.</p>

                                
                                <span class="error" style="display: none" id="error_gift_name">Error</span>
                                @php
                                    $gifts = array(); 
                                    if(isset($settings->details['gift']) && $settings->details['gift'] != ' '){
                                        $gifts = explode(',',$settings->details['gift']);
                                    }
                                @endphp
                                <ul class="badge gift_item d-flex flex-wrap px-0 mx-auto mb-0">
                                    @if(count($gifts) > 0)
                                        @foreach($gifts as $gift)
                                        <li class="delete-item outer_badge badge badge-warning d-flex justify-content-between align-items-center mb-2 mr-2"><span class="gift-name">{{ $gift }}</span><span class="badge badge-danger badge-pill delete_badge">X</span></li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>   
                        </div>

                        {{-- Free Reward --}}
                        <div class="types-to-input @if($settings->type != 'Free') blank-inputs @endif form-group row" style="@if(!isset($settings->details['Free']) || $userBalance['wallet_balance'] > 0 || $planData['userData']->current_account_status == 'free') display:none; @endif" id="noreward_row" >
                        </div>


                        {{-- Minimum Task To be complete --}}
                        <div class="form-group row" id="minimum_task" style="@if(!isset($settings->details['minimum_task'])) display:none; @endif">
                            <div class="col-sm-5 col-form-label">
                                <label>Minimum tasks <span class="text-danger">*</span> </label>  
                            </div>
                            <div class="col-sm-7">
                                <input type="text" name="minimum_task" min="1" class="form-control number-validation" placeholder="Enter number of tasks require..." value="{{ $settings->details['minimum_task'] ?? '' }}">
                                <span class="error" style="display: none" id="error_minimum_task">Error</span>
                            </div>   
                        </div>

                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                
                                {{-- Submit buttom --}}
                                <button type="submit" class="btn btn-success px-4" style="width:100px">Save</button>
                            </div>
                            <div>
                                {{-- Modify tasks button --}}
                                <a href="{{ route('business.channel.instantRewards.modifyTasks') }}" class="btn btn-primary px-1 px-md-4">Modify Challenge Tasks</a>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>


            {{-- Column 2nd --}}
            <div class="col-lg-4 col-md-5 mb-3">
                
                @include('business.current-offer')

            </div>
            
        </div>
        
    </div>

    {{-- @include('components.recharge_alert') --}}
</section>
@php
    // dd($planData);
@endphp

{{-- QR Code modal --}}
<div class="modal ol-modal popin qr-pre-modal" tabindex="-1" role="dialog" id="qr_code_modal">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            {{-- <div class="modal-header px-3 pt-3">
                <h5 class="modal-title text-primary">Get QR</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="qr_code_modal_close">
                    <span aria-hidden="true" style="font-size: 16px;"><i class="fa fa-times"></i></span>
                </button>
            </div> --}}
            <div class="modal-body p-3 pr-md-5">

                <button type="button" class="close" style="position: absolute;top: 5px;right: 15px;line-height: 1;z-index: 1;" data-dismiss="modal" aria-label="Close" id="qr_code_modal_close">
                    <span aria-hidden="true" style="font-size: 16px;"><i class="fa fa-times"></i></span>
                </button>
                @php
                    $path = 'assets/business/logos/'.$planData['business_detail']['logo'];
                    
                    if ( $planData['business_detail']['logo'] != '' && file_exists($path)) {
                        $qrcode = '<img src="data:image/png;base64, '.base64_encode(QrCode::format('png')->size(512)->merge(asset($path), .25, true)->color(0, 121, 163)->errorCorrection('H')->generate($qr_url)).'" width="100%">';
                    }else{
                        $qrcode = '<img src="data:image/png;base64, '.base64_encode(QrCode::format('png')->size(512)->color(0, 121, 163)->errorCorrection('H')->generate($qr_url)).'" width="200px">';
                    }
                    // $qrcode = QrCode::size(200)->color(0, 121, 163)->generate($qr_url);
                @endphp
                <div class="row">
                    <div class="col-md-5">
                        <div class="modal-header px-0 pt-0">
                            <h5 class="modal-title text-primary">Get QR</h5>
                            
                        </div>
                        <div class="mb-4">
                            <p>See the multiple QR design options below for your Instant Challenge, And download whichever you like.</p>
                        </div>

                        <p class="mb-1"><b>List of Designs:</b></p>
                        <ul class="nav nav-tabs flex-row flex-md-column" id="qr-designs-tab" role="tablist">
                            <li class="nav-item">
                              <a class="nav-link active" id="qrd-1-tab" data-toggle="tab" href="#qrd-1" role="tab" aria-controls="qrd-1" aria-selected="true">
                                <div class="qr-des-btn">
                                    <div class="d-md-flex text-center text-md-left align-items-center">
                                        <div class="mr-md-3 mb-3 mb-md-0">
                                            <i class="fa fa-qrcode fa-2x"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Design 1</h6>
                                            <p class="small mb-0 d-none d-md-block">Without contact details on the design</p>
                                        </div>
                                    </div>
                                </div>
                              </a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="qrd-2-tab" data-toggle="tab" href="#qrd-2" role="tab" aria-controls="qrd-2" aria-selected="false">
                                <div class="qr-des-btn">
                                    <div class="d-md-flex text-center text-md-left align-items-center">
                                        <div class="mr-md-3 mb-3 mb-md-0">
                                            <i class="fa fa-qrcode fa-2x"></i>
                                        </div>
                                        <div>
                                            <h6  class="mb-0">Design 2</h6>
                                            <p class="small mb-0 d-none d-md-block">With contact details on the design</p>
                                        </div>
                                    </div>
                                </div>
                              </a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="qrd-3-tab" data-toggle="tab" href="#qrd-3" role="tab" aria-controls="qrd-3" aria-selected="false">
                                <div class="qr-des-btn">
                                    <div class="d-md-flex text-center text-md-left align-items-center">
                                        <div class="mr-md-3 mb-3 mb-md-0">
                                            <i class="fa fa-qrcode fa-2x"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Design 3</h6>
                                            <p class="small mb-0 d-none d-md-block">With contact details on the design</p>
                                        </div>
                                    </div>
                                </div>
                              </a>
                            </li>
                        </ul>

                        {{-- <div>
                            <button type="button" class="btn btn-outline-danger px-3 d-none d-md-inline-block" data-dismiss="modal" aria-label="Close">
                                Close
                            </button>
                        </div> --}}
                    </div>
                    <div class="col-md-7">
                        <div class="tab-content bg-light rounded" id="qr-designs-preview">
                            <div class="tab-pane fade show active" id="qrd-1" role="tabpanel">
                                <div class="mx-auto" style="max-width: 320px;">
                                    {{-- First Design  --}}
                                    <div class="qr-column ">
                                        <div class="bg-white">
                                            @include('business.instant-rewards.qr-design-one', array($qrcode))
                                        </div>
                                        <div class="mt-3 text-center">
                                            <a class="btn btn-primary px-3" href="{{ route('business.downloadQrCode', 'one') }}"> <i class="fa fa-download mr-2"></i> Download</a>
                                            <a class="btn btn-info px-3" href="{{ route('business.downloadQrCode', ['str' => 'one', 'stream' => 1]) }}" target="_blank"> <i class="fa fa-print mr-2"></i> Print</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="qrd-2" role="tabpanel">
                                <div class="mx-auto" style="max-width: 320px;">
                                    {{-- Second Design  --}}
                                    <div class="qr-column">
                                        <div class="bg-white">
                                            @include('business.instant-rewards.qr-design-two', array($qrcode))
                                        </div>
                                        <div class="mt-3 text-center">
                                            <a class="btn btn-primary px-3" href="{{ route('business.downloadQrCode', 'two') }}"> <i class="fa fa-download mr-2"></i> Download</a>
                                            <a class="btn btn-info px-3" href="{{ route('business.downloadQrCode', ['str' => 'two', 'stream' => 1]) }}" target="_blank"> <i class="fa fa-print mr-2"></i> Print</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="qrd-3" role="tabpanel">
                                <div class="mx-auto" style="max-width: 320px;">
                                    {{-- third Design  --}}
                                    <div class="qr-column ">
                                        <div class="bg-white">
                                            @include('business.instant-rewards.qr-design-three', array($qrcode))
                                        </div>
                                        <div class="mt-3 text-center">
                                            <a class="btn btn-primary px-3" href="{{ route('business.downloadQrCode', 'three') }}"> <i class="fa fa-download mr-2"></i> Download</a>
                                            <a class="btn btn-info px-3" href="{{ route('business.downloadQrCode', ['str' => 'three', 'stream' => 1]) }}" target="_blank"> <i class="fa fa-print mr-2"></i> Print</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                

                {{-- <div class="text-center">
                    <p>Please click download button to download the QR code and put it anywhere you want for more customer acquisition.</p>
                    <a class="btn btn-primary px-3" href="{{ route("business.downloadQrCode") }}">Download QR Code</a>
                </div> --}}

            </div>
        </div>
    </div>
</div>
{{-- QR Code modal - END --}}




@endsection

@section('end_body')
<script>
    $(function () {

        $('.reward_type').on('change', function() {

            var selected_type = $('.reward_type:checked');

            /* Hide all inputes related to types */
            $('.types-to-input').hide();
            $('.blank-inputs').find('input').val('');
            $('.blank-inputs .gift_item').empty();
            
            /* check which type selectd and then show their inputs */
            if(selected_type.val() === 'Fixed Amount'){
                $("#discount_amount").show();
                $('#minimum_task').show();
            }
            else if(selected_type.val() === 'Percentage Discount'){
                $("#discount_percent").show();
                $('#minimum_task').show();
            }
            else if(selected_type.val() === 'Gift'){
                $("#gift_name").show();
                $('#minimum_task').show();
            }
            else if(selected_type.val() === 'No Reward'){
                $('#minimum_task').show();
            }else if(selected_type.val() === 'Free'){
                $('#minimum_task').hide();
                $("#gift_name").hide();
                $("#discount_percent").hide();
                $("#discount_amount").hide();
                $("#noreward_row").show();
            }
        });

    });
</script>

<script>
    $(function () {
        var count = 0;
        var gift_name = $('input[name="gift_name"]'),
        items = $(".gift_item");
            $(".add-gift").on("click", function (e) {
                e.preventDefault();

                if(gift_name.val()==""){
                    Sweet("error", "Please enter gift name");
                    gift_name.focus();
                }
                else if(gift_name.val().length < 3){
                    Sweet("error", "Gift name require more than 3 character");
                    gift_name.focus();
                }
                else{

                    var gift_added = '';
                    var giftItems = $(".gift_item li");

                    count = giftItems.length;
                    var isNewAddedGift = true;

                    giftItems.each(function(idx, li) {
                        var single = $(li).children('.gift-name');

                        if(gift_name.val() != single.text()){
                            gift_added = gift_added + ',' + single.text();
                        }
                        else{
                            isNewAddedGift = false;
                        }
                    });

                    if (gift_name.val()) {
                        if(count < 5){
                            // input val
                            if(isNewAddedGift==true){
                                items.append(
                                    '<li class="delete-item outer_badge badge badge-warning d-flex justify-content-between align-items-center mb-2 mr-2"><span class="gift-name">' +
                                    gift_name.val() +
                                    '</span><span class="badge badge-danger badge-pill delete_badge">X</span></li>'
                                );

                                gift_added = gift_added+','+gift_name.val();
                                // console.log(gift_added);
                                $('input[name="gift"]').val(gift_added.replace(/^,|,$/g,''));

                                gift_name.val("");
                                count++;
                            }
                            else{
                                Sweet("error","Repeat gift name not allowed.");
                                gift_name.focus();
                            }
                        }else{
                            Sweet("error","Gift items limit exceeded(You can add 5 gift items only).");
                            gift_name.focus();
                        }
                    
                    } else {
                        Sweet("error","Gift name can not be blank.");
                        gift_name.focus();
                    }
                }
            });

            $(document).on("click", ".delete-item", function () {
                items.find("li").eq($(this).index()).remove();
                count--;

                var gift_added = '';
                var giftItems = $(".gift_item li");
                giftItems.each(function(idx, li) {
                    var single = $(li).children('.gift-name');
                    gift_added = gift_added+','+single.text();
                });

                $('input[name="gift"]').val(gift_added.replace(/^,|,$/g,''));
            });
    });

    $(document).ready(function(){

        $("#qr_code_modal_check").on("click", function(){
            var planData = @json($planData);
            // console.log(planData);
            if(planData.instant_reward_settings != null){
                $("#qr_code_modal").modal('show');
            }else{
                Sweet("error", "Please first update the Challenge Settings.");
                return false;
            }
        });

        $("#qr_code_modal_close").on("click", function(){
            $("#qr_code_modal").modal('hide');
        });

        /* $(document).ajaxSend(function() {
            $("#overlay").fadeIn(300);　
        }); */

        $("#instantRewardForm").on('submit', function(e){
            e.preventDefault();

            var isChannelActive = {{ $isChannelActive['status'] }};
            var tasksCount = {{ $counttask }};
            if(isChannelActive == 0){
                var msg = "{{Config::get('constants.instant_challenge_status')}}"
                Sweet("error", msg);
                return false;
            }
            /* If dont have running offer or not posted */
            var is_posted = {{ $planData['is_posted'] }};
            /*if(is_posted == 0){
                Sweet("error", "First Create and Post offer on Social Media.");
                return false;
            }*/


            // validations
            var isError = false;
            $(".error").hide();
            var challenge_type = $('input[name=type]:checked').val();
            if(challenge_type=="Fixed Amount"){
                var discount_amount = $('input[name="discount_amount"]').val(); 
                if(discount_amount==""){
                    $("#error_discount_amount").text("Please enter discount amount!");
                    $("#error_discount_amount").show();
                    isError = true;
                }
                else if($.isNumeric(discount_amount)==false){
                    $("#error_discount_amount").text("Enter valid discount amount!");
                    $("#error_discount_amount").show();
                    isError = true;
                }
                else if(discount_amount <= 0){
                    $("#error_discount_amount").text("Enter valid discount amount!");
                    $("#error_discount_amount").show();
                    isError = true;
                }
            }
            else if(challenge_type=="Percentage Discount"){
                var discount_percent = $('input[name="discount_percent"]').val(); 
                if(discount_percent==""){
                    $("#error_discount_percent").text("Please enter discount percent!");
                    $("#error_discount_percent").show();
                    isError = true;
                }
                else if($.isNumeric(discount_percent)==false){
                    $("#error_discount_percent").text("Enter valid discount percent!");
                    $("#error_discount_percent").show();
                    isError = true;
                }
                else if(discount_percent <= 0 || discount_percent > 100){
                    $("#error_discount_percent").text("Enter valid discount percent!");
                    $("#error_discount_percent").show();
                    isError = true;
                }
            }
            /*else if(challenge_type=="No Reward"){
            }*/
            var minimum_task;
            if(challenge_type != "Free"){

                minimum_task = $('input[name="minimum_task"]').val();
                if(minimum_task==""){
                    $("#error_minimum_task").text("Please enter number of tasks!");
                    $("#error_minimum_task").show();
                    isError = true;
                }
                else if($.isNumeric(minimum_task)==false){
                    $("#error_minimum_task").text("Enter valid number of tasks!");
                    $("#error_minimum_task").show();
                    isError = true;
                }
                else if(minimum_task <= 0){
                    $("#error_minimum_task").text("Enter valid number of tasks!");
                    $("#error_minimum_task").show();
                    isError = true;
                }else if(minimum_task > tasksCount){
                    $("#error_minimum_task").text("Enter valid number of tasks!");
                    $("#error_minimum_task").show();
                    isError = true;
                }
            }else{
                $('input[name="minimum_task"]').val('1');
                minimum_task = 1;
            }
            if(isError==true){
                return false;
            }
           

            var formData = new FormData(this);
            var action = this.action;
            console.log(minimum_task);
            // var tasks = $('input[name="minimum_task"]').val();
            var task_status = false;
            if(minimum_task != '' && minimum_task > 0){
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                var $data = {
                    'minimum_task' : minimum_task,
                    '_token' : CSRF_TOKEN
                };

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    }
                });
                $.ajax({
                    url: "{{ route('business.checkTasks') }}",
                    type: "post",
                    dataType: "json",
                    async: true,
                    data: $data,
                    success: function(response) {
                        // console.log(response);
                        if(response.status == false){

                            Swal.fire({
                                title: '<strong>Please Create Task First</strong>',
                                icon: 'info',
                                html:
                                response.message,
                                showCloseButton: false,
                                showCancelButton: true,
                                focusConfirm: false,
                                allowOutsideClick:false,
                                confirmButtonText:
                                    'Go To Task Page',
                                cancelButtonText:
                                    'Close'
                            }).then((result) => {
                                // console.log(result);
                                if (result.value == true) {
                                    window.location.href = '{{ route('business.channel.instantRewards.modifyTasks') }}'
                                } 
                            })
                            // Sweet("error", response.message);

                            return false;
                        }
                        else{
                            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
                            $.ajax({
                                type: 'POST',
                                url: action,
                                data: formData,
                                dataType: 'json',
                                contentType: false,
                                cache: false,
                                processData:false,
                                success: function(response){ 
                                    $("#overlay").fadeOut(300);
                                    // console.log(response);
                                    
                                    // Update header setting status
                                    $('.refresh-settings-status').click();

                                    if(response.status == true){
                                        Sweet('success',response.message);
                                        setTimeout(() => {
                                            window.location.reload();
                                        }, 1200);
                                        
                                    }else{
                                        Sweet('error',response.message);
                                    }
                                },
                                error: function(xhr, status, error) 
                                {
                                    $("#overlay").fadeOut(300);
                                    $.each(xhr.responseJSON.errors, function (key, item) 
                                    {
                                        Sweet('error',item);
                                    });
                                }
                            })
                        }
                    },
                    error: function(response) {
                        //
                    }
                })
            }else if(tasks != '' && tasks <= 0){
                Sweet("error", "Enter valid input");
            }
        });


        //get Customer info
        // $('input[name="minimum_task"]').on('focusout', function(event) {
        //     checkTasks();
        // });

        // $('input[name="minimum_task"]').on('keyup', function(event) {
        //     checkTasks();
        // });

        // function checkTasks(){
        //     var tasks = $('input[name="minimum_task"]').val();

        //     if(tasks != '' && tasks > 0){
        //         var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        //         var $data = {
        //             'minimum_task' : tasks,
        //             '_token' : CSRF_TOKEN
        //         };

        //         $.ajaxSetup({
        //             headers: {
        //                 'X-CSRF-TOKEN': CSRF_TOKEN
        //             }
        //         });
        //         $.ajax({
        //             url: "{{ route('business.checkTasks') }}",
        //             type: "post",
        //             dataType: "json",
        //             data: $data,
        //             success: function(response) {
        //                 if(response.status == false){
        //                     Sweet("error", response.message);
        //                     $('input[name="minimum_task"]').focus();
        //                 }
        //             },
        //             error: function(response) {
        //                 //
        //             }
        //         })
        //     }else if(tasks != '' && tasks <= 0){
        //         Sweet("error", "Enter valid input");
        //     }
        //     //return false;
        // }
    });
</script>

@include('business.channels.common-js')

@endsection