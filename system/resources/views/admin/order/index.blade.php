@extends('layouts.admin')
@section('title', 'Admin: Subscriptions')
@section('head')
@include('layouts.partials.headersection',['title'=>'Subscriptions'])
@endsection
@section('content')

<div class="">
	<div class="row justify-content-center">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<div class="col-sm-10">
						<ul class="nav nav-pills">
							<li class="nav-item">
								<a class="nav-link @if($type==='all') active @endif" href="{{ route('admin.order.index') }}">{{ __('All') }}</a>
							</li>

							{{-- <li class="nav-item">
								<a  href="{{ route('admin.order.index','status=2') }}" class="nav-link @if($type==2) active @endif">{{ __('Pending') }}</a>
							</li> --}}
							<li class="nav-item">
								<a  href="{{ route('admin.order.index','status=3') }}" class="nav-link @if($type==3) active @endif">{{ __('Expired') }}</a>
							</li>
							<li class="nav-item">
								<a class="nav-link @if($type===0) active @endif" href="{{ route('admin.order.index','status=cancelled') }}">{{ __('Cancelled') }}</a>
							</li>
							
						</ul>
					</div>
					<div class="col-sm-2">
						@can('order.create')
						<a href="{{ route('admin.order.create') }}" class="btn btn-primary float-right">{{ __('Create order') }}</a>
						@endcan
					</div>
				</div>
			</div>
			<div class="card">
				<div class="card-body">
					<div class="float-right">
						<form>
							<input type="hidden" name="type" value="@if($type === 0) trash @else {{ $type }} @endif">
							<div class="input-group mb-2">

								<input type="text" id="src" class="form-control" placeholder="Search..." required="" name="src" autocomplete="off" value="{{ $request->src ?? '' }}">
								<select class="form-control selectric" name="term" id="term">
									<option value="order_no">{{ __('Search By Subscription Id') }}</option>
									<option value="email">{{ __('Search By Customer Mail') }}</option>

								</select>
								<div class="input-group-append">                                            
									<button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
								</div>
							</div>
						</form>
					</div>

					<form method="post" action="{{ route('admin.orders.destroys') }}" class="basicform">
						@csrf
						<div class="float-left mb-1">
							@can('order.delete')
							<div class="input-group">
								<select class="form-control selectric" name="method">
									<option value="" >{{ __('Select Action') }}</option>
									
									<option value="2" >{{ __('Move To Pending') }}</option>
									@if($type !== 0)
									<option value="cancelled" >{{ __('Move To Cancelled') }}</option>
									@endif
									@if($type===0)
									<option value="delete" >{{ __('Delete Permanently') }}</option>
									@endif
								</select>
								<div class="input-group-append">                                            
									<button class="btn btn-primary basicbtn" type="submit">{{ __('Submit') }}</button>
								</div>
							</div>
							@endcan
						</div>

						<div class="table-responsive">
							<table class="table table-hover table-nowrap card-table text-center">
								<thead>
									<tr>
										<th class="text-left" ><input type="checkbox" class="checkAll"></th>

										<th class="text-left" >{{ __('Subscription id') }}</th>
										<th >{{ __('Date') }}</th>
										<th>{{ __('Customer Name') }}</th>
										<th>{{ __('Customer Email') }}</th>
										<th class="text-right">{{ __('Subscription total') }}</th>
										<th>{{ __('Payment Method') }}</th>
										<th>{{ __('Payment Status') }}</th>
										{{-- <th>{{ __('Fulfillment') }}</th> --}}
										<th class="text-right">{{ __('Action') }}</th>
									</tr>
								</thead>
								<tbody class="list font-size-base rowlink" data-link="row">
									@foreach($posts ?? [] as $key => $row)
									<tr>
										<td class="text-left"><input type="checkbox" name="ids[]" value="{{ $row->id }}"></td>
										<td class="text-left"><a href="{{ route('admin.order.invoice',$row->id) }}">{{ $row->order_no }}</a></td>
										<td>{{ $row->created_at->format('d-F-Y') }}</td>
										<td><a href="{{ route('admin.customer.show',$row->user->id) }}">{{ $row->user->name }}</a></td>
										<td><a href="{{ route('admin.customer.show',$row->user->id) }}">{{ $row->user->email }}</a></td>
										<td>{{ amount_format($row->amount) }}</td>
										<td>{{ $row->payment_method->method->name ?? '' }}</td>
										<td>@if(!empty($row->payment_method))
											@if($row->payment_method->status==1)
											<span class="badge badge-success">{{ __('Paid') }}</span>
											@else
											<span class="badge badge-danger">{{ __('Fail') }}</span>
											@endif
											@endif
										</td>

										{{-- <td>
											@if($row->status == 1) <span class="badge badge-success">Approved</span> @elseif($row->status == 2) <span class="badge badge-warning">{{ __('Pending') }}</span>@elseif($row->status == 3) <span class="badge badge-danger">{{ __('Expired') }}</span>@else <span class="badge badge-danger">{{ __('Cancelled') }}</span> @endif

										</td> --}}
										<td> <div class="dropdown d-inline">
											<button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												{{ __('Action') }}
											</button>
											<div class="dropdown-menu">
												{{-- <a class="dropdown-item has-icon" href="{{ route('admin.order.edit',$row->id) }}"><i class="far fa-edit"></i> {{ __('Edit') }}</a> --}}
												<a class="dropdown-item has-icon" href="{{ route('admin.order.show',$row->id) }}"><i class="far fa-eye"></i> {{ __('View') }}</a>
												<a class="dropdown-item has-icon" href="{{ route('admin.order.invoice',$row->id) }}"><i class="fa fa-file-invoice"></i> {{ __('Download Invoice') }}</a>

											</div>
										</div></td>
									</tr>	
									@endforeach
								</tbody>
							</table>

						</div>
					</div>
				</form>
				<div class="card-footer d-flex justify-content-between">
					{{ $posts->appends($request->all())->links('vendor.pagination.bootstrap-4') }}
				</div>
			</div>
		</div>
	</div>   
</div>
@endsection
@section('end_body')
<script src="{{ asset('assets/js/form.js') }}"></script>
@endsection

