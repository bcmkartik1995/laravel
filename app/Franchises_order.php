<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Franchises_order extends Model
{

    protected $casts = [
        'order_details' => 'array'
    ];

    
    public function f_order()
    {
        return $this->belongsTo('App\Orders', 'orders_id');
    }

    public function franchise()
    {
        return $this->belongsTo('App\Franchise', 'franchises_id');
    }

    public function worker_orders()
    {
        return $this->hasMany('App\Worker_assigned_services', 'f_order_id');
    }

    public function extra_payments()
    {
        return $this->hasMany('App\Extra_payment', 'f_order_id');
    }


}
