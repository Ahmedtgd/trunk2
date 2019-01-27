<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdTarget extends Model
{
    //
    protected $table="adtarget";

    public function AdControl()
    {
    	return $this->hasOne('App\Models\AdControl','adtarget_id');
    }
}
