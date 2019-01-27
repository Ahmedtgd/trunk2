<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OcbcHeader extends Model
{
    protected $table = 'ocbc_header';

    /*starts relations*/

    public function ocbc_details()
    {
        return $this->hasMany('App\Models\OcbcDetail');
    }

    public function ocbc_trailer()
    {
        return $this->hasOne('App\Models\OcbcTrailer');
    }

    /*end relations*/
}
