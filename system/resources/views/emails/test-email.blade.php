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
                        <a href="{{url('/')}}"><img src="{{ asset('assets/emails/images/5day-left.png') }}" style="width: 100%;max-width: 380px;" alt=""></a>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 15px;" align="center">
                        <h2 style="margin: 0 0 10px 0;font-weight: 300;"><span style="font-weight:900;color:#00249c;">Test Email</span></h2>
                    </td>
                </tr>
                @include('emails.email-footer')
            </table>
        </td>
    </tr>
</table>