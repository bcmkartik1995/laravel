<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package_category extends Model
{
    use SoftDeletes;
    protected $dates = ['daleted_at'];
    public $timestamps = false;
    protected $table = 'package_categories';

    
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function package()
    {
        return $this->belongsTo('App\Package');
    }

}
