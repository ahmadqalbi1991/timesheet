<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\TruckType;
use App\Models\City;
use App\Models\Languages;
use App\Models\Category;
use App\Models\Company;
use App\Models\User;
use App\Models\Deligate;
use Validator;
use DB;

class BasicController extends Controller
{
    //
    public function country_list(REQUEST $request){
        $status   = "0";
        $message  = "";
        $o_data   = [];
        $errors   = [];

        $country_list = Country::where(['country_status'=>1,'deleted_at'=>NULL])->orderBy('country_name','asc')->get();
        if(!empty($country_list)){
            $status = "1";
            $message = "success";
            $o_data['list'] = $country_list->toArray();
        }else{
            $message = "no data to list";
        }
        $o_data = convert_all_elements_to_string($o_data);
        return response()->json(['status' => (string)$status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data], 200);
    }

    public function dial_codes(REQUEST $request){
        $status   = "0";
        $message  = "";
        $o_data   = [];
        $errors   = [];

        $dial_codes = Country::where(['country_status'=>1,'deleted_at'=>NULL])->orderBy('country_name','asc')->select('dial_code')->get();
        if(!empty($dial_codes)){

            $dial_codes = $dial_codes->map(function ($item) {
                $item->dial_code_text = '+'.$item->dial_code; 
                return $item;
            });

            $status = "1";
            $message = "success";
            $o_data['list'] = $dial_codes;
        }else{
            $message = "no data to list";
        }
        $o_data = convert_all_elements_to_string($o_data);
        return response()->json(['status' => (string)$status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data], 200);
    }

    public function city_list(REQUEST $request){
        $status   = "0";
        $message  = "";
        $o_data   = [];
        $errors   = [];

        $rules= [
            //'country_id'        => 'required|numeric',
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

        $city_list = City::where(['city_status'=>1])->orderBy('city_name','asc');
        if(!empty($request->country_id))
        {
            $city_list = $city_list->where('country_id',$request->country_id);   
        }
        
        $city_list = $city_list->get()->toArray();

        if(!empty($city_list)){
            $status = "1";
            $message = "success";
            $o_data['list'] = $city_list;
        }else{
            $message = "no data to list";
        }
        $o_data = convert_all_elements_to_string($o_data);
        return response()->json(['status' => (string)$status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data], 200);
    }
    public function deligate_list(REQUEST $request)
    {
        $status   = "0";
        $message  = "";
        $o_data   = [];
        $errors   = [];
        $o_data = \App\Models\Deligate::select('deligates.*')->orderBy('id','asc')
        ->get();
        $o_data = convert_all_elements_to_string($o_data);
        return response()->json(['status' => (string)$status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data], 200);
    }
    public function language_list(REQUEST $request){
        $status   = "0";
        $message  = "";
        $o_data   = [];
        $errors   = [];

        $country_list = Languages::where(['language_status'=>1,'deleted_at'=>NULL])->orderBy('language_name','asc')->get()->toArray();
        if(!empty($country_list)){
            $status = "1";
            $message = "success";
            $o_data['list'] = $country_list;
        }else{
            $message = "no data to list";
        }
        $o_data = convert_all_elements_to_string($o_data);
        return response()->json(['status' => (string)$status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data], 200);
    }
    public function activity_list(REQUEST $request){
        $status   = "0";
        $message  = "";
        $o_data   = [];
        $errors   = [];

        $country_list = Category::with('children')->where(['category_status'=>1,'deleted_at'=>NULL,'parent_category_id'=>0])->orderBy('category_name','asc')->get()->toArray();
        if(!empty($country_list)){
            $status = "1";
            $message = "success";
            $o_data['list'] = $country_list;
        }else{
            $message = "no data to list";
        }
        $o_data = convert_all_elements_to_string($o_data);
        return response()->json(['status' => (string)$status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data], 200);
    }

    public function truck_list(){

        $status   = "0";
        $message  = "";
        $o_data   = [];
        $errors   = [];

        $truck_list = TruckType::where('status','active')->select('id','truck_type','dimensions','icon','max_weight_in_tons')->where('is_container',0)->orderBy('sort_order','asc')->get();
        if(!empty($truck_list)){
            $status = "1";
            $message = "success";
            foreach ($truck_list as $key => $value) {
                $truck_list[$key]->max_weight_in_tons_kg = (float)$value->max_weight_in_tons * 1000;
            }
            $o_data['list'] = $truck_list->toArray();
        }else{
            $message = "no data to list";
        }
        $o_data = convert_all_elements_to_string($o_data);
        return response()->json(['status' => (string)$status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data], 200);
    }

    public function truck_detail(Request $request){

        $status   = "0";
        $message  = "";
        $o_data   = [];
        $errors   = [];

        $rules= [
            'id'        => 'required|numeric',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        }else{
            
            $truck_details = TruckType::where('id',$request->id)->where('status','active')->select('id','truck_type','dimensions','icon','max_weight_in_tons')->first();

            if(!empty($truck_details)){                
                $status = "1";
                $message = "success";
                $o_data = $truck_details;
            }else{
                $message = "No any Truck Found";   
            }

        }

        $o_data = convert_all_elements_to_string($o_data);
        return response()->json(['status' => (string)$status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data], 200);
    }

    public function account_types(){

        $status   = "0";
        $message  = "";
        $o_data   = [];
        $errors   = [];

        $account_types = DB::table('driver_types')->select('id','type')->get();
        if(!empty($account_types)){
            $status = "1";
            $message = "success";
            $o_data['account_types'] = $account_types->toArray();
        }else{
            $message = "no data to list";
        }
        $o_data = convert_all_elements_to_string($o_data);
        return response()->json(['status' => (string)$status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data], 200);
    }

    public function company_list(){

        $status   = "0";
        $message  = "";
        $o_data   = [];
        $errors   = [];

        $company_list = User::join('companies','companies.user_id','=','users.id')->where('users.status','active')->select('users.id','users.name','companies.logo')->get();
        if(!empty($company_list)){

            $company_list = $company_list->map(function ($item) {
                $item->logo =  get_uploaded_image_url($item->logo, 'company_image_upload_dir', 'placeholder.png');
                return $item;
            });

            $status = "1";
            $message = "success";
            $o_data['list'] = $company_list->toArray();
        }else{
            $message = "no data to list";
        }
        $o_data = convert_all_elements_to_string($o_data);
        return response()->json(['status' => (string)$status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data], 200);
    }

     public function settings(){

        $status   = "1";
        $message  = "";
        $o_data   = [];
        $errors   = [];
        $o_data = \App\Models\Settings::select('contact_number','whatsapp_number')->get()->first();
        
        $o_data = convert_all_elements_to_string($o_data);
        return response()->json(['status' => (string)$status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data], 200);
    }
    public function containerList(){

        $status   = "0";
        $message  = "";
        $o_data   = [];
        $errors   = [];

        $truck_list = TruckType::where('status','active')->select('id','truck_type','truck_type as name','dimensions','icon','max_weight_in_tons','max_weight_in_tons as max_weight_in_metric_tons')->where('is_container',1)->get();
        if(!empty($truck_list)){
            $status = "1";
            $message = "success";
            foreach ($truck_list as $key => $value) {
                $truck_list[$key]->max_weight_in_tons_kg = $value->max_weight_in_tons * 1000;
                $truck_list[$key]->max_weight_in_metric_tons_kg = $value->max_weight_in_metric_tons * 1000;
            }
            $o_data['list'] = $truck_list->toArray();
        }else{
            $message = "no data to list";
        }
        $o_data = convert_all_elements_to_string($o_data);
        return response()->json(['status' => (string)$status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data], 200);

        
    }



    
}
