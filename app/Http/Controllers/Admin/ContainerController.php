<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerType;
use App\Models\Company;
use Validator;
use Illuminate\Support\Facades\Auth;
use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\LaravelAdapter;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\TruckType;


class ContainerController extends Controller
{
    //
    public function index(){
        $page_heading = "Containers";
        $mode="List";
        return view('admin.containers.list',compact('mode', 'page_heading'));
    }

    public function create($id=''){
        $page_heading = 'Containers';
        $mode = "Create";
        $truck_type  = '';
        $name  = '';
        $type  = '';
        $dimension= '';
        $icon= '';
        $max_weigt= '';
        $status= '';
        $permissions= [];

        if($id){

            $mode = "Edit";
            $id = decrypt($id);
            $truck_type = TruckType::find($id);

            $name  = $truck_type->truck_type;

            $dimension  = $truck_type->dimensions;
            $type  = $truck_type->type;

            $icon= $truck_type->icon;

            $max_weigt= $truck_type->max_weight_in_tons;
            $status= $truck_type->status;

        }
        $site_modules = config('crud.site_modules');
        $operations   = config('crud.operations');
        return view('admin.containers.create',compact('mode', 'page_heading','truck_type','name','id','dimension','icon','max_weigt','type','status','operations','site_modules'));

    }

    public function store(REQUEST $request){
        
        $status     = "0";
        $message    = "";
        $o_data     = [];
        $errors     = [];
        $o_data['redirect'] = route('truck_type.list');
       
            $type_nmae  = $request->truck_type;
            $type  = 'ftl';
            $dimension  = $request->dimension;
            $icon  = $request->icon;
            $max_weigt = $request->max_weigt;
            $status = $request->status;
            $id         = $request->id;
            
            $check      = TruckType::whereRaw('Lower(truck_type) = ?',[strtolower($type_nmae)])->where('id','!=',$id)->get();
            
            if($check->count() > 0){
                $message = "Container Already Addded";
                $errors['truck_type'] = 'Container Already Addded';
            }else{
                if($id){

                    $rules = [
                        'truck_type' => '',
                        'dimension' => 'required',
                        'max_weigt' => 'required',
                        'type' => 'required',
                        'status' => 'required',
                    ];
            
                    $validator = Validator::make($request->all(),$rules);
            
                    if ($validator->fails()) {
                        $status = "0";
                        $message = "Validation error occured";
                        $errors = $validator->messages();
                    }
                    else {

                        if($request->file("icon") != null){
                            $truck_type   = TruckType::find($id);
                            $truck_type->truck_type    = $type_nmae;
                            $truck_type->dimensions  = $dimension;
                            $truck_type->max_weight_in_tons = $max_weigt;
                            $truck_type->type = $type;
                            $truck_type->status  = $status;
                            $truck_type->is_container  = 1;
                            $response = image_upload($request,'truct_type','icon');
                            
                            if($response['status']){
                                $truck_type->icon= $response['link'];
                            }
                                
                            $truck_type->save();
                        }
                        else{
                            $truck_type   = TruckType::find($id);
                            $truck_type->truck_type    = $type_nmae;
                            $truck_type->dimensions  = $dimension;
                            $truck_type->max_weight_in_tons = $max_weigt;
                            $truck_type->type = $type;
                            $truck_type->status  = $status;
                             $truck_type->is_container  = 1;
                            $truck_type->save();
                        }

                        $status = "1";
                        $message = "Container Updated Successfully";
                    }
                }else{


                    $rules = [
                        'truck_type' => 'required',
                        'dimension' => 'required',
                        'max_weigt' => 'required',
                        'type' => 'required',
                        'icon' => 'required',
                        'status' => 'required',
                    ];
            
                    $validator = Validator::make($request->all(),$rules);
            
                    if ($validator->fails()) {
                        $status = "0";
                        $message = "Validation error occured";
                        $errors = $validator->messages();
                    }
                    else {

                        $truck_type   = new TruckType();
                        $truck_type->truck_type    = $type_nmae;
                        $truck_type->dimensions  = $dimension;
                        $truck_type->type = $type;
                        $truck_type->max_weight_in_tons = $max_weigt; 
                        
                        $response = image_upload($request,'truct_type','icon');
                            
                        if($response['status']){
                            $truck_type->icon= $response['link'];
                        }
                        $truck_type->status  = $status;
                        $truck_type->is_container  = 1;
                        $truck_type->save();

                        $status = "1";
                        $message = "Container Added Successfully";
                    }

                }
            
        }

        echo json_encode(['status' => $status, 'errors' => $errors, 'message' => $message, 'oData' => $o_data]);
    }


    public function getcontainersList(Request $request){

        $sqlBuilder = TruckType::select([
            DB::raw('truck_type::text as truck_type'),
            DB::raw('dimensions::text as dimensions'),
            DB::raw('type::text as type'),
            DB::raw('max_weight_in_tons::text as max_weight_in_tons'),
            DB::raw('status::text as status'),
                              DB::raw('created_at::text as created_at'),
            DB::raw('id::text as id')
        ])->where('is_container',1);
        $dt = new Datatables(new LaravelAdapter);

        $dt->query($sqlBuilder);

        $dt->edit('created_at',function($data){
            return (new Carbon($data['created_at']))->format('d/m/y H:i A');
        });

        $dt->edit('type',function($data){
            return strtoupper($data['type']);
        });

        $dt->edit('status',function($data){
            if(get_user_permission('containers','u')){
                $checked = ($data["status"]=='active')?"checked":"";
                     $html= '<label class="switch s-icons s-outline  s-outline-warning  mb-4 mr-2">
                        <input type="checkbox" data-role="active-switch"
                            data-href="'.route('containers.change_status', ['id' => encrypt($data['id'])]).'"
                            '.$checked.' >
                        <span class="slider round"></span>
                    </label>';
            }else{
                $checked = ($data["status"]=='active')?"Active":"InActive";
                $class = ($data["status"]=='active')?"badge-success":"badge-danger";
                $html = '<span class="badge '.$class.'" '.$checked.' </span>';
            }
          return $html;
        });


        $dt->add('action', function($data) {
            $html = '<div class="dropdown custom-dropdown">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink7"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <i class="flaticon-dot-three"></i>
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink7">';
                    if(get_user_permission('containers','u')){
                    $html.='<a class="dropdown-item"
                        href="'.route('containers.edit',['id'=>encrypt($data['id'])]).'"><i
                            class="flaticon-pencil-1"></i> Edit</a>';
                    }
                    
                    if(get_user_permission('containers','d')){
                        $html.='<a class="dropdown-item" data-role="unlink"
                            data-message="Do you want to remove this truck type?"
                            href="'.route('containers.destroy',['id'=>encrypt($data['id'])]).'"><i
                                class="flaticon-delete-1"></i> Delete</a>';
                        }                             
                    

            $html.='</div>
            </div>';
            return $html;
        });

        return $dt->generate();
    }


    public function change_status(REQUEST $request){
        $status = "0";
        $message = "";
        $o_data  = [];
        $errors = [];
        $id = $request->id;
        $id = decrypt($id);

        $item = TruckType::where(['id'=>$id])->get();
 
        if($item->count() > 0){

            TruckType::where('id','=',$id)->update(['status'=>$request->status == '1'?'active':'inactive']);
            $status = "1";
            $message= "Status changed successfully";
        }else{
            $message = "Faild to change status";
        }

        echo json_encode(['status' => $status, 'errors' => $errors, 'message' => $message, 'oData' => $o_data]);

    }

    public function delete(REQUEST $request,$id) {
        $status = "0";
        $message = "";


        $id = decrypt( $id );

        $truck_type = TruckType::where(['id' => $id])->first();

        if( $truck_type ) {
            TruckType::where(['id' => $id])->delete();
            $message = "Truck Type deleted successfully";
            $status = "1";
        }
        else {
            $message = "Invalid Truck Type";
        }

        echo json_encode([
            'status' => $status , 'message' => $message
        ]);
    }


}
