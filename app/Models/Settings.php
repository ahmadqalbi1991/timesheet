<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Settings extends Model
{
   
    protected $table='settings';

    protected $primaryKey = 'id';
    protected $fillable = ['contact_number','whatsapp_number'];

    
}
