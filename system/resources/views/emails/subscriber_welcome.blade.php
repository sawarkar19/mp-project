<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;chartset=utf-8">
    <title>welcome</title>
    
    
</head>
<body>
    <table class="OL_MAILER" align="center" cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#f3f6ff">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
        <tr>
            <td style="padding: 20px 10px;font-family: 'Poppins', sans-serif;">
                <table class="email-dark" cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#ffffff" style="max-width:700px; margin: auto;">
                    <tr>
                        <td align="center"  style="padding: 35px 20px;">
                            <a href="{{url('/')}}"><img src="{{ asset('assets/emails/images/logo-dark.png') }}" style="width: 100%;max-width: 200px;" alt="mouthoublicity.io"></a>
                        </td>
                        
                    </tr>
                    <tr>
                        <td style="text-align: center;padding: 30px 0;">
                            <a href="{{ route('business.dashboard') }}">
                                <img src="{{ asset('assets/emails/images/welcome.png') }}" style="width: 100%;max-width: 380px;" alt="">
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 15px;" align="center">
                            {{-- <h3 style="margin: 0 0 10px 0;font-weight: 300;font-size: 14px;"><b>Dear {{ $data['name'] }}!</b></h3> --}}
                            {{-- <h2 style="margin: 0 0 10px 0;font-weight: 300;">Welcome to MouthPublicity.io! &#128522;</h2> --}}
                            <p  style="margin: 0 0 10px 0;font-size: 14px;">{!!  $content !!}</p>
                            <div>
                                <a href="{{ url('login') }}" style="display:inline-block;padding:.4rem 1.4rem;border: 0px;background-color: #00249c;color:#FFF;text-decoration: none;border-radius: 40px;font-weight: bold;font-size: 13px;">Login Now</a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="border-top: 0px solid rgba(0,0,0,0.2);padding: 15px;">
                            <p style="font-size: 14px;margin-bottom: 5px;margin-top:0px;">Regards,</p>
                            <p style="font-size: 14px;margin:0;font-weight: bold;">MouthPublicity.io Team.</p>
                        </td>
                    </tr>
                    @include('emails.email-footer')
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
