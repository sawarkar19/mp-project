<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="shortcut icon" href="{{asset('favicon.ico')}}" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/front/vendor/bootstrap/css/bootstrap.min.css') }}">

    {{-- <link rel="stylesheet" href="{{ asset('assets/js/line-awesome.min.css') }}" > --}}

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
        .hide_task{
            display: none;
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
                <p class="less_text">{{ \Illuminate\Support\Str::limit($offer->instant_offer->offer_description, 150, $end='...') }} <span><a href="#" class="show_more"> Show more</a></span></p>
                <p class="more_text">{{ $offer->instant_offer->offer_description }} <span><a href="#" class="show_less"> Show less</a></span></p>

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

                
                {{-- if tasks (Offer) is completed  --}}
                {{-- <div class="text-center border-bottom">
                    <div class="congrats">
                        <h5 class="mb-1"><span class="fw-bold d-block text-danger">Congrats! &#x1F600;</span></h5>
                        <p>You have unlock the offer. We have sent you the redeem code on your registered number.</p>
                    </div>
                </div> --}}
                

                {{-- If Tasks (offer) not complete  --}}
                
                <div class="text-center py-3 px-2 border-bottom">
                    <h6 class="mb-0 small">Complete <span class="fw-bold text-primary">{{ $offer->instant_offer->target }} Task</span> to Unlock Offer</h6>
                </div>
                
                
                
                {{-- Instant Tasks List --}}
                  <div class="task_list">

                    {{-- ======================= Single Task ======================= --}}

                    {{-- Classes for Brand:- Facebook: fb , Instagram: ig , Linkedin: li , Twitter: tw , Youtube: yt , Pinterest: pt --}}
                    
                    @if($tasks['fb_page_url'] != '') 
                    <div class="ins_task border-bottom fb @if(($redeem != null && $redeem->is_redeemed == 1) && (in_array($task_ids['fb_page_url'], $completedTasks))) hide_task @endif">

                        <a target="_blank" href="{{ $tasks['fb_page_url'] }}" id="fb_page_url" class="task_click"> {{-- CLick Event --}}

                        <div class="inner d-flex justify-content-between align-items-center">
                            {{-- ICON --}}
                            <div class="ins_icon">
                                <div class="ico-thm">
                                    {{-- Brand Icons Classes: Facebook: la-facebook , Instagram: la-instagram , Linkedin: la-linkedin , Twitter: la-twitter , Youtube: la-youtube , Pinterest: la-pinterest --}}
                                    {{-- <i class="la la-facebook"></i> --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                                        <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                                    </svg>
                                </div>
                            </div>

                            <div class="ins_title">
                                {{-- Title --}}
                                <h6 class="mb-0">Follow Our Page On Facebook </h6>
                            </div>

                            <div class="tic_ico">

                                @if(!in_array($task_ids['fb_page_url'], $completedTasks))
                                <span class="pending_task_fb_page_url"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" style="fill: var(--bs-orange);" class="" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                                </svg></span>
                                <span class="processing_task_fb_page_url" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="rotate" viewBox="0 0 16 16">
                                    <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                                    <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                                </svg></span>
                                @else
                                {{-- If Task is Processing  --}}
                                <span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="rotate" viewBox="0 0 16 16">
                                    <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                                    <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                                </svg></span>
                                @endif

                              
                                {{-- if task is not complete --}}
                                {{-- <span class="pending_task_fb_page_url"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" style="fill: var(--bs-orange);" class="" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                                </svg></span> --}}

                              
                                {{-- If Task is completed  --}}
                                {{-- <span class="completed_task_fb_page_url"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" style="fill: var(--bs-teal);" class="" viewBox="0 0 16 16">
                                    <path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01-.622-.636zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708z"/>
                                </svg></span> --}}

                            </div>
                        </div>

                        </a>
                    </div>
                    @endif

                    @if($tasks['fb_post_url'] != '') 
                    <div class="ins_task border-bottom fb @if(($redeem != null && $redeem->is_redeemed == 1) && (in_array($task_ids['fb_post_url'], $completedTasks))) hide_task @endif">

                        <a target="_blank" href="{{ $tasks['fb_post_url'] }}" id="fb_post_url" class="task_click"> {{-- CLick Event --}}

                        <div class="inner d-flex justify-content-between align-items-center">
                            {{-- ICON --}}
                            <div class="ins_icon">
                                <div class="ico-thm">
                                    {{-- Facebook icone --}}
                                    {{-- <i class="la la-facebook"></i> --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                                        <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                                    </svg>
                                </div>
                            </div>

                            <div class="ins_title">
                                {{-- Title --}}
                                <h6 class="mb-0">Like Our Post on Facebook </h6>
                            </div>

                            <div class="tic_ico">
                                @if(!in_array($task_ids['fb_post_url'], $completedTasks))
                                <span class="pending_task_fb_post_url"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" style="fill: var(--bs-orange);" class="" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                                </svg></span>
                                <span class="processing_task_fb_post_url" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="rotate" viewBox="0 0 16 16">
                                    <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                                    <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                                </svg></span>
                                @else
                                {{-- If Task is Processing  --}}
                                <span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="rotate" viewBox="0 0 16 16">
                                    <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                                    <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                                </svg></span>
                                @endif

                            </div>
                        </div>

                        </a>
                    </div>
                    @endif

                    {{-- ======================= Single Task End ======================= --}}

                    <!-- single task -->
                    @if($tasks['tw_username'] != '')
                    <div class="ins_task border-bottom tw @if(($redeem != null && $redeem->is_redeemed == 1) && (in_array($task_ids['tw_username'], $completedTasks))) hide_task @endif" title="Task Completed" data-bs-toggle="tooltip">
                        <a target="_blank" href="https://twitter.com/{{ $tasks['tw_username'] }}" id="tw_username" onclick="checkFollow()" class="">
                        <div class="inner d-flex justify-content-between align-items-center">
                        <!-- ICON -->
                        <div class="ins_icon">
                            <div class="ico-thm">
                            <!-- TWITTER SVG -->
                                {{-- <i class="la la-twitter"></i> --}}
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
                                    <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>
                                </svg>
                            </div>
                        </div>
                        <!-- Title -->
                        <div class="ins_title">
                            <h6 class="mb-0">Follow Us On Twitter</h6>
                        </div>
                        <div class="tic_ico">


                                @if(!in_array($task_ids['tw_username'], $completedTasks))
                                <span class="pending_task_tw_username"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" style="fill: var(--bs-orange);" class="" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                                </svg></span>
                                <span class="processing_task_tw_username" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="rotate" viewBox="0 0 16 16">
                                    <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                                    <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                                </svg></span>
                                @else
                                {{-- If Task is Processing  --}}
                                <span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="rotate" viewBox="0 0 16 16">
                                    <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                                    <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                                </svg></span>
                                @endif

                            </div>
                        </div>
                        </a>
                    </div>
                    @endif
                    <!-- single task End -->


                    <!-- single task -->
                    @if($tasks['tw_tweet_like'] != '')
                    <div class="ins_task border-bottom tw @if(($redeem != null && $redeem->is_redeemed == 1) && (in_array($task_ids['tw_tweet_like'], $completedTasks))) hide_task @endif" title="Task Completed" data-bs-toggle="tooltip">
                        <a target="_blank" href="{{ $tasks['tw_tweet_like'] }}" id="tw_tweet_like" onclick="checkTwLikedBy()" class="">
                        <div class="inner d-flex justify-content-between align-items-center">
                        <!-- ICON -->
                        <div class="ins_icon">
                            <div class="ico-thm">
                            <!-- TWITTER SVG -->
                                {{-- <i class="la la-twitter"></i> --}}
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
                                    <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>
                                </svg>
                            </div>
                        </div>
                        <!-- Title -->
                        <div class="ins_title">
                            <h6 class="mb-0">Like Our Tweet</h6>
                        </div>
                        <div class="tic_ico">

                                @if(!in_array($task_ids['tw_tweet_like'], $completedTasks))
                                <span class="pending_task_tw_tweet_like"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" style="fill: var(--bs-orange);" class="" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                                </svg></span>
                                <span class="processing_task_tw_tweet_like" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="rotate" viewBox="0 0 16 16">
                                    <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                                    <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                                </svg></span>
                                @else
                                {{-- If Task is Processing  --}}
                                <span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="rotate" viewBox="0 0 16 16">
                                    <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                                    <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                                </svg></span>
                                @endif

                            </div>
                        </div>
                        </a>
                    </div>
                    @endif

                    {{--insta_profile_url--}}

                    @if($tasks['insta_profile_url'] != '')
                    <!-- single task -->
                      <div class="ins_task border-bottom ig @if(($redeem != null && $redeem->is_redeemed == 1) && (in_array($task_ids['insta_profile_url'], $completedTasks))) hide_task @endif">
                        <a target="_blank" href="{{ $tasks['insta_profile_url'] }}" id="insta_profile_url" onclick="" class="task_click">
                        <div class="inner d-flex justify-content-between align-items-center">
                            <!-- ICON -->
                            <div class="ins_icon">
                                <div class="ico-thm">
                                    <!-- Instagram SVG -->
                                    {{-- <i class="la la-instagram"></i> --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                                        <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/>
                                    </svg>
                                </div>
                            </div>
                            <!-- Title -->
                            <div class="ins_title">
                            <h6 class="mb-0">Follow Us On Instagram</h6>
                            </div>
                            <div class="tic_ico">

                                @if(!in_array($task_ids['insta_profile_url'], $completedTasks))
                                <span class="pending_task_insta_profile_url"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" style="fill: var(--bs-orange);" class="" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                                </svg></span>
                                <span class="processing_task_insta_profile_url" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="rotate" viewBox="0 0 16 16">
                                    <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                                    <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                                </svg></span>
                                @else
                                {{-- If Task is Processing  --}}
                                <span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="rotate" viewBox="0 0 16 16">
                                    <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                                    <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                                </svg></span>
                                @endif

                            </div>
                        </div>
                        </a>
                        </div>
                        @endif

                        
                    <!-- single task -->
                    @if($tasks['insta_post_url'] != '')
                      <div class="ins_task border-bottom ig @if(($redeem != null && $redeem->is_redeemed == 1) && (in_array($task_ids['insta_post_url'], $completedTasks))) hide_task @endif">
                        <a target="_blank" href="{{ $tasks['insta_post_url'] }}" id="insta_post_url" class="task_click">
                        <div class="inner d-flex justify-content-between align-items-center">
                            <!-- ICON -->
                            <div class="ins_icon">
                                <div class="ico-thm">
                                    <!-- Instagram SVG -->
                                    {{-- <i class="la la-instagram"></i> --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                                        <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/>
                                    </svg>
                                </div>
                            </div>
                            <!-- Title -->
                            <div class="ins_title">
                            <h6 class="mb-0">Like Our Instagram Post</h6>
                            </div>
                            <div class="tic_ico">

                                @if(!in_array($task_ids['insta_post_url'], $completedTasks))
                                <span class="pending_task_insta_post_url"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" style="fill: var(--bs-orange);" class="" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                                </svg></span>
                                <span class="processing_task_insta_post_url" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="rotate" viewBox="0 0 16 16">
                                    <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                                    <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                                </svg></span>
                                @else
                                {{-- If Task is Processing  --}}
                                <span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="rotate" viewBox="0 0 16 16">
                                    <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                                    <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                                </svg></span>
                                @endif

                            </div>
                        </div>
                        </a>
                        </div>
                        @endif
                        <!-- single task End -->

                        
                        <!-- single task -->
                        @if($tasks['yt_channel_url'] != '')
                        <div class="ins_task border-bottom yt @if(($redeem != null && $redeem->is_redeemed == 1) && (in_array($task_ids['yt_channel_url'], $completedTasks))) hide_task @endif">
                        <a target="_blank" href="{{ $tasks['yt_channel_url'] }}" id="yt_channel_url" onclick="checkSubscribe()" class="">
                        <div class="inner d-flex justify-content-between align-items-center">
                            <!-- ICON -->
                            <div class="ins_icon">
                                <div class="ico-thm">
                                    <!-- Youtube SVG -->
                                    {{-- <i class="la la-youtube"></i> --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-youtube" viewBox="0 0 16 16">
                                        <path d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.007 2.007 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.007 2.007 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31.4 31.4 0 0 1 0 7.68v-.123c.002-.215.01-.958.064-1.778l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.007 2.007 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A99.788 99.788 0 0 1 7.858 2h.193zM6.4 5.209v4.818l4.157-2.408L6.4 5.209z"/>
                                    </svg>
                                </div>
                            </div>
                            <!-- Title -->
                            <div class="ins_title">
                            <h6 class="mb-0">Subscribe To Our Youtube Channel</h6>
                            </div>
                            <div class="tic_ico">

                                @if(!in_array($task_ids['yt_channel_url'], $completedTasks))
                                <span class="pending_task_yt_channel_url"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" style="fill: var(--bs-orange);" class="" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                                </svg></span>
                                <span class="processing_task_yt_channel_url" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="rotate" viewBox="0 0 16 16">
                                    <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                                    <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                                </svg></span>
                                @else
                                {{-- If Task is Processing  --}}
                                <span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="rotate" viewBox="0 0 16 16">
                                    <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                                    <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                                </svg></span>
                                @endif

                            </div>
                        </div>
                        </a>
                        </div>
                        @endif


                        
                        <!-- single task -->
                        @if($tasks['yt_comment_url'] != '')
                        <div class="ins_task border-bottom yt @if(($redeem != null && $redeem->is_redeemed == 1) && (in_array($task_ids['yt_comment_url'], $completedTasks))) hide_task @endif">
                        <a target="_blank" href="{{ $tasks['yt_comment_url'] }}" id="yt_comment_url" onclick="checkComment()" class="">
                        <div class="inner d-flex justify-content-between align-items-center">
                            <!-- ICON -->
                            <div class="ins_icon">
                                <div class="ico-thm">
                                    <!-- Youtube SVG -->
                                    {{-- <i class="la la-youtube"></i> --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-youtube" viewBox="0 0 16 16">
                                        <path d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.007 2.007 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.007 2.007 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31.4 31.4 0 0 1 0 7.68v-.123c.002-.215.01-.958.064-1.778l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.007 2.007 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A99.788 99.788 0 0 1 7.858 2h.193zM6.4 5.209v4.818l4.157-2.408L6.4 5.209z"/>
                                    </svg>
                                </div>
                            </div>
                            <!-- Title -->
                            <div class="ins_title">
                            <h6 class="mb-0">Comment On Our Youtube Video</h6>
                            </div>
                            <div class="tic_ico">

                                @if(!in_array($task_ids['yt_comment_url'], $completedTasks))
                                <span class="pending_task_yt_comment_url"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" style="fill: var(--bs-orange);" class="" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                                </svg></span>
                                <span class="processing_task_yt_comment_url" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="rotate" viewBox="0 0 16 16">
                                    <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                                    <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                                </svg></span>
                                @else
                                {{-- If Task is Processing  --}}
                                <span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="rotate" viewBox="0 0 16 16">
                                    <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                                    <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                                </svg></span>
                                @endif

                            </div>
                        </div>
                        </a>
                        </div>
                        @endif


                        
                        <!-- single task -->
                        @if($tasks['yt_like_url'] != '')
                        <div class="ins_task border-bottom yt @if(($redeem != null && $redeem->is_redeemed == 1) && (in_array($task_ids['yt_like_url'], $completedTasks))) hide_task @endif">
                        <a target="_blank" href="{{ $tasks['yt_like_url'] }}" id="yt_like_url" onclick="checkLike()" class="">
                        <div class="inner d-flex justify-content-between align-items-center">
                            <!-- ICON -->
                            <div class="ins_icon">
                                <div class="ico-thm">
                                    <!-- Youtube SVG -->
                                    {{-- <i class="la la-youtube"></i> --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-youtube" viewBox="0 0 16 16">
                                        <path d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.007 2.007 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.007 2.007 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31.4 31.4 0 0 1 0 7.68v-.123c.002-.215.01-.958.064-1.778l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.007 2.007 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A99.788 99.788 0 0 1 7.858 2h.193zM6.4 5.209v4.818l4.157-2.408L6.4 5.209z"/>
                                    </svg>
                                </div>
                            </div>
                            <!-- Title -->
                            <div class="ins_title">
                            <h6 class="mb-0">Like To Our Youtube Video</h6>
                            </div>
                            <div class="tic_ico">
                                @if(!in_array($task_ids['yt_like_url'], $completedTasks))
                                <span class="pending_task_yt_like_url"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" style="fill: var(--bs-orange);" class="" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                                </svg></span>
                                <span class="processing_task_yt_like_url" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="rotate" viewBox="0 0 16 16">
                                    <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                                    <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                                </svg></span>
                                @else
                                {{-- If Task is Processing  --}}
                                <span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="rotate" viewBox="0 0 16 16">
                                    <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                                    <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                                </svg></span>
                                @endif

                            </div>
                        </div>
                        </a>
                        </div>
                        @endif

                        
                        <!-- single task -->
                        @if($tasks['li_company_url'] != '')
                        <div class="ins_task border-bottom li @if(($redeem != null && $redeem->is_redeemed == 1) && (in_array($task_ids['li_company_url'], $completedTasks))) hide_task @endif">
                        <a target="_blank" href="{{ $tasks['li_company_url'] }}" id="li_company_url" class="task_click">
                        <div class="inner d-flex justify-content-between align-items-center">
                            <!-- ICON -->
                            <div class="ins_icon">
                                <div class="ico-thm">
                                    <!-- Linkedin SVG -->
                                    {{-- <i class="la la-linkedin"></i> --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-linkedin" viewBox="0 0 16 16">
                                        <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854V1.146zm4.943 12.248V6.169H2.542v7.225h2.401zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248-.822 0-1.359.54-1.359 1.248 0 .694.521 1.248 1.327 1.248h.016zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016a5.54 5.54 0 0 1 .016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225h2.4z"/>
                                    </svg>
                                </div>
                            </div>
                            <!-- Title -->
                            <div class="ins_title">
                            <h6 class="mb-0">Follow Our Linkedin Page</h6>
                            </div>
                            <div class="tic_ico">

                                @if(!in_array($task_ids['li_company_url'], $completedTasks))
                                <span class="pending_task_li_company_url"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" style="fill: var(--bs-orange);" class="" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                                </svg></span>
                                <span class="processing_task_li_company_url" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="rotate" viewBox="0 0 16 16">
                                    <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                                    <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                                </svg></span>
                                @else
                                {{-- If Task is Processing  --}}
                                <span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="rotate" viewBox="0 0 16 16">
                                    <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                                    <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                                </svg></span>
                                @endif

                            </div>
                        </div>
                        </a>
                        </div>
                        @endif

                        
                        <!-- single task -->
                        @if($tasks['google_link'] != '')
                        <div class="ins_task border-bottom @if(($redeem != null && $redeem->is_redeemed == 1) && (in_array($task_ids['google_link'], $completedTasks))) hide_task @endif">
                        <a target="_blank" href="{{ $tasks['google_link'] }}" id="google_link" class="task_click">
                        <div class="inner d-flex justify-content-between align-items-center">
                            <!-- ICON -->
                            <div class="ins_icon">
                                <div class="ico-thm">
                                    <!-- Google SVG -->
                                    {{-- <i class="la la-google"></i> --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-google" viewBox="0 0 16 16">
                                        <path d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.792 4.792 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.702 3.702 0 0 0 1.599-2.431H8v-3.08h7.545z"/>
                                    </svg>
                                </div>
                            </div>
                            <!-- Title -->
                            <div class="ins_title">
                            <h6 class="mb-0">Review Us On Google</h6>
                            </div>
                            <div class="tic_ico">

                                @if(!in_array($task_ids['google_link'], $completedTasks))
                                <span class="pending_task_google_link"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" style="fill: var(--bs-orange);" class="" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                                </svg></span>
                                <span class="processing_task_google_link" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="rotate" viewBox="0 0 16 16">
                                    <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                                    <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                                </svg></span>
                                @else
                                {{-- If Task is Processing  --}}
                                <span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="rotate" viewBox="0 0 16 16">
                                    <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                                    <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                                </svg></span>
                                @endif

                            </div>
                        </div>
                        </a>
                        </div>
                        @endif

                        
                        <!-- single task -->
                        @if($tasks['visit_page_url'] != '')
                        <div class="ins_task border-bottom @if(($redeem != null && $redeem->is_redeemed == 1) && (in_array($task_ids['visit_page_url'], $completedTasks))) hide_task @endif">
                        <a target="_blank" href="{{ $tasks['visit_page_url'] }}" id="visit_page_url" class="task_click">
                        <div class="inner d-flex justify-content-between align-items-center">
                            <!-- ICON -->
                            <div class="ins_icon">
                                <div class="ico-thm">
                                    <!-- website SVG -->
                                    {{-- <i class="la la-link"></i> --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-globe2" viewBox="0 0 16 16">
                                        <path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm7.5-6.923c-.67.204-1.335.82-1.887 1.855-.143.268-.276.56-.395.872.705.157 1.472.257 2.282.287V1.077zM4.249 3.539c.142-.384.304-.744.481-1.078a6.7 6.7 0 0 1 .597-.933A7.01 7.01 0 0 0 3.051 3.05c.362.184.763.349 1.198.49zM3.509 7.5c.036-1.07.188-2.087.436-3.008a9.124 9.124 0 0 1-1.565-.667A6.964 6.964 0 0 0 1.018 7.5h2.49zm1.4-2.741a12.344 12.344 0 0 0-.4 2.741H7.5V5.091c-.91-.03-1.783-.145-2.591-.332zM8.5 5.09V7.5h2.99a12.342 12.342 0 0 0-.399-2.741c-.808.187-1.681.301-2.591.332zM4.51 8.5c.035.987.176 1.914.399 2.741A13.612 13.612 0 0 1 7.5 10.91V8.5H4.51zm3.99 0v2.409c.91.03 1.783.145 2.591.332.223-.827.364-1.754.4-2.741H8.5zm-3.282 3.696c.12.312.252.604.395.872.552 1.035 1.218 1.65 1.887 1.855V11.91c-.81.03-1.577.13-2.282.287zm.11 2.276a6.696 6.696 0 0 1-.598-.933 8.853 8.853 0 0 1-.481-1.079 8.38 8.38 0 0 0-1.198.49 7.01 7.01 0 0 0 2.276 1.522zm-1.383-2.964A13.36 13.36 0 0 1 3.508 8.5h-2.49a6.963 6.963 0 0 0 1.362 3.675c.47-.258.995-.482 1.565-.667zm6.728 2.964a7.009 7.009 0 0 0 2.275-1.521 8.376 8.376 0 0 0-1.197-.49 8.853 8.853 0 0 1-.481 1.078 6.688 6.688 0 0 1-.597.933zM8.5 11.909v3.014c.67-.204 1.335-.82 1.887-1.855.143-.268.276-.56.395-.872A12.63 12.63 0 0 0 8.5 11.91zm3.555-.401c.57.185 1.095.409 1.565.667A6.963 6.963 0 0 0 14.982 8.5h-2.49a13.36 13.36 0 0 1-.437 3.008zM14.982 7.5a6.963 6.963 0 0 0-1.362-3.675c-.47.258-.995.482-1.565.667.248.92.4 1.938.437 3.008h2.49zM11.27 2.461c.177.334.339.694.482 1.078a8.368 8.368 0 0 0 1.196-.49 7.01 7.01 0 0 0-2.275-1.52c.218.283.418.597.597.932zm-.488 1.343a7.765 7.765 0 0 0-.395-.872C9.835 1.897 9.17 1.282 8.5 1.077V4.09c.81-.03 1.577-.13 2.282-.287z"/>
                                    </svg>
                                </div>
                            </div>
                            <!-- Title -->
                            <div class="ins_title">
                            <h6 class="mb-0">{{ $tasks['visit_page_title'] }}</h6>
                            </div>
                            <div class="tic_ico">

                                @if(!in_array($task_ids['visit_page_url'], $completedTasks))
                                <span class="pending_task_visit_page_url"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" style="fill: var(--bs-orange);" class="" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                                </svg></span>
                                <span class="processing_task_visit_page_url" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="rotate" viewBox="0 0 16 16">
                                    <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                                    <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                                </svg></span>
                                @else
                                {{-- If Task is Processing  --}}
                                <span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="rotate" viewBox="0 0 16 16">
                                    <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                                    <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                                </svg></span>
                                @endif

                            </div>
                        </div>
                        </a>
                        </div>
                        @endif
                        <!-- single task End -->

                    </div>
                    

                </div>
              <!-- Instant task list End -->
                <div class="border border-light p-3 mb-4">

                    <div class="text-center">
                      <button type="button" id="sendRedeemCode" class="btn btn-success waves-effect waves-light">Done</button>
                    </div>

                </div>
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
            {{-- <p class="smallest mb-2">Powerd By <a href="#" target="_blank" class="logo_footer"><img src="{{ asset('assets/front/images/logo-light.svg') }}" alt="MouthPublicity.io" class="logo_powered"></a> </p> --}}
            <p class="smallest mb-2">Powerd By <span style="color: #fdb500" class="fw-bold">Logic Innovates</span> </p>
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

    <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
    
    @include('templates.instant_offer_js')
    
</html>
