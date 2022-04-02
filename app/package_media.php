<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class package_media extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
