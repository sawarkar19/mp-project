<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="shortcut icon" href="{{asset('favicon.ico')}}" type="image/x-icon">

    <title>{{ $offer->title }}</title>

    <!-- Bootstrap 5.2.0 -->
    <link rel="stylesheet" href="{{ asset('assets/website/vendor/bootstrap/css/bootstrap.min.css') }}" media="all">
    <link rel="stylesheet" href="{{ asset('assets/instant_card/css/magnific-popup.css') }}" media="all">
    @include('instant-challenge.style')

    <script src="{{ asset('assets/js/jQuery.3.6.0.min.js') }}"></script>
    <script src="{{asset('assets/website/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/js/input-validation.js') }}"></script>
    <script src="{{asset('assets/instant_card/js/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{asset('assets/website/js/confetti.js')}}"></script>

</head>
<body>

{{-- Copy to clipboard --}}
<input id="cpToClipbord" type="text" style="display: none">
{{-- <iframe ></iframe> --}}

<section class="main-page" id="instant-tasks">
    <div class="container">

        <div class="card instant-tasks">

            @php
                if($offer->type == 'custom'){
                    if($offer->website_url != ''){
                        if($offer->website_meta_image != ''){
                            $img_url = $offer->website_meta_image;
                        }else{
                            $img_url = asset('assets/img/default_website_img.jpg');
                        }
                    }else{
                        $img_url = asset('assets/templates/custom').'/'.$offer->image;
                    } 
                }else{
                    $img_url = asset('assets/offer-thumbnails').'/'.$offer->offer_template->thumbnail;
                }
            @endphp
            {{-- Offer Image --}}
            <div class="card-img">
                <div class="offer-image" style="background-image: url({{ $img_url }})"></div>
            </div>

            {{-- Offer Content, Title & text --}}
            <div class="card-body">
                <h1 class="main-title">{{ $offer->title }}</h1>
                <p class="main-text">{{ $offer->description }}</p>

                @if(count($instantTasks) > 0)
                    @if($settings['type'] != 'Free')
                        <div class="task-info">
                            Complete minimum <span style="color:#FC6262;"><span>{{ $settings->details['minimum_task'] }}</span> tasks</span> from the following list and get the redeem code on your mobile number
                        </div>
                    @endif
                @endif
            </div>

            {{-- Offer's Task List Container --}}
            <div class="tasks-container mb-0">
                
                {{-- Define variable of the main array --}}
                @php 
                    $all_tasks = array(); 
                @endphp

                {{-- Count number of task   --}}
                @if (count($instantTasks) == 0)
                    {{-- if count 0 show alert --}}
                    <div class="text-center">
                        <span class="no-tasks">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="rotate" viewBox="0 0 16 16">
                                <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                                <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                            </svg>
                        </span>
                    </div>

                @else

                    {{-- Or else show all the tasks --}}
                    @foreach ($instantTasks as $instantKey => $instantTask)
                        @php
                            $isComingSoon = $instantTask->task->coming_soon ?? 0;
                        @endphp

                        @if ($isComingSoon==0)
                            @php
                                $isTaskShow = 1;
                                $redirectBaseUrl = $iconColor = $icon = $action_icon = $openTaskModal = "";
                                $isNoAppLinkClass = $task_value = $redirectBaseUrlBrowser = "";

                                // ex. for google review
                                $one_extra_field_value = "";

                                if($subscription->status == '1' && in_array($instantTask->id, $redeemedTasks)){
                                    $is_hide_task = true;
                                }else{
                                    $is_hide_task = false;
                                }
                                
                                /* # Incomplete and Complete Social Media Icon # */
                                $action_icon = ""; /* redeem not completred */
                                if(!in_array($instantTask->id, $completedTasks)){
                                    if($tasks[$instantTask->task_id]=="fb_page_url" || $tasks[$instantTask->task_id]=="fb_like_post_url"){
                                        $action_icon = 'FB-like'; /* FACEBOOK LIKE */
                                    }
                                    else if($tasks[$instantTask->task_id]=="fb_comment_post_url"){
                                        $action_icon = 'FB-comment'; /* FACEBOOK COMMENT */
                                    }
                                    else if($tasks[$instantTask->task_id]=="fb_share_post_url"){
                                        $action_icon = 'FB-share'; /* FACEBOOK SHARE */
                                    }
                                    
                                    else if($tasks[$instantTask->task_id]=="insta_profile_url"){
                                        $action_icon = 'IG-follow'; /* INSTAGRAM FOLLOW */
                                    }
                                    else if($tasks[$instantTask->task_id]=="insta_post_url"){
                                        $action_icon = 'IG-like'; /* INSTAGRAM LIKE */
                                    }
                                    else if($tasks[$instantTask->task_id]=="insta_comment_post_url"){
                                        $action_icon = 'IG-comment'; /* INSTAGRAM COMMENT */
                                    }
                                    
                                    else if($tasks[$instantTask->task_id]=="tw_username"){
                                        $action_icon = 'TW-follow'; /* TWITTER FOLLOW */
                                    }
                                    else if($tasks[$instantTask->task_id]=="tw_tweet_url"){
                                        $action_icon = 'TW-like'; /* TWITTER LIKE */
                                    }
                                    
                                    else if($tasks[$instantTask->task_id]=="li_company_url"){
                                        $action_icon = 'LN-follow'; /* LINKEDIN FOLLOW */
                                    }
                                    else if($tasks[$instantTask->task_id]=="li_post_url"){
                                        $action_icon = 'LN-like'; /* LINKEDIN LIKE */
                                    }
                                    
                                    else if($tasks[$instantTask->task_id]=="yt_channel_url"){
                                        $action_icon = 'YT-subscribe'; /* YOUTUBE SUBSCRIBE */
                                    }
                                    else if($tasks[$instantTask->task_id]=="yt_like_url"){
                                        $action_icon = 'YT-like'; /* YOUTUBE LIKE */
                                    }
                                    else if($tasks[$instantTask->task_id]=="yt_comment_url"){
                                        $action_icon = 'YT-comment'; /* YOUTUBE COMMENT */
                                    }
                                    
                                    else if($tasks[$instantTask->task_id]=="google_review_link"){
                                        $action_icon = 'GL-review'; /* GOOGLE REVIEW */
                                    }

                                    else if($tasks[$instantTask->task_id]=="visit_page_url"){
                                        $action_icon = 'WB-visit'; /* WEBSITE VISIT */
                                    }
                                }
                                else{
                                    if($tasks[$instantTask->task_id]=="fb_page_url" || $tasks[$instantTask->task_id]=="fb_like_post_url"){
                                        $action_icon = 'FB-liked'; /* FACEBOOK LIKE */
                                    }
                                    else if($tasks[$instantTask->task_id]=="fb_comment_post_url"){
                                        $action_icon = 'FB-commented'; /* FACEBOOK COMMENT */
                                    }
                                    else if($tasks[$instantTask->task_id]=="fb_share_post_url"){
                                        $action_icon = 'FB-shared'; /* FACEBOOK SHARE */
                                    }
                                    
                                    else if($tasks[$instantTask->task_id]=="insta_profile_url"){
                                        $action_icon = 'IG-following'; /* INSTAGRAM FOLLOW */
                                    }
                                    else if($tasks[$instantTask->task_id]=="insta_post_url"){
                                        $action_icon = 'IG-liked'; /* INSTAGRAM LIKE */
                                    }
                                    else if($tasks[$instantTask->task_id]=="insta_comment_post_url"){
                                        $action_icon = 'IG-commented'; /* INSTAGRAM COMMENT */
                                    }
                                    
                                    else if($tasks[$instantTask->task_id]=="tw_username"){
                                        $action_icon = 'TW-following'; /* TWITTER FOLLOW */
                                    }
                                    else if($tasks[$instantTask->task_id]=="tw_tweet_url"){
                                        $action_icon = 'TW-liked'; /* TWITTER LIKE */
                                    }
                                    
                                    else if($tasks[$instantTask->task_id]=="li_company_url"){
                                        $action_icon = 'LN-following'; /* LINKEDIN FOLLOW */
                                    }
                                    else if($tasks[$instantTask->task_id]=="li_post_url"){
                                        $action_icon = 'LN-liked'; /* LINKEDIN LIKE */
                                    }
                                    
                                    else if($tasks[$instantTask->task_id]=="yt_channel_url"){
                                        $action_icon = 'YT-subscribed'; /* YOUTUBE SUBSCRIBE */
                                    }
                                    else if($tasks[$instantTask->task_id]=="yt_like_url"){
                                        $action_icon = 'YT-liked'; /* YOUTUBE LIKE */
                                    }
                                    else if($tasks[$instantTask->task_id]=="yt_comment_url"){
                                        $action_icon = 'YT-commented'; /* YOUTUBE COMMENT */
                                    }
                                    
                                    else if($tasks[$instantTask->task_id]=="google_review_link"){
                                        $action_icon = 'GL-reviewed'; /* GOOGLE REVIEW */
                                    }

                                    else if($tasks[$instantTask->task_id]=="visit_page_url"){
                                        $action_icon = 'WB-visited'; /* WEBSITE VISIT */
                                    }
                                }


                                /* ==============
                                    FACEBOOK 
                                ============== */
                                if($tasks[$instantTask->task_id]=="fb_page_url" || $tasks[$instantTask->task_id]=="fb_comment_post_url" || $tasks[$instantTask->task_id]=="fb_like_post_url" || $tasks[$instantTask->task_id]=="fb_share_post_url"){
                                    if($tasks[$instantTask->task_id]=="fb_page_url"){
                                        $redirectBaseUrl = "fb://page/".$instantTask['task_value'];
                                        $isNoAppLinkClass = "fb-page-link";
                                        $task_value = $instantTask['task_value'];
                                    }
                                    else{
                                        // $redirectBaseUrl = "fb://facewebmodal/f?href=/".$instantTask['task_value'];
                                        // $redirectBaseUrl = "fb://page?pfbid0uAnwWUeVAGoGVygqo7fwLB2LKA1wDi8stDwF2btyuVwKkK3yw4bWPjphJh7NZTuWl";
                                        $redirectBaseUrl = $instantTask['task_value']; // redirect after login in browser
                                        $isNoAppLinkClass = "fb-post-link";
                                        $task_value = $instantTask['task_value'];

                                        $redirectBaseUrlBrowser = $instantTask['task_value'];
                                        $redirectBaseUrlBrowser = str_replace("https://www.facebook.com","https://m.facebook.com",$redirectBaseUrlBrowser);
                                    }
                                    $iconColor = "fb";
                                    $icon = 'facebook.svg'; /* all logo files are stored in the directory [assets/instant_card/imgs/] */
                                    $openTaskModal = "";
                                    if($tasks[$instantTask->task_id]=="fb_page_url"){
                                        // $openTaskModal = 'checkFacebookLikeOurPage("'.$instantTask['id'].'")';
                                    }
                                    else if($tasks[$instantTask->task_id]=="fb_comment_post_url"){
                                        // $openTaskModal = 'checkFacebookPostComment("'.$instantTask['id'].'")';
                                    }
                                    else if($tasks[$instantTask->task_id]=="fb_like_post_url"){
                                        // $openTaskModal = 'checkFacebookPostLike("'.$instantTask['id'].'")';
                                    }
                                    // else if($tasks[$instantTask->task_id]=="fb_share_post_url"){
                                    //     $openTaskModal = 'checkFacebookSharePost("'.$instantTask['id'].'")';
                                    // }
                                }

                                /*============== 
                                    INTAGRAM 
                                ==============*/
                                else if($tasks[$instantTask->task_id]=="insta_profile_url" || $tasks[$instantTask->task_id]=="insta_post_url" || $tasks[$instantTask->task_id]=="insta_comment_post_url"){
                                    if($tasks[$instantTask->task_id]=="insta_profile_url"){
                                        $isNoAppLinkClass = "instagram-follow-link";
                                    }
                                    else{
                                        $isNoAppLinkClass = "instagram-post-link";
                                    }
                                    $redirectBaseUrl = $instantTask['task_value'];
                                    $task_value = $instantTask['task_value'];
                                    $iconColor = "ig";
                                    $icon = 'instagram.svg'; /* all logo files are stored in the directory [assets/instant_card/imgs/] */
                                    $openTaskModal = "";
                                }

                                /*============== 
                                    TWITTER 
                                ==============*/
                                else if($tasks[$instantTask->task_id]=="tw_username" || $tasks[$instantTask->task_id]=="tw_tweet_url"){
                                    if($tasks[$instantTask->task_id]=="tw_username"){
                                        $tweet_ID = $instantTask['task_value'];
                                        $prefix = '@';
                                        if (substr($instantTask['task_value'], 0, strlen($prefix)) == $prefix) {
                                            $tweet_ID = substr($instantTask['task_value'], strlen($prefix));
                                        }
                                        $redirectBaseUrl = 'https://twitter.com/'.$tweet_ID;
                                        $isNoAppLinkClass = "tw-profile-link";
                                        $task_value = $tweet_ID;
                                    }
                                    else{
                                        $redirectBaseUrl = $instantTask['task_value'];
                                        $isNoAppLinkClass = "tw-post-link";
                                        $task_value = $instantTask['task_value'];
                                    }
                                    $iconColor = "tw";
                                    $icon = 'twitter.svg'; /* all logo files are stored in the directory [assets/instant_card/imgs/] */

                                    if($tasks[$instantTask->task_id]=="tw_username"){
                                        // $openTaskModal = 'checkFollow("'.$instantTask['id'].'")';
                                    }
                                    else if($tasks[$instantTask->task_id]=="tw_tweet_url"){
                                        // $openTaskModal = 'checkTwLikedBy("'.$instantTask['id'].'")';
                                    }
                                }

                                /*============== 
                                    LINKEDIN 
                                ==============*/
                                else if($tasks[$instantTask->task_id]=="li_company_url" || $tasks[$instantTask->task_id]=="li_post_url"){
                                    $redirectBaseUrl = $instantTask['task_value'];
                                    $iconColor = "li";
                                    $icon = 'linkedin.svg'; /* all logo files are stored in the directory [assets/instant_card/imgs/] */
                                    $openTaskModal = "";
                                }

                                /*============== 
                                    YOUTUBE 
                                ==============*/
                                else if($tasks[$instantTask->task_id]=="yt_channel_url" || $tasks[$instantTask->task_id]=="yt_like_url" || $tasks[$instantTask->task_id]=="yt_comment_url"){
                                    $redirectBaseUrl = $instantTask['task_value'];
                                    $iconColor = "yt";
                                    $icon = 'youtube.svg'; /* all logo files are stored in the directory [assets/instant_card/imgs/] */
                                    if($tasks[$instantTask->task_id]=="yt_channel_url"){
                                        // $openTaskModal = 'checkSubscribe("'.$instantTask['id'].'")';
                                        $isNoAppLinkClass = "youtube-channel-link";
                                        $task_value = $instantTask['task_value'];
                                    }
                                    else if($tasks[$instantTask->task_id]=="yt_comment_url"){
                                        // $openTaskModal = 'checkComment("'.$instantTask['id'].'")';
                                        $isNoAppLinkClass = "youtube-post-link";
                                        $task_value = $instantTask['task_value'];
                                    }
                                    else if($tasks[$instantTask->task_id]=="yt_like_url"){
                                        // $openTaskModal = 'checkLike("'.$instantTask['id'].'")';
                                        $isNoAppLinkClass = "youtube-post-link";
                                        $task_value = $instantTask['task_value'];
                                    }
                                }

                                /*==============
                                    GOOGLE REVIEW
                                ==============*/
                                else if($tasks[$instantTask->task_id]=="google_review_link"){
                                    $redirectBaseUrl = "https://search.google.com/local/writereview?placeid=".$instantTask['task_value'];
                                    $task_value = $instantTask['task_value'];
                                    $one_extra_field_value = $instantTask['one_extra_field_value'];

                                    $iconColor = "ins_icon";
                                    $icon = 'google.svg'; /* all logo files are stored in the directory [assets/instant_card/imgs/] */
                                    // dd($is_hide_task, $messageWallet->total_messages);
                                    // if($messageWallet->total_messages > 0){
                                    $openTaskModal = 'checkGoogleReview("'.$instantTask['id'].'")';
                                    // }else{
                                    //     if(!in_array($instantTask->id, $completedTasks)){
                                    //         // dd($is_hide_task, $messageWallet->total_messages);
                                    //         $isTaskShow = 0; 
                                    //     }
                                    // }
                                }

                                /*==============
                                    WEBSITE
                                ==============*/
                                else if($tasks[$instantTask->task_id]=="visit_page_url"){
                                    $redirectBaseUrl = $instantTask['task_value'];
                                    $iconColor = "ins_icon";
                                    $icon = 'visit.svg'; /* all logo files are stored in the directory [assets/instant_card/imgs/] */
                                    $openTaskModal = "";
                                }

                            @endphp

                            @php
                                if($isTaskShow){
                                    $task_data = array(
                                        'is_completed' => false,
                                        'status' => 'new',
                                        'disabled' => false,
                                        'task_id' => $instantTask['id'],
                                        'task_attr_id' => 'set-single-task_' . $instantTask['id'],
                                        'clickable_attr_id' => 'instant_task_id_' . $instantTask['id'],
                                        'hide_task' => $is_hide_task,
                                        'icon' => $icon,
                                        'name' => @$instantTask->task->name,
                                        'action_icon' => $action_icon,
                                        'onclick' => '',
                                        'redirect_url' => $redirectBaseUrl,
                                        'isNoAppLinkClass' => $isNoAppLinkClass,
                                        'task_value' => $task_value,
                                        'task_key' => $tasks[$instantTask['task_id']],
                                        'task_value_browser' => $redirectBaseUrlBrowser ?? NULL,
                                        'one_extra_field_value' => $one_extra_field_value ?? NULL,
                                    );

                                    if(in_array($instantTask['id'], $completedTasks)){
                                        $task_data['is_completed'] = true;
                                        $task_data['status'] = 'verified';
                                        $task_data['disabled'] = true;
                                    }else{
                                        if ($isNoAppLinkClass=="" && $task_value =="") {
                                            $task_data['redirect_url'] = $redirectBaseUrl;
                                        }
                                        if($openTaskModal != ""){
                                            $task_data['onclick'] = $openTaskModal;
                                        }
                                    }

                                    /* Push single task data to all tasks array. */
                                    array_push($all_tasks, $task_data);

                                }
                            @endphp
                            
                        @endif

                    @endforeach

                    @foreach ($all_tasks as $item)
                        @include('instant-challenge.components.task', $item)
                    @endforeach

                @endif
            </div>


            {{-- resend code button --}}
            <div class="small px-3 py-3 text-center" id="forResend" style="display: none">
                <a href="#" onclick="resendRedeemCode();return false;" >Click here</a> if redeem code not received automatically.

                <br/>
                <div id="redeemMsg"></div>
            </div>

            {{-- Offer Footer --}}
            <div class="card-footer py-3 bg-light border-0">
                <div>
                    <div class="d-flex align-items-center">
                        @if($business->logo != '' && file_exists('assets/business/logos/'.$business->logo))
                        <div class="me-3">
                            <img src="{{ asset('assets/business/logos/'.$business->logo) }}" alt="{{ $business->business_name }}" class="business_logo" />
                        </div>
                        @endif
                        <div class="">
                            <div class="">
                                <p class="mb-0 fw-normal">{{ $business->business_name }}</p>
                                <p class="mb-0 text-muted small fw-light">{{ $business->tag_line }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <footer>

        <div class="container">
            <div class="pb-3 pt-5">
                <div class="text-center text-white">
                    {{-- <p class="smallest mb-2">Powerd By <a href="#" target="_blank" class="logo_footer"><img src="{{ asset('assets/front/images/logo-light.svg') }}" alt="MouthPublicity" class="logo_powered"></a> </p> --}}
                    <p class="mb-2 small">Powerd By <a target="_blank" href="https://logicinnovates.com" style="color: #fdb500" class="fw-bold">Logic Innovates</a> </p>
                </div>
                <div class="d-flex justify-content-center text-white">
                    <a href="{{url('terms-and-conditions')}}" target="_blank" class="mx-2 small-links">Terms & Conditions</a>
                    <a href="{{url('privacy-policy')}}" target="_blank" class="mx-2 small-links">Privacy Policy</a>
                </div>
            </div>
        </div>
    </footer>

</section>

@foreach ($all_tasks as $item)
    @php
        $item['image']="";
        if($item['task_key']=="fb_page_url" || $item['task_key']=="fb_comment_post_url" || $item['task_key']=="fb_like_post_url"){
            $item['image'] = 'facebook.svg';
        }
        else if($item['task_key']=="insta_profile_url" || $item['task_key']=="insta_post_url" || $item['task_key']=="insta_comment_post_url"){
            $item['image'] = 'instagram.svg';
        }
        else if($item['task_key']=="tw_username" || $item['task_key']=="tw_tweet_url"){
            $item['image'] = 'twitter.svg';
        }
        else if($item['task_key']=="yt_channel_url" || $item['task_key']=="yt_like_url" || $item['task_key']=="yt_comment_url"){
            $item['image'] = 'youtube.svg';
        }
        else if($item['task_key']=="google_review_link"){
            $item['image'] = 'google.svg';
        }
    @endphp
    @include('instant-challenge.components.popups', $item)
@endforeach

{{-- Get Subscribers details Modal --}}
@include('instant-challenge.components.get-details')

{{-- Loader --}}
<div id="loader" style="display: none;">
    <div class="content">
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
            </svg>
        </div>
        <div>
            <h6>Please wait...<br>Redirecting to App or Web.</h6>
        </div>
    </div>
</div>

<div id="loaderFetchRecord" style="display: none;">
    <div class="content">
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
            </svg>
        </div>
        <div>
            <h6>Please wait...<br>fetching Records</h6>
        </div>
    </div>
</div>

<div id="overlay">
    <div class="cv-spinner">
        <span class="spinner"></span>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('.offer-image').magnificPopup({
            items: {
                src: '{{$img_url}}'
            },
            type:'image',
            mainClass: 'mfp-no-margins mfp-fade',
            image: {
                verticalFit: true
            },
        });
    });
    
    function congrats(){
        var end = Date.now() + (3 * 1000);
        (function frame() {
            confetti({
                particleCount: 5,
                spread: 40,
                angle: 70,
                origin: {x: 0, y:0.6}
            });
            confetti({
                particleCount: 5,
                spread: 40,
                angle: 110,
                origin: {x: 1, y:0.6}
            });
            if (Date.now() < end) {
                requestAnimationFrame(frame);
            }
        }());
    }
</script>

{{-- Show Block-Popup Msg --}}
@include('instant-challenge.components.popup-msg')

@include('instant-challenge.script-noapplink')
@include('instant-challenge.script-offer')

</body>
</html>