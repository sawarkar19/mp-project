@extends('layouts.admin')
@section('title', 'Admin: Edit Keyword')
@section('head')
@include('layouts.partials.headersection',['title'=>'Edit Keyword'])

@endsection
@section('content')

<div class="row">
	<div class="col-lg-9">      
		<div class="card">
			<div class="card-body">
				<form id="pageEditform" method="post" action="{{ route('admin.frontendSearch.frontendSearchUpdate', $FrontEndSearch->id) }}" enctype="multipart/form-data">
					@csrf
					<div class="custom-form pt-20">

						<div class="form-group">
							<label for="name">Title</label>
							<input type="text" placeholder="Keyword" name="keyword" class="form-control form-control char-spcs-validation" id="keyword" value="{{ old('title', $FrontEndSearch->keyword) }}">
						</div>

						<div class="form-group">
							<label for="url">Path (URL)</label>
							<input type="url" placeholder="Page URL" name="path" class="form-control no-space-validation not-allow-spaces" id="path" value="{{ old('url', $FrontEndSearch->path) }}">
						</div>

						<div class="form-group">
							<label for="meta_title">Name</label>
							<input type="text" placeholder="Name" name="name" class="form-control char-spcs-validation" id="name" value="{{ old('title', $FrontEndSearch->name) }}">
						</div>

						<div class="form-group">
							<label for="description">Description</label>
							<textarea name="description" class="form-control char-num-and-spcs" cols="30" rows="3" placeholder="Description" id="description" maxlength="">{{ old('title', $FrontEndSearch->description) }}</textarea>
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
							<button type="submit" class="btn btn-primary col-12"><i class="fa fa-save"></i> {{ __('Update') }}</button>
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
							<option value="1" @if($FrontEndSearch->status == 1) selected @endif>{{ __('Published') }}</option>
							<option value="0" @if($FrontEndSearch->status == 0) selected @endif>{{ __('Draft') }}</option>
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
@include('admin.frontendsearch.customjs')
@endsection

