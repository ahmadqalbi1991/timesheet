<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\booking_reviews;
use Validator;
use Illuminate\Support\Facades\Auth;
use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\LaravelAdapter;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ReviewsController extends Controller
{
    //
    public function index(){
        $page_heading = "Reviews";
        $mode="List";
        return view('admin.reviews.list',compact('mode', 'page_heading'));
    }

    public function getReviewList(Request $request){

        // $sqlBuilder =  DB::table('variations')

        $sqlBuilder  = booking_reviews::join('bookings','bookings.id','=','booking_reviews.booking_id')
            ->leftJoin('users','booking_reviews.updated_by','=','users.id')->select([
            DB::raw('booking_number::text as booking_id'),
            DB::raw('booking_reviews.comment::text as comment'),
            DB::raw('booking_reviews.rate::text as rate'),
            DB::raw('booking_reviews.status::text as status'),
            DB::raw('booking_reviews.created_at::text as created_at'),
            DB::raw('booking_reviews.id::text as id'),
            DB::raw('users.name::text as updated_by'),
        ])->orderBy('booking_reviews.id','desc');
        $dt = new Datatables(new LaravelAdapter);

        $dt->query($sqlBuilder);

        $dt->edit('created_at',function($data){
            return (new Carbon($data['created_at']))->format('d/m/y h:i A');
        });

        $dt->edit('status',function($data){
            $html = '';
            if($data["status"]=='pending'){
                $html = '<span class="badge badge-secondary"> Pending </span>';
            }
            elseif($data["status"]=='approve'){
                $html = '<span class="badge badge-success"> Approved </span>';
            }
            elseif($data["status"]=='disapprove'){
                $html = '<span class="badge badge-danger"> Disapproved </span>';
            }
          return $html;
        });

        $dt->edit('rate',function($data){
            $stars = '';
            $rating = $data["rate"];

            for ($i = 1; $i <= 5; $i++) {
                if ($i <= $rating) {
                    $stars .= '<i class="fa fa-star"></i>';
                } else {
                    $stars .= '<i class="fa fa-star-o"></i>';
                }
            }
            return '<div class="star-rating">'.$rating.'<div class="starts"><i class="fa fa-star"></i></div></div>';
        });


        $dt->add('action', function($data) {
            $html = '<div class="dropdown custom-dropdown">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink7"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <i class="flaticon-dot-three"></i>
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink7">';
                    if(get_user_permission('reviews','u')){
                    $html.='<a class="dropdown-item"
                        href="'.route('reviews.edit',['id'=>encrypt($data['id'])]).'"><i
                            class="flaticon-pencil-1"></i> Edit</a>';
                    }
                    
                    if(get_user_permission('reviews','d')){
                        $html.='<a class="dropdown-item" data-role="unlink"
                            data-message="Do you want to remove this review?"
                            href="'.route('reviews.delete',['id'=>encrypt($data['id'])]).'"><i
                                class="flaticon-delete-1"></i> Delete</a>';
                        }                             
                    

            $html.='</div>
            </div>';
            return $html;
        });

        return $dt->generate();
    }

    public function create($id=''){
        $page_heading = 'Reviews';
        $mode = "Create";
        $booking_id  = '';
        $driver_id= '';
        $customer_id= '';
        $rating= '';
        $comment= '';

        if($id){

            $mode = "Edit";
            $id = decrypt($id);
            $company = Company::find($id);
            $company->logo = url(Storage::url('comapny/'.$company->logo));
            $company_name = $company->name;
            $company_status = $company->status;
            $logo = $company->logo;
            $company->company_license = url(Storage::url('comapny/'.$company->company_license));
            $company_license = $company->company_license;


        }
        $site_modules = config('crud.site_modules');
        $operations   = config('crud.operations');
        return view('admin.reviews.create',compact('mode', 'page_heading','comment','id','rating','customer_id','driver_id','booking_id','operations','site_modules'));

    }


    public function edit($id){
        $id = decrypt($id);


        $review = booking_reviews::find($id);
        $id = $review->id;
        $comment = $review->comment;


          

        $rate = $review->rate;
        $booking_id = $review->booking_id;
        $status = $review->status;


        $booking_id  = booking_reviews::join('bookings','bookings.id','=','booking_reviews.booking_id')->where('booking_reviews.id',$id)->select(
            'bookings.booking_number',
        )->first();

        $booking_id = $booking_id->booking_number;





        $page_heading = 'Review Edit';
        $mode = "Detail";
        $site_modules = config('crud.site_modules');
        $operations   = config('crud.operations');
        
        return view('admin.reviews.edit',compact('id','booking_id','mode', 'page_heading','operations','site_modules','comment','rate','status'));

    }



    public function update(REQUEST $request){
        
        $status     = "0";
        $message    = "";
        $o_data     = [];
        $errors     = [];
        $o_data['redirect'] = route('reviews.list');
       
            $comment  = $request->comment;
            $rating= $request->rating;
            $id         = $request->id;
            $status         = $request->status;
           
                if($id){

                    $rules = [
                        'status' => 'required',
                    ];
            
                    $validator = Validator::make($request->all(),$rules);
            
                    if ($validator->fails()) {
                        $status = "0";
                        $message = "Validation error occured";
                        $errors = $validator->messages();
                    }
                    else {

                            $review   = booking_reviews::find($id);
                            $review->status  = $status;
                            $review->updated_by = Auth::user()->id;
                            $review->save();
                        
                        $status = "1";
                        $message = "Review Updated Successfully";
                    }
                }
        

        echo json_encode(['status' => $status, 'errors' => $errors, 'message' => $message, 'oData' => $o_data]);
    }
    


    public function submit(REQUEST $request){
       
        $status     = "0";
        $message    = "";
        $o_data     = [];
        $errors     = [];
        $o_data['redirect'] = route('reviews.list');
       
            $booking_id  = $request->booking_id;
            $driver_id= $request->driver_id;
            $customer_id  = $request->customer_id;
            $rating= $request->rating;
            $comment  = $request->comment;


                // if($id){

                //     $rules = [
                //         'company_name' => 'required',
                //     ];
            
                //     $validator = Validator::make($request->all(),$rules);
            
                //     if ($validator->fails()) {
                //         $status = "0";
                //         $message = "Validation error occured";
                //         $errors = $validator->messages();
                //     }
                //     else {

                //         if($request->file("logo") != null || $request->file("company_license") != null){
                //             $company   = Company::find($id);
                //             $company->name    = $company_name;
                //             $company->status  = $company_status;
                //                 $response = image_upload($request,'comapny','logo');
                                
                //                 if($response['status']){
                //                     $company->logo= $response['link'];
                //                 }
                                
                //             $response = image_upload($request,'comapny','company_license');
                            
                //             if($response['status']){
                //                 $company->company_license= $response['link'];
                //             }
                                
                //                 $company->save();
                //         }
                //         else{
                //             $company   = Company::find($id);
                //             $company->name    = $company_name;
                //             $company->status  = $company_status;
                //             $company->save();
                //         }

                        


                //         $status = "1";
                //         $message = "Company Updated Successfully";
                //     }
                // }else{

                    $rules = [
                        'rating' => 'required',
                        'comment' => 'required',
                    ];
            
                    $validator = Validator::make($request->all(),$rules);
            
                    if ($validator->fails()) {
                        $status = "0";
                        $message = "Validation error occured";
                        $errors = $validator->messages();
                    }
                    else {

                        $review   = new booking_reviews();
                        $review->booking_id    = $booking_id;
                        $review->driver_id  = $driver_id;
                        $review->customer_id  = $customer_id;
                        $review->rate  = $rating;
                        $review->comment  = $comment;
                        $review->save();

                        $status = "1";
                        $message = "Review Addded Successfully";
                    }

                // }
            
        echo json_encode(['status' => $status, 'errors' => $errors, 'message' => $message, 'oData' => $o_data]);
    }

   
    public function change_status(REQUEST $request,$id){
        $status = "0";
        $message = "";
        $o_data  = [];
        $errors = [];

        $id = decrypt($id);

        $item = booking_reviews::where(['id'=>$id])->get();
 
        if($item->count() > 0){

            booking_reviews::where('id','=',$id)->update(['status'=>$request->status == '1'?'active':'inactive']);
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

        $noti = booking_reviews::where(['id' => $id])->first();

        if( $noti ) {
            booking_reviews::where(['id' => $id])->delete();
            $message = "Review deleted successfully";
            $status = "1";
        }
        else {
            $message = "Invalid Review data";
        }

        echo json_encode([
            'status' => $status , 'message' => $message
        ]);
    }

    
    






}
