<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseDetail extends Model
{
    use HasFactory;
    protected $table = 'warehousing_details';
    
    public function booking(){
        return $this->belongsTo(Booking::class);
    }

    public function storage_type(){
        return $this->belongsTo(StorageType::class,'type_of_storage','id');
    }

    public function getWeightPerPalletAttribute($weight_per_pallet){
        if(isset($weight_per_pallet)){
            return $weight_per_pallet."Kg";
        }else{
            return "";
        }        
    }

    public function getTotalWeightAttribute($total_weight){
        if(isset($total_weight)){
            return $total_weight."Kg";
        }else{
            return "";
        }
    }
}
