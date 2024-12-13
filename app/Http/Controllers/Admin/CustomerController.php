<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CustomerType;
use App\Models\Wallet;
use Validator;
use Illuminate\Support\Facades\Auth;
use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\LaravelAdapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\NamedRange;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use App\Imports\ProductImport;
use App\Exports\ExportReports;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Company;
use App\Models\Country;
use App\Models\Address;
use Illuminate\Support\Facades\Hash;

use Carbon\Carbon;

use App\Models\Role;
use App\Models\RolePermissions;
use Response;


class CustomerController extends Controller
{
    const PRODUCT_TYPE_SIMPLE = 1;
    const PRODUCT_TYPE_VARIABLE = 2;
    const ATTRIBUTE_COL_START = 26;
    public function index(REQUEST $request)
    {
        $page_heading = "Customers";
        $mode = "List";
        return view('admin.customers.list', compact('mode', 'page_heading'));
    }

    public function getcustomerList(Request $request)
    {

        // $sqlBuilder =  DB::table('variations')

        $sqlBuilder = User::join('customer_types','customer_types.id','=','users.customer_type_id')->select([
            'email',
            'dial_code',
            'phone',
            'user_image',
            'customer_types.name as customer_type',
            DB::raw('users.name::text as user_name'),
            DB::raw('user_status::text as user_status'),
            DB::raw('users.created_at::text as created_at'),
            DB::raw('users.id::text as id')
        ])->where(['role_id' => 1]);//
        $dt = new Datatables(new LaravelAdapter);

        $dt->query($sqlBuilder);


        $dt->edit('created_at', function ($data) {

            return (new Carbon($data['created_at']))->format('d/m/y H:i A');
        });
        $dt->edit('phone', function ($data) {
            return "+" . $data['dial_code'] . " " . $data['phone'];
        });
        // $dt->edit('user_image', function ($data) {
        //     return "
        //     <ul class='list-unstyled users-list m-0 avatar-group d-flex align-items-center'>
        //         <li data-bs-toggle='tooltip' data-popup='tooltip-custom' data-bs-placement='top' class='avatar avatar-xs pull-up' aria-label='Sophia Wilkerson'  data-bs-original-title='Sophia Wilkerson'>
        //             <img class='rounded-circle' src='" . get_uploaded_image_url($data['user_image'], 'user_image_upload_dir') . "' style='width:50px; height:50px;'>
        //         </li>
        //     </ul>";
        // });

        $dt->edit('user_status', function ($data) {
            if (get_user_permission('users', 'u')) {
                $checked = ($data["user_status"] == 1) ? "checked" : "";
                $html = '<label class="switch s-icons s-outline  s-outline-warning  mb-4 mr-2">
                        <input type="checkbox" data-role="active-switch"
                            data-href="' . route('users.status_change', ['id' => encrypt($data['id'])]) . '"
                            ' . $checked . ' >
                        <span class="slider round"></span>
                    </label>';
            } else {
                $checked = ($data["user_status"] == 1) ? "Active" : "InActive";
                $class = ($data["user_status"] == 1) ? "badge-success" : "badge-danger";
                $html = '<span class="badge ' . $class . '" ' . $checked . ' </span>';
            }
            return $html;
        });


        $dt->add('action', function ($data) {
            $html = '<div class="dropdown custom-dropdown">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink7"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <i class="flaticon-dot-three"></i>
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink7">';
            // if (get_user_permission('users', 'v')) {
            //     $html .= '<a class="dropdown-item"
            //             href="' . route('customers.view', ['id' => encrypt($data['id'])]) . '"><i
            //                 class="bx bx-file"></i> View</a>';
            // }
           if (get_user_permission('users', 'u')) {
               $html .= '<a class="dropdown-item"
                       href="' . route('customers.edit', ['id' => encrypt($data['id'])]) . '"><i
                           class="flaticon-pencil-1"></i> Edit</a>';
           }
           

            // if (get_user_permission('users', 'd')) {
            //     $html .= '<a class="dropdown-item" data-role="unlink"
            //             data-message="Do you want to remove this user?"
            //             href="' . route('user_roles.delete', ['id' => encrypt($data['id'])]) . '"><i
            //                 class="flaticon-delete-1"></i> Delete</a>';
            // }
            $html .= '</div>
            </div>';
            return $html;
        });

        return $dt->generate();
    }

    public function change_status(REQUEST $request, $id)
    {
        $status = "0";
        $message = "";
        $o_data = [];
        $errors = [];

        $id = decrypt($id);

        $item = User::where(['id' => $id])->get();
        if ($item->count() > 0) {
            $item = $item->first();
            User::where('id', '=', $id)->update(['user_status' => $request->status]);
            $status = "1";
            $message = "Status changed successfully";
        } else {
            $message = "Faild to change status";
        }

        echo json_encode(['status' => $status, 'errors' => $errors, 'message' => $message, 'oData' => $o_data]);

    }
    function view($id){
        $id = decrypt($id);
        $page_heading = "Customer";
        $mode = "Information";
        $user = User::findOrFail($id);
        return view('admin.customers.view', compact('mode', 'page_heading','user'));
    }

    public function edit($id){
        $id = decrypt($id);
        $page_heading = "Customer";
        $mode = "Edit";
        $user = User::find($id);
        $customer_types = CustomerType::where('deleted_at',null)->where('status','active')->get();
        if(!empty($user)){
            return view('admin.customers.edit', compact('mode', 'page_heading','user','customer_types'));       
        }else{
            abort(404);
        }
    }

    public function update(Request $request, $id){
       
        $status     = "0";
        $message    = "";
        $o_data     = [];
        $errors     = [];
        $o_data['redirect'] = route('customers.list');
        $rules = [
            'customer_type_id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'dial_code' => 'required',
        ];

        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        }

        $user = User::find($id);

        if(!empty($user)){
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->user_status = $request->user_status;
            $user->address = $request->address;
            $user->customer_type_id = $request->customer_type_id;
            $user->dial_code =$request->dial_code;
            
            $user->save();
            $status = "1";    
            $message = "Customer Updated Successfully";
        } else {
            $message = "Faild to change customer Information";
        }

        echo json_encode(['status' => $status, 'errors' => $errors, 'message' => $message, 'oData' => $o_data]);            
    }    

    public function listCust(REQUEST $request)
    {
        $page_heading = "Customers";
        $mode = "List";
        return view('admin.customerData.list', compact('mode', 'page_heading'));
    }

    public function getcustomerTotalList(Request $request){

        // $sqlBuilder =  DB::table('variations')

        $sqlBuilder = User::select([
            DB::raw('name::text as name'),
            DB::raw('email::text as email'),
            DB::raw('dial_code::text as dial_code'),
            DB::raw('phone::text as phone'),
            DB::raw('status::text as status'),
            DB::raw('users.created_at::text as created_at'),
            DB::raw('users.id::text as id')
        ])->whereNotIn('users.id', function($query) {
            $query->select('user_id')
                  ->from('blacklists')
                  ->whereColumn('users.id','=','blacklists.user_id');
        })->where('role_id',3)->orderBy('users.created_at','desc');
        $dt = new Datatables(new LaravelAdapter);

        $dt->query($sqlBuilder);

        $dt->edit('created_at',function($data){
            return (new Carbon($data['created_at']))->format('d/m/y H:i A');
        });

        $dt->edit('phone',function($data){
            return $data['dial_code']." ".$data['phone'];
        });

        $dt->edit('status',function($data){
            if(get_user_permission('customers','u')){
                $checked = ($data["status"]=='active')?"checked":"";
                    $html= '<label class="switch s-icons s-outline  s-outline-warning  mb-4 mr-2">
                        <input type="checkbox" data-role="active-switch"
                            data-href="'.route('customers.status_active', ['id' => encrypt($data['id'])]).'"
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
            $address_count = Address::select('id')->where('user_id',$data['id'])->get()->count();
            $html = '<div class="dropdown custom-dropdown">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink7"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <i class="flaticon-dot-three"></i>
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink7">';
                    if(get_user_permission('customers','u')){
                    $html.='<a class="dropdown-item"
                        href="'.route('customer.edit.data',['id'=>encrypt($data['id'])]).'"><i
                            class="bx bx-edit"></i> edit</a>';
                    }

                    if (get_user_permission('address', 'u')) {
                        $html .= '<a class="dropdown-item"
                                href="' . route('address.list', ['user_id' => $data['id']]) . '"><i
                                    class="flaticon-pencil-1"></i> Address ('.$address_count.')</a>';
                       }
                    
                    if (get_user_permission('customers', 'u')) {
                    $html .= '<a class="dropdown-item"
                            href="' . route('blacklists.add', ['id' => encrypt($data['id'])]) . '"><i class="fa-solid fa-user-lock"></i> BlackList</a>';
                    }

                    
                    

            $html.='</div>
            </div>';
            return $html;
        });

        return $dt->generate();
    }

    public function detailView($id=''){

        $page_heading = 'Customer';
        $mode = "Create";
        $user  = '';
        $status = '';
        $name = '';
        $phone = '';
        $email = '';
        $dial_code = '';
        $password = '';
        $permissions= [];

        if($id){

            $mode = "Detail";
            $id = decrypt($id);
            $user = User::find($id);
            $name = $user->name;
            $phone = $user->phone;
            $status = $user->status;
            $email = $user->email;
            $dial_code = $user->dial_code;
            $password = $user->password;
            


        }
        $site_modules = config('crud.site_modules');
        $operations   = config('crud.operations');
        return view('admin.customerData.insert',compact('mode','status', 'page_heading','id','user','name','email','phone','password','dial_code'));
    }

  

    public function change_status_cus(REQUEST $request,$id){
        $status = "0";
        $message = "";
        $o_data  = [];
        $errors = [];

        $id = decrypt($id);

        $item = User::where(['id' => $id])->get();
 
        if($item->count() > 0){

            User::where('id','=',$id)->update(['status'=>$request->status == '1'?'active':'inactive']);
            $status = "1";
            $message= "Status changed successfully";
        }else{
            $message = "Faild to change status";
        }

        echo json_encode(['status' => $status, 'errors' => $errors, 'message' => $message, 'oData' => $o_data]);

    }

    public function createCus(){
            $page_heading = 'Create Customer';
            $mode = "Import CSV";
        $site_modules = config('crud.site_modules');
        $operations   = config('crud.operations');
        return view('admin.customerData.create',compact('mode', 'page_heading'));

    }

   

    
    public function submitCsv(REQUEST $request){
        
        $status     = "0";
        $message    = "";
        $o_data     = [];
        $errors     = [];
        $o_data['redirect'] = route('customers.list.all');
        $rules = [
            'customer_csv' => 'required',
        ];

        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        }
        else {

            $file = $request->file('customer_csv')->store('temp');
            $path=storage_path('app').'/'.$file;  
            $data = Excel::toArray(new ProductImport, $path);
            
            
            foreach ($data[0] as $key=>$row) {
                if ($key === 0) {
                    continue;
                }
                if (User::where('email', '=', $row[1])->exists()) {
                    continue;
                }

                if (User::where('phone', '=', $row[3])->exists()) {
                    continue;
                }
              

                $customer   = new User();
                $customer->name    = $row[0];
                $customer->email  = $row[1];
                $customer->dial_code    = $row[2];
                $customer->phone    = $row[3];
                $customer->status  = 'active';
                $customer->password  = Hash::make($row[5]);
                $customer->role_id  = 3;
                $customer->email_verified_at  = Carbon::now();
                $customer->phone_verified  = 1;

                $customer->save();


                


                            $wallet = new Wallet();
                            $wallet->user_id = $customer->id;
                            $wallet->amount = 0;
                            $wallet->save();
 


            }
            


            // Insert the data into the database
           

            $status = "1";
            $message = "Customers Data Addded Successfully";    
            
        }

        echo json_encode(['status' => $status, 'errors' => $errors, 'message' => $message, 'oData' => $o_data]);
    }


    public function insert(REQUEST $request){
        
        $status     = "0";
        $message    = "";
        $o_data     = [];
        $errors     = [];
        $o_data['redirect'] = route('customers.list.all');
        $rules = [
            'customer_name' => 'required',
            'customer_email' => 'required',
            'dial_code' => 'required',
            'phone' => 'required',
            'address' => 'required',
            //'country' => 'required',
            //'city' => 'required',
            //'zip_code' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ];

        if($request->id != ''){
            $rules['password'] = 'required';     
        }


        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        }
        
        else {

            $name  = $request->customer_name;
            $email= $request->customer_email;
            $dial_code  = $request->dial_code;
            $phone= $request->phone;
            $password  = $request->password;
            $status= $request->status;
            $id         = $request->id;
            $check      = User::whereRaw('Lower(email) = ?',[strtolower($email)])->where('id','!=',$id)->get();
            
            if($check->count() > 0){
                $message = "Customer Already Addded";
                $errors['customer_name'] = 'Customer Already Addded';
            }else{
                       if($id){
                            $customer   = User::find($id);
                            $customer->name    = $name;
                            $customer->email  = $email;
                            $customer->dial_code    = $dial_code;
                            $customer->phone    = $phone;
                            if($request->password != null){
                                $customer->password  = Hash::make($password);
                            }
                            
                            $customer->address = $request->address;
                            $customer->address_2 = $request->address;
                            //$customer->country = $request->country;
                            //$customer->city = $request->city;
                            //$customer->zip_code = $request->zip_code;
                            $customer->latitude = $request->latitude;
                            $customer->longitude = $request->longitude;
                            $customer->trade_licence_number = $request->trade_licence_number;

                            $customer->role_id  = 3;
                            $customer->status  = $status;

                            $customer->save();

                            $status = "1";
                            $message = "Customer Updated Successfully";
                       }
                       else{
                            $customer   = new User();
                            $customer->name    = $name;
                            $customer->email  = $email;
                            $customer->dial_code    = $dial_code;
                            $customer->phone    = $phone;
                            $customer->password  = Hash::make($password);
                            $customer->role_id  = 3;
                            $customer->status  = $status;
                            
                            $customer->address = $request->address;
                            $customer->address_2 = $request->address;
                            //$customer->country = $request->country;
                            //$customer->city = $request->city;
                            //$customer->zip_code = $request->zip_code;
                            $customer->latitude = $request->latitude;
                            $customer->longitude = $request->longitude;
                            $customer->trade_licence_number = $request->trade_licence_number;

                            $customer->email_verified_at  = Carbon::now();
                            $customer->phone_verified  = 1;

                            $customer->save();


                            $wallet = new Wallet();
                            $wallet->user_id = $customer->id;
                            $wallet->amount = 0;
                            $wallet->save();
 
                            $status = "1";
                            $message = "Customer Addded Successfully";
                       }
                       if($request->file("trade_licence_doc") != null){
                        $response = image_upload($request,'users','trade_licence_doc');
                        
                        if($response['status']){
                            $customer->trade_licence_doc = $response['link'];
                            $customer->save();
                        }
                    }
            }
        }

        echo json_encode(['status' => $status, 'errors' => $errors, 'message' => $message, 'oData' => $o_data]);
    }
    

    public function detailShow($id){
        $page_heading = 'Customer';
        $mode = "Create";

        if($id){

            $mode = "Detail";
            $id = decrypt($id);
            $user = User::find($id);
            
        }
        $site_modules = config('crud.site_modules');
        $operations   = config('crud.operations');
        return view('admin.customerData.detail',compact('mode', 'page_heading','user'));
    }

    public function exportCsv3q()
    {

        $attr_col_start=21;
        $country = Country::pluck('dial_code')->toArray();

        

        
        $spreadsheet    = new Spreadsheet();
        $sheet1        = new Worksheet($spreadsheet, 'Customers');
        
        
        $sheet1->setCellValue('A1', 'Name');
        $sheet1->setCellValue('B1', 'Email');
        $sheet1->setCellValue('C1', 'Dial code');
        $sheet1->setCellValue('D1', 'Phone');
        $sheet1->setCellValue('E1', 'Status');
        $sheet1->setCellValue('F1', 'Password');
        
        
    
        $spreadsheet->addSheet($sheet1, 0);
       

       
        



 $sheet1->getStyle('A1:'.$sheet1->getHighestDataColumn().'1')->getFont()->setBold(true);
        $spreadsheet->setActiveSheetIndex(0);


        // PRODUCT TYPE
        $sheet1->setDataValidation(
            'C2:C1000',
            (new DataValidation())
                ->setType(DataValidation::TYPE_LIST)
                ->setErrorStyle(DataValidation::STYLE_STOP )
                ->setAllowBlank(false)
                ->setShowInputMessage(true)
                ->setShowErrorMessage(true)
                ->setShowDropDown(true)
                ->setErrorTitle('Product error')
                ->setError('Product type is not in list.')
                ->setPromptTitle('Pick from list')
                ->setFormula1(sprintf('"%s"',implode(",",$country))));
        // stock count
        $sheet1->setDataValidation(
            'D2:D1000',
            (new DataValidation())
                ->setType(DataValidation::TYPE_CUSTOM)
                ->setErrorStyle(DataValidation::STYLE_STOP )
                ->setAllowBlank(false)
                ->setShowInputMessage(true)
                ->setShowErrorMessage(true)
                ->setErrorTitle('Stock Error')
                ->setError('Value must be a number.')
                ->setPromptTitle('Invalid Value')
                ->setFormula1('=ISNUMBER(I2)')
        );
        // allow back orders
       $sheet1->setDataValidation(
            'E2:E1000',
            (new DataValidation())
                ->setType(DataValidation::TYPE_LIST)
                ->setErrorStyle(DataValidation::STYLE_STOP )
                ->setAllowBlank(false)
                ->setShowInputMessage(true)
                ->setShowErrorMessage(true)
                ->setShowDropDown(true)
                ->setErrorTitle('Vendor error')
                ->setError('Vendor is not in list.')
                ->setPromptTitle('Pick from list')
                  ->setFormula1('"Active,Inactive"')

                
        );
        
    

        $sheet1->getColumnDimension('A')->setWidth(20);
        $sheet1->getColumnDimension('B')->setWidth(20);
        $sheet1->getColumnDimension('C')->setWidth(20);
        $sheet1->getColumnDimension('D')->setWidth(20);
        $sheet1->getColumnDimension('E')->setWidth(20);
        $sheet1->getColumnDimension('F')->setWidth(20);
        
        
        

        $date = date('d-m-y-'.substr((string)microtime(), 1, 8));
$date = str_replace(".", "", $date);
$filename = "demo".$date.".xlsx";
try {
    $writer = new Xlsx($spreadsheet);
    $writer->save($filename);
    $content = file_get_contents($filename);
} catch(Exception $e) {
    exit($e->getMessage());
}

header("Content-Disposition: attachment; filename=".$filename);

unlink($filename);
exit($content);
      
       
    }

    public function exportXlsx()
    {
        $csvFile = public_path('csv/demo.xlsx');

        $headers = [
            'Content-Type' => 'text/xlsx',
            'Content-Disposition' => 'attachment; filename="demo.xlsx"',
        ];

        return Response::download($csvFile, 'demo.xlsx', $headers);
    }


    


}


