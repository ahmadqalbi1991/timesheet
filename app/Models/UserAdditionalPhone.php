<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAdditionalPhone extends Model
{
    use HasFactory;
    protected $table='user_additional_phone';
    protected $primaryKey = 'id';
}
