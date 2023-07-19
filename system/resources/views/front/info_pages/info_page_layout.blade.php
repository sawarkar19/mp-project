<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<!-- Custom Links After Start-Head Tag -->
	@yield('start_head')
	<!-- Page Title -->
	<title>@yield('title')</title>
	<!-- Page Meta -->
	@include('layouts.front.meta')
	<!-- Page CSS, JS & Other Links -->
	@include('layouts.front.link')
	<!-- Custom Links After End-Head Tag -->
	@yield('end_head')
</head>
<body>
	@yield('start_body')
    
	<!-- Page Content -->
	@yield('content')
	
	{{-- Footer  --}}
	<footer>
		<div class="py-2 bg-light">
			<div class="container text-center_">
				<div class="copyright">
					<p class="mb-0 text-dark">
						&copy; {{ date('Y') }} All rights reserved | Powered By 
						<a href="https://logicinnovates.com/" target="_blank" class="brandname">
						<span class="color-drk">Logic Innovates</span>
						</a>
					</p>
				</div>
			</div>
		</div>
	</footer>

	@yield('end_body')
</body>
</html>