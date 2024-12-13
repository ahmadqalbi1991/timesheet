<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TruckType extends Model
{
    use HasFactory;

    protected $fillable = ['truck_type','dimensions','type','icon','status','max_weight_in_tons','is_container'];

    public function getIconAttribute($icon){
        return get_uploaded_image_url($icon,'truct_type_upload_dir','placeholder.png' );
    }

    public function bookings(){
        return $this->hasMany(Booking::class);
    }

    public function driver(){
        return $this->hasMany(DriverDetail::class);
    }

    public function booking_cart_truck(){
        return $this->hasMany(BookingTruckCart::class,'truck_id','id');
    }

    public function booking_truck(){
        return $this->hasMany(BookingCart::class,'truck_id','id');
    }

}
