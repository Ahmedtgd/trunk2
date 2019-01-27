<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table='company';


    public function members()
    {
        return $this->hasMany(Member::class,'company_id');
    }
}
