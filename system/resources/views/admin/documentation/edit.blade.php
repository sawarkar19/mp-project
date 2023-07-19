@extends('layouts.admin')
@section('title', 'Admin: Documentations')
@section('head')
<link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" />

@include('layouts.partials.headersection',['title'=>'Edit Documentation'])
<style>
	#error{color:#ff0000;}
	#success{color:green;}
	.is_required {
		color: red;
	}
</style>
@endsection
@section('content')

<div class="row">
	<div class="col-lg-9">      
		<div class="card">
			<div class="card-body">
				<form id="documentationform" method="post" action="{{ route('admin.documentation.BUpdate',$documentationInfo->id) }}" enctype="multipart/form-data">
					@csrf
					<div class="custom-form pt-20">

						<div class="form-group">
							<label for="name">Title <span class="is_required">*</span></label>
							<input type="text" placeholder="Title" name="title" class="form-control nicEdit-main" id="name" value="{{ $documentationInfo->title }}">
						</div>

						<div class="form-group">
							<label for="description">Content <span class="is_required">*</span></label>
							<textarea name="description" class="form-control editor description" id="description" >{{  $documentationInfo->content }}</textarea>
						</div>

						<div class="form-group">
							<label for="ordering">Ordering</label>
							<input type="mobile" placeholder="Ordering Number" name="ordering" class="form-control number-validation" id="ordering" maxlength="8" value="{{ $documentationInfo->ordering }}">
						</div>

						{{--  <div class="form-group">
							<label for="image">Featured Image</label>
							<input type="file" placeholder="Title" name="documentation_banner" class="form-control" id="image">
						</div>

						@if($documentationInfo->image != null)
						<div class="col-4">
							<img id="preview_oi" src="{{ URL::to('assets/documentations/banners/' . $documentationInfo->image) }}" style="max-height:120px;" class="img-fluid" />
						</div><br>
						@endif

						<div class="form-group">
							<label for="meta_title">Meta Title</label>
							<input type="text" placeholder="Meta Title" name="meta_title" class="form-control" id="meta_title" value="{{ $documentationInfo->meta_title }}">
						</div>

						<div class="form-group">
							<label for="meta_keyword">Meta Keyword</label>
							<input type="text" placeholder="Meta Keyword" name="meta_keyword" class="form-control" id="meta_keyword" value="{{ $documentationInfo->meta_keyword }}">
						</div>

						<div class="form-group">
							<label for="meta_description">Meta Description</label>
							<textarea name="meta_description" class="form-control " cols="30" rows="3" placeholder="Meta Description" id="meta_description" maxlength="">{{ $documentationInfo->meta_description }}</textarea>
						</div>				  --}}
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
							<option value="1" @if($documentationInfo->status == 1) selected @endif>{{ __('Published') }}</option>
							<option value="0" @if($documentationInfo->status == 0) selected @endif>{{ __('Draft') }}</option>
						</select>
					</div>
				</div>
				<div class="card sub">
					<div class="card-body">
						<div class="form-group">
							<h5>{{ __('Publish Date') }}</h5>
							<hr>
		                    <input type="date" id="updated_at" name="updated_at" class="form-control" value="{{ \Carbon\Carbon::parse($documentationInfo->updated_at)->format('Y-m-d') }}">
		                </div>
					</div>
					
				</div>
				{{--  <div class="card sub">
					<div class="card-body">
						<h5>{{ __('Is Featured') }}</h5>
						<hr>
						<select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="featured">
							<option value="0" @if($documentationInfo->featured == 0) selected @endif>{{ __('No') }}</option>
							<option value="1" @if($documentationInfo->featured == 1) selected @endif>{{ __('Yes') }}</option>
						</select>
					</div>
				</div>  --}}
				{{--  <div class="card sub">
					<div class="card-body">
						<h5>{{ __('Add Tags') }}</h5>
						<hr>                        
						<input type="text" id="tag" value="" class="form-control">
						<input type="button" name="tag" value="Add" class="btn btn-primary col-12" style="margin-top:10px;" onclick="add_tags()">
						<span id="error"></span>
						<span id="success"></span>
					</div>
				</div>  --}}

				<div class="card sub">
					<div class="card-body">
						<h5>{{ __('Select Category') }}</h5>
						<hr> 
						
						<select class="form-control select2" name="tags" id="tag_listing">

						  @foreach($all_tags as $result)
						  <option value="{{$result->id}}"  @if($result->id == $selectTags)selected="selected" @endif>{{$result->name}}</option>
						  @endforeach
						</select>
					</div>
				</div>
			</div>
		</div>
</form>


@endsection
@section('end_body')
	@include('admin.documentation.customjs')
	<script src="{{ asset('assets/js/input-validation.js') }}"></script>

@endsection

