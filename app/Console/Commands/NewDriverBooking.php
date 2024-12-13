<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Kreait\Firebase\Contract\Database;
use App\Models\Booking;
use App\Models\BookingQoute;
use App\Models\User;

class NewDriverBooking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'new:driverbooking {qoute_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'The command is used to generate notification to driver for submit quote';

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
        $quoteDetails = BookingQoute::with(['driver','booking'])->find($qoute_id);
        

        $customer   = $quoteDetails->driver;    
        $name       = $customer->name;
        $title      = 'New booking';
        $description = "New booking assigned to you by admin";
        
        $data['user'] =   $customer;
        $data['booking'] = $quoteDetails->booking;
        $mailbody   = view('emai_templates.statuschange', compact( 'name','title','description','data'))->render();
        send_email($customer->email, $title,$mailbody);
        //$customer->email 
        $ntype = 'new_booking_driver';
        $notification_id = time();
        $booking = $quoteDetails->booking;
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
    }
}