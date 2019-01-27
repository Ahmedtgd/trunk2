<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adslot extends Model
{
    protected  $table = 'adslot';

    public function products()
    {
        return $this->belongsToMany('App\Models\Product','adslotproduct','adslot_id','product_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
}
