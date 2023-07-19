<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
</head>
<body>

    <table class="OL_MAILER" align="center" cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#f3f6ff">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
        <tr>
            <td style="padding: 20px;font-family: 'Poppins', sans-serif;">
                <table cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#ffffff" style="max-width:650px; margin: auto;">
                    <tr>
                        <td align="center" style="padding: 35px 20px;">
                            <a href="{{url('/')}}"><img src="{{ asset('assets/emails/images/logo-dark.png') }}" style="width: 100%;max-width: 150px;" alt="MouthPublicity.io"></a>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center;padding: 20px 0;">
                            <a href="{{url('/')}}"><img src="{{ asset('assets/emails/images/thank-you.png') }}" style="width: 100%;max-width: 380px;" alt=""></a>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 15px;" align="center">
                            <h3 style="margin: 0 0 10px 0;">Thank you for sharing your contact details with us.</h3>
                            <p style="margin: 0 0 10px 0;font-size: 14px;">{!!  $content !!}</p>
                            <p style="margin: 0 0 10px 0;font-size: 14px;">Have a great day! &#128522; </p>
                        </td>
                    </tr>
                    
                    @include('emails.email-footer')

                </table>
            </td>
        </tr>
    </table>
    
</body>
</html>