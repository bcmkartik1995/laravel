<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Franchise extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function frenchise_orders()
    {
        return $this->hasMany('App\Franchises_order', 'franchises_id');
    }

    public static function franchiseCount(){

        return Franchise::where('status','=','1')->count();
    }

    public function country()
    {
        return $this->belongsTo('App\Country','country_id');
    }
    public function state()
    {
        return $this->belongsTo('App\State','state_id');
    }
    public function city()
    {
        return $this->belongsTo('App\City','city_id');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\Admin','user_id');
    }

    public function franchise_categories()
    {
        return $this->hasMany('App\Franchise_categories', 'franchises_id'); //removable
    }

    public function payments()
    {
        return $this->hasMany('App\Payments', 'franchise_id');
    }

    public function franchise_worker()
    {
        return $this->hasMany('App\Franchise_worker', 'franchises_id');
    }

    public function franchise_work_cities()
    {
        return $this->hasMany('App\Franchise_work_cities', 'franchise_id');
    }

    public function franchise_services()
    {
        return $this->hasMany('App\Franchise_services', 'franchise_id');
    }
    public function franchise_workers()
    {
        return $this->hasMany('App\Franchise_worker', 'franchises_id');
    }
    public function franchise_timings()
    {
        return $this->hasMany('App\Franchise_timing', 'franchises_id');
    }
    public function franchise_offday()
    {
        return $this->hasMany('App\Franchise_offday', 'franchises_id');
    }



}
