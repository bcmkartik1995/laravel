<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $casts = [
        'sub_category_id' => 'array',
        'category_id' => 'array'
    ];

    public function package_services()
    {
        return $this->hasMany('App\Package_service', 'package_id');
    }
    public function Package_categories()
    {
        return $this->hasMany('App\Package_category', 'package_id');
    }
    public function Package_subcategories()
    {
        return $this->hasMany('App\Package_subcategory', 'package_id');
    }
    public function Package_cities()
    {
        return $this->hasMany('App\Package_cities', 'package_id');
    }
    public function packages_ratings()
    {
        return $this->hasMany('App\Packages_ratings', 'package_id');
    }
    public function package_media()
    {
        return $this->hasMany('App\package_media', 'package_id');
    }


    public function owner()
    {
        return $this->belongsTo('App\Franchise','franchises_id');
    }
}
