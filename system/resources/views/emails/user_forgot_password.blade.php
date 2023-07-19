<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>
<body>
    <table class="OL_MAILER" align="center" cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#f3f6ff">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
        <tr>
            <td style="padding: 20px;font-family: 'Poppins', sans-serif;">
                <table cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#ffffff" style="max-width:650px; margin: auto;">
                    <tr>
                        <td align="center" style="padding: 35px 20px;">
                            <a href="{{url('/')}}"><img src="{{ asset('assets/emails/images/logo-dark.png') }}" style="width: 100%;max-width: 200px;" alt="MouthPublicity.io"></a>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center;padding: 30px 0;">
                            <a href="{{url('/')}}"><img src="{{ asset('assets/emails/images/reset-password.png') }}" style="width: 100%;max-width: 280px;" alt=""></a>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 15px;" align="center">
                            <h3 style="margin: 0 0 10px 0;font-size: 16px;">Hello, {{ $data['name'] }}!</h3>
                            <p style="margin: 0 0 10px 0;font-size: 14px;">{!!  $content !!}</p>
                            <p style="margin: 0 0 10px 0;font-size: 14px;">Click the link below to complete the process.</p>
                            <div style="padding: 10px;">
                                <a href="{{ route('forgotPassword', 'token='.$data['token']) }}" target="_blank" style="display:inline-block;padding:.5rem 1rem;border: 0px;background-color: #00249c;color:#FFF;text-decoration: none;border-radius: 6px;font-weight: bold;margin-bottom: 10px;">Reset Password</a>
                                <p style="margin: 0;font-size: 12px;">
                                    <a href="{{ route('forgotPassword', 'token='.$data['token']) }}" target="_blank">{{ route('forgotPassword', 'token='.$data['token']) }}</a>
                                </p>
                            </div>
                            <p style="font-size: 14px;">If you did not perform this request, you can safely ignore this email.</p>
                        </td>
                    </tr>
                    @include('emails.email-footer')
                </table>
            </td>
        </tr>
    </table>
    
</body>
</html>