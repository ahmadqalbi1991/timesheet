<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Page;
use Validator;

class CMSController extends Controller
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

    public function get_all_pages(Request $request){
        
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
            $pages = Page::where('status',1)->select('id','title','slug','description')->get();

            if(!empty($pages)){
                $status = "1";
                $message = "success";
                $o_data['list'] = $pages->toArray();
            }else{
                $message = "no data to list";
            }
        }
        
        $o_data = convert_all_elements_to_string($o_data);
        return response()->json(['status' => (string)$status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data], 200);
    }    

    public function get_single_page(Request $request){
        
        $status   = "0";
        $message  = "";
        $o_data   = [];
        $errors   = [];

        $validator = Validator::make($request->all(), [
          
            'page_uid'           => 'required' 
        ]);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        }else{

            $user_id = $this->validateAccesToken($request->access_token);
            $page = Page::where('slug',$request->page_uid)->select('id','title','slug','description')->first();

            if(!empty($page)){
                $status = "1";
                $message = "success";
                $o_data['page'] = $page->toArray();
                if($request->page_uid == 'help') {
                   $settings =  \App\Models\AppSettings::first();
                   $o_data['email'] = $settings->email;
                   $o_data['website'] = $settings->website;
                   $o_data['contact_numbers'] = $settings->contact_numbers;
                }
            }else{
                $message = "no and page found";
            }
        }
        
        $o_data = convert_all_elements_to_string($o_data);
        return response()->json(['status' => (string)$status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data], 200);
    }

    public function helpRequest(Request $request){
        
        $status   = "0";
        $message  = "";
        $o_data   = [];
        $errors   = [];

        $validator = Validator::make($request->all(), [
            'access_token' => 'required',
            'subject'           => 'required',
            'message'           => 'required',
        ]);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        }else{

            $user_id = $this->validateAccesToken($request->access_token);
            
            $obj = new \App\Models\HelpRequest();
            $obj->user_id = $user_id ;
            $obj->subject = $request->subject;
            $obj->message = $request->message;
            $obj->created_at = time_to_uae(gmdate('Y-m-d H:i:s'));
           
            if($obj->save()) {
                $status = "1";
                $message = "Your request submitted successfully";
            }
        }
        
        $o_data = convert_all_elements_to_string($o_data);
        return response()->json(['status' => (string)$status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data], 200);
    }

    public function faqs(Request $request){
        
        $status   = "0";
        $message  = "";
        $o_data   = [];
        $errors   = [];

        $validator = Validator::make($request->all(), [
           
           
        ]);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        }else{
            $status = "1";
            $user_id = $this->validateAccesToken($request->access_token);
            $page = Page::where('slug','faq')->select('id','title','slug','description')->first();
            $o_data = $page ;
            $o_data['list'] = \App\Models\Faq::where('active',1);
            if(isset($request->usertype) && $request->usertype=='customer' ) {
                $o_data['list'] =  $o_data['list']->whereIn('usertype',[0,3]);
            } else if(isset($request->usertype) && $request->usertype=='driver' ) {
                $o_data['list'] =  $o_data['list']->whereIn('usertype',[0,2]);
            }
            $o_data['list'] =  $o_data['list']->get();
            
        }
        
        $o_data = convert_all_elements_to_string($o_data);
        return response()->json(['status' => (string)$status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data], 200);
    }


}
