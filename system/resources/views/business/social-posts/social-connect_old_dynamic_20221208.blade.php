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
                            $is_page_id = $userSocialConnection->$platform_page_id ? 1 : 0;
                        @endphp

                        <div class="{{$columns}}">
                            <div class="sconnect card">
                                @if($userSocialConnection->$platform_key) 
                                    <i class="fas fa-check-circle connected-icon"></i>
                                    @if($is_page_id)
                                        <i class="fas fa-pen update-icon text-primary" id="{{ $platform->page_popup_id }}" title="Update Page" ></i>
                                    @endif
                                @endif

                                <div class="card-body">
                                    <div class="sc-icon mb-2">
                                        <i class="{{ $platform->icon_class_name }}" style="color: {{ $platform->icon_color_code }};"></i>
                                    </div>
                                    <h6>{{ $platform->name }}</h6>
                                    <div class="text-secondary">{{ $platform->subname }}</div>
                                </div>

                                @if($platform->status==1)
                                    <a class="@if($userSocialConnection->$platform_key) connected @else new_connect @endif text-decoration-none connect-to-social-media" data-socialAccount="{{ $platform->social_account_name }}" href="javascript:void(0)" >
                                        <b> @if($userSocialConnection->$platform_key) Connected @else Connect Now @endif </b>
                                        <span  id="loading_icon_{{ $platform->social_account_name }}" class="ms-2" style="display:none;">
                                            <i class="fa fa-spinner fa-2x fa-spin"></i>
                                        </span>
                                    </a>
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

                <div class="col-12">
                    <hr />
                </div>

                <div class="{{$columns}}">
                    <div class="sconnect card">
                        {{-- Place this below icon if Connected --}}
                        {{-- <i class="fas fa-check-circle connected-icon"></i> --}}
                        @if($userSocialConnection->is_facebook_auth) 
                            <i class="fas fa-check-circle connected-icon"></i>
                            <i class="fas fa-pen update-icon text-primary" id="updatePage" title="Update Page" ></i>
                            {{-- <i class="fas fa-edit" id="updatePage" title="Update Page" style="cursor: pointer; text-align: right; " ></i> --}}
                        @endif
                        <div class="card-body">
                            <div class="sc-icon mb-2">
                                <i class="fab fa-facebook" style="color: #4267B2;"></i>
                            </div>
                            <h6>Facebook</h6>
                            <div class="text-secondary">Page or Group</div>
                        </div>
                        <a class="@if($userSocialConnection->is_facebook_auth) connected @else new_connect @endif text-decoration-none connect-to-social-media"  data-socialAccount="facebook" href="javascript:void(0)" >
                            <b> @if($userSocialConnection->is_facebook_auth) Connected @else Connect Now @endif </b>
                            <span  id="loading_icon_facebook" class="ms-2" style="display:none;">
                                <i class="fa fa-spinner fa-2x fa-spin"></i>
                            </span>
                        </a>
                    </div>
                </div>

                <div class="{{$columns}}">
                    <div class="sconnect card">
                        @if($userSocialConnection->is_twitter_auth) 
                            <i class="fas fa-check-circle connected-icon"></i>
                        @endif

                        <div class="card-body">
                            <div class="sc-icon mb-2">
                                <i class="fab fa-twitter" style="color: #1DA1F2;"></i>
                            </div>
                            <h6>Twitter</h6>
                            <div class="text-secondary">Profile</div>
                        </div>
                        <a class="@if($userSocialConnection->is_twitter_auth) connected @else new_connect @endif text-decoration-none connect-to-social-media"  data-socialAccount="twitter" href="javascript:void(0)">
                            <b> @if($userSocialConnection->is_twitter_auth) Connected @else Connect Now @endif </b>
                            <span  id="loading_icon_twitter" class="ms-2" style="display:none;">
                                <i class="fa fa-spinner fa-2x fa-spin"></i>
                            </span>
                        </a>
                    </div>
                </div>

                <div class="{{$columns}}">
                    <div class="sconnect card">
                        {{-- Place this below icon if Disconnected or Expired --}}
                        {{-- <i class="fas fa-exclamation-circle disconnected-icon"></i> --}}
                        @if($userSocialConnection->is_linkedin_auth) 
                            <i class="fas fa-check-circle connected-icon"></i>
                            <i class="fas fa-pen update-icon text-primary" id="updatePageLinkedIn" title="Update Page" ></i>
                        @endif

                        <div class="card-body">
                            <div class="sc-icon mb-2">
                                <i class="fab fa-linkedin" style="color: #0A66C2;"></i>
                            </div>
                            <h6>LinkedIn</h6>
                            <div class="text-secondary">Profile</div>
                        </div>
                        <a class="@if($userSocialConnection->is_linkedin_auth) connected @else new_connect @endif text-decoration-none connect-to-social-media"  data-socialAccount="linkedIn" href="javascript:void(0)" >
                            <b>@if($userSocialConnection->is_linkedin_auth) Connected @else Connect Now @endif </b>
                            <span  id="loading_icon_linkedIn" class="ms-2" style="display:none;">
                                <i class="fa fa-spinner fa-2x fa-spin"></i>
                            </span>
                        </a>
                        {{-- <div class="re_connect">
                            <b>Reconnect</b>
                        </div> --}}
                    </div>
                </div>

                <div class="{{$columns}}">
                    <div class="sconnect card">
                        <div class="card-body">
                            <div class="sc-icon mb-2">
                                <i class="fab fa-instagram" style="color: #f00276;"></i>
                            </div>
                            <h6>Instagram</h6>
                            <div class="text-secondary">Business Account</div>
                        </div>
                        <div class="new_connect a_disable" data-toggle="tooltip" data-placement="bottom" title="Coming soon..." >
                            <b>Connect Now</b>
                        </div>
                    </div>
                </div>

                <div class="{{$columns}}">
                    <div class="sconnect card">
                        @if($userSocialConnection->is_youtube_auth) 
                            <i class="fas fa-check-circle connected-icon"></i>
                        @endif
                        <div class="card-body">
                            <div class="sc-icon mb-2">
                                <i class="fab fa-youtube" style="color: #f00276;"></i>
                            </div>
                            <h6>Youtube</h6>
                            <div class="text-secondary">Channel or Video</div>
                        </div>
                        {{-- <a class="@if($userSocialConnection->is_youtube_auth) connected @else new_connect @endif text-decoration-none connect-to-social-media"  data-socialAccount="youtube" href="javascript:void(0)" >
                            <b>@if($userSocialConnection->is_youtube_auth) Connected @else Connect Now @endif </b>
                            <span  id="loading_icon_youtube" class="ms-2" style="display:none;">
                                <i class="fa fa-spinner fa-2x fa-spin"></i>
                            </span>
                        </a> --}}
                        <div class="new_connect a_disable" data-toggle="tooltip" data-placement="bottom" title="Coming soon..." >
                            <b>Connect Now</b>
                        </div>
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
                <div class="modal-footer justify-content-start pt-0">
                    <button type="submit" class="btn btn-success" >Update Page</button>

                    <a class="@if($userSocialConnection->is_facebook_auth) connected @else new_connect @endif text-decoration-none connect-to-social-media btn btn-primary"  data-socialAccount="facebook" href="javascript:void(0)" >
                        New Pages from facebook Account
                        <span  id="loading_icon_facebook" class="ms-2" style="display:none;">
                            <i class="fa fa-spinner fa-2x fa-spin"></i>
                        </span>
                    </a>
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
                        <label for="" class="text-primary">LinkedIn Page Id</label>
                        <a href="#" class="info-btn" data-toggle="modal" data-target="#linkedin_pageid_modal" data-backdrop="static" data-keyboard="false"><i class="fa fa-info-circle"></i></a>

                        <input type="text" name="linkedin_page_id" id="linkedin_page_id" class="form-control number-validation" placeholder="Enter the linkedin page id" value="{{ $userSocialConnection->linkedin_page_id ?? '' }}">
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
    @include('business.social-posts.social-connect-js')
    @include('business.social-posts.social-media-modals')
@endsection

