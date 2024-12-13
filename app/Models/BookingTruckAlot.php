<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingTruckAlot extends Model
{
    use HasFactory;

    protected $fillable = ['booking_truck_id','user_id','role_id'];

    public function booking_truck(){
        return $this->belongsTo(BookingTruck::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
