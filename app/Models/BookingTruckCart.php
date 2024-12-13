<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingTruckCart extends Model
{
    use HasFactory;

    protected $fillable = ['booking_cart_id','truck_id','quantity','gross_weight'];

    public function truck_type(){
        return $this->belongsTo(TruckType::class,'truck_id','id');
    }
}
