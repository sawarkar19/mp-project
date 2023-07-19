@extends('layouts.website')

@section('title', 'Contact Us Now & Use MouthPublicity.io for Mouth Publicity Management!')
@section('description', 'We\'re available to assist you if you have any questions regarding our platform or comments about a feature (or anything in between). Our sales and support teams are just a message away.')
{{-- @section('keywords', 'why MouthPublicity.io, what is MouthPublicity.io, mission of MouthPublicity.io, about us MouthPublicity.io') --}}
{{-- @section('image', '') --}}

@section('end_head')
<style>
.has-error{
    color: var(--bs-danger);
    font-size: .75rem;
    font-weight: 600;
}
</style>
@endsection

@section('content')
{{-- contact us section --}}
<section id="contact_us">

    <div class="pb-5 text-dark">
        <div class="container">
            {{-- Breadcrumb Section --}}
            @php
                $bcrm = array(
                    array('name' => 'Contact Us', 'link' => false),
                );
            @endphp
            @include('website.components.breadcrumb', $bcrm)
        </div>
        <div class="container">
            <div class="row justify-content-between align-items-center mb-5">

                <div class="col-lg-6 mb-lg-0 mb-5">
                    <div class="mb-4">
                        <h1 class="su_title font-800 color-gradient">Let's connect</h1>
                        <p>Let's grow your business together. Create a link and share it now. Have any issues creating your link with MouthPublicity.io, Feel free to reach us. Fill the form now, and the customer executive will soon get in touch with you. </p>
                    </div>
                    <div>
                        <div class="bg-light px-4 py-3 mb-4 rounded">
                            <div class="d-flex align-items-center">
                                <div class="pe-3">
                                    <i class="bi bi-envelope color-gradient font-xlarge"></i>
                                </div>
                                <div>
                                    <p class="mb-0 font-600"><a href="mailto:care@mouthpublicity.io" style="text-decoration: none;color:inherit;" class="font-large">care@mouthpublicity.io</a></p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-light px-4 py-3 mb-4 rounded">
                            <div class="d-flex align-items-center">
                                <div class="pe-3">
                                    <i class="bi bi-telephone color-gradient font-xlarge"></i>
                                </div>
                                <div>
                                    <p class="mb-0 font-600"><a href="tel:+917887882244" style="text-decoration: none;color:inherit;" class="font-family-text">+91 788 788 2244</a></p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-light px-4 py-3 mb-4 rounded">
                            <div class="d-flex">
                                <div class="pe-3">
                                    <i class="bi bi-geo-alt color-gradient font-xlarge"></i>
                                </div>
                                <div>
                                    <p class="mb-1 font-600" >Corporate Address</p>
                                    <p class="mb-0 small text-capitalize"><b>Logic Innovates</b>, Premier Technology Building, 1st floor, B-Wing, IT Park, Gayatri Nagar, Nagpur, Maharashtra - 440022, India.</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-light px-4 py-3 mb-4 rounded">
                            <div class="d-flex">
                                <div class="pe-3">
                                    <i class="bi bi-geo-alt color-gradient font-xlarge"></i>
                                </div>
                                <div>
                                    <p class="mb-1 font-600" >Registered Address</p>
                                    <p class="mb-0 small text-capitalize"><b>Logic Innovates</b>, kranti surya nagar, katol road, nagpur, maharashtra - 440013, India</p>
                                </div>
                            </div>
                        </div>

                    </div>
                    
                </div>

                <div class="col-lg-5 mb-lg-0 mb-5 ">
                    <div class="oplk-contact-form bg-color-gradient-light p-sm-5 p-3 rounded-3" id="__contact_form_section__">
                        <h2 class="font-600 h5">Write us message below:</h2>
                        <form class="pt-3 form-type-one" id="contactForm" method="post" action="">
                           <div class="form-group mb-3"> 
                               {{-- <label class="font-600 font-small" for="name">Full Name <span class="text-danger">*</span></label> --}}
                               <input type="text" name="name" class="form-control mtc_trigger char-validation" data-mtcinput="#mauticform_input_contactform_f_name" id="name" placeholder="Enter full name *" title="Full Name *">
                               <span class="has-error name-has-error"></span>
                            </div>
                            <div class="form-group mb-3">
                                {{-- <label class="font-600 font-small" for="mobile">WhatsApp Number <span class="text-danger">*</span></label> --}}
                                <input type="tel" name="mobile" id="mobile" class="form-control mtc_trigger no-space-validation number-validation" data-mtcinput="#mauticform_input_contactform_contact_no" placeholder="Enter Mobile Number * (10 Digits)" title="10 Digit Mobile Number">
                                <span class="has-error mobile-has-error"></span>
                            </div>
                            <div class="form-group mb-3">
                                {{-- <label class="font-600 font-small" for="email">Email address <span class="text-danger">*</span></label> --}}
                                <input type="email" name="email" id="email" class="form-control mtc_trigger" data-mtcinput="#mauticform_input_contactform_email" placeholder="Enter Email Address *" title="Email Address">
                                <span class="has-error email-has-error"></span>
                            </div>
                            <div class="form-group mb-3">
                                {{-- <label class="font-600 font-small" for="message">Message</label> --}}
                                <textarea name="message" id="message" class="form-control mtc_trigger" data-mtcinput="#mauticform_input_contactform_f_message" rows="3" placeholder="Your Message..." title="Message"  style="height: 100px"></textarea>
                            </div>
                            <small class="font-small fst-italic">All (<span class="text-danger">*</span>) fields are required</small>
                            <div class="mt-3">
                                <button type="submit" id="contactBtn" class="btn btn-primary-ol px-4">Send Message</button>
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
                            <h4 class="font-700">FACING DIFFICULTY WITH</h4>
                            <h5 class="color-gradient h1 font-900">MouthPublicity.io.?</h5>
                            <h4 class="font-700 text-end text-uppercase h6">We're here to support you '7 Days a Week'</h4>
                            <h5 class="bg-color-gradient rounded-1 px-1 py-2 text-white text-center text-uppercase h4">Mon-Sun <b>10:00</b>am to <b>7:00</b>pm</h5>
                            <h6 class="fw-bolder">Contact us now! @ <a href="tel:+917887882244" class="h3 text-decoration-none color-lht">+91 7887882244</a></h6>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<div class="d-none" style="display: none;">
    <form autocomplete="false" role="form" method="post" action="https://mp.salesrobo.com/form/submit?formId=3" id="mauticform_contactform" data-mautic-form="contactform" enctype="multipart/form-data">
        <input type="text" name="mauticform[f_name]" id="mauticform_input_contactform_f_name" value="" placeholder="enter your name" class="mauticform-input">
        <input type="tel" name="mauticform[contact_no]" id="mauticform_input_contactform_contact_no" value="" placeholder="enter your mobile number" class="mauticform-input">
        <input type="email" name="mauticform[email]" id="mauticform_input_contactform_email" value="" placeholder="Enter your email id" class="mauticform-input">
        <textarea name="mauticform[f_message]" id="mauticform_input_contactform_f_message" class="mauticform-textarea"></textarea>
        <input type="hidden" name="mauticform[formId]" id="mauticform_contactform_id" value="3">
        <input type="hidden" name="mauticform[return]" id="mauticform_contactform_return" value="">
        <input type="hidden" name="mauticform[formName]" id="mauticform_contactform_name" value="contactform">
        <button type="submit" name="mauticform[submit]" id="mauticform_input_contactform_submit" value="" class="mauticform-button btn btn-default">Submit</button>
    </form>
</div>
@endsection

@push('end_body')
<script type="text/javascript">
    $(document).ready(function(){
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $('#contactForm').on('submit', function(e){
            e.preventDefault();
            var btn = $('#contactBtn');
            var name = $('#name').val();
            var email = $('#email').val();
            var mobile = $('#mobile').val();
            var message = $('#message').val();

            var form_send = true;
            /*Name validation*/
            if(name == ''  || name.length < 3) {
                $("#name").focus();
                $('.name-has-error').text('Please enter a valid name.');
                form_send = false;
            }else{
                $('.name-has-error').text('');
            }

            /*Mobile number validation*/
            if (isNaN(mobile) || mobile == 0 || mobile == -1 || mobile.length != 10) {
                $("#mobile").focus();
                $('.mobile-has-error').text('Please enter a valid mobile number.');
                form_send = false;
            }else{
                $('.mobile-has-error').text('');
            }

            /*Email Validation*/
            var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if(email == ''  || email == "null" || email.length < 2 || !regex.test(email)) {
                $("#email").focus();
                $('.email-has-error').text('Please enter a valid email address.');
                form_send = false;
            }else{
                $('.email-has-error').text('');
            }

            if (form_send) {

                btn.prop('disabled', true);
                btn.html('Please Wait....');

                // SalesRobo Submit
                var mtc_form = $("form#mauticform_contactform");
                var bobo = submit_bobo_form(mtc_form);

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
                    dataType: 'json',
                    beforeSend: function(){
                        btn.prop('disabled', true);
                        btn.html('Please Wait....');
                    },
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) {
                        /*console.log(data);*/
                        if(data.status == true){
                            $('#name').val('');
                            $('#email').val('');
                            $('#mobile').val('');
                            $('#message').val('');

                            window.location.href = '{{ url('/contact-us/thankyou') }}'

                            // $('.success-message').show();
                            // $('.success-message-text').html(data.message);
                            // setTimeout(function() {
                            //     $(".success-message").fadeOut(700)
                            // }, 15000);
                            // setTimeout(function() {
                            //     $('.success-message-text').html('');
                            // }, 16000);
                        }else{
                        }
                    },
                    complete: function(){
                        btn.removeAttr('disabled')
                        btn.html('Sent Message')
                    }
                });
            }

        })
    });
</script>
@endpush