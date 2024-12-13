<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\City;
use Validator;
use Illuminate\Support\Facades\Auth;
use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\LaravelAdapter;
use DB;
use Carbon\Carbon;


class CityController extends Controller
{
    public function index(){
        $page_heading = "City";
        $mode="List";
        return view('admin.city.list',compact('mode','page_heading'));
    }

    public function create($id=''){
        $page_heading = 'City';
        $mode="Create";
        $countries  = DB::table('countries')->where('country_status',1)->where('deleted_at',null)->get();
        $city_name  = '';
        $city_status= '';
        $country_id      = '';
        $permissions= [];

        if($id){
            $page_heading = "City";
            $mode ="Edit";
            $id = decrypt($id);
            $role = City::find($id);
            $city_name = $role->city_name;
            $city_status = $role->city_status;
            $country_id  = $role->country_id;
 
        }
        return view('admin.city.create',compact('mode','page_heading','id','countries','city_name','city_status','country_id'));

    }

    public function submit(REQUEST $request){
        $status     = "0";
        $message    = "";
        $o_data     = [];
        $errors     = [];
        $o_data['redirect'] = route('cities.list');
        $rules = [
            'city_name' => 'required',
            'country' => 'required'
        ];

        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        }
        else {
            $city_name  = $request->city_name;
            $city_status= $request->city_status;
            $country_id      = $request->country;
            $id         = $request->id;
            $check      = City::whereRaw('Lower(city_name) = ?',[strtolower($city_name)])->where('id','!=',$id)->get();
            if($check->count() > 0){
                $message = "City Already Addded";
                $errors['city_name'] = 'City Already Added';
            }else{
                if($id){
                    DB::beginTransaction();
                    try{
                        $role   = City::find($id);
                        $role->city_name    = $city_name;
                        $role->city_status  = $city_status;
                        $role->country_id        = $country_id;
                        $role->save();
                        $id            = $role->id;


                        DB::commit();
                        $status = "1";
                        $message = "City updated Successfully";

                    }catch(EXCEPTION $e){
                        DB::rollback();
                        $message = "Failed to update City ".$e->getMessage();
                    }
                }else{
                    DB::beginTransaction();
                    try{
                        $role   = new City();
                        $role->city_name    = $city_name;
                        $role->city_status  = $city_status;
                        $role->country_id        = $country_id;
                        $role->save();
                        $id            = $role->id;


                        DB::commit();
                        $status = "1";
                        $message = "City Added Successfully";

                    }catch(EXCEPTION $e){
                        DB::rollback();
                        $message = "Failed to create City ".$e->getMessage();
                    }
                }
            }
        }

        echo json_encode(['status' => $status, 'errors' => $errors, 'message' => $message, 'oData' => $o_data]);
    }

    public function getcityList(Request $request){

        // $sqlBuilder =  DB::table('variations')

        $sqlBuilder = City::join('countries','countries.country_id','=','cities.country_id')->select([
            DB::raw('city_name::text as city_name'),
            DB::raw('countries.country_name::text as country_name'),
            DB::raw('city_status::text as city_status'),
            DB::raw('cities.created_at::text as created_at'),
            DB::raw('cities.id::text as id'),
        ]);
        $dt = new Datatables(new LaravelAdapter);

        $dt->query($sqlBuilder);



        $dt->edit('created_at',function($data){
            return (new Carbon($data['created_at']))->format('d/m/y H:i A');
        });

        $dt->edit('city_status',function($data){
            $checked = ($data["city_status"]==1)?"checked":"";
            $html= '<label class="switch s-icons s-outline  s-outline-warning  mb-4 mr-2">
                <input type="checkbox" data-role="active-switch"
                    data-href="'.route('cities.status_change', ['id' => encrypt($data['id'])]).'"
                    '.$checked.' >
                <span class="slider round"></span>
            </label>';
          return $html;
        });


        $dt->add('action', function($data) {
            $html = '<div class="dropdown custom-dropdown">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink7"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <i class="flaticon-dot-three"></i>
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink7">';
                    if(get_user_permission('countries','u')){
                    $html.='<a class="dropdown-item"
                        href="'.route('cities.edit',['id'=>encrypt($data['id'])]).'"><i
                            class="flaticon-pencil-1"></i> Edit</a>';
                    }
                    if(get_user_permission('countries','d')){
                    $html.='<a class="dropdown-item" data-role="unlink"
                        data-message="Do you want to remove this record?"
                        href="'.route('cities.delete',['id'=>encrypt($data['id'])]).'"><i
                            class="flaticon-delete-1"></i> Delete</a>';
                    }
            $html.='</div>
            </div>';
            return $html;
        });

        return $dt->generate();
    }

    public function change_status(REQUEST $request,$id){
        $status = "0";
        $message = "";
        $o_data  = [];
        $errors = [];

        $id = decrypt($id);

        $item = City::where(['id'=>$id])->get();
        if($item->count() > 0){
            $item=$item->first();
            City::where('id','=',$id)->update(['city_status'=>$request->status]);
            $status = "1";
            $message= "Status changed successfully";
        }else{
            $message = "Failed to change status";
        }

        echo json_encode(['status' => $status, 'errors' => $errors, 'message' => $message, 'oData' => $o_data]);

    }

    public function delete(REQUEST $request,$id) {
        $status = "0";
        $message = "";


        $id = decrypt( $id );

        $category_data = City::where(['id' => $id])->first();

        if( $category_data ) {
            City::where(['id' => $id])->delete();
            $message = "City deleted successfully";
            $status = "1";
        }
        else {
            $message = "Invalid City data";
        }

        echo json_encode([
            'status' => $status , 'message' => $message
        ]);
    }

    public function getcityOptions(Request $request){
        
        $status = "0";
        $message = "";
        $country = Country::where('country_name',$request->country)->first();
        $cities = DB::table('cities')->where('city_status',1)->where('country_id',$country->country_id)->get();
        if(count($cities) > 0){
            $status = "1"; 
        }

        $options = view('admin.city.options',compact('cities'))->render();
        
        return response()->json(['status' => $status, 'options' => $options],200);

    }
}
