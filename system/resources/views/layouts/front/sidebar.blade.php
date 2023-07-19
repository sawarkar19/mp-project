<div>
    {{-- E-Book  --}}
    <div class="BlogIn-sidebar px-xl-5 px-lg-3 mt-4 mt-lg-0">
        <h2 class="font-600 itStyle h3">Limited Edition</h2>
        <h3 class="text-uppercase font-600 color-text-gradient-lighter h2" style="line-height: 1.1;">RAPID BUSINESS GROWTH BOOK TO BOOST SALES</h3>
        <p class="font-600 my-3" style="line-height: 1.2;color: #666666;">Getting 100% free to 1000&#8377; of targeted customers using these pre-tested strategies</p>
        <p class="text-uppercase font-600 h5" style="line-height: 1;">BOOK WORTH</p>
        <p class="font-600 BlogNum" style="line-height: 0.9;">&#8377; 1000.</p>
        <p class="font-600" style="line-height: 0;">Download Now for free</p>
        <div class="d-flex_">
            <img src="{{ asset('assets/front/images/e-book/amazon.svg') }}" class="amzImg pe-1" alt="MouthPublicity.io">
            <img src="{{ asset('assets/front/images/e-book/five-star.png') }}" class="starImg pe-1" alt="MouthPublicity.io">
            <span class="font-400">4.7/5</span>
        </div>
        <div class="mt-4">
            <div class="form-group mb-3">
                <input type="email" id="e_book_email" name="e_book_email" class="form-control ol-input" placeholder="Share Email & Get it on your inbox!">
            </div>
            <button type="button" class="btn btn-theme w-100 sent-message" id="ebookGetNow">Get Now</button>
        </div>
        <img src="{{ asset('assets/front/images/e-book/blog-ebook.png') }}" class="ebookImg mt-5" alt="MouthPublicity.io">
    </div>
    {{-- E-Book END  --}}

    {{-- SUbscription --}}
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

</div>