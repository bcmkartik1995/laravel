<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    // protected $table = 'lead';
    protected $fillable = ['user_id','name','country_id','state_id','city_id','email','phone','skill'];

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
}
