@extends('layouts.admin')
@section('title', 'Admin: Email List')
@section('head')
@include('layouts.partials.headersection',['title'=>'Emails'])

<style>
	.custom-switch-input:checked ~ .custom-switch-indicator {
	    background: #31ce55;
	}
</style>
@endsection
@section('content')

<div class="card"  >
	<div class="card-body">
		<div class="row mb-30">
			<div class="col-lg-6">
				<h4>{{ __('Email List') }}</h4>
			</div>
			<div class="col-lg-6">
				
			</div>
		</div>
		<br>
		<div class="card-action-filter">
			<form method="post" class="basicform_with_reload" action="{{ route('admin.emailmanages.destroys') }}">
				@csrf
				<div class="row">
					<div class="col-lg-6">
						<div class="d-flex">
							<div class="single-filter">
								<div class="form-group">
									<select class="form-control selectric" name="status">
										<option disabled="" selected="">Select Action</option>
										<option value="delete">{{ __('Delete Permanently') }}</option>
									</select>
								</div>
							</div>
							<div class="single-filter">
								<button type="submit" class="btn btn-primary btn-lg ml-2">{{ __('Apply') }}</button>
							</div>
						</div>
					</div>

					<div class="col-lg-6">
						<div class="add-new-btn">
							<a href="{{ route('admin.emailmanages.create') }}" class="btn btn-primary float-right">{{ __('Add New Email') }}</a>
						</div>
					</div>
				</div>
			</div>
			<div class="table-responsive custom-table">
				@if (count($emails) >= 1)
			
				<table class="table">
					<thead>
						<tr>
							<th class="am-select">
								<div class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input checkAll" id="selectAll">
									<label class="custom-control-label checkAll" for="selectAll"></label>
								</div>
							</th>
							<th class="am-title">{{ __('Subject') }}</th>
							<th class="am-title">{{ __('Status') }}</th>
							<th class="am-date" style="min-width: 200px;">{{ __('Action') }}</th>
						</tr>
					</thead>
					<tbody>
						@foreach($emails as $email)
						<tr id="blog_id_{{ $email->id }}">
							<th>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="ids[]" class="custom-control-input" id="customCheck{{ $email->id }}" value="{{ $email->id }}">
									<label class="custom-control-label" for="customCheck{{ $email->id }}"></label>
								</div>
							</th>
							<td>
								{{ $email->subject }}
							</td>

							<td>
								@if ($email->status == 1)
									<span class="badge badge-success">{{ __('Active') }}</span>
								@elseif($email->status == 0)
									<span class="badge badge-danger">{{ __('Inactive') }}</span>
								@endif
							</td>
							
							<td>
								<a class="btn btn-icon icon-left btn-primary" href="{{ route('admin.emailmanages.edit',$email->id) }}" ><i class="fa fa-edit"></i></a>
							</td>
							
						</tr>
						@endforeach
					</tbody>
				</form>

			</table>
			@else
			<div class="card-body">
				<h3>{{ Config::get('constants.no_record_found') }}</h3>
			</div>
			@endif
			{{ $emails->links('vendor.pagination.bootstrap-4') }}

		</div>
	</div>
</div>
@endsection
@section('end_body')
	<script>
		$(".basicform_with_reload").on('submit', function(e){
			e.preventDefault();
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			var basicbtnhtml=$('.basicbtn').html();
			$.ajax({
				type: 'POST',
				url: this.action,
				data: new FormData(this),
				dataType: 'json',
				contentType: false,
				cache: false,
				processData:false,
				beforeSend: function() {
					
					$('.basicbtn').html("Please Wait....");
					$('.basicbtn').attr('disabled','')

				},
				
				success: function(response){ 
					$('.basicbtn').removeAttr('disabled')
					if (response.status == true) {
                        Sweet('success',response.message);
					} else {
						Sweet('error',response.message);
					}
					
					$('.basicbtn').html(basicbtnhtml);
					setTimeout(function(){
						location.reload();
					},2000);
				},
				error: function(xhr, status, error) 
				{
					$('.basicbtn').html(basicbtnhtml);
					$('.basicbtn').removeAttr('disabled')
					$('.errorarea').show();
					$.each(xhr.responseJSON.errors, function (key, item) 
					{
						Sweet('error',item)
						$("#errors").html("<li class='text-danger'>"+item+"</li>")
					});
					errosresponse(xhr, status, error);
				}
			})
		});
	</script>
@endsection

