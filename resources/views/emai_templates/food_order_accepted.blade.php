<div marginwidth="0" marginheight="0" id="" dir="ltr" style="background: #008645;margin:0; padding:20px 0 20px 0;width:100%; margin: 0;">
    <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
        <tbody>
            <tr>
                <td align="center" valign="top">
                    <table border="0" cellpadding="0" cellspacing="0" width="600" style="background-color:#ffffff;border-radius:15px!important;overflow: hidden;">
                        <tbody>
                            <tr>
                                <td>
                                    <div style="padding:15px 20px;background:#f6f9ff;padding-bottom:15px">
                                        <table style="background:#f6f9ff;font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;font-size:14px;width:100%">
                                            <tbody>
                                                <tr>
                                                        <td>
                                                            <img src="{{ asset('') }}admin-assets/assets/img/logo.png" alt="" style="width: 100px; margin-bottom: 0px; ">
                                                        </td>
                                                    </tr>
                                                <tr>
                                                    <td>

                                                        <h1 style="color:#000000;font-size:30px;line-height:normal; margin-bottom: 0;">Great news!</h1>
                                                    </td>

                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        <tr>
                            <td align="center" valign="top">
                                <table border="0" cellpadding="0" cellspacing="0" width="600">
                                    <tbody>
                                    <tr>
                                        <td valign="top" style="background-color:#ffffff;padding:px px 0">
                                            <table border="0" cellpadding="20" cellspacing="0" width="100%" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif">
                                                <tbody>
                                                <tr>
                                                    <td valign="top" style="padding-bottom:0px">

                                                        <div style="color:#636363;font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;font-size:14px;line-height:150%;text-align:left;margin-top:0px">
                                                            <h4 style="font-weight: 600; font-size: 28px; color: #1e1e1e; margin-top:0">Dear <span style="color: #ED622F;">{{$name}},</span> </h4>
                                                            <p style="margin:0 0 16px;font-size:14px;line-height:26px;color:#000000;text-align:left">
                                                               Your order <b> #{{config('global.sale_order_prefix').date(date('Ymd', strtotime($order->created_at))).$order->order_id}}</b> has been received on {{date('d F Y h:i A',strtotime($order->booking_date))}}.
                                                               Please complete your payment on app and we will start preparing your order.</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table style="width:100%">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="width:20%"><div style="height:10px;background:#5dbf13;border-radius:3px"></div></td>
                                                                    <td style="width:20%"><div style="height:10px;background:#5dbf13;border-radius:3px"></div></td>
                                                                    <td style="width:20%"><div style="height:10px;background:#5dbf13;border-radius:3px"></div></td>
                                                                    <td style="width:20%"><div style="height:10px;background:#5dbf13;border-radius:3px"></div></td>
                                                                    <td style="width:20%"><div style="height:10px;background:#5dbf13;border-radius:3px"></div></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <p style="font-weight:600;color:#5dbf13;font-size:18px">Received!</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table>
                                                            <tbody>
                                                                <tr>
                                                                    <td style="width:50%;background:#f6f9ff; color: #1e1e1e; padding:15px 10px;font-size:14px">
                                                                        <h4>ORDER SUMMARY</h4>
                                                                        <table style="font-size:14px;width:100%">
                                                                            <tbody><tr><td><table style="font-size:14px;width:100%">
                                                                            <tbody style="color: #1e1e1e; ">
                                                                                <tr>
                                                                                    <td style="padding:5px">Invoice No:</td>
                                                                                    <td style="padding:5px">#{{$order->invoice_id}}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="padding:5px">Sub Total:</td>
                                                                                    <td style="padding:5px">£ {{$order->total}}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="padding:5px">Tax:</td>
                                                                                    <td style="padding:5px">£ {{$order->vat}}</td>
                                                                                </tr>


                                                                                                                                                                <tr>
                                                                                    <td style="padding:5px">Discount:</td>
                                                                                    <td style="padding:5px">£ {{$order->discount}}</td>
                                                                                </tr>

                                                                                <tr>
                                                                                    <td style="padding:5px">Grand Total:</td>
                                                                                    <td style="padding:5px">£ {{$order->grand_total}}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="padding:5px">Payment :</td>
                                                                                    <td style="padding:5px">
                                                                                       @if($order->payment_mode==1)
                                                                                       Wallet
                                                                                        @endif
                                                                                        @if($order->payment_mode==2)
                                                                                        Card
                                                                                         @endif
                                                                                         @if($order->payment_mode==3)
                                                                                         Apple Pay
                                                                                          @endif                                                                                 </td>


                                                                            </tr></tbody>
                                                                        </table>
                                                                    </td>
                                                                    <td style="width:50%;background:#f6f9ff; color: #1e1e1e; padding:15px 10px;font-size:14px">
                                                                        <h4>SHIPPING ADDRESS</h4>
                                                                        <p style="font-weight:700;margin-bottom:0px">{{$order->address->full_name}}</p>
                                                                        <p style="margin-top:5px;line-height:22px">
                                                                            {{$order->address->dial_code.$order->address->phone}} <br>

                                                                            {{$order->address->address}}<br>

                                                                            @if($order->address->building_name)
                                                                            {{$order->address->building_name}}
                                                                            <br>

                                                                            @endif

                                                                            @if($order->address->land_mark)
                                                                            {{$order->address->land_mark}}
                                                                            <br>

                                                                            @endif


                                                                        </p>
                                                                    </td>
                                                                </tr></tbody></table></td></tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <table style="font-size:14px;width:100%;border-top:1px solid #dadada;border-bottom:1px solid #dadada; color: #1e1e1e; ">
                                                            <tbody>
                                                                @foreach ($order->products as $prd)
                                                                <tr>

                                                                    <td style="width:100px">
                                                                        <img style="max-width:100px;padding-right:5px" src="{{$prd->image}}" alt="" >
                                                                    </td>
                                                                    <td>
                                                                        <div style="float:left">
                                                                            <p>{{$prd->product_name}}</p>
                                                                            <p></p>
                                                                            <p></p>
                                                                            <p></p>
                                                                            <p>Quantity : {{$prd->quantity}}</p>


                                                                        </div>

                                                                    </td>

                                                                    <td>
                                                                        <div style="float:left">
                                                                            <p>Price : £ {{$prd->price}}</p>

                                                                        </div>

                                                                    </td>


                                                                    <td>
                                                                        <div style="float:left">
                                                                            <p>Discount : £ {{$prd->discount}}</p>

                                                                        </div>

                                                                    </td>

                                                                    <td>
                                                                        <div style="float:left">
                                                                            <p>Total : £ {{$prd->total}}</p>
                                                                        </div>

                                                                    </td>
                                                                </tr>
                                                                @endforeach

                                                                                                                        </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>

                                                        <p style="margin:50px 0 3px; font-size: 12px; line-height: 16px; color: #1e1e1e; text-align: left;">Yours,</p>
                                                        <p style="margin:0 0 16px; font-size: 17px;  line-height: 26px; color: #ED622F; font-weight: 600; text-align: left;">TimeX Shipping team</p>

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

                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="center" valign="top">

                <table border="0" cellpadding="10" cellspacing="0" width="600">
                    <tbody>
                    <tr>
                    <td align="center" valign="top">
                        <table border="0" cellpadding="10" cellspacing="0" width="600">
                            <tbody>
                            <tr>
                                <td valign="top" style="padding:0">
                                    <table border="0" cellpadding="10" cellspacing="0" width="100%">
                                        <tbody>
                                        <tr>
                                            <td colspan="2" valign="middle" style="padding:0;border:0;color:#aac482;font-family:Arial;font-size:12px;line-height:125%;text-align:center">
                                                <p style="color: #ffffff; padding-top:20px;margin-top:0px">
                                                    © 2023 TimeX Shipping. All Rights Reserved.</p>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                            </td></tr>
                            </tbody>
                        </table>
                    </td>
                    </tr>
                </tbody>
            </table>

            </td></tr>
        </tbody>
    </table>
    </div>
