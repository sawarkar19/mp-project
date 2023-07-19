<table class="OL_MAILER" align="center" cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#f3f6ff">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
    <tr>
        <td style="padding: 20px 10px;font-family: 'Poppins', sans-serif;">
            <table cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#ffffff" style="max-width:700px; margin: auto;">
                <tr>
                    <td align="center" style="padding: 35px 20px;">
                        <a href="{{url('/')}}"><img src="{{ asset('assets/emails/images/logo-dark.png') }}" style="width: 100%;max-width: 200px;" alt="MouthPublicity.io"></a>
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
                        <p style="margin: 0 0 10px 0;font-size: 14px;">{!!  $content !!}</p>
                        {{-- <p style="margin: 0 0 10px 0;font-size: 14px;">Login and start using our free features to understand the importance and impact of mouth publicity on your business! </p> --}}
                        <div>
                            {{-- <a href="{{ url('business/profile') }}" style="display:inline-block;padding:.4rem 1.4rem;border: 0px;background-color: #00249c;color:#FFF;text-decoration: none;border-radius: 40px;font-weight: bold;font-size: 13px;">Go to profile setting</a> --}}
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table cellpadding="0px" cellspacing="0px"
                            style="width: 100%;margin-bottom:15px;padding:10px;">
                            <tr>
                                <td style="padding: 0 0 10px 0;border-bottom: 1px dashed rgba(0,0,0,0.2);">
                                    <h4 style="font-weight: 400;margin-bottom: 0px;">
                                        <span style="color: rgb(207, 36, 24);line-height:1.8">If you have
                                            any query! </span> Feel free to connect us. <br>We are available from
                                        Monday to Friday between 10 AM to 7 PM
                                    </h4>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table cellpadding="0px" cellspacing="0px"
                                        style="width: 100%;margin-top: 10px;">
                                        <tr>
                                            <td class="ol_responsive">
                                                <p style="margin-bottom: 0px;">Call us on</p>
                                                <p style="font-weight: bold;font-size: 18px;margin-bottom:0px;"><a
                                                        href="tel:07887882244"
                                                        style="text-decoration: none;color: #00249c;">07887882244</a>
                                                </p>
                                            </td>
                                            <td width="15" class="ol_responsive"></td>
                                            <td class="ol_responsive">
                                                <p style="margin-bottom: 0px;">Or you can mail us at</p>
                                                <p style="font-weight: bold;font-size: 18px;margin-bottom:0px;"><a
                                                        href="mailto:care@mouthpublicity.io"
                                                        style="text-decoration: none;color: #00249c;">care@mouthpublicity.io</a>
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                @include('emails.email-footer')
            </table>
        </td>
    </tr>
</table>