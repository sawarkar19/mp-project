<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Primary Meta Tags -->
    <title>{{$post->title}}</title>
    <meta name="title" content="{{$post->title}}">
    <meta name="description" content="{{$post->description}}">
    {{-- <meta name="keywords" content="@yield('keywords', $default_keywords)"> --}}

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{$post->title}}">
    <meta property="og:description" content="{{$post->description}}">
    <meta property="og:image" content="{{asset('assets/socialposts/'.$post->image)}}">
    <meta property="og:image:width" content="1200"/>
    <meta property="og:image:height" content="630"/>
    <meta property="og:locale" content="en_US"/>
    <meta property="og:url" content="{{URL::full()}}">
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{URL::full()}}">

    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="{{ asset('assets/front/vendor/bootstrap/css/bootstrap.min.css') }}" media="all">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,500;1,300&display=swap');
        body{
            font-family: 'Poppins', sans-serif;
        }
        .post-card{
            overflow: hidden;
            font-weight: 300;
        }
        .post-card .card-body{
            line-height: 1.8;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="py-5">
            <div class="row justify-content-center">
                <div class="col-sm-10 col-lg-8 col-xl-6">
                    <div class="card post-card shadow-sm">
                        <div class="card-img">
                            <img src="{{ asset('assets/socialposts/'.$post->image) }}" class="img-fluid" alt="">
                        </div>
                        <div class="card-header py-4">
                            <h5 class="mb-0" style="font-weight: 500">{{ $post->title }}</h5>
                        </div>
                        <div class="card-body">
                            {{ $post->description }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>