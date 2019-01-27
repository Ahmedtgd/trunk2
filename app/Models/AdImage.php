<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdImage extends Model
{
    //
    protected $table="adimage";

    /**
     * Get the adcontrol that owns the adimage
     */
    public function adcontrol()
    {
        return $this->belongsTo('App\Models\AdControl','adcontrol_id','id');
    }

     /**
     * Get the categoryadimage record associated with the adimage.
     */
    public function categoryadimage()
    {
        return $this->hasOne('App\Models\Categoryadimage','adimage_id','id');
    }
}
