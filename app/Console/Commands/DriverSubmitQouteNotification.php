<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Kreait\Firebase\Contract\Database;
use App\Models\Booking;
use App\Models\BookingQoute;
use App\Models\User;

class DriverSubmitQouteNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'driver_submit_qoute:driver {qoute_id}';

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
        $booking_qoute = BookingQoute::find($qoute_id); 
        $booking = Booking::find($booking_qoute->booking_id);

        if(!empty($booking_qoute)){

            $title = 'Quote Submitted';
            $notification_id = time();
            $description = "You have successfully submitted the quote in booking ". $booking->booking_number;
            $ntype = 'driver_qoute_submitted';

            if($ntype != ''){
                $driver = $booking_qoute->driver;
                
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
                
                
                $data = [
                    '1'=>$driver->name,
                    '2'=> $booking->booking_number,
                    '3'=> $booking->created_at?date('d/M/Y H:i:s',strtotime($booking->created_at)):'NA',
                    '4'=> $booking->customer->name??'NA',
                    '5' => $booking->collection_address??'NA',
                    '6' => $booking->deliver_address??'NA'
                ];
                sendWhatsappTemplateMessage($driver_phone, 'HXc13bc0c0fda4ba5aac4d9a9afad98361', $data);
                
                $admin_whatsap = config('global.admin_whatsap_number');
                
                $data = [
                    '1'=>'driver submitted the quote in booking '.$booking->booking_number,
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
