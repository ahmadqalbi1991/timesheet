<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\User;
use Validator;
class AddressController extends Controller
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

    public function get_address_list(Request $request){

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
            $addresses = Address::join('countries','countries.country_id','=','addresses.country_id')
                        ->join('cities','cities.id','=','addresses.city_id')
                        ->where('user_id',$user_id)->where('is_deleted',0)
                        ->select('addresses.*','countries.country_name','cities.city_name')
                        ->withCount('collection_address')
                        ->withCount('deliver_address')
                        ->orderBy('collection_address_count','desc')
                        ->orderBy('deliver_address_count','desc')
                        ->get();

            if(!empty($addresses)){
                $status = "1";
                $message = "success";
                $o_data['list'] = $addresses->toArray();
            }else{
                $message = "no data to list";
            }
            
        }

        $o_data = convert_all_elements_to_string($o_data);
        return response()->json(['status' => (string)$status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data], 200);
    }

    public function get_single_address(Request $request){

        $status   = "0";
        $message  = "";
        $o_data   = [];
        $errors   = [];
        
        $validator = Validator::make($request->all(), [
            'access_token' => 'required',
            'id'           => 'required'
        ]);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        }else{

            $user_id = $this->validateAccesToken($request->access_token);
            $address = Address::join('countries','countries.country_id','=','addresses.country_id')
                        ->join('cities','cities.id','=','addresses.city_id')
                        ->where('addresses.id',$request->id)->where('user_id',$user_id)
                        ->where('is_deleted',0)->first();
            
            if(!empty($address)){
                $status = "1";
                $message = "success";
                $o_data['address'] = $address;
            }else{
                $message = "No any Address Found";
            }
            
        }

        $o_data = convert_all_elements_to_string($o_data);
        return response()->json(['status' => (string)$status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data], 200);
    }


    public function add_address(Request $request){

        $status   = "0";
        $message  = "";
        $o_data   = [];
        $errors   = [];
        
        $validator = Validator::make($request->all(), [
            'access_token' => 'required',
            'address'      => 'required',
            'latitude'     => 'required',
            'longitude'    => 'required',
            'city_id'      => 'required',
            'country_id'   => 'required',
            'zip_code'     => 'required',
            'dial_code'     => 'required',
            'phone'     => 'required',        
        ]);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        }else{

            $user_id = $this->validateAccesToken($request->access_token);
            $address = new Address();

            $address->user_id = $user_id;
            $address->address = $request->address;
            $address->latitude = $request->latitude;
            $address->longitude = $request->longitude;
            $address->city_id = $request->city_id;
            $address->country_id = $request->country_id;
            $address->zip_code = $request->zip_code;
            $address->dial_code = $request->dial_code;
            $address->phone = $request->phone;
            $address->building = $request->building;
            $address->save();

            if(!empty($address)){
                $status = "1";
                $message = "Address Successfully Saved";
                $o_data  = $address;
            }else{
                $message = "Sorry Address Could Not Save";
            }
            
            
        }

        $o_data = convert_all_elements_to_string($o_data);
        return response()->json(['status' => (string)$status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data], 200);
    }

    public function update_address(Request $request){

        $status   = "0";
        $message  = "";
        $o_data   = [];
        $errors   = [];
        
        $validator = Validator::make($request->all(), [
            'access_token' => 'required',
            'address'      => 'required',
            'latitude'     => 'required',
            'longitude'    => 'required',
            'city_id'      => 'required',
            'country_id'   => 'required',
            'zip_code'     => 'required',
            'dial_code'     => 'required',
            'phone'         => 'required',
            'id'           => 'required',        
        ]);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        }else{

            $user_id = $this->validateAccesToken($request->access_token);
            $address = Address::where('id',$request->id)->where('user_id',$user_id)->first();

            if(empty($address)){
                return response()->json([
                    'status' => "0",
                    'message' => 'No any address found ',
                    'error' => (object)$errors
                ], 200);                
            }

            $address->address = $request->address;
            $address->latitude = $request->latitude;
            $address->longitude = $request->longitude;
            $address->city_id = $request->city_id;
            $address->country_id = $request->country_id;
            $address->zip_code = $request->zip_code;
            $address->dial_code = $request->dial_code;
            $address->phone = $request->phone;
            $address->building = $request->building;
            $address->save();

            if(!empty($address)){
                $status = "1";
                $message = "Address Successfully Updated";
                $o_data  = $address;
            }else{
                $message = "Sorry Address Could Not Update";
            }
            
        }

        $o_data = convert_all_elements_to_string($o_data);
        return response()->json(['status' => (string)$status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data], 200);
    }

    public function delete_address(Request $request){

        $status   = "0";
        $message  = "";
        $o_data   = [];
        $errors   = [];
        
        $validator = Validator::make($request->all(), [
            'access_token' => 'required',
            'id'           => 'required',        
        ]);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        }else{ 

            $user_id = $this->validateAccesToken($request->access_token);
            $address = Address::where('id',$request->id)->where('user_id',$user_id)->first();

            $address->is_deleted = 1;
            $address->save();

            if(!empty($address)){
                $status = "1";
                $message = "Address Deleted Successfully";
            }else{
                $message = "Sorry Address Could Not Delete";
            }
            
        }

        $o_data = convert_all_elements_to_string($o_data);
        return response()->json(['status' => (string)$status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data], 200);
    }
}
