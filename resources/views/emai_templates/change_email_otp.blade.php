<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
    xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{config('global.site_name')}}</title>
    </head>

<body style="margin: 0; color: #f2f2f2;">

    <div marginwidth="0" marginheight="0">
    <div marginwidth="0" marginheight="0" id="" dir="ltr" style="background: #008645;margin:0; padding:20px 0 20px 0;width:100%; margin: 0;">

    <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100% ">
        <tbody>
            <tr>
                <td align="center" valign="top">
                    <table border="0" cellpadding="0" cellspacing="0" width="600" style="background:#ffffff; border-radius:15px!important; overflow: hidden;">
                        <tbody>
                            <tr>
                                <td style="background: #ffffff;">
                                    <div style="padding: 15px 20px; background:#ffffff; padding-bottom: 15px;">
                                        <table style="background:#ffffff; font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif;font-size:14px;width: 100%;">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <img src="{{ asset('') }}admin-assets/assets/img/logo.png" alt="" style="width: 100px; margin-bottom: 0px; ">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h2 style="color: #1e1e1e;line-height: 42px; font-size: 30px;padding-right: 20px;margin: 0;">Please Verify Your Email </h2>
                                                    </td>
                                                    <td style="text-align: right;">
                                                        <img src="{{ asset('') }}admin-assets/assets/img/logo.svg" alt="" style="max-width: 120px; margin-bottom: 0px; ">
                                                    </td>

                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        <tr>
                            <td align="center" valign="top" style="background: #ffffff;">
                                <table border="0" cellpadding="0" cellspacing="0" width="600" style="background: #ffffff;">
                                    <tbody>
                                    <tr>
                                        <td valign="top" style="background-color: #ffffff; padding:0;">
                                            <table border="0" cellpadding="20" cellspacing="0" width="100%" style="font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif;">
                                                <tbody>
                                                <tr>
                                                    <td valign="top" style="padding-bottom: 0px;">

                                                        <div  style="color:#636363;font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif;font-size:14px;line-height:150%;text-align:left;margin-top: 0px">
                                                            <h4 style="font-weight: 600; font-size: 28px; color: #1e1e1e;margin-top: 0px">Dear <span style="color: #ED622F;">{{$name}},</span> </h4>
                                                            <p style="margin:0 0 16px; font-size: 15px; line-height: 26px; color: #1e1e1e; text-align: left;">
                                                                In order to activate your account, verify your email address by entering the unique code generated below:
                                                            </p>
                                                            <div style="margin: 25px auto;">
                                                                <p style="margin:0 0 16px; font-size: 17px; line-height: 26px; color: #1e1e1e; text-align: center;">
                                                                    OTP for verifying your email id at TimeX Shipping
                                                                </p>
                                                                <div style="margin: 15px auto; font-size: 24px; border-radius: 8px; width: 210px; font-weight: 700;line-height: 50px; background: #ED622F; color: #ffffff; text-align: center;">
                                                                    {{$otp}}
                                                                </div>
                                                            </div>
                                                            <p style="margin:0 0 16px; font-size: 13px; line-height: 22px; color: #1e1e1e; text-align: left;">If you face any problem for activating your account please contact us using the TimeX Shipping website <a href="#" style="color: #ED622F; text-decoration: none;">contact form</a>
                                                            </p>

                                                            <p style="margin:0 0 3px; font-size: 12px; line-height: 16px; color: #1e1e1e; text-align: left;">Yours,</p>
                                                            <p style="margin:0 0 16px; font-size: 17px; line-height: 26px; color: #ED622F; font-weight: 600; text-align: left;">TimeX Shipping team</p>

                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="background: #ffffff;">
                                <div style="padding: 20px; background: #ffffff;">
                                    <table style="background: #ffffff; font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif;font-size:14px;width: 100%;">
                                        <tbody>

                                            <tr>
                                                <td style="width: 100%;" colspan="2">
                                                    <table style="font-size: 14px; width: 100%;">
                                                        <tbody>


                                                            <tr>
                                                                <td colspan="2" valign="middle"
                                                                    style="padding:0;border:0;color:#aac482;font-family:Arial;font-size:12px;line-height:125%;text-align:center; background: #ffffff;">
                                                                    <p style="color: #1e1e1e; padding-top: 20px; font-style: 14px; margin-top: 0px">
                                                                        © 2023 TimeX Shipping. All Rights Reserved.</p>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>

        </tbody>
    </table>

</div>
</div>

</body>

</html>
