<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order_Details extends Model
{
    protected $table = 'order_details';
    protected $casts = [
        'booking_details' => 'array'
    ];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }
    public function sub_category()
    {
        return $this->belongsTo('App\SubCategory');
    }
    public function serivce()
    {
        return $this->belongsTo('App\Service');
    }
    public function package()
    {
        return $this->belongsTo('App\Package');
    }
}
