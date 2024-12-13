<?php

namespace App\Http\Controllers\Api\v1\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company;
use App\Models\TruckType;
use App\Models\DriverDetail;
use App\Models\Booking;
use App\Models\BookingQoute;
use App\Models\Deligate;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\LaravelAdapter;
use DB;
use Carbon\Carbon;
use App\Mail\CustomerRequestMail;
use App\Mail\DriverRequestMail;
use App\Mail\DriverQoutedRequest;
use Mail;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $status     = "0";
        $message    = "";
        $o_data     = [];
        $errors     = [];
        
        $rules = [
            'customer' => 'required',
            'quantity' => 'required',
            'deligate_type' => 'required',
            'collection_address' => 'required',
            'deliver_address' => 'required',
            'receiver_name' => 'required',
            'receiver_email' => 'required',
            'receiver_phone' => 'required',
        ];

        if($request->deligate_type == 'truck'){
            $rule['truck_type'] = 'required';
        }
        $all = $request->all();
        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
            
        }
        else{

            $deligate_details = [];
               
               $deligate = Deligate::where('slug',$request->deligate_type)->first();
               
               if(!empty($deligate->deligate_attributes)){

                    foreach($deligate->deligate_attributes as $attribute){
                        if(isset($all[$attribute->name])){
                            $deligate_details[$attribute->name] = $all[$attribute->name];    
                        }
                    }
               }

            $booking = Booking::create([
                'collection_address' => $request->collection_address,
                'deliver_address' => $request->deliver_address,
                'sender_id' => $request->customer,
                'receiver_name' => $request->receiver_name,
                'receiver_email'=> $request->receiver_email,
                'receiver_phone' => $request->receiver_phone,
                'deligate_id' => $deligate->id,
                'deligate_details' => json_encode($deligate_details),
                'truck_type_id' => $request->truck_type ?? null,
                'quantity' => $request->quantity,
                'admin_response' => 'pending',
                'status' => 'pending',
            ]);


            if(!empty($booking)){
                $booking_number = sprintf("%06d", $booking->id);
                $booking->booking_number = "#TX-".$booking_number;
                $booking->save();
            }

            if(!empty($booking) && !empty($booking_qoute)){
                $data['user'] = User::find($booking->sender_id);
                $data['booking'] = $booking;
               if(env('MAILS_ENABLE')){
                    Mail::to($data['user']->email)->send(new CustomerRequestMail($data));
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function qoutes($id){
        $qoutes = Booking::join('booking_qoutes','booking_qoutes.booking_id','=','bookings.id')->join('users','booking_qoutes.driver_id','=','users.id')->where('admin_response','approved_by_admin')->where('booking_qoutes.is_admin_approved','yes')->get();
        dd($qoutes);

    }

    public function approve_qoute($id){
       
        $qoute = BookingQoute::find($id);
        $qoute->status = 'accepted';
        $qoute->save();
       
        BookingQoute::where('booking_id',$qoute->booking_id)->where('id','!=',$qoute->id)->update(['status' => 'rejected']);

        Booking::where('id',$qoute->booking_id)->update(['status' => 'accepted','driver_id' => $qoute->driver_id,'qouted_amount' => $qoute->price]);

             if(!empty($qoute)){
               
                $status = "1";
                $message = "The qoute has been accepted successfully";
               
            }
            else
            {
                $status = "0";
                $message = "Qoute could not be accepted";
            }

    }
}
