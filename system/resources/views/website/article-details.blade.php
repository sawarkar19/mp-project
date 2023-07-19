@extends('layouts.website')

@section('title', $blog->meta_title)
@section('description', $blog->meta_description)
@section('keywords', $blog->meta_keyword)
@section('image', asset('assets/blogs/banners/'.$blog->image))

@section('end_head')
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
@endsection

@section('content')
{{-- Articles --}}
<section id="blogs-page">
    
    {{-- page heading --}}
    <div class="bg-light">
    	<div class="container">
            {{-- Breadcrumb Section --}}
            @php
                $bcrm = array(
                    array('name' => 'Articles', 'link' => route('articles')),
                    array('name' => $blog->title, 'link' => false),
                );
            @endphp
            @include('website.components.breadcrumb', $bcrm)
        </div>
        <div class="container">
			<div class="pb-5">
                {{-- Blog Title  --}}
				<h1 class="h2 font-600">{{$blog->title}}</h1>
                {{-- Author and Date --}}
                <ol class="breadcrumb text-muted small" style="--bs-breadcrumb-divider: '|';--bs-breadcrumb-divider-color: rgba(var(--color-primary), 1);">
                    <li class="breadcrumb-item active" aria-current="page">{{\Carbon\Carbon::parse($blog->created_at)->format('d M Y')}}</li>
                    @if ($user != null)
                        @if ($user->name != NULL)
                            <li class="breadcrumb-item active" aria-current="page">{{$user->name}}</li>
                        @endif
                        @if ($user->designation != NULL)
                            <li class="breadcrumb-item active" aria-current="page">{{$user->designation}}</li>
                        @endif
                    @endif
                </ol>
			</div>
		</div>
    </div>

    <div class="py-5">
        <div class="container">
			<div class="row">
				<div class="col-lg-8 mb-5 mb-lg-0">
                    
                    {{-- Articles main Image  --}}
					@if($blog->image != '')
					<div class="mb-4">
						<img src="{{asset('assets/articles/banners/'.$blog->image)}}" class="img-fluid" alt="MouthPublicity.io">
					</div>
					@endif

                    {{-- Articles Content --}}
					<div class="post-content">
						{!!$blog->content!!}
					</div>

                    
					{{-- @if ($user != null)
					<hr class="my-5">
                    <!-- Author details  -->
					<div class="author-card card border-0 shadow-sm">
						<div class="card-body w-100">
							<div class="row">
								<div class="col-sm-3 col-xl-2">
									<div class="author-dp mx-sm-auto mb-2" @if($user->profile_pic != '') style="background-image:url({{asset('assets/blogs/authors/'.$user->profile_pic)}});" @endif></div>
								</div>
								<div class="col-sm-9 col-xl-10">
									<div class="author-info">
										<h4 class="author-name h5 font-600">{{$user->name}}</h4>
										<p class="text-muted small mb-2">{{$user->designation}}</p>
										<p class="author-bio">{{$user->bio}}</p>
										<ul class="author-social">
											@if ($user->facebook_profile != '')<li class="author-social-list"><a href="{{$user->facebook_profile}}" target="_blank" title="Facebook"><i class="bi bi-facebook" style="color:#4267B2;"></i></a></li> @endif
											@if ($user->instagram_profile != '')<li class="author-social-list"><a href="{{$user->instagram_profile}}" target="_blank" title="Instagram"><i class="bi bi-instagram" style="color:#3f729b;"></i></a></li>@endif
											@if ($user->linkedin_profile != '')<li class="author-social-list"><a href="{{$user->linkedin_profile}}" target="_blank" title="LinkedIn"><i class="bi bi-linkedin" style="color:#0e76a8;"></i></a></li>@endif
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
					@endif --}}
					
				</div>


                {{-- ======= Sidebar ======= --}}
                <div class="col-lg-4">
                    @include('website.components.blogs-sidebar')
                </div>

            </div>
        </div>

    </div>
</section>

@endsection