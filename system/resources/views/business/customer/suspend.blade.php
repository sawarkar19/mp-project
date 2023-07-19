@extends('layouts.business')
@section('title', 'Customers: Business Panel')
@section('end_head')
	<style>.dropdown-item{cursor:pointer;}</style>
@endsection
@section('head')
@include('layouts.partials.headersection',['title'=>'Suspended Customers'])
@endsection
@section('content')
<div class="card">
	<div class="card-body">
		<div class="float-right">
			<a href="{{ route('business.customer.create') }}" class="btn btn-primary float-right">
				{{ __('Create Customer') }}
			</a>
		</div>
		<br><br>
		<div class="float-right">
			<form>
				<div class="input-group mb-2">

					<input type="text" id="src" class="form-control" placeholder="Search..." required="" name="src" autocomplete="off" value="{{ $src ?? '' }}">
					<select class="form-control selectric" name="type" id="type">
						<option value="mobile">{{ __('Search By Mobile') }}</option>
						<option value="offer">{{ __('Search By Offer') }}</option>
						{{-- <option value="id">{{ __('Search By Id') }}</option> --}}
					</select>
					<div class="input-group-append">                                            
						<button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
					</div>
				</div>
			</form>
		</div>
		<form method="post" action="{{ route('business.customer.destroys') }}" class="basicform_with_remove">
			@csrf
			<div class="float-left">
				<div class="input-group">
					<select class="form-control selectric" name="type">
						<option selected="" disabled="">{{ __('Select Action') }}</option>
						<option value="delete" class="text-danger">{{ __('Delete Permanently') }}</option>
					</select>
					<div class="input-group-append">                                            
						<button class="btn btn-primary basicform_with_remove" type="submit">{{ __('Submit') }}</button>
					</div>
				</div>
			</div>
			<div class="table-responsive custom-table">
				<table class="table">
					<thead>
						<tr>
							<th class="am-select">
								<div class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input checkAll" id="selectAll">
									<label class="custom-control-label checkAll" for="selectAll"></label>
								</div>
							</th>
							<th class="am-title">{{ __('Name') }}</th>
							<th class="am-title">{{ __('Mobile') }}</th>
							<th class="am-title">{{ __('Total Subscription') }}</th>
							{{-- <th class="am-date">{{ __('Registered At') }}</th> --}}
							<th class="am-date">{{ __('Action') }}</th>
						</tr>
					</thead>
					<tbody>
						@foreach($posts as $row)
						<tr id="row{{  $row->id }}">
							<td>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="ids[]" class="custom-control-input" id="customCheck{{ $row->id }}" value="{{ $row->id }}">
									<label class="custom-control-label" for="customCheck{{ $row->id }}"></label>
								</div>
							</td>
							<td>
								<a href="{{ route('business.customer.show',$row->id) }}">
									@empty($row->name){{ '---' }}@else{{ $row->name }}@endif (#{{ $row->id }})
								</a> 
								<div>
									<a href="{{ route('business.customer.edit',$row->id) }}">
										{{ __('Edit') }}
									</a>
								</div>
							</td>
							
							<td>
								<a href="{{ route('business.customer.show',$row->id) }}">
									{{ $row->mobile }}
								</a>
							</td>
							
							<td>{{ number_format($row->orders_count) }}</td>
							
							<td>
								<div class="dropdown d-inline">
                      				<button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      					{{ __('Action') }}
									</button>
									<div class="dropdown-menu">
										<a class="dropdown-item has-icon" href="{{ route('business.customer.edit',$row->id) }}">
											<i class="fas fa-user-edit"></i> {{ __('Edit Acount') }}
										</a>
										<a class="dropdown-item has-icon" href="{{ route('business.customer.show',$row->id) }}">
											<i class="fas fa-search"></i> {{ __('View Customer') }}
										</a>
										<a class="dropdown-item has-icon" onclick="$('.suspend-customer').click();">
											<i class="fas fa-pause"></i> {{ __('Suspend Customer') }}
										</a>
										<form method="post" action="{{ route('business.customer.suspend') }}" class="basicform_with_reload" style="display:none;">
											@csrf
											<input type="hidden" name="id" value="{{ $row->id }}" />
											<input type="submit" name="submit" class="suspend-customer basicform_with_reload" style="display:none;" />
										</form>
									</div>
                    			</div>
                    		</td>
						</tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr>
							<th class="am-select">
								<div class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input checkAll" id="selectAll">
									<label class="custom-control-label checkAll" for="selectAll"></label>
								</div>
							</th>
							<th class="am-title">{{ __('Name') }}</th>
							<th class="am-title">{{ __('Mobile') }}</th>
							<th class="am-title">{{ __('Total Subscription') }}</th>
							<th class="am-date">{{ __('Action') }}</th>
						</tr>
					</tfoot>
				</table>
			</form>
			{{ $posts->links('vendor.pagination.bootstrap-4') }}
			<span>
				{{ __('Note') }}: <b class="text-danger">
					{{ __('For Better Performance Remove Unusual Users') }}
				</b>	
			</span>
		</div>
	</div>
</div>
@endsection
@push('js')
	<script src="{{ asset('assets/js/form.js') }}"></script>
@endpush
@section('end_body')
@endsection