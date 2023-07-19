@extends('layouts.admin')
@section('title', 'Admin: Subscriptions')
@section('head')
@include('layouts.partials.headersection',['title'=>'Subscription No: '. $info->order_no])
@endsection
@section('content')

<div class="row">
	<div class="col-sm-6">
		<div class="card">
			<div class="card-header">
				<h4>{{ __('Subscription Information') }}</h4>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-hover">
						<tr>
							<td>{{ __('Subscription No') }}</td>
							<td><b>{{ $info->order_no }}</b></td>
						</tr>
						<tr>
							<td>{{ __('Subscription Status') }}</td>
							<td>@if($info->status == 1) <span class="badge badge-success">{{ __('Approved') }}</span> {{-- @elseif($info->status == 2) <span class="badge badge-warning">{{ __('Pending') }}</span> --}}@elseif($info->status == 3) <span class="badge badge-danger">{{ __('Expired') }}</span>@else <span class="badge badge-danger">{{ __('Cancelled') }}</span> @endif</td>
						</tr>
						<tr>
							<td>{{ __('Subscription Created Date') }}</td>
							<td><b>{{ $info->created_at->format('Y-m-d') }}</b></td>
						</tr>
						<tr>
							<td>{{ __('Subscription Created At') }}</td>
							<td><b>{{ $info->created_at->diffForHumans() }}</b></td>
						</tr>
						<tr>
							<td>{{ __('Subscription Will Be Expired') }}</td>
							<td><b>{{ $info->will_expire_on }}</b></td>
						</tr>
						<tr>
							<td>{{ __('Subscription Amount') }}</td>
							<td><b>{{ amount_format($info->amount) }}</b></td>
						</tr>
						<tr>
							<td>{{ __('Plan Name') }}</td>
							<td><b>{{ $info->plan_info->name ?? '' }}</b></td>
						</tr>
						<tr>
							<td>{{ __('Payment Mode') }}</td>
							<td><b>{{ $info->payment_method->method->name ?? '' }}</b></td>
						</tr>
						<tr>
							<td>{{ __('Transaction Id') }}</td>
							<td><b>{{ $info->payment_method->transaction_id ?? '' }}</b></td>
						</tr>
						<tr>
							<td>{{ __('Transaction Status') }}</td>
							<td>@if(!empty($info->payment_method))
								@if($info->payment_method->status==1)
								<span class="badge badge-success">{{ __('Paid') }}</span>
								@else
								<span class="badge badge-danger">{{ __('Fail') }}</span>
								@endif
								@endif
							</td>
						</tr>
						
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="card">
			<div class="card-header">
				<h4>{{ __('User Information') }}</h4>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-hover">
						<tr>
							<td>{{ __('User Name') }}</td>
							<td><b><a href="{{ route('admin.customer.show',$info->user->id) }}">{{ $info->user->name ?? '' }}</a></b></td>
						</tr>
						<tr>
							<td>{{ __('User Email') }}</td>
							<td><a href="mailto:{{ $info->user->email ?? '' }}"><b>{{ $info->user->email ?? '' }}</b></a></td>
						</tr>
						
					</table>
				</div>   		
			</div>
		</div>
	</div>
</div>
@endsection


