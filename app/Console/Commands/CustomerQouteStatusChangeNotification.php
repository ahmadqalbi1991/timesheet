<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Kreait\Firebase\Contract\Database;
use App\Models\Booking;
use App\Models\AcceptedQoute;
use App\Models\User;

class CustomerQouteStatusChangeNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customer_request_change_status:customer {qoute_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'The command is used to generate notification to customer for quote change status';

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
        $booking = Booking::find($accepted_qoute->booking_id);

        if(!empty($accepted_qoute)){

            $driver = $accepted_qoute->driver;

            if($accepted_qoute->status == 'journey_started')
            {
                $title = 'Journey Started';
                $notification_id = time();
                $description = "The Driver ".$driver->name." has Started Journey in the booking ".$booking->booking_number." ";
                $ntype = 'customer_journey_started';
            }

            if($accepted_qoute->status == 'item_collected')
            {
                $title = 'Item Collected';
                $notification_id = time();
                $description = "The Driver ".$driver->name." has Collected the Items in the booking ".$booking->booking_number." ";
                $ntype = 'customer_item_collected';
            }

            if($accepted_qoute->status == 'on_the_way')
            {
                $title = 'On the Way';
                $notification_id = time();
                $description = "The Driver ".$driver->name." is On the Way in booking ".$booking->booking_number." ";
                $ntype = 'customer_on_the_way';
            }

            if($accepted_qoute->status == 'border_crossing')
            {
                $title = 'Border Crossing';
                $notification_id = time();
                $description = "The Driver ".$driver->name." has successfully Crossed the Border in booking ".$booking->booking_number." ";
                $ntype = 'customer_border_crossing';
            }

            if($accepted_qoute->status == 'custom_clearance')
            {
                $title = 'Custom Clearance';
                $notification_id = time();
                $description = "The Driver ".$driver->name." successfully Cleared the Custom in the booking ".$booking->booking_number." ";
                $ntype = 'customer_custom_clearance';
            }

            if($accepted_qoute->status == 'delivered')
            {
                $title = 'Delivered';
                $notification_id = time();
                $description = "The Driver ".$driver->name." has successfully delivered booking ".$booking->booking_number." ";
                $ntype = 'customer_delivered';
            }

            if($ntype != ''){
                $customer = $booking->customer;
                
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

            
        }   
        return 0;
    }
}
