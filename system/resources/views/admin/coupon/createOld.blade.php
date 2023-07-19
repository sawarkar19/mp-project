@extends('layouts.admin')

@section('title', 'Admin: Create Coupon')

@section('head')
	@include('layouts.partials.headersection',['title'=>'Create Coupon'])
@endsection

@section('content')
<section class="section">
	<form method="post" action="{{ route('admin.coupon.store') }}" class="couponform_with_reset">
		<div class="row">
			<div class="col-md-8">
				<div class="card">
					<div class="card-body">
						
						<div class="form-group">
			                <label>{{ __('Coupon Name') }} <span class="text-danger">*</span></label>
			                <input type="text" name="name" class="form-control" required> 
			              </div>

			              <div class="form-group">
			                <label>{{ __('Start Date') }}</label>
			                <input type="date"  name="start_date" class="form-control datepicker"> 
			              </div>
			              
			              <div class="form-group">
			                <label>{{ __('End Date') }}</label>
			                <input type="date"  name="end_date" class="form-control datepicker"> 
			              </div>

			              <div class="form-group">
			                <label>{{ __('Coupon For') }} <span class="is_required">*</span></label> 
			                <select class="form-control" name="coupon_for" id="coupon_for" required>
			                  <option value="">{{ __('Select Coupon For') }}</option>
			                  <option value="individuals">{{ __('For Individuals') }}</option>
			                  <option value="for_all">{{ __('For All') }}</option>            
			                </select> 
			              </div>  
						
					</div>
				</div>
			</div>
			<div class="col-md-4">
				
			</div>
		</div>
	</form>
</section>
@endsection