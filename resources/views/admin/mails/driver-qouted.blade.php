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
                                                            <h4 style="font-weight: 600; font-size: 28px; color: #1e1e1e;margin-top: 0px">Dear <span style="color: #ED622F;">    {{ $data['user']->name}},</span> </h4>
                                                            <p style="margin:0 0 16px; font-size: 15px; line-height: 26px; color: #1e1e1e; text-align: left;">
                                                                  You have some qoutes against the request. {{ $data['booking']->booking_number}} that you have submitted. Please check in your app.
                                                            </p>





                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                        <td>
                                             <table cellspacing="0" cellpadding="0" width="100%" style="color:#000">
                                                  <tr>
                                                    <td class="header-lg">
                                                        <table align="center">
                                                            <tr>
                                                                <th colspan = "2">Details for Request Qoute</th>
                                                                <td colspan = "2"><hr /></td>
                                                            </tr>
                                                            <tr>
                                                                <td > <strong>Collection Address &nbsp;&nbsp;</strong></td><td>{{ $data['booking']->collection_address}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td > <strong>Deliver Address &nbsp;&nbsp;</strong></td><td>{{ $data['booking']->deliver_address}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td > <strong>Receiver Name &nbsp;&nbsp;</strong></td><td>{{ $data['booking']->receiver_name}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td > <strong>Receiver Email &nbsp;&nbsp;</strong></td><td>{{ $data['booking']->receiver_email}}</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                  </tr>


                                                </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                             <div  style="color:#636363;font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif;font-size:14px;line-height:150%;text-align:left;margin-top: 0px">
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
