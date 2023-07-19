<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="shortcut icon" href="{{asset('favicon.ico')}}" type="image/x-icon">
    <script src="{{ asset('assets/js/jQuery.3.6.0.min.js') }}"></script>
    <title>Google Auth</title>
</head>
<body>
    <div id="openAuth"></div>

</body>

<script >
    $(document).ready(function(){
        getGoogleId();
        function getGoogleId(){
            var urlParamsObject = new URLSearchParams(window.location.search)
            var urlParamsString = urlParamsObject.toString();
            var google_id = urlParamsObject.get('google_id');
            localStorage.setItem("google_review_id", google_id);  

            setTimeout(() => {
                window.close();
            }, 3000);   
        }
    });

</script>
</html>