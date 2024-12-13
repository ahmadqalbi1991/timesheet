<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Kreait\Firebase\Contract\Database;
use App\Models\Booking;
use App\Models\User;


class NotifyDriverBookingNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify_driver_on_booking:user {booking_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'The command is used to generate notification to driver for new booking by customer.';

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
        $booking = Booking::with('booking_truck')->find($booking_id);

        if(!empty($booking)){
            $truck_type_ids = $booking->booking_truck->pluck('truck_id')->toArray();
            if(count($truck_type_ids) == 0){
                return 0;
            }
            $device_tokens = [];
            $notifications = [];
            $notification_id = time();
            $title = 'Booking request has been received.';
            $description = "You have received a new booking request ".$booking->booking_number." ";
            $ntype = 'new_booking_driver';

            $driver_details = \App\Models\DriverDetail::with('user')->whereIn('truck_type_id' , $truck_type_ids)->get();
            if($driver_details->count()){
                foreach ($driver_details as $key => $row) {
                    $user   = $row->user; 
                    
                    
                    if($user){
                        if ($user->firebase_user_key) {
                            $notification_data["Nottifications/" . $user->firebase_user_key . "/" . $notification_id] = [
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
                            $notifications = $notification_data;
                        }

                        if ($user->user_device_token) {  
                            $device_tokens[] = $user->user_device_token;
                        }
                    }
                }
                if(count($device_tokens)){
                    $send_data = [
                        "title" => $title,
                        "body" => $description,
                        "icon" => 'myicon',
                        "sound" => 'default',
                        "click_action" => "EcomNotification"];
                    $other_data =  ["type" => $ntype,
                        "notificationID" => $notification_id,
                        "orderId" => (string) $booking->id,
                        "invoiceId" => (string) $booking->booking_number,
                        "imageURL" => "",
                    ]; 

                    $this->database->getReference()->update($notifications);
                    send_multicast_notification($device_tokens,$send_data,$other_data);

                }
                // dd($notifications,$device_tokens,$send_data,$other_data);
            }


            
        }   
        return 0;
    }
}
