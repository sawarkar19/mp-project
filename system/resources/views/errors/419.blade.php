@extends('layouts.error')

@section('title', '419')

@section('content')

<div>
	<h1 class="font-900 oplk-text-gradient pb-2">Page Expired</h1>
	<h5 class="font-500" style="line-height: 25px;">You have been logged out or session expired.</h5>
    {{-- <h6 class="font-500" style="line-height: 25px;">
        The page you are looking for is currently not available. Please try again later.
    </h6 > --}}
</div>
@endsection

@section('images')
<img src="{{ asset('assets/images/error/error.svg') }}" class="" alt="">
@endsection