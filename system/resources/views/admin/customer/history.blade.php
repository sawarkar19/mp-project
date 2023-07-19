@extends('layouts.admin')
@section('title', 'Transaction History: Admin Panel')
@section('head')
@include('layouts.partials.headersection',['title'=>'History'])
@endsection
@section('content')
<div class="row justify-content-center">
	<div class="col-sm-12">
		@if(Session::has('fail'))
			<div class="alert alert-danger alert-dismissible show fade">
				<div class="alert-body">
					<button class="close" data-dismiss="alert">
						<span>×</span>
					</button>
					{{ Session::get('fail') }}
				</div>
			</div>
		@endif
		@if(Session::has('success'))
			<div class="alert alert-success alert-dismissible show fade">
				<div class="alert-body">
					<button class="close" data-dismiss="alert">
						<span>×</span>
					</button>
					{{ Session::get('success') }}
				</div>
			</div>
		@endif
	</div>
</div>

<div class="card">
	<div class="card-header">
		<h4>{{ __('Transaction History') }}</h4>
	</div>
	<div class="card-body p-0">
		@if(count($posts) >= 1)
		<div class="table-responsive">
			<table class="table table-hover table-nowrap card-table text-center">
				<thead>
					<tr>
						<th class="text-left">{{ __('Transaction ID') }}</th>
						<th >{{ __('Transaction Amount') }}</th>
						<th >{{ __('Transaction Date') }}</th>
						<th class="text-right">{{ __('Action') }}</th>
					</tr>
				</thead>
				<tbody class="list font-size-base rowlink" data-link="row">
					@foreach($posts as $row)
					<tr>
						<td class="text-left"><a href="{{ route('business.viewHistory',$row->id) }}">{{ $row->transaction_id }}</a></td>
						<td>{{ $row->transaction_amount }}</td>
						<td>{{ \Carbon\Carbon::parse($row->created_at)->format('j F, Y') }}</td>
						<td class="text-right">
							<a href="{{ route('admin.customer.invoice',$row->id) }}" class="btn btn-success">View Invoice</a>
						</td>
					</tr>	
					@endforeach
				</tbody>
			</table>
		</div>

		<div class="p-2">
			{{ $posts->links('vendor.pagination.bootstrap-4') }}
		</div>
		
							
		@else
		<div>
			<div class="card-body">
				<h3>{{ Config::get('constants.no_record_found') }}</h3>
			</div>
		</div>
		@endif
	</div>
	<div class="card-footer d-flex justify-content-between">
		{{-- {{ $posts->links('vendor.pagination.bootstrap-4') }} --}}
	</div>
</div>
@endsection