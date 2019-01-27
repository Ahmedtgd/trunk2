<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OcbcInv extends Model
{
    protected $table = 'ocbc_inv';

    /*starts relations*/

    public function ocbc_detail()
    {
        return $this->belongsTo('App\Models\OcbcDetail');
    }

    /*end relations*/
}
