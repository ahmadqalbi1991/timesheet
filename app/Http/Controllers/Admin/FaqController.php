<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\LaravelAdapter;
use App\Models\Faq;

class FaqController extends Controller
{
    public function index(){
        $page_heading = "Faqs";
        $mode="List";
        return view('admin.faq.list',compact('mode','page_heading'));
    }

    public function create($id=''){
        $page_heading = 'Pages';
        $mode="Create";
        $cms_page = new Faq();

        if($id){
            $mode= "Edit";
            $id = decrypt($id);
            $cms_page = Faq::find($id);
        }
        

        return view('admin.faq.create',compact('mode','page_heading','id',
            'cms_page'));

    }

    public function submit(REQUEST $request){
        $status     = "0";
        $message    = "";
        $o_data     = [];
        $errors     = [];
        $o_data['redirect'] = route('cms.pages.list');
        $rules = [
            'title' => 'required',
            'description' => 'required',
            
            'status' => 'required'
        ];

        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        }
        else {
            $id         = $request->id;
            
                if($id){
                    DB::beginTransaction();
                    try{
                        $cms_page   = Faq::find($id);
                        $cms_page->title    = $request->title;
                        $cms_page->description  = $request->description;
                        $cms_page->usertype = $request->usertype;
                        $cms_page->active       = $request->status;
                        $cms_page->save();

                        DB::commit();
                        $status = "1";
                        $message = "Faq updated Successfully";

                    }catch(EXCEPTION $e){
                        DB::rollback();
                        $message = "Faild to update language ".$e->getMessage();
                    }
                }else{
                    DB::beginTransaction();
                    try{
                        $cms_page   = new Faq();
                        $cms_page->title    = $request->title;
                        $cms_page->description  = $request->description;
                        $cms_page->usertype = $request->usertype;
                        $cms_page->active       = $request->status;
                        $cms_page->save();

                        DB::commit();
                        $status = "1";
                        $message = "Faq Added Successfully";

                    }catch(EXCEPTION $e){
                        DB::rollback();
                        $message = "Failed to create page ".$e->getMessage();
                    }
                }
           
        }

        echo json_encode(['status' => $status, 'errors' => $errors, 'message' => $message, 'oData' => $o_data]);
    }

    public function getPagesList(Request $request){

        // $sqlBuilder =  DB::table('variations')

        $sqlBuilder = Faq::select([
            DB::raw('title::text as title'),
            DB::raw('usertype::text as usertype'),
            DB::raw('description::text as description'),
            DB::raw('created_at::text as created_at'),
            DB::raw('id::text as id'),
            DB::raw('active::integer as status')
        ]);
        $dt = new Datatables(new LaravelAdapter);

        $dt->query($sqlBuilder);

       
        $dt->add('usertype',function($data){
            if($data['usertype'] == 3)
                return 'Customer';
            else if($data['usertype'] == 2)
                return 'Driver';
            else 
                return 'All';
        });

        $dt->add('created_at',function($data){
            return (new Carbon($data['created_at']))->format('d/m/y H:i A');
        });

        $dt->edit('status',function($data){
            $checked = ($data["status"]==1)?"checked":"";
            $html = '';
            if(get_user_permission('pages','u')){
            $html= '<label class="switch s-icons s-outline  s-outline-warning  mb-4 mr-2">
                <input type="checkbox" data-role="active-switch"
                    data-href="'.route('cms.faq.status_change', ['id' => encrypt($data['id'])]).'"
                    '.$checked.' >
                <span class="slider round"></span>
            </label>';
            }else{
                $checked = ($data["status"]==1)?"Active":"Inactive";
                $color = ($data["status"]==1)?"success":"secondary";
                $html = '<span class = "badge badge-'.$color.'">'.$checked.'</span>';
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
            if(get_user_permission('pages','u')){
                $html.='<a class="dropdown-item"
                        href="'.route('cms.faq.edit',['id'=>encrypt($data['id'])]).'"><i
                            class="flaticon-pencil-1"></i> Edit</a>';
            }
            if(get_user_permission('pages','d')){
                $html.='<a class="dropdown-item" data-role="unlink"
                        data-message="Do you want to remove this record?"
                        href="'.route('cms.faq.delete',['id'=>encrypt($data['id'])]).'"><i
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

        $item = Faq::where(['id'=>$id])->get();
        if($item->count() > 0){
            $item=$item->first();
            $item->active = $request->status;
            $item->save();
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

        $category_data = Faq::where(['id' => $id])->first();

        if( $category_data ) {
            Page::where(['id' => $id])->delete();
            $message = "Page deleted successfully";
            $status = "1";
        }
        else {
            $message = "Invalid page identifier";
        }

        echo json_encode([
            'status' => $status , 'message' => $message
        ]);
    }
   

}
