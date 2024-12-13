<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function country(){
        return $this->belongsTo(Country::class,'country_id','country_id');
    }

    public function city(){
        return $this->belongsTo(City::class,'city_id','id');
    }

    public function collection_address(){
        return $this->hasMany(BookingCart::class,'collection_address','id');
    }

    public function deliver_address(){
        return $this->hasMany(BookingCart::class,'deliver_address','id');
    }

}
