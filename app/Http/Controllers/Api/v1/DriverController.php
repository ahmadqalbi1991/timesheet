<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DriverDetail;
use Validator;
use DB;

class DriverController extends Controller
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

    public function addAdditionalNumber(Request $request)
    {
        $status = "0";
        $message = "";
        $o_data = [];
        $errors = [];
        
        $validator = Validator::make($request->all(), [
            'access_token'           => 'required',
            'dial_code'              => 'required',
            'phone'                 => 'required',
            'id'                    => ''
        ]);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        } else {            
            $user_id = $this->validateAccesToken($request->access_token);
            $userdeatils = \App\Models\User::find($user_id);  

            $checkALreadyDialCodeExist = \App\Models\UserAdditionalPhone::where('dial_code',$request->dial_code)->where('user_id',$user_id);
            if(isset($request->id) && $request->id > 0 ) {
                $checkALreadyDialCodeExist =  $checkALreadyDialCodeExist ->where('id','!=',$request->id);
            }

            $checkALreadyDialCodeExist =  $checkALreadyDialCodeExist ->first();
            if($checkALreadyDialCodeExist != null) {
                $message = "Mobile number already added for this country";
            } else { 
                $checkExist =  \App\Models\UserAdditionalPhone::where('dial_code',$request->dial_code)->where('mobile',$request->phone)->first();    
                if($checkExist !=null) {
                    $message = "Mobile number already exist";

                } else {
                    $otp   = generate_otp();
                    $userdeatils->user_phone_otp = $otp;
                    $userdeatils->save();
                    $message = "Otp send successfully";
                    $status = "1";
                }
            }
            

        }
        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => (object)$o_data], 200);
    }

    public function verifyAdditionalPhoneOtp(Request $request)
    {
        $status = "0";
        $message = "";
        $o_data = [];
        $errors = [];               
        $validator = Validator::make($request->all(), [
            'access_token'           => 'required',
            'dial_code'              => 'required',
            'phone'                 => 'required',
            'otp'                   =>'required',
            'id'                    =>''
        ]);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        } else {            
            $user_id = $this->validateAccesToken($request->access_token);
            $userdeatils = \App\Models\User::find($user_id);          
            
            
            if($userdeatils->user_phone_otp == $request->otp) {
                if(isset($request->id)) {
                    $obj = \App\Models\UserAdditionalPhone::find($request->id);
                } else {
                    $obj = new \App\Models\UserAdditionalPhone();
                    $obj->user_id = $user_id;
                }
                if($obj !=null) {
                    $obj->dial_code = $request->dial_code;
                    $obj->mobile    = $request->phone;
                    $obj->save();
                    $status         = "1";
                    $message        = "Mobile number added successfully";
                } else {
                    $message        = "Something went wrong";
                }
                

            } else {
                $message = "Invalid otp";
            }

        }
        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => (object)$o_data], 200);
    }

    public function deleteAdditionalPhone(Request $request)
    {
        $status = "0";
        $message = "";
        $o_data = [];
        $errors = [];               
        $validator = Validator::make($request->all(), [
            'access_token'           => 'required',           
            'id'                    =>'required'
        ]);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        } else {            
            $user_id = $this->validateAccesToken($request->access_token); 
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

    public function phoneByCountry(Request $request)
    {
        $status = "0";
        $message = "";
        $o_data = [];
        $errors = [];               
        $validator = Validator::make($request->all(), [
            'access_token'           => 'required',           
            'countrycode'                    =>'required'
        ]);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        } else {         
            $status = "1";  
            $message = "country code saved"; 
            $user_id = $this->validateAccesToken($request->access_token); 
            $country = \App\Models\Country::where('iso_code',$request->countrycode)->first();
            $uObj = \App\Models\User::find($user_id);
            $uObj->default_iso_code = $request->countrycode;
            $uObj->save(); 
            $o_data = $uObj;
            /*$phoneDetails= \App\Models\UserAdditionalPhone::where('user_additional_phone.user_id',$user_id)
            ->join('countries','countries.dial_code','user_additional_phone.dial_code')
            ->where('iso_code',$request->countrycode)->get(['id','mobile','user_additional_phone.dial_code'])->toArray();
            $country = \App\Models\Country::where('iso_code',$request->countrycode)->first();
            if($country !=null ) {
                $uObj = \App\Models\User::find($user_id);
                if($country->dial_code == $uObj->dial_code ) {
                    $phoneDetails[] = ['id'=>'0','mobile'=>$uObj->phone,'dial_code'=>$uObj->dial_code];
                }
            }
            

            $o_data['list'] = $phoneDetails;*/
        }
        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => (object)$o_data], 200);
    }
}