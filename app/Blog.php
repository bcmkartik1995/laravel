<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function category()
    {
        return $this->belongsTo('App\Category','category_id');
    }

    public function sub_category()
    {
        return $this->belongsTo('App\SubCategory','sub_category_id');
    }
}
