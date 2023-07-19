@extends('layouts.app')
@push('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/daterangepicker.css') }}">
@endpush
@section('content')
<div class="row">
	<div class="col-lg-3 col-md-6 col-sm-6 col-12">
		<div class="card card-statistic-1 card-primary">
			<div class="card-icon bg-primary">
				<i class="fas fa-shopping-bag"></i>
			</div>
			<div class="card-wrap">
				<div class="card-header">
					<h4>{{ __('Total Orders') }}</h4>
				</div>
				<div class="card-body">
					{{ number_format($total) }}
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-3 col-md-6 col-sm-6 col-12">
		<div class="card card-statistic-1 card-danger">
			<div class="card-icon bg-danger">
				<i class="fas fa-ban"></i>
			</div>
			<div class="card-wrap">
				<div class="card-header">
					<h4>{{ __('Order Cancelled') }}</h4>
				</div>
				<div class="card-body">
					{{ number_format($canceled) }}
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-3 col-md-6 col-sm-6 col-12">
		<div class="card card-statistic-1 card-warning">
			<div class="card-icon bg-warning">
				<i class="fas fa-history"></i>
			</div>
			<div class="card-wrap">
				<div class="card-header">
					<h4>{{ __('In Processing') }}</h4>
				</div>
				<div class="card-body">
					{{ number_format($proccess) }}
				</div>
			</div>
		</div>
	</div>

	<div class="col-lg-3 col-md-6 col-sm-6 col-12">
		<div class="card card-statistic-1 card-success">
			<div class="card-icon bg-success">
				<i class="far fa-check-square"></i>
			</div>
			<div class="card-wrap">
				<div class="card-header">
					<h4>{{ __('Order Complete') }}</h4>
				</div>
				<div class="card-body">
					{{ number_format($canceled) }}
				</div>
			</div>
		</div>
	</div>


	<div class="col-lg-3 col-md-6 col-sm-6 col-12">
		<div class="card card-statistic-1 card-primary">
			<div class="card-icon bg-primary">
				<i class="fas fa-money-check-alt"></i>
			</div>
			<div class="card-wrap">
				<div class="card-header">
					<h4>{{ __('Total Amount') }}</h4>
				</div>
				<div class="card-body">
					{{ amount_format($amounts) }}
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-3 col-md-6 col-sm-6 col-12">
		<div class="card card-statistic-1 card-danger">
			<div class="card-icon bg-danger">
				<i class="fas fa-money-bill"></i>
			</div>
			<div class="card-wrap">
				<div class="card-header">
					<h4>{{ __('Canceled Amount') }}</h4>
				</div>
				<div class="card-body">
					{{ amount_format($amount_cancel) }}
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-3 col-md-6 col-sm-6 col-12">
		<div class="card card-statistic-1 card-warning">
			<div class="card-icon bg-warning">
				<i class="fas fa-money-bill"></i>
			</div>
			<div class="card-wrap">
				<div class="card-header">
					<h4>{{ __('Pending Amount') }}</h4>
				</div>
				<div class="card-body">
					{{ amount_format($amount_proccess) }}
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-3 col-md-6 col-sm-6 col-12">
		<div class="card card-statistic-1 card-success">
			<div class="card-icon bg-success">
				<i class="fas fa-money-bill"></i>
			</div>
			<div class="card-wrap">
				<div class="card-header">
					<h4>{{ __('Earnings Amount') }}</h4>
				</div>
				<div class="card-body">
					{{ amount_format($amount_completed) }}
				</div>
			</div>
		</div>
	</div>

	<div class="col-sm-12">
		<div class="card card-primary">
			<div class="card-header">
				<h4>{{ __('Orders') }}</h4>
				<form class="card-header-form">
					<div class="d-flex">
						<!--<input type="text" name="start" class="form-control datepicker" value="{{ $start }}">
						<input type="text" name="end" class="form-control datepicker" value="{{ $end }}">-->
                        <select class="form-control" name="payment_status" id="payment_status" style="width: 250px;" required>
						 <option value="">{{ __('Please Select Payment Status') }}</option>
						 <option value="2">{{ __('Pending') }}</option>
						 <option value="1" >{{ __('Complete') }}</option>
						 <option value="3" >{{ __('Incomplete') }}</option>
						 <option value="cancel" >{{ __('Cancel') }}</option>
						</select>
						<button class="btn btn-primary btn-icon" type="submit" style="line-height:36px;margin-right:20px;"><i class="fas fa-search"></i></button>
					</div>		
				</form>
				<button class="btn btn-sm btn-primary  ml-1" type="button" data-toggle="modal" data-target="#searchmodal">
                  <i class="fe fe-sliders mr-1"></i> {{ __('Filter') }} <span class="badge badge-primary ml-1 d-none">0</span>
                </button>
			</div>
			<div class="card-body">
				

				<div class="table-responsive">
					<table class="table table-striped table-md table-hover">
						<tbody><tr>
							<th class="text-left" >{{ __('Invoice No') }}</th>
							<th >{{ __('Date') }}</th>
							<th>{{ __('Customer') }}</th>
							<th class="text-right">{{ __('Order total') }}</th>
							<th>{{ __('Payment') }}</th>
							<th>{{ __('Fulfillment') }}</th>
							<th class="text-right">{{ __('Item(s)') }}</th>
							<th class="text-right">{{ __('Invoice') }}</th>
						</tr>
						
						@foreach($orders as $key => $row)
						<tr>

							<td><a href="{{ route('seller.invoice',$row->id) }}" >{{ $row->order_no }}</a></td>
							<td><a href="{{ route('seller.order.show',$row->id) }}">{{ $row->created_at->format('d-F-Y') }}</a></td>
							<td> @if(empty($row->user_id)) {{ __('Guest Order') }} @else <a href="{{ route('seller.customer.show',$row->user_id) }}">{{ $row->customer->name ?? '' }}</a>  @endif</td>
							<td class="text-right">{{ amount_format($row->total) }}</td>
							<td>
								@if($row->payment_status==2)
								<span class="badge badge-warning">{{ __('Pending') }}</span>

								@elseif($row->payment_status==1)
								<span class="badge badge-success">{{ __('Complete') }}</span>

								@elseif($row->payment_status==0)
								<span class="badge badge-danger">{{ __('Cancel') }}</span> 
								@elseif($row->payment_status==3)
								<span class="badge badge-danger">{{ __('Incomplete') }}</span> 

								@endif
							</td>
							<td>
								@if($row->status=='pending')
								<span class="badge badge-warning">{{ __('Awaiting processing') }}</span>

								@elseif($row->status=='processing')
								<span class="badge badge-primary">{{ __('Processing') }}</span>

								@elseif($row->status=='ready-for-pickup')
								<span class="badge badge-info">{{ __('Ready for pickup') }}</span>

								@elseif($row->status=='completed')
								<span class="badge badge-success">{{ __('Completed') }}</span>

								@elseif($row->status=='archived')
								<span class="badge badge-warning">{{ __('Archived') }}</span>
								@elseif($row->status=='canceled')
								<span class="badge badge-warning">{{ __('Canceled') }}</span>

								@else
								<span class="badge badge-info">{{ $row->status }}</span>

								@endif
							</td>

							<td class="text-right"> {{ $row->order_items_count }}</td>
							<td class="text-right">
								<a href="{{ route('seller.order.show',$row->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
							</td>
						</tr>
						@endforeach
						
					</tbody></table>
					{{ $orders->appends($request->all())->links('vendor.pagination.bootstrap-4') }}
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="searchmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="card-header-title">{{ __('Filters') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
            <div class="modal-body">
                <div class="form-group row mb-4">
                    <label class="col-sm-7">{{ __('Payment Status') }}</label>
                    <div class="col-sm-5">
                        <select class="form-control" name="payment_status" id="payment_status">
                            <option value="2">{{ __('Pending') }}</option>
                            <option value="1" >{{ __('Complete') }}</option>
                            <option value="3" >{{ __('Incomplete') }}</option>
                            <option value="cancel" >{{ __('Cancel') }}</option>
                        </select>
                    </div>
                </div>

                <hr />

                <div class="form-group row mb-4">
                    <label class="col-sm-7">{{ __('Fulfillment status') }}</label>
                    <div class="col-sm-5">
                        <select class="form-control" name="status" id="status" >
                            <option value="pending" >{{ __('pending') }}</option>
                            <option value="processing" >{{ __('processing') }}</option>
                            <option value="ready-for-pickup" >{{ __('ready-for-pickup') }}</option>
                            <option value="completed" >{{ __('completed') }}</option>
                            <option value="archived" >{{ __('archived') }}</option>
                            <option value="canceled" >{{ __('canceled') }}</option>
                        </select>
                    </div>
                </div>

                <hr />

                <div class="form-group row mb-4">
                    <label class="col-sm-3">{{ __('Starting date') }}</label>
                    <div class="col-sm-9">
                        <input type="date" name="start" class="form-control" value="{{ $request->start }}" />
                    </div>
                </div>

                <hr />

                <div class="form-group row mb-4">
                    <label class="col-sm-3">{{ __('Ending date') }}</label>
                    <div class="col-sm-9">
                        <input type="date" name="end" class="form-control" value="{{ $request->end }}" />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="{{ url()->current() }}" class="btn btn-secondary">{{ __('Clear Filter') }}</a>
                <button type="submit" class="btn btn-primary">{{ __('Filter') }}</button>
            </div>
            </form>
        </div>
    </div>
</div>

@endsection
@push('js')
<script src="{{ asset('assets/js/order_index.js') }}"></script>
<script src="{{ asset('assets/js/daterangepicker.js') }}"></script>
@endpush