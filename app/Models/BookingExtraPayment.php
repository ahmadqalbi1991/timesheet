<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingExtraPayment extends Model
{
    protected $table='booking_extra_charges';
    protected $primaryKey = 'id';
}