<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Franchise_plans extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function plan()
    {
        return $this->belongsTo('App\Credit_plans', 'plan_id');
    }
}
