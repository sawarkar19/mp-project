<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- Custom Links After Start-Head Tag -->
        @yield('start_head')
        <!-- Page Title -->
        <title>@yield('title')</title>
        <!-- Page Meta -->
        @include('layouts.employee.meta')
        <!-- Page CSS, JS & Other Links -->
        @include('layouts.employee.link')
        <!-- Custom Links After End-Head Tag -->
        @yield('end_head')

        <script src="{{ asset('assets/js/input-validation.js') }}" type="text/javascript" ></script>

    </head>
    <body @if (isset($_COOKIE["sidebar"]) && $_COOKIE["sidebar"] === 'mini') class="sidebar-mini" {{$_COOKIE["sidebar"]}} @endif>
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
                        <div class="bullet"></div>Powered By 
                        {{-- <a href="{{ url('/') }}">{{ env('APP_NAME') }}</a> --}}
                        <a href="https://logicinnovates.com/" target="_blank">
                        <span>Logic Innovates</span>
                        </a>
                    </div>
                </footer>
            </div>
        </div>
        @include('layouts.employee.scripts')
        @yield('end_body')

        <div id="overlay">
          <div class="cv-spinner">
            <span class="spinner"></span>
          </div>
        </div>
    </body>
</html>