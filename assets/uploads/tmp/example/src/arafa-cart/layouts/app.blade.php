<!DOCTYPE html>
<html lang="{{ App::getlocale() }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        {{-- generate seo info --}}
        {!! SEO::generate() !!}
        {!! JsonLdMulti::generate() !!}
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!--=====================================
                    CSS LINK PART START
        =======================================-->
        <!-- FOR PAGE ICON -->
        <link rel="icon" href="{{ asset('uploads/'.domain_info('user_id').'/favicon.ico') }}">
        @php
        Helper::autoload_site_data();
        
        @endphp
        <style type="text/css">
           :root {
              --main-theme-color: {{ Cache::get(domain_info('user_id').'theme_color','#dc3545') }};   
          }
        </style>
      
      
         @stack('css')
        <!-- FOR STYLE -->
        
    </head>
<body>
 


{{-- load partials views --}}      
@include('frontend/arafa-cart/layouts/header')
@yield('content')
@include('frontend/arafa-cart/layouts/footer')

{{-- end load --}}





{{-- load whatsapp api --}}
{{ load_whatsapp() }}
{{-- end whatsapp api loading --}}

@php
$currency_info=currency_info();
@endphp
<input type="hidden" id="currency_position" value="{{ $currency_info['currency_position'] }}">
<input type="hidden" id="currency_name" value="{{ $currency_info['currency_name'] }}">
<input type="hidden" id="currency_icon" value="{{ $currency_info['currency_icon'] }}">
<input type="hidden" id="preloader" value="{{ asset('uploads/preload.webp') }}">
<input type="hidden" id="base_url" value="{{ url('/') }}">
<input type="hidden" id="theme_color" value="{{ Cache::get(domain_info('user_id').'theme_color','#dc3545') }}">


  @stack('js')
 <!-- FOR INTERACTION -->
<!--=====================================
    JS LINK PART END
=======================================-->
    </body>
</html>