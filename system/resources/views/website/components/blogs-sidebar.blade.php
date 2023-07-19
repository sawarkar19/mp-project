<aside class="sticky-top sb-top-position" style="display:none">

    {{-- E-Book  --}}
    <div class="b-sidebar px-xl-5 px-lg-3 mt-4 mt-lg-0">
        {{-- <h4 class="font-600 fst-italic">Limited Edition</h4> --}}
        <h2 class="text-uppercase font-900 color-gradient h3" style="line-height: 1.1;">Best mouth publicity practices for your business growth</h2>
        <p class="font-600 my-3" style="line-height: 1.2;color: #666666;">Get this handbook worth ₹1000 for free. Know how word of mouth can be a real game changer for your business marketing.</p>
        <p class="text-uppercase font-700 mb-1" style="line-height: 1;">BOOK WORTH</p>
        <p class="font-600 h3 mb-1" style="line-height: 1;">&#8377; 1000</p>
        <p class="font-600 text-uppercase font-700 text-danger" style="line-height: 1;">Download Now for <span class="font-700">free</span></p>
        {{-- <div class="d-flex_">
            <img src="{{ asset('assets/website/images/e-book/amazon.svg') }}" class="amz-logo pe-1" alt="MouthPublicity.io">
            <img src="{{ asset('assets/website/images/e-book/five-star.png') }}" class="ratings-star pe-1" alt="MouthPublicity.io">
            <span class="font-400">4.7/5</span>
        </div> --}}
        <div class="mt-3 form-type-one">
            <div class="form-group mb-3">
                <input type="email" id="e_book_email" name="e_book_email" class="form-control shadow mtc_trigger" data-mtcinput="#mauticform_input_ebooksubscription_email" placeholder="Share Email & Get it on your inbox!">
            </div>
            <button type="button" class="btn btn-primary-ol w-100 sent-message" id="ebookGetNow">Get Now</button>
        </div>
        <img src="{{ asset('assets/website/images/e-book/blog-ebook.png') }}" class="ebookImg mt-4" alt="MouthPublicity.io E-book">
    </div>
    {{-- E-Book END  --}}



    {{-- Subscription --}}
    @if($setting->show_subscription)
    <div class="">
        <h5 class="font-h1 ">More Update!</h5>
        <p>Join our mailing list and keep up with <span class="brandname">MouthPublicity.io</span></p>
        <div class="subscriber">
          <div class="subscribe_form">
              <div class="subs_row">
                  <input type="email" class="subscribe_input" required placeholder="Your Email ID" id="subscriber">
                  <button type="submit" class="subs_btn" id="subscribeEmail">Send</button>
              </div>
          </div>
        </div>
        <div class="error-message-sec">
            <p class="text-message-success"></p>
            <p class="text-message-error"></p>
        </div>
    </div>

    <hr class="my-4">
    @endif

    {{-- Categories --}}
    @if($setting->show_category)
    <div class="">
        <h5>Categories</h5>
        <div>
            <ul class="blogs-links-list">
                <li>
                    <a href="">
                        <h6 class="title_link">All</h6>
                    </a>
                </li>
                <li>
                    <a href="">
                        <h6 class="title_link">Business</h6>
                    </a>
                </li>
                <li>
                    <a href="">
                        <h6 class="title_link">Cashbacks</h6>
                    </a>
                </li>
                <li>
                    <a href="">
                        <h6 class="title_link">Coupons</h6>
                    </a>
                </li>
                <li>
                    <a href="">
                        <h6 class="title_link">Offers</h6>
                    </a>
                </li>
                <li>
                    <a href="">
                        <h6 class="title_link">Social Media</h6>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <hr class="my-4">
    @endif

    {{-- Top Posts --}}
    @if($setting->show_top_post)
    <div class="">
        <h5>Top Posts</h5>
        <div>
            <ul class="blogs-links-list">
                <li>
                    <a href="">
                        <h6 class="title_link">Lorem, ipsum dolor sit amet consectetur adipisicing elit Sed rerum molestias.</h6>
                        <p class="short-text">Read Now</p>
                    </a>
                </li>
                <li>
                    <a href="">
                        <h6 class="title_link">Molestias ipsum provident placeat aliquid ipsa dicta quibusdam possimus non nostrum quae.</h6>
                        <p class="short-text">Read Now</p>
                    </a>
                </li>
                <li>
                    <a href="">
                        <h6 class="title_link">Sit amet consectetur adipisicing elit. Nesciunt, ad eum. Hic eius corporis qui ducimus enim amet!</h6>
                        <p class="short-text">Read Now</p>
                    </a>
                </li>
                <li>
                    <a href="">
                        <h6 class="title_link">Saepe temporibus nisi consequatur, debitis magnam illum ratione, sit eveniet ipsum neque eaque ab sapiente voluptate</h6>
                        <p class="short-text">Read Now</p>
                    </a>
                </li>
                <li>
                    <a href="">
                        <h6 class="title_link">Ea illum, quisquam, cum ab doloremque accusamus maiores praesentium ad magni doloribus eaque consectetur</h6>
                        <p class="short-text">Read Now</p>
                    </a>
                </li>
            </ul>
            
        </div>
    </div>
    @endif

</aside>

{{-- Push E-Book Modal and Form script --}}
@push('end_body')
{{-- E-Book Modal --}}
<div class="modal ol-modal popin" id="EBookModal" data-bs-backdrop="static" aria-hidden="true">
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
                                    <h5 class="font-600 fst-italic">Hurry up..!</h5>
                                    <h4 class="text-uppercase font-800 color-gradient h3" style="line-height: 1.1;">Your book is on the way</h4>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <p class="">Sign up now and check the Mouth Publicity book, plus get the offers and updates from <span class="color-gradient font-900">MouthPublicity.io</span> </p>
                            </div>
                        </div>
                    
                        <div class="row align-items-center" style="position: relative;">
                            <div class="col-lg-6">
                                <div class="body_part_image">
                                    <img src="{{ asset('assets/front/images/e-book/blog-ebook.png') }}" class="w-100" alt="MouthPublicity.io E-Book">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                {{-- <h5></h5> --}}
                                <p class="font-600 small">The E-Book will be directly sent to your email ID.</p>
                                <form accept="#" method="post" id="getEBookForm" class="form-type-one">
                                    <div class="form-group mb-3">
                                        <input name="name" type="text" class="form-control mtc_trigger shadow-sm" data-mtcinput="#mauticform_input_ebooksubscription_f_name" id="book_name" placeholder="Enter Your Name *" required />
                                    </div>
                                    <div class="form-group mb-3">
                                        <input name="number" type="tel" class="form-control mtc_trigger shadow-sm" data-mtcinput="#mauticform_input_ebooksubscription_whatsapp_number" id="book_number" placeholder="WhatsApp No. *" required />
                                    </div>
                                    <div class="form-group mb-3">
                                        <input name="email" type="email" class="form-control mtc_trigger shadow-sm" data-mtcinput="#mauticform_input_ebooksubscription_email" id="book_email" placeholder="Enter your E-mail ID *" required />
                                    </div>
                                    <div class="error_mag font-600 font-small mb-3"></div>
                                    <div class="">
                                        <button class="btn btn-primary-ol btn-lg font-700 w-100" type="submit">Get Book</button>
                                    </div>
                                </form>

                                <div class="d-none" style="display: none;">
                                    <form autocomplete="false" role="form" method="post" action="https://mp.salesrobo.com/form/submit?formId=6" id="mauticform_ebooksubscription" data-mautic-form="ebooksubscription" enctype="multipart/form-data">
                                        <input  name="mauticform[f_name]" id="mauticform_input_ebooksubscription_f_name" value="" placeholder="enter your name" class="mauticform-input" type="text">
                                        <input  name="mauticform[email]" id="mauticform_input_ebooksubscription_email" value="" placeholder="enter your email id" class="mauticform-input" type="email">
                                        <input  name="mauticform[whatsapp_number]" id="mauticform_input_ebooksubscription_whatsapp_number" value="" placeholder="enter your WhatsApp number" class="mauticform-input" type="tel">
                                        <input  name="mauticform[formId]" type="hidden" id="mauticform_ebooksubscription_id" value="6">
                                        <input  name="mauticform[return]" type="hidden" id="mauticform_ebooksubscription_return" value="">
                                        <input  name="mauticform[formName]" type="hidden" id="mauticform_ebooksubscription_name" value="ebooksubscription">
                                        <button  name="mauticform[submit]" type="submit" id="mauticform_input_ebooksubscription_submit" value="" class="mauticform-button btn btn-default">Submit</button>
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
{{-- E-Book Modal -- END --}}

@include('website.scripts.ebook-js')

@endpush