@extends('layouts.app')
@section('head')
@include('layouts.partials.headersection',['title'=>'Banner Ads'])
@endsection
@section('content')
@if(Session::has('error'))
<div class="row">
	<div class="col-sm-12">
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
			<strong>{{ Session::get('error') }}</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	</div>
</div>
@endif
<div class="card">
	<div class="card-body">

		<div class="float-left mb-2">
			<button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">{{ __('Create New') }}</button>				
		</div>
		<div class="table-responsive custom-table">
			<table class="table">
				<thead>
					<tr>
						<th class="am-title">{{ __('Image') }}</th>
						<th class="am-title">{{ __('Url') }}</th>
						<th class="text-right">{{ __('Last Modified') }}</th>
						<th class="text-right">{{ __('Action') }}</th>
					</tr>
				</thead>
				<tbody>
				    <?php                      
					  $posts=App\Category::where('type','banner_ads')->where('user_id',Auth::id())->latest()->get();
					  foreach($posts as $row){
					?>					
					<tr>
						<td class="text-left"><img src="{{ asset($row->name) }}" height="100"></td>
						<td class="text-left">{{ $row->slug }}</td>
						<td class="text-right">{{ $row->updated_at->diffForHumans() }}</td>
						<td class="text-right">
						<button class="btn btn-primary" data-toggle="modal" data-target="#editModal{{ $row->id }}"><i class="fa fa-edit"></i></button>
						<a href="{{ route('seller.ad.destroy',$row->id) }}" class="btn btn-danger  cancel"><i class="fa fa-trash"></i></a>
						</td>
					</tr>
					<!-- Modal -->
						<div class="modal fade" id="editModal{{ $row->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $row->id }}" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered modal-lg">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="editModalLabel{{ $row->id }}">{{ __('Edit Ads') }}</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<form method="post" action="{{ route('seller.ads.update',11) }}" class="basicform_with_reload">
											@csrf
											@method('PUT')
											<div class="form-group">
												<label>{{ __('Select Image') }}</label>
												<input type="file" accept="Image/*" name="file" class="form-control"> 
												<p class="margin0 specify-product-size">Banner Image size must be 1110px X 368px</p>
												<img src="{{ asset($row->name) }}" height="100">
											</div>
											<div class="form-group">
												<label>{{ __('Url') }}</label>
												<input type="text"  name="url" required="" value="{{ asset($row->slug) }}" class="form-control"> 
											</div>

										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
											<button type="submit" class="btn btn-primary basicbtn">{{ __('Submit') }}</button>
											<input type="hidden"  name="id" value="{{ $row->id }}" class="form-control">
										</form>
									</div>
								</div>
							</div>
						</div>
					<?php }	?>
				</tbody>
			</table>
		</div>
	</div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">{{ __('Add Ads') }}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="{{ route('seller.ads.update',11) }}" class="basicform_with_reload">
					@csrf
					@method('PUT')
					<div class="form-group">
						<label>{{ __('Select Image') }}</label>
						<input type="file" accept="Image/*" name="file" required="" class="form-control"> 
						<p class="margin0 specify-product-size">Banner Image size must be 1110px X 368px <span class="text-danger">*</span></p>
					</div>
					<div class="form-group">
						<label>{{ __('Url') }}</label>
						<input type="text"  name="url" required="" value="#" class="form-control"> 
					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
					<button type="submit" class="btn btn-primary basicbtn">{{ __('Submit') }}</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
@push('js')
<script src="{{ asset('assets/js/form.js') }}"></script>
@endpush