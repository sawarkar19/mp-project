@extends('layouts.seo')
@section('title', 'Admin: Blogs')
@section('head')
<link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" />

@include('layouts.partials.headersection',['title'=>'Add New Blog'])
<style>
  #error{color:#ff0000;}
  #success{color:green;}
</style>
@endsection
@section('content')

<div class="row">
	<div class="col-lg-9">      
		<div class="card">
			<div class="card-body">
				<form id="blogform" method="post" action="{{ route('seo.blog.store') }}" enctype="multipart/form-data">
					@csrf
					<div class="custom-form pt-20">

						<div class="form-group">
							<label for="name">Title</label>
							<input type="text" placeholder="Title" name="title" class="form-control" id="name">
						</div>

						<div class="form-group">
							<label for="description">Content</label>
							<textarea name="description" class="form-control editor description" id="description" ></textarea>
						</div>

						<div class="form-group">
							<label for="image">Featured Image</label>
							<input type="file" placeholder="Title" name="blog_banner" class="form-control" id="image">
						</div>

						<div class="col-4">
							<img id="preview_oi" />
						</div><br>

						<div class="form-group">
							<label for="meta_title">Meta Title</label>
							<input type="text" placeholder="Meta Title" name="meta_title" class="form-control" id="meta_title">
						</div>

						<div class="form-group">
							<label for="meta_keyword">Meta Keyword</label>
							<input type="text" placeholder="Meta Keyword" name="meta_keyword" class="form-control" id="meta_keyword">
						</div>

						<div class="form-group">
							<label for="meta_description">Meta Description</label>
							<textarea name="meta_description" class="form-control " cols="30" rows="3" placeholder="Meta Description" id="meta_description" maxlength=""></textarea>
						</div>						
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-3">
			<div class="single-area">
				<div class="card">
					<div class="card-body">						
						<div class="btn-publish">
							<button type="submit" class="btn btn-primary col-12"><i class="fa fa-save"></i> {{ __('Save') }}</button>
						</div>
					</div>
				</div>
			</div>
		<div class="single-area">
				<div class="card sub">
					<div class="card-body">
						<h5>{{ __('Status') }}</h5>
						<hr>
						<select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="status">
							<option value="1">{{ __('Published') }}</option>
							<option value="0">{{ __('Draft') }}</option>
						</select>
					</div>
				</div>
				<div class="card sub">
					<div class="card-body">
						<h5>{{ __('Is Featured') }}</h5>
						<hr>
						<select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="featured">
							<option value="0">{{ __('No') }}</option>
							<option value="1">{{ __('Yes') }}</option>
						</select>
					</div>
				</div>
								<div class="card sub">
					<div class="card-body">
						<h5>{{ __('Add Tags') }}</h5>
						<hr>                        
						<input type="text" id="tag" value="" class="form-control">
						<input type="button" name="tag" value="Add" class="btn btn-primary col-12" style="margin-top:10px;" onclick="add_tags()">
						<span id="error"></span>
						<span id="success"></span>
					</div>
				</div>

				<div class="card sub">
					<div class="card-body">
						<h5>{{ __('Select Tags') }}</h5>
						<hr> 
						<select multiple class="form-control select2" name="tags[]" id="tag_listing">

						  @foreach($all_tags as $result)
						  <option value="{{$result->id}}" @foreach($selectTags as $tag_id) @if($result->id == $tag_id)selected="selected"@endif @endforeach>{{$result->tag}}</option>
						  @endforeach
						</select>
					</div>
				</div>
			</div>
		</div>
</form>
@endsection
@section('end_body')
	@include('seo.blog.customjs')
@endsection

