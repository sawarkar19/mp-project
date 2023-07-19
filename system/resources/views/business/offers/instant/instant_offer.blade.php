<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="{{asset('favicon.ico')}}" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/front/vendor/bootstrap/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/js/line-awesome.min.css') }}" >

    <link rel="stylesheet" href="{{ asset('assets/instant_card/css/style.css') }}">
    <title>{{ $offer->title }}</title>

    <style>
        body{
            background: linear-gradient(90deg, rgba(0,36,156, 0.8) 0%, rgb(0,255,175, 0.8) 180%);
        }
        #offers .instant_offer_card{
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 0px;
        }
        .more_text{
            display: none;
        }
        .show_more,.show_less{
            text-decoration: none;
        }
    </style>
  </head>
  <body>

    

    <section id="offers">
      <div class="container">
        <div class="my-3">

          <div class="instant_offer_card shadow-sm">
            <div class="inner">

              <div class="img mb-1">
                  {{-- IMAGE THUMBNAIL --}}
                  @if($offer->instant_offer->offer_banner != '')
                    <div class="img_thumb" style="background-image:url({{ asset('assets/offers/banners/'.$offer->instant_offer->offer_banner) }});"></div>
                  @else
                    <div class="img_thumb" style="background-image:url({{ asset('assets/offers/banners/instant-offer.jpg') }});"></div>
                  @endif
              </div>



              {{-- TITLE  --}}
              <div class="title pb-0">
                <h3>{{ $offer->title }}</h3>
              </div>
              
              {{-- INFORMATION DATA  --}}
              <div class="info">
                <p>{{ $offer->instant_offer->offer_description }}</p>
              </div>

              {{-- <div class="dashed-diveder"></div> --}}

               {{-- DATE & SHARE BUTTON  --}}
              {{-- <div class="share_option">
                <div class="">
                  <div class="text-center">
                    <div class="">
                      <p class="mb-0 small">Offer Ends In: <b>{{ $offer->end_date->format('j F, Y') }}</b></p>
                    </div>
                  </div>
                </div>
              </div> --}}

              <div class="dashed-diveder"></div>

              
              <div class="">

                {{-- If Tasks (offer) not complete  --}}
                
                <div class="text-center py-3 px-2 border-bottom">
                    <h6 class="mb-0 small">Complete <span class="fw-bold text-primary">{{ $offer->instant_offer->target }} Task</span> to Unlock Offer</h6>
                </div>
                
                
                {{-- Instant Tasks List --}}
                <div class="task_list">

                    {{-- ======================= Single Task ======================= --}}

                    {{-- Classes for Brand:- Facebook: fb , Instagram: ig , Linkedin: li , Twitter: tw , Youtube: yt , Pinterest: pt --}}
                    
                    @if($tasks['fb_page_url'] != '') 
                    <div class="ins_task border-bottom fb">

                        <a href="#"> {{-- CLick Event --}}

                        <div class="inner d-flex justify-content-between align-items-center">
                            {{-- ICON --}}
                            <div class="ins_icon">
                                <div class="ico-thm">
                                    {{-- Brand Icons Classes: Facebook: la-facebook , Instagram: la-instagram , Linkedin: la-linkedin , Twitter: la-twitter , Youtube: la-youtube , Pinterest: la-pinterest --}}
                                    <i class="la la-facebook"></i>
                                </div>
                            </div>

                            <div class="ins_title">
                                {{-- Title --}}
                                <h6 class="mb-0">Follow Our Page On Facebook </h6>
                            </div>

                            <div class="tic_ico">

                                {{-- if task is not complete --}}
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" style="fill: var(--bs-orange);" class="" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                                </svg>

                            </div>
                        </div>

                        </a>
                    </div>
                    @endif

                    @if($tasks['fb_post_url'] != '') 
                    <div class="ins_task border-bottom fb">

                        <a href="#"> {{-- CLick Event --}}

                        <div class="inner d-flex justify-content-between align-items-center">
                            {{-- ICON --}}
                            <div class="ins_icon">
                                <div class="ico-thm">
                                    {{-- Brand Icons Classes: Facebook: la-facebook , Instagram: la-instagram , Linkedin: la-linkedin , Twitter: la-twitter , Youtube: la-youtube , Pinterest: la-pinterest --}}
                                    <i class="la la-facebook"></i>
                                </div>
                            </div>

                            <div class="ins_title">
                                {{-- Title --}}
                                <h6 class="mb-0">Like Our Post on Facebook </h6>
                            </div>

                            <div class="tic_ico">

                                {{-- if task is not complete --}}
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" style="fill: var(--bs-orange);" class="" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                                </svg>

                            </div>
                        </div>

                        </a>
                    </div>
                    @endif

                    {{-- ======================= Single Task End ======================= --}}

                    <!-- single task -->
                    @if($tasks['tw_username'] != '')
                    <div class="ins_task border-bottom tw " title="Task Completed" data-bs-toggle="tooltip">
                        <a href="#">
                        <div class="inner d-flex justify-content-between align-items-center">
                        <!-- ICON -->
                        <div class="ins_icon">
                            <div class="ico-thm">
                            <!-- TWITTER SVG -->
                            <i class="la la-twitter"></i>
                            </div>
                        </div>
                        <!-- Title -->
                        <div class="ins_title">
                            <h6 class="mb-0">Follow Us On Twitter</h6>
                        </div>
                        <div class="tic_ico">

                            {{-- if task is not complete --}}
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" style="fill: var(--bs-orange);" class="" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                                </svg>
                            
                        </div>
                        </div>
                        </a>
                    </div>
                    @endif

                    <!-- single task End -->


                    <!-- single task -->
                    @if($tasks['tw_tweet_like'] != '')
                    <div class="ins_task border-bottom tw" title="Task Completed" data-bs-toggle="tooltip">
                        <a href="#"/>
                        <div class="inner d-flex justify-content-between align-items-center">
                        <!-- ICON -->
                        <div class="ins_icon">
                            <div class="ico-thm">
                            <!-- TWITTER SVG -->
                            <i class="la la-twitter"></i>
                            </div>
                        </div>
                        <!-- Title -->
                        <div class="ins_title">
                            <h6 class="mb-0">Like Our Tweet</h6>
                        </div>
                        <div class="tic_ico">

                            <span class="pending_task_tw_tweet_like"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" style="fill: var(--bs-orange);" class="" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                                </svg></span>

                            </div>
                        </div>
                        </a>
                    </div>
                    @endif

                    <!-- single task End -->

                    @if($tasks['insta_profile_url'] != '')
                    <!-- single task -->
                      <div class="ins_task border-bottom ig">
                        <a href="#">
                        <div class="inner d-flex justify-content-between align-items-center">
                            <!-- ICON -->
                            <div class="ins_icon">
                            <div class="ico-thm">
                                <!-- FACEBOOK SVG -->
                                <i class="la la-instagram"></i>
                            </div>
                            </div>
                            <!-- Title -->
                            <div class="ins_title">
                            <h6 class="mb-0">Follow Us on Instagram</h6>
                            </div>
                            <div class="tic_ico">

                                {{-- if task is not complete --}}
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" style="fill: var(--bs-orange);" class="" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                                </svg>

                            </div>
                        </div>
                        </a>
                        </div>
                        @endif

                        @if($tasks['insta_post_url'] != '')
                    <!-- single task -->
                      <div class="ins_task border-bottom ig">
                        <a href="#">
                        <div class="inner d-flex justify-content-between align-items-center">
                            <!-- ICON -->
                            <div class="ins_icon">
                            <div class="ico-thm">
                                <!-- FACEBOOK SVG -->
                                <i class="la la-instagram"></i>
                            </div>
                            </div>
                            <!-- Title -->
                            <div class="ins_title">
                            <h6 class="mb-0">Like Our Instagram Post</h6>
                            </div>
                            <div class="tic_ico">

                                {{-- if task is not complete --}}
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" style="fill: var(--bs-orange);" class="" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                                </svg>

                            </div>
                        </div>
                        </a>
                        </div>
                        @endif
                        <!-- single task End -->

                        @if($tasks['yt_channel_url'] != '')
                        <!-- single task -->
                        <div class="ins_task border-bottom yt">
                        <a href="#">
                        <div class="inner d-flex justify-content-between align-items-center">
                            <!-- ICON -->
                            <div class="ins_icon">
                            <div class="ico-thm">
                                <!-- FACEBOOK SVG -->
                                <i class="la la-youtube"></i>
                            </div>
                            </div>
                            <!-- Title -->
                            <div class="ins_title">
                            <h6 class="mb-0">Subscribe To Our Youtube Channel</h6>
                            </div>
                            <div class="tic_ico">

                            {{-- if task is not complete --}}
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" style="fill: var(--bs-orange);" class="" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                                </svg>

                            </div>
                        </div>
                        </a>
                        </div>
                        @endif


                        @if($tasks['yt_comment_url'] != '')
                        <!-- single task -->
                        <div class="ins_task border-bottom yt">
                        <a href="#">
                        <div class="inner d-flex justify-content-between align-items-center">
                            <!-- ICON -->
                            <div class="ins_icon">
                            <div class="ico-thm">
                                <!-- FACEBOOK SVG -->
                                <i class="la la-youtube"></i>
                            </div>
                            </div>
                            <!-- Title -->
                            <div class="ins_title">
                            <h6 class="mb-0">Comment On Our Youtube Video</h6>
                            </div>
                            <div class="tic_ico">

                            {{-- if task is not complete --}}
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" style="fill: var(--bs-orange);" class="" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                                </svg>

                            </div>
                        </div>
                        </a>
                        </div>
                        @endif


                        @if($tasks['yt_like_url'] != '')
                        <!-- single task -->
                        <div class="ins_task border-bottom yt">
                        <a href="#">
                        <div class="inner d-flex justify-content-between align-items-center">
                            <!-- ICON -->
                            <div class="ins_icon">
                            <div class="ico-thm">
                                <!-- FACEBOOK SVG -->
                                <i class="la la-youtube"></i>
                            </div>
                            </div>
                            <!-- Title -->
                            <div class="ins_title">
                            <h6 class="mb-0">Like To Our Youtube Video</h6>
                            </div>
                            <div class="tic_ico">

                            {{-- if task is not complete --}}
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" style="fill: var(--bs-orange);" class="" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                                </svg>

                            </div>
                        </div>
                        </a>
                        </div>
                        @endif

                        @if($tasks['google_link'] != '') 
                        <div class="ins_task border-bottom">

                            <a href="#"> {{-- CLick Event --}}

                            <div class="inner d-flex justify-content-between align-items-center">
                                {{-- ICON --}}
                                <div class="ins_icon">
                                    <div class="ico-thm">
                                        {{-- Brand Icons Classes: Facebook: la-facebook , Instagram: la-instagram , Linkedin: la-linkedin , Twitter: la-twitter , Youtube: la-youtube , Pinterest: la-pinterest --}}
                                        <i class="la la-google"></i>
                                    </div>
                                </div>

                                <div class="ins_title">
                                    {{-- Title --}}
                                    <h6 class="mb-0">Review Us On Google </h6>
                                </div>

                                <div class="tic_ico">

                                    {{-- if task is not complete --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" style="fill: var(--bs-orange);" class="" viewBox="0 0 16 16">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                                    </svg>

                                </div>
                            </div>

                            </a>
                        </div>
                        @endif

                        @if($tasks['li_company_url'] != '')
                        <!-- single task -->
                        <div class="ins_task border-bottom li">
                        <a href="#">
                        <div class="inner d-flex justify-content-between align-items-center">
                            <!-- ICON -->
                            <div class="ins_icon">
                            <div class="ico-thm">
                                <!-- FACEBOOK SVG -->
                                <i class="la la-linkedin"></i>
                            </div>
                            </div>
                            <!-- Title -->
                            <div class="ins_title">
                            <h6 class="mb-0">Follow Our Linkedin Page</h6>
                            </div>
                            <div class="tic_ico">

                            {{-- if task is not complete --}}
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" style="fill: var(--bs-orange);" class="" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                                </svg>

                            </div>
                        </div>
                        </a>
                        </div>
                        @endif

                        @if($tasks['visit_page_url'] != '')
                        <!-- single task -->
                        <div class="ins_task border-bottom">
                        <a href="#">
                        <div class="inner d-flex justify-content-between align-items-center">
                            <!-- ICON -->
                            <div class="ins_icon">
                            <div class="ico-thm">
                                <!-- FACEBOOK SVG -->
                                <i class="la la-link"></i>
                            </div>
                            </div>
                            <!-- Title -->
                            <div class="ins_title">
                            <h6 class="mb-0">{{ $tasks['visit_page_title'] }}</h6>
                            </div>
                            <div class="tic_ico">

                            {{-- if task is not complete --}}
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" style="fill: var(--bs-orange);" class="" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                                </svg>

                            </div>
                        </div>
                        </a>
                        </div>
                        @endif
                        <!-- single task End -->

                    </div>
                    

                </div>
              <!-- Instant task list End -->

              <!-- VENDER INFO  -->
              <div class="business_option">
                <div class="d-flex align-items-center">
                  <div class="flex-column me-3">
                    @if($business->logo != '')
                      <img src="{{ asset('assets/business/logos/'.$business->logo) }}" alt="" class="business_logo" />
                    @else
                      <img src="{{ asset('assets/instant_card/imgs/no-preview.jpg') }}" alt="" class="business_logo" />
                    @endif
                  </div>
                  <div class="flex-column">
                    <div class="">
                      <p class="mb-0">{{ $business->business_name }}</p>
                      <p class="mb-0 text-muted smallest fw-light">{{ $business->tag_line }}</p>
                    </div>
                  </div>
                </div>
              </div>

            </div>

          </div>


        </div>
      </div>
    </section>

    <footer>
      <div class="container">
        <div class="pb-3 pt-5">
          <div class="text-center text-white">
            <p class="smallest mb-2">Powerd By <a href="#" target="_blank" class="logo_footer"><img src="{{ asset('assets/front/images/logo-light.svg') }}" alt="MouthPublicity" class="logo_powered"></a> </p>
          </div>
          <div class="d-flex justify-content-center text-white">
            <a href="/terms-and-conditions" class="mx-2 small-links">Terms & Conditions</a>
            <a href="/privacy-policy" class="mx-2 small-links">Privacy Policy</a>
          </div>
        </div>
      </div>
    </footer>

  </body>
  <script src="{{ asset('assets/js/jQuery.3.6.0.min.js') }}"></script>
  <script src="{{ asset('assets/front/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
</html>
