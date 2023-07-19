@extends('layouts.admin')
@section('title', 'Admin: Demo accounts')
@section('head')
@include('layouts.partials.headersection',['title'=>'Add Demo Account'])
@endsection
@section('content')

<div class="row">
	<div class="col-lg-9">      
		<div class="card">
			<div class="card-body">
				
				<form method="post" action="{{ route('admin.demo-accounts.store') }}" id="pageform" enctype="multipart/form-data">
					@csrf
					<div class="pt-20">
					
						<div class="form-group">
							<label for="name">Name <span class="text-danger">*</span></label>
							<input type="text" name="name" id="name" class="form-control" required />
						</div>

						<div class="form-group">
							<label for="email">Email <span class="text-danger">*</span></label>
							<input type="email" name="email" id="email" class="form-control" required />
						</div>

						<div class="form-group">
							<label for="mobile">Mobile <span class="text-danger">*</span></label>
							<input type="text" name="mobile" id="mobile" minlength="10" maxlength="10" class="form-control" required />
						</div>

						<div class="form-group">
							<label for="password">Password <span class="text-danger">*</span></label>
							<input type="password" name="password" id="password" class="form-control" required />
						</div>

						<div class="form-group">
							<label for="password_confirmation">Password confirmation <span class="text-danger">*</span></label>
							<input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required />
						</div>
						
					</div>
				</div>
			</div>

		</div>
		<div class="col-lg-3">
			<div class="single-area">
				<div class="card">
					<div class="card-body">
						<h5>{{ __('Publish') }}</h5>
						<hr>
						<div class="btn-publish">
							<button type="submit" class="btn btn-primary col-12 basicbtn"><i class="fa fa-save"></i> {{ __('Save') }}</button>
						</div>
					</div>
				</div>
			</div>
	    </div>
</form>
@endsection
@section('end_body')
<script>
	$("#pageform").on('submit', function(e){
		e.preventDefault();

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
			type: 'POST',
			url: this.action,
			data: new FormData(this),
			dataType: 'json',
			contentType: false,
			cache: false,
			processData:false,
			success: function(response){ 
				console.log(response);
				if(response.status == true){
					$('#pageform').trigger('reset');
					Sweet('success',response.message);
					setTimeout(function(){
						window.location.href = '{{ route('admin.demo-accounts.index') }}';
					}, 2000);
				}else{
					Sweet('error',response.message);
				}
			},
			error: function(xhr, status, error) 
			{
				$.each(xhr.responseJSON.errors, function (key, item) 
				{
					Sweet('error',item);
				});
			}
		})
	});
</script>
@endsection

