<footer>
    <div class="w-100 bg-white">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-6 col-lg-7 order-md-2 bg-light">
                    <div class="footer-light bg-light px-md-5 py-5">
                        <div class="mb-4">
                            <p>Are you facing difficulties in acquiring customers? Use MouthPublicity.io to grab more customers!</p>
                            <p>MouthPublicity.io is the best platform to grow your business. MouthPublicity.io enables you to generate offers to attract your customers. Increase the customer engagement and visitors of your website by using MouthPublicity.io.</p>
                        </div>
                        <div class="mb-4">
                            <h4 class="font-h1 ">More Updates!</h4>
                            <p>Join our mailing list and keep up with <span class="brandname">MouthPublicity.io</span></p>
                            <div class="subscriber">
                              {{-- <form action="#" method="post"> --}}
                              <div class="subscribe_form">
                                  <div class="subs_row">
                                      <input type="email" class="subscribe_input" required placeholder="Your Email ID" id="subscriber" name="subscriber">
                                      <button type="button" class="subs_btn" id="subscribeEmail">Send</button>
                                  </div>
                              </div>
                              {{-- </form> --}}
                            </div>
                            <div class="error-message-sec">
                                <p class="text-message-success"></p>
                                <p class="text-message-error"></p>
                            </div>
                        </div>
                        <div class="footer-links">
                            <a href="{{url('terms-and-conditions')}}" class="f_link">Terms & Conditions</a>
                            <a href="{{url('privacy-policy')}}" class="f_link">Privacy Policy</a>
                            <a href="{{url('faqs')}}" class="f_link">FAQs</a>
                            <a href="{{url('contact-us')}}" class="f_link">Contact Us</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-5 oreder-md-1 px-0">
                    <div class="footer-dark px-md-5 py-md-5 p-3">

                        <div class="ft_logo">
                            <a href="{{ url('') }}"><img src="{{ asset('assets/front/images/logo-plain-light.svg') }}" class="fl-rotate" alt="MouthPublicity.io"></a>
                        </div>

                        <div class="d-flex flex-column justify-content-end text-center position-relative">
                
                            <div class="ivr-number mb-0">
                                <h4 class="h5 font-400 text-white"><a href="tel:+917887882244" style="color:inherit;text-decoration:none;"><i class="bi bi-telephone-fill oplk-color-gradient small"></i> +91 788 788 2244</a> </h4>
                            </div>

                            <div class="social_media_icons my-2">
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
                            </ul>
                        </div>

                            <div class="copyright">
                                <p>&copy; {{ date('Y') }} All rights reserved | Powered By 
                                    {{-- <a href="https://logicinnovates.com/" target="_blank" class="brandname"> --}}
                                    <span class="color-drk">Logic Innovates</span>
                                    {{-- </a> --}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</footer>


{{-- E-Book Modale --}}
<div class="modal ol-modal popin" id="EBookModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <span class="splashes pop_up_dots_up_ebook"></span>
            <span class="splashes pop_up_dots_bottom_ebook"></span>
            <div class="modal-header p-0">
                <div class="part_right_close_button me-3">
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
            </div>
            <div class="modal-body pb-5">
                <div class="container-fluid_">
                    <div class="px-md-5">
                        <div class="row">
                            <div class="col-lg-6 pe-4">
                                <div class="title_part_left">
                                    <h2 class="font-600 font-h2 fst-italic">Hurry up..!</h2>
                                    <h3 class="text-uppercase font-600 color-text-gradient-lighter h2" style="line-height: 1.1;">Your book is on the way</h3>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <p style="line-height: 1.3;">Sign up now and check The Mouth Publicity book, plus get the offers and updates from <span class="color-text-gradient-lighter font-900">MouthPublicity.io</span> </p>
                            </div>
                        </div>
                    
                        <div class="row align-items-center" style="position: relative;">
                            <div class="col-lg-6">
                                <div class="body_part_image">
                                    <img src="{{ asset('assets/front/images/e-book/blog-ebook.png') }}" class="w-100" alt="book image">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                {{-- <h5></h5> --}}
                                <p>The E-Book will be directly sent to your email ID.</p>
                                <form accept="#" method="post" id="getEBookForm">
                                    <div class="form-group">
                                        <input name="name" type="text" class="form-control ol-input" id="book_name" placeholder="Enter Your Name *" required />
                                    </div>
                                    <div class="form-group">
                                        <input name="number" type="tel" class="form-control ol-input" id="book_number" placeholder="WhatsApp No. *" required />
                                    </div>
                                    <div class="form-group">
                                        <input name="email" type="email" class="form-control ol-input" id="book_email" placeholder="Enter your E-mail ID *" required />
                                    </div>
                                    <div class="error_mag"></div>
                                    <div class="">
                                        <button class="btn btn-theme btn-lg font-500 w-100" type="submit">Get Book</button>
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
@include('front.subscriber_js')