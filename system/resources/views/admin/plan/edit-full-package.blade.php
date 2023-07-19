@extends('layouts.admin')
@section('title', 'Admin: Create Plan')
@section('head')
<style type="text/css">
  .is_required{
    color:red;
  }
</style>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-colorpicker.min.css') }}">
@include('layouts.partials.headersection',['title'=>'Update Package'])
@endsection
@section('content')

<div class="row">
  <div class="col-12 mt-2">
    <div class="card">
        <div class="card-body">
        	<form method="post" action="{{ route('admin.plan.fullPackageUpdate') }}" class="fullPackageUpdate">
				@csrf
				<div class="row">
					<div class="col-sm-8">
						<div class="form-group">
							<label>{{ __('Package Name') }} <span class="is_required">*</span></label>
							<input type="text" name="name" class="form-control two-space-validation" required value="{{ isset($fullPackage->title) ? $fullPackage->title : '' }}"> 
						</div>

						<div class="form-group">
							<label>{{ __('Package description') }} <span class="is_required">*</span></label>
							<input type="text" class="form-control three-space-validation" required="" name="description" value="{{ isset($fullPackage->description) ? $fullPackage->description : '' }}"></textarea>
						</div> 


						<div class="form-group">
							<label>{{ __('Package Price') }} <span class="is_required">*</span></label>
							<input type="tel" step="any" name="price" class="form-control number-validation" maxlength="5" required value="{{ isset($fullPackage->price) ? $fullPackage->price : '' }}"> 
						</div>
						@php
						$selected_plans = [];
						if(isset($fullPackage->selected_plans) && !empty($fullPackage->selected_plans)){
							$selected_plans = json_decode($fullPackage->selected_plans);
						}
						@endphp	
						
						<div class="form-group">
							<label>{{ __('Select') }} <span class="is_required">*</span></label>
							@if(!empty($plans))
								@foreach($plans as $plan)
									<h6><label for="plan-{{ $plan->id }}">{{ $plan->title }} <input id="plan-{{ $plan->id }}" type="checkbox" name="selected_plans[]" value="{{ $plan->id }}" {{ (in_array($plan->id,$selected_plans) ? 'checked' : '') }}></h6>
								@endforeach
							@endif
						</div>
						
						<div class="form-group">
							<button class="btn btn-primary basicbtn" type="submit" >{{ __('Save') }}</button>
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
@endsection

