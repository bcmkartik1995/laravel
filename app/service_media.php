<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class service_media extends Model
{
    protected $fillable = [
        'service_id'
    ];
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
}
