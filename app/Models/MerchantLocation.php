<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerchantLocation extends Model
{
    protected $table ="merchantlocation";

    
    public function fair_location()
    {
        return $this->belongsTo('App\Models\Fairlocation','location_id','id');
    }
}
