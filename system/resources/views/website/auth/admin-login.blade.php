<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Login | MouthPublicity.io </title>
    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Salesrobo -->
    {{-- <script>
        (function(w,d,t,u,n,a,m){w['MauticTrackingObject']=n;
            w[n]=w[n]||function(){(w[n].q=w[n].q||[]).push(arguments)},a=d.createElement(t),
            m=d.getElementsByTagName(t)[0];a.async=1;a.src=u;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://oc.salesrobo.com/mtc.js','mt');

        mt('send', 'pageview');
    </script> --}}

    <script>
        (function(w,d,t,u,n,a,m){w['MauticTrackingObject']=n;
            w[n]=w[n]||function(){(w[n].q=w[n].q||[]).push(arguments)},a=d.createElement(t),
            m=d.getElementsByTagName(t)[0];a.async=1;a.src=u;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://mp.salesrobo.com/mtc.js','mt');
    
        mt('send', 'pageview');
    </script>

    <!-- Bootstrap 5.2.0 -->
    <link rel="stylesheet" href="{{ asset('assets/website/vendor/bootstrap/css/bootstrap.min.css') }}" media="all">

    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="{{ asset('assets/website/css/style.css') }}" media="all">
    <link rel="stylesheet" href="{{ asset('assets/website/css/responsive.css') }}" media="all">
    <link rel="stylesheet" href="{{ asset('assets/website/css/customs.css') }}" media="all">
</head>
<body class="">
    <div class="bg-light w-100 py-3 d-flex flex-column justify-content-center align-items-center" style="min-height:100vh;">
        <div class="" style="max-width:100%;width:350px;">
            <div class="text-center mb-3">
                <img src="{{asset('assets/website/images/logos/portrait-logo-dark.svg')}}" alt="MouthPublicity.io" style="width: 125px;max-width:100%;">
                {{-- <h5 class="font-600 color-primary">Admin Authentication</h5> --}}
            </div>
            <div class="card border-0 shadow">
                <div class="card-body pt-4">
                    <div class="signForm" id="__login_form__">
                        <form action="{{ route('postLogin') }}" method="post" class="form-type-one loginform" id="_SignInForm_">
                            @csrf

                            <div class="mb-3">
                                <h5 class="color-primary font-700">Login</h5>
                            </div>
                            <div class="form-group mb-3">
                                <!-- <label for="">ID/Mobile Number</label> -->
                                <input type="text" name="username" minlength="10" maxlength="70" id="loginEmail" class="form-control shadow-sm three-space-validation @error('username') is-invalid @enderror form-control-lg" required autocomplete="username" autofocus placeholder="Email ID/WhatsApp Number" value="{{ old('username') }}">
                                @error('username')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <!-- <label for="">Password</label> -->
                                <input type="password" name="password" value="" id="loginPassword" class="form-control shadow-sm form-control-lg @error('password') is-invalid @enderror" required placeholder="Password" autocomplete="current-password">
                            </div>
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
                        </form>
                    </div>
    
    
                    {{-- Forgot Password form  --}}
                    <div id="__ol_forgot_form__" class="" style="display: none">
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
            </div>

        </div>

    </div>

    <script src="{{ asset('assets/website/vendor/jQuery/jQuery.min.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/website/vendor/bootstrap/js/bootstrap.min.js') }}"></script>

    <script type="text/javascript">

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
    
        function loginForgot(){
            $('#__ol_forgot_form__').show();
            $('#__login_form__').hide();
        }
    </script>
</body>
</html>