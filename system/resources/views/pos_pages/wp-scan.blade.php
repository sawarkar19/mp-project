<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap 5.2.0 -->
    <link rel="stylesheet" href="{{ asset('assets/website/vendor/bootstrap/css/bootstrap.min.css') }}">

    <!-- ICONS (Bootstrap) V1.5.0 -->
    <link rel="stylesheet" href="{{ asset('assets/website/vendor/bootstrap-icons/font/bootstrap-icons.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/fontawsome/all.min.css') }}">
        <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="{{ asset('assets/website/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/website/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/website/css/customs.css') }}">
<style>
    .main-logo-mp {
        max-width: 200px;
        margin: auto;
    }

    .wp-scan-card {
        width: 100%;
        max-width: 900px;
        margin: auto;
        background-color: #F2F5FD;
        border-radius: 8px;
        position: relative;
    }

    .wp-scan-card .wp-scan-card-inner {
        position: relative;
        z-index: 2;
    }

    .qr-scanner i {
        font-size: 170px;
    }

    .list-unstyled-border li {
        border-bottom: 1px solid #f9f9f9;
        padding-bottom: 15px;
        margin-bottom: 15px;
    }

    .step-num {
        margin-right: 15px;
        width: 48px;
    }

    .step-num p {
        font-size: 2rem;
        margin-bottom: 0px;
        line-height: 1;
        color: #d9e3f3;
        font-weight: 500;
    }

    .media {
        display: flex;
        align-items: center;
    }

    .media .media-title {
        margin-top: 0;
        margin-bottom: 5px;
        font-weight: 700;
        font-size: 15px;
        color: #34395e;
    }

    .wp-padding {
        padding: 20px;
    }

    .br-left-to-top {
        border-radius: 0.6rem 0 0 0.6rem;
    }

    .br-right-to-bottom {
        border-radius: 0 0.6rem 0.6rem 0;
    }
    .pos-footer {
        padding: 15px 0px;
        color: var(--cl-default);
        display: inline-block;
        width: 100%;
        background: #fff;
    }
    .bullet{
        display: inline;
        margin: 0 4px;
    }
    .stage{
        position: relative;
        padding: 0px 50px;
        display: inline-block;
    }
    .dot-flashing {
        position: relative;
        width: 10px;
        height: 10px;
        border-radius: 5px;
        background-color: #2204a9;
        color: #2204a9;
        animation: dot-flashing 1s infinite linear alternate;
        animation-delay: 0.5s;
    }
    .dot-flashing::before, .dot-flashing::after {
        content: "";
        display: inline-block;
        position: absolute;
        top: 0;
    }
    .dot-flashing::before {
        left: -15px;
        width: 10px;
        height: 10px;
        border-radius: 5px;
        background-color: #2204a9;
        color: #2204a9;
        animation: dot-flashing 1s infinite alternate;
        animation-delay: 0s;
    }
    .dot-flashing::after {
        left: 15px;
        width: 10px;
        height: 10px;
        border-radius: 5px;
        background-color: #2204a9;
        color: #2204a9;
        animation: dot-flashing 1s infinite alternate;
        animation-delay: 1s;
    }

    .sb-tabs{
        position: relative;
        width: 100%;
        
        border-bottom: 1px solid #e1e7ed;
        /* border-top: 1px solid #e1e7ed; */
        border-left: 3px solid transparent;
    }
    .sb-tabs .inner{
        position: relative;
        padding: 20px 12px;
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        align-items: center
    }
    .sb-tabs .status-icon{
        width: 35px;
        text-align: left;
    }
    .sb-tabs .status-icon i{
        font-size: 1rem!important;
    }
    .sb-tabs .dirction-ico{
        width: 15px;
        text-align: right;
    }
    .sb-tabs .title_{
        width: calc(100% - 50px);
        text-align: left;
    }
    .sb-tabs .title_ h6{
        color: #38404b;
        margin-bottom: 3px;
        font-size: .9rem;
        line-height: 1.2!important;
    }
    .sb-tabs .title_ p{
        color: rgb(117, 117, 117);
        margin-bottom: 0px;
        font-size: .6rem;
        line-height: 1.2!important;
    }

    #b-setting-tab .nav-item >.nav-link{
        padding: 0px;
    }
    #b-setting-tab .nav-item >.nav-link.active > .sb-tabs{
        /* border-bottom: 1px solid #e1e7ed;
        border-top: 1px solid #e1e7ed; */
        border-left: 3px solid var(--primary);
        background-color: #f8fbff;
    }



    .step-num{
        margin-right: 15px;
        width: 48px;
    }
    .step-num p{
        font-size: 2rem;
        margin-bottom: 0px;
        line-height: 1;
        color: #d9e3f3;
    }
    .wa-div{
        position: relative;
        width: 100%;
        max-width: 280px;
        margin: auto;
    }
    .wa-qr{
        position: relative;
        width: 100%;
        height: auto;
        /*padding: 5px 0px;*/
        border: 2px solid #128C7E;
        text-align: center;
    }
    .wa-qr img{
        width: 100%;/*
        max-width: 270px;*/
    }
    .reload-qr{
        width: 100%;
        height: 100%;
        min-height: 280px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .reload-qr .circle-reload{
        display: inline;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background-color: #128C7E;
        color: #ffffff;
        text-align: center;
    }
    .reload-qr .circle-reload i{
        line-height: 80px;
    }
    #onClickReloadQR{
        cursor:pointer;
    }

    .lh-1{
        line-height: 1.5!important;
    }
    
    .default.alert-info{
        color: #0c5460;
        background-color: #f4fbfc;
        border:1px solid #99c5cc;
    }

    .facebook-bg,
    .instagram-bg,
    .twitter-bg,
    .linkedin-bg,
    .youtube-bg,
    .pintrest-bg{
        color: #ffffff;
        padding-left: 12px;
        padding-right: 12px;
    }
    .facebook-bg i,
    .instagram-bg i,
    .twitter-bg i,
    .linkedin-bg i,
    .youtube-bg i,
    .pintrest-bg i{
        font-size: 1.2rem!important;
        width: 20px;
        text-align: center;
    }
    .facebook-bg{ background-color: #4267B2!important;}
    .instagram-bg{ background-color: #E1306C!important;}
    .twitter-bg{ background-color: #00acee!important;}
    .linkedin-bg{ background-color: #0077b5!important;}
    .youtube-bg{ background-color: #FF0000!important;}
    .pintrest-bg{ background-color: #E60023!important;}

    .img-container {
        /* Never limit the container height here */
        max-width: 100%;
    }

    .img-container img {
        /* This is important */
        width: 100%;
    }
    button.google_map_btn:focus{
        outline: none !important;
        border-style: none !important;
    }

    /* busniess logo */
    .logo-wrap.crop-again{
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        height: 100%;
        text-align: center;
        width: 100%;

    }
    .logo-wrap.crop-again img{
        height: 100% !important;
        width: 100%;
        object-fit: contain;
    }


    .channel_list{
        position: relative;
        width: 100%;
        /* margin-bottom: 2rem; */
    }
    .channel_list .inner{
        position: relative;
        align-items: center;
        justify-content: space-between;
        background-color: #fff;
        border-radius: 4px;
        border-bottom: 1px solid #e1e7ed;
        padding: 15px 0px;
    }

    .inner{
        border-bottom: 1px solid #e1e7ed;
    }

    
    .channel_list:last-child .inner {
        border-bottom: 0px;
    }
    @media(max-width:767px){
        .channel_list{
            margin-bottom: 1.5rem;
        }
        .channel_list .inner{
            padding: 10px 15px;
            box-shadow: 0px 2px 8px rgba(0,0,0,.05);
        }
    }

    .vw{
        position: relative;
    }
    .vw .card{
        border: 1px solid #e3e3e3;
        transition: all 300ms ease;
        background-color: #fbfbfb;
        box-shadow: none!important;
    }
    .vw .card > .card-body{
        padding: 15px !important;
    }
    .vw h6{
        margin-left: 20px;
    }
    .vw p{
        line-height: 1.5!important;
    }
    .vw .vw_input{
        /* visibility: hidden; */
        position: absolute;
        z-index: 1;
        top: 20px;
        left: 15px;
    }
    .vw .vw_input:checked + .card{
        border: 1px solid var(--primary);
        background-color: #fafcff;
    }
    .vw_page_preview{
        width: 100%;
        display: block;
        position: relative;
        padding: 5px 2px;
        text-align: center;
        font-size: .8rem;
        font-weight: 500;
        color: #556070;
        background-color: #ffffff;
        text-decoration: none;
        transition: all 300ms ease-in-out;
        border-radius: 3px 3px 0 0;
        border: 1px solid #e4e6fc;
        border-bottom: none!important;
        line-height: 1.5;
    }
    .vw_page_preview:hover{
        text-decoration: none;
        color: #303439;
        background-color: #e6eef9;
    }
    .imagecheck-image:hover {
        opacity: 1;
    }
    .imagecheck .selectable-name:after {
        content: '';
        position: absolute;
        top: 0.42rem;
        left: .25rem;
        display: block;
        width: 1rem;
        height: 1rem;
        pointer-events: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        background: var(--cl-prime) url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3E%3Cpath fill='%23fff' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.26 2.974 7.25 8 2.193z'/%3E%3C/svg%3E") no-repeat center center/50% 50%;
        color: #fff;
        z-index: 1;
        border-radius: 3px;
        opacity: 0;
        transition: .3s opacity; 
    }
    .imagecheck-input:checked ~ .selectable-name:after {
        opacity: 1;
    }
    .imagecheck-input:checked .imagecheck-image:hover {
        opacity: 1;
    }
    
    .google-review img{
        width: 40px;
    }
    .google-review{
        padding: 0 2px !important;
    }
    #contact5 .info-btn {
        font-size: 14px;
    }

    .card.sconnect{
        position: relative;
        text-align: center;
        box-shadow: none!important;
        border: 1px solid rgba(0, 0, 0, .3);
        border-radius: 6px;
        height: 100%;
        margin-bottom: 0px;
    }
    .card.sconnect .card-body{
        padding-left: 10px;
        padding-right: 10px;
    }
    .sconnect .sc-icon i{
        font-size: 2.2rem;
    }
    .card.sconnect .connected,
    .card.sconnect .new_connect,
    .card.sconnect .re_connect{
        position: relative;
        padding: 10px;
        border-radius: 0 0 6px 6px;
    }
    .card.sconnect .connected{
        background-color: #d4edda;
        color: #155724;

        pointer-events: none;
    }
    .card.sconnect .new_connect{
        background-color: #cce5ff;
        color: #004085;
        cursor: pointer;
    }
    .card.sconnect .re_connect{
        background-color: #fff3cd;
        color: #856404;
        cursor: pointer;
    }

    .card.sconnect .connected-icon,
    .card.sconnect .disconnected-icon{
        position: absolute;
        font-size: 1.2rem;
        top: 6px;
        left: 6px;
    }
    .card.sconnect .connected-icon{
        color: var(--success);
    }
    .card.sconnect .disconnected-icon{
        color: var(--danger);
    }

    .card.sconnect .update-icon{
        position: absolute;
        font-size: 1rem;
        top: 6px;
        right: 6px;
        cursor: pointer;
    }
    .sconnect .a_disable{
        cursor: no-drop !important;
        background: #bdc0c4 !important;
        color: #a2a2a2 !important;
    }
    .facebook-modal .modal-dialog-centered::before {
        height: auto !important;
    }
    .step-icon i{
        font-size: 23px;
        position: relative;
        top: 4px;
    }
    .social-steps.accordion .accordion-item{
        background: #fff;
    }
    .social-steps.accordion .accordion-header{
        background-color: transparent;
        box-shadow: none;
        position: relative;
        color: #3f729b;
    }   
    .underline-text{
        max-width: 150px;
        border-bottom: 2px solid #FAD8AB;
        margin: auto;
    } 
    .social-post-setps .accordion .accordion-header[aria-expanded="true"] .fa-angle-down:before {
        content: "\f106";
    }
    .steps-lineHeight p{
        line-height: 22px;
    }
    .gift_item .badge {
        line-height: 0;
    }
    .delete_badge {
        padding: 10px 8px;
        font-size: 10px;
        margin-left: 6px;
        cursor: pointer;
    }
    .vcard_redirect{
        font-size: 11px;
        line-height: 15px;
        margin-top: 10px;
    }
    .pop-icon{
        border: none;
        background: none;
    }
    .pop-icon:focus{
        outline: none;
    }

    /* .connect-pop .fa-link{
        transform: rotate(45deg);
        font-size: 23px;
    } */
    .connect-pop .fab{
        background: #4d4a4a;
        color: #fff;
        font-size: 15px;
        border-radius: 50%;
        padding: 6px;
    }
    .arrow.dark::after{
        border-bottom-color: var(--dark);
    }

    @keyframes dot-flashing {
        0% {
            background-color: #2204a9;
        }
        50%, 100% {
            background-color: rgba(152, 128, 255, 0.2);
        }
    }
    @media(max-width: 767px) {
        .br-left-to-top {
            border-radius: 0.6rem 0.6rem 0 0;
        }

        .br-right-to-bottom {
            border-radius: 0 0 0.6rem 0.6rem;
        }
    }
</style>
</head>
<body>
{{-- Whatsapp scan section --}}
    <section id="whatsapp-scan">
        <div style="display:none" id="pos_info_token">{{ $str }}</div>

        <div class="wp-scan py-5 px-3">
            <div class="container">
                <div class="text-center mb-4">
                    <a class="" href="{{url('/')}}">
                        <img src="{{asset('assets/website/images/logos/logo-dark.svg')}}" alt="MouthPublicity"
                            class="main-logo-mp">
                    </a>
                </div>

                <div class="wp-scan-card shadow">
                    <div class="wp-scan-card-inner">
                        <div class="row">
                            <div class="col-md-6 bg-color-gradient br-left-to-top wp-padding">
                                <div class="text-center text-white">
                                    <h6 class="text-center font-700 my-3">
                                        Scan QR, to start sending messages.
                                    </h6>

                                    <div class="tab-pane fade setting-section-tab active show" id="whatsapp_setting_tab" role="tabpanel" aria-labelledby="whatsapp_setting">
                                        <div class="p-4">
        
                                            <div id="instance_key" style="display: none"></div>

                                                <div id="disconnected" style="@if($wa_session &&   $wa_session->instance_id != '') display:none @endif">
                                                    <div class="d-flex flex-column mx-auto mb-4" style="width: 100%;max-width:500px;">



                                                        
                                                        <div class="">
                                                            <div class="text-center mb-3" id="countdownTest">
                                                                <span>Code will change in</span> 
                                                                <b><span class="js-timeout">0:50</span> sec.</b>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="wa-setting">
                                                                <div class="wa-div">
                                                                    <div class="wa-qr" id="qr_code_img">
                                                                        {{-- reload QR icon --}}
                                                                        <div class="reload-qr">
                                                                            <div class="circle-reload" data-toggle="tooltip" title="Refresh QR code">
                                                                                <i class="fa fa-redo-alt fa-3x fa-spin"></i>
                                                                            </div>
                                                                        </div>
                                                                        {{-- QR code img tag --}}
                                                                    </div>
                                                                    <div id="instance_id" style="display:none"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                
                                                    
                
                                                    </div>
                                                </div>

                                                <div id="connected" class="p-3 rounded" style="background: #f4fff8;    color: #000000;text-align: left;@if(!$wa_session ||  $wa_session->instance_id == '') display:none @endif">
                                                    <div class="d-md-flex">
                                                        <div class="avatar-item mb-3 mb-md-0 mr-3" style="max-width: 60px">
                                                            @if(isset($wa_session->wa_avatar) && $wa_session->wa_avatar)
                                                                <img alt="image" src="{{$wa_session->wa_avatar}}" class="img-fluid" data-toggle="tooltip" title="{{ $whatsapp_num }}">
                                                            @else
                                                                <img alt="image" src="{{asset('assets/img/avatar/avatar-2.png')}}" class="img-fluid" data-toggle="tooltip" title="{{ $whatsapp_num }}">
                                                            @endif
                                                        </div>
                                                        <div style="padding-left: 10px;">
                                                            <p class="mb-2 h5"><b id="wa_number" style="font-size: 16px;">{{ $whatsapp_num }}</b> <small id="wa_name" style="font-size: 16px;">({{ isset($wa_session->wa_id) ? $wa_session->wa_id : '' }})</small> </p>
                                                            <p class="mb-0"><i class="fa fa-wifi text-primary mr-2"></i> State: <span class="badge badge-success py-1" style="color:#2cff5d">Connected</span></p>
                                                        </div>
                                                    </div>

                                                    <a class="btn btn-primary-ol btn-lg w-100 my-3" href="{{ route('posInfoPage', $str) }}">Next</a>
                                                </div>
                                            
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="col-md-6 wp-padding border br-right-to-bottom bg-white">
                                <div class="mt-4">
                                    <h6 class="color-primary mb-4 font-600">Steps to Connect WhatsApp</h6>

                                    <ul class="list-unstyled list-unstyled-border mb-0">
                                        <li class="media align-items-center">
                                            <div class="step-num">
                                                <p>01.</p>
                                            </div>
                                            <div class="media-body">
                                                <div class="media-title">Open WhatsApp</div>
                                                <div class="text-muted">Open WhatsApp application on your phone.</div>
                                            </div>
                                        </li>
                                        <li class="media align-items-center">
                                            <div class="step-num">
                                                <p>02.</p>
                                            </div>
                                            <div class="media-body">
                                                <div class="media-title">Select Linked Devices</div>
                                                <div class="text-muted">Tap on
                                                    <span class="">
                                                        <svg height="18px" viewBox="0 0 24 24" width="18px">
                                                            <rect fill="#f2f2f2" height="24" rx="3" width="24"></rect>
                                                            <path
                                                                d="m12 15.5c.825 0 1.5.675 1.5 1.5s-.675 1.5-1.5 1.5-1.5-.675-1.5-1.5.675-1.5 1.5-1.5zm0-2c-.825 0-1.5-.675-1.5-1.5s.675-1.5 1.5-1.5 1.5.675 1.5 1.5-.675 1.5-1.5 1.5zm0-5c-.825 0-1.5-.675-1.5-1.5s.675-1.5 1.5-1.5 1.5.675 1.5 1.5-.675 1.5-1.5 1.5z"
                                                                fill="#818b90"></path>
                                                        </svg>
                                                    </span>
                                                    Menu or
                                                    <span class="">
                                                        <svg width="18" height="18" viewBox="0 0 24 24">
                                                            <rect fill="#F2F2F2" width="24" height="24" rx="3"></rect>
                                                            <path
                                                                d="M12 18.69c-1.08 0-2.1-.25-2.99-.71L11.43 14c.24.06.4.08.56.08.92 0 1.67-.59 1.99-1.59h4.62c-.26 3.49-3.05 6.2-6.6 6.2zm-1.04-6.67c0-.57.48-1.02 1.03-1.02.57 0 1.05.45 1.05 1.02 0 .57-.47 1.03-1.05 1.03-.54.01-1.03-.46-1.03-1.03zM5.4 12c0-2.29 1.08-4.28 2.78-5.49l2.39 4.08c-.42.42-.64.91-.64 1.44 0 .52.21 1 .65 1.44l-2.44 4C6.47 16.26 5.4 14.27 5.4 12zm8.57-.49c-.33-.97-1.08-1.54-1.99-1.54-.16 0-.32.02-.57.08L9.04 5.99c.89-.44 1.89-.69 2.96-.69 3.56 0 6.36 2.72 6.59 6.21h-4.62zM12 19.8c.22 0 .42-.02.65-.04l.44.84c.08.18.25.27.47.24.21-.03.33-.17.36-.38l.14-.93c.41-.11.82-.27 1.21-.44l.69.61c.15.15.33.17.54.07.17-.1.24-.27.2-.48l-.2-.92c.35-.24.69-.52.99-.82l.86.36c.2.08.37.05.53-.14.14-.15.15-.34.03-.52l-.5-.8c.25-.35.45-.73.63-1.12l.95.05c.21.01.37-.09.44-.29.07-.2.01-.38-.16-.51l-.73-.58c.1-.4.19-.83.22-1.27l.89-.28c.2-.07.31-.22.31-.43s-.11-.35-.31-.42l-.89-.28c-.03-.44-.12-.86-.22-1.27l.73-.59c.16-.12.22-.29.16-.5-.07-.2-.23-.31-.44-.29l-.95.04c-.18-.4-.39-.77-.63-1.12l.5-.8c.12-.17.1-.36-.03-.51-.16-.18-.33-.22-.53-.14l-.86.35c-.31-.3-.65-.58-.99-.82l.2-.91c.03-.22-.03-.4-.2-.49-.18-.1-.34-.09-.48.01l-.74.66c-.39-.18-.8-.32-1.21-.43l-.14-.93a.426.426 0 00-.36-.39c-.22-.03-.39.05-.47.22l-.44.84-.43-.02h-.22c-.22 0-.42.01-.65.03l-.44-.84c-.08-.17-.25-.25-.48-.22-.2.03-.33.17-.36.39l-.13.88c-.42.12-.83.26-1.22.44l-.69-.61c-.15-.15-.33-.17-.53-.06-.18.09-.24.26-.2.49l.2.91c-.36.24-.7.52-1 .82l-.86-.35c-.19-.09-.37-.05-.52.13-.14.15-.16.34-.04.51l.5.8c-.25.35-.45.72-.64 1.12l-.94-.04c-.21-.01-.37.1-.44.3-.07.2-.02.38.16.5l.73.59c-.1.41-.19.83-.22 1.27l-.89.29c-.21.07-.31.21-.31.42 0 .22.1.36.31.43l.89.28c.03.44.1.87.22 1.27l-.73.58c-.17.12-.22.31-.16.51.07.2.23.31.44.29l.94-.05c.18.39.39.77.63 1.12l-.5.8c-.12.18-.1.37.04.52.16.18.33.22.52.14l.86-.36c.3.31.64.58.99.82l-.2.92c-.04.22.03.39.2.49.2.1.38.08.54-.07l.69-.61c.39.17.8.33 1.21.44l.13.93c.03.21.16.35.37.39.22.03.39-.06.47-.24l.44-.84c.23.02.44.04.66.04z"
                                                                fill="#818b90"></path>
                                                        </svg>
                                                    </span>
                                                    Settings and select <b class="color-primary">Linked Devices</b>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="media align-items-center">
                                            <div class="step-num">
                                                <p>03.</p>
                                            </div>
                                            <div class="media-body">
                                                <div class="media-title">Scan QR Code</div>
                                                <div class="text-muted">Tap on <b class="color-primary">Link a Device</b> and
                                                    Point your phone to this screen to <b class="color-primary">capture the
                                                        code</b></div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-5 mx-auto" style="max-width: 850px">
                    <p class="mb-0" style="line-height: 1.7;">Your WhatsApp account will be
                        secured with MouthPublicity as we can't read, listen or store your personal
                        or business conversation as per our data <a
                            href="{{ route('privacy_policy') }}" target="_blank">Privacy policy</a>.</p>
                </div>
            </div>
        </div>
    </section>
    <footer class="pos-footer">

        <div class="text-center">Copyright © 2023
            <div class="bullet"></div>Powered By 
            
            <a href="https://logicinnovates.com/" target="_blank">
            <span>Logic Innovates</span>
            </a>
        </div>
    </footer>

    <script src="{{ asset('assets/js/jquery-3.5.1.min.js')}}"></script>

    <script type="text/javascript">

        var n = 0;
    
        var interval;
        var refreshId;
        var intervalReconnect;
        var intervalCallNow;
        var QrScaned = false;
        var start = Date.now();
    
        function callNow(instance_key) {
            if(QrScaned != true){
                get_key_info(instance_key);
            }
        }
    
        function updateBeat() {
            n = parseInt(n) + 1;
            // console.log(n*20+' Seconds Completed! & ', 'n = '+n);
        }
    
        function checkNow() {
            // console.log(n)
            if(n >= 3){
                clearInterval(interval);
                clearInterval(intervalCallNow);
                return true;
            }else{
                return false;
            }
        }
    
        function reload(frame, url) {
            $(frame).load(url);
        }
    
        /* Countdown 2 */
        function countdown2(){
            if (checkNow()) {
                var image = new Image();
                image.src = "{{ asset('assets/click-to-reload1.jpg') }}";
                $('.reload-qr').hide();
                $("#qr_code_img img:last-child").remove()
                $('#qr_code_img').append(image);
                $("#qr_code_img img:last-child").attr('id', 'onClickReloadQR');
                $('#countdownTest').html('');
                $('#countdownTest').html('<span>Code will not change </span><b><span class="js-timeout">until</span> you reload.</b>');
                clearInterval(interval);
                clearInterval(intervalCallNow);
                return false;
            }
            updateBeat();
            get_wa_token();
        }
        
    
        /* 20 seconds countdown */
        function countdown() {
            // console.log('hey');
            clearInterval(interval);
            interval = setInterval( function() {
                var timer = $('.js-timeout').html();
                timer = timer.split(':');
                var minutes = timer[0];
                var seconds = timer[1];
                seconds -= 1;
                if (minutes < 0)
                    return;
                else if (seconds < 0 && minutes != 0) {
                    minutes -= 1;
                    seconds = 59;
                }
                else if (seconds < 10 && length.seconds != 2)
                    seconds = '0' + seconds;
                    $('.js-timeout').html(minutes + ':' + seconds);
    
                if (minutes == 0 && seconds == 0)
                    clearInterval(interval);
    
                    var timeout = $('.js-timeout').html();
                    if(timeout == '0:00'){
                        countdown2();
                    }
            }, 1000);
        }
    
        /* get instance id*/
        var wa_action = '{{ $wa_api_url->value }}';
        var key_secret = '{{ $wa_session->key_secret }}';
        var key_id = '{{ $wa_session->key_id }}';
        var wa_mobile = '{{ $userData->mobile }}';
    
        function get_wa_token(){
            $("#qr_code_img img").remove();
            $('.reload-qr').show();
            $.ajax({
                url : wa_action+'/instance/init?key_secret='+key_secret+'&key_id='+key_id+'&wa_mobile='+wa_mobile,
                type : 'GET',
                dataType : "json", 
                success : function(res) {
                    
                    if(res.error == false) {
                        $('#instance_key').text();
                        $('#instance_key').text(res.key);
                        // console.log('get_wa_token:', $('#instance_key').text());
                        setTimeout(function() { 
                            get_qrcode(res.key); 
                        }, 2000);
                        
                    }
                }
            });
        }
    
        /* get QR Code */
        function get_qrcode(instance_key){
            // console.log(instance_key);
            $.ajax({
                url : wa_action+'/instance/qrbase64?key='+instance_key,
                type : 'GET',
                dataType : "json", 
                success : function(res) {
                    // console.log('get_qrcode: ',res);
                    if(res.error == false){
                        var image = new Image();
                        image.src = res.qrcode;
                        $('.reload-qr').hide();
                        $('#qr_code_img').append(image);
                        $('.js-timeout').html('0:50');
                        countdown();
                        $("#whatsapp_setting").find("div.status-icon").html('<i class="fas fa-exclamation-circle text-warning"></i>');
                        intervalCallNow = setInterval(function(){
                            callNow(instance_key);
                        }, 4000)
                    }
                }
            });        
        }
    
        /* check instance id is connected or not*/
        function get_key_info(instance_key){
            let phone_connected = false;
            let current_instance_key = $("#instance_key").text();   
            if(QrScaned != true && current_instance_key == instance_key){
                $.ajax({
                    url : wa_action+'/instance/info?key='+instance_key,
                    type : 'GET',
                    dataType : "json",
                    success : function(res) {
                        // console.log('get_key_info: ',res);
                        phone_connected = res.instance_data.phone_connected;
                        
                        if(res.error == false && (phone_connected != undefined || phone_connected == true)){
                            // console.log('Connected');
                            let wa_data = set_key(res.instance_data);
                            let number = res.instance_data.user.id.split(':');
                            $('#disconnected').hide();
                            
                            $('#connected img').attr('title', number[0]);
                            $('#connected #wa_name').text('');
                            $('#connected #wa_name').text('('+res.instance_data.user.id+')');
                            $('#connected #wa_number').text('');
                            $('#connected #wa_number').text(number[0]);
                            $('#connected').show();
                            $("#whatsapp_setting").find("div.status-icon").html('<i class="fas fa-check-circle text-success"></i>');
                            
                            clearInterval(interval);
                            clearInterval(intervalCallNow);
                            QrScaned = true;
    
                        }else{
                            // console.log('Not Connected');
                            
                        }
                    }
                });
            }
        }
    
        /* inserting instance data into database */
        function set_key(instance_data){
            var jid = instance_data.user.id;
            var number = jid.split(':');
            var instance_key = instance_data.instance_key;

            var pos_info_token = $("#pos_info_token").text();

            $.ajax({
                url : "{{ route('setWebInstanceKey') }}",
                type : 'POST',
                data : {
                    "jid": jid,
                    "number" : number[0],
                    "instance_key" : instance_key,
                    "pos_info_token": pos_info_token,
                    "_token" : $('meta[name="csrf-token"]').attr('content')
                },
                dataType : "json", 
                success : function(res) {
                    // console.log('set_key: ',res);
                    if(res.error == false){
                        $('#instance_key').text();
                        $('#instance_key').text(instance_key);
                            // location.reload();
                    }
                    
                }
            });
        }
    
        function reset_key(){

            var pos_info_token = $("#pos_info_token").text();
            
            $.ajax({
                url : "{{ route('resetWebInstanceKey') }}",
                type : 'POST',
                data : {
                    "key_id": key_id,
                    "key_secret" : key_secret,
                    "pos_info_token" : pos_info_token,
                    "_token" : $('meta[name="csrf-token"]').attr('content')
                },
                dataType : "json", 
                success : function(res) {
                    // $("#whatsapp_setting").find("div.status-icon").html('<i class="fas fa-exclamation-circle text-warning"></i>');
                    // location.reload();
                    // console.log('reset_key: ',res);
                    
                    
                }
            });
        }
    
        function reconnectOnLoad(instance_key){
    
            if(QrScaned != true){
                if(instance_key != '' || instance_key != null){
                    $.ajax({
                        url : wa_action+'/instance/qrbase64?key='+instance_key,
                        type : 'GET',
                        dataType : "json", 
                        success : function(res) {
                            // console.log('reconnectOnLoad: ',res);
                            if(res.error == false){
                                if(res.qrcode == '' || res.qrcode == ' '){
                                    let data = get_wa_token();
                                }
                                $('#instance_key').text();
                                $('#instance_key').text(res.key);
                            }else{
                                //
                            }
                        }
                    });
                }else{
                    let data = get_wa_token();
                    // console.log(data);                
                }
            }
        }
    
        /* at end of the all script */
        $(document).ready(function(){
            $(document).on('click', '#onClickReloadQR', function(){
                clearInterval(interval);
                clearInterval(refreshId);
                clearInterval(intervalCallNow);
                $('#countdownTest').html('');
                $('#countdownTest').html('<span>Code will change in </span><b><span class="js-timeout">0:50</span> sec.</b>');
                n = 0;
                get_wa_token(); countdown(); 
                // console.log(n);
            })
            
            var instance_key = "{{ isset($wa_session->instance_id) ? $wa_session->instance_id : '' }}";
            // console.log(instance_key);
            if(instance_key){ 
                // get_key_info(instance_key)
                // reconnectOnLoad(instance_key) 
    
                $.ajax({
                    url : wa_action+'/instance/info?key='+instance_key,
                    type : 'GET',
                    dataType : "json",
                    success : function(res) {
                        // console.log('get_key_info: ',res);
                        phone_connected = res.instance_data.phone_connected;
                        if(phone_connected != undefined && phone_connected == false){
                            $('#instance_key').text();
                            $('#connected').hide();
                            $('#disconnected').show();
                            reset_key();
                            get_wa_token();
    
                            // reconnectOnLoad(instance_key) 
                            // console.log('Not Connected');
                        }
                    }
                });
            }else{
                get_wa_token();  
            }
        });
    
        </script>
</body>