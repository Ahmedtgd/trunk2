<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{

    protected $table = 'courier';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders(){
        return $this->hasMany('App\Models\POrder');
    }
}
