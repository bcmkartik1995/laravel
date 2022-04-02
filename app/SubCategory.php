<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    public function category()
    {
        return $this->belongsTo('App\Category','category_id');
    }

    public function service()
    {
        return $this->hasMany('App\Service','sub_category_id');
    }

    public function booking_detail()
    {
        return $this->hasMany('App\Booking_Detail');
    }

    public function packages_subcategory()
    {
        return $this->hasMany('App\Package_subcategory','sub_category_id');
    }

    public function blog()
    {
        return $this->hasMany('App\Blog','sub_category_id');
    }
}
