@extends('layouts.error')

@section('title', '403')

@section('content')
<div>
	<h1 class="font-900 oplk-text-gradient pb-2">Well,</h1>
	<h5 class="font-600" style="line-height: 25px;">This is unexpected</h5>
    <h6 class="font-500" style="line-height: 25px;">
        You don't have permission to access this page!
    </h6 >
</div>
@endsection

@section('images')
<img src="{{ asset('assets/images/error/error.svg') }}" class="" alt="">
@endsection