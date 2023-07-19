@extends('layouts.admin')
@section('title', 'Admin: Manage Payments')
@section('head')
    @include('layouts.partials.headersection', ['title' => 'Manage Payments'])

    @include('admin.customer.style')

    <style>
        .checkout-bar {
            position: -webkit-sticky;
            position: sticky;
            z-index: 1020;
            bottom: 0;
            width: 100%;
        }

        .lh-1 {
            line-height: 1.5 !important;
        }

        .font-11 {
            font-size: 11px;
        }

        .remove-btn {
            float: right;
            padding: 0px 8px;
            font-size: 10px;
        }
    </style>
@endsection
@section('content')

    <section id="pricing">
        <div class="position-relative">
            <div class="buy-renew">
                <div class="plan_duration_sticky_top sticky-top mb-4">
                    <div class="pricing-nav rounded">
                        <div class="pnav-inner">
                            <div class="container-fluid">
                                <div class="flex-nav justify-content-md-between">
                                    <div class="col-12 col-md-6 px-0">
                                        <div class="scroll-btns d-flex">
                                            <a href="#RenewApps"
                                                class="scrolly btn btn-sm btn-outline-primary px-2 mr-1">Channels</a>
                                            <a href="#Users"
                                                class="scrolly btn btn-sm btn-outline-primary px-2 mr-1">Users</a>
                                            <a href="#RechargePlans"
                                                class="scrolly btn btn-sm btn-outline-primary px-2">Message Plans</a>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="package-duration-cell">
                                            <div class="d-flex justify-content-center justify-content-md-end">

                                                @forelse($plans as $plan)
                                                    <div class="price-duration-box">
                                                        <label for="in_id_{{ $plan->slug }}"
                                                            class="pt-check-box @if ($plan->slug == 'monthly') text-center @endif ">
                                                            <input type="radio" id="in_id_{{ $plan->slug }}"
                                                                data-name="{{ $plan->name }}" name="pkg_duration"
                                                                value="{{ $plan->slug }}" class="custom-switch-input"
                                                                @if ($plan->is_default == 1) checked @endif>
                                                            <label for="in_id_{{ $plan->slug }}">
                                                            </label>

                                                            @if ($plan->discount > 0)
                                                                <span class="badge-save">Save 20%</span>
                                                            @endif

                                                        </label>
                                                        <label for="in_id_{{ $plan->slug }}" class="heads">
                                                            <span>{{ $plan->name }}</span>
                                                        </label>

                                                        @php
                                                            $multiple = 1;
                                                            if ($plan->is_default == 1) {
                                                                $multiple = $plan->months;
                                                            }
                                                        @endphp
                                                    </div>
                                                @empty
                                                    -
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Renew And Buy Both tabs start --}}
                <div class="position-relative" style="z-index: 1;">
                    {{-- Channles --}}
                    <div id="RenewApps">
                        <div class="card">
                            <div class="card-header sticky-top price-top justify-content-between">
                                <h4 class="text-primary">My Channels</h4>
                                <div class="text-right">
                                    <h6 class="mb-0">&#8377;<span id="paidChannelPrice" class="font-weight-bold">0</span>
                                    </h6>
                                    <p class="mb-0 small lh-normal">Payable Amount</p>
                                </div>
                            </div>
                            <div class="card-body px-0 py-0 ">
                                <div class="list_of_feat">
                                    @forelse($paidChannels as $p_channel)
                                        @php
                                            $now = \Carbon\Carbon::now()->format('Y-m-d');
                                            if ($p_channel->admin_user_channel->will_expire_on >= $now) {
                                                $status = 'Active';
                                                $status_badge = 'badge-success';
                                            } else {
                                                $status = 'Expired';
                                                $status_badge = 'badge-danger';
                                            }
                                        @endphp
                                        <div class="feature_row">
                                            <div class="inner">
                                                <div class="feature_flex">
                                                    <div class="f-col d-flex pb-3 pb-sm-0">
                                                        <div class="ftr_flx_check text-sm-center">
                                                            <div class="custom-checkbox custom-control"
                                                                style="@if ($p_channel->price <= 0) visibility:hidden @endif">

                                                                @if (\Carbon\Carbon::now()->format('Y-m-d') >=
                                                                    \Carbon\Carbon::parse($p_channel->admin_user_channel->will_expire_on)->subDays($renew_info->value)->format('Y-m-d'))
                                                                    <input type="checkbox"
                                                                        class="custom-control-input renew-channel"
                                                                        id="checkbox_{{ $p_channel->id }}">
                                                                    <label for="checkbox_{{ $p_channel->id }}"
                                                                        class="custom-control-label"></label>
                                                                @else
                                                                    <input type="checkbox"
                                                                        class="custom-control-input renew-channel"
                                                                        id="checkbox_{{ $p_channel->id }}" disabled>
                                                                    <label for="checkbox_{{ $p_channel->id }}"
                                                                        class="custom-control-label" data-toggle="tooltip"
                                                                        data-placement="top"
                                                                        title="Can Renew After {{ \Carbon\Carbon::parse($p_channel->admin_user_channel->will_expire_on)->subDays($renew_info->value)->format('d M Y') }}"></label>
                                                                @endif
                                                            </div>

                                                            {{-- Price --}}
                                                            <input type="hidden"
                                                                name="renew_channel_price_{{ $p_channel->id }}"
                                                                value="{{ $p_channel->price }}" />
                                                        </div>
                                                        <div class="ftr_flx_title">
                                                            <div class="pr-md-4">
                                                                <h6 data-toggle="collapse"
                                                                    data-target="#collapse_paid_{{ $p_channel->slug }}">
                                                                    <span
                                                                        id="channel_name{{ $p_channel->id }}">{{ $p_channel->name }}</span>
                                                                    <span>
                                                                        <span><i
                                                                                class="fas fa-chevron-down ml-3"></i></span>
                                                                    </span>

                                                                    @if (\Carbon\Carbon::now()->format('Y-m-d') >
                                                                        \Carbon\Carbon::parse($p_channel->admin_user_channel->will_expire_on)->format('Y-m-d'))
                                                                        <p class="mb-0" style="font-size: 11px;">( Expired
                                                                            on
                                                                            <b>{{ \Carbon\Carbon::parse($p_channel->admin_user_channel->will_expire_on)->format('d M Y') }}</b>
                                                                            )
                                                                        </p>
                                                                    @elseif(\Carbon\Carbon::now()->format('Y-m-d') <
                                                                        \Carbon\Carbon::parse($p_channel->admin_user_channel->will_expire_on)->format('Y-m-d'))
                                                                        <p class="mb-0" style="font-size: 11px;">( Will
                                                                            Expire on
                                                                            <b>{{ \Carbon\Carbon::parse($p_channel->admin_user_channel->will_expire_on)->format('d M Y') }}</b>
                                                                            )
                                                                        </p>
                                                                    @else
                                                                        <p class="mb-0" style="font-size: 11px;">( Will
                                                                            Expire <b>Today</b> )</p>
                                                                    @endif


                                                                </h6>
                                                                <div class="collapse"
                                                                    id="collapse_paid_{{ $p_channel->slug }}">
                                                                    <div class="">
                                                                        <p class="font_90 lh-normal c-dul">
                                                                            {{ $p_channel->description }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="f-col">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="pr-4">
                                                                <div class="badge {{ $status_badge }}">{{ $status }}
                                                                </div>
                                                            </div>

                                                            <div class="text-right" style="width: 100px;">

                                                                @if ($p_channel->price <= 0)
                                                                    <h6 class="mb-0 ">FREE</h6>
                                                                    <p class="mb-0 including_gst lh-normal"><small>For
                                                                            Now</small></p>
                                                                @else
                                                                    <h6 class="mb-0 ">&#8377;<span
                                                                            id="paidChannel{{ $p_channel->id }}">{{ $p_channel->price * $multiple }}</span>
                                                                    </h6>
                                                                    <p class="mb-0 including_gst lh-normal"><small>Including
                                                                            GST</small></p>
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="no_recored text-center py-3">
                                            <h6 class="mb-0">{{ Config::get('constants.no_record_found') }}</h6>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>


                        {{-- Add Channels --}}

                        @if (count($unpaidChannels) > 0)
                            <div class="card">
                                <div class="card-header sticky-top price-top justify-content-between"
                                    style="background-color: #ebfff0!important;">
                                    <h4 class="text-success">Add Channels</h4>
                                    <div class="text-right">
                                        <h6 class="mb-0">&#8377;<span id="unpaidChannelPrice"
                                                class="font-weight-bold">0</span></h6>
                                        <p class="mb-0 small lh-normal">Payable Amount</p>
                                    </div>
                                </div>
                                <div class="card-body px-0 py-0 ">
                                    <div class="list_of_feat">

                                        @forelse($unpaidChannels as $unp_channel)
                                            <div class="feature_row" id="row_openlink_api">
                                                <div class="inner">
                                                    <div class="feature_flex">
                                                        <div class="f-col d-flex pb-3 pb-sm-0">
                                                            <div class="ftr_flx_check text-sm-center">
                                                                <div class="custom-checkbox custom-control">
                                                                    <input type="checkbox"
                                                                        class="custom-control-input buy-channel"
                                                                        id="checkbox_{{ $unp_channel->id }}">
                                                                    <label for="checkbox_{{ $unp_channel->id }}"
                                                                        class="custom-control-label"></label>

                                                                    {{-- Price --}}
                                                                    <input type="hidden"
                                                                        name="buy_channel_price_{{ $unp_channel->id }}"
                                                                        value="{{ $unp_channel->price }}" />
                                                                </div>
                                                            </div>
                                                            <div class="ftr_flx_title">
                                                                <div class="pr-md-4">
                                                                    <h6 data-toggle="collapse"
                                                                        data-target="#collapse_renew_{{ $unp_channel->slug }}">
                                                                        <span
                                                                            id="channel_name{{ $unp_channel->id }}">{{ $unp_channel->name }}</span>
                                                                        <span>
                                                                            <span><i
                                                                                    class="fas fa-chevron-down ml-3"></i></span>
                                                                        </span>
                                                                    </h6>
                                                                    <div class="collapse"
                                                                        id="collapse_renew_{{ $unp_channel->slug }}">
                                                                        <div class="">
                                                                            <p class="font_90 lh-normal c-dul">
                                                                                {{ $unp_channel->description }}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="f-col">
                                                            <div class="text-right">
                                                                <h6 class="mb-0 ">&#8377;<span
                                                                        id="unpaidChannel{{ $unp_channel->id }}">{{ $unp_channel->price * $multiple }}</span>
                                                                </h6>
                                                                <p class="mb-0 including_gst lh-normal"><small>Including
                                                                        GST</small></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="no_recored text-center py-3">
                                                <h6 class="mb-0">{{ Config::get('constants.no_record_found') }}</h6>
                                            </div>
                                        @endforelse

                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    {{-- Channles END --}}


                    {{-- Users Start --}}
                    <div id="Users">
                        <div class="card">
                            <div class="card-header sticky-top price-top justify-content-between"
                                style="background-color: #fff4f4 !important;">
                                <h4 style="color: #8b177f;">My Users</h4>
                                <div class="text-right">
                                    <h6 class="mb-0">&#8377;<span id="usersPrice" class="font-weight-bold">0</span>
                                    </h6>
                                    <p class="mb-0 small lh-normal">Payable Amount</p>

                                    <input type="hidden" name="user_count" id="user_count" value="" />
                                    <input type="hidden" name="main_user_price" id="main_user_price"
                                        value="{{ $employee_price->value }}" />
                                    <input type="hidden" name="per_user_price" id="per_user_price"
                                        value="{{ $employee_price->value * $multiple }}" />
                                </div>
                            </div>
                            <div class="card-body px-0 py-0 ">
                                <div class="list_of_feat">
                                    @forelse($users as $user)
                                        @php
                                            $now = \Carbon\Carbon::now()->format('Y-m-d');
                                            if ($user->will_expire_on >= $now) {
                                                $status = 'Active';
                                                $status_badge = 'badge-success';
                                            } else {
                                                $status = 'Expired';
                                                $status_badge = 'badge-danger';
                                            }
                                        @endphp

                                        <div class="feature_row">
                                            <div class="inner">
                                                <div class="feature_flex align-items-center">
                                                    <div class="f-col d-flex pb-3 pb-sm-0">
                                                        <div class="ftr_flx_check text-sm-center">

                                                            <div class="custom-checkbox custom-control"
                                                                style="@if ($user->is_free == 1) visibility:hidden @endif">

                                                                @if (\Carbon\Carbon::now()->format('Y-m-d') >=
                                                                    \Carbon\Carbon::parse($user->will_expire_on)->subDays($renew_info->value)->format('Y-m-d'))
                                                                    <input type="checkbox" name="user_checkbox[]"
                                                                        class="custom-control-input user-checkbox"
                                                                        id="userCheckbox_{{ $user->id }}"
                                                                        value="{{ $user->id }}" />
                                                                    <label for="userCheckbox_{{ $user->id }}"
                                                                        class="custom-control-label"></label>
                                                                @else
                                                                    <input type="checkbox" name="user_checkbox[]"
                                                                        class="custom-control-input user-checkbox"
                                                                        id="userCheckbox_{{ $user->id }}"
                                                                        value="{{ $user->id }}" disabled />
                                                                    <label for="userCheckbox_{{ $user->id }}"
                                                                        class="custom-control-label" data-toggle="tooltip"
                                                                        data-placement="top"
                                                                        title="Can Renew After {{ \Carbon\Carbon::parse($user->will_expire_on)->subDays($renew_info->value)->format('d M Y') }}"></label>
                                                                @endif




                                                            </div>
                                                        </div>
                                                        <div class="ftr_flx_title">
                                                            <div class="pr-md-4">

                                                                @php
                                                                    $name = 'User';
                                                                    if ($user->employee) {
                                                                        $name = $user->employee->name;
                                                                    }
                                                                    
                                                                @endphp

                                                                <input type="hidden" name="user_name{{ $user->id }}"
                                                                    class="custom-control-input user-checkbox"
                                                                    id="user_name{{ $user->id }}"
                                                                    value="{{ $name }}">

                                                                <h6>
                                                                    {{ $name }}

                                                                    @if (\Carbon\Carbon::now()->format('Y-m-d') > \Carbon\Carbon::parse($user->will_expire_on)->format('Y-m-d'))
                                                                        <p class="mb-0 font-11"
                                                                            style="@if ($user->is_free == 1) visibility:hidden @endif">
                                                                            (Expired on
                                                                            <b>{{ \Carbon\Carbon::parse($user->will_expire_on)->format('d M Y') }}</b>)
                                                                        </p>
                                                                    @elseif(\Carbon\Carbon::now()->format('Y-m-d') < \Carbon\Carbon::parse($user->will_expire_on)->format('Y-m-d'))
                                                                        <p class="mb-0 font-11"
                                                                            style="@if ($user->is_free == 1) visibility:hidden @endif">
                                                                            ( Will Expire on
                                                                            <b>{{ \Carbon\Carbon::parse($user->will_expire_on)->format('d M Y') }}</b>
                                                                            )
                                                                        </p>
                                                                    @else
                                                                        <p class="mb-0 font-11"
                                                                            style="@if ($user->is_free == 1) visibility:hidden @endif">
                                                                            ( Will Expire <b>Today</b> )</p>
                                                                    @endif

                                                                </h6>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="f-col">
                                                        <div class="d-flex justify-content-between align-items-center">

                                                            <div class="pr-4">
                                                                <div class="badge {{ $status_badge }}">
                                                                    {{ $status }}</div>
                                                            </div>

                                                            <div class="text-right" style="width: 100px;">

                                                                @if ($user->is_free == 1)
                                                                    <h6 class="mb-0 ">FREE</h6>
                                                                    <p class="mb-0 including_gst lh-normal"><small>With
                                                                            Channel</small></p>
                                                                @else
                                                                    <h6 class="mb-0 ">&#8377;<span
                                                                            class="employee_price">{{ $employee_price->value * $multiple }}</span>
                                                                    </h6>
                                                                    <p class="mb-0 including_gst lh-normal">
                                                                        <small>Including GST</small>
                                                                    </p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="no_recored text-center py-3">
                                            <h6 class="mb-0">{{ Config::get('constants.no_record_found') }}</h6>
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            {{-- Add users --}}
                            <div class="card-footer d-flex justify-content-between align-items-center"
                                style="background-color:#f7fbff !important; border-bottom: none;">
                                {{-- <h6 class="mb-0">Total: &#8377;300<span class="small"> (3*100)</span></h6> --}}
                                <div class="text-right">
                                    <button class="btn btn-sm px-3 btn-primary btn-round" id="openAddUser" data-toggle="modal"
                                        data-target="#userModal"><i class="fa fa-user-plus mr-1"></i>Add Users</button>
                                </div>
                            </div>

                        </div>
                    </div>
                    {{-- users end --}}

                    {{-- Recharge Section Start --}}
                    <div id="RechargePlans">
                        <div class="card">
                            <div class="card-header sticky-top price-top justify-content-between"
                                style="top: 0px; background-color: rgb(249, 249, 229) !important;">
                                <h4 style="color: #d2d200 !important;">Message Plans</h4>
                                <div class="text-right">
                                    <h6 class="mb-0">&#8377;<span id="messagePrice" class="font-weight-bold">0</span>
                                    </h6>
                                    <p class="mb-0 small lh-normal">Payable Amount</p>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="recharge-list">
                                    <div>
                                        <div class="bg_off_white_recharge ">
                                            <div class="p-3 p-lg-4">
                                                <div class="row align-items-center">

                                                    <div class="col-4 col-md-3 col-lg-3">
                                                        <div><span style="opacity: 0.8;">Messages: </span><br> <span
                                                                class="badge badge-success">{{ $message_plan->total_messages }}
                                                            </span> <small>(Remaining Messages)</small></div>
                                                    </div>
                                                    <div class="col-4 col-md-3 col-lg-3">
                                                        <div><span style="opacity: 0.8;">Validity: </span><br>
                                                            {{ \Carbon\Carbon::parse($message_plan->will_expire_on)->format('d M Y') }}
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- add Recharge --}}
                            <div class="card-footer d-flex justify-content-between align-items-center"
                                style="background-color:#f7fbff !important; border-bottom: none;">
                                {{-- <h6 class="mb-0">Total: &#8377;1600<span class="small"></span></h6> --}}
                                <div class="text-right">
                                    <button class="btn btn-sm px-3 btn-round btn-primary" data-toggle="modal"
                                        data-target="#Message_Modal"><i class="fa fa-comment-alt mr-1"></i>Add
                                        Messages</button>
                                </div>

                            </div>
                        </div>
                    </div>
                    {{-- Recharge Section End --}}

                </div>
                {{-- Renew And Buy Both tabs end --}}
            </div>

            {{-- all the payment calculations --}}
            <div class="checkout-bar">
                <div>
                    <div class="collapse" id="fare_breakup"
                        style="box-shadow: 0 19px 38px rgba(0,0,0,0.30), 0 15px 12px rgba(0,0,0,0.22);">
                        <div class="p-3" style="background: #fbfdff;">

                            {{-- Features / Channels list --}}
                            <table class="table table-sm table-hover" id="cartTable">
                                {{-- Cart Items --}}
                            </table>

                            <table class="table text-right table-sm mb-0" id="paymentTable">
                                {{-- Payment Details --}}
                            </table>

                        </div>
                    </div>
                </div>
                <div class="card" style="box-shadow: 0 1px 10px rgb(0 0 0 / 10%);">
                    <div class="card-body">

                        <div class="row justify-content-between align-items-center">

                            <div class="col-sm-6 col-md-5 col-xl-4 mb-4 mb-sm-0">
                                {{-- Coupon code apply --}}
                                <input type="hidden" name="coupon_type" value="" />
                                <input type="hidden" name="coupon_discount" value="" />

                                <div>
                                    <p class="text-danger mb-1 lh-1">Have a poromo code?</p>
                                </div>
                                <div class="form-group mb-0">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm"
                                            placeholder="Enter the coupon code" name="coupon" id="couponCode"
                                            value="">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary btn-sm px-2" type="button"
                                                id="applyCoupon">Apply</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 text-right">
                                {{-- Payment button --}}
                                <div>
                                    <div class="d-sm-flex align-items-center justify-content-end">
                                        <div class="">
                                            <span class="view_cart_detail"><a href="#">View Purchase
                                                    Details<i class="fas fa-chevron-up"></i></a></span>
                                            <span><a data-toggle="collapse" href="#fare_breakup" aria-expanded="false"
                                                    aria-controls="fare_breakup" style="display: none"
                                                    id="viewCart">View Purchase Details<i
                                                        class="fas fa-chevron-up"></i></a></span>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-end">
                                            <div class="mx-3">
                                                <p class="mb-0 lh-1"><small>Payable Amount</small><br><span
                                                        class="h6">&#8377; <span id="cartTotal">0</span></span></p>

                                                <input type="hidden" name="total_before_discount"
                                                    id="total_before_discount" value="0" />
                                            </div>
                                            <div class="mr-0">

                                                {{-- Form --}}
                                                <form method="POST" action="{{ route('admin.proceedToPay') }}"
                                                    id="subscriptionForm">
                                                    @csrf
                                                    <input type="hidden" name="user_id" value="{{ $id }}" />
                                                    <input type="hidden" name="plan_id" value="" />
                                                    <input type="hidden" name="buy_channels" value="" />
                                                    <input type="hidden" name="renew_channels" value="" />
                                                    <input type="hidden" name="buy_users" value="" />
                                                    <input type="hidden" name="renew_users" value="" />
                                                    <input type="hidden" name="message_plan_id" value="" />
                                                    <input type="hidden" name="total_price" value="" />
                                                    <input type="hidden" name="payble_price" value="" />
                                                    <input type="hidden" name="promocode_amount" value="" />

                                                    <button type="submit" class="btn btn-success px-4" id="proceedToPay"
                                                        disabled>Pay Now</button>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- end payment --}}
        </div>
    </section>

    {{-- modal of Add users  start --}}
    <div class="modal fade" id="userModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
        aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">Add Users</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-between add_user py-1 px-2 align-items-center">
                        <p class="mb-0" id="modalPerUserAmt">Per User (&#8377;{{ $employee_price->value * $multiple }}/-)</p>
                        <div class="item-qty">
                            <button class="qty-count qty-count--minus" data-action="minus" type="button"
                                id="">-</button>
                            <input class="product-qty" type="text" name="product-qty" min="1" max=""
                                value="1" id="" style="width: 50px;" readonly="">
                            <button class="qty-count qty-count--add" data-action="add" type="button"
                                id="">+</button>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h6>Summery</h6>
                        <div class="total_user p-2">
                            <div class="d-flex justify-content-between ">
                                <p> Amount Per User</p>
                                <p class="font-weight-bold" id="modalAmtUserPer"> &#8377;{{ $employee_price->value * $multiple }}</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p> Total User</p>
                                <p class="font-weight-bold" id="modalCountUser">1</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p> Total Payable Amount</p>
                                <div class="text-right">
                                    <p class="mb-0">&#8377;<span id="userTotalPrice"
                                            class="font-weight-bold">{{ $employee_price->value * $multiple }}</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="selectUserPlan">Add User(s)</button>
                </div>
            </div>
        </div>
    </div>
    {{-- modal of Add users end --}}

    {{-- modal of Add message pack start- --}}
    <div class="modal fade add_message_modal" data-backdrop="static" data-keyboard="false" id="Message_Modal"
        tabindex="-1" role="dialog" aria-labelledby="messageModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="messageModalLabel">Add Message Plans</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row select_offer">

                        @forelse($message_plans as $msg_plan)
                            <div class="col-12 col-sm-12 col-md-6 col-lg-4">
                                <div class="options" id="{{ $msg_plan->id }}">
                                    <input type="hidden" name="message_plan_selected" id="message_plan_selected"
                                        value="" />
                                    <input type="hidden" name="message_plan_id" id="message_plan_id" value="" />
                                    <input type="radio" name="option" id="pack_{{ $msg_plan->id }}"
                                        class="radio_button_msg radio_button_cash">

                                    <label class="radio_label cash_label mb-4" for="pack_{{ $msg_plan->id }}">
                                        <div class="card mb-0">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between mb-3">
                                                    <h5 class="text-primary">&#8377; <span
                                                            id="messagePlanPrice{{ $msg_plan->id }}">{{ $msg_plan->price }}</span>
                                                    </h5>
                                                    <div>
                                                        <p class="mb-0" style="line-height:1; opacity: 0.7;">
                                                            <small>Total Messages</small>
                                                        </p>
                                                        <p class="font-weight-bold mb-0"
                                                            id="messagePlanTotalMessage{{ $msg_plan->id }}">
                                                            {{ $msg_plan->messages }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="mb-0" style="line-height:1; opacity: 0.7;">
                                                            <small>Validity</small>
                                                        </p>
                                                        <p class="font-weight-bold mb-0">{{ $msg_plan->validity }}
                                                            {{ $msg_plan->validity_type }}</p>
                                                    </div>
                                                </div>
                                                <div>
                                                    <p class="mb-0" style="line-height: 22px; color: #595959;">
                                                        &#8377;{{ $msg_plan->per_message }} per Messages.Get carry forward
                                                        benefits</p>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        @empty
                            <div class="no_recored text-center py-3">
                                <h6 class="mb-0">{{ Config::get('constants.no_record_found') }}</h6>
                            </div>
                        @endforelse

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="selectMessagePlan">Select Plan</button>
                </div>
            </div>
        </div>
    </div>
    <div class="loader-overlap" style="display: none;" id="loader">
        <div class="d-flex flex-column h-100 align-items-center justify-content-center">
            <div class="spinner-border text-white" style="width: 3rem; height: 3rem;" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
    {{-----modal of Add message pack end-----}}

@endsection
@section('end_body')
    


    <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>

    @include('admin.customer.script')

@endsection
