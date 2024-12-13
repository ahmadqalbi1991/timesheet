<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $table='companies';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'logo',
        'status',
        'created_at',
        'updated_at',
    ];

    public function getLogoAttribute($logo){
        return get_uploaded_image_url($logo,'company_image_upload_dir');
    }

    public function company(){
        return $this->belongsTo(User::class,'user_id','id');
    }

}
