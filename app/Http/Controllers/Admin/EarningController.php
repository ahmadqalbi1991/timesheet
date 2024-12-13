<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company;
use App\Models\TruckType;
use App\Models\DriverDetail;
use App\Models\Booking;
use App\Models\Deligate;
use App\Models\BookingQoute;
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
use App\Mail\CustomerRequestUpdateMail;
use Mail;

class EarningController extends Controller
{
    public function index(REQUEST $request)
    {
        $page_heading = "Earnings";
        $mode = "List";
        return view('admin.earnings.list', compact('mode', 'page_heading'));
    }


    public function getearningList($from = null,$to = null){
        $data['from'] = $from;
        $data['to'] = $to;
        $sqlBuilder = Booking::join('users as customers','customers.id','=','bookings.sender_id')->join('deligates','deligates.id','=','bookings.deligate_id')
         ->join('accepted_qoutes','accepted_qoutes.booking_id','bookings.id')
        ->leftJoin('users as drivers','drivers.id','=','accepted_qoutes.driver_id')

        ->select([
            'bookings.id as id',
            'bookings.booking_number as booking_number',
            'customers.name as customer_name',
            'deligates.name as deligate_name',
            'deligates.id as deligate_id',
            'drivers.name as driver_name',
            'bookings.status as booking_status',
            'accepted_qoutes.qouted_amount as qouted_amount',
            'accepted_qoutes.total_amount as total_amount',
            'accepted_qoutes.commission_amount as comission_amount',
            'bookings.created_at as created_at',
        ])->where(function($query) use ($data){
            if(isset($data['from']) && isset($data['to'])){
                
                $query->whereBetween('bookings.created_at', [$data['from'], $data['to']]);    
            }
            
        })->orderBy('bookings.id','DESC')->where('accepted_qoutes.status','delivered')->where('bookings.is_paid','yes');
        $dt = new Datatables(new LaravelAdapter);

        $dt->query($sqlBuilder);


        $dt->edit('created_at', function ($data) {
            return (new Carbon($data['created_at']))->format('d/m/y h:i A');
        });

        $dt->edit('driver_name', function ($data) {
            return $data['driver_name'] ?? 'Not Approved Yet';
        });

        $dt->add('earned_amount', function ($data) {
            $earned_amount = get_earned_amount($data['qouted_amount'],$data['comission_amount']);
            return (number_format($earned_amount,2) ?? number_format(0));
        });

        $dt->edit('qouted_amount', function ($data) {
            return (number_format($data['qouted_amount'],3) ?? number_format(0));
        });

        $dt->edit('comission_amount', function ($data) {
            return $data['comission_amount']."%";
        });


        /*$dt->edit('booking_status', function ($data) {
           
            $status = '';
            $status_color = '';
            if($data['booking_status'] == 'pending'){
                $status = 'PENDING';
                $status_color = 'secondary';
            }
            else if($data['booking_status'] == 'qouted'){
                $status = 'QOUTED';
                $status_color = 'warning';
            }
            else if($data['booking_status'] == 'accepted'){
                $status = 'ACCEPTED';
                $status_color = 'success';
            }
            else if($data['booking_status'] == 'journey_started'){
                $status = 'JOURNEY STARTED';
                $status_color = 'info';
            }
            else if($data['booking_status'] == 'item_collected'){
                $status = 'ITEM COLLECTED';
                $status_color = 'info';
            }
            else if($data['booking_status'] == 'on_the_way'){
                $status = 'On THE WAY';
                $status_color = 'info';
            }
            else if($data['booking_status'] == 'border_crossing'){
                $status = 'BORDER CLEARNACE';
                $status_color = 'info';
            }
            else if($data['booking_status'] == 'custom_clearance'){
                $status = 'CUSTOM CLEARANCE';
                $status_color = 'info';
            }
            else if($data['booking_status'] == 'delivered'){
                $status = 'DELIVERED';
                $status_color = 'info';
            }
            
            $html = '';
            $html .= '<span class="badge badge-'.$status_color.'">'.$status; 
            $html .= '</span>';
            return $html;
           
        });*/


        $dt->add('action', function ($data) {
            $html = '<div class="dropdown custom-dropdown">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink7"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <i class="flaticon-dot-three"></i>
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink7">';
            if (get_user_permission('users', 'v')) {
                $html .= '<a class="dropdown-item"
                        href="' . route('bookings.view', ['id' => encrypt($data['id'])]) . '"><i
                            class="bx bx-show"></i> View</a>';
            }
           if (get_user_permission('users', 'u')  && $data['deligate_id'] == 1) {

               $html .= '<a class="dropdown-item"
                   href="' . route('booking.qoutes', ['id' => encrypt($data['id'])]) . '"><i
               class="bx bxs-truck"></i> Driver Qoutes</a>';
           }
            $html .= '</div>
            </div>';
            return $html;
        });

        return $dt->generate();

    }
}
