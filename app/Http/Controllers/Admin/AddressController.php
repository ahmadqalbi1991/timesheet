<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\User;
use App\Models\Country;
use App\Models\City;
use Illuminate\Support\Facades\Auth;
use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\LaravelAdapter;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Validator;
use Hash;
use DB;
class AddressController extends Controller
{
    //
    public function index(REQUEST $request){
        $page_heading = "Address";
        $user_id = $request->user_id;
        $mode="List";
        return view('admin.address.list',compact('mode', 'page_heading','user_id'));
    }


    public function create(REQUEST $request,$id=''){
        $user_id = $request->user_id;
        $page_heading = 'Address';
        $mode = "Create";
        $company_name  = '';
        $company_email = '';
        $dial_code = '';
        $phone = '';
        $company_status = '';
        $address = '';
        $latitude = '';
        $longitude = '';
        $logo= '';
        $company_license= '';
        $license_expiry = '';
        $permissions= [];
        $datamain = [];
        if($id){

            $mode = "Edit";
            $id = decrypt($id);
            $datamain = Address::find($id);
            $company_email = $datamain->email;
            $dial_code = $datamain->dial_code;
            $phone = $datamain->phone;
            $company_status = $datamain->status;
            $address = $datamain->address;
            $latitude = $datamain->latitude;
            $longitude = $datamain->longitude;

        }
        
        $countries = Country::select('country_name','country_id')->where('country_status',1)->where('deleted_at',null)->get();
        $cities = City::select('city_name','id')->where('city_status',1)->get();
        $site_modules = config('crud.site_modules');
        $operations   = config('crud.operations');
        return view('admin.address.create',compact('mode', 
        'page_heading','company_license','id','user_id','company_status',
        'logo','operations','site_modules','address','latitude','longitude','company_email','dial_code',
        'company_email','phone','datamain','countries','cities'));

    }

    public function view($id=''){
        $page_heading = 'Address';
        $mode = "Detail";
        $company_name  = '';
        $company_email = '';
        $dial_code = '';
        $phone = '';
        $company_status = '';
        $address = '';
        $latitude = '';
        $longitude = '';
        $logo= '';
        $company_license= '';
        $license_expiry = '';
        $permissions= [];

        if($id){

            $mode = "Edit";
            $id = decrypt($id);
            $company = User::find($id);
            $company->company->logo = url(Storage::url('comapny/'.$company->company->logo));
            $company_name = $company->name;
            $company_email = $company->email;
            $dial_code = $company->dial_code;
            $phone = $company->phone;
            $company_status = $company->status;
            $address = $company->address;
            $latitude = $company->latitude;
            $longitude = $company->longitude;
            $logo = $company->company->logo;
            $company->company->company_license = url(Storage::url('comapny/'.$company->company->company_license));
            $company_license = $company->company->company_license;
            $license_expiry = $company->company->license_expiry;

        }
        $site_modules = config('crud.site_modules');
        $operations   = config('crud.operations');
        return view('admin.company.view',compact('mode', 'page_heading','company_license','id','company_name','company_status','logo','operations','site_modules','address','latitude','longitude','company_email','dial_code','company_email','phone','license_expiry'));

    }

    public function submit(REQUEST $request){
        
        $status     = "0";
        $message    = "";
        $o_data     = [];
        $errors     = [];
        $o_data['redirect'] = route('address.list',['user_id'=>$request->user_id]);
       
          

            $id         = $request->id;
          
             

                    $rules = [
            'address'      => 'required',
            'latitude'     => 'required',
            'longitude'    => 'required',
            'city_id'      => 'required',
            'country_id'   => 'required',
            'zip_code'     => 'required',
            'dial_code'     => 'required',
            'phone'     => 'required',   

                    ];
            
                    $validator = Validator::make($request->all(),$rules);
            
                    if ($validator->fails()) {
                        $status = "0";
                        $message = "Validation error occured";
                        $errors = $validator->messages();
                    }
                    else {
                        
                        if($id){
                        $address = Address::find($id);
                        }
                        else{
                        $address = new Address();
                        $address->user_id = $request->user_id;
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

                           


                        $status = "1";
                        $message = "Address saved Successfully";
                    }
                
       
        echo json_encode(['status' => $status, 'errors' => $errors, 'message' => $message, 'oData' => $o_data]);
    }


    public function getaddressList(Request $request){

        // $sqlBuilder =  DB::table('variations')
        $user_id = $request->user_id;
       
        $sqlBuilder = Address::select([
            DB::raw('addresses.address::text as address'),
            DB::raw('addresses.latitude::text as latitude'),
            DB::raw('addresses.longitude::text as longitude'),
            DB::raw('addresses.city_id::text as city_id'),
            DB::raw('addresses.country_id::text as country_id'),
            DB::raw('addresses.zip_code::text as zip_code'),
            DB::raw('addresses.dial_code::text as dial_code'),
            DB::raw('addresses.phone::text as phone'),
            DB::raw('addresses.building::text as building'),
            DB::raw('addresses.created_at::text as created_at'),
            DB::raw('addresses.id::text as id'),
            DB::raw('addresses.user_id::text as user_id')
        ])->where('user_id',$user_id);
        
        $dt = new Datatables(new LaravelAdapter);

        $dt->query($sqlBuilder);

        $dt->edit('created_at',function($data){
            return (new Carbon($data['created_at']))->format('d/m/y H:i A');
        });

        $dt->edit('phone', function ($data) {
            return "+" . $data['dial_code'] . " " . $data['phone'];
        });

        
        $dt->add('action', function($data) {
            $html = '<div class="dropdown custom-dropdown">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink7"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <i class="flaticon-dot-three"></i>
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink7">';
                      

                    if(get_user_permission('address','u')){
                    $html.='<a class="dropdown-item"
                        href="'.route('address.edit',['id'=>encrypt($data['id'])]).'"><i
                            class="flaticon-pencil-1"></i> Edit</a>';
                    }
                    
                    if(get_user_permission('address','d')){
                        $html.='<a class="dropdown-item" data-role="unlink"
                            data-message="Do you want to remove this address?"
                            href="'.route('address.delete',['id'=>encrypt($data['id'])]).'"><i
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

        $item = User::where(['id'=>$id])->get();
 
        if($item->count() > 0){
            User::where('id',$id)->update(['status'=>$request->status == '1'?'active':'inactive']);
            Company::where('user_id','=',$id)->update(['status'=>$request->status == '1'?'active':'inactive']);
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

        $company = Address::where(['id'=>$id])->get();

        if( $company ) {
            Address::where(['id' => $id])->delete();
            $message = "Address deleted successfully";
            $status = "1";
        }
        else {
            $message = "Invalid Address data";
        }

        echo json_encode([
            'status' => $status , 'message' => $message
        ]);
    }
    public function get_list(REQUEST $request){
        
        $user_id = $request->cusid??0;
        $datamain = Address::where(['user_id' => $user_id])->get();
        
        return view('admin.address.list_by_user',compact('datamain'));
    }

    

}
