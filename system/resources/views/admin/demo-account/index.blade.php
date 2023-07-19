@extends('layouts.admin')
@section('title', 'Admin: Demo Account List')
@section('head')
@include('layouts.partials.headersection',['title'=>'Demo accounts'])
@endsection
@section('content')

<div class="card"  >
	<div class="card-body">
		<div class="card-action-filter">
			<form method="post" class="basicform_with_reload" action="{{ route('admin.demo-accounts.changeStatus') }}">
				@csrf
				<div class="row">
					<div class="col-lg-6">
						<div class="d-flex">
							<div class="single-filter">
								<div class="form-group">
									<select class="form-control selectric" name="status">
                              <option disabled selected>{{ __('Select Action') }}</option>
										<option value="1">{{ __('Active') }}</option>
										<option value="0">{{ __('Deactivate') }}</option>
									</select>
								</div>
                            </div>
                            
							<div class="single-filter">
								<button type="submit" class="btn btn-primary btn-lg ml-2 basicbtn">{{ __('Apply') }}</button>
                            </div>
                            
						</div>
					</div>
					<div class="col-lg-6">
						
						<div class="add-new-btn">
							<a href="{{ route('admin.demo-accounts.create') }}" class="btn btn-primary float-right">{{ __('Create New') }}</a>
						</div>
						
					</div>
				</div>
			</div>
			<div class="table-responsive custom-table">
				<table class="table">
					<thead>
						<tr>
							<th>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input checkAll" id="customCheck12">
									<label class="custom-control-label checkAll" for="customCheck12"></label>
								</div>
							</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Email') }}</th>
                            <th>{{ __('Mobile') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Action') }}</th>
						</tr>
					</thead>
					<tbody>
						@foreach($users as $row)
						<tr>
							<td>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="ids[]" class="custom-control-input" id="customCheck{{ $row->id }}" value="{{ $row->id }}">
									<label class="custom-control-label" for="customCheck{{ $row->id }}"></label>
								</div>
							</td>
							<td>
                                {{ $row->name }}
                            </td>
                            <td>
                               {{ $row->email }}
                            </td>
							<td>
								{{ $row->mobile }}
							 </td>
							<td>
								@if($row->status==1)
									<span class="badge badge-success">{{ __('Active') }}</span>
								@else
									<span class="badge badge-danger">{{ __('Deactive') }}</span>
								@endif
							</td>
                        	<td>
								<a class="btn btn-primary" href="{{ route('admin.demo-accounts.edit', $row->id) }}">{{ __('Edit') }}</a>
							</td>
							
						</tr>
						@endforeach
					</tbody>
				</form>
			
			</table>
			
			{{ $users->links('vendor.pagination.bootstrap-4') }}

		</div>
	</div>
</div>
@endsection
@section('end_body')
<script src="{{ asset('assets/js/form.js') }}"></script>
@endsection

