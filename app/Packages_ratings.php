<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Packages_ratings extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    public function package()
    {
        return $this->belongsTo('App\Package','package_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function service()
    {
        return $this->belongsTo('App\Package','package_id');
    }
}
