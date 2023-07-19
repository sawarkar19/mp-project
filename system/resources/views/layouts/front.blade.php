<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	@php
	/* Get the Marketing tool data like Google Analytics, Google Tag Manager, Facebook Pixel */
	$marketing_tools = DB::table('options')->where('key', 'marketing_tool')->first();
	$mt_data = json_decode($marketing_tools->value);
	@endphp

	{{-- /* Check for Google tag maneger & print the script */ --}}
	@if (isset($mt_data->google_tag_manager_status) && $mt_data->google_tag_manager_status === "on")
	@if (isset($mt_data->gtm_container_id) && !empty($mt_data->gtm_container_id))
	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer', '{{$mt_data->gtm_container_id}}');</script>
	<!-- End Google Tag Manager -->
	@endif
	@endif

	{{-- /* Check for Google Analytics & print the script */ --}}
	@if (isset($mt_data->google_status) && $mt_data->google_status === "on")
	@if (isset($mt_data->ga_measurement_id) && !empty($mt_data->ga_measurement_id))
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id={{$mt_data->ga_measurement_id}}"></script>
	<script>window.dataLayer = window.dataLayer || [];function gtag(){window.dataLayer.push(arguments);}gtag('js', new Date());gtag('config', '{{$mt_data->ga_measurement_id}}');</script>
	@endif
	@endif

	{{-- /* Check for Facebook Pixel & print the script */ --}}
	@if (isset($mt_data->fb_pixel_status) && $mt_data->fb_pixel_status === "on")
	@if (isset($mt_data->fb_pixel) && !empty($mt_data->fb_pixel))
	<!-- Facebook Pixel Code -->
	<script>!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window, document,'script','https://connect.facebook.net/en_US/fbevents.js');fbq('init', {{$mt_data->fb_pixel}});fbq('track', 'PageView');</script>
	<!-- End Facebook Pixel Code -->
	@endif
	@endif

	{{--Script for Openlink share button & counts--}}
	<script src="{{ asset('assets/js/targets-web.js') }}"></script>


	{{--Script for ChatBot--}}
	{{-- <script type="text/javascript" id="zsiqchat">var $zoho=$zoho || {};$zoho.salesiq = $zoho.salesiq || {widgetcode: "547132576f756f1db79fb47571364ec7eaa65c367c056e1894263b9e101dd2e2", values:{},ready:function(){}};var d=document;s=d.createElement("script");s.type="text/javascript";s.id="zsiqscript";s.defer=true;s.src="https://salesiq.zoho.in/widget";t=d.getElementsByTagName("script")[0];t.parentNode.insertBefore(s,t);</script> --}}

	{{-- Custom Links After Start-Head Tag --}}
	@yield('start_head')
	{{-- Page Meta --}}
	@include('layouts.front.meta')
	{{-- Page CSS, JS & Other Links --}}
	@include('layouts.front.link')
	{{--  Custom Links After End-Head Tag --}}
	@yield('end_head')
</head>
<body>

{{--Check for Google tag maneger & print the noscript--}}
@if (isset($mt_data->google_tag_manager_status) && $mt_data->google_tag_manager_status == "on")
	@if (isset($mt_data->gtm_container_id) && !empty($mt_data->gtm_container_id))
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{$mt_data->gtm_container_id}}" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	@endif
@endif
{{--Check for Facebook Pixel & print the noscript--}}
@if (isset($mt_data->fb_pixel_status) && $mt_data->fb_pixel_status === "on")
	@if (isset($mt_data->fb_pixel) && !empty($mt_data->fb_pixel))
	<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id={{$mt_data->fb_pixel}}&ev=PageView&noscript=1"/></noscript>
	@endif
@endif

	@yield('start_body')

	<!-- Header -->
	@include('layouts.front.header')

	<!-- Page Content -->
	@yield('content')

	<!-- Footer -->
	@include('layouts.front.footer')

	@include('layouts.front.scripts')

	@yield('end_body')
	<script>
		$(document).ready(function(){
			var h_height = $("header").height();
			var m_height = $("ul.menus").height();
			if(m_height > h_height){
				$("header").addClass('show-arrow');
			}
		})
	</script>
</body>
</html>