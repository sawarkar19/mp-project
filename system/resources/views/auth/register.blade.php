@extends('layouts.auth')
@section('title', 'Registration')
@section('end_head')
    <link rel="stylesheet" href="{{ asset('assets/auth/css/register.css') }}">
    <style>
        .mobile-error,
        .email-error{
            color: #ff0000;
            font-size: 15px;
            text-align: center;
        }
    </style>
@endsection
@section('content')

    <div class="card-header"><h4 class="center" id="Title">{{ __('Register') }}</h4></div>
    <div class="card-body">
        <div class="success"></div>
        <div class="error"></div>
        {{-- <?php session_start(); ?> --}}
        <form class="basicform" id="basicform" method="post" action="{{ route('register') }}">
            @csrf
            <div class="card-body">
                <div id="front_page">
                    <div class="row">
                        <div class="form-group col-12">
                            <label for="frist_name">{{ __('Name') }} <span class="star">*</span>
                            </label>
                            <input id="first_name" type="text" class="form-control three-space-validation" value="" name="name" required>
                        </div>
                        <div class="form-group col-12">
                            <label for="mobile">{{ __('Mobile No.') }} <span class="star">*</span>
                            </label>
                            <input id="mobile" type="tel" class="form-control no-space-validation number-validation" value="" name="mobile" maxlength="10" required>
                            <div class="mobile-error"></div>
                        </div>
                        <div class="form-group col-12">
                            <label for="email">{{ __('Email') }} <span class="star">*</span>
                            </label>
                            <input id="email" type="email" class="form-control" value="" name="email" minlength="10" required>
                            <div class="email-error"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12">
                            <label for="password">{{ __('Password') }} <span class="star">*</span>
                            </label>
                            <input id="password" type="password" class="form-control no-space-validation" value="" name="password" required>
                        </div>
                        <div class="form-group col-12">
                            <label for="confirm_password">{{ __('Confirm Password') }} <span class="star">*</span>
                            </label>
                            <input id="confirm_password" type="password" class="form-control no-space-validation" value="" name="confirm_password" required>
                        </div>
                    </div>
                </div>
                <div id="second_page" style="display:none;">
                    <div class="row">
                        <div class="form-group col-12">
                            <div id="valsession" class="session_name">
                                <input class="session_name" type="text" value="<?php echo $_SESSION['session_number'] ?? ''; ?>" id="valedit" name="val"><span onclick="editNumber()" style="cursor:pointer;"><img src="{{ asset('assets/img/pencil.png') }}" class="pencil-img"></span>
                            </div>
                        </div>
                        <div class="form-group col-12" id="editmobnumber" style="display:none;">
                            <label for="mobile_resend" style="display:block">{{ __('Mobile No.') }} <span class="star">*</span><span id="goBack" style="float:right" onclick="goBack()">go back</span>
                            </label>
                            <input type="hidden" placeholder="Mobile No." value="" name="mobile_resend" id="mobile_resend" class="form-control no-space-validation number-validation" required style="display:none;" maxlength="10">
                        </div>
                        <div class="form-group col-12" id="otpColDiv">
                            <label for="last_name">{{ __('Enter OTP') }}</label>
                            <input id="otp" type="tel" class="form-control no-space-validation number-validation" name="otp" placeholder="Enter OTP" maxlength="6">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {{-- <button type="submit" id="payment" class="btn btn-primary btn-lg btn-block basicbtn" style="display:none;">{{ __(' Register and Payment') }}</button> --}}
                    <input type="button" id="button_otp" class="btn btn-primary btn-lg btn-block basicbtn" value="Send OTP" onClick="sendOTP();">
                    <input type="button" id="button_otpVer" class="btn btn-primary btn-lg btn-block basicbtn" value="Verify OTP" onClick="verifyOTP();" style="display:none;">
                </div>
        </form>
        <div class="simple-footer">
            {{ __('Copyright') }} &copy; {{ env('APP_NAME') }} {{ date('Y') }}
        </div>
    </div>
@endsection
@section('end_body')
    <script src="{{ asset('assets/js/admin/register.js') }}"></script>
    <script src="{{ asset('assets/js/input-validation.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            setTimeout('$("#error").hide()',3000);
            setTimeout('$("#success").hide()',3000);
        });

        function editNumber(){
            $('#mobile_resend').attr("type", 'tel');
            $('#button_otp').attr("value", 'Resend OTP');
            $("#mobile_resend").show(); 
            $("#editmobnumber").show(); 
            $("#button_otp").show();    
            $("#button_otpVer").hide(); 
            $("#valsession").hide();    
            $(".success").hide();
            $(".error").hide();
            $("#otp").val('');
            $("#mobile_resend").val('');
            $('#otpColDiv').hide();
        }

        function goBack(){
            $('#mobile_resend').attr("type", 'hidden');
            // $('#button_otp').attr("value", 'Resend OTP');
            $('#button_otp').hide();
            $("#mobile_resend").hide(); 
            $("#editmobnumber").hide(); 
            $("#button_otp").hide();    
            $("#button_otpVer").show(); 
            $("#valsession").show();    
            $(".success").show();
            $(".error").show();
            $("#otp").val('');
            $("#mobile_resend").val(<?php echo $_SESSION['session_number'] ?? ''; ?>);
            $('#otpColDiv').show();
        }
    </script>
    @include('auth.scripts.validation')
    @include('auth.scripts.otp')

@endsection