<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class RoleUser extends Model
{
    protected $table = 'role_users';
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    protected $fillable = array('user_id', 'role_id', 'company_id');

    public function user_role(){
       return $this->hasOne('App\Models\Role','id','role_id');
    }
    public function users(){
       return $this->hasOne('App\Models\User','id','user_id');
    }
    
    

}
