<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingStatusTracking extends Model
{
    use HasFactory;
    protected $fillable = ['booking_id','status_tracking','driver_id'];

    public function booking(){
        return $this->belongsTo(Booking::class);
    }
    public function driver(){
        return $this->belongsTo(User::class,'driver_id','id');
    }
}
