<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartWarehousingDetail extends Model
{
    use HasFactory;

    protected $fillable = ['item','booking_cart_id','type_of_storage','items_are_stockable','no_of_pallets','pallet_dimension','weight_per_pallet','total_weight','total_item_cost','date_of_commencement','date_of_return'];

    public function booking_cart(){
        return $this->belongsTo(BookingCart::class);
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
