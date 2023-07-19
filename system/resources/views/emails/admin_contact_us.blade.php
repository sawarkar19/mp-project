 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Details</title>
</head>
<body>

    <table class="OL_MAILER" cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#f3f6ff">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
        <tr>
            <td style="padding: 20px;font-family: 'Poppins', sans-serif;">
                <table cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#ffffff" style="max-width:650px; margin: auto;">
                    <tr>
                        <td style="padding: 20px" align="center">
                            <a href="{{url('/')}}" target="_blank"><img style="width: 180px;"
                                src="{{asset('assets/emails/images/logo-dark.png')}}" border="0" /></a>
                        </td>
                    </tr>
                    
                    <tr>
                        <td style="padding: 15px;" align="center">
                            <h3 style="margin: 0 0 10px 0;">Website Contact Enquiry</h3>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table style="font-size: 14px" cellspacing="10px">
                                <tr>
                                    <td style="vertical-align: top;">Name</td>
                                    <td style="vertical-align: top;">:</td>
                                    <td style="vertical-align: top;">{{$data['name']}}</td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: top;">Email</td>
                                    <td style="vertical-align: top;">:</td>
                                    <td style="vertical-align: top;">{{$data['email']}}</td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: top;">Phone</td>
                                    <td style="vertical-align: top;">:</td>
                                    <td style="vertical-align: top;">{{$data['mobile']}}</td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: top;">Message</td>
                                    <td style="vertical-align: top;">:</td>
                                    <td style="vertical-align: top;">{{$data['message']}}</td>
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