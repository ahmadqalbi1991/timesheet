<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Kreait\Firebase\Contract\Database;
use App\Models\Booking;
use App\Models\AcceptedQoute;
use App\Models\User;

class CustomerReceivedQouteNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customer_quote_received:customer {booking_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'The command is used to generate notification to customer for receiving qoute';

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

            $title = 'Quotes Received';
            $notification_id = time();
            $description = "You have received the quotes in booking ".$booking->booking_number;
            $ntype = 'customer_received_quote';


            if($ntype != ''){
                $customer = $booking->customer;
                
                $name       = $customer->name;    
                $data['user'] =   $customer;
                $data['booking'] = $booking;          
               
                $mailbody   = view('emai_templates.statuschange', compact( 'name','title','description','data'))->render();
                send_email($customer->email, $title,$mailbody);

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
