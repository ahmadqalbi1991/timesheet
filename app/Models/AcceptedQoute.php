<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcceptedQoute extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'booking_truck_id',
        'driver_id',
        'price',
        'hours',
        'status',
        'qouted_amount',
        'commission_amount',
        'deliver_note_doc'
    ];

    public function booking(){
        return $this->belongsTo(Booking::class);
    }

    public function driver(){
        return $this->belongsTo(User::class,'driver_id');
    }

    public function booking_truck(){
         return $this->belongsTo(BookingTruck::class,'booking_truck_id','truck_id');
    }
}
