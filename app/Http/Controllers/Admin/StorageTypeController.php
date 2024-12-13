<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\StorageType;
use App\Models\WarehouseDetail;
use Illuminate\Http\Request;
use Validator;
use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\LaravelAdapter;
use DB;
use Carbon\Carbon;

class StorageTypeController extends Controller
{
    /*
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {

       $page_heading = "Type of Storage";
       $datamain = StorageType::select('storage_types.*')
       ->get();
       
       return view('admin.storage_types.list', compact('page_heading', 'datamain'));
   }

   public function getstorageList(){
       
       $sqlBuilder = StorageType::select([
           DB::raw('name::text as name'),
           DB::raw('status::text as status'),
           DB::raw('created_at::text as created_at'),
           DB::raw('id::text as id'),
       ])->orderBy('storage_types.id','DESC');//
       $dt = new Datatables(new LaravelAdapter);

       $dt->query($sqlBuilder);

       $dt->edit('created_at', function ($data) {
           return (new Carbon($data['created_at']))->format('d/m/y H:i A');
       });

       $dt->edit('status',function($data){
           if(get_user_permission('storage_types','u')){
               $checked = ($data["status"]=='active')?"checked":"";
                   $html= '<label class="switch s-icons s-outline  s-outline-warning  mb-4 mr-2">
                       <input type="checkbox" data-role="active-switch"
                           data-href="'.route('storage_types.change_status', ['id' => encrypt($data['id'])]).'"
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


       $dt->add('action', function ($data) {
           $html = '<div class="dropdown custom-dropdown">
               <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink7"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                   <i class="flaticon-dot-three"></i>
               </a>

               <div class="dropdown-menu" aria-labelledby="dropdownMenuLink7">';
          
          if (get_user_permission('storage_types', 'u')) {
              $html .= '<a class="dropdown-item"
                      href="' . route('storage_types.edit', ['id' => encrypt($data['id'])]) . '"><i
                          class="flaticon-pencil-1"></i> Edit</a>';
           }
           if (get_user_permission('storage_types', 'd')) {
              $html .= '<a class="dropdown-item"
                  href="' . route('storage_types.destroy', ['id' => encrypt($data['id'])]) . '"><i
              class="bx bxs-truck"></i> Delete</a>';
           }    
           $html .= '</div>
           </div>';
           return $html;
       });

       return $dt->generate();
   }

   public function create()
   {

       $page_heading = "Storage Type Create";
       $mode = "create";
       $id = "";
       $name = "";
       $icon = "";
       $status = "1";
       $deligate_attributes = array();

       return view("admin.storage_types.create", compact('page_heading', 'mode', 'id', 'name', 'icon', 'status','deligate_attributes'));
   }


   public function store(Request $request)
   {
       $status = "0";
       $message = "";
       $o_data = [];
       $errors = [];
       $redirectUrl = '';

       $rules = [
           'name' => 'required',
       ];

       $all = $request->all();
               
       $validator = Validator::make($request->all(), $rules);
       if ($validator->fails()) {
           $status = "0";
           $message = "Validation error occured";
           $errors = $validator->messages();
       } else {
           $input = $request->all();

           $check_exist = StorageType::where(['name' => $request->name])->where('id', '!=', $request->id)->get()->toArray();
           if (empty($check_exist)) {
               $ins = [
                   'name' => $request->name,
                   'slug' => str_replace(' ','-',strtolower($request->name)),
                   'updated_at' => gmdate('Y-m-d H:i:s'),
                   'status' => $request->status,
               ];


               if ($request->id != "") {
                   $storage_type = StorageType::find($request->id);
                   $storage_type->update($ins);

                   // if(isset($all['attributes']) && count($all['attributes']) > 0){
                   //     DeligateAttribute::where('deligate_id',$deligate->id)->delete();
                   //     foreach($all['attributes'] as $attribute){

                   //         DeligateAttribute::create(
                   //             [
                   //                 'deligate_id' => $deligate->id, 
                   //                 'details' => json_encode(deligate_attribute_values($attribute)),
                   //                 'name' => $attribute
                   //             ]
                   //         );    
                   //     }
                   // }

                   $status = "1";
                   $message = "Storage Type updated succesfully";
               } else {
                   $ins['created_at'] = gmdate('Y-m-d H:i:s');
                   $storage_type = StorageType::create($ins);

                   // if(isset($all['attributes']) && count($all['attributes']) > 0){
                   //     DeligateAttribute::where('deligate_id',$deligate->id)->delete();
                   //     foreach($all['attributes'] as $attribute){
                           
                   //         DeligateAttribute::create(
                   //             [
                   //                 'deligate_id' => $deligate->id, 
                   //                 'details' => json_encode(deligate_attribute_values($attribute)),
                   //                 'name' => $attribute
                   //             ]
                   //         );       
                   //     }
                   // }
                   $status = "1";
                   $message = "Storage Type added successfully";
               }
           } else {
               $status = "0";
               $message = "Storage Type Name should be unique";
               $errors['name'] = $request->name . " already added";
           }

       }
       echo json_encode(['status' => $status, 'message' => $message, 'errors' => $errors]);
   }

   public function edit($id)
   {

       $id = decrypt($id);
       $datamain = StorageType::find($id);

       if ($datamain) {
           $page_heading = "Storage Type Edit";
           $mode = "edit";
           $id = $datamain->id;
           $name = $datamain->name;
           $status = $datamain->status;
        
       return view("admin.storage_types.create", compact('page_heading', 'mode', 'id', 'name', 'status'));
       } else {
           abort(404);
       }
   }


   public function destroy($id)
   {

       $status = "0";
       $message = "";
       $o_data = [];
       $id = decrypt($id);
       $storage_type = StorageType::find($id);
       if ($storage_type) {
          
           $bookings = WarehouseDetail::where('type_of_storage',$id)->get();
           if(count($bookings) > 0){
               $status = "0";
               $message = "Sorry you cannot remove the Storage Type, because it associated with bookings";
           }
           else{
               $storage_type->delete();
               $status = "1";
               $message = "Storage Type removed successfully";
           }
       } else {
           $message = "Sorry!.. Delete could not be deleted?";
       }

       return redirect()->back();

   }
   public function change_status(Request $request)
   {   
       $status = "0";
       $message = "";

       $id = decrypt($request->id);
       if (StorageType::where('id', $id)->update(['status' => $request->status == '1'?'active':'inactive'])) {
           $status = "1";
           $msg = "Successfully activated";
           if (!$request->status) {
               $msg = "Successfully deactivated";
           }
           $message = $msg;
       } else {
           $message = "Something went wrong";
       }
       echo json_encode(['status' => $status, 'message' => $message]);
   }
}
