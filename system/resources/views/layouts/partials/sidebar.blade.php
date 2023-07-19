@php
    $role_id = Auth::User()->role_id;
    $role = \DB::table('roles')->where('id', $role_id)->first()->role;

    $business = false;
    if($role_id == 2) {
        /* if user is Admin of the business */
        $business = \DB::table('business_details')->where('user_id', Auth::User()->id)->first();
    }
    elseif ($role_id == 3) {
        /* if user is Employee of the Business */
        $business = \DB::table('business_details')->where('user_id', Auth::User()->created_by)->first();
    }
@endphp
<div class="main-sidebar">
    <aside id="sidebar-wrapper" class="business-sidebar-wrapper sidebar-wraper-flex">
        
        @if ($business)
        {{-- customer logo --}}
        <div class="sidebar-brand sidebar-customer-logo">
            <a href="{{ route($role.'.dashboard') }}" class="sidebar-logo-sec">
                <div class="d-flex align-items-center business-detail-sec"> 
                    @if ($business->logo != '')
                    <div class="sidebar-logo-round">
                        <img src="{{ asset('assets/business/logos/'.$business->logo) }}" class="sidebar-logo" id="img" alt="{{$business->business_name}}">
                    </div>
                    @endif
                    <div class="customer-logo flex-fill">
                        <h6 id="text" class="customer-logo-text text-left px-2 m-0">{{$business->business_name}}</h6>
                    </div>
                </div>
                
            </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm sidebar-brand-sm-height">
            <a href="{{ route($role.'.dashboard') }}" class="sidebar-logo-sec">
                @if ($business->logo != '')
                <div class="sidebar-logo-round">
                    <img src="{{ asset('assets/business/logos/'.$business->logo) }}" id="img" alt="{{$business->business_name}}">
                </div>
                @else
                <div class="customer-logo">
                    <h6 id="text" class="customer-logo-text text-left px-2 m-0">{{$business->business_name}}</h6>
                </div>
                @endif
            </a>
        </div>
        @endif

        @if($business == false)

            @if($role_id == 1)
                <div class="sidebar-brand sidebar-customer-logo">
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-logo-sec">
                        <div class="d-flex align-items-center"> 
                            <div class="customer-logo flex-fill">
                                <h6 id="text" class="customer-logo-text text-left px-2 m-0">Superadmin</h6>
                            </div>
                        </div>
                        
                    </a>
                </div>
                <div class="sidebar-brand sidebar-brand-sm sidebar-brand-sm-height">
                    <a href="{{ route('admin.dashboard') }}">
                        <div class="customer-logo">
                            <h6 id="text" class="customer-logo-text text-left px-2 m-0">SA</h6>
                        </div>
                    </a>
                </div>
            @endif
            
            @if($role_id == 4)
                <div class="sidebar-brand sidebar-customer-logo">
                    <a href="{{ route('seo.dashboard') }}" class="sidebar-logo-sec">
                        <div class="d-flex align-items-center"> 
                            <div class="customer-logo flex-fill">
                                <h6 id="text" class="customer-logo-text text-left px-2 m-0">SEO Manager</h6>
                            </div>
                        </div>
                        
                    </a>
                </div>
                <div class="sidebar-brand sidebar-brand-sm sidebar-brand-sm-height">
                    <a href="{{ route('seo.dashboard') }}">
                        <div class="customer-logo">
                            <h6 id="text" class="customer-logo-text text-left px-2 m-0">SEO Manager</h6>
                        </div>
                    </a>
                </div>
            @endif

            @if($role_id == 5)
                <div class="sidebar-brand sidebar-customer-logo">
                    <a href="{{ route('account.dashboard') }}" class="sidebar-logo-sec">
                        <div class="d-flex align-items-center"> 
                            <div class="customer-logo flex-fill">
                                <h6 id="text" class="customer-logo-text text-left px-2 m-0">Account</h6>
                            </div>
                        </div>
                        
                    </a>
                </div>
                <div class="sidebar-brand sidebar-brand-sm sidebar-brand-sm-height">
                    <a href="{{ route('account.dashboard') }}">
                        <div class="customer-logo">
                            <h6 id="text" class="customer-logo-text text-left px-2 m-0">Account</h6>
                        </div>
                    </a>
                </div>
            @endif

            @if ($role_id == 6)
                <div class="sidebar-brand sidebar-customer-logo">
                    <a href="{{ route('seomanager.dashboard') }}" class="sidebar-logo-sec">
                        <div class="d-flex align-items-center">
                            <div class="customer-logo flex-fill">
                                <h6 id="text" class="customer-logo-text text-left px-2 m-0">SEO Manager</h6>
                            </div>
                        </div>

                    </a>
                </div>
                <div class="sidebar-brand sidebar-brand-sm sidebar-brand-sm-height">
                    <a href="{{ route('seomanager.dashboard') }}">
                        <div class="customer-logo">
                            <h6 id="text" class="customer-logo-text text-left px-2 m-0">SEO</h6>
                        </div>
                    </a>
                </div>
            @endif

            @if($role_id == 7)
                <div class="sidebar-brand sidebar-customer-logo">
                    <a href="{{ route('support.dashboard') }}" class="sidebar-logo-sec">
                        <div class="d-flex align-items-center"> 
                            <div class="customer-logo flex-fill">
                                <h6 id="text" class="customer-logo-text text-left px-2 m-0">Support</h6>
                            </div>
                        </div>
                        
                    </a>
                </div>
                <div class="sidebar-brand sidebar-brand-sm sidebar-brand-sm-height">
                    <a href="{{ route('support.dashboard') }}">
                        <div class="customer-logo">
                            <h6 id="text" class="customer-logo-text text-left px-2 m-0">Support</h6>
                        </div>
                    </a>
                </div>
            @endif

            @if($role_id == 8)
                <div class="sidebar-brand sidebar-customer-logo">
                    <a href="{{ route('designer.dashboard') }}" class="sidebar-logo-sec">
                        <div class="d-flex align-items-center"> 
                            <div class="customer-logo flex-fill">
                                <h6 id="text" class="customer-logo-text text-left px-2 m-0">Designer</h6>
                            </div>
                        </div>
                        
                    </a>
                </div>
                <div class="sidebar-brand sidebar-brand-sm sidebar-brand-sm-height">
                    <a href="{{ route('designer.dashboard') }}">
                        <div class="customer-logo">
                            <h6 id="text" class="customer-logo-text text-left px-2 m-0">Designer</h6>
                        </div>
                    </a>
                </div>
            @endif

            @if($role_id == 9)
                <div class="sidebar-brand sidebar-customer-logo">
                    <a href="{{ route('wacloud.dashboard') }}" class="sidebar-logo-sec">
                        <div class="d-flex align-items-center"> 
                            <div class="customer-logo flex-fill">
                                <h6 id="text" class="customer-logo-text text-left px-2 m-0">WaCloud</h6>
                            </div>
                        </div>
                        
                    </a>
                </div>
                <div class="sidebar-brand sidebar-brand-sm sidebar-brand-sm-height">
                    <a href="{{ route('wacloud.dashboard') }}">
                        <div class="customer-logo">
                            <h6 id="text" class="customer-logo-text text-left px-2 m-0">WaCloud</h6>
                        </div>
                    </a>
                </div>
            @endif

            
        @endif

        <ul class="sidebar-menu flex-fill">
            @if(Auth::user()->role_id==1)
                @include('layouts.partials.roles.admin')
            @elseif(Auth::user()->role_id==2)
                @if(session('current_panel') == 'partner')
                    @include('layouts.partials.roles.partner')
                @else
                    @include('layouts.partials.roles.business')
                @endif
            @elseif(Auth::user()->role_id==3)
                @include('layouts.partials.roles.employee')
            @elseif(Auth::user()->role_id==4)
                @include('layouts.partials.roles.seo')
            @elseif(Auth::user()->role_id==5)
                @include('layouts.partials.roles.account')
            @elseif(Auth::user()->role_id==6)
                @include('layouts.partials.roles.seo-manager')
            @elseif(Auth::user()->role_id==7)
                @include('layouts.partials.roles.support')
            @elseif(Auth::user()->role_id==8)
                @include('layouts.partials.roles.designer')
            @elseif(Auth::user()->role_id==9)
                @include('layouts.partials.roles.wacloud')
            @endif
        </ul>


        {{-- openlink logo --}}
        <div class="sidebar-brand text-center">
            {{-- <a href="{{ url('dashboard') }}">{{ env('APP_NAME') }}</a> --}}
            <a href="{{ url('/') }}" target="_blank"><img src="{{ asset('assets/website/images/logos/portrait-logo-dark.svg') }}" style="width:130px; max-width:100%;"></a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm text-center">
            {{-- <a href="#">{{ Str::limit(env('APP_NAME'), $limit = 1) }}</a> --}}
            <a href="{{ url('/') }}" class="px-0 pt-0 mx-auto" style="width:32px; padding-bottom:5px;" target="_blank"><img src="{{ asset('assets/front/images/logo-icon.png') }}"></a>
        </div>
        
    </aside>
</div>
