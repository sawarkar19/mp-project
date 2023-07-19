@extends('layouts.seo')
@section('title', 'Admin: Blog List')
@section('head')
@include('layouts.partials.headersection',['title'=>'Blogs'])

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
				<h4>{{ __('Blog List') }}</h4>
			</div>
			<div class="col-lg-6">
				
			</div>
		</div>
		<br>
		<div class="card-action-filter">
			<form method="post" class="basicform_with_reload" action="{{ route('seo.blogs.destroys') }}">
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
							<a href="{{ route('seo.blog.create') }}" class="btn btn-primary float-right">{{ __('Add New Blog') }}</a>
						</div>
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
							<th class="am-title">{{ __('Title') }}</th>
							<th class="am-title">{{ __('Url') }}</th>
							{{-- <th class="am-date">{{ __('Last Update') }}</th> --}}
							<th class="am-date" style="min-width: 200px;">{{ __('Action') }}</th>
						</tr>
					</thead>
					<tbody>
						@foreach($blogs as $blog)
						<tr id="blog_id_{{ $blog->id }}">
							<th>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="ids[]" class="custom-control-input" id="customCheck{{ $blog->id }}" value="{{ $blog->id }}">
									<label class="custom-control-label" for="customCheck{{ $blog->id }}"></label>
								</div>
							</th>
							<td>
								{{ $blog->title }}
							</td>
							<input type="text" class="offscreen" id="myUrl{{ $blog->id }}" value="{{ url('/blogs',$blog->slug)  }}">
							<td><a href="{{ url('/blogs',$blog->slug)  }}" target="_blank">{{ url('/blogs',$blog->slug)  }}</a></td>
							
							{{-- <td>{{ __('Last Modified') }}
								<div class="date">
									{{ $blog->created_at->diffForHumans() }}
								</div>
							</td> --}}
							
							<td>
								<a class="btn btn-icon icon-left btn-primary" href="{{ route('seo.blog.edit',$blog->id) }}" ><i class="fa fa-edit"></i></a>
								@if(Auth::user()->role_id == 1)
								<a class="btn btn-icon icon-left btn-danger delete-item" id="{{ $blog->id }}" href="#"><i class="fa fa-trash"></i></a>
								<label class="custom-switch pl-0 btn">
                                    <input type="checkbox" id="{{ $blog->id }}" class="custom-switch-input change-item-status" @if($blog->status == 1) checked @endif>
                                    <span class="custom-switch-indicator" style="margin-left: 10px;"></span>
                                </label>
                                @endif
							</td>
							
						</tr>
						@endforeach
					</tbody>
				</form>

			</table>
			{{ $blogs->links('vendor.pagination.bootstrap-4') }}

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
					Sweet('success',response);
					$('.basicbtn').html(basicbtnhtml);
					location.reload();
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

		$(document).on('click', '.delete-item', function(e){
			e.preventDefault();
			var blog_id = $(this).attr('id');

			var confirmation = confirm("Do you really want to remove this blog?");
		    if (confirmation) {
			    $.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				}); 

				var url = '{{ route("seo.blogs.destroyBlog", ":id") }}';
            	url = url.replace(':id', blog_id);

				$.ajax({
					type: 'POST',
					url:  url,
					data: {
						blog_id : blog_id
					},
					dataType: 'json',
					success: function(response){
						Sweet('success',response.message);
						$('#blog_id_'+blog_id).css('display','none');
					},
					error: function(xhr, status, error){
						Sweet('error','Page not removed');
					} 

				})
		    }
		});

		$(document).on('change', '.change-item-status', function(e){
			e.preventDefault();

			var blog_id = $(this).attr('id');
			
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			}); 

			var url = '{{ route("seo.blogs.changeBlogStatus", ":id") }}';
        	url = url.replace(':id', blog_id);

			$.ajax({
				type: 'POST',
				url:  url,
				data: {
					blog_id : blog_id
				},
				dataType: 'json',
				success: function(response){
					Sweet('success',response.message);
					$('#'+response.hide).hide();
					$('#'+response.show).show();
				},
				error: function(xhr, status, error){
					Sweet('error','Page status not changed');
				} 

			})
		});
	</script>
@endsection

