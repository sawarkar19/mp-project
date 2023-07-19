<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Password</title>

    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="{{ asset('assets/front/vendor/bootstrap/css/bootstrap.min.css') }}" media="all">
    <!-- ICONS (Bootstrap) V1.5.0 -->
    <link rel="stylesheet" href="{{ asset('assets/front/vendor/bootstrap-icons/font/bootstrap-icons.css') }}" media="all">
    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="{{ asset('assets/front/css/style.css') }}" media="all">
    <link rel="stylesheet" href="{{ asset('assets/front/css/responsive.css') }}" media="all">
    <link rel="stylesheet" href="{{ asset('assets/front/css/customs.css') }}" media="all">
    <script src="{{ asset('assets/front/vendor/jQuery/jQuery.min.js') }}"></script>

    <style>
        .form-group{
            position: relative;
        }
        .visidden{
            position: absolute;
            right: 0px;
            top: 0px;
            color: #FFF;
            cursor: pointer;
            z-index: 3;
            text-align: center;
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
        }
        .error{
            color: red;
            font-size: 12px;
        }
    </style>

</head>
<body>
    <section id="signup">
        <span class="splashes dots-top"></span>

        <div class="py-5">
            <div class="container">
                <div class="mb-5">
                    <a href="{{ url('') }}">
                        <img src="{{ asset('assets/front/images/logo-light.svg') }}" class="main_logo" alt="MouthPublicity.io">
                    </a>
                </div>

                <div class="row align-items-center_ justify-content-between">
                    <div class="col-md-5">
                        <div class="text-white mb-4">

                            <div class="text-center text-md-start">
                                <img src="{{ asset('assets/front/images/shield.png')}}" style="max-width:280px;width:100%;" class="mx-auto_" alt="Protect">
                            </div>

                            <div class="bg-success d-flex py-2 alert">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <div><b>Payment Successful</b><br><small>We have successfully received your payment.</small></div>
                            </div>
                            @if($data)
                                <div class="table-responsive small">
                                    <table class="table table-sm table-borderless text-white rounded" style="background: rgba(255, 255, 255, 0.1)">
                                        <tr>
                                            <td class="ps-3">Payment Status</td>
                                            <td>:</td>
                                            <td class="pe-3">Success</td>
                                        </tr>
                                        <tr>
                                            <td class="ps-3">Amount</td>
                                            <td>:</td>
                                            <td class="pe-3">&#8377; {{ $data['amount'] }}</td>
                                        </tr>
                                        <tr>
                                            <td class="ps-3">Transaction ID</td>
                                            <td>:</td>
                                            <td class="pe-3">{{ $data['payment_id'] }}</td>
                                        </tr>
                                        {{-- <tr>
                                            <td class="ps-3">Transaction Time</td>
                                            <td>:</td>
                                            <td class="pe-3">{{ \Carbon\Carbon::parse($user->user_plan->created_at)->format('d-m-Y H:i') }}</td>
                                        </tr> --}}
                                    </table>
                                </div>
                            @endif                           
                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="text-white">
                            <h1 class="h4 su_title lh-1">
                                <span class="h5 d-block">Hello,</span> <span>{{ $user->name }}</span>
                            </h1>
                            <p>We found that you are registering for the first time to MouthPublicity.io, To login your MouthPublicity.io account please generate your secure password for registered email id ({{ $user->email }}).</p>

                            <div class="bg-danger d-flex py-2 alert mt-2" style="color: #fff">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <div><b>Please Note</b><br><small>Don't go back without generating password otherwise you will face problem while login to your account. For any query please contact our Support team.</small></div>
                            </div>

                            <div class="signinoutTab me-auto ms-0">
                                <div class="p-3 rounded" style="background: rgba(255, 255, 255, 0.1)">
                                    <p class="small text-white"><i>Create your new password here...</i></p>
                                    <form action="{{ route('updateUserPassword') }}" method="post" class="line-form login--form" id="generatePassswordForm">
                                        @csrf
                                        <div class="form-group">
                                            <span class="bi bi-eye visidden"></span>
                                            <input type="password" name="password" id="password" class="form-control form-control-lg no-space-validation" placeholder="Password" required>
                                        </div>
                                        <div class="form-group">
                                            <span class="bi bi-eye visidden"></span>
                                            <input type="password" name="confirmPassword" id="confirmPassword" class="form-control form-control-lg no-space-validation" placeholder="Confirm Password" required>
                                        </div>
                                        <div class="hidden-fields">
                                            <input type="hidden" name="user_token" value="{{ $user->pass_token }}" />
                                        </div>
                                        <div>
                                            <button type="submit" class="login--form__button btn btn-theme  fw-normal text-capitalize" value="submit">Create Password</button>
                                        </div>
                                    </form>
                                </div>
                            </div>


                        </div>
                        
                    </div>
                </div>
                
            </div>
        </div>

    </section>

    <script type="text/javascript">
        /** This section is only needed once per page if manually copying **/
        if (typeof MauticSDKLoaded == 'undefined') {
            var MauticSDKLoaded = true;
            var head            = document.getElementsByTagName('head')[0];
            var script          = document.createElement('script');
            script.type         = 'text/javascript';
            script.src          = 'https://mp.salesrobo.com/media/js/mautic-form.js?vdaf5f073';
            script.onload       = function() {
                MauticSDK.onLoad();
            };
            head.appendChild(script);
            var MauticDomain = 'https://mp.salesrobo.com';
            var MauticLang   = {
                'submittingMessage': "Please wait..."
            }
        }else if (typeof MauticSDK != 'undefined') {
            MauticSDK.onLoad();
        }
    </script>
    
    <div class="d-none" style="display: none;">
        <form autocomplete="false" role="form" method="post" action="https://mp.salesrobo.com/form/submit?formId=8" id="mauticform_checkoutform" data-mautic-form="checkoutform" enctype="multipart/form-data">
            <input name="mauticform[email]" value="{{$user->email}}" id="mauticform_input_checkoutform_email" value="" placeholder="enter your email id" class="mauticform-input" type="email">
            <input name="mauticform[whatsapp_number]" value="{{$user->mobile}}" id="mauticform_input_checkoutform_whatsapp_number" value="" placeholder="enter your whatsapp number" class="mauticform-input" type="tel">
            <textarea name="mauticform[address]" id="mauticform_input_checkoutform_address" class="mauticform-textarea">{{$user->bussiness_detail->address_line_1 }}</textarea>
            <input name="mauticform[state]" value="{{$user->bussiness_detail->state}}" id="mauticform_input_checkoutform_state" value="" class="mauticform-input" type="text">
            <input name="mauticform[city]" value="{{$user->bussiness_detail->city}}" id="mauticform_input_checkoutform_city" value="" class="mauticform-input" type="text">
            <input name="mauticform[pincode]" value="{{$user->bussiness_detail->pincode}}" id="mauticform_input_checkoutform_pincode" value="" placeholder="Enter Pincode in digits" class="mauticform-input" type="number">
            <input name="mauticform[gst_number]" value="" id="mauticform_input_checkoutform_gst_number" value="" placeholder="enter your business GST number" class="mauticform-input" type="number">
            <input name="mauticform[business_name]" value="{{$user->bussiness_detail->business_name}}" id="mauticform_input_checkoutform_business_name" value="" class="mauticform-input" type="text">
            <input name="mauticform[expired_subscription]" value="no" id="mauticform_input_checkoutform_expired_subscription" value="" placeholder="yes or no" class="mauticform-input" type="text">
            <input name="mauticform[paid_subscription]" value="yes" id="mauticform_input_checkoutform_paid_subscription" value="" placeholder="Yes or No" class="mauticform-input" type="text">
            <button name="mauticform[submit]" type="submit" id="mauticform_input_checkoutform_submit" value="" class="mauticform-button btn btn-default">Submit</button>
            <input name="mauticform[formId]" type="hidden" id="mauticform_checkoutform_id" value="8">
            <input name="mauticform[return]" type="hidden" id="mauticform_checkoutform_return" value="">
            <input name="mauticform[formName]" type="hidden" id="mauticform_checkoutform_name" value="checkoutform">
        </form>
    </div>

    <script src="{{ asset('assets/front/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/input-validation.js') }}"></script>
    
    <script>
        function submit_bobo_form(mtc_form) {
        
            let mtc_method = mtc_form.attr("method");
            let mtc_action = mtc_form.attr("action");
            let mtc_formdata = mtc_form.serialize();

            $.ajax({
                url: mtc_action,
                type: mtc_method,
                data: mtc_formdata,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
                success:function(){
                    localStorage.setItem("_mtc_checkout_received_", true);
                }
            });

            return true;
        }
        $(function() {
            var status_store = localStorage.getItem("_mtc_checkout_received_");
            if (!status_store) {
                var mtc_form = $("form#mauticform_checkoutform")
                submit_bobo_form(mtc_form);
                console.log('Code run...');
            }
        });
    </script>
    
    <script>
    $(document).ready( function() {

        $(document).delegate(".bi-eye", "click", function(){
            $(this).removeClass("bi-eye").addClass("bi-eye-slash").nextAll("input[type='password']").attr("type", "text");
        });
        $(document).delegate(".bi-eye-slash", "click", function(){
            $(this).removeClass("bi-eye-slash").addClass("bi-eye").nextAll("input[type='text']").attr("type", "password");
        });

        // $(document).on('click', '.login--form__button', function () {
            $('#generatePassswordForm').validate({
                rules: {
                    password: {
                        required: true,
                        minlength: 8
                    },
                    confirmPassword: {
                        required: true,
                        equalTo: "#password"
                    }
                },
                messages: {
                    password: {
                        required: 'Please enter Password.',
                        minlength: 'Password must be at least 8 characters long.',
                    },
                    confirmPassword: {
                        required: 'Please enter Confirm Password.',
                        equalTo: 'Confirm Password do not match with Password.',
                    }
                }
            });
        // });
    });
    </script>

</body>
</html>