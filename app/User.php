<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Auth;
use Faker\Provider\Uuid;
use Illuminate\Support\Facades\Validator;
// use Uuid;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use HasApiTokens;
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','phone','country','state','city','photo','zip','address',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function get_user_referral_code(){

        $referral_id = Auth::user()->referral_id;
        if(empty($referral_id)){
            $referral_id = $this->genUserCode();
        }
        return $referral_id;
    }

    private function genUserCode(){
        $this->referral_id = [
            'referral_id' => $this->random_strings(6)
        ];

        $rules = ['referral_id' => 'unique:users'];
        $validate = Validator::make($this->referral_id, $rules)->passes();

        return $validate ? $this->referral_id['referral_id'] : $this->genUserCode();
    }

    public function user_city()
    {
        return $this->belongsTo('App\City', 'city');
    }

    private function random_strings($length_of_string)  { 
        $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz'; 
        return substr(str_shuffle($str_result), 0, $length_of_string); 
    } 

}
