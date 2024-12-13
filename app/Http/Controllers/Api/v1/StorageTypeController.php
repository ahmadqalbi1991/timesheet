<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StorageType;
use App\Models\User;
use Validator;
class StorageTypeController extends Controller
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

    public function get_storage_types(Request $request){

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
            $storage_types = StorageType::where('status','active')->select('id','name')->get();

            if(!empty($storage_types)){
                $status = "1";
                $message = "success";
                $o_data['list'] = $storage_types->toArray();
            }else{
                $message = "no data to list";
            }
            
        }

        $o_data = convert_all_elements_to_string($o_data);
        return response()->json(['status' => (string)$status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data], 200);
    }    
}
