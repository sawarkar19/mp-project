@extends('layouts.website')

@php
    use Illuminate\Support\Facades\Request;
    if(Request::has('tab')){if(Request::get('tab') == 'register'){$tab = 'register';}else{$tab = '';} }else{$tab = '';}
@endphp

@section('title', 'Login, Registration | MouthPublicity.io')
@section('description', 'Sign in to MouthPublicity.io, the mouth publicity tool that helps you grow your business through word-of-mouth with the power of Social Media.')
{{-- @section('keywords', '') --}}
{{-- @section('image', '') --}}

@section('end_head')
<style>
    .session_name,
    .session_name:focus{
        background: unset;
        border: unset;
        padding: unset;
        outline: none;
        box-shadow: none;
        font-weight: 600;
    }
    .otp-massage{
        /* line-height: 1;
        display: inline-block;
        padding: 10px;
        color: #000;
        background-color: #ffebeb;
        border-radius: 4px; */
    }
    .error{
        font-size: 75%;
        color: #e91313;
    }
    .text-error{
        color: #e91313;
    }
    /* eye button */
    .password-eyeicon{
        position:absolute;
        right: 14px;
        top: 10px;
    }
</style>
@endsection

@section('content')
<section id="signup" class="signup_media_query">
    <span class="splashes dots-top"></span>
    <span class="splashes dots-color-bottom"></span>

    <div class="py-sm-5 py-4">
        <div class="container">

            <div class="row justify-content-between align-items-center">
                <div class="col-md-6 order-2 order-md-1 py-4">
                    <div class="">
                        <h1 class="su_title font-900 color-gradient d-inline-block">Welcome To<br>MouthPublicity.io</h1>
                        <p class="mb-0">Register / Login to MouthPublicity.io to start and manage your business mouth publicity now. MouthPublicity.io is an organic marketing platform where you can market your brand, products, and services to new and existing customers. With MouthPublicity.io, you can boost your customer reach and brand awareness by simply launching mouth publicity campaign.</p>
                    </div>

                    <div class="mt-4">
                        <p class="h5 font-700">care@mouthpublicity.io</p>

                        <div class="social-media-icons color-primary" style="font-size: 1.5rem;">
                            <ul class="s-m-row mb-0">
                                @if($info->facebook != '')
                                    @if($info->facebook != '#')
                                        <li class="s-m-list"><a href="{{ $info->facebook }}" target="_blank" data-bs-toggle="tooltip" data-bs-custom-class="social-tooltip" title="Facebook"><i class="bi bi-facebook"></i></a></li>
                                    @endif
                                @endif
                                @if($info->instagram != '')
                                    @if($info->instagram != '#')
                                        <li class="s-m-list"><a href="{{ $info->instagram }}" target="_blank" data-bs-toggle="tooltip" data-bs-custom-class="social-tooltip" title="Instagram"><i class="bi bi-instagram"></i></a></li>
                                    @endif
                                @endif
                                @if($info->linkedin != '')
                                    @if($info->linkedin != '#')
                                        <li class="s-m-list"><a href="{{ $info->linkedin }}" target="_blank" data-bs-toggle="tooltip" data-bs-custom-class="social-tooltip" title="Linkedin"><i class="bi bi-linkedin"></i></a></li>
                                    @endif
                                @endif
                                @if($info->twitter != '')
                                    @if($info->twitter != '#')
                                        <li class="s-m-list"><a href="{{ $info->twitter }}" target="_blank" data-bs-toggle="tooltip" data-bs-custom-class="social-tooltip" title="Twitter"><i class="bi bi-twitter"></i></a></li>
                                    @endif
                                @endif
                                @if($info->youtube != '')
                                    @if($info->youtube != '#')
                                        <li class="s-m-list"><a href="{{ $info->youtube }}" target="_blank" data-bs-toggle="tooltip" data-bs-custom-class="social-tooltip" title="Youtube"><i class="bi bi-youtube"></i></a></li>
                                    @endif
                                @endif
                            </ul>
                        </div>

                    </div>
                </div>

                <div class="col-md-6 order-1 order-md-2">
                    <div class="signinoutTab">

                        @php    
                            if(isset(request()->req) && request()->req == 'demo'){
                                $login_title = 'Demo Login';
                            }else{
                                $login_title = 'Login';
                            }
                        @endphp
                        
                        <ul class="nav nav-tabs" id="SignInOut" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link @if($tab != 'register') active @endif" id="signin_tab" data-bs-toggle="tab" data-bs-target="#signin_content" type="button" role="tab" aria-controls="signin_content" aria-selected="true">{{ $login_title }}</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link @if($tab === 'register') active @endif" id="signup_tab" data-bs-toggle="tab" data-bs-target="#signup_content" type="button" role="tab" aria-controls="signup_content" aria-selected="false">Register</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="SignInOutContent">

                            <div class="tab-pane fade @if($tab != 'register') show active @endif" id="signin_content" role="tabpanel" aria-labelledby="signin_tab">
                                <!-- Login Form  -->
                                <div class="signForm pt-5" id="__login_form__">
                                    <form action="{{ route('postLogin') }}" method="post" class="form-type-one" id="_SignInForm_">
                                        @csrf

                                        <input type="hidden" name="force_login_check" id="force_login_check" value="0" />

                                        @if($login_title == 'Demo Login')
                                            <div class="form-group mb-3">
                                                <!-- <label for="">ID/Mobile Number</label> -->
                                                <input type="text" name="username" minlength="10" maxlength="70" id="loginEmail" class="form-control shadow-sm three-space-validation @error('username') is-invalid @enderror form-control-lg" required autocomplete="username" autofocus placeholder="Email ID/WhatsApp Number" value="{{ old('username', $user_mobile) }}" readonly>
                                                @error('username')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3 password-field position-relative">
                                                <!-- <label for="">Password</label> -->
                                                <input type="password" name="password" value="{{ $user_pass }}" id="loginPassword" class="form-control shadow-sm form-control-lg @error('password') is-invalid @enderror" required placeholder="Password" autocomplete="current-password" readonly>
                                                <span toggle="#password-field" class="bi bi-eye-fill password-eyeicon toggle-loginpassword"></span>
                                            </div>
                                        @else
                                            <div class="form-group mb-3">
                                                <!-- <label for="">ID/Mobile Number</label> -->
                                                <input type="text" name="username" minlength="10" maxlength="70" id="loginEmail" class="form-control shadow-sm three-space-validation @error('username') is-invalid @enderror form-control-lg" required autocomplete="username" autofocus placeholder="Email ID/WhatsApp Number" value="{{ old('username', $user_mobile) }}">
                                                @error('username')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3 password-field position-relative">
                                                <!-- <label for="">Password</label> -->
                                                <input type="password" name="password" value="{{ $user_pass }}" id="loginPassword" class="form-control shadow-sm form-control-lg @error('password') is-invalid @enderror" required placeholder="Password" autocomplete="current-password">
                                                <span toggle="#password-field" class="bi bi-eye-fill password-eyeicon toggle-loginpassword"></span>
                                            </div>
                                        @endif

                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" value="" id="loginRemember" name="remember" checked>
                                            <label class="form-check-label" for="loginRemember">
                                                Remember Me
                                            </label>
                                        </div>
                                        <div class="mb-2">
                                            <input type="submit" value="Login" class="btn btn-primary-ol btn-lg w-100" id="loginFormBtn">
                                        </div>
                                        <div>
                                            <a href="#" class="btn btn-link-ol" id="forgot_form_btn" onclick="loginForgot(); return false;">Forgot Password?</a>
                                        </div>
                                        {{-- MULTIPLE login  --}}
                                        <!-- <div class="mb-2">
                                            <input type="button" value="multiple Login" class="btn btn-primary-ol btn-lg"  data-bs-toggle="modal" data-bs-target="#multiple-login">
                                        </div> -->
                                    </form>
                                </div>
                                
                                {{-- Forgot Password form  --}}
                                <div id="__ol_forgot_form__" class="mt-4" style="display: none">
                                    <form action="{{ route('forgotPasswordEmail') }}" method="post" class="form-type-one">
                                     {{-- @csrf --}}
                                        <div class="mb-3">
                                            <h5 class="color-primary font-700">Forgot Password</h5>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="forgot_pass_username" class="mb-3">Enter Email ID or Mobile Number</label>
                                            <input type="text" name="username" id="forgot_pass_username" minlength="10" maxlength="70" required class="form-control shadow-sm three-space-validation @error('username') is-invalid @enderror form-control-lg" autocomplete="username" placeholder="Email ID/Mobile Number">
                                        </div>
                                        <div class="">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <button type="submit" id="forgotPass" class="btn btn-primary-ol px-4">Submit</button>
                                                <div class="mt-sm-2">
                                                    <a href="#" class="btn btn-link-ol" id="goBackLogin">Go To Login</a>
                                                </div>
                                            </div> 
                                        </div>
                                    </form>
                                </div>
                            </div>
                            

                            <!-- Registration form  -->
                            <div class="tab-pane fade @if($tab === 'register') show active @endif" id="signup_content" role="tabpanel" aria-labelledby="signup_tab">
                                <form action="" method="post" class="basicform" id="basicform">
                                    @csrf
                                    <div class="signForm pt-5">
                                        <!-- Register Form -->
                                        <div id="__regisFrm__">
                                            {{-- <form action="{{ route('register') }}" method="post" class="line-form" id="_SignUpForm_"> --}}
                                            <div class="form-type-one" id="_SignUpForm_">
                                                <div class="form-group mb-3">
                                                    <input type="text" name="name" id="name" class="form-control form-control-lg shadow-sm three-space-validation mtc_trigger" data-mtcinput="#mauticform_input_registerorsignupform_f_name" placeholder="Your Name *" required>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <input type="tel" name="mobile" id="mobile" class="form-control form-control-lg shadow-sm no-space-validation number-validation mtc_trigger" data-mtcinput="#mauticform_input_registerorsignupform_whatsapp_number" placeholder="WhatsApp Number * (10 Digits)" minlength="10" maxlength="10" required>
                                                    <div class="mobile-error"></div>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <input type="email" name="email" id="email" class="form-control form-control-lg shadow-sm mtc_trigger" data-mtcinput="#mauticform_input_registerorsignupform_email" placeholder="Your Email Address *">
                                                    <div class="email-error"></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group mb-3">
                                                            <input type="password" name="password" id="password" class="form-control form-control-lg shadow-sm no-space-validation" placeholder="Set Password *" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group mb-3">
                                                            <input type="password" name="confirm_password" id="confirm_password" class="form-control form-control-lg shadow-sm no-space-validation" placeholder="Confirm Password *" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <input type="submit" value="Register Now" class="btn btn-primary-ol btn-lg w-100 basicbtn send-otp-btn" onClick="sendOTP();">
                                                </div>
                                            </div>
                                            {{-- </form> --}}
                                        </div>
                                        <!-- END Register Form -->

                                        <!-- OTP Form  -->
                                        <div id="__otpFrm__" style="display:none;">
                                            {{-- <form action="#" method="post" class="line-form" id="_OTP_Form_"> --}}
                                            <div class="form-type-one" id="_OTP_Form_">
                                                <div class="mb-3">
                                                    <h5 class="color-primary font-700">OTP Verify</h5>
                                                </div>
                                                <div class="mb-4">
                                                    <p class="text-success"><i class="bi bi-patch-check-fill"></i> OTP is sent on your whatsapp number.</p>

                                                    <p class="text-error"></p>

                                                    <div class="d-flex justify-content-between">
                                                        <input class="session_name" type="text" value="<?php echo $_SESSION['session_number'] ?? ''; ?>" id="valedit" name="val" readonly>
                                                        {{-- <span onclick="editNumber()" style="cursor:pointer;"> --}}
                                                        {{-- <span> --}}
                                                        <span onclick="editNumber()" style="cursor:pointer;" class="btn btn-sm btn-outline-dark" title="Edit Number" data-bs-toggle="tooltip"><i class="bi bi-pencil"></i></span>
                                                        {{-- </span> --}}
                                                    </div>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <input type="text" name="otp" id="otp" inputmode="numeric" autocomplete="one-time-code" pattern="\d{6}" required="" class="form-control form-control-lg shadow-sm no-space-validation number-validation" placeholder="Enter OTP" maxlength="6">
                                                </div>
                                                <div class="">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <div class="d-flex align-items-center">
                                                                <input type="button" id="button_otpVer" class="btn btn-primary-ol px-4 basicbtn" value="Verify OTP" onClick="verifyOTP();">
                                                                <span  id="loading_icon" class="ms-2" style="display:none;">
                                                                    <i class="bi bi-arrow-repeat bi-spin" style="font-size:1.6rem;"></i>
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <div id="rebtn" class="text-end" style="padding-left:15px;">
                                                            <div>
                                                                <button type="button" id="ReSendOtpBtn" class="btn btn-sm btn-outline-dark px-3" style="display:none;" onClick="resendOTP();">
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
                                                    </div> 
                                                    {{-- <div>
                                                        <span class="otp-massage mt-3 small font-600 px-2 py-2 bg-light d-block" style="display:none;">OTP Sent</span>
                                                    </div> --}}
                                                </div>
                                            </div>
                                            {{-- </form> --}}
                                        </div>
                                        <!-- END OTP Form  -->
                                        
                                        <!-- Change Number Form  -->
                                        <div id="__chngPhFrm__" style="display:none;">
                                            {{-- <form action="#" method="post" class="line-form" id="_Change_Phone_Form_"> --}}
                                            <div class="form-type-one" id="_Change_Phone_Form_">
                                                <div class="mb-3">
                                                    <h5 class="color-primary font-700">Change Mobile Number</h5>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="mobile_resend">Mobile No.</label>
                                                    <input type="tel" name="mobile_resend" id="mobile_resend" required="" minlength="10" maxlength="10" class="form-control form-control-lg shadow-sm no-space-validation number-validation mtc_trigger" data-mtcinput="#mauticform_input_registerorsignupform_whatsapp_number" required="" maxlength="10" placeholder="Enter Mobile Number...">
                                                </div>

                                                <div class="">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <button type="button" id="changePhoneBtn" class="btn btn-primary-ol px-3" onclick="sendOTP();">
                                                            Change
                                                        </button>
                                                        <button type="button" class="btn btn-link-ol mt-sm-2" onclick="goBack()">
                                                            Go Back
                                                        </button>
                                                    </div> 
                                                </div>
                                            </div>
                                            {{-- </form> --}}
                                        </div>
                                        <!-- END Change Number Form  -->
                                    </div>
                                </form>

                                <div class="d-none" style="display: none;">
                                    <form autocomplete="false" role="form" method="post" action="https://mp.salesrobo.com/form/submit?formId=5" id="mauticform_registerorsignupform" data-mautic-form="registerorsignupform" enctype="multipart/form-data">
                                        <input name="mauticform[f_name]" id="mauticform_input_registerorsignupform_f_name"  value="" placeholder="enter your name" class="mauticform-input" type="text">
                                        <input name="mauticform[email]" id="mauticform_input_registerorsignupform_email"  value="" placeholder="enter your email id" class="mauticform-input" type="email">
                                        <input name="mauticform[whatsapp_number]" id="mauticform_input_registerorsignupform_whatsapp_number"  value="" placeholder="Enter your WhatsApp no." class="mauticform-input" type="tel">
                                        <input name="mauticform[formId]" type="hidden"  id="mauticform_registerorsignupform_id" value="5">
                                        <input name="mauticform[return]" type="hidden"  id="mauticform_registerorsignupform_return" value="">
                                        <input name="mauticform[formName]" type="hidden"  id="mauticform_registerorsignupform_name" value="registerorsignupform">
                                        <button name="mauticform[submit]" type="submit"  id="mauticform_input_registerorsignupform_submit" value="" class="mauticform-button btn btn-default">Submit</button>
                                    </form>
                                </div>

                            </div>
                                    
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    {{-- multiple logins modal --}}
    <div class="modal fade bg-white" id="multiple-login" tabindex="-1" aria-labelledby="multipleLoginLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content shadow border-white p-3">
            <div class="modal-body">
                <h6 class="text-center lh-base text-black multiple-login-text font-600">This MouthPublicity.io account is already logged in on another device. Click "Login Here" to use MouthPublicity.io on this device and you will be logged out of other devices.</h6>
            </div>
            <div class="modal-footer justify-content-center border-top-0">
                <a type="button" href="#" class="btn btn-primary-ol me-3 px-3" id="loginHere">Login Here</a>
                <a type="button" href="#"class="btn btn-outline-secondary ms-3 px-4" data-bs-dismiss="modal" id="logincancel">Cancel</a>
            </div>
          </div>
        </div>
    </div>
    {{-- multiple logins modal end --}}
</section>
@endsection

{{-- Push Scripts file to the JS --}}
@push('js')
<script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets/js/form.js') }}"></script>
<script src="{{ asset('assets/js/admin/register.js') }}"></script>
<script src="{{ asset('assets/js/input-validation.js') }}"></script>
<script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
@endpush

{{-- Push script to end of the body --}}
@push('end_body')
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
        // alert("ready");
        setTimeout('$("#error").hide()',3000);
        setTimeout('$("#success").hide()',3000);
        
        /* var tab = "{{ $tab }}";
        if(tab == 'register'){
            $('#signup_tab').click();
        } */

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

/* ************************ Rollback Login Disclamer Functionality Start ************************ */
    $("#_SignInForm_").on('submit', function(e) {
        
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var btnText = $('#loginFormBtn').val();

        $.ajax({
            type: 'POST',
            url: this.action,
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {

                $('#loginFormBtn').val("Please Wait....");
                $('#loginFormBtn').attr('disabled',true)

            },

            success: function(response) {
                
                $('#loginFormBtn').removeAttr('disabled');
                $('#loginFormBtn').val(btnText);
                    if(response.force_login_check){
                      
                        $("#force_login_check").val(1);
                   
                        $("#multiple-login").modal('show'); /* modal open */
                        
                    }else{
                        // alert("in else");
                        if(response.type == 'error'){
                            Sweet('error',response.message);

                        }else if(response.type == 'success'){
                            if(response.payment == 'pending'){
                                window.location.href = response.redirect;
                            }else{
                                if(response.link && response.link != ''){
                                    window.location.href = response.link;
                                }else{
                                    location.reload();
                                }
                                
                            }
                        }
                    }
            
            },
            // error: function(xhr, status, error) {
            //     Sweet('error',response.message);
            //     $('#loginFormBtn').html(btnText);
            //     $('#loginFormBtn').removeAttr('disabled');
            // }
        })
    });

    $(document).on('click', '#loginHere', function(){
       $("#_SignInForm_").submit();
    //    $("#force_login_check").val(1);
    });
    $(document).on('click', '#logincancel', function(){
       $("#force_login_check").val(0);
    });

</script>

{{-- login password hide and show --}}
<script>
    $(document).on('click', '.toggle-loginpassword', function() {

        $(this).toggleClass("bi bi-eye-slash-fill");

        var input = $("#loginPassword");
        if (input.attr('type') === "password") {
            input.attr('type', 'text');
        } 
        else {
            input.attr('type', 'password') ;
        }
    });
</script>
@include('auth.scripts.validation')
@include('auth.scripts.otp')
@endpush