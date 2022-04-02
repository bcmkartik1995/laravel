<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Role;
use Auth;
use App\Franchise;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Authenticatable
{
    use SoftDeletes;
    
    protected $dates = ['deleted_at'];

    protected $guard = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','phone','role_id','photo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role()
    {
    	return $this->belongsTo('App\Models\Role')->withDefault(function ($data) {
            foreach($data->getFillable() as $dt){
                $data[$dt] = __('Deleted');
            }
        });
    }

    public function role_title()
    {
        if(Auth::user()->role_id == 0){
            $role_title = 'superadmin';
        }else{
            $role_title = Role::where('id', Auth::user()->role_id)->pluck('name')->first();
        }
        
        return $role_title;
    }



    public function hasFranchise()
    {
        $franchise_user = Franchise::where('user_id',Auth::guard('admin')->user()->id)->first();

        $hasFranchise = false;
        if(!empty($franchise_user)){
            $hasFranchise = true;
        }
        return $hasFranchise;
    }

    public function getFranchise($user_id = null)
    {
        if(empty($user_id)){
            $user_id = Auth::guard('admin')->user()->id;
        }
        $franchise_user = Franchise::where('user_id',$user_id)->first();
        return $franchise_user;
    }


    public function IsSuper(){
        if ($this->id == 1) {
           return true;
        }
        return false;
    }

    public function sectionCheck($value){
        $sections = explode(" , ", $this->role->section);
        if (in_array($value, $sections)){
            return true;
        }else{
            return false;
        }
    }


   }
