<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\LaravelAdapter;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Validator;
use Hash;
use DB;
class CompaniesController extends Controller
{
    //
    public function index(){
        $page_heading = "Companies";
        $mode="List";
        return view('admin.company.list',compact('mode', 'page_heading'));
    }


    public function create($id=''){
        $page_heading = 'Company';
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
        $company = [];
        if($id){

            $mode = "Edit";
            $id = decrypt($id);
            $company = User::find($id);
            //$company->company->logo = url(Storage::url('comapny/'.$company->company->logo));
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
        return view('admin.company.create',compact('mode', 'page_heading','company_license','id','company_name','company_status','logo','operations','site_modules','address','latitude','longitude','company_email','dial_code','company_email','phone','license_expiry','company'));

    }

    public function view($id=''){
        $page_heading = 'Company';
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
        $o_data['redirect'] = route('company.list');
       
            $company_name  = $request->company_name;
            $company_status= $request->company_status;
            $license_expiry= $request->license_expiry;

            $id         = $request->id;
            $check      = Company::whereRaw('Lower(name) = ?',[strtolower($company_name)])->where('id','!=',$id)->get();
            
            if(false){
                $message = "Company Already Addded";
                $errors['company_name'] = 'Company Already Exists With Same Name';
            }else{
                if($id){

                    $rules = [
                        'company_name' => 'required',
                        'email' => 'required|unique:users,email,'.$id,
                        'dial_code' => 'required',
                        'phone' => 'required|unique:users,phone,'.$id,
                        'address' => 'required',
                        'latitude' => 'required',
                        'longitude' => 'required',
                        'license_expiry' => 'required'

                    ];
            
                    $validator = Validator::make($request->all(),$rules);
            
                    if ($validator->fails()) {
                        $status = "0";
                        $message = "Validation error occured";
                        $errors = $validator->messages();
                    }
                    else {

                        if($request->file("logo") != null || $request->file("company_license") != null){

                            $user = User::find($id);
                            $user->name = $request->company_name;
                            $user->email = $request->email;
                            if($request->password != null){
                                $user->password = Hash::make($request->password);
                            }
                            $user->dial_code = $request->dial_code;
                            $user->phone = $request->phone;
                            $user->phone_verified = 1;
                            $user->role_id = 4;
                            $user->status = $request->company_status;
                            $user->address = $request->address;
                            $user->latitude = $request->latitude;
                            $user->longitude = $request->longitude;
                            $user->address_2 = $request->address_2;
                            $user->country = $request->country;
                            $user->city = $request->city;
                            $user->zip_code = $request->zip_code;

                            $user->save();

                            if(!empty($user)){
                            
                                $company   = Company::where('user_id',$id)->first();
                                $company->name    = $company_name;
                                $company->status  = $company_status;
                                $company->license_expiry  = $license_expiry;
                                
                                    $response = image_upload($request,'comapny','logo');
                                    
                                    if($response['status']){
                                        $company->logo= $response['link'];
                                    }
                                    
                                $response = image_upload($request,'comapny','company_license');
                                
                                if($response['status']){
                                    $company->company_license= $response['link'];
                                }
                                    
                                $company->save();

                            }
                        }
                        else{   

                            $user = User::find($id);
                            $user->name = $request->company_name;
                            $user->email = $request->email;
                            if($request->password != null){
                                $user->password = Hash::make($request->password);
                            }
                            $user->dial_code = $request->dial_code;
                            $user->phone = $request->phone;
                            $user->phone_verified = 1;
                            $user->role_id = 4;
                            $user->status = $request->company_status;
                            $user->address = $request->address;
                            $user->latitude = $request->latitude;
                            $user->longitude = $request->longitude;
                            $user->address_2 = $request->address_2;
                            $user->country = $request->country;
                            $user->city = $request->city;
                            $user->zip_code = $request->zip_code;
                            $user->save();

                            if(!empty($user)){
                                $company   = Company::where('user_id',$id)->first();
                                $company->name    = $company_name;
                                $company->status  = $company_status;
                                $company->license_expiry  = $license_expiry;
                                $company->save();     
                            }

                        }

                        $status = "1";
                        $message = "Company Updated Successfully";
                    }
                }else{

                    $rules = [
                        'company_name' => 'required',
                        'email'     => 'required|unique:users',
                        'password'  => 'required',
                        'dial_code' => 'required',
                        'phone'     => 'required|unique:users',
                        'logo' => 'required',
                        'company_license' => 'required',
                        'address' => 'required',
                        'latitude' => 'required',
                        'longitude' => 'required',
                        'license_expiry' => 'required'
                    ];
            
                    $validator = Validator::make($request->all(),$rules);
            
                    if ($validator->fails()) {
                        $status = "0";
                        $message = "Validation error occured";
                        $errors = $validator->messages();
                    }
                    else {
                        
                        $user = new User();
                        $user->name = $request->company_name;
                        $user->email = $request->email;
                        $user->password = Hash::make($request->password);
                        $user->dial_code = $request->dial_code;
                        $user->phone = $request->phone;
                        $user->phone_verified = 1;
                        $user->role_id = 4;
                        $user->email_verified_at = Carbon::now();
                        $user->status = $request->company_status;
                        $user->address = $request->address;
                        $user->latitude = $request->latitude;
                        $user->longitude = $request->longitude;
                        $user->address_2 = $request->address_2;
                        $user->country = $request->country;
                        $user->city = $request->city;
                        $user->zip_code = $request->zip_code;
                        $user->save();     

                        if(!empty($user)){
                            $company   = new Company();
                            $company->name    = $company_name;
                            $company->status  = $company_status;
                            $company->license_expiry  = $license_expiry;
                            $company->user_id  = $user->id;

                            if($request->file("logo") != null){
                                $response = image_upload($request,'comapny','logo');
                                
                                if($response['status']){
                                    $company->logo= $response['link'];
                                }
                            }

                            if($request->file("company_license") != null){
                                $response = image_upload($request,'comapny','company_license');
                                
                                if($response['status']){
                                    $company->company_license= $response['link'];
                                }
                            }

                            $company->save();

                            $status = "1";
                            $message = "Company Created Successfully";
                        }
                        else{
                            $status = "0";
                            $message = "Company Could Not Created";
                        }    
                    }

                }
            
        }

        echo json_encode(['status' => $status, 'errors' => $errors, 'message' => $message, 'oData' => $o_data]);
    }


    public function getCompanyList(Request $request){

        // $sqlBuilder =  DB::table('variations')

        $sqlBuilder = User::join('companies','companies.user_id','=','users.id')->select([
            DB::raw('users.name::text as company_name'),
            DB::raw('users.email::text as company_email'),
            DB::raw('users.dial_code::text as dial_code'),
            DB::raw('users.phone::text as phone'),
            DB::raw('users.status::text as status'),
            DB::raw('users.created_at::text as created_at'),
            DB::raw('users.id::text as id')
        ])->whereNotIn('users.id', function($query) {
            $query->select('user_id')
                  ->from('blacklists')
                  ->whereColumn('users.id','=','blacklists.user_id');
        })->where('role_id',4);
        $dt = new Datatables(new LaravelAdapter);

        $dt->query($sqlBuilder);

        $dt->edit('created_at',function($data){
            return (new Carbon($data['created_at']))->format('d/m/y H:i A');
        });

        $dt->edit('phone', function ($data) {
            return "+" . $data['dial_code'] . " " . $data['phone'];
        });

        $dt->edit('status',function($data){
            if(get_user_permission('company','u')){
                $checked = ($data["status"]=='active')?"checked":"";
                    $html= '<label class="switch s-icons s-outline  s-outline-warning  mb-4 mr-2">
                        <input type="checkbox" data-role="active-switch"
                            data-href="'.route('company.status_change', ['id' => encrypt($data['id'])]).'"
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
                    if(get_user_permission('company','v')){
                    $html.='<a class="dropdown-item"
                        href="'.route('company.view',['id'=>encrypt($data['id'])]).'"><i
                            class="bx bx-show"></i> View</a>';
                    }    

                    if(get_user_permission('company','u')){
                    $html.='<a class="dropdown-item"
                        href="'.route('company.edit',['id'=>encrypt($data['id'])]).'"><i
                            class="flaticon-pencil-1"></i> Edit</a>';
                    }
                    
                    if(get_user_permission('company','d')){
                        $html.='<a class="dropdown-item" data-role="unlink"
                            data-message="Do you want to remove this category?"
                            href="'.route('company.delete',['id'=>encrypt($data['id'])]).'"><i
                                class="flaticon-delete-1"></i> Delete</a>';
                    }
                    
                    if (get_user_permission('company', 'u')) {
                        $html .= '<a class="dropdown-item"
                                href="' . route('blacklists.add', ['id' => encrypt($data['id'])]) . '"><i class="fa-solid fa-user-lock"></i> BlackList</a>';
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

        $company = User::where(['id'=>$id])->get();

        if( $company ) {
            User::where(['id' => $id])->delete();
            Company::where(['user_id' => $id])->delete();
            $message = "Company deleted successfully";
            $status = "1";
        }
        else {
            $message = "Invalid Company data";
        }

        echo json_encode([
            'status' => $status , 'message' => $message
        ]);
    }

}
