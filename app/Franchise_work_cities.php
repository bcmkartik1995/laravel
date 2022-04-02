<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Franchise_work_cities extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function city()
    {
        return $this->belongsTo('App\City', 'city_id');
    }
}
