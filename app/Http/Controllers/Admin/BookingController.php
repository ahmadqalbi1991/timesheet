<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company;
use App\Models\TruckType;
use App\Models\Wallet;
use App\Models\ShippingMethod;
use App\Models\DriverDetail;
use App\Models\Booking;
use App\Models\Deligate;
use App\Models\user_wallet_transactions;
use App\Models\BookingQoute;
use App\Models\BookingAdditionalCharge;
use App\Models\BookingStatusTracking;
use App\Models\BookingTruck;
use App\Models\Container;
use App\Models\BookingTruckAlot;
use App\Models\BookingDeligateDetail;
use App\Models\WarehouseDetail;
use App\Models\Address;
use App\Models\AcceptedQoute;
use Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\LaravelAdapter;
use DB;
use Carbon\Carbon;
use App\Mail\CustomerRequestMail;
use App\Mail\DriverRequestMail;
use App\Mail\DriverQoutedRequest;
use App\Mail\CustomerRequestUpdateMail;
use Mail;

class BookingController extends Controller
{
    public function index(REQUEST $request)
    {
        $page_heading = "Bookings";
        $mode = "List";
        return view('admin.bookings.list', compact('mode', 'page_heading'));
    }

    public function create(){

        $page_heading = "Create Booking";
        $mode = "create";
        $customers = User::where('status','active')->where('role_id',3)->orderBy('name','asc')->get();
        $trucks = TruckType::where('status','active')->get();
        $deligates = Deligate::where('status','active')->get();
        $shipping_methods = ShippingMethod::where('status','active')->get();
        return view('admin.bookings.create',compact('customers','page_heading','mode','trucks','shipping_methods','deligates'));

    }

    public function store(Request $request){
        
        $status     = "0";
        $message    = "";
        $o_data     = [];
        $errors     = [];
        $o_data['redirect'] = route('bookings.list');
        $rules = [];
        $rules['deligate'] = 'required';
        $rules['customer'] = 'required';
        $msg = [];
        //Trucking Vlidation
        if($request->deligate == 1 && $request->type == 'ftl'){
          
            $rules['collection_address_id'] = 'required';
            $rules['deliver_address_id'] = 'required';
            $rules['truck_type'] = 'required';
            $rules['quantity'] = 'required';
            $rules['gross_weight'] = 'required';
            $rules['company'] = 'required';
            $rules['shipping_method'] = 'required';
            $msg['company.required'] = "Select Driver";
            
        }
        elseif($request->deligate == 1 && $request->type == 'ltl'){
          
            $rules['item'] = 'required';
            $rules['no_of_packages'] = 'required';
            $rules['dimension_of_each_package'] = 'required';
            $rules['weight_of_each_package'] = 'required';
            $rules['total_gross_weight'] = 'required';
            $rules['total_volume_in_cbm'] = 'required';
            
        }

        //Air Freight
        if($request->deligate == 2){

            $rules['collection_address_id'] = 'required';
            $rules['deliver_address_id'] = 'required';
            $rules['truck_type'] = 'required';
            $rules['quantity'] = 'required';
            $rules['gross_weight'] = 'required';
            $rules['company'] = 'required';
            $rules['shipping_method'] = 'required';
            $rules['item'] = 'required';
            $rules['no_of_packages'] = 'required';
            $rules['dimension_of_each_package'] = 'required';
            $rules['weight_of_each_package'] = 'required';
            $rules['total_gross_weight'] = 'required';
            $rules['total_volume_in_cbm'] = 'required';
            $msg['company.required'] = "Select Driver";

        }

        //Warehousing
        if($request->deligate == 4){

            $rules['is_collection'] = 'required';
            if($request->is_collection == 1){
                $rules['collection_address_id'] = 'required';
                $rules['truck_type'] = 'required';
                $rules['quantity'] = 'required';
                $rules['gross_weight'] = 'required';
                $rules['company'] = 'required';
                $msg['company.required'] = "Select Driver";
            }
            $rules['item'] = 'required';
            $rules['types_of_storages'] = 'required';
            $rules['no_of_pallets'] = 'required';
            $rules['pallet_dimension'] = 'required';
            $rules['weight_per_pallet'] = 'required';
            $rules['total_weight'] = 'required';
            $rules['total_item_cost'] = 'required';

        }

        $validator = Validator::make($request->all(),$rules,$msg);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
            
        }
        else{

            $deligate = Deligate::where('slug','truck')->first();
            $collection_address = Address::find($request->collection_address_id);
            $deliver_address = Address::find($request->deliver_address_id);


            $booking = Booking::create([
                'is_collection' => isset($request->collection_address)?1:0,
                'collection_address' => $collection_address->address ?? '',
                'deliver_address' => $deliver_address->address ?? '',
                'collection_latitude' => $collection_address->latitude ?? '',
                'collection_longitude' => $collection_address->collection_longitude ?? '',
                'deliver_latitude' => $deliver_address->latitude ?? '',
                'deliver_longitude' => $deliver_address->longitude ?? '',
                'sender_id' => $request->customer,
                'deligate_id' => $request->deligate,
                'deligate_type' => $request->type ?? '',
                'shipping_method_id' => $request->shipping_method ?? '',
                'invoice_number' => $request->invoice_number ?? '',
                'admin_response' => ($request->deligate == 4 && isset($request->is_collection) && $request->is_collection ==0)?'approved_by_admin':'ask_for_qoute',
                'status' => 'pending',
                'collection_address_id' => $request->collection_address_id ?? 0,
                'deliver_address_id' => $request->deliver_address_id ?? 0,
            ]);

            if(!empty($booking)){
                $booking_number = sprintf("%06d", $booking->id);
                $booking->booking_number = "#TX-".$booking_number;
                $booking->save();

                if($booking->status == 'pending'){
                    $status_booking = 'request_created';
                }
                else{
                    $status_booking = $booking->status;
                }
                if(!empty($booking) && count($request->truck_type) > 0){
                    
                } else { 
                    BookingStatusTracking::updateOrCreate(['booking_id' => $booking->id,'status_tracking' => $status_booking],['status_tracking' => $status_booking],['created_at' => gmdate('Y-m-d H:i:s')]);
                }
            }

            // if trucking have LTL
            if(!empty($booking) && ($booking->deligate_id == 1 && $booking->deligate_type == 'ltl')){
                $booking_deligate_detail = new BookingDeligateDetail();
                $booking_deligate_detail->booking_id = $booking->id;
                $booking_deligate_detail->item = $request->item;
                $booking_deligate_detail->no_of_packages = $request->no_of_packages;
                $booking_deligate_detail->dimension_of_each_package = $request->dimension_of_each_package;
                $booking_deligate_detail->weight_of_each_package = $request->weight_of_each_package;
                $booking_deligate_detail->total_gross_weight = $request->total_gross_weight;
                $booking_deligate_detail->total_volume_in_cbm = $request->total_volume_in_cbm;
                $booking_deligate_detail->save();
            }

            // if Air Freight
            if(!empty($booking) && ($booking->deligate_id == 2)){
                $booking_deligate_detail = new BookingDeligateDetail();
                $booking_deligate_detail->booking_id = $booking->id;
                $booking_deligate_detail->item = $request->item;
                $booking_deligate_detail->no_of_packages = $request->no_of_packages;
                $booking_deligate_detail->dimension_of_each_package = $request->dimension_of_each_package;
                $booking_deligate_detail->weight_of_each_package = $request->weight_of_each_package;
                $booking_deligate_detail->total_gross_weight = $request->total_gross_weight;
                $booking_deligate_detail->total_volume_in_cbm = $request->total_volume_in_cbm;
                $booking_deligate_detail->save();
            }

            // if Warehousing
            if(!empty($booking) && ($booking->deligate_id == 4)){
                $booking_deligate_detail = new WarehouseDetail();
                $booking_deligate_detail->booking_id = $booking->id;
                $booking_deligate_detail->item = $request->item;
                $booking_deligate_detail->type_of_storage = $request->types_of_storages;
                $booking_deligate_detail->items_are_stockable = $request->items_are_stockable;
                $booking_deligate_detail->no_of_pallets = $request->no_of_pallets;
                $booking_deligate_detail->weight_per_pallet = $request->weight_per_pallet;
                $booking_deligate_detail->pallet_dimension = $request->pallet_dimension;
                $booking_deligate_detail->total_weight = $request->total_weight;
                $booking_deligate_detail->total_item_cost = $request->total_item_cost;
                $booking_deligate_detail->save();
            }
            
            if(!empty($booking) && count($request->truck_type) > 0){
                
                foreach($request->truck_type as $key => $truck_type){
                    
                    if(isset($request->quantity[$key]) && isset($request->gross_weight[$key])){
                        $booking_truck = new BookingTruck();
                        $booking_truck->booking_id = $booking->id;
                        $booking_truck->truck_id = $truck_type;
                        $booking_truck->quantity = $request->quantity[$key];
                        $booking_truck->gross_weight = $request->gross_weight[$key];
                        $booking_truck->save();

                        if(!empty($booking_truck) && isset($request->company[$key])){
                            
                            foreach($request->company[$key] as $user_id){

                                if(User::where('id',$user_id)->where('role_id',2)->exists()){
                                    $booking_qoute = new BookingQoute();
                                    $booking_qoute->booking_id = $booking->id;
                                    $booking_qoute->booking_truck_id = $booking_truck->id;
                                    $booking_qoute->driver_id = $user_id;
                                    $booking_qoute->price = 0.00;
                                    $booking_qoute->hours = 0;
                                    $booking_qoute->status = 'pending';
                                    $booking_qoute->save();

                                    if($booking->status == 'pending'){
                                        $status_booking = 'request_created';
                                    }
                                    else{
                                        $status_booking = $booking->status;
                                    }
                                     BookingStatusTracking::updateOrCreate(['booking_id' => $booking->id,'status_tracking' => $status_booking],['status_tracking' => $status_booking,'driver_id'=>$user_id],['created_at' => gmdate('Y-m-d H:i:s')]);
                                }

                                $user = User::find($user_id);
                                $booking_truck_alot = new BookingTruckAlot();
                                $booking_truck_alot->booking_truck_id = $booking_truck->id;
                                $booking_truck_alot->user_id = $user->id;
                                $booking_truck_alot->role_id = $user->role_id;
                                $booking_truck_alot->save();
                                
                                $data['driver'] = $user;
                                $data['booking'] = $booking;
                                if(env('MAILS_ENABLE')){
                                    //Mail::to($data['driver']->email)->send(new DriverRequestMail($data));
                                }
                            }
                        }

                    }
                    
                }
    
            }
            
            
            if(!empty($booking)){
                $data['user'] = User::find($booking->sender_id);
                $data['booking'] = $booking;
               if(env('MAILS_ENABLE')){
                    //Mail::to($data['user']->email)->send(new CustomerRequestMail($data));
                } 
            }

            if(!empty($booking)){
               
                $status = "1";
                $message = "Booking has been created successfully";
               
            }
            else
            {
                $status = "0";
                $message = "Booking could not be created";
            }   

        }

         echo json_encode(['status' => $status, 'errors' => $errors, 'message' => $message, 'oData' => $o_data]);
    }


    public function edit($id){
        $id = decrypt($id);
        $booking = Booking::find($id);
        if(empty($booking)){
            abort(404);
        }
        $deligate = Deligate::where('id',$booking->deligate_id)->first();
        $page_heading = "Edit Booking";
        $mode = "edit "." ".$booking->booking_number;
        $shipping_methods = ShippingMethod::where('status','active')->get();
    
        $companies = User::join('driver_details','driver_details.user_id','=','users.id')->where('role_id',2)->where('users.status','active')->get();     
        
        $customers = User::where('status','active')->where('role_id',3)->get();
        $trucks = TruckType::where('status','active')->get();
        $containers = Container::where('status','active')->get();
        $deligates = Deligate::where('status','active')->get();
        $selected_drivers = $booking->booking_qoutes->pluck('driver_id')->toArray();

        $view = '';
        if($booking->deligate_id == 1){
            $page_heading = "Edit ".$deligate->name;
            $view = 'admin.bookings.edit_trucking';
        }
        elseif($booking->deligate_id == 2){
            $page_heading = "Edit ".$deligate->name;
            $view = 'admin.bookings.edit_air_freight';
        }elseif($booking->deligate_id == 3){
            $page_heading = "Edit ".$deligate->name;
            $view = 'admin.bookings.edit_sea_freight';
        }
        elseif($booking->deligate_id == 4){
            $page_heading = "Edit ".$deligate->name;
            $view = 'admin.bookings.edit_warehouse_detail';
        }else{
            abort(404);
        }

        return view($view,compact('customers','page_heading','mode','trucks','booking','companies','selected_drivers','deligate','shipping_methods','deligates','containers'));

    }


    public function view($id){
        $id = decrypt($id);
        $booking = Booking::find($id);
        $deligate = Deligate::where('id',$booking->deligate_id)->first();
        $shipping_methods = ShippingMethod::where('status','active')->get();
        $page_heading = "Booking Details";
        $mode = "view";
        $drivers = User::where('status','active')->where('role_id',2)->get();
        $customers = User::where('status','active')->where('role_id',3)->get();
        
        $individual_drivers = DriverDetail::where('is_company','no')->groupBy('user_id')->pluck('user_id')->toArray();
        $drivers_companies = DriverDetail::where('is_company','yes')->groupBy('company_id')->pluck('company_id')->toArray();
        $user_ids = array_merge($individual_drivers,$drivers_companies);
        $companies = User::whereIn('id',$user_ids)->where('status','active')->get();

        $trucks = TruckType::where('status','active')->get();
        $containers = Container::where('status','active')->get();
        $selected_drivers = $booking->booking_qoutes->pluck('driver_id')->toArray();
        $accepetdqoaute = AcceptedQoute::where('booking_id',$id)->first();
        
        $view = '';
        if($booking->deligate_id == 1){
            $page_heading = "View ".$deligate->name;
            $view = 'admin.bookings.trucking_detail';
        }
        elseif($booking->deligate_id == 2){
            $page_heading = "View ".$deligate->name;
            $view = 'admin.bookings.airfreight_detail';
        }
        elseif($booking->deligate_id == 4){
            $page_heading = "View ".$deligate->name;
            $view = 'admin.bookings.warehouse_detail';
        }else if($booking->deligate_id == 3){
            $page_heading = "View ".$deligate->name;
            $view = 'admin.bookings.seafright';
        }
        //echo $view; exit;

        return view($view,compact('customers','page_heading','mode','trucks','booking','drivers','selected_drivers','deligate','accepetdqoaute','shipping_methods','companies','containers'));

    }


     public function update(Request $request,$id){
        
        $status     = "0";
        $message    = "";
        $o_data     = [];
        $errors     = [];
        $o_data['redirect'] = route('bookings.list');
        $rules = [
            'customer' => 'required',
//            'truck_type' => 'required',
//            'drivers' => 'required',
            'shipping_method' => 'required',
            'quantity' => 'required',
            'dial_code' => 'required',
            'collection_address' => 'required',
            'deliver_address' => 'required',
            'receiver_name' => 'required',
            'receiver_email' => 'required',
            'receiver_phone' => 'required',
        ];

        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
            
        }
        else{
            $booking_number = sprintf("%06d", $id);
            $booking = Booking::where('id',$id)->update([
                'collection_address' => $request->collection_address,
                'deliver_address' => $request->deliver_address,
                'sender_id' => $request->customer,
                'receiver_name' => $request->receiver_name,
                'receiver_email'=> $request->receiver_email,
                'receiver_phone' => ($request->dial_code." ".$request->receiver_phone),
                'shipping_method_id' => $request->shipping_method,
                'invoice_number' => $request->invoice_number,
                'truck_type_id' => $request->truck_type,
                'quantity' => $request->quantity,
                'delivery_note' => $request->delivery_note,
                'booking_number' => "#TX-".$booking_number
            ]);

            
            if(!empty($booking) && ($request->drivers != null && count($request->drivers) > 0)){
                
                Booking::where('id',$id)->update([
                    'admin_response' => 'ask_for_qoute',
                ]);
                foreach($request->drivers as $driver){
                    
                    $booking_qoute = new BookingQoute();
                    $booking_qoute->booking_id = $id;
                    $booking_qoute->driver_id = $driver;
                    $booking_qoute->price = 0.00;
                    $booking_qoute->hours = 0;
                    $booking_qoute->status = 'pending';
                    $booking_qoute->save(); 
                    $data['driver'] = User::find($booking_qoute->driver_id);
                    $data['booking'] = $booking;
                    if(env('MAILS_ENABLE')){
                        Mail::to($data['driver']->email)->send(new DriverRequestMail($data));
                    }
                }
    
             }
            /////////


            if(!empty($booking)){
                $booking = Booking::find($id);
                $data['user'] = User::find($booking->sender_id);
                $data['booking'] = $booking;
               if(env('MAILS_ENABLE')){
                    Mail::to($data['user']->email)->send(new CustomerRequestUpdateMail($data));
                } 
            }

            if(!empty($booking)){
               
                $status = "1";
                $message = "Booking has been updated successfully";
               
            }
            else
            {
                $status = "0";
                $message = "Booking could not be updated";
            }   

        }

         echo json_encode(['status' => $status, 'errors' => $errors, 'message' => $message, 'oData' => $o_data]);
    }


    public function get_drivers(Request $request){

        $truck_id = $request->truck_id;
        $companies_ids = DriverDetail::where('truck_type_id',$truck_id)->where('is_company','yes')->pluck('company_id')->toArray();
        $individual_ids = DriverDetail::where('truck_type_id',$truck_id)->where('is_company','no')->pluck('user_id')->toArray();

        $user_ids = array_merge($companies_ids,$individual_ids);
        
        $drivers = User::join('driver_details','driver_details.user_id','=','users.id')->where('role_id',2)->where('truck_type_id',$truck_id)->where('users.status','active')->get();

        $options = view('admin.bookings.drivers',compact('drivers'))->render();
        return response()->json(['options' => $options],200);        
    }

    public function getbookingList(Request $request){

        $sqlBuilder = Booking::join('users as customers','customers.id','=','bookings.sender_id')->join('deligates','deligates.id','=','bookings.deligate_id')->select([
            'bookings.id as id',
            'bookings.booking_number as booking_number',
            'bookings.deligate_type as deligate_type',
            'bookings.is_collection as is_collection',
            'customers.name as customer_name',
            'deligates.name as deligate_name',
            'deligates.id as deligate_id',
            'bookings.admin_response as admin_response',
            'bookings.status as booking_status', 
            'bookings.is_paid as is_paid',
            'bookings.created_at as created_at',
        ])->orderBy('bookings.id','DESC');//
        if(isset($request->status)) {
            $statuses = ['on_process','cancelled','completed'];
            if(($request->status=='completed' || $request->status=='cancelled' )) {
                $sqlBuilder = $sqlBuilder ->where('bookings.status',$request->status);
            }
            else if(in_array($request->status,$statuses)) {
                $sqlBuilder = $sqlBuilder ->where('bookings.status',$request->status)->where('bookings.admin_response','approved_by_admin');
            } else {
                
                    $sqlBuilder = $sqlBuilder ->where('bookings.admin_response',$request->status)->where('bookings.status','pending');
                
            }
        }
        if(isset($request->user) && $request->user!='') { //echo $request->search['value'];
            $sqlBuilder = $sqlBuilder ->where('customers.name','ilike','%'.$request->user.'%');
        }
        if(isset($request->payment_status)) {
            $sqlBuilder = $sqlBuilder ->where('bookings.is_paid',$request->payment_status);
        }
        if(isset($request->created_date)) {
            $sqlBuilder = $sqlBuilder ->whereDate('bookings.created_at',date('Y-m-d',strtotime($request->created_date)) );
        }
        $dt = new Datatables(new LaravelAdapter);

        $dt->query($sqlBuilder);

        $dt->edit('booking_number', function ($data) {
            $html = '';
            $html .= $data['booking_number'];

            $status = '';
            $status_color = '';
            if($data['is_paid'] == 'no'){
                $status = 'UNPAID';
                $status_color = 'danger';
            }
            else if($data['is_paid'] == 'yes'){
                $status = 'PAID';
                $status_color = 'info';
            }

            $statuses = ['unpaid','paid'];

            $html .= '<br />';

            $html .= '<span class="badge badge-'.$status_color.'">'.$status.'</span>';
 
            return $html;

            return $html;
        });    

        $dt->edit('created_at', function ($data) {
            return (new Carbon($data['created_at']))->format('d/m/y h:i A');
        });

        $dt->add('customer_name', function ($data) {
            return $data['customer_name'];
        });


        $dt->edit('deligate_name', function ($data) {
            $html = '';
            $html .= '<strong>'.$data['deligate_name'];
            if($data['deligate_type']){
                $html .= '<br />';
                $html .= '<small>('.strtoupper($data['deligate_type']).')</small>';
            }
            $html .= '</strong>';
            return $html;
        });

        // $dt->edit('total_amount', function ($data) {
        //     return (number_format($data['total_amount'],2) ?? number_format(0));
        // });


        $dt->edit('is_paid', function ($data) {
            $status = '';
            $status_color = '';
            if($data['is_paid'] == 'no'){
                $status = 'UNPAID';
                $status_color = 'danger';
            }
            else if($data['is_paid'] == 'yes'){
                $status = 'PAID';
                $status_color = 'info';
            }

            $statuses = ['unpaid','paid'];

            $html = '';

            $html = '<span class="badge badge-'.$status_color.'">'.$status.'</span>';
 
            return $html;
        });

        $dt->edit('booking_status', function ($data) {
            $html = get_booking_status($data['admin_response'],$data['booking_status']); 
            return $html;
        });


        $dt->add('action', function ($data) {
            $html = '<div class="dropdown custom-dropdown">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink7"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <i class="flaticon-dot-three"></i>
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink7">';
            if (get_user_permission('bookings', 'v')) {
                
                $html .= '<a class="dropdown-item"
                        href="' . route('bookings.view', ['id' => encrypt($data['id'])]) . '"><i
                            class="bx bx-show"></i> View</a>';
            }
           if (get_user_permission('bookings', 'u')) {
               $html .= '<a class="dropdown-item"
                       href="' . route('bookings.edit', ['id' => encrypt($data['id'])]) . '"><i
                           class="flaticon-pencil-1"></i> Edit</a>';

               if($data['deligate_id'] != 4 && $data['deligate_id'] != 3 &&  $data['deligate_id'] != 2 ){            
                    $html .= '<a class="dropdown-item"
                        href="' . route('booking.qoutes', ['id' => encrypt($data['id'])]) . '"><i
                    class="bx bxs-truck"></i> Driver Quotes </a>';
                }

            //    $html .= '<a class="dropdown-item add-charges" href = "javascript::void(0)" data-id = "'.$data['id'].'"  
            //        ><i class="fa-solid fa-sack-dollar"></i></i> Add Charges</a>';

               $html .= '<a class="dropdown-item add-payment" href = "javascript::void(0)" data-id = "'.$data['id'].'"  
                   ><i class="fa-solid fa-sack-dollar"></i></i> Add Payment</a>';    
           }
            $html .= '</div>
            </div>';
            return $html;
        });

        return $dt->generate();

    }

    public function change_status($id,$status){
        $deligate_status = [
            'collected_from_shipper',
            'cargo_cleared_at_origin_border',
            'cargo_tracking',
            'cargo_reached_destination_border',
            'cargo_cleared_destination_customs',
            'delivery_completed',
            'completed',


            'items_received_in_warehouse',
            'items_stored',

        ];
        $booking = Booking::with('booking_qoutes')->find($id);
        $qoute = $booking->booking_qoutes->first();
        if(in_array($status, $deligate_status) && $qoute){
            if($status != null){
                DB::table('booking_status_trackings')->updateOrInsert(
                    [
                        'booking_id' => $booking->id,
                        'driver_id'  => $qoute->driver_id,
                        'status_tracking' => $status,
                    ],
                    [
                        'status_tracking' => $status,
                        'statuscode' => config('global.'.$status),
                        'quote_id'=>$qoute->id,
                        'created_at' => time_to_uae(gmdate('Y-m-d H:i:s')),//gmdate('Y-m-d H:i:s'),
                        'updated_at' => time_to_uae(gmdate('Y-m-d H:i:s'))//gmdate('Y-m-d H:i:s'),
                    ]
                );
                if($status =='delivery_completed' ) {
                    Booking::where('id',$id)->update(['status' => $status,'admin_response'=>'approved_by_admin']);
                    $bool = AcceptedQoute::where('booking_id',$id)
                    ->where('driver_id',$qoute->driver_id)->update([
                        'status' => 'delivered',
                        'statuscode' => '9',
                    ]);

                } else {
                    Booking::where('id',$id)->update(['status' => $status]);
                }
            }
        }
        else{
            if($status =='on_process' || $status =='completed' ) {
                Booking::where('id',$id)->update(['status' => $status,'admin_response'=>'approved_by_admin']);
            } else {
                Booking::where('id',$id)->update(['status' => $status]);
            }
        }
        // dd($booking,$status,config('global.qoute_status_names.'.'4'));
        // if($booking){

        // }
       
        // if (config('global.server_mode') == 'local') {
            // \Artisan::call('user_booking:user ' . $id);
        // } else { 
            exec("php " . base_path() . "/artisan user_booking:user " . $id . " > /dev/null 2>&1 & ");
        // }
        return redirect()->back();
    }

    public function payment_status($id,$status){
        
        Booking::where('id',$id)->update(['is_paid' => ($status == 'paid')?'yes':'no']);
        return redirect()->back();
        
    }

    public function booking_qoutes($id){
        $id = decrypt($id);

        $booking = Booking::find($id);
        $page_heading = "Bookings Quotes against booking ".$booking->booking_number;
        $mode = "List";
        $exist_drivers = $booking->booking_qoutes->pluck('driver_id')->toArray();
        
        $drivers = User::join('driver_details' ,'driver_details.user_id','=','users.id')->where('truck_type_id',$booking->truck_type_id)->whereNotIn('users.id',$exist_drivers)->where('users.status','active')->select('users.*')->get();
        $truck = TruckType::find($booking->truck_type_id);
        $trucks = TruckType::where('status','active')->get();
        
        return view('admin.bookings.qoutes', compact('mode', 'page_heading','id','drivers','truck','booking','trucks'));
    }

    public function getBookingQouteList($id){
        
        $sqlBuilder = BookingQoute::join('users as drivers','drivers.id','=','booking_qoutes.driver_id')
            ->join('driver_details','drivers.id','=','driver_details.user_id')
            ->join('truck_types','truck_types.id','=','driver_details.truck_type_id')
            ->join('bookings','bookings.id','=','booking_qoutes.booking_id')
            ->select([
            'booking_qoutes.id as id',
            'booking_qoutes.booking_id as booking_id',
            'booking_qoutes.price as quoteprice',
            'booking_qoutes.hours as quotehours',
            'drivers.name as driver_name',
            'truck_types.truck_type as truck_type',
            'driver_details.is_company as is_company',
            'booking_qoutes.price as qouted_amount',
            'booking_qoutes.hours as hours',
            'booking_qoutes.status as qoute_status',
            'booking_qoutes.comission_amount as comission_amount',
            'booking_qoutes.created_at as created_at',
            'booking_qoutes.is_admin_approved as is_admin_approved',
            'bookings.collection_address',
            'bookings.deliver_address'
        ])->where('booking_qoutes.booking_id',$id)->orderBy('booking_qoutes.price','ASC');

        $dt = new Datatables(new LaravelAdapter);
        $dt->query($sqlBuilder); 

        $dt->edit('driver_name', function ($data) {
            $html = '';
            $html .= '<span>';
            $html .= $data['driver_name'];
            if($data['is_company'] == 'yes'){
                $html .= ' (Company)';
            }else{
                $html .= ' (Individual)';
            }   
            $html .= '</span>';    
            return $html;
        });

        $dt->edit('qouted_amount', function ($data) {
            return $data['qouted_amount'] ?? 0.00;
        });
        $dt->edit('created_at', function ($data) {
            return date('d/M/Y H:i:s',strtotime($data['created_at']));
        });

        $dt->edit('comission_amount', function ($data) {
            return $data['comission_amount'] ?? 0.00;
        });

        $dt->edit('qoute_status', function ($data) {
            $status = '';
            if($data['qoute_status'] == 'pending'){
                $status = '<span class="badge badge-secondary">PENDING</span>';
            }
            else if($data['qoute_status'] == 'qouted'){

                $status = '<span class="badge badge-success">QUOTED</span>';
            }
            else if($data['qoute_status'] == 'accepted'){
                $status = '<span class="badge badge-info">ACCEPTED</span>';
            }
            else if($data['qoute_status'] == 'rejected'){
                $status = '<span class="badge badge-primary">REJECTED</span>';
            }
            return $status;
        });


        $dt->add('check_all', function ($data) {
            if($data['qoute_status'] == 'qouted'){

                if($data['is_admin_approved'] == 'yes'){
                    $html = '<input type = "checkbox" name = "ids[]" value = "'.$data['id'].'" class = "checked" checked = "checked" onclick="this.checked=!this.checked;">';
                }else{
                    $html = '<input type = "checkbox" name = "ids[]" value = "'.$data['id'].'" class = "check_all">';
                }

            }else{
                $html = '<input type = "checkbox" name = "ids[]" value = "" disabled = "disabled">';
            }
            
            return $html;
        });


        $dt->add('action', function ($data) {
            $html = '<div class="dropdown custom-dropdown">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink7"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <i class="flaticon-dot-three"></i>
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink7">';
        
           if (get_user_permission('bookings', 'u')) {

               $html .= '<a class="dropdown-item add-commission d-none" data-toggle="modal" data-target="#commission-modal" data-id = "'.$data['id'].'" data-commission = "'.$data['comission_amount'].'"   
                   ><i class="fa-solid fa-sack-dollar"></i></i> Add Commission</a>
                   <a class="dropdown-item add-quote" data-toggle="modal" data-target="#quote-modal" data-id = "'.$data['id'].'" data-price = "'.$data['quoteprice'].'"  data-hours = "'.$data['quotehours'].'"  
                   ><i class="fa-solid fa-sack-dollar"></i></i> Update Quote</a>';    
           }
            $html .= '</div>
            </div>';
            return $html;
        });

        return $dt->generate();
    }


    public function approve_qoutes(Request $request){
                
        $status     = "0";
        $message    = "";
        $o_data     = [];
        $errors     = [];
        $o_data['redirect'] = route('bookings.list');
        $rules = [
            'ids' => 'required',
            'booking_id' => 'required'
        ];

        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        } 
        else{

            $bool = BookingQoute::whereIn('id',$request->ids)->update(['is_admin_approved' => 'yes']);
            
            if($bool){
                $bool = BookingQoute::whereIn('id',$request->ids)->get()->first();
                $booking_bool = Booking::where('id',$request->booking_id)->update(['status' => 'qoutes_received','statuscode'=>config('global.qoutes_received'),'admin_response' => 'approved_by_admin']);

                if($booking_bool){
                    $booking = Booking::find($request->booking_id);
                    $data['user'] = User::find($booking->sender_id);
                    /*$obj =  new \App\Models\AcceptedQoute();
                    $obj->booking_id = $booking->id;
                    $obj->driver_id = $bool->driver_id;
                    $obj->hours = $bool->hours;
                    $obj->qouted_amount = $bool->price;
                    $obj->commission_amount = $booking->comission_amount;
                    $obj->total_amount = $obj->qouted_amount+$obj->commission_amount;
                    $obj->created_at = gmdate('Y-m-d H:i:s');
                    $obj->status = "accepted";
                    $obj->save();*/

                    $data['booking'] = $booking;
                    if(env('MAILS_ENABLE')){
                        Mail::to($data['user']->email)->send(new DriverQoutedRequest($data));
                    }

                    //Customer Notification
                    if (config('global.server_mode') == 'local') {
                        \Artisan::call('customer_quote_received:customer ' . $booking->id);
    
                    } else { 
                        exec("php " . base_path() . "/artisan customer_quote_received:customer " . $booking->id . " > /dev/null 2>&1 & ");
                    }

                    $status     = "1";
                    $message    = "The Following Qoutes have been approved and sent to customer";

                }
                else{
                    $status     = "0";
                    $message    = "Sorry The Following Qoutes could not approved";     
                }

            }
            else{
                $status     = "0";
                $message    = "Sorry The Following Qoutes could not approved";   
            }
        }

         echo json_encode(['status' => $status, 'errors' => $errors, 'message' => $message, 'oData' => $o_data]);
    }

    public function add_commission(Request $request){
                
        $html = '';
        $status     = "0";
        $message    = "";
        $o_data     = [];
        $errors     = [];
        $o_data['redirect'] = '';
        $rules = [
            'commission_amount' => 'required',
            'booking_id' => 'required'
        ];

        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        } 
        else{
            
            $booking = Booking::find($request->booking_id);
            $booking->comission_amount = $request->commission_amount;
            $booking->save();

            $total_amount = get_total_calculate($booking->qouted_amount,$booking->comission_amount);
            $booking->total_amount = $total_amount;
            $booking->save();

            if($booking){

                $status     = "1";
                $message    = "The commission amount has been added to the booking";

                $html .= (number_format($request->commission_amount,2) ?? number_format(0));
                $html .= '<i data-id = "'.$request->booking_id.'" class = "edit-commission fa fa-pencil float-right"></i>';
            }
            else{
                $status     = "0";
                $message    = "Sorry! The following commission amount could not added";   
            }

        }
        echo json_encode(['status' => $status, 'errors' => $errors, 'message' => $message, 'oData' => $o_data,'html' => $html]);
    }
    

    public function assign_drvivers(Request $request,$id){

        $status     = "0";
        $message    = "";
        $o_data     = [];
        $errors     = [];
        $o_data['redirect'] = '';
        $rules = [
            'drivers' => 'required'
        ];

        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
            
        }
        else{

            $booking = Booking::find($id);
            $booking->admin_response = 'ask_for_qoute';
            $booking->save();

            if(!empty($booking) && count($request->truck_type) > 0){
                
                foreach($request->truck_type as $key => $truck_type){
                    
                    if(isset($request->quantity[$key]) && isset($request->gross_weight[$key])){
                        
                        $booking_id = $booking->id;
                        $truck_id = $truck_type;
                        $quantity = $request->quantity[$key];
                        $gross_weight = $request->gross_weight[$key];
                        
                        $booking_truck = BookingTruck::updateOrCreate(
                            ['booking_id' => $booking_id, 'truck_id' => $truck_id],
                            ['quantity' => $quantity, 'gross_weight' => $gross_weight]
                        );

                        if(!empty($booking_truck) && isset($request->drivers[$key])){
                            
                            foreach($request->drivers[$key] as $user_id){

                                if(User::where('id',$user_id)->where('role_id',2)->exists()){
                                    $booking_qoute = new BookingQoute();
                                    $booking_qoute->booking_id = $booking->id;
                                    $booking_qoute->booking_truck_id = $booking_truck->id;
                                    $booking_qoute->driver_id = $user_id;
                                    $booking_qoute->price = 0.00;
                                    $booking_qoute->hours = 0;
                                    $booking_qoute->status = 'pending';
                                    $booking_qoute->save();
                                }

                                $user = User::find($user_id);
                                $booking_truck_alot = new BookingTruckAlot();
                                $booking_truck_alot->booking_truck_id = $booking_truck->id;
                                $booking_truck_alot->user_id = $user->id;
                                $booking_truck_alot->role_id = $user->role_id;
                                $booking_truck_alot->save();
                                
                                $data['driver'] = $user;
                                $data['booking'] = $booking;
                                if (config('global.server_mode') == 'local') {
                                    \Artisan::call('new:driverbooking ' . $booking_qoute->id);
                                } else { 
                                    exec("php " . base_path() . "/artisan new:driverbooking " . $booking_qoute->id . " > /dev/null 2>&1 & ");
                                }
                                /*if(env('MAILS_ENABLE')){
                                    Mail::to($data['driver']->email)->send(new DriverRequestMail($data));
                                }*/
                            }
                        }

                    }
                    
                }
    
            }
            

            if(!empty($booking) && !empty($booking_qoute)){
               
                $status = "1";
                $message = "Drivers assigned successfully";
               
            }
            else
            {
                $status = "0";
                $message = "Drivers could not be assigned";
            }            

        }

        echo json_encode(['status' => $status, 'errors' => $errors, 'message' => $message, 'oData' => $o_data]);

    }    

    public function get_booking_charges(Request $request){

        $status     = "0";
        $message    = "";
        $o_data     = [];
        $errors     = [];
        $o_data['redirect'] = '';
    
        $booking = Booking::find($request->booking_id);
        
        if(empty($booking)){
            $status = "0";
            $o_data['html'] = "Booking Not Found";
        }else{
            $status = "1";
            $o_data['booking_number'] = $booking->booking_number;
            $o_data['html'] = view('admin.bookings.charges',compact('booking'))->render();     
        }        
        
        echo json_encode(['status' => $status, 'errors' => $errors, 'message' => $message, 'oData' => $o_data]);
    }


    public function add_booking_charges(Request $request){

        $status     = "0";
        $message    = "";
        $o_data     = [];
        $errors     = [];
        $o_data['redirect'] = '';
        $rules = [
            'booking_id'    => 'required',
            'qouted_amount' => 'required|numeric',
            'commission' => 'required|numeric',
            'shipping_charges' => 'required|numeric',
            'cost_of_truck' => 'required|numeric',
            'border_charges' => 'required|numeric',
            'custom_charges' => 'required|numeric',
            'waiting_charges' => 'required|numeric'
        ];

        
        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages(); 
        }
        else{

            $booking = Booking::find($request->booking_id);
        
            if(empty($booking)){
                $status = "0";
                $o_data['html'] = "Booking Not Found";
            }else{
                $status = "1";
                $booking->comission_amount = $request->commission;
                $booking->shipping_charges = $request->shipping_charges;
                $booking->cost_of_truck = $request->cost_of_truck;
                $booking->border_charges = $request->border_charges;
                $booking->custom_charges = $request->custom_charges;
                $booking->waiting_charges = $request->waiting_charges;
                $booking->save();

                for($i = 0;isset($request->charges_name[$i]) && isset($request->amount[$i]);$i++){
                    
                  $new_charge = new BookingAdditionalCharge();
                  $new_charge->booking_id = $booking->id;
                  $new_charge->charges_name = $request->charges_name[$i];
                  $new_charge->charges_amount = $request->amount[$i];
                  $new_charge->save();

                }

                if($request->old_charges_name != null && count($request->old_charges_name) > 0){
                    foreach($request->old_charges_name as $key => $value){
                        if(isset($request->old_charges_name[$key]) && isset($request->old_amount[$key])){
                            
                            $old_charge = BookingAdditionalCharge::find($key);
                            $old_charge->booking_id = $booking->id;
                            $old_charge->charges_name = $request->old_charges_name[$key];
                            $old_charge->charges_amount = $request->old_amount[$key];
                            $old_charge->save();     

                        }
                    }
                }
                $booking_additional_charges = BookingAdditionalCharge::where('booking_id',$booking->id)->sum('charges_amount');
                $total_amount = get_total_calculate($booking->qouted_amount,$booking->comission_amount);    
                $grand_total = ($total_amount + $booking->shipping_charges + $booking->cost_of_truck + $booking->border_charges + $booking->custom_charges + $booking->waiting_charges + $booking_additional_charges);
                
                $booking->total_amount = $grand_total;
                $booking->save();

                $o_data['html'] = view('admin.bookings.charges',compact('booking'))->render();
            }

        }
        
        echo json_encode(['status' => $status, 'errors' => $errors, 'message' => $message, 'oData' => $o_data]);

    }

    public function remove_booking_charges(Request $request){

        $status     = "0";
        $message    = "";
        $o_data     = [];
        $errors     = [];
        $o_data['redirect'] = '';
        $rules = [
            'id'    => 'required',
        ];

        
        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages(); 
        }
        else{

            $charges = BookingAdditionalCharge::find($request->id);
        
            if(empty($charges)){
                $status = "0";
                $o_data['html'] = "Booking Charges Not Found";
            }else{
                $status = "1";
                $charges->delete();    

                $booking = Booking::find($charges->booking_id);

                $booking_additional_charges = BookingAdditionalCharge::where('booking_id',$booking->id)->sum('charges_amount');
                $total_amount = get_total_calculate($booking->qouted_amount,$booking->comission_amount);    
                $grand_total = ($total_amount + $booking->shipping_charges + $booking->cost_of_truck + $booking->border_charges + $booking->custom_charges + $booking->waiting_charges + $booking_additional_charges);
                $booking->total_amount = $grand_total;
                $booking->save();

                $o_data['html'] = view('admin.bookings.charges',compact('booking'))->render();     
            }

        }
        
        echo json_encode(['status' => $status, 'errors' => $errors, 'message' => $message, 'oData' => $o_data]);

    }


    public function get_booking_payments(Request $request){

        $status     = "0";
        $message    = "";
        $o_data     = [];
        $errors     = [];
        $o_data['redirect'] = '';
    
        $booking = Booking::find($request->booking_id);
        
        if(empty($booking)){
            $status = "0";
            $o_data['html'] = "Booking Not Found";
        }else{
            $status = "1";
            $o_data['booking_number'] = $booking->booking_number;
            $o_data['html'] = view('admin.bookings.payments',compact('booking'))->render();     
        }        
        
        echo json_encode(['status' => $status, 'errors' => $errors, 'message' => $message, 'oData' => $o_data]);
    }


    public function add_booking_payments(Request $request){

        $status     = "0";
        $message    = "";
        $o_data     = [];
        $errors     = [];
        $o_data['redirect'] = '';
        $rules = [
            'booking_id'    => 'required',
            'received_amount' => 'required'
        ];

        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages(); 
        }
        else{

            $booking = Booking::find($request->booking_id);
        
            if(empty($booking)){
                $status = "0";
                $o_data['html'] = "Booking Not Found";
            }else{
                $status = "1";
                $booking->total_received_amount = $request->received_amount;
                if($booking->total_received_amount >= $booking->grand_total){
                    $booking->is_paid = 'yes';
                }else{
                    $booking->is_paid = 'no';
                }
                $booking->save();
                $o_data['html'] = view('admin.bookings.payments',compact('booking'))->render();
            }

        }
        
        echo json_encode(['status' => $status, 'errors' => $errors, 'message' => $message, 'oData' => $o_data]);

    }

    public function update_warehousing(Request $request,$id){
        
        $status     = "0";
        $message    = "";
        $o_data     = [];
        $errors     = [];
        $o_data['redirect'] = route('bookings.list');
        $rules = [];
        $rules['deligate'] = 'required';
        $rules['customer'] = 'required';
        $rules['is_collection'] = 'required';
        if($request->is_collection == 1){
            $rules['collection_address'] = 'required';
        }
        $rules['item'] = 'required';
        $rules['types_of_storages'] = 'required';
        $rules['no_of_pallets'] = 'required';
        $rules['pallet_dimension'] = 'required';
        $rules['weight_per_pallet'] = 'required';
        $rules['total_weight'] = 'required';
        $rules['total_item_cost'] = 'required'; 

        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
            
        }
        else{
                    
            $booking = Booking::where('id',$id)->update([
                'is_collection' => isset($request->collection_address)?1:0,
                'collection_address' => $request->collection_address ?? '',
                'deliver_address' => $request->deliver_address ?? '',
                'sender_id' => $request->customer,
                'deligate_id' => $request->deligate,
                'deligate_type' => $request->type ?? '',
                'shipping_method_id' => $request->shipping_method ?? '',
                'invoice_number' => $request->invoice_number ?? '',
            ]);

            $booking = Booking::find($id);
            $booking->rack = $request->rack;
            if($request->file("storage_picture") != null){
                $response = image_upload($request,'bookings','storage_picture');
                
                if($response['status']){
                    $booking->storage_picture = $response['link'];                        
                }
            }
                
            $booking->date_of_commencement = $request->date_of_commencement;
            $booking->date_of_return = $request->date_of_return;
            $booking->instructions = $request->instructions;
            $booking->save();

            if(\Auth::user()->role_id == 1){
                $booking_qoute = BookingQoute::where('booking_id',$booking->id)->where('driver_id',\Auth::user()->id)->first();
                if(!$booking_qoute){
                    $booking_qoute = new BookingQoute();
                    $booking_qoute->booking_id = $booking->id;
                    $booking_qoute->driver_id = \Auth::user()->id;
                    $booking_qoute->status = 'qouted';
                    $booking_qoute->is_admin_approved = 'yes';
                    $booking_qoute->created_at =  gmdate('d M Y h:i A');
                }
                if($booking_qoute->status != 'accepted'){
                    $booking_qoute->price = $request->price;
                    $booking_qoute->hours = $request->hours ?? 0;
                    $booking_qoute->comission_amount = $request->comission_amount ?? 0;
                    
                    $booking_qoute->updated_at =  gmdate('d M Y h:i A');
                    
                    $booking_qoute->save();
                    // dd($booking_qoute);
                    $booking->total_commission_amount = $booking_qoute->comission_amount;
                    $booking->status = 'qoutes_received';
                    $booking->admin_response = 'approved_by_admin';
                    $booking->save();
                    //Customer Notification
                    if (config('global.server_mode') == 'local') {
                        \Artisan::call('customer_quote_received:customer ' . $booking->id);
    
                    } else { 
                        exec("php " . base_path() . "/artisan customer_quote_received:customer " . $booking->id . " > /dev/null 2>&1 & ");
                    }
                }
            }

            // if Warehousing
            if(!empty($booking) && ($booking->deligate_id == 4)){
                $booking_deligate_detail = WarehouseDetail::where('booking_id',$id)->first();

                $booking_deligate_detail->booking_id            = $booking->id;
                $booking_deligate_detail->item                  = $request->item;
                $booking_deligate_detail->type_of_storage       = $request->types_of_storages;
                $booking_deligate_detail->items_are_stockable   = $request->items_are_stockable;
                $booking_deligate_detail->no_of_pallets         = $request->no_of_pallets;
                $booking_deligate_detail->weight_per_pallet     = str_replace('Kg', '',  $request->weight_per_pallet);
                $booking_deligate_detail->pallet_dimension      = $request->pallet_dimension;
                $booking_deligate_detail->total_weight          = $request->total_weight;
                $booking_deligate_detail->total_item_cost       = $request->total_item_cost;
                $booking_deligate_detail->save();
            }

            if(!empty($booking) && isset($request->truck_type) && count($request->truck_type) > 0){
                
                foreach($request->truck_type as $key => $truck_type){
                    
                    if(isset($request->quantity[$key]) && isset($request->gross_weight[$key])){
                        $booking_truck = new BookingTruck();
                        $booking_truck->booking_id = $booking->id;
                        $booking_truck->truck_id = $truck_type;
                        $booking_truck->quantity = $request->quantity[$key];
                        $booking_truck->gross_weight = $request->gross_weight[$key];
                        $booking_truck->save();

                        if(!empty($booking_truck) && isset($request->company[$key])){
                            
                            foreach($request->company[$key] as $user_id){

                                if(User::where('id',$user_id)->where('role_id',2)->exists()){
                                    $booking_qoute = new BookingQoute();
                                    $booking_qoute->booking_id = $booking->id;
                                    $booking_qoute->driver_id = $user_id;
                                    $booking_qoute->price = 0.00;
                                    $booking_qoute->hours = 0;
                                    $booking_qoute->status = 'pending';
                                    $booking_qoute->save();
                                }

                                $user = User::find($user_id);
                                $booking_truck_alot = new BookingTruckAlot();
                                $booking_truck_alot->booking_truck_id = $booking_truck->id;
                                $booking_truck_alot->user_id = $user->id;
                                $booking_truck_alot->role_id = $user->role_id;
                                $booking_truck_alot->save();
                                
                                $data['driver'] = $user;
                                $data['booking'] = $booking;
                                if(env('MAILS_ENABLE')){
                                    Mail::to($data['driver']->email)->send(new DriverRequestMail($data));
                                }
                            }
                        }

                    }
                    
                }
    
            }

            if(!empty($booking)){
               
                $status = "1";
                $message = "Warehousing Booking has been updated successfully";
               
            }
            else
            {
                $status = "0";
                $message = "Warehousing Booking could not updated";
            }
        }

        echo json_encode(['status' => $status, 'errors' => $errors, 'message' => $message, 'oData' => $o_data]);
    }

    public function update_airfreight(Request $request,$id){
        
        $status     = "0";
        $message    = "";
        $o_data     = [];
        $errors     = [];
        $o_data['redirect'] = route('bookings.list');
        $rules = [];
        $rules['deligate'] = 'required';
        $rules['customer'] = 'required';
        $rules['collection_address'] = 'required';
        $rules['deliver_address'] = 'required';
        // $rules['truck_type'] = 'required';
        // $rules['quantity'] = 'required';
        // $rules['gross_weight'] = 'required';
        // $rules['company'] = 'required';
        $rules['shipping_method'] = 'required';
        $rules['item'] = 'required';
        $rules['no_of_packages'] = 'required';
        $rules['dimension_of_each_package'] = 'required';
        $rules['weight_of_each_package'] = 'required';
        $rules['total_gross_weight'] = 'required';
        $rules['total_volume_in_cbm'] = 'required'; 

        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
            
        }
        else{
                    
            $booking = Booking::where('id',$id)->update([
                'is_collection' => isset($request->collection_address)?1:0,
                'collection_address' => $request->collection_address ?? '',
                'deliver_address' => $request->deliver_address ?? '',
                'sender_id' => $request->customer,
                'deligate_id' => $request->deligate,
                'deligate_type' => $request->type ?? '',
                'shipping_method_id' => $request->shipping_method ?? '',
                'invoice_number' => $request->invoice_number ?? '',
            ]);

            $booking = Booking::find($id);

            //Air Freight
            if(!empty($booking) && ($booking->deligate_id == 2)){
                $booking_deligate_detail = BookingDeligateDetail::where('booking_id',$id)->first();
                $booking_deligate_detail->item = $request->item;
                $booking_deligate_detail->no_of_packages = $request->no_of_packages;
                $booking_deligate_detail->dimension_of_each_package = $request->dimension_of_each_package;
                $booking_deligate_detail->weight_of_each_package = $request->weight_of_each_package;
                $booking_deligate_detail->total_gross_weight = $request->total_gross_weight;
                $booking_deligate_detail->total_volume_in_cbm = $request->total_volume_in_cbm;
                $booking_deligate_detail->save();
            }
            if(\Auth::user()->role_id == 1){
                $booking_qoute = BookingQoute::where('booking_id',$booking->id)->where('driver_id',\Auth::user()->id)->first();
                if(!$booking_qoute){
                    $booking_qoute = new BookingQoute();
                    $booking_qoute->booking_id = $booking->id;
                    $booking_qoute->driver_id = \Auth::user()->id;
                    $booking_qoute->status = 'qouted';
                    $booking_qoute->is_admin_approved = 'yes';
                    $booking_qoute->created_at =  gmdate('d M Y h:i A');
                }
                if($booking_qoute->status != 'accepted'){
                    $booking_qoute->price = $request->price;
                    $booking_qoute->hours = $request->hours;
                    $booking_qoute->comission_amount = $request->comission_amount ?? 0;
                    
                    $booking_qoute->updated_at =  gmdate('d M Y h:i A');
                    
                    $booking_qoute->save();

                    $booking->total_commission_amount = $booking_qoute->comission_amount;
                    $booking->status = 'qoutes_received';
                    $booking->admin_response = 'approved_by_admin';
                    $booking->save();
                    //Customer Notification
                    if (config('global.server_mode') == 'local') {
                        \Artisan::call('customer_quote_received:customer ' . $booking->id);
    
                    } else { 
                        exec("php " . base_path() . "/artisan customer_quote_received:customer " . $booking->id . " > /dev/null 2>&1 & ");
                    }
                }
            }

            if(!empty($booking) && isset($request->truck_type) && count($request->truck_type) > 0){
                
                foreach($request->truck_type as $key => $truck_type){
                    
                    if(isset($request->quantity[$key]) && isset($request->gross_weight[$key])){
                        $booking_truck = new BookingTruck();
                        $booking_truck->booking_id = $booking->id;
                        $booking_truck->truck_id = $truck_type;
                        $booking_truck->quantity = $request->quantity[$key];
                        $booking_truck->gross_weight = $request->gross_weight[$key];
                        $booking_truck->save();

                        if(!empty($booking_truck) && isset($request->company[$key])){
                            
                            foreach($request->company[$key] as $user_id){

                                if(User::where('id',$user_id)->where('role_id',2)->exists()){
                                    $booking_qoute = new BookingQoute();
                                    $booking_qoute->booking_id = $booking->id;
                                    $booking_qoute->driver_id = $user_id;
                                    $booking_qoute->price = 0.00;
                                    $booking_qoute->hours = 0;
                                    $booking_qoute->status = 'pending';
                                    $booking_qoute->save();
                                }

                                $user = User::find($user_id);
                                $booking_truck_alot = new BookingTruckAlot();
                                $booking_truck_alot->booking_truck_id = $booking_truck->id;
                                $booking_truck_alot->user_id = $user->id;
                                $booking_truck_alot->role_id = $user->role_id;
                                $booking_truck_alot->save();
                                
                                $data['driver'] = $user;
                                $data['booking'] = $booking;
                                if(env('MAILS_ENABLE')){
                                    Mail::to($data['driver']->email)->send(new DriverRequestMail($data));
                                }
                            }
                        }

                    }
                    
                }
    
            }

            if(!empty($booking)){
               
                $status = "1";
                $message = "AirFreight Booking has been updated successfully";
               
            }
            else
            {
                $status = "0";
                $message = "AirFreight Booking could not updated";
            }
        }

        echo json_encode(['status' => $status, 'errors' => $errors, 'message' => $message, 'oData' => $o_data]);
    }

    public function update_trucking(Request $request,$id){
        
        $status     = "0";
        $message    = "";
        $o_data     = [];
        $errors     = [];
        $o_data['redirect'] = route('bookings.list');
        $rules = [];

        $rules['deligate'] = 'required';
        $rules['customer'] = 'required';

        //Trucking Vlidation
        if($request->deligate == 1 && $request->type == 'ftl'){
          
            $rules['collection_address'] = 'required';
            $rules['deliver_address'] = 'required';
            // $rules['truck_type'] = 'required';
            // $rules['quantity'] = 'required';
            // $rules['gross_weight'] = 'required';
            // $rules['company'] = 'required';
            $rules['shipping_method'] = 'required';
            
        }
        elseif($request->deligate == 1 && $request->type == 'ltl'){
          
            $rules['item'] = 'required';
            $rules['no_of_packages'] = 'required';
            $rules['dimension_of_each_package'] = 'required';
            $rules['weight_of_each_package'] = 'required';
            $rules['total_gross_weight'] = 'required';
            $rules['total_volume_in_cbm'] = 'required';
            $rules['num_of_pallets'] = 'required';
            
        }
            
        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
            
        }
        else{
            $booking = Booking::where('id',$id)->update([
                'is_collection' => isset($request->collection_address)?1:0,
                'collection_address' => $request->collection_address ?? '',
                'deliver_address' => $request->deliver_address ?? '',
                'sender_id' => $request->customer,
                'deligate_id' => $request->deligate,
                'deligate_type' => $request->type ?? '',
                'shipping_method_id' => $request->shipping_method ?? '',
                'invoice_number' => $request->invoice_number ?? '',
            ]);

            $booking = Booking::find($id);
            
            // if trucking have LTL
            if(!empty($booking) && ($booking->deligate_id == 1 && $booking->deligate_type == 'ltl')){
                $booking_deligate_detail = BookingDeligateDetail::where('booking_id',$id)->first();
                
                if(empty($booking_deligate_detail)){
                    $booking_deligate_detail = new BookingDeligateDetail();
                }

                $booking_deligate_detail->item = $request->item;
                $booking_deligate_detail->booking_id = $booking->id;
                $booking_deligate_detail->no_of_packages = $request->no_of_packages;
                $booking_deligate_detail->dimension_of_each_package = $request->dimension_of_each_package;
                $booking_deligate_detail->weight_of_each_package = $request->weight_of_each_package;
                $booking_deligate_detail->total_gross_weight = $request->total_gross_weight;
                $booking_deligate_detail->total_volume_in_cbm = $request->total_volume_in_cbm;
                $booking_deligate_detail->num_of_pallets = $request->num_of_pallets;
                $booking_deligate_detail->save();
            }
            else{
                BookingDeligateDetail::where('booking_id',$id)->delete();
            }
            if($booking && $booking->deligate_id == 3){
                if(\Auth::user()->role_id == 1){
                    $booking_qoute = BookingQoute::where('booking_id',$booking->id)->where('driver_id',\Auth::user()->id)->first();
                    if(!$booking_qoute){
                        $booking_qoute = new BookingQoute();
                        $booking_qoute->booking_id = $booking->id;
                        $booking_qoute->driver_id = \Auth::user()->id;
                        $booking_qoute->status = 'qouted';
                        $booking_qoute->is_admin_approved = 'yes';
                        $booking_qoute->created_at =  gmdate('d M Y h:i A');
                    }
                    if($booking_qoute->status != 'accepted'){
                        $booking_qoute->price = $request->price;
                        $booking_qoute->hours = $request->hours;
                        $booking_qoute->comission_amount = $request->comission_amount ?? 0;
                        
                        $booking_qoute->updated_at =  gmdate('d M Y h:i A');
                        
                        $booking_qoute->save();

                        $booking->total_commission_amount = $booking_qoute->comission_amount;
                        $booking->status = 'qoutes_received';
                        $booking->admin_response = 'approved_by_admin';
                        $booking->save();
                        //Customer Notification
                        if (config('global.server_mode') == 'local') {
                            \Artisan::call('customer_quote_received:customer ' . $booking->id);
        
                        } else { 
                            exec("php " . base_path() . "/artisan customer_quote_received:customer " . $booking->id . " > /dev/null 2>&1 & ");
                        }
                    }
                }
            }

            if(!empty($booking) && isset($request->truck_type) && count($request->truck_type) > 0){
                
                foreach($request->truck_type as $key => $truck_type){
                    
                    if(isset($request->quantity[$key]) && isset($request->gross_weight[$key])){
                        $booking_truck = new BookingTruck();
                        $booking_truck->booking_id = $booking->id;
                        $booking_truck->truck_id = $truck_type;
                        $booking_truck->quantity = $request->quantity[$key];
                        $booking_truck->gross_weight = $request->gross_weight[$key];
                        $booking_truck->save();

                        if(!empty($booking_truck) && isset($request->company[$key])){
                            
                            foreach($request->company[$key] as $user_id){

                                if(User::where('id',$user_id)->where('role_id',2)->exists()){
                                    $booking_qoute = new BookingQoute();
                                    $booking_qoute->booking_id = $booking->id;
                                    $booking_qoute->driver_id = $user_id;
                                    $booking_qoute->price = 0.00;
                                    $booking_qoute->hours = 0;
                                    $booking_qoute->status = 'pending';
                                    $booking_qoute->save();
                                }

                                $user = User::find($user_id);
                                $booking_truck_alot = new BookingTruckAlot();
                                $booking_truck_alot->booking_truck_id = $booking_truck->id;
                                $booking_truck_alot->user_id = $user->id;
                                $booking_truck_alot->role_id = $user->role_id;
                                $booking_truck_alot->save();
                                
                                $data['driver'] = $user;
                                $data['booking'] = $booking;
                                if(env('MAILS_ENABLE')){
                                    Mail::to($data['driver']->email)->send(new DriverRequestMail($data));
                                }
                            }
                        }

                    }
                    
                }
    
            }

            if(!empty($booking)){
               
                $status = "1";
                $message = "Booking has been updated successfully";
               
            }
            else
            {
                $status = "0";
                $message = "Booking could not updated";
            }
        }

        echo json_encode(['status' => $status, 'errors' => $errors, 'message' => $message, 'oData' => $o_data]);
    }

    public function add_qoutes_commission(Request $request){
        
        $status     = "0";
        $message    = "";
        $o_data     = [];
        $errors     = [];
        $o_data['redirect'] = '';
        $rules = [
            'commission_amount' => 'required|numeric',
            'qoute_id' => 'required',
        ];

        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        }
        else{
           $booking_id = BookingQoute::where('id',$request->qoute_id)->pluck('booking_id')->first(); 
           
           $qoute = BookingQoute::where('id',$request->qoute_id)->update(['comission_amount' => $request->commission_amount]);
           
           if(!empty($booking_id)){
            $amounts = [];
            $total_commission_amount = BookingQoute::where('booking_id',$booking_id)->sum('comission_amount');
            
            $booking = Booking::find($booking_id);
            $booking->total_commission_amount = $total_commission_amount;
            $booking->save();
            
            make_booking_total($booking->id);
           }
           

           if($qoute){
            $status = "1";
            $message = "Commission Amount added successfully";
           }else{
            $status = "0";
            $message = "Commission Amount could not added";
           }
        }    
        
        echo json_encode(['status' => $status, 'errors' => $errors, 'message' => $message, 'oData' => $o_data]);
    }

    public function add_update_qoutes(Request $request){
        
        $status     = "0";
        $message    = "";
        $o_data     = [];
        $errors     = [];
        $o_data['redirect'] = '';
        $rules = [
            'price' => 'required|numeric',
             'hours' => 'required|numeric',
            'qoute_id' => 'required',
        ];

        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        }
        else{
           $booking_id = BookingQoute::where('id',$request->qoute_id)->pluck('booking_id')->first(); 
           $booking = Booking::find($booking_id);
            
            if(empty($booking)){
               echo json_encode([
                    'status' => "0",
                    'error' => (object) array(),
                    'message' => 'No any request found',
                ]);    die();                 
            }
            $bool = BookingQoute::where('id',$request->qoute_id)
                    ->update([
                        'price' => $request->price,
                        'hours' => $request->hours,
                        'status' => 'qouted',
                        'statuscode' => config('global.qouted'),
                        'qouted_at' => time_to_uae(gmdate('Y-m-d h:i:s'))
                    ]);
            
            $booking->admin_response = 'driver_qouted';
            $booking->save();        
           

           if($bool){
            $status = "1";
            $message = "Quote Amount saved successfully";
           }else{
            $status = "0";
            $message = "Quote Amount could not saved";
           }
        }    
        
        echo json_encode(['status' => $status, 'errors' => $errors, 'message' => $message, 'oData' => $o_data]);
    }

    public function accept_qoutes(Request $request){
                
        $status     = "0";
        $message    = "";
        $o_data     = [];
        $errors     = [];
        $o_data['redirect'] = route('bookings.list');
        $rules = [
            'quote_ids' => 'required',
            'booking_id' => 'required'
        ];

        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        } 
        else{

            
            
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

         echo json_encode(['status' => $status, 'errors' => $errors, 'message' => $message, 'oData' => $o_data]);
    }
}
