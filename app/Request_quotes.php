<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Request_quotes extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    public function requested_service()
    {
        return $this->belongsTo('App\Service', 'service_id');
    }
}
