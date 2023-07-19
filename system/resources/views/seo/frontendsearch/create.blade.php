@extends('layouts.seo')
@section('title', 'SEO: Add New Keyword')
@section('head')
@include('layouts.partials.headersection',['title'=>'Add New Keyword'])

<style>
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
				<form id="pageform" method="post" action="{{ route('seo.frontendsearch.store') }}" enctype="multipart/form-data">
					@csrf
					<div class="custom-form pt-20">

						<div class="form-group">
							<label for="keyword">Keyword<span class="is_required">*</span></label>
							<input type="text" placeholder="Keyword" name="keyword" class="form-control char-spcs-validation" id="keyword">
						</div>

						<div class="form-group">
							<label for="url">Path (URL)<span class="is_required">*</span></label>
							<input type="url" placeholder="Page URL" name="path" class="form-control no-space-validation not-allow-spaces" id="path">
						</div>

						<div class="form-group">
							<label for="name">Name<span class="is_required">*</span></label>
							<input type="text" placeholder="Name" name="name" class="form-control char-spcs-validation" id="name">
						</div>

						<div class="form-group">
							<label for="description">Description<span class="is_required">*</span></label>
							<textarea name="description" class="form-control char-num-and-spcs" cols="30" rows="3" placeholder="Description" id="description" maxlength=""></textarea>
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
{{--  <script src="{{ asset('assets/js/form.js') }}"></script>  --}}
<script src="{{ asset('assets/js/input-validation.js') }}"></script>
@include('seo.frontendsearch.customjs')
@endsection

