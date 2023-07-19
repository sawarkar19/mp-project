@extends('layouts.business')
@section('title', 'Redeem: Business Panel')
@section('head')
@include('layouts.partials.headersection',['title'=>'Redeem Code'])
<style>
	#error-show, #error-amount, #error-invoice{
	    color: red;
	    display: block;
	    padding: 10px 0px;
	}
	.total-amount{
	    text-align: center;
	    font-size: 16px !important;
	    margin-bottom: 20px;
	    font-weight: 700;
	}
	hr.dashed {
	    border-top: 2px dashed #dedede;
    	margin: 0.4rem 0;
	}
	/* #resetBtn{
		border: 0;
	    background: initial;
	    background-color: #aaa;
	    color: #fff;
	    font-size: 1.0625em;
	    padding: 10px;
    	border-radius: 5px !important;
    	width: 100px;
	} */
	#form-head{
		background: linear-gradient( 115deg, #00FFAF 0%, #00249C 80%);
		-webkit-background-clip: text;
		-webkit-text-fill-color: transparent;
		font-weight: bold;
	}
	.input-label{
		font-size: 15px !important;
	}
	#shareForm .form-group{
		margin-bottom: 10px !important;
	}
	label span{
		color: red;
	}
</style>
@endsection
@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
		<div class="col-12 col-sm-10 col-md-8 col-xl-6">

			<div class="card card-primary">
				<div class="card-header">
					<h4 id="form-head">Redeem Coupon Code</h4>
				</div>
				<div class="card-body">
					<form id="couponForm">
						@csrf
						<div class="form-group mb-2">
							<input id="coupon" type="text" class="form-control form-control-lg py-4" name="coupon" autofocus placeholder="Enter Coupon Code..." required="" style="text-transform: uppercase;font-size:1.1rem">
							<span id="error-show"></span>
						</div>
		
						<div>
							<button type="button" id="checkRedeemCoupon" class="btn btn-success px-3"><i class="fa fa-gift"></i> Redeem</button>
						</div>
					</form>

					<form id="calculationForm" style="display: none;"> 
						@csrf
						
						<div>
							<p class="alert alert-light"><b class="alert-title">Yay...</b><br>Coupon code successfully aplied, Please add billing details below to redeem coupon. </p>
						</div>
						<div class="d-flex">
							<div>
								<div class="form-group mb-1">
									<div class="input-group">
										<label style="width: 100%;">Enter amount <span>*</span></label>
										<input id="amount" type="text" class="form-control" name="amount" autofocus placeholder="Enter amount" required="">
										<input id="offer_id" type="hidden" name="offer_id" value="">
										<input id="discount_type" type="hidden" name="discount_type" value="">
										<input id="discount_value" type="hidden" name="discount_value" value="">
										<input id="redeem_amount" type="hidden" name="discount_value" value="">
										<input id="redeem_id" type="hidden" name="redeem_id" value="">
										<input id="targets" type="hidden" name="targets" value="">
									</div>
									<span id="error-amount"></span>
								</div>
							</div>
							
							@if($businessSettings['ask_for_invoice'] == 'Yes')
							<div class="ml-3">
								<div class="form-group mb-1" id="invoice-section">
									<div class="input-group">
										<label style="width: 100%;">Enter Invoice No. @if($businessSettings['invoice_required'] == 'Yes')<span>*</span>@endif</label>
										<input id="invoice" type="text" class="form-control" name="invoice" autofocus placeholder="Enter invoice">
									</div>
									<span id="error-invoice"></span>
								</div>
							</div>
							@endif
						</div>
		
						<div id="totalBox"></div>
		
						<div class="form-group text-center">
							<button type="button" id="resetBtn" class="btn btn-sm px-3 btn-outline-dark">Reset</button>
							<button type="button" id="calculateOffer" class="btn btn-sm px-3 btn-primary">Calculate</button>
						</div>
						<div class="form-group text-center">
							<button type="button" id="redeemOffer" class="btn btn-lg btn-success" disabled>
								Redeem Code</button>
						</div>
		
					</form>


					<table class="table table-bordered" id="offerTable" style="display: none;">
						<thead>
							<tr>
								<th scope="col text-center" colspan="4">Offer Details</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th scope="row">Title</th><td id="offerTitle"></td>
							</tr>
						</tbody>
					</table>

				</div>
			</div>

		</div>
    </div>
</div>

@endsection

@section('end_body')
    @include('business.redeem.customjs')
@endsection