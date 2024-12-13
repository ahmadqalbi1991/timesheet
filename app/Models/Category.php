<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Category extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = "categories";
    protected $primaryKey = "category_id";

    public $hidden = ['created_at','deleted_at','updated_at'];

    protected $fillable = [
        'category_id',
        'category_name',
        'unique_category_code',
        'unique_category_text',
        'category_image',
        'category_icon',
        'created_by',
        'category_status',
        'created_at',
        'updated_at',
        'deleted_at',
        'parent_category_id'
    ];

    public $appends = ['processed_category_image','processed_category_icon'];

    // protected $casts = [
    //     'created_at' => 'date_format:d/m/yyyy',
    // ];
    public function children()
    {
        return $this->hasMany('App\Models\Category', 'parent_category_id', 'category_id');
    }
    public function parent()
    {
        return $this->belongsTo('App\Models\Category', 'parent_category_id');
    }

    public function getProcessedCategoryImageAttribute(){
        return get_uploaded_image_url($this->category_image,'category_image_upload_dir');
    }
    public function getProcessedCategoryIconAttribute(){
        return get_uploaded_image_url($this->category_icon,'category_image_upload_dir');
    }
    public function setDateAttribute( $value ) {
        $this->attributes['created_at'] = (new Carbon($value))->format('d/m/y H:i:s');
        $this->attributes['updated_at'] = (new Carbon($value))->format('d/m/y H:i:s');
    }
}
