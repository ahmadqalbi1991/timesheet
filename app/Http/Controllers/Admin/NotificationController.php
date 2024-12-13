<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use Validator;
use Illuminate\Support\Facades\Auth;
use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\LaravelAdapter;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Notifications;
use App\Models\NotificationUser;
use Kreait\Firebase\Contract\Database;


class NotificationController extends Controller
{
    //
         public function __construct(Database $database)
        {
           $this->database = $database;
        }
        public function index(){
            $page_heading = "Notifications";
            $mode="List";
            return view('admin.notificaiton.list',compact('mode', 'page_heading'));
        }

        public function getNotiList(Request $request){


            $sqlBuilder = Notifications::select([
               
                DB::raw('title::text as title'),
                DB::raw('description::text as customer_desc'),
                DB::raw('notifications.status::text as status'),
                DB::raw('notifications.created_at::text as created_at'),
                DB::raw('notifications.id::text as id')
            ])->distinct('title');
            $dt = new Datatables(new LaravelAdapter);
    
            $dt->query($sqlBuilder);
    
            $dt->edit('created_at',function($data){
                return (new Carbon($data['created_at']))->format('d/m/y H:i A');
            });


            $dt->edit('status',function($data){
                if(get_user_permission('notifications','u')){
                    $checked = ($data["status"]=='active')?"checked":"";
                        $html= '<label class="switch s-icons s-outline  s-outline-warning  mb-4 mr-2">
                            <input type="checkbox" data-role="active-switch"
                                data-href="'.route('notification.status_change', ['id' => encrypt($data['id'])]).'"
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
    

            $dt->edit('customer_desc',function($data){
                $desciption = substr($data['customer_desc'],0,50).'...!';
                return $desciption;
            });
    
    
            $dt->add('action', function($data) {
                $html = '<div class="dropdown custom-dropdown">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink7"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <i class="flaticon-dot-three"></i>
                    </a>
    
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink7">';
                        if(get_user_permission('notifications','u')){
                        $html.='<a class="dropdown-item"
                            href="'.route('notification.edit',['id'=>encrypt($data['id'])]).'"><i
                                class="flaticon-pencil-1"></i> Edit</a>';
                        }
                        
                        if(get_user_permission('notifications','d')){
                            $html.='<a class="dropdown-item" data-role="unlink"
                                data-message="Do you want to remove this notification?"
                                href="'.route('notification.delete',['id'=>encrypt($data['id'])]).'"><i
                                    class="flaticon-delete-1"></i> Delete</a>';
                            }                             
                        
    
                $html.='</div>
                </div>';
                return $html;
            });
    
            return $dt->generate();
            
        }

        public function create($id=''){
            $page_heading = 'Notification Create';
            $mode = "Create";
            $site_modules = config('crud.site_modules');
            $operations   = config('crud.operations');

            
            $users = User::whereIn('role_id',[2,3,4])->get();

            return view('admin.notificaiton.create',compact('mode', 'page_heading','operations','site_modules','users'));
    
        }


        public function edit($id){
            $id = decrypt($id);

            $noti = Notifications::find($id);

            $noti->image = url(Storage::url('notificaiton/'.$noti->image));
            $id = $noti->id;
            $title = $noti->title;
            $desc = $noti->description;
            $image = $noti->image;
            $status = $noti->status;
            
            $user_ids = [];
            if(count($noti->users->pluck('user_id')) > 0){
               $user_ids = $noti->users->pluck('user_id')->toArray();
            }
            $users = User::whereIn('id',$user_ids)->paginate(8);
            

            $page_heading = 'Notification Edit';
            $mode = "Detail";
            $site_modules = config('crud.site_modules');
            $operations   = config('crud.operations');

            return view('admin.notificaiton.edit',compact('id','mode', 'page_heading','operations','site_modules','title','desc','image','status','users'));
    
        }


        public function submit(REQUEST $request){
        
            $status     = "0";
            $message    = "";
            $o_data     = [];
            $errors     = [];
            $o_data['redirect'] = route('notification.list');
            $rules = [
                'title' => 'required',
                'desc' => 'required',
                'status' => 'required',
                
            ];
    
            $validator = Validator::make($request->all(),$rules);
    
            if ($validator->fails()) {
                $status = "0";
                $message = "Validation error occured";
                $errors = $validator->messages();
            }
            else {
    
                    
                        $noti = new Notifications();
                        //$noti->user_id = 0;
                        $noti->title = $request->title;
                        $noti->status = $request->status;
                        $noti->description = $request->desc;
                        if($request->file("image"))
                        {
                            $response = image_upload($request,'notificaiton','image');
                                
                            if($response['status']){
                                $noti->image= $response['link'];
                            }
                        }
                        
                        
                        $noti->save();
                        if(!empty($noti)){
                            foreach($request->options as $user_id){
                                $user = new NotificationUser();
                                $user->notification_id = $noti->id;
                                $user->user_id = $user_id;
                                $user->save();
                            }
                        }
                        
                        $image = "";
                        $notification_data1 = Notifications::find($noti->id); 
                        if(!empty($notification_data1->image))
                        {
                         $image = url(Storage::url('notificaiton/'.$notification_data1->image));
                        }
                        

                        $title = $request->title;
            $notification_id = time();
            $description = $request->desc;
            $ntype = 'public-notification';

            foreach($request->options as $user_id)
            {
                $customer = User::find($user_id);
                if(!empty($customer->firebase_user_key))
                {
                    if($ntype != ''){
                   
                        if (!empty($customer->firebase_user_key)) {
                            $notification_data["Nottifications/" . $customer->firebase_user_key . "/" . $notification_id] = [
                                "title" => $title,
                                "description" => $description,
                                "notificationType" => $ntype,
                                "createdAt" => gmdate("d-m-Y H:i:s", $notification_id),
                                "url" => "",
                                "imageURL" => (string) $image,
                                "read" => "0",
                                "seen" => "0",
                            ];
                            
                            $this->database->getReference()->update($notification_data);
                        }
        
                        if (!empty($customer->user_device_token)) {
                            send_single_notification($customer->user_device_token, [
                                "title" => $title,
                                "body" => $description,
                                "icon" => 'myicon',
                                "sound" => 'default',
                                "click_action" => "EcomNotification"],
                                ["type" => $ntype,
                                    "notificationID" => $notification_id,
                                    "imageURL" => $image,
                                ]);
                        }
                    }
                }
                
            }
            



                $status = "1";
                $message = "Notification Sent Successfully";
    
        }
            echo json_encode(['status' => $status, 'errors' => $errors, 'message' => $message, 'oData' => $o_data]);
    }

    public function getListUser(Request $request){
        $option = $request->option;
        if($option == 0){

            $output  = "";
            $datas = User::whereIn('role_id',['2','3','4'])->get();
    
            foreach($datas as $data){

                $output .= 
                    "<tr>
                        <td> " .
                            "<span class='custom-checkbox'>"
                                . "<input type='checkbox' id='checkbox1' class='select-customers' name='options[]' value='$data->id'> 
                            </span> 
                        </td>



                        <td> " . $data->name . "</td>
                        <td> " . $data->email . "</td>
                    </tr>";
            }
        }else{

            $output  = "";
            $datas = User::where('role_id' , $request->option);
            if($request->option == 2)
            {
                $datas = $datas->where('phone_verified',1);    
            }
            $datas = $datas->get();
    
            foreach($datas as $data){
                $output .= 
                    "<tr>
                        <td> " .
                            "<span class='custom-checkbox'>"
                                . "<input type='checkbox' id='checkbox1' class='select-customers' name='options[]' value=' $data->id '> 
                            </span> 
                        </td>

                        <td> " . $data->name . "</td>
                        <td> " . $data->email . "</td>
                    </tr>";
            }
        }
        
        return response($output);
        
    }

    public function getSearchUser(Request $request){
        $option = $request->option; 
        $search = $request->search;
        if($option == 0){

            $output  = "";
            $datas = User::where('name', 'like', '%'.$search.'%')->get();
    
            foreach($datas as $data){

                $output .= 
                    "<tr>
                        <td> " .
                            "<span class='custom-checkbox'>"
                                . "<input type='checkbox' id='checkbox1' name='options[]' value='$data->id'> 
                            </span> 
                        </td>



                        <td> " . $data->name . "</td>
                        <td> " . $data->email . "</td>
                    </tr>";
            }
        }else{

            $output  = "";
            $datas = User::where('name', 'like', '%'.$search.'%')->where('role_id' , $request->option)->get();
    
            foreach($datas as $data){
                $output .= 
                    "<tr>
                        <td> " .
                            "<span class='custom-checkbox'>"
                                . "<input type='checkbox' id='checkbox1' name='options[]' value=' $data->id '> 
                            </span> 
                        </td>

                        <td> " . $data->name . "</td>
                        <td> " . $data->email . "</td>
                    </tr>";
            }
        }
        
        return response($output);
        
    }


    public function update(REQUEST $request){
        
        $status     = "0";
        $message    = "";
        $o_data     = [];
        $errors     = [];
        $o_data['redirect'] = route('notification.list');
       
            $title  = $request->title;
            $desc= $request->desc;
            $id         = $request->id;
            $status         = $request->status;
            $image         = $request->image;
           
                if($id){

                    $rules = [
                        'title' => 'required',
                        'desc' => 'required',
                        'status' => 'required',
                    ];
            
                    $validator = Validator::make($request->all(),$rules);
            
                    if ($validator->fails()) {
                        $status = "0";
                        $message = "Validation error occured";
                        $errors = $validator->messages();
                    }
                    else {

                        if($request->file("image") != null ){
                            $noti   = Notifications::find($id);
                            $noti->title    = $title;
                            $noti->description  = $desc;
                            $noti->status  = $status;

                                $response = image_upload($request,'notificaiton','image');
                                
                                if($response['status']){
                                    $noti->image= $response['link'];
                                }
                                
                                $noti->save();
                        }
                        else{
                            $noti   = Notifications::find($id);
                            $noti->title    = $title;
                            $noti->description  = $desc;
                            $noti->status  = $status;
                            $noti->save();
                        }

                        


                        $status = "1";
                        $message = "Notification Updated Successfully";
                    }
                }
        

        echo json_encode(['status' => $status, 'errors' => $errors, 'message' => $message, 'oData' => $o_data]);
    }
    
    
    public function change_status(REQUEST $request,$id){
        $status = "0";
        $message = "";
        $o_data  = [];
        $errors = [];

        $id = decrypt($id);

        $item = Notifications::where(['id'=>$id])->get();
 
        if($item->count() > 0){

            Notifications::where('id','=',$id)->update(['status'=>$request->status == '1'?'active':'inactive']);
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

        $noti = Notifications::where(['id' => $id])->first();

        if( $noti ) {
            Notifications::where(['id' => $id])->delete();
            NotificationUser::where('notification_id',$id)->delete();
            $message = "Notification deleted successfully";
            $status = "1";
        }
        else {
            $message = "Invalid Notification data";
        }

        echo json_encode([
            'status' => $status , 'message' => $message
        ]);
    }
}
