@extends('layouts.seo')
@section('title', 'SEO: Pages')
@section('head')
@include('layouts.partials.headersection',['title'=>'Add New Page'])
@endsection
@section('content')

<div class="row">
	<div class="col-lg-9">      
		<div class="card">
			<div class="card-body">
				<form id="pageform" method="post" action="{{ route('seo.page.store') }}" enctype="multipart/form-data">
					@csrf
					<div class="custom-form pt-20">

						<div class="form-group">
							<label for="name">Title</label>
							<input type="text" placeholder="Title" name="title" class="form-control" id="name">
						</div>

						<div class="form-group">
							<label for="url">URL</label>
							<input type="url" placeholder="Page URL" name="url" class="form-control" id="url">
						</div>

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
			</div>
		</div>
</form>
@endsection
@section('end_body')
	@include('seo.page.customjs')
@endsection

