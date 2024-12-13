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
use App\Models\DriverDetail;
use App\Models\City;
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
            $driver_details = \App\Models\DriverDetail::where(['user_id' => $user_id])->first();

            // $bookingsIds = Booking::
            // where('deligate_id',1)
            // ->whereHas('booking_truck', function($q) use($driver_details) {
            //     return $q->where('truck_id',$driver_details->truck_type_id);
            // })
            // ->with(['booking_truck'=> function($q) use($driver_details) {
            //     return $q->where('truck_id',$driver_details->truck_type_id);
            // }])
            // ->where('deligate_type','ftl')
            // ->whereIn('status',['pending','qouted','qoutes_received'])
            // ->orderBy('id','desc')->pluck('id')->toArray();

            $bookings = Booking::
            where('deligate_id',1)
            ->whereHas('booking_truck', function($q) use($driver_details) {
                return $q->where('truck_id',$driver_details->truck_type_id);
            })
            ->with(['booking_truck'=> function($q) use($driver_details) {
                return $q->where('truck_id',$driver_details->truck_type_id);
            }])
            ->with(['booking_qoutes'=> function($q) use($user_id) {
                // return $q->where('driver_id',$user_id);//->whereIn('status',['pending','qouted']);
            }])
            // where('deligate_id',$driver_details->truck_type_id)
            ->where('deligate_type','ftl')
            ->orderBy('id','desc')->get();
            $bookingsIds = [];
            foreach($bookings  as $key => $row){
                // ['accepted', 'journey_started', 'item_collected', 'on_the_way', 'border_crossing', 'custom_clearance', 'delivered']
                $quote_count = $row->booking_qoutes->whereNotIn('status',['pending','qouted'])->count();
                $driver_b_q = $row->booking_qoutes->where('driver_id',$user_id)->first();
                $qty = $row->booking_truck->first()->quantity;
                if($qty > $quote_count && !($driver_b_q && $driver_b_q->status == 'accepted')){
                    // if($driver_b_q && $driver_b_q->status == 'accepted'){
                    // }else{
                        $bookingsIds[] = $row->id;
                    // }
                }  
            }

            $bookings = Booking::with(['booking_qoutes'=> function($q) use($user_id) {
                return $q->where('driver_id',$user_id)->whereIn('status',['pending','qouted']);
            }])
            ->whereHas('booking_qoutes', function($q) use($user_id) {
                return $q->where('driver_id',$user_id)->whereIn('status',['pending','qouted']);
            })
            // ->join('booking_qoutes','bookings.id','=','booking_qoutes.booking_id')
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
                    'bookings.deligate_id as deligate_id',
                    // 'booking_qoutes.status as quote_status',
                    )
            ->whereIn('bookings.deligate_id',['1'])
            ->whereIn('bookings.status',['pending','qouted'])
            // ->when(count($bookingsIds),function($q) use($bookingsIds){
                // return $q
                ->orWhereIn('bookings.id',$bookingsIds)
            // })
            ->orderBy('bookings.id','desc');

            if($limit !="") {
                $bookings->limit($limit)->skip($offset);
            }

            $bookings = $bookings->get()->map(function ($item) use($request) {
               
                 $item->quote_status_number = config('global.'.($item->booking_qoutes->first() ? $item->booking_qoutes->first()->status : 'pending'));
                 $item->quote_status = driver_quote_status_name(($item->booking_qoutes->first() ? $item->booking_qoutes->first()->status : 'pending'));
                 $item->created_at = api_date_in_timezone($item->created_at, 'Y-m-d H:i:s', $request->timezone);
                 $item->created_at_format = api_date_in_timezone($item->created_at, 'd M Y', $request->timezone);
                 $item->deligate_name = $item->deligate_data->name??'';
                 unset($item->booking_qoutes);
                return $item;
            });            

            $status = "1";
            $o_data['count'] = $bookings->count();
            $o_data['list'] = $bookings->toArray();
            $o_data['document_expired'] = driverExpiry($user_id);
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
                    'bookings.deligate_id as deligate_id', 
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
                 $item->deligate_name = $item->deligate_data->name??'';
                return $item;
            });            

            $status = "1";
            $o_data['list'] = $bookings->toArray();
            $o_data['document_expired'] = driverExpiry($user_id);
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
                    'bookings.deligate_id as deligate_id', 
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
                 $item->deligate_name = $item->deligate_data->name??'';
                return $item;
            });            

            $status = "1";
            $o_data['list'] = $bookings->toArray();
            $o_data['document_expired'] = driverExpiry($user_id);
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
                
            // if(empty($booking_qoute)){
            //     return response()->json([
            //         'status' => "0",
            //         'error' => (object) array(),
            //         'message' => 'No any request found',
            //     ], 200);                
            // }

            if(isset($booking_qoute->status) && $booking_qoute->status == 'accepted'){

                $booking = Booking::
                    // join('accepted_qoutes','bookings.id','=','accepted_qoutes.booking_id')
                    with(['booking_accepted_qoutes'=> function($q) use($user_id) {
                    return $q->where('driver_id',$user_id);
                }])
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
                        'bookings.deligate_id as deligate_id', 
                        // 'accepted_qoutes.status as quote_status',
                        // 'accepted_qoutes.qouted_amount as quoted_amount',
                        // 'accepted_qoutes.hours as hours',
                        // 'accepted_qoutes.booking_truck_id as booking_truck_id',
                        )
                ->where('bookings.id',$request->booking_id)       
                // ->where('accepted_qoutes.driver_id',$user_id)
                ->first();
                $booking->booking_qoutes = $booking->booking_accepted_qoutes;

            }else{
                
                $booking = Booking::
                // join('booking_qoutes','bookings.id','=','booking_qoutes.booking_id')
                with(['booking_qoutes'=> function($q) use($user_id) {
                    return $q->where('driver_id',$user_id)->whereIn('status',['pending','qouted']);
                },'deligate_data'])
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
                        'bookings.deligate_id as deligate_id', 
                        // 'booking_qoutes.status as quote_status',
                        // 'booking_qoutes.price as quoted_amount',
                        // 'booking_qoutes.hours as hours',
                        // 'booking_qoutes.booking_truck_id as booking_truck_id',
                        )
                ->where('bookings.id',$request->booking_id)
                // ->where('booking_qoutes.driver_id',$user_id)
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
                $data['deligate_name'] = $booking->deligate_data->name??'';
                $data['deligate_id'] = $booking->deligate_id;
                $booking_qoutes = $booking->booking_qoutes->first() ?? new BookingQoute();

                if(!$booking_qoutes->status){
                    $booking_qoutes->status = 'pending';
                }
                
                if(isset($booking_qoute->status) && $booking_qoute->status == 'accepted'){
                    $booking_qoutes->price = $booking_qoutes->qouted_amount;
                }
                $data['allow_place_quote'] = ($booking_qoutes->status == 'pending')?'1':'0';
                // dd($booking_qoutes);
                if($booking_qoutes->status == 'pending' || $booking_qoutes->status == 'qouted'){
                    $data['current_status_number'] = config('global.'.$booking_qoutes->status);
                    $data['current_status'] = driver_quote_status_name($booking_qoutes->status);

                    $data['next_status_number'] = '';
                    $data['next_status'] = '';

                }else{
                    if($request->test){
                        dd(config('global.'.$booking_qoutes->status),config('global.'.next_status($booking_qoutes->status)),$booking_qoutes);
                    }

                    $data['current_status_number'] = config('global.'.$booking_qoutes->status);
                    $data['current_status'] = driver_quote_status_name($booking_qoutes->status);

                    $data['next_status_number'] = config('global.'.next_status($booking_qoutes->status));
                    $data['next_status'] = driver_quote_status_name(next_status($booking_qoutes->status));

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
                $driver_details = \App\Models\DriverDetail::where(['user_id' => $user_id])->first();
                
                $booking_truck = BookingTruck::where([['truck_id',$driver_details->truck_type_id],['booking_id',$booking->id]])->first();
                // dd($booking_truck,$booking_qoutes,$booking);
                if($booking_truck){                  
                                        
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

                if($booking_qoutes->id && $booking_qoutes->status != 'pending'){                  
                                
                    $data['quote_detail'] = [
                        'quoted_amount' => $booking_qoutes->price ?? '0',
                        'hours'    => ($booking_qoutes->hours ?? '0')." "."Hours",
                        'deliver_note_doc'=>'',
                        'driver_advance_amount'=>'0',
                        'balance_amount'=>$booking_qoutes->price
                    ];      
                    if(isset($booking_qoutes->deliver_note_doc) && $booking_qoutes->deliver_note_doc !='') {
                        $data['quote_detail']['deliver_note_doc'] = asset('storage/bookings/'.$booking_qoutes->deliver_note_doc);
                    }  
                    if(isset($booking_qoutes->driver_advance_amount) ) {
                        $data['quote_detail']['driver_advance_amount'] = $booking_qoutes->driver_advance_amount;
                        $data['quote_detail']['balance_amount'] = $booking_qoutes->price-$booking_qoutes->driver_advance_amount;
                    }                                        

                    $data['quote_section'] = '1';
                    $data['extra_charge'] = \App\Models\BookingExtraPayment::where('driver_id',$user_id)->where('booking_id',$booking->id)->get()->toArray();
                    $extra_charge = config('global.extra_charge');
                    foreach ($data['extra_charge'] as $key => $value) {
                        
                        $data['extra_charge'][$key]['charge_name'] = $extra_charge[$value['extra_charge_id']];
                        
                    }
                    $totalExpenses = array_column($data['extra_charge'], 'extra_charge_amount');
                    
                    $data['quote_detail']['balance_amount'] = $data['quote_detail']['balance_amount']- array_sum($totalExpenses);
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
            $bool = BookingQoute::where('booking_id',$request->booking_id)->where('driver_id',$user_id)->whereIn('status',['pending','qouted'])->first();
            $driver_details = \App\Models\DriverDetail::with('truck_type')->where(['user_id' => $user_id])->first();

            // $booking_truck = BookingTruck::with('truck_type')->where('booking_id',$booking->id)->first();
            // dd( $booking_truck,$driver_details);
            // if(!$booking_truck){
            //     $booking_truck = new BookingTruck();
            //     $booking_truck->booking_id = $booking->id;
            //     $booking_truck->truck_id = $truck_type;
            //     $booking_truck->quantity = $request->quantity[$key];
            //     $booking_truck->gross_weight = $request->gross_weight[$key];
            //     $booking_truck->save();
            // }
            if(!$bool){
                $bool = new BookingQoute();
                $bool->booking_id = $request->booking_id;
                $bool->driver_id = $user_id;
            }
            if(!$bool->booking_truck_id){
                $bool->booking_truck_id =  $driver_details->truck_type_id;
            }
            $bool->price =  $request->price;
            $bool->hours = $request->hours;
            $bool->status = 'qouted';
            $bool->statuscode = config('global.qouted');
            $bool->qouted_at = gmdate('Y-m-d H:i:s');
            $bool->save();


            // $bool = BookingQoute::where('booking_id',$request->booking_id)
            //         ->where('driver_id',$user_id)->where('status','pending')->update([
            //             'price' => $request->price,
            //             'hours' => $request->hours,
            //             'status' => 'qouted',
            //             'statuscode' => config('global.qouted'),
            //             'qouted_at' => gmdate('Y-m-d H:i:s')
            //         ]);
            
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
                    //Mail::to(env('Admin_Email'))->send(new DriverSubmitMail($data));
                    Mail::to("rusvinmerak@gmail.com")->send(new DriverSubmitMail($data));
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
                // if($request->test){
                //     dd(config('global.qoute_status_names.'.$request->status),AcceptedQoute::where('booking_id',$request->booking_id)
                // ->where('driver_id',$user_id)->get());
                // }
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
                                'created_at' => time_to_uae(gmdate('Y-m-d H:i:s')),//gmdate('Y-m-d H:i:s'),
                                'updated_at' => time_to_uae(gmdate('Y-m-d H:i:s')),//gmdate('Y-m-d H:i:s'),
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
            //'delivery_note'          => 'required', 
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
                if($request->file("deliver_note_doc") != null){
                    $response = image_upload($request,'bookings','deliver_note_doc');
                    
                    if($response['status']){
                        $qoute->deliver_note_doc = $response['link'];                        
                    }
                }
                if($request->file("upload_doc") != null){
                    $response = image_upload($request,'bookings','upload_doc');
                    
                    if($response['status']){
                        //$qoute->upload_doc = $response['link'];                        
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
                                'created_at' => time_to_uae(gmdate('Y-m-d H:i:s')),//gmdate('Y-m-d H:i:s'),
                                'updated_at' => time_to_uae(gmdate('Y-m-d H:i:s')),//gmdate('Y-m-d H:i:s'),
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
           // 'driving_license_issued_by' => 'required',
            'driving_license_expiry'    => 'required',
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
            $customer->trade_licence_number = $request->trade_licence_number;
            $customer->latitude = $request->latitude;
            $customer->longitude = $request->longitude;
            $customer->country_id = $request->country_id;
            $customer->city_id = $request->city_id;
            $customer->updated_at  = gmdate('Y-m-d H:i:s');
            $customer->save();



            $vehicle_plate_place = City::find($request->vehicle_plate_place);
            
            $driving_license_issued_by = City::find($request->driving_license_issued_by);

            $driverdetails = DriverDetail::where('user_id',$user_id)->first();
            $driverdetails->mulkia_number = $request->mulkiya_number;
            $driverdetails->driving_license_issued_by = $driving_license_issued_by->city_name??'';
            $driverdetails->driving_license_number = $request->driving_license_number;
            $driverdetails->driving_license_expiry = $request->driving_license_expiry??'';
            //$driverdetails->is_company = $request->account_type == '0' ? 'no' : 'yes';
            //$driverdetails->truck_type_id = $request->truck_type_id;
            
            $response = '';
            if($request->file("mulkiya") != null){
                $response = image_upload($request,'users','mulkiya');
                
                if($response['status']){
                    $driverdetails->mulkia = $response['link'];
                }
            }
            $response = '';
            if($request->file("driving_license") != null){
                $response = image_upload($request,'users','driving_license');
                
                if($response['status']){
                    $driverdetails->driving_license = $response['link'];
                }
            }
            
            $driverdetails->vehicle_plate_number = $request->vehicle_plate_number;
            $driverdetails->vehicle_plate_place = isset($vehicle_plate_place) ?  $vehicle_plate_place->city_name :'';
            $response = '';
            if($request->file("emirates_id_or_passport_front") != null){
                $response = image_upload($request,'users','emirates_id_or_passport_front');
                
                if($response['status']){
                    $driverdetails->emirates_id_or_passport = $response['link'];
                }
            }
            $response = '';
            if($request->file("emirates_id_or_passport_back") != null){
                $response = image_upload($request,'users','emirates_id_or_passport_back');
                
                if($response['status']){
                    $driverdetails->emirates_id_or_passport_back = $response['link'];
                }
            }
           
            $driverdetails->save();
            
            $response = '';
            if($request->file("trade_licence_doc") != null){
                $response = image_upload($request,'users','trade_licence_doc');
                
                if($response['status']){
                    $customer->trade_licence_doc = $response['link'];
                    $customer->save();
                }
            }
            if(!empty($customer)){
                $response = '';
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
            $driverdetails = DriverDetail::where('user_id',$user_id)->first();

            if(!empty($user)){
                $data = [];
                $data = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'dial_code' => $user->dial_code,
                    'dial_code_display' => '+'.$user->dial_code,
                    'phone' => $user->phone,
                    'country' => $user->country,
                    'country_id' =>$user->country_id,
                    'city_id' => $user->city_id,
                    'account_type' => $driverdetails->is_company == 'no' ? 'Individual' : 'Company',
                    'city' => $user->city,
                    'zip_code' => $user->zip_code,
                    'address' => $user->address_2,
                    'location' => $user->address,
                    'profile_image' => $user->profile_image,
                    'latitude' => $user->latitude,
                    'longitude' => $user->longitude,
                    'trade_licence_number' => $user->trade_licence_number,
                    'driving_license' => $driverdetails->driving_license,
                    'driving_license_number' => $driverdetails->driving_license_number,
                    'driving_license_expiry' => $driverdetails->driving_license_expiry,
                    'mulkiya' => $driverdetails->mulkia,
                    'emirates_id_or_passport' => $driverdetails->emirates_id_or_passport,
                    'emirates_id_or_passport_back' => $driverdetails->emirates_id_or_passport_back,
                    'vehicle_plate_place' => $driverdetails->vehicle_plate_place,
                    'vehicle_plate_place_id' => $user->city_id,
                    'mulkiya_number' => $driverdetails->mulkia_number,
                    'driving_license_issued_by' => $driverdetails->driving_license_issued_by,
                    'driving_license_issued_by_id' => $user->city_id,
                    'trade_licence_doc' => $user->trade_licence_doc,
                    'vehicle_plate_number' => $driverdetails->vehicle_plate_number,
                    'truck_type_id' => $driverdetails->truck_type_id,
                    'truck_type_name' => $driverdetails->truck_type->truck_type??'',
                    'additional_phone'=>\App\Models\UserAdditionalPhone::where('user_id',$user->id)->get(['id','dial_code','mobile'])->toArray()
                ];     
                $status = "1";
                $message = "success";
                $o_data['user'] = convert_all_elements_to_string($data);
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
            'booking_id' => 'required',
            'advance_amount' => 'required',
            'quote_id'=>''
        ]);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        } else {
            $user = User::find($user_id);
            $qoute = AcceptedQoute::where('booking_id',$request->booking_id)
                        ->where('driver_id',$user_id);  
            if(isset($request->quote_id)) {
                $qoute =  $qoute->where('id',$request->quote_id); 
            }      
            $qoute =  $qoute->first();     

            if(!empty($qoute)){
               
                $qoute = AcceptedQoute::find($qoute->id);
                $qoute->driver_advance_amount = $qoute->driver_advance_amount+$request->advance_amount;
                $qoute->save();
                $booking = Booking::find($request->booking_id);
                $booking->total_received_amount = $booking->total_received_amount+$request->advance_amount;
                $booking->save();
                $status = "1";
                $message = "Advance amount added";
            }
            
        }
        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => (object)$o_data], 200);
    }

    public function addExpenses(Request $request)
    {
        $status = "0";
        $message = "";
        $o_data = [];
        $errors = [];
        $user_id = $this->validateAccesToken($request->access_token);
        $validator = Validator::make($request->all(), [
            'access_token' => 'required',
            'booking_id' => 'required',
            'extra_charge_amount' => 'required',
            'extra_charge_id'=>'required',
            'extra_charge_name'=>'',
            'id'=>''
        ]);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        } else {
            $user = User::find($user_id);
            $qoute = AcceptedQoute::where('booking_id',$request->booking_id)
                        ->where('driver_id',$user_id);  
            if(isset($request->quote_id)) {
                $qoute =  $qoute->where('id',$request->quote_id); 
            }      
            $qoute =  $qoute->first(); 
            if(!empty($qoute)){               
                $qoute = AcceptedQoute::find($qoute->id);
                if(isset($request->id)) {
                    $payment =  \App\Models\BookingExtraPayment::find($request->id);
                } else {
                    $payment =  new \App\Models\BookingExtraPayment();
                    $payment->created_at = gmdate('Y-m-d H:i:s');
                }
                $payment->booking_id = $request->booking_id;
                $payment->accepted_quote_id = $qoute->id;
                $payment->driver_id = $user->id;
                $payment->extra_charge_id = $request->extra_charge_id;
                $payment->extra_charge_name = $request->extra_charge_name;
                $payment->extra_charge_amount = $request->extra_charge_amount;
                
                $payment->updated_at = gmdate('Y-m-d H:i:s');
                $payment->save();
                $status = "1";
                $message = "Extra expense saved successfully";

            } else {
                $message = "Permission denied";
            }
        }
        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => (object)$o_data], 200);
    }

    public function extraCategoryList(Request $request)
    {
        $status = "1";
        $message = "";
        $o_data = [];
        $errors = [];
        $list = [];
        $extra_charge = config('global.extra_charge');
        foreach ($extra_charge as $key => $value) {
            $list[] = ['id'=>$key,'vl'=>$value];
        }
        $o_data['list'] = array_values($list);
        $o_data = convert_all_elements_to_string($o_data);
        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => (object)$o_data], 200);
    }
    

}    
