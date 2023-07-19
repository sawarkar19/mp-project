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
                        <a href="{{url('/')}}"><img src="{{ asset('assets/emails/images/welcome.png') }}" style="width: 100%;max-width: 380px;" alt=""></a>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 15px;" align="center">
                        <h2 style="margin: 0 0 10px 0;font-weight: 300;">Welcome to <span style="font-weight:900;color:#00249c;">MouthPublicity.io</span>, {{$data['name']}}!</h2>
                        <p style="margin: 0 0 10px 0;font-size: 14px;">Thanks for signing up! We are very happy to have you with us &#128522;. Here is a little more information about who we are, and a few links about our story and success cases. We hope you find in our business what you are looking for. </p>
                        <div style="padding: 10px;">
                            <a href="{{ url('generate-admin-password?token='.$data['token']) }}" style="display:inline-block;padding:.4rem 1.4rem;border: 0px;background-color: #00249c;color:#FFF;text-decoration: none;border-radius: 40px;font-weight: bold;margin-bottom: 10px;font-size: 13px;">Go To Your Account</a>
                        </div>
                    </td>
                </tr>
                <tr style="background-color: #f7f7f7;" align="center">
                    <td style="padding: 25px 10px;">
                        <h3 style="margin: 0px;margin-bottom: 10px;">About <span style="font-weight:900;color:#00249c;">MouthPublicity.io</span></h3>
                        <p style="margin: 0px;font-size: 14px;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Alias quibusdam, cum eos obcaecati totam odio ex doloremque rem unde animi praesentium amet eligendi sapiente delectus, repudiandae provident natus dolor sit.</p>
                    </td>
                </tr>
                <tr>
                    <td style="border-top: 0px solid rgba(0,0,0,0.2);padding: 25px 10px;">
                        <h3 style="margin:0px;margin-bottom: 20px;text-align: center;">Our Apps</h3>
                        <table style="width: 100%;margin-bottom: 25px;">
                            <tr>
                                <td style="width:50%;" align="center">
                                    <div style="border:1px solid #00249c;padding: 15px 5px;border-radius: 6px;max-width: 200px;margin: auto;">
                                        <h4 style="margin: 0px;margin-bottom: 10px;">Future Offer</h4>
                                        <p style="font-size: 12px;margin-top: 0px;">Lerum maiores ipsum est dolorum magnam veniam. Rem molestiae repudiandae, itaque eos dolores obcaecati!</p>
                                        <a href="#" style="font-size: 12px;">Read More</a>
                                    </div>
                                </td>
                                <td style="width:50%;" align="center">
                                    <div style="border:1px solid #00249c;padding: 15px 5px;border-radius: 6px;max-width: 200px;margin: auto;">
                                        <h4 style="margin: 0px;margin-bottom: 10px;">Instant Offer</h4>
                                        <p style="font-size: 12px;margin-top: 0px;">Lerum maiores ipsum est dolorum magnam veniam. Rem molestiae repudiandae, itaque eos dolores obcaecati!</p>
                                        <a href="#" style="font-size: 12px;">Read More</a>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <p style="font-size: 14px;margin-bottom: 5px;">Regards,</p>
                        <p style="font-size: 14px;margin:0;font-weight: bold;">MouthPublicity.io Team.</p>
                    </td>
                </tr>
                @include('emails.email-footer')
            </table>
        </td>
    </tr>
</table>