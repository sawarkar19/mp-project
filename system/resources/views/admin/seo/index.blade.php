@extends('layouts.admin')
@section('title', 'Admin: SEO')
@section('head')
@include('layouts.partials.headersection',['title'=>'Seo Info'])
@endsection
@section('content')

<div class="card"  >
	<div class="card-body">
		<div class="alert alert-success text-white none">
			<ul id="success" class="text-white"></ul>
		</div>		
		<form method="post"  class="basicform" action="{{ route('admin.seo.store') }}">
			@csrf
			<div class="custom-form">
				<div class="row">
					<div class="form-group col-lg-6">
						<label for="title">{{ __('Site Title') }}</label>
						<input type="text" name="title"  id="title" class="form-control" value="{{ $info->title ?? '' }}" placeholder="Site Title">
					</div>
					<div class="form-group col-lg-6">
						<label for="twitterTitle">{{ __('Twitter Title') }}</label>
						<input type="text" name="twitterTitle"  id="twitterTitle" class="form-control" value="{{ $info->twitterTitle  ?? ''}}" placeholder="Twiiter Title">
					</div>
					<div class="form-group col-lg-6">
						<label for="canonical ">{{ __('Canonical URL') }}</label>
						<input type="text" name="canonical"  id="canonical" class="form-control" value="{{ $info->canonical ?? '' }}" placeholder="Canonical URL">
					</div>
					<div class="form-group col-lg-6">
						<label for="tags">{{ __('Tags') }}</label>
						<input type="text" name="tags"  id="tags" class="form-control" value="{{ $info->tags ?? '' }}" placeholder="Tags">
					</div>
					<div class="form-group col-lg-12">
						<label for="image_path">{{ __('Image Path') }}</label>
						<input type="url" name="image_path"  id="image_path" class="form-control" value="{{ $info->image_path ?? '' }}" placeholder="Image Path">
					</div>
					<div class="form-group col-lg-12">
						<label for="description">{{ __('Site description') }}</label>
						<textarea name="description" id="description" class="form-control" cols="30" rows="10">{{ $info->description ?? '' }}</textarea>
					</div>
					<div class="form-group col-lg-12">
						<button class="btn btn-primary col-12 basicbtn" type="submit">{{ __('Update') }}</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<div class="card"  >
	<div class="card-body">
		<div class="alert alert-success text-white none">
			<ul id="success" class="text-white"></ul>
		</div>		

		<form method="post" action="{{ route('admin.seo.sitemap') }}">
			@csrf()			
						
			<div class="custom-form">
				<h4 for="sitemap">Sitemap</h4>
				<hr>
				<div class="form-group">
					<input type="text" disabled="" class="form-control" value="{{ url('/').'/sitemap_index.xml' }}">
				</div>
				<div class="form-group">
					<button class="btn btn-primary col-12 basicbtn" type="submit">Update Sitemap</button>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection
@section('end_body')
<script src="{{ asset('assets/js/form.js') }}"></script>
@endsection

