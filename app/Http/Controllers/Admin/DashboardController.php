<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company;
use DB;
use App\Models\Booking;
use Carbon\Carbon;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $page_heading = "Dashboard";
        
        $customerData = User::where('role_id',3)->count();
        $driverData =  User::where('role_id',2)->count();
        $companyData = User::join('companies','companies.user_id','=','users.id')->where('role_id',4)->count();
        $bookingData = DB::table('bookings')->count();

        $bookings = DB::table('bookings')
                    ->select(DB::raw('created_at as month'), DB::raw('COUNT(*) as count'))
                    ->groupBy('month')
                    ->orderBy('created_at','asc')
                    ->get();
        $customerss = DB::table('users')->where('role_id' , 3)->orderBy('id','DESC')->take(7)->get();

        $roles = DB::table('roles')->count();

        $customersss = DB::table('users')->where('role_id' , 3)
                    ->select(DB::raw('created_at as month'), DB::raw('COUNT(*) as count'))
                    ->groupBy('month')
                    ->orderBy('created_at','asc')
                    ->get();

        
        return view('admin.dashboard', compact('page_heading','customerData','customersss','driverData','bookings','bookingData','customerss','roles','companyData'));
    }
}
