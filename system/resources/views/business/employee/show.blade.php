@extends('layouts.business')
@section('title', 'Business: User Details')
@section('head')
@include('layouts.partials.headersection',['title'=>'User Details'])
@endsection
@section('content')


<div class="row mt-sm-4">
      <div class="col-md-6 offset-md-3">
        <div class="card profile-widget">
          <div class="profile-widget-header">                     
            
            <div class="profile-widget-items">
              
              <div class="profile-widget-item">
                <div class="profile-widget-item-label">{{ __('Business Name') }}</div>
                <div class="profile-widget-item-value">{{ $employee_info->bussiness_details->bussiness_detail->business_name ?? '' }}</div>
              </div>

            </div>
          </div>
          <div class="profile-widget-description">
            <!-- <div class="profile-widget-name"> User Details </div> -->
            <ul class="list-group list-group-flush">
              <li class="list-group-item"><b>{{ __('Name :') }}</b> {{ $employee_info->name }}</li>
              <li class="list-group-item"><b>{{ __('Mobile No :') }}</b> <a href="tel:{{ $employee_info->mobile }}">{{ $employee_info->mobile }} </a></li>
              <li class="list-group-item"><b>{{ __('Joining Date :') }}</b> {{ $employee_info->created_at->format('j M, Y') }}</li>
              <li class="list-group-item"><b>{{ __('Total Shared :') }}</b> <span class="badge badge-warning">{{ $total_shares }}</span> Customer(s)</li>
              <li class="list-group-item"><b>{{ __('Total Redeemed :') }}</b> <span class="badge badge-warning">{{ $total_redeems }}</span> Customer(s)</li>
              
            </ul>

          </div>
          
        </div>
      </div>

      @if($employee_info->employee_details != '')
      <div class="col-md-6 offset-md-3">
        <div class="card profile-widget">
          {{-- <div class="profile-widget-header">                     
            
            <div class="profile-widget-items">
              
              <div class="profile-widget-item">
                <div class="profile-widget-item-label">{{ __('User Address') }}</div>
                <div class="profile-widget-item-value">{{ $employee_info->name ?? '' }}</div>
              </div>

            </div>
          </div> --}}
          <div class="profile-widget-description">
            <div class="profile-widget-name"> Address Details </div>
            <ul class="list-group">
              @if($employee_info->employee_details->address != '')
              <li class="list-group-item">{{ __('Address :') }} {{ $employee_info->employee_details->address }}</li>
              @endif

              @if($employee_info->employee_details->pincode != '')
              <li class="list-group-item">{{ __('Pincode :') }} {{ $employee_info->employee_details->pincode }}</li>
              @endif

              @if($employee_info->employee_details->city != '')
              <li class="list-group-item">{{ __('City:') }} {{ $employee_info->employee_details->city }}</li>
              @endif

              @if($employee_info->employee_details->state != '')
              <li class="list-group-item">{{ __('State :') }} {{ $employee_info->employee_details->state }}</li>
              @endif

              @if($employee_info->employee_details->country != '')
              <li class="list-group-item">{{ __('Country :') }} {{ $employee_info->employee_details->country }}</li>
              @endif
            </ul>

          </div>
          
        </div>
      </div>
      @endif

      
    </div>

@endsection