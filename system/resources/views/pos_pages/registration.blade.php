<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Bootstrap 5.2.0 -->
    <link rel="stylesheet" href="{{ asset('assets/website/vendor/bootstrap/css/bootstrap.min.css') }}">

    <!-- ICONS (Bootstrap) V1.5.0 -->
    <link rel="stylesheet" href="{{ asset('assets/website/vendor/bootstrap-icons/font/bootstrap-icons.css') }}">
        <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="{{ asset('assets/website/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/website/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/website/css/customs.css') }}">
<style>
    .main-logo-mp{
        max-width: 200px;
        margin: auto;
    }
    .info-form-card{
        width: 100%;
        max-width: 1000px;
        margin: auto;
        background-color: #F2F5FD;
        border-radius: 8px;
        position: relative;
    }
    .info-form-card .info-form-card-inner{
        position: relative;
        z-index: 2;
    }
    .send-otp{
        position: absolute;
        right: 10px;
        top: 69px;
        font-size: 12px;
    }
    .verify-otp{
        position: absolute;
        right: 10px;
        top: 45px;
        font-size: 12px;
    }
    .send-otp a ,.verify-otp a{
        text-decoration: none;

    }
    .pos-registration-form .form-control{
        padding: 0.7rem 1rem;
        font-size: .9rem;
        font-weight: 600;
        outline: 0!important;
        border-color: #888;

    }
    .reg-img{
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    .wp-padding{
        padding: 20px;
    }
    .br-left-to-top {
        border-radius: 0.6rem 0 0 0.6rem;
    }
    .br-right-to-bottom {
        border-radius: 0 0.6rem 0.6rem 0;
    }
    .bullet{
        display: inline;
        margin: 0 4px;
    }
    .pos-footer {
        padding: 15px 0px;
        color: var(--cl-default);
        display: inline-block;
        width: 100%;
        background: #fff;
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

    @keyframes dot-flashing {
        0% {
            background-color: #2204a9;
        }
        50%, 100% {
            background-color: rgba(152, 128, 255, 0.2);
        }
    }
    @media(max-width: 767px){
        .br-left-to-top {
            border-radius: 0.6rem 0.6rem 0 0;
        }
        .br-right-to-bottom {
            border-radius: 0 0 0.6rem 0.6rem;
        }
        .reg-img{
            position: relative;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    }
</style>
</head>
<body>
    {{-- Information section --}}
    <section id="registration">
        <div class="info-form py-5 px-3">
            <div class="container">
                <div class="text-center mb-4">
                    {{-- <a class="" href="{{url('/')}}">
                        <img src="{{asset('assets/website/images/logos/logo-dark.svg')}}" alt="MouthPublicity" class="main-logo-mp">
                    </a>
                    <div class="stage">
                        <div class="dot-flashing"></div>
                      </div> --}}
                    <a class="" href="{{url('/')}}">
                        <img src="{{asset('assets/website/images/logos/logo-dark.svg')}}" alt="MouthPublicity" class="main-logo-mp">
                    </a>
                </div>
                <div class="info-form-card shadow">  
                    <div class="info-form-card-inner">
                        <div class="row">
                            <div class="col-md-6 bg-color-gradient br-left-to-top wp-padding position-relative">
                                <div class="text-center text-white h-100 position-relative bg-dot overflow-hidden">
                                    <img src="{{asset('assets/website/images/pos/registration.png')}}"  class="img-fluid reg-img">
                                </div>
                                
                            </div>
                            <div class="col-md-6 wp-padding border br-right-to-bottom bg-white">
                                <div class="px-3">
                                    <h5 class="color-primary font-800">Fill in Details</h5>

                                    {{-- Information Form --}}
                                    <form class="form-type-one" method="post" action="{{ route('sendPosOTP') }}" id="sendPosOTPForm">
                                        @csrf
                                        
                                        <input type="hidden" name="enterprise_info_token" value="{{ $str }}" />

                                        <div class="form-group mb-3">
                                            <label>Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control mt-2 shadow-sm" name="name" placeholder="Name" value="{{ $name }}">
                                            <span class="text-danger error-message name-error"></span>
                                        </div>
                                        <div class="form-group mb-3 position-relative">
                                            <label>WhatsApp number <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control mt-2 shadow-sm"  name="mobile" placeholder="WhatsApp Number" value="{{ $mobile }}">
                                            <span class="text-danger error-message number-error"></span>
                                        </div>
                                
                                        <div class="form-group mb-3">
                                            <label>Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control mt-2 shadow-sm"  name="email" placeholder="Email Address" value="{{ $email }}">
                                            <span class="text-danger error-message email-error"></span>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>Password <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control mt-2 shadow-sm" name="password" placeholder="Password">
                                            <span class="text-danger error-message password-error"></span>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>Confirm Password <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control mt-2 shadow-sm" name="password_confirmation" placeholder="Confirm Password">
                                            <span class="text-danger error-message confirm-password-error"></span>
                                        </div>

                                        <button type="submit" class="sendbtn btn btn-primary-ol btn-lg w-100 my-3">Send OTP</button>

                                        <p class="text-danger error-message other-error"></p>
                                        
                                    </form>

                                    
                                    <form class="form-type-one" method="post" action="{{ route('verifyPosOTP') }}" id="verifyPosOTPForm" style="display:none;">
                                        @csrf

                                        <input type="hidden" name="enterprise_info_token" value="{{ $str }}" />

                                        <div class="form-group mb-3 position-relative">
                                            <label>Whatsapp Number <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control mt-2 shadow-sm" name="mobile" id="whatsapp_number" placeholder="Enter whatsapp number" value="{{ session()->get('session_number') }}">
                                            <span class="text-danger error-message number-error"></span>
                                        </div>

                                        <div class="form-group mb-3 position-relative">
                                            <label>Enter OTP <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control mt-2 shadow-sm" name="otp" placeholder="Enter OTP" id="otp">
                                            <span class="text-danger error-message otp-error"></span>
                                        </div>

                                        <div class="text-end" style="padding-left:15px;">
                                            <div>
                                                <button type="button" id="ReSendOtpBtn" class="btn btn-sm btn-outline-dark px-3" style="display:none;">
                                                    Resend OTP
                                                </button>
                                            </div>
                                            <div>
                                                <span>
                                                    <span class="resend-count small">Resend OTP In</span>
                                                    <span class="js-timeout">2:00</span>
                                                </span>
                                            </div>
                                        </div>

                                        <button type="submit" id="VerifySendOtpBtn" class="verifybtn btn btn-primary-ol btn-lg w-100 my-3">Verify OTP</button>

                                        <p class="text-success success-message other-success"></p>
                                        <p class="text-danger error-message other-error"></p>

                                    </form>
                                </div>
                            </div>
                        </div>    
                    </div>
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

    <script>

        var interval;

        function countdown() {
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
                        $('.js-timeout').hide();
                        $('.resend-count').hide();
                        $('#ReSendOtpBtn').show();
                    }
            }, 1000);
        }

        $("#ReSendOtpBtn").on('click', function() {
            var mobile = $('#whatsapp_number').val();
            $('#otp').val('');

            //hide errors
            $('.error-message').hide();
            $('.success-message').hide();

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var input = {
                            "mobile" : mobile,
                            "_token" : CSRF_TOKEN
                        };

            var resendbtnhtml = $('.resendbtn').html();
            $.ajax({
                url : '{{ route('resendPosOTP') }}',
                type : 'POST',
                data : input,
                dataType : "json",
                beforeSend: function() {

                    $('.resendbtn').html("Please Wait....");
                    $('.resendbtn').attr('disabled', '')

                },
                success: function(response) {

                    if(response.status){
                        $('.other-success').text(response.message);
                        $('.other-success').show();
                        $('.js-timeout').text("2:00");
                        $('.js-timeout').show();
                        $('.resend-count').show();
                        $('#ReSendOtpBtn').hide();
                        countdown();
                    }else{
                        $('.other-error').text(response.message);
                        $('.other-error').show();
                    }   

                    $('.resendbtn').removeAttr('disabled')
                    $('.resendbtn').html(resendbtnhtml);
                    
                },
                error: function(xhr, status, error) {
                    $('.resendbtn').html(resendbtnhtml);
                    $('.resendbtn').removeAttr('disabled');

                    $.each(xhr.responseJSON.errors, function(key, item) {
                        if(key == 'mobile'){
                            $('.number-error').text(item[0]);
                            $('.number-error').show();
                        }
                        
                    });
                }
            });
        });

        $("#sendPosOTPForm").on('submit', function(e) {
            e.preventDefault();

            //hide errors
            $('.error-message').hide();
            $('.success-message').hide();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var sendbtnhtml = $('.sendbtn').html();
            $.ajax({
                type: 'POST',
                url: this.action,
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {

                    $('.sendbtn').html("Please Wait....");
                    $('.sendbtn').attr('disabled', '')

                },
                success: function(response) {

                    if(response.status){
                        $('#sendPosOTPForm').hide();
                        $('#verifyPosOTPForm').show();
                        $('.other-success').text(response.message);
                        $('.other-success').show();
                        $('#whatsapp_number').val(response.session_number);
                        countdown();
                    }else{
                        $('.other-error').text(response.message);
                        $('.other-error').show();
                    }   

                    $('.sendbtn').removeAttr('disabled')
                    $('.sendbtn').html(sendbtnhtml);
                    
                },
                error: function(xhr, status, error) {
                    $('.sendbtn').html(sendbtnhtml);
                    $('.sendbtn').removeAttr('disabled')

                    $.each(xhr.responseJSON.errors, function(key, item) {
                        if(key == 'name'){
                            $('.name-error').text(item[0]);
                            $('.name-error').show();
                        }

                        if(key == 'email'){
                            $('.email-error').text(item[0]);
                            $('.email-error').show();
                        }

                        if(key == 'mobile'){
                            $('.number-error').text(item[0]);
                            $('.number-error').show();
                        }

                        if(key == 'password'){
                            $('.password-error').text(item[0]);
                            $('.password-error').show();
                        }

                        if(key == 'password_confirmation'){
                            $('.confirm-password-error').text(item[0]);
                            $('.confirm-password-error').show();
                        }
                        
                    });
                    
                }
            })
        });


        $("#verifyPosOTPForm").on('submit', function(e) {
            e.preventDefault();

            //hide errors
            $('.error-message').hide();
            $('.success-message').hide();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var verifybtnhtml = $('.verifybtn').html();
            $.ajax({
                type: 'POST',
                url: this.action,
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {

                    $('.verifybtn').html("Please Wait....");
                    $('.verifybtn').attr('disabled', '')

                },
                success: function(response) {

                    if(response.status){
                        window.location.href = response.redirect_url;
                    }else{
                        $('.other-error').text(response.message);
                        $('.other-error').show();
                    }

                    $('.verifybtn').removeAttr('disabled')
                    $('.verifybtn').html(verifybtnhtml);
                    
                },
                error: function(xhr, status, error) {
                    $('.verifybtn').html(verifybtnhtml);
                    $('.verifybtn').removeAttr('disabled')
                }
            })
        });
    </script>
</body>
