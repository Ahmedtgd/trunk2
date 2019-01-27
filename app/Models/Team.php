<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'team';

    public function merchant()
    {
        return $this->belongsTo('App\Models\Merchant');
    }
}
