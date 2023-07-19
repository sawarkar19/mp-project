@extends('layouts.admin')
@section('title', 'Admin: Subcribers')
@section('head')
@include('layouts.partials.headersection',['title'=>'Subscriber Details'])
@endsection
@section('content')

<section class="section">
	<div class="section-body">
		<div class="row mt-sm-4">
			<div class="col-12 col-md-12 col-lg-5">
				<div class="card profile-widget">
					{{-- <div class="profile-widget-header">                     
						
						<div class="profile-widget-items">
							
							<div class="profile-widget-item">
								<div class="profile-widget-item-label">{{ __('Plan') }}</div>
								<div class="profile-widget-item-value">{{ $user_info->user_plan->plan_info->name ?? 'Free Plan' }}</div>
							</div>

							<div class="profile-widget-item">
								<div class="profile-widget-item-label">{{ __('Will Expired') }}</div>
								<div class="profile-widget-item-value">{{ \Carbon\Carbon::parse($user_info->user_plan->will_expire_on)->toFormattedDateString() ?? 'Never' }}</div>
							</div>

							<div class="profile-widget-item">
								<div class="profile-widget-item-label">{{ __('Status') }}</div>
								<div class="profile-widget-item-value"> @if($user_info->status==1) <span class="badge badge-success">{{ __('Active') }}</span>
									@elseif($user_info->status==0) <span class="badge badge-danger">{{ __('Trash') }}</span>
									@elseif($user_info->status==2) <span class="badge badge-warning">{{ __('Suspended') }}</span>
									@elseif($user_info->status==3) <span class="badge badge-warning">{{ __('Active') }}</span>
								@endif</div>
							</div>
						</div>
					</div> --}}
					<div class="profile-widget-description">
						<div class="profile-widget-name"> Subscriber Details </div>
						<ul class="list-group">
							<li class="list-group-item">{{ __('Name :') }} <b>{{ $user_info->name }}</b></li>
							<li class="list-group-item">{{ __('Mobile :') }} <b>{{ $user_info->mobile }}</b></li>
							<li class="list-group-item">{{ __('Email :') }} <b>{{ $user_info->email }}</b></li>
                           
							<li class="list-group-item">{{ __('Joining Date:') }} <b>{{ $user_info->created_at->toFormattedDateString() }}</b></li>
						</ul>

					</div>
					
				</div>
				
			</div>
			<div class="col-12 col-md-12 col-lg-7">
				<div class="card">
					<form method="post" id="productform" novalidate="" action="{{ route('admin.email.store') }}">
						@csrf
						<div class="card-header">
							<h4>{{ __('Send Email') }} </h4>
						</div>
						<div class="card-body">
							
							<div class="row">
								<div class="form-group col-md-6 col-12">
									<label>{{ __('Mail To') }}</label>
									<input type="email" name="email" class="form-control" value="{{ $user_info->email }}" required="" readonly>
									
								</div>
							
								<div class="form-group col-md-6 col-12">
									<label>{{ __('Subject') }}</label>
									<input type="text" class="form-control" required="" name="subject">
									
								</div>
							</div>
							
							<div class="row">
								<div class="form-group col-12">
									<label>{{ __('Message') }}</label>
									<textarea class="form-control" id="copyContent" required="" name="message"></textarea>
									{{-- <input type="hidden" id="copyContent" name="content" value=""> --}}
								</div>
							</div>
							<button class="btn btn-primary basicbtn" type="submit">{{ __('Send') }}</button>
						</div>
						
					</form>
				</div>
			</div>
			<div class="col-12 row">
				{{--<div class="col-4 col-md-4 col-lg-4">
					<div class="card profile-widget">
						<div class="profile-widget-header">
							<div class="profile-widget-items">
								<div class="profile-widget-item">
									<div class="profile-widget-item-label">Current Plan</div>
									<div class="profile-widget-item-value">Get Users Current Plan Detail</div>
								</div>
							</div>
						</div>
						<div class="profile-widget-description" style="text-align:center;">
							<button class="btn btn-primary" onclick="window.location.href = '{{ route('admin.customer.planInfo', $user_info->id) }}'">View Plan</button>
						</div>
					</div>
				</div>--}}
				<div class="col-4 col-md-4 col-lg-4">
					<div class="card profile-widget">
						<div class="profile-widget-header">
							<div class="profile-widget-items">
								<div class="profile-widget-item">
									<div class="profile-widget-item-label">User Management</div>
									<div class="profile-widget-item-value">Manage Users</div>
								</div>
							</div>
						</div>
						<div class="profile-widget-description" style="text-align:center;">
							<button class="btn btn-primary" onclick="window.location.href = '{{ route('admin.customer.userInfo', $user_info->id) }}'">View Users</button>
						</div>
						
					</div>
				</div>
				<div class="col-4 col-md-4 col-lg-4">
					<div class="card profile-widget">
						<div class="profile-widget-header">
							<div class="profile-widget-items">
								<div class="profile-widget-item">
									<div class="profile-widget-item-label">User Transaction History</div>
									<div class="profile-widget-item-value">Plan Purchase History</div>
								</div>
							</div>
						</div>
						<div class="profile-widget-description" style="text-align:center;">
							<button class="btn btn-primary" onclick="window.location.href = '{{ route('admin.customer.history', $user_info->id) }}'">Get History</button>
						</div>
					</div>
				</div>
				<div class="col-4 col-md-4 col-lg-4">
					<div class="card profile-widget">
						<div class="profile-widget-header">
							<div class="profile-widget-items">
								<div class="profile-widget-item">
									<div class="profile-widget-item-label">Send Password Email</div>
									<div class="profile-widget-item-value">Regenerate Password Link</div>
								</div>
							</div>
						</div>
						<div class="profile-widget-description" style="text-align:center;">
							<button class="btn btn-primary" id="sendPasswordEmail">Regenerate Password</button>
						</div>
					</div>
				</div>
				
			</div>
		</div>

		{{-- <div class="row">
			<div class="col-12 col-md-12">
				<div class="card">
					<div class="card-header">
						<h4>{{ __('Plan Purchase History') }}</h4>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-striped table-hover text-center table-borderless">
								<thead>
									@if(count($plan_history)==0)
										<tr>
											<th>{{ __('Free Plan Is Active!') }}</th>
										</tr>
									@else
										<tr>
											<th>{{ __('Invoice No') }}</th>
											<th>{{ __('Plan Name') }}</th>
											<th>{{ __('Price') }}</th>
											<th>{{ __('Payment Method') }}</th>
											<th>{{ __('Payment Id') }}</th>

											<th>{{ __('Created at') }}</th>
											<th>{{ __('View') }}</th>
										</tr>
									@endif
								</thead>
								<tbody>
									@if(count($plan_history)==0)
									@else
										@foreach($plan_history as $row)
										@isset($row->payment_method->transaction_id)
										<tr>
											<td>{{ $row->order_no }}</td>
											<td>{{ $row->plan_info->name }}</td>
											<td>{{ $row->amount }}</td>
											<td>{{ $row->payment_method->method->name ?? '' }}</td>
											<td>{{ $row->payment_method->transaction_id ?? '' }}</td>
											<td>{{ $row->created_at->format('d-F-Y') }}</td>
											<td><a href="{{ route('admin.customer.planInfo',$row->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a></td>
										</tr>
										@endisset
										@endforeach
									@endif
								</tbody>
							</table>
							{{ $plan_history->links('vendor.pagination.bootstrap-4') }}
						</div>
					</div>
				</div>
			</div>	
		</div> --}}


	</div>

</section>
@endsection
@section('end_body')
	<script type="text/javascript" src="{{ asset('assets/js/ckeditor/ckeditor.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/form.js?v=1.0') }}"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			var content = CKEDITOR.instances['copyContent'].getData();
		});
		$(document).on('click', '#sendPasswordEmail', function(){
			var btn = $(this);
			var btnhtml = btn.text();
			var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
			var input = {
				"user_id" : "{{ $user_info->id }}",
				"_token" : CSRF_TOKEN
			};
			$.ajax({
				url : '{{ route('admin.customers.resendEmail') }}',
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
	</script>
@endsection

