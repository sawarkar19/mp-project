@extends('layouts.admin')
@section('title', 'Admin: Manage Payments')
@section('head')
@include('layouts.partials.headersection',['title'=>'Manage Payments'])
  
@include('business.plan.style')

<style>
  .required_input{
    color: red;
  }

  .remove_selection {
      background-color: #bfc6cd !important;
      color: #fff !important;
  }

  .tab_btn a.active {
        box-shadow: 0 2px 6px #e1e5e8 !important;
        background-color: #3131d8 !important;
        border-color: #3131d8 !important;
        color: #fff !important;
  }

  .tab_btn a{
      font-size: 20px !important;
      font-weight: 600;
  }
</style>
@endsection
@section('content')

<div class="row">
  <div class="col-12 mt-2">

    <form id="managePaymentForm" >
          @csrf

    <div class="card">
      <div class="card-body">

          <div class="form-group">
            <label for="user_type">{{ __('Select User Type') }}</label>
            <select name="user_type" class="form-control" id="user_type" required>
              <option value="new" @if($user_id == '') selected @endif >New User</option>
              <option value="old" @if($user_id != '') selected @endif >Existing User</option>
            </select>
          </div>

          {{-- Existing User --}}
          <div class="form-row" id="old_user" @if($user_id == '') style="display:none;" @endif>
              <div class="form-group col-md-12">
                <label for="user_id">{{ __('Select User') }}</label>
                <select name="user_id" class="form-control" id="user_id" required>
                  <option value="">Select User</option>
                    @foreach($old_users as $user)
                      <option value="{{ $user->id }}" @if($user_id == $user->id) selected @endif >{{ $user->name }}</option>
                    @endforeach
                </select>
              </div>
          </div>

          {{-- New User --}}
          <div class="form-row" id="new_user" @if($user_id != '') style="display:none;" @endif>
              <div class="form-group col-md-3">
                <label  for="business_name">{{ __('Name') }}<span class="required_input">*</span></label>
                <input type="text" class="form-control" id="business_name" name="business_name">
              </div>
              
              <div class="form-group col-md-5">
                <label for="business_email">{{ __('Email') }}<span class="required_input">*</span></label>
                <input type="email" class="form-control" id="business_email" name="business_email">
              </div>

              <div class="form-group col-md-4">
                <label for="business_mobile">{{ __('Whatsapp Number') }}<span class="required_input">*</span></label>
                <input type="text" class="form-control" id="business_mobile" name="business_mobile">
              </div>
          </div>


          <hr>


          <div id="content">
            <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
                <li class="tab_btn">
                  <a href="#plan_tab" class="btn btn-secondary btn-lg btn-block active" data-toggle="tab">Default Plan</a>
                </li>
                <li class="tab_btn">
                  <a href="#manual_plan" class="btn btn-secondary btn-lg btn-block" data-toggle="tab">Manual Plan</a>
                </li>
            </ul>

            <hr>

            <div id="my-tab-content" class="tab-content">
                <div class="tab-pane active" id="plan_tab">
                      
                  <div class="buy-renew">
            
                    <div class="plan_duration_sticky_top sticky-top" id="">
                        <div class="pricing-nav rounded">
                            <div class="pnav-inner">
                                <div class="container">
                                    <div class="flex-nav"> 
                                        {{-- /* package duration buttons  */ --}}
                                        <div class="package-duration-cell">
                                            <div class="d-flex justify-content-center">
                                            @foreach($plans as $plan)
                                            @php
                                                if($planInfo && isset($planInfo['selected_plan'])){
                                                    if($planInfo['selected_plan'] == $plan->id){
                                                        $checked = 1;
                                                    }else{
                                                        $checked = 0;
                                                    }
                                                }else{
                                                    if($plan->is_default == 1){
                                                        $checked = 1;
                                                    }else{
                                                        $checked = 0;
                                                    }
                                                }
                                            @endphp

                                            <div class="price-duration-box">
                                                <label for="in_id_{{ $plan->slug }}" class="pt-check-box {{($plan->discount == 0) ? 'text-center' : ''}}">
                                                    <input type="radio" id="in_id_{{ $plan->slug }}" data-name="{{ $plan->name }}" name="pkg_duration" value="{{ $plan->slug }}" class="custom-switch-input change_plan" @if($checked) checked @endif />
                                                    <label for="in_id_{{ $plan->slug }}"></label>
                                                    @if ($plan->discount > 0)
                                                        <span class="badge-save">Save {{round($plan->discount)}}%</span>
                                                    @endif
                                                </label>
                                                <label for="in_id_{{ $plan->slug }}" class="heads">
                                                    <span>{{ $plan->name }}</span>
                                                </label>

                                                <input type="hidden" id="{{ $plan->slug }}_plan_id" name="{{ $plan->slug }}_plan_id" value="{{ $plan->id }}">
                                                <input type="hidden" id="{{ $plan->slug }}_plan_name" name="{{ $plan->slug }}_plan_name" value="{{ $plan->name }}">
                                                <input type="hidden" id="{{ $plan->slug }}_billing_type" name="{{ $plan->slug }}_billing_type" value="{{ $plan->slug }}">
                                            </div>

                                            @endforeach
                                            
                                           </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Renew And Buy Both tabs --}}
                    <div>
                        {{-- Free Apps --}}
                        <div class="">
                            <div class="card">
                                <div class="card-header sticky-top price-top justify-content-between" style="background-color: #fdf0eb!important;">
                                    <h4 class="text-danger">Free Apps</h4>
                                </div>
                                <div class="card-body px-0 py-0 ">

                                    <div class="list_of_feat">
                                        @foreach($freeData as $free_plan)
                                        
                                        @if(in_array($free_plan->feature->id, [1,2]))
                                        
                                        <div class="feature_row @if(in_array($free_plan->feature->id, $disable_plan_ids)) disable_plan @endif "  id="row_{{ $featureKeys[$free_plan->feature->id] }}">
                                            <div class="inner">
                                                <div class="feature_flex">

                                                    {{-- Column One  --}}
                                                    <div class="f-col d-sm-flex pb-3 pb-sm-0">
                                                        
                                                            {{-- Default Checkbox --}}
                                                            <div class="ftr_flx_check text-sm-center">
                                                                <div class="custom-checkbox custom-control">
                                                                    <input type="checkbox" class="custom-control-input" id="default-checkbox" checked disabled />
                                                                    <label for="default-checkbox" class="custom-control-label default-checkbox"></label>
                                                                </div>
                                                            </div>
                                                            {{-- Checkbox END --}}
                                                        

                                                        {{-- Title and text  --}}
                                                        <div class="ftr_flx_title">
                                                            <div class="pr-md-4">
                                                                <h6 data-toggle="collapse" data-target="#collapseBuy_{{ $featureKeys[$free_plan->feature->id] }}" >
                                                                    <span>{{ $free_plan->feature->title }}</span>
                                                                    <span>
                                                                        @if($free_plan->feature->short_description != '') ( {{ $free_plan->feature->short_description }} ) @endif
                                                                    </span>
                                                                    <span><i class="fas fa-chevron-down ml-3"></i></span>
                                                                </h6>
                                                                <div class="collapse" id="collapseBuy_{{ $featureKeys[$free_plan->feature->id] }}">
                                                                    <div class="">
                                                                        <p class="font_90 lh-normal c-dul">{{ $free_plan->feature->description }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- Title and text END --}}
                                                    </div>

                                                    {{-- Price  --}}
                                                    <div class="f-col">
                                                        <div class="d-flex justify-content-between align-items-center">

                                                            <div class="pr-4"></div>

                                                            <div class="text-right">

                                                                <h6 class="mb-0 "><span>FREE</span></h6>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- Price END --}}

                                                </div>
                                            </div>
                                        </div>
                                        
                                        @endif

                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Renew  --}}

                        @if(count($subscriptionData) > 0)
                        <div class="py-5">
                            <div class="card">
                                <div class="card-header sticky-top price-top justify-content-between">
                                    <h4>Renew Apps</h4>
                                    <div class="text-right">
                                        <h6 class="mb-0">&#8377;<span class="font-weight-bold" id="topbar_renew_amount">0</span></h6>
                                        <p class="mb-0 small lh-normal">Payable Amount</p>
                                    </div>
                                </div>
                                <div class="card-body px-0 py-0 ">
                                    <div class="list_of_feat">

                                        @foreach($subscriptionData as $renew_plan)

                                        @if(!in_array($renew_plan->feature->id, [1,2]))

                                            <div class="feature_row">
                                                <div class="inner">
                                                    <div class="feature_flex">

                                                        {{-- Column One  --}}
                                                        <div class="f-col d-sm-flex pb-3 pb-sm-0">
                                                            @if(in_array($renew_plan->feature_id, [6,7]))
                                                                {{-- Default Checkbox --}}
                                                                <div class="ftr_flx_check text-sm-center">
                                                                    <div class="custom-checkbox custom-control">
                                                                        <input type="checkbox" class="custom-control-input" id="default-checkbox" checked disabled />
                                                                        <label for="default-checkbox" class="custom-control-label default-checkbox"></label>
                                                                    </div>
                                                                </div>
                                                                {{-- Checkbox END --}}
                                                            @else
                                                                {{-- Checkbox  --}}
                                                                <div class="ftr_flx_check text-sm-center">
                                                                    <div class="custom-checkbox custom-control">
                                                                        <input type="checkbox" class="custom-control-input  renew_feature renew_feature_{{ $featureKeys[$renew_plan->feature_id] }}" id="renew_input_{{ $featureKeys[$renew_plan->feature_id] }}"  value="{{ $sale_prices[$featureKeys[$renew_plan->feature_id]] }}" 
                                                                             />
                                                                        <label for="renew_input_{{ $featureKeys[$renew_plan->feature_id] }}" class="custom-control-label"></label>
                                                                    </div>
                                                                </div>
                                                                {{-- Checkbox END --}}
                                                            @endif

                                                            {{-- Title and text  --}}
                                                            <div class="ftr_flx_title">
                                                                <div class="pr-md-4">
                                                                    <h6 data-toggle="collapse" data-target="#collapseRenew_{{ $featureKeys[$renew_plan->feature_id] }}" >
                                                                        <span>{{ $renew_plan->feature->title }}</span>
                                                                        <span>
                                                                            @if($renew_plan->feature->short_description != '') ( {{ $renew_plan->feature->short_description }} ) @endif
                                                                        </span>
                                                                        <span><i class="fas fa-chevron-down ml-3"></i></span>

                                                                        @if(!in_array($renew_plan->feature_id, [6,7]))

                                                                        <p class="mb-0" style="font-size: 11px;">( Next Invoice on <b>{{ \Carbon\Carbon::parse($renew_plan->will_expire_on)->format('d F Y') }}</b> )</p>

                                                                        @endif

                                                                    </h6>
                                                                    <div class="collapse" id="collapseRenew_{{ $featureKeys[$renew_plan->feature_id] }}">
                                                                        <div class="">
                                                                            <p class="font_90 lh-normal c-dul">{{ $renew_plan->feature->description }}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{-- Title and text END --}}
                                                        </div>

                                                        {{-- Price  --}}
                                                        <div class="f-col">
                                                            <div class="d-flex justify-content-between align-items-center">

                                                                <div class="pr-4">

                                                                    @if(!in_array($renew_plan->feature_id, [6,7]))

                                                                    @if(\Carbon\Carbon::parse($renew_plan->will_expire_on)->format('Y-m-d') >= \Carbon\Carbon::now()->format('Y-m-d'))
                                                                        <div class="badge badge-success">Active</div>
                                                                    @else
                                                                        <div class="badge badge-danger">Expired</div>
                                                                    @endif

                                                                    @endif

                                                                </div>

                                                                <div class="text-right" style="width: 100px;">

                                                                    @if(!in_array($renew_plan->feature_id, [6,7]))

                                                                        <input type="hidden" id="renew_constant_price_{{ $featureKeys[$renew_plan->feature_id] }}" value="{{ $sale_prices[$featureKeys[$renew_plan->feature->id]] }}">

                                                                        <h6 class="mb-0 ">
                                                                            ₹<span id="renew_sale_price_{{ $featureKeys[$renew_plan->feature_id] }}">{{ $sale_prices[$featureKeys[$renew_plan->feature->id]] }}</span>
                                                                        </h6>
                                                                        <p class="mb-0 including_gst lh-normal"><small>Including GST</small></p>

                                                                    @endif

                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- Price END --}}

                                                    </div>
                                                </div>
                                            </div>


                                            {{-- Employee --}}
                                            @if(count($renew_plan->employees) > 0)
                                            @foreach($renew_plan->employees as $employee)
                                                <div class="feature_row" style="padding-left: 50px !important;">
                                                <div class="inner">
                                                    <div class="feature_flex">

                                                        {{-- Column One  --}}
                                                        <div class="f-col d-sm-flex pb-3 pb-sm-0">
                                                            {{-- Checkbox  --}}
                                                            <div class="ftr_flx_check text-sm-center">
                                                                <div class="custom-checkbox custom-control">
                                                                    <input type="checkbox" class="custom-control-input renew_feature renew_feature_{{ $featureKeys[$renew_plan->feature_id] }}_employee" name="employee_list[]" id="employee_{{ $employee->id }}" value="{{ $sale_prices[$featureKeys[$renew_plan->feature_id]] }}" checked- disabled- />
                                                                    <label for="employee_{{ $employee->id }}" class="custom-control-label"></label>
                                                                </div>
                                                            </div>
                                                            {{-- Checkbox END --}}

                                                            {{-- Title and text  --}}
                                                            <div class="ftr_flx_title">
                                                                <div class="pr-md-4">
                                                                    <h6 data-toggle="collapse" data-target="#collapseBuyFeature_1" >

                                                                        @if($employee->user != '')

                                                                        <span>{{ $employee->user->name }}</span>

                                                                        @else

                                                                        <span>Employee {{ $loop->iteration }}</span>

                                                                        @endif

                                                                        <p class="mb-0" style="font-size: 11px;">( Next Invoice on <b>{{ \Carbon\Carbon::parse($employee->expiry_date)->format('d F Y') }}</b> )</p>
                                                                        
                                                                        {{-- <span><i class="fas fa-chevron-down ml-3"></i></span> --}}
                                                                    </h6>
                                                                    
                                                                </div>
                                                            </div>
                                                            {{-- Title and text END --}}
                                                        </div>

                                                        {{-- Price  --}}
                                                        <div class="f-col">
                                                            <div class="d-flex justify-content-between align-items-center">

                                                                <div class="pr-4">

                                                                    @if(\Carbon\Carbon::parse($employee->expiry_date)->format('Y-m-d') >= \Carbon\Carbon::now()->format('Y-m-d'))
                                                                        <div class="badge badge-success">Active</div>
                                                                    @else
                                                                        <div class="badge badge-danger">Expired</div>
                                                                    @endif
                                                                </div>

                                                                <div class="text-right" style="width:100px">

                                                                    <input type="hidden" id="renew_constant_price_employee_{{ $employee->id }}" value="{{ $sale_prices[$featureKeys[$renew_plan->feature->id]] }}">

                                                                    <h6 class="mb-0 ">₹<span id="renew_sale_price_employee_{{ $employee->id }}">{{ $sale_prices[$featureKeys[$renew_plan->feature->id]] }}</span></h6>
                                                                    <p class="mb-0 including_gst lh-normal"><small>Including GST</small></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- Price END --}}

                                                    </div>
                                                </div>
                                                </div>
                                            @endforeach
                                            @endif
                                        

                                            {{-- Direct Posts --}}
                                            @if(count($renew_plan->direct_posts) > 0)

                                            <input type="hidden" name="direct_posts_count" value="{{ count($renew_plan->direct_posts) }}">

                                                @foreach($renew_plan->direct_posts as $direct_post)
                                                    <div class="feature_row" style="padding-left: 50px !important;">
                                                    <div class="inner">
                                                        <div class="feature_flex">

                                                            {{-- Column One  --}}
                                                            <div class="f-col d-sm-flex pb-3 pb-sm-0">
                                                                {{-- Checkbox  --}}
                                                                <div class="ftr_flx_check text-sm-center">
                                                                    <div class="custom-checkbox custom-control">
                                                                        <input type="checkbox" name="directpost_list[]" class="custom-control-input renew_feature renew_feature_{{ $featureKeys[$renew_plan->feature_id] }}_post" id="post_{{ $direct_post->id }}" value="{{ $sale_prices[$featureKeys[$renew_plan->feature_id]] }}" />
                                                                        <label for="post_{{ $direct_post->id }}" class="custom-control-label"></label>
                                                                    </div>
                                                                </div>
                                                                {{-- Checkbox END --}}

                                                                {{-- Title and text  --}}
                                                                <div class="ftr_flx_title">
                                                                    <div class="pr-md-4">
                                                                        <h6 data-toggle="collapse" data-target="#collapseBuyFeature_1" >
                                                                            <span>D2C Post {{ $loop->iteration }}</span>

                                                                            <p class="mb-0" style="font-size: 11px;">( Next Invoice on <b>{{ \Carbon\Carbon::parse($direct_post->expiry_date)->format('d F Y') }}</b> )</p>
                                                                            {{-- <span><i class="fas fa-chevron-down ml-3"></i></span> --}}
                                                                        </h6>
                                                                        
                                                                    </div>
                                                                </div>
                                                                {{-- Title and text END --}}
                                                            </div>

                                                            {{-- Price  --}}
                                                            <div class="f-col">
                                                                <div class="d-flex justify-content-between align-items-center">

                                                                    <div class="pr-4">
                                                                        
                                                                        @if(\Carbon\Carbon::parse($direct_post->expiry_date)->format('Y-m-d') >= \Carbon\Carbon::now()->format('Y-m-d'))
                                                                            <div class="badge badge-success">Active</div>
                                                                        @else
                                                                            <div class="badge badge-danger">Expired</div>
                                                                        @endif
                                                                    </div>

                                                                    <div class="text-right" style="width:100px">

                                                                        <input type="hidden" id="renew_constant_price_post_{{ $direct_post->id }}" value="{{ $sale_prices[$featureKeys[$renew_plan->feature->id]] }}">

                                                                        <h6 class="mb-0 ">₹<span  id="renew_sale_price_post_{{ $direct_post->id }}">{{ $sale_prices[$featureKeys[$renew_plan->feature->id]] }}</span></h6>
                                                                        <p class="mb-0 including_gst lh-normal"><small>Including GST</small></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{-- Price END --}}

                                                        </div>
                                                    </div>
                                                    </div>
                                                @endforeach
                                            @endif

                                        @endif

                                        @endforeach
                                    </div>
                                </div>
                                <div class="card-footer border-top">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div>
                                                <p class="mb-1">Have a Promo Code!</p>
                                                <div class="input-group input-group-sm" style="max-width: 300px;">
                                                    <input type="text" class="form-control" placeholder="Enter Code Here" name="promo_code_renew" value="" id="promo_code_renew" >

                                                    <input type="hidden" name="coupon_user_renew" value="" >
                                                    <input type="hidden" name="coupon_for_renew" value="" >
                                                    <input type="hidden" name="coupon_type_renew" value="" >
                                                    <input type="hidden" name="coupon_discount_renew" value="" >

                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary" type="button" id="applyCouponRenew">Apply</button>
                                                        <button class="btn btn-danger" type="button" id="cancelCouponRenew" style="display:none;">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table mb-0 text-right">
                                                <tr>
                                                    <td class="pl-0 pr-0">
                                                        Total
                                                    </td>
                                                    <td class="pr-0" width="100px">
                                                        <h6 class="mb-0">&#8377;<span class="font-weight-bold" id="actual_renew_amount">0</span></h6>
                                                    </td>
                                                </tr>
                                                <tr id="promocode_amount_renew_row" style="display:none;">
                                                    <td class="pl-0 pr-0">
                                                        Coupon Discount
                                                    </td>
                                                    <td class="pr-0" width="100px">
                                                        <h6 class="mb-0">- &#8377;<span class="font-weight-bold" id="promocode_amount_renew">0</span></h6>
                                                    </td>
                                                </tr>
                                                <tr id="added_discount_renew_row" style="display:none;">
                                                    <td class="pl-0 pr-0">
                                                        Additional 25% Discount
                                                    </td>
                                                    <td class="pr-0" width="100px">
                                                        <h6 class="mb-0">- &#8377;<span class="font-weight-bold" id="added_discount_renew">0</span></h6>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td style="padding-right: 0px !important;"><hr></td>
                                                </tr>
                                                <tr>
                                                    <td class="pl-0 pr-0">
                                                        Total Payable Amount
                                                    </td>
                                                    <td class="pr-0">
                                                        <h6 class="mb-0">&#8377;<span class="font-weight-bold" id="total_renew_amount">0</span></h6>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="px-0">
                                                        <button class="btn btn-success px-4" id="proceedWithRenew">Pay Now</button>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        {{-- Renew END  --}}


                        {{-- Buy  --}}
                        <div class="">
                            <div class="card">
                                <div class="card-header sticky-top price-top justify-content-between" style="background-color: #ebfff0!important;">
                                    <h4 class="text-success">Buy Apps</h4>
                                    <div class="text-right">
                                        <h6 class="mb-0">&#8377;<span class="font-weight-bold" id="topbar_buy_amount">0</span></h6>
                                        <p class="mb-0 small lh-normal">Payable Amount</p>
                                    </div>
                                </div>
                                <div class="card-body px-0 py-0 ">

                                    @empty(array_intersect($planIds,[3,4,5,6,7,8]))
                                    <div id="alert—window" class="mt-2">
                                        
                                        <div class="alert alert-light" role="alert">
                                            <div class="custom-checkbox custom-control">
                                                <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="all_apps" name="all_apps">
                                                <label for="all_apps" class="custom-control-label"><b>Click here to <span id="selectText">select</span> All Apps ( You will get extra 25% OFF. )</b></label>
                                            </div>
                                        </div>
                                    </div>
                                    @endempty

                                    <div class="list_of_feat">
                                        @foreach($feature_list as $list_item)

                                        @if(!in_array($list_item->id, [1,2]))

                                        <div class="feature_row @if(in_array($list_item->id, $disable_plan_ids)) disable_plan @endif "  id="row_{{ $featureKeys[$list_item->id] }}">
                                            <div class="inner">
                                                <div class="feature_flex">

                                                    {{-- Column One  --}}
                                                    <div class="f-col d-sm-flex pb-3 pb-sm-0">
                                                    
                                                            {{-- Checkbox  --}}
                                                            <div class="ftr_flx_check text-sm-center">
                                                                <div class="custom-checkbox custom-control">
                                                                    <input type="checkbox" class="custom-control-input buy_feature buy_feature_{{ $featureKeys[$list_item->id] }}" id="buy_input_{{ $featureKeys[$list_item->id] }}" value="{{ $sale_prices[$featureKeys[$list_item->id]] }}" />
                                                                <label for="buy_input_{{ $featureKeys[$list_item->id] }}" class="custom-control-label"></label>
                                                                </div>
                                                            </div>
                                                            {{-- Checkbox END --}}
                                                        

                                                        {{-- Title and text  --}}
                                                        <div class="ftr_flx_title">
                                                            <div class="pr-md-4">
                                                                <h6 data-toggle="collapse" data-target="#collapseBuy_{{ $featureKeys[$list_item->id] }}" >
                                                                    <span>{{ $list_item->title }}</span>
                                                                    <span>
                                                                        @if($list_item->short_description != '') ( {{ $list_item->short_description }} ) @endif
                                                                    </span>
                                                                    <span><i class="fas fa-chevron-down ml-3"></i></span>
                                                                </h6>
                                                                <div class="collapse" id="collapseBuy_{{ $featureKeys[$list_item->id] }}">
                                                                    <div class="">
                                                                        <p class="font_90 lh-normal c-dul">{{ $list_item->description }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- Title and text END --}}
                                                    </div>

                                                    {{-- Price  --}}
                                                    <div class="f-col">
                                                        <div class="d-flex justify-content-between align-items-center">

                                                            <div class="pr-4">

                                                                @if($list_item->select_qty == '1')

                                                                <div class="item-qty mb-2">
                                                                    <button class="qty-count qty-count--minus" data-action="minus" type="button" id="buy_{{ $featureKeys[$list_item->id] }}_minus" >-</button>
                                                                    <input class="product-qty" type="text" name="product-qty" min="1" max="" value="1" id="buy_{{ $featureKeys[$list_item->id] }}_qty" style="width: 50px;" readonly>
                                                                    <button class="qty-count qty-count--add" data-action="add" type="button" id="buy_{{ $featureKeys[$list_item->id] }}_add" >+</button>     
                                                                </div>

                                                                @endif

                                                            </div>

                                                            <div class="text-right">

                                                                    <input type="hidden" id="buy_constant_price_{{ $featureKeys[$list_item->id] }}" value="{{ $sale_prices[$featureKeys[$list_item->id]] }}">

                                                                    <h6 class="mb-0 ">₹<span id="buy_sale_price_{{ $featureKeys[$list_item->id] }}">{{ $sale_prices[$featureKeys[$list_item->id]] }}</span></h6>
                                                                    <p class="mb-0 including_gst lh-normal"><small>Including GST</small></p>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- Price END --}}

                                                </div>
                                            </div>
                                        </div>

                                        @endif

                                        @endforeach
                                    </div>
                                </div>

                                {{-- Footer Total Pricing  --}}
                                <div class="card-footer border-top">
                                    <div class="row">
                                        <div class="col-md-6">

                                            @php 

                                                if($coupon != ''){
                                                    $promo_code = $coupon->code;
                                                    $coupon_user = $coupon->user_id;
                                                    $coupon_for = $coupon->coupon_for;
                                                    $coupon_type = $coupon->coupon_type;
                                                    $coupon_discount = $coupon->discount;
                                                }else{
                                                    $promo_code = '';
                                                    $coupon_user = '';
                                                    $coupon_for = '';
                                                    $coupon_type = '';
                                                    $coupon_discount = '';
                                                }

                                            @endphp

                                            <div>
                                                <p class="mb-1">Have a Promo Code!</p>
                                                <div class="input-group input-group-sm" style="max-width: 300px;">
                                                    <input type="text" class="form-control" placeholder="Enter Code Here" name="promo_code" value="{{ $promo_code }}" id="promo_code" >

                                                    <input type="hidden" name="coupon_user" value="{{ $coupon_user }}" >
                                                    <input type="hidden" name="coupon_for" value="{{ $coupon_for }}" >
                                                    <input type="hidden" name="coupon_type" value="{{ $coupon_type }}" >
                                                    <input type="hidden" name="coupon_discount" value="{{ $coupon_discount }}" >

                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary" type="button" id="applyCoupon" @if($promo_code != '') style="display:none;" @endif>Apply</button>
                                                        <button class="btn btn-danger" type="button" id="cancelCoupon" @if($promo_code == '') style="display:none;" @endif >Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table mb-0 text-right">
                                                <tr>
                                                    <td class="pl-0 pr-0">
                                                        Total
                                                    </td>
                                                    <td class="pr-0" width="100px">
                                                        <h6 class="mb-0">&#8377;<span class="font-weight-bold" id="actual_buy_amount">0</span></h6>
                                                    </td>
                                                </tr>
                                                <tr id="promocode_amount_buy_row" style="display:none;">
                                                    <td class="pl-0 pr-0">
                                                        Coupon Discount
                                                    </td>
                                                    <td class="pr-0" width="100px">
                                                        <h6 class="mb-0">- &#8377;<span class="font-weight-bold" id="promocode_amount_buy">0</span></h6>
                                                    </td>
                                                </tr>
                                                <tr id="added_discount_buy_row" style="display:none;">
                                                    <td class="pl-0 pr-0">
                                                        Additional 25% Discount
                                                    </td>
                                                    <td class="pr-0" width="100px">
                                                        <h6 class="mb-0">- &#8377;<span class="font-weight-bold" id="added_discount_buy">0</span></h6>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td style="padding-right: 0px !important;"><hr></td>
                                                </tr>
                                                <tr>
                                                    <td class="pl-0 pr-0">
                                                        Total Payable Amount
                                                    </td>
                                                    <td class="pr-0">
                                                        <h6 class="mb-0">&#8377;<span class="font-weight-bold" id="total_buy_amount">0</span></h6>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="px-0">
                                                        <button class="btn btn-success px-4" id="proceedWithBuy">Pay Now</button>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>

                </div>
                <div class="tab-pane" id="manual_plan">
                    <h1>Manual Plan</h1>
                </div>
            </div>
        </div>

          <hr>

          <button class="btn btn-primary" type="submit" id="submitBtn" >Submit</button>
          
     </div>
    </div>

 
    </form>

 </div>
</div>
@endsection
@section('end_body')
<script src="{{ asset('assets/js/form.js') }}"></script>
<script>
    $(document).on("change", '#user_type', function() {
        if($(this).val() == 'old'){
            $("#new_user").css("display","none");  
            $("#old_user").css("display","flex");
        }else{
            $("#new_user").css("display","flex");
            $("#old_user").css("display","none");
        }
    });


    jQuery(document).ready(function ($) {
        $('#tabs').tab();
    });

    $(document).on("change", "#user_id", function() {
        var user_id = $(this).val();
        if(user_id != ''){
            window.location = '{{ $domain }}/admin/manage-payments?user_id='+user_id;
        }else{
            window.location = '{{ $domain }}/admin/manage-payments';
        }
    });

    $(document).on("click", '#submitBtn', function(e) {
        e.preventDefault();

        $("#submitBtn").prop("disabled", true);

        console.log('sdsd');
    });
</script>

<script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>

@include('business.plan.newjs')

@endsection


