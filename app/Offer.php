<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    public function user_offer()
    {
        return $this->hasOne('App\Offer_user', 'offer_id');
    }

    public function owner()
    {
        return $this->belongsTo('App\Franchise','franchises_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function best_offer()
    {
        return $this->hasMany('App\Best_offers', 'offer_id');
    }
}
