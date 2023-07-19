@extends('layouts.error')

@section('title', '498')    

@section('content')

<div>
	<h1 class="font-900 oplk-text-gradient pb-2">Oops, Link Expired!</h1>
	{{-- <h5 class="font-600" style="line-height: 25px;">It's not here! What you are looking for!</h5> --}}
    <h6 class="font-500" style="line-height: 25px;">
        The link you followed has expired. 
    </h6 >
</div>

@endsection

@section('images')
<div class="text-md-center">
    <img src="{{ asset('assets/images/error/link_expired.png') }}" class="mt-2 mt-sm-0" alt="" style="max-width: 380px;">
</div>
@endsection
