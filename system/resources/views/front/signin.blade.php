@extends('layouts.front')
@php
    use Illuminate\Support\Facades\Request;
    if(Request::has('tab')){if(Request::get('tab') == 'register'){$tab = 'register';}else{$tab = '';} }else{$tab = '';}
@endphp
@section('start_head')
    <link rel="stylesheet" href="{{ asset('assets/uploads/tmp/assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">


    <style>
    .session_name,
    .session_name:focus-visible{
        background: unset;
        border: unset;
        padding: unset;
        color: #fff;
    }
    #rebtn{}
    .otp-massage{line-height: 1;
        display: inline-block;
        padding: 10px;
        color: #000;
        background-color: #ffebeb;
        border-radius: 4px;
    }

    .fa-spinner:before {
        content: "\f110";
        color: rgb(0,255,175);
    }
    
    .error{
        font-size: 80%;
    }

    .text-error{
        color: red;
    }
</style>


@endsection
@section('title', 'Login, Registration | OpenChallenge')
@section('content')

<section id="signup" class="signup_media_query">
    <span class="splashes dots-top"></span>
    <span class="splashes dots-color-bottom"></span>
    <div class="py-5">
        <div class="container">
            <div class="mb-5">
                <a href="{{ url('') }}"><img src="{{ asset('assets/front/images/logo-light.svg') }}" class="main_logo" alt="OpenChallenge"></a>
            </div>

            <div class="row justify-content-between">
                <div class="col-md-6 order-2 order-md-1">
                    <div class="text-white">
                        <h1 class="su_title font-800 oplk-text-gradient d-inline-block">Welcome To<br>OpenChallenge.</h1>
                        <p class="mb-0">Register / Login to OpenChallenge to grow your business now. OpenChallenge is an organic marketing platform where you can market your brand, products, and services to new and existing customers. With OpenChallenge, you can boost your customer reach and brand awareness by simply generating a link.</p>
                    </div>

                    <div class="mt-4 text-white">
                        <p class="font-h3 h4 font-400">care@mouthpublicity.io</p>

                        <div class="social_media_icons">
                            <ul class="smi_row mb-0">
                                @if($info->facebook != '')
                                    @if($info->facebook != '#')
                                        <li class="smi_list"><a href="{{ $info->facebook }}" target="_blank"><i class="bi bi-facebook"></i></a></li>
                                    @endif
                                @endif
                                @if($info->instagram != '')
                                    @if($info->instagram != '#')
                                        <li class="smi_list"><a href="{{ $info->instagram }}" target="_blank"><i class="bi bi-instagram"></i></a></li>
                                    @endif
                                @endif
                                @if($info->linkedin != '')
                                    @if($info->linkedin != '#')
                                        <li class="smi_list"><a href="{{ $info->linkedin }}" target="_blank"><i class="bi bi-linkedin"></i></a></li>
                                    @endif
                                @endif
                                @if($info->twitter != '')
                                    @if($info->twitter != '#')
                                        <li class="smi_list"><a href="{{ $info->twitter }}" target="_blank"><i class="bi bi-twitter"></i></a></li>
                                    @endif
                                @endif
                                @if($info->youtube != '')
                                    @if($info->youtube != '#')
                                        <li class="smi_list"><a href="{{ $info->youtube }}" target="_blank"><i class="bi bi-youtube"></i></a></li>
                                    @endif
                                @endif
                                {{-- @if($info->pinterest != '')
                                    @if($info->pinterest != '#')
                                        <li class="smi_list">
                                            <a href="https://www.pinterest.com/openlinkk" target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="40" style="vertical-align: text-top" fill="currentColor" class="bi bi-pinterest" viewBox="0 0 16 16">
                                                    <path d="M8 0a8 8 0 0 0-2.915 15.452c-.07-.633-.134-1.606.027-2.297.146-.625.938-3.977.938-3.977s-.239-.479-.239-1.187c0-1.113.645-1.943 1.448-1.943.682 0 1.012.512 1.012 1.127 0 .686-.437 1.712-.663 2.663-.188.796.4 1.446 1.185 1.446 1.422 0 2.515-1.5 2.515-3.664 0-1.915-1.377-3.254-3.342-3.254-2.276 0-3.612 1.707-3.612 3.471 0 .688.265 1.425.595 1.826a.24.24 0 0 1 .056.23c-.061.252-.196.796-.222.907-.035.146-.116.177-.268.107-1-.465-1.624-1.926-1.624-3.1 0-2.523 1.834-4.84 5.286-4.84 2.775 0 4.932 1.977 4.932 4.62 0 2.757-1.739 4.976-4.151 4.976-.811 0-1.573-.421-1.834-.919l-.498 1.902c-.181.695-.669 1.566-.995 2.097A8 8 0 1 0 8 0z"/>
                                                </svg>
                                            </a>
                                        </li>
                                    @endif
                                @endif --}}
                                
                                @if($info->tumblr != '')
                                    @if($info->tumblr != '#')
                                        <li class="smi_list"><a href="https://www.tumblr.com/blog/openlinkblog" target="_blank"><i class="bi bi-tumblr"></i></a></li>
                                    @endif
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 order-1 order-md-2">
                    <div class="signinoutTab">
                        
                        <ul class="nav nav-tabs" id="SignInOut" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active btn-lg" id="signin_tab" data-bs-toggle="tab" data-bs-target="#signin_content" type="button" role="tab" aria-controls="signin_content" aria-selected="true">Login</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link btn-lg" id="signup_tab" data-bs-toggle="tab" data-bs-target="#signup_content" type="button" role="tab" aria-controls="signup_content" aria-selected="false">Register</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="SignInOutContent">

                            <!-- Login Form  -->
                            <div class="tab-pane fade show active" id="signin_content" role="tabpanel" aria-labelledby="signin_tab">
                                <!-- Login Form  -->
                                <div class="signForm py-5" id="__login_form__">
                                    <form action="{{ route('postLogin') }}" method="post" class="line-form loginform" id="_SignInForm_">
                                        @csrf
                                        <div class="form-group">
                                            <!-- <label for="">ID/Mobile Number</label> -->
                                            <input type="text" name="username" id="loginEmail" class="form-control three-space-validation @error('username') is-invalid @enderror form-control-lg" required autocomplete="username" autofocus placeholder="Email ID/WhatsApp Number" value="{{ old('username') }}">
                                            @error('username')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <!-- <label for="">Password</label> -->
                                            <input type="password" name="password" id="loginPassword" class="form-control form-control-lg @error('password') is-invalid @enderror" required placeholder="Password" autocomplete="current-password">
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="loginRemember" name="remember" checked>
                                            <label class="form-check-label" for="loginRemember">
                                                Remember Me
                                            </label>
                                        </div>
                                        <div class="mb-3">
                                            <input type="submit" value="Login" class="btn btn-theme btn-lg w-100" id="loginFormBtn">
                                        </div>
                                        <style>
                                            .link_btn{
                                                color: #FFF;
                                                text-decoration: none;
                                            }
                                            .link_btn:hover{
                                                color: var(--color-thm-drk);
                                                text-decoration: none;
                                            }
                                        </style>
                                        <div>
                                            <a href="#" class="link_btn" id="forgot_form_btn" onclick="loginForgot(); return false;">Forgot Password?</a>
                                        </div>
                                    </form>
                                </div>

                                {{-- Forgot Password form  --}}
                                <div id="__ol_forgot_form__" class="text-white mt-4" style="display: none">
                                    <form action="{{ route('forgotPasswordEmail') }}" method="post" class="line-form">
                                     {{-- @csrf --}}
                                         <div>
                                             <h5>Forgot Password</h5>
                                         </div>
                                        <div class="form-group">
                                            <label for="forgot_pass_username" class="mb-3">Enter Email ID or Mobile Number</label>
                                            <input type="text" name="username" id="forgot_pass_username" required class="form-control three-space-validation @error('username') is-invalid @enderror form-control-lg" autocomplete="username" placeholder="Email ID/Mobile Number">
                                        </div>
     
                                        <div class="mt-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <button type="submit" id="forgotPass" class="btn btn-theme px-4">
                                                   Submit
                                                </button>
                                                <a href="#" class="link_btn" id="goBackLogin">Go To Login</a>
                                            </div> 
                                        </div>
                                    </form>
                                </div>
                            </div>
                            

                            <!-- Registration form  -->
                            <div class="tab-pane fade" id="signup_content" role="tabpanel" aria-labelledby="signup_tab">
                                <form action="" method="post" class="line-form basicform" id="basicform">
                                    @csrf
                                    <div class="signForm py-5 text-white">
                                        <!-- Register Form -->
                                        <div id="__regisFrm__">
                                            {{-- <form action="{{ route('register') }}" method="post" class="line-form" id="_SignUpForm_"> --}}
                                            <div class="line-form" id="_SignUpForm_">
                                                <div class="form-group">
                                                    <input type="text" name="name" id="name" class="form-control form-control-lg three-space-validation" placeholder="Your Name" required>
                                                </div>
                                                <div class="form-group">
                                                    <input type="tel" name="mobile" id="mobile" class="form-control form-control-lg no-space-validation number-validation" placeholder="Your WhatsApp Number (10 Digits)" minlength="10" maxlength="10" required>
                                                    <div class="mobile-error"></div>
                                                </div>
                                                <div class="form-group">
                                                    <input type="email" name="email" id="email" class="form-control form-control-lg" placeholder="Your Email Address">
                                                    <div class="email-error"></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group ">
                                                            <input type="password" name="password" id="password" class="form-control form-control-lg no-space-validation" placeholder="Set Password *" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <input type="password" name="confirm_password" id="confirm_password" class="form-control form-control-lg no-space-validation" placeholder="Confirm Password *" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <input type="submit" value="Register Now" class="btn btn-theme btn-lg w-100 basicbtn send-otp-btn" onClick="sendOTP();">
                                                </div>
                                            </div>
                                            {{-- </form> --}}
                                        </div>
                                        <!-- END Register Form -->

                                        <!-- OTP Form  -->
                                        <div id="__otpFrm__" style="display:none;">
                                            {{-- <form action="#" method="post" class="line-form" id="_OTP_Form_"> --}}
                                            <div class="line-form" id="_OTP_Form_">
                                                
                                                <div class="">
                                                    <p class="text-success"><i class="bi bi-patch-check-fill"></i> OTP is sent on your mobile number.</p>

                                                    <p class="text-error"></p>

                                                    <div class="d-flex justify-content-between">
                                                        <input class="session_name" type="text" value="<?php echo $_SESSION['session_number'] ?? ''; ?>" id="valedit" name="val" readonly>
                                                        {{-- <span onclick="editNumber()" style="cursor:pointer;"> --}}
                                                        {{-- <span> --}}
                                                        <span onclick="editNumber()" style="cursor:pointer;" class="btn btn-sm btn-outline-light" title="Edit Number" data-bs-toggle="tooltip"><i class="bi bi-pencil"></i></span>
                                                        {{-- </span> --}}
                                                    </div>
                                                    <hr>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" name="otp" id="otp" inputmode="numeric" autocomplete="one-time-code" pattern="\d{6}" required="" class="form-control form-control-lg no-space-validation number-validation" placeholder="Enter OTP" maxlength="6">
                                                </div>
                                                <div class="mt-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <div class="d-flex align-items-center">
                                                                <input type="button" id="button_otpVer" class="btn btn-theme px-4 basicbtn" value="Verify OTP" onClick="verifyOTP();">
                                                                <span  id="loading_icon" class="ms-2" style="display:none;">
                                                                    <i class="fa fa-spinner fa-2x fa-spin"></i>
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <div id="rebtn" style="padding-left:15px;">
                                                            <button type="button" id="ReSendOtpBtn" class="btn btn-sm btn-outline-secondary" style="display:none;" onClick="resendOTP();">
                                                                Resend OTP
                                                            </button>
                                                            <span class="otp-massage" style="display:none;"></span>
                                                            <span>
                                                                <span class="resend-count">Resend OTP In</span>
                                                                <span class="js-timeout">2:00</span>
                                                            </span>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                            {{-- </form> --}}
                                        </div>
                                        <!-- END OTP Form  -->
                                        
                                        <!-- Change Number Form  -->
                                        <div id="__chngPhFrm__" style="display:none;">
                                            {{-- <form action="#" method="post" class="line-form" id="_Change_Phone_Form_"> --}}
                                            <div class="line-form" id="_Change_Phone_Form_">
                                                <div class="form-group">
                                                    <label for="mobile_resend">Mobile No.</label>
                                                    <input type="tel" name="mobile_resend" id="mobile_resend" required="" class="form-control form-control-lg no-space-validation number-validation" required="" maxlength="10" placeholder="Enter Mobile Number...">
                                                </div>

                                                <div class="mt-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <button type="button" id="changePhoneBtn" class="btn btn-theme px-4" onclick="sendOTP();">
                                                            Change
                                                        </button>
                                                        <div>
                                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="goBack()">
                                                                Go Back
                                                            </button>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                            {{-- </form> --}}
                                        </div>
                                        <!-- END Change Number Form  -->
                                    </div>
                                </form>
                            </div>

                                    
                            </div>

                        </div>
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

    <script type="text/javascript">
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

        function Sweet(icon,title,time=3000){
        
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: time,
                timerProgressBar: true,
                onOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: icon,
                title: title,
            })
        }

        $(document).ready(function(){
            
            setTimeout('$("#error").hide()',3000);
            setTimeout('$("#success").hide()',3000);
            var tab = "{{ $tab }}";
            if(tab == 'register'){
                $('#signup_tab').click();
            }

            $(document).on('click', '#goBackLogin', function(){
                $('#__ol_forgot_form__').hide();
                $('#__login_form__').show();
            });

            $(document).on('click', '#forgotPass', function(){
                var btn = $(this);
                var basicbtnhtml=$(this).html();
                var username = $("#forgot_pass_username").val();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var input = {
                    "username" : username,
                    "_token" : CSRF_TOKEN
                };
                console.log(input);
                $.ajax({
                    url : "{{ route('forgotPasswordEmail') }}",
                    type : 'POST',
                    data : input,
                    dataType : "json",
                    beforeSend: function() {
                        
                        btn.html("Please Wait....");
                        btn.attr('disabled','');

                    },
                    success: function(response){
                        btn.removeAttr('disabled')
                        btn.html(basicbtnhtml);
                        if(response.type == 'error'){
                            Sweet('error',response.message);
                        }else if(response.type == 'success'){
                            Sweet('success',response.message);
                            $('#__ol_forgot_form__').hide();
                            $('#__login_form__').show();
                        }
                        
                    },
                    error: function(xhr, status, error) 
                    {
                        btn.html(basicbtnhtml);
                        btn.removeAttr('disabled')
                        Sweet('error',response.message);
                    }
                });
            });
        });

        function editNumber(){
            $(".text-error").hide();
            $('#__chngPhFrm__').show();
            $('#_OTP_Form_').hide();
        }

        function goBack(){   
            $("#button_otpVer").show();
            $('#__chngPhFrm__').hide();
            $('#_OTP_Form_').show();
        }

        function loginForgot(){
           $('#__ol_forgot_form__').show();
           $('#__login_form__').hide();
        }
    </script>
    @include('auth.scripts.validation')
    @include('auth.scripts.otp')
@endsection