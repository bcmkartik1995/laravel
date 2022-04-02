<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payments extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = ['franchise_id', 'type', 'amount', 'payment_date','created_by','status','remarks'];

    public function franchise()
    {
        return $this->belongsTo('App\Franchise','franchise_id');
    }
}
