<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'member';


    public function deliveryman()
    {
        return $this->hasOne(RoleUser::class,'user_id','user_id')->where('role_id',28);
    }
}
