@extends('layouts.business')
@section('title', 'Edit Offer: Business')
@section('end_head')<style>label span{color:red;}</style>@endsection
@section('head') @include('layouts.partials.headersection',['title'=>'Edit Instant Offer']) @endsection
@section('content')


<style>
    .accordion .accordion-header{
        padding: 12px 15px;
    }
    .accordion .accordion-header.collapsed .fa-chevron-up{
        opacity: .6;
    }
    .accordion .accordion-header.collapsed .fa-chevron-up::before{
        content: "\f078"!important;
    }
    .image-note{
        font-style: italic;
        color: red;
    }
    .draft_btn {
        background: transparent;
        border: none;
        color: #6777ef;
    }
    .fa-google:before{
        border: 1px solid;
        border-radius: 10px;
        padding: 3px;
    }
</style>
<style>
    #overlay{   
      position: fixed;
      top: 0;
      z-index: 9999;
      width: 100%;
      height:100%;
      display: none;
      background: rgba(0,0,0,0.6);
    }
    .cv-spinner {
      height: 100%;
      display: flex;
      justify-content: center;
      align-items: center;  
    }
    .spinner {
      width: 40px;
      height: 40px;
      border: 4px #ddd solid;
      border-top: 4px #2e93e6 solid;
      border-radius: 50%;
      animation: sp-anime 0.8s infinite linear;
    }
    @keyframes sp-anime {
      100% { 
        transform: rotate(360deg); 
      }
    }
    .is-hide{
      display:none;
    }
    .action_btn{
        padding: 0.5rem 0.8rem;
        font-size: 14px;
    }
    .discription_modal p{
        line-height: 22px;
    }
    .Steps {
        width: 12%;
        line-height: 22px;
    }
    .remove-business-logo{
        position: absolute;
        top: 0;
        right: 0rem;
        cursor: pointer;
        border: 2px solid #d21313;
        border-radius: 50%;
        background: #d21313;
        width: 17px;
        height: 17px;
        padding: .96px;
        color: #fff;
        text-align: center;
    }
</style>
{{-- Image Crop CSS --}}
<style type="text/css">
    .image-crop-modal .docs-tooltip{
        color: #ffffff;
    }
    .image-crop-modal .preview {
      overflow: hidden;
      width: 160px; 
      height: 160px;
      margin: 10px;
      border: 1px solid red;
    }
    .image-crop-modal .modal-lg{
      max-width: 1000px !important;
    }
    .image-crop-modal .ratio-btn{
      margin-bottom: 0px !important;
    }
    .image-crop-modal .container {
      margin: 20px auto;
      max-width: 640px;
    }
    .image-crop-modal img {
      width: 100%;
    }

</style>
<section class="section">

    <div class="section-body">

        <form  id="instantform" action="{{ route('business.instant.update', $offer->id) }}" method="post" enctype="multipart/form-data">

            @csrf
        <div class="row justify-content-center my-5">
            <div class="col-md-7 col-xl-6">

                <!-- SECTION One (OFFER) -->
                <div class="card" id="offer_details">
                    <div class="card-header">
                        <h4>Offer Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Offer Title <span>*</span></label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Enter title here..." value="{{old('title', $offer->title)}}" required>
                        </div>

                        <div class="form-row">
                            <div class="col-12">
                                <div class="form-group mb-0">
                                    <label>Offer Image</label>
                                    <div class="small mb-2">Please select <span class="text-danger">PNG</span>, <span class="text-danger">JPG</span> or <span class="text-danger">JPEG</span> image with maximum 2MB file size.</div>
                                    <input type="file" name="offer_image" id="image_offer" class="form-control img-preview-oi mb-1 cropImageClass" >
                                    <p class="mb-0 small"><i><span class=" text-danger">Note:</span> Image dimensions should be near to 640 x 380</i></p>

                                    <input type="hidden" name="imagestring" id="imagestring" value="" />
                                </div>
                            </div>
                            
                            <div class="col-4">
                                @if($offer->instant_offer->offer_banner != '')
                                <img id="preview_oi" style="max-height:120px;margin-bottom: 30px;" src="{{ asset('assets/offers/banners/'.$offer->instant_offer->offer_banner) }}" class="img-fluid" />
                                <i class="fa fa-times remove-business-logo" style="display:none" id="removeLogo" aria-hidden="true" data-toggle="tooltip" title="Remove Logo"></i>
                                @else
                                <img id="preview_oi" style="max-height:120px;margin-bottom: 30px;" src="" class="img-fluid" />
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Offer Description <span>*</span></label>
                            <textarea class="form-control" name="offer_description" rows="3" required>{{old('offer_description', $offer->instant_offer->offer_description)}}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Number of challenge to complete ( Optional )</label>
                            <input type="text" name="target" id="target" class="form-control" value="{{ old('target', $offer->instant_offer->target) }}" placeholder="Enter task count...">
                            <p class="mb-0 small"><i><span class=" text-danger">Note:</span> By default it will ask to complete any one task.</i></p>
                        </div>

                    </div>
                </div>
                <!-- SECTION TWO END -->

                <!-- SECTION THREE (COUPON) -->
                <div class="card">
                    <div class="card-header">
                        <h4>Discount Details</h4>
                    </div>
                    <div class="card-body">

                        <div class="row justify-content-between">
                            <div class="col-md-6 mb-3">
                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="radio" id="coupon_percentage" name="discount_type" value="Percentage" data-name="percentage" class="custom-control-input discount_type_input" @if($offer->instant_offer->discount_type == "Percentage") checked @endif> 
                                    <label class="custom-control-label" for="coupon_percentage"><b>Percent (%)</b> </label>
                                    <p class="small mb-0 mt-1" style="line-height:1.6;"><i>Set the percentage of discount you want to give to your customer on the specific offer.</i> </p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="radio" id="coupon_amount" name="discount_type" value="Fixed" data-name="amount" class="custom-control-input discount_type_input" @if($offer->instant_offer->discount_type == "Fixed") checked @endif>
                                    <label class="custom-control-label" for="coupon_amount"><b>Amount (&#8377;)</b></label>
                                    <p class="small mb-0 mt-1" style="line-height:1.6;"><i>Set the fixed amount in rupees, you want to give to your customer as an offer.</i> </p>
                                </div>
                            </div>
                        </div>

                        
                        <div class="form-group" id="coupon_percentage_input" @if($offer->instant_offer->discount_type != "Percentage") style="display:none" @endif>
                            <label for="">Discount in Percentage (%) <span>*</span> </label>
                            <input type="text" name="discount_percent" class="form-control" min="0" max="100" placeholder="Enter Percentage between 0 to 100%"  value="{{ old('discount_percent', $offer->instant_offer->discount_value) }}">
                        </div>
                        
                        <div class="form-group" id="coupon_amount_input" @if($offer->instant_offer->discount_type != "Fixed") style="display:none" @endif>
                            <label for="">Discount in Amount (&#8377;) <span>*</span></label>
                            <input type="text" name="discount_amount" class="form-control" min="0" placeholder="Enter Amount from 0"  value="{{ old('discount_amount', $offer->instant_offer->discount_value) }}">
                        </div>
                        
                    </div>
                </div>
                <!-- SECTION THREE END -->

               

            </div>

            {{-- Column right --}}
            <div class="col-md-5 col-xl-6">
                
                <!-- Entries Section -->
                {{-- Facebook  --}}
                <div class="card" id="FACEBOOK">
                    <div class="card-header">
                        <h4><i class="fab fa-facebook"></i> Facebook</h4>
                    </div>
                    <div class="card-body">

                        <div class="accordion">
                            <div class="accordion-header collapsed accordion_fb_page_url" role="button" data-toggle="collapse" data-target="#fb2" aria-expanded="false">
                              <h4>Follow Our Page On Facebook <span class="float-right"><i class="fa fa-chevron-up"></i></span></h4>
                            </div>
                            <div class="accordion-body collapse p-0" id="fb2">
                              <div>
                                  <div class="border p-3">
                                    <div class="form-row align-items-center">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="d-flex justify-content-between">
                                                   <label for="">Enter Facebook Page ID <span>*</span> </label> 
                                                   <a href="#" class="info-btn" data-toggle="modal" data-target="#facebook_details_modal"><i class="fa fa-question-circle"></i></a>
                                                </div>
                                                <input type="text" name="fb_page_url" class="form-control" @if(isset($tasks['fb_page_url'])) value="{{ $tasks['fb_page_url'] }}" @endif placeholder="112977887546093" >
                                            </div>
                                        </div>
      
                                    </div>
                                  </div>
                              </div>
                            </div>
                        </div>

                        {{-- ============ --}}

                        <div class="accordion">
                            <div class="accordion-header collapsed accordion_fb_post_url" role="button" data-toggle="collapse" data-target="#fb3" aria-expanded="false">
                              <h4>Like Our Post on Facebook <span class="float-right"><i class="fa fa-chevron-up"></i></span></h4>
                            </div>
                            <div class="accordion-body collapse p-0" id="fb3">
                              <div>
                                  <div class="border p-3">
                                    <div class="form-row align-items-center">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="d-flex justify-content-between">
                                                    <label for="">Facebook Post URL <span>*</span> </label>
                                                    <a href="#" class="info-btn" data-toggle="modal" data-target="#facebook_post_details_modal"><i class="fa fa-question-circle"></i></a>
                                                </div>
                                                
                                                <input type="url" name="fb_post_url" class="form-control" @if(isset($tasks['fb_post_url'])) value="{{ $tasks['fb_post_url'] }}" @endif placeholder="https://www.facebook.com/url-of-the-post" >
                                            </div>
                                        </div>

                                    </div>
                                  </div>
                              </div>
                            </div>
                        </div>


                    </div>
                </div>
                <!-- Facebook END -->

                {{-- Instagram  --}}
                <div class="card" id="INSTAGRAM">
                    <div class="card-header">
                        <h4><i class="fab fa-instagram"></i> Instagram</h4>
                    </div>
                    <div class="card-body">

                        <div class="accordion">
                            <div class="accordion-header collapsed accordion_insta_profile_url" role="button" data-toggle="collapse" data-target="#ig2" aria-expanded="false">
                              <h4>Follow Us on Instagram <span class="float-right"><i class="fa fa-chevron-up"></i></span></h4>
                            </div>
                            <div class="accordion-body collapse p-0" id="ig2">
                              <div>
                                  <div class="border p-3">
                                    <div class="form-row align-items-center">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="d-flex justify-content-between">
                                                    <label for="">URL <span>*</span> </label>
                                                    <a href="#" class="info-btn" data-toggle="modal" data-target="#instagram_details_modal"><i class="fa fa-question-circle"></i></a>
                                                </div>
                                               
                                                <input type="url" name="insta_profile_url" class="form-control" @if(isset($tasks['insta_profile_url'])) value="{{ $tasks['insta_profile_url'] }}" @endif placeholder="https://www.instagram.com/url-of-profile" >
                                            </div>
                                        </div>
       
                                    </div>
                                  </div>
                              </div>
                            </div>
                        </div>

                        {{-- ============ --}}

                        <div class="accordion">
                            <div class="accordion-header collapsed accordion_insta_post_url" role="button" data-toggle="collapse" data-target="#ig3" aria-expanded="false">
                              <h4>Like Our Instagram Post <span class="float-right"><i class="fa fa-chevron-up"></i></span></h4>
                            </div>
                            <div class="accordion-body collapse p-0" id="ig3">
                              <div>
                                  <div class="border p-3">
                                    <div class="form-row align-items-center mb-3">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="d-flex justify-content-between"> 
                                                    <label for="">Instagram Post URL <span>*</span> </label>
                                                    <a href="#" class="info-btn" data-toggle="modal" data-target="#instagram_post_details_modal"><i class="fa fa-question-circle"></i></a>   
                                                </div>
                                                
                                                <input type="url" name="insta_post_url" class="form-control" @if(isset($tasks['insta_post_url'])) value="{{ $tasks['insta_post_url'] }}" @endif placeholder="https://www.instagram.com/url-of-the-post" >
                                            </div>
                                        </div>
 
                                    </div>
                                    <p class="mb-0 small"><i><span class=" text-danger">Note:</span> Photos or Videos must be public for this action type</i></p>
                                  </div>
                              </div>
                            </div>
                        </div>


                    </div>
                </div>
                {{-- Instagram End  --}}

                {{-- Twitter  --}}
                <div class="card" id="TWITTER">
                    <div class="card-header">
                        <h4><i class="fab fa-twitter"></i> Twitter</h4>
                    </div>
                    <div class="card-body">

                        <div class="accordion">
                            <div class="accordion-header collapsed accordion_tw_username" role="button" data-toggle="collapse" data-target="#tw4" aria-expanded="false">
                              <h4>Follow On Twitter <span class="float-right"><i class="fa fa-chevron-up"></i></span></h4>
                            </div>
                            <div class="accordion-body collapse p-0" id="tw4">
                              <div>
                                  <div class="border p-3">
                                    <div class="form-row align-items-center mb-3">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="d-flex justify-content-between">
                                                    <label for="">Username <span>*</span> </label>
                                                    <a href="#" class="info-btn" data-toggle="modal" data-target="#twitter_details_modal"><i class="fa fa-question-circle"></i></a>     
                                                </div>
                                                  
                                                <div class="input-group">
                                                    <div class="input-group-prepend bg-light">
                                                        <span class="input-group-text">@</span>
                                                    </div>
                                                    <input type="text" name="tw_username" class="form-control" @if(isset($tasks['tw_username'])) value="{{ $tasks['tw_username'] }}" @endif placeholder="" >
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <p class="mb-0 small"><i><span class=" text-danger">Note:</span> Photos or Videos must be public for this action type</i></p>
                                  </div>
                              </div>
                            </div>
                        </div>

                        <div class="accordion">
                            <div class="accordion-header collapsed accordion_tw_tweet_like" role="button" data-toggle="collapse" data-target="#tw5" aria-expanded="false">
                              <h4>Like Our Tweet <span class="float-right"><i class="fa fa-chevron-up"></i></span></h4>
                            </div>
                            <div class="accordion-body collapse p-0" id="tw5">
                              <div>
                                  <div class="border p-3">
                                    <div class="form-row align-items-center mb-3">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="d-flex justify-content-between">
                                                    <label for="">Tweet URL <span>*</span> </label>
                                                    <a href="#" class="info-btn" data-toggle="modal" data-target="#tweet_details_modal"><i class="fa fa-question-circle"></i></a>    
                                                </div>
                                                <input type="url" name="tw_tweet_like" class="form-control" @if(isset($tasks['tw_tweet_like'])) value="{{ $tasks['tw_tweet_like'] }}" @endif placeholder="https://twitter.com/openChallenge/status/1468094073454006..." >
                                            </div>
                                        </div>
      
                                    </div>
                                    <p class="mb-0 small"><i><span class=" text-danger">Note:</span> Photos or Videos must be public for this action type</i></p>
                                  </div>
                              </div>
                            </div>
                        </div>

                    </div>
                </div>
                {{-- Twitter --}}

                {{-- Linkedin --}}
                <div class="card" id="LINKEDIN">
                    <div class="card-header">
                        <h4><i class="fab fa-linkedin"></i> Linkedin</h4>
                    </div>
                    <div class="card-body">

                        <div class="accordion">
                            <div class="accordion-header collapsed accordion_li_company_url" role="button" data-toggle="collapse" data-target="#li1" aria-expanded="false">
                              <h4>Follow Company on Linkedin <span class="float-right"><i class="fa fa-chevron-up"></i></span></h4>
                            </div>
                            <div class="accordion-body collapse p-0" id="li1">
                              <div>
                                  <div class="border p-3">
                                    <div class="form-row align-items-center mb-3">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="d-flex justify-content-between">
                                                    <label for="">Company URL <span>*</span> </label>
                                                    <a href="#" class="info-btn" data-toggle="modal" data-target="#linkedin_details_modal"><i class="fa fa-question-circle"></i></a>    
                                                </div>
                                                
                                                <input type="url" name="li_company_url" class="form-control" @if(isset($tasks['li_company_url'])) value="{{ $tasks['li_company_url'] }}" @endif placeholder="https://www.linkedin.com/company/hsft873jhsg" >
                                            </div>
                                        </div>

                                    </div>
                                    
                                  </div>
                              </div>
                            </div>
                        </div>

                    </div>
                </div>
                {{-- Youtube End  --}}

                {{-- Youtube --}}
                <div class="card" id="YOUTUBE">
                    <div class="card-header">
                        <h4><i class="fab fa-youtube"></i> Youtube</h4>
                    </div>
                    <div class="card-body">

                        <div class="accordion">
                            <div class="accordion-header collapsed accordion_yt_channel_url" role="button" data-toggle="collapse" data-target="#yt1" aria-expanded="false">
                              <h4>Subscribe To Our Youtube Channel <span class="float-right"><i class="fa fa-chevron-up"></i></span></h4>
                            </div>
                            <div class="accordion-body collapse p-0" id="yt1">
                              <div>
                                  <div class="border p-3">
                                    <div class="form-row align-items-center mb-3">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="d-flex justify-content-between">
                                                    <label for="">Channel URL <span>*</span> </label>
                                                    <a href="#" class="info-btn" data-toggle="modal" data-target="#youtube_details_modal"><i class="fa fa-question-circle"></i></a>    
                                                </div>
                                                
                                                <input type="url" name="yt_channel_url" class="form-control" @if(isset($tasks['yt_channel_url'])) value="{{ $tasks['yt_channel_url'] }}" @endif placeholder="https://www.youtube.com/channel/hsft873jhsg" >
                                            </div>
                                        </div>

                                    </div>
                                    <p class="mb-0 small"><i><span class=" text-danger">Note:</span> Use either a user or channel url</i></p>
                                  </div>
                              </div>
                            </div>
                        </div>

                        <div class="accordion">
                            <div class="accordion-header collapsed accordion_yt_comment_url" role="button" data-toggle="collapse" data-target="#yt2" aria-expanded="false">
                              <h4>Comment On Our Youtube Video <span class="float-right"><i class="fa fa-chevron-up"></i></span></h4>
                            </div>
                            <div class="accordion-body collapse p-0" id="yt2">
                              <div>
                                  <div class="border p-3">
                                    <div class="form-row align-items-center mb-3">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="d-flex justify-content-between">
                                                    <label for="">Video URL <span>*</span> </label>
                                                    <a href="#" class="info-btn" data-toggle="modal" data-target="#youtube_video_details_modal"><i class="fa fa-question-circle"></i></a>
                                                </div>
                                                 
                                                <input type="url" name="yt_comment_url" class="form-control" @if(isset($tasks['yt_comment_url'])) value="{{ $tasks['yt_comment_url'] }}" @endif placeholder="https://www.youtube.com/watch?v=ZRhwHEoX...." >
                                            </div>
                                        </div>

                                    </div>
                                    <p class="mb-0 small"><i><span class=" text-danger">Note:</span> Use either a user or channel url</i></p>
                                  </div>
                              </div>
                            </div>
                        </div>

                        <div class="accordion">
                            <div class="accordion-header collapsed accordion_yt_like_url" role="button" data-toggle="collapse" data-target="#yt3" aria-expanded="false">
                              <h4>Like To Our Youtube Video <span class="float-right"><i class="fa fa-chevron-up"></i></span></h4>
                            </div>
                            <div class="accordion-body collapse p-0" id="yt3">
                              <div>
                                  <div class="border p-3">
                                    <div class="form-row align-items-center mb-3">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="d-flex justify-content-between">
                                                    <label for="">Video URL <span>*</span> </label>
                                                    <a href="#" class="info-btn" data-toggle="modal" data-target="#youtube_videolike_details_modal"><i class="fa fa-question-circle"></i></a>    
                                                </div>
                                                
                                                <input type="url" name="yt_like_url" class="form-control" @if(isset($tasks['yt_like_url'])) value="{{ $tasks['yt_like_url'] }}" @endif placeholder="https://www.youtube.com/watch?v=ZRhwHEoX..." >
                                            </div>
                                        </div>

                                    </div>
                                    <p class="mb-0 small"><i><span class=" text-danger">Note:</span> Use either a user or channel url</i></p>
                                  </div>
                              </div>
                            </div>
                        </div>

                    </div>
                </div>
                {{-- Youtube End  --}}

                {{-- Google review --}}
                <div class="card" id="WEBPAGE">
                    <div class="card-header">
                        <h4><i class="fab fa-google"></i> Google</h4>
                    </div>
                    <div class="card-body">
                        
                        <div class="accordion">
                            <div class="accordion-header collapsed accordion_google_link" role="button" data-toggle="collapse" data-target="#go2" aria-expanded="false">
                              <h4>Review Us On Google <span class="float-right"><i class="fa fa-chevron-up"></i></span></h4>
                            </div>
                            <div class="accordion-body collapse p-0" id="go2">
                              <div>
                                  <div class="border p-3">
                                    <div class="form-row align-items-center mb-3">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="d-flex justify-content-between">
                                                    <label for="">Google URL <span>*</span> </label>
                                                    <a href="#" class="info-btn" data-toggle="modal" data-target="#google_details_modal"><i class="fa fa-question-circle"></i></a>    
                                                </div>
                                                
                                                <input type="url" name="google_link" class="form-control" @if(isset($tasks['google_link'])) value="{{ $tasks['google_link'] }}" @endif placeholder="https://www.google.com/search?q=..." >
                                            </div>
                                        </div>

                                    </div>
                                  </div>
                              </div>
                            </div>
                        </div>

                    </div>
                </div>
                {{-- Google review End  --}}


                {{-- Visit Site --}}
                <div class="card" id="WEBPAGE">
                    <div class="card-header">
                        <h4><i class="fa fa-link"></i> Visit A Page</h4>
                    </div>
                    <div class="card-body">
                        
                        <div class="accordion">
                            <div class="accordion-header collapsed accordion_visit_page_url" role="button" data-toggle="collapse" data-target="#vp1" aria-expanded="false">
                              <h4>Visit A Page <span class="float-right"><i class="fa fa-chevron-up"></i></span></h4>
                            </div>
                            <div class="accordion-body collapse p-0" id="vp1">
                              <div>
                                  <div class="border p-3">
                                    <div class="form-row align-items-center">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Title <span>*</span> </label>
                                                <input type="text" name="visit_page_title" class="form-control" @if(isset($tasks['visit_page_title'])) value="{{ $tasks['visit_page_title'] }}" @endif  placeholder="e.g: Visit MouthPublicity Page" >
                                            </div>
                                        </div>
 
                                        <div class="col-md-12">
                                            <div class="form-group mb-0">
                                                <div class="d-flex justify-content-between"> 
                                                    <label for="">Page URL <span>*</span> </label>
                                                    <a href="#" class="info-btn" data-toggle="modal" data-target="#website_details_modal"><i class="fa fa-question-circle"></i></a>   
                                                </div>
                                                <input type="url" name="visit_page_url" class="form-control" @if(isset($tasks['visit_page_url'])) value="{{ $tasks['visit_page_url'] }}" @endif placeholder="https://www.example.com/" placeholder="" >
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                              </div>
                            </div>
                        </div>

                    </div>
                </div>
                {{-- Visit SIte End  --}}


            </div>

            <div class="col-md-8">
                <input type="hidden" name="is_draft" value="0" id="is_draft">
                <hr>
                <!-- SUBMIT  -->
                <div class="d-flex justify-content-between align-items-center">
                    @if($offer->status != 1)
                    <div>
                        <button type="submit" class="draft_btn" name="draft_btn" value="draft">
                            Save in Draft
                        </button>
                    </div>
                    @endif
                    <div>
                        <!-- SUBMIT BUTTON -->
                        <button type="submit" name="save_btn" value="save" class="btn btn-icon icon-left btn-success save_btn">
                            <i class="fas fa-check"></i>
                            Save & Publish
                        </button>
                    </div>
                </div>
            </div>
                
        </div>
 
        </form> <!-- Form Close -->
    </div>

</section>
{{-- modal discription for facebook --}}
<div class="modal fade discription_modal" id="facebook_details_modal" tabindex="-1" role="dialog" aria-labelledby="facebook_details_modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-primary">Facebook Page ID </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <p>A Facebook Page ID is the unique identifier of a Facebook Business Page. Integrate your Facebook page through your Facebook ID with MouthPublicity. Once the page integration is done, you can assign different tasks to your customers on this page. Integration makes easy tracking of all the activities taken by your users, and you can always analyse them on the MouthPublicity Dashboard.</p>
            <hr>
            <h5 class="text-capitalize text-primary mb-3">Steps to get Facebook page ID</h5>
            <div class="d-flex mb-2">
                <p class="mb-0 font-weight-bold Steps">Step 1: </p>
                <p class="mb-1 ml-2"> From News Feed, click Pages in the left-hand-side menu.</p>    
            </div>
            <div class="d-flex mb-2">
                <p class="mb-0 font-weight-bold Steps">Step 2:</p>
                <p class="mb-1 ml-2"> Click your Page name to go to your Page.</p>    
            </div>
            <div class="d-flex mb-2">
                <p class="mb-0 font-weight-bold Steps">Step 3:</p>
                <p class="mb-1 ml-2"> Click About at the top of your Page. If you can't see it, click More.</p>    
            </div>
            <div class="d-flex mb-2">
                <p class="mb-0 font-weight-bold Steps">Step 4:</p>
                <p class="mb-1 ml-2"> Scroll down to find your Page ID below MORE INFO.</p>     
            </div> 
            
          </div>
        </div>
    </div>
</div>
{{--modal discription for facebook post--}}
<div class="modal fade discription_modal" id="facebook_post_details_modal" tabindex="-1" role="dialog" aria-labelledby="facebook_post_details_modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-primary">Facebook Post URL </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Copy-paste the URL of the Facebook post on which you want to assign a task, i.e. post like, comment, or share with your customers. Once the URL is integrated with MouthPublicity, you can easily track each activity taken on the post by different customers.</p>
            <hr>
            <h5 class="text-capitalize text-primary mb-3">Steps to get Facebook post URL</h5>
            <div class="d-flex mb-2">
                <p class="mb-0 font-weight-bold Steps">Step 1: </p>
                <p class="mb-1 ml-2"> From Home Feed, click on your profile.</p>    
            </div>
            <div class="d-flex mb-2">
                <p class="mb-0 font-weight-bold Steps">Step 2:</p>
                <p class="mb-1 ml-2"> Click on posts.</p>    
            </div>
            <div class="d-flex mb-2">
                <p class="mb-0 font-weight-bold Steps">Step 3:</p>
                <p class="mb-1 ml-2"> Click on the post which URL you want.</p>    
            </div>
            <div class="d-flex mb-2">
                <p class="mb-0 font-weight-bold Steps">Step 4:</p>
                <p class="mb-1 ml-2"> Click on the date and time of the post.</p>    
            </div>
            <div class="d-flex mb-2">
                <p class="mb-0 font-weight-bold Steps">Step 5:</p>
                <p class="mb-1 ml-2"> Copy the URl present in searchbar.</p>     
            </div> 
            
          </div>
        </div>
    </div>
</div>
{{--modal discription for instagram page--}}
<div class="modal fade discription_modal" id="instagram_details_modal" tabindex="-1" role="dialog" aria-labelledby="instagram_details_modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-primary">Instagram Page URL </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Copy-paste the URL of your Instagram profile and get it integrated now with MouthPublicity. Once the integration is done, you can easily keep track of activities taken by your users and always analyse them on the MouthPublicity Dashboard.</p>
            <hr>
            <h5 class="text-capitalize text-primary mb-3">Steps to get Instagram Page URL</h5>
            <div class="d-flex mb-2">
                <p class="mb-0 font-weight-bold Steps">Step 1: </p>
                <p class="mb-1 ml-2"> From Home Feed, click on your profile.</p>    
            </div>
            <div class="d-flex mb-2">
                <p class="mb-0 font-weight-bold Steps">Step 2:</p>
                <p class="mb-1 ml-2"> Copy the URl present in searchbar.</p>    
            </div>
          </div>
        </div>
    </div>
</div>
{{--modal discription for instagram post--}}
<div class="modal fade discription_modal" id="instagram_post_details_modal" tabindex="-1" role="dialog" aria-labelledby="instagram_post_details_modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-primary">Instagram Post URL </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Copy and paste the URL of the Instagram post to which you want to assign a task, i.e. post like, comment, or share with your customers. Once the URL is integrated with MouthPublicity, you can easily track each activity taken on the post by different customers.</p>
            <hr>
            <h5 class="text-capitalize text-primary mb-3">Steps to get Instagram post URL</h5>
            <div class="d-flex mb-2">
                <p class="mb-0 font-weight-bold Steps">Step 1: </p>
                <p class="mb-1 ml-2"> From Home Feed, click on your profile.</p>    
            </div>
            <div class="d-flex mb-2">
                <p class="mb-0 font-weight-bold Steps">Step 2:</p>
                <p class="mb-1 ml-2"> Click on the post whose URL you want.</p>    
            </div>
            <div class="d-flex mb-2">
                <p class="mb-0 font-weight-bold Steps">Step 3:</p>
                <p class="mb-1 ml-2"> Copy the URL present in searchbar.</p>    
            </div>
          </div>
        </div>
    </div>
</div>
{{--modal discription for twitter handel--}}
<div class="modal fade discription_modal" id="twitter_details_modal" tabindex="-1" role="dialog" aria-labelledby="twitter_details_modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-primary">Twitter Username </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Copy and paste the URL of your Twitter profile and get it integrated now with MouthPublicity. Once the integration is done, you can easily keep track of activities taken by your users and always analyse them on the MouthPublicity Dashboard.</p>
            <hr>
            <h5 class="text-capitalize text-primary mb-3">Steps to get Twitter Username</h5>
            <div class="d-flex mb-2">
                <p class="mb-0 font-weight-bold Steps">Step 1: </p>
                <p class="mb-1 ml-2"> From Home Feed you will see your username at the bottom-left corner.</p>    
            </div>
          </div>
        </div>
    </div>
</div>
{{--modal discription for twitter tweet--}}
<div class="modal fade discription_modal" id="tweet_details_modal" tabindex="-1" role="dialog" aria-labelledby="tweet_details_modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-primary">Tweet URL </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Copy and paste the URL of the Twitter post on which you want to assign a task, i.e. post like, comment, or share with your customers. Once the URL is integrated with MouthPublicity, you can easily track each activity taken on the post by different customers. </p>
            <hr>
            <h5 class="text-capitalize text-primary mb-3">Steps to get tweet URL</h5>
            <div class="d-flex mb-2">
                <p class="mb-0 font-weight-bold Steps">Step 1: </p>
                <p class="mb-1 ml-2"> From Home Feed, click on tweet.</p>    
            </div>
             <div class="d-flex mb-2">
                <p class="mb-0 font-weight-bold Steps">Step 2:</p>
                <p class="mb-1 ml-2"> Click on the date and time of the tweet.</p>    
            </div>
            <div class="d-flex mb-2">
                <p class="mb-0 font-weight-bold Steps">Step 3:</p>
                <p class="mb-1 ml-2"> Copy the URl present in searchbar.</p>    
            </div>
          </div>
        </div>
    </div>
</div>
{{--modal discription for linkedin--}}
<div class="modal fade discription_modal" id="linkedin_details_modal" tabindex="-1" role="dialog" aria-labelledby="linkedin_details_modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-primary">Company URL </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Copy-paste the URL of your LinkedIn profile and get it integrated now with MouthPublicity. Once the integration is done, you can easily keep track of activities taken by your users and always analyse them on the MouthPublicity Dashboard.</p>
            <hr>
            <h5 class="text-capitalize text-primary mb-3">Steps to get Company URL</h5>
            <div class="d-flex mb-2">
                <p class="mb-0 font-weight-bold Steps">Step 1: </p>
                <p class="mb-1 ml-2"> From Home Feed, click on comapny profile.</p>    
            </div>
             <div class="d-flex mb-2">
                <p class="mb-0 font-weight-bold Steps">Step 2:</p>
                <p class="mb-1 ml-2"> Copy the URl present in searchbar.</p>    
            </div>
          </div>
        </div>
    </div>
</div>
{{--modal discription for youtube--}}
<div class="modal fade discription_modal" id="youtube_details_modal" tabindex="-1" role="dialog" aria-labelledby="youtube_details_modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-primary">Channel URL</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Copy and paste the URL of the Youtube channel that you want to assign as a task to your customers. Once the URL is integrated with MouthPublicity, you can easily track each activity taken on the post by different customers.</p>
            <hr>
            <h5 class="text-capitalize text-primary mb-3">Steps to get Youtube Channel URL</h5>
            <div class="d-flex mb-2">
                <p class="mb-0 font-weight-bold Steps">Step 1: </p>
                <p class="mb-1 ml-2"> At Home Feed, from the left Menu click on  Customization.</p>    
            </div>
            <div class="d-flex mb-2">
                <p class="mb-0 font-weight-bold Steps">Step 2:</p>
                <p class="mb-1 ml-2"> Click on Basic info.</p>    
            </div>
            <div class="d-flex mb-2">
                <p class="mb-0 font-weight-bold Steps">Step 3:</p>
                <p class="mb-1 ml-2"> Under Channel URL copy your Channel URL.</p>    
            </div>
          </div>
        </div>
    </div>
</div>
{{--modal discription for youtube video--}}
<div class="modal fade discription_modal" id="youtube_video_details_modal" tabindex="-1" role="dialog" aria-labelledby="youtube_video_details_modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-primary">Youtube video URL</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Copy and paste the URL of the YouTube video to which you want to assign a task, such as posting, liking, commenting, or sharing with your customers.Once the URL is integrated with MouthPublicity, you can easily track each activity taken on the post by different customers.</p>
            <hr>
            <h5 class="text-capitalize text-primary mb-3">Steps to get Youtube Video URL</h5>
            <div class="d-flex mb-2">
                <p class="mb-0 font-weight-bold Steps">Step 1: </p>
                <p class="mb-1 ml-2"> At Home Feed, click on the video whose URL you want.</p>    
            </div>
            <div class="d-flex mb-2">
                <p class="mb-0 font-weight-bold Steps">Step 2:</p>
                <p class="mb-1 ml-2"> Copy the URL present in searchbar.</p>    
            </div>
          </div>
        </div>
    </div>
</div>
{{--modal discription for youtube video like--}}
<div class="modal fade discription_modal" id="youtube_videolike_details_modal" tabindex="-1" role="dialog" aria-labelledby="youtube_videolike_details_modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-primary">Youtube video URL</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Copy and paste the URL of the YouTube video to which you want to assign a task, such as posting, liking, commenting, or sharing with your customers.Once the URL is integrated with MouthPublicity, you can easily track each activity taken on the post by different customers.</p>
            <hr>
            <h5 class="text-capitalize text-primary mb-3">Steps to get Youtube Video URL</h5>
            <div class="d-flex mb-2">
                <p class="mb-0 font-weight-bold Steps">Step 1: </p>
                <p class="mb-1 ml-2"> At Home Feed, click on the video whose URL you want.</p>    
            </div>
            <div class="d-flex mb-2">
                <p class="mb-0 font-weight-bold Steps">Step 2:</p>
                <p class="mb-1 ml-2"> Copy the URL present in searchbar.</p>    
            </div>
          </div>
        </div>
    </div>
</div>
{{--modal discription for google url--}}
<div class="modal fade discription_modal" id="google_details_modal" tabindex="-1" role="dialog" aria-labelledby="google_details_modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-primary">Google Page URL</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Copy-paste the URL of your Google business page and get it integrated now with MouthPublicity. Once the integration is done, you can easily keep track of activities taken by your users and always analyze them on the MouthPublicity Dashboard.</p>
            <hr>
            <h5 class="text-capitalize text-primary mb-3">Steps to get google URL</h5>
            <div class="d-flex mb-2">
                <p class="mb-0 font-weight-bold Steps">Step 1: </p>
                <p class="mb-1 ml-2"> At Home Feed, Click the Share review form button. </p>    
            </div>
            <div class="d-flex mb-2">
                <p class="mb-0 font-weight-bold Steps">Step 2:</p>
                <p class="mb-1 ml-2"> Copy the review link.</p>    
            </div>
          </div>
        </div>
    </div>
</div>
{{--modal discription for website url--}}
<div class="modal fade discription_modal" id="website_details_modal" tabindex="-1" role="dialog" aria-labelledby="website_details_modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-primary">Website URL</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Copy-paste the URL of your website and get it integrated now with MouthPublicity. Once the integration is done, you can easily keep track of activities taken by your users and always analyze them on the MouthPublicity Dashboard.</p>
            <hr>
            <h5 class="text-capitalize text-primary mb-3">Steps to get google URL</h5>
            <div class="d-flex mb-2">
                <p class="mb-0 font-weight-bold Steps">Step 1: </p>
                <p class="mb-1 ml-2"> At website home page, copy the URL present in searchbar.</p>    
            </div>
          </div>
        </div>
    </div>
</div>

{{-- Crop Image Modal --}}
<div class="modal ol-modal popin image-crop-modal" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalLabel">Crop Image Before Upload</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="img-container">
              <div class="row">
                  <div class="col-md-8 cjs_img_container">
                      <img id="cropImage" src="">
                  </div>
                  <div class="col-md-4">
                      <div class="preview"></div>


                    <div class="btn-group mb-2 ml-2">
                        <button type="button" class="btn btn-primary zoom-in" data-method="zoom" data-option="0.1" title="Zoom In">
                          <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="">
                            <span class="fa fa-search-plus"></span>
                          </span>
                        </button>
                        <button type="button" class="btn btn-primary zoom-out" data-method="zoom" data-option="-0.1" title="Zoom Out">
                          <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="">
                            <span class="fa fa-search-minus"></span>
                          </span>
                        </button>
                    </div>
        
                    <div class="btn-group d-flex flex-nowrap mb-2 ml-2" data-toggle="buttons">
                        <label class="btn btn-primary ratio-btn" input-ele="aspectRatio1">
                          <input type="radio" class="sr-only" id="aspectRatio1" name="aspectRatio" value="1.7777777777777777">
                          <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="">
                            16:9
                          </span>
                        </label>
                        <label class="btn btn-primary ratio-btn" input-ele="aspectRatio2">
                          <input type="radio" class="sr-only" id="aspectRatio2" name="aspectRatio" value="1.3333333333333333">
                          <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="">
                            4:3
                          </span>
                        </label>
                        <label class="btn btn-primary ratio-btn" input-ele="aspectRatio3">
                          <input type="radio" class="sr-only" id="aspectRatio3" name="aspectRatio" value="1">
                          <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="">
                            1:1
                          </span>
                        </label>
                        <label class="btn btn-primary ratio-btn" input-ele="aspectRatio4">
                          <input type="radio" class="sr-only" id="aspectRatio4" name="aspectRatio" value="0.6666666666666666">
                          <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="">
                            2:3
                          </span>
                        </label>
                        <label class="btn btn-primary ratio-btn active" input-ele="aspectRatio5">
                          <input type="radio" class="sr-only" id="aspectRatio5" name="aspectRatio" value="NaN">
                          <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="">
                            Free
                          </span>
                        </label>
                    </div>
        
                    <div class="btn-group mb-2 ml-2">
                        <button type="button" class="btn btn-primary ratate-anticlockwise" data-method="rotate" data-option="-45" title="Rotate Left">
                          <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="">
                            <span class="fa fa-undo-alt"></span>
                          </span>
                        </button>
                        <button type="button" class="btn btn-primary ratate-clockwise" data-method="rotate" data-option="45" title="Rotate Right">
                          <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="">
                            <span class="fa fa-redo-alt"></span>
                          </span>
                        </button>
                    </div>
        
                    <div class="btn-group mb-2 ml-2">
                        <button type="button" class="btn btn-primary flip-horizontal" data-method="scaleX" data-option="-1" title="Flip Horizontal">
                          <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="">
                            <span class="fa fa-arrows-alt-h"></span>
                          </span>
                        </button>
                        <button type="button" class="btn btn-primary flip-verticle" data-method="scaleY" data-option="-1" title="Flip Vertical">
                          <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="">
                            <span class="fa fa-arrows-alt-v"></span>
                          </span>
                        </button>
                    </div>

                    <div class="btn-group mb-2 ml-2">
                        <button type="button" class="btn btn-primary" id="cropReset">Reset</button>
                    
                        <button type="button" class="btn btn-primary"  id="cancelCrop">Cancel</button>

                        
                    </div>

                    <div class="mb-2 ml-2">
                        <button type="button" class="btn btn-success" id="crop">Crop</button>
                    </div>
        
                    
                  </div>
              </div>
          </div>
        </div>
          {{-- <div class="modal-footer">
            
          </div> --}}
      </div>
    </div>
</div>

@endsection
@section('end_body')
    @include('business.offers.instant.js')
    <script>
        $(document).ready(function() {
    
            // on the change of discount type (percent or Amount) [Coupon detail block]
            var $discount_type_input = $("input.discount_type_input");
            $discount_type_input.on("change", function() {
                // get the checked input data
                var $selected = $("input.discount_type_input:checked");
                if($selected.data("name") == "percentage"){
                    $("#coupon_amount_input").hide();
                    $("#coupon_percentage_input").show();
                    $("input[name='discount_amount']").val('');
    
                }else if($selected.data("name") == "amount"){
                    $("#coupon_percentage_input").hide();
                    $("#coupon_amount_input").show();
                    $("input[name='discount_percent']").val('');
                }
            });
            
            /* ============================================= */
            /* Input File image Preview */
            /* $("input.img-preview-oi").on("change", function() {
                if(this.files[0].size > 2097152){
                    $('#image_offer').val('');
                    Sweet('error','Image size must be smaller than 2MB or equal.');
                    return false;
                }

                var file = $(this).get(0).files[0];
                if(file){

                    var file_name = file.name;
                    var fileExt = file_name.split('.').pop();
                    var ext = fileExt.toLowerCase();
                    
                    if(ext != 'jpeg' && ext != 'png' && ext != 'jpg'){
                        $("input.img-preview-oi").val('');
                        $('.remove-business-logo').hide();
                        $("#preview_oi").removeAttr("src");
                        $("#preview_oi").attr("alt",'');
                        
                        Sweet('error','Image format is not supported. Please Upload jpg, jpeg or png image.');
                        return;
                    }

                    var reader = new FileReader();
                    reader.onload = function(e){

                        var image = new Image();
                        image.src = e.target.result;
                            
                        image.onload = function () {
                            var height = this.height;
                            var width = this.width;

                            if(width > 1000 || height > 1000){
                                $("input.img-preview-oi").val('');
                                $('.remove-business-logo').hide();
                                $("#preview_oi").removeAttr("src");
                                $("#preview_oi").attr("alt",'');

                                Sweet('error','Image Resolutions are too high.');
                                return false; 
                            }else{
                                $('.remove-business-logo').show();
                                $("#preview_oi").attr("src", reader.result);
                            }
                        }
                    }
                    reader.readAsDataURL(file);
                }else{
                    $("#preview_oi").removeAttr("src");
                }
            }) */
        })
    </script>
    <!-- <script type="text/javascript">
        $(function(){
            var dtToday = new Date();
            
            var month = dtToday.getMonth() + 1;
            var day = dtToday.getDate();
            var year = dtToday.getFullYear();
            if(month < 10)
                month = '0' + month.toString();
            if(day < 10)
                day = '0' + day.toString();
            
            var maxDate = year + '-' + month + '-' + day;
            $('#start_date').attr('min', maxDate);
            $('#end_date').attr('min', maxDate);
        });
    </script> -->
    <script>
        var fb_page_url = $("[name='fb_page_url']").val();
        if(fb_page_url != ''){
            $('.accordion_fb_page_url').trigger('click');
        }

        var fb_post_url = $("[name='fb_post_url']").val();
        if(fb_post_url != ''){
            $('.accordion_fb_post_url').trigger('click');
        }

        var insta_profile_url = $("[name='insta_profile_url']").val();
        if(insta_profile_url != ''){
            $('.accordion_insta_profile_url').trigger('click');
        }

        var insta_post_url = $("[name='insta_post_url']").val();
        if(insta_post_url != ''){
            $('.accordion_insta_post_url').trigger('click');
        }

        var tw_tweet_like = $("[name='tw_tweet_like']").val();
        if(tw_tweet_like != ''){
            $('.accordion_tw_tweet_like').trigger('click');
        }

        var tw_username = $("[name='tw_username']").val();
        if(tw_username != ''){
            $('.accordion_tw_username').trigger('click');
        }

        var li_company_url = $("[name='li_company_url']").val();
        if(li_company_url != ''){
            $('.accordion_li_company_url').trigger('click');
        }

        var yt_channel_url = $("[name='yt_channel_url']").val();
        if(yt_channel_url != ''){
            $('.accordion_yt_channel_url').trigger('click');
        }

        var yt_comment_url = $("[name='yt_comment_url']").val();
        if(yt_comment_url != ''){
            $('.accordion_yt_comment_url').trigger('click');
        }

        var yt_like_url = $("[name='yt_like_url']").val();
        if(yt_like_url != ''){
            $('.accordion_yt_like_url').trigger('click');
        }

        var google_link = $("[name='google_link']").val();
        if(google_link != ''){
            $('.accordion_google_link').trigger('click');
        }

        var visit_page_url = $("[name='visit_page_url']").val();
        if(visit_page_url != ''){
            $('.accordion_visit_page_url').trigger('click');
        }

    </script>


{{-- Image Crop Script --}}
<script>

    var $modal = $('#modal');
    var image = document.getElementById('cropImage');
    var cropper;
      
    $("body").on("change", ".cropImageClass", function(e){
        var files = e.target.files;
        
        if (files && files.length > 0) {
            var file_type = files[0].type;
            var fileExt = file_type.split('/');
            var ext = fileExt[1].toLowerCase();
            
            if(ext != 'jpeg' && ext != 'png' && ext != 'jpg'){
                $(this).val(''); 
                Sweet('error','Image format is not supported. Please Upload jpg, jpeg or png image.');
                return;
            }
        }

        var done = function (url) {
          image.src = url;
          $modal.modal('show');
        };
        var reader;
        var file;
        var url;
    
        if (files && files.length > 0) {
          file = files[0];
    
          if (URL) {
            done(URL.createObjectURL(file));
          } else if (FileReader) {
            reader = new FileReader();
            reader.onload = function (e) {
              done(reader.result);
            };
            reader.readAsDataURL(file);
          }
        }
    });
    
    $modal.on('shown.bs.modal', function () {
        cropper = new Cropper(image, {
            aspectRatio: NaN,
            preview: '.preview',
            dragMode: 'move',
            autoCropArea: 0.65,
            cropBoxMovable: true,
            toggleDragModeOnDblclick: false,
        });
    }).on('hidden.bs.modal', function () {
       cropper.destroy();
       cropper = null;
    });
    
    $("#crop").click(function(){
        canvas = cropper.getCroppedCanvas({
            width: 500,
            height: 500,
        });
    
        canvas.toBlob(function(blob) {
            url = URL.createObjectURL(blob);
            var reader = new FileReader();
            reader.readAsDataURL(blob); 
             
            reader.onloadend = function() { 
                var fullQuality = canvas.toDataURL('image/jpeg', 1.0);
               
                $("#preview_oi").attr("src", fullQuality);
                $("#imagestring").val(fullQuality);
                $('.remove-business-logo').show();
                $modal.modal('hide');
            
             }
        });
    })

    $("#cancelCrop").click(function(){
        $('.cropImageClass').val('');
        $modal.modal('hide');
    })
    
    //Change AspectRatio
    $(".ratio-btn").click(function(){
        var input = $(this).attr('input-ele');
        var ratio = $('#'+input).val();
        changeRatio(ratio);
    })
    
    function changeRatio(ratio) {
        cropper.setAspectRatio(Number(ratio))
    }
    
    //Rotate Image
    $(".ratate-anticlockwise").click(function(){
        cropper.rotate(-45)
    })
    
    $(".ratate-clockwise").click(function(){
        cropper.rotate(45)
    })
    
    //Flip image
    $(".flip-horizontal").click(function(){
        var attr = $(this).attr('data-option');
        cropper.scaleX(attr)
    
        if(attr == 1){
          $(this).attr('data-option', -1);
        }else{
          $(this).attr('data-option', 1);
        }
    })
    
    $(".flip-verticle").click(function(){
        var attr = $(this).attr('data-option');
        cropper.scaleY(attr)
    
        if(attr == 1){
          $(this).attr('data-option', -1);
        }else{
          $(this).attr('data-option', 1);
        }
    })
    
    //Zoom
    $(".zoom-in").click(function(){
        cropper.zoom(0.1)
    })
    
    $(".zoom-out").click(function(){
        cropper.zoom(-0.1)
    })
    
    //Reset
    $("#cropReset").click(function(){
        cropper.reset()
    })

    
</script>
<script>
    $(document).ready(function() {
        
        $("#removeLogo").click(function() {
            swal.fire({
                title: 'Are you sure?',
                text: 'Once deleted, you will not be able to recover this logo file!',
                type: 'question',
                icon: 'warning',
                animation: true,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes Delete',
                cancelButtonText: 'Cancel',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: true,
                focusConfirm: true
            })
            .then(function(data){
                /*console.log(data.value);*/
                if (data.value == true) {
                    $('#image_offer').val('');
                    $("#preview_oi").attr("src", '');
                    $("#imagestring").val('');
                    $('.remove-business-logo').hide();
                        
                } else {
                    
                }
            });
        });
    });
</script>
@endsection
