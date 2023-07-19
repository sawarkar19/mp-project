@extends('layouts.website')

@section('title', '')
@section('description', '')
@section('keywords', '')
{{-- @section('image', '') --}}

@section('end_head')
<style>
.btn-primary-ol{
    transform: scale(1);
    transition: all 300ms ease-in-out;
}
.btn-primary-ol:hover{
    transform: scale(1.05);
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

/* .color-gradient-on-dark{
    background: rgba(var(--color-primary), 1);
    background: linear-gradient(90deg, rgb(0 244 174) 0%, rgb(9 142 205) 145%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
} */
.lines-highlight{
    position: relative;
}
.lines-highlight::after,
.lines-highlight::before{
    content: "";
    position: absolute;
    top: 100%;
    right: 0;
    width: 100%;
    height: 2px;
    background: linear-gradient(90deg, rgb(0 244 174) 0%, rgb(9 142 205) 145%);
    transform: rotate(357deg);
    transform-origin:70% 0%;
}
.lines-highlight::after{
    transform: rotate(354deg);
    width: 80%;
}

.lp-do-card{
    background-color: #212326;
    border-radius: 10px;
    color: #fff;
    padding: 1.5rem 2rem;
    display: flex;
    flex-direction: column;
    height: 100%;
    min-height: 300px;
    justify-content: center;
    align-items: center;
}
.lp-do-card .title{
    color: #0ecdc2;
}
.lp-do-card p{
    margin-bottom: 0px;
}

.laverage_check{
    position: relative;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    padding: .6rem;
    -webkit-box-align: center;
    -webkit-align-items: center;
    -ms-flex-align: center;
    align-items: center;
    border-radius: 8rem;
    background-color: #fff;
}
.laverage_check .icon{
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    width: 2rem;
    height: 2rem;
    margin-right: .5rem;
    padding: 0.5rem;
    -webkit-box-pack: center;
    -webkit-justify-content: center;
    -ms-flex-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    -webkit-align-items: center;
    -ms-flex-align: center;
    align-items: center;
    border-radius: 25rem;
    background-color: rgba(0,116,123,.05);
}
.laverage_check .title{
    /* font-size: 20px; */
    /* line-height: 30px; */
    font-weight: 600;
}

.fd-challenge-img img {
    max-width: 350px;
    width: 100%;
}
.dw-arrow{
    max-width: 450px;
    width: 100%;
    opacity: .5;
}
.down-ar{
    display: none;
}

.step-badge{
    position: relative;
    width: 56px;
    height: 56px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 1.5rem;
    font-weight: 600;
    color: #fff;
    background-color: rgba(var(--color-one), 1);
    outline: 5px solid rgba(var(--color-two), .2);
}
/* .step-badge::before{
    content: "";
    width: 100%;
    height: 100%;
    border-radius: 50%;
    position: absolute;
    z-index: -1;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%) scale(1.2);
    background-color: rgba(var(--color-two), .5);
} */

/* offer modal css */
img.pop-img-width {
    width: 150px;
    height: 150px;
}
.offerpop-head-1 {
    font-size: 25px;
    font-weight: bold;
    line-height: 1.2;
}
.offerpop-head-2{
    color: rgba(25, 122, 164, 1);
    font-weight: bold;
    line-height: 1.2;
}
.offerpop-head-2 span {
    font-size: 42px;
    padding: 0px 5px;
    text-shadow: 3px 3px 4px #ddddddcf;
}
.offerpop-head-3 span{
    color: rgba(25, 122, 164, 1);
}
.popoffer-btn {
    text-decoration: none;
    color: #fff;
    font-size: 28px;
    text-transform: capitalize;
    font-weight: bold;
}
.popoffer-btn:hover{
    color: #fff;
    text-shadow: 2px 2px 4px #232323b0;
    transition: all 0.5s ease;
}
.popoffer-close {
    float: right;
    font-size: 9px;
}
/* end offer modal css */

@media(max-width:991px){
    .dw-arrow{
        max-width: 353px;
    }
}
@media(max-width:767px){
    .lp-do-card{
        min-height: auto;
        padding: 1.5rem;
    }

    .dw-arrow{
        display: none;
    }
    .down-ar{
        display: inline;
        width: 18px;
    }
}
@media(max-width:480px){
    .btn-primary-ol.bs{
        font-size: .9rem!important;
        line-height: 1.2;
    }
}
</style>
@endsection

@section('content')
{{-- Banner Section --}}
<section id="banner">
    <div class="pb-5 bg-dots">
        <div class="container-fluid">
            <div class="row justify-content-end align-items-center">

                <div class="col-lg-5 order-lg-2 pe-lg-0">
                    <div class="">
                        <video autoplay loop muted playsinline width="100%" poster="{{asset('assets/website/images/oc-video-screen-1.jpg')}}" src="{{asset('assets/website/videos/mp-story.mp4')}}">
                            <source src="{{asset('assets/website/videos/mp-story.mp4')}}" type="video/mp4"></source>
                        </video>
                    </div>
                </div>

                <div class="col-lg-6 mb-lg-0 order-lg-1">
                    <div class="banner-block pe-xl-5">

                        <h1 class="mb-3 font-900 hb-head-font color-primary" style="font-size: 2.5rem">Convert customers to mouth publicity marketing team for free</h1>
                        <p class="mb-4">MouthPublicity.io - The world's only free mouth publicity platform to start, boost, manage and track your business word of mouth. Whether you have an offline store, a personal brand, or any business, MouthPublicity.io helps you tap in to the power of mouth marketing.</p>
                        <div>
                            <a href="{{url('signin?tab=register')}}" class="btn bs px-4 px-sm-5 btn-primary-ol py-2 rounded-pill font-large">Start, Boost, Manage & Track <br class="d-none d-sm-block">Your Mouth Publicity Now</a>
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


<section class="py-5" style="background-color: #131416;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="text-white font-800">With <span class="lines-highlight">MouthPublicity.io</span> You can</h2>
        </div>


        <div class="row mb-5">
            <div class="col-md-4 mb-4 mb-md-0">
                <div class="lp-do-card">
                    <div class="text-center">
                        <div class="mb-3">
                            <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 300 300">
                                <defs>
                                    <style>
                                    .cls-1 {
                                        fill: #0ecdc2;
                                    }
                                    .cls-2 {
                                        fill: #212326;
                                    }
                                    .cls-3 {
                                        fill: #3b414d;
                                    }
                                    </style>
                                </defs>
                                <g>
                                    <circle class="cls-1" cx="150" cy="150" r="135.78"/>
                                    <path class="cls-3" d="m150,296.37C69.29,296.37,3.63,230.71,3.63,150S69.29,3.63,150,3.63s146.36,65.66,146.36,146.36-65.66,146.37-146.36,146.37Zm0-271.55c-69.03,0-125.19,56.16-125.19,125.19s56.16,125.19,125.19,125.19,125.19-56.16,125.19-125.19S219.03,24.81,150,24.81Z"/>
                                </g>
                                <g>
                                    <path class="cls-2" d="m93.36,178.67c.55-3.48,1.06-6.96,2.16-10.33,3.31-10.15,9.15-18.36,18.39-23.97.91-.55,1.59-.59,2.55-.02,11.74,6.89,23.49,6.8,35.17-.17.68-.4,1.19-.49,1.9-.09,5.61,3.12,10.09,7.4,13.53,12.81.54.84.6,1.41-.17,2.22-5.33,5.63-8.61,12.31-9.36,20.03-1.18,12.05,2.84,22.16,11.87,30.26.29.26.89.46.74.87-.18.5-.8.24-1.21.24-24.74.01-49.49.01-74.23,0-.45,0-.9-.06-1.34-.09,0-10.59,0-21.18,0-31.77Z"/>
                                    <path class="cls-2" d="m159.47,116.57c.2,12.85-10.11,25.57-25.61,25.56-15.31-.01-25.76-12.68-25.59-25.88.18-14.09,11.55-25.35,25.84-25.36,14.04,0,25.62,11.82,25.36,25.67Z"/>
                                    <path class="cls-2" d="m219.56,183.15c.14,15.05-12.58,27.58-27.66,27.42-15.06-.17-27.39-12.44-27.38-27.54,0-15.07,12.49-27.53,27.56-27.54,15.17,0,27.5,12.39,27.48,27.66Zm-37.3,3.57c1.52,0,3.04,0,4.56,0,1.65,0,1.67.02,1.67,1.62,0,3.04.04,6.08-.02,9.11-.02,1.1.37,1.45,1.43,1.4,1.47-.07,2.96-.07,4.43,0,1.04.05,1.46-.25,1.44-1.38-.07-3.12.01-6.24-.04-9.36-.02-1.07.31-1.44,1.4-1.42,3.12.06,6.24-.02,9.36.04,1.1.02,1.44-.36,1.39-1.42-.07-1.47-.08-2.96,0-4.43.07-1.18-.41-1.46-1.5-1.44-3.08.06-6.16-.02-9.24.04-1.08.02-1.43-.36-1.41-1.43.05-3.24,0-6.49.03-9.73,0-.85-.27-1.18-1.13-1.15-1.6.05-3.2.06-4.8,0-1.01-.04-1.37.3-1.35,1.33.05,3.16-.02,6.32.04,9.48.02,1.11-.34,1.53-1.48,1.51-3.2-.06-6.4,0-9.61-.03-.89,0-1.25.27-1.22,1.2.06,1.64.05,3.28,0,4.93-.02.84.26,1.18,1.13,1.15,1.64-.05,3.28-.01,4.93-.01Z"/>
                                    <path class="cls-2" d="m163.57,90.66c12.15,0,22.03,8.86,23.24,20.59,1.48,14.34-10.08,26.43-24.48,25.6-1.58-.09-1.95-.74-1.09-2.04,4.21-6.35,6.02-13.35,5.42-20.91-.62-7.89-3.77-14.7-9.31-20.38-.42-.43-1.24-.8-1.05-1.4.19-.63,1.09-.59,1.71-.76,1.91-.53,3.85-.79,5.56-.7Z"/>
                                    <path class="cls-2" d="m199.71,149.15c-2.19-.51-4.3-.7-6.44-.79-6.21-.26-12.04,1.1-17.52,4.01-2.2,1.17-2.18,1.21-3.58-.85-1.58-2.31-3.34-4.46-5.35-6.42-.25-.24-.71-.45-.53-.87.16-.39.63-.3.99-.34,6.05-.66,11.38-3.01,16.03-6.89.77-.64,1.35-.8,2.28-.32,5.54,2.87,10.36,6.61,14.23,11.53.19.24.56.45.35.82-.06.11-.36.09-.46.11Z"/>
                                </g>
                            </svg>
                        </div>
                        <h5 class="title font-600">Make customers to share their positive experience willingly</h5>
                        <p>You can create sharable word of mouth campaign with in just few minutes and make your customers to share it willingly</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4 mb-md-0">
                <div class="lp-do-card">
                    <div class="text-center">
                        
                        <div class="mb-3">
                            <svg id="Layer_2" data-name="Layer 2" xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 300 300">
                                <defs>
                                    <style>
                                    .cls-1 {
                                        fill: #0ecdc2;
                                    }
                                
                                    .cls-2 {
                                        fill: #212326;
                                    }
                                
                                    .cls-3 {
                                        fill: #3b414d;
                                    }
                                    </style>
                                </defs>
                                <g>
                                    <circle class="cls-1" cx="150" cy="150" r="135.78"/>
                                    <path class="cls-3" d="m150,296.37C69.29,296.37,3.63,230.71,3.63,150S69.29,3.63,150,3.63s146.36,65.66,146.36,146.36-65.66,146.37-146.36,146.37Zm0-271.55c-69.03,0-125.19,56.16-125.19,125.19s56.16,125.19,125.19,125.19,125.19-56.16,125.19-125.19S219.03,24.81,150,24.81Z"/>
                                </g>
                                <g>
                                    <path class="cls-2" d="m149.12,80.41c1.76.85,2.83,2.45,4.03,3.87,4.87,5.79,9.54,11.71,12.69,18.68,3.29,7.27,5.39,14.83,5.89,22.8.1,1.63.51,2.67,2.26,3.42,8.79,3.79,14.4,12.84,13.95,22.38-.25,5.28-2.24,9.92-5.76,13.88-1.46,1.65-3.66,1.73-5.36.2-2.89-2.6-5.77-5.2-8.61-7.86-.85-.8-1.12-.55-1.48.39-1.7,4.41-3.96,8.53-6.42,12.57-1.8,2.96-4.31,4.61-7.61,5.22-4.53.84-8.95.47-13.18-1.47-1.67-.76-2.97-1.96-3.98-3.49-2.58-3.92-4.73-8.05-6.49-12.39-.67-1.65-.69-1.67-1.96-.52-2.69,2.43-5.36,4.88-8.03,7.32-2.08,1.9-4.2,1.74-5.99-.4-10.1-12.09-5.54-29.53,9.07-36.09.97-.44,1.53-.86,1.6-2.04.4-6.61,1.7-13.04,4.06-19.26,3.13-8.26,7.73-15.63,13.55-22.24,1.58-1.79,3-3.76,5.15-4.97h2.62Zm10.69,43.34c.05-6.75-5.21-12.09-11.94-12.12-6.7-.03-11.98,5.2-12.07,11.86-.09,6.55,5.1,12.27,12.01,12.27,6.86,0,11.99-5.61,12-12.02Z"/>
                                    <path class="cls-2" d="m147.67,214.69c-20.13,0-40.26,0-60.39,0-.74,0-1.48.08-2.21-.17-1.43-.49-2.53-2.01-2.52-3.51.01-1.65,1.14-3.11,2.76-3.59.99-.29,2-.2,2.99-.19.78.01,1.2-.3,1.44-1.03,2-6.07,8.42-10.73,15.52-10.01.99.1,1.71-.17,2.44-.89,7.33-7.11,18.84-5.06,23.28,4.13.38.79.8,1.18,1.73,1.28,3.97.45,7.23,2.21,9.5,5.58.48.71,1.05.93,1.86.93,3.89-.02,7.77-.02,11.66,0,.77,0,1.28-.26,1.78-.86,2.45-2.97,5.59-4.85,9.35-5.63.81-.17,1.3-.48,1.67-1.22,3.36-6.7,10.05-9.92,16.68-9.27,7.54.74,13.08,5.74,14.89,13.1.22.89.38,1.8.41,2.71.03.93.44,1.19,1.3,1.18,2.45-.03,4.89-.04,7.34.01,1.84.04,3.22,1.07,3.7,2.61.47,1.5.03,3-1.18,4.02-.59.5-1.25.79-2.03.81-.52.01-1.05.01-1.57.01-20.13,0-40.26,0-60.39,0Z"/>
                                    <path class="cls-2" d="m144.06,189.83c0-2.4.03-4.8-.01-7.2-.02-.99.31-1.44,1.35-1.4,1.66.05,3.32.03,4.97.01.83-.01,1.18.33,1.18,1.16-.02,4.93-.02,9.86,0,14.79,0,.93-.43,1.22-1.28,1.21-1.61-.02-3.23-.04-4.84,0-1.01.03-1.4-.35-1.38-1.38.05-2.4.02-4.8.02-7.2Z"/>
                                    <path class="cls-2" d="m163.33,186.42c0,2.14-.03,4.28.01,6.41.02,1.01-.35,1.42-1.37,1.39-1.61-.05-3.23-.03-4.84,0-.85.01-1.29-.25-1.29-1.19.03-4.45.02-8.9,0-13.35,0-.77.31-1.11,1.09-1.1,1.74.02,3.49.03,5.23,0,.85-.02,1.17.35,1.16,1.17-.02,2.22,0,4.45,0,6.67Z"/>
                                    <path class="cls-2" d="m132.28,185.74c0-1.92.03-3.84-.01-5.76-.02-.97.27-1.45,1.34-1.41,1.66.06,3.32.04,4.97,0,.82-.01,1.19.29,1.19,1.14-.02,4.01-.02,8.03,0,12.04,0,.85-.38,1.16-1.19,1.15-1.7-.02-3.4-.03-5.11,0-.94.02-1.21-.44-1.19-1.29.03-1.96,0-3.93,0-5.89Z"/>
                                </g>
                            </svg>
                        </div>
                        <h5 class="title font-600">Boost,Manage,and Track your word of mouth campaigns</h5>
                        <p>MouthPublicity.io not only lets you to initiate word of mouth but also gives you a power to manage and control it.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="lp-do-card">
                    <div class="text-center">
                        <div class="mb-3">
                            <svg id="Layer_2" data-name="Layer 2" xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 300 300">
                                <defs>
                                    <style>
                                    .cls-1 {
                                        fill: #0ecdc2;
                                    }
                                
                                    .cls-2 {
                                        fill: #212326;
                                    }
                                
                                    .cls-3 {
                                        fill: #3b414d;
                                    }
                                    </style>
                                </defs>
                                <g>
                                    <circle class="cls-1" cx="150" cy="150" r="135.78"/>
                                    <path class="cls-3" d="m150,296.37C69.29,296.37,3.63,230.71,3.63,150S69.29,3.63,150,3.63s146.36,65.66,146.36,146.36-65.66,146.37-146.36,146.37Zm0-271.55c-69.03,0-125.19,56.16-125.19,125.19s56.16,125.19,125.19,125.19,125.19-56.16,125.19-125.19S219.03,24.81,150,24.81Z"/>
                                </g>
                                <g>
                                    <path class="cls-2" d="m186.38,84.2c1.93,3.41,3.84,6.82,5.79,10.21,3.72,6.5,7.46,12.98,11.18,19.48.68,1.19.64,1.25-.69,1.26-1.69,0-3.38.03-5.07,0-.75-.02-1.06.27-1,1.01.03.34,0,.69,0,1.04,0,23.15,0,46.3,0,69.46q0,1.76-1.75,1.77c-5.87,0-11.75,0-17.62,0-1.52,0-1.52,0-1.52-1.53,0-23.31,0-46.61,0-69.92q0-1.82-1.79-1.82c-1.57,0-3.15,0-4.72,0-1.32,0-1.37-.09-.69-1.25,3.86-6.55,7.73-13.09,11.58-19.64,1.96-3.34,3.89-6.7,5.84-10.05.15,0,.31,0,.46,0Z"/>
                                    <path class="cls-2" d="m85.93,195.25c.54-.03,1.07-.08,1.61-.08,38.17,0,76.33,0,114.5,0,.31,0,.62.02.92,0,.73-.06,1.03.26,1.02,1-.03,1.69-.03,3.38,0,5.07.01.75-.29,1.06-1.02,1-.34-.03-.69,0-1.04,0-38.09,0-76.18,0-114.27,0-.57,0-1.15-.05-1.72-.08,0-2.3,0-4.61,0-6.91Z"/>
                                    <path class="cls-2" d="m148.05,158.5c0-9.37,0-18.73,0-28.1,0-1.58,0-1.59,1.58-1.59,5.95,0,11.9.03,17.85-.03,1.17-.01,1.49.34,1.49,1.5-.03,18.89-.03,37.77,0,56.66,0,1.16-.32,1.51-1.49,1.5-5.99-.05-11.98-.05-17.96,0-1.17.01-1.49-.34-1.49-1.5.04-9.48.02-18.96.02-28.44Z"/>
                                    <path class="cls-2" d="m120.41,168.98c0-5.99.03-11.97-.02-17.96-.01-1.16.32-1.51,1.49-1.5,6.03.05,12.05.05,18.08,0,1.05,0,1.38.32,1.37,1.37-.03,12.05-.03,24.1,0,36.15,0,1.05-.31,1.39-1.37,1.38-6.06-.04-12.13-.04-18.19,0-1.05,0-1.38-.32-1.37-1.37.04-6.03.02-12.05.02-18.08Z"/>
                                    <path class="cls-2" d="m103.15,188.41c-3.07,0-6.14-.03-9.21.02-.91.01-1.2-.3-1.19-1.2.03-5.26.03-10.51,0-15.77,0-.91.3-1.2,1.2-1.19,6.18.03,12.36.03,18.53,0,.9,0,1.2.3,1.19,1.2-.03,5.26-.03,10.51,0,15.77,0,.91-.3,1.2-1.2,1.19-3.11-.04-6.22-.02-9.32-.02Z"/>
                                </g>
                            </svg>
                        </div>
                        <h5 class="title font-600">Build your Brand Trust & Increase Brand Recall Value</h5>
                        <p>Word of mouth is the single most effective factor to build trust among your customers and make them to talk about your brand with others.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center">
            <a href="{{url('signin?tab=register')}}" style="font-size: 1.5rem;" class="btn bs px-4 px-sm-5 btn-primary-ol py-3 rounded-pill">Start converting customers to mouth publicity marketing team now</a>
        </div>

    </div>
</section>

<section class="py-5 bg-color-gradient-light_" style="background-color: #d4e4ef;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="color-primary font-800">Who can Leverage MouthPublicity.io</h2>
        </div>

        <div class="row">

            @php
                $levegaer = array(
                    array('title'=> 'Agency Owner'),
                    array('title'=> 'Offline Retail Stores'),
                    array('title'=> 'Wedding & Event Business'),
                    array('title'=> 'Personal Brand'),
                    array('title'=> 'Local Business'),
                    array('title'=> 'Coaching Business'),
                    array('title'=> 'Startup'),
                    array('title'=> 'E-Commerce Store'),
                    array('title'=> 'Jewelry Business'),
                    array('title'=> 'Apparels & Personal Care Brand'),
                    array('title'=> 'Restaurants & Food Business'),
                    array('title'=> 'Healthcare Business'),
                );
            @endphp
            @foreach ($levegaer as $item)
            <div class="col-lg-4 col-sm-6 mb-3">
                <div class="laverage_check">
                    <div class="icon">
                        <svg height="100%" viewBox="0 0 24 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 10.5048L7.67831 16.1829L21.0441 2.81705" stroke="url(#paint0_linear_606_1619)" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"></path>
                            <defs>
                                <linearGradient id="paint0_linear_606_1619" x1="-5.65611" y1="9.5" x2="27.2429" y2="9.5" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#09D4E7"></stop>
                                    <stop offset="1" stop-color="#05744C"></stop>
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                    <div class="title">
                        {{$item['title']}}
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>

<style>
    .how-to-steps{
        background: linear-gradient(180deg, rgba(212, 228, 239, 1) 0%, rgba(212, 228, 239, 0) 50%);
    }
</style>
<section class="how-to-steps">
    <div class="container">
        <div class="py-5">
            <div class="text-center mb-5">
                <h2 class="text-dark font-800">How it works for <span class="color-primary lines-highlight">Your Business</span></h2>
                <p class="fw-bold">Turn your customers into a mouth publicity marketing team in just 7 simple steps and 7 minutes.</p>
            </div>

            <div class="row justify-content-center align-items-center">
                <div class="col-12 col-md-5">
                    <div class="">
                        <h6><span class="step-badge">1</span></h6>
                        <h5 class="font-700 color-primary">Get started for free with simple OTP registration or login.</h5>
                        <p class="text-muted">Simply register via OTP signup to start launching your mouth publicity campaign.</p>
                        <a href="{{url('signin?tab=register')}}" class="btn btn-primary-ol rounded-pill px-3">Get Started Now</a>
                    </div>
                </div>
                <div class="col-12 col-md-5">
                    <div class="fd-challenge-img">
                        <img class="img-fluid" src="{{ asset('assets/landing-page/lp-step-1.png') }}" alt="MouthPublicity.io">
                    </div>
                </div>
            </div>

            <div class="down-arrow text-center my-3">
                <img src="{{ asset('assets/website/images/how-it-works/arrowgr-rl.svg') }}" alt="arrow" class="dw-arrow">
                <img src="{{ asset('assets/website/images/how-it-works/down-ar.png') }}" alt="arrow" class="down-ar">
            </div>
            <div class="mt-3 mt-md-0">
                <div class="row justify-content-center align-items-center">
                    <div class="col-12 col-md-5 order-md-2">
                        <div class="">
                            <h6><span class="step-badge">2</span></h6>
                            <h5 class="font-700 color-primary">Create an offer in 5 minutes with easy-to-make attractive templates.</h5>
                            <p class="text-muted">Design mind-blowing offers with our eye-catching, customizable templates in just a few minutes and save your valuable time.</p>
                            <a href="{{url('signin?tab=register')}}" class="btn btn-primary-ol rounded-pill px-3">Create Offer Now</a>
                        </div>
                    </div>
                    <div class="col-12 col-md-5 order-md-1">
                        <div class="text-md-end">
                            <img class="img-fluid" src="{{ asset('assets/landing-page/lp-step-2.png') }}" alt="MouthPublicity.io">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="down-arrow text-center my-3">
                <img src="{{ asset('assets/website/images/how-it-works/arrowgr-lr.svg') }}" alt="arrow" class="dw-arrow">
                <img src="{{ asset('assets/website/images/how-it-works/down-ar.png') }}" alt="arrow" class="down-ar">
            </div>
            <div class="mt-3 mt-md-0">
                <div class="row justify-content-center align-items-center">
                    <div class="col-12 col-md-5">
                        <div class="">
                            <h6><span class="step-badge">3</span></h6>
                            <h5 class="font-700 color-primary">Create a challenge and set tasks and discounts/gifts.</h5>
                            <p class="text-muted">Select a challenge and create tasks that you want your customers to do for you. For example, like, share, follow, or subscribe on social media, and share your offer link with a number of people to get clicks. Set discounts or gifts to avail of your customers on completion of targeted tasks.</p>
                            <a href="{{url('signin?tab=register')}}" class="btn btn-primary-ol rounded-pill px-3">Create Challenge Now</a>
                        </div>
                    </div>
                    <div class="col-12 col-md-5">
                        <div class="fd-challenge-img">
                            <img class="img-fluid" src="{{ asset('assets/landing-page/lp-step-3.png') }}" alt="MouthPublicity.io">
                        </div>
                    </div>
                </div>
            </div>

            <div class="down-arrow text-center my-3">
                <img src="{{ asset('assets/website/images/how-it-works/arrowgr-rl.svg') }}" alt="arrow" class="dw-arrow">
                <img src="{{ asset('assets/website/images/how-it-works/down-ar.png') }}" alt="arrow" class="down-ar">
            </div>
            <div class="mt-3 mt-md-0">
                <div class="row justify-content-center align-items-center">
                    <div class="col-12 col-md-5 order-md-2">
                        <div class="">
                            <h6><span class="step-badge">4</span></h6>
                            <h5 class="font-700 color-primary">Share challenge link with your customers in one click.</h5>
                            <p class="text-muted">Ask your customer to take the challenge to avail of discounts or gifts. Take their WhatsApp number and share the challenge link by entering the WhatsApp number or make them scan the generated challenge QR code to receive the challenge link on their phone.</p>
                            <a href="{{url('signin?tab=register')}}" class="btn btn-primary-ol rounded-pill px-3">Share Now</a>
                        </div>
                    </div>
                    <div class="col-12 col-md-5 order-md-1">
                        <div class="text-md-end">
                            <img class="img-fluid" src="{{ asset('assets/landing-page/lp-step-4.png') }}" alt="MouthPublicity.io">
                        </div>
                    </div>
                </div>
            </div>

            <div class="down-arrow text-center my-3">
                <img src="{{ asset('assets/website/images/how-it-works/arrowgr-lr.svg') }}" alt="arrow" class="dw-arrow">
                <img src="{{ asset('assets/website/images/how-it-works/down-ar.png') }}" alt="arrow" class="down-ar">
            </div>
            <div class="mt-3 mt-md-0">
                <div class="row justify-content-center align-items-center">
                    <div class="col-12 col-md-5">
                        <div class="">
                            <h6><span class="step-badge">5</span></h6>
                            <h5 class="font-700 color-primary">Let your customers share your offer link with others in their network.</h5>
                            <p class="text-muted">Your happy customers will be performing the tasks (like, share, follow you on social media and sharing the offer link with others) willingly to unlock the discounts or gifts.</p>
                            <a href="{{url('signin?tab=register')}}" class="btn btn-primary-ol rounded-pill px-3">Start Mouth Publicity Now</a>
                        </div>
                    </div>
                    <div class="col-12 col-md-5">
                        <div class="fd-challenge-img">
                            <img src="{{ asset('assets/landing-page/lp-step-5.png') }}" alt="MouthPublicity.io">
                        </div>
                    </div>
                </div>
            </div>

            <div class="down-arrow text-center my-3">
                <img src="{{ asset('assets/website/images/how-it-works/arrowgr-rl.svg') }}" alt="arrow" class="dw-arrow">
                <img src="{{ asset('assets/website/images/how-it-works/down-ar.png') }}" alt="arrow" class="down-ar">
            </div>
            <div class="mt-3 mt-md-0">
                <div class="row justify-content-center align-items-center">
                    <div class="col-12 col-md-5 order-md-2">
                        <div class="">
                            <h6><span class="step-badge">6</span></h6>
                            <h5 class="font-700 color-primary">Redeem your customer's efforts with simple redeem code management.</h5>
                            <p class="text-muted">Give your customer the discounts and gifts upon completing the challenge by them. Avail of the discounts or gift through the redeem code they received at the end and verify by entering the redeem code.</p>
                            <a href="{{url('signin?tab=register')}}" class="btn btn-primary-ol rounded-pill px-3">Manage Redeem Now</a>
                        </div>
                    </div>
                    <div class="col-12 col-md-5 order-md-1">
                        <div class="text-md-end">
                            <img class="img-fluid" src="{{ asset('assets/landing-page/lp-step-6.png') }}" alt="MouthPublicity.io">
                        </div>
                    </div>
                </div>
            </div>

            <div class="down-arrow text-center my-3">
                <img src="{{ asset('assets/website/images/how-it-works/arrowgr-lr.svg') }}" alt="arrow" class="dw-arrow">
                <img src="{{ asset('assets/website/images/how-it-works/down-ar.png') }}" alt="arrow" class="down-ar">
            </div>
            <div class="mt-3 mt-md-0">
                <div class="row justify-content-center align-items-center">
                    <div class="col-12 col-md-5">
                        <div class="">
                            <h6><span class="step-badge">7</span></h6>
                            <h5 class="font-700 color-primary">Watch your brand/product/services reach unlimited people with analytics</h5>
                            <p class="text-muted">Track Mouth Publicity in a single dashboard and see the impact of your customer's mouth publicity through the number of customers, clicks, shares, and reach that ultimately increases your brand recall value.</p>
                            <a href="{{url('signin?tab=register')}}" class="btn btn-primary-ol rounded-pill px-3">See the Impact Now</a>
                        </div>
                    </div>
                    <div class="col-12 col-md-5">
                        <div class="fd-challenge-img">
                            <img src="{{ asset('assets/landing-page/lp-step-7.png') }}" alt="MouthPublicity.io">
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="text-center mb-5">
            <a href="{{url('signin?tab=register')}}" style="font-size: 1.5rem;" class="btn bs px-4 px-sm-5 btn-primary-ol py-3 rounded-pill">Start converting customers to mouth publicity marketing team now</a>
        </div>
    </div>
</section>


<section class="py-5" style="background-color: #d4e4ef;">
    <div class="container">

        <div class="text-center mb-5 mx-auto" style="max-width: 880px;">
            <h2 class="text-dark font-800">Why you should do mouth publicity for your product, service, business & personal brand</h2>
        </div>

        <div>
            <div class="row justify-content-center mb-3">
                @php
                    $why = array(
                        array('title'=> 'Increase Customer Trust'),
                        array('title'=> 'Improve Brand Reputation'),
                        array('title'=> 'Lower Acquisition Costs'),
                        array('title'=> 'Greater Customer Retention'),
                        array('title'=> 'Improve Brand Reputation'),
                    );
                @endphp
                @foreach ($why as $item)
                <div class="mb-4 col-sm-6 col-md-4" {{-- style="max-width: 300px;" --}}>
                    <div class="laverage_check">
                        <div class="icon">
                            <svg height="100%" viewBox="0 0 24 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 10.5048L7.67831 16.1829L21.0441 2.81705" stroke="url(#paint0_linear_606_1619)" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"></path>
                                <defs>
                                    <linearGradient id="paint0_linear_606_1619" x1="-5.65611" y1="9.5" x2="27.2429" y2="9.5" gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#09D4E7"></stop>
                                        <stop offset="1" stop-color="#05744C"></stop>
                                    </linearGradient>
                                </defs>
                            </svg>
                        </div>
                        <div class="title font-large">
                            {{$item['title']}}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="row justify-content-center">
                <div class="col-md-9 col-lg-10">
                    <div class="mb-4">
                        <img src="{{asset('assets\landing-page\graph-media-stats.png')}}" class="img-fluid" alt="Media Statistics">
                    </div>
                </div>
            </div>
        </div>

        <div class="pb-4">
            <div class="row">
                <div class="col-sm-6 col-lg-3 mb-4">
                    <div class="lp-do-card {{-- bg-white text-dark --}}" style="min-height: 100px;">
                        <div class="text-center">
                            <h5 class="title font-700 h1 {{-- color-primary --}}">82%</h5>
                            <p>of marketers use word of mouth marketing to increase their brand awareness.</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 mb-4">
                    <div class="lp-do-card {{-- bg-white text-dark --}}" style="min-height: 100px;">
                        <div class="text-center">
                            <h5 class="title font-700 h1 {{-- color-primary --}}">43%</h5>
                            <p>expect word of mouth marketing to improve their direct sale</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 mb-4">
                    <div class="lp-do-card {{-- bg-white text-dark --}}" style="min-height: 100px;">
                        <div class="text-center">
                            <h5 class="title font-700 h1 {{-- color-primary --}}">88%</h5>
                            <p>of consumers place the highest level of trust in word-of-mouth</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 mb-4">
                    <div class="lp-do-card {{-- bg-white text-dark --}}" style="min-height: 100px;">
                        <div class="text-center">
                            <h5 class="title font-700 h1 {{-- color-primary --}}">90%</h5>
                            <p>more likely to trust and buy from a brand recommended by a friend</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="text-center">
            <a href="{{url('signin?tab=register')}}" style="font-size: 1.5rem;" class="btn bs px-4 px-sm-5 btn-primary-ol py-3 rounded-pill">Start converting customers to mouth publicity marketing team now</a>
        </div>

    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5 mx-auto">
            <h2 class="text-dark font-800">Frequently Ask Questions</h2>
        </div>

        <div style="max-width: 850px;" class="mx-auto">
            {{-- <div class="accordion" id="accordionFAQ"> --}}

                @php
                    $faqs = array(
                        array(
                            'que' => 'What is MouthPublicity.io?',
                            'ans' => 'MouthPublicity.io is a word of mouth tool to manage & track word of mouth of your product, services, business or personal brand. Anyone can use it for propagating and promoting the content with different objectives like increase social media presence, reach to unlimited potential customer through his own customers and ultimately build brand trust.  You can easily register their business on MouthPublicity.io and create and share their business offers with their customers through MouthPublicity.io.'
                        ),
                        array(
                            'que' => 'Is MouthPublicity.io tool is free?',
                            'ans' => 'Yes MouthPublicity.io tool is free for lifetime, you can register for free and start using this for your business or brand. No credit card required. '
                        ),
                        array(
                            'que' => 'Is my data safe with MouthPublicity.io?',
                            'ans' => 'Yes, your data is safe with MouthPublicity.io. For more details click on Privacy policy.'
                        ),
                        array(
                            'que' => 'I don\'t have a website, can I still use MouthPublicity.io?',
                            'ans' => 'Yes, you can still use MouthPublicity.io and create offers and landing pages by using customized templates.'
                        ),
                        array(
                            'que' => 'I am having an offline business so how is this concept going to help me?',
                            'ans' => 'MouthPublicity.io is built with the concept of offering true power-of-mouth publicity media to all businesses. Once created mouth publicity for your business. You can ask your customers (on cash/billing counter) to take this sharing challenge and share in their personal network. '
                        ),
                    );
                @endphp

                @foreach ($faqs as $f)

                <div class="accordion-item mb-4 border-0 shadow-sm rounded-4 bg-white">
                    <h6 class="rounded-4 mb-0" id="faqs{{$loop->iteration}}">
                        <button class="p-3 accordion-button {{ $loop->iteration == 1 ? '' : 'collapsed'}} text-decoration-none font-xlarge color-primary font-600" type="button" data-bs-toggle="collapse" data-bs-target="#faqsCol{{$loop->iteration}}" aria-expanded="true" aria-controls="faqsCol{{$loop->iteration}}">
                            {{$f['que']}}
                        </button>
                    </h6>
                    <div id="faqsCol{{$loop->iteration}}" class="accordion-collapse collapse {{ $loop->iteration == 1 ? 'show' : ''}}" aria-labelledby="faqs{{$loop->iteration}}" {{-- data-bs-parent="#accordionFAQ" --}}>
                        <div class="rounded-4 rounded-top-0 p-3 bg-light">
                            {!! $f['ans'] !!}
                        </div>
                    </div>
                </div>
                    
                @endforeach

            {{-- </div> --}}
        </div>

    </div>
    <div class="container mt-5">
        <div class="text-center">
            <a href="{{url('signin?tab=register')}}" style="font-size: 1.5rem;" class="btn bs px-4 px-sm-5 btn-primary-ol py-3 rounded-pill">Start converting customers to mouth publicity marketing team now</a>
        </div>
    </div>
</section>

{{-- offer modal --}}
<div id="offerModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            {{--<div class="modal-header">
             <h4 class="modal-title text-center"><span>Don't Go Yet!</span> <br> Get Rs. 100 for Free to your MouthPublicity.io Account</h4> --}
                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> 
            </div>--}}
            <div class="modal-body">
                <button type="button" class="btn-close popoffer-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="row align-items-center text-center">
                    <div class="col-md-4">
                        <img src="{{asset('assets/website/images/landing-page/offer-popup.png')}}" class="pop-img-width" alt="">
                    </div>
                    <div class="col-md-8">
                        <p class="offerpop-head-1 mb-0">Don't Go Yet!</p>
                        <p class="offerpop-head-2 mb-0">GET <span>&#8377;100</span> FREE</p>
                        <p class="offerpop-head-3">To Your <span>MouthPublicity.io</span> Account</p>

                    </div>
                </div>
                <div class="mt-4 px-3 small text-center">
                    <p>Are you sure you want to leave without taking advantage of our special offer? Register for MouthPublicity.io now and get Rs. 100 for free to access our pro features!</p>
                    {{-- <p></p> --}}
                    <p class="text-muted mb-0 mt-4"><a href="#" data-bs-dismiss="modal">No Thanks</a></p>
                </div>
                
            </div>
            <div class="modal-footer bg-color-gradient d-block text-center">
                <a href="#" class="popoffer-btn">Signup Now & Add free Rs. 100 </a>
            </div>
            </div>
  
    </div>
  </div>

@endsection

@push('end_body')
{{-- <script>
// offer modal script(Don't delete this script)
$(window).ready(function() {
	setTimeout(function() {
		$('#offerModal').modal ("show")
	}, 0)
})
</script> --}}
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
@endpush