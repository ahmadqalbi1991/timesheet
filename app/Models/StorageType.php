<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorageType extends Model
{
    use HasFactory;

    protected $fillable = ['name','status'];

    public function warehouse_detail(){
        return $this->hasMany(WarehouseDetail::class,'type_of_storage','id');
    }

    public function cart_warehouse_detail(){
        return $this->hasMany(CartWarehousingDetail::class,'type_of_storage','id');
    }
    
}
