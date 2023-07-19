@extends('layouts.seo')
@section('title', 'SEO: Ebooks')
@section('head')
<link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" />

@include('layouts.partials.headersection',['title'=>'Edit Ebook'])
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
				<form id="ebookform" method="post" action="{{ route('seo.ebook.BUpdate',$ebookInfo->id) }}" enctype="multipart/form-data">
					@csrf
					<div class="custom-form pt-20">

						<div class="form-group">
							<label for="name">Title</label>
							<input type="text" placeholder="Title" name="title" class="form-control" id="name" value="{{ $ebookInfo->title }}">
						</div>

						<div class="form-group">
							<label for="description">Content</label>
							<textarea name="description" class="form-control editor description" id="description" >{{  $ebookInfo->content }}</textarea>
						</div>

						<div class="form-group">
							<label for="ebook">Ebook Upload</label>
							<input type="file" placeholder="Title" name="ebook_name" class="form-control" id="ebook">
						</div>

						@if($ebookInfo->ebook_name != null)
						<div class="col-2">
							<a href="{{ URL::to('assets/ebooks/attachments/'.$ebookInfo->ebook_name) }}" target="_blank">
							<img id="preview_pdf" src="{{ URL::to('assets/ebooks/pdf-icon.png') }}" style="max-height:120px;" class="img-fluid" />
							</a>
						</div><br>
						@endif

						<div class="form-group">
							<label for="image">Featured Image</label>
							<input type="file" placeholder="Title" name="ebook_banner" class="form-control" id="image">
						</div>

						@if($ebookInfo->image != null)
						<div class="col-4">
							<img id="preview_oi" src="{{ URL::to('assets/ebooks/banners/' . $ebookInfo->image) }}" style="max-height:120px;" class="img-fluid" />
						</div><br>
						@endif
						

						<div class="form-group">
							<label for="meta_title">Meta Title</label>
							<input type="text" placeholder="Meta Title" name="meta_title" class="form-control" id="meta_title" value="{{ $ebookInfo->meta_title }}">
						</div>

						<div class="form-group">
							<label for="meta_keyword">Meta Keyword</label>
							<input type="text" placeholder="Meta Keyword" name="meta_keyword" class="form-control" id="meta_keyword" value="{{ $ebookInfo->meta_keyword }}">
						</div>

						<div class="form-group">
							<label for="meta_description">Meta Description</label>
							<textarea name="meta_description" class="form-control " cols="30" rows="3" placeholder="Meta Description" id="meta_description" maxlength="">{{ $ebookInfo->meta_description }}</textarea>
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
							<option value="1" @if($ebookInfo->status == 1) selected @endif>{{ __('Published') }}</option>
							<option value="0" @if($ebookInfo->status == 0) selected @endif>{{ __('Draft') }}</option>
						</select>
					</div>
				</div>
				<div class="card sub">
					<div class="card-body">
						<h5>{{ __('Is Featured') }}</h5>
						<hr>
						<select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="featured">
							<option value="0" @if($ebookInfo->featured == 0) selected @endif>{{ __('No') }}</option>
							<option value="1" @if($ebookInfo->featured == 1) selected @endif>{{ __('Yes') }}</option>
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
	@include('seo.ebook.customjs')
@endsection

