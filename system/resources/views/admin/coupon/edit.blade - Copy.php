@extends('layouts.admin')
@section('title', 'Admin: Create Coupon')
@section('head')
<style type="text/css">
  .is_required{
    color:red;
  }
</style>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-colorpicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/js/chosen/chosen.css') }}" />
@include('layouts.partials.headersection',['title'=>'Edit Coupon'])
@endsection
@section('content')

<div class="row">
  <div class="col-12 mt-2">
    <div class="card">
        <div class="card-body">
        	<form method="post" action="{{ route('admin.coupon.update',$info->id) }}" class="basicform">
				@csrf
				@method('PUT')
				<div class="row">
					<div class="col-sm-8">
						<div class="form-group">
							<label>{{ __('Coupon Name') }} <span class="is_required">*</span></label>
							<input type="text" name="name" class="form-control two-space-validation" required value="{{ $info->name }}"> 
						</div>

						<div class="form-group">
							<label>{{ __('Coupon Code') }} <span class="is_required">*</span></label>
							<input type="text" name="code" class="form-control two-space-validation" required value="{{ $info->code }}"> 
						</div>

						<div class="form-group">
							<label>{{ __('Coupon Description') }} <span class="is_required">*</span></label>
							<input type="text" class="form-control three-space-validation" required="" name="description" value="{{ $info->description }}">
						</div> 

						<div class="form-group">
                <label>{{ __('Coupon For') }} <span class="is_required">*</span></label> 
                <select class="form-control" name="coupon_for" id="coupon_for" required>
                  <option>{{ __('Select Coupon For') }}</option>
                  <option @if($info->coupon_for=='individuals') selected="" @endif value="individuals">{{ __('For Individuals') }}</option>
                  <option @if($info->coupon_for=='for_all') selected="" @endif value="for_all">{{ __('For All') }}</option>            
                </select> 
            </div>

            @if($info->coupon_for=='individuals')
            <div class="form-group" id="userList" style="display:block;">
                <label class="d-block">{{ __('User List') }} <span class="is_required">*</span></label> 
                <select class="chzn-select form-control" name="user_id" id="user_id" required >
                  <option value=""></option> 
                  @foreach($getIndividualUser as $user)
                  <option value="{{ $user->id }}" {{ $getUser->id == $user->id ? 'selected' : ''}} >{{ $user->name }}</option>
                  @endforeach
                </select>                                        
            </div>
            @else
            <div class="form-group" id="userList" style="display:none;">
                <label class="d-block">{{ __('User List') }} <span class="is_required">*</span></label> 
                <select class="chzn-select form-control" name="user_id" id="user_id" required >
                  <option value=""></option> 
                  @foreach($getIndividualUser as $user)
                  <option value="{{ $user->id }}">{{ $user->name }}</option>
                  @endforeach
                </select>                                        
            </div>
            @endif

						<div class="form-group">
                <label>{{ __('Coupon Type') }} <span class="is_required">*</span></label>
                <select class="form-control" name="coupon_type" required>
                  <option>{{ __('Select Coupon Type') }}</option>
                  <option @if($info->coupon_type=='percentage') selected="" @endif value="percentage">{{ __('Percentage') }}</option>
                  <option @if($info->coupon_type=='price') selected="" @endif value="price">{{ __('Price') }}</option>        
                </select> 
            </div>

            <div class="form-group">
                <label>{{ __('Price/Percenatge') }} <span class="is_required">*</span></label>
                <input type="tel"  name="price_percentage" class="form-control number-validation" maxlength="1000000" required value="{{ $info->price_percentage }}"> 
            </div>

            <div class="form-group">
                <label>{{ __('Start Date') }}</label>
                <input type="date"  name="start_date" class="form-control" value="{{ $start_date }}"> 
            </div>

            <div class="form-group">
                <label>{{ __('End Date') }}</label>
                <input type="date"  name="end_date" class="form-control" value="{{ $end_date }}"> 
            </div>

           

						<div class="form-group">
							<button class="btn btn-primary basicbtn" type="submit" >{{ __('Update') }}</button>
						</div>
					</div>
					<div class="col-sm-4">						
						<div class="form-group">
							<label>{{ __('Is Featured ?') }} <span class="is_required">*</span></label>
							<select class="form-control" name="featured">
								<option value="0" @if($info->featured==0) selected="" @endif>{{ __('No') }}</option>
								<option value="1" @if($info->featured==1) selected="" @endif>{{ __('Yes') }}</option>
							</select>
						</div>
						<div class="form-group">
							<label>{{ __('Is Default ?') }} <span class="is_required">*</span></label>
							<select class="form-control" name="is_default">
								<option value="0" @if($info->is_default == 0) selected @endif>{{ __('No') }}</option>
								<option value="1" @if($info->is_default == 1) selected @endif>{{ __('Yes') }}</option>
							</select>
						</div>
						<div class="form-group">
							<label>{{ __('Status') }} <span class="is_required">*</span></label>
							<select class="form-control" name="status">
								<option value="1" @if($info->status==1) selected="" @endif>{{ __('Enable') }}</option>
								<option value="0" @if($info->status==0) selected="" @endif>{{ __('Disable') }}</option>
							</select>
						</div>
					</div>
				</div>			
			</form>
      </div>
    </div>
  </div>
</div>
@endsection
@section('end_body')
		<script src="{{ asset('assets/js/bootstrap-colorpicker.min.js') }}"></script>
		<script src="{{ asset('assets/js/form.js') }}"></script>
    <script src="{{ asset('assets/js/input-validation.js') }}"></script>
    <script src="{{ asset('assets/js/chosen/chosen.jquery.js') }}"></script>
    <script>
     
      $(document).ready(function() {
          $('#coupon_type').click(function(){
            var couponType = $('#coupon_type :selected').text();
            console.log(couponType); 
            if(couponType=="Percentage"){
              $("input").attr({
                 "max" : 100,        
                 "min" : 1          
              });
            } else if(couponType=="Price"){
                $("input").attr({
                 "max" : 1000000,        
                 "min" : 1         
                });
            }
          });

          $('#coupon_for').click(function(){
            var couponFor = $('#coupon_for :selected').text();
            console.log(couponFor);
            if(couponFor=="For Individuals"){
                $("#userList").show();
            }else{
                $("#userList").hide();
            }
          });

          $(".chzn-select").chosen();

      });   
      
    </script>
@endsection

