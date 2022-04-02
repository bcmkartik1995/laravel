<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Franchise_services extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function service()
    {
        return $this->belongsTo('App\Service', 'service_id');
    }

    public function franchise()
    {
        return $this->belongsTo('App\Franchise', 'franchise_id');
    }
}
