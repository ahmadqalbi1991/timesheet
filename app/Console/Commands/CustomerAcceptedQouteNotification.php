<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Kreait\Firebase\Contract\Database;
use App\Models\Booking;
use App\Models\AcceptedQoute;
use App\Models\User;

class CustomerAcceptedQouteNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customer_quote_accepted:customer {qoute_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'The command is used to generate notification to customer for qoute accept status';

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

            $title = 'Quote Accepted';
            $notification_id = time();
            $description = "You have accepted the quote in booking ".$booking->booking_number." "." Submitted by ".$accepted_qoute->driver->name;
            $ntype = 'customer_qoute_accepted';


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
