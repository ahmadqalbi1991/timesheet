<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Deligate;
use App\Models\BookingCart;
use App\Models\BookingStatusTracking;
use App\Models\Booking;
use App\Models\BookingDeligateDetail;
use App\Models\BookingTruck;
use App\Models\CartWarehousingDetail;
use App\Models\WarehouseDetail;
use Validator;
use DB;
use App\Mail\CustomerRequestMail;
use Mail;


class WarehousingController extends Controller
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

    public function warehousing_booking_create(Request $request){
       
        $status   = "0";
        $message  = "";
        $o_data   = [];
        $errors   = [];

        $rules = [];

        $rules = [
            'access_token'              => 'required',
            'device_cart_id'            => 'required',
            'is_collection'             => 'required',
            'deligate_id'               => 'required',
            'items_are_stockable'       => 'required',
            'type_of_storage'           => 'required',
            'item'                      => 'required',
            'no_of_pallets'             => 'required',
            'pallet_dimension'          => 'required',
            'weight_per_pallet'         => 'required',
            'total_weight'              => 'required',
            'total_item_cost'           => 'required'
        ];

        if(isset($request->is_collection) && $request->is_collection == 1){
            $rules['collection_address_id'] = 'required';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        }else{

            $user_id = $this->validateAccesToken($request->access_token);
            
            // Add another Service with same reference number
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
                                'device_cart_id'       => $request->device_cart_id
                            ],
                            [
                                'is_collection'        => $request->is_collection,
                                'collection_address'   => $request->collection_address_id ?? null,
                            ]);
            
            
            if(!empty($booking_cart)){
                
                if($request->has('booking_number')){
                    BookingCart::where([
                        'sender_id'            => $user_id,
                        'deligate_id'          => $request->deligate_id,
                        'device_cart_id'       => $request->device_cart_id
                    ])->update(['booking_number' => $request->booking_number]);
                }
                if($request->has('parent_id') && $request->parent_id > 0 ){
                    BookingCart::where([
                        'sender_id'            => $user_id,
                        'deligate_id'          => $request->deligate_id,
                       
                        'device_cart_id'       => $request->device_cart_id
                    ])->update(['booking_number' => $exist_booking->booking_number,'parent_id'=>$request->parent_id]);
                }
                

                CartWarehousingDetail::updateOrCreate([
                    'booking_cart_id' => $booking_cart->id
                ],[
                   'type_of_storage'            => $request->type_of_storage,
                   'item'                       => $request->item,
                   'items_are_stockable'        => $request->items_are_stockable == 1?'yes':'no',
                   'no_of_pallets'              => $request->no_of_pallets,
                   'pallet_dimension'           => $request->pallet_dimension,
                   'weight_per_pallet'          => $request->weight_per_pallet,
                   'total_weight'               => $request->total_weight,
                   'total_item_cost'            => $request->total_item_cost,
                   'date_of_commencement'       => date('Y-m-d',strtotime($request->date_of_commencement)),
                   'date_of_return'       => date('Y-m-d',strtotime($request->date_of_return)),
                ]);
                
                $o_data['is_collection'] = $booking_cart->is_collection;
                if($booking_cart->is_collection == 1){
                    $collection_address = [
                        'address' => $booking_cart->collection_address_book->address ?? '',
                        'latitude' => $booking_cart->collection_address_book->latitude ?? '',
                        'longitude' => $booking_cart->collection_address_book->longitude ?? '',
                        'country' => $booking_cart->collection_address_book->country->country_name ?? '',
                        'city' => $booking_cart->collection_address_book->city->city_name ?? '',
                        'phone' => (isset($booking_cart->collection_address_book->dial_code) && isset($booking_cart->collection_address_book->phone))? ('+'.$booking_cart->collection_address_book->dial_code." ".$booking_cart->collection_address_book->phone) : '',
                    ];
                }

                $deligate_details = [
                    'type_of_storage'            => $booking_cart->cart_warehouse_detail->storage_type->name,
                    'item'                       => $booking_cart->cart_warehouse_detail->item,
                    'items_are_stockable'        => ucfirst($booking_cart->cart_warehouse_detail->items_are_stockable),
                    'no_of_pallets'              => $booking_cart->cart_warehouse_detail->no_of_pallets,
                    'pallet_dimension'           => $booking_cart->cart_warehouse_detail->pallet_dimension,
                    'weight_per_pallet'          => $booking_cart->cart_warehouse_detail->weight_per_pallet,
                    'total_weight'               => $booking_cart->cart_warehouse_detail->total_weight,
                    'total_item_cost'            => $booking_cart->cart_warehouse_detail->total_item_cost,
                    'date_of_commencement'       => date('Y-m-d',strtotime($request->date_of_commencement)),
                    'date_of_return'             => date('Y-m-d',strtotime($request->date_of_return)),
                ];

                $status = "1";
                $message = "Request Created Successfully";
                if($booking_cart->is_collection == 1){
                    $o_data['collection_address']   = $collection_address;
                }
                $o_data['details'] = $deligate_details;
                $o_data['currency_code'] =  config('global.default_currency_code');

            }else{
                $status = "0";
                $message = "Request Could Not Created";

            }
        }

        $o_data = convert_all_elements_to_string($o_data);
        return response()->json(['status' => (string)$status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data], 200);

    }

    public function warehousing_get_cart(Request $request){
        
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
                'deligate_id'          => Deligate::Warehousing
            ])->first();
             
            if(!empty($booking_cart)){                      
                $cart = [
                    'device_cart_id'             => $booking_cart->device_cart_id ?? '',
                    'is_collection'              => $booking_cart->is_collection ?? '',
                    'deligate_id'                => $booking_cart->deligate_id ?? '',
                    'type_of_storage'            => $booking_cart->cart_warehouse_detail->type_of_storage,
                    'item'                       => $booking_cart->cart_warehouse_detail->item,
                    'items_are_stockable'        => $booking_cart->cart_warehouse_detail->items_are_stockable == 'yes'?'1':'0',
                    'no_of_pallets'              => $booking_cart->cart_warehouse_detail->no_of_pallets,
                    'pallet_dimension'           => $booking_cart->cart_warehouse_detail->pallet_dimension,
                    'weight_per_pallet'          => str_replace('Kg','',$booking_cart->cart_warehouse_detail->weight_per_pallet) ?? '',
                    'total_weight'               => str_replace('Kg','',$booking_cart->cart_warehouse_detail->total_weight) ?? '',
                    'total_item_cost'            => $booking_cart->cart_warehouse_detail->total_item_cost,
                    'date_of_commencement'       => date('Y-m-d',strtotime($booking_cart->cart_warehouse_detail->date_of_commencement)),
                    'date_of_return'             => date('Y-m-d',strtotime($booking_cart->cart_warehouse_detail->date_of_return)),
                ];

                if($booking_cart->is_collection == 1){
                    $cart['collection_address_id'] = $booking_cart->collection_address ?? '';
                }

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

    public function warehousing_booking_checkout(Request $request){
        
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
                'deligate_id'          => Deligate::Warehousing
            ])->first();
            
            if(!empty($booking_cart)){

                $o_data['is_collection'] = $booking_cart->is_collection;
                if($booking_cart->is_collection == 1){
                    $collection_address = [
                        'address' => $booking_cart->collection_address_book->address ?? '',
                        'latitude' => $booking_cart->collection_address_book->latitude ?? '',
                        'longitude' => $booking_cart->collection_address_book->longitude ?? '',
                        'country' => $booking_cart->collection_address_book->country->country_name ?? '',
                        'city' => $booking_cart->collection_address_book->city->city_name ?? '',
                        'phone' => (isset($booking_cart->collection_address_book->dial_code) && isset($booking_cart->collection_address_book->phone))? ('+'.$booking_cart->collection_address_book->dial_code." ".$booking_cart->collection_address_book->phone) : '',
                    ];
                }

                $deligate_details = [
                    'type_of_storage'            => $booking_cart->cart_warehouse_detail->storage_type->name,
                    'item'                       => $booking_cart->cart_warehouse_detail->item,
                    'items_are_stockable'        => ucfirst($booking_cart->cart_warehouse_detail->items_are_stockable),
                    'no_of_pallets'              => $booking_cart->cart_warehouse_detail->no_of_pallets,
                    'pallet_dimension'           => $booking_cart->cart_warehouse_detail->pallet_dimension,
                    'weight_per_pallet'          => $booking_cart->cart_warehouse_detail->weight_per_pallet,
                    'total_weight'               => $booking_cart->cart_warehouse_detail->total_weight,
                    'total_item_cost'            => $booking_cart->cart_warehouse_detail->total_item_cost,
                    'date_of_commencement'       => date('Y-m-d',strtotime($booking_cart->cart_warehouse_detail->date_of_commencement)),
                    'date_of_return'             => date('Y-m-d',strtotime($booking_cart->cart_warehouse_detail->date_of_return)),
                ];

                $status = "1";
                $message = "success";
                if($booking_cart->is_collection == 1){
                    $o_data['collection_address']   = $collection_address;
                }
                $o_data['details'] = $deligate_details;
                $o_data['currency_code'] =  config('global.default_currency_code');

            }else{
                $status = "0";
                $message = "No any Request Created";
            }            
        }

        $o_data = convert_all_elements_to_string($o_data);
        return response()->json(['status' => (string)$status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data], 200);
    }

    public function warehousing_place_booking(Request $request){
        
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
                'deligate_id'          => Deligate::Warehousing
            ])->first();
            
            if(!empty($booking_cart)){
                $booking = Booking::create(                [
                    'is_collection' => $booking_cart->is_collection,
                    'collection_address' => $booking_cart->collection_address_book->address ?? '',
                    'collection_latitude' => $booking_cart->collection_address_book->latitude ?? '',
                    'collection_longitude' => $booking_cart->collection_address_book->longitude ?? '',
                    'collection_country' => $booking_cart->collection_address_book->country->country_name ?? '',
                    'collection_city' => $booking_cart->collection_address_book->city->city_name ?? '',
                    'collection_phone' => (isset($booking_cart->collection_address_book->dial_code) && isset($booking_cart->collection_address_book->phone))? ('+'.$booking_cart->collection_address_book->dial_code." ".$booking_cart->collection_address_book->phone) : '',
                    'sender_id' => $user_id,
                    'deligate_id' => $booking_cart->deligate_id,
                    'admin_response' => 'pending',
                    'status' => 'pending',
                    'date_of_commencement'=> $booking_cart->cart_warehouse_detail->date_of_commencement,
                    'date_of_return'=> $booking_cart->cart_warehouse_detail->date_of_return,
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
                    
                    $booking_deligate_detail = new WarehouseDetail();
                    $booking_deligate_detail->booking_id = $booking->id;
                    $booking_deligate_detail->item                = $booking_cart->cart_warehouse_detail->item;
                    $booking_deligate_detail->type_of_storage     = $booking_cart->cart_warehouse_detail->type_of_storage;
                    $booking_deligate_detail->items_are_stockable = $booking_cart->cart_warehouse_detail->items_are_stockable;
                    $booking_deligate_detail->no_of_pallets       = $booking_cart->cart_warehouse_detail->no_of_pallets;
                    $booking_deligate_detail->weight_per_pallet   = str_replace('Kg','',$booking_cart->cart_warehouse_detail->weight_per_pallet);
                    $booking_deligate_detail->pallet_dimension    = $booking_cart->cart_warehouse_detail->pallet_dimension;
                    $booking_deligate_detail->total_weight        = str_replace('Kg','',$booking_cart->cart_warehouse_detail->total_weight);
                    $booking_deligate_detail->total_item_cost     = $booking_cart->cart_warehouse_detail->total_item_cost;
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
                    CartWarehousingDetail::where('booking_cart_id',$booking_cart->id)->delete();
                    BookingCart::where('device_cart_id',$request->device_cart_id)->where('deligate_id',Deligate::Warehousing)->delete();
                    
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
