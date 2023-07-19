@extends('layouts.business')
@section('title', 'Share Challenge: Business Panel')

@section('end_head')
<link rel="stylesheet" href="{{ asset('assets/plugin/choices.js/styles/choices.min.css') }}">
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

     .choices__list--dropdown .choices__item--selectable
    {
        padding-right: 4px;
    }
   .choices__list--dropdown .choices__item--selectable:after
    {
        display: none;
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

    /*--auto send offer--*/
    .select_hours{
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        grid-template-rows: 1fr 2fr 1fr;
        gap: 30px 20px;
    }
    .auto_send_offer_button {
      /*float: left;*/
      /*margin: 0 5px 10 0;*/
      width: 100px;
      position: relative;
      border: 1px solid #eee;
      text-align: center;
    }

    /* .auto_send_offer_button label,
    .auto_send_offer_button input {
      display: block;
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
    } */
    
    .auto_send_offer_button input {
      display: block;
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
    }

    .auto_send_offer_button input[type="radio"] {
      opacity: 0.011;
      z-index: 100;
    }

    .auto_send_offer_button input[type="radio"]:checked + label {
        background: var(--primary);
        border-radius: 0px;
        width: 100px;
        color: #fff;
    }

    .auto_send_offer_button label {
      cursor: pointer;
      z-index: 90;
      line-height: 1.8em;
      margin-bottom: 0px;
    }

    .hours_tab {
        border: 1px solid #ddd;
    }
    .form-check-input {
        width: 18px;
        height: 18px;
    }
    .form-check-label {
        margin-top: 4px;
        margin-left: 5px;
    }
    /*--end auto send offer--*/

    /*--select groups--*/
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: var(--cl-prime);
        color: #fff;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: #fff;
    }
    .form-group textarea {
        height: 35px !important;
    }
    /* .select2-container{
        max-width: 100% !important;
        width: 100%;
    } */
    /*--end select groups--*/
    
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

@section('head') @include('layouts.partials.headersection',['title'=>'Share Challenge']) @endsection

@section('content')
<section class="section">
    <div class="section-body">

        <div class="mb-4">
            @if(isset($routes) && !empty($routes))
                @include('business.channels.routes-toggle')
            @endif
        </div>

        <div  class="row">

            <div class="col-md-7 col-lg-8">
                <form method="post" action="{{ route('business.channel.shareAndRewardSetting', $channel_id) }}" id="shareAndRewardForm">
                    <input type="hidden" name="channel_id" id="channel_id" value="{{ $channel_id }}" />
                    <input type="hidden" name="has_reward_setting" id="has_reward_setting" value="{{ $has_reward_setting }}" />
                    <div class="card">
                        <div class="card-header justify-content-between">
                            <h4>Challenge Settings</h4>
                            <span class="info-btn" data-toggle="tooltip"  title="Here you can set and update your reward details and amount which will be given to the customer who has shared and completed the challenge."><i class="fa fa-info-circle"></i></span>
                        </div>
                        <div class="card-body">
                            {{-- Reward Type --}}
                            <div class="form-group">
                                <label class="form-label mb-3">Select Discount type for your running offer</label>
                                
                                <div class="row select_offer">
                                    <div class="col-sm-6 mb-3"> 

                                    @if($planData['message_plan']->wallet_balance <= 0)
                                    <div class="options" data-toggle="tooltip">
                                    @else
                                    <div class="options" data-toggle="tooltip" title="Set Reward cashback to your customer for each click while they share.">
                                    @endif
                                            <input type="radio" name="type" value="Cash Per Click"  id="cashPerClick" class="reward_type radio_button_cash" @if($settings->type == 'Cash Per Click') checked @endif> 
                                            <label class="radio_label cash_label mb-0" for="cashPerClick">
                                                <div class="card">
                                                    <div class="card_style">
                                                        <h6 class="mb-0 @if($planData['userData']->current_account_status == 'free') __pro__ @endif">Cash Per Click</h6> 
                                                    </div>
                                                </div>  
                                            </label>    
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mb-3"> 
                                        <div class="options">
                                            <input type="radio" name="type" value="Fixed Amount"  id="fixedAmount" class="reward_type  radio_button_fixed" @if($settings->type == 'Fixed Amount') checked @endif> 
                                            <label class="radio_label fixed_label mb-0" for="fixedAmount">
                                                <div class="card">
                                                    <div class="card_style">
                                                    @if($planData['userData']->current_account_status == 'free')
                                                    <h6 class="mb-0 @if($planData['userData']->current_account_status == 'free') __pro__ @endif" data-toggle="tooltip">Fixed Amount</h6>
                                                    @else
                                                    <h6 class="mb-0 @if($planData['userData']->current_account_status == 'free') __pro__ @endif" data-toggle="tooltip" title="Set the fixed amount in rupees, you want to give to your customer as an offer.">Fixed Amount</h6> 
                                                        @endif
                                                    </div>
                                                </div>
                                            </label>  
                                        </div>
                                    </div> 
                                    <div class="col-sm-6 mb-3">
                                        <div class="options">
                                            <input type="radio" name="type" value="Percentage Discount"  id="percentageDiscount" class="reward_type radio_button_percentage" @if($settings->type == 'Percentage Discount') checked @endif> 
                                            <label class="radio_label percentage_label mb-0" for="percentageDiscount">
                                                <div class="card">
                                                    <div class="card_style">
                                                    @if($planData['userData']->current_account_status == 'free')
                                                    <h6 class="mb-0 @if($planData['userData']->current_account_status == 'free') __pro__ @endif" data-toggle="tooltip" >Percentage Discount</h6>  
                                                    @else
                                                    <h6 class="mb-0 @if($planData['userData']->current_account_status == 'free') __pro__ @endif" data-toggle="tooltip" title="Set the percentage of discount you want to give to your customer.">Percentage Discount</h6>  
                                                    @endif
                                                    </div>
                                                </div>
                                            </label>
                                        </div> 
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <div class="options">
                                            <input type="radio" name="type" value="Gift"  id="giftItem" class="reward_type radio_button_gift" @if($settings->type == 'Gift') checked @endif> 
                                            <label class="radio_label gift_label mb-0" for="giftItem">
                                                <div class="card">
                                                    <div class="card_style">

                                                    @if($planData['userData']->current_account_status == 'free')
                                                    <h6 class="mb-0 @if($planData['userData']->current_account_status == 'free') __pro__ @endif" data-toggle="tooltip" >Gift</h6>  
                                                    @else
                                                    <h6 class="mb-0 @if($planData['userData']->current_account_status == 'free') __pro__ @endif" data-toggle="tooltip" title="Set the percentage of discount you want to give to your customer.">Gift</h6>  
                                                    @endif
                                                    </div>
                                                </div>  
                                            </label>    
                                        </div> 
                                    </div>

                                    @if($planData['userData']->current_account_status == 'free')   
                                        <div class="col-sm-6  mb-3">
                                            <div class="options" data-toggle="tooltip" title="Here customer will not get any reward.">
                                                <input type="radio" name="type" value="Free" id="noreward" class="reward_type radio_button_noreward" @if($settings->type == 'Free' || $planData['userData']->current_account_status == 'free') checked @endif> 
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
                                            <div class="options" data-toggle="tooltip" title="Here customer will not get any reward.">
                                                <input type="radio" name="type" value="No Reward" id="noreward" class="reward_type radio_button_noreward" @if($settings->type == 'No Reward' || $userBalance['wallet_balance'] <= 0) checked @endif > 
                                                <label class="radio_label gift_label mb-0" for="noreward">
                                                    <div class="card">
                                                        <div class="card_style">
                                                            <h6 class="mb-0">No Reward</h6>  
                                                        </div>
                                                    </div>  
                                                </label>    
                                            </div> 
                                        </div>
                                    @endif
                                    


                                </div>
                            </div>
                            {{-- Types END --}}


                            <div>
                                {{-- per click (cashback) --}}
                                <div class="types-to-input  @if($settings->type != 'Cash Per Click') blank-inputs @endif form-group row" id="discount_perclick" style="@if(!isset($settings->details['discount_perclick']))display:none;@endif">
                                    <div class="col-sm-5 col-form-label">
                                        <label class="mb-1">Enter discount amount per click <span class="text-danger">*</span> </label>
                                        <p class="small text-secondary mb-1 mb-1" style="line-height:1.6;">Set fixed cashback amount per click you want to give to your customer (for example: &#8377;1,  &#8377;0.50).</p>
                                    </div>
                                    <div class="col-sm-7">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                                            </div>
                                            <input type="text" name="discount_perclick" class="form-control offer_data_in number-valide-with-two-digit" maxlength="9" min="1" placeholder="Enter the amount of one single click" value="{{ $settings->details['discount_perclick'] ?? '' }}">
                                        </div>  
                                        <span class="error" style="display: none" id="error_discount_perclick">Error</span>
                                    </div>
                                </div>

                                {{-- Fixed Amount --}}
                                <div class="types-to-input  @if($settings->type != 'Fixed Amount') blank-inputs @endif form-group row" id="discount_amount" style="@if(!isset($settings->details['discount_amount']))display:none;@endif">
                                    <div class="col-sm-5 col-form-label">
                                         <label class="mb-1">Enter Discount Amount <span class="text-danger">*</span> </label>
                                         <p class="small text-secondary mb-1" style="line-height:1.6;">Set the fixed amount in rupees, you want to give to your customer as an offer.</p>   
                                    </div>
                                    <div class="col-sm-7">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                                            </div>
                                            <input type="text" name="discount_amount"  class="form-control offer_data_in number-valide-with-two-digit" maxlength="9" min="0" placeholder="Enter Amount above 0" value="{{ $settings->details['discount_amount'] ?? '' }}">
                                        </div>
                                        <span class="error" style="display: none" id="error_discount_amount">Error</span>
                                    </div>
                                </div>

                                {{-- Percentage Discount --}}
                                <div class="types-to-input  @if($settings->type != 'Percentage Discount') blank-inputs @endif form-group row" id="discount_percent" style="@if(!isset($settings->details['discount_percent']))display:none;@endif">
                                    <div class="col-sm-5 col-form-label">
                                        <label class="mb-1">Enter Discount Percentage <span class="text-danger">*</span> </label>
                                        <p class="small text-secondary mb-1" style="line-height:1.5;">Set the percentage of discount you want to give to your customer.</p>
                                    </div>
                                    <div class="col-sm-7">
                                        <div class="input-group">
                                            <input type="text" name="discount_percent" class="form-control offer_data_in number-validation" maxlength="3" min="0" max="100" placeholder="Enter Percentage between 1 to 100%" value="{{ $settings->details['discount_percent'] ?? '' }}">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-percent"></i></span>
                                            </div>
                                        </div>
                                        <span class="error" style="display: none" id="error_discount_percent">Error</span>
                                    </div>    
                                </div>

                                {{-- Gifts --}}
                                <div class="types-to-input  @if($settings->type != 'Gift') blank-inputs @endif form-group row" style="@if(!isset($settings->details['gift']))display:none;@endif" id="gift_name" >
                                    <div class="col-sm-5 col-form-label">
                                        <label for="gift_name" class="d-block">Add Gift Item <span class="text-danger">*</span></label>
                                        <p class="small text-secondary mb-1" style="line-height:1.6;">Enter the name of product and click Add to add the name(Max 5 names).</p>
                                    </div> 
                                    <div class="col-sm-7">
                                        <div class="input-group">
                                            <input type="hidden" name="gift" class="input_gift" value="{{ $settings->details['gift'] ?? '' }}">
                                            <input type="text" name="gift_name" class="form-control input_gift mb-2" placeholder="Enter Name...">
                                            <div class="input-group-append">
                                                <button class="input-group-text btn btn-primary add-gift text-white px-3" type="button"><i class="fa fa-plus mr-2"></i>Add</button>
                                            </div>
                                        </div>
                                        @php
                                            $gifts = array(); 
                                            if(isset($settings->details['gift']) && $settings->details['gift'] != ' '){
                                                $gifts = explode(',',$settings->details['gift']);
                                            }
                                        @endphp
                                        <ul class="badge gift_item d-flex flex-wrap px-0 mx-auto">
                                            @if(count($gifts) > 0)
                                                @foreach($gifts as $gift)
                                                <li class="delete-item outer_badge badge badge-warning d-flex justify-content-between align-items-center mb-2 mr-2"><span class="gift-name">{{ $gift }}</span><span class="badge badge-danger badge-pill delete_badge">X</span></li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>   
                                </div>

                                {{-- Free Reward --}}
                                <div class="types-to-input  @if($settings->type != 'Free') blank-inputs @endif form-group row" style="@if(!isset($settings->details['Free']) || $userBalance['wallet_balance'] > 0) display:none; @endif" id="free_row" >  
                                </div>

                                {{-- Other inputs --}}
                                <div class="form-group row" style="@if(!isset($settings->details['minimum_click'])) display:none; @endif" id="minimum_click">
                                    <div class="col-sm-5 col-form-label">
                                        <label>Minimum Unique clicks <span class="text-danger">*</span> </label> 
                                    </div>
                                    <div class="col-sm-7">
                                        <input type="text" name="minimum_click" min="1" class="form-control number-validation" placeholder="Enter number of minimum clicks require..." value="{{ $settings->details['minimum_click'] ?? '' }}">
                                        <span class="error" style="display: none" id="error_minimum_click">Error</span>
                                    </div>   
                                </div>

                                <div class="form-group row" style="@if(!isset($settings->details['maximum_click']))display:none;@endif" id="maximum_click" >
                                    <div  class="col-sm-5 col-form-label">
                                        <label>Maximum clicks(Visits) to be count! <span class="text-danger">*</span> </label>
                                    </div>
                                    <div class="col-sm-7">
                                        <input type="text" name="maximum_click" min="1" class="form-control number-validation" placeholder="Enter number of clicks to maximum limit..." value="{{ $settings->details['maximum_click'] ?? '' }}">
                                        <span class="error" style="display: none" id="error_maximum_click">Error</span>
                                    </div>  
                                </div> 

                            </div>

                        </div> {{-- Card Body END --}}
                        <div class="card-footer">
                            <div class="text-left">
                                {{-- submit Button --}}
                                <button type="submit" class="btn btn-success px-4">Save</button>
                            </div>
                        </div>
                    </div>
                </form>

                @if(auth()->user()->is_sales_person == 1 && auth()->user()->is_demo == 0)
                <form action="{{ route('business.sendShareChallenge') }}" method="POST" id="SendShareChallenge">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            Send Share Challenge
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <input type="text" name="mobile" value="" placeholder="Enter mobile number" class="form-control" required />
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">Send</button>
                        </div>
                    </div>
                </form>
                @endif
            </div>
            {{-- END Column --}}


            {{-- Column 2nd --}}
            <div class="col-lg-4 col-md-5 mb-3">
                {{-- Current (on going) offer  --}}
                @include('business.current-offer')

                {{--Auto send offer --}}
                <h2 class="section-title">Auto Share Settings</h2>
                <div class="card py-2 px-3">
                    <form method="post" action="{{ route('business.channel.autoShareSettings') }}" id="autoShareForm">
                        @csrf
                    <div class="set_hrs">

                        <div class="form-check pt-2 mb-2">
                            <input class="form-check-input" type="checkbox" id="share_to_subscribed_customers" name="share_to_subscribed_customers" @if($businessDetail->share_to_subscribed_customers) checked @endif>
                            <label class="form-check-label h6" for="share_to_subscribed_customers">
                            Share With Subscribers
                            </label>
                        </div>
                        
                        <p style="line-height: 1.5;" class="mb-0">Set the time duration at which you want the Share challenge to be automatically sent to the customers.</p>
                    </div>
                    <div class="d-flex flex-wrap mt-3 select_hours_" style="gap: 10px;">
                        
                        @forelse ($timings as $time)
                            <div class="auto_send_offer_button hours_tab">
                                <input type="radio" name="auto_share_timing_id" id="label{{ $time->id }}" value="{{ $time->id }}" @if($businessDetail->auto_share_timing_id == $time->id) checked @endif>
                                <label class="btn btn-default" for="label{{ $time->id }}">{{ $time->time_period }} Hours</label>
                            </div>    
                        @empty
                            <div>No records found</div>
                        @endforelse
                    </div>

                    <hr>

                    
                    {{--New Offer--}}
                    {{-- <div>
                        <div class="form-check pt-2">
                            <input class="form-check-input" type="checkbox" id="send_when_start" name="send_when_start" @if($businessDetail->send_when_start) checked @endif>
                            <label class="form-check-label h6" for="send_when_start">
                                New offer update
                            </label>
                        </div>
                        <p style="line-height: 1.5;" class="mb-0 mt-2">Tick the “New offer update” and select the groups in which you want your new offer to be automatically sent.</p>

                        <div class="form-group mt-3">
                            <label for="selectChoice" class="d-block" style="font-size: 16px;">Select Groups </label>
                            <select id="selectChoice" name="selected_groups[]" class="form-control choice-group" multiple="multiple">
                                @forelse ($groups as $group)
                                    <option value="{{ $group->id }}" @if(in_array($group->id, $businessDetail->selected_groups)) selected @endif>{{ $group->name }}</option>
                                @empty
                                    <option value="">Groups Not Found</option>
                                @endforelse
                            </select>
                        </div>
                    </div>

                    <hr> --}}

                    <button type="submit" class="btn btn-success">Update</button>

                </div>


                </form>
                

            </div>

        </div>    
    </div>
</section>
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
            
            // $("#minimum_click").hide();
            $("#maximum_click").hide();
            
            /* check which type selectd and then show their inputs */
            if(selected_type.val() === 'Cash Per Click'){
                $("#discount_perclick").show();
                $("#minimum_click").show();
                $("#maximum_click").show();
            }
            else if(selected_type.val() === 'Fixed Amount'){
                $("#discount_amount").show();
                $("#minimum_click").show();
            }
            else if(selected_type.val() === 'Percentage Discount'){
                $("#discount_percent").show();
                $("#minimum_click").show();
            }
            else if(selected_type.val() === 'Gift'){
                $("#gift_name").show();
                $("#minimum_click").show();
            }
            else if(selected_type.val() === 'No Reward'){
                $("#minimum_click").show();
            }else if(selected_type.val() === 'Free'){
                $("#maximum_click").hide();
                $("#minimum_click").hide();
                $("#discount_perclick").hide();
                $("#gift_name").hide();
                $("#discount_percent").hide();
                $("#discount_amount").hide();
                $("#free_row").show();
                $('input[name="minimum_click"]').val(1);
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

                    // console.log(gift_name.val());
                    if (gift_name.val()) {
                        if(count < 5){
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

            $(document).on("click", "#share_to_subscribed_customers", function(){
                if($("#share_to_subscribed_customers").prop('checked') == false){
                    $('input[name="auto_share_timing_id"]').prop('checked', false);
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

        $(document).ajaxSend(function() {
            $("#overlay").fadeIn(300);　
        });

        $("#shareAndRewardForm").on('submit', function(e){
            e.preventDefault();

            var isChannelActive = {{ $isChannelActive['status'] }}

            if(isChannelActive == 0){
                var msg = "{{Config::get('constants.share_challenge_status')}}"
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

            if(challenge_type=="Free"){
                $('input[name="minimum_click"]').val('1');
            }

            var minimum_click = $('input[name="minimum_click"]').val();
            
            if(challenge_type=="Cash Per Click"){
                var discount_perclick = $('input[name="discount_perclick"]').val(); 
                if(discount_perclick==""){
                    $("#error_discount_perclick").text("Please enter discount per click!");
                    $("#error_discount_perclick").show();
                    isError = true;
                }
                else if($.isNumeric(discount_perclick)==false){
                    $("#error_discount_perclick").text("Enter valid discount per click!");
                    $("#error_discount_perclick").show();
                    isError = true;
                }
                else if(discount_perclick <= 0){
                    $("#error_discount_perclick").text("Enter valid discount per click!");
                    $("#error_discount_perclick").show();
                    isError = true;
                }

                var maximum_click = $('input[name="maximum_click"]').val(); 
                if(maximum_click==""){
                    $("#error_maximum_click").text("Please enter maximum number of click!");
                    $("#error_maximum_click").show();
                    isError = true;
                }
                else if($.isNumeric(maximum_click)==false){
                    $("#error_maximum_click").text("Enter valid maximum number of click!");
                    $("#error_maximum_click").show();
                    isError = true;
                }
                else if(maximum_click <= 0){
                    $("#error_maximum_click").text("Enter valid maximum number of click!");
                    $("#error_maximum_click").show();
                    isError = true;
                }
            }
            else if(challenge_type=="Fixed Amount"){
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
            else if(challenge_type=="Gift"){

            }
            
            // console.log(minimum_click);
            if(minimum_click==""){
                $("#error_minimum_click").text("Please enter minimum number of click!");
                $("#error_minimum_click").show();
                isError = true;
            }
            else if($.isNumeric(minimum_click)==false){
                $("#error_minimum_click").text("Enter valid minimum number of click!");
                $("#error_minimum_click").show();
                isError = true;
            }
            else if(minimum_click <= 0){
                $("#error_minimum_click").text("Enter valid minimum number of click!");
                $("#error_minimum_click").show();
                isError = true;
            }
            
            if(isError==true){
                return false;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: this.action,
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData:false,
                success: function(response){ 
                    $("#overlay").fadeOut(300);

                    // Update header setting status
                    $('.refresh-settings-status').click();

                    // console.log(response);
                    if(response.status == true){
                        Sweet('success',response.message);
                        $("#has_reward_setting").val(1);
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
        });


        $("#autoShareForm").on('submit', function(e){
            e.preventDefault();

            var isChannelActive = {{ $isChannelActive['status'] }}

            if(isChannelActive == 0){
                var msg = "{{Config::get('constants.share_challenge_status')}}"
                Sweet("error", msg);
                return false;
            }

            /* If dont have running offer or not posted */
            var is_posted = {{ $planData['is_posted'] }};
            if(is_posted == 0){
                Sweet("error", "First Create and Post offer on Social Media.");
                return false;
            }

            var has_reward_setting = $("#has_reward_setting").val();
            if(has_reward_setting == 0){
                Sweet('error',"Please first update challenge settings in you left.");
                return false;
            }

            if($("#share_to_subscribed_customers").prop('checked') == true){
                var selectedHourse = $("input:radio[name='auto_share_timing_id']").is(":checked");
                if(selectedHourse==false){
                    Sweet('error', "Please select hours to share with subscriber");
                    return false;
                }
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: this.action,
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData:false,
                success: function(response){ 
                    $("#overlay").fadeOut(300);
                    
                    // Update header setting status
                    $('.refresh-settings-status').click();

                    // console.log(response);
                    if(response.status == true){
                        Sweet('success',response.message);
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
        });

        $("#SendShareChallenge").on('submit', function(e){
            e.preventDefault();

            var number = $('input[name="mobile"]').val();

            if (isNaN(number) || number == 0 || number == -1 || number == -0) {
                Sweet('error', `Please enter valid mobile number!`)
            }else{
                if (number.length != 10) {
                    Sweet('error', `Mobile number should be 10 digits!`)
                }
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: this.action,
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData:false,
                success: function(response){ 
                    $("#overlay").fadeOut(300);
                    //console.log(response);
                    if(response.status == true){
                        Sweet('success',response.message);
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
        });
        
    });
</script>
{{-- choice js --}}
<script src="{{ asset('assets/plugin/choices.js/scripts/choices.min.js') }}"></script>
 
<script>
    $(function(){
        var groups = new Choices('.choice-group', {
            removeItemButton: true,
            removeItems: true,
            position: 'bottom'
        })
    });
</script>
{{-- choice js end --}}
@include('business.channels.common-js')

@endsection