<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Booking;
use App\Models\Deligate;
use App\Models\user_wallet_transactions;
use App\Models\BookingQoute;
use App\Models\AcceptedQoute;
use App\Models\BookingAdditionalCharge;
use App\Models\BookingStatusTracking;
use App\Models\BookingTruck;
use App\Models\BookingTruckAlot;
use App\Models\BookingDeligateDetail;
use App\Models\WarehouseDetail;
use App\Models\booking_reviews;
use App\Mail\DriverSubmitMail;
use Mail;
use Validator;
use DB;

class DriverBookingController extends Controller
{
    private function validateAccesToken($access_token)
    {
        $user = User::where(['user_access_token' => $access_token])->get();

        if ($user->count() == 0) {
            http_response_code(401);
            echo json_encode([
                'status' => "0",
                'message' => 'Invalid login',
                'oData' => [],
                'errors' => (object) [],
            ]);
            exit;

        } else {
            $user = $user->first();
            if ($user != null) { //$user->active == 1
                return $user->id;
            } else {
                http_response_code(401);
                echo json_encode([
                    'status' => "0",
                    'message' => 'Invalid login',
                    'oData' => [],
                    'errors' => (object) [],
                ]);
                exit;
                return response()->json([
                    'status' => "0",
                    'message' => 'Invalid login',
                    'oData' => [],
                    'errors' => (object) [],
                ], 401);
                exit;
            }
        }
    }

    public function driver_pending_requests(Request $request){

        $status = "0";
        $message = "";
        $o_data = [];
        $errors = [];

        $limit = isset($request->limit) ? $request->limit : 10;
        $offset = isset($request->page) ? ($request->page - 1) * $request->limit : 0;
       
        $validator = Validator::make($request->all(), [
            'access_token'           => 'required',
            'timezone'               => 'required'
        ]);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        } else {
            
            $user_id = $this->validateAccesToken($request->access_token);
            $bookings = Booking::join('booking_qoutes','bookings.id','=','booking_qoutes.booking_id')
            ->select('bookings.id as id',
                    'bookings.booking_number as booking_number',
                    'bookings.collection_address as collection_address',
                    'bookings.collection_latitude as collection_latitude',
                    'bookings.collection_longitude as collection_longitude',
                    'bookings.collection_country as collection_country',
                    'bookings.collection_city as collection_city',
                    'bookings.collection_phone as collection_phone',
                    'bookings.deliver_address as deliver_address',
                    'bookings.deliver_latitude as deliver_latitude',
                    'bookings.deliver_longitude as deliver_longitude',
                    'bookings.deliver_country as deliver_country',
                    'bookings.deliver_city as deliver_city',
                    'bookings.deliver_phone as deliver_phone',
                    'bookings.created_at as created_at',
                    'booking_qoutes.status as quote_status',
                    )
            ->where('booking_qoutes.driver_id',$user_id)
            ->whereIn('booking_qoutes.status',['pending','qouted'])
            ->orderBy('bookings.id','desc');

            if($limit !="") {
                $bookings->limit($limit)->skip($offset);
            }

            $bookings = $bookings->get()->map(function ($item) use($request) {
                
                 $item->quote_status_number = config('global.'.$item->quote_status);
                 $item->quote_status = driver_quote_status_name($item->quote_status);
                 $item->created_at = api_date_in_timezone($item->created_at, 'Y-m-d H:i:s', $request->timezone);
                 $item->created_at_format = api_date_in_timezone($item->created_at, 'd M Y', $request->timezone);
                return $item;
            });            

            $status = "1";
            $o_data['list'] = $bookings->toArray();
            $o_data = convert_all_elements_to_string($o_data);
        }
        
        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => $o_data], 200);
    }

    public function driver_accepted_requests(Request $request){

        $status = "0";
        $message = "";
        $o_data = [];
        $errors = [];

        $limit = isset($request->limit) ? $request->limit : 10;
        $offset = isset($request->page) ? ($request->page - 1) * $request->limit : 0;
       
        $validator = Validator::make($request->all(), [
            'access_token'           => 'required',
            'timezone'               => 'required'
        ]);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        } else {
            
            $user_id = $this->validateAccesToken($request->access_token);
            $bookings = Booking::join('accepted_qoutes','bookings.id','=','accepted_qoutes.booking_id')
            ->select('bookings.id as id',
                    'bookings.booking_number as booking_number',
                    'bookings.collection_address as collection_address',
                    'bookings.collection_latitude as collection_latitude',
                    'bookings.collection_longitude as collection_longitude',
                    'bookings.collection_country as collection_country',
                    'bookings.collection_city as collection_city',
                    'bookings.collection_phone as collection_phone',
                    'bookings.deliver_address as deliver_address',
                    'bookings.deliver_latitude as deliver_latitude',
                    'bookings.deliver_longitude as deliver_longitude',
                    'bookings.deliver_country as deliver_country',
                    'bookings.deliver_city as deliver_city',
                    'bookings.deliver_phone as deliver_phone',
                    'bookings.created_at as created_at',
                    'accepted_qoutes.status as quote_status',
                    )
            ->where('accepted_qoutes.driver_id',$user_id)
            ->where('accepted_qoutes.status','!=','delivered')
            ->orderBy('bookings.id','desc');

            if($limit !="") {
                $bookings->limit($limit)->skip($offset);
            }

            $bookings = $bookings->get()->map(function ($item) use($request) {
                
                 $item->quote_status_number = config('global.'.$item->quote_status);
                 $item->quote_status = driver_quote_status_name($item->quote_status);
                 $item->created_at = api_date_in_timezone($item->created_at, 'Y-m-d H:i:s', $request->timezone);
                 $item->created_at_format = api_date_in_timezone($item->created_at, 'd M Y', $request->timezone);
                return $item;
            });            

            $status = "1";
            $o_data['list'] = $bookings->toArray();
            $o_data = convert_all_elements_to_string($o_data);
        }
        
        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => $o_data], 200);
    }

    public function driver_completed_requests(Request $request){

        $status = "0";
        $message = "";
        $o_data = [];
        $errors = [];

        $limit = isset($request->limit) ? $request->limit : 10;
        $offset = isset($request->page) ? ($request->page - 1) * $request->limit : 0;
       
        $validator = Validator::make($request->all(), [
            'access_token'           => 'required',
            'timezone'               => 'required'
        ]);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        } else {
            
            $user_id = $this->validateAccesToken($request->access_token);
            $bookings = Booking::join('accepted_qoutes','bookings.id','=','accepted_qoutes.booking_id')
            ->select('bookings.id as id',
                    'bookings.booking_number as booking_number',
                    'bookings.collection_address as collection_address',
                    'bookings.collection_latitude as collection_latitude',
                    'bookings.collection_longitude as collection_longitude',
                    'bookings.collection_country as collection_country',
                    'bookings.collection_city as collection_city',
                    'bookings.collection_phone as collection_phone',
                    'bookings.deliver_address as deliver_address',
                    'bookings.deliver_latitude as deliver_latitude',
                    'bookings.deliver_longitude as deliver_longitude',
                    'bookings.deliver_country as deliver_country',
                    'bookings.deliver_city as deliver_city',
                    'bookings.deliver_phone as deliver_phone',
                    'bookings.created_at as created_at',
                    'accepted_qoutes.status as quote_status',
                    )
            ->where('accepted_qoutes.driver_id',$user_id)
            ->where('accepted_qoutes.status','delivered')
            ->orderBy('bookings.id','desc');

            if($limit !="") {
                $bookings->limit($limit)->skip($offset);
            }

            $bookings = $bookings->get()->map(function ($item) use($request) {
                
                 $item->quote_status_number = config('global.'.$item->quote_status);
                 $item->quote_status = driver_quote_status_name($item->quote_status);
                 $item->created_at = api_date_in_timezone($item->created_at, 'Y-m-d H:i:s', $request->timezone);
                 $item->created_at_format = api_date_in_timezone($item->created_at, 'd M Y', $request->timezone);
                return $item;
            });            

            $status = "1";
            $o_data['list'] = $bookings->toArray();
            $o_data = convert_all_elements_to_string($o_data);
        }
        
        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => $o_data], 200);
    }

    public function driver_request_detail(Request $request){

        $status = "0";
        $message = "";
        $o_data = [];
        $errors = [];
       
        $validator = Validator::make($request->all(), [
            'access_token'           => 'required',
            'timezone'               => 'required',
            'booking_id'             => 'required'   
        ]);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        } else {
            
            $user_id = $this->validateAccesToken($request->access_token);
            $booking_qoute = BookingQoute::where('booking_id',$request->booking_id)->where('driver_id',$user_id)->first();
                
            if(empty($booking_qoute)){
                return response()->json([
                    'status' => "0",
                    'error' => (object) array(),
                    'message' => 'No any request found',
                ], 200);                
            }

            if(isset($booking_qoute->status) && $booking_qoute->status == 'accepted'){

                $booking = Booking::join('accepted_qoutes','bookings.id','=','accepted_qoutes.booking_id')
                ->select('bookings.id as id',
                        'bookings.booking_number as booking_number',
                        'bookings.sender_id as sender_id',
                        'bookings.collection_address as collection_address',
                        'bookings.collection_latitude as collection_latitude',
                        'bookings.collection_longitude as collection_longitude',
                        'bookings.collection_country as collection_country',
                        'bookings.collection_city as collection_city',
                        'bookings.collection_phone as collection_phone',
                        'bookings.deliver_address as deliver_address',
                        'bookings.deliver_latitude as deliver_latitude',
                        'bookings.deliver_longitude as deliver_longitude',
                        'bookings.deliver_country as deliver_country',
                        'bookings.deliver_city as deliver_city',
                        'bookings.deliver_phone as deliver_phone',
                        'bookings.created_at as created_at', 
                        'accepted_qoutes.status as quote_status',
                        'accepted_qoutes.qouted_amount as quoted_amount',
                        'accepted_qoutes.hours as hours',
                        'accepted_qoutes.booking_truck_id as booking_truck_id',
                        )
                ->where('bookings.id',$request->booking_id)       
                ->where('accepted_qoutes.driver_id',$user_id)
                ->first();

            }else{
                
                $booking = Booking::join('booking_qoutes','bookings.id','=','booking_qoutes.booking_id')
                ->select('bookings.id as id',
                        'bookings.booking_number as booking_number',
                        'bookings.sender_id as sender_id',
                        'bookings.collection_address as collection_address',
                        'bookings.collection_latitude as collection_latitude',
                        'bookings.collection_longitude as collection_longitude',
                        'bookings.collection_country as collection_country',
                        'bookings.collection_city as collection_city',
                        'bookings.collection_phone as collection_phone',
                        'bookings.deliver_address as deliver_address',
                        'bookings.deliver_latitude as deliver_latitude',
                        'bookings.deliver_longitude as deliver_longitude',
                        'bookings.deliver_country as deliver_country',
                        'bookings.deliver_city as deliver_city',
                        'bookings.deliver_phone as deliver_phone',
                        'bookings.created_at as created_at',
                        'booking_qoutes.status as quote_status',
                        'booking_qoutes.price as quoted_amount',
                        'booking_qoutes.hours as hours',
                        'booking_qoutes.booking_truck_id as booking_truck_id',
                        )
                ->where('bookings.id',$request->booking_id)
                ->where('booking_qoutes.driver_id',$user_id)
                ->first();    
            }
            
            $data = [];

            if(!empty($booking)){
                
                $data['quote_section'] = '0';
                $data['customer_detail_section'] = '0';
                $data['booking_truck_section'] = '0';
                //$data['booking_reviews_section'] = '0';
                
                $data['booking_id'] = $booking->id;
                $data['booking_number'] = $booking->booking_number;
                $data['created_at'] = api_date_in_timezone($booking->created_at, 'Y-m-d H:i:s', $request->timezone);
                $data['created_at_format'] = api_date_in_timezone($booking->created_at, 'd M Y', $request->timezone);
                $data['default_currency_code'] = config('global.default_currency_code');
                $data['allow_place_quote'] = ($booking->quote_status == 'pending')?'1':'0';

                if($booking->quote_status == 'pending' || $booking->quote_status == 'qouted'){
                    $data['current_status_number'] = config('global.'.$booking->quote_status);
                    $data['current_status'] = driver_quote_status_name($booking->quote_status);

                    $data['next_status_number'] = '';
                    $data['next_status'] = '';

                }else{

                    $data['current_status_number'] = config('global.'.$booking->quote_status);
                    $data['current_status'] = driver_quote_status_name($booking->quote_status);

                    $data['next_status_number'] = config('global.'.next_status($booking->quote_status));
                    $data['next_status'] = driver_quote_status_name(next_status($booking->quote_status));

                }
                
                $collection_address = [
                    'address' => $booking->collection_address ?? '',
                    'latitude' => $booking->collection_latitude ?? '',
                    'longitude' => $booking->collection_longitude ?? '',
                    'country' => $booking->collection_country ?? '',
                    'city' => $booking->collection_city ?? '',
                    'phone' => $booking->collection_phone ?? '',
                ];
                
                $deliver_address = [
                    'address' => $booking->deliver_address ?? '',
                    'latitude' => $booking->deliver_latitude ?? '',
                    'longitude' => $booking->deliver_longitude ?? '',
                    'country' => $booking->deliver_country ?? '',
                    'city' => $booking->deliver_city ?? '',
                    'phone' => $booking->deliver_phone ?? '',
                ];

                $data['collection_address'] = $collection_address;
                $data['deliver_address'] = $deliver_address;                
                
                $booking_truck = BookingTruck::find($booking->booking_truck_id);
                
                if(!empty($booking_truck) > 0){                  
                                        
                    $data['truck_detail'] = [
                        'truck_id' => $booking_truck->truck_id,
                        'truck'    => $booking_truck->truck_type->truck_type,
                        'weight'   => $booking_truck->gross_weight,
                        'quantity'   => $booking_truck->quantity,
                        'dimensions'   => $booking_truck->truck_type->dimensions,
                        'icon'      => $booking_truck->truck_type->icon,
                    ];                                               

                    $data['booking_truck_section'] = '1';

                }

                if(!empty($booking->customer)){                  
                                        
                    $data['customer_detail'] = [
                        'customer_id' => $booking->customer->id,
                        'name'    => $booking->customer->name,
                        'email'    => $booking->customer->email,
                        'phone'   => '+'.$booking->customer->dial_code." ".$booking->customer->phone,
                        'profile_image'      => $booking->customer->profile_image,
                    ];                                               

                    $data['customer_detail_section'] = '1';
                }

                if($booking->quote_status != 'pending'){                  
                                        
                    $data['quote_detail'] = [
                        'quoted_amount' => $booking->quoted_amount,
                        'hours'    => $booking->hours." "."Hours",
                    ];                                               

                    $data['quote_section'] = '1';
                }

                $status = "1";
                $o_data['request_detail'] = $data;
                $o_data = convert_all_elements_to_string($o_data);

            }else{
                $status = "0";
                $message = 'No any Request Found';
                $o_data = convert_all_elements_to_string($o_data);
            }

        }    

        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => $o_data], 200);
    }

    public function driver_submit_quote(Request $request){
                    
        $status = "0";
        $message = "";
        $o_data = [];
        $errors = [];
       
        $validator = Validator::make($request->all(), [
            'access_token'           => 'required',
            'booking_id'             => 'required|numeric',
            'price'                  => 'required|numeric',
            'hours'                  => 'required'         
        ]);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        } else {
            
            $user_id = $this->validateAccesToken($request->access_token);
            
            $booking = Booking::find($request->booking_id);
            
            if(empty($booking)){
                return response()->json([
                    'status' => "0",
                    'error' => (object) array(),
                    'message' => 'No any request found',
                ], 200);                    
            }

            $bool = BookingQoute::where('booking_id',$request->booking_id)
                    ->where('driver_id',$user_id)->where('status','pending')->update([
                        'price' => $request->price,
                        'hours' => $request->hours,
                        'status' => 'qouted',
                        'statuscode' => config('global.qouted'),
                        'qouted_at' => gmdate('Y-m-d H:i:s')
                    ]);
            
            $booking->admin_response = 'driver_qouted';
            $booking->save();        
            
            if($bool){

                $booking_qoute = BookingQoute::where('booking_id',$request->booking_id)
                    ->where('driver_id',$user_id)->where('status','qouted')->first();
                        
                //Driver Quote Submit Notification
                // if (config('global.server_mode') == 'local') {
                //     \Artisan::call('driver_submit_qoute:driver ' . $booking_qoute->id);
                // } else { 
                    exec("php " . base_path() . "/artisan driver_submit_qoute:driver " . $booking_qoute->id . " > /dev/null 2>&1 & ");
                //}    

                $data['booking'] = $booking;
                $data['driver'] = User::find($user_id);
                if(env('MAILS_ENABLE')){
                    Mail::to(env('Admin_Email'))->send(new DriverSubmitMail($data));
                }

                $status = "1";
                $message = "Quote submitted successfully";
            }else{
                $status = "1";
                $message = "Quote could not submitted";
            }
        
        }    

        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => $o_data], 200);
    }

    public function change_request_status(Request $request){
        
        $status = "0";
        $message = "";
        $o_data = [];
        $errors = [];

        $validator = Validator::make($request->all(), [
            'access_token'           => 'required',
            'booking_id'             => 'required|numeric',
            'status'                  => 'required|numeric|in:2,4,5,6,7,8,9', 
        ]);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        } else {
            
            $user_id = $this->validateAccesToken($request->access_token);
            
            $booking = Booking::find($request->booking_id);
            
            if(empty($booking)){
                return response()->json([
                    'status' => "0",
                    'error' => (object) array(),
                    'message' => 'No any request found',
                ], 200);                    
            }


            if(config('global.qoute_status_names.'.$request->status) != null){
                $bool = AcceptedQoute::where('booking_id',$request->booking_id)
                ->where('driver_id',$user_id)->update([
                    'status' => config('global.qoute_status_names.'.$request->status),
                    'statuscode' => $request->status,
                ]);
                
                if($request->status == 9 && $bool){
                   $total_count = AcceptedQoute::where('booking_id',$request->booking_id)->count();
                   $delivered_count = AcceptedQoute::where('booking_id',$request->booking_id)->where('status','delivered')->count();
                   
                   if($total_count === $delivered_count){
                        
                        Booking::where('id',$request->booking_id)->update(['status' => 'completed','statuscode'=>config('global.completed')]);
                      
                        // if (config('global.server_mode') == 'local') {
                        //     \Artisan::call('user_booking:user ' . $request->booking_id);
                        // } else { 
                            exec("php " . base_path() . "/artisan user_booking:user " . $request->booking_id . " > /dev/null 2>&1 & ");
                       // }

                   } 
                }    

                if($bool){
                
                    $qoute = AcceptedQoute::where('booking_id',$request->booking_id)
                        ->where('driver_id',$user_id)->first();

                    // if (config('global.server_mode') == 'local') {
                    //     \Artisan::call('driver_request_change_status:driver ' . $qoute->id);
                    // } else { 
                        exec("php " . base_path() . "/artisan driver_request_change_status:driver " . $qoute->id . " > /dev/null 2>&1 & ");
                    //}

                    // if (config('global.server_mode') == 'local') {
                    //     \Artisan::call('customer_request_change_status:customer ' . $qoute->id);
                    // } else { 
                        exec("php " . base_path() . "/artisan customer_request_change_status:customer " . $qoute->id . " > /dev/null 2>&1 & ");
                    //}

                    if(config('global.qoute_status_names.'.$request->status) != null){
                        DB::table('booking_status_trackings')->updateOrInsert(
                            [
                                'booking_id' => $booking->id,
                                'driver_id'  => $qoute->driver_id,
                                'status_tracking' => config('global.qoute_status_names.'.$request->status),
                            ],
                            [
                                'status_tracking' => config('global.qoute_status_names.'.$request->status),
                                 'statuscode' => $request->status,
                                 'quote_id'=>$qoute->id,
                                'created_at' => gmdate('Y-m-d H:i:s'),
                                'updated_at' => gmdate('Y-m-d H:i:s'),
                            ]
                        );
                    }

                    $status = "1";
                    $message = "Status changed successfully";

                }else{
                    $status = "0";
                    $message = "Status could not be changed";
                }

                                 
            }
            else{
                $status = "0";
                $message = "Status could not be changed";
            }
            

        } 
            return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => $o_data], 200);               
    }

    public function deliver_now(Request $request){
        
        $status = "0";
        $message = "";
        $o_data = [];
        $errors = [];

        $validator = Validator::make($request->all(), [
            'access_token'           => 'required',
            'booking_id'             => 'required|numeric',
            'signature'              => 'required',
            'delivery_note'          => 'required', 
            'quote_id'                =>''
        ]);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        } else {
            
            $user_id = $this->validateAccesToken($request->access_token);
            $request->status = 9;
            $booking = Booking::find($request->booking_id);
            
            if(empty($booking)){
                return response()->json([
                    'status' => "0",
                    'error' => (object) array(),
                    'message' => 'No any request found',
                ], 200);                    
            }
            
                      
                        

            $qoute = AcceptedQoute::where('booking_id',$request->booking_id)
                        ->where('driver_id',$user_id);  
            if(isset($request->quote_id)) {
                $qoute =  $qoute->where('id',$request->quote_id); 
            }      
            $qoute =  $qoute->first();     

            if(!empty($qoute)){
               
                $qoute->delivery_note = $request->delivery_note;
                if($request->file("signature") != null){
                    $response = image_upload($request,'bookings','signature');
                    
                    if($response['status']){
                        $qoute->customer_signature = $response['link'];                        
                    }
                }
                $qoute->status = 'delivered';
                $qoute->statuscode = config('global.delivered');
                $qoute->save();

                $checkPending = AcceptedQoute::where('booking_id',$request->booking_id)->where('statuscode','!=',config('global.delivered'))->get()->first();
                $totalBooked = \App\Models\BookingTruck::where('booking_id',$request->booking_id)->count();
                $approved = AcceptedQoute::where('booking_id',$request->booking_id)->count();
                if($checkPending == null && $totalBooked <= $approved ) {
                    $booking->status = 'completed';
                    $booking->statuscode = config('global.completed');
                    $booking->save();
                    $bool = AcceptedQoute::where('booking_id',$request->booking_id)
                        ->where('driver_id',$user_id)->update([
                            'status' =>'delivered',
                            'statuscode' => 9,
                        ]);
                }
                


                 DB::table('booking_status_trackings')->updateOrInsert(
                            [
                                'booking_id' => $booking->id,
                                'driver_id'  => $qoute->driver_id,
                                'status_tracking' => config('global.qoute_status_names.'.$request->status),
                            ],
                            [
                                'status_tracking' => config('global.qoute_status_names.'.$request->status),
                                 'statuscode' => config('global.delivered'),
                                    'quote_id'=>$qoute->id,
                                'created_at' => gmdate('Y-m-d H:i:s'),
                                'updated_at' => gmdate('Y-m-d H:i:s'),
                            ]
                        );
                // if (config('global.server_mode') == 'local') {
                //     \Artisan::call('user_booking:user ' . $request->booking_id);
                // } else { 
                    exec("php " . base_path() . "/artisan user_booking:user " . $request->booking_id . " > /dev/null 2>&1 & ");
                //}
                $status = "1";
                $message = "Booking delivered successfully";

            }else{
                $status = "0";
                $message = "Request is not delivered yet";
            }
        }

        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => $o_data], 200);
    }

    public function driver_update_profile(Request $request)
    {
        $status   = "0";
        $message  = "";
        $o_data   = [];
        $errors   = [];

        $user_id = $this->validateAccesToken($request->access_token);

        $rules= [
            'name'              => 'required',
           
            'dial_code'         => 'required',
            'phone'             => 'required|unique:users,phone,'.$user_id,
            'country_id'        => '',
            'city_id'           => '',
            'zip_code'          => '',
            'address'           => 'required',
            'location'          => '',
            'latitude'          => 'required',
            'longitude'         => 'required',
            'trade_licence_number' => '',
            'trade_licence_doc'    => '',
            'access_token'      => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        } else {

            $country = \App\Models\Country::where('country_id',$request->country_id)->first();
            $city = \App\Models\City::find($request->city_id);
    
            $customer   = User::find($user_id);
            $customer->name    = $request->name;
           
            $customer->address_2 = $request->address;
           
            $customer->latitude = $request->latitude;
            $customer->longitude = $request->longitude;

            //$customer->trade_licence_number = $request->trade_licence_number;
            $customer->updated_at  = gmdate('Y-m-d H:i:s');
            $customer->save();
            if($request->file("trade_licence_doc") != null){
                $response = image_upload($request,'users','trade_licence_doc');
                
                if($response['status']){
                    $customer->trade_licence_doc = $response['link'];
                    $customer->save();
                }
            }
            if(!empty($customer)){
                if($request->file("profile_image") != null){
                    $response = image_upload($request,'users','profile_image');
                    
                    if($response['status']){
                        $customer->profile_image = $response['link'];
                        $customer->save();
                    }
                }

                $status = "1";
                $message = "Profile updated successfully";
            }else{
                $status = "0";
                $message = "Profile could not updated";
            }

        }

        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => $o_data], 200);
    }
    public function driver_edit_profile(Request $request){
        
        $status = "0";
        $message = "";
        $o_data = [];
        $errors = [];
        $user_id = $this->validateAccesToken($request->access_token);
        $validator = Validator::make($request->all(), [
            'access_token' => 'required',
        ]);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        } else {
            $user = User::find($user_id);
            if(!empty($user)){
                $data = [];
                $data = [
                    'name' => $user->name,
                    'email' => $user->email,
                    'dial_code' => $user->dial_code,
                    'dial_code_display' => '+'.$user->dial_code,
                    'phone' => $user->phone,
                    'country' => $user->country,
                    'country_id' =>$user->country_id,
                    'city_id' => $user->city_id,
                    'city' => $user->city,
                    'zip_code' => $user->zip_code,
                    'address' => $user->address_2,
                    'location' => $user->address,
                    'profile_image' => $user->profile_image,
                    'latitude' => $user->latitude,
                    'longitude' => $user->longitude,
                    'trade_licence_number' => $user->trade_licence_number,
                    'trade_licence_doc' => $user->trade_licence_doc,

                ];     
                $status = "1";
                $message = "success";
                $o_data['user'] = $data;
            }else{
                $status = "0";
                $message = "Not Found Any User";
            }
        }

        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => $o_data], 200);

    }

    public function addAdvanceAmount(Request $request)
    {
        
        $status = "0";
        $message = "";
        $o_data = [];
        $errors = [];
        $user_id = $this->validateAccesToken($request->access_token);
        $validator = Validator::make($request->all(), [
            'access_token' => 'required',
            'quote_id' => 'required',
            'advance_amount' => 'required',
        ]);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        } else {
            $user = User::find($user_id);
            
        }
    }


}    
