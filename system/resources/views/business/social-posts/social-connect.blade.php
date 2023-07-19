@extends('layouts.business')
@section('title', 'Connect With Social Media')
@section('head')
    @include('layouts.partials.headersection',['title'=>'Connect With Social Media'])
@endsection

@section('end_head')
<style>
.card.sconnect{
    position: relative;
    text-align: center;
    box-shadow: none!important;
    border: 1px solid rgba(0, 0, 0, .3);
    border-radius: 6px;
    height: 100%;
    margin-bottom: 0px;
}
.card.sconnect .card-body{
    padding-left: 10px;
    padding-right: 10px;
}
.sconnect .sc-icon i{
    font-size: 2.2rem;
}
.card.sconnect .connected,
.card.sconnect .new_connect,
.card.sconnect .re_connect{
    position: relative;
    padding: 10px;
    border-radius: 0 0 6px 6px;
}
.card.sconnect .connected{
    background-color: #d4edda;
    color: #155724;

    pointer-events: none;
}
.card.sconnect .new_connect{
    background-color: #cce5ff;
    color: #004085;
    cursor: pointer;
}
.card.sconnect .re_connect{
    background-color: #fff3cd;
    color: #856404;
    cursor: pointer;
}

.card.sconnect .connected-icon,
.card.sconnect .disconnected-icon{
    position: absolute;
    font-size: 1.2rem;
    top: 6px;
    left: 6px;
}
.card.sconnect .connected-icon{
    color: var(--success);
}
.card.sconnect .disconnected-icon{
    color: var(--danger);
}

.card.sconnect .update-icon{
    position: absolute;
    font-size: 1rem;
    top: 6px;
    right: 6px;
    cursor: pointer;
}
.sconnect .a_disable{
    cursor: no-drop !important;
    background: #bdc0c4 !important;
    color: #a2a2a2 !important;
}
.facebook-modal .modal-dialog-centered::before {
    height: auto !important;
}
.step-icon i{
    font-size: 23px;
    position: relative;
    top: 4px;
}
.social-steps.accordion .accordion-item{
    background: #fff;
}
.social-steps.accordion .accordion-header{
    background-color: transparent;
    box-shadow: none;
    position: relative;
    color: #3f729b;
}   
.underline-text{
    max-width: 150px;
    border-bottom: 2px solid #FAD8AB;
    margin: auto;
} 
.social-post-setps .accordion .accordion-header[aria-expanded="true"] .fa-angle-down:before {
    content: "\f106";
}
.steps-lineHeight p{
    line-height: 22px;
}

</style>

@endsection

@section('content')
<section>
    <div class="section">

        <div class="my-5 text-center">
            <h5>Connect Social Media Accounts</h5>
            <p>Here you can connect your social media Accounts / Pages / Groups / Profiles to directly auto-post your offer.</p>
        </div>

        <div>
            <div class="row justify-content-center">

                @php $columns = 'col-xl-2 col-md-4 col-sm-4 col-6 mb-4' @endphp
                @if($userSocialPlatform!=NULL)
                    
                    @foreach ($userSocialPlatform as $key => $platform)
                        @php
                            $platform_keyname = $platform->platform_key;
                            $platform_key = 'is_'.$platform_keyname.'_auth';
                            $platform_page_id = $platform_keyname."_page_id";
                            
                            $is_page_id = 0;
                            $pagePlatforms = ["facebook", "linkedin"];
                            if(in_array($platform_keyname, $pagePlatforms)){
                                $is_page_id = 1;
                            }
                        @endphp

                        <div class="{{$columns}}">
                            <div class="sconnect card">
                                @if($platform->status==1)

                                    @if($platform->platform_key == 'youtube' && $youtubeTasks > 0)
                                        <i class="fas fa-check-circle connected-icon"></i>
                                    @else
                                        @if($userSocialConnection->$platform_key) 
                                            <i class="fas fa-check-circle connected-icon"></i>
                                            @if($is_page_id)
                                                <i class="fas fa-pen update-icon text-primary" id="{{ $platform->page_popup_id }}" title="Update Page" ></i>
                                            @endif
                                        @endif
                                    @endif
                                    
                                @endif

                                <div class="card-body">
                                    <div class="sc-icon mb-2">
                                        {{-- <i class="{{ $platform->icon_class_name }}" style="color: {{ $platform->icon_color_code }};"></i> --}}
                                        {!! $platform->icon_class_name !!}
                                    </div>
                                    <h6>{{ $platform->name }}  </h6>
                                    <div class="text-secondary">{{ $platform->subname }}</div>
                                </div>

                                

                                @if($platform->status==1)
                                    @if($platform->platform_key == 'youtube')
                                         
                                        @if($youtubeTasks > 0) 
                                            <a class="connected text-decoration-none" data-socialAccount="{{ $platform->social_account_name }}" href="javascript:void(0)" >
                                                <b>Connected</b>
                                            </a> 
                                        @else 
                                            <a class="new_connect text-decoration-none connect_to_youtube" data-socialAccount="{{ $platform->social_account_name }}" href="javascript:void(0)" >
                                                <b>Connect Now</b>
                                            </a>
                                        @endif 
                                            
                                    @else
                                        <a class="@if($userSocialConnection->$platform_key) connected @else new_connect @endif text-decoration-none @if($platform->platform_key != "google") connect-to-social-media @else showMsgPopup @endif " data-socialAccount="{{ $platform->social_account_name }}" href="javascript:void(0)" >
                                            <b> @if($userSocialConnection->$platform_key) Connected @else Connect Now @endif </b>
                                            <span id="loading_icon_{{ $platform->social_account_name }}" class="ms-2" style="display:none;">
                                                <i class="fa fa-spinner fa-2x fa-spin"></i>
                                            </span>
                                        </a>
                                    @endif
                        
                                    
                                @else
                                    <div class="new_connect a_disable" data-toggle="tooltip" data-placement="bottom" title="Coming soon..." >
                                        <b>Connect Now</b>
                                    </div>
                                @endif
                            </div>
                        </div>

                    @endforeach
                @else
                    <div class="col-12">
                        <div class="sconnect card">
                            <p>Social Platform not found!</p>
                        </div>
                    </div>
                @endif

            </div>
        </div>
        
    </div>
    <div class="container">
        <div class="py-5">
            {{-- social-post-steps --}}
            <div class="row justify-content-center">  
                <div class="col-xl-8 col-lg-10 col-12">
                    <div class="text-center mb-5">
                        <h4 class="font-800">Can't connect social media account?</h4>
                        <h6>Follow the steps below</h6>
                        <div class="underline-text"></div>
                    </div> 
                    <div class="social-post-setps">
                        {{-- How to switch from your personal to professional Instagram account --}}
                        <div class="accordion social-steps insta-switch" id="insta-switch-accordion">
                            <div class="accordion-item">
                              <div class="accordion-header" id="insta-switch-head" data-toggle="collapse" data-target="#insta-switch" aria-expanded="false" aria-controls="insta-switch">
                                   <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-inline-block mt-2 mt-md-0">
                                            <h6 class="mb-0">How to switch from your personal to professional Instagram account?</h6>
                                        </div>
                                        <div class="">
                                            <i class="fas fa-angle-down" style="font-size: 20px;"></i>
                                        </div>
                                   </div>
                                    
                              </div>
                          
                              <div id="insta-switch" class="collapse" aria-labelledby="insta-switch-head" data-parent="#insta-switch-accordion">
                                <div class="accordion-body steps-lineHeight insta-switch-steps mt-4">
                                    <div class="insta-switch-step1">
                                        <p><b>Step 1:</b> Go to your Profile and tap Menu in the top right-hand corner.Tap Settings.</p>
                                    </div>
                                    <div class="insta-switch-step2 mt-4">
                                        <p><b>Step 2:</b> For some accounts, the switch to Professional Account option will be listed directly under Settings.If not then tap on Account.</p>
                                    </div>
                                    <div class="insta-switch-step3 mt-4">
                                        <p><b>Step 3:</b> Tap on switch to Professional Account.</p>
                                    </div>
                                    <div class="insta-switch-step4 mt-4">
                                        <p><b>Step 4:</b> Tap on Continue.</p>
                                    </div>
                                    <div class="insta-switch-step5 mt-4">
                                        <p><b>Step 5:</b> Select a category for your business and tap Done.</p>
                                    </div>
                                    <div class="insta-switch-step6 mt-4">
                                        <p><b>Step 6:</b> Tap on OK to confirm.</p>
                                    </div>
                                    <div class="insta-switch-step7 mt-4">
                                        <p><b>Step 7:</b> Tap on Business.</p>
                                    </div>
                                    <div class="insta-switch-step8 mt-4">
                                        <p><b>Step 8:</b> Tap on Next.</p>
                                    </div>
                                    <div class="insta-switch-step9 mt-4">
                                        <p><b>Step 9:</b> Add contact details and tap Next. Or tap don't use my contact info to skip this step.</p>
                                    </div>
                                </div>
                              </div>
                            </div>
                        </div>
                        {{-- How to link your facebook account to Instagram account --}}
                        <div class="accordion social-steps fb-link-insta" id="fb-link-insta-accordion">
                            <div class="accordion-item">
                              <div class="accordion-header" id="fb-link-insta-head" data-toggle="collapse" data-target="#fb-link-insta" aria-expanded="false" aria-controls="fb-link-insta">
                                    <div class="d-flex justify-content-between align-items-center">    
                                        <div class="d-inline-block mt-2 mt-md-0">
                                            <h6 class="mb-0">How to link your Facebook account to Instagram account?</h6>
                                        </div>
                                        <div class="">
                                            <i class="fas fa-angle-down" style="font-size: 20px;"></i>
                                        </div>
                                    </div>        
                              </div>
                          
                              <div id="fb-link-insta" class="collapse" aria-labelledby="fb-link-insta-head" data-parent="#fb-link-insta-accordion">
                                <div class="accordion-body steps-lineHeight fb-link-insta-steps mt-4">
                                    <div class="fb-link-insta-step1">
                                        <h6>Through Instagram </h6>
                                        <hr>
                                        <p><b>Step 1:</b> Go to your profile and tap Menu.</p>
                                    </div>
                                    <div class="fb-link-insta-step2 mt-4">
                                        <p><b>Step 2:</b> Then tap on Settings</p>
                                    </div>
                                    <div class="fb-link-insta-step3 mt-4">
                                        <p><b>Step 3:</b> At the bottom, tap on Accounts Centre.</p>
                                    </div>
                                    <div class="fb-link-insta-step4 mt-4">
                                        <p><b>Step 4:</b> Tap Add Facebook Account or Add Instagram Account and follow the on-screen instructions.</p>
                                    </div>

                                    <div class="fb-link-insta-step1">
                                        <h6>Through Facebook </h6>
                                        <hr>
                                        <p><b>Step 1:</b> From the top right tap on Menu.</p>
                                    </div>
                                    <div class="fb-link-insta-step2 mt-4">
                                        <p><b>Step 2:</b> Then tap on Settings</p>
                                    </div>
                                    <div class="fb-link-insta-step3 mt-4">
                                        <p><b>Step 3:</b> At the bottom, tap on Accounts Centre.</p>
                                    </div>
                                    <div class="fb-link-insta-step4 mt-4">
                                        <p><b>Step 4:</b> Tap Add Instagram Account and follow the on-screen instructions.</p>
                                    </div>
                                </div>
                              </div>
                            </div>
                        </div>

                        {{--how to create facebook business page --}}
                        <div class="accordion social-steps facebook-business-page" id="facebook-business-accordion">
                            <div class="accordion-item">
                            <div class="accordion-header" id="facebookHeading-business" data-toggle="collapse" data-target="#facebook-business" aria-expanded="false" aria-controls="facebook">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-inline-block">
                                            <h6 class="mb-0">How to create facebook business page?</h6>
                                        </div>
                                        <div class="">
                                            <i class="fas fa-angle-down" style="font-size: 20px;"></i>
                                        </div>
                                    </div>    
                            </div>
                        
                            <div id="facebook-business" class="collapse" aria-labelledby="facebookHeading-business" data-parent="#facebook-business-accordion">
                                <div class="accordion-body steps-lineHeight steps-lineHeight fb-business-steps mt-4">
                                    <div class="fb-business-step1">
                                        <p><b>Step 1:</b> From your facebook account click on Pages.</p>
                                        <img src="{{ asset('assets/business/social-post-steps/facebook-business-page/business-facebook-step1.png') }}" class="w-100" alt="">
                                    </div>
                                    <div class="fb-business-step2 mt-4">
                                        <p><b>Step 2:</b> From the Pages section, click Create New Page.</p>
                                        <img src="{{ asset('assets/business/social-post-steps/facebook-business-page/business-facebook-step2.png') }}" class="w-100" alt="">
                                    </div>
                                    <div class="fb-business-step3 mt-4">
                                        <p><b>Step 3:</b> Add your Page name, category and page's bio and click on Create Page.</p>
                                        <img src="{{ asset('assets/business/social-post-steps/facebook-business-page/business-facebook-step3.png') }}" class="w-100" alt="">
                                    </div>
                                    <div class="fb-business-step4 mt-4">
                                        <p><b>Step 4:</b>  Add information, such as contact, location (its optional), and click on Next.</p>
                                        <img src="{{ asset('assets/business/social-post-steps/facebook-business-page/business-facebook-step4.png') }}" class="w-100" alt="">
                                    </div>
                                    <div class="fb-business-step5 mt-4">
                                        <p><b>Step 5:</b> Add profile and cover photos, edit the action button (its optional) and click Next.</p>
                                        <img src="{{ asset('assets/business/social-post-steps/facebook-business-page/business-facebook-step5.png') }}" class="w-100" alt="">
                                    </div>
                                    <div class="fb-business-step6 mt-4">
                                        <p><b>Step 6:</b> You can connect whatsapp to your page by adding whatsapp number and the click on get code and follow the instructions given by screen or you can Skip it just by clicking on Skip.</p>
                                        <img src="{{ asset('assets/business/social-post-steps/facebook-business-page/business-facebook-step6.png') }}" class="w-100" alt="">
                                    </div>
                                    <div class="fb-business-step7 mt-4">
                                        <p><b>Step 7:</b> Invite friends to connect with your Page (its optional), and click Next.</p>
                                        <img src="{{ asset('assets/business/social-post-steps/facebook-business-page/business-facebook-step7.png') }}" class="w-100" alt="">
                                    </div>
                                    <div class="fb-business-step8 mt-4">
                                        <p><b>Step 8:</b> Click Done.</p>
                                        <img src="{{ asset('assets/business/social-post-steps/facebook-business-page/business-facebook-step8.png') }}" class="w-100" alt="">
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        {{-- facebook --}}
                        <div class="accordion social-steps facebook" id="facebook-accordion">
                            <div class="accordion-item">
                              <div class="accordion-header" id="facebookHeading" data-toggle="collapse" data-target="#facebook" aria-expanded="false" aria-controls="facebook">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-inline-block">
                                            <h6 class="mb-0">Connect with Facebook</h6>
                                        </div>
                                        <div class="">
                                            <i class="fas fa-angle-down" style="font-size: 20px;"></i>
                                        </div>
                                    </div>    
                              </div>
                          
                              <div id="facebook" class="collapse" aria-labelledby="facebookHeading" data-parent="#facebook-accordion">
                                <div class="accordion-body steps-lineHeight steps-lineHeight fb-steps mt-4">
                                    <div class="fb-step1">
                                        <p><b>Step 1:</b> Click on the Connect Now from facebook card. It will redirect to  your facebook account.</p>
                                        <img src="{{ asset('assets/business/social-post-steps/facebook/socialpost-fb-step1.png') }}" class="w-100" alt="">
                                    </div>
                                    <div class="fb-step2 mt-4">
                                        <p><b>Step 2:</b> Facebook screen will appear, enter you facebook credentials and Sing in. Then click on Edit button.</p>
                                        <img src="{{ asset('assets/business/social-post-steps/facebook/socialpost-fb-step2.png') }}" class="w-100" alt="">
                                    </div>
                                    <div class="fb-step3 mt-4">
                                        <p><b>Step 3:</b> Select the Facebook Business Account you want to connect.</p>
                                        <img src="{{ asset('assets/business/social-post-steps/facebook/socialpost-fb-step3.png') }}" class="w-100" alt="">
                                    </div>
                                    <div class="fb-step4 mt-4">
                                        <p><b>Step 4:</b> Allow all manage permission by managemedias by enabling all the toggle buttons.</p>
                                        <img src="{{ asset('assets/business/social-post-steps/facebook/socialpost-fb-step4.png') }}" class="w-100" alt="">
                                    </div>
                                    <div class="fb-step5 mt-4">
                                        <p><b>Step 5:</b> The facebook page will redirect to your dashboard account. Select your facebook page and click on update page</p>
                                        <img src="{{ asset('assets/business/social-post-steps/facebook/socialpost-fb-step5.png') }}" class="w-100" alt="">
                                    </div>
                                    <div class="fb-step6 mt-4">
                                        <p><b>Step 6:</b> Make sure to check green tick and connected on Facebook card.</p>
                                        <img src="{{ asset('assets/business/social-post-steps/facebook/socialpost-fb-step6.png') }}" class="w-100" alt="">
                                    </div>
                                </div>
                              </div>
                            </div>
                        </div>
                        {{-- instagram --}}
                        <div class="accordion social-steps instagram" id="instagram-accordion">
                            <div class="accordion-item">
                              <div class="accordion-header" id="instagramHeading" data-toggle="collapse" data-target="#instagram" aria-expanded="false" aria-controls="instagram">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-inline-block">
                                            <h6 class="mb-0">Connect with Instagram</h6>
                                        </div>
                                        <div class="">
                                            <i class="fas fa-angle-down" style="font-size: 20px;"></i>
                                        </div>
                                    </div>    
                              </div>
                          
                              <div id="instagram" class="collapse" aria-labelledby="instagramHeading" data-parent="#instagram-accordion">
                                <div class="accordion-body steps-lineHeight insta-steps mt-4">
                                    <h6 class="text-warning">Note: To connect with instagram you have to first connect with facebook</h6>
                                    <div class="insta-step1">
                                        <p><b>Step 1:</b> Click on the Connect Now from instagram card. It will redirect to  your facebook account.</p>
                                        <img src="{{ asset('assets/business/social-post-steps/instagram/socialpost-insta-step1.png') }}" class="w-100" alt="">
                                    </div>
                                    <div class="insta-step2 mt-4">
                                        <p><b>Step 2:</b> Authenticate it by clicking on Continue button.</p>
                                        <img src="{{ asset('assets/business/social-post-steps/instagram/socialpost-insta-step2.png') }}" class="w-100" alt="">
                                    </div>
                                    <div class="insta-step3 mt-4">
                                        <p><b>Step 3:</b> Select the Instagram Business Account you want to connect.</p>
                                        <img src="{{ asset('assets/business/social-post-steps/instagram/socialpost-insta-step3.png') }}" class="w-100" alt="">
                                    </div>
                                    <div class="insta-step4 mt-4">
                                        <p><b>Step 4:</b> Proceed to next screen by clicking on Next button.</p>
                                        <img src="{{ asset('assets/business/social-post-steps/instagram/socialpost-insta-step4.png') }}" class="w-100" alt="">
                                    </div>
                                    <div class="insta-step5 mt-4">
                                        <p><b>Step 5:</b> Allow all manage permission by managemedias by enabling all the toggle buttons.</p>
                                        <img src="{{ asset('assets/business/social-post-steps/instagram/socialpost-insta-step5.png') }}" class="w-100" alt="">
                                    </div>
                                    <div class="insta-step6 mt-4">
                                        <p><b>Step 6:</b> Click on Ok</p>
                                        <img src="{{ asset('assets/business/social-post-steps/instagram/socialpost-insta-step6.png') }}" class="w-100" alt="">
                                    </div>
                                    <div class="insta-step7 mt-4">
                                        <p><b>Step 7:</b> The facebook page will redirect to your dashboard account and make sure to check green tick and connected on instagram card.</p>
                                        <img src="{{ asset('assets/business/social-post-steps/instagram/socialpost-insta-step7.png') }}" class="w-100" alt="">
                                    </div>
                                </div>
                              </div>
                            </div>
                        </div>
                        {{-- twitter --}}
                        <div class="accordion social-steps twitter" id="twitter-accordion">
                            <div class="accordion-item">
                              <div class="accordion-header" id="twitterHeading" data-toggle="collapse" data-target="#twitter" aria-expanded="false" aria-controls="twitter">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-inline-block">
                                            <h6 class="mb-0">Connect with Twitter</h6>
                                        </div>
                                        <div class="">
                                            <i class="fas fa-angle-down" style="font-size: 20px;"></i>
                                        </div>
                                    </div>
                              </div>
                          
                              <div id="twitter" class="collapse" aria-labelledby="twitterHeading" data-parent="#twitter-accordion">
                                <div class="accordion-body steps-lineHeight twitter-steps mt-4">
                                    <div class="twitter-step1">
                                        <p><b>Step 1:</b> Click on the Connect Now from Twitter card. It will redirect to  your Twitter sign in page.</p>
                                        <img src="{{ asset('assets/business/social-post-steps/twitter/socialpost-twitter-step1.png') }}" class="w-100" alt="">
                                    </div>
                                    <div class="twitter-step2 mt-4">
                                        <p><b>Step 2:</b> Authenticate it by clicking on Authorize App button.</p>
                                        <img src="{{ asset('assets/business/social-post-steps/twitter/socialpost-twitter-step2.png') }}" class="w-100" alt="">
                                    </div>
                                    <div class="twitter-step3 mt-4">
                                        <p><b>Step 3:</b> The Twitter page will redirect to your dashboard account and make sure to check green tick and connected on Twitter card.</p>
                                        <img src="{{ asset('assets/business/social-post-steps/twitter/socialpost-twitter-step3.png') }}" class="w-100" alt="">
                                    </div>
                                </div>
                              </div>
                            </div>
                        </div>
                        {{-- linkedIn --}}
                        <!-- <div class="accordion social-steps linkedin" id="linkedin-accordion">
                            <div class="accordion-item">
                              <div class="accordion-header" id="linkedinHeading" data-toggle="collapse" data-target="#linkedin" aria-expanded="false" aria-controls="linkedin">
                                    <div class="d-flex justify-content-between align-items-center">    
                                        <div class="d-inline-block">
                                            <h6 class="mb-0">Connect with linkedIn</h6>
                                        </div>
                                        <div class="">
                                            <i class="fas fa-angle-down" style="font-size: 20px;"></i>
                                        </div>
                                    </div>    
                              </div>
                          
                              <div id="linkedin" class="collapse" aria-labelledby="linkedinHeading" data-parent="#linkedin-accordion">
                                <div class="accordion-body steps-lineHeight linkedin-steps mt-4">
                                    <div class="linkedin-step1">
                                        <p><b>Step 1:</b> Click on the Connect Now from LinkedIn card. It will redirect to your LinkedIn Account.</p>
                                        <img src="{{ asset('assets/business/social-post-steps/linkedin/socialpost-linkedin-step1.png') }}" class="w-100" alt="">
                                    </div>
                                    <div class="linkedin-step2 mt-4">
                                        <p><b>Step 2:</b> Authenticate it by clicking on Allow button.</p>
                                        <img src="{{ asset('assets/business/social-post-steps/linkedin/socialpost-linkedin-step2.png') }}" class="w-100" alt="">
                                    </div>
                                    <div class="linkedin-step3 mt-4">
                                        <p><b>Step 3:</b> The LinkedIn page will redirect to your dashboard account. It will ask you about your LinkedIn Page Id.</p>
                                    </div>
                                    <div class="linkedin-step4 mt-4">
                                        <p><b>Step 4:</b> For LinkedIn Page Id, From your linkedin account go to your business page and copy the Id present in URL.</p>
                                        <img src="{{ asset('assets/business/social-post-steps/linkedin/socialpost-linkedin-step3.png') }}" class="w-100" alt="">
                                    </div>
                                    <div class="linkedin-step5 mt-4">
                                        <p><b>Step 5:</b> Paste the LinkedIn Page Id on dashboard and click on update page.</p>
                                        <img src="{{ asset('assets/business/social-post-steps/linkedin/socialpost-linkedin-step4.png') }}" class="w-100" alt="">
                                    </div>
                                    <div class="linkedin-step6 mt-4">
                                        <p><b>Step 6:</b> Make sure to check green tick and connected on LinkedIn card</p>
                                        <img src="{{ asset('assets/business/social-post-steps/linkedin/socialpost-linkedin-step5.png') }}" class="w-100" alt="">
                                    </div>
                                </div>
                              </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>    
    
</section>


{{-- modal of Add users  start --}}
<div class="modal fade" id="modalConnectSocialMedia" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Connecting...</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body " style="word-break:break-all" id="authConnectSocialMedia">
                
            </div>
        </div>
    </div>
</div>
{{-- modal of Add users end --}}

{{-- modal of Facebook Pages start --}}
<form method="POST" action="{{ route('business.save-facebook-page') }}" id="facebookPagesForm">
    <div class="modal ol-modal popin" id="modalFacebookPages" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="facebookPagesLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary">Facebook Pages</h5>
                    {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> --}}
                </div>
                <div class="modal-body" id="facebookPages">
                    
                </div>
                <div class="modal-footer justify-content-start pt-0 m-0">
                    <button type="submit" class="btn btn-success mr-2 mb-2 updateFbModalBtns" >Update Page</button>

                    <a class="@if($userSocialConnection->is_facebook_auth) connected @else new_connect @endif text-decoration-none connect-to-social-media btn btn-primary m-0 mb-1 updateFbModalBtns"  data-socialAccount="facebook" href="javascript:void(0)" >
                        Add New Pages
                        <span  id="loading_icon_facebook" class="ms-2" style="display:none;">
                            <i class="fa fa-spinner fa-2x fa-spin"></i>
                        </span>
                    </a>

                    <a href="javascript:void(0)" data-dismiss="modal" class="btn btn-danger closeFbModalBtns">Close</a>
                </div>
            </div>
        </div>
    </div>
</form>
{{-- modal of Facebook Pages end --}}


{{-- modal of LinkedIn Pages start --}}
<form method="POST" action="{{ route('business.save-linkedin-page') }}" id="linkedinPagesForm">
    <div class="modal ol-modal popin" id="modalLinkedInPages" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="facebookPagesLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary">LinkedIn Page</h5>
                    {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> --}}
                </div>
                <div class="modal-body" id="linkedinPages">
                    <div class="form-group mb-0">

                        <div class="d-flex justify-content-between">
                            <label for="" class="text-primary">LinkedIn Page Id</label>
                            <a href="#" class="info-btn" data-toggle="modal" data-target="#linkedin_pageid_modal" data-backdrop="static" data-keyboard="false"><i class="fa fa-info-circle"></i></a>
                        </div>

                        @php
                            $linkedInPageId="";
                            if($userSocialConnection!=NULL){
                                $linkedInPageId = $userSocialConnection->linkedin_page_id ?? '';
                                $linkedInPageId = $linkedInPageId != 0 ? $linkedInPageId : '';
                            }
                        @endphp

                        <input type="text" name="linkedin_page_id" id="linkedin_page_id" class="form-control" placeholder="Enter the linkedin page id" value="{{ $linkedInPageId }}">
                        <p class='error' id='error_linkedin_page' ></p>

                    </div>
                </div>
                <div class="modal-footer justify-content-start pt-0">
                    <button type="submit" class="btn btn-success" >Update Page</button>
                </div>
            </div>
        </div>
    </div>
</form>
{{-- modal of Facebook Pages end --}}


@endsection

@section('end_body')
    @include('business.settings.social-connections.social-connect-js')
    @include('business.settings.social-connections.social-media-modals')

    <script>
        $(document).on("click", ".connect_to_youtube", function(){
            sessionStorage.setItem('connect_to', 'youtube');
            window.location.href = '{{ route('business.channel.instantRewards.modifyTasks') }}';
        });
    </script>
@endsection

