@extends('layouts.account')
@section('title', 'Statements: Account Panel')
@section('head')
@include('layouts.partials.headersection',['title'=>'Statements'])
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
		<h4>{{ __('Transactions') }}</h4>
	</div>
	<div class="card-body p-0">
		@if(count($plans) >= 1)
		<div class="table-responsive">
			<table class="table table-hover table-nowrap card-table">
				<thead>
					<tr>
						<th style="width: 100px;">{{ __('Sr. No.') }}</th>
						<th>{{ __('Payment ID') }}</th>
						<th>{{ __('Status') }}</th>
						<th>{{ __('Amount') }}</th>
						<th>{{ __('Transaction Date') }}</th>
						{{-- <th>{{ __('Invoice Date') }}</th> --}}
						<th>{{ __('Action') }}</th>
					</tr>
				</thead>
				<tbody class="list font-size-base rowlink" data-link="row">
					@foreach($plans as $row)
					<tr>
						<td style="width: 100px;"><b>{{ $plans->firstItem() + $loop->index }}</b></td>
						<td><a href="{{ route('account.viewHistory',$row->id) }}">{{ $row->transaction_id }}</a></td>
						<td class="badges">
							{{-- <span class="badge badge-warning">Unpaid</span> --}}
							<span class="badge badge-success">Paid</span>
						</td>
						<td>&#8377; {{ $row->transaction_amount }}</td>
						<td>{{ \Carbon\Carbon::parse($row->created_at)->format('j F, Y') }}</td>
						{{-- <td></td> --}}
						<td>
							<a href="{{ route('account.viewHistory',$row->id) }}" class="btn btn-warning">Invoice</a>
						</td>
					</tr>	
					@endforeach
				</tbody>
			</table>
		</div>

					
		@else
		<div class="col-md-12">
           <div class="no_recored text-center">
                 
                <h3> {{ Config::get('constants.no_record_found') }}</h3>
           </div>
         </div>
		@endif
	</div>
	<div class="card-footer text-center">
        {{ $plans->links('vendor.pagination.bootstrap-4') }}
      </div>
</div>
@endsection	