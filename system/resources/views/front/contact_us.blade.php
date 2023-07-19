@extends('layouts.front')

@section('title', 'Contact Us - MouthPublicity.io')
@section('description', 'Support Center - MouthPublicity.io')
@section('keywords', 'MouthPublicity.io contact no, email')
{{-- @section('image', '') --}}

@section('end_head')
<style type="text/css">
    
    .oplk-contact-section {
        padding-bottom: 10px;
    }

    .oplk-contact-section .oplk-contact-icon {
        float: left;
        /* margin-bottom: 20px; */
        display: inline-block;
        font-size: 25px;
        color: #34b2a4;
        padding-right: 20px;
        position: initial;
        vertical-align: middle;
    }

    .oplk-contact-section .oplk-contact-info {
        padding-top: 10px;
        font-weight: 700;
    }
    
    .form-floating>label{
        top: 1px;
        left: 1px;
        width: calc(100% - 3px);
        border-radius: 4px;
        font-size: 13px;
        font-weight: 400;
        line-height: 1;
        background: #fff;
        padding: 20px 10px;
        height: auto;
        transition: all 200ms ease-in-out;
    }
    .form-floating>.form-control:focus~label,
    .form-floating>.form-control:not(:placeholder-shown)~label,
    .form-floating>.form-select~label{
        padding: 5px 10px;
        opacity: 1;
        transform: scale(1);
    }

    .form-control-lg{
        font-size: 1rem;
    }
    .has-error{
        color: red;
        font-size: 10px;
    }
</style>
@endsection
@section('content')

<section id="">
    {{-- <span class="splashes dots-top"></span> --}}
    <!-- <span class="splashes dots-color-bottom"></span> -->
    <div class="py-5 text-black">
        <div class="container">
            <div class="mb-5">
                <a href="{{ url('') }}"><img src="{{ asset('assets/front/images/logo-dark.svg') }}" class="main_logo" alt="MouthPublicity.io"></a>
            </div>

            <div class="row justify-content-between mb-5">

                <div class="col-lg-6 mb-lg-0 mb-5">
                    <div class="">
                        <h1 class="su_title font-600">Let's connect</h1>
                        <p>Let's grow your business together. Create a link and share it now. Have any issues creating your link with MouthPublicity.io, Feel free to reach us. Fill the form now, and the customer executive will soon get in touch with you. </p>
                    </div>
                    <div>
                        <div class="bg-light px-4 py-2 mb-4" style="border-radius: 10px;">
                            <div class="d-flex align-items-center">
                                <div class="pe-3">
                                    <i class="bi bi-envelope oplk-color-gradient font-xlarge"></i>
                                </div>
                                <div>
                                    <p class="mb-0 font-600"><a href="mailto:mouthpublicity.io" style="text-decoration: none;color:inherit;" class="font-large">care@mouthpublicity.io</a></p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-light px-4 py-2 mb-4" style="border-radius: 10px;">
                            <div class="d-flex align-items-center">
                                <div class="pe-3">
                                    <i class="bi bi-telephone oplk-color-gradient font-xlarge"></i>
                                </div>
                                <div>
                                    <p class="mb-0 font-600"><a href="tel:+917887882244" style="text-decoration: none;color:inherit;" class="font-large">+91 788 788 2244</a></p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-light px-4 py-2 mb-4" style="border-radius:10px;">
                            <div class="d-flex">
                                <div class="pe-3">
                                    <i class="bi bi-geo-alt oplk-color-gradient font-xlarge"></i>
                                </div>
                                <div>
                                    <p class="mb-1 font-600" >Address</p>
                                    <p class="mb-0 small text-capitalize"><b>Logic Innovates</b>, Premier Technology Building, 1st floor, B-Wing, IT Park, Gayatri Nagar, Nagpur, Maharashtra - 440022, India.</p>
                                </div>
                            </div>
                        </div>

                        <!--<div class="bg-light px-4 py-2 mb-4" style="border-radius:10px;">-->
                        <!--    <div class="d-flex">-->
                        <!--        <div class="pe-3">-->
                        <!--            <i class="bi bi-geo-alt oplk-color-gradient font-xlarge"></i>-->
                        <!--        </div>-->
                        <!--        <div class="w-100">-->
                        <!--            <div data-bs-toggle="collapse" data-bs-target="#regisAddress" aria-expanded="false" aria-controls="regisAddress" style="cursor:pointer;">-->
                        <!--                <p class="mb-1 font-600 w-100" >Registered Address <span class="float-end "><i class="bi bi-chevron-down"></i></span> </p>-->
                        <!--            </div>-->
                        <!--            <div class="collapse" id="regisAddress">-->
                        <!--                <p class="mb-0 small text-capitalize"><b>Logic Innovates</b>, kranti surya nagar, katol road, nagpur, maharashtra - 440013, india.</p>-->
                        <!--            </div>-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--</div>-->

                    </div>
                    
                </div>

                <div class="col-lg-5 mb-lg-0 mb-5 ">
                    <div class="oplk-contact-form oplk-background-color-gradient font-900 p-5 rounded-3" id="__contact_form_section__">
                        <h4>Write us message below</h4>
                        <form class="pt-3" id="contactForm" method="post" action="">
                           <div class="form-floating mb-3"> 
                              <input type="text" name="name" class="form-control form-control-lg char-validation" id="name" placeholder="John Deo" >
                              <label for="name">First & Last Name <span class="text-danger">*</span></label>
                              <span class="has-error name-has-error"></span>
                            </div>
                            <div class="form-floating mb-3">
                              <input type="tel" name="mobile" id="mobile" class="form-control form-control-lg no-space-validation number-validation" placeholder="Your Mobile Number (10 Digits)">
                              <label for="mobile">WhatsApp Number <span class="text-danger">*</span></label>
                              <span class="has-error mobile-has-error"></span>
                            </div>
                            <div class="form-floating mb-3">
                              <input type="email" name="email" id="email" class="form-control form-control-lg" placeholder="Your Email Address" >
                              <label for="email">Email address <span class="text-danger">*</span></label>
                              <span class="has-error email-has-error"></span>
                            </div>
                            <div class="form-floating mb-2">
                              <textarea name="message" id="message" class="form-control form-control-lg" rows="3" placeholder="Your Message..."  style="height: 100px"></textarea>
                              <label for="message">Message</label>
                            </div>
                            <small class="font-small text-muted">All (<span class="text-danger">*</span>) fields are required</small>
                            <div class="mt-3">
                                <button type="submit" id="contactBtn" class="btn btn-theme">Send Message</button>
                            </div>
                            <div class="success-message" style="display:none;">
                                <p class="success-message-text alert alert-success mt-2"></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <div class="row justify-content-between my-5">
                <div class="col-lg-6" >
                    <div>
                        <img src="{{ asset('assets/front/images/home/contact-us.svg') }}" alt="MouthPublicity.io Support">
                    </div>
                </div>
                <div class="col-lg-4 me-5 mt-5">
                    <div class="support">
                        <div class="mb-5">
                            <h4 class="fw-bolder">FACING DIFFICULTY WITH</h4>
                            <h1 class="oplk-text-gradient"><strong>MouthPublicity.io?</strong></h1>
                            <h4 class="fw-bolder text-end text-uppercase h6">We're here to support you '7 Days a Week'</h4>
                            <h2 class="oplk-bg-color-gradient p-1 text-white text-center text-uppercase h4">Mon-Sun <b>10:00</b>am to <b>7:00</b>pm</h2>
                            <h6 class="fw-bolder">Contact us now! @ <a href="tel:+917887882244" class="h3 text-decoration-none color-lht">+91 7887882244</a></h6>
                            
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection

@section('end_body')
    <script src="{{ asset('assets/js/form.js') }}"></script>
    <script src="{{ asset('assets/js/input-validation.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $('#contactForm').submit(function(e){
                e.preventDefault();

                var btn = $('#contactBtn');
                var name = $('#name').val();
                var email = $('#email').val();
                var mobile = $('#mobile').val();
                var message = $('#message').val();

                /*Name validation*/
                if(name == ''  || name == "null" || name.length < 2) {
                    $("#name").focus();
                    $('.name-has-error').text('Please enter valid name.');
                    return false;
                }

                if(!name.match(/^[a-zA-Z\s]+$/)){
                    $("#name").focus();
                    $('.name-has-error').text('Please enter valid name.');
                    return false;
                }

                $('.name-has-error').text('');

                 /*Mobile number validation*/
                if (isNaN(mobile) || mobile == 0 || mobile == -1 || mobile == -0) {
                    $("#mobile").focus();
                    $('.mobile-has-error').text('Please enter valid mobile number.');
                    return false;
                }

                if (mobile.length != 10) {
                    $("#mobile").focus();
                    $('.mobile-has-error').text('Please enter valid mobile number.');
                    return false;
                }
                $('.mobile-has-error').text('');

                /*Email Validation*/
                if(email == ''  || email == "null" || email.length < 2) {
                    $("#email").focus();
                    $('.email-has-error').text('Please enter valid email.');
                    return false;
                }

                var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if(!regex.test(email)) {
                    $("#email").focus();
                   $('.email-has-error').text('Please enter valid email.');
                    return false;
                }
                $('.email-has-error').text('');

                $.ajax({
                    url: '{{ route('postContact') }}',
                    type: "POST",
                    data: {
                        _token: CSRF_TOKEN,
                        name: name,
                        email: email,
                        mobile: mobile,
                        message: message
                    },
                    dataType: 'JSON',
                    beforeSend: function(){
                        btn.attr('disabled','')
                        btn.html('Please Wait....')
                    },
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) {
                        /*console.log(data);*/
                        if(data.status == true){
                            $('#name').val('');
                            $('#email').val('');
                            $('#mobile').val('');
                            $('#message').val('');
                            $('.success-message').show();
                            $('.success-message-text').html(data.message);
                            setTimeout(function() {
                                $(".success-message").fadeOut(700)
                            }, 15000);
                            setTimeout(function() {
                                $('.success-message-text').html('');
                            }, 16000);
                        }else{
                        }
                    },
                    complete: function(){
                        btn.removeAttr('disabled')
                        btn.html('Sent Message')
                   }
                });
            })
        });
    </script>
@endsection