<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerType extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['name', 'status'];


    public function users(){
        return $this->hasMany(User::class);
    }
}
