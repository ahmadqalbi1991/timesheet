<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DB;
use Hash;
use Kreait\Firebase\Contract\Database;
use PDO;
use Validator;


class UserController extends Controller
{
    
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

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
            if ($user != null) {//$user->active == 1
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

    public function change_password(REQUEST $request)
    {
        $status = "0";
        $message = "";
        $o_data = [];
        $errors = [];
        $user_id = $this->validateAccesToken($request->access_token);
        $validator = Validator::make($request->all(), [
            'access_token' => 'required',
            'old_password' => 'required',
            'new_password' => 'required',
        ]);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        } else {
            $user = User::find($user_id);
            if (Hash::check($request->old_password, $user->password)) {
                $user->password = bcrypt($request->new_password);
                $user->save();
                $status = "1";
                $message = "Password Updated successfully";
            } else {
                $message = "Old password not match";
            }

        }
        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object)$errors, 'oData' => (object)$o_data]);
    }
}
