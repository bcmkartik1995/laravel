<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }
    public function owner()
    {
        return $this->belongsTo('App\Franchise','franchises_id');
    }
    public function sub_category()
    {
        return $this->belongsTo('App\SubCategory','sub_category_id');
    }
    protected $fillable = [
        'title', 'image', 'price','description'
    ];

    public static function serviceCount(){
        return Service::where('status','=','1')->count();
    }

    public function service_media()
    {
        return $this->hasMany('App\service_media', 'service_id');
    }
    public function services_ratings()
    {
        return $this->hasMany('App\Services_ratings', 'service_id');
    }

    public function package_service()
    {
        return $this->hasMany('App\Package_service', 'service_id');
    }

    public function best_service()
    {
        return $this->hasMany('App\Best_service', 'service_id');
    }
    
    public function request_quotes()
    {
        return $this->hasMany('App\Request_quotes', 'service_id');
    }
    public function faqs()
    {
        return $this->hasMany('App\Faq', 'service_id');
    }

    public function worker_services()
    {
        return $this->hasMany('App\Worker_service','service_id');
    }
}
