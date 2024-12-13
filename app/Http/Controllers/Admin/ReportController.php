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
use App\Models\Address;
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
use App\Exports\ExportReports;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\NamedRange;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use Maatwebsite\Excel\Facades\Excel;
use App\Classes\FPDFExtended;
use Mail;

class ReportController extends Controller
{
    public function jobs_in_transit(Request $request){
        $page_heading = "Reports";
        $mode = "Booking Reports";
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $bookings = Booking::whereNotIn('bookings.status',['pending','qouted','delivered','completed'])->join('accepted_qoutes','accepted_qoutes.booking_id','bookings.id')->where('bookings.status','on_process')
        ->join('users as customers','customers.id','bookings.sender_id')->join('users as driver','driver.id','accepted_qoutes.driver_id');
        if(isset($request->from_date)) {
            $bookings = $bookings->whereDate('bookings.created_at','>=',date('Y-m-d',strtotime($request->from_date)));
        }
        if(isset($request->to_date)) {
            $bookings = $bookings->whereDate('bookings.created_at','<=',date('Y-m-d',strtotime($request->to_date)));
        }
        $bookings = $bookings->orderBy('bookings.id','desc')->with(['driver','customer'])->select('bookings.id','bookings.booking_number','accepted_qoutes.qouted_amount','accepted_qoutes.total_amount','accepted_qoutes.commission_amount','bookings.status as booking_status','accepted_qoutes.status as status','driver.name as driver_name','customers.name as customer_name','bookings.created_at');
        
        if($request->excel == 'Export XLSX') {

            $bookings = $bookings->get();
            $rows = array();
            $i = 1;

            foreach ($bookings as $key => $booking) {

                $rows[$key]['i'] = $i;
                $rows[$key]['booking_number'] = $booking->booking_number??'';
                $rows[$key]['customer_name'] = ($booking->customer_name)??'-';
                $rows[$key]['driver_name'] = $booking->driver_name;
                $rows[$key]['amount'] = number_format($booking->qouted_amount,3);
                $rows[$key]['total_amount'] = $booking->total_amount;
                $rows[$key]['commission_amount'] = !empty($booking->commission_amount) ? $booking->commission_amount.'%' : '';
                $rows[$key]['status'] = get_driver_tracking_status($booking->status);
                // $rows[$key]['state'] = $val->state->name??'';
                // $rows[$key]['city'] = $val->city->name??'';
                $rows[$key]['created_date'] = date('d/m/y H:i A',strtotime($booking->created_at));
                $i++;
            }
            $headings = [
                "#",
                "Booking",
                "Customer Name",
                "Driver Name",
                "Quoted Amount",
                "Total Amount",
                "Commission %",
                "Booking Status",
                // "State",
                // "City",
                "Created Date",
            ];
            $coll = new ExportReports([$rows], $headings);
            $ex = Excel::download($coll, 'bookings_' . date('d_m_Y_h_i_s') . '.xlsx');
            if (ob_get_length()) ob_end_clean();
            return $ex;
            
        }
        else if($request->excel == 'Export Pdf') {

            $bookings = $bookings->get();
            $rows = array();
            $i = 1;

            $pdf = new FPDFExtended();
            $pdf->AddPage();
            $pdf->SetFont('Arial', '', 10);
            // Table with 20 rows and 4 columns
            $pdf->SetWidths(array(10, 55, 50, 41, 40));

            $pdf->Row(array("S.No", "Name",  "Email", "Mobile No", "Created"));

            foreach ($bookings as $key => $val) {

                $pdf->Row(
                    array(($key + 1), 
                    ($val->name != '')?$val->name:$val->first_name.' '.$val->last_name, 
                    ($val->email)??'-', 
                    ($val->dial_code!='')?$val->dial_code.' '.$val->phone:'-', 
                    date('d-m-Y h:i A',strtotime($val->created_at))
                ));

            }

            $pdf->Output('D', 'customers_' . date('d_m_Y_h_i_s') .".pdf");





        }
        else{

            if (isset($_GET['from'])) {
                $bookings = $bookings->paginate(500);
            }
            else
            {
                $bookings=$bookings->paginate(10);  
            }
            return view('admin.reports.jobs_in_transit', compact('mode', 'page_heading','bookings','from_date','to_date'));

            
        }

    }
     
    public function customers(REQUEST $request){
        $page_heading = "Customers";
        $from_date    = $request->from_date;
        $to_date      = $request->to_date;
        $list = User::select([
            DB::raw('name::text as name'),
            DB::raw('email::text as email'),
            DB::raw('dial_code::text as dial_code'),
            DB::raw('phone::text as phone'),
            DB::raw('status::text as status'),
            DB::raw('users.created_at::text as created_at'),
            DB::raw('users.id::text as id')
        ])->whereNotIn('users.id', function($query) {
            $query->select('user_id')
                  ->from('blacklists')
                  ->whereColumn('users.id','=','blacklists.user_id');
        })->where('role_id',3)->orderBy('users.created_at','desc');
        
        if($from_date != ''){
            $list = $list->whereDate('created_at','>=',date('Y-m-d',strtotime($from_date)));
        }
        if($to_date != ''){
            $list = $list->whereDate('created_at','<=',date('Y-m-d',strtotime($to_date)));
        }

        if($request->excel == 'Export XLSX') {

            $list = $list->get();
            $rows = array();
            $i = 1;

            foreach ($list as $key => $val) {

                $rows[$key]['i'] = $i;
                $rows[$key]['name'] = ($val->name != '')?$val->name:$val->first_name.' '.$val->last_name;
                $rows[$key]['email'] = ($val->email)??'-';
                $rows[$key]['phone'] = ($val->dial_code!='')?$val->dial_code.' '.$val->phone:'-';
                // $rows[$key]['address line 1'] = ($val->vendordata->address1)??'';
                // $rows[$key]['address line 2'] = ($val->vendordata->address1)??'';
                // $rows[$key]['street'] = ($val->vendordata->street)??'';
                // $rows[$key]['country'] = $val->country->name??'';
                // $rows[$key]['state'] = $val->state->name??'';
                // $rows[$key]['city'] = $val->city->name??'';
                $rows[$key]['created_date'] = date('d-m-Y h:i A',strtotime($val->created_at));
                $i++;
            }
            $headings = [
                "#",
                "Name",
                "Email",
                "Mobile",
                // "Address line 1",
                // "Address Line 2",
                // "Street",
                // "County",
                // "State",
                // "City",
                "Created Date",
            ];
            $coll = new ExportReports([$rows], $headings);
            $ex = Excel::download($coll, 'customers_' . date('d_m_Y_h_i_s') . '.xlsx');
            if (ob_get_length()) ob_end_clean();
            return $ex;
            
        }
        else if($request->excel == 'Export Pdf') {

            $list = $list->get();
            $rows = array();
            $i = 1;

            $pdf = new FPDFExtended();
            $pdf->AddPage();
            $pdf->SetFont('Arial', '', 10);
            // Table with 20 rows and 4 columns
            $pdf->SetWidths(array(10, 55, 50, 41, 40));

            $pdf->Row(array("S.No", "Name",  "Email", "Mobile No", "Created"));

            foreach ($list as $key => $val) {

                $pdf->Row(
                    array(($key + 1), 
                    ($val->name != '')?$val->name:$val->first_name.' '.$val->last_name, 
                    ($val->email)??'-', 
                    ($val->dial_code!='')?$val->dial_code.' '.$val->phone:'-', 
                    date('d-m-Y h:i A',strtotime($val->created_at))
                ));

            }

            $pdf->Output('D', 'customers_' . date('d_m_Y_h_i_s') .".pdf");





        }
        else{

            if (isset($_GET['from_date'])) {
                $list = $list->paginate(500);
            }
            else
            {
                $list=$list->paginate(10);  
            }
            return view('admin.reports.customers', compact('page_heading', 'list','from_date','to_date'));

            
        }

    }
    public function drivers(REQUEST $request){
        $page_heading = "Customers";
        $from_date    = $request->from_date;
        $to_date      = $request->to_date;
        $list = User::select([
            DB::raw('name::text as name'),
            DB::raw('email::text as email'),
            DB::raw('dial_code::text as dial_code'),
            DB::raw('phone::text as phone'),
            DB::raw('status::text as status'),
            DB::raw('users.created_at::text as created_at'),
            DB::raw('users.id::text as id')
        ])->whereNotIn('users.id', function($query) {
            $query->select('user_id')
                  ->from('blacklists')
                  ->whereColumn('users.id','=','blacklists.user_id');
        })->where('role_id',3)->orderBy('users.created_at','desc');
        
        if($from_date != ''){
            $list = $list->whereDate('created_at','>=',date('Y-m-d',strtotime($from_date)));
        }
        if($to_date != ''){
            $list = $list->whereDate('created_at','<=',date('Y-m-d',strtotime($to_date)));
        }

        if($request->excel == 'Export XLSX') {

            $list = $list->get();
            $rows = array();
            $i = 1;

            foreach ($list as $key => $val) {

                $rows[$key]['i'] = $i;
                $rows[$key]['name'] = ($val->name != '')?$val->name:$val->first_name.' '.$val->last_name;
                $rows[$key]['email'] = ($val->email)??'-';
                $rows[$key]['phone'] = ($val->dial_code!='')?$val->dial_code.' '.$val->phone:'-';
                // $rows[$key]['address line 1'] = ($val->vendordata->address1)??'';
                // $rows[$key]['address line 2'] = ($val->vendordata->address1)??'';
                // $rows[$key]['street'] = ($val->vendordata->street)??'';
                // $rows[$key]['country'] = $val->country->name??'';
                // $rows[$key]['state'] = $val->state->name??'';
                // $rows[$key]['city'] = $val->city->name??'';
                $rows[$key]['created_date'] = date('d-m-Y h:i A',strtotime($val->created_at));
                $i++;
            }
            $headings = [
                "#",
                "Name",
                "Email",
                "Mobile",
                // "Address line 1",
                // "Address Line 2",
                // "Street",
                // "County",
                // "State",
                // "City",
                "Created Date",
            ];
            $coll = new ExportReports([$rows], $headings);
            $ex = Excel::download($coll, 'customers_' . date('d_m_Y_h_i_s') . '.xlsx');
            if (ob_get_length()) ob_end_clean();
            return $ex;
            
        }
        else if($request->excel == 'Export Pdf') {

            $list = $list->get();
            $rows = array();
            $i = 1;

            $pdf = new FPDFExtended();
            $pdf->AddPage();
            $pdf->SetFont('Arial', '', 10);
            // Table with 20 rows and 4 columns
            $pdf->SetWidths(array(10, 55, 50, 41, 40));

            $pdf->Row(array("S.No", "Name",  "Email", "Mobile No", "Created"));

            foreach ($list as $key => $val) {

                $pdf->Row(
                    array(($key + 1), 
                    ($val->name != '')?$val->name:$val->first_name.' '.$val->last_name, 
                    ($val->email)??'-', 
                    ($val->dial_code!='')?$val->dial_code.' '.$val->phone:'-', 
                    date('d-m-Y h:i A',strtotime($val->created_at))
                ));

            }

            $pdf->Output('D', 'customers_' . date('d_m_Y_h_i_s') .".pdf");





        }
        else{

            if (isset($_GET['from_date'])) {
                $list = $list->paginate(500);
            }
            else
            {
                $list=$list->paginate(10);  
            }
            return view('admin.reports.customers', compact('page_heading', 'list','from_date','to_date'));

            
        }

    }

    public function companies(REQUEST $request){
        $page_heading = "Customers";
        $from_date    = $request->from_date;
        $to_date      = $request->to_date;
        $list = User::select([
            DB::raw('name::text as name'),
            DB::raw('email::text as email'),
            DB::raw('dial_code::text as dial_code'),
            DB::raw('phone::text as phone'),
            DB::raw('status::text as status'),
            DB::raw('users.created_at::text as created_at'),
            DB::raw('users.id::text as id')
        ])->whereNotIn('users.id', function($query) {
            $query->select('user_id')
                  ->from('blacklists')
                  ->whereColumn('users.id','=','blacklists.user_id');
        })->where('role_id',3)->orderBy('users.created_at','desc');
        
        if($from_date != ''){
            $list = $list->whereDate('created_at','>=',date('Y-m-d',strtotime($from_date)));
        }
        if($to_date != ''){
            $list = $list->whereDate('created_at','<=',date('Y-m-d',strtotime($to_date)));
        }

        if($request->excel == 'Export XLSX') {

            $list = $list->get();
            $rows = array();
            $i = 1;

            foreach ($list as $key => $val) {

                $rows[$key]['i'] = $i;
                $rows[$key]['name'] = ($val->name != '')?$val->name:$val->first_name.' '.$val->last_name;
                $rows[$key]['email'] = ($val->email)??'-';
                $rows[$key]['phone'] = ($val->dial_code!='')?$val->dial_code.' '.$val->phone:'-';
                // $rows[$key]['address line 1'] = ($val->vendordata->address1)??'';
                // $rows[$key]['address line 2'] = ($val->vendordata->address1)??'';
                // $rows[$key]['street'] = ($val->vendordata->street)??'';
                // $rows[$key]['country'] = $val->country->name??'';
                // $rows[$key]['state'] = $val->state->name??'';
                // $rows[$key]['city'] = $val->city->name??'';
                $rows[$key]['created_date'] = date('d-m-Y h:i A',strtotime($val->created_at));
                $i++;
            }
            $headings = [
                "#",
                "Name",
                "Email",
                "Mobile",
                // "Address line 1",
                // "Address Line 2",
                // "Street",
                // "County",
                // "State",
                // "City",
                "Created Date",
            ];
            $coll = new ExportReports([$rows], $headings);
            $ex = Excel::download($coll, 'customers_' . date('d_m_Y_h_i_s') . '.xlsx');
            if (ob_get_length()) ob_end_clean();
            return $ex;
            
        }
        else if($request->excel == 'Export Pdf') {

            $list = $list->get();
            $rows = array();
            $i = 1;

            $pdf = new FPDFExtended();
            $pdf->AddPage();
            $pdf->SetFont('Arial', '', 10);
            // Table with 20 rows and 4 columns
            $pdf->SetWidths(array(10, 55, 50, 41, 40));

            $pdf->Row(array("S.No", "Name",  "Email", "Mobile No", "Created"));

            foreach ($list as $key => $val) {

                $pdf->Row(
                    array(($key + 1), 
                    ($val->name != '')?$val->name:$val->first_name.' '.$val->last_name, 
                    ($val->email)??'-', 
                    ($val->dial_code!='')?$val->dial_code.' '.$val->phone:'-', 
                    date('d-m-Y h:i A',strtotime($val->created_at))
                ));

            }

            $pdf->Output('D', 'customers_' . date('d_m_Y_h_i_s') .".pdf");





        }
        else{

            if (isset($_GET['from_date'])) {
                $list = $list->paginate(500);
            }
            else
            {
                $list=$list->paginate(10);  
            }
            return view('admin.reports.customers', compact('page_heading', 'list','from_date','to_date'));

            
        }

    }

}
