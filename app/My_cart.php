<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class My_cart extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $casts = [
        'cart_data' => 'array'
    ];
}
