<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingCart extends Model
{
    use HasFactory;

    protected $fillable = ['is_collection','collection_address','deliver_address','sender_id','deligate_id','deligate_type','device_cart_id','booking_number','shipmenttype'];
    

    public function collection_address_book(){
        return $this->belongsTo(Address::class,'collection_address','id');
    }

    public function deliver_address_book(){
        return $this->belongsTo(Address::class,'deliver_address','id');
    }

    public function cart_deligate_detail(){
        return $this->hasOne(CartDeligateDetail::class,'booking_cart_id','id');
    }

    public function cart_warehouse_detail(){
        return $this->hasOne(CartWarehousingDetail::class,'booking_cart_id','id');
    }
}
