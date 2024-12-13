<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingTruck extends Model
{
    use HasFactory;

    protected $fillable = ['booking_id','truck_id','quantity','gross_weight'];

    public function booking(){
        return $this->belongsTo(Booking::class);
    }

    public function truck_type(){
        return $this->belongsTo(TruckType::class,'truck_id','id');
    }
    public function container(){
        return $this->belongsTo(Container::class,'truck_id','id');
    }

    public function booking_truck_alot(){
        return $this->hasMany(BookingTruckAlot::class);
    }

    public function booking_truck_qoutes(){
        return $this->hasMany(BookingQoute::class);
    }

    public function booking_truck_accepted_qoutes(){
        return $this->hasMany(AcceptedQoute::class);
    }

}
