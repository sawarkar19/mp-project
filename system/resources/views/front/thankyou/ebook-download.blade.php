@extends('layouts.front')
@php
    use Illuminate\Support\Facades\Request;
    if(Request::has('tab')){if(Request::get('tab') == 'register'){$tab = 'register';}else{$tab = '';} }else{$tab = '';}
@endphp
@section('start_head')
    <link rel="stylesheet" href="{{ asset('assets/uploads/tmp/assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">


    <style>
    #thankYou {
        position: relative; 
        background-color: #fff; 
        min-height: 100vh;
        overflow: hidden; 
    }
    .splashes.dots-color-bottom-ty {
        content: url(assets/front/images/dots-colorbt-ty.png);
        bottom: 421px;
        left: -8px;
        width: 200px;
    }
    .splashes.dots-top-ty {
        content: url(assets/front/images/dots-ty.png);
        top: 122px;
        right: 22%;
        width: 100px;
    }
    .ty-txt1 {
        max-width: 50%;
        margin: 0 auto;
        font-size: 28px;
    }
    .btnW {
        width: 184px;
        padding: 13px 0px !important;
        margin: 0px 15px;
    }
    .oplk-text-gradient-rev {
        background: #00FFAF;
        background: -webkit-linear-gradient(120deg, #00249C, #00FFAF);
        background: -moz-linear-gradient(120deg, #00249C, #00FFAF);
        background: linear-gradient(120deg, #00249C, #00FFAF);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    @media (max-width: 767px){
        .btnW {
            width: 150px;
            padding: 13px 0px !important;
            margin: 0px 2px;
        }
        .ty-txt1 {
            max-width: 100%;
        }
    }

    </style>


@endsection
@section('title', 'Thank You | OpenChallenge')
@section('content')

<section id="thankYou">
    <span class="splashes dots-top-ty"></span>
    <span class="splashes dots-color-bottom-ty"></span>
    <div class="py-5">
        <div class="container">
           <div class="mb-5">
                <a href="{{ url('') }}"><img src="{{ asset('assets/front/images/logo-dark.svg') }}" class="main_logo" alt="OpenChallenge"></a>
            </div>

            <div class="row justify-content-between text-center">
                <img src="{{ asset('assets/front/images/thankyou.png') }}" class="img-fluid" style="width: 600px; margin: 0 auto;">
                <div class="mt-5">
                    <div class="oplk-text-gradient-rev d-inline-block mx-auto">
                        <h4 class="font-600 text-uppercase ">YEAH, IT'S ON THE WAY.!!!</h4>
                        <h6 class="text-uppercase">OHHHH IT'S ALREADY REACHED.!!!</h6>
                    </div>
                    
                    <h6 class="mt-4 font-600 ty-txt1">Check your inbox you must receive the OpenChallenge E-book.</h6>
                    <div class="mt-5">
                        <a href="#" class="btn btn-theme btnW"><i class="bi bi-arrow-left"></i> Back to Home</a>
                        <a href="#" class="btn btn-theme btnW"><i class="bi bi-geo-alt"></i> Contact us</a>
                    </div>
                    <div class="mt-5 font-600">
                        <p class="text-muted">See How OpenChallenge mouth publicity media is changing and growing businesses. Be one of them now..!</p>
                        <h4>You are Awesome Seriously..!</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
 

@endsection
@section('end_body')
    <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/js/form.js') }}"></script>
    <script src="{{ asset('assets/js/admin/register.js') }}"></script>
    <script src="{{ asset('assets/js/input-validation.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>

    @include('auth.scripts.validation')
    @include('auth.scripts.otp')
@endsection