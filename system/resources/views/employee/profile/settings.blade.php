@extends('layouts.employee')
@section('title', 'Employee: Profile')
@section('head')
@include('layouts.partials.headersection',['title'=>'Profile Settings'])
<style>
    .capitalize input{
        text-transform: capitalize;
    }
    label span{
      color: red;
    }
</style>
@endsection
@section('content')

<?php  session_start(); ?>
<section>
    <div class="section">
        
        <div class="row">
            <div class="col-md-6">
                

                <div class="card">
                 <form method="post" class="employeeSettingform" action="{{ route('employee.profile.update') }}">
                    @csrf
                    <div class="card-header">
                      <h4>{{__('Edit Genaral Settings')}}</h4>
                    </div>
                    <div class="card-body pb-0">
                      <p class="text-muted">{{__('Enter your name and mobile number here.')}}</p>
                      <div class="form-group">
                        <label>{{ __('Name') }} <span>*</span></label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text">
                              <i class="fas fa-user"></i>
                            </div>
                          </div>
                          <input type="text" name="name" id="name" class="form-control" required placeholder="Enter Name" value="{{ Auth::user()->name }}">
                        </div>
                      </div>
                      <div class="form-group">
                        <label>{{ __('Mobile') }} <span>*</span></label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text">
                              <i class="fas fa-mobile"></i>
                            </div>
                          </div>
                          <input type="text" name="mobile" id="mobile" class="form-control"  value="{{ $info->mobile }}" disabled> 
                        </div>
                      </div>
                    </div>
                    <div class="card-footer pt-">
                      <button type="submit" class="btn btn-info basicbtn">{{ __('Update') }}</button>
                    </div>
                  </form>
                </div>

            </div>
            <div class="col-md-6">
                <div class="card">
                    <form method="post" class="employeeSettingform" action="{{ route('employee.address.update') }}">
                    @csrf
                      <div class="card-header">
                        <h4>{{ __('Update Address') }}</h4>
                      </div>
                      <div class="card-body">
                        <div class="form-group">
                            <label for="address">{{ __('Address') }}</label>
                            <input type="text" name="address" id="address" class="form-control three-space-validation"  placeholder="Enter address" value="{{ $info->employee_details->address }}" >
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-6">
                            <label for="pincode">{{ __('Pincode') }}</label>
                            <input type="text" name="pincode" id="pincode" class="form-control number-validation"  placeholder="Enter pincode" value="{{ $info->employee_details->pincode }}" maxlength="6" minlength="6">
                          </div>
                          <div class="form-group col-md-6">
                            <label for="city">{{ __('City') }}</label>
                            <input type="text" name="city" id="city" class="form-control three-space-validation char-spcs-validation"  placeholder="Enter city" value="{{ $info->employee_details->city }}" >
                          </div>
                        </div>
                        
                        <div class="form-row">
                          <div class="form-group mb-0 col-md-6">
                            <label for="state">{{ __('State') }}</label>
                            <select name="state" class="form-control">
                                @foreach($states as $state)
                                    <option value="{{ $state->name }}" @if($info->employee_details->state == $state->name) selected @endif>{{ $state->name }}</option>
                                @endforeach
                            </select>
                          </div>
                          <div class="form-group mb-0 col-md-6">
                            <label for="country">{{ __('Country') }}</label>
                            <input type="text" name="country" id="country" class="form-control"  placeholder="Enter country" value="India" disabled>
                          </div>
                          
                        </div>
                       
                      </div>
                      <div class="card-footer">
                        <button type="submit" class="btn btn-primary basicbtn">{{ __('Update') }}</button>
                      </div>
                    </form>

                </div>
            </div>
        </div>

    </div>
</section>


@endsection
@section('end_body')

<script src="{{ asset('assets/js/form.js') }}"></script>
<script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/js/input-validation.js') }}"></script>
@endsection
@section('end_body')
    @include('business.scripts.profile-setting')
@endsection
