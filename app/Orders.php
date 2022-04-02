<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orders extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $casts = [
        'cart' => 'array','unallocated' => 'array'
    ];
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function franchise_orders()
    {
        return $this->hasMany('App\Franchises_order', 'orders_id');
    }

    public function order_review()
    {
        return $this->hasMany('App\Order_review', 'order_id');
    }

    public function worker_orders()
    {
        return $this->hasMany('App\Worker_assigned_services', 'order_id');
    }
}
