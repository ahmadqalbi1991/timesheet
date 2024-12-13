<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Kreait\Firebase\Contract\Database;
use App\Models\Booking;
use App\Models\User;


class CustomerBookingNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user_booking:user {booking_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'The command is used to generate notification to user for booking each booking status';

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
        $booking_id = $this->argument('booking_id');
        $booking = Booking::find($booking_id);

        if(!empty($booking)){

            $title = 'Successfully placed Booking';
            $notification_id = time();
            $description = "You have successfully placed a booking request ".$booking->booking_number." ";
            $ntype = '';
            $wdesc="You have a new  booking from ".$booking->customer->name." ". $booking->booking_number;

            if($booking->status == 'pending')
            {
                $title = 'Successfully placed Booking';
                $notification_id = time();
                $description = "You have successfully placed a booking ".$booking->booking_number." ";
                $ntype = 'customer_new_booking';
                $wdesc="You have a new  booking from ".$booking->customer->name." ". $booking->booking_number;
            }

            if($booking->status == 'on_process')
            {
                $title = 'Your Booking is on process';
                $notification_id = time();
                $description = "Your Booking is on process ".$booking->booking_number." ";
                $ntype = 'customer_on_process_booking';
                $wdesc=$description;
            }

            if($booking->status == 'completed')
            {
                $title = 'Your Booking is completed';
                $notification_id = time();
                $description = "Your Booking has been completed ".$booking->booking_number." ";
                $ntype = 'customer_completed_booking';
                $wdesc=$description;
            }


            ////////////////////////////
            if($booking->status == 'collected_from_shipper')
            {
                $title = 'Collected From Shipper.';
                $notification_id = time();
                $description = "Your Booking Items Are Collected From Shipper ".$booking->booking_number." ";
                $ntype = 'customer_on_process_booking';
                $wdesc=$description;
            }
            if($booking->status == 'cargo_cleared_at_origin_border')
            {
                $title = 'Cargo Cleared at Origin Border.';
                $notification_id = time();
                $description = "Your Booking Items Are Cargo Cleared at Origin Border ".$booking->booking_number." ";
                $ntype = 'customer_on_process_booking';
                $wdesc=$description;
            }
            if($booking->status == 'cargo_tracking')
            {
                $title = 'Cargo Tracking.';
                $notification_id = time();
                $description = "Your Booking Items Are in Cargo Tracking ".$booking->booking_number." ";
                $ntype = 'customer_on_process_booking';
                $wdesc=$description;
            }
            if($booking->status == 'cargo_reached_destination_border')
            {
                $title = 'Cargo Reached Destination Border';
                $notification_id = time();
                $description = "Your Booking Items Are Reached at Destination Border".$booking->booking_number." ";
                $ntype = 'customer_on_process_booking';
                $wdesc=$description;
            }
            if($booking->status == 'cargo_cleared_destination_customs')
            {
                $title = 'Cargo Cleared Destination Customs.';
                $notification_id = time();
                $description = "Your Booking Items Are Cleared Destination Customs".$booking->booking_number." ";
                $ntype = 'customer_on_process_booking';
                $wdesc=$description;
            }
            if($booking->status == 'delivery_completed')
            {
                $title = 'Delivered Completed.';
                $notification_id = time();
                $description = "Your Booking Items Are Delivered Successfully ".$booking->booking_number." ";
                $ntype = 'customer_on_process_booking';
                $wdesc=$description;
            }
            ////////////////////////////

            if($booking->status == 'items_received_in_warehouse')
            {
                $title = 'Items Received';
                $notification_id = time();
                $description = "Your Booking items are received in warehouse ".$booking->booking_number." ";
                $ntype = 'customer_on_process_booking';
                $wdesc=$description;
            }
            if($booking->status == 'items_stored')
            {
                $title = 'Items Stored';
                $notification_id = time();
                $description = "Your Booking Items Are Stored in warehouse ".$booking->booking_number." ";
                $ntype = 'customer_on_process_booking';
                $wdesc=$description;
            }

            $customer   = $booking->customer; 
            $name       = $customer->name;
            //$mailbody   = view('emai_templates.statuschange', compact( 'name','title','description'))->render();
            //send_email($customer->email, $title,$mailbody);

            // if($reservation_booking->status == config('global.booking_status_wait_for_schedule'))
            // {
            //     $title = 'Chalet Booking Wait For Your Scheduled';
            //     $notification_id = time();
            //     $description = "Your booking has been confirmed, you have to wait for your Schedule in booking request ".$reservation_booking->booking_id." ";
            //     $ntype = 'user_wait_for_schedule_chalet_booking';
            // }


            if($ntype != ''){
               // $customer = $booking->customer; print_r($customer);
                
                if (!empty($customer->firebase_user_key)) {
                    $notification_data["Nottifications/" . $customer->firebase_user_key . "/" . $notification_id] = [
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

                if (!empty($customer->user_device_token)) {  
                    send_single_notification($customer->user_device_token, [
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
            }
            
            //   $driver_phone =  str_replace("+","",$driver->dial_code).$driver->phone;
            //     //$driver_phone = "919847823799";
                
                
            //     $data = [
            //         '1'=>$driver->name,
            //         '2'=>$booking->customer->name,
            //         '3'=> $booking->booking_number,
            //         '4'=> $booking->created_at?date('d/M/Y H:i:s',strtotime($booking->created_at)):'NA',
            //         '5'=> $booking->customer->name??'NA',
            //         '6' => $booking->collection_address??'NA',
            //         '7' => $booking->deliver_address??'NA'
            //     ];
            //     sendWhatsappTemplateMessage($driver_phone, 'HXd293b25b45a3275bf3eeecde201e526e', $data);
                
                $admin_whatsap = config('global.admin_whatsap_number');
                //$admin_whatsap = 919847823799;
                $data = [
                    '1'=> $wdesc,
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
        return 0;
    }
}
