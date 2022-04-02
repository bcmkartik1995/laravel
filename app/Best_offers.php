<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Best_offers extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function offer()
    {
        return $this->belongsTo('App\Offer','offer_id');
    }
}
