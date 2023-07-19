@extends('layouts.admin')
@section('title', 'Admin: Admins')
@section('head')
@include('layouts.partials.headersection',['title'=>'Edit Admin'])
@endsection
@section('content')

<div class="row">
	<div class="col-lg-9">      
		<div class="card">
			<div class="card-body">
				
				<form method="post" action="{{ route('admin.users.update',$user->id) }}" id="pageform" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
					<div class="pt-20">
						@php
						$arr['title']= 'Name';
						$arr['id']= 'name';
						$arr['type']= 'text';
						$arr['placeholder']= 'Enter Name';
						$arr['name']= 'name';
                        $arr['is_required'] = true;
                        $arr['value']=$user->name;
						echo  input($arr);
                      
						$arr['title']= 'Email';
						$arr['id']= 'email';
						$arr['type']= 'email';
						$arr['placeholder']= 'Enter Email';
						$arr['name']= 'email';
                        $arr['is_required'] = true;
                        $arr['value']=$user->email;
                        echo  input($arr);

                        $arr['title']= 'Mobile';
						$arr['id']= 'mobile';
						$arr['type']= 'number';
						$arr['placeholder']= 'Enter Mobile';
						$arr['name']= 'mobile';
						$arr['is_required'] = true;
						$arr['value']=$user->mobile;
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
								<option value="4" @if($user->role_id==4) selected @endif>SEO Manager</option>
								<option value="5" @if($user->role_id==5) selected @endif>Account</option>
								<option value="7" @if($user->role_id==7) selected @endif>Support</option>
								<option value="8" @if($user->role_id==8) selected @endif>Designer</option>
							</select>
						</div>

                        
                        <div class="form-group">
                        <label>{{ __('Status') }}</label>
                        <select name="status" class="form-control">
                            <option value="1" @if($user->status==1) selected @endif>Active</option>
                            <option value="0"  @if($user->status==0) selected @endif>Deactive</option>

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
				<div class="card">
					<div class="card-body">
						<h5>{{ __('Send Credentials Email') }}</h5>
						<hr>
						<div class="btn-publish">
							<button type="button" class="btn btn-primary col-12" id="sendEmail"><i class="fa fa-paper-plane"></i> {{ __('Send Mail') }}</button>
						</div>
					</div>
				</div>
			</div>			
		</div>
	</form>
@endsection
@section('end_body')
	<script src="{{ asset('assets/js/form.js') }}"></script>
	<script type="text/javascript">
		$(document).on('click', '#sendEmail', function(){
			var btn = $(this);
			var btnhtml = btn.text();
			var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
			var input = {
				"user_id" : "{{ $user->id }}",
				"_token" : CSRF_TOKEN
			};
			$.ajax({
				url : '{{ route('admin.users.resendEmail') }}',
				type : 'POST',
				data : input,
				dataType : "json",
				beforeSend: function() {	       			
	       			btn.attr('disabled','')
	       			btn.html('Please Wait....')
	    		},
				success : function(response) {
					if(response.type == "error"){
						$(".error").html(response.message);
						$(".success").hide();
					}else if(response.type == "success"){
						$(".success").html(response.message);
					}
					btn.removeAttr('disabled');
					btn.html(btnhtml);
				}
			});
		});

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

