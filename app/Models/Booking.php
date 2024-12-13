<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_collection',
        'collection_address',
        'collection_latitude',
        'collection_longitude',
        'collection_country',
        'collection_city',
        'collection_zipcode',
        'collection_phone',
        'deliver_address',
        'deliver_latitude',
        'deliver_longitude',
        'deliver_country',
        'deliver_city',
        'deliver_zipcode',
        'deliver_phone',
        'sender_id',
        'deligate_id',
        'deligate_type',
        'truck_type_id',
        'admin_response',
        'qouted_amount',
        'comission_amount',
        'customer_signature',
        'delivery_note',
        'driver_id',
        'status',
        'is_paid',
        'booking_number',
        'invoice_number',
        'total_amount',
        'shipping_method_id',
        'invoice_number',
        'date_of_commencement',
        'date_of_return',
        'shipmenttype'
    ];

    public function getStoragePictureAttribute($storage_picture){
        return $storage_picture ? asset(\Storage::url("bookings/{$storage_picture}")) : '';
        // return get_uploaded_image_url($storage_picture,'bookings','avatar.png');
    }
    public function customer(){
        return $this->belongsTo(User::class,'sender_id','id');
    }

    public function driver(){
        return $this->belongsTo(User::class,'driver_id','id');
    }

    public function booking_qoutes(){
        return $this->hasMany(BookingQoute::class);
    }

    public function booking_accepted_qoutes(){
        return $this->hasMany(AcceptedQoute::class);
    }

    public function booking_truck(){
        return $this->hasMany(BookingTruck::class);
    }

    public function booking_deligate_detail(){
        return $this->hasOne(BookingDeligateDetail::class);
    }

    public function warehouse_detail(){
        return $this->hasOne(WarehouseDetail::class);
    }

    public function booking_charges(){
        return $this->hasMany(BookingAdditionalCharge::class);
    }

    public function booking_status_trackings(){
        return $this->hasMany(BookingStatusTracking::class)->orderBy('quote_id','asc')->orderBy('statuscode','desc');
    }

    public function reviews(){
        return $this->hasOne(booking_reviews::class,'booking_id','id');
    }
    public function deligate_data(){
        return $this->hasOne(Deligate::class,'id','deligate_id');
    }
}
