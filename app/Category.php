<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    public function subCategory()
    {
        return $this->hasMany('App\SubCategory', 'category_id');
    }

    public function packages()
    {
        return $this->hasMany('App\Package', 'category_id');
    }

    public function packages_category()
    {
        return $this->hasMany('App\Package_category', 'category_id');
    }

    public function booking_detail()
    {
        return $this->hasMany('App\Booking_Detail');
    }

    public function service()
    {
        return $this->hasMany('App\Service','category_id');
    }

    public function offer()
    {
        return $this->hasMany('App\Offer','category_id');
    }

    public function services()
    {
        return $this->hasMany('App\Booking_Detail');
    }
    
    public function blog()
    {
        return $this->hasMany('App\Blog','category_id');
    }

}
