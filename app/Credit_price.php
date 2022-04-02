<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Credit_price extends Model
{
    protected $table = 'credit_price';
    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
