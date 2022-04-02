<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package_service extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    protected $fillable = ['package_id','service_id'];
    public function service()
    {
        return $this->belongsTo('App\Service', 'service_id');
    }
}
