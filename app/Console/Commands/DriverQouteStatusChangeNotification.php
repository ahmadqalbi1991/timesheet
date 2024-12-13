<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Kreait\Firebase\Contract\Database;
use App\Models\Booking;
use App\Models\AcceptedQoute;
use App\Models\User;

class DriverQouteStatusChangeNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'driver_request_change_status:driver {qoute_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'The command is used to generate notification to driver for quote change status';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Database $database)
    {
        parent::__construct();
        $this->database = $database;
    }

    /**
     * Execute the console command.
     *
     * @return int
     * 
     */
    public function handle()
    {
        $qoute_id = $this->argument('qoute_id');
        $accepted_qoute = AcceptedQoute::find($qoute_id); 
        $booking = Booking::with(['customer'])->find($accepted_qoute->booking_id);

        if(!empty($accepted_qoute)){
            $status_text = '';
            $ntype='';
            if($accepted_qoute->status == 'journey_started')
            {
                $status_text = $title = 'Journey Started';
                $notification_id = time();
                $description = "Your Journey Started in the booking ".$booking->booking_number." ";
                $ntype = 'driver_journey_started';
            }

            if($accepted_qoute->status == 'item_collected')
            {
                $status_text = $title = 'Item Collected';
                $notification_id = time();
                $description = "You have Collected the Items in the booking ".$booking->booking_number." ";
                $ntype = 'driver_item_collected';
            }

            if($accepted_qoute->status == 'on_the_way')
            {
                $status_text = $title = 'On the Way';
                $notification_id = time();
                $description = "Your are On the Way in booking ".$booking->booking_number." ";
                $ntype = 'driver_on_the_way';
            }

            if($accepted_qoute->status == 'border_crossing')
            {
                $status_text = $title = 'Border Crossing';
                $notification_id = time();
                $description = "You have successfully Crossed the Border in booking ".$booking->booking_number." ";
                $ntype = 'driver_border_crossing';
            }

            if($accepted_qoute->status == 'custom_clearance')
            {
                $status_text = $title = 'Custom Clearance';
                $notification_id = time();
                $description = "You have successfully Custom Clearance in the booking ".$booking->booking_number." ";
                $ntype = 'driver_custom_clearance';
            }

            if($accepted_qoute->status == 'delivered')
            {
                $status_text = $title = 'Delivered';
                $notification_id = time();
                $description = "You have successfully delivered booking ".$booking->booking_number." ";
                $ntype = 'driver_delivered';
            }
            echo $accepted_qoute->status;

            if($ntype != ''){
                $driver = $accepted_qoute->driver;
                
                if (!empty($driver->firebase_user_key)) {
                    $notification_data["Nottifications/" . $driver->firebase_user_key . "/" . $notification_id] = [
                        "title" => $title,
                        "description" => $description,
                        "notificationType" => $ntype,
                        "createdAt" => gmdate("d-m-Y H:i:s", $notification_id),
                        "orderId" => (string) $booking->id,
                        "invoiceId" => (string) $booking->booking_number,
                        "url" => "",
                        "imageURL" => '',
                        "read" => "0",
                        "seen" => "0",
                    ];
                    $this->database->getReference()->update($notification_data);
                }

                if (!empty($driver->user_device_token)) {
                    send_single_notification($driver->user_device_token, [
                        "title" => $title,
                        "body" => $description,
                        "icon" => 'myicon',
                        "sound" => 'default',
                        "click_action" => "EcomNotification"],
                        ["type" => $ntype,
                            "notificationID" => $notification_id,
                            "orderId" => (string) $booking->id,
                            "invoiceId" => (string) $booking->booking_number,
                            "imageURL" => "",
                        ]);
                }
                
                $driver_phone =  str_replace("+","",$driver->dial_code).$driver->phone;
                //$driver_phone = "919847823799";
                $d_msg =  'Hi '.$driver->name.', your order '.$booking->booking_number.' status has been changed to '.$status_text.'
                    Date/time : '.$booking->created_at.'
                    Customer name : '.$booking->customer->name.'
                    Pick up:'.$booking->collection_address.'
                    drop locations :'.$booking->deliver_address;
                send_whatsap_message($d_msg,$driver_phone);
                $admin_whatsap = config('global.admin_whatsap_number');
                $ad_msg =  'Hi admin, your order '.$booking->booking_number.' status has been changed to '.$status_text.'
                    Order ID : '.$booking->booking_number.'
                    Date/time : '.$booking->created_at.'
                    Customer name : '.$booking->customer->name.'
                    Driver name : '.$driver->name.'
                    Status : '.$status_text.'
                    Pick up:'.$booking->collection_address.'
                    drop locations :'.$booking->deliver_address;
                send_whatsap_message($ad_msg,$admin_whatsap);
            }
            
            if($accepted_qoute->status =='accepted'){
                $title = 'Quote Accepted';
                $driver = $accepted_qoute->driver;
                $driver_phone =  str_replace("+","",$driver->dial_code).$driver->phone;
                //$driver_phone = "919847823799";
                
                
                $data = [
                    '1'=>$driver->name,
                    '2'=>$booking->customer->name,
                    '3'=> $booking->booking_number,
                    '4'=> $booking->created_at?date('d/M/Y H:i:s',strtotime($booking->created_at)):'NA',
                    '5'=> $booking->customer->name??'NA',
                    '6' => $booking->collection_address??'NA',
                    '7' => $booking->deliver_address??'NA'
                ];
                sendWhatsappTemplateMessage($driver_phone, 'HXd293b25b45a3275bf3eeecde201e526e', $data);
                
                $admin_whatsap = config('global.admin_whatsap_number');
                //$admin_whatsap = 919847823799;
                $data = [
                    '1'=>"Quote has been accepted by ".$booking->customer->name." in booking ". $booking->booking_number,
                    '2'=> $booking->booking_number??'NA',
                    '3'=> $booking->created_at?date('d/M/Y H:i:s',strtotime($booking->created_at)):'NA',
                    '4'=> $booking->customer->name??'NA',
                    '5' => $driver->name??'NA',
                    '6' => $title,
                    '7' => $booking->collection_address??'NA',
                    '8' => $booking->deliver_address??'NA'
                ];
                sendWhatsappTemplateMessage($admin_whatsap, 'HXd0035f703a7bc1e7e271db09629b721f', $data);
            }

            
        }   
        return 0;
    }
}
