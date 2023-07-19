@extends('layouts.business')

@section('title', 'Social Posts: Business Panel')

@section('head')
    @include('layouts.partials.headersection', ['title'=>'Social Posts'])
@endsection

@section('end_head')
<style>

    .ofr-card{
        position: relative;
        display: flex;
        width: 100%;
        justify-content: space-between;
        border-radius: 4px;
        overflow: hidden;
        box-shadow: 1px 1px 8px 1px rgba(0, 0, 0, .1);
        background-color: #ffffff;
        margin-bottom: 15px;
    }
    .ofr-card .ofr-img{
        width: 30%;
        /* height: 100%; */
        position: relative;
        background-color: #f2f2f2;
        background-position: top center;
        background-size: cover;
        transition: all 800ms ease;
    }
    .ofr-card .ofr-img:hover{
        background-position: bottom center;
    }

    .ofr-card .ofr-body{
        width: 70%;
    }
    .ofr-card .ofr-body-inner{
        position: relative;
        padding: 15px;
    }
    .ofr-card .ofr-title,
    .ofr-card  .ofr-text{
        line-height: 1.5;
        overflow: hidden;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        display: -webkit-box;
        width: 100%;
    }
    .ofr-card  .ofr-title{
        font-weight: 500!important;
        margin-bottom: 5px;
        font-size: 1rem
    }
    .ofr-card .ofr-date-flex{
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .ofr-card p{
        line-height: 1.5!important;
    }
    .ofr-main-card a{
        text-decoration: none!important;
        color: inherit;
    }
    .ofr-card:hover .ofr-title{
        color: var(--primary);
    }
    .btnCopy {
        border-radius: 50%;
        padding: 3px 9px !important ;
        background-color: var(--primary);
    }
    .btnCopy i{
        color: #fff;
    }
    .btnCopy:hover {
        border: 1px solid #237cd8 !important;
        background-color: transparent;
    }
    .btnCopy:hover i{
        color: #237cd8;
    }

    /* offer navigation design  */
    #offers_list.nav{
        position: relative;
        border-radius: 4px;
        margin-bottom: 1.5rem;
    }
    #offers_list.nav .nav-item{
        width: 33.33%;
    }
    #offers_list.nav .nav-item > .nav-link{
        text-align: center;
        background-color: #f2f2f2;
        color: var(--secondary);
        text-transform: capitalize;
        /* font-size: 1rem; */
        padding: 1rem .5rem;
        font-weight: 500;
        line-height: 1;
        height: 100%;
        border: 1px solid rgba(0, 0, 0, .1);
        position: relative;
    }
    #offers_list.nav .nav-item:first-child > .nav-link{
        border-radius: 4px 0px 0px 4px;
    }
    #offers_list.nav .nav-item:last-child > .nav-link{
        border-radius: 0px 4px 4px 0px;
    }
    #offers_list.nav .nav-item > .nav-link > .badge{
        background-color: var(--secondary);
        color: var(--light);
    }
    #offers_list.nav .nav-item > .nav-link:hover{
        background-color: var(--light);
        /* color: #fff; */
    }
    #offers_list.nav .nav-item > .nav-link.active{
        background-color: var(--primary);
        color: #fff;
    }
    #offers_list.nav .nav-item > .nav-link.active > .badge{
        background-color: var(--light);
        color: var(--dark);
    }

    #offers_list.nav .nav-item > .nav-link.active::after{
        content: "";
        position: absolute;
        z-index: 2;
        left: 50%;
        transform: translateX(-50%);
        top: 100%;
        width: 0;
        height: 0;
        border-left: 10px solid transparent;
        border-right: 10px solid transparent;
        border-top: 10px solid var(--primary);
        clear: both;
    }
    .social_Box {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        justify-content: space-between;
        align-items: center;
        /*height: 35px;*/
        border-radius: 40px;
    }
    .social_Box a {
        margin: 0px 4px;
        text-align: center;
        position: relative;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: var(--cl-prime);
        color: #fff;
    }
    .social_Box a > i {
        line-height: 31px;
        margin-left: 0px!important;
        font-size: 15px;
    }
    .social_Box_opacity a{
        opacity: 0.4;
        pointer-events: none;
    }
    .social_Box a.twitter {
        background-color: #00acee;
    }
    .social_Box a.facebook {
        background-color: #4267B2;
    }
    .social_Box a.linkedin {
        background-color: #0e76a8;
    }
    .social_Box a.instagram {
        background-color: #cb275e;
    }
    .social_Box a.youtube {
        background-color: #FF0000;
    }
    .social_Box a.disabled{
        opacity: 0.5;
        background-color: rgb(121, 121, 121)!important;
    }

    .social_Box i {
        font-size: 17px;
    }
    #SocialPreviewTab{
        line-height: 1;
    }
    #SocialPreviewTab.nav-tabs li{
        width: auto;
        margin: 0px;
    }
    #SocialPreviewTab.nav-tabs .nav-link{
        border: none;
        color: var(--secondary);
    }
    #SocialPreviewTab.nav-tabs .nav-link > span > i{
        font-size: 1.4rem;
    }
    #SocialPreviewTab.nav-tabs .nav-link:focus,
    #SocialPreviewTab.nav-tabs .nav-link:hover{
        border-color: transparent;
    }
    #SocialPreviewTab.nav-tabs .nav-item.show .nav-link,
    #SocialPreviewTab.nav-tabs .nav-link.active{
        background-color: transparent;
        border-color: transparent;
        border-bottom: 1px solid var(--primary);
        color: var(--primary);
    }

    .previews p,
    .previews a{
        line-height: 1.4!important;
        font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial,sans-serif!important;
    }
    .preview_img{
        position: relative;
        width: 100%;
        padding-bottom: 52%;
        background-color: #f9f9f9;
        background-size: cover;
        background-position: center;
    }
    .preview_title{
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
    }
    .preview_text{
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    #twitter{
        max-width: 600px;
        width: 100%
    }
    .tw-logo{
        position: relative;
        width: 46px;
        height: 46px;
        display: inline-block;
        border-radius: 50%;
        background-color: #1d9bf0;
    }
    #twitter .twitter-header{
        padding: 2px 20px;
        background-color: transparent;
        display: flex;
        align-items: center;
        padding: 16px 20px;
    }
    #twitter .twitter-body{
        padding: 15px 10px 10px 10px;
    }
    #twitter .twitter-box{
        margin-top: 15px;
        padding: 0px 0px 0px 48px;
    }

    #twitter .img_size img{
        width: 46px;
        height: auto;
        border-radius: 50%
    }
    #twitter .box{
        border-radius: 15px;
        border: 1px solid #CAEAEC;
        margin-bottom: 10px;
        overflow: hidden;
    }
    #twitter .box-footer{
        padding: 5px 10px 10px 10px;
    }
    #twitter .box-footer p{
        margin-bottom: 0px;
        line-height: 23px;
        color: #9A9B9D;
    }

    #facebook{
        position: relative;
    }
    #facebook .inner{
        position: relative;
        background-color: #ffffff;
        border-radius: max(0px, min(8px, ((100vw - 4px) - 100%) * 9999)) / 8px;
        -webkit-box-shadow:  0 1px 2px var(rgba(0, 0, 0, 0.2));
        box-shadow: 0 1px 2px var(rgba(0, 0, 0, 0.2));
    }
    #facebook .header{
        padding: 12px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    #facebook .foot {
        padding: 8px 15px;
        background: #f0f2f5;
    }

    #linkedIn{
        position: relative;
    }
    #linkedIn .inner{
        position: relative;
        background-color: #ffffff;
        border-radius: max(0px, min(8px, ((100vw - 4px) - 100%) * 9999)) / 8px;
        -webkit-box-shadow:  0 1px 2px var(rgba(0, 0, 0, 0.2));
        box-shadow: 0 1px 2px var(rgba(0, 0, 0, 0.2));
    }
    #linkedIn .header{
        padding: 12px;
        display: flex;
        justify-content: space-between;
        align-items: start;
    }
    #linkedIn .dash{
        width: 60px;
        height: 5px;
        border-radius: 3px;
        background-color: #ddd;
        display: inline-block;
    }
    #linkedIn .foot {
        padding: 12px;
        background: #eef3f8;
        display: flex;
        justify-content: space-between;
    }
    #linkedIn a.learnBtn {
        border-radius: 20px;
        border: 1px solid var(--cl-prime);
        padding: 2px 11px;
        font-weight: 500;
    }
    #instagram{
        max-width: 600px;
        width: 100%
    }
    .insta-logo{
        position: relative;
        width: 46px;
        height: 46px;
        display: inline-block;
        border-radius: 50%;
        background-color: #1d9bf0;
    }
    #instagram .instagram-header{
        padding: 2px 20px;
        background-color: transparent;
        display: flex;
        align-items: center;
        padding: 16px 20px;
    }
    #instagram .instagram-body{
        /* padding: 15px 10px 10px 10px; */
    }
    #instagram .insta-padd{
        padding: 15px 10px 10px 10px;
    }
    #instagram .instagram-box{
        /*margin-top: 15px;
        padding: 0px 0px 0px 48px; */
    }

    #instagram .img_size img{
        width: 46px;
        height: auto;
        border-radius: 50%
    }
    #instagram .box{
        /* border-radius: 15px;
        border: 1px solid #CAEAEC; */
        margin-bottom: 10px;
        overflow: hidden;
    }
    #instagram .box-footer{
        padding: 5px 10px 10px 15px;
    }
    #instagram .box-footer p{
        margin-bottom: 0px;
        line-height: 23px;
        color: #9A9B9D;
    }
    .postBtnBagde{
        vertical-align: middle;
        padding: 0px 12px;
        font-weight: 500;
        letter-spacing: .3px;
        border-radius: 30px;
        font-size: 12px;
        box-shadow: none;
        line-height: 20px;
    }
    .marSocial {
        margin: 0px 10px;
    }

    .multiple ul {
    display: flex;
    padding: 6px;
    }
    .multiple ul li {
    transform-origin: center center;
    opacity: 0;
    will-change: transform, opacity;
    -webkit-animation: bounceIn 1000ms ease-out forwards;
            animation: bounceIn 1000ms ease-out forwards;
    display: flex;
    justify-content: center;
    padding: 6px;
    }

    .multiple .button {
    position: relative;
    height: 40px;
    width: 110px;
    }
    .multiple .button > input {
    cursor: pointer;
    position: absolute;
    z-index: 5;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    }
    .multiple .button > input:active ~ div:before {
    transition: opacity 0ms, transform 200ms cubic-bezier(0.19, 1, 0.22, 1);
    transform: none;
    opacity: 1;
    }
    .multiple .button > input:active ~ div div, .multiple .button > input:checked ~ div div {
    transform: translateX(100%);
    }
    .multiple .button > div {
    transition: all 150ms cubic-bezier(0.19, 1, 0.22, 1);
    will-change: background;
    position: relative;
    height: 40px;
    width: 110px;
    padding: 4px;
    border-radius: 40px;
    }
    .multiple .button > div:before {
    transition: opacity 300ms ease-out, transform 0ms 300ms, background 0ms 300ms;
    opacity: 1;
    transform-origin: center center;
    transform: scale(1);
    will-change: transform, opacity;
    content: "";
    display: block;
    position: absolute;
    z-index: -1;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border-radius: 40px;
    }
    .multiple .button > div div {
    transition: all 200ms cubic-bezier(0.19, 1, 0.22, 1);
    will-change: transform;
    height: 32px;
    width: 32px;
    background: white;
    border-radius: 100%;
    }
    .multiple .button > div svg {
    display: block;
    height: 100%;
    width: auto;
    fill: white;
    }
    .multiple .button.fb > div {
    background: #ced6e5;
    }
    .multiple .button.fb > div:before {
    background: #3b5997;
    }
    .multiple .button.fb > input:hover ~ div, .multiple .button.fb > input:focus ~ div {
    background: #9daccb;
    }
    .multiple .button.fb > input:checked ~ div {
    background: #3b5997;
    }
    .multiple .button.fb > input:checked ~ div:before {
    background: #ced6e5;
    }
    .multiple .button.fb > input:checked:hover ~ div, .multiple .button.fb > input:checked:focus ~ div {
    background: #3e5171;
    }
    .multiple .button.fb svg {
    fill: #3b5997;
    }
    .multiple .button.tw > div {
    background: #cbeaf8;
    }
    .multiple .button.tw > div:before {
    background: #2daae1;
    }
    .multiple .button.tw > input:hover ~ div, .multiple .button.tw > input:focus ~ div {
    background: #96d5f0;
    }
    .multiple .button.tw > input:checked ~ div {
    background: #2daae1;
    }
    .multiple .button.tw > input:checked ~ div:before {
    background: #cbeaf8;
    }
    .multiple .button.tw > input:checked:hover ~ div, .multiple .button.tw > input:checked:focus ~ div {
    background: #377996;
    }
    .multiple .button.tw svg {
    fill: #2daae1;
    }
    .multiple .button.in > div {
    background: #bdd4e0;
    }
    .multiple .button.in > div:before {
    background: #bdd4e0;
    }
    .multiple .button.in > input:hover ~ div, .multiple .button.in > input:focus ~ div {
    background: #bdd4e0;
    }
    .multiple .button.in > input:checked ~ div {
    background: #0072b1;
    }
    .multiple .button.in > input:checked ~ div:before {
    background: #0072b1;
    }
    .multiple .button.in > input:checked:hover ~ div, .multiple .button.in > input:checked:focus ~ div {
    background: #0072b1;
    }
    .multiple .button.in i {
        font-size: 23px;
        color: #0072b1;
        margin-left: 6px;
        line-height: 34px;
    }

    @-webkit-keyframes rotateInLeft {
    0% {
        opacity: 0;
        transform: rotateX(30deg) rotateY(-30deg) translateX(300px) translateZ(200px);
    }
    100% {
        opacity: 1;
        transform: none;
    }
    }

    @keyframes rotateInLeft {
    0% {
        opacity: 0;
        transform: rotateX(30deg) rotateY(-30deg) translateX(300px) translateZ(200px);
    }
    100% {
        opacity: 1;
        transform: none;
    }
    }
    @-webkit-keyframes rotateInRight {
    0% {
        opacity: 0;
        transform: rotateX(30deg) rotateY(-30deg) translateX(-300px) translateZ(200px);
    }
    100% {
        opacity: 1;
        transform: none;
    }
    }
    @keyframes rotateInRight {
    0% {
        opacity: 0;
        transform: rotateX(30deg) rotateY(-30deg) translateX(-300px) translateZ(200px);
    }
    100% {
        opacity: 1;
        transform: none;
    }
    }

    @-webkit-keyframes bounceIn {
    0% {
        transform: matrix3d(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
        opacity: 1;
    }
    5.81% {
        transform: matrix3d(0.483, 0, 0, 0, 0, 0.483, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
    }
    11.61% {
        transform: matrix3d(0.88, 0, 0, 0, 0, 0.88, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
    }
    17.42% {
        transform: matrix3d(1.09, 0, 0, 0, 0, 1.09, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
    }
    23.12% {
        transform: matrix3d(1.142, 0, 0, 0, 0, 1.142, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
    }
    30.33% {
        transform: matrix3d(1.098, 0, 0, 0, 0, 1.098, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
    }
    37.44% {
        transform: matrix3d(1.033, 0, 0, 0, 0, 1.033, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
    }
    44.54% {
        transform: matrix3d(0.994, 0, 0, 0, 0, 0.994, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
    }
    51.65% {
        transform: matrix3d(0.984, 0, 0, 0, 0, 0.984, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
    }
    80.28% {
        transform: matrix3d(1.002, 0, 0, 0, 0, 1.002, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
    }
    100% {
        transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
        opacity: 1;
    }
    }
    @keyframes bounceIn {
    0% {
        transform: matrix3d(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
        opacity: 1;
    }
    5.81% {
        transform: matrix3d(0.483, 0, 0, 0, 0, 0.483, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
    }
    11.61% {
        transform: matrix3d(0.88, 0, 0, 0, 0, 0.88, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
    }
    17.42% {
        transform: matrix3d(1.09, 0, 0, 0, 0, 1.09, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
    }
    23.12% {
        transform: matrix3d(1.142, 0, 0, 0, 0, 1.142, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
    }
    30.33% {
        transform: matrix3d(1.098, 0, 0, 0, 0, 1.098, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
    }
    37.44% {
        transform: matrix3d(1.033, 0, 0, 0, 0, 1.033, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
    }
    44.54% {
        transform: matrix3d(0.994, 0, 0, 0, 0, 0.994, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
    }
    51.65% {
        transform: matrix3d(0.984, 0, 0, 0, 0, 0.984, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
    }
    80.28% {
        transform: matrix3d(1.002, 0, 0, 0, 0, 1.002, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
    }
    100% {
        transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
        opacity: 1;
    }
    }


    .add-link-social-icons{
        padding-top: 6px;
        padding-right: 4px;
    }
    /* .active-social-icon{
        border: 2px solid green;
    } */

    .btn-is-disabled {
    pointer-events: none; /* Disables the button completely. Better than just cursor: default; */
    opacity: "0.7";
    }


    .show-disabled {
        /* Disables the button completely. Better than just cursor: default; */
    /* pointer-events: none;  */
    opacity: "0.5";
    background-color: rgb(121, 121, 121)!important;
    }

    .card.sconnect{
        box-shadow: none!important;
        border: 1px solid rgba(0, 0, 0, .3);
        border-radius: 6px;
        width: 100%;
        margin-bottom: .6rem;
    }
    .card.sconnect:last-child{
        margin-bottom: 0rem!important;
    }
    .sconnect .sc-icon{
        width: 45px;
    }
    .sconnect .sc-icon i{
        font-size: 2rem;
    }

    .card.sconnect.disconnected{
        background-color: #fff5e9;
        border-color: #b56007;
    }
    @media (max-width:575px){
        .alert-responsive{
            display: flex;
            flex-direction: column;
        }
        
    }

</style>
@endsection

@section('content')
<section class="section">
    <div class="mb-3">
        @if($isSocialPost!=0)
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="alert alert-light alert-has-icon alert-responsive">
                        <div class="alert-icon"><i class="far fa-bell"></i></div>
                        <div class="alert-body mb-2 mb-sm-0">
                        <div class="alert-title">Social Platforms</div>
                            Before posting your offer on social media please update your social platform page links by clicking on the icons. 
                        </div>
                        <div style="justify-content: center;">
                            {{-- <a class="updateSocialLinks twitter" data-social_link="twitter_link" data-social_value="{{ $businessDetails->twitter_link }}" data-placeholderLinks="https://twitter.com/page-or-account-url" >
                                <span><i class="fab fa-twitter add-link-social-icons" ></i></span> 
                            </a>
                            <a class="updateSocialLinks facebook" data-social_link="facebook_link" data-social_value="{{ $businessDetails->facebook_link }}" data-placeholderLinks="https://facebook.com/page-or-account-url">
                                <span><i class="fab fa-facebook add-link-social-icons"></i></span>
                            </a>
                            <a class="updateSocialLinks linkedin" data-social_link="linkedin_link" data-social_value="{{ $businessDetails->linkedin_link }}" data-placeholderLinks="https://linkedin.com/page-or-account-url">
                                <span><i class="fab fa-linkedin add-link-social-icons"></i></span>
                            </a> --}}

                            <a id="redirectToSocialConnectPage" href="javascript:void(0)" class="btn btn-primary">
                                Connect to social links
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-md-6">
                <div class="card_">
                    <div class="previews">
                        <ul class="nav nav-tabs justify-content-center" id="SocialPreviewTab" role="tablist">
                            @if(in_array('facebook', $activeUserSocialPlatform))
                                <li class="nav-item" data-toggle="tooltip" title="Facebook">
                                    <a class="nav-link text-center @if($activeUserSocialPlatform[0]=='facebook') active @endif " id="face" data-toggle="tab" href="#facebook" role="tab" aria-controls="face" aria-selected="@if($activeUserSocialPlatform[0]=='facebook') true @else false @endif">
                                    <span><i class="fab fa-facebook"></i></span> {{-- Facebook --}}
                                    </a>
                                </li>
                            @endif

                            @if(in_array('twitter', $activeUserSocialPlatform))
                                <li class="nav-item" data-toggle="tooltip" title="Twitter">
                                    <a class="nav-link text-center @if($activeUserSocialPlatform[0]=='twitter') active @endif" id="twit" data-toggle="tab" href="#twitter" role="tab" aria-controls="twit" aria-selected="@if($activeUserSocialPlatform[0]=='twitter') true @else false @endif">
                                    <span><i class="fab fa-twitter"></i></span> {{-- Twitter --}}
                                    </a>
                                </li>
                            @endif

                            @if(in_array('linkedin', $activeUserSocialPlatform))
                                <li class="nav-item" data-toggle="tooltip" title="Linkedin">
                                    <a class="nav-link text-center @if($activeUserSocialPlatform[0]=='linkedin') active @endif" id="linked" data-toggle="tab" href="#linkedin" role="tab" aria-controls="linked" aria-selected="@if($activeUserSocialPlatform[0]=='linkedin') true @else false @endif">
                                    <span><i class="fab fa-linkedin"></i></span> {{-- Linkedin --}}
                                    </a>
                                </li>
                            @endif

                            <li class="nav-item" data-toggle="tooltip" title="" data-original-title="Instagram">
                                <a class="nav-link text-center" id="insta" data-toggle="tab" href="#instagram" role="tab" aria-controls="insta" aria-selected="false">
                                <span><i class="fab fa-instagram"></i></span> 
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content tab-bordered" id="SocialPreviewTabContent">

                            @if(in_array('facebook', $activeUserSocialPlatform))
                                <div class="tab-pane fade @if($activeUserSocialPlatform[0]=='facebook') active show @endif p-0 pt-3 border-0" id="facebook" role="tabpanel" aria-labelledby="face">
                                    <!--Facebook Link Page -->
                                    <div class="">
                                        <div id="facebook" class="fb-contain">
                                            <div class="inner">
                                                <div class="header">
                                                    <div>
                                                        <div class="d-flex">
                                                            <div class="mr-2">
                                                                <svg viewBox="0 0 36 36" fill="url(#jsc_s_2)" height="44" width="44"><defs><linearGradient x1="50%" x2="50%" y1="97.0782153%" y2="0%" id="jsc_s_2"><stop offset="0%" stop-color="#0062E0"></stop><stop offset="100%" stop-color="#19AFFF"></stop></linearGradient></defs><path d="M15 35.8C6.5 34.3 0 26.9 0 18 0 8.1 8.1 0 18 0s18 8.1 18 18c0 8.9-6.5 16.3-15 17.8l-1-.8h-4l-1 .8z"></path><path class="p361ku9c" fill="#ffffff" d="M25 23l.8-5H21v-3.5c0-1.4.5-2.5 2.7-2.5H26V7.4c-1.3-.2-2.7-.4-4-.4-4.1 0-7 2.5-7 7v4h-4.5v5H15v12.7c1 .2 2 .3 3 .3s2-.1 3-.3V23h4z"></path></svg>
                                                            </div>
                                                            <div>
                                                                <p class="my-1 h6" style="font-weight:500;color:#000;">Facebook</p>
                                                                <p class="mb-0 small ">{{\Carbon\Carbon::now()->format('d M Y')}}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <svg viewBox="0 0 20 20" width="1.5em" height="1.5em"><g fill-rule="evenodd" transform="translate(-446 -350)"><path d="M458 360a2 2 0 1 1-4 0 2 2 0 0 1 4 0m6 0a2 2 0 1 1-4 0 2 2 0 0 1 4 0m-12 0a2 2 0 1 1-4 0 2 2 0 0 1 4 0"></path></g></svg>
                                                    </div>
                                                </div>
                                                <div class="w-100">
                                                    <div class="preview_img" id="fb-image"></div>
                                                </div>
                                                <div class="foot">
                                                    <p class="mb-0">OPNL.IN</p>
                                                    <p class="mb-1 preview_title h6">Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                                    <p class="mb-0 preview_text" style="-webkit-line-clamp: 1;">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                                </div>
                                                <div class="bg-white px-3 py-2">
                                                    <img src="{{ asset('assets/business/sp_preview/fb-footer.png') }}" class="w-100">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Facebook Link Page End -->
                                </div>
                            @endif

                            @if(in_array('twitter', $activeUserSocialPlatform))
                                <div class="tab-pane fade @if($activeUserSocialPlatform[0]=='twitter') active show @endif p-0 pt-3 border-0" id="twitter" role="tabpanel" aria-labelledby="twit">
                                    <div>
                                        <div class="card" id="twitter">
                                            <div class="twitter-body">
                                                <div class="d-flex justify-content-between">
                                                    <div class="d-flex">
                                                        <div class="img_size mr-2">
                                                            <div class="tw-logo text-center">
                                                                <svg viewBox="0 0 24 24" style="margin-top: 8px;" aria-hidden="true" class="" height="30" width="30"><g><path fill="#ffffff" d="M23.643 4.937c-.835.37-1.732.62-2.675.733.962-.576 1.7-1.49 2.048-2.578-.9.534-1.897.922-2.958 1.13-.85-.904-2.06-1.47-3.4-1.47-2.572 0-4.658 2.086-4.658 4.66 0 .364.042.718.12 1.06-3.873-.195-7.304-2.05-9.602-4.868-.4.69-.63 1.49-.63 2.342 0 1.616.823 3.043 2.072 3.878-.764-.025-1.482-.234-2.11-.583v.06c0 2.257 1.605 4.14 3.737 4.568-.392.106-.803.162-1.227.162-.3 0-.593-.028-.877-.082.593 1.85 2.313 3.198 4.352 3.234-1.595 1.25-3.604 1.995-5.786 1.995-.376 0-.747-.022-1.112-.065 2.062 1.323 4.51 2.093 7.14 2.093 8.57 0 13.255-7.098 13.255-13.254 0-.2-.005-.402-.014-.602.91-.658 1.7-1.477 2.323-2.41z"></path></g></svg>
                                                            </div>
                                                        </div>
                                                        <div class="">
                                                            <h6 class="mb-1" style="font-size: .9rem;">Twitter </h6>
                                                            <p class="mb-0">
                                                                <span class="text-black-50">@twitter . {{\Carbon\Carbon::now()->format('Md')}}</span>
                                                            </p>
                                                            {{-- <p class="mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p> --}}
                                                        </div>
                                                    </div>
                                                    <div class="pl-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" data-supported-dps="24x24" fill="currentColor" class="mercado-match" width="24" height="24" focusable="false">
                                                            <path d="M14 12a2 2 0 11-2-2 2 2 0 012 2zM4 10a2 2 0 102 2 2 2 0 00-2-2zm16 0a2 2 0 102 2 2 2 0 00-2-2z"></path>
                                                        </svg>
                                                    </div>
                                                </div>    
                                                
                                                <div class="twitter-box">
                                                    <div class="box">
                                                        <div class="preview_img" id="preview-img"></div>
                                                        <div class="box-footer">
                                                            <a href="#">opnl.in</a>
                                                            <p class="text-muted preview_title h6">Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p> 
                                                            <p class="preview_text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer p-0 pb-1">
                                                        <img src="{{ asset('assets/business/sp_preview/tw-footer.png') }}" class="w-100">
                                                    </div>
                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if(in_array('linkedin', $activeUserSocialPlatform))
                                <div class="tab-pane fade @if($activeUserSocialPlatform[0]=='linkedin') active show @endif border-0 p-0 pt-3" id="linkedin" role="tabpanel" aria-labelledby="linked">
                                    <div id="linkedIn" class="in-contain">
                                        <div class="inner">
                                            <div class="header">
                                                <div>
                                                    <div class="d-flex">
                                                        <div class="mr-3">
                                                            {{-- <div class="img-thumb"></div> --}}
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 34 34">
                                                                <title>LinkedIn</title>
                                                                <g>
                                                                <path fill="#0a66c2" d="M34,2.5v29A2.5,2.5,0,0,1,31.5,34H2.5A2.5,2.5,0,0,1,0,31.5V2.5A2.5,2.5,0,0,1,2.5,0h29A2.5,2.5,0,0,1,34,2.5ZM10,13H5V29h5Zm.45-5.5A2.88,2.88,0,0,0,7.59,4.6H7.5a2.9,2.9,0,0,0,0,5.8h0a2.88,2.88,0,0,0,2.95-2.81ZM29,19.28c0-4.81-3.06-6.68-6.1-6.68a5.7,5.7,0,0,0-5.06,2.58H17.7V13H13V29h5V20.49a3.32,3.32,0,0,1,3-3.58h.19c1.59,0,2.77,1,2.77,3.52V29h5Z" fill="currentColor"></path>
                                                                </g>
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <p class="mb-0" style="font-weight:600;">LinkedIn</p>
                                                            <p class="text-black-50 mb-0">23,457 followers</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" data-supported-dps="24x24" fill="currentColor" width="24" height="24" focusable="false">
                                                        <path d="M14 12a2 2 0 11-2-2 2 2 0 012 2zM4 10a2 2 0 102 2 2 2 0 00-2-2zm16 0a2 2 0 102 2 2 2 0 00-2-2z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="w-100">
                                                <div class="preview_img" id="in-image"></div>
                                            </div>
                                            <div class="foot">
                                                <div style="max-width: 80%;">
                                                    <p class="preview_title mb-1 h6">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                                                    <p class="preview_text mb-0">opnl.in</p>
                                                </div>
                                                <!-- <div>
                                                <a href="#" class="learnBtn">Learn More</a>
                                                </div> -->
                                            </div>
                                            <div class="bg-white">
                                                <img src="{{ asset('assets/business/sp_preview/in-footer.png') }}" class="w-100 px-3">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- instagram preview --}}
                            <div class="tab-pane fade p-0 pt-3 border-0" id="instagram" role="tabpanel" aria-labelledby="insta">
                                <div>
                                    <div class="card" id="instagram">
                                        <div class="instagram-body">
                                            <div class="d-flex justify-content-between insta-padd">
                                                <div class="d-flex align-items-center">
                                                    <div class="img_size mr-2">

                                                        <div class="insta-logo_ text-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 333333 333333" aria-hidden="true" class="" height="30" width="30" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd"><defs><linearGradient id="a" gradientUnits="userSpaceOnUse" x1="250181" y1="308196" x2="83152.4" y2="25137"><stop offset="0" stop-color="#f58529"/><stop offset=".169" stop-color="#feda77"/><stop offset=".478" stop-color="#dd2a7b"/><stop offset=".78" stop-color="#8134af"/><stop offset="1" stop-color="#515bd4"/></linearGradient></defs><path d="M166667 0c92048 0 166667 74619 166667 166667s-74619 166667-166667 166667S0 258715 0 166667 74619 0 166667 0zm-40642 71361h81288c30526 0 55489 24654 55489 54772v81069c0 30125-24963 54771-55488 54771l-81289-1c-30526 0-55492-24646-55492-54771v-81069c0-30117 24966-54771 55492-54771zm40125 43843c29663 0 53734 24072 53734 53735 0 29667-24071 53735-53734 53735-29672 0-53739-24068-53739-53735 0-29663 24068-53735 53739-53735zm0 18150c19643 0 35586 15939 35586 35585 0 19647-15943 35589-35586 35589-19650 0-35590-15943-35590-35589s15940-35585 35590-35585zm51986-25598c4819 0 8726 3907 8726 8721 0 4819-3907 8726-8726 8726-4815 0-8721-3907-8721-8726 0-4815 3907-8721 8721-8721zm-85468-20825h68009c25537 0 46422 20782 46422 46178v68350c0 25395-20885 46174-46422 46174l-68009 1c-25537 0-46426-20778-46426-46174v-68352c0-25395 20889-46177 46426-46177z" fill="url(#a)"/></svg>
                                                        </div>

                                                    </div>
                                                    <div class="">
                                                        <h6 class="mb-1" style="font-size: .9rem;">Instagram </h6>
                                                        
                                                    </div>
                                                </div>
                                                <div class="pl-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" data-supported-dps="24x24" fill="currentColor" class="mercado-match" width="24" height="24" focusable="false">
                                                        <path d="M14 12a2 2 0 11-2-2 2 2 0 012 2zM4 10a2 2 0 102 2 2 2 0 00-2-2zm16 0a2 2 0 102 2 2 2 0 00-2-2z"></path>
                                                    </svg>
                                                </div>
                                            </div>    
                                            
                                            <div class="instagram-box">
                                                <div class="box">
                                                    <div class="preview_img" id="preview-img" ></div>
                                                    
                                                </div>
                                                <div class="card-footer p-0 pb-1">
                                                    <img src="{{ asset('assets/business/sp_preview/insta-footer.png') }}" class="w-100">
                                                    <div class="box-footer insta-padd">
                                                        <h6 class="my-2" style="font-size: .9rem;">4,65,22 likes</h6>
                                                        <h6 class="mb-1" style="font-size: .9rem;">Instagram <span class="text-black-50 preview_text d-inline">test comment</span></h6>
                                                        <p class="my-2">View all 2,999 comments</p>
                                                        <p class="my-2" style="font-size: 0.6rem">DECEMBER 31, 2022</p>
                                                    </div>
                                                    <img src="{{ asset('assets/business/sp_preview/insta-footer2.png') }}" class="w-100">
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

            <div class="col-md-6">
                <div>

                    {{-- social links modal --}}
                    <!-- <div class="card mt-3">
                        <div class="card-header">
                            <h4>{{ __("Social Links") }}
                        </div>
                        <div class="card-body">
                            {{-- <div class="previews">
                                <div class="ofr-card">
                                    <div class="ofr-body p-2"> --}}
                                        
                                        {{-- <div class="d-flex justify-content-between align-items-center"> --}}
                                            {{-- <div class="btn_wrap"> --}}
                                                {{-- <span></span> --}}
                                                <div class="social_Box" style="justify-content: normal;">
                                                    {{-- TWITTER --}}
                                                    <a class="updateSocialLinks twitter" data-social_link="twitter_link" data-social_value="{{ $businessDetails->twitter_link }}" data-placeholderLinks="https://twitter.com/page-or-account-url" >
                                                        <span><i class="fab fa-twitter add-link-social-icons" ></i></span> 
                                                    </a>
                                                    {{-- Facebook --}}
                                                    <a class="updateSocialLinks facebook" data-social_link="facebook_link" data-social_value="{{ $businessDetails->facebook_link }}" data-placeholderLinks="https://facebook.com/page-or-account-url">
                                                        <span><i class="fab fa-facebook add-link-social-icons"></i></span>
                                                    </a>
                                                    {{-- LINKEDIN --}}
                                                    <a class="updateSocialLinks linkedin" data-social_link="linkedin_link" data-social_value="{{ $businessDetails->linkedin_link }}" data-placeholderLinks="https://linkedin.com/page-or-account-url">
                                                        <span><i class="fab fa-linkedin add-link-social-icons"></i></span>
                                                    </a>
                                                </div>
                                            {{-- </div> --}}
                                        {{-- </div> --}}
                                    {{-- </div>
                                </div>
                            </div> --}}
                        </div>
                    </div> -->

                    <div class="card_ mt-3">
                        <div class="card-body_">
                            <ul class="nav nav-pills" id="offers_list" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link social-post" id="scheduled" data-toggle="tab" href="#scheduled_tab" role="tab" aria-controls="scheduled" aria-selected="true">Scheduled <span class="badge py-1 px-2">{{ count($scheduled) }}</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link social-post" id="unscheduled" data-toggle="tab" href="#unscheduled_tab" role="tab" aria-controls="unscheduled" aria-selected="false">Unscheduled <span class="badge py-1 px-2">{{ count($unscheduled) }}</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link social-post" id="posted" data-toggle="tab" href="#posted_tab" role="tab" aria-controls="posted" aria-selected="false">Posted <span class="badge py-1 px-2">{{ count($posted) }}</span></a>
                                </li>
                            </ul>
                          <div class="tab-content" id="tab_offers_list">

                            {{-- Scheduled Offers list --}}
                            <div class="tab-pane fade social-post-tab" id="scheduled_tab" role="tabpanel" aria-labelledby="scheduled">
                                <div class="ofrs_list">
                                    <div class="ofr-main-card">
                                        {{-- single offer  --}}

                                        @forelse ($scheduled as $s_offer)
                                            @php
                                                if($s_offer->type != 'custom'){
                                                    $preview_url = route("business.offerPreview", $s_offer->id);
                                                }else{
                                                    $preview_url = route("business.customOfferPreview", $s_offer->id);
                                                }

                                                if($s_offer->type == 'custom'){
                                                    if($s_offer->website_url != ''){
                                                        $img_url = asset('assets/img/default_website_img.jpg');
                                                        $preview_img_url = asset('assets/img/default_website_img.jpg');
                                                    }else{
                                                        $img_url = asset('assets/templates/custom').'/'.$s_offer->image;
                                                        $preview_img_url = asset('assets/templates/resize-file/fb-resize-').$s_offer->image;
                                                    }
                                                    
                                                }else{
                                                    $img_url = asset('assets/offer-thumbnails').'/'.$s_offer->offer_template->thumbnail;
                                                    $preview_img_url = asset('assets/templates/resize-file/fb-resize-').$s_offer->offer_template->thumbnail;
                                                }

                                                $status = 'Upcoming';
                                                $now = \Carbon\Carbon::now()->format("Y-m-d");
                                                $start_date = date('Y-m-d', strtotime($s_offer->start_date));
                                                $end_date = date('Y-m-d', strtotime($s_offer->end_date));

                                                if($start_date <= $now && $now <= $end_date ){
                                                    $status = 'On Going';
                                                }

                                                $taskOfferIds = $taskIds = [];
                                                foreach ($s_offer->getInstantTasks as $taskKey => $instantTask) {
                                                    $taskOfferIds[]=$instantTask->offer_id;
                                                    $taskIds[]=$instantTask->task_id;
                                                }

                                            @endphp
                                            {{-- <a href="{{ $preview_url }}" class="hover-to-cal" data-startdate="{{ \Carbon\Carbon::parse($s_offer->start_date)->format('Y-m-d') }}" data-toggle="tooltip" title="Click to Preview Offer"> --}}
                                                <div class="ofr-card">
                                                    <div class="ofr-img preview-on-click" data-preview_img="{{ $preview_img_url }}" style="background-image: url('{{ $img_url }}');"> </div>
                                                    <div class="ofr-body">
                                                        <div class="ofr-body-inner">
                                                            <div class="mb-2">
                                                                <p class="ofr-title mb-0">{{ $s_offer->title }}</p>

                                                                @php
                                                                    $description = isset($s_offer->description) ? $s_offer->description : "";  
                                                                    $description = str_replace("\n", " ", $description );
                                                                    $description = str_replace("\r", " ", $description );
                                                                    $description = str_replace("<br />", " ", $description );
                                                                @endphp

                                                                <p class="ofr-description" style="display: none">{!! $description !!}</p>
                                                            </div>
                                                            <div class="mb-2">
                                                                <span class="badge badge-success py-1">{{ $status }}</span> 
                                                                <!-- <span class="badge badge-success py-1">Posted</span> -->
                                                            </div>
                                                            <div>
                                                                <div class="ofr-date-flex">
                                                                    <p class="mb-0">Start: <strong class="text-primary">{{ \Carbon\Carbon::parse($s_offer->start_date)->format('j M, Y') }}</strong></p>
                                                                    <p class="mb-0">End: <strong class="text-primary">{{ \Carbon\Carbon::parse($s_offer->end_date)->format('j M, Y') }}</strong></p>
                                                                </div> 
                                                            </div>
                                                            <div class="d-flex justify-content-between mt-2 align-items-center">
                                                                <div class="btn_wrap">
                                                                    <div class="social_Box">
                                                                        @php
                                                                            $otherPlatformKey="";
                                                                        @endphp

                                                                        @foreach($s_offer->socialPost->social_platforms as $platformKey => $platform)

                                                                            @if(in_array($platform->platform_key, $activeUserSocialPlatform))
                                                                                @if($platform->platform_key=="twitter")
                                                                                    @php
                                                                                        $isTwitterShow=1;
                                                                                        $isTwitterDisable=0;
                                                                                        $isTwitterShowNotConnectedPopup=1;
                                                                                        if($isSocialPost!=0){
                                                                                            
                                                                                            if(isset($userSocialConnection->is_twitter_auth) && @$userSocialConnection->is_twitter_auth!=null){
                                                                                                // $isTwitterShow=0;
                                                                                                // $isTwitterDisable=1;
                                                                                                $isTwitterShowNotConnectedPopup=0;
                                                                                            }
                                                                                        }

                                                                                        $is_posted = false;
                                                                                        if(in_array('7', $taskIds) && in_array($s_offer->id, $taskOfferIds)){
                                                                                            $is_posted = true;
                                                                                        }

                                                                                        $manual_post_twitter = "";
                                                                                        if($s_offer->type == "custom"){
                                                                                            if($s_offer->website_url != ''){
                                                                                                $manual_post_twitter = "https://www.twitter.com/intent/tweet?url=".$s_offer->website_url."?media=".$platform->value;
                                                                                            }
                                                                                            else{
                                                                                                $manual_post_twitter = "https://www.twitter.com/intent/tweet?url=".$domain."/f/".$s_offer->uuid."?media=".$platform->value;
                                                                                            }
                                                                                        }
                                                                                        else{
                                                                                            $manual_post_twitter = "https://www.twitter.com/intent/tweet?url=".$domain."/f/".$s_offer->uuid."?media=".$platform->value;
                                                                                        }
                                                                                    @endphp

                                                                                    @if($isTwitterShow==1)
                                                                                        <a data-manual_post="{{$manual_post_twitter}}" data-offer_id="{{ encrypt($s_offer->id) }}" data-taskKey="{{ encrypt($platform->platform_key) }}" data-offer_type="scheduled" data-btnId="twitter_id_{{ $s_offer->id }}" data-platform="{{ $platform->platform_key }}" class="@if($isTwitterDisable==1 || $is_posted == true) disabled @elseif($status == 'Upcoming') showUpcomingPopup @elseif($isTwitterShowNotConnectedPopup==1) showNotConnectedPopup @else postToSocialLink @endif {{$platform->platform_key}}" id="twitter_id_{{ $s_offer->id }}" >
                                                                                            <i class="fab fa-twitter socialImg"></i>
                                                                                        </a>
                                                                                    @endif

                                                                                @endif

                                                                                @if($platform->platform_key == "facebook")
                                                                                    @php
                                                                                        $isFacebookShow=1;
                                                                                        $isFacebookDisable=0;
                                                                                        $isFacebookShowNotConnectedPopup=1;
                                                                                        if($isSocialPost!=0){
                                                                                            if(isset($userSocialConnection->is_facebook_auth) && @$userSocialConnection->is_facebook_auth==null || @$userSocialConnection->facebook_page_id!=null){
                                                                                                // $isFacebookShow=0;
                                                                                                // $isFacebookDisable=1;
                                                                                                $isFacebookShowNotConnectedPopup=0;
                                                                                            }
                                                                                        }

                                                                                        $is_posted = false;
                                                                                        if((in_array('2', $taskIds) || in_array('3', $taskIds) || in_array('15', $taskIds)) && in_array($s_offer->id, $taskOfferIds)){
                                                                                            $is_posted = true;
                                                                                        }

                                                                                        $manual_post_facebook = "";
                                                                                        if($s_offer->type == "custom"){
                                                                                            if($s_offer->website_url != ''){
                                                                                                $manual_post_facebook = "https://www.facebook.com/sharer.php?u=".$s_offer->website_url."?media=".$platform->value;
                                                                                            }
                                                                                            else{
                                                                                                $manual_post_facebook = "https://www.facebook.com/sharer.php?u=".$domain."/f/".$s_offer->uuid."?media=".$platform->value;
                                                                                            }
                                                                                        }
                                                                                        else{
                                                                                            $manual_post_facebook = "https://www.facebook.com/sharer.php?u=".$domain."/f/".$s_offer->uuid."?media=".$platform->value;
                                                                                        }
                                                                                    @endphp
                                                                                    
                                                                                    @if($isFacebookShow==1)
                                                                                        <a data-manual_post="{{$manual_post_facebook}}" data-offer_id="{{ encrypt($s_offer->id) }}" data-taskKey="{{ encrypt($platform->platform_key) }}" data-offer_type="scheduled" data-btnId="facebook_id_{{ $s_offer->id }}" data-platform="{{ $platform->platform_key }}" class="@if($isFacebookDisable==1 || $is_posted == true) disabled @elseif($status == 'Upcoming') showUpcomingPopup @elseif($isFacebookShowNotConnectedPopup==1) showNotConnectedPopup @else postToSocialLink @endif {{$platform->platform_key}}" id="facebook_id_{{ $s_offer->id }}" ><i class="fab fa-facebook socialImg"></i></a>
                                                                                    @endif
                                                                                @endif
                                                                                
                                                                                {{--
                                                                                @if($platform->platform_key=="linkedin")
                                                                                    @php
                                                                                        $isLinkedinShow=1;
                                                                                        $isLinkedinDisable=0;
                                                                                        $isLinkedinShowNotConnectedPopup=1;
                                                                                        if($isSocialPost!=0){
                                                                                            if(isset($userSocialConnection->is_linkedin_auth) && @$userSocialConnection->is_linkedin_auth!=null || @$userSocialConnection->linkedin_page_id!=null){
                                                                                                // $isLinkedinShow=0;
                                                                                                // $isLinkedinDisable=1;
                                                                                                $isLinkedinShowNotConnectedPopup=0;
                                                                                            }
                                                                                        }

                                                                                        $is_posted = false;
                                                                                        if((in_array('9', $taskIds)) && in_array($s_offer->id, $taskOfferIds)){
                                                                                            $is_posted = true;
                                                                                        }

                                                                                        $manual_post_linkedin = "";
                                                                                        if($s_offer->type == "custom"){
                                                                                            if($s_offer->website_url != ''){
                                                                                                $manual_post_linkedin = "https://www.linkedin.com/sharing/share-offsite/?url=".$s_offer->website_url."?media%3D".$platform->value;
                                                                                            }
                                                                                            else{
                                                                                                $manual_post_linkedin = "https://www.linkedin.com/sharing/share-offsite/?url=".$domain."/f/".$s_offer->uuid."?media=".$platform->value;
                                                                                            }
                                                                                        }
                                                                                        else{
                                                                                            $manual_post_linkedin = "https://www.linkedin.com/sharing/share-offsite/?url=".$domain."/f/".$s_offer->uuid."?media=".$platform->value;
                                                                                        }
                                                                                    @endphp
                                                                                    
                                                                                    @if($isLinkedinShow==1)
                                                                                        <a data-manual_post="{{$manual_post_linkedin}}" data-offer_id="{{ encrypt($s_offer->id) }}" data-taskKey="{{ encrypt($platform->platform_key) }}" data-offer_type="scheduled" data-btnId="linkedin_id_{{ $s_offer->id }}" data-platform="{{ $platform->platform_key }}" class="@if($isLinkedinDisable==1 || $is_posted == true) disabled @elseif($status == 'Upcoming') showUpcomingPopup @elseif($isLinkedinShowNotConnectedPopup==1) showNotConnectedPopup @else postToSocialLink @endif {{$platform->platform_key}}" id="linkedin_id_{{ $s_offer->id }}" ><i class="fab fa-linkedin socialImg"></i></a>
                                                                                    @endif
                                                                                @endif                     
                                                                                --}}
                                                                                
                                                                                @if($s_offer->website_url == '')
                                                                                    @if($platform->platform_key=="instagram")
                                                                                        @php
                                                                                            $isCustomWebsiteOffer = 0;
                                                                                            $isInstagramShow=1;
                                                                                            $isInstagramDisable=0;
                                                                                            $isInstagramShowNotConnectedPopup=1;
                                                                                            if($isSocialPost!=0){
                                                                                                if(isset($userSocialConnection->is_instagram_auth) && @$userSocialConnection->is_instagram_auth!=null){
                                                                                                    // $isInstagramShow=0;
                                                                                                    // $isInstagramDisable=1;
                                                                                                    $isInstagramShowNotConnectedPopup=0;
                                                                                                }
                                                                                            }

                                                                                            $is_posted = false;
                                                                                            if((in_array('5', $taskIds)) && in_array($s_offer->id, $taskOfferIds)){
                                                                                                $is_posted = true;
                                                                                            }

                                                                                            $manual_post_instagram = "";
                                                                                            if($s_offer->type == "custom"){
                                                                                                if($s_offer->website_url != ''){
                                                                                                    $manual_post_instagram = "https://www.instagram.com/";
                                                                                                }
                                                                                                else{
                                                                                                    $manual_post_instagram = "https://www.instagram.com/";
                                                                                                }
                                                                                            }
                                                                                            else{
                                                                                                $manual_post_instagram = "https://www.instagram.com/";
                                                                                            }

                                                                                            if($s_offer->type=="custom" && $s_offer->website_url != ''){
                                                                                                $isCustomWebsiteOffer = 1;
                                                                                            }
                                                                                        @endphp        

                                                                                        @if($isInstagramShow==1)
                                                                                            <a data-custom_website_offer="{{ $isCustomWebsiteOffer }}" data-manual_post="{{$manual_post_instagram}}" data-offer_id="{{ encrypt($s_offer->id) }}" data-taskKey="{{ encrypt($platform->platform_key) }}" data-offer_type="scheduled" data-btnId="instagram_id_{{ $s_offer->id }}" data-platform="{{ $platform->platform_key }}" class="@if($isInstagramDisable==1 || $is_posted == true) disabled @elseif($status == 'Upcoming') showUpcomingPopup @elseif($isInstagramShowNotConnectedPopup==1) showNotConnectedPopup @else postToSocialLink @endif {{$platform->platform_key}}" id="instagram_id_{{ $s_offer->id }}" ><i class="fab fa-instagram socialImg"></i></a>
                                                                                        @endif
                                                                                    @endif
                                                                                @endif
                                                                            @endif

                                                                            @php
                                                                                if($platform->platform_key == "other"){
                                                                                    $otherPlatformKey = $platform->value;
                                                                                }
                                                                            @endphp
                                                                        @endforeach

                                                                        {{-- <a data-custom_website_offer="" data-manual_post="" data-offer_id="" data-taskKey="" data-offer_type="scheduled" data-btnId="" data-platform="" class="youtube" id="youtube_id_" >
                                                                            <i class="fab fa-youtube socialImg"></i>
                                                                        </a> --}}
                                                                    </div>                      
                                                                </div>
                                                                <div class="ml-2 action_button">        
                                                                    <a href="{{ $domain}}/f/{{$s_offer->uuid}}?media={{ $otherPlatformKey }}" class="btn btn-sm btnCopy" data-toggle="tooltip" title="" data-original-title="Copy Url"><i class="fas fa-copy"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            {{-- </a> --}}
                                        @empty
                                            <div class="no_recored text-center py-3">
                                                <h6 class="mb-0"> {{ Config::get('constants.no_record_found') }}</h6>
                                            </div>
                                        @endforelse
                                    </div>
                                    {{-- offer END  --}}
                                </div>
                            </div>
                            {{-- Scheduled Offer List - END --}}

                            {{-- Un-scheduled offers  --}}
                            <div class="tab-pane fade social-post-tab" id="unscheduled_tab" role="tabpanel" aria-labelledby="unscheduled">
                                <div class="ofrs_list">
                                    <div class="ofr-main-card">
                                        {{-- single offer  --}}
                                        @forelse ($unscheduled as $u_offer)
                                            @php
                                                if($u_offer->type != 'custom'){
                                                    $preview_url = route("business.offerPreview", $u_offer->id);
                                                }else{
                                                    $preview_url = route("business.customOfferPreview", $u_offer->id);
                                                }

                                                if($u_offer->type == 'custom'){
                                                    if($u_offer->website_url != ''){
                                                        $img_url = asset('assets/img/default_website_img.jpg');
                                                        $preview_img_url = asset('assets/img/default_website_img.jpg');
                                                    }else{
                                                        $img_url = asset('assets/templates/custom').'/'.$u_offer->image;
                                                        $preview_img_url = asset('assets/templates/resize-file/fb-resize-').$u_offer->image;
                                                    }
                                                    
                                                }else{
                                                    $img_url = asset('assets/offer-thumbnails').'/'.$u_offer->offer_template->thumbnail;
                                                    $preview_img_url = asset('assets/templates/resize-file/fb-resize-').$u_offer->offer_template->thumbnail;
                                                }

                                                $status = 'Upcoming';
                                                $now = \Carbon\Carbon::now()->format("Y-m-d");
                                                $start_date = date('Y-m-d', strtotime($u_offer->start_date));
                                                $end_date = date('Y-m-d', strtotime($u_offer->end_date));

                                                if($start_date <= $now && $now <= $end_date ){
                                                    $status = 'On Going';
                                                }
                                            @endphp
                                            {{-- <a href="{{ $preview_url }}" data-toggle="tooltip" title="Click to Preview Offer"> --}}
                                                <div class="ofr-card">
                                                    <div class="ofr-img preview-on-click" data-preview_img="{{ $preview_img_url }}"  style="background-image: url('{{ $img_url }}');"> </div>
                                                    <div class="ofr-body">
                                                        <div class="ofr-body-inner">
                                                            <div class="mb-2">
                                                                <p class="ofr-title">{{ $u_offer->title }}</p>

                                                                @php
                                                                    $description = isset($u_offer->description) ? $u_offer->description : "";  
                                                                    $description = str_replace("\n", " ", $description );
                                                                    $description = str_replace("\r", " ", $description );
                                                                    $description = str_replace("<br />", " ", $description );
                                                                @endphp

                                                                <p class="ofr-description" style="display: none">{!! $description !!}</p>

                                                            </div>
                                                            <div class="mb-2">
                                                                <!-- <span class="badge badge-info py-1" id="Socialpost_popup">Post Now</span> -->
                                                                {{-- <button class="btn btn-primary postBtnBagde" data-toggle="modal" data-target="#Socialpost_popup" data-backdrop="static" data-keyboard="false">Post Now</button>  --}}
                                                                <button class="btn btn-primary postBtnBagde" >Post Now</button> 
                                                            </div>
                                                            <div class="d-flex justify-content-between mt-2 align-items-center">
                                                                <div class="btn_wrap">
                                                                    <span></span>
                                                                    <div class="social_Box">
                                                                        @php
                                                                            $otherPlatformKey="";
                                                                        @endphp
                                                                        @foreach($u_offer->socialPost->social_platforms as $platformKey => $platform)

                                                                            @if(in_array($platform->platform_key, $activeUserSocialPlatform))

                                                                                @if($platform->platform_key=="twitter")
                                                                                    @php
                                                                                        $isTwitterShow=1;
                                                                                        $isTwitterDisable=0;
                                                                                        $isTwitterShowNotConnectedPopup=1;
                                                                                        if($isSocialPost!=0){
                                                                                            if(isset($userSocialConnection->is_twitter_auth) && @$userSocialConnection->is_twitter_auth!=null){
                                                                                                // $isTwitterShow=0;
                                                                                                // $isTwitterDisable=1;
                                                                                                $isTwitterShowNotConnectedPopup=0;
                                                                                            }
                                                                                        }

                                                                                        $manual_post_twitter = "";
                                                                                        if($u_offer->type == "custom"){
                                                                                            if($u_offer->website_url != ''){
                                                                                                $manual_post_twitter = "https://www.twitter.com/intent/tweet?url=".$u_offer->website_url."?media=".$platform->value;
                                                                                            }
                                                                                            else{
                                                                                                $manual_post_twitter = "https://www.twitter.com/intent/tweet?url=".$domain."/f/".$u_offer->uuid."?media=".$platform->value;
                                                                                            }
                                                                                        }
                                                                                        else{
                                                                                            $manual_post_twitter = "https://www.twitter.com/intent/tweet?url=".$domain."/f/".$u_offer->uuid."?media=".$platform->value;
                                                                                        }
                                                                                    @endphp

                                                                                    @if($isTwitterShow==1)
                                                                                        <a data-manual_post="{{$manual_post_twitter}}" data-offer_id="{{ encrypt($u_offer->id) }}" data-taskKey="{{ encrypt($platform->platform_key) }}" data-offer_type="unscheduled" class="@if($isTwitterDisable==1) disabled @elseif($isTwitterShowNotConnectedPopup) showNotConnectedPopup @else postToSocialLink @endif {{$platform->platform_key}}" ><i class="fab fa-twitter socialImg"></i></a>
                                                                                    @endif
                                                                                @endif

                                                                                @if($platform->platform_key == "facebook")
                                                                                    @php
                                                                                        $isFacebookShow=1;
                                                                                        $isFacebookDisable=0;
                                                                                        $isFacebookShowNotConnectedPopup=1;
                                                                                        if($isSocialPost!=0){
                                                                                            
                                                                                            if(isset($userSocialConnection->is_facebook_auth) && @$userSocialConnection->is_facebook_auth!=null || @$userSocialConnection->facebook_page_id!=null){
                                                                                                // $isFacebookShow=0;
                                                                                                // $isFacebookDisable=1;
                                                                                                $isFacebookShowNotConnectedPopup=0;
                                                                                            }
                                                                                        }

                                                                                        $manual_post_facebook = "";
                                                                                        if($u_offer->type == "custom"){
                                                                                            if($u_offer->website_url != ''){
                                                                                                $manual_post_facebook = "https://www.facebook.com/sharer.php?u=".$u_offer->website_url."?media=".$platform->value;
                                                                                            }
                                                                                            else{
                                                                                                $manual_post_facebook = "https://www.facebook.com/sharer.php?u=".$domain."/f/".$u_offer->uuid."?media=".$platform->value;
                                                                                            }
                                                                                        }
                                                                                        else{
                                                                                            $manual_post_facebook = "https://www.facebook.com/sharer.php?u=".$domain."/f/".$u_offer->uuid."?media=".$platform->value;
                                                                                        }
                                                                                    @endphp
                                                                                    
                                                                                    @if($isFacebookShow==1)
                                                                                        <a data-manual_post="{{$manual_post_facebook}}" data-offer_id="{{ encrypt($u_offer->id) }}" data-taskKey="{{ encrypt($platform->platform_key) }}" data-offer_type="unscheduled" class="@if($isFacebookDisable==1) disabled @elseif($isFacebookShowNotConnectedPopup==1) showNotConnectedPopup @else postToSocialLink @endif {{$platform->platform_key}}" ><i class="fab fa-facebook socialImg"></i></a>
                                                                                    @endif
                                                                                @endif
                                                                                
                                                                                {{-- @if($platform->platform_key == "linkedin" && $businessDetails->linkedin_link != null) --}}

                                                                                {{--
                                                                                @if($platform->platform_key=="linkedin")
                                                                                    @php
                                                                                        $isLinkedinShow=1;
                                                                                        $isLinkedinDisable=0;
                                                                                        $isLinkedinShowNotConnectedPopup=1;
                                                                                        if($isSocialPost!=0){
                                                                                            if(isset($userSocialConnection->is_linkedin_auth) &&  @$userSocialConnection->is_linkedin_auth!=null || @$userSocialConnection->linkedin_page_id!=null){
                                                                                                // $isLinkedinShow=0;
                                                                                                // $isLinkedinDisable=1;
                                                                                                $isLinkedinShowNotConnectedPopup=0;
                                                                                            }
                                                                                        }

                                                                                        $manual_post_linkedin = "";
                                                                                        if($u_offer->type == "custom"){
                                                                                            if($u_offer->website_url != ''){
                                                                                                $manual_post_linkedin = "https://www.linkedin.com/sharing/share-offsite/?url=".$u_offer->website_url."?media%3D".$platform->value;
                                                                                            }
                                                                                            else{
                                                                                                $manual_post_linkedin = "https://www.linkedin.com/sharing/share-offsite/?url=".$domain."/f/".$u_offer->uuid."?media=".$platform->value;
                                                                                            }
                                                                                        }
                                                                                        else{
                                                                                            $manual_post_linkedin = "https://www.linkedin.com/sharing/share-offsite/?url=".$domain."/f/".$u_offer->uuid."?media=".$platform->value;
                                                                                        }
                                                                                    @endphp

                                                                                    @if($isLinkedinShow==1)
                                                                                        <a data-manual_post="{{$manual_post_linkedin}}" data-offer_id="{{ encrypt($u_offer->id) }}" data-taskKey="{{ encrypt($platform->platform_key) }}" data-offer_type="unscheduled" class="@if($isLinkedinDisable==1) disabled @elseif($isLinkedinShowNotConnectedPopup==1) showNotConnectedPopup @else postToSocialLink @endif {{$platform->platform_key}}" ><i class="fab fa-linkedin socialImg"></i></a>
                                                                                    @endif
                                                                                @endif
                                                                                --}}

                                                                                @if($u_offer->website_url == '')
                                                                                    @if($platform->platform_key=="instagram")
                                                                                        @php
                                                                                            $isCustomWebsiteOffer = 0;
                                                                                            $isInstagramShow=1;
                                                                                            $isInstagramDisable=0;
                                                                                            $isInstagramShowNotConnectedPopup=1;
                                                                                            if($isSocialPost!=0){
                                                                                                if(isset($userSocialConnection->is_instagram_auth) && @$userSocialConnection->is_instagram_auth!=null){
                                                                                                    // $isInstagramShow=0;
                                                                                                    // $isInstagramDisable=1;
                                                                                                    $isInstagramShowNotConnectedPopup=0;
                                                                                                }
                                                                                            }

                                                                                            $manual_post_instagram = "";
                                                                                            if($u_offer->type == "custom"){
                                                                                                if($u_offer->website_url != ''){
                                                                                                    $manual_post_instagram = "https://www.instagram.com/";
                                                                                                }
                                                                                                else{
                                                                                                    $manual_post_instagram = "https://www.instagram.com/";
                                                                                                }
                                                                                            }
                                                                                            else{
                                                                                                $manual_post_instagram = "https://www.instagram.com/";
                                                                                            }

                                                                                            if($u_offer->type=="custom" && $u_offer->website_url != ''){
                                                                                                $isCustomWebsiteOffer = 1;
                                                                                            }
                                                                                        @endphp        

                                                                                        @if($isInstagramShow==1)
                                                                                            <a data-custom_website_offer="{{ $isCustomWebsiteOffer }}" data-manual_post="{{$manual_post_instagram}}" data-offer_id="{{ encrypt($u_offer->id) }}" data-taskKey="{{ encrypt($platform->platform_key) }}" data-offer_type="unscheduled" class="@if($isInstagramDisable==1) disabled @elseif($isInstagramShowNotConnectedPopup==1) showNotConnectedPopup @else postToSocialLink @endif {{$platform->platform_key}}" >
                                                                                                <i class="fab fa-instagram socialImg"></i></a>
                                                                                        @endif
                                                                                    @endif
                                                                                @endif
                                                                            @endif

                                                                            @php
                                                                                if($platform->platform_key == "other"){
                                                                                    $otherPlatformKey = $platform->value;
                                                                                }
                                                                            @endphp
                                                                            
                                                                        @endforeach

                                                                        {{-- <a data-custom_website_offer="" data-manual_post="" data-offer_id="" data-taskKey="" data-offer_type="unscheduled" class="youtube">
                                                                            <i class="fab fa-youtube socialImg"></i></a> --}}
                                                                    </div>                      
                                                                </div>
                                                                <div class="ml-2 action_button">        
                                                                    <a href="{{ $domain}}/f/{{$u_offer->uuid}}?media={{ $otherPlatformKey }}" class="btn btn-sm btnCopy" data-toggle="tooltip" title="" data-original-title="Copy Url"><i class="fas fa-copy"></i></a>
                                                                </div>
                                                            </div>                                                  
                                                        </div>
                                                    </div>
                                                </div>
                                            {{-- </a> --}}
                                        @empty
                                            <div class="no_recored text-center py-3">
                                                <h6 class="mb-0"> {{ Config::get('constants.no_record_found') }}</h6>
                                            </div>
                                        @endforelse
                                        {{-- offer END  --}}

                                    </div>
                                </div>
                            </div>
                            {{-- UN-Secheduled offer - END --}}
                            
                            {{-- Posted offer --}}
                            <div class="tab-pane fade social-post-tab" id="posted_tab" role="tabpanel" aria-labelledby="posted">
                                <div class="ofrs_list">
                                    <div class="ofr-main-card">
                                        {{-- single offer  --}}
                                        @forelse ($posted as $e_offer)
                                            @php
                                                if($e_offer->type != 'custom'){
                                                    $preview_url = route("business.offerPreview", $e_offer->id);
                                                }else{
                                                    $preview_url = route("business.customOfferPreview", $e_offer->id);
                                                }
                                                
                                                if($e_offer->type == 'custom'){
                                                    if($e_offer->website_url != ''){
                                                        $img_url = asset('assets/img/default_website_img.jpg');
                                                        $preview_img_url = asset('assets/img/default_website_img.jpg');
                                                    }else{
                                                        $img_url = asset('assets/templates/custom').'/'.$e_offer->image;
                                                        $preview_img_url = asset('assets/templates/resize-file/fb-resize-').$e_offer->image;
                                                    }
                                                    
                                                }else{
                                                    $img_url = asset('assets/offer-thumbnails').'/'.$e_offer->offer_template->thumbnail;
                                                    $preview_img_url = asset('assets/templates/resize-file/fb-resize-').$e_offer->offer_template->thumbnail;
                                                }

                                                $start_date = date('Y-m-d', strtotime($e_offer->start_date));
                                                $end_date = date('Y-m-d', strtotime($e_offer->end_date));

                                                $taskOfferIds = $taskIds = [];
                                                foreach ($e_offer->getInstantTasks as $taskKey => $instantTask) {
                                                    $taskOfferIds[]=$instantTask->offer_id;
                                                    $taskIds[]=$instantTask->task_id;
                                                }
                                            @endphp
                                            {{-- <a href="{{ $preview_url }}" data-toggle="tooltip" title="Click to Preview Offer"> --}}
                                                <div class="ofr-card">
                                                    <div class="ofr-img preview-on-click" data-preview_img="{{ $preview_img_url }}"  style="background-image: url('{{ $img_url }}');"> </div>
                                                    <div class="ofr-body">
                                                        <div class="ofr-body-inner">
                                                            <div class="mb-2">
                                                                <p class="ofr-title">{{ $e_offer->title }}</p>

                                                                @php
                                                                    $description = isset($e_offer->description) ? $e_offer->description : "";  
                                                                    $description = str_replace("\n", " ", $description );
                                                                    $description = str_replace("\r", " ", $description );
                                                                    $description = str_replace("<br />", " ", $description );
                                                                @endphp
                                                                <p class="ofr-description" style="display: none">{!! $description !!}</p>

                                                            </div>
                                                            <div class="mb-2">
                                                                <span class="badge badge-success py-1">Posted</span>
                                                                @if($e_offer->end_date < \Carbon\Carbon::now()->format("Y-m-d"))
                                                                    <span class="badge badge-danger py-1">Expired</span>
                                                                @endif
                                                            </div>

                                                            @if($e_offer->start_date != null && $e_offer->end_date)
                                                                <div>
                                                                    <div class="ofr-date-flex">
                                                                        <p class="mb-0">Start: <strong class="text-primary">{{ \Carbon\Carbon::parse($e_offer->start_date)->format('j M, Y') }}</strong></p>
                                                                        <p class="mb-0">End: <strong class="text-primary">{{ \Carbon\Carbon::parse($e_offer->end_date)->format('j M, Y') }}</strong></p>
                                                                    </div> 
                                                                </div>
                                                            @endif
                                                        
                                                            <div class="d-flex justify-content-between mt-2 align-items-center">
                                                                <div class="btn_wrap">
                                                                    <span></span>
                                                                    <div class="social_Box">
                                                                        @php
                                                                            $otherPlatformKey="";
                                                                        @endphp
                                                                        @foreach($e_offer->socialPost->social_platforms as $platformKey => $platform)

                                                                            @if($platform->platform_key == "twitter")
                                                                                {{-- check posted or not --}}
                                                                                @php
                                                                                    $is_posted = false;
                                                                                    if((in_array(7, $taskIds)) && in_array($e_offer->id,$taskOfferIds)){
                                                                                        // echo "check posted or not";
                                                                                        $is_posted = true;
                                                                                    }
                                                                                @endphp

                                                                                @if($is_posted == true)
                                                                                    <a data-offer_id="{{ encrypt($e_offer->id) }}" data-taskKey="{{ encrypt($platform->platform_key) }}" class="disabled {{$platform->platform_key}}" ><i class="fab fa-twitter socialImg"></i></a>
                                                                                @endif
                                                                            @endif

                                                                            @if($platform->platform_key == "facebook")
                                                                                {{-- check posted or not --}}
                                                                                @php
                                                                                    $is_posted = false;
                                                                                    if((in_array(2, $taskIds) || in_array(3, $taskIds)) && in_array($e_offer->id,$taskOfferIds)){
                                                                                        // echo "check posted or not";
                                                                                        $is_posted = true;
                                                                                    }
                                                                                @endphp

                                                                                @if($is_posted == true)
                                                                                    <a data-offer_id="{{ encrypt($e_offer->id) }}" data-taskKey="{{ encrypt($platform->platform_key) }}" class="disabled {{$platform->platform_key}}" ><i class="fab fa-facebook socialImg"></i></a>
                                                                                @endif
                                                                            @endif
                                                                            
                                                                            {{-- 
                                                                            @if($platform->platform_key == "linkedin")
                                                                                @php
                                                                                    $is_posted = false;
                                                                                    if((in_array(9, $taskIds)) && in_array($e_offer->id,$taskOfferIds)){
                                                                                        // echo "check posted or not";
                                                                                        $is_posted = true;
                                                                                    }
                                                                                @endphp

                                                                                @if($is_posted == true)
                                                                                    <a data-offer_id="{{ encrypt($e_offer->id) }}" data-taskKey="{{ encrypt($platform->platform_key) }}" class="disabled {{$platform->platform_key}}" ><i class="fab fa-linkedin socialImg"></i></a>
                                                                                @endif
                                                                            @endif
                                                                            --}}

                                                                            @if($e_offer->website_url == '')
                                                                                @if($platform->platform_key == "instagram")
                                                                                    @php
                                                                                        $is_posted = false;
                                                                                        if((in_array(5, $taskIds)) && in_array($e_offer->id,$taskOfferIds)){
                                                                                            $is_posted = true;
                                                                                        }
                                                                                    @endphp

                                                                                    @if($is_posted == true)
                                                                                        <a data-offer_id="{{ encrypt($e_offer->id) }}" data-taskKey="{{ encrypt($platform->platform_key) }}" class="disabled {{$platform->platform_key}}" >
                                                                                            <i class="fab fa-instagram socialImg"></i></a>
                                                                                    @endif
                                                                                @endif
                                                                            @endif

                                                                            @php
                                                                                if($platform->platform_key == "other"){
                                                                                    $otherPlatformKey = $platform->value;
                                                                                }
                                                                            @endphp
                                                                        @endforeach
                                                                        
                                                                        {{-- <a data-offer_id="" data-taskKey="" class="disabled " >
                                                                            <i class="fab fa-youtube socialImg"></i></a> --}}
                                                                    </div>                      
                                                                </div>
                                                                <div class="ml-2 action_button">        
                                                                    <a href="{{ $domain }}/f/{{$e_offer->uuid}}?media={{ $otherPlatformKey }}" class="btn btn-sm btnCopy" data-toggle="tooltip" title="" data-original-title="Copy Url"><i class="fas fa-copy"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            {{-- </a> --}}
                                        @empty
                                            <div class="no_recored text-center py-3">
                                                <h6 class="mb-0"> {{ Config::get('constants.no_record_found') }}</h6>
                                            </div>
                                        @endforelse
                                        {{-- offer END  --}}
                                    </div>
                                </div>
                            </div>
                            {{-- Posted offer - END --}}
                          </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- social post modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="Socialpost_popup">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <p class="mb-1 h6 text-center">Do you want to schedule this post?</p>
                <!--  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button> --> 
            </div>
            <div class="modal-body">
                
                <div class="row justify-content-center">

                    <!-- social box with toggle -->
                    <div class="socialmedia_select">
                        <div class="multiple">
                            <ul>
                              <li>
                                <div class="button fb">
                                  <input type="checkbox">
                                  <div>
                                    <div>
                                      <svg viewBox="0 0 300 300">
                                        <path d="M163.988278,238 L163.988278,158.174748 L190.783087,158.174748 L194.794624,127.064872 L163.988278,127.064872 L163.988278,107.202592 C163.988278,98.1955566 166.489117,92.0577667 179.405739,92.0577667 L195.879762,92.0500433 L195.879762,64.2257044 C193.029826,63.8472575 183.251223,63 171.874647,63 C148.12286,63 131.862775,77.4976035 131.862775,104.122498 L131.862775,127.064872 L105,127.064872 L105,158.174748 L131.862775,158.174748 L131.862775,238 L163.988278,238 Z"></path>
                                      </svg>
                                    </div>
                                  </div>
                                </div>
                              </li>
                              <li>
                                <div class="button tw">
                                  <input type="checkbox">
                                  <div>
                                    <div>
                                      <svg viewBox="0 0 300 300">
                                        <path d="M117.971989,221.296919 C184.008403,221.296919 220.142857,166.535014 220.142857,119.12605 C220.142857,117.585434 220.142857,116.044818 220.072829,114.504202 C227.07563,109.462185 233.168067,103.089636 238,95.8767507 C231.557423,98.7478992 224.62465,100.638655 217.341737,101.54902 C224.764706,97.1372549 230.436975,90.0644258 233.168067,81.6610644 C226.235294,85.7927171 218.532213,88.7338936 210.338936,90.3445378 C203.756303,83.3417367 194.442577,79 184.148459,79 C164.330532,79 148.22409,95.1064426 148.22409,114.92437 C148.22409,117.72549 148.57423,120.456583 149.134454,123.117647 C119.302521,121.647059 92.8319328,107.291317 75.1148459,85.5826331 C72.0336134,90.9047619 70.2829132,97.0672269 70.2829132,103.64986 C70.2829132,116.114846 76.6554622,127.109244 86.2492997,133.551821 C80.3669468,133.341737 74.8347339,131.731092 70.0028011,129.070028 L70.0028011,129.560224 C70.0028011,146.927171 82.3977591,161.492997 98.7843137,164.784314 C95.7731092,165.62465 92.6218487,166.044818 89.3305322,166.044818 C87.0196078,166.044818 84.7787115,165.834734 82.6078431,165.414566 C87.1596639,179.70028 100.464986,190.064426 116.151261,190.344538 C103.826331,200.008403 88.3501401,205.7507 71.5434174,205.7507 C68.6722689,205.7507 65.8011204,205.610644 63,205.260504 C78.8263305,215.344538 97.7338936,221.296919 117.971989,221.296919"></path>
                                      </svg>
                                    </div>
                                  </div>
                                </div>
                              </li>
                              <li>
                                <div class="button in">
                                  <input checked type="checkbox">
                                  <div>
                                    <div>
                                        <i class="fab fa-linkedin"></i>
                                    </div>
                                  </div>
                                </div>
                              </li>
                            </ul>
                          </div>
                    </div>
                    <!--//end social box with toggle -->

                    <!-- social box with icon --
                    <div class="socialmedia_select d-flex">
                        <div class="socialBoxes facebook">
                           <label>
                                <input type="checkbox" value="1" checked>
                                    <span><i class="fab fa-facebook"></i> Facebook</span>
                           </label>
                        </div>

                        <div class="socialBoxes twitter">
                           <label>
                              <input type="checkbox" value="1" checked>
                              <span><i class="fab fa-twitter"></i> Twitter</span>
                           </label>
                        </div>

                        <div class="socialBoxes linkedin">
                           <label>
                              <input type="checkbox" value="1" checked>
                              <span><i class="fab fa-linkedin"></i> Linkedin</span>
                           </label>
                        </div>
                    </div>
                    <!--// end social box with icon -->

                    <!-- <div class="socialmedia_select d-flex">
                        <div class="marSocial">
                            <input type="checkbox" id="Facebook" checked>
                            <label for="Facebook">
                                <span></span> Facebook
                            </label>
                        </div>
                        <div class="marSocial">
                            <input type="checkbox" id="Twitter" checked>
                            <label for="Twitter">
                                <span></span> Twitter
                            </label>
                        </div>
                        <div class="marSocial">
                            <input type="checkbox" id="Linkedin" checked>
                            <label for="Linkedin">
                                <span></span> Linkedin
                            </label>
                        </div>
                    </div> -->
                </div>
            </div>
            <div class="modal-footer justify-content-center pt-0">
                
                <button type="button" class="btn btn-success" data-dismiss="modal" aria-label="Close"><i class="fa fa-check"></i> Yes</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i> No</button>
            </div>
        </div>
    </div>
</div>




<!-- social post Task modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="socialpost_taskp" aria-hidden="true" data-backdrop="static" and data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <p class="mb-1 h6 text-center">Update task url</p>
                &nbsp;
                <a href="#" class="info-btn" id="updateTaskInfoIcon" data-toggle="modal" data-target="" data-backdrop="static" data-keyboard="false"><i class="fa fa-info-circle"></i></a>
                <!--  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button> --> 
            </div>
            <div class="modal-body">
                <div class="row ">
                    <input type="text" name="task_url" id="task_url" class="form-control" placeholder="Task url" />
                    <div class="error" id="showTaskErrors"></div>
                </div>
            </div>
            <div class="modal-footer justify-content-center pt-0">
                
                <button type="button" id="btnUpdateTask" class="btn btn-success" data-offer_id="" data-socialmedialTaskKey=""><i class="fa fa-check"></i> {{ __('Update') }}</button>
                <button type="button" id="skipUpdateTask" class="btn btn-danger" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i> {{ __('Skip') }}</button>
            </div>
        </div>
    </div>
</div>



<!-- update social links -->
<div class="modal fade" tabindex="-1" role="dialog" id="update_sociallink">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <p class="mb-1 h6 text-center">Update Social Link</p>
                <!--  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button> --> 
            </div>
            <div class="modal-body">
                <div class="row ">
                    <input type="text" name="social_value" id="social_value" class="form-control" />
                    <div class="error" id="showLinkErrors"></div>
                </div>
            </div>
            <div class="modal-footer justify-content-center pt-0">
                <button type="button" id="btnUpdateSocialLink" class="btn btn-success"><i class="fa fa-check"></i> {{ __('Update') }}</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i> {{ __('Cancel') }}</button>
            </div>
        </div>
    </div>
</div>


{{-- Disconnected Social Media Accounts Modal --}}
<div class="modal ol-modal popin" id="socialConnectModal" role="dialog" aria-labelledby="socialConnectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header d-block text-center">
                <h5 class="modal-title text-primary" id="socialConnectModalLabel">Social Accounts Disconnected</h5>
                <p class="mb-0">Please connect / reconnect your social accounts with {{config('app.name')}} to use Social Post.</p>
            </div>
            <div class="modal-body p-sm-5">

                <div class="d-flex flex-column">

                    @if($userSocialPlatform!=NULL)
                        @foreach ($userSocialPlatform as $key => $platform)

                            @php
                                $platform_keyname = $platform->platform_key;
                                $platform_key = 'is_'.$platform_keyname.'_auth';
                                $platform_page_id = $platform_keyname."_page_id" ?? NULL;
                                
                                if($userSocialConnection==NULL){
                                    $is_page_id = 0;
                                }
                                else{
                                    $is_page_id = $userSocialConnection->$platform_page_id ? 1 : 0;
                                }
                            @endphp
        
                            <div class="sconnect card">
                                <div class="card-body p-2">
                                    <div class="d-flex align-items-center">
                                        <div class="sc-icon">
                                            {!! $platform->icon_class_name !!}
                                            {{-- <i class="{{ $platform->icon_class_name }}" style="color: {{ $platform->icon_color_code }};"></i> --}}
                                        </div>
                                        <div class="flex-fill">
                                            <h6 class="mb-0">{{ $platform->name }}</h6>
                                            <div class="text-secondary">{{ $platform->subname }}</div>
                                        </div>
                                        <div>
                                            @if(@$userSocialConnection->$platform_key==null)
                                                @if($platform->status==1)
                                                    <a data-socialAccount="{{ $platform->social_account_name }}" class="btn btn-primary px-sm-3 @if($platform->platform_key == "google") showMsgPopup @elseif($platform->platform_key=="youtube") connect_with_youtube @else connect-to-social-media @endif text-white">Connect
                                                        <span  id="loading_icon_{{ $platform->social_account_name }}" class="ms-2" style="display:none;">
                                                            <i class="fa fa-spinner fa-2x fa-spin"></i>
                                                        </span>
                                                    </a>
                                                @else
                                                    <span data-toggle="tooltip" data-placement="right" title="Coming soon...">
                                                        {{-- <a data-socialAccount="{{ $platform->social_account_name }}" class="btn btn-primary px-sm-3 text-white disabled">Connect
                                                            <span  id="loading_icon_{{ $platform->social_account_name }}" class="ms-2" style="display:none;">
                                                                <i class="fa fa-spinner fa-2x fa-spin"></i>
                                                            </span>
                                                        </a> --}}
                                                        Coming soon..
                                                    </span>
                                                @endif
                                            @else
                                                <a class="btn btn-success px-sm-3">Connected</a>                                    
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="sconnect card">
                            <div class="card-body p-2">
                                <p>Social Platform not found!</p>
                            </div>
                        </div>
                    @endif

                    <div class="text-right">
                        <a class="btn btn-primary text-white" data-dismiss="modal" aria-label="Close" >Skip >></a>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

{{-- modal of Add users  start --}}
<div class="modal fade" id="modalConnectSocialMedia" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Connecting...</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body " style="word-break:break-all" id="authConnectSocialMedia">
                
            </div>
        </div>
    </div>
</div>
{{-- modal of Add users end --}}

@php
    $description = isset($scheduled[0]) ? @$scheduled[0]->description : "";  
    $description = str_replace("\n", " ", $description );
    $description = str_replace("\r", " ", $description );
    $description = str_replace("<br />", " ", $description );
@endphp

@endsection

@section('end_body')

@include('business.social-posts.social-media-modals')
@include('business.social-posts.social-connect-js')

<script>
    /* to show the preview of posts */
    $(document).ready(function() {
        /* Select tab */
        if(sessionStorage.getItem("social_post")){
            var tab_id = sessionStorage.getItem("social_post");
            $(".social-post").removeClass("active");
            $(".social-post").removeClass("show");

            $(".social-post-tab").removeClass("active");
            $(".social-post-tab").removeClass("show");

            $("#"+tab_id).addClass("active");
            $("#"+tab_id).addClass("show");

            $("#"+tab_id+"_tab").addClass("active");
            $("#"+tab_id+"_tab").addClass("show");
        }else{
            $("#scheduled").addClass("active");
            $("#scheduled").addClass("show");

            $("#scheduled_tab").addClass("active");
            $("#scheduled_tab").addClass("show");
        }


        /* Modal Toggle for Social Media Connect */
        var isSocialPost = '{{ $isSocialPost }}';
        if(isSocialPost!='0'){
            '<?php if(@$userSocialConnection->is_facebook_auth==null && @$userSocialConnection->is_twitter_auth==null && @$userSocialConnection->is_linkedin_auth==null && @$userSocialConnection->is_youtube_auth==null && @$userSocialConnection->is_instagram_auth==null && @$userSocialConnection->is_google_auth==null){ ?>'
                $('#socialConnectModal').modal({
                    backdrop: 'static',
                    keyboard: false,
                    show:true
                });
            '<?php } ?>'
        }


        $('.preview-on-click').on("click",  function(e) {
            var parent = $(this).parent('div.ofr-card');
            // var image = $(this).css('background-image').replace(/^url\(['"](.+)['"]\)/, '$1');
            var image = $(this).attr("data-preview_img");
            var title = parent.find('.ofr-title').text();
            var description = parent.find('.ofr-description').text();
            
            $('.preview_title').text(title);
            $('.preview_text').text(description);
            $('.preview_img').css('background-image', 'url('+image+')');
        });

        showPreview();
        function showPreview(){
            @php
                if(@$scheduled[0]->type == 'custom'){
                    if(@$scheduled[0]->website_url != ''){
                        $img_url = asset('assets/img/default_website_img.jpg');
                    }else{
                        // $img_url = asset('assets/templates/custom').'/'.@$scheduled[0]->image;
                        $img_url = asset('assets/templates/resize-file/fb-resize-').@$scheduled[0]->image;
                    }
                    
                }else{
                    // $img_url = asset('assets/offer-thumbnails').'/'.@$scheduled[0]->offer_template->thumbnail;
                    $img_url = asset('assets/templates/resize-file/fb-resize-').@$scheduled[0]->offer_template->thumbnail;
                }
            @endphp
            // var parent = $(this).parent('div.ofr-card');
            var image = '{{ @$img_url }}';
            var title = "{!! @$scheduled[0]->title !!}";
            var description = "{!! @$description !!}";
            
            $('.preview_title').text(title);
            $('.preview_text').text(description);

            $('.preview_img').css('background-image', 'url('+image+')');
        }



        // Social Post Modal
        $(document).on("click", ".socialModal", function(){
            $("#socialpost_taskp").modal("toggle");
            $("#task_url").val("");
            $("#btnUpdateTask").attr("data-socialmedialTaskKey", $(this).attr("data-taskKey"));
            $("#btnUpdateTask").attr("data-offer_id", $(this).attr("data-offer_id"));
        });

        // Social Post Modal
        $(document).on("click", "#btnUpdateTask", function(){
            var task_url = $("#task_url").val();
            var noerr = true;
            var msg = "";
            $("#showTaskErrors").html(msg);
            if(task_url == ""){
                msg += "<p>Please enter Url</p>";
                noerr = false;
            }
            else{
                msg += "<p>Please enter valid Url</p>";
                noerr = isValidURL(task_url);
            }

            if(noerr != true){
                $("#showTaskErrors").html(msg);
            }
            else{
                var offer_id = $(this).attr("data-offer_id");
                var task_key = $(this).attr("data-socialmedialtaskkey");
                var btnid = $(this).attr("data-btnid");

                var task_value = $("#task_url").val();

                $.ajax({
                    url: '{{ URL::to("business/addPostTask") }}',
                    type: 'POST',
                    dataType: "JSON",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "task_key": task_key,
                        "task_value": task_value,
                        "offer_id": offer_id
                    },
                    success: function(data) {
                        $("#task_url").val("");
                        $("#socialpost_taskp").modal("hide");
                        $("#overlay").fadeOut(300);
                        if(data.status == true){
                            Sweet('success',data.message);
                            $("#"+btnid).addClass("disabled");
                            // setTimeout(function () {
                            //     location.reload();
                            // }, 1500);
                        }else{
                            Sweet('error',data.message);
                        }
                    }
                });
            }
        });

        var elm;
        function isValidURL(u){
            if(!elm){
                elm = document.createElement('input');
                elm.setAttribute('type', 'url');
            }
            elm.value = u;
            return elm.validity.valid;
        }

        $(document).on("click", ".updateSocialLinks", function(){
            $("#btnUpdateSocialLink").attr('data-social_link', $(this).data("social_link"));
            $("#social_value").val($(this).data("social_value"));
            $("#social_value").attr('placeholder', $(this).attr("data-placeholderLinks"));

            $("#showLinkErrors").html("");
            $("#update_sociallink").modal('toggle');
        });

        // Social Post Modal
        $(document).on("click", "#btnUpdateSocialLink", function(){
            var social_value = $("#social_value").val();
            var noerr = true;
            var msg = "";
            var msg = "";
            $("#showLinkErrors").html(msg);
            if(social_value == ""){
                msg += "<p>Please enter Url</p>";
                noerr = false;
            }
            else{
                msg += "<p>Please enter valid Url</p>";
                noerr = isValidURL(social_value);
            }

            if(noerr != true){
                $("#showLinkErrors").html(msg);
            }
            else{
                var social_link = $(this).attr("data-social_link");

                $.ajax({
                    url: '{{ URL::to("business/updateSocialLink") }}',
                    type: 'POST',
                    dataType: "JSON",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "social_link": social_link,
                        "social_value": social_value,
                    },
                    success: function(data) {
                        // console.log(data);
                        
                        $("#overlay").fadeOut(300);
                        if(data.status == true){
                            $("#social_value").val("");
                            $("#update_sociallink").modal("hide");

                            Sweet('success',data.message);
                            setTimeout(function () {
                                location.reload();
                            }, 1500);
                        }else{
                            Sweet('error',data.message);
                        }
                    }
                });
            }
        });



        $(document).on("click", ".btnCopy", function(e){
            e.preventDefault();
            var copyText = $(this).attr('href');

            document.addEventListener('copy', function(e) {
                e.clipboardData.setData('text/plain', copyText);
                e.preventDefault();
            }, true);

            document.execCommand('copy');  
            // console.log('copied text : ', copyText);
            // alert('copied text: ' + copyText);
        });


        $(document).on("click", ".showUpcomingPopup", function(){
            Swal.fire({
                title: 'Can not post Upcoming offer!',
                // text: 'Unable to post Upcoming offer',
                icon: 'info',
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonColor: '#3085d6'
            });
        });

        $(document).on("click", ".showNotConnectedPopup", function(){
            Swal.fire({
                title: 'Please connect first!',
                text: 'You are not connected to social media or connection expired!',
                icon: 'info',
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonColor: '#3085d6'
            });
        });

        // Push post to SocialConnectController to post offer
        $(document).on("click", ".postToSocialLink", function(){

            var isChannelActive = {{ $isChannelActive['status'] }}

            if(isChannelActive == 0){
                var msg = "{{Config::get('constants.social_post_status')}}"
                Sweet("error", msg);
                return false;
            }

            var social_type = $(this).attr("data-taskKey");
            var offer_id = $(this).attr("data-offer_id");
            var offer_type = $(this).attr("data-offer_type");
            var manual_post = $(this).attr("data-manual_post");
            var btnId = $(this).attr("data-btnId");
            var platform = $(this).attr("data-platform");

            var custom_website_offer = $(this).attr("data-custom_website_offer");
            if(custom_website_offer=="1"){
                Swal.fire({
                    icon: 'error',
                    text: "Url will not post on Instagram",
                });
                $("#overlay").fadeOut(300);
                return false;
            }

            $("#overlay").fadeIn(300);

            var thisData = this;

            var isSocialPost = '{{ $isSocialPost }}';
            if(isSocialPost!='0'){
                $.ajax({
                    url: '{{ URL::to("business/postToSocialLink") }}',
                    type: 'POST',
                    dataType: "JSON",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "social_type": social_type,
                        "offer_id": offer_id,
                    },
                    success: function(data) {
                        if(data.response.status==200){
                            // console.log('data.response.status==200');
                            var offer_id1 = data.response.offer_id;
                            var task_value = data.response.post_short_url;
                            var task_key = data.social_type_slug;

                            if(offer_type!="unscheduled"){
                                // alert(offer_type);
                                $.ajax({
                                    url: '{{ URL::to("business/addSocialPostTask") }}',
                                    type: 'POST',
                                    dataType: "JSON",
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        "task_key": task_key,
                                        "task_value": task_value,
                                        "offer_id": offer_id1
                                    },
                                    success: function(data) {
                                        $("#overlay").fadeOut(300);

                                        if(data.status == true){
                                            Sweet('success',data.message);
                                            $(thisData).removeClass("postToSocialLink");
                                            $(thisData).addClass("disabled");
                                            // setTimeout(function () {
                                            //     location.reload();
                                            // }, 1500);
                                        }else{
                                            Sweet('error',data.message);
                                        }
                                        // $("#tab_offers_list").load(location.href + " #tab_offers_list");
                                    }
                                });
                            }
                            else{
                                $("#overlay").fadeOut(300);
                                Sweet('success', "Offer posted successfully!");
                            }
                        }
                        else if(data.response.status==500 && data.response.is_expired==true){
                            Swal.fire({
                                icon: 'error',
                                text: data.response.error,
                            });
                            $("#overlay").fadeOut(300);
                        }
                        else{
                            var msgPlatform = "";
                            if(platform=="facebook"){
                                msgPlatform = "Facebook";
                            }
                            else if(platform=="twitter"){
                                msgPlatform = "Twitter";
                            }
                            else if(platform=="linkedin"){
                                msgPlatform = "LinkedIn";
                            }

                            Swal.fire({
                                icon: 'error',
                                text: "Oops! We're sorry, but it looks like there is an issue on "+msgPlatform+" side. Our team is working to resolve the problem, but in the meantime, please try again later. Thank you for your patience and understanding.",
                                title: "Offer not posted"
                            });
                            $("#overlay").fadeOut(300);
                        }
                    }
                });
            }
            else{
                $("#overlay").fadeOut(300);
                var msgPlatform = "";
                if(platform=="facebook"){
                    msgPlatform = "Facebook";
                }
                else if(platform=="twitter"){
                    msgPlatform = "Twitter";
                }
                else if(platform=="linkedin"){
                    msgPlatform = "LinkedIn";
                }

                Swal.fire({
                    icon: 'error',
                    text: "Oops! We're sorry, but it looks like there is an issue on "+msgPlatform+" side. Our team is working to resolve the problem, but in the meantime, please try again later. Thank you for your patience and understanding.",
                    title: "Offer not posted"
                });
                $("#overlay").fadeOut(300);
            }

        });

        $(document).on("click", "#skipUpdateTask", function(){
            var offer_id = $(this).attr("data-offer_id");
            $("#"+offer_id).removeClass("disabled");
        });

        $(document).on("click", ".social-post", function(){
            sessionStorage.setItem("social_post", $(this).attr('id'));
            // console.log($(this).attr('id'));
        });

        $(document).on("click", "#redirectToSocialConnectPage", function(){
            sessionStorage.setItem("setting_section", "social_connection");
            window.location.href = "{{ route('business.settings') }}";
        });

        $(document).on("click", ".connect_with_youtube", function(){
            sessionStorage.setItem('connect_to', 'youtube');
            window.location.href = '{{ route('business.channel.instantRewards.modifyTasks') }}';
        });
    });
</script>

@endsection