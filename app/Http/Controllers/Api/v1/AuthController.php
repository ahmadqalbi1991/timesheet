<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempUser;
use App\Models\Country;
use App\Models\City;
use App\Models\User;
use App\Models\DriverDetail;
use App\Models\Blacklist;
use App\Models\TempGallery;
use App\Models\Album;
use App\Models\UserCategories;
use Validator;
use DB;
use Hash;
use Auth;
use Socialite;
use Kreait\Firebase\Contract\Database;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthController extends Controller
{
    //
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function customer_register(Request $request){

        $status   = "0";
        $message  = "";
        $o_data   = [];
        $errors   = [];

        $rules= [
            'name'              => 'required',
            'email'             => 'required|email',
            'dial_code'         => 'required',
            'phone'             => 'required',
            'password'          => 'required|confirmed',
            'country_id'        => 'required|numeric',
            'city_id'           => 'required|numeric',
            'zip_code'          => 'required|numeric',
            'address'           => '',
            'user_device_type'  => 'required',
            'user_device_token' => 'required',
            'user_device_id'    => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
        
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();

            return response()->json([
                'status' => "0",
                'message' => $message,
                'error' => (object)$errors
            ], 200);
        }

        if (Blacklist::where('user_device_id', $request->user_device_id)->first() != null) {
            return response()->json([
                'status' => "0",
                'error' => (object)array(),
                'message' => 'The existing device is in blacklist you cannot create account',
            ], 200);
        }

        if (User::where('email', $request->email)->first() != null) {
            return response()->json([
                'status' => "0",
                'error' => (object)array(),
                'message' => 'Email already exists.',
            ], 201);
        }

        if (User::where('phone', $request->phone)->first() != null) {
            return response()->json([
                'status' => "0",
                'error' => (object)array(),
                'message' => 'Phone already exists.',
            ], 201);
        }

        $country = Country::where('country_id',$request->country_id)->first();
        $city = City::find($request->city_id);

      // DB::beginTransaction();
        try{
            $checkExist = \App\Models\TempUser::where('email',$request->email)->where('role_id',3)->first();
            if($checkExist  == null) {
                $customer   = new \App\Models\TempUser();
            } else {
               $customer   = \App\Models\TempUser::find($checkExist->temp_user_id); 
            }
            
            
            $customer->name    = $request->name;
            $customer->email  = $request->email;
            $customer->dial_code    = $request->dial_code;
            $customer->phone    = $request->phone;
            $customer->password  = Hash::make($request->password);
            $customer->role_id  = 3; 
            //$customer->status  = 'inactive';
            $customer->address = '';
            $customer->address_2 = $request->address??'';
           // $customer->country = $country->country_name;
           // $customer->city = $city->city_name;
            $customer->country_id = $request->country_id;
            $customer->city_id = $request->city_id;
            $customer->zip_code = $request->zip_code;
            $customer->latitude = $request->latitude;
            $customer->longitude = $request->longitude;
            /*$customer->email_verified_at  = gmdate('Y-m-d H:i:s');
            $customer->phone_verified  = 0;*/
            $customer->user_device_type  = $request->user_device_type;
            $customer->user_device_token  = $request->user_device_token;
            $customer->user_device_id  = $request->user_device_id; 
             $otp = generate_otp();
            $customer->user_phone_otp = $otp; 
            $customer->save(); 
            $name = $customer->name;
            $mailbody = view('emai_templates.verify_mail', compact('otp', 'name'));
            send_email($customer->email,'Verify Registration', $mailbody);
            
           
            send_normal_SMS(
                "OTP for verifying your account at ".env('APP_NAME')." is ".$otp,
                $customer->dial_code."".$customer->phone
            );

            if(!empty($customer->temp_user_id > 0)){
                $o_data['user_id'] = $customer->temp_user_id;
                $status = "1";
                $message = "To verify your mobile number, please enter the OTP that is sent to your mobile number ending in ".preg_replace('~[+\d-](?=[\d-]{3})~', 'X', $customer->phone);
            }else{
                $message = "Failed to register please try again";
            }

            //DB::commit();
        }catch (\Exception $e) { echo $e->getMessage();
            //DB::rollback();
            $message = "Failed to register please try again";
        }

        /*$token = $customer->createToken('Personal Access Token')->plainTextToken;

        $user = User::find($customer->id);
        $user->user_access_token = $token;
        $user->save();
        
        $user->user_id = (string)$user->id;
        if (config('global.server_mode') == 'local') {
            \Artisan::call('update:firebase_node ' . $user->id);
        } else { 
            exec("php " . base_path() . "/artisan update:firebase_node " . $user->id . " > /dev/null 2>&1 & ");
        }

        try {
            $this->sendEmailAndNotifyAdmin($user);
         } catch (\Throwable $th) {
             info($th->getMessage());
         }*/


        $o_data = convert_all_elements_to_string($o_data);
        return response()->json(['status' => (string)$status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data], 200);
    }


    public function sendEmailAndNotifyAdmin($user)
    {
        $to = env('Admin_Email');
        $subject = 'New User Registration';
        $admin_name = 'Admin';
        $user_name = $user->name;
        $url = url('admin/customers/lists/all');

        $mailbody = view('emai_templates.new_user', compact('admin_name', 'user_name', 'url'));
        send_email($to, $subject, $mailbody);

        // AccountNotification::create([
        //     'user_id' => $user->id,
        //     'title' => 'New User Registration',
        //     'message' => $user->name . ' just joined Livemarket.',
        // ]);
    }

    function signIn(Request $request)
    {
        
        $rules = [
            'email' =>      'required',
            'password' =>   'required',
            'user_device_type' => 'required',
            'user_device_token' => 'required',
            'user_device_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
        
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();

            return response()->json([
                'status' => "0",
                'message' => $message,
                'error' => (object)$errors
            ], 200);
        }

        if (Blacklist::where('user_device_id', $request->user_device_id)->first() != null) {
            return response()->json([
                'status' => "0",
                'error' => (object)array(),
                'message' => 'The existing device is in blacklist you cannot login with your account',
            ], 200);
        }

        $credentials = $request->only('email', 'password');
        $credentials['role_id'] = 3;
        $user = User::whereEmail(strtolower($credentials['email']))->first();
        if(!is_null($user) && auth()->attempt($credentials)){

            if (Blacklist::where('user_id', $user->id)->first() != null) {
                return response()->json([
                    'status' => "0",
                    'error' => (object)array(),
                    'message' => 'Your account is in blacklist you cannot login, please contact to Admin',
                ], 200);
            }

            if ($user->phone_verified == 0) {
                return response()->json([
                    'status' => "0",
                    'error' => (object) ['msg' => 'Invalid Login'],
                    'message' => 'Your Phone Number is not verified',
                ], 200);
            }

            if($user->status == 'active'){
                if(isset($request->user_device_token)){
                    $user->update(['user_device_token' => $request->user_device_token,
                        'user_device_type' => $request->user_device_type]);
                }
                $token = $user->createToken($user->id.$user->name.$user->email);
                $response = ['user' => $user, 'token' => $token->plainTextToken,'currency_code'=>config('global.default_currency_code')];
                $userNode = User::find($user->id);
                $userNode->user_access_token = $response['token'];
                $userNode->save();
                $response=convert_all_elements_to_string($response);
                Auth::logoutOtherDevices($request->password);
                if (config('global.server_mode') == 'local') {
                    \Artisan::call('update:firebase_node ' . $user->id);
                } else { 
                    exec("php " . base_path() . "/artisan update:firebase_node " . $user->id . " > /dev/null 2>&1 & ");
                }
                $userNode = User::find($user->id);
                $response['user'] = $userNode;
                return response()->json(
                    [
                        'status' => "1",
                        'code' => (string) 200,
                        'message' => 'Login Successful',
                        'oData' => (object) $response,
                        'errors' => (object)array()
                    ], 200);

                //return $this->successResponse($response, 'Login Successful');
            }else{

                return new JsonResponse(
                    [
                        'status' => "0",
                        'code' => (string) 400,
                        'message' => 'Your Account is inactive by admin. Please wait. or contact admin for more details',
                        'errors' => (object) ['msg' => 'Invalid Login']
                    ], 200);
                    
            }
        }else{

            return new JsonResponse(
                [
                    'status' => "0",
                    'code' => (string) 400,
                    'message' => 'Login Failed',
                    'errors' => (object) ['msg' => 'Invalid credentials']
                ], 200);

        }
    }

    public function forgot_password_api(REQUEST $request){
        $status = "0";
        $message = "";
        $o_data = [];
        $errors = [];
        $needRegistration = "0";
        $validator = Validator::make($request->all(), [
            'email' => 'required'
        ]);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        } else {
            $user = User::whereEmail(strtolower($request->email))->get();
            if($user->count()> 0){
                $user = $user->first();
                if( $user->login_type == "social" ){
                    $message ="This account is social media login";
                }else{
                    $otp = generate_otp();

                    $userNode = User::find($user->id);
                    $userNode->password_reset_otp = $otp;
                    $userNode->password_reset_time = gmdate('Y-m-d H:i:s');
                    $userNode->save();
                    $text = "OTP for verifying your account at ".env("APP_NAME")." is ".$otp;
                    if($userNode->phone != ''){
                        send_normal_SMS($text,$userNode->dial_code.$userNode->phone);
                    }
                    if($userNode->email != ''){
                        $name = $userNode->name;
                        $mailbody = view('emai_templates.forgot_mail', compact('text', 'name'))->render();
                        send_email($userNode->email,"Forgot Password",$mailbody);
                    }
                    $status = "1";
                    $message = "Otp sent to your registred mobile number and email id";
                }
            }else{
                
                $message = "User not found on this email id";
            }
        }
        return response()->json(['status' => $status,'code'=>($status==1)?"200":"400", 'message' => $message, 'errors' => (object) $errors, 'oData' => (object) $o_data]);
    }

    public function reset_password_api(REQUEST $request){
        $status = "0";
        $message = "";
        $o_data = [];
        $errors = [];
        $needRegistration = "0";
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'otp'   => 'required',
            'new_password'=>'required'
        ]);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        } else {
            $user = User::whereEmail(strtolower($request->email))->get();
            if($user->count()> 0){
                $user = $user->first();
                if( $user->login_type == "social" ){
                    $message ="This account is social media login";
                }else{

                    $userNode = User::find($user->id);
                    if($request->otp == $userNode->password_reset_otp ){
                        $userNode->password_reset_otp = 0;
                        $userNode->password = Hash::make($request->new_password);
                        $userNode->save();
                        $status = "1";
                        $message = "Password changed successfully";
                    }else{
                        $message = "Invalid otp provided";
                    }
                }
            }else{
                
                $message = "User not found on this email id";
            }
        }
        return response()->json(['status' => $status,'code'=>($status==1)?"200":"400", 'message' => $message, 'errors' => (object) $errors, 'oData' => (object) $o_data]);
    }

    public function logout(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'access_token' => 'required',
            ]
        );

        if ($validator->fails()) {
            $message = "Validation error occured";
            $errors = $validator->messages();
            return response()->json([
                'status' => "0",
                'message' => $message,
                'error' => (object) $errors,
                'oData' => (object)[]
            ], 200);
        }
        $user = User::where(['user_access_token' => $request->access_token])->first();
        if (!$user) {
            http_response_code(401);
            echo json_encode([
                'status' => "0",
                'message' => 'This account has been logged in on another device',
                'oData' => (object)[],
                'errors' => (object) [],
            ]);
            exit;
        } else {
            $user->user_device_token = '';
            $user->user_access_token='';
            $user->updated_at = gmdate('Y-m-d H:i:s');
            $user->save();
            return response()->json(['status' => "1",
                'message' => 'Successfully logged out',
                'oData' => (object)[],
                'errors' => (object) [],], 200);
        }
    }

    

    private function firebase_success($user){
    
    }

    private function sync_temp_user($temp_user_id=''){
        $temp_user = TempUser::find($temp_user_id);
        
        if($temp_user){
            $user                           = new User();
            
            $user = new User();
            $user->name = $temp_user->name;
            $user->email = $temp_user->email;
            $user->password = Hash::make($temp_user->password);
            $user->dial_code = $temp_user->dial_code;
            $user->phone = $temp_user->phone;

            $user->temp_dialcode = $temp_user->dial_code;
            $user->temp_mobile = $temp_user->phone;

            $user->phone_verified = 0;
            $user->role_id = 2;
            $user->user_device_type = $temp_user->user_device_type;
            $user->user_device_token = $temp_user->user_device_token;
            $user->user_device_id = $temp_user->user_device_id;
            //$user->email_verified_at = Carbon::now();
            //$user->status = $request->status;
            $user->address_2 = $temp_user->address_2;
            $user->address = $temp_user->address;
            $user->country = $temp_user->country;
            $user->city = $temp_user->city;  
            $user->country_id = $temp_user->country_id;
            $user->city_id = $temp_user->city_id;  
            // $user->zip_code = $temp_user->zip_code;
            $user->latitude = $temp_user->latitude;
            $user->longitude = $temp_user->longitude;
            $user->created_at = gmdate('Y-m-d H:i:s');
            $user->updated_at = gmdate('Y-m-d H:i:s');
            $user->save();

            if(!empty($user)){
                
                $driving_drivers = array();
                
                $driving_drivers['mulkia_number'] = $temp_user->mulkiya_number;
                $driving_drivers['driving_license_issued_by'] = $temp_user->driving_license_issued_by;
                $driving_drivers['driving_license_number'] = $temp_user->driving_license_number;
                $driving_drivers['driving_license'] = $temp_user->driving_license;
                $driving_drivers['mulkia'] = $temp_user->mulkiya;
                $driving_drivers['driving_license_expiry'] = date('Y-m-d',strtotime($temp_user->driving_license_expiry));
                $driving_drivers['vehicle_plate_number'] = $temp_user->vehicle_plate_number;
                $driving_drivers['vehicle_plate_place'] = $temp_user->vehicle_plate_place;
                $driving_drivers['emirates_id_or_passport'] = $temp_user->emirates_id_or_passport;
                $driving_drivers['emirates_id_or_passport_back'] = $temp_user->emirates_id_or_passport_back;

                $driving_drivers['truck_type_id'] = $temp_user->truck_type;
                $driving_drivers['total_rides'] = 0;
                $driving_drivers['address'] = $temp_user->address;
                $driving_drivers['latitude'] = $temp_user->latitude;
                $driving_drivers['longitude'] = $temp_user->longitude;


                if($temp_user->account_type == '1'){
                    $driving_drivers['is_company'] = 'yes';
                    $driving_drivers['company_id'] = $temp_user->company_id;
                }else{
                    $driving_drivers['company_id'] = null;
                    $driving_drivers['is_company'] = 'no';
                }

                $bool = DriverDetail::updateOrCreate(['user_id' => $user->id],
                                $driving_drivers
                            );

                return $user->id;                                 
            }
            else{
                return false;
            }

        }else{
            return false;
        }
    }

    public function resend_otp(REQUEST $request){
        $status   = "0";
        $message  = "";
        $o_data   = [];
        $errors   = [];

        // $rules= [
        //     'type' => 'required' 
        // ];

        // if($request->type == 'email'){
        //     $rules['email'] = 'required';
        // }else{
            // $rules['dial_code'] = 'required';
            // $rules['phone']     = 'required';
        // }
    
        if($request->user_id == null){
            $rules['dial_code'] = 'required';
            $rules['phone']     = 'required';
        }else{
            $rules['user_id'] = 'required';
        }
        
        $validator = Validator::make($request->all(), $rules);
  
        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        }else{
            if($request->user_id != null){
                $user = User::find($request->user_id);
            }else{
                $check = User::where(['dial_code'=>$request->dial_code,'phone'=>$request->phone])->get();
                if($check->count() > 0){
                    $user = User::find($check->first()->id);
                }else{
                    $user = [];
                    $message = "Invalid Request";
                }
            }
            if(!empty($user)){
                $otp = generate_otp();
                $user->user_phone_otp = $otp;
                send_normal_SMS(
                    "OTP for verifying your account at ".env('APP_NAME')." is ".$otp,
                    $user->dial_code."".$user->phone
                );
                $user->save();
                $status = "1";
                $message = "OTP Resent, please enter the OTP that is sent to your mobile number ending in ".preg_replace('~[+\d-](?=[\d-]{3})~', 'X', $user->phone);
                $o_data['user_id'] = $user->id;
            }
        }
        $o_data = convert_all_elements_to_string($o_data);
        return response()->json(['status' => (string)$status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data], 200);
    }
    public function resendSignupotp(REQUEST $request){
        $status   = "0";
        $message  = "";
        $o_data   = [];
        $errors   = [];

        
    
        if($request->user_id == null){
            $rules['dial_code'] = 'required';
            $rules['phone']     = 'required';
        }else{
            $rules['user_id'] = 'required';
        }
        
        $validator = Validator::make($request->all(), $rules);
  
        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        }else{
            if($request->user_id != null){
                $user = TempUser::find($request->user_id);
            }else{
                $check = TempUser::where(['dial_code'=>$request->dial_code,'phone'=>$request->phone])->get();
                if($check->count() > 0){
                    $user = TempUser::find($check->first()->id);
                }else{
                    $user = [];
                    $message = "Invalid Request";
                }
            }
            if(!empty($user)){
                $otp = generate_otp();
                $user->user_phone_otp = $otp;
                send_normal_SMS(
                    "OTP for verifying your account at ".env('APP_NAME')." is ".$otp,
                    $user->dial_code."".$user->phone
                );
                $user->save();
                $name = $user->name;
                $mailbody = view('emai_templates.verify_mail', compact('otp', 'name'));
                send_email($user->email,'Verify Registration', $mailbody);

                $status = "1";
                $message = "OTP Resent, please enter the OTP that is sent to your mobile number ending in ".preg_replace('~[+\d-](?=[\d-]{3})~', 'X', $user->phone);
                $o_data['user_id'] = $user->temp_user_id;
            }
        }
        $o_data = convert_all_elements_to_string($o_data);
        return response()->json(['status' => (string)$status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data], 200);
    }
    public function verifyOtp(REQUEST $request){
        $status   = "0";
        $message  = "";
        $o_data   = [];
        $errors   = [];

        $rules= [
            'otp' => 'required',
            'user_id' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
  
        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        }else{
            
            $user = \App\Models\TempUser::find($request->user_id); 
            if($user != null){
                if( $user->user_phone_otp == $request->otp ){
                    $customer = new \App\Models\User();
                    $customer->name = $user->name;
                    $customer->email = $user->email;
                    $customer->dial_code = $user->dial_code;
                    $customer->phone = $user->phone;
                    $customer->country = $user->country;
                    $customer->city = $user->city;
                    $customer->country_id = $user->country_id;
                    $customer->password = $user->password;
                    $customer->zip_code = $user->zip_code;
                    $customer->role_id = $user->role_id;
                    $customer->address = '';
                    $customer->address_2 = $user->address_2;
                    $customer->latitude = $user->latitude;
                    $customer->longitude = $user->longitude;
                    $customer->user_device_type = $user->user_device_type;
                    $customer->user_device_token = $user->user_device_token;
                    $customer->user_device_id = $user->user_device_id;

                    $customer->user_phone_otp = '';
                    $customer->phone_verified = 1;
                    $customer->status = 'active';
                    $customer->updated_at = gmdate('Y-m-d H:i:s');
                    $customer->save();

                    $token = $customer->createToken('Personal Access Token')->plainTextToken;

                    $user = User::find($customer->id);
                    $user->user_access_token = $token;
                    $user->save();
                    $user = \App\Models\User::find($user->id);
                    if($user->firebase_user_key == null)
                    {
                        $fb_user_refrence = $this->database->getReference('Users/')
                            ->push([
                                'device_token' => $user->user_device_token,
                                'user_name' => $user->name,
                                'email'     => $user->email,
                                'user_id'   => $user->id
                            ]);

                        $user->firebase_user_key = $fb_user_refrence->getKey();
                    } else {
                        $this->database->getReference('Users/' . $user->firebase_user_key . '/')->update(['fcm_token' => $user->device_token]);
                    }
                    $user->save();
                    $userData['firebase_user_key'] = $user->firebase_user_key;
                    $userData['token'] = $this->generateToken($user);

                    $token = $user->createToken($user->id.$user->name.$user->email);
                    $response = ['user' => $user, 'token' => $token->plainTextToken,'currency_code'=>config('global.default_currency_code')];
                    $user = User::find($user->id);
                    $user->user_access_token = $response['token'];
                    $user->save();
                    
                    $user->user_id = (string)$user->id;
                    if (config('global.server_mode') == 'local') {
                        \Artisan::call('update:firebase_node ' . $user->id);
                    } else { 
                        exec("php " . base_path() . "/artisan update:firebase_node " . $user->id . " > /dev/null 2>&1 & ");
                    }
                     exec("php " . base_path() . "/artisan send:welcomemail " . $user->id . " > /dev/null 2>&1 & ");

                    try {
                        $this->sendEmailAndNotifyAdmin($user);
                     } catch (\Throwable $th) {
                         info($th->getMessage());
                     }
                    \App\Models\TempUser::where(['temp_user_id'=>$request->user_id])->delete();
                    $o_data['user'] = $user;
                    $o_data['token'] = $user->user_access_token;
                    $o_data['currency_code'] = config('global.default_currency_code');
                    $o_data = convert_all_elements_to_string($o_data);
                    $status = "1";
                    $message = "OTP verified successfully";
                }else{
                    $message = "OTP not matching";
                }
                            
            }else{
                $message ="Invalid request";
            }               
        }
        $o_data = convert_all_elements_to_string($o_data);
        return response()->json(['status' => (string)$status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data], 200);
    }

    public function verify_otp(REQUEST $request){
        $status   = "0";
        $message  = "";
        $o_data   = [];
        $errors   = [];

        $rules= [
            'otp' => 'required',
            'user_id' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
  
        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        }else{
            $user = User::find($request->user_id);
            if($user != null){
                if( $user->user_phone_otp == $request->otp ){
                    $user->user_phone_otp = '';
                    $user->dial_code = $user->temp_dialcode;
                    $user->phone = $user->temp_mobile;
                    $user->temp_dialcode = '';
                    $user->temp_mobile = '';
                   
                    $user->phone_verified = 1;
                    $user->status = 'active';
                    $user->updated_at = gmdate('Y-m-d H:i:s');
                    $user->save();
                    $status = "1";
                    $message = "OTP verified successfully";
                    $user = User::find($request->user_id);
                    $o_data = convert_all_elements_to_string($user);
                }else{
                    $message = "OTP not matching";
                }

                //$o_data = TempUser::where(['temp_user_id'=>$request->temp_user_id])->get()->first()->toArray();
            }else{
                $message ="Invalid request";
            }
        }
        $o_data = convert_all_elements_to_string($o_data);
        return response()->json(['status' => (string)$status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data], 200);
    }

    public function change_number(REQUEST $request){
        $status   = "0";
        $message  = "";
        $o_data   = [];
        $errors   = [];

        $rules['user_id'] = 'required';
        $rules['dial_code'] = 'required';
        $rules['phone']     = 'required';        
        
                
        $validator = Validator::make($request->all(), $rules);
  
        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        }else{

                $check = User::where(['dial_code'=>$request->dial_code,'phone'=>$request->phone])->get();
                if($check->count() > 0){
                    return response()->json([
                        'status' => "0",
                        'error' => (object)array(),
                        'message' => 'Phone Number already exists.',
                    ], 201);
                }else{
                    $user = User::find($request->user_id);
                }
            
            if(!empty($user)){
                $otp = generate_otp();
                $user->temp_dialcode = $request->dial_code;
                $user->temp_mobile = $request->phone;
                $user->phone_verified = 0;
                $user->user_phone_otp = $otp;
                send_normal_SMS(
                    "OTP for verifying your phone number recently changed at ".env('APP_NAME')." is ".$otp,
                    $request->dial_code."".$request->phone
                );
                $user->save();
                $status = "1";
                $message = "To verify your mobile number, please enter the OTP that is sent to your mobile number ending in ".preg_replace('~[+\d-](?=[\d-]{3})~', 'X', $user->phone);
                $o_data['user_id'] = $user->id;
            }
        }
        $o_data = convert_all_elements_to_string($o_data);
        return response()->json(['status' => (string)$status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data], 200);
    }

    public function driver_register(Request $request){
        
        $status   = "0";
        $message  = "";
        $o_data   = [];
        $errors   = [];
        
        $rules= [
            'step' => 'required|numeric'
        ];

        if($request->step == 1){

            $rules['name'] = 'required';
            $rules['email'] = 'required';
            $rules['password'] = 'required|confirmed';
            $rules['dial_code'] = 'required';
            $rules['phone'] = 'required';
            $rules['truck_type'] = 'required|exists:truck_types,id';
            $rules['account_type'] = 'required|in:0,1';
            $rules['user_device_type'] = 'required';
            $rules['user_device_token'] = 'required';
            $rules['user_device_id'] = 'required';
            
            if($request->account_type == '1'){
                //$rules['company_id'] = 'required|exists:users,id';
            }

        }
        elseif($request->step == 2){

            $rules['country_id'] = 'required|exists:countries,country_id';
            $rules['city_id'] = 'required|exists:cities,id';
            $rules['address'] = 'required';

            $rules['location'] = 'required';
            $rules['latitude'] = 'required';
            $rules['longitude'] = 'required';
            $rules['temp_user_id'] = 'required';

        }
        elseif($request->step == 3){

            $rules['emirates_id_or_passport_front'] = 'required|mimes:jpeg,png,jpg';
            $rules['emirates_id_or_passport_back'] = 'required|mimes:jpeg,png,jpg';
            $rules['driving_license'] = 'required|mimes:jpeg,png,jpg';
            $rules['driving_license_number'] = 'required|unique:driver_details';
            $rules['driving_license_expiry'] = 'required';
            $rules['driving_license_issued_by'] = 'required';
            $rules['vehicle_plate_number'] = 'required';
            $rules['vehicle_plate_place'] = 'required';
            $rules['mulkiya'] = 'required|mimes:jpeg,png,jpg';
            $rules['mulkiya_number'] = 'required';
            $rules['temp_user_id'] = 'required';            
        }
        else{
            return response()->json([
                'status' => "0",
                'error' => (object) array(),
                'message' => 'Invalid Step',
            ], 200);
        }


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
        
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();

            return response()->json([
                'status' => "0",
                'message' => $message,
                'error' => (object)$errors
            ], 200);
        }

        DB::beginTransaction();
        try{
            
            if($request->step == 1){

                if (Blacklist::where('user_device_id', $request->user_device_id)->first() != null) {
                    return response()->json([
                        'status' => "0",
                        'error' => (object)array(),
                        'message' => 'The existing device is in blacklist you cannot create account',
                    ], 200);
                }
        
                if (User::where('email', $request->email)->first() != null) {
                    return response()->json([
                        'status' => "0",
                        'error' => (object)array(),
                        'message' => 'Email already exists.',
                    ], 201);
                }
        
                if (User::where('phone', $request->phone)->first() != null) {
                    return response()->json([
                        'status' => "0",
                        'error' => (object)array(),
                        'message' => 'Phone already exists.',
                    ], 201);
                }

                TempUser::where('email',$request->email)->delete();
                TempUser::where('dial_code',$request->dial_code)->where('phone',$request->phone)->delete();


                $temp_user = new TempUser();
                $temp_user->name = $request->name;
                $temp_user->email = $request->email;
                $temp_user->password = $request->password;
                $temp_user->dial_code = $request->dial_code;
                $temp_user->phone = $request->phone;
                $temp_user->truck_type = $request->truck_type;
                $temp_user->account_type = $request->account_type;
                $temp_user->company_id = $request->company_id??0;
                $temp_user->user_device_type = $request->user_device_type;
                $temp_user->user_device_token = $request->user_device_token;
                $temp_user->user_device_id = $request->user_device_id;
                $temp_user->save();

                if($temp_user->temp_user_id > 0){
                    $status = "1";
                    $message = "Personal Information Saved Successfully..!";
                    $temp_user=TempUser::find($temp_user->temp_user_id);
                    $o_data =  $temp_user->toArray();
                }else{
                    $status = "0";
                    $message = "Failed To Save Personal Information";
                }
    
            }
            else if($request->step == 2){

                $temp_user = TempUser::find($request->temp_user_id);

                if(empty($temp_user)){
                    return response()->json([
                        'status' => "0",
                        'errors' => (object)[],
                        'message' => 'Invalid Temp User ID',
                    ], 401);
                }

                $country = Country::where('country_id',$request->country_id)->first();
                $city = City::find($request->city_id);
                $temp_user->address = $request->location;
                $temp_user->address_2 = $request->address;
                $temp_user->country_id = $request->country_id;
                $temp_user->city_id = $request->city_id;
                $temp_user->country = $country->country_name;
                $temp_user->city = $city->city_name;
                // $temp_user->zip_code = $request->zip_code;
                $temp_user->latitude = $request->latitude; 
                $temp_user->longitude = $request->longitude;
                $temp_user->save();  

                if($temp_user->temp_user_id > 0){
                    $status = "1";
                    $message = "Address Information Saved Successfully..!"; 
                    $temp_user = TempUser::find($request->temp_user_id);
                    $o_data =  $temp_user->toArray();
                }else{
                    $status = "0"; 
                    $message = "Failed To Save Address Information";
                }

            }
            else if($request->step == 3){
                                                
                $temp_user = TempUser::find($request->temp_user_id);
                
                if(empty($temp_user)){
                    return response()->json([
                        'status' => "0",
                        'errors' => (object)[],
                        'message' => 'Invalid Temp User ID',
                    ], 401);
                }

                if($request->file("driving_license") != null){
                    $response = image_upload($request,'users','driving_license');
                    
                    if($response['status']){
                        $temp_user->driving_license = $response['link'];
                    }
                }

                if($request->file("mulkiya") != null){
                        $response = image_upload($request,'users','mulkiya');
                        
                        if($response['status']){
                            $temp_user->mulkiya = $response['link'];
                        }
                }

                if($request->file("emirates_id_or_passport_front") != null){
                    $response = image_upload($request,'users','emirates_id_or_passport_front');
                    
                    if($response['status']){
                        $temp_user->emirates_id_or_passport = $response['link'];
                    }
                }

                if($request->file("emirates_id_or_passport_back") != null){
                    $response = image_upload($request,'users','emirates_id_or_passport_back');
                    
                    if($response['status']){
                        $temp_user->emirates_id_or_passport_back = $response['link'];
                    }
                }

                $vehicle_plate_place = City::find($request->vehicle_plate_place);
                
                $driving_license_issued_by = City::find($request->driving_license_issued_by);
                
                $temp_user->driving_license_number = $request->driving_license_number;
                $temp_user->driving_license_expiry = $request->driving_license_expiry;
                $temp_user->driving_license_issued_by = $driving_license_issued_by->city_name;
                $temp_user->vehicle_plate_number = $request->vehicle_plate_number;
                $temp_user->vehicle_plate_place = $vehicle_plate_place->city_name;
                $temp_user->mulkiya_number = $request->mulkiya_number;
                
                $temp_user->save();  
                
                $resp = $this->sync_temp_user($temp_user->temp_user_id);


                    if( $resp ){
                        $user = User::find($resp);
                        $tokenResult = $user->createToken('Personal Access Token')->accessToken;
                        $token = $tokenResult->token;
                        $user->user_access_token = $token;
                        $access_token = $token;
                        $user->save();

                         $token = $user->createToken($user->id.$user->name.$user->email);
                        $response = ['user' => $user, 'token' => $token->plainTextToken,'currency_code'=>config('global.default_currency_code')];
                        $user = User::find($user->id);
                        $user->user_access_token = $response['token'];
                        $user->save();

                        if ($user->firebase_user_key == null) {
                            $fb_user_refrence = $this->database->getReference('Users/')
                                ->push([
                                    'fcm_token' => $user->user_device_token,
                                    'user_name' => $user->name,
                                    'email' => $user->email,
                                    'dial_code' => $user->dial_code,
                                    'phone' => $user->phone,
                                    'user_id' => $user->id,
                                    'user_image' => $user->user_image,
                                    'last_login' => time()
                                ]);
                            $user->firebase_user_key = $fb_user_refrence->getKey();
                        } else {
                            $this->database->getReference('Users/' . $user->firebase_user_key . '/')->update(['fcm_token' => $user->user_device_token]);
                        }
                        $user->save();
                        
                        $otp = generate_otp();
                        $user->user_phone_otp = $otp;
                        $user->save();
                        
                        $name = $user->name;
                        $mailbody = view('emai_templates.verify_mail', compact('otp', 'name'));
                        send_email($user->email,'Verify Registration', $mailbody);

                        send_normal_SMS(
                            "OTP for verifying your account at ".env('APP_NAME')." is ".$otp,
                            $user->dial_code."".$user->phone
                        );

                        if(!empty($user->id > 0)){
                            $o_data['user_id'] = $user->id;
                            $status = "1";
                            $message = "To verify your mobile number, please enter the OTP that is sent to your mobile number ending in ".preg_replace('~[+\d-](?=[\d-]{3})~', 'X', $user->phone);
                            TempUser::where(['temp_user_id'=>$temp_user->temp_user_id])->delete();

                            try {
                                $this->sendEmailAndNotifyAdmin($user);
                            } catch (\Throwable $th) {
                                info($th->getMessage());
                            }


                        }else{
                            $message = "Failed to register please try again";
                        }

                    }else{
                        $message = "Failed To Complete Registration Please Try Again";
                    }

            }
            

            DB::commit();
        }catch (\Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
        }


        $o_data = convert_all_elements_to_string($o_data);
        return response()->json(['status' => (string)$status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data], 200);
    
    }

    function driver_signIn(Request $request)
    {
        
        $rules = [
            'email' =>      'required',
            'password' =>   'required',
            'user_device_type' => 'required',
            'user_device_token' => 'required',
            'user_device_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
        
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();

            return response()->json([
                'status' => "0",
                'message' => $message,
                'error' => (object)$errors
            ], 200);
        }

        if (Blacklist::where('user_device_id', $request->user_device_id)->first() != null) {
            return response()->json([
                'status' => "0",
                'error' => (object)array(),
                'message' => 'The existing device is in blacklist you cannot login with your account',
            ], 200);
        }

        $credentials = $request->only('email', 'password');
        $credentials['role_id'] = 2;
        $user = User::whereEmail(strtolower($credentials['email']))->first();
        if(!is_null($user) && auth()->attempt($credentials)){

            if (Blacklist::where('user_id', $user->id)->first() != null) {
                return response()->json([
                    'status' => "0",
                    'error' => (object)array(),
                    'message' => 'Your account is in blacklist you cannot login, please contact to Admin',
                ], 200);
            }

            if ($user->phone_verified == 0) {
                return response()->json([
                    'status' => "0",
                    'error' => (object) ['msg' => 'Invalid Login'],
                    'message' => 'Your Phone Number is not verified',
                ], 200);
            }

            if($user->status == 'active'){
                if(isset($request->user_device_token)){
                    $user->update(['user_device_token' => $request->user_device_token,
                        'user_device_type' => $request->user_device_type]);
                }
                $token = $user->createToken($user->id.$user->name.$user->email);
                $response = ['user' => $user, 'token' => $token->plainTextToken,'currency_code'=>config('global.default_currency_code')];
                $userNode = User::find($user->id);
                $userNode->user_access_token = $response['token'];
                $userNode->save();
                $response=convert_all_elements_to_string($response);
                Auth::logoutOtherDevices($request->password);
                if (config('global.server_mode') == 'local') {
                    \Artisan::call('update:firebase_node ' . $user->id);
                } else { 
                    exec("php " . base_path() . "/artisan update:firebase_node " . $user->id . " > /dev/null 2>&1 & ");
                }

                return response()->json(
                    [
                        'status' => "1",
                        'code' => (string) 200,
                        'message' => 'Login Successful',
                        'oData' => (object) $response,
                        'errors' => (object)array()
                    ], 200);

                //return $this->successResponse($response, 'Login Successful');
            }else{

                return new JsonResponse(
                    [
                        'status' => "0",
                        'code' => (string) 400,
                        'message' => 'Your Account is inactive by admin. Please wait. or contact admin for more details',
                        'errors' => (object) ['msg' => 'Invalid Login']
                    ], 200);
                    
            }
        }else{

            return new JsonResponse(
                [
                    'status' => "0",
                    'code' => (string) 400,
                    'message' => 'Login Failed',
                    'errors' => (object) ['msg' => 'Invalid credentials']
                ], 200);

        }
    }

    public function user_image_submit(REQUEST $request){
        $status   = "0";
        $message  = "";
        $o_data   = [];
        $errors   = [];

        $rules= [
            'temp_user_id'=>'required',
            'default_image_index'=>'required',
            'pics.*'    => function ($attribute, $value, $fail) {
                if (!$value) {
                    $fail(':attribute required.');
                }
                $is_image = Validator::make(
                    ['upload' => $value],
                    ['upload' => 'image']
                )->passes();
    
    
                if (!$is_image) {
                    $fail(':attribute must be image.');
                }
    
                if ($is_image) {
                    $validator = Validator::make(
                        ['image' => $value],
                        ['image' => "max:5500"]
                    );
                    if ($validator->fails()) {
                        $fail(":attribute must be one megabyte or less.");
                    }
                }
            }
        ];

  
        $validator = Validator::make($request->all(), $rules);
  
        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        }else{
            $user = TempUser::find($request->temp_user_id);
            if($user){
                $extra_file_names = [];
                if($request->hasfile('pics')) {
                    foreach($request->file('pics') as $file)
                    {
                        $dir = config('global.upload_path')."/".config('global.user_image_upload_dir');
                        $file_name2 = time().uniqid().".".$file->getClientOriginalExtension();
                        $file->storeAs(config('global.user_image_upload_dir'),$file_name2,config('global.upload_bucket'));
                        $extra_file_names[] = $file_name2;
                    }
                }
                $default_image = '';
                if(!empty($extra_file_names)){
                    foreach($extra_file_names as $index=> $image){
                        $file_path = get_uploaded_image_url($image,'user_image_upload_dir'); 
                        $extension = pathinfo($file_path, PATHINFO_EXTENSION);

                        $gallery = new TempGallery();
                        
                        if( $index == $request->default_image_index ){
                            $gallery->is_default = 1;
                            $default_image = $image;
                        }
                        $gallery->extension = $extension;
                        $gallery->temp_user_id = $request->temp_user_id;
                        $gallery->file_path = $image;
                        $gallery->save();
                    }
                    $user->blur_pics =  $request->blur_pics;
                    if($default_image){
                        $user->user_image = $default_image;
                    }else{
                        $user->user_image = $extra_file_names[0]??0;
                    }
                    $user->save();
                    $status = "1";
                    $message = "Image uploaded successfully";
                }else{
                    $message = "Faild to upload images";
                }
            }
        }
        return response()->json(['status' => (string)$status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data], 200);
    }

    public function login_with_phone(REQUEST $request){
        $status   = "0";
        $message  = "";
        $o_data   = [];
        $errors   = [];

        $rules= [
            'dial_code'=>'required',
            'phone'=>'required',
        ];

  
        $validator = Validator::make($request->all(), $rules);
  
        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        }else{
            $dial_code = $request->dial_code;
            $phone     = $request->phone;
            $user = User::where(['dial_code'=>$dial_code,'phone'=>$phone])->get();
            if($user->count() > 0){
                $otp = generate_otp();
                $user = User::find($user->first()->id);
                $user->user_phone_otp = $otp;
                send_normal_SMS(
                    "OTP for login your account at ".env('APP_NAME')." is ".$otp,
                    $request->dial_code.$request->phone
                );
                $user->save();
                $status  = "1";
                $message = "Otp sent successfully";
            }else{
                $message = "Invalid user";
            }
        }
        return response()->json(['status' => (string)$status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data], 200);
    }

    public function verify_login_otp(REQUEST $request){
        $status   = "0";
        $message  = "";
        $o_data   = [];
        $errors   = [];
        $access_token = '';

        $rules= [
            'dial_code'=>'required',
            'phone'=>'required',
            'otp'  => 'required'
        ];

  
        $validator = Validator::make($request->all(), $rules);
  
        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        }else{
            $dial_code = $request->dial_code;
            $phone     = $request->phone;
            $otp       = $request->otp;
            $user = User::where(['dial_code'=>$dial_code,'phone'=>$phone])->get();
            if($user->count() > 0){
                
                $user = $user->first();
                if($user->user_phone_otp == $otp){
                    
                    $status = "1";
                    $message = "You have successfully loged in";
                    $data= $this->login_success($user->id);
                    $access_token = $data['access_token'];
                    $o_data = convert_all_elements_to_string($data['user']);
                }else{
                    $message = "Otp not match";
                }
                
            }else{
                $message = "Invalid Request";
            }
        }
        return response()->json(['status' => (string)$status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data,'access_token'=>(string)$access_token], 200);
      }
    private function login_success($user_id){
        $user = User::find($user_id);
        if ($user->firebase_user_key == null) {
            $fb_user_refrence = $this->database->getReference('Users/')
                ->push([
                    'fcm_token' => $user->user_device_token,
                    'user_name' => $user->name,
                    'email' => $user->email,
                    'dial_code' => $user->dial_code,
                    'phone' => $user->phone,
                    'user_id' => $user->id,
                    'user_image' => $user->user_image,
                    'last_login' => time()
                ]);
            $user->firebase_user_key = $fb_user_refrence->getKey();
        } else {
            $this->database->getReference('Users/' . $user->firebase_user_key . '/')->update(['fcm_token' => $user->user_device_token,'last_login' => time()]);
        }
        $tokenResult = $user->createToken('Personal Access Token')->accessToken;
        $token = $tokenResult->token;
        $user->user_access_token = $token;
        $access_token = $token;
        $user->user_phone_otp='';
        $user->save();
        return ['user'=>$user->toArray(),'access_token'=>$access_token];
    }




    protected function _registerOrLoginUser($data){
        $user = User::where('email',$data->email)->first();
          if(!$user){
             $user = new User();
             $user->name = $data->name;
             $user->email = $data->email;
             $user->provider_id = $data->id;
             $user->avatar = $data->avatar;
             $user->save();
          }
        Auth::login($user);
    }

    
    //Facebook Login
    public function redirectToFacebook(){
        return Socialite::driver('facebook')->stateless()->redirect();
        $message = "suucess";
        return response()->json( $message, 200);
    }
        
    //facebook callback  
    public function handleFacebookCallback(){
        $user = Socialite::driver('facebook')->stateless()->user();
        $this->_registerorLoginUser($user);
    }

    public function generateToken($user)
    {
        return $user->createToken($user->id . $user->name . $user->email)->plainTextToken;
    }
    public function socialLogin(Request $request)
    {
        $status  = "0";
        $message = "";
        $o_data  = [];
        $errors  = [];
        $accessToken = '';
        $validator = Validator::make($request->all(), [
            'email'         => 'required',
            'name' => 'required',
            'user_device_type' => 'required',
            'user_device_token' => 'required',
            'social_key' => 'required',
            'user_device_id'=>'required'
        ]);


        if ($validator->fails()) {
            $message = "Validation error occured";
            $errors = $validator->messages();
            return response()->json(['status' => "0", 'message' => $message, 'errors' => (object)$errors, 'oData' => (object)[], 'accessToken' => '']);
        } else {
            if (User::where('email', $request->email)->where('login_type','normal')->first() != null) {
                return response()->json(['status' => "0", 'message' => 'Email already used for normal login', 'errors' => (object)[], 'oData' => (object)[], 'accessToken' => '']);
            }
            else if (User::where('email', $request->email)->first() != null) {
                $user = User::where('email', $request->email)->first();
                
            } else {
                $user = new User([
                    'name' => $request->name,
                    'email' => $request->email,
                    'device_type' => $request->device_type,
                    'points'=> config('global.signup_point'),
                    'fcm_token' => $request->fcm_token,
                    'password' => Hash::make(uniqid()),
                    'phone_otp' => 1234, // rand(1000, 9999)
                    'social_key' => $request->social_key,
                    'email_verified_at' => gmdate('Y-m-d H:i:s'),
                    'login_type'=>'social',
                    'role_id'=>3
                ]);
                $user->save();              
                
            }
            $status = "1";            
            $token = $user->createToken($user->id.$user->name.$user->email);
            User::where(['id' => $user->id])->update(['user_access_token' => $token->plainTextToken]);
           
            $accessToken = $token->plainTextToken;

            $o_data = [
                        'user_id'      =>  $user->id,
                        'name' => $user->name,
                        'first_name' => ($user->first_name)??'',
                        'last_name' => ($user->last_name)??'',
                        'email' => ($user->email)??'',
                        'dial_code' => ($user->dial_code)??'',
                        //'phone_number' => ($user->phone)??'',
                        'phone' => ($user->phone)??'',
                        'user_device_type'      =>  $request->device_type,
                        'user_access_token'     =>  $accessToken,
                        'fcm_token'             =>  $request->fcm_token,
                        'country_id' => ($user->country_id)??'',
                        'city_id' => ($user->city_id)??'',
                        'profile_image'=>$user->image,
                        'phone_verified' => (string) ($user->phone_verified??0),
                        'firebase_user_key'=>$user->firebase_user_key,
                        'updated_on'            =>  gmdate('Y-m-d H:i:s')
                    ];

            $i_data=[
                        'fcm_token'    =>  $request->fcm_token,
                    ];
            if ( empty($user->firebase_user_key) ) {
                $fb_user_refrence = $this->database->getReference('Users/')
                        ->push([
                            'fcm_token' => $request->fcm_token,
                            'user_name' => $o_data['name'],
                            'user_id'   => $user->id,
                            'email'     => $user->email
                        ]);

                $i_data['firebase_user_key'] = $fb_user_refrence->getKey();

                $o_data['firebase_user_key'] = $i_data['firebase_user_key'];
            } else {
                $this->database->getReference('Users/' . $user->firebase_user_key . '/')->update([
                            'fcm_token' => $request->fcm_token,
                            'user_name' => $user->name,
                            'user_id'   => $user->id,
                            'email'     => $user->email
                        ]);
            }
            User::where(['id' => $user->id])->update($i_data);
            
        }
        return response()->json(['status' => $status, 'message' => 'successfully logged in', 'errors' => (object)$errors, 'oData' => (object)$o_data, 'accessToken' => $accessToken, 'is_guest' => false]);
    }
}
