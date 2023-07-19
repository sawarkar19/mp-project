<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html;chartset=utf-8">
    <title>MouthPublicity</title>

    {{-- @include('layouts.business.link') --}}

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/frontend/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style>
        body{
            background: #fff;
        }
        p, h1, h2, h3, h4, h5, h6{
            line-height: 1;
        }
        @page {
            margin: 10px 10px;
        }
    </style>
</head>
<body>
    @include('business.instant-rewards.qr-design-'.$page, ["qrcode" => $qrcode, "planData" => $planData])
</body>
</html>