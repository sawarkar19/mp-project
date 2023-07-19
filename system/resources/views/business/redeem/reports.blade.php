@extends('layouts.business')
@section('title', 'Redeem Reports: Business Panel')

@section('end_head')
<link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css') }}" rel="stylesheet">
<style>
	.lh-1{
		line-height: 1;
	}
	.table:not(.table-sm):not(.table-md):not(.dataTable) td,
	.table:not(.table-sm):not(.table-md):not(.dataTable) th {
		padding: 5px 10px;
		height: 55px;
	}
	.table:not(.table-sm) thead th{
		text-transform: capitalize;
	}
</style>
@endsection

@section('head')
@include('layouts.partials.headersection',['title'=>'Redeem Reports'])
@endsection

@section('content')
<section>
	<div class="section">

		{{-- filter part --}}
		<div class="card">
			{{-- <div class="card-header">
				<h4>Apply Filter</h4>
			</div> --}}
			<div class="card-body">

				<form action="{{ route('business.redeemReports') }}" method="get">
					
				<div class="row align-items-end">

					<div class="col-md-8">
						<div class="row">
							<div class="col-sm-7">
								<div class="form-group mb-sm-0 mb-3">
									<label for="" class="mb-1">Select the Date Range <span>*</span></label>
									<div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text">
											<i class="fas fa-calendar"></i>
										  </div>
										</div>
										<input type="text" name="date_range" value="{{ $date_range }}" class="form-control daterange-cus" required>
									</div>
								</div>
							</div>
							<div class="col-sm-5">
								<div class="form-group mb-md-0 mb-3">
									<label for="" class="mb-1">Offer Type</label>
									<select name="offer_type" id="" class="form-control">
										<option value="">All</option>
										<option value="instant" @if ($type == 'instant') selected @endif >Instant Challenge</option>
										<option value="future" @if ($type == 'future') selected @endif>Share Challenge</option>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="text-right_">
							<input type="submit" value="Apply Filter" class="btn btn-sm btn-primary px-3" id="applyBtn">
							<input type="reset" value="Clear" class="btn btn-sm btn-secondary px-3" id="resetBtn">
						</div>
					</div>
				</div>

				</form>
			</div>
		</div>
		{{-- filter part end  --}}

		@php
			$get_url = explode('?', \URL::full());
			$default_dates = 'date_range='.$date_range;
			if(isset($get_url[1]) && $get_url[1] != ''){
				$default_dates = $get_url[1];
			}
		@endphp
		{{-- data list  --}}
		@if(count($records) >= 1)
			
		<div class="row">
			<div class="col-12 order-2">
				<div class="card">
					<div class="card-header">
						<h4>Redeem List</h4>
						<div class="card-header-form">
							<a href="{{route('business.redeemExportExcel')}}?{{$default_dates}}" target="_blank" class="btn btn-sm btn-success rounded px-3 mr-2" data-toggle="tooltip" title="Export to Excel">Excel</a>
							<a href="{{route('business.redeemExportPdf')}}?{{$default_dates}}" target="_blank" class="btn btn-sm btn-danger px-3" data-toggle="tooltip" title="Export to PDF">PDF</a>
						</div>
					</div>
		
					<div class="card-body p-0">
						<div class="table-responsive">
							<table class="table table-striped table-bordered mb-0">
								<thead>
									<tr>
										<th>Sr. No.</th>
										<th>{{ __('Customer') }}</th>
										<th>{{ __('Offer') }}</th>
										<th>{{ __('Bill Amount') }}</th>
										<th>{{ __('Paid Amount') }}</th>
										<th>{{ __('Discount') }}</th>
										<th>{{ __('Discount Info') }}</th>
										<th>{{ __('Redeem At') }}</th>
									</tr>
								</thead>
								<tbody>
									@php
										$total_amo = 0;
										$discount_amo = 0;
										$recieved_amo = 0;
									@endphp
		
									@foreach($records as $row)
									<tr>
										<td>{{ $loop->iteration }}</td>
										<td>{{ $row->subscription_details->customer->mobile }}</td>
										<td>
											<p class="mb-1 lh-1"><b>{{ $row->subscription_details->offer->uuid }}</b></p>
											@if ($row->subscription_details->offer->type == 'future')
												<p class="mb-0 small lh-1">(Share Challenge)</p>
											@else
												<p class="mb-0 small lh-1">(Instant Challenge)</p>
											@endif
										</td>
										<td>
											<span style="font-family: Arial, Helvetica, sans-serif;">&#8377;</span> {{ $row->actual_amount }}
											
											@php $total_amo = $total_amo + $row->actual_amount; /*Calculate Total Amount*/ @endphp
										</td>
										<td>
											<span style="font-family: Arial, Helvetica, sans-serif;">&#8377;</span> {{ $row->redeem_amount }}
											@php $recieved_amo = $recieved_amo + $row->redeem_amount; /*Calculate Paid(redeem) Amount*/ @endphp
										</td>
										<td>
											<b><span style="font-family: Arial, Helvetica, sans-serif;">&#8377;</span> {{number_format($row->actual_amount - $row->redeem_amount, 2)}}</b>
										</td>
										<td>
											@php
												if ($row->discount_type == "Percentage") {
													$sufix = '%';
													$prefix = '';
												}else{
													$prefix = '<span style="font-family: Arial, Helvetica, sans-serif;">&#8377;</span>';
													$sufix = '';
												}
											@endphp

											<p class="mb-1 lh-1"><b>{!!$prefix!!} {{ $row->discount_value }}{{$sufix}}</b></p>

											@if ($row->discount_type == "Percentage")
												<small>(Percentage Discount)</small>
											@elseif ($row->discount_type == "Perclick")
												<small>(Cash Per Click Discount)</small>
											@elseif ($row->discount_type == "Fixed")
												<small>(Fixed Amount Discount)</small>
											@endif

											@php $discount_amo = $discount_amo + ($row->actual_amount - $row->redeem_amount);  /*Calculate Discounted Amount*/  @endphp
										</td>
										<td>
											{{\Carbon\Carbon::parse($row->created_at)->format('d/m/Y - H:i')}}
										</td>
									</tr>
									@endforeach
								</tbody>
		
							</table>
						</div>
					</div>
				</div>
			</div>

			<div class="col-12 order-1">
				<div class="row">
					<div class="col-6 col-md-3">
						<div class="card card-primary">
							<div class="card-body">
								<p>Total Amount</p>
								<h5 class="mb-0">&#8377; {{$total_amo}}</h5>
							</div>
						</div>
					</div>
					<div class="col-6 col-md-3">
						<div class="card card-success">
							<div class="card-body">
								<p>Recieved Amount</p>
								<h5 class="mb-0">&#8377; {{$recieved_amo}}</h5>
							</div>
						</div>
					</div>
					<div class="col-6 col-md-3">
						<div class="card card-warning">
							<div class="card-body">
								<p>Discounted Amount</p>
								<h5 class="mb-0">&#8377; {{$discount_amo}}</h5>
							</div>
						</div>
					</div>
					<div class="col-6 col-md-3">
						<div class="card card-danger">
							<div class="card-body">
								<p>Total Discount (%)</p>
								<h5 class="mb-0">{{number_format(($discount_amo / $total_amo) * 100, 2)}} %</h5>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>


		@else
		<div class="no_recored mb-3">
			<i class="fas fa-exclamation-triangle mr-1"></i> Records not found!
		</div>
		@endif

	</div>
</section>
@endsection
@push('js')
	<script src="{{ asset('assets/js/form.js') }}"></script>
	<script src="{{ asset('assets/js/daterangepicker.js') }}"></script>
@endpush
@section('end_body')

<script>
	$(document).ready(function(){
		var today = new Date();
		var today_date = today.getDate()+'-'+(today.getMonth()+1)+'-'+today.getFullYear();

		
		var yesterday = new Date(new Date().getTime() - 24*60*60*1000);
		var yesterday_date = yesterday.getDate()+'-'+(yesterday.getMonth()+1)+'-'+yesterday.getFullYear();

		var last_7_day = new Date(new Date().getTime() - 7 * 24 * 60 * 60 * 1000);
		var last_7_day_date = last_7_day.getDate()+'-'+(last_7_day.getMonth()+1)+'-'+last_7_day.getFullYear();


		var firstDay_last = new Date(today.getFullYear(), today.getMonth()-1, 1);
		var lastDay_last = new Date(today.getFullYear(), today.getMonth(), 0);
		var last_month_first_day_date = firstDay_last.getDate()+'-'+(firstDay_last.getMonth()+1)+'-'+firstDay_last.getFullYear();
		var last_month_last_day_date = lastDay_last.getDate()+'-'+(lastDay_last.getMonth()+1)+'-'+lastDay_last.getFullYear();


		var firstDay_this = new Date(today.getFullYear(), today.getMonth(), 1);
		var this_month_first_day_date = firstDay_this.getDate()+'-'+(firstDay_this.getMonth()+1)+'-'+firstDay_this.getFullYear();

		var this_year_first_day_date = '01-01-'+firstDay_this.getFullYear();

		$('.daterange-cus').daterangepicker({
			"autoApply": true,
			"showDropdowns": true,
			"locale": {format: 'DD-MM-YYYY'},
			"drops": 'down',
			"opens": 'right',
			"alwaysShowCalendars": false,
			"ranges":{
				"Today": [
					today_date,
					today_date
				],
				"Yesterday": [
					yesterday_date,
					yesterday_date
				],
				"Last 7 Days": [
					last_7_day_date,
					today_date
				],
				"Last Month": [
					last_month_first_day_date,
					last_month_last_day_date
				],
				"This Month": [
					this_month_first_day_date,
					today_date
				],
				"This Year": [
					this_year_first_day_date,
					today_date
				],
			},
		});
	});
</script>
@endsection