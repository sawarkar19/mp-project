@extends('layouts.business')
@section('title', 'Modify Task: Business')
@section('end_head')@endsection
@section('head') @include('layouts.partials.headersection', ['title' => 'Modify Tasks']) @endsection
@section('content')


    <style>
        label span {
            color: red;
        }

        .accordion .accordion-header {
            padding: 12px 15px;
        }

        .accordion .accordion-header.collapsed .fa-chevron-up {
            opacity: .6;
        }

        .accordion .accordion-header.collapsed .fa-chevron-up::before {
            content: "\f078" !important;
        }

        .image-note {
            font-style: italic;
            color: red;
        }

        .draft_btn {
            background: transparent;
            border: none;
            color: #6777ef;
        }

        .google .btn:not(.btn-social):not(.btn-social-icon):hover {
            border-color: #4285F4 !important;
            background-color: #4285F4;
            color: #fff;
        }

        .google .btn:not(.btn-social):not(.btn-social-icon):focus {
            background-color: #4285F4;
            color: #fff;
        }

        .google_btn {
            background: #4285F4;
            color: #fff;
        }

        .facebook .btn:not(.btn-social):not(.btn-social-icon):hover {
            background-color: #8aa6de;
            color: #fff;
        }

        .facebook .btn:not(.btn-social):not(.btn-social-icon):focus {
            background-color: #8aa6de;
            color: #fff;
        }

        .facebook_btn {
            background: #4267B2;
            color: #fff;
        }

        .instagram .btn:not(.btn-social):not(.btn-social-icon):hover {
            background-color: #cb275e;
            ;
            color: #fff;
        }

        .instagram .btn:not(.btn-social):not(.btn-social-icon):focus {
            background-color: #cb275e;
            ;
            color: #fff;
        }

        .instagram_btn {
            background: #E1306C;
            color: #fff;
        }

        .twitter .btn:not(.btn-social):not(.btn-social-icon):hover {
            border-color: #1DA1F2 !important;
            background-color: #1DA1F2;
            color: #fff;
        }

        .twitter .btn:not(.btn-social):not(.btn-social-icon):focus {
            background-color: #1DA1F2;
            color: #fff;
        }

        .twitter_btn {
            background: #1DA1F2;
            color: #fff;
        }

        .linkedin .btn:not(.btn-social):not(.btn-social-icon):hover {
            border-color: #0077b5 !important;
            background-color: #0077b5;
            color: #fff;
        }

        .linkedin .btn:not(.btn-social):not(.btn-social-icon):focus {
            background-color: #0077b5;
            color: #fff;
        }

        .linkedin_btn {
            background: #0077b5;
            color: #fff;
        }

        .youtube .btn:not(.btn-social):not(.btn-social-icon):hover {
            border-color: #FF0000 !important;
            background-color: #FF0000;
            color: #fff;
        }

        .youtube .btn:not(.btn-social):not(.btn-social-icon):focus {
            background-color: #FF0000;
            color: #fff;
        }

        .youtube_btn {
            background: #FF0000;
            color: #fff;
        }

        .website .btn:not(.btn-social):not(.btn-social-icon):hover {
            border-color: #0DA8EE !important;
            background-color: #0DA8EE;
            color: #fff;
        }

        .website .btn:not(.btn-social):not(.btn-social-icon):focus {
            background-color: #0DA8EE;
            color: #fff;
        }

        .website_btn {
            background: #0DA8EE;
            color: #fff;
        }

        .form_header .card-header, .available_task .card-header{
            min-height: 50px;
            padding: 6px 25px;
        }

        .form_header .card-header i {
            position: relative;
            font-size: 23px;
            top: 4px;
        }

        .facebook_card .card-header h6,
        .facebook_card .card-header i {
            color: #4267B2;
        }

        .instagram_card .card-header h6,
        .instagram_card .card-header i {
            color: #3f729b;
        }

        .twitter_card .card-header h6,
        .twitter_card .card-header i {
            color: #1DA1F2;
        }

        .linkedin_card .card-header h6,
        .linkedin_card .card-header i {
            color: #0077b5;
        }

        .youtube_card .card-header h6,
        .youtube_card .card-header i {
            color: #ff0000;
        }

        .google_card .card-header h6,
        .google_card .card-header i {
            color: #4285F4;
        }

        .website_card .card-header h6,
        .website_card .card-header i {
            color: #0DA8EE;
        }

        .instructSec {
            border: 2px dashed #ddd;
            text-align: center;
        }

        .instructSec p {
            font-size: 18px;
        }

        .dColor {
            color: #4267B2;
        }

        .accordion .accordion-header {
            background-color: transparent;
        }

        .accordion .accordion-header:hover {
            background-color: transparent;
        }

        .accordion .accordion-header[aria-expanded="true"] {
            box-shadow: none;
            background-color: transparent;
            color: #fff;
        }

        .accordion-header h6::after {
            content: '+';
            transform: rotate(45deg);
            float: right;
            font-size: 21px;
            font-weight: 300;
            -webkit-transition: 0.5s ease-in;
        }

        .accordion-header.collapsed h6::after {
            transform: rotate(0deg);
        }
    </style>
    {{-- @php dd($tasks) @endphp --}}

    <section class="section">

        <div class="section-body">
            <form id="instantform" action="{{ route('business.channel.instantRewards.updateTasks') }}" method="post">

                @csrf
                <div class="row justify-content-between my-5">

                    {{-- Column right --}}
                    <div class="col-sm-12 col-md-7 col-lg-7 col-xl-7">

                        <!-- Entries Section -->
                        {{-- Default  --}}
                        <div class="instructSec pt-2 pb-2 pl-5 pr-5 mb-3">
                            <p class="mb-0">Click on buttons to the right to add new task.</p>
                        </div>
                        {{-- Default END --}}

                        <input type="hidden" name="deleted_item" id="deleted_item" />

                        <div id="task_tabs_main">
                            @php
                                $showGoogleReviewModal = 1;
                                $task_status = $user_visible_task_status = [];
                                
                                $isUserFree = $userInfo->current_account_status ?? NULL;

                                // set array task_key wise
                                $tasks_keys = [];
                                foreach ($tasks as $task){
                                    $tasks_keys[$task->task_key] = $task;
                                }   
                                
                                $isShowTask = [];
                            @endphp

                            @foreach ($tasks as $task)
                                @php
                                    $task_status['task_' . $task->id] = $task->coming_soon;
                                    $user_visible_task_status['task_' . $task->id] = $task->visible_to_free_user;
                                @endphp

                                @if($task->coming_soon==0)
                                    @if($task->visible_to_free_user==1 || $isUserFree!="free")
                                        @php
                                            $is_automatic = $task->is_automatic;

                                            if($task->instant_task!=NULL){
                                                array_push($isShowTask, $task->instant_task->task_id);
                                            }
                                        @endphp

                                        @if ($task->task_key == 'google_review_link')
                                            @if (isset($task->instant_task))
                                                @php
                                                    $showGoogleReviewModal = 0;
                                                @endphp
                                            @endif
                                        @endif

                                        <div class="card form_header {{ $task->tab_classes }} socialTabs @if (@$task->instant_task->task_id != $task->id) secHide @endif "
                                            style="@if (@$task->instant_task->task_id != $task->id) display: none @endif"
                                            id="{{ $task->tab_ids }}">
                                            <div class="card-header justify-content-between">
                                                <div>
                                                    <div class="mr-2 d-inline-block">
                                                        {!! $task->icon !!}
                                                    </div>
                                                    <div class="d-inline-block">
                                                        <h6 class="mb-0"> {!! $task->name !!}</h6>
                                                    </div>
                                                </div>
                                                <div class="">
                                                    <button type="button" class="btn btn-danger @if($is_automatic==1) disabled @else tabHide @endif"
                                                        data-task_id="{{ $task->id }}" data-task_key="{{ $task->task_key }}"
                                                        style="@if($is_automatic!=1)cursor: pointer @endif " title="@if($is_automatic==1) Auto-post task not deleted @endif ">x</button>
                                                    {{-- <span class=" fa fa-times tabHide" data-task_key="{{ $task->task_key }}" style="cursor: pointer"></span> --}}
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-row align-items-center">
                                                    <div class="col-md-12">
                                                        <div class="form-group mb-0">
                                                            <div class="d-flex justify-content-between">
                                                                <label for="">{{ $task->tab_label }}<span>*</span></label>
                                                                <a href="#" class="info-btn" data-toggle="modal"
                                                                    data-target="#{{ $task->modal_target }}" data-backdrop="static"
                                                                    data-keyboard="false"><i class="fa fa-info-circle"></i></a>
                                                            </div>
                                                            <input type="text" id="{{ $task->task_key }}_url"
                                                                name="{{ $task->task_key }}" class="form-control"
                                                                value="{{ @$task->instant_task->task_value }}"
                                                                placeholder="{{ $task->placeholder }}" @if($is_automatic==1) disabled @endif >

                                                            
                                                            @if($task->task_key == "google_review_link")
                                                                <div class="d-flex justify-content-between mt-3">
                                                                    <label for="">{{ $task->one_extra_field_name }}<span>*</span></label>
                                                                    <a href="#" class="info-btn" data-toggle="modal"
                                                                    data-target="#{{ $task->modal_target_extra_field }}" data-backdrop="static"
                                                                    data-keyboard="false"><i class="fa fa-info-circle"></i></a>
                                                                </div>
                                                                
                                                                <input type="text" id="{{ $task->one_extra_field }}_url"
                                                                    name="{{ $task->one_extra_field }}" class="form-control"
                                                                    value="{{ @$task->instant_task->one_extra_field_value }}"
                                                                    placeholder="{{ $task->one_extra_field_placeholder }}" @if($is_automatic==1) disabled @endif >
                                                            @endif

                                                            {{-- @if ($task->task_key == 'yt_like_url' || $task->task_key == 'yt_comment_url')
                                        <div class="text-center">OR</div>
                                        <input type="file" id="{{ $task->task_key }}_video" name="{{ $task->task_key }}_video" class="form-control" value="{{ @$task->instant_task->task_value }}" placeholder="{{ $task->placeholder }}" >
                                        @endif --}}

                                                            <div class="errorSocialLinks" id="error_{{ $task->task_key }}"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-5 col-lg-5 col-xl-5">
                        <div class="card available_task">
                            <div class="card-header">
                                <h4>Available Tasks</h4>
                            </div>
                            <div class="card-body" id="scoial_media">
                                <div class="dropdown facebook d-inline mr-2 mb-2">
                                    <button class="btn facebook_btn dropdown-toggle mb-3" type="button"
                                        id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="fab fa-facebook"></i> Facebook
                                    </button>
                                    <div class="dropdown-menu tooltip-color">
                                        {{-- fb_page_url --}}
                                        @if(isset($task_status['task_1']) && $task_status['task_1']==1)
                                            {{-- Comming Soon --}}
                                            <a class="dropdown-item facebook_follow disabled" href="#" data-toggle="tooltip" data-placement="top" title="Coming soon..." style="pointer-events: all;">Like Our Page</a>
                                        @elseif(isset($user_visible_task_status['task_1']) && $user_visible_task_status['task_1']==0 && $isUserFree=="free")
                                            {{-- Free user task --}}
                                            <a class="dropdown-item facebook_follow disabled" href="#" data-toggle="tooltip" data-placement="top" title="Pro feature..." href="#" style="pointer-events: all;"> Like Our Page </a>
                                        @else
                                            <a class="dropdown-item facebook_follow" data-task_key="{{ $tasks_keys['fb_page_url']->task_key }}" data-task_added_through="{{ $tasks_keys['fb_page_url']->task_added_through }}" data-is_automatic="{{ $tasks_keys['fb_page_url']->is_automatic ?? 0 }}" data-is_task_show="{{ in_array(1, $isShowTask) ? 1 : 0 }}" href="#" id="fb_follow_pg_opt">Like Our Page</a>
                                        @endif

                                        {{-- fb_comment_post_url --}}
                                        @if(isset($task_status['task_2']) && $task_status['task_2']==1)
                                            {{-- Comming Soon --}}
                                            <a class="dropdown-item facebook_comment disabled" data-toggle="tooltip" data-placement="top" title="Coming soon..." href="#" style="pointer-events: all;">Comment On Our Post</a>
                                        @elseif(isset($user_visible_task_status['task_2']) && $user_visible_task_status['task_2']==0 && $isUserFree=="free")
                                            {{-- Free user task --}}
                                            <a class="dropdown-item facebook_comment disabled" data-toggle="tooltip" data-placement="top" title="Pro feature..." href="#" style="pointer-events: all;">Comment On Our Post</a>
                                        @else
                                            {{-- normal task --}}
                                            <a class="dropdown-item facebook_comment" href="#" data-task_key="{{ $tasks_keys['fb_comment_post_url']->task_key }}" data-task_added_through="{{ $tasks_keys['fb_comment_post_url']->task_added_through }}" data-is_automatic="{{ $tasks_keys['fb_comment_post_url']->is_automatic ?? 0 }}" data-is_task_show="{{ in_array(2, $isShowTask) ? 1 : 0 }}" id="fb_comment_pg_opt">Comment On Our Post</a>
                                        @endif
                                        
                                        {{-- fb_like_post_url --}}
                                        @if(isset($task_status['task_3']) && $task_status['task_3']==1)
                                            {{-- Comming Soon --}}
                                            <a class="dropdown-item facebook_like disabled" data-toggle="tooltip" data-placement="top" title="Coming soon..." href="#" style="pointer-events: all;">Like Our Post</a>
                                        @elseif(isset($user_visible_task_status['task_3']) && $user_visible_task_status['task_3']==0 && $isUserFree=="free")
                                            {{-- Free user task --}}
                                            <a class="dropdown-item facebook_like disabled" data-toggle="tooltip" data-placement="top" title="Pro feature..." href="#" style="pointer-events: all;">Like Our Post</a>
                                        @else
                                            {{-- normal task --}}
                                            <a class="dropdown-item facebook_like" data-task_key="{{ $tasks_keys['fb_like_post_url']->task_key }}" data-task_added_through="{{ $tasks_keys['fb_like_post_url']->task_added_through }}" data-is_automatic="{{ $tasks_keys['fb_like_post_url']->is_automatic ?? 0 }}" data-is_task_show="{{ in_array(3, $isShowTask) ? 1 : 0 }}" href="#" id="fb_like_pg_opt">Like Our Post</a>
                                        @endif
                                        
                                        {{-- fb_share_post_url --}}
                                        @if(isset($task_status['task_15']) && $task_status['task_15']==1)
                                            {{-- Comming Soon --}}
                                            <a class="dropdown-item facebook_share disabled" data-toggle="tooltip" data-placement="top" title="Coming soon..." href="#" style="pointer-events: all;">Share Our Post</a>
                                        @elseif(isset($user_visible_task_status['task_15']) && $user_visible_task_status['task_15']==0 && $isUserFree=="free")
                                            {{-- Free user task --}}
                                            <a class="dropdown-item facebook_share disabled" data-toggle="tooltip" data-placement="top" title="Pro feature..." href="#" style="pointer-events: all;">Share Our Post</a>
                                        @else
                                            {{-- normal task --}}
                                            <a class="dropdown-item facebook_share" data-task_key="{{ $tasks_keys['fb_share_post_url']->task_key }}" data-task_added_through="{{ $tasks_keys['fb_share_post_url']->task_added_through }}" data-is_automatic="{{ $tasks_keys['fb_share_post_url']->is_automatic ?? 0 }}" data-is_task_show="{{ in_array(15, $isShowTask) ? 1 : 0 }}" href="#" id="fb_share_pg_opt" style="pointer-events: all;">Share Our Post</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="dropdown instagram d-inline mr-2 mb-2">
                                    <button class="btn instagram_btn dropdown-toggle mb-3" type="button"
                                        id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="fab fa-instagram"></i> Instagram
                                    </button>
                                    <div class="dropdown-menu">
                                        {{-- insta_profile_url --}}
                                        @if(isset($task_status['task_4']) && $task_status['task_4']==1)
                                            {{-- Comming Soon --}}
                                            <a class="dropdown-item Insta_follow disabled" data-toggle="tooltip" data-placement="top" title="Coming soon..." href="#" style="pointer-events: all;">Follow Our Profile</a>
                                        @elseif(isset($user_visible_task_status['task_4']) && $user_visible_task_status['task_4']==0 && $isUserFree=="free")
                                            {{-- Free user task --}}
                                            <a class="dropdown-item Insta_follow disabled" data-toggle="tooltip" data-placement="top" title="Pro feature..." href="#" style="pointer-events: all;">Follow Our Profile</a>
                                        @else
                                            {{-- normal task --}}
                                            <a class="dropdown-item Insta_follow" data-task_key="{{ $tasks_keys['insta_profile_url']->task_key }}" data-task_added_through="{{ $tasks_keys['insta_profile_url']->task_added_through }}" data-is_automatic="{{ $tasks_keys['insta_profile_url']->is_automatic ?? 0 }}" data-is_task_show="{{ in_array(4, $isShowTask) ? 1 : 0 }}" href="#" id="insta_follow_pg_opt">Follow Our Profile</a>
                                        @endif

                                        {{-- insta_post_url --}}
                                        @if(isset($task_status['task_5']) && $task_status['task_5']==1)
                                            {{-- Comming Soon --}}
                                            <a class="dropdown-item Insta_like disabled" data-toggle="tooltip" data-placement="top" title="Coming soon..." href="#" style="pointer-events: all;">Like Our Post</a>
                                        @elseif(isset($user_visible_task_status['task_5']) && $user_visible_task_status['task_5']==0 && $isUserFree=="free")
                                            {{-- Free user task --}}
                                            <a class="dropdown-item Insta_like disabled" data-toggle="tooltip" data-placement="top" title="Pro feature..." href="#" style="pointer-events: all;">Like Our Post</a>
                                        @else
                                            {{-- normal task --}}
                                            <a class="dropdown-item Insta_like" data-task_key="{{ $tasks_keys['insta_post_url']->task_key }}" data-task_added_through="{{ $tasks_keys['insta_post_url']->task_added_through }}" data-is_automatic="{{ $tasks_keys['insta_post_url']->is_automatic ?? 0 }}" data-is_task_show="{{ in_array(5, $isShowTask) ? 1 : 0 }}" href="#" id="insta_like_pg_opt">Like Our Post</a>
                                        @endif

                                        {{-- insta_comment_post_url --}}
                                        @if(isset($task_status['task_16']) && $task_status['task_16']==1)
                                            {{-- Comming Soon --}}
                                            <a class="dropdown-item Insta_comment_count disabled" data-toggle="tooltip" data-placement="top" title="Coming soon..." href="#" style="pointer-events: all;">Comment on Our Post</a>
                                        @elseif(isset($user_visible_task_status['task_16']) && $user_visible_task_status['task_16']==0 && $isUserFree=="free")
                                            {{-- Free user task --}}
                                            <a class="dropdown-item Insta_comment_count disabled" data-toggle="tooltip" data-placement="top" title="Pro feature..." href="#" style="pointer-events: all;">Comment on Our Post</a>
                                        @else
                                            {{-- normal task --}}
                                            <a class="dropdown-item Insta_comment_count" data-task_key="{{ $tasks_keys['insta_comment_post_url']->task_key }}" data-task_added_through="{{ $tasks_keys['insta_comment_post_url']->task_added_through }}" data-is_automatic="{{ $tasks_keys['insta_comment_post_url']->is_automatic ?? 0 }}" data-is_task_show="{{ in_array(16, $isShowTask) ? 1 : 0 }}" href="#" id="insta_comment_count_pg_opt">Comment on Our Post</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="dropdown twitter d-inline mr-2 mb-2">
                                    <button class="btn twitter_btn dropdown-toggle mb-3" type="button"
                                        id="dropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="fab fa-twitter"></i> Twitter
                                    </button>
                                    <div class="dropdown-menu">
                                        {{-- tw_username --}}
                                        @if(isset($task_status['task_6']) && $task_status['task_6']==1)
                                            {{-- Comming Soon --}}
                                            <a class="dropdown-item twitter_follow disabled" data-toggle="tooltip" data-placement="top" title="Coming soon..." href="#" style="pointer-events: all;">Follow Our Profile</a>
                                        @elseif(isset($user_visible_task_status['task_6']) && $user_visible_task_status['task_6']==0 && $isUserFree=="free")
                                            {{-- Free user task --}}
                                            <a class="dropdown-item twitter_follow disabled" data-toggle="tooltip" data-placement="top" title="Pro feature..." href="#" style="pointer-events: all;">Follow Our Profile</a>
                                        @else
                                            {{-- normal task --}}
                                            <a class="dropdown-item twitter_follow"  data-task_key="{{ $tasks_keys['tw_username']->task_key }}"  data-task_added_through="{{ $tasks_keys['tw_username']->task_added_through }}" data-is_automatic="{{ $tasks_keys['tw_username']->is_automatic ?? 0 }}" data-is_task_show="{{ in_array(6, $isShowTask) ? 1 : 0 }}" href="#" id="twitter_follow_pg_opt">Follow Our Profile</a>
                                        @endif

                                        {{-- tw_tweet_url --}}
                                        @if(isset($task_status['task_7']) && $task_status['task_7']==1)
                                            {{-- Comming Soon --}}
                                            <a class="dropdown-item twitter_like disabled" data-toggle="tooltip" data-placement="top" title="Coming soon..." href="#" style="pointer-events: all;">Like Our Tweet</a>
                                        @elseif(isset($user_visible_task_status['task_7']) && $user_visible_task_status['task_7']==0 && $isUserFree=="free")
                                            {{-- Free user task --}}
                                            <a class="dropdown-item twitter_like disabled" data-toggle="tooltip" data-placement="top" title="Pro feature..." href="#" style="pointer-events: all;">Like Our Tweet</a>
                                        @else
                                            {{-- normal task --}}
                                            <a class="dropdown-item twitter_like" data-task_key="{{ $tasks_keys['tw_tweet_url']->task_key }}" data-task_added_through="{{ $tasks_keys['tw_tweet_url']->task_added_through }}" data-is_automatic="{{ $tasks_keys['tw_tweet_url']->is_automatic ?? 0 }}" data-is_task_show="{{ in_array(7, $isShowTask) ? 1 : 0 }}" href="#" id="twitter_like_pg_opt">Like Our Tweet</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="dropdown linkedin d-inline mr-2 mb-2">
                                    <button class="btn linkedin_btn dropdown-toggle mb-3" type="button"
                                        id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="fab fa-linkedin"></i> LinkedIn
                                    </button>
                                    <div class="dropdown-menu">
                                        {{-- li_company_url --}}
                                        @if(isset($task_status['task_8']) && $task_status['task_8']==1)
                                            {{-- Comming Soon --}}
                                            <a class="dropdown-item linkedin_follow disabled" data-toggle="tooltip" data-placement="top" title="Coming soon..." href="#" style="pointer-events: all;">Follow Our Page</a> 
                                        @elseif(isset($user_visible_task_status['task_8']) && $user_visible_task_status['task_8']==0 && $isUserFree=="free")
                                            {{-- Free user task --}}
                                            <a class="dropdown-item linkedin_follow disabled" data-toggle="tooltip" data-placement="top" title="Pro feature..." href="#" style="pointer-events: all;">Follow Our Page</a> 
                                        @else
                                            {{-- normal task --}}
                                            <a class="dropdown-item linkedin_follow" data-task_key="{{ $tasks_keys['li_company_url']->task_key }}" data-task_added_through="{{ $tasks_keys['li_company_url']->task_added_through }}" data-is_automatic="{{ $tasks_keys['li_company_url']->is_automatic ?? 0 }}" data-is_task_show="{{ in_array(8, $isShowTask) ? 1 : 0 }}" href="#" id="linkedin_follow_pg_opt">Follow Our Page</a>
                                        @endif

                                        {{-- li_post_url --}}
                                        @if(isset($task_status['task_9']) && $task_status['task_9']==1)
                                            {{-- Comming Soon --}}
                                            <a class="dropdown-item linkedin_follow disabled" data-toggle="tooltip" data-placement="top" title="Coming soon..." href="#" style="pointer-events: all;">Like Our Post</a>
                                        @elseif(isset($user_visible_task_status['task_8']) && $user_visible_task_status['task_8']==0 && $isUserFree=="free")
                                            {{-- Free user task --}}
                                            <a class="dropdown-item linkedin_follow disabled" data-toggle="tooltip" data-placement="top" title="Pro feature..." href="#" style="pointer-events: all;">Like Our Post</a>
                                        @else
                                            {{-- normal task --}}
                                            <a class="dropdown-item linkedin_follow" data-task_key="{{ $tasks_keys['li_post_url']->task_key }}" data-task_added_through="{{ $tasks_keys['li_post_url']->task_added_through }}" data-is_automatic="{{ $tasks_keys['li_post_url']->is_automatic ?? 0 }}" data-is_task_show="{{ in_array(9, $isShowTask) ? 1 : 0 }}" href="#" id="linkedin_like_pg_opt">Like Our Post</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="dropdown youtube d-inline mr-2 mb-2">
                                    <button class="btn youtube_btn dropdown-toggle mb-3" type="button"
                                        id="dropdownMenuButton5" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="true">
                                        <i class="fab fa-youtube"></i> Youtube
                                    </button>
                                    <div class="dropdown-menu">
                                        {{-- yt_channel_url --}}
                                        @if(isset($task_status['task_10']) && $task_status['task_10']==1)
                                            {{-- Comming Soon --}}
                                            <a class="dropdown-item youtube_subscribe disabled" data-toggle="tooltip" data-placement="top" title="Coming soon..." href="#" style="pointer-events: all;">Subscribe To Our Channel</a>
                                        @elseif(isset($user_visible_task_status['task_10']) && $user_visible_task_status['task_10']==0 && $isUserFree=="free")
                                            {{-- Free user task --}}
                                            <a class="dropdown-item youtube_subscribe disabled" data-toggle="tooltip" data-placement="top" title="Pro feature..." href="#" style="pointer-events: all;">Subscribe To Our Channel</a>
                                        @else
                                            {{-- normal task --}}
                                            <a class="dropdown-item youtube_subscribe" data-task_key="{{ $tasks_keys['yt_channel_url']->task_key }}" data-task_added_through="{{ $tasks_keys['yt_channel_url']->task_added_through }}" data-is_automatic="{{ $tasks_keys['yt_channel_url']->is_automatic ?? 0 }}" data-is_task_show="{{ in_array(10, $isShowTask) ? 1 : 0 }}" href="#" id="yt_follow_pg_opt">Subscribe To Our Channel</a>
                                        @endif

                                        {{-- yt_like_url --}}
                                        @if(isset($task_status['task_11']) && $task_status['task_11']==1)
                                            {{-- Comming Soon --}}
                                            <a class="dropdown-item youtube_like disabled" data-toggle="tooltip" data-placement="top" title="Coming soon..." href="#" style="pointer-events: all;">Like To Our Video</a>
                                        @elseif(isset($user_visible_task_status['task_11']) && $user_visible_task_status['task_11']==0 && $isUserFree=="free")
                                            {{-- Free user task --}}
                                            <a class="dropdown-item youtube_like disabled" data-toggle="tooltip" data-placement="top" title="Pro feature..." href="#" style="pointer-events: all;">Like To Our Video</a>
                                        @else
                                            {{-- normal task --}}
                                            <a class="dropdown-item youtube_like" data-task_key="{{ $tasks_keys['yt_like_url']->task_key }}" data-task_added_through="{{ $tasks_keys['yt_like_url']->task_added_through }}" data-is_automatic="{{ $tasks_keys['yt_like_url']->is_automatic ?? 0 }}" data-is_task_show="{{ in_array(11, $isShowTask) ? 1 : 0 }}" href="#" id="yt_like_pg_opt">Like To Our Video</a>
                                        @endif

                                        {{-- yt_comment_url --}}
                                        @if(isset($task_status['task_12']) && $task_status['task_12']==1)
                                            {{-- Comming Soon --}}
                                            <a class="dropdown-item youtube_comment disabled" data-toggle="tooltip" data-placement="top" title="Coming soon..." href="#" style="pointer-events: all;">Comment To Our Video</a>
                                        @elseif(isset($user_visible_task_status['task_12']) && $user_visible_task_status['task_12']==0 && $isUserFree=="free")
                                            {{-- Free user task --}}
                                            <a class="dropdown-item youtube_comment disabled" data-toggle="tooltip" data-placement="top" title="Pro feature..." href="#" style="pointer-events: all;">Comment To Our Video</a>
                                        @else
                                            {{-- normal task --}}
                                            <a class="dropdown-item youtube_comment" data-task_key="{{ $tasks_keys['yt_comment_url']->task_key }}" data-task_added_through="{{ $tasks_keys['yt_comment_url']->task_added_through }}" data-is_automatic="{{ $tasks_keys['yt_comment_url']->is_automatic ?? 0 }}" data-is_task_show="{{ in_array(12, $isShowTask) ? 1 : 0 }}" href="#" id="yt_comment_pg_opt">Comment To Our Video</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="dropdown google d-inline mr-2 mb-2">
                                    <button class="btn google_btn dropdown-toggle mb-3" type="button"
                                        id="dropdownMenuButton6" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="fab fa-google"></i> Google
                                    </button>
                                    <div class="dropdown-menu">
                                        {{-- google_review_link --}}
                                        @if(isset($task_status['task_13']) && $task_status['task_13']==1)
                                            {{-- Comming Soon --}}
                                            <a class="dropdown-item google_review disabled" data-toggle="tooltip" data-placement="top" title="Coming soon..." href="#" style="pointer-events: all;">Review Us On Google</a>
                                        @elseif(isset($user_visible_task_status['task_13']) && $user_visible_task_status['task_13']==0 && $isUserFree=="free")
                                            {{-- Free user task --}}
                                            <a class="dropdown-item google_review disabled" data-toggle="tooltip" data-placement="top" title="Pro feature..." href="#" style="pointer-events: all;">Review Us On Google</a>
                                        @else
                                            {{-- normal task --}}
                                            <a class="dropdown-item google_review" data-task_key="{{ $tasks_keys['google_review_link']->task_key }}" data-task_added_through="{{ $tasks_keys['google_review_link']->task_added_through }}" data-is_automatic="{{ $tasks_keys['google_review_link']->is_automatic ?? 0 }}" data-is_task_show="{{ in_array(13, $isShowTask) ? 1 : 0 }}"  href="#" id="google_follow_pg_opt">Review Us On Google</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="dropdown website d-inline mr-2 mb-2">
                                    <button class="btn website_btn dropdown-toggle mb-3" type="button"
                                        id="dropdownMenuButton7" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="fa fa-link"></i> Website Page
                                    </button>
                                    <div class="dropdown-menu">
                                        {{-- visit_page_url --}}
                                        @if(isset($task_status['task_14']) && $task_status['task_14']==1)
                                            {{-- Comming Soon --}}
                                            <a class="dropdown-item website_page disabled" data-toggle="tooltip" data-placement="top" title="Coming soon..." href="#" style="pointer-events: all;">Website URL</a>
                                        @elseif(isset($user_visible_task_status['task_13']) && $user_visible_task_status['task_13']==0 && $isUserFree=="free")
                                            {{-- Free user task --}}
                                            <a class="dropdown-item website_page disabled" data-toggle="tooltip" data-placement="top" title="Pro feature..." href="#" style="pointer-events: all;">Website URL</a>
                                        @else
                                            {{-- normal task --}}
                                            <a class="dropdown-item website_page" data-task_key="{{ $tasks_keys['visit_page_url']->task_key }}" data-task_added_through="{{ $tasks_keys['visit_page_url']->task_added_through }}" data-is_automatic="{{ $tasks_keys['visit_page_url']->is_automatic ?? 0 }}" data-is_task_show="{{ in_array(14, $isShowTask) ? 1 : 0 }}" href="#" id="website_follow_pg_opt">Website URL</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <button type="submit" id="btnSubmit" class="btn btn-success">
                                    Save Tasks
                                </button>
                            </div>
                        </div>
                    </div>


                </div>

               

            </form> <!-- Form Close -->
        </div>


        </div>

    </section>
    {{-- modal discription for facebook --}}
    <div class="modal fade discription_modal" id="facebook_details_modal" tabindex="-1" role="dialog"
        aria-labelledby="facebook_details_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary">Facebook Page ID </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>A Facebook Page ID is the unique identifier of a Facebook Business Page. Integrate your Facebook page
                        through your Facebook ID with MouthPublicity. Once the page integration is done, you can assign
                        different tasks to your customers on this page. Integration makes easy tracking of all the
                        activities taken by your users, and you can always analyse them on the MouthPublicity Dashboard.</p>
                    <a href="https://www.facebook.com/pages/?category=your_pages&ref=bookmarks" class="btn btn-primary"
                        target="_blank">Click here</a>
                    <hr>
                    <h5 class="text-capitalize text-primary mb-3">Steps to get Facebook page ID</h5>
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                            <div class="card h-100 mb-0">
                                <div class="card-body">
                                    <div class="">
                                        <span class="step mb-3"><b>Step 1:</b></span>
                                        <p class="mb-1">From your facebook page's News Feed, click Pages in the
                                            left-hand-side of menu.</p>
                                        <img src="{{ asset('assets/business/steps_images/step1.jpg') }}" class="w-100">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                            <div class="card h-100 mb-0">
                                <div class="card-body">
                                    <div class="">
                                        <span class="step mb-3"><b>Step 2:</b></span>
                                        <p class="mb-1">Click on your Page name.</p>
                                        <img src="{{ asset('assets/business/steps_images/step2.png') }}" class="w-100">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                            <div class="card h-100 mb-0">
                                <div class="card-body">
                                    <div class="">
                                        <span class="step mb-3"><b>Step 3:</b></span>
                                        <p class="mb-1">From your facebook page, Click on MORE Tap (Present below your
                                            logo)</p>
                                        <img src="{{ asset('assets/business/steps_images/step3.png') }}" class="w-100">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                            <div class="card h-100 mb-0">
                                <div class="card-body">
                                    <div class="">
                                        <span class="step mb-3"><b>Step 4:</b></span>
                                        <p class="mb-1">After click on MORE, Click on the ABOUT Option.</p>
                                        <img src="{{ asset('assets/business/steps_images/step4.png') }}" class="w-100">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                            <div class="card h-100 mb-0">
                                <div class="card-body">
                                    <div class="">
                                        <span class="step mb-3"><b>Step 5:</b></span>
                                        <p class="mb-1">Scroll down to find your Page ID.</p>
                                        <img src="{{ asset('assets/business/steps_images/step5.png') }}" class="w-100">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    {{-- modal discription for facebook post --}}
    <div class="modal fade discription_modal" id="facebook_post_details_modal" tabindex="-1" role="dialog"
        aria-labelledby="facebook_post_details_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary">Facebook Post URL </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Copy-paste the URL of the Facebook post on which you want to assign a task, i.e. post like, comment,
                        or share with your customers. Once the URL is integrated with MouthPublicity, you can easily track
                        each activity taken on the post by different customers.</p>
                    <hr>
                    <h5 class="text-capitalize text-primary mb-3">Steps to get Facebook post URL</h5>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                        <div class="card h-100 mb-0">
                            <div class="card-body">
                                <div class="">
                                    <span class="step mb-3"><b>Step 1:</b></span>
                                    <p class="mb-1">From Home Feed, click on your page profile.</p>
                                    <img src="{{ asset('assets/business/steps_images/stepfb1.png') }}" class="w-100">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                        <div class="card h-100 mb-0">
                            <div class="card-body">
                                <div class="">
                                    <span class="step mb-3"><b>Step 2:</b></span>
                                    <p class="mb-1">Go to the post and click on the date and time of the post whose URL you want.</p>
                                    <img src="{{ asset('assets/business/steps_images/stepfb2.png') }}" class="w-100">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                        <div class="card h-100 mb-0">
                            <div class="card-body">
                                <div class="">
                                    <span class="step mb-3"><b>Step 3:</b></span>
                                    <p class="mb-1"> Copy the URL present in searchbar.</p>
                                    <img src="{{ asset('assets/business/steps_images/stepfb3.png') }}" class="w-100">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    {{-- modal discription for instagram page --}}
    <div class="modal fade discription_modal" id="instagram_details_modal" tabindex="-1" role="dialog"
        aria-labelledby="instagram_details_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary">Instagram Page URL </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Copy-paste the URL of your Instagram profile and get it integrated now with MouthPublicity. Once the
                        integration is done, you can easily keep track of activities taken by your users and always analyse
                        them on the MouthPublicity Dashboard.</p>
                    <hr>
                    <h5 class="text-capitalize text-primary mb-3">Steps to get Instagram Page URL</h5>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                        <div class="card h-100 mb-0">
                            <div class="card-body">
                                <div class="">
                                    <span class="step mb-3"><b>Step 1:</b></span>
                                    <p class="mb-1"> From Home Feed, click on your profile.</p>
                                    <img src="{{ asset('assets/business/steps_images/insta-step1.png') }}"
                                        class="w-100">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                        <div class="card h-100 mb-0">
                            <div class="card-body">
                                <div class="">
                                    <span class="step mb-3"><b>Step 2:</b></span>
                                    <p class="mb-1"> Copy the URL present in searchbar.</p>
                                    <img src="{{ asset('assets/business/steps_images/insta-step2.png') }}"
                                        class="w-100">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal discription for instagram post --}}
    <div class="modal fade discription_modal" id="instagram_post_details_modal" tabindex="-1" role="dialog"
        aria-labelledby="instagram_post_details_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary">Instagram Post URL </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Copy and paste the URL of the Instagram post to which you want to assign a task, i.e. post like,
                        comment, or share with your customers. Once the URL is integrated with MouthPublicity, you can easily
                        track each activity taken on the post by different customers.</p>
                    <hr>
                    <h5 class="text-capitalize text-primary mb-3">Steps to get Instagram post URL</h5>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                        <div class="card h-100 mb-0">
                            <div class="card-body">
                                <div class="">
                                    <span class="step mb-3"><b>Step 1:</b></span>
                                    <p class="mb-1">From Home Feed, click on your profile.</p>
                                    <img src="{{ asset('assets/business/steps_images/insta-step1.png') }}"
                                        class="w-100">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                        <div class="card h-100 mb-0">
                            <div class="card-body">
                                <div class="">
                                    <span class="step mb-3"><b>Step 2:</b></span>
                                    <p class="mb-1">From Home Feed, click on your profile.</p>
                                    <img src="{{ asset('assets/business/steps_images/insta-step22.png') }}"
                                        class="w-100">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                        <div class="card h-100 mb-0">
                            <div class="card-body">
                                <div class="">
                                    <span class="step mb-3"><b>Step 3:</b></span>
                                    <p class="mb-1"> Copy the URL present in searchbar.</p>
                                    <img src="{{ asset('assets/business/steps_images/insta-step33.png') }}"
                                        class="w-100">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    {{-- modal discription for twitter handel --}}
    <div class="modal fade discription_modal" id="twitter_details_modal" tabindex="-1" role="dialog"
        aria-labelledby="twitter_details_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary">Twitter Username </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Copy and paste the URL of your Twitter profile and get it integrated now with MouthPublicity. Once the
                        integration is done, you can easily keep track of activities taken by your users and always analyse
                        them on the MouthPublicity Dashboard.</p>
                    <hr>
                    <h5 class="text-capitalize text-primary mb-3">Steps to get Twitter Username</h5>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                        <div class="card h-100 mb-0">
                            <div class="card-body">
                                <div class="">
                                    <span class="step mb-3"><b>Step 1:</b></span>
                                    <p class="mb-1">From Home Feed you will see your username at the bottom-left corner.
                                    </p>
                                    <img src="{{ asset('assets/business/steps_images/twitter-step1.png') }}"
                                        class="w-100">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    {{-- modal discription for twitter tweet --}}
    <div class="modal fade discription_modal" id="tweet_details_modal" tabindex="-1" role="dialog"
        aria-labelledby="tweet_details_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary">Tweet URL </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Copy and paste the URL of the Twitter post on which you want to assign a task, i.e. post like,
                        comment, or share with your customers. Once the URL is integrated with MouthPublicity, you can easily
                        track each activity taken on the post by different customers. </p>
                    <hr>
                    <h5 class="text-capitalize text-primary mb-3">Steps to get tweet URL</h5>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                        <div class="card h-100 mb-0">
                            <div class="card-body">
                                <div class="">
                                    <span class="step mb-3"><b>Step 1:</b></span>
                                    <p class="mb-1">From Home Feed, Click on profile.</p>
                                    <img src="{{ asset('assets/business/steps_images/twitter-step11.png') }}"
                                        class="w-100">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                        <div class="card h-100 mb-0">
                            <div class="card-body">
                                <div class="">
                                    <span class="step mb-3"><b>Step 2:</b></span>
                                    <p class="mb-1">Go to the post and click on the date and time of the post whose URL you want.</p>
                                    <img src="{{ asset('assets/business/steps_images/twitter-step22.png') }}"
                                        class="w-100">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                        <div class="card h-100 mb-0">
                            <div class="card-body">
                                <div class="">
                                    <span class="step mb-3"><b>Step 3:</b></span>
                                    <p class="mb-1">Now copy the URL present in search bar</p>
                                    <img src="{{ asset('assets/business/steps_images/twitter-step33.png') }}"
                                        class="w-100">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    {{-- modal discription for linkedin --}}
    <div class="modal fade discription_modal" id="linkedin_details_modal" tabindex="-1" role="dialog"
        aria-labelledby="linkedin_details_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary">Company URL </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Copy-paste the URL of your LinkedIn profile and get it integrated now with MouthPublicity. Once the
                        integration is done, you can easily keep track of activities taken by your users and always analyse
                        them on the MouthPublicity Dashboard.</p>
                    <hr>
                    <h5 class="text-capitalize text-primary mb-3">Steps to get Company URL</h5>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                        <div class="card h-100 mb-0">
                            <div class="card-body">
                                <div class="">
                                    <span class="step mb-3"><b>Step 1:</b></span>
                                    <p class="mb-1"> From Home Feed, click on comapny profile.</p>
                                    <img src="{{ asset('assets/business/steps_images/linkedin-step1.png') }}"
                                        class="w-100">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                        <div class="card h-100 mb-0">
                            <div class="card-body">
                                <div class="">
                                    <span class="step mb-3"><b>Step 2:</b></span>
                                    <p class="mb-1">In the company profile. Click on Share Page and then Click on Copy
                                        URL</p>
                                    <img src="{{ asset('assets/business/steps_images/linkedin-step2.png') }}"
                                        class="w-100">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal discription for youtube subscribe --}}
    <div class="modal fade discription_modal" id="youtube_details_modal" tabindex="-1" role="dialog"
        aria-labelledby="youtube_details_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary">Channel URL</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Copy and paste the URL of the Youtube channel that you want to assign as a task to your customers.
                        Once the URL is integrated with MouthPublicity, you can easily track each activity taken on the post
                        by different customers.</p>
                    <hr>
                    <h5 class="text-capitalize text-primary mb-3">Steps to get Youtube Channel URL</h5>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                        <div class="card h-100 mb-0">
                            <div class="card-body">
                                <div class="">
                                    <span class="step mb-3"><b>Step 1:</b></span>
                                    <p class="mb-1">From Home Feed go to your profile and click on your channel.</p>
                                    <img src="{{ asset('assets/business/steps_images/yt-step1.png') }}" class="w-100">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                        <div class="card h-100 mb-0">
                            <div class="card-body">
                                <div class="">
                                    <span class="step mb-3"><b>Step 2:</b></span>
                                    <p class="mb-1">In channel, Click on Customise Channel</p>
                                    <img src="{{ asset('assets/business/steps_images/yt-step2.png') }}" class="w-100">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                        <div class="card h-100 mb-0">
                            <div class="card-body">
                                <div class="">
                                    <span class="step mb-3"><b>Step 3:</b></span>
                                    <p class="mb-1">Click on Basic Info.</p>
                                    <img src="{{ asset('assets/business/steps_images/yt-step3.png') }}" class="w-100">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                        <div class="card h-100 mb-0">
                            <div class="card-body">
                                <div class="">
                                    <span class="step mb-3"><b>Step 4:</b></span>
                                    <p class="mb-1">Under Channel URL copy your Channel URL.</p>
                                    <img src="{{ asset('assets/business/steps_images/yt-step4.png') }}" class="w-100">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    {{-- modal discription for youtube video comment --}}
    <div class="modal fade discription_modal" id="youtube_video_details_modal" tabindex="-1" role="dialog"
        aria-labelledby="youtube_video_details_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary">Youtube video URL</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Copy and paste the URL of the YouTube video to which you want to assign a task, such as posting,
                        liking, commenting, or sharing with your customers.Once the URL is integrated with MouthPublicity,
                        you can easily track each activity taken on the post by different customers.</p>
                    <hr>
                    <h5 class="text-capitalize text-primary mb-3">Steps to get Youtube Video URL</h5>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                        <div class="card h-100 mb-0">
                            <div class="card-body">
                                <div class="">
                                    <span class="step mb-3"><b>Step 1:</b></span>
                                    <p class="mb-1">At Home Feed, click on your profile present in right hand side of screen then click on your channel.</p>
                                    <img src="{{ asset('assets/business/steps_images/yt-step11.png') }}" class="w-100">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                        <div class="card h-100 mb-0">
                            <div class="card-body">
                                <div class="">
                                    <span class="step mb-3"><b>Step 2:</b></span>
                                    <p class="mb-1">Click on the video whose URL you want.</p>
                                    <img src="{{ asset('assets/business/steps_images/yt-step22.png') }}" class="w-100">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                        <div class="card h-100 mb-0">
                            <div class="card-body">
                                <div class="">
                                    <span class="step mb-3"><b>Step 3:</b></span>
                                    <p class="mb-1">Copy the URL present in searchbar.</p>
                                    <img src="{{ asset('assets/business/steps_images/yt-step33.png') }}" class="w-100">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal discription for youtube video like --}}
    <div class="modal fade discription_modal" id="youtube_videolike_details_modal" tabindex="-1" role="dialog"
        aria-labelledby="youtube_videolike_details_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary">Youtube video URL</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Copy and paste the URL of the YouTube video to which you want to assign a task, such as posting,
                        liking, commenting, or sharing with your customers.Once the URL is integrated with MouthPublicity,
                        you can easily track each activity taken on the post by different customers.</p>
                    <hr>
                    <h5 class="text-capitalize text-primary mb-3">Steps to get Youtube Video URL</h5>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                        <div class="card h-100 mb-0">
                            <div class="card-body">
                                <div class="">
                                    <span class="step mb-3"><b>Step 1:</b></span>
                                    <p class="mb-1">At Home Feed, click on your profile present in right hand side of screen then click on your channel.</p>
                                    <img src="{{ asset('assets/business/steps_images/yt-step11.png') }}" class="w-100">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                        <div class="card h-100 mb-0">
                            <div class="card-body">
                                <div class="">
                                    <span class="step mb-3"><b>Step 2:</b></span>
                                    <p class="mb-1">Click on the video whose URL you want.</p>
                                    <img src="{{ asset('assets/business/steps_images/yt-step22.png') }}" class="w-100">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                        <div class="card h-100 mb-0">
                            <div class="card-body">
                                <div class="">
                                    <span class="step mb-3"><b>Step 3:</b></span>
                                    <p class="mb-1">Copy the URL present in searchbar.</p>
                                    <img src="{{ asset('assets/business/steps_images/yt-step33.png') }}" class="w-100">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal discription for google url --}}
    <div class="modal fade discription_modal" id="google_details_modal" tabindex="-1" role="dialog"
        aria-labelledby="google_details_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary">Google Review URL</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Copy-paste the URL of your Google business page and get it integrated now with MouthPublicity. Once
                        the integration is done, you can easily keep track of activities taken by your users and always
                        analyze them on the MouthPublicity Dashboard.</p>
                    <hr>
                    <h5 class="text-capitalize text-primary mb-3">Steps to get Google Review URL</h5>
                    <div class="mb-4">
                        <span class="mb-0 font-weight-bold Steps">Step 1: </span>
                        <p class="mb-1">Click on the link <a
                                href="https://developers.google.com/maps/documentation/places/web-service/place-id"
                                target="_blank">google.com/maps</a></p>
                        <img src="{{ asset('assets/business/steps_images/google-review-step1.png') }}" class="w-100">
                    </div>
                    <div class="mb-4">
                        <span class="mb-0 font-weight-bold Steps">Step 2: </span>
                        <p class="mb-1">Scroll down to <b>Find the ID of a particular place</b> section</p>
                        <img src="{{ asset('assets/business/steps_images/google-review-step2.png') }}" class="w-100">
                    </div>
                    <div class="mb-4">
                        <span class="mb-0 font-weight-bold Steps">Step 3: </span>
                        <p class="mb-1">Type your business location</p>
                        <img src="{{ asset('assets/business/steps_images/google-review-step3.png') }}" class="w-100">
                    </div>
                    <div class="mb-4">
                        <span class="mb-0 font-weight-bold Steps">Step 4: </span>
                        <p class="mb-1">Copy the page ID</p>
                        <img src="{{ asset('assets/business/steps_images/google-review-step4.png') }}" class="w-100">
                    </div>
                    <div class="mb-4">
                        <span class="mb-0 font-weight-bold Steps">Step 5: </span>
                        <p class="mb-1">Paste the Page ID in google review url</p>
                        <img src="{{ asset('assets/business/steps_images/google-review-step5.png') }}" class="w-100">
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal discription for google map url --}}
    <div class="modal fade discription_modal" id="google_map_link_modal" tabindex="-1" role="dialog"
        aria-labelledby="google_details_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary">Google Map URL</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Copy-paste the URL of your Google business page and get it integrated now with MouthPublicity. Once
                        the integration is done, you can easily keep track of activities taken by your users and always
                        analyze them on the MouthPublicity Dashboard.</p>
                    <hr>
                    <h5 class="text-capitalize text-primary mb-3">Steps to get Google Map URL</h5>
                    <div class="mb-4">
                        <span class="mb-0 font-weight-bold Steps">Step 1: </span>
                        <p class="mb-1">Click on the link <a href="https://www.google.com/maps" target="_blank">google.com/maps</a></p>
                        <img src="{{ asset('assets/business/google_map_step/step1.png') }}" class="w-100">
                    </div>
                    <div class="mb-4">
                        <span class="mb-0 font-weight-bold Steps">Step 2: </span>
                        <p class="mb-1">Type your address.</p>
                        <img src="{{ asset('assets/business/google_map_step/step2.png') }}" class="w-100">
                    </div>
                    <div class="mb-4">
                        <span class="mb-0 font-weight-bold Steps">Step 3: </span>
                        <p class="mb-1">Copy the URL present in search bar.</p>
                        <img src="{{ asset('assets/business/google_map_step/step3.png') }}" class="w-100">
                    </div>
                    {{-- <div class="mb-4">
                        <span class="step mb-3"><b>Step 6:</b></span>
                        <p class="mb-1">Paste the URL in google map link.</p>
                        <img src="{{ asset('assets/business/google_map_step/step6.png') }}" class="w-100">
                    </div> --}}
                </div>
                
            </div>
        </div>
    </div>
    {{-- modal discription for website url --}}
    <div class="modal fade discription_modal" id="website_details_modal" tabindex="-1" role="dialog"
        aria-labelledby="website_details_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary">Website URL</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Copy-paste the URL of your website and get it integrated now with MouthPublicity. Once the integration
                        is done, you can easily keep track of activities taken by your users and always analyze them on the
                        MouthPublicity Dashboard.</p>
                    <hr>
                    <h5 class="text-capitalize text-primary mb-3">Steps to get google URL</h5>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                        <div class="card h-100 mb-0">
                            <div class="card-body">
                                <div class="">
                                    <span class="step mb-3"><b>Step 1:</b></span>
                                    <p class="mb-1"> At website home page, copy the URL present in searchbar.</p>
                                    <img src="{{ asset('assets/business/steps_images/web-step1.png') }}" class="w-100">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
@section('end_body')

    <script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/input-validation.js') }}"></script>

    @include('business.offers.instant.js')
    <script>
        let isGoogleReviewModalShowAlReady = 0;
        $(document).ready(function() {
            //youtube
            var connect_to = sessionStorage.getItem('connect_to');
            if(connect_to == 'youtube'){
                $("#dropdownMenuButton5").parent().addClass('show');
                $("#dropdownMenuButton5").next().addClass('show');

                sessionStorage.removeItem('connect_to');
            }



            // on the change of discount type (percent or Amount) [Coupon detail block]
            var $discount_type_input = $("input.discount_type_input");
            $discount_type_input.on("change", function() {
                // get the checked input data
                var $selected = $("input.discount_type_input:checked");
                if ($selected.data("name") == "percentage") {
                    $("#coupon_amount_input").hide();
                    $("#coupon_percentage_input").show();
                    $("input[name='discount_amount']").val('');

                } else if ($selected.data("name") == "amount") {
                    $("#coupon_percentage_input").hide();
                    $("#coupon_amount_input").show();
                    $("input[name='discount_percent']").val('');
                }
            });


            $(document).on("click", ".tabHide", function() {

                var task_key = $(this).attr('data-task_key');
                var task_id = $(this).attr('data-task_id');

                var deleted_item = $("#deleted_item").val();
                var thisTag = $(this);

                if ($("input[name=" + task_key + "]").val() == '') {
                    $(thisTag).parents(".socialTabs").hide();
                    return true;
                }

                swal.fire({
                        title: 'Are you sure?',
                        text: 'Once deleted, you will not be able to recover this!',
                        icon: 'warning',
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
                    .then(function(data) {
                        /*console.log(data.value);*/
                        if (data.value == true) {
                            var items = deleted_item + ", " + task_id;

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                type: 'POST',
                                url: "{{ route('business.removeDeletedTask') }}",
                                data: {
                                    "task_key": task_key,
                                    "task_id": task_id
                                },
                                dataType: 'json',
                                success: function(response){ 
                                    // Update header setting status
                                    $('.refresh-settings-status').click();

                                    $("#overlay").fadeOut(300);
                                    if(response.status==true){
                                        $("input[name=" + task_key + "]").val("");
                                        $("input[name='google_map_link']").val("");
                                        $("#deleted_item").val(items);
                                        $(thisTag).parents(".socialTabs").hide();
                                    }

                                    if(task_key+"_url"=="google_review_link_url"){
                                        isGoogleReviewModalShowAlReady = 0;
                                        @php
                                            $showGoogleReviewModal = 1;
                                        @endphp
                                    }

                                    Sweet('success',response.message);
                                },
                                error: function(xhr, status, error) 
                                {
                                    console.log("err", xhr);
                                }
                            });
                        }
                    });
            });

        })
    </script>

    <script>
        $(function() {
            $(".secHide").hide();

            function getUnique(array) {
                var uniqueArray = [];
                // Loop through array values
                for (i = 0; i < array.length; i++) {
                    if (uniqueArray.indexOf(array[i]) === -1) {
                        uniqueArray.push(array[i]);
                    }
                }
                return uniqueArray;
            }

            function removeDeleteTaskId(task_id) {
                var deleted_item = $("#deleted_item").val();
                var arr = deleted_item.split(', ');

                var uniqueDeleteItem = getUnique(arr);

                // uniqueDeleteItem = uniqueDeleteItem.splice(uniqueDeleteItem.indexOf(task_id),1);
                uniqueDeleteItem = $.grep(uniqueDeleteItem, function(value) {
                    return value != task_id;
                });

                console.log(uniqueDeleteItem);
                $("#deleted_item").val(uniqueDeleteItem.join(", "));
            }

            function onSelectTaskOnTop(tab, task_id, input_id) {
                var sec_id = document.getElementById(tab);
                var get_sec = sec_id.outerHTML;
                sec_id.remove();
                $("#task_tabs_main").prepend(get_sec);
                $("#" + tab).show();


                // Check currently task is deleted or not
                var deleted_item = $("#deleted_item").val();
                var arr = deleted_item.split(', ');
                var uniqueDeleteItem = getUnique(arr);

                uniqueDeleteItem = $.grep(uniqueDeleteItem, function(value) {
                    if(value==task_id){
                        $("#"+input_id).val("");

                        // For Extra fields
                        $("#google_map_link_url").val("");
                    }
                });
            }

            $("#fb_follow_pg_opt").on("click", function() {
                var task_added_through = $(this).attr("data-task_added_through");
                var is_automatic = $(this).attr("data-is_automatic");
                var is_task_show = $(this).attr("data-is_task_show");
                if(is_automatic==1 && is_task_show==0){
                    showAutoPostMsgPopup(task_added_through);
                }
                else{
                    removeDeleteTaskId(1);
                    onSelectTaskOnTop("fb_follow_pg_sec", 1, "fb_page_url_url");
                }
            });

            $("#fb_comment_pg_opt").on("click", function() {
                var task_added_through = $(this).attr("data-task_added_through");
                var is_automatic = $(this).attr("data-is_automatic");
                var is_task_show = $(this).attr("data-is_task_show");
                if(is_automatic==1 && is_task_show==0){
                    showAutoPostMsgPopup(task_added_through);
                }
                else{
                    removeDeleteTaskId(2);
                    onSelectTaskOnTop("fb_comment_pg_sec", 2, "fb_comment_post_url_url");
                }
            });

            $("#fb_like_pg_opt").on("click", function() {
                var task_added_through = $(this).attr("data-task_added_through");
                var is_automatic = $(this).attr("data-is_automatic");
                var is_task_show = $(this).attr("data-is_task_show");
                if(is_automatic==1 && is_task_show==0){
                    showAutoPostMsgPopup(task_added_through);
                }
                else{
                    //   removeDeleteTaskId(3);
                    onSelectTaskOnTop("fb_like_pg_sec", 3, "fb_like_post_url_url");
                }
            });
            $("#fb_share_pg_opt").on("click", function() {
                var task_added_through = $(this).attr("data-task_added_through");
                var is_automatic = $(this).attr("data-is_automatic");
                var is_task_show = $(this).attr("data-is_task_show");
                if(is_automatic==1 && is_task_show==0){
                    showAutoPostMsgPopup(task_added_through);
                }
                else{
                    // 15 is primary key in Task tbl
                    //   removeDeleteTaskId(15);
                    onSelectTaskOnTop("fb_share_pg_sec", 15, "fb_share_post_url_url");
                }
            });

            $("#insta_follow_pg_opt").on("click", function() {
                var task_added_through = $(this).attr("data-task_added_through");
                var is_automatic = $(this).attr("data-is_automatic");
                var is_task_show = $(this).attr("data-is_task_show");
                if(is_automatic==1 && is_task_show==0){
                    showAutoPostMsgPopup(task_added_through);
                }
                else{
                    //   removeDeleteTaskId(4);
                    onSelectTaskOnTop("insta_follow_pg_sec", 4, "insta_profile_url_url");
                }
            });

            $("#insta_like_pg_opt").on("click", function() {
                var task_added_through = $(this).attr("data-task_added_through");
                var is_automatic = $(this).attr("data-is_automatic");
                var is_task_show = $(this).attr("data-is_task_show");
                if(is_automatic==1 && is_task_show==0){
                    showAutoPostMsgPopup(task_added_through);
                }
                else{
                    //   removeDeleteTaskId(5);
                    onSelectTaskOnTop("insta_like_pg_sec", 5, "insta_post_url_url");
                }
            });

            $("#insta_comment_count_pg_opt").on("click", function() {
                var task_added_through = $(this).attr("data-task_added_through");
                var is_automatic = $(this).attr("data-is_automatic");
                var is_task_show = $(this).attr("data-is_task_show");
                if(is_automatic==1 && is_task_show==0){
                    showAutoPostMsgPopup(task_added_through);
                }
                else{
                    //   removeDeleteTaskId(16);
                    onSelectTaskOnTop("insta_comment_pg_sec", 16, "insta_comment_post_url_url");
                }
            });

            $("#twitter_follow_pg_opt").on("click", function() {
                var task_added_through = $(this).attr("data-task_added_through");
                var is_automatic = $(this).attr("data-is_automatic");
                var is_task_show = $(this).attr("data-is_task_show");
                if(is_automatic==1 && is_task_show==0){
                    showAutoPostMsgPopup(task_added_through);
                }
                else{
                    //   removeDeleteTaskId(6);
                    onSelectTaskOnTop("twitter_follow_pg_sec", 6, "tw_username_url");
                }
            });
            $("#twitter_like_pg_opt").on("click", function() {
                var task_added_through = $(this).attr("data-task_added_through");
                var is_automatic = $(this).attr("data-is_automatic");
                var is_task_show = $(this).attr("data-is_task_show");
                if(is_automatic==1 && is_task_show==0){
                    showAutoPostMsgPopup(task_added_through);
                }
                else{
                    //   removeDeleteTaskId(7);
                    onSelectTaskOnTop("twitter_like_pg_sec", 7, "tw_tweet_url_url");
                }
            });

            $("#linkedin_like_pg_opt").on("click", function() {
                var task_added_through = $(this).attr("data-task_added_through");
                var is_automatic = $(this).attr("data-is_automatic");
                var is_task_show = $(this).attr("data-is_task_show");
                if(is_automatic==1 && is_task_show==0){
                    showAutoPostMsgPopup(task_added_through);
                }
                else{
                    //   removeDeleteTaskId(8);
                    onSelectTaskOnTop("linkedin_like_pg_sec", 8, "li_company_url_url");
                }
            });

            $("#linkedin_follow_pg_opt").on("click", function() {
                var task_added_through = $(this).attr("data-task_added_through");
                var is_automatic = $(this).attr("data-is_automatic");
                var is_task_show = $(this).attr("data-is_task_show");
                if(is_automatic==1 && is_task_show==0){
                    showAutoPostMsgPopup(task_added_through);
                }
                else{
                    //   removeDeleteTaskId(9);
                    onSelectTaskOnTop("linkedin_follow_pg_sec", 9, "li_post_url_url");
                }
            });

            $("#yt_follow_pg_opt").on("click", function() {
                var task_added_through = $(this).attr("data-task_added_through");
                var is_automatic = $(this).attr("data-is_automatic");
                var is_task_show = $(this).attr("data-is_task_show");
                if(is_automatic==1 && is_task_show==0){
                    showAutoPostMsgPopup(task_added_through);
                }
                else{
                    //   removeDeleteTaskId(10);
                    onSelectTaskOnTop("yt_follow_pg_sec", 10, "yt_channel_url_url");
                }
            });
            $("#yt_like_pg_opt").on("click", function() {
                var task_added_through = $(this).attr("data-task_added_through");
                var is_automatic = $(this).attr("data-is_automatic");
                var is_task_show = $(this).attr("data-is_task_show");
                if(is_automatic==1 && is_task_show==0){
                    showAutoPostMsgPopup(task_added_through);
                }
                else{
                    //   removeDeleteTaskId(11);
                    onSelectTaskOnTop("yt_like_pg_sec", 11, "yt_like_url_url");
                }
            });

            $("#yt_comment_pg_opt").on("click", function() {
                var task_added_through = $(this).attr("data-task_added_through");
                var is_automatic = $(this).attr("data-is_automatic");
                var is_task_show = $(this).attr("data-is_task_show");
                if(is_automatic==1 && is_task_show==0){
                    showAutoPostMsgPopup(task_added_through);
                }
                else{
                    //   removeDeleteTaskId(12);
                    onSelectTaskOnTop("yt_comment_pg_sec", 12, "yt_comment_url_url");
                }
            });

            $("#google_follow_pg_opt").on("click", function() {
                var task_key = $(this).attr("data-task_key");
                task_key = task_key+"_url";
                var task_value = $("#"+task_key).val();
                // var googleReviewMsg = "Rs. {{ $googleReviewDeductCost->amount ?? 0 }} will be deducted from your wallet balance for each review.";
                // if(task_value!=""){
                //     //   removeDeleteTaskId(13);
                //     // show confirm modal befor insert place id
                //     var showGoogleReviewModal = '{{ $showGoogleReviewModal }}';
                //     if (showGoogleReviewModal == 1 && isGoogleReviewModalShowAlReady==0) {
                //         Swal.fire({
                //             title: '<strong>Please Note</strong>',
                //             html: googleReviewMsg,
                //             icon: 'info',
                //             showCloseButton: false,
                //             showCancelButton: true,
                //             focusConfirm: false,
                //             allowOutsideClick: false,
                //             confirmButtonText: 'Accept',
                //             cancelButtonText: 'Cancel'
                //         }).then((result) => {
                //             // console.log(result.value);
                //             if (result.value) {
                //                 isGoogleReviewModalShowAlReady = 1;
                //                 onSelectTaskOnTop("google_follow_pg_sec", 13, "google_review_link_url");
                //             }
                //         });
                //     } else {
                        onSelectTaskOnTop("google_follow_pg_sec", 13, "google_review_link_url");
                    // }
                // }
                // else{
                //     var task_added_through = $(this).attr("data-task_added_through");
                //     var is_automatic = $(this).attr("data-is_automatic");
                //     var is_task_show = $(this).attr("data-is_task_show");
                //     if(is_automatic==1 && is_task_show==0){
                //         showAutoPostMsgPopup(task_added_through);
                //     }
                //     else{
                //         //   removeDeleteTaskId(13);
                //         // show confirm modal befor insert place id
                //         var showGoogleReviewModal = '{{ $showGoogleReviewModal }}';
                //         if (showGoogleReviewModal == 1 && isGoogleReviewModalShowAlReady==0) {
                //             Swal.fire({
                //                 title: '<strong>Please Note</strong>',
                //                 html: googleReviewMsg,
                //                 icon: 'info',
                //                 showCloseButton: false,
                //                 showCancelButton: true,
                //                 focusConfirm: false,
                //                 allowOutsideClick: false,
                //                 confirmButtonText: 'Accept',
                //                 cancelButtonText: 'Cancel'
                //             }).then((result) => {
                //                 // console.log(result.value);
                //                 if (result.value) {
                //                     isGoogleReviewModalShowAlReady = 1;
                //                     onSelectTaskOnTop("google_follow_pg_sec", 13, "google_review_link_url");
                //                 }
                //             });
                //         } else {
                //             onSelectTaskOnTop("google_follow_pg_sec", 13, "google_review_link_url");
                //         }
                //     }
                // }
            });

            $("#website_follow_pg_opt").on("click", function() {
                var task_added_through = $(this).attr("data-task_added_through");
                var is_automatic = $(this).attr("data-is_automatic");
                var is_task_show = $(this).attr("data-is_task_show");
                if(is_automatic==1 && is_task_show==0){
                    showAutoPostMsgPopup(task_added_through);
                }
                else{
                    //   removeDeleteTaskId(14);
                    onSelectTaskOnTop("website_follow_pg_sec", 14, "visit_page_url_url");
                }
            });
        });

        function showAutoPostMsgPopup(task_added_through){
            if(task_added_through=="Offer Post"){
                swal.fire({
                    text: 'This task will be added after offer post to social medial from social post',
                    icon: 'warning',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Go to social post!',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Close',
                    buttonsStyling: true,
                    showCloseButton: false,
                    showCancelButton: true,
                    focusConfirm: true
                }).then((result) => {
                    if(result.value==true){
                        window.location.href = "{{ route('business.channel.socialPosts', 1) }}";
                    }
                });
            }
            else{
                swal.fire({
                    text: 'This task will be added automatically since you are not connected to social media channels Please go and connect!',
                    icon: 'warning',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Go to connect page!',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Close',
                    buttonsStyling: true,
                    showCloseButton: false,
                    showCancelButton: true,
                    focusConfirm: true
                }).then((result) => {
                    if(result.value==true){
                        sessionStorage.setItem("setting_section", "social_connection");
                        window.location.href = "{{ route('business.settings') }}";
                    }
                });
            }
        }
    </script>
@endsection
