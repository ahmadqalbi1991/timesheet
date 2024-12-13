<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartDeligateDetail extends Model
{
    use HasFactory;

    protected $fillable = ['item','booking_cart_id','no_of_packages','dimension_of_each_package','weight_of_each_package','total_gross_weight','total_volume_in_cbm','num_of_pallets'];

    public function booking_cart(){
        return $this->belongsTo(BookingCart::class);
    }

    public function getWeightOfEachPackageAttribute($weight_of_each_package){
        if(isset($weight_of_each_package)){
            return $weight_of_each_package."Kg";
        }else{
            return "";
        }
        
    }

    public function getTotalGrossWeightAttribute($total_gross_weight){
        if(isset($total_gross_weight)){
            return $total_gross_weight."Kg";
        }else{
            return "";
        }
        
    }
}
