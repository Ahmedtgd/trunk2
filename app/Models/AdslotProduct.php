<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdslotProduct extends Model
{
    protected $table = 'adslotproduct';

    public function hits()
    {
        return $this->hasOne('App\Models\AdslotProductHit','adslotproduct_id');
    }

}
