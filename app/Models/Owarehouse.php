<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Owarehouse extends Model
{
    protected $table='owarehouse';

    /*occupation has only one user 1:1*/
    public function pledges()
    {
        return $this->hasMany('App\Models\Owarehouse_pledge','owarehouse_id','id');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product','product_id','id');
    }
}
