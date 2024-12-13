<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{config('global.site_name')}}</title>
  </head>
  <?php $booking = $data['booking'];
$deligate = \App\Models\Deligate::where('id',$booking->deligate_id)->first();
$trucks = \App\Models\TruckType::where('status','active')->get();
?>
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
                                                            <h4 style="font-weight: 600; font-size: 28px; color: #1e1e1e;margin-top: 0px">Dear <span style="color: #ED622F;">    Admin,</span> </h4>
                                                            <p style="margin:0 0 16px; font-size: 15px; line-height: 26px; color: #1e1e1e; text-align: left;">
                                                                  The Driver {{ $data['driver']->name ?? ''}} has submitted th quote against the request. {{ $data['booking']->booking_number}}.
                                                            </p>





                                                        </div>
                                                    </td>
                                                </tr>

                                    <tr>
                                        <td>
                                            <div style="color:#000">
                                                 <table width="100%">
                                                  <tr>
                                                    <td>Booking</td>
                                                    <td>: {{$booking->booking_number}}</td>
                                                  </tr>
                                                  @if(isset($booking->invoice_number))
                                                  <tr>
                                                    <td>Invoice</td>
                                                    <td>: #{{$booking->invoice_number }}</td>
                                                  </tr>
                                                  @else
                                                  <tr>
                                                    <td>Invoice</td>
                                                    <td>: {{'# (Not Added Yet)' }}</td>
                                                  </tr>
                                                  @endif
                                                  <tr>
                                                    <td>Deligate</td>
                                                    <td>: {{ $deligate->name ?? '' }}</td>
                                                  </tr>
                                                  @if($booking->is_collection == 1)
                                                  <tr>
                                                    <td>Collection Address</td>
                                                    <td>: {{ $data['booking']->collection_address}}</td>
                                                  </tr>
                                                  @endif
                                                  @if(!empty($data['booking']->deliver_address))
                                                  <tr>
                                                    <td>Deliver Address</td>
                                                    <td>: {{ $data['booking']->deliver_address}}</td>
                                                  </tr>
                                                  @endif
                                                  @if($booking->deligate_id == 2)
                                                  <tr>
                                                    <td>Item / HS Code</td>
                                                    <td>: {{ $booking->booking_deligate_detail->item ?? '' }}</td>
                                                  </tr>
                                                  <tr>
                                                    <td>No of Packages</td>
                                                    <td>: {{ $booking->booking_deligate_detail->no_of_packages ?? '' }}</td>
                                                  </tr>

                                                  <tr>
                                                    <td>Dimension of each Package</td>
                                                    <td>: {{ $booking->booking_deligate_detail->dimension_of_each_package ?? '' }}</td>
                                                  </tr>

                                                  <tr>
                                                    <td>Weight of each Package</td>
                                                    <td>: {{ $booking->booking_deligate_detail->weight_of_each_package ?? '' }}</td>
                                                  </tr>

                                                  <tr>
                                                    <td>Total Gross Weight</td>
                                                    <td>: {{ $booking->booking_deligate_detail->total_gross_weight ?? '' }}</td>
                                                  </tr>
                                                  <tr>
                                                    <td>Total Volume in CBM</td>
                                                    <td>: {{ $booking->booking_deligate_detail->total_volume_in_cbm ?? '' }}</td>
                                                  </tr>
                                                  @endif
                                                  @if($booking->deligate_id == 4)
                                                  <tr>
                                                    <td>Would you like to <b>Timex Shipping LLC</b> to collect your cargo?</td>
                                                    <td>: {{ $booking->is_collection == 1 ?'Yes':'No' }}</td>
                                                  </tr>
                                                  <tr>
                                                    <td>Items are stockable</td>
                                                    <td>: {{ strtoupper($booking->warehouse_detail->items_are_stockable) }}</td>
                                                  </tr>
                                                  <tr>
                                                    <td>Types of Storages</td>
                                                    <td>: {{ $booking->warehouse_detail->storage_type->name ?? ' ' }}</td>
                                                  </tr>
                                                  <tr>
                                                    <td>Item</td>
                                                    <td>: {{ $booking->warehouse_detail->item ?? ' ' }}</td>
                                                  </tr>
                                                  <tr>
                                                    <td>No of Pallets</td>
                                                    <td>: {{ $booking->warehouse_detail->no_of_pallets ?? ' ' }}</td>
                                                  </tr>
                                                  <tr>
                                                    <td>Pallet Dimensions</td>
                                                    <td>: {{ $booking->warehouse_detail->pallet_dimension ?? ' ' }}</td>
                                                  </tr>
                                                  <tr>
                                                    <td>Weight per Pallet (Kg)</td>
                                                    <td>: {{ $booking->warehouse_detail->weight_per_pallet ?? ' ' }}</td>
                                                  </tr>
                                                  <tr>
                                                    <td>Total Weight (Kg)</td>
                                                    <td>: {{ $booking->warehouse_detail->total_weight ?? ' ' }}</td>
                                                  </tr>
                                                  <tr>
                                                    <td>Total Item Cost</td>
                                                    <td>: {{ $booking->warehouse_detail->total_item_cost ?? ' ' }}</td>
                                                  </tr>
                                                  @endif

                                                  </table>
                                                  @if($booking->deligate_id == 1)
                                                  @if(!empty($booking->booking_truck))
                                                  <table width="100%">
                                                    <tr>
                                                    <td>Truck Type</td>
                                                    <td>Quantity</td>
                                                    <td>Total Gross Weight</td>
                                                    </tr>
                                                  @if($booking->deligate_id == 1)
                                                  @foreach($booking->booking_truck as $b_truck)
                                                  <tr>
                                                    <td> @foreach($trucks as $truck)
                                                      @if($truck->id == $b_truck->truck_id)
                                                      {{$truck->truck_type." -- "."(".$truck->dimensions.")"}}
                                                        @endif
                                                    @endforeach</td>
                                                    <td>{{ $b_truck->quantity }}</td>
                                                    <td>{{ $b_truck->gross_weight }}</td>
                                                    </tr>
                                                    @endforeach
                                                    @endif
                                                  </table>
                                                  @endif
                                                  @endif

                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div>
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
                                        <td colspan="2" valign="middle" style="padding:0;border:0;color:#777777;font-family:Arial;font-size:12px;line-height:125%;text-align:center; background: #ffffff;">
                                          <p> © {{date('Y')}} {{config('global.site_name')}}. All Rights Reserved.</p>
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



