<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company;
use App\Models\TruckType;
use App\Models\DriverDetail;
use App\Models\Booking;
use App\Models\AcceptedQoute;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\LaravelAdapter;
use DB;
use Carbon\Carbon;
use App\Imports\DriverImport;
use Maatwebsite\Excel\Facades\Excel;

class DriverController extends Controller
{

    public function index(REQUEST $request)
    {
        $page_heading = "Truck Drivers";
        $mode = "List";
        return view('admin.drivers.list', compact('mode', 'page_heading'));
    }
    public function ExportDriver(Request $request)
    {
        $driver = User::where('role_id',2)->find(139)->toArray();
        dd($driver);
        $bookings = $bookings->get();
        $rows = array();
        $i = 1;


        $column = [
          "name" => "NbDriver",
          "email" => "nbd1@mailinator.com",
          "dial_code" => "971",
          "phone" => "984569999",
          "status" => "active",
          "address" => "Business Bay",
          // "latitude" => "22.4898608024688"
          // "longitude" => "88.37032970041037"
          "country" => "United Arab Emirates",
          "city" => "Dubai",
          "zip_code" => null,
          // "address_2" => "38, Ananda Pally, Jadavpur, Kolkata, West Bengal 700092, India,"
          // "login_type" => "normal"
          "trade_licence_number" => null,
          "trade_licence_doc" => null,
        ];

        
        $headings = [
            // "#",
            "Driver Name",
            "Email",
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
    function driver_import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx',
        ]);

        DB::beginTransaction();
        try {
            $file = $request->file('excel_file');

            $data = Excel::toArray(new DriverImport, $file);
            $data = count($data) == 1 ? $data[0] : $data;

            $data = array_filter($data, function ($row) {
                return !empty(array_filter($row));
            });

            for ($i = 1; $i < count($data); $i++) {
                $user = User::inserDriverData($data[$i]);
            }
            session()->flash('success', 'Imported successfully');
            DB::commit();
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('error', 'Error occurred during import: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function earning($id)
    {
        $id = decrypt($id);
        
        $user = User::find($id);
        if(!empty($user)){

            $page_heading = "Earnings";
            $mode = "list";
            $totalEarning = \App\Models\AcceptedQoute::where('driver_id',$id)->sum('qouted_amount');
            $paidEarning = Booking::join('users as customers','customers.id','=','bookings.sender_id')->join('deligates','deligates.id','=','bookings.deligate_id')
         ->join('accepted_qoutes','accepted_qoutes.booking_id','bookings.id')
         ->where('is_paid','yes')
         ->where('accepted_qoutes.driver_id',$id)->sum('accepted_qoutes.qouted_amount');
            return view('admin.drivers.earnings',compact('page_heading','mode','id','totalEarning','paidEarning'));

        }
        else{
            abort(404);
        } 
    }
    public function getearningList(Request $request){
       
        $sqlBuilder = Booking::join('users as customers','customers.id','=','bookings.sender_id')->join('deligates','deligates.id','=','bookings.deligate_id')
         ->join('accepted_qoutes','accepted_qoutes.booking_id','bookings.id')
        ->leftJoin('users as drivers','drivers.id','=','accepted_qoutes.driver_id')
         ->where('accepted_qoutes.driver_id',$request->id)
        ->select([
            'bookings.id as id',
            'bookings.booking_number as booking_number',
            'customers.name as customer_name',
            'deligates.name as deligate_name',
            'drivers.name as driver_name',
            'bookings.is_paid as is_paid',
            'bookings.status as booking_status',
            'accepted_qoutes.qouted_amount as qouted_amount',
            'accepted_qoutes.total_amount as total_amount',
            'accepted_qoutes.commission_amount as comission_amount',
            'bookings.created_at as created_at',
        ])->orderBy('bookings.id','DESC')->where('accepted_qoutes.status','delivered');
        $dt = new Datatables(new LaravelAdapter);

        $dt->query($sqlBuilder);


        $dt->edit('created_at', function ($data) {
            return (new Carbon($data['created_at']))->format('d/m/y h:i A');
        });

        $dt->edit('customer_name', function ($data) {
            return $data['customer_name'] ?? '';
        });

        $dt->add('earned_amount', function ($data) {
            $earned_amount = get_earned_amount($data['qouted_amount'],$data['comission_amount']);
            return (number_format($earned_amount,2) ?? number_format(0));
        });

        $dt->edit('qouted_amount', function ($data) {
            return (number_format($data['qouted_amount'],3) ?? number_format(0));
        });

       

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
           if (get_user_permission('users', 'u')) {

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
    public function getdriversList(Request $request)
    {
        // $sqlBuilder =  DB::table('variations')ss
        
        $sqlBuilder = User::join('roles','roles.id','=','users.role_id')
        ->join('driver_details','driver_details.user_id','=','users.id')
        ->leftJoin('companies','companies.user_id','=','driver_details.company_id')
        ->select([
            DB::raw('users.email::text as email'),
            DB::raw('dial_code::text as dial_code'),
            DB::raw('users.id::text as id'),
            DB::raw('phone::text as phone'),
            DB::raw('roles.role::text as role_name'),
            DB::raw('companies.name::text as company_name'),
            DB::raw('users.status::text as user_status'),
            DB::raw('driver_details.total_rides::text as total_rides'),
            DB::raw('driver_details.is_company::text as is_company'),
            DB::raw('users.name::text as name'),
            DB::raw('users.created_at::text as created_at'),
            
        ])->whereNotIn('driver_details.user_id', function($query) {
            $query->select('user_id')
                  ->from('blacklists')
                  ->whereColumn('users.id','=','blacklists.user_id');
        })->where('role_id','=',2)->where('phone_verified',1)  
       ->orderBy('created_at','desc');
        $dt = new Datatables(new LaravelAdapter);

       

        $dt->query($sqlBuilder);

        
        $dt->edit('created_at', function ($data) {
            return (new Carbon($data['created_at']))->format('d/m/y h:i A');
        });
        
        $dt->edit('phone', function ($data) {
            return "+" . $data['dial_code'] . " " . $data['phone'];
        });

        $dt->edit('is_company', function ($data) {
            $type = '';
            if($data['is_company'] == 'yes'){
                $type = 'Company'."<br />"."<small>(".$data['company_name'].")</small>";
            }else{
                $type = 'Individual';
            }
            return $type;
        });
        
        // $dt->edit('user_image', function ($data) {
        //     return "
        //     <ul class='list-unstyled users-list m-0 avatar-group d-flex align-items-center'>
        //         <li data-bs-toggle='tooltip' data-popup='tooltip-custom' data-bs-placement='top' class='avatar avatar-xs pull-up' aria-label='Sophia Wilkerson'  data-bs-original-title='Sophia Wilkerson'>
        //             <img class='rounded-circle' src='" . get_uploaded_image_url($data['user_image'], 'user_image_upload_dir') . "' style='width:50px; height:50px;'>
        //         </li>
        //     </ul>";
        // });

        $dt->edit('user_status', function ($data) {
            if (get_user_permission('drivers', 'u')) {
                $checked = ($data["user_status"] == 'active') ? "checked" : "";
                $html = '<label class="switch s-icons s-outline  s-outline-warning  mb-4 mr-2">
                        <input type="checkbox" data-role="active-switch"
                            data-href="' . route('drivers.status_change', ['id' => encrypt($data['id'])]) . '"
                            ' . $checked . ' >
                        <span class="slider round"></span>
                    </label>';
            } else {
                $checked = ($data["user_status"] == 'active') ? "Active" : "InActive";
                $class = ($data["user_status"] == 'active') ? "badge-success" : "badge-danger";
                $html = '<span class="badge ' . $class . '" ' . $checked . ' </span>';
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
                    if (get_user_permission('drivers', 'v')) {
                        $html .= '<a class="dropdown-item"
                                href="' . route('drivers.view', ['id' => encrypt($data['id'])]) . '"><i
                                    class="bx bx-file"></i> View</a>';
                    }
                if (get_user_permission('drivers', 'u')) {
                    $html .= '<a class="dropdown-item"
                            href="' . route('drivers.edit', ['id' => encrypt($data['id'])]) . '"><i
                                class="flaticon-pencil-1"></i> Edit</a>';
                }
                if (get_user_permission('drivers', 'u')) {
                    $html .= '<a class="dropdown-item"
                            href="' . route('blacklists.add', ['id' => encrypt($data['id'])]) . '"><i class="fa-solid fa-user-lock"></i> BlackList</a>';
                }
                 $html .= '<a class="dropdown-item"
                            href="' . route('drivers.earning', ['id' => encrypt($data['id'])]) . '"><i class="fa-solid fa-user-lock"></i> Earnings</a>';

            // if (get_user_permission('users', 'd')) {
            //     $html .= '<a class="dropdown-item" data-role="unlink"
            //             data-message="Do you want to remove this user?"
            //             href="' . route('user_roles.delete', ['id' => encrypt($data['id'])]) . '"><i
            //                 class="flaticon-delete-1"></i> Delete</a>';
            // }
            $html .= '</div>
            </div>';
            
            return $html;
        });

        return $dt->generate();
    }
    

    public function create(){

        $page_heading = "Create Driver Account";
        $mode = "create";
        $companies = User::join('companies','companies.user_id','=','users.id')->where('users.status','active')->where('role_id',4)->get(['users.*']);
        $get_driver_types = get_driver_types();
        $trucks = TruckType::where('status','active')->where('is_container',0)->get();
    
        return view('admin.drivers.create',compact('companies','get_driver_types','page_heading','mode','trucks'));

    }


    function submit(Request $request){
         
        $status     = "0";
        $message    = "";
        $o_data     = [];
        $errors     = [];
        $o_data['redirect'] = route('drivers.list');
        $rules = [
            'truck_type' => 'required',
            'driver_type' => 'required',
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'dial_code' => 'required',
            'phone' => 'required|unique:users',
            'driving_license' => 'required|mimes:jpeg,png,jpg,gif',
            'emirates_id_or_passport' => 'required|mimes:jpeg,png,jpg,gif',
            'emirates_id_or_passport_back' => 'required|mimes:jpeg,png,jpg,gif',
            'driving_license_number' => 'required|unique:driver_details',
            'driving_license_expiry' => 'required',
            'driving_license_issued_by' => 'required',
            'vehicle_plate_number' => 'required',
            'vehicle_plate_place' => 'required',
            'mulkiya' => 'required|mimes:jpeg,png,jpg,gif',
            'mulkiya_number' => 'required',
            'status' => 'required',
            'address' => 'required',
            'country' => 'required',
            'city' => 'required',
            //'zip_code' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ];
        if($request->driver_type == '1'){
            $rules['company'] = 'required';
        }
       
        $validator = Validator::make($request->all(),$rules);
        
        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
            
        }
        else{
            
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->dial_code = $request->dialcode;
            $user->phone = $request->phone;
            $user->phone_verified = 1;
            $user->role_id = 2;
            $user->email_verified_at = Carbon::now();
            $user->status = $request->status;
            $user->address = $request->address;
            $user->address_2 = $request->address;
            $user->country = $request->country;
            $user->city = $request->city;
            $user->zip_code = $request->zip_code??'';
            $user->latitude = $request->latitude;
            $user->longitude = $request->longitude;
            $user->save(); 

            if(!empty($user)){
                
                $driving_drivers = array();
                
                $driving_drivers['mulkia_number'] = $request->mulkiya_number;
                $driving_drivers['driving_license_issued_by'] = $request->driving_license_issued_by;
                $driving_drivers['driving_license_number'] = $request->driving_license_number;
                $driving_drivers['driving_license_expiry'] = date('Y-m-d',strtotime($request->driving_license_expiry));
                $driving_drivers['vehicle_plate_number'] = $request->vehicle_plate_number;
                $driving_drivers['vehicle_plate_place'] = $request->vehicle_plate_place;

                $driving_drivers['truck_type_id'] = $request->truck_type;
                $driving_drivers['total_rides'] = 0;
                $driving_drivers['address'] = $request->address;
                $driving_drivers['latitude'] = $request->latitude;
                $driving_drivers['longitude'] = $request->longitude;


                if($request->driver_type == '1'){
                    $driving_drivers['is_company'] = 'yes';
                    $driving_drivers['company_id'] = $request->company;
                }else{
                    // $driving_drivers['company_id'] = 0;
                    $driving_drivers['is_company'] = 'no';
                }


                if($request->file("driving_license") != null){
                        $response = image_upload($request,'users','driving_license');
                        
                        if($response['status']){
                            $driving_drivers['driving_license'] = $response['link'];
                        }
                }


                if($request->file("mulkiya") != null){
                        $response = image_upload($request,'users','mulkiya');
                        
                        if($response['status']){
                            $driving_drivers['mulkia'] = $response['link'];
                        }
                }

                if($request->file("emirates_id_or_passport") != null){
                    $response = image_upload($request,'users','emirates_id_or_passport');
                    
                    if($response['status']){
                        $driving_drivers['emirates_id_or_passport'] = $response['link'];
                    }
                }

                if($request->file("emirates_id_or_passport_back") != null){
                    $response = image_upload($request,'users','emirates_id_or_passport_back');
                    
                    if($response['status']){
                        $driving_drivers['emirates_id_or_passport_back'] = $response['link'];
                    }
                }

                 $phone = $request->adphone; 
                $dial_code = $request->dial_code;
                if(isset($request->phoneid)) {
                    foreach($request->phoneid as $k => $echphone) {
                       
                        if($echphone == 0 ) {
                           $ob = new \App\Models\UserAdditionalPhone();
                           $ob->user_id = $user->id;
                        } else {
                           $ob =  \App\Models\UserAdditionalPhone::find($echphone);
                        }
                        $ob->dial_code =  $dial_code[$k];
                        $ob->mobile =  $phone[$k];
                        $ob->save();
                    }
                }
                
                $bool = DriverDetail::updateOrCreate(['user_id' => $user->id],
                                $driving_drivers
                            ); 
               
                               
                if($bool){
                        $status = "1";
                        $message = "Driver account created Successfully";
                }
                else
                {
                    $status = "0";
                    $message = "Driver account could not created";
                }               
            }
        }

        echo json_encode(['status' => $status, 'errors' => $errors, 'message' => $message, 'oData' => $o_data]);
    }

    public function edit($id){
        $id = decrypt($id);
        
        $user = User::with('additionalPhone')->find($id);
        if(!empty($user)){

            $page_heading = "Edit Driver Account";
            $mode = "edit";
            $companies = User::where('status','active')->where('role_id',4)->get();
            $get_driver_types = get_driver_types();
            $trucks = TruckType::where('status','active')->where('is_container',0)->get();

            return view('admin.drivers.edit',compact('companies','get_driver_types','page_heading','mode','user','trucks'));

        }
        else{
            abort(404);
        } 

    }    


    function update(Request $request,$id){
        
        $status     = "0";
        $message    = "";
        $o_data     = [];
        $errors     = [];
        $o_data['redirect'] = route('drivers.list');
        $rules = [
            'truck_type' => 'required',
            'driver_type' => 'required',
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$id,
            'dial_code' => 'required',
            'phone' => 'required|unique:users,phone,'.$id,
            'mulkiya_number' => 'required',
            'status' => 'required',
            'address' => 'required',
            'country' => 'required',
            'city' => 'required',
            //'zip_code' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'driving_license_expiry' => 'required',
            'driving_license_issued_by' => 'required',
            'vehicle_plate_number' => 'required',
            'vehicle_plate_place' => 'required',
            'driving_license_number' => 'required|unique:driver_details,driving_license_number, '.$request->driver_detail_id,

        ];
        if($request->driver_type == '1'){
            $rules['company'] = 'required';
        }

        if($request->file("driving_license") != null){
            $rules['driving_license'] = 'required|mimes:jpeg,png,jpg,gif';
        }

        if($request->file("emirates_id_or_passport") != null){
            $rules['emirates_id_or_passport'] = 'required|mimes:jpeg,png,jpg,gif';
        }

        if($request->file("emirates_id_or_passport_back") != null){
            $rules['emirates_id_or_passport_back'] = 'required|mimes:jpeg,png,jpg,gif';
        }

        if($request->file("mulkiya") != null){
            $rules['mulkiya'] = 'required|mimes:jpeg,png,jpg,gif';
        }

        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
            
        }
        else{

            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;

            if($request->password != null){
                $user->password = Hash::make($request->password);
            }
           
            $user->dial_code = $request->dialcode;
            $user->phone = $request->phone;
            $user->phone_verified = 1;
            $user->role_id = 2;
            $user->email_verified_at = Carbon::now();
            $user->status = $request->status;
            $user->address = $request->address;
            $user->address_2 = $request->address;
            $user->country = $request->country;
            $user->city = $request->city;
            $user->zip_code = $request->zip_code??'';
            $user->latitude = $request->latitude;
            $user->longitude = $request->longitude;
            
            $user->save();

           

            if(!empty($user)){
                
                $driving_drivers = array();             
                $driving_drivers['mulkia_number'] = $request->mulkiya_number;
                $driving_drivers['driving_license_issued_by'] = $request->driving_license_issued_by;
                $driving_drivers['driving_license_number'] = $request->driving_license_number;
                $driving_drivers['driving_license_expiry'] = date('Y-m-d',strtotime($request->driving_license_expiry));
                $driving_drivers['vehicle_plate_number'] = $request->vehicle_plate_number;
                $driving_drivers['vehicle_plate_place'] = $request->vehicle_plate_place;

                $driving_drivers['truck_type_id'] = $request->truck_type;
                $driving_drivers['total_rides'] = 0;
                $driving_drivers['address'] = $request->address;
                $driving_drivers['latitude'] = $request->latitude;
                $driving_drivers['longitude'] = $request->longitude;    


                if($request->driver_type == '1'){
                    $driving_drivers['is_company'] = 'yes';
                    $driving_drivers['company_id'] = $request->company;
                }else{
                    $driving_drivers['company_id'] = 0;
                    $driving_drivers['is_company'] = 'no';
                }


                if($request->file("driving_license") != null){
                        $response = image_upload($request,'users','driving_license');
                        
                        if($response['status']){
                            $driving_drivers['driving_license'] = $response['link'];
                        }
                }


                if($request->file("mulkiya") != null){
                        $response = image_upload($request,'users','mulkiya');
                        
                        if($response['status']){
                            $driving_drivers['mulkia'] = $response['link'];
                        }
                }

                if($request->file("emirates_id_or_passport") != null){
                    $response = image_upload($request,'users','emirates_id_or_passport');
                    
                    if($response['status']){
                        $driving_drivers['emirates_id_or_passport'] = $response['link'];
                    }
                }

                if($request->file("emirates_id_or_passport_back") != null){
                    $response = image_upload($request,'users','emirates_id_or_passport_back');
                    
                    if($response['status']){
                        $driving_drivers['emirates_id_or_passport_back'] = $response['link'];
                    }
                }

                $bool = DriverDetail::updateOrCreate(['user_id' => $user->id],
                                $driving_drivers
                            );
                
                $phone = $request->adphone;
                $dial_code = $request->dial_code;
                if(isset($request->phoneid)) {
                    foreach($request->phoneid as $k => $echphone) {
                       
                        if($echphone == 0 ) {
                           $ob = new \App\Models\UserAdditionalPhone();
                           $ob->user_id = $user->id;
                        } else {
                           $ob =  \App\Models\UserAdditionalPhone::find($echphone);
                        }
                        $ob->dial_code =  $dial_code[$k];
                        $ob->mobile =  $phone[$k];
                        $ob->save();
                    }
                }
                               
                if($bool){
                        $status = "1";
                        $message = "Driver account updated successfully";
                }
                else
                {
                    $status = "0";
                    $message = "Driver account could not updated";
                }               
            }
        }

        echo json_encode(['status' => $status, 'errors' => $errors, 'message' => $message, 'oData' => $o_data]);
    }

    public function change_status(REQUEST $request, $id)
    {
        $status = "0";
        $message = "";
        $o_data = [];
        $errors = [];

        $id = decrypt($id);
        $item = User::where(['id' => $id])->get();
        if ($item->count() > 0) {
            $item = $item->first();
            User::where('id', '=', $id)->update(['status' => $request->status == '1'?'active':'inactive']);
            $status = "1";
            $message = "Status changed successfully";
        } else {
            $message = "Faild to change status";
        }

        echo json_encode(['status' => $status, 'errors' => $errors, 'message' => $message, 'oData' => $o_data]);

    }
    function view($id){
        $id = decrypt($id);
        
        $user = User::find($id);
        if(!empty($user)){

            $page_heading = "View Driver Account";
            $mode = "view";
            $companies = User::where('status','active')->where('role_id',4)->get();
            $get_driver_types = get_driver_types();
            $total_bookings = AcceptedQoute::where('driver_id',$id)->where('status','delivered')->count();
            $trucks = TruckType::where('status','active')->where('is_container',0)->get();
            return view('admin.drivers.view',compact('companies','get_driver_types','page_heading','mode','user','trucks','total_bookings'));

        }
        else{
            abort(404);
        } 
    }
    public function delete_phone(Request $request)
    {
        $status = "0";
        $message = "";
        $o_data = [];
        $errors = [];               
        $validator = Validator::make($request->all(), [
            'user_id'               =>'required' ,       
            'id'                    =>'required'
        ]);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        } else {            
            $user_id    =   $request->user_id;
            $phoneObj = \App\Models\UserAdditionalPhone::find($request->id);  
            if( $phoneObj!=null && $phoneObj->user_id == $user_id  ) {
                $phoneObj ->delete();
                $status = "1";
                $message = "Mobile number deleted successfully";
            } else {
                $message = "Invalid user request";
            }
        }
        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => (object)$o_data], 200);
    }
}
