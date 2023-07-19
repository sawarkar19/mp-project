@extends('layouts.business')

@section('title', 'Personalised Messaging: Business Panel')

@section('head')
    @include('layouts.partials.headersection', ['title'=>'Personalised Messaging'])

    <link href="{{ asset('assets/css/jquery-ui.css') }}" rel="stylesheet" />
    
@endsection



@section('end_head')
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugin/quill/quill.snow.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugin/quill/quill.emoji.css')}}"> --}}

<link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css') }}" rel="stylesheet">
{{-- <link rel="stylesheet" href="{{ asset('assets/plugin/select2/css/select2.css') }}" rel="stylesheet"> --}}

<link rel="stylesheet" href="{{ asset('assets/plugin/choices.js/styles/choices.min.css') }}">

<style type="text/css">
    .lh-1{
        line-height: 1.5;
    }
    label span{
        color: red;
    }

    .btn-icon{
        min-width: 30px;
    }
    .message-box{
        height: 100%;
        margin-bottom: 0px!important;
    }
    .message-box .card-body,
    .message-box .card-footer{
        padding: 15px!important;
    }


    /* .radio_button{
        visibility: hidden;
        position: absolute;
        top: 0;
        left: 0;
    } */
    .options input:checked + .radio_label:before{
        visibility: visible;
    }
    .options input:checked + .radio_label:after{
        visibility: visible;
    } 
    .options input:checked + .radio_label .card{
        border: 2px solid #144DB1;
        /* background: #effaff; */
    }
    .options .card {
        /* background: #f5f5f7; */
        margin-bottom: 0;
        /* border-radius: 10px 10px 10px 0px; */
        border: 2px solid #f8f8f8;
    }
    .card_style{
        padding: 12px;
    }
    .card_style h6{
        font-size: 14px;
        margin-bottom: 6px;
    }
    .card_style p{
        font-size: 12px;
        line-height: 16px;
    }



    .form-group textarea {
        height: auto !important; 
        width: 100% !important;
    }
        
    .select2-container--default .select2-selection--multiple .select2-selection__choice{
        color: #434d4a;
    }
    .card-message-selection{
        pointer-events:none;
    }
    .card-message-hedding{
        pointer-events:none;
        color: #412272;
    }
        

    /* Add message box design */
    .add-message-box{
        height: 100%;
        min-height: auto;
        cursor: pointer;
    }
    .amb-inner{
        position: relative;
        padding: 15px;
        width: 100%;
        height: 100%;
        border: 1px dashed var(--secondary);
        border-radius: 3px;
        text-align: center;
        transition: all 300ms ease;
    }
    .amb-inner .amb-body{
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .amb-inner .title{
        transition: all 300ms ease;
        color: var(--dark);
    }
    .add-message-box:hover .amb-inner{
        border: 1px dashed var(--primary);
    }
    .add-message-box:hover .amb-inner .title{
        color: var(--primary);
    }
    
    .tempSec_Bg {
        background: #f9f9f9;
        padding: 25px;
        border-top-left-radius: 0.3rem;
        border-top-right-radius: 0.3rem;
    }
    /* .add-pr-msg .modal-body{
        padding: 15px;
        padding-top: 0px;
    } */
    .search::before {
        content: "\f002";
        position: absolute;
        right: 1.5rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--color-thm-lth);
        z-index: 99;
        display: inline-block;
        font-family: "Font Awesome 5 Free";
        font-style: normal;
        font-weight: 400!important;
        font-variant: normal;
        text-transform: none;
        line-height: 1;
        vertical-align: -0.125em;
        -webkit-font-smoothing: antialiased;
    }
    .scroll_temp{
        max-height: 400px;
        overflow-y: scroll;
        overflow-x: hidden;
        /* margin-bottom: 20px; */
    }
    .modal_fullwidth{
        width: 100%;
        max-width: 1024px;
    }

    .grid {
        display: flex;
        flex-wrap: wrap;
    }
       .grid-col {
        flex: 1;
        padding: 0 0.1em;
    }
    .grid-col--2, .grid-col--3 {
    display: none;
    }
    /* new popups */
    .birthday-images-section{
        background-image: url({{ asset('assets/business/pop-up-images/personalised-message/background-img.png')}});
        background-repeat: no-repeat;
        background-size: 100% 100%;
    }
    .anni-images-section{
        background: #F6E9CA;
        border-radius: 0.3rem 0 0 0.3rem;
    }
   
    .text-color{
        color: #412272;
    }
    .options{
        position: relative;
    }
    .radio_button{
        visibility: hidden;
        position: absolute;
        top: 14px;
        right: 6px;
        z-index: 10;
    }
    .radio_button[type="radio"]:checked + label:before,
    .radio_button[type="radio"]:not(:checked) + label:before {
        content: '';
        border: 1px solid #ddd;
        width: 15px;
        height: 15px;
        border-radius: 50%;
        position: absolute;
        top: 12px;
        right: 6px;
        z-index: 10;
    }
    .radio_button[type="radio"]:checked + label:after,
    .radio_button[type="radio"]:not(:checked) + label:after {
        border: 1px solid #fff;
        border-top: 0;
        border-left: 0;
        content: "";
        display: block;
        height: 6px;
        position: absolute;
        top: 18px;
        right: 12px;
        transform: rotate(45deg) translate(-50%, -50%);
        width: 4px;
    }
   
    .radio_button[type="radio"]:not(:checked) + label:after {
        opacity: 0;
    }
    .radio_button[type="radio"]:checked + label:before{
        background: #144DB1;
    }
    .radio_button[type="radio"]:checked + label:after {
        opacity: 1;
        z-index: 11;
    }
    .date-time .form-group{
        max-width: 350px;
        padding: 0.5rem 0;
    }
    .tab-select ul.nav.nav-tabs{
        border-bottom: 2px solid #ebebeb;
    }
    .tab-select .nav-tabs .nav-link.active{
        border-bottom: 2px solid #412272;
        color: #412272;
        font-weight: 500;
        background: transparent;
    }
    .tab-select .nav-tabs .nav-link {
        border: 2px solid transparent;
        border-top-left-radius: 0rem;
        border-top-right-radius: 0rem;
        color: #777777;
    }
    .anni-card{
        position: relative;
    }
    
    .anniversary-msg .modal-body{
        padding: 0px 15px !important;
    }
      
    .personalised-inner-image{
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
    }
    .personalised-design-img{
        position: absolute;
        top: 0;
        left:-1px;
    }
    .birthday-design {
        max-width: 200px;
    }
    .birthday-inner{
         max-width: 160px;
    }
    .anni-card-img{
        max-width: 120px;
    }
    .anni-flower{
        max-width: 100px;
    }
    .birthday-msg button.close, .anniversary-msg button.close, .add-pr-msg button.close{   
        color: #164287;
        opacity: 0.8;
        font-size: 1.2rem;
        position: absolute;
        right:0;
        top: 0;
        z-index: 10;
    }
    .tab-select .nav-link{
        padding: 0.5rem 0rem;
    }
    @media (min-width: 768px) {  
        .grid-col {
            padding: 0 0.5em;
        }
        .grid-col--2 {
            display: block;
        }
        .birthday-msg .modal-dialog.modal-lg, .anniversary-msg .modal-dialog.modal-lg{
            max-width: 700px;
        }
        .tab-select .nav-tabs li {
            margin: 0 20px;
        }
        .tab-select .nav-tabs li:first-child{
            margin: 0 20px 0 0;
        }
    }
    @media(max-width:768px){
        .personalised-design-img{
            width: 130px;
        }
        .tab-select .nav-tabs li{
            width: 40%;
        }
        .add-message-img-inner img{
            max-width: 100px;
        }
        .personalised-inner-image{
            position: relative;
            max-width: 117px;
            top: 25px;
            left: 50%;
            transform: translateX(-50%);
        }  
        .anni-card-img{
            max-width: 66px;
            padding-bottom: 20px;
        }
        .anni-flower{
            width:91px;
        } 
        .add-pr-msg button.close{
            line-height: 1.3;
        }
        .greetOfferImage {
            display: none;
        }
    }
     /* new popups end*/
    /**--grid-list view css-**/
    .message-box .innerBox{
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
    }
    .message-box .innerBox .greet-title-msg .greetTitle.marBtm-3{
        margin-bottom: 1rem;
    }
    .message-box .innerBox .greet-title-msg {
        display: flex;
        flex-direction: column;
    }
    .message-box .innerBox .greet-title-msg .greetTitle h6 {
        white-space: nowrap;
        overflow-x: clip;
        text-overflow: ellipsis;
        align-items: center;
        max-width: 500px;
        overflow: hidden;
    }
    .message-box .innerBox .greetActions-icons{
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .addmsg-mar{
        margin-bottom: 1.5rem;
    }
    button.btn-cls-outline{
        padding: 0rem;
        outline: none!important;
    }
    button.btn-cls-outline:focus{
        padding: 0rem;
        margin-top: 3px;
    }
    .form-control[readonly] {
        background-color: #fdfdff;
        opacity: 1;
    }
    .tempSec_Bg .choices__list--dropdown .choices__item--selectable
    {
        padding-right: 4px;
    }
    .tempSec_Bg .choices__list--dropdown .choices__item--selectable:after
    {
        display: none;
    }

    /* view message details Modal start */
    .message-view-modal .modal-header .close-button{
        outline: transparent;
    }
    /* .message-view-modal .modal-header{
        padding-top: 8px;
    } */
    .msg-title-color{
        color: #626262;
    }
    .view-msg-contact-table{
        font-weight: 500 !important;
        height: 40px !important;
    }
     /* view message details Modal end */
    @media (min-width: 575px){
        .list{
            display: block;
        }
        .list .colWidthfull{
        max-width: 100%;  
        }
        .list .addmsg-mar{
            margin-bottom: 0px;
        }
        .list .message-box .innerBox{
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            height: 100%;
        }
        .list .message-box .innerBox .greet-title-msg{
            display: flex;
            flex-direction: row;
            flex: auto;
            align-items: center;
        } 
        .list .message-box .innerBox .greet-title-msg .greetTitle{
            max-width: 400px;
            width: 30%;
        }
        .list .message-box .innerBox .greet-title-msg .greetTitle h6 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            white-space: pre-wrap;
        }
        .list .message-box .innerBox .greet-title-msg .greetTitle.marBtm-3 {
            margin-bottom: 0px;
        }
        .list .message-box .innerBox .marRight{
            margin-right: 10px;
        }
    }
    @media(max-width:575px){
        .greetOfferImage {
            display: none;
        }
    }
    /**--end grid-list view css-**/

    /**--ipad save cancel btn--**/
    /* @media (max-width: 991px){
        .pers-msg-btn{
            font-size: 10px;
            padding: 0px 8px;
        }
    } */

    .message-type-tag{
        background: linear-gradient(135deg, rgb(0,255,175, 1) -50%, rgba(0,36,156, 1));
        color: #fff;
        padding: 5px;
        font-size: 10px;
        font-weight: 600;
        border-radius: 0px 33px 33px 0;
        letter-spacing: 1.5px;
    }

    .greetOfferImage img{
        max-width: 230px;
        border-radius: 6px;
    }

    @media (min-width: 768px) and  (max-width: 991px){
        .add-pr-msg .modal-dialog{
            max-width: 700px;
        }
    }

    /* share offer */
     .grid .greetOfferImage{
        display: none;
    }

    .greetOfferImage{
        position: relative;
        width: 30%;
        height: 100%;
    }
    .greetOfferImage .greet-img{
        max-width: 290px;
        height: 230px;
        display: block;
        position: relative;
        background-color: #f2f2f2;
        background-position: top center;
        background-size: cover;
        transition: all 800ms ease;
        border-radius: 4px 0 0 4px;
    }
    .greetOfferImage .greet-img:hover{
        background-position: bottom center;
    }
    .greet-title-msg__shareOffer{
        max-width: 600px;
    }
    /* share offer end*/
</style>
@endsection

@section('content')
<section class="section">
    <div class="section-body">

        <div class="mb-4 row justify-content-between align-items-center">
            <div class="col-4 order-2">
                @if(isset($routes) && !empty($routes))
                    @include('business.channels.routes-toggle')
                @endif
            </div>
            
            <div class="col-8 order-1">
                <a href="{{ route('business.channel.personalisedMessage.viewHistory') }}" class="btn btn-primary">{{ __("View Message History") }}</a>
            </div>
        </div>

        <div class="text-right mb-5">
            <!-- <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button" class="btn @if(isset($_COOKIE['listing_view']) && $_COOKIE['listing_view'] === 'list') btn-primary @else btn-light @endif" title="List View" data-toggle="tooltip" id="switch-list-style"><i class="fa fa-list"></i></button> -->
                <!-- else me primary -->
                <!-- <button type="button" class="btn @if (isset($_COOKIE['listing_view'])) @if($_COOKIE['listing_view'] === 'grid') btn-primary @else btn-light @endif @else btn-primary @endif" title="Grid View" data-toggle="tooltip" id="switch-grid-style"><i class="fa fa-th-large"></i></button> -->
                <!-- else me light -->
            <!-- </div> -->

            <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button" class="btn 
                @if(isset($_COOKIE['listing_view']))
                    @if($_COOKIE['listing_view'] === 'list') btn-primary 
                    @else btn-light 
                    @endif 
                @else btn-primary 
                @endif" title="List View" data-toggle="tooltip" id="switch-list-style"><i class="fa fa-list"></i></button>
                <!-- else me primary -->
                <button type="button" class="btn 
                @if(isset($_COOKIE['listing_view'])) 
                    @if($_COOKIE['listing_view'] === 'grid') btn-primary 
                    @else btn-light 
                    @endif 
                @else btn-light 
                @endif" title="Grid View" data-toggle="tooltip" id="switch-grid-style"><i class="fa fa-th-large"></i></button>
                <!-- else me light -->
            </div>
        </div>

        <div class="row @if(isset($_COOKIE['listing_view'])) {{$_COOKIE['listing_view']}} @else list @endif" id="gridListSwitch">
            @php
                $grid = true;
                
                if ($grid) {
                    $columns = 'col-xl-4 col-sm-6';
                    $view_type = 'grid';
                }else{
                    $columns = 'col-12';
                    $view_type = 'list';
                }
            @endphp

            {{-- Add Message Card --}}

            <div class="{{$columns}} @if($planData['userData']->current_account_status == 'free') __pro__ card bg-transparent border-0 @endif colWidthfull mb-4 " >
                <div class="add-message-box" onclick="viewModal('1')">
                    <div class="amb-inner">
                        <div class="amb-body">
                            <h6 class="title "><i class="fas fa-plus" style="font-size: inherit;"></i><br>Add Message</h6>
                            <p class="text text-secondary mb-0">Click here to add message of festival greetings, offers, and more...</p>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Current Offer --}}
            @php
                $title="Current Offer";
                $description="Current Offer Description";
                $current_offer_id='0';
                $offer_start_date="";
                $offer_end_date="";
                $offerImg= asset('assets/img/default_website_img.jpg');
                if($planData['current_offer']!=NULL){
                     $title=$planData['current_offer']->title;
                    $description=$planData['current_offer']->description;
                    $current_offer_id=$planData['current_offer']->id;
                    $offer_start_date=Carbon\Carbon::parse($planData['current_offer']->start_date)->format('d M, Y');
                    $offer_end_date=Carbon\Carbon::parse($planData['current_offer']->end_date)->format('d M, Y');
                    if($planData['current_offer']->type == 'custom'){
                        if($planData['current_offer']->website_url != ''){
                            if($planData['current_offer']->website_meta_image != ''){
                            $offerImg= $planData['current_offer']->website_meta_image;
                            }else{
                                $offerImg = asset('assets/img/default_website_img.jpg');
                            }
                        }else{
                            $offerImg = asset('assets/templates/custom').'/'.$planData['current_offer']->image;
                        }
                    }else{
                        $offerImg = asset('assets/offer-thumbnails').'/'.$planData['current_offer']->offer_template->thumbnail;
                    }

                }
            @endphp
            <div class="{{$columns}} colWidthfull mb-4" id="current_offer_card">

                <div class="message-box card">
                    <div><span class="mb-3 message-type-tag">Share New Offers</span></div>
                    <span></span>
                    <div class="card-body">
                        <div class="innerBox">
                            <div class="greet-title-msg">
                                <div class="greetOfferImage mr-2">
                                    <a href="#" class="greet-img hover-to-cal" style="background-image: url({{$offerImg}});"></a>
                                </div>
                                <div class="greetMessage greet-title-msg__shareOffer">
                                    <div class="greetTitleOffer marBtm-3">
                                        <h6 class="" style="color: var(--purple)">{{$title}}</h6>
                                    </div>
                                    <p class="lh-1" id="activeBirthdayMsg">{!! nl2br($description) !!} </p>
                                    <p class="lh-1" id="activeBirthdayMsg"><i class="far fa-calendar-check text-warning mr-1" data-toggle="tooltip" title="Start Date"></i>Start Date : {!! $offer_start_date !!} </p>
                                    <p class="lh-1" id="activeBirthdayMsg"><i class="far fa-calendar-check text-warning mr-1" data-toggle="tooltip" title="End Date"></i>End Date : {!! $offer_end_date !!} </p>
                                    <div class="greetDate">
                                        <p class="mb-0 font-weight-500" style="color: #7b848c;">
                                            <i class="far fa-clock text-warning mr-1" data-toggle="tooltip" title="Scheduled On"></i>
                                        Challenge will be shared on the offer start date at 10 AM
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="greetActions greetActions-icons">
                                @if($current_offer_id!='0')
                                <div class="">
                                    <button class="btn btn-icon btn-sm btn-outline-dark marRight" onclick="editModal({{ $current_offer_id }})" data-toggle="tooltip" title="Edit Share"><i class="fas fa-pen"></i></button>
                                </div>
                                @endif
                                <div class="">
                                    <div class="form-group mb-0">
                                        <div class="custom-switches-stacked float-right refresh-settings-status" data-toggle="tooltip" title="Message On/Off">
                                            <label class="custom-switch pl-0 mb-0">
                                                <input type="checkbox" data-toggle="toggle" name="send_when_start" value="1" class="custom-switch-input setSelectedGroups " @if($busnessDetails->send_when_start=='1') checked @endif >
                                                <span class="custom-switch-indicator"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Birthday Card New--}}
            <div class="{{$columns}} colWidthfull mb-4" id="birthday_card">

                <div class="message-box card">
                    <div><span class="mb-3 message-type-tag">Birthday</span></div>
                    <span></span>
                    <div class="card-body">
                        <div class="innerBox">
                            <div class="greet-title-msg">
                                <div class="greetTitle marBtm-3">
                                    <h6 class="mb-0" style="color: var(--purple)">Birthday Greeting</h6>
                                </div>
                                <div class="greetMessage">
                                    @php
                                        $busniess_name = $busnessDetails->business_name;
                                        $busniess_name = $busniess_name ?? 'owner';
                                       
                                        if(strlen($busniess_name) > 28){
                                            $busniess_name = substr($busniess_name,0,28).'..';
                                        }
                                        $dob_message = $dobTemp->template->message;
                                        $dob_message = str_replace("[business_name]", $busniess_name, $dob_message);
                                        $dob_message = str_replace("{#var#}", $busniess_name, $dob_message);
                                    @endphp
                                    <p class="lh-1" id="activeBirthdayMsg">{!! nl2br($dob_message) !!} </p>
                                </div>
                            </div>
                            <div class="greetActions greetActions-icons">
                                <div class="">
                                    <button class="btn btn-icon btn-sm btn-outline-dark marRight" onclick="viewModal('7')" data-toggle="tooltip" title="Edit Message"><i class="fas fa-pen"></i></button>
                                </div>
                                <div class="">
                                    <div class="form-group mb-0">
                                        <div class="custom-switches-stacked float-right refresh-settings-status" data-toggle="tooltip" title="Message On/Off">
                                            <label class="custom-switch pl-0 mb-0">
                                                <input type="checkbox" data-toggle="toggle" name="schedule_dob" value="1" data-scheduleType="{{ encrypt(7) }}" class="custom-switch-input setIsSchedule" @if($dobTemp->is_scheduled) checked @endif >
                                                <span class="custom-switch-indicator"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>


            {{-- Annivercery Card --}}
            <div class="{{$columns}} colWidthfull mb-4" id="anniversary_card">
                <div class="message-box card">
                    <div><span class="mb-3 message-type-tag">Anniversary</span></div>
                    <span></span>
                    <div class="card-body">
                        <div class="innerBox">
                            <div class="greet-title-msg">
                                <div class="greetTitle marBtm-3">
                                    <h6 class="mb-0" style="color: var(--purple)">Anniversary Greeting</h6>
                                </div>
                                <div class="greetMessage">
                                    @php
                                        $anni_message = $anniTemp->template->message;
                                        $anni_message = str_replace("[business_name]", $busniess_name, $anni_message);
                                        $anni_message = str_replace("{#var#}", $busniess_name, $anni_message);
                                    @endphp
                                    <p class="lh-1" id="activeAnniMsg">{!! nl2br($anni_message) !!}</p>
                                </div>
                            </div>
                            <div class="greetActions greetActions-icons">
                                <div class="">
                                    <button class="btn btn-icon btn-sm btn-outline-dark marRight" onclick="viewModal('8')" data-toggle="tooltip" title="Edit Message"><i class="fas fa-pen"></i></button>
                                </div>
                                <div class="">
                                    <div class="form-group mb-0">
                                        <div class="custom-switches-stacked float-right refresh-settings-status" data-toggle="tooltip" title="Message On/Off">
                                            <label class="custom-switch pl-0 mb-0">
                                                <input type="checkbox" data-toggle="toggle" name="schedule_ani" value="1" data-scheduleType="{{ encrypt(8) }}" class="custom-switch-input setIsSchedule" @if($anniTemp->is_scheduled) checked @endif >
                                                <span class="custom-switch-indicator"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            
                        </div>
                    </div>
                   
                </div>
            </div>

            {{--  Dynamic Festival list --}}
            
            @if (count($festivalTemp) > 0)
            @php $i=1; $festivals=0; @endphp
            
                {{-- /* Looping through the array and printing the same card for each item in the array. */ --}}
                
                @foreach($festivalTemp as $festivals)
                
                <div class="{{$columns}} colWidthfull mb-4" id="newPersonaliseMsg{{ $festivals->id }}">

                    <div class="message-box card" id="personaliseMsg{{ $festivals->id }}">
                        <div><span class="mb-3 message-type-tag">Festival</span></div>
                        <div class="card-body">
                            <div class="innerBox">
                                <div class="greet-title-msg">
                                    <div class="greetTitle marBtm-3">
                                        <h6 class="text-warning mb-0">{{ $festivals->template->category->name }}</h6>
                                    </div>
                                    <div class="greetMessage">
                                        @php
                                        
                                            $festival_message = $festivals->template->message;
                                            $festival_message = str_replace("[business_name]", $busniess_name, $festival_message);
                                            $festival_message = str_replace("{#var#}", $busniess_name, $festival_message);
                                        @endphp
                                        <p class="lh-1 mb-0">{!! nl2br($festival_message) !!}</p>
                                        <div class="greetDate">
                                            <p class="mb-0 font-weight-500" style="color: #7b848c;">
                                                <i class="far fa-calendar-check text-warning mr-1" data-toggle="tooltip" title="Scheduled On"></i> 
                                                {{ Carbon\Carbon::parse($festivals->scheduled)->format('d M, Y') }} 
                                                @if($festivals->getTimeSlot!=NULL)
                                                    | {{ Carbon\Carbon::parse($festivals->getTimeSlot->value)->format('h:i A') }}
                                                @endif    
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                

                                <div class="greetActions greetActions-icons mt-2">
                                     @php
                                        $todayDate1 = Carbon\Carbon::now();
                                        $todayDate = Carbon\Carbon::parse($todayDate1)->format('Y-m-d');
                                        $todayDatetime = Carbon\Carbon::parse($todayDate1)->format('Y-m-d H:i:s');

                                        $scheduleDate = Carbon\Carbon::parse($festivals->scheduled)->format('Y-m-d');
                                        $scheduleDatetime = Carbon\Carbon::parse($festivals->scheduled)->format('Y-m-d H:i:s');
                                    @endphp
                                        <button class="btn btn-icon btn-sm btn-outline-dark marRight editFestivalTemplate" data-edit_temp_id_fest="{{ $festivals->id }}" data-edit_catg_id_fest = "{{ $festivals->message_template_category_id }}" data-toggle="tooltip" title="Edit Message"><i class="fas fa-pen"></i></button>

                                        <div class="custom-switches-stacked float-right" data-toggle="tooltip" title="Message On/Off">
                                            <label class="custom-switch pl-0 mb-0">
                                                <input type="checkbox" data-toggle="toggle" name="schedule_fest_date" value="1" data-scheduleType="{{  encrypt($festivals->message_template_category_id) }}" class="custom-switch-input setIsSchedule" @if($festivals->is_scheduled) checked @endif>
                                                <span class="custom-switch-indicator"></span>
                                            </label>
                                        </div>                                   
                                </div>
                                
                            </div>
                        </div>
                        
                    </div>
                </div>

                @endforeach
            @endif 
    


            {{-- Customise / Dynamic message list --}}
            @if (count($personalisedTemp) > 0)
            @php $i=1; @endphp
            
                {{-- /* Looping through the array and printing the same card for each item in the array. */ --}}
                @foreach($personalisedTemp as $temp)
                
                <div class="{{$columns}} colWidthfull mb-4" id="newPersonaliseMsg{{ $temp->id }}">

                    <div class="message-box card" id="personaliseMsg{{ $temp->id }}">
                        <div><span class="mb-3 message-type-tag">Custom</span></div>
                        <div class="card-body">
                            <div class="innerBox">
                                <div class="greet-title-msg">
                                    <div class="greetTitle marBtm-3">
                                        <h6 class="text-warning mb-0">{{ $temp->template->category->name }}</h6>
                                    </div>
                                    <div class="greetMessage">
                                        @php
                                            $other_message = $temp->template->message;
                                            $other_message = str_replace("[business_name]", $busniess_name, $other_message);
                                            $other_message = str_replace("{#var#}", $busniess_name, $other_message);
                                        @endphp
                                        <p class="lh-1 mb-0">{!! nl2br($other_message) !!}</p>
                                        <div class="greetDate">
                                            <p class="mb-0 font-weight-500" style="color: #7b848c;">
                                                <i class="far fa-calendar-check text-warning mr-1" data-toggle="tooltip" title="Scheduled On"></i> 
                                                {{ Carbon\Carbon::parse($temp->scheduled)->format('d M, Y') }} 
                                                @if($temp->getTimeSlot!=NULL)
                                                    | {{ Carbon\Carbon::parse($temp->getTimeSlot->value)->format('h:i A') }}
                                                @endif    
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                

                                <div class="greetActions greetActions-icons mt-2">
                                     @php
                                        $todayDate1 = Carbon\Carbon::now();
                                        $todayDate = Carbon\Carbon::parse($todayDate1)->format('Y-m-d');
                                        $todayDatetime = Carbon\Carbon::parse($todayDate1)->format('Y-m-d H:i:s');

                                        $scheduleDate = Carbon\Carbon::parse($temp->scheduled)->format('Y-m-d');
                                        $scheduleDatetime = Carbon\Carbon::parse($temp->scheduled)->format('Y-m-d H:i:s');
                                    @endphp
                                        @if($todayDate < $scheduleDate)
                                            <button class="btn btn-icon btn-sm btn-outline-dark marRight editScheduleTemplate" data-edit_temp_id="{{ $temp->id }}" data-toggle="tooltip" title="Edit Message"><i class="fas fa-pen"></i></button>

                                            <button class="btn btn-icon btn-sm btn-outline-danger" onclick="cancelRow('{{ $temp->id }}');return false;" data-toggle="tooltip" title="Cancel Message"><i class="fas fa-ban"></i></button>
                                        @else
                                            <div class="text-primary">
                                                {{-- view button --}}
                                                <button type="button" data-temp_id="{{ $temp->id }}" class="btn btn-icon btn-sm btn-outline-primary view-message"><i class="fa fa-eye"></i></button>
                                                {{-- view button end --}}
                                                
                                                <i class="fas fa-spinner fa-spin"></i> Will process today...
                                            </div>
                                        @endif                                   
                                </div>
                                
                            </div>
                        </div>
                        
                    </div>
                </div>
                @endforeach
            @endif

 

           
        </div>

    </div>  
</section>
<!--view message details Modal start-->
<div class="modal fade" id="message-view-modal" tabindex="-1" role="dialog" aria-labelledby="message-view-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content message-view-modal">
            <div class="modal-header">
            <h5 class="modal-title text-primary" id="message-view-modal-title">Message Details</h5>
            <button type="button" class="close close-button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="my-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="">
                            <h6 class="mb-0 msg-title-color">Message</h6>
                        </div>
                        <div class="greetDate">
                            <p class="mb-0 font-weight-500">
                                <i class="far fa-calendar-check text-warning mr-1" data-toggle="tooltip" title="Scheduled On"></i> 
                                <span id="view-datetime"></span>
                                {{-- {{ Carbon\Carbon::parse($temp->scheduled)->format('d M, Y') }} 
                                @if($temp->getTimeSlot!=NULL)
                                    | {{ Carbon\Carbon::parse($temp->getTimeSlot->value)->format('h:i A') }}
                                @endif     --}}
                            </p>
                        </div>
                    </div>
                    <div class="greetTitle">
                        <p class="mb-0 text-warning" id="view-category_name">
                            {{-- {{ $temp->template->category->name }} --}}
                        </p>
                    </div>
                    <div class="greetMessage">
                        {{-- @php
                            $other_message = $temp->template->message;
                            $other_message = str_replace("[business_name]", $busniess_name, $other_message);
                            $other_message = str_replace("{#var#}", $busniess_name, $other_message);
                        @endphp --}}
                        <p class="lh-1 mb-0" id="view-message_text">
                            {{-- {!! nl2br($other_message) !!} --}}
                        </p>
                    </div> 
                </div>
                <hr>
                <div>
                    <h6 class="mb-3 msg-title-color">Contact Groups</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                  <th class="view-msg-contact-table">Contact Group Title</th>
                                  <th class="view-msg-contact-table">Customers Count</th>
                                </tr>
                            </thead>      
                            <tbody id="view-contact_info">
                                {{-- <tr>
                                    <td class="">Messaging API</td>
                                    <td class=""><span class="badge badge-primary">2</span></td>
                                </tr> --}}
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
 </div>
<!--view message details Modal end-->

    <input type="hidden" name="other_message_id" value="" id="other_message_id">
    <input type="hidden" name="channel_id" value="5" id="channel_id">
    <input type="hidden" name="template_id" value="" id="template_id">
    <input type="hidden" name="template_id_fest" value="" id="template_id_fest">
    <input type="hidden" name="dob_message_id" value="{{ $dobTemp->id }}" id="dob_message_id">
    <input type="hidden" name="anni_message_id" value="{{ $anniTemp->id }}" id="anni_message_id">
    <input type="hidden" name="fest_message_id" value="" id="fest_message_id">

    @include('business.personalised-messages.modals')

@endsection

@section('end_body')

    <script src="{{ asset('assets/plugin/choices.js/scripts/choices.min.js') }}"></script>
    <script>
    $(function() {
        var groups = new Choices('.choice-group', {
            removeItemButton: true,
            removeItems: true,
            position: 'bottom'
        });

        var groups = new Choices('.choise-groups', {
            allowHTML: true,
            shouldSort: false,
            searchEnabled: true,
            searchChoices: true,
            removeItemButton: true,
            position: 'bottom',
            prependValue: null
        }).setChoices(
            @json($groups_array),
            'value',
            'label',
            false
        );
        var timeslot = new Choices('.choices-time', {
            allowHTML: true,
            shouldSort: false,
            searchPlaceholderValue: 'Search time slot...',
            position: 'bottom',
        }).setChoices(
            @json($slots_array),
            'value',
            'label',
            false
        );

        
        var timeslotFestival = new Choices('.choices-time-festival', {
            allowHTML: true,
            shouldSort: false,
            searchPlaceholderValue: 'Search time slot...',
            position: 'bottom',
        }).setChoices(
            @json($slots_array),
            'value',
            'label',
            false
        );

        var groupsFestival = new Choices('.choise-groups-festival', {
            allowHTML: true,
            shouldSort: false,
            searchEnabled: true,
            searchChoices: true,
            removeItemButton: true,
            position: 'bottom',
            prependValue: null
        }).setChoices(
            @json($groups_array),
            'value',
            'label',
            false
        );

        $("#personalisedDate").change(function(e){
            var selectDate = $(this).val();
            $.ajax({
                url: '{{ route("business.personalisedMessage.setTimeStamp") }}',
                type:"POST",
                dataType: "JSON",
                data:{
                    "selectDate": selectDate,
                    "_token": "{{ csrf_token() }}"
                },
                beforeSend: function() {
                    $("#overlay").fadeIn(300);
                },
                success:function(response){
                    if(response.status==true){
                        timeslot.clearChoices();
                        timeslot.setChoices(response.data, 'value', 'label', false);
                    }
                    $("#overlay").fadeOut(300);
                }
            })
        });

        $(".closeModalTemp").click(function(e){
            groups.removeActiveItems();
            groups.setChoices(defaults(), 'value', 'label', false);

            groupsFestival.removeActiveItems();
            groupsFestival.setChoices(defaults(), 'value', 'label', false);
        })

        function defaults() {
            return @json($groups_array).map((lbl, i) => ({value: 'value', label: 'label'}));
        }

        let editDates = [];
        $(".editScheduleTemplate").click(function(e){

            var id = $(this).attr("data-edit_temp_id");
            var cat_id = $(this).attr("data-edit_catg_id");
           
            $("#personalisedDate").attr("data-edit_temp_id", id);
            
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var modalId, cardId, channel_id, temp_id, date, time, groups1, message;
            temp_id = $('#template_id').val();
            
            $('#personalisedDate').val('');
            $('#personalisedTime').val('');
            $('#myGroups').val('');
            $('#other_message_id').val(id);
            
            var inputVal = { "id" : id, "cat_id" : cat_id, "_token" : CSRF_TOKEN };
            $.ajax({
                url : '{{ route('business.channel.personalisedMessage.editTemplate') }}',
                type : 'POST',
                dataType : "json",
                data : inputVal,
                success : function(res) {
                    // console.log('res: ', res.record);
                    console.log('res: ', res.record.selectedGroupsInfo);
                    if(res.status == true){

                        // Set Time Choice
                        timeslot.clearChoices();
                        timeslot.setChoices(res.record.slots_array, 'value', 'label', false);

                        // groups.clearChoices();
                        // Working code
                        // groups.setValue(res.record.selectedGroupsInfo.map((v) => ({value: v.id, label: v.name})));
                        // groups.choice();
                        
                        console.log(res.record.selectedGroupsInfo);
                        groups.clearChoices();
                        groups.setChoices(res.record.selectedGroupsInfo, 'value', 'label', false);

                        // Set Dates
                        editDates = res.record.usedDates;

                        // Custom MSG
                        modalId = "personalisedMessages";

                        $("#personalisedDate").val(res.record.date);
                        // $("#personalisedTime").val(res.record.time_slot_id).change();
                        $("#personalisedTime option[value='1']").attr("selected", true);
                        // $("#myGroups").val(res.record.groups);   

                        $('.'+modalId+' .grid-item').remove();
                        var instance = new Colcade('.'+modalId,{
                            columns: '.grid-col',
                            items: '.grid-item'
                        });

                        instance.destroy();
                        var data_col = "";
                        var templates = res.record.templates;

                        var busniess_name = '{{ $busniess_name }}';
                        $.each(templates, function(i, elm) {
                            var name = elm.category.name;
                            message = nl2br(elm.message);
                            
                            var isChecked = "";
                            if(elm.id == res.record.template_id){
                                isChecked = "checked";
                                $("#checkTemplateCategory").val(elm.message_template_category_id);
                                $("#checkTemplateID").val(res.record.template_id);
                            }

                            message = message.replaceAll('{#var#}', busniess_name);

                            data_col = '<div class="options card-msg-option chooseTemplate" data-templatecategory_id="'+elm.message_template_category_id+'" data-template_id="'+elm.id+'"><input type="radio" '+isChecked+' name="bdaytemp"  id="temp_'+elm.id+'" value="'+elm.id+'" class="radio_button"><label class="radio_label mb-2 d-block" for=temp_'+elm.id+'"><div class="card"><div class="card_style"><h6 class="card-message-hedding">'+name+'</h6><p class="mb-0 card-message-selection">“'+message+'”</p></div></div></label></div>';

                            instance.append([
                                makeItem(data_col, 'message_template_category_'+res.record.message_template_category_id)
                            ]);
                        });
                        $('#temp_'+res.template_id).prop("checked", true);
                        $('#'+modalId).modal('toggle');
                        // console.log(modalId);
                    }
                }
            });
        });
// Edit Festival function start


        let editDates1 = [];
        $(".editFestivalTemplate").click(function(e){
            var id = $(this).attr("data-edit_temp_id_fest");
            var cat_id = $(this).attr("data-edit_catg_id_fest");
           
            $("#festivalDate").attr("data-edit_temp_id_fest", id);
            
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var modalId, cardId, channel_id, temp_id, date, time, groups1, message;

            temp_id = $('#template_id_fest').val();
            // alert(temp_id);


            $('#festivalDate').val('');
            $('#festivalTime').val('');
            $('#myGroupsFest').val('');
            $('#fest_message_id').val(id);
            var inputVal = { "id" : id, "cat_id" : cat_id, "_token" : CSRF_TOKEN };
            $.ajax({
                url : '{{ route('business.channel.personalisedMessage.editFestivalTemplate') }}',
                type : 'POST',
                dataType : "json",
                data : inputVal,
                success : function(res) {
                    console.log('res: ', res.record.selectedGroupsInfo);
                    
                    // alert( $('#myGroupsFest').val(''));
                    if(res.record.cat_id!=''){
                        $('#st_category_input_fest').attr('readonly', true);
                        $("#myGroupsFest option[value='"+res.record.selectedGroupsInfo+"']").empty();                        
                        $("#st_category_input_fest option[value='"+res.record.cat_id+"']").attr("selected", "selected");
                    }

                    if(res.status == true){
                        // Set Time Choice
                        timeslotFestival.clearChoices();
                        timeslotFestival.setChoices(res.record.slots_array, 'value', 'label', false);

                        // console.log("timeslotFestival ", timeslotFestival);

                        // groups.clearChoices();
                        // Working code
                        // groups.setValue(res.record.selectedGroupsInfo.map((v) => ({value: v.id, label: v.name})));
                        // groups.choice();
                        // console.log("hiie");
                        console.log(res.record.selectedGroupsInfo);
                        // console.log($('.choices__list.choices__list--multiple').html());
                        groupsFestival.clearChoices();
                        groupsFestival.setChoices(res.record.selectedGroupsInfo, 'value', 'label', false);
                        

                       
                        // Set Dates
                        editDates1 = res.record.usedDates;

                        // Custom MSG
                        modalId = "festivalMessages";
                       
                         $("#festivalDate").val(res.record.date);
                         $("#festivalTime option[value='"+res.record.date+"']").attr("selected", true);  
                        //  $("#myGroupsFest option[value='"+res.record.selectedGroupsInfo+"']").attr("selected", false); 
                      
                        //  alert(modalId);
                        $('.'+modalId+' .grid-item').remove();
                        var instance1 = new Colcade('.'+modalId,{
                            columns: '.grid-col',
                            items: '.grid-item'
                        });
                        instance1.destroy();
                        var data_col = "";
                        var templates = res.record.templates;

                        var busniess_name = '{{ $busniess_name }}';
                        // // alert(busniess_name);
                        $.each(templates, function(i, elm) {
                            var name = elm.category.name;
                            message = nl2br(elm.message);
                            
                            var isChecked = "";
                            // console.log('hi');
                            // console.log("el id ", elm.id);
                            // console.log("template_id ", res.record.template_id);
                            if(elm.id == res.record.template_id){
                                isChecked = "checked";
                                $("#checkFestTemplateCategory").val(elm.message_template_category_id);
                                $("#checkFestTemplateID").val(res.record.template_id);
                            }

                            message = message.replaceAll('{#var#}', busniess_name);

                            data_col = '<div class="options card-msg-option chooseFestTemplate" data-templatecategory_id_fest="'+elm.message_template_category_id+'" data-template_id_fest="'+elm.id+'"><input type="radio" '+isChecked+' name="festivaltemp"  id="temp_'+elm.id+'" value="'+elm.id+'" class="radio_button"><label class="radio_label mb-2 d-block" for=temp_'+elm.id+'"><div class="card"><div class="card_style"><h6 class="card-message-hedding">'+name+'</h6><p class="mb-0 card-message-selection">“'+message+'”</p></div></div></label></div>';

                            instance1.append([
                                makeItem(data_col, 'message_template_category_'+res.record.message_template_category_id)
                            ]);
                        });
                        $('#temp_'+res.template_id).prop("checked", true);
                        // $('#temp_'+res.template_id).prop("checked", true);
                        $('#'+modalId).modal('toggle');
                        // console.log(modalId);
                    }
                }
            });
        });


    

        $( function() {

            var unavailableDates = @json($usedDates);

            function unavailable(date) {
                dmy = date.getDate() + "-" + (date.getMonth() + 1) + "-" + date.getFullYear();
                if ($.inArray(dmy, unavailableDates) == -1) {
                    return [true, ""];
                } else {
                    return [false, "", "Unavailable"];
                }
            }

            function getDate(element) {
                var date;
                try {
                    date = $.datepicker.parseDate(dateFormat, element.value);
                } catch (error) {
                    date = null;
                }

                return date;
            }
            
            $("#personalisedDate").datepicker({
                dateFormat: "dd-mm-yy",
                changeMonth: true,
                changeYear: true,
                minDate: new Date(new Date().getTime() + 24 * 60 * 60 * 1000),
                numberOfMonths: 1,
                // beforeShowDay: unavailable
                beforeShowDay: function(date){

                    var editTempId = $("#personalisedDate").attr("data-edit_temp_id");
                    console.log("hi");
                    console.log("editTempId ",editTempId);
                    if(editTempId == "0"){
                        dmy = date.getDate() + "-" + (date.getMonth() + 1) + "-" + date.getFullYear();

                        console.log("dmy ", dmy);
                        console.log("unavailableDates ", unavailableDates);
                        if ($.inArray(dmy, unavailableDates) == -1) {
                            return [true, ""];
                        } else {
                            return [false, "", "Unavailable"];
                        }
                    }
                    else{
                        dmy = date.getDate() + "-" + (date.getMonth() + 1) + "-" + date.getFullYear();
                        const dtData = [];
                        $.ajax({
                            url : "{{ route('business.getPersonalisedMsgInfo') }}",
                            type : 'POST',
                            dataType : "JSON",
                            data : {
                                editTempId: editTempId,
                                "_token": "{{ csrf_token() }}"
                            },
                            success : function(res) {
                                dtData.push(res.dates);
                            }
                        });

                        if ($.inArray(dmy, dtData) == -1) {
                            return [true, ""];
                        } else {
                            return [false, "", "Unavailable"];
                        }
                    }
                }
            });

            $("#festivalDate").datepicker({
                dateFormat: "dd-mm-yy",
                changeMonth: true,
                changeYear: true,
                minDate: new Date(new Date().getTime() + 24 * 60 * 60 * 1000),
                numberOfMonths: 1,
                // beforeShowDay: unavailable
                beforeShowDay: function(date){

                    var editTempIdFestival = $("#festivalDate").attr("data-edit_temp_id_fest");
                    // console.log("editTempId ",editTempIdFestival);
                    
                    if(editTempIdFestival == "0"){
                        dmy = date.getDate() + "-" + (date.getMonth() + 1) + "-" + date.getFullYear();

                        console.log("dmy ", dmy);
                        console.log("unavailableDates ", unavailableDates);
                        if ($.inArray(dmy, unavailableDates) == -1) {
                            return [true, ""];
                        } else {
                            return [false, "", "Unavailable"];
                        }
                    }
                    else{
                        dmy = date.getDate() + "-" + (date.getMonth() + 1) + "-" + date.getFullYear();
                        // alert(dmy);
                        const dtData = [];
                        $.ajax({
                            url : "{{ route('business.getFestivalMsgInfo') }}",
                            type : 'POST',
                            dataType : "JSON",
                            data : {
                                editTempIdFestival: editTempIdFestival,
                                "_token": "{{ csrf_token() }}"
                            },
                            success : function(res) {
                                dtData.push(res.dates);
                            }
                        });

                        if ($.inArray(dmy, dtData) == -1) {
                            return [true, ""];
                        } else {
                            return [false, "", "Unavailable"];
                        }
                    }
                }
            });

        } );
    });
    </script>
   <script src="{{ asset('assets/plugin/colcade/js/colcade.js') }}"></script>
    <script>
        var colcade = new Colcade( '.grid' , {
            columns: '.grid-col',
            items: '.grid-item'
        });
    </script>
    {{-- <script src="{{ asset('assets/plugin/select2/js/select2.full.js') }}"></script>
    <script>
        $(function(){
            if(jQuery().select2) {
                $(".select2").select2();
            }
        });
    </script> --}}

    <script>
        function set_cookie(name, value) {
            document.cookie = name + '=' + value;
        }

        $(document).ready(function(){
            
            $("#switch-list-style").on("click", function(e){
                e.preventDefault();
                if ($("#gridListSwitch").addClass("list")) {
                    $("#gridListSwitch").removeClass( "grid" );
                    $(this).removeClass( "btn-light" );
                    $(this).addClass( "btn-primary" );
                   
                }
                $("#switch-grid-style").addClass( "btn-light");
                $("#switch-grid-style").removeClass( "btn-primary");
                set_cookie('listing_view', 'list');
                
            });
            $("#switch-grid-style").on("click", function(e){
                e.preventDefault();
                if ($("#gridListSwitch").addClass("grid")) {
                    $("#gridListSwitch").removeClass( "list" );
                    $(this).removeClass( "btn-light" );
                    $(this).addClass( "btn-primary" );
                }
                $("#switch-list-style").addClass( "btn-light");
                $("#switch-list-style").removeClass( "btn-primary");
                set_cookie('listing_view', 'grid');
            });

            $(document).on("click", ".view-message", function(){
                $("#message-view-modal").modal('show');
                var temp_id = $(this).attr('data-temp_id');
                $.ajax({
                    url : "{{ route('business.viewPersonalisedMsg') }}",
                    type : 'POST',
                    dataType : "JSON",
                    data : {
                        temp_id: temp_id,
                        "_token": "{{ csrf_token() }}"
                    },
                    beforeSend: function() {
                        $("#overlay").fadeIn(300);
                    },
                    success:function(response){
                        $("#overlay").fadeOut(300);
                        var htmlTbl="";
                        if(response.status==true){
                            $("#view-datetime").text(response.data.date);
                            $("#view-category_name").text(response.data.title);
                            $("#view-message_text").html(response.data.message);
                            if(response.data.contact_grps_data.length > 0){
                                response.data.contact_grps_data.forEach(grp=> {
                                    htmlTbl += "<tr>";
                                        htmlTbl += '<td class="">'+grp.name+'</td>';
                                        htmlTbl += '<td class="">'+grp.cust_count+'</td>';
                                    htmlTbl += "</tr>";
                                });
                            }
                            else{
                                htmlTbl += "<tr><td colspan='2'>Record not found!</td></tr>";
                            }
                        }
                        else{
                            $("#view-datetime").text("");
                            $("#view-category_name").text("");
                            $("#view-message_text").html("");
                            htmlTbl += "<tr><td colspan='2'>Record not found!</td></tr>";
                        }
                        $("#view-contact_info").html(htmlTbl);


                        // view-datetime
                        
                        // console.log("view-hostory");
                        // console.log(response);
                    }
                });
            });
        });
    </script>

    <script>
        $(".btnPrevious").click(function () {
            $(".nav-tabs .active").parent().prev("li").find("a").trigger("click");
        });
        $(".btnNext").click(function () {
            $(".nav-tabs .active").parent().next("li").find("a").trigger("click");
        });
        $(".btnPreviousFest").click(function () {
            // alert("pre");
            $(".nav-tabs .active").parent().prev("li").find("a").trigger("click");
        });
        $(".btnNextFest").click(function () {
            // alert("nex");
            $(".nav-tabs .active").parent().next("li").find("a").trigger("click");
        });
    </script>
    {{-- <script>
        $(document).ready(function() {


            $(".container__tab").click(function () {
                var tab =  $(this).attr("data-type");
                // alert(tab);
                // $('.tab1').click(function() {
                //     $('.myButton').toggle();
                // });
                // });
                if(tab == "dateAndTime"){
                    $('.btnPrevious').hide();
                    $('.pers-msg-btn').hide();
                    $('.btnNext').show();
                    // alert(tab);
                } 
                else {
                    $('.pers-msg-btn').show();
                    $('.btnPrevious').show();
                    $('.btnNext').hide();
                    // alert(tab);
                }
            });
        });
    </script> --}}
    
   
    <script src="{{ asset('assets/js/daterangepicker.js') }}"></script>

    @include('business.personalised-messages.scripts')
    @include('business.channels.common-js')
    
@endsection