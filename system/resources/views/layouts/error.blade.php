<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.error.meta')
    <title>@yield('title')</title>
    @include('layouts.error.link')
</head>

<body>
    <section>
        <div class="container py-5">
            <div class="mb-5">
                <a href="{{url('')}}">
                    <img src="{{ asset('assets/front/images/logo-dark.svg') }}" class="main_logo" alt="MouthPublicity.io">
                </a>
            </div>  
            <div class="row align-items-center error">
                <div class="col-lg-7 col-md-7 col-12 error_404 mb-4">
                    @yield('content')

                    @include('layouts.error.search')
                    @include('layouts.error.back')

                </div>
                <div class="col-lg-5 col-md-5 col-12">
                    @yield('images')
                </div>
            </div>
            @include('layouts.error.footer')
        </div>
    </section>
    
    @include('layouts.error.script')
    </body>
</html>