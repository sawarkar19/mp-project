<footer class="text-white">
    <div class="pt-5">
        <div class="container">

            <div class="text-center mb-5">
                {{-- Logo --}}
                <div>
                    <img src="{{asset('assets/website/images/logos/portrait-logo-light.svg')}}" style="width: 180px;" alt="MouthPublicity.io">
                </div>
                {{-- Social Medial Icons --}}
                <div class="social-media-icons text-white" style="font-size: 1.2rem;">
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

            <div class="row mb-5 justify-content-between">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-6">
                            <div class="ftr-column">
                                <div class="mb-3">
                                    <h6 class="text-uppercase font-800">Products</h6>
                                </div>
                                <div>
                                    <ul class="ftr-nav">
                                        <li class="ftr-item"><a class="ftr-link" href="{{route('channels', 'instant-challenge')}}">Instant Challenge</a></li>
                                        <li class="ftr-item"><a class="ftr-link" href="{{route('channels', 'share-challenge')}}">Share Challenge</a></li>
                                        <li class="ftr-item"><a class="ftr-link" href="{{route('channels', 'social-post')}}">Social Post</a></li>
                                        <li class="ftr-item"><a class="ftr-link" href="{{route('channels', 'personalised-message')}}">Personalised Messaging</a></li>
                                        <li class="ftr-item"><a class="ftr-link" href="{{route('channels', 'messaging-api')}}">Messaging API</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
    
                        <div class="col-6">
                            <div class="ftr-column">
                                <div class="mb-3">
                                    <h6 class="text-uppercase font-800">Company</h6>
                                </div>
                                <div>
                                    <ul class="ftr-nav">
                                        <li class="ftr-item"><a class="ftr-link" href="{{url('about-us')}}">About Us</a></li>
                                        <li class="ftr-item"><a class="ftr-link" href="{{url('pricing')}}">Pricing</a></li>
                                        <li class="ftr-item"><a class="ftr-link" href="{{url('blogs')}}">Blogs</a></li>
                                        <li class="ftr-item"><a class="ftr-link" href="{{url('articles')}}">Articles</a></li>
                                        <li class="ftr-item"><a class="ftr-link" href="{{ url('/how-it-works') }}">How it Works</a></li>
                                        <li class="ftr-item"><a class="ftr-link" href="{{url('faqs')}}">FAQs</a></li>
                                        <li class="ftr-item"><a class="ftr-link" href="{{url('contact-us')}}">Contact Us</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-6">
                            <div class="ftr-column">
                                <div class="mb-3">
                                    <h6 class="text-uppercase font-800">Customer</h6>
                                </div>
                                <div>
                                    <ul class="ftr-nav">
                                        <li class="ftr-item"><a class="ftr-link" href="{{url('documentation/business-settings')}}">Documentation</a></li>
                                        <li class="ftr-item"><a class="ftr-link" href="{{url('signin')}}">Login</a></li>
                                        <li class="ftr-item"><a class="ftr-link" href="{{url('signin?tab=register')}}">Register</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
    
                        <div class="col-6 mb-4">
                            <div class="ftr-column">
                                <div class="mb-3">
                                    <h6 class="text-uppercase font-800">Policy</h6>
                                </div>
                                <div>
                                    <ul class="ftr-nav">
                                        <li class="ftr-item"><a class="ftr-link" href="{{url('privacy-policy')}}">Privacy Policy</a></li>
                                        <li class="ftr-item"><a class="ftr-link" href="{{url('terms-and-conditions')}}">Terms & Conditions</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="">
                                <h5 class="font-700 mb-1">More Updates!</h5>
                                <p class="mb-1 small" style="color: rgba(255, 255, 255, 0.6)">Get latest updates directly on your WhatsApp & keep up with <span class="font-700">MouthPublicity.io.</span></p>
                                <div class="subscriber">
                                    <form action="{{route('subscribe_wa')}}" method="post" id="wa_subscribe_form">
                                        @csrf
                                        <div class="subscribe_form">
                                            <div class="subs_row">
                                                <input type="tel" name="input_data" pattern="[6789][0-9]{9}" class="subscribe_input mtc_trigger" data-mtcinput="#mauticform_input_mpwebsitefooterform_whatsapp_number" required placeholder="WhatsApp Number..." id="subscriber">
                                                <button type="submit" class="subs_btn" id="subscribeEmail">Send</button>
                                            </div>
                                        </div>
                                    </form>
                                    
                                    <div class="d-none" style="display: none;">
                                        <form autocomplete="false" role="form" method="post" action="https://mp.salesrobo.com/form/submit?formId=4" id="mauticform_mpwebsitefooterform" data-mautic-form="mpwebsitefooterform" enctype="multipart/form-data">
                                            <input name="mauticform[whatsapp_number]" type="tel" id="mauticform_input_mpwebsitefooterform_whatsapp_number" value="" class="mauticform-input" >
                                            <input name="mauticform[formId]" type="hidden" id="mauticform_mpwebsitefooterform_id" value="4">
                                            <input name="mauticform[return]" type="hidden" id="mauticform_mpwebsitefooterform_return" value="">
                                            <input name="mauticform[formName]" type="hidden" id="mauticform_mpwebsitefooterform_name" value="mpwebsitefooterform">
                                        </form>
                                    </div>

                                </div>
                                <div class="error-message-sec">
                                    <p class="text-message-success"></p>
                                    <p class="text-message-error"></p>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>

            </div>

            <div class="copyright border-top py-3">
                <div class="text-center">
                    <p class="mb-0">&copy; {{ date('Y') }} All rights reserved | Powered By <a href="https://logicinnovates.com" target="_blank" class="color-one font-600">Logic Innovates</a></p>
                </div>
            </div>

        </div>
    </div>
</footer>

@push('end_body')
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
            }
        });

        return true;
    }
    $(function(){
        $(".mtc_trigger").on("input change", function() {
           var in_value = $(this).val();
           var mtc_input = $(this).data('mtcinput');
           $(mtc_input).val(in_value);
        });
    });
</script>

@include('website.scripts.subscriber_js')
@endpush