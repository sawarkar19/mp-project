@extends('layouts.admin')
@section('title', 'Admin: Admins')
@section('head')
@include('layouts.partials.headersection',['title'=>'Add Admin'])
@endsection
@section('content')

<div class="row">
	<div class="col-lg-9">      
		<div class="card">
			<div class="card-body">
				
				<form method="post" action="{{ route('admin.users.store') }}" id="pageform" enctype="multipart/form-data">
					@csrf
					<div class="pt-20">
						@php
						$arr['title']= 'Name';
						$arr['id']= 'name';
						$arr['type']= 'text';
						$arr['placeholder']= 'Enter Name';
						$arr['name']= 'name';
						$arr['is_required'] = true;
						echo  input($arr);
                      
						$arr['title']= 'Email';
						$arr['id']= 'email';
						$arr['type']= 'email';
						$arr['placeholder']= 'Enter Email';
						$arr['name']= 'email';
						$arr['is_required'] = true;
                        echo  input($arr);

						$arr['title']= 'Mobile';
						$arr['id']= 'mobile';
						$arr['type']= 'number';
						$arr['placeholder']= 'Enter Mobile';
						$arr['name']= 'mobile';
						$arr['is_required'] = true;
                        echo  input($arr);
                        
                        $arr['title']= 'Password';
						$arr['id']= 'password';
						$arr['type']= 'password';
						$arr['placeholder']= 'Enter password';
						$arr['name']= 'password';
						$arr['is_required'] = true;
                        echo  input($arr);
                        
                        $arr['title']= 'Confirm Password';
						$arr['id']= 'password_confirmation';
						$arr['type']= 'password';
						$arr['placeholder']= 'Confirm Password';
						$arr['name']= 'password_confirmation';
						$arr['is_required'] = true;
						echo  input($arr);
						@endphp

						<div class="form-group">
							<label for="password_confirmation">Select Role</label>
							<select name="user_role" class="form-control" id="user_role" required>
								<option value="4">SEO Manager</option>
								<option value="5">Account</option>
								<option value="7">Support</option>
								<option value="8">Designer</option>
							</select>
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
						window.location.href = '{{ route('admin.users.index') }}';
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

