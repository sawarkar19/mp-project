@extends('layouts.seo')
@section('title', 'Profile Setting')
@section('head') @include('layouts.partials.headersection',['title'=>'Profile Settings']) @endsection

@section('end_head')
<style>
    .input-group-addon {
        padding: .75rem;
        margin-bottom: 0;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.25;
        color: #495057;
        text-align: center;
        background-color: #e9ecef;
        border: 1px solid rgba(0,0,0,.15);
        border-radius: .25rem;
        border-top-left-radius:unset;
        border-bottom-left-radius:unset;
    }
   
    label span{
        color: red;
    }
    .missing-info{
        margin-bottom: 15px;
        font-style: italic;   
    }
    .capitalize input{
        text-transform: capitalize;
    }

    .success { color:green; }
    .error { color:green; }


    .important{
        position: relative;
        width: 100%;
        padding: 20px 15px 8px 15px;
        border: 1px solid var(--danger);
        border-radius: 4px;
        margin-bottom: 20px;
    }
    /* .important p:last-child{
        margin-bottom: 0px;
    } */
    .important::before{
        content: "Important";
        padding: 3px 10px;
        background-color: #ffffff;
        color: var(--danger);
        position:absolute;
        top:0;
        left: 15px;
        transform: translateY(-50%);
        font-size: 12px;
        font-weight: 500;
    }
    
</style>
@endsection

@section('content')


<section class="section">

    <div class="section-body">

        <div>
            @if($basic->business_name == '' || $basic->address_line_1 == '')
                <div class="alert alert-danger missing-info" role="alert">
                  Please enter necessary business details before creating offer.
                </div>
            @endif
        </div>
        


        <div class="row justify-content-center_">

            <div class="col-md-6">
                <!-- profile details -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-user mr-3"></i>
                        <h4>{{__('Profile Details')}}</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" class="ProfileForm basicSettingform" action="{{ route('seo.profileUpdate') }}">
                        @csrf
                            <div class="custom-form">
                                <div class="form-group">
                                    <label for="name" class="col-form-label">{{__('Name')}} <span>*</span></label>
                                    <input type="text" name="name" id="name" class="form-control" required placeholder="Enter User's  Name" value="{{ Auth::user()->name }}"> 
                                </div>
                                <div class="form-group">
                                    <label for="email" class="col-form-label">{{__('Email ID')}} <span>*</span></label>
                                    <input type="text" name="email" id="email" class="form-control" value="{{ Auth::user()->email }}" readonly> 
                                </div>

                                {{-- <div class="form-group">
                                    <label for="joined_date" class="col-form-label">{{__('Joined At')}} <span>*</span></label>
                                    <input type="text" name="text" id="joined_date" class="form-control" value="{{ \Carbon\Carbon::parse(Auth::user()->created_at)->format("j M, Y") }}" readonly> 
                                </div> --}}
                            
                                <div class="form-group mb-0">
                                    <button type="submit" class="btn btn-info px-4 basicbtn" name="Save">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- profile details End -->
            
            <div class="col-md-6">
                <!-- Mobile edit -->
                @if( Auth::user()->role_id != 1)
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-mobile-alt mr-3"></i>
                        <h4>{{ __('Registered (WhatsApp) Number') }}</h4>
                    </div>
                    <div class="card-body">
                    <form method="post" id="basicformMobile">
                        @csrf
                        <div class="custom-form">
                            <div class="form-group" id="enter_input">
                                <label for="name" id="mobile_label" class="col-form-label">{{ __('Number ') }} <small>(10 Digit)</small> <span>*</span></label>
                                <label for="name" id="resend_name"  style="display:none;" class="col-form-label">{{ __('Resend OTP Number') }} <span>*</span></label>
                                <input type="text" name="mobile" id="mobile" class="form-control" required placeholder="Enter WhatsApp Number" value="{{ Auth::user()->mobile }}">
                            </div>
                            <div class="form-group" id="verify_input" style="display:none;">
                                <label for="name" class="col-form-label">{{ __('Enter OTP Number') }} <span>*</span></label>
                                <input type="text" name="otp" id="otp" class="form-control" required placeholder="Enter OTP Number" value="">
                            </div>
                            <div class="form-group" id="OtpBtn">
                                <button type="button" class="btn btn-info basicbtn1" onClick="sendOTP();">{{ __('Send OTP') }}</button>
                            </div>
                            <div class="form-group" id="VrfBtn" style="display:none;">
                                <button type="button" class="btn btn-info basicbtn2" onClick="verifyOTP();">{{ __('Verify OTP') }}</button>
                                <button type="button" class="btn btn-info basicbtn2" onClick="resendOTP();">{{ __('Resend OTP') }}</button>
                            </div>
                            <div class="form-group"> <span class="success"></span>
                                <span class="error"></span>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
                @endif
                <!-- Mobile End -->
            </div>

            <div class="col-md-6">
                <!-- Password change -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-key mr-3"></i>
                        <h4>{{__('Change Password')}}</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" id="ChangePasswordForm" class="mb-0 basicSettingform" action="{{ route('seo.profileUpdate') }}">
                            {{-- @csrf --}}
                            <div class="custom-form">
                                {{-- <div class="form-group show_hide_password">
                                    <label for="oldpassword" class="col-form-label">{{ __('Old Password') }}</label>
                                    <div class="input-group mb-3">
                                        <input type="password" name="password_current" id="oldpassword" class="form-control" placeholder="Enter Old Password" required>
                                      <div class="input-group-append">
                                        <button class="btn btn-primary" type="button">Button</button>
                                      </div>
                                    </div>
                                  </div> --}}

                                <div class="form-group show_hide_password">
                                    <label for="oldpassword" class="col-form-label">{{ __('Old Password') }}</label>
                                    <div class="input-group" id="show_hide_old_password">
                                        <input type="password" name="password_current" id="oldpassword" class="form-control" placeholder="Enter Old Password" required>
                                        <div class="input-group-append">
                                            <a href="" class="btn btn-primary"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group show_hide_password">
                                    <label for="password" class="col-form-label">{{ __('New Password') }}</label>
                                    <div class="input-group" id="show_hide_new_password">
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Enter New Password" required>
                                        <div class="input-group-append">
                                            <a href="" class="btn btn-primary"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group show_hide_password">
                                    <label for="password_confirmation" class="col-form-label">{{ __('Confirm Password') }}</label>
                                    <div class="input-group" id="show_hide_con_password">
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm Your Password" required>
                                        <div class="input-group-append">
                                            <a href="" class="btn btn-primary"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div style="padding-bottom: 15px;font-size:10px">
                                    <span><b>Note: </b></span><span style="color: red">If you update your password, you will be logged out and redirected to Sign In page where you have to login with New Password.</span>
                                </div>
                                {{-- <input type="hidden" id="progress_percent" name="progress_percent" value="{{ //$progress }}" > --}}
                                <div class="form-group mb-0">
                                    <button type="submit" class="btn btn-info px-4 basicbtn" name="Change">{{ __('Change') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- password End -->
            </div>

        </div>
    </div>
</section>

@endsection

@push('js')
<script src="{{ asset('assets/js/form.js') }}"></script>
<script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/js/input-validation.js') }}"></script>

<script>
    $(document).ready(function() {
        
        $("#show_hide_old_password a").on('click', function(event) {
            event.preventDefault();
            if($('#show_hide_old_password input').attr("type") == "text"){
                $('#show_hide_old_password input').attr('type', 'password');
                $('#show_hide_old_password i').addClass( "fa-eye-slash" );
                $('#show_hide_old_password i').removeClass( "fa-eye" );
            }else if($('#show_hide_old_password input').attr("type") == "password"){
                $('#show_hide_old_password input').attr('type', 'text');
                $('#show_hide_old_password i').removeClass( "fa-eye-slash" );
                $('#show_hide_old_password i').addClass( "fa-eye" );
            }
        });

        $("#show_hide_new_password a").on('click', function(event) {
            event.preventDefault();
            if($('#show_hide_new_password input').attr("type") == "text"){
                $('#show_hide_new_password input').attr('type', 'password');
                $('#show_hide_new_password i').addClass( "fa-eye-slash" );
                $('#show_hide_new_password i').removeClass( "fa-eye" );
            }else if($('#show_hide_new_password input').attr("type") == "password"){
                $('#show_hide_new_password input').attr('type', 'text');
                $('#show_hide_new_password i').removeClass( "fa-eye-slash" );
                $('#show_hide_new_password i').addClass( "fa-eye" );
            }
        });

        $("#show_hide_con_password a").on('click', function(event) {
            event.preventDefault();
            if($('#show_hide_con_password input').attr("type") == "text"){
                $('#show_hide_con_password input').attr('type', 'password');
                $('#show_hide_con_password i').addClass( "fa-eye-slash" );
                $('#show_hide_con_password i').removeClass( "fa-eye" );
            }else if($('#show_hide_con_password input').attr("type") == "password"){
                $('#show_hide_con_password input').attr('type', 'text');
                $('#show_hide_con_password i').removeClass( "fa-eye-slash" );
                $('#show_hide_con_password i').addClass( "fa-eye" );
            }
        });
        
    });
</script>
<script>
    $(document).ready(function () {
        
    });
</script>
@endpush
@section('end_body')
    @include('seo.scripts.profile-setting')
@endsection