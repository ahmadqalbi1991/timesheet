<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Kreait\Firebase\Contract\Database;
use App\Models\Booking;
use App\Models\AcceptedQoute;
use App\Models\User;

class CustomerReviewSubmitNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user_review:user {booking_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'The command is used to generate notification to customer for submit review';

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

        if(!empty($accepted_qoute)){

            $title = 'Reviews Submitted';
            $notification_id = time();
            $description = "You have successfully submitted reviews in booking ".$booking->booking_number;
            $ntype = 'customer_review_submitted';


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
