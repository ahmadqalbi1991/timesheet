<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Container extends Model
{
    use HasFactory;

    protected $fillable = ['name','dimensions','type','icon','status','max_weight_in_metric_tons'];

    public function getIconAttribute($icon){
        return get_uploaded_image_url($icon,'containers_upload_dir');
    }

    public function bookings(){
        return $this->hasMany(Booking::class);
    }
}
