@extends('layouts.business')

@section('title', 'Make Payment: Business Panel')

@section('head')
	@include('layouts.partials.headersection',['title'=>'Make Payment'])
@endsection

@section('end_head')
	<style>
		.hero-tab{
			display: none;
		}
		.mark-required{
			color: red;
		}
	</style>
@endsection

@section('content')
@php $stripe=false; @endphp

<div class="mb-5">
	
	<div class="row justify-content-center">
		<div class="col-xl-8 col-md-10">

			@php
			if(url('/') == env('APP_URL')){
				$url=url('/business/make-charge/');
			}
			else{
				$url=url('/business/make-charge/');
			}
			@endphp

			@foreach($getways as $key => $row)
			{{-- @php
				dd($row);
			@endphp --}}
			<div class="card">
				<div class="card-header py-2 justify-content-between align-items-center d-block d-sm-flex">
					<img style="width: 120px;max-width:100%;" src="{{ asset('assets/'.$row->preview->content) }}">
					<div class="">
						<p class="small mb-0"><i class="fa fa-shield-alt text-primary"></i> Secure payment with <span class="font-weight-bold text-primary">{{$row->name}}</span></p>
					</div>
				</div>
				<div class="card-body">

				@if($row->slug == 'stripe')

					@php $stripe=true; @endphp
					@php $credentials=json_decode($row->credentials->content ?? ''); @endphp

					<script src="https://js.stripe.com/v3/"></script>

					<form action="{{ url($url.'/'.$planDetails['plan_id']) }}" method="post" id="payment-form">
						@csrf
						<div class="hiddens">
							<input type="hidden" name="mode" value="{{ $row->id }}">
							<input type="hidden" id="publishable_key" value="{{ $credentials->publishable_key }}">
						</div>

						<div class="form-group">
							<label for="card-element">Credit or debit card</label>
							<div id="card-element">
								<!-- A Stripe Element will be inserted here. -->
							</div>
							<!-- Used to display form errors. -->
							<div id="card-errors" role="alert"></div>

							@if($planDetails['payble_price'] > 0)
								<button type="submit" class="subscribe btn btn-primary btn-block shadow-sm mt-2"> Make Payment With {{ $row->name }} ({{ $price }}) </button>
							@else
								<a href="{{ url(env('APP_URL').'/contact') }}" target="_blank"  class="subscribe btn btn-primary btn-block shadow-sm text-white">{{ __('Please Contact With Us') }}</a>
							@endif
						</div>
						
					</form>

				@else

					<form role="form" method="post" action="{{ url($url.'/'.$planDetails['plan_id']) }}" id="paymentForm">
						<div class="hiddens">
							@csrf
							<input type="hidden" name="mode" value="{{ $row->id }}">
						</div>

						<div class="form-group row">
							<label for="name" class="col-sm-3 col-form-label">{{ __('Name') }}<span class="mark-required">*</span></label>
							<div class="col-sm-9">
								<input type="text" name="name" value="{{ Auth::user()->name }}" class="form-control" style="height: 40px;" id="name" readonly="">
							</div>
						</div>

						<div class="form-group row">
							<label for="email" class="col-sm-3 col-form-label">{{ __('Email') }}<span class="mark-required">*</span></label>
							<div class="col-sm-9">
								<input type="text" name="email" value="{{ Auth::user()->email }}" class="form-control" style="height: 40px;" id="email" readonly="">
							</div>
						</div>

						<div class="form-group row">
							<label for="phone" class="col-sm-3 col-form-label">{{ __('Phone Number') }}<span class="mark-required">*</span></label>
							<div class="col-sm-9">
								<input type="number" name="phone" value="{{ Auth::user()->mobile }}" class="form-control" style="height: 40px;" id="phone" readonly="">
							</div>
						</div>

						<div class="form-group row">
							<label for="gst_address" class="col-sm-3 col-form-label">{{ __('Address') }}<span class="mark-required">*</span></label>
							<div class="col-sm-9">
								<input type="text" name="gst_address" value="{{ $businessDetail['billing_address_line_1'] }}" id="gst_address" class="form-control" placeholder="Address *" title="Address">
							</div>
						</div>

						<div class="form-group row">
							<label for="gst_state" class="col-sm-3 col-form-label">{{ __('State') }}<span class="mark-required">*</span></label>
							<div class="col-sm-9">
								<select name="gst_state" id="gst_state" class="form-control" style="height: 40px;" title="State">
									<option value="0" selected disabled>- Select State -</option>
									@foreach($states as $state)
										<option value="{{ $state->id }}"  class="state_{{ $state->id }}" id="{{ $state->gst_code_id }}"
											@if ($businessDetail['billing_state'] == $state->id)
												selected
											@endif
											>{{ $state->name }}</option>
									@endforeach
								</select>
							</div>
						</div>


						<div class="form-group row">
							<label for="gst_city" class="col-sm-3 col-form-label">{{ __('City') }}<span class="mark-required">*</span></label>
							<div class="col-sm-9">
								<input type="text" name="gst_city" value="{{ $businessDetail['billing_city'] }}" id="gst_city" class="form-control char-validation" placeholder="City *" title="City">
							</div>
						</div>


						<div class="form-group row">
							<label for="gst_pincode" class="col-sm-3 col-form-label">{{ __('Pincode') }}<span class="mark-required">*</span></label>
							<div class="col-sm-9">
								<input type="text" name="gst_pincode" value="{{ $businessDetail['billing_pincode'] }}" id="gst_pincode" class="form-control no-space-validation number-validation" placeholder="Pincode *" title="Area Pincode" minlength="6" maxlength="6">
							</div>
						</div>

						<div class="row justify-content-end">
							<div class="col-sm-9">

								<div class="form-check btn btn-outline-secondary btn-sm mb-2 d-inline-block" style="padding-left: 32px;">
									<input class="form-check-input tl-drk" type="checkbox" id="gst_claim" name="gst_claim" value="1">
									<label class="form-check-label" for="gst_claim">
										Claim GST
									</label>
								</div>

								<div class="collapse" id="gst_collapse">
									<div class="shadow-sm rounded px-3 py-2">
										<div class="line-inputs">
											<p class="small mb-1 font-weight-light_">(To claim your GST, please provide your GST account details)</p>
											<div class="row">
												<div class="col-md-5">
													<div class="form-group mb-3">
														<input type="text" class="form-control" style="height: 40px;" placeholder="GST Number *" title="GST Number" name="gst_number" id="gst_number_input">
													</div>
												</div>
												<div class="col-md-7">
													<div class="form-group mb-3">
														<input type="text" class="form-control" style="height: 40px;" placeholder="Registred Business Name *" title="Registred Business Name" name="gst_business_name" id="gst_business_name_input">
													</div>
												</div>
											</div>
			
											<div class="mt-3">
												<p class="mb-0 font-weight-light_ small">GSTIN : <span class="BillGrossPrice fw-bold">27AAECL6399Q1ZG</span> <span>(Logic Innovates)</span> </p>
											</div>
										</div>
									</div>
								</div>

							</div>
						</div>


						<hr>
						<div class="text-right_">
							@if($planDetails['payble_price'] > 0)
								<div class="d-sm-flex justify-content-between align-items-center">
									<p class="mb-1 mb-sm-0">{{ __('Make Payment With') }} {{ $row->name }}<br><span class="">{!! $price !!}</span> </p>
									<button type="button" id="pay_now" class="subscribe btn btn-primary px-4">Pay Now</button>
								</div>
							@else
								<a href="{{ url(env('APP_URL').'/contact') }}" target="_blank"  class="subscribe btn btn-primary">{{ __('Please Contact With Us') }}</a>
							@endif
						</div>

					</form>

					
				@endif

				</div>
			</div>
			@endforeach

		</div>
	</div>
</div>
@endsection

@push('js')
	@if($stripe == true)
		<script src="{{ asset('assets/js/stripe.js') }}"></script>
	@endif
@endpush
@section('end_body')
	<script src="{{ asset('assets/js/input-validation.js') }}"></script>

	<script type="text/javascript">
		$(document).ready(function(){
			
			if($('#gst_claim').is(':checked')) {
				$("#gst_collapse").toggle("collapse");
			}

			$(document).on('change', '#gst_claim', function(){
		        var active = $(this).prop("checked") ? 1 : 0
		        $("#gst_collapse").toggle("collapse");
		        $('.gst_claim').val(active);
		    });

		    $(document).on('change', '#gst_state', function(){
		        var state_id = $(this).val();
		        $('.gst_state').val(state_id);
		    });


	    	function validateInputs() {
	            var gst_claim = $('#gst_claim').prop("checked") ? 1 : 0 ;
	            var gst_busi_name = $('#gst_business_name_input').val();
	            var gst_address = $('#gst_address').val();
	            var gst_state = $('#gst_state').val();
	            var gst_city = $('#gst_city').val();
	            var gst_pincode = $('#gst_pincode').val();
	            var gst_number_input = $('#gst_number_input').val();
	            var name = $('#name').val();
	            var phone = $('#phone').val();
	            var email = $('#email').val();
	            var password = $('#password').val();

	            if(name == ''){
	                $("#name").focus();
	                Sweet('error', 'Please enter name.');
	                return false;
	            }

	            if(phone == ''){
	                $("#phone").focus();
	                Sweet('error', 'Please enter Whatsapp number.');
	                return false;
	            }

	            if(phone.length < 10){
	                $("#gst_pincode").focus();
	                Sweet('error', 'Whatsapp number should be of 10 digit.');
	                return false;
	            }

	            if(email == ''){
	                $("#email").focus();
	                Sweet('error', 'Please enter email.');
	                return false;
	            }

	            var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	            if(!regex.test(email)) {
	                $("#email").focus();
	                Sweet('error', 'Please enter valid email.');
	                return false;
	            }

	            if(gst_address == ''){
	                $("#gst_address").focus();
	                Sweet('error', 'Please enter address.');
	                return false;
	            }

	            if(gst_address.length < 6){
	                $("#gst_address").focus();
	                Sweet('error', 'Address is too short.');
	                return false;
	            }

	            if(gst_state == 0 || gst_state == undefined){
	                $("#gst_state").focus();
	                Sweet('error', 'Please select state.');
	                return false;
	            }

	            if(gst_city == ''){
	                $("#gst_city").focus();
	                Sweet('error', 'Please enter city.');
	                return false;
	            }

	            if(gst_city.length < 3){
	                $("#gst_city").focus();
	                Sweet('error', 'City name is too short.');
	                return false;
	            }

	            if(gst_pincode == ''){
	                $("#gst_pincode").focus();
	                Sweet('error', 'Please enter pincode.');
	                return false;
	            }

	            if(gst_pincode.length < 6){
	                $("#gst_pincode").focus();
	                Sweet('error', 'Pincode should be of 6 digit.');
	                return false;
	            }

	            if(gst_claim == 1){
	                
	                if(gst_number_input != ""){
	                    var gstinformat = new RegExp('^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9]{1}Z[a-zA-Z0-9]{1}$');
	                    if (!gstinformat.test(gst_number_input)) {    
	                        Sweet('error', 'Please Enter Valid GSTIN Number.');
	                        $("#gst_number_input").focus();
	                        return false;  
	                    }

	                    var gst_state_code = gst_number_input.slice(0, 2);
	                    var state_code = $('.state_'+gst_state).attr('id');

	                    if(state_code != gst_state_code){
	                        Sweet('error', 'Please Enter Valid GSTIN Number.');
	                        $("#gst_number_input").focus();
	                        return false;
	                    }

	                }else{
	                    /*console.log('gst empty');*/
	                    $("#gst_number_input").focus();
	                    Sweet('error', 'Please insert GST Number.');
	                    return false;
	                }
	                $('.gst_number').val(gst_number_input);

	                if(gst_busi_name == ''){
	                    $("#gst_business_name_input").focus();
	                    Sweet('error', 'Please enter the registered business name.');
	                    return false;
	                }

	                if(gst_busi_name.length < 3){
		                $("#gst_busi_name").focus();
		                Sweet('error', 'Registered business name is too short.');
		                return false;
		            }
	            }

	            return true;
	        }

			$(document).on('click', '#pay_now', function(){
		    	
		    	var validate = validateInputs();
	            if(!validate){
	                return false;
	            }

	            var gst_claim = $('#gst_claim').prop("checked") ? 1 : 0 ;
	            var gst_busi_name = $('#gst_business_name_input').val();
	            var gst_address = $('#gst_address').val();
	            var gst_state = $('#gst_state').val();
	            var gst_city = $('#gst_city').val();
	            var gst_pincode = $('#gst_pincode').val();
	            var gst_number_input = $('#gst_number_input').val();
	            var name = $('#name').val();
	            var phone = $('#phone').val();
	            var email = $('#email').val();

	            if(gst_claim != 1){
	                gst_busi_name = '';
	                gst_number_input = '';
	            }

		    	$('#paymentForm').submit();
		    	
		    });
		})
	</script>
@endsection