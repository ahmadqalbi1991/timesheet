<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Deligate;
use App\Models\BookingCart;
use App\Models\BookingTruckCart;
use App\Models\BookingStatusTracking;
use App\Models\Booking;
use App\Models\BookingDeligateDetail;
use App\Models\BookingTruck;
use App\Models\CartDeligateDetail;
use Validator;
use DB;
use App\Mail\CustomerRequestMail;
use Mail;

class SeaFreightController extends Controller
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

    public function deligates_list(Request $request){
        
        $status   = "0";
        $message  = "";
        $o_data   = [];
        $errors   = [];
        
        $validator = Validator::make($request->all(), [
            'access_token' => 'required',
        ]);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        }else{

            $user_id = $this->validateAccesToken($request->access_token);
            $deligates_list = Deligate::where('status','active')->select('id','name','icon')->get();
            if(!empty($deligates_list)){
                    
                $status = "1";
                $message = "success";
                $o_data['list'] = $deligates_list->toArray();
            }else{
                $message = "no data to list";
            }
        }

        $o_data = convert_all_elements_to_string($o_data);
        return response()->json(['status' => (string)$status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data], 200);

    }

    public function ftl_seafreight_booking_create(Request $request){
       
        $status   = "0";
        $message  = "";
        $o_data   = [];
        $errors   = [];

        $validator = Validator::make($request->all(), [
            'access_token' => 'required',
            'device_cart_id' => 'required',
            'collection_address_id' => 'required|exists:addresses,id',
            'deliver_address_id' => 'required|exists:addresses,id',
            'deligate_id' => 'required',
        ]);


        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        }else{

            $user_id = $this->validateAccesToken($request->access_token);
            
            // Add another Service with same reference number
            if($request->has('booking_number')){
                $exist_booking = Booking::where('booking_number',$request->booking_number)
                                    ->where('sender_id',$user_id)
                                    ->where('status','completed')
                                    ->first();
            
                if(empty($exist_booking)){
                    return response()->json([
                        'status' => "0",
                        'message' => 'No any request exist with this reference number '.$request->booking_number,
                        'error' => (object)$errors
                    ], 200);
                }
            }
            if($request->has('parent_id') && $request->parent_id > 0 ){
                $exist_booking = Booking::where('id',$request->parent_id)
                                    ->where('sender_id',$user_id)
                                    ->where('status','completed')
                                    ->first();
            
                if(empty($exist_booking)){
                    return response()->json([
                        'status' => "0",
                        'message' => 'No any request exist with this reference number ',
                        'error' => (object)$errors
                    ], 200);
                }
            }
            clearCart($user_id);                   
            $booking_cart = BookingCart::updateOrCreate([
                                'sender_id'            => $user_id,
                                'deligate_id'          => $request->deligate_id,
                                'deligate_type'        => 'fcl',
                                'device_cart_id'       => $request->device_cart_id
                            ],
                            [
                                'is_collection' => 1,
                                'collection_address'   => $request->collection_address_id,
                                'deliver_address'      => $request->deliver_address_id,
                                'shipmenttype'         => $request->shipmenttype
                            ]);
            
            
            if(!empty($booking_cart)){
                
                if($request->has('booking_number')){
                    BookingCart::where([
                        'sender_id'            => $user_id,
                        'deligate_id'          => $request->deligate_id,
                        'deligate_type'        => 'fcl',
                        'device_cart_id'       => $request->device_cart_id
                    ])->update(['booking_number' => $request->booking_number]);
                }
                if($request->has('parent_id') && $request->parent_id > 0 ){
                    BookingCart::where([
                        'sender_id'            => $user_id,
                        'deligate_id'          => $request->deligate_id,
                        'deligate_type'        => 'fcl',
                        'device_cart_id'       => $request->device_cart_id
                    ])->update(['booking_number' => $exist_booking->booking_number,'parent_id'=>$request->parent_id]);
                }
                
                $status = "1";
                $message = "Request Created Successfully";
            }
        }

        $o_data = convert_all_elements_to_string($o_data);
        return response()->json(['status' => (string)$status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data], 200);

    }

    public function ftl_add_truck(Request $request){
       
        $status   = "0";
        $message  = "";
        $o_data   = [];
        $errors   = [];

        $validator = Validator::make($request->all(), [
            'access_token' => 'required',
            'truck_id' => 'required',
            'quantity' => 'required',
            'total_weight' => 'required',
            'device_cart_id' => 'required',
        ]);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        }else{

            $user_id = $this->validateAccesToken($request->access_token);
            
            $booking_cart = BookingCart::where([
                                'sender_id'            => $user_id,
                                'device_cart_id'       => $request->device_cart_id, 
                                'deligate_type'        => 'fcl'
                            ])->first();
            
            
            if(!empty($booking_cart) && isset($request->truck_id)){
                
                BookingTruckCart::updateOrCreate([
                    'booking_cart_id' => $booking_cart->id,
                    'truck_id'        => $request->truck_id
                ],[
                    'quantity'        => $request->quantity,
                    'gross_weight'    => $request->total_weight    
                ]);

                $status = "1";
                $message = "Container has been added successfully";
            }else{
                $status = "0";
                $message = "Cart does not exist";
            }
        }

        $o_data = convert_all_elements_to_string($o_data);
        return response()->json(['status' => (string)$status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data], 200);

    }

    public function ftl_get_selected_trucks(Request $request){

        $status   = "0";
        $message  = "";
        $o_data   = [];
        $errors   = [];

        $validator = Validator::make($request->all(), [
            'access_token' => 'required',
            'device_cart_id' => 'required',    
        ]);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        }else{

            $user_id = $this->validateAccesToken($request->access_token);

            $booking_cart = BookingCart::where([
                'sender_id'            => $user_id,
                'device_cart_id'       => $request->device_cart_id, 
                'deligate_type'        => 'ftl'
            ])->first();

            if(!empty($booking_cart)){
                $selected_trucks = BookingTruckCart::where('booking_cart_id',$booking_cart->id)->select('id','booking_cart_id','truck_id','quantity','gross_weight')->get();
                if(!empty($selected_trucks)){
                    $status = "1";
                    $message = "success";
                    $o_data['list'] = $selected_trucks->toArray();
                }
                else{
                    $status = "0";
                    $message = "no data to list";
                }
                
            }
            else{
                $status = "0";
                $message = "No any trucks added";
            }
        }

        $o_data = convert_all_elements_to_string($o_data);
        return response()->json(['status' => (string)$status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data], 200);
    }

   

    public function ftl_booking_checkout(Request $request){
        
        $status   = "0";
        $message  = "";
        $o_data   = [];
        $errors   = [];
        
        $validator = Validator::make($request->all(), [
            'access_token' => 'required',
            'device_cart_id' => 'required',    
        ]);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        }else{

            $user_id = $this->validateAccesToken($request->access_token);

            $booking_cart = BookingCart::where([
                'sender_id'            => $user_id,
                'device_cart_id'       => $request->device_cart_id, 
                'deligate_type'        => 'fcl'
            ])->first();
            
            if(!empty($booking_cart)){

                $collection_address = [
                    'address' => $booking_cart->collection_address_book->address ?? '',
                    'latitude' => $booking_cart->collection_address_book->latitude ?? '',
                    'longitude' => $booking_cart->collection_address_book->longitude ?? '',
                    'country' => $booking_cart->collection_address_book->country->country_name ?? '',
                    'city' => $booking_cart->collection_address_book->city->city_name ?? '',
                    'phone' => (isset($booking_cart->collection_address_book->dial_code) && isset($booking_cart->collection_address_book->phone))? ('+'.$booking_cart->collection_address_book->dial_code." ".$booking_cart->collection_address_book->phone) : '',
                ];

                $deliver_address = [
                    'address' => $booking_cart->deliver_address_book->address ?? '',
                    'latitude' => $booking_cart->deliver_address_book->latitude ?? '',
                    'longitude' => $booking_cart->deliver_address_book->longitude ?? '',
                    'country' => $booking_cart->deliver_address_book->country->country_name ?? '',
                    'city' => $booking_cart->deliver_address_book->city->city_name ?? '',
                    'phone' => (isset($booking_cart->deliver_address_book->dial_code) && isset($booking_cart->deliver_address_book->phone))? ('+'.$booking_cart->deliver_address_book->dial_code." ".$booking_cart->deliver_address_book->phone) : '',
                ];

                $selected_trucks = BookingTruckCart::join('truck_types','truck_types.id','=','booking_truck_carts.truck_id')->where('booking_cart_id',$booking_cart->id)
                            ->select('booking_truck_carts.id','booking_truck_carts.truck_id','booking_truck_carts.quantity','booking_truck_carts.gross_weight','truck_types.truck_type','truck_types.icon')->get();
                    
                $selected_trucks = $selected_trucks->map(function ($item) use($request) {
                    
                    $item->icon = get_uploaded_image_url($item->icon,'truct_type_upload_dir');    
                    
                    return $item;
                });

                $status = "1";
                $message = "success";
                $o_data['shipmenttype'] = $booking_cart->shipmenttype;
                if($booking_cart->shipmenttype > 0 )
                    $o_data['shipmenttype_name'] =  \App\Models\ShippingMethod::where('id',$booking_cart->shipmenttype)->first()->name;
                else
                    $o_data['shipmenttype_name'] = "";
                $o_data['collection_address']   = $collection_address;
                $o_data['deliver_address']      = $deliver_address;
                $o_data['trucks'] = $selected_trucks->toArray();

            }else{
                $status = "0";
                $message = "No any Request Created";
            }            
        }

        $o_data = convert_all_elements_to_string($o_data);
        return response()->json(['status' => (string)$status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data], 200);
    }

    public function ftl_place_booking(Request $request){
        
        $status   = "0";
        $message  = "";
        $o_data   = [];
        $errors   = [];
        
        $validator = Validator::make($request->all(), [
            'access_token' => 'required',
            'device_cart_id' => 'required',
            'is_agreed'    => 'required|in:1'     
        ]);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        }else{
            $user_id = $this->validateAccesToken($request->access_token);
            
            $booking_cart = BookingCart::where([
                'sender_id'            => $user_id,
                'device_cart_id'       => $request->device_cart_id,
                'deligate_type'        => 'fcl'
            ])->first();
            
            if(!empty($booking_cart)){


                $booking = Booking::create([
                    'is_collection' => 1,
                    'collection_address' => $booking_cart->collection_address_book->address ?? '',
                    'collection_latitude' => $booking_cart->collection_address_book->latitude ?? '',
                    'collection_longitude' => $booking_cart->collection_address_book->longitude ?? '',
                    'collection_country' => $booking_cart->collection_address_book->country->country_name ?? '',
                    'collection_city' => $booking_cart->collection_address_book->city->city_name ?? '',
                    'collection_phone' => (isset($booking_cart->collection_address_book->dial_code) && isset($booking_cart->collection_address_book->phone))? ('+'.$booking_cart->collection_address_book->dial_code." ".$booking_cart->collection_address_book->phone) : '',

                    'deliver_address' => $booking_cart->deliver_address_book->address ?? '',
                    'deliver_latitude' => $booking_cart->deliver_address_book->latitude ?? '',
                    'deliver_longitude' => $booking_cart->deliver_address_book->longitude ?? '',
                    'deliver_country' => $booking_cart->deliver_address_book->country->country_name ?? '',
                    'deliver_city' => $booking_cart->deliver_address_book->city->city_name ?? '',
                    'deliver_phone' => (isset($booking_cart->deliver_address_book->dial_code) && isset($booking_cart->deliver_address_book->phone))? ('+'.$booking_cart->deliver_address_book->dial_code." ".$booking_cart->deliver_address_book->phone) : '',
                    'shipmenttype'=>$booking_cart->shipmenttype,
                    'shipping_method_id'=>$booking_cart->shipmenttype,
                    'sender_id' => $user_id,
                    'deligate_id' => $booking_cart->deligate_id,
                    'deligate_type' => $booking_cart->deligate_type ?? '',
                    'admin_response' => 'pending',
                    'status' => 'pending',
                    'created_at' => gmdate('d M Y h:i A'),
                    'updated_at' => gmdate('d M Y h:i A'),
                ]);

                if(!empty($booking)){

                    if(isset($booking_cart->parent_id) && $booking_cart->parent_id != ''){   
                        
                        $exist_booking = Booking::where('id',$booking_cart->parent_id)
                                    ->where('sender_id',$user_id)
                                    
                                    ->first();
                        if($exist_booking !=null) {
                            $booking->parent_id = $exist_booking->id;
                            $booking->booking_number = getChildBooking($exist_booking); 
                        } else {

                            $booking_number = sprintf("%06d", $booking->id);
                            $booking->booking_number = "#TX-".$booking_number;
                        }
                        
                        $booking->save();
                    }
                    else{
                        $booking_number = sprintf("%06d", $booking->id);
                        $booking->booking_number = "#TX-".$booking_number;
                        $booking->save();
                    }

                }

                if(!empty($booking)){
                    $selected_trucks = BookingTruckCart::where('booking_cart_id',$booking_cart->id)->get();
                    if(count($selected_trucks) == 0){
                        
                        return response()->json([
                            'status' => "0",
                            'message' => 'Trucks not added',
                            'error' => (object)$errors
                        ], 200);

                    }
                    foreach($selected_trucks as $truck){

                        $booking_truck = new BookingTruck();
                        $booking_truck->booking_id = $booking->id;
                        $booking_truck->truck_id = $truck->truck_id;
                        $booking_truck->quantity = $truck->quantity;
                        $booking_truck->gross_weight = $truck->gross_weight;
                        $booking_truck->save();

                    }
                }
                
                if(!empty($booking)){
                    $data['user'] = User::find($booking->sender_id);
                    $data['booking'] = $booking;
                   if(env('MAILS_ENABLE')){
                      Mail::to($data['user']->email)->send(new CustomerRequestMail($data));
                    } 
                }

                if(!empty($booking)){
                    BookingTruckCart::where('booking_cart_id',$booking_cart->id)->delete();
                    BookingCart::where('device_cart_id',$request->device_cart_id)->where('deligate_type','fcl')->delete();
                    
                    // if (config('global.server_mode') == 'local') {
                    //     \Artisan::call('user_booking:user ' . $booking->id);
                    // } else { 
                        exec("php " . base_path() . "/artisan user_booking:user " . $booking->id . " > /dev/null 2>&1 & ");
                    //}

                    $status = "1";
                    $message = "Request Submitted Successfully";
                    $o_data['booking_id']   = $booking->booking_number; 
                }
                else{

                    $status = "0";
                    $message = "Booking Could Not Submitted";
                }                

            }else{
                $status = "0";
                $message = "No any Request Created";
            }

        }    

        $o_data = convert_all_elements_to_string($o_data);
        return response()->json(['status' => (string)$status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data], 200);
    } 
    
    public function ftl_remove_truck(Request $request){

        $status   = "0";
        $message  = "";
        $o_data   = [];
        $errors   = [];

        $validator = Validator::make($request->all(), [
            'access_token' => 'required',
            'device_cart_id' => 'required',
            'truck_id'      => 'required'    
        ]);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        }else{

            $user_id = $this->validateAccesToken($request->access_token);

            $booking_cart = BookingCart::where([
                'sender_id'            => $user_id,
                'device_cart_id'       => $request->device_cart_id, 
                'deligate_type'        => 'ftl'
            ])->first();
            
            if(!empty($booking_cart)){
                $selected_trucks = BookingTruckCart::where('booking_cart_id',$booking_cart->id)->where('truck_id',$request->truck_id)->delete();
                if(!empty($selected_trucks)){
                    $status = "1";
                    $message = "Container removed successfully";

                }
                else{
                    $status = "0";
                    $message = "Container could not remove";
                }
                
            }
            else{
                $status = "0";
                $message = "No any trucks added";
            }
            
        }   

        $o_data = convert_all_elements_to_string($o_data);
        return response()->json(['status' => (string)$status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data], 200);
    }

    public function ftl_get_cart(Request $request){
        
        $status   = "0";
        $message  = "";
        $o_data   = [];
        $errors   = [];
        
        $validator = Validator::make($request->all(), [
            'access_token' => 'required',
            'device_cart_id' => 'required',    
        ]);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        }else{

            $user_id = $this->validateAccesToken($request->access_token);

            $booking_cart = BookingCart::where([
                'sender_id'            => $user_id,
                'device_cart_id'       => $request->device_cart_id, 
                'deligate_type'        => 'ftl'
            ])->first();
            
            if(!empty($booking_cart)){

                $cart = [
                    'device_cart_id'         => $booking_cart->device_cart_id,
                    'collection_address_id' => $booking_cart->collection_address,
                    'deliver_address_id'    => $booking_cart->deliver_address,
                    'deligate_id'           => $booking_cart->deligate_id,
                    'deligate_type'         => $booking_cart->deligate_type,   
                ];



                $selected_trucks = BookingTruckCart::join('truck_types','truck_types.id','=','booking_truck_carts.truck_id')->where('booking_cart_id',$booking_cart->id)
                            ->select('booking_truck_carts.id','booking_truck_carts.truck_id','booking_truck_carts.quantity','booking_truck_carts.gross_weight','truck_types.truck_type','truck_types.icon')->get();
                    
                $selected_trucks = $selected_trucks->map(function ($item) use($request) {
                    
                    $item->icon = get_uploaded_image_url($item->icon,'truct_type_upload_dir');    
                    
                    return $item;
                });

                $status = "1";
                $message = "success";
                $o_data['cart']   = $cart;
                $o_data['trucks'] = $selected_trucks->toArray();

            }else{
                $status = "0";
                $message = "No any Cart Exist";
            }            
        }

        $o_data = convert_all_elements_to_string($o_data);
        return response()->json(['status' => (string)$status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data], 200);
    }    

    public function ltl_booking_create(Request $request){
       
        $status   = "0";
        $message  = "";
        $o_data   = [];
        $errors   = [];

        $validator = Validator::make($request->all(), [
            'access_token'              => 'required',
            'device_cart_id'            => 'required',
            'collection_address_id'     => 'required|exists:addresses,id',
            'deliver_address_id'        => 'required|exists:addresses,id',
            'deligate_id'               => 'required',
            'item'                      => 'required',
            'no_of_packages'            => 'required',
            'dimension_of_each_package' => 'required',
            'weight_of_each_package'    => 'required',
            'total_gross_weight'        => 'required',
            'total_volume_in_cbm'       => 'required'
        ]);


        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        }else{

            $user_id = $this->validateAccesToken($request->access_token);
            
            // Add another Service with same reference number
            if($request->has('parent_id')  && $request->parent_id > 0 ){
                $exist_booking = Booking::where('id',$request->parent_id)
                                    ->where('sender_id',$user_id)
                                    ->where('status','completed')
                                    ->first();
            
                if(empty($exist_booking)){
                    return response()->json([
                        'status' => "0",
                        'message' => 'No any request exist with this reference number ',
                        'error' => (object)$errors
                    ], 200);
                }
            }
            clearCart($user_id); 
            $booking_cart = BookingCart::updateOrCreate([
                                'sender_id'            => $user_id,
                                'deligate_id'          => $request->deligate_id,
                                'deligate_type'        => 'lcl',
                                'device_cart_id'       => $request->device_cart_id
                            ],
                            [
                                'is_collection' => 1,
                                'collection_address'   => $request->collection_address_id,
                                'deliver_address'      => $request->deliver_address_id,
                                'shipmenttype'         => $request->shipmenttype
                            ]);
            
            
            if(!empty($booking_cart)){
                
                if($request->has('booking_number')){
                    BookingCart::where([
                        'sender_id'            => $user_id,
                        'deligate_id'          => $request->deligate_id,
                        'deligate_type'        => 'lcl',
                        'device_cart_id'       => $request->device_cart_id
                    ])->update(['booking_number' => $request->booking_number]);
                }
                
                if($request->has('parent_id') && $request->parent_id > 0 ){
                    BookingCart::where([
                        'sender_id'            => $user_id,
                        'deligate_id'          => $request->deligate_id,
                        'deligate_type'        => 'lcl',
                        'device_cart_id'       => $request->device_cart_id
                    ])->update(['booking_number' => $exist_booking->booking_number,'parent_id'=>$request->parent_id]);
                }

                CartDeligateDetail::updateOrCreate([
                    'booking_cart_id' => $booking_cart->id
                ],[
                   'item'                       => $request->item,
                   'no_of_packages'             => $request->no_of_packages,
                   'dimension_of_each_package'  => $request->dimension_of_each_package,
                   'weight_of_each_package'     => $request->weight_of_each_package,
                   'total_gross_weight'         => $request->total_gross_weight,
                   'total_volume_in_cbm'        => $request->total_volume_in_cbm
                ]);
                
                $collection_address = [
                    'address' => $booking_cart->collection_address_book->address ?? '',
                    'latitude' => $booking_cart->collection_address_book->latitude ?? '',
                    'longitude' => $booking_cart->collection_address_book->longitude ?? '',
                    'country' => $booking_cart->collection_address_book->country->country_name ?? '',
                    'city' => $booking_cart->collection_address_book->city->city_name ?? '',
                    'phone' => (isset($booking_cart->collection_address_book->dial_code) && isset($booking_cart->collection_address_book->phone))? ('+'.$booking_cart->collection_address_book->dial_code." ".$booking_cart->collection_address_book->phone) : '',
                ];

                $deliver_address = [
                    'address' => $booking_cart->deliver_address_book->address ?? '',
                    'latitude' => $booking_cart->deliver_address_book->latitude ?? '',
                    'longitude' => $booking_cart->deliver_address_book->longitude ?? '',
                    'country' => $booking_cart->deliver_address_book->country->country_name ?? '',
                    'city' => $booking_cart->deliver_address_book->city->city_name ?? '',
                    'phone' => (isset($booking_cart->deliver_address_book->dial_code) && isset($booking_cart->deliver_address_book->phone))? ('+'.$booking_cart->deliver_address_book->dial_code." ".$booking_cart->deliver_address_book->phone) : '',
                ];


                $deligate_details = [
                    'item'                       => $booking_cart->cart_deligate_detail->item ?? '',
                    'no_of_packages'             => $booking_cart->cart_deligate_detail->no_of_packages ?? '',
                    'dimension_of_each_package'  => $booking_cart->cart_deligate_detail->dimension_of_each_package ?? '',
                    'weight_of_each_package'     => $booking_cart->cart_deligate_detail->weight_of_each_package ?? '',
                    'total_gross_weight'         => $booking_cart->cart_deligate_detail->total_gross_weight ?? '',
                    'total_volume_in_cbm'        => $booking_cart->cart_deligate_detail->total_volume_in_cbm ?? ''
                ];

                $status = "1";
                $message = "Request Created Successfully";
                $o_data['collection_address']   = $collection_address;
                $o_data['deliver_address']      = $deliver_address;
                $o_data['details'] = $deligate_details;


            }else{
                $status = "0";
                $message = "Request Could Not Created";

            }
        }

        $o_data = convert_all_elements_to_string($o_data);
        return response()->json(['status' => (string)$status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data], 200);

    }

    public function ltl_get_cart(Request $request){
        
        $status   = "0";
        $message  = "";
        $o_data   = [];
        $errors   = [];
        
        $validator = Validator::make($request->all(), [
            'access_token' => 'required',
            'device_cart_id' => 'required',    
        ]);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        }else{

            $user_id = $this->validateAccesToken($request->access_token);

            $booking_cart = BookingCart::where([
                'sender_id'            => $user_id,
                'device_cart_id'       => $request->device_cart_id, 
                'deligate_type'        => 'ltl'
            ])->first();
             
            if(!empty($booking_cart)){

                $cart = [
                    'device_cart_id'             => $booking_cart->device_cart_id ?? '',
                    'collection_address_id'      => $booking_cart->collection_address ?? '',
                    'deliver_address_id'         => $booking_cart->deliver_address ?? '',
                    'deligate_id'                => $booking_cart->deligate_id ?? '',
                    'deligate_type'              => $booking_cart->deligate_type ?? '',
                    'shipmenttype'               => $booking_cart->shipmenttype??'',
                    'item'                       => $booking_cart->cart_deligate_detail->item ?? '',
                    'no_of_packages'             => $booking_cart->cart_deligate_detail->no_of_packages ?? '',
                    'dimension_of_each_package'  => $booking_cart->cart_deligate_detail->dimension_of_each_package ?? '',
                    'weight_of_each_package'     => str_replace('Kg','',$booking_cart->cart_deligate_detail->weight_of_each_package) ?? '',
                    'total_gross_weight'         => str_replace('Kg','',$booking_cart->cart_deligate_detail->total_gross_weight) ?? '',
                    'total_volume_in_cbm'        => $booking_cart->cart_deligate_detail->total_volume_in_cbm ?? ''
                ];

                $status = "1";
                $message = "success";
                $o_data['cart']   = $cart;
                

            }else{
                $status = "0";
                $message = "No any Cart Exist";
            }            
        }

        $o_data = convert_all_elements_to_string($o_data);
        return response()->json(['status' => (string)$status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data], 200);
    }    

    public function ltl_booking_checkout(Request $request){
        
        $status   = "0";
        $message  = "";
        $o_data   = [];
        $errors   = [];
        
        $validator = Validator::make($request->all(), [
            'access_token' => 'required',
            'device_cart_id' => 'required',    
        ]);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        }else{

            $user_id = $this->validateAccesToken($request->access_token);

            $booking_cart = BookingCart::where([
                'sender_id'            => $user_id,
                'device_cart_id'       => $request->device_cart_id, 
                'deligate_type'        => 'lcl'
            ])->first();
            
            if(!empty($booking_cart)){

                $collection_address = [
                    'address' => $booking_cart->collection_address_book->address ?? '',
                    'latitude' => $booking_cart->collection_address_book->latitude ?? '',
                    'longitude' => $booking_cart->collection_address_book->longitude ?? '',
                    'country' => $booking_cart->collection_address_book->country->country_name ?? '',
                    'city' => $booking_cart->collection_address_book->city->city_name ?? '',
                    'phone' => (isset($booking_cart->collection_address_book->dial_code) && isset($booking_cart->collection_address_book->phone))? ('+'.$booking_cart->collection_address_book->dial_code." ".$booking_cart->collection_address_book->phone) : '',
                ];

                $deliver_address = [
                    'address' => $booking_cart->deliver_address_book->address ?? '',
                    'latitude' => $booking_cart->deliver_address_book->latitude ?? '',
                    'longitude' => $booking_cart->deliver_address_book->longitude ?? '',
                    'country' => $booking_cart->deliver_address_book->country->country_name ?? '',
                    'city' => $booking_cart->deliver_address_book->city->city_name ?? '',
                    'phone' => (isset($booking_cart->deliver_address_book->dial_code) && isset($booking_cart->deliver_address_book->phone))? ('+'.$booking_cart->deliver_address_book->dial_code." ".$booking_cart->deliver_address_book->phone) : '',
                ];

                $deligate_details = [
                    'item'                       => $booking_cart->cart_deligate_detail->item ?? '',
                    'no_of_packages'             => $booking_cart->cart_deligate_detail->no_of_packages ?? '',
                    'dimension_of_each_package'  => $booking_cart->cart_deligate_detail->dimension_of_each_package ?? '',
                    'weight_of_each_package'     => $booking_cart->cart_deligate_detail->weight_of_each_package ?? '',
                    'total_gross_weight'         => $booking_cart->cart_deligate_detail->total_gross_weight ?? '',
                    'total_volume_in_cbm'        => $booking_cart->cart_deligate_detail->total_volume_in_cbm ?? ''
                ];
                $o_data['shipmenttype'] = $booking_cart->shipmenttype;
                if($booking_cart->shipmenttype > 0 )
                    $o_data['shipmenttype_name'] =  \App\Models\ShippingMethod::where('id',$booking_cart->shipmenttype)->first()->name;
                else
                    $o_data['shipmenttype_name'] = "";

                $status = "1";
                $message = "success";
                $o_data['collection_address']   = $collection_address;
                $o_data['deliver_address']      = $deliver_address;
                $o_data['details'] = $deligate_details;

            }else{
                $status = "0";
                $message = "No any Request Created";
            }            
        }

        $o_data = convert_all_elements_to_string($o_data);
        return response()->json(['status' => (string)$status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data], 200);
    }

    public function ltl_place_booking(Request $request){
        
        $status   = "0";
        $message  = "";
        $o_data   = [];
        $errors   = [];
        
        $validator = Validator::make($request->all(), [
            'access_token' => 'required',
            'device_cart_id' => 'required',
            'is_agreed'    => 'required|in:1'     
        ]);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        }else{
            $user_id = $this->validateAccesToken($request->access_token);
            
            $booking_cart = BookingCart::where([
                'sender_id'            => $user_id,
                'device_cart_id'       => $request->device_cart_id,
                'deligate_type'        => 'lcl'
            ])->first();
            
            if(!empty($booking_cart)){

                $booking = Booking::create([
                    'is_collection' => 1,
                    'collection_address' => $booking_cart->collection_address_book->address ?? '',
                    'collection_latitude' => $booking_cart->collection_address_book->latitude ?? '',
                    'collection_longitude' => $booking_cart->collection_address_book->longitude ?? '',
                    'collection_country' => $booking_cart->collection_address_book->country->country_name ?? '',
                    'collection_phone' => (isset($booking_cart->collection_address_book->dial_code) && isset($booking_cart->collection_address_book->phone))? ('+'.$booking_cart->collection_address_book->dial_code." ".$booking_cart->collection_address_book->phone) : '',

                    'deliver_address' => $booking_cart->deliver_address_book->address ?? '',
                    'deliver_latitude' => $booking_cart->deliver_address_book->latitude ?? '',
                    'deliver_longitude' => $booking_cart->deliver_address_book->longitude ?? '',
                    'deliver_country' => $booking_cart->deliver_address_book->country->country_name ?? '',
                    'deliver_city' => $booking_cart->deliver_address_book->city->city_name ?? '',
                    'deliver_phone' => (isset($booking_cart->deliver_address_book->dial_code) && isset($booking_cart->deliver_address_book->phone))? ('+'.$booking_cart->deliver_address_book->dial_code." ".$booking_cart->deliver_address_book->phone) : '',
                    
                    'shipmenttype'=>$booking_cart->shipmenttype,
                    'shipping_method_id'=>$booking_cart->shipmenttype,
                    'sender_id' => $user_id,
                    'deligate_id' => $booking_cart->deligate_id,
                    'deligate_type' => $booking_cart->deligate_type ?? '',
                    'admin_response' => 'pending',
                    'status' => 'pending',
                    'created_at' => time_to_uae(gmdate('d M Y h:i A')),
                    'updated_at' => time_to_uae(gmdate('d M Y h:i A')),
                ]);

                if(!empty($booking)){
                    if(isset($booking_cart->parent_id) && $booking_cart->parent_id != ''){   
                        
                        $exist_booking = Booking::where('id',$booking_cart->parent_id)
                                    ->where('sender_id',$user_id)
                                    
                                    ->first();
                        if($exist_booking !=null) {
                            $booking->parent_id = $exist_booking->id;
                            $booking->booking_number = getChildBooking($exist_booking); 
                        } else {
                            
                            $booking_number = sprintf("%06d", $booking->id);
                            $booking->booking_number = "#TX-".$booking_number;
                        }
                        
                        $booking->save();
                    }
                    else{
                        $booking_number = sprintf("%06d", $booking->id);
                        $booking->booking_number = "#TX-".$booking_number;
                        $booking->save();
                    }
                }

                if(!empty($booking)){
                    
                    $booking_deligate_detail = new BookingDeligateDetail();
                    $booking_deligate_detail->booking_id            = $booking->id;
                    $booking_deligate_detail->item                  = $booking_cart->cart_deligate_detail->item;
                    $booking_deligate_detail->no_of_packages        = $booking_cart->cart_deligate_detail->no_of_packages;
                    $booking_deligate_detail->dimension_of_each_package = $booking_cart->cart_deligate_detail->dimension_of_each_package;
                    $booking_deligate_detail->weight_of_each_package = str_replace('Kg','',$booking_cart->cart_deligate_detail->weight_of_each_package);
                    $booking_deligate_detail->total_gross_weight    = str_replace('Kg','',$booking_cart->cart_deligate_detail->total_gross_weight);
                    $booking_deligate_detail->total_volume_in_cbm   = $booking_cart->cart_deligate_detail->total_volume_in_cbm;
                    $booking_deligate_detail->save();
                }
                
                if(!empty($booking)){
                    $data['user'] = User::find($booking->sender_id);
                    $data['booking'] = $booking;
                   if(env('MAILS_ENABLE')){
                        Mail::to($data['user']->email)->send(new CustomerRequestMail($data));
                    } 
                }

                if(!empty($booking)){
                    CartDeligateDetail::where('booking_cart_id',$booking_cart->id)->delete();
                    BookingCart::where('device_cart_id',$request->device_cart_id)->where('deligate_type','lcl')->delete();
                    
                    // if (config('global.server_mode') == 'local') {
                    //     \Artisan::call('user_booking:user ' . $booking->id);
                    // } else { 
                        exec("php " . base_path() . "/artisan user_booking:user " . $booking->id . " > /dev/null 2>&1 & ");
                    //}

                    $status = "1";
                    $message = "Request Submitted Successfully";
                    $o_data['booking_id']   = $booking->booking_number; 
                }
                else{

                    $status = "0";
                    $message = "Request Could Not Submitted";
                }                

            }else{
                $status = "0";
                $message = "No any Request Created";
            }

        }    

        $o_data = convert_all_elements_to_string($o_data);
        return response()->json(['status' => (string)$status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data], 200);
    }
}
