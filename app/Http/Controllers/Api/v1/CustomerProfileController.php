<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Country;
use App\Models\City;
use Validator;

class CustomerProfileController extends Controller
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

    public function customer_edit_profile(Request $request){
        
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
            if(!empty($user)){
                $data = [];
                $data = [
                    'name' => $user->name,
                    'email' => $user->email,
                    'dial_code' => $user->dial_code,
                    'dial_code_display' => '+'.$user->dial_code,
                    'phone' => $user->phone,
                    'country' => $user->country,
                    'country_id' => Country::where('country_name',$user->country)->first()->country_id ?? '',
                    'city_id' => City::where('city_name',$user->city)->first()->id ?? '',
                    'city' => $user->city,
                    'zip_code' => $user->zip_code,
                    'address' => $user->address_2,
                    'location' => $user->address,
                    'profile_image' => $user->profile_image,
                    'latitude' => $user->latitude,
                    'longitude' => $user->longitude,
                    'trade_licence_number' => $user->trade_licence_number,
                    'trade_licence_doc' => $user->trade_licence_doc,

                ];     
                $status = "1";
                $message = "success";
                $o_data['user'] = $data;
            }else{
                $status = "0";
                $message = "Not Found Any User";
            }
        }

        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => $o_data], 200);

    }

    public function customer_update_profile(Request $request){

        $status   = "0";
        $message  = "";
        $o_data   = [];
        $errors   = [];

        $user_id = $this->validateAccesToken($request->access_token);

        $rules= [
            'name'              => 'required',
            //'email'             => 'required|email|unique:users,email,'.$user_id,
            'dial_code'         => 'required',
            'phone'             => 'required|unique:users,phone,'.$user_id,
            'country_id'        => '',
            'city_id'           => '',
            'zip_code'          => '',
            'address'           => 'required',
            'location'          => '',
            'latitude'          => '',
            'longitude'         => '',
            'trade_licence_number' => '',
            'trade_licence_doc'    => '',
            'access_token'      => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        } else {

            $country = Country::where('country_id',$request->country_id)->first();
            $city = City::find($request->city_id);
    
            $customer   = User::find($user_id);
            $customer->name    = $request->name;
           // $customer->email  = $request->email;
            //$customer->dial_code    = $request->dial_code;
            //$customer->phone    = $request->phone;
           // $customer->address = $request->location;
            $customer->address_2 = $request->address;
           // $customer->country = $country->country_name;
            //$customer->city = $city->city_name;
           // $customer->zip_code = $request->zip_code;
            $customer->latitude = $request->latitude;
            $customer->longitude = $request->longitude;

            $customer->trade_licence_number = $request->trade_licence_number??'';
            $customer->updated_at  = gmdate('Y-m-d H:i:s');
            $customer->save();
            if($request->file("trade_licence_doc") != null){
                $response = image_upload($request,'users','trade_licence_doc');
                
                if($response['status']){
                    $customer->trade_licence_doc = $response['link'];
                    $customer->save();
                }
            }
            if(!empty($customer)){
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
}
