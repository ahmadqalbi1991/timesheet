<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationUser extends Model
{
    use HasFactory;

    public function notification(){
        return $this->belongsTo(NewNotification::class, 'notification_id','id');
    }
}
