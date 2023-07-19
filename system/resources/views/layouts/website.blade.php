<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#166da2">

    {{-- /* Including the third-party analytics scripts like Google, Facebook, etc. */ --}}
    @include('layouts.website.analytics')


    @php
    $marketing_tools = DB::table('options')->where('key', 'google_tag_manager')->first();
    $mt_data = $marketing_tools->value;
    @endphp
    {!! $mt_data !!}


   
    @if (isset($mt_data->google_tag_manager_status) && $mt_data->google_tag_manager_status == 1)
    @if (isset($mt_data->gtm_container_id) && !empty($mt_data->gtm_container_id))
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-11112432156"></script>
    <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'AW-11112432156');
    </script>
    <!-- Google tag (gtag.js) -->
    @endif
    @endif

    {{-- zoho sales IQ Start --}}

    @php
    
    $zoho_script_data = DB::table('options')->where('key', 'zoho_sales')->first();
    $zoho_script = $zoho_script_data->value;
    
    @endphp
    
    @if ($zoho_script_data != null && $zoho_script_data->status == 1)
        {!! $zoho_script !!}
    @endif
    
    {{-- zoho sales IQ End --}}

    <!--Start of Tawk.to Script-->
    {{-- <script type="text/javascript">
		var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
		(function(){
		var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
		s1.async=true;
		s1.src='https://embed.tawk.to/6315880554f06e12d892bb5b/1gc61mlmk';
		s1.charset='UTF-8';
		s1.setAttribute('crossorigin','*');
		s0.parentNode.insertBefore(s1,s0);
		})();
	</script> --}}
    <!--End of Tawk.to Script-->



    <!-- Salesrobo -->
    {{-- <script>
    (function(w,d,t,u,n,a,m){w['MauticTrackingObject']=n;
        w[n]=w[n]||function(){(w[n].q=w[n].q||[]).push(arguments)},a=d.createElement(t),
        m=d.getElementsByTagName(t)[0];a.async=1;a.src=u;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://oc.salesrobo.com/mtc.js','mt');

    mt('send', 'pageview');
</script> --}}


    <script>
    (function(w, d, t, u, n, a, m) {
        w['MauticTrackingObject'] = n;
        w[n] = w[n] || function() {
                (w[n].q = w[n].q || []).push(arguments)
            }, a = d.createElement(t),
            m = d.getElementsByTagName(t)[0];
        a.async = 1;
        a.src = u;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', 'https://mp.salesrobo.com/mtc.js', 'mt');

    mt('send', 'pageview');
    </script>



    {{-- Page Meta --}}
    @include('layouts.website.meta')

    {{-- Page CSS, JS & Other Links --}}
    @include('layouts.website.link')

    @yield('end_head')

</head>

<body>
    @yield('start_body')

    <!-- Header -->
    @include('website.components.header')


    <article class="CONTENT_WRAPPER">
        <!-- Page Content -->
        @yield('content')
    </article>

    <!-- Footer -->
    @include('website.components.footer')

    <script>
    // When the user scrolls down 50px from the top of the document, resize the header's font size
    let logo_width_large, logo_width_small;
    let device_width = screen.width;
    let logo_selector = document.getElementById("mainLogo");
    if (device_width > 767) {
        logo_width_large = "240";
        logo_width_small = "180";
    } else if (device_width > 320) {
        logo_width_large = "200";
        logo_width_small = "140";
    } else {
        logo_width_large = "150";
        logo_width_small = "120";
    }

    function scrollFunction() {
        if (document.body.scrollTop > 150 || document.documentElement.scrollTop > 150) {
            logo_selector.setAttribute("width", logo_width_small);
            logo_selector.setAttribute("height", "auto");
            logo_selector.closest('nav.navbar').style.minHeight = '72px';
        } else {
            logo_selector.setAttribute("width", logo_width_large);
            logo_selector.setAttribute("height", "auto");
            logo_selector.closest('nav.navbar').style.minHeight = '90px';
        }
    }
    logo_selector.setAttribute("width", logo_width_large);
    window.onscroll = function() {
        scrollFunction()
    };
    </script>

    @include('layouts.website.scripts')
    @stack('end_body')
</body>

</html>