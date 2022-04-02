<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Worker_assigned_services extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function worker()
    {
        return $this->belongsTo('App\Franchise_worker','worker_id');
    }

    public function service()
    {
        return $this->belongsTo('App\Service','service_id');
    }
    public function package()
    {
        return $this->belongsTo('App\Package','package_id');
    }

    public function franchise_order()
    {
        return $this->belongsTo('App\Franchises_order','f_order_id');
    }

    public function orders()
    {
        return $this->belongsTo('App\Orders','order_id');
    }
}
