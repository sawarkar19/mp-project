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
                        <a href="{{ route('pricing') }}"><img src="{{ asset('assets/emails/images/3day-left.png') }}" style="width: 100%;max-width: 380px;" alt=""></a>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 15px;" align="center">
                        {{-- <h2 style="margin: 0 0 10px 0;font-weight: 300;color:#000;">Dear {{ $data['name'] }}</h2> --}}

                        
                        <p style="margin: 0 0 10px 0;font-size: 14px;">{!!  $data['message'] !!}</p>
                        {{-- <p>Click to renew your service. Have a good day!</p> --}}
                        <div style="padding: 10px;">
                            <a href="{{ route('pricing') }}" style="display:inline-block;padding:.4rem 1.4rem;border: 0px;background-color: #00249c;color:#FFF;text-decoration: none;border-radius: 40px;font-weight: bold;margin-bottom: 10px;font-size: 13px;">Renew Plan</a>
                        </div>
                    </td>
                </tr>
                @include('emails.email-footer')
            </table>
        </td>
    </tr>
</table>