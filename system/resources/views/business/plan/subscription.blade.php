@extends('layouts.business')
@section('title', 'Subscribed Plan: Business Panel')
@section('head')
	@include('layouts.partials.headersection',['title'=>'Subscriptions'])
@endsection

@section('end_head')
<style type="text/css">
	.user_image{
		background-color: #006BA2;
		padding:18px 22px;
		border-radius: 6px;
		height: 100px;
    	width: 100px;
	}
	
	.user_image i{
		font-size: 62px;
	}
	.user_image i:before{
		color: #ffffff;
	}
	.user_info{
		margin-left: -3px;
		display: flex;
		justify-content: start;
		padding-left: 0;
	}
	
	.user_font{
		color: #000;
    	font-weight: 500;
    	font-size: 14px;
	}
	table th,tr,td{
		font-size: 12px;
	}
	.subscribe_table span{
		font-size: 10px;
	}
	@media(max-width: 650px){
		.user_details{
			display: block;
		}
		.user_info{
			display: block;
			padding-left: 0;
		}
		.user_image{
			padding:16px;
			border-radius: 6px;
			max-width: 80px;
			height: 80px;
		}
		
		.user_image i{
			font-size: 42px;
		}
	}

</style>
@endsection

@section('content')

<section class="section">

	<div class="card">
		<div class="card-header">
			<h4>{{ __('User Information') }}</h4>
		</div>
		<div class="card-body">
			<div class="user_details">
				<div class="user_info align-items-center">
					<div class="user_name bg-primary rounded-circle text-white text-center mr-3 mr-lg-4" style="width:55px;height:55px;">
						<i class="fas fa-user" style="line-height:55px;font-size:1.5rem"></i>
					</div>
					<div class="user_name py-3 mr-3 mr-lg-5">
						<div>{{ __('User Name') }}</div>
						<div class="user_font mt-1">{{ Auth::user()->name ?? '' }}</div>
					</div>
					<div class="user_email py-3 mr-3 mr-lg-5">
						<div>{{ __('User Email') }}</div>
						<div class="user_font mt-1">{{ Auth::user()->email ?? '' }}</div>
					</div>
					<div class="user_mobile py-3">
						<div>{{ __('User Mobile') }}</div>
						<div class="user_font mt-1">{{ Auth::user()->mobile ?? '' }}</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	{{-- <div class="card">
		<div class="card-header">
			<h4>Subscriptions</h4>
		</div>
		<div class="card-body">
			<div class="d-md-flex">
				<div>

				</div>
				<div>
					<h5>Premium Plan <span class="badge badge-success">Active</span> </h5>
					@php
						$lowest_date = $plan_infos->min('will_expire_on');
					@endphp
					<p class="text-muted mb-0"><span>{{ $plan_infos->count() }} Active Apps</span> | Next Invoice on {{ \Carbon\Carbon::parse($lowest_date)->format('j F, Y') }}</p>
				</div>
			</div>
		</div>
	</div> --}}



	<div class="card">
		<div class="card-header">
			<h4>Active Apps</h4>
		</div>
		<div class="card-body p-0">
			<div class="table-responsive">
				<table class="table table-striped subscribe_table mb-0">
					<thead>
						<tr class="">
							<th><b>{{ __('App Name') }}</b></th>
							<th><b>{{ __('App No.') }}</b></th>
							<th><b>{{ __('App Status') }}</b></th>
							<th class="text-right"><b>{{ __('Expire On') }}</b></th>
							{{-- <th class="text-right" width="200"><b>{{ __('App Amount') }}</b></th> --}}
						</tr>
					</thead>
					<tbody>
						@foreach($plan_infos as $info)
						<tr>
							<td><b>{{ $info->feature->title }}</b></td>
							<td>{{ $info->order_no }}</td>
							<td>
								@if($info->status == 1)<span class="badge badge-success py-1">{{ __('Active') }}</span>
								@else<span class="badge badge-danger py-1">{{ __('Expired') }}</span>
								@endif
							</td>
							<td class="text-right">
								@php
									$current_date = \Carbon\Carbon::now();
									$expiry_befor_10days_date = \Carbon\Carbon::parse($info->will_expire_on)->subDays(10);
									$expiry_befor_20days_date = \Carbon\Carbon::parse($info->will_expire_on)->subDays(20);
									if ($current_date >= $expiry_befor_10days_date) {
										$dcol = 'text-danger';
									}
									elseif ($current_date >= $expiry_befor_20days_date) {
										$dcol = 'text-warning';
									}
									else {
										$dcol = 'text-dark';
									}
								@endphp
								<b class="{{$dcol}}">{{ \Carbon\Carbon::parse($info->will_expire_on)->format('j F, Y') }}</b>
							</td>
							{{-- <td class="text-right">&#8377; {{ $info->amount }}</td> --}}
						</tr>
						@endforeach
					</tbody>
				</table>			
			</div>
		</div>
	</div>

</section>


{{-- <div class="card">
	<div class="card-header">
		<h4>Subscriptions</h4>
	</div>
	<div class="card-body p-0">
		<div class="table-responsive">
			<table class="table table-striped subscribe_table">
				<thead>
					<tr class="">
						<th><b>{{ __('Plan Name') }}</b></th>
						<th><b>{{ __('Subscription No') }}</b></th>
						<th><b>{{ __('Subscription Status') }}</b></th>
						<th><b>{{ __('Subscription Created Date') }}</b></th>
						<th><b>{{ __('Subscription Period') }}</b></th>
						<th><b>{{ __('Subscription Amount') }}</b></th>
						<th><b>{{ __('Payment Mode') }}</b></th>
						<th><b>{{ __('Transaction Id') }}</b></th>
						<th><b>{{ __('Transaction Status') }}</b></th>
                    </tr>
				</thead>
				<tbody>
					@foreach($plan_infos as $info)
					<tr>
						<td><b>{{ $info->feature->title }}</b></td>
						<td>{{ $info->order_no }}</td>
						<td>
							@if($info->status == 1)<span class="badge badge-success">{{ __('Approved') }}</span>
							@elseif($info->status == 2)<span class="badge badge-warning">{{ __('Pending') }}</span>
							@elseif($info->status == 3)<span class="badge badge-danger">{{ __('Expired') }}</span>
							@else<span class="badge badge-danger">{{ __('Cancelled') }}</span>
							@endif
						</td>
						<td>{{ \Carbon\Carbon::parse($info->created_at)->format('j F, Y') }}</td>
						<td><b>{{ \Carbon\Carbon::parse($info->will_expire_on)->format('j F, Y') }}</b></td>
						<td>{{ $info->amount }}</td>
						<td>{{ $info->payment_method->method->name ?? '' }}</td>
						<td>{{ $info->payment_method->transaction_id ?? '' }}</td>
						<td>
							@if(!empty($info->payment_method))
								@if($info->payment_method->status==1)
								<span class="badge badge-success">{{ __('Paid') }}</span>
								@else
								<span class="badge badge-danger">{{ __('Fail') }}</span>
								@endif
							@endif
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>			
		</div>
	</div>
</div> --}}


@endsection