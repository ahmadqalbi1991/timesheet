<!DOCTYPE html>
<html
  xmlns="http://www.w3.org/1999/xhtml"
  xmlns:v="urn:schemas-microsoft-com:vml"
  xmlns:o="urn:schemas-microsoft-com:office:office"
>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>{{config('global.site_name')}}</title>

  </head>
  <?php $booking = $data['booking'];
  $deligate = \App\Models\Deligate::where('id',$booking->deligate_id)->first();
  $trucks = \App\Models\TruckType::where('status','active')->get(); ?>
  <body style="margin: 0; color: #f2f2f2">
    <div marginwidth="0" marginheight="0">
      <div
        marginwidth="0"
        marginheight="0"
        id=""
        dir="ltr"
        style="
          background: #008645;
          margin: 0;
          padding: 20px 0 20px 0;
          width: 100%;
          margin: 0;
        "
      >
        <table
          border="0"
          cellpadding="0"
          cellspacing="0"
          height="100%"
          width="100% "
        >
          <tbody>
            <tr>
              <td align="center" valign="top">
                <table
                  border="0"
                  cellpadding="0"
                  cellspacing="0"
                  width="600"
                  style="
                    background: #ffffff;
                    border-radius: 15px !important;
                    overflow: hidden;
                  "
                >
                  <tbody>
                    <tr>
                      <td style="background: #ffffff">
                        <div
                          style="
                            padding: 15px 20px;
                            background: #ffffff;
                            padding-bottom: 15px;
                          "
                        >
                          <table
                            style="
                              background: #ffffff;
                              font-family: Roboto, RobotoDraft, Helvetica, Arial,
                                sans-serif;
                              font-size: 14px;
                              width: 100%;
                            "
                          >
                            <tbody>
                              <tr>
                                <td>
                                  <img
                                    src="{{ asset('') }}admin-assets/assets/img/logo.png"
                                    alt=""
                                    style="width: 100px; margin-bottom: 0px"
                                  />
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <h2
                                    style="
                                      color: #1e1e1e;
                                      line-height: 42px;
                                      font-size: 30px;
                                      padding-right: 20px;
                                    "
                                  >
                                  New booking
                                  </h2>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td
                        align="center"
                        valign="top"
                        style="background: #ffffff"
                      >
                        <table
                          border="0"
                          cellpadding="0"
                          cellspacing="0"
                          width="600"
                          style="background: #ffffff"
                        >
                          <tbody>
                            <tr>
                              <td
                                valign="top"
                                style="background-color: #ffffff; padding: 0"
                              >
                                <table
                                  border="0"
                                  cellpadding="20"
                                  cellspacing="0"
                                  width="100%"
                                  style="
                                    font-family: Roboto, RobotoDraft, Helvetica,
                                      Arial, sans-serif;
                                  "
                                >
                                  <tbody>
                                    <tr>
                                      <td
                                        valign="top"
                                        style="padding-bottom: 0px"
                                      >
                                        <div
                                          style="
                                            color: #636363;
                                            font-family: Roboto, RobotoDraft,
                                              Helvetica, Arial, sans-serif;
                                            font-size: 14px;
                                            line-height: 150%;
                                            text-align: left;
                                            margin-top: 0px;
                                          "
                                        >
                                          <h4
                                            style="
                                              font-weight: 600;
                                              font-size: 28px;
                                              color: #1e1e1e;
                                              margin-top: 0px;
                                            "
                                          >
                                            Dear
                                            <span style="color: #ed622f"
                                              >{{ $data['user']->name}},</span
                                            >
                                          </h4>
                                          <p
                                            style="
                                              margin: 0 0 16px;
                                              font-size: 15px;
                                              line-height: 26px;
                                              color: #1e1e1e;
                                              text-align: left;
                                            "
                                          >
                                          New booking assigned to you by admin
                                          </p>
                                        </div>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div style="color: #000">
                                          <table width="100%" class="booking-table" style=" border: 1px solid #ccc;border-collapse: collapse;margin-top: 15px;">
                                            <tr>
                                              <td colspan="2" style="padding:  10px;
    background: #ed622f;
    color: white;
    font-weight: 700;
    text-align: left;">
                                                Booking Details
                                              </td>
                                            </tr>
                                            <tr >
                                              <td style="border: 1px solid #ccc;padding:10px;width: 50%;">
                                              <strong>Booking</strong>
                                              </td>
                                              <td style="border: 1px solid #ccc;padding:10px;">
                                                 {{$booking->booking_number}}
                                              </td>
                                            </tr>
                                            @if(isset($booking->invoice_number))
                                            <tr>
                                              <td style="border: 1px solid #ccc;padding:10px; font-weight: 700;">Invoice</td>
                                              <td style="border: 1px solid #ccc;padding:10px;">
                                                #{{$booking->invoice_number }}
                                              </td>
                                            </tr>
                                            @else
                                            <tr>
                                              <td style="border: 1px solid #ccc;padding:10px; font-weight: 700;">Invoice</td>
                                              <td style="border: 1px solid #ccc;padding:10px; ">
                                                 {{'# (Not Added Yet)' }}
                                              </td>
                                            </tr>
                                            @endif
                                            <tr>
                                              <td style="border: 1px solid #ccc;padding:10px; font-weight: 700;">Deligate</td>
                                              <td style="border: 1px solid #ccc;padding:10px; ">
                                                 {{ $deligate->name ?? '' }}
                                              </td>
                                            </tr>
                                            @if(!empty($booking->deligate_type))
                                            <tr>
                                              <td style="border: 1px solid #ccc;padding:10px; font-weight: 700;">Deligate Type</td>
                                              <td style="border: 1px solid #ccc;padding:10px; " >
                                                 {{
                                                  strtoupper($booking->deligate_type)
                                                ?? '' }}
                                              </td>
                                            </tr>
                                             @endif
                                             @if($booking->deligate_type ==
                                            'ltl')
                                            <tr>
                                              <td style="border: 1px solid #ccc;padding:10px; font-weight: 700;">Item / HS Code</td>
                                              <td style="border: 1px solid #ccc;padding:10px; " >
                                                 {{
                                                $booking->booking_deligate_detail->item
                                                ?? '' }}
                                              </td>
                                            </tr>
                                            <tr>
                                              <td style="border: 1px solid #ccc;padding:10px; font-weight: 700;">No of Packages</td>
                                              <td style="border: 1px solid #ccc;padding:10px; ">
                                                 {{
                                                $booking->booking_deligate_detail->no_of_packages
                                                ?? '' }}
                                              </td>
                                            </tr>

                                            <tr>
                                              <td style="border: 1px solid #ccc;padding:10px; font-weight: 700;">Dimension of each Package</td>
                                              <td style="border: 1px solid #ccc;padding:10px; ">
                                                 {{
                                                $booking->booking_deligate_detail->dimension_of_each_package
                                                ?? '' }}
                                              </td>
                                            </tr>

                                            <tr>
                                              <td style="border: 1px solid #ccc;padding:10px; font-weight: 700;">Weight of each Package</td>
                                              <td style="border: 1px solid #ccc;padding:10px; ">
                                                {{
                                                $booking->booking_deligate_detail->weight_of_each_package
                                                ?? '' }}
                                              </td>
                                            </tr>

                                            <tr>
                                              <td style="border: 1px solid #ccc;padding:10px; font-weight: 700;">Total Gross Weight</td>
                                              <td style="border: 1px solid #ccc;padding:10px; ">
                                                 {{
                                                $booking->booking_deligate_detail->total_gross_weight
                                                ?? '' }}
                                              </td>
                                            </tr>
                                            <tr>
                                              <td style="border: 1px solid #ccc;padding:10px; font-weight: 700;">Total Volume in CBM</td>
                                              <td style="border: 1px solid #ccc;padding:10px; ">
                                                 {{
                                                $booking->booking_deligate_detail->total_volume_in_cbm
                                                ?? '' }}
                                              </td>
                                            </tr>
                                            @endif @if($booking->deligate_id ==
                                            4)
                                            <tr>
                                              <td style="border: 1px solid #ccc;padding:10px; font-weight: 700;">
                                                Would you like to
                                                <b>Timex Shipping LLC</b> to
                                                collect your cargo?
                                              </td>
                                              <td style="border: 1px solid #ccc;padding:10px; ">
                                                 {{ $booking->is_collection ==
                                                1 ?'Yes':'No' }}
                                              </td>
                                            </tr>
                                            <tr>
                                              <td style="border: 1px solid #ccc;padding:10px; font-weight: 700;">Items are stockable</td>
                                              <td style="border: 1px solid #ccc;padding:10px; ">
                                                 {{
                                                strtoupper($booking->warehouse_detail->items_are_stockable)
                                                }}
                                              </td>
                                            </tr>
                                            <tr>
                                              <td style="border: 1px solid #ccc;padding:10px; font-weight: 700;">Types of Storages</td>
                                              <td style="border: 1px solid #ccc;padding:10px; ">
                                                 {{
                                                $booking->warehouse_detail->storage_type->name
                                                ?? ' ' }}
                                              </td>
                                            </tr>
                                            <tr>
                                              <td style="border: 1px solid #ccc;padding:10px; font-weight: 700;">Item</td>
                                              <td style="border: 1px solid #ccc;padding:10px; ">
                                                 {{
                                                $booking->warehouse_detail->item
                                                ?? ' ' }}
                                              </td>
                                            </tr>
                                            <tr>
                                              <td style="border: 1px solid #ccc;padding:10px; font-weight: 700;">No of Pallets</td>
                                              <td style="border: 1px solid #ccc;padding:10px; ">
                                                 {{
                                                $booking->warehouse_detail->no_of_pallets
                                                ?? ' ' }}
                                              </td>
                                            </tr>
                                            <tr>
                                              <td style="border: 1px solid #ccc;padding:10px; font-weight: 700;">Pallet Dimensions</td>
                                              <td style="border: 1px solid #ccc;padding:10px; ">
                                                 {{
                                                $booking->warehouse_detail->pallet_dimension
                                                ?? ' ' }}
                                              </td>
                                            </tr>
                                            <tr>
                                              <td style="border: 1px solid #ccc;padding:10px; font-weight: 700;">Weight per Pallet (Kg)</td>
                                              <td style="border: 1px solid #ccc;padding:10px; ">
                                                 {{
                                                $booking->warehouse_detail->weight_per_pallet
                                                ?? ' ' }}
                                              </td>
                                            </tr>
                                            <tr>
                                              <td style="border: 1px solid #ccc;padding:10px; font-weight: 700;">Total Weight (Kg)</td>
                                              <td style="border: 1px solid #ccc;padding:10px; ">
                                                 {{
                                                $booking->warehouse_detail->total_weight
                                                ?? ' ' }}
                                              </td>
                                            </tr>
                                            <tr>
                                              <td style="border: 1px solid #ccc;padding:10px; font-weight: 700;">Total Item Cost</td>
                                              <td style="border: 1px solid #ccc;padding:10px; ">
                                                 {{
                                                $booking->warehouse_detail->total_item_cost
                                                ?? ' ' }}
                                              </td>
                                            </tr>
                                            @endif
                                          </table>
                                          <table style="width: 100%;" >
                                            <tbody>
                                              <tr>

                                      
                                                <td style="width: 50%;" valign="top">
                                                @if($booking->is_collection == 1)
                                                  <table class="booking-table" style=" border: 1px solid #ccc;border-collapse: collapse;margin-top: 15px;width: 100%;">
                                                    <tbody>
                                                      <tr>
                                                        <td style="text-align: left;border: 0px solid #ccc;padding:10px; font-weight: 700;    background: #008645;color: white;">
                                                         <strong>
                                                          Collection Address
                                                         </strong>
                                                        </td>
                                                      </tr>
                                                      <tr>
                                                        <td style="border: 1px solid #ccc;padding:10px; font-weight: 700; text-align: left;">
                                                          <div>
                                                            <p style="    margin-top: 0;">{{ $data['booking']->collection_address}},
                                                            {{ $data['booking']->collection_country}},
                                                            {{ $data['booking']->collection_phone}}   </p>
                                                            <a href="http://www.google.com/maps/place/{{ $data['booking']->collection_latitude}},{{ $data['booking']->collection_longitude}}"><button style="color: #ed622f;
    border: 0;
    border-radius: 5px;
    cursor: pointer;
    background: white;
    font-weight: bold;
    text-decoration: underline;">View Map</button></a>
                                                        </div>

                                                        </td>
                                                      </tr>
                                                    </tbody>
                                                  </table>
                                                  @endif
                                                </td>

                                                <td style="width: 50%;" valign="top">
                                                @if(!empty($data['booking']->deliver_address))
                                                  <table class="booking-table" style=" border: 1px solid #ccc;border-collapse: collapse;margin-top: 15px;width: 100%;">
                                                    <tbody>
                                                      <tr>
                                                        <td style="text-align: left;border: 0px solid #ccc;padding:10px; font-weight: 700;    background: #ed622f;color: white;">
                                                         <strong>
                                                          Deliver Address
                                                         </strong>
                                                        </td>
                                                      </tr>
                                                      <tr>
                                                        <td style="border: 1px solid #ccc;padding:10px; font-weight: 700;text-align: left;">
                                                         <div>
                                                           <p style="    margin-top: 0;"> {{ $data['booking']->deliver_address}},
                                                           {{ $data['booking']->deliver_city}} ,
                                                           {{ $data['booking']->deliver_country}},
                                                           {{ $data['booking']->deliver_phone}}
                                                           </p>
                                                           <a href="http://www.google.com/maps/place/{{ $data['booking']->deliver_latitude}},{{ $data['booking']->deliver_longitude}}"><button style="color: #ed622f;
    border: 0;
    border-radius: 5px;
    cursor: pointer;
    background: white;
    font-weight: bold;
    text-decoration: underline;">View Map</button></a>
                                                         </div>
                                                        </td>
                                                      </tr>
                                                    </tbody>
                                                  </table>
                                                  @endif
                                                </td>

                                              </tr>
                                            </tbody>
                                          </table>
                                         
                                          @if($booking->deligate_type == 'ftl')
                                          @if(!empty($booking->booking_truck))
                                          <table width="100%" class="booking-table" style=" border: 1px solid #ccc;border-collapse: collapse;margin-top: 15px;">
                                            <tr>
                                              <td style="border: 1px solid #ccc;padding:10px; font-weight: 700;">Truck Type</td>
                                              <td style="border: 1px solid #ccc;padding:10px; font-weight: 700;">Quantity</td>
                                              <td style="border: 1px solid #ccc;padding:10px; font-weight: 700;">Total Gross Weight</td>
                                            </tr>
                                            @if($booking->deligate_type == 'ftl')

                                            @foreach($booking->booking_truck as $b_truck)
                                                  <tr>
                                                    <td style="border: 1px solid #ccc;padding:10px; font-weight: 700;"> @foreach($trucks as $truck)
                                                      @if($truck->id == $b_truck->truck_id)
                                                      {{$truck->truck_type." -- "."(".$truck->dimensions.")"}}
                                                        @endif
                                                    @endforeach</td>
                                                    <td style="border: 1px solid #ccc;padding:10px; font-weight: 700;">{{ $b_truck->quantity }}</td>
                                                    <td style="border: 1px solid #ccc;padding:10px; font-weight: 700;">{{ $b_truck->gross_weight }} Kg Per Truck</td>
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
                                          <p
                                            style="
                                              margin: 0 0 3px;
                                              font-size: 12px;
                                              line-height: 16px;
                                              color: #1e1e1e;
                                              text-align: left;
                                            "
                                          >
                                            Yours,
                                          </p>
                                          <p
                                            style="
                                              margin: 0 0 16px;
                                              font-size: 17px;
                                              line-height: 26px;
                                              color: #ed622f;
                                              font-weight: 600;
                                              text-align: left;
                                            "
                                          >
                                            TimeX Shipping team
                                          </p>
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
                      <td style="background: #ffffff">
                        <div style="padding: 20px; background: #ffffff">
                          <table
                            style="
                              background: #ffffff;
                              font-family: Roboto, RobotoDraft, Helvetica, Arial,
                                sans-serif;
                              font-size: 14px;
                              width: 100%;
                            "
                          >
                            <tbody>
                              <tr>
                                <td style="width: 100%" colspan="2">
                                  <table style="font-size: 14px; width: 100%">
                                    <tbody>
                                      <tr>
                                        <td
                                          colspan="2"
                                          valign="middle"
                                          style="
                                            padding: 0;
                                            border: 0;
                                            color: #777777;
                                            font-family: Arial;
                                            font-size: 12px;
                                            line-height: 125%;
                                            text-align: center;
                                            background: #ffffff;
                                          "
                                        >
                                          <p>
                                            © {{date('Y')}}
                                            {{config('global.site_name')}}. All
                                            Rights Reserved.
                                          </p>
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
