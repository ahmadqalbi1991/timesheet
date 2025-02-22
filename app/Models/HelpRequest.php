<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HelpRequest extends Model
{
   
    protected $table='help_request';
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
