<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400&display=swap');

        body {
            margin: 0px;
        }

        table.ol_body {
            font-family: 'Inter', sans-serif;
            background-color: rgb(243, 246, 255);
            margin: 0px;
            border: 0px;
            padding: 30px;
            width: 100%;
        }

        table.ol_wrapper {
            width: 100%;
            max-width: 650px;
            position: relative;
            margin: auto;
            background-color: #FFF;
            padding: 15px;
            border-radius: 2px;
            overflow: hidden;
            /* box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.07); */
        }

        p {
            font-weight: 300;
            margin-top: 0px;
            margin-bottom: 10px;
            font-size: 14px;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h5 {
            font-weight: 400;
            margin-top: 0px;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h5,
        p {
            line-height: 1.5;
        }

        .ol_receipt {
            position: relative;
            width: 100%;
            padding: 15px;
            background: rgb(243, 246, 255);
            border-radius: 4px;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        .ol_responsive {
            width: auto;
        }

        @media only screen and (max-width: 620px) {
            table.ol_body {
                padding: 0px;
            }

            .ol_receipt {
                padding: 10px;
            }

            .ol_responsive {
                width: 100% !important;
                display: block;
            }
        }
    </style>
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
                        <a href="{{ route('pricing') }}"><img src="{{ asset('assets/emails/images/recharge-now.png') }}" style="width: 100%;max-width: 380px;" alt=""></a>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 15px;" align="center">
                        {{-- <h2 style="margin: 0 0 10px 0;font-weight: 300;color:#000;">Dear {{ $data['name'] }}</h2>                      --}}
                        <p style="font-weight: bold;">{!!  $data['message'] !!}</p>
                        <p style="font-weight: 700;">Recharge now to run a successful marketing campaign</p>
                        <div style="padding: 10px;">
                            <a href="{{ route('pricing') }}" style="display:inline-block;padding:.4rem 1.4rem;border: 0px;background-color: #00249c;color:#FFF;text-decoration: none;border-radius: 40px;font-weight: bold;margin-bottom: 10px;font-size: 13px;">Recharge Now</a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="height: 30px;"></td>
                </tr>

                <tr>
                    <td>
                        <table cellpadding="0px" cellspacing="0px" style="width: 100%;margin-bottom:15px;padding:10px;">
                            <tr>
                                <td style="padding: 0 0 10px 0;border-bottom: 1px dashed rgba(0,0,0,0.2);">
                                    <h4 style="font-weight: 400;margin-bottom: 0px;">
                                        <span style="color: rgb(207, 36, 24);line-height:1.8">&#128533; If you have
                                            any query! </span> Feel free to connect us. <br>We are available from
                                        Monday to Sunday between 10 AM to 7 PM
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
</body>

</html>
