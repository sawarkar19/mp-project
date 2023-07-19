@extends('layouts.error')

@section('title', '401')

@section('content')

<div>
	<h1 class="font-900 oplk-text-gradient pb-2">OOPS!</h1>
	<h5 class="font-600" style="line-height: 25px;">Authorization is required</h5>
    <h6 class="font-500" style="line-height: 25px;">
        This server could not verify that you are authorised to access this page. Refresh and please try again.
    </h6 >
</div>
@endsection

@section('images')
<img src="{{ asset('assets/images/error/error.svg') }}" class="" alt="">
@endsection