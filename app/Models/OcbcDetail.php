<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OcbcDetail extends Model
{
    protected $table = 'ocbc_detail';

    public function ocbc_header()
    {
        return $this->belongsTo('App\Models\OcbcHeader');
    }

    public function ocbc_invs()
    {
        return $this->hasMany('App\Models\OcbcInv');
    }
}
