<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Worker_service extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function services()
    {
        return $this->belongsTo('App\Service','service_id');
    }
}
