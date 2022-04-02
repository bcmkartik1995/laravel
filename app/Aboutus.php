<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Aboutus extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
}
