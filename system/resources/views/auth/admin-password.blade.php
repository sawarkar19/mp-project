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
            right: 10px;
            top: 10px;
            color: #FFF;
            cursor: pointer;
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

                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="text-white mb-4">
                            <h1 class="h2 su_title lh-1">
                                <span class="h4 d-block">Hello,</span> <span>{{ $user->name }}</span>
                            </h1>
                            <p>We recommend that you keep your password secure and not share it with anyone.</p>
                            <p>Your MouthPublicity.io Admin account has been created by MouthPublicity.io SuperAdmin, To login your MouthPublicity.io account please create your secure password for registered email id ({{ $user->email }})</p>
                        </div>

                        <div class="signinoutTab me-auto ms-0">
                            <p class="small text-white"><i>Create your new password here...</i></p>
                            <form action="{{ route('updateAdminPassword') }}" method="post" class="line-form login--form" id="generatePassswordForm">
                                @csrf
                                <div class="form-group">
                                    <span class="bi bi-eye-slash visidden"></span>
                                    <input type="password" name="password" id="password" class="form-control form-control-lg no-space-validation" placeholder="Password" required>
                                </div>
                                <div class="form-group">
                                    <span class="bi bi-eye-slash visidden"></span>
                                    <input type="password" name="confirmPassword" id="confirmPassword" class="form-control form-control-lg no-space-validation" placeholder="Confirm Password" required>
                                </div>
                                <div class="hidden-fields">
                                    <input type="hidden" name="user_token" value="{{ $token }}" />
                                </div>
                                <div>
                                    <button type="submit" class="login--form__button btn btn-theme btn-lg fw-normal text-capitalize" value="submit">Create Password</button>
                                </div>
                            </form>

                        </div>

                    </div>

                    <div class="col-md-6">
                        <div class="text-center">
                            <img src="{{ asset('assets/front/images/shield.png')}}" style="max-width:380px;width:100%;" class="mx-auto" alt="Protect">
                        </div>
                    </div>
                </div>
                
            </div>
        </div>

    </section>
    <script src="{{ asset('assets/front/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/input-validation.js') }}"></script>
    <script>

        

    $(document).ready( function() {

        $(document).delegate(".bi-eye-slash", "click", function(){
            $(this).removeClass("bi-eye-slash").addClass("bi-eye").nextAll("input[type='password']").attr("type", "text");
        });
        $(document).delegate(".bi-eye", "click", function(){
            $(this).removeClass("bi-eye").addClass("bi-eye-slash").nextAll("input[type='text']").attr("type", "password");
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
        // })
        // $('#generatePassswordForm').validate({
        //     rules: {
        //         password: {
        //             required: true,
        //             minlength: 8
        //         },
        //         confirmPassword: {
        //             required: true,
        //             equalTo: "#password"
        //         }
        //     },
        //     messages: {
        //         password: {
        //             required: 'Please enter Password.',
        //             minlength: 'Password must be at least 8 characters long.',
        //         },
        //         confirmPassword: {
        //             required: 'Please enter Confirm Password.',
        //             equalTo: 'Confirm Password do not match with Password.',
        //         }
        //     }
        // });
    });
    </script>

</body>
</html>