@extends('layouts.business')

@section('title', 'Make Message Recharge: Business Panel')

@section('head')
	@include('layouts.partials.headersection',['title'=>'Make Message Recharge'])
@endsection

@section('end_head')
	<style>
		.hero-tab{
			display: none;
		}
	</style>
@endsection

@section('content')

<div class="mb-5">
	
	<div class="row justify-content-center">
		<div class="col-lg-7">

			@php $url=url('/business/make-recharge/'); @endphp
			@foreach($getways as $key => $row)
			<div class="card">
				<div class="card-header py-2 justify-content-between align-items-center d-block d-sm-flex">
					<img style="width: 120px;max-width:100%;" src="{{ asset('assets/'.$row->preview->content) }}">
					<div class="">
						<p class="small mb-0"><i class="fa fa-shield-alt text-primary"></i> Secure payment with <span class="font-weight-bold text-primary">{{$row->name}}</span></p>
					</div>
				</div>
				<div class="card-body">

					<form role="form" method="post" action="{{ url($url.'/'.$rechargeDetails->id) }}" id="paymentForm">
					{{-- <form role="form" method="post" action="#" id="paymentForm"> --}}
						<div class="hiddens">
							@csrf
							<input type="hidden" name="mode" value="{{ $row->id }}">
						</div>

						<div class="form-group row">
							<label for="pname" class="col-sm-3 col-form-label">{{ __('Name') }}</label>
							<div class="col-sm-9">
								<input type="text" name="name" value="{{ Auth::user()->name }}" class="form-control" style="height: 40px;" id="pname" readonly="">
							</div>
						</div>

						<div class="form-group row">
							<label for="pemail" class="col-sm-3 col-form-label">{{ __('Email') }}</label>
							<div class="col-sm-9">
								<input type="text" name="email" value="{{ Auth::user()->email }}" class="form-control" style="height: 40px;" id="pemail" readonly="">
							</div>
						</div>

						<div class="form-group row">
							<label for="pphone" class="col-sm-3 col-form-label">{{ __('Phone Number') }}</label>
							<div class="col-sm-9">
								<input type="number" name="phone" value="{{ Auth::user()->mobile }}" class="form-control" style="height: 40px;" id="pphone" readonly="">
							</div>
						</div>

						{{-- <div class="row justify-content-end">
							<div class="col-sm-9">

								<div class="form-check btn btn-outline-secondary btn-sm mb-2 d-inline-block" style="padding-left: 32px;">
									<input class="form-check-input tl-drk" type="checkbox" id="gst_claim" name="gst_claim">
									<label class="form-check-label" for="gst_claim">
										Claim GST
									</label>
								</div>

								<div class="collapse" id="gst_collapse">
									<div class="shadow-sm rounded px-3 py-2">
										<div class="line-inputs">
											<p class="small mb-1 font-weight-light_">(To claim your GST, please provide your GST account details)</p>
											<div class="row">
												<div class="col-12">
													<div class="form-group mb-3">
														<input type="text" name="gst_address" id="gst_address" class="form-control" placeholder="GST Address *">
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group mb-3">
														<select name="gst_state" id="gst_state" class="form-control" style="height: 40px;">
															<option value="0" selected disabled>- Select State -</option>
															@foreach($states as $state)
																<option value="{{ $state->id }}">{{ $state->name }}</option>
															@endforeach
														</select>
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group mb-3">
														<input type="text" name="gst_city" id="gst_city" class="form-control" placeholder="City *" >
													</div>
												</div>
												<div class="col-sm-6 col-lg-4">
													<div class="form-group mb-3">
														<input type="text" name="gst_pincode" id="gst_pincode" class="form-control" placeholder="Pincode *">
													</div>
												</div>
												<div class="col-lg-8">
													<div class="form-group mb-3">
														<input type="text" class="form-control" style="height: 40px;" placeholder="Enter GST Number *" name="gst_number" id="gst_number_input">
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
						</div> --}}


						<hr>
						<div class="text-right_">
							<div class="d-sm-flex justify-content-between align-items-center">
								<p class="mb-1 mb-sm-0">{{ __('Make Recharge With') }} {{ $row->name }}<br><span class="">{!! $price !!}</span> </p>
								<button type="button" id="pay_now" class="subscribe btn btn-primary px-4">Pay Now</button>
							</div>
						</div>

					</form>

				</div>
			</div>
			@endforeach

		</div>
	</div>
</div>
@endsection

@push('js')
	
@endpush
@section('end_body')
	<script type="text/javascript">
		$(document).ready(function(){
			$(document).on('change', '#gst_claim', function(){
		    // $("#gst_claim").on("change", function(){
		        var active = $(this).prop("checked") ? 1 : 0
		        $("#gst_collapse").toggle("collapse");
		        if(active == 0){
		            $('#gst_tr').show();
		            $('#igst_tr').hide();
		            $('#cgst_tr').hide();
		            $('#sgst_tr').hide();
		            $('#gst_state').val('0');
		        }else{ }
		        $('.gst_claim').val(active);
		    });
		    $(document).on('change', '#gst_state', function(){
		        var state_id = $(this).val();
		        $('.gst_state').val(state_id);
		        if(state_id == 14){
		            $('#gst_tr').hide();
		            $('#cgst_tr').hide();
		            $('#sgst_tr').hide();
		            $('#igst_tr').show();
		        }else{
		            $('#gst_tr').hide();
		            $('#igst_tr').hide();
		            $('#cgst_tr').show();
		            $('#sgst_tr').show();
		        }
		    })
		    $(document).on('change', '#gst_number_input', function () {    
		        var inputvalues = $(this).val();
		        var gstinformat = new RegExp('^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9]{1}Z[a-zA-Z0-9]{1}$');    
		        if (gstinformat.test(inputvalues)) {
		            $('.gst_number').val(inputvalues);
		            return true;    
		        } else {
		            Sweet('error', 'Please Enter Valid GSTIN Number.');
		            $("#gst_number_input").focus();
		        }
		    });


			$(document).on('click', '#pay_now', function(){
		    	
		    	if ($('#gst_claim').is(':checked')) {
		            var gst_address = $('#gst_address').val();
		            var gst_state = $('#gst_state').val();
		            var gst_city = $('#gst_city').val();
		            var gst_pincode = $('#gst_pincode').val();
		            var gst_number_input = $('#gst_number_input').val();
		    		if(gst_address == ''){
                    $("#gst_address").focus();
	                    Sweet('error', 'Enter GST Address.');
	                    return false;
	                }
	                if(gst_state == 0 || gst_state == undefined){
	                    $("#gst_state").focus();
	                    Sweet('error', 'Please select state.');
	                    return false;
	                }
	                if(gst_city == ''){
	                    $("#gst_city").focus();
	                    Sweet('error', 'Enter GST City.');
	                    return false;
	                }
	                if(gst_pincode == ''){
	                    $("#gst_pincode").focus();
	                    Sweet('error', 'Enter GST Pincode.');
	                    return false;
	                }
	                if(gst_number_input != ""){
	                    var gstinformat = new RegExp('^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9]{1}Z[a-zA-Z0-9]{1}$');
	                    if (!gstinformat.test(gst_number_input)) {    
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

	                /*Redirect to payment*/
		    		$('#paymentForm').submit();
		    	}else{
		    		$('#paymentForm').submit();
		    	}
		    	
		    });
		})
	</script>
@endsection