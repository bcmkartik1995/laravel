<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package_subcategory extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public $timestamps = false;
    
    protected $table = 'package_subcategories';

    public function subcategory()
    {
        return $this->belongsTo('App\SubCategory');
    }
}
