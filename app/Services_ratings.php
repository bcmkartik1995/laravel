<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Services_ratings extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    public function service()
    {
        return $this->belongsTo('App\Service');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
