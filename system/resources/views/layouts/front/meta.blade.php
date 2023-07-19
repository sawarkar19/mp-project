<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">

@php
    $default_title = 'MouthPublicity.io - The Ultimate Word of Mouth Marketing Platform.';
    $default_description = 'MouthPublicity.io aims to be the most powerful marketing application for businesses and enterprises of any size. OpenLink has been developed as the premier application to boost your brand reach by your existing customers and provide them with structured benefits for growing your social media presence and referring your business to their network.';
    $default_keywords = 'word of mouth marketing, WOM Marketing, mouth publicity, MouthPublicity.io';
    $default_image = asset('assets/front/images/openlink-the-mouth-publicity-media.jpg');
@endphp

<!-- Primary Meta Tags -->
<title>@yield('title', $default_title)</title>
<meta name="title" content="@yield('title', $default_title)">
<meta name="description" content="@yield('description', $default_description)">
<meta name="keywords" content="@yield('keywords', $default_keywords)">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:title" content="@yield('title', $default_title)">
<meta property="og:description" content="@yield('description', $default_description)">
<meta property="og:image" content="@yield('image', $default_image)">
<meta property="og:image:alt" content="{{$default_image}}">
<meta property="og:image:width" content="1200"/>
<meta property="og:image:height" content="630"/>
<meta property="og:locale" content="en_US"/>
<meta property="og:url" content="{{URL::full()}}">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="{{URL::full()}}">