@extends('layouts.front')

@if ($blog->meta_title != null) @section('title', $blog->meta_title) @endif
@if ($blog->meta_description != null) @section('description', $blog->meta_description) @endif
@if ($blog->meta_keyword != null) @section('keywords', $blog->meta_keyword) @endif
@if ($blog->image != null) @section('image', asset('assets/blogs/banners/'.$blog->image)) @endif

@section('end_head')
<style type="text/css">
	.excerpt{
		font-size: 12px;
	}
	.pro-img{
		width: 100px;
	}

	.author_info .au_name{
		color: var(--color-thm-lth);
		text-transform: capitalize;
		margin-bottom: 0px;
	}
	.au_social{
		position: relative;
		display: flex;
		flex-direction: row;
		list-style: none;
		padding-left: 0px;
	}
	.au_social .au_sl_list{
		margin-right: 15px;
		font-size: 20px;
	}
	.au-dp{
		position: relative;
		width: 80px;
		height: 80px;
		border-radius: 50%;
		background-color: #f2f2f2;
		background-position: center;
		background-size: cover;
		box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.08);
		background-image: url({{asset('assets/front/images/no-preview.jpg')}});
	}
</style>
@endsection

@section('content')

<section id="header-banner">
	<div class="py-5">
		<div class="container">
			<div class="mb-5 mb-xl-0 pb-5">
				<a href="{{url('')}}"><img src="{{ asset('assets/front/images/logo-dark.svg') }}" class="main_logo" alt="OpenLink"></a>
			</div>
		</div>

		<div class="container pe-sm-0 ps-sm-0 pb-5">
			<div class="">
				<h1 class="">{{$blog->title}}</h1>
				<div class="text-muted small">
					<span>{{\Carbon\Carbon::parse($blog->created_at)->format('d M, Y')}}</span>
					@if ($user->name != NULL)
					<span class="color-drk">|</span> <span>{{$user->name}}</span>
					@endif
					@if ($user->designation != NULL)
					<span class="color-drk">|</span> <span>{{$user->designation}}</span>
					@endif
				</div>
			</div>
		</div>

		<div class="container">
			<div class="row">
				<div class="col-lg-8 mb-5 mb-lg-0">
					
					@if($blog->image != '')
					<div class="mb-4">
						<img src="{{asset('assets/blogs/banners/'.$blog->image)}}" class="img-fluid" alt="OpenLink">
					</div>
					@endif

					<style>
						.post-content h3{
							font-size: 1.60rem;
							color: #585858;
						}
						.post-content h4{
							font-size: 1.25rem!important;
						}
						.post-content img{
							max-width: 100%!important;
							height: auto!important;
						}
					</style>

					<div class="post-content">
						{!!$blog->content!!}
					</div>

					<hr class="my-5">

					<div class="author_card card border-0 shadow-sm">
						<div class="card-body w-100">
							<div class="row">
								<div class="col-sm-3 col-xl-2">
									<div class="au-dp mx-sm-auto mb-2" @if($user->profile_pic != '') style="background-image:url({{asset('assets/blogs/authors/'.$user->profile_pic)}});" @endif></div>
								</div>
								<div class="col-sm-9 col-xl-10">
									<div class="author_info">
										<h4 class="au_name">{{$user->name}}</h4>
										<p class="text-muted small mb-2">{{$user->designation}}</p>
										<p class="au_bio">{{$user->bio}}</p>
										<ul class="au_social">
											@if ($user->facebook_profile != '')<li class="au_sl_list"><a href="{{$user->facebook_profile}}" target="_blank" title="Facebook"><i class="bi bi-facebook" style="color:#4267B2;"></i></a></li> @endif
											@if ($user->instagram_profile != '')<li class="au_sl_list"><a href="{{$user->instagram_profile}}" target="_blank" title="Instagram"><i class="bi bi-instagram" style="color:#3f729b;"></i></a></li>@endif
											@if ($user->linkedin_profile != '')<li class="au_sl_list"><a href="{{$user->linkedin_profile}}" target="_blank" title="LinkedIn"><i class="bi bi-linkedin" style="color:#0e76a8;"></i></a></li>@endif
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
				

				{{-- ====================================Sidebar============================================ --}}
				<div class="col-lg-4">
	                <div class="sticky-top sdbr-sk">
	                    @include('layouts.front.sidebar')
	                </div>
	            </div>

				
			</div>
		</div>
	</div>
</section>

@endsection