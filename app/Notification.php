<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Notification extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at','created_at'];

    protected $appends=['published'];

    // public function getPublishedAttribute(){
        
    //     return $this->attributes['created_at'];
    // }

    public function getPublishedAttribute(){
        
        return Carbon::createFromTimeStamp(strtotime($this->attributes['created_at']) )->diffForHumans();
    }

}
