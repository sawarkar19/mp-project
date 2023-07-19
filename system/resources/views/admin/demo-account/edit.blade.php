@extends('layouts.admin')
@section('title', 'Admin: Demo accounts')
@section('head')
@include('layouts.partials.headersection',['title'=>'Edit Demo Account'])
@endsection
@section('content')

<div class="row">
	<div class="col-lg-9">      
		<div class="card">
			<div class="card-body">
				
				<form method="post" action="{{ route('admin.demo-accounts.update',$user->id) }}" id="pageform" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
					<div class="pt-20">
						<div class="form-group">
							<label for="name">Name <span class="text-danger">*</span></label>
							<input type="text" name="name" id="name"  value="{{ $user->name }}" class="form-control" required />
						</div>

						<div class="form-group">
							<label for="email">Email <span class="text-danger">*</span></label>
							<input type="email" name="email" id="email"  value="{{ $user->email }}" class="form-control" required />
						</div>

						<div class="form-group">
							<label for="mobile">Mobile <span class="text-danger">*</span></label>
							<input type="text" name="mobile" id="mobile" minlength="10" maxlength="10" class="form-control" value="{{ $user->mobile }}" required />
						</div>

						<div class="form-group">
							<label for="password">Password <span class="text-danger">*</span></label>
							<input type="password" name="password" id="password" class="form-control" />
							<p style="font-size: 10px"><span>Note:</span><span class="text-danger">Enter only if you want to update</span></p>
						</div>

						<div class="form-group">
							<label for="password_confirmation">Password confirmation <span class="text-danger">*</span></label>
							<input type="password" name="password_confirmation" id="password_confirmation" class="form-control" />
							<p style="font-size: 10px"><span>Note:</span><span class="text-danger">Enter only if you want to update</span></p>
						</div>

						<div class="form-group">
							<label for="enable_multi_login">Enable multi login</label>
							<select name="enable_multi_login" class="form-control" id="enable_multi_login" required>
								<option value="1" @if($user->enable_multi_login==1) selected @endif>Yes</option>
								<option value="0"  @if($user->enable_multi_login==0) selected @endif>No</option>
							</select>
						</div>

						<div class="form-group">
							<label for="is_demo">Is demo account</label>
							<select name="is_demo" class="form-control" id="is_demo" required>
								<option value="1" @if($user->is_demo==1) selected @endif>Yes</option>
								<option value="0"  @if($user->is_demo==0) selected @endif>No</option>
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
				url : '{{ route('admin.demo-accounts.resendEmail') }}',
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

