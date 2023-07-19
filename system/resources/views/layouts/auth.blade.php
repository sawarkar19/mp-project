<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- Custom Links After Start-Head Tag -->
        @yield('start_head')
        <!-- Page Title -->
        <title>@yield('title')</title>
        <!-- Page Meta -->
        @include('layouts.auth.meta')
        <!-- Page CSS, JS & Other Links -->
        @include('layouts.auth.link')
        <!-- Custom Links After End-Head Tag -->
        @yield('end_head')
    </head>
    <body>
        <!-- Custom Code Before Main Content -->
        @yield('start_body')

        <div id="app">
            <section class="section">
                <div class="container mt-5">
                    <div class="row">
                        @if(Route::currentRouteName() == 'register')
                            <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2 register-div">
                        @else
                            <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        @endif
                            <div class="login-brand">
                                <img src="{{ asset('assets/img/logo.png') }}" alt="logo" width="100" class="shadow-light">
                            </div>
                            <div class="card card-primary">
                                <!-- Main Content -->
                                @yield('content')
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- General JS Scripts -->
        @include('layouts.auth.gen-scripts')
        <!-- Template JS File -->
        @include('layouts.auth.temp-scripts')
        <!-- Custom Code After Main Content -->
        @yield('end_body')
    </body>
</html>




