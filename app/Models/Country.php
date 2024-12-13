<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $table='countries';
    protected $primaryKey = 'country_id';

    public function addresses(){
        return $this->hasMany(Address::class,'country_id','country_id');
    }
}
