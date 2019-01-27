<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OcbcTrailer extends Model
{
    protected $table = 'ocbc_trailer';

    /*starts relations*/

    public function ocbc_header()
    {
        return $this->belongsTo('App\Models\OcbcHeader');
    }

    /*end relations*/
}
