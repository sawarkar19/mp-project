@extends('layouts.app')
@section('content')
<div class="">
    <div class="row justify-content-center">
        <div class="col-12">
           
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Transactions') }}</h4>
                    <form class="card-header-form">
                        <div class="input-group">                            
			                <select class="form-control" name="payment_status" id="payment_status" style="width: 250px;" required>
							    <option value="">{{ __('Please Select Payment Status') }}</option>
								<option value="2">{{ __('Pending') }}</option>
								<option value="1" >{{ __('Complete') }}</option>
								<option value="3" >{{ __('Incomplete') }}</option>
								<option value="cancel" >{{ __('Cancel') }}</option>
							</select>
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-primary btn-icon" style="line-height:36px;margin-right:20px;"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </form> 
					 <form class="card-header-form">
						<div class="input-group">
							<input type="text" name="src" value="{{ $request->src ?? '' }}" class="form-control" required=""  placeholder="transactions id..." />
							<div class="input-group-btn">
								<button type="submit" class="btn btn-primary btn-icon"><i class="fas fa-search"></i></button>
							</div>
						</div>
                    </form> 
					<button class="btn btn-sm btn-primary  ml-1" type="button" data-toggle="modal" data-target="#searchmodal">
					  <i class="fe fe-sliders mr-1"></i> {{ __('Filter') }} <span class="badge badge-primary ml-1 d-none">0</span>
					</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-nowrap card-table text-center">
                            <thead>
                                <tr>
                                    <th class="text-left" >{{ __('Order No') }}</th>
                                    <th class="text-left" >{{ __('Transaction Id') }}</th>
                                    <th >{{ __('Last Update') }}</th>
                                    <th>{{ __('Customer') }}</th>
                                    <th>{{ __('Amount') }}</th>
                                    <th>{{ __('Payment') }}</th>
                                    <th>{{ __('Method') }}</th>
                                </tr>
                            </thead>
                            <tbody class="list font-size-base rowlink" data-link="row">
                                @foreach($orders as $key => $row)
                                <tr>
                                    <td class="text-left">
                                        <a href="{{ route('seller.order.show',$row->id) }}">{{ $row->order_no }}</a>
                                    </td>
                                     <td class="text-left">
                                       <a href="#" data-toggle="modal" class="edit" data-target="#editModal" data-oid="{{ $row->id }}" data-td="{{ $row->id }}"  data-mode="{{ $row->getway->id ?? '' }}" data-transaction="{{ $row->transaction_id }}">{{ $row->transaction_id }}</a>
                                    </td>
                                    <td>
                                    	<a href="{{ route('seller.order.show',$row->id) }}">{{ $row->updated_at->format('d-F-Y') }}</a>
                                    	<br>
                                    	<small>{{ $row->updated_at->diffForHumans() }}</small>
                                    </td>
                                    <td>@if($row->customer_id != null)<a href="{{ route('seller.customer.show',$row->customer_id) }}">{{ $row->customer->name }}</a>@else {{ __('Guest Transaction') }} @endif</td>
                                    <td >{{ amount_format($row->total) }}</td>
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
                                 	<td>{{ $row->getway->name ?? '' }}</td>
                                    
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    @if(count($request->all()) > 0)
                    {{ $orders->appends($request->all())->links('vendor.pagination.bootstrap-4') }}
                    @else
                    {{ $orders->links('vendor.pagination.bootstrap-4') }}
                    @endif
                </div>
            </div>
        </div>
    </div>  
</div>




<form method="post" action="{{ route('seller.transection.store') }}" class="basicform">
	@csrf
<div class="modal fade" id="editModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">{{ __('Edit') }}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				
				<input type="hidden" name="o_id" id="o_id" value="">
				<input type="hidden" name="t_id" id="t_id"  value="">
				<div class="form-group">
					<label>{{ __('File Name') }}</label>
					<select class="form-control" name="method" id="method">
						@foreach($getways as $row)
						<option value="{{ $row->method->id }}">{{ $row->method->name }}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group">
					<label>{{ __('Transection Id') }}</label>
					<input type="text" name="transection_id" class="form-control" required="" id="transection_id">
				</div>
				
			</div>
			<div class="modal-footer">

				<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
				<button type="submit" class="btn btn-primary basicbtn">{{ __('Save') }}</button>
			</div>
		</div>
	</div>
</div>
</form>

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
                    <label class="col-sm-7">{{ __('Payment Method') }}</label>
                    <div class="col-sm-5">
                        <select class="form-control" name="status" id="status" >
                            <option value="2" >{{ __('Cash On Delivery (COD)') }}</option>
                            <option value="4" >{{ __('Razorpay') }}</option>
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
<script type="text/javascript" src="{{ asset('assets/js/form.js') }}"></script>
<script src="{{ asset('assets/js/order_index.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/seller/transaction/index.js') }}"></script>
@endpush

