@extends('layouts.error')

@section('title', '500')

@section('content')

<div>
	<h1 class="font-900 oplk-text-gradient pb-2">Uh oh!</h1>
	 <h5 class="font-600" style="line-height: 25px;">Something went wrong</h5>
    <h6 class="font-500" style="line-height: 25px;">
        Refresh and try again, if it doesn't work contact us on 7887882244.
    </h6 >
</div>
@endsection

@section('images')
<img src="{{ asset('assets/images/error/error.svg') }}" class="" alt="">
@endsection