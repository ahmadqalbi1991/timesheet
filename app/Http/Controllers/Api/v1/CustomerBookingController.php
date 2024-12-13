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
use Validator;
use DB;
class CustomerBookingController extends Controller
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

    public function customer_requests(Request $request){

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
            $bookings = Booking::where('sender_id',$user_id)
                        ->select('bookings.id as id','bookings.booking_number as booking_number',
                        'bookings.status as booking_status','bookings.created_at as created_at',
                        'bookings.deligate_id','bookings.deligate_type')
                        ->addSelect(['deligate_name' => Deligate::select('name')
                        ->whereColumn('bookings.deligate_id', 'deligates.id')
                        ->limit(1)])
                        ->orderBy('bookings.id','desc');

            if($limit !="") {
                $bookings->limit($limit)->skip($offset);
            }

            $bookings = $bookings->get();
            // ->map(function ($item) use($request) {
            //     if($item->deligate_id == 1 || $item->deligate_id == 3){
            //         $item->deligate_name = $item->deligate_name." - ".strtoupper($item->deligate_type);   
            //     }
            //      $item->booking_status_number = config('global.'.$item->booking_status);
            //      $item->booking_status = booking_status_name($item->booking_status);
            //      $item->created_at_new = api_date_in_timezone($item->created_at, 'Y-m-d H:i:s', $request->timezone);
            //      $created_at_new = $item->created_at;
            //      unset($item->created_at);
            //      $item->created_at = api_date_in_timezone($created_at_new, 'Y-m-d H:i:s', $request->timezone);
            //      $item->created_at_format = api_date_in_timezone($item->created_at, 'd M Y', $request->timezone);
            //     return $item;
            // });   
            $newbookings = [];
            foreach($bookings as $item)
            {
                if($item->deligate_id == 1 || $item->deligate_id == 3){
                    $item->deligate_name = $item->deligate_name." - ".strtoupper($item->deligate_type);   
                }
                 $item->booking_status_number = config('global.'.$item->booking_status);
                 $item->booking_status = booking_status_name($item->booking_status);
                 $item->created_at_new = api_date_in_timezone($item->created_at, 'Y-m-d H:i:s', $request->timezone);
                 $created_at_new = $item->created_at;
                 unset($item->created_at);
                 $item->created_at = api_date_in_timezone($created_at_new, 'Y-m-d H:i:s', $request->timezone);
                 $item->created_at_format = api_date_in_timezone($item->created_at, 'd M Y', $request->timezone);
                 $newbookings[] = $item;
            }        

            $status = "1";
            $o_data['list'] = $newbookings;
            $o_data = convert_all_elements_to_string($o_data);
        }
        
        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => $o_data], 200);
    }

    public function customer_request_detail(Request $request){

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
            $booking = Booking::where('sender_id',$user_id)
                                ->where('id',$request->booking_id)
                                ->select('bookings.id as id',
                                    'bookings.booking_number as booking_number',
                                    'bookings.is_collection as is_collection',
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
                                    'bookings.status as booking_status',
                                    'bookings.created_at as created_at',
                                    'bookings.deligate_id',
                                    'bookings.admin_can_accept_quote',
                                    'bookings.shipmenttype',
                                    'bookings.shipping_method_id',
                                    'bookings.rack',
                                    'bookings.storage_picture',
                                    'bookings.date_of_commencement',
                                    'bookings.date_of_return',
                                    'bookings.instructions',
                                    'bookings.deligate_type')
                            ->addSelect(['deligate_name' => Deligate::select('name')
                            ->whereColumn('bookings.deligate_id', 'deligates.id')
                            ->limit(1)])
                            ->first();

            $data = [];

            if(!empty($booking)){
                
                $data['received_qoutes_section'] = '0';
                $data['accepted_quotes_section'] = '0';
                $data['booking_trucks_section'] = '0';
                $data['driver_section'] = '0';
                $data['booking_reviews_section'] = '0';
                

                if($booking->deligate_id == 1 || $booking->deligate_id == 3){
                    $data['deligate_name'] = $booking->deligate_name." - ".strtoupper($booking->deligate_type);   
                }else{
                    $data['deligate_name'] = $booking->deligate_name;
                }

                $data['rack'] = $booking->rack;
                $data['storage_picture'] = $booking->storage_picture;
                $data['shipmenttype'] = (int)$booking->shipping_method_id;
                //$shipmenttype = config('global.shipmenttype');
                if($booking->shipping_method_id > 0 )
                    $data['shipmenttype_name'] =  \App\Models\ShippingMethod::where('id',$booking->shipping_method_id)->first()->name;
                else
                    $data['shipmenttype_name'] = "";
                $data['date_of_commencement'] = $booking->date_of_commencement;
                $data['date_of_return'] = $booking->date_of_return;
                $data['instructions'] = $booking->instructions;
                $data['admin_can_accept_quote'] = $booking->admin_can_accept_quote;
                $data['deligate_id'] = $booking->deligate_id;
                $data['deligate_type'] = $booking->deligate_type;
                $data['booking_id'] = $booking->id;
                $data['booking_number'] = $booking->booking_number;
                $data['booking_status_number'] = config('global.'.$booking->booking_status);
                $data['booking_status'] = booking_status_name($booking->booking_status);
                $data['created_at'] = api_date_in_timezone($booking->created_at, 'Y-m-d H:i:s', $request->timezone);
                $data['created_at_format'] = api_date_in_timezone($booking->created_at, 'd M Y', $request->timezone);
                $data['default_currency_code'] = config('global.default_currency_code');
                $data['is_allow_review'] = (empty($booking->reviews) && $booking->booking_status == 'completed')?'1':'0';
                
                //booking reviews
                if(!empty($booking->reviews)){
                    $data['booking_reviews_section'] = '1';
                    $data['booking_reviews'] = [
                        'ratings' => floor($booking->reviews->rate * 10) / 10,
                        'reviews' => $booking->reviews->comment,
                        'submitted_at' => api_date_in_timezone($booking->reviews->created_at, 'd M Y', $request->timezone)
                    ];
                }
    
                if($booking->deligate_id == 1 || $booking->deligate_id == 2 || $booking->deligate_id == 4 || $booking->deligate_id == 3){
                    
                    // LTL Details Or Air Freight
                    if($booking->deligate_id == 2 || (($booking->deligate_id == 1 || $booking->deligate_id == 3) && $booking->deligate_type == 'ltl')){
                    
                        $deligate_detail = [
                            'item'                       => $booking->booking_deligate_detail->item ?? '',
                            'no_of_packages'             => $booking->booking_deligate_detail->no_of_packages ?? '',
                            'dimension_of_each_package'  => $booking->booking_deligate_detail->dimension_of_each_package ?? '',
                            'weight_of_each_package'     => $booking->booking_deligate_detail->weight_of_each_package ?? '',
                            'total_gross_weight'         => $booking->booking_deligate_detail->total_gross_weight ?? '',
                            'total_volume_in_cbm'        => $booking->booking_deligate_detail->total_volume_in_cbm ?? '',
                            'num_of_pallets'             => $booking->booking_deligate_detail->num_of_pallets ?? '',
                        ];

                        $data = array_merge($data,$deligate_detail);
    
                    }

                    if($booking->deligate_type == 'lcl'){
                    
                        $deligate_detail = [
                            'item'                       => $booking->booking_deligate_detail->item ?? '',
                            'no_of_packages'             => $booking->booking_deligate_detail->no_of_packages ?? '',
                            'dimension_of_each_package'  => $booking->booking_deligate_detail->dimension_of_each_package ?? '',
                            'weight_of_each_package'     => $booking->booking_deligate_detail->weight_of_each_package ?? '',
                            'total_gross_weight'         => $booking->booking_deligate_detail->total_gross_weight ?? '',
                            'total_volume_in_cbm'        => $booking->booking_deligate_detail->total_volume_in_cbm ?? ''
                        ];

                        $data = array_merge($data,$deligate_detail);
    
                    }
                    
                    // Warehousing

                    
                    if($booking->deligate_id == 4){
                        
                        $data['is_collection'] = $booking->is_collection;
                        
                        $deligate_details = [
                            'type_of_storage'            => $booking->warehouse_detail->storage_type->name,
                            'item'                       => $booking->warehouse_detail->item,
                            'items_are_stockable'        => ucfirst($booking->warehouse_detail->items_are_stockable),
                            'no_of_pallets'              => $booking->warehouse_detail->no_of_pallets,
                            'pallet_dimension'           => $booking->warehouse_detail->pallet_dimension,
                            'weight_per_pallet'          => $booking->warehouse_detail->weight_per_pallet,
                            'total_weight'               => $booking->warehouse_detail->total_weight,
                            'total_item_cost'            => $booking->warehouse_detail->total_item_cost
                        ];

                        $data = array_merge($data,$deligate_details);
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

                    if($booking->is_collection == 1){
                        $data['collection_address'] = $collection_address;
                    }
                    if($booking->deligate_id != 4){
                        $data['deliver_address'] = $deliver_address;
                    }    
                    
                    $booking_qoutes = BookingQoute::with('booking_truck.truck_type')
                    ->where('booking_id',$booking->id)->where('is_admin_approved','yes')->orderBy('price','ASC')->get();
                    $data['received_qoutes_count'] = $booking_qoutes->count();
                    
                    //received qouted
                    if($booking_qoutes->count() > 0){
                        $booking_qoutes = $booking_qoutes->map(function ($item) use($request) {                        
                            
                            $item->qouted_at = api_date_in_timezone($item->qouted_at, 'd M Y h:i A', $request->timezone);
                                                    
                            return [
                                'qoute_id' => $item->id,
                                'qoute_by' => $item->driver->name,
                                'truck'    => $item->booking_truck->truck_type->truck_type??'',
                                'truck_quantity' => $item->booking_truck->quantity??'',
                                'qoute_status_number'=> config('global.'.$item->status),
                                'status'        => qoute_status_name($item->status),
                                'qouted_at' => $item->qouted_at,
                                'qouted_amount'     => price_with_commission($item),
                                //'sub_total' => ($item->booking_truck->quantity * $item->price)
                            ];

                        });            
                        
                        $data['received_qoutes_section'] = '1';
                        $data['received_qoutes'] = $booking_qoutes->toArray();
                    }

                    $accepted_qoute_list = AcceptedQoute::with('booking_truck.truck_type')->where('booking_id',$booking->id)->orderBy('id','ASC')->get();
                    $data['accepted_qoutes_count'] = $accepted_qoute_list->count();
                    
                    //accepted qoutes
                    if($accepted_qoute_list->count() > 0){
                        $accepted_qoutes = $accepted_qoute_list->map(function ($item) use($request) {                        
                            
                            $delivery_date = strtotime($item->created_at. "+".$item->hours."hours");
                            $delivery_date = date('Y-m-d H:i:s',$delivery_date);
                            $delivery_date = api_date_in_timezone($delivery_date, 'd F Y', $request->timezone);
                           
                            return [
                                'qoute_id' => $item->id,
                                'qoute_by' => $item->driver->name,
                                'truck'    => $item->booking_truck->truck_type->truck_type??'',
                                'truck_quantity' => $item->booking_truck->quantity??'',
                                'qouted_amount'     => get_total_amount($item->qouted_amount,$item->commission_amount),
                                'delivery_date' => $delivery_date
                            ];

                        });            
                        $data['accepted_quotes_section'] = '1';
                        $data['accepted_quotes'] = $accepted_qoutes->toArray();
                    }

                    //drivers list
                    if($accepted_qoute_list->count() > 0){
                        $drivers = $accepted_qoute_list->map(function ($item) use($request,$user_id) {
                            if($item->driver->default_iso_code =="") {
                                $item->driver->default_iso_code = "AE";
                            } 

                            $country = \App\Models\Country::where('iso_code',$item->driver->default_iso_code)->first();  
                            $mobile = $item->driver->dial_code.$item->driver->phone;
                            if($country->dial_code == $item->driver->dial_code )  {
                                $mobile = $item->driver->dial_code.$item->driver->phone;
                            }  else {  
                                $phoneDetails= \App\Models\UserAdditionalPhone::where('user_additional_phone.user_id',$item->driver->id)            
                                ->where('dial_code',$country->dial_code)
                                ->get(['id','mobile','dial_code'])->first();    
                                if($phoneDetails !=null) {  
                                    $mobile = $phoneDetails->dial_code.$phoneDetails->mobile;
                                }

                            }                           
                            
                            if($item->driver->role_id == 1){
                                $mobile = str_replace(' ', '', (\App\Models\Settings::first()->contact_number ?? ''));
                            }
                            return [
                                'qoute_id' => $item->id,
                                'driver_id' => $item->driver->id,
                                'driver' => $item->driver->name,
                                'driver_phone' => $mobile,
                                'profile_image' => $item->driver->profile_image,
                                'truck'    => $item->booking_truck->truck_type->truck_type ?? '',
                                'truck_status' => get_booking_truck_status_for_app($item->status),
                                'truck_status_number' => config('global.'.$item->status),
                            ];

                        });            
                        $data['driver_section'] = '1';
                        $data['drivers'] = $drivers->toArray();
                    }

                    //trucks list
                    $booking_trucks = BookingTruck::where('booking_id',$booking->id)->get();
                    $data['booking_trucks_count'] = $booking_trucks->count();
                    if(count($booking_trucks) > 0){                  
                        $booking_trucks = $booking_trucks->map(function ($item) use($request) {                        
                                                    
                            return [
                                'booking_truck_id' => $item->id,
                                'truck_id' => $item->truck_id,
                                'truck'    => isset($item->truck_type) ? $item->truck_type->truck_type :'',
                                'quantity'    => $item->quantity,
                                'weight'   => $item->gross_weight,
                                'icon'      => isset($item->truck_type) ?$item->truck_type->icon:'',
                            ];
    
                        });

                        $data['booking_trucks_section'] = '1';
                        $data['booking_trucks'] = $booking_trucks->toArray();
                    }
                                        
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

    public function customer_accept_quote(Request $request){
    
        $status = "0";
        $message = "";
        $o_data = [];
        $errors = [];
       
        $validator = Validator::make($request->all(), [
            'access_token'           => 'required',
            'quote_id'             => 'required'   
        ]);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        } else {
            
            $user_id = $this->validateAccesToken($request->access_token);
            $booking_qoute = BookingQoute::where('id',$request->quote_id)->where('status','qouted')->first();
            
            if(!empty($booking_qoute)){
                $booking_qoute->status = "accepted";
                $booking_qoute->statuscode = config('global.accepted');
                $booking_qoute->save();

                $accepted_qoute = new AcceptedQoute();
                $accepted_qoute->booking_id = $booking_qoute->booking_id;
                $accepted_qoute->driver_id = $booking_qoute->driver_id;
                $accepted_qoute->qouted_amount = $booking_qoute->price;
                $accepted_qoute->status = $booking_qoute->status;
                $accepted_qoute->hours = $booking_qoute->hours;
                $accepted_qoute->commission_amount = $booking_qoute->comission_amount;
                $accepted_qoute->booking_truck_id = $booking_qoute->booking_truck_id;
                $accepted_qoute->total_amount = $accepted_qoute->qouted_amount + (get_total_amount($accepted_qoute->qouted_amount,$accepted_qoute->comission_amount));
                $accepted_qoute->created_at = time_to_uae(gmdate('Y-m-d H:i:s'));
                $accepted_qoute->updated_at = time_to_uae(gmdate('Y-m-d H:i:s'));
                $accepted_qoute->save();
                
                $booking = Booking::find($booking_qoute->booking_id);


                if($booking->status == 'pending'){
                    $status_booking = 'request_created';
                }
                else{
                    $status_booking = $booking->status;
                }
                

                DB::table('booking_status_trackings')->updateOrInsert(
                    [
                        'booking_id' => $booking->id,
                        'driver_id'  => $accepted_qoute->driver_id,
                        'status_tracking' => 'request_created',
                    ],
                    [
                        'status_tracking' => 'request_created',
                        'statuscode' => 0,
                        'quote_id'=>$accepted_qoute->id,
                        'created_at' => $booking->created_at,
                        'updated_at' => $booking->created_at,
                    ]
                );
                
                DB::table('booking_status_trackings')->updateOrInsert(
                    [
                        'booking_id' => $booking->id,
                        'driver_id'  => $accepted_qoute->driver_id,
                        'status_tracking' => 'accepted',
                    ],
                    [
                        'status_tracking' => 'accepted',
                        'statuscode' => config('global.accepted'),
                        'quote_id'=>$accepted_qoute->id,
                        'created_at' => $accepted_qoute->created_at,
                        'updated_at' => $booking->created_at,
                    ]
                );
                
            
                Booking::where('id',$booking_qoute->booking_id)->update(['status' => 'on_process','statuscode'=>config('global.on_process')]);
                do_booking_totals($booking_qoute->booking_id);

                try{
                    //Booking Notification
                    // if (config('global.server_mode') == 'local') {
                    //     \Artisan::call('user_booking:user ' . $booking_qoute->booking_id);
                    // } else { 
                        exec("php " . base_path() . "/artisan user_booking:user " . $booking_qoute->booking_id . " > /dev/null 2>&1 & ");
                    //}

                    //Customer Qoute Accept Notification
                    // if (config('global.server_mode') == 'local') {
                    //     \Artisan::call('customer_quote_accepted:customer ' . $accepted_qoute->id);
                    // } else { 
                        exec("php " . base_path() . "/artisan customer_quote_accepted:customer " . $accepted_qoute->id . " > /dev/null 2>&1 & ");
                   // }

                    //Driver Qoute Accept Notification
                    // if (config('global.server_mode') == 'local') {
                    //     \Artisan::call('driver_quote_accepted:driver ' . $accepted_qoute->id);

                    // } else { 
                        exec("php " . base_path() . "/artisan driver_quote_accepted:driver " . $accepted_qoute->id . " > /dev/null 2>&1 & ");
                    //}
                }
                catch (\Exception $e) {
                    // Ignoring the exception without any specific action
                }


                $status = "1";
                $message = "Quote has been Accepted";
                $o_data = convert_all_elements_to_string($o_data);
            }else{
                $status = "0";
                $message = "Quote could not Accepted";
                $o_data = convert_all_elements_to_string($o_data);
            }
        }
        
        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => $o_data], 200);
    }

    public function customer_submit_review(Request $request){
        
        $status = "0";
        $message = "";
        $o_data = [];
        $errors = [];
       
        $validator = Validator::make($request->all(), [
            'access_token'           => 'required',
            'booking_id'             => 'required',
            'ratings'                => 'required|numeric|min:1|max:5',
            'reviews'                => 'required',         
        ]);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        } else {
            
            $user_id = $this->validateAccesToken($request->access_token);
            $booking = Booking::find($request->booking_id);

            if(!empty($booking) && $booking->status != 'completed'){
                return response()->json([
                    'status' => "0",
                    'error' => (object) array(),
                    'message' => 'Sorry the Booking is not completed right now',
                ], 200);

            }

            if(empty($booking->reviews)){
                $review = new booking_reviews();
                $review->booking_id = $request->booking_id;
                $review->customer_id = $user_id;
                $review->rate = $request->ratings;
                $review->comment = $request->reviews;
                $review->status = 'pending';
                $review->created_at = date('Y-m-d H:i:s');
                $review->updated_at = date('Y-m-d H:i:s');
                $review->save();
                
                //Booking Review Submit Notification
                if (config('global.server_mode') == 'local') {
                    \Artisan::call('user_review:user ' . $review->booking_id);
                } else { 
                    exec("php " . base_path() . "/artisan user_review:user " . $review->booking_id . " > /dev/null 2>&1 & ");
                }
                
                $status = "1";
                $message = "Reviews has been submitted successfully";
            }else{
                $status = "0";
                $message = "Reviews already has been submitted";
            }
        }
        $o_data = convert_all_elements_to_string($o_data);        
        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => $o_data], 200);
    }

    public function customer_accept_all_quotes(Request $request){
        
        $status = "0";
        $message = "";
        $o_data = [];
        $errors = [];
       
        $validator = Validator::make($request->all(), [
            'access_token'           => 'required',
            'quote_ids'             => 'required'   
        ]);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        } else {

            $user_id = $this->validateAccesToken($request->access_token);
            
            if(isset($request->quote_ids) && count($request->quote_ids)> 0){
                foreach($request->quote_ids as $qoute_id){

                    $booking_qoute = BookingQoute::where('id',$qoute_id)->where('status','qouted')->first();
                    
                    if(!empty($booking_qoute)){
                        $booking_qoute->status = "accepted";
                        $booking_qoute->save();

                        $accepted_qoute = new AcceptedQoute();
                        $accepted_qoute->booking_id = $booking_qoute->booking_id;
                        $accepted_qoute->driver_id = $booking_qoute->driver_id;
                        $accepted_qoute->qouted_amount = $booking_qoute->price;
                        $accepted_qoute->status = $booking_qoute->status;
                        $accepted_qoute->hours = $booking_qoute->hours;
                        $accepted_qoute->commission_amount = $booking_qoute->comission_amount;
                        $accepted_qoute->booking_truck_id = $booking_qoute->booking_truck_id;
                        $accepted_qoute->total_amount = $accepted_qoute->qouted_amount + (get_total_amount($accepted_qoute->qouted_amount,$accepted_qoute->comission_amount));
                        $accepted_qoute->created_at = time_to_uae(gmdate('Y-m-d H:i:s'));
                        $accepted_qoute->updated_at = time_to_uae(gmdate('Y-m-d H:i:s'));
                        $accepted_qoute->save();
                        
                        $booking = Booking::find($booking_qoute->booking_id);
                        
                        DB::table('booking_status_trackings')->updateOrInsert(
                            [
                                'booking_id' => $booking->id,
                                'driver_id'  => $accepted_qoute->driver_id,
                                'status_tracking' => 'request_created',
                            ],
                            [
                                'status_tracking' => 'request_created',
                                 'statuscode' => 0,
                                 'quote_id'=>$accepted_qoute->id,
                                'created_at' => $booking->created_at,
                                'updated_at' => $booking->created_at,
                            ]
                        );
                        
                        DB::table('booking_status_trackings')->updateOrInsert(
                            [
                                'booking_id' => $booking->id,
                                'driver_id'  => $accepted_qoute->driver_id,
                                'status_tracking' => 'accepted',
                            ],
                            [
                                'status_tracking' => 'accepted',
                                 'statuscode' => config('global.accepted'),
                                 'quote_id'=>$accepted_qoute->id,
                                'created_at' => $accepted_qoute->created_at,
                                'updated_at' => $booking->created_at,
                            ]
                        );
                        
                        //Driver Qoute Accept Notification
                        // if (config('global.server_mode') == 'local') {
                        //     \Artisan::call('driver_quote_accepted:driver ' . $accepted_qoute->id);

                        // } else { 
                            exec("php " . base_path() . "/artisan driver_quote_accepted:driver " . $accepted_qoute->id . " > /dev/null 2>&1 & ");
                        //}

                        $status = "1";
                        $message = "Quote has been Accepted";

                    }else{
                        $status = "0";
                        $message = "Quote could not Accepted";

                    }

                }
            }

            if(isset($request->quote_ids[0])){

                $booking_qoute = BookingQoute::where('id',$request->quote_ids[0])->first();
                
                if(!empty($booking_qoute)){
                    Booking::where('id',$booking_qoute->booking_id)->update(['status' => 'on_process']);
                    do_booking_totals($booking_qoute->booking_id);

                    try{
                        //Booking Notification
                        // if (config('global.server_mode') == 'local') {
                        //     \Artisan::call('user_booking:user ' . $booking_qoute->booking_id);
                        // } else { 
                            exec("php " . base_path() . "/artisan user_booking:user " . $booking_qoute->booking_id . " > /dev/null 2>&1 & ");
                        //}
        
                        //Customer Qoute Accept Notification
                        // if (config('global.server_mode') == 'local') {
                        //     \Artisan::call('customer_quote_accepted:customer ' . $accepted_qoute->id);
                        // } else { 
                            exec("php " . base_path() . "/artisan customer_quote_accepted:customer " . $accepted_qoute->id . " > /dev/null 2>&1 & ");
                        //}
        
        
                    }
                    catch (\Exception $e) {
                        // Ignoring the exception without any specific action
                    }

                    $status = "1";
                    $message = "All Quotes have been Accepted";
                    $o_data = convert_all_elements_to_string($o_data);
                }

            }else{
                $status = "0";
                $message = "Quotes could not Accepted";
                $o_data = convert_all_elements_to_string($o_data);
            }

        }
        
      
        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => $o_data], 200);
    }

    public function customer_track_shipment(Request $request){
        
        $status = "0";
        $message = "";
        $o_data = [];
        $errors = [];
       
        $validator = Validator::make($request->all(), [
            'access_token'           => 'required',
            'booking_id'             => 'required',
            // 'driver_id'              => 'required',
            'timezone'              => 'required',   
        ]);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        } else {
            
            $user_id = $this->validateAccesToken($request->access_token);
            $status_tracking = BookingStatusTracking::where('booking_id',$request->booking_id)->when($request->driver_id,function($q) use($request) {
                return $q->where('driver_id',$request->driver_id);
            })->OrderBy('id','ASC')->get();
            
            if($status_tracking->count() > 0){
                $status_tracking_data = $status_tracking->map(function ($item) use($request) {                        
                    
                    $item->created_at = api_date_in_timezone($item->created_at, 'd M Y h:i A', $request->timezone);
                    return [
                        'id' => $item->id,
                        'status' => get_driver_tracking_status($item->status_tracking),
                        'time_at' => date('d M Y - h:i A',strtotime($item->created_at)),
                    ];

                });            
                
                $status = "1";
                $o_data['list'] = $status_tracking_data;
                $o_data = convert_all_elements_to_string($o_data);
            }

        }
        
        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => $o_data], 200);
    }

    public function grantAdminAcceptQuote(Request $request)
    {
        $status = "0";
        $message = "";
        $o_data = [];
        $errors = [];
       
        $validator = Validator::make($request->all(), [
            'access_token'           => 'required',
            'booking_id'             => 'required',
           
        ]);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        } else {
            $user_id = $this->validateAccesToken($request->access_token);
            $booking = Booking::find($request->booking_id);
            $booking->admin_can_accept_quote = 1;
            $booking->save();
            $status = "1";
            $message = "Admin permission granted";
        }
        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => $o_data], 200);
    }
}
