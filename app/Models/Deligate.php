<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deligate extends Model
{
    use HasFactory;
    protected $table = "deligates";
    protected $primaryKey = "id";

    const Trucking = 1;
    const Air_Freight = 2;
    const Sea_Freight = 3;
    const Warehousing = 4;


    protected $fillable = ['name','icon','slug','status'];

    public function getIconAttribute($icon){

        return get_uploaded_image_url( $icon, 'deligates_upload_dir', 'placeholder.png' );
        
    }

    public function deligate_attributes(){
        return $this->hasMany(DeligateAttribute::class);
    }

}
