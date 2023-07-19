{{-- TASK --}}
{{-- Classes use with below element(.task-row): --}}
{{-- 1. [verifying] - while task is complete & verifying with media --}}
{{-- 2. [verified] - Task is completed & Verified --}}
{{-- 3. [unverify] - task verification faild --}}
<div class="task-row {{$status}} @if($hide_task) d-none @endif" id="{{$task_attr_id}}">

    <a class="@if($disabled) disabled @else {{ $isNoAppLinkClass }} @endif @if (!$is_completed) task_click @if($redirect_url != "") {{$isNoAppLinkClass}} @endif @endif"
        
        @if (!$is_completed)
            target="_blank"

            @if($isNoAppLinkClass=="" && $task_value=="")
                href="{{ $redirectBaseUrl }}" 
            @elseif($task_key=="google_review_link")
                href="{{ $redirectBaseUrl }}" 
            @endif 

            {{-- @if ($redirect_url != "")
                href="{{$redirect_url}}"
            @endif --}}

            @if($onclick != "") 
                onclick="{{ $onclick }}" 
            @endif

            data-instant_task_id="{{$task_id}}"
            data-task_value="{{$task_value}}"
            data-task_value_browser="{{ $task_value_browser }}"
            data-task_key="{{$task_key}}"

            {{-- ex. for google review --}}
            data-one_extra_field_value="{{ encrypt($one_extra_field_value) }}"
        @endif

        id="{{$clickable_attr_id}}"
    >
        <div class="card in-task">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex justify-content-start align-items-center">
                        <div>
                            {{-- Task icon is the logo of Social media name --}}
                            {{-- send string name in small letters with .svg extention e.g: [instagram.svg] --}}
                            <img src="{{asset('assets/instant_card/imgs/'.$icon)}}" class="task-logo" alt="{{$icon}}">
                        </div>
                        <div>
                            {{-- Name of the task should be in html content --}}
                            <h6 class="task-title">{!! $name !!}
                            
                                @if($isNoAppLinkClass=="" && $task_value=="")
                                    isNoAppLinkClass="{{ $isNoAppLinkClass }}" 
                                    <br/>
                                    task_value="{{ $task_value }}"
                                @endif
                            </h6>
                        </div>
                    </div>

                    {{-- to show status using Ticks --}}
                    @include('instant-challenge.components.ticks', ['id' => $task_attr_id . '_verifying'])

                    {{-- Task Action icon  --}}
                    {{-- Pattern of the icon class:
                    {{-- Use 2 character in capital letters of social media name e.g.: FB, IG, TW, LN, YT, GL(google), WB(website) --}}
                    {{-- action names e.g: like/liked, comment/commented, share/shared, follo/following, review/reviewed, visit/visited, subscribe/subscribed --}}
                    {{-- [use 2 character]-[action name] : class look a like this - [FB-like / FB-liked]--}}
                    <div id="task_icon_status__{{$task_id}}" class="action-icon {{$action_icon}}"></div>
                </div>
            </div>
        </div>
    </a>

    {{-- Verifying Section --}}
    {{-- to show status using card --}}
    {{-- @include('instant-challenge.components.verifying', ['id' => $task_attr_id . '_verifying']) --}}

    {{-- Failed verification --}}
    @include('instant-challenge.components.failed', [
        'id' => $task_attr_id . '_failed',
        'reverify_id' => $task_attr_id . '_failed_reverify_'.$task_key,
    ])

    {{-- Check rigth if verified --}}
    {{-- to show status using card --}}
    {{-- @include('instant-challenge.components.success', ['id' => $task_attr_id . '_verified']) --}}

</div>