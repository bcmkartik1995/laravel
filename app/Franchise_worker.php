<?php

namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Franchise_worker extends Authenticatable
{
    protected $guard = 'worker';

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'email', 'password','mobile','photo'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function franchise()
    {
        return $this->belongsTo('App\Franchise','franchises_id');
    }

    public function worker_service()
    {
        return $this->hasMany('App\Worker_service','worker_id');
    }
}
