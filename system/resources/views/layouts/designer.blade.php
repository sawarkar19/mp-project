<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- Custom Links After Start-Head Tag -->
        @yield('start_head')
        <!-- Page Title -->
        <title>@yield('title')</title>
        <!-- Page Meta -->
        @include('layouts.designer.meta')
        <!-- Page CSS, JS & Other Links -->
        @include('layouts.designer.link')
        <!-- Custom Links After End-Head Tag -->
        @yield('end_head')

    </head>
    <body>
        @yield('start_body')
        <div id="app">
            <div class="main-wrapper">
                <div class="navbar-bg"></div>
                    @include('layouts.partials.header')
                    @include('layouts.partials.sidebar')
                <!-- Main Content -->
                <div class="main-content">
                    <section class="section">
                        @yield('head')
                        <div class="section-body"></div>
                    </section>
                    @yield('content')
                </div>
                <footer class="main-footer">
                    <div class="footer-left">Copyright &copy; {{ date('Y') }}
                        <div class="bullet"></div>Powered By <a href="https://logicinnovates.com/" target="_blank">Logic Innovates</a>
                    </div>
                </footer>
            </div>
        </div>
        @include('layouts.designer.scripts')
        @yield('end_body')
    </body>
</html>