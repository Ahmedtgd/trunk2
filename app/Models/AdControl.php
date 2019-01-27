<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdControl extends Model
{
    //
    protected $table="adcontrol";

    public function AdImages()
    {
    	return $this->hasMany('App\Models\AdImage','adcontrol_id');
    }

    /**
     * Get the adtarget that owns the adcontrol
     */
    public function adtarget()
    {
        return $this->belongsTo('App\Models\AdTarget','adtarget_id','id');
    }
}
