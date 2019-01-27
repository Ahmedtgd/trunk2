<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Descimage extends Model
{
    protected $table = 'descimage';

    public function merchant()
    {
        return $this->belongsTo('App\Models\Merchant');
    }
}
