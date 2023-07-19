@extends('layouts.admin')
@section('title', 'Admin: Frontend Settings')
@section('head')
@include('layouts.partials.headersection',['title'=>'Frontend Settings'])
@endsection
@section('content')

<div class="card">
	<div class="card-body">
		
		<div class="row">
			<div class="col-12 col-sm-12 col-md-4">
				<ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
					<li class="nav-item">
						<a class="nav-link  @if(route('admin.appearance.show','header') == url()->current()) active @endif" href="{{ route('admin.appearance.show','header') }}" >{{ __('Header Section') }}</a>
					</li>
					<li class="nav-item">
						<a class="nav-link @if(route('admin.appearance.show','about') == url()->current()) active @endif" href="{{ route('admin.appearance.show','about') }}">{{ __('About Section') }}</a>
					</li>
					<li class="nav-item">
						<a class="nav-link @if(route('admin.appearance.show','ecom_features') == url()->current()) active @endif" href="{{ route('admin.appearance.show','ecom_features') }}">{{ __('Market Features') }}</a>
					</li>
					<li class="nav-item">
						<a class="nav-link @if(route('admin.appearance.show','counter_area') == url()->current()) active @endif" href="{{ route('admin.appearance.show','counter_area') }}">{{ __('Counter Area') }}</a>
					</li>
					
					<li class="nav-item">
						<a class="nav-link @if(route('admin.appearance.show','testimonials') == url()->current()) active @endif" href="{{ route('admin.appearance.show','testimonials') }}">{{ __('Testimonials Section') }}</a>
					</li>
					
				</ul>
			</div>
			<div class="col-12 col-sm-12 col-md-8">
				@yield('append')
			</div>
		</div>

	</div>
</div>

@endsection


