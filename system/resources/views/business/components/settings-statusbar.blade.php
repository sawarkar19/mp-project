<div id="refresh-status">
<div class="section-header d-block">
    <div class="w-100 d-flex justify-content-between collapsed" data-toggle="collapse" data-target="#settings_status" aria-expanded="false" aria-controls="settings_status">
        <div style="width: calc(100% - 30px);">
            {{-- <p class="mb-0">View and update all your MouthPublicity settings</p> --}}
            <div class="container-fluid pl-0">
                <div class="row align-items-center">
                    @php
                        $columns = 'col-md-3 col-sm-6';
                    @endphp
                    {{-- <div class="{{$columns}}">
                        <div class="d-flex w-100 align-items-center justify-content-center">
                            <div class="progress-cell">
                                <div class="progressed-bar" style="width: {{ $planData['statusbar']['profile']['profile_per'] }}%;"></div>
                                <div class="z-2 d-flex justify-content-start align-items-center w-100">
                                    <div class="progress-icon">
                                        @if($planData['statusbar']['profile']['profile_per']==100)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="#ffcc23" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
                                                <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.146.146 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.163.163 0 0 1-.054.06.116.116 0 0 1-.066.017H1.146a.115.115 0 0 1-.066-.017.163.163 0 0 1-.054-.06.176.176 0 0 1 .002-.183L7.884 2.073a.147.147 0 0 1 .054-.057zm1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566z"/>
                                                <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995z"/>
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="progress-title">Profile</div>
                                </div>
                            </div>
                            <span class="progress-percent">{{ $planData['statusbar']['profile']['profile_per'] }}%</span>
                        </div>
                    </div> --}}
                    <div class="{{$columns}}">
                        <div class="d-flex w-100 align-items-center justify-content-center">
                            <div class="progress-cell">
                                <div class="progressed-bar" style="width: {{ $planData['statusbar']['setting']['setting_per'] }}%;"></div>
                                <div class="z-2 d-flex justify-content-start align-items-center w-100">
                                    <div class="progress-icon">
                                        @if($planData['statusbar']['setting']['setting_per']==100)
                                            {{-- <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                                            </svg> --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" id="check">
                                                <path fill="none" d="M0 0h24v24H0V0z"></path>
                                                <path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.88-11.71L10 14.17l-1.88-1.88c-.39-.39-1.02-.39-1.41 0-.39.39-.39 1.02 0 1.41l2.59 2.59c.39.39 1.02.39 1.41 0L17.3 9.7c.39-.39.39-1.02 0-1.41-.39-.39-1.03-.39-1.42 0z"></path>
                                            </svg>
                                        @else
                                            {{-- <svg xmlns="http://www.w3.org/2000/svg" fill="#ffcc23" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
                                                <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.146.146 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.163.163 0 0 1-.054.06.116.116 0 0 1-.066.017H1.146a.115.115 0 0 1-.066-.017.163.163 0 0 1-.054-.06.176.176 0 0 1 .002-.183L7.884 2.073a.147.147 0 0 1 .054-.057zm1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566z"/>
                                                <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995z"/>
                                            </svg> --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                <path fill="#ffcc23" fill-rule="evenodd" d="M5.06875 2.52286C5.46561 1.83092 6.20233 1.40417 7 1.40417C7.79767 1.40417 8.53439 1.83092 8.93125 2.52286L12.7418 9.16667C12.911 9.46161 13 9.79568 13 10.1357C13 11.2113 12.128 12.0833 11.0524 12.0833H2.94765C1.87199 12.0833 1 11.2113 1 10.1357C1 9.79568 1.08901 9.46161 1.25816 9.16667L5.06875 2.52286ZM7 2.40417C6.56061 2.40417 6.1548 2.63924 5.9362 3.02038L2.12561 9.6642C2.04331 9.8077 2 9.97025 2 10.1357C2 10.6591 2.42428 11.0833 2.94765 11.0833H11.0524C11.5757 11.0833 12 10.6591 12 10.1357C12 9.97025 11.9567 9.8077 11.8744 9.6642L8.0638 3.02038C7.8452 2.63924 7.43939 2.40417 7 2.40417Z" clip-rule="evenodd"></path>
                                                <path fill="#ffcc23" fill-rule="evenodd" d="M7 4.38914C7.27614 4.38914 7.5 4.613 7.5 4.88914V7.51076C7.5 7.7869 7.27614 8.01076 7 8.01076C6.72386 8.01076 6.5 7.7869 6.5 7.51076V4.88914C6.5 4.613 6.72386 4.38914 7 4.38914ZM7 8.99503C7.27614 8.99503 7.5 9.21889 7.5 9.49503V9.73259C7.5 10.0087 7.27614 10.2326 7 10.2326C6.72386 10.2326 6.5 10.0087 6.5 9.73259V9.49503C6.5 9.21889 6.72386 8.99503 7 8.99503Z" clip-rule="evenodd"></path>
                                            </svg>

                                        @endif
                                    </div>
                                    <div class="progress-title">Settings</div>
                                </div>
                            </div>
                            <span class="progress-percent">{{ $planData['statusbar']['setting']['setting_per'] }}%</span>
                        </div>
                    </div>
                    <div class="{{$columns}}">
                        <div class="d-flex w-100 align-items-center justify-content-center">
                            <div class="progress-cell">
                                <div class="progressed-bar" style="width: {{ $planData['statusbar']['social_connect']['social_connect_per'] }}%;"></div>
                                <div class="z-2 d-flex justify-content-start align-items-center w-100">
                                    <div class="progress-icon">
                                        @if($planData['statusbar']['social_connect']['social_connect_per']==100)
                                            {{-- <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                                            </svg> --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" id="check">
                                                <path fill="none" d="M0 0h24v24H0V0z"></path>
                                                <path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.88-11.71L10 14.17l-1.88-1.88c-.39-.39-1.02-.39-1.41 0-.39.39-.39 1.02 0 1.41l2.59 2.59c.39.39 1.02.39 1.41 0L17.3 9.7c.39-.39.39-1.02 0-1.41-.39-.39-1.03-.39-1.42 0z"></path>
                                            </svg>
                                        @else
                                            {{-- <svg xmlns="http://www.w3.org/2000/svg" fill="#ffcc23" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
                                                <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.146.146 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.163.163 0 0 1-.054.06.116.116 0 0 1-.066.017H1.146a.115.115 0 0 1-.066-.017.163.163 0 0 1-.054-.06.176.176 0 0 1 .002-.183L7.884 2.073a.147.147 0 0 1 .054-.057zm1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566z"/>
                                                <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995z"/>
                                            </svg> --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                <path fill="#ffcc23" fill-rule="evenodd" d="M5.06875 2.52286C5.46561 1.83092 6.20233 1.40417 7 1.40417C7.79767 1.40417 8.53439 1.83092 8.93125 2.52286L12.7418 9.16667C12.911 9.46161 13 9.79568 13 10.1357C13 11.2113 12.128 12.0833 11.0524 12.0833H2.94765C1.87199 12.0833 1 11.2113 1 10.1357C1 9.79568 1.08901 9.46161 1.25816 9.16667L5.06875 2.52286ZM7 2.40417C6.56061 2.40417 6.1548 2.63924 5.9362 3.02038L2.12561 9.6642C2.04331 9.8077 2 9.97025 2 10.1357C2 10.6591 2.42428 11.0833 2.94765 11.0833H11.0524C11.5757 11.0833 12 10.6591 12 10.1357C12 9.97025 11.9567 9.8077 11.8744 9.6642L8.0638 3.02038C7.8452 2.63924 7.43939 2.40417 7 2.40417Z" clip-rule="evenodd"></path>
                                                <path fill="#ffcc23" fill-rule="evenodd" d="M7 4.38914C7.27614 4.38914 7.5 4.613 7.5 4.88914V7.51076C7.5 7.7869 7.27614 8.01076 7 8.01076C6.72386 8.01076 6.5 7.7869 6.5 7.51076V4.88914C6.5 4.613 6.72386 4.38914 7 4.38914ZM7 8.99503C7.27614 8.99503 7.5 9.21889 7.5 9.49503V9.73259C7.5 10.0087 7.27614 10.2326 7 10.2326C6.72386 10.2326 6.5 10.0087 6.5 9.73259V9.49503C6.5 9.21889 6.72386 8.99503 7 8.99503Z" clip-rule="evenodd"></path>
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="progress-title">Social Connect</div>
                                </div>
                            </div>
                            <span class="progress-percent">{{ $planData['statusbar']['social_connect']['social_connect_per'] }}%</span>
                        </div>
                    </div>
                    <div class="{{$columns}}">
                        <div class="d-flex w-100 align-items-center justify-content-center">
                            <div class="progress-cell">
                                <div class="progressed-bar" style="width: {{ $planData['statusbar']['challenge_setting']['challenge_setting_per'] }}%;"></div>
                                <div class="z-2 d-flex justify-content-start align-items-center w-100">
                                    <div class="progress-icon">
                                        @if($planData['statusbar']['challenge_setting']['challenge_setting_per']==100)
                                            {{-- <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                                            </svg> --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" id="check">
                                                <path fill="none" d="M0 0h24v24H0V0z"></path>
                                                <path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.88-11.71L10 14.17l-1.88-1.88c-.39-.39-1.02-.39-1.41 0-.39.39-.39 1.02 0 1.41l2.59 2.59c.39.39 1.02.39 1.41 0L17.3 9.7c.39-.39.39-1.02 0-1.41-.39-.39-1.03-.39-1.42 0z"></path>
                                            </svg>
                                        @else
                                            {{-- <svg xmlns="http://www.w3.org/2000/svg" fill="#ffcc23" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
                                                <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.146.146 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.163.163 0 0 1-.054.06.116.116 0 0 1-.066.017H1.146a.115.115 0 0 1-.066-.017.163.163 0 0 1-.054-.06.176.176 0 0 1 .002-.183L7.884 2.073a.147.147 0 0 1 .054-.057zm1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566z"/>
                                                <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995z"/>
                                            </svg> --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                <path fill="#ffcc23" fill-rule="evenodd" d="M5.06875 2.52286C5.46561 1.83092 6.20233 1.40417 7 1.40417C7.79767 1.40417 8.53439 1.83092 8.93125 2.52286L12.7418 9.16667C12.911 9.46161 13 9.79568 13 10.1357C13 11.2113 12.128 12.0833 11.0524 12.0833H2.94765C1.87199 12.0833 1 11.2113 1 10.1357C1 9.79568 1.08901 9.46161 1.25816 9.16667L5.06875 2.52286ZM7 2.40417C6.56061 2.40417 6.1548 2.63924 5.9362 3.02038L2.12561 9.6642C2.04331 9.8077 2 9.97025 2 10.1357C2 10.6591 2.42428 11.0833 2.94765 11.0833H11.0524C11.5757 11.0833 12 10.6591 12 10.1357C12 9.97025 11.9567 9.8077 11.8744 9.6642L8.0638 3.02038C7.8452 2.63924 7.43939 2.40417 7 2.40417Z" clip-rule="evenodd"></path>
                                                <path fill="#ffcc23" fill-rule="evenodd" d="M7 4.38914C7.27614 4.38914 7.5 4.613 7.5 4.88914V7.51076C7.5 7.7869 7.27614 8.01076 7 8.01076C6.72386 8.01076 6.5 7.7869 6.5 7.51076V4.88914C6.5 4.613 6.72386 4.38914 7 4.38914ZM7 8.99503C7.27614 8.99503 7.5 9.21889 7.5 9.49503V9.73259C7.5 10.0087 7.27614 10.2326 7 10.2326C6.72386 10.2326 6.5 10.0087 6.5 9.73259V9.49503C6.5 9.21889 6.72386 8.99503 7 8.99503Z" clip-rule="evenodd"></path>
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="progress-title">Challenges Setting</div>
                                </div>
                            </div>
                            <span class="progress-percent">{{ $planData['statusbar']['challenge_setting']['challenge_setting_per'] }}%</span>
                        </div>
                    </div>
                    <div class="{{$columns}}">
                        <div class="d-flex w-100 align-items-center justify-content-center">
                            <div class="progress-cell">
                                <div class="progressed-bar" style="width: {{ $planData['statusbar']['personalised_msg']['personalised_msg_per'] }}%;"></div>
                                <div class="z-2 d-flex justify-content-start align-items-center w-100">
                                    <div class="progress-icon">
                                        @if($planData['statusbar']['personalised_msg']['personalised_msg_per']==100)
                                            {{-- <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                                            </svg> --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" id="check">
                                                <path fill="none" d="M0 0h24v24H0V0z"></path>
                                                <path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.88-11.71L10 14.17l-1.88-1.88c-.39-.39-1.02-.39-1.41 0-.39.39-.39 1.02 0 1.41l2.59 2.59c.39.39 1.02.39 1.41 0L17.3 9.7c.39-.39.39-1.02 0-1.41-.39-.39-1.03-.39-1.42 0z"></path>
                                            </svg>
                                        @else
                                            {{-- <svg xmlns="http://www.w3.org/2000/svg" fill="#ffcc23" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
                                                <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.146.146 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.163.163 0 0 1-.054.06.116.116 0 0 1-.066.017H1.146a.115.115 0 0 1-.066-.017.163.163 0 0 1-.054-.06.176.176 0 0 1 .002-.183L7.884 2.073a.147.147 0 0 1 .054-.057zm1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566z"/>
                                                <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995z"/>
                                            </svg> --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                <path fill="#ffcc23" fill-rule="evenodd" d="M5.06875 2.52286C5.46561 1.83092 6.20233 1.40417 7 1.40417C7.79767 1.40417 8.53439 1.83092 8.93125 2.52286L12.7418 9.16667C12.911 9.46161 13 9.79568 13 10.1357C13 11.2113 12.128 12.0833 11.0524 12.0833H2.94765C1.87199 12.0833 1 11.2113 1 10.1357C1 9.79568 1.08901 9.46161 1.25816 9.16667L5.06875 2.52286ZM7 2.40417C6.56061 2.40417 6.1548 2.63924 5.9362 3.02038L2.12561 9.6642C2.04331 9.8077 2 9.97025 2 10.1357C2 10.6591 2.42428 11.0833 2.94765 11.0833H11.0524C11.5757 11.0833 12 10.6591 12 10.1357C12 9.97025 11.9567 9.8077 11.8744 9.6642L8.0638 3.02038C7.8452 2.63924 7.43939 2.40417 7 2.40417Z" clip-rule="evenodd"></path>
                                                <path fill="#ffcc23" fill-rule="evenodd" d="M7 4.38914C7.27614 4.38914 7.5 4.613 7.5 4.88914V7.51076C7.5 7.7869 7.27614 8.01076 7 8.01076C6.72386 8.01076 6.5 7.7869 6.5 7.51076V4.88914C6.5 4.613 6.72386 4.38914 7 4.38914ZM7 8.99503C7.27614 8.99503 7.5 9.21889 7.5 9.49503V9.73259C7.5 10.0087 7.27614 10.2326 7 10.2326C6.72386 10.2326 6.5 10.0087 6.5 9.73259V9.49503C6.5 9.21889 6.72386 8.99503 7 8.99503Z" clip-rule="evenodd"></path>
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="progress-title">Personalised Messaging</div>
                                </div>
                            </div>
                            <span class="progress-percent">{{ $planData['statusbar']['personalised_msg']['personalised_msg_per'] }}%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a href="javascript:void(0)" style="width: 30px;" class="text-decoration-none text-center d-flex justify-content-center align-items-center"><i class="fa fa-chevron-down" style="font-size: 1.2rem;line-height:1;"></i></a>
    </div>

    <div class="w100-30 collapse" id="settings_status">
        <div class="container-fluid pl-0">
            <div class="row">
                {{-- PROFILE | COLUMN --}}
                {{-- <div class="{{$columns}}">
                    <div class="py-3">
                        <div class="mb-2">
                            <h6 class="text-primary d-md-none">Profile</h6>
                        </div>
                        <div>
                            <ul class="settings-status-list">
                                <li>
                                    <a href="{{ route('business.profileSettings') }}" class="@if($planData['statusbar']['profile']['details']==1) done @else pending @endif">
                                        <span>Profile Details</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('business.profileSettings') }}" class="@if($planData['statusbar']['profile']['reg_number']==1) done @else pending @endif">
                                        <span>Registered Number</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div> --}}

                {{-- SETTINGS | COLUMN --}}
                <div class="{{$columns}}">
                    <div class="py-3">
                        <div class="mb-2">
                            <h6 class="text-primary d-md-none">Settings</h6>
                        </div>
                        <div>
                            <ul class="settings-status-list">
                                <li>
                                    <a href="javascript:void(0)" class="@if($planData['statusbar']['setting']['business_details']==1) done @else pending @endif redirectOnClick" data-tabname="business_details">
                                        <span>Business Details</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" class="@if($planData['statusbar']['setting']['business_contact']==1) done @else pending @endif redirectOnClick" data-tabname="business_contact">
                                        <span>Business Contact</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" class="@if($planData['statusbar']['setting']['business_address']==1) done @else pending @endif redirectOnClick" data-tabname="billing_address">
                                        <span>Billing Address</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" class="@if($planData['statusbar']['setting']['social_link']==1) done @else pending @endif redirectOnClick" data-tabname="social_link">
                                        <span>Social Links</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" class="@if($planData['statusbar']['setting']['whatsapp_setting']==1) done @else pending @endif redirectOnClick" data-tabname="whatsapp_setting">
                                        <span>WhatsApp Setting</span>
                                    </a>
                                </li>


                                <li>
                                    <a href="javascript:void(0)" class="@if($planData['statusbar']['setting']['message_route']==1) done @else pending @endif redirectOnClick" data-tabname="message_route">
                                        <span>Message Routes</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" class="@if($planData['statusbar']['setting']['vcard_setting']==1) done @else pending @endif redirectOnClick" data-tabname="vcard_setting">
                                        <span>V-Card/Website</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" class="@if($planData['statusbar']['setting']['notification_setting']==1) done @else pending @endif redirectOnClick" data-tabname="notification_setting">
                                        <span>Notifications</span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>

                {{-- SOCIAL CONNECT | COLUMN --}}
                <div class="{{$columns}}">
                    <div class="py-3">
                        <div class="mb-2">
                            <h6 class="text-primary d-md-none">Social Connect</h6>
                        </div>
                        <div>
                            <ul class="settings-status-list">
                                <li>
                                    <a href="javascript:void(0)" class="@if($planData['statusbar']['social_connect']['facebook']==1) done @else pending @endif redirectOnClick" data-tabname="social_connection">
                                        <span>Facebook</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" class="@if($planData['statusbar']['social_connect']['instagram']==1) done @else pending @endif redirectOnClick" data-tabname="social_connection">
                                        <span>Instagram</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" class="@if($planData['statusbar']['social_connect']['twitter']==1) done @else pending @endif redirectOnClick" data-tabname="social_connection">
                                        <span>Twitter</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" class="@if($planData['statusbar']['social_connect']['linkedin']==1) done @else pending @endif redirectOnClick" data-tabname="social_connection">
                                        <span>LinkedIn</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" class="@if($planData['statusbar']['social_connect']['youtube']==1) done @else pending @endif redirectOnClick" data-tabname="social_connection">
                                        <span>Youtube</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" class="@if($planData['statusbar']['social_connect']['google']==1) done @else pending @endif redirectOnClick" data-tabname="social_connection">
                                        <span>Google</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- CHALLENGES SETTING | COLUMN --}}
                <div class="{{$columns}}">
                    <div class="py-3">
                        <div class="mb-2">
                            <h6 class="text-primary d-md-none">Challenges Setting</h6>
                        </div>
                        <div>
                            <ul class="settings-status-list">
                                <li>
                                    <a href="{{ route('business.channel.instantRewards', 2) }}" class="@if($planData['statusbar']['challenge_setting']['instant_challenge']==1) done @else pending @endif">
                                        <span>Instant Challenge</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('business.channel.shareAndReward', 3) }}" class="@if($planData['statusbar']['challenge_setting']['shared_challenge']==1) done @else pending @endif">
                                        <span>Share Challenge</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('business.channel.shareAndReward', 3) }}" class="@if($planData['statusbar']['challenge_setting']['auto_shared_challenge_setting']==1) done @else pending @endif">
                                        <span>Auto Share Settings</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- PERSONALISED MESSAGE | COLUMN --}}
                <div class="{{$columns}}">
                    <div class="py-3">
                        <div class="mb-2">
                            <h6 class="text-primary d-md-none">Personalised Messaging</h6>
                        </div>
                        <div>
                            <ul class="settings-status-list">
                                <li>
                                    <a href="{{ route('business.channel.personalisedMessage', 5) }}" class="@if($planData['statusbar']['personalised_msg']['share_new_offer']==1) done @else pending @endif">
                                        <span>Share New Offers</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('business.channel.personalisedMessage', 5) }}" class="@if($planData['statusbar']['personalised_msg']['dob']==1) done @else pending @endif">
                                        <span>Birthday Greeting</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('business.channel.personalisedMessage', 5) }}" class="@if($planData['statusbar']['personalised_msg']['anni']==1) done @else pending @endif">
                                        <span>Anniversary Greeting</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
</div>