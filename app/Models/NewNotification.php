<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewNotification extends Model
{
    protected $table='notifications';
    protected $primaryKey = 'id';
    use HasFactory;

    public function users(){
        return $this->hasMany(NotificationUser::class, 'notification_id','id');
    }
}
