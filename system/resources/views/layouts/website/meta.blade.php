@php
    $default_title = '';
    $default_description = '';
    $default_keywords = '';
    $default_image = asset('assets/front/images/openlink-the-mouth-publicity-media.jpg');
@endphp
<!-- Primary Meta Tags -->
<title>@yield('title', $default_title)</title>
<meta name="title" content="@yield('title', $default_title)">
<meta name="description" content="@yield('description', $default_description)">
<meta name="keywords" content="@yield('keywords', $default_keywords)">
{{-- <meta name="google-site-verification" content="X1L0tkQzEel9VGefA_NSy9YaWVbklsrWobxbE5H1PK4" /> --}}

    {{-- google-site-verification --}}

    @php
    $google_site_verification = DB::table('options')->where('key', 'meta_google_site_verification')->first();

    
    
    @endphp
    
    @if ($google_site_verification != null && $google_site_verification->status == 1)
    @php $google_site = $google_site_verification->value; @endphp 
        {!! $google_site !!}
    @endif
    
    {{-- google-site-verification --}}
    {{-- facebook-domain-verification --}}

    @php
    
    $facebook_domain_verification = DB::table('options')->where('key', 'meta_facebook_domain_verification')->first();
    
    
    @endphp
    
    @if ($facebook_domain_verification != null && $facebook_domain_verification->status == 1)
    @php $facebook_domain = $facebook_domain_verification->value; @endphp
        {!! $facebook_domain !!}
    @endif
    
    {{-- facebook-domain-verification --}}


<!-- <meta name="google-site-verification" content="KHnFbyYZNzdmHmx186kS33UdcYce85Mt6b8B2wpX430" /> -->
<!-- <meta name="facebook-domain-verification" content="dumfjqfhvcqne2c7au2f97r01y8r1k" /> -->

<link rel="canonical" href="{{URL::full()}}" />

<meta name="robots" content="INDEX,FOLLOW" />
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
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{URL::full()}}">
<meta property="twitter:title" content="@yield('title', $default_title)">
<meta property="twitter:description" content="@yield('description', $default_description)">
<meta property="twitter:image" content="@yield('image', $default_image)">